<?php

	$uri = $this->uri->segment(3);
	$first_name = $edit->first_name;
	$last_name = $edit->last_name;
	$username = $edit->username;
	$email = $edit->email;
	$phone_no = $edit->phone_no;
	$group_id = $edit->group_id;
	$status = $edit->status;

?>
<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Users <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'users/'); ?>">Users</a></li>
			<li class="active">Edit User</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Edit User</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post">
									<input type="hidden" name="uri" id="uri" value="<?php echo $uri; ?>" />
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
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Role</label>
									</div>
									<div class="col-xs-8">
										<select class="form-control" id="role" name="role" tabindex="6">
											<option value='0'>Select Role</option>
											<?php
												foreach($user_groups as $row) {
													
													$selected = '';
													if($row->group_id == $group_id) {
														
														$selected = 'selected = selected';
													}
													
													echo "<option value='".$row->group_id."' $selected>$row->name</option>";
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
										<input type="radio" id="status_active" name="status" class="minimal" value="<?php echo YES; ?>" <?php if($status == YES) echo 'checked'; ?> tabindex="7" /> Active &nbsp;
										<input type="radio" id="status_deactive" name="status" class="minimal" value="<?php echo NO; ?>" <?php if($status == NO) echo 'checked'; ?> tabindex="7" /> Deactive
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnEditUser" tabindex="8" onclick="EditUser();">Save</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="9" href="<?php echo base_url(ADMIN_PATH.'users/'); ?>">Cancel</a>
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

var btnEditUserID = "#btnEditUser";
var uriID = "#uri";
var firstNameID = "#first_name";
var lastNameID = "#last_name";
var userNameID = "#username";
var emailID = "#email";
var phone_noID = "#phone_no";
var passwordID = "#password";
var roleID = "#role";
var statusID = "input[name=status]:checked";

/* edit user */
function EditUser() {
	
	btnDisabled(btnEditUserID);

	var id = $.trim($(uriID).prop("value"));
	var first_name = $.trim($(firstNameID).prop("value"));
	var last_name = $.trim($(lastNameID).prop("value"));
	var username = $.trim($(userNameID).prop("value"));
	var email = $.trim($(emailID).prop("value"));
	var phone_no = $.trim($(phone_noID).prop("value"));
	var role = $.trim($(roleID).prop("value"));
	var status = $.trim($(statusID).val());
	
	var usernameReg = <?php echo ALPHA_NUMERIC_REG; ?>;
	var emailReg = <?php echo EMAIL_REG; ?>;
	var phone_noReg = <?php echo NUMERIC_REG; ?>;

	if(username == '' || username == null) {
		
		btnEnabled(btnEditUserID);
		getFocus(userNameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Username" + isRequired);
		return false;

	} else if(!username.match(usernameReg)) {
		
		btnEnabled(btnEditUserID);
		getFocus(userNameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(doNotEnterSpecialOrSpaceCharecters);
		return false;
	
	} else if(email == ''  || email == null) {
	
		btnEnabled(btnEditUserID);
		getFocus(emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Email" + isRequired);
		return false;

	} else if(!email.match(emailReg)) {
		
		btnEnabled(btnEditUserID);
		getFocus(emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validEmail);
		return false;

	} else if(phone_no == ''  || phone_no == null) {
	
		btnEnabled(btnEditUserID);
		getFocus(phone_noID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Phone Number" + isRequired);
		return false;

	} else if(!phone_no.match(phone_noReg)) {
		
		btnEnabled(btnEditUserID);
		getFocus(phone_noID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validPhone);
		return false;

	} else if(role == '0') {

		btnEnabled(btnEditUserID);
		getFocus(roleID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Role" + isRequired);
		return false;
	}
	
		loaderShow();
	
	var form_data = {
		'id': id,
		'first_name': first_name,
		'last_name': last_name,
		'username': username,
		'email': email,
		'phone_no': phone_no,
		'role': role,
		'status': status
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "update-user/",
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
				$(btnEditUserID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'users/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnEditUserID);
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