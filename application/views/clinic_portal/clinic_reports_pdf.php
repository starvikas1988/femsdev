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
		<h4 class="form-title m-b-xl text-center"><b><u>CLINIC PATIENT DETAILS</u></b></h4>
				
		
		<h6 class="form-title m-b-xl text-left"><b><?php echo $patient_details['patient_code']; ?> - <?php echo $patient_details['c_name']; ?></b></h6>
		
		<div style="padding:0px 2px">
			
		<div class="row">	
		<div class="col-md-12">
		<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Patient ID</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $patient_details['patient_code']; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Name</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $patient_details['c_name']; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Gender</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $patient_details['c_gender'] == 'M' ? 'Male' : 'Female'; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Birthdate</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo date('d M, Y', strtotime($patient_details['c_birth'])); ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Address</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $patient_details['c_address']; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Blood Type</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $patient_details['c_blood']; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Allergy</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $patient_details['c_allergy']; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Pre-Existing Medical Conditions</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $patient_details['c_medical']; ?></th>
		</tr>
		<tr>
			<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Pre-Employment Medical Remarks</th>
			<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $patient_details['c_medical_remarks']; ?></th>
		</tr>
		</table>
		</div>
		</div>
		
		<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>
		
		<div class="row">	
		<div class="col-md-12">
		<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
		<tr style="background-color:#ccc">
			<th style="border: 1px solid #68696b;padding:10px 10px;text-align:center;width:100%;font-size:16px" colspan="7">DOCTOR'S CONSULTATION</th>
		</tr>
		<tr style="background-color:#f3f3f3">
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Date</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Chief Complaint</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Doctor's Assessment</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Doctor's Intervention</th>
		</tr>
		<?php $counter=0; foreach($medical_details as $token){ $counter++; ?>
		<tr style="font-size:10px">
			<td style="border: 1px solid #68696b;padding:5px 10px;text-align:center">
			<?php echo $token['d_date']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;">
			<?php echo $token['d_complaint']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<?php echo $token['d_assessment']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;">
			<?php echo $token['d_intervention']; ?>
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
			<th style="border: 1px solid #68696b;padding:10px 10px;text-align:center;width:100%;font-size:16px" colspan="7">ANNUAL PHYSICAL EXAMINATION</th>
		</tr>
		<tr style="background-color:#f3f3f3">
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:10%;">Year</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:16%;">Complete Blood Count</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:15%;">Urinalysis</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:16%;">Chest XRay PA</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:15%;">Drug Test</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:18%;">Physical Examination</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:16%;">Doctor's Clearance</th>
		</tr>
		<?php $counter=0; foreach($physical_details as $token){ $counter++; ?>
		<tr style="font-size:10px">
			<td style="border: 1px solid #68696b;padding:5px 10px;text-align:center">
			<?php echo $token['p_year']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;">
			<?php echo $token['p_cbc']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<?php echo $token['p_urinalysis']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;">
			<?php echo $token['p_xray']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;">
			<?php echo $token['p_drugtest']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;">
			<?php echo $token['p_physical']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;">
			<?php echo $token['p_clearance']; ?>
			</td>
		</tr>
		<?php } ?>
		</table>
		</div>
		</div>
		
	</div>
	
		<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>
		
		<hr/>		
		<p style="text-align:left;margin:0px 0px 0px 0px;font-size:10px">** Registered On <?php echo $patient_details['date_added']; ?> | <?php echo $patient_details['added_by_name']; ?></p>		
	
	</div>
	</div>
		
	
</section> 
</div>
