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
date_default_timezone_set("Asia/Jakarta");

class PeramalanController extends Controller
{
    //

     public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permission:read-home', ['only' => ['index','create','loadData','getNotif','getChart']]);
        
        // $this->middleware('permission:home-create', ['only' => ['create','store']]);
        // $this->middleware('permission:home-update', ['only' => ['edit','update']]);
        // $this->middleware('permission:home-delete', ['only' => ['delete']]);
    }

    public $viewDir = "forecast";

    protected function view($view, $data = [])
    {
       return view($this->viewDir.".".$view, $data);
   }

    public function index()
    {
    	 return $this->view('index');
    }

    public function forecastingArrses(Request $request)
    {
    	$date_from=date('2019-01-02');
    	$date_to=date('2019-06-20');
    	$data_penjualan=RawDatum::select(DB::raw('WEEK(tgl_transaksi) as minggu,sum(pasir) as pasir,sum(gendol) as gendol,sum(abu) as abu, sum(split2_3) as split2_3, sum(split1_2) as split1_2, sum(lpa) as lpa'))
    	->where('tgl_transaksi','>=',$date_from)
    	->where('tgl_transaksi','<=',$date_to)
    	// ->groupby('tgl_transaksi')
        ->groupBy(DB::raw('WEEK(tgl_transaksi)'))
    	->get();
        // dd($data_penjualan);

        $minggu=$this->week_between_two_dates($date_from,$date_to);
        // dd($minggu);

    	// $periode=$this->getPeriode($date_from,$date_to);
    	$total=$this->getTotal($minggu,$data_penjualan);
        // dd($total);
    	$result=$this->arrses($data_penjualan,$minggu,$total,$date_to);
        
        return \Response::json($result); 
    }

    private function arrses($data_penjualan,$periode,$total,$date_to)
    {
    	$periode=$periode;
    	$X=$total;
    	$F = array();
        $e = array();
        $E = array();
        $AE = array();
        $alpha = array();
        $beta = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9];
        $PE = array();
        $MAPE = array();

        for($i = 0; $i < count($beta); $i++) 
        {
        	$F[$i][0] = $e[$i][0] = $E[$i][0] = $AE[$i][0] = $alpha[$i][0] = $PE[$i][0] = 0;
            $F[$i][1] = $X[0];
            $alpha[$i][1] = $beta[$i];

              for($j = 1; $j < count($periode); $j++){
                // perhitungan peramalan untuk periode berikutnya
                $F[$i][$j + 1] = ($alpha[$i][$j] * $X[$j]) + ((1 - $alpha[$i][$j]) * $F[$i][$j]);

                // menghitung selisih antara nilai aktual dengan hasil peramalan
                $e[$i][$j] = $X[$j] - $F[$i][$j]; 

                // menghitung nilai kesalahan peramalan yang dihaluskan
                $E[$i][$j] = ($beta[$i] * $e[$i][$j]) + ((1 - $beta[$i]) * $E[$i][$j - 1]);

                // menghitung nilai kesalahan absolut peramalan yang dihaluskan
                $AE[$i][$j] = ($beta[$i] * abs($e[$i][$j])) + ((1 - $beta[$i]) * $AE[$i][$j - 1]);

                // menghitung nilai alpha untuk periode berikutnya
                $alpha[$i][$j + 1] = $E[$i][$j] == 0 ? $beta[$i] : abs($E[$i][$j] / $AE[$i][$j]);

                // menghitung nilai kesalahan persentase peramalan
                $PE[$i][$j] = $X[$j] == 0 ? 0 : abs((($X[$j] - $F[$i][$j]) / $X[$j]) * 100);
            }

            // menghitung rata-rata kesalahan peramalan
            $MAPE[$i] = array_sum($PE[$i])/(count($periode) - 1);
        }
        $bestBetaIndex = array_search(min($MAPE), $MAPE);

        $hasil = array();
        for ($i = 0; $i <= count($periode); $i++) {
        	if ($i < count($periode)) {
        		$hasil[$i] = [
        			'periode'                   => $periode[$i],
        			'aktual'                    => $X[$i],
        			'peramalan'                 => $F[$bestBetaIndex][$i],
        			'galat'                     => $e[$bestBetaIndex][$i],
        			'galat_pemulusan'           => $E[$bestBetaIndex][$i],
        			'galat_pemulusan_absolut'   => $AE[$bestBetaIndex][$i],
        			'alpha'                     => $alpha[$bestBetaIndex][$i],
        			'percentage_error'          => $PE[$bestBetaIndex][$i]
        		];
        	} else {
        		// $nextPeriode = date('W', strtotime("+1 week", strtotime(date($date_to))));
        		$hasil[$i] = [
        			'periode'                   => $periode[$i-1]+1,
        			'aktual'                    => 0,
        			'peramalan'                 => $F[$bestBetaIndex][$i],
        			'galat'                     => 0,
        			'galat_pemulusan'           => 0,
        			'galat_pemulusan_absolut'   => 0,
        			'alpha'                     => $alpha[$bestBetaIndex][$i],
        			'percentage_error'          => 0
        		];
        	}
        }
        return $hasil;
    }

    public function forecastingDes(Request $request)
    {
        $date_from=date('2019-01-02');
        $date_to=date('2019-06-20');
        $data_penjualan=RawDatum::select(DB::raw('WEEK(tgl_transaksi) as minggu,sum(pasir) as pasir,sum(gendol) as gendol,sum(abu) as abu, sum(split2_3) as split2_3, sum(split1_2) as split1_2, sum(lpa) as lpa'))
        ->where('tgl_transaksi','>=',$date_from)
        ->where('tgl_transaksi','<=',$date_to)
        // ->groupby('tgl_transaksi')
        ->groupBy(DB::raw('WEEK(tgl_transaksi)'))
        ->get();
        // dd($data_penjualan);

        $minggu=$this->week_between_two_dates($date_from,$date_to);
        // dd($minggu);

        // $periode=$this->getPeriode($date_from,$date_to);
        $total=$this->getTotal($minggu,$data_penjualan);
        // dd($total);
        $result=$this->des($data_penjualan,$minggu,$total,$date_to);
        // dd($result);
        return \Response::json($result); 
    }

     private function des($data_penjualan,$periode,$total,$date_to)
    {
        // dd($total);
        $no = 0;
        $data = array();
        $jumlah = 0;
        $perediksiData = array();
        $prediksi=array();
        $PE=array();

        $raw=array();

        $m = 0;
        $n = 0;

        foreach($periode as $i => $minggu)
        {
            $data=array(
                'minggu'=>$i+1,
                'total'=>$total[$i],
            );
            array_push($raw,$data);
        }

        $a = 0.5;
        $xt = $raw[0]['total'];
        $s1lalu = 0;
        $s2lalu = 0;
        $priode = 0;

    
        // foreach($raw as $i => $val)
        for($i=0;$i<=count($raw);$i++)
        {
            if($i==0)
            {
                $s1=$raw[$i]['total'];
                $s2=$raw[$i]['total'];
            }
            else
            {
                if($i<count($raw))
                {
                    $s1 = ($a * $raw[$i]['total']) + ((1-$a) * $s1lalu);
                    $s2 = ($a * $s1) + ((1-$a) * $s2lalu);
                }      
            }

            $nilaiA = (2 * $s1) - $s2;
            $nilaiB = ($a / (1-$a)) * ($s1-$s2);

            $prediksi[$i+1] = $nilaiA + $nilaiB;


            if($i==0)
            {
                $PE[$i] =0;
                 $data=array(
                'minggu'=>$periode[$i],
                'aktual'=>$raw[$i]['total'],
                'prediksi'=>0,
                's1'=>$s1,
                's2'=>$s2,
                's1lalu'=>$s1lalu,
                's2lalu'=>$s2lalu,
                'nilaiA'=>$nilaiA,
                'nilaiB'=>0,
                'error'=>$PE[$i],
            );
            }
            else if($i!==0 && $i<count($raw))
            {
                $PE[$i] = $raw[$i]['total'] == 0 ? 0 : abs((($raw[$i]['total'] - $prediksi[$i]) / $raw[$i]['total']) * 100);
                 $data=array(
                'minggu'=>$periode[$i],
                'aktual'=>$raw[$i]['total'],
                'prediksi'=>$prediksi[$i],
                's1'=>$s1,
                's2'=>$s2,
                's1lalu'=>$s1lalu,
                's2lalu'=>$s2lalu,
                'nilaiA'=>$nilaiA,
                'nilaiB'=>$nilaiB,
                'error'=>$PE[$i],
            );
            }
            else
            {
               $PE[$i] =0;
               $data=array(
                'minggu'=>$periode[$i-1]+1,
                'aktual'=>0,
                'prediksi'=>$prediksi[$i],
                's1'=>0,
                's2'=>0,
                's1lalu'=>0,
                's2lalu'=>0,
                'nilaiA'=>0,
                'nilaiB'=>0,
                'error'=>$PE[$i],
            ); 
            }
           
            array_push($perediksiData,$data);
            if (!empty($total[$i])) {
                $xt = $total[$i];
                $s1lalu = $s1;
                $s2lalu = $s2;
            }
        }
   
        return $perediksiData;
    }



    public static function week_between_two_dates($start_date, $end_date)
    {
           $p = new DatePeriod(
            new DateTime($start_date), 
            new DateInterval('P1W'), 
            new DateTime($end_date)
        );
           foreach ($p as $w) {
            $minggu[]=$w->format('W');
        }
        return $minggu;
    }

    public static function getTotal($periode,$data)
    {
        $array = array();
        for($i=0; $i<count($periode); $i++) {
            for($j=0; $j<count($data); $j++) {
            	// dd($data[$j]['minggu']+1);
                if($periode[$i] == ($data[$j]['minggu']+1)){
                    $array[$i] = floatval($data[$j]['abu']);
                    break;
                }else{
                    $array[$i] = 0;
                }
            }
        }
        return $array;
    }

    public static function getPeriode($date_from,$date_to)
    {
        $array= array();
        $date_from = $date_from;
        $i = 0;

        for($a=date('Y-m-d', strtotime($date_from));$a<=date('Y-m-d', strtotime($date_to));$a++)
        {
        	$array[$i] = $date_from;
            $date_from = date('Y-m-d', strtotime("+1 day", strtotime(date($date_from))));
        	$i++;
        }

        // while(date('Y-m-d', strtotime($date_from)) <= date('Y-m-d', strtotime($date_to))) {
        //     $array[$i] = $date_from;
        //     $month = date('Y-m-d', strtotime("+1 day", strtotime(date($date_from))));
        //     $i++;
        // }

        return $array;
    }

}
