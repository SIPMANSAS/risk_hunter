<?php
  /**
   * Calendar Class
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: class.calendar.php, v1.1.2 Nov 2018 transinova $
   */
  
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');
  
  class Calendar
  {

	  const bdetTable = "calendar_details";
	  const bdatTable = "calendar_data";
	  const bfilesTable = "calendar_files";
	  
      public $weekDayNameLength;
	  public $monthNameLength;
      private $arrWeekDays = array();
      private $arrMonths = array();
      private $pars = array();
      private $today = array();
      private $prevYear = array();
      private $nextYear = array();
      private $prevMonth = array();
      private $nextMonth = array();
	  public $eventMonth;
	  public $daterange;
	  public $ppttype;
	  public $availcolor;
	  public $navailcolor;
	  public $availstatus;
	  public $navailstatus;
	  public $weekStartedDay;
	  public $jsweekStartedDay;
	  private static $db;


      /**
       * Calendar::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Vault::get("Database");		  
		  $this->weekStartedDay = $this->setWeekStart();
		  if($this->setWeekStart()>1){$this->jsweekStartedDay='1';}else
		  {$this->jsweekStartedDay='0';}
		  $this->weekDayNameLength = "short";
		  $this->monthNameLength = "long";
		  $this->init();
      }

	  /**
	   * Calendar::init()
	   * 
	   * @return
	   */
	  private function init()
	  {
          $year = (isset($_POST['year']) && $this->checkYear($_POST['year'])) ? intval($_POST['year']) : date("Y");
          $month = (isset($_POST['month']) && $this->checkMonth($_POST['month'])) ? intval($_POST['month']) : date("m");
          $day = (isset($_POST['day']) && $this->checkDay($_POST['day'])) ? intval($_POST['day']) : date("d");
		  $ldim = $this->calcDays($month, $day);		  
		  if($day > $ldim) {
		  	$day = $ldim;
		  }
		  $this->ppttype = (isset($_POST['ppttype'])) ? intval($_POST['ppttype']) : Vault::get("Vhrental")->ppttype;
		  $this->availcolor = Vault::get("Vhrental")->availcolor;
		  $this->navailcolor = Vault::get("Vhrental")->navailcolor;
		  $this->availstatus = Vault::get("Vhrental")->availstatus; 		
		  $this->navailstatus = Vault::get("Vhrental")->navailstatus;
          $cdate = getdate(mktime(0, 0, 0, $month, $day, $year));

          $this->pars["year"] = $cdate['year'];
          $this->pars["month"] = $this->toDecimal($cdate['mon']);
          $this->pars["nmonth"] = $cdate['mon'];
          $this->pars["month_full_name"] = $cdate['month'];
          $this->pars["day"] = $day;
          $this->today = getdate();

          $this->prevYear = getdate(mktime(0, 0, 0, $this->pars['month'], $this->pars["day"], $this->pars['year'] - 1));
          $this->nextYear = getdate(mktime(0, 0, 0, $this->pars['month'], $this->pars["day"], $this->pars['year'] + 1));
          $this->prevMonth = getdate(mktime(0, 0, 0, $this->pars['month'] - 1, $this->calcDays($this->pars['month']-1,$this->pars["day"]), $this->pars['year']));
          $this->nextMonth = getdate(mktime(0, 0, 0, $this->pars['month'] + 1, $this->calcDays($this->pars['month']+1,$this->pars["day"]), $this->pars['year']));

          $this->arrWeekDays[0] = array("mini" => Lang::$say->_SU, "short" => Lang::$say->_SUN, "long" => Lang::$say->_SUNDAY);
          $this->arrWeekDays[1] = array("mini" => Lang::$say->_MO, "short" => Lang::$say->_MON, "long" => Lang::$say->_MONDAY);
          $this->arrWeekDays[2] = array("mini" => Lang::$say->_TU, "short" => Lang::$say->_TUE, "long" => Lang::$say->_TUESDAY);
          $this->arrWeekDays[3] = array("mini" => Lang::$say->_WE, "short" => Lang::$say->_WED, "long" => Lang::$say->_WEDNESDAY);
          $this->arrWeekDays[4] = array("mini" => Lang::$say->_TH, "short" => Lang::$say->_THU, "long" => Lang::$say->_THURSDAY);
          $this->arrWeekDays[5] = array("mini" => Lang::$say->_FR, "short" => Lang::$say->_FRI, "long" => Lang::$say->_FRIDAY);
          $this->arrWeekDays[6] = array("mini" => Lang::$say->_SA, "short" => Lang::$say->_SAT, "long" => Lang::$say->_SATURDAY);
		  
		  $this->arrMonths[1] = array("short" => Lang::$say->_JA_, "long" => Lang::$say->_JAN);
		  $this->arrMonths[2] = array("short" => Lang::$say->_FE_, "long" => Lang::$say->_FEB);
		  $this->arrMonths[3] = array("short" => Lang::$say->_MA_, "long" => Lang::$say->_MAR);
		  $this->arrMonths[4] = array("short" => Lang::$say->_AP_, "long" => Lang::$say->_APR);
		  $this->arrMonths[5] = array("short" => Lang::$say->_MY_, "long" => Lang::$say->_MAY);
		  $this->arrMonths[6] = array("short" => Lang::$say->_JU_, "long" => Lang::$say->_JUN);
		  $this->arrMonths[7] = array("short" => Lang::$say->_JL_, "long" => Lang::$say->_JUL);
		  $this->arrMonths[8] = array("short" => Lang::$say->_AU_, "long" => Lang::$say->_AUG);
		  $this->arrMonths[9] = array("short" => Lang::$say->_SE_, "long" => Lang::$say->_SEP);
		  $this->arrMonths[10] = array("short" => Lang::$say->_OC_, "long" => Lang::$say->_OCT);
		  $this->arrMonths[11] = array("short" => Lang::$say->_NO_, "long" => Lang::$say->_NOV);
		  $this->arrMonths[12] = array("short" => Lang::$say->_DE_, "long" => Lang::$say->_DEC);
	  }
	 

	  
      /**
       * Calendar::renderCalendar()
       * 
	   * @param mixed $type
	   * @param year $type
	   * @param ppttype $type
       * @return
       */
      public function renderCalendar($type = false, $year=false, $ppttype=false, $keyword=false)
      {
$info = '<div class="alert alert-warning margin-top-15" role="alert"><div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOASGN . '</p></div></div>';		
			
			switch($type){
			case 'yeardata': 
				if(Vault::get("Vhrental")->anyAssigned()){
				return sanitize_output($this->renderYearCalendar($year,$ppttype));}
				else {return sanitize_output($info);}
			break;
			case 'yearlist': 
				if(Vault::get("Vhrental")->anyAssigned()){
				return sanitize_output($this->renderYearList($year,$ppttype));}
				else {return sanitize_output($info);}
			break;
			case 'list':
				if(Vault::get("Vhrental")->anyAssigned()){
				echo sanitize_output($this->renderYearList($year,$ppttype));}
				else {echo sanitize_output($info);}
			break;
			case 'searchlist': 
				if(Vault::get("Vhrental")->anyAssigned()){
				return sanitize_output($this->renderSearchList($keyword));}
				else {return sanitize_output($info);}
			break;			
			default:
				if(Vault::get("Vhrental")->anyAssigned()){
				echo sanitize_output($this->renderYearCalendar($year,$ppttype));}
				else {echo sanitize_output($info);}
			break;				
			} 
      }
	  

      public function renderCalendarM($type=false,$month=false,$year=false,$ppttype=false,$psview=false,$months=false)
      {
		  if($year){
		  if($year<(date("Y")-CFG_PUBLPASTYEARS)){$year=(date("Y")-CFG_PUBLPASTYEARS);}
		  }
		switch($type){
		case 'monthdata': return sanitize_output($this->renderMonthCalendar($month,$year,$ppttype,$psview,$months));
		break;
		default:
		echo sanitize_output($this->renderMonthCalendar($month,$year,$ppttype,$psview,$months));
		break;
				
			}		  
		  
	  }
	
      /**
       * Calendar::checkDatesRange()
       * 
       * @return
       */
      public function checkDatesRange()
      {	  
			$this->checkDatesAvail();
		}


/**
* Calendar::createDateRangeArray()
* 
* @param mixed $fromYear
* @param mixed $fromMonth
* @param mixed $fromDay
* @param mixed $toYear
* @param mixed $toMonth
* @param mixed $toDay
* @return
*/
private static function createDateRangeArray($fromYear, $fromMonth, $fromDay, $toYear, $toMonth, $toDay) {
	  
		  //$fromTime = mktime(0,0,0,$fromMonth,$fromDay,$fromYear);
		  //$toTime = mktime(0,0,0,$toMonth,$toDay,$toYear);
		  //$howManyDays = ceil(($toTime-$fromTime)/60/60/24);
		  
      		$fromTime = new DateTime($fromDay.'-'.$fromMonth.'-'.$fromYear);
      		$toTime = new DateTime($toDay.'-'.$toMonth.'-'.$toYear);
      		$howManyDays = $toTime->diff($fromTime)->format("%a");
		  	$listdays = array();
		  
		  for ($day = 0; $day <= $howManyDays; $day++) {
			  $dateYear = date("Y", mktime(0, 0, 0, $fromMonth, ($fromDay + $day), $fromYear));
			  $dateMonth = date("m", mktime(0, 0, 0, $fromMonth, ($fromDay + $day), $fromYear));
			  $dateDay = date("d", mktime(0, 0, 0, $fromMonth, ($fromDay + $day), $fromYear));
			  $listdays[$day] = $dateYear . "-" . $dateMonth . "-" . $dateDay;
		  }
		  
		  return $listdays;
}

/**
* Calendar::countDateRange()
* 
* @param mixed $fromYear
* @param mixed $fromMonth
* @param mixed $fromDay
* @param mixed $toYear
* @param mixed $toMonth
* @param mixed $toDay
* @return
*/
private static function countDateRange($fromYear, $fromMonth, $fromDay, $toYear, $toMonth, $toDay) {
	  
		  $fromTime = mktime(0,0,0,$fromMonth,$fromDay,$fromYear);
		  $toTime = mktime(0,0,0,$toMonth,$toDay,$toYear);
		  $howManyDays = ceil(($toTime-$fromTime)/60/60/24);
		  return $howManyDays;
}



/**
* Calendar::setWeekStart()
* 
* @return
*/
private function setWeekStart()
{
		  return Vault::get("Gist")->weekstart;
}

/**
* Calendar::calcDays()
* 
* @param string $month
* @param string $day
* @return
*/
	  private function calcDays($month, $day)
	  {
		  if ($day < 29) {
			  return $day;
		  } elseif ($day == 29) {
			  return ((int)$month == 2) ? 28 : 29;
		  } elseif ($day == 30) {
			  return ((int)$month != 2) ? 30 : 28;
		  } elseif ($day == 31) {
			  return ((int)$month == 2 ? 28 : ((int)$month == 4 || (int)$month == 6 || (int)$month == 9 || (int)$month == 11 ? 30 : 31));
		  } else {
			  return 30;
		  }
	
	  }
	  
/**
* Calendar::toDecimal()
* 
* @param mixed $number
* @return
*/
public function toDecimal($number)
{
          return (($number < 10) ? "0" : "") . $number;
}
	  

/**
* Calendar::checkYear()
* 
* @param string $year
* @return
*/
public function checkYear($year = "")
      {
          return (strlen($year) == 4 or ctype_digit($year)) ? true : false;
}


/**
* Calendar::checkMonth()
* 
* @param string $month
* @return
*/
public function checkMonth($month = "")
      {
          return ((strlen($month) == 2) or ctype_digit($month) or ($month < 12)) ? true : false;
      }


/**
* Calendar::checkDay()
* 
* @param string $day
* @return
*/
private function checkDay($day = "")
      {
          return ((strlen($day) == 2) or ctype_digit($day) or ($day < 31)) ? true : false;
      }


/**
* Calendar::renderYearList()
* 
* @param mixed $year
* @param mixed $ppttype
* @return
*/
private function renderYearList($year=false,$ppttype=false)
	  {
		$rend=false;$disp=false;$calnav=false;$counter=0;
		if(!$year){
        $year = (isset($_POST['year']) && $this->checkYear($_POST['year'])) ? intval($_POST['year']) : date("Y");
		}
		if(!$ppttype){
		$this->ppttype = (isset($_POST['ppttype'])) ? intval($_POST['ppttype']) : Vault::get("Vhrental")->ppttype;
		$ppttype = (isset($_POST['ppttype'])) ? intval($_POST['ppttype']) : Vault::get("Vhrental")->ppttype;
		}else{$this->ppttype = $ppttype;}
		$eppid = makePassId($this->ppttype);
		
		  		
		if((Vault::get("Vhrental")->isPptTypeLocked($ppttype)||Vault::get("Gist")->pptlock) && (Vault::get("Users")->userlevel<8)){$islocked=true;}else{$islocked=false;}
		
		for ($mn = 1; $mn < 13; $mn++) {
			
          $day = date("d");
		  $ldim = $this->calcDays($mn, $day);
		  if($day > $ldim) {
		  	$day = $ldim;
		  }		
		  $cdate = getdate(mktime(0, 0, 0, $mn, $day, $year));
          $prevYear = getdate(mktime(0, 0, 0, $mn, $day, $cdate['year'] - 1));
          $nextYear = getdate(mktime(0, 0, 0, $mn, $day, $cdate['year'] + 1));
		  $is_day = 0;
		  $first_day = getdate(mktime(0, 0, 0, $mn, 1, $cdate['year']));
		  $last_day = getdate(mktime(0, 0, 0, $mn + 1, 0, $cdate['year']));
		  
		  if(Vault::get("Users")->userlevel<7 && Vault::get("Users")->userlevel>5){
			  $userq=" AND e.userid=".(int)Vault::get("Users")->uid;
			  $emptylist=Lang::$say->_BKG_YOURLISTEMPTY;
			  }else{
				  $userq="";
				  $emptylist=Lang::$say->_BKG_LISTEMPTY;
				  }

		  $sql = "SELECT e.*, e.id as bookingid, DAY(checkin) as sday, st.title" . Lang::$lang . " as statustitle, st.colorhex as blockcolor"
		  . "\n FROM " . self::bdetTable . " as e"
		  . "\n LEFT JOIN " . Vhrental::blksTable . " as st ON st.id = e.status "
		  . "\n WHERE ((YEAR(checkin) = " . (int)$cdate['year']
		  . "\n AND MONTH(checkin) = " . (int)$cdate['mon']."))"
		  . "\n AND e.ppttypeid  = " . (int)$ppttype." ".$userq
		  . "\n ORDER BY checkin ASC";

/*		  . "\n WHERE ((YEAR(checkin) = " . (int)$cdate['year']
		  . "\n AND MONTH(checkin) = " . (int)$cdate['mon'].") OR"
		  . "\n (YEAR(checkout) = " . (int)$cdate['year']
		  . "\n AND MONTH(checkout) = " . (int)$cdate['mon'].")) "
		  . "\n AND e.ppttypeid  = " . (int)$ppttype.""
		  . "\n ORDER BY checkin ASC";*/
		  		  
		  $row = self::$db->fetch_all($sql);
		  if($row){
			  $counter++;
			  $rend .= '
<div class="card panel-default">
<div class="card-header"><h3 class="card-title"><span class="moncalnum float-right"> '. str_pad(intval($mn) , 2 , "0" , STR_PAD_LEFT) . '</span>' . $this->arrMonths[$mn][$this->monthNameLength] .'  <span class="d-inline-block d-sm-none"> '. $cdate['year'] . '</span></h3></div>
  <div class="card-body">
    <div class="rowspan yearlist"><table class="restable table table-sm"><tbody>';
			  foreach ($row as $brow) {
				  
$checkin = explode("-",$brow->checkin);
$checkout = explode("-",$brow->checkout);
$numnights = $this->countDateRange($checkin[0],$checkin[1],$checkin[2],$checkout[0],$checkout[1],$checkout[2]);
$numdays = $numnights+1;
if($numnights>1){$numnights = $numnights.' '.Lang::$say->_BKG_NIGHTS;}else{$numnights = $numnights.' '.Lang::$say->_BKG_NIGHT;}
$numdays = $numdays.' '.Lang::$say->_BKG_DAYS.' '.$numnights;

if($brow->guestadult){
if($brow->guestadult>1){$guestadult = $brow->guestadult.' '.Lang::$say->_BKG_GUESTADULTS;}else{$guestadult = $brow->guestadult.' '.strtolower(Lang::$say->_BKG_GUESTADULT);}}else{$guestadult='';}

if($brow->guestchild){
if($brow->guestchild>1){$guestchild = ' '.$brow->guestchild.' '.Lang::$say->_BKG_GUESTCHILDS;}else{$guestchild = ' '.$brow->guestchild.' '.strtolower(Lang::$say->_BKG_GUESTCHILD);}}else{$guestchild='';}
if(!$brow->guestadult && !$brow->guestchild){$guestadult='-';}

$creator = getValue('username', Users::usrTable, "id=".$brow->userid);
if($brow->userid==Vault::get("Users")->uid){$creator .= ' ('.Lang::$say->_ME.')';}
$updater = getValue('username', Users::usrTable, "id=".$brow->updaterid);
if($brow->updaterid==Vault::get("Users")->uid){$updater .= ' ('.Lang::$say->_ME.')';}

$attachments=$this->countAttached($brow->bookingid);


if($this->isCanEditBlock($brow->bookingid)){
	$btnedit='<a class="bked itemaction" href="javascript:void(0);" data-cont="bookingedit" data-id="'.$brow->bookingid.'" data-option="editBoking" data-vmode="yearlist"><span class="glyphicon glyphicon-pencil"></span></a>';
	$btddelete='<a class="bkdel itemaction itemdelete" href="javascript:void(0);" data-listcont="bookingdel" data-id="'.$brow->bookingid.'" data-option="deleteBooking" data-vmode="yearlist" data-name="' . displayDate($brow->checkin) .' - ' . displayDate($brow->checkout) .', '.$brow->statustitle.'"><span class="glyphicon glyphicon-remove"></span></a>';	
	}else{
	$btnedit='';
	$btddelete='';	
	}
if($this->isCanViewDetails($brow->bookingid)){
if($attachments>0){$attachments=' <span class="glyphicon glyphicon-paperclip"></span>';}else{$attachments='';}	
	$btninfo='<a class="bkinf itemaction" href="javascript:void(0);" data-cont="bookinginfo" data-id="'.$brow->bookingid.'" data-option="infoBoking" data-vmode="yearlist"><span class="glyphicon glyphicon-info-sign"></span></a>';
	$guestinfo=$brow->guestname.'<br />'.$guestadult.$guestchild;
	$authorinfo=Lang::$say->_BY.' '.$creator.'<br />'.displayMyDate($brow->created);	
}else{
	$btninfo='';
	$guestinfo='';
	$authorinfo='';
}
				  $rend .= '
          <tr>
            <td width="20%"><span class="colorinlist"><div class="calrel">
<div class="cout s'.$brow->status.'"></div>
<span class="dtnum">'.$brow->sday.'</span>
<div class="chin s'.$brow->status.'"></div>
</div></span> <span class="colorprevtext">'.$brow->statustitle.'</span></td>
            <td>' . displayDate($brow->checkin) .' - ' . displayDate($brow->checkout) .'<br />'.$numdays.'</td>
            <td width="25%">'.$guestinfo.$attachments.'</td>
            <td width="20%">'.$authorinfo.'</td>
			<td width="15%" class="text-right noprint"><div class="listactions">'.$btnedit.$btninfo.$btddelete.'</div>
		</td>
          </tr>';				  
			  }//foreach
			  unset($brow);
	$rend .= '</tbody></table></div>
  </div>
</div>'; 
		  }	

		}
		
if($islocked){$iconadd='<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>';}else{$iconadd='<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>';}
if($this->isCanCreateBlock()){$addbtn='<button class="btn btn-default float-right bkad" data-cont="bookingadd" href="javascript:void(0);" data-ppttype="' . $this->ppttype . '" data-y="'. $this->prevYear['year'] . '"  data-vmode="yearlist">'.$iconadd.' '.Lang::$say->_BKG_CREATE.'</button>';}else{$addbtn='';}
	$calnav = '
		  <div class="rowspanx calnav">
		  <div class="calnav-controlwrap col-sm-6 padlno">
		  <select class="form-control changetype custom-select" name="changetype" data-auth="'.genRequestKey('calNavigateYear'.$cdate['year']).'" data-year="' . $cdate['year'] . '" data-vmode="yearlist">
		  '.Vault::get("Vhrental")->propertyTypeSelectBox($ppttype).'
		  </select>
		  </div><div class="calnav-controlwrap col-sm-3">
		  <a href="javascript:void(0);" data-year="'. $prevYear['year'] . '" class="changeyear prev" data-auth="'.genRequestKey('calNavigateYear'.$prevYear['year']).'" data-vmode="yearlist">
		  <i class="glyphicon glyphicon-chevron-left"></i></a><span class="year">' . $cdate['year'] . '</span><a href="javascript:void(0);" data-year="' . $nextYear['year'] . '" class="changeyear next" data-auth="'.genRequestKey('calNavigateYear'.$nextYear['year']).'" data-vmode="yearlist">
		  <i class="glyphicon glyphicon-chevron-right"></i></a>';
if($counter>0){$calnav .= '<a target="_blank" class="float-right exportmodebutton noprint" href="printmode.php?do=blocks2csv&p=' . $eppid . '&y=' . $cdate['year'] . '"><span class="glyphicon glyphicon-save"></span></a>';}
$calnav .= '</div>
		  <div class="col-sm-3 padrno">'.$addbtn.'</div>
		  </div>
		  ';
if($counter===0){$rend = '<div class="alert alert-warning margin-top-15" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . $emptylist . '</p></div></div>';}
$disp = Vault::get("Vhrental")->propertyTypeStylesheet().'<div class="yearcalendar">'. $calnav.'<div class="rowspan">'.$rend.'</div>
<div class="clearfix"></div><div class="calnav-bottom">'.$calnav.'</div></div>
<div style="display:none;" id="popbkiavanae"></div>	
';

if(!$this->ppttype){$disp = '<div class="alert alert-warning margin-top-15" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div>';}

	return($disp);

	  }
	  
	  
/**
* Calendar::renderYearCalendar()
* 
* @param mixed $year
* @param mixed $ppttype
* @return
*/
private function renderYearCalendar($year=false,$ppttype=false)
	  {
		$rend=false;$disp=false;$calnav=false;
		if(!$year){
        $year = (isset($_POST['year']) && $this->checkYear($_POST['year'])) ? intval($_POST['year']) : date("Y");
		}
		if(!$ppttype){
		$this->ppttype = (isset($_POST['ppttype'])) ? intval($_POST['ppttype']) : Vault::get("Vhrental")->ppttype;
		$ppttype = (isset($_POST['ppttype'])) ? intval($_POST['ppttype']) : Vault::get("Vhrental")->ppttype;
		}else{$this->ppttype = $ppttype;}
		
		  		
		if((Vault::get("Vhrental")->isPptTypeLocked($ppttype)||Vault::get("Gist")->pptlock) && (Vault::get("Users")->userlevel<8)){$islocked=true;}else{$islocked=false;}
		
		for ($mn = 1; $mn < 13; $mn++) {
			
          $day = date("d");
		  $ldim = $this->calcDays($mn, $day);
		  if($day > $ldim) {
		  	$day = $ldim;
		  }		  
		  $cdate = getdate(mktime(0, 0, 0, $mn, $day, $year));
          $prevYear = getdate(mktime(0, 0, 0, $mn, $day, $cdate['year'] - 1));
          $nextYear = getdate(mktime(0, 0, 0, $mn, $day, $cdate['year'] + 1));
		  $is_day = 0;
		  $is_week = 0;
		  $first_day = getdate(mktime(0, 0, 0, $mn, 1, $cdate['year']));
		  $last_day = getdate(mktime(0, 0, 0, $mn + 1, 0, $cdate['year']));
	
		  $rend .= '<div class="month-container" id="yearcal-'.$mn.'-'.$cdate['year'].'-sm">
		  <div class="calendar-wrap-sm">
		  <div class="wtb-sm">';
		  $rend .= '<div class="wtbcaption"><span class="moncalnum float-right"> '. str_pad(intval($mn) , 2 , "0" , STR_PAD_LEFT) . '</span><div class="wtbrow">';
		  $rend .= '<span class="month">' . $this->arrMonths[$mn][$this->monthNameLength] .'</span>  <span class="d-inline-block d-sm-none">&nbsp; '. $cdate['year'] . '</span>';
		  $rend .= '</div></div><div class="wtbheading"><div class="wtbrow">';
		  
		  for ($i = $this->weekStartedDay - 1; $i < $this->weekStartedDay + 6; $i++) {
			  $rend .= '<div class="wtbhead">' . $this->arrWeekDays[($i % 7)][$this->weekDayNameLength] . '</div>';
		  }
		  $rend .= '</div></div><div class="wtbbody">';
	
		  if ($first_day['wday'] == 0) {
			  $first_day['wday'] = 7;
		  }
		  $max_days = $first_day['wday'] - ($this->weekStartedDay - 1);
		  if ($max_days < 7) {
			  $rend .= '<div class="wtbrow">';$is_week++;
			  for ($i = 1; $i <= $max_days; $i++) {
				  $rend .= '<div class="wtbcell"><div class="calrel"><div class="cout"></div><div class="chin"></div></div></div>';
			  }
			  $is_day = 0;
			  for ($i = $max_days + 1; $i <= 7; $i++) {
				  $is_day++;
				  $rend .=$this->calCell($is_day,$mn,$cdate['year']);
			  }
			  $rend .= '</div>';
		  }
	
		  $fullWeeks = floor(($last_day['mday'] - $is_day) / 7);
	
		  for ($i = 0; $i < $fullWeeks; $i++) {$is_week++;
			  $rend .= '<div class="wtbrow">';
			  for ($j = 0; $j < 7; $j++) {
				  $is_day++;
				  $rend .=$this->calCell($is_day,$mn,$cdate['year']);
			  }
			  $rend .= '</div>';
		  }
	
		  if ($is_day < $last_day['mday']) {
			  $rend .= '<div class="wtbrow">';$is_week++;
			  for ($i = 0; $i < 7; $i++) {
				  $is_day++;
				  $rend .=$this->calCell($is_day,$mn,$cdate['year'],$last_day['mday']);	
			  }
			  $rend .= '</div>';
		  }
		  
if($is_week==4){
	$rend .= '<div class="wtbrow">';
			  for ($i = 0; $i < 7; $i++) {
				$rend .='<div class="wtbcell"><div class="calrel"><div class="cout"></div><div class="chin"></div></div></div>';	
			  }	
	$rend .= '</div>';
	$rend .= '<div class="wtbrow">';
			  for ($i = 0; $i < 7; $i++) {
				$rend .='<div class="wtbcell"><div class="calrel"><div class="cout"></div><div class="chin"></div></div></div>';	
			  }	
	$rend .= '</div>';	
}
if($is_week==5){
	$rend .= '<div class="wtbrow">';
			  for ($i = 0; $i < 7; $i++) {
				$rend .='<div class="wtbcell"><div class="calrel"><div class="cout"></div><div class="chin"></div></div></div>';	
			  }	
	$rend .= '</div>';
	
}
		  $rend .= "</div>";
		  $rend .= "</div></div></div>";
}
if($islocked){$iconadd='<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>';}else{$iconadd='<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>';}
if($this->isCanCreateBlock()){$addbtn='<button class="btn btn-default float-right bkad" data-cont="bookingadd" href="javascript:void(0);" data-ppttype="' . $ppttype . '" data-y="'. $cdate['year'] . '">'.$iconadd.' '.Lang::$say->_BKG_CREATE.'</button>';}else{$addbtn='';}

	$calnav = '
		  <div class="rowspanx calnav">
		  <div class="calnav-controlwrap col-sm-6 padlno">
		  <select class="form-control changetype custom-select" name="changetype" data-auth="'.genRequestKey('calNavigateYear'.$cdate['year']).'" data-year="' . $cdate['year'] . '">
		  '.Vault::get("Vhrental")->propertyTypeSelectBox($ppttype).'
		  </select>
		  </div><div class="calnav-controlwrap col-sm-3">
		  <a href="javascript:void(0);" data-year="'. $prevYear['year'] . '" class="changeyear prev" data-auth="'.genRequestKey('calNavigateYear'.$prevYear['year']).'">
		  <i class="glyphicon glyphicon-chevron-left"></i></a><span class="year">' . $cdate['year'] . '</span><a href="javascript:void(0);" data-year="' . $nextYear['year'] . '" class="changeyear next" data-auth="'.genRequestKey('calNavigateYear'.$nextYear['year']).'">
		  <i class="glyphicon glyphicon-chevron-right"></i></a>
		  </div>
		  <div class="col-sm-3 padrno">'.$addbtn.'<a class="float-right printbutton" href="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></div>
		  </div>	  
		  ';

$disp = Vault::get("Vhrental")->propertyTypeStylesheet().'<div class="yearcalendar">'. $calnav.'<div class="rowspan cals-center"><div class="cals-container">'.$rend.'</div></div>
<div class="clearfix"></div><div class="calnav-bottom">'.$calnav.'</div></div>
<div style="display:none;" id="popbkiavanae"></div>	
';
if(!$this->ppttype){$disp = '<div class="alert alert-warning margin-top-15" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div>';}
	return($disp);

	  }



/**
* Calendar::renderMonthCalendar()
* 
* @param mixed $year
* @param mixed $ppttype
* @param mixed $months
* @return
*/
private function renderMonthCalendar($month=false,$year=false,$ppttype=false,$psview=false,$months=false)
	  {
		$rend=false;$disp=false;$calnav=false;
		if(!$months||$months=='null'){$months = Vault::get("Gist")->publiccalview;}
		if(!$year){
        $year = (isset($_POST['year']) && $this->checkYear($_POST['year'])) ? intval($_POST['year']) : date("Y");
		}
		if(!$month){
        $month = (isset($_POST['month']) && $this->checkMonth($_POST['month'])) ? intval($_POST['month']) : date("m");
		}		
		if(!$ppttype){
		$this->ppttype = (isset($_POST['ppttype'])) ? intval($_POST['ppttype']) : Vault::get("Vhrental")->ppttype;
		$ppttype = (isset($_POST['ppttype'])) ? intval($_POST['ppttype']) : Vault::get("Vhrental")->ppttype;
		}else{$this->ppttype = $ppttype;}
		$ppttypename = Vault::get("Vhrental")->propertyTypeName($ppttype);
		
		  		
		if((Vault::get("Vhrental")->isPptTypeLocked($ppttype)||Vault::get("Gist")->pptlock) && (Vault::get("Users")->userlevel<8)){$islocked=true;}else{$islocked=false;}

if($months==1 || $months==2 || $months==3 || $months==4 || $months==12){
		  $mn=$month;			
          $day = 1;//$day = date("d");
		  $ldim = $this->calcDays($mn, $day);
		  $cdate = getdate(mktime(0, 0, 0, $mn, $day, $year));
          $prevYear = getdate(mktime(0, 0, 0, $mn, $day, $cdate['year'] - 1));
          $nextYear = getdate(mktime(0, 0, 0, $mn, $day, $cdate['year'] + 1));
		  
		  $prevMonth = getdate(mktime(0, 0, 0, $mn - 1, $day, $cdate['year']));
          $nextMonth = getdate(mktime(0, 0, 0, $mn + 1, $day, $cdate['year']));
		  
		$rend .= $this->monthCal($mn,$cdate['year']);
		if($months==2){
			if($mn==12){$rend .= $this->monthCal(1,$nextYear['year']);}
		else {$rend .= $this->monthCal($mn+1,$cdate['year']);}
		}
		if($months==3){
		if($mn==11){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);}
		elseif($mn==12){
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);}
		else{$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);}
		}
		if($months==4){
		if($mn==10){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);}
		elseif($mn==11){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);}
		elseif($mn==12){
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);
			$rend .= $this->monthCal(3,$nextYear['year']);
			}
		else{$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal($mn+3,$cdate['year']);}
		}
		
		if($months==12){
		if($mn==2){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal($mn+3,$cdate['year']);
			$rend .= $this->monthCal($mn+4,$cdate['year']);
			$rend .= $this->monthCal($mn+5,$cdate['year']);
			$rend .= $this->monthCal($mn+6,$cdate['year']);
			$rend .= $this->monthCal($mn+7,$cdate['year']);
			$rend .= $this->monthCal($mn+8,$cdate['year']);
			$rend .= $this->monthCal($mn+9,$cdate['year']);
			$rend .= $this->monthCal($mn+10,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);			
			}		
		elseif($mn==3){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal($mn+3,$cdate['year']);
			$rend .= $this->monthCal($mn+4,$cdate['year']);
			$rend .= $this->monthCal($mn+5,$cdate['year']);
			$rend .= $this->monthCal($mn+6,$cdate['year']);
			$rend .= $this->monthCal($mn+7,$cdate['year']);
			$rend .= $this->monthCal($mn+8,$cdate['year']);
			$rend .= $this->monthCal($mn+9,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);			
			}		
		elseif($mn==4){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal($mn+3,$cdate['year']);
			$rend .= $this->monthCal($mn+4,$cdate['year']);
			$rend .= $this->monthCal($mn+5,$cdate['year']);
			$rend .= $this->monthCal($mn+6,$cdate['year']);
			$rend .= $this->monthCal($mn+7,$cdate['year']);
			$rend .= $this->monthCal($mn+8,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);
			$rend .= $this->monthCal(3,$nextYear['year']);			
			}		
		elseif($mn==5){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal($mn+3,$cdate['year']);
			$rend .= $this->monthCal($mn+4,$cdate['year']);
			$rend .= $this->monthCal($mn+5,$cdate['year']);
			$rend .= $this->monthCal($mn+6,$cdate['year']);
			$rend .= $this->monthCal($mn+7,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);
			$rend .= $this->monthCal(3,$nextYear['year']);
			$rend .= $this->monthCal(4,$nextYear['year']);			
			}		
		elseif($mn==6){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal($mn+3,$cdate['year']);
			$rend .= $this->monthCal($mn+4,$cdate['year']);
			$rend .= $this->monthCal($mn+5,$cdate['year']);
			$rend .= $this->monthCal($mn+6,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);
			$rend .= $this->monthCal(3,$nextYear['year']);
			$rend .= $this->monthCal(4,$nextYear['year']);
			$rend .= $this->monthCal(5,$nextYear['year']);			
			}		
		elseif($mn==7){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal($mn+3,$cdate['year']);
			$rend .= $this->monthCal($mn+4,$cdate['year']);
			$rend .= $this->monthCal($mn+5,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);
			$rend .= $this->monthCal(3,$nextYear['year']);
			$rend .= $this->monthCal(4,$nextYear['year']);
			$rend .= $this->monthCal(5,$nextYear['year']);
			$rend .= $this->monthCal(6,$nextYear['year']);			
			}		
		elseif($mn==8){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal($mn+3,$cdate['year']);
			$rend .= $this->monthCal($mn+4,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);
			$rend .= $this->monthCal(3,$nextYear['year']);
			$rend .= $this->monthCal(4,$nextYear['year']);
			$rend .= $this->monthCal(5,$nextYear['year']);
			$rend .= $this->monthCal(6,$nextYear['year']);
			$rend .= $this->monthCal(7,$nextYear['year']);			
			}		
		elseif($mn==9){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal($mn+3,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);
			$rend .= $this->monthCal(3,$nextYear['year']);
			$rend .= $this->monthCal(4,$nextYear['year']);
			$rend .= $this->monthCal(5,$nextYear['year']);
			$rend .= $this->monthCal(6,$nextYear['year']);
			$rend .= $this->monthCal(7,$nextYear['year']);
			$rend .= $this->monthCal(8,$nextYear['year']);			
			}		
		elseif($mn==10){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);
			$rend .= $this->monthCal(3,$nextYear['year']);
			$rend .= $this->monthCal(4,$nextYear['year']);
			$rend .= $this->monthCal(5,$nextYear['year']);
			$rend .= $this->monthCal(6,$nextYear['year']);
			$rend .= $this->monthCal(7,$nextYear['year']);
			$rend .= $this->monthCal(8,$nextYear['year']);
			$rend .= $this->monthCal(9,$nextYear['year']);			
			}
		elseif($mn==11){
			$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);
			$rend .= $this->monthCal(3,$nextYear['year']);
			$rend .= $this->monthCal(4,$nextYear['year']);
			$rend .= $this->monthCal(5,$nextYear['year']);
			$rend .= $this->monthCal(6,$nextYear['year']);
			$rend .= $this->monthCal(7,$nextYear['year']);
			$rend .= $this->monthCal(8,$nextYear['year']);
			$rend .= $this->monthCal(9,$nextYear['year']);
			$rend .= $this->monthCal(10,$nextYear['year']);
			}
		elseif($mn==12){
			$rend .= $this->monthCal(1,$nextYear['year']);
			$rend .= $this->monthCal(2,$nextYear['year']);
			$rend .= $this->monthCal(3,$nextYear['year']);
			$rend .= $this->monthCal(4,$nextYear['year']);
			$rend .= $this->monthCal(5,$nextYear['year']);
			$rend .= $this->monthCal(6,$nextYear['year']);
			$rend .= $this->monthCal(7,$nextYear['year']);
			$rend .= $this->monthCal(8,$nextYear['year']);
			$rend .= $this->monthCal(9,$nextYear['year']);
			$rend .= $this->monthCal(10,$nextYear['year']);
			$rend .= $this->monthCal(11,$nextYear['year']);
			}
		else{$rend .= $this->monthCal($mn+1,$cdate['year']);
			$rend .= $this->monthCal($mn+2,$cdate['year']);
			$rend .= $this->monthCal($mn+3,$cdate['year']);
			$rend .= $this->monthCal($mn+4,$cdate['year']);
			$rend .= $this->monthCal($mn+5,$cdate['year']);
			$rend .= $this->monthCal($mn+6,$cdate['year']);
			$rend .= $this->monthCal($mn+7,$cdate['year']);
			$rend .= $this->monthCal($mn+8,$cdate['year']);
			$rend .= $this->monthCal($mn+9,$cdate['year']);
			$rend .= $this->monthCal($mn+10,$cdate['year']);
			$rend .= $this->monthCal($mn+11,$cdate['year']);}
		}
				
	$calnav = '
		  <div class="rowspanx calnav">
		  <div class="calnav-controlwrap col-sm-12 padlno">';//$months
	if(!$psview||$psview=='null'){$calnav .= '
		  <select class="form-control changetypemonth custom-select" name="changetype" data-auth="'.genRequestKey('calNavigateMonth'.$cdate['mon'].$cdate['year']).'" data-year="' . $cdate['year'] . '" data-month="' . $cdate['mon'] . '" data-months="' . $months . '">
		  '.Vault::get("Vhrental")->propertyTypeSelectBox($ppttype).'
		  </select>
		  ';}else{$calnav .= '<h4>'.$ppttypename.'</h4>';}
		  $calnav .= '</div><div class="calnav-controlwrap col-sm-12  padlno">
		  <a href="javascript:void(0);" data-ppttype="' . $ppttype . '" data-year="'. $prevMonth['year'] . '" data-month="'. $prevMonth['mon'] . '" data-months="' . $months . '" class="changemonthyear prev" data-auth="'.genRequestKey('calNavigateMonth'.$prevMonth['mon'].$prevMonth['year']).'">
		  <i class="glyphicon glyphicon-chevron-left"></i></a><span class="year"></span><a href="javascript:void(0);" data-ppttype="' . $ppttype . '" data-year="' . $nextMonth['year'] . '" data-month="'. $nextMonth['mon'] . '" data-months="' . $months . '" class="changemonthyear next" data-auth="'.genRequestKey('calNavigateMonth'.$nextMonth['mon'].$nextMonth['year']).'">
		  <i class="glyphicon glyphicon-chevron-right"></i></a>
		  </div>
		  </div>	  
		  ';		
}



if(!$months){
	//if(!$months || $months==12){
	for ($mn = 1; $mn < 13; $mn++){
          $day = date("d");
		  $ldim = $this->calcDays($mn, $day);
		  $cdate = getdate(mktime(0, 0, 0, $mn, $day, $year));
          $prevYear = getdate(mktime(0, 0, 0, $mn, $day, $cdate['year'] - 1));
          $nextYear = getdate(mktime(0, 0, 0, $mn, $day, $cdate['year'] + 1));
		  $prevMonth = getdate(mktime(0, 0, 0, $mn - 1, $day, $cdate['year']));
          $nextMonth = getdate(mktime(0, 0, 0, $mn + 1, $day, $cdate['year']));
	$rend .= $this->monthCal($mn,$cdate['year']);		
		
	}//for
	$calnav = '
		  <div class="rowspanx calnav">
		  <div class="calnav-controlwrap col-md-4 padlno">';
	if(!$psview||$psview=='null'){$calnav .= '
		  <select class="form-control changetypeyear custom-select" name="changetype" data-auth="'.genRequestKey('calNavigateYearView'.$cdate['year']).'" data-year="' . $cdate['year'] . '" data-view="12">
		  '.Vault::get("Vhrental")->propertyTypeSelectBox($ppttype).'
		  </select>
		  ';}else{$calnav .= '<h4>'.$ppttypename.'</h4>';}
		  $calnav .='</div><div class="calnav-controlwrap col-md-8">
		  <a href="javascript:void(0);" data-ppttype="' . $ppttype . '" data-year="'. $prevYear['year'] . '" class="changeyearview prev" data-auth="'.genRequestKey('calNavigateYearView'.$prevYear['year']).'" data-view="12">
		  <i class="glyphicon glyphicon-chevron-left"></i></a><span class="year">' . $cdate['year'] . '</span><a href="javascript:void(0);" data-ppttype="' . $ppttype . '" data-year="' . $nextYear['year'] . '" class="changeyearview next" data-auth="'.genRequestKey('calNavigateYearView'.$nextYear['year']).'" data-view="12">
		  <i class="glyphicon glyphicon-chevron-right"></i></a>
		  </div>
		  </div>	  
		  ';	
}


$disp = Vault::get("Vhrental")->propertyTypeStylesheet().'<div class="yearcalendar">'. $calnav.'<div class="rowspan cals-center"><div class="cals-container">'.$rend.'</div></div>';
if(!$months || $months==12){
$disp .= '<div class="clearfix"></div>'.$calnav.'</div>';}
$disp .= '<div style="display:none;" id="popbkiavanae"></div>';

if(!$this->ppttype){$disp = '<div class="alert alert-warning margin-top-15" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div>';}
	return($disp);

	  }
	  
private function monthCal($mn=false,$yr=false)
{
          $rend = false;
		  $is_day = 0;
		  $is_week = 0;
		  $first_day = getdate(mktime(0, 0, 0, $mn, 1, $yr));
		  $last_day = getdate(mktime(0, 0, 0, $mn + 1, 0, $yr));
	
		  $rend .= '<div class="month-container lightbg" id="yearcal-'.$mn.'-'.$yr.'-sm">
		  <div class="calendar-wrap-sm">
		  <div class="wtb-sm">';
		  $rend .= '<div class="wtbcaption"><span class="moncalnum float-right"> '. str_pad(intval($mn) , 2 , "0" , STR_PAD_LEFT) . '</span><div class="wtbrow">';
		  $rend .= '<span class="month">' . $this->arrMonths[intval($mn)][$this->monthNameLength] .'</span>  <span class="xd-inline-block xd-sm-none"> '. $yr . '</span>';
		  $rend .= '</div></div><div class="wtbheading"><div class="wtbrow">';
		  
		  for ($i = $this->weekStartedDay - 1; $i < $this->weekStartedDay + 6; $i++) {
			  $rend .= '<div class="wtbhead">' . $this->arrWeekDays[($i % 7)][$this->weekDayNameLength] . '</div>';
		  }
		  $rend .= '</div></div><div class="wtbbody">';
	
		  if ($first_day['wday'] == 0) {
			  $first_day['wday'] = 7;
		  }
		  $max_days = $first_day['wday'] - ($this->weekStartedDay - 1);
		  if ($max_days < 7) {
			  $rend .= '<div class="wtbrow">';$is_week++;
			  for ($i = 1; $i <= $max_days; $i++) {
				  $rend .= '<div class="wtbcell"><div class="calrel"><div class="cout"></div><div class="chin"></div></div></div>';
			  }
			  $is_day = 0;
			  for ($i = $max_days + 1; $i <= 7; $i++) {
				  $is_day++;
				  $rend .=$this->calCellRO($is_day,$mn,$yr);
			  }
			  $rend .= '</div>';
		  }
	
		  $fullWeeks = floor(($last_day['mday'] - $is_day) / 7);
	
		  for ($i = 0; $i < $fullWeeks; $i++) {
			  $rend .= '<div class="wtbrow">';$is_week++;
			  for ($j = 0; $j < 7; $j++) {
				  $is_day++;
				  $rend .=$this->calCellRO($is_day,$mn,$yr);
			  }
			  $rend .= '</div>';
		  }
	
		  if ($is_day < $last_day['mday']) {
			  $rend .= '<div class="wtbrow">';$is_week++;
			  for ($i = 0; $i < 7; $i++) {
				  $is_day++;
				  $rend .=$this->calCellRO($is_day,$mn,$yr,$last_day['mday']);	
			  }
			  $rend .= '</div>';
		  }

if($is_week==5){
	$rend .= '<div class="wtbrow">';
			  for ($i = 0; $i < 7; $i++) {
				$rend .='<div class="wtbcell"><div class="calrel"><div class="cout"></div><div class="chin"></div></div></div>';	
			  }	
	$rend .= '</div>';
	
}
		  
		  $rend .= "</div>";
		  $rend .= "</div></div></div>";
		  return($rend);
		  	  
	
}
	  

private function calCell($is_day=false,$mn=false,$year=false,$lastdaymd=false)
{
$data1=false;$data2=false;
$class = '';
$tclass = '';
$data = '';
				  
if (($is_day == $this->today['mday']) && ($this->today['mon'] == $mn) && ($this->today['year'] == $year))
{$tclass = " today";}

$islocked = Vault::get("Vhrental")->isPptTypeLocked($this->ppttype);
$daynum = $is_day;
$datayear = $year;				  
$fdate = $datayear . '-' .$mn . '-' . $is_day;
$fdate1 = $fdate;
$fdate2 = $fdate;
$outap='<a class="outap"></a>';
$intap='<a class="intap"></a>';
$adtap='';
$data1 = $this->checkCalData($fdate,1,$this->ppttype);
$data2 = $this->checkCalData($fdate,2,$this->ppttype);
if($data1){$fdate1=displayDate($data1->detcheckin).' - '.displayDate($data1->detcheckout);
	if($this->isCanViewFullColor()){$bcolor1=$data1->datstatus;}else{$bcolor1=$this->navailstatus;}
			}else{$bcolor1=$this->availstatus;}
if($data2){$fdate2=displayDate($data2->detcheckin).' - '.displayDate($data2->detcheckout);
	if($this->isCanViewFullColor()){$bcolor2=$data2->datstatus;}else{$bcolor2=$this->navailstatus;}
			}else{$bcolor2=$this->availstatus;}

if(!Vault::get("Users")->logged_in){$cmark=' p';}else{$cmark='';}
$outap_view = '<a class="retap'.$cmark.' bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$bcolor1.'-o"></a>';
$intap_view = '<a class="adtap'.$cmark.' bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$bcolor2.'-i"></a>';
$intap_add = '<a class="adtap bkad" href="#" data-cont="bookingadd" data-ppttype="' . $this->ppttype . '" data-date="'. $fdate . '"></a>';

if($data1 && !$data2){
	$intap='';
	$outap = $outap_view;
	
		if($this->isCanViewFullColor()){
		if($this->isCanEditBlock($data1->detbookingid)){
			$outap = '<a class="retap bkiavae" href="#" data-cont="bookingedit" data-id="'.$data1->detbookingid.'"  data-dn="'.$fdate1.'" data-ct="'.$bcolor1.'-o"></a>';
			$intap = $intap_view;
			}
			else{
				if($this->isCanViewDetails($data1->detbookingid)){
				$outap = '<a class="retap bkiavai" href="#" data-cont="bookingedit" data-id="'.$data1->detbookingid.'"  data-dn="'.$fdate1.'" data-ct="'.$bcolor1.'-o"></a>';
				}
				else{
					$outap = $outap_view;
				}
			$intap = $intap_view;
			}
			if($this->isCanCreateBlock()){
			$intap = $intap_add;}
			else{
			$intap = $intap_view;
			}
			}else{
			$intap = $intap_view;
			}	

	}
	
if($data2 && !$data1){
	$outap='';
	$intap = $intap_view;

		if($this->isCanViewFullColor()){
		if($this->isCanEditBlock($data2->detbookingid)){
			$intap = '<a class="adtap bkiavae" href="#" data-cont="bookingedit" data-id="'.$data2->detbookingid.'"  data-dn="'.$fdate2.'" data-ct="'.$bcolor2.'-i"></a>';
			$outap = $outap_view;
			}
			else{
			if($this->isCanViewDetails($data2->detbookingid)){
				$intap = '<a class="adtap bkiavai" href="#" data-cont="bookingedit" data-id="'.$data2->detbookingid.'"  data-dn="'.$fdate2.'" data-ct="'.$bcolor2.'-i"></a>';
			}else{
				$intap = $intap_view;
				}
			$outap = $outap_view;
			}

			}else{
			$outap = $outap_view;
			}
			
	}

if($data1 && $data2){
	if($data1->detbookingid == $data2->detbookingid){
		$outap='';$intap='';		
		if($this->isCanViewFullColor()){
		if($this->isCanEditBlock($data1->detbookingid)){
			$daynum = '<a class="bkiavae" href="#" data-cont="bookingedit" data-id="'.$data1->detbookingid.'"  data-dn="'.$fdate1.'" data-ct="'.$bcolor1.'-a">'.$is_day.'</a>';
			}
			else{
				if($this->isCanViewDetails($data1->detbookingid)){
					$daynum = '<a class="bkiavai" href="#" data-cont="bookingedit" data-id="'.$data1->detbookingid.'" data-dn="'.$fdate1.'" data-ct="'.$bcolor1.'-a">'.$is_day.'</a>';
				}else{
			$daynum = '<a class="bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$bcolor1.'-a">'.$is_day.'</a>';}
			}
			}else{
				$daynum = '<a class="bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$this->navailstatus.'-a">'.$is_day.'</a>';
			}
				
		}else{

		if($this->isCanViewFullColor()){
		if($this->isCanEditBlock($data1->detbookingid)){
			$outap = '<a class="retap bkiavae" href="#"  data-cont="bookingedit" data-id="'.$data1->detbookingid.'" data-dn="'.$fdate1.'" data-ct="'.$bcolor1.'-o"></a>';
			}
			else{
				if($this->isCanViewDetails($data1->detbookingid)){
					$outap = '<a class="retap bkiavai" href="#" data-cont="bookingedit" data-id="'.$data1->detbookingid.'" data-dn="'.$fdate1.'" data-ct="'.$bcolor1.'-a"></a>';
				}else{		
			$intap = $intap_view;
			$outap = $outap_view;
			if(!Vault::get("Users")->logged_in){$intap='';$outap='';}
			}
			}
			
			

		if($this->isCanEditBlock($data2->detbookingid)){
			$intap = '<a class="adtap bkiavae" href="#" data-cont="bookingedit" data-id="'.$data2->detbookingid.'"  data-dn="'.$fdate2.'" data-ct="'.$bcolor2.'-i"></a>';
			}
			else{
				if($this->isCanViewDetails($data2->detbookingid)){
					$intap = '<a class="adtap bkiavai" href="#" data-cont="bookingedit" data-id="'.$data2->detbookingid.'" data-dn="'.$fdate2.'" data-ct="'.$bcolor2.'-i"></a>';
				}else{		
			$intap = $intap_view;
			$outap = $outap_view;
			}
			}			
			
			}else{
			$intap = $intap_view;
			$outap = $outap_view;
			if(!Vault::get("Users")->logged_in){$intap='';$outap='';
			$daynum = '<a class="bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$this->navailstatus.'-a">'.$is_day.'</a>';}
			}
						

			}

	
}
if(!$data1 && !$data2){
	$outap='';$intap='';
	if($this->isCanCreateBlock()){
		$daynum = '<a class="bkad" href="#" data-cont="bookingadd" data-ppttype="' . $this->ppttype . '" data-date="'. $fdate . '">'.$is_day.'</a>';
		}else{$daynum = '<a class="bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$this->availstatus.'-a">'.$is_day.'</a>';}
	}


$cellout = '<div class="wtbcell caldt' . $class . $tclass . '"><div class="calrel">
<div class="cout s'.$bcolor1.'">'.$outap.'</div><span class="dtnum">' . $daynum . '</span>
<div class="chin s'.$bcolor2.'">'.$intap.'</div>
</div></div>';

if($lastdaymd){
	if($is_day <= $lastdaymd){$cellout=$cellout;}else{$cellout='<div class="wtbcell"><div class="calrel"><div class="cout"></div><div class="chin"></div></div></div>';}
}
return ($cellout);
}


private function calCellRO($is_day=false,$mn=false,$year=false,$lastdaymd=false)
{
$data1=false;$data2=false;
$class = '';
$tclass = '';
$data = '';
				  
if (($is_day == $this->today['mday']) && ($this->today['mon'] == $mn) && ($this->today['year'] == $year))
{$tclass = " today";}

$islocked = 1;
$daynum = $is_day;
$datayear = $year;				  
$fdate = $datayear . '-' .$mn . '-' . $is_day;
$fdate1 = $fdate;
$fdate2 = $fdate;
$outap='<a class="outap"></a>';
$intap='<a class="intap"></a>';
$adtap='';
$data1 = $this->checkCalData($fdate,1,$this->ppttype);
$data2 = $this->checkCalData($fdate,2,$this->ppttype);
if($data1){$fdate1=displayDate($data1->detcheckin).' - '.displayDate($data1->detcheckout);
	$bcolor1=$this->navailstatus;
			}else{$bcolor1=$this->availstatus;}
if($data2){$fdate2=displayDate($data2->detcheckin).' - '.displayDate($data2->detcheckout);
	$bcolor2=$this->navailstatus;
			}else{$bcolor2=$this->availstatus;}

$cmark=' p';
$outap_view = '<a class="retap'.$cmark.' bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$bcolor1.'-o"></a>';
$intap_view = '<a class="adtap'.$cmark.' bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$bcolor2.'-i"></a>';
$intap_add = '<a class="adtap bkad" href="#" data-cont="bookingadd" data-ppttype="' . $this->ppttype . '" data-date="'. $fdate . '"></a>';

if($data1 && !$data2){
	$intap='';
	$outap = $outap_view;
	$intap = $intap_view;
	}
	
if($data2 && !$data1){
	$outap='';
	$intap = $intap_view;
	$outap = $outap_view;	
	}

if($data1 && $data2){
	if($data1->detbookingid == $data2->detbookingid){
		$outap='';$intap='';
		$daynum = '<a class="bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$this->navailstatus.'-a">'.$is_day.'</a>';				
		}else{

			$intap = $intap_view;
			$outap = $outap_view;
			if(!Vault::get("Users")->logged_in){$intap='';$outap='';
			$daynum = '<a class="bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$this->navailstatus.'-a">'.$is_day.'</a>';}

						

			}

	
}
if(!$data1 && !$data2){
	$outap='';$intap='';
	$daynum = '<a class="bkiavanae" href="#" data-dn="'.displayDate($fdate).'" data-ct="'.$this->availstatus.'-a">'.$is_day.'</a>';
	}


$cellout = '<div class="wtbcell caldt' . $class . $tclass . '"><div class="calrel">
<div class="cout s'.$bcolor1.'">'.$outap.'</div><span class="dtnum">' . $daynum . '</span>
<div class="chin s'.$bcolor2.'">'.$intap.'</div>
</div></div>';

if($lastdaymd){
	if($is_day <= $lastdaymd){$cellout=$cellout;}else{$cellout='<div class="wtbcell"><div class="calrel"><div class="cout"></div><div class="chin"></div></div></div>';}
}
return ($cellout);
}


/**
* Calendar::checkCalData()
* 
* @return
*/
private function checkCalData($date,$daypart,$ppttype=false,$editid=false)
{
	if($editid){$editq=" AND da.bookingid!='".$editid."' ";}else{$editq="";}

	$query = "SELECT de.*, de.id as detbookingid, de.checkin as detcheckin, de.checkout as detcheckout, da.id as datid, da.bookingdate as datbookingdate, da.daypart as datdaypart, da.status as datstatus"
	. "\n FROM " . self::bdetTable . " as de"
	. "\n LEFT JOIN " . self::bdatTable . " as da ON da.bookingid = de.id"
	. "\n WHERE da.bookingdate = '" . $date."'".$editq." AND da.daypart = '" . $daypart."' AND de.ppttypeid='".$ppttype."'"
	. "\n";
	$row = self::$db->first($query); 		  
	return ($row) ? $row : false;

}



/**
* Calendar::checkDatesAvail()
* 
* @return
*/
private function checkDatesAvail()
	  {
		if(isset($_POST['checkin_submit']) && isset($_POST['checkout_submit']) && isset($_POST['ppttype'])){

			  $checkin = sanitize($_POST['checkin_submit']);
			  $checkout = sanitize($_POST['checkout_submit']);
			  $ppttype = sanitize($_POST['ppttype']);
			  
			if($checkin && $checkout){
				if(strtotime($checkin)>=strtotime($checkout)){Sift::$msgs['navailrange']=Lang::$say->_BKG_RANGEINVLD;}
				else{
  			  
			  $dstart = explode("-",$checkin);
			  $dend = explode("-",$checkout);
			  $idays = self::createDateRangeArray($dstart[0],$dstart[1],$dstart[2],$dend[0],$dend[1],$dend[2]);
			  $inights = count($idays)-1;
			  
			  if(Sift::$id){$editq=Sift::$id;}else{$editq=false;}
			  
			  foreach ($idays as $idate) {
				  
			  $data1 = $this->checkCalData($idate,1,$ppttype,$editq);
              $data2 = $this->checkCalData($idate,2,$ppttype,$editq);
			  
			  if($data1 && !$data2){
				  if($idate!=$checkin){
				  Sift::$msgs['navail'.$idate]=displayDate($idate).' '.Lang::$say->_BKG_CHKIND_O;}
			  }
			  
			  if(!$data1 && $data2){
				  if($idate!=$checkout){
				  Sift::$msgs['navail'.$idate]=displayDate($idate).' '.Lang::$say->_BKG_CCHKOUTD_O;}
			  }
			  
			  if($data1 && $data2){
				  Sift::$msgs['navail'.$idate]=displayDate($idate).' '.Lang::$say->_BKG_NAVAIL;
			  }
				  
			  }//foreach idays
			unset($idate);
				}
			  
			  if (empty(Sift::$msgs)) { 
				  $inights= ($inights>1) ? $inights.' '.Lang::$say->_BKG_NIGHTS : $inights.' '.Lang::$say->_BKG_NIGHT;
			  $json['status'] = 'success';
			  $json['message'] =  Sift::msgSuccess($inights.'. '.Lang::$say->_BKG_AVAILMSG, false,3000,false,true);
			  print json_encode($json);			  
			  }else{
			  $json['message'] =  Sift::msgStatus();
			  print json_encode($json);
			  }
			}// if checkin checkout
		}//issetpost
	  }


/**
* Calendar::checkDatesAvailBool($editid=false)
* 
* @return
*/
private function checkDatesAvailBool($checkin,$checkout,$ppttype,$editid=false)
	  {
		$err=0;
		if($checkin && $checkout && $ppttype){
			  
			if($checkin && $checkout){
				if(strtotime($checkin)>=strtotime($checkout)){$err++;}
				else{  			  
			  $dstart = explode("-",$checkin);
			  $dend = explode("-",$checkout);
			  $idays = self::createDateRangeArray($dstart[0],$dstart[1],$dstart[2],$dend[0],$dend[1],$dend[2]);
			  
			  if(Sift::$id){$editq=Sift::$id;}else{$editq=false;}
			  
			  foreach ($idays as $idate) {
				  
			  $data1 = $this->checkCalData($idate,1,$ppttype,$editq);
              $data2 = $this->checkCalData($idate,2,$ppttype,$editq);
			  
			  if($data1 && !$data2){
				  if($idate!=$checkin){
				  $err++;}
			  }
			  
			  if(!$data1 && $data2){
				  if($idate!=$checkout){
				  $err++;}
			  }
			  
			  if($data1 && $data2){
				  $err++;
			  }
				  
			  }//foreach idays
			unset($idate);
				}
			  
			  if ($err>0) {
			  return true;  
			  }else{
			  return false;
			  }
			}// if checkin checkout
		}//issetpost
	  }


/**
* Calendar::saveBookingBlock()
* 
* @return
*/
public function saveBookingBlock()
{
		  $dateschange = true;
		  $dbaffected = 0;
		  $successupload=0;
		  $filesadding = false;
		  
		  Sift::checkPost('checkin', Lang::$say->_BKG_CHKIND_R);
		  if(!isset($_POST['checkin_submit']) || !$_POST['checkin_submit'] ){Sift::$msgs['checkin']=Lang::$say->_BKG_CHKIND_R;}
		  Sift::checkPost('checkout', Lang::$say->_BKG_CCHKOUTD_R);
		  if(!isset($_POST['checkout_submit']) || !$_POST['checkout_submit'] ){Sift::$msgs['checkout']=Lang::$say->_BKG_CCHKOUTD_R;}	
		  Sift::checkPost('bookingstatus', Lang::$say->_BKG_STATUS_R);  
		  Sift::checkPost('guestname', Lang::$say->_BKG_GUESTNAME_R);
		  
		  $checkin = sanitize($_POST['checkin_submit']);
		  $checkout = sanitize($_POST['checkout_submit']);
		  if(isset($_POST['bookingadd_ppttype'])){$ppttype=sanitize($_POST['bookingadd_ppttype']);}
		  if(isset($_POST['bookingedit_ppttype'])){$ppttype=sanitize($_POST['bookingedit_ppttype']);}
		  if(isset($_POST['bookingadd_vmode'])){$vmode=sanitize($_POST['bookingadd_vmode']);}
		  if(isset($_POST['bookingedit_vmode'])){$vmode=sanitize($_POST['bookingedit_vmode']);}	

		  if(isset($_POST['bookingadd_keyword'])){$keyword=sanitize($_POST['bookingadd_keyword']);}
		  if(isset($_POST['bookingedit_keyword'])){$keyword=sanitize($_POST['bookingedit_keyword']);}		  
 
		  if(!$ppttype){Sift::checkPost('bookingdates', Lang::$say->_BKG_DATES_R);}

if (isset($_FILES['files']) && !empty($_FILES['files'])) {
	$fileuploaderr=false;
	$attached=false;
    $num_files = count($_FILES["files"]['name']);
	if($num_files>0){		
		$filesadding=true;		
		}
}
if ($filesadding) {
	
		if(Sift::$id){
			$attached = $this->countAttached(Sift::$id);
			if($attached>0){$addedMoreWord=Lang::$say->_FILES_ATTACHMAX3;}else{$addedMoreWord=Lang::$say->_FILES_ATTACHMAX2;}
			if(($num_files+$attached)>FILES_MAXATTACHED) {
			Sift::$msgs['errMaxAttached'] = Lang::$say->_FILES_ATTACHMAX1.' '.(FILES_MAXATTACHED-$attached).' '.$addedMoreWord;$fileuploaderr++;}
			}else{
			if(FILES_MAXATTACHED < $num_files) {Sift::$msgs['errMaxAttached'] = Lang::$say->_FILES_ATTACHMAX1.' '.FILES_MAXATTACHED.' '.Lang::$say->_FILES_ATTACHMAX2;$fileuploaderr++;}
			}
	
	$uploadsSize=0;	
    for ($i = 0; $i < $num_files; $i++) {
			  if (FILES_MAXUPLOADSIZE != null && FILES_MAXUPLOADSIZE < $_FILES["files"]["size"][$i]) {
            Sift::$msgs['errFilesEr'.$i] = Lang::$say->_FILES_FILE.' ('.$_FILES["files"]["name"][$i].') '.Lang::$say->_FILES_LARGER.' '.fileEasySize(FILES_MAXUPLOADSIZE);
			$fileuploaderr++;
			  }
			  $uploadsSize = $uploadsSize+$_FILES["files"]["size"][$i];
    }
	if(FILES_MAXUPLOADSSIZE != null && FILES_MAXUPLOADSSIZE < $uploadsSize) {
		Sift::$msgs['errFilesTotalMax'] = Lang::$say->_FILES_ALLFILES.' '.Lang::$say->_FILES_CANTLARGER.' '.fileEasySize(FILES_MAXUPLOADSSIZE);$fileuploaderr++;
	}
} 
   
		  
		  if(Sift::$id){
			  
		  if($this->checkDatesAvailBool($checkin,$checkout,$ppttype,Sift::$id)){
			  Sift::$msgs['navaildates']=Lang::$say->_BKG_NAVAILMSG;}
		  }
		  else{
		  if($this->checkDatesAvailBool($checkin,$checkout,$ppttype)){
			  Sift::$msgs['navaildates']=Lang::$say->_BKG_NAVAILMSG;}
		  }

			  
		  if (empty(Sift::$msgs)) {  

		  if(Sift::$id){
			$rowcheck = getValuesById("checkin,checkout",self::bdetTable, Sift::$id);
			if($checkin==$rowcheck->checkin && $checkout==$rowcheck->checkout){$dateschange=false;}			
		  }
			  $data = array(
			  		'userid' => Vault::get("Users")->uid,
					'ppttypeid' => $ppttype,
					'checkin' => $checkin,
					'checkout' => $checkout,
					'guestname' => sanitize($_POST['guestname']),
					'guestemail' => strtolower(sanitize($_POST['guestemail'])),
					'guestphone' => sanitize($_POST['guestphone']),
					'guestcountry' => sanitize($_POST['guestcountry']),
					'guestadult' => intval($_POST['guestadult']),
					'guestchild' => intval($_POST['guestchild']),
					'status' => intval($_POST['bookingstatus']),
					'amount' => numInputToMyVal($_POST['amount']),
					'deposit' => numInputToMyVal($_POST['deposit']),
					'balancedue' => numInputToMyVal($_POST['balancedue']),
					'note_en' => $_POST['note_en']
			  );
			  
			  $statusname = getValue('title' . Lang::$lang, Vhrental::blksTable, "id=".intval($_POST['bookingstatus']));
			  if(!Sift::$id){$data['created'] = "NOW()";}
			  
			  (Sift::$id) ? self::$db->update(self::bdetTable, $data, "id=" . Sift::$id) : $lastid = self::$db->insert(self::bdetTable, $data);

if ($filesadding && !$fileuploaderr) {	
    for ($i = 0; $i < $num_files; $i++) {
		$filesId = (Sift::$id) ? Sift::$id : $lastid;
		$ppid = makePassId($filesId);
		$newFileName = makeNewFileName($ppid, $_FILES["files"]["name"][$i]);		
        if (!$_FILES["files"]["error"][$i]) {		
		if(move_uploaded_file($_FILES["files"]["tmp_name"][$i], '../'.FILES_DIR.'/' . $newFileName)){
			  $dataf = array(
					'bookingid' => $filesId,
					'filename' => $newFileName,
					'filetitle' => $_FILES["files"]["name"][$i],
					'updated' => "NOW()"
			  );
			self::$db->insert(self::bfilesTable, $dataf);
			$successupload++;
		}
        }
    }
} 			  
			  
			  if (self::$db->affected()) {	  
			  $dbaffected++;
			  $dataupd = array();
			  if(Sift::$id){
				  $dataupd['updated'] = "NOW()";$dataupd['updaterid'] = Vault::get("Users")->uid;
				  self::$db->update(self::bdetTable, $dataupd, "id=" . Sift::$id);
				  }
			  
			  $message = (Sift::$id) ? Lang::$say->_BKG_BLKUPDATED : Lang::$say->_BKG_BLKCREATED;

			  $dstart = explode("-",$checkin);
			  $dend = explode("-",$checkout);	  
			  
			  if($dateschange){
				  
			  $days_data = self::createDateRangeArray($dstart[0],$dstart[1],$dstart[2],$dend[0],$dend[1],$dend[2]);
			  //$fromYear, $fromMonth, $fromDay, $toYear, $toMonth, $toDay
			  
			  $edata['bookingid'] = (Sift::$id) ? Sift::$id : $lastid;			  
			  self::$db->delete(self::bdatTable, "bookingid=" . $edata['bookingid']);
			  
			  $query = "INSERT INTO " .self::bdatTable." (bookingid, daypart, bookingdate, status) VALUES ('";
			  $values = array();
	
			  foreach ($days_data as $block) {
				  if($block==$checkin){
			array_push($values,$edata['bookingid'] . '\', \'2\', \'' . $block . '\', \'' . $data['status']);
					  }elseif($block==$checkout){
			array_push($values,$edata['bookingid'] . '\', \'1\', \'' . $block . '\', \'' . $data['status']);
					  }else{
				  //$values1[] = $edata['bookingid'] . '\', \'1\', \'' . $block . '\', \'' . $data['status'];
			array_push($values,$edata['bookingid'] . '\', \'1\', \'' . $block . '\', \'' . $data['status']);
			array_push($values,$edata['bookingid'] . '\', \'2\', \'' . $block . '\', \'' . $data['status']);
			}
			  }
	
			  $query .=implode('\'), (\'', $values) . '\')';
			  self::$db->query($query);
			  }//if new or if dates changed
			  else {
				   $datadat = array(
					'status' => intval($_POST['bookingstatus'])
			  		);
					self::$db->update(self::bdatTable, $datadat, "bookingid=" . Sift::$id);
				  }
			  }//affected insert or update detailTbl

			  if ($dbaffected>0) {//affected insert or update dataTbl
				  $json['status'] = 'success';
				  if(Sift::$id){					  
					  $actionname = Lang::$say->_GNL_BLOCKUPDATE;
					  $json['message'] = Sift::msgSuccess($message, false,4000,false,false);
					  }else{
					  $actionname = Lang::$say->_GNL_BLOCKCREATE;
				      $json['message'] = Sift::msgSuccess($message, false,false,false,false);
					  }

if((!Sift::$id && Vault::get("Gist")->notifyoncreate) || (Sift::$id && Vault::get("Gist")->notifyonupdate)){
					  require_once (BASEPATH . "classes/class.mailer.php");
					  $rowtpl = Vault::get("Gist")->getRowById(Gist::etplTable, 4);
					  $datadate =date("d M Y, H:i");
					  
					  $blockid = (Sift::$id) ? Sift::$id:$lastid;
					  $blockdetails = $this->blockDetails($blockid);
	
					  $body = str_replace(array(
						  '[USERNAME]',
						  '[NAME]',
						  '[EMAIL]',						  
						  '[ACTION]',
						  '[DATES]',
						  '[SITENAME]',
						  '[URL]',
						  '[SIGNATURE]',
						  '[IP]',
						  '[DATE]',
						  '[DETAILS]'), array(
						  Vault::get("Users")->username,
						  Vault::get("Users")->name,
						  Vault::get("Users")->email,
						  $actionname,
						  displayDate($checkin).' - '.displayDate($checkout).', '.$statusname,		  
						  Vault::get("Gist")->pptname,
						  SITEURL,
				          Vault::get("Gist")->signature,
						  getVisitingIP(),
						  $datadate,
						  $blockdetails), $rowtpl->{'body' . Lang::$lang});

			  $subject = str_replace(array(
				  '[NAME]',
				  '[EMAIL]',			  
				  '[USERNAME]',
				  '[SITENAME]',
				  '[DATE]',
				  '[ACTION]',
				  '[DATES]'), array(
				  Vault::get("Users")->name,
				  Vault::get("Users")->email,				  
				  Vault::get("Users")->username,
				  Vault::get("Gist")->pptname,
				  $datadate,
				  $actionname,
				  displayDate($checkin).' - '.displayDate($checkout).', '.$statusname				  
				  ), $rowtpl->{'subject' . Lang::$lang});						  
	
					 $mailer = Mailer::sendMail();
					 $msg = Swift_Message::newInstance()
							->setSubject($subject)
							->setTo(array(Vault::get("Gist")->pptemail => Vault::get("Gist")->pptname))
							->setFrom(array(Vault::get("Gist")->pptemail => Vault::get("Gist")->pptname))
							->setBody(cleanOut($body), 'text/html');
	
					  $mailer->send($msg);
					  

          $sqlnt = "SELECT u.*, u.fname "
		  . "\n FROM " . Users::usrTable. " as u"
		  . "\n WHERE userlevel=8 "
		  . "\n  AND active='y' ";
          $rownt = self::$db->fetch_all($sqlnt);
		  if($rownt){
			  foreach ($rownt as $usrn) {
				  $assgnarray='';
				  $assgnarray = explode(',',$usrn->pptassignment);
					if (in_array($ppttype,$assgnarray))
  						{
				  			$msg->setTo(array($usrn->email => $usrn->fname));
				  			$mailer->send($msg);
  					}		  

			  }//$usrn
			  unset($usrn);
		  }//rownt
					  
}
					  
					  if($vmode && $vmode=='yearlist'){
					  $json['content'] = $this->renderCalendar('yearlist',$dstart[0],$ppttype);}
					  elseif($vmode && $vmode=='searchlist'){$json['content'] = $this->renderSearchList($keyword);}
					  else{
					  $json['content'] = $this->renderCalendar('yeardata',$dstart[0],$ppttype);}
					  if(Sift::$id){$json['filelist'] = $this->getAttachmentList(Sift::$id);}
			  } else {				  
				  if($successupload>0){
					  if(Sift::$id){
						  $message = Lang::$say->_BKG_BLKUPDATED;
						  $json['status'] = 'success';
						  $actionname = Lang::$say->_GNL_BLOCKUPDATE;
					      $json['message'] = Sift::msgSuccess($message, false,4000,false,false);
						  $json['filelist'] = $this->getAttachmentList(Sift::$id);
					  }
					  }else{				  
				  $json['status'] = 'warning';
				  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
				  }
			  }
			  print json_encode($json);

		  } else {
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  }
	  }



/**
* Calendar::isCanCreateBlock()
* 
* @return
*/
public function isCanCreateBlock()
	{
	if(Vault::get("Users")->userlevel<=9 && Vault::get("Users")->userlevel>5){
		return(true);
		}else{return(false);}
	}	

/**
* Calendar::isCanViewFullColor()
* 
* @return
*/
public function isCanViewFullColor()
	{
	if(Vault::get("Users")->userlevel<=9 && Vault::get("Users")->userlevel>4){
		return(true);
		}else{return(false);}
	}
		  
/**
* Calendar::isCanEditBlock()
* 
* @return
*/
public function isCanEditBlock($bookingid=false)
	{
	switch(Vault::get("Users")->userlevel){
		case 9: return(1);
		break;
		case 8: return(1);
		break;
		case 7: if(getValueById('userid', self::bdetTable, $bookingid)==Vault::get("Users")->uid){
			return(2);}else{return(false);};
		break;
		case 6: if(getValueById('userid', self::bdetTable, $bookingid)==Vault::get("Users")->uid){
			return(2);}else{return(false);};
		break;
		case 5: return(false);
		break;
		case 4: return(false);
		break;
		default: return(false);
		break;
		}
	}		  	  	  


/**
* Calendar::isCanViewDetails()
* 
* @return
*/
public function isCanViewDetails($bookingid=false)
	{
	switch(Vault::get("Users")->userlevel){
		case 9: return(1);
		break;
		case 8: return(1);
		break;
		case 7: return(1);
		break;
		case 6: if(getValueById('userid', self::bdetTable, $bookingid)==Vault::get("Users")->uid){
			return(2);}else{return(false);};
		break;
		case 5: return(false);
		break;
		case 4: return(false);
		break;
		default: return(false);
		break;
		}
	}	


/**
* Calendar::getBlockDetails()
* 
* @param mixed $id
* @return
*/
public function getBlockDetails($id)
	  {
          $id = sanitize($id);
          $id = self::$db->escape($id);  

 $query = "SELECT de.*, de.id as detbookingid, de.status as destatus, de.note_en as denote, st.title" . Lang::$lang . " as statustitle, st.colorhex as blockcolor"
		  . "\n FROM " . self::bdetTable . " as de"
		  . "\n LEFT JOIN " . Vhrental::blksTable . " as st ON st.id = de.status "
		  . "\n WHERE de.id = '" . $id."' "
		  . "\n";
		  $row = self::$db->first($query);
		  
		  return ($row) ? $row : false;		  
	  }
	  
/**
* Calendar::editFormBlock()
* 
* @param mixed $id
* @return
*/
public function editFormBlock($id)
	  {

if(isset($_POST['vmode']) && $_POST['vmode']){$vmode = $_POST['vmode'];}else{$vmode = false;}
if(isset($_POST['keyword']) && $_POST['keyword']){$keyword = $_POST['keyword'];}else{$keyword = false;}		  
$row = $this->getBlockDetails($id);
		   
$ci = explode('-',$row->checkin);
$co = explode('-',$row->checkout);
if(Vault::get("Gist")->site_dsep=='.'){$numinputclass=' ti-ifnumdep';}else{$numinputclass=' ti-ifnumdec';}

$fileSelects = false;
for ($x = 0; $x < FILES_BROWSENUM; $x++) {
if(FILES_BROWSENUM==1){$fcol='12';}else{$fcol='6';}
if(FILES_MULTISELECT){$filesMulti=' multiple="multiple" ';$fsPlaceholder=Lang::$say->_FILES_MULTIPLE;}else{$filesMulti=' ';$fsPlaceholder=Lang::$say->_FILES_SINGLE;}
$fileSelects .='<div class="col-sm-'.$fcol.' col-md-'.$fcol.' col-lg-'.$fcol.'">
<div class="form-group">
<input'.$filesMulti.'class="filestyle" data-badge="true" type="file" id="multiFiles" name="files[]" accept="'.FILES_TYPES_ACCEPTED.'"/>
</div>
</div>';
} 

if($row->guestadult==0){$row->guestadult='';}
if($row->guestchild==0){$row->guestchild='';}

if($fileSelects){$fileSelects='<div class="row"><div class="col-sm-12"><label>'.Lang::$say->_FILES_ATTACHMENT.'</label><div class="righttool"><a href="javascript:void(0)" class="clear-filestyle">'.Lang::$say->_CLEAR.'</a></div></div></div><div class="row" id="files-container">'.$fileSelects.'</div></div></div>';}else{$fileSelects='';}

$disp = '
 <form class="form" id="form_bookingedit">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="checkin">'.Lang::$say->_BKG_CHKIND.'</label>
                <input data-listcont="bookingedit" data-auth="'.genRequestKey(Vault::get("Users")->uid.'checkAvailDate').'" type="text" class="form-control checkined setbookingdate" name="checkin">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="checkout">'.Lang::$say->_BKG_CCHKOUTD.'</label>
                <input data-listcont="bookingedit" data-auth="'.genRequestKey(Vault::get("Users")->uid.'checkAvailDate').'" type="text" class="form-control checkouted setbookingdate" name="checkout">
              </div>
            </div>         
            <div class="col-sm-4">
              <div class="form-group">
			  <label style="width:100%" for="status">'.Lang::$say->_BKG_STATUS.'</label>
				<div class="input-group"><div class="input-group-prepend"><span class="input-group-text wprev"><div class="colorprev"></div></span></div>
                  '.Vault::get("Vhrental")->blockStatSelectBox('bookingstatus',$row->destatus).'
				  </div>
              </div>
            </div>
          </div>
          
<div class="row">
          <div class="col-sm-6">
              <div class="form-group">
                <label for="guestname">'.Lang::$say->_BKG_GUESTNAME.'</label>
                <input type="text" class="form-control" name="guestname" value="'.$row->guestname.'">
              </div>
          </div>
           <div class="col-sm-3">
           <div class="form-group">
                <label for="guestadult">'.Lang::$say->_BKG_GUESTADULT.'</label>
                <input type="text" class="form-control ti-ifnumber" name="guestadult" value="'.$row->guestadult.'" maxlength="3">
              </div>             
            </div>
            <div class="col-sm-3">
           <div class="form-group">
                <label for="guestchild">'.Lang::$say->_BKG_GUESTCHILD.'</label>
                <input type="text" class="form-control ti-ifnumber" name="guestchild" value="'.$row->guestchild.'" maxlength="3">
              </div>
           </div>          
</div>    
<div class="row">
           <div class="col-sm-4">
           <div class="form-group">
                <label for="guestemail">'.Lang::$say->_BKG_GUESTEMAIL.'</label>
                <input type="text" class="form-control" name="guestemail" value="'.$row->guestemail.'">
              </div>             
            </div>
            <div class="col-sm-4">
           <div class="form-group">
                <label for="guestphone">'.Lang::$say->_BKG_GUESTPHONE.'</label>
                <input type="text" class="form-control" name="guestphone" value="'.$row->guestphone.'">
              </div>
           </div>
           <div class="col-sm-4">
               <div class="form-group">
                <label for="guestcountry">'.Lang::$say->_BKG_GUESTCOUNTRY.'</label>
                <input type="text" class="form-control" name="guestcountry" value="'.$row->guestcountry.'">
              </div>             
            </div>
</div>
<div class="row">
          <div class="col-sm-4">
              <div class="form-group">
                <label for="amount">'.Lang::$say->_BKG_AMOUNT.'</label>
				<div class="input-group">
				<div class="input-group-prepend"><span class="input-group-text">'.Vault::get("Gist")->site_currsym.'</span></div>				
                <input type="text" class="form-control'.$numinputclass.'" name="amount" value="'.myValToNumInput($row->amount).'" maxlength="12">
              </div></div>
          </div>
           <div class="col-sm-4">
           <div class="form-group">
                <label for="deposit">'.Lang::$say->_BKG_DEPOSIT.'</label>
				<div class="input-group">
				<div class="input-group-prepend"><span class="input-group-text">'.Vault::get("Gist")->site_currsym.'</span></div>				
                <input type="text" class="form-control'.$numinputclass.'" name="deposit" value="'.myValToNumInput($row->deposit).'" maxlength="12">
              </div></div>            
            </div>
            <div class="col-sm-4">
           <div class="form-group">
                <label for="balancedue">'.Lang::$say->_BKG_BALANCEDUE.'</label>
				<div class="input-group">
				<div class="input-group-prepend"><span class="input-group-text">'.Vault::get("Gist")->site_currsym.'</span></div>
                <input type="text" class="form-control'.$numinputclass.'" name="balancedue" value="'.myValToNumInput($row->balancedue).'" maxlength="12">
              </div></div>
           </div>          
</div>
'.$fileSelects.'<div id="attachment-list" class="listfilepanel_bookingedit listpanel_bookingfileedit">'.$this->getAttachmentList($id).'</div>
    
<div class="row">
            <div class="col-sm-8">           
              <div class="form-group">
                <label for="company">'.Lang::$say->_BKG_NOTES.'</label>
                <textarea name="note_en" rows="4" class="form-control" type="text" style="height:80px;resize:none;">'.$row->denote.'</textarea>
              </div>
           </div>
           <div class="col-sm-4"> 
              <div class="form-group"><label>&nbsp;</label>
			    <input type="hidden" name="id"  value="'.$id.'">
				<input type="hidden" name="bookingedit_vmode" value="'.$vmode.'">
                <input type="hidden" name="bookingedit_ppttype"  value="'.$row->ppttypeid.'">
                <input type="hidden" name="updateBooking" value="'.genRequestKey('updateBooking'.$id).'">
				<input type="hidden" name="bookingedit_keyword" value="'.$keyword.'">				
                <button id="save_bookingedit" data-after="none" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.Lang::$say->_SAVE.'</button>
              </div>
            </div>
          </div>
</form>
        <div id="msg_bookingedit" class="msg_bookingfileedit"></div>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {

$(".checkined").pickadate({
format: "dd mmm yyyy",
formatSubmit: "yyyy-mm-dd",
min:false,
firstDay: '.$this->jsweekStartedDay.',
  onSet: function() {
    $(".checkouted").pickadate("picker").set("min",$(".checkined").pickadate("picker").get());
  }
	});
$(".checkouted").pickadate({
format: "dd mmm yyyy",
formatSubmit: "yyyy-mm-dd",
min:+1,
firstDay: '.$this->jsweekStartedDay.'
	});


$(".checkined").pickadate("picker").set("select", new Date('.$ci[0].', '.$ci[1].'-1, '.$ci[2].'));
$(".checkouted").pickadate("picker").set("view", new Date('.$co[0].', '.$co[1].'-1, '.$co[2].'));
$(".checkouted").pickadate("picker").set("select", new Date('.$co[0].', '.$co[1].'-1, '.$co[2].'));

$(".setcolorprev").trigger("change");

$(":file").filestyle({badge: true,input: true,buttonBefore: true,btnClass: "btn-default",htmlIcon: \'<span class="glyphicon glyphicon-folder-open"></span>\',text: "",badgeName: "badge-danger",placeholder: "'.$fsPlaceholder.'"});

$(document).on("click", ".clear-filestyle", function(event) {
 event.preventDefault();
 event.stopPropagation();
$(":file").filestyle("clear");
  }); 
  
});
// ]]>
</script>
';

          return ($row) ? sanitize_output($disp) : false;
	  }	
	  
	  

/**
* Calendar::infoFormBlock()
* 
* @param mixed $id
* @return
*/
public function infoFormBlock($id,$printview=false)
	  {
          $id = sanitize($id);
          $id = self::$db->escape($id);
		  
if(!$this->isCanViewDetails($id)){exit;}	  

 $query = "SELECT de.*, de.id as detbookingid, de.status as destatus, de.note_en as denote, st.title" . Lang::$lang . " as statustitle, st.colorhex as blockcolor, pt.name as ppttype"
		  . "\n FROM " . self::bdetTable . " as de"
		  . "\n LEFT JOIN " . Vhrental::blksTable . " as st ON st.id = de.status "
		  . "\n LEFT JOIN " . Vhrental::pptyTable . " as pt ON pt.id = de.ppttypeid "
		  . "\n WHERE de.id = '" . $id."' "
		  . "\n";
		  $row = self::$db->first($query);
if($row){		  
$checkin = explode("-",$row->checkin);
$checkout = explode("-",$row->checkout);
$numnights = $this->countDateRange($checkin[0],$checkin[1],$checkin[2],$checkout[0],$checkout[1],$checkout[2]);
$numdays = $numnights+1;
if($numnights>1){$numnights = $numnights.' '.Lang::$say->_BKG_NIGHTS;}else{$numnights = $numnights.' '.Lang::$say->_BKG_NIGHT;}
$numdays = $numdays.' '.Lang::$say->_BKG_DAYS.' '.$numnights;

if($row->guestadult){
if($row->guestadult>1){$guestadult = $row->guestadult.' '.Lang::$say->_BKG_GUESTADULTS;}else{$guestadult = $row->guestadult.' '.strtolower(Lang::$say->_BKG_GUESTADULT);}}else{$guestadult='';}

if($row->guestchild){
if($row->guestchild>1){$guestchild = ' '.$row->guestchild.' '.Lang::$say->_BKG_GUESTCHILDS;}else{$guestchild = ' '.$row->guestchild.' '.strtolower(Lang::$say->_BKG_GUESTCHILD);}}else{$guestchild='';}
if(!$row->guestadult && !$row->guestchild){$guestadult='-';}

$creator = getValue('username', Users::usrTable, "id=".$row->userid);
if($row->userid==Vault::get("Users")->uid){$creator .= ' ('.Lang::$say->_ME.')';}
$updater = getValue('username', Users::usrTable, "id=".$row->updaterid);
if($row->updaterid==Vault::get("Users")->uid){$updater .= ' ('.Lang::$say->_ME.')';}

if(!$printview){$col='col-sm-6';$cols='</div><div class="col-sm-6">';$clas=' grid-divider';
$btn='<a class="float-right printmodebutton" target="_blank" href="printmode.php?do=block&i='.Vault::get("niceIds")->makenice($row->detbookingid).'"><span class="glyphicon glyphicon-print"></span></a>';$btnprint='';
if($row->denote){
$info='<div class="form-group"><label for="note_en">'.Lang::$say->_BKG_NOTES.':</label>
<textarea readonly name="note_en" class="form-control" type="text" style="min-height:132px;resize:none;">'.$row->denote.'</textarea></div>';}else{$info='';}
}
else{$col='col-sm-12';$cols='';$clas='';$btn='';$btnprint='<h5>'.Lang::$say->_BKG_BLKDETAILS.'<a class="float-right printbutton" href="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></h5>';
if($row->denote){$info='<div class="form-group"><label for="note_en">'.Lang::$say->_BKG_NOTES.':</label><p>'.$row->denote.'</p></div>';}else{$info='';}
}

if($row->amount>0){			
$amount = '<div class="form-group">
                <label class="details-head">'.Lang::$say->_BKG_AMOUNT.':</label><label class="text-normal">'.numFormatDisplay($row->amount,true).'</label>
              </div>';
}else{$amount='';}
if($row->deposit>0){			
$deposit = '<div class="form-group">
                <label class="details-head">'.Lang::$say->_BKG_DEPOSIT.':</label><label class="text-normal">'.numFormatDisplay($row->deposit,true).'</label>
              </div>';
}else{$deposit='';}
if($row->balancedue>0){			
$balancedue = '<div class="form-group">
                <label class="details-head">'.Lang::$say->_BKG_BALANCEDUE.':</label><label class="text-normal">'.numFormatDisplay($row->balancedue,true).'</label>
              </div>';
}else{$balancedue='';}

$disp = '
<div class="row details '.$clas.'">
            <div class="'.$col.'"><div class="col-padding">
			'.$btnprint.'
              <div class="form-group">
                <label class="details-head">'.Lang::$say->_PPT_TYPE.':</label><label class="text-normal">'.$row->ppttype.'</label>'.$btn.'
              </div>			
              <div class="form-group">
                <label class="details-head">'.Lang::$say->_BKG_CHKIND.':</label><label class="text-normal">'.displayDate($row->checkin).'</label>
              </div>
              <div class="form-group">
                <label class="details-head">'.Lang::$say->_BKG_CCHKOUTD.':</label><label class="text-normal">'.displayDate($row->checkout).'</label>
              </div>
              <div class="form-group">
                <label class="details-head">'.Lang::$say->_BKG_LOSTAY.':</label><label class="text-normal">'.$numdays.'</label>
              </div>
              <div class="form-group">
			  <label class="details-head colorprevtext">'.Lang::$say->_BKG_STATUS.':</label><label class="text-normal infolist"> <span class="colorinlist"><div class="calrel">
<div class="cout" style=" border-color:'.$row->blockcolor.'"></div>
<div class="chin" style=" border-color:'.$row->blockcolor.'"></div>
</div></span> <span class="colorprevtext">'.$row->statustitle.'</span></label>
              </div>
              <div class="form-group">
              <label class="details-head">'.Lang::$say->_BKG_GUESTNAME.':</label><label class="text-normal">'.$row->guestname.'</label>
              </div>

           <div class="form-group">
              <label class="details-head">'.Lang::$say->_BKG_GUESTNUM.':</label><label class="text-normal">'.$guestadult.$guestchild.'</label>
              </div>
           <div class="form-group">
              <label class="details-head">'.Lang::$say->_BKG_GUESTEMAIL.':</label><label class="text-normal">'.$row->guestemail.'</label>
              </div>             
           <div class="form-group">
              <label class="details-head">'.Lang::$say->_BKG_GUESTPHONE.':</label><label class="text-normal">'.$row->guestphone.'</label>
              </div>
           <div class="form-group">
              <label class="details-head">'.Lang::$say->_BKG_GUESTCOUNTRY.':</label><label class="text-normal">'.$row->guestcountry.'</label>
              </div>'.$amount.$deposit.$balancedue.'           
            </div>'.$cols.'<div class="col-padding">
'.$this->getAttachmentList($id,true,1).$info.'			       

              <div class="form-group">
                <label class="details-head">'.Lang::$say->_BKG_CREATEDON.':</label><label class="text-normal">'.displayMyDate($row->created).'</label>
				</div>';
if($this->isCanEditBlock($id)){			
$disp .= '<div class="form-group">
                <label class="details-head">'.Lang::$say->_BKG_CREATEDBY.':</label><label class="text-normal">'.$creator.'</label>
				</div>';
}
$disp .= '<div class="form-group">
                <label class="details-head">'.Lang::$say->_BKG_LASTUPD.':</label><label class="text-normal">'.displayMyDate($row->updated).'</label>
              </div>';
if(Vault::get("Users")->userlevel<=9 && Vault::get("Users")->userlevel>7){			
$disp .= '<div class="form-group">
                <label class="details-head">'.Lang::$say->_BKG_UPDATEDBY.':</label><label class="text-normal">'.$updater.'</label>
              </div>';
}
$disp .= '</div></div>

          </div>
';
}
          return ($row) ? sanitize_output($disp) : false;
	  }	
	  
/**
* Calendar::addFormBlock()
* 
* @return
*/
public function addFormBlock()
{

if($this->isCanCreateBlock()){

if(isset($_POST['ppttype']) && $_POST['ppttype']){$ppttype = $_POST['ppttype'];}else{$ppttype = false;}
if(isset($_POST['date']) && $_POST['date']){$date = $_POST['date'];}else{$date = false;}
if(isset($_POST['year']) && $_POST['year']){$year = $_POST['year'];}else{$year = false;}
if(isset($_POST['vmode']) && $_POST['vmode']){$vmode = $_POST['vmode'];}else{$vmode = false;}

if((Vault::get("Vhrental")->isPptTypeLocked($ppttype)||Vault::get("Gist")->pptlock) && (Vault::get("Users")->userlevel<8)){$islocked=true;}else{$islocked=false;}

if(Vault::get("Gist")->site_dsep=='.'){$numinputclass=' ti-ifnumdep';}else{$numinputclass=' ti-ifnumdec';}

$fileSelects = false;
for ($x = 0; $x < FILES_BROWSENUM; $x++) {
if(FILES_BROWSENUM==1){$fcol='12';}else{$fcol='6';}
if(FILES_MULTISELECT){$filesMulti=' multiple="multiple" ';$fsPlaceholder=Lang::$say->_FILES_MULTIPLE;}else{$filesMulti=' ';$fsPlaceholder=Lang::$say->_FILES_SINGLE;}
$fileSelects .='<div class="col-sm-'.$fcol.'">
<div class="form-group">
<input'.$filesMulti.'class="filestyle" data-badge="true" type="file" id="multiFiles" name="files[]" accept="'.FILES_TYPES_ACCEPTED.'"/>
</div>
</div>';
} 
if($fileSelects){$fileSelects='<div class="row"><div class="col-sm-12"><label>'.Lang::$say->_FILES_ATTACHMENT.'</label><div class="righttool"><a href="javascript:void(0)" class="clear-filestyle">'.Lang::$say->_CLEAR.'</a></div></div></div><div class="row" id="files-container">'.$fileSelects.'</div></div></div>';}else{$fileSelects='';}

$addform ='';
if(!$islocked){	 $addform .=' 
        <form class="form" id="form_bookingadd">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="checkin">'.Lang::$say->_BKG_CHKIND.'</label>
                <input data-listcont="bookingadd" data-auth="'.genRequestKey(Vault::get("Users")->uid.'checkAvailDate').'" type="text" class="form-control checkin setbookingdate" name="checkin">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="checkout">'.Lang::$say->_BKG_CCHKOUTD.'</label>
                <input data-listcont="bookingadd" data-auth="'.genRequestKey(Vault::get("Users")->uid.'checkAvailDate').'" type="text" class="form-control checkout setbookingdate" name="checkout">
              </div>
            </div>         
            <div class="col-sm-4">
              <div class="form-group">
                <label style="width:100%" for="status">'.Lang::$say->_BKG_STATUS.'</label>
				<div class="input-group"><div class="input-group-prepend"><span class="input-group-text wprev"><div class="colorprev"></div></span></div>
                  '.Vault::get("Vhrental")->blockStatSelectBox('bookingstatus',false).'
				  </div>
              </div>
            </div>
          </div>
          
<div class="row">
          <div class="col-sm-6">
              <div class="form-group">
                <label for="guestname">'.Lang::$say->_BKG_GUESTNAME.'</label>
                <input type="text" class="form-control" name="guestname">
              </div>
          </div>
           <div class="col-sm-3">
           <div class="form-group">
                <label for="guestadult">'.Lang::$say->_BKG_GUESTADULT.'</label>
                <input type="text" class="form-control ti-ifnumber" name="guestadult" maxlength="3">
              </div>             
            </div>
            <div class="col-sm-3">
           <div class="form-group">
                <label for="guestchild">'.Lang::$say->_BKG_GUESTCHILD.'</label>
                <input type="text" class="form-control ti-ifnumber" name="guestchild" maxlength="3">
              </div>
           </div>          
</div>    
<div class="row">
           <div class="col-sm-4">
           <div class="form-group">
                <label for="guestemail">'.Lang::$say->_BKG_GUESTEMAIL.'</label>
                <input type="text" class="form-control" name="guestemail">
              </div>             
            </div>
            <div class="col-sm-4">
           <div class="form-group">
                <label for="guestphone">'.Lang::$say->_BKG_GUESTPHONE.'</label>
                <input type="text" class="form-control" name="guestphone">
              </div>
           </div>
           <div class="col-sm-4">
               <div class="form-group">
                <label for="guestcountry">'.Lang::$say->_BKG_GUESTCOUNTRY.'</label>
                <input type="text" class="form-control" name="guestcountry">
              </div>             
            </div>
</div>
<div class="row">
          <div class="col-sm-4">
              <div class="form-group">
                <label for="amount">'.Lang::$say->_BKG_AMOUNT.'</label>
				<div class="input-group">
				<div class="input-group-prepend"><span class="input-group-text">'.Vault::get("Gist")->site_currsym.'</span></div>				
                <input type="text" class="form-control'.$numinputclass.'" name="amount" maxlength="12">
              </div></div>
          </div>
           <div class="col-sm-4">
           <div class="form-group">
                <label for="deposit">'.Lang::$say->_BKG_DEPOSIT.'</label>
				<div class="input-group">
				<div class="input-group-prepend"><span class="input-group-text">'.Vault::get("Gist")->site_currsym.'</span></div>				
                <input type="text" class="form-control'.$numinputclass.'" name="deposit" maxlength="12">
              </div></div>            
            </div>
            <div class="col-sm-4">
           <div class="form-group">
                <label for="balancedue">'.Lang::$say->_BKG_BALANCEDUE.'</label>
				<div class="input-group">
				<div class="input-group-prepend"><span class="input-group-text">'.Vault::get("Gist")->site_currsym.'</span></div>
                <input type="text" class="form-control'.$numinputclass.'" name="balancedue" maxlength="12">
              </div></div>
           </div>          
</div>
'.$fileSelects.'<div id="attachment-list" class="listpanel_bookingfileadd"></div>
<div class="row">
            <div class="col-sm-8">           
              <div class="form-group">
                <label for="company">'.Lang::$say->_BKG_NOTES.'</label>
                <textarea name="note_en" rows="4" class="form-control" type="text" style="height:80px;resize:none;"></textarea>
              </div>
           </div>
           <div class="col-sm-4"> 
              <div class="form-group"><label>&nbsp;</label>
                <input type="hidden" name="bookingadd_ppttype" value="'.$ppttype.'">
				<input type="hidden" name="bookingadd_vmode" value="'.$vmode.'">
                <input type="hidden" name="saveBooking" value="'.genRequestKey('saveBooking'.Vault::get("Users")->uid).'">
                <button id="save_bookingadd" data-after="hide" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.Lang::$say->_SAVE.'</button>
              </div>
            </div>
          </div>
        </form>
        <div id="msg_bookingadd"></div>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {


	var suffix = "bookingadd";
	var ppttype = "";
	var fdate = "'.$date.'";
	if(fdate){
	var date = fdate.split("-");}
		
if($("#form_"+suffix).length){

$("#msg_"+suffix).html("");
$("#form_"+suffix).show(); 

	
$(".colorprev").css("background","none");
$(".checkin").pickadate({
format: "dd mmm yyyy",
formatSubmit: "yyyy-mm-dd",
min:false,
firstDay: '.$this->jsweekStartedDay.',
  onSet: function() {
    $(".checkout").pickadate("picker").set("min",$(".checkin").pickadate("picker").get());
  }
	});
$(".checkout").pickadate({
format: "dd mmm yyyy",
formatSubmit: "yyyy-mm-dd",
min:+1,
firstDay: '.$this->jsweekStartedDay.'
	});
	
$(".checkin").pickadate("picker").clear();
$(".checkout").pickadate("picker").clear();	

if(fdate){
$(".checkin").pickadate("picker").set("select", new Date(date[0], date[1]-1, date[2]));
$(".checkout").pickadate("picker").set("view", new Date(date[0], date[1]-1, date[2]));
}

}


$(":file").filestyle({badge: true,input: true,buttonBefore: true,btnClass: "btn-default",htmlIcon: \'<span class="glyphicon glyphicon-folder-open"></span>\',text: "",badgeName: "badge-danger",placeholder: "'.$fsPlaceholder.'"});

$(document).on("click", ".clear-filestyle", function(event) {
 event.preventDefault();
 event.stopPropagation();
$(":file").filestyle("clear");
  }); 


});
// ]]>
</script>
		';}
		else{
$addform .=Sift::msgWarning(Lang::$say->_BKG_NEWBLOCKED, false,false,false,false);			
			
			};
			}
return sanitize_output($addform);	
}


/**
* Calendar::modalBlockForms()
* 
* @return
*/
public function modalBlockForms()
	  {
$disp='';
if($this->isCanCreateBlock()){
$disp ='<div class="modal fade" id="modaldlg_bookingadd" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">	
       <h5 class="modal-title"><span class="glyphicon glyphicon-plus"></span> '.Lang::$say->_BKG_CREATE.'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="'.Lang::$say->_CLOSE.'">
          <span aria-hidden="true">&times;</span>
        </button>		
		</div>
      <div id="panel_bookingadd" class="modal-body">		
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modaldlg_bookingedit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
       <h5 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> '.Lang::$say->_BKG_EDIT.'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="'.Lang::$say->_CLOSE.'">
          <span aria-hidden="true">&times;</span>
        </button>		
		</div>
      <div  id="panel_bookingedit" class="modal-body"></div>
    </div>
  </div>
</div>';}
$disp .='
<div class="modal fade" id="modaldlg_bookinginfo" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
       <h5 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span> '.Lang::$say->_BKG_BLKDETAILS.'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="'.Lang::$say->_CLOSE.'">
          <span aria-hidden="true">&times;</span>
        </button>		
		</div>
      <div id="panel_bookinginfo" class="modal-body"></div>
    </div>
  </div>
</div>
';
print ($disp)?sanitize_output($disp):'';	
}



/**
* Calendar::deleteUserBlocks()
* 
* @param mixed $userid
* @return
*/
public function deleteUserBlocks($userid=false)
{
	if($userid){
$userid = sanitize($userid);
$userid = self::$db->escape($userid);
$query = "SELECT id"
	. "\n FROM " . self::bdetTable
	. "\n WHERE userid = '" . $userid ."'"
	. "\n";
$row = self::$db->fetch_all($query);
if($row){
foreach ($row as $detrow) {
self::$db->delete(self::bdatTable, "bookingid='" . $detrow->id."'");


$queryf = "SELECT filename"
	. "\n FROM " . self::bfilesTable
	. "\n WHERE bookingid = '" . $detrow->id ."'"
	. "\n";
$rowf = self::$db->fetch_all($queryf);
	foreach ($rowf as $attrow) {
		if($attrow->filename){
			@unlink('../'.FILES_DIR.'/' .$attrow->filename);
			}
		}unset($attrow);

self::$db->delete(self::bfilesTable, "bookingid='" . $detrow->id."'");
self::$db->delete(self::bdetTable, "id='" . $detrow->id."'");
}
unset($detrow);
}
	}else{return(false);}

}


/**
* Calendar::deletePptTypeBlocks()
* 
* @param mixed $pptypeid
* @return
*/
public function deletePptTypeBlocks($pptypeid=false)
{
	if($pptypeid){
$pptypeid = sanitize($pptypeid);
$pptypeid = self::$db->escape($pptypeid);
$query = "SELECT id"
	. "\n FROM " . self::bdetTable
	. "\n WHERE ppttypeid = '" . $pptypeid ."'"
	. "\n";
$row = self::$db->fetch_all($query);
if($row){
foreach ($row as $detrow) {
self::$db->delete(self::bdatTable, "bookingid='" . $detrow->id."'");
self::$db->delete(self::bdetTable, "id='" . $detrow->id."'");
}
unset($detrow);
}
	}else{return(false);}

}



/**
* Calendar::blockDetails()
* 
* @param mixed $id
* @return
*/
public function blockDetails($id)
	  {
          $id = sanitize($id);
          $id = self::$db->escape($id);
		  
if(!$this->isCanViewDetails($id)){exit;}	  

 $query = "SELECT de.*, de.id as detbookingid, de.status as destatus, de.note_en as denote, st.title" . Lang::$lang . " as statustitle, st.colorhex as blockcolor, pt.name as ppttype"
		  . "\n FROM " . self::bdetTable . " as de"
		  . "\n LEFT JOIN " . Vhrental::blksTable . " as st ON st.id = de.status "
		  . "\n LEFT JOIN " . Vhrental::pptyTable . " as pt ON pt.id = de.ppttypeid "
		  . "\n WHERE de.id = '" . $id."' "
		  . "\n";
		  $row = self::$db->first($query);
if($row){		  
$checkin = explode("-",$row->checkin);
$checkout = explode("-",$row->checkout);
$numnights = $this->countDateRange($checkin[0],$checkin[1],$checkin[2],$checkout[0],$checkout[1],$checkout[2]);
$numdays = $numnights+1;
if($numnights>1){$numnights = $numnights.' '.Lang::$say->_BKG_NIGHTS;}else{$numnights = $numnights.' '.Lang::$say->_BKG_NIGHT;}
$numdays = $numdays.' '.Lang::$say->_BKG_DAYS.' '.$numnights;

if($row->guestadult){
if($row->guestadult>1){$guestadult = $row->guestadult.' '.Lang::$say->_BKG_GUESTADULTS;}else{$guestadult = $row->guestadult.' '.strtolower(Lang::$say->_BKG_GUESTADULT);}}else{$guestadult='';}

if($row->guestchild){
if($row->guestchild>1){$guestchild = ' '.$row->guestchild.' '.Lang::$say->_BKG_GUESTCHILDS;}else{$guestchild = ' '.$row->guestchild.' '.strtolower(Lang::$say->_BKG_GUESTCHILD);}}else{$guestchild='';}
if(!$row->guestadult && !$row->guestchild){$guestadult='-';}



$creator = getValue('username', Users::usrTable, "id=".$row->userid);
$updater = getValue('username', Users::usrTable, "id=".$row->updaterid);
$disp =
Lang::$say->_PPT_TYPE.': '.$row->ppttype.'<br />'.
Lang::$say->_BKG_CHKIND.': '.displayDate($row->checkin).'<br />'.
Lang::$say->_BKG_CCHKOUTD.': '.displayDate($row->checkout).'<br />'.
Lang::$say->_BKG_LOSTAY.': '.$numdays.'<br />'.
Lang::$say->_BKG_STATUS.': '.$row->statustitle.'<br />'.
Lang::$say->_BKG_GUESTNAME.': '.$row->guestname.'<br />'.
Lang::$say->_BKG_GUESTNUM.': '.$guestadult.$guestchild.'<br />'.
Lang::$say->_BKG_GUESTEMAIL.': '.$row->guestemail.'<br />'.
Lang::$say->_BKG_GUESTPHONE.': '.$row->guestphone.'<br />'.
Lang::$say->_BKG_GUESTCOUNTRY.': '.$row->guestcountry.'<br />'.
Lang::$say->_BKG_NOTES.': '.$row->denote.'<br />'.
Lang::$say->_BKG_CREATEDON.': '.displayMyDate($row->created).'<br />'.
Lang::$say->_BKG_CREATEDBY.': '.$creator.'<br />'.
Lang::$say->_BKG_LASTUPD.': '.displayMyDate($row->updated).'<br />'.
Lang::$say->_BKG_UPDATEDBY.': '.$updater.'<br />';
}
          return ($row) ? sanitize_output($disp) : false;
	  }	


/**
* Calendar::checkFeedData()
* 
* @return
*/
public function checkFeedData($ppttype,$checkin,$checkout)
	  {
  			  
			  $dstart = explode("-",$checkin);
			  $dend = explode("-",$checkout);
			  $idays = self::createDateRangeArray($dstart[0],$dstart[1],$dstart[2],$dend[0],$dend[1],$dend[2]);
		      $rowpt = Vault::get("Gist")->getRowById(Vhrental::pptyTable, $ppttype);
			  $x=0;
			  $dataret = array();
			  foreach ($idays as $idate) {
				  
			  $data1 = $this->checkCalData($idate,1,$ppttype);
              $data2 = $this->checkCalData($idate,2,$ppttype);
				
			  
			  
			  if($data1 && !$data2){
				  $dataret[$x]=Lang::$say->_BKG_FEEDAVAILCI;
			  }
			  
			  if(!$data1 && $data2){
				  $dataret[$x]=Lang::$say->_BKG_FEEDAVAILCO;
			  }
			  
			  if($data1 && $data2){
				  $dataret[$x]=Lang::$say->_BKG_FFEDNAVAIL;
			  }

			  if(!$data1 && !$data2){
				  $dataret[$x]=Lang::$say->_BKG_FEEDAVAIL;
			  }	
			  if(!$rowpt->publish){$dataret[$x]=Lang::$say->_BKG_FFEDNAVAIL;}
			  		  
				$x++;  
			  }//foreach idays
			unset($idate);
				
			return($dataret);  


	  }




/**
* Calendar::eventList()
* 
* @param mixed $ppttype
* @return
*/
public function eventList($ppttype=false)
	  {


		  $sql = "SELECT e.*, e.id as bookingid, DAY(checkin) as sday, st.title" . Lang::$lang . " as statustitle, e.note_en as remarks"
		  . "\n FROM " . self::bdetTable . " as e"
		  . "\n LEFT JOIN " . Vhrental::blksTable . " as st ON st.id = e.status "
		  . "\n WHERE e.ppttypeid  = " . (int)$ppttype." "
		  . "\n ORDER BY created ASC";

		  		  
		  $row = self::$db->fetch_all($sql);
		  if($row){return ($row);}else{return (false);}	


	  }



/**
* Calendar::isCanExpDetails()
* 
* @return
*/
public function isCanExpDetails($bookingid=false,$username=false)
	{
	$userdt=getValues("id,userlevel", Users::usrTable, "username='".$username."'");
	switch($userdt->userlevel){
		case 9: return(1);
		break;
		case 8: return(1);
		break;
		case 7: return(1);
		break;
		case 6: if(getValueById('userid', self::bdetTable, $bookingid)==$userdt->id){
			return(2);}else{return(false);};
		break;
		case 5: return(false);
		break;
		case 4: return(false);
		break;
		default: return(false);
		break;
		}
	}	


      /**
       * Calendar::getAttachmentList()
       * 
       * @return
       */
      public function getAttachmentList($bid,$viewonly=false,$col=2)
	  {
		  if($col==1){$col=12;}else{$col=6;}
		  $query = self::$db->query("SELECT * FROM " . self::bfilesTable ." WHERE bookingid='".$bid
		  . "' \n ORDER BY updated DESC ");
		  
		  $res = self::$db->numrows($query);
		  $disp ='<div class="row attachment-list">';
		  
		  while ($row = self::$db->fetch($query)) {
			
		if($viewonly){			  
			  $disp .='<div id="attachment_'.$row->id.'" class="col-sm-'.$col.' col-md-'.$col.' col-lg-'.$col.'">
			  <div class="row"><div class="col-sm-12"><a target="_blank" class="attachment-item" href="'.FILESURL.$row->filename.'">
			  <span class="glyphicon glyphicon-file" aria-hidden="true"></span> '.$row->filetitle.'</a></div></div></div>';			
		}else{			  
			  $disp .='<div id="attachment_'.$row->id.'" class="col-sm-6">
			  <div class="row"><div class="col-12"><a target="_blank" class="attachment-item" href="'.FILESURL.$row->filename.'">
			  <span class="glyphicon glyphicon-file" aria-hidden="true"></span> '.$row->filetitle.'</a>
<a class="itemdelete" data-listcont="bookingfileedit" data-option="deleteAttachment" data-vmode="'.$bid.'" data-id="'.$row->id.'" data-auth="'.genRequestKey('deleteAttachment'.$row->id).'" href="javascript:void(0);" data-name="'.$row->filetitle.'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a> 			  
			  </div></div></div>';
		}

		  }
if($viewonly){$disp ='<div class="form-group"><div class="row"><div class="col-sm-12"><label>'.Lang::$say->_FILES_ATTACHMENT.':</label></div></div>'.$disp.'</div>';
}
		  
		  $disp .='</div>';
$notypes=' ';  
		  return ($res) ? sanitize_output($disp) : $notypes;
	  }
	  
	  


      /**
       * Calendar::countAttached()
       * 
       * @return
       */
      public function countAttached($bid)
	  {
		  $query = self::$db->query("SELECT * FROM " . self::bfilesTable ." WHERE bookingid='".$bid
		  . "' \n ORDER BY updated DESC ");		  
		  $res = self::$db->numrows($query);
		  return ($res) ? $res : 0;
	  }



	  
	  /**
	   * Calendar::monthSelect()
	   *
       * @return
       */
	  public function monthSelect($selid=false)
	  {
		$disp='';
		for ($mn = 1; $mn < 13; $mn++){
			if($selid){$selid=$selid;}else{$selid=date("m");}
			if(intval($selid)==$mn){$selected=' selected="selected" ';}else{$selected='';}
			if($selid==''){$selected='none';}
			 $disp .='<option value="'.$mn.'"'.$selected.'>'.$this->arrMonths[$mn][$this->monthNameLength].'</option>';	
		}
		return $disp;
	  }



/**
* Calendar::blocksToCsv()
* 
* @param mixed $year
* @param mixed $ppttype
* @return
*/
public function blocksToCsv($year=false,$ppttype=false)
	  {
		$counter=0;
		$result = array();
		if(!$year || !$ppttype){
			exit;		
		}

$pptyname=getValueById('name', Vhrental::pptyTable, $ppttype);

		for ($mn = 1; $mn < 13; $mn++) {
			
          $day = date("d");
		  $ldim = $this->calcDays($mn, $day);
		  if($day > $ldim) {
		  	$day = $ldim;
		  }		
		  $cdate = getdate(mktime(0, 0, 0, $mn, $day, $year));
          $prevYear = getdate(mktime(0, 0, 0, $mn, $day, $cdate['year'] - 1));
          $nextYear = getdate(mktime(0, 0, 0, $mn, $day, $cdate['year'] + 1));
		  $is_day = 0;
		  $first_day = getdate(mktime(0, 0, 0, $mn, 1, $cdate['year']));
		  $last_day = getdate(mktime(0, 0, 0, $mn + 1, 0, $cdate['year']));
		  
		  if(Vault::get("Users")->userlevel<7 && Vault::get("Users")->userlevel>5){
			  $userq=" AND e.userid=".(int)Vault::get("Users")->uid;
			  }else{
				  $userq="";
				  }

		  $sql = "SELECT e.*, e.id as bookingid, DAY(checkin) as sday, st.title" . Lang::$lang . " as statustitle, st.colorhex as blockcolor"
		  . "\n FROM " . self::bdetTable . " as e"
		  . "\n LEFT JOIN " . Vhrental::blksTable . " as st ON st.id = e.status "
		  . "\n WHERE ((YEAR(checkin) = " . (int)$cdate['year']
		  . "\n AND MONTH(checkin) = " . (int)$cdate['mon']."))"
		  . "\n AND e.ppttypeid  = " . (int)$ppttype." ".$userq
		  . "\n ORDER BY checkin ASC";
		  		  
		  $row = self::$db->fetch_all($sql);
		  if($row){
			  foreach ($row as $i => $brow) {
				  
$checkin = explode("-",$brow->checkin);
$checkout = explode("-",$brow->checkout);
$numnights = $this->countDateRange($checkin[0],$checkin[1],$checkin[2],$checkout[0],$checkout[1],$checkout[2]);
$numdays = $numnights+1;


if($brow->guestadult){$guestadult = $brow->guestadult;}else{$guestadult='';}
if($brow->guestchild){$guestchild = $brow->guestchild;}else{$guestchild='';}
if(!$brow->amount||$brow->amount==0){$bkamount='';}else{$bkamount = $brow->amount;}
if(!$brow->deposit||$brow->deposit==0){$bkdeposit='';}else{$bkdeposit = $brow->deposit;}
if(!$brow->balancedue||$brow->balancedue==0){$bkbalancedue='';}else{$bkbalancedue = $brow->balancedue;}
$creator = getValue('username', Users::usrTable, "id=".$brow->userid);
$updater = getValue('username', Users::usrTable, "id=".$brow->updaterid);
if($brow->created=='0000-00-00 00:00:00'){$brow->created='';}
if($brow->updated=='0000-00-00 00:00:00'){$brow->updated='';}
$attachments=$this->countAttached($brow->bookingid);
if($attachments>0){$attachments=$attachments.' '.Lang::$say->_FILES_FILE;}else{$attachments='';}

if($this->isCanViewDetails($brow->bookingid)){
$counter++;
$result[]=array(
'#' => $counter,
Lang::$say->_PPT_TYPE => $pptyname,
Lang::$say->_BKG_CHKIND => ($brow->checkin),
Lang::$say->_BKG_CCHKOUTD => ($brow->checkout),
Lang::$say->_BKG_STATUS => $brow->statustitle,
Lang::$say->_BKG_DAYS => $numdays,
Lang::$say->_BKG_NIGHTS => $numnights,
Lang::$say->_BKG_GUESTNAME => $brow->guestname,
Lang::$say->_BKG_GUESTADULT => $guestadult,
Lang::$say->_BKG_GUESTCHILD => $guestchild,
Lang::$say->_BKG_GUESTEMAIL => $brow->guestemail,
Lang::$say->_BKG_GUESTPHONE => $brow->guestphone,
Lang::$say->_BKG_GUESTCOUNTRY => $brow->guestcountry,
Lang::$say->_BKG_AMOUNT => $bkamount,
Lang::$say->_BKG_DEPOSIT => $bkdeposit,
Lang::$say->_BKG_BALANCEDUE => $bkbalancedue,
Lang::$say->_BKG_CREATEDON => $brow->created,
Lang::$say->_BKG_CREATEDBY => $creator,
Lang::$say->_BKG_LASTUPD => $brow->updated,
Lang::$say->_BKG_UPDATEDBY => $updater,
Lang::$say->_FILES_ATTACHMENT => $attachments,
Lang::$say->_BKG_NOTES => $brow->note_en);
}
				  
			  }//foreach
			  unset($brow);

		  }	

		}
		
	return ($result) ? $result :false;

	  }




/**
* Calendar::renderSearchList()
* 
* @param mixed $keyword
* @return
*/
public function renderSearchList($keyword=false)
	  {
		$rend=false;$disp=false;$counter=0;		

		  
		  if(Vault::get("Users")->userlevel<7 && Vault::get("Users")->userlevel>5){
			  $userq=" AND e.userid=".(int)Vault::get("Users")->uid;
			  $emptylist=Lang::$say->_BKG_SCYOURLISTEMPTY.': <strong>'.$keyword.'</strong>';
			  }else{
				  $userq="";
				  $emptylist=Lang::$say->_BKG_SCLISTEMPTY.': <strong>'.$keyword.'</strong>';
				  }
if (strpos($keyword, '@') !== false) {
    $mtq=" AGAINST ('\"" . self::$db->escape($keyword) . "*\"' IN BOOLEAN MODE) ";
}else{
    $mtq=" AGAINST ('" . self::$db->escape($keyword) . "*' IN BOOLEAN MODE) ";
}		  

		  $sql = "SELECT e.*, e.id as bookingid, DAY(checkin) as sday,MONTH(checkin) as smonth,YEAR(checkin) as syear, st.title" . Lang::$lang . " as statustitle, st.colorhex as blockcolor"
		  . "\n FROM " . self::bdetTable . " as e"
		  . "\n LEFT JOIN " . Vhrental::blksTable . " as st ON st.id = e.status "
		  . "\n WHERE ((e.guestname LIKE '%".$keyword."%') OR (e.guestemail LIKE '%".$keyword."%')  OR (e.guestcountry LIKE '%".$keyword."%')) " 
		  .$userq
		  . "\n ORDER BY checkin ASC";


		  		  
		  $row = self::$db->fetch_all($sql);
		  if($row){
			  $counter++;

			  foreach ($row as $brow) {

			  $rend .= '
<div class="card panel-default">
<div class="card-header"><h3 class="card-title"><span class="moncalnum float-right"> '. str_pad(intval($brow->smonth) , 2 , "0" , STR_PAD_LEFT) . '</span>' . $this->arrMonths[$brow->smonth][$this->monthNameLength] .'  <span class=""> '. $brow->syear . '</span></h3></div>
  <div class="card-body">
    <div class="rowspan yearlist"><table class="restable table table-sm"><tbody>';				  
$checkin = explode("-",$brow->checkin);
$checkout = explode("-",$brow->checkout);
$numnights = $this->countDateRange($checkin[0],$checkin[1],$checkin[2],$checkout[0],$checkout[1],$checkout[2]);
$numdays = $numnights+1;
if($numnights>1){$numnights = $numnights.' '.Lang::$say->_BKG_NIGHTS;}else{$numnights = $numnights.' '.Lang::$say->_BKG_NIGHT;}
$numdays = $numdays.' '.Lang::$say->_BKG_DAYS.' '.$numnights;

if($brow->guestadult){
if($brow->guestadult>1){$guestadult = $brow->guestadult.' '.Lang::$say->_BKG_GUESTADULTS;}else{$guestadult = $brow->guestadult.' '.strtolower(Lang::$say->_BKG_GUESTADULT);}}else{$guestadult='';}

if($brow->guestchild){
if($brow->guestchild>1){$guestchild = ' '.$brow->guestchild.' '.Lang::$say->_BKG_GUESTCHILDS;}else{$guestchild = ' '.$brow->guestchild.' '.strtolower(Lang::$say->_BKG_GUESTCHILD);}}else{$guestchild='';}
if(!$brow->guestadult && !$brow->guestchild){$guestadult='-';}

$creator = getValue('username', Users::usrTable, "id=".$brow->userid);
if($brow->userid==Vault::get("Users")->uid){$creator .= ' ('.Lang::$say->_ME.')';}
$updater = getValue('username', Users::usrTable, "id=".$brow->updaterid);
if($brow->updaterid==Vault::get("Users")->uid){$updater .= ' ('.Lang::$say->_ME.')';}

$attachments=$this->countAttached($brow->bookingid);

if($this->isCanEditBlock($brow->bookingid)){
	$btnedit='<a class="bked itemaction" href="javascript:void(0);" data-cont="bookingedit" data-id="'.$brow->bookingid.'" data-option="editBoking" data-vmode="searchlist" data-keyword="'.$keyword.'"><span class="glyphicon glyphicon-pencil"></span></a>';
	$btddelete='<a class="bkdel itemaction itemdelete" href="javascript:void(0);" data-listcont="bookingdel" data-id="'.$brow->bookingid.'" data-option="deleteBooking" data-vmode="searchlist" data-keyword="'.$keyword.'"  data-name="' . displayDate($brow->checkin) .' - ' . displayDate($brow->checkout) .', '.$brow->statustitle.'"><span class="glyphicon glyphicon-remove"></span></a>';	
	}else{
	$btnedit='';
	$btddelete='';	
	}
if($this->isCanViewDetails($brow->bookingid)){
if($attachments>0){$attachments=' <span class="glyphicon glyphicon-paperclip"></span>';}else{$attachments='';}	
	$btninfo='<a class="bkinf itemaction" href="javascript:void(0);" data-cont="bookinginfo" data-id="'.$brow->bookingid.'" data-option="infoBoking" data-vmode="searchlist"><span class="glyphicon glyphicon-info-sign"></span></a>';
	$guestinfo=$brow->guestname.'<br />'.$guestadult.$guestchild;
	$authorinfo=Lang::$say->_BY.' '.$creator.'<br />'.displayMyDate($brow->created);	
}else{
	$btninfo='';
	$guestinfo='';
	$authorinfo='';
}
				  $rend .= '
          <tr>
            <td width="20%"><span class="colorinlist"><div class="calrel">
<div class="cout s'.$brow->status.'"></div>
<span class="dtnum">'.$brow->sday.'</span>
<div class="chin s'.$brow->status.'"></div>
</div></span> <span class="colorprevtext">'.$brow->statustitle.'</span></td>
            <td>' . displayDate($brow->checkin) .' - ' . displayDate($brow->checkout) .'<br />'.$numdays.'</td>
            <td width="25%">'.$guestinfo.$attachments.'</td>
            <td width="20%">'.$authorinfo.'</td>
			<td width="15%" class="text-right noprint"><div class="listactions">'.$btnedit.$btninfo.$btddelete.'</div>
		</td>
          </tr>';	
$rend .= '</tbody></table></div>
  </div>
</div>';		  			  
			  }//foreach
			  unset($brow);
	 
		  }	

if($counter===0){$rend = '<div class="alert alert-warning margin-top-15" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . $emptylist . '</p></div></div>';}else{$disp ='<div class="alert alert-success" role="alert">'.Lang::$say->_BKG_SCRESULTS.' <strong>'.$keyword.'</strong>:</div>';}
$disp .= Vault::get("Vhrental")->propertyTypeStylesheet().'
<div class="yearcalendar"><div class="rowspan">'.$rend.'</div>
<div class="clearfix"></div></div>
<div style="display:none;" id="popbkiavanae"></div>	
';

if(!$this->ppttype){$disp = '<div class="alert alert-warning margin-top-15" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div>';}

	return($disp);

	  }








	  
  }
?>