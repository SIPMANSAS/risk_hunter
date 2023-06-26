<?php
  /**
   * Security Class
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: class.security.php, v1.1.0 Feb 2018 transinova $
   */
  
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');
  
  
  class Security
  {
	  
      private static $ip;
      private $counter;
      private $wait;
	  const lTable = "sys_log";
      
      /**
       * Security::__construct()
       * 
       * @param integer $attempt
       * @param integer $wait
       * @return
       */
      function __construct($attempt = 3, $wait = 180)
      {
          $this->setPars($attempt, $wait);
          self::$ip = self::getip();
      }
      
      /**
       * Security::getip()
       * 
       * @return
       */
      private static function getip()
      {
          return getVisitingIP();
      }
      
      /**
       * Security::setPars()
       * 
       * @param mixed $counter
       * @param mixed $wait
       * @return
       */
      private function setPars($counter, $wait)
      {
          $this->counter = $counter;
          $this->wait = $wait;
      }
      
      /**
       * Security::reLogin()
       * 
       * @param mixed $remain
       * @return
       */
	  public function reLogin(&$remain)
	  {
		  $remain = 0;
		  $time = $this->getTime();
		  $var = $this->getRecord(self::$ip);
		  if (!$var)
			  return true;
		  if ($var->failed < $this->counter)
			  return true;
		  if (($time - $var->failed_last) > $this->wait) {
			  $this->deleteRecord(self::$ip);
			  return true;
		  }
		  $remain = $this->wait - ($time - $var->failed_last);
		  return false;
	  }
      
      /**
       * Security::setFailedLogin()
       * 
       * @return
       */
      public function setFailedLogin()
      {
          $this->setRecord(self::$ip, $this->getTime());
      }
      
      /**
       * Security::getTime()
       * 
       * @return
       */
      private function getTime()
      {
          return time();
      }
      
      /**
       * Security::getRecord()
       * 
       * @param mixed $ip
       * @return
       */
      private function getRecord($ip)
      {
		  
          $sql = "SELECT * FROM " . self::lTable . " WHERE ip='" . Vault::get("Database")->escape($ip) . "' AND type='user'";
          $row = Vault::get("Database")->first($sql);
		  
		  return ($row) ? $row : 0;
      }
      
      /**
       * Security::setRecord()
       * 
       * @param mixed $ip
       * @param mixed $failed
       * @param mixed $failed_last
       * @return
       */
	  private function setRecord($ip, $failed_last)
	  {
	
		  $ip = sanitize($ip);
		  if ($row = $this->getRecord($ip)) {
			  $data = array('failed' => "INC(1)", 'failed_last' => $failed_last);
	
			  Vault::get("Database")->update(self::lTable, $data, "id='" . $row->id . "'");
		  } else {
			  $data = array(
				  'ip' => $ip,
				  'type' => "user",
				  'failed' => 1,
				  'failed_last' => $failed_last,
				  'importance' => "yes",
				  'user_id' => "Guest",
				  'created' => "NOW()",
				  'message' => "failed login attempt",
				  'info_icon' => "warning");
	
			  Vault::get("Database")->insert(self::lTable, $data);
		  }
	  }

	  
					  
      /**
       * Security::deleteRecord()
       * 
       * @param mixed $ip
       * @return
       */
      private function deleteRecord($ip)
      {
          Vault::get("Database")->delete(self::lTable, "ip='" . Vault::get("Database")->escape($ip) . "' AND type = 'user'");
      }
	  
  }
?>