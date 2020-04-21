<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Export <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Export</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<h3 class="box-title">Export</h3>
					</div>
					
					<div class="box-body margin-left-right-15px">
						<div class="col-xs-12">
							<a href="<?php echo base_url(ADMIN_PATH.'export-pdf/'); ?>" class="btn btn-primary" target="_blank">Download TCPDF</a>
							<a href="<?php echo base_url(ADMIN_PATH.'export-excel/'); ?>" class="btn btn-primary" target="_blank">Download Excel</a>
							<a href="<?php echo base_url(ADMIN_PATH.'export-word/'); ?>" class="btn btn-primary" target="_blank">Download Word</a>
							<a href="<?php echo base_url(ADMIN_PATH.'export-zip/'); ?>" class="btn btn-primary" target="_blank">Download Zip</a>
						</div>					
					</div>

				</div>
         		</div>			
		</div>
	</section>
	
</div>
<!-- content -->