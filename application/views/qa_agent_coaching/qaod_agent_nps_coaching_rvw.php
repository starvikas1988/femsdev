<!-- <script src="<?php echo base_url() ?>application/third_party/ckeditor/ckeditor.js"></script> -->

<style>
input{

	text-align:center;
}

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

.eml{
	font-weight:bold;
	background-color:#D4EFDF;
}

select {
  text-align: center;
  text-align-last: center;
  /* webkit*/
}
option {
  text-align: left;
  /* reset to left*/
}

textarea{
	text-align: center;
  text-align-last: center;
}
.file_class input[type="file"] {
  border: 1px solid #ccc!important;
  padding: 8px;
  text-align: left;
}
.btn-new{
  width: 200px;
  padding: 10px!important;
}

</style>
<?php 
// echo"<pre>";
// print_r($od_nps_coaching);
// echo"</pre>";
?>

<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
				  <!-- <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
				  	<input type="hidden" name="tl_id" value="<?php echo $od_nps_coaching['tl_id']; ?>">
				  	<input type="hidden" name="agent_id" value="<?php echo $od_nps_coaching['agent_id']; ?>">
				  	<input type="hidden" name="upload_raw_id" value="<?php echo $od_nps_coaching['id']; ?>">
				  	<input type="hidden" name="fusion_id" value="<?php echo $od_nps_coaching['fusion_id']; ?>"> -->
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color: #569CE9;color: #fff;">
										<td colspan="6" id="theader" style="font-size:30px">OFFICE DEPOT: NPS COACHING FORM</td>
									</tr>
									<tr>
										<td >Client</td>
										<td >
										<select class="form-control" style="text-align:center" id="client_id" name="client_id" required>
												<option value="42" selected>Office Depot</option>
											</select>
										</td>
											<td >Process</td>
										<td >
											<select class="form-control" style="text-align:center" id="process_id" name="process_id" readonly>
												<?php 
												if($od_nps_coaching['process_id']!=''){
													?>
													<option value="<?php echo $od_nps_coaching['process_id'] ?>"><?php echo $od_nps_coaching['process_name'] ?></option>
													<?php 
												}else{
													?>
													<option value="">-Select-</option>
													<?php
												}
												?>
												
												
												<?php foreach ($process_details as $key => $value){ ?>
												<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
											<?php } ?>
											</select>
										</td>
									</tr>
									<?php 
									$auditDate = ($od_nps_coaching['audit_date']);
									if($od_nps_coaching['callout_date']!=''){
										$call_out_Date = ($od_nps_coaching['callout_date']);
									}
									?>
									<tr>
										<td >Date of Coaching</td>
										<td >
										<input type="text" class="form-control" name="date_coaching" id="audit_date" value = "<?php echo CurrDateMDY(); ?>" disabled>
										</td>
											<td >Callout Date</td>
										<td >
											<input type="text" class="form-control" name="callout_date" id="callout_date" value = "<?php echo $od_nps_coaching['callout_date']; ?>" disabled>
										</td>
									</tr>

									<tr>
										<td >Coaching Age</td>
										<td >
										<input type="text" class="form-control" name="coaching_age" id="coaching_age" value="<?php echo $od_nps_coaching['coaching_age']; ?>" disabled>
										</td>
											<td >Team Lead</td>
										<td >
											<input type="text" class="form-control" name="tead_lead" value="<?php echo $od_nps_coaching['tl_name']; ?>" disabled>
										</td>
									</tr>

									<?php 
									$clDate_val=mysql2mmddyy($od_nps_coaching['call_date']);
									?>
									<tr>
										<td >Survey Date</td>
										<td >
										<input type="text" class="form-control" name="survey_date" id="survey_date" value="<?php echo $od_nps_coaching['call_date']; ?>" disabled>
										</td>
											<td style="color:red;">Category 1</td>
										<td >
											<input type="text" class="form-control" name="category1" value="<?php echo $od_nps_coaching['category1']; ?>" disabled>
										</td>
									</tr>


									<tr>
										<td >Queue Name</td>
										<td >
										<input type="text" class="form-control" name="queue_name" value="<?php echo $od_nps_coaching['queue_name']; ?>" disabled>
										</td>
											<td style="color:red;">Sub Category</td>
										<td >
											<input type="text" class="form-control" name="sub_category" value="<?php echo $od_nps_coaching['sub_Category']; ?>" disabled>
										</td>
									</tr>


									<tr>
										<td >Session ID</td>
										<td >
										<input type="text" class="form-control" name="session_id" value="<?php echo $od_nps_coaching['session_id']; ?>" disabled>
										</td>
											<td >NPS Comments</td>
										<td >
											<!-- <input type="text" class="form-control" name="nps_comment" value="<?php //echo $od_nps_coaching['nps_comment']; ?>"> -->
											<textarea class="form-control" id="nps_comment" name="nps_comment" value="<?php echo $od_nps_coaching['nps_comment']; ?>" disabled><?php echo $od_nps_coaching['nps_comment']; ?></textarea>
										</td>
									</tr>


									<tr>
										<td >Agent</td>
										<td >
										<input type="text" class="form-control" name="agent" value="<?php echo $od_nps_coaching['agent_name']; ?>" disabled>
										</td>
											<td >RCA L1</td>
										<td >
											<select class="form-control" name="rcal1" id="rcal1" disabled>
												<option  value="<?php echo $od_nps_coaching['rca_level1']; ?>"><?php echo $od_nps_coaching['rca_level1']; ?></option>
											</select>

											<!-- <input type="text" class="form-control" name="rcal1" value="<?php //echo $od_nps_coaching['rca_level1']; ?>"> -->
										</td>
									</tr>


									<tr>
										<td >Tenurity</td>
										<td >
										<input type="text" class="form-control" name="tenuarity" value="<?php echo $od_nps_coaching['tenuarity']; ?> disabled">
										</td>
											<td >RCA L2</td>
										<td >
											<select class="form-control" name="rcal2" id="rcal2" disabled>
												<option  value="<?php echo $od_nps_coaching['rca_level2']; ?>"><?php echo $od_nps_coaching['rca_level2']; ?></option>
											</select>
											<!-- <input type="text" class="form-control" name="rcal2" value="<?php //echo $od_nps_coaching['rca_level2']; ?>"> -->
										</td>
									</tr>


									<tr>
										<td >NPS Score</td>
										<td >
										<input type="text" class="form-control" name="nps_score" value="<?php echo $od_nps_coaching['nps_score']; ?>" disabled>
										</td>
											<td >Controllable/Uncontrollable</td>
										<td >
											<select class="form-control" name="controllable_uncontrollable" disabled>
												<option vlaue="" disabled>Select</option>
												<option <?php echo $od_nps_coaching['controllable_uncontrollable']=='controllable'?"selected":""; ?> value="controllable">controllable</option>
												<option <?php echo $od_nps_coaching['controllable_uncontrollable']=='uncontrollable'?"selected":""; ?> value="uncontrollable">uncontrollable</option>
											</select>
										</td>
									</tr>


									<tr>
										<td >Month</td>
										<td >
										<input type="text" class="form-control" name="month" value="<?php echo date('F', strtotime('m')); ?>" disabled>
										</td>
										<td>VOC:</td>
										<td colspan="3">
											<select class="form-control" id="voc" name="voc" disabled>
												<option value="">-Select-</option>
												<option <?php echo $od_nps_coaching['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $od_nps_coaching['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $od_nps_coaching['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $od_nps_coaching['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $od_nps_coaching['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
											
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" disabled>
											<option value="">-Select-</option>
											<option <?php echo $od_nps_coaching['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
											<option <?php echo $od_nps_coaching['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
											<option <?php echo $od_nps_coaching['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
											<option <?php echo $od_nps_coaching['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option <?php echo $od_nps_coaching['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>Fusion ID:</td>
										
										<td><input type="text" readonly class="form-control"  id="fusion_id" name="fusion_id" value="<?php echo $od_nps_coaching['fusion_id']; ?>"></td>
										
									</tr>

									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>

									<tr>
										<td >RCA Details</td>
										<td >
										<textarea class="form-control" id="rca_details" name="rca_details" value="<?php echo $od_nps_coaching['rca_details']; ?>" disabled><?php echo $od_nps_coaching['rca_details']; ?></textarea>
										</td>
											<td >Recommendation</td>
										<td >
											<textarea class="form-control" id="recommendation" name="recommendation" value="<?php echo $od_nps_coaching['recommendation']; ?>" disabled><?php echo $od_nps_coaching['recommendation']; ?></textarea>
										</td>
									</tr>

								</tbody>
							</table>
								<table class="table table-striped skt-table" width="100%" style="margin-top:-19px;">
								<tbody>
									<tr><td colspan="11" style="background-color:#C5C8C8"></td></tr>
									<tr>
										<td colspan="3">Audio Files</td>
										<?php 
										if($od_nps_coaching['attach_file']==''){
											?>
												<td colspan="3" class="file_class"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
											<?php
										}else{
											?>
												<td colspan="3" class="file_class"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
												<td colspan=5>
												<?php if($od_nps_coaching['attach_file']!=''){ 
													$attach_file = explode(",",$od_nps_coaching['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_agent_coaching/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_agent_coaching/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php }  
												}?>
											</td>
											<?php
										}
										?>
										

									</tr>

									<?php if($od_nps_coaching_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=8><?php echo $od_nps_coaching['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=8><?php echo $od_nps_coaching['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=8><?php echo $od_nps_coaching['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=8><?php echo $od_nps_coaching['client_rvw_note'] ?></td></tr>
									<?php } ?>

									<form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="od_nps_coaching_id" class="form-control" value="<?php echo $od_nps_coaching_id; ?>">
										
										<tr>
											<td colspan="2" style="font-size:16px">Feedback Acceptance</td>
											<td colspan="8">
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $od_nps_coaching['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $od_nps_coaching['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2"  style="font-size:16px">Review</td>
											<td colspan="8"><textarea class="form-control" name="note" required=""><?php echo $od_nps_coaching['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($od_nps_coaching['entry_date'],72) == true){ ?>
											<tr>
												<?php if($od_nps_coaching['agent_rvw_note']==''){ ?>
													<td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									  </form>
									
									<?php 
									if($od_nps_coaching_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=10><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($od_nps_coaching['entry_date'],72) == true){ ?>
												<tr><td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
									<?php 	
											}
										}
									} 
									?>
							
									<!-- <tr>
										<td colspan="10"><button class="btn btn-success btn-new waves-effect" type="submit" id="qaformsubmit" >SAVE</button></td>

									</tr> -->

								</tbody>
							</table>
						</div>
					</div>
<!-- </form> -->

				</div>
			</div>
		</div>

	</section>
</div>


<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    //CKEDITOR.replace( 'coaching_comment' );
    //CKEDITOR.replace( 'rca_details' );
    //CKEDITOR.replace( 'recommendation' );
</script>

