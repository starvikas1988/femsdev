<style>
.panel-heading{
	margin-bottom: 10px;
	font-weight:600;
}
</style>

<?php
$classnow = "style='background-color:#3cc3b5;color:#fff;font-weight:600;font-size:11px'";
$classactive = "style='color:#888181;font-weight:600;border-right:1px solid #eee;font-size:11px'";

if(in_array($uri, $mysections)){
?>
<div class="wrap">
<ul class="nav nav-tabs" style="background:#fff">
<?php foreach($mysections as $eachsection){ ?>  
  <li class="nav-item" <?php echo (($uri == $eachsection))? $classnow : $classactive; ?>>
  <a class="nav-link" onclick="<?php echo $extraFormCheck; ?>"   href="<?php echo base_url('covid_case/form/'.$crmid.'/'.$eachsection); ?>" <?php echo (($uri == $eachsection))? $classnow : $classactive; ?>><?php echo ucwords($eachsection); ?></a></li>
<?php } ?>  
 </ul>
</div>
<?php } ?>


<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">	

  
<div class="panel panel-default">
  <div class="panel-body">
  
    <form action="<?php echo base_url(); ?>covid_case/submit_demographics" method="POST" autocomplete="off">
	
	<div class="row">
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">CRM ID</label>
		  <input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crmdetails['crm_id']; ?>" name="crm_id" readonly>
		  <input type="hidden" class="form-control" id="time_interval" placeholder="" value="" name="time_interval" readonly>
		</div>
	</div>
	
	<div class="col-md-5">
		<div class="form-group">
		  <label for="case">Case Name</label>
		  <input type="text" class="form-control" id="case_name" placeholder="" value="<?php echo $crmdetails['fname'] ." " .$crmdetails['lname']; ?>" name="case_name" readonly>
		</div>
	</div>
	
	<div class="col-md-3">
		<div class="form-group">
		<p class="timerClock pull-right"><i class="fa fa-clock-o"></i> <span id="timeWatch"></span></p>
		</div>
	</div>
	</div>
			
</div>
</div>
	
	
<div class="panel panel-default">
  <div class="panel-heading">DEMOGRAPHICS
  <a href="<?php echo base_url()."covid_case/form/" .$crmdetails['crm_id'] ."/administrative/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Administrative LHJ</a>
  </div>
  <div class="panel-body">
	
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Age at Symptom Onset :</label>
		</div>
	</div>
	<!--<div class="col-md-6">
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Month</span>
            </div>
		    <input type="text" class="form-control" id="d_age_at_symptom_month" placeholder="" name="d_age_at_symptom_month">
        </div>
		</div>
	</div>-->
	<div class="col-md-6">
		<div class="form-group">
		<div class="input-group mb-3">
            <div class="input-group-addon">
               <span class="input-group-text">Age</span>
            </div>
		    <input type="text" class="form-control" id="d_age_at_symptom_year" placeholder="" name="d_age_at_symptom_year">
        </div>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Ethnicity :</label>
		  <div class="checklist">
			<label><input type="radio" value="HIS" name="d_ethinicity"> Hispanic or Latino</label>
			<label><input type="radio" value="NHIS" name="d_ethinicity"> Not Hispanic or Latino</label>
			<label><input type="radio" value="UNK" name="d_ethinicity"> Unknown </label>
		  </div>
		</div>		
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Race :</label>
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="d_race"> Unknown</label>
			<label><input type="radio" value="AMERIND" name="d_race"> Amer Ind/AK Native</label>
			<label><input type="radio" value="ASIAN" name="d_race"> Asian Black/African </label>
			<label><input type="radio" value="AMERNATIVE" name="d_race"> Amer Native </label>
			<label><input type="radio" value="HI" name="d_race"> HI/Other PI </label>
			<label><input type="radio" value="WHITE" name="d_race"> White </label>
			<label><input type="radio" value="OTHER" name="d_race"> Other </label>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Primary Language :</label>
		  <input type="text" class="form-control" id="d_primary_language" placeholder="" name="d_primary_language">
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Interpreter Needed :</label>
		   <div class="checklist">
			<label><input type="radio" value="Y" name="d_is_interpreter_needed"> Yes</label>
			<label><input type="radio" value="N" name="d_is_interpreter_needed"> No</label>
			<label><input type="radio" value="UNK" name="d_is_interpreter_needed"> Unknown</label>
		   </div>
		</div>
	</div>
	</div>
	<br/>
	<div class="row">
	<div class="col-md-6">	
	<div class="form-group">
	  <label for="case">Employed: **</label>
	    <div class="checklist">
			<label><input type="radio" value="Y" name="d_is_employed" onclick="d_is_employed_validator(this)"  required> Yes</label>
			<label><input type="radio" value="N" name="d_is_employed" onclick="d_is_employed_validator(this)" required> No</label>
			<label><input type="radio" value="UNK" name="d_is_employed" onclick="d_is_employed_validator(this)" required> Unknown</label>
		   </div>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Occupation :</label>
		  <input type="text" class="form-control" id="d_occupation" placeholder="" name="d_occupation" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Industry : </label>
		  <input type="text" class="form-control" id="d_industry" placeholder="" name="d_industry" required>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Employer : </label>
		  <input type="text" class="form-control" id="d_employer" placeholder="" name="d_employer" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Worksite : </label>
		  <input type="text" class="form-control" id="d_worksite" placeholder="" name="d_worksite" required>
		</div>
	</div>
	</div>
	<br/>
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Student/Day Care : **</label>
		  <div class="checklist">
			<label><input type="radio" value="Y" name="d_is_student_care" onclick="d_is_student_care_validator(this)" required> Yes</label>
			<label><input type="radio" value="N" name="d_is_student_care" onclick="d_is_student_care_validator(this)" required> No</label>
			<label><input type="radio" value="UNK" name="d_is_student_care" onclick="d_is_student_care_validator(this)" required> Unknown</label>
		   </div>
		</div>
	</div>
	<div class="col-md-6 ioptions">		
		<div class="form-group">
		  <label for="case">Type Of School : **</label>
		  <div class="checklist">
			<label><input type="radio" value="PRE" name="d_type_of_school" required> Preschool/Day Care</label>
			<label><input type="radio" value="K12" name="d_type_of_school" required> K-12</label>
			<label><input type="radio" value="COLL" name="d_type_of_school" required> College</label>
			<label><input type="radio" value="GRAD" name="d_type_of_school" required> Graduate School</label>
			<label><input type="radio" value="VOC" name="d_type_of_school" required> Vocational</label>
			<label><input type="radio" value="ONL" name="d_type_of_school" required> Online</label>
			<label><input type="radio" value="OTH" name="d_type_of_school" required> Other</label>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">School Name : **</label>
		  <input type="text" class="form-control" id="d_school_name" placeholder="" name="d_school_name" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">School Address : **</label>
		  <input type="text" class="form-control" id="d_school_address" placeholder="" name="d_school_address" required>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">City/State/Country : **</label>
		  <input type="text" class="form-control" id="d_school_city" placeholder="" name="d_school_city" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Zip :</label>
		  <input type="text" class="form-control" id="d_school_zip" placeholder="" name="d_school_zip" required>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Phone Number :</label>
		  <input type="text" class="form-control number-only" id="d_phone" placeholder="" name="d_phone" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Teacher's Name :</label>
		  <input type="text" class="form-control" id="d_teacher_name" placeholder="" name="d_teacher_name" required>
		</div>
	</div>
	</div>
	
	
	
	</div>  
  </div>
  
  
   
 <div class="panel panel-default">
  <div class="panel-heading">Remarks</div>
  <div class="panel-body"> 
  
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Disposition : **</label>
		  <select class="form-control" name="cl_disposition" id="cl_disposition" required>
			<option value="C"> Confirm Case </option>
			<option value="P"> Call Back</option>
		  </select>
		</div>
	</div>
  
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Comments **</label>
		  <textarea class="form-control" name="cl_comments" id="cl_comments" required></textarea>
		</div>
	</div>
		
	<button type="submit" name="save" class="btn btn-success">Save & Next</button>
	
	<?php if(!empty($crmdetails['d_is_employed'])){ ?>
	<a href="<?php echo base_url()."covid_case/form/" .$crmdetails['crm_id'] ."/clinical/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	
	</form> 
  </div>
 </div>

</div>
</div>
<section>
</div>