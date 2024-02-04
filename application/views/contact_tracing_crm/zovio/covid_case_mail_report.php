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
	<h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Generate Mail Logs - Zovio</h4>
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
	
	
	<div class="col-md-2" style="display:none">
	<div class="form-group">
      <label for="enddate">Report</label>
      <select class="form-control" name="report_type" required="required">
		<option value="excel">Excel</option>
	  </select>
    </div>
    </div>
	
	<div class="col-md-3">
    <div class="form-group" style="margin-top:20px">
		<button name="reportSubmission" type="submit" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
	</div>
	</div>
</div>
	
  </form>


</div>
</div>
</section>
</div>

  