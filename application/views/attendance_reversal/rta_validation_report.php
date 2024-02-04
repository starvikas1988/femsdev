<!DOCTYPE html>
<html lang="en">
<head>
  <title>RTA Validation1</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/attendance_reversal/css/custom.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/attendance_reversal/slick/slick.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/attendance_reversal/slick/slick-theme.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap.min.css">

   <!--start automatic table th adjust css library-->
   <link rel="stylesheet" href="<?php echo base_url();?>assets/attendance_reversal/css/app.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/attendance_reversal/css/dataTables.bootstrap4.min.css">
  <!--end automatic table th adjust css library-->

</head>
<body>

<div class="main">
	<div class="container-fluid">	
		<div class="gimini-main">
			<div class="common-top3">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<div class="select_top">
							<div class="row">
								<!--<div class="col-md-6">
									<div class="dropdown_widget">
										<select class="form-control">
											<option>One</option>
											<option>Two</option>
											<option>Three</option>
											<option>Four</option>
											<option>Five</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="dropdown_widget">
										<select class="form-control">
											<option>One</option>
											<option>Two</option>
											<option>Three</option>
											<option>Four</option>
											<option>Five</option>
										</select>
									</div>
								</div>-->
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="up-in-toggle toggle_widget toggle_widget_new">
							<input type="radio" id="switch_left" name="switch_2" value="yes"  />
							<label for="switch_left">Reversal</label>
							<input type="radio" id="switch_right" name="switch_2" checked value="no"/>
							<label for="switch_right">All</label>
						  </div>
					</div>
				</div>
			</div>
			
			<div class="common_top">
				<div class="common-main">
					<div class="row">
						<div class="col-sm-12">
							<div class="common-repeat">
								<div class="white-widget no-padding approval_widget approval_widget_new">
									<div class="table-widget">
										<div class="right-hr table_padding">
											<div class="radio_widget">
												<label class="radio-inline"><input type="radio" name="optradio" checked>Calendar month</label>
												<label class="radio-inline"><input type="radio" name="optradio">Payroll Month</label>
											</div>
											<div class="table-responsive">
												<table id="example" class="table table-striped dt-responsive nowrap">
													<thead>
														<tr>
															<th>MWP ID</th>
															<th>Name</th>
															<th>Status</th>
															<th>L1</th>
															<th>Client</th>
															<th>Process</th>
															<th>Mon, 1-Aug</th>
															<th>Mon, 2-Aug</th>
															<th>Mon, 3-Aug</th>
															<th>Mon, 4-Aug</th>
															<th>Mon, 5-Aug</th>
															<th>Mon, 6-Aug</th>
															<th>Mon, 7-Aug</th>
															<th>Mon, 5-Aug</th>
															<th>Mon, 10-Aug</th>
														</tr>
													</thead>									
													<tbody>
													<tr>
														<td>
															FKOL001234
														</td>
														<td>
															Manash Kundu<br>
														</td>
														<td>
															<span class="small_blue_color">Present</span><br>
															<span class="small_green_color">Active</span>
														</td>
														<td>
															<small>Manash Kundu</small><br>
															<small>Ganesh Marve</small>
														</td>
														<td>
															<small>Kolkata</small><br>
															<small>Operaton</small>
														</td>
														<td>
															<small>Oyo</small><br>
															<small>SIG</small> 
														</td>
														<td>
															<span class="small_blue_color">
																p
															</span>
														</td>
														<td>
															<span class="small_orange_color">
																Tardy
															</span>
														</td>
														<td>
															<span class="small_blue_color">
																p
															</span>
														</td>
														<td>
															<span class="small_blue_color">
																p
															</span>
														</td>
														<td>
															<span class="small_orange_color">
																Tardy
															</span>
														</td>
														<td>
															<span class="small_green_color">
																Wo
															</span>
														</td>
														<td>
															<span class="small_orange_color">
																Tardy
															</span>
														</td>
														<td>
															<span class="small_green_color">
																Wo
															</span>
														</td>
														<td>
															<span class="small_orange_color">
																Tardy
															</span>
														</td>
													</tr>
													<tr>
														<td>
															FKOL005678
														</td>
														<td>
															Kunal Bose<br>
														</td>
														<td>
															<span class="small_blue_color">Present</span><br>
															<span class="small_green_color">Active</span>
														</td>
														<td>
															<small>Manash Kundu</small><br>
															<small>Ganesh Marve</small>
														</td>
														<td>
															<small>Kolkata</small><br>
															<small>Operaton</small>
														</td>
														<td>
															<small>Oyo</small><br>
															<small>SIG</small> 
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															p
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
													</tr>
													<tr>
														<td>
															FKOL001234
														</td>
														<td>
															Deb Kumar<br>
														</td>
														<td>
															<span class="small_blue_color">Present</span><br>
															<span class="small_green_color">Active</span>
														</td>
														<td>
															<small>Manash Kundu</small><br>
															<small>Ganesh Marve</small>
														</td>
														<td>
															<small>Kolkata</small><br>
															<small>Operaton</small>
														</td>
														<td>
															<small>Oyo</small><br>
															<small>SIG</small> 
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															p
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
													</tr>
													<tr>
														<td>
															FKOL001234
														</td>
														<td>
															Somnath Bhattacharya<br>
														</td>
														<td>
															<span class="small_blue_color">Present</span><br>
															<span class="small_green_color">Active</span>
														</td>
														<td>
															<small>Manash Kundu</small><br>
															<small>Ganesh Marve</small>
														</td>
														<td>
															<small>Kolkata</small><br>
															<small>Operaton</small>
														</td>
														<td>
															<small>Oyo</small><br>
															<small>SIG</small> 
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															p
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
													</tr>
													<tr>
														<td>
															FKOL001234
														</td>
														<td>
															Sankha Choudhury<br>
														</td>
														<td>
															<span class="small_blue_color">Present</span><br>
															<span class="small_green_color">Active</span>
														</td>
														<td>
															<small>Manash Kundu</small><br>
															<small>Ganesh Marve</small>
														</td>
														<td>
															<small>Kolkata</small><br>
															<small>Operaton</small>
														</td>
														<td>
															<small>Oyo</small><br>
															<small>SIG</small> 
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															p
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
													</tr>
													<tr>
														<td>
															FKOL001234
														</td>
														<td>
															Ganesh Marve<br>
														</td>
														<td>
															<span class="small_blue_color">Present</span><br>
															<span class="small_green_color">Active</span>
														</td>
														<td>
															<small>Manash Kundu</small><br>
															<small>Ganesh Marve</small>
														</td>
														<td>
															<small>Kolkata</small><br>
															<small>Operaton</small>
														</td>
														<td>
															<small>Oyo</small><br>
															<small>SIG</small> 
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															p
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
													</tr>
													<tr>
														<td>
															FKOL001234
														</td>
														<td>
															Amit Sharma<br>
														</td>
														<td>
															<span class="small_blue_color">Present</span><br>
															<span class="small_green_color">Active</span>
														</td>
														<td>
															<small>Manash Kundu</small><br>
															<small>Ganesh Marve</small>
														</td>
														<td>
															<small>Kolkata</small><br>
															<small>Operaton</small>
														</td>
														<td>
															<small>Oyo</small><br>
															<small>SIG</small> 
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															p
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
													</tr>
													<tr>
														<td>
															FKOL001234
														</td>
														<td>
															Debyan Chatterjee<br>
														</td>
														<td>
															<span class="small_blue_color">Present</span><br>
															<span class="small_green_color">Active</span>
														</td>
														<td>
															<small>Manash Kundu</small><br>
															<small>Ganesh Marve</small>
														</td>
														<td>
															<small>Kolkata</small><br>
															<small>Operaton</small>
														</td>
														<td>
															<small>Oyo</small><br>
															<small>SIG</small> 
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															p
														</td>
														<td>
															p
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
														<td>
															WO
														</td>
														<td>
															Tardy
														</td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			
		</div>
	</div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/attendance_reversal/slick/slick.min.js"></script>
<script src="<?php echo base_url();?>assets/attendance_reversal/js/progresscircle.js"></script>
<script src="<?php echo base_url();?>assets/attendance_reversal/js/custom.js"></script>
<script src="<?php echo base_url();?>assets/attendance_reversal/js/chart-bar.js"></script>

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

<!--start automatic table th adjust js library-->
<script src="<?php echo base_url();?>assets/attendance_reversal/js/dashboard.init.js"></script>
<script src="<?php echo base_url();?>assets/attendance_reversal/js/dataTables.responsive.min.js"></script>
<!--end automatic table th adjust js library-->

<script>
	$(document).ready(function() {
    var table = $('#example').DataTable( {
		pageLength: 20,
        lengthChange: true,
		lengthMenu: [
            [20, 50, 100, -1],
            [20, 50, 100, 'All'],
        ],
        buttons: [ '', 'excel', '', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(0)' );
} );
</script>


<script>
	$(document).ready(function() {
		$(".dtr-control").click(function () {
			if (!$(this).hasClass('active_minus')){
				$(this).addClass('active_minus');
			}else{
				$(this).removeClass('active_minus');
			}
		});	
	});
</script>

</body>
</html>