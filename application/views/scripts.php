<!-- alert box modal -->
<div id="deleteAlertModal" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLabel">Please select any Record</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<a role="button" class="btn btn-primary ok_button_width" data-dismiss="modal">OK</a>
			</div>
		</div>
	</div>
</div>
<!-- alert box modal -->

<!-- confirm box modal -->
<div id="deleteConfirmModal" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLabel">Are you sure want to Delete Selected Record?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
				<a role="button" class="btn btn-danger" id="btnDelete" onClick="deleteData();">Delete</a>
			</div>
		</div>
	</div>
</div>
<!-- confirm box modal -->

<!-- common and constant scripts -->
<script type="text/javascript">

$(window).load(function() {
	loaderHide();
});

$(window).unload(function() {
	loaderShow();
});

var BASE_URL = "<?php echo base_url(); ?>";
var NO_IMAGE_THUMB_PATH = "<?php echo NO_IMAGE_THUMB_PATH; ?>";
var ICONS_PATH = "<?php echo IMAGES_PATH.'icons/'; ?>";

var yes = "<?php echo YES; ?>";
var no = "<?php echo NO; ?>";

var loaderText = "<?php echo LOADER_TEXT; ?>";

var errorID = "#error-msg";
var errorClass = "alert alert-danger alert-dismissible";
var successClass = "alert alert-success alert-dismissible";

var isRequired = "<?php echo IS_REQUIRED; ?>";
var notSame = "<?php echo NOT_SAME; ?>";
var doNotEnterSpecialOrSpaceCharecters = "<?php echo NOT_SPECIAL_CHARECTER_OR_SPACE; ?>";
var doNotEnterSpecialCharecters = "<?php echo NOT_SPECIAL_CHARECTER; ?>";
var validEmail = "<?php echo NOT_VALID_EMAIL; ?>";
var validPhone = "<?php echo NOT_VALID_PHONE; ?>";
var alreadyExists = "<?php echo ALREADY_EXIST; ?>";
var validNumberOfCharecters = "<?php echo NOT_VALID_NUMBER_OF_CHARECTER; ?>";
var onlyAlphabtes = "<?php echo ONLY_ALPHA; ?>";
var onlyAlphabtesAndSpace = "<?php echo ONLY_ALPHA_AND_SPACE; ?>";
var errorImage = "<?php echo ERROR_IMAGE; ?>";
var errorExcel = "<?php echo ERROR_EXCEL; ?>";
var selectOne = "<?php echo SELECT_ONE; ?>";
var validExtension = "<?php echo VALID_EXTENSION; ?>";
var validExtensionExcel = "<?php echo VALID_EXTENSION_EXCEL; ?>";
var notEmailExists = "<?php echo NOT_EMAIL_EXIST; ?>";
var tryAgainLater = "<?php echo TRY_AGAIN_LATER; ?>";

var countryID = "#country_id";
var stateID = "#state_id";
var cityID = "#city_id";

var btnDeleteID = "#btnDelete";

/* show loader */
function loaderShow() {
	
	$('.loader').fadeIn(1000);
}

/* hide loader */
function loaderHide() {
	
	$('.loader').fadeOut(1000);
}

/* btn disabled */
function btnDisabled(btnID) {
	
	$(btnID).attr('disabled', true);
	return true;
}

/* btn enabled */
function btnEnabled(btnID) {
	
	$(btnID).attr('disabled', false);
	return true;
}

/* get focus */
function getFocus(fieldID) {
	
	$(fieldID).focus();
	return true;
}

/* tooltip */
function tooltip() {
	
	$("body").tooltip({ selector: '[data-tooltip=tooltip]' });
}

/* tooltip */
function goBack() {
	
	history.go(-1);
}

/* state list */
function getStateList() {
	
	var country_id = $.trim($(countryID).prop("value"));
	
	if(country_id == '0') {

		btnDisabled(stateID);
		btnDisabled(cityID);
		$(stateID).html("<option value='0'>Select State</option>");
		$(cityID).html("<option value='0'>Select City</option>");
		getFocus(countryID);
		return false;
	}
	
	var form_data = {
		'country_id': country_id
	};
	
	$.ajax({
		url: BASE_URL + "get-states",
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
		
				btnEnabled(stateID);
				btnDisabled(cityID);
				$(cityID).html("<option value='0'>Select City</option>");
				$(stateID).html(msg);
				return false;

			} else {
				
				btnDisabled(stateID);
				btnDisabled(cityID);
				$(stateID).html("<option value='0'>Select State</option>");
				$(cityID).html("<option value='0'>Select City</option>");
				getFocus(countryID);
				return false;
			}
				
		},
		error: function() {
			// alert("fail");
		}
    });
}

/* city list */
function getCityList() {
	
	var state_id = $.trim($(stateID).prop("value"));
	
	if(state_id == '0') {

		btnDisabled(cityID);
		$(cityID).html("<option value='0'>Select City</option>");
		getFocus(stateID);
		return false;
	}
	
	var form_data = {
		'state_id': state_id
	};
	
	$.ajax({
		url: BASE_URL + "get-cities",
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
		
				btnEnabled(cityID);
				$(cityID).html(msg);
				return false;

			} else {
				
				btnDisabled(cityID);				
				$(cityID).html("<option value='0'>Select City</option>");
				getFocus(stateID);
				return false;
			}
			
		},
		error: function() {
			// alert("fail");
		}
    });
}

/* ------------------------------------------------------------------------------------------------------------- */

/* check and uncheck single button */
function checkSingle(isChecked) {
	
	if(isChecked === true) {
		
		$(this).prop("checked", true);

		var checkbox_length = $('.chkSingle').length;
		var checkbox_checked_length = $('.chkSingle:checked').length;
		if(checkbox_length == checkbox_checked_length) {
			$('.chkAll').prop('checked', true);
		}
	    
	} else {
		
		$(this).prop("checked", false);
		$('.chkAll').prop('checked', false);
	}
}


/* check all and uncheck all */
function checkAll(isChecked) {
	
	if(isChecked === true) {
		
		$('.chkSingle').prop('checked', true);
		$('.chkAll').prop('checked', true);
	
	} else {
		
		$('.chkSingle').prop('checked', false);
		$('.chkAll').prop('checked', false);
	}
}

/* multiple delete request function */
function deleteRequest() {
	
	var favorite = [];
	$.each($(".chkSingle:checked"), function() {            
		favorite.push($(this).data('id'));
	});
		
	var ids = favorite.join(",");
	if(ids == '' || ids == null) {
		
		$("#deleteAlertModal").modal('show');
		return false;
	
	} else {
		
		$("#deleteConfirmModal").modal('show');
	}
}

/* alert box close */
function btnAlertBoxCancel() {
	
	$("#deleteAlertModal").modal('hide');
}

/* confirm box of multiple delete */
function btnConfirmBoxCancel() {
	
	$("#deleteConfirmModal").modal('hide');
}

</script>
<!-- common and constant scripts -->