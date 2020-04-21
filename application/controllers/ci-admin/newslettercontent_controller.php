<?php

/* 

location :- application/controllers/newslettercontent_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Newslettercontent_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();

		$this->load->library('pagination');		
	}
	
	/* create content display */
	public function create() {
		
		$data = array();
		$data['title'] = 'Newsletter Content';
		$data['active_tab'] = ADMIN_PATH.'newsletter-content';
		$data['page_content'] = ADMIN_PATH.'newsletter-content/create';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}	

	/* get data */
	public function get_newsletter_content_data($page) {
		
		$tableName = 'newsletter_content';
		$select1 = 'count(newsletter_content_id) as count_newsletter_content';
		$where = array(
					'delete_status' => NO
				);
		
		/* pagination passing parameter */
		$main_data = '';
		$config = array();
		$get_row = $this->main_model->get_first_row($select1,$where,$tableName);
		$count_newsletter_content = $get_row->count_newsletter_content;
		if ($count_newsletter_content > 0) {

			$perPage = 1;

			$uri = $page;
			$start = ($uri - 1) * $perPage;

			$select2 = 'newsletter_content_id,title,description,status';
			$order_field = 'newsletter_content_id';
			$order_val = 'DESC';

			/* get current page records */
			$i = 0;
			$newsletterContentData = $this->main_model->get_result_where_with_order_and_pagination($select2,$where,$order_field,$order_val,$perPage,$start,$tableName);
			foreach($newsletterContentData as $row) {
				$i++;
				
				$no = (($uri * $perPage) - $perPage) + $i;
				
				$id = $row->newsletter_content_id;
				$title = $row->title;
				$desc = $row->description;
				$description = '';
				if(strlen($desc) > 100) {
					
					$description = substr($desc,0,100).'...';
				
				} else {
					
					$description = $desc;
				}
				$status = $row->status;

				$checkbox = '<input type="checkbox" id="chkSingle_'.$id.'" name="chkSingle[]" class="chkSingle margin-left-right-auto" data-id="'.$id.'" onClick="checkSingle(this.checked);" />';
			
				$status_img = '';
				if($status == YES) {

					$deactivate_url = base_url(ADMIN_PATH.'change-status-newsletter-content/'.$id.'/'.NO.'/'.$uri.'/');
					$status_img = '<span data-toggle="modal" data-target="#wrongModal_'.$id.'">
										<a role="button" data-tooltip="tooltip" data-placement="top" title="Activate">'.DEACTIVATE_ICON.'</a>
									</span>
									<div id="wrongModal_'.$id.'" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="wrongModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="wrongModalLabel">Are you sure want to Deactivate Newsletter Content?</h5>
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
					
					$activate_url = base_url(ADMIN_PATH.'change-status-newsletter-content/'.$id.'/'.YES.'/'.$uri.'/');
					$status_img = '<span data-toggle="modal" data-target="#rightModal_'.$id.'">
										<a role="button" data-tooltip="tooltip" data-placement="top" title="Deactivate">'.ACTIVATE_ICON.'</a>
									</span>
									<div id="rightModal_'.$id.'" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="rightModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="rightModalLabel">Are you sure want to Activate Newsletter Content?</h5>
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

				$edit = '<a href="'.base_url(ADMIN_PATH."edit-newsletter-content/$id/").'" data-tooltip="tooltip" title="Edit">'.EDIT_ICON.'</a>';
				$view = '<a href="'.base_url(ADMIN_PATH."view-newsletter-content/$id/").'" data-tooltip="tooltip" title="View">'.VIEW_ICON.'</a>';
				
				/* configuration of ajax pagination */
				$config['base_url'] = "#";
				$config['total_rows'] = $count_newsletter_content;
				$config['per_page'] = $perPage;
				$config["uri_segment"] = 3;
				
				/* custom paging configuration */
				$config['num_links'] = 1;
				$config['use_page_numbers'] = TRUE;
				$config['reuse_query_string'] = TRUE;

				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';

				$config['first_link'] = '<<';
				$config['first_tag_open'] = '<li class="firstlink">';
				$config['first_tag_close'] = '</li>';

				$config['last_link'] = '>>';
				$config['last_tag_open'] = '<li class="lastlink">';
				$config['last_tag_close'] = '</li>';

				$config['next_link'] = '>';
				$config['next_tag_open'] = '<li class="nextlink">';
				$config['next_tag_close'] = '</li>';

				$config['prev_link'] = '<';
				$config['prev_tag_open'] = '<li class="prevlink">';
				$config['prev_tag_close'] = '</li>';

				$config['cur_tag_open'] = '<li class="curlink active">';
				$config['cur_tag_close'] = '</li>';

				$config['num_tag_open'] = '<li class="numlink">';
				$config['num_tag_close'] = '</li>';

       	
				$this->pagination->initialize($config);

				/* build paging links */
				$pagination_links = $this->pagination->create_links();
	 	
				$main_data .= '<tr>'.
								'<td class="text-center">'.$checkbox.'</td>'.
								'<td>'.$no.'</td>'.
								'<td>'.$title.'</td>'.
								'<td>'.$description.'</td>'.
								'<td>'.$status_img.'</td>'.
								'<td>'.$edit.'&nbsp;'.$view.'</td>'.
							'</tr>';
			}

		} else {
								
			$main_data = '<tr>'.
							'<td class="text-center" colspan="5">No data available in table</td>'.
						'</tr>';
		}

		$output = array(
		 			'response' => true,
		 			'total_rows' => $count_newsletter_content,
		 			'main_data' => $main_data,
		 			'pagination_links' => $pagination_links
		 		) ;
	 	echo json_encode($output);
	 	exit;
	}	
	
	/* change status */
	public function change_status($id,$val,$uri) {				
			
		$tableName = 'newsletter_content';
		$where = array(
					'newsletter_content_id' => $id
				);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'status' => $val
				);		
		
		$change_status_val = $this->main_model->update_data($where,$update,$tableName);
		if($change_status_val == true) {
			
			redirect(base_url(ADMIN_PATH.'newsletter-content/'.$uri));
			exit();
		}
	}
	
	/* change delete status */
	public function change_delete_status() {				
		
		$ids = trim($this->input->post("ids"));

		$tableName = 'newsletter_content';
		$where_in_field = 'newsletter_content_id';
		$where_in_val = explode(",",$ids);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'delete_status' => YES
				);		
		
		$arr = array();
		$delete_val = $this->main_model->update_multiple_data($where_in_field,$where_in_val,$update,$tableName);
		if($delete_val == true) {
			
			$arr['response'] = true;
			$this->session->set_flashdata('warning','Newsletter Content Deleted Successfully');

		} else {
			
			$arr['response'] = false;
			$this->session->set_flashdata('error','Please try again later');
		}
		echo json_encode($arr);
		exit();
	}
	
	/* add newsletter content create page */
	public function add_newsletter_content() {				
			
		$data = array();
		$data['title'] = 'Add Newsletter Content';
		$data['active_tab'] = ADMIN_PATH.'add-newsletter-content';
		$data['page_content'] = ADMIN_PATH.'newsletter-content/add-newsletter-content';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store add newsletter content */
	public function store() {				
			
		$this->notAjaxDirect();
		
		$title = trim($this->input->post("title"));
		$description = trim($this->input->post("description"));
		$description_textonly = strip_tags($description);
		$status = trim($this->input->post("status"));
		$delete_status = NO;
		
		$titleReg = ALPHA_SPACE_REG;
		
		$arr = array();
		if(empty($title)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Title".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($titleReg, $title)) {
			
			$arr['response'] = false;
			$arr['msg'] = ONLY_ALPHA_AND_SPACE;
			echo json_encode($arr);
			exit();
		
		} else if(empty($description)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Description".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}
		
		$type = "single";
		$tableName = 'newsletter_content';
		$insert = array(
					'title' => $title,
					'description' => $description,
					'created_at' => CURRENT_DATETIME,
					'status' => $status,
					'delete_status' => $delete_status
				);

		$inserted_data = $this->main_model->insert_data($insert,$tableName,$type);
		if($inserted_data != false) {
			
			$arr['response'] = true;
			$arr['msg'] = "Newsletter Content Added Successfully";
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = false;
			$arr['msg'] = TRY_AGAIN_LATER;
			echo json_encode($arr);
			exit();
		}
	}

	/* edit newsletter content create page */
	public function edit_newsletter_content($id) {
		
		$tableNameEdit = 'newsletter_content';
		$selectEdit = 'title,description,status';
		$whereEdit = array(
						'newsletter_content_id' => $id,
						'delete_status' => NO
					);
		$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
		
		/* check data exist in table or not */
		$this->show404Page($editData);
		
		$data = array();
		$data['title'] = 'Edit Newsletter Content';
		$data['active_tab'] = ADMIN_PATH.'edit-newsletter-content';
		$data['page_content'] = ADMIN_PATH.'newsletter-content/edit-newsletter-content';
		$data['edit'] = $editData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store edit newsletter content */
	public function storeEdit() {				
		
		$this->notAjaxDirect();
		
		$id = trim($this->input->post("id"));
		$title = trim($this->input->post("title"));
		$description = trim($this->input->post("description"));
		$description_textonly = strip_tags($description);
		$status = trim($this->input->post("status"));
		$delete_status = NO;
		
		$titleReg = ALPHA_SPACE_REG;
		
		$arr = array();
		if(empty($title)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Title".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($titleReg, $title)) {
			
			$arr['response'] = false;
			$arr['msg'] = ONLY_ALPHA_AND_SPACE;
			echo json_encode($arr);
			exit();
		
		} else if(empty($description)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Description".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}

		$tableName = 'newsletter_content';
		$where = array(
					'newsletter_content_id ' => $id
				);
		$update = array(
					'title' => $title,
					'description' => $description,
					'modified_at' => CURRENT_DATETIME,
					'status' => $status
				);
	
		$updated_data = $this->main_model->update_data($where,$update,$tableName);
		if($updated_data == true) {
			
			$arr['response'] = true;
			$arr['msg'] = "Newsletter Content Updated Successfully";
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = true;
			$arr['msg'] = "Newsletter Content Updated Successfully";
			echo json_encode($arr);
			exit();
		}
	}
	
	/* view newsletter content page */
	public function view_newsletter_content($id) {
		
		$tableNameView = 'newsletter_content';
		$selectView = 'title,description,status';
		$whereView = array(
						'newsletter_content_id' => $id,
						'delete_status' => NO
					);
		$viewData = $this->main_model->get_first_row($selectView,$whereView,$tableNameView);
		
		/* check data exist in table or not */
		$this->show404Page($viewData);
		
		$data = array();
		$data['title'] = 'View Newsletter Content';
		$data['active_tab'] = ADMIN_PATH.'view-newsletter-content';
		$data['page_content'] = ADMIN_PATH.'newsletter-content/view-newsletter-content';
		$data['view'] = $viewData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
}

/* 

End of file :- 

location :- application/controllers/newslettercontent_controller.php

*/

?>