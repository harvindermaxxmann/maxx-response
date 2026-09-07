<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use App\Role;
use App\RolePermission;
use App\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Crypt;
use Illuminate\Support\Facades\Hash;

class RolesController extends Controller
{
    //
    public function roles(Request $Request){
        Session::put('active',2); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('roles');
            if(!empty($data['role_name'])){
                $querys = $querys->where('role_name','like','%'.$data['role_name'].'%');
            }
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            
            $querys =  $querys->where($conditions)
                	->skip($iDisplayStart)->take($iDisplayLength)
                	->OrderBy('id','Desc')
                	->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $role){
                $checked='';
                if($role['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $actionValues='
                    <a title="Edit Role" class="btn btn-sm green margin-top-10" href="'.url('admin/add-edit-role/'.$role['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array( 
                	$num,    
                    $role['role_name'],
                    '<div  id='.$role['id'].' rel=roles class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Manage Roles";
        return View::make('admin.roles.roles')->with(compact('title'));
    }

    public function addEditRole(Request $request,$roleid=null){
    	$title ="Manage Roles";
    	$getModules = Module::where('shown_in_roles','1')->get();
        $getModules = json_decode(json_encode($getModules),true);
        if($roleid){
        	$role = Role::find($roleid);
        	$roledata = json_decode(json_encode($role),true);
        	$message="Role has been updated successfully";
        }else{
        	$role = new Role;
        	$roledata = array();
        	$message="Role has been added successfully";
        }
        if($request->isMethod('post')){
        	$data =$request->all();
        	//echo "<pre>"; print_r($data); die;
        	$role->role_name = $data['role_name'];
        	$role->status = 1;
        	$role->save();
        	if(!$roledata){
        		$roleid = DB::getPdo()->lastInsertId();
        	}
        	foreach ($data['module_id'] as $mkey => $module) {
                $checkIfExists = RolePermission::where(['role_id'=>$roleid,'module_id'=>$mkey])->first();
                if(!empty($checkIfExists)){
                    $roleperm = RolePermission::find($checkIfExists->id);
                }else{
                    $roleperm = new RolePermission;
                    $roleperm->role_id = $roleid;
                    $roleperm->module_id = $mkey;
                }
                if(is_array($data['module_id'][$mkey])){
                    foreach ($data['module_id'][$mkey] as $akey => $value) {
                        if(isset($data['module_id'][$mkey]['view_access'])){
                            $roleperm->$akey = 1;
                        }else{
                            $roleperm->view_access = 0;
                        }
                        if(isset($data['module_id'][$mkey]['edit_access'])){
                            $roleperm->$akey = 1;
                        }else{
                            $roleperm->edit_access = 0;
                        }
                        if(isset($data['module_id'][$mkey]['delete_access'])){
                            $roleperm->$akey = 1;
                        }else{
                            $roleperm->delete_access = 0;
                        }
                    }
                }else{
                    $roleperm->view_access = 0;
                    $roleperm->edit_access = 0;
                    $roleperm->delete_access = 0;
                }
                $roleperm->save();
            }
            return redirect()->action([RolesController::class, 'roles'])->with('flash_message_success',$message);
        }
        return view('admin.roles.add-edit-role')->with(compact('title','getModules','roleid','roledata'));
    }
}
