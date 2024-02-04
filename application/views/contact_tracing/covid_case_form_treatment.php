<style>
.panel-heading{
	margin-bottom: 10px;
	font-weight:600;
}
.ui-datepicker{
	z-index:99999!important;
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
  <a class="nav-link"  onclick="<?php echo $extraFormCheck; ?>"  href="<?php echo base_url('contact_tracing/form/'.$crmid.'/'.$eachsection); ?>" <?php echo (($uri == $eachsection))? $classnow : $classactive; ?>><?php echo ucwords($eachsection); ?></a></li>
<?php } ?>  
 </ul>
</div>
<?php } ?>

<form action="<?php echo base_url(); ?>contact_tracing/submit_treatment_information" method="POST" autocomplete="off">

<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body" id="treatmentBodyform">	

  
<div class="panel panel-default">
  <div class="panel-body">
  
    
	
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
  <div class="panel-heading">TREATMENT
  <a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/clinical/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Clinical Information</a>
  </div>
  <div class="panel-body">
	
	<div class="row">
	<div class="col-md-6">	
	<div class="form-group">
		<label for="case"><br/></label>
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
			<label><input type="radio" onclick="t_treatment_1_validator(this)" value="Y" name="t_treatment_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="t_treatment_1_validator(this)"  name="t_treatment_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="t_treatment_1_validator(this)"  name="t_treatment_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Did patient receive prophylaxis/treatment ? **</label>
		</div>
	</div>
	<div class="col-md-5">		
		<div class="form-group">
		</div>
	</div>
	</div>
	
	
	<div class="row ioptions">
	<div class="col-md-3">		
		<div class="form-group">
		<label>Specify Medication</label>
		</div>
	</div>
	<!--<div class="col-md-4">		
		<div class="form-group">
			<input type="text" class="form-control" id="t_treatment_1_info" placeholder="" name="t_treatment_1_info">
		</div>
	</div>-->
	
	<div class="col-md-5">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="checkbox" value="ANTIBIOTIC" name="t_treatment_1_medication[]" required> Antibiotic</label>
			<label><input type="checkbox" value="ANTIVIRAL" name="t_treatment_1_medication[]" required> Antiviral</label>
			<label><input type="checkbox" value="OTHER" name="t_treatment_1_medication[]" required> Other</label>
		</div>
		</div>
	</div>
	</div>
	
	
	<div class="row ioptions">
	<div class="col-md-3">		
		<div class="form-group">
		    <label>Number of days actually taken</label>
			<input type="text" class="form-control number-only" id="t_treatment_days" placeholder="" name="t_treatment_days" required>
		</div>
	</div>
	
	<div class="col-md-4">		
		<div class="form-group">
		    <label>Treatment Start Date</label>
			<input type="text" class="form-control" id="t_treatment_start_date" placeholder="" name="t_treatment_start_date" required>
		</div>
	</div>
	
	<div class="col-md-5">		
		<div class="form-group">
		    <label>Treatment End Date</label>
			<input type="text" class="form-control" id="t_treatment_end_date" placeholder="" name="t_treatment_end_date" required>
		</div>
	</div>
	</div>
	
	
	<div class="row ioptions">
	
	<div class="col-md-3">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Duration</span>
            </div>
			<input type="text" class="form-control number-only" id="t_treatment_duration" placeholder="" name="t_treatment_duration" required>
		</div>
		</div>
	</div>
	
	<div class="col-md-4">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="radio" value="DAYS" name="t_treatment_duration_type" required> Days</label>
			<label><input type="radio" value="WEEKS" name="t_treatment_duration_type" required> Weeks</label>
			<label><input type="radio" value="MONTHS" name="t_treatment_duration_type" required> Months</label>
		</div>
		</div>
	</div>
	
	<!--<div class="col-md-3">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Prescribed Dose</span>
            </div>
			<input type="text" class="form-control" id="t_treatment_prescribed" placeholder="" name="t_treatment_prescribed">
		</div>
		</div>
	</div>
	
	<div class="col-md-2">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="radio" value="G" name="t_treatment_prescribed_unit"> g</label>
			<label><input type="radio" value="MG" name="t_treatment_prescribed_unit"> mg</label>
			<label><input type="radio" value="ML" name="t_treatment_prescribed_unit"> ml</label>
		</div>
		</div>
	</div>-->
	
	
	</div>
	
	
	
	<div class="row ioptions" id="medicationPrescribedRow">
	<hr/>
	
	<?php 
	$t_dose = 0;
	if(!empty($crmdetails['t_treatment_1_info'])){ 
	$t_treatment_1_info_ar = explode('##', $crmdetails['t_treatment_1_info']);
	$t_treatment_1_dose_ar = explode('##', $crmdetails['t_treatment_prescribed']);
	$t_treatment_1_unit_ar = explode('##', $crmdetails['t_treatment_prescribed_unit']);
	foreach($t_treatment_1_info_ar as $token){
		$t_dose++;
	?>
	
	<div class="medicationPrescribedDiv">
	<div class="col-md-5">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Medication</span>
            </div>
			<input type="text" class="form-control" id="t_treatment_1_info_medication_1" value="<?php echo $t_treatment_1_info_ar[$t_dose - 1]; ?>" placeholder="" name="t_treatment_1_info_medication[]">
		</div>
		</div>
	</div>
		
	<div class="col-md-3">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Prescribed Dose</span>
            </div>
			<input type="text" class="form-control" id="t_treatment_prescribed_dose_1" value="<?php echo $t_treatment_1_dose_ar[$t_dose - 1]; ?>"  placeholder="" name="t_treatment_prescribed_dose[]">
		</div>
		</div>
	</div>
	
	<div class="col-md-2">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="radio" value="G" name="t_treatment_prescribed_unit_dose_<?php echo $t_dose; ?>"> g</label>
			<label><input type="radio" value="MG" name="t_treatment_prescribed_unit_dose_<?php echo $t_dose; ?>"> mg</label>
			<label><input type="radio" value="ML" name="t_treatment_prescribed_unit_dose_<?php echo $t_dose; ?>"> ml</label>
		</div>
		</div>
	</div>
	
	<div class="col-md-2">		
		<div class="form-group">
		<button type="button" class="btn btn-danger t_removeMore hide"><i class="fa fa-times"></i></button>
		</div>
	</div>
	</div>
	
	
	<?php } } ?>
	
	
	<?php if($t_dose < 1){ ?>
	<div class="medicationPrescribedDiv">
	<div class="col-md-5">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Medication</span>
            </div>
			<input type="text" class="form-control" id="t_treatment_1_info_medication_1" placeholder="" name="t_treatment_1_info_medication[]">
		</div>
		</div>
	</div>
		
	<div class="col-md-3">		
		<div class="form-group">
		<div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text">Prescribed Dose</span>
            </div>
			<input type="text" class="form-control" id="t_treatment_prescribed_dose_1" placeholder="" name="t_treatment_prescribed_dose[]">
		</div>
		</div>
	</div>
	
	<div class="col-md-2">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="radio" value="G" name="t_treatment_prescribed_unit_dose_1"> g</label>
			<label><input type="radio" value="MG" name="t_treatment_prescribed_unit_dose_1"> mg</label>
			<label><input type="radio" value="ML" name="t_treatment_prescribed_unit_dose_1"> ml</label>
		</div>
		</div>
	</div>
	
	<div class="col-md-2">		
		<div class="form-group">
		<button type="button" class="btn btn-danger t_removeMore hide"><i class="fa fa-times"></i></button>
		</div>
	</div>
	</div>
	<?php } ?>
	
	</div>
	
	<div class="row ioptions">
	<div class="col-md-12">
	<button type="button" id="t_addMore" class="btn btn-primary"><i class="fa fa-plus"></i> Add More</button>
	</div>
	</div>
	
	
	
	
	<div class="row ioptions">
	<hr/>
	
	<div class="col-md-3">		
		<div class="form-group">
		<label>Indication</label>
		</div>
	</div>
	
	<div class="col-md-6">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="checkbox" value="PEP" name="t_treatment_indication[]" required> PEP</label>
			<label><input type="checkbox" value="PREP" name="t_treatment_indication[]" required> PrEP</label>
			<label><input type="checkbox" value="TREATMENT" name="t_treatment_indication[]" required> Treatment for Disease</label>
			<label><input type="checkbox" value="INCIDENTAL" name="t_treatment_indication[]" required> Incidental</label>
			<label><input type="checkbox" value="OTHER" name="t_treatment_indication[]" required> Other</label>
		</div>
		</div>
	</div>
	
	<div class="col-md-3">		
		<div class="form-group">
			<input type="text" class="form-control" id="t_treatment_indication_other" placeholder="Other Indication" name="t_treatment_indication_other">
		</div>
	</div>
	</div>
	
	
	
	
	
	<div class="row ioptions">
	<div class="col-md-3">		
		<div class="form-group">
		<label>Did patient take medication as prescribed</label>
		</div>
	</div>
	
	<div class="col-md-3">		
		<div class="form-group">
		    <div class="checklist">
			<label><input type="radio" value="Y" onclick="t_treatment_2_medication_validator(this)" name="t_treatment_2_medication" required> Yes</label>
			</div>
		</div>
	</div>
	
	<div class="col-md-3">		
		<div class="form-group">
		    <div class="checklist">
			<label><input type="radio" value="N" onclick="t_treatment_2_medication_validator(this)" name="t_treatment_2_medication" required> No - Why Not?</label>
			</div>
			<input type="text" class="form-control" id="t_treatment_2_medication_info" placeholder="Why Not?" name="t_treatment_2_medication_info" required>
		</div>
	</div>
	
	<div class="col-md-3">		
		<div class="form-group">
		    <div class="checklist">
			<label><input type="radio" value="UNK" onclick="t_treatment_2_medication_validator(this)" name="t_treatment_2_medication" required> Unknown</label>
			</div>
		</div>
	</div>
	</div>
	
	
	
	<div class="row ioptions">
	<hr/>
	<div class="col-md-3">		
		<div class="form-group">
		<label>Prescribing Provider</label>
		</div>
	</div>
	
	<div class="col-md-9">		
		<div class="form-group">
		    <input type="text" class="form-control" id="t_treatment_prescribing" placeholder="" name="t_treatment_prescribing" required>
		</div>
	</div>
	</div>
	
		
	</div>  
  </div>
  
  
  

<div class="panel panel-default">
  <div class="panel-body"> 
		
	<button type="submit" name="save" class="btn btn-success">Save & Next</button>
	
	<?php if(!empty($crmdetails['t_treatment_1'])){ ?>
	<a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/notes/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	

  </div>
 </div>


</div>
</div>
<section>
</div>

</form> 