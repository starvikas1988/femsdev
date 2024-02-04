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
.customRadio{
	padding-left:20px;
}
.customRadio input{
	margin-right:10px;
}
.multipleOthersText{
	margin-left:25px;
	width:60%;
}

.oddRow{
	padding:4px 0px 4px 2px;
	background-color: #f7f7f7;
}
.evenRow{
	padding:4px 0px 4px 2px;
}
.qCircle{
	padding:5px 10px;
	border-radius:50%;
	background-color:#000;
	color:#fff;
	margin-right:6px;
}
.panelQ{
	font-size:14px;
	font-weight:600;
}
</style>


<div class="wrap">
	<section class="app-content">
	
		<div class="row">
		
		<div class="col-md-12">
		<div class="widget">
			<header class="widget-header">
			<h4 class="widget-title">MPower Feedback Analytics</h4>
			</header>
		</div>
		</div>
		
		
		
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body">
					<form id="form_new_user" method="GET" action="">						
							<div class="row">								
								<div class="col-md-2">
									<div class="form-group">
										<label>Month</label>
										<select class="form-control" name="monthSelect" id="monthSelect">
											<?php
											//echo "<option value='ALL'>ALL</option>";
											for($i=1; $i<=12; $i++){
												$setSelection = "";
												$currDate = date('Y')."-".sprintf('%02d', $i)."-01";
												if($i == $selected_month){ $setSelection = "selected"; }
											?>
												<option value="<?php echo date('m', strtotime($currDate)); ?>" <?php echo $setSelection; ?>><?php echo date('F', strtotime($currDate)); ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Year</label>
										<select class="form-control" name="yearSelect" id="yearSelect">
											<?php
											//echo "<option value='ALL'>ALL</option>";
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
									
								<div class="col-md-1" style="margin-top:25px">
									<div class="form-group">
										<button class="btn btn-success waves-effect" type="submit">View Report</button>
									</div>
								</div>
								
								<div class="col-md-1" style="margin-top:25px">
									<div class="form-group">
									     &nbsp;&nbsp;
										
									</div>
								</div>
							</div>							
					</form>	
					</div>
				</div>
			</div>
		</div>
		
<?php

$optionsArray_1 = array(
	"1" => "1 Star",
	"2" => "2 Star",
	"3" => "3 Star",
	"4" => "4 Star",
	"5" => "5 Star",
);

$optionsArray_2 = array(
	"0" => "Not at all Likely",
	"1" => "1",
	"2" => "2",
	"3" => "3",
	"4" => "4",
	"5" => "5",
	"6" => "6",
	"7" => "7",
	"8" => "8",
	"9" => "9",
	"10" => "Extremely Likely",
);


?>
		
		
		
		
<div class="row">
		
<div class="col-md-12">
<div class="widget">
	<header class="widget-header">
	<h4 class="widget-title"><i class="fa fa-bar-chart"></i> Feedback Analytics 
	<span class="pull-right"><a href="<?php echo base_url() ."feedback/generate_feedback_reports?monthSelect=".$selected_month."&yearSelect=".$selected_year; ?>" class="btn btn-primary waves-effect downloadFeedback"><i class="fa fa-download"></i> Download</a> <?php echo $total_submission; ?>/<?php echo $totalCRMCount; ?> Records</span></h4>
	</header>
</div>
</div>

<div class="col-md-12">
<div class="widget">
<div class="widget-body">
<div class="panel panel-default">
<div class="panel-heading font-weight-bold panelQ"></div>
<div class="panel-body">	

<div class="col-md-12 col-sm-12 col-xs-12">
<?php if($totalCRMCount > 0){ ?>
	<div class="col-md-8">
    <div id="feedback_overview_graph" style="width:100%;height:220px; padding:10px 0px"> </div>
    </div>
<?php } else { ?>
	<span class="text-danger"><b>-- No Records Availabale --</b></span>
<?php } ?>
</div>
			  
</div>	
</div>
</div>
</div>
</div>

<div class="col-md-12">
<div class="widget">
<div class="widget-body">
<div class="panel panel-default">
<div class="panel-heading font-weight-bold panelQ"><span class="qCircle">1</span> Rate experience based on Courtesy</div>
<div class="panel-body">	
<?php foreach($optionsArray_1 as $opt => $val){ ?>
	<?php
	// SURVEY 1
	$answer_check = !empty($answers['customer_service'][$opt]) ? $answers['customer_service'][$opt] : '0';
	$total_check = 0;
	if($total_submission > 0){
		$total_check = ($answer_check / $total_submission) * 100;
		$total_check = sprintf('%02d', $total_check);
	}
	$colorClass = "bg-primary";
	if($total_check >= 80){ $colorClass = "bg-success"; }
	if($total_check >= 50 && $total_check < 80){ $colorClass = "bg-primary"; }
	if($total_check >= 30 && $total_check < 50){ $colorClass = "bg-warning"; }
	if($total_check < 30){ $colorClass = "bg-danger"; }
	?>	
	  <div class="row">
		<div class="col-md-4" style="text-align:right"><b><?php echo $val; ?></b></div>
		<div class="col-md-6">
		<div class="progress">
		  <div class="progress-bar progress-bar-striped <?php echo $colorClass; ?>" role="progressbar" style="width: <?php echo $total_check; ?>%" aria-valuenow="<?php echo $total_check; ?>" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		</div>
		<div class="col-md-2" style="text-align:left"><b><?php echo $total_check; ?>% (<?php echo $answer_check; ?>)</b></div>
	   </div>	  
<?php } ?>
			  
</div>	
</div>

<div class="panel panel-default">
<div class="panel-heading font-weight-bold panelQ"><span class="qCircle">2</span> Rate experience based on Product Knowledge</div>
<div class="panel-body">	
<?php foreach($optionsArray_1 as $opt => $val){ ?>
	<?php
	// SURVEY 1
	$answer_check = !empty($answers['customer_experience'][$opt]) ? $answers['customer_experience'][$opt] : '0';
	$total_check = 0;
	if($total_submission > 0){
		$total_check = ($answer_check / $total_submission) * 100;
		$total_check = sprintf('%02d', $total_check);
	}
	$colorClass = "bg-primary";
	if($total_check >= 80){ $colorClass = "bg-success"; }
	if($total_check >= 50 && $total_check < 80){ $colorClass = "bg-primary"; }
	if($total_check >= 30 && $total_check < 50){ $colorClass = "bg-warning"; }
	if($total_check < 30){ $colorClass = "bg-danger"; }
	?>	
	  <div class="row">
		<div class="col-md-4" style="text-align:right"><b><?php echo $val; ?></b></div>
		<div class="col-md-6">
		<div class="progress">
		  <div class="progress-bar progress-bar-striped <?php echo $colorClass; ?>" role="progressbar" style="width: <?php echo $total_check; ?>%" aria-valuenow="<?php echo $total_check; ?>" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		</div>
		<div class="col-md-2" style="text-align:left"><b><?php echo $total_check; ?>% (<?php echo $answer_check; ?>)</b></div>
	   </div>	  
<?php } ?>
			  
</div>
</div>


<div class="panel panel-default">
<div class="panel-heading font-weight-bold panelQ"><span class="qCircle">3</span> Rate experience based on Resolution</div>
<div class="panel-body">	
<?php foreach($optionsArray_1 as $opt => $val){ ?>
	<?php
	// SURVEY 1
	$answer_check = !empty($answers['customer_resolution'][$opt]) ? $answers['customer_resolution'][$opt] : '0';
	$total_check = 0;
	if($total_submission > 0){
		$total_check = ($answer_check / $total_submission) * 100;
		$total_check = sprintf('%02d', $total_check);
	}
	$colorClass = "bg-primary";
	if($total_check >= 80){ $colorClass = "bg-success"; }
	if($total_check >= 50 && $total_check < 80){ $colorClass = "bg-primary"; }
	if($total_check >= 30 && $total_check < 50){ $colorClass = "bg-warning"; }
	if($total_check < 30){ $colorClass = "bg-danger"; }
	?>	
	  <div class="row">
		<div class="col-md-4" style="text-align:right"><b><?php echo $val; ?></b></div>
		<div class="col-md-6">
		<div class="progress">
		  <div class="progress-bar progress-bar-striped <?php echo $colorClass; ?>" role="progressbar" style="width: <?php echo $total_check; ?>%" aria-valuenow="<?php echo $total_check; ?>" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		</div>
		<div class="col-md-2" style="text-align:left"><b><?php echo $total_check; ?>% (<?php echo $answer_check; ?>)</b></div>
	   </div>	  
<?php } ?>
			  
</div>
</div>


<div class="panel panel-default">
<div class="panel-heading font-weight-bold panelQ"><span class="qCircle">4</span> Based on entire experience with the company, how likely is it that someone will recommend Mpower Energy to a friend/colleague?</div>
<div class="panel-body">	
<?php foreach($optionsArray_2 as $opt => $val){ ?>
	<?php
	// SURVEY 1
	$answer_check = !empty($answers['customer_recommend'][$opt]) ? $answers['customer_recommend'][$opt] : '0';
	$total_check = 0;
	if($total_submission > 0){
		$total_check = ($answer_check / $total_submission) * 100;
		$total_check = sprintf('%02d', $total_check);
	}
	$colorClass = "bg-primary";
	if($total_check >= 80){ $colorClass = "bg-success"; }
	if($total_check >= 50 && $total_check < 80){ $colorClass = "bg-primary"; }
	if($total_check >= 30 && $total_check < 50){ $colorClass = "bg-warning"; }
	if($total_check < 30){ $colorClass = "bg-danger"; }
	?>	
	  <div class="row">
		<div class="col-md-4" style="text-align:right"><b><?php echo $val; ?></b></div>
		<div class="col-md-6">
		<div class="progress">
		  <div class="progress-bar progress-bar-striped <?php echo $colorClass; ?>" role="progressbar" style="width: <?php echo $total_check; ?>%" aria-valuenow="<?php echo $total_check; ?>" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		</div>
		<div class="col-md-2" style="text-align:left"><b><?php echo $total_check; ?>% (<?php echo $answer_check; ?>)</b></div>
	   </div>	  
<?php } ?>
			  
</div>	
</div>




</div>		
</div>		
</div>		
		
</div>		
		
		
		
		
		
		
		
	
	</section>
</div>