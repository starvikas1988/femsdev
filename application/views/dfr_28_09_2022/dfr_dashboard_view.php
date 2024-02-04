<style>
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
  font-size: 21px;
  font-weight: 600;
  /*margin-bottom: 5px;
  margin-top: 7px;*/
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
  color: #fff;
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

.bg-uber {
  background-color: #00b300 !important;
  border: 1px solid #00b300;
  color: white;
}

.fg-uber {
  color: #00b300 !important;
}

.progress{
	border-radius: 0px;
	height: 20px;
}
.progress-custom {
    display: table;
    width: 100%;
}

.progress-custom .progress{
    margin-bottom: 0;
    display: table-cell;
    vertical-align: middle;
	width:80%;
}

.progress-custom .progress-value{
    display: table-cell;
    vertical-align: middle;
	font-weight:600;	
	position:absolute;
    padding: 0 4px; /*optionally*/
}


@c1: #fa0; // chart color
@c2: #0af; // active color

/* DOUGHNUT */
div {
  width: 300px;
  height: 300px;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  margin: auto;
  position: absolute;
  background: @c1 linear-gradient(to right, @c1 50%, @c2 50%);
  color: @c2;
  border-radius: 50%;
  
  
  @keyframes spin {
    to {
      transform: rotate(180deg);
    }
  }
  
  @keyframes background {
    50% {
      background-color: currentColor;
    }
  }
  
  &::after {
    content: '';
    position: absolute;
    width: 80%;
    height: 80%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto;
    background: @bg;
    border-radius: 50%;
  }
  &::before {
    content: '';
    position: absolute;
    display: block;
    background-color: inherit;
    height: 100%;
    width: 50%;
    bottom: 0;
    right: 0;
    border-radius: ~"0 100% 100% 0 / 50%";
    transform: rotate(0);
    transform-origin: 0 50%;
    animation: 50s spin infinite linear,
               100s background infinite step-end;
    animation-play-state: paused;
    animation-delay: inherit;
  }
}

/*------ LEGEND ----------*/
.legend{
	display:inline-block;
	padding:0px 50px;
	display: inline-block;
	padding: 0px 50px;
	position: absolute;
	margin-top: 50px;
}
.legend_group{
	position:relative;
	font-weight:600;
	line-height:2em;
}
.legend_group span{
	width: 12px;
	height: 12px;
	display: block;
	position: absolute;
	margin-left: -20px;
	margin-top: 7px;
}


.stackedspin{
	width:20%;
	height:100px;
	display:inline-block;
	text-align: center;
	vertical-align:middle;
	padding: 36px 0px;
	color:#fff;
	font-weight: 600;
	font-size: 18px;
}

.stacked{
	display:block;
	margin-top:10px;
}

.stacked-text{
	width:20%;
	margin-top:4px;
	display: inline-block;
	text-align: center;
	color:#fff;
	font-weight: 600;
	font-size: 12px;
}

</style>

<div class="wrap">
<section class="app-content">
<div class="row">
<div class="col-md-12">



<div class="widget">

	<div class="row">
	<div class="col-md-2">
		<header class="widget-header">
			<h4 class="widget-title text-left">DFR Dashboard</h4>
		</header>
	</div>
	</div>
	
	<div class="widget-body">
	<div class="row">
	<form method="GET" action="">
		<div class="col-md-3">	
		<div class="form-group">
		<label>Start Date</label>
		<input type="text" class="form-control" id="start_date" name="start_date" value="<?php echo $start_date; ?>" placeholder="Start Date">
		</div>
		</div>
		
		<div class="col-md-3">	
		<div class="form-group">
		<label>End Date</label>
		<input type="text" class="form-control" id="end_date" name="end_date" value="<?php echo $end_date; ?>" placeholder="End Date">
		</div>
		</div>
		
		<div class="col-md-2">
		<div class="form-group">
		<?php 
		echo "<label>Select Location</label>";
		echo '<select name="select_office" class="form-control">';
		foreach($location_list as $key=>$value){
			$sCss=""; if($value['abbr']==$location) $sCss="selected";
			echo '<option value="'.$value['abbr'].'" '.$sCss.'>'.$value['office_name'].'</option>';
		}
		echo '</select>';
		?>
		</div>
		</div>
		
		<div class="col-md-2">
		<div class="form-group">
		<label></label>
		<input type="submit" name="searchnow" value="Search" class="btn btn-block btn-success">
		</div>
		</div>
	</form>	
	</div>
	</div>

</div>

<hr class="widget-separator">


<div class="widget">

	<div class="row">
	<div class="col-md-6">
		<header class="widget-header">
			<h4 class="widget-title text-left"><i class="fa fa-user"></i> Total Applications : <?php echo $total_application; ?></h4>
		</header>
	</div>
	</div>

<div class="widget-body">

    <div class="row">
        <div class="col-md-2 col-sm-6 col-xs-12">
            <div class="mini-stat bg-uber clearfix rounded">
                <span class="mini-stat-icon"><i class="fa fa-tasks fg-uber"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $hired_application; ?></span>
                    Hired
                </div>
            </div>
        </div>
		
		<div class="col-md-2 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-facebook rounded">
                <span class="mini-stat-icon"><i class="fa fa-bar-chart fg-facebook"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $apps_per_hire; ?></span>
                    Apps Per Hire
                </div>
            </div>
        </div>
		
		<div class="col-md-2 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-facebook rounded">
                <span class="mini-stat-icon"><i class="fa fa-bar-chart fg-facebook"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $days_to_hire; ?></span>
                    Days to Hire
                </div>
            </div>
        </div>
		
		<div class="col-md-2 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-facebook rounded">
                <span class="mini-stat-icon"><i class="fa fa-bar-chart fg-facebook"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $cost_per_hire; ?></span>
                    Cost Per Hire
                </div>
            </div>
        </div>
		
		<div class="col-md-2 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-googleplus rounded">
                <span class="mini-stat-icon"><i class="fa fa-bar-chart fg-googleplus"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo round($opened_position); ?></span>
                    Open Positions
                </div>
            </div>
        </div>
		
		<div class="col-md-2 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-googleplus rounded">
                <span class="mini-stat-icon"><i class="fa fa-bar-chart fg-googleplus"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo round($days_in_mkt); ?></span>
                    Days in MKT
                </div>
            </div>
        </div>
	</div>
	
	
</div>


<div class="widget-body">	
	<div class="row">
	
        <div class="col-md-6 col-sm-6 col-xs-12">
		<header class="widget-header bg-twitter">
			<h4 class="widget-title text-left text-white"><i class="fa fa-user"></i> Monthly Metrics (Past 12 Months)</h4>
		</header>
		
		<table class="table table-bordered table-responsive">
		<thead>
			<tr>
				<th>Month</th>
				<th>Hired</th>
				<th>Days to Hire</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($monthly_data as $tokenm){ 
		    $getwidth = "0";
			if($monthly_max_data > 0){
			     $getwidth =  round(($tokenm['hired']/$monthly_max_data)*100,2);
			     $getdays =  round(($tokenm['hireddays']/$monthly_max_days)*100,2);
			}
		?>
			<tr>
				<td style="width:30%"><?php echo $tokenm['month'] ."-" .$tokenm['year']; ?></td>
				<td style="width:35%">
				<div class="progress-custom">
					<div class="progress">
						<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $getwidth; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $getwidth; ?>%;"></div>
					</div>
					<div class="progress-value">
						<?php echo $tokenm['hired']; ?>
					</div>
				</div>
				</td>
				<td style="width:35%">
				<div class="progress-custom">
					<div class="progress">
						<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $getwidth; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $getwidth; ?>%;"></div>
					</div>
					<div class="progress-value">
						<?php echo $tokenm['hireddays']; ?>
					</div>
				</div>
				</td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
		</div>
		
		<div class="col-md-1 col-sm-6 col-xs-12">
		</div>
		
		<div class="col-md-5 col-sm-6 col-xs-12">
		<header class="widget-header bg-twitter">
			<h4 class="widget-title text-left text-white"><i class="fa fa-user"></i> Application Resources</h4>
		</header>		
		<table class="table table-bordered table-responsive">
		<thead>
			<tr>
				<th></th>
				<th># HIRED</th>
				<th>% OF HIRED</th>
				<th>CONV RATE</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($hiring_info as $tokenh){
			$getwidth = "0";
			if($monthly_max_data > 0){
			$getwidth =  round(($tokenh['count_hire']/$total_application)*100,2);
			}
		?>
			<tr>
				<td style="width:30%"><?php if(!empty($tokenh['hiring_source'])){ echo $tokenh['hiring_source']; } else { echo "Unknown"; } ?></td>
				<td style="width:15%;text-align:center;"><?php echo $tokenh['count_hire']; ?></td>
				<td style="width:15%;text-align:center;"><?php echo round(($tokenh['count_hire']/$hired_application)*100,2); ?>%</td>
				<td style="width:40%">
				<div class="progress-custom">
					<div class="progress">
						<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $getwidth; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $getwidth; ?>%;"></div>
					</div>
					<div class="progress-value">
						<?php echo $getwidth; ?>
					</div>
				</div>
				</td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
		</div>
		
		
		
		
		
		
	</div>
</div>
</div>


<div class="widget">

	<div class="row">
	<div class="col-md-6">
		<header class="widget-header">
			<h4 class="widget-title text-left">Total Cost : Rs. <?php echo round($total_cost); ?></h4>
		</header>
	</div>
	</div>
	
<div class="widget-body">		
	<div class="row">
	
	
	<div class="col-md-6">
	
	<header class="widget-header bg-twitter">
		<h4 class="widget-title text-left text-white"><i class="fa fa-user"></i> PIPELINE EFFICIENCY OF HIRING</h4>
	</header>	
   
	<!--<div class="legend">
		<div class="legend_group" style="position:relative;">
		<span style="background-color:<?php echo $color_pie[0]; ?>;"></span> APPLICATION
		</div>
		<div class="legend_group" style="position:relative;">
		<span style="background-color:<?php echo $color_pie[1]; ?>;"></span> INTERVIEWED
		</div>
		<div class="legend_group" style="position:relative;">
		<span style="background-color:<?php echo $color_pie[2]; ?>;"></span> SHORTLISTED
		</div>
		<div class="legend_group" style="position:relative;">
		<span style="background-color:<?php echo $color_pie[3]; ?>;"></span> OFFER
		</div>
		<div class="legend_group" style="position:relative;">
		<span style="background-color:<?php echo $color_pie[4]; ?>;"></span> HIRE
		</div>
	</div>-->
	
	<div class="mypiechart" style="width:500px;height:400px;display: inline-block;margin-top:10px">	
		<canvas id="pipeline_canvas"></canvas>
	</div>
	
	</div>
	
	
	<div class="col-md-6">
	
	<header class="widget-header bg-twitter">
		<h4 class="widget-title text-left text-white"><i class="fa fa-user"></i> ACTIVE PIPELINE</h4>
	</header>
	
    <div class="stacked">
	
	<div class="stackedspin" style="background-color:<?php echo $color_pie[0]; ?>"><?php echo $total_application; ?></div><div class="stackedspin" style="background-color:<?php echo $color_pie[1]; ?>"><?php echo $interview_completed; ?></div><div class="stackedspin" style="background-color:<?php echo $color_pie[2]; ?>"><?php echo $shortlisted_application; ?></div><div class="stackedspin" style="background-color:<?php echo $color_pie[3]; ?>"><?php echo $offered_application; ?></div><div class="stackedspin" style="background-color:<?php echo $color_pie[4]; ?>"><?php echo $hired_application; ?></div>
	
	<div class="stacked-text" style="color:<?php echo $color_pie[0]; ?>">APPLICATION</div><div class="stacked-text" style="color:<?php echo $color_pie[1]; ?>">INTERVIEWED</div><div class="stacked-text" style="color:<?php echo $color_pie[2]; ?>">SHORTLISTED</div><div class="stacked-text" style="color:<?php echo $color_pie[3]; ?>">OFFER</div><div class="stacked-text" style="color:<?php echo $color_pie[4]; ?>">HIRE</div>
	
	</div>
	
	</div>
	
	
	
	</div>
</div>	
	
</div>




</div>
</div>
</section>
</div>