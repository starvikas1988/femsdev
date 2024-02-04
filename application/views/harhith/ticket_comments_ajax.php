<style>
#recordDetailsModal p.boxInfo{
	font-size:13px;
	color:#685f5f;
}
#recordDetailsModal p span{
	font-size:13px;
	font-weight:600;
	color:#684f4f;
}
</style>

<div class="row">

<div class="col-md-12">
<h5><i class="fa fa-bell"></i> INFO DETAILS</h5>
<hr style="margin-top:5px;margin-top:5px" />
<p class="boxInfo">
<span><b>TICKET NO : </b></span><?php echo $tickets_list[0]['ticket_no']; ?><br/>
<span><b>STATUS : </b></span><span class="font-weight-bold text-<?php echo hth_ticket_status_color($tickets_list[0]['ticket_status']); ?>"><?php echo hth_ticket_status($tickets_list[0]['ticket_status']); ?></span><br/>
</p>
</div>

</div>

<hr/>

<div class="row">

<div class="col-md-12">
<h5><i class="fa fa-pie-chart"></i> COMMENTS</h5>
<hr style="margin-top:5px;margin-top:5px" />
<p class="boxInfo">
<?php 
$comments = 0;
if(!empty($tickets_logs)){ 
foreach($tickets_logs as $ltoken){ 
if($ltoken['log_type'] == "comments"){
	$comments++;
?>
<span><b><?php echo $ltoken['agent_name']; ?> : <?php echo $ltoken['date_added']; ?><br/></b></span><?php echo !empty($ltoken['log_comments']) ? $ltoken['log_comments'] : "n/a"; ?><br/><br/>
<?php } } } if($comments == 0){ ?>
<span class="text-danger">-- No Comments Found --</span>
<?php } ?>
</p>
</div>

</div>

<hr/>

<div class="row">

<div class="col-md-12">
<h5><i class="fa fa-pie-chart"></i> LOGS</h5>
<hr style="margin-top:5px;margin-top:5px" />
<p class="boxInfo">
<?php 
$status = 0;
if(!empty($tickets_logs)){ 
foreach($tickets_logs as $ltoken){ 
if($ltoken['log_type'] == "status"){
	$status++;
?>
<span><b><?php echo $ltoken['client_name']; ?> : <?php echo $ltoken['date_added']; ?><br/></b></span>
<?php 
if($ltoken['log_status'] == "A"){
	echo "Assigned To : " .$ltoken['client_name_reference']; 
} else {
	echo hth_ticket_status($ltoken['log_status']) ." : ";
	echo !empty($ltoken['log_comments']) ? $ltoken['log_comments'] : "n/a"; 
}
?>
<br/><br/>
<?php } } } if($status == 0){ ?>
<span class="text-danger">-- No Logs Found --</span>
<?php } ?>
</p>
</div>

</div>