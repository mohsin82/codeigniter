<?php
	$siteDetailsData = siteDetails();
	$website_name = $siteDetailsData->website_name;

	$getUsernameData = getUsername();
	$username = $getUsernameData->username;
?>


<header class="main-header">

	<a href="<?php echo base_url(); ?>" class="logo">
		<span class="logo-mini">
			<b><?php echo $website_name; ?></b>
		</span>
		<span class="logo-lg">
			<b><?php echo $website_name; ?></b>
		</span>
	</a>

	<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle text-color-white-font-size-15px" data-toggle="dropdown">
						Hi <?php echo $username; ?>
						<i class="fa fa-caret-down fa-fw"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right navbar-ul">
						<li role="separator" class="padding-5px"></li>
						<li class="li">
							<a href="<?php echo base_url(ADMIN_PATH.'my-account/'); ?>">
								<i class="fa fa-user-circle-o" aria-hidden="true"></i>
								My Account
							</a>
						</li>
						<li role="separator" class="divider"></li>
						<li class="li">
							<a href="<?php echo base_url(ADMIN_PATH.'change-password/'); ?>">
								<i class="fa fa-lock" aria-hidden="true"></i>
								Change Password
							</a>
						</li>
						<li class="li">
							<a href="<?php echo base_url(); ?>" target="_blank">
								<i class="fa fa-external-link" aria-hidden="true"></i>
								Visit Site
							</a>
						</li>
						<li class="last-space"></li>
					</ul>
				</li>
				<li class="logout-div">
					<a href="<?php echo base_url(ADMIN_PATH.'logout/'); ?>" class="text-color-white-font-size-15px">
						<i class="fa fa-sign-out"></i>&nbsp;
						<span>Logout</span>
					</a>
				</li>
			</ul>
		</div>
	</nav>
	
</header>