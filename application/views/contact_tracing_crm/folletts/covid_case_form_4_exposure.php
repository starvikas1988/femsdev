<style>
.panel-heading{
	margin-bottom: 10px;
	font-weight:600;
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
  
    <form action="<?php echo base_url(); ?>contact_tracing_follett/submit_exposure" method="POST" autocomplete="off">
	
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
  <div class="panel-heading">Novel Coronavirus EXPOSURE TIMELINE
  <a href="<?php echo base_url()."contact_tracing_follett/form/" .$crmdetails['crm_id'] ."/condition/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Condition</a>
  </div>
  <div class="panel-body">
  
	<h5><b>Identifying Exposed Contacts and Sites of Transmission</b></h5>
	<br/>
	<div class="row">
	<div class="col-md-8">
		<div class="card" style="border: 1px solid #000;padding: 10px 30px;">
		  <div class="card-body">
			<h5 class="card-title"><b>collect locations of potential exposure and transmission for each date below:</b></h5>		
			<ul style="list-style-type: disc;">
			<li>Addresses and phone numbers of work & high risk settings</li>
			<li>Dates and times visited (if available, time of arrival and length of stay)</li>
			<li>Travel information (e.g., departure & arrival cities, method of transport, transport company, flight number)</li>
			<li>Remember to ask about stops at healthcare facilities, schools and child care centers</li>
			</ul>
		  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card" style="border: 1px solid #000;padding: 10px 30px;">
		  <div class="card-body">
			<h5 class="card-title"><b>Information about Contacts</b></h5>		
			<ul style="list-style-type: disc;">
			<li>Names and phone numbers of contacts</li>
			<li>Relation to case</li>
			<li>Are contacts symptomatic?</li>
			</ul>
			<br/>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row" style="margin-top:20px">
	<div class="col-md-12">	
	
	<table class="table">
	<thead>
		<tr>
			<th width="15%">#</th>
			<th width="20%">Date</th>
			<th width="5%">Day</th>
			<th width="30%">Locations (With Times)</th>
			<th width="30%">Contacts</th>
		</tr>
	</thead>
	<tbody>
	<?php
	// SYMPTOM DATE
	$symptomDate = $crmdetails['s_date_of_symptom'];
	$startCheckDate = !empty($symptomDate) && $symptomDate != '0000-00-00' ?  date('Y-m-d', strtotime('-2 day', strtotime($symptomDate))) : "";
	
	for($i=0; $i<17; $i++){
		$j = $i-2;
		$currentExposureDate = "";
		if(!empty($crmexposure[0]['e_date'])){ $currentExposureDate = $crmexposure[0]['e_date']; } else {
			$currentExposureDate = $startCheckDate;
		}
	?>
	<tr>
		<td class="">
		<b><?php
		if($j == 6){ echo "CONTAGIOUS PERIOD"; }
		if($j == 0){ echo "<span class='text-danger'>SYMPTOM ONSET</span>"; }
		?></b>
		</td>
		<td>
		<input class="form-control" type="text" value="<?php echo $currentExposureDate; ?>" name="e_date_<?php echo $i; ?>" id="e_date_<?php echo $i; ?>" <?php echo $j>-2?"readonly":""; ?>></input>
		</td>
		<td><?php echo $j; ?></td>
		<td><textarea class="form-control" id="e_location_<?php echo $i; ?>" name="e_location_<?php echo $i; ?>"><?php if(!empty($crmexposure[$i]['e_location'])){ echo $crmexposure[$i]['e_location']; } ?></textarea></td>
		<td><textarea class="form-control" id="e_contacts_<?php echo $i; ?>" name="e_contacts_<?php echo $i; ?>"><?php if(!empty($crmexposure[$i]['e_contacts'])){ echo $crmexposure[$i]['e_contacts']; } ?></textarea></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>	
	
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
	
	<?php if(!empty($currentExposureDate) || $crmdetails['s_is_symptom'] == 'No'){ ?>
	<a href="<?php echo base_url()."contact_tracing_follett/form/" .$crmdetails['crm_id'] ."/final/"; ?>" class="btn btn-primary pull-right"><i class="fa fa-angle-double-right"></i> Skip & Next</a>
	<?php } ?>
	
	</div>
	
	</form> 
  </div>
 </div>

</div>
</div>
<section>
</div>