<?php 
	$banner_id = $this->uri->segment(3);
?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Banner Images <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li><a href="<?php echo base_url(ADMIN_PATH.'banners/'); ?>">Banners</a></li>
			<li class="active">Banner Images</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border">
						<h3 class="box-title">Banner Image List</h3>
						<div class="pull-right">
							<a href="<?php echo base_url(ADMIN_PATH."add-banner-image/$banner_id/"); ?>" class="btn btn-primary">
								<?php echo ADD_NEW_BUTTON; ?>
							</a>
							<a role="button" class="btn btn-danger" onClick="deleteRequest();">
								<?php echo DELETE_BUTTON; ?>
							</a>
						</div>
					</div>

					<div class="box-body">
						<div class="col-xs-12">
								<input type="hidden" id="banner_id" value="<?php echo $banner_id; ?>" />
							<?php echo flashErrors(); ?>
							<form method="post">
								<table id="tableBannerImages" class="display table-responsives table table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="5%" class="text-center">
												<input type="checkbox" id="chkAll" name="chkAll" class="chkAll margin-left-right-auto" onClick="checkAll(this.checked);" />
											</th>
											<th width="5%">#</th>
											<th width="20%">Image</th>
											<th width="20%">Title</th>
											<th width="25%">Link</th>
											<th width="10%">Status</th>
											<th width="15%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no = 0;
											if(!empty($banner_images)) {
												
												foreach($banner_images as $row) {
													$no++;
													
													$id = $row->banner_image_id;
													$image = $row->image;
													$title = $row->title;
													$link_text = $row->link_text;
													$tab_status = $row->tab_status;
													$status = $row->status;
										?>
												
												<tr>
													<td class="text-center">
														<?php
															$checkbox = '<input type="checkbox" id="chkSingle_'.$id.'" name="chkSingle[]" class="chkSingle margin-left-right-auto" data-id="'.$id.'" onClick="checkSingle(this.checked);" />';

															echo $checkbox;
														?>
													</td>
													<td><?php echo $no; ?></td>
													<td>
														<?php
															if(file_exists(BANNER_IMAGE_THUMB_PATH.$image)) {
														
																echo '<a class="thumb" data-fancybox-group="gallery" href="'.base_url(BANNER_IMAGE_PATH.$image).'" >'.
																		'<img src="'.base_url(BANNER_IMAGE_THUMB_PATH.$image).'" class="thumbnail" alt="banner-image" width="80px" height="60px" />'.
																	'</a>';
																
															} else {
																
																echo '<img src="'.base_url(NO_IMAGE_THUMB_PATH).'" class="thumbnail" alt="banner-image" width="80px" height="60px" />';
															}
														?>
													</td>
													<td>
														<?php echo $title; ?>
													</td>
													<td>
														<a href="<?php echo $link_text; ?>" target="_blank">
															<?php echo $link_text; ?>
														</a>
													</td>
													<td>
														<?php 
															if($status == YES) {
																
																$deactivate_url = base_url(ADMIN_PATH."change-status-banner-image/$banner_id/".$id."/".NO."/");
																$status_img = '<span data-toggle="modal" data-target="#wrongModal_'.$id.'">
																					<a role="button" data-tooltip="tooltip" data-placement="top" title="Activate">'.DEACTIVATE_ICON.'</a>
																				</span>
																				<div id="wrongModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="wrongModalLabel" aria-hidden="true">
																					<div class="modal-dialog" role="document">
																						<div class="modal-content">
																							<div class="modal-header">
																								<h5 class="modal-title" id="wrongModalLabel">Are you sure want to Deactivate Banner Image?</h5>
																								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																									<span aria-hidden="true">&times;</span>
																								</button>
																							</div>
																							<div class="modal-footer">
																								<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
																								<a href="'.$deactivate_url.'" class="btn btn-danger">Deactivate</a>
																							</div>
																						</div>
																					</div>
																				</div>';
																
															} else {
																
																$activate_url = base_url(ADMIN_PATH."change-status-banner-image/$banner_id/".$id."/".YES."/");
																$status_img = '<span data-toggle="modal" data-target="#rightModal_'.$id.'">
																					<a role="button" data-tooltip="tooltip" data-placement="top" title="Deactivate">'.ACTIVATE_ICON.'</a>
																				</span>
																				<div id="rightModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rightModalLabel" aria-hidden="true">
																					<div class="modal-dialog" role="document">
																						<div class="modal-content">
																							<div class="modal-header">
																								<h5 class="modal-title" id="rightModalLabel">Are you sure want to Activate Banner Image?</h5>
																								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																									<span aria-hidden="true">&times;</span>
																								</button>
																							</div>
																							<div class="modal-footer">
																								<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
																								<a href="'.$activate_url.'" class="btn btn-primary">Activate</a>
																							</div>
																						</div>
																					</div>
																				</div>';
															}
																
																echo $status_img;
														?>
													</td>
													<td>
														<?php
															$edit_url = base_url(ADMIN_PATH."edit-banner-image/$banner_id/".$id."/");
														?>
														<a href="<?php echo $edit_url; ?>" data-tooltip="tooltip" title="Edit"><?php echo EDIT_ICON; ?></a>
													</td>
												</tr>
										<?php
												}
											
											} else {
										?>
												<tr>
													<td class="text-center" colspan="5">No data available in table</td>
												</tr>	
										<?php
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<th width="5%" class="text-center">
												<input type="checkbox" id="chkAll" name="chkAll" class="chkAll margin-left-right-auto" onClick="checkAll(this.checked);" />
											</th>
											<th width="5%">#</th>
											<th width="20%">Image</th>
											<th width="20%">Title</th>
											<th width="25%">Link</th>
											<th width="10%">Status</th>
											<th width="15%">Action</th>
										</tr>
									</tfoot>
								</table>
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

var tableBannerImagesID = "#tableBannerImages";

$(document).ready(function() {
	
	tooltip();
	
	$('.thumb').fancybox();

});

/* multiple delete function */
function deleteData() {
	
	btnDisabled(btnDeleteID);
	loaderShow();
	btnConfirmBoxCancel();
	
	var favorite = [];
	$.each($("input[name='chkSingle[]']:checked"), function() {            
		favorite.push($(this).data('id'));
	});
		
	var ids = favorite.join(",");
		
	if(ids == '' || ids == null) {
		
		$("#deleteAlertModal").modal('show');
		return false;
	
	} else {
		
		var get_banner_id = $("#banner_id").prop("value");
		var form_data = {
			'banner_id': get_banner_id,
			'ids': ids
		};

		$.ajax({
			url: BASE_URL_ADMIN + "delete-banner-image/",
			type: "POST",
			async: false,
			data: form_data,
			dataType: "json",
			success: function(json_response) {
				
				// alert(response);
				// console.log(json_response);
				
				var banner_id = $.trim(json_response.banner_id);
				var response = $.trim(json_response.response);
				if(response === "true") {
					
					window.location.href = BASE_URL_ADMIN + "banner-images/"+banner_id+"/";
					
				} else {
					
					window.location.href = BASE_URL_ADMIN + "banner-images/"+banner_id+"/";
				}
			
			},
			error: function() {
				// alert("fail");
			} 
		});
	}
}
</script>
<!-- scripts -->