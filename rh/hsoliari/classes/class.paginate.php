<?php
  /**
   * Class Pagination
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: class.paginate.php, v1.1.0 Feb 2018 transinova $
   */
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');
  
  class Paginator
  {
      public $items_per_page;
      public $items_total;
      public $num_pages = 1;
      public $limit;
	  public $current_page;
      public $default_ipp;
	  public $path = 0;
	  public $path_after;
	  public $live;
	  public $begin;
	  public $end;
	  public $parentid;
	  public $command;
      private $mid_range;
      private $low;
      private $high;
      private $retdata;
      private $querystring;
	  private static $instance; 
      
      
      /**
       * Paginator::__construct()
       * 
       * @return
       */
      private function __construct()
      {
          $this->current_page = 1;
          $this->mid_range = 7;
          $this->items_per_page = (isset($_GET['ipp']) and !empty($_GET['ipp'])) ? sanitize($_GET['ipp']) : $this->default_ipp;
      }

      /**
       * Paginator::instance()
       * 
       * @return
       */
	  public static function instance(){
		  if (!self::$instance){ 
			  self::$instance = new Paginator(); 
		  } 
	  
		  return self::$instance;  
	  }
	     
      /**
       * Paginator::paginate()
       * 
       * @return
       */
      public function paginate()
      {	
		  $this->items_per_page = (isset($_GET['ipp']) and !empty($_GET['ipp'])) ? intval($_GET['ipp']) : $this->default_ipp;
          $this->num_pages = ceil($this->items_total / $this->items_per_page);
          
		  if(!$this->live){
          $this->current_page = intval(sanitize(get('pg')));}
          if ($this->current_page < 1 or !is_numeric($this->current_page))
              $this->current_page = 1;
          if ($this->current_page > $this->num_pages)
              $this->current_page = $this->num_pages;
          $prev_page = $this->current_page - 1;
          $next_page = $this->current_page + 1;
          

		  if (isset($_GET)) {
              $args = explode("&amp;", $_SERVER['QUERY_STRING']);
              foreach ($args as $arg) {
                  $keyval = explode("=", $arg);
                  if ($keyval[0] != "pg" && $keyval[0] != "ipp")
                      $this->querystring .= "&amp;" . sanitize($arg);
              }
          }
          
          if (isset($_POST)) {
              foreach ($_POST as $key => $val) {
                  if ($key != "pg" && $key != "ipp")
                      $this->querystring .= "&amp;$key=" . sanitize($val);
              }
          }
		  if($this->live){$this->querystring='';}
          if ($this->num_pages > 1) {
              if ($this->current_page != 1 && $this->items_total >= $this->default_ipp) {
                  if ($this->path) {
					  $this->retdata = "<li><a class=\"item\" href=\"".$this->path."pg=".$prev_page."{$this->path_after}\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a></li>";
                  } else {
                      $this->retdata = "<li><a class=\"item\" href=\"" . phpself() . "?pg=$prev_page&amp;ipp=$this->items_per_page$this->querystring\"><span class=\"glyphicon glyphicon-chevron-left\"></span></li></a>";
                  }
              } else {
                  $this->retdata = "<li class=\"disabled\"><a class=\"item\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a></li>";
              }
              
              $this->start_range = $this->current_page - floor($this->mid_range / 2);
              $this->end_range = $this->current_page + floor($this->mid_range / 2);
              
              if ($this->start_range <= 0) {
                  $this->end_range += abs($this->start_range) + 1;
                  $this->start_range = 1;
              }
              if ($this->end_range > $this->num_pages) {
                  $this->start_range -= $this->end_range - $this->num_pages;
                  $this->end_range = $this->num_pages;
              }
              $this->range = range($this->start_range, $this->end_range);
              
              for ($i = 1; $i <= $this->num_pages; $i++) {
                  if ($this->range[0] > 2 && $i == $this->range[0])
                      $this->retdata .= "<li class=\"disabled\"><a class=\"item\"> ... </a></li>";

                  if ($i == 1 or $i == $this->num_pages or in_array($i, $this->range)) {
                      if ($i == $this->current_page) {
                          $this->retdata .= "<li class=\"active\"><a class=\"item\">$i</a></li>";
                      } else {
                          if ($this->path) {
							  $this->retdata .= "<li><a class=\"item\" href=\"".$this->path."pg=$i{$this->path_after}\">$i</a></li>";
                          } else {
                              $this->retdata .= "<li><a class=\"item\" href=\"" . phpself() . "?pg=$i&amp;ipp=$this->items_per_page$this->querystring\">$i</a></li>";
                          }
                      }
                  }

                  if ($this->range[$this->mid_range - 1] < $this->num_pages - 1 && $i == $this->range[$this->mid_range - 1])
                      $this->retdata .= "<li class=\"disabled\"><a class=\"item\"> ... </a></li>";
              }

              if ($this->current_page != $this->num_pages && $this->items_total >= $this->default_ipp) {
                  if ($this->path) {
					  $this->retdata .= "<li><a class=\"item\" href=\"".$this->path."pg=".$next_page."{$this->path_after}\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a></li>";
                  } else {
                      $this->retdata .= "<li><a class=\"item\" href=\"" . phpself() . "?pg=$next_page&amp;ipp=$this->items_per_page$this->querystring\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a></li>";
                  }
              } else {
                  $this->retdata .= "<li class=\"disabled\"><a class=\"item\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a></li>";
              }
			  
          } else {
              for ($i = 1; $i <= $this->num_pages; $i++) {
                  if ($i == $this->current_page) {
                      $this->retdata .= "<li class=\"active\"><a class=\"item\" href=\"javascript:void(0);\">$i</a></li>";
                  } else {
					  if ($this->path) {
						  $this->retdata .= "<li><a class=\"item\" href=\"".$this->path . "pg=$i{$this->path_after}\">$i</a></li>";
					  } else {
                          $this->retdata .= "<li><a class=\"item\" href=\"" . phpself() . "?pg=$i&amp;ipp=$this->items_per_page$this->querystring\">$i</a></li>";
					  }
                  }
              }
          }
          $this->low = ($this->current_page - 1) * $this->items_per_page;
          $this->high = $this->current_page * $this->items_per_page - 1;
          $this->limit = ($this->items_total == 0) ? '' : " LIMIT $this->low,$this->items_per_page";
      }
      
      /**
       * Paginator::items_per_page()
       * 
       * @return
       */
      public function items_per_page()
      {
          $items = '';
          $ipp_array = array(10, 25, 50, 75, 100);
		  $items .= "<option  value=\"\">" . Lang::$say->_PAG_IPP . "</option>";
          foreach ($ipp_array as $ipp_opt)
              $items .= ($ipp_opt == $this->items_per_page) ? "<option selected=\"selected\" value=\"$ipp_opt\">$ipp_opt</option>\n" : "<option value=\"$ipp_opt\">$ipp_opt</option>\n";
          return ($this->num_pages >= 1) ? "<select class=\"selectbox\" onchange=\"window.location='" . phpself() . "?pg=1&amp;ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n" : '';
      }
      
      /**
       * Paginator::jump_menu()
       * 
       * @return
       */
      public function jump_menu()
      {
          $option = '';
		  $option .= "<option  value=\"\">" . Lang::$say->_PAG_GOTO . "</option>";
          for ($i = 1; $i <= $this->num_pages; $i++) {
              $option .= ($i == $this->current_page) ? "<option value=\"$i\" selected=\"selected\">$i</option>\n" : "<option value=\"$i\">$i</option>\n";
          }
          return ($this->num_pages >= 1) ? "<select class=\"selectbox\" onchange=\"window.location='" . phpself() . "?pg='+this[this.selectedIndex].value+'&amp;ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n" : '';
      }


      /**
       * Paginator::display_pages()
       * 
       * @return
       */
      public function display_pages()
      {
          return($this->items_total > $this->items_per_page) ? '<nav><ul class="pagination">' . $this->retdata . '</ul></nav>' : "";
      }
	        
      /**
       * Paginator::display_paging()
       * 
       * @return
       */
      public function display_paging()
      {
          return($this->items_total > $this->items_per_page) ? '<nav><ul class="pagination" id="livepaging_'.$this->parentid.'" data-option="'.$this->command.'"  data-auth="'.genRequestKey($this->command).'">' . $this->retdata . '</ul></nav>' : "";
      }
  }
?>