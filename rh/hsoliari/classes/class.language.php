<?php
  /**
   * Language Class
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: class.language.php, v1.1.0 Feb 2018 transinova $
   */

  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');

  final class Lang
  {
      const langdir = "lang/";
	  public static $language;
	  public static $say = array();
	  public static $lang;	  
	  public $currlang;


      /**
       * Lang::__construct()
       * 
       * @return
       */
      public function __construct()
      {
		  self::get();
		  if(isset($_COOKIE['LANGUAGE_VRBC'])){
			  $this->currlang=$_COOKIE['LANGUAGE_VRBC'];
			  }else{
				  $this->currlang=Vault::get("Gist")->lang;
				  }
      }
	  
      /**
       * Lang::get()
       * 
       * @return
       */
	  private static function get()
	  {
		  if (isset($_COOKIE['LANGUAGE_VRBC'])) {
			  $sel_lang = sanitize($_COOKIE['LANGUAGE_VRBC'], 2);
			  $vlang = self::fetchLanguage($sel_lang);
			  if(in_array($sel_lang, $vlang)) {
				  Gist::$language = $sel_lang;
			  } else {
				  Gist::$language = Vault::get("Gist")->lang;
			  }
			  if (file_exists(BASEPATH . self::langdir . Gist::$language . "/lang.xml")) {
				  self::$say = self::set(BASEPATH . self::langdir . Gist::$language . "/lang.xml", Gist::$language);
			  } else {
				  self::$say = self::set(BASEPATH . self::langdir . Vault::get("Gist")->lang . "/lang.xml", Vault::get("Gist")->lang);
			  }
		  } else {
			  Gist::$language = Vault::get("Gist")->lang;
			  self::$say = self::set(BASEPATH . self::langdir . Vault::get("Gist")->lang. "/lang.xml", Vault::get("Gist")->lang);
			  
		  }
		  self::$lang = "_" . Gist::$language;
		  return self::$say;
	  }

      /**
       * Lang::set()
       * 
       * @return
       */
	  public static function set($lang, $abbr)
	  {
		  $xmlel = simplexml_load_file($lang);
		  $data = new stdClass();
		  foreach ($xmlel as $pkey) {
			  $key = (string )$pkey['data'];
			  $data->$key = (string )str_replace(array('\'', '"'), array("&apos;", "&quot;"), $pkey);
		  }
	  
		  return $data;
	  }


	  	  
      /**
       * Lang::fetchLanguage()
       * 
       * @return
       */
	  public static function fetchLanguage()
	  {
		  $lang_array = '';
		  $directory = BASEPATH . Lang::langdir;
		  if (!is_dir($directory)) {
			  return false;
		  } else {
			  $lang_array = glob($directory . "*", GLOB_ONLYDIR);
			  $lang_array = str_replace($directory, "", $lang_array);
	
		  }
	
		  return $lang_array;
	  }



  }
?>