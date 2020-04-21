<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Page <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'pages/1'); ?>">Pages</a></li>
			<li class="active">Add Page</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Add Page</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px pageContainer">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post">
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Title</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="page_title" name="page_title" placeholder="Title" tabindex="1" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Description</label>
									</div>
									<div class="col-xs-8">
										<textarea class="form-control" id="page_description" name="page_description" placeholder="Description" tabindex="2"></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo REQUIRED_CONSTANT; ?>Meta Tag Title</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="meta_tag_title" name="title" placeholder="Meta Tag Title" tabindex="3" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Meta Tag Description</label>
									</div>
									<div class="col-xs-8">
										<textarea class="form-control" id="meta_tag_description" name="meta_tag_description" placeholder="Meta Tag Description" rows="8" tabindex="4"></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Meta Tag Keywords</label>
									</div>
									<div class="col-xs-8">
										<textarea class="form-control" id="meta_tag_keywords" name="meta_tag_keywords" placeholder="Meta Tag Keyword Like : Admin, User etc" rows="8" tabindex="5"></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Status</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" id="status_active" name="status" class="minimal" value="<?php echo YES; ?>" checked tabindex="6" /> Active &nbsp;
										<input type="radio" id="status_deactive" name="status" class="minimal" value="<?php echo NO; ?>" tabindex="6" /> Deactive
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnAddPage" tabindex="7" onclick="AddPage();">Submit</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="8" href="<?php echo base_url(ADMIN_PATH.'pages/1'); ?>">Cancel</a>
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
    CKEDITOR.replace('page_description');
});

var btnAddPageID = "#btnAddPage";
var page_titleID = "#page_title";
var page_descriptionID = ".pageContainer iframe";
var meta_tag_titleID = "#meta_tag_title";
var meta_tag_descriptionID = "#meta_tag_description";
var meta_tag_keywordsID = "#meta_tag_keywords";
var statusID = "input[name=status]:checked";

/* add page */
function AddPage() {
	
	btnDisabled(btnAddPageID);
	
	var page_title = $.trim($(page_titleID).prop("value"));
	var page_description = $.trim(CKEDITOR.instances.page_description.getData());
	var page_description_textonly = $.trim($(page_descriptionID).contents().find("body").text());
	var meta_tag_title = $.trim($(meta_tag_titleID).prop("value"));
	var meta_tag_description = $.trim($(meta_tag_descriptionID).prop("value"));
	var meta_tag_keywords = $.trim($(meta_tag_keywordsID).prop("value"));
	var status = $.trim($(statusID).val());
	
	var page_descriptionLength = page_description_textonly.length;

	if(page_title == '' || page_title == null) {
		
		btnEnabled(btnAddPageID);
		getFocus(page_titleID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Title" + isRequired);
		return false;

	} else if(page_descriptionLength == 0) {

		btnEnabled(btnAddPageID);
		getFocus($(page_descriptionID).contents().find('body'));
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Description" + isRequired);
		return false;
	
	} else if(meta_tag_title == '' || meta_tag_title == null) {

		btnEnabled(btnAddPageID);
		getFocus(meta_tag_titleID);
		$(errorID).removeClass(successClass);
		$(errorID).addClass(errorClass);
		$(errorID).html("Meta Tag Title" + isRequired);
		return false;
	}
	
		loaderShow();
		
	var form_data = {
		'page_title': page_title,
		'page_description': page_description,
		'meta_tag_title': meta_tag_title,
		'meta_tag_description': meta_tag_description,
		'meta_tag_keywords': meta_tag_keywords,
		'status': status
	};
	
	$.ajax({
		url: BASE_URL_ADMIN + "insert-page/",
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
				$(btnAddPageID).html(loaderText);
				window.location.href = BASE_URL_ADMIN + 'pages/1';
				
			} else {
				
				loaderHide();
				btnEnabled(btnAddPageID);
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