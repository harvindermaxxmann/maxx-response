<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Admin;
use DB;
use Cookie;
use Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\User;
use Auth;
use App\BillingDetail;
use Hash;
use App\Order;
use App\Feature;
use App\Page;
use App\Contact;
use Carbon\Carbon;
use App\LinkedList;
use App\MaxxFunctions;
use File;
use Illuminate\Support\Facades\Storage;


class ObdAndIvrController extends Controller
{

    public function obdIvrCampaignList() {
        return view('front.OBDandIVR.obd-and-ivr-campaign-list');
    }

    public function invitationsAndRsvpReport() {
        return view('front.OBDandIVR.invitations-and-rsvp-report');
    }

}
