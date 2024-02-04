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
  
    <form action="<?php echo base_url(); ?>contact_tracing/submit_notes" method="POST" autocomplete="off">
	
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
  <div class="panel-heading">NOTES
  <?php if(!empty($crmdetails['a_is_outbreak_related'])){ 
		if($crmdetails['a_is_outbreak_related'] == 'N'){
  ?>
  <a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/administrative/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Administrative</a>
  <?php } else { ?>
  <a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/treatment/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Treatment</a>
  <?php } } ?>
  </div>
  <div class="panel-body">
	
	<div class="row">
	<div class="col-md-8">	
	<div class="form-group">
		<label for="case">Enter Comments (Optional) : </label>
		<textarea rows='5' class="form-control" name="case_notes" id="case_notes"></textarea>
	</div>
	</div>
	</div>
	
	<div class="row hide">
	<hr/>
	<div class="col-md-6">		
		<div class="form-group">
		<label>Permission received to use case name in conversations with contacts ? **</label>
		</div>
	</div>
	
	<div class="col-md-1">		
		<div class="form-group">
		    <div class="checklist">
			<label><input type="radio" value="Y" name="case_permission"> Yes</label>
			</div>
		</div>
	</div>
	
	<div class="col-md-1">		
		<div class="form-group">
		    <div class="checklist">
			<label><input type="radio" value="N" name="case_permission"> No</label>
			</div>
		</div>
	</div>
	</div>

	
	</div>  
  </div>
  

<?php if((!empty($crm_treatment)) && ($crmdetails['ongoing_status'] != 'P')){ if($crm_treatment != 'Y'){ ?>
  
<div class="panel panel-default">
  <div class="panel-heading" style="background-color: #ffd6cc;">Case Submission</div>
  <div class="panel-body">
	
	<div class="row">
	   <div class="col-md-6">		
			<div class="form-group">
			  <label for="case">Case Submission</label>
			  <input type="hidden" class="form-control" id="case_closure_type" placeholder="" value="Y" name="case_closure_type">
			  <select class="form-control" name="cls_disposition" id="cls_disposition" required>
				<option value="COMPLETE"> Complete</option>
			  </select>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="form-group">
			  <label for="case">Any Remarks (Optional)</label>
			  <textarea class="form-control" name="cls_remarks" id="cls_remarks"></textarea>
			</div>
		</div>	
    </div>
  
	<button type="submit" name="save" class="btn btn-success">Submit Case</button>
	
	</div>  
  </div>
  
 <?php } } ?> 
  

<?php if(!empty($crm_treatment)){ if(($crm_treatment == 'Y') || ($crmdetails['ongoing_status'] == 'P')){ ?> 
  <div class="panel panel-default">
  <div class="panel-body"> 
 	
	<button type="submit" name="save" class="btn btn-success">Save & Next</button>
	
	<?php if(!empty($crmdetails['case_permission'])){ ?>
	<a href="<?php echo base_url()."contact_tracing/form/" .$crmdetails['crm_id'] ."/exposure/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	
<?php } } ?>
		

	
	</form> 
  </div>
 </div>
 
  

</div>
</div>
<section>
</div>