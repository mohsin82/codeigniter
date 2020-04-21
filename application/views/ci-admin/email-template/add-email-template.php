<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Email Templates <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'email-templates/'); ?>">Email Templates</a></li>
			<li class="active">Add Email Template</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Add Email Template</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px emailTemplateContainer">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post">
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Subject</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" tabindex="1" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Message</label>
									</div>
									<div class="col-xs-8">
										<textarea class="form-control" id="message" name="message" placeholder="Message" tabindex="2"></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Status</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" id="status_active" name="status" class="minimal" value="<?php echo YES; ?>" checked tabindex="3" /> Active &nbsp;
										<input type="radio" id="status_deactive" name="status" class="minimal" value="<?php echo NO; ?>" tabindex="3" /> Deactive
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnAddEmailTemplate" tabindex="4" onclick="AddEmailTemplate();">Submit</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="5" href="<?php echo base_url(ADMIN_PATH.'email-templates/'); ?>">Cancel</a>
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

$(function () {
    CKEDITOR.replace('message');
});

var btnAddEmailTemplateID = "#btnAddEmailTemplate";
var subjectID = "#subject";
var messageID = ".emailTemplateContainer iframe";
var statusID = "input[name=status]:checked";

/* add email template */
function AddEmailTemplate() {
	
	btnDisabled(btnAddEmailTemplateID);
	
	var subject = $.trim($(subjectID).prop("value"));
	var message = $.trim(CKEDITOR.instances.message.getData());
	var message_textonly = $.trim($(messageID).contents().find("body").text());
	var status = $.trim($(statusID).val());
	
	var subjectReg = <?php echo ALPHA_SPACE_REG; ?>;
	var messageLength = message_textonly.length;
	
	if(subject == '' || subject == null) {
		
		btnEnabled(btnAddEmailTemplateID);
		getFocus(subjectID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Subject" + isRequired);
		return false;

	} else if(!subject.match(subjectReg)) {
	
		btnEnabled(btnAddEmailTemplateID);
		getFocus(subjectID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(onlyAlphabtesAndSpace);
		return false;
	
	} else if(messageLength == 0) {

		btnEnabled(btnAddEmailTemplateID);
		getFocus($(messageID).contents().find('body'));
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Message" + isRequired);
		return false;
	}
	
		loaderShow();
		
	var form_data = {
		'subject': subject,
		'message': message,
		'status': status
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "insert-email-template/",
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
				$(btnAddEmailTemplateID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + "email-templates/";
				
			} else {
				
				loaderHide();
				btnEnabled(btnAddEmailTemplateID);
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