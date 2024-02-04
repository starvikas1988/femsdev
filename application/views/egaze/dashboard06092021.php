
<style>
.avatar-content{
	text-align: center;
    height: 25px;
    padding: 1px;
    width: 25px;
    border-radius: 100%;
    text-transform: uppercase;
    color: rgb(255, 255, 255);
    background-color: rgb(211, 84, 0);
    font: 10px / 24px Helvetica, Arial, sans-serif;
}
.avatar-container{
	margin-right: 12px;
	position: relative;
}
.avatar-container .avatar-status{
	position: absolute;
    bottom: -6px;
    right: -1px;
    font-size: 11px;
}
.avatar-container .avatar-status.active{
	color: #27c26c;
}
.avatar-container .avatar-status.ideal{
	color: #d2d2d2;
}
.progressbar-panel .percentage-count{
	width: 35px;
	line-height: 15px;
}
.mainmenu{
    background-color: #ececec;
    padding-top: 0;
    padding-bottom: 0;
}
.date-picker{
    padding-top: 7px;
}
.date-picker .date-picker-input{
    line-height: 11px;
    text-align: center;
    border: 0;
    margin: 0 auto;
    font-size: 15px;
    background: #ececec;
}
.table thead th{
    color: rgba(0,0,0,.54);
    font-size: 12px;
    font-weight: 500;
}


.table-vertical-middle tr td {
    vertical-align: middle;
}

.table td,
.table th,
.border {
    border-color: #e5e9ec !important;
}

.table td,
.table th {
    padding: .75rem 1rem;
}

.table-dark td,
.table-dark th,
.table-dark thead th {
    border-color: #32383e !important;
}

.table-hover tbody tr:hover,
.table-striped tbody tr:nth-of-type(odd),
.table-active,
.table-active > td,
.table-active > th {
    background-color: #f8fafb;
}

.table .thead-light th {
    color: #495057;
    border-color: #e5e9ec; 
    background-color: #f8fafb;
}

.table thead th {
    vertical-align: bottom;

    border-top: none;
    border-bottom: none;
}

.table tfoot th {
    vertical-align: bottom;

    border-bottom: none;
}

.table-striped tbody tr:nth-of-type(odd),
.table-active,
.table-active > td,
.table-active > th {
    background-color: #f8fafb;
}

.media .media-body p{
    color: rgba(0,0,0,.54);
}

.media {
    display: table;
}

/*----------------------------------
reset styles
----------------------------------*/
.progress-bar-animated {
    -webkit-animation: progress-bar-stripes 1s linear infinite;
    animation: progress-bar-stripes 1s linear infinite;
}
.grid-view [class^=col-] {
    padding-top: 10px;
    padding-bottom: 10px;

    border: 1px solid rgba(86, 61, 124, .2);
    background-color: rgba(86, 61, 124, .15);
}

.grid-view {
    margin-bottom: 10px;
    padding: 0 15px;
}

.card-group {
    box-shadow: 0 1px 10px 1px rgba(115, 108, 203, .1);
}

.card {
	background-color: #fff;
    border: 1px solid #e5e9ec;
	border-radius: .25rem;
}
.card .card-header {
    padding: 1rem;

    border-bottom: 1px solid #e5e9ec; 
    background: #fff;
}
.card .card-header .card-title {
    margin-bottom: 0;

    color: #53505f;

    font-size: 18px; 
    font-weight: 500;
}
.card .card-footer {
    border-top: 1px solid #e5e9ec;
    background: transparent;
}
.card-body{
	padding: 0px 10px;
}
.card-shadow {
    border: none;
    box-shadow: 0 1px 10px 1px rgba(115, 108, 203, .1);
}

.no-shadow {
    box-shadow: none;
}

.table .table {
    background-color: #ffffff;
}
.egazetable{
	border-radius: 3px;
}
.egazetable tr th{
	border-bottom: none!important;
	padding: 15px 15px!important;
}

.egazetable tr td{
	padding: 15px 15px!important;
}

.egazetable tr th:last-child{
	border-bottom: none!important;
}

.float-left {
    float: left!important;
}

.percentage-count {
	text-align:right;
	padding-right: 5px;
}

</style>

<div class="wrap">
	<section class="app-content">
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget" style="border-radius: 3px;">
					<header class="widget-header">
						<h4 class="widget-title"><i class="fa fa-bar-chart"></i> EfficiencyX Team Report						
						<a href="<?php echo base_url('egaze/reports') ."?d=".$date_now."&office=".$office_now."&dept=".$department_now."&client=".$client_now."&process=".$process_now."&csv=yes"; ?>" class="btn btn-success btn-sm" style="padding: 1px 6px;margin-left:5px"><i class="fa fa-download"></i> Download Report</a>
						</h4>
					</header>
					
					<div class="row" style="margin-top:-35px; margin-left:40%;padding-right:5px">

					<div class="col-md-2">
					<div class="form-group myreports">
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
					
					
					<div class="col-md-2" <?php if(!isAccessGlobalEGaze()){ echo "style='display:none'"; } ?>>
					<div class="form-group myreports">
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
					
					<div class="col-md-2" <?php if(!isAccessGlobalEGaze()){ echo "style='display:none'"; } ?>>
					<div class="form-group myreports">
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
					
					<div class="col-md-2" <?php if(!isAccessGlobalEGaze()){ echo "style='display:none'"; } ?>>
					<div class="form-group myreports">
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
					<div class="form-group myreports">
						<div class="input-group" id="selectdatepick" style="cursor:pointer">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input id="selectdate" type="text" class="form-control" value="<?php echo $date_now; ?>" name="selectdate" placeholder="Select Date">
						</div>
					</div>
					</div>
					
					<div class="col-md-1">
					<div class="form-group myreports">
						<button class="btn btn-primary btn-sm searchQButton"><i class="fa fa-search"></i></button>
					</div>
					</div>
					</div>
					
					</div>
					
					
				</div>
			</div>
		</div>
	
	</section>
</div>


<?php

function display_time_view($seconds)
{
	$diff = $seconds;
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


<!--main contents start-->
<main class="main-content">			
	
	<div class="container-fluid">
		<div class="row">
				<div class="card card-shadow mb-4">
					<div class="card-body p-2">
						<div class="table table-responsive m-0">
							<table class="egazetable table m-0">
								<thead>
									<tr>
										<th scope="col" width="24%">Name</th>
										<th scope="col" style="padding: 15px 10px!important;" width="11%">Total Time Worked</th>
										<th scope="col" style="text-align:center;" width="16%">Idle Minutes %</th>
										<th scope="col" style="text-align:center;" width="16%"> Productive Apps % </th>
										<th scope="col" style="text-align:center;" width="16%"> Non-Compliance Apps % </th>
										<th scope="col" style="text-align:center;" width="16%"> Unproductive Apps %</th>
									</tr>
								</thead>
								<tbody>
								
								<?php foreach($activities as $tokenm){ 
																	
									$e_userid = $tokenm['user_id'];
									$totaltime = $apps[$e_userid]['totaltime'];
									$totalidle = $apps[$e_userid]['idletime'];
									$totalproductive = $apps[$e_userid]['productive'];
									$totalunproductive = $apps[$e_userid]['noncompliance'];
									$totalunknown = $apps[$e_userid]['unproductive'];
									
									//$totaltimeoverall = $totaltime + $totalidle;
									$totaltimeoverall = $totaltime;
									
									$idle_percent         = round(($totalidle/$totaltimeoverall) * 100);
									$productive_percent   = round(($totalproductive/$totaltimeoverall) * 100);
									$unproductive_percent = round(($totalunproductive/$totaltimeoverall) * 100);
									$unknown_percent      = round(($totalunknown/$totaltimeoverall) * 100);
									
									$userCode = "";
									$userCodeArr = explode(' ', $tokenm['fullname']);
									foreach ($userCodeArr as $w) { $userCode .= $w[0]; }
									
									$currentcolor = $colour_array[mt_rand(0,3)];
									
									$extrastyle = "background-image: url(../pimgs/blank.png);background-size: cover;";
								?>
								
									<tr>
										<th scope="row" style="padding: 10px 15px!important;">
											<div class="media">
												<div class="avatar-container">
													<div class="avatar-content"> <?php echo $userCode; ?> </div>
													<div class="avatar-status <?php if($tokenm['is_logged_in'] == 1){ echo "active"; } else { echo "ideal"; } ?>">
														<i class="fa fa-circle" aria-hidden="true"></i>
													</div>
												</div>
												<div class="media-body">
													<p class="mb-0">
													<a href="<?php echo base_url('egaze/individual?uid='.$tokenm['user_id'].'&d='.$date_now) ?>">
													<strong class=""><?php echo $tokenm['fullname']; ?></strong>
													</a>
													</p>
												</div>
											</div>
										</th>
										<td style="font-weight: 600;"><?php echo display_time_view($totaltime); ?></td>
										<td>
											<div class="form-group progressbar-panel align-items-center m-0">
												<div class="float-left percentage-count"><?php echo $idle_percent; ?>%</div>
												<div class="progress">
													<div class="progress-bar <?php echo $colour_array[2]; ?> progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $idle_percent; ?>%;" aria-valuenow="<?php echo $idle_percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</td>										
										<td>
											<div class="form-group progressbar-panel align-items-center m-0">
												<div class="float-left percentage-count"><?php echo $productive_percent; ?>%</div>
												<div class="progress">
													<div class="progress-bar <?php echo $colour_array[0]; ?> progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $productive_percent; ?>%;" aria-valuenow="<?php echo $productive_percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group progressbar-panel align-items-center m-0">
												<div class="float-left percentage-count"><?php echo $unproductive_percent; ?>%</div>
												<div class="progress">
													<div class="progress-bar <?php echo $colour_array[1]; ?> progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $unproductive_percent; ?>%;" aria-valuenow="<?php echo $unproductive_percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group progressbar-panel align-items-center m-0">
												<div class="float-left percentage-count"><?php echo $unknown_percent; ?>%</div>
												<div class="progress">
													<div class="progress-bar <?php echo $colour_array[3]; ?> progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $unknown_percent; ?>%;" aria-valuenow="<?php echo $unknown_percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
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
	</div>
</main>
<!--main contents end-->