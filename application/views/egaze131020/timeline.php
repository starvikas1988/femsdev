
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
	margin: 10px 0px!important;
	border-radius: 3px;
}
.egazetable tr th{
	/*border-bottom: none!important;*/
	/*padding: 15px 15px!important;*/
}

.egazetable tr td, .egazetable tr th{
	/*padding: 15px 15px!important;*/
    border: 1px solid #ddd!important;
}

.egazetable tr th:last-child{
	/*border-bottom: none!important;*/
}

.float-left {
    float: left!important;
}

.percentage-count {
	text-align:right;
	padding-right: 5px;
}

.bartimeline{
	background-color: #aaf584;
    width: 20%;
    display: block;
    line-height: 2em;
    margin-left: 10%;
	float:left;
}

span.bartimeline:hover{
	background-color: #83dc56;
    border: 2px solid #a7fd00;
}


/*------------- TOOLTIP --------------------------*/
[tooltip] {
  position: relative; /* opinion 1 */
}

/* Applies to all tooltips */
[tooltip]::before,
[tooltip]::after {
  text-transform: none; /* opinion 2 */
  font-size: .9em; /* opinion 3 */
  line-height: 1;
  user-select: none;
  pointer-events: none;
  position: absolute;
  display: none;
  opacity: 0;
}
[tooltip]::before {
  content: '';
  border: 5px solid transparent; /* opinion 4 */
  z-index: 1001; /* absurdity 1 */
}
[tooltip]::after {
  content: attr(tooltip); /* magic! */
  
  /* most of the rest of this is opinion */
  font-family: Helvetica, sans-serif;
  text-align: center;
  
  /* 
    Let the content set the size of the tooltips 
    but this will also keep them from being obnoxious
    */
  min-width: 3em;
  max-width: 21em;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  padding: 1ch 1.5ch;
  border-radius: .3ch;
  box-shadow: 0 1em 2em -.5em rgba(0, 0, 0, 0.35);
  background: #333;
  color: #fff;
  z-index: 1000; /* absurdity 2 */
}

/* Make the tooltips respond to hover */
[tooltip]:hover::before,
[tooltip]:hover::after {
  display: block;
}

/* don't show empty tooltips */
[tooltip='']::before,
[tooltip='']::after {
  display: none !important;
}

/* FLOW: UP */
[tooltip]:not([flow])::before,
[tooltip][flow^="up"]::before {
  bottom: 100%;
  border-bottom-width: 0;
  border-top-color: #333;
}
[tooltip]:not([flow])::after,
[tooltip][flow^="up"]::after {
  bottom: calc(100% + 5px);
}
[tooltip]:not([flow])::before,
[tooltip]:not([flow])::after,
[tooltip][flow^="up"]::before,
[tooltip][flow^="up"]::after {
  left: 50%;
  transform: translate(-50%, -.5em);
}

/* FLOW: DOWN */
[tooltip][flow^="down"]::before {
  top: 100%;
  border-top-width: 0;
  border-bottom-color: #333;
}
[tooltip][flow^="down"]::after {
  top: calc(100% + 5px);
}
[tooltip][flow^="down"]::before,
[tooltip][flow^="down"]::after {
  left: 50%;
  transform: translate(-50%, .5em);
}

/* FLOW: LEFT */
[tooltip][flow^="left"]::before {
  top: 50%;
  border-right-width: 0;
  border-left-color: #333;
  left: calc(0em - 5px);
  transform: translate(-.5em, -50%);
}
[tooltip][flow^="left"]::after {
  top: 50%;
  right: calc(100% + 5px);
  transform: translate(-.5em, -50%);
}

/* FLOW: RIGHT */
[tooltip][flow^="right"]::before {
  top: 50%;
  border-left-width: 0;
  border-right-color: #333;
  right: calc(0em - 5px);
  transform: translate(.5em, -50%);
}
[tooltip][flow^="right"]::after {
  top: 50%;
  left: calc(100% + 5px);
  transform: translate(.5em, -50%);
}

/* KEYFRAMES */
@keyframes tooltips-vert {
  to {
    opacity: .9;
    transform: translate(-50%, 0);
  }
}

@keyframes tooltips-horz {
  to {
    opacity: .9;
    transform: translate(0, -50%);
  }
}

/* FX All The Things */ 
[tooltip]:not([flow]):hover::before,
[tooltip]:not([flow]):hover::after,
[tooltip][flow^="up"]:hover::before,
[tooltip][flow^="up"]:hover::after,
[tooltip][flow^="down"]:hover::before,
[tooltip][flow^="down"]:hover::after {
  animation: tooltips-vert 300ms ease-out forwards;
}

[tooltip][flow^="left"]:hover::before,
[tooltip][flow^="left"]:hover::after,
[tooltip][flow^="right"]:hover::before,
[tooltip][flow^="right"]:hover::after {
  animation: tooltips-horz 300ms ease-out forwards;
}

.timeblock{
	display:block;
}
</style>

<div class="wrap">
	<section class="app-content">
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget" style="border-radius: 3px;">
					<header class="widget-header">
						<h4 class="widget-title"><i class="fa fa-bar-chart"></i> EfficiencyX Timeline</h4>
					</header>
					
					<div class="row" style="margin-top:-35px; margin-left:80%;padding-right:5px">					
					<div class="col-md-12">
					<div class="form-group">
						<div class="input-group" id="selectdatepick" style="cursor:pointer">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input id="selectdate" type="text" class="form-control" value="<?php echo $my_date; ?>" name="selectdate" placeholder="Select Date">
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

function display_time_view($t1, $t2 = "")
{
	$diff = abs(strtotime($t2) - strtotime($t1));
	if($t2 == ""){ $diff = $t1; }
	$hours = floor($diff / (60*60));
	$minutes = floor(($diff - $hours*60*60)/ 60);
	$seconds = floor(($diff - $hours*60*60 - $minutes*60));
	
	$times = "";
	if($hours > 0){ $times .= $hours ." hr "; } 
	if($minutes > 0){ $times .= $minutes ." min "; } 
	if($seconds > 0){ if($minutes <= 0) { $times .= $seconds ." sec "; } } 
	$result_array = array(
	    "diff" => $diff,
		"hours" => $hours,
		"minutes" => $minutes,
		"seconds" => $seconds,
		"times" => $times
	);
	return $result_array;
}


function get_bar_length($startdate, $enddate, $current_hour)
{
	$totalseconds = 2*60*60;
	$current_slot = sprintf('%02d', $current_hour) .":00:00";
	$start_slot = date('H:i:s', strtotime($startdate));
	$end_slot = date('H:i:s', strtotime($enddate));
	
	$time_check = display_time_view($current_slot, $start_slot);
	$seconds = $time_check['diff'];
	
	$width = round((($totalseconds - $time_check['diff'])/$totalseconds)*100, 2);
	
	$time_check = display_time_view($startdate, $enddate);
	if($time_check['diff'] > $totalseconds){ $left = round((($time_check['diff'] - $totalseconds)/$totalseconds)*100, 2); }
	if($time_check['diff'] <= $totalseconds){ $left = round((($totalseconds - $time_check['diff'])/$totalseconds)*100, 2); }
	
	$result = array( "width" => $width ."%", "left" => (100-$left) ."%" );
	return $result;
}



?>


<!--main contents start-->
<main class="main-content">			
	
	<div class="container-fluid">
		<div class="row">
				<div class="card card-shadow mb-4">
					<div class="card-body p-2">
						<div class="table m-0" style="padding: 10px 0px 12px 0px;">
							<table class="egazetable table m-0">
								<thead>
									<tr>
										<th scope="col" width="5%">Status</th>
										<th scope="col" style="padding: 15px 10px!important;" width="12%">Name</th>
										<th scope="col" style="padding: 15px 10px!important;" width="8%">Worked</th>
										<?php
										for($i=1; $i<=12; $i++){
											$nowtime = $i*2;
											$time = "2020-10-10 " .sprintf('%02d',$nowtime) .":00:00";
										?>
										<th scope="col" style="" width="<?php echo (80/12); ?>%"><?php echo date('h A',strtotime($time)); ?></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
								
								<?php foreach($activities as $tokenm){ 
								
									$totaltime = $tokenm['totaltimespent'];									
									$userCode = "";
									$userCodeArr = explode(' ', $tokenm['fullname']);
									foreach ($userCodeArr as $w) { $userCode .= $w[0]; }
									
									$currentcolor = $colour_array[mt_rand(0,3)];
									$displaytotal = display_time_view($totaltime);
									
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
												
											</div>
										</th>
										
										<td style="font-weight: 600;">
											<p class="mb-0"><strong class=""><?php echo $tokenm['fullname']; ?></strong></p>
										</td>										
										
										<td style="font-weight: 600;"><?php echo $displaytotal['times']; ?></td>										
										
										<?php
										$start = "2020-04-27 08:10:10";
										$end = "2020-04-27 08:50:10";
										for($i=1; $i<=12; $i++){ 
											$width = "20%"; $left="10%";
											if($i==5){ $width = "120%"; $left="5%";}
											if($i==6){ $width = "20%"; $left="60%";}
											if($i==10){ $width = "130%"; $left="60%";}
											
											//08:10 - 08:50
											if($i==4){
											$checker = get_bar_length($start, $end, $i*2);
											echo $checker['width'];
											echo $checker['left'];
											}
											
											
										?>
										<td>
										<div class="timeblock">
										<span class="bartimeline" tooltip="I'm up above it!" style="width:<?php echo $width; ?>;margin-left:<?php echo $left; ?>">&nbsp;</span>
										<span class="bartimeline" tooltip="I'm up above it!" style="width:10%;margin-left:90%">&nbsp;</span>
										</div>
										</td>
										<?php } ?>
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