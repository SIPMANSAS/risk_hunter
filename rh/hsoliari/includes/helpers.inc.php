<?php

  /**
   * Helpers
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: helpers.inc.php, v1.1.0 Feb 2018 transinova $
   */
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');

 
  /**
   * post()
   * 
   * @param mixed $var
   * @return
   */
  function post($var)
  {
      if (isset($_POST[$var]))
          return $_POST[$var];
  }

  /**
   * get()
   * 
   * @param mixed $var
   * @return
   */
  function get($var)
  {
      if (isset($_GET[$var]))
          return $_GET[$var];
  }

  /**
   * sanitize()
   * 
   * @param mixed $string
   * @param bool $trim
   * @return
   */
  function sanitize($string, $trim = false, $int = false, $str = false)
  {
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array(
          '‘',
          '’',
          '“',
          '”'), array(
          "'",
          "'",
          '"',
          '"'), $string);

      if ($trim)
          $string = substr($string, 0, $trim);
      if ($int)
          $string = preg_replace("/[^0-9\s]/", "", $string);
      if ($str)
          $string = preg_replace("/[^a-zA-Z\s]/", "", $string);

      return $string;
  }

  /**
   * cleanSanitize()
   * 
   * @param mixed $string
   * @param bool $trim
   * @return
   */
  function cleanSanitize($string, $trim = false, $end_char = '&#8230;')
  {
      $string = cleanOut($string);
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array(
          '‘',
          '’',
          '“',
          '”'), array(
          "'",
          "'",
          '"',
          '"'), $string);

      if ($trim) {
          if (strlen($string) < $trim) {
              return $string;
          }

          $string = preg_replace("/\s+/", ' ', str_replace(array(
              "\r\n",
              "\r",
              "\n"), ' ', $string));

          if (strlen($string) <= $trim) {
              return $string;
          }

          $out = "";
          foreach (explode(' ', trim($string)) as $val) {
              $out .= $val . ' ';

              if (strlen($out) >= $trim) {
                  $out = trim($out);
                  return (strlen($out) == strlen($string)) ? $out : $out . $end_char;
              }
          }
      }
      return $string;
  }

  /**
   * truncate()
   * 
   * @param mixed $str
   * @param int $n
   * @param mixed $end_char
   * @return
   */
  function truncate($str, $n = 100, $end_char = '&#8230;')
  {
      if (strlen($str) < $n) {
          return $str;
      }

      $str = preg_replace("/\s+/", ' ', str_replace(array(
          "\r\n",
          "\r",
          "\n"), ' ', $str));

      if (strlen($str) <= $n) {
          return $str;
      }

      $out = "";
      foreach (explode(' ', trim($str)) as $val) {
          $out .= $val . ' ';

          if (strlen($out) >= $n) {
              $out = trim($out);
              return (strlen($out) == strlen($str)) ? $out : $out . $end_char;
          }
      }
  }


  /**
   * redirect_to()
   * 
   * @param mixed $location
   * @return
   */
  function redirect_to($location)
  {
      if (!headers_sent()) {
          header('Location: ' . $location);
          exit;
      } else {
          echo '<script type="text/javascript">';
          echo 'window.location.href="' . $location . '";';
          echo '</script>';
          echo '<noscript>';
          echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
          echo '</noscript>';
      }
  }

  /**
   * countEntries()
   * 
   * @param mixed $table
   * @param string $where
   * @param string $what
   * @return
   */
  function countEntries($table, $where = '', $what = '')
  {
      if (!empty($where) && isset($what)) {
          $q = "SELECT COUNT(*) FROM " . $table . "  WHERE " . $where . " = '" . $what . "' LIMIT 1";
      } else
          $q = "SELECT COUNT(*) FROM " . $table . " LIMIT 1";

      $record = Vault::get("Database")->query($q);
      $total = Vault::get("Database")->fetchrow($record);
      return $total[0];
  }

  /**
   * getChecked()
   * 
   * @param mixed $row
   * @param mixed $status
   * @param mixed $return
   * @return
   */
  function getChecked($row, $status, $return=false)
  {
      if ($row == $status) {
		  if($return){return " checked=\"checked\"";}else{echo " checked=\"checked\"";}
      }
  }

  /**
   * getSelected()
   * 
   * @param mixed $row
   * @param mixed $status
   * @param mixed $return
   * @return
   */
  function getSelected($row, $status, $return=false)
  {
      if ($row == $status) {
          if($return){return " selected=\"selected\"";}else{echo " selected=\"selected\" ";}
      }
  }
  
  /**
   * getValue()
   * 
   * @param mixed $stwhatring
   * @param mixed $table
   * @param mixed $where
   * @return
   */
  function getValue($what, $table, $where)
  {
      $sql = "SELECT $what FROM $table WHERE $where";
      $row = Vault::get("Database")->first($sql);
      return ($row) ? $row->$what : '';
  }

  /**
   * getValues()
   * 
   * @param mixed $stwhatring
   * @param mixed $table
   * @param mixed $where
   * @return
   */
  function getValues($what, $table, $where)
  {
      $sql = "SELECT $what FROM $table WHERE $where";
      $row = Vault::get("Database")->first($sql);
      return ($row) ? $row : 0;
  }
  
  /**
   * getValueById()
   * 
   * @param mixed $what
   * @param mixed $table
   * @param mixed $id
   * @return
   */
  function getValueById($what, $table, $id)
  {
      $sql = "SELECT $what FROM $table WHERE id = $id";
      $row = Vault::get("Database")->first($sql);
      return ($row) ? $row->$what : '';
  }

  /**
   * getValuesById()
   * 
   * @param mixed $what
   * @param mixed $table
   * @param mixed $id
   * @return
   */
  function getValuesById($what, $table, $id)
  {
      $sql = "SELECT $what FROM $table WHERE id = $id";
      $row = Vault::get("Database")->first($sql);
      return ($row) ? $row : 0;
  }
  
  /**
   * phpself()
   * 
   * @return
   */
  function phpself()
  {
      return htmlspecialchars($_SERVER['PHP_SELF']);
  }

  /**
   * stripTags()
   * 
   * @param mixed $start
   * @param mixed $end
   * @param mixed $string
   * @return
   */
  function stripTags($start, $end, $string)
  {
      $string = stristr($string, $start);
      $doend = stristr($string, $end);
      return substr($string, strlen($start), -strlen($doend));
  }



  /**
   * cleanOut()
   * 
   * @param mixed $text
   * @return
   */
  function cleanOut($text)
  {
      $text = strtr($text, array(
          '\r\n' => "",
          '\r' => "",
          '\n' => ""));
      $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
      $text = str_replace('<br>', '<br />', $text);
      return stripslashes($text);
  }

  /**
   * randName()
   * 
   * @return
   */
  function randName($i = 6)
  {
      $code = '';
      for ($x = 0; $x < $i; $x++) {
          $code .= '-' . substr(strtoupper(sha1(rand(0, 999999999999999))), 2, 6);
      }
      $code = substr($code, 1);
      return $code;
  }




function makePassId($myid=false) {
 if($myid){
   $unique = Vault::get("niceIds")->makenice($myid.'p').'.'.Vault::get("niceIds")->makenice(strrev($myid)).'.'.substr($myid,-1);
   if($unique){return  Vault::get("niceIds")->makenice($unique);}else{return false;}
	}else{return false;}
  }	


function restorePassId($passid=false) {
	if($passid){
   $trids=Vault::get("niceIds")->restore($passid);
   $trids=explode('.',$trids);
   if($trids){
	   if(count($trids)>1 && $trids[1]){
	   $unique = Vault::get("niceIds")->restore($trids[1]);}else{return false;}
	   if($unique){return strrev($unique);}else{return false;}
	   }else{return false;}
	}else{return false;}
  }	

  /**
   * compareFloatNumbers()
   * 
   * @param mixed $float1
   * @param mixed $float2
   * @param string $operator
   * @return
   */
  function compareFloatNumbers($float1, $float2, $operator='=')  
  {  
	  // Check numbers to 5 digits of precision  
	  $epsilon = 0.00001;  
		
	  $float1 = (float)$float1;  
	  $float2 = (float)$float2;  
		
	  switch ($operator)  
	  {  
		  // equal  
		  case "=":  
		  case "eq":  
			  if (abs($float1 - $float2) < $epsilon) {  
				  return true;  
			  }  
			  break;    
		  // less than  
		  case "<":  
		  case "lt":  
			  if (abs($float1 - $float2) < $epsilon) {  
				  return false;  
			  } else {  
				  if ($float1 < $float2) {  
					  return true;  
				  }  
			  }  
			  break;    
		  // less than or equal  
		  case "<=":  
		  case "lte":  
			  if (compareFloatNumbers($float1, $float2, '<') || compareFloatNumbers($float1, $float2, '=')) {  
				  return true;  
			  }  
			  break;    
		  // greater than  
		  case ">":  
		  case "gt":  
			  if (abs($float1 - $float2) < $epsilon) {  
				  return false;  
			  } else {  
				  if ($float1 > $float2) {  
					  return true;  
				  }  
			  }  
			  break;    
		  // greater than or equal  
		  case ">=":  
		  case "gte":  
			  if (compareFloatNumbers($float1, $float2, '>') || compareFloatNumbers($float1, $float2, '=')) {  
				  return true;  
			  }  
			  break;    
		
		  case "<>":  
		  case "!=":  
		  case "ne":  
			  if (abs($float1 - $float2) > $epsilon) {  
				  return true;  
			  }  
			  break;    
		  default:  
			  die("Unknown operator '".$operator."' in compareFloatNumbers()");    
	  }  
		
	  return false;  
  } 

  /**
   * numberToWords()
   * 
   * @param mixed $number
   * @return
   */
  function numberToWords($number)
  {
      $says = array(
          'zero',
          'one',
          'two',
          'three',
          'four',
          'five',
          'six',
          'seven',
          'eight',
          'nine',
          'ten',
          'eleven',
          'twelve',
          'thirteen',
          'fourteen',
          'fifteen',
          'sixteen',
          'seventeen',
          'eighteen',
          'nineteen',
          'twenty',
          30 => 'thirty',
          40 => 'fourty',
          50 => 'fifty',
          60 => 'sixty',
          70 => 'seventy',
          80 => 'eighty',
          90 => 'ninety',
          100 => 'hundred',
          1000 => 'thousand');
      $number_in_words = '';
      if (is_numeric($number)) {
          $number = (int)round($number);
          if ($number < 0) {
              $number = -$number;
              $number_in_words = 'minus ';
          }
          if ($number > 1000) {
              $number_in_words = $number_in_words . numberToWords(floor($number / 1000)) . " " . $says[1000];
              $hundreds = $number % 1000;
              $tens = $hundreds % 100;
              if ($hundreds > 100) {
                  $number_in_words = $number_in_words . ", " . numberToWords($hundreds);
              } elseif ($tens) {
                  $number_in_words = $number_in_words . " and " . numberToWords($tens);
              }
          } elseif ($number > 100) {
              $number_in_words = $number_in_words . numberToWords(floor($number / 100)) . " " . $says[100];
              $tens = $number % 100;
              if ($tens) {
                  $number_in_words = $number_in_words . " and " . numberToWords($tens);
              }
          } elseif ($number > 20) {
              $number_in_words = $number_in_words . " " . $says[10 * floor($number / 10)];
              $units = $number % 10;
              if ($units) {
                  $number_in_words = $number_in_words . numberToWords($units);
              }
          } else {
              $number_in_words = $number_in_words . " " . $says[$number];
          }
          return $number_in_words;
      }
      return false;
  }
  
  /**
   * wordsToNumber()
   * 
   * @param mixed $number
   * @return
   */
  function wordsToNumber($data) {
	$data = strtr(
		$data,
		array(
			'zero'      => '0',
			'a'         => '1',
			'one'       => '1',
			'two'       => '2',
			'three'     => '3',
			'four'      => '4',
			'five'      => '5',
			'six'       => '6',
			'seven'     => '7',
			'eight'     => '8',
			'nine'      => '9',
			'ten'       => '10',
			'eleven'    => '11',
			'twelve'    => '12',
			'thirteen'  => '13',
			'fourteen'  => '14',
			'fifteen'   => '15',
			'sixteen'   => '16',
			'seventeen' => '17',
			'eighteen'  => '18',
			'nineteen'  => '19',
			'twenty'    => '20',
			'thirty'    => '30',
			'forty'     => '40',
			'fourty'    => '40',
			'fifty'     => '50',
			'sixty'     => '60',
			'seventy'   => '70',
			'eighty'    => '80',
			'ninety'    => '90',
			'hundred'   => '100',
			'thousand'  => '1000',
			'million'   => '1000000',
			'billion'   => '1000000000',
			'and'       => '',
		)
	);
  
	$parts = array_map(
		function ($val) {
			return floatval($val);
		},
		preg_split('/[\s-]+/', $data)
	);
  
	$stack = new SplStack; 
	$sum   = 0; 
	$last  = null;
  
	foreach ($parts as $part) {
		if (!$stack->isEmpty()) {
			if ($stack->top() > $part) {
				if ($last >= 1000) {
					$sum += $stack->pop();
					$stack->push($part);
				} else {
					$stack->push($stack->pop() + $part);
				}
			} else {
				$stack->push($stack->pop() * $part);
			}
		} else {
			$stack->push($part);
		}
  
		$last = $part;
	}
  
	return $sum + $stack->pop();
  }

  /**
   * timesince()
   * 
   * @param int $original
   * @return
   */
  function timesince($original)
  {
      // array of time period chunks
      $chunks = array(
          array(60 * 60 * 24 * 365, 'year'),
          array(60 * 60 * 24 * 30, 'month'),
          array(60 * 60 * 24 * 7, 'week'),
          array(60 * 60 * 24, 'day'),
          array(60 * 60, 'hour'),
          array(60, 'min'),
          array(1, 'sec'),
          );

      $today = time();
       /* Current unix time  */
      $since = $today - $original;

      // $j saves performing the count function each time around the loop
      for ($i = 0, $j = count($chunks); $i < $j; $i++) {
          $seconds = $chunks[$i][0];
          $name = $chunks[$i][1];

          // finding the biggest chunk (if the chunk fits, break)
          if (($count = floor($since / $seconds)) != 0) {
              break;
          }
      }

      $print = ($count == 1) ? '1 ' . $name : "$count {$name}s";

      if ($i + 1 < $j) {
          // now getting the second item
          $seconds2 = $chunks[$i + 1][0];
          $name2 = $chunks[$i + 1][1];

          // add second item if its greater than 0
          if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
              $print .= ($count2 == 1) ? ', 1 ' . $name2 : " $count2 {$name2}s";
          }
      }
      return $print . ' ' . Lang::$say->_AGO;
  } 



  /**
   * searchforValue()
   * 
   * @param bool $value
   * @return
   */
  function searchforValue($array, $key, $value)
  {
	  if($array) {
		  foreach ($array as $val) {
			  if ($val->$key == $value) {
				  return true;
			  }
		  }
		  return false;
	  }
  }

  /**
   * findInArray()
   * 
   * @param mixed $array
   * @param mixed $val1
   * @param mixed $val2
   * @return
   */
  function findInArray($array, $val1, $val2)
  {
	  if($array) {
		  $result = array();
		  foreach ($array as $val) {
			  if ($val->$val1 == $val2) {
				  $result[] = $val;
			  }
		  }
		  return ($result) ? $result : 0;
	  }
  }

  /**
   * countInArray()
   * 
   * @param mixed $array
   * @param mixed $key
   * @param mixed $value
   * @return
   */
  function countInArray($array, $key, $value)
  {
      $i = 0;
      foreach ($array as $k => $v)
          $i++;      {
          if ($v->$key === $value)
              return $i;
      }
      return false;
  }
  

    
  /**
   * dodate()
   * 
   * @param mixed $format
   * @param mixed $date
   * @return
   */
  function dodate($format, $date)
  {

      return strftime($format, strtotime($date));
  }

  /**
   * getTime()
   * 
   * @return
   */
  function getTime()
  {
      $timer = explode(' ', microtime());
      $timer = $timer[1] + $timer[0];
      return $timer;
  }

//-----------------------------------------------------------------------------

function genRequestKey($salt='') {
   $unique=sha1(getVisitingIP().'|'.date("jzSN").'|'.$salt.'|'.$_SERVER['HTTP_USER_AGENT'].SITEURL);
   if($unique){return $unique;}
  }

//-----------------------------------------------------------------------------

function getVisitingIP() {
		if ( function_exists( 'apache_request_headers' ) ) {
			$headers = apache_request_headers();
		} else {
			$headers = $_SERVER;
		}
		if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			$the_ip = $headers['X-Forwarded-For'];
		} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
		) {
			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
		} else {
			$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
		}
		if(!$the_ip){$the_ip=$_SERVER['REMOTE_ADDR'];}
		return $the_ip;
	}

//-----------------------------------------------------------------------------  

function displayMyDate($datestr,$format="d M Y, H:i"){
$DateDisp=strtotime($datestr);
$DateDisp=date($format,$DateDisp);
if($datestr=='0000-00-00 00:00:00'){$DateDisp='-';}
return $DateDisp;
}
//-----------------------------------------------------------------------------  

function displayDate($datestr,$format="d M Y"){
if($datestr){
$format="d M Y";
//$engFullNames = array('January','February','March','April','May','June','July','August','September','October','November','December');
//$traFullNames = array(Lang::$say->_JAN_,Lang::$say->_FEB_,Lang::$say->_MAR_,Lang::$say->_APR_,Lang::$say->_MAY_,Lang::$say->_JUN_,Lang::$say->_JUL_,Lang::$say->_AUG_,Lang::$say->_SEP_,Lang::$say->_OCT_,Lang::$say->_NOV_,Lang::$say->_DEC_);
$engShortNames = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
$traShortNames = array(Lang::$say->_JA_,Lang::$say->_FE_,Lang::$say->_MA_,Lang::$say->_AP_,Lang::$say->_MY_,Lang::$say->_JU_,Lang::$say->_JL_,Lang::$say->_AU_,Lang::$say->_SE_,Lang::$say->_OC_,Lang::$say->_NO_,Lang::$say->_DE_);
$DateDisp=strtotime($datestr);
$DateDisp=date($format,$DateDisp);

$dt = str_ireplace($engShortNames, $traShortNames, $DateDisp);
return $dt;}else{return false;}
}
//-----------------------------------------------------------------------------  
/**
* [sanitize_output Compress the php output]
* @param  [type] $buffer [ Buffer = ob_get_contents(); ]
* @return [type]         [ string ]
*/
function sanitize_output($buffer)
{

$search = array(
'/\>[^\S ]+/s',         //strip whitespaces after tags, except space
'/[^\S ]+\</s',         //strip whitespaces before tags, except space
'/(\s)+/s',             // shorten multiple whitespace sequences
'/<!--(.|\s)*?-->/',    //strip HTML comments
'#(?://)?<!\[CDATA\[(.*?)(?://)?\]\]>#s', //leave CDATA alone
);
$replace = array(
'>',
'<',
'\\1',
'',
"//<![CDATA[\n".'\1'."\n//]]>",//"//<![CDATA[".'\1'."//]]>",
);
$buffer = preg_replace($search, $replace, $buffer);
return $buffer;
}
//----------------------------------------------------------------------------- 

function invcolor($color){
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = 255 - hexdec(substr($color,(2*$x),2));
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
    return '#'.$rgb;
}
//----------------------------------------------------------------------------- 
function dkncolor($rgb, $darker=1.3) {

    $hash = (strpos($rgb, '#') !== false) ? '#' : '';
    $rgb = (strlen($rgb) == 7) ? str_replace('#', '', $rgb) : ((strlen($rgb) == 6) ? $rgb : false);
    if(strlen($rgb) != 6) return $hash.'000000';
    $darker = ($darker > 1) ? $darker : 1;

    list($R16,$G16,$B16) = str_split($rgb,2);

    $R = sprintf("%02X", floor(hexdec($R16)/$darker));
    $G = sprintf("%02X", floor(hexdec($G16)/$darker));
    $B = sprintf("%02X", floor(hexdec($B16)/$darker));

    return $hash.$R.$G.$B;
}
//----------------------------------------------------------------------------- 
function hextorgbvalues($hex) 
{
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);

        return $rgb;
}

//----------------------------------------------------------------------------- 
function displayDash($value) {
      if(intval($value===0) || !trim($value)){return('-');}else{return($value);}
  }

//----------------------------------------------------------------------------- 
function isEmailValid($email)
	  {
		  if (function_exists('filter_var')) {
			  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				  return true;
			  } else
				  return false;
		  } else
			  return preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $email);
	  }
function formatjsvar($text) {
	return addslashes($text);
}
//----------------------------------------------------------------------------- 
function jsDateMonthNames($mode) {
      switch($mode){
case "ms": $return = '["'.formatjsvar(Lang::$say->_JA_).'","'.formatjsvar(Lang::$say->_FE_).'","'.formatjsvar(Lang::$say->_MA_).'","'.formatjsvar(Lang::$say->_AP_).'","'.formatjsvar(Lang::$say->_MY_).'","'.formatjsvar(Lang::$say->_JU_).'","'.formatjsvar(Lang::$say->_JL_).'","'.formatjsvar(Lang::$say->_AU_).'","'.formatjsvar(Lang::$say->_SE_).'","'.formatjsvar(Lang::$say->_OC_).'","'.formatjsvar(Lang::$say->_NO_).'","'.formatjsvar(Lang::$say->_DE_).'"]'; 
	break; 
case "mf": $return = '["'.formatjsvar(Lang::$say->_JAN).'","'.formatjsvar(Lang::$say->_FEB).'","'.formatjsvar(Lang::$say->_MAR).'","'.formatjsvar(Lang::$say->_APR).'","'.formatjsvar(Lang::$say->_MAY).'","'.formatjsvar(Lang::$say->_JUN).'","'.formatjsvar(Lang::$say->_JUL).'","'.formatjsvar(Lang::$say->_AUG).'","'.formatjsvar(Lang::$say->_SEP).'","'.formatjsvar(Lang::$say->_OCT).'","'.formatjsvar(Lang::$say->_NOV).'","'.formatjsvar(Lang::$say->_DEC).'"]'; 
	break; 
  case "df": $return = '["'.formatjsvar(Lang::$say->_SUNDAY).'","'.formatjsvar(Lang::$say->_MONDAY).'","'.formatjsvar(Lang::$say->_TUESDAY).'","'.formatjsvar(Lang::$say->_WEDNESDAY).'","'.formatjsvar(Lang::$say->_THURSDAY).'","'.formatjsvar(Lang::$say->_FRIDAY).'","'.formatjsvar(Lang::$say->_SATURDAY).'"]'; 
	break; 
case "ds": $return = '["'.formatjsvar(Lang::$say->_SUN).'","'.formatjsvar(Lang::$say->_MON).'","'.formatjsvar(Lang::$say->_TUE).'","'.formatjsvar(Lang::$say->_WED).'","'.formatjsvar(Lang::$say->_THU).'","'.formatjsvar(Lang::$say->_FRI).'","'.formatjsvar(Lang::$say->_SAT).'"]'; 	  
	  break;   
	  }
	  return($return);
  }
//-----------------------------------------------------------------------------
function neatName($string)
  {
	  $string = str_replace(array(
          ' ',
          '/',
          '?',
          ';'), array(
          "",
          ".",
          '',
          ''), $string);
      return $string;
  }
//----------------------------------------------------------------------------- 
function makeNewFileName($bid,$fileName) {
$newFileName = sanitize($fileName);
$tempName = explode(".", $fileName);
$fileName = str_replace(' ','-',$fileName);
$fileName = str_replace('_','-',$fileName);
$fileName = str_replace('---','-',$fileName);
$fileName = str_replace('--','-',$fileName);
$fileName = truncate($fileName,200,'');
$fileExtension = strtolower(end($tempName));
$newFileName = str_replace('.'.$fileExtension,'_'.$bid.'-'.round(microtime(true)).'.'.$fileExtension,$fileName);
return $newFileName;
  }
  
//----------------------------------------------------------------------------- 
function fileEasySize($bytes)
  {
      if ($bytes >= 1073741824) {
          $bytes = number_format($bytes / 1073741824, 0) . ' GB';
      } elseif ($bytes >= 1048576) {
          $bytes = number_format($bytes / 1048576, 0) . ' MB';
      } elseif ($bytes >= 1024) {
          $bytes = number_format($bytes / 1024, 0) . ' KB';
      } elseif ($bytes > 1) {
          $bytes = $bytes . ' bytes';
      } elseif ($bytes == 1) {
          $bytes = $bytes . ' byte';
      } else {
          $bytes = '0 bytes';
      }

      return $bytes;
  }  

//----------------------------------------------------------------------------- 

function numFormatDisplay($amount,$curr=false,$decimals=2)
	  {
		if($curr){$currtext = Vault::get("Gist")->site_currsym .' ';}else{$currtext='';}
		if(Vault::get("Gist")->site_dsep=='.'){$tsep=',';$dsep='.';}else{$tsep='.';$dsep=',';}
		return ($amount == 0) ? '0': $currtext.preg_replace('~\\'.$dsep.'0+$~','',number_format($amount,$decimals,$dsep,$tsep));
	  }

function numInputToMyVal($value)
  {
     if(Vault::get("Gist")->site_dsep!='.'){
	 return floatval(str_replace(',','.', $value));
	 }else{return floatval($value);}
  }

function myValToNumInput($value)
  {
      if(Vault::get("Gist")->site_dsep!='.'){
	  if($value>0){
	  return str_replace('.',',', $value);}else{return '';}
	  }else{return $value;}
  }


?>