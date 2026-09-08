<?php 
	//----------------------------------------------------------------------------------//	
	//                               COMPULSORY SETTINGS
	//----------------------------------------------------------------------------------//
	
	/*  Set the URL to your Sendy installation (without the trailing slash) */
	$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
	$host_name = explode(':', $host)[0];
	$is_local = in_array($host_name, array('localhost', '127.0.0.1'), true);
	$local_path = 'http://'.$host.'/maxx-response/sendy';
	define('APP_PATH', $is_local ? $local_path : 'https://maxxresponse.com/sendy');
	
	/*  MySQL database connection credentials (please place values between the apostrophes) */
	// $dbHost = 'localhost'; //MySQL Hostname
	// $dbUser = 'maxxresp_sendy'; //MySQL Username
	// $dbPass = 'j4NWN_Eb33Nd'; //MySQL Password
	// $dbName = 'maxxresp_sendy'; //MySQL Database Name
	
	$dbHost = '192.168.1.2'; //MySQL Hostname
	$dbUser = 'webuser'; //MySQL Username
	$dbPass = 'M@xxmann@121'; //MySQL Password
	$dbName = 'maxxresp_sendy'; //MySQL Database Name
	//----------------------------------------------------------------------------------//	
	//								  OPTIONAL SETTINGS
	//----------------------------------------------------------------------------------//	
	
	/* 
		Change the database character set to something that supports the language you'll
		be using. Example, set this to utf16 if you use Chinese or Vietnamese characters
	*/
	$charset = 'utf8mb4';
	
	/*  Set this if you use a non standard MySQL port.  */
	$dbPort = 3306;	
	
	/*  Domain of cookie (99.99% chance you don't need to edit this at all)  */
	define('COOKIE_DOMAIN', '');
	
	//----------------------------------------------------------------------------------//
?>

