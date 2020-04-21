<?php

/* 

location :- application/controllers/setting_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();
	}
	
	/* display a view page */
	public function create() {
		
		$tableNameEdit = 'config';
		$selectEdit = 'website_name,owner_name,website_email,website_phone_no,country_id,state_id,city_id,address,website_logo,favicon,from_mail,maintenance';
		$whereEdit = array(
						'status' => YES,
						'delete_status' => NO
					);
		$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
		
		/* check data exist in table or not */
		$this->show404Page($editData);

		$tableNameCountries = 'countries';
		$selectCountries = 'country_id,name';
		$whereCountries = array(
							'status' => YES,
							'delete_status' => NO
						);
			
		$countries = $this->main_model->get_result_where($selectCountries,$whereCountries,$tableNameCountries);
		
		$tableNameStates = 'states';
		$selectStates = 'state_id,name,country_id';
		$whereStates = array(
						'country_id' => $editData->country_id,
						'status' => YES,
						'delete_status' => NO
					);
			
		$states = $this->main_model->get_result_where($selectStates,$whereStates,$tableNameStates);
		
		$tableNameCities = 'cities';
		$selectCities = 'city_id,name,state_id';
		$whereCities = array(
						'state_id' => $editData->state_id,
						'status' => YES,
						'delete_status' => NO
					);
			
		$cities = $this->main_model->get_result_where($selectCities,$whereCities,$tableNameCities);
		
		$data = array();
		$data['title'] = 'Setting';
		$data['active_tab'] = ADMIN_PATH.'site-setting';
		$data['page_content'] = ADMIN_PATH.'setting/create';
		$data['countries'] = $countries;
		$data['states'] = $states;
		$data['cities'] = $cities;
		$data['edit'] = $editData;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	public function update_site_setting() {
		
		$this->notAjaxDirect();
		
		$uniqueString = uniqid();
		
		$website_name = trim($this->input->post("website_name"));
		$owner_name = trim($this->input->post("owner_name"));
		$website_email = trim($this->input->post("website_email"));
		$website_phone_no = trim($this->input->post("website_phone_no"));
		$country = trim($this->input->post("country"));
		$state = trim($this->input->post("state"));
		$city = trim($this->input->post("city"));
		$address = trim($this->input->post("address"));
		$website_logo = $this->input->post("website_logo");
		$favicon = $this->input->post("favicon");
		$from_mail = trim($this->input->post("from_mail"));
		$maintenance = trim($this->input->post("maintenance"));
		
		$emailReg = EMAIL_REG;
		$phone_noReg = NUMERIC_REG;
		
		$arr = array();
		if(empty($website_name)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Website Name".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(empty($owner_name)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Owner Name".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(empty($website_email)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Email".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($emailReg, $website_email)) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_VALID_EMAIL;
			echo json_encode($arr);
			exit();
		
		} else if(empty($website_phone_no)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Phone Number".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($phone_noReg, $website_phone_no)) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_VALID_PHONE;
			echo json_encode($arr);
			exit();
		
		} else if($country == '0') {
			
			$arr['response'] = false;
			$arr['msg'] = "Country".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if($state == '0') {
			
			$arr['response'] = false;
			$arr['msg'] = "State".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if($city == '0') {
			
			$arr['response'] = false;
			$arr['msg'] = "City".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(empty($address)) {
			
			$arr['response'] = false;
			$arr['msg'] = "Address".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(empty($from_mail)) {
			
			$arr['response'] = false;
			$arr['msg'] = "From Mail".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		
		} else if(!preg_match($emailReg, $from_mail)) {
			
			$arr['response'] = false;
			$arr['msg'] = NOT_VALID_EMAIL;
			echo json_encode($arr);
			exit();
		}
		
		$tableNameEdit = 'config';
		$selectEdit = 'config_id,website_logo,favicon';
		$whereEdit = array(
						'status' => YES,
						'delete_status' => NO
					);
					
		$editData = $this->main_model->get_first_row($selectEdit,$whereEdit,$tableNameEdit);
		
		/* check data exist in table or not */
		$this->show404Page($editData);
		
		$old_website_logo = $editData->website_logo;
		$old_favicon = $editData->favicon;
		
		/* website logo */
		$websiteLogoName = '';
		if($website_logo == 'undefined') {
			
			$websiteLogoName = $old_website_logo;
			
		} else {
		
			$fileName = $this->removeSpecialCharecter($_FILES["website_logo"]["name"]);
			
			$websiteLogoName = $uniqueString.'_'.$fileName;
			$imgTempName = $_FILES["website_logo"]["tmp_name"];
			$imgTempType = $_FILES["website_logo"]["type"];
			$imgTempSize = $_FILES["website_logo"]["size"];

			if(isset($_FILES) || !empty($_FILES)) {
				
				$validextensions = array("jpeg", "jpg", "png");
				$temporary = explode(".",$websiteLogoName);
				$file_extension = end($temporary);
			
				if(in_array($file_extension, $validextensions)) {
				
					if($_FILES["website_logo"]["error"] > 0) {
						
						$arr['response'] = false;
						$arr['msg'] = ERROR_IMAGE;
						echo json_encode($arr);
						exit();
					}
					
				} else {
				
					$arr['response'] = false;
					$arr['msg'] = VALID_EXTENSION;
					echo json_encode($arr);
					exit();
				}
			}
		}
		
		/* favicon */
		$websiteFaviconName = '';
		if($favicon == 'undefined') {
			
			$websiteFaviconName = $old_favicon;
			
		} else {
		
			$fileName = $this->removeSpecialCharecter($_FILES["favicon"]["name"]);
			
			$websiteFaviconName = $uniqueString.'_'.$fileName;
			$imgTempName = $_FILES["favicon"]["tmp_name"];
			$imgTempType = $_FILES["favicon"]["type"];
			$imgTempSize = $_FILES["favicon"]["size"];

			if(isset($_FILES) || !empty($_FILES)) {
				
				$validextensions = array("jpeg", "jpg", "png");
				$temporary = explode(".",$websiteFaviconName);
				$file_extension = end($temporary);
			
				if(in_array($file_extension, $validextensions)) {
				
					if($_FILES["favicon"]["error"] > 0) {
						
						$arr['response'] = false;
						$arr['msg'] = ERROR_IMAGE;
						echo json_encode($arr);
						exit();
					}
					
				} else {
				
					$arr['response'] = false;
					$arr['msg'] = VALID_EXTENSION;
					echo json_encode($arr);
					exit();
				}
			}
		}
		
		
		if($website_logo != 'undefined') {
			
			$fieldWebsiteLogoName = 'website_logo';
			$mainWebsiteLogoPath = WEBSITE_LOGO_PATH;
			
			$this->uploadImage($uniqueString,$fieldWebsiteLogoName,$mainWebsiteLogoPath,'');
			
			if(file_exists(WEBSITE_LOGO_PATH.$old_website_logo)) {
					
				unlink(WEBSITE_LOGO_PATH.$old_website_logo);
			}
		}
		
		if($favicon != 'undefined') {
			
			$fieldFaviconName = 'favicon';
			$mainFaviconPath = FAVION_IMAGE_PATH;
			
			$this->uploadImage($uniqueString,$fieldFaviconName,$mainFaviconPath,'');
			
			if(file_exists(FAVION_IMAGE_PATH.$old_favicon)) {
					
				unlink(FAVION_IMAGE_PATH.$old_favicon);
			}
		}
		
		$tableName = 'config';
		$where = array(
					'status' => YES,
					'delete_status' => NO
				);
		$update = array(
					'website_name' => $website_name,
					'owner_name' => $owner_name,
					'website_email' => $website_email,
					'website_phone_no' => $website_phone_no,
					'country_id' => $country,
					'state_id' => $state,
					'city_id' => $city,
					'address' => $address,
					'website_logo' => $websiteLogoName,
					'favicon' => $websiteFaviconName,
					'from_mail' => $from_mail,
					'maintenance' => $maintenance,
					'modified_at' => CURRENT_DATETIME,
				);
		
		$updated_data = $this->main_model->update_data($where,$update,$tableName);
		if($updated_data == true) {
			
			$arr['response'] = true;
			$arr['msg'] = "Site-Setting Updated Successfully";
			echo json_encode($arr);
			exit();
			
		} else {
			
			$arr['response'] = true;
			$arr['msg'] = "Site-Setting Updated Successfully";
			echo json_encode($arr);
			exit();
		}
	}
	
}

/* 

End of file :- 

location :- application/controllers/setting_controller.php

*/

?>