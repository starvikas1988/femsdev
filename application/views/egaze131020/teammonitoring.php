
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


<div class="row" style="margin-top:-35px; margin-left:40%;padding-right:5px">					
<div class="col-md-2">
<div class="form-group myrealtime">
	<select class="form-control" name="officeid" id="officeid">
		<?php
			foreach($location_list as $token)
			{
				if($token['is_active'] == 1)
				{
					$varso = "";
					if($token['abbr'] == $office_now) { $varso = "selected"; } 
					echo '<option value="'.$token['abbr'].'" ' .$varso .'>'.$token['location'].'</option>';
				}
			}
		?>
	</select>
</div>
</div>


<div class="col-md-2" <?php if(!get_global_access()){ echo "style='display:none'"; } ?>>
<div class="form-group myrealtime">
	<select class="form-control" name="departmentid" id="departmentid">
		<?php
			foreach($department_list as $token)
			{
				if($token['is_active'] == 1)
				{
					$varso = "";
					if($token['id'] == $department_now) { $varso = "selected"; } 
					echo '<option value="'.$token['id'].'" ' .$varso .'>'.$token['description'].'</option>';
				}
			}
		?>
	</select>
</div>
</div>



					<div class="col-md-2" <?php if(!get_global_access()){ echo "style='display:none'"; } ?>>
					<div class="form-group myrealtime">
						<select class="form-control" name="client_id" id="client_id" required >
						    <option value="ALL">ALL</option>
							<?php foreach($client_list as $client): ?>
								<?php
								$sCss="";
								if($client['client_id']==$client_now) $sCss="selected";
								?>
								<option value="<?php echo $client['client_id']; ?>" <?php echo $sCss;?>><?php echo $client['shname']; ?></option>
								
							<?php endforeach; ?>
																	
						</select>
					</div>
					</div>
					
					<div class="col-md-2" <?php if(!get_global_access()){ echo "style='display:none'"; } ?>>
					<div class="form-group myrealtime">
						<select class="form-control" name="process_id" id="process_id">
						    <option value="0">ALL</option>
							<?php foreach($process_list as $process): ?>
								<?php
									if($process->id ==0 ) continue;
									$sCss="";
									if($process->id==$process_now) $sCss="selected";
								?>
								<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
								
							<?php endforeach; ?>
							
						</select>
					</div>
					</div>

<div class="col-md-3">
<div class="form-group myrealtime">
	<div class="input-group" id="selectdatepick" style="cursor:pointer">
		<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		<input id="selectdate" type="text" class="form-control" value="<?php echo $date_now; ?>" name="selectdate" placeholder="Select Date">
	</div>
</div>
</div>
</div>



</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="widget">
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
	
	</div>

</div>
</div>
</div>



<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Real Time Activities</h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">

<div id="example31" style="height: 400px;"></div>
	
</div>
</div>
</div>
</div>

<?php if((get_global_access() == 1) && ($errorsFound != "")){ ?>
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">ERROR LOGS</h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">

<?php echo $errorsFound; ?>
	
</div>
</div>
</div>
</div>
<?php } ?>


</section>
</div>
