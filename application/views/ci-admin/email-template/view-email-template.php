<?php

	$subject = $view->subject;
	$message = $view->message;
	$status = $view->status;

?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Email Templates <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'email-templates/'); ?>">Email Templates</a></li>
			<li class="active">View Email Template</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">View Email Template</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-xs-12">
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Subject</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $subject; ?>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Message</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $message; ?>
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