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
					<form id="frm" name="search_frm" method="Post"  action="<?php echo base_url();?>mck/close_contact">
					<div class="row">
							<div class="col-sm-3">
								<div class="mb-2">
									<label>Case Name</label>
									<input type="text" class="form-control" id="search_case_name" name="search_case_name" value="<?php echo $search_case_name;?>">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="mb-2">
									<label>Country</label>
									<!--<input type="text" class="form-control" id="">-->
									<select id="search_country" name="search_country" class="form-control">
										<option value=""> Select </option>
										<?php foreach ($country_list as $key => $rows) {
										?>
										<option value="<?php echo $rows['id'];?>" <?php echo ($rows['id']==$search_country)?'selected="selected"':'';?>><?php echo $rows['name'];?></option>
										<?php } ?>
									</select>	
								</div>
							</div>
							<div class="col-sm-3">
								<div class="mb-2">
									<label>Location</label>
									<input type="text" class="form-control" id="search_location" name="search_location" value="<?php echo $search_location;?>">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="mb-2">
									<button type="submit" class="search-btn">
										<i class="fa fa-search" aria-hidden="true"></i>
									</button>
								</div>
							</div>
					</div>
				</form>
				</div>
			</div>			
			<div class="white-area">
				<div class="top-filter">
					<!--<a href="mailto:example@gmail.com" class="mail-icon">
						<i class="fa fa-envelope-o" aria-hidden="true"></i>
					</a>-->
					<table id="example" class="table table-striped">
						<thead>
						  <tr>
							<th></th>
							<th></th>
							<th>COVID-19 Case</th>
							<th>Added On</th>
							<th>Name</th>
							<th>Impacted Mck Office</th>
							<th>Person Region</th>
							<th>Health Status</th>
							<th>Location</th>
							<th>Person Case Management</th>
							<th>Action</th>
							<!--<div class="gear-widget">
								<div class="dropdown">
								  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
									<i class="fa fa-cog" aria-hidden="true"></i>
								  </button>
								  <ul class="dropdown-menu">
									<li><a class="dropdown-item" href="#">Option 1</a></li>
									<li><a class="dropdown-item" href="#">Option 2</a></li>
									<li><a class="dropdown-item" href="#">Option 3</a></li>
									<li><a class="dropdown-item" href="#">Option 4</a></li>
									<li><a class="dropdown-item" href="#">Option 5</a></li>
								  </ul>
								</div>
							</div>-->	
						  </tr>
						</thead>
						<tbody>
						<?php 
						$i=1;
						foreach($case_list as $ky=>$rws){ 
							?>	
						  <tr>
							<td><?php echo $i;?></td>
							<td>				
							</td>
							<td><?php echo $rws['caseID'];?></td>
							<td><?php echo $rws['added_date'];?></td>
							<td><?php echo ucfirst($rws['name']);?></td>
							<td><?php echo $rws['home_office_lmp'];?></td>
							<td><?php echo $rws['country_name'];?></td>
							<td><?php echo $rws['assess_situation'];?></td>
							<td><?php echo $rws['location'];?></td>
							<td><?php echo $rws['case_manager'];?></td>
							<td>
							<?php if(is_access_mckinsey_edit() || get_login_type()== "client"){ ?>
								<a href="<?php echo base_url() ?>mck/edit_case/<?php echo $rws['caseID'];?>" class="editable">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>
								<?php } if(is_access_mckinsey_delete() || get_login_type()== "client"){ ?>	
								<a onclick="delete_case('<?php echo $rws['caseID'];?>');" class="editable">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</a>
								<?php } ?>	
							</td>
						  </tr>
						  <?php $i++;} ?>
						</tbody>
					  </table>
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