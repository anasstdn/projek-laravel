<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Requests;
use Illuminate\Support\Facades\Schema;
use App\Models\RawDatum;
use App\Encryption;
use DatePeriod;
use DateTime;
use DateInterval;
use Carbon\Carbon;
use App\Traits\ActivityTraits;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
date_default_timezone_set(setting('timezone'));

class PenjualanBarangController extends Controller
{
//
	use ActivityTraits;
	public $viewDir = "penjualan_barang";
	public function __construct()
	{
		$this->middleware('auth');
    // $this->middleware('permission:read-home', ['only' => ['index','create','loadData','getNotif','getChart']]);
    // $this->middleware('permission:home-create', ['only' => ['create','store']]);
    // $this->middleware('permission:home-update', ['only' => ['edit','update']]);
    // $this->middleware('permission:home-delete', ['only' => ['delete']]);
		$this->middleware('permission:read-penjualan-barang');
	}

	 protected function view($view, $data = [])
    {
       return view($this->viewDir.".".$view, $data);
   }

	public function index()
	{ 
		$data = RawDatum::orderby('created_at','desc')->paginate(10);
		return $this->view('index',compact('data'));
	}

	public function getData(Request $request)
    {
        if($request->ajax())
        {
            $per_page=$request->input('per_page',null);
            $sort=$request->input('sort',null);
            $search=$request->input('search',null);

            $data=RawDatum::select('*')
            ->where(function($q) use($search){
                $q->where('no_nota','like','%'.$search.'%')
                ->orWhere('tgl_transaksi','like','%'.$search.'%');
            })
            ->orderby('created_at',empty($sort) ? 'desc' : $sort=='date_desc'?'desc':'asc')
            ->paginate(empty($per_page) ? 10 : $per_page);
            
            return $this->view('index-data',compact('data'))->render();
        } 
    }

    public function create()
    {
        //
        // dd('aaaaaa');
        $this->menuAccess(\Auth::user(),'Penjualan Barang (Create)');
        return $this->view('form');
    }

    public function edit($id)
    {
        //
        $this->menuAccess(\Auth::user(),'Penjualan Barang (Edit)');
        $data = RawDatum::find($id);
        return $this->view("form",compact('data'));
    }

    public function destroy(Request $request, $kode)
    {
        //
        $data=RawDatum::find($kode);
           $this->logDeletedActivity($data,'Delete data id='.$kode.'','Penjualan Barang','raw_datum');
           $act=false;
           try {
               $act=$data->forceDelete();
           } catch (\Exception $e) {
               $data=RawDatum::find($kode);
               $act=$data->delete();
           }
    }

    public function sendData(Request $request)
    {
        $input=$request->all();
        $decrypt=new Encryption();
        // dd($decrypt->decrypt($input['campur'],$input['enckey']));
        DB::beginTransaction();
        try {
            switch($decrypt->decrypt($input['mode'],$input['enckey']))
            {
                case 'add':
                // $data=array(
                //     'no_nota'=>$input['no_nota'],
                //     'tgl_transaksi'=>date('Y-m-d',strtotime($input['tgl_transaksi'])),
                //     'pasir'=>$input['pasir']==''?null:$input['pasir'],
                //     'abu'=>$input['abu']==''?null:$input['abu'],
                //     'gendol'=>$input['gendol']==''?null:$input['gendol'],
                //     'split2_3'=>$input['split2_3']==''?null:$input['split2_3'],
                //     'split1_2'=>$input['split1_2']==''?null:$input['split1_2'],
                //     'lpa'=>$input['lpa']==''?null:$input['lpa'],
                //     'campur'=>$input['campur']=='undefined'?'N':'Y',
                // );
                $data=array(
                    'no_nota'=>$decrypt->decrypt($input['no_nota'],$input['enckey']),
                    'tgl_transaksi'=>date('Y-m-d',strtotime($decrypt->decrypt($input['tgl_transaksi'],$input['enckey']))),
                    'pasir'=>$input['pasir']==''?null:$decrypt->decrypt($input['pasir'],$input['enckey']),
                    'abu'=>$input['abu']==''?null:$decrypt->decrypt($input['abu'],$input['enckey']),
                    'gendol'=>$input['gendol']==''?null:$decrypt->decrypt($input['gendol'],$input['enckey']),
                    'split2_3'=>$input['split2_3']==''?null:$decrypt->decrypt($input['split2_3'],$input['enckey']),
                    'split1_2'=>$input['split1_2']==''?null:$decrypt->decrypt($input['split1_2'],$input['enckey']),
                    'lpa'=>$input['lpa']==''?null:$decrypt->decrypt($input['lpa'],$input['enckey']),
                    'campur'=>$decrypt->decrypt($input['campur'],$input['enckey'])=='undefined' || $decrypt->decrypt($input['campur'],$input['enckey'])==''?'N':'Y',
                );
                // dd($data);
                $this->logCreatedActivity(Auth::user(),$data,'Penjualan Barang','raw_datum');
                $act=RawDatum::create($data);
                break;
                case 'edit':
                $list=RawDatum::find($decrypt->decrypt($input['id'],$input['enckey']));
                // $data=array(
                //     'no_nota'=>$input['no_nota'],
                //     'tgl_transaksi'=>date('Y-m-d',strtotime($input['tgl_transaksi'])),
                //     'pasir'=>$input['pasir']==''?null:$input['pasir'],
                //     'abu'=>$input['abu']==''?null:$input['abu'],
                //     'gendol'=>$input['gendol']==''?null:$input['gendol'],
                //     'split2_3'=>$input['split2_3']==''?null:$input['split2_3'],
                //     'split1_2'=>$input['split1_2']==''?null:$input['split1_2'],
                //     'lpa'=>$input['lpa']==''?null:$input['lpa'],
                //     'campur'=>$input['campur']=='undefined'?'N':'Y',
                // );
                $data=array(
                    'no_nota'=>$decrypt->decrypt($input['no_nota'],$input['enckey']),
                    'tgl_transaksi'=>date('Y-m-d',strtotime($decrypt->decrypt($input['tgl_transaksi'],$input['enckey']))),
                    'pasir'=>$input['pasir']==''?null:$decrypt->decrypt($input['pasir'],$input['enckey']),
                    'abu'=>$input['abu']==''?null:$decrypt->decrypt($input['abu'],$input['enckey']),
                    'gendol'=>$input['gendol']==''?null:$decrypt->decrypt($input['gendol'],$input['enckey']),
                    'split2_3'=>$input['split2_3']==''?null:$decrypt->decrypt($input['split2_3'],$input['enckey']),
                    'split1_2'=>$input['split1_2']==''?null:$decrypt->decrypt($input['split1_2'],$input['enckey']),
                    'lpa'=>$input['lpa']==''?null:$decrypt->decrypt($input['lpa'],$input['enckey']),
                    'campur'=>$decrypt->decrypt($input['campur'],$input['enckey'])=='undefined' || $decrypt->decrypt($input['campur'],$input['enckey'])==''?'N':'Y',
                );
                $this->logUpdatedActivity(Auth::user(),$list->getAttributes(),$data,'Penjualan Barang','raw_datum');
                // dd($data);
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
