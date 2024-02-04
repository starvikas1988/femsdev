<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
<div class="wrap">
<section class="app-content">

<div class="widget">
<header class="widget-header">
	<h2 class="widget-title">Dynamic POP Up system</h2>
</header>
<hr class="widget-separator">


<div class="widget-body">

<div class="row">
<div class="col-md-12">

	<div class="card card-primary">
	  <div class="card-header">
		<h3 class="card-title"><i class="fa fa-edit"></i> Please Fill This Form</h3>
		<hr/>
	  </div>
	  <?php
	  $display_location = 'none';
	  $display_individual = 'none';
	  $display_team = 'none';
	  $display_client = 'none';
	  $display_process = 'none';
	  $display_global = 'none';
	//   var_dump($pop_up);die;
	   if(isset($pop_up)){
		$pop_up = reset($pop_up);
		// $start_time = new DateTime($pop_up['start_time']);
		$start_time = $pop_up['start_time'];
		$end_time = $pop_up['end_time'];
		$update_id = $pop_up['id'];
		switch ($pop_up['preferances']) {
			case 'Individual':
				$Individual = 'Selected=selected';
				$display_individual = 'block';
				$Individual_content = $pop_up['femsid'];
			break;
			case 'Team':
				$Team = 'Selected=selected';
				$display_team = 'block';
				$Team_content = $pop_up['team'];
			break;
			case 'Client':
				$Client = 'Selected=selected';
				$display_client = 'block';
				$Client_content = $pop_up['client'];
			break;
			case 'Process':
				$Process = 'Selected=selected';
				$display_process = 'block';
				$display_client = 'block';
				$Process_content = $pop_up['process'];
				$Client_content = $pop_up['client'];
			break;
			case 'Location':
				$Location = 'Selected=selected';
				$display_location = 'block';
				$Location_content = $pop_up['location'];
			break;
		    case 'Global':
				$Global = 'Selected=selected';
				$display_global = 'block';
			break;
			
			default:
				# code...
				break;
		}
	  } ?>
	  <form method="POST" action="<?php echo base_url('dynamic_pop_up/action'); ?>" autocomplete="off" enctype="multipart/form-data">
     <?php 
	 if(isset($pop_up)){?>
			<input type="hidden" name="update_id" value="<?php echo $update_id; ?>">
	 <?php } ?>
        <div class="row">
        <div class="form-group col-md-3">
			<label for="preferances">Display Preference</label>
			<select class="form-control" name="preferances" id="preferances">
			    <option>Select Option</option>
                <option val='Individual' <?php echo isset($Individual)? $Individual:''; ?> >Individual</option>
                <option val='Team' <?php echo isset($Team)? $Team:''; ?>>Team</option>
				<option val='Client' <?php echo isset($Client)? $Client:''; ?>>Client</option>
				<option val='Process' <?php echo isset($Process)? $Process:''; ?>>Process</option>
                <option val='Location' <?php echo isset($Location)? $Location:''; ?>>Location</option>
                <option val='Global' <?php echo isset($Global)? $Global:''; ?>>Global</option>
            </select>
		  </div>	  
		  <div class="form-group col-md-3">
			<label for="startdate">Display Start Date</label>
			<input type="datetime-local" class="form-control" name="start_date" value="<?php echo isset($start_time)? date('Y-m-d\TH:i:s', strtotime($start_time)):''?>" required>
		  </div>
          <div class="form-group col-md-3">
			<label for="enddate">Display End Date</label>
			<input type="datetime-local" class="form-control" name="end_date" value="<?php echo isset($end_time)? date('Y-m-d\TH:i:s', strtotime($end_time)):'' ?>" required>
		  </div>
         
		</div>
		<div class="row">		  
		  <div class="form-group col-md-3" id='loc' style="display:<?php echo $display_location; ?>">
			<label for="Location">Location</label><br>
			<select class="form-control selectpicker" id="location" multiple data-live-search="true" name="location[]">
				<option value="">Select</option>
				<?php foreach($location_data as $lc): 
					$cScc='';
					$Location_data = explode(",",$Location_content);

					if(in_array($lc['abbr'],$Location_data)){$cScc='Selected';};
					// if($lc['abbr']==$Location_content) $cScc='Selected';
				?>
					<option value="<?php echo $lc['abbr']; ?>" <?php echo $cScc; ?> ><?php echo $lc['location']; ?></option>
				<?php endforeach; ?>
			</select>
			
		  </div>
		  <div class="form-group col-md-3" id='clie' style="display:<?php echo $display_client; ?>">
			<label for="Client">Client</label><br/>
				<select class="selectpicker" multiple data-live-search="true" id="fclient_id" name="client[]" >
					<option value="ALL">ALL</option>
					<?php foreach($client_list as $client): 
						$cScc='';
      					$Client_data = explode(",",$Client_content);

					    if(in_array($client->id,$Client_data)){$cScc='Selected';};

						// if($client->id==$client_id) $cScc='Selected';
					?>
				<option value="<?php echo $client->id; ?>" <?php echo $cScc; ?> ><?php echo $client->shname; ?></option>
				<?php endforeach; ?>
			</select>
		  </div>
          <div class="form-group col-md-3" id='proc' style="display:<?php echo $display_process; ?>">
			<label for="Process">Process</label><br/>
			<select class="selectpicker" multiple data-live-search="true" id="fprocess_id" name="process[]" >
				<option value="ALL">ALL</option>
				<?php foreach($process_list as $process): 
					$cScc='';
					$Process_data = explode(",",$Process_content);

					if(in_array($process->id,$Process_data)){$cScc='Selected';};
					// if($process->id==$process_id) $cScc='Selected';
				?>
				<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?> ><?php echo $process->name; ?></option>
			<?php endforeach; ?>
			</select>
		  </div>
		  <div class="form-group col-md-3" id='indv' style="display:<?php echo $display_individual; ?>">
				<label for="Client">FEMS Id</label>
                <textarea  class="form-control" name="femsid" value="" id="individual"><?php echo isset($Individual_content)? $Individual_content:''; ?></textarea>
            </div>
			<div class="form-group col-md-3" id='teams' style="display:<?php echo $display_team; ?>">
			<label for="Client">L1-Supervisor</label>
			<select class="selectpicker" multiple data-live-search="true" id="l1Super" name="l1Super[]">
			<!-- <select class="form-control" id="l1Super" name="l1Super"> -->
				<option value="">-Select-</option>
				<?php 
					foreach($user_tlmanager as $tl):
					$cScc='';
					$Team_data = explode(",",$Team_content);

					if(in_array($tl['id'],$Team_data)){$cScc='Selected';};
					// if($tl['id']==$l1Super) $cScc='Selected';
				?>
					<option value="<?php echo $tl['id']; ?>" <?php echo $cScc; ?>><?php echo $tl['name']." - ".$tl['fusion_id']; ?></option>
				<?php endforeach; ?>
			</select>
            </div>
       
		</div>
        <div class="row">
            <div class="form-group col-md-3">
				<label for="Client">Image:</label>
				<?php 
				$required = 'required';
				if(isset($pop_up['image_path'])){
					$required = '';?>
					<img src="<?php echo base_url(); ?>uploads/dynamic_pop_up/<?php echo $pop_up['image_path']; ?>" style="width:50px;height:50px;border-radius:5px;">
				<?php }
				?>
				
				<input type="file" class="form-control" name="file" value="" accept="image/*" <?php echo isset($required)? $required:''; ?> >
            </div>
			<div class="form-group col-md-3">
				<label for="Client">Redirect Link:</label>
				<input type="text" class="form-control" name="link" value="<?php echo isset($pop_up['img_link'])? $pop_up['img_link']:''; ?>" >

			</div>
            <div class="form-group col-md-3" style="text-align:center">
            	<button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
	  </form>
	</div>
			
</div>
</div>

</div>
</div>
</section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
$('#preferances').on('change', function() {
//   alert( this.value );
var a=this.value;
    $('#indv').hide();
	$('#loc').hide();
	$('#clie').hide();
	$('#proc').hide();
	$('#teams').hide();
if(a=='Individual'){
	$('#indv').show();
	$("#individual").prop('required',true);
}else if(a=='Location'){
	$('#loc').show();
	$("#location").prop('required',true);
}else if(a=='Client'){
	$('#clie').show();
	$("#fclient_id").prop('required',true);
}else if(a=='Team'){
	$('#teams').show();
}else if(a=='Process'){
	$('#clie').show();
	$('#proc').show();
	$("#fclient_id").prop('required',true);
	$("#fprocess_id").prop('required',true);
}
});
// $("#fclient_id").change(function(){
//   var client_id=$(this).val();
			
//   populate_process_combo(client_id,'','fprocess_id','Y');
// });
$('select').selectpicker();
</script>