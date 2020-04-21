<?php

/*

location :- application/controllers/forgotpassword_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Forgotpassword_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
	}
	
	/* display a view page */
	public function create() {
		
		$this->goToAdminDashboard();
		
		$data = array();
		$data['title'] = 'Forgot Password';
		$data['active_tab'] = ADMIN_PATH.'forgot-password';
		$data['page_content'] = ADMIN_PATH.'forgot-password/create';
		$data['includes'] = 'login';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* get forgot-password */
	public function get_forgot_password() {
		
		$this->notAjaxDirect();
		
		$email = $this->input->post("email");
		$delete_status = NO;
		
		$emailReg = EMAIL_REG;
		
		$arr = array();
		if(empty($email)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Email".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		}  else if(!preg_match($emailReg, $email)) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_VALID_EMAIL;
			echo json_encode($arr);
			exit();
		}
		
		$join_type = 'left';
		$tableNameJoin1 = 'user_groups ug';
		$tableNameJoin2 = 'users u';
		$select = 'count(u.user_id) as count_user';
		$where = array(
					'u.email' => $email,
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
		
			// $emailEncrypted = $this->encryptIt($email);	
			// $forgotUrl = base_url(ADMIN_PATH."reset-password/$emailEncrypted");
			// echo "Forgot Password <a href='".$forgotUrl."'>Click here</a>";
			
			$arr['response'] = true;
			$arr['msg'] = EMAIL_SEND_RESET_LINK;
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_EMAIL_EXIST;
			echo json_encode($arr);
			exit();
		}
	}
	
	/* verify reset-password */
	public function reset_password($email) {
	
		$this->goToAdminDashboard();
		
		$data = array();
		$data['title'] = 'Reset Password';
		$data['active_tab'] = ADMIN_PATH.'reset-password';
		$data['page_content'] = ADMIN_PATH.'forgot-password/reset-password';
		$data['includes'] = 'login';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* change reset-password */
	public function update_reset_password() {
		
		$this->notAjaxDirect();
		
		$emailEncrypted = $this->input->post("email");
		$email = $this->decryptIt($emailEncrypted);
		$new_pwd = $this->input->post("new_password");
		$new_password = $this->encryptIt($new_pwd);
		$confirm_pwd = $this->input->post("confirm_password");
		$confirm_password = $this->encryptIt($confirm_pwd);
		$delete_status = NO;
		
		$arr = array();
		if(empty($email)) {
			
			$arr['response'] = false;
			$arr['msg'] = TRY_AGAIN_LATER;
			echo json_encode($arr);
			exit();
			
		} else if(empty($new_pwd)) {
			
			$arr['response'] = false;
			$arr['msg'] = "New Password".IS_REQUIRED;
			echo json_encode($arr);
			exit();
			
		} else if(empty($confirm_pwd)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Confirm Password".IS_REQUIRED;
			echo json_encode($arr);
			exit();
			
		} else if($new_password != $confirm_password) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_SAME;
			echo json_encode($arr);
			exit();
		}
		
		$join_type = 'left';
		$tableNameJoin1 = 'user_groups ug';
		$tableNameJoin2 = 'users u';
		$select = 'count(u.user_id) as count_user';
		$where1 = array(
					'u.email' => $email,
					'u.delete_status' => $delete_status,
					'ug.status' => YES,
					'ug.delete_status' => NO
				);
		$where_in_field = 'ug.role';
		$where_in_val = array(ROLE_SUPER_ADMIN,ROLE_SUB_ADMIN);		
		$join_where = 'ug.group_id = u.group_id';
		
		$get_row = $this->main_model->get_first_row_with_join($select,$where1,$where_in_field,$where_in_val,$join_where,$tableNameJoin1,$tableNameJoin2,$join_type);		
		$users_count = $get_row->count_user;
		if($users_count > 0) {
		
			$update = array(
						'password' => $confirm_password,
						'modified_at' => CURRENT_DATETIME
					);
			$where2 = array(
						'u.email' => $email,
						'u.delete_status' => $delete_status
					);
		
			$updated_data = $this->main_model->update_data($where2,$update,$tableNameJoin1);
			if($updated_data == true) {
				
				delete_cookie(ADMIN_COOKIE_USERNAME);
				delete_cookie(ADMIN_COOKIE_PASSWORD);
				
				$arr['response'] = true;
				$arr['msg'] = PASSWORD_CHANGED;
				echo json_encode($arr); 
				exit();
				
			} else {
			
				$arr['response'] = true;
				$arr['msg'] = PASSWORD_CHANGED;
				echo json_encode($arr); 
				exit();
			}
			
		} else {
		
			$arr['response'] = false;
			$arr['msg'] = NOT_EMAIL_EXIST;
			echo json_encode($arr);
			exit();
		}
	}
}

/* 

End of file :- 

location :- application/controllers/forgotpassword_controller.php

*/

?>