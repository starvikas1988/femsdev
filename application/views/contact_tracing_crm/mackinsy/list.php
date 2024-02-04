<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Case List</title>
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
	
</head>

<body>

<div id="page-container">
    <div class="header-area">
        <div class="header-area-left">
            <a href="#" class="logo">
                <img src="<?php echo base_url() ?>assets/mckinsey/images/logo.png" class="logo" alt="">
            </a>
        </div>
		<!--start mobile logo -->
		<div class="mobile-logo-new">
			<a href="#" class="logo">
                <img src="<?php echo base_url() ?>assets/mckinsey/images/side-logo.png" class="logo" alt="">
            </a>
		</div>
		<!--end mobile logo -->
		
        <div class="row align-items-center header_right">           
            <div class="col-md-10">
                <?php include('menu.php');?>
            </div>            
            <div class="col-md-2">
                  <div class="dropdown log-out pull-right">
						<button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
						  <img src="<?php echo base_url() ?>assets/mckinsey/images/user.jpg" alt="" class="img-fluid">
						</button>
						<ul class="dropdown-menu profile-widget">
							<li class="text-center">
								<img src="<?php echo base_url() ?>assets/mckinsey/images/user.jpg" alt="" class="img-fluid">
							</li>
							<li class="text-center"><strong>Profile Name</strong></li>
						  <li><a class="dropdown-item" href="#">example@gmail.com</a></li>
						</ul>
					</div>
				</div>
            </div>            
        </div>

    </div>
   
    <div class="main-content page-content">
        <div class="main-content-inner">
			<div class="top-bg">
				<div class="row">
					<div class="col-md-12">
					   <div class="elements-left">
							<h3 class="heading-black">
								Case Listing
							</h3>
					   </div>					   
					</div>
				</div>
			</div>
            <div class="row">
				<div class="col-sm-9">
					<div class="repeat-widget">
						<table id="example" class="table table-striped table-bordered">
						<thead>
						  <tr>
							<th>Case No</th>
							<th>Name</th>
							<th>Communication</th>
							<th>phone</th>
							<th>Fmno</th>
							<th>location</th>
							<th>Assess Situation</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody>
						 <?php foreach($case_list as $key=>$rw){ ?>	
						  <tr>
							<td><?php echo $rw['case_id'];?></td>
							<td><?php echo $rw['name'];?></td>
							<td><?php echo $rw['communication'];?></td>
							<td><?php echo $rw['phone'];?></td>
							<td><?php echo $rw['fmno'];?></td>
							<td><?php echo $rw['location'];?></td>
							<td><?php echo $rw['assess_situation'];?></td>
							<td>
								<a href="<?php echo base_url() ?>mck/edit/<?php echo $rw['case_id'];?>" class="editable">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>
								<a onclick="delete_case('<?php echo $rw['case_id'];?>');" class="editable">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</a>
							</td>
						  </tr>
						  <?php } ?>						  					  
						</tbody>
					  </table>
					</div>					
				</div>
				<div class="col-sm-3">
					<div class="right-area dropdown-area">
						<div class="mb-2">
							<input type="text" class="form-control" placeholder="Country" id="">
							<button class="add-btn">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</div>
						<div class="mb-2">
							<input type="text" class="form-control" placeholder="Location" id="">
							<button class="add-btn">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</div>
						<div class="mb-2">
							<input type="text" class="form-control" placeholder="Office Managing Partner
" id="">
						</div>
						<div class="mb-2">
							<input type="text" class="form-control" placeholder="HR" id="">
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>

<div class="footer-new">
	© Copyright 2021. All right reserved.
</div>

<!--add dropdown menu-->
<div class="modal fade modal-design" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Modal body..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
<!--end add dropdown menu-->

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
        buttons: [ 'excel', '', '', '' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>

<!--end data table library here-->

<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
<?php
include_once 'application/views/jscripts/contact_tracing/mackinsy/ticket_list_js.php';
?>
</body>
</html>