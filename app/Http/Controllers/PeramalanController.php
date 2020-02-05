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

    public function index()
    {
    	 return view('forecast/index');
    }

    public function forecasting()
    {
    	$date_from=date('2019-01-02');
    	$date_to=date('2019-01-20');
    	$data_penjualan=RawDatum::select(DB::raw('tgl_transaksi,sum(pasir) as pasir,sum(gendol) as gendol,sum(abu) as abu, sum(split2_3) as split2_3, sum(split1_2) as split1_2, sum(lpa) as lpa'))
    	->where('tgl_transaksi','>=',$date_from)
    	->where('tgl_transaksi','<=',$date_to)
    	->groupby('tgl_transaksi')
    	->get();

    	$periode=$this->getPeriode($date_from,$date_to);
    	$total=$this->getTotal($periode,$data_penjualan);
    	$result=$this->arrses($data_penjualan,$periode,$total,$date_to);
    	dd($result);
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
        		$nextPeriode = date('Y-m-d', strtotime("+1 day", strtotime(date($date_to))));
        		$hasil[$i] = [
        			'periode'                   => $nextPeriode,
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

    public static function getTotal($periode,$data)
    {
        $array = array();
        for($i=0; $i<count($periode); $i++) {
            for($j=0; $j<count($data); $j++) {
            	// dd($data[$j]['tgl_transaksi']);
                if($periode[$i] == Carbon::parse($data[$j]['tgl_transaksi'])->format('Y-m-d')){
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

    private function des()
    {

    }
}
