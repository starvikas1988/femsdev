
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


.individual-user-data tbody {
      display:block;
      max-height:400px;
	  overflow-y:scroll;
}
.individual-user-data thead, .individual-user-data tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;
}
.individual-user-data thead{
    box-shadow: 0px 5px 10px 0px rgba(223,222,227,0.75);
}
.individual-user-data .table thead th{
    padding: 0.5rem 0.5rem;
}
.individual-user-data .table td{
    padding: 0.45rem 1rem;
}
.individual-user-data tbody .mCSB_inside>.mCSB_container {
    margin-right: 15px;
}

.table thead th{
    color: rgba(0,0,0,.54)!important;
    font-size: 12px!important;
    font-weight: 500!important;
}
.media .media-body p{
    color: rgba(0,0,0,.54);
}
.section-checkbox{
    position: absolute;
    z-index: 1;
    right: -7px;
    top: 1px;
}
.section-checkbox .control--checkbox{
    min-height: 20px;
    margin: 0;
}
.screencast-gallary .container{
    margin: 0;
    max-width: 1290px;
}
.text-height-0 {
  line-height: 1!important;
}
.text-height-1 {
  line-height: 1.5!important;
}
.text-height-2 {
  line-height: 2!important;
}
.text-height-3 {
  line-height: 2.5!important;
}
.text-height-4 {
  line-height: 3!important;
}
.text-height-5 {
  line-height: 3.5!important;
}
/* ============== Text Icon Scale ================= */
.fa-6 {
    font-size: 20em;
}
.fa-5 {
    font-size: 12em;
}
.fa-4 {
    font-size: 7em;
}
.fa-3 {
    font-size: 4em;
}
.fa-2 {
    font-size: 2em;
}
.fa-1 {
    font-size: 1.5em;
}
.text-capitalize{
	font-size: 14px!important;
    font-weight: 600!important;
    padding: 6px 4px!important;
	text-transform:capitalize;
}
tr.hide-table-padding td {
  padding: 0;
}

.expand-button {
	position: relative;
}

.accordion-toggle .expand-button:after
{
  position: absolute;
  left:.75rem;
  top: 50%;
  transform: translate(0, -50%);
  content: '-';
  font-size: 13px;
  background-color: #c5cdd2;
  padding: 2px 10px 0px 10px;
  cursor:pointer;
}
.accordion-toggle.collapsed .expand-button:after
{
  content: '+';
  font-size: 13px;
  background-color: #c5cdd2;
  padding: 2px 10px 0px 10px;
  cursor:pointer;
}
</style>


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
	
<div class="wrap">
	<section class="app-content">
		
		
		<div class="row">
			<div class="col-md-12" style="padding: 0px 10px;">
				<div class="widget" style="border-radius: 3px;padding-bottom: 5px;">
					<header class="widget-header">
						<h4 class="widget-title"><i class="fa fa-bar-chart"></i> EfficiencyX Individual Dashboard
						<?php if($this->input->get('uid') != ""){ ?>
						<a onclick="window.close()" class="btn btn-danger btn-sm" style="padding: 1px 6px;"><i class="fa fa-arrow-left"></i> Go Back</a>
						<?php } ?>
						</h4>
					</header>
					
					<div class="row" style="margin-top:-35px; margin-left:80%;padding-right:5px">					
					<div class="col-md-12">
					<div class="form-group">
						<!--<div class="input-group" id="selectdatepick" style="cursor:pointer">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input id="selectdate" type="text" class="form-control" value="<?php echo $my_date; ?>" name="selectdate" placeholder="Select Date">
						</div>-->
						<b><i class="fa fa-user"></i> <?php echo $mydetails['fullname']; ?></b>
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
                    <div class="col-md-12">
                        <div class="card card-shadow mb-4">
                            <div class="card-body" style="padding:15px 10px">
                                <div id="timestamp" style="height: 150px;"></div>
                            </div>
                            <div class="card-footer p-0">
                                <table class="table table-hover text-center m-0">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-left p-1 pl-3 pr-3 pb-1">
                                            <p class="lead m-0"><b>Week View</b></p>
                                        </th>
										<?php
										for($i=1;$i<=7;$i++){
											$qStrUid="";
											if($user_now!="") $qStrUid = "uid=".$user_now."&";
										?>										
                                        <th scope="col"><a title="<?php echo $date[$i]['date']; ?>" href="individual?<?php echo $qStrUid; ?>d=<?php echo $date[$i]['date']; ?>">
										<i class="fa fa-calendar"></i> <?php echo date('l', strtotime($date[$i]['date'])); ?></a>
										</th>
										<?php } ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="text-left"><p class="blockquote-footer m-0">Productivity</p></th>
											<?php 
											for($i=1;$i<=7;$i++){ 
												$productive = ($date[$i]['p_seconds']/$date[$i]['seconds']) * 100;
											?>
                                            <td>
                                                <div class="progress m-0" style="height: 12px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width:<?php echo $productive; ?>%;" aria-valuenow="<?php echo $productive; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
											<?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card card-shadow mb-4 individual-user-data position-relative">
                            <div class="card-body p-0 position-relative">
                                <table class="table table-hover text-center m-0 position-relative">
                                    <thead>
                                    <tr>
                                        <th style="width:5%;"></th>
                                        <th style="width:15%;" scope="col" class="text-capitalize"><h6 class="text-capitalize m-0 text-height-0">Time</h6></th>
                                        <th style="width:25%;" scope="col"><h6 class="text-capitalize m-0 text-height-0">App</h6></th>
                                        <th style="width:25%;" scope="col"><h6 class="text-capitalize m-0 text-height-0">Title</h6></th>
                                        <th style="width:30%;" scope="col"><h6 class="text-capitalize m-0 text-height-0">Progress Bar</h6></th>
                                    </tr>
                                    </thead>
                                    <tbody class="mCustomScrollbar">
									<?php 
									$collapser = 0; 
									foreach($activities_group as $etoken){ 
										$collapser++;
										$current_app_name = $etoken['app_name'];
										$current_records = array_filter($myactivities, function($n) use ($current_app_name){ 
															if($n['app_name'] == $current_app_name){ return $n; }
														});
										$percentage = ($etoken['total_time']/$total_time_activity['total_seconds']) * 100;
									?>
									 <tr class="accordion-toggle activityInfo collapsed" type="close" sid="<?php echo $etoken['user_id']; ?>" lid="<?php echo $collapser; ?>" date="<?php echo $date_now; ?>" appname="<?php echo $etoken['app_name']; ?>" id="accordion<?php echo $collapser; ?>" data-toggle="collapse" data-parent="#accordion<?php echo $collapser; ?>" href="#collapse<?php echo $collapser; ?>">
										<td style="text-align:left;width:5%;" class="expand-button"></td>
										<td style="text-align:left;width:15%;"><b><?php echo display_time_view($etoken['total_time']); ?></b></td>
										<td style="text-align:left;width:25%;"><?php echo $current_app_name; ?></td>
										<td style="text-align:left;width:25%;" title="<?php echo $current_app_name; ?>"><?php echo $etoken['count_records']; ?></td>
										<td style="width:30%;">
											<div class="pt-2">
												<div class="progress m-0" style="height: 12px;">
													<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentage; ?>%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</td>
									</tr>
									
									<tr class="hide-table-padding">
									<td style="width:5%;"></td>
									<td colspan="4" style="width:95%;">
									<div id="collapse<?php echo $collapser; ?>" class="collapse p-3 dataCollapser<?php echo $collapser; ?>">
									<?php //echo "<pre>".print_r($current_records, true) ."</pre>";
									//echo $etoken['app_name']; ?>
									<table>
									<?php 
									/*foreach($current_records as $token){ 
										$diff = $token['total_time_spent'];  
										$display_total_time = display_time_sync($diff);
										
										$current_time = date('Y-m-d H:i:s');
										$start_time = $token['start_datetime'];
										$display_ago_time = display_time_sync_two($current_time, $start_time);
										
										$diffsec = abs(strtotime($diff) - strtotime("00:00:00"));
										$percentage = ($diffsec/$total_time_activity['total_seconds']) * 100;
										
										//echo $diffsec .$total_time_activity['total_seconds'];echo " -- ";
										
									?>
                                        <tr>
                                            <td style="text-align:left;width:15%;padding: 0.2rem 0.2rem;"><b><?php echo $display_total_time; ?></b></td>
                                            <td style="text-align:left;width:20%;padding: 0.2rem 0.2rem;"><?php echo $token['app_name']; ?></td>
                                            <td style="text-align:left;width:20%;padding: 0.2rem 0.2rem;" title="<?php echo $token['window_title']; ?>"><?php echo substr($token['window_title'],0,30); ?><?php if(strlen($token['window_title']) > 28){ echo "..."; } ?></td>
											<td style="text-align:left;width:15%;padding: 0.2rem 0.2rem;"><?php echo $token['start_datetime_local']; ?></td>
											<td style="text-align:left;width:15%;padding: 0.2rem 0.2rem;"><?php echo $token['end_datetime_local']; ?></td>
                                            <td style="width:10%;padding: 0.2rem 0.2rem;">
                                                <div class="pt-2">
                                                    <div class="progress m-0" style="height: 12px;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentage; ?>%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
									<?php }*/ ?>
									</table>
									
									
									
									
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