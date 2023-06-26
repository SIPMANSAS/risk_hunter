<?php
  /**
   * Vhrental Class
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: class.vhrental.php, v1.1.1 Feb 2018 transinova $
   */
  
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');
  
  class Vhrental
  {
	  
	  const pptyTable = "property_types";
	  const blksTable = "property_blockstatuses";

	  
	  private static $db;
	  public $ppttype;
	  public $availcolor;
	  public $navailcolor;
	  public $availstatus;
	  public $navailstatus;

      /**
       * Vhrental::__construct()
       * 
       * @return
       */
      function __construct($ctree = true, $item = false, $cat = false)
      {
		  self::$db = Vault::get("Database");
		  $this->defaultPptType();
		  $this->twoColor();
      }


      /**
       * Vhrental::savePropertyType()
       * 
       * @return
       */
	  public function savePropertyType()
	  {

		  if (Sift::$id){
			$result = $this->propertyTypeExists($_POST['ptypename'],Sift::$id);
				if ($result == 1)
					  Sift::$msgs['ptypename'] = Lang::$say->_PPT_TYPE_R;
				  if ($result == 2)
				  	  Sift::$msgs['ptypename'] = Lang::$say->_PPT_TYPE_E;	 
		  }else{
			$result = $this->propertyTypeExists($_POST['ptypename']);
				if ($result == 1)
					  Sift::$msgs['ptypename'] = Lang::$say->_PPT_TYPE_R;
				  if ($result == 2)
				  	  Sift::$msgs['ptypename'] = Lang::$say->_PPT_TYPE_E;
			  }
		  
		  if(isset($_POST['ptypepublish'])){$ptypepublish=intval($_POST['ptypepublish']);}else{$ptypepublish=0;}
		  if(isset($_POST['ptypelock'])){$ptypelock=intval($_POST['ptypelock']);}else{$ptypelock=0;}
		  if(isset($_POST['ptypehideinpub'])){$ptypehideinpub=intval($_POST['ptypehideinpub']);}else{$ptypehideinpub=0;}
			  
		  
		  if (empty(Sift::$msgs)) {
			  $data = array(
					  'name' => sanitize($_POST['ptypename']), 
					  'publish' => $ptypepublish,
					  'locked' => $ptypelock,
					  'hideinpub' => $ptypehideinpub
			  );

			  if (!Sift::$id){
			  self::$db->insert(self::pptyTable, $data);
			  }else{
				  self::$db->update(self::pptyTable, $data, "id='" . Sift::$id . "'");
				  }
			  
			  if(self::$db->affected()) {
				  $json['status'] = 'success';
				  if (Sift::$id) {
				  $json['message'] = Sift::msgSuccess(Lang::$say->_PPT_TYPEUPDATED, false,4000,false,true);
				  }
				  else{$json['message'] = Sift::msgSuccess(Lang::$say->_PPT_TYPEADDED, false,false,false,false);}
				  $json['content'] = $this->getTypeList();
			  } else {
				  $json['status'] = 'failed';
				  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
			  }
			  print json_encode($json);
			  
		  } else {
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  }
      }



	  /**
	   * Vhrental::propertyTypeExists()
	   * 
	   * @param mixed $type,$editid
	   * @return
	   */
	  private function propertyTypeExists($type=false,$editid=false)
	  {
		  if($editid){$sq=" AND id!='$editid' ";}else{$sq="";}
		  $type = sanitize($type);
		  if (strlen(self::$db->escape($type)) < 4)
			  return 1;
		  $sql = self::$db->query("SELECT name" 
		  . "\n FROM " . self::pptyTable
		  . "\n WHERE name = '" . $type . "'".$sq
		  . "\n LIMIT 1");	
		  $count = self::$db->numrows($sql);	
		  return ($count > 0) ? 2 : false;
	  } 	

	  /**
	   * Vhrental::propertyTypeIdExists()
	   * 
	   * @param mixed $id
	   * @return
	   */
	  public function propertyTypeIdExists($id=false,$withpub=false)
	  {
		  $id = sanitize($id);
		  if($withpub){$pubcheck=" AND publish='1' ";}else{$pubcheck="";}
		  $sql = self::$db->query("SELECT id" 
		  . "\n FROM " . self::pptyTable
		  . "\n WHERE id = '" . $id . "'".$pubcheck
		  . "\n LIMIT 1");	
		  $count = self::$db->numrows($sql);	
		  return ($count > 0) ? 1 : false;
	  } 

	  /**
	   * Vhrental::propertyTypeIdPubview()
	   * 
	   * @param mixed $id
	   * @return
	   */
	  public function propertyTypeIdPubview($id=false)
	  {
		  $id = sanitize($id);
		  $pubcheck=" AND publish=1 AND hideinpub='0' ";
		  $sql = self::$db->query("SELECT id" 
		  . "\n FROM " . self::pptyTable
		  . "\n WHERE id = '" . $id . "'".$pubcheck
		  . "\n LIMIT 1");	
		  $count = self::$db->numrows($sql);	
		  return ($count > 0) ? 1 : false;
	  }
	  /**
	   * Vhrental::propertyTypeName()
	   * 
	   * @param mixed $id
	   * @return
	   */
	  public function propertyTypeName($id=false)
	  {
		  $id = sanitize($id);$row =false;
		  $sql = self::$db->query("SELECT name" 
		  . "\n FROM " . self::pptyTable
		  . "\n WHERE id = '" . $id . "'"
		  . "\n LIMIT 1");	
		  $count = self::$db->numrows($sql);
		  if($count > 0){$row = self::$db->fetch($sql);}
		  return ($count > 0) ? $row->name : false;
	  } 
	  
      /**
       * Vhrental::reorderPropertyType()
       * 
       * @return
       */
	  public function reorderPropertyType()
	  {
		$i = 0; $updated=0;

		foreach ($_POST['ppttypeitem'] as $value) {
			$data = array(
					  'sort' => $i
			  );
			self::$db->update(self::pptyTable, $data, "id='" . $value . "'");
			if(self::$db->affected()){$updated++;}
    		$i++;
			}
			  if($updated>0) {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgSuccess(Lang::$say->_GNL_SORTSAVED, false,2000,false,true);
			  } else {
				  $json['status'] = 'failed';
				  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
			  }
			  print json_encode($json);
		}


      /**
       * Vhrental::getTypeList()
       * 
       * @return
       */
      public function getTypeList()
	  {

		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n ORDER BY sort ASC ");
		  
		  $res = self::$db->numrows($query);
		  $disp ='<ul id="pptTypeList" class="sortablelist">';
		  
		  while ($row = self::$db->fetch($query)) {
			  if($row->locked){$locked='<span class="glyphicon glyphicon-lock recstatus" aria-hidden="true"></span>';}else{$locked='';}
			  if(!$row->publish){$hidden='<span class="glyphicon glyphicon-ban-circle recstatus" aria-hidden="true"></span>';}else{$hidden='';}
			  
if($row->hideinpub){$hideinpub='<span class="glyphicon glyphicon-eye-close recstatus" aria-hidden="true"></span>';}else{$hideinpub='';}			  
			  
			  $disp .='<li id="ppttypeitem_'.$row->id.'" class="dd-item"><div class="dd-holder">
			  <div class="row"><div class="col-sm-8">
			  <span class="dd-handle"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></span>'.$row->name.$hidden.$locked.$hideinpub.'</div><div class="col-sm-4">
			  <a class="itemaction itemedit" data-listcont="ppttypeedit" data-id="'.$row->id.'" data-option="editPropertyType" href="javascript:void(0);" data-name="'.$row->name.'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
<a class="itemaction itemdelete" data-listcont="ppttypedel" data-id="'.$row->id.'" data-option="deletePropertyType" href="javascript:void(0);" data-name="'.$row->name.'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a> 			  
			  </div></div></div></li>';

		  }
		  $disp .='</ul>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $( "#pptTypeList" ).sortable({
      handle: ".dd-handle",
	  placeholder: "dd-placeholder",
update: function (event, ui) {
        var typelist = $(this).sortable("serialize");
		typelist+= "&sortPropertyType='.genRequestKey('sortPropertyType').'";
        $.ajax({
            data: typelist,
            type: "post",
			dataType: "json",
            url: siteurl+"controller/controller.php",
			success: function(json){
                $(".msg_ppttypeedit").html(json.message);
        	}			
        });
    }	  
    });
});
// ]]>
</script>	  
		  ';
$notypes='<div class="alert alert-warning" role="alert">'.Lang::$say->_PPT_TYPESNONE.'</div>';  
		  return ($res) ? sanitize_output($disp) : $notypes;
	  }
	  

	  /**
	   * Vhrental::editFormType()
	   * 
	   * @param mixed $id
	   * @return
	   */
	  public function editFormType($id)
	  {
          $id = sanitize($id);
          $id = self::$db->escape($id);

		  $sql = "SELECT * FROM " . self::pptyTable . " WHERE id = '" . $id . "' ";
          $row = self::$db->first($sql);
if($row->locked){$locked=' checked="checked"';}else{$locked='';}
if($row->publish){$hidden=' checked="checked"';}else{$hidden='';}
if($row->hideinpub){$hideinpub=' checked="checked"';}else{$hideinpub='';}
$disp = '
<form class="form" id="form_ppttypeedit">
<div class="row">
<div class="col-sm-5">
  <div class="form-group">
    <label for="ptypename">'.Lang::$say->_PPT_TYPE.'</label>
    <input type="text" class="form-control" name="ptypename" placeholder="'.Lang::$say->_PPT_TYPE.'" value="'.$row->name.'">
  </div>
</div>
<div class="col-sm-5"><label class="hidden-xs">&nbsp;</label>
<div class="form-group">
    <label class="checkbox-inline">
      <input name="ptypepublish" type="checkbox" value="1" '.$hidden.'> <i></i>'.Lang::$say->_PUBLISH.'
    </label>
    <label class="checkbox-inline">
      <input name="ptypelock" type="checkbox" value="1" '.$locked.'> <i></i>'.Lang::$say->_LOCK.'
    </label>
    <label class="checkbox-inline">
      <input name="ptypehideinpub" type="checkbox" value="1" '.$hideinpub.'> <i></i>'.Lang::$say->_GNL_HIDEINPUBLIC.'
    </label>	
</div> 
</div>
<div class="col-sm-2"><label class="hidden-xs">&nbsp;</label> 
  <div class="form-group">
  <input type="hidden" name="updatePropertyType" value="'.genRequestKey('updatePropertyType'.$row->id).'">
  <input type="hidden" name="id" value="'.$row->id.'">
  <button id="save_ppttypeedit" data-after="none" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.Lang::$say->_SAVE.'</button>
</div>    
</div>
</div>  
</form>
<div id="msg_ppttypeedit"></div>
';

          return ($row) ? sanitize_output($disp) : false;
	  }	
	  
	  
      /**
       * Vhrental::getBlockStatList()
       * 
       * @return
       */
      public function getBlockStatList()
	  {

		  $query = self::$db->query("SELECT *, title" . Lang::$lang . " as thetitle FROM " . self::blksTable
		  . "\n ORDER BY sort ASC ");
		  
		  $res = self::$db->numrows($query);
		  $disp ='<ul id="blockStatList" class="sortablelist">';
		  
		  while ($row = self::$db->fetch($query)) {
			  if(!$row->inuse){$notused='<span class="glyphicon glyphicon-ban-circle recstatus" aria-hidden="true"></span>';}else{$notused='';}
			  $disp .='<li id="blockstatitem_'.$row->id.'" class="dd-item"><div class="dd-holder">
			  <div class="row"><div class="col-sm-5">
			  <span class="dd-handle"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></span>'.$row->status.' '.$row->desc.$notused.'</div><div class="col-sm-5"><span class="colorthumb" style="background-color:'.$row->colorhex.'"></span>'.$row->thetitle.'</div><div class="col-sm-2">
			  <a class="itemaction itemedit" data-listcont="blockstatedit" data-id="'.$row->id.'" data-option="editBlockStatus" href="javascript:void(0);" data-name="'.$row->thetitle.'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
			  </div></div></div></li>';

		  }
		  $disp .='</ul>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function(){
    $( "#blockStatList" ).sortable({
      handle: ".dd-handle",
	  placeholder: "dd-placeholder",
update: function (event, ui) {
        var blockstatlist = $(this).sortable("serialize");
		blockstatlist+= "&sortBlockStatus='.genRequestKey('sortBlockStatus').'";
        $.ajax({
            data: blockstatlist,
            type: "post",
			dataType: "json",
            url: siteurl+"controller/controller.php",
			success: function(json){
                $(".msg_blockstatedit").html(json.message);
        	}			
        });
    }	  
    });
});
// ]]>
</script>	  
		  ';
		  return ($res) ? sanitize_output($disp) : null;
	  }
	  

      /**
       * Vhrental::getBlockStatJsVars()
       * 
       * @return
       */
      public function getBlockStatJsVars()
	  {

		  $query = self::$db->query("SELECT *, title" . Lang::$lang . " as thetitle FROM " . self::blksTable
		  . "\n ORDER BY sort ASC ");
		  
		  $res = self::$db->numrows($query);
	      $disp ='var ljsBlockStats = [];';
		  while ($row = self::$db->fetch($query)) {
			  $disp .='ljsBlockStats["'.$row->id.'"]="'.addslashes($row->thetitle).'";
			  ';
		  }
		  
		  return ($res) ? sanitize_output($disp) : null;
	  }
	  

	  /**
	   * Vhrental::editFormBlockStatus()
	   * 
	   * @param mixed $id
	   * @return
	   */
	  public function editFormBlockStatus($id)
	  {
          $id = sanitize($id);
          $id = self::$db->escape($id);

		  $sql = "SELECT * FROM " . self::blksTable . " WHERE id = '" . $id . "' ";
          $row = self::$db->first($sql);
if($row->inuse){$inuse=' checked="checked"';}else{$inuse='';}
if($row->reserved){$reserved=' onclick="return false;"';}else{$reserved='';}
$disp = '
<form class="form" id="form_blockstatedit">
<div class="row">
<div class="col-sm-7">
  <div class="form-group">
    <label for="title'.Lang::$lang.'">'.Lang::$say->_PPT_BLSTTITLE.' '.Lang::$say->_FOR.': '.$row->status.' <span class="badge badge-secondary">'.Vault::get("Lang")->currlang.'</label>
    <input type="text" class="form-control" name="title'.Lang::$lang.'" placeholder="'.Lang::$say->_PPT_BLSTTITLE.'" value="'.$row->{'title'.Lang::$lang}.'">
  </div>
</div>
<div class="col-sm-1"><label>'.Lang::$say->_PPT_BLSTCOLOR.'</label>
<div class="form-group">
<input id="color_hex" type="text" name="colorhex" value="'.$row->colorhex.'" />
</div>
</div>
<div class="col-sm-2"><label class="hidden-xs">&nbsp;</label>
<div class="form-group">
    <label class="checkbox-inline">
      <input name="inuse" type="checkbox" value="1" '.$inuse.$reserved.'> <i></i>'.Lang::$say->_PPT_BLSTUSE.'
    </label>  
</div> 
</div>
<div class="col-sm-2"><label class="hidden-xs">&nbsp;</label> 
  <div class="form-group">
  <input type="hidden" name="updateBlockStatus" value="'.genRequestKey('updateBlockStatus'.$row->id).'">
  <input type="hidden" name="id" value="'.$row->id.'">
  <button id="save_blockstatedit" data-after="none" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.Lang::$say->_SAVE.'</button>
</div>    
</div>
</div>  
</form>
<div id="msg_blockstatedit"></div>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
$("#color_hex").colorPicker();
});
// ]]>
</script>
';

          return ($row) ? sanitize_output($disp) : false;
	  }	
	  
	  

      /**
       * Vhrental::saveBlockStatus()
       * 
       * @return
       */
	  public function saveBlockStatus()
	  {
		  if (Sift::$id){
			$result = $this->blockStatusExists($_POST['title' . Lang::$lang],Sift::$id);
				if ($result == 1)
					  Sift::$msgs['title'] = Lang::$say->_PPT_BLST_R;
				  if ($result == 2)
				  	  Sift::$msgs['title'] = Lang::$say->_PPT_BLST_E;	 
		  }else{
			$result = $this->blockStatusExists($_POST['title' . Lang::$lang]);
				if ($result == 1)
					  Sift::$msgs['title'] = Lang::$say->_PPT_BLST_R;
				  if ($result == 2)
				  	  Sift::$msgs['title'] = Lang::$say->_PPT_BLST_E;
			  }


		  if (Sift::$id){
			$result = $this->colorStatusExists(strtolower(sanitize($_POST['colorhex'])),Sift::$id);
				if ($result == 1)
					  Sift::$msgs['title'] = Lang::$say->_PPT_BLSTCLR_E;
		  }else{
			$result = $this->colorStatusExists(strtolower(sanitize($_POST['colorhex'])));
				if ($result == 1)
					  Sift::$msgs['title'] = Lang::$say->_PPT_BLSTCLR_E;
			  }
		  
		  if(isset($_POST['inuse'])){$inuse=intval($_POST['inuse']);}else{$inuse=0;}
			  
		  
		  if (empty(Sift::$msgs)) {
			  $data = array(
					  'title'. Lang::$lang => sanitize($_POST['title' . Lang::$lang]), 
					  'colorhex' => strtolower(sanitize($_POST['colorhex'])),
					  'inuse' => $inuse
			  );

			  if (!Sift::$id){
			  self::$db->insert(self::blksTable, $data);
			  }else{
				  self::$db->update(self::blksTable, $data, "id='" . Sift::$id . "'");
				  }
			  
			  if(self::$db->affected()) {
				  $json['status'] = 'success';
				  if (Sift::$id) {
				  $json['message'] = Sift::msgSuccess(Lang::$say->_PPT_BLSTUPDATED, false,4000,false,true);
				  }
				  else{$json['message'] = Sift::msgSuccess(Lang::$say->_PPT_BLSTADDED, false,false,false,false);}
				  $json['content'] = $this->getBlockStatList();
			  } else {
				  $json['status'] = 'failed';
				  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
			  }
			  print json_encode($json);
			  
		  } else {
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  }
      }


	  /**
	   * Vhrental::blockStatusExists()
	   * 
	   * @param mixed $status,$editid
	   * @return
	   */
	  private function blockStatusExists($status=false,$editid=false)
	  {
		  if($editid){$sq=" AND id!='$editid' ";}else{$sq="";}
		  $status = sanitize($status);
		  if (strlen(self::$db->escape($status)) < 4)
			  return 1;
		  $sql = self::$db->query("SELECT id" 
		  . "\n FROM " . self::blksTable
		  . "\n WHERE title". Lang::$lang." = '" . $status . "'".$sq
		  . "\n LIMIT 1");	
		  $count = self::$db->numrows($sql);	
		  return ($count > 0) ? 2 : false;
	  } 	

	  /**
	   * Vhrental::colorStatusExists()
	   * 
	   * @param mixed $colorhex,$editid
	   * @return
	   */
	  private function colorStatusExists($colorhex=false,$editid=false)
	  {
		  if($editid){$sq=" AND id!='$editid' ";}else{$sq="";}
		  $colorhex = sanitize($colorhex);
		  $sql = self::$db->query("SELECT id" 
		  . "\n FROM " . self::blksTable
		  . "\n WHERE colorhex = '" . $colorhex . "'".$sq
		  . "\n LIMIT 1");	
		  $count = self::$db->numrows($sql);	
		  return ($count > 0) ? 1 : false;
	  } 	  


      /**
       * Vhrental::reorderBlockStatus()
       * 
       * @return
       */
	  public function reorderBlockStatus()
	  {
		$i = 0; $updated=0;

		foreach ($_POST['blockstatitem'] as $value) {
			$data = array(
					  'sort' => $i
			  );
			self::$db->update(self::blksTable, $data, "id='" . $value . "'");
			if(self::$db->affected()){$updated++;}
    		$i++;
			}
			  if($updated>0) {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgSuccess(Lang::$say->_GNL_SORTSAVED, false,2000,false,true);
			  } else {
				  $json['status'] = 'failed';
				  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
			  }
			  print json_encode($json);
		}



      /**
       * Vhrental::blockStatSelectBox($name='status',$selectid=false)
       * 
       * @return
       */
      public function blockStatSelectBox($name='status',$selectid=false)
	  {

		  $query = self::$db->query("SELECT *, title" . Lang::$lang . " thetitle FROM " . self::blksTable
		  . "\n WHERE inuse='1' AND reserved!='1' ORDER BY sort ASC ");
		  
		  $res = self::$db->numrows($query);
		  $disp='<select class="form-control setcolorprev custom-select" name="'.$name.'">';$style='';
		   if(!$selectid){$disp .='<option value="" class="option c'.str_replace('#','',strtolower($this->availcolor)).'" data-hex="'.strtolower($this->availcolor).'">-</option>';}
		  while ($row = self::$db->fetch($query)) {
			  if($row->id==$selectid){$selected=' selected="selected"';}else{$selected='';}
			  $disp .='<option'.$selected.' class="option c'.str_replace('#','',strtolower($row->colorhex)).'" value="'.$row->id.'" data-hex="'.strtolower($row->colorhex).'">'.$row->thetitle.'</option>';
			  $style .='option.option.c'.str_replace('#','',strtolower($row->colorhex)).':before{background-color: '.strtolower($row->colorhex).';}';			  
		  }
		  if($disp){
			  $disp .='</select>
			  <style>
option.option{line-height:24px;height:24px;}			  
option.option::before {
    content: "";
    display: inline-block;
    height: 12px;
	margin-top: 3px;
    margin-left: 3px;
    margin-right: 5px;
    width: 25px;
	border-radius: 2px;
	border: 1px solid rgba(255, 255, 255, 0.5);
}
				'.$style.'
				</style>';
			  }

		  return ($res) ? sanitize_output($disp) : '';
	  }
	  	    
      /**
       * Vhrental::defaultPptType()
       * 
       * @return
       */
      public function defaultPptType()
	  {

if(!Vault::get("Users")->logged_in){
		  $query = "SELECT id FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND hideinpub='0' ORDER BY sort ASC ";
}else{
if(Vault::get("Users")->isSuperAdmin()){
		  $query = "SELECT id FROM " . self::pptyTable
		  . "\n WHERE publish='1' ORDER BY sort ASC ";	
	}else{
			$pptassignment=getValueById('pptassignment', Users::usrTable, Vault::get("Users")->uid);  
			$pptassignments=array_map('intval', explode(',', $pptassignment));
			$pptassignment = implode("','",$pptassignments);
		  $query = "SELECT id FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id IN ('".$pptassignment."') ORDER BY sort ASC ";		
	}	
}
		  $row = self::$db->first($query);
		  $this->ppttype = ($row) ? $row->id : null;	  
}

	  
      /**
       * Vhrental::isPptTypeLocked()
       * 
       * @return
       */
      public function isPptTypeLocked($id)
	  {

		  $query = "SELECT locked FROM " . self::pptyTable
		  ."\n WHERE id='".$id."'";
		  $row = self::$db->first($query);
		  return ($row) ? $row->locked : null;
	  }

      /**
       * Vhrental::twoColor()
       * 
       * @return
       */
      public function twoColor()
	  {

		  $query = "SELECT id as sid,colorhex FROM " . self::blksTable
		  . "\n WHERE status='Available' ";
		  $row = self::$db->first($query);
		  $this->availcolor = $row->colorhex;
		  $this->availstatus = $row->sid;
		  $query = "SELECT id as sid,colorhex FROM " . self::blksTable
		  . "\n WHERE status='Booked' ";
		  $row = self::$db->first($query);
		  $this->navailcolor = $row->colorhex;		  
		  $this->navailstatus = $row->sid;
	  }

      /**
       * Vhrental::propertyTypeSelectBox()
       * 
       * @return
       */
      public function propertyTypeSelectBox($selectid=false,$publicmode=false)
	  {

if(!Vault::get("Users")->logged_in){
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND hideinpub='0' ORDER BY sort ASC ");
		  $disp ='';
		  $res = self::$db->numrows($query);
		  
		  while ($row = self::$db->fetch($query)) {
			  if((Vault::get("Gist")->pptlock || $row->locked=='1') && (Vault::get("Users")->userlevel<8)){$locked=' ('.strtolower(Lang::$say->_PPT_LOCKED).')';}else{$locked='';}
			  if($row->id==$selectid){$selected=' selected="selected"';}else{$selected='';}
			  $disp .='<option'.$selected.' value="'.$row->id.'">'.$row->name.$locked.'</option>';
		  }

		  return ($res) ? sanitize_output($disp) : '';
}else{
if($publicmode){$hideinpubq=" AND hideinpub='0' ";}else{$hideinpubq="";}
if(Vault::get("Users")->isSuperAdmin()){
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' $hideinpubq ORDER BY sort ASC ");	
	}else{
		$pptassignment=getValueById('pptassignment', Users::usrTable, Vault::get("Users")->uid);  
		$pptassignments=array_map('intval', explode(',', $pptassignment));
		$pptassignment = implode("','",$pptassignments);		
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id IN ('".$pptassignment."') $hideinpubq ORDER BY sort ASC ");
	}
		  $disp ='';
		  $res = self::$db->numrows($query);
		  while ($row = self::$db->fetch($query)) {
			  if((Vault::get("Gist")->pptlock || $row->locked=='1') && (Vault::get("Users")->userlevel<8)){$locked=' ('.strtolower(Lang::$say->_PPT_LOCKED).')';}else{$locked='';}
			  if($row->id==$selectid){$selected=' selected="selected"';}else{$selected='';}
			  $disp .='<option'.$selected.' value="'.$row->id.'">'.$row->name.$locked.'</option>';
		  }

		  return ($res) ? sanitize_output($disp) : '';

}

	  }
	  
      /**
       * Vhrental::propertyTypeStylesheet()
       * 
       * @return
       */
      public function propertyTypeStylesheet()
	  {
		  $query = self::$db->query("SELECT id as sid, colorhex FROM " . self::blksTable
		  . "\n WHERE inuse='1' ORDER BY sort ASC ");
		  $disp ='';$style ='';  
		  while ($row = self::$db->fetch($query)) {
		$style .='.cout.s'.$row->sid.'{border-top-color:'.$row->colorhex.' !important;_border-top-color:'.$row->colorhex.' !important;}';
		$style .='.chin.s'.$row->sid.'{border-bottom-color:'.$row->colorhex.' !important;_border-bottom-color:'.$row->colorhex.' !important;}';
		$style .='.chin.s'.$row->sid.' .intap{color:'.dkncolor($row->colorhex).' !important;}';
		$style .='.cout.s'.$row->sid.' .outap{color:'.dkncolor($row->colorhex).' !important;}';
		$style .='.chin.s'.$row->sid.' .adtap{color:'.dkncolor($row->colorhex).' !important;}';
		$style .='.cout.s'.$row->sid.' .retap{color:'.dkncolor($row->colorhex).' !important;}';
		  }

		  $disp ='<style>'.$style.'</style>';
		  return sanitize_output($disp);
	  }
	 


      /**
       * Vhrental::feedLinks()
       * @param mixed $userid
       * @return
       */
      public function feedLinks($userid=false)
	  {
          if(!$userid){$userid=Vault::get("Users")->uid;$username=Vault::get("Users")->username;}else
		  {$username=getValueById('username', Users::usrTable, $userid);}

$pastYearLimit = CFG_PUBLPASTYEARS;

if(Vault::get("Users")->isSuperAdmin()){
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' ORDER BY sort ASC ");	
	}else{
			$pptassignment=getValueById('pptassignment', Users::usrTable, $userid);  
			$pptassignments=array_map('intval', explode(',', $pptassignment));
			$pptassignment = implode("','",$pptassignments);
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id IN ('".$pptassignment."') ORDER BY sort ASC ");		
	}  
		  
		  $disp ='';
		  $res = self::$db->numrows($query);
if($res){  

$disp .='<div class="row">
      <div class="col-sm-12">
        <p>'.Lang::$say->_BKG_FEEDLINKDESC.'</p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6"><div class="form-group">
<label for="changetype_calfeed">'.Lang::$say->_PPT_TYPE.'</label>
        <select class="form-control custom-select" name="changetype_calfeed" id="changetype_calfeed" data-auth="'. genRequestKey('linkFeedCal'.$userid).'">
          <option value="-">-</option>
          '.Vault::get("Vhrental")->propertyTypeSelectBox().'
        </select>
		</div>
      </div>
      <div class="col-sm-2"><div class="form-group">
<label for="changeout_calfeed">'.Lang::$say->_OUTPUT.'</label>
        <select class="form-control custom-select" name="changeout_calfeed" id="changeout_calfeed" data-auth="'. genRequestKey('linkFeedCal'.$userid).'">
          <option value="xml">xml</option>
          <option value="json">json</option>
        </select>
		</div>
      </div>
      <div class="col-sm-2"><div class="form-group">
<label for="changemon_calfeed">'.Lang::$say->_MONTH.'</label>
        <select class="form-control custom-select" name="changemon_calfeed" id="changemon_calfeed" data-auth="'.genRequestKey('linkFeedCal'.$userid).'">
          '.Vault::get("Calendar")->monthSelect().'
        </select>
		</div>
      </div>
      <div class="col-sm-2"><div class="form-group">
<label for="changemon_calfeed">'.Lang::$say->_YEAR.'</label>
        <select class="form-control custom-select" name="changeyear_calfeed" id="changeyear_calfeed" data-auth="'.genRequestKey('linkFeedCal'.$userid).'">
        </select>
		</div>
      </div>
    </div>
    <div id="panel_calfeed">
      <div class="alert alert-info margin-top-15" role="alert">'.Lang::$say->_PPT_LINKOPTS_R.'</div>
    </div>
  <script type="text/javascript">
var min = new Date().getFullYear(),
	miin = min - '.$pastYearLimit.',
    max = min + 5,
    selectyear = document.getElementById("changeyear_calfeed");

for (var i = miin; i<=max; i++){
    var opt = document.createElement("option");
    opt.value = i;
    opt.innerHTML = i;
    selectyear.appendChild(opt);
}
selectyear.value = new Date().getFullYear();
</script>';		  
		  }
		  

$notypes = '<div class="alert alert-warning" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div>';
		  
		  return ($res) ? sanitize_output($disp) : $notypes;
	  }
	  
	  
	  
      /**
       * Vhrental::feedLink()
       * @param mixed $pptid
       * @return
       */
      public function feedLink($pptid=false,$output=false,$month=false,$year=false)
	  {

$notypes = '<div class="alert alert-info margin-top-15" role="alert">' . Lang::$say->_PPT_LINKOPTS_R . '</div>';
if(!$pptid || $pptid=='-'){return $notypes;}
if($output){$output=$output;}else{$output='xml';}
if(!$month){$month=date("m");}
if(!$year){$year=date("Y");}

          $userid=Vault::get("Users")->uid;
		  $username=Vault::get("Users")->username;
		  $userlevel =getValueById('userlevel', Users::usrTable, $userid);

if(Vault::get("Users")->isSuperAdmin()){
		  $query = "SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id='".$pptid."' LIMIT 1 ";	
	}else{
			$pptassignment=getValueById('pptassignment', Users::usrTable, $userid);  
			$pptassignments=array_map('intval', explode(',', $pptassignment));
			$pptassignment = implode("','",$pptassignments);
		  $query = "SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id IN ('".$pptassignment."') AND id='".$pptid."' LIMIT 1 ";		
	}  
		  
		  $disp ='';
		  $row = self::$db->first($query); 
if($row){
$akey=md5($row->id.'.'.$userid.'.'.getValueById('akey', Users::usrTable, $userid).'.'.Vault::get("Gist")->pptname);
$ppid = makePassId($pptid);			  
$disp .='<hr><div class="form-group">
                <label class="bolder" for="feedlink'.$row->id.'">'.$row->name.'</label>
				<div class="input-group">
                <input readonly type="text" class="form-control copyable i'.$row->id.'" name="feedlink'.$row->id.'" autocomplete="off" autocorrect="off" value="'.SITEURL.'feed.php?v='.$output.'&p='.$ppid.'&m='.$month.'&y='.$year.'&u='.$username.'&k='.$akey.'">
              <div class="input-group-append"><span class="input-group-text"><a data-id="'.$row->id.'" class="copyable-btn" href="javascript:void(0);"><span class="glyphicon glyphicon-copy"></span> '.Lang::$say->_COPY.'</a></span></div></div></div>';		  
		  }
		  
$resetbtn = '<div class="row margin-top-15"><div class="col-sm-12"><a href="javascript:void(0);" class="float-left generateakey" data-listcont="feedlinks" data-id="'.$userid.'" data-auth="'.genRequestKey($userid.'generateAkey').'"><span class="glyphicon glyphicon-refresh"></span> '.Lang::$say->_BKG_REGENFEEDKEY.'</a></div></div>';

$notypes = '<div class="alert alert-warning" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div>';
		  
		  return ($row) ? sanitize_output($disp).$resetbtn : $notypes;
	  }


      /**
       * Vhrental::exportLink()
       * @param mixed $pptid
       * @return
       */
      public function exportLink($pptid=false)
	  {

$notypes = '<div class="alert alert-info margin-top-15" role="alert">' . Lang::$say->_PPT_LINKOPTS_R . '</div>';
if(!$pptid || $pptid=='-'){return $notypes;}

          $userid=Vault::get("Users")->uid;
		  $username=Vault::get("Users")->username;
		  $userlevel =getValueById('userlevel', Users::usrTable, $userid);

		  if($userlevel<=9 && $userlevel>=4){

if(Vault::get("Users")->isSuperAdmin()){
		  $query = "SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id='".$pptid."' LIMIT 1 ";	
	}else{
			$pptassignment=getValueById('pptassignment', Users::usrTable, $userid);  
			$pptassignments=array_map('intval', explode(',', $pptassignment));
			$pptassignment = implode("','",$pptassignments);
		  $query = "SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id IN ('".$pptassignment."')  AND id='".$pptid."' LIMIT 1 ";		
	}  
		  
		  $dexp ='';
		  $row = self::$db->first($query); 
		   
if($row) {
$akey=md5(getValueById('akey', Users::usrTable, $userid).'.'.$username.'.'.$row->id.'.'.$userid.'.'.Vault::get("Gist")->pptname);
$ppid = makePassId($pptid);	  		 

$dexp .='<hr><div class="form-group">
                <label for="currlink'.$row->id.'" class="bolder">'.$row->name.'</label>
				<div class="input-group">
                <input readonly type="text" class="form-control copyable ie'.$row->id.'" name="currlink'.$row->id.'" autocomplete="off" autocorrect="off" value="'.SITEURL.'calexp.php?p='.$ppid.'&u='.$username.'&k='.$akey.'">
              <div class="input-group-append"><span class="input-group-text"><a data-id="e'.$row->id.'" class="copyable-btn" href="javascript:void(0);"><span class="glyphicon glyphicon-copy"></span> '.Lang::$say->_COPY.'</a> &nbsp;&nbsp; 
<a href="'.SITEURL.'calexp.php?p='.$ppid.'&u='.$username.'&k='.$akey.'&d=1"><span class="glyphicon glyphicon-download"></span> '.Lang::$say->_DOWNLOAD.'</a></span>			  
			  </div></div></div>';
$resetbtn = '<div class="row margin-top-15" style="padding-bottom:10px;"><div class="col-sm-12"><a href="javascript:void(0);" class="float-left generateakey" data-listcont="feedlinks" data-id="'.$userid.'" data-auth="'.genRequestKey($userid.'generateAkey').'"><span class="glyphicon glyphicon-refresh"></span> '.Lang::$say->_BKG_REGENFEEDKEY.'</a></div></div>';			  
		  }

$notypes = '<div class="alert alert-warning" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div>';
		  return ($row) ? sanitize_output($dexp).$resetbtn : $notypes;
		  }else{return $notypes;}
	  }



      /**
       * Vhrental::exportLinks()
       * @param mixed $userid
       * @return
       */
      public function exportLinks($userid=false)
	  {
          if(!$userid){$userid=Vault::get("Users")->uid;$username=Vault::get("Users")->username;}else
		  {$username=getValueById('username', Users::usrTable, $userid);}
		  $userlevel =getValueById('userlevel', Users::usrTable, $userid);
		  if($userlevel<=9 && $userlevel>=4){

if(Vault::get("Users")->isSuperAdmin()){
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' ORDER BY sort ASC ");	
	}else{
			$pptassignment=getValueById('pptassignment', Users::usrTable, $userid);  
			$pptassignments=array_map('intval', explode(',', $pptassignment));
			$pptassignment = implode("','",$pptassignments);
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id IN ('".$pptassignment."') ORDER BY sort ASC ");		
	}  
		  
		  $dexp ='';
		  $res = self::$db->numrows($query);
if($res) {
$dexp .='<div class="row">
      <div class="col-sm-12">
        <p>'.Lang::$say->_BKG_EXPCALLINKDESC.'</p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6"><div class="form-group">
<label for="changetype_calexp">'.Lang::$say->_PPT_TYPE.'</label>
        <select class="form-control changetype custom-select" name="changetype_calexp" id="changetype_calexp" data-auth="'.genRequestKey($userid.'linkExportCal').'">
          <option value="-">-</option>
          '.Vault::get("Vhrental")->propertyTypeSelectBox().'
        </select>
</div>		
      </div>
    </div>
    <div id="panel_calexp">
      <div class="alert alert-info margin-top-15" role="alert">'.Lang::$say->_PPT_LINKOPTS_R.'</div>
    </div>';			  
		  }

$notypes = '<div class="alert alert-warning" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div>';
		  
		  return ($res) ? sanitize_output($dexp) : $notypes;
		  }else{return '';}
	  }




      /**
       * Vhrental::publicLinks()
       * @param mixed $userid
       * @return
       */
      public function publicLinks($userid=false)
	  {
          if(!$userid){$userid=Vault::get("Users")->uid;$username=Vault::get("Users")->username;}else
		  {$username=getValueById('username', Users::usrTable, $userid);}

$pastYearLimit = CFG_PUBLPASTYEARS;

if(Vault::get("Users")->isSuperAdmin()){
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' ORDER BY sort ASC ");	
	}else{
			$pptassignment=getValueById('pptassignment', Users::usrTable, $userid);  
			$pptassignments=array_map('intval', explode(',', $pptassignment));
			$pptassignment = implode("','",$pptassignments);
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id IN ('".$pptassignment."') ORDER BY sort ASC ");		
	}  
		  
		  $disp ='';
		  $res = self::$db->numrows($query);
if($res){  
if(!Vault::get("Gist")->publiccalview || Vault::get("Gist")->publiccalview=='12'){$defaultplnum = " selected=\"selected\" ";}else{$defaultplnum = "";}
$disp .='<div class="row">
      <div class="col-sm-12">
        <p>'.Lang::$say->_BKG_PUBLICLINKDESC.'</p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6"><div class="form-group">
<label for="changetype_publiclinks">'.Lang::$say->_PPT_TYPE.'</label>
        <select class="form-control custom-select" name="changetype_publiclinks" id="changetype_publiclinks" data-auth="'. genRequestKey('publicLinks'.$userid).'">
          <option value="-">-</option>';
if(!Vault::get("Gist")->publiccalurlonly){$disp .='<option value="all">'.Lang::$say->_GNL_PCV_ALLPPTTYPE.'</option>';}
$disp .= Vault::get("Vhrental")->propertyTypeSelectBox(false,true).'
        </select>
		</div>
      </div>
      <div class="col-sm-2"><div class="form-group">
<label for="changemon_publiclinks">'.Lang::$say->_STARTMONTH.'</label>
        <select class="form-control custom-select" name="changemon_publiclinks" id="changemon_publiclinks" data-auth="'.genRequestKey('publicLinks'.$userid).'">
		<option value="">'.Lang::$say->_DEFAULT.'</option>
          '.Vault::get("Calendar")->monthSelect('none').'
        </select>
		</div>
      </div>
      <div class="col-sm-2"><div class="form-group">
<label for="changeyear_publiclinks">'.Lang::$say->_STARTYEAR.'</label>
        <select class="form-control custom-select" name="changeyear_publiclinks" id="changeyear_publiclinks" data-auth="'.genRequestKey('publicLinks'.$userid).'">
		<option value="">'.Lang::$say->_DEFAULT.'</option>
        </select>
		</div>
      </div>
      <div class="col-sm-2"><div class="form-group">
<label for="changeout_publiclinks">'.Lang::$say->_STARTCALNUM.'</label>
        <select class="form-control custom-select" name="changeout_publiclinks" id="changeout_publiclinks" data-auth="'. genRequestKey('publicLinks'.$userid).'">
			  <option value="" selected="selected">'.Lang::$say->_DEFAULT.'</option>
			  <option value="12">'.Lang::$say->_GNL_PCV_ONEYEAR.'</option>
              <option value="4">'.Lang::$say->_GNL_PCV_FOURMON.'</option>
              <option value="3">'.Lang::$say->_GNL_PCV_THREEMON.'</option>
              <option value="2">'.Lang::$say->_GNL_PCV_TWOMON.'</option>
              <option value="1">'.Lang::$say->_GNL_PCV_ONEMON.'</option>
        </select>
		</div>
      </div>	  
    </div>
    <div id="panel_publiclinks">
      <div class="alert alert-info margin-top-15" role="alert">'.Lang::$say->_PPT_LINKOPTS_R.'</div>
    </div>
  <script type="text/javascript">
var min = new Date().getFullYear(),
	miin = min - '.$pastYearLimit.',
    max = min + 5,
    selectyear = document.getElementById("changeyear_publiclinks");

for (var i = miin; i<=max; i++){
    var opt = document.createElement("option");
    opt.value = i;
    opt.innerHTML = i;
    selectyear.appendChild(opt);
}
</script>';		  
		  }
		  

$notypes = '<div class="alert alert-warning" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div>';
		  
		  return ($res) ? sanitize_output($disp) : $notypes;
	  }
	  



      /**
       * Vhrental::publicLink()
       * @param mixed $userid
       * @return
       */
      public function publicLink($pptid=false,$month=false,$year=false,$calnum=false)
	  {
$notypes = '<div class="alert alert-info margin-top-15" role="alert">' . Lang::$say->_PPT_LINKOPTS_R . '</div>';	
if(!$pptid || $pptid=='-'){return $notypes;}else{if($pptid=='all'){$pptidq='';}else{$pptidq=" AND id='".$pptid."' ";}}
//if($output){$output=$output;}else{$output='xml';}
if($month){$month='&m='.intval($month);}else{$month='';}
if($year){$year='&y='.intval($year);}else{$year='';}
if($calnum){$calnum='&c='.intval($calnum);}else{$calnum='';}
if($month||$year||$calnum){$genqstr='?'.$month.$year.$calnum;$genqstr=str_replace('?&','?',$genqstr);}else{$genqstr='';}

          $userid=Vault::get("Users")->uid;
		  $username=Vault::get("Users")->username;
		  $userlevel =getValueById('userlevel', Users::usrTable, $userid);
		  
if(Vault::get("Users")->isSuperAdmin()){
		  $query = "SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' ".$pptidq." AND hideinpub='0' LIMIT 1 ";	
	}else{
			$pptassignment=getValueById('pptassignment', Users::usrTable, $userid);  
			$pptassignments=array_map('intval', explode(',', $pptassignment));
			$pptassignment = implode("','",$pptassignments);
		  $query = "SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id IN ('".$pptassignment."') ".$pptidq." AND hideinpub='0' LIMIT 1 ";		
	}  
		  $disp ='';
		  $row = self::$db->first($query); 
		   
if($row) {
	  
if($pptid=='all'){
$disp = '<hr><div class="form-group">
				<label class="bolder">'.Lang::$say->_GNL_PCV_ALLPPTTYPE.'</label><div class="form-group">
				<label for="genpublicurl" class="labelnormal">'.Lang::$say->_GNL_PCALURL.'</label>
				<div class="input-group">
                <input readonly type="text" class="form-control copyable icugeneralpublicurl" name="genpublicurl" autocomplete="off" autocorrect="off" value="'.SITEURL.$genqstr.'">
              <div class="input-group-append"><span class="input-group-text"><a data-id="cugeneralpublicurl" class="copyable-btn" href="javascript:void(0);"><span class="glyphicon glyphicon-copy"></span> '.Lang::$say->_COPY.'</a></span></div></div></div>
			  <div class="form-group">
                <label for="currurlex" class="labelnormal">'.Lang::$say->_GNL_PCCALEC.'</label>
			  <div class="area-group"><textarea readonly class="form-control copyable iceall" name="currurlex" rows="4">
<style>.vrbc-embed-container{min-height:420px;position:relative;padding-bottom:7.50%;height:0;overflow:hidden;max-width:100%}.vrbc-embed-container embed,.vrbc-embed-container iframe,.vrbc-embed-container object{position:absolute;top:0;left:0;width:100%;height:100%;background:none;}@media screen and (max-width:595px){.vrbc-embed-container{min-height:420px}} </style><div class="vrbc-embed-container"> <iframe src="'.SITEURL.$genqstr.'" frameborder="0" allowfullscreen></iframe></div>
			  </textarea><a data-id="ceall" class="copyable-btn addon right" href="javascript:void(0);"><span class="glyphicon glyphicon-copy"></span> '.Lang::$say->_COPY.'</a>
			  </div>
			  </div>
			  </div>
			  ';}

else{	  
$ppid = makePassId($row->id);	
if($row->hideinpub){$hideinpub=' <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>';}else{$hideinpub='';}		  

$disp .='<hr><div class="form-group">
				<label class="bolder">'.$row->name.$hideinpub.'</label><div class="form-group">';
if(!$row->hideinpub){
$disp .='<label for="publicurl'.$row->id.'" class="labelnormal">'.Lang::$say->_GNL_PCALURL.'</label>
				<div class="input-group">
                <input readonly type="text" class="form-control copyable icu'.$row->id.'" name="publicurl'.$row->id.'" autocomplete="off" autocorrect="off" value="'.SITEURL.'?p='.$ppid.$month.$year.$calnum.'">
              <div class="input-group-append"><span class="input-group-text"><a data-id="cu'.$row->id.'" class="copyable-btn" href="javascript:void(0);"><span class="glyphicon glyphicon-copy"></span> '.Lang::$say->_COPY.'</a></span></div></div></div>
			  <div class="form-group">
                <label for="currurlex" class="labelnormal">'.Lang::$say->_GNL_PCCALEC.'</label>
			  <div class="area-group"><textarea readonly class="form-control copyable ice'.$row->id.'" name="currurlex" rows="4">
<style>.vrbc-embed-container{min-height:420px;position:relative;padding-bottom:7.50%;height:0;overflow:hidden;max-width:100%}.vrbc-embed-container embed,.vrbc-embed-container iframe,.vrbc-embed-container object{position:absolute;top:0;left:0;width:100%;height:100%;background:none;}@media screen and (max-width:595px){.vrbc-embed-container{min-height:420px}} </style><div class="vrbc-embed-container"> <iframe src="'.SITEURL.'?p='.$ppid.$month.$year.$calnum.'" frameborder="0" allowfullscreen></iframe></div>
			  </textarea><a data-id="ce'.$row->id.'" class="copyable-btn addon right" href="javascript:void(0);"><span class="glyphicon glyphicon-copy"></span> '.Lang::$say->_COPY.'</a>
			  </div>
			  </div>';}
$disp .='</div>';
}

}	//if row	
		  
$top = '<div class="row"><div class="col-sm-12"></div></div>';
$bottom = '
<div class="alert alert-info" role="alert" style="font-size:90%">'.Lang::$say->_GNL_PCEMBEDINSTRUCT.'</div>';
$notypes = '<div class="alert alert-warning margin-top-15" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNONEPUBLIC . '</p></div></div>';
		  
		  return ($row) ? $top.sanitize_output($disp).$bottom : $notypes;
	  }
	  
	  

      /**
       * Vhrental::ptypesAssignmentChecks()
       * @param mixed $userid
       * @return
       */
public function ptypesAssignmentChecks($userid=false)
	  {
          if(!$userid){$userid=Vault::get("Users")->uid;}
		  $pptassignment=getValueById('pptassignment', Users::usrTable, $userid);
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' ORDER BY sort ASC ");
		  $disp ='';
		  $res = self::$db->numrows($query);
		  while ($row = self::$db->fetch($query)) {$active='';
$pptassignments=explode(',',$pptassignment);
if(in_array($row->id,$pptassignments)){$active=' checked="checked"';}else{$active='';}	  

$disp .='<div class="col-sm-6 col-md-6 col-lg-4"><div class="form-group">
				<div class="input-group">
                <label class="checkbox-inline">
                  <input id="ppttypeids-'.$row->id.'" name="ppttypeids[]" type="checkbox" value="'.$row->id.'" '.$active.'>
                  <i></i>'.$row->name.'</label>
</div></div></div>';		  
		  }
		  
$top = '<div class="row" style="padding-bottom:10px;">';
$bottom = '</div>';
$notypes = '<div class="alert alert-warning" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div>';
		  
		  return ($res) ? $top.sanitize_output($disp).$bottom : $notypes;
	  }





      /**
       * Vhrental::ptypesAssignments()
       * @param mixed $userid
       * @return
       */
public function ptypesAssignments($userid=false)
	  {
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' ORDER BY sort ASC ");
		  $disp ='';
		  $res = self::$db->numrows($query);		  		  
if($userid){$pptassignment=getValueById('pptassignment', Users::usrTable, $userid);}
		  while ($row = self::$db->fetch($query)) {
		  $active='';
if($userid){$pptassignments=explode(',',$pptassignment);
		  if(in_array($row->id,$pptassignments)){$active=' checked="checked"';}else{$active='';}
}else{$active='';}

$disp .='<div class="col-sm-6 col-md-6 col-lg-4"><div class="form-group">
				<div class="input-group">
                <label class="checkbox-inline">
                  <input id="ppttypeids-'.$row->id.'" name="ppttypeids[]" type="checkbox" value="'.$row->id.'" '.$active.'>
                  <i></i>'.$row->name.'</label>
</div></div></div>';		  
		  }
		  
$top = '<div class="row"><div class="col-md-12"><label>'.Lang::$say->_UR_ASSIGNPPTY.'</label></div></div><div class="row" style="padding-bottom:10px;">';
$bottom = '</div><hr class="slim">';
$notypes = '<div class="alert alert-warning" role="alert">
<div class="content">
<div class="header">' . Lang::$say->_ALERT . '</div>
<p>' . Lang::$say->_PPT_TYPESNOSETUP . '</p></div></div><hr class="slim">';
		  
		  return ($res) ? $top.sanitize_output($disp).$bottom : $notypes;
	  }

      /**
       * Vhrental::anyAssigned()
       * @param mixed $userid
       * @return
       */
public function anyAssigned()
	  {
if(Vault::get("Users")->isSuperAdmin()){
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n ");	
	}else{
		$pptassignment=getValueById('pptassignment', Users::usrTable, Vault::get("Users")->uid);
		$pptassignments=array_map('intval', explode(',', $pptassignment));
		$pptassignment = implode("','",$pptassignments);		
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id IN ('".$pptassignment."') ");		
	}
		  $res = self::$db->numrows($query);
		  return ($res) ? true : false;
}

      /**
       * Vhrental::countAssigned()
       * @param mixed $userid
       * @return
       */
public function countAssigned($userid)
	  {

if(getValueById("userlevel", Users::usrTable, $userid)==9){
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' ");	
}else{		  
$pptassignment=getValueById('pptassignment', Users::usrTable, $userid); 
$pptassignments=array_map('intval', explode(',', $pptassignment));
$pptassignment = implode("','",$pptassignments);		  
		  $query = self::$db->query("SELECT * FROM " . self::pptyTable
		  . "\n WHERE publish='1' AND id IN ('".$pptassignment."') ");
}
		  $res = self::$db->numrows($query);
		  return ($res) ? $res : 0;
}	  




 	
  }
?>