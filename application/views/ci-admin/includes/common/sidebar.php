<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu" data-widget="tree">
			
			<li class="header">MAIN NAVIGATION</li>
			
			<li class="<?php if($active_tab == ADMIN_PATH.'dashboard') { echo 'active'; } ?>">
				<a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">
					<i class="fa fa-dashboard"></i>
					<span>Dashboard</span>
				</a>
			</li>
			
			<li class="<?php if($active_tab == ADMIN_PATH.'banners' || $active_tab == ADMIN_PATH.'add-banner' || $active_tab == ADMIN_PATH.'edit-banner' || $active_tab == ADMIN_PATH.'banner-images' || $active_tab == ADMIN_PATH.'add-banner-image' || $active_tab == ADMIN_PATH.'edit-banner-image' || $active_tab == ADMIN_PATH.'email-templates' || $active_tab == ADMIN_PATH.'add-email-template' || $active_tab == ADMIN_PATH.'edit-email-template' || $active_tab == ADMIN_PATH.'view-email-template') { echo 'active'; } ?> treeview">
				<a role="button">
					<i class="fa fa-desktop"></i><span>Design</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if($active_tab == ADMIN_PATH.'add-banner') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'add-banner/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Add Banner
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'banners' || $active_tab == ADMIN_PATH.'edit-banner' || $active_tab == ADMIN_PATH.'banner-images' || $active_tab == ADMIN_PATH.'add-banner-image' || $active_tab == ADMIN_PATH.'edit-banner-image') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'banners/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Banners
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'add-email-template') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'add-email-template/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Add Email Template
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'email-templates' || $active_tab == ADMIN_PATH.'edit-email-template' || $active_tab == ADMIN_PATH.'view-email-template') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'email-templates/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Email Templates
						</a>
					</li>
				</ul>
			</li>
			
			<!--<li class="<?php //if($active_tab == ADMIN_PATH.'send-mail') { echo 'active'; } ?> treeview">
				<a role="button">
					<i class="fa fa-envelope"></i><span>Send</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php // if($active_tab == ADMIN_PATH.'send-mail') { echo 'active'; } ?>">
						<a href="<?php // echo base_url(ADMIN_PATH.'send-mail/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Send Mail
						</a>
					</li>
				</ul>
			</li>-->
			
			<li class="<?php if($active_tab == ADMIN_PATH.'newsletter-content' || $active_tab == ADMIN_PATH.'add-newsletter-content' || $active_tab == ADMIN_PATH.'edit-newsletter-content' || $active_tab == ADMIN_PATH.'view-newsletter-content' || $active_tab == ADMIN_PATH.'newsletter-users' || $active_tab == ADMIN_PATH.'add-newsletter-user' || $active_tab == ADMIN_PATH.'edit-newsletter-user' || $active_tab == ADMIN_PATH.'view-newsletter-user') { echo 'active'; } ?> treeview">
				<a role="button">
					<i class="fa fa-user-plus"></i><span>Newsletter</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if($active_tab == ADMIN_PATH.'add-newsletter-user') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'add-newsletter-user/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Add Newsletter User
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'newsletter-users' || $active_tab == ADMIN_PATH.'edit-newsletter-user' || $active_tab == ADMIN_PATH.'view-newsletter-user') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'newsletter-users/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Newsletter User
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'add-newsletter-content') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'add-newsletter-content/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Add Newsletter Content
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'newsletter-content' || $active_tab == ADMIN_PATH.'edit-newsletter-content' || $active_tab == ADMIN_PATH.'view-newsletter-content') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'newsletter-content/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Newsletter Content
						</a>
					</li>
				</ul>
			</li>
			
			<li class="<?php if($active_tab == ADMIN_PATH.'pages' || $active_tab == ADMIN_PATH.'add-page' || $active_tab == ADMIN_PATH.'edit-page' || $active_tab == ADMIN_PATH.'view-page') { echo 'active'; } ?> treeview">
				<a role="button">
					<i class="fa fa-clone"></i><span>Pages</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if($active_tab == ADMIN_PATH.'add-page') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'add-page/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Add Page
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'pages' || $active_tab == ADMIN_PATH.'edit-page' || $active_tab == ADMIN_PATH.'view-page') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'pages/1'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Pages
						</a>
					</li>
				</ul>
			</li>
			
			<li class="<?php if($active_tab == ADMIN_PATH.'contact-us' || $active_tab == ADMIN_PATH.'edit-contact-us' || $active_tab == ADMIN_PATH.'view-contact-us') { echo 'active'; } ?>">
				<a href="<?php echo base_url(ADMIN_PATH.'contact-us/'); ?>">
					<i class="fa fa-envelope"></i><span>Contact Us</span>
				</a>
			</li>
			
			<li class="<?php if($active_tab == ADMIN_PATH.'users' || $active_tab == ADMIN_PATH.'add-user' || $active_tab == ADMIN_PATH.'edit-user' || $active_tab == ADMIN_PATH.'view-user') { echo 'active'; } ?> treeview">
				<a role="button">
					<i class="fa fa-users"></i><span>Users</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if($active_tab == ADMIN_PATH.'add-user') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'add-user/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Add User
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'users' || $active_tab == ADMIN_PATH.'edit-user' || $active_tab == ADMIN_PATH.'view-user') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'users/'); ?>">
							<i class="fa fa-angle-double-right"></i>
							Users
						</a>
					</li>
				</ul>
			</li>
			
			<li class="<?php if($active_tab == ADMIN_PATH.'site-setting') { echo 'active'; } ?> treeview">
				<a role="button">
					<i class="fa fa-wrench"></i><span>Setting</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if($active_tab == ADMIN_PATH.'site-setting') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'site-setting/'); ?>">
							<i class="fa fa-angle-double-right"></i> Site-Setting
						</a>
					</li>
				</ul>
			</li>
			
			<li class="<?php if($active_tab == ADMIN_PATH.'import' || $active_tab == ADMIN_PATH.'export' || $active_tab == ADMIN_PATH.'print-view' || $active_tab == ADMIN_PATH.'editors' || $active_tab == ADMIN_PATH.'dynamic-generate-box' || $active_tab == ADMIN_PATH.'form-design') { echo 'active'; } ?> treeview">
				<a role="button">
					<i class="fa fa-filter"></i><span>Advance</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if($active_tab == ADMIN_PATH.'import') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'import/'); ?>">
							<i class="fa fa-angle-double-right"></i> Import
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'export') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'export/'); ?>">
							<i class="fa fa-angle-double-right"></i> Export
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'print-view') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'print-view/'); ?>">
							<i class="fa fa-angle-double-right"></i> Print View
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'editors') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'editors/'); ?>">
							<i class="fa fa-angle-double-right"></i> Editors
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'dynamic-generate-box') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'dynamic-generate-box/'); ?>">
							<i class="fa fa-angle-double-right"></i> Dynamic Generate Box
						</a>
					</li>
					<li class="<?php if($active_tab == ADMIN_PATH.'form-design') { echo 'active'; } ?>">
						<a href="<?php echo base_url(ADMIN_PATH.'form-design/'); ?>">
							<i class="fa fa-angle-double-right"></i> Form Design
						</a>
					</li>
				</ul>
			</li>
			
		</ul>
	</section>
</aside>