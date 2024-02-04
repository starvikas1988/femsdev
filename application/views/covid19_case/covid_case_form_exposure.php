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
  
    <form action="<?php echo base_url(); ?>covid_case/submit_transmission" method="POST" autocomplete="off">
	
	<div class="row">
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">CRM ID</label>
		  <input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crmrow['crm_id']; ?>" name="crm_id" readonly>
		  <input type="hidden" class="form-control" id="time_interval" placeholder="" value="" name="time_interval" readonly>
		</div>
	</div>
	
	<div class="col-md-5">
		<div class="form-group">
		  <label for="case">Case Name</label>
		  <input type="text" class="form-control" id="case_name" placeholder="" value="<?php echo $crmrow['fname'] ." " .$crmrow['lname']; ?>" name="case_name" readonly>
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
  <div class="panel-heading">Novel Coronavirus EXPOSURE TIMELINE
  <a href="<?php echo base_url()."covid_case/form/" .$crmrow['crm_id'] ."/notes/"; ?>" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Back to Notes</a>
  </div>
  <div class="panel-body">
  
	<h5><b>Identifying Exposed Contacts and Sites of Transmission</b></h5>
	<br/>
	<div class="row">
	<div class="col-md-8">
		<div class="card" style="border: 1px solid #000;padding: 10px 30px;">
		  <div class="card-body">
			<h5 class="card-title"><b>collect locations of potential exposure and transmission for each date below:</b></h5>		
			<ul style="list-style-type: disc;">
			<li>Addresses and phone numbers of work & high risk settings</li>
			<li>Dates and times visited (if available, time of arrival and length of stay)</li>
			<li>Travel information (e.g., departure & arrival cities, method of transport, transport company, flight number)</li>
			<li>Remember to ask about stops at healthcare facilities, schools and child care centers</li>
			</ul>
		  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card" style="border: 1px solid #000;padding: 10px 30px;">
		  <div class="card-body">
			<h5 class="card-title"><b>Information about Contacts</b></h5>		
			<ul style="list-style-type: disc;">
			<li>Names and phone numbers of contacts</li>
			<li>Relation to case</li>
			<li>Are contacts symptomatic?</li>
			</ul>
			<br/>
		  </div>
		</div>
	</div>
	</div>
	
	<div class="row" style="margin-top:20px">
	<div class="col-md-12">	
	
	<table class="table">
	<thead>
		<tr>
			<th width="15%">#</th>
			<th width="20%">Date</th>
			<th width="5%">Day</th>
			<th width="30%">Locations (With Times)</th>
			<th width="30%">Contacts</th>
		</tr>
	</thead>
	<tbody>
	<?php
	for($i=0; $i<17; $i++){
		$j = $i-2;
	?>
	<tr>
		<td class="">
		<b><?php
		if($j == 6){ echo "CONTAGIOUS PERIOD"; }
		if($j == 0){ echo "<span class='text-danger'>SYMPTOM ONSET</span>"; }
		?></b>
		</td>
		<td>
		<input class="form-control" type="text" value="<?php if(!empty($crmdetails[0]['e_date'])){ echo $crmdetails[0]['e_date']; } ?>" name="e_date_<?php echo $i; ?>" id="e_date_<?php echo $i; ?>" <?php echo $j>-2?"readonly":""; ?>></input>
		</td>
		<td><?php echo $j; ?></td>
		<td><textarea class="form-control" id="e_location_<?php echo $i; ?>" name="e_location_<?php echo $i; ?>"><?php if(!empty($crmdetails[$i]['e_location'])){ echo $crmdetails[$i]['e_location']; } ?></textarea></td>
		<td><textarea class="form-control" id="e_contacts_<?php echo $i; ?>" name="e_contacts_<?php echo $i; ?>"><?php if(!empty($crmdetails[$i]['e_contacts'])){ echo $crmdetails[$i]['e_contacts']; } ?></textarea></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>	
	
	</div>
	</div>
		
</div>  
</div>



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
	
	<?php if(!empty($crmdetails[0]['e_date'])){ ?>
	<a href="<?php echo base_url()."covid_case/form/" .$crmrow['crm_id'] ."/risk/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	
	</form> 
  </div>
 </div>

</div>
</div>
<section>
</div>