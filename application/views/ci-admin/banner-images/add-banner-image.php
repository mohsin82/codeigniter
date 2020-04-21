<?php 
	$uri = $this->uri->segment(3);
?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Banner Images <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'banners/'); ?>">Banners</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'banner-images/'.$uri.'/'); ?>">Banners Images</a></li>
			<li class="active">Add Banner Image</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Add New Banner Image</h3>
						<?php echo BACK_BUTTON;?>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post" enctype="multipart/form-data">
									<input type="hidden" name="uri" id="uri" value="<?php echo $uri; ?>" />
								<div class="row form-group">
									<div class="col-xs-4">
										<label>
											<?php echo REQUIRED_CONSTANT; ?>Image <br/>
											<?php echo BANNER_IMAGE_SIZE_CONSTANT; ?>
										</label>
									</div>
									<div class="col-xs-8">
										<input type="file" accept="image/*" class="form-control" id="image" name="image" tabindex="1" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Title</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="title" name="title" placeholder="Title" tabindex="2" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Link</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="link" name="link" placeholder="Link" tabindex="3" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Tab</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" id="tab_status_same" name="tab_status" class="minimal" value="<?php echo SAME_TAB; ?>" checked tabindex="4" /> Same Tab &nbsp;
										<input type="radio" id="tab_status_new" name="tab_status" class="minimal" value="<?php echo NEW_TAB; ?>" tabindex="4" /> New Tab
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Status</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" id="status_active" name="status" class="minimal" value="<?php echo YES; ?>" checked tabindex="5" /> Active &nbsp;
										<input type="radio" id="status_deactive" name="status" class="minimal" value="<?php echo NO; ?>" tabindex="5" /> Deactive
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnAddBannerImage" tabindex="6" onclick="AddBannerImage();">Submit</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="7" href="<?php echo base_url(ADMIN_PATH.'banner-images/'.$uri.'/'); ?>">Cancel</a>
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

var btnAddBannerImageID = "#btnAddBannerImage";
var uriID = "#uri";
var imageID = "#image";
var titleID = "#title";
var linkID = "#link";
var tab_statusID = "input[name=tab_status]:checked";
var statusID = "input[name=status]:checked";
	
/* add banner image */
function AddBannerImage() {
	
	btnDisabled(btnAddBannerImageID);
	
		var id = $.trim($(uriID).prop("value"));
		var image = $(imageID).prop('files')[0];
		var title = $.trim($(titleID).prop("value"));
		var link = $.trim($(linkID).prop("value"));
		var tab_status = $.trim($(tab_statusID).val());
		var status = $.trim($(statusID).val());
		
		if(image == '' || image == null || image == undefined) {
		
			btnEnabled(btnAddBannerImageID);
			getFocus(imageID);
			$(errorID).removeClass(successClass);
			$(errorID).addClass(errorClass);
			$(errorID).html(selectOne);
			return false;
		}
		
			loaderShow();
		
		var form_data = new FormData();
		form_data.append('banner_id',id);
		form_data.append('image',image);
		form_data.append('title',title);
		form_data.append('link',link);
		form_data.append('tab_status',tab_status);
		form_data.append('status',status);
			
		$.ajax({
			url: BASE_URL_ADMIN + "insert-banner-image/",
			type: "POST",
			async: false,
			data: form_data,
			dataType: "json",
			cache: false,
			contentType: false,
			processData: false,
			success: function (json_response) {
				
				// alert(json_response);
				// console.log(json_response);
				
				var response = $.trim(json_response.response);
				var msg = $.trim(json_response.msg);
				if(response === "true") {
			
					$(errorID).removeClass(errorClass);
					$(errorID).addClass(successClass);
					$(errorID).html(msg);
					$(btnAddBannerImageID).html(loaderText);
					window.location.href = BASE_URL_ADMIN + "banner-images/" + id + "/";
					
				} else {
					
					loaderHide();
					btnEnabled(btnAddBannerImageID);
					$(errorID).removeClass(successClass);
					$(errorID).addClass(errorClass);
					$(errorID).html(msg);
					return false;
				}
				
			},
			error: function () {
				// alert("fail");
			}
		});
}

</script>
<!-- scripts -->