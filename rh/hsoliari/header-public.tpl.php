<?php
if (!defined("_EXECPERMIT_WNV"))
die('Direct access to this location is not allowed.');
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
<?php if($gist->sysuicorners){ ?><link href="assets/css/sqcorners.css" rel="stylesheet"><?php } ?>
<link rel="shortcut icon" type="image/x-icon" href="assets/images/fav.ico" />
<script type="text/javascript">var siteurl = "<?php echo SITEURL?>";
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
<script src="assets/js/calnav.js"></script>
<!--[if lt IE 9]>
      <script src=assets/js/html5shiv.min.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
<?php if(defined('CFG_EUCOOKIES') && CFG_EUCOOKIES):?>
<script type="text/javascript" src="assets/js/eucookies.js"></script>
<script type="text/javascript"> 
$(document).ready(function () {
    $("body").acceptCookies({
        position: 'top',
        notice: '<?php echo Lang::$say->_EUC_INFO;?>',
        accept: '<?php echo Lang::$say->_EUC_ACCEPT;?>'
    })
});
</script>
<?php endif;?>
</head>
<body class="nonavbar">
<?php if($user->logged_in){?>
<div class="loggedin-bar" style="display:none;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="d-none d-sm-none d-md-inline-block"><?php echo Lang::$say->_GNL_PCV_LOGGEDIN;?> </span> <?php echo $user->username ?> <a href="<?php echo SITEURL?>home.php"><?php echo Lang::$say->_HOME;?></a> <a href="javascript:void(0);" class="logoutpublic"><?php echo Lang::$say->_LOGOUT;?></a></div>
<?php }?>
<div class="container">