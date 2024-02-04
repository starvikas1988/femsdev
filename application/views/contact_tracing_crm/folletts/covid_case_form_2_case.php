<style>
.panel-heading{
	margin-bottom: 10px;
	font-weight:600;
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
  
    <form action="<?php echo base_url(); ?>contact_tracing_follett/submit_case_information" method="POST" autocomplete="off">
	
	<div class="row">
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">CASE ID NUMBER</label>
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
  <a href="<?php echo base_url()."contact_tracing_follett/form/" .$crmdetails['crm_id'] ."/personal/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Personal Details</a>
  </div>
  <div class="panel-body">
	
	<div class="row">	
	<div class="col-md-12">
		  <p class="chatquote"><b>(If caller has not told you status of their health, please proceed with the following)
		  <br/>AGENT: I'm sorry you're going through this.  Can you please verify for me where you believe you were exposed?</b>
		  <br/><br/>
		  <select style="width:40%" class="form-control" id="p_is_incident" placeholder="" name="p_is_incident" required>
			<option value="">-- Select Status --</option>
			<option value="Yes">Yes</option>
			<option value="no">No</option>
		  </select>
		  <br/>
		  </p><br/>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">If "yes", please provide info. here</label>
		  <textarea class="form-control" id="p_incident" placeholder="" name="p_incident"><?php echo !empty($crmdetails['cid']) ? $crmdetails['p_incident'] : ''; ?></textarea>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Exposure Status : </label>
		  <select class="form-control" id="p_type_of_case" placeholder="" name="p_type_of_case" required>
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
	  <label for="case">Has Team Member Been Diagnosed as Positive?</label>
	  <select class="form-control" id="p_is_diagonised" placeholder="" name="p_is_diagonised" required>
		<option value="">-- Select Option --</option>
		<option value="Yes">Yes</option>
		<option value="No">No</option>
		<option value="Awaiting Results">Awaiting Results</option>
	  </select>
	</div>
	</div>
	
	<div class="col-md-6">	
	<div class="form-group">
	  <label for="case">Date of Test</label>
	  <input type="text" class="form-control newDatePick" id="p_date_of_test" value="<?php echo !empty($crmdetails['p_date_of_test']) ? date('m/d/Y', strtotime($crmdetails['p_date_of_test'])) : ''; ?>" placeholder="" name="p_date_of_test">
	</div>
	</div>
	
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">If "yes", please provide info. here</label>
		  <textarea class="form-control" id="p_is_diagonised_details" placeholder="" name="p_is_diagonised_details" required><?php echo !empty($crmdetails['cid']) ? $crmdetails['p_is_diagonised_details'] : ''; ?></textarea>
		</div>
	</div>	
	</div>
	
	<hr/>
	
	<div class="row">
	<div class="col-md-6" style="display:none">		
		<div class="form-group">
		  <label for="case">Team Member's Store Location :</label>
		  <textarea class="form-control" id="p_store_location" placeholder="" name="p_store_location"><?php echo !empty($crmdetails['cid']) ? $crmdetails['p_store_location'] : ''; ?></textarea>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Date of Expected Results :</label>
		  <input type="text" class="form-control newDatePick" id="p_date_of_result" value="<?php echo !empty($crmdetails['p_date_of_result']) ? date('m/d/Y', strtotime($crmdetails['p_date_of_result'])) : ''; ?>" placeholder="" name="p_date_of_result">
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
	
	<?php if(!empty($crmdetails['p_type_of_case'])){ ?>
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