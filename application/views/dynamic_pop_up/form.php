<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>

<style>
	.select2-container--default .select2-selection--multiple .select2-selection__choice {
		margin-top:0!important;
		margin-bottom: 5px;
	}	
	.filter-widget .select2-selection {
		overflow-y:scroll;
	}
	.choose-bg {
		border:1px solid #ddd!important;
		transition:all 0.5s ease-in-out 0s;
	}
	.choose-bg:hover {
		border:1px solid #188ae2!important;
	}
	

</style>

<?php
	  $Individual_content='';
	  $Location_content='';
	  $Team_content='';
	  $Client_content='';
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
<div class="wrap">
	<div class="widget">
		<div class="widget-body">
			<div class="filter-widget">
				<h4><?php echo $form_type; ?> Pop-up</h4>
				<span style="letter-spacing:0.5px;font-size:14px;">* Operational Timezone - EST</span>
				<hr style="margin-top:10px;">
				<form method="POST" action="<?php echo base_url('dynamic_pop_up/action'); ?>" autocomplete="off" enctype="multipart/form-data">
				<?php 
				if(isset($pop_up)){?>
						<input type="hidden" name="update_id" value="<?php echo $update_id; ?>">
				<?php } ?>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label>Start date</label>
							<input type="datetime-local" name="start_date" class="form-control" value="<?php echo isset($start_time)? date('Y-m-d\TH:i:s', strtotime($start_time)):''?>" required>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>End date</label>
							<input type="datetime-local" name="end_date" class="form-control" value="<?php echo isset($end_time)? date('Y-m-d\TH:i:s', strtotime($end_time)):'' ?>" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label>Display Preference</label>
							<select name="preferances" id="preferances" class="form-control">
								<option>Select Option</option>
								<option value='Individual' <?php echo isset($Individual)? $Individual:''; ?> >Individual</option>
								<option value='Team' <?php echo isset($Team)? $Team:''; ?>>Team</option>
								<option value='Client' <?php echo isset($Client)? $Client:''; ?>>Client</option>
								<option value='Process' <?php echo isset($Process)? $Process:''; ?>>Process</option>
								<option value='Location' <?php echo isset($Location)? $Location:''; ?>>Location</option>
								<option value='Global' <?php echo isset($Global)? $Global:''; ?>>Global</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div id='indv' style="display:<?php echo $display_individual; ?>">
							<div class="form-group">
								<label for="individual">FEMS Id</label>
								<textarea  class="form-control" name="femsid" value="" id="individual" placeholder="EX: FKOL000001,FKOL000002" onkeyup="nospaces(this)"><?php echo isset($Individual_content)? $Individual_content:''; ?></textarea>
							</div>
						</div>
						<div id='teams' style="display:<?php echo $display_team; ?>">
							<div class="form-group">
								<label for="l1Super">L1-Supervisor</label>
								<select class="form-control" style="width:100%; height:100px" id="l1Super" name="l1Super[]" multiple>
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
						<div id='loc' style="display:<?php echo $display_location; ?>">
							<div class="form-group">
								<label for="location">Location</label>
								<select class="form-control" style="width:100%; height:100px" id="fdoffice_ids" name="location[]" autocomplete="off"  multiple>
								<!-- <option value=""></option> -->
								<?php foreach($location_data as $lc): 
									$cScc='';
									$Location_data = explode(",",$Location_content);

									if(in_array($lc['abbr'],$Location_data)){$cScc='Selected';};
									// if($lc['abbr']==$Location_content) $cScc='Selected';
								?>
									<option value="<?php echo $lc['abbr']; ?>" <?php echo $cScc; ?> ><?php echo $lc['office_name']; ?></option>
								<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div id='clie' style="display:<?php echo $display_client; ?>">
							<div class="form-group">
								<label for="fclient_id">Client</label>
								<select class="form-control" style="width:100%; height:100px" id="fclient_id" name="client[]" multiple>
									<option value="">Select</option>
									<option value="0">All</option>
									<?php 
									$Client_data = explode(",",$Client_content);
									foreach($client_list as $client): 
										$cScc='';
										if(in_array($client->id,$Client_data)){$cScc='Selected';};
									?>
									<option value="<?php echo $client->id; ?>" <?php echo $cScc; ?> ><?php echo $client->shname; ?></option>
									<?php endforeach; ?>
								</select>
								
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div id='proc' style="display:<?php echo $display_process; ?>">
							<div class="form-group">
								<label for="fprocess_id">Process</label>
								<select class="form-control" style="width:100%; height:100px" multiple id="fprocess_id" name="process[]">
									<option value="">Select</option>
									<option value="0">All</option>
									<?php 
									$Process_data = explode(",",$Process_content);
									foreach($process_list as $process): 
										$cScc='';
										if(in_array($process->id,$Process_data)){$cScc='Selected';};
									?>
									<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?> ><?php echo $process->name; ?></option>
									<?php endforeach; ?>
								</select>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
						<label for="">Upload Featured Image</label>
						<?php 
							$required = 'required';
							if(isset($pop_up['image_path'])){
								$required = '';?>
								<img src="<?php echo base_url(); ?>uploads/dynamic_pop_up/<?php echo $pop_up['image_path']; ?>" style="width:50px;height:50px;border-radius:5px;">
							<?php }
							?>							
							<input type="file" class="form-control choose-bg" name="file" value="" accept="image/*" <?php echo isset($required)? $required:''; ?> >							
						</div>
					</div>		
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Redirect Link</label>
							<input type="text" class="form-control" name="link" value="<?php echo isset($pop_up['img_link'])? $pop_up['img_link']:''; ?>" placeholder="Write full link...">
						</div>
					</div>		
				</div>		
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<button type="submit" class="submit-btn">							
								Submit
							</button>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function () {
	var baseURL ="<?php echo base_url(); ?>";
	$("#fclient_id").select2();
	$("#fprocess_id").select2();
	$("#location").select2();
	$("#l1Super").select2();
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
		$("#location").removeAttr('required',true);
		$("#fclient_id").removeAttr('required',true);
		$("#fprocess_id").removeAttr('required',true);
		$("#l1Super").removeAttr('required',true);
	}else if(a=='Location'){
		$('#loc').show();
		$("#location").prop('required',true);
		$("#individual").removeAttr('required',true);
		$("#fclient_id").removeAttr('required',true);
		$("#fprocess_id").removeAttr('required',true);
		$("#l1Super").removeAttr('required',true);
	}else if(a=='Client'){
		$('#clie').show();
		$("#fclient_id").prop('required',true);
		$("#individual").removeAttr('required',true);
		$("#location").removeAttr('required',true);
		$("#fprocess_id").removeAttr('required',true);
		$("#l1Super").removeAttr('required',true);
	}else if(a=='Team'){
		$('#teams').show();
		$("#l1Super").prop('required',true);
		$("#individual").removeAttr('required',true);
		$("#location").removeAttr('required',true);
		$("#fclient_id").removeAttr('required',true);
		$("#fprocess_id").removeAttr('required',true);
	}else if(a=='Process'){
		$('#clie').show();
		$('#proc').show();
		$("#fclient_id").prop('required',true);
		$("#fprocess_id").prop('required',true);
		$("#individual").removeAttr('required',true);
		$("#location").removeAttr('required',true);
		$("#l1Super").removeAttr('required',true);
	}else if(a=='Global'){
		$("#individual").removeAttr('required',true);
		$("#location").removeAttr('required',true);
		$("#fclient_id").removeAttr('required',true);
		$("#fprocess_id").removeAttr('required',true);
		$("#l1Super").removeAttr('required',true);
	}
	});
	$("#fclient_id").change(function(){
       		var clients = $('#fclient_id').val(); 
			var cl = $('#preferances').val();
			if(cl == 'Process'){
				$.ajax({
					type: 'GET',    
					url:baseURL+'dynamic_pop_up/get_process_by_clients',
					data:'clients='+ clients,
					success: function(data){
						var res;
						var i=0;
						var a = JSON.parse(data); 
						
						var b = $("#fprocess_id").val();
						$("#fprocess_id option").remove();
					
						if(b != null){ 
							var res =  b.toString().split(',');
							var leng = res.length;
						}
						$.each(a, function(index,jsonObject){
							
							if( i < leng){
								if(jsonObject.id == res[i]){
										$("#fprocess_id").append('<option value="'+jsonObject.id+'" selected="selected">' + jsonObject.name + '</option>');
										i++;
								}else{
									$("#fprocess_id").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
								}
							}else{
								$("#fprocess_id").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
							}
						});	
					}
				});
			}
		});
});
function nospaces(t){
  if(t.value.match(/\s/g)){
    t.value=t.value.replace(/\s/g,'');
  }
}
// $("#fclient_id").change(function(){
//   var client_id=$(this).val();
			
//   populate_process_combo(client_id,'','fprocess_id','Y');
// });
// $('select').selectpicker();
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('.multi_select').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#fdoffice_ids').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});

</script>
