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

<table>
<?php 
foreach($current_records as $token){ 
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
<?php } ?>
</table>