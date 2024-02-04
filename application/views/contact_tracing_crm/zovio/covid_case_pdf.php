<style>
body {
	background: #ffffff;
	font-family: "apercu", sans-serif,"Helvetica Neue", Helvetica, Arial;
	font-size: 13px;
	line-height: 1.4;
	color: #67686a;
	/*#6a6c6f*/
}
.text-center{
	text-align:center;
}
.form-title{
	font-size:16px;
}
th{
	font-size:12px;
}
td{
	font-size:10px;
}

</style>

<div class="wrap">
	<section class="app-content">	
	
	
		<div class="simple-page-wrap" style="width:100%;">
		<div class="simple-page-form">
		<h4 class="form-title m-b-xl text-center"><b><u>CONTACT TRACING - ZOVIO</u></b></h4>
				
		
		<h6 class="form-title m-b-xl text-left">
		<b><?php echo $crm_details['crm_id']; ?> - <?php echo $crm_details['fname'] ." " .$crm_details['lname']; ?>
		<br/>Case Status : <?php echo $crm_details['case_status'] == 'C' ? '<span style="color:green">Closed</span>' : '<span style="color:red">Open</span>'; ?>
		</b><br/>		
		</h6>
		<div style="padding:0px 2px">
			
		<div class="row">	
		<div class="col-md-12">
		<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">CASE ID</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $crm_details['crm_id']; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Name</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $crm_details['fname'] ." " . $crm_details['lname']; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Call Date</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['date_of_call']) ? $crm_details['date_of_call'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Phone</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['caller_phone']) ? $crm_details['caller_phone'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Secondary Phone</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['store_phone']) ? $crm_details['store_phone'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Work Location/Dept</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['caller_store_location']) ? $crm_details['caller_store_location'] : "-"; ?></th>
		</tr>
		</table>
		</div>
		</div>
		
		<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>
		
		<div class="row">	
		<div class="col-md-12">
		<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
		<tr style="background-color:#ccc">
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px" colspan="2">CASE DETAILS</th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Were You Exposed?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['p_incident']) ? $crm_details['p_incident'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Exposure Info</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['p_incident']) ? $crm_details['p_incident'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Type of Case</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($caseTypes[$crm_details['p_type_of_case']]) ? $caseTypes[$crm_details['p_type_of_case']] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Is Diagnosed as Positive?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['p_is_diagonised']) ? $crm_details['p_is_diagonised'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Diagnosed Details</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['p_is_diagonised_details']) ? $crm_details['p_is_diagonised_details'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Date of Test</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['p_date_of_test']) ? $crm_details['p_date_of_test'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Date of Expected Results</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['p_date_of_result']) ? $crm_details['p_date_of_result'] : "-"; ?></th>
		</tr>
		</table>
		</div>
		</div>
		
		
		<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>
		
		<div class="row">	
		<div class="col-md-12">
		<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
		<tr style="background-color:#ccc">
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px" colspan="2">CASE STATUS & CONDITION</th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Symptoms</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_symptoms']) ? $crm_details['s_symptoms'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Was caller exposed at place of work?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_exposure_event']) ? $crm_details['s_exposure_event'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Notes</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_exposure_notes']) ? $crm_details['s_exposure_notes'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">When did caller last work?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_last_work']) ? $crm_details['s_last_work'] : "-"; ?></th>
		</tr>
		<!--
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">When did the caller start having symptoms ?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_date_of_symptom']) ? $crm_details['s_date_of_symptom'] : "-"; ?></th>
		</tr>-->
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">When did you begin your isolation or quarantine please?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_date_isolating']) ? $crm_details['s_date_isolating'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Have you tested positive for COVID-19 within the past three months and recovered ?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_is_symptom']) ? $crm_details['s_is_symptom'] : "-"; ?></th>
		</tr>
		<!--<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Are COVID safety protocols followed at your place of employment?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_protocol_followed']) ? $crm_details['s_protocol_followed'] : "-"; ?></th>
		</tr>-->
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Was there any cleaning that you are aware of at your place of employment?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_cleaning']) ? $crm_details['s_cleaning'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">May I ask what your current work status is, please?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($workTypes[$crm_details['s_work_status']]) ? $workTypes[$crm_details['s_work_status']] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Did you have any close contact with anyone else 48 hours prior to incident date? </th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_any_contact']) ? $crm_details['s_any_contact'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Notes</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_any_contact_notes']) ? $crm_details['s_any_contact_notes'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Do you have any shortness of breath?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_feeling']) ? $crm_details['s_feeling'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Notes</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['s_feeling_notes']) ? $crm_details['s_feeling_notes'] : "-"; ?></th>
		</tr>
		</table>
		</div>
		</div>
		
		
		
		<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>
		
		<div class="row">	
		<div class="col-md-12">
		<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
		<tr style="background-color:#ccc">
			<th style="border: 1px solid #68696b;padding:10px 10px;text-align:center;width:100%;font-size:16px" colspan="7">EXPOSURE</th>
		</tr>
		<tr style="background-color:#f3f3f3">
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">#</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Date</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Day</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Locations (With Times)</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Contacts</th>
		</tr>
		<?php
		// SYMPTOM DATE
		$symptomDate = $crm_details['s_date_isolating'];
		$startCheckDate = !empty($symptomDate) && $symptomDate != '0000-00-00' ?  date('Y-m-d', strtotime('-2 day', strtotime($symptomDate))) : "";
		
		for($i=0; $i<17; $i++){
			$j = $i-2;
			$currentExposureDate = "";
			if(!empty($crmexposure[$i]['e_date'])){ $currentExposureDate = $crmexposure[$i]['e_date']; } else {
				$currentExposureDate = date('Y-m-d', strtotime("+".$i ." day", strtotime($startCheckDate)));
			}
		?>
		<tr style="font-size:10px">
			<td style="border: 1px solid #68696b;padding:5px 10px;text-align:center">
			<b><?php
			if($j == 6){ echo "CONTAGIOUS PERIOD"; }
			if($j == 0){ echo "<span class='text-danger'>SYMPTOM ONSET</span>"; }
			?></b>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;">
			<?php echo $currentExposureDate; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;">
			<?php echo $j; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<?php if(!empty($crmexposure[$i]['e_location'])){ echo $crmexposure[$i]['e_location']; } ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;">
			<?php if(!empty($crmexposure[$i]['e_contacts'])){ echo $crmexposure[$i]['e_contacts']; } ?>
			</td>
		</tr>
		<?php } ?>
		</table>
		</div>
		</div>
		
		<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>
		
		<div class="row">	
		<div class="col-md-12">
		<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
		<tr style="background-color:#ccc">
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px" colspan="2">FINAL SECTION</th>
		</tr>
		<?php
		  $caseResultType = $crm_details['p_type_of_case'];
		  $styleColor = "background-color:#ccc;color:#000";
		  if($caseResultType == 'C' || $caseResultType == 'D'){
			  $styleColor = "background-color:#fffb8b;color:#000";
		  }
		  if($caseResultType == 'A' || $caseResultType == 'B' || $caseResultType == 'E'){
			  $styleColor = "background-color:#ff8b8b;color:#fff";
		  }
		?>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Caller Test Result</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($caseTypes[$caseResultType]) ? $caseTypes[$caseResultType] : "N/A"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Have you been in contact with anyone who has tested Positive within the last 14 days?  </th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['f_individuals']) ? $crm_details['f_individuals'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Are there other individuals who have tested positive that you aware of from the same location within the last 14 days?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['f_other_individual']) ? $crm_details['f_other_individual'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Are you still actively working onsite?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['f_is_positive_working']) ? $crm_details['f_is_positive_working'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Is the caller a 3rd party (trash collector, police officer, someone who came in contact at the location but does not work there)? Or is the call about a 3rd Party?</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['f_is_third_party']) ? $crm_details['f_is_third_party'] : "-"; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Notes</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
			<?php echo !empty($crm_details['f_notes']) ? $crm_details['f_notes'] : "-"; ?></th>
		</tr>
		</table>
		</div>
		</div>
		
	</div>
	
		<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>
		
		<hr/>		
		<p style="text-align:left;margin:0px 0px 0px 0px;font-size:10px">** Added On <?php echo $crm_details['date_added']; ?> | <?php echo $crm_details['added_by_name']; ?></p>		
	
	</div>
	</div>
		
	
</section> 
</div>
