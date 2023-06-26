<?php
  /**
   * Start
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: start.php, v1.1.0 Feb 2018 transinova $
   */
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');

  error_reporting(E_ALL);
  
  $BASEPATH = str_replace("start.php", "", realpath(__FILE__));
  define("BASEPATH", $BASEPATH);
  
 
  $configFile = BASEPATH . "includes/config.inc.php";
  $synctzFile = BASEPATH . "includes/synctz.inc.php";
  if (file_exists($configFile)) {
      require_once ($configFile);
	  require_once ($synctzFile);
  } else {
	  exit;
  }

  require_once (BASEPATH . "classes/class.db.php");

  require_once (BASEPATH . "classes/class.vault.php");
  Vault::set('Database', new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE));
  $db = Vault::get("Database");
  $db->connect();

  
  //Include Functions
  require_once (BASEPATH . "includes/helpers.inc.php");
  require_once (BASEPATH . "includes/niceIds.inc.php");
  Vault::set('niceIds', new niceIds());
  

	require_once(BASEPATH . "classes/class.sift.php");
	$request = new Sift();


  //Start Gist Class 
  require_once (BASEPATH . "classes/class.gist.php");
  Vault::set('Gist', new Gist());
  $gist = Vault::get("Gist");

  //Start Language Class 
  require_once(BASEPATH . "classes/class.language.php");
  Vault::set('Lang',new Lang());

  //StartUser Class 
  require_once (BASEPATH . "classes/class.user.php");
  Vault::set('Users', new Users());
  $user = Vault::get("Users");
  
  //Load Security Class
  require_once(BASEPATH . "classes/class.security.php");
  Vault::set('Security', new Security($gist->attempt, $gist->flood));
  $wenbssec = Vault::get("Security"); 

  //Start Paginator Class 
  require_once(BASEPATH . "/classes/class.paginate.php");
  $pager = Paginator::instance();

  //Start Vhrental Class
  require_once (BASEPATH . "classes/class.vhrental.php");
  Vault::set('Vhrental', new Vhrental());
  $vhr = Vault::get("Vhrental");

  //Start Calendar Class
  require_once (BASEPATH . "classes/class.calendar.php");
  Vault::set('Calendar', new Calendar());
  $cal = Vault::get("Calendar");
  
  define("SITEURL", Vault::get("Gist")->site_url.'/'.Vault::get("Gist")->site_dir.'/');
  $langlist = $gist->langList();
  
  define("FILESPATH", BASEPATH.FILES_DIR.'/');
  define("FILESURL", Vault::get("Gist")->site_url.'/'.CFG_DIR.'/'.FILES_DIR.'/');
  
?>