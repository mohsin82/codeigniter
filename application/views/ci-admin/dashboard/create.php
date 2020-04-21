<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Dashboard <small>Control panel</small></h1>
	</section>
	
	<section class="content">
		<div class="row">
			
			<div class="col-xs-12">
				<div class="col-xs-6 col-md-4 col-lg-3">
					<div class="small-box bg-blue">
						<div class="inner">
							<h3><?php echo $users_count; ?></h3>
							<p>User Registrations</p>
						</div>
						<div class="icon">
							<i class="ion ion-person"></i>
						</div>
						<a href="<?php echo base_url(ADMIN_PATH.'users/'); ?>" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
				<div class="col-xs-6 col-md-4 col-lg-3">
					<div class="small-box bg-yellow">
						<div class="inner">
							<h3><?php echo $banners_count; ?></h3>
							<p>Banners</p>
						</div>
						<div class="icon">
							<i class="ion ion-images"></i>
						</div>
						<a href="<?php echo base_url(ADMIN_PATH.'banners/'); ?>" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
				<div class="col-xs-6 col-md-4 col-lg-3">
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3><?php echo $email_templates_count; ?></h3>
							<p>Email Templates</p>
						</div>
						<div class="icon">
							<i class="ion ion-ios-infinite-outline"></i>
						</div>
						<a href="<?php echo base_url(ADMIN_PATH.'email-templates/'); ?>" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
				<div class="col-xs-6 col-md-4 col-lg-3">
					<div class="small-box bg-green">
						<div class="inner">
							<h3><?php echo $contact_us_count; ?></h3>
							<p>Contact Us</p>
						</div>
						<div class="icon">
							<i class="ion ion-person-stalker"></i>
						</div>
						<a href="<?php echo base_url(ADMIN_PATH.'contact-us/'); ?>" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
				<div class="col-xs-6 col-md-4 col-lg-3">
					<div class="small-box bg-red">
						<div class="inner">
							<h3><?php echo $newsletter_content_count; ?></h3>
							<p>Newsletter Content</p>
						</div>
						<div class="icon">
							<i class="ion ion-clipboard"></i>
						</div>
						<a href="<?php echo base_url(ADMIN_PATH.'newsletter-content/'); ?>" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
				<div class="col-xs-6 col-md-4 col-lg-3">
					<div class="small-box bg-olive">
						<div class="inner">
							<h3><?php echo $newsletter_users_count; ?></h3>
							<p>Newsletter User</p>
						</div>
						<div class="icon">
							<i class="ion ion-ios-color-filter-outline"></i>
						</div>
						<a href="<?php echo base_url(ADMIN_PATH.'newsletter-users/'); ?>" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
				<div class="col-xs-6 col-md-4 col-lg-3">
					<div class="small-box bg-light-blue">
						<div class="inner">
							<h3><?php echo $page_tag_count; ?></h3>
							<p>Pages</p>
						</div>
						<div class="icon">
							<i class="ion ion-merge"></i>
						</div>
						<a href="<?php echo base_url(ADMIN_PATH.'pages/1'); ?>" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>
			
		</div>
	</section>
	
</div>
<!-- content -->