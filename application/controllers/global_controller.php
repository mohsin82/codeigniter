<?php

/* 

location :- application/controllers/global_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

/* this controller is used in all side */
class Global_controller extends MY_Controller {

	/* get state list */
	public function getStateList() {
		
		$this->notAjaxDirect();
		
		$country_id = trim($this->input->post("country_id"));
		
		$arr = array();
		if($country_id == '0') {
			
			$arr['response'] = false;
			$arr['msg'] = "Please Select Country";
			echo json_encode($arr);
			exit();
		}
		
		$tableName = 'states';
		$select = 'state_id,name';
		$where = array(
					'country_id' => $country_id,
					'status' => YES,
					'delete_status' => NO
				);
			
		$states = $this->main_model->get_result_where($select,$where,$tableName);
		if($states != false) {
			
			$states_list = "<option value='0'>Select State</option>";
			foreach($states as $row) {

				$state_id = $row->state_id;
				$state_name = $row->name;
				$states_list .= "<option value='".$state_id."'>$state_name</option>";
			}
			
			$arr['response'] = true;
			$arr['msg'] = $states_list;
			echo json_encode($arr);
			exit();

		} else {
			
			$states_list = "<option value='0'>Select State</option>";

			$arr['response'] = true;
			$arr['msg'] = $states_list;
			echo json_encode($arr);
			exit();
		}
	}
	
	/* get city list */
	public function getCityList() {
		
		$this->notAjaxDirect();
		
		$state_id = trim($this->input->post("state_id"));
		
		$arr = array();
		if($state_id == '0') {
			
			$arr['response'] = false;
			$arr['msg'] = "Please Select State";
			echo json_encode($arr);
			exit();
		}
		
		$tableName = 'cities';
		$select = 'city_id,name';
		$where = array(
					'state_id' => $state_id,
					'status' => YES,
					'delete_status' => NO
				);
			
		$cities = $this->main_model->get_result_where($select,$where,$tableName);
		if($cities != false) {
		
			$cities_list = "<option value='0'>Select City</option>";
			foreach($cities as $row) {

				$city_id = $row->city_id;
				$city_name = $row->name;
				$cities_list .= "<option value='".$city_id."'>$city_name</option>";
			}

			$arr['response'] = true;
			$arr['msg'] = $cities_list;
			echo json_encode($arr);
			exit();

		} else {
			
			$cities_list = "<option value='0'>Select City</option>";

			$arr['response'] = true;
			$arr['msg'] = $cities_list;
			echo json_encode($arr);
			exit();
		}
	}
}

/* 

End of file :- 

location :- application/controllers/global_controller.php

*/

?>