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
	.saq_input{
		width:95%; height:2.5rem; border:1px solid black; outline:none; padding-left:.5rem; border-radius:3px;
		background-color:transparent;
		}
	</style>
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
								<input type="file" value="<?= $get_person[0]['photo'] ?>" name="photo" class="form-control" placeholder="" id="photofile" required="" accept="image/*">
							</td>
					  	</tr>
					  	<tr>
					  		<td>
								<label>Aadhar Card / Social Security No</label>
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
							} ?>
							</td>
							<td>
								<input type="file" value="<?= $get_person[0]['attachment_adhar'] ?>" name="adhar" class="form-control" placeholder="" id="adharfile" required="" accept=".pdf,image/*">
							</td>
						
					 	</tr>

						  <tr>
							<td>
								<label class="pan">PAN Card(optional)</label>
								
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
								<input type="file" value="<?= $get_person[0]['attachment_pan'] ?>" name="pan" class="form-control" placeholder="" id="panfile" accept="image/*">
								<input type="hidden" name="c_id" class="c_id" value="<?php echo $c_id;?>" >
							</td>
						  </tr>
						  <!-- bank -->
						  
						  <tr>
							<td>
								<label class="pan">Passbook</label>
								
							</td>
							<td>
								<?php if(!empty($get_person[0]['attachment_bank'])) { ?>
							<img src="<?php echo base_url()."uploads/dfr_bank/".$get_person[0]['attachment_bank'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
							</td>
							<td>
								<input type="file" value="<?= $get_person[0]['attachment_bank'] ?>" name="bank" class="form-control" placeholder="" id="bankfile" accept="image/*">
								
							</td>
						  </tr>

						  

					  
					<!--<tr>
						<td>
						<label>Covid-19 Declaration</label>
						</td>
						<td>
						<input type="file" value="<?php $get_person[0][''] ?>" name="covid" class="form-control" placeholder="" id="covid">
						</td>
					</tr>-->
					

					</tbody>
				  </table>
				  
				  
				  
					<!--<div class="saq" style=" box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2), 0 3px 8px 0 rgba(0, 0, 0, 0.19); padding:.5rem;">
					<h5>Enter Your Bank Information</h5>
						<div class="bank_information" style="display:flex; padding: .21rem; margin: 2rem 0; flex-wrap:wrap;">
							
							<div class="b_i" style="width:33%; margin-top: .5rem;">
							<div class="label"><label>Bank Name</label></div>
							<div class="label"><input type="text" value="<?= isset($get_person[0]['bank_name']) ? $get_person[0]['bank_name'] : '' ?>" name="bank_name" id="bank_name" class="saq_input" required placeholder="Bank name"/></div>
							</div>
							<div class="b_i" style="width:33%; margin-top: .5rem;">
							<div class="label"><label>Branch Name</label></div>
							<div class="label"><input type="text" value="<?= isset($get_person[0]['branch_name']) ? $get_person[0]['branch_name'] : '' ?>" name="branch_name" id="branch_name" class="saq_input" required placeholder="Branch name"/></div>
							</div>
							<div class="b_i" style="width:33%; margin-top: .5rem;">
							<div class="label"><label>Account Type</label></div>
							<div class="label"><select name="acc_type" class="saq_input" required><option value="Savings">Saving</option><option value="Checking">Checking</option></select></div>
							</div>
							<div class="b_i" style="width:50%; margin-top: .5rem;">
							<div class="label"><label>Accound Number</label></div>
							<div class="label"><input type="text" value="<?= isset($get_person[0]['bank_acc_no']) ? $get_person[0]['bank_acc_no'] : '' ?>" name="bank_acc_no" id="bank_acc_no" class="saq_input" required placeholder="Account Number"/></div>
							</div>
							<div class="b_i" style="width:50%; margin-top: .5rem;">
							<div class="label"><label>IFSC Code</label></div>
							<div class="label"><input type="text"  value="<?= isset($get_person[0]['ifsc_code']) ? $get_person[0]['ifsc_code'] : '' ?>" name="ifsc_code" id="ifsc_code" class="saq_input" required placeholder="IFSC CODE"/></div>
							</div>
						</div>
						</div>-->
					
					
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
									<input type="file" value="<?= $get_edu[0]['education_doc'] ?>" name="edu[]" accept=".doc,.docx,.pdf,image/*" required id="edufile" class="edufile">
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
													
												<input type="file" value="<?= $get_exp[0]['experience_doc'] ?>" name="exp[]" accept=".doc,.docx,.pdf,image/*" required id="expfile" class="expfile">
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
													<input type="text" class="form-control required" id="basic-url" name="captcha" aria-describedby="basic-addon3" style="border-radius: .25rem;">
													<div class="input-group-append">
														<span class="input-group-text" style="cursor:pointer;" id="reload_captcha">Reload</span>
													</div>
												</div>
										</div>

											
				  <button type="submit" class="btn btn-block btn-info">Submit</button>
				  <br><br><br><br><br>
			</form>			
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


		<script>
			$(document).ready(function(){
				var phfile = $("#photofile").attr('value');
				if(phfile!==""){
					$("#photofile").removeAttr('required');
				}
				var phfile = $("#adharfile").attr('value');
				if(phfile!==""){
					$("#adharfile").removeAttr('required');
				}
				var phfile = $("#bankfile").attr('value');
				if(phfile!==""){
					$("#bankfile").removeAttr('required');
				}
				var phfile = $(".edufile").attr('value');
				if(phfile!==""){
					$(".edufile").removeAttr('required');
				}
				var phfile = $(".expfile").attr('value');
				if(phfile!==""){
					$(".expfile").removeAttr('required');
				}
			});

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

	    if (fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg or png files");
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
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
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
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
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