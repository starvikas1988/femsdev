
<style>

#bargraphHorizontal{
  font:12px Arial;
  border:1px solid #ccc;
}
#bargraphHorizontal th{
  font-weight:normal;
}
#bargraphHorizontal td{
  padding:1px 0;
  margin:0;
  vertical-align:middle;
}
#bargraphHorizontal td div{
  border-radius:50px;
  height:8px;
  display:inline-block;
}

#bargraphHorizontal td div .valuelabel{
  
}

#bargraphHorizontal .label{
  text-align:right;
  color:#000;
}
#bargraphHorizontal .val{
  text-align:left;
}
#bargraphHorizontal img{
  vertical-align:middle;
}
</style>


<div class="wrap">
<section class="app-content">
	
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Team Dashboard <?php //echo " - " .date('d M, Y'); ?></h4>
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
	
	</div>

</div>
</div>
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

<div class="row">
<div class="col-md-6">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Top Used Websites & Applications</h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix" style="">

<table id="bargraphHorizontal" style="width:100%;border:none;">
<tbody>
  <tr>
    <th style="width:20%" class="label">&nbsp;</th>
    <th style="width:90%" class="val">&nbsp;</th>
  </tr>
  <?php 
    $count = 0;
	$totalcheck = 0;
	foreach($top_productive as $token){ 
		$count++;
		$app_name = $token['app_name'];
		$total_min = display_time_view($token['totaltimespent']);
		if($count == 1){ $totalcheck =  $total_min; }
		$getpercent = ($total_min / $totalcheck) * 90;
  ?>
  <tr>
    <td class="label"><?php echo $app_name; ?></td>
    <td class="val" style="padding:2px 0px"><div style="width:<?php echo $getpercent; ?>%;margin-left:5px;background-color:green">&nbsp;</div> <div> <?php echo $total_min; ?></div></td>
  </tr>
  <?php } ?>
  </tbody>
 </table>
	
</div>
</div>
</div>


<div class="col-md-6">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Top Used Unproductive Websites & Applications</h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">


<table id="bargraphHorizontal" style="width:100%;border:none;">
<tbody>
  <tr>
    <th style="width:20%" class="label">&nbsp;</th>
    <th style="width:90%" class="val">&nbsp;</th>
  </tr>
  <?php 
    $count = 0;
	$totalcheck = 0;
	foreach($top_unproductive as $token){ 
		$count++;
		$app_name = $token['app_name'];
		$total_min = display_time_view($token['totaltimespent']);
		if($count == 1){ $totalcheck =  $total_min; }
		$getpercent = ($total_min / $totalcheck) * 90;
  ?>
  <tr>
    <td class="label"><?php echo $app_name; ?></td>
    <td class="val" style="padding:2px 0px"><div style="width:<?php echo $getpercent; ?>%;margin-left:5px;background-color:red">&nbsp;</div> <div> <?php echo $total_min; ?></div></td>
  </tr>
  <?php } ?>
  </tbody>
 </table>

	
</div>
</div>
</div>
</div>



<div class="row">

<div class="col-md-6">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Usage with Highest Hours</h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">


<table id="bargraphHorizontal" style="width:100%;border:none;">
<tbody>
  <tr>
    <th style="width:20%" class="label">&nbsp;</th>
    <th style="width:90%" class="val">&nbsp;</th>
  </tr>
  <?php 
    $count = 0;
	$totalcheck = 0;
	foreach($top_emp_hours as $token){ 
		$count++;
		$user_id = $token['user_id'];
		$full_name = array_search($user_id, array_column($myteam, 'user_id'));
		$app_name = $token['app_name'];
		$total_min = display_time_view($token['totaltimespent']);
		if($count == 1){ $totalcheck =  $total_min; }
		$getpercent = ($total_min / $totalcheck) * 80;
  ?>
  <tr>
    <td class="label"><?php echo $myteam[$full_name]['fullname']; ?></td>
    <td class="val" style="padding:2px 0px"><div style="width:<?php echo $getpercent; ?>%;margin-left:5px;background-color:green">&nbsp;</div> <div> <?php echo $total_min; ?></div></td>
  </tr>
  <?php } ?>
  </tbody>
 </table>

	
</div>
</div>
</div>



<div class="col-md-6">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Usage with Lowest Hours</h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix" style="">

<table id="bargraphHorizontal" style="width:100%;border:none;">
<tbody>
  <tr>
    <th style="width:20%" class="label">&nbsp;</th>
    <th style="width:90%" class="val">&nbsp;</th>
  </tr>
  <?php 
    $count = 0;
	$totalcheck = 0;
	foreach($less_emp_hours as $token){ 
		$count++;
		$user_id = $token['user_id'];
		$full_name = array_search($user_id, array_column($myteam, 'user_id'));
		$total_min = display_time_view($token['totaltimespent']);
		if($count == 1){ $totalcheck =  $total_min; }
		$getpercent = ($total_min / $totalcheck) * 80;
  ?>
  <tr>
    <td class="label"><?php echo $myteam[$full_name]['fullname']; ?></td>
    <td class="val" style="padding:2px 0px"><div style="width:<?php echo $getpercent; ?>%;margin-left:5px;background-color:red">&nbsp;</div> <div> <?php echo $total_min; ?></div></td>
  </tr>
  <?php } ?>
  </tbody>
 </table>
	
</div>
</div>
</div>

</div>



</section>
</div>
