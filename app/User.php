<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function userSubscriptions(){
        $subscriptions = DB::table('orders')->where('user_id',Auth::user()->id)->orderby('id','DESC')->where('payment_mode','!=','free')->get();
        $subscriptions = json_decode(json_encode($subscriptions),true);
        return $subscriptions;
    }

    public static function convertcurrencySymbol($currency){
        switch ($currency) {
            case "USD":
                return "$";
                break;
            case "INR":
                return "Rs.";
                break;
            default:
                return $currency;
        }
    }
}
