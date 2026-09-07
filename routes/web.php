<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PricingController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ObdAndIvrController;
use App\Http\Controllers\FacebookAdsController;
use App\Http\Controllers\GoogleAdsController;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    echo 0;
});



Route::match(['get', 'post'], '/max/admin', [AdminController::class, 'login']);
Route::match(['get', 'post'], '/logout', [AdminController::class, 'logout']);
// Admin Routes with Middleware
Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function () {
    Route::match(['get', 'post'], '/status', [AdminController::class, 'status']);
    Route::match(['get', 'post'], '/dashboard', [AdminController::class, 'dashboard']);
    Route::match(['get', 'post'], '/logout', [AdminController::class, 'logout']);
    Route::match(['get', 'post'], '/profile', [AdminController::class, 'profile']);
    Route::match(['get', 'post'], '/settings', [AdminController::class, 'settings']);
    Route::match(['get', 'post'], '/change-admin-logo', [AdminController::class, 'changeAdminLogo']);
    Route::match(['get', 'post'], '/change-admin-password', [AdminController::class, 'changeAdminPassword']);
    Route::match(['get', 'post'], '/checkAdminPassword', [AdminController::class, 'checkAdminPassword']);
    Route::match(['get', 'post'], '/checkUserMobile', [AdminController::class, 'checkUserMobile']);
    Route::match(['get', 'post'], '/checkUsername', [AdminController::class, 'checkUsername']);

    // Roles
    Route::match(['get', 'post'], '/roles', [RolesController::class, 'roles']);
    Route::match(['get', 'post'], '/add-edit-role/{id?}', [RolesController::class, 'addEditRole']);

    // Subadmin Routes
    Route::match(['get', 'post'], '/subadmins', [AdminController::class, 'subadmins']);
    Route::match(['get', 'post'], '/add-edit-subadmin/{id?}', [AdminController::class, 'addeditSubadmin']);
    Route::match(['get', 'post'], '/checkAdminUsername', [AdminController::class, 'checkAdminUsername']);

    // Users Routes
    Route::match(['get', 'post'], '/users', [UsersController::class, 'users']);
    Route::match(['get', 'post'], '/add-edit-user/{userid?}', [UsersController::class, 'addEditUser']);
    Route::match(['get', 'post'], '/change-user-password', [UsersController::class, 'changeUserPassword']);
    Route::match(['get', 'post'], '/CheckUserEmail', [UsersController::class, 'CheckUserEmail']);

    // Package Routes
    Route::match(['get', 'post'], '/packages', [PackageController::class, 'packages']);
    Route::match(['get', 'post'], '/add-edit-package/{pid?}', [PackageController::class, 'addEditPackage']);
    
    // Feature Routes
    Route::match(['get', 'post'], '/features', [PackageController::class, 'features']);
    Route::match(['get', 'post'], '/add-edit-feature/{fid?}', [PackageController::class, 'addEditFeature']);
    Route::match(['get', 'post'], '/update-discounts', [PackageController::class, 'updateDiscounts']);

    // Coupon Routes
    Route::match(['get', 'post'], '/coupons', [PackageController::class, 'coupons']);
    Route::match(['get', 'post'], '/checkCouponCode', [PackageController::class, 'checkCouponCode']);
    Route::match(['get', 'post'], '/add-edit-coupon/{id?}', [PackageController::class, 'addEditCoupon']);
    Route::match(['get', 'post'], '/delete-coupon/{id}', [PackageController::class, 'deleteCouponCode']);

    // Category Routes
    Route::match(['get', 'post'], '/categories', [TemplateController::class, 'categories']);
    Route::match(['get', 'post'], '/add-edit-category/{id?}', [TemplateController::class, 'addEditCategory']);

    // Pages Routes
    Route::match(['get', 'post'], '/pages', [TemplateController::class, 'pages']);
    Route::match(['get', 'post'], '/add-edit-page/{id?}', [TemplateController::class, 'addEditPage']);

    // Order Routes
    Route::match(['get', 'post'], '/orders', [OrdersController::class, 'orders']);
    Route::match(['get', 'post'], '/order-details/{orderid}', [OrdersController::class, 'orderdetails']);

    // Banner Images Routes
    Route::match(['get', 'post'], '/banner-images', [AdminController::class, 'bannerImages']);
    Route::match(['get', 'post'], '/add-edit-banner-image/{bannerid?}', [AdminController::class, 'addEditBannerImage']);
    Route::match(['get', 'post'], '/delete-banner-image/{bannerid}', [AdminController::class, 'deleteBannerImage']);

    // SMS Sender IDs
    Route::match(['get', 'post'], '/sender-ids', [AdminController::class, 'senderids']);
    Route::match(['get', 'post'], '/approve-sender-id/{senderid}', [AdminController::class, 'approveSenderId']);
});

/*Front end Routes*/
Route::get('/', [IndexController::class,'index'])->name('index');
Route::match(['get', 'post'], '/login', [IndexController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [IndexController::class, 'register'])->name('register');
Route::match(['get', 'post'], '/forgot-passwor', [IndexController::class, 'ForgotPassword'])->name('ForgotPassword');




Route::get('/logout',[DashboardController::class,'logout']);

//Pricing Routes
Route::get('/pricing', [PricingController::class, 'pricing']);

Route::match(['get', 'post'], '/check-listsize-pricing', [PricingController::class, 'checkListSizePricing']);

Route::match(['get', 'post'], '/change-plan', [PricingController::class, 'changePlan']);

Route::match(['get', 'post'], '/change-currency', [PricingController::class, 'changeCurrency']);


Route::match(['get', 'post'], '/buy-package', [PricingController::class, 'buyPackage']);

Route::match(['get', 'post'], '/billing', [PricingController::class, 'billing']);

Route::group(['middleware' => ['auth']], function () {

	Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
	Route::get('/my-account',[DashboardController::class,'myaccount']);
	Route::post('/update-account-details',[DashboardController::class,'updateAccountDetails']);
	Route::post('/change-password',[DashboardController::class,'changePassword']);
	Route::get('/view-invoice/{id}',[DashboardController::class,'viewinvoice']);
	Route::get('/order-review',[PricingController::class, 'orderReview']);
	Route::post('/change-payment-gateway',[PricingController::class, 'changePaymentgateway']);
	Route::post('/make-payment',[PricingController::class, 'makePayment']);
	Route::match(['get','post'],'/cancel-order',[PricingController::class, 'cancelOrder']);
	Route::get('/checkout-success',[PricingController::class, 'getExpressCheckoutSuccess']);
	Route::get('/thanks',[PricingController::class, 'thanks']);
	Route::post('/apply-coupon',[PricingController::class, 'applycoupon']);
	Route::match(['get','post'],'/ccavenue/response',[PricingController::class,'ccavenueresponse']);
	//Authorize.Net Routes
	Route::match(['get','post'],'/complete-purchase',[PricingController::class,'completeauthorizeNet']);
	//Create Pgaes
	Route::match(['get','post'],'create/{slug}',[DashboardController::class,'createpage']);

	//landing Page Routes
    Route::controller(LandingPageController::class)->group(function () {
        Route::match(['get', 'post'], 'landing-page/choose-template', 'landingchoosetemplate')->name('landingpage.choose_template');
        Route::match(['get', 'post'], 'process-landing-page', 'processLandingpage')->name('landingpage.process');
        Route::match(['get', 'post'], 'lp-settings', 'lpSettings')->name('landingpage.settings');
        Route::match(['get', 'post'], 'lps/manage', 'landingpages')->name('landingpage.manage');
        Route::match(['get', 'post'], 'delete-landing/{id}', 'deletelanding')->name('landingpage.delete');
    });

	Route::get('user-landing-page/{userid}/{filename}', function ($userid,$filename){
        $path = storage_path('app/templates/'.$userid.'/landing-pages'.'/'. $filename);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    });

	//Newsletter Routes
	Route::controller(NewsletterController::class)->group(function () {
        Route::match(['get', 'post'], 'newsletter/{slug}', 'createNewsletter')->name('newsletter.create');
        Route::match(['get', 'post'], 'newsletter-choose-template', 'newsletterChooseTemplate')->name('newsletter.choose_template');
        Route::match(['get', 'post'], 'create-plain-html', 'createPlainHtml')->name('newsletter.create_plain_html');
        Route::get('getcampaignId/{id}', 'getcampaignId')->name('newsletter.get_campaign_id');
        Route::match(['get', 'post'], 'newsletter-summary', 'newsletterSummary')->name('newsletter.summary');
        Route::match(['get', 'post'], 'drafts', 'drafts')->name('newsletter.drafts');
        Route::get('delete-draft/{id}', 'deletedraft')->name('newsletter.delete_draft');
        Route::post('newsletter-campaign', 'newsletterCampaign')->name('newsletter.campaign');
        Route::get('draft/preview/{id}', 'draftpreview')->name('newsletter.draft_preview');
        Route::get('run-newsletter-campaign', 'runNewsletterCampaign')->name('newsletter.run_campaign');
    });

	Route::match(['get','post'],'/email-campaign-list',[NewsletterController::class, 'newsletterCampaignList']);
	Route::match(['get','post'],'/email',[NewsletterController::class, 'newsletterReport']);

	Route::match(['get','post'],'/email-campaigns',[NewsletterController::class, 'newsletterCampaigns']);

	Route::match(['get','post'],'/email-campaign-details',[NewsletterController::class, 'newsletterCampaignDetails']);


	//Editor Related  Routes
	Route::controller(EditorController::class)->group(function () {
        Route::match(['get', 'post'], 'view-template/{folder}/{file}', 'viewtemplate')->name('editor.view_template');
        Route::match(['get', 'post'], 'process-template', 'processTemplate')->name('editor.process_template');
        Route::match(['get', 'post'], 'html/editor', 'Editor')->name('editor.html_editor');
        Route::match(['get', 'post'], 'upload-editor-image', 'uploadeditorImage')->name('editor.upload_image');
        Route::match(['get', 'post'], 'save-template', 'saveTemplate')->name('editor.save_template');
    });

	Route::get('user-newsletter-template/{userid}/{filename}', function ($userid,$filename){
        $path = storage_path('app/templates/'.$userid.'/newsletter'.'/'. $filename);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    });

	//Contacts
	Route::get('/contact-lists',[DashboardController::class,'contactlists']);
	Route::get('/contacts',[DashboardController::class,'contacts']);

	Route::match(['get','post'],'add-contact/{slug}',[DashboardController::class,'addcontact']);
	Route::get('/delete-contact/{id}',[DashboardController::class,'deleteContact']);
	Route::get('/delete-contactlist/{id}',[DashboardController::class,'deleteContactlist']);	
	Route::get('/export-contacts',[DashboardController::class,'exportContacts']);
	Route::get('/view-user-contcat/{contcatid?}',[DashboardController::class,'viewUserContcat']);
	Route::post('/add-list-name',[DashboardController::class,'addListName']);
	Route::match(['get','post'],'getspecservice',[DashboardController::class,'getspecservice']);

	//Sms campaign
	Route::controller(CampaignController::class)->group(function () {
        Route::match(['get', 'post'], 'sms', 'sms')->name('campaign.sms');
        Route::match(['get', 'post'], 'sms-campaign', 'smsCampaign')->name('campaign.sms_campaign');
        Route::match(['get', 'post'], 'resend-sms-campaign', 'resendSmsCampaign')->name('campaign.resend_sms_campaign');
        Route::match(['get', 'post'], 'delete-sms-campaign/{campaignid}', 'deleteSmsCampaign')->name('campaign.delete_sms_campaign');
        Route::match(['get', 'post'], 'export/sms-campaign/{campaignid}', 'exportSmsCampaign')->name('campaign.export_sms_campaign');
        Route::match(['get', 'post'], 'campaign-detail/{campaignid}', 'campaignDetail')->name('campaign.detail');
        Route::post('create-sms-sender-id', 'createSmsSenderId')->name('campaign.create_sms_sender_id');
        Route::get('sender-thanks', 'senderThanks')->name('campaign.sender_thanks');
        Route::post('send-sms-to-contacts', 'sendSmsToContacts')->name('campaign.send_sms_to_contacts');
        Route::post('get-tiny-url', 'getTinyUrl')->name('campaign.get_tiny_url');
        Route::match(['get', 'post'], 'sms-campaign-list', 'smsCampaignList')->name('campaign.sms_campaign_list');
    });

	Route::controller(ObdAndIvrController::class)->group(function () {
        Route::match(['get', 'post'], 'obd-and-ivr-campaign-list', 'obdIvrCampaignList')->name('campaign.obd_ivr_campaign_list');
        Route::match(['get', 'post'], 'invitations-and-rsvp', 'invitationsAndRsvpReport')->name('campaign.invitations_rsvp_report');
    });
    
    Route::controller(FacebookAdsController::class)->group(function () {
        Route::match(['get', 'post'], 'facebook-ads-campaign-list', 'facebookAdsCampaignList')->name('campaign.facebook_ads_campaign_list');
        Route::match(['get', 'post'], 'facebook-ads-campaign', 'facebookAdsCampaign')->name('campaign.facebook_ads_campaign');
    });
    
    Route::controller(GoogleAdsController::class)->group(function () {
        Route::match(['get', 'post'], 'google-ads-campaign-list', 'googleAdsCampaignList')->name('campaign.google_ads_campaign_list');
        Route::match(['get', 'post'], 'google-ads-campaign', 'googleAdsCampaign')->name('campaign.google_ads_campaign');
    });

});

//Landing Page Preview
Route::get('lp/preview/{id}',[LandingPageController::class, 'landingpreview']);


Route::post('/get-states', [PricingController::class, 'getstates']);
Route::post('/get-cities', [PricingController::class, 'getcities']);
Route::post('/paypal/notify', [PricingController::class, 'notify']);
Route::post('/update-exchange-rates', [PricingController::class, 'updateExchangeRates']);

/*Front end Routes*/
Route::get('/send-email',[IndexController::class, 'sendtestemail']);
Route::get('/test-bulk-email',[TestController::class, 'bulkemail']);
