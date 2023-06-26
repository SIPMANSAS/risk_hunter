<?php
define("_EXECPERMIT_WNV", true);
require_once ("../start.php");
	
if($user->logged_in){redirect_to(SITEURL . "home.php");}
$create = 0;
$pagetitle = Lang::$say->_UR_PASSWORDFG;

if(isset($_GET['c']) && isset($_GET['e'])){
$pagetitle = Lang::$say->_UR_PASSWORDCHG;
if($user->passResetRequestExists(sanitize($_GET['c']),sanitize($_GET['e']))){$create = 1;}else{$create = 2;}
}

?>
<!DOCTYPE html>
<html lang="<?php echo Vault::get("Lang")->currlang ?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $pagetitle ?></title>
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
</head>
<body class="loginpage">
<div class="container">
  <div class="row">
    <div class="col-sm-12 col-sm-10 col-md-8 col-lg-4 mx-auto">
<div class="card">
  <div class="card-body">      
      <?php if($create==1){?>
      <div class="rowspan" id="panel_passreset">
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
        <form method="post" enctype="multipart/form-data" class="form-signin" id="form_passreset">
          <h2><?php echo Lang::$say->_UR_PASSWORDCHG?></h2>
          <div class="form-group">
            <p align="justify"><?php echo Lang::$say->_UR_PASSCREATEINST;?></p>
            <label for="regemail" class="sr-only"><?php echo Lang::$say->_UR_EMAIL?></label>
            <input name="newpassword" type="password" autofocus required class="form-control logtop" placeholder="<?php echo Lang::$say->_UR_PASSWORDNEW?>" maxlength="60">
            <input name="confnewpassword" type="password" autofocus required class="form-control logbott" placeholder="<?php echo Lang::$say->_UR_PASSWORDCNF?>" maxlength="60">
          </div>
          <input name="eval" type="hidden" value="<?php echo sanitize($_GET['e'])?>">
          <input name="code" type="hidden" value="<?php echo sanitize($_GET['c'])?>">
          <input name="passResetCreate" type="hidden" value="<?php echo genRequestKey('passResetCreate')?>">
          <button id="save_passreset" class="btn btn-lg btn-primary btn-block" type="submit" name="passreset" data-after="hide"><?php echo Lang::$say->_UR_PASSWORDCRT ?></button>
        </form>
        </div>
        <div class="row">
          <div class="loginmessage"></div>
        </div>
        <div id="msg_passreset"></div>
      </div>
      <?php } elseif($create==2){ 
echo Sift::msgWarning(Lang::$say->_UA_PASS_R_INV.' <a href="accesshelp.php">'.Lang::$say->_UR_PASSWORDFG.'</a>',false,false,false,false);	
	} else {?>
      <div class="rowspan" id="panel_passreset">
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
        <form method="post" enctype="multipart/form-data" class="form-signin" id="form_passreset">
          <h2 class="form-signin-heading"><?php echo Lang::$say->_UR_PASSWORDFG?></h2>
          <div class="form-group">
            <p align="justify"><?php echo Lang::$say->_UR_PASSRESINST;?></p>
            <label for="regemail" class="sr-only"><?php echo Lang::$say->_UR_EMAIL?></label>
            <input name="regemail" type="text" autofocus required class="form-control" placeholder="<?php echo Lang::$say->_UR_EMAIL?>" maxlength="60">
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-5"><img class="catchaimg" src="../captcha.php" alt=""></div>
              <div class="col-sm-7">
                <input name="captcha" type="text" required class="form-control" placeholder="<?php echo Lang::$say->_UA_PASS_RCAPT?>" maxlength="5">
              </div>
            </div>
          </div>
          <input name="passwordReset" type="hidden" value="<?php echo genRequestKey('passwordReset')?>">
          <button id="save_passreset" class="btn btn-lg btn-secondary btn-block" type="submit" name="passreset" data-after="hide"><?php echo Lang::$say->_UA_PASS_RSUBMIT ?></button>
        </form>
        </div>
        <div class="row">
          <div class="loginmessage"></div>
        </div>
        <div id="msg_passreset"></div>
      </div>
      <div class="rowspan access-footer"> <a href="../login/"><?php echo Lang::$say->_UA_LOGINNOW?></a> </div>
      <?php } ?>
    </div>
    </div>
    </div>
  </div>
</div>
<!-- /container -->
</body>
</html>