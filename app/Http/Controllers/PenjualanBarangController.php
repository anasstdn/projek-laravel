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

class PenjualanBarangController extends Controller
{
//
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
		return $this->view('index');
	}
}
