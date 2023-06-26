<?php

  /**
   * Niceids
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: niceids.inc.php, v1.1.0 Feb 2018 transinova $
   */
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');


class niceIds{
	private $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N', 'O','P','Q','R','S','T','U','V','W','X','Y','Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	private $mtx = array();
	private $key;


	public function __construct($key='193578642aBcDefGHiJklmNOpQrsTUVwZXy') {
		
		$this->key = $this->salting($key);	
        
        for($x = 0; $x < strlen($this->key); $x++) {
                $start_position = array_search($this->key[$x], $this->alphabet);
                $array1 = array_slice($this->alphabet, $start_position, count($this->alphabet));
                $array2 = array_slice($this->alphabet, 0, $start_position);
                $mtx[$x] = array_merge($array1, $array2);
        }
        
        $this->mtx = $mtx;
	}


	public function makenice($txt_o){
        $txt_c = '';
        $txt_o = str_replace(array(" ",".",",",";",":","à","è","é","ì","ò","ù","-","_"),array('SP','STOP','VIR','DOTVR', '2DT', 'aGR','eGR','eAC','iGR','oGR','uGR','Dsh','uSc'), $txt_o);
		for($i = 0; $i < strlen($txt_o); $i++) {
            $char = substr($txt_o, $i, 1);
                $original_position = array_search($char, $this->alphabet);
                $txt_c .= $this->mtx[$i % strlen($this->key)][$original_position];
        }
        
        return $txt_c;
	}


	function restore($txt_c){
		$txt_o = "";
		
        $k = 0;
        for($i = 0; $i < strlen($txt_c); $i++) {
            $char_c = substr($txt_c, $i, 1);            
                $position_c = array_search($char_c, $this->mtx[$k]);
                $txt_o .= $this->alphabet[$position_c];            
            if($k == strlen($this->key) -1)
                $k = 0;
            else
                $k++;
        }
        
        $txt_o = str_replace(array('SP','STOP','VIR','DOTVR', '2DT', 'aGR','eGR','eAC','iGR','oGR','uGR','Dsh','uSc'), array(" ",".",",",";",":","à","è","é","ì","ò","ù","-","_"), $txt_o);
        
        return $txt_o;
	}
    

    private function salting($key) {
        $key = str_replace(array(" ",".",",",";"),"", $key);
        $array = array();
        for($i = 0; $i < strlen($key); $i++) {
            $char = substr($key, $i, 1);
            if(!in_array($char, $array))
                array_push($array, $char);
            else
                continue;
        }
        
        $key = '';
        for($i = 0; $i < count($array); $i++)
            $key .= $array[$i];
        
        return $key;
    }
}
?>