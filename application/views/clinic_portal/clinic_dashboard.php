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
  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Clinic Dashboard</h4>
  </div>
  
  
  
  <!--<div class="col-md-6">
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
  </div> -->
  
  
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
                    <span><?php echo !empty($todays_records) ? $todays_records : '0'; ?></span>
                    Today's Entries
                </div>
            </div>
        </div>
		
		
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat bg-facebook clearfix rounded">
                <span class="mini-stat-icon"><i class="fa fa-tasks fg-facebook"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $total_records; ?></span>
                    Total Records
                </div>
            </div>
        </div>
	</div>
</div>
</div>

<div class="panel panel-default">
  <div class="panel-heading"><b>Patient Record Analytics - Year <?php echo $selected_year; ?></b></div>
  <div class="panel-body">	
	<div class="row">
	<div class="col-md-8 col-sm-8 col-xs-8">
	<?php
	if($this->uri->segment(3) == 'test'){ 
		$checkUp = array(
			"role_id" => get_role_id(),
			"role_dir" => get_role_dir(),
			"dept_id" => get_dept_id(),
			"dept_folder" => get_dept_folder(),
			"client_ids" => get_client_ids(),
			"process_ids" => get_process_ids(),
			"assigned_to" => get_assigned_to(),
			"assigned_to_name" => get_assigned_to_name(),			
			"user_office_id" => get_user_office_id(),
			"user_id" => get_user_id(),			
			"global_access" => get_global_access(),			
			"user_site_id" => get_user_site_id(),
			"user_oth_office" => get_user_oth_office(),
		);
		echo "<pre>" .print_r($checkUp, 1) ."</pre>";
	}
	?>
	
		<div style="width:100%;height:400px; padding:50px 10px">
			<canvas id="qa_2dline_graph_container"></canvas>
		</div>
	
		<!--<span class="text-danger"><b>-- No Records Availabale --</b></span>-->
	
	</div>	
	</div>	
</div>
</div>

</div>
</div>


</div>
</div>  
<section>
</div>