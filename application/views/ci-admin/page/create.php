<?php
	$uri = $this->uri->segment(3);
?>

<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Page <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Pages</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">		
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border">
						<h3 class="box-title">Page List</h3>
						<div class="pull-right">
							<a href="<?php echo base_url(ADMIN_PATH."add-page/"); ?>" class="btn btn-primary">
								<?php echo ADD_NEW_BUTTON; ?>
							</a>
							<a role="button" class="btn btn-danger" onClick="deleteRequest();">
								<?php echo DELETE_BUTTON; ?>
							</a>
						</div>
					</div>
					
					<div class="box-body">
						<div class="col-xs-12">
							<?php echo flashErrors(); ?>
							<form method="post">
								<table id="tablePage" class="table table-bordered" cellpadding="10" width="100%">
									<thead>
										<tr>
											<th width="5%" class="text-center">
												<input type="checkbox" id="chkAll" name="chkAll" class="chkAll margin-left-right-auto" onClick="checkAll(this.checked);" />
											</th>
											<th width="5%">#</th>
											<th width="20%">Title</th>
											<th width="45%">Description</th>
											<th width="10%">Status</th>
											<th width="15%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$i = 0;
											if(!empty($pages)) {
												
												foreach($pages as $row) {
													
													$i++;
													
													$no = (($uri * $per_page) - $per_page) + $i;
													
													$id = $row->page_id;
													$page_title = $row->page_title;
													$page_desc = $row->page_description;
													$page_description = '';
													if(strlen($page_desc) > 100) {
																
														$page_description = substr($page_desc,0,100).'...';
													
													} else {
														
														$page_description = $page_desc;
													}
													$status = $row->status;
										?>

												<tr>
													<td class="text-center">
														<input type="checkbox" id="chkSingle_<?php echo $id; ?>" name="chkSingle[]" class="chkSingle margin-left-right-auto" data-id="<?php echo $id; ?>" onClick="checkSingle(this.checked);" />
													</td>
													<td><?php echo $no; ?></td>
													<td><?php echo $page_title; ?></td>
													<td><?php echo $page_description; ?></td>
													<td>
														<?php 
															$status_img = '';
															if($status == YES) {
																
																$deactivate_url = base_url(ADMIN_PATH.'change-status-page/'.$id.'/'.NO.'/'.$uri.'/');
																$status_img = '<span data-toggle="modal" data-target="#wrongModal_'.$id.'">
																					<a role="button" data-tooltip="tooltip" data-placement="top" title="Activate">'.DEACTIVATE_ICON.'</a>
																				</span>
																				<div id="wrongModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="wrongModalLabel" aria-hidden="true">
																					<div class="modal-dialog" role="document">
																						<div class="modal-content">
																							<div class="modal-header">
																								<h5 class="modal-title" id="wrongModalLabel">Are you sure want to Deactivate Page?</h5>
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
																
																$activate_url = base_url(ADMIN_PATH.'change-status-page/'.$id.'/'.YES.'/'.$uri.'/');
																$status_img = '<span data-toggle="modal" data-target="#rightModal_'.$id.'">
																					<a role="button" data-tooltip="tooltip" data-placement="top" title="Deactivate">'.ACTIVATE_ICON.'</a>
																				</span>
																				<div id="rightModal_'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rightModalLabel" aria-hidden="true">
																					<div class="modal-dialog" role="document">
																						<div class="modal-content">
																							<div class="modal-header">
																								<h5 class="modal-title" id="rightModalLabel">Are you sure want to Activate Page?</h5>
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

															$edit_url = base_url(ADMIN_PATH."edit-page/".$id."/");
															$view_url = base_url(ADMIN_PATH."view-page/".$id."/");

														?>
														
														<a href="<?php echo $edit_url; ?>" data-tooltip="tooltip" title="Edit"><?php echo EDIT_ICON; ?></a>
														
														<a href="<?php echo $view_url; ?>" data-tooltip="tooltip" title="View"><?php echo VIEW_ICON; ?></a>
														
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
											<th width="20%">Title</th>
											<th width="45%">Description</th>
											<th width="10%">Status</th>
											<th width="15%">Action</th>
										</tr>
									</tfoot>
								</table>
							</form>
							<div class="pull-right">
								<?php
									if(isset($links)) {
										echo $links;
									}
								?>
							</div>
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

$(document).ready(function() {
	
	tooltip();
	
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

		var form_data = {
			'ids': ids
		};

		$.ajax({
			url: BASE_URL_ADMIN + "delete-page/",
			type: "POST",
			async: false,
			data: form_data,
			dataType: "json",
			success: function(json_response) {
				
				// alert(response);
				// console.log(json_response);

				var response = $.trim(json_response.response);
				if(response === "true") {
					
					window.location.href = BASE_URL_ADMIN + "pages/1";
					
				} else {
					
					window.location.href = BASE_URL_ADMIN + "pages/1";
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