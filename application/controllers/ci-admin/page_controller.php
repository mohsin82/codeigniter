<?php

/* 

location :- application/controllers/page_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Page_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();
		
		$this->load->library('pagination');
	}
	
	/* display a view page */
	public function create($defaultValue = 0) {
		
		$tableName = 'pages';
		$select1 = 'count(page_id) as count_page';
		$where = array(
					'delete_status' => NO
				);
		
		/* pagination passing parameter */
		$data = array();
		$get_row = $this->main_model->get_first_row($select1,$where,$tableName);
		$count_page  = $get_row->count_page;
		if ($count_page > 0) {

			$select2 = 'page_id,page_title,page_description,status';
			$order_field = 'page_id';
			$order_val = 'DESC';

			$perPage = 2;
			$page = $this->uri->segment(3) ? ($this->uri->segment(3) - 1) : $defaultValue;
			$start = $page * $perPage;

			/* get current page records */
			$pageData = $this->main_model->get_result_where_with_order_and_pagination($select2,$where,$order_field,$order_val,$perPage,$start,$tableName);
			$data['pages'] = $pageData;
			$data['per_page'] = $perPage;

			$config['base_url'] = base_url(ADMIN_PATH.'pages');
			$config['total_rows'] = $count_page;
			$config['per_page'] = $perPage;
			$config["uri_segment"] = 3;

			/* custom paging configuration */
			$config['num_links'] = 2;
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
			$data["links"] = $this->pagination->create_links();
		}

		$data['title'] = 'Pages';
		$data['active_tab'] = ADMIN_PATH.'pages';
		$data['page_content'] = ADMIN_PATH.'page/create';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}

	/* change status */
	public function change_status($id,$val,$uri) {				
		
		$tableName = 'pages';
		$where = array(
					'page_id' => $id
				);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'status' => $val
				);	
		
		$change_status_val = $this->main_model->update_data($where,$update,$tableName);
		if($change_status_val == true) {
			
			redirect(base_url(ADMIN_PATH.'pages/'.$uri));
			exit();
		}
	}
	
	/* change delete status multiple */
	public function change_delete_status() {				
		
		$ids = trim($this->input->post("ids"));

		$tableName = 'pages';
		$where_in_field = 'page_id';
		$where_in_val = explode(",",$ids);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'delete_status' => YES
				);		
		
		$arr = array();
		$delete_val = $this->main_model->update_multiple_data($where_in_field,$where_in_val,$update,$tableName);
		if($delete_val == true) {
			
			$arr['response'] = true;
			$this->session->set_flashdata('warning','Page Deleted Successfully');

		} else {
			
			$arr['response'] = false;
			$this->session->set_flashdata('error','Please try again later');
		}
		echo json_encode($arr);
		exit();
	}
	
	/* add page create */
	public function add_page() {
		
		$data = array();
		$data['title'] = 'Add Page';
		$data['active_tab'] = ADMIN_PATH.'add-page';
		$data['page_content'] = ADMIN_PATH.'page/add-page';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store page */
	public function store() {				
		
		$this->notAjaxDirect();
		
		$page_title = trim($this->input->post("page_title"));
		$page_description = trim($this->input->post("page_description"));
		$page_description_textonly = strip_tags($page_description);
		$meta_tag_title = trim($this->input->post("meta_tag_title"));
		$meta_tag_description = trim($this->input->post("meta_tag_description"));
		$meta_tag_keywords = trim($this->input->post("meta_tag_keywords"));
		$status = trim($this->input->post("status"));
		$delete_status = NO;
		
		$arr = array();
		if(empty($page_title)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Title".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(empty($page_description)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Description".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(empty($meta_tag_title)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Meta Tag Title".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}
		
		$type = "single";
		$tableName = 'pages';	
		$insert = array(
					'page_title' => $page_title,
					'page_description' => $page_description,
					'meta_tag_title' => $meta_tag_title,
					'meta_tag_description' => $meta_tag_description,
					'meta_tag_keywords' => $meta_tag_keywords,
					'created_at' => CURRENT_DATETIME,
					'status' => $status,
					'delete_status' => $delete_status
				);
	
		$inserted_data = $this->main_model->insert_data($insert,$tableName,$type);
		if($inserted_data != false) {
			
			$arr['response'] = true;
			$arr['msg'] = "Page Added Successfully";
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = false;
			$arr['msg'] = TRY_AGAIN_LATER;
			echo json_encode($arr);
			exit();
		}
	}
	
	/* edit page create */
	public function edit_page($id) {
		
		$tableNameEdit = 'pages';
		$selectEdit = 'page_title,page_description,meta_tag_title,meta_tag_description,meta_tag_keywords,status';
		$whereEdit = array(
						'page_id' => $id,
						'delete_status' => NO
					);
		$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
		
		/* check data exist in table or not */
		$this->show404Page($editData);
		
		$data = array();
		$data['title'] = 'Edit Page';
		$data['active_tab'] = ADMIN_PATH.'edit-page';
		$data['page_content'] = ADMIN_PATH.'page/edit-page';
		$data['edit'] = $editData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store edit page */
	public function storeEdit() {				
		
		$this->notAjaxDirect();
		
		$id = trim($this->input->post("id"));
		$page_title = trim($this->input->post("page_title"));
		$page_description = trim($this->input->post("page_description"));
		$page_description_textonly = strip_tags($page_description);
		$meta_tag_title = trim($this->input->post("meta_tag_title"));
		$meta_tag_description = trim($this->input->post("meta_tag_description"));
		$meta_tag_keywords = trim($this->input->post("meta_tag_keywords"));
		$status = trim($this->input->post("status"));
		
		$arr = array();
		if(empty($page_title)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Title".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(empty($page_description)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Description".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(empty($meta_tag_title)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Meta Tag Title".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}
		
		$tableName = 'pages';	
		$where = array(
					'page_id ' => $id
				);
		$update = array(
					'page_title' => $page_title,
					'page_description' => $page_description,
					'meta_tag_title' => $meta_tag_title,
					'meta_tag_description' => $meta_tag_description,
					'meta_tag_keywords' => $meta_tag_keywords,
					'modified_at' => CURRENT_DATETIME,
					'status' => $status
				);
	
		$updated_data = $this->main_model->update_data($where,$update,$tableName);
		if($updated_data == true) {
			
			$arr['response'] = true;
			$arr['msg'] = "Page Updated Successfully";
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = true;
			$arr['msg'] = "Page Updated Successfully";
			echo json_encode($arr);
			exit();
		}
	}
		
	/* view page */
	public function view_page($id) {
		
		$tableNameView = 'pages';
		$selectView = 'page_title,page_description,meta_tag_title,meta_tag_description,meta_tag_keywords,status';
		$whereView = array(
						'page_id' => $id,
						'delete_status' => NO
					);
		$viewData = $this->main_model->get_first_row($selectView,$whereView,$tableNameView);
		
		/* check data exist in table or not */
		$this->show404Page($viewData);
		
		$data = array();
		$data['title'] = 'View Page';
		$data['active_tab'] = ADMIN_PATH.'view-page';
		$data['page_content'] = ADMIN_PATH.'page/view-page';
		$data['view'] = $viewData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	} 
}

/* 

End of file :- 

location :- application/controllers/page_controller.php

*/

?>