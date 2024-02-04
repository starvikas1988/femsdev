<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Mckinsey Crm</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/custom.css">    
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/metisMenu.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">   
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/buttons.bootstrap5.min.css">
	
	<style>
		.footer-new {
			position:fixed;
		}
		.dt-buttons {
			margin: 22px 0 0 0;
		}
	</style>
	
</head>

<body>

<div id="page-container">
    <div class="header-area">
        <div class="header-area-left">
            <a href="<?php echo base_url() ?>/home" class="logo">
                <img src="<?php echo base_url() ?>assets/mckinsey/images/logo.png" class="logo" alt="">
            </a>
        </div>		
        <div class="row align-items-center header_right">           
               <?php include('menu.php');?>  
            
            </div>            
        </div>

    </div>
   
    <div class="main-content page-content">
        <div class="main-content-inner">			
            <div class="white-area">
				<div class="top-filter">
					<form id="frm" name="search_frm" method="Post"  action="<?php echo base_url();?>mck/report/all_cases">
					<div class="row">
							<div class="col-sm-3">
								<div class="mb-2">
									<label>Start Date</label>
									<input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $start_date;?>">
								</div>
							</div>
							
							<div class="col-sm-3">
								<div class="mb-2">
									<label>End Date</label>
									<input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $end_date;?>">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="mb-2">
								<div class="dt-buttons btn-group flex-wrap"><button class="btn btn-secondary buttons-excel buttons-html5" name="download" id="download" value="download_report" tabindex="0" aria-controls="example" type="submit"><span>Excel</span></button> </div>
								</div>
							</div>
					</div>
				</form>
				</div>
			</div>			
			
		</div>
		
	</div>

<div class="footer-new">
	© Copyright 2022. All right reserved.
</div>


<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/metisMenu.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/main.js"></script>
<!--start data table library here-->
<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.bootstrap5.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.colVis.min.js"></script>

<script>
	$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'excel']
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>
<?php
include_once 'application/views/jscripts/contact_tracing/mackinsy/ticket_list_js.php';
?>
<!--buttons: [ 'excel', 'pdf', '', '' ]-->
<!--end data table library here-->
</body>
</html>