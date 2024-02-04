<style>
p.chatquote{
	background-color: #fbfbfb;
    font-size: 12px;
    padding: 5px 14px;
    line-height: 1.3em;
}
p.chatimp{
	background-color:#f3e8e8;
}
.first_avi>ul{
  display:flex;
  align-items:center;
  /* border:1px solid black; */
  width: 75vw;
  justify-content:space-between;
  margin-top: .5rem;
  background-color:#f1f1f1;
  height: 2rem;
  padding: 0 0.5rem;

}
.first_avi>ul>.li_first{
  border-right:1px solid black;
  width: 5rem;
}
.first_avi>ul>.li_second{
  width: 5rem;
  /* border:1px solid black; */
  display:flex;
  align-items:center;
  justify-content:center;
}
#bold>ul>li{
  font-weight:700;
  color:black;
}
.slotUI li{
	font-size:10px!important;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #dbe1ea;
}
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/diy/avail/css/custom.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/diy/avail/css/os-theme-round-dark.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/diy/avail/css/OverlayScrollbars.css">
<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">	

  <h4>diy Availability Update
  </h4>
  <hr/>
  
  <?php if(!empty($availabilityData)){ ?>
  
<form name="frm" id="frm" method="post" action="<?php echo base_url();?>diy/add_set_availability">


<div class="panel panel-default">
  <div class="panel-heading">Update Availability</div>
  <div class="panel-body">

	<div class="row">   
    <div class="col-md-6">
	<div class="form-group">
      <label for="case">Teachers Name :</label>
      <div class="form-control" disabled name="techer_name" style="display:flex;justify-content:center; align-items:center;">
	  <?php echo $teacherDetails[0]['fname'] ." " .$teacherDetails[0]['lname']; ?></div>
      <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $teacherDetails[0]['id'];?>" required>
      <input type="hidden" name="batch_code" id="batch_code" value="<?php echo $availabilityData[0]['batch_code']; ?>" required>
    </div>
	</div>
	
	<div class="col-md-6">
	 <div class="form-group">
		  <label for="case">Course :</label>
		  <select class="form-control" name="course_id" id="course_id" readonly required>
			<option value="">-- Select Course --</option>
			<?php 
			foreach($course_master as $token){
				$checkedName = "";
				if(!empty($availabilityData)){
					if($availabilityData[0]['course_id'] == $token['id']){ $checkedName= "selected"; 
				
			?>
			<option value="<?php echo $token['id'];?>" <?php echo $checkedName; ?>><?php echo $token['name'];?></option>
			<?php } } } ?>
		  </select>
	  </div>
	</div>	
	</div>
	
	
    <div class="row">	
    <h5 style="margin-bottom:1rem;">Select From date to To date</h5>
    <div class="col-md-6">
      <div class="form-group">
        <label for="case">From Date : </label>
        <input type="text" class="form-control date_pics" value="<?php echo date('m/d/Y', strtotime($availabilityData[0]['from_date'])); ?>" placeholder="Select Date" name="select_from_date" readonly required>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="case">To Date: </label>
        <input type="text" class="form-control date_pics" value="<?php echo date('m/d/Y', strtotime($availabilityData[0]['to_date'])); ?>" placeholder="Select Date" name="select_to_date" readonly required>
      </div>
    </div>
    </div>
	   <section id="calendar-area" class="calendar-area">
    <div class="calendar-widget">
      <div class="calendar-main box">
      <div class="gmt-widget">
        <small><?php echo $timezone;?></small>
      </div>
      <table class="table table-striped">
        <thead>
        <tr>
        <th></th>
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
        <th>Sun</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach($time_slots as $token){
            
          ?>
        <tr>
        <td>
          <?php echo $token['slot_name'];?>
        </td>
        <?php
          $checkedName = "";
          if(!empty($availabilityDayData['MON'])){
            $slotDataIds = explode(',', $availabilityDayData['MON']['slot_ids']); 
            if(in_array($token['id'], $slotDataIds)){ $checkedName= "checked='checked'"; }
          }
        ?>
        <td>
          <label class="checkbox-widget">
          <input type="checkbox" name="MON[]"  value="<?php echo $token['id'];?>" <?php echo  $checkedName; ?>>
          <span class="checkmark"></span>
          </label>
        </td>
        <?php
          $checkedName = "";
          if(!empty($availabilityDayData['TUE'])){
            $slotDataIds = explode(',', $availabilityDayData['TUE']['slot_ids']); 
            if(in_array($token['id'], $slotDataIds)){ $checkedName= "checked='checked'"; }
          }
        ?>
        <td>
          <label class="checkbox-widget">
          <input type="checkbox" name="TUE[]"  value="<?php echo $token['id'];?>" <?php echo  $checkedName; ?>>
          <span class="checkmark"></span>
          </label>
        </td>
        <?php
          $checkedName = "";
          if(!empty($availabilityDayData['WED'])){
            $slotDataIds = explode(',', $availabilityDayData['WED']['slot_ids']); 
            if(in_array($token['id'], $slotDataIds)){ $checkedName= "checked='checked'"; }
          }
        ?>
        <td>
          <label class="checkbox-widget">
          <input type="checkbox" name="WED[]"  value="<?php echo $token['id'];?>" <?php echo  $checkedName; ?>>
          <span class="checkmark"></span>
          </label>
        </td>
        <?php
          $checkedName = "";
          if(!empty($availabilityDayData['THU'])){
            $slotDataIds = explode(',', $availabilityDayData['THU']['slot_ids']); 
            if(in_array($token['id'], $slotDataIds)){ $checkedName= "checked='checked'"; }
          }
        ?>
        <td>
          <label class="checkbox-widget">
          <input type="checkbox" name="THU[]"  value="<?php echo $token['id'];?>" <?php echo  $checkedName; ?>>
          <span class="checkmark"></span>
          </label>
        </td>
        <?php
          $checkedName = "";
          if(!empty($availabilityDayData['FRI'])){
            $slotDataIds = explode(',', $availabilityDayData['FRI']['slot_ids']); 
            if(in_array($token['id'], $slotDataIds)){ $checkedName= "checked='checked'"; }
          }
        ?>
        <td>
          <label class="checkbox-widget">
          <input type="checkbox" name="FRI[]"  value="<?php echo $token['id'];?>" <?php echo  $checkedName; ?>>
          <span class="checkmark"></span>
          </label>
        </td>
        <?php
          $checkedName = "";
          if(!empty($availabilityDayData['SAT'])){
            $slotDataIds = explode(',', $availabilityDayData['SAT']['slot_ids']); 
            if(in_array($token['id'], $slotDataIds)){ $checkedName= "checked='checked'"; }
          }
        ?>
        <td>
          <label class="checkbox-widget">
          <input type="checkbox" name="SAT[]"  value="<?php echo $token['id'];?>" <?php echo  $checkedName; ?>>
          <span class="checkmark"></span>
          </label>
        </td>
        <?php
          $checkedName = "";
          if(!empty($availabilityDayData['SUN'])){
            $slotDataIds = explode(',', $availabilityDayData['SUN']['slot_ids']); 
            if(in_array($token['id'], $slotDataIds)){ $checkedName= "checked='checked'"; }
          }
        ?>
        <td>
          <label class="checkbox-widget">
          <input type="checkbox" name="SUN[]"  value="<?php echo $token['id'];?>" <?php echo  $checkedName; ?>>
          <span class="checkmark"></span>
          </label>
        </td>
        </tr>
        <?php } ?>
        </tbody>
      </table>
      </div>
    </div>
    </section>
	
	<div class="row">
  
	
	<div class="col-md-12">	
	  <div class="row">	
		<h5 style="margin-bottom:1rem;">Day When you are unavailable <b style="color:red;">(Maximum 4)</b></h5>
		<?php $counter=0; foreach($unavailableData as $token){ $counter++; ?>
		<div class="col-md-3">
		  <div class="form-group">
			<label for="case">Date <?php echo $counter; ?> when you are unavailable : </label>
			<input type="text" class="form-control date_pics" value="<?php echo date('m/d/Y', strtotime($token['from_date'])); ?>" placeholder="Select Date" name="date_one_false" readonly>
		  </div>
		</div>
		<?php } ?>
		</div>
	</div>
	<hr/>
	
    
	<button  type="submit" style="height: 2.5rem;" name="submit" class="btn btn-success col-md-12" onclick="return confirm('Are you sure? you want to update')"><i class="fa fa-save"></i> Update </button>
	
	</div>
	 
    </div>
	</div>
 
    </form>
  <?php } else { ?>
  
  <div class="panel panel-default">
  <div class="panel-heading">Update Availability</div>
  <div class="panel-body">
	<div class="row">
	<br/>
	<div class="col-md-12">	
	<span class="text-danger"><b><i class="fa fa-warning"></i> Invalid Parameters!</b></span>
	</div>
	<br/><br/>
	</div>
  </div>
  </div>
  
  
  <?php } ?>

</div>
</div>
<section>
</div>
<script src="<?php echo base_url();?>assets/diy/avail/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/diy/avail/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/diy/avail/js/jquery.overlayScrollbars.js"></script>
<script>
//var j = jQuery.noConflict();
$('.box').overlayScrollbars({className       : "os-theme-round-dark",resize          : "both",
  sizeAutoCapable : true,
  paddingAbsolute : true}); 
</script>