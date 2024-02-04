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
  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Alpha Gas CRM</h4>
  </div>
  <div class="col-md-6">
	<div class="row pull-right">
	<form id="form_new_user"  method="GET" action="" autocomplete="off">
		<div class="col-md-4">
			<div class="form-group">
				<input type="text" id="search_from_date" name="start" value="<?php if(!empty($from_date)){ echo date('m/d/Y', strtotime($from_date)); } ?>" class="form-control" required>
			</div>
		</div>
		<div class="col-md-4"> 
			<div class="form-group">
				<input type="text" id="search_to_date" name="end" value="<?php if(!empty($to_date)){ echo date('m/d/Y', strtotime($to_date)); } ?>" class="form-control" required>
			</div> 
		</div>							
		<div class="col-md-2">
			<button class="btn btn-success waves-effect" type="submit" value="View"><i class="fa fa-search"></i></button>
		</div>		
	</form>
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
                    <span><?php echo $todays_records; ?></span>
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
  <div class="panel-heading"><b>Alpha Gas Analytics - <i class="fa fa-calendar"></i> <?php echo $from_date != $to_date ? date('d M', strtotime($from_date)) ." - " .date('d M Y', strtotime($to_date)) : date('d M Y', strtotime($from_date)); ?></b></div>
  <div class="panel-body">	
	<div class="row">
	<div class="col-md-4 col-sm-4 col-xs-12">
	<?php if($todays_records > 0){ ?>
		<div style="width:100%;height:300px; padding:50px 10px">
			<canvas id="qa_2dpie_graph_container"></canvas>
		</div>
	<?php } else { ?>
		<span class="text-danger"><b>-- No Records Availabale --</b></span>
	<?php } ?>
	</div>
	
	
	<div class="col-md-8 col-sm-8 col-xs-12">
	<h4 class="text-center"><i class="fa fa-user"></i> User Analytics</h4>
	<hr/>
		<?php foreach($allUsers as $uid){ ?>
			<?php
			$total_check = $month[$currMonth]['user'][$uid];
			$percent_check = sprintf('%02d', round(($total_check / $allTotal) * 100));
			$colorClass = "bg-primary";
			if($total_check >= 80){ $colorClass = "bg-success"; }
			if($total_check >= 50 && $total_check < 80){ $colorClass = "bg-primary"; }
			if($total_check >= 30 && $total_check < 50){ $colorClass = "bg-warning"; }
			if($total_check < 30){ $colorClass = "bg-danger"; }
			?>
			
			  <div class="row">
				<div class="col-md-4" style="text-align:right"><b><?php echo ucwords(strtolower($monthly['userinfo'][$uid]['name'])); ?></b></div>
				<div class="col-md-6">
				<div class="progress">
				  <div class="progress-bar progress-bar-striped <?php echo $colorClass; ?>" role="progressbar" style="width: <?php echo $percent_check; ?>%" aria-valuenow="<?php echo $percent_check; ?>" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				</div>
				<div class="col-md-2" style="text-align:left"><b><?php echo $percent_check; ?>% (<?php echo $total_check; ?>)</b></div>
			  </div>	  
		<?php } ?>
	</div>	
	
	</div>	
</div>
</div>




<div class="panel panel-default">
  <div class="panel-heading"><b>Alpha Gas - Daywise Analytics - <i class="fa fa-calendar"></i> <?php echo date('F Y', strtotime($currYear ."-".$currMonth."-01")); ?></b></div>
  <div class="panel-body">	
	<div class="row">	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div style="width:100%;height:300px; padding:50px 10px">
			<canvas id="qa_2dbar_graph_container"></canvas>
		</div>
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