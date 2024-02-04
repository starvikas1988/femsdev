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
  <a class="nav-link" onclick="<?php echo $extraFormCheck; ?>"   href="<?php echo base_url('covid_case/form/'.$crmid.'/'.$eachsection); ?>" <?php echo (($uri == $eachsection))? $classnow : $classactive; ?>><?php echo ucwords($eachsection); ?></a></li>
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
  
    <form action="<?php echo base_url(); ?>covid_case/submit_notes" method="POST" autocomplete="off">
	
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

<?php if(count($ai_address) > 0){ ?>

<div class="panel panel-default">
   <div class="panel-heading">P.S.</div>
   
  <div class="panel-body">

	<div class="row">
	<div class="col-md-12">
		<h6>
		<b><span class='text-danger'><?php echo count($ai_address); ?> Positive Cases</span></b> found nearby the same location of current case, please review once</h6>		
		<b>CASES FOUND :</b> <br/>
		<?php 
		//echo "<pre>".print_r($ai_address, true)."</pre>"; 
		$ai_count = 1;
		foreach($ai_address as $token){
		?>
		<?php //echo $ai_count++; ?> <?php echo $token['crm_id']; ?> - <?php echo $token['fname'] ." " .$token['lname']; ?> - Address : <?php echo $token['p_address']; ?>, <?php echo $token['p_country']; ?>, <?php echo $token['p_state']; ?>, <?php echo $token['p_city']; ?><br/>
		<?php } ?>
		<br/>
		
		<?php if($crmdetails['ongoing_status'] == 'P'){ ?>
			<a class="btn btn-secondary"><i class="fa fa-unlock"></i> Case has been unlocked as Positive</a>
			<a href="<?php echo base_url()."covid_case/lock/" .$crmdetails['crm_id'] ."/".$uri; ?>"  onclick="return confirm('Are you sure you want to lock this case to negative?')" class="btn btn-success btn-sm"><i class="fa fa-lock"></i> Revert to Negative</a>
		<?php } else { ?>
			<a href="<?php echo base_url()."covid_case/unlock/" .$crmdetails['crm_id'] ."/".$uri; ?>" onclick="return confirm('Are you sure you want to unlock this case to positive?')" class="btn btn-danger"><i class="fa fa-lock"></i> Unlock this Case to Positive</a>
		<?php } ?>
	</div>
	</div>
			
</div>
</div>

<?php } ?>	
	
<div class="panel panel-default">
  <div class="panel-heading">NOTES
  <?php if(!empty($crmdetails['a_is_outbreak_related'])){ 
		if($crmdetails['a_is_outbreak_related'] == 'N'){
  ?>
  <a href="<?php echo base_url()."covid_case/form/" .$crmdetails['crm_id'] ."/administrative/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Administrative</a>
  <?php } else { ?>
  <a href="<?php echo base_url()."covid_case/form/" .$crmdetails['crm_id'] ."/treatment/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Treatment</a>
  <?php } } ?>
  </div>
  <div class="panel-body">
	
	<div class="row">
	<div class="col-md-8">	
	<div class="form-group">
		<label for="case">Enter Note : **</label>
		<textarea rows='5' class="form-control" name="case_notes" id="case_notes" required></textarea>
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
  <div class="panel-heading" style="background-color: #ffd6cc;">Case Closure</div>
  <div class="panel-body">
	
	 <div class="row">
	   <div class="col-md-6">		
			<div class="form-group">
			  <label for="case">Case Disposition</label>
			  <input type="hidden" class="form-control" id="case_closure_type" placeholder="" value="Y" name="case_closure_type">
			  <select class="form-control" name="cls_disposition" id="cls_disposition" required>
				<option value="NEGATIVE"> Negative</option>
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
	
	<button type="submit" name="save" class="btn btn-success">Save & Next</button>
	
	<?php if(!empty($crmdetails['case_permission'])){ ?>
	<a href="<?php echo base_url()."covid_case/form/" .$crmdetails['crm_id'] ."/exposure/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	
<?php } } ?>
		

	
	</form> 
  </div>
 </div>
 
 
 
<div class="modal fade" id="caseClosureModal" tabindex="-1" role="dialog" aria-labelledby="caseClosureModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	
	<form method="POST" action="<?php echo base_url()."/covid_case/submit_case_closure"; ?>"  autocomplete='off'>
	
      <div class="modal-header">
        <h2 class="modal-title" id="caseClosureModalLabel">Case Closure</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <div class="row">
	       <input type="hidden" class="form-control" id="case_crm_id" placeholder="" value="<?php echo $crmdetails['crm_id']; ?>" name="case_crm_id" readonly>
			<div class="col-md-12">		
				<div class="form-group">
				  <label for="case">Case Disposition</label>
				  <select class="form-control" name="cls_disposition" id="cls_disposition" required>
					<option value="POSITIVE"> Positive</option>
					<option value="NEGATIVE"> Negative</option>
					<option value="UNKNOWN"> Unknown</option>
				  </select>
				</div>
				
				<div class="form-group">
				  <label for="case">Any Remarks (Optional)</label>
				  <textarea class="form-control" name="cls_remarks" id="cls_remarks" required></textarea>
				</div>
			</div>	
	  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
	  
	</form>
    </div>
  </div>
</div>
  

</div>
</div>
<section>
</div>