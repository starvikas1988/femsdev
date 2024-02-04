<style>
.panel-heading{
	margin-bottom: 10px;
	font-weight:600;
}
td{
	padding: 0px 2px!important;
}
table th, td label, td input[type='text'],td textarea, td select{
	font-size:11px!important;
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
<div class="widget-body" id="formContacts">	

  
<div class="panel panel-default">
  <div class="panel-body">
  
    
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">CRM ID</label>
		  <input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crmdetails['crm_id']; ?>" name="crm_id" readonly>
		  <input type="hidden" class="form-control" id="time_interval" placeholder="" value="" name="time_interval" readonly>
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
  <div class="panel-heading">COVID-19 CONTACT ACTIONS FOR LHJs	
  <a href="<?php echo base_url()."covid_case/form/" .$crmdetails['crm_id'] ."/investigation/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Investigation Notes</a>
  </div>
  <div class="panel-body">
	
	<br/>
	
	<div class="row" id="contactTable">
	<div class="col-md-9">		
		<div class="form-group">
		<label>Information collected from Appendix A: Part I and Part II are abstracted and filled in below for contact tracing.</label>
		</div>
	</div>
	
	<div class="row">
	<form id="invForm" action="<?php echo base_url(); ?>covid_case/submit_contact_action" method="POST" autocomplete="off">
	<input type="hidden" name="crm_id_check" id="crm_id_check" value="<?php echo $crmdetails['crm_id']; ?>">
	
	<div class="col-md-12">		
		
		<table class="table table-bordered">
		<thead>
			<tr>
				<th width="15%">Risk and Response (Exposure) or Transmission (Contagious) Period</th>
				<th width="15%">Name of Facility/workplace/event</th>
				<th width="15%">Healthcare Code*</th>
				<th width="10%">Date and time case presented</th>
				<th width="15%">Exposure Details/Notes</th>
				<th width="15%">Location or Address</th>
				<th width="10%">Contact Name/Email/Phone</th>
				<th width="12%">County</th>
				<th width="5%"></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$counter = 0;
		foreach($crmcontact as $token){		
		$counter++;
		?>
		<tr>
			<td><div class="form-group"><label><textarea class="form-control" id="ca_info_1[]" name="ca_info_1[]" required><?php echo $token['ca_info_1']; ?></textarea></label></div></td>
			<td><div class="form-group"><label><textarea class="form-control" id="ca_info_2[]" name="ca_info_2[]"><?php echo $token['ca_info_2']; ?></textarea></label></div></td>
			<td><div class="form-group"><label><textarea class="form-control" id="ca_info_3[]" name="ca_info_3[]"><?php echo $token['ca_info_3']; ?></textarea></label></div></td>				
			<td><div class="form-group"><label><input type="text" class="form-control" id="ca_info_4_<?php echo $counter; ?>" name="ca_info_4[]" value="<?php echo $token['ca_info_4']; ?>"></label></div></td>
			<td><div class="form-group"><label><textarea class="form-control" id="ca_info_5[]" name="ca_info_5[]"><?php echo $token['ca_info_5']; ?></textarea></label></div></td>
			<td><div class="form-group"><label><textarea class="form-control" id="ca_info_6[]" name="ca_info_6[]"><?php echo $token['ca_info_6']; ?></textarea></label></div></td>
			<td><div class="form-group"><label><textarea class="form-control" id="ca_info_7[]" name="ca_info_7[]"><?php echo $token['ca_info_7']; ?></textarea></label></div></td>
			<td><div class="form-group"><label><textarea class="form-control" id="ca_info_8[]" name="ca_info_8[]"><?php echo $token['ca_info_8']; ?></textarea></label></div></td>
			<td><button type="button" class="btn btn-danger ca_removeMore <?php echo $counter==1?'hide':''; ?>"><i class="fa fa-times"></i></button></td>
		</tr>		
		<?php } ?>
		
		<?php if($counter == 0){ ?>
			<tr>
				<td><div class="form-group"><label><textarea class="form-control" id="ca_info_1[]" name="ca_info_1[]" required></textarea></label></div></td>
				<td><div class="form-group"><label><textarea class="form-control" id="ca_info_2[]" name="ca_info_2[]"></textarea></label></div></td>
				<td><div class="form-group"><label><textarea class="form-control" id="ca_info_3[]" name="ca_info_3[]"></textarea></label></div></td>				
				<td><div class="form-group"><label><input type="text" class="form-control" id="ca_info_4[]" name="ca_info_4[]"></label></div></td>
				<td><div class="form-group"><label><textarea class="form-control" id="ca_info_5[]" name="ca_info_5[]"></textarea></label></div></td>
				<td><div class="form-group"><label><textarea class="form-control" id="ca_info_6[]" name="ca_info_6[]"></textarea></label></div></td>
				<td><div class="form-group"><label><textarea class="form-control" id="ca_info_7[]" name="ca_info_7[]"></textarea></label></div></td>
				<td><div class="form-group"><label><textarea class="form-control" id="ca_info_8[]" name="ca_info_8[]"></textarea></label></div></td>
				<td><button type="button" class="btn btn-danger ca_removeMore hide"><i class="fa fa-times"></i></button></td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
		
		<button type="button" id="ca_addMore" class="btn btn-primary"><i class="fa fa-plus"></i> Add More</button>
		
	</div>
	</div>
		
	
	
	<br/>
	
	
	<div class="row">	
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
	</div>
	
	<hr/>
	
	
	
	<button type="submit" name="save" id="saveContacts" class="btn btn-success">Save</button>
	<a href="<?php echo base_url()."covid_case/form/" .$crmdetails['crm_id'] ."/personal/"; ?>" class="pull-right btn btn primary"><i class="fa fa-home"></i> Go Home</a>
	
	</form>
	
	</div>  
  </div>

</div>
</div>
<section>
</div>