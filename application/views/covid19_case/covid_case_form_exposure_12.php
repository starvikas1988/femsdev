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
  
    <form action="<?php echo base_url(); ?>covid_case/submit_exposure" method="POST" autocomplete="off">
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">CRM ID</label>
		  <input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crmrow['crm_id']; ?>" name="crm_id" readonly>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Case Name</label>
		  <input type="text" class="form-control" id="case_name" placeholder="" value="<?php echo $crmrow['fname'] ." " .$crmrow['lname']; ?>" name="case_name" readonly>
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
  
	<h5><b>PART I: Identifying Sources of Infection</b></h5>
	<br/>
	<div class="row">
	<div class="col-md-8">
		<div class="card" style="border: 1px solid #000;padding: 10px 30px;">
		  <div class="card-body">
			<h5 class="card-title"><b>Part I & Part II: collect locations of potential exposure and transmission for each date below:</b></h5>		
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
	for($i=14; $i>=0; $i--){
		$bgclass = "";
		if($i<3){ $bgclass = "style='background-color:#fbf9f9'"; }
	?>
	<tr <?php echo $bgclass; ?>>
		<td class="">
		<b><?php 
		if($i == 14){ echo "EARLIEST EXPOSURE DATE"; } 
		if($i == 7){ echo "EXPOSURE PERIOD"; }
		if($i == 0){ echo "<span class='text-danger'>SYMPTOM ONSET</span>"; }
		?></b>
		</td>
		<td>
		<input class="form-control" type="text" value="<?php if(!empty($crmdetails[14-$i]['e_date'])){ echo $crmdetails[14-$i]['e_date']; } ?>" name="e_date_<?php echo $i; ?>" id="e_date_<?php echo $i; ?>" <?php echo $i<14?"readonly":""; ?> <?php echo $i==14?"required":""; ?>></input>
		</td>
		<td><?php echo $i>0? "-".$i : 0; ?></td>
		
		<?php if($i<3){ if($i==2){?>
		
		<td rowspan="3" class="text-center">SEE PART II FOR <br/>CONTAGIOUS PERIOD</td>
		<td rowspan="3"></td>
		
		<?php }} else { ?>
		<td>
		<textarea class="form-control" id="e_location_<?php echo $i; ?>" name="e_location_<?php echo $i; ?>"><?php if(!empty($crmdetails[14-$i]['e_location'])){ echo $crmdetails[14-$i]['e_location']; } ?></textarea>
		</td>
		<td>
		<textarea class="form-control" id="e_contacts_<?php echo $i; ?>" name="e_contacts_<?php echo $i; ?>"><?php if(!empty($crmdetails[14-$i]['e_contacts'])){ echo $crmdetails[14-$i]['e_contacts']; } ?></textarea>
		</td>
		<?php } ?>
		
		
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
	<a href="<?php echo base_url()."covid_case/form/" .$crmrow['crm_id'] ."/transmission/"; ?>" class="btn btn-primary pull-right">Skip & Next</a>
	<?php } ?>
	
	</form> 
  </div>
 </div>

</div>
</div>
<section>
</div>