
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
						  //echo '<pre>';print_r($c_data);
						 // echo "</pre>";
							if($error!='') echo $error;
						?>
						
						<form action="<?php echo base_url()."diy/approve/$c_id" ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" id="c_id" name="c_id" value="<?php echo $c_id; ?>">
							
							
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="name">First Name</label>
										<input type="text" class="form-control" id="fname" placeholder="First Name" name="fname"  value="<?php echo $c_data['fname']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="name">Last Name</label>
										<input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname"  value="<?php echo $c_data['lname']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="blood_group">Gender</label>
										<input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname"  value="<?php echo $c_data['sex']; ?>" readonly>
											
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="blood_group">Role</label>
										<input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname"  value="<?php echo $c_data['role']; ?>" readonly>
											
									</div>
								</div>
								
							</div>
							
							<div class="row">
								
									<div class="col-md-4">
									<div class="form-group">
										<label for="blood_group">Category</label>
										<input type="text" class="form-control" value='<?php echo $c_data['course']; ?>' autocomplete="off" readonly >
									</div>
								</div>
								

							<div class="col-md-4">
									<div class="form-group">
										<label for="dob">Date Of Birth:</label>
										<input type="text" class="form-control" id="dob" value='<?php echo $c_data['dob']; ?>' name="dob" autocomplete="off" readonly >
									</div>								
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="name">Email ID:</label>
										<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error="Invalid email address" class="form-control email" id="email_id_per" placeholder="Email ID Personal" name="email_id_per"  value="<?php echo $c_data['email_id']; ?>" readonly>
									</div>
								</div>
							</div>

							
								<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">Country:</label>
										<input type="text" class="form-control" id="dob" value='<?php echo $c_data['country'] ?>' name="dob" autocomplete="off" readonly >
										<input type="hidden" name="" id="country_id" value="<?php echo $c_data['country_id'] ?>">
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
										<input type="number" class="form-control" id="mobile" name="diy_mobile" min="10"  value='<?php echo $c_data['mobile']; ?>' readonly>
										</div>
									</div>
								</div>
								<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">Payout Currency:</label>
										<select class="form-control" name="diy_payout_currency" id="diy_payout_currency">
											<option>-Select-</option>
											<?php foreach($currency as $token){ ?>
												<option value="<?php echo $token->id; ?>" <?php if($token->id == $c_data['payout_currency']) echo 'selected'; ?>><?php echo $token->name; ?></option>
												<?php } ?>
											<!-- <?php foreach($currency as $cnt): ?>
												<option value="<?php echo $cnt->abbr ?>"><?php echo $cnt->abbr ?></option>
											<?php endforeach; ?> -->							
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="password">Per Hour Rate:</label>
										<input type="number" class="form-control" id="PHR" placeholder="Per Hour Rate" data-error="Invalid Per Hour Rate" name="diy_PHR" min="2" value="<?php echo $c_data['PHR']; ?>">
									</div>
								</div>
								
								</div>
								<div class="row NonIndian_details" style="display: none;">
								<div class="col-md-6">
									<div class="form-group">
										<label for="password">IBAN/SWIFT CODE/SORT CODE:</label>
										<input type="number" class="form-control" id="diy_IBAN" placeholder="IBAN/SWIFT CODE/SORT CODE" data-error="Invalid IBAN/SWIFT CODE/SORT CODE" name="diy_IBAN" min="2" value="<?php echo $c_data['IBAN']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="password">Tax ID Number / SSN:</label>
										<input type="number" class="form-control" id="diy_TIN" placeholder="Invalid Tax ID Number" data-error="Invalid Tax ID Number" name="diy_TIN" min="2" value="<?php echo $c_data['TIN']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-3" style="text-align: center;">
									<div class="form-group">
										<label for="password" style="margin-top: 25px;">Tax ID:</label>
										<?php $tax = $c_data["pan_card_pic"]; if($tax != "") { ?><a class="btn btn-success" href="<?php echo base_url("kyt/diytid/$tax") ?>" target="_blank">View File</a>
										<?php }else{
											echo"No File Uploaded";
										} ?>
										</div>
									</div>
								</div>
								<div class="row Indian_details" style="display: none;">

									<div class="col-md-3">
										<div class="form-group">
											<label for="pan">Pan Number:</label>
											<input type="text" class="form-control" id="pan" name="diy_pan" value="<?php echo $c_data['pan']; ?>" readonly>
										</div>
									</div>

									<div class="col-md-6" style="text-align: center;">
										<div class="form-group">
											<label for="account" style="margin-top: 25px;">Pan Card:</label>
											<?php $pan = $c_data["personal_pic"]; if($pan != "") { ?>
											<a class="btn btn-success" href="<?php echo base_url("kyt/diyPic/$pan") ?>" target="_blank">View File</a>
											<?php }else{
											echo"No File Uploaded";
										} ?>
										</div>
									</div>
									
									<div class="col-md-3">
									<div class="form-group">
										<label for="password">IFSC CODE:</label>
										<input type="text" class="form-control" id="diy_IFSC" value="<?php echo $c_data['IFSC']; ?>" readonly name="diy_IFSC">
										</div>
									</div>
									</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="account">Bank Name:</label>
											<input type="text" class="form-control email" id="bank_name" value="<?php echo $c_data['bank_name']; ?>" readonly name="diy_bank_name">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="account">Account Number:</label>
											<input type="number" class="form-control" id="account_num" name="diy_account_num" value="<?php echo $c_data['account_num']; ?>" readonly>
										</div>
									</div>
									
									<div class="col-md-3">
										<div class="form-group">
											<label for="account">Account Name:</label>
											<input type="text" value="<?php echo $c_data['account_name']; ?>" readonly class="form-control email" id="account_name" name="diy_account_name">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="pan">Bank Address:</label>
											<input type="text" class="form-control" id="bank_add" name="diy_bank_add" value="<?php echo $c_data['bank_add']; ?>" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="phone">GMT Time Zone:</label>
											<input type="text" class="form-control" value="<?php echo $c_data['gmt']; ?>" readonly>
										</div>
									</div>
									<div class="col-md-6" style="text-align: center;">
										<div class="form-group">
											<label for="account" style="margin-top: 25px;">Goverment Issued Photo ID:</label>
											<?php $govt = $c_data["security_doc"]; if($govt !="") { ?><a class="btn btn-success" href="<?php echo base_url("kyt/diy/$govt") ?>" target="_blank">View File</a>
										<?php }else{
											echo"No File Uploaded";
										} ?>
										</div>
									</div>
								</div>

								<br><br>
														
							
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success">Approve</button> 
								<button class="btn btn-success send_link">Re-send Link</button>
					
				  
							</div>
							<br><br><br><br><br>
							
						</form>
			
			        </div>
		</div><!-- .row -->

	</section>
	
</div><!-- .wrap -->
<script type="text/javascript">
	var client_id=$('#country_id').val();
	if(client_id==101){
	    $(".NonIndian_details").css("display", "none");
	    $(".Indian_details").css("display", "block");
	}else if(client_id==0){
	    $(".Indian_details").css("display", "none");
	   	$(".NonIndian_details").css("display", "none");
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
</script>

<script>

$(document).on('click','.send_link',function(e)
			{ 
				e.preventDefault();
				// alert('hi');

				// showPleaseWait();
				
					var email = $('#email_id_per').val();
					var fname = $('#fname').val();
					var lname = $('#lname').val();
					var c_id = $('#c_id').val();
					// var datas = {'email':email};
					//console.log(datas);
					$.ajax({
						type	:	'POST',
						url		:	'<?php echo base_url('diy/send_diy_add_link'); ?>',
						data:'email='+ email+'&fname='+fname+'&lname='+lname+'&c_id='+c_id,
						success	:	function(msg){
									
										alert('link Sent.');
									}
					});
				
			});
</script>
