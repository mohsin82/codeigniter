<?php

/* 

location :- application/controllers/emailtemplate_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Emailtemplate_controller extends MY_Controller {
	
	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();

		$this->load->model(ADMIN_PATH.'emailtemplate_model');
	}
	
	/* display a view page */
	public function create() {
		
		$data = array();
		$data['title'] = 'Email Templates';
		$data['active_tab'] = ADMIN_PATH.'email-templates';
		$data['page_content'] = ADMIN_PATH.'email-template/create';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}

	/* ajax data list */
	public function ajax_data_list() {
		
		$this->notAjaxDirect();
		
		$content = $this->emailtemplate_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($content as $list) {
			
			$no++;
			$id = $list->email_template_id;
			$subject = $list->subject;
			$mess = $list->message;
			$status = $list->status;
			$checkbox = '<input type="checkbox" id="chkSingle_'.$id.'" name="chkSingle[]" class="chkSingle margin-left-right-auto" data-id="'.$id.'" onClick="checkSingle(this.checked);" />';

			$row = array();
			$row[] = $checkbox;
			$row[] = $no;
			$row[] = $subject;
			
			$message = '';
			if(strlen($mess) > 100) {
				
				$message = substr($mess,0,100).'...';
				
			} else {

				$message = $mess;
			}
			$row[] = $message;
			
			$status_img = '';
			if($status == YES) {
				
				$deactivate_url = base_url(ADMIN_PATH.'change-status-email-template/'.$id.'/'.NO.'/');
				$status_img = '<span data-toggle="modal" data-target="#wrongModal_'.$id.'">
									<a role="button" data-tooltip="tooltip" data-placement="top" title="Activate">'.DEACTIVATE_ICON.'</a>
								</span>
								<div id="wrongModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="wrongModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="wrongModalLabel">Are you sure want to Deactivate Email Template?</h5>
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
				
				$activate_url = base_url(ADMIN_PATH.'change-status-email-template/'.$id.'/'.YES.'/');
				$status_img = '<span data-toggle="modal" data-target="#rightModal_'.$id.'">
									<a role="button" data-tooltip="tooltip" data-placement="top" title="Deactivate">'.ACTIVATE_ICON.'</a>
								</span>
								<div id="rightModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rightModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="rightModalLabel">Are you sure want to Activate Email Template?</h5>
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
		
			$edit_url = base_url(ADMIN_PATH.'edit-email-template/'.$id.'/');
			$edit = '<a href="'.$edit_url.'" data-tooltip="tooltip" title="Edit">'.EDIT_ICON.'</a>';
			
			$view_url = base_url(ADMIN_PATH.'view-email-template/'.$id.'/');
			$view = '<a href="'.$view_url.'" data-tooltip="tooltip" title="View">'.VIEW_ICON.'</a>';
						
			$row[] = $edit."&nbsp;".$view;
			
			$data[] = $row;
		}
			
		$output = array(						
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->emailtemplate_model->count_all(),
					"recordsFiltered" => $this->emailtemplate_model->count_filtered(),
					"data" => $data
				);
		echo json_encode($output);
		exit();
	}	
	
	/* change status */
	public function change_status($id,$val) {				
		
		$tableName = 'email_templates';
		$where = array(
					'email_template_id' => $id
				);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'status' => $val
				);		
		
		$change_status_val = $this->main_model->update_data($where,$update,$tableName);
		if($change_status_val == true) {
			
			redirect(base_url(ADMIN_PATH.'email-templates/'));
			exit();
		}
	}
	
	/* change delete status */
	public function change_delete_status() {				
		
		$ids = trim($this->input->post("ids"));

		$tableName = 'email_templates';
		$where_in_field = 'email_template_id';
		$where_in_val = explode(",",$ids);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'delete_status' => YES
				);		
		
		$arr = array();
		$delete_val = $this->main_model->update_multiple_data($where_in_field,$where_in_val,$update,$tableName);
		if($delete_val == true) {
			
			$arr['response'] = true;
			$this->session->set_flashdata('warning','Email Template Deleted Successfully');

		} else {
			
			$arr['response'] = false;
			$this->session->set_flashdata('error','Please try again later');
		}
		echo json_encode($arr);
		exit();
	}
	
	/* add email template create page */
	public function add_email_template() {
		
		$data = array();
		$data['title'] = 'Add Email Template';
		$data['active_tab'] = ADMIN_PATH.'add-email-template';
		$data['page_content'] = ADMIN_PATH.'email-template/add-email-template';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store email template */
	public function store() {				
		
		$this->notAjaxDirect();
		
		$subject = trim($this->input->post("subject"));
		$message = trim($this->input->post("message"));
		$message_textonly = strip_tags($message);
		$status = trim($this->input->post("status"));
		$delete_status = NO;
		
		$subjectReg = ALPHA_SPACE_REG;
		
		$arr = array();
		if(empty($subject)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Subject".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($subjectReg, $subject)) {
			
			$arr['response'] = false;
			$arr['msg'] = ONLY_ALPHA_AND_SPACE;
			echo json_encode($arr);
			exit();
		
		} else if(empty($message)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Message".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}
		
		$type = "single";
		$tableName = 'email_templates';
		$insert = array(
					'subject' => $subject,
					'message' => $message,
					'created_at' => CURRENT_DATETIME,
					'status' => $status,
					'delete_status' => $delete_status
				);

		$inserted_data = $this->main_model->insert_data($insert,$tableName,$type);
		if($inserted_data != false) {
			
			$arr['response'] = true;
			$arr['msg'] = "Email Template Added Successfully";
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = false;
			$arr['msg'] = TRY_AGAIN_LATER;
			echo json_encode($arr);
			exit();
		}
	}

	/* edit email template create page */
	public function edit_email_template($id) {
		
		$tableNameEdit = 'email_templates';
		$selectEdit = 'subject,message,status';
		$whereEdit = array(
						'email_template_id' => $id,
						'delete_status' => NO
					);
		$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
		
		/* check data exist in table or not */
		$this->show404Page($editData);
		
		$data = array();
		$data['title'] = 'Edit Email Template';
		$data['active_tab'] = ADMIN_PATH.'edit-email-template';
		$data['page_content'] = ADMIN_PATH.'email-template/edit-email-template';
		$data['edit'] = $editData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store edit email template */
	public function storeEdit() {				
		
		$this->notAjaxDirect();
		
		$id = trim($this->input->post("id"));
		$subject = trim($this->input->post("subject"));
		$message = trim($this->input->post("message"));
		$message_textonly = strip_tags($message);
		$status = trim($this->input->post("status"));
		
		$subjectReg = ALPHA_SPACE_REG;
		
		$arr = array();
		if(empty($subject)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Subject".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($subjectReg, $subject)) {
			
			$arr['response'] = false;
			$arr['msg'] = ONLY_ALPHA_AND_SPACE;
			echo json_encode($arr);
			exit();
		
		} else if(empty($message)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Message".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}
		
		$tableName = 'email_templates';
		
			$where = array(
						'email_template_id ' => $id
					);
			$update = array(
						'subject' => $subject,
						'message' => $message,
						'modified_at' => CURRENT_DATETIME,
						'status' => $status
					);
		
			$updated_data = $this->main_model->update_data($where,$update,$tableName);
			if($updated_data == true) {
				
				$arr['response'] = true;
				$arr['msg'] = "Email Template Updated Successfully";
				echo json_encode($arr);
				exit();
				
			} else {
			
				$arr['response'] = true;
				$arr['msg'] = "Email Template Updated Successfully";
				echo json_encode($arr);
				exit();
			}
	}
	
	/* view email template page */
	public function view_email_template($id) {
		
		$tableNameView = 'email_templates';
		$selectView = 'subject,message,status';
		$whereView = array(
						'email_template_id' => $id,
						'delete_status' => NO
					);
		$viewData = $this->main_model->get_first_row($selectView,$whereView,$tableNameView);
		
		/* check data exist in table or not */
		$this->show404Page($viewData);
		
		$data = array();
		$data['title'] = 'View Email Template';
		$data['active_tab'] = ADMIN_PATH.'view-email-template';
		$data['page_content'] = ADMIN_PATH.'email-template/view-email-template';
		$data['view'] = $viewData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	} 
}

/* 

End of file :- 

location :- application/controllers/emailtemplate_controller.php

*/

?>