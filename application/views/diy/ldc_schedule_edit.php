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
</style>

<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">	

  <h4>Edit Schedule
  <p class="timerClock pull-right"><i class="fa fa-clock-o"></i> <span id="timeWatch"></span></p>
  </h4>
  <hr/>
  <?php 
		if($this->session->flashdata('response')){
  		echo $this->session->flashdata('response');
		  if(isset($_SESSION['response'])){
			unset($_SESSION['response']);
		}
		}
  ?>
<form name="frm" id="frm" method="post" action="<?php echo base_url('diy/update_schedule_data');?>">
	
	
<div class="panel panel-default">
  <div class="panel-body">
		<h1><?php echo @$this->input->get('m');?></h1><br>

	<input type="hidden" name="id" id="id" value="<?php echo $scheduleData[0]['id'];?>">
	<input type="hidden" name="course_id" id="course_id" value="<?php echo $scheduleData[0]['course_id'];?>">
	<div class="row">	
	<div class="col-md-6">
		<div class="form-group">
        <label>Date :</label>
        <input type="text" name="schedule_date" onchange="myFunction(this)"  class="form-control date_pic" value="<?php echo $scheduleData[0]['schedule_date'];?>" >
		</div>
	</div>
	<?php $days =array('MON','TUE','WED','THU','FRI','SAT','SUN');
	  
	?>
	<!-- <button onclick="myFunction()">Try it</button> -->
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Day :  </label>
		  <select class="form-control" id="schedule_days" disabled>
			<?php foreach($days as $k=>$dd){?>						
				<option value="<?php echo $dd;?>" <?php echo($dd==$scheduleData[0]['schedule_day'])?"selected='selected'":"";?>><?php echo $dd;?></option>
			<?php }?>
		  </select>	
			<input style="display:none;" name="schedule_days" id="schedule_days_new"
			 	<?php if($scheduleData[0]['schedule_day']!=''){?>
					value="<?php echo $scheduleData[0]['schedule_day'];?>" 
				<?php }else{?>
					value="<?php echo $dd;?>" 
				<?php } ?> 
			/>  
		</div>
	</div>
	</div>
    <?php
	
	?>
	<div class="row">	
    <div class="col-md-6">
		<div class="form-group">
		  <label for="case">Teachers Name : </label>

		  <!--<select class="form-control">
            <option value="">Select Teachers Name</option>
            <option value="1">Teacher 1</option>
            <option value="1">Teacher 2</option>
            <option value="1">Teacher 3</option>
            <option value="1">Teacher 4</option>
            <option value="1">Teacher 5</option>
        </select>-->
		<input type="text" name="teacher_name" class="form-control" value="<?php echo $teachersDataAr[0]['fname'].' '.$teachersDataAr[0]['lname'];?>" readonly>
		<input type="hidden" name="teacher_id" value="<?php echo $teachersDataAr[0]['id'];?>">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Email : </label>
          <input type="email" name="email" class="form-control" value="<?php echo $teachersDataAr[0]['email_id'];?>" readonly>
		</div>
	</div>
	</div>

	<div class="row">	
   
	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Slots Time : </label>
		  <select class="form-control" name="slots_time">
            <?php foreach($slotlist as $k=>$val){?>
			  <option value="<?php echo $val['id'];?>" <?php echo($val['id']==$scheduleData[0]['slot_id'])?"selected='selected'":"";?>><?php echo date('h:i A' ,strtotime($val['start_time'])); ?></option>
			<?php } ?>
        </select>
		</div>
	</div>
    <div class="col-md-6">
		<div class="form-group">
		  <label for="case">Session Type :</label>
		  <!--<select class="form-control">
            <option value="">Select Session Type</option>
            <option value="1">11</option>
            <option value="1">12</option>
            <option value="1">1</option>
            <option value="1">2</option>
            <option value="1">3</option>
        </select>-->
		<input type="text" name="session_type" class="form-control" value="<?php echo $scheduleData[0]['session_type'];?>" readonly>
		</div>
	</div>
	</div>

	<div class="row">	
   
	
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Course : </label>
		  <!--<select class="form-control">
            <option value="">Select Course</option>
            <option value="1">11</option>
            <option value="1">12</option>
            <option value="1">1</option>
            <option value="1">2</option>
            <option value="1">3</option>
        </select>-->
		<input type="text" name="course_name" class="form-control" value="<?php echo $scheduleData[0]['course_category'];?>" readonly>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Age Group : </label>
          <input type="text" name="age_group" id="age_group" class="form-control" value="<?php echo $scheduleData[0]['age_group'];?>" >
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Child Name : </label>
          <input type="name" name="child_name" class="form-control" value="<?php echo $scheduleData[0]['child_name'];?>" >
		</div>
	</div>
	</div>
    </div>


 <div class="panel panel-default">
  <div class="panel-heading">Summary / Notes</div>
  <div class="panel-body"> 
  
	<div class="col-md-12">		
		<div class="form-group">
		  <label for="case">Comments</label>
		  <textarea class="form-control" name="cl_comments" id="cl_comments" ><?php echo $scheduleData[0]['comments']; ?></textarea>
		</div>
	</div>
	
	<div class="col-md-12">	
	<hr/>
	
	<?php //if(get_login_type() != "client" || get_global_access()){ ?>
    
	<button  type="submit" style="height: 2.5rem;" name="submit" class="btn btn-success col-md-12" onclick="return confirm('Are you sure? you want to update')"><i class="fa fa-save"></i> Submit </button>
	<?php //} ?>
	
	</div>
	
	</form> 
  </div>
 </div>
 
  

</div>
</div>
<section>
</div>