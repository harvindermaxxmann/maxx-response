<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use App\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Crypt;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{
    //
    public function users(Request $Request){
        Session::put('active',1); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('users');
            if(!empty($data['name'])){
                $querys = $querys->where('name','like','%'.$data['name'].'%');
            }
            if(!empty($data['email'])){
                $querys = $querys->where('email','like','%'.$data['email'].'%');
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
            foreach($querys as $user){
                $checked='';
                if($user['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $actionValues='
                	<a title="Change Password" data-userid="'.$user['id'].'" class="btn btn-sm yellow margin-top-10 editPassword" href="javascript:;"> <i class="fa fa-clock-o"></i>
                    </a>
                    <a title="Edit User" class="btn btn-sm green margin-top-10" href="'.url('admin/add-edit-user/'.$user['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array(     
                    $user['id'],
                    $user['name'],
                    $user['email'],
                    '<div  id='.$user['id'].' rel=users class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Users";
        return View::make('admin.users.users')->with(compact('title'));
    }

    public function addEditUser(Request $request,$id=null){
    	if($id==""){
    		$title = "Add User";
    		$message = "User has been added successfully!.";
    		$userdata = array();
    		$user = new User;
    	}else{
    		$title = "Edit User";
    		$message = "User has been updated successfully!.";
    		$user = User::find($id);
    		$userdata = json_decode(json_encode($user),true);
    	}
        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);
            $user->name = $data['name'];
            if(isset($data['email'])){
                $user->email = $data['email'];
            }
            if(isset($data['password'])){
                $user->password = bcrypt($data['password']);
            }
            if(!$userdata){
                $user->status = 1;
            }
            $user->save();
            return Redirect()->action([UsersController::class, 'users'])->with('flash_message_success',$message);
        }
    	return view('admin.users.add-edit-user')->with(compact('title','userdata'));
    }

    public function changeUserPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $userdata = User::where('id',$data['id'])->select('id','password')->first();
            $userdata =json_decode(json_encode($userdata),true);
            echo json_encode($userdata); die;
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $user = User::find($data['id']);
            $user->password = bcrypt($data['password']);
            $user->save();
            return redirect()->back()->with('flash_message_success', 'Password has been Updated Successfully!.');
        }
    } 

    public function CheckUserEmail(Request $request){
        $data = $request->all();
        $userEmail = $data['email'];
        $count = DB::table('users')
                       ->where('email', $userEmail)
                       ->count();
        if($count == 1) {
            echo '{"valid":false}';die;;
        }else {
            echo '{"valid":true}';die;
        }
    }
}
