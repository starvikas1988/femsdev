<style>
	.prevAttachDiv {
		background-color: #f5f5f5;
		float: left;
		position: relative;
		height: auto;
		min-height: 70px;
		width: 100%;
		border: 1px solid #ccc;
		padding: 3px;
		z-index: 0;
	}

	.currAttachDiv {
		background-color: #f5f5f5;
		float: left;
		position: relative;
		height: auto;
		min-height: 70px;
		width: 100%;
		border: 1px solid #ccc;
		padding: 3px;
		z-index: 0;
		display: none;
	}

	.attachDiv {
		width: 30px;
		height: 30px;
		float: left;
		padding: 1px;
		border: 2px solid #ccc;
		margin: 5px;
		position: relative;
		cursor: pointer;
	}

	.attachDiv img {
		width: 100%;
		height: 100%;
		position: relative;
	}

	.deleteAttach {
		display: none;
		cursor: pointer;
		top: 0;
		right: 0;
		position: absolute;
		z-index: 99;
	}

	input[type="checkbox"] {
		width: 20px;
		height: 20px;
		vertical-align: bottom;
	}

	html,
	body {
		height: 100%;
	}

	.container {
		height: 100%;
		/*display: flex;*/
		justify-content: center;
		align-items: center;
	}
</style>
<?php
if (get_user_office_id() == "CHA") $compName = " CSPL ";
else $compName = " Fusion ";
?>
<div class="container">
	<section class="app-content top_1">
		<?php
		if (get_user_office_id() == "JAM" && $isUpdateHrInfo == "Y") {
		?>
			<div class="row" style='margin-bottom:0px;'>
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title">Basic Personal information</h4>
								</header><!-- .widget-header -->
								<hr class="widget-separator">
								<div class="widget-body">
									<center>
										<h4><span class='label label-info'>Please Update Date of birth & Gender.</span></h4>
										<div class="form-group" style='margin-top:10px;'>
											<form class="frmAddPerInfo" action="<?php echo base_url(); ?>profile/updateHRInfo" data-toggle="validator" method='POST'>
												<div class="row ">
													<div class="col-md-12">
														<div class="widget">
															<div class="widget-body clearfix">
																<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="dob"><span style='color:red;'>*</span>Date of birth (mm/dd/yyyy):</label>
																			<input type="text" class="form-control" id="dob" value='<?php echo mysql2mmddyy($hr_row['dob']); ?>' name="dob" autocomplete="off" required>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="sex"><span style='color:red;'>*</span>Gender</label>
																			<select class="form-control" id="sex" name="sex" required>
																				<option value="">--select--</option>
																				<option value="<?php echo $hr_row['sex']; ?>" Selected><?php echo $hr_row['sex']; ?></option>
																				<option value="Male">Male</option>
																				<option value="Female">Female</option>
																				<option value="Others">Others</option>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="row">
																	<div class="col-md-12" style="color:darkgreen;font-weight:bold;">
																		<input type="checkbox" id="is_correct_nos" name="is_correct_nos" value='1' required>
																		I certify that the Date of birth & Gender information provided by me is accurate. I will be responsible for any issue due to incorrect information.
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer1">
													<button type="submit" id='btnHRInfo' style='margin-top:5px;' class="btn btn-primary">Save Info</button>
												</div>
											</form>
										</div>
										<!--
							<div class="form-group" style='margin-top:20px;'>
								<a href="<?php //echo base_url(); 
											?>profile/personal">
								<button title="" type='button' class='btn btn-primary btn-s' data-toggle='modal'>Click Here To Update Your All Personal Info</button> <br>
								</a>
							</div>
							-->
									</center>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		if (get_user_office_id() == "JAM" && $isUpdateBasicInfo == "Y") {
		?>
			<div class="row" style='margin-bottom:0px;'>
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title">Basic Personal information</h4>
								</header><!-- .widget-header -->
								<hr class="widget-separator">
								<div class="widget-body">
									<center>
										<h4><span class='label label-info'>Please Update Your TRN & NIS.</span></h4>
										<div class="form-group" style='margin-top:2px;'>
											<form class="frmAddPerInfo" action="<?php echo base_url(); ?>profile/updateSocialInfo" data-toggle="validator" method='POST'>
												<div class="row">
													<div class="col-md-12">
														<div class="widget">
															<div class="widget-body clearfix">
																<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="pan_no"><span style='color:red;'>*</span>TRN:</label>
																			<input type="text" class="form-control" id="pan_no" value="<?php echo $personal_row['pan_no'] ?>" name="pan_no" required>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="social_security_no"><span style='color:red;'>*</span>NIS</label>
																			<input type="text" class="form-control" id="social_security_no" value='<?php echo $personal_row['social_security_no'] ?>' name="social_security_no" required>
																		</div>
																	</div>
																</div>
																<div class="row">
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="pan_no">Email ID (Personal):</label>
																			<input type="email" class="form-control" id="email_id_per" value='<?php echo $personal_row['email_id_per'] ?>' name="email_id_per">
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="pan_no">Email ID (Office):</label>
																			<input type="email" class="form-control" id="email_id_off" value='<?php echo $personal_row['email_id_off'] ?>' name="email_id_off">
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label for="social_security_no">Phone</label>
																			<input type="text" class="form-control" id="phone" value='<?php echo $personal_row['phone'] ?>' name="phone" onkeypress="return isNumber(event)">
																		</div>
																	</div>
																</div>
																<div class="row">
																	<div class="col-md-12" style="color:darkgreen;font-weight:bold;">
																		<input type="checkbox" id="is_correct_nos" name="is_correct_nos" value='1' required>
																		I certify that the TRN & NIS information provided by me is accurate. I will be responsible for any issue due to incorrect information.
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer1">
													<button type="submit" id='btnPerInfo' style='margin-top:5px; margin-left:80px;' class="btn btn-primary">Save Info</button>
													<a href="<?php echo base_url('home/skipPerInfo'); ?>">
														<button type="button" id='btnPerInfoSkip' style='margin-top:5px; float:right;' class="btn btn-danger">Skip Now</button>
													</a>
												</div>
											</form>
										</div>
										<!--
					<div class="form-group" style='margin-top:20px;'>
						<a href="<?php //echo base_url(); 
									?>profile/personal">
						<button title="" type='button' class='btn btn-primary btn-s' data-toggle='modal'>Click Here To Update Your All Personal Info</button> <br>
						</a>
					</div>
					-->
									</center>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		//if( $is_added_bank_details == 0 && $skipBankInfo!="Y"  ){
		if ($is_added_bank_details == 0 && $skipBankInfo != "Y"  && (isIndiaLocation(get_user_office_id()) == true || get_user_office_id() == "JAM")) {
		?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default" style='margin-top:2px;'>
						<div class="panel-body">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title">Pending Bank Detail</h4>
								</header><!-- .widget-header -->
								<hr class="widget-separator">
								<div class="widget-body">
									<center>
										<h4><span class='label label-info'>
												The salary will be processed as per the FEMS bank account detail.
											</span></h4>
										<?php if (isIndiaLocation(get_user_office_id()) == true) { ?>
											<h4><span class='label label-info'>
													If You Failed To Upload The Same In Next 7 Days Then Your Service Will Be Terminated Due To Non Submission Of Complete Documents.
												</span></h4>
										<?php } ?>
										<div class="form-group" style='margin-top:20px;'>
											<button title="" type='button' style='margin-left:80px;' class='addBankDetails btn btn-primary btn-s' data-toggle='modal' data-target='#addBankInfoModal'>Click Here To Add Your Bank Details</button>
											<a href="<?php echo base_url('home/skipBankInfo'); ?>">
												<button type="button" id='btnBankInfoSkip' style='float:right;' class="btn btn-danger">Skip Now</button>
											</a>
										</div>
									</center>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } else {
			//if( $bank_row['is_accept'] == 0 && $skipBankInfo!="Y"  ){
			if ($bank_row['is_accept'] == 0 && $skipBankInfo != "Y" && (isIndiaLocation(get_user_office_id()) == true || get_user_office_id() == "JAM")) {
			?>
				<div class="row">
					<!-- DataTable -->
					<div class="col-md-12">
						<div class="widget">
							<header class="widget-header">
								<h4 class="widget-title">Your Bank Detail</h4>
							</header><!-- .widget-header -->
							<hr class="widget-separator">
							<div class="widget-body">
								<center>
									<h4><span class='label label-info'> The salary will be processed as per the FEMS bank account detail.</span></h4>
									<h4><span class='label label-info'>Please Verify Your Bank Detals.</span></h4>
									<!--
						<h4><span class='label label-info'>N.B - This option is valid upto 26th May, after that no option will be available to make any change.</span></h4> 
						-->
									<br>
									<br>
									<div class="table-responsive">
										<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
											<thead>
												<tr class='bg-info'>
													<th>Bank Name</th>
													<th>Branch</th>
													<th>Account No</th>
													<th>Account Type</th>
													<th>IFSC Code</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$pDate = 0;
												$slno = 1;
												?>
												<tr>
													<td><?php echo $bank_row['bank_name']; ?></td>
													<td><?php echo $bank_row['branch']; ?></td>
													<td><?php echo $bank_row['acc_no']; ?></td>
													<td><?php echo $bank_row['acc_type']; ?></td>
													<td><?php echo $bank_row['ifsc_code']; ?></td>
													<td>
														<button title='Edit Bank Info' type='button' data-toggle='modal' data-target='#editBankInfoModal' class='btn btn-success btn-s'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<br>
									<form class="frmBankAccept" action="<?php echo base_url(); ?>profile/bankInfoAccept" data-toggle="validator" method='POST'>
										<input type="hidden" class="form-control" id="id" value='<? echo $bank_row['id']; ?>' name="id">
										<input type="hidden" class="form-control" id="user_id" value='<? echo $bank_row['user_id']; ?>' name="user_id">
										<input type="checkbox" id="is_accept" name="is_accept" required>
										I certify that the bank account information provided by me is accurate and salary can be processed through this account.<br>I will be responsible for any salary issue due to incorrect bank details.
										<div class="form-group" style='margin-top:20px;'>
											<button type="submit" id='btnEditBankPerInfo' class="btn btn-primary">Verify My Bank Details</button>
											<?php if ($bank_row['skip_cnt'] < 1) { ?>
												<a href="<?php echo base_url('home/SkipBankInfo/Y'); ?>">
													<button type="button" id='btnBankInfoVerifySkip' style='float:right;' class="btn btn-danger">Skip Now</button>
												</a>
												<br>
												<div style='float:right;'>
													You have Only <?php echo (1 - $bank_row['skip_cnt']) ?> More
												</div>
											<?php } ?>
										</div>
									</form>
								</center>
							</div><!-- .widget-body -->
						</div><!-- .widget -->
					</div>
					<!-- END DataTable -->
				</div><!-- .row -->
			<?php
			}
			//if($bank_row['is_acpt_document']==0 && $skipBankInfo!="Y" && isIndiaLocation(get_user_office_id())==true  && (get_role_dir()=="agent" || get_role_dir()=="tl") && ($gross_pay >0 && $gross_pay<21000)){
			//&& get_dept_id()=='6'
			?>
			<!--
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body">
					<center>
						<h4><span class='label label-info'>Your ESIC Registration would be done provided bank Account detail's(Cheque book/Passbook) picture where your name is printed</span></h4> </br>
						
						<form class="frmBankAccept" action="<?php echo base_url(); ?>profile/bankUploadInfoAccept" data-toggle="validator" method='POST' enctype="multipart/form-data">
												
							<input type="hidden" class="form-control" id="" value='<? echo $bank_row['id']; ?>' name="id" >
							<input type="hidden" class="form-control" id="" value='<? echo $bank_row['user_id']; ?>' name="uid" >
							
							<div class="row">
								<div class="col-md-5">
									<center>
									<?php if (!file_exists($BankRealPath)) {
										$req = "required";
									?>
										
										<div style="height:auto; width:70%; border:5px solid gray;">
											</br></br>
											Upload Your Bank Document
											</br></br></br>
										</div>
									
									<?php } else {
										$req = "";
									?>
										<div style="height:auto; width:70%; border:5px solid gray;">
										<a href= "<?php echo $BankImgURL; ?>" target="_blank" >
											<img src="<?php echo $BankImgURL; ?>"  >
										</a>
										</div>
										
									<?php } ?>
									
									
									</center>
								</div>
								<div class="col-md-6">
									<div class="btn btn-sm float-left" style="background-color:#73C6B6">
									
									<input type="file" class="filestyle" data-icon="false" accept=".jpg,.jpeg,.pdf" id="upl_bank_info" name="upl_bank_info[]" <?php echo $req; ?> >
									</div>
									
									<p style="color:red"><br/><b>NOTE :</b> Document Type .pdf, .jpg, .jpeg is only allowed. <br/>Maximum Size is 1MB for uploading documents.</p>
									
								</div>
								
								
							
							</div>
							
							<input type="checkbox" id="is_acpt_document" name="is_acpt_document" value="1" required>
							I certify that the uploaded photocopy of cheque book or passbook provided by me is accurate and salary can be processed through this account.<br>I will be responsible for any salary issue due to incorrect photocopy details.
							
							<div class="form-group" style='margin-top:20px;'>
								<button type="submit" id='btnBankUpl' class="btn btn-primary">Upload</button>
								
								<a href="<?php //echo base_url('home/skipBankInfo');
											?>">
								<button type="button" id='btnBankUploadInfoSkip' style='float:right;' class="btn btn-danger">Skip Now</button>
								</a>
								
							</div>
							
							<?php //if($this->input->get('errorupload')){ 
							?>
							<h4><span class='label label-danger'>ERROR : Document Uploaded exceeds maximum limit of file size 1MB</span></h4>
							<?php //} 
							?>
						
						</form>
					
					</center>
					</div>
				</div>
			</div>
		</div>
		-->
			<?php
			//}else 
			//echo $bank_row['is_acpt_document'] . ">> " . file_exists($BankRealPath) . " > ". $skipBankInfo ;
			if (($bank_row['is_acpt_document'] == 0 || !file_exists($BankRealPath)) && $skipBankInfo != "Y" && isIndiaLocation(get_user_office_id()) == true) {
			?>
				<div class="row">
					<div class="col-md-12">
						<div class="white_widget padding_3">
							<div class="widget-body no_padding">
								<p>
									<?php if (!file_exists($BankRealPath)) { ?>
										Upload Your Bank Document Which Should Have Your Name Printed (Pass Book/cheque Book/mobile Internet Banking Home Page)in Case if You Failed to Upload the Same in Next 7 Days Then Your Service Will Be Terminated Due to Non Submission of Complete Documents
									<?php } else { ?>
										Update Your Bank Document Which Should Have Your Name Printed (Pass Book/cheque Book/mobile Internet Banking Home Page) or Certify Your Existing Bank Document
									<?php } ?>
								</p>
								<hr class="sepration_border">
								<form class="frmBankAccept" action="<?php echo base_url(); ?>profile/bankUploadInfoAccept" data-toggle="validator" method='POST' enctype="multipart/form-data">
									<input type="hidden" class="form-control" id="" value='<? echo $bank_row['id']; ?>' name="id">
									<input type="hidden" class="form-control" id="" value='<? echo $bank_row['user_id']; ?>' name="uid">
									<div class="row form-group d_flex">
										<div class="col-md-5">

											<?php if (!file_exists($BankRealPath)) {
												$req = "required";
											?>
												<div style="height:100px; width:100%; border: 2px solid var(--bs-common-btn-border);justify-content: center;display:flex;align-items:center;">
													Upload Your Bank Document													
												</div>
											<?php } else {
												$req = "";
											?>
												<div style="height:auto; width:10%; border: 2px solid var(--bs-common-btn-border)">
													<a href="<?php echo $BankImgURL; ?>" target="_blank">
														<img src="<?php echo $BankImgURL; ?>">
													</a>
												</div>
											<?php } ?>
										</div>
										<div class="col-md-7">
											<div class="float-left form-group">
												<div class="file_upload_style">
													<input type="file" class="filestyle form-control" data-icon="false" accept=".jpg,.jpeg,.pdf" id="upl_bank_info" name="upl_bank_info[]" <?php echo $req; ?>>
												</div>
											</div>
											<!--<p style="color:red">Upload jpg, jpeg, png, pdf format only</p>-->
											<p class="red_bg"><b>NOTE :</b> Document Type .pdf, .jpg, .jpeg is only allowed. <br />Maximum Size is 1MB for uploading documents.</p>
										</div>
									</div>
									<input type="checkbox" id="is_acpt_document" name="is_acpt_document" value="1" required style="float: left;margin:0 10px 0 0;">
									I certify that the uploaded photocopy of cheque book or passbook provided by me is accurate and salary can be processed through this account. I will be responsible for any salary issue due to incorrect photocopy details.
									<div class="top_1">
										<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Upload</button>
										<a href="<?php echo base_url('home/skipBankInfo'); ?>">
											<button type="button" id='btnBankUploadInfoSkip' style='float:right;' class="btn btn_padding filter_btn save_common_btn">Skip Now</button>
										</a>
									</div>
									<?php if ($this->input->get('errorupload')) { ?>
										<h4><span class='label label-danger'>ERROR : Document Uploaded exceeds maximum limit of file size 1MB</span></h4>
									<?php } ?>
								</form>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			if (empty($document_row['aadhar_doc']) && isIndiaLocation(get_user_office_id()) == true  && (get_role_dir() == "agent" || get_role_dir() == "tl")) {
			?>
				<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-body">
								<center>
									<h4><span class='label label-info'><i class="fa fa-warning"></i> Please Upload your Adhaar Card</span></h4> </br>
									<form class="frmBankAccept" action="<?php echo base_url(); ?>profile/adhaarUploadDoc" data-toggle="validator" method='POST' enctype="multipart/form-data">
										<input type="hidden" class="form-control" id="" value='<? echo get_user_id(); ?>' name="uid">
										<div class="row">
											<div class="btn btn-sm float-left" style="background-color:#73C6B6">
												<input type="file" class="filestyle" data-icon="false" id="upl_adhaar_info" name="upl_adhaar_info[]" required>
											</div>
											<p style="color:red">Upload jpg, jpeg, png, pdf format only</p>
										</div>
										<input type="checkbox" id="is_acpt_aadhaar" name="is_acpt_aadhaar" value="1" required>
										I certify that the uploaded photocopy of adhaar copy is authentic & I will be responsible for incorrect photocopy uploaded.
										<div class="form-group" style='margin-top:20px;'>
											<button type="submit" id='btnAdhaarUpl' class="btn btn-primary">Upload</button>
										</div>
									</form>
								</center>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
		}
		/////////////////////////////////////////////////
		$policyID = "";
		if (count($policy_list) > 0) {
			?>
			<div class="row">
				<!-- DataTable -->
				<div class="col-md-12">
					<div class="white_widget padding_3">
						<h2 class="avail_title_heading">Pending <?php echo $compName; ?> Policies</h2>
						<hr class="sepration_border">
						<div class="widget-body no_padding">
							<div class="common_table_widget report_hirarchy_new table_export new_fixed_widget">
								<table id="default-datatable" data-plugin="DataTable" class="table table-bordered table-striped skt-table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>SL. No.</th>
											<th>Location</th>
											<th>Function</th>
											<th>Title</th>
											<th>Attachment</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$pDate = 0;
										$slno = 1;
										foreach ($policy_list as $row) :
										?>
											<tr>
												<td><?php echo $slno++; ?></td>
												<td class="twolines1"><?php echo $row['office_id']; ?></td>
												<td><?php echo $row['func_name']; ?></td>
												<td><?php echo $row['title']; ?></td>
												<td width="250px">
													<?php
													$policyID = $row['id'];
													$attach_list = $all_policy_attach[$policyID];
													if (!empty($attach_list)) {
													?>
														<div class='pageAttachDiv' id='attDiv<?php $row['id']; ?>'>
															<?php
															foreach ($attach_list as $attRow) {
																$iconUrl = getIconUrl($policyID . "-" . $attRow['id'] . "." . $attRow['ext']);
																$attachUrl = base_url() . "uploads/policy/" . $policyID . "-" . $attRow['id'] . "." . $attRow['ext'];
																$attID = $attRow['id'];
																$params = $row['title'] . "$#" . $row['description'] . "$#" . $row['office_id'] . "$#" . $row['function_id'] . "$#" . $row['is_active'];
																$filePath = FCPATH . $iconUrl;
																$src = file_exists($filePath) ? base_url() . $iconUrl : base_url() . 'uploads/knowledge_base/no_image_available.jpg';
															?>
																<div class='attachDiv' title='Click here to open' id="div_<?php echo $attID ?>">
																	<a target='_blank' class='atLink' href="<?php echo $attachUrl; ?>">
																		<img src="<?php echo $src; ?>" id="<?php echo $attID ?>" />
																	</a>
																</div>
															<?php } ?>
														</div>
													<?php } ?>
												</td>
												<td>
													<?php if ($row['is_active'] == 1) { ?>
														<?php if ($row['is_accepted'] == 0) { ?>
															<button title="" titleJS="" adpid='<?php echo $row['id'] ?>' type='button' class='acptPolicy btn btn_padding filter_btn btn-xs' data-toggle='modal'>Accept Policy</button>
														<?php } else {
															echo 'Policy Accepted';
														}
														?>
													<?php } ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div><!-- .widget-body -->
					</div><!-- .widget -->
				</div>
				<!-- END DataTable -->
			</div><!-- .row -->
		<?php } ?>
		<?php
		$pu_ID = "";
		if (count($process_updates) > 0) {
		?>
			<div class="row">
				<!-- DataTable -->
				<div class="col-md-12">
					<div class="white_widget padding_3">
						<h2 class="avail_title_heading">Pending <?php echo $compName; ?> Process Update</h2>
						<hr class="sepration_border">
						<div class="widget-body no_padding">
							<div class="common_table_widget report_hirarchy_new table_export new_fixed_widget">
								<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>SL. No.</th>
											<th>Date</th>
											<th>Location</th>
											<th>Client</th>
											<th>Process</th>
											<th>Title</th>
											<th>Description</th>
											<th>Attachment</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$pDate = 0;
										$slno = 1;
										foreach ($process_updates as $row) :
											$params = $row['title'] . "#" . $row['description'] . "#" . $row['office_id'] . "#" . $row['client_id'] . "#" . $row['process_id'] . "#" . $row['is_active'];
										?>
											<tr>
												<td><?php echo $slno++; ?></td>
												<td><?php echo $row['addedDate']; ?></td>
												<td><?php echo $row['office_id']; ?></td>
												<td><?php echo $row['clientID']; ?></td>
												<td><?php echo $row['processID']; ?></td>
												<td><?php echo $row['title']; ?></td>
												<td><?php echo $row['description']; ?></td>
												<td width="150px">
													<?php
													$pu_ID = $row['id'];
													$attach_list = $all_pu_attach[$pu_ID];
													if (!empty($attach_list)) {
													?>
														<div class='pageAttachDiv' id='attDiv<?php $row['id']; ?>'>
															<?php
															foreach ($attach_list as $attRow) {
																$iconUrl = base_url() . getIconUrl($pu_ID . "-" . $attRow['id'] . "." . $attRow['ext'], "process_updates");
																$attachUrl = base_url() . "uploads/process_updates/" . $pu_ID . "-" . $attRow['id'] . "." . $attRow['ext'];
																$attID = $attRow['id'];
															?>
																<div class='attachDiv' title='Click here to open' id="div_<?php echo $attID ?>">
																	<a target='_blank' class='atLink' href="<?php echo $attachUrl; ?>">
																		<img src="<?php echo $iconUrl; ?>" id="<?php echo $attID ?>" />
																	</a>
																</div>
															<?php } ?>
														</div>
													<?php } ?>
												</td>
												<td width="280px">
													<?php if ($row['is_active'] == 1) { ?>
														<?php if ($row['is_accepted'] == 0) { ?>
															<button title="" titleJS="" adpid='<?php echo $row['id'] ?>' type='button' class='acceptedProcessUpdates btn btn-warning btn-xs' data-toggle='modal'>Accept Process Updates</button> &nbsp;
														<?php } else {
															echo 'Accepted Process Updates';
														}
														?>
													<?php } ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div><!-- .widget-body -->
					</div><!-- .widget -->
				</div>
				<!-- END DataTable -->
			</div><!-- .row -->
		<?php } ?>
	</section>
</div>
<!------------------------------------------------------------------------------------------------>
<!--- Pending Policy Acceptance --->
<div class="modal fade" id="myPolicyModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<form class="frmPolicyAccept" method='POST' action="<?php echo base_url('') ?>home/pending_process_policy" data-toggle="validator">
				<div class="modal-header">
					<button type="button" class="close close_new" data-dismiss="modal"></button>
					<h4 class="modal-title">Policy Acceptance</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="adpid" name="adpid" value="<?php echo $policyID; ?>">
					<div class="row">
						<div class="col-md-12">
							<input type="checkbox" id="p_status" name="p_status" required>
							Check here to indicate that you have read & agree to the terms of this policy
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id='btnPolicyAccept' class="btn btn_padding filter_btn_blue save_common_btn">I Agree</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--- --->
<!---Process Updates Acceptance--->
<div class="modal fade" id="myProcessModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<form class="frmProcessAccept" method='POST' action="<?php echo base_url() ?>home/pending_process_policy" data-toggle="validator">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Process Update Acceptance</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="process_id_apu" name="process_id" value="<?php echo $pu_ID; ?>">
					<div class="row">
						<div class="col-md-12">
							<input type="checkbox" id="process_status" name="process_status" required>
							Check here to indicate that you have read & agree to the terms of this process update
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id='btnProcessAccept' class="btn btn-primary">I Agree</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!---End Process Updates Acceptance--->
<!-- add bank modal -->
<div class="modal fade" id="addBankInfoModal" tabindex="-1" role="dialog1" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Bank Details</h4>
			</div>
			<div class="modal-body">
				<form class="frmAddBankInfo" action="<?php echo base_url(); ?>profile/add_bank" data-toggle="validator" method='POST'>
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<div class="widget-body clearfix">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="bank_name">Bank Name</label>
												<input type="text" class="form-control" id="bank_name" value='' name="bank_name" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="branch">Branch</label>
												<input type="text" class="form-control" id="branch" value='' name="branch" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="acc_no">Account No</label>
												<input type="text" class="form-control" id="acc_no" value='' name="acc_no" onkeydown="return ( event.ctrlKey || event.altKey 
												|| (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
												|| (95<event.keyCode && event.keyCode<106)
												|| (event.keyCode==8) || (event.keyCode==9) 
												|| (event.keyCode>34 && event.keyCode<40) 
												|| (event.keyCode==46) )" required>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="ifsc_code">Account Type</label>
												<select class="form-control" id="acc_type" name="acc_type" required>
													<option>Savings</option>
													<option>Checking</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="ifsc_code">IFSC Code</label>
												<input type="text" class="form-control" id="ifsc_code" value='' name="ifsc_code" pattern="^[a-zA-Z0-9]{11}$" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<input type="checkbox" id="is_accept" name="is_accept" value='1' required>
											I certify that the bank account information provided by me is accurate and salary can be processed through this account. I will be responsible for any salary issue due to incorrect bank details.
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" id='btnAddBankPerInfo' class="btn btn-primary">Add Bank Info</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- edit bank modal -->
<div class="modal fade" id="editBankInfoModal" tabindex="-1" role="dialog1" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Update Bank Details</h4>
			</div>
			<div class="modal-body">
				<form class="frmEditBankInfo" action="<?php echo base_url(); ?>profile/edit_bank" data-toggle="validator" method='POST'>
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<div class="widget-body clearfix">
									<div class="row">
										<input type="hidden" class="form-control" id="did" value='<?php echo $bank_row['id']; ?>' name="did">
										<div class="col-md-6">
											<div class="form-group">
												<label for="bank_name">Bank Name</label>
												<input type="text" class="form-control" id="bank_name" value='<?php echo $bank_row['bank_name']; ?>' name="bank_name" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="branch">Branch</label>
												<input type="text" class="form-control" id="branch" value='<?php echo $bank_row['branch']; ?>' name="branch" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="acc_no">Account No</label>
												<input type="text" class="form-control" id="acc_no" value='<?php echo $bank_row['acc_no']; ?>' name="acc_no" onkeydown="return ( event.ctrlKey || event.altKey 
												|| (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
												|| (95<event.keyCode && event.keyCode<106)
												|| (event.keyCode==8) || (event.keyCode==9) 
												|| (event.keyCode>34 && event.keyCode<40) 
												|| (event.keyCode==46) )" required>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="ifsc_code">Account Type</label>
												<select class="form-control" id="acc_type" name="acc_type" required>
													<option>Savings</option>
													<option>Checking</option>
													<option>Salary</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="ifsc_code">IFSC Code</label>
												<input type="text" class="form-control" id="ifsc_code" value='<?php echo $bank_row['ifsc_code']; ?>' pattern="^[a-zA-Z0-9]{11}$" name="ifsc_code" required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" id='btnEditBankPerInfo' class="btn btn-primary">Update Info</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
//get_user_office_id()=="KOL" || get_user_office_id()=="BLR" || get_user_office_id()=="HWH"
if ((isIndiaLocation(get_user_office_id()) == true) && $isUpdateAddressInfo == "Y") {
?>
	<!-- edit personal modal -->
	<div class="col-md-12">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">Update Your Both Address</h4>
			</header><!-- .widget-header -->
			<hr class="widget-separator">
			<form class="frmEditAddress" id="frmEditAddress" action="<?php echo base_url(); ?>home/updateAddress" data-toggle="validator" method='POST'>
				<div class="widget-body">
					<div class="panel-group">
						<div class="panel panel-info">
							<div class="panel-heading">Address Present</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="pre_country">Country</label>
											<select name="pre_country" id="pre_country" data-adrs="pre" class="form-control" required>
												<option value="">--select--</option>
												<?php
												foreach ($get_countries as $pre_country) {
													if ($personal_row['country_pre'] == $pre_country['name']) {
														$pre_country_selected = "selected";
													} else {
														$pre_country_selected = "";
													}
												?>
													<option cid="<?php echo $pre_country['id']; ?>" value="<?php echo $pre_country['name']; ?>" <?php echo $pre_country_selected; ?>> <?php echo $pre_country['name']; ?> </option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="pre_state">State:</label>
											<select class="form-control" id="pre_state" data-adrs="pre" name="pre_state" required>
												<option value="">--select--</option>
												<?php
												foreach ($get_pre_states as $pre_state) {
													if ($personal_row['state_pre'] == $pre_state['name']) {
														$pre_state_selected = "selected";
													} else {
														$pre_state_selected = "";
													} ?>
													<option sid="<?php echo $pre_state['id']; ?>" value="<?php echo $pre_state['name']; ?>" <?php echo $pre_state_selected; ?>><?php echo $pre_state['name']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="pre_city">City:</label>
											<select class="form-control" id="pre_city" data-adrs="pre" name="pre_city" required>
												<option value="">--select--</option>
												<?php
												$ctFound = 0;
												foreach ($get_pre_cities as $pre_city) {
													if ($personal_row['city_pre'] == $pre_city['name']) {
														$pre_city_selected = "selected";
														$ctFound = 1;
													} else {
														$pre_city_selected = "";
													} ?>
													<option value="<?php echo $pre_city['name']; ?>" <?php echo $pre_city_selected; ?>><?php echo $pre_city['name']; ?></option>
												<?php
												}
												if ($ctFound == 0) {
													echo "<option value='" . $personal_row['city_pre'] . "' selected>" . $personal_row['city_pre'] . "</option>";
												}
												?>
												<option value="other"> Other </option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="pre_city">City other:</label>
											<input type="text" class="form-control" id="pre_city_other" name="pre_city_other" value="" disabled>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<?php if (get_user_office_id() == 'ALB' ||  get_user_office_id() == 'UKL') { ?>
												<label for="pre_pin">Postal Code:</label>
											<?php } else { ?>
												<label for="pre_pin">Pin:</label>
											<?php } ?>
											<input type="text" class="form-control" id="pre_pin" name="pre_pin" value="<?php echo $personal_row['pin_pre']; ?>" onkeypress="return isNumber(event)" <?php if (get_user_office_id() != 'ALB') { ?>required <?php } ?>>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="address_present">Address present:</label>
											<input type="text" class="form-control" id="address_present" name="address_present" value="<?php echo $personal_row['address_present']; ?>" <?php if (get_user_office_id() != 'UKL') { ?>required <?php } ?>>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-group">
						<div class="panel panel-info">
							<div class="panel-heading">Address Permanent
								<div class="form-group pull-right">
									<label for="address_present">Same as Present Address : </label> <input type="checkbox" name="same_addr" value="1" id="same_addr">
								</div>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="per_country">Country</label>
											<select name="per_country" id="per_country" data-adrs="per" class="form-control" required>
												<option value="">--select--</option>
												<?php
												foreach ($get_countries as $country) {
													if ($personal_row['country'] == $country['name']) {
														$country_selected = "selected";
													} else {
														$country_selected = "";
													}
												?>
													<option cid="<?php echo $country['id']; ?>" value="<?php echo $country['name']; ?>" <?php echo $country_selected; ?>> <?php echo $country['name']; ?> </option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="per_state">State:</label>
											<select class="form-control" id="per_state" data-adrs="per" name="per_state" required>
												<option value="">--select--</option>
												<?php
												foreach ($get_per_states as $per_state) {
													if ($personal_row['state'] == $per_state['name']) {
														$per_state_selected = "selected";
													} else {
														$per_state_selected = "";
													}
												?>
													<option sid="<?php echo $per_state['id']; ?>" value="<?php echo $per_state['name']; ?>" <?php echo $per_state_selected; ?>><?php echo $per_state['name']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="per_city">City:</label>
											<select class="form-control" id="per_city" data-adrs="per" name="per_city" required>
												<option value="">--select--</option>
												<?php
												$ctFound = 0;
												foreach ($get_per_cities as $per_city) {
													if ($personal_row['city'] == $per_city['name']) {
														$per_city_selected = "selected";
														$ctFound = 1;
													} else {
														$per_city_selected = "";
													}
												?>
													<option value="<?php echo $per_city['name']; ?>" <?php echo $per_city_selected; ?>><?php echo $per_city['name']; ?></option>
												<?php
												}
												if ($ctFound == 0) {
													echo "<option value='" . $personal_row['city'] . "' selected>" . $personal_row['city'] . "</option>";
												}
												?>
												<option value="other"> Other </option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="per_city">City other:</label>
											<input type="text" class="form-control" id="per_city_other" name="per_city_other" value="" disabled>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<?php if (get_user_office_id() == 'ALB' ||  get_user_office_id() == 'UKL') { ?>
												<label for="per_pin">Postal Code:</label>
											<?php } else { ?>
												<label for="per_pin">Pin:</label>
											<?php } ?>
											<input type="text" class="form-control" id="per_pin" name="per_pin" value='<?php echo $personal_row['pin']; ?>' onkeypress="return isNumber(event)" <?php if (get_user_office_id() != 'ALB') { ?>required <?php } ?>>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="address_permanent">Address permanent:</label>
											<input type="text" class="form-control" id="address_permanent" name="address_permanent" value="<?php echo $personal_row['address_permanent']; ?>" <?php if (get_user_office_id() != 'UKL') { ?>required <?php } ?>>
										</div>
										<input type="hidden" name="office_id" value="<?php echo get_user_office_id(); ?>" id="office_id">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="checkbox" id="is_certify_address" name="is_certify_address" value='1' required>
							<b>I certify that the above address information provided by me is accurate as per my knowledge.</b>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" id='btnEditPersonal' class="btn btn-primary">Confirm</button>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".acptPolicy").click(function() {
			var adpid = $(this).attr("adpid");
			$('#adpid').val(adpid);
			$("#myPolicyModal").modal('show');
		});
		$('.frmPolicyAccept').submit(function() {
			if ($('#p_status').prop("checked") == true) {
				$("#myPolicyModal").modal('hide');
			} else {
				alert("Please select the CheckBox.");
			}
		});
		$(".acceptedProcessUpdates").click(function() {
			var adpid = $(this).attr("adpid");
			$('#process_id_apu').val(adpid);
			$("#myProcessModal").modal('show');
		});
		$('.frmProcessAccept').submit(function() {
			if ($('#process_status').prop("checked") == true) {
				$("#myProcessModal").modal('hide');
			} else {
				alert("Please select the CheckBox.");
			}
		});
	});
</script>