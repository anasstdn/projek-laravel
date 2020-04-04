<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Datatables;
use App\Traits\ActivityTraits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ActivityTraits;

    public $viewDir = "barang";
    public $breadcrumbs = array(
       'permissions'=>array('title'=>'Agama','link'=>"#",'active'=>false,'display'=>true),
   );

    protected function view($view, $data = [])
    {
       return view($this->viewDir.".".$view, $data);
   }

   public function __construct()
   {
       $this->middleware('auth');
       $this->middleware('permission:read-barang');
       // $this->middleware('permission:create-barang', ['only' => ['create','sendData']]);
       // $this->middleware('permission:edit-barang', ['only' => ['edit','sendData']]);
       // $this->middleware('permission:delete-barang', ['only' => ['destroy']]);
   }

    public function index()
    {
        //
        $this->menuAccess(\Auth::user(),'Barang');
        $data = Barang::select(\DB::raw('barang.*,barang_golongan.barang_golongan,satuan.satuan'))->leftjoin('barang_golongan','barang_golongan.id','=','barang.id_barang_golongan')
        ->leftjoin('satuan','satuan.id','=','barang.id_satuan')
        ->orderby('barang.created_at','desc')->paginate(10);
        return $this->view("index",compact('data'));
    }

    public function getData(Request $request)
    {
        if($request->ajax())
        {
            $per_page=$request->input('per_page',null);
            $sort=$request->input('sort',null);
            $search=$request->input('search',null);

            $data=Barang::select(\DB::raw('barang.*,barang_golongan.barang_golongan,satuan.satuan'))
            ->leftjoin('barang_golongan','barang_golongan.id','=','barang.id_barang_golongan')
            ->leftjoin('satuan','satuan.id','=','barang.id_satuan')
            ->where(function($q) use($search){
                $q->where('barcode','like','%'.$search.'%')
                ->orWhere('nama_barang','like','%'.$search.'%')
                ->orWhere('barang_golongan.barang_golongan','like','%'.$search.'%')
                ->orWhere('satuan','like','%'.$search.'%');
            })
            ->orderby('barang.created_at',empty($sort) ? 'desc' : $sort=='date_desc'?'desc':'asc')
            ->paginate(empty($per_page) ? 10 : $per_page);
            
            return $this->view('index-data',compact('data'))->render();
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->menuAccess(\Auth::user(),'Barang (Create)');
        return $this->view('form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
         $this->menuAccess(\Auth::user(),'Barang (Edit)');
        $data = Barang::find($id);
        return $this->view("form",compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $kode)
    {
        //
        $data=Barang::find($kode);
           $this->logDeletedActivity($data,'Delete data id='.$kode.'','Barang','barang');
           $act=false;
           try {
               $act=$data->forceDelete();
           } catch (\Exception $e) {
               $data=Barang::find($kode);
               $act=$data->delete();
           }
    }

    public function sendData(Request $request)
    {
        $input=$request->all();
        DB::beginTransaction();
        try {
            switch($input['mode'])
            {
                case 'add':
                $data=array(
                    'barcode'=>$input['barcode'],
                    'nama_barang'=>$input['nama_barang'],
                    'id_barang_golongan'=>$input['id_barang_golongan'],
                    'id_satuan'=>$input['id_satuan'],
                    'harga_beli'=>$input['harga_beli'],
                    'harga_jual'=>$input['harga_jual'],
                    'diskon'=>$input['diskon'],
                );
                $this->logCreatedActivity(Auth::user(),$data,'Barang','barang');
                $act=Barang::create($data);
                break;
                case 'edit':
                $list=Barang::find($input['id']);
                $data=array(
                    'barcode'=>$input['barcode'],
                    'nama_barang'=>$input['nama_barang'],
                    'id_barang_golongan'=>$input['id_barang_golongan'],
                    'id_satuan'=>$input['id_satuan'],
                    'harga_beli'=>$input['harga_beli'],
                    'harga_jual'=>$input['harga_jual'],
                    'diskon'=>$input['diskon'],
                );
                $this->logUpdatedActivity(Auth::user(),$list->getAttributes(),$data,'Barang','barang');
                $act=$list->update($data);
                break;
            }

            if($act==true)
            {
                $data=array(
                'status'=>true,
                'msg'=>'Data berhasil diupdate'
              );
            }
            else
            {
                $data=array(
                'status'=>false,
                'msg'=>'Data gagal disimpan'
              );
            }
        } catch (Exception $e) {
            $data=array(
                'status'=>false,
                'msg'=>$e->getMessage(),
              );
          DB::rollback();
      }
      DB::commit();
      return \Response::json($data);
  }
}
