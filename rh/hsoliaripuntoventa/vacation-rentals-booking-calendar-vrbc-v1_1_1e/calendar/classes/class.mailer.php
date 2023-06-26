<?php
  /**
   * Mailer Class
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: class.mailer.php, v1.1.0 Feb 2018 transinova $
   */
  
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');

  class Mailer
  {
	  
	  private static $instance;
	  
      /**
       * Mailer::__construct()
       * 
       * @return
       */
      private function __construct(){}

      /**
       * Mailer::instance()
       * 
       * @return
       */
	  public static function instance(){
		  if (!self::$instance){ 
			  self::$instance = new Mailer(); 
		  } 
	  
		  return self::$instance;  
	  }
	  
      /**
       * Mailer::sendMail()
       * 
	   * Sends a various messages to users
       * @return
       */
      public static function sendMail()
      {
          require_once (BASEPATH . 'classes/swift/swift_required.php');
          
          if (Vault::get("Gist")->mailer == "SMAIL") {
			  $transport = Swift_SendmailTransport::newInstance(Vault::get("Gist")->sendmail);
          } else
              $transport = Swift_MailTransport::newInstance();
          
          return Swift_Mailer::newInstance($transport);
	  }
	  
  }
  //$mail = new Mailer();
?>