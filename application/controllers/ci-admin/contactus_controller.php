<?php

/* 

location :- application/controllers/contactus_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();
		
		$this->load->model(ADMIN_PATH.'contactus_model');
	}
	
	/* create contact us display */
	public function create() {
		
		$data = array();
		$data['title'] = 'Contact Us';
		$data['active_tab'] = ADMIN_PATH.'contact-us';
		$data['page_content'] = ADMIN_PATH.'contact-us/create';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* ajax data list */
	public function ajax_data_list() {
		
		$this->notAjaxDirect();
		
		$content = $this->contactus_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($content as $list) {
			
			$no++;
			$id = $list->contact_us_id;
			$name = $list->name;
			$_email = $list->email;
			$email = '<a href="mailto:'.$_email.'">'.$_email.'</a>';
			$subject = $list->subject;
			$status = $list->status;
			$checkbox = '<input type="checkbox" id="chkSingle_'.$id.'" name="chkSingle[]" class="chkSingle margin-left-right-auto" data-id="'.$id.'" onClick="checkSingle(this.checked);" />';
			
			$row = array();
			$row[] = $checkbox;
			$row[] = $no;
			$row[] = $name;
			$row[] = $email;
			$row[] = $subject;

			$status_img = '';
			if($status == YES) {
				
				$deactivate_url = base_url(ADMIN_PATH.'change-status-contact-us/'.$id.'/'.NO.'/');
				$status_img = '<span data-toggle="modal" data-target="#wrongModal_'.$id.'">
									<a role="button" data-tooltip="tooltip" data-placement="top" title="Activate">'.DEACTIVATE_ICON.'</a>
								</span>
								<div id="wrongModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="wrongModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="wrongModalLabel">Are you sure want to Deactivate Contact?</h5>
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
				
				$activate_url = base_url(ADMIN_PATH.'change-status-contact-us/'.$id.'/'.YES.'/');
				$status_img = '<span data-toggle="modal" data-target="#rightModal_'.$id.'">
									<a role="button" data-tooltip="tooltip" data-placement="top" title="Deactivate">'.ACTIVATE_ICON.'</a>
								</span>
								<div id="rightModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rightModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="rightModalLabel">Are you sure want to Activate Contact?</h5>
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
			
			$edit_url = base_url(ADMIN_PATH.'edit-contact-us/'.$id.'/');
			$edit = '<a href="'.$edit_url.'" data-tooltip="tooltip" title="Edit">'.EDIT_ICON.'</a>';
						
			$view_url = base_url(ADMIN_PATH.'view-contact-us/'.$id.'/');
			$view = '<a href="'.$view_url.'" data-tooltip="tooltip" title="View">'.VIEW_ICON.'</a>';
			
			$row[] = $edit."&nbsp;".$view;
			
			$data[] = $row;
		}
			
		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->contactus_model->count_all(),
					"recordsFiltered" => $this->contactus_model->count_filtered(),
					"data" => $data
				);
		echo json_encode($output);
		exit();
	}	
	
	/* change status */
	public function change_status($id,$val) {				
		
		$tableName = 'contact_us';
		$where = array(
					'contact_us_id' => $id
				);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'status' => $val
				);		
			
		$change_status_val = $this->main_model->update_data($where,$update,$tableName);
		if($change_status_val == true) {
			
			redirect(base_url(ADMIN_PATH.'contact-us/'));
			exit();
		}
	}
	
	/* change delete status */
	public function change_delete_status() {				
		
		$ids = trim($this->input->post("ids"));

		$tableName = 'contact_us';
		$where_in_field = 'contact_us_id';
		$where_in_val = explode(",",$ids);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'delete_status' => YES
				);		
		
		$arr = array();
		$delete_val = $this->main_model->update_multiple_data($where_in_field,$where_in_val,$update,$tableName);
		if($delete_val == true) {
			
			$arr['response'] = true;
			$this->session->set_flashdata('warning','Contact Us Deleted Successfully');

		} else {
			
			$arr['response'] = false;
			$this->session->set_flashdata('error','Please try again later');
		}
		echo json_encode($arr);
		exit();
	}
	
	/* edit contact-us create page */
	public function edit_contact_us($id) {
		
		$tableNameEdit = 'contact_us';
		$selectEdit = 'name,email,subject,message,reply';
		$whereEdit = array(
						'contact_us_id' => $id,
						'delete_status' => NO
					);
		$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
		
		/* check data exist in table or not */
		$this->show404Page($editData);
				
		$data = array();
		$data['title'] = 'Edit Contact Us';
		$data['active_tab'] = ADMIN_PATH.'edit-contact-us';
		$data['page_content'] = ADMIN_PATH.'contact-us/edit-contact-us';
		$data['edit'] = $editData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store edit contact-us */
	public function storeEdit() {				
		
		$this->notAjaxDirect();
		
		$id = trim($this->input->post("id"));
		$reply = trim($this->input->post("reply"));
		$reply_textonly = strip_tags($reply);
		
		$arr = array();
		if(empty($reply)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Reply".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}
		
		$tableName = 'contact_us';
		$where = array(
					'contact_us_id ' => $id
				);
		$update = array(
					'reply' => $reply,
					'modified_at' => CURRENT_DATETIME
				);
	
		$updated_data = $this->main_model->update_data($where,$update,$tableName);
		if($updated_data == true) {
			
			$arr['response'] = true;
			$arr['msg'] = "Reply Sended Successfully";
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = true;
			$arr['msg'] = "Reply Sended Successfully";
			echo json_encode($arr);
			exit();
		}
	}
	
	/* view contact-us page */
	public function view_contact_us($id) {
		
		$tableNameView = 'contact_us';
		$selectView = 'name,email,subject,message,reply';
		$whereView = array(
						'contact_us_id' => $id,
						'delete_status' => NO
					);
		$viewData = $this->main_model->get_first_row($selectView,$whereView,$tableNameView);
		
		/* check data exist in table or not */
		$this->show404Page($viewData);
		
		$data = array();
		$data['title'] = 'View Contact Us';
		$data['active_tab'] = ADMIN_PATH.'view-contact-us';
		$data['page_content'] = ADMIN_PATH.'contact-us/view-contact-us';
		$data['view'] = $viewData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
}

/* 

End of file :- 

location :- application/controllers/contactus_controller.php

*/

?>