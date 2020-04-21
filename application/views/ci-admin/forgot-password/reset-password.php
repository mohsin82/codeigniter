<?php
	$email = $this->uri->segment(3);
?>

<!-- content -->
<div class="login-box-body">
	
	<h5 class="reset-password-box-msg text-center">Reset Password</h5>
	
	<div>
		<?php echo customErrors(); ?>
		<form method="post">
				<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group has-feedback">
						<input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" tabindex="1" />
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group has-feedback">
						<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" tabindex="2" />
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
				</div>
			</div>
			<div class="row form-group has-feedback">
				<div class="col-xs-6">
					<button type="button" class="btn btn-primary btn-block" id="btnCheckResetPassword" tabindex="3" onclick="checkResetPassword();">Reset Password</button>
				</div>
				<div class="col-xs-6">
					<a class="btn btn-default btn-block" id="btnCancel" tabindex="4" href="<?php echo base_url(ADMIN_PATH.'login/'); ?>">Cancel</a>
				</div>
			</div>
		</form>
	</div>

</div>
<!-- content -->

<!-- scripts -->
<script type="text/javascript">

var btnCheckResetPasswordID = "#btnCheckResetPassword";
var emailID = "#email";
var newPasswordID = "#new_password";
var confirmPasswordID = "#confirm_password";

/* check reset-password function */
function checkResetPassword() {
	
	btnDisabled(btnCheckResetPasswordID);
	
	var email = $(emailID).prop("value");
	var new_password = $(newPasswordID).prop("value");
	var confirm_password = $(confirmPasswordID).prop("value");

	if(email == '' || email == null) {
		
		return false;
	
	} else if(new_password == '' || new_password == null) {
		
		btnEnabled(btnCheckResetPasswordID);
		getFocus(newPasswordID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("New Password" + isRequired);
		return false;
	
	} else if(confirm_password == '' || confirm_password == null) {
		
		btnEnabled(btnCheckResetPasswordID);
		getFocus(confirmPasswordID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Confirm Password" + isRequired);
		return false;	
	
	} else if(new_password != confirm_password) {
		
		btnEnabled(btnCheckResetPasswordID);
		getFocus(confirmPasswordID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(notSame);
		return false;	
	}

		loaderShow();

	var form_data = {
		'email': email,
		'new_password': new_password,
		'confirm_password': confirm_password
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "reset-password-" + ADMIN_PATH,
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
				$(btnCheckResetPasswordID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'login/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnCheckResetPasswordID);
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