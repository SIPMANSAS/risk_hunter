<?php 
	/** 
	* Config
    *
	* @package Vacation Rentals Booking Calendar (VRBC)
	* @author transinova.com
	* @copyright 2017-2018
	* @version Id: config.inc.php, v1.1.0 Feb 2018 transinova $
	*/
 
if (!defined("_EXECPERMIT_WNV")) die('Direct access to this location is not allowed.');

//Website URL without trailing slash
define('CFG_URL', 'http://localhost');

//VRBC Install Folder Name
define('CFG_DIR', 'hsoliari');

//Database Constants Configuration Settings:
define('DB_SERVER', 'localhost'); //MySQL Server
define('DB_USER', 'root'); //MySQL Database Username
define('DB_PASS', ''); //MySQL Database Password
define('DB_DATABASE', 'hsoliari'); //MySQL Database Name

define('CFG_TZ', 'America/Bogota'); // Change the TimeZone with yours. e.g. America/Los_Angeles
									// See the list at: http://php.net/manual/en/timezones.php

define('CFG_WEEKSTART', '2'); // Weekstart. 1:Sunday / 2:Monday

define('CFG_LGNATTEMPT', '7'); // Login attempt try before temporary blocked
define('CFG_LGNFLOOD', '1800'); // Login attempt waiting time to retry in second
// e.g: 1800=30Min / 900=15Min / 600=10Min


//Display Euro Cookies Notification on the First Time
define('CFG_EUCOOKIES', false); // true / false 

//Display MySQL errors debugging. true is Not recomended for live site: 
define('DEBUG', false); // true / false

//Currency
define('CFG_CURRENCY', 'PESOS');
define('CFG_CURRENCYSYMBOL', '$'); //Currency Symbol
define('CFG_DECIMALSEPARATOR', '.'); //Decimal Separator . point / , comma

define('FILES_DIR', 'bookingfiles'); //Booking Attachment Files Folder Name
define('FILES_MAXUPLOADSIZE', 1048576); //Max size of each file, in Bytes.
define('FILES_MAXUPLOADSSIZE', 5242880); //Max total size of files, in Bytes. 
// 524288=500KB / 1048576=1MB / 2097152=2MB / 3145728=3MB / 5242880=5MB / 6291456=6MB / 7340032=7MB

//Max number of files attached to a booking block
define('FILES_MAXATTACHED', 5);

//Number of file browser/selector
//Set 0 to disable file upload
define('FILES_BROWSENUM', 1);
						 
							  
//Allow Multiselect files in File Upload Dialog with Ctrl or Shift
//Best if source files located in the same folder.
define('FILES_MULTISELECT', true); // true / false 

	
// filter filetypes in File Upload Dialog
define('FILES_TYPES_ACCEPTED', '.jpg,.jpeg,.png,.pdf,.rtf,.doc,.docx,.xls,.xlsx');

// Limit past years in public view
define('CFG_PUBLPASTYEARS', 1); // 0,1,2,3..... Set 0 to disable past year(s)


?>
