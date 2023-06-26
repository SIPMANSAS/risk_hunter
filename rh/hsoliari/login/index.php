<?php
define("_EXECPERMIT_WNV", true);
require_once ("../start.php");

if(isset($_GET['logout'])){
if($_GET['logout']=='true'){
  if ($user->logged_in)
      $user->logout();
  redirect_to(SITEURL.'login/');
}
if($_GET['logout']=='public'){
  $qrstr='';
  if ($user->logged_in)
      $user->logout();
	  if($_SERVER['QUERY_STRING']){
	  $qrstr = $_SERVER['QUERY_STRING'];
	  $qrstr = htmlspecialchars_decode($qrstr);
	  $qrstr = str_replace('logout=public&','',$qrstr);
	  $qrstr = '?'.$qrstr;
	  }
  redirect_to(SITEURL.$qrstr);
}
}
	
if ($user->logged_in){redirect_to(SITEURL . "index2.php");}


if (isset($_POST['postlogin'])){
  $result = $user->login(sanitize($_POST['username']), sanitize($_POST['password']));
  if ($result){redirect_to(SITEURL . "index2.php");}
}
if (isset($_GET['postlogin'])){
  $result = $user->login(sanitize($_GET['username']), sanitize($_GET['password']));
  if ($result){redirect_to(SITEURL . "index2.php");}
}
$gist->pptname = ($gist->pptname) ? $gist->pptname:Lang::$say->_PPT_YNAME;
?>
<!DOCTYPE html>
<html lang="<?php echo Vault::get("Lang")->currlang ?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo Lang::$say->_UA_LOGIN?></title>
<meta name="author" content="transinova.com">
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/app.css" rel="stylesheet">
<?php if($gist->sysuicorners){ ?><link href="../assets/css/sqcorners.css" rel="stylesheet"><?php } ?>
<link rel="shortcut icon" type="image/x-icon" href="../assets/images/fav.ico" />
<script type="text/javascript">var siteurl = "<?php echo SITEURL?>";
</script>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/jquery-ui.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/plugins.js"></script>
<script src="../assets/js/access.js"></script>
<!--[if lt IE 9]>
      <script src=../assets/js/html5shiv.min.js"></script>
      <script src="../assets/js/respond.min.js"></script>
    <![endif]-->
<?php if(defined('CFG_EUCOOKIES') && CFG_EUCOOKIES):?>
<script type="text/javascript" src="../assets/js/eucookies.js"></script>
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

<body class="loginpage">
<div class="container">
  <div class="rowspan">
    <div class="col-sm-12 col-sm-10 col-md-8 col-lg-4 mx-auto">
<div class="card">
  <div class="card-body">    
      <div class="rowspan">
      <div class="row langtool">
<div class="col-xs-4 mx-auto">      
<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
  <?php if(isset($_COOKIE['LANGUAGE_VRBC'])){echo ($_COOKIE['LANGUAGE_VRBC']);}else{echo ($gist->lang);}?>
  <span class="caret"></span> </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <?php print $gist->getLanguageMenu(); ?>
  </ul>
	</div>    
    </div>
    </div>
    <div class="rowspan">  
        <form method="post" enctype="multipart/form-data" class="form-signin">
          <input name="postlogin" type="hidden" value="1">
          <div class="logo"><img src="<?php echo SITEURL."assets/images/logo.png"?>" alt="<?php echo $gist->pptname ?>">
          <h2><?php echo $gist->pptname ?></h2>
          </div>
          <label for="username" class="sr-only"><?php echo Lang::$say->_UR_EMAIL?></label>
          <input name="username" type="text" autofocus required class="form-control form-control-lg logtop" placeholder="<?php echo Lang::$say->_UR_EMAILORUSR?>" maxlength="60">
          <label for="inputPassword" class="sr-only"><?php echo Lang::$say->_UR_PASSWORD?></label>
          <input type="password" name="password" class="form-control form-control-lg logbott" placeholder="<?php echo Lang::$say->_UR_PASSWORD?>" required>
          <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo Lang::$say->_UA_LOGIN ?></button>
        </form>
        </div>
      </div>
      <div class="rowspan">
        <div class="loginmessage"><?php print Sift::$showMsg;?></div>
      </div>
      <div class="rowspan access-footer"> <a href="accesshelp.php"><?php echo Lang::$say->_UR_PASSWORDFG?>?</a><?php if($gist->showpubliccal){?><a class="float-right" href="../"><?php echo Lang::$say->_GNL_PUBLICVIEWCAL?></a><?php }?> </div>
      </div>
      </div>
    </div>
  </div>
</div>
<!-- /container -->
</body>
</html>
