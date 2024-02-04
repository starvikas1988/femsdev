<style type="text/css">
  	h3, form{
  		padding-left: 10px;
  		padding-right: 10px;
  	}
</style>
  
<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">
	
<div class="row">
<div class="col-md-12">
	<h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Generate Report</h4>
	<hr/>
</div>
</div>

<form method="GET" enctype="multipart/form-data" action="" autocomplete="off">

<div class="row">
	<div class="col-md-3">
    <div class="form-group">
      <label for="startdate">Start Date</label>
      <input type="text" class="form-control newDatePick" id="start_date" value="<?php echo $start_date; ?>" name="start_date" required>
    </div>
	</div>
	
	<div class="col-md-3">
    <div class="form-group">
      <label for="enddate">End date</label>
      <input type="text" class="form-control newDatePick" id="end_date" value="<?php echo $end_date; ?>" name="end_date" required>
    </div>
    </div>
	
	<div class="col-md-4">
    <div class="form-group">
         <label for="type">Select Location</label>
		  <select class="form-control" name="main_location">
			<option value="">ALL</option>
			<?php 			
			/*foreach($caseLocation as $keyt){ 
				$selected="";
				if($keyt['caller_store_location'] == $main_location){ $selected="selected"; }
				if($keyt['caller_store_location']!=""){
			?>
			<option value="<?php echo $keyt['caller_store_location']; ?>" <?php echo $selected; ?>><?php echo $keyt['caller_store_location']; ?></option>
			<?php }*/
			foreach ($school_list as $kt=> $keyt) {
				$selected = "";
				if ($keyt['id'] == $main_location) {
					$selected = "selected";
				}
				if ($keyt['id'] != "") {
			?>
					<option value="<?php echo $keyt['id']; ?>" <?php echo $selected; ?>><?php echo $keyt['name']; ?></option>
			<?php }
			} ?>
		  </select>
    </div>
    </div>
	
	<div class="col-md-4">
    <div class="form-group">
         <label for="type">Select Agent</label>
		  <select class="form-control" name="main_agent">
			<option value="">ALL</option>
			<?php 			
			foreach($caseAgents as $keyt){ 
				$selected="";
				if($keyt['agent_id'] == $main_agent){ $selected="selected"; }
				if($keyt['agent_id']!=""){
			?>
			<option value="<?php echo $keyt['agent_id']; ?>" <?php echo $selected; ?>><?php echo $keyt['fullname']; ?></option>
			<?php } } ?>
		  </select>
    </div>
    </div>
	
	<div class="col-md-4">
    <div class="form-group">
         <label for="type">Select Type</label>
		  <select class="form-control" name="main_type">
			<option value="">ALL</option>
			<?php 			
			foreach($caseTypes as $key=>$val){ 
				$selected="";
				if($key == $currReportType){ $selected="selected"; }
			?>
			<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $val; ?></option>
			<?php } ?>
		  </select>
    </div>
    </div>
	
	<div class="col-md-2">
    <div class="form-group">
         <label for="type">Case Status</label>
		  <select class="form-control" name="case_status">
			<option value="">ALL</option>
			<option value="P" <?php echo $case_type == 'P' ? 'selected' : ''; ?>>Open</option>
			<option value="C" <?php echo $case_type == 'C' ? 'selected' : ''; ?>>Closed</option>
		  </select>
    </div>
    </div>
	
	<div class="col-md-2" style="display:none">
	<div class="form-group">
      <label for="enddate">Report</label>
      <select class="form-control" name="report_type" required="required">
		<option value="excel">Excel</option>
		<option value="zip">Zip</option>
	  </select>
    </div>
    </div>
	
	<div class="col-md-3">
    <div class="form-group">
		<button name="reportSubmission" style="margin-top:20px" type="submit" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
	</div>
	</div>
</div>
	
</form>


</div>
</div>
</section>
</div>

  