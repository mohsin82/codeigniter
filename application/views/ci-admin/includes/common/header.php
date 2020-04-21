<?php
	$siteDetailsData = siteDetails();
	$website_name = $siteDetailsData->website_name;
	$favicon = $siteDetailsData->favicon;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $website_name.' | '.$title; ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<?php
		if(file_exists(FAVION_IMAGE_PATH.$favicon)) {
			
			echo '<link rel="shortcut icon" href="'.base_url(FAVION_IMAGE_PATH.$favicon).'" />';
		}
	?>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(PLUGINS_PATH.'bootstrap/dist/css/bootstrap.min.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(PLUGINS_PATH.'font-awesome/css/font-awesome.min.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(PLUGINS_PATH.'dist/css/AdminLTE.min.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(PLUGINS_PATH.'Ionicons/css/ionicons.min.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(PLUGINS_PATH.'dist/css/skins/_all-skins.min.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(PLUGINS_PATH.'datatables/css/jquery.dataTables.min.css')?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(PLUGINS_PATH.'datepicker/dist/css/bootstrap-datepicker.min.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(PLUGINS_PATH.'fancybox/source/jquery.fancybox.css?v=2.1.5'); ?>" />
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH.'admin_style.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH.'admin_media_style.css'); ?>" />
	
	<script type="text/javascript" src="<?php echo base_url(PLUGINS_PATH.'jquery/dist/jquery.2.2.4.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url(PLUGINS_PATH.'bootstrap/dist/js/bootstrap.min.js'); ?>"></script>	
	<script type="text/javascript" src="<?php echo base_url(PLUGINS_PATH.'dist/js/adminlte.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url(PLUGINS_PATH.'datatables/js/jquery.dataTables.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url(PLUGINS_PATH.'datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url(PLUGINS_PATH.'fancybox/source/jquery.fancybox.pack.js?v=2.1.5'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url(PLUGINS_PATH.'ck-editor/ckeditor.js'); ?>"></script>
	
	<!-- admin path variable -->
	<script type="text/javascript"> 
		var ADMIN_PATH = "<?php echo ADMIN_PATH; ?>";
		var BASE_URL_ADMIN = "<?php echo base_url(ADMIN_PATH); ?>";
	</script>
	<!-- admin path variable -->
	
</head>
<body class="hold-transition skin-blue sidebar-mini word-break">

	<!-- loader -->
	<div class="loader">
		<?php echo LOADER; ?>
	</div>
	<!-- loader -->

	<?php require_once(APPPATH.'views/scripts.php'); ?>

<div class="wrapper">
