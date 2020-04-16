<?php

namespace App\Http\Controllers;

use App\Models\RawDatum;
use Illuminate\Http\Request;
use DB;
use Excel;
use Carbon\Carbon;
date_default_timezone_set(setting('timezone'));

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $viewDir = "data";

    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('permission:create-data');
       $this->middleware('permission:read-data');
       $this->middleware('permission:update-data');
       $this->middleware('permission:delete-data');
   }


   public function index()
   {
        //
    return $this->view('index');
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function downloadData($type)
    {
        $data = RawDatum::get()->toArray();

        return Excel::create('excel_data', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    public function importData(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'import_file' => 'required'
        ]);

        $path = $request->file('import_file')->getRealPath();
        $data = Excel::load($path)->toArray();
        // dd($data[0]); 
        if(count($data[0])>0){
            RawDatum::truncate();
            foreach ($data[0] as $key => $value) {
              $arr[] = ['tgl_transaksi' => Carbon::parse($value['tgl_transaksi'])->format('Y-m-d'), 'no_nota' => $value['no_nota'],'pasir'=>$value['pasir'],'gendol'=>$value['gendol'],'abu'=>$value['abu'],'split2_3'=>$value['split2_3'],'split1_2'=>$value['split1_2'],'lpa'=>$value['lpa'],'campur'=>$value['campur'],'created_at'=>date('Y-m-d H:i:s')];  
          }

          if(!empty($arr)){
            RawDatum::insert($arr);
        }
    }

    return back()->with('success', 'Insert Record successfully.');
}

protected function view($view, $data = [])
{
   return view($this->viewDir.".".$view, $data);
}


public function create()
{
        //
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
