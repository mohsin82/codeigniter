<?php

	$uri = $this->uri->segment(3);
	$title = $edit->title;
	$description = $edit->description;
	$status = $edit->status;

?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Newsletter Content <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'newsletter-content/'); ?>">Newsletter Content</a></li>
			<li class="active">Edit Newsletter Content</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Edit Newsletter Content</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px newsletterContentContainer">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post">
									<input type="hidden" name="uri" id="uri" value="<?php echo $uri; ?>" />
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Title</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $title; ?>" tabindex="1" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Description</label>
									</div>
									<div class="col-xs-8">
										<textarea type="text" class="form-control" id="description" name="description" placeholder="Description" tabindex="2"><?php echo $description; ?></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Status</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" id="status_active" name="status" class="minimal" value="<?php echo YES; ?>" <?php if($status == YES) echo 'checked'; ?> tabindex="3" /> Active &nbsp;
										<input type="radio" id="status_deactive" name="status" class="minimal" value="<?php echo NO; ?>" <?php if($status == NO) echo 'checked'; ?> tabindex="3" /> Deactive
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnEditNewsletterContent" tabindex="4" onclick="EditNewsletterContent();">Save</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="5" href="<?php echo base_url(ADMIN_PATH.'newsletter-content/'); ?>">Cancel</a>
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
    CKEDITOR.replace('description');
});

var btnEditNewsletterContentID = "#btnEditNewsletterContent";
var uriID = "#uri";
var titleID = "#title";
var descriptionID = ".newsletterContentContainer iframe";
var statusID = "input[name=status]:checked";

/* edit newsletter content */
function EditNewsletterContent() {
	
	btnDisabled(btnEditNewsletterContentID);
	
	var id = $.trim($(uriID).prop("value"));
	var title = $.trim($(titleID).prop("value"));
	var description = $.trim(CKEDITOR.instances.description.getData());
	var description_textonly = $.trim($(descriptionID).contents().find("body").text());
	var status = $.trim($(statusID).val());
	
	var titleReg = <?php echo ALPHA_SPACE_REG; ?>;
	var descriptionLength = description_textonly.length;

	if(title == '' || title == null) {
	
		btnEnabled(btnEditNewsletterContentID);
		getFocus(titleID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Title" + isRequired);
		return false;

	} else if(!title.match(titleReg)) {
		
		btnEnabled(btnEditNewsletterContentID);
		getFocus(titleID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html(onlyAlphabtesAndSpace);
		return false;
	
	} else if(descriptionLength == 0) {
	
		btnEnabled(btnEditNewsletterContentID);
		getFocus($(descriptionID).contents().find('body'));;
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Description" + isRequired);
		return false;
	}
	
		loaderShow();
		
	var form_data = {
		'id': id,
		'title': title,
		'description': description,
		'status': status
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "update-newsletter-content",
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
				$(btnEditNewsletterContentID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'newsletter-content/';
				
			} else {
				
				loaderHide();
				btnEnabled(btnEditNewsletterContentID);
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