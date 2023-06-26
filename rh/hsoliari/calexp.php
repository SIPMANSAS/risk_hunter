<?php
  /**
   * Calexp
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: calexp.php, v1.1.1 Feb 2018 transinova $
   */
define("_EXECPERMIT_WNV", true);
require_once ("start.php");
require_once (BASEPATH . "classes/zapcallib/zapcallib.php");
$cWarning=false;
$feeddata=false;
function calexpNeatText($string)
  {
      $string = preg_replace('#^https?://#', '', $string);
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

if(isset($_GET['u'])){
	if($_GET['u']){
		$cUsername=sanitize($_GET['u']);
	}else{
		$cWarning+=1;
	}
	}else{$cWarning+=1;}

if(isset($_GET['k'])){
	if($_GET['k']){
		$cKey=sanitize($_GET['k']);
	}else{
		$cWarning+=1;
	}
	}else{$cWarning+=1;}

if(isset($_GET['p'])){
	if($_GET['p']){
		$cPropType=intval(restorePassId(sanitize($_GET['p'])));
		if(Vault::get("Vhrental")->propertyTypeIdExists($cPropType,true)){
			if(!$user->calExpAuth($cUsername,$cKey,$cPropType)){$cWarning+=1;}		
		}else{$cWarning+=1;}
	}else{
		$cWarning+=1;
	}
	}else{$cWarning+=1;}

if(!$cWarning){
$rowpt = Vault::get("Gist")->getRowById(Vhrental::pptyTable, $cPropType);
$feeddata= $cal->eventList($cPropType);
}

if($feeddata){
$callDomainText = calexpNeatText(sanitize(CFG_URL));

// TimeZone ID defined in the config
$calTzid = CFG_TZ;

// create the ical object
$icsVrbc = new ZCiCal();


$datanode = new ZCiCalDataNode("NAME:".htmlspecialchars($rowpt->name));
$icsVrbc->curnode->data[$datanode->getName()] = $datanode;
$datanode = new ZCiCalDataNode("X-WR-CALNAME:".htmlspecialchars($rowpt->name));
$icsVrbc->curnode->data[$datanode->getName()] = $datanode;
$datanode = new ZCiCalDataNode("X-WR-RELCALID:".$callDomainText.'.'.$cPropType);
$icsVrbc->curnode->data[$datanode->getName()] = $datanode;
$datanode = new ZCiCalDataNode("DESCRIPTION:".htmlspecialchars($gist->pptname.' - '.$rowpt->name));
$icsVrbc->curnode->data[$datanode->getName()] = $datanode;
$datanode = new ZCiCalDataNode("CALSCALE:GREGORIAN");
$icsVrbc->curnode->data[$datanode->getName()] = $datanode;



$tojson=array();
$i = 0;
foreach ($feeddata as $crow) {

if($cal->isCanExpDetails($crow->bookingid,$cUsername)){
	 if($gist->expinfostatus){$blockTitle = $crow->statustitle;}else{$blockTitle = Lang::$say->_BKG_BOOKED;}
	 if($gist->expinfoguestname && $crow->guestname){$blockTitle .= '; '.$crow->guestname;}
	 if($gist->expinfoguestnum){
if($crow->guestadult){
if($crow->guestadult>1){$guestadult = '; '.$crow->guestadult.' '.Lang::$say->_BKG_GUESTADULTS;}else{$guestadult = $crow->guestadult.' '.strtolower(Lang::$say->_BKG_GUESTADULT);}}else{$guestadult='';}

if($crow->guestchild){
if($crow->guestchild>1){$guestchild = ' '.$crow->guestchild.' '.Lang::$say->_BKG_GUESTCHILDS;}else{$guestchild = ' '.$crow->guestchild.' '.strtolower(Lang::$say->_BKG_GUESTCHILD);}}else{$guestchild='';}
if(!$crow->guestadult && !$crow->guestchild){$guestadult='';$guestchild='';}
		 $blockTitle .= $guestadult.$guestchild;}
	if($gist->expinfoguestcountry && $crow->guestcountry){$blockTitle .= '; '.$crow->guestcountry;}
	$blockDesc = $gist->pptname.' - '.$rowpt->name .'; '.$blockTitle;
	if($gist->expinforemarks && $crow->remarks){$blockDesc .= '; '.$crow->remarks;}
	
	}
else{
	$blockTitle = Lang::$say->_BKG_BOOKED;
	$blockDesc = false;
}

$blockLocation = htmlspecialchars($gist->pptaddress);

$blockCheckin = $crow->checkin." 14:00:00";
$blockCheckout = $crow->checkout." 12:00:00";
if($i==0){
// Add timezone data
ZCTimeZoneHelper::getTZNode(substr($blockCheckin,0,4),substr($blockCheckout,0,4),$calTzid, $icsVrbc->curnode);
}
// create the event within the ical object
$blockobj = new ZCiCalNode("VEVENT", $icsVrbc->curnode);
// add title
$blockobj->addNode(new ZCiCalDataNode("SUMMARY:" . htmlspecialchars($blockTitle)));

if($blockDesc){
// add desc
$blockobj->addNode(new ZCiCalDataNode("DESCRIPTION:" . htmlspecialchars($blockDesc)));
}
if($gist->expinfopptaddress){
// add location
$blockobj->addNode(new ZCiCalDataNode("LOCATION:" . $blockLocation));
}
// add status
//$blockobj->addNode(new ZCiCalDataNode("STATUS:" . $crow->statustitle));
// add start date
$blockobj->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($blockCheckin)));
// add end date
$blockobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($blockCheckout)));
$blockobj->addNode(new ZCiCalDataNode("CREATED:" . ZCiCal::fromSqlDateTime($crow->created)));
$blockobj->addNode(new ZCiCalDataNode("LAST-MODIFIED:" . ZCiCal::fromSqlDateTime($crow->updated)));
$blockobj->addNode(new ZCiCalDataNode("SEQUENCE:" . $i));
// UID is a required item in VEVENT, create unique string for this event
// Adding your domain to the end is a good way of creating uniqueness
$blockuid = date('Y-m-d-H-i-s') .'.'.$cPropType.'.'.$crow->checkin."@".$callDomainText;
$blockobj->addNode(new ZCiCalDataNode("UID:" . $blockuid));
// DTSTAMP is a required item in VEVENT
$blockobj->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime()));

$i++;

}

$calFileName = calexpNeatText($gist->pptname.'_'.$rowpt->name.'_'.$cUsername.'_'.date('Y-m-d-H-i-s').'.ics');
if(isset($_GET['d']) && $_GET['d']==1){
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename='.$calFileName);
}
echo $icsVrbc->export();
}else{echo 
"<div style='text-align:center;margin-top:50px;'>" 
 . "<span style='padding: 15px; border: 1px solid #faebcc;background-color: #fcf8e3; color: #8a6d3b;" 
. "border-radius: 4px;font-family: \"Helvetica Neue\",Helvetica,Arial,sans-serif; font-size: 14px; margin-left:auto; margin-right:auto'>" 
. Lang::$say->_GNL_FEED_URL_ERR."</span></div>";
}
?>