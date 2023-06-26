<?php
  /**
   * Feed
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: feed.php, v1.1.1 Feb 2018 transinova $
   */
define("_EXECPERMIT_WNV", true);
require_once ("start.php");
$cWarning=false;
if(isset($_GET['v'])){
	if($_GET['v']=='xml' || $_GET['v']=='json'){
		$cView=sanitize($_GET['v']);
	}else{
		$cWarning+=1;
	}
	}else{$cWarning+=1;}

if(isset($_GET['m'])){
	if(ctype_digit($_GET['m']) && $_GET['m']>0 && $_GET['m']<13){
		$cMonth=intval(sanitize($_GET['m']));
	}else{
		$cWarning+=1;
		}
	}else{$cWarning+=1;}
	
if(isset($_GET['y'])){
    if($cal->checkYear($_GET['y']) && $_GET['y']>1970){
		$cYear=intval(sanitize($_GET['y']));
		if($cYear<(date("Y")-CFG_PUBLPASTYEARS)){$cYear=(date("Y")-CFG_PUBLPASTYEARS);}
	}else{
		$cWarning+=1;
		}
}else{$cWarning+=1;}

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
		if(!$user->feedAuth($cUsername,$cKey,$cPropType)){$cWarning+=1;}		
		}else{$cWarning+=1;}		
	}else{
		$cWarning+=1;
	}
	}else{$cWarning+=1;}


if(!$cWarning){
$rowpt = Vault::get("Gist")->getRowById(Vhrental::pptyTable, $cPropType);
$daysinmonth = cal_days_in_month(CAL_GREGORIAN,$cMonth,$cYear);
$checkin=$cYear.'-'.$cMonth.'-01';
$checkout=$cYear.'-'.$cMonth.'-'.$daysinmonth;
$feeddata= $cal->checkFeedData($cPropType,$checkin,$checkout);
if($feeddata){
$feeddatalength = count($feeddata);

if($cView=='xml'){
$vrbcXML = new SimpleXMLElement("<vrbc></vrbc>");
$vrbcXML->addAttribute('month', $cMonth);
$vrbcXML->addAttribute('year', $cYear);
$vrbcXML->addAttribute('property', htmlspecialchars($gist->pptname.' - '.$rowpt->name));
}

$tojson=array();
for ($i = 0; $i < $feeddatalength; $i++) {
	$datenum = ($i+1);
	$caldate = $cYear.'-'.$cMonth.'-'.$datenum;

if($cView=='json'){
$tojson['caldate'][$i] = new StdClass;
$tojson['caldate'][$i]->id = $datenum;
$tojson['caldate'][$i]->type = htmlspecialchars($rowpt->name);
$tojson['caldate'][$i]->date = $caldate;
$tojson['caldate'][$i]->status = $feeddata[$i];
}


if($cView=='xml'){
$vrbcItem = $vrbcXML->addChild('caldate');
$vrbcItem->addChild('id', $datenum);
$vrbcItem->addChild('type', htmlspecialchars($rowpt->name));
$vrbcItem->addChild('date', $caldate);
$vrbcItem->addChild('status', $feeddata[$i]);
}
	
}
if($cView=='xml'){
Header('Content-type: application/xml');
echo $vrbcXML->asXML();}

if($cView=='json'){
echo json_encode($tojson);}
}
}else{echo 
"<div style='text-align:center;margin-top:50px;'>" 
 . "<span style='padding: 15px; border: 1px solid #faebcc;background-color: #fcf8e3; color: #8a6d3b;" 
. "border-radius: 4px;font-family: \"Helvetica Neue\",Helvetica,Arial,sans-serif; font-size: 14px; margin-left:auto; margin-right:auto'>" 
. Lang::$say->_GNL_FEED_URL_ERR."</span></div>";
}
?>