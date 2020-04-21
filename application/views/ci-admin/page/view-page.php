<?php

	$page_title = $view->page_title;
	$page_description = $view->page_description;
	$meta_tag_title = $view->meta_tag_title;
	$meta_tag_description = $view->meta_tag_description;
	$meta_tag_keywords = $view->meta_tag_keywords;
	$status = $view->status;

?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Page <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'pages/1'); ?>">Pages</a></li>
			<li class="active">View Page</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">View Page</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-xs-12">
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Title</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $page_title; ?>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Description</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $page_description; ?>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Meta Tag Title</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $meta_tag_title; ?>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Meta Tag Description</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $meta_tag_description; ?>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-4 col-lg-2">
									<label><?php echo NOT_REQUIRED_CONSTANT; ?>Meta Tag Keywords</label>
								</div>
								<div class="col-xs-8 col-lg-10">
									<?php echo $meta_tag_keywords; ?>
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