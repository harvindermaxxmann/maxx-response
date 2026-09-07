<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    //
    public function page(){
    	return $this->belongsTo('App\Page','page_id');
    }

    public static function createSudomain($subdomain){
    	$cpanel_user = env('CPANEL_USERNAME');
    	// your cPanel password
    	$cpanel_pass =  env('CPANEL_PASSWORD');
    	// your cPanel skin
    	$cpanel_skin = env('CPANEL_SKIN');
    	// your cPanel domain
    	$cpanel_host = env('CPANEL_HOST');
    	// subdomain name
    	$dir = 'public_html/subdomains/'.$subdomain;
    	// create the subdomain
	    $sock = fsockopen($cpanel_host,2082);
	    if(!$sock) {
	        print('Socket error');
	        exit();
	    }
    	$pass = base64_encode("$cpanel_user:$cpanel_pass");
    	$in = "GET /frontend/$cpanel_skin/subdomain/doadddomain.html?rootdomain=$cpanel_host&domain=$subdomain&dir=$dir\r\n";
    	$in .= "HTTP/1.0\r\n";
    	$in .= "Host:$cpanel_host\r\n";
    	$in .= "Authorization: Basic $pass\r\n";
    	$in .= "\r\n";
    	$result ='';
	    fputs($sock, $in);
	        while (!feof($sock)) {
	        $result .= fgets ($sock,128);
	    }
    	fclose($sock);
    	return $result;
    }

    public static function transferFiles($subdomain,$landingid){
        $ftp_server=env('FTP_SERVER');
        $ftp_user_name=env('FTP_USERNAME');
        $ftp_user_pass=env('FTP_PASSWORD');
        $file = "http://maxxresponse.maxxmannsupport.com/lp/preview/".$landingid;//tobe uploaded
        $remote_file = "subdomains/".$subdomain."/"."index.html";
        // set up basic connection
        $conn_id = ftp_connect($ftp_server);
        // login with username and password
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
        // upload a file
        if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
            $response = true;
            /*echo "successfully uploaded $file\n";
            exit;*/
        }else {
            $response = false;
            /*echo "There was a problem while uploading $file\n";
            exit;*/
        }
        //close the connection
        ftp_close($conn_id);
        return $response;
    }
}
