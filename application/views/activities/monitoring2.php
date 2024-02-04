
<link rel='stylesheet' href='https://cdn.rawgit.com/AdventCoding/Timespace/e24e8fe6/css/jquery.timespace.light.css'>
<style>
html {font-family: helvetica, arial;}
.htimeline { list-style: none; padding: 0; margin: 20px 0 0; }

.htimeline .step { float: left; border-top-style: solid; border-top-width: 5px; position: relative; margin-right:1px;  margin-bottom: 15px; text-align: left; padding: 3px 0 5px 10px; background-color: #ddd; color: #333; height: 75px; vertical-align: middle; border-right: solid 1px #bbb; transition: all 0.5s ease;}
.htimeline .step:nth-child(odd) { background-color: #eee; }
.htimeline .step:first-child { border-left: solid 1px #bbb; }
.htimeline .step:hover { background-color: #ccc; border-bottom-width: 6px; }

.htimeline .step > div { margin: 0 5px; font-size: 10px; vertical-align: top; padding: 0;}

.htimeline .step.green { border-top-color: #348F50;}
.htimeline .step.orange { border-top-color: #F09819;}
.htimeline .step.red { border-top-color: #C04848;}
.htimeline .step.blue { border-top-color: #49a09d;}

.htimeline .step::before { width: 15px; height: 15px; border-radius: 50px; content: ' '; background-color: white; position: absolute; top: -10px; left: 0px; border-style: solid; border-width: 3px; transition: all 0.5s ease;}
.htimeline .step:hover::before { width: 18px; height: 18px; bottom: -12px; }
.htimeline .step.green::before {border-color: #348F50;}
.htimeline .step.orange::before {border-color: #F09819;}
.htimeline .step.red::before {border-color: #C04848;}
.htimeline .step.blue::before {border-color: #49a09d;}

.htimeline .step::after { content: attr(data-date); position: absolute; top: -20px; left: 17px; font-size: 11px; font-style: italic; color: #888}

/*TASKS*/
.htimeline .step .tasks { margin-top: 10px; }
.htimeline .step .tasks .resource {position: relative; height: 40px;}
.htimeline .step .tasks .resource::before { position: absolute; bottom: 2px; left: -5px; content: attr(data-name); font-size: 10px; font-style: italic; color: #888}
.htimeline .step .tasks .task { overflow: hidden; font-size: 10px; padding: 3px; border: solid 1px white; border-radius: 4px; min-height: 20px;}
.htimeline .step.green .tasks .task { background-color: #348F50; color: white; }
.htimeline .step.orange .tasks .task { background-color: #F09819; color: white; }
.htimeline .step.red .tasks .task { background-color: #C04848; color: white; }
.htimeline .step.blue .tasks .task { background-color: #49a09d; color: white; }
	
	
	
	
.my-custom-scrollbar {
position: relative;
max-height: 400px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}

.badge{
	color: #000;
	font-size: 12px;
	padding: 5px 7px;
    background-color: #ececec;
}	

.badge-danger{
	background-color: #6b6a6a;
	color:#fff;
}

.jqTimespaceEvent{
	margin-top:0px!important;
}
.jqTimespaceDataContainer {
	max-height: 500px!important;
}

.jqTimespaceEvent p {
    overflow: hidden;
    margin: 0;
    border: 1px solid var(--border-secondary);
    border-radius: 0 0.6rem 0.6rem 0;
    padding: 0rem;
    line-height: 1rem;
    font-size: 10px;
    white-space: nowrap;
    cursor: pointer;
    background: var(--bg-dull);
}


/* Differenct Colors */
.t_red{ background: #ffb0b0!important; }
.t_green{ background: #63ff6e!important; }
.t_orange{ background: #ffc266!important; }
.t_blue{ background: #afd1fa!important; }
.t_yellow{ background: #f9ff8c!important; }
	
</style>




<div class="wrap">
<section class="app-content">
	
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Today Activities 
<?php if($this->input->get('uid') != ""){ ?>
<a class="btn btn-primary btn-sm" href="<?php echo base_url('activities/myteam'); ?>"><i class="fa fa-arrow-left"></i> Go Back</a>
<?php } ?>
</h4>
</header>
<hr class="widget-separator"/>

	<div class="widget-body clearfix">
					
	<div class="row">
	
		<!--<div class="col-md-12">
			Current Date : <?php echo date('d M, Y h:i A'); ?><br/><br/>
		</div>-->
	
		<div class="col-md-4">
			<div class="form-group">
				<label>Fusion ID : <?php echo $mydetails['fusion_id']; ?></label><br/>
				<label>Name : <?php echo $mydetails['fullname']; ?></label>
				
			</div>
		</div>
		
		
		<div class="col-md-4">
			<div class="form-group" id="foffice_div" >
				<label>Department : <?php echo $mydetails['department_name']; ?></label><br/>
				<label>Designation : <?php echo $mydetails['designation']; ?></label>
				
			</div>
		</div>
		
	</div>
	
	
	<?php
	
	function display_time_sync($diff)
	{
		$eachset = explode(':', $diff);
		$times = "";
		if($eachset[0] > 0){ $times .= $eachset[0] ." hr "; } 
		if($eachset[1] > 0){ $times .= $eachset[1] ." min "; } 
		if($eachset[2] > 0){ $times .= $eachset[2] ." sec "; } 
		return $times;
	}
	
	function display_time_sync_two($t1, $t2)
	{
		$diff = abs(strtotime($t1) - strtotime($t2));  
		$hours = floor($diff / (60*60));
		$minutes = floor(($diff - $hours*60*60)/ 60);
		$seconds = floor(($diff - $hours*60*60 - $minutes*60));
		
		$times = "";
		if($hours > 0){ $times .= $hours ." hr "; } 
		if($minutes > 0){ $times .= $minutes ." min "; } 
		if($seconds > 0){ if($minutes <= 0) { $times .= $seconds ." sec "; } } 
		return $times;
	}
	
	?>
	
	
	
	<!--<div class="row">
	
		<form method="GET">
		
		<div class="col-md-2">
		<div class="form-group">
		<label for="start_date">Today Date</label>
		<input type="text" class="form-control"  id="start_date" value="<?php echo date('Y-m-d'); ?>" name="start_date" required="" autocomplete="off">
		</div>
		</div>
	
		<div class="col-md-2">
		<div class="form-group" id="foffice_div">
			<label>Show Last Activities</label>
			<select class="form-control" name="activity_time" id="activity_time">
				<option value="00:30:00">30 min</option>																
				<option value="01:00:00">1 hr</option>																
				<option value="02:00:00">2 hr</option>																
				<option value="04:00:00">4 hr</option>																
				<option value="06:00:00">6 hr</option>																
				<option value="12:00:00">12 hr</option>																
				<option value="24:00:00">24 hr</option>																
			</select>
		</div>
		<input type="hidden" name="user_set" id="user_set" value="<?php echo $user_now; ?>">
		</div>
					
		</form>
	
	</div>-->
	
	
	
	
	</div>

</div>
</div>
</div>



<div class="row">

<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">24-Hour Timeline</h4>
</header>
<div id="timelineClock"></div>
</div>
</div>


<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Idle Time - <i class="fa fa-clock-o"></i> <?php if($total_idle != ""){ echo $total_idle; } else { echo "N/A"; } ?></h4>
</header>
<hr class="widget-separator"/>

<div class='container-fluid'> 
  <ul class='htimeline'>
   
    <?php 
   
   foreach($myevents as $tokenteam){ 
		$difftt = $tokenteam['total_time'];  
		$display_total_time_tt = display_time_sync($difftt);
   
   ?>
   
    <li data-date='<?php echo date('h:i A', strtotime($tokenteam['start_dt'])); ?>' class='step red' style="min-width:8%">
      <div title="<?php echo $tokenteam['event_name']; ?>"><?php echo $tokenteam['event_name']; ?></div>
      <div class='tasks container-fluid'>
        <div class='resource' data-name='<?php //echo $display_total_time_tt; ?>'>
          <div class='task col-sm-12'><?php echo $display_total_time_tt; ?></div>
        </div>
      </div>
    </li>
	
   <?php } ?>
	
	
	
	
	
  </ul>
</div>	

</div>
</div>
</div>


<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Monitor Activities <a class="btn btn-primary btn-sm" onclick="window.location.reload();"><i class="fa fa-refresh"></i> Refresh</a></h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">

<div class="table-wrapper-scroll-y my-custom-scrollbar">

  <table class="table table-bordered mb-0">
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col" width="15%">#</th>
        <th scope="col">Events</th>
        <th scope="col">Log Time</th>
      </tr>
    </thead>
    <tbody>
	<?php 
	foreach($myactivities as $token){ 
	
	
		$diff = $token['total_time_spent'];  
		$display_total_time = display_time_sync($diff);
		
		$current_time = date('Y-m-d H:i:s');
		$start_time = $token['start_datetime'];
		$display_ago_time = display_time_sync_two($current_time, $start_time);
		
	
	
	?>
      <tr>
        <th scope="row" width="15%"><a href="#" class="badge badge-secondary"><i class="fa fa-calendar-o"></i> <?php echo $display_ago_time; ?> ago</a></th>
        <th scope="row">
		<a href="#" title="<?php echo $display_total_time; ?>" class="badge badge-danger"><i class="fa fa-clock-o"></i> <?php echo $display_total_time; ?></a>
		<a href="#" title="<?php echo $token['app_name']; ?>" class="badge badge-secondary"><i class="fa fa-tag"></i> App : <?php echo $token['app_name']; ?></a>
		<a href="#" title="<?php echo $token['window_title']; ?>" class="badge badge-secondary"><i class="fa fa-tag"></i> Title : <?php echo substr($token['window_title'],0,15); ?><?php if(strlen($token['window_title']) > 15){ echo "..."; } ?></a>
		</th>
		<th scope="row" width="15%">
		<a href="#" class="badge badge-secondary"><i class="fa fa-calendar"></i> <?php echo date('d M Y, h:i:s A', strtotime($token['start_datetime'])); ?> - 
		<?php echo date('d M Y, h:i:s A', strtotime($token['end_datetime']));; ?></a>
		</th>
      </tr>
	<?php } ?>
    </tbody>
  </table>

</div>


	
</div>
</div>
</div>
</div>





</section>
</div>
