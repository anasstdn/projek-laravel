<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Requests;
use Illuminate\Support\Facades\Schema;
use App\Models\RawDatum;
use DatePeriod;
use DateTime;
use DateInterval;
use Carbon\Carbon;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
date_default_timezone_set(setting('timezone'));

class PenjualanController extends Controller
{
    //
    public $viewDir = "penjualan";
     public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permission:read-home', ['only' => ['index','create','loadData','getNotif','getChart']]);
        // $this->middleware('permission:home-create', ['only' => ['create','store']]);
        // $this->middleware('permission:home-update', ['only' => ['edit','update']]);
        // $this->middleware('permission:home-delete', ['only' => ['delete']]);
    }


    protected function view($view, $data = [])
    {
       return view($this->viewDir.".".$view, $data);
   }

   public function index()
    {
    	 return $this->view('index');
    }

     public function loadData()
    {
       $GLOBALS['nomor']=\Request::input('start',1)+1;
       $tahun=\Request::input('tahun');
       // dd($tahun);
       // $dataList = RawDatum::select(\DB::raw('MONTH(tgl_transaksi) as bulan,sum(pasir) as pasir, sum(gendol) as gendol, sum(abu) as abu, sum(split2_3) as split2_3, sum(split1_2) as split1_2, sum(lpa) as lpa'))
       // ->whereYear('tgl_transaksi',date('2019'))
       // ->groupBy('bulan')
       // ->orderBy('bulan','asc');
       $dataList=Schema::getColumnListing('raw_data');
       // dd($dataList);
       $arr_to_rem=array('id','tgl_transaksi','no_nota','created_at','updated_at');
       $dataList=array_diff($dataList,$arr_to_rem);
       // dd($dataList);

       if (request()->get('status') == 'trash') {
         $dataList->onlyTrashed();
     }
     return DataTables::of($dataList)
     ->addColumn('nomor',function($kategori){
         return $GLOBALS['nomor']++;
     })
     ->addColumn('produk',function($data){
        // dd($data);
        if($data!=='id' && $data!=='tgl_transaksi' && $data !=='no_nota' && $data!=='created_at' && $data!=='updated_at')
        {
            if(isset($data)){
                return column_name($data);
            }
        }

    })

     ->addColumn('jan',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',1)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
    })
    ->addColumn('feb',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',2)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
    })
    ->addColumn('mar',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',3)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
    })
     ->addColumn('apr',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',4)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
    })
     ->addColumn('mei',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',5)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
})
      ->addColumn('jun',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',6)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
})
       ->addColumn('jul',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',7)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
})
        ->addColumn('aug',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',8)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
       return number_format($total,1,',','.');
    }else{
        return null;
    }
})
         ->addColumn('sep',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',9)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
})
          ->addColumn('okt',function($data) use($tahun){ 
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',10)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
})
           ->addColumn('nov',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',11)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
})
            ->addColumn('des',function($data) use($tahun){
      if(isset($data)){
        $jum=RawDatum::select(\DB::raw('sum('.$data.') as total'))
        ->whereMonth('tgl_transaksi',12)
        ->whereYear('tgl_transaksi',$tahun)
        ->first();
        // dd($jum);
        $total=isset($jum) && !empty($jum->total)?$jum->total:0;
        return number_format($total,1,',','.');
    }else{
        return null;
    }
})

//      ->addColumn('email',function($data){
//       if(isset($data->email)){
//         return $data->email;
//     }else{
//         return null;
//     }
// })

//  ->addColumn('verified',function($data){
//       if(isset($data->verified)){
//         return $data->verified;
//     }else{
//         return null;
//     }
// })

    //  ->addColumn('verified', function ($data) {
    //      if(isset($data->verified))
    //      {
    //         return array('id'=>$data->id,'status_aktif'=>$data->verified);
    //     }else
    //     {
    //         return null;
    //     }

    // })

     ->make(true);
 }

 public function loadDataMingguan()
 {
    $GLOBALS['nomor']=\Request::input('start',1)+1;
    $minggu=date('Y-m-d',strtotime(\Request::input('week_input')));
    $tahun=date('Y',strtotime(\Request::input('week_input')));
    $minggu=strftime('%V', strtotime($minggu))-1;

    $dataList=RawDatum::select(DB::raw('tgl_transaksi,COALESCE(sum(pasir),0) as pasir,COALESCE(sum(gendol),0) as gendol,COALESCE(sum(abu),0) as abu, COALESCE(sum(split2_3),0) as split2_3, COALESCE(sum(split1_2),0) as split1_2, COALESCE(sum(lpa),0) as lpa'))
    ->where(\DB::raw('date_format(tgl_transaksi,"%V")'),'=',$minggu)
    ->whereYear('tgl_transaksi',$tahun)
    ->groupBy(DB::raw('tgl_transaksi'))
    ->orderBy('tgl_transaksi','asc');

    if (request()->get('status') == 'trash') {
         $dataList->onlyTrashed();
     }
     return DataTables::of($dataList)
     ->addColumn('nomor',function($kategori){
         return $GLOBALS['nomor']++;
     })

     ->addColumn('tgl_transaksi',function($data){
      if(isset($data->tgl_transaksi)){
        return date_indo(date('Y-m-d',strtotime($data->tgl_transaksi)));
      }else{
        return null;
      }
    })

     ->addColumn('pasir',function($data){
      if(isset($data->pasir)){
        return $data->pasir!==null?$data->pasir:'0';
      }else{
        return null;
      }
    })

     ->addColumn('gendol',function($data){
      if(isset($data->gendol)){
        return $data->gendol!==null?$data->gendol:'0';
      }else{
        return null;
      }
    })

      ->addColumn('abu',function($data){
      if(isset($data->abu)){
        return $data->abu!==null?$data->abu:'0';
      }else{
        return null;
      }
    })

       ->addColumn('split2_3',function($data){
      if(isset($data->split2_3)){
        return $data->split2_3!==null?$data->split2_3:'0';
      }else{
        return null;
      }
    })

         ->addColumn('split1_2',function($data){
      if(isset($data->split1_2)){
        return $data->split1_2!==null?$data->split1_2:'0';
      }else{
        return null;
      }
    })

            ->addColumn('lpa',function($data){
      if(isset($data->lpa)){
        return $data->lpa!==null?$data->lpa:'0';
      }else{
        return null;
      }
    })

       ->make(true);



 }



}
