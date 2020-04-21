<?php

/* 

location :- application/controllers/bannerimage_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Bannerimage_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();
	}
	
	/* create banner image display */
	public function create($id) {
		
		$tableName = 'banner_images';
		$select = 'banner_image_id,image,title,link_text,tab_status,status';
		$where = array(
					'banner_id' => $id,
					'delete_status' => NO
				);
		$order_field = 'banner_image_id';
		$order_val = 'DESC';
		
		$bannerImagesData = $this->main_model->get_result_with_order($select,$where,$order_field,$order_val,$tableName);
		
		$data = array();
		$data['title'] = 'Banner Images';
		$data['active_tab'] = ADMIN_PATH.'banner-images';
		$data['page_content'] = ADMIN_PATH.'banner-images/create';
		$data['banner_images'] = $bannerImagesData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* change status */
	public function change_status($banner_id,$id,$val) {				
		
		$tableName = 'banner_images';
		$where = array(
					'banner_image_id' => $id,
				);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'status' => $val
				);		
		
		$change_status_val = $this->main_model->update_data($where,$update,$tableName);
		if($change_status_val == true) {
			
			redirect(base_url(ADMIN_PATH.'banner-images/'.$banner_id.'/'));
			exit();
		}
	}
	
	/* change delete status */
	public function change_delete_status() {				
		
		$banner_id = trim($this->input->post("banner_id"));
		$ids = trim($this->input->post("ids"));

		$tableName = 'banner_images';
		$where = array(
					'banner_id' => $banner_id
				);
		$where_in_field = 'banner_image_id';
		$where_in_val = explode(",",$ids);
		$update = array(
					'modified_at' => CURRENT_DATETIME,
					'delete_status' => YES
				);		
		
		$arr = array();
		$delete_val = $this->main_model->update_multiple_data_where($where,$where_in_field,$where_in_val,$update,$tableName);
		if($delete_val == true) {
			
			$arr['response'] = true;
			$arr['banner_id'] = $banner_id;
			$this->session->set_flashdata('warning','Banner Image Deleted Successfully');

		} else {
			
			$arr['response'] = false;
			$arr['banner_id'] = $banner_id;
			$this->session->set_flashdata('error','Please try again later');
		}
		echo json_encode($arr);
		exit();			
	}
	
	/* add banner image */
	public function add_banner_image($banner_id) {
		
		$data = array();
		$data['title'] = 'Add Banner Image';
		$data['active_tab'] = ADMIN_PATH.'add-banner-image';
		$data['page_content'] = ADMIN_PATH.'banner-images/add-banner-image';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store add banner image */
	public function store() {				
		
		$this->notAjaxDirect();
		
		$uniqueString = uniqid();
		
		$banner_id = trim($this->input->post("banner_id"));
		$image = $this->input->post("image");
		$title = trim($this->input->post("title"));
		$link = trim($this->input->post("link"));
		$tab_status = trim($this->input->post("tab_status"));
		$status = trim($this->input->post("status"));
		$delete_status = NO;
		
		$titleReg = ALPHA_SPACE_REG;

		$arr = array();
		if(!empty($image) || $image == 'undefined') {
			
			$arr['response'] = false;
			$arr['msg'] = SELECT_ONE;
			echo json_encode($arr);
			exit();
		}
		
		$checkTableName = 'banners';
		$checkSelect = 'count(banner_id) as count_banner';
		$checkWhere = array(
						'banner_id' => $banner_id
					);
				
		$get_row = $this->main_model->get_first_row($checkSelect,$checkWhere,$checkTableName);		
		$count_banner = $get_row->count_banner;
		if($count_banner > 0) {

			$fileName = $this->removeSpecialCharecter($_FILES["image"]["name"]);
	
			$imgName = $uniqueString.'_'.$fileName;
			$imgTempName = $_FILES["image"]["tmp_name"];
			$imgTempType = $_FILES["image"]["type"];
			$imgTempSize = $_FILES["image"]["size"];

			if(isset($_FILES) || !empty($_FILES)) {
				
				$validextensions = array("jpeg", "jpg", "png");
				$temporary = explode(".",$imgName);
				$file_extension = end($temporary);
			
				if(in_array($file_extension, $validextensions)) {
				
					if($_FILES["image"]["error"] > 0) {
						
						$arr['response'] = false;
						$arr['msg'] = ERROR_IMAGE;
						echo json_encode($arr);
						exit();
					
					} else {
						
						if(file_exists(BANNER_IMAGE_PATH.$imgName)) {
						
							$arr['response'] = false;
							$arr['msg'] = "Image is".ALREADY_EXIST;
							echo json_encode($arr);
							exit();

						} else {
							
							$fieldName = 'image';
							$thumbPath = BANNER_IMAGE_THUMB_PATH;
							$mainPath = BANNER_IMAGE_PATH;
							
							$this->createThumbnail($uniqueString,$fieldName,$mainPath,'',TRUE,$thumbPath,THUMB_WIDTH_BANNER_IMAGE,THUMB_HEIGHT_BANNER_IMAGE);
						}
					}
					
				} else {
				
					$arr['response'] = false;
					$arr['msg'] = VALID_EXTENSION;
					echo json_encode($arr);
					exit();
				}
				
			} else {
				
				$arr['response'] = false;
				$arr['msg'] = SELECT_ONE;
				echo json_encode($arr);
				exit();
			}
			
			$type = "single";
			$tableName = 'banner_images';				
			$insert = array(
						'banner_id' => $banner_id,
						'image' => $imgName,
						'title' => $title,
						'link_text' => $link,
						'tab_status' => $tab_status,
						'created_at' => CURRENT_DATETIME,
						'status' => $status,
						'delete_status' => $delete_status
					);

			$inserted_data = $this->main_model->insert_data($insert,$tableName,$type);
			if($inserted_data != false) {
				
				$arr['response'] = true;
				$arr['msg'] = "Banner Image Added Successfully";
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
	
	/* edit banner image */
	public function edit_banner_image($banner_id,$id) {
		
		$tableNameEdit = 'banner_images';
		$selectEdit = 'image,title,link_text,tab_status,status';
		$whereEdit = array(
						'banner_image_id' => $id,
						'banner_id' => $banner_id,
						'delete_status' => NO
					);
					
		$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
		
		/* check data exist in table or not */
		$this->show404Page($editData);
		
		$data = array();
		$data['title'] = 'Edit Banner Image';
		$data['active_tab'] = ADMIN_PATH.'edit-banner-image';
		$data['page_content'] = ADMIN_PATH.'banner-images/edit-banner-image';
		$data['edit'] = $editData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* store edit banner image */
	public function storeEdit() {				
		
		$this->notAjaxDirect();
		
		$uniqueString = uniqid();
		
		$banner_id = trim($this->input->post("banner_id"));
		$id = trim($this->input->post("id"));
		$new_image = trim($this->input->post("image"));
		$title = trim($this->input->post("title"));
		$link = trim($this->input->post("link"));
		$tab_status = trim($this->input->post("tab_status"));
		$status = trim($this->input->post("status"));
		
		$checkTableName = 'banners';
		$checkSelect = 'count(banner_id) as count_banner';
		$checkWhere = array(
						'banner_id' => $banner_id
					);
			
		$get_row = $this->main_model->get_first_row($checkSelect,$checkWhere,$checkTableName);		
		$count_banner = $get_row->count_banner;
		if($count_banner > 0) {

			$tableNameEdit = 'banner_images';
			$selectEdit = 'image';
			$whereEdit = array(
							'banner_image_id' => $id,
							'banner_id' => $banner_id,
							'delete_status' => NO
						);
						
			$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
			
			/* check data exist in table or not */
			$this->show404Page($editData);
			
			$old_image = $editData->image;
			
			$arr = array();
			$imgName = '';
			if($new_image == 'undefined') {
				
				$imgName = $old_image;
				
			} else {
				
				$fileName = $this->removeSpecialCharecter($_FILES["image"]["name"]);
				
				$imgName = $uniqueString.'_'.$fileName;
				$imgTempName = $_FILES["image"]["tmp_name"];
				$imgTempType = $_FILES["image"]["type"];
				$imgTempSize = $_FILES["image"]["size"];

				if(isset($_FILES) && !empty($_FILES)) {
					
					$validextensions = array("jpeg", "jpg", "png");
					$temporary = explode(".",$imgName);
					$file_extension = end($temporary);
				
					if(in_array($file_extension, $validextensions)) {
					
						if($_FILES["image"]["error"] > 0) {
							
							$arr['response'] = false;
							$arr['msg'] = ERROR_IMAGE;
							echo json_encode($arr);
							exit();
						
						} else {
							
							if (file_exists(BANNER_IMAGE_PATH.$imgName)) {
							
								$arr['response'] = false;
								$arr['msg'] = "Image is".ALREADY_EXIST;
								echo json_encode($arr);
								exit();
								
							} else {
								
								$fieldName = 'image';
								$thumbPath = BANNER_IMAGE_THUMB_PATH;
								$mainPath = BANNER_IMAGE_PATH;
								
								$this->createThumbnail($uniqueString,$fieldName,$mainPath,'',TRUE,$thumbPath,THUMB_WIDTH_BANNER_IMAGE,THUMB_HEIGHT_BANNER_IMAGE);
								
								if(file_exists(BANNER_IMAGE_THUMB_PATH.$old_image)) {
									
									unlink(BANNER_IMAGE_THUMB_PATH.$old_image);
								}
								
								if(file_exists(BANNER_IMAGE_PATH.$old_image)) {
									
									unlink(BANNER_IMAGE_PATH.$old_image);
								}
							}
						}
						
					} else {
						
						$arr['response'] = false;
						$arr['msg'] = VALID_EXTENSION;
						echo json_encode($arr);
						exit();
					}
					
				} else {
					
					$arr['response'] = false;
					$arr['msg'] = SELECT_ONE;
					echo json_encode($arr);
					exit();
				}
			}
		
			$tableName = 'banner_images';			
			$where = array(
						'banner_image_id ' => $id,
						'banner_id ' => $banner_id
					);
			$update = array(
						'image' => $imgName,
						'title' => $title,
						'link_text' => $link,
						'tab_status' => $tab_status,
						'modified_at' => CURRENT_DATETIME,
						'status' => $status
					);
			
			$updated_data = $this->main_model->update_data($where,$update,$tableName);
			if($updated_data == true) {
				
				$arr['response'] = true;
				$arr['msg'] = "Banner Image Updated Successfully";
				echo json_encode($arr);
				exit();
				
			} else {
				
				$arr['response'] = true;
				$arr['msg'] = "Banner Image Updated Successfully";
				echo json_encode($arr);
				exit();
			}
		}	
	}
	
}

/* 

End of file :- 

location :- application/controllers/bannerimage_controller.php

*/

?>