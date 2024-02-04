<!-- Schedule -->

<div class="wrap">
<style>
	#OutputDiv{
	
		color:red;
		font-weight:bold;
		font-size:1.1em;
	}
	
	.glowbutton {
	  background-color: #004A7F;
	  -webkit-border-radius: 10px;
	  border-radius: 10px;
	  border: none;
	  color: #FFFFFF;
	  cursor: pointer;
	  display: inline-block;
	  font-family: Arial;
	  font-size: 14px;
	  padding: 5px 10px;
	  text-align: center;
	  text-decoration: none;
	  -webkit-animation: glowing 1500ms infinite;
	  -moz-animation: glowing 1500ms infinite;
	  -o-animation: glowing 1500ms infinite;
	  animation: glowing 1500ms infinite;
	}
	@-webkit-keyframes glowing {
	  0% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
	  50% { background-color: #FF0000; -webkit-box-shadow: 0 0 40px #FF0000; }
	  100% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
	}

	@-moz-keyframes glowing {
	  0% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
	  50% { background-color: #FF0000; -moz-box-shadow: 0 0 40px #FF0000; }
	  100% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
	}

	@-o-keyframes glowing {
	  0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
	  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
	  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
	}

	@keyframes glowing {
	  0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
	  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
	  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
	}

</style>


<section class="app-content">

<div class="row">
<div class="col-md-12">
<?php if($this->uri->segment($this->uri->total_segments()) == 'error'){ ?>
<div class="alert alert-danger" role="alert">
  ERROR : Something Went Wrong!
</div>
<?php } ?>
<?php if($this->uri->segment($this->uri->total_segments()) == 'success'){ ?>
<div class="alert alert-success" role="alert">
  SUCCESS : Data Uploaded Successfully!
</div>
<?php } ?>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Availiability Upload
<a class="btn btn-primary btn-sm pull-right" target="_blank" href='<?php echo base_url('diy_test/download_sample_availiability_log'); ?>'><i class="fa fa-download"></i> Sample Format</a>
</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">

<form method="POST" enctype="multipart/form-data">

<div class="row">
<div class="col-md-6">
	<div class="form-group" >
	<h4 class="widget-title">Please Select the File to Upload Schedule for Teachers</h4>
	</div>
</div>
</div>

<hr/>
<div class="row">
<div class="col-md-3" style="width:215px;">	
	<div class="form-group" >
		<label for="sedate">Upload File</label>
	</div>
</div>
<div class="col-md-3" style="width:215px;">	
	<div class="form-group" >
		<input type="file" name="userfile" accept=".csv" required>
		<input type="hidden" name="upload_file" value="1">
	</div>
</div>
<div class="col-md-3" style="width:215px;">	
	<div class="form-group" >
		<select name="timezone_id" class="form-control">
	<?php 
	foreach($gmtlist as $token){			
	$selection = "";
	if($mytime == $token['GMT_offset']){ $selection = "selected"; }
	
	?>
	<option value="<?php echo $token['GMT_offset']; ?>" <?php echo $selection; ?>><?php echo $token['gmtCountryName']; ?></option>
	<?php } ?>
	</select>
	</div>
</div>
</div>
<br/>
<div class="row">
<div class="col-md-3" style="width:215px;">	
	<div class="form-group" >
		<button type="submit" name="uploadAvailiability" class="btn btn-danger">Upload</button>
	</div>
</div>
</div><!-- .row -->
</form>
</div>
</div>
</div>



<?php if(!empty($uploadData)){ ?>
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Upload Logs
<a class="btn btn-primary btn-sm pull-right" target="_blank" href='<?php echo base_url('diy/download_upload_log'); ?>'><i class="fa fa-download"></i> Export Log</a>

</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<div class="table-responsive">
	<table id="dataExportTable" class="table table-striped skt-table" cellspacing="0" width="100%">
		<thead>
			<tr class='bg-info'>
				<th>SL</th>
				<th>Status</th>
				<th>Remarks</th>
				<th>Date</th>
				<th>Day</th>
				<th>Teacher Name</th>
				<th>Teacher Email</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>TimeZone</th>
				<th>GmtTime</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$counter=0;
			foreach($uploadData['csv'] as $row){ 
				$counter++;
				$classCheck = "";
				if($row['status'] == 'error'){
					$classCheck = "style='background-color:#fbd1d1'";
				}
				if($row['status'] == 'success' && $row['email_status'] == 1){
					$classCheck = "style='background-color:#d2ffd3'";
				}
			?>
			<tr <?php echo $classCheck; ?>>
				<td><?php echo $counter; ?></td>
				<td><?php echo $row['status']; ?></td>
				<td><?php echo !empty($row['remarks']['error']) ? $row['remarks']['error'] ."," .$row['remarks']['success'] : $row['remarks']['success']; ?></td>
				<td><?php echo $row['avail_date']; ?></td>
				<td><?php echo $row['avail_day']; ?></td>
				<td><?php echo $row['teacher_name']; ?></td>
				<td><?php echo $row['teacher_email']; ?></td>
				<td><?php echo $row['avail_start_time']; ?></td>
				<td><?php echo $row['avail_end_time']; ?></td>
				<td><?php echo $row['avail_timezone']; ?></td>
				<td><?php echo $row['gmtTime']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
</div>
</div>
</div>
<?php } ?>


</div><!-- .row -->

</section>

</div><!-- .wrap -->


