
 <style>

	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:2px;
		font-size:11px;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}

	.panel .table td, .panel .table th{
		font-size:11px;
		padding:6px;
	}
	
	.hide{
	  disply:none;	  
	}
	
	.modal-dialog {
		width: 800px;
	}
	.modal
	{
		overflow:auto;
	}
	
	/*---------- MY CUSTOM CSS -----------*/
	.rounded {
	  -webkit-border-radius: 3px !important;
	  -moz-border-radius: 3px !important;
	  border-radius: 3px !important;
	}

	.mini-stat {
	  padding: 5px;
	  margin-bottom: 20px;
	}

	.mini-stat-icon {
	  width: 30px;
	  height: 30px;
	  display: inline-block;
	  line-height: 30px;
	  text-align: center;
	  font-size: 15px;
	  background: none repeat scroll 0% 0% #EEE;
	  border-radius: 100%;
	  float: left;
	  margin-right: 10px;
	  color: #FFF;
	}

	.mini-stat-info {
	  font-size: 12px;
	  padding-top: 2px;
	}

	span, p {
	  /*color: white;*/
	}

	.mini-stat-info span {
	  display: block;
	  font-size: 20px;
	  font-weight: 600;
	  margin-bottom: 5px;
	  margin-top: 7px;
	}

	/* ================ colors =====================*/
	.bg-facebook {
	  background-color: #3b5998 !important;
	  border: 1px solid #3b5998;
	  color: white;
	}

	.fg-facebook {
	  color: #3b5998 !important;
	}

	.bg-twitter {
	  background-color: #00a0d1 !important;
	  border: 1px solid #00a0d1;
	  color: white;
	}

	.fg-twitter {
	  color: #00a0d1 !important;
	}

	.bg-googleplus {
	  background-color: #db4a39 !important;
	  border: 1px solid #db4a39;
	  color: white;
	}

	.fg-googleplus {
	  color: #db4a39 !important;
	}

	.bg-bitbucket {
	  background-color: #205081 !important;
	  border: 1px solid #205081;
	  color: white;
	}

	.fg-bitbucket {
	  color: #205081 !important;
	}
	
		
	.highcharts-credits {
		display: none !important;
	}
	
	
	.text-box{
		background-color: #fff;
		padding: 10px 10px;
		margin:5px 5px 25px 5px;
		border-radius: 4px;
	}
	
	.text-headbox{
		margin-top: 5px;
		text-align:center;
	}
	.bhead{
		padding: 5px 8px;
		color: #000;
		font-size: 20px;
		letter-spacing: 0.8px;
		font-weight: 600;
		text-align:center;
	}
	.bheadInfo{
		padding: 2px 8px;
		color: #000;
		font-size: 16px;
		letter-spacing: 1px;
		font-weight: 600;
	}
	.btext{
		background-color: #d4eff7;
		padding: 17px;
		border-radius: 20px 0px 0px 0px;
		font-size: 25px;
	}
	
	.boxShape{
		background-color: #fff797;
		padding: 10px 20px;
		width: 80%;
		border-radius: 10px;
	}
	.initialInfo{
		font-size: 45px;
		padding: 5px 10px;
	}
	.laterInfo{
		font-size: 19px;
        padding: 20px 5px 20px 5px;
	}
	
	.counterBox{
		background-color: #fff797;
		padding: 10px 20px;
		width: 100%;
		border-radius: 10px;
	}
	
	.counterIcon{
		font-size: 45px;
		padding: 5px 10px;
	}
	
	.counterInfo{
		font-size: 16px;
	}
	.prizeNumber{
		border: 2px solid #f4ff4d;
		border-radius: 50%;
		padding: 7px 12px;
		margin: 0px 10px 0px 0px;
		background-color: #000;
		font-size:16px;
	}
	.rankInfo{
		margin: 18px 10px;
	}
		
</style>


<!-- Metrix -->

<div class="wrap">
<section class="app-content">
	
<div class="widget">
<hr class="widget-separator"/>

	<div class="widget-body clearfix">
	
	<div class="row">
	  <div class="col-md-4">
	  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Acceptance Dashboard</h4>
	  </div>
	</div>
	 
	<hr/>
	
	<div class="row">		
	<div class="col-md-12">
	<form method="GET" id="summaryForm" enctype="multipart/form-data">
	
		<div class="row">
		<div class="col-md-3">
			<div class="form-group" style="padding:2px 10px 2px 0px">
				<label for="ssdate">Select Office</label>
				<select class="form-control" name="select_office" id="select_office">								
					<?php
					foreach($location_list as $token){
						$selectin = "";
						if($selected_office == $token['abbr']){ $selectin = "selected"; }								
					?>
					<option value="<?php echo $token['abbr']; ?>" <?php echo $selectin; ?>><?php echo $token['office_name']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group" style="padding:2px 10px 2px 0px">
				<label for="ssdate">Search Client</label>
				<select class="form-control" name="select_client" id="select_client" required>
					<option value="ALL">ALL</option>
					<?php
					foreach($client_list as $token){
						$selectin = "";
						if($selected_client == $token['id']){ $selectin = "selected"; } 
						
					?>
					<option value="<?php echo $token['id']; ?>" <?php echo $selectin; ?>><?php echo $token['shname']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
				
		<div class="col-md-3">
			<div class="form-group" style="padding:2px 10px 2px 0px">
				<label for="ssdate">Select Campaign</label>
				<select class="form-control" name="select_process" id="select_process" required>								
					<?php 
					echo "<option value='ALL'>ALL</option>";
					$sn=0; foreach($userProcess as $token){ $sn++;
					$selectiny = "";
					if($selected_process == $token['process_id']){ $selectiny = "selected"; }
					?>
					<option value="<?php echo $token['process_id']; ?>" <?php echo $selectiny; ?>><?php echo str_replace('qa_', '', $token['process_name']); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group" style="padding:2px 10px 2px 0px">
				<label for="ssdate">Select TL</label>
				<select class="form-control" name="select_tl" id="select_tl" required>
					<option value="ALL">ALL</option>
					<?php $sn=0; foreach($tl_list as $token){ $sn++;
					$selectiny = "";
					if($selected_tl == $token['id']){ $selectiny = "selected"; }
					?>
					<option value="<?php echo $token['id']; ?>" <?php echo $selectiny; ?>><?php echo $token['fullname']." (" .$token['fusion_id'].")"; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
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
		
		<div class="col-md-1">
			<div class="form-group" style="margin-top:20px">
				<input type="submit" class="btn btn-primary btn-md" name='submitgraph' value="Search">
			</div>
		</div>		
		</div>
		
	</form>		
	</div>
	</div>
	
		
	<!--
	
	<div class="row">
    <div class="col-md-4">
	  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Acceptance Analytics</h4>
	</div>
	</div>
	-->
	<hr/>
	
    <div class="row">	
	<div class="col-md-12">
	<div class="row">
	<?php if(empty($selected_process)){ ?>
		<div class="col-md-3">
			<div class="counterBox text-center row" style="background-color:#5f0000;background-image: linear-gradient(to right, #ed6ea0 0%, #ec8c69 100%);margin:0 auto; width:70%">
				<div class="col-md-12 text-white counterIcon"><i class="fa fa-headphones"></i></div> 
				<div class="col-md-12 text-white text-center counterInfo"><span style="font-size:12px">Process Count</span> <br/> <b><?php echo $overview['process_count']; ?></b></div>
			</div>
		</div>
	<?php } ?>	
		<div class="col-md-3">
			<div class="counterBox text-center row" style="background-color:#4d687c;background-image: linear-gradient(to top, #30cfd0 0%, #330867 100%);margin:0 auto; width:70%">
				<div class="col-md-12 text-white counterIcon"><i class="fa fa-users"></i></div> 
				<div class="col-md-12 text-white text-center counterInfo"><span style="font-size:12px">Feedback Raised</span> <br/> <b><?php echo $overview['feedback_raised']; ?></b></div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="counterBox text-center row" style="background-color:#31863f;background-image: linear-gradient(to top, #3cba92 0%, #0ba360 100%);margin:0 auto; width:70%">
				<div class="col-md-12 text-white counterIcon"><i class="fa fa-bullhorn"></i></div> 
				<div class="col-md-12 text-white text-center counterInfo"><span style="font-size:12px">Feedback Accepted</span> <br/> <b><?php echo $overview['feedback_accepted']; ?></b></div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="counterBox text-center row" style="background-color:#5f0000;background-image: linear-gradient(to right, #ed6ea0 0%, #ec8c69 100%);margin:0 auto; width:70%">
				<div class="col-md-12 text-white counterIcon"><i class="fa fa-bar-chart"></i></div> 
				<div class="col-md-12 text-white text-center counterInfo"><span style="font-size:12px">Acceptance Trend</span> <br/> <b><?php echo $overview['feedback_trend']; ?>%</b></div>
			</div>
		</div>
		
	</div>
	</div>
	</div>
	
	</div>
</div>





<div class="widget">
<hr class="widget-separator"/>
	<div class="widget-body clearfix">
	<!--<div class="row">
    <div class="col-md-4">
	  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Acceptance Analytics</h4>
	</div>
	</div>

	<hr/>	-->
    <div class="row">
	
	<div class="col-md-6">
	<div class="table-responsive">
			<table style="margin-top: 10px;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
				<thead>
					<tr class='bg-info'>
						<th>#</th>
						<th>Campaign</th>
						<th>Feedback Raised</th>
						<th>Feedback Accepted</th>
						<th>Acceptance</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$cn = 1;
				$countZero = 0;
				foreach($overview['reviewData'] as $token){
						//if($countZero <= 5){
						if($token['total_feedback'] > 0 || !empty($selected_process)){
						//if($token['total_feedback'] <= 0){ $countZero++; }
				?>
				<tr>
					<td class="text-center"><?php echo $cn++; ?></td>
					<td class="text-center"><b><?php echo $token['qa_name']; ?><b></td>
					<td class="text-center"><b><?php echo $token['total_feedback']; ?></b></td>
					<td class="text-center"><?php echo $token['agent_review']; ?></td>
					<td class="text-center"><?php echo $token['feedback_percent']; ?>%</td>
				</tr>
				<?php } //} ?>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	
	
	<div class="col-md-6">
	<div class="table-responsive">
			<table style="margin-top: 10px;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
				<thead>
					<tr class='bg-info'>
						<th>#</th>
						<th>Campaign</th>
						<th>Agent Review</th>
						<th>Management Review</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$cn = 1;
				$countZero = 0;
				foreach($overview['reviewAgent'] as $token){
						//if($countZero <= 5){
						if($token['total_feedback'] > 0 || !empty($selected_process)){
						//if($token['total_feedback'] <= 0){ $countZero++; }
				?>
				<tr>
					<td class="text-center"><?php echo $cn++; ?></td>
					<td class="text-center"><b><?php echo $token['qa_name']; ?><b></td>
					<td class="text-center"><b><?php echo $token['agent_review']; ?></b></td>
					<td class="text-center"><?php echo $token['manager_review']; ?></td>
				</tr>
				<?php //} ?>
				<?php } } ?>
				</tbody>
			</table>
		</div>
	</div>
	
	</div>
	
	</div>
</div>



<div class="widget">
<hr class="widget-separator"/>
	<div class="widget-body clearfix">
    <div class="row">
	<div class="col-md-<?php echo !empty($selected_process) ? 6 : 12; ?>">
	<h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Acceptance Timeline</h4>
	<hr/>
	<div id="mySmartViewAcceptance" style="width: 100%;height:<?php echo !empty($selected_process) ? 300 : 500; ?>px"></div>
	<br/>
	</div>
	<div class="col-md-<?php echo !empty($selected_process) ? 6 : 12; ?>">
	<h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Acceptance View</h4>
	<hr/>
	<div id="mySmartViewAcceptanceTimeline" style="width: 100%;height:<?php echo !empty($selected_process) ? 300 : 400; ?>px"></div>
	</div>
	</div>
	</div>
</div>
		
</section>
</div><!-- .wrap -->


