
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
	table.google-visualization-orgchart-table {
		border-collapse: separate;
	}
	.headBar {
		background-color:#e7e7e7!important;
	}
</style>


<div class="wrap">
<section class="app-content">
	
	<div class="row">		
	<div class="col-md-12">
	<div class="widget headBar">
		<header class="widget-header">
		<h4 class="widget-title"><i class="fa fa-bar-chart"></i> Ticket Overview</h4>
		</header>
	</div>
	</div>
		
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-body">				
				
				
			<form method="GET" id="summaryForm" enctype="multipart/form-data">
			<div class="row">
				
				<div class="col-md-3">
					<div class="form-group" style="padding:2px 10px 2px 0px">
						<label for="ssdate">Filter Type</label>
						<select class="form-control filterType" name="report_type" id="report_type">								
							<option value="month" <?php echo $report_type == "month" ? "selected" : ""; ?>>Month</option>
							<option value="date" <?php echo $report_type == "date" ? "selected" : ""; ?>>Date</option>
						</select>
					</div>
				</div>
				
				<div class="col-md-3 monthInfo" <?php echo $report_type == "date" ? 'style="display:none"' : ''; ?>>
					<div class="form-group" style="padding:2px 10px 2px 0px">
						<label for="ssdate">Search Month</label>
						<select class="form-control" name="select_month" id="select_month">								
							<?php
							for($i=1;$i<=12;$i++){
								$selectin = "";
								if($selected_month == $i){ $selectin = "selected"; }					
							?>
							<option value="<?php echo sprintf('%02d', $i); ?>" <?php echo $selectin; ?>>
							<?php echo date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01')); ?>
							</option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="col-md-3 monthInfo" <?php echo $report_type == "date" ? 'style="display:none"' : ''; ?>>
					<div class="form-group" style="padding:2px 10px 2px 0px">
						<label for="ssdate">Search Year</label>
						<select class="form-control" name="select_year" id="select_year">								
							<?php
							$current_y = date('Y');
							$last_y = $current_y - 5;
							for($j=$current_y;$j>=$last_y;$j--){
								$selectiny = "";
								if($selected_year == $j){ $selectiny = "selected"; }
							?>
							<option value="<?php echo $j; ?>" <?php echo $selectiny; ?>>
							<?php echo $j; ?>
							</option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="col-md-3 dateInfo" <?php echo $report_type == "month" ? 'style="display:none"' : ''; ?>>
					<div class="form-group" style="padding:2px 10px 2px 0px">
						<label for="ssdate">Start Date</label>
					<input class="form-control" name="select_start_date" id="select_start_date" value="<?php echo date('m/d/Y', strtotime($start_date_full)); ?>" required>
					</div>
				</div>
				
				<div class="col-md-3 dateInfo" <?php echo $report_type == "month" ? 'style="display:none"' : ''; ?>>
					<div class="form-group" style="padding:2px 10px 2px 0px">
						<label for="ssdate">End Date</label>
					<input class="form-control" name="select_end_date" id="select_end_date" value="<?php echo date('m/d/Y', strtotime($end_date_full)); ?>"  required>
					</div>
				</div>
				
				<div class="col-md-2">
					<div class="form-group" style="margin-top:22px">
						<input type="submit" class="btn btn-primary btn-md" name='submitgraph' value="Search">
					</div>
				</div>
		
				
			</div>
			</form>
			
			</div>
		</div>
	</div>
	</div>
	
	
	<br/>
	
	<div class="row">		
	<div class="col-md-12">
	<div class="widget headBar">
		<header class="widget-header">
		<h4 class="widget-title"><i class="fa fa-bar-chart"></i> Daywise Ticket Overview</h4>
		</header>
	</div>
	</div>
		
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-body">	
				<div class="row">
				<div class="col-md-12">
					<div style="width:100%;height:400px; padding:10px 10px">
						<canvas id="o_ticket_daily"></canvas>
					</div>
				</div>				
				</div>				
			</div>
		</div>
	</div>
	
	</div>
	
	<br/>
	
	<div class="row">		
	<div class="col-md-12">
	<div class="widget headBar">
		<header class="widget-header">
		<h4 class="widget-title"><i class="fa fa-bar-chart"></i> Ticket Analytics</h4>
		</header>
	</div>
	</div>
		
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-body">	
				<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12">
							<br/>
							<div id="o_ticket_classified_all"></div>
							<br/>
						</div>						
						<div class="col-md-12">
							<div id="o_ticket_all"></div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12">
							<div style="width:100%;padding:20px 40px;height:250px">
								<canvas id="o_ticket_analytics_all_open"></canvas>
							</div>
						</div>
						<div class="col-md-12">
							<div style="width:100%;padding:20px 40px;height:250px">
								<canvas id="o_ticket_analytics_all_closed"></canvas>
							</div>
						</div>
					</div>
				</div>
				</div>				
			</div>
		</div>
	</div>
	
	</div>
	
	<br/>

<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

</section>
</div>