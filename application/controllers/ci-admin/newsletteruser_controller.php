<?php

/* 

location :- application/controllers/newsletteruser_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletteruser_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();

		$this->load->model(ADMIN_PATH.'newsletteruser_model');
	}
	
	/* create newsletter user display */
	public function create() {
		
		$fromDate = "0";
		$toDate = "0";
		if( !empty($this->input->get_post("fromDate")) && !empty($this->input->get_post("toDate")) ) {
			
			$fromDate = $this->input->get_post("fromDate");
			$toDate = $this->input->get_post("toDate");
		}
		
		$data = array();
		$data['title'] = 'Newsletter User';
		$data['active_tab'] = ADMIN_PATH.'newsletter-users';
		$data['page_content'] = ADMIN_PATH.'newsletter-user/create';
		$data['fromDate'] = $fromDate;
		$data['toDate'] = $toDate;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
		
	/* ajax data list */
	public function ajax_data_list($start_date,$end_date) {
		
		$this->notAjaxDirect();
		
		$startDate = $endDate = 0;
		if($start_date != "0" && $end_date != "0") {

			$from_date_format = "Y-m-d 00:00:00";
			$startDate = $this->convertDateFormat($from_date_format,$start_date);

			$to_date_format = "Y-m-d 23:59:59";
			$endDate = $this->convertDateFormat($to_date_format,$end_date);
		}

		$user = $this->newsletteruser_model->get_datatables($startDate,$endDate);
		$data = array();
		$no = $_POST['start'];
		foreach ($user as $list) {
			
			$no++;
			$id = $list->newsletter_user_id;
			$_email = $list->email;
			$email = '<a href="mailto:'.$_email.'">'.$_email.'</a>';
			$status = $list->status;
			$checkbox = '<input type="checkbox" id="chkSingle_'.$id.'" name="chkSingle[]" class="chkSingle margin-left-right-auto" data-id="'.$id.'" onClick="checkSingle(this.checked);" />';
			
			$row = array();
			$row[] = $checkbox;
			$row[] = $no;
			$row[] = $email;
			
			$status_img = '';
			if($status == YES) {
				
				$deactivate_url = base_url(ADMIN_PATH.'change-status-newsletter-user/'.$id.'/'.NO.'/');
				$status_img = '<span data-toggle="modal" data-target="#wrongModal_'.$id.'">
									<a role="button" data-tooltip="tooltip" data-placement="top" title="Activate">'.DEACTIVATE_ICON.'</a>
								</span>
								<div id="wrongModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="wrongModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="wrongModalLabel">Are you sure want to Deactivate Newsletter User?</h5>
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
				
				$activate_url = base_url(ADMIN_PATH.'change-status-newsletter-user/'.$id.'/'.YES.'/');
				$status_img = '<span data-toggle="modal" data-target="#rightModal_'.$id.'">
									<a role="button" data-tooltip="tooltip" data-placement="top" title="Deactivate">'.ACTIVATE_ICON.'</a>
								</span>
								<div id="rightModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rightModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="rightModalLabel">Are you sure want to Activate Newsletter User?</h5>
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
			
			$edit_url = base_url(ADMIN_PATH.'edit-newsletter-user/'.$id.'/');
			$edit = '<a href="'.$edit_url.'" data-tooltip="tooltip" title="Edit">'.EDIT_ICON.'</a>';
						
			$view_url = base_url(ADMIN_PATH.'view-newsletter-user/'.$id.'/');
			$view = '<a href="'.$view_url.'" data-tooltip="tooltip" title="View">'.VIEW_ICON.'</a>';
			
			$row[] = $edit."&nbsp;".$view;
			
			$data[] = $row;
		}
			
		$output = array(						
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->newsletteruser_model->count_all($startDate,$endDate),
					"recordsFiltered" => $this->newsletteruser_model->count_filtered($startDate,$endDate),
					"data" => $data
				);
		echo json_encode($output);
		exit();
	}	
	
	/* change status */
	public function change_status($id,$val) {				
		
		$tableName = 'newsletter_users';
		$where = array(
					'newsletter_user_id' => $id
				);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'status' => $val
				);		
		
		$change_status_val = $this->main_model->update_data($where,$update,$tableName);
		if($change_status_val == true) {
			
			redirect(base_url(ADMIN_PATH.'newsletter-users/'));
			exit();
		}
	}
	
	/* change delete status */
	public function change_delete_status() {				
		
		$ids = trim($this->input->post("ids"));

		$tableName = 'newsletter_users';
		$where_in_field = 'newsletter_user_id';
		$where_in_val = explode(",",$ids);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'delete_status' => YES
				);		
		
		$arr = array();
		$delete_val = $this->main_model->update_multiple_data($where_in_field,$where_in_val,$update,$tableName);
		if($delete_val == true) {
			
			$arr['response'] = true;
			$this->session->set_flashdata('warning','Newsletter User Deleted Successfully');

		} else {
			
			$arr['response'] = false;
			$this->session->set_flashdata('error','Please try again later');
		}
		echo json_encode($arr);
		exit();
	}
	
	/* add newsletter user create page */
	public function add_newsletter_user() {				
			
		$data = array();
		$data['title'] = 'Add Newsletter User';
		$data['active_tab'] = ADMIN_PATH.'add-newsletter-user';
		$data['page_content'] = ADMIN_PATH.'newsletter-user/add-newsletter-user';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store add newsletter user */
	public function store() {				
		
		$this->notAjaxDirect();
		
		$email = trim($this->input->post("email"));
		$status = trim($this->input->post("status"));
		$delete_status = NO;
		
		$emailReg = EMAIL_REG;
		
		$arr = array();
		if(empty($email)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Email".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($emailReg, $email)) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_VALID_EMAIL;
			echo json_encode($arr);
			exit();
		} 
		
		$tableName = 'newsletter_users';
		$select = 'count(newsletter_user_id) as count_newsletter_user';
		$emailWhere = array(
						'email' => $email,
						'delete_status' => $delete_status
					);		
		
		$get_row = $this->main_model->get_first_row($select,$emailWhere,$tableName);
		$count_newsletter_user = $get_row->count_newsletter_user;
		if($count_newsletter_user > 0) {
	
			$arr['response'] = false;
			$arr['msg'] = "Email is".ALREADY_EXIST;
			echo json_encode($arr);
			exit();
		
		} else {
				
			$type = "single";
			$insert = array(
						'email' => $email,
						'created_at' => CURRENT_DATETIME,
						'status' => $status,
						'delete_status' => $delete_status
					);

			$inserted_data = $this->main_model->insert_data($insert,$tableName,$type);
			if($inserted_data != false) {
				
				$arr['response'] = true;
				$arr['msg'] = "Newsletter User Added Successfully";
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

	/* edit newsletter user create page */
	public function edit_newsletter_user($id) {
		
		$tableNameEdit = 'newsletter_users';
		$selectEdit = 'email,status';
		$whereEdit = array(
						'newsletter_user_id' => $id,
						'delete_status' => NO
					);
		$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
		
		/* check data exist in table or not */
		$this->show404Page($editData);

		$data = array();
		$data['title'] = 'Edit Newsletter User';
		$data['active_tab'] = ADMIN_PATH.'edit-newsletter-user';
		$data['page_content'] = ADMIN_PATH.'newsletter-user/edit-newsletter-user';
		$data['edit'] = $editData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store edit newsletter user */
	public function storeEdit() {				
			
		$this->notAjaxDirect();
		
		$id = trim($this->input->post("id"));
		$email = trim($this->input->post("email"));
		$status = trim($this->input->post("status"));
		$delete_status = NO;
		
		$emailReg = EMAIL_REG;
		
		$arr = array();
		if(empty($email)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Email".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($emailReg, $email)) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_VALID_EMAIL;
			echo json_encode($arr);
			exit();
		}
		
		$tableName = 'newsletter_users';
		$select = 'count(newsletter_user_id) as count_newsletter_user';
		$emailWhere = array(
						'newsletter_user_id !=' => $id,
						'email' => $email,
						'delete_status' => $delete_status
					);		
		
		$get_row = $this->main_model->get_first_row($select,$emailWhere,$tableName);
		$count_newsletter_user = $get_row->count_newsletter_user;
		if($count_newsletter_user > 0) {
	
			$arr['response'] = false;
			$arr['msg'] = "Email is".ALREADY_EXIST;
			echo json_encode($arr);
			exit();
		
		} else {
			
			$where = array(
						'newsletter_user_id ' => $id
					);
			$update = array(
						'email' => $email,
						'modified_at' => CURRENT_DATETIME,
						'status' => $status
					);
		
			$updated_data = $this->main_model->update_data($where,$update,$tableName);
			if($updated_data == true) {
				
				$arr['response'] = true;
				$arr['msg'] = "Newsletter User Updated Successfully";
				echo json_encode($arr);
				exit();
				
			} else {
				
				$arr['response'] = true;
				$arr['msg'] = "Newsletter User Updated Successfully";
				echo json_encode($arr);
				exit();
			}
		}
	}
	
	/* view newsletter user page */
	public function view_newsletter_user($id) {
		
		$tableNameView = 'newsletter_users';
		$selectView = 'email,status';
		$whereView = array(
						'newsletter_user_id' => $id,
						'delete_status' => NO
					);
		$viewData = $this->main_model->get_first_row($selectView,$whereView,$tableNameView);
		
		/* check data exist in table or not */
		$this->show404Page($viewData);

		$data = array();
		$data['title'] = 'View Newsletter User';
		$data['active_tab'] = ADMIN_PATH.'view-newsletter-user';
		$data['page_content'] = ADMIN_PATH.'newsletter-user/view-newsletter-user';
		$data['view'] = $viewData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
}

/* 

End of file :- 

location :- application/controllers/newsletteruser_controller.php

*/

?>