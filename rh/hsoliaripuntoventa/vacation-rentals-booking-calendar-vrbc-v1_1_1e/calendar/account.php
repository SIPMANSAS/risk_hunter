<?php
define("_EXECPERMIT_WNV", true);
require_once ("start.php");
if(!$user->logged_in){redirect_to(SITEURL . "login/");}
if(!isset($_GET['do']) || !$_GET['do']){$pageTitle = Lang::$say->_UA_UPDATEPROFILE.' - '.$gist->pptname;}
if(isset($_GET['do']) && $_GET['do']=='links'){$pageTitle = Lang::$say->_LINKS.' - '.$gist->pptname;}
include("header.tpl.php");
$row = $user->getUserInfo($user->username);
?>
<?php if(!isset($_GET['do']) || !$_GET['do']){
?>

<h1><?php echo Lang::$say->_UA_UPDATE ?></h1>
<div class="card panel-default">
  <div class="card-header">
    <h3 class="card-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo Lang::$say->_UA_UPDATEPROFILE ?></h3>
  </div>
  <div class="card-body" id="panel_userupdate">
    <div class="container-fluid">
      <form class="form" id="form_userupdate">
        <div class="row">
          <div class="col-sm-3">
            <div class="form-group">
              <label for="fname"><?php echo Lang::$say->_UR_FULLNAME ?></label>
              <input type="text" class="form-control" name="fname"  value="<?php echo $row->fname ?>">
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label for="fullnameview"><?php echo Lang::$say->_UR_EMAIL ?></label>
              <input <?php if($user->userlevel!=9){echo 'disabled';}?> type="text" class="form-control" name="fullnameview"  value="<?php echo $row->email ?>">
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label for="usernameview"><?php echo Lang::$say->_UR_USRNAME ?></label>
              <?php if($user->userlevel!=9){$usernamev=' disabled';}else{$usernamev='';}?>
              <input<?php echo $usernamev ?> type="text" class="form-control" name="usernameview"  value="<?php echo $row->username ?>">
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label style="width:100%" for="userlevelnameview"><?php echo Lang::$say->_UR_UROLE ?></label>
              <input disabled type="text" class="form-control" name="userlevelnameview"  value="<?php echo $user->userLevelName($row->userlevel) ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="company"><?php echo Lang::$say->_UR_COMNAME ?></label>
              <input type="text" class="form-control" name="company" value="<?php echo $row->company ?>">
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group">
              <label for="caddress"><?php echo Lang::$say->_UR_COMADDR ?></label>
              <input type="text" class="form-control" name="caddress" value="<?php echo $row->caddress ?>">
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label for="caddress"><?php echo Lang::$say->_UR_COMPHONE ?></label>
              <input type="text" class="form-control" name="cphone" value="<?php echo $row->cphone ?>">
            </div>
          </div>
        </div>
        <hr class="slim">
        <div class="row">
          <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
            <div class="form-group">
              <input type="hidden" name="saveProfile" value="<?php echo genRequestKey('saveProfile'.$row->id);?>">
              <button id="save_userupdate" data-after="none" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?php echo Lang::$say->_SAVE;?></button>
            </div>
          </div>
        </div>
      </form>
      <div id="msg_userupdate"></div>
    </div>
  </div>
</div>
<div class="card panel-default">
  <div class="card-header">
    <h3 class="card-title"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> <?php echo Lang::$say->_UR_PASSWORDCHG ?></h3>
  </div>
  <div class="card-body" id="panel_passupdate">
    <div class="container-fluid">
      <form class="form" id="form_passupdate">
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="currpassword"><?php echo Lang::$say->_UR_PASSWORDNOW ?></label>
              <input type="password" class="form-control" name="currpassword" autocomplete="off" autocorrect="off">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="newpassword"><?php echo Lang::$say->_UR_PASSWORDNEW ?></label>
              <input type="password" class="form-control" name="newpassword" autocomplete="off" autocorrect="off">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="confnewpassword"><?php echo Lang::$say->_UR_PASSWORDCNFCHG ?></label>
              <input type="password" class="form-control" name="confnewpassword" autocomplete="off" autocorrect="off">
            </div>
          </div>
        </div>
        <hr class="slim">
        <div class="row">
          <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
            <div class="form-group">
              <input type="hidden" name="updatePassword" value="<?php echo genRequestKey($row->id.'updatePassword');?>">
              <button id="save_passupdate" data-after="hide" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?php echo Lang::$say->_UR_PASSWORDCHG;?></button>
            </div>
          </div>
        </div>
      </form>
      <div id="msg_passupdate"></div>
    </div>
  </div>
</div>
<?php } ?>
<?php if(isset($_GET['do']) && $_GET['do']=='links'){
?>
<h1><?php echo Lang::$say->_LINKS ?></h1>
<?php if(Vault::get("Vhrental")->anyAssigned()){ ?>
<?php if($user->userlevel<=9 && $user->userlevel>=4){ ?>
<div class="card panel-default">
  <div class="card-header">
    <h3 class="card-title"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> <?php echo Lang::$say->_BKG_EXPCAL ?></h3>
  </div>
  <div class="card-body panel_feedlinks panel_calexplinks listpanelexp_feedlinks">
<?php echo Vault::get("Vhrental")->exportLinks();?>
  </div>
</div>
<?php } ?>
<?php if($user->userlevel<=9 && $user->userlevel>=4){ ?>
<div class="card panel-default">
  <div class="card-header">
    <h3 class="card-title"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> <?php echo Lang::$say->_GNL_PCV_URL ?></h3>
  </div>
  <div class="card-body panel_feedlinks panel_publiclinks panelplnk_feedlinks listpanelplnk_feedlinks">
  <div class="msg_publiclinks"></div>
<?php if(Vault::get("Gist")->showpubliccal){?>    
         <?php echo Vault::get("Vhrental")->publicLinks();?>
<?php } else {  ?>
<div class="alert alert-warning" role="alert">
  <div class="content">
    <div class="header"><?php echo Lang::$say->_ALERT ?></div>
    <p><?php echo Lang::$say->_GNL_PCV_DISABLED ?></p>
  </div>
</div>
<?php } ?>
  </div>  
</div>
<?php } ?>
<div class="card panel-default">
  <div class="card-header">
    <h3 class="card-title"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> <?php echo Lang::$say->_BKG_FEEDAVAILABILITY ?></h3>
  </div>
  <div class="card-body panel_feedlinks panel_calfeedlinks listpanel_feedlinks">
<?php echo Vault::get("Vhrental")->feedLinks();?>    
  </div>
</div>

<?php } else {  ?>
<div class="alert alert-warning" role="alert">
  <div class="content">
    <div class="header"><?php echo Lang::$say->_ALERT ?></div>
    <p><?php echo Lang::$say->_PPT_TYPESNOASGN ?></p>
  </div>
</div>
<?php } ?>
<script src="assets/js/links.js"></script>
<?php }?>
<?php include("footer.tpl.php");?>