<style>
.customRadio{
	padding-left:20px;
}
.customRadio input{
	margin-right:10px;
}
.multipleOthersText{
	margin-left:25px;
	width:60%;
}

.oddRow{
	padding:4px 0px 4px 2px;
	background-color: #f7f7f7;
}
.evenRow{
	padding:4px 0px 4px 2px;
}
.qCircle{
	padding:5px 10px;
	border-radius:50%;
	background-color:#000;
	color:#fff;
	margin-right:6px;
}
.panelQ{
	font-size:14px;
	font-weight:600;
}
</style>
<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">	
 
 <div class="row">	
  <div class="col-md-12">
  <h4><i class="fa fa-stethoscope"></i> Clinic Portal
  <?php if($this->uri->segment(3) == 'edit'){ ?>
   <a onclick="javascript:window.close()" class="btn btn-danger btn-sm" style="float:right"><i class="fa fa-arrow-left"></i> Go Back</a>
  <?php } ?>
  </h4>
  </div>
 </div>
  
 
  <hr/>
  <!--<h5><b>NAME: </b>&nbsp;&nbsp;<u>&nbsp;<?php echo $user_details['fname'] ." " .$user_details['lname']; ?>&nbsp;</u></h5>
  <p>Please enter the patient details!</p>
  <hr/>-->
  
  <form method="POST" action="<?php echo base_url('clinic_portal/addPatient'); ?>" autocomplete="off">
  
    <div class="row">	
	<div class="col-md-9">
		<div class="form-group row">
		  <label for="case" class="col-md-5">Name : **</label>
		  <div class="col-md-7">
		  <input type="hidden" class="form-control" id="c_patient_id" placeholder="" name="c_patient_id" value="<?php echo $patient_id; ?>">
		  <input type="text" class="form-control" id="c_name" placeholder="" name="c_name" value="<?php echo !empty($patient_details['c_name']) ? $patient_details['c_name'] : ''; ?>" required>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row">
		<div class="col-md-9">
		<div class="form-group row">
		  <label for="case" class="col-md-5">Birthdate : **</label>
		  <div class="col-md-7">
		  <input type="date" class="form-control" id="c_birthdate" placeholder="" name="c_birthdate" value="<?php echo !empty($patient_details['c_birth']) ? $patient_details['c_birth'] : ''; ?>" required>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-9">
		<div class="form-group row">
		  <label for="case" class="col-md-5">Gender : **</label>
		  <div class="col-md-7">
		  <select class="form-control" id="c_gender" placeholder="" name="c_gender" required>
			<option value="M">Male</option>
			<option value="F">Female</option>
		  </select>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row">
		<div class="col-md-9">
		<div class="form-group row">
		  <label for="case" class="col-md-5">Address : **</label>
		  <div class="col-md-7">
		  <textarea class="form-control" id="c_address" placeholder="" name="c_address" required><?php echo !empty($patient_details['c_address']) ? $patient_details['c_address'] : ''; ?></textarea>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row">
		<div class="col-md-9">
		<div class="form-group row">
		  <label for="case" class="col-md-5">Blood Type : **</label>
		  <div class="col-md-7">
		  <select class="form-control" id="c_blood" placeholder="" name="c_blood" required>
			<option value="A+">A+</option>
			<option value="A-">A-</option>
			<option value="B+">B+</option>
			<option value="B-">B-</option>
			<option value="O+">O+</option>
			<option value="O-">O-</option>
			<option value="AB+">AB+</option>
			<option value="AB-">AB-</option>
		  </select>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row">
		<div class="col-md-9">
		<div class="form-group row">
		  <label for="case" class="col-md-5">Known Allergies : **</label>
		  <div class="col-md-7">
		  <textarea class="form-control" id="c_allergy" placeholder="" name="c_allergy" required><?php echo !empty($patient_details['c_allergy']) ? $patient_details['c_allergy'] : ''; ?></textarea>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row">
		<div class="col-md-9">
		<div class="form-group row">
		  <label for="case" class="col-md-5">Pre-Existing Medical Conditions : **</label>
		  <div class="col-md-7">
		  <textarea class="form-control" id="c_medical" placeholder="" name="c_medical" required><?php echo !empty($patient_details['c_medical']) ? $patient_details['c_medical'] : ''; ?></textarea>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row">
		<div class="col-md-9">
		<div class="form-group row">
		  <label for="case" class="col-md-5">Pre-Employment Medical Remarks : **</label>
		  <div class="col-md-7">
		  <textarea class="form-control" id="c_medical_remarks" placeholder="" name="c_medical_remarks" required><?php echo !empty($patient_details['c_medical_remarks']) ? $patient_details['c_medical_remarks'] : ''; ?></textarea>
		  </div>
		</div>
	</div>
	</div>
	
  <hr/>
  
  
  
		<div class="row">	
		<div class="col-md-12">
		<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
		<tr style="background-color:#f3f3f3">
			<th style="border: 1px solid #68696b;padding:15px 10px;text-align:center;font-size:16px" colspan="5">DOCTOR'S CONSULTATION</th>
		</tr>
		<tr style="background-color:#f3f3f3">
		    <th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:12%;">Date</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:25%;">Chief Complaint</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:25%;">Doctor's Assessment</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:33%;">Doctor's Intervention</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:5%;"></th>
		</tr>
		<?php $counter=0; foreach($medical_details as $token){ $counter++; ?>
		<tr style="font-size:10px">
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<input type="date" class="form-control" style="width:100%" placeholder="" name="d_date[]" value="<?php echo $token['d_date']; ?>" required>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="d_complaint[]" required><?php echo $token['d_complaint']; ?></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="d_assessment[]" required><?php echo $token['d_assessment']; ?></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="d_intervention[]" required><?php echo $token['d_intervention']; ?></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<input type="hidden" name="d_ref_id[]" value="<?php echo $token['d_id']; ?>">
			<input type="hidden" name="d_patient_id[]" value="<?php echo $token['patient_id']; ?>">
			<?php if($counter > 1){ ?>
			<a onclick="return confirm('Are you sure, you want to delete this record?')" href="<?php echo base_url('clinic_portal/del_patient_consult/'.$token['patient_id'].'/'.$token['d_id']); ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
			<?php } ?>
			</td>
		</tr>
		<?php } ?>
		
		
		<?php if($counter == 0){ ?>
		<tr style="font-size:10px">
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<input type="date" class="form-control" style="width:100%" placeholder="" name="d_date[]" value="" required>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="d_complaint[]" value="" required></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="d_assessment[]" value="" required></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="d_intervention[]" value="" required></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<input type="hidden" name="d_ref_id[]" value="">
			<input type="hidden" name="d_patient_id[]" value="<?php echo $patient_id; ?>">
			<button type="button" onclick="$(this).closest('tr').remove();"  class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
			</td>
		</tr>		
		<?php } ?>
		
		</table>
		
		<button type="button" style="width:100px;margin:10px 0px" onclick="$('#recordsTable').append($('#sampleTableDiv').html())" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add More</button>
		</div>
		</div>
		
		
		
		
		<hr/>
		
		
		<div class="row">	
		<div class="col-md-12">
		<table id="recordsTablePhysical" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
		<tr style="background-color:#f3f3f3">
			<th style="border: 1px solid #68696b;padding:15px 10px;text-align:center;font-size:16px" colspan="8">ANNUAL PHYSICAL EXAMINATION</th>
		</tr>
		<tr style="background-color:#f3f3f3">
		    <th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:10%;">Year</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:16%;">Complete Blood Count</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:15%;">Urinalysis</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:15%;">Chest XRay PA</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:15%;">Drug Test</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:18%;">Physical Examination</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:16%;">Doctor's Clearance</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:5%;"></th>
		</tr>
		<?php $counter=0; foreach($physical_details as $token){ $counter++; ?>
		<tr style="font-size:10px">
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<input type="text" class="form-control" style="width:100%" placeholder="" name="p_year[]" value="<?php echo $token['p_year']; ?>" required>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_cbc[]" required><?php echo $token['p_cbc']; ?></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_urinalysis[]" required><?php echo $token['p_urinalysis']; ?></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_xray[]" required><?php echo $token['p_xray']; ?></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_drugtest[]" required><?php echo $token['p_drugtest']; ?></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_physical[]" required><?php echo $token['p_physical']; ?></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_clearance[]" required><?php echo $token['p_clearance']; ?></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<input type="hidden" name="p_ref_id[]" value="<?php echo $token['p_id']; ?>">
			<input type="hidden" name="p_patient_id[]" value="<?php echo $patient_id; ?>">
			<?php if($counter > 1){ ?>
			<a onclick="return confirm('Are you sure, you want to delete this record?')" href="<?php echo base_url('clinic_portal/del_patient_physical/'.$token['patient_id'].'/'.$token['p_id']); ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
			<?php } ?>
			</td>
		<?php } ?>
		</tr>
		
		
		<?php if($counter == 0){ ?>
		<tr style="font-size:10px">
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<input type="text" class="form-control" style="width:100%" placeholder="" name="p_year[]" value="" required>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_cbc[]" value="" required></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_urinalysis[]" value="" required></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_xray[]" value="" required></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_drugtest[]" value="" required></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_physical[]" value="" required></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_clearance[]" value="" required></textarea>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<input type="hidden" name="p_ref_id[]" value="">
			<input type="hidden" name="p_patient_id[]" value="<?php echo $patient_id; ?>">
			<button type="button" onclick="$(this).closest('tr').remove();"  class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
			</td>
		</tr>		
		<?php } ?>
		</table>
		
		<button type="button" style="width:100px;margin:10px 0px" onclick="$('#recordsTablePhysical').append($('#sampleTableDivPhysical').html())" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add More</button>
		</div>
		</div>
		
		
		<hr/>
		
		<?php if($this->uri->segment(3) == 'edit'){ ?>
		
		<div class="row">
		<div class="col-md-12 text-center">
		<div class="form-group row">
		  <label for="case col-md-12">Update Remarks : **</label>
		</div>
		<div class="form-group row">
		  <div class="col-md-3 text-center">
		  </div>
		  <div class="col-md-6 text-center">
		  <textarea class="form-control" id="update_remarks" placeholder="" name="update_remarks" required></textarea>
		  </div>
		   <div class="col-md-3 text-center">
		  </div>
		</div>
		</div>
		</div>
		
		<hr/>
		
		<?php }  ?>
		
		
		
		<div class="row">
		<div class="col-md-12 text-center">
		<?php if($this->uri->segment(3) == 'edit'){ ?>
			<button type="submit" style="padding-left:10px" name="save" class="btn btn-success"><i class="fa fa-sign-in"></i> Update</button>			
		<?php } else { ?>
		    <button type="submit" style="padding-left:10px" name="save" class="btn btn-success"><i class="fa fa-sign-in"></i> Submit</button>
		<?php } ?>
		</div>
		</div>

		
			
  </form>
  
  
  
  
  
  
  
  <!--- PRE TABLE ADD MORE CONSULTATION --->
	<table id="sampleTableDiv" style="display:none">
	<tr style="font-size:10px">
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<input type="date" class="form-control" style="width:100%" placeholder="" name="d_date[]" value="" required>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<textarea type="text" class="form-control" style="width:100%" placeholder="" name="d_complaint[]" value="" required></textarea>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<textarea type="text" class="form-control" style="width:100%" placeholder="" name="d_assessment[]" value="" required></textarea>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<textarea type="text" class="form-control" style="width:100%" placeholder="" name="d_intervention[]" value="" required></textarea>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<input type="hidden" name="d_ref_id[]" value="">
		<input type="hidden" name="d_patient_id[]" value="<?php echo $patient_id; ?>">
		<button type="button" onclick="$(this).closest('tr').remove();"  class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
		</td>
	</tr>
	</table>
	
	
	 <!--- PRE TABLE ADD MORE PHYSICAL --->
	<table id="sampleTableDivPhysical" style="display:none">
	<tr style="font-size:10px">
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<input type="text" class="form-control" style="width:100%" placeholder="" name="p_year[]" value="" required>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_cbc[]" value="" required></textarea>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_urinalysis[]" value="" required></textarea>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_xray[]" value="" required></textarea>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_drugtest[]" value="" required></textarea>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_physical[]" value="" required></textarea>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<textarea type="text" class="form-control" style="width:100%" placeholder="" name="p_clearance[]" value="" required></textarea>
		</td>
		<td style="border: 1px solid #68696b;padding:5px 10px">
		<input type="hidden" name="p_ref_id[]" value="">
		<input type="hidden" name="p_patient_id[]" value="<?php echo $patient_id; ?>">
		<button type="button" onclick="$(this).closest('tr').remove();"  class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
		</td>
	</tr>
	</table>
  
  
  
  
</div>
</section>
</div>
</div>