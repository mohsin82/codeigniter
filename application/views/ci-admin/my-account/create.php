<?php

	$first_name = $edit->first_name;
	$last_name = $edit->last_name;
	$username = $edit->username;
	$email = $edit->email;
	$phone_no = $edit->phone_no;

?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>My Account <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">My Account</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">		
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">My Account</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post">
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>First Name</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php echo $first_name; ?>" tabindex="1" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Last Name</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $last_name; ?>" tabindex="2" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Username</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>" tabindex="3" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Email</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" tabindex="4" />
									</div>			
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Phone Number</label>
									</div>
									<div class="col-xs-8">
										<input type="number" class="form-control" id="phone_no" name="phone_no" placeholder="Phone Number" value="<?php echo $phone_no; ?>" min="0" tabindex="5" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnMyAccount" tabindex="6" onclick="MyAccount();">Save</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="7" href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Cancel</a>
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

var btnMyAccountID = "#btnMyAccount";
var firstNameID = "#first_name";
var lastNameID = "#last_name";
var userNameID = "#username";
var emailID = "#email";
var phone_noID = "#phone_no";

/* update my-account */
function MyAccount() {
	
	btnDisabled(btnMyAccountID);

	var first_name = $.trim($(firstNameID).prop("value"));
	var last_name = $.trim($(lastNameID).prop("value"));
	var username = $.trim($(userNameID).prop("value"));
	var email = $.trim($(emailID).prop("value"));
	var phone_no = $.trim($(phone_noID).prop("value"));
	
	var usernameReg = <?php echo ALPHA_NUMERIC_REG; ?>;
	var emailReg = <?php echo EMAIL_REG; ?>;
	var phone_noReg = <?php echo NUMERIC_REG; ?>;

	if(username == '' || username == null) {
		
		btnEnabled(btnMyAccountID);
		getFocus(userNameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Username" + isRequired);
		return false;
		
	} else if(!username.match(usernameReg)) {
		
		btnEnabled(btnMyAccountID);
		getFocus(userNameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(doNotEnterSpecialCharecters);
		return false;
	
	} else if(email == '' || email == null) {
		
		btnEnabled(btnMyAccountID);
		getFocus(emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Email" + isRequired);
		return false;
		
	} else if(!email.match(emailReg)) {
		
		btnEnabled(btnMyAccountID);
		getFocus(emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validEmail);
		return false;
	
	} else if(phone_no == ''  || phone_no == null) {
	
		btnEnabled(btnMyAccountID);
		getFocus(phone_noID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Phone Number" + isRequired);
		return false;

	} else if(!phone_no.match(phone_noReg)) {
		
		btnEnabled(btnMyAccountID);
		getFocus(phone_noID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validPhone);
		return false;
	}
	
		loaderShow();
	
	var form_data = {
		'first_name': first_name,
		'last_name': last_name,
		'username': username,
		'email': email,
		'phone_no': phone_no
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "update-my-account/",
		type: "POST",
		async: false,
		data: form_data,
		dataType: "json",
		success: function(json_response) {
			
			// alert(json_response);
			console.log(json_response);

			var response = $.trim(json_response.response);
			var msg = $.trim(json_response.msg);
			if(response === "true") {
		
				$(errorID).removeClass(errorClass);
				$(errorID).addClass(successClass);
				$(errorID).html(msg);
				$(btnMyAccountID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'dashboard/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnMyAccountID);
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