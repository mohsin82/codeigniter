<?php

/* 

location :- application/controllers/login_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends MY_Controller {

	/* display a view page */
	public function create() {
		
		$this->goToAdminDashboard();
		
		$data = array();
		/* cookie value set to view */
		if(isset($_COOKIE[ADMIN_COOKIE_USERNAME]) && isset($_COOKIE[ADMIN_COOKIE_PASSWORD])) {
			
			$data['cookie_admin_username'] = $this->decryptIt($_COOKIE[ADMIN_COOKIE_USERNAME]);
			$data['cookie_admin_password'] = $this->decryptIt($_COOKIE[ADMIN_COOKIE_PASSWORD]);

		} else {
			
			$data['cookie_admin_username'] = '';
			$data['cookie_admin_password'] = '';
		}
		$data['title'] = 'Login';
		$data['active_tab'] = ADMIN_PATH.'login';
		$data['page_content'] = ADMIN_PATH.'login/create';
		$data['includes'] = 'login';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* get login */
	public function get_login() {
		
		$this->notAjaxDirect();
		
		$username = $this->input->post("username");
		$pwd = $this->input->post("password");
		$password = $this->encryptIt($pwd);
		$remember = $this->input->post("remember");
		$status = YES;
		$delete_status = NO;
		
		$usernameReg = ALPHA_NUMERIC_REG;

		$arr = array();
		if(empty($username)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Username".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($usernameReg, $username)) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_SPECIAL_CHARECTER_OR_SPACE;
			echo json_encode($arr);
			exit();
		
		} else if(empty($pwd)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Password".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}
		
		$join_type = 'left';
		$tableNameJoin1 = 'user_groups ug';
		$tableNameJoin2 = 'users u';
		$select = 'count(u.user_id) as count_user, user_id';
		$where = array(
					'u.username' => $username,
					'u.password' => $password,
					'u.status' => $status,
					'u.delete_status' => $delete_status,
					'ug.status' => YES,
					'ug.delete_status' => NO
				);
		$where_in_field = 'ug.role';
		$where_in_val = array(ROLE_SUPER_ADMIN,ROLE_SUB_ADMIN);		
		$join_where = 'ug.group_id = u.group_id';
		
		$get_row = $this->main_model->get_first_row_with_join($select,$where,$where_in_field,$where_in_val,$join_where,$tableNameJoin1,$tableNameJoin2,$join_type);
		$users_count = $get_row->count_user;
		if($users_count > 0) {
			
			$user_id = $get_row->user_id;
			
			if($remember == '1') {
				
				set_cookie(ADMIN_COOKIE_USERNAME, $this->encryptIt($username), COOKIE_TIME);
				set_cookie(ADMIN_COOKIE_PASSWORD, $password, COOKIE_TIME);
			}
			
			$this->session->set_userdata(ADMIN_SESSION_ID, $user_id);

			$arr['response'] = true;
			$arr['msg'] = VALID_LOGIN;
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = false;
			$arr['msg'] = INVALID_LOGIN;
			echo json_encode($arr);
			exit();
		}
	}
	
	/* get logout */
	public function get_logout() {
		
		$this->session->unset_userdata(ADMIN_SESSION_ID);
		redirect(base_url(ADMIN_PATH.'login/'));
	}

}

/* 

End of file :- 

location :- application/controllers/login_controller.php

*/

?>