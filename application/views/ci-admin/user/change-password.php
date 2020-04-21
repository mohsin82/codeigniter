<?php

	$uri = $this->uri->segment(3);
		
?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Change Password <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'users/'); ?>">Users</a></li>
			<li class="active">Change Password</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Change Password</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post">
									<input type="hidden" name="uri" id="uri" value="<?php echo $uri; ?>" />
								<div class="row form-group has-feedback">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>New Password</label>
									</div>
									<div class="col-xs-8">
										<input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" tabindex="1" />
										<span class="glyphicon glyphicon-lock form-control-feedback margin-left-right-15px"></span>
									</div>
								</div>
								<div class="row form-group has-feedback">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Confirm Password</label>
									</div>
									<div class="col-xs-8">
										<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" tabindex="2" />
										<span class="glyphicon glyphicon-lock form-control-feedback margin-left-right-15px"></span>
									</div>
								</div>
								<div class="row form-group has-feedback">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnChangePassword" tabindex="3" onclick="getChangePassword();">Change Password</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-danger btn-block" id="btnCancel" tabindex="4" href="<?php echo base_url(ADMIN_PATH.'users/'); ?>">Cancel</a>
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

var btnChangePasswordID = "#btnChangePassword";
var uriID = "#uri";
var newPasswordID = "#new_password";
var confirmPasswordID = "#confirm_password";

/* change password user function */
function getChangePassword() {
	
	btnDisabled(btnChangePasswordID);
	
	var id = $.trim($(uriID).prop("value"));
	var new_password = $(newPasswordID).prop("value");
	var confirm_password = $(confirmPasswordID).prop("value");
	
	if(new_password == '' || new_password == null) {
		
		btnEnabled(btnChangePasswordID);
		getFocus(newPasswordID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("New Password" + isRequired);
		return false;
	
	} else if(confirm_password == '' || confirm_password == null) {
		
		btnEnabled(btnChangePasswordID);
		getFocus(confirmPasswordID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Confirm Password" + isRequired);
		return false;	
	
	} else if(new_password != confirm_password) {
		
		btnEnabled(btnChangePasswordID);
		getFocus(confirmPasswordID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(notSame);
		return false;	
	}

	loaderShow();
	
	var form_data = {
		'id': id,
		'new_password': new_password,
		'confirm_password': confirm_password
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "update-change-password-user",
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
				$(btnChangePasswordID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'users/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnChangePasswordID);
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