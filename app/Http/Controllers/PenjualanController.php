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
         $this->middleware('permission:read-penjualan');
    }


    protected function view($view, $data = [])
    {
       return view($this->viewDir.".".$view, $data);
   }

   public function index()
    {
    	 return $this->view('index');
    }

    public function chart()
    {
      return $this->view('index-chart');
    }

    public function getChart(Request $request)
    {
       // dd('aaaaa');
      $total_transaksi=array();

      $graph_pie=array();

      $date_from=date('2019-01-01');
      $date_to=date('2019-12-31');

      $data_penjualan=RawDatum::select(DB::raw('
        SUM(if(MONTH(tgl_transaksi) = 1, 1,0)) as Jan,
        SUM(if(MONTH(tgl_transaksi) = 2, 1,0)) as Feb,
        SUM(if(MONTH(tgl_transaksi) = 3, 1,0)) as Mar,
        SUM(if(MONTH(tgl_transaksi) = 4, 1,0)) as Apr,
        SUM(if(MONTH(tgl_transaksi) = 5, 1,0)) as May,
        SUM(if(MONTH(tgl_transaksi) = 6, 1,0)) as Jun,
        SUM(if(MONTH(tgl_transaksi) = 7, 1,0)) as Jul,
        SUM(if(MONTH(tgl_transaksi) = 8, 1,0)) as Aug,
        SUM(if(MONTH(tgl_transaksi) = 9, 1,0)) as Sep,
        SUM(if(MONTH(tgl_transaksi) = 10, 1,0)) as Oct,
        SUM(if(MONTH(tgl_transaksi) = 11, 1,0)) as Nov,
        SUM(if(MONTH(tgl_transaksi) = 12, 1,0)) as `Dec`
        '))
      ->whereYear('tgl_transaksi',date('2019'))
      // ->groupby('tgl_transaksi')
      ->first();

      array_push($total_transaksi,$data_penjualan->Jan);
      array_push($total_transaksi,$data_penjualan->Feb);
      array_push($total_transaksi,$data_penjualan->Mar);
      array_push($total_transaksi,$data_penjualan->Apr);
      array_push($total_transaksi,$data_penjualan->May);
      array_push($total_transaksi,$data_penjualan->Jun);
      array_push($total_transaksi,$data_penjualan->Jul);
      array_push($total_transaksi,$data_penjualan->Aug);
      array_push($total_transaksi,$data_penjualan->Sep);
      array_push($total_transaksi,$data_penjualan->Oct);
      array_push($total_transaksi,$data_penjualan->Nov);
      array_push($total_transaksi,$data_penjualan->Dec);

    
      // dd($total_transaksi);
      $total_pasir=$this->totalPasir();

      $total_abu=$this->totalAbu();

      $total_gendol=$this->totalGendol();

      $total_split_1=$this->totalSplit1();

      $total_split_2=$this->totalSplit2();

      $total_lpa=$this->totalLpa();

      $bulan=$this->month_between_two_dates($date_from,$date_to);

      $total_pasir_pie=RawDatum::select(DB::raw('count(id) as pasir'))
      ->whereNotNull('pasir')
      ->where('campur','N')
      ->whereYear('tgl_transaksi',date('2019'))
      ->first();
      array_push($graph_pie, $total_pasir_pie->pasir);

      $total_abu_pie=RawDatum::select(DB::raw('count(id) as abu'))
      ->whereNotNull('abu')
      ->where('campur','N')
      ->whereYear('tgl_transaksi',date('2019'))->first();
      array_push($graph_pie, $total_abu_pie->abu);

      $total_gendol_pie=RawDatum::select(DB::raw('count(id) as gendol'))
      ->whereNotNull('gendol')
      ->where('campur','N')
      ->whereYear('tgl_transaksi',date('2019'))->first();
       array_push($graph_pie, $total_gendol_pie->gendol);

      $total_split_1_pie=RawDatum::select(DB::raw('count(id) as split1_2'))
      ->whereNotNull('split1_2')
      ->where('campur','N')
      ->whereYear('tgl_transaksi',date('2019'))->first();
      array_push($graph_pie, $total_split_1_pie->split1_2);

      $total_split_2_pie=RawDatum::select(DB::raw('count(id) as split2_3'))
      ->whereNotNull('split2_3')
      ->where('campur','N')
      ->whereYear('tgl_transaksi',date('2019'))->first();
      array_push($graph_pie, $total_split_2_pie->split2_3);

      $total_lpa_pie=RawDatum::select(DB::raw('count(id) as lpa'))
      ->whereNotNull('lpa')
      ->where('campur','N')
      ->whereYear('tgl_transaksi',date('2019'))->first();
      array_push($graph_pie, $total_lpa_pie->lpa);

      $total_campur_pie=RawDatum::select(DB::raw('count(id) as campur'))
      ->where('campur','Y')
      ->whereYear('tgl_transaksi',date('2019'))->first();
      array_push($graph_pie, $total_campur_pie->campur);

      $label_pie=['Pasir','Abu','Pasir Gendol','Split 1/2','Split 2/3','LPA','Campur'];

      $data=array(
        'bulan'=>$bulan,
        'total_transaksi'=>$total_transaksi,
        'total_pasir'=>$total_pasir,
        'total_abu'=>$total_abu,
        'total_gendol'=>$total_gendol,
        'total_split_1'=>$total_split_1,
        'total_split_2'=>$total_split_2,
        'total_lpa'=>$total_lpa,
        'graph_pie'=>$graph_pie,
        'label_pie'=>$label_pie,
      );
      return \Response::json($data);  
    }

    public function totalPasir()
    {
      $total_transaksi=array();
      $data_penjualan=RawDatum::select(DB::raw('
        SUM(if(MONTH(tgl_transaksi) = 1, pasir,0)) as Jan,
        SUM(if(MONTH(tgl_transaksi) = 2, pasir,0)) as Feb,
        SUM(if(MONTH(tgl_transaksi) = 3, pasir,0)) as Mar,
        SUM(if(MONTH(tgl_transaksi) = 4, pasir,0)) as Apr,
        SUM(if(MONTH(tgl_transaksi) = 5, pasir,0)) as May,
        SUM(if(MONTH(tgl_transaksi) = 6, pasir,0)) as Jun,
        SUM(if(MONTH(tgl_transaksi) = 7, pasir,0)) as Jul,
        SUM(if(MONTH(tgl_transaksi) = 8, pasir,0)) as Aug,
        SUM(if(MONTH(tgl_transaksi) = 9, pasir,0)) as Sep,
        SUM(if(MONTH(tgl_transaksi) = 10, pasir,0)) as Oct,
        SUM(if(MONTH(tgl_transaksi) = 11, pasir,0)) as Nov,
        SUM(if(MONTH(tgl_transaksi) = 12, pasir,0)) as `Dec`
        '))
      ->whereYear('tgl_transaksi',date('2019'))
      // ->groupby('tgl_transaksi')
      ->first();

      array_push($total_transaksi,$data_penjualan->Jan);
      array_push($total_transaksi,$data_penjualan->Feb);
      array_push($total_transaksi,$data_penjualan->Mar);
      array_push($total_transaksi,$data_penjualan->Apr);
      array_push($total_transaksi,$data_penjualan->May);
      array_push($total_transaksi,$data_penjualan->Jun);
      array_push($total_transaksi,$data_penjualan->Jul);
      array_push($total_transaksi,$data_penjualan->Aug);
      array_push($total_transaksi,$data_penjualan->Sep);
      array_push($total_transaksi,$data_penjualan->Oct);
      array_push($total_transaksi,$data_penjualan->Nov);
      array_push($total_transaksi,$data_penjualan->Dec);

      return $total_transaksi;
    }

    public function totalAbu()
    {
      $total_transaksi=array();
      $data_penjualan=RawDatum::select(DB::raw('
        SUM(if(MONTH(tgl_transaksi) = 1, abu,0)) as Jan,
        SUM(if(MONTH(tgl_transaksi) = 2, abu,0)) as Feb,
        SUM(if(MONTH(tgl_transaksi) = 3, abu,0)) as Mar,
        SUM(if(MONTH(tgl_transaksi) = 4, abu,0)) as Apr,
        SUM(if(MONTH(tgl_transaksi) = 5, abu,0)) as May,
        SUM(if(MONTH(tgl_transaksi) = 6, abu,0)) as Jun,
        SUM(if(MONTH(tgl_transaksi) = 7, abu,0)) as Jul,
        SUM(if(MONTH(tgl_transaksi) = 8, abu,0)) as Aug,
        SUM(if(MONTH(tgl_transaksi) = 9, abu,0)) as Sep,
        SUM(if(MONTH(tgl_transaksi) = 10, abu,0)) as Oct,
        SUM(if(MONTH(tgl_transaksi) = 11, abu,0)) as Nov,
        SUM(if(MONTH(tgl_transaksi) = 12, abu,0)) as `Dec`
        '))
      ->whereYear('tgl_transaksi',date('2019'))
      // ->groupby('tgl_transaksi')
      ->first();

      array_push($total_transaksi,$data_penjualan->Jan);
      array_push($total_transaksi,$data_penjualan->Feb);
      array_push($total_transaksi,$data_penjualan->Mar);
      array_push($total_transaksi,$data_penjualan->Apr);
      array_push($total_transaksi,$data_penjualan->May);
      array_push($total_transaksi,$data_penjualan->Jun);
      array_push($total_transaksi,$data_penjualan->Jul);
      array_push($total_transaksi,$data_penjualan->Aug);
      array_push($total_transaksi,$data_penjualan->Sep);
      array_push($total_transaksi,$data_penjualan->Oct);
      array_push($total_transaksi,$data_penjualan->Nov);
      array_push($total_transaksi,$data_penjualan->Dec);

      return $total_transaksi;
    }

    public function totalGendol()
    {
      $total_transaksi=array();
      $data_penjualan=RawDatum::select(DB::raw('
        SUM(if(MONTH(tgl_transaksi) = 1, gendol,0)) as Jan,
        SUM(if(MONTH(tgl_transaksi) = 2, gendol,0)) as Feb,
        SUM(if(MONTH(tgl_transaksi) = 3, gendol,0)) as Mar,
        SUM(if(MONTH(tgl_transaksi) = 4, gendol,0)) as Apr,
        SUM(if(MONTH(tgl_transaksi) = 5, gendol,0)) as May,
        SUM(if(MONTH(tgl_transaksi) = 6, gendol,0)) as Jun,
        SUM(if(MONTH(tgl_transaksi) = 7, gendol,0)) as Jul,
        SUM(if(MONTH(tgl_transaksi) = 8, gendol,0)) as Aug,
        SUM(if(MONTH(tgl_transaksi) = 9, gendol,0)) as Sep,
        SUM(if(MONTH(tgl_transaksi) = 10, gendol,0)) as Oct,
        SUM(if(MONTH(tgl_transaksi) = 11, gendol,0)) as Nov,
        SUM(if(MONTH(tgl_transaksi) = 12, gendol,0)) as `Dec`
        '))
      ->whereYear('tgl_transaksi',date('2019'))
      // ->groupby('tgl_transaksi')
      ->first();

      array_push($total_transaksi,$data_penjualan->Jan);
      array_push($total_transaksi,$data_penjualan->Feb);
      array_push($total_transaksi,$data_penjualan->Mar);
      array_push($total_transaksi,$data_penjualan->Apr);
      array_push($total_transaksi,$data_penjualan->May);
      array_push($total_transaksi,$data_penjualan->Jun);
      array_push($total_transaksi,$data_penjualan->Jul);
      array_push($total_transaksi,$data_penjualan->Aug);
      array_push($total_transaksi,$data_penjualan->Sep);
      array_push($total_transaksi,$data_penjualan->Oct);
      array_push($total_transaksi,$data_penjualan->Nov);
      array_push($total_transaksi,$data_penjualan->Dec);

      return $total_transaksi;
    }

     public function totalSplit1()
    {
      $total_transaksi=array();
      $data_penjualan=RawDatum::select(DB::raw('
        SUM(if(MONTH(tgl_transaksi) = 1, split1_2,0)) as Jan,
        SUM(if(MONTH(tgl_transaksi) = 2, split1_2,0)) as Feb,
        SUM(if(MONTH(tgl_transaksi) = 3, split1_2,0)) as Mar,
        SUM(if(MONTH(tgl_transaksi) = 4, split1_2,0)) as Apr,
        SUM(if(MONTH(tgl_transaksi) = 5, split1_2,0)) as May,
        SUM(if(MONTH(tgl_transaksi) = 6, split1_2,0)) as Jun,
        SUM(if(MONTH(tgl_transaksi) = 7, split1_2,0)) as Jul,
        SUM(if(MONTH(tgl_transaksi) = 8, split1_2,0)) as Aug,
        SUM(if(MONTH(tgl_transaksi) = 9, split1_2,0)) as Sep,
        SUM(if(MONTH(tgl_transaksi) = 10, split1_2,0)) as Oct,
        SUM(if(MONTH(tgl_transaksi) = 11, split1_2,0)) as Nov,
        SUM(if(MONTH(tgl_transaksi) = 12, split1_2,0)) as `Dec`
        '))
      ->whereYear('tgl_transaksi',date('2019'))
      // ->groupby('tgl_transaksi')
      ->first();

      array_push($total_transaksi,$data_penjualan->Jan);
      array_push($total_transaksi,$data_penjualan->Feb);
      array_push($total_transaksi,$data_penjualan->Mar);
      array_push($total_transaksi,$data_penjualan->Apr);
      array_push($total_transaksi,$data_penjualan->May);
      array_push($total_transaksi,$data_penjualan->Jun);
      array_push($total_transaksi,$data_penjualan->Jul);
      array_push($total_transaksi,$data_penjualan->Aug);
      array_push($total_transaksi,$data_penjualan->Sep);
      array_push($total_transaksi,$data_penjualan->Oct);
      array_push($total_transaksi,$data_penjualan->Nov);
      array_push($total_transaksi,$data_penjualan->Dec);

      return $total_transaksi;
    }

     public function totalSplit2()
    {
      $total_transaksi=array();
      $data_penjualan=RawDatum::select(DB::raw('
        SUM(if(MONTH(tgl_transaksi) = 1, split2_3,0)) as Jan,
        SUM(if(MONTH(tgl_transaksi) = 2, split2_3,0)) as Feb,
        SUM(if(MONTH(tgl_transaksi) = 3, split2_3,0)) as Mar,
        SUM(if(MONTH(tgl_transaksi) = 4, split2_3,0)) as Apr,
        SUM(if(MONTH(tgl_transaksi) = 5, split2_3,0)) as May,
        SUM(if(MONTH(tgl_transaksi) = 6, split2_3,0)) as Jun,
        SUM(if(MONTH(tgl_transaksi) = 7, split2_3,0)) as Jul,
        SUM(if(MONTH(tgl_transaksi) = 8, split2_3,0)) as Aug,
        SUM(if(MONTH(tgl_transaksi) = 9, split2_3,0)) as Sep,
        SUM(if(MONTH(tgl_transaksi) = 10, split2_3,0)) as Oct,
        SUM(if(MONTH(tgl_transaksi) = 11, split2_3,0)) as Nov,
        SUM(if(MONTH(tgl_transaksi) = 12, split2_3,0)) as `Dec`
        '))
      ->whereYear('tgl_transaksi',date('2019'))
      // ->groupby('tgl_transaksi')
      ->first();

      array_push($total_transaksi,$data_penjualan->Jan);
      array_push($total_transaksi,$data_penjualan->Feb);
      array_push($total_transaksi,$data_penjualan->Mar);
      array_push($total_transaksi,$data_penjualan->Apr);
      array_push($total_transaksi,$data_penjualan->May);
      array_push($total_transaksi,$data_penjualan->Jun);
      array_push($total_transaksi,$data_penjualan->Jul);
      array_push($total_transaksi,$data_penjualan->Aug);
      array_push($total_transaksi,$data_penjualan->Sep);
      array_push($total_transaksi,$data_penjualan->Oct);
      array_push($total_transaksi,$data_penjualan->Nov);
      array_push($total_transaksi,$data_penjualan->Dec);

      return $total_transaksi;
    }

     public function totalLpa()
    {
      $total_transaksi=array();
      $data_penjualan=RawDatum::select(DB::raw('
        SUM(if(MONTH(tgl_transaksi) = 1, lpa,0)) as Jan,
        SUM(if(MONTH(tgl_transaksi) = 2, lpa,0)) as Feb,
        SUM(if(MONTH(tgl_transaksi) = 3, lpa,0)) as Mar,
        SUM(if(MONTH(tgl_transaksi) = 4, lpa,0)) as Apr,
        SUM(if(MONTH(tgl_transaksi) = 5, lpa,0)) as May,
        SUM(if(MONTH(tgl_transaksi) = 6, lpa,0)) as Jun,
        SUM(if(MONTH(tgl_transaksi) = 7, lpa,0)) as Jul,
        SUM(if(MONTH(tgl_transaksi) = 8, lpa,0)) as Aug,
        SUM(if(MONTH(tgl_transaksi) = 9, lpa,0)) as Sep,
        SUM(if(MONTH(tgl_transaksi) = 10, lpa,0)) as Oct,
        SUM(if(MONTH(tgl_transaksi) = 11, lpa,0)) as Nov,
        SUM(if(MONTH(tgl_transaksi) = 12, lpa,0)) as `Dec`
        '))
      ->whereYear('tgl_transaksi',date('2019'))
      // ->groupby('tgl_transaksi')
      ->first();

      array_push($total_transaksi,$data_penjualan->Jan);
      array_push($total_transaksi,$data_penjualan->Feb);
      array_push($total_transaksi,$data_penjualan->Mar);
      array_push($total_transaksi,$data_penjualan->Apr);
      array_push($total_transaksi,$data_penjualan->May);
      array_push($total_transaksi,$data_penjualan->Jun);
      array_push($total_transaksi,$data_penjualan->Jul);
      array_push($total_transaksi,$data_penjualan->Aug);
      array_push($total_transaksi,$data_penjualan->Sep);
      array_push($total_transaksi,$data_penjualan->Oct);
      array_push($total_transaksi,$data_penjualan->Nov);
      array_push($total_transaksi,$data_penjualan->Dec);

      return $total_transaksi;
    }

     public static function month_between_two_dates($start_date, $end_date)
    {
           $p = new DatePeriod(
            new DateTime($start_date), 
            new DateInterval('P1M'), 
            new DateTime($end_date)
        );
           foreach ($p as $w) {
            $minggu[]=$w->format('m/Y');
        }
        return $minggu;
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

 public function loadDataBulanan()
 {
    $GLOBALS['nomor']=\Request::input('start',1)+1;
   $tahun=\Request::input('tahun');
   $bulan=\Request::input('bulan');

    $dataList=RawDatum::select(DB::raw('tgl_transaksi,COALESCE(sum(pasir),0) as pasir,COALESCE(sum(gendol),0) as gendol,COALESCE(sum(abu),0) as abu, COALESCE(sum(split2_3),0) as split2_3, COALESCE(sum(split1_2),0) as split1_2, COALESCE(sum(lpa),0) as lpa'))
    // ->where(\DB::raw('date_format(tgl_transaksi,"%V")'),'=',$minggu)
    ->whereMonth('tgl_transaksi',$bulan)
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
        return date(setting('date_format'),strtotime($data->tgl_transaksi));
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
        return date(setting('date_format'),strtotime($data->tgl_transaksi));
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

 public function loadDataHarian()
 {
    $GLOBALS['nomor']=\Request::input('start',1)+1;
    $tanggal=date('Y-m-d',strtotime(\Request::input('date_input')));
    // $tahun=date('Y',strtotime(\Request::input('week_input')));
    // $minggu=strftime('%V', strtotime($minggu))-1;

    $dataList=RawDatum::select(DB::raw('no_nota,tgl_transaksi,COALESCE(pasir,0) as pasir,COALESCE(gendol,0) as gendol,COALESCE(abu,0) as abu, COALESCE(split2_3,0) as split2_3, COALESCE(split1_2,0) as split1_2, COALESCE(lpa,0) as lpa'))
    // ->where(\DB::raw('date_format(tgl_transaksi,"%V")'),'=',$minggu)
    ->whereDate('tgl_transaksi',$tanggal)
    // ->groupBy(DB::raw('tgl_transaksi'))
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
        return date(setting('date_format'),strtotime($data->tgl_transaksi));
      }else{
        return null;
      }
    })

      ->addColumn('no_nota',function($data){
      if(isset($data->no_nota)){
        return $data->no_nota;
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
