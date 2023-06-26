<?php
/**
* Controller
*
* @package Vacation Rentals Booking Calendar (VRBC)
* @author transinova.com
* @copyright 2017-2018
* @version $Id: controller.php, v1.1.0 Feb 2018 transinova $
*/

define("_EXECPERMIT_WNV", true);
require_once ("../start.php");


if($gist->showpubliccal && isset($_POST['view']) && $_POST['view']==12){
/* calNavigateYearView */
if (isset($_POST['calNavigateYearView']) && isset($_POST['year']) && $_POST['calNavigateYearView']==genRequestKey('calNavigateYearView'.$_POST['year'])){
	  $monthcal = $cal->renderCalendarM('monthdata',false,$_POST['year'],$_POST['ppttype'],$_POST['psview'],$_POST['view']);
	  if($monthcal) :
		  $json['status'] = 'success';
		  $json['content'] = $monthcal;		  
	  else :
		  $json['status'] = 'warning';
		  $json['content'] = '';
		  
	  endif;
	  print json_encode($json);	
 } 
}
if($gist->showpubliccal){
/* calNavigateMonth */
//
if (isset($_POST['calNavigateMonth']) && isset($_POST['month']) && isset($_POST['year']) && $_POST['calNavigateMonth']==genRequestKey('calNavigateMonth'.$_POST['month'].$_POST['year'])){

	$monthcal = $cal->renderCalendarM('monthdata',$_POST['month'],$_POST['year'],$_POST['ppttype'],$_POST['psview'],$_POST['months']);
	  if($monthcal) :
		  $json['status'] = 'success';
		  $json['content'] = $monthcal;		  
	  else :
		  $json['status'] = 'warning';
		  $json['content'] = '';
		  
	  endif;
	  print json_encode($json);	
 }  

	}

if ((!$user->logged_in) && (isset($_POST['passwordReset']) || isset($_POST['passResetCreate']))){

/* passwordReset */
if (isset($_POST['regemail']) && isset($_POST['passwordReset']) && $_POST['passwordReset']==genRequestKey('passwordReset')){
      $user->passResetRequest();
 }
/* passResetCreate */
if (isset($_POST['confnewpassword']) && isset($_POST['passResetCreate']) && $_POST['passResetCreate']==genRequestKey('passResetCreate')){
      $user->resetNewPassword();
 } 
}


$deleteitem = (isset($_POST['deleteitem']))  ? $_POST['deleteitem'] : null;
$edititem = (isset($_POST['edititem']))  ? $_POST['edititem'] : null;
$navigate = (isset($_POST['navigate']))  ? $_POST['navigate'] : null;

if($user->logged_in && $user->isSuperAdmin()){

/* savePropertyConfig */
if (isset($_POST['savePropertyConfig']) && $_POST['savePropertyConfig']==genRequestKey('savePropertyConfig')){
      $gist->setConfig();
 }

/* savePropertyType */
if (isset($_POST['savePropertyType']) && $_POST['savePropertyType']==genRequestKey('savePropertyType')){
      $vhr->savePropertyType();
 } 

/* saveUser */
if (isset($_POST['saveUser']) && $_POST['saveUser']==genRequestKey('saveUser')){
      $user->saveUserReg();
 } 
 
/* updatePropertyType */
if (isset($_POST['updatePropertyType']) && isset($_POST['id'])  && $_POST['updatePropertyType']==genRequestKey('updatePropertyType'.$_POST['id'])){
      $vhr->savePropertyType();
 } 
 
/* sortPropertyType */
if (isset($_POST['sortPropertyType']) && $_POST['sortPropertyType']==genRequestKey('sortPropertyType')){
      $vhr->reorderPropertyType();
 } 
 
/* updateBlockStatus */
if (isset($_POST['updateBlockStatus']) && isset($_POST['id'])  && $_POST['updateBlockStatus']==genRequestKey('updateBlockStatus'.$_POST['id'])){
      $vhr->saveBlockStatus();
 }

/* sortBlockStatus */
if (isset($_POST['sortBlockStatus']) && $_POST['sortBlockStatus']==genRequestKey('sortBlockStatus')){
      $vhr->reorderBlockStatus();
 }

/* updateUser */
if (isset($_POST['updateUser']) && isset($_POST['id'])  && $_POST['updateUser']==genRequestKey('updateUser'.$_POST['id'])){
      $user->saveUserReg();
 }
 
/* saveUassign */
if (isset($_POST['saveUassign']) && isset($_POST['id'])  && $_POST['saveUassign']==genRequestKey('saveUassign'.$_POST['id'])){
      $user->updateUassign();
 } 

/* updateEmTemplate */
if (isset($_POST['updateEmTemplate']) && isset($_POST['id'])  && $_POST['updateEmTemplate']==genRequestKey('updateEmTemplate'.$_POST['id'])){
      $gist->saveEmTemplate();
 }
 
/* updateLanguage */
if (isset($_POST['updateLanguage']) && isset($_POST['id'])  && $_POST['updateLanguage']==genRequestKey($_POST['id'].'updateLanguage')){
      $gist->updateLanguage();
 }

/* saveLanguage */
if (isset($_POST['saveLanguage']) && $_POST['saveLanguage']==genRequestKey('saveLanguage')){
      $gist->addLanguage();
 }  

/* sortLanguageList */
if (isset($_POST['sortLanguageList']) && $_POST['sortLanguageList']==genRequestKey('sortLanguageList')){
      $gist->reorderLanguageList();
 } 
 

/* == Delete Commands == */

switch ($deleteitem){
/* == Delete Propert Type == */
  case "deletePropertyType":
  	  $cal->deletePptTypeBlocks(Sift::$id);
	  $result = $db->delete(Vhrental::pptyTable, "id=" . Sift::$id);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = Sift::msgSuccess(Lang::$say->_PPT_TYPEDELETED, false,4000,false,true);
		  $json['content'] = $vhr->getTypeList();		  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
		  
	  endif;
	  print json_encode($json);
   break;
/* == Delete User == */
  case "deleteUser":
      $cal->deleteUserBlocks(Sift::$id);
	  $result = $db->delete(Users::usrTable, "id=" . Sift::$id);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = Sift::msgSuccess(Lang::$say->_UR_DELETED, false,4000,false,true);
		  $json['content'] = $user->getUserList();	  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
		  
	  endif;
	  print json_encode($json);
   break;

/* == delete Language == */
  case "deleteLanguage":
      $gist->removeLanguage(Sift::$id);
	  $result = $db->delete(Gist::lngTable, "id=" . Sift::$id);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = Sift::msgSuccess(Lang::$say->_LANG_DELETED, false,4000,false,true);
		  $json['content'] = $gist->getLanguageList();	  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
		  
	  endif;
	  print json_encode($json);
   break;	   



}//delete switch 

switch ($edititem){
/* == Edit Propert Type == */
  case "editPropertyType":
	  $result = $vhr->editFormType(Sift::$id);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = '';
		  $json['content'] = $result;		  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
		  
	  endif;
	  print json_encode($json);
   break;	
/* == Edit Block Status == */
  case "editBlockStatus":
	  $result = $vhr->editFormBlockStatus(Sift::$id);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = '';
		  $json['content'] = $result;		  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
		  
	  endif;
	  print json_encode($json);
   break;
/* == Edit User == */
  case "editUser":
	  $result = $user->editFormUser(Sift::$id);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = '';
		  $json['content'] = $result;		  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);		  
	  endif;
	  print json_encode($json);
   break;
/* == Edit Email Template == */
  case "editEmTemplate":
	  $result = $gist->editFormEmTemplate(Sift::$id);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = '';
		  $json['content'] = $result;		  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);		  
	  endif;
	  print json_encode($json);
   break;
/* == Edit Language == */
  case "editLanguage":
	  $result = $gist->editFormLanguage(Sift::$id);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = '';
		  $json['content'] = $result;		  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
		  
	  endif;
	  print json_encode($json);
   break;
/* == Edit User Assignment == */
  case "editUassign":
	  $result = $user->editFormUassign(Sift::$id);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = '';
		  $json['content'] = $result;		  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);		  
	  endif;
	  print json_encode($json);
   break;   
}//edit switch

/* == Update Phrase== */
if (isset($_POST['auth']) && isset($_POST['key']) && $_POST['auth']==genRequestKey('inPlaceEditLangPhrase'.$_POST['key']) && $_POST['type'] == "language"){
          if (empty($_POST['title'])){
              print '--- emptystring ---';
              exit;
		  }
		  else{
          if (file_exists(BASEPATH . Lang::langdir . $_POST['lang'] . "/lang.xml")){
		      $xmlel = simplexml_load_file(BASEPATH . Lang::langdir . $_POST['lang'] . "/lang.xml");
              $node = $xmlel->xpath("/language/phrase[@data = '" . $_POST['key'] . "']");
			  $title = cleanOut($_POST['title']);
			  $title = strip_tags($title);
              $node[0][0] = $title;
              $xmlel->asXML(BASEPATH . Lang::langdir . $_POST['lang'] . "/lang.xml");
		  }
		  print $title;
		  }
	  
}

/* == Navigate Commands == */
if (isset($_POST['navigate']) && $_POST['page'] && $_POST['auth']==genRequestKey($_POST['navigate'])){
switch ($navigate){
/* == Navigate Users == */
  case "reloadUsers":
	  $result = $user->getUserList();
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = Sift::msgSuccess(Lang::$say->_UR_UPDATED, false,4000,false,true);
		  $json['content'] = $result;	  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
		  
	  endif;
	  print json_encode($json);
   break;

/* == Navigate User Assigments == */
  case "reloadUassign":
	  $result = $user->getUserAssignments();
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = Sift::msgSuccess(Lang::$say->_UR_UPDATED, false,4000,false,true);
		  $json['content'] = $result;	  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
		  
	  endif;
	  print json_encode($json);
   break;   	
   
}//navigate switch
}

}//End if($user->isSuperAdmin())


if($user->logged_in){
/* saveProfile */
if (isset($_POST['saveProfile']) && $_POST['saveProfile']==genRequestKey('saveProfile'.$user->uid)){
      $user->updateProfile();
 }

/* updatePassword */
if (isset($_POST['updatePassword']) && $_POST['updatePassword']==genRequestKey($user->uid.'updatePassword')){
      $user->updatePassword();
 }



/* calNavigateYear */
if (isset($_POST['calNavigateYear']) && isset($_POST['year']) && $_POST['calNavigateYear']==genRequestKey('calNavigateYear'.$_POST['year']) && !isset($_POST['view'])){
	$yearcal = false;
	if(isset($_POST['vmode'])){
	if($_POST['vmode']=='yearlist'){
	$yearcal = $cal->renderCalendar('yearlist',$_POST['year'],$_POST['ppttype']);}
	elseif($_POST['vmode']=='yearstat'){
	$yearcal = $cal->renderStats('yearlist',$_POST['year'],$_POST['ppttype']);}
	}else{$yearcal = $cal->renderCalendar('yeardata',$_POST['year'],$_POST['ppttype']);}
	  if($yearcal) :
		  $json['status'] = 'success';
		  $json['content'] = $yearcal;		  
	  else :
		  $json['status'] = 'warning';
		  $json['content'] = '';
		  
	  endif;
	  print json_encode($json);	
 } 


/* regenerateAkey */
if (isset($_POST['regenerateakey']) && $_POST['id']){
	  $result = $user->regenerateAkey(Sift::$id);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = $vhr->exportLinks(Sift::$id);
		  $json['content'] = $vhr->feedLinks(Sift::$id);
		  $json['extra'] = $vhr->publicLinks(Sift::$id);	  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);		  
	  endif;
	  print json_encode($json);	  
 } 


/* linkExportCal */
if (isset($_POST['linkExportCal']) && $_POST['ppttype'] && $_POST['linkExportCal']==genRequestKey($user->uid.'linkExportCal')){
		  $json['status'] = 'success';
		  $json['content'] = $vhr->exportLink($_POST['ppttype']);
	      print json_encode($json);	  
 }

/* linkFeedCal */
if (isset($_POST['linkFeedCal']) && $_POST['ppttype'] && $_POST['linkFeedCal']==genRequestKey('linkFeedCal'.$user->uid)){
		  $json['status'] = 'success';
		  $json['content'] = $vhr->feedLink($_POST['ppttype'],$_POST['output'],$_POST['month'],$_POST['year']);
	      print json_encode($json);	  
 }
 

if($user->userlevel<=9 && $user->userlevel>=4){
/* linkPublicCal */
if (isset($_POST['linkPublicCal']) && $_POST['ppttype'] && $_POST['linkPublicCal']==genRequestKey('publicLinks'.$user->uid)){
		  $json['status'] = 'success';
		  $json['content'] = $vhr->publicLink($_POST['ppttype'],$_POST['month'],$_POST['year'],$_POST['calnum']);
	      print json_encode($json);	  
 } 
 
}//if(userlevel<=9 && userlevel>=4)

if($user->userlevel<=9 && $user->userlevel>5){
	
/* saveBooking */
if (isset($_POST['saveBooking']) && $_POST['saveBooking']==genRequestKey('saveBooking'.$user->uid)){
	if($cal->isCanCreateBlock()){
      $cal->saveBookingBlock();
	}
 } 

/* updateBooking */
if (isset($_POST['updateBooking']) && isset($_POST['id'])  && $_POST['updateBooking']==genRequestKey('updateBooking'.$_POST['id'])){
	if($cal->isCanEditBlock($_POST['id'])){
      $cal->saveBookingBlock();
	  }
 } 
 

/* checkAvailDate */
if (isset($_POST['checkAvailDate']) && $_POST['checkAvailDate']==genRequestKey($user->uid.'checkAvailDate')){
      $cal->checkDatesRange();
 }  


/* addBooking */
if (isset($_POST['addbooking']) && $_POST['ppttype']){
      if($cal->isCanCreateBlock()){
	  $result = $cal->addFormBlock();}else{$result = false;}
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = '';
		  $json['content'] = $result;		  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);		  
	  endif;
	  print json_encode($json);	  
 } 

/* editBooking */
if (isset($_POST['editbooking']) && $_POST['id']){
      if($cal->isCanEditBlock($_POST['id'])){
	  $result = $cal->editFormBlock(Sift::$id);}else{$result = false;}
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = '';
		  $json['content'] = $result;		  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);		  
	  endif;
	  print json_encode($json);	  
 } 

/* infoBooking */
if (isset($_POST['infobooking']) && $_POST['id']){
      if($cal->isCanViewDetails($_POST['id'])){
	  $result = $cal->infoFormBlock(Sift::$id);}else{$result = false;}
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = '';
		  $json['content'] = $result;		  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);		  
	  endif;
	  print json_encode($json);	  
 } 

/* delBooking */
if (isset($_POST['deleteitem']) && $_POST['id'] && ($_POST['deleteitem']=='deleteBooking')){
	if($cal->isCanEditBlock($_POST['id'])){
$row = $cal->getBlockDetails($_POST['id']);
$blockdetails = $cal->blockDetails($_POST['id']);
$ci = explode('-',$row->checkin);
if(isset($_POST['keyword'])){$keyword=sanitize($_POST['keyword']);}else{$keyword=false;}

	$queryf = "SELECT filename"
	. "\n FROM " . Calendar::bfilesTable
	. "\n WHERE bookingid = '" . Sift::$id ."'"
	. "\n";
	$rowf = $db->fetch_all($queryf);
	foreach ($rowf as $attrow) {
		if($attrow->filename){
			@unlink('../'.FILES_DIR.'/' .$attrow->filename);
			}
		}unset($attrow);

	  $db->delete(Calendar::bfilesTable, "bookingid=" .Sift::$id);
	
	  $resultdat = $db->delete(Calendar::bdatTable, "bookingid=" . Sift::$id);
	  $resultdet = $db->delete(Calendar::bdetTable, "id=" . Sift::$id);
	}else{$resultdat = false;$resultdet = false;}
	  if($resultdat && $resultdet) :
	  

if(($_POST['id'] && Vault::get("Gist")->notifyondelete)){
					  require_once (BASEPATH . "classes/class.mailer.php");
					  $rowtpl = Vault::get("Gist")->getRowById(Gist::etplTable, 4);
					  $datadate =date("d M Y, H:i");
					  $actionname = Lang::$say->_GNL_BLOCKDELETE;
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
						  displayDate($row->checkin).' - '.displayDate($row->checkout).', '.$row->statustitle,
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
				  displayDate($row->checkin).' - '.displayDate($row->checkout).', '.$row->statustitle		  
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
          $rownt = $db->fetch_all($sqlnt);
		  if($rownt){
			  foreach ($rownt as $usrn) {
				  $msg->setTo(array($usrn->email => $usrn->fname));
				  $mailer->send($msg);
				  
			  }//$usrn
			  unset($usrn);
		  }//rownt
					  
}
	  
		  $json['status'] = 'success';
		  $json['message'] = Sift::msgSuccess(Lang::$say->_BKG_BLKDELETED, false,4000,false,true);
		  if(isset($_POST['vmode']) && $_POST['vmode']=='yearlist'){
					  $json['content'] = $cal->renderCalendar('yearlist',$ci[0],$row->ppttypeid);}
			elseif(isset($_POST['vmode']) && $_POST['vmode']=='searchlist'){$json['content'] = $cal->renderSearchList($keyword);}
					  else{
					  $json['content'] = $cal->renderCalendar('yeardata',$ci[0],$row->ppttypeid);}		   
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);		  
	  endif;
	  print json_encode($json);
}

/* == delete Attachment == */
if (isset($_POST['deleteitem']) && $_POST['auth']==genRequestKey('deleteAttachment'.Sift::$id) && ($_POST['deleteitem']=='deleteAttachment')){

$filename = getValue('filename', Calendar::bfilesTable, "id=".Sift::$id);
if($filename){
@unlink('../'.FILES_DIR.'/' .$filename);
$result = $db->delete(Calendar::bfilesTable, "id='" . Sift::$id."'");}
	  
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = Sift::msgSuccess(Lang::$say->_FILES_FILEDELETED, false,4000,false,true);
		  $json['content'] = $cal->getAttachmentList($_POST['vmode']);	 
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
		  
	  endif;
	  print json_encode($json);
}

/* == Search Blocks == */
if (isset($_POST['blockSearch']) && $_POST['blockSearch']!='' && $_POST['auth']==genRequestKey('blockSearch')){
	  $result = $cal->renderSearchList($_POST['blockSearch']);
	  if($result) :
		  $json['status'] = 'success';
		  $json['message'] = '';
		  $json['content'] = $result;	  
	  else :
		  $json['status'] = 'warning';
		  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
		  
	  endif;
	  print json_encode($json);
}
   

}// //End if userlevel >5)

} // if login 

?>