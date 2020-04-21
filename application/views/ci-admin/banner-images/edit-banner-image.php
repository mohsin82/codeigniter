<?php 
	$uri1 = $this->uri->segment(3);
	$uri2 = $this->uri->segment(4);

	$image = $edit->image;
	$title = $edit->title;
	$link_text = $edit->link_text;
	$tab_status = $edit->tab_status;
	$status = $edit->status;

?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Banner Images <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'banners/'); ?>">Banners</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'banner-images/'.$uri1.'/'); ?>">Banners Images</a></li>
			<li class="active">Edit Banner Image</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Edit Banner Image</h3>
						<?php echo BACK_BUTTON;?>
					</div>
						
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8">
							<?php echo customErrors(); ?>
							<form method="post" enctype="multipart/form-data">
									<input type="hidden" name="uri1" id="uri1" value="<?php echo $uri1; ?>" />
									<input type="hidden" name="uri2" id="uri2" value="<?php echo $uri2; ?>" />
								<div class="row form-group">
									<div class="col-xs-4">
										<label>
											<?php echo NOT_REQUIRED_CONSTANT; ?>Image <br/>
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
										<input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $title; ?>" tabindex="2" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Link</label>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" id="link" name="link" placeholder="Link" value="<?php echo $link_text; ?>" tabindex="3" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Tab</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" id="tab_status_active" name="tab_status" class="minimal" value="<?php echo SAME_TAB; ?>" <?php if($tab_status == SAME_TAB) echo 'checked'; ?> tabindex="4" /> Same Tab &nbsp;
										<input type="radio" id="tab_status_deactive" name="tab_status" class="minimal" value="<?php echo NEW_TAB; ?>" <?php if($tab_status == NEW_TAB) echo 'checked'; ?> tabindex="4" /> New Tab
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-4">
										<label><?php echo NOT_REQUIRED_CONSTANT; ?>Status</label>
									</div>
									<div class="col-xs-8">
										<input type="radio" id="status_active" name="status" class="minimal" value="<?php echo YES; ?>" <?php if($status == YES) echo 'checked'; ?> tabindex="5" /> Active &nbsp;
										<input type="radio" id="status_deactive" name="status" class="minimal" value="<?php echo NO; ?>" <?php if($status == NO) echo 'checked'; ?> tabindex="5" /> Deactive
									</div>
								</div>
								<div class="row form-group">
									<div class="col-xs-6 col-md-4">
										<button type="button" class="btn btn-primary btn-block" id="btnEditBannerImage" tabindex="6" onclick="EditBannerImage();">Save</button>
									</div>
									<div class="col-xs-6 col-md-4">
										<a class="btn btn-default btn-block" id="btnCancel" tabindex="7" href="<?php echo base_url(ADMIN_PATH.'banner-images/'.$uri1.'/'); ?>">Cancel</a>
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

var btnEditBannerImageID = "#btnEditBannerImage";
var uriID1 = "#uri1";
var uriID2 = "#uri2";
var imageID = "#image";
var titleID = "#title";
var linkID = "#link";
var tab_statusID = "input[name=tab_status]:checked";
var statusID = "input[name=status]:checked";
	
/* edit banner image */
function EditBannerImage() {
	
	btnDisabled(btnEditBannerImageID);
		
		var banner_id = $.trim($(uriID1).prop("value"));
		var id = $.trim($(uriID2).prop("value"));
		var image = $(imageID).prop('files')[0];
		var title = $.trim($(titleID).prop("value"));
		var link = $.trim($(linkID).prop("value"));
		var tab_status = $.trim($(tab_statusID).val());
		var status = $.trim($(statusID).val());
		
			loaderShow();

		var form_data = new FormData();
		form_data.append('banner_id',banner_id);
		form_data.append('id',id);
		form_data.append('image',image);
		form_data.append('title',title);
		form_data.append('link',link);
		form_data.append('tab_status',tab_status);
		form_data.append('status',status);
		
		$.ajax({
			url: BASE_URL_ADMIN + "update-banner-image/",
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
					$(btnEditBannerImageID).html(loaderText);
					window.location.href = BASE_URL_ADMIN + "banner-images/" + banner_id + "/";
					
				} else {
					
					loaderHide();
					btnEnabled(btnEditBannerImageID);
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