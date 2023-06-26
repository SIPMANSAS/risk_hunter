<?php
  /**
   * Class Vault
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: class.vault.php, v1.1.0 Feb 2018 transinova $
   */

  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');
	  
  abstract class Vault
  {
      static $objects = array();


      /**
       * Vault::get()
       * 
       * @param mixed $name
       * @return
       */
      public static function get($name)
      {
          return isset(self::$objects[$name]) ? self::$objects[$name] : null;
      }

      /**
       * Vault::set()
       * 
       * @param mixed $name
       * @param mixed $object
       * @return
       */
      public static function set($name, $object)
      {
          self::$objects[$name] = $object;
      }
  }
?>