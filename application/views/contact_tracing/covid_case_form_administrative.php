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
  <a class="nav-link" onclick="<?php echo $extraFormCheck; ?>"  href="<?php echo base_url('contact_tracing/form/'.$crmid.'/'.$eachsection); ?>" <?php echo (($uri == $eachsection))? $classnow : $classactive; ?>><?php echo ucwords($eachsection); ?></a></li>
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
  
    <form action="<?php echo base_url(); ?>contact_tracing/submit_administrative_lhj" method="POST" autocomplete="off">
	
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
  <div class="panel-heading">ADMINISTRATIVE LHJ: Local Health Jurisdiction
  <a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/personal/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Personal Details</a>
  </div>
  <div class="panel-body">
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Investigator: **</label>
		  <input type="text" class="form-control" id="case_investigator" placeholder="" name="case_investigator" required>
		</div>
	</div>
	</div>
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">LHJ Case ID (optional) :</label>
		  <input type="text" class="form-control" id="lhj_case_id" placeholder="" name="lhj_case_id">
		</div>		
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">LHJ notification date :</label>
		  <input type="text" class="form-control" id="lhj_notification_date" placeholder="" name="lhj_notification_date" required>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Classification : **</label>
		  <div class="checklist">
			<label><input type="radio" value="P" name="case_classification" required> Classification Pending</label>
			<label><input type="radio" value="C" name="case_classification" required> Confirmed</label>
			<label><input type="radio" value="NR" name="case_classification" required> Not Reportable </label>
		  </div>
		  <div class="checklist">
			<label><input type="radio" value="PB" name="case_classification" required> Probable </label>
			<label><input type="radio" value="RO" name="case_classification" required> Ruled out </label>
			<label><input type="radio" value="S" name="case_classification" required> Suspect </label>
		  </div>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Investigation Status : **</label>
		   <div class="checklist">
			<label><input type="radio" value="P" name="case_investigation_status" required> In Progress</label>
			<label><input type="radio" value="C" name="case_investigation_status" required> Complete</label>
			<label><input type="radio" value="NA" name="case_investigation_status" required> N/A</label>
		   </div>
		   <div class="checklist">
			<label><input type="radio" value="CNR" name="case_investigation_status" required> Complete – Not reportable to DOH </label>
			<label><input type="radio" value="UC" name="case_investigation_status" required> Unable to Complete </label>
		  </div>
		</div>
	</div>
	</div>
	<div class="row" style="display:none">
	<div class="col-md-6">	
	<div class="form-group">
	  <label for="case">Reason:</label>
	  <input type="text" class="form-control" id="case_reason" placeholder="" name="case_reason">
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Investigation Start Date : **</label>
		  <input type="text" class="form-control" id="case_investigation_start" placeholder="" name="case_investigation_start" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Investigation Complete Date :</label>
		  <input type="text" class="form-control" id="case_investigation_complete" placeholder="" name="case_investigation_complete" required>
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Case Complete Date :</label>
		  <input type="text" class="form-control" id="case_complete_date" placeholder="" name="case_complete_date" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Outbreak Related :</label>
		  <div class="checklist">
			<label><input type="radio" onclick="case_outbreak_validator(this)" value="Y" name="case_outbreak" required> Yes</label>
			<label><input type="radio" onclick="case_outbreak_validator(this)" value="N" name="case_outbreak" required> No</label>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row ioptions">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">LHJ Cluster ID :</label>
		  <input type="text" class="form-control" id="lhj_cluster" placeholder="" name="lhj_cluster" required>
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Cluster Name :</label>
		  <input type="text" class="form-control" id="case_cluster_name" placeholder="" name="case_cluster_name" required>
		</div>
	</div>
	</div>

	
	</div>  
  </div>
  
  
 <div class="panel panel-default">
  <div class="panel-body"> 
  
	<button type="submit" name="save" class="btn btn-success">Save & Next</button>
	
	<?php if(!empty($crmdetails['a_investigator'])){ ?>
	<a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/demographics/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	
	</form> 
  </div>
 </div>
  

</div>
</div>
<section>
</div>