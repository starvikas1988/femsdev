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

  <h4>diy DEMO CLASS FORM
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
<form name="frm" id="frm" method="post" action="<?php echo base_url('diy/insert_demo_class');?>">
	
	
<div class="panel panel-default">
  <div class="panel-heading">Basic Information</div>
  <div class="panel-body">
		

	
	<div class="row">	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Parent Name : </label>
		  <input type="text" class="form-control" id="parent_name" value="<?php echo set_value('parent_name'); ?>" placeholder="" name="parent_name" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Phone Number : </label>
		  <input type="number" min="0"  class="form-control" id="phone_number" value="<?php echo set_value('phone_number'); ?>" placeholder="" name="phone_number" required>
		</div>
	</div>
	</div>

	<div class="row">	
    <div class="col-md-6">
		<div class="form-group">
		  <label for="case">Alternative Phone Number : </label>
		  <input type="number" min="0"  class="form-control" id="alt_phone_number" value="<?php echo set_value('alt_phone_number'); ?>" placeholder="" name="alt_phone_number" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Email ID : </label>
		  <input type="email" class="form-control" id="email" value="<?php echo set_value('email'); ?>" placeholder="" name="email" required>
		</div>
	</div>
	</div>

	<div class="row">	
   
	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Alternative Email ID : </label>
		  <input type="email" class="form-control" id="alt_email" value="<?php echo set_value('alt_email'); ?>" placeholder="" name="alt_email" required>
		</div>
	</div>
    <div class="col-md-6">
		<div class="form-group">
		  <label for="case">City : </label>
		  <input type="text" class="form-control" id="city" value="<?php echo set_value('city'); ?>" placeholder="" name="city" required>
		</div>
	</div>
	</div>

	<div class="row">	
   
	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">State : </label>
		  <input type="text" class="form-control" id="case_lname" value="<?php echo set_value('case_lname'); ?>" placeholder="" name="state" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Country : </label>
		  <input type="text" class="form-control" id="country" value="<?php echo set_value('country'); ?>" placeholder="" name="country" required>
		</div>
	</div>
	</div>
    </div>


<div class="panel panel-default">
  <div class="panel-heading">Slots</div>
  <div class="panel-body">
		

	
	<div class="row">	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Demo Date : </label>
		  <input type="text" class="form-control" id="date_pic" value="<?php echo set_value('date_pic'); ?>" placeholder="select Demo Date" name="demo_date" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Slots Time : </label>
		  <select name="Slots_time" id="Slots_time" class="form-control">
		  <option value="">Select Slot Time</option>
		  	<?php foreach($teacher_time_slot as $ts=>$tts):?>
			  <!-- <option value="<?php echo $tts['slots_time'];?>"><?php echo $tts['name'];?></option> -->
			  <option value="<?php echo $tts['id'];?>"><?php echo $tts['slot_name'];?></option>
			<?php endforeach;?>
		  </select>	  
		</div>
	</div>
	</div>

	<div class="row">	
    <div class="col-md-6">
		<div class="form-group">
		  <label for="case">Time Zone : </label>
		  <!-- <input type="text" class="form-control" id="case_lname" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['lname'] : ''; ?>" placeholder="" name="time_zone" required> -->
          <select required class="form-control" id="exampleFormControlSelect1" name="time_zone">
                <option value="" >Select Time Zone</option>
                <option value="EST" >EST</option>
                <option value="IST"> IST </option>
               
            </select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Kids Name: </label>
		  <input type="text" class="form-control" id="kids_name" value="<?php echo set_value('kids_name'); ?>" placeholder="" name="kids_name" required>
		</div>
	</div>
	</div>

	<div class="row">	
   
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Age : </label>
		  <input type="text" class="form-control" id="age" value="<?php echo set_value('age'); ?>" placeholder="" name="age" required>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Curriculum/Course : </label>
			
			<select required class="form-control" id="exampleFormControlSelect1" name="course">
          	<option value="">Select Course</option>
			<?php	
				foreach($course_master as $ks=>$cr){
			?>
			
		  	<option value="<?php echo $cr['id'];?>"><?php echo $cr['name'];?></option>
		  <?php 
				}
			?>
			</select>	
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Level : </label>
		  <!-- <input type="text" class="form-control" id="case_lname" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['lname'] : ''; ?>" placeholder="" name="level" required> -->
          <select required class="form-control" id="exampleFormControlSelect1" name="levels">
          <option value="">Select Level</option>
				<?php
					foreach($level_master as $ks=>$lr){
				?>
		  			<option value="<?php echo $lr['id'];?>"><?php echo $lr['name'];?></option>
		  		<?php 
					}	
				?>
            </select>
		</div>
	</div>
	</div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Validation</div>
  <div class="panel-body">

	<div class="row">	
   
    <div class="col-md-4">
		<div class="form-group">
		  <label for="case">Laptop/Desktop : </label>
		  <!-- <input type="text" class="form-control" id="case_lname" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['lname'] : ''; ?>" placeholder="" name="course" required> -->
          <select required class="form-control" id="exampleFormControlSelect1" name="laptop">
          <option value="">Select</option>
                <option value="YES">YES</option>
                <option value="NO">NO</option>
            </select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Microphone & Camera : </label>
		  <!-- <input type="text" class="form-control" id="case_lname" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['lname'] : ''; ?>" placeholder="" name="course" required> -->
          <select required class="form-control" id="exampleFormControlSelect1" name="camera">
          <option value="">Select</option>
                <option value="YES">YES</option>
                <option value="NO">NO</option>
                
            </select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Smart Phone : </label>
		  <!-- <input type="text" class="form-control" id="case_lname" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['lname'] : ''; ?>" placeholder="" name="course" required> -->
          <select required class="form-control" id="exampleFormControlSelect1" name="smart_phone">
          <option value="">Select</option>
                <option value="YES">YES </option>
                <option value="NO">NO </option>
            </select>
		</div>
	</div>
</div>
<div class="row">	
   
    <div class="col-md-4">
		<div class="form-group">
		  <label for="case">Internet Connection : </label>
		  <!-- <input type="text" class="form-control" id="case_lname" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['lname'] : ''; ?>" placeholder="" name="course" required> -->
          <select required class="form-control" id="exampleFormControlSelect1" name="internet">
          <option value="">Select</option>
                <option value="YES">YES</option>
                <option value="NO">NO</option>
            </select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Browser Update : </label>
		  <!-- <input type="text" class="form-control" id="case_lname" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['lname'] : ''; ?>" placeholder="" name="course" required> -->
          <select required class="form-control" id="exampleFormControlSelect1" name="browser_update">
          <option value="">Select</option>
                <option value="YES">YES</option>
                <option value="NO">NO</option>
            </select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Parent Presence : </label>
		  <!-- <input type="text" class="form-control" id="case_lname" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['lname'] : ''; ?>" placeholder="" name="course" required> -->
          <select required class="form-control" id="exampleFormControlSelect1" name="parent_presence">
          <option value="">Select</option>
                <option value="YES">YES </option>
                <option value="NO">NO </option>
            </select>
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
		  <textarea class="form-control" name="cl_comments" id="cl_comments" required><?php echo set_value('cl_comments'); ?></textarea>
		</div>
	</div>
	
	<div class="col-md-12">	
	<hr/>
	
	<?php if(get_login_type() != "client" || get_global_access()){ ?>
    
	<button  type="submit" style="height: 2.5rem;" name="submit" class="btn btn-success col-md-12"><i class="fa fa-save"></i> Submit </button>
	<?php } ?>
	
	</div>
	
	</form> 
  </div>
 </div>
 
  

</div>
</div>
<section>
</div>