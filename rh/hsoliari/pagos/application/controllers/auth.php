<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    function login()
    {
        $this->layout_view = 'login';
        
        if ($_POST) {
            $user = User::validate_login($_POST['username'], $_POST['password']);
            
            if ($user) {
               // viene de login calendar

                        session_destroy();
                        ini_set("session.cookie_lifetime","86400");
                        session_cache_limiter('private');
              			$cache_limiter = session_cache_limiter();
			           session_cache_expire(1440);
			           $cache_expire = session_cache_expire();
			           $expira = time() + 86400;
                       setcookie('sess', $expira , '/tmp', 'http://hotelsoliari.deshida.com.co');

                        session_start();
                        session_regenerate_id();
                        if (!isset($_SESSION['timeout_idle'])) {
                           $_SESSION['timeout_idle'] = time() + 86400;
                        } else {
                          if ($_SESSION['timeout_idle'] < time()) {
                          //destroy session
                          } else {
                            $_SESSION['timeout_idle'] = time() + 86400;
                          }
                        }
                        $_SESSION['uid'] = '23';
			            $_SESSION['username'] = $_POST['username'];
			            $_SESSION['name'] = 'Recepcion';
			            $_SESSION['email'] = 'comercial@deshida.com.co';
			            $_SESSION['userlevel'] = '7';
			            $_SESSION['access'] = '';
                        $_SESSION['last'] = '2020-01-01';
                        $_SESSION['register'] = '61';
                        $_SESSION['store'] = '1';
                        $_SESSION['inicio'] = time();
                        $_SESSION['expira'] = time() + (86400);


              //  $result = $user->login(sanitize($_POST['username']), sanitize($_POST['password']));
               // finaliza
               $user = $_POST['username'];
               $password = $_POST['password'];
                redirect('../login/index.php?postlogin=1&username='.$user.'&password='.$password);
                 redirect('pos/switshtable');
            } else {
                $this->view_data['username'] = $_POST['username'];
                $this->view_data['message'] = $this->lang->line('login_incorrect');
            }
        }
    }

    function logout()
    {
        if (! $this->user) {
            redirect('login');
        } else {
            $update = User::find($this->user->id);
            $update->last_active = date("Y-m-d H:i:s");
            $update->save();
            
            User::logout();
            redirect('login');
        }
    }
}
