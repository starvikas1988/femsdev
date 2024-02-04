<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title>

	<link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">

  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous"> -->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/date-picker.css">  
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/linkcustom.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.min.css">

  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet"> -->


</head>
<body>
<style>
	.modal-dialog{
		width:800px;
	}
	/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
.add-regisnation {
	width:100%;
}
.add-regisnation .wrap {
	width:100%;
	padding:0 25px;
}
.add-regisnation .widget-separator {
	display:none;
}
.gj-textbox-md {
	border-bottom:none;
}
#dob{
background-color: #fff !important;
}
.add-regisnation .form-control {
	transition:all 0.5s ease-in-out 0s;
	height:auto;
	height:40px;
}
.add-regisnation .form-control:hover {
	transition:all 0.5s ease-in-out 0s;
	border:1px solid #3053dc;
}
.add-regisnation .form-control:focus {	
	border:1px solid #3053dc;
	outline:none;
	box-shadow:none;
}
.add-regisnation i {
	font-size:14px;
	color:rgba(0,0,0,0.5);
}
.add-regisnation .gj-datepicker-md {
	border:1px solid #ccc;	
}
.add-regisnation .gj-datepicker-md [role=right-icon] {
	right: 10px;
    top: 11px;
    font-size: 16px;	
}
.add-regisnation .select2-selection {
	transition:all 0.5s ease-in-out 0s;
	height:auto;
	padding:4px;
}
.add-regisnation .select2-selection:hover {
	transition:all 0.5s ease-in-out 0s;
	border:1px solid #3053dc;
}
.add-regisnation .select2-selection:focus {	
	border:1px solid #3053dc;
	outline:none;
	box-shadow:none;
}
.add-regisnation .btn {
	width:200px;
	max-width:100%;
	padding:10px;
	border:1px solid #3053dc;
	background:#3053dc;
	font-weight:bold;
	border-radius:5px;
	margin:10px 0 0 0;
	transition:all 0.5s ease-in-out 0s;
}
.add-regisnation .btn:hover {
	background:#0d2999;
	border:1px solid #3053dc;
}
.add-regisnation .btn:focus {
	background:#0d2999;
	outline:none;
	box-shadow:none;
	border:1px solid #3053dc;
}
.add-regisnation .top-main {
	background:#fff;
	border-bottom:none;
}
.add-regisnation ::-webkit-input-placeholder {
  color: rgba(0,0,0,0.5);
  font-size:14px;
  letter-spacing:0.5px;
}
.add-regisnation ::-moz-placeholder {
  color: rgba(0,0,0,0.5);
  font-size:14px;
  letter-spacing:0.5px;
}
.add-regisnation :-ms-input-placeholder {
  color: rgba(0,0,0,0.5);
  font-size:14px;
  letter-spacing:0.5px;
}
.add-regisnation :-moz-placeholder {
  color: rgba(0,0,0,0.5);
  font-size:14px;
  letter-spacing:0.5px;
}
.add-regisnation .top-main {
	background:#ffffff;
	margin:0 0 25px 0;
}
.add-regisnation .logo {
	height:50px;
	margin:0 0 5px 0;
}
</style>
	<div class="add-regisnation">
<div class="container" style="background: #fff;box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);padding:0;">
<div class="top-main">
		<div class="row">
			<div class="col-sm-4">
				<div class="body-widget">
					<img src="<?php echo base_url(); ?>assets/images/diy_logo.jpg" class="logo" alt="">
				</div>
			</div>
		</div>	
	</div>
<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12" id="form_container">
				<div class="widget">
					<!-- <header class="widget-header">
						<h4 class="widget-title">Register</h4>
					</header> -->
					<hr class="widget-separator"/>
					<div class="widget-body clearfix">
						
						<?php 
						// print_r($c_data); exit;
							if($error!='') echo $error;
						?>
						
						<form class="myform" method="post" enctype="multipart/form-data">
							<input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
							
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="name">First Name</label>
										<input type="text" class="form-control" id="fname" placeholder="First Name" name="fname" required value="<?php echo $c_data['fname']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="name">Last Name</label>
										<input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname" required value="<?php echo $c_data['lname']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="blood_group">Gender</label>
											<select class="form-control" id="sex" name="sex" required>
												<option value="">--select--</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
												<option value="Others">Others</option>
											</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="blood_group">Role</label>
											<select class="form-control" id="role" name="role" required>
												<option value="">--Select--</option>
												<?php foreach($role as $token){ ?>
												<option value="<?php echo $token->name; ?>"><?php echo $token->name; ?></option>
												<?php } ?>
											</select>
									</div>
								</div>
								
							</div>
							
							<div class="row">
								
									<!--<div class="col-md-4">
									<div class="form-group">
										<label for="blood_group">Select <?php echo  ($ClientName=="kyt")?"Course":"Category" ?></label>
											<select style="width:100%" class="form-control" id="client_course" name="client_course[]" multiple <?php echo $req; ?>>
												<option value="">--Select Course--</option>
												<?php foreach($courses_list as $token){ ?>
												<option value="<?php echo $token['id']; ?>"><?php echo $token['name']; ?></option>
												<?php } ?>
											</select>
									</div>
								</div>-->
								

							<div class="col-md-6">
									<div class="form-group">
										<label for="dob">Date Of Birth:</label>
										<input type="text" class="form-control" id="dob" value='' name="dob" autocomplete="off" readonly >
									</div>								
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="name">Email ID:</label>
										<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error="Invalid email address" class="form-control email" id="email_id_per" placeholder="Email ID Personal" name="email_id_per" required value="<?php echo $c_data['email_id']; ?>" readonly>
									</div>
								</div>
							</div>

							<?php //////////////////////////////////////////////////////////////////////////////////////// ?>
							<?php 
								if($ClientName=="diy"){ 
								$req=($ClientName=="diy")?"required":"";
							?>
								<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">Country:</label>
										<select class="form-control" name="diy_country" id="country_id" <?php echo $req; ?>>
											<option>-Select-</option>
											<?php foreach($countries as $cnt): ?>
												<option value="<?php echo $cnt->id ?>"><?php echo $cnt->name ?></option>
											<?php endforeach; ?>							
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="countryCode">Country Code:</label>
										<input type="text" class="form-control" id="countryCode" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="phone">Mobile No:</label>
										<input type="number" pattern="[1-9]{1}[0-9]{9}" class="form-control" id="mobile" placeholder="Mobile No" name="diy_mobile" min="10" <?php echo $req; ?>>
										</div>
									</div>
								</div>
								<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="name">Payout Currency:</label>
										<select class="form-control" name="diy_payout_currency" id="diy_payout_currency">
											<option>-Select-</option>
											<?php foreach($currency as $token){ ?>
												<option value="<?php echo $token->id; ?>"><?php echo $token->name; ?></option>
												<?php } ?>
											<!-- <?php foreach($currency as $cnt): ?>
												<option value="<?php echo $cnt->abbr ?>"><?php echo $cnt->abbr ?></option>
											<?php endforeach; ?> -->							
										</select>
									</div>
								</div>
								<!--<div class="col-md-6">
									<div class="form-group">
										<label for="password">Per Hour Rate:</label>
										<input type="number" class="form-control" id="PHR" placeholder="Per Hour Rate" data-error="Invalid Per Hour Rate" name="diy_PHR" <?php echo $req; ?> min="2">
									</div>
								</div>-->
								
								</div>
								<div class="row NonIndian_details" style="display: none;">
								<div class="col-md-6">
									<div class="form-group">
										<label for="password">IBAN/SWIFT CODE/SORT CODE:</label>
										<input class="form-control" id="diy_IBAN" placeholder="IBAN/SWIFT CODE/SORT CODE" data-error="Invalid IBAN/SWIFT CODE/SORT CODE" name="diy_IBAN" min="2">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="password">Tax ID Number / SSN:</label>
										<input type="number" class="form-control" id="diy_TIN" placeholder="Invalid Tax ID Number" data-error="Invalid Tax ID Number" name="diy_TIN" min="2">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="password">Tax ID:</label>
										<input type="file" class="form-control" id="diy_tid" placeholder="Tax Id" data-error="Invalid Tax ID" name="attach_file_photo_tid[]" accept="image/*">
										</div>
									</div>
								</div>
								<div class="row Indian_details" style="display: none;">
									<div class="col-md-4">
										<div class="form-group">
											<label for="pan">Pan Number:</label>
											<input type="text" class="form-control" id="pan" placeholder="Pan For New User" name="diy_pan" data-error="Invalid PAN Details">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="account">Pan Card:</label>
											<input type="file" data-error="Invalid Account Details" class="form-control security_doc" id="personal_doc" multiple  name="attach_file_photo[]" accept="image/*">
										</div>
									</div>
									<div class="col-md-4">
									<div class="form-group">
										<label for="password">IFSC CODE:</label>
										<input type="text" class="form-control" id="diy_IFSC" placeholder="Per IFSC CODE" data-error="Invalid Per Hour Rate" name="diy_IFSC">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="account">Bank Name:</label>
											<input type="text" data-error="Invalid Bank Name" class="form-control email" id="bank_name" placeholder="Bank Name" name="diy_bank_name" <?php echo $req; ?>>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="account">Account Number:</label>
											<input type="number" data-error="Invalid Account Details" class="form-control email" id="account_num" placeholder="Account Number" name="diy_account_num" <?php echo $req; ?>>
										</div>
									</div>
									
									<div class="col-md-3">
										<div class="form-group">
											<label for="account">Account Name:</label>
											<input type="text"  data-error="Invalid Account Details" class="form-control email" id="account_name" placeholder="Account Name" name="diy_account_name" <?php echo $req; ?>>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="pan">Bank Address:</label>
											<input type="text"  class="form-control" id="bank_add" placeholder="Bank Address" name="diy_bank_add" data-error="Invalid Bank Address Details" <?php echo $req; ?>>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="phone">GMT Time Zone:</label>
											<select class="form-control" name="TimeZone" id="TimeZone" <?php echo $req; ?>>
												<option value="">-Select-</option>
												<?php foreach($GMT_timezone as $client): ?>
												<option value="<?php echo $client['GMT_offset']."#".$client['id'] ?>"><?php echo $client['gmtCountryName'] ?></option>
											<?php endforeach; ?>
													
										</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="account">Goverment Issued Photo ID:</label>
											<input type="file" data-error="Invalid Account Details" class="form-control security_doc" id="security_doc" multiple  name="attach_file[]" accept=".pdf,image/*" required="required ">
										</div>
									</div>
								</div>
								<?php } ?>
														
							
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success">Submit</button>
					
				  
							</div>
							<br><br><br><br><br>
							
						</form>
			
			        </div>
		</div><!-- .row -->

	</section>
		</div>

		<div class="wrap p-t-0">
		<footer class="app-footer">
			<div class="clearfix">
				<!--<ul class="footer-menu pull-right">
					<li><a href="javascript:void(0)">Careers</a></li>
					<li><a href="javascript:void(0)">Privacy Policy</a></li>
					<li><a href="javascript:void(0)">Feedback <i class="fa fa-angle-up m-l-md"></i></a></li>
				</ul>-->
				<div class="copyright pull-left">&copy; <?php echo date("Y");?> Omind Technologies</div>
			</div>
		</footer>
	</div>
</div><!-- .wrap -->

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
	<script src="<?php echo base_url() ?>libs/bower/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/select2.full.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/date-picker.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script> -->




		<script>


			$(document).on('submit','form.myform',function(e)
			{ 
				e.preventDefault();
				// alert('hi');

				showPleaseWait();
				
				
					var datas = $(this).serializeArray();
					//console.log(datas);
					$.ajax({
						type	:	'POST',
						url		:	'<?php echo base_url('diy/process_upload'); ?>',
						data:  new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						success	:	function(msg){
									hidePleaseWait();
									// console.log(msg);
									var msg = JSON.parse(msg);
									if(msg.error == 'false')
									{
										$('#form_container').addClass('text-center card');
										$('#form_container').attr("style", "border: 1px solid; padding-top: 32px; padding-bottom: 32px;");
										$('.wide').attr("style", "width: 100%;margin-left: 0%;");
										$('#form_container').html('<h4>Thank You, You Have Successfully Submitted your Details</h4>');
										// window.location.reload();	
									}
									else if(msg.error == 'file_error')
									{
										alert('Unable to Upload File. Plase Re-Upload It.');
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



$(document).ready(function(){




	$('#diy_tid,#personal_doc').change(function () {
    	var uploadpath = $(this).val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg or png files");
	        $(this).val('');
	        return false;
	    }
});

	$('#security_doc').change(function () {
    	var uploadpath = $(this).val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $(this).val('');
	        return false;
	    }
});


	

	$("#dept_id").on('change', function() {
		var x = $(this).val();
		if(x==7 || x==9){
			$("#client_id").val(0).trigger('change');
		}	
	});	
	
	
	$('#uan_no,#existing_uan').hide();
	$('#esi_no,#existing_esi').hide();

	$('#role').on('change', function(){
		var selectValue = $(this).val();
		if(selectValue=='consultant'){
			$('#client_id, #process_id').prop('disabled', true);
			$("#client_div, #process_div").hide('slow');
		}else{
			$('#client_id, #process_id').prop('disabled', false);
			$("#client_div, #process_div").show('slow');
		}
	});

	$('#edrole').on('change', function(){
		var selectValue = $(this).val();
		if(selectValue=='consultant'){
			$('#edclient_id, #edprocess_id').prop('disabled', true);
			$("#client_div, #process_div").hide('slow');
		}else{
			$('#edclient_id, #edprocess_id').prop('disabled', false);
			$("#client_div, #process_div").show('slow');
		}
	});
	

	
	
	$("#office_id").change(function(){
					
		$("#client_id").val('');
		$("#role_id").val('');
		$("#site_id").val('');
		
		$("#site_div").hide();
		$('#site_id').removeAttr('required');
			
		var off_id=$(this).val();
		if(off_id=='KOL'){
			$('#xpoid').attr("required", "true");
		}else{
			$('#xpoid').removeAttr("required");
		}
		
		if(off_id=='BLR' || off_id=='HWH' || off_id=='KOL'){
			$('#uan_no,#existing_uan').show();
			$('#esi_no,#existing_esi').show();
			$('#uan_no').prop('disabled', false);
			$('#esi_no').prop('disabled', false);
		}else{
			$('#uan_no,#existing_uan').hide();
			$('#esi_no,#existing_esi').hide();
			$('#uan_no').prop('disabled', true);
			$('#esi_no').prop('disabled', true);
		}
		
	});
	
	$("#client_id").change(function(){
		var client_id=$(this).val();
		
		var URL='<?php echo base_url();?>/user/select_process';
		
		$.ajax({
		   type: 'GET',    
		   url:URL,
		   data:'client_id='+client_id,
		    success: function(data){
			  
			  
			  var a = JSON.parse(data);
			  //var mySelect = $('#process_id');
			  $("#process_id").empty();
			  
				$.each(a, function(index,jsonObject){
					 $("select#process_id").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
				});	
			},
			error: function(){	
				alert('error!');
			}
		  });
		
	});
	
	$("#edclient_id").change(function(){
		var client_id=$(this).val();
		
		var URL='<?php echo base_url();?>/user/select_process';
		
		$.ajax({
		   type: 'GET',    
		   url:URL,
		   data:'client_id='+client_id,
		    success: function(data){
			  
			  
			  var a = JSON.parse(data);
			  //var mySelect = $('#process_id');
			  $("#edprocess_id").empty();
			  
				$.each(a, function(index,jsonObject){
					 $("select#edprocess_id").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
				});	
			},
			error: function(){	
				alert('error!');
			}
		  });
		
	});

	$("#country_id").change(function(){
		var client_id=$(this).val();
		if(client_id==101){
		    $(".NonIndian_details").css("display", "none");
		    $(".Indian_details").css("display", "block");
		   }else{
		    $(".NonIndian_details").css("display", "block");
		    $(".Indian_details").css("display", "none");
		   }
		var URL='<?php echo base_url();?>/user/select_phoneCode';
		$.ajax({
		   type: 'GET',    
		   url:URL,
		   data:'phoneCode_id='+client_id,
		    success: function(data){
			  var a = JSON.parse(data);
  			  $("#countryCode").val(a.phonecode);
			},
			error: function(){	
				alert('error!');
			}
		  });
		
	});
	
	
	$("#dept_id").change(function(){
		
		var dept_id=$('#dept_id').val();
		populate_sub_dept_combo(dept_id);
		//$("#role_id").val('');
	});
	});


$(function(){
    
	var timeOffset="-300";
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
	
		
	/* global setting */
	/*
    var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        minDate   : "-2D"
    }
	*/
	 var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset
    }
	
	//$( "#doj" ).datepicker();
	$("#doj").datepicker($.extend({},datepickersOpt));
	$("#dob").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-70:c+0"});
	$("#eddob").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-70:c+0"});
	// $("#time_details").datepicker().timepicker();
	$("#client_id").select2();
	$("#process_id").select2();
	$("#office_id").select2();
	$("#client_course").select2();
	
	
	
}); 

function checkNum()
{

if ((event.keyCode > 64 && event.keyCode < 91) || (event.keyCode > 96 && event.keyCode < 123) || event.keyCode == 8)
   return true;
else
   {
       alert("Please enter only char");
       return false;
   }

}
function allowOnlyLetters(e, t)   
{    
   if (window.event)    
   {    
      var charCode = window.event.keyCode;    
   }    
   else if (e)   
   {    
      var charCode = e.which;    
   }    
   else { return true; }    
   if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))    
       return true;    
   else  
   {    
      alert("Please enter only alphabets"); 
      $('#account_name').val('Amit Debnath');   
      return false;    
   }           
} 
      
</script>





</body>
</html>