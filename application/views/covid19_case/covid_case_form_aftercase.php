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
  
    <form action="<?php echo base_url(); ?>covid_case/submit_aftercase" method="POST" autocomplete="off">
	
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
	
	
<div class="panel panel-default">
  <div class="panel-heading">TRANSMISSION AFTER CASE IS SYMPTOMATIC (Complete AFTER interview for data entry)
  <a href="<?php echo base_url()."covid_case/form/" .$crmdetails['crm_id'] ."/risk/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Risk</a>
  </div>
  <div class="panel-body">
	
	<br/>
	
	<div class="row">
	<div class="col-md-9">		
		<div class="form-group">
		<label>Visited, attended, employed, or volunteered at any public settings (including healthcare) while contagious</label>
		</div>
	</div>
	
	<div class="col-md-1">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="radio" value="Y" onclick="af_1_visited_validator(this)" name="af_1_visited" required> Yes</label>
		</div>
		</div>
	</div>
	
	<div class="col-md-1">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="radio" value="N" onclick="af_1_visited_validator(this)" name="af_1_visited" required> No</label>
		</div>
		</div>
	</div>
	
	<div class="col-md-1">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="radio" value="UNK" onclick="af_1_visited_validator(this)" name="af_1_visited" required> Unknown</label>
		</div>
		</div>
	</div>
	</div>
	
	
	
	<div class="row ioptions">
	<div class="col-md-3">		
		<div class="form-group">
		<label>Settings and details (check all that apply)</label>
		</div>
	</div>
	
	<div class="col-md-9">		
		<div class="form-group">
		<div class="checklist">
			<label><input type="checkbox" value="DAY" name="af_1[]" required> Day care</label>
			<label><input type="checkbox" value="SCHOOL" name="af_1[]" required> School</label>
			<label><input type="checkbox" value="AIRPORT" name="af_1[]" required> Airport</label>
			<label><input type="checkbox" value="HOTEL" name="af_1[]" required> Hotel/Motel/Hostel</label>
			<label><input type="checkbox" value="TRANSIT" name="af_1[]" required> Transit</label>
			<label><input type="checkbox" value="HEALTHCARE" name="af_1[]" required> Health care</label>
			<label><input type="checkbox" value="HOME" name="af_1[]" required> Home</label>
			<label><input type="checkbox" value="WORK" name="af_1[]" required> Work</label>
			<label><input type="checkbox" value="COLLEGE" name="af_1[]" required> College </label>
			<label><input type="checkbox" value="MILITARY" name="af_1[]" required> Military </label>
			<label><input type="checkbox" value="CORRECTIONAL" name="af_1[]" required> Correctional facility </label>
			<label><input type="checkbox" value="WORSHIP" name="af_1[]" required> Place of worship </label>
			<label><input type="checkbox" value="INTERNATIONAL" name="af_1[]" required> International travel </label>
			<label><input type="checkbox" value="TRAVEL" name="af_1[]" required> Out of state travel </label>
			<label><input type="checkbox" value="LTCF" name="af_1[]" required> LTCF  </label>
			<label><input type="checkbox" value="HOMELESS" name="af_1[]" required> Homeless/shelter  </label>
			<label><input type="checkbox" value="SOCIAL" name="af_1[]" required> Social event </label>
			<label><input type="checkbox" value="PUBLIC" name="af_1[]" required> Large public gathering </label>
			<label><input type="checkbox" value="RESTAURANT" name="af_1[]" required> Restaurant </label>
			<label><input type="checkbox" value="OTHER" name="af_1[]" required> Other </label>
		</div>
		</div>
	</div>
	</div>
	
	
	
	
	<div class="row ioptions">
	<br/>
	<div class="col-md-12">		
		<div class="form-group">
		<label>ITravel – during the 14 days before symptom onset did you travel?</label>
		</div>
	</div>
	</div>
	
	
	<div class="row ioptions">
	<div class="col-md-12">		
		
		<table class="table table-bordered">
		<thead>
			<tr>
				<th width="10%">#</th>
				<th width="20%">Setting 1</th>
				<th width="20%">Setting 2</th>
				<th width="20%">Setting 3</th>
				<th width="20%">Setting 4</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Setting Type: (as checked above)</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Facility Name</td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_1_facility" placeholder="" name="af_setting_1_facility"></label></div></td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_2_facility" placeholder="" name="af_setting_2_facility"></label></div></td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_3_facility" placeholder="" name="af_setting_3_facility"></label></div></td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_4_facility" placeholder="" name="af_setting_4_facility"></label></div></td>
			</tr>
			<tr>	
				<td>Start Date</td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_1_start" placeholder="" name="af_setting_1_start"></label></div></td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_2_start" placeholder="" name="af_setting_2_start"></label></div></td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_3_start" placeholder="" name="af_setting_3_start"></label></div></td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_4_start" placeholder="" name="af_setting_4_start"></label></div></td>
			</tr>
			<tr>	
				<td>End Date</td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_1_end" placeholder="" name="af_setting_1_end"></label></div></td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_2_end" placeholder="" name="af_setting_2_end"></label></div></td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_3_end" placeholder="" name="af_setting_3_end"></label></div></td>
				<td><div class="form-group"><label><input type="text" class="form-control" id="af_setting_4_end" placeholder="" name="af_setting_4_end"></label></div></td>
			</tr>
			<tr>	
				<td>List of contacts known?</td>
				<td>
				<div class="form-group">
				<div class="checklist">
				<label><input type="radio" value='Y' name="af_setting_1_known"> Yes</label>
				<label><input type="radio" value='N' name="af_setting_1_known"> No</label>
				<label><input type="radio" value='UNK' name="af_setting_1_known"> Unk</label>
				</div>
				</div>
				</td>
				
				<td>
				<div class="form-group">
				<div class="checklist">
				<label><input type="radio" value='Y' name="af_setting_2_known"> Yes</label>
				<label><input type="radio" value='N' name="af_setting_2_known"> No</label>
				<label><input type="radio" value='UNK' name="af_setting_2_known"> Unk</label>
				</div>
				</div>
				</td>
				
				<td>
				<div class="form-group">
				<div class="checklist">
				<label><input type="radio" value='Y' name="af_setting_3_known"> Yes</label>
				<label><input type="radio" value='N' name="af_setting_3_known"> No</label>
				<label><input type="radio" value='UNK' name="af_setting_3_known"> Unk</label>
				</div>
				</div>
				</td>
				
				<td>
				<div class="form-group">
				<div class="checklist">
				<label><input type="radio" value='Y' name="af_setting_4_known"> Yes</label>
				<label><input type="radio" value='N' name="af_setting_4_known"> No</label>
				<label><input type="radio" value='UNK' name="af_setting_4_known"> Unk</label>
				</div>
				</div>
				</td>
			</tr>
			
			
		</tbody>
		</table>
		
	</div>
	</div>
	
	
</div>  
</div>







  
<div class="panel panel-default">
  <div class="panel-heading" style="background-color: #ffd6cc;">Case Closure</div>
  <div class="panel-body">
	
	 <div class="row">
	   <div class="col-md-6">		
			<div class="form-group">
			  <label for="case">Case Disposition</label>
			  <input type="hidden" class="form-control" id="case_closure_type" placeholder="" value="Y" name="case_closure_type">
			  <select class="form-control" name="cls_disposition" id="cls_disposition" required>
				<option value="POSITIVE"> Positive</option>
				<option value="RECOVERED"> Recovered</option>
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
  

<!--
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
	
	<?php if(!empty($crmdetails['af_1_visited'])){ ?>
	<a href="<?php echo base_url()."covid_case/form/" .$crmdetails['crm_id'] ."/investigation/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	
	</form> 
  </div>
 </div>
-->


</div>
</div>
<section>
</div>