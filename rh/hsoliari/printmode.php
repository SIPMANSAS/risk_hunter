<?php
define("_EXECPERMIT_WNV", true);
require_once ("start.php");
if(!$user->logged_in){redirect_to(SITEURL . "login/");}

if(!isset($_GET['do']) || !$_GET['do']){
$pageTitle = Lang::$say->_PRINT.' '.Lang::$say->_GNL_CALENDARS.' - '.$gist->pptname;
include("header-print.tpl.php");
?>
<div class="rowspan calheading yearly"><h1><?php echo Lang::$say->_GNL_CALENDARS ?></h1></div>
<div class="row">
    <div id="yearcalendar" class="cals panel_yearcalendar listpanel_bookingadd listpanel_bookingedit listpanel_bookingdel listpanel_bookinginfo panel_bookingdel">
      <?php $cal->renderCalendar();?>
    </div>
</div>
</div>
<!-- /container --> 
</body>
</html>
<?php } ?>

<?php if(isset($_GET['do']) && $_GET['do']=='blocks'){
if(Vault::get("Users")->userlevel<=9 && Vault::get("Users")->userlevel>6){	
$blocklist_title=Lang::$say->_BKG_BLKLIST;}else{$blocklist_title=Lang::$say->_BKG_MYBLKLIST;}
$pageTitle = Lang::$say->_PRINT.' '.$blocklist_title.' - '.$gist->pptname;
include("header-print.tpl.php");
?>
<h1><?php echo $blocklist_title ?><a class="float-right printbutton" href="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></h1>
<div class="rowspan"><div class="msg_bookingdel"></div></div>
<div class="rowspan">
    <div id="yearcalendar" class="blocklist panel_yearcalendar listpanel_bookingadd listpanel_bookingedit listpanel_bookingdel listpanel_bookinginfo panel_bookingdel">
<?php $cal->renderCalendar('list');?>
    </div>
</div>
</div>
<!-- /container --> 
</body>
</html>
<?php } ?>
<?php if(isset($_GET['do']) && $_GET['do']=='block'){ 
if(!isset($_GET['i'])){exit;}
if(!$cal->isCanViewDetails(Vault::get("niceIds")->restore(sanitize($_GET['i'])))){exit;}
$create = 0;
$pageTitle = Lang::$say->_BKG_BLKDETAILSPRINT.' - '.$gist->pptname;
include("header-print.tpl.php");
echo $cal->infoFormBlock(Vault::get("niceIds")->restore(sanitize($_GET['i'])),true);
?>
</div>
<!-- /container --> 
</body>
</html>
<?php } ?>
<?php if(isset($_GET['do']) && $_GET['do']=='blocks2csv' && isset($_GET['y']) && isset($_GET['p'])){
$cPropType=intval(restorePassId(sanitize($_GET['p'])));
$pptyname=getValueById('name', Vhrental::pptyTable, $cPropType);
      header("Pragma: no-cache");
	  header('Content-Type: text/csv; charset=utf-8');
	  header('Content-Disposition: attachment; filename=BookingBlocks-'.neatName($pptyname.'-'.$_GET['y'].'-'.Vault::get("Users")->username).'.csv');
	  
	  $data = fopen('php://output', 'w');
	  fputcsv($data, array(
'#',
Lang::$say->_PPT_TYPE,
Lang::$say->_BKG_CHKIND,
Lang::$say->_BKG_CCHKOUTD,
Lang::$say->_BKG_STATUS,
ucfirst(Lang::$say->_BKG_DAYS),
ucfirst(Lang::$say->_BKG_NIGHTS),
Lang::$say->_BKG_GUESTNAME,
Lang::$say->_BKG_GUESTADULT,
Lang::$say->_BKG_GUESTCHILD,
Lang::$say->_BKG_GUESTEMAIL,
Lang::$say->_BKG_GUESTPHONE,
Lang::$say->_BKG_GUESTCOUNTRY,
Lang::$say->_BKG_AMOUNT.' ('.Vault::get("Gist")->site_currsym.')',
Lang::$say->_BKG_DEPOSIT.' ('.Vault::get("Gist")->site_currsym.')',
Lang::$say->_BKG_BALANCEDUE.' ('.Vault::get("Gist")->site_currsym.')',
Lang::$say->_BKG_CREATEDON,
Lang::$say->_BKG_CREATEDBY,
Lang::$say->_BKG_LASTUPD,
Lang::$say->_BKG_UPDATEDBY,
Lang::$say->_FILES_ATTACHMENT,
Lang::$say->_BKG_NOTES));
	  
	  $result = $cal->blocksToCsv($_GET['y'],$cPropType);
	  if($result){
		  foreach ($result as $row) :
			  fputcsv($data, $row);
		  endforeach;
		  fclose($data);
	  }

} ?>