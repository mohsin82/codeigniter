<?php

	$first_name = $view->first_name;
	$last_name = $view->last_name;
	$username = $view->username;
	$email = $view->email;
	$phone_no = $view->phone_no;
	$group_id = $view->group_id;
	$status = $view->status;

?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Users <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'users/'); ?>">Users</a></li>
			<li class="active">View User</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">View User</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-xs-12">
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>First Name</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $first_name; ?>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Last Name</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $last_name; ?>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Username</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $username; ?>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Email</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $email; ?>
								</div>			
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Phone Number</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $phone_no; ?>
								</div>			
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Role</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php
										foreach($user_groups as $row) {
											
											if($row->group_id == $group_id) {
												
												echo $row->name;
											}
										}
									?>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Status</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php 
										if($status == YES) { 
											
											echo 'Active';
										
										} else {
											
											echo 'Deactivate';
										}
									?>
								</div>
							</div>
						</div>
					</div>

				</div>
         		</div>			
		</div>
	</section>
	
</div>
<!-- content -->