<?php
define("_EXECPERMIT_WNV", true);
require_once ("start.php");
if(!$user->logged_in){redirect_to(SITEURL . "login/");}
$pageTitle = Lang::$say->_GNL_SETTINGS.' - '.$gist->pptname;
if(isset($_GET['do']) && ($_GET['do']=='language' || $_GET['do']=='langphrases')){$pageTitle = Lang::$say->_LANGUAGES.' - '.$gist->pptname;}
include("header.tpl.php");
//if(!$user->isSuperAdmin()){print Sift::msgWarning(Lang::$say->_LG_ONLYSUAPADMIN); return;}
?>
<?php if(!isset($_GET['do']) || !$_GET['do']){
?>

<h1><?php echo Lang::$say->_GNL_SETTINGS?></h1>
<div class="card panel-default">
<div class="card-header"><h3 class="card-title"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> <?php echo Lang::$say->_GNL_SYSSETTINGS ?></h3></div>
  <div class="card-body" id="panel_pptconfig">
    <form class="form" id="form_pptconfig">
      <div class="row">
        <div class="col-sm-12">
          <label class="bolder margin-bottom-20"><?php echo Lang::$say->_PPT_DETAILS ?></label>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-10">
          <div class="form-group">
            <label for="propertyname"><?php echo Lang::$say->_PPT_NAME ?></label>
            <input type="text" class="form-control" name="propertyname" value="<?php echo $gist->pptname ?>">
          </div>
        </div>
        <div class="col-sm-2">
          <label class="hidden-xs">&nbsp;</label>
          <div class="form-group">
            <label class="checkbox-inline">
              <input name="propertylock" type="checkbox" value="1"<?php getChecked($gist->pptlock, '1')?>>
              <i></i><?php echo Lang::$say->_LOCK ?></label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="propertyaddress"><?php echo Lang::$say->_PPT_ADDR ?></label>
            <input type="text" class="form-control" name="propertyaddress" value="<?php echo $gist->pptaddress ?>">
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label for="propertyphone"><?php echo Lang::$say->_PPT_PHONE ?></label>
            <input type="text" class="form-control" name="propertyphone" value="<?php echo $gist->pptphone ?>">
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label for="propertyemail"><?php echo Lang::$say->_PPT_EMAIL ?></label>
            <input type="text" class="form-control" name="propertyemail" value="<?php echo $gist->pptemail ?>">
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <label class="bolder margin-bottom-20"><?php echo Lang::$say->_GNL_SYSOPTS ?></label>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            <label for="sysdeflanguage"><?php echo Lang::$say->_DEFLANGUAGES ?></label>
            <div class="form-group">
              <select class="form-control custom-select" name="sysdeflanguage">
                <?php print $gist->getLanguageSelect(); ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <label for="sysuicorners"><?php echo Lang::$say->_UIOPTIONS ?></label>
          <div class="form-group">
            <label class="checkbox-inline">
              <input name="sysuicorners" type="checkbox" value="1"<?php getChecked($gist->sysuicorners, '1')?>>
              <i></i><?php echo Lang::$say->_UICORNERS ?> </label>
          </div>
        </div>
        <div class="col-sm-5">
          <label for="notification"><?php echo Lang::$say->_GNL_NOTIFYWHEN ?></label>
          <div class="form-group">
            <label class="checkbox-inline">
              <input name="notifyoncreate" type="checkbox" value="1"<?php getChecked($gist->notifyoncreate, '1')?>>
              <i></i><?php echo Lang::$say->_GNL_BLOCKCREATE ?> </label>
            <label class="checkbox-inline">
              <input name="notifyonupdate" type="checkbox" value="1"<?php getChecked($gist->notifyonupdate, '1')?>>
              <i></i><?php echo Lang::$say->_GNL_BLOCKUPDATE ?> </label>
            <label class="checkbox-inline">
              <input name="notifyondelete" type="checkbox" value="1"<?php getChecked($gist->notifyondelete, '1')?>>
              <i></i><?php echo Lang::$say->_GNL_BLOCKDELETE ?> </label>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <label class="bolder margin-bottom-20"><?php echo Lang::$say->_GNL_PUBLICVECALOPTS ?></label>
        </div>
        <div class="col-sm-4">
          <label for="showpubliccal"><?php echo Lang::$say->_GNL_PUBLICVECAL ?></label>
          <div class="form-group">
            <label class="checkbox-inline">
              <input name="showpubliccal" type="checkbox" value="1"<?php getChecked($gist->showpubliccal, '1')?>>
              <i></i><?php echo Lang::$say->_GNL_ENBPUBLICCAL ?> </label>
          </div>
        </div>
        <div class="col-sm-4">
          <label for="publiccalurlonly"><?php echo Lang::$say->_GNL_PCV_PERPTVIEW ?></label>
          <div class="form-group">
            <label class="checkbox-inline">
              <input name="publiccalurlonly" type="checkbox" value="1"<?php getChecked($gist->publiccalurlonly, '1')?>>
              <i></i><?php echo Lang::$say->_GNL_PCV_PERPTVURLONLY ?> </label>
          </div>
        </div>
        <div class="col-sm-3">
          <label for="publiccalview"><?php echo Lang::$say->_GNL_PUBLICCALVIEW ?></label>
          <div class="form-group">
            <select class="form-control custom-select" name="publiccalview">
              <option value="12" <?php if(!$gist->publiccalview || $gist->publiccalview=='12'){echo " selected=\"selected\" ";} ?>><?php echo Lang::$say->_GNL_PCV_ONEYEAR ?></option>
              <option value="4" <?php getSelected($gist->publiccalview, '4') ?>><?php echo Lang::$say->_GNL_PCV_FOURMON ?></option>
              <option value="3" <?php getSelected($gist->publiccalview, '3') ?>><?php echo Lang::$say->_GNL_PCV_THREEMON ?></option>
              <option value="2" <?php getSelected($gist->publiccalview, '2') ?>><?php echo Lang::$say->_GNL_PCV_TWOMON ?></option>
              <option value="1" <?php getSelected($gist->publiccalview, '1') ?>><?php echo Lang::$say->_GNL_PCV_ONEMON ?></option>
            </select>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <label class="bolder" for="notification"><?php echo Lang::$say->_BKG_EXPCALOPTS ?></label>
          <p><?php echo Lang::$say->_BKG_EXPADDINFO ?>:</p>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label class="checkbox-inline">
              <input name="expinfostatus" value="1" type="checkbox"<?php getChecked($gist->expinfostatus, '1')?>>
              <i></i><?php echo Lang::$say->_PPT_BLOCKSTATUS ?> </label>
            <label class="checkbox-inline">
              <input name="expinfoguestname" value="1" type="checkbox"<?php getChecked($gist->expinfoguestname, '1')?>>
              <i></i><?php echo Lang::$say->_BKG_GUESTNAME ?> </label>
            <label class="checkbox-inline">
              <input name="expinfoguestnum" value="1" type="checkbox"<?php getChecked($gist->expinfoguestnum, '1')?>>
              <i></i><?php echo Lang::$say->_BKG_GUESTNUM ?> </label>
            <label class="checkbox-inline">
              <input name="expinfoguestcountry" value="1" type="checkbox"<?php getChecked($gist->expinfoguestcountry, '1')?>>
              <i></i><?php echo Lang::$say->_BKG_GUESTCOUNTRY ?> </label>
            <label class="checkbox-inline">
              <input name="expinforemarks" value="1" type="checkbox"<?php getChecked($gist->expinforemarks, '1')?>>
              <i></i><?php echo Lang::$say->_BKG_NOTES ?> </label>
            <label class="checkbox-inline">
              <input name="expinfopptaddress" value="1" type="checkbox"<?php getChecked($gist->expinfopptaddress, '1')?>>
              <i></i><?php echo Lang::$say->_PPT_ADDRESS ?> </label>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
          <div class="form-group">
            <input type="hidden" name="savePropertyConfig" value="<?php echo genRequestKey('savePropertyConfig');?>">
            <button id="save_pptconfig" data-after="none" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?php echo Lang::$say->_SAVE;?></button>
          </div>
        </div>
      </div>
    </form>
    <div id="msg_pptconfig"></div>
  </div>
</div>
<div class="clearfix"></div>
<div class="card panel-default">
  <div class="card-header"><h3 class="card-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <?php echo Lang::$say->_PPT_TYPES ?></h3></div>
  <div class="card-body panel_ppttypeadd panel_ppttypeedit panel_ppttypedel">
    <div class="row">
      <div class="col-lg-12"> <a class="btn btn-default float-right" id="showmodaldlg_ppttypeadd" href="javascript:void(0);"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo Lang::$say->_PPT_ADDTYPE ?></a></div>
    </div>
    <div class="clearfix"><br />
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="msg_ppttypeadd msg_ppttypeedit msg_ppttypedel"></div>
        <div class="listpanel_ppttypeadd listpanel_ppttypeedit listpanel_ppttypedel"> <?php echo $vhr->getTypeList()?> </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modaldlg_ppttypeadd" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">       
        <h5 class="modal-title"><span class="glyphicon glyphicon-plus"></span> <?php echo Lang::$say->_PPT_ADDTYPE ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>        
        </div>
      <div  id="panel_ppttypeadd" class="modal-body">
        <form class="form" id="form_ppttypeadd">
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group">
                <label for="ptypename"><?php echo Lang::$say->_PPT_TYPE ?></label>
                <input type="text" class="form-control" name="ptypename">
              </div>
            </div>
            <div class="col-sm-5">
              <label class="hidden-xs">&nbsp;</label>
              <div class="form-group">
                <label class="checkbox-inline">
                  <input name="ptypepublish" type="checkbox" value="1">
                  <i></i><?php echo Lang::$say->_PUBLISH ?> </label>
                <label class="checkbox-inline">
                  <input name="ptypelock" type="checkbox" value="1">
                  <i></i><?php echo Lang::$say->_LOCK ?> </label>
                <label class="checkbox-inline">
                  <input name="ptypehideinpub" type="checkbox" value="1">
                  <i></i><?php echo Lang::$say->_GNL_HIDEINPUBLIC ?> </label>                  
              </div>
            </div>
            <div class="col-sm-2">
              <label class="hidden-xs">&nbsp;</label>
              <div class="form-group">
                <input type="hidden" name="savePropertyType" value="<?php echo genRequestKey('savePropertyType');?>">
                <button id="save_ppttypeadd" data-after="hide" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?php echo Lang::$say->_SAVE;?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="msg_ppttypeadd"></div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modaldlg_ppttypeedit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> <?php echo Lang::$say->_PPT_EDITTYPE ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
      <div  id="panel_ppttypeedit" class="modal-body"> </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="card panel-default">
  <div class="card-header"><h3 class="card-title"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> <?php echo Lang::$say->_PPT_BLOCKSTATUSES ?></h3></div>
  <div class="card-body panel_blockstatedit">
    <div class="row">
      <div class="col-lg-12"> </div>
    </div>
    <div class="clearfix"><br />
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="msg_blockstatedit"></div>
        <div class="listpanel_blockstatus listpanel_blockstatedit"><?php echo $vhr->getBlockStatList()?> </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modaldlg_blockstatedit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> <?php echo Lang::$say->_PPT_BLSTEDIT ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>       
        </div>
      <div  id="panel_blockstatedit" class="modal-body"> </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="card panel-default">
  <div class="card-header"><h3 class="card-title"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <?php echo Lang::$say->_GNL_EMAILTPLS ?></h3></div>
  <div class="card-body panel_emailtpledit">
    <div class="row">
      <div class="col-lg-12">
        <div class="msg_emailtpledit"></div>
        <div class="listpanel_emailtpledit"> <?php echo $gist->getEmTemplatList()?> </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modaldlg_emailtpledit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> <?php echo Lang::$say->_GNL_EDITEMAILTPL ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>      
        </div>
      <div  id="panel_emailtpledit" class="modal-body"> </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if(isset($_GET['do']) && $_GET['do']=='language'){

?>
<h1><?php echo Lang::$say->_LANGUAGES?></h1>
<div class="clearfix"></div>
<div class="card panel-default">
  <div class="card-header"><h3 class="card-title"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> <?php echo Lang::$say->_LANGUAGES ?></h3> </div>
  <div class="card-body panel_langadd panel_langedit panel_langdel">
    <div class="row">
      <div class="col-lg-12"> <a class="btn btn-default float-right" id="showmodaldlg_langadd" href="javascript:void(0);"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo Lang::$say->_LANGADD ?></a></div>
    </div>
    <div class="clearfix"><br />
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="msg_langadd msg_langedit msg_langdel"></div>
        <div class="listpanel_langadd listpanel_langedit listpanel_langdel"> <?php echo $gist->getLanguageList()?> </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modaldlg_langadd" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span class="glyphicon glyphicon-plus"></span> <?php echo Lang::$say->_LANGADD ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
      <div  id="panel_langadd" class="modal-body">
        <form class="form" id="form_langadd">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="name"><?php echo Lang::$say->_LANGNAME ?></label>
                <input type="text" class="form-control" name="name">
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label for="abbr"><?php echo Lang::$say->_LANGABBR ?></label>
                <input name="abbr" type="text" class="form-control" maxlength="5">
              </div>
            </div>
            <div class="col-sm-3">
              <label for="direction"><?php echo Lang::$say->_LANGDIRECTION ?></label>
              <div class="inline-group">
                <label class="labelnormal radio-inline">
                  <input id="langdirection1" name="direction" value="ltr" checked="checked" type="radio">
                  <i></i>LTR</label>
                <label class="labelnormal radio-inline">
                  <input id="langdirection2" name="direction" value="rtl" type="radio">
                  <i></i>RTL</label>
              </div>
            </div>
            <div class="col-sm-2">
              <label class="hidden-xs">&nbsp;</label>
              <div class="form-group">
                <label class="checkbox-inline">
                  <input name="publish" type="checkbox" value="1">
                  <i></i><?php echo Lang::$say->_PUBLISH ?> </label>
              </div>
            </div>
            <div class="col-sm-2">
              <label class="hidden-xs">&nbsp;</label>
              <div class="form-group">
                <input type="hidden" name="saveLanguage" value="<?php echo genRequestKey('saveLanguage');?>">
                <button id="save_langadd" data-after="hide" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?php echo Lang::$say->_SAVE;?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="msg_langadd"></div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modaldlg_langedit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">        
        <h5 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> <?php echo Lang::$say->_LANGEDIT ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>        
        </div>
      <div  id="panel_langedit" class="modal-body"> </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if(isset($_GET['do']) && $_GET['do']=='langphrases' && isset($_GET['abbr'])){
if(!$gist->validLang(sanitize($_GET['abbr'],5))){
$abbr=false;
echo '<div class="alert alert-warning" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_LANGABBR_R . '</p></div></div>';	
	exit;}else{
		$abbr = sanitize($_GET['abbr'],5);
		$langname = getValue('name', Gist::lngTable, "abbr='".$abbr."'");
		}
?>
<h1><?php echo Lang::$say->_LANGUAGES.' &rsaquo; '.Lang::$say->_LANGPHRASES?></h1>
<div class="clearfix"></div>
<div class="card panel-default">
  <div class="card-header"><h3 class="card-title"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> <a href="settings.php?do=language"><?php echo Lang::$say->_LANGUAGES ?></a> &rsaquo; <?php echo $langname.' ('.$abbr.') '.Lang::$say->_LANGPHRASES?></h3></div>
  <div class="card-body panel_langadd panel_langedit panel_langdel">
    <div class="row">
      <div class="col-lg-12"> <a class="btn btn-default" href="settings.php?do=language"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> <?php echo Lang::$say->_BACK ?></a> </div>
    </div>
    <div class="clearfix"><br />
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="msg_langadd msg_langedit msg_langdel"></div>
        <div class="listpanel_langadd listpanel_langedit listpanel_langdel">
          <div id="langphrases" class="rowspan">
            <?php 
		$xmlmaster = simplexml_load_file(BASEPATH .Lang::langdir.'en' . "/lang-master.xml");
		$xmlel = simplexml_load_file(BASEPATH .Lang::langdir.''. $abbr . "/lang.xml"); $data = new stdClass();
		$masterphrs = array();		
		foreach($xmlmaster as $mkey) {
    	$masterphrs["$mkey[data]"] = $mkey->__toString();
		}	
		?>
            <?php 
		$i = 1;
		foreach ($xmlel as $pkey){
		?>
            <div class="row">
              <div class="col-sm-5">
                <div class="wenbs ophrase"><?php echo '<span class="recstatus">'.$i.'.</span> '.$masterphrs["$pkey[data]"]?></div>
              </div>
              <div class="col-sm-7">
                <div contenteditable="true" data-auth="<?php echo genRequestKey('inPlaceEditLangPhrase'.$pkey['data']);?>" data-edit-type="language" data-id="<?php echo $i++;?>" data-key="<?php echo $pkey['data'];?>" data-abbr="<?php echo $abbr;?>" class="wenbs phrase"><?php echo $pkey;?></div>
              </div>
            </div>
            <?php }
		unset($mkey);
		unset($pkey);
		?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12"> <a class="btn btn-default" href="settings.php?do=language"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> <?php echo Lang::$say->_BACK ?></a> </div>
    </div>
  </div>
</div>
<?php } ?>
<?php include("footer.tpl.php");?>
