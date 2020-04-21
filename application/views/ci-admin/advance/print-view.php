<!-- content -->
<div class="content-wrapper">

	<section class="content-header">
		<h1>Print View <small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(ADMIN_PATH.'dashboard/'); ?>">Home</a></li>
			<li class="active">Print View</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					
					<div class="box-header with-border margin-left-right-5px">
						<div class="row">
							<div class="col-md-6">
								<h3 class="box-title">Print View</h3>
							</div>
							<div class="col-md-6">
								<div class="pull-right">
									<button type="button" class="btn btn-primary" id="btnPrintView" onclick="printViewPage();">Print</button>
								</div>	
							</div>
						</div>
					</div>
						
					<div class="box-body margin-left-right-15px">
						<div class="col-xs-12">
							<div id="printCss">
								<table id="tableNewsletterUser" class="display table table-bordered table-responsives" cellspacing="5" width="100%" border="1">
									<thead>
										<tr>
											<td width="10%"><b>#</b></td>
											<td width="90%"></b>Email</b></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>test@gmail.com</td>
										</tr>
									</tbody>
								</table>
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

var btnPrintViewID = "#btnPrintView";
var printCssID = "#printCss";

/* print view */	
function printViewPage() {

    return false;
}

</script>
<!-- scripts -->