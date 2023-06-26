<?php
define("_EXECPERMIT_WNV", true);
require_once ("start.php");
if(!$user->logged_in){redirect_to(SITEURL . "login/");}
$pageTitle = Lang::$say->_UR_USERS.' - '.$gist->pptname;
if(isset($_GET['do']) && ($_GET['do']=='assign')){$pageTitle = Lang::$say->_UR_ASSIGNMENT.' - '.$gist->pptname;}
include("header.tpl.php");
if(!$user->isSuperAdmin()){print Sift::msgWarning(Lang::$say->_LG_ONLYSUAPADMIN); return;}
?>
<?php if(!isset($_GET['do']) || !$_GET['do']){
?>
<h1><?php echo Lang::$say->_UR_USERS ?></h1>
<div class="card panel-default">
  <div class="card-body panel_useradd panel_useredit panel_userdel">
    <div class="row">
      <div class="col-lg-12"> <a class="btn btn-default float-right" id="showmodaldlg_useradd" href="javascript:void(0);"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo Lang::$say->_UR_USERADD ?></a></div>
    </div>
    <div class="clearfix"><br />
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="msg_useradd msg_useredit msg_userdel"></div>
        <div class="listpanel_useradd listpanel_useredit listpanel_userdel"> <?php echo $user->getUserList() ?> </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modaldlg_useradd" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">      
        <h5 class="modal-title"><span class="glyphicon glyphicon-plus"></span> <?php echo Lang::$say->_UR_USERADD ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>                
        </div>
      <div  id="panel_useradd" class="modal-body">
        <form class="form" id="form_useradd">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="fname"><?php echo Lang::$say->_UR_FULLNAME ?></label>
                <input type="text" class="form-control" name="fname" autocomplete="off" autocorrect="off">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="email"><?php echo Lang::$say->_UR_EMAIL ?></label>
                <input type="text" class="form-control" name="email" autocomplete="off" autocorrect="off">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label style="width:100%" for="userlevel"><?php echo Lang::$say->_UR_UROLE ?> <a href="#user_role_help" role="button" class="float-right" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span> <?php echo Lang::$say->_HELP ?></a></label>
                <select class="form-control custom-select" name="userlevel">
                  <option value="8"><?php echo Lang::$say->_UR_UTY8 ?></option>
                  <option value="7"><?php echo Lang::$say->_UR_UTY7 ?></option>
                  <option value="6"><?php echo Lang::$say->_UR_UTY6 ?></option>
                  <option value="5"><?php echo Lang::$say->_UR_UTY5 ?></option>
                  <option value="4"><?php echo Lang::$say->_UR_UTY4 ?></option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="password"><?php echo Lang::$say->_UR_USRNAMECREATE ?></label>
                <input type="text" class="form-control" name="username" autocomplete="off"  autocorrect="off">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="password"><?php echo Lang::$say->_UR_PASSWORDCRT ?></label>
                <input type="password" class="form-control" name="password" autocomplete="off" autocorrect="off">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="password2"><?php echo Lang::$say->_UR_PASSWORDCNF ?></label>
                <input type="password" class="form-control" name="password2" autocomplete="off" autocorrect="off">
              </div>
            </div>
            <div class="col-sm-3">
              <label class="hidden-xs">&nbsp;</label>
              <div class="form-group">
                <label class="checkbox-inline">
                  <input name="active" type="checkbox" value="y">
                  <i></i><?php echo Lang::$say->_UR_ACTIVE ?> </label>
                <label class="checkbox-inline">
                  <input name="notify" type="checkbox" value="1">
                  <i></i><?php echo Lang::$say->_UR_NOTIFY ?> </label>
              </div>
            </div>
          </div>
          <hr class="slim">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="company"><?php echo Lang::$say->_UR_COMNAME ?></label>
                <input type="text" class="form-control" name="company">
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label for="caddress"><?php echo Lang::$say->_UR_COMADDR ?></label>
                <input type="text" class="form-control" name="caddress">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="caddress"><?php echo Lang::$say->_UR_COMPHONE ?></label>
                <input type="text" class="form-control" name="cphone">
              </div>
            </div>
          </div>
          <hr class="slim">
          <?php echo Vault::get("Vhrental")->ptypesAssignments();?>          
          <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
              <div class="form-group">
                <input type="hidden" name="saveUser" value="<?php echo genRequestKey('saveUser');?>">
                <button id="save_useradd" data-after="hide" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?php echo Lang::$say->_SAVE;?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="msg_useradd"></div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modaldlg_useredit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">      
        <h5 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> <?php echo Lang::$say->_UR_USEREDIT ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>        
        </div>
      <div  id="panel_useredit" class="modal-body"> </div>
    </div>
  </div>
</div>
<?php /*?><div class="modal fade" id="modaldlg_feedlinks" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">      
         <h5 class="modal-title"><span class="glyphicon glyphicon-link"></span> <?php echo Lang::$say->_BKG_FEEDAVAILABILITY ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
      <div class="modal-body panel_feedlinks">
        <div class="msg_feedlinks"></div>
        <div class="panel_calfeedlinks listpanel_feedlinks">
          <div id="panel_feedlinks"></div>
        </div>
      </div>
    </div>
  </div>
</div><?php */?>


<?php }?>
<?php if(isset($_GET['do']) && $_GET['do']=='assign'){?>
<h1><?php echo Lang::$say->_UR_ASSIGNMENT ?></h1>
<div class="card panel-default">
  <div class="card-body panel_uassignedit">
    <div class="clearfix"><br />
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="msg_uassignedit"></div>
        <div class="listpanel_uassignedit"> <?php echo $user->getUserAssignments() ?> </div>
      </div>                                                     
    </div>
  </div>
</div>

<div class="modal fade" id="modaldlg_uassignedit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
       <h5 class="modal-title"><span class="glyphicon glyphicon-saved"></span> <?php echo Lang::$say->_UR_ASSIGNPPTY ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>        
        </div>
      <div  id="panel_uassignedit" class="modal-body"> </div>
    </div>
  </div>
</div>

<?php }?>

<div id="user_role_help" class="modal fade second-modal" data-backdrop-limit="1" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="<?php echo Lang::$say->_UR_UROLE ?>" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">        
       <h5 class="modal-title"><span class="glyphicon glyphicon-question-sign"></span> <?php echo Lang::$say->_UR_UROLE ?> <?php echo Lang::$say->_HELP ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo Lang::$say->_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>                
        </div>
      <div class="modal-body">
        <table width="100%" class="table table-hover table-sm">
          <tr>
            <th class="notopborder"><?php echo Lang::$say->_UR_UROLE ?></th>
            <th class="notopborder"><?php echo Lang::$say->_UR_RCEBLOCK ?></th>
            <th class="notopborder"><?php echo Lang::$say->_UR_RVDBLOCK ?></th>
            <th class="notopborder"><?php echo Lang::$say->_UR_RVCBLOCK ?></th>
          </tr>
          <tr>
            <td><?php echo Lang::$say->_UR_UTY8 ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLALL ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLALL ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLALLCLR ?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$say->_UR_UTY7 ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLTHR ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLALL ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLALLCLR ?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$say->_UR_UTY6 ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLTHR ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLTHR ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLALLCLR ?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$say->_UR_UTY5 ?></td>
            <td><span class="glyphicon glyphicon-ban-circle graynote"></span> <?php echo Lang::$say->_NO ?></td>
            <td><span class="glyphicon glyphicon-ban-circle graynote"></span> <?php echo Lang::$say->_NO ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLALLCLR ?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$say->_UR_UTY4 ?></td>
            <td><span class="glyphicon glyphicon-ban-circle graynote"></span> <?php echo Lang::$say->_NO ?></td>
            <td><span class="glyphicon glyphicon-ban-circle graynote"></span> <?php echo Lang::$say->_NO ?></td>
            <td><span class="glyphicon glyphicon-ok-sign graynote"></span> <?php echo Lang::$say->_UR_ROLSTDCLR ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include("footer.tpl.php");?>