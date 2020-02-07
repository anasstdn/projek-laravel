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
        $user=User::find($id);
        return $this->view('form',compact('user'));
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
       ->addColumn('action', function ($data) use ($config) {
        $edit=url("user/".$data->id)."/edit";
         $delete=url("user/".$data->id);
         $reset=url("user/".$data->id)."/reset";
         $content = '';
    
          $content .= "<a onclick='show_modal(\"$edit\")' class='btn btn-xs btn-primary' data-toggle='tooltip' data-original-title='Edit' title='Edit'><i class='entypo-pencil' aria-hidden='true'></i>Edit</a>";
          $content .= " <a onclick='hapus(\"$delete\")' class='btn btn-xs btn-danger' data-toggle='tooltip' data-original-title='Remove' title='Remove'><i class='entypo-trash' aria-hidden='true'></i>Delete</a>";
          $content .= " <a onclick='reset(\"$reset\")' class='btn btn-xs btn-orange' data-toggle='tooltip' data-original-title='Reset Password' title='Reset Password'><i class='entypo-arrows-ccw' aria-hidden='true'></i>Reset Password</a>";
      
      return $content;
  })

       ->make(true);
   }
    
}
