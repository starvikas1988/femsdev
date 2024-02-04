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
	.element-left {
		width:auto;
		display:inline-block;
		margin:0 10px 0 0;
	}
	.green-bg-widget {
		width:100%;
		height:70px;
		display:flex;
		align-items:center;
		background:#10c469;
		padding:10px 15px;
		border-radius:5px;
	}
	.white-small {
		width: 50px;
		height: 50px;
		display: inline-block;
		line-height: 50px;
		font-size:20px;
		text-align: center;
		color: #10c469;
		border-radius:50%;
		background:#eee;		
	}
	.white-small1 {
		width: 50px;
		height: 50px;
		display: inline-block;
		line-height: 50px;
		font-size:20px;
		text-align: center;
		color: #db4a39;
		border-radius:50%;
		background:#eee;
	}
	.white-small-blue {
		width: 50px;
		height: 50px;
		display: inline-block;
		line-height: 50px;
		font-size:20px;
		text-align: center;
		color: #3b5998;
		border-radius:50%;
		background:#eee;
	}
	.count-head {
		font-size:18px;
		padding:0;
		margin:0;
		color:#fff;
		margin:0 0 5px 0;
		font-weight:bold;
	}
	.count-content {
		font-size:13px;
		padding:0;
		margin:0;
		color:#fff;		
	}
	.google-bg-widget {
		width:100%;
		height:70px;
		display:flex;
		align-items:center;
		background:#db4a39;
		padding:10px 15px;
		border-radius:5px;
	}
	.facebook-bg-widget {
		width:100%;
		height:70px;
		display:flex;
		align-items:center;
		background:#3b5998;
		padding:10px 15px;
		border-radius:5px;
	}
	.common-top {
		width:100%;
		margin:20px 0 0 0;
	}
	.main-widget {
		width:100%;
	}
	.main-widget .panel {
		margin:0;
	}
	.caller-widget .form-control {
		width: 100%;
		height: 35px;
		font-size: 14px;
		transition: all 0.5s ease-in-out 0s;
	}
	.caller-widget .form-control:hover {
		border: 1px solid #188ae2;
	}
	.caller-widget .form-control:focus {
		border: 1px solid #188ae2;
		outline: none;
		box-shadow: none;
	}
	.fliter-btn {
		width:100%;
		height:34px;
		line-height:30px;
		border-radius:5px;
		color:#fff;
		background: #5cb85c;
		border:1px solid #4cae4c;
		transition:all 0.5s ease-in-out 0s;
	}
	.fliter-btn:hover {
		background:#449d44;
	}
	.fliter-btn:focus {
		background:#449d44;
		outline:none;
		box-shadow:none;
	}
	.main-widget .panel-default > .panel-heading {
		background-color: #f7f7f7;
	}
	.main-widget .panel-heading {
		font-size:16px;
	}
</style>
<div class="wrap">
<section class="app-content">

<div class="widget">
<div class="widget-body">
  <div class="row">
		  <div class="col-md-6">
			<h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Contact Tracing Overview</h4>
		  </div>
	  <div class="col-md-6">
		<div class="caller-widget">
			<div class="row pull-right">
			<form id="form_new_user"  method="GET" action="" autocomplete="off">
				<div class="col-md-5">
					<div class="form-group">
						<input type="text" id="search_from_date" name="start" value="<?php if(!empty($from_date)){ echo date('m/d/Y', strtotime($from_date)); } ?>" class="form-control" required>
					</div>
				</div>
				<div class="col-md-5"> 
					<div class="form-group">
						<input type="text" id="search_to_date" name="end" value="<?php if(!empty($to_date)){ echo date('m/d/Y', strtotime($to_date)); } ?>" class="form-control" required>
					</div> 
				</div>							
				<div class="col-md-2">
					<button class="fliter-btn" type="submit" value="View"><i class="fa fa-search"></i></button>
				</div>		
			</form>
			</div>
		</div>
	  </div>
	  </div>

<div class="main-widget">  
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">	 
				<div class="panel-body">    
					<div class="row">		
						<div class="col-md-4">
						<a href="<?php echo base_url() ."howard_training/case_list?start_date=".$from_date."&end_date=".$to_date; ?>">
							<div class="green-bg-widget">
								<div class="element-left">
									<div class="white-small">
										<i class="fa fa-bar-chart"></i>
									</div>
								</div>
								<div class="element-left">
									<h3 class="count-head">
										<?php echo $todays_records; ?>
									</h3>
									<h4 class="count-content">
										Current Entries
									</h4>
								</div>
							</div>
						</a>
						</div>
						
						<div class="col-md-4">
						 <a href="<?php echo base_url() ."howard_training/case_list?case_status=P&start_date=".$from_date."&end_date=".$to_date; ?>">			
							<div class="google-bg-widget">
								<div class="element-left">
									<div class="white-small1">
										<i class="fa fa-bar-chart"></i>
									</div>
								</div>
								<div class="element-left">
									<h3 class="count-head">
										<?php echo $caseStatus['today']['open']; ?>
									</h3>
									<h4 class="count-content">
										Cases Open
									</h4>
								</div>
							</div>
						  </a>
						</div>
						
						
						<div class="col-md-4">
						<a href="<?php echo base_url() ."howard_training/case_list?case_status=P"; ?>">
							<div class="facebook-bg-widget">
								<div class="element-left">
									<div class="white-small-blue">
										<i class="fa fa-tasks"></i>
									</div>
								</div>
								<div class="element-left">
									<h3 class="count-head">
										<?php echo $caseStatus['total']['open'] ."/" .$total_records; ?>
									</h3>
									<h4 class="count-content">
										Total Open Cases
									</h4>
								</div>
							</div>
							
						</a>
						</div>
						
						<!--<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="<?php echo base_url() ."howard_training/case_list"; ?>">
							<div class="mini-stat bg-facebook clearfix rounded">
								<span class="mini-stat-icon"><i class="fa fa-tasks fg-facebook"></i></span>
								<div class="mini-stat-info">
									<span><?php echo $total_records; ?></span>
									Total Records
								</div>
							</div>
						</a>
						</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


</div>
	
</div>

<div class="main-widget">
	<div class="common-top">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<b>Contact Tracing Records</b>
					</div>
					  <div class="panel-body">	
						<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
						<?php if($todays_records > 0){ ?>
							<div style="width:100%;height:300px; padding:50px 10px">
								<canvas id="qa_2dpie_graph_container"></canvas>
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
	</div>
	<div class="common-top">
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<b>Contact Tracing Location wise Cases</b>
					</div>
					  <div class="panel-body">	
						<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
						<?php if($todays_records > 0){ ?>
							<div style="width:100%;height:300px; padding:50px 10px">
								<canvas id="qa_2dpie_graph_container_loc"></canvas>
							</div>
						<?php } else { ?>
							<span class="text-danger"><b>-- No Records Availabale --</b></span>
						<?php } ?>
						</div>	
						</div>	
					</div>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<b>Contact Tracing Agent wise Cases</b>
					</div>
					  <div class="panel-body">	
						<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
						<?php if($todays_records > 0){ ?>
							<div style="width:100%;height:300px; padding:50px 10px">
								<canvas id="qa_2dpie_graph_container_agent"></canvas>
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
	  </div>
	</div>

<section>
</div>