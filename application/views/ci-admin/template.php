<?php

	if($includes == 'login') {
		
		$this->load->view(ADMIN_PATH.'includes/login/header');
		$this->load->view($page_content);
		$this->load->view(ADMIN_PATH.'includes/login/footer');
	}

	if($includes == 'common') {
		
		$this->load->view(ADMIN_PATH.'includes/common/header');
		$this->load->view(ADMIN_PATH.'includes/common/navbar');
		$this->load->view(ADMIN_PATH.'includes/common/sidebar');
		$this->load->view($page_content);
		$this->load->view(ADMIN_PATH.'includes/common/footer');
	}
	
?>