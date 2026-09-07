<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Srmklive\PayPal\Services\AdaptivePayments;
use Srmklive\PayPal\Services\ExpressCheckout;
class Controller extends BaseController
{
    public $mode;
	public $smsmode;
    protected $provider;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        //$this->provider = new ExpressCheckout();
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );
        if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            $this->mode = "local";
            $this->smsmode = "live";
        }else{
            $this->mode = "local";
            $this->smsmode = "local";
        }
    }

    public function cleanstring($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
}
