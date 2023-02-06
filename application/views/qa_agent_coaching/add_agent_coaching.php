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
// print_r($agent_upload_each);
// echo"</pre>";
?>

<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
				  <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
				  	 <!-- <form id="form_audit_user" method="POST" action="<?php //echo base_url('Qa_agent_coaching_upload/add_agent_coaching_feedback')?>" enctype="multipart/form-data"> -->
				  	 	<?php $stratAuditTimes=date('Y-m-d H:i:s'); ?>
				  	 	<input type="hidden" name="audit_start_time" value="<?php echo $stratAuditTimes; ?>">
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
												<option value="">Select</option>
												<?php foreach ($process_details as $key => $value){ ?>
												<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
											<?php } ?>
											</select>
										</td>
									</tr>
									<?php 
									 $auditDate = date("Y-m-d");
									// if($agent_upload_each['callout_date']!=''){
									// 	$call_out_Date = ($agent_upload_each['callout_date']);
									// }
									?>
									<tr>
										<td >Date of Coaching</td>
										<td >
										<input type="text" class="form-control" name="date_coaching" id="audit_date" value="<?php echo CurrDateMDY(); ?>">
										</td>
											<td >Callout Date</td>
										<td >
											<input type="text" class="form-control" name="callout_date" id="callout_date">
										</td>
									</tr>

									<tr>
										<td >Coaching Age</td>
										<td >
										<input type="text" class="form-control" name="coaching_age" id="coaching_age" value="">
										</td>
										<td >Agent</td>
										<td >
										<!-- <input type="text" class="form-control" name="agent" value="<?php //echo $agent_upload_each['agent_name']; ?>"> -->
										<select class="form-control" style="text-align:center" id="agent_id" name="agent_id" required>
												<option value="">-Select-</option>
												<?php foreach($agent_name as $agent_name_value): ?>
													<option value="<?php echo $agent_name_value['id']; ?>"><?php echo $agent_name_value['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>

									<?php 
								//	$clDate_val=mysql2mmddyy($agent_upload_each['call_date']);
									?>
									<tr>
										<td >Survey Date</td>
										<td >
										<input type="text" class="form-control" name="survey_date" id="survey_date" value="">
										</td>
											<td style="color:red;">Category 1</td>
										<td >
											<input type="text" class="form-control" name="category1" value="">
										</td>
									</tr>


									<tr>
										<td >Queue Name</td>
										<td >
										<input type="text" class="form-control" name="queue_name" value="">
										</td>
											<td style="color:red;">Sub Category</td>
										<td >
											<input type="text" class="form-control" name="sub_category" value="">
										</td>
									</tr>


									<tr>
										<td >Session ID</td>
										<td >
										<input type="text" class="form-control" name="session_id" value="">
										</td>
											<td >NPS Comments</td>
										<td >
											<!-- <input type="text" class="form-control" name="nps_comment" value="<?php //echo $agent_upload_each['nps_comment']; ?>"> -->
											<textarea class="form-control" id="nps_comment" name="nps_comment" value="" required></textarea>
										</td>
									</tr>


									<tr>
										<td >Team Lead</td>
										<td >
											<!-- <input type="text" class="form-control" name="tead_lead" value="<?php //echo $agent_upload_each['tl_name']; ?>"> -->
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										
											<td >RCA L1</td>
										<td >
											<select class="form-control" name="rcal1" id="rcal1">
												<option vlaue="">Select</option>
												<option value="Agent">Agent</option>
												<option value="Customer">Customer</option>
												<option value="Process">Process</option>
												<option value="Technology">Technology</option>
											</select>
										</td>
									</tr>


									<tr>
										<td >Tenurity</td>
										<td >
										<input type="text" class="form-control" name="tenuarity" value="">
										</td>
											<td >RCA L2</td>
										<td >
											<select class="form-control" name="rcal2" id="rcal2">
												<option vlaue="" disabled>Select</option>
											</select>
										</td>
									</tr>


									<tr>
										<td >NPS Score</td>
										<td >
										<input type="text" class="form-control" name="nps_score" value="">
										</td>
											<td >Controllable/Uncontrollable</td>
										<td >
											<select class="form-control" name="controllable_uncontrollable">
												<option vlaue="">Select</option>
												<option  value="controllable">controllable</option>
												<option  value="uncontrollable">uncontrollable</option>
											</select>
										</td>
									</tr>


									<tr>
										<td >Month</td>
										<td >
										<input type="text" class="form-control" name="month" value="<?php echo date('F', strtotime('m')); ?>">
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="fusion_id"></td>
											
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
											<option value="">-Select-</option>
											<option  value="CQ Audit">CQ Audit</option>
											<option  value="BQ Audit">BQ Audit</option>
											<option  value="Calibration">Calibration</option>
											<option  value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option  value="Certificate Audit">Certificate Audit</option>
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
										
									</tr>
									<tr>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>

									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>

									<tr>
										<td >RCA Details</td>
										<td >
										<textarea class="form-control" id="rca_details" name="rca_details" value="" required></textarea>
										</td>
											<td >Recommendation</td>
										<td >
											<textarea class="form-control" id="recommendation" name="recommendation" value="" required></textarea>
										</td>
									</tr>

								</tbody>
							</table>
								<table class="table table-striped skt-table" width="100%" style="margin-top:-19px;">
								<tbody>
									<tr><td colspan="11" style="background-color:#C5C8C8"></td></tr>
									<tr>
										<td colspan="3">Audio Files</td>
										<td colspan="3" class="file_class"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										
									</tr>
							
									<tr>
										<td colspan="10"><button class="btn btn-success btn-new waves-effect" type="submit" id="qaformsubmit" >SAVE</button></td>

									</tr>

								</tbody>
							</table>
						</div>
					</div>

				  </form>

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

