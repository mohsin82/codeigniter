<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Users <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'users/'); ?>">Users</a></li>
			<li class="active">Add User</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Add New User</h3>
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
										<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" tabindex="1" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Last Name</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" tabindex="2" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Username</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="username" name="username" placeholder="Username" tabindex="3" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Email</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="email" name="email" placeholder="Email" tabindex="4" />
									</div>			
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Phone Number</label>
									</div>
									<div class="col-xs-8">
										<input type="number" class="form-control" id="phone_no" name="phone_no" placeholder="Phone Number" min="0" tabindex="5" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Password</label>
									</div>
									<div class="col-xs-8">
										<input type="password" class="form-control" id="password" name="password" placeholder="Password" tabindex="6" />
									</div>
								</div>
								
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Confirm Password</label>
									</div>
									<div class="col-xs-8">
										<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" tabindex="7" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Role</label>
									</div>
									<div class="col-xs-8">
										<select class="form-control" id="role" name="role" tabindex="8">
											<option value='0'>Select Role</option>
											<?php
												foreach($user_groups as $row) {
													
													echo "<option value='".$row->group_id."'>$row->name</option>";
												}
											?>
										</select>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Status</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" id="status_active" name="status" class="minimal" value="<?php echo YES; ?>" checked tabindex="9" /> Active &nbsp;
										<input type="radio" id="status_deactive" name="status" class="minimal" value="<?php echo NO; ?>" tabindex="9" /> Deactive
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnAddUser" tabindex="10" onclick="AddUser();">Submit</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="11" href="<?php echo base_url(ADMIN_PATH.'users/'); ?>">Cancel</a>
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

var btnAddUserID = "#btnAddUser";
var firstNameID = "#first_name";
var lastNameID = "#last_name";
var userNameID = "#username";
var emailID = "#email";
var phone_noID = "#phone_no";
var passwordID = "#password";
var confirmPasswordID = "#confirm_password";
var roleID = "#role";
var statusID = "input[name=status]:checked";

/* add user */	
function AddUser() {
	
	btnDisabled(btnAddUserID);
	
	var first_name = $.trim($(firstNameID).prop("value"));
	var last_name = $.trim($(lastNameID).prop("value"));
	var username = $.trim($(userNameID).prop("value"));
	var email = $.trim($(emailID).prop("value"));
	var phone_no = $.trim($(phone_noID).prop("value"));
	var password = $(passwordID).prop("value");
	var confirm_password = $(confirmPasswordID).prop("value");
	var role = $.trim($(roleID).prop("value"));
	var status = $.trim($(statusID).val());
	
	var usernameReg = <?php echo ALPHA_NUMERIC_REG; ?>;
	var emailReg = <?php echo EMAIL_REG; ?>;
	var phone_noReg = <?php echo NUMERIC_REG; ?>;

	if(username == '' || username == null) {
		
		btnEnabled(btnAddUserID);
		getFocus(userNameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Username" + isRequired);
		return false;

	} else if(!username.match(usernameReg)) {
		
		btnEnabled(btnAddUserID);
		getFocus(userNameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(doNotEnterSpecialOrSpaceCharecters);
		return false;
	
	} else if(email == ''  || email == null) {
	
		btnEnabled(btnAddUserID);
		getFocus(emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Email" + isRequired);
		return false;

	} else if(!email.match(emailReg)) {
		
		btnEnabled(btnAddUserID);
		getFocus(emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validEmail);
		return false;

	} else if(phone_no == ''  || phone_no == null) {
	
		btnEnabled(btnAddUserID);
		getFocus(phone_noID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Phone Number" + isRequired);
		return false;

	} else if(!phone_no.match(phone_noReg)) {
		
		btnEnabled(btnAddUserID);
		getFocus(phone_noID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validPhone);
		return false;

	} else if(password == '' || password == null) {

		btnEnabled(btnAddUserID);
		getFocus(passwordID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Password" + isRequired);
		return false;
	
	} else if(confirm_password == '' || confirm_password == null) {
		
		btnEnabled(btnAddUserID);
		getFocus(confirmPasswordID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Confirm Password" + isRequired);
		return false;	
	
	} else if(password != confirm_password) {
		
		btnEnabled(btnAddUserID);
		getFocus(confirmPasswordID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(notSame);
		return false;	
	
	} else if(role == '0') {

		btnEnabled(btnAddUserID);
		getFocus(roleID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Role" + isRequired);
		return false;
	}
	
		loaderShow();
	
	var form_data = {
		'first_name': first_name,
		'last_name': last_name,
		'username': username,
		'email': email,
		'phone_no': phone_no,
		'password': password,
		'confirm_password': confirm_password,
		'role': role,
		'status': status
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "insert-user/",
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
				$(btnAddUserID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'users/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnAddUserID);
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