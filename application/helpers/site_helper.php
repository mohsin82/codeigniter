<?php

/* 

location :- application/helpers/site_helper.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

/* common erors using flash */
if(!function_exists('flashErrors')) {
	
	function flashErrors() {
		
		/* Get a reference to the controller object */
		$ci =& get_instance();
		
		$err = '';
		if($ci->session->flashdata('success')) {

			$successMsg = $ci->session->flashdata('success');
			$err = '<div class="row">'.
					'<div class="col-xs-12">'.
						'<p class="alert alert-success alert-dismissible">'.$successMsg.'</p>'.
					'</div>'.
				'</div>';
		
		} else if($ci->session->flashdata('warning')) {

			$warningMsg = $ci->session->flashdata('warning');
			$err = '<div class="row">'.
					'<div class="col-xs-12">'.
						'<p class="alert alert-warning alert-dismissible">'.$warningMsg.'</p>'.
					'</div>'.
				'</div>';
		
		} else if($ci->session->flashdata('error')) {

			$errorMsg = $ci->session->flashdata('error');
			$err = '<div class="row">'.
					'<div class="col-xs-12">'.
						'<p class="alert alert-danger alert-dismissible">'.$errorMsg.'</p>'.
					'</div>'.
				'</div>';
		}
		return $err;
	}
}


/* common erors using custom */
if(!function_exists('customErrors')) {
	
	function customErrors() {
		
		/* Get a reference to the controller object */
		$ci =& get_instance();
		
		$err = '<div class="row">'.
				'<div class="col-xs-12">'.
					'<p id="error-msg"></p>'.
				'</div>'.
			'</div>';
		return $err;
	}
}

/* site details */
if(!function_exists('siteDetails')) {
	
	function siteDetails() {
		
		/* Get a reference to the controller object */
		$ci =& get_instance();
		
		$tableName = 'config';
		$select = 'website_name,website_logo,favicon';
		$where = array(
					'status' => YES,
					'delete_status' => NO
				);
		$siteDetailsData = $ci->main_model->get_first_row($select,$where,$tableName);
		
		/* check data exist in table or not */
		$ci->show404Page($siteDetailsData);

		return $siteDetailsData;
	}
}

/* get username from session id */
if(!function_exists('getUsername')) {
	
	function getUsername() {
		
		/* Get a reference to the controller object */
		$ci =& get_instance();
		
		$sess_id = $ci->session->userdata(ADMIN_SESSION_ID);

		$join_type = 'left';
		$tableNameJoin1 = 'user_groups ug';
		$tableNameJoin2 = 'users u';
		$select = 'u.username as username';
		$where = array(
					'u.user_id' => $sess_id,
					'u.delete_status' => NO,
					'ug.status' => YES,
					'ug.delete_status' => NO
				);
		$where_in_field = 'ug.role';
		$where_in_val = array(ROLE_SUPER_ADMIN,ROLE_SUB_ADMIN,ROLE_USER);
		$join_where = 'ug.group_id = u.group_id';
		$getUsernameData = $ci->main_model->get_first_row_with_join($select,$where,$where_in_field,$where_in_val,$join_where,$tableNameJoin1,$tableNameJoin2,$join_type);
		
		/* check data exist in table or not */
		$ci->show404Page($getUsernameData);

		return $getUsernameData;
	}
}

/* 

End of file :- 

location :- application/helpers/site_helper.php

*/

?>