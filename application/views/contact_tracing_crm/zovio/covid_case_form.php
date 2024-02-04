
<?php
$data['mysections'] = $mysections;
$data['extraFormCheck'] = $extraFormCheck;
$data['urlSection'] = $urlSection;
$data['crmid'] = $crmid;
$this->load->view('contact_tracing_crm/zovio/covid_case_navbar', $data);
?>

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

  <h4>Contact Tracing Zovio
  <p class="timerClock pull-right"><i class="fa fa-clock-o"></i> <span id="timeWatch"></span></p>
  </h4>
  <hr/>
  
<div class="panel panel-default">
  <div class="panel-heading">Case Information</div>
  <div class="panel-body">
  
    <form action="<?php echo base_url(); ?>contact_tracing_crm/submit_personal_information" method="POST" autocomplete="off">
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">CASE ID NUMBER</label>
		  <input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crmid; ?>" name="crm_id" readonly>
		  <input type="hidden" class="form-control" id="time_interval" placeholder="" value="" name="time_interval" readonly>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Call Date</label>
		  <input type="text" class="form-control oldDatePick" id="date_of_call" placeholder="" value="<?php echo !empty($crmdetails['cid']) ? date('m/d/Y', strtotime($crmdetails['date_of_call'])) : date('m/d/Y', strtotime($currentDate)); ?>"  name="date_of_call">
		</div>
	</div>
	</div>
		
	
</div>
</div>
	
	
<div class="panel panel-default">
  <div class="panel-heading">Team Member Information</div>
  <div class="panel-body">
	
	<div class="row">	
	<div class="col-md-12">
		  <p class="chatquote">Hello, thank you for calling Zovio Health and Healing Support Line, this is <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>.  Who do I have the pleasure of speaking with today?  (Thank customer after each request)</p> <br/>
	</div>
	<div class="col-md-12">
		  <p class="chatquote">May I please verify the spelling of both your first and last name?</p> <br/>
	</div>
	</div>
	
	<div class="row">	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">First Name : **</label>
		  <input type="text" class="form-control" id="case_fname" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['fname'] : ''; ?>" placeholder="" name="case_fname" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Last Name : **</label>
		  <input type="text" class="form-control" id="case_lname" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['lname'] : ''; ?>" placeholder="" name="case_lname" required>
		</div>
	</div>
	</div>
	
	<div class="row">	
	<div class="col-md-12">
		  <p class="chatquote">Next may I please verify your phone number?</p> <br/>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Caller's Phone : **</label>
		  <input type="text" class="form-control" id="caller_phone" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['caller_phone'] : ''; ?>" placeholder="" name="caller_phone" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Secondary Phone :</label>
		  <input type="text" class="form-control" id="store_phone" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['store_phone'] : ''; ?>" placeholder="" name="store_phone">
		</div>
	</div>
	</div>
	
	<div class="row">	
	<div class="col-md-6">
		  <p class="chatquote">May I please have your work location and Department?</p> <br/>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Caller's Work Location/Dept</label>
		  <textarea class="form-control" id="caller_store_location" placeholder="" name="caller_store_location"><?php echo !empty($crmdetails['cid']) ? $crmdetails['caller_store_location'] : ''; ?></textarea>
		</div>
	</div>
	<!--<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Manager Name</label>
		  <input type="text" class="form-control number-only" value="<?php echo !empty($crmdetails['cid']) ? $crmdetails['caller_manager_name'] : ''; ?>" id="caller_manager_name" placeholder="" name="caller_manager_name">
		</div>
	</div>-->
	</div>
	
	<div class="row">	
	<div class="col-md-12">
		  <p class="chatquote chatimp"><b>AGENTS-VERIFY ALL INFORMATION IS CORRECT BEFORE PROCEEDING</b></p> <br/>
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
	<?php if(get_login_type() != "client" || (get_login_type() != "client" && !is_access_zovio_report())){ ?>
	<button type="submit" name="save" class="btn btn-success"><i class="fa fa-save"></i> Save & Next</button>
	<?php } ?>
	<?php if(!empty($crmdetails['cid'])){ ?>
	<a href="<?php echo base_url()."contact_tracing_crm/form/" .$crmdetails['crm_id'] ."/case/"; ?>" class="btn btn-primary pull-right"><i class="fa fa-angle-double-right"></i> Skip & Next</a>
	<?php } ?>
	</div>
	
	</form> 
  </div>
 </div>
 
  

</div>
</div>
<section>
</div>