<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use DB;
use Mail;
use Config;
use mysqli;

class Helper
{

	//------------------------------------------------------//
	public static function get_bounced( $campaign_id )
	{

		//MySQL database connection credentials (please place values between the apostrophes)
		$mysqli = new mysqli("localhost","root","","maxxresp_sendy");
	
		$q = 'SELECT last_campaign FROM subscribers WHERE last_campaign = '.$campaign_id.' AND bounced = 1';
		$r = mysqli_query($mysqli, $q);
		if ($r && mysqli_num_rows($r) > 0)
		{
		    return mysqli_num_rows($r);
		}
		else
		{
			return 0;
		}
	}

	public static function get_click_percentage($cid)
	{
		
		//MySQL database connection credentials (please place values between the apostrophes)
		$mysqli = new mysqli("localhost","root","","maxxresp_sendy");
		
		$clicks_join = '';
		$clicks_array = array();
		$clicks_unique = 0;
		
		$q = 'SELECT * FROM links WHERE campaign_id = '.$cid;
		$r = mysqli_query($mysqli, $q);
		if ($r && mysqli_num_rows($r) > 0)
		{
		    while($row = mysqli_fetch_array($r))
		    {
		    	$id = stripslashes($row['id']);
				$link = stripslashes($row['link']);
				$clicks = $row['clicks']=='' ? '' : stripslashes($row['clicks']);
				if($clicks!='')
					$clicks_join .= $clicks.',';				
		    }  
		}
		
		$clicks_array = explode(',', $clicks_join);
		$clicks_unique = count(array_unique($clicks_array));
		
		return $clicks_unique-1;
	}

}

?>