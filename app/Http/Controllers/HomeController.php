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
use App\Traits\ActivityTraits;
use Gmopx\LaravelOWM\LaravelOWM;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    use ActivityTraits;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-home', ['only' => ['index','create','loadData','getNotif','getChart']]);
        // $this->middleware('permission:home-create', ['only' => ['create','store']]);
        // $this->middleware('permission:home-update', ['only' => ['edit','update']]);
        // $this->middleware('permission:home-delete', ['only' => ['delete']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->menuAccess(Auth::user(),'Home');
        return view('home');
    }

    public function weather()
    {
       $lowm = new LaravelOWM();
       $current_weather = $lowm->getCurrentWeather('daerah istimewa yogyakarta');
       $data=array(
        'now'=>$current_weather->temperature->now->getValue()!==null?$current_weather->temperature->now->getValue():0,
        'min'=>$current_weather->temperature->min->getValue()!==null?$current_weather->temperature->min->getValue():0,
        'max'=>$current_weather->temperature->max->getValue()!==null?$current_weather->temperature->max->getValue():0,
        'country'=>($current_weather->city->name!==null?$current_weather->city->name:'').', '.($current_weather->city->country!==null?$current_weather->city->country:'')
       );
       return \Response::json($data);
    }

    public function card(Request $request)
    {
        if(\Auth::user()->can('read-card-admin') || \Auth::user()->can('read-card-manager'))
        {
          $total_transaksi=RawDatum::select(\DB::raw('count(id) as total'))->first();

          $total_transaksi_bulan_ini=RawDatum::select(\DB::raw('count(id) as total'))
          ->whereMonth('tgl_transaksi',date('m'))
          ->whereYear('tgl_transaksi',date('Y'))
          ->first();




          Carbon::setWeekStartsAt(Carbon::MONDAY);
          Carbon::setWeekEndsAt(Carbon::SATURDAY);
          // dd(Carbon::now()->startOfWeek()->addWeeks('-1')->format('Y-m-d'));

           $total_transaksi_minggu_ini=RawDatum::select(\DB::raw('count(id) as total'))
          ->whereBetween('tgl_transaksi', [Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])
          ->first();

          $total_transaksi_hari_ini=RawDatum::select(\DB::raw('count(id) as total'))
          ->whereDate('tgl_transaksi',date('Y-m-d'))
          ->first();


          //  $pasir_minggu_ini=RawDatum::select(\DB::raw('sum(pasir) as total'))
          // ->whereBetween('tgl_transaksi', [Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])
          // ->first();

          // $pasir_minggu_lalu=RawDatum::select(\DB::raw('sum(pasir) as total'))
          // ->whereBetween('tgl_transaksi', [Carbon::now()->startOfWeek()->addWeeks('-1')->format('Y-m-d'), Carbon::now()->endOfWeek()->addWeeks('-1')->format('Y-m-d')])
          // ->first();


          $data=array(
            'total_transaksi'=>isset($total_transaksi)?$total_transaksi->total:0,
            'total_transaksi_bulan_ini'=>isset($total_transaksi_bulan_ini)?$total_transaksi_bulan_ini->total:0,
            'total_transaksi_minggu_ini'=>isset($total_transaksi_minggu_ini)?$total_transaksi_minggu_ini->total:0,
            'total_transaksi_hari_ini'=>isset($total_transaksi_hari_ini)?$total_transaksi_hari_ini->total:0,
            // 'pasir_minggu_ini'=>isset($pasir_minggu_ini) && $pasir_minggu_ini->total!==null?$pasir_minggu_ini->total:0,
            // 'pasir_minggu_lalu'=>isset($pasir_minggu_lalu) && $pasir_minggu_lalu->total!==null?$pasir_minggu_lalu->total:0
          );
        }

        return \Response::json($data);
    }



    public function getChart()
    {
        $tahun=\Request::input('tahun',null);
        $dates = getDatesFromRange(''.$tahun.'-01-01', ''.$tahun.'-12-31');
        $arr_pasir=[];
        $arr_gendol=[];
        $arr_abu=[];
        $arr_split2=[];
        $arr_split1=[];
        $arr_lpa=[];
        foreach($dates as $a)
        {
           $sum=RawDatum::select(\DB::raw('sum(pasir) as pasir'))
        ->where('tgl_transaksi',$a)->first();
        
        array_push($arr_pasir,(isset($sum->pasir) && $sum->pasir!==null)?$sum->pasir:0);

        $sum1=RawDatum::select(\DB::raw('sum(gendol) as gendol'))
        ->where('tgl_transaksi',$a)->first(); 

        array_push($arr_gendol,(isset($sum1->gendol) && $sum1->gendol!==null)?$sum1->gendol:0);

        $sum2=RawDatum::select(\DB::raw('sum(abu) as abu'))
        ->where('tgl_transaksi',$a)->first(); 

        array_push($arr_abu,(isset($sum2->abu) && $sum2->abu!==null)?$sum2->abu:0);

         $sum3=RawDatum::select(\DB::raw('sum(split2_3) as split2_3'))
        ->where('tgl_transaksi',$a)->first(); 

        array_push($arr_split2,(isset($sum3->split2_3) && $sum3->split2_3!==null)?$sum3->split2_3:0);

         $sum4=RawDatum::select(\DB::raw('sum(split1_2) as split1_2'))
        ->where('tgl_transaksi',$a)->first(); 

        array_push($arr_split1,(isset($sum4->split1_2) && $sum4->split1_2!==null)?$sum4->split1_2:0);

        $sum5=RawDatum::select(\DB::raw('sum(lpa) as lpa'))
        ->where('tgl_transaksi',$a)->first(); 

        array_push($arr_lpa,(isset($sum5->lpa) && $sum5->lpa!==null)?$sum5->lpa:0);
        }
        
        $data=array(
            'dates'=>$dates,
            'pasir'=>$arr_pasir,
            'gendol'=>$arr_gendol,
            'abu'=>$arr_abu,
            'split2'=>$arr_split2,
            'split1'=>$arr_split1,
            'lpa'=>$arr_lpa,
        );
        // dd($data);
        // echo json_encode($data);
        return \Response::json($data);  
        // return \Response::json($data);
    }

    public function loadData()
    {
       $GLOBALS['nomor']=\Request::input('start',1)+1;
       $tahun=\Request::input('tahun');
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

  public function getNotif()
  {
    $get=Notification::where('user_id',Auth::user()->id)->get();
    $data=array('data'=>$get);
    // echo json_encode($data);
     return \Response::json($data);  
  }


}

