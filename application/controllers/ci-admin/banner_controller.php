<?php

/* 

location :- application/controllers/banner_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();

		$this->load->model(ADMIN_PATH.'banner_model');
	}
	
	/* create banner display */
	public function create() {
		
		$data = array();
		$data['title'] = 'Banners';
		$data['active_tab'] = ADMIN_PATH.'banners';
		$data['page_content'] = ADMIN_PATH.'banner/create';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* ajax data list */
	public function ajax_data_list() {
		
		$this->notAjaxDirect();
		
		$content = $this->banner_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($content as $list) {

			$no++;
			$id = $list->banner_id;
			$name = $list->name;
			$status = $list->status;
			$checkbox = '<input type="checkbox" id="chkSingle_'.$id.'" name="chkSingle[]" class="chkSingle margin-left-right-auto" data-id="'.$id.'" onClick="checkSingle(this.checked);" />';
			
			$row = array();
			$row[] = $checkbox;
			$row[] = $no;
			$row[] = $name;
			
			$status_img = '';
			if($status == YES) {
				
				$deactivate_url = base_url(ADMIN_PATH.'change-status-banner/'.$id.'/'.NO.'/');
				$status_img = '<span data-toggle="modal" data-target="#wrongModal_'.$id.'">
									<a role="button" data-tooltip="tooltip" data-placement="top" title="Activate">'.DEACTIVATE_ICON.'</a>
								</span>
								<div id="wrongModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="wrongModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="wrongModalLabel">Are you sure want to Deactivate Banner?</h5>
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
				
				$activate_url = base_url(ADMIN_PATH.'change-status-banner/'.$id.'/'.YES.'/');
				$status_img = '<span data-toggle="modal" data-target="#rightModal_'.$id.'">
									<a role="button" data-tooltip="tooltip" data-placement="top" title="Deactivate">'.ACTIVATE_ICON.'</a>
								</span>
								<div id="rightModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rightModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="rightModalLabel">Are you sure want to Activate Banner?</h5>
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
			
			$image_url = base_url(ADMIN_PATH.'banner-images/'.$id.'/');
			$image = '<a href="'.$image_url.'" data-tooltip="tooltip" title="Image">'.IMAGE_ICON.'</a>';

			$edit_url = base_url(ADMIN_PATH.'edit-banner/'.$id.'/');
			$edit = '<a href="'.$edit_url.'" data-tooltip="tooltip" title="Edit">'.EDIT_ICON.'</a>';

			$row[] = $image."&nbsp;".$edit;
				
			$data[] = $row;
		}
			
		$output = array(						
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->banner_model->count_all(),
					"recordsFiltered" => $this->banner_model->count_filtered(),
					"data" => $data
				);					
		echo json_encode($output);
		exit();
	}	
	
	/* change status */
	public function change_status($id,$val) {				
		
		$tableName = 'banners';
		$where = array(
					'banner_id' => $id
				);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'status' => $val
				);		
		
		$change_status_val = $this->main_model->update_data($where,$update,$tableName);
		if($change_status_val == true) {
			
			redirect(base_url(ADMIN_PATH.'banners/'));
			exit();
		}
	}

	/* change delete status */
	public function change_delete_status() {				
		
		$ids = trim($this->input->post("ids"));

		$tableName1 = 'banners';
		$where_in_field1 = 'banner_id';
		$where_in_val1 = explode(",",$ids);
		$update1 = array(
					'modified_at' => CURRENT_DATETIME,
					'delete_status' => YES
				);	
		
		$arr = array();
		$delete_val1 = $this->main_model->update_multiple_data($where_in_field1,$where_in_val1,$update1,$tableName1);
		if($delete_val1 == true) {
			
			$tableName2 = 'banner_images';
			$where_in_field2 = 'banner_id';
			$where_in_val2 = explode(",",$ids);
			$update2 = array(
						'modified_at' => CURRENT_DATETIME,
						'delete_status' => YES
					);

			$delete_val2 = $this->main_model->update_multiple_data($where_in_field2,$where_in_val2,$update2,$tableName2);

			$arr['response'] = true;
			$this->session->set_flashdata('warning','Banner Deleted Successfully');

		} else {
			
			$arr['response'] = false;
			$this->session->set_flashdata('error','Please try again later');
		}
		echo json_encode($arr);
		exit();
	}
	
	/* add banner create page */
	public function add_banner() {				
		
		$data = array();
		$data['title'] = 'Add Banner';
		$data['active_tab'] = ADMIN_PATH.'add-banner';
		$data['page_content'] = ADMIN_PATH.'banner/add-banner';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store add user */
	public function store() {				
		
		$this->notAjaxDirect();
		
		$name = trim($this->input->post("name"));
		$status = trim($this->input->post("status"));
		$delete_status = NO;
		
		$nameReg = ALPHA_SPACE_REG;
		
		$arr = array();
		if(empty($name)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Name".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($nameReg, $name)) {
			
			$arr['response'] = false;
			$arr['msg'] = ONLY_ALPHA_AND_SPACE;
			echo json_encode($arr);
			exit();
		}
			
		$type = "single";
		$tableName = 'banners';
		$insert = array(
					'name' => $name,
					'created_at' => CURRENT_DATETIME,
					'status' => $status,
					'delete_status' => $delete_status
				);

		$inserted_data = $this->main_model->insert_data($insert,$tableName,$type);
		if($inserted_data != false) {
			
			$arr['response'] = true;
			$arr['msg'] = "Banner Added Successfully";
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = false;
			$arr['msg'] = TRY_AGAIN_LATER;
			echo json_encode($arr);
			exit();
		}
	}
	
	/* edit banner create page */
	public function edit_banner($id) {				
		
		$tableNameEdit = 'banners';
		$selectEdit = 'name,status';
		$whereEdit = array(
						'banner_id' => $id,
						'delete_status' => NO
					);
		$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
		
		/* check data exist in table or not */
		$this->show404Page($editData);
				
		$data = array();
		$data['title'] = 'Edit Banner';
		$data['active_tab'] = ADMIN_PATH.'edit-banner';
		$data['page_content'] = ADMIN_PATH.'banner/edit-banner';
		$data['edit'] = $editData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store edit user */
	public function storeEdit() {				
		
		$this->notAjaxDirect();
		
		$id = trim($this->input->post("id"));
		$name = trim($this->input->post("name"));
		$status = trim($this->input->post("status"));
		$delete_status = NO;
		
		$nameReg = ALPHA_SPACE_REG;
		
		$arr = array();
		if(empty($name)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Name".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($nameReg, $name)) {
			
			$arr['response'] = false;
			$arr['msg'] = ONLY_ALPHA_AND_SPACE;
			echo json_encode($arr);
			exit();
		}
			
		$tableName = 'banners';
		$where = array(
					'banner_id ' => $id
				);
		$update = array(
					'name' => $name,
					'modified_at' => CURRENT_DATETIME,
					'status' => $status
				);
	
		$updated_data = $this->main_model->update_data($where,$update,$tableName);
		if($updated_data == true) {
			
			$arr['response'] = true;
			$arr['msg'] = "Banner Updated Successfully";
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = true;
			$arr['msg'] = "Banner Updated Successfully";
			echo json_encode($arr);
			exit();
		}
	}
}

/* 

End of file :- 

location :- application/controllers/banner_controller.php

*/

?>