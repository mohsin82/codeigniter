<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Dynamic Generate Box <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Dynamic Generate Box</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Dynamic Generate Box</h3>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-lg-8">
							<div class="row form-group">
								<div class="col-xs-12">
									<?php echo NOT_REQUIRED_CONSTANT; ?>
									<div class="field_wrapper">
										<input type="text" name="field_name[]" tabindex="1" />
										<a role="button" class="add_button" title="Add field">
											<img src="<?php echo base_url(IMAGES_PATH.'icons/plus.png'); ?>" width="25px" />
										</a>
									</div>
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

$(document).ready(function(){
    
	/* icons */
	var minus_icon = BASE_URL + ICONS_PATH + 'minus.png';
	
	/* Input fields increment limitation */
	var maxField = 10;
	
	/* Add button selector */
    var addButton = $('.add_button');
	
	/* Input field wrapper */
    var wrapper = $('.field_wrapper');
	
	/* New input field html  */
    var fieldHTML = '<div><input type="text" name="field_name[]" value="" /><a role="button" class="remove_button" title="Remove field"><img src="'+minus_icon+'" width="25px" /></a></div>';
	
	/* Initial field counter is 1 */
    var x = 1;
	
	/* Once add button is clicked */
    $(addButton).click(function(){ 
        
        if(x < maxField){
            x++;
			
			/* Add field html */
            $(wrapper).append(fieldHTML);
        }
    });
	
	/* Once remove button is clicked */
    $(wrapper).on('click', '.remove_button', function(e){
        
        e.preventDefault();
		
		/* Remove field html */
        $(this).parent('div').remove();
        x--;
    });
	
});

</script>
<!-- scripts -->