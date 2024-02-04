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
  
    <form action="<?php echo base_url(); ?>contact_tracing/submit_risk_response" method="POST" autocomplete="off">
	
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
  <div class="panel-heading">RISK AND RESPONSE SOURCE OF ILLNESS FOR CASE (Complete AFTER interview for data entry)
  <a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/exposure/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Exposure Timeline</a>
  </div>
  <div class="panel-body">
	
	
	<div class="row">
	<div class="col-md-2">		
		<div class="form-group">
		<label>Is the patient (check all that apply)</label>
		</div>
	</div>
	
	<div class="col-md-7">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="checkbox" value="HEALTHCARE" name="r_patient_1[]"> Healthcare worker</label>
			<label><input type="checkbox" value="USMILITARY" name="r_patient_1[]"> US military</label>
			<label><input type="checkbox" value="FLIGHTCREW" name="r_patient_1[]"> Flight crew</label>
			<label><input type="checkbox" value="SCHOOL" name="r_patient_1[]"> Associated with school</label>
			<label><input type="checkbox" value="LONGTERM" name="r_patient_1[]"> Associated with Long-Term Care/Rehab/Retirement Center</label>
			<label><input type="checkbox" value="PRISON" name="r_patient_1[]"> Associated with a prison</label>
			<label><input type="checkbox" value="HOMELESS" name="r_patient_1[]"> Living homeless</label>
			<label><input type="checkbox" value="COMPROMISED" name="r_patient_1[]"> Immune compromised</label>
			<label><input type="checkbox" value="EMS" name="r_patient_1[]"> EMS/First responder</label>
			<label><input type="checkbox" value="OTHER" name="r_patient_1[]"> Other position of concern</label>
		</div>
		</div>
	</div>
	
	<div class="col-md-3">		
		<div class="form-group">
			<input type="text" class="form-control" id="r_patient_1_other" placeholder="Other Position" name="r_patient_1_other">
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-6">	
	<div class="form-group">
		<label for="case"><br/></label>
	</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-12">		
		<div class="form-group">
		<label>ITravel – during the 14 days before symptom onset did you travel?</label>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-12">		
		
		<table class="table table-bordered">
		<thead>
			<tr>
				<th width="10%">#</th>
				<th width="30%">Setting 1</th>
				<th width="30%">Setting 2</th>
				<th width="30%">Setting 3</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Travel out of:</td>
				<td>
				
				<div class="checklist">
				<label><input type="checkbox" value="COUNTRY" name="r_setting_1[]"> Country</label>
				<label><select class="form-control" id="r_setting_1_country" placeholder="" name="r_setting_1_country">
				 <option value="">--- Select Country ---</option>
				  <?php foreach($allCountries as $eachCountry){ ?>
						<option value="<?php echo $eachCountry['name']; ?>" cid="<?php echo $eachCountry['id']; ?>"><?php echo $eachCountry['name']; ?></option>
				  <?php } ?>
				</select></label>
				</div>
				<br/>
				<div class="checklist">
				<label><input type="checkbox" value="STATE" name="r_setting_1[]"> State</label>
				<label><select class="form-control" id="r_setting_1_state" placeholder="" name="r_setting_1_state">
					<option>--- Select State ----</option>
				</select></label>
				</div>
				<br/>
				<div class="checklist">
				<label><input type="checkbox" value="CITY" name="r_setting_1[]"> County/City</label>
				<label><input type="text" class="form-control" id="r_setting_1_city" placeholder="" name="r_setting_1_city"></label>
				</div>
				</td>
				
				<td>
				<div class="checklist">
				<label><input type="checkbox" value="COUNTRY" name="r_setting_2[]"> Country</label>
				<label><select class="form-control" id="r_setting_2_country" placeholder="" name="r_setting_2_country">
				 <option value="">--- Select Country ---</option>
				  <?php foreach($allCountries as $eachCountry){ ?>
						<option value="<?php echo $eachCountry['name']; ?>" cid="<?php echo $eachCountry['id']; ?>"><?php echo $eachCountry['name']; ?></option>
				  <?php } ?>
				</select></label>
				</div>
				<br/>
				<div class="checklist">
				<label><input type="checkbox" value="STATE" name="r_setting_2[]"> State</label>
				<label><select class="form-control" id="r_setting_2_state" placeholder="" name="r_setting_2_state">
					<option>--- Select State ----</option>
				</select></label>
				</div>
				<br/>
				<div class="checklist">
				<label><input type="checkbox" value="CITY" name="r_setting_2[]"> County/City</label>
				<label><input type="text" class="form-control" id="r_setting_2_city" placeholder="" name="r_setting_2_city"></label>
				</div>				
				</td>
				
				<td>
				<div class="checklist">
				<label><input type="checkbox" value="COUNTRY" name="r_setting_3[]"> Country</label>
				<label><select class="form-control" id="r_setting_3_country" placeholder="" name="r_setting_3_country">
				 <option value="">--- Select Country ---</option>
				  <?php foreach($allCountries as $eachCountry){ ?>
						<option value="<?php echo $eachCountry['name']; ?>" cid="<?php echo $eachCountry['id']; ?>"><?php echo $eachCountry['name']; ?></option>
				  <?php } ?>
				</select></label>
				</div>
				<br/>
				<div class="checklist">
				<label><input type="checkbox" value="STATE" name="r_setting_3[]"> State</label>
				<label><select class="form-control" id="r_setting_3_state" placeholder="" name="r_setting_3_state">
					<option>--- Select State ----</option>
				</select></label>
				</div>
				<br/>
				<div class="checklist">
				<label><input type="checkbox" value="CITY" name="r_setting_3[]"> County/City</label>
				<label><input type="text" class="form-control" id="r_setting_3_city" placeholder="" name="r_setting_3_city"></label>
				</div>
				</td>
			</tr>
			
			
			<tr>
				<td>Start and end dates</td>
				<td>
				<div class="checklist">
				<label>Start</label>
				<label><input type="text" class="form-control" id="r_setting_1_start" placeholder="" name="r_setting_1_start"></label>
				</div>
				<div class="checklist">
				<label>End</label>
				<label><input type="text" class="form-control" id="r_setting_1_end" placeholder="" name="r_setting_1_end"></label>
				</div>
				</td>
				
				<td>
				<div class="checklist">
				<label>Start</label>
				<label><input type="text" class="form-control" id="r_setting_2_start" placeholder="" name="r_setting_2_start"></label>
				</div>
				<div class="checklist">
				<label>End</label>
				<label><input type="text" class="form-control" id="r_setting_2_end" placeholder="" name="r_setting_2_end"></label>
				</div>
				</td>
				
				<td>
				<div class="checklist">
				<label>Start</label>
				<label><input type="text" class="form-control" id="r_setting_3_start" placeholder="" name="r_setting_3_start"></label>
				</div>
				<div class="checklist">
				<label>End</label>
				<label><input type="text" class="form-control" id="r_setting_3_end" placeholder="" name="r_setting_3_end"></label>
				</div>
				</td>
			</tr>
			
			
			
		</tbody>
		</table>
		
	</div>
	</div>
		
		
	
	
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
			<label><input type="radio" value="Y" onclick="r_risk_1_validator(this)" name="r_risk_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="N" onclick="r_risk_1_validator(this)" name="r_risk_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-1">		
		<div class="form-group">
		  <div class="checklist">
			<label><input type="radio" value="UNK" onclick="r_risk_1_validator(this)" name="r_risk_1" required></label>
		  </div>
		</div>
	</div>
	<div class="col-md-9">		
		<div class="form-group">
		  <label for="case">In the 14 days prior to symptom onset, did the patient have close contact with a confirmed or probable coronavirus case</label>
		</div>
	</div>
	</div>
	
	
	
	
	<div class="row ioptions">
	<hr/>
	<div class="col-md-3">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-3">		
		<div class="form-group">
		  <div class="checklist">
			<label>Contact Start Date</label>
			<label><input type="text" class="form-control" value="" name="r_risk_1_start" id="r_risk_1_start" required></label>
		  </div>  
		</div>
	</div>
	
	<div class="col-md-3">		
		<div class="form-group">
		  <div class="checklist">
			<label>Contact End Date</label>
			<label><input type="text" class="form-control" value="" name="r_risk_1_end" id="r_risk_1_end" required></label>
		  </div>  
		</div>
	</div>
	</div>
	
	
	<div class="row ioptions">
	<div class="col-md-3">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-3">		
		<div class="form-group">
			<label>WDRS # of contact</label>
			<input type="text" class="form-control" value="" name="r_risk_2_wdrs" id="r_risk_2_wdrs" required> 
		</div>
	</div>
	
	<div class="col-md-3">		
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" value="" name="r_risk_2_name" id="r_risk_2_name" required> 
		</div>
	</div>
	
	<div class="col-md-3">		
		<div class="form-group">
			<label>DOB (Optional)</label>
			<input type="text" class="form-control" value="" name="r_risk_2_dob" id="r_risk_2_dob">  
		</div>
	</div>
	</div>
	
	
	
	
	
	<div class="row ioptions">
	<hr/>
	<div class="col-md-3">		
		<div class="form-group">
		<label>Suspected exposure setting</label>
		</div>
	</div>
	<div class="col-md-9">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="checkbox" value="DAYCARE" name="r_risk_3[]" required> Day care/childcare</label>
			<label><input type="checkbox" value="SCHOOL" name="r_risk_3[]" required> School (not college)</label>
			<label><input type="checkbox" value="HOME" name="r_risk_3[]" required> Home</label>
			<label><input type="checkbox" value="WORK" name="r_risk_3[]" required> Work</label>
			<label><input type="checkbox" value="COLLEGE" name="r_risk_3[]" required> College</label>
			<label><input type="checkbox" value="TRANSIT" name="r_risk_3[]" required> Transit</label>
			<label><input type="checkbox" value="MILITARY" name="r_risk_3[]" required> Military</label>
			<label><input type="checkbox" value="DOCTOR" name="r_risk_3[]" required> Doctor’s office</label>
			<label><input type="checkbox" value="HOSPITALWARD" name="r_risk_3[]" required> Hospital ward</label>
			<label><input type="checkbox" value="HOSPITAL" name="r_risk_3[]" required> Hospital outpatient facility</label>
			<label><input type="checkbox" value="LONGTERM" name="r_risk_3[]" required> Long term care facility</label>
			<label><input type="checkbox" value="LABORATORY" name="r_risk_3[]" required> Laboratory</label>
			<label><input type="checkbox" value="RESTAURANT" name="r_risk_3[]" required> Restaurant</label>
			<label><input type="checkbox" value="CORRECTIONAL" name="r_risk_3[]" required> Correctional facility</label>
			<label><input type="checkbox" value="WORSHIP" name="r_risk_3[]" required> Place of worship</label>
			<label><input type="checkbox" value="HOMELESS" name="r_risk_3[]" required> Homeless/shelter</label>
			<label><input type="checkbox" value="INTERNATIONAL" name="r_risk_3[]" required> International travel</label>
			<label><input type="checkbox" value="HOTEL" name="r_risk_3[]" required> Out of state travel</label>
			<label><input type="checkbox" value="OTHER" name="r_risk_3[]" required> Hotel/motel/hostel</label>
			<label><input type="checkbox" value="SOCIAL" name="r_risk_3[]" required> Social event</label>
			<label><input type="checkbox" value="PUBLIC" name="r_risk_3[]" required> Large public gathering</label>
			<label><input type="checkbox" value="OTHER" name="r_risk_3[]" required> Other</label>
			<label><input type="text" class="form-control" placeholder="Enter Other Exposure" name="r_risk_3_other" id="r_risk_3_other"></label>
		</div>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-3">		
		<div class="form-group">
		</div>
	</div>
	<div class="col-md-9">		
		<div class="form-group">
			<label>Describe :</label>
			<input type="text" class="form-control" value="" name="r_risk_3_describe" id="r_risk_3_describe"> 
		</div>
	</div>
	</div>
	
	
	</div>  
  </div>
  
  
  
  
 <div class="panel panel-default">
  <div class="panel-heading">Remarks</div>
  <div class="panel-body"> 
		
	<button type="submit" name="save" class="btn btn-success">Save & Next</button>
	
	<?php if(!empty($crmdetails['r_risk_1'])){ ?>
	<a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/aftercase/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	
	</form> 
  </div>
 </div>
  
  

</div>
</div>
<section>
</div>