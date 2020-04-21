<!-- content -->
<div class="login-box-body">
	
	<h5 class="login-box-msg">Sign in to start your session</h5>
	
	<div>
		<?php echo customErrors(); ?>
		<form method="post">
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group has-feedback">
						<input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $cookie_admin_username; ?>" tabindex="1" />
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">		
					<div class="form-group has-feedback">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $cookie_admin_password; ?>" tabindex="2" />
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 padding-left-right-15px-0px">
					<div class="remember_me">
						<label>
							<input type="checkbox" id="remember" name="remember" tabindex="3" />
							<span class="remember">Remember Me</span>
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-8">
					<div class="spacer"></div>
					<div class="forgot-password">
						<a href="<?php echo base_url(ADMIN_PATH.'forgot-password/'); ?>" tabindex="4">Forgot Password</a>
					</div>
				</div>
				<div class="col-xs-6 col-sm-4">
					<button type="button" class="btn btn-primary btn-block" id="btnLogin" tabindex="5" onclick="getLogin();">Login</button>
				</div>
			</div>
		</form>
	</div>

</div>
<!-- content -->

<!-- scripts -->
<script type="text/javascript">

var btnLoginID = "#btnLogin";
var usernameID = "#username";
var passwordID = "#password";
var rememberID = "#remember";

var keypressID = "#username,#password";
$(keypressID).keypress(function (e) {
	if (e.which == 13) {
		getLogin();
	}
});

/* login function */
function getLogin() {
	
	btnDisabled(btnLoginID);
	
	var username = $(usernameID).prop("value");
	var password = $(passwordID).prop("value");
	var remember = '0';
	if($('input[name="remember"]').prop('checked') == true) {
		remember = '1';
	}
	
	var username_reg = <?php echo ALPHA_NUMERIC_REG; ?>;
	
	if(username == '' || username == null) {
	
		btnEnabled(btnLoginID);
		getFocus(usernameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Username" + isRequired);
		return false;

	} else if(!username.match(username_reg)) {
		
		btnEnabled(btnLoginID);
		getFocus(usernameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(doNotEnterSpecialOrSpaceCharecters);
		return false;
	
	} else if(password == '' || password == null) {
		
		btnEnabled(btnLoginID);
		getFocus(passwordID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Password" + isRequired);
		return false;
	}
	
		loaderShow();

	var form_data = {
		'username': username,
		'password': password,
		'remember': remember
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "get-login/",
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
				$(btnLoginID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'dashboard/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnLoginID);
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