<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Crypt;
use Illuminate\Support\Facades\Mail;
use PDF;
use App\Module;
use App\Role;
use App\Models\BannerImage;
use App\UserSenderId;
//use Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image; 

class AdminController extends Controller
{
    public function status(Request $request){
        if(Session::has('adminSession')){
            if($request->ajax()){
                $data = $request->input();
                if(DB::table($data['table'])->where('id', $data['id'])->update(['status' => $data['status'] ]) ){
                    echo "1";die;
                } else {
                    echo "0";die; 
                }
            }
        }
        else{
            return redirect()->action([AdminController::class, 'login'])->with('flash_message_error', 'Kindly login first');
        }
    }

    public function login(Request $request){
        if(Session::has('adminSession')){
           return redirect()->action([AdminController::class, 'dashboard']);
        }
        if($request->isMethod('post')){
            $this->validate($request, [
                'username'=>'required',
                'password'=>'required'
            ]);
            $userdata = $request->all();
            $userpassword['password'] = md5($userdata['password']);
            $admin  = DB::table('admins')
                    ->where('username', $userdata['username'])
                    ->where('password', $userpassword['password'])
                    ->first();
            if(!empty($admin)){
                if($admin->status==0){
                    return redirect()->action([AdminController::class, 'login'])->with('flash_message_error', 'Your account is temporarily deactivate by System Administrator');
                }
                if(isset($userdata['remember'])){
                    $cookieData = $userdata;
                    unset($userdata['remember']);
                    Cookie::queue('rememberMe', $cookieData,(86400 * 30));
                }
                else{
                    Cookie::queue(Cookie::forget('rememberMe'));
                }
                $adminSession = json_decode( json_encode($admin), true);
                Session::put('adminSession', $adminSession);
                DB::table('admins')
                    ->where('id', Session::get('adminSession')['id'])
                    ->update(['last_login' => date('Y:m:d h:i:s')]);
                return redirect()->action([AdminController::class, 'dashboard']);
            }   
            else{
                return redirect()->action([AdminController::class, 'login'])->with('flash_message_error', 'Your email or password is incorrect, please enter correct value');
            }
        } else {
            if(Cookie::get('rememberMe')){
                $stayTuned = Cookie::get('rememberMe');
                return View::make('admin.admin_login')->with('stayTuned',$stayTuned);
            }
            else{
                return view('admin.admin_login');
            }
        } 
    }
    public function checkAdminEmail(Request $request) {
        $data = $request->all();
        $email = $data['email'];
        $check_email = DB::table('admins')
                       ->where('email', $email)
                       ->count();
        if($check_email == 1) {
            echo '{"valid":true}';die;
        } else {
            echo '{"valid":false}';die;;
        }
    }

    public function dashboard(){
        Session::put('active','dashboard');
        $title = "Dashboard";
        if(Session::get('adminSession')['type'] =="super"){
            $getModules = DB::table('modules')->where('table_name','!=','')->select('id','name','view_route','table_name','icon')->orderBy('sortorder','ASc')->get();
        }else{
            $getAdminModules = DB::table('role_permissions')->where(['role_id'=>Session::get('adminSession')['role_id'],'view_access'=>'1'])->select('module_id')->get();
            $getAdminModules = Arr::flatten(json_decode(json_encode($getAdminModules),true));
            $getModules = DB::table('modules')->whereIn('id',$getAdminModules)->where('table_name','!=','')->select('id','name','view_route','table_name','icon')->orderBy('sortorder','ASc')->get();
        }
        $getModules = json_decode(json_encode($getModules),true);
        foreach ($getModules as $key => $module) {
            if($module['table_name']=="admins"){
                $getModules[$key]['table_count'] = DB::table('admins')->where('type','!=','super')->count();
            }else{
                $getModules[$key]['table_count'] = DB::table($module['table_name'])->count();
            }
        }
        return view('admin.admin_dashboard')->with(compact('title','getModules'));
    }

    public function profile(Request $request){
        if(Session::has('adminSession')){
            Session::put('active','profile');
            $admindata = DB::table('admins')->where('id', Session::get('adminSession')['id'])->first();
            $admindata=json_decode( json_encode($admindata), true);
            $title = "Profile";
            return view('admin.profile', ['admindata'=>$admindata,'title'=>$title]);
        } else{
            return redirect()->action([AdminController::class, 'login'])->with('flash_message_error', 'Please login');
        }
    }

    public function logout(){
        DB::table('admins')->where('id',Session::get('adminSession')['id'])->update(['last_login' => date('Y-m-d h:i:s')]);
        Session::forget('adminSession');
        return redirect()->action([AdminController::class, 'login'])->with('flash_message_success', 'Logged out successfully.');
       
    }

    public function settings(Request $request){
        if(Session::has('adminSession')){
             Session::put('active','settings');
            if($request->isMethod('post')){
                $data = $request->all();
                $this->validate($request, [
                    'name'=>'required',
                    'username'=>'required',
                    'email'=>'required|email',
            ]);
            $update_data = DB::table('admins')
                ->where('id', Session::get('adminSession')['id'])
                ->update([
                    'name'=>$data['name'],
                    'username'=>$data['username'],
                    'email'=>$data['email'],
                    'mobile'=>$data['mobile']]);             
            if($update_data){
                Session::put('adminSession.username', $data['username']);
                return redirect()->action([AdminController::class, 'profile'])->with('flash_message_success', 'Profile has been updated successfully');        
            } else {
                return redirect()->action([AdminController::class, 'profile'])->with('flash_message_success', 'Profile has been updated successfully');
                } 
            }
            else{
                $admindata = DB::table('admins')->where('id', Session::get('adminSession')['id'])->first();
                $admindata =json_decode( json_encode($admindata), true);
                $title = "Account Settings";
                return view('admin.admin_accountSettings', ['admindata'=>$admindata,'title'=>$title]); 
            }
        }
    }

    public function changeAdminLogo(Request $request){
        $admindata = Session::get('adminSession');
        $admindata =json_decode( json_encode($admindata), true);
        $image=$_FILES;
        if($image['image']['error']==0){
            $imgName = pathinfo($_FILES['image']['name']);
            $ext = $imgName['extension'];
            $NewImageName = rand(4,10000);
            $destination = base_path() . '/public/images/AdminImages/';
            if(move_uploaded_file($image['image']['tmp_name'],$destination.$NewImageName.".".$ext)){
                if(file_exists($destination.Session::get('adminSession')['image']) && !empty(Session::get('adminSession')['image'])){
                    
                    unlink($destination.Session::get('adminSession')['image']);
                }
                Session::put('adminSession.image', $NewImageName.".".$ext);  
                $image =DB::table('admins')
                ->where('id', Session::get('adminSession')['id'])
                ->update(['image' => $NewImageName.".".$ext]);
                if(!empty($image)){
                   return redirect()->action([AdminController::class, 'profile'])->with('flash_message_success', 'Image has been uploaded successfully');         
                } else {
                   return redirect('/admin/settings/#tab_1_2')->with('flash_message_error', 'You have not Select any image'); 
                }
            }
        }
         else {
            return redirect('/admin/settings/#tab_1_2')->with('flash_message_error', 'You have not Select any image'); 
        }
    }
    public function checkAdminPassword(Request $request) {
        $data = $request->all();
        $password = $data['password'];
        $count = DB::table('admins')
                        ->where('email',Session::get('adminSession')['email'])
                       ->where('password', md5($password))
                       ->count();
        if($count == 1) {
            echo '{"valid":true}';die;
        } else {
            echo '{"valid":false}';die;;
        }
    }
    public function changeAdminPassword(Request $request){
        if(Session::has('adminSession')){
            if($request->isMethod('post')){
                $data = $request->input();
                if(!empty($data)){
                    if(Session::get('adminSession')['password'] == md5($data['password'])){
                        DB::table('admins')
                            ->where('id', Session::get('adminSession')['id'])
                            ->update(['password' => md5($data['new_password'])]);
                        Session::put('adminSession.password', md5($data['new_password']));  
                        return redirect('/admin/settings/')->with('flash_message_success', 'Password has been updated successfully');   
                    } else {
                        return redirect('/admin/settings/#tab_1_3')->with('flash_message_error', 'please enter correct current password'); 
                    }
                }
            }
        }
    }
    
    public function common_delete(Request $request, $table, $id) {
        if(Session::has('adminSession')){
            if(!empty($table) && !empty($id)){
                $id=convert_uudecode(base64_decode($id));
                if(DB::table($table)->where('id', $id)->delete()) {
                    return redirect()->back()->with('flash_message_success', 'Record deleted successfully');
                } else {
                    return redirect()->back()->with('flash_message_error', 'Some error occured, please try again later');
                }
            }
        } else {
            return redirect()->action([AdminController::class, 'login'])->with('flash_message_error', 'Kindly login first');
        }    
    }

    public function subadmins(Request $Request){
        Session::put('active',3); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('admins')->where('type','!=','super');
            if(!empty($data['name'])){
                $querys = $querys->where('name','like','%'.$data['name'].'%');
            }
            if(!empty($data['username'])){
                $querys = $querys->where('username','like','%'.$data['username'].'%');
            }
            if(!empty($data['email'])){
                $querys = $querys->where('email','like','%'.$data['email'].'%');
            }
            $querys = $querys->OrderBy('id','DESC');
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                    ->skip($iDisplayStart)->take($iDisplayLength)
                    ->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $subadmin){
                $id= base64_encode(convert_uuencode($subadmin['id'])); 
                $checked='';
                if($subadmin['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $actionValues='<a title="Edit Subadmin" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-subadmin/'.$subadmin['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $subadmin['name'],
                    $subadmin['username'],
                    $subadmin['email'],
                    $subadmin['mobile'],
                    '<div  id="'.$subadmin['id'].'" rel="admins" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Permissions";
        return View::make('admin.subadmins.subadmins')->with(compact('title'));
    }

    public function addeditSubadmin(Request $request,$id=null){
        Session::put('active',3); 
        if($id ==""){
            $message ='SubAdmin has been added successfully!.';
            $title = "Add SubAdmin"; 
            $admin = new Admin;
            $admindata = array();
            $getunitAccessids = array();
        }else{
            $message = 'SubAdmin has been updated successfully!.';
            $title = "Edit SubAdmin"; 
            $admin = Admin::find($id);
            $admindata = json_decode(json_encode($admin),true);
        }
        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);
            foreach ($data as $key => $value) {
                if($key != "password"){
                    $admin->$key = $value;
                }
            }
            if(empty($admindata)){
                $admin->password = md5($data['password']);
            }
            $admin->type="subadmin";
            $admin->save();
            return redirect()->action([AdminController::class, 'subadmins'])->with('flash_message_success',$message);
        }
        $roles = Role::where('status',1)->get();
        return view('admin.subadmins.add-edit-subadmin')->with(compact('title','admindata','roles'));
    }

    public function checkAdminUsername(Request $request) {
        $data = $request->all();
        $username = $data['username'];
        $checkadmin = DB::table('admins')
                       ->where('username', $username)
                       ->count();
        if($checkadmin == 1) {
             echo '{"valid":false}';die;;
        }else {
            echo '{"valid":true}';die;
        }
    }

    public function bannerImages(Request $Request){
        Session::put('active',11); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('banner_images');
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('id','DESC')
                ->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=0;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $image){
                $id= base64_encode(convert_uuencode($image['id'])); 
                $checked='';
                if($image['status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
                $actionValues='<a title="Edit Banner Image" class="btn btn-sm green margin-top-10" href="'.url('admin/add-edit-banner-image/'.$image['id']).'"> <i class="fa fa-edit"></i></a> 
                    <a  title="Delete Banner Image"  class="btn btn-sm red margin-top-10 delete"  onclick="return ConfirmDelete()" href="'.url('admin/delete-banner-image/'.$image['id']).'"> <i class="fa fa-times"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array(     
                $num,
                '<img style="width:250px;" src="'.url('images/banner/'.$image['image']).'"/>',
                $image['type'],
                '<div  id="'.$image['id'].'" rel="banner_images" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',  
                $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Banner Images";
        return View::make('admin.banners.banners-images')->with(compact('title'));
    }

    public function addEditBannerImage(Request $request, $id=null){
        Session::put('active',10); 
        if($id ==""){
            $message = "Banner Image has been added successfully!";
            $banner = new BannerImage();
            $bannerdata = array();
            $title = "Add Banner Image";
        }else{
            $message = "Banner Image has been updated successfully!";
            $banner = BannerImage::find($id);
            $bannerdata = json_decode(json_encode($banner),true);
            $title = "Edit Banner Image";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $banner->type = $data['type'];
            $banner->description = $data['description'];
            $banner->status = 1;
            $banner->sort = $data['sort'];
            if($request->hasFile('image')){
                if ($request->file('image')->isValid()) {
                    $file = $request->file('image');
                    $img = Image::make($file);
                    $destination = public_path('/images/banner/');
                    if(!empty($bannerdata) &&  $bannerdata['image'] !="" && file_exists($destination.$bannerdata['image'])){
                        unlink($destination.$bannerdata['image']);
                    }
                    $ext = $file->getClientOriginalExtension();
                    $mainFilename =Str::random(5).date('h-i-s').".".$ext;
                    $img->save($destination.$mainFilename);
                    $banner->image= $mainFilename;
                }
            }
            $banner->save();
            return redirect()->action([AdminController::class, 'bannerImages'])->with('flash_message_success',$message);
        }
        return view('admin.banners.add-edit-banner')->with(compact('title','bannerdata'));

    }

    public function deleteBannerImage($id){
        $banner = BannerImage::find($id);
        $destination = public_path('/images/banner/');
        if($banner->image !="" && file_exists($destination.$banner->image)){
            unlink($destination.$banner->image);
        }
        $banner->delete();
        return redirect()->action([AdminController::class, 'bannerImages'])->with('flash_message_success','Record has been deleted successfully!');
    }

    public function senderids(Request $Request){
        Session::put('active',20); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = UserSenderId::with('user');
            /*if(!empty($data['name'])){
                $querys = $querys->where('name','like','%'.$data['name'].'%');
            }*/
            $querys = $querys->OrderBy('id','DESC');
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                    ->skip($iDisplayStart)->take($iDisplayLength)
                    ->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $senderid){
                if($senderid['status'] ==1){
                    $actionValues ='Approved';
                }else{
                    $actionValues=' <a title="Approve Sender Id" class="btn btn-sm green margin-top-10" href="'.url('admin/approve-sender-id/'.$senderid['id']).'"> <i class="fa fa-hand-o-right"></i>
                        </a>';
                }
                $num = ++$i;
                $records["data"][] = array(     
                    $senderid['user']['name'],
                    $senderid['sample1'],
                    $senderid['sample2'],
                    $senderid['sample3'],
                    $senderid['business_name'],
                    $senderid['website_url'],
                    $senderid['email'], 
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Sender Ids";
        return View::make('admin.sms-campgains.sender-ids')->with(compact('title'));
    }

    public function approveSenderId(Request $request,$senderid){
        $title="Approve Sender Id";
        $details = UserSenderId::where('id',$senderid)->first();
        if($request->isMethod('post')){
            //MXMCMS
            $data = $request->all();
            //Update Sender id Table
            UserSenderId::where('id',$senderid)->update(['sender_id'=>$data['sender_id'],'status'=>1]);
            $senderdetails = UserSenderId::find($senderid);
            //send email to user
            if($this->mode=="live"){
                $email = $details->email;
                $messageData = [
                    'senderdetails' => $senderdetails,
                    'data' =>$data
                ];
                Mail::send('emails.send-senderid-email', $messageData, function($message) use ($email){
                    $message->to($email)->subject('Sender Id Details');
                });
            }
            return redirect()->action([AdminController::class, 'senderids'])->with('flash_message_success','Sender id has been approved successfully');
        }
        return view('admin.sms-campgains.approve-sender-id')->with(compact('title','details'));
    }
}

