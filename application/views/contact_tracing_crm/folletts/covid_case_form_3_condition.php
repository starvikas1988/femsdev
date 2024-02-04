<style>
.panel-heading{
	margin-bottom: 10px;
	font-weight:600;
}
.header-div{
	background-color: #f9f9f9;
    font-size: 15px;
    padding: 10px 20px;
    font-weight: 600;
    margin-bottom: 20px;
}
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


<?php
$data['mysections'] = $mysections;
$data['extraFormCheck'] = $extraFormCheck;
$data['urlSection'] = $urlSection;
$data['crmid'] = $crmid;
$this->load->view('contact_tracing_crm/folletts/covid_case_navbar', $data);
?>

<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">	

  
<div class="panel panel-default">
  <div class="panel-body">
  
    <form action="<?php echo base_url(); ?>contact_tracing_follett/submit_condition_information" method="POST" autocomplete="off">
	
	<div class="row">
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">CASE ID</label>
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
  <div class="panel-heading">CASE DETAILS
  <a href="<?php echo base_url()."contact_tracing_follett/form/" .$crmdetails['crm_id'] ."/case/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Case Details</a>
  </div>
  <div class="panel-body">
	
	<div class="row">	
	<div class="col-md-12">
		  <p class="chatquote"><b>AGENT:</b> Can you please share with me any symptoms you have? (or your employee currently has?)</p><br/>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Caller's Symptoms :</label>
		  <select class="form-control" id="s_symptoms" placeholder="" name="s_symptoms[]" multiple required>
			<option value="">-- Symptoms --</option>
			<option value="No Symptoms">No Symptoms</option>
			<option value="Fever">Fever</option>
			<option value="Congestion">Congestion</option>
			<option value="Sore Throat">Sore Throat</option>
			<option value="Headache">Headache</option>
			<option value="Chills">Chills</option>
			<option value="Muscle Aches/Pains">Muscle Aches/Pains</option>
			<option value="Sinus Congestion">Sinus Congestion</option>
			<option value="Pneumonia">Pneumonia</option>
			<option value="Exhaustion">Exhaustion</option>
			<option value="Shortness of Breath">Shortness of Breath</option>
			<option value="Isolating at Home-Very Mild Symptoms">Isolating at Home-Very Mild Symptoms</option>
			<option value="Quarantine at Home-Symptomatic">Quarantine at Home-Symptomatic</option>
			<option value="Hospitalized">Hospitalized</option>
		  </select>
		</div>
	</div>
	</div>
	
	
	<hr/>
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">AGENT:  Was caller exposed at place of work? </label>
		   <select class="form-control" id="s_exposure_event" placeholder="" name="s_exposure_event" required>
			<option value="">-- Select Option --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>		
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">If "yes," please provide info. here : </label>
		  <textarea class="form-control" id="s_exposure_notes" placeholder="" name="s_exposure_notes"><?php echo !empty($crmdetails['cid']) ? $crmdetails['s_exposure_notes'] : ''; ?></textarea>
		</div>		
	</div>
	</div>
	
	
	<div class="row">
	</div>
	
	<hr/>
	
	<div class="row">
	
	<div class="col-md-6">	
	<div class="form-group">
	  <label for="case">AGENT:  Can you please tell me when you last worked? </label>
	  <input type="text" class="form-control newDatePick" id="s_last_work" value="<?php echo !empty($crmdetails['s_last_work']) ? date('m/d/Y', strtotime($crmdetails['s_last_work'])) : ''; ?>" placeholder="" name="s_last_work">
	</div>
	</div>	
	
	<div class="col-md-6" style="display:none">		
		<div class="form-group">
		  <label for="case">Do they have symptoms ?</label>
		  <select class="form-control" id="s_is_symptom" placeholder="" name="s_is_symptom">
			<option value="">-- Select Option --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">AGENT: When did you begin experiencing symptoms ?</label>
		  <input type="text" class="form-control newDatePick" id="s_date_of_symptom" value="<?php echo !empty($crmdetails['s_date_of_symptom']) ? date('m/d/Y', strtotime($crmdetails['s_date_of_symptom'])) : ''; ?>" placeholder="" name="s_date_of_symptom">
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">AGENT: When did you begin your quarantine or isolation? </label>
		  <input type="text" class="form-control newDatePick" id="s_date_isolating" value="<?php echo !empty($crmdetails['s_date_isolating']) ? date('m/d/Y', strtotime($crmdetails['s_date_isolating'])) : ''; ?>" placeholder="" name="s_date_isolating">
		</div>
	</div>
	</div>
	
	<hr/>
	
	<h2 class="header-div">SAFETY MEASURES</h2>
	
	<div class="row">
	<div class="col-md-12">		
		<div class="form-group">
		  <label for="case">AGENT: Are COVID safety protocols followed at your place of employment? </label>
		  <select class="form-control" id="s_protocol_followed" placeholder="" name="s_protocol_followed" required>
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
			<option value="N/A">N/A</option>
		  </select>
		</div>
	</div>
	
	<div class="col-md-6" style="display:none">		
		<div class="form-group">
		  <label for="case">1.	All team members wearing a mask or face covering all the time?</label>
		  <select class="form-control" id="s_is_face_covered" placeholder="" name="s_is_face_covered">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6" style="display:none">		
		<div class="form-group">
		  <label for="case">2.	Social Distancing maintain?</label>
		  <select class="form-control" id="s_is_social_distance" placeholder="" name="s_is_social_distance">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6" style="display:none">		
		<div class="form-group">
		  <label for="case">3.	Frequent high touch area cleaning  every 2 hours?</label>
		  <select class="form-control" id="s_is_high_cleaning" placeholder="" name="s_is_high_cleaning">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6" style="display:none">		
		<div class="form-group">
		  <label for="case">4.	Are Team Member’s given health checks before each shift? (temp. taken, symptoms checked)?</label>
		  <select class="form-control" id="s_is_daily_certification" placeholder="" name="s_is_daily_certification">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6" style="display:none">		
		<div class="form-group">
		  <label for="case">5.	Does your location have a digital thermometer for team member use ?</label>
		  <select class="form-control" id="s_is_thermometer" placeholder="" name="s_is_thermometer">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">AGENT: Was there any cleaning that you are aware of at your place of employment?</label>
		  <select class="form-control" id="s_cleaning" placeholder="" name="s_cleaning">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
			<option value="N/A">N/A</option>
		  </select>
		</div>
	</div>
	
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">AGENT: May I ask what your current work status is, please?</label>
		   <select class="form-control" id="s_work_status" placeholder="" name="s_work_status" required>
			<option value="">-- Select Status --</option>
		  <?php foreach($caseTypes as $key=>$val){ ?>
			<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
		  <?php } ?>
		  </select>
		</div>
	</div>
	</div>
	
	<hr/>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">AGENT: Did you have any close contact with any other team members 48 hours prior to incident date?</label>
		  <select class="form-control" id="s_any_contact" placeholder="" name="s_any_contact">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
			<option value="N/A">N/A</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Notes:</label>
		  <textarea class="form-control" id="s_any_contact_notes" placeholder="" name="s_any_contact_notes"><?php echo !empty($crmdetails['cid']) ? $crmdetails['s_any_contact_notes'] : ''; ?></textarea>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">AGENT: Do you have any shortness of breath? (If yes, please advise to contact Primary Care Physician immediately)</label>
		  <select class="form-control" id="s_feeling" placeholder="" name="s_feeling">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Notes:</label>
		  <textarea class="form-control" id="s_feeling_notes" placeholder="" name="s_feeling_notes"><?php echo !empty($crmdetails['cid']) ? $crmdetails['s_feeling_notes'] : ''; ?></textarea>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">AGENT: May I ask what department you work in please?</label>
		  <select class="form-control" id="s_department" placeholder="" name="s_department">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Notes:</label>
		  <textarea class="form-control" id="s_department_notes" placeholder="" name="s_department_notes"><?php echo !empty($crmdetails['cid']) ? $crmdetails['s_department_notes'] : ''; ?></textarea>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">AGENT: Also, what shift do you work on please? </label>
		  <select class="form-control" id="s_shift" placeholder="" name="s_shift">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Notes:</label>
		  <textarea class="form-control" id="s_shift_notes" placeholder="" name="s_shift_notes"><?php echo !empty($crmdetails['cid']) ? $crmdetails['s_shift_notes'] : ''; ?></textarea>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">AGENT: Do you reside with any other Team Members employed at your same location? (Please add these individuals in your contact tracing)</label>
		  <select class="form-control" id="s_reside" placeholder="" name="s_reside">
			<option value="">-- Select --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Notes:</label>
		  <textarea class="form-control" id="s_reside_notes" placeholder="" name="s_reside_notes"><?php echo !empty($crmdetails['cid']) ? $crmdetails['s_reside_notes'] : ''; ?></textarea>
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
		
	<div class="col-md-12">	
	<hr/>	
	<?php if(get_login_type() != "client" || (get_login_type() != "client" && !is_access_follett_report())){ ?>
	<button type="submit" name="save" class="btn btn-success"><i class="fa fa-save"></i> Save & Next</button>
	<?php } ?>
	
	<?php if(!empty($crmdetails['s_is_symptom'])){ ?>
	<a href="<?php echo base_url()."contact_tracing_follett/form/" .$crmdetails['crm_id'] ."/condition/"; ?>" class="btn btn-primary pull-right"><i class="fa fa-angle-double-right"></i> Skip & Next</a>
	<?php } ?>
	
	</div>
	
	</form> 
  </div>
 </div>
  

</div>
</div>
<section>
</div>