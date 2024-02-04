<style>
.customRadio{
	padding-left:20px;
}
.customRadio input{
	margin-right:10px;
}
</style>
<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">	

  <h4>Ameridial Downtime Tracker</h4>
  <hr/>
  <h5>
  <b>NAME: </b>&nbsp;&nbsp;<u>&nbsp;<?php echo $agent_details['fname'] ." " .$agent_details['lname']; ?> (<?php echo $agent_details['fusion_id']; ?>)&nbsp;</u> 
  </h5>
  <hr/>
 
 <?php
 	$idd = $ameridialData['id'] ? $ameridialData['id'] : '';
 	$issue_date = $ameridialData['issue_date'] ? $ameridialData['issue_date'] : date('Y-m-d', strtotime($today));
 	$issue_time = $ameridialData['issue_time'] ? $ameridialData['issue_time'] : date('H:i', strtotime($today));
 	$ticket = $ameridialData['ticket_no'] ? $ameridialData['ticket_no'] : '';
 	$issuee = $ameridialData['issue'] ? $ameridialData['issue'] : '';
 	$remarkss = $ameridialData['remarks'] ? $ameridialData['remarks'] : '';
 ?> 

<form action="<?php echo base_url()?>downtime/submit_ameridial_form" method="POST" autocomplete="off">

<input type="hidden" class="form-control" id="agent_uid" value="<?php echo $agent_details['id']; ?>" placeholder="" name="agent_uid" required readonly>

<div class="row">
<div class="col-md-12">  
 <div class="panel panel-default">
  <div class="panel-heading">Ameridial Downtime Form</div>
  <div class="panel-body"> 
	<br/>
	<input type="hidden" class="form-control" id="id" placeholder="" value="<?php echo $idd;?>" name="id" required>
	<div class="row">
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Issue Date</label>
		  <input type="date" class="form-control" id="issue_date" placeholder="" value="<?php echo $issue_date;?>" name="issue_date" required>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Issue Time</label>
		  <input type="time" class="form-control" id="issue_time" placeholder="" value="<?php echo $issue_time; ?>" name="issue_time" required>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="form-group">
		  <label for="case">Ticket No</label>
		  <input type="text" class="form-control" id="ticket_no" placeholder="" value="<?php echo $ticket; ?>" name="ticket_no" required>
		</div>
	</div>
	</div>
	
	<br/>
	
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Issue</label>
		  <textarea type="text" class="form-control" id="issue" placeholder="" name="issue" required><?php echo $issuee; ?></textarea>
		</div>
	</div>
	</div>
	
	<br/>
	
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Remarks</label>
		  <textarea type="text" class="form-control" id="remarks" placeholder="" name="remarks" required><?php echo $remarkss; ?></textarea>
		</div>
	</div>
	</div>
	
  
  
  </div>
</div>
</div>
</div>
  
<div class="panel panel-default">
<div class="panel-body">
<div class="row">
<div class="col-md-6">	
	<button type="submit" style="padding-left:10px" name="save" class="btn btn-success">Submit</button>
</div>
</div>
</div>
</div>
  
	
</form> 
	
	
  </div>
 </div>
<section>
</div>