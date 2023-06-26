<?php
  /**
   * User Class
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2018
   * @version $Id: class.user.php, v1.1.0 Feb 2018 transinova $
   */
  
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');

  class Users
  {
	  const usrTable = "sys_users";
	  const sesPrefix = "tivrbc110cal_";
	  public $logged_in = null;
	  public $uid = 0;
	  public $userid = 0;
      public $username;
	  public $name;
	  public $sesid;
	  public $email;
      public $userlevel;
	  private $lastlogin = "NOW()";
	  public $last;
	  private static $db;
      

      /**
       * Users::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Vault::get("Database");
		  $this->startSession();
      }
 

      /**
       * Users::startSession()
       * 
       * @return
       */
      private function startSession()
      {
		if (strlen(session_id()) < 1)
			session_start();
	  
		$this->logged_in = $this->loginCheck();
		
		if (!$this->logged_in) {
			$this->username = $_SESSION[self::sesPrefix.'username'] = "Guest";
			$this->sesid = sha1(session_id());
			$this->userlevel = 0;
		}
      }

	  /**
	   * Users::loginCheck()
	   * 
	   * @return
	   */
	  private function loginCheck()
	  {
          if (isset($_SESSION[self::sesPrefix.'username']) && $_SESSION[self::sesPrefix.'username'] != "Guest") {
              
              $row = $this->getUserInfo($_SESSION[self::sesPrefix.'username']);
			  $this->uid = $row->id;
			  $this->name = $row->fname;
              $this->username = $row->username;
			  $this->userlevel = $row->userlevel;
			  $this->email = $row->email;
			  $this->access = $row->access;
			  $this->last = $row->lastlogin;
			  $this->sesid = sha1(session_id());

              return true;
          } else {
              return false;
          }  
	  }

	  /**
	   * Users::isSuperAdmin()
	   * 
	   * @return
	   */
	  public function isSuperAdmin()
	  {
		  if($this->userlevel==9){return(true);}else{return(false);}
	  
	  }	


	  
	  /**
	   * Users::login()
	   * 
	   * @param mixed $username
	   * @param mixed $password
	   * @return
	   */
	  public function login($username, $password)
	  {
		  
		  $timeleft = null;
		  if (!Vault::get("Security")->reLogin($timeleft)) {
			  $minutes = ceil($timeleft / 60);
			  Sift::$msgs['username'] = str_replace("%MINUTES%", $minutes, Lang::$say->_LG_ATTEMT_RERR);
		  } elseif ($username == "" && $password == "") {
			  Sift::$msgs['username'] = Lang::$say->_LG_ERROR1;
		  } else {
			  $status = $this->checkStatus($username, $password);
			  
			  switch ($status) {
				  case 0:
					  Sift::$msgs['username'] = Lang::$say->_LG_ERROR2;
					  Vault::get("Security")->setFailedLogin();
					  break;
					  
				  case 1:
					  Sift::$msgs['username'] = Lang::$say->_LG_ERROR3;
					  Vault::get("Security")->setFailedLogin();
					  break;
					  
				  case 2:
					  Sift::$msgs['username'] = Lang::$say->_LG_ERROR4;
					  Vault::get("Security")->setFailedLogin();
					  break;
					  
				  case 3:
					  Sift::$msgs['username'] = Lang::$say->_LG_ERROR5;
					  Vault::get("Security")->setFailedLogin();
					  break;
			  }
		  }
		  if (empty(Sift::$msgs) && $status == 5) {
			  $row = $this->getUserInfo($username);
			  $this->uid = $_SESSION[self::sesPrefix.'uid'] = $row->id;
			  $this->username = $_SESSION[self::sesPrefix.'username'] = $row->username;
			  $this->name = $_SESSION[self::sesPrefix.'name'] = $row->fname;
			  $this->email = $_SESSION[self::sesPrefix.'email'] = $row->email;
			  $this->userlevel = $_SESSION['userlevel'] = $row->userlevel;
			  $this->access = $_SESSION['access'] = $row->access;
			  $this->last = $_SESSION['last'] = $row->lastlogin;

			  $data = array(
					'lastlogin' => $this->lastlogin, 
					'lastip' => sanitize($_SERVER['REMOTE_ADDR'])
			  );
			  self::$db->update(self::usrTable, $data, "username='" . $this->username . "'");

				  
			  return true;
		  } else
			  Sift::msgStatus();
	  }

      /**
       * Users::logout()
       * 
       * @return
       */
      public function logout()
      {
          unset($_SESSION[self::sesPrefix.'username']);
		  unset($_SESSION[self::sesPrefix.'email']);
		  unset($_SESSION[self::sesPrefix.'name']);
		  unset($_SESSION[self::sesPrefix.'userlevel']);
		  unset($_SESSION[self::sesPrefix.'last']);
          unset($_SESSION[self::sesPrefix.'uid']);
          session_destroy();
		  session_regenerate_id();
          
          $this->logged_in = false;
          $this->username = Lang::$say->_GUEST;
          $this->userlevel = 0;
      }
	  
	  /**
	   * Users::getUserInfo()
	   * 
	   * @param mixed $username
	   * @return
	   */
	  public function getUserInfo($username)
	  {
          $username = sanitize($username);
          $username = self::$db->escape($username);

		  $sql = "SELECT * FROM " . self::usrTable . " WHERE username = '" . $username . "' OR email = '" . $username . "'";
          $row = self::$db->first($sql);
          if (!$username)
              return false;

          return ($row) ? $row : 0;
	  }



	  	  
	  /**
	   * Users::checkStatus()
	   * 
	   * @param mixed $username
	   * @param mixed $password
	   * @return
	   */
	  public function checkStatus($username, $password)
	  {
		  
		  $username = sanitize($username);
		  $username = self::$db->escape($username);
		  $password = sanitize($password);
		  
		  $sql = "SELECT password, active FROM " . self::usrTable . " WHERE username = '" . $username . "' OR email = '" . $username . "'";
          $result = self::$db->query($sql);
          
          if (self::$db->numrows($result) == 0)
              return 0;
			  
          $row = self::$db->fetch($result);
          $entered_pass = sha1($password);
		  
          switch ($row->active) {
			  case "b":
				  return 1;
				  break;
				  
			  case "n":
				  return 2;
				  break;
				  
			  case "t":
				  return 3;
				  break;
				  
			  case "y" && $entered_pass == $row->password:
				  return 5;
				  break;
		  }
	  }



	  /**
	   * Users::userLevelName()
	   * 
	   * @param mixed $lid
	   * @return
	   */
	  public function userLevelName($lid)
	  {
		  
          switch ($lid) {
			  case 9:
				  return Lang::$say->_UR_UTY9;
				  break;
				  
			  case 8:
				  return Lang::$say->_UR_UTY8;
				  break;
				  
			  case 7:
				  return Lang::$say->_UR_UTY7;
				  break;
				  
			  case 6:
				  return Lang::$say->_UR_UTY6;
				  break;
				  
			  case 5:
				  return Lang::$say->_UR_UTY5;
				  break;
			  case 4:
				  return Lang::$say->_UR_UTY4;
				  break;
		  }		  
	  }

	  /**
	   * Users::getUserList()
	   * 
	   * @param bool $from
	   * @return
	   */
	  public function getUserList($pagenum=false)
	  {
          
		  if(isset($_POST['page'])){$page = sanitize($_POST['page']);}else{$page=$pagenum;}
		  $where =' WHERE userlevel<9 ';
		  $q = "SELECT COUNT(*) FROM " . self::usrTable . $where. " LIMIT 1";		  
		  
          $record = self::$db->query($q);
          $total = self::$db->fetchrow($record);
          $counter = $total[0];
		  
		  $pager = Paginator::instance();
		  $pager->live = true;
		  $pager->parentid = 'useredit';
		  $pager->command = 'reloadUsers';
		  $pager->items_total = $counter;
		  $pager->default_ipp = Vault::get("Gist")->perpage;
		  $pager->current_page = $page;
		  $pager->paginate();	  

		  
          $sql = "SELECT u.*, u.fname "
		  . "\n FROM " . self::usrTable. " as u"
		  . "\n $where"
		  . "\n ORDER BY u.fname ASC" . $pager->limit;
          $row = self::$db->fetch_all($sql);
		  $nousers='<div class="alert alert-warning" role="alert">'.Lang::$say->_UR_NOUSER.'</div>';

if($row){
	$disp ='<script type="text/javascript">
var ljsDelConfirm = "'.Lang::$say->_UR_DELCONFIRM.'";
</script><table class="restable table table-hover table-framed">
						  <thead>
						  <tr>
						  <th>'.Lang::$say->_UR_NAME.'</th>
						  <th>'.Lang::$say->_UR_USRNAME.'</th>					  
						  <th>'.Lang::$say->_GNL_COMPANY.'</th>
						  <th>'.Lang::$say->_UR_LASTLOGIN.'</th>
						  <th class="text-center">'.Lang::$say->_UR_ASSIGNED.'</th>		
						  <th>'.Lang::$say->_ACTIONS.'</th>				  
						  </tr>
							</thead><tbody>';
					  foreach ($row as $usr) {
$numassigned = Vault::get("Vhrental")->countAssigned($usr->id);
if($usr->active!='y'){$ustatus='<span class="glyphicon glyphicon-ban-circle recstatus" aria-hidden="true"></span>';}else{$ustatus='';}
if($numassigned>0){$assgnum='<span class="badge badge-secondary">'.$numassigned.'</span>';}else{$assgnum='-';}						  
						  $company = ($usr->company)?$usr->company:'-';
						  $disp .='<tr>
						  <td>'.$usr->fname.' '.$ustatus.'<br /><a href="#user_role_help" data-toggle="modal">'.$this->userLevelName($usr->userlevel).'</a></td>
						  <td>'.$usr->username.'<br />'.$usr->email.'</td>
						  <td>'.$company.'<br />'.$usr->cphone.'</td>
						  <td>'.displayMyDate($usr->lastlogin).'<br />'.$usr->lastip.'</td>
						  <td class="text-center">'.$assgnum.'</td>	
						  <td><a class="itemaction itemedit" data-listcont="useredit" data-id="'.$usr->id.'" data-option="editUser" href="javascript:void(0);" data-name="'.$usr->fname.'" data-page="'.$page.'"  data-auth="'.genRequestKey($usr->id.'editUser').'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					  
						  
<a class="itemaction itemdelete" data-listcont="userdel" data-id="'.$usr->id.'" data-option="deleteUser" href="javascript:void(0);" data-name="'.$usr->fname.'" data-page="'.$page.'" data-auth="'.genRequestKey($usr->id.'deleteUser').'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>					  
						  </tr>';						  
					  }	
	$disp .='</tbody></table>';
	if($pager->items_total<Vault::get("Gist")->perpage)
	$disp .='<div class="row">
    <div class="col-sm-6">
      <span>'.Lang::$say->_PAG_TOTAL.': '.$pager->items_total.' / '.Lang::$say->_PAG_CURPAGE.': '.$pager->current_page.' '.Lang::$say->_PAG_OF.' '.$pager->num_pages.'</span> </div>
      <div class="col-sm-6">
        <div id="pagination" class="float-right">'.$pager->display_paging().'</div>
      </div>
  </div>';
	unset($usr);
}

		              
	return ($row) ? sanitize_output($disp) : $nousers;
}


	  /**
	   * Users::saveUserReg()
	   * 
	   * @return
	   */
	  public function saveUserReg()
	  {

		  
		  Sift::checkPost('fname', Lang::$say->_UR_FULLNAME_R);
	
		  if (!$this->isValidEmail($_POST['email'])){
			  Sift::$msgs['email'] = Lang::$say->_UR_EMAIL_R2;}
			  else{
		  if(Sift::$id){
				$result = $this->emailAddrExists($_POST['email'],Sift::$id);
				if ($result == 1)
					  Sift::$msgs['email'] = Lang::$say->_UR_EMAIL_R1;
		  	}else{
				$result = $this->emailAddrExists($_POST['email']);
				if ($result == 1)
					  Sift::$msgs['email'] = Lang::$say->_UR_EMAIL_R1;
			   }			  
			}
			
			Sift::checkPost('userlevel', Lang::$say->_UR_ROLE_R);

		  
		  if(Sift::$id){
			  if ($value = $this->usernameCheck($_POST['username'],Sift::$id)) {
				  if ($value == 1)
					  Sift::$msgs['username'] = Lang::$say->_UR_USERNAME_R1;
				  if ($value == 2)
					  Sift::$msgs['username'] = Lang::$say->_UR_USERNAME_R2;
				  if ($value == 3)
					  Sift::$msgs['username'] = Lang::$say->_UR_USERNAME_R3;
			  }
			  if(strlen($_POST['password'])>0){
		  	if (strlen($_POST['password']) < 6)
			  Sift::$msgs['password'] = Lang::$say->_UR_PASSWORD_R1;
			  elseif (!preg_match("/^.*((?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,50}).*$/", ($_POST['password'] = trim($_POST['password']))))
			  Sift::$msgs['password'] = Lang::$say->_UR_PASSWORD_R2;
		  	elseif ($_POST['password'] != $_POST['password2'])
			  Sift::$msgs['password'] = Lang::$say->_UR_PASSWORD_R3; 
			  }
		  }else{
			  if ($value = $this->usernameCheck($_POST['username'])) {
				  if ($value == 1)
					  Sift::$msgs['username'] = Lang::$say->_UR_USERNAME_R1;
				  if ($value == 2)
					  Sift::$msgs['username'] = Lang::$say->_UR_USERNAME_R2;
				  if ($value == 3)
					  Sift::$msgs['username'] = Lang::$say->_UR_USERNAME_R3;
			  }
		  	if (strlen($_POST['password']) < 6)
			  Sift::$msgs['password'] = Lang::$say->_UR_PASSWORD_R1;
elseif (!preg_match("/^.*((?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,50}).*$/", ($_POST['password'] = trim($_POST['password']))))
			  Sift::$msgs['password'] = Lang::$say->_UR_PASSWORD_R2;
		  	elseif ($_POST['password'] != $_POST['password2'])
			  Sift::$msgs['password'] = Lang::$say->_UR_PASSWORD_R3; 
		  }
		
		  if(isset($_POST['active']) && sanitize($_POST['active'])){$active='y';}else{$active='n';}
		  
        $ppttypeids = '';
        if (!empty($_POST['ppttypeids'])) {
			$sep=',';
            foreach ($_POST['ppttypeids'] as $pptycheck){
                $ppttypeids .= $pptycheck . $sep;				
            }
			$ppttypeids = rtrim($ppttypeids, ',');
        }	

		  if (empty(Sift::$msgs)) {
	
			  $data = array(
			  	  'username' => strtolower(sanitize($_POST['username'])),
				  'email' => strtolower(sanitize($_POST['email'])),
				  'fname' => sanitize($_POST['fname']),
				  'userlevel' => intval($_POST['userlevel']),
				  'active' => $active,
				  'company' => sanitize($_POST['company']),
				  'caddress' => sanitize($_POST['caddress']),
				  'cphone' => sanitize($_POST['cphone']),
				  'pptassignment' => $ppttypeids
				  );
	
			  if (!Sift::$id){$data['created'] = "NOW()";}
				  
			  if (!Sift::$id){$data['akey']=sanitize($_POST['saveUser']);}
	
			  if (Sift::$id){$userrow = Gist::getRowById(self::usrTable, Sift::$id);}
				  
			  if(Sift::$id){
			  	if (strlen($_POST['password'])>0) {
				  $data['password'] = sha1($_POST['password']);
				  $infoname = $userrow->fname;
				  $infousername = $userrow->username;
				  $infoemail = $userrow->email;
				  $infopassword = $_POST['password'];
				  $passchanged=true;
			  	} else {
				  $data['password'] = $userrow->password;				  
				  $passchanged=false;
				  $infoname = $userrow->fname;
				  $infousername = $userrow->username;
				  $infoemail = $userrow->email;
				  $infopassword = Lang::$say->_GNL_NOTCHANGED;				  
				  }			  
			  }
			  else
			  {
				  $data['password'] = sha1($_POST['password']);
				  $infoname = $data['fname'];
				  $infousername = $data['username'];
				  $infoemail = $data['email'];
				  $infopassword = $_POST['password'];
				  }
	
	
			  (Sift::$id) ? self::$db->update(self::usrTable, $data, "id='" . Sift::$id . "'") : self::$db->insert(self::usrTable, $data);
	
			  if (self::$db->affected()) {
				  $json['status'] = 'success';

				  if (Sift::$id) {
				  $json['message'] = Sift::msgSuccess(Lang::$say->_UR_UPDATED, false,4000,false,true);
				  }
				  else{$json['message'] = Sift::msgSuccess(Lang::$say->_UR_ADDED, false,false,false,false);}
				  $json['content'] = $this->getUserList();

				  print json_encode($json);

if (isset($_POST['notify']) && intval($_POST['notify']) == 1 || (isset($_POST['notify']) && intval($_POST['notify']) == 1 && $passchanged)) {
	
					  require_once (BASEPATH . "classes/class.mailer.php");
					  $mailer = Mailer::sendMail();
	
					  
					  if(Sift::$id) {
					  $row = Vault::get("Gist")->getRowById(Gist::etplTable, 2);}
					  else{
					  $row = Vault::get("Gist")->getRowById(Gist::etplTable, 1);}
	
					  $body = str_replace(array(
					  	  '[NAME]',
						  '[EMAIL]',
						  '[USERNAME]',
						  '[PASSWORD]',
						  '[NAME]',
						  '[SITENAME]',
						  '[URL]',
						  '[SIGNATURE]'), array(
						  $infoname,
						  $infoemail,
						  $infousername,
						  $infopassword,
						  $infoname,
						  Vault::get("Gist")->pptname,
						  SITEURL,
				          Vault::get("Gist")->signature), $row->{'body' . Lang::$lang});
	
					  $msg = Swift_Message::newInstance()
							->setSubject($row->{'subject' . Lang::$lang})
							->setTo(array($data['email'] => $data['fname']))
							->setFrom(array(Vault::get("Gist")->pptemail => Vault::get("Gist")->pptname))
							->setBody(cleanOut($body), 'text/html');
	
					  $mailer->send($msg);
				  }
			  } else {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
				  print json_encode($json);
			  }
	
		  } else {
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  }
	  }



	  /**
	   * Users::updateProfile()
	   * 
	   * @return
	   */
	  public function updateProfile()
	  {

		  Sift::checkPost('fname', Lang::$say->_UR_FULLNAME_R);

if($this->userlevel==9 && ($this->email!=$_POST['fullnameview'])){
		  if (!$this->isValidEmail($_POST['fullnameview'])){
			  Sift::$msgs['fullnameview'] = Lang::$say->_UR_EMAIL_R2;}
			  else{
		  if(Sift::$id){
				$result = $this->emailAddrExists($_POST['fullnameview'],Sift::$id);
				if ($result == 1)
					  Sift::$msgs['fullnameview'] = Lang::$say->_UR_EMAIL_R1;
		  	}else{
				$result = $this->emailAddrExists($_POST['fullnameview']);
				if ($result == 1)
					  Sift::$msgs['fullnameview'] = Lang::$say->_UR_EMAIL_R1;
			   }			  
			}	
}

		  if($this->userlevel==9 && ($this->username!=$_POST['usernameview'])){
			  if ($value = $this->usernameCheck($_POST['usernameview'],$this->uid)) {
				  if ($value == 1)
					  Sift::$msgs['usernameview'] = Lang::$say->_UR_USERNAME_R1;
				  if ($value == 2)
					  Sift::$msgs['usernameview'] = Lang::$say->_UR_USERNAME_R2;
				  if ($value == 3)
					  Sift::$msgs['usernameview'] = Lang::$say->_UR_USERNAME_R3;
			  }
		  }
	
		  if (empty(Sift::$msgs)) {
	
			  $data = array(
				  'fname' => sanitize($_POST['fname']),
				  'company' => sanitize($_POST['company']),
				  'caddress' => sanitize($_POST['caddress']),
				  'cphone' => sanitize($_POST['cphone'])
				  );
			if($this->userlevel==9 && ($this->email!=$_POST['fullnameview'])){$data['email'] = sanitize($_POST['fullnameview']);}
			if($this->userlevel==9 && ($this->username!=$_POST['usernameview'])){$data['username'] = sanitize($_POST['usernameview']);}
			  self::$db->update(self::usrTable, $data, "id='" . $this->uid . "'");
	
			  if (self::$db->affected()) {
				  
				  if($this->userlevel==9 && ($this->username!=$_POST['usernameview'])){$this->username = $_SESSION[self::sesPrefix.'username'] = $data['username'];
				  $this->loginCheck();}
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgSuccess(Lang::$say->_UA_UPDATEOK, false,4000,false,true);
				  print json_encode($json);
			  } else {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
				  print json_encode($json);
			  }
	
		  } else {
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  }
	  }



	  /**
	   * Users::updatePassword()
	   * 
	   * @return
	   */
	  public function updatePassword()
	  {

		Sift::checkPost('currpassword', Lang::$say->_UR_PASSWORD_R1);
		if(strlen($_POST['currpassword'])>=8)
		{
			$userpass = getValueById("password", self::usrTable, $this->uid);
		  if ($userpass!=sha1($_POST['currpassword']))
			  {
				Sift::$msgs['currpassword'] = Lang::$say->_UR_PASSWORD_R4;
			  }				
		}

		  Sift::checkPost('newpassword', Lang::$say->_UR_UPDTPASSWORD_R1);
		  Sift::checkPost('confnewpassword', Lang::$say->_UR_UPDTCPASSWORD_R1);

		  if (strlen($_POST['newpassword']) < 8)
			  Sift::$msgs['newpassword'] = Lang::$say->_UR_UPDTPASSWORD_R1;
		  elseif (!preg_match("/^.*((?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,50}).*$/", ($_POST['newpassword'] = trim($_POST['newpassword']))))
			  Sift::$msgs['newpassword'] = Lang::$say->_UR_UPDTPASSWORD_R2;
		  elseif ($_POST['newpassword'] != $_POST['confnewpassword'])
			  Sift::$msgs['newpassword'] = Lang::$say->_UR_UPDTPASSWORD_R3;

		
		if (empty(Sift::$msgs)) {
			$data = array(
				  'password' => sha1($_POST['confnewpassword'])
			  );				   
			  self::$db->update(self::usrTable, $data, "id=" . $this->uid);
			  if (self::$db->affected()) {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgSuccess(Lang::$say->_UR_UPDTPASSWORD_OK, false,false,false,false);
				  
			  } else {
				  $json['status'] = 'info';
				  $json['message'] = Sift::msgWarning(Lang::$say->_UR_PASSWORD_RR, false,4000,false,true);
			  }
			  print json_encode($json);
		}else {
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  } 
	  }
	  

	  /**
	   * Users::getUserData()
	   * 
	   * @return
	   */
	  public function getUserData()
	  {
	
		  $sql = "SELECT * FROM " . self::usrTable 
		  . "\n WHERE id = " . $this->uid;
		  $row = self::$db->first($sql);
	
		  return ($row) ? $row : 0;
	  }
	  
	  /**
	   * Users::getUserDatabyId()
	   * 
	   * @return
	   */
	  public function getUserDatabyId()
	  {
	
		  $sql = "SELECT * FROM " . self::usrTable 
		  . "\n WHERE id = " . $this->uid;
		  $row = self::$db->first($sql);
	
		  return ($row) ? $row : 0;
	  }



	  	  	  	  
	  /**
	   * Users::usernameCheck()
	   * 
	   * @param mixed $username
	   * @return
	   */
	  private function usernameCheck($username,$editid=false)
	  {
	
		  $username = sanitize($username);
		  if (strlen(self::$db->escape($username)) < 6)
			  return 1;
	
		  //alphabets, numbers, underscores or hyphens
		  $valid_uname = "/^[a-zA-Z0-9_-]{4,15}$/";
		  if (!preg_match($valid_uname, $username))
			  return 2;
		if($editid){$editid= " AND id!='".$editid."' " ;}else{$editid='';}
		  $sql = self::$db->query("SELECT username" 
		  . "\n FROM " . self::usrTable
		  . "\n WHERE username = '" . $username . "'".$editid 
		  . "\n LIMIT 1");
	
		  $count = self::$db->numrows($sql);
	
		  return ($count > 0) ? 3 : false;
	  } 	


/**
* Users::emailAddrExists()
* 
* @param mixed $email
* @param mixed $editid
* @return
*/
	  private function emailAddrExists($email=false,$editid=false)
	  {
		  if($editid){$sq=" AND id!='$editid' ";}else{$sq="";}
		  $email = sanitize($email);
		  $sql = self::$db->query("SELECT email" 
		  . "\n FROM " . self::usrTable
		  . "\n WHERE email = '" . $email . "'".$sq
		  . "\n LIMIT 1");	
		  $count = self::$db->numrows($sql);
		  return ($count > 0) ? 1 : false;
	  } 	
	  	   

	  
	  /**
	   * User::isValidEmail()
	   * 
	   * @param mixed $email
	   * @return
	   */
	  private function isValidEmail($email)
	  {
		  if (function_exists('filter_var')) {
			  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				  return true;
			  } else
				  return false;
		  } else
			  return preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $email);
	  } 	

      /**
       * User::validateToken()
       * 
       * @param mixed $token
       * @return
       */
	  private function validateToken($token)
	  {
		  $token = sanitize($token, 40);
		  $sql = "SELECT token" 
		  . "\n FROM " . self::usrTable 
		  . "\n WHERE token ='" . self::$db->escape($token) . "'" 
		  . "\n LIMIT 1";
		  
		  $result = self::$db->query($sql);
	
		  if (self::$db->numrows($result))
			  return true;
	  }
	  
	  /**
	   * Users::getUniqueCode()
	   * 
	   * @param string $length
	   * @return
	   */
	  private function getUniqueCode($length = "")
	  {
		  $code = md5(uniqid(rand(), true));
		  if ($length != "") {
			  return substr($code, 0, $length);
		  } else
			  return $code;
	  }

	  /**
	   * Users::generateRandID()
	   * 
	   * @return
	   */
	  private function generateRandID()
	  {
		  return sha1($this->getUniqueCode(24));
	  }



	  
	  

	  /**
	   * Users::editFormUser()
	   * 
	   * @param mixed $id
	   * @return
	   */
	  public function editFormUser($id)
	  {
          $id = sanitize($id);
          $id = self::$db->escape($id);
		  
		  if(isset($_POST['page'])){$page = sanitize($_POST['page']);}else{$page=1;}

		  $sql = "SELECT * FROM " . self::usrTable . " WHERE id = '" . $id . "' ";
          $row = self::$db->first($sql);
if($row->active=='y'){$active=' checked="checked"';}else{$active='';}
$disp = '
        <form class="form" id="form_useredit">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="fname">'.Lang::$say->_UR_FULLNAME.'</label>
                <input name="fname" type="text" class="form-control" value="'.$row->fname.'" autocomplete="off" autocorrect="off">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="email">'.Lang::$say->_UR_EMAIL.'</label>
                <input name="email" type="text" class="form-control" value="'.$row->email.'" autocomplete="off" autocorrect="off">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label style="width:100%" for="userlevel">'.Lang::$say->_UR_UROLE.'<a href="#user_role_help" role="button" class="float-right" data-toggle="modal"><span class="glyphicon glyphicon-question-sign"></span> '. Lang::$say->_HELP.'</a></label>
                <select class="form-control custom-select" name="userlevel">
                  <option value="8"'.getSelected($row->userlevel, 8, true).'>'.Lang::$say->_UR_UTY8.'</option>
                  <option value="7"'.getSelected($row->userlevel, 7, true).'>'.Lang::$say->_UR_UTY7.'</option>
                  <option value="6"'.getSelected($row->userlevel, 6, true).'>'.Lang::$say->_UR_UTY6.'</option>
                  <option value="5"'.getSelected($row->userlevel, 5, true).'>'.Lang::$say->_UR_UTY5.'</option>
                  <option value="4"'.getSelected($row->userlevel, 4, true).'>'.Lang::$say->_UR_UTY4.'</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="password">'.Lang::$say->_UR_USRNAME.'</label>
                <input type="text" class="form-control" name="username" autocomplete="off"  autocorrect="off" value="'.$row->username.'">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="password">'.Lang::$say->_UR_PASSWORDCHG.'</label>
                <input type="password" class="form-control" name="password" autocomplete="off"  autocorrect="off">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="password2">'.Lang::$say->_UR_PASSWORDCNFCHG.'</label>
                <input type="password" class="form-control" name="password2" autocomplete="off"  autocorrect="off">
              </div>
            </div>
            <div class="col-sm-3">
              <label class="hidden-xs">&nbsp;</label>
              <div class="form-group">
                <label class="checkbox-inline">
                  <input name="active" type="checkbox" value="y" '.$active.'>
                  <i></i>'.Lang::$say->_UR_ACTIVE.'</label>
                <label class="checkbox-inline">
                  <input name="notify" type="checkbox" value="1">
                  <i></i>'.Lang::$say->_UR_NOTIFY.'</label>                  
              </div>
            </div>
          </div>
          <hr class="slim">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="company">'.Lang::$say->_UR_COMNAME.'</label>
                <input name="company" type="text" class="form-control" value="'.$row->company.'">
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label for="caddress">'.Lang::$say->_UR_COMADDR.'</label>
                <input name="caddress" type="text" class="form-control" value="'.$row->caddress.'">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="caddress">'.Lang::$say->_UR_COMPHONE.'</label>
                <input name="cphone" type="text" class="form-control" value="'.$row->cphone.'">
              </div>
            </div>
          </div>
          <hr class="slim">
		  '. Vault::get("Vhrental")->ptypesAssignments($row->id).'
          <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
              <div class="form-group">
			  <input type="hidden" name="page" value="'.$page.'">
              <input type="hidden" name="id" value="'.$row->id.'">
                <input type="hidden" name="updateUser" value="'.genRequestKey('updateUser'.$row->id).'">
                <button id="save_useredit" data-after="none" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.Lang::$say->_SAVE.'</button>
              </div>
            </div>
          </div>
        </form>
        <div id="msg_useredit"></div>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
setTimeout(function(){
  $(\'#modaldlg_useredit\').find(\'input:password\').val(\'\');
}, 1500);
});
// ]]>
</script>
';

          return ($row) ? sanitize_output($disp) : false;
	  }	



/**
* Users::passResetRequest()
* 
* @return
*/
public function passResetRequest()
	  {
	
		  Sift::checkPost('captcha', Lang::$say->_UA_PASS_RCAPT_R);
	
		  if ($_SESSION[self::sesPrefix.'captchacode'] != $_POST['captcha'])
			  Sift::$msgs['captcha'] = Lang::$say->_UA_PASS_RCAPT_R1;

	  if (empty(Sift::$msgs['captcha'])) {
	  Sift::checkPost('regemail', Lang::$say->_UR_EMAIL_R);

	  if(strlen($_POST['regemail'])>0){
		  if (!$this->emailAddrExists($_POST['regemail']))
			  Sift::$msgs['regemail'] = Lang::$say->_UR_EMAIL_R3;
		   }
	  }
	
		  if (empty(Sift::$msgs)) {
	
			  $user = $this->getUserInfo($_POST['regemail']);
			  $token = $this->getUniqueCode(32);
			  
			  $params = 'login/accesshelp.php?e=' . Vault::get("niceIds")->makenice($user->id).'&c=' . $token;
			  $rstlink = SITEURL.$params;			  
	
			  $data['token'] = $token;
			  $datadate =date("d M Y, H:i");	
	
			  self::$db->update(self::usrTable, $data, "id = '" . $user->id . "'");
	$mailsent = false;
	if(Vault::get("Gist")->pptemail){
		
			  require_once (BASEPATH . "classes/class.mailer.php");
			  $row = Gist::getRowById(Gist::etplTable, 3);
			  
			  $body = str_replace(array(
				  '[NAME]',
				  '[EMAIL]',
				  '[USERNAME]',
				  '[URL]',
				  '[LINK]',
				  '[IP]',
				  '[SITENAME]',
				  '[DATE]',
				  '[SIGNATURE]'), array(
				  $user->fname,
				  $user->email,
				  $user->username,
				  SITEURL,
				  $rstlink,
				  getVisitingIP(),
				  Vault::get("Gist")->pptname,
				  $datadate,
				  Vault::get("Gist")->signature
				  ), $row->{'body' . Lang::$lang});
			  
			  $subject = str_replace(array(
				  '[NAME]',
				  '[EMAIL]',			  
				  '[USERNAME]',
				  '[SITENAME]',
				  '[DATE]'), array(
				  $user->fname,
				  $user->email,				  
				  $user->username,
				  Vault::get("Gist")->pptname,
				  $datadate
				  ), $row->{'subject' . Lang::$lang});			  
	
			  $mailer = Mailer::sendMail();
			  $message = Swift_Message::newInstance()
							->setSubject($subject)
							->setTo(array($user->email => $user->fname))
							->setFrom(array(Vault::get("Gist")->pptemail => Vault::get("Gist")->pptname))
							->setBody(cleanOut($body), 'text/html');
			  $mailsent = $mailer->send($message);	
	}
	
			  if (self::$db->affected() && $mailsent) {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgSuccess(Lang::$say->_UA_PASS_R_OK,false,false,false,false);
			  } else {
				  $json['status'] = 'warning';
				  $json['message'] = Sift::msgWarning(Lang::$say->_UA_PASS_R_ERR,false,4000,false,true);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  }
	  }


	  /**
	   * User::passResetRequestExists()
	   * 
	   * @param mixed $e
	   * @param mixed $c
	   * @return
	   */
	  public function passResetRequestExists($c,$e)
	  {
		  
		  $uiden=Vault::get("niceIds")->restore($e);
		  $sql = self::$db->query("SELECT id" 
		  . "\n FROM " .self::usrTable
		  . "\n WHERE id = '" . $uiden . "' AND token='".sanitize($c,80)."' " 
		  . "\n LIMIT 1");		  
		  if (self::$db->numrows($sql) == 1) {
			  return true;
		  } else
			  return false;
	  }


	  /**
	   * Users::resetNewPassword()
	   * 
	   * @return
	   */
	  public function resetNewPassword()
	  {

		$uiden=Vault::get("niceIds")->restore($_POST['eval']);
		if($uiden){
		if (getValueById("token", self::usrTable, $uiden)!=sanitize($_POST['code'],40))
			  Sift::$msgs['eval'] = Lang::$say->_UA_NOTVLDPWDVARS;
		}else{Sift::$msgs['eval'] = Lang::$say->_UA_NOTVLDPWDVARS;}

		  
		  Sift::checkPost('newpassword', Lang::$say->_UR_UPDTPASSWORD_R1);
		  Sift::checkPost('confnewpassword', Lang::$say->_UR_UPDTCPASSWORD_R1);


		  if (strlen($_POST['newpassword']) < 8)
			  Sift::$msgs['newpassword'] = Lang::$say->_UR_UPDTPASSWORD_R1;
		  elseif (!preg_match("/^.*((?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,50}).*$/", ($_POST['newpassword'] = trim($_POST['newpassword']))))
			  Sift::$msgs['newpassword'] = Lang::$say->_UR_UPDTPASSWORD_R2;
		  elseif ($_POST['newpassword'] != $_POST['confnewpassword'])
			  Sift::$msgs['newpassword'] = Lang::$say->_UR_UPDTPASSWORD_R3;

		
		if (empty(Sift::$msgs)) {
			$data = array(
				  'password' => sha1($_POST['confnewpassword']),
				  'token' => 0
			  );				   
			  self::$db->update(self::usrTable, $data, "id='" . $uiden ."' AND token='".sanitize($_POST['code'],40)."' ");
			  if (self::$db->affected()) {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgSuccess(Lang::$say->_UR_UPDTPASSWORD_OKLOG.' '.'<a href="../">'.Lang::$say->_UA_LOGINNOW.'</a>', false, false, false, false);

			  } else {
				  $json['status'] = 'warning';
				  $json['message'] = Sift::msgWarning(Lang::$say->_SYSERROR, false);
			  }
			  print json_encode($json);
		}else {
			  $json['status'] = 'error';
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  } 
	  }


	  /**
	   * Users::feedAuth()
	   * 
	   * @param mixed $username
	   * @param mixed $akey
	   * @return
	   */
	  public function feedAuth($username,$akey,$pptid)
	  {
          $username = sanitize($username);
          $username = self::$db->escape($username);
		  if(!$username || !$akey){return false;}
		  $sql = "SELECT id,akey FROM " . self::usrTable . " WHERE username = '" . $username . "' AND active = 'y' AND (userlevel BETWEEN 4 AND 9)";
		  
          $row = self::$db->first($sql);if(!$row){return false;}
		  if(md5($pptid.'.'.$row->id.'.'.$row->akey.'.'.Vault::get("Gist")->pptname)==$akey){return true;}else{return false;}
	  }



	  /**
	   * Users::regenerateAkey()
	   * 
	   * @return
	   */
	  public function regenerateAkey()
	  {
		  if (Sift::$id) {	
			  $data = array();
			  $data['akey']=$this->generateRandID();
			  self::$db->update(self::usrTable, $data, "id='" . Sift::$id . "'");	
			  if (self::$db->affected()) {
				  return true;
			  } else {
				  return false;
			  }
	
		  } else {
			  return false;
		  }
	  }


	  /**
	   * Users::calExpAuth()
	   * 
	   * @param mixed $username
	   * @param mixed $akey
	   * @return
	   */
	  public function calExpAuth($username,$akey,$pptid)
	  {
          $username = sanitize($username);
          $username = self::$db->escape($username);
		  if(!$username || !$akey){return false;}
		  $sql = "SELECT id,akey FROM " . self::usrTable . " WHERE username = '" . $username . "' AND active = 'y' AND (userlevel BETWEEN 4 AND 9)";
		  
          $row = self::$db->first($sql);if(!$row){return false;}
		  if(md5($row->akey.'.'.$username.'.'.$pptid.'.'.$row->id.'.'.Vault::get("Gist")->pptname)==$akey){return true;}else{return false;}
	  }




	  /**
	   * Users::getUserAssignments()
	   * 
	   * @param bool $from
	   * @return
	   */
	  public function getUserAssignments($pagenum=false)
	  {
          
		  if(isset($_POST['page'])){$page = sanitize($_POST['page']);}else{$page=$pagenum;}
		  $where =' WHERE userlevel<9 ';
		  $q = "SELECT COUNT(*) FROM " . self::usrTable . $where. " LIMIT 1";		  
		  
          $record = self::$db->query($q);
          $total = self::$db->fetchrow($record);
          $counter = $total[0];
		  
		  $pager = Paginator::instance();
		  $pager->live = true;
		  $pager->parentid = 'uassignedit';
		  $pager->command = 'reloadUassign';
		  $pager->items_total = $counter;
		  $pager->default_ipp = Vault::get("Gist")->perpage;
		  $pager->current_page = $page;
		  $pager->paginate();	  

		  
          $sql = "SELECT u.*, u.fname "
		  . "\n FROM " . self::usrTable. " as u"
		  . "\n $where"
		  . "\n ORDER BY u.fname ASC" . $pager->limit;
          $row = self::$db->fetch_all($sql);
		  $nousers='<div class="alert alert-warning" role="alert">'.Lang::$say->_UR_NOUSER.'</div>';

if($row){
	$disp ='<table class="restable table table-hover table-framed">
						  <thead>
						  <tr>
						  <th>'.Lang::$say->_USER.'</th>
						  <th>'.Lang::$say->_UR_ASSIGNEDPPTY.'</th>		
						  <th>'.Lang::$say->_ACTIONS.'</th>				  
						  </tr>
							</thead><tbody>';
					  foreach ($row as $usr) {
$typeList=false;
$numassigned = Vault::get("Vhrental")->countAssigned($usr->id);
if($numassigned>0){$assgnum='<span class="badge badge-secondary">'.$numassigned.'</span>';}else{$assgnum='-';}
$pptassignments = explode(',',$usr->pptassignment);
$typeName=false;
if($usr->pptassignment){
foreach ($pptassignments as $ppty) {
    $typeName = getValueById("name", Vhrental::pptyTable, intval($ppty));
	if($typeName){$typeList .= '<div class="col-sm-12 col-md-6 col-lg-4"><h3 class="badge badge-secondary intd">'.$typeName.'</h3></div>';}
}
unset($ppty);
}else{$typeList='<div class="col-sm-12"><span class="recstatus small">'.Lang::$say->_UR_NOASSIGNED.'</span></div>';}

if($usr->active!='y'){$ustatus='<span class="glyphicon glyphicon-ban-circle recstatus" aria-hidden="true"></span>';}else{$ustatus='';}						  
						  $company = ($usr->company)?$usr->company:'-';
						  $disp .='<tr>
						  <td width="200"><strong>'.$usr->fname.'</strong> '.$ustatus.'<br /><span class="small">'.'<a href="#user_role_help" data-toggle="modal">'.$this->userLevelName($usr->userlevel).'</a>'.'<br />'.$usr->username.'<br />'.$usr->email.'<br />'.$usr->company.'</span></td>
						  <td><div class="row">'.$typeList.'</div></td>	
						  <td width="90">'.$assgnum.'<a class="itemaction itemedit" data-listcont="uassignedit" data-id="'.$usr->id.'" data-option="editUassign" href="javascript:void(0);" data-name="'.$usr->fname.'" data-page="'.$page.'"  data-auth="'.genRequestKey($usr->id.'editUassign').'"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span></a>
			  
						  </tr>';						  
					  }	
	$disp .='</tbody></table>';
	if($pager->items_total<Vault::get("Gist")->perpage)
	$disp .='<div class="row">
    <div class="col-sm-6">
      <span>'.Lang::$say->_PAG_TOTAL.': '.$pager->items_total.' / '.Lang::$say->_PAG_CURPAGE.': '.$pager->current_page.' '.Lang::$say->_PAG_OF.' '.$pager->num_pages.'</span> </div>
      <div class="col-sm-6">
        <div id="pagination" class="float-right">'.$pager->display_paging().'</div>
      </div>
  </div>';
	unset($usr);
}

		              
	return ($row) ? sanitize_output($disp) : $nousers;
}






      /**
       * Users::editFormUassign()
       * 
       * @param mixed $id
       * @return
       */
      public function editFormUassign($id)                     
      {
          $id = sanitize($id);
          $id = self::$db->escape($id);
          
          if(isset($_POST['page'])){$page = sanitize($_POST['page']);}else{$page=1;}

          $sql = "SELECT * FROM " . self::usrTable . " WHERE id = '" . $id . "' ";
          $row = self::$db->first($sql);
if($row->active=='y'){$active=' checked="checked"';}else{$active='';}
$disp = '
        <form class="form" id="form_uassignedit">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>'.$row->fname.' ('.$row->username.')</label>
				<br />'.$this->userLevelName($row->userlevel).'
              </div>
            </div>
          </div>
		  <hr class="slim">
          '.Vault::get("Vhrental")->ptypesAssignmentChecks($row->id).'
          <hr class="slim">
          <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
              <div class="form-group">
              <input type="hidden" name="page" value="'.$page.'">
              <input type="hidden" name="id" value="'.$row->id.'">
                <input type="hidden" name="saveUassign" value="'.genRequestKey('saveUassign'.$row->id).'">
                <button id="save_uassignedit" data-after="none" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.Lang::$say->_SAVE.'</button>
              </div>
            </div>
          </div>
        </form>
        <div id="msg_uassignedit"></div>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
setTimeout(function(){
  $(\'#modaldlg_uassignedit\').find(\'input:password\').val(\'\');
}, 1500);
});
// ]]>
</script>
';

          return ($row) ? sanitize_output($disp) : false;
      }







	  /**
	   * Users::updateUassign()
	   * 
	   * @return
	   */
	  public function updateUassign()
	  {
		  
		  if(!Sift::$id){Sift::$msgs['userid'] = Lang::$say->_UR_USERNAME_R;}	  
	
        $ppttypeids = '';
        if (!empty($_POST['ppttypeids'])) {
			$sep=',';
            foreach ($_POST['ppttypeids'] as $pptycheck){
                $ppttypeids .= $pptycheck . $sep;				
            }
			$ppttypeids = rtrim($ppttypeids, ',');
        }	
	
		  if (empty(Sift::$msgs)) {
	
			  $data = array(
			  	  'pptassignment' => $ppttypeids
				  );
	
	
			  self::$db->update(Users::usrTable, $data, "id='" . Sift::$id . "'");
	
			  if (self::$db->affected()) {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgSuccess(Lang::$say->_UR_UPDATED, false,4000,false,true);
				  $json['content'] = $this->getUserAssignments();
				  print json_encode($json);
			  } else {
				  $json['status'] = 'success';
				  $json['message'] = Sift::msgWarning(Lang::$say->_PROCCESS_HALTED, false,4000,false,true);
				  print json_encode($json);
			  }
	
		  } else {
			  $json['message'] = Sift::msgStatus();
			  print json_encode($json);
		  }
	  }






	    	  	  	   
  }
?>