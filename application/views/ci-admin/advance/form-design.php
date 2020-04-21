<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Form Design <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Form Design</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Form Design</h3>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8">
							<form method="post">
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Radio Button</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" class="minimal" id="status_active" name="status" value="<?php echo YES; ?>" checked tabindex="1" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Check-Box</label>
									</div>
									<div class="col-xs-8">
										<div class="remember_me">
											<label>
												<input type="checkbox" id="checkbox" name="checkbox" value="1" checked tabindex="2" />
											</label>
										</div>
									</div>
								</div>
								<div class="spacer"></div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>File</label>
									</div>
									<div class="col-xs-8">
										<span id="selectFile" tabindex="3" onclick="selectFile();"> Select a file</span>
										<input type="file" accept="image/*" class="form-control file-hide" id="file" name="file" />
									</div>
								</div>
							</form>
						</div>
					</div>
						
				</div>
         		</div>			
		</div>
	</section>
	
</div>
<!-- content -->


<!-- scripts -->
<script type="text/javascript">

/* select file */
function selectFile() {
	
	/* call type=file */
	$("#file").click();
}	
	
</script>
<!-- scripts -->