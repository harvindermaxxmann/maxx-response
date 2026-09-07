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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Package;
use App\Order;
use App\BannerImage;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    //
    public function sendtestemail(){
        $email = "kunalmahajan710@gmail.com";
        $messageData = [];
        Mail::send('emails.send-test-email', $messageData, function($message) use ($email){
			
			$message->from('marketing@maxxresponse.com');
		
            $message->to($email)->subject('Test Email');
        });
        echo "email send successfully";
    }


    public function index(){
        Session::forget('menuactive');
    	$title ="Home";
        $bannerImages = DB::table('banner_images')->where('status',1)->where('type','home')->get();
        $bannerImages = json_decode(json_encode($bannerImages),true);
    	return view('front.index')->with(compact('title','bannerImages'));
    }

    public function login(Request $request){
        Session::put('menuactive','signin');
        if(Auth::check()){
            return redirect()->action([DashboardController::class, 'dashboard']);
        }
    	if($request->isMethod('post')){
    		$rules = [
                'email' => 'bail|email|required',
                'password' => 'bail|required'
            ];
            $customMessages = [
            	//Add custom messages
            ];
            $this->validate($request, $rules, $customMessages);
            $data =  $request->all();
            //echo "<pre>"; print_r($data); die;
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                if(Auth::user()->status==0){
                    Auth::logout();
                    return redirect()->action([IndexController::class, 'login'])->with('flash_message_error','We are sorry!.Your account is temporarily deactivated.');
                }
                if(isset($data['userremember'])){
                    //echo "hello"; die;
                    Cookie::queue('rememberMe', $data['userremember'],(86400 * 30));
                    Cookie::queue('rememberEmail', Auth::user()->email,(86400 * 30));
                    Cookie::queue('rememberPassword', $data['password'],(86400 * 30));
                }else{
                    Cookie::queue(Cookie::forget('rememberMe'));
                    Cookie::queue(Cookie::forget('rememberEmail'));
                    Cookie::queue(Cookie::forget('rememberPassword'));
                }
                return redirect()->action([DashboardController::class, 'dashboard'])->with('flash_message_success','You are now Logged in successfully');
            }else{
                Cookie::queue(Cookie::forget('rememberMe'));
                Cookie::queue(Cookie::forget('rememberEmail'));
                Cookie::queue(Cookie::forget('rememberPassword'));
                return Redirect()->action([IndexController::class, 'login'])->with('flash_message_error','You have entered wrong email or password');
            }
    	}
        $stayTuned = array();
        if(Cookie::get('rememberMe')){
            $stayTuned['rememberMe'] = Cookie::get('rememberMe');
            $stayTuned['rememberEmail'] = Cookie::get('rememberEmail');
            $stayTuned['rememberPassword'] = Cookie::get('rememberPassword');
        }
    	$title="Sign In";
    	return view('front.login')->with(compact('title','stayTuned'));
    }

    public function register(Request $request){
        Session::put('menuactive','signup');
        if(Auth::check()){
            return redirect()->action([DashboardController::class,'dashboard']);
        }
    	if($request->isMethod('post')){
    		$rules = [
                'name' => 'bail|required|string|regex:/^[\pL\s\-]+$/u|max:255',
                'email' => 'bail|required|email|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|max:255|unique:users',
                'password' => 'bail|required|min:6|confirmed',
                'password_confirmation' => 'bail|required|min:6',
            ];
            $customMessages = [
                'name.regex' => 'The name may conatin only letters.',
                'email.regex' => 'The email must be a valid email address.',
                'email.unique' => 'This email has already been taken. Kindly sign In your account.',
                'password.required' => 'Please enter your new password',
                'password_confirmation.required' => 'Please enter your confirm password'
            ];
            $this->validate($request, $rules, $customMessages);
    		$data = $request->all();
            $user = new User;
    		$user->name = $data['name'];
    		$user->email = $data['email'];
            $user->password = bcrypt($data['password']);
    		$user->status = 1;
    		$user->save();
            if($this->mode =="live"){
                $email = $data['email'];
                $userdetails = $data;
                $messageData = [
                    'userdetails' => $userdetails,
                ];
                Mail::send('emails.signup-email', $messageData, function($message) use ($email){
                    $message->to($email)->subject('Registration with maxx Response');
                });
            }
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                Order::availFreePlan(Auth::user()->id);
                return redirect::to('/dashboard')->with('flash_message_success','Your account has been successfully created in Maxx Response');
            }
    	}
    	$title = "Signup";
    	return view('front.register')->with(compact('title'));
    }

    public function ForgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if(isset($data['email']) && !empty($data['email'])){
                $checkEmailExists = User::where('email',$data['email'])->first();
                if($checkEmailExists){
                    $password = Str::random(6);
                    User::where('email',$data['email'])->update(['password'=>bcrypt($password)]);
                    if($this->mode =="live"){
                        $email = $data['email'];
                        $messageData = [
                            'userdetails' => $checkEmailExists,
                            'password'   => $password
                        ];
                        Mail::send('emails.forgot-password', $messageData, function($message) use ($email){
                            $message->to($email)->subject('Password changed successfully');
                        });
                    }
                    $status = "sucess";
                    $message= "Password has been changed successfully and sent to your email";
                }else{
                    $status = "failed";
                    $message= "This email not exists in Maxx Response";
                }
            }else{
                $status = "failed";
                $message= "Please Enter your email";
            }
            return response()->json([
                'status' => $status,
                'message' =>$message
            ]);
        }
    }
}
