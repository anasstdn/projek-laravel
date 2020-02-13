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
        $this->middleware('permission:read-user', ['only' => ['index','loadData']]);
        $this->middleware('permission:create-user', ['only' => ['create','sendData','cekUsername','cekEmail']]);
        $this->middleware('permission:update-user', ['only' => ['edit','sendData','cekUsername','cekEmail','reset']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy','delete']]);
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
      $role=\App\Role::select(\DB::raw("*"))->get();
      return $this->view('form',compact('role'));
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
        $role=\App\Role::select(\DB::raw("*"))->get();
        return $this->view('form',compact('user','role'));
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
      $data=array(
        'id'=>$id,
        'url'=>url('user/delete'),
      );
      return view('delete-view',$data);
    }

    public function delete(Request $request)
    {
      $all_data=$request->all();
      // dd($all_data);
      $user=User::find($all_data['id']);
      $act=false;
      try {
       $act=$user->forceDelete();
       $delRoleUser=RoleUser::where('user_id',$all_data['id'])->forceDelete();
     } catch (\Exception $e) {
       $user=User::find($user->pk());
       $act=$user->delete();
       $delRoleUser=RoleUser::where('user_id',$all_data['id'])->delete();
     }

       if($act==true && $delRoleUser==true)
       {
          $data=array(
            'status'=>true,
            'msg'=>'Data berhasil dihapus'
          );
       }
       else
       {
          $data=array(
            'status'=>false,
            'msg'=>'Data gagal dihapus'
          );
       }

       return \Response::json($data);
   }

   public function reset(Request $request, $kode)
   {
      $user=User::find($kode);

      $dat=array(
        'password'=>bcrypt('12345678'),
      );

      $reset=$user->update($dat);

      if($reset==true)
      {
          $data=array('status'=>true,
            'msg'=>'Password berhasil direset'
        );
      }
      else
      {
          $data=array('status'=>false,
            'msg'=>'Password gagal direset'
        );
      }
      echo json_encode($data);
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
         $delete=url("user/".$data->id)."/destroy";
         $reset=url("user/".$data->id)."/reset";
         $content = '';
    
          $content .= "<a onclick='show_modal(\"$edit\")' class='btn btn-xs btn-primary' data-toggle='tooltip' data-original-title='Edit' title='Edit'><i class='entypo-pencil' aria-hidden='true'></i>Edit</a>";
          $content .= " <a onclick='delete_data(\"$delete\")' class='btn btn-xs btn-danger' data-toggle='tooltip' data-original-title='Remove' title='Remove'><i class='entypo-trash' aria-hidden='true'></i>Delete</a>";
          $content .= " <a onclick='reset(\"$reset\")' class='btn btn-xs btn-orange' data-toggle='tooltip' data-original-title='Reset Password' title='Reset Password'><i class='entypo-arrows-ccw' aria-hidden='true'></i>Reset Password</a>";
      
      return $content;
  })

       ->make(true);
   }

   public function cekUsername(Request $request)
   {
    $all_data=$request->all();
    // dd($all_data['mode']);
    switch($all_data['mode'])
    {
      case 'add':
      $cek_username=User::where('username','like','%'.$all_data['username'].'%')->first();
      break;
      case 'edit':
      $cek_username=User::where(function($q) use ($all_data){
        $q->where('username','like','%'.$all_data['username'].'%')
        ->where('id','<>',$all_data['id']);
      })
      ->first();
      break;
    }
    // dd($cek_username);
    if($cek_username==true)
    {
      $data=array(
        'status'=>false,
        'msg'=>'Username sudah digunakan user lain'
      );
    }
    else
    {
      $data=array('status'=>true,
      'msg'=>'Username tersedia'
    );
    }

    return \Response::json($data);
   }

    public function cekEmail(Request $request)
   {
    $all_data=$request->all();
    // dd($all_data['mode']);
    switch($all_data['mode'])
    {
      case 'add':
      $cek_username=User::where('email','like','%'.$all_data['email'].'%')->first();
      break;
      case 'edit':
      $cek_username=User::where(function($q) use ($all_data){
        $q->where('email','like','%'.$all_data['email'].'%')
        ->where('id','<>',$all_data['id']);
      })
      ->first();
      break;
    }
    // dd($cek_username);
    if($cek_username==true)
    {
      $data=array(
        'status'=>false,
        'msg'=>'Email sudah digunakan user lain'
      );
    }
    else
    {
      $data=array('status'=>true,
      'msg'=>'Email tersedia'
    );
    }

    return \Response::json($data);
   }

   public function sendData(Request $request)
   {
    $all_data=$request->all();
    // dd($all_data);
    DB::beginTransaction();
    try {
      switch($all_data['mode'])
      {
        case 'add':
            $user  = array(
             'name' =>$all_data['nama'] ,
             'username' =>$all_data['username'] ,
             'email' =>$all_data['email'] ,
             'password' =>bcrypt($all_data['password']) ,
                   // 'jenis_kelamin' =>isset($all_data['jenis_kelamin'])?$all_data['jenis_kelamin']:'' ,
             'jenis_kelamin' =>'L' ,
             'verified'=>$all_data['verified'],
           );

            $user=User::create($user);

            $role=array(
             'role_id'=>intval($all_data['roles']),
             'user_id'=>$user->id,
             'user_type'=>'App\User'
            );

            // dd($role);

            $roleUser = DB::table('role_user')->insert($role);

            if($user==true && $roleUser==true)
            {
              $data=array(
                'status'=>true,
                'msg'=>'Data berhasil disimpan'
              );
            }
            else
            {
               $data=array(
                'status'=>false,
                'msg'=>'Data gagal disimpan'
              );
            }
        break;
        case 'edit':
            $user=User::find($all_data['id']);
            // dd($all_data);
            if(!empty($all_data['password']))
            {
                $dataUser  = array(
                 'name' =>$all_data['nama'] ,
                 'username' =>$all_data['username'] ,
                 'email' =>$all_data['email'] ,
                 'password' =>bcrypt($all_data['password']) ,
                       // 'jenis_kelamin' =>isset($all_data['jenis_kelamin'])?$all_data['jenis_kelamin']:'' ,
                 'jenis_kelamin' =>'L' ,
                 'verified'=>$all_data['verified'],
               );
            }
            else
            {
                $dataUser  = array(
                 'name' =>$all_data['nama'] ,
                 'username' =>$all_data['username'] ,
                 'email' =>$all_data['email'] ,
                 // 'password' =>bcrypt($all_data['password']) ,
                       // 'jenis_kelamin' =>isset($all_data['jenis_kelamin'])?$all_data['jenis_kelamin']:'' ,
                 'jenis_kelamin' =>'L' ,
                 'verified'=>$all_data['verified'],
               );
            }
            $act=$user->update($dataUser);

            $delRoleUser=RoleUser::where('user_id',$all_data['id'])->forceDelete();

            $role=array(
             'role_id'=>intval($all_data['roles']),
             'user_id'=>$user->id,
             'user_type'=>'App\User'
            );

            // dd($role);

            $roleUser = DB::table('role_user')->insert($role);

            if($user==true && $roleUser==true)
            {
              $data=array(
                'status'=>true,
                'msg'=>'Data berhasil diupdate'
              );
            }
            else
            {
               $data=array(
                'status'=>false,
                'msg'=>'Data gagal disimpan'
              );
            }
        break;
      }
     
    } catch (Exception $e) {
      echo 'Message' .$e->getMessage();
      DB::rollback();
    }
    DB::commit();
    return \Response::json($data);
  }
    
}
