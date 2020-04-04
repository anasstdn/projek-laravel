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
       $this->middleware('permission:read-barang', ['only' => ['index','getData']]);
       $this->middleware('permission:create-barang', ['only' => ['create','sendData']]);
       $this->middleware('permission:edit-barang', ['only' => ['edit','sendData']]);
       $this->middleware('permission:delete-barang', ['only' => ['destroy']]);
   }

    public function index()
    {
        //
        $this->menuAccess(\Auth::user(),'Barang');
        $data = Barang::select(\DB::raw('barang.*,barang_golongan.barang_golongan'))->leftjoin('barang_golongan','barang_golongan.id','=','barang.id_barang_golongan')->orderby('barang.created_at','desc')->paginate(10);
        return $this->view("index",compact('data'));
    }

    public function getData(Request $request)
    {
        if($request->ajax())
        {
            $per_page=$request->input('per_page',null);
            $sort=$request->input('sort',null);
            $search=$request->input('search',null);

            $data=Barang::select(\DB::raw('barang.*,barang_golongan.barang_golongan'))
            ->leftjoin('barang_golongan','barang_golongan.id','=','barang.id_barang_golongan')
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
    public function destroy($id)
    {
        //
    }
}
