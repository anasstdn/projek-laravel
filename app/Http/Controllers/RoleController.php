<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{
    //
    public $viewDir = "role";
    public $breadcrumbs = array(
         'permissions'=>array('title'=>'Roles','link'=>"#",'active'=>false,'display'=>true),
       );

    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('permission:read-role', ['only' => ['index','loadData']]);
    	$this->middleware('permission:create-role', ['only' => ['hakmenus','createpermissionrole']]);
    	$this->middleware('permission:update-role', ['only' => ['hakmenus','createpermissionrole']]);
    }

    public function index()
    {
    	return $this->view( "index");
    }

    protected function view($view, $data = [])
    {
    	return view($this->viewDir.".".$view, $data);
    }

     public function hakmenus($role_id)
       {
        $send['role_id'] = $role_id;
        $send['role'] = new Role;

        // $pemesan=Stok::select(\DB::raw($selected_field));
        $send['permissionmenu']=$permissionmenu= Permission::select(\DB::raw('permissions.name as nama_perm,permissions.id as id_perm'))
        // ->where('menus.url','!=',null)
        // ->join('permission_role','permission_role.permission_id','=','permissions.id')
        ->get();

         return $this->view( "edit-permission",$send);
       }

       public function createpermissionrole(Request $request )
       {
       	// dd($request->all());
       	$roleId = ($request->input('role_id'));
       	// dd($roleId);
       	$all_data = $request->all();
           // dd($all_data);
       	$permisi =  \DB::table('permission_role')->where('role_id',$roleId)->delete();
     // dd($permisi);
       	foreach ($all_data['role'] as $num => $row){
       		if(isset($row['flag_aktif']) ){
                // $role = Role::find($roleId);
       			$datarole = array(
       				'permission_id'=>$row['id_perm'],
       				'role_id'=>$roleId,

       			);
            // dd($datarole);
       			// $permissionmenu = PermissionRole::create($datarole);
       			$permissionmenu = DB::table('permission_role')->insert($datarole);
              // dd($permissionmenu->role_id);
       		}


       	}
       	\Artisan::call('cache:clear');

            // dd($all_data);
       	message($permissionmenu,'Data Hak Akses berhasil ditambahkan','Data Hak Akses berhasil ditambahkan');
       	return redirect('role');
       }

    public function loadData()
    {
    	$GLOBALS['nomor']=\Request::input('start',1)+1;
    	$dataList = Role::select('*');
    	if (request()->get('status') == 'trash') {
    		$dataList->onlyTrashed();
    	}
    	return Datatables::of($dataList)
    	->addColumn('nomor',function($kategori){
    		return $GLOBALS['nomor']++;
    	})
            //    ->addColumn('action', function ($data) {
            //        $edit=url("role/".$data->pk())."/edit";
            //        $delete=url("role/".$data->pk());
            //      $content = '';
            //       $content .= "<a onclick='show_modal(\"$edit\")' class='btn btn-sm btn-icon btn-pure btn-default on-default edit-row ' data-toggle='tooltip' data-original-title='Edit'><i class='icon md-edit' aria-hidden='true'></i></a>";
            //       $content .= " <a onclick='hapus(\"$delete\")' class='btn btn-sm btn-icon btn-pure btn-default on-default remove-row' data-toggle='tooltip' data-original-title='Remove'><i class='icon md-delete' aria-hidden='true'></i></a>";

            //        return $content;
            //    })

    	->addColumn('action', function ($data) {

    		$content = '';
    		$content .= "<a href='permission-role/get/".$data->id."/menu' class='btn btn-sm btn-primary' >Access Permission</a>";

    		return $content;
    	})
    	->make(true);
    }
}
