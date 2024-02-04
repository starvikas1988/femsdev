<style>
		.show 
		{
			padding-right: 21%!important;
		}
		.color_link 
		{
			color: #007bff!important;
		}
		.correct_file
		{
			border: 2px solid #23e123 !important;
		}
		.wrong_file
		{
			border: 2px solid #e12323 !important;
		}
		#other_source_ref_container
		{
			display:none;
		}
		
		input[type=file] {
			background: skyblue;
		}
		
		.tableModel > thead > tr > th, .tableModel > thead > tr > td, .tableModel > tbody > tr > th, .tableModel > tbody > tr > td, .tableModel > tfoot > tr > th, .tableModel > tfoot > tr > td {
			padding:2px;
			font-size:11px;
		}
		
		.tableModel > tr > td{
			padding:2px;
			font-size:11px;
		}
	
</style>


<div class="" >
	<div class="row">		
		<div class="col-sm-12">
				<table id="default-datatable" data-plugin="DataTable" class="tableModel table-bordered" cellspacing="0" width="100%">
					<thead>
					 <tr class='bg-info'>
						<th>Description</th>
						<th>Uploaded File</th>
						<!-- <th>Action</th> -->
					  </tr>
					</thead>
					<tbody>

						<tr>
							<td>
								<label>Photograph</label>
							</td>
							<td>
								<input type="hidden" name="photoa" id="photo" value="<?php echo $get_person[0]['photo'];?>" >
							<?php if(!empty($get_person[0]['photo'])) { 
							$directory_check = "photo";
								$file_url = base_url() ."/uploads/" .$directory_check ."/" .$get_person[0]['photo'];
								$icon_url = getIconUrl($get_person[0]['photo'], $directory_check); } ?>
							<!--  -->
							<?php if (!empty($get_person[0]['photo'])) { ?>
								<a class="viewdocs">
								 <img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>
								 <?php echo $get_person[0]['photo']; ?> </a>
							<?php  } else{
								echo "No File Uploaded";
							} ?>
							</td>
							
					  	</tr>
					  	<?php if($user_office_id == "MAN" || $user_office_id == "CEB" || $user_office_id == "KOL"){ ?>
					  	<tr>
					  		<td>
					  		<?php if($user_office_id == "MAN" || $user_office_id == "CEB"){ ?>

								<label>SSS Number (Photocopy of E1 or SSS ID)</label>
						
							<?php	} else { ?>
							
								<label>Aadhar Card / Social Security No</label>
							

							<?php } ?>
							</td>

							<td><input type="hidden" name="" id="adhar" value="<?php echo $get_person[0]['attachment_adhar'];?>" >

								<?php if (!empty($get_person[0]['attachment_adhar'])) {
								$directory_check = "candidate_aadhar";
								$file_url = base_url() ."/uploads/" .$directory_check ."/" .$get_person[0]['attachment_adhar'];
								$icon_url = getIconUrl($get_person[0]['attachment_adhar'], $directory_check); } ?>
								 <?php if (!empty($get_person[0]['attachment_adhar'])) { ?>
								<a href="<?php echo base_url()."uploads/candidate_aadhar/".$get_person[0]['attachment_adhar'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_adhar']; ?> </a>
							<?php  } else{
								echo "No File Uploaded";
							} ?></td>
							
						
					 	</tr>
					 	<?php } ?>

						  <tr>
							<td>

								<?php if($user_office_id == "MAN" || $user_office_id == "CEB"){ ?>
							<label>TIN Number (Completely filled out 1902 & 2305 forms)</label>
							<?php	}
							elseif($user_office_id == "JAM"){ ?>
								<label>Tax Registration Number ID (To file taxes on the employee's behalf)</label>
							<?php }
							 else { ?>
								<label class="pan">PAN Card(optional)</label>
							<?php } ?>
								
							</td>
							<td>
								<?php if(!empty($get_person[0]['attachment_pan'])) { ?>
							<img src="<?php echo base_url()."uploads/pan/".$get_person[0]['attachment_pan'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
						</td>
							
						  </tr>


						  <?php if($user_office_id == "MAN" || $user_office_id == "CEB" || $user_office_id == "JAM"){ ?>
						  <tr>
							<td>

								

								<label>Birth Certificate</label>
						
							
							
								
							</td>
							<td>

								<?php if (!empty($get_person[0]['attachment_birth_certificate'])) {
								$directory_check = "candidate_birth";
								$file_url = base_url() ."/uploads/" .$directory_check ."/" .$get_person[0]['attachment_birth_certificate'];
								$icon_url = getIconUrl($get_person[0]['attachment_birth_certificate'], $directory_check); } ?>
								 <?php if (!empty($get_person[0]['attachment_birth_certificate'])) { ?>
								<a href="<?php echo base_url()."uploads/candidate_birth/".$get_person[0]['attachment_birth_certificate'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_birth_certificate']; ?> </a>
							<?php  }
							else{
								echo "No File Uploaded";
							} ?>
						</td>
							
					</tr>

					<?php	} ?>

					<?php if($user_office_id == "MAN" || $user_office_id == "CEB" || $user_office_id == "JAM"){ ?>
					<tr>
							<td>

								<?php if($user_office_id == "MAN" || $user_office_id == "CEB"){ ?>

								<label>Philhealth Number (Philhealth ID or completely filled out PMRF forms)</label>
						
							<?php	} elseif($user_office_id == "JAM"){ ?>
								
								<label>National Insurance Scheme ID (To file taxes on the employee's behalf)</label>
							
							<?php } ?>	
							</td>
							<td>

								<?php if (!empty($get_person[0]['attachment_health_insurence'])) {
								$directory_check = "candidate_insurence";
								$file_url = base_url() ."/uploads/" .$directory_check ."/" .$get_person[0]['attachment_health_insurence'];
								$icon_url = getIconUrl($get_person[0]['attachment_health_insurence'], $directory_check); } ?>
								 <?php if (!empty($get_person[0]['attachment_health_insurence'])) { ?>
								<a href="<?php echo base_url()."uploads/candidate_insurence/".$get_person[0]['attachment_health_insurence'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_health_insurence']; ?> </a>
							<?php  } 
							else{
								echo "No File Uploaded";
							} ?>
						</td>
							
					</tr>

					<?php } ?>


					<?php if($user_office_id == "MAN" || $user_office_id == "CEB"){ ?>
					<tr>
							<td>

						
								<label>NBI Clearance</label>
						
								
							</td>
							<td>

								<?php if (!empty($get_person[0]['attachment_nbi_clearence'])) {
								$directory_check = "candidate_nbi_clearence";
								$file_url = base_url() ."/uploads/" .$directory_check ."/" .$get_person[0]['attachment_nbi_clearence'];
								$icon_url = getIconUrl($get_person[0]['attachment_nbi_clearence'], $directory_check); } ?>
								 <?php if (!empty($get_person[0]['attachment_nbi_clearence'])) { ?>
								<a href="<?php echo base_url()."uploads/candidate_nbi_clearence/".$get_person[0]['attachment_nbi_clearence'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_nbi_clearence']; ?> </a>
							<?php  } 
							else{
								echo "No File Uploaded";
							} ?>
						</td>
							
					</tr>

					<?php	} ?>

					  

					</tbody>
				  </table>
				 <?php if(!empty($get_edu)) { ?>

				  <table class="table table-bordered">
							  <thead>
								<tr>
								  <th scope="col" colspan="8" class="text-center">Education Info <sup style="color:red;">*</sup></th>
								</tr>
							  </thead>
							  <tbody>
							  <tr style="background-color:#81CAF1">
							  	<td>SL</td>
							  	<td>Exam Name</td>
							  	<td>Passing Year</td>
							  	<td>Board/UV</td>
							  	<td>Specialization</td>
							  	<td>Grade/CGPA</td>
							  	<td>Uploaded File</td>
							  	<!-- <td>Action</td> -->
							  </tr>
							  <?php foreach ($get_edu as $key => $value): ?>
							  	<tr>
							  	<th scope="row"><?php echo $key+1; ?></th>
							  	<td><?php echo $value['exam']; ?></td>
							  	<input type="hidden" name="exam[]" class="exam" value="<?php echo $value['exam']; ?>" >
							  	<td><?php echo $value['passing_year']; ?></td>
							  	<td><?php echo $value['board_uv']; ?></td>
							  	<td><?php echo $value['specialization']; ?></td>
							  	<td><?php echo $value['grade_cgpa']; ?></td>
							  	<td>
							  		<input type="hidden" name="" id="edudoc<?php echo $key; ?>" value="<?php echo $value['education_doc'];?>" >
							  		<?php if(!empty($value['education_doc'])) {
									$directory_check = "education_doc";
									$file_url = base_url() ."/uploads/" .$directory_check ."/" .$value['education_doc'];
									$icon_url = getIconUrl($value['education_doc'], $directory_check); }
									 ?>
							  		<?php if(!empty($value['education_doc'])) {?>
							  			<a onclick="viewdocsedu(<?php echo $key; ?>)" title="click to view file" class="color_link">
							  	 <img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $value['education_doc']; ?> </a>
							  	<?php }
							  	else{
									  		echo "No File Uploaded";
									  	} ?></td>
							  	<!-- <td class="file_uploader_education" data-id="1">
									Upload Your Document PDF &amp; Image Files Only
									<input type="file" name="edu[]" accept=".doc,.docx,.pdf,image/*" required id="edufile">
								</td> -->
						</tr>
							  <?php endforeach ?>
							  
				  </tbody>
			</table>
		<?php } ?>

		<?php if(!empty($get_exp)) { ?>

			<table class="table table-bordered">
							  <thead>
								<tr>
								  <th scope="col" colspan="4" class="text-center">Experience 
								  	<sup style="color:red;">*</sup>
								  </th>
								</tr>
							  </thead>
							  <tbody>
							  <tr style="background-color:#81CAF1">
							  	<td>SL</td>
							  	<td>Organization</td>
							  	<td>Uploaded File</td>
							  	<!-- <td>Action</td> -->
							  </tr>
							  <?php foreach ($get_exp as $key => $value): ?>
							  		<tr>
									  	<th scope="row"><?php echo $key+1; ?></th>
									  	<td><?php echo $value['company_name']; ?></td>
									  	<input type="hidden" name="company_name[]" class="company_name" value="<?php echo $value['company_name']; ?>" >
									  	<td>
									  		<input type="hidden" id="expdoc<?php echo $key; ?>" class="company_name" value="<?php echo $value['experience_doc']; ?>" >
									  		<?php
									  		if(!empty($value['experience_doc'])) {
											$directory_check = "experience_doc";
											$file_url = base_url() ."/uploads/" .$directory_check ."/" .$value['experience_doc'];
											$icon_url = getIconUrl($value['experience_doc'], $directory_check); }
											?>
									  		<?php if(!empty($value['experience_doc'])) { ?>
									  			<a onclick="viewdocsexp(<?php echo $key; ?>)" title="click to view file" class="color_link"> 
									  			<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $value['experience_doc']; ?></a>
									  	<?php  }  else{
									  		echo "No File Uploaded";
									  	} ?></td>
									  	
									</tr>
							  <?php endforeach ?>
							  							  

						</tbody>
					</table>
				<?php } ?>

<div class="modal fade" id="viewdocsmodal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width:800px;">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" id="show_docs">
						
					</div>
				</div>
			</div>
			<div class="row" style="margin-left:8px" id="req_details">
				
			</div>
			
			</br></br>
			
      </div>
    </div>
  </div>
</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
$(document).ready(function(){
	var get_personal = $(".pan_val").val();
	if (get_personal != "")  {
		$(".pan").text('PAN Card*');
		$("#pan").attr('required', true);
	 }
});


function showPleaseWait() {
    
    if (document.querySelector("#pleaseWaitDialog") == null) {
        var modalLoading = '<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" role="dialog">\
            <div class="modal-dialog">\
                <div class="modal-content">\
                    <div class="modal-header">\
                        <h4 class="modal-title">Please wait...</h4>\
                    </div>\
                    <div class="modal-body">\
                        <div class="progress">\
                          <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"\
                          aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height: 40px">\
                          </div>\
                        </div>\
                    </div>\
                </div>\
            </div>\
        </div>';
        $(document.body).append(modalLoading);
    }
  
    $("#pleaseWaitDialog").modal("show");
}

/**
 * Hides "Please wait" overlay. See function showPleaseWait().
 */
function hidePleaseWait() {
    $("#pleaseWaitDialog").modal("hide");
}

</script>

<script type="text/javascript">

var baseURL="<?php echo base_url(); ?>";	
	
$('#panfile').change(function () {
    	var uploadpath = $('#panfile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);

	    if (fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported");
	        $('#panfile').val('');
	        return false;
	    }
});

$('#photofile').change(function () {
    	var uploadpath = $('#photofile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);

	    if (fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported");
	        $('#photofile').val('');
	        return false;
	    }
});

$('#adharfile').change(function () {
    	var uploadpath = $('#adharfile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);

	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported");
	        $('#adharfile').val('');
	        return false;
	    }
});

$('#expfile').change(function () {
    	var uploadpath = $('#expfile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);

	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported");
	        $('#expfile').val('');
	        return false;
	    }
});

$('#edufile').change(function () {
    	var uploadpath = $('#edufile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);

	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported");
	        $('#edufile').val('');
	        return false;
	    }
});

$(document).on('click','#reload_captcha',function()
			{
				var datas = {};
				$.ajax({
					type	:	'POST',
					url		:	'<?php echo base_url('applyjoblink/captcha/true'); ?>',
					data	:	datas,
					success	:	function(msg){
					var msg_json = JSON.parse(msg);
								$('#captcha_image').html(msg_json.image);
								
							}
				});
			});


		$(".viewdocs").click(function(){
			$("#viewdocsmodal").modal('show');
			var photo = $('#photo').val();
			$("#show_docs").html('<img style="width: 100%;" src="'+baseURL+'/uploads/photo/'+photo+'"/>');	
		});


		$(".viewdocs1").click(function(){
			$("#viewdocsmodal").modal('show');
			var pan = $('#pan').val();
			$("#show_docs").html('<img style="width: 100%;" src="'+baseURL+'/uploads/pan/'+pan+'"/>');
		});

		$(".viewdocs2").click(function(){
			$("#viewdocsmodal").modal('show');
			var adhar = $('#adhar').val();
			$("#show_docs").html('<iframe style="width: 100%; height: 600px;" src="'+baseURL+'/uploads/candidate_aadhar/'+adhar+'"/>');
		});


	function viewdocsedu(key){
		$("#viewdocsmodal").modal('show');
		var edu = $('#edudoc'+key).val();
		$("#show_docs").html('<iframe style="width: 100%; height: 600px;" src="'+baseURL+'/uploads/education_doc/'+edu+'"/>');
	}

	function viewdocsexp(key){
		$("#viewdocsmodal").modal('show');
		var exp = $('#expdoc'+key).val();
		$("#show_docs").html('<iframe style="width: 100%; height: 600px;" src="'+baseURL+'/uploads/experience_doc/'+exp+'"/>');
	}


</script>
