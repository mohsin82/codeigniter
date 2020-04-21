<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Newsletter User <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Newsletter User </li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border">
						<div class="row">
							<div class="col-xs-12">
								<h3 class="box-title">Newsletter User List</h3>
								<div class="pull-right">
									<div class="pull-right">
										<a href="<?php echo base_url(ADMIN_PATH."add-newsletter-user/"); ?>" class="btn btn-primary">
											<?php echo ADD_NEW_BUTTON; ?>
										</a>
										<a role="button" class="btn btn-danger" onClick="deleteRequest();">
											<?php echo DELETE_BUTTON; ?>
										</a>
									</div>
								</div>	
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-md-8">
								<form id="filterNewsletterUserForm" method="get" action="<?php echo base_url(ADMIN_PATH."newsletter-users"); ?>">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<div class="input-group">
													<input type="text" id="fromDate" name="fromDate" class="form-control" placeholder="From Date" value="<?php if($fromDate != "0") { echo $fromDate; } ?>" />
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<div class="input-group">
													<input type="text" id="toDate" name="toDate" class="form-control" placeholder="To Date" value="<?php if($toDate != "0") { echo $toDate; } ?>"  />
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<button type="button" id="btnFilterNewsletterUser" class="btn btn-primary btn-block" onclick="FilterNewsletterUser();">Filter</button>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<?php if($fromDate != "0" && $toDate != "0") { ?>
													<a href="<?php echo base_url(ADMIN_PATH."newsletter-users/"); ?>" class="btn btn-default btn-block">Clear</a>
												<?php } ?>
											</div>
										</div>
									</div>	
								</form>
							</div>
						</div> 
					</div>
						
					<div class="box-body">
						<div class="col-xs-12">
							<?php echo flashErrors(); ?>
							<form method="post">
								<table id="tableNewsletterUser" class="display table-responsives" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="5%" class="text-center">
												<input type="checkbox" id="chkAll" name="chkAll" class="chkAll margin-left-right-auto" onClick="checkAll(this.checked);" />
											</th>
											<th width="10%">#</th>
											<th width="60%">Email</th>
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
											<th width="60%">Email</th>
											<th width="10%">Status</th>
											<th width="15%">Action</th>
										</tr>
									</tfoot>
								</table>
							</form>
							<!-- alert box modal -->
							<div id="alertModal" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="filterModalLabel">Please select From Date and To Date</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="btnAlertBoxCancel();">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-footer">
											<a role="button" class="btn btn-primary" onClick="btnAlertBoxCancel();">OK</a>
										</div>
									</div>
								</div>
							</div>
							<!-- alert box modal -->
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
	
	var fromDate = "<?php echo $fromDate; ?>";
	var toDate = "<?php echo $toDate; ?>";

	/* newsletter user datatable */
	$('#tableNewsletterUser').DataTable({ 

        "processing": true,
        "serverSide": true,
        "order": [],
		"ajax": {
            "url": BASE_URL_ADMIN + "newsletter-user-data-list/" + fromDate + "/" + toDate + "/",
            "type": "POST"
        },
		"columnDefs": [
			{ 
				"targets": [ 0,1,3,4 ],
				"orderable": false,
			},
        ],
	});
	
	/* from date */
	$("#fromDate").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: 1,
        //startDate: new Date(),
        todayHighlight: true,
        //endDate: new Date()
    	}).on('changeDate', function (selected) {
        
		var date = new Date(selected.date.valueOf());
		var secondsOfOneDay = 86400000;
		var minDate = new Date(date.getTime() + secondsOfOneDay);
		$('#toDate').datepicker('setStartDate', minDate);
		$(this).datepicker('hide');
	});

	/* to date */
	$("#toDate").datepicker({
		format: 'dd-mm-yyyy',
		todayHighlight: true,
        //endDate: new Date()
	}).on('changeDate', function (selected) {
        
		var date = new Date(selected.date.valueOf());
		var secondsOfOneDay = 86400000;
		var maxDate = new Date(date.getTime() - secondsOfOneDay);
		$('#fromDate').datepicker('setEndDate', maxDate);
		$(this).datepicker('hide');
	});

	/* filter datewise */

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

var alertModalID = "#alertModal";

var formID = "#filterNewsletterUserForm";
var btnFilterNewsletterUserID = "#btnFilterNewsletterUser";
var fromDateID = "#fromDate";
var toDateID = "#toDate";

/* alert box of close */
function btnAlertBoxCancel() {
	
	$(alertModalID).removeClass('in');
	$(alertModalID).css({"display":"none","padding-right":"17px"});
}

function FilterNewsletterUser() {

	btnDisabled(btnFilterNewsletterUserID);
	
	var fromDate = $.trim($(fromDateID).prop("value"));
	var toDate = $.trim($(toDateID).prop("value"));

	if(fromDate == '' || fromDate == null || toDate == '' || toDate == null) {
		
		$(alertModalID).addClass('in');
		$(alertModalID).css({"display":"block","padding-right":"17px"});
		btnEnabled(btnFilterNewsletterUserID);
		return false;
	}

	$(formID).submit();
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
			url: BASE_URL_ADMIN + "delete-newsletter-user/",
			type: "POST",
			async: false,
			data: form_data,
			dataType: "json",
			success: function(json_response) {
				
				// alert(response);
				// console.log(json_response);
				
				var response = $.trim(json_response.response);
				if(response === "true") {
					
					window.location.href = BASE_URL_ADMIN + "newsletter-users/";
					
				} else {
					
					window.location.href = BASE_URL_ADMIN + "newsletter-users/";
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