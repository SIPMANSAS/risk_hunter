<?php
  /**
   * Index
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: index.php, v1.1.0 Feb 2018 transinova $
   */
define("_EXECPERMIT_WNV", true);
require_once ("start.php");
$cPropType=false;
$cWarning=false;
$cMonth=false;
$cYear=false;
$cMonths=false;
if(isset($_GET['p'])){
	$cPropType=restorePassId(sanitize($_GET['p']));
	$psview=$cPropType;
	$rowpt = Vault::get("Vhrental")->propertyTypeIdPubview($cPropType);
	if(!$rowpt){$cWarning .=Lang::$say->_PPT_TYPE_NFOUND.'<br />';}
} else{
	if($gist->publiccalurlonly){
		$cWarning .=Lang::$say->_GNL_PCV_PERPTVURLREQ.'<br />';
	}
}
if(isset($_GET['m'])){
	if(ctype_digit($_GET['m']) && $_GET['m']>0 && $_GET['m']<13){
		$cMonth=intval(sanitize($_GET['m']));
	}else{
		$cMonth=false; $cWarning .=Lang::$say->_GNL_PCV_URLMON_R.'<br />';
		}
	}
if(isset($_GET['y'])){
    if($cal->checkYear($_GET['y']) && $_GET['y']>1970){
		$cYear=intval(sanitize($_GET['y']));
	}else{
		$cYear=false; $cWarning .=Lang::$say->_GNL_PCV_URLYEAR_R.'<br />';
		}
}
if(isset($_GET['c'])){
    if(ctype_digit($_GET['c']) && ($_GET['c']==1 || $_GET['c']==2 || $_GET['c']==3 || $_GET['c']==4 || $_GET['c']==12)){
		$cMonths=intval(sanitize($_GET['c']));
	}else{
		$cMonths=false; $cWarning .=Lang::$say->_GNL_PCV_URLCNUM_R.'<br />';
		}
}

$pageTitle = Lang::$say->_GNL_CALENDARS.' - '.$gist->pptname;
include("header-public.tpl.php");		

?>
<div class="row"><div class="col-12">
<div class="pvlang"><div class="dropdown float-right">
<div class="btn-group">
  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
  <?php if(isset($_COOKIE['LANGUAGE_VRBC'])){echo ($_COOKIE['LANGUAGE_VRBC']);}else{echo ($gist->lang);}?>
  <span class="caret"></span>
  </button>
  <ul class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenu1">
    <?php print $gist->getLanguageMenu(); ?>
  </ul>
</div>

	</div>
	</div></div>
</div>   
<div class="rowspan calheading monthly"><h1><?php echo $gist->pptname ?></h1></div>
<div class="row monthly">
<?php if($gist->showpubliccal){ ?>
  <div id="yearcalendar" class="panel_yearcalendar">
    <?php
	if(!$cWarning){ 
	if(isset($_GET['p'])){
		if($rowpt){$cal->renderCalendarM(false,$cMonth,$cYear,$cPropType,$psview,$cMonths);}
		}else{
			if(!$gist->publiccalurlonly){$cal->renderCalendarM(false,$cMonth,$cYear,false,false,$cMonths);}
			}
	}else{echo Sift::msgWarning($cWarning, false,false,false,false);	}
	?>
  </div>
<?php
}else{
echo Sift::msgWarning(Lang::$say->_GNL_PCV_DISABLED, false,false,false,false);
}
?>
</div>
</div>
<!-- /container -->
<div class="clearfix"></div>
</body></html>