<?php

/*

location :- application/controllers/dashboard_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_controller extends MY_Controller {
	
	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();
	}
	
	/* display a view page */
	public function create() {
		
		/* users count */
		$join_type = 'left';
		$tableNameJoin1 = 'user_groups ug';
		$tableNameJoin2 = 'users u';
		$select = 'count(u.user_id) as count_user';
		$where = array(
					'u.delete_status' => NO,
					'ug.status' => YES,
					'ug.delete_status' => NO
				);
		$where_in_field = 'ug.role';
		$where_in_val = array(ROLE_SUB_ADMIN,ROLE_USER);
		$join_where = 'ug.group_id = u.group_id';
		$get_row1 = $this->main_model->get_first_row_with_join($select,$where,$where_in_field,$where_in_val,$join_where,$tableNameJoin1,$tableNameJoin2,$join_type);
		$count_user = $get_row1->count_user;

		/* banners count */
		$tableName2 = 'banners';
		$select2 = 'count(banner_id) as count_banner';
		$where2 = array(
					'delete_status' => NO
				);
		$get_row2 = $this->main_model->get_first_row($select2,$where2,$tableName2);
		$count_banner = $get_row2->count_banner; 
		
		/* email template count */
		$tableName3 = 'email_templates';
		$select3 = 'count(email_template_id) as count_email_template';
		$where3 = array(
					'delete_status' => NO
				);
		$get_row3 =  $this->main_model->get_first_row($select3,$where3,$tableName3);
		$count_email_template = $get_row3->count_email_template;

		/* contact us count */
		$tableName4 = 'contact_us';
		$select4 = 'count(contact_us_id) as count_contact_us';
		$where4 = array(
					'delete_status' => NO
				);
		$get_row4 = $this->main_model->get_first_row($select4,$where4,$tableName4);
		$count_contact_us = $get_row4->count_contact_us;

		/* newsletter content count */
		$tableName5 = 'newsletter_content';
		$select5 = 'count(newsletter_content_id) as count_newsletter_content';
		$where5 = array(
					'delete_status' => NO
				);
		$get_row5 = $this->main_model->get_first_row($select5,$where5,$tableName5);
		$count_newsletter_content = $get_row5->count_newsletter_content;
		
		/* newsletter user count */
		$tableName6 = 'newsletter_users';
		$select6 = 'count(newsletter_user_id) as count_newsletter_user';
		$where6 = array(
					'delete_status' => NO
				);
		$get_row6 = $this->main_model->get_first_row($select6,$where6,$tableName6);
		$count_newsletter_user = $get_row6->count_newsletter_user;
		
		/* page count */
		$tableName7 = 'pages';
		$select7 = 'count(page_id) as count_page';
		$where7 = array(
					'delete_status' => NO
				);
		$get_row7 = $this->main_model->get_first_row($select7,$where7,$tableName7);
		$count_page = $get_row7->count_page;
		
		$data = array();
		$data['title'] = 'Dashboard';
		$data['active_tab'] = ADMIN_PATH.'dashboard';
		$data['page_content'] = ADMIN_PATH.'dashboard/create';
		$data['users_count'] = $count_user;
		$data['banners_count'] = $count_banner;
		$data['email_templates_count'] = $count_email_template;
		$data['contact_us_count'] = $count_contact_us;
		$data['newsletter_content_count'] = $count_newsletter_content;
		$data['newsletter_users_count'] = $count_newsletter_user;
		$data['page_tag_count'] = $count_page;
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
}

/* 

End of file :- 

location :- application/controllers/dashboard_controller.php

*/

?>