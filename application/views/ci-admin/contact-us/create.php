<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Contact Us <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Contact Us</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border">
						<h3 class="box-title">Contact Us List</h3>
						<div class="pull-right">
							<a role="button" class="btn btn-danger" onClick="deleteRequest();">
								<?php echo DELETE_BUTTON; ?>
							</a>
						</div>
					</div>
					
					<div class="box-body">
						<div class="col-xs-12">
							<?php echo flashErrors(); ?>
							<form method="post">
								<table id="tableContactus" class="display table-responsives" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="5%" class="text-center">
												<input type="checkbox" id="chkAll" name="chkAll" class="chkAll margin-left-right-auto" onClick="checkAll(this.checked);" />
											</th>
											<th width="10%">#</th>
											<th width="15%">Name</th>
											<th width="15%">Email</th>
											<th width="30%">Subject</th>
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
											<th width="15%">Name</th>
											<th width="15%">Email</th>
											<th width="30%">Subject</th>
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

$(document).ready(function() {
	
	tooltip();
	
	/* contact-us datatable */
	$('#tableContactus').DataTable({ 

        "processing": true,
        "serverSide": true,
        "order": [],
		"ajax": {
            "url": BASE_URL_ADMIN + "contact-us-data-list/",
            "type": "POST"
        },
		"columnDefs": [
			{ 
				"targets": [ 0,1,5,6 ],
				"orderable": false,
			},
        ],
	});
	
	/* after ajax stop */
	$(document).ajaxStop(function() {
		
		$(".chkSingle").parent().addClass('text-center');
		
		/* dropdown of limit per page on change event */
		$(".dataTables_length select").on('change', function () {
			$('input[name="chkAll"]').prop('checked', false);
		});

		/* pagination button on click event */
		$(".paginate_button").on('click', function () {
			$('input[name="chkAll"]').prop('checked', false);
		});
	});
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
			url: BASE_URL_ADMIN + "delete-contact-us/",
			type: "POST",
			async: false,
			data: form_data,
			dataType: "json",
			success: function(json_response) {
				
				// alert(response);
				// console.log(json_response);
				
				var response = $.trim(json_response.response);
				if(response === "true") {
					
					window.location.href = BASE_URL_ADMIN + "contact-us/";
					
				} else {
					
					window.location.href = BASE_URL_ADMIN + "contact-us/";
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