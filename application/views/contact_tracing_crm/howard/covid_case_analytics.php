 <style>

	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:4px;
		font-size:11px;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}

	.inputTable > tr > td{
		font-size:12px;
		padding:4px;
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
	
</style>
<div class="wrap">
<section class="app-content">

<div class="widget">
<div class="widget-body">
  <div class="row">
  <div class="col-md-6">
  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Conact Tracing Analytics Overview</h4>
  </div>
  <div class="col-md-6">
	<div class="row pull-right">
	<div class="col-md-6">
		<select style="width:150px" class="form-control" name="monthSelect" id="monthSelect">
			<?php
			for($i=1; $i<=12; $i++){
				$setSelection = "";
				$currDate = date('Y')."-".sprintf('%02d', $i)."-01";
				if($i == $selected_month){ $setSelection = "selected"; }
			?>
				<option value="<?php echo date('m', strtotime($currDate)); ?>" <?php echo $setSelection; ?>><?php echo date('F', strtotime($currDate)); ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-6">
		<select style="width:150px" class="form-control" name="yearSelect" id="yearSelect">
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
  </div>
  </div>
  <hr style="margin-top: 10px;">
  
<div class="row">
<div class="col-md-12">


<div class="panel panel-default">	 
<div class="panel-body">    
	<div class="row">		
		<div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix  bg-googleplus rounded">
                <span class="mini-stat-icon"><i class="fa fa-bar-chart fg-googleplus"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $months[round($selected_month)]['total']['positive']; ?></span>
                    Positive Cases
                </div>
            </div>
        </div>
		
		
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat bg-facebook clearfix rounded">
                <span class="mini-stat-icon"><i class="fa fa-tasks fg-facebook"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $months[round($selected_month)]['total']['negative']; ?></span>
                    Negative Cases
                </div>
            </div>
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat bg-success clearfix rounded">
                <span class="mini-stat-icon"><i class="fa fa-tasks fg-facebook"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo count($months[round($selected_month)]['locations']['cases']); ?></span>
                    Locations Found
                </div>
            </div>
        </div>
	</div>
</div>
</div>


<div class="panel panel-default">
  <div class="panel-heading"><b>Zovio Case Analytics : <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?></b>
  <a href="<?php echo current_url().'?ex=cases&m='.$selected_month.'&y='.$selected_year; ?>" class="row btn btn-primary brn-sm pull-right exportGraphCasesExcel"><i class='fa fa-file-excel-o'></i> Export Excel</a>
  </div>
  <div class="panel-body">
<div class="row">
<div class="col-md-6">
<div id="team_2dbar_cases_positive" style="width:100%;height:400px; padding:10px 20px"></div>
</div>
<div class="col-md-6">
<div id="team_2dbar_cases_negative" style="width:100%;height:400px; padding:10px 20px"></div>
</div>
</div>
  </div>
</div>




<div class="panel panel-default">
  <div class="panel-heading"><b>Weekly Case : <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?></b></div>
  <div class="panel-body">
<div class="row">

<?php
$current_dataSet = $months[round($selected_month)];
$weekSl = 0;
for($i=0; $i<$current_dataSet['weekcount']; $i++){ 
if(date('Y-m-d') >= $current_dataSet['weekly'][$i]['start']){
	 ++$weekSl;
?>

<div class="col-md-6">
<div id="team_2dbar_cases_week_positive_<?php echo $weekSl; ?>" style="width:100%;height:400px; padding:10px 20px"></div>
</div>

<div class="col-md-6">
<div id="team_2dbar_cases_week_negative_<?php echo $weekSl; ?>" style="width:100%;height:400px; padding:10px 20px"></div>
</div>
<?php } } ?>

</div>
  </div>
</div>















</div>
</div>


</div>
</div>  
<section>
</div>