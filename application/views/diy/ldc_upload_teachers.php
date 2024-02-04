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
<h4 class="widget-title">Teacher Upload
<a class="btn btn-primary btn-sm pull-right" target="_blank" href='<?php echo base_url('diy/download_sample_teacher_log'); ?>'><i class="fa fa-download"></i> Sample Format</a>
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

<div class="col-md-6">
	<div class="form-group">
	<label for="office_id">Location</label>
		<select class="form-control" name="office_id" id="office_id" multiple required>
			<option value=''>-- Select a Location --</option>
			<?php foreach($location_list as $loc): ?>
				<option value="<?php echo $loc['abbr'];?>"><?php echo $loc['office_name'];?></option>
			<?php endforeach; ?>									
		</select>
	</div>
</div>
</div>


<div class="row">
<div class="col-md-6">
	<div class="form-group" id="client_div">
	<label for="client_id">Select Client(s)</label>
		<select class="form-control" name="client_id" id="client_id">
			<option>-Select-</option>
			<?php foreach($client_list as $client): ?>
				<option value="<?php echo $client->id ?>"><?php echo $client->shname ?></option>
			<?php endforeach; ?>							
		</select>
	</div>
</div>
<div class="col-md-6">
	<div class="form-group" id="process_div">
	<label for="process_id">Select Process</label>
		<select class="form-control" name="process_id" id="process_id">
			<option>-Select-</option>
			<?php foreach($process_list as $process): ?>
				<option value="<?php echo $process->id ?>"><?php echo $process->name ?></option>
			<?php endforeach; ?>							
		</select>
	</div>
</div>				
</div>

<br/><br/>
						
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
</div>
<br/>
<div class="row">
<div class="col-md-3" style="width:215px;">	
	<div class="form-group" >
		<button type="submit" name="uploadSchedule" class="btn btn-danger">Upload</button>
	</div>
</div>
</div><!-- .row -->
</form>
</div>
</div>
</div>



</div><!-- .row -->

</section>

</div><!-- .wrap -->


