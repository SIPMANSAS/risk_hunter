<?php
  /**
   * Gist Class
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: class.gist.php, v1.1.0 Feb 2018 transinova $
   */
  
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');
  
  class Gist
  {
      
	  const cfgTable = "sys_config";
	  const lngTable = "sys_language";
	  const pptcTable = "property_config";
	  const etplTable = "sys_mailtemplates";
	  
      public $year = null;
      public $month = null;
      public $day = null;
	  
      public static $language;
	  public $langlist;
	  
	  
      /**
       * Gist::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          $this->getConfig();		  
		  ($this->dtz) ? date_default_timezone_set($this->dtz) : date_default_timezone_set('GMT');		  
          $this->year = (get('year')) ? get('year') : strftime('%Y');
          $this->month = (get('month')) ? get('month') : strftime('%m');
          $this->day = (get('day')) ? get('day') : strftime('%d');          
          return mktime(0, 0, 0, $this->month, $this->day, $this->year);
		  
      }
	
      /**
       * Gist::getConfig()
       *
       * @return
       */
      private function getConfig()
      {
 		  $sql = "SELECT * FROM " . self::pptcTable;
          $row = Vault::get("Database")->first($sql);
		  $sql = "SELECT * FROM " . self::cfgTable;
          $cfg = Vault::get("Database")->first($sql);

		  $this->pptname = $row->name;
		  $this->pptemail = $row->email;	
		  $this->pptphone = $row->phone;
		  $this->pptaddress = $row->address;
		  $this->pptlock = $row->locked;		  
		  $this->dtz = CFG_TZ;
		  $this->lang = $cfg->sysdeflanguage;
		  $this->sysuicorners = $cfg->sysuicorners;
		  $this->site_url = CFG_URL;
		  $this->site_dir = CFG_DIR;
		  $this->flood = CFG_LGNFLOOD;
		  $this->attempt = CFG_LGNATTEMPT;
		  $this->perpage = 50;	
		  $this->mailer= 'PHP';
		  $this->weekstart = CFG_WEEKSTART;
		  $this->appname = $cfg->sysappname;
		  $this->appver = $cfg->sysappver;
		  $this->notifyoncreate = $cfg->notify_oncreate;
		  $this->notifyonupdate = $cfg->notify_onupdate;
		  $this->notifyondelete = $cfg->notify_ondelete;
		  $this->showpubliccal = $cfg->show_publiccal;
		  $this->expinfostatus = $cfg->expinfo_status;
		  $this->expinfoguestname = $cfg->expinfo_guestname;
		  $this->expinfoguestnum = $cfg->expinfo_guestnum;
		  $this->expinfoguestcountry = $cfg->expinfo_guestcountry;
		  $this->expinforemarks = $cfg->expinfo_remarks;
		  $this->expinfopptaddress = $cfg->expinfo_pptaddress;
		  $this->signature = '<b>'.$row->name.'</b><br />'.$row->address.'<br />'.$row->phone.'<br />'.$row->email.'<br />'.CFG_URL.'/'.CFG_DIR;
		  $this->publiccalview = $cfg->publiccal_view;
		  $this->publiccalurlonly = $cfg->publiccal_urlonly;
		  
		  $this->site_curr = CFG_CURRENCY;
		  $this->site_currsym = CFG_CURRENCYSYMBOL;		  
		  if(CFG_DECIMALSEPARATOR=='.'){
			    $this->site_tsep = ',';
				$this->site_dsep = CFG_DECIMALSEPARATOR;
			  }else{
			    $this->site_tsep = '.';
				$this->site_dsep = ',';
			  }

      }

      /**
       * Gist::setConfig()
       * 
       * @return
       */
	  public function setConfig()
	  {

		  Sift::checkPost('propertyname',Lang::$say->_PPT_NAME_R);
		  Sift::checkPost('propertyemail',Lang::$say->_PPT_EMAIL_R);
		  if (!isEmailValid($_POST['propertyemail'])){
			  Sift::$msgs['propertyemail'] = Lang::$say->_UR_EMAIL_R2;}
			  
		  if(isset($_POST['propertylock'])){$propertylock=intval($_POST['propertylock']);}else{$propertylock=0;}
		  
		  if(isset($_POST['notifyoncreate'])){$notifyoncreate=intval($_POST['notifyoncreate']);}else{$notifyoncreate=0;}
		  if(isset($_POST['notifyonupdate'])){$notifyonupdate=intval($_POST['notifyonupdate']);}else{$notifyonupdate=0;}
		  if(isset($_POST['notifyondelete'])){$notifyondelete=intval($_POST['notifyondelete']);}else{$notifyondelete=0;}
		  if(isset($_POST['showpubliccal'])){$showpubliccal=intval($_POST['showpubliccal']);}else{$showpubliccal=0;}
		  if(isset($_POST['publiccalview'])){$publiccalview=intval($_POST['publiccalview']);}else{$publiccalview=12;}
		  if(isset($_POST['expinfostatus'])){$expinfostatus=intval($_POST['expinfostatus']);}else{$expinfostatus=0;}
		   if(isset($_POST['sysdeflanguage'])){$sysdeflanguage=sanitize($_POST['sysdeflanguage']);}else{$sysdeflanguage='en';}
if(isset($_POST['sysuicorners'])){$sysuicorners=intval($_POST['sysuicorners']);}else{$sysuicorners=0;}	   
		  if(isset($_POST['expinfoguestname'])){$expinfoguestname=intval($_POST['expinfoguestname']);}else{$expinfoguestname=0;}
		  if(isset($_POST['expinfoguestnum'])){$expinfoguestnum=intval($_POST['expinfoguestnum']);}else{$expinfoguestnum=0;}
		  if(isset($_POST['expinfoguestcountry'])){$expinfoguestcountry=intval($_POST['expinfoguestcountry']);}else{$expinfoguestcountry=0;}
		  if(isset($_POST['expinforemarks'])){$expinforemarks=intval($_POST['expinforemarks']);}else{$expinforemarks=0;}
		  if(isset($_POST['expinfopptaddress'])){$expinfopptaddress=intval($_POST['expinfopptaddress']);}else{$expinfopptaddress=0;}
		  if(isset($_POST['publiccalurlonly'])){$publiccalurlonly=intval($_POST['publiccalurlonly']);}else{$publiccalurlonly=0;}
			  
		  if (empty(Sift::$msgs)) {
			  $data = array(
					  'name' => sanitize($_POST['propertyname']), 
					  'email' => sanitize($_POST['propertyemail']),
					  'phone' => sanitize($_POST['propertyphone']),
					  'address' => sanitize($_POST['propertyaddress']),
					  'locked' => $propertylock
			  );
			  $datac = array(
			  		'notify_oncreate' => $notifyoncreate,
			  		'notify_onupdate' => $notifyonupdate,
					'notify_ondelete' => $notifyondelete,
					'show_publiccal' => $showpubliccal,
					'expinfo_status' => $expinfostatus,
					'expinfo_guestname' => $expinfoguestname,
					'expinfo_guestnum' => $expinfoguestnum,
					'expinfo_guestcountry' => $expinfoguestcountry,
					'expinfo_remarks' => $expinforemarks,
					'expinfo_pptaddress' => $expinfopptaddress,
					'publiccal_view' => $publiccalview,
					'publiccal_urlonly' => $publiccalurlonly,
					'sysdeflanguage' => $sysdeflanguage,
					'sysuicorners' => $sysuicorners
					
			  );
			  
			  if(Vault::get("Database")->update(self::cfgTable, $datac) &&
			  Vault::get("Database")->update(self::pptcTable, $data))
			  
			  {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgSuccess(Lang::$say->_PPT_CGUPDATED, false,4000,false,true);
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


 

	  public  function langList()
	  {
		  
		  $sql = "SELECT * FROM " . self::lngTable . " ORDER BY sort";
          $row = Vault::get("Database")->fetch_all($sql);
          
		  return ($row) ? $this->langlist = $row : 0;
	  }
 
 	  /**
	   * Gist:::validLang()
	   * 
       * @param mixed $abbr
       * @return
       */

	  public function validLang($abbr)
	  {
	
		  $result = array();
		  foreach ($this->langList() as $val) {
			  if ($val->abbr == $abbr) {
				  $result[] = $val;
			  }
		  }
		  return ($result) ? 1 : 0;
	
	  }




 	  	   	  	  
      /**
       * Gist::getShortDate()
       * 
       * @return
       */ 
      public static function getShortDate($selected = false)
	  {
	
		  $format = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? "%#d" : "%e";
	
          $arr = array(
				 '%m-%d-%Y' => strftime('%m-%d-%Y') . ' (MM-DD-YYYY)',
				 $format . '-%m-%Y' => strftime($format . '-%m-%Y') . ' (D-MM-YYYY)',
				 '%m-' . $format . '-%y' => strftime('%m-' . $format . '-%y') . ' (MM-D-YY)',
				 $format . '-%m-%y' => strftime($format . '-%m-%y') . ' (D-MMM-YY)',
				 '%d %b %Y' => strftime('%d %b %Y')
		  );
		  
		  $shortdate = '';
		  foreach ($arr as $key => $val) {
              if ($key == $selected) {
                  $shortdate .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $shortdate .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $shortdate;
      }
	  
      /**
       * Gist::getLongDate()
       * 
       * @return
       */ 	
	  public static function getLongDate($selected = false)
	  {
		  $format = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? "%#d" : "%e";
		  $arr = array(
			  '%B %d, %Y %I:%M %p' => strftime('%B %d, %Y %I:%M %p'),
			  '%d %B %Y %I:%M %p' => strftime('%d %B %Y %I:%M %p'),
			  '%B %d, %Y' => strftime('%B %d, %Y'),
			  '%d %B, %Y' => strftime('%d %B, %Y'),
			  '%A %d %B %Y' => strftime('%A %d %B %Y'),
			  '%A %d %B %Y %H:%M' => strftime('%A %d %B %Y %H:%M'),
			  '%a %d, %B' => strftime('%a %d, %B'));
	
		  $html = '';
		  foreach ($arr as $key => $val) {
			  if ($key == $selected) {
				  $html .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
			  } else
				  $html .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $html;
	  }

      /**
       * Gist::getTimeFormat()
       * 
       * @return
       */ 	  
      public static function getTimeFormat($selected = false)
	  {
          $arr = array(
				'%I:%M %p' => strftime('%I:%M %p'),
				'%I:%M %P' => strftime('%I:%M %P'),
				'%H:%M' => strftime('%H:%M'),
				'%k' => strftime('%k'),
		  );
		  
		  $longdate = '';
		  foreach ($arr as $key => $val) {
              if ($key == $selected) {
                  $longdate .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $longdate .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $longdate;
      }
	  
      /**
       * Gist::monthList()
       * 
       * @return
       */ 	  
	  public static function monthList($list = true, $long = true, $selected = false)
	  {
		  $selected = is_null(get('month')) ? strftime('%m') : get('month');
	
		  if ($long) {
			  $arr = array(
				  '01' => Lang::$say->_JAN,
				  '02' => Lang::$say->_FEB,
				  '03' => Lang::$say->_MAR,
				  '04' => Lang::$say->_APR,
				  '05' => Lang::$say->_MAY,
				  '06' => Lang::$say->_JUN,
				  '07' => Lang::$say->_JUL,
				  '08' => Lang::$say->_AUG,
				  '09' => Lang::$say->_SEP,
				  '10' => Lang::$say->_OCT,
				  '11' => Lang::$say->_NOV,
				  '12' => Lang::$say->_DEC);
		  } else {
			  $arr = array(
				  '01' => Lang::$say->_JA_,
				  '02' => Lang::$say->_FE_,
				  '03' => Lang::$say->_MA_,
				  '04' => Lang::$say->_AP_,
				  '05' => Lang::$say->_MY_,
				  '06' => Lang::$say->_JU_,
				  '07' => Lang::$say->_JL_,
				  '08' => Lang::$say->_AU_,
				  '09' => Lang::$say->_SE_,
				  '10' => Lang::$say->_OC_,
				  '11' => Lang::$say->_NO_,
				  '12' => Lang::$say->_DE_);
		  }
		  $html = '';
		  if ($list) {
			  foreach ($arr as $key => $val) {
				  $html .= "<option value=\"$key\"";
				  $html .= ($key == $selected) ? ' selected="selected"' : '';
				  $html .= ">$val</option>\n";
			  }
		  } else {
			  $html .= '"' . implode('","', $arr) . '"';
		  }
		  unset($val);
		  return $html;
	  }

      /**
       * Gist::weekList()
       * 
       * @return
       */ 	  
	  public static function weekList($list = true, $long = true, $selected = false)
	  {
		  if ($long) {
			  $arr = array(
				  '1' => Lang::$say->_SUNDAY,
				  '2' => Lang::$say->_MONDAY,
				  '3' => Lang::$say->_TUESDAY,
				  '4' => Lang::$say->_WEDNESDAY,
				  '5' => Lang::$say->_THURSDAY,
				  '6' => Lang::$say->_FRIDAY,
				  '7' => Lang::$say->_SATURDAY);
		  } else {
			  $arr = array(
				  '1' => Lang::$say->_SUN,
				  '2' => Lang::$say->_MON,
				  '3' => Lang::$say->_TUE,
				  '4' => Lang::$say->_WED,
				  '5' => Lang::$say->_THU,
				  '6' => Lang::$say->_FRI,
				  '7' => Lang::$say->_SAT);
		  }
	
		  $html = '';
		  if ($list) {
			  foreach ($arr as $key => $val) {
				  $html .= "<option value=\"$key\"";
				  $html .= ($key == $selected) ? ' selected="selected"' : '';
				  $html .= ">$val</option>\n";
			  }
		  } else {
			  $html .= '"' . implode('","', $arr) . '"';
		  }
	
		  unset($val);
		  return $html;
	  }
	  
      /**
       * Gist::yearList()
	   *
       * @param mixed $start_year
       * @param mixed $end_year
       * @return
       */
	  function yearList($start_year, $end_year)
	  {
		  $selected = is_null(get('year')) ? date('Y') : get('year');
		  $r = range($start_year, $end_year);
		  
		  $select = '';
		  foreach ($r as $year) {
			  $select .= "<option value=\"$year\"";
			  $select .= ($year == $selected) ? ' selected="selected"' : '';
			  $select .= ">$year</option>\n";
		  }
		  return $select;
	  }


	  				  
      /**
       * Gist::getRowById()
       * 
       * @param mixed $table
       * @param mixed $id
       * @param bool $and
       * @param bool $is_admin
       * @return
       */
      public static function getRowById($table, $id, $and = false, $is_admin = true)
      {
          $id = sanitize($id, 8, true);
          if ($and) {
              $sql = "SELECT * FROM " . (string )$table . " WHERE id = '" . Vault::get("Database")->escape((int)$id) . "' AND " . Vault::get("Database")->escape($and) . "";
          } else
              $sql = "SELECT * FROM " . (string )$table . " WHERE id = '" . Vault::get("Database")->escape((int)$id) . "'";

          $row = Vault::get("Database")->first($sql);

          if ($row) {
              return $row;
          } else {
              if ($is_admin)
                  Sift::error("You have selected an Invalid Id - #" . $id, "Gist::getRowById()");
          }
      }

      /**
       * Gist::getRow()
       * 
       * @param mixed $table
       * @param mixed $where
	   * @param bool $is_admin
       * @return
       */
      public static function getRow($table, $where, $what, $is_admin = true)
      {
          $sql = "SELECT * FROM " . (string )$table . " WHERE $where = '" . $what . "'";
          $row = Vault::get("Database")->first($sql);

          if ($row) {
              return $row;
          } else {
              if ($is_admin)
                  Sift::error("You have selected an Invalid Value - #" . $what, "Gist::getRow()");
          }
      }



      /**
       * Gist::setLocalet()
       * 
       * @return
       */
	  public function setLocale()
	  {
		  return explode(',', $this->locale);
	  }
	  


	  
      /**
       * Gist::checkTable()
       * 
	   * @param mixed $tablename
       * @return
       */
	  public static function checkTable($tablename)
	  {
		  return Vault::get("Database")->numrows(Vault::get("Database")->query("SHOW TABLES LIKE '" . $tablename . "'")) ? true : false;
	  }


      /**
       * Gist::getEmTemplatList()
       * 
       * @return
       */
	  public function getEmTemplatList()
	  {
		  $sql = "SELECT id, name_en as name,subject". Lang::$lang." as subject FROM " . self::etplTable . " ORDER BY name_en ASC";
		  $row = Vault::get("Database")->fetch_all($sql);
		  
if($row){
	$disp ='<table class="restable table table-hover table-framed">
						  <thead>
						  <tr>
						  <th>#</th>
						  <th>'.Lang::$say->_GNL_EMAILTPLNAME.'</th>
						  <th>'.Lang::$say->_GNL_EMAILTPLSBJ.'</th>		
						  <th>'.Lang::$say->_ACTIONS.'</th>				  
						  </tr>
							</thead><tbody>';
	foreach ($row as $emt) {
						  $disp .='<tr>
						  <td>'.$emt->id.'</td>
						  <td>'.$emt->name.'</td>
						  <td>'.$emt->subject.'</td>
						  <td><a class="itemaction itemedit" data-listcont="emailtpledit" data-id="'.$emt->id.'" data-option="editEmTemplate" href="javascript:void(0);" data-name="'.$emt->name.'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
						  ';
	}//foreach
	unset($emt);
	$disp .='</tbody></table>';
}//if row
	
		  return ($row) ? $disp : '';
	  }


	  /**
	   * Gist::editFormEmTemplate()
	   * 
	   * @param mixed $id
	   * @return
	   */
	  public function editFormEmTemplate($id)
	  {
          $id = sanitize($id);
          $id = Vault::get("Database")->escape($id);

		  $sql = "SELECT id, name_en as name,subject". Lang::$lang." as subject,help_en as help, body". Lang::$lang." as body FROM " . self::etplTable . " WHERE id = '" . $id . "' ";
          $row = Vault::get("Database")->first($sql);

$disp = '
        <form class="form" id="form_emailtpledit">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="fname">'.Lang::$say->_GNL_EMAILTPLSBJ.' '.Lang::$say->_FOR.': '.$row->name.' <span class="badge badge-secondary">'.Vault::get("Lang")->currlang.'</label>
                <input name="subject'.Lang::$lang.'" type="text" class="form-control" value="'.$row->subject.'">
              </div>
            </div>
          </div>

          <div class="row">
		  <div class="col-sm-12">
		  <div class="form-group">
		  <label for="body'.Lang::$lang.'">'.Lang::$say->_GNL_EMAILTPLBODY.' <span class="badge badge-secondary">'.Vault::get("Lang")->currlang.'</label>
			<textarea name="body'.Lang::$lang.'">'.$row->body.'</textarea>
		  </div>
		  </div>
          </div>
          <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
              <div class="form-group">
              <input type="hidden" name="id" value="'.$row->id.'">
                <input type="hidden" name="updateEmTemplate" value="'.genRequestKey('updateEmTemplate'.$row->id).'">
                <button id="save_emailtpledit" data-after="none" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.Lang::$say->_SAVE.'</button>
              </div>
            </div>
          </div>
        </form>
        <div id="msg_emailtpledit"></div>
<script src="assets/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {

tinymce.init({
  selector: "textarea",
    setup: function (editor) {
        editor.on("change", function () {
            tinymce.triggerSave();
        });
    },  
  height: 200,
  menubar: false,
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table contextmenu paste code"
  ],
  toolbar: "undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code",
  content_css: "assets/css/editor.css"
});

$(document).on("focusin", function(e) {
    if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
    }
});

});
// ]]>
</script>
';

          return ($row) ? sanitize_output($disp) : false;
	  }	



	  /**
	   * Gist::saveEmTemplate()
	   * 
	   * @return
	   */
	  public function saveEmTemplate()
	  {

		  Sift::checkPost('subject' . Lang::$lang, Lang::$say->_GNL_EMAILTPLSBJ_R);
		  Sift::checkPost('body' . Lang::$lang, Lang::$say->_GNL_EMAILTPLBODY_R);
	
		  if (empty(Sift::$msgs)) {
			  $data = array(
				  'subject' . Lang::$lang => sanitize($_POST['subject' . Lang::$lang]),
				  'body' . Lang::$lang => $_POST['body' . Lang::$lang]
				  );
	

			 Vault::get("Database")->update(self::etplTable, $data, "id='" . Sift::$id . "'");

	
			  if (Vault::get("Database")->affected()) {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgSuccess(Lang::$say->_GNL_EMAILTPLUPDATED, false);
				  $json['content'] = $this->getEmTemplatList();

			  } else {
				  $json['status'] = 'info';
				  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  }
	  }




      /**
       * Gist::getLanguageList()
       * 
       * @return
       */
      public function getLanguageList()
	  {

		  $sql = "SELECT * FROM " . self::lngTable . " ORDER BY sort ASC ";
		  $languages = Vault::get("Database")->fetch_all($sql);
		  
if($languages){
	
		  $disp ='<ul id="languageList" class="sortablelist">';
		  
		  foreach ($languages as $row)  {

if(isset($_COOKIE['LANGUAGE_VRBC'])){
	if($row->abbr==$_COOKIE['LANGUAGE_VRBC']){$curlang=' <span class="recstatus"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.Lang::$say->_CURRENT.'</span>';}else{$curlang='';}
	}else{$curlang='';}
if($row->abbr==$this->lang){$deflang=' <span class="recstatus"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> '.Lang::$say->_DEFAULT.'</span>';}else{$deflang='';}
if(!file_exists(BASEPATH . 'lang/' . $row->abbr . "/lang.xml")){$langwarn='<span class="recstatus"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> '.Lang::$say->_LANG_ADDLANGFILE.' ('. $row->abbr.')</span> ';$edphrases='';}else{$langwarn='';$edphrases=' <a href="settings.php?do=langphrases&abbr='. $row->abbr.'"><span class="glyphicon glyphicon-text-size" aria-hidden="true"></span></a>';}
				  
			  if($row->abbr=='en'){$deletebtn='';}else{$deletebtn=' <a class="itemaction itemdelete" data-listcont="langdel" data-id="'.$row->id.'" data-option="deleteLanguage" href="javascript:void(0);" data-name="'.$row->name.'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';}

			  if(!$row->publish){$hidden='<span class="glyphicon glyphicon-ban-circle recstatus" aria-hidden="true"></span>';}else{$hidden='';}
			  $disp .='<li id="langitem_'.$row->id.'" class="dd-item"><div class="dd-holder">
			  <div class="row"><div class="col-sm-8">
			  <span class="dd-handle"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></span>'.$row->name.' ('.$row->abbr.')'.$curlang.$deflang.$hidden.$langwarn.'</div><div class="col-sm-4">
			  <a class="itemaction itemedit" data-listcont="langedit" data-id="'.$row->id.'" data-option="editLanguage" href="javascript:void(0);" data-name="'.$row->name.'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> '.$edphrases.$deletebtn.'
			  </div></div></div></li>';

		  }
		  $disp .='</ul>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $( "#languageList" ).sortable({
      handle: ".dd-handle",
	  placeholder: "dd-placeholder",
update: function (event, ui) {
        var typelist = $(this).sortable("serialize");
		typelist+= "&sortLanguageList='.genRequestKey('sortLanguageList').'";
        $.ajax({
            data: typelist,
            type: "post",
			dataType: "json",
            url: siteurl+"controller/controller.php",
			success: function(json){
                $(".msg_langedit").html(json.message);
        	}			
        });
    }	  
    });
});
// ]]>
</script>	  
		  ';
}else{
$disp='';  }
		  return ($languages) ? sanitize_output($disp) : false;
	  }
	  

	  /**
	   * Gist::editFormLanguage()
	   * 
	   * @param mixed $id
	   * @return
	   */
	  public function editFormLanguage($id)
	  {
          $id = sanitize($id);
          $id = Vault::get("Database")->escape($id);

		  $sql = "SELECT * FROM " . self::lngTable . " WHERE id = '" . $id . "' ";
          $row = Vault::get("Database")->first($sql);
if($row->publish){$publish=' checked="checked"';}else{$publish='';}
$direction1='';$direction2='';
if($row->direction=='ltr'){$direction1=' checked="checked"';}
if($row->direction=='rtl'){$direction2=' checked="checked"';}
$disp = '
<form class="form" id="form_langedit">
<div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="name">'.Lang::$say->_LANGNAME.'</label>
				<div class="input-group"><div class="input-group-prepend"><span class="input-group-text">'.$row->abbr.'</span></div>
                <input type="text" class="form-control" name="name" value="'.$row->name.'">
              </div></div>
            </div>
<div class="col-sm-3">
<label for="direction">'.Lang::$say->_LANGDIRECTION.'</label>
		<div class="inline-group">        
            <label class="labelnormal radio-inline">
              <input name="direction" value="ltr" type="radio"'.$direction1.'>
              <i></i>LTR</label>
            <label class="labelnormal radio-inline">
              <input name="direction" value="rtl" type="radio"'.$direction2.'>
              <i></i>RTL</label>
          </div>
</div>     			 
<div class="col-sm-3"><label class="hidden-xs">&nbsp;</label>
<div class="form-group">
    <label class="checkbox-inline">
      <input name="publish" type="checkbox" value="1" '.$publish.'> <i></i>'.Lang::$say->_PUBLISH.'
    </label>
 
</div> 
</div>
<div class="col-sm-2"><label class="hidden-xs">&nbsp;</label> 
  <div class="form-group">
  <input type="hidden" name="updateLanguage" value="'.genRequestKey($row->id.'updateLanguage').'">
  <input type="hidden" name="id" value="'.$row->id.'">
  <button id="save_langedit" data-after="none" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.Lang::$say->_SAVE.'</button>
</div>    
</div>
</div>  
</form>
<div id="msg_langedit"></div>

';

          return ($row) ? sanitize_output($disp) : false;
	  }

      /**
       * Gist::reorderLanguageList()
       * 
       * @return
       */
	  public function reorderLanguageList()
	  {
		$i = 0; $updated=0;

		foreach ($_POST['langitem'] as $value) {
			$data = array(
					  'sort' => $i
			  );
			Vault::get("Database")->update(self::lngTable, $data, "id='" . $value . "'");
			if(Vault::get("Database")->affected()){$updated++;}
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
       * Gist::getLanguageMenu()
       * 
       * @return
       */
      public function getLanguageMenu($activeid=false)
	  {//WHERE publish=1

		  $sql = "SELECT * FROM " . self::lngTable . " WHERE publish=1  ORDER BY sort ASC ";
		  $languages = Vault::get("Database")->fetch_all($sql);
		  
if($languages){	
		  $disp ='';		  
		  foreach ($languages as $row)  {
			  if(isset($_COOKIE['LANGUAGE_VRBC'])){
				   if($_COOKIE['LANGUAGE_VRBC']==$row->abbr){
				  	$ceked='<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';}
				  		else{$ceked='';}
				  }else{
					if($this->lang ==$row->abbr){
					 $ceked='<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';}else{$ceked='';}
					  }
if(file_exists(BASEPATH . 'lang/' . $row->abbr . "/lang.xml")){
$disp .= '<a class="dropdown-item langitem" href="javascript:void(0);" data-lang="'.$row->abbr.'">'.$row->name.' ('.$row->abbr.') '.$ceked.'</a>';}

		  }
unset($row);
}else{
$notypes='<div class="nav-item">'.Lang::$say->_LANGNAME_R.'</div>';  }
		  return ($languages) ? sanitize_output($disp) : $notypes;
	  }

      /**
       * Gist::getLanguageSelect()
       * 
       * @return
       */
      public function getLanguageSelect()
	  {

		  $sql = "SELECT * FROM " . self::lngTable . " WHERE publish=1  ORDER BY sort ASC ";
		  $languages = Vault::get("Database")->fetch_all($sql);
		  
if($languages){
	
		  $disp ='';
		  
		  foreach ($languages as $row)  {
if(file_exists(BASEPATH . 'lang/' . $row->abbr . "/lang.xml")){
if($row->abbr==$this->lang){$selected=' selected="selected"';}else{$selected='';}
			  $disp .='<option'.$selected.' value="'.$row->abbr.'">'.$row->name.' ('.$row->abbr.') </option>';
}
		  }
 unset($row);
}else{
$disp='';}
		  return ($languages) ? sanitize_output($disp) : false;
	  }

	  /**
	   * Gist::updateLanguage()
	   * 
	   * @return
	   */
	  public function updateLanguage()
	  {
		  
		  Sift::checkPost('name', Lang::$say->_LANGNAME_R);
		  if(isset($_POST['publish'])){$publish=intval($_POST['publish']);}else{$publish=0;}
		  
		  if (empty(Sift::$msgs)) {
			  $data = array(
				  'name' => sanitize($_POST['name']),
				  'direction' => strtolower(sanitize($_POST['direction'],3)),  
				  'publish' => $publish
			  );

			  Vault::get("Database")->update(self::lngTable, $data, "id='" . Sift::$id . "'");
	
			  if(Vault::get("Database")->affected()) {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgSuccess(Lang::$say->_LANG_UPDATED, false,4000,false,true);
				  $json['content'] = $this->getLanguageList();
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
	   * Gist::addLanguage()
	   *
       * @return
       */
	  public function addLanguage()
	  {
	
		  Sift::checkPost('name', Lang::$say->_LANGNAME_R);
		  Sift::checkPost('abbr', Lang::$say->_LANGABBR_R);
	
		  if (Vault::get("Gist")->validLang($_POST['abbr']))
			  Sift::$msgs['abbr'] = Lang::$say->_LANGABBR_EXISTS;
			
			if(isset($_POST['publish'])){$publish=intval($_POST['publish']);}else{$publish=0;}
	
		  if (empty(Sift::$msgs)) {
			  $abbr = strtolower(sanitize($_POST['abbr'],5));
			  $abbr = str_replace(' ','_',$abbr);
			  
			  Vault::get("Database")->query("LOCK TABLES " . self::etplTable . " WRITE");

if(!$this->isFieldExists(self::etplTable,'subject_' . $abbr)){			  
			  Vault::get("Database")->query("ALTER TABLE " . self::etplTable . " ADD COLUMN subject_$abbr VARCHAR(255) NOT NULL AFTER subject_en");}

if(!$this->isFieldExists(self::etplTable,'body_' . $abbr)){
			  Vault::get("Database")->query("ALTER TABLE " . self::etplTable . " ADD COLUMN body_$abbr TEXT AFTER body_en");}

			  Vault::get("Database")->query("UNLOCK TABLES");
	
			  if ($email_templates = Vault::get("Database")->fetch_all("SELECT * FROM " . self::etplTable)) {
				  foreach ($email_templates as $row) {
					  $data = array(
						  'subject_' . $abbr => $row->subject_en,
						  'body_' . $abbr => $row->body_en);
	
					  Vault::get("Database")->update(self::etplTable, $data, "id = {$row->id}");
				  }
				  unset($data, $row);
			  }
			  
			 
			  Vault::get("Database")->query("LOCK TABLES " . Vhrental::blksTable . " WRITE");
if(!$this->isFieldExists(Vhrental::blksTable,'title_en' . $abbr)){			  
			  Vault::get("Database")->query("ALTER TABLE " . Vhrental::blksTable . " ADD COLUMN title_$abbr VARCHAR(50) NULL AFTER title_en");}
			  Vault::get("Database")->query("UNLOCK TABLES");
			  
			  if ($ppt_types = Vault::get("Database")->fetch_all("SELECT * FROM " . Vhrental::blksTable)) {
				  foreach ($ppt_types as $row) {
					  $data = array(
						  'title_' . $abbr => $row->title_en);	
					  Vault::get("Database")->update(Vhrental::blksTable, $data, "id = {$row->id}");
				  }
				  unset($data, $row);
			  }			  

			  $langdata = array(
				  'name' => sanitize($_POST['name']),
				  'abbr' => strtolower(sanitize($_POST['abbr'],5)),
				  'direction' => strtolower(sanitize($_POST['direction'],3)),
				  'publish' => $publish
				  );
				  
			  Vault::get("Database")->insert(self::lngTable, $langdata);
			  
				if (!file_exists(BASEPATH .Lang::langdir.'/'.$abbr)) {//BASEPATH .Lang::langdir.'/en' . "/lang-master.xml"
    			if(mkdir(BASEPATH .Lang::langdir.'/'.$abbr, 0755, true)){
					copy(BASEPATH .Lang::langdir.'/en' . "/lang-master.xml",BASEPATH .Lang::langdir.'/'.$abbr.'/lang.xml');
					copy(BASEPATH .Lang::langdir.'/en' . "/index.php",BASEPATH .Lang::langdir.'/'.$abbr.'/index.php');
					}
				}			  
	
			  $json['status'] = 'success';
			  $json['message'] = Sift::msgSuccess(Lang::$say->_LANG_ADDED, false,false,false,false);
			  $json['content'] = $this->getLanguageList();
			  print json_encode($json);
	
		  } else {
			  $json['status'] = 'failed';
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  }
	  }


	  /**
	   * Gist::removeLanguage()
	   *
       * @return
       */
	  public function removeLanguage()
	  {
	  
	
		  $abbr = getValueById("abbr", self::lngTable, Sift::$id);
	
		  Vault::get("Database")->query("LOCK TABLES " . self::etplTable . " WRITE");
		  
		  if($this->isFieldExists(self::etplTable,'subject_' . $abbr)){
		  Vault::get("Database")->query("ALTER TABLE " . self::etplTable . " DROP COLUMN subject_" . $abbr);
		  }

		  if($this->isFieldExists(self::etplTable,'body_' . $abbr)){		  
		  Vault::get("Database")->query("ALTER TABLE " . self::etplTable . " DROP COLUMN body_" . $abbr);
		  }	  
		  Vault::get("Database")->query("UNLOCK TABLES");	  
		  
		  Vault::get("Database")->query("LOCK TABLES " . Vhrental::blksTable . " WRITE");
		  if($this->isFieldExists(Vhrental::blksTable,'title_' . $abbr)){	
		  Vault::get("Database")->query("ALTER TABLE " . Vhrental::blksTable . " DROP COLUMN title_" . $abbr);
		  }
		  Vault::get("Database")->query("UNLOCK TABLES");


	  }

	  /**
	   * Gist::isFieldExists()
	   *
       * @return
       */
	  public function isFieldExists($table=false,$column=false)
	  {
		  $table = sanitize($table);
		  $column = sanitize($column);
$sql = Vault::get("Database")->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$table."' AND COLUMN_NAME = '".$column."';");	
		  $count = Vault::get("Database")->numrows($sql);	
		  return ($count > 0) ? 1 : false;	  
	  }


	  
//-----------  

  }
?>