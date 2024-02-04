
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	
	#show{
		margin-top:5px;
	}
	
	td{
		font-size:10px;
	}
	
	#default-datatable th{
		font-size:11px;
	}
	#default-datatable th{
		font-size:11px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
	}
	
	.modal-dialog{
		width:800px;
	}
</style>

<div class="wrap">
	<section class="app-content">
	
	<div class="row">
		<div class="col-12">

			<div class="widget">
			
				<?php if($graph_download == "no") { ?>
				<div class="row">
					<div class="col-md-10">
						<header class="widget-header">
							<h4 class="widget-title">Generate Report</h4>
						</header>
					</div>	
					<hr class="widget-separator">
				</div>
				<?php } ?>
				<div class="widget-body">
					<?php if($graph_download == "no") { ?>
					<form id="form_new_user" action="" method="GET" action="" autocomplete="off">
					
						<div class="row">
							<div class="col-md-3"> 
								<div class="form-group">
									<label>Report Type</label>
									<select class="form-control" name="report_type">
										<option <?php if($rprt_type == "Table") echo "selected"; ?> value="Table">Table</option>
										<option <?php if($rprt_type == "Graph") echo "selected"; ?> value="Graph">Graph</option>
									</select>
								</div> 
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>From Date (mm/dd/yyyy)</label>
									<input type="date" id="search_from_date" name="start" value="<?php if(!empty($from_date)){ echo date('Y-m-d', strtotime($from_date)); } ?>" class="form-control" required>
								</div>
							</div>
							<div class="col-md-3"> 
								<div class="form-group">
									<label>To Date (mm/dd/yyyy)</label>
									<input type="date" id="search_to_date" name="end" value="<?php if(!empty($to_date)){ echo date('Y-m-d', strtotime($to_date)); } ?>" class="form-control" required>
								</div> 
							</div>
							<div class="col-md-3"> 
								<div class="form-group">
									<label>File</label>
									<select class="form-control" name="rtype">
										<option <?php if($rtype == "Government Benefits") echo "selected"; ?> value="Government Benefits">Government Benefits</option>
										<option <?php if($rtype == "Corporate Health & Life Insurance") echo "selected"; ?> value="Corporate Health & Life Insurance">Corporate Health & Life Insurance</option>
										<option <?php if($rtype == "Downloadable Forms") echo "selected"; ?> value="Downloadable Forms">Downloadable Forms</option>
										<option <?php if($rtype == "Other Employee Perks") echo "selected"; ?> value="Other Employee Perks">Other Employee Perks</option>
										<option <?php if($rtype == "Frequently Asked Questions") echo "selected"; ?> value="Frequently Asked Questions">Frequently Asked Questions</option>
									</select>
								</div> 
							</div>
							<div class="col-md-3"> 
								<div class="form-group">
									<label>Fusion ID</label>
									<input type="text" class="form-control" name="f_id" value="<?php if($f_id!='') echo $f_id; ?>">
								</div> 
							</div>
						</div>
						
						<div class="row">							
							<div class="col-md-1" style="margin-top:20px">
								<button class="btn btn-success waves-effect" type="submit" value="View">Search</button>
							</div>
						</div>
						
					</form>
				<?php } ?>

					<?php if($rprt_type == "Table"){ if(!empty($fullAray)){ ?>
	<br>
	<hr>


	<div class="table-responsive">

		<?php if($download_link!=""){ ?>
									<div style="margin-bottom: 25px;float:left;margin-top:22px;" class="col-md-12">
										
										<div class="form-group" style='float:left;'>
											<h4><b>Report Details <?php if($f_id != "") echo "For ".$f_id; ?></b></h4>
										</div>

										<div class="form-group" style='float:right;'>
											<a id="download_pro" href='<?php echo $download_link; ?>'><span style="padding:12px;" class="label label-success">Export Report</span></a>
										</div>
									</div>
								<?php } ?>
		<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
			<thead>
				<tr class='bg-info'>
					<th>Sl. No.</th>
					<th>File Name</th>
					<th>Download Date</th>
					<th>No. of <?php if($rtype == "Government Benefits" || $rtype == "Frequently Asked Questions" || $rtype == "Other Employee Perks") echo 'Views'; else echo 'Downloads'; ?></th>
				</tr>
			</thead>
			<tbody>

				<?php 
					$downloads = 0; foreach ($fullAray as $key => $value) { 
						$downloads +=$value['downloads'];
				?>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td><?php echo $value['file_name']; ?></td>
						<td><?php echo $value['downloaded_date']; ?></td>
						<td><?php echo $value['downloads']; ?></td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="3">Total Downloads</td>
					<td><?php echo $downloads; ?></td>
				</tr>
			</tbody>
		</table>
	</div>


<?php }else{ ?>
	<br>
	<hr>

	<div style="margin-bottom: 25px;float:left;margin-top:22px;" class="col-md-12">	
		<div class="form-group" style='float:left;'>
			<h4><b>Report Details <?php if($f_id != "") echo "For ".$f_id; ?></b></h4>
		</div>
	</div>

	<div class="text-center">
		<label class="label-danger">No Data Found</label>
	</div>

<?php } }elseif($rprt_type == "Graph"){ ?>


<div class="wrap">
<section class="app-content">

  <hr style="margin-top: 10px;">
  
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">	 

 <!-- <a href='<?php echo base_url()."clinic_portal/download_graph_pdf/$from_date/$to_date/$rtype/$f_id" ?>' class="btn float-reght btn-success">Export Graph Report</a>  -->
<div class="panel panel-default">
  <div class="panel-heading"><b>Downloads Analytics - Day-wise <?php if($f_id != "") echo "For ".$f_id; ?></b></div>
  <div class="panel-body">	
	<div class="row">
	<div class="col-md-8 col-sm-8 col-xs-8">
	
	
		<div style="width:100%;height:400px; padding:50px 10px">
			<canvas id="download_report_2dline_graph_container"></canvas>
		</div>
	
		<!--<span class="text-danger"><b>-- No Records Availabale --</b></span>-->
	
	</div>	
	</div>	
</div>
</div>

</div>
</div>


</div>
<!-- </div>   -->
</section>
</div>



<?php } ?>	
				</div>
				
			</div>

		</div>		
	</div>



		
	</section>
</div>
<?php if($rprt_type == "Graph") { ?>

<script src="<?php echo base_url() ?>libs/jquery/jquery-3.5.1.js"></script>	
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>

<script type="text/javascript">
var ctxBAR = document.getElementById("download_report_2dline_graph_container");
var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php for ($i = 0; $i<count($fullAray); $i++) { echo date('d-m-Y', strtotime($fullAray[$i]['downloaded_date'])); if($i<(count($fullAray))){ echo'","';} } ?>"],
	  datasets: [
		{
		  label: "Visitors",
		  data: [
		  <?php for ($i = 0; $i<count($fullAray); $i++) { echo $fullAray[$i]['downloads']; if($i<count($fullAray)) echo','; } ?>			
		  ],
		  //backgroundColor: ["<?php echo implode('","',$randomColors); ?>"],
		  backgroundColor: "#3f9907",
		  borderColor: "#3f9907",
		 // borderColor: ["<?php echo implode('","',$randomColors); ?>"],
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 2,
		text: ""
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel + '';
		   }
		}
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  scales: {
		   xAxes: [{
			// gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			display:true,
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value + '';
			  },
			  beginAtZero: true,
			}
		  }]
		},
	  plugins: {
	  datalabels: {
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value + '';
		},
		font: {
		  size:9,
		  weight: 'bold'
		}
	  }
	  }	
	},
	
});

</script>
<?php } ?>