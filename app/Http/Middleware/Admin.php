<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Closure;
use Illuminate\Support\Facades\Session;
use App\RolePermission;
use App\Module;
use Illuminate\Support\Facades\Request;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(Session::has('adminSession'))){
            return redirect()->action([AdminController::class, 'login'])->with('flash_message_error', 'Please Login.');
        }else{
            if(Session::get('adminSession')['type']!="super"){
                if(!empty(Request::getQueryString())){
                    $currentUrl = Route::getFacadeRoot()->current()->uri().'?'.Request::getQueryString();
                }else{
                    $currentUrl = Route::getFacadeRoot()->current()->uri();
                }
                $moduleDetail = Module::orwhere('view_route',$currentUrl)->orwhere('edit_route',$currentUrl)->orwhere('delete_route',$currentUrl)->first();
                $moduleDetail = json_decode(json_encode($moduleDetail),true);
                $getAdminRoledetail = RolePermission::where(['role_id'=>Session::get('adminSession')['role_id'],'module_id' => $moduleDetail['id']])->first();
                $getAdminRoledetail = json_decode(json_encode($getAdminRoledetail),true);
                if(!empty($getAdminRoledetail) && !empty($moduleDetail)){
                    if($currentUrl == $moduleDetail['view_route'] && $getAdminRoledetail['view_access'] == 0){
                        return redirect()->action([AdminController::class, 'dashboard'])->with('flash_message_error','You have no right to access this functionality');
                    }
                    if($currentUrl == $moduleDetail['edit_route'] && $getAdminRoledetail['edit_access'] == 0){
                        return redirect()->action([AdminController::class, 'dashboard'])->with('flash_message_error','You have no right to access this functionality');
                    }
                    if($currentUrl == $moduleDetail['delete_route'] && $getAdminRoledetail['delete_access'] == 0){
                        return redirect()->action([AdminController::class, 'dashboard'])->with('flash_message_error','You have no right to access this functionality');
                    }
                }
            }
        }
        return $next($request);
    }
}
