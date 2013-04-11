<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $meta_title; ?> - MEDNET</title>
	<meta charset="UTF-8">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap.min.css'); ?>">
	<script type="text/javascript" src="<?php echo site_url('js/bootstrap.min.js'); ?>"></script>
	<!-- /Bootstrap -->
	<link rel="stylesheet" href="<?php echo site_url('css/global.css'); ?>">
	<?php if ($is_admin): ?>
	<link rel="stylesheet" href="<?php echo site_url('css/admin.css'); ?>">
	<!-- Datepicker -->
	<link rel="stylesheet" href="<?php echo site_url('css/datepicker.css'); ?>">
	<script type="text/javascript" src="<?php echo site_url('js/bootstrap-datepicker.js'); ?>"></script>
	<!-- /Datepicker -->
	<!-- TinyMCE -->
	<script type="text/javascript" src="<?php echo site_url('js/tiny_mce/tiny_mce.js'); ?>"></script>
	<script type="text/javascript">
		tinyMCE.init({
			// General options
			mode : "textareas",
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontsizeselect,forecolor",
			theme_advanced_buttons2 : "bullist,numlist,|,link,unlink,anchor,image,code,|,charmap,|,search,replace,|,preview,fullscreen,help",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
		});
	</script>
	<!-- /TinyMCE -->
	<!-- Chosen plugin -->
	<script type="text/javascript" src="<?php echo site_url('js/chosen.jquery.min.js'); ?>"></script>
	<link rel="stylesheet" href="<?php echo site_url('css/chosen.css'); ?>">
	<!-- /Chosen plugin -->
	<link rel="stylesheet" href="<?php echo site_url('css/admin_styles.css'); ?>">
	<script type="text/javascript" src="<?php echo site_url('js/admin_scripts.js'); ?>"></script>
	<?php ENDIF; ?>
</head>