<!-- content -->
<div class="login-box-body">
	
	<h5 class="forgot-password-box-msg text-center">Forgot Password</h5>
	
	<div>
		<?php echo customErrors(); ?>
		<form method="post">
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group has-feedback">
						<input type="text" class="form-control" id="email" name="email" placeholder="Email" tabindex="1" />
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
				</div>
			</div>
			<div class="row form-group has-feedback">
				<div class="col-xs-6">
					<button type="button" class="btn btn-primary btn-block" id="btnForgotPassword" tabindex="2" onclick="getForgotPassword();">Forgot Password</button>
				</div>
				<div class="col-xs-6">
					<a class="btn btn-default btn-block" id="btnCancel" tabindex="3" href="<?php echo base_url(ADMIN_PATH.'login/'); ?>">Cancel</a>
				</div>
			</div>
		</form>
	</div>

</div>
<!-- content -->

<!-- scripts -->
<script type="text/javascript">

var btnForgotPasswordID = "#btnForgotPassword";
var emailID = "#email";

var keypressID = "#email";
$(keypressID).keypress(function (e) {
	if (e.which == 13) {
		getForgotPassword();
		return false;
	}	
});

/* forgot-password function */
function getForgotPassword() {
	
	btnDisabled(btnForgotPasswordID);
	
	var email = $(emailID).prop("value");
	
	var emailReg = <?php echo EMAIL_REG; ?>;
	
	if(email == '' || email == null) {
	
		btnEnabled(btnForgotPasswordID);
		getFocus(emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Email" + isRequired);
		return false;

	} else if(!email.match(emailReg)) {
		
		btnEnabled(btnForgotPasswordID);
		getFocus(emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validEmail);
		return false;
	}
	
		loaderShow();

	var form_data = {
		'email': email
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "get-forgot-password/",
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
				$(btnForgotPasswordID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'login/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnForgotPasswordID);
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