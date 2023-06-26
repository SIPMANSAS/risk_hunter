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
<link href="assets/css/print.css" rel="stylesheet" media="all">
<?php if($gist->sysuicorners){ ?><link href="assets/css/sqcorners.css" rel="stylesheet"><?php } ?>
<link rel="shortcut icon" type="image/x-icon" href="assets/images/fav.ico" />
<script type="text/javascript">var siteurl = "<?php echo SITEURL?>";
</script>
<script src="assets/js/jquery.min.js"></script> 
<script src="assets/js/jquery-ui.min.js"></script> 
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/calnavprint.js"></script>
<!--[if lt IE 9]>
      <script src=assets/js/html5shiv.min.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">