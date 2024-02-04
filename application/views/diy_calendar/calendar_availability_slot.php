<style>
.slotDIV .slotButton{
	margin:1px 0px!important;
}
#slots_selected .slotShowButton{
	margin:2px 1px!important;
}
.slotDIV button.in{
	background-color:#196f24!important;
	border-color:#196f24!important;
}
.header_slot{
	font-size:16px!important;
}
.header_slot_section{
	background-color: #eee;
    padding: 10px 0px 10px 10px;
    font-size: 14px;
    font-weight: 600;
}
.slotDIV::-webkit-scrollbar {
    width: 4px;
}
/* Track */
.slotDIV::-webkit-scrollbar-track {
    /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.8);*/ 
    -webkit-border-radius: 10px;
    background-color:#fff;
    border-radius: 10px;
}
/* Handle */
.slotDIV::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background:#c5bebe; 
    /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);*/
}
</style>

<div class="row">
<div class="col-md-12">


<div class="row">
<div class="col-md-8">


<div class="slotFormGroup" style="padding:20px 20px;">

<div class="row">
<h4 class="header_slot_section"> <i class="fa fa-user"></i> Teacher Info</h4>
</div>
<div class="row">
 <div class="col-md-6">
  <div class="form-group">
	Teacher : <b><?php echo $teacherDetails['fname'] ." " .$teacherDetails['lname']; ?></b>
  </div>
 </div>
 <div class="col-md-6">
  <div class="form-group">
  Teacher Timezone : <b><?php echo $teacherDetails['gmtCountryName']; ?></b>
  </div>
 </div>
</div>

<div class="row">
 <div class="col-md-12">
  <div class="form-group">
	Current Active Timezone : <b><?php echo $my_gmt_timezone_name; ?></b>
	<br/><span class="text-danger">NOTE : Please choose slot time based on your timezone as shown above</span>
  </div>
 </div>
</div>

<hr style="margin-top: 10px;margin-bottom: 10px;" /> 

<div class="row">
<h4 class="header_slot_section"> <i class="fa fa-calendar-o"></i> Availability Info</h4>
</div>
<form method="POST" action="<?php echo base_url('diy_calendar/calendar_availability_slot_data_submission'); ?>">

<div class="row">
 <div class="col-md-6">
  <div class="form-group">
	<label for="case">From Date : </label>
	<input type="date" class="form-control date_pic" autocomplete="off" value="<?php echo $calendar_date; ?>"  name="s_from_date" required <?php echo $cl_type == "edit" ? "readonly" : ""; ?>>
  </div>
 </div>
 <div class="col-md-6">
  <div class="form-group">
	<label for="case">To Date: </label>
	<input type="date" class="form-control date_pic" autocomplete="off" value="<?php echo $calendar_date; ?>"  name="s_to_date" required <?php echo $cl_type == "edit" ? "readonly" : ""; ?>>
  </div>
 </div>
</div>

<div class="row">
 <div class="col-md-6">
  <div class="form-group">
	<label for="case">From Time : (optional)</label>
	<select name="slot_from_time" class="form-control">
	<option value="">-- Select Slot</option>
	<?php 
	foreach($slot_list as $token){ 
		$selected = "";
		$getStartTime = $token['start_time'];
		if(strtolower($token['slot_name']) == "12 am"){ $getStartTime = "00:00:00"; }
		if(strtolower($token['slot_name']) == "12.30 am"){ $getStartTime = "00:30:00"; }
	?>
	<option value="<?php echo $token['id']; ?>" stime="<?php echo $getStartTime; ?>"><?php echo date('h:i A', strtotime($token['start_time'])); ?></option>
	<?php } ?>
	</select>
  </div>
 </div>
 <div class="col-md-6">
  <div class="form-group">
	<label for="case">To Time : (optional)</label>
	<select name="slot_to_time" class="form-control">
	<option value="">-- Select Slot</option>
	<?php 
	foreach($slot_list as $token){ 
		$selected = "";
		$getStartTime = $token['start_time'];
		if(strtolower($token['slot_name']) == "12 am"){ $getStartTime = "00:00:00"; }
		if(strtolower($token['slot_name']) == "12.30 am"){ $getStartTime = "00:30:00"; }
	?>
	<option value="<?php echo $token['id']; ?>" stime="<?php echo $getStartTime; ?>"><?php echo date('h:i A', strtotime($token['start_time'])); ?></option>
	<?php } ?>
	</select>
  </div>
 </div>
</div>

<div class="row"> 
 <div class="col-md-12">
  <div class="form-group">
	<label for="case">Slots Available</label>
	<input type="hidden" name="cl_slot_ids" value="">
	<input type="hidden" name="cl_gmt_time" value="<?php echo $my_gmt_timezone; ?>">
	<input type="hidden" name="cl_teacher_id" value="<?php echo $teacherDetails['id']; ?>">
	<input type="hidden" name="cl_course_id" value="<?php echo $teacherDetails['course_id']; ?>">
	<input type="hidden" name="cl_type" value="<?php echo $cl_type; ?>">
  </div>
 </div>
 
 <div class="col-md-12">
   <div id="slots_selected" style="width:100%">
	  <span class="text-danger">-- No Slots Slected --</span><br/>
   </div>
 </div>
</div>

<hr/>

<div class="row"> 
  <div class="col-md-12">
  <div class="form-group">
	<button type="submit" name="slot_submission" style="width: 110px;" class="btn btn-primary disabled"><i class="fa fa-paper-plane"></i> Save</button>
  </div>
 </div>
</div>

</form>

</div>

</div>

<div class="col-md-4">
<h2 class="header_slot"><i class="fa fa-clock-o"></i>  Select Slot</h2>
<div class="slotGroup" style="padding:10px 2px;">
<div class="slotDIV" style="width:200px;height:400px;overflow-y:scroll">
<?php 
//echo'<pre>';print_r($availabilityIndexed);
foreach($slot_list as $token){ 
	$selected = "";
	if(!empty($availabilityIndexed[$token['id']])){ $selected = "in"; }
	if(!empty($availabilityIndexed[$token['id']]) && !empty($availabilityIndexed[$token['id']]['schedule_id'])){ $selected = "in disabled"; }
	if(!empty($availabilityIndexed[$token['id']]) && !empty($availabilityIndexed[$token['id']]['is_leave'])){ $selected = "disabled"; }
	if(!empty($availabilityIndexed[$token['id']]) && empty($availabilityIndexed[$token['id']]['is_approved'])){ $selected = "in disabled"; }
	if(!empty($availabilityIndexed[$token['id']]) && !empty($availabilityIndexed[$token['id']]['is_approved']) && get_role()=="teacher"){ $selected = "in disabled"; }
	if(!empty($availabilityIndexed[$token['id']]) && !empty($availabilityIndexed[$token['id']]['is_approved'])){ $selected .= " approved_check "; }
	
	$getStartTime = $token['start_time'];
	if(strtolower($token['slot_name']) == "12 am"){ $getStartTime = "00:00:00"; }
	if(strtolower($token['slot_name']) == "12.30 am"){ $getStartTime = "00:30:00"; }
?>
<button eid="<?php echo $token['id']; ?>" stime="<?php echo $getStartTime; ?>" class="btn btn-danger slotButton <?php echo $selected; ?>" style="width:100%"><?php echo date('h:i A', strtotime($token['start_time'])); ?></button>
<?php } ?>

</div>
</div>

</div>
</div>






</div>
</div>