<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Editors <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Editors</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Editors</h3>
					</div>
					
					<div class="box-body margin-left-right-15px editorsContainer">
						<div class="col-lg-8">
							<form method="post">
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Ckeditor</label>
									</div>
									<div class="col-xs-8">
										<textarea class="form-control" id="ckeditor" name="ckeditor" placeholder="Ckeditor" tabindex="1"></textarea>
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

$(function () {
    CKEDITOR.replace('ckeditor');
});

var ckeditorID = ".editorsContainer iframe";

/* btn click */
function btnClick() {
	
	var ckeditor = $.trim(CKEDITOR.instances.ckeditor.getData());
	var ckeditor_textonly = $.trim($(ckeditorID).contents().find("body").text());
	
	var ckeditorLength = ckeditor_textonly.length;
	
	if(ckeditorLength == 0) {
	
		/* call error function */
	}
	
	var form_data = {
		'ckeditor': ckeditor
	};
}

</script>
<!-- scripts -->