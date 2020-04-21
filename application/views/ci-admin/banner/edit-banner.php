<?php

	$uri = $this->uri->segment(3);
	$name = $edit->name;
	$status = $edit->status;
	
?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Banners <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'banners/'); ?>">Banners</a></li>
			<li class="active">Edit Banner</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Edit Banner</h3>
						<?php echo BACK_BUTTON;?>
					</div>
						
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post">
									<input type="hidden" name="uri" id="uri" value="<?php echo $uri; ?>" />
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Name</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="banner_name" name="banner_name" placeholder="Name" value="<?php echo $name; ?>" tabindex="1" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Status</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" id="status_active" name="status" class="minimal" value="<?php echo YES; ?>" <?php if($status == YES) echo 'checked'; ?> tabindex="2" /> Active &nbsp;
										<input type="radio" id="status_deactive" name="status" class="minimal" value="<?php echo NO; ?>" <?php if($status == NO) echo 'checked'; ?>  tabindex="2"/> Deactive
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnEditBanner" tabindex="3" onclick="EditBanner();">Save</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="4" href="<?php echo base_url(ADMIN_PATH.'banners/'); ?>">Cancel</a>
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

var btnEditBannerID = "#btnEditBanner";
var uriID = "#uri";
var banner_nameID = "#banner_name";
var statusID = "input[name=status]:checked";

/* edit banner */
function EditBanner() {
	
	btnDisabled(btnEditBannerID);
	
	var id = $.trim($(uriID).prop("value"));
	var banner_name = $.trim($(banner_nameID).prop("value"));
	var status = $.trim($(statusID).val());
	
	var banner_nameReg = <?php echo ALPHA_SPACE_REG; ?>;
	
	if(banner_name == '' || banner_name == null) {
		
		btnEnabled(btnEditBannerID);
		getFocus(banner_nameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Name" + isRequired);
		return false;
	
	} else if(!banner_name.match(banner_nameReg)) {
		
		btnEnabled(btnEditBannerID);
		getFocus(banner_nameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(onlyAlphabtesAndSpace);
		return false;
	}
	
		loaderShow();
	
	var form_data = {
		'id': id,
		'name': banner_name,
		'status': status
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "update-banner/",
		type: "POST",
		async: false,
		data: form_data,
		dataType: "json",
		success: function(json_response) {
			
			// alert(json_response);
			// console.log(json_response);
			
			var response = $.trim(json_response.response);
			var msg = $.trim(json_response.msg);
			if(response === "true") {
		
				$(errorID).removeClass(errorClass);
				$(errorID).addClass(successClass);
				$(errorID).html(msg);
				$(btnEditBannerID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'banners/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnEditBannerID);
				$(errorID).removeClass(successClass);
				$(errorID).addClass(errorClass);
				$(errorID).html(msg);
				return false;
			}
			
		},
		error: function() {
			// alert("fail");
		} 
	});
}

</script>
<!-- scripts -->