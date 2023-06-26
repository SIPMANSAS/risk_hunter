<?php 
	/** 
	* SyncTZ

	* @package Vacation Rentals Booking Calendar (VRBC)
	* @author transinova.com
	* @copyright 2017-2018
	* @version Id: synctz.inc.php, v1.1.0 Feb 2018 transinova $
	*/
 
if (!defined("_EXECPERMIT_WNV")) 
die('Direct access to this location is not allowed.');

/*Set Timezone*/
date_default_timezone_set(CFG_TZ);

/*Syc MySql & PHP date TZ*/
$mysqlitz_now = new DateTime();
$mysqlitz_mins = $mysqlitz_now->getOffset() / 60;
$mysqlitz_sgn = ($mysqlitz_mins < 0 ? -1 : 1);
$mysqlitz_mins = abs($mysqlitz_mins);
$mysqlitz_hrs = floor($mysqlitz_mins / 60);
$mysqlitz_mins -= $mysqlitz_hrs * 60;
$mysqlitz_offset = sprintf('%+d:%02d', $mysqlitz_hrs*$mysqlitz_sgn, $mysqlitz_mins);
define('MYSQLITZ', $mysqlitz_offset);

?>