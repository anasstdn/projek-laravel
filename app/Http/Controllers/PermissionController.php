<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DataTables;
use Carbon\Carbon;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public $viewDir = "permission";

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
         $GLOBALS['nomor']=\Request::input('start',1)+1;
           $dataList = Permission::select('*');
           if (request()->get('status') == 'trash') {
               $dataList->onlyTrashed();
           }
           return Datatables::of($dataList)
               ->addColumn('nomor',function($kategori){
                   return $GLOBALS['nomor']++;
               })

               ->addColumn('name',function($data){
                if(isset($data->name)){
                  return $data->name;
                }else{
                  return null;
                }
              })

               ->addColumn('display_name',function($data){
                if(isset($data->display_name)){
                  return $data->display_name;
                }else{
                  return null;
                }
              })

                 ->addColumn('description',function($data){
                if(isset($data->description)){
                  return $data->description;
                }else{
                  return null;
                }
              })
   // ->addColumn('action', function ($data) {
               //     $edit=url("permission/".$data->pk())."/edit";
               //     $delete=url("permission/".$data->pk());
               //   $content = '';
               //    $content .= "<a onclick='show_modal(\"$edit\")' class='btn btn-sm btn-icon btn-pure btn-default on-default edit-row ' data-toggle='tooltip' data-original-title='Edit'><i class='icon md-edit' aria-hidden='true'></i></a>";
               //    $content .= " <a onclick='hapus(\"$delete\")' class='btn btn-sm btn-icon btn-pure btn-default on-default remove-row' data-toggle='tooltip' data-original-title='Remove'><i class='icon md-delete' aria-hidden='true'></i></a>";

               //     return $content;
               // })
               ->make(true);
       }
    
}
