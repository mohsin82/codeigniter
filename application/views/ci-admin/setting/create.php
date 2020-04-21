<?php

	$website_name = $edit->website_name;
	$owner_name = $edit->owner_name;
	$website_email = $edit->website_email;
	$website_phone_no = $edit->website_phone_no;
	$country_id = $edit->country_id;
	$state_id = $edit->state_id;
	$city_id = $edit->city_id;
	$address = $edit->address;
	$website_logo = $edit->website_logo;
	$favicon = $edit->favicon;
	$from_mail = $edit->from_mail;
	$maintenance = $edit->maintenance;

?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Setting <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Site-Setting</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">		
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Edit Setting</h3>
						<div class='pull-right'>
							<button type="button" class="btn btn-primary margin-left-right-15px" id="btnSiteSetting" tabindex="13" onclick="siteSetting();">Save</button>
							<?php echo BACK_BUTTON; ?>
						</div>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8"> 
							<?php echo customErrors(); ?>
							<ul class="nav nav-tabs" id="settingTab">
								<li class="general active" data-class="general">
									<a href="#general">General</a>
								</li>
								<li class="location" data-class="location">
									<a href="#location">Location</a>
								</li>
								<li class="image" data-class="image">
									<a href="#image">Image</a>
								</li>
								<li class="server" data-class="server">
									<a href="#server">Server</a>
								</li>
							</ul>
							<form method="post" enctype="multipart/form-data">
								<div class="tab-content margin-20px">
									<!-- general tab -->
										<div id="general" class="tab-pane fade in active">
											<div class="row form-group">
												<div class="col-xs-4">
													<label><?php echo REQUIRED_CONSTANT; ?>Website Name</label>
												</div>
												<div class="col-xs-8">
													<input type="text" class="form-control" id="website_name" name="website_name" placeholder="Website Name" value="<?php echo $website_name; ?>" tabindex="1" />
												</div>
											</div>
											<div class="row form-group">
												<div class="col-xs-4">
													<label><?php echo REQUIRED_CONSTANT; ?>Owner Name</label>
												</div>
												<div class="col-xs-8">
													<input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Owner Name" value="<?php echo $owner_name; ?>" tabindex="2" />
												</div>
											</div>
											<div class="row form-group">
												<div class="col-xs-4">
													<label><?php echo REQUIRED_CONSTANT; ?>Email</label>
												</div>
												<div class="col-xs-8">
													<input type="email" class="form-control" id="website_email" name="website_email" placeholder="Email" value="<?php echo $website_email; ?>" tabindex="3" />
												</div>
											</div>
											<div class="row form-group">
												<div class="col-xs-4">
													<label><?php echo REQUIRED_CONSTANT; ?>Phone Number</label>
												</div>
												<div class="col-xs-8">
													<input type="number" class="form-control" id="website_phone_no" name="website_phone_no" placeholder="Phone Number" value="<?php echo $website_phone_no; ?>" tabindex="4" />
												</div>
											</div>
										</div>
									<!-- general tab -->
									<!-- location tab -->
									<div id="location" class="tab-pane fade">
										<div class="row form-group">
											<div class="col-xs-4">
												<label><?php echo REQUIRED_CONSTANT; ?>Country</label>
											</div>
											<div class="col-xs-8">
												<select class="form-control" id="country_id" name="country_id" tabindex="5" onChange="getStateList();">
													<option value='0'>Select Country</option>
													<?php
														foreach($countries as $row) {
															
															$selected = '';
															if($country_id == $row->country_id) {
																
																$selected = 'selected = selected';
															}
															
															echo "<option value='".$row->country_id."' $selected>$row->name</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-4">
												<label><?php echo REQUIRED_CONSTANT; ?>State</label>
											</div>
											<div class="col-xs-8">
												<select class="form-control" id="state_id" name="state_id" tabindex="6" onChange="getCityList();">
													<option value='0'>Select State</option>
													<?php
														foreach($states as $row) {
															
															$selected = '';
															if($state_id == $row->state_id) {
																
																$selected = 'selected = selected';
															}
															
															echo "<option value='".$row->state_id."' $selected>$row->name</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-4">
												<label><?php echo REQUIRED_CONSTANT; ?>City</label>
											</div>
											<div class="col-xs-8">
												<select class="form-control" id="city_id" name="city_id" tabindex="7">
													<option value='0'>Select City</option>
													<?php
														foreach($cities as $row) {
															
															$selected = '';
															if($city_id == $row->city_id) {
																
																$selected = 'selected = selected';
															}
															
															echo "<option value='".$row->city_id."' $selected>$row->name</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-4">
												<label><?php echo REQUIRED_CONSTANT; ?>Address</label>
											</div>
											<div class="col-xs-8">
												<textarea class="form-control" id="website_address" name="website_address" placeholder="Address" rows="5" tabindex="8"><?php echo $address; ?></textarea>
											</div>
										</div>
									</div>
									<!-- location tab -->
									<!-- image tab -->
									<div id="image" class="tab-pane fade">
										<div class="row form-group">
											<div class="col-xs-4">
												<label>
													<?php echo NOT_REQUIRED_CONSTANT; ?>Website Logo <br/>
													<?php echo WEBSITE_LOGO_SIZE_CONSTANT; ?>
												</label>
											</div>
											<div class="col-xs-8">
												<input type="file" accept="image/*" class="form-control" id="website_logo" name="website_logo" value="<?php echo $website_logo; ?>" tabindex="9" />
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-4">
												<label>
													<?php echo NOT_REQUIRED_CONSTANT; ?>Favicon <br/>
													<?php echo FAVICON_ICON_SIZE_CONSTANT; ?>
												</label>
											</div>
											<div class="col-xs-8">
												<input type="file" accept="image/*" class="form-control" id="favicon" name="favicon" value="<?php echo $favicon; ?>" tabindex="10" />
											</div>
										</div>
									</div>
									<!-- image tab -->
									<!-- server tab -->
									<div id="server" class="tab-pane fade">
										<div class="row form-group">
											<div class="col-xs-4">
												<label><?php echo REQUIRED_CONSTANT; ?>From Mail</label>
											</div>
											<div class="col-xs-8">
												<input type="email" class="form-control" id="from_mail" name="from_mail" placeholder="From Mail" value="<?php echo $from_mail; ?>" tabindex="11" />
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-4">
												<label><?php echo NOT_REQUIRED_CONSTANT; ?>Maintenance</label>
											</div>
											<div class="col-xs-8">
												<input type="radio" id="maintenance" name="maintenance" class="minimal" value="<?php echo YES; ?>" <?php if($maintenance == YES) echo 'checked'; ?> tabindex="12" /> Active &nbsp;
												<input type="radio" id="maintenance" name="maintenance" class="minimal" value="<?php echo NO; ?>" <?php if($maintenance == NO) echo 'checked'; ?> tabindex="12" /> Deactive
											</div>
										</div>
									</div>
									<!-- server tab -->
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

var generalTab = "general";	
var locationTab = "location";		
var imageTab = "image";	
var serverTab = "server";	
						
var btnSiteSettingID = "#btnSiteSetting";

var website_nameID = "#website_name";
var owner_nameID = "#owner_name";
var website_emailID = "#website_email";
var website_phone_noID = "#website_phone_no";

var addressID = "#website_address";

var website_logoID = "#website_logo";
var faviconID = "#favicon";

var from_mailID = "#from_mail";
var maintenanceID = "input[name=maintenance]:checked";

$(document).ready(function() { 
 
	$("#settingTab a").click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	});
	
});

/* get focus on tabs */
function getTabFocus(getTabId) {

	if($("#settingTab li").hasClass('active')) {

		var classname = $("#settingTab li.active").data('class');
		
		$("#settingTab li.active").removeClass('active');
		$("#"+classname).removeClass('active');
		$("#"+classname).removeClass('in');
		
		$("."+getTabId).addClass('active');
		$("#"+getTabId).addClass('active');
		$("#"+getTabId).addClass('in');
		
	} else {
		
		$("."+getTabId).addClass('active');
		$("#"+getTabId).addClass('active');
		$("#"+getTabId).addClass('in');
	}
	
}

/* site setting */
function siteSetting() { 
	
	btnDisabled(btnSiteSettingID);
	
	var website_name = $.trim($(website_nameID).prop("value"));
	var owner_name = $.trim($(owner_nameID).prop("value"));
	var website_email = $.trim($(website_emailID).prop("value"));
	var website_phone_no = $.trim($(website_phone_noID).prop("value"));
	var country = $.trim($(countryID).prop("value"));
	var state = $.trim($(stateID).prop("value"));
	var city = $.trim($(cityID).prop("value"));
	var address = $.trim($(addressID).prop("value"));
	var website_logo = $(website_logoID).prop('files')[0];
	var favicon = $(faviconID).prop('files')[0];
	var from_mail = $.trim($(from_mailID).prop("value"));
	var maintenance = $.trim($(maintenanceID).val());
	
	var emailReg = <?php echo EMAIL_REG; ?>;
	var phone_noReg = <?php echo NUMERIC_REG; ?>;
	
	if(website_name == '' || website_name == null) {
	
		btnEnabled(btnSiteSettingID);
		getTabFocus(generalTab);
		getFocus(website_nameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Website name" + isRequired);
		return false;
		
	} else if(owner_name == '' || owner_name == null) {
	
		btnEnabled(btnSiteSettingID);
		getTabFocus(generalTab);
		getFocus(owner_nameID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Owner name" + isRequired);
		return false;

	} else if(website_email == ''  || website_email == null) {
	
		btnEnabled(btnSiteSettingID);
		getTabFocus(generalTab);
		getFocus(website_emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Email" + isRequired);
		return false;

	} else if(!website_email.match(emailReg)) {
		
		btnEnabled(btnSiteSettingID);
		getTabFocus(generalTab);
		getFocus(website_emailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validEmail);
		return false;
	
	} else if(website_phone_no == ''  || website_phone_no == null) {
	
		btnEnabled(btnSiteSettingID);
		getTabFocus(generalTab);
		getFocus(website_phone_noID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Phone Number" + isRequired);
		return false;

	} else if(!website_phone_no.match(phone_noReg)) {
		
		btnEnabled(btnSiteSettingID);
		getTabFocus(generalTab);
		getFocus(website_phone_noID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validPhone);
		return false;
	
	} else if(country == '0') {

		btnEnabled(btnSiteSettingID);
		getTabFocus(locationTab);
		getFocus(countryID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Country" + isRequired);
		return false;
	
	} else if(state == '0') {

		btnEnabled(btnSiteSettingID);
		getTabFocus(locationTab);
		getFocus(stateID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("State" + isRequired);
		return false;
	
	} else if(city == '0') {

		btnEnabled(btnSiteSettingID);
		getTabFocus(locationTab);
		getFocus(cityID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("City" + isRequired);
		return false;
	
	} else if(address == ''  || address == null) {
		
		btnEnabled(btnSiteSettingID);
		getTabFocus(locationTab);
		getFocus(addressID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Address" + isRequired);
		return false;
	
	} else if(from_mail == ''  || from_mail == null) {
	
		btnEnabled(btnSiteSettingID);
		getTabFocus(serverTab);
		getFocus(from_mailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("From Email" + isRequired);
		return false;

	} else if(!from_mail.match(emailReg)) {
		
		btnEnabled(btnSiteSettingID);
		getTabFocus(serverTab);
		getFocus(from_mailID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(validEmail);
		return false;
	}
	
		loaderShow();
	
	var form_data = new FormData();
	form_data.append('website_name',website_name);
	form_data.append('owner_name',owner_name);
	form_data.append('website_email',website_email);
	form_data.append('website_phone_no',website_phone_no);
	form_data.append('country',country);
	form_data.append('state',state);
	form_data.append('city',city);
	form_data.append('address',address);
	form_data.append('website_logo',website_logo);
	form_data.append('favicon',favicon);
	form_data.append('from_mail',from_mail);
	form_data.append('maintenance',maintenance);
	
	$.ajax({
		url: BASE_URL_ADMIN + "update-site-setting/",
		type: "POST",
		async: false,
		data: form_data,
		dataType: "json",
		cache: false,
		contentType: false,
		processData: false,
		success: function(json_response) {
			
			// alert(json_response);
			// console.log(json_response);
			
			var response = $.trim(json_response.response);
			var msg = $.trim(json_response.msg);
			if(response === "true") {
		
				$(errorID).removeClass(errorClass);
				$(errorID).addClass(successClass);
				$(errorID).html(msg);
				$(btnSiteSettingID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'dashboard/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnSiteSettingID);
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