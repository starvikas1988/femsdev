<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title><?php echo hth_title(!empty($page_title) ? $page_title : ""); ?></title>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/harhith/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/harhith/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/harhith/css/custom.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.min.css">
	<?php if(!empty($is_show_table) && $is_show_table == 1){ ?>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/harhith/datatable/jquery.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/harhith/datatable/buttons.dataTables.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<?php } ?>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/harhith/css/metisMenu.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">   
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">
	<style>
	.submenu li.active > a, .submenu li.active {
		color: #fff;
		background-color: #6a350e!important;
	}
	.submenu li {
		padding-left: 20px;
	}
	</style>
</head>

<body>

<div id="page-container">
	
   <?php $this->load->view('harhith/top'); ?>   
   <?php $this->load->view('harhith/menu'); ?>
   
    <div class="main-content page-content">
        <div class="main-content-inner">
		
			
        <?php $this->load->view('harhith/'.$content_template); ?>
			
		
    </div>
	</div>
    <footer>
        <div class="footer-area">
			<div style="float:right;display:inline">
			<a onclick="window.history.back();" class="bg-primary text-white" style="cursor:pointer;padding: 5px 20px;border-radius: 20px;"><i class="fa fa-arrow-left"></i> Go Back</a>
			<a onclick="scrollTopAnimated()" class="bg-warning text-white" style="cursor:pointer;padding: 5px 20px;border-radius: 20px;"><i class="fa fa-arrow-up"></i> Go to Top</a>
			</div>
            <p>&copy; Copyright <?php echo date('Y'); ?>. All right reserved.			
			</p>
        </div>
    </footer>    
</div>


<script src="<?php echo base_url() ?>assets/harhith/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/js/jquery.inputmask.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/js/metisMenu.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/js/main.js"></script>
<script>
function scrollTopAnimated() {
	$("html, body").animate({ scrollTop: "0" });
}
</script>

<?php
if(isset($content_js) && !empty($content_js))
{
	if(is_array($content_js))
	{
		foreach($content_js as $key=>$script_url)
		{
			if(!preg_match("/.php/", $script_url))
			{
				if(preg_match("/\Ahttp/", $script_url))
				{
					echo '<script src="'.$script_url.'"></script>';
				}
				else
				{
					echo '<script src="'. base_url('application/views/jscripts/'.$script_url).'"></script>';
				}
			}
			else
			{
				$this->load->view('jscripts/'.$script_url);
			}
		}
	}
	else
	{
		if(!preg_match("/.php/", $content_js))
		{
			if(preg_match("/\Ahttp/", $content_js))
			{
				echo '<script src="'.$content_js.'"></script>';
			}
			else
			{
				echo '<script src="'. base_url('application/views/jscripts/'.$content_js).'"></script>';
			}
		}
		else
		{
			$this->load->view('jscripts/'.$content_js);
		}
	}
}
?>
	
</body>
</html>