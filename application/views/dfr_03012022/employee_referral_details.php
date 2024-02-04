<div class="row">

<div class="col-md-12">  
 <div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-user"></i> Referral Details</div>
  <div class="panel-body"> 
	<br/>
	
	<div class="row">
	  <div class="col-md-4">
		  <p>		  
		  <b>Name :</b> <?php echo $referral_details['name']; ?> <br/>
		  <b>Location :</b> <?php echo $referral_details['location']; ?> <br/>
		  <b>Phone :</b> <?php echo $referral_details['phone']; ?> <br/>
		  <b>Email :</b> <?php echo $referral_details['email']; ?> <br/> 
		  <b>Position Referred To :</b> <span class="text-primary"><?php echo !empty($referral_details['position']) ? ($referral_details['position'] == "agent" ? "CCE" : ucwords($referral_details['position'])) : "-"; ?></span> <br/> 
		  <b>CV :</b> 
		  <?php if(!empty($referral_details['attachment_cv'])){ ?>
			<a title="<?php echo $referral_details['attachment_cv']; ?>" style="cursor:pointer" onclick="window.open('<?php echo base_url()."dfr/employee_referral_attachment_view?filedir=".base64_encode($referral_details['attachment_cv']); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no, status=yes');"><b><i class="fa fa-download"></i> <?php echo $referral_details['attachment_cv']; ?></b></a>
			<?php } else { echo "N/A"; } ?><br/>
		  </p>
	  </div>
	  <div class="col-md-4">
		  <p>
		  <b>Referral Fusion ID :</b> <?php echo $referral_details['referral_fusionid']; ?> <br/>
		  <b>Referral Name :</b> <?php echo $referral_details['added_name']; ?> <br/>
		  <b>Referral Client :</b> <?php echo $referral_details['client_name']; ?> <br/>
		  <b>Referral Process :</b> <?php echo $referral_details['process_name']; ?> <br/>
		  <b>Referral Office :</b> <?php echo $referral_details['office_id']; ?> <br/>
		  </p>
	  </div>
	  <div class="col-md-4">
		  <p>
		  <b>Referral Comments :</b> <br/><?php echo $referral_details['comment']; ?> <br/>
		  <b>Status :</b> <span class="text text-<?php echo _ref_show_status_color($referral_details['ref_status']); ?>"><b><?php echo _ref_show_status_name($referral_details['ref_status']); ?></b></span> <br/>
		  </p>
	  </div>
	</div>
	
	
	
	
 </div>
</div>
</div>

<?php
$nameExplode = !empty($referral_details['name']) ? explode(' ', $referral_details['name']) : array();
$ref_firstname = $referral_details['name'];
if(!empty($nameExplode)){
	$ref_firstname = $nameExplode[0];
	$ref_lastname = !empty($nameExplode[1]) ? $nameExplode[1] : "";
	$ref_lastname .= !empty($nameExplode[2]) ? $nameExplode[2] : "";
	$ref_lastname .= !empty($nameExplode[3]) ? $nameExplode[3] : "";
	$ref_lastname .= !empty($nameExplode[4]) ? $nameExplode[4] : "";
	
}
function _ref_show_status_name($check){
	$resultArray = array(
		"P" => "Pending",
		"A" => "Shortlisted",
		"R" => "Rejected",
		"C" => "Moved to Requisiton",
		"X" => "Call Back",
	);
	$finalResult = $resultArray;
	if(!empty($check)){ $finalResult = $resultArray[$check]; }
	return $finalResult;
}
function _ref_show_status_color($check="")
{
	$resultArray = array(
		"P" => "danger",
		"A" => "primary",
		"R" => "secondary",
		"C" => "success",
		"X" => "warning",
	);
	$finalResult = $resultArray;
	if(!empty($check)){ $finalResult = $resultArray[$check]; }
	return $finalResult;
}
?>

<?php if($referral_details['ref_status'] != 'P'){ ?>
<div class="col-md-12">  
 <div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-user"></i> Update Status</div>
  <div class="panel-body"> 
	<br/>
	<div class="row">	
	<div class="col-md-6">
		<p>
		  <b>Status :</b> <span class="text text-<?php echo _ref_show_status_color($referral_details['ref_status']); ?>"><b><?php echo _ref_show_status_name($referral_details['ref_status']); ?></b></span> <br/>
		  <?php if($referral_details['ref_status'] == 'C'){ ?>
		  
		 
		  
		  <?php if(!empty($referral_details['ref_candidate_id']) && !empty($referral_details['requisition_id'])){ ?>
		  
		   <a target="_blank" href="<?php echo base_url('dfr/view_requisition/'.$referral_details['ref_requisition_id']); ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View Requisition</a>
		   
		   <br/><br/>
		   
		  <?php if($referral_details['candidate_status'] !='E' && $referral_details['requisition_status']=='A'){ ?>
		   
		  <a onclick="return confirm('Are you sure you want to resend apply link ?')" hrefURL="<?php echo base_url('dfr/resend_basic_link?r_id='.$referral_details['ref_requisition_id'].'&c_id='.$referral_details['ref_candidate_id']); ?>" class="btn btn-warning btn-xs ref_sendMyLink"><i class="fa fa-envelope"></i> Resend Apply Link</a>
		  
		  <a onclick="return confirm('Are you sure you want to resend document link ?')"  hrefURL="<?php echo base_url('dfr/resend_doc_link?r_id='.$referral_details['ref_requisition_id'].'&c_id='.$referral_details['ref_candidate_id'].'&requisition_id='.$referral_details['requisition_id']); ?>" class="btn btn-primary btn-xs ref_sendMyLink"><i class="fa fa-file"></i> Send Document Link</a>
		  
		  <?php } ?>
		  
		  
		  <?php } ?>
		  
		  
		  <?php } ?><br/>
		   
		</p>
	</div>
	<div class="col-md-6">
		<p>
			<b>Selection Type :</b> <?php echo $referral_details['ref_call_type']; ?><br/>
		  <b>HR Comments :</b> <br/> <?php echo $referral_details['ref_comments']; ?> <br/>
		</p>
	</div>
	</div>	
 </div>
</div>
</div>
<?php } ?>

<?php if($referral_details['ref_status'] == 'P' || $referral_details['ref_status'] == 'X'){ ?>
<div class="col-md-12">  
 <div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-user"></i> Update Status</div>
  <div class="panel-body"> 
	<br/>
	<form id="rf_updateReferralStatusFrm" method="POST">
	<div class="row">	
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Selection Type</label>
		 <input type="hidden" name="selection_id" value="<?php echo $referral_details['id']; ?>">
		 <select name="selection_type" class="form-control" required>
			<option value="">-- Select --</option>
			<option value="Voice">Voice</option>
			<option value="Non-Voice">Non Voice</option>
		 </select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Selection Status</label>
		 <select name="selection_status" class="form-control" required>
			<option value="">-- Select --</option>
			<option value="A">Shortlisted</option>
			<option value="R">Rejected</option>
			<option value="X">Call Back</option>
		 </select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Comments</label>
		 <textarea name="selection_comments" class="form-control" required></textarea>
		</div>
	</div>
	</div>
	
	<div class="row">	
	<div class="col-md-4">
		<div class="form-group">
		 <button type="button" name="save" class="btn btn-danger rf_updateReferralStatus"><i class="fa fa-sign-in"></i> Update</button>
		</div>
	</div>
	</div>
	</form>
 </div>
</div>
</div>
<?php } ?>



<?php if($referral_details['ref_status'] == 'A'){ ?>
<div class="col-md-12">  
 <div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-user"></i> Move To Requistion</div>
  <div class="panel-body"> 
	<br/>
	<form id="rf_updateReferralMoveFrm" method="POST">
	<div class="row">	
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Location</label>
		 <input type="hidden" name="selection_id" value="<?php echo $referral_details['id']; ?>">
		  <select class="form-control" name="selection_location">
			<option value="">-- Select --</option>
			<?php
			if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
			?>
			<?php foreach($location_list as $loc): ?>
			<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>				
			<?php endforeach; ?>													
		</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Requistion</label>
		 <select name="selection_requisition" class="form-control" required>
			<option value="">-- Select --</option>
		 </select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Requistion Details</label>
		 <textarea name="selection_details" class="form-control" readonly></textarea>
		</div>
	</div>
	</div>
	
	<div class="row">	
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Firstname</label>
		  <input class="form-control" name="candidate_firstname" value="<?php echo $ref_firstname; ?>" required>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Lastname</label>
		 <input class="form-control" name="candidate_lastname" value="<?php echo $ref_lastname; ?>" required>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Email ID</label>
		 <input class="form-control" name="candidate_email_id"  value="<?php echo $referral_details['email']; ?>"  required>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Phone No</label>
		 <input maxlen="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"  class="form-control" name="candidate_phone_no" value="<?php echo $referral_details['phone']; ?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Onboarding Type</label>
		 <select id="onboarding_typ" name="onboarding_type" class="form-control" required>
				<option value="">-- Select type --</option>
				<option value="Regular">Regular</option>
				<option value="NAPS">NAPS</option>
				<option value="Stipend">Stipend</option>
				<option value="Contract">Contract</option>
				<option value="Hourly">Hourly</option>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Company</label>
		 <select id="company" name="company" class="form-control" required>
			<option value="">-- Select company --</option>
			<?php foreach ($company_list as $key => $value) { ?>
				<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
			<?php } ?>
		 </select>
		</div>
	</div>
	</div>
	
	<div class="row">	
	<div class="col-md-4">
		<div class="form-group">
		 <button type="button" name="save" class="btn btn-danger rf_updateReferralMove"><i class="fa fa-sign-in"></i> Update</button>
		</div>
	</div>
	</div>
	</form>
 </div>
</div>
</div>
<?php } ?>





</div>