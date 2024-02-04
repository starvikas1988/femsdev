<?php 

/*---------------------------------------------------------------------------------------

Check The current URL and moniter the links,

If the session is on then a user can jump between the three dashboards irrespective of the 
session he is logged in. In order to stop that the below is written, which will check the change 
in URL and and search for admin, agent and coach keywords present in the url. Then based on the 
keywords will assign a 404 error page. 

----------------------------------------------------------------------------------------*/
is_valid_session_url();

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	
	<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	?>
	<title><?php echo APP_TITLE;?></title>
	<meta name="description" content="Fems Loader/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
<style>
	
	.pageLoader {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url("<?php echo base_url(); ?>assets/images/loader.gif") 50% 50% no-repeat rgb(249,249,249);
		opacity: .8;
}

</style>

<!-- <script src="<?php //echo base_url() ?>libs/bower/jquery/dist/jquery.js"></script> -->
	<script src="<?php echo base_url() ?>libs/jquery/jquery-3.5.1.js"></script>
	
<script type="text/javascript">
$(window).load(function() {
    $(".pageLoader").fadeOut("slow");
});
</script>

</head>
	
<body>
	<div class="pageLoader"></div>

</body>