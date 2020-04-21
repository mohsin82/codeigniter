<?php

/* 

location :- application/controllers/myaccount_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount_controller extends MY_Controller {
	
	/* function construct */
	function __construct() {
		
		parent::__construct();

		$this->goToAdminLogin();
	}
	
	/* display a my-account page */
	public function create() {
		
		$id = $this->session->userdata(ADMIN_SESSION_ID);
		
		$tableName = 'users';
		$select = 'first_name,last_name,username,email,phone_no';
		$where = array(
					'user_id' => $id,
					'delete_status' => NO
				);
					
		$accountData = $this->main_model->get_first_row($select,$where,$tableName);
		
		/* check data exist in table or not */
		$this->show404Page($accountData);
		
		$data = array();
		$data['title'] = 'My Account';
		$data['active_tab'] = ADMIN_PATH.'my-account';
		$data['page_content'] = ADMIN_PATH.'my-account/create';
		$data['edit'] = $accountData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store my-account */
	public function update_my_acoount() {				
		
		$this->notAjaxDirect();
		
		$id = $this->session->userdata(ADMIN_SESSION_ID);
		
		$first_name = trim($this->input->post("first_name"));
		$last_name = trim($this->input->post("last_name"));
		$username = trim($this->input->post("username"));
		$email = trim($this->input->post("email"));
		$phone_no = trim($this->input->post("phone_no"));
		
		$usernameReg = ALPHA_NUMERIC_REG;
		$emailReg = EMAIL_REG;
		$phone_noReg = NUMERIC_REG;
		
		$arr = array();
		if(empty($username)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Username".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($usernameReg, $username)) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_SPECIAL_CHARECTER;
			echo json_encode($arr);
			exit();
		
		} else if(empty($email)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Email".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($emailReg, $email)) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_VALID_EMAIL;
			echo json_encode($arr);
			exit();
		
		} else if(empty($phone_no)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Phone Number".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($phone_noReg, $phone_no)) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_VALID_PHONE;
			echo json_encode($arr);
			exit();
		}
		
		$tableName = 'users';
		$select = 'count(user_id) as count_user';
		$usernameWhere = array(
							'user_id != ' => $id,
							'username' => $username
						);
						
		$get_row1 = $this->main_model->get_first_row($select,$usernameWhere,$tableName);		
		$count_username = $get_row1->count_user;
		if($count_username > 0) {
		
			$arr['response'] = false;
			$arr['msg'] = "Username".ALREADY_EXIST;
			echo json_encode($arr);
			exit();
			
		} else {
			
			$emailWhere = array(
							'user_id != ' => $id,
							'email' => $email
						);

			$get_row2 = $this->main_model->get_first_row($select,$emailWhere,$tableName);
			$count_email = $get_row2->count_user;
			if($count_email > 0) {
		
				$arr['response'] = false;
				$arr['msg'] = "Email".ALREADY_EXIST;
				echo json_encode($arr);
				exit();
			
			} else {

				$phoneWhere = array(
								'user_id != ' => $id,
								'phone_no' => $phone_no
							);
			
				$get_row3 = $this->main_model->get_first_row($select,$phoneWhere,$tableName);
				$count_phone_no = $get_row3->count_user;
				if($count_phone_no > 0) {
			
					$arr['response'] = false;
					$arr['msg'] = "Phone Number".ALREADY_EXIST;
					echo json_encode($arr);
					exit();
				
				} else {
				
					$where = array(
								'user_id ' => $id
							);
					$update = array(
								'first_name' => $first_name,
								'last_name' => $last_name,
								'username' => $username,
								'email' => $email,
								'phone_no' => $phone_no
							);
				
					$updated_data = $this->main_model->update_data($where,$update,$tableName);
					if($updated_data == true) {
						
						$arr['response'] = true;
						$arr['msg'] = "Account Updated Successfully";
						echo json_encode($arr);
						exit();
						
					} else {
						
						$arr['response'] = true;
						$arr['msg'] = "Account Updated Successfully";
						echo json_encode($arr);
						exit();
					}
				}
			}
		}
	}
	
}

/* 

End of file :- 

location :- application/controllers/myaccount_controller.php

*/

?>