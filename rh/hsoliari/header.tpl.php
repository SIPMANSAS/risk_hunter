<?php
if (!defined("_EXECPERMIT_WNV"))
die('Direct access to this location is not allowed.');
if(!$user->logged_in){redirect_to(SITEURL . "login/");}
$gist->pptname = ($gist->pptname) ? $gist->pptname:Lang::$say->_PPT_YNAME;
?>
<!DOCTYPE html>
<html lang="<?php echo Vault::get("Lang")->currlang ?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $pageTitle ?></title>
<meta name="author" content="transinova.com">
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/app.css" rel="stylesheet">
<link href="assets/css/calendar.css" rel="stylesheet">
<link href="assets/css/datepicker.css" rel="stylesheet">
<?php if($gist->sysuicorners){ ?><link href="assets/css/sqcorners.css" rel="stylesheet"><?php } ?>
<link rel="shortcut icon" type="image/x-icon" href="assets/images/fav.ico" /><script type="text/javascript">var siteurl = "<?php echo SITEURL?>";
var cfgweekstart = "<?php echo $gist->weekstart?>";
var ljsDelConfirm = "<?php echo Lang::$say->_DEL_CONFIRM?>";
var ljsDelConfirmCk = "<?php echo Lang::$say->_DEL_CONFIRMCK?>";
var ljsDelNoConfirm = "<?php echo Lang::$say->_DEL_NOCONFIRM?>";
var ljsConfirm = "<?php echo Lang::$say->_CONFIRM?>";
var ljsYes = "<?php echo Lang::$say->_YES?>";
var ljsNo = "<?php echo Lang::$say->_NO?>";
var ljsCancel = "<?php echo Lang::$say->_CANCEL?>";
var ljsDelete = "<?php echo Lang::$say->_DELETE?>";
var ljsChkin = "<?php echo Lang::$say->_BKG_CHKIND?>";
var ljsChkout = "<?php echo Lang::$say->_BKG_CCHKOUTD?>";
var ljsBooked = "<?php echo Lang::$say->_BKG_BOOKED?>";
var ljsAvailable = "<?php echo Lang::$say->_BKG_AVAIL?>";
var ljsNavailable = "<?php echo Lang::$say->_BKG_NAVAIL?>";
var ljsChKeyConfirm = "<?php echo Lang::$say->_UR_RKEYCONFIRM?>";
var ljsCopiedToClipbrd = "<?php echo Lang::$say->_GNL_COPIEDTOCBD?>";
var ljsClear = "<?php echo Lang::$say->_CLEAR?>";
var ljsClose = "<?php echo Lang::$say->_CLOSE?>";
var ljsToday = "<?php echo Lang::$say->_TODAY?>";
var ljsWorking = "<?php echo Lang::$say->_WORKINGDOT?>";
var jsmonthsFull = <?php echo jsDateMonthNames('mf')?>;
var jsmonthsShort = <?php echo jsDateMonthNames('ms')?>;
var jsdaysFull = <?php echo jsDateMonthNames('df')?>;
var jsdaysShort = <?php echo jsDateMonthNames('ds')?>;
<?php echo Vault::get("Vhrental")->getBlockStatJsVars();?>
</script>
<script src="assets/js/jquery.min.js"></script> 
<script src="assets/js/jquery-ui.min.js"></script> 
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/calnav.js"></script>
<!--[if lt IE 9]>
      <script src=assets/js/html5shiv.min.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- Fixed navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top calapp">
  <div class="container">
<a class="navbar-brand" href="index2.php"><img src="<?php echo SITEURL."assets/images/logo.png"?>" alt="<?php echo $gist->pptname ?>"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>    

    <div id="navbar" class="navbar-collapse collapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item"><a class="nav-link" href="home.php"><?php echo Lang::$say->_GNL_CALENDARS;?></a></li>
<?php 
if($cal->isCanCreateBlock()){
if(Vault::get("Users")->userlevel<=9 && Vault::get("Users")->userlevel>6){	
$blocklist_menu=Lang::$say->_BKG_BLKLIST;}else{$blocklist_menu=Lang::$say->_BKG_MYBLKLIST;}
?>        
<li class="nav-item"><a class="nav-link" href="blocklist.php"><?php echo $blocklist_menu;?></a></li>
        
<?php
}
if($user->isSuperAdmin()){
?>        
        <li class="nav-item dropdown"><a href="javascript:void(0);" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo Lang::$say->_UR_USERS;?> <span class="caret"></span></a>
          <div class="dropdown-menu">
<a class="dropdown-item" href="users.php"><?php echo Lang::$say->_UR_USERS;?></a>
<a class="dropdown-item" href="users.php?do=assign"><?php echo Lang::$say->_UR_ASSIGNMENT;?></a>        
          </div>        
        </li>
        <li class="nav-item dropdown"><a href="javascript:void(0);" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo Lang::$say->_GNL_SETTINGS;?> <span class="caret"></span></a>
          <div class="dropdown-menu">
<a class="dropdown-item" href="settings.php"><?php echo Lang::$say->_GNL_SETTINGS;?></a>
<a class="dropdown-item" href="settings.php?do=language"><?php echo Lang::$say->_LANGUAGES;?></a>       
          </div>        
        </li>
<?php 
}
?>      
      </ul>
      <ul class="nav navbar-nav navbar-right">
<?php 
if($cal->isCanCreateBlock()){
?>        
<li class="nav-item"><a class="nav-link" href="blocklist.php?do=search"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <?php echo Lang::$say->_SEARCH;?></a></li>
<?php }?>  
<li class="nav-item dropdown"><a href="javascript:void(0);" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $user->username ?> <span class="caret"></span></a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="account.php"><?php echo Lang::$say->_UA_UPDATE;?></a>
            <a class="dropdown-item" href="account.php?do=links"><?php echo Lang::$say->_LINKS;?></a>
            <div class="dropdown-divider"></div>
            <?php if($gist->showpubliccal){ ?>            
            <a class="dropdown-item" href="./" target="_blank"><?php echo Lang::$say->_GNL_VIEWPUBLICCAL;?></a>
            <div class="dropdown-divider"></div>
            <?php } ?>
            <a class="dropdown-item" href="login/?logout=true"><?php echo Lang::$say->_LOGOUT;?></a>
          </div>
        </li>
<li class="nav-item dropdown"><a href="javascript:void(0);" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> <?php echo Vault::get("Lang")->currlang ?> <span class="caret"></span></a>
          <div class="dropdown-menu dropdown-menu-right">
<?php print $gist->getLanguageMenu(); ?>          
          </div>
        </li>                  
      </ul>
    </div>
    <!--/.nav-collapse --> 
  </div>
</nav>
<div class="container">
