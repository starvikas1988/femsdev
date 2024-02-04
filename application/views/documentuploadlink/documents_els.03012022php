<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<title>Upload Documents</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/date-picker.css">  
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom2.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<style>
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

		td{
			font-size: 12px;
		}
		.form-control {
			height: unset;
			font-size: unset;
    		padding: unset;
    		width: unset;
		}
		input[type=file] {
			background: skyblue;
		}

</style>
</head>
<body>
<div class="container">
	<div class="top-main">
		<div class="row" style="border-bottom: 2px solid #b4b4b4;margin-bottom: 20px;">
			<div class="col-sm-4">
				<div class="body-widget">
					<img src="<?php echo base_url(); ?>assets/css/images/fusion-logo.png" class="logo" alt="">
				</div>
			</div>
		</div>	
	</div>
	<div class="row wide">
		<!-- <?php print_r($get_person); ?> -->
		<!--  action="<?php echo base_url()."document/process_upload" ?>" -->
		<div class="col-sm-12" id="form_container">
			<h3 class="text-center">Upload Your Documents (<?php echo $get_person[0]['fname'] ." ". $get_person[0]['lname']; ?>)</h3>
			<form id="msform" method="post" enctype="multipart/form-data">
				<table class="table table-bordered">
					<thead>
								<tr>
								  <th scope="col" colspan="8" class="text-center">Personal Info <sup style="color:red;">*</sup></th>
								</tr>
							  </thead>
					<thead style="
					    background: skyblue;
					    color: #495057;
					    vertical-align: middle!important;
					">
					  <tr>
						<th>Description</th>
						<th>Uploaded File</th>
						<th>Action</th>
					  </tr>
					</thead>
					<tbody>

						<tr>
							<td>
								<label>Photograph</label>
							</td>
							<td>
								<input type="hidden" name="user_office_id" class="exam" value="<?php echo $user_office_id; ?>" >
							<?php if(!empty($get_person[0]['photo'])) { ?>
							<img src="<?php echo base_url()."uploads/photo/".$get_person[0]['photo'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
							</td>
							<td>
								<input type="file" name="photo" class="form-control" placeholder="" id="photofile"  accept=".pdf,image/*">
							</td>
					  	</tr>

					  	<tr>
					  		<td>
								<label>National ID/Passport</label>
							</td>

							<td>
								<?php if (!empty($get_person[0]['attachment_adhar'])) {
								$directory_check = "candidate_national_id";
								$file_url = base_url() ."/uploads/candidate_national_id/" .$get_person[0]['attachment_adhar'];
								$icon_url = getIconUrl($get_person[0]['attachment_adhar'], $directory_check);  ?>
								 
								<a href="<?php echo base_url()."uploads/candidate_national_id/".$get_person[0]['attachment_adhar'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_adhar']; ?> </a>
							<?php  } else{
								echo "No File Uploaded";
							} ?>
							</td>
							<td>
								<input type="file" name="adhar" class="form-control" placeholder="" id="adhar" accept=".pdf,image/*" required="">
								<!-- <input type="file" name="national_id" class="form-control" placeholder="" id="national_id" accept=".pdf,image/*" required=""> -->
							</td>
						
					 	</tr>

					  	<!-- <tr>
					  		<td>
								<label>AFP Information</label>
							</td>

							<td>
								<?php if (!empty($get_person[0]['attachment_adhar'])) {
								$directory_check = "candidate_aadhar";
								$file_url = base_url() ."/uploads/candidate_aadhar/" .$get_person[0]['attachment_adhar'];
								$icon_url = getIconUrl($get_person[0]['attachment_adhar'], $directory_check);  ?>
								 
								<a href="<?php echo base_url()."uploads/candidate_aadhar/".$get_person[0]['attachment_adhar'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_adhar']; ?> </a>
							<?php  } else{
								echo "No File Uploaded";
							} ?></td>
							<td>
								<input type="file" name="adhar" class="form-control" placeholder="" id="adharfile" required="" accept=".doc,.docx,.pdf,image/*">
							</td>
						
					 	</tr>
 -->
						  <tr>
							<td>
								<label>NIT</label>
							</td>
							<td>
								<?php if(!empty($get_person[0]['attachment_pan'])) { ?>
							<img src="<?php echo base_url()."uploads/pan/".$get_person[0]['attachment_pan'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
						</td>
							<td>
								<input type="file" name="pan" class="form-control" placeholder="" id="panfile" accept=".pdf,image/*">
								<input type="hidden" name="c_id" class="c_id" value="<?php echo $c_id;?>" >
							</td>
						  </tr>


					
					<tr>
							<td>	
								<label>ISSS Information</label>
							</td>
							<td>

								<?php if (!empty($get_person[0]['attachment_health_insurence'])) {
								$directory_check = "candidate_insurence";
								$file_url = base_url() ."/uploads/" .$directory_check ."/" .$get_person[0]['attachment_health_insurence'];
								$icon_url = getIconUrl($get_person[0]['attachment_health_insurence'], $directory_check);  ?>
								<a href="<?php echo base_url()."uploads/candidate_insurence/".$get_person[0]['attachment_health_insurence'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_health_insurence']; ?> </a>
							<?php  } 
							else{
								echo "No File Uploaded";
							} ?>
						</td>
							<td>
								<input type="file" name="health" class="form-control" placeholder="" id="healthfile" accept=".pdf,image/*" >
							</td>
					</tr>

					<tr>
				  		<td>
							<label>Local background (30 days)</label>
						</td>

						<td>
							<?php if (!empty($get_person[0]['attachment_local_background'])) {
							$directory_check = "candidate_local_background";
							$file_url = base_url() ."/uploads/candidate_local_background/" .$get_person[0]['attachment_local_background'];
							$icon_url = getIconUrl($get_person[0]['attachment_local_background'], $directory_check);  ?>
							 
							<a href="<?php echo base_url()."uploads/candidate_local_background/".$get_person[0]['attachment_local_background'] ?>" target="_blank">
							<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_local_background']; ?> </a>
						<?php  } else{
							echo "No File Uploaded";
						} ?>
						</td>
						<td>
							<input type="file" name="local_background" class="form-control" placeholder="" id="local_background" accept=".pdf,image/*">
						</td>
					
				 	</tr>

				 	<tr>
				  		<td>
							<label>Resume</label>
						</td>

						<td>
							<?php if (!empty($get_person[0]['attachment'])) {
							$directory_check = "candidate_resume";
							$file_url = base_url() ."/uploads/candidate_resume/" .$get_person[0]['attachment'];
							$icon_url = getIconUrl($get_person[0]['attachment'], $directory_check);  ?>
							 
							<a href="<?php echo base_url()."uploads/candidate_resume/".$get_person[0]['attachment'] ?>" target="_blank">
							<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment']; ?> </a>
						<?php  } else{
							echo "No File Uploaded";
						} ?>
						</td>
						<td>
							<input type="file" name="file_upload" class="form-control" placeholder="" id="file_upload" accept=".doc,.docx,.pdf,image/*">
						</td>
					
				 	</tr>


					

					  
					<!--<tr>
						<td>
						<label>Covid-19 Declaration</label>
						</td>
						<td>
						<input type="file" name="covid" class="form-control" placeholder="" id="covid">
						</td>
					</tr>-->


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
							  	<td>Action</td>
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
							  		<?php if(!empty($value['education_doc'])) {
									$directory_check = "education_doc";
									$file_url = base_url() ."/uploads/" .$directory_check ."/" .$value['education_doc'];
									$icon_url = getIconUrl($value['education_doc'], $directory_check); 
									 ?>
								  	<a href="<?php echo base_url()."uploads/education_doc/".$value['education_doc']?>" target="_blank">
								  	 <img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $value['education_doc']; ?> </a>
							  	<?php }
							  	else{
									  		echo "No File Uploaded";
									  	} ?></td>
							  	<td class="file_uploader_education" data-id="1">
									Upload Your Document PDF &amp; Image Files Only
									<input type="file" name="edu[]" accept=".doc,.docx,.pdf,image/*" required id="edufile">
								</td>
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
							  	<td>Action</td>
							  </tr>
							  <?php foreach ($get_exp as $key => $value): ?>
							  		<tr>
									  	<th scope="row"><?php echo $key+1; ?></th>
									  	<td><?php echo $value['company_name']; ?></td>
									  	<input type="hidden" name="company_name[]" class="company_name" value="<?php echo $value['company_name']; ?>" >
									  	<td>
									  		<?php
									  		if(!empty($value['experience_doc'])) {
											$directory_check = "experience_doc";
											$file_url = base_url() ."/uploads/" .$directory_check ."/" .$value['experience_doc'];
											$icon_url = getIconUrl($value['experience_doc'], $directory_check); 
											?>
									  		<a href="<?php echo base_url()."uploads/experience_doc/".$value['experience_doc']?>" target="_blank"> 
									  		<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $value['experience_doc']; ?></a>
									  	<?php  }  else{
									  		echo "No File Uploaded";
									  	} ?></td>
									  	<td class="file_uploader" data-id="1">
								  			<div class="form-group">
															Upload Your Document PDF &amp; Image Files Only
													
															<input type="file" name="exp[]" accept=".doc,.docx,.pdf,image/*" required id="expfile">
											</div>
										</td>
									</tr>
							  <?php endforeach ?>
							  							  

						</tbody>
					</table>
				<?php } ?>

					<div class="form-group">
							<label for="basic-url">Type The Below Text (Case Sensitive):</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="captcha_image"><?php echo $captcha['image']?></span>
								</div>
								<input type="text" class="form-control required" id="basic-url" name="captcha" aria-describedby="basic-addon3" style="border-radius: .25rem;" required="">
								
							</div>
					</div>

											
				 <button type="button" id="reload_captcha" style="float:left;" class="btn btn-primary">Reload</button>
					
				<button type="submit" class="btn btn-success">Submit</button>
					
				  <br><br><br><br><br>
			</form>			
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


		<script>
			$(document).on('submit','#msform',function(e)
			{ 
				showPleaseWait();
				e.preventDefault();
					var datas = $(this).serializeArray();
					//console.log(datas);
					$.ajax({
						type	:	'POST',
						url		:	'<?php echo base_url('Documentuploadlink/process_upload'); ?>',
						data:  new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						success	:	function(msg){
									hidePleaseWait();
									var msg = JSON.parse(msg);
									if(msg.error == 'false')
									{
										$('#form_container').addClass('text-center card');
										$('#form_container').attr("style", "border: 1px solid; padding-top: 32px; padding-bottom: 32px;");
										$('.wide').attr("style", "width: 100%;margin-left: 0%;");
										$('#form_container').html('<h4>Thank You, You Have Successfully Uploaded your Documents</h4>');
										// window.location.reload();	
									}
									else if(msg.error == 'file_error')
									{
										alert('Unable to Upload File. Plase Re-Upload It.');
									}
									else if(msg.error == 'cap_error')
									{
										alert('Wrong Captcha Entered');
									}
									
								}
					});
				
			});
		</script>
<script type="text/javascript">


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
	
$('#panfile').change(function () {
    	var uploadpath = $('#panfile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png" || fileExtension == "pdf") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $('#panfile').val('');
	        return false;
	    }
});

$('#photofile').change(function () {
    	var uploadpath = $('#photofile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png" || fileExtension == "pdf") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $('#photofile').val('');
	        return false;
	    }
});

$('#adharfile').change(function () {
    	var uploadpath = $('#adharfile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $('#adharfile').val('');
	        return false;
	    }
});

$('#expfile').change(function () {
    	var uploadpath = $('#expfile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $('#expfile').val('');
	        return false;
	    }
});

$('#healthfile').change(function () {
    	var uploadpath = $('#healthfile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $('#healthfile').val('');
	        return false;
	    }
});

$('#edufile').change(function () {
    	var uploadpath = $('#edufile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
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
</script>

</body>