<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Import <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Import</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Import</h3>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8">
							<div class="row form-group">
								<div class="col-xs-12">
									<a class="btn btn-primary" href="<?php echo base_url(SAMPLE_EXCEL_PATH); ?>" download>Download Sample File</a>
								</div>
							</div>
							<br/>
							<?php echo customErrors(); ?>
							<div class="row form-group">
								<div class="col-xs-4">
									<label>
										<?php echo NOT_REQUIRED_CONSTANT; ?>File <br/>
										<?php echo EXCEL_ONLY_CONSTANT; ?>
									</label>
								</div>
								<div class="col-xs-8">
									<input type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control" id="file" name="file" tabindex="1" />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-6 col-md-4">
									<button type="button" class="btn btn-primary btn-block" id="btnImportFile" tabindex="2" onclick="importFile();">Submit</button>
								</div>
								<div class="col-xs-6 col-md-4">
									<a class="btn btn-default btn-block" id="btnCancel" tabindex="3" href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Cancel</a>
								</div>
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

var btnImportFileID = "#btnImportFile";
var fileID = "#file";

/* import file */
function importFile() {
	
	btnDisabled(btnImportFileID);
	
		var fileName = $(fileID).prop("files")[0];
		
		if(fileName == '' || fileName == null || fileName == undefined) {
			
			btnEnabled(btnImportFileID);
			getFocus(fileID);
			$(errorID).removeClass(successClass);
			$(errorID).addClass(errorClass);
			$(errorID).html("File" + isRequired);
			return false;
		}

		loaderShow();
	
		var form_data = new FormData();
		form_data.append('fileName',fileName);
			
		$.ajax({
			url: BASE_URL_ADMIN + "insert-import-file/",
			type: "POST",
			async: false,
			data: form_data,
			dataType: "json",
			cache: false,
			contentType: false,
			processData: false,
			success: function(json_response) {
			
				// alert(json_response);
				// console.log(json_response);
				
				var response = $.trim(json_response.response);
				var msg = $.trim(json_response.msg);
				if(response === "true") {
			
					$(errorID).removeClass(errorClass);
					$(errorID).addClass(successClass);
					$(errorID).html(msg);
					$(btnImportFileID).html(loaderText);
					window.location.href = BASE_URL_ADMIN + 'dashboard/';
					
				} else {
					
					loaderHide();
					btnEnabled(btnImportFileID);
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