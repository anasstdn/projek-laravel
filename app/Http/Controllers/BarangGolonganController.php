<?php

namespace App\Http\Controllers;

use App\Models\BarangGolongan;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use Carbon\Carbon;
use App\Traits\ActivityTraits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangGolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ActivityTraits;
    public $viewDir = "barang_golongan";
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
           $this->middleware('permission:read-barang-golongan', ['only' => ['index','getData']]);
           $this->middleware('permission:create-barang-golongan', ['only' => ['create','create','store']]);
           // $this->middleware('permission:read-barang-golongan');
       }

    public function index()
    {
        //
        $this->menuAccess(\Auth::user(),'Barang Golongan');
        // dd('aaaaa');
        $data = BarangGolongan::orderby('created_at','desc')->paginate(10);
        return $this->view("index",compact('data'));
    }

    public function getData(Request $request)
    {
        if($request->ajax())
        {
            $per_page=$request->input('per_page',null);
            $sort=$request->input('sort',null);
            $search=$request->input('search',null);

            $data=BarangGolongan::select('*')
            ->where(function($q) use($search){
                $q->where('barang_golongan','like','%'.$search.'%');
            })
            ->orderby('created_at',empty($sort) ? 'desc' : $sort=='date_desc'?'desc':'asc')
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
        // dd('aaaaaa');
        $this->menuAccess(\Auth::user(),'Barang Golongan (Create)');
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
     * @param  \App\BarangGolongan  $barangGolongan
     * @return \Illuminate\Http\Response
     */
    public function show(BarangGolongan $barangGolongan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BarangGolongan  $barangGolongan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $this->menuAccess(\Auth::user(),'Barang Golongan (Edit)');
        $data = BarangGolongan::find($id);
        return $this->view("form",compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BarangGolongan  $barangGolongan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarangGolongan $barangGolongan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BarangGolongan  $barangGolongan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $kode)
    {
        //
        $data=BarangGolongan::find($kode);
           $this->logDeletedActivity($data,'Delete data id='.$kode.'','Barang Golongan','barang_golongan');
           $act=false;
           try {
               $act=$data->forceDelete();
           } catch (\Exception $e) {
               $data=BarangGolongan::find($kode);
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
                    'barang_golongan'=>$input['golongan_barang'],
                );
                $this->logCreatedActivity(Auth::user(),$data,'Barang Golongan','barang_golongan');
                $act=BarangGolongan::create($data);
                break;
                case 'edit':
                $list=BarangGolongan::find($input['id']);
                $data=array(
                    'barang_golongan'=>$input['golongan_barang'],
                );
                $this->logUpdatedActivity(Auth::user(),$list->getAttributes(),$data,'Barang Golongan','barang_golongan');
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
