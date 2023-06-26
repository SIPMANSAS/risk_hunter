<?php
define("_EXECPERMIT_WNV", true);
require_once ("start.php");
if(!$user->logged_in){redirect_to(SITEURL . "login/");}
?>
<?php if(!isset($_GET['do']) || !$_GET['do']){
if(Vault::get("Users")->userlevel<=9 && Vault::get("Users")->userlevel>6){	
$blocklist_title=Lang::$say->_BKG_BLKLIST;}else{$blocklist_title=Lang::$say->_BKG_MYBLKLIST;}
$pageTitle = $blocklist_title.' - '.$gist->pptname;
include("header.tpl.php");
if(!$cal->isCanCreateBlock()){print Sift::msgWarning(Lang::$say->_LG_ONLYSUAPADMIN); return;}
?>
<h1><?php echo $blocklist_title ?><a target="_blank" class="float-right printmodebutton" href="printmode.php?do=blocks"><span class="glyphicon glyphicon-print"></span></a></h1>
<div class="rowspan"><div class="msg_bookingdel"></div></div>
<div class="rowspan">
    <div id="yearcalendar" class="blocklist panel_yearcalendar listpanel_bookingadd listpanel_bookingedit listpanel_bookingdel listpanel_bookinginfo panel_bookingdel">
<?php $cal->renderCalendar('list');?>
    </div>
</div>
<?php } ?>
<?php if(isset($_GET['do']) && $_GET['do']=='search'){
if(Vault::get("Users")->userlevel<=9 && Vault::get("Users")->userlevel>6){	
$blocklist_title=Lang::$say->_SEARCH.' '.Lang::$say->_BKG_BLKLIST;}else{$blocklist_title=Lang::$say->_SEARCH.' '.Lang::$say->_BKG_MYBLKLIST;}
$pageTitle = $blocklist_title.' - '.$gist->pptname;
include("header.tpl.php");
if(!$cal->isCanCreateBlock()){print Sift::msgWarning(Lang::$say->_LG_ONLYSUAPADMIN); return;}	
?>
<h1><?php echo Lang::$say->_SEARCH ?></h1>
<div class="rowspan">
<div class="card panel-default">
  <div class="card-body" id="panel_blocksearch">
    <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 mx-auto">
            <div class="form-group">
              <label for="searchterm"><?php echo Lang::$say->_BKG_SCINSTRUCT ?></label>
              <input data-auth="<?php echo genRequestKey('blockSearch')?>" id="searchterm" name="searchterm" type="text" class="form-control form-control-lg" maxlength="50">
            </div>
          </div>
          </div>
    </div>
  </div>
</div>
</div>
<div class="rowspan"><div class="msg_bookingdel"></div></div>
<div class="rowspan searchresult">
    <div id="yearcalendar" class="blocklist panel_yearcalendar listpanel_bookingadd listpanel_bookingedit listpanel_bookingdel listpanel_bookinginfo panel_bookingdel">

    </div>
</div>

<?php } ?>
<?php $cal->modalBlockForms();?>
<?php include("footer.tpl.php");?>