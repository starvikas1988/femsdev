<style>
.panel-heading{
	margin-bottom: 10px;
	font-weight:600;
}
.p-info{
	font-size:13px!important;
	line-height:1.5em!important;
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
  
    <form action="<?php echo base_url(); ?>contact_tracing_follett/submit_final_information" method="POST" autocomplete="off">
	
	<div class="row">
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">CRM ID NUMBER</label>
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
  <a href="<?php echo base_url()."contact_tracing_follett/form/" .$crmdetails['crm_id'] ."/exposure/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Case Details</a>
  </div>
  <div class="panel-body">
	
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Caller Test Result</label>
		   <?php
		  $caseResultType = $crmdetails['p_type_of_case'];
		  $styleColor = "background-color:#ccc;color:#000";
		  if($caseResultType == 'C' || $caseResultType == 'D'){
			  $styleColor = "background-color:#fffb8b;color:#000";
		  }
		  if($caseResultType == 'A' || $caseResultType == 'B' || $caseResultType == 'E'){
			  $styleColor = "background-color:#ff8b8b;color:#fff";
		  }
		  ?>
		  <input class="form-control" style="<?php echo $styleColor; ?>" id="f_test_result" placeholder="" value="<?php echo !empty($caseTypes[$caseResultType]) ? $caseTypes[$caseResultType] : "N/A"; ?>" name="f_test_result" readonly>
		</div>
	</div>
	</div>
	
	<hr/>
	
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">AGENT: Is there 1 or more Team Member who have been in contact with the Positive team member within the last 14 days?  </label>
		  <select class="form-control" id="f_individuals" placeholder="" name="f_individuals" required>
			<option value="">-- Select Option --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
			<option value="Unsure">Unsure</option>
		  </select>
		</div>
	</div>
	
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">AGENT: Are there other individuals who have tested positive that you aware of from your office within the last 14 days?</label>
		  <select class="form-control" id="f_other_individual" placeholder="" name="f_other_individual" required>
			<option value="">-- Select Option --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
			<option value="N/A">N/A</option>
		  </select>
		</div>
	</div>
	
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">AGENT: Are you still actively working onsite? </label>
		  <select class="form-control" id="f_is_positive_working" placeholder="" name="f_is_positive_working" required>
			<option value="">-- Select Option --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
			<option value="N/A">N/A</option>
		  </select>
		</div>
	</div>
	
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Is the caller a 3rd party (trash collector, police officer, someone who came in contact at the location but does not work there)? Or is the call about a 3rd Party?</label>
		  <select class="form-control" id="f_is_third_party" placeholder="" name="f_is_third_party" required>
			<option value="">-- Select Option --</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
			<option value="N/A">N/A</option>
		  </select>
		</div>
	</div>
	</div>
	
	<hr/>
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
	<p class="p-info">
	<b>A- </b>
	<span style="margin-left:10px">1. Notify TM location manager of the TM absence and estimated return to work date.</span>  <br/>
	<span style="margin-left:28px">2. Notify location manager to complete covid cleaning protocols of impacted TM work area.</span><br/> 
	<span style="margin-left:28px">3. Provide notification to TM MedLife and Sedgweg ( if believed to be work place infection) phone numbers.</span> <br/>
	<span style="margin-left:28px">4. (Retail Campus stores ONLY) Notify store regional manager of confirmed covid case ( no names) for Regional Manager to notify campus contact using approved template provided prior from asset protection.</span><br/>
	<span style="margin-left:28px"><b>All California Positive (A) Cases</b> email case report to  Erskin, Matthew @ merskin@follett.com</span><br/>
    <span style="margin-left:28px"><b>All New Mexico Positive (A) Cases</b>  email case report to  Sarkis Grigorian SGrigorian@follett.com</span><br/>
    <span style="margin-left:28px"><b>All California Positive (A) Cases</b> that have an additional  work place resulted/exposure email email case report to  Sarkis Grigorian SGrigorian@follett.com</span>
	</p>
	
	<p class="p-info">
	<b>B- </b> 
	<span style="margin-left:10px">1. Notify TM location manager of the TM absence and estimated return to work date.</span><br/>
	<span style="margin-left:28px">2. Notify location manager to complete covid cleaning protocols of impacted TM work area.</span><br/>
	<span style="margin-left:28px"><b>Close B Contact Case:</b> email to Sarkis Grigorian SGrigorian@follett.com</span>
	</p>
	
	<p class="p-info">
	<b>C- </b> <span style="margin-left:10px">1. Please inform TM to report or update at this number if there are any changes in medical condition or COVID test results.</span> 
	</p>
	
	<p class="p-info">
	<b>D- </b> <span style="margin-left:10px">1. Please inform TM to report or update at this number if there are any changes in medical condition or COVID test results.</span> 
	</p>
	
	<p class="p-info">
	<b>E- </b><span style="margin-left:10px">1. Please inform TM to report or update at this number if there are any changes in medical condition or COVID test results.</span> 
	</p>
	
	<p class="p-info">
	<b>F- </b>
	<span style="margin-left:10px">1. Please advise manager to begin covid cleaning protocols of impacted TM Work area.</span><br/> 
	<span style="margin-left:28px">2. Please call TM to check health update and verify information for Contact Tracing.</span><br/>
	<span style="margin-left:28px">3. Advise you will followup in 5 days.</span> 
	</p>
	<br/>
	<p class="p-info">
	<b>If your caller is Positive, please advise:</b><br/>
	You may apply for Short Term Disability or Family Medical Leave by calling MedLife at 888-343-6896.  If you believe your illness originated from your work place, you may report a claim to Worker's Compensation at 855-439-8393. <br/><br/>
	
	<b>For all other HR related questions, please direct your Team Member to:</b><br/>
	Go to <a target="_blank" href="https://folletthr.zendesk.com/hc/en-us">https://folletthr.zendesk.com/hc/en-us</a> <br/>
	Click either Submit a Ticket or Access Knowledge Base <br/>> Enter the email address you have marked as preferred in myHR <br/>> Enter the password you created when you setup your Ask HR/Zendesk account
	</p>
	</div>
	</div>
	</div>
	
	<hr/>
	
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Case Status : </label>
		  <select name="case_final_status" class="form-control">
				<option value="P" <?php echo $crmdetails['case_status'] == 'P' ? 'selected' : ''; ?>>Open</option>				
				<option value="C" <?php echo $crmdetails['case_status'] == 'C' ? 'selected' : ''; ?>>Closed</option>
		  </select>
		</div>
	</div>	
	</div>
	
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Comments, Notes and Follow-Up: </label>
		  <textarea class="form-control" id="f_notes" placeholder="" name="f_notes" required><?php echo !empty($crmdetails['cid']) ? $crmdetails['f_notes'] : ''; ?></textarea>
		</div>
	</div>	
	</div>
		
	</div>  
  </div>
  
  
  <div class="row">	
	<div class="col-md-12">
		  <p class="chatquote"><b>AGENT:</b>  I want to thank you for calling us today.  I really hope you get to feeling better quickly.  In the meantime, please remember if you are positive or you should become positive, you will need to isolate for 10 days from the date of your test, or your first symptom, whichever was earlier. If after those 10 days you have been symptom free for 48 hours without the use of any medication, you may stop your isolation.  If there are any changes to your health or any further tests to report, please do give us a call back here at the same number and we will update your case.  In the meantime, I will be checking back in with you in 5 days just to make sure you are doing well.  Do you have any questions for me before we disconnect today?</p> <br/>
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
	<button type="submit" name="save" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
	<?php } ?>
	</div>
	
	</form> 
  </div>
 </div>
  

</div>
</div>
<section>
</div>