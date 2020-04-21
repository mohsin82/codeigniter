<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Newsletter Content<small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Newsletter Content</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border">
						<h3 class="box-title">Newsletter Content List</h3>
						<div class="pull-right">
							<a href="<?php echo base_url(ADMIN_PATH."add-newsletter-content/"); ?>" class="btn btn-primary">
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
								<table id="tableNewsletterContent" class="table table-bordered" cellpadding="10" width="100%">
									<thead>
										<tr>
											<th width="5%" class="text-center">
												<input type="checkbox" id="chkAll" name="chkAll" class="chkAll margin-left-right-auto" onClick="checkAll(this.checked);" />
											</th>
											<th width="10%">#</th>
											<th width="25%">Title</th>
											<th width="35%">Description</th>
											<th width="10%">Status</th>
											<th width="15%">Action</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
									<tfoot>
										<tr>
											<th width="5%" class="text-center">
												<input type="checkbox" id="chkAll" name="chkAll" class="chkAll margin-left-right-auto" onClick="checkAll(this.checked);" />
											</th>
											<th width="10%">#</th>
											<th width="25%">Title</th>
											<th width="35%">Description</th>
											<th width="10%">Status</th>
											<th width="15%">Action</th>
										</tr>
									</tfoot>
								</table>
							</form>
							<div id="pagination_link" class="pull-right"></div>
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
	
	/* after ajax stop */
	$(document).ajaxStop(function() {
		
		$(".pagination li a").on('click', function () {
			$('input[name="chkAll"]').prop('checked', false);
		});
	});

	/* call ajax pagination on load of page */
	load_more_data(1);

	/* ajax pagination on click */
	$(document).on("click", ".pagination li a", function(event) {
	
		event.preventDefault();
		
		var current_page = $(this).data("ci-pagination-current-page");
		var page = $(this).data("ci-pagination-page");

		if(current_page != page) {

			load_more_data(page);
		}
	});

});

/* ajax pagination function */
function load_more_data(page) {

	$.ajax({
		url: BASE_URL_ADMIN + "get-newsletter-content-data/" + page + '/',
		type: "GET",
		async: false,
		dataType: "json",
		success: function(json_response) {
			
			// alert(json_response);
			//console.log(json_response);

			var response = json_response.response;
			if(response == true) {

				var total_rows = json_response.total_rows;
				var main_data = $.trim(json_response.main_data);
				var pagination_links = json_response.pagination_links;		
				
				$("#tableNewsletterContent tbody").html(main_data);
				$("#pagination_link").html(pagination_links);
			}
		},
		error: function() {
			// alert("fail");
		} 
	});
}

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
			url: BASE_URL_ADMIN + "delete-newsletter-content/",
			type: "POST",
			async: false,
			data: form_data,
			dataType: "json",
			success: function(json_response) {
				
				// alert(response);
				// console.log(json_response);
				
				var response = $.trim(json_response.response);
				if(response === "true") {
					
					window.location.href = BASE_URL_ADMIN + "newsletter-content/";
					
				} else {
					
					window.location.href = BASE_URL_ADMIN + "newsletter-content/";
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