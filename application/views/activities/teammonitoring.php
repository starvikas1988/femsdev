
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
.table th{ font-size:12px; }	
</style>




<div class="wrap">
<section class="app-content">
	
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Today Activities <?php //echo " - " .date('d M, Y'); ?></h4>
</header>
<hr class="widget-separator"/>

	<div class="widget-body clearfix">
	
				
	<div class="row">
	
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
	
	<div class="row">
	<hr/>
	
	<form method="GET">
		
		<div class="col-md-4">
		<div class="form-group">
		<input type="text" class="form-control"  placeholder="Enter Name/ Fusion ID" id="qsearch" value="<?php echo $searchingq; ?>" name="qsearch">
		</div>
		</div>
	
		<div class="col-md-4">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Search</button>
		
		<?php if($searchingq != ""){ ?>
			<a href="<?php echo base_url('activities/myteam'); ?>" class="btn btn-success">View All</a>
		<?php } ?>
		</div>
		</div>
		
		
					
	</form>
	</div>
	
	
	</div>

</div>
</div>
</div>



<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Team Members</h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">

<div class="">

  <table class="table table-bordered mb-0">
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
        <th scope="col" style="width:20%">Fusion ID</th>
        <th scope="col" style="width:10%" class="text-center">Idle Time</th>
		<th scope="col">Recent Activities</th>
      </tr>
    </thead>
    <tbody>
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
	
	$countc = 0;
	foreach($myteam as $token){ 
	
		$countc++;
		$uidteam = $token['user_id'];
		
	?>
      <tr>
        <th scope="row"><?php echo $countc; ?></th>
        <th scope="row"><?php echo $token['fusion_id']; ?><br/>
        <a href="<?php echo base_url() ."activities/monitor?uid=". $uidteam; ?>"><?php echo $token['fullname']; ?> <i class="fa fa-eye"></i></a><br/>
        <?php echo $token['designation']; ?></th>
		
		<th scope="row" class="text-center"><?php echo $totalidle[$uidteam]; ?></th>
		
        <th scope="row">
		
		  <ul class='htimeline'>
		   
		   <?php 
		   
		   foreach($team[$uidteam] as $tokenteam){ 
				$diff = $tokenteam['total_time_spent'];  
				$display_total_time = display_time_sync($diff);
		   
		   ?>
		   
			<li data-date='<?php echo date('h:i A', strtotime($tokenteam['start_datetime'])); ?>' class='step orange'>
			  <div title="<?php echo $tokenteam['window_title']; ?>"><?php echo substr($tokenteam['window_title'],0,15); ?><?php if(strlen($tokenteam['window_title']) > 15){ echo "..."; } ?></div>
			  <div class='tasks container-fluid'>
				<div class='resource' data-name='<?php echo $display_total_time; ?>'>
				  <div class='task col-sm-12'><?php echo $tokenteam['app_name']; ?></div>
				</div>
			  </div>
			</li>
			
		   <?php } ?>
			
		  </ul>
		
		
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
