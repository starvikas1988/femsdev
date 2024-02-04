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
  <a class="nav-link" onclick="<?php echo $extraFormCheck; ?>"   href="<?php echo base_url('contact_tracing/form/'.$crmid.'/'.$eachsection); ?>" <?php echo (($uri == $eachsection))? $classnow : $classactive; ?>><?php echo ucwords($eachsection); ?></a></li>
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
  
    <form action="<?php echo base_url(); ?>contact_tracing/submit_clinical_information" method="POST" autocomplete="off">
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">CRM ID</label>
		  <input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crmdetails['crm_id']; ?>" name="crm_id" readonly>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Case Name</label>
		  <input type="text" class="form-control" id="case_name" placeholder="" value="<?php echo $crmdetails['fname'] ." " .$crmdetails['lname']; ?>" name="case_name" readonly>
		</div>
	</div>
	</div>
			
</div>
</div>
	
	
<div class="panel panel-default">
  <div class="panel-heading">CLININCAL INFORMATION
  <a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/demographics/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Demographics</a>
  </div>
  <div class="panel-body">
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Complainant ill : **</label>
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_complainant_ill_validator(this)" name="c_complainant_ill" required> Yes</label>
			<label><input type="radio" value="N" onclick="c_complainant_ill_validator(this)" name="c_complainant_ill" required> No</label>
			<label><input type="radio" value="UNK" onclick="c_complainant_ill_validator(this)" name="c_complainant_ill" required> Unknown</label>
		  </div>
		</div>		
	</div>
	<div class="col-md-6 ioptions">		
		<div class="form-group">
		  <label for="case">Symptom Onset : **</label>
		  <input type="text" class="form-control" id="c_symptom_onset" placeholder="" name="c_symptom_onset" required>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-2">
		<div class="form-group">
		  <label for="case"></label>
		  <div class="checklist">
			<label><input type="checkbox" value="1" name="c_derived"> Derived</label>
		  </div>
		</div>		
	</div>
	<div class="col-md-2">		
		<div class="form-group">
		  <label for="case">Illness Duration :</label>
		  <input type="number" class="form-control" id="c_illness_duration" placeholder="" name="c_illness_duration" required>
		</div>
	</div>
	<div class="col-md-2">		
		<div class="form-group">
		  <label for="case"></label>
		   <div class="checklist">
			<label><input type="radio" value="D" name="c_illness_duration_type" required> Days</label>
			<!--<label><input type="radio" value="W" name="c_illness_duration_type" required> Weeks</label>
			<label><input type="radio" value="M" name="c_illness_duration_type" required> Months</label>
			<label><input type="radio" value="Y" name="c_illness_duration_type" required> Years</label>-->
		   </div>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Diagnosis Date :</label>
		  <input type="text" class="form-control" id="c_diagnosis_date" placeholder="" name="c_diagnosis_date" required>
		</div>
	</div>
	</div>
		
	<div class="row">
	<div class="col-md-6">	
	<div class="form-group">
	  <label for="case">Illness is Still Ongoing:</label>
	    <div class="checklist">
			<label><input type="radio" value="Y" name="c_illness_ongoing" required> Yes</label>
			<label><input type="radio" value="N" name="c_illness_ongoing" required> No</label>
			<label><input type="radio" value="UNK" name="c_illness_ongoing" required> Unknown</label>
		   </div>
		</div>
	</div>
	</div>
	
	<hr/>
	
	<div class="row">
	<div class="col-md-6">	
	<div class="form-group">
		<label for="case">Clinincal Features :</label>
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">Yes</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">No</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">Unknown</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case"></label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Any fever, subjective or measured **</label>
		</div>
	</div>
	<div class="col-md-2">		
		<div class="form-group">
		  <label for="case">Temp measured? **</label>
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_clinincal_info_1_temp_validator(this)" name="c_clinincal_info_1_temp" required> Yes</label>
			<label><input type="radio" value="N" onclick="c_clinincal_info_1_temp_validator(this)" name="c_clinincal_info_1_temp" required> No</label>
		  </div>
		</div>
	</div>
	<div class="col-md-3 ioptions">		
		<div class="form-group">
		  <label for="case">Highest measured temp</label>
		  <div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">°F</span>
            </div>
		    <input type="text" class="form-control" value="" name="c_clinincal_info_1_hightemp" id="c_clinincal_info_1_hightemp" required>
		   </div>
		</div>
	</div>
	</div>
		
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Chills or rigors</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_3" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_3" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_3" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Headache</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_4" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_4" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_4" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Myalgia (muscle aches or pains)</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_5" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_5" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_5" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Pharyngitis (sore throat)</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_6" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_6" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_6" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Sinus congestion</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_7" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_7" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_7" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Cough **</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onchange="c_clinincal_info_8_temp_validator(this)" name="c_clinical_info_8" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onchange="c_clinincal_info_8_temp_validator(this)" name="c_clinical_info_8" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onchange="c_clinincal_info_8_temp_validator(this)" name="c_clinical_info_8" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Productive cough</label>
		</div>
	</div>
	<div class="col-md-5 ioptions">
		<div class="form-group">
		  <label for="case">Onset Date:</label>
		  <input type="text" class="form-control" id="c_clinical_info_8_onset" placeholder="" name="c_clinical_info_8_onset" required>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onchange="c_clinincal_info_9_temp_validator(this)" name="c_clinical_info_9" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onchange="c_clinincal_info_9_temp_validator(this)" name="c_clinical_info_9" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onchange="c_clinincal_info_9_temp_validator(this)" name="c_clinical_info_9" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Dry cough</label>
		</div>
	</div>
	<div class="col-md-5 ioptions">
		<div class="form-group">
		  <label for="case">Onset Date:</label>
		  <input type="text" class="form-control" id="c_clinical_info_9_onset" placeholder="" name="c_clinical_info_9_onset" required>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_10" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_10" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_10"></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Dyspnea (shortness of breath)</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_clinincal_info_11_temp_validator(this)" name="c_clinical_info_11" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="c_clinincal_info_11_temp_validator(this)" name="c_clinical_info_11" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="c_clinincal_info_11_temp_validator(this)" name="c_clinical_info_11" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-3">		
		<div class="form-group">
		  <label for="case">Pneumonia **</label>
		</div>
	</div>
	<div class="col-md-6 ioptions">		
		<div class="form-group">
		<div class="checklist">
		    <label>Diagnosed By : </label>
			<label><input type="checkbox" value="XRAY" name="c_clinical_info_11_diagnosis[]" required> X-Ray</label>
			<label><input type="checkbox" value="CT" name="c_clinical_info_11_diagnosis[]" required> CT</label>
			<label><input type="checkbox" value="MRI" name="c_clinical_info_11_diagnosis[]" required> MRI</label>
			<label><input type="checkbox" value="PROVIDER" name="c_clinical_info_11_diagnosis[]" required> Provider Only</label>
			
			<br/>
			<label>Result : </label>
			<label><input type="radio" value="POSITIVE" name="c_clinical_info_11_result" required> Positive</label>
			<label><input type="radio" value="NEGATIVE" name="c_clinical_info_11_result" required> Negative</label>
			<label><input type="radio" value="INDETERMINATE" name="c_clinical_info_11_result" required> Indeterminate</label>
			<label><input type="radio" value="NOTTESTED" name="c_clinical_info_11_result" required> Not Tested</label>
			<label><input type="radio" value="OTHER" name="c_clinical_info_11_result" required> Other</label>
		</div>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_clinincal_info_12_temp_validator(this)" name="c_clinical_info_12" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="c_clinincal_info_12_temp_validator(this)" name="c_clinical_info_12" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="c_clinincal_info_12_temp_validator(this)" name="c_clinical_info_12" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Acute respiratory distress syndrome (ARDS)</label>
		</div>
	</div>
	<div class="col-md-5 ioptions">		
		<div class="form-group">
		<div class="checklist">
		    <label>Diagnosed By : </label>
			<label><input type="checkbox" value="XRAY" name="c_clinical_info_12_diagnosis[]" required> X-Ray</label>
			<label><input type="checkbox" value="CT" name="c_clinical_info_12_diagnosis[]" required> CT</label>
			<label><input type="checkbox" value="MRI" name="c_clinical_info_12_diagnosis[]" required> MRI</label>
			<label><input type="checkbox" value="PROVIDER" name="c_clinical_info_12_diagnosis[]" required> Provider Only</label>
		</div>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_13" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_13" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_13" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Nausea</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_14" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_14" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_14" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Vomitting</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_15" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_15" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_15" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Diarrhea</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_16" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_16" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_16" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Abdominal Pain or Cramps</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_17" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_17" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_17" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Anosmia (loss of sense of smell)</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_clinical_info_18" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_clinical_info_18" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_clinical_info_18" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-8">		
		<div class="form-group">
		  <label for="case">Dysgeusia/ageusia (altered, impaired, or lost sense of taste)</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_clinincal_info_19_temp_validator(this)" name="c_clinical_info_19" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="c_clinincal_info_19_temp_validator(this)" name="c_clinical_info_19" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="c_clinincal_info_19_temp_validator(this)"  name="c_clinical_info_19" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Other symptoms consistent with this disease</label>
		</div>
	</div>
	<div class="col-md-5 ioptions">		
		<div class="form-group">
		<input type="text" class="form-control" id="c_clinical_info_19_other" placeholder="" name="c_clinical_info_19_other" required>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-3">		
		<div class="form-group">
		 <label>First symptom(s) that presented: </label>
		</div>
	</div>
	<div class="col-md-9">
		<div class="form-group">
		<div class="checklist">
			<label><input type="checkbox" value="FEVER" name="c_clinical_info_20_first[]" required> Fever</label>
			<label><input type="checkbox" value="CHILLS" name="c_clinical_info_20_first[]" required> Chills/Rigors</label>
			<label><input type="checkbox" value="HEADACHE" name="c_clinical_info_20_first[]" required> Headache</label>
			<label><input type="checkbox" value="MYALGIA" name="c_clinical_info_20_first[]" required> Myalgia</label>
			<label><input type="checkbox" value="PHARYNGITIS" name="c_clinical_info_20_first[]" required> Pharyngitis</label>
			<label><input type="checkbox" value="SINUS" name="c_clinical_info_20_first[]" required> Sinus Congestion</label>
			<label><input type="checkbox" value="COUGH" name="c_clinical_info_20_first[]" required> Cough</label>
			<label><input type="checkbox" value="DYSPNEA" name="c_clinical_info_20_first[]" required> Dyspnea</label>
			<label><input type="checkbox" value="PNEUMONIA" name="c_clinical_info_20_first[]" required> Pneumonia</label>
			<label><input type="checkbox" value="ARDS" name="c_clinical_info_20_first[]" required> ARDS</label>
			<label><input type="checkbox" value="NAUSEA" name="c_clinical_info_20_first[]" required> Nausea</label>
			<label><input type="checkbox" value="VOMITING" name="c_clinical_info_20_first[]" required> Vomiting</label>
			<label><input type="checkbox" value="DIARRHEA" name="c_clinical_info_20_first[]" required> Diarrhea</label>
			<label><input type="checkbox" value="ABDOMINAL" name="c_clinical_info_20_first[]" required> Abdominal Pain or Cramps</label>
			<label><input type="checkbox" value="OTHER" name="c_clinical_info_20_first[]" required> Other Symptom - Describe</label>
		</div>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-4">		
		<div class="form-group">
		 <label>Pregnancy status at time of symptom onset: </label>
		</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
		<div class="checklist">
			<label><input type="checkbox" value="PREGNANT" name="c_clinical_info_20_pregnancy[]" required> Pregnant</label>
			<label><input type="checkbox" value="POSTPARTUM" name="c_clinical_info_20_pregnancy[]" required> Postpartum</label>
			<label><input type="checkbox" value="NOTPREGNANT" name="c_clinical_info_20_pregnancy[]" required> Neither Pregnant nor Postpartum</label>
			<label><input type="checkbox" value="UNKNOWN" name="c_clinical_info_20_pregnancy[]" required> Unknown</label>
		</div>
		</div>
	</div>
	</div>
	
	<hr/>
	
	<div class="row">
	<div class="col-md-6">	
	<div class="form-group">
		<label for="case">Predisposing Conditions :</label>
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">Yes</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">No</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">Unknown</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case"></label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Current tobacco smoker</label>
		</div>
	</div>
	<div class="col-md-2">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Diabetes Mellitus</label>
		</div>
	</div>
	<div class="col-md-2">		
		<div class="form-group">
		</div>
	</div>
	</div>
		
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_3" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_3" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_3" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Chemotherapy</label>
		</div>
	</div>
	<div class="col-md-2">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_4" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_4" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_4" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Steroid therapy</label>
		</div>
	</div>
	<div class="col-md-2">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_predisposing_info_5_validator(this)" name="c_predisposing_info_5"  required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="c_predisposing_info_5_validator(this)" name="c_predisposing_info_5"  required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="c_predisposing_info_5_validator(this)" name="c_predisposing_info_5"  required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Cancer diagnosis or treatment in 12 months prior to onset</label>
		</div>
	</div>
	<div class="col-md-4 ioptions">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Specify </span>
            </div>
		<input type="text" class="form-control" id="c_predisposing_info_5_specify" placeholder="" name="c_predisposing_info_5_specify" required></label>
		</div>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_6"  required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_6"  required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_6"  required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Organ transplant</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_predisposing_info_7_validator(this)"  name="c_predisposing_info_7"  required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="c_predisposing_info_7_validator(this)"  name="c_predisposing_info_7" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="c_predisposing_info_7_validator(this)"  name="c_predisposing_info_7" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Immunosuppressive therapy, condition or disease</label>
		</div>
	</div>
	<div class="col-md-4 ioptions">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Specify </span>
            </div>
		<input type="text" class="form-control" id="c_predisposing_info_7_specify" placeholder="" name="c_predisposing_info_7_specify" required></label>
		</div>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_8" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_8" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_8" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Chronic heart disease</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_9" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_9" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_9" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Asthma/reactive airway disease</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_10" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_10" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_10" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Chronic lung disease (e.g., COPD, emphysema) </label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_11" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_11" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_11" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Chronic liver disease</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_12" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_12" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_12" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Chronic kidney disease</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_13" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_13" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_13" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Hemoglobinopathy (e.g., sickle cell disease)</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_14" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_14" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_14" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Current prescription or treatment</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_predisposing_info_15" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_predisposing_info_15" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_predisposing_info_15" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Hemodialysis at time of onset</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_predisposing_info_16_temp_validator(this)" name="c_predisposing_info_16" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="c_predisposing_info_16_temp_validator(this)" name="c_predisposing_info_16" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="c_predisposing_info_16_temp_validator(this)" name="c_predisposing_info_16" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		  <label for="case">Other underlying medical conditions</label>
		</div>
	</div>
	<div class="col-md-4 ioptions">		
		<div class="form-group">
		<input type="text" class="form-control" id="c_predisposing_info_16_others" placeholder="" name="c_predisposing_info_16_others">
		</div>
	</div>
	</div>
	
	
	<hr/>
	
	<div class="row">
	<div class="col-md-6">	
	<div class="form-group">
		<label for="case">Clinical Testing :</label>
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">Yes</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">No</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">Unknown</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case"></label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_clinical_testing_1_validator(this)" name="c_clinical_testing_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="c_clinical_testing_1_validator(this)" name="c_clinical_testing_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="c_clinical_testing_1_validator(this)" name="c_clinical_testing_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">COVID-19 testing performed</label>
		</div>
	</div>
	<div class="col-md-5 ioptions">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="radio" onclick="c_clinical_testing_1_info_validator(this)" value="POSITIVE" name="c_clinical_testing_1_info" required> Positive</label>
			<label><input type="radio"  onclick="c_clinical_testing_1_info_validator(this)" value="NEGATIVE" name="c_clinical_testing_1_info" required> Negative</label>
			<label><input type="radio"  onclick="c_clinical_testing_1_info_validator(this)" value="INDETERMINATE" name="c_clinical_testing_1_info" required> Indeterminate</label>
			<label><input type="radio"  onclick="c_clinical_testing_1_info_validator(this)" value="PENDING" name="c_clinical_testing_1_info" required> Pending</label>
			<label><input type="radio"  onclick="c_clinical_testing_1_info_validator(this)" value="NOTDONE" name="c_clinical_testing_1_info" required> Not Done</label>
			<label><input type="radio"  onclick="c_clinical_testing_1_info_validator(this)" value="INADEQUATE" name="c_clinical_testing_1_info" required> Specimen Inadequate</label>
		</div>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">DATE </span>
            </div>
			<input type="text" class="form-control" id="c_clinical_testing_1_date" placeholder="" name="c_clinical_testing_1_date" required>
		</div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		<label>List positive results in the NOTES section</label>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-12">		
		<div class="form-group">
		<br/>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_clinical_testing_2_validator(this)" name="c_clinical_testing_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="c_clinical_testing_2_validator(this)" name="c_clinical_testing_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="c_clinical_testing_2_validator(this)" name="c_clinical_testing_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Flu testing performed</label>
		</div>
	</div>
	<div class="col-md-5 ioptions">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="radio"  onclick="c_clinical_testing_2_info_validator(this)" value="POSITIVE" name="c_clinical_testing_2_info" required> Positive</label>
			<label><input type="radio"  onclick="c_clinical_testing_2_info_validator(this)" value="NEGATIVE" name="c_clinical_testing_2_info" required> Negative</label>
			<label><input type="radio"  onclick="c_clinical_testing_2_info_validator(this)" value="INDETERMINATE" name="c_clinical_testing_2_info" required> Indeterminate</label>
			<label><input type="radio" onclick="c_clinical_testing_2_info_validator(this)"  value="PENDING" name="c_clinical_testing_2_info" required> Pending</label>
			<label><input type="radio"  onclick="c_clinical_testing_2_info_validator(this)" value="NOTDONE" name="c_clinical_testing_2_info" required> Not Done</label>
			<label><input type="radio"  onclick="c_clinical_testing_2_info_validator(this)" value="INADEQUATE" name="c_clinical_testing_2_info" required> Specimen Inadequate</label>
		</div>
		</div>
	</div>
	</div>
		
	<div class="row ioptions">
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">DATE </span>
            </div>
			<input type="text" class="form-control" id="c_clinical_testing_2_date" placeholder="" name="c_clinical_testing_2_date" required>
		</div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		<label>List positive results in the NOTES section</label>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-12">		
		<div class="form-group">
		<br/>
		</div>
	</div>
	<div>
	
	<div class="row">
	<div class="col-md-3">		
		<div class="form-group">
		  <label for="case">Viral respiratory panel</label>
		</div>
	</div>
	<div class="col-md-9">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="radio"  onclick="c_clinical_testing_3_info_validator(this)" value="POSITIVE" name="c_clinical_testing_3_info" required> Positive</label>
			<label><input type="radio"  onclick="c_clinical_testing_3_info_validator(this)" value="NEGATIVE" name="c_clinical_testing_3_info" required> Negative</label>
			<label><input type="radio"  onclick="c_clinical_testing_3_info_validator(this)" value="INDETERMINATE" name="c_clinical_testing_3_info" required> Indeterminate</label>
			<label><input type="radio"  onclick="c_clinical_testing_3_info_validator(this)" value="PENDING" name="c_clinical_testing_3_info" required> Pending</label>
			<label><input type="radio"  onclick="c_clinical_testing_3_info_validator(this)" value="NOTDONE" name="c_clinical_testing_3_info" required> Not Done</label>
			<label><input type="radio"  onclick="c_clinical_testing_3_info_validator(this)" value="INADEQUATE" name="c_clinical_testing_3_info" required> Specimen Inadequate</label>
		</div>
		</div>
	</div>
	</div>
		
	<div class="row ioptions">
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">DATE </span>
            </div>
			<input type="text" class="form-control" id="c_clinical_testing_3_date" placeholder="" name="c_clinical_testing_3_date" required>
		</div>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		<label>List positive results in the NOTES section</label>
		</div>
	</div>
	</div>
	
	
	<hr/>
	
	
	
	<div class="row">
	<div class="col-md-6">	
	<div class="form-group">
		<label for="case">Hospitalization : **</label>
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">Yes</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">No</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">Unknown</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case"></label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_hospitalization_1_validator(this)" name="c_hospitalization_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="c_hospitalization_1_validator(this)" name="c_hospitalization_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="c_hospitalization_1_validator(this)" name="c_hospitalization_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Hospitalized for this Illness</label>
		</div>
	</div>
	<div class="col-md-5 ioptions">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Facility name</span>
            </div>
			<input type="text" class="form-control" id="c_hospitalization_1_info" placeholder="" name="c_hospitalization_1_info" required>
		</div>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Hospital Admission Date</span>
            </div>
			<input type="text" class="form-control" id="c_hospitalization_1_admission" placeholder="" name="c_hospitalization_1_admission" required>
		</div>
		</div>
	</div>
	
	<div class="col-md-5">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Hospital Discharge Date</span>
            </div>
			<input type="text" class="form-control" id="c_hospitalization_1_discharge" placeholder="" name="c_hospitalization_1_discharge" required>
		</div>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_hospitalization_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_hospitalization_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_hospitalization_2" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Admitted to ICU **</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_hospitalization_3" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_hospitalization_3" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_hospitalization_3" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Mechanical ventilation or intubation required **</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" name="c_hospitalization_5" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" name="c_hospitalization_5" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" name="c_hospitalization_5" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Still hospitalized</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	
	
	<div class="row">
	<div class="col-md-6">	
	<div class="form-group">
		<br/>
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">Yes</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">No</label>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <label for="case">Unknown</label>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case"></label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	
	<div class="row">
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="Y" onclick="c_hospitalization_4_validator(this)" name="c_hospitalization_4" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="c_hospitalization_4_validator(this)" name="c_hospitalization_4" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="c_hospitalization_4_validator(this)" name="c_hospitalization_4" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Died of this illness **</label>
		</div>
	</div>
	<div class="col-md-5 ioptions">		
		<div class="form-group">
		<label>Please fill in the death date information on the Person Screen</label>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Death Date</span>
            </div>
			<input type="text" class="form-control" id="c_hospitalization_4_death" placeholder="" name="c_hospitalization_4_death" required>
		</div>
		</div>
	</div>
	</div>
	
		
	</div>  
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-body"> 
		
	<button type="submit" name="save" class="btn btn-success">Save & Next</button>
	
	<?php if(!empty($crmdetails['c_complainant_ill'])){ ?>
	<a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/treatment/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	
	</form> 
  </div>
 </div>



</div>
</div>
<section>
</div>