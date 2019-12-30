<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $viewDir = "user";

    protected function view($view, $data = [])
    {
     return view($this->viewDir.".".$view, $data);
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


    public function loadData()
    {
     $config = config('laratrust_seeder.list_role');
     $GLOBALS['nomor']=\Request::input('start',1)+1;
     $dataList = User::select('*');
     // dd($dataList->get());
     if (request()->get('status') == 'trash') {
         $dataList->onlyTrashed();
     }
     return DataTables::of($dataList)
     ->addColumn('nomor',function($kategori){
         return $GLOBALS['nomor']++;
     })
     ->addColumn('username',function($data){
      if(isset($data->username)){
        return $data->username;
    }else{
        return null;
    }
})

 ->addColumn('name',function($data){
      if(isset($data->name)){
        return $data->name;
    }else{
        return null;
    }
})

 ->addColumn('email',function($data){
      if(isset($data->email)){
        return $data->email;
    }else{
        return null;
    }
})

//  ->addColumn('verified',function($data){
//       if(isset($data->verified)){
//         return $data->verified;
//     }else{
//         return null;
//     }
// })

     ->addColumn('verified', function ($data) {
         if(isset($data->verified))
         {
            return array('id'=>$data->id,'status_aktif'=>$data->verified);
        }else
        {
            return null;
        }

    })

     ->make(true);
 }
    
}
