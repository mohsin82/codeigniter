<?php

	$uri = $this->uri->segment(3);
	$name = $edit->name;
	$email = $edit->email;
	$subject = $edit->subject;
	$message = $edit->message;
	$reply = $edit->reply;

?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Contact Us <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'contact-us/'); ?>">Contact Us</a></li>
			<li class="active">Edit Contact Us</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Edit Contact Us</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px contactusContainer">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post">
									<input type="hidden" name="uri" id="uri" value="<?php echo $uri; ?>" />
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Name</label>
									</div>
									<div class="col-xs-8">
										<?php echo $name; ?>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Email</label>
									</div>
									<div class="col-xs-8">
										<?php echo $email; ?>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Subject</label>
									</div>
									<div class="col-xs-8">
										<?php echo $subject; ?>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Message</label>
									</div>
									<div class="col-xs-8">
										<?php echo $message; ?>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Reply</label>
									</div>
									<div class="col-xs-8">
										<textarea type="text" class="form-control" id="reply" name="reply" placeholder="Reply" tabindex="1"><?php echo $reply; ?></textarea>
									</div>			
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnEditContactus" tabindex="2" onclick="EditContactus();">Reply</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="3" href="<?php echo base_url(ADMIN_PATH.'contact-us/'); ?>">Cancel</a>
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
    CKEDITOR.replace('reply');
});

var btnEditContactusID = "#btnEditContactus";
var uriID = "#uri";
var replyID = ".contactusContainer iframe";

/* edit newsletter content */
function EditContactus() {
	
	btnDisabled(btnEditContactusID);
	
	var id = $.trim($(uriID).prop("value"));
	var reply = $.trim(CKEDITOR.instances.reply.getData());
	var reply_textonly = $.trim($(replyID).contents().find("body").text());
	var replyLength = reply_textonly.length;

	if(replyLength == 0) {

		btnEnabled(btnEditContactusID);
		getFocus($(replyID).contents().find('body'));
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Reply" + isRequired);
		return false;
	}
	
		loaderShow();
		
	var form_data = {
		'id': id,
		'reply': reply
	};		
		
	$.ajax({
		url: BASE_URL_ADMIN + "update-contact-us/",
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
				$(btnEditContactusID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'contact-us/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnEditContactusID);
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