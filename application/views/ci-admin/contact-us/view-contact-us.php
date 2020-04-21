<?php

	$name = $view->name;
	$email = $view->email;
	$subject = $view->subject;
	$message = $view->message;
	$reply = $view->reply;

?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Contact Us <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'contact-us/'); ?>">Contact Us</a></li>
			<li class="active">View Contact Us</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">View Contact Us</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-xs-12">
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Name</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $name; ?>
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
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Reply</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php
										if(!empty($reply)) {
										
											echo $reply;
										
										} else {
											
											echo 'No reply yet.';
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