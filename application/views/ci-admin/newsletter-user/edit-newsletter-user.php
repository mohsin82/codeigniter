<?php

	$uri = $this->uri->segment(3);
	$email = $edit->email;
	$status = $edit->status;

?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Newsletter User <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'newsletter-users/'); ?>">Newsletter User</a></li>
			<li class="active">Edit Newsletter User</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Edit Newsletter User</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post">
									<input type="hidden" name="uri" id="uri" value="<?php echo $uri; ?>" />
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Email</label>
									</div>
									<div class="col-xs-8">
										<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" tabindex="1" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Status</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" id="status_active" name="status" class="minimal" value="<?php echo YES; ?>" <?php if($status == YES) echo 'checked'; ?> tabindex="2" /> Active &nbsp;
										<input type="radio" id="status_deactive" name="status" class="minimal" value="<?php echo NO; ?>" <?php if($status == NO) echo 'checked'; ?> tabindex="2" /> Deactive
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnEditNewsletterUser" tabindex="3" onclick="EditNewsletterUser();">Save</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="4" href="<?php echo base_url(ADMIN_PATH.'newsletter-users/'); ?>">Cancel</a>
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

var btnEditNewsletterUserID = "#btnEditNewsletterUser";
var uriID = "#uri";
var emailID = "#email";
var statusID = "input[name=status]:checked";

/* edit newsletter user */
function EditNewsletterUser() {
	
	btnDisabled(btnEditNewsletterUserID);
	
	var id = $.trim($(uriID).prop("value"));
	var email = $.trim($(emailID).prop("value"));
	var status = $.trim($(statusID).val());
	
	var emailReg = <?php echo EMAIL_REG; ?>;
	
	if(email == '' || email == null) {
	
		btnEnabled(btnEditNewsletterUserID);
		getFocus(emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Email" + isRequired);
		return false;
		
	} else if(!email.match(emailReg)) {
		
		btnEnabled(btnEditNewsletterUserID);
		getFocus(emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validEmail);
		return false;
	}
	
		loaderShow();
		
	var form_data = {
		'id': id,
		'email': email,
		'status': status
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "update-newsletter-user/",
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
				$(btnEditNewsletterUserID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'newsletter-users/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnEditNewsletterUserID);
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