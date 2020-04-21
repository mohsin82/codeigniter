<?php

/*

location :- application/controllers/changepassword_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Changepassword_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();
	}
	
	/* display a view page */
	public function create() {
		
		$data = array();
		$data['title'] = 'Change Password';
		$data['active_tab'] = ADMIN_PATH.'change-password';
		$data['page_content'] = ADMIN_PATH.'change-password/create';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* change password */
	public function update_change_password() {
		
		$this->notAjaxDirect();

		$old_pwd = $this->input->post("old_password");
		$old_password = $this->encryptIt($old_pwd);
		$new_pwd = $this->input->post("new_password");
		$new_password = $this->encryptIt($new_pwd);
		$confirm_pwd = $this->input->post("confirm_password");
		$confirm_password = $this->encryptIt($confirm_pwd);
		
		$arr = array();
		if(empty($old_pwd)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Old Password".IS_REQUIRED;
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
		
		$tableName = 'users';
		$sess_id = $this->session->userdata(ADMIN_SESSION_ID);
		$select = 'count(user_id) as count_user';
		$where = array(
					'user_id' => $sess_id,
					'password' => $old_password
				);
		$update = array(
					'password' => $confirm_password,
					'modified_at' => CURRENT_DATETIME
				);
				
		$get_row = $this->main_model->get_first_row($select,$where,$tableName);		
		$count_user = $get_row->count_user;
		if($count_user > 0) {
			
			$updated_data = $this->main_model->update_data($where,$update,$tableName);
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
			$arr['msg'] = OLD_PASSWORD_INCORRECT;
			echo json_encode($arr);
			exit();
		}
	}
}

/* 

End of file :- 

location :- application/controllers/changepassword_controller.php

*/

?>