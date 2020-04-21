<?php

/* 

location :- application/controllers/user_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class User_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();
		
		$this->load->model(ADMIN_PATH.'user_model');
	}
	
	/* create user display */
	public function create() {
		
		$data = array();
		$data['title'] = 'Users';
		$data['active_tab'] = ADMIN_PATH.'users';
		$data['page_content'] = ADMIN_PATH.'user/create';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* ajax data list */
	public function ajax_data_list() {
		
		$this->notAjaxDirect();
		
		$content = $this->user_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($content as $list) {
			
			$no++;
			$id = $list->user_id;
			$username = $list->username;
			$_email = $list->email;
			$email = '<a href="mailto:'.$_email.'">'.$_email.'</a>';
			$_phone_no = $list->phone_no;
			$phone_no = '<a href="tel:'.$_phone_no.'">'.$_phone_no.'</a>';
			$group_name = $list->group_name;
			$status = $list->status;
			$checkbox = '<input type="checkbox" id="chkSingle_'.$id.'" name="chkSingle[]" class="chkSingle margin-left-right-auto" data-id="'.$id.'" onClick="checkSingle(this.checked);" />';
			
			$row = array();
			$row[] = $checkbox;
			$row[] = $no;
			$row[] = $username;
			$row[] = $email;
			$row[] = $phone_no;
			$row[] = $group_name;
			
			$status_img = '';
			if($status == YES) {
				
				$deactivate_url = base_url(ADMIN_PATH.'change-status-user/'.$id.'/'.NO.'/');
				$status_img = '<span data-toggle="modal" data-target="#wrongModal_'.$id.'">
									<a role="button" data-tooltip="tooltip" data-placement="top" title="Activate">'.DEACTIVATE_ICON.'</a>
								</span>
								<div id="wrongModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="wrongModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="wrongModalLabel">Are you sure want to Deactivate User?</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
												<a href="'.$deactivate_url.'" class="btn btn-danger">Deactivate</a>
											</div>
										</div>
									</div>
								</div>';
				
			} else {
				
				$activate_url = base_url(ADMIN_PATH.'change-status-user/'.$id.'/'.YES.'/');
				$status_img = '<span data-toggle="modal" data-target="#rightModal_'.$id.'">
									<a role="button" data-tooltip="tooltip" data-placement="top" title="Deactivate">'.ACTIVATE_ICON.'</a>
								</span>
								<div id="rightModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rightModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="rightModalLabel">Are you sure want to Activate User?</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
												<a href="'.$activate_url.'" class="btn btn-primary">Activate</a>
											</div>
										</div>
									</div>
								</div>';
			}
			$row[] = $status_img;

				
			$edit_url = base_url(ADMIN_PATH.'edit-user/'.$id.'/');
			$edit = '<a href="'.$edit_url.'" data-tooltip="tooltip" title="Edit">'.EDIT_ICON.'</a>';
						
			$view_url = base_url(ADMIN_PATH.'view-user/'.$id.'/');
			$view = '<a href="'.$view_url.'" data-tooltip="tooltip" title="View">'.VIEW_ICON.'</a>';
			
			$change_pwd_url = base_url(ADMIN_PATH.'change-password-user/'.$id.'/');
			$change_pwd = '<a href="'.$change_pwd_url.'" data-tooltip="tooltip" title="Change Password">'.CHANGE_PASSWORD_ICON.'</a>';

			$row[] = $edit."&nbsp;".$view."&nbsp;".$change_pwd;
			
			$data[] = $row;
		}
			
		$output = array(						
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->user_model->count_all(),
					"recordsFiltered" => $this->user_model->count_filtered(),
					"data" => $data
				);
		echo json_encode($output);
		exit();
	}
	
	/* change status */
	public function change_status($id,$val) {				
		
		$tableName = 'users';
		$where = array(
					'user_id' => $id
				);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'status' => $val
				);		
		
		$change_status_val = $this->main_model->update_data($where,$update,$tableName);
		if($change_status_val == true) {
			
			redirect(base_url(ADMIN_PATH.'users/'));
			exit();
		}
	}
		
	/* change delete status multiple */
	public function change_delete_status() {				
			
		$ids = trim($this->input->post("ids"));

		$tableName = 'users';
		$where_in_field = 'user_id';
		$where_in_val = explode(",",$ids);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'delete_status' => YES
				);		
		
		$arr = array();
		$delete_val = $this->main_model->update_multiple_data($where_in_field,$where_in_val,$update,$tableName);
		if($delete_val == true) {
			
			$arr['response'] = true;
			$this->session->set_flashdata('warning','User Deleted Successfully');

		} else {
			
			$arr['response'] = false;
			$this->session->set_flashdata('error','Please try again later');
		}
		echo json_encode($arr);
		exit();
	}
	
	/* add user create page */
	public function add_user() {				
			
		$tableName = 'user_groups';
		$select = 'group_id,name';
		$where = array(
					'role != ' => ROLE_SUPER_ADMIN,
					'status' => YES,
					'delete_status' => NO
				);
			
		$user_groups = $this->main_model->get_result_where($select,$where,$tableName);
		
		$data = array();
		$data['title'] = 'Add User';
		$data['active_tab'] = ADMIN_PATH.'add-user';
		$data['page_content'] = ADMIN_PATH.'user/add-user';
		$data['user_groups'] = $user_groups;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store add user */
	public function store() {				
			
		$this->notAjaxDirect();
		
		$first_name = trim($this->input->post("first_name"));
		$last_name = trim($this->input->post("last_name"));
		$username = trim($this->input->post("username"));
		$email = trim($this->input->post("email"));
		$phone_no = trim($this->input->post("phone_no"));
		$pwd = $this->input->post("password");
		$password = $this->encryptIt($pwd);
		$confirm_pwd = $this->input->post("confirm_password");
		$confirm_password = $this->encryptIt($confirm_pwd);
		$role = trim($this->input->post("role"));
		$status = trim($this->input->post("status"));
		$delete_status = NO;
		
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
			$arr['msg'] = NOT_SPECIAL_CHARECTER_OR_SPACE;
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
			
		} else if(empty($pwd)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Password".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(empty($confirm_pwd)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Confirm Password".IS_REQUIRED;
			echo json_encode($arr);
			exit();
			
		} else if($password != $confirm_password) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_SAME;
			echo json_encode($arr);
			exit();
		
		} else if($role == '0') {

			$arr['response'] = false;
			$arr['msg'] = "Role".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}
			
		$tableName = 'users';
		$select = 'count(user_id) as count_user';
		$usernameWhere = array(
							'username' => $username,
							'delete_status' => $delete_status
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
							'email' => $email,
							'delete_status' => $delete_status
						);

			$get_row2 = $this->main_model->get_first_row($select,$emailWhere,$tableName);
			$count_email = $get_row2->count_user;
			if($count_email > 0) {
		
				$arr['response'] = false;
				$arr['msg'] = "Email".ALREADY_EXIST;
				echo json_encode($arr);
				exit();
			
			} else {
				
				$phone_noWhere = array(
									'phone_no' => $phone_no,
									'delete_status' => $delete_status
								);

				$get_row3 = $this->main_model->get_first_row($select,$phone_noWhere,$tableName);
				$count_phone_no = $get_row3->count_user;
				if($count_phone_no > 0) {
			
					$arr['response'] = false;
					$arr['msg'] = "Phone Number".ALREADY_EXIST;
					echo json_encode($arr);
					exit();
				
				} else {

					$type = "single";
					$insert = array(
								'first_name' => $first_name,
								'last_name' => $last_name,
								'username' => $username,
								'email' => $email,
								'phone_no' => $phone_no,
								'password' => $password,
								'group_id' => $role,
								'created_at' => CURRENT_DATETIME,
								'status' => $status,
								'delete_status' => $delete_status
							);

					$inserted_data = $this->main_model->insert_data($insert,$tableName,$type);
					if($inserted_data != false) {
						
						// echo $inserted_data;
						// $to = $email;
						// $subject = "User Register";
						
						// $content = '';
						// eval("\$content = \"$content\";");
						// $emailContent = wordwrap($content,70);
						
							// $this->sendMail($to, $subject, $emailContent);
						
						$arr['response'] = true;
						$arr['msg'] = "User Added Successfully";
						echo json_encode($arr);
						exit();
						
					} else {
						
						$arr['response'] = false;
						$arr['msg'] = TRY_AGAIN_LATER;
						echo json_encode($arr);
						exit();
					}
				}
			}
		}
	}
	
	/* edit user create page */
	public function edit_user($id) {
		
		$tableName = 'user_groups';
		$select = 'group_id,name';
		$where = array(
					'role != ' => ROLE_SUPER_ADMIN,
					'status' => YES,
					'delete_status' => NO
				);
			
		$user_groups = $this->main_model->get_result_where($select,$where,$tableName);
		
		$tableNameEdit = 'users';
		$selectEdit = 'first_name,last_name,username,email,phone_no,group_id,status';
		$whereEdit = array(
						'user_id' => $id,
						'delete_status' => NO
					);
		$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
		
		/* check data exist in table or not */
		$this->show404Page($editData);
		
		$data = array();
		$data['title'] = 'Edit User';
		$data['active_tab'] = ADMIN_PATH.'edit-user';
		$data['page_content'] = ADMIN_PATH.'user/edit-user';
		$data['user_groups'] = $user_groups;
		$data['edit'] = $editData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store edit user */
	public function storeEdit() {				
			
		$this->notAjaxDirect();
		
		$id = trim($this->input->post("id"));
		$first_name = trim($this->input->post("first_name"));
		$last_name = trim($this->input->post("last_name"));
		$username = trim($this->input->post("username"));
		$email = trim($this->input->post("email"));
		$phone_no = trim($this->input->post("phone_no"));
		$role = trim($this->input->post("role"));
		$status = trim($this->input->post("status"));
		$delete_status = NO;
					
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
			$arr['msg'] = NOT_SPECIAL_CHARECTER_OR_SPACE;
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
			
		} else if($role == '0') {

			$arr['response'] = false;
			$arr['msg'] = "Role".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}


		$tableName = 'users';
		$select = 'count(user_id) as count_user';
		$usernameWhere = array(
							'user_id != ' => $id,
							'username' => $username,
							'delete_status' => $delete_status
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
							'email' => $email,
							'delete_status' => $delete_status
						);

			$get_row2 = $this->main_model->get_first_row($select,$emailWhere,$tableName);
			$count_email = $get_row2->count_user;
			if($count_email > 0) {
		
				$arr['response'] = false;
				$arr['msg'] = "Email".ALREADY_EXIST;
				echo json_encode($arr);
				exit();
			
			} else {
				
				$phone_noWhere = array(
									'user_id != ' => $id,
									'phone_no' => $phone_no,
									'delete_status' => $delete_status
								);

				$get_row3 = $this->main_model->get_first_row($select,$phone_noWhere,$tableName);
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
								'phone_no' => $phone_no,
								'group_id' => $role,
								'modified_at' => CURRENT_DATETIME,
								'status' => $status
							);
						
					$updated_data = $this->main_model->update_data($where,$update,$tableName);
					if($updated_data == true) {
						
						$arr['response'] = true;
						$arr['msg'] = "User Updated Successfully";
						echo json_encode($arr);
						exit();
						
					} else {
						
						$arr['response'] = true;
						$arr['msg'] = "User Updated Successfully";
						echo json_encode($arr);
						exit();
					}
				}
			}
		}
	}
	
	/* view user page */
	public function view_user($id) {
		
		$tableName = 'user_groups';
		$select = 'group_id,name';
		$where = array(
					'status' => YES,
					'delete_status' => NO
				);
			
		$user_groups = $this->main_model->get_result_where($select,$where,$tableName);
		
		$tableNameView = 'users';
		$selectView = 'first_name,last_name,username,email,phone_no,group_id,status';
		$whereView = array(
						'user_id' => $id,
						'delete_status' => NO
					);
		$viewData = $this->main_model->get_first_row($selectView,$whereView,$tableNameView);
		
		/* check data exist in table or not */
		$this->show404Page($viewData);

		$data = array();
		$data['title'] = 'View User';
		$data['active_tab'] = ADMIN_PATH.'view-user';
		$data['page_content'] = ADMIN_PATH.'user/view-user';
		$data['user_groups'] = $user_groups;
		$data['view'] = $viewData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}

	/* change password create page */
	public function change_password($id) {
		
		$data = array();
		$data['title'] = 'Change Password';
		$data['active_tab'] = ADMIN_PATH.'change-password';
		$data['page_content'] = ADMIN_PATH.'user/change-password';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}

	/* update change password user */
	public function update_change_password() {
		
		$this->notAjaxDirect();

		$id = $this->input->post("id");
		$new_pwd = $this->input->post("new_password");
		$new_password = $this->encryptIt($new_pwd);
		$confirm_pwd = $this->input->post("confirm_password");
		$confirm_password = $this->encryptIt($confirm_pwd);
		
		$arr = array();
		if(empty($new_pwd)) {
			
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
		$select = 'count(user_id) as count_user';
		$where = array(
					'user_id' => $id
				);
		$update = array(
					'password' => $confirm_password,
					'modified_at' => CURRENT_DATETIME
				);
				
		$updated_data = $this->main_model->update_data($where,$update,$tableName);
		if($updated_data == true) {
			
			$arr['response'] = true;
			$arr['msg'] = "Password is Successfully changed";
			echo json_encode($arr);
			exit();
			
		} else {
		
			$arr['response'] = true;
			$arr['msg'] = "Password is Successfully changed";
			echo json_encode($arr);
			exit();
		}
	}
}

/* 

End of file :- 

location :- application/controllers/user_controller.php

*/

?>