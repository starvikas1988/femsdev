
<?php
$classnow = "style='background-color:#3cc3b5;color:#fff;font-weight:600;font-size:11px'";
$classactive = "style='color:#888181;font-weight:600;border-right:1px solid #eee;font-size:11px'";

if(in_array($uri, $mysections)){
?>
<div class="wrap">
<ul class="nav nav-tabs" style="background:#fff">
<?php foreach($mysections as $eachsection){ ?>  
  <li class="nav-item" <?php echo (($uri == $eachsection))? $classnow : $classactive; ?>>
  <a class="nav-link"  onclick="<?php echo $extraFormCheck; ?>" href="<?php echo base_url('contact_tracing/form/'.$crmid.'/'.$eachsection); ?>" <?php echo (($uri == $eachsection))? $classnow : $classactive; ?>><?php echo ucwords($eachsection); ?></a></li>
<?php } ?>  
 </ul>
</div>
<?php } ?>


<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">	

  <h4>Contact Tracing Form</h4>
  <hr/>
  
<div class="panel panel-default">
  <div class="panel-body">
  
    <form action="<?php echo base_url(); ?>contact_tracing/submit_personal_information" method="POST" autocomplete="off">
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">CRM ID</label>
		  <input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crmid; ?>" name="crm_id" readonly>
		  <input type="hidden" class="form-control" id="crm_source" placeholder="" value="individual" name="crm_source" readonly>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Timer</label>
		  <input type="text" class="form-control" id="timer_Show" placeholder="" value="" name="timer_Show" readonly>
		</div>
	</div>
	</div>
		
	<div class="row">	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">First Name : **</label>
		  <input type="text" class="form-control" id="case_fname" placeholder="" name="case_fname" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Last Name : **</label>
		  <input type="text" class="form-control" id="case_lname" placeholder="" name="case_lname" required>
		</div>
	</div>
	</div>
	
</div>
</div>
	
	
<div class="panel panel-default">
  <div class="panel-heading">Personal Information</div>
  <div class="panel-body">
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Date Of Birth : **</label>
		  <input type="text" class="form-control" id="case_dob" placeholder="" name="case_dob">
		</div>
	</div>
	<div class="col-md-6 hide">
		<div class="form-group">
		  <label for="case">Sex at Birth : **</label>
		  <div class="checklist">
			<label><input type="radio" value="M" name="case_gender"> Male</label>
			<label><input type="radio" value="F" name="case_gender"> Female</label>
			<label><input type="radio" value="O" name="case_gender"> Others</label>
		  </div>
		</div>		
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Alternate Name:</label>
		  <input type="text" class="form-control" id="case_alt" placeholder="" name="case_alt">
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Phone : **</label>
		  <input type="text" class="form-control number-only" id="case_phone" placeholder="" name="case_phone" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Email : **</label>
		  <input type="email" class="form-control" id="case_email" placeholder="" name="case_email" required>
		</div>
	</div>
	<div class="col-md-6">	
	<div class="form-group">
	  <label for="case">Address Type : **</label>
	  <div class="checklist">
		<label><input type="radio" value="Home" name="case_addresstype" required> Home</label>
		<label><input type="radio" value="Mailing" name="case_addresstype" required> Mailing</label>
		<label><input type="radio" value="Others" name="case_addresstype" required> Others</label>
	  </div>
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Street Address : **</label>
		  <input type="text" class="form-control" id="case_address" placeholder="" name="case_address" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Select Country : **</label>
		  <select class="form-control" id="case_country" name="case_country" required>
		       <option value="">--- Select Country ---</option>
		  <?php foreach($allCountries as $eachCountry){ ?>
				<option value="<?php echo $eachCountry['name']; ?>" cid="<?php echo $eachCountry['id']; ?>"><?php echo $eachCountry['name']; ?></option>
		  <?php } ?>
		  </select>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Select State : **</label>
		  <select class="form-control" id="case_state" name="case_state" required>
			<option value="">--- Select State ---</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group" id="htmlCity">
		  <label for="case">Select City : **</label>
		  <input class="form-control" id="case_city" name="case_city" required>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Residence type (incl. Homeless) : **</label>
		  <input type="text" class="form-control" id="case_residence" placeholder="" name="case_residence" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">WA resident : **</label>
		  <div class="checklist">
			<label><input type="radio" value="Y" name="wa_resident" required> Yes</label>
			<label><input type="radio" value="N" name="wa_resident" required> No</label>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Guardian Name :</label>
		  <input type="text" class="form-control" id="case_guardian" placeholder="" name="case_guardian">
		</div>
	</div>
	</div>
	
	
	</div>  
  </div>
  
  
 <div class="panel panel-default">
  <div class="panel-body"> 
		
	<button type="submit" name="save" class="btn btn-success">Save & Next</button>
	
	<?php if(!empty($crmdetails['p_address_type'])){ ?>
	<a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/administrative/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	
	</form> 
  </div>
 </div>
 
  

</div>
</div>
<section>
</div>