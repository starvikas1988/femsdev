<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:12px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#95A5A6;
}

.eml{
	font-weight:bold;
	background-color:#F4D03F;
}
</style>

<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-12">
				<div class="widget">
				  <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
					
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="12" id="theader" style="font-size:30px">Awareness- PHONE QA FORM</td>
										<?php
										if($pre_booking_id==0){
											
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											
										}else{
											if($awareness['entry_by']!=''){
												$auditorName = $awareness['auditor_name'];
											}else{
												$auditorName = $awareness['client_name'];
											}
											//p$auditDate = mysql2mmddyy($awareness['audit_date']);
											$auditDate = ConvServerToLocal($awareness['audit_date']);
											$clDate_val = mysql2mmddyy($awareness['call_date']);
											
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td colspan="2">QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td colspan="2">Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Call Date:</td>
										<td colspan="4"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>

									<tr>
										<td colspan="2">Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $awareness['agent_id'] ?>"><?php echo $awareness['fname']." ".$awareness['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="2">Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="" value="<?php echo $awareness['process_name'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td colspan="4">
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $awareness['tl_id'] ?>"><?php echo $awareness['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>

									<tr>
										<td style="font-weight:bold" colspan="1">ACPT:</td>
										<td colspan="2">
											<select class="form-control"  name="data[acpt]" required>
												<option value="<?php echo $awareness['acpt'] ?>"><?php echo $awareness['acpt'] ?></option>
												<option value="">-Select-</option>
												<option value="Agent">Agent</option>
												<option value="Customer">Customer</option>
												<option value="Process">Process</option>
												<option value="Technology">Technology</option>
											</select>
										</td>
										<!-- <td style="font-weight:bold" colspan="1">Channel:</td>
										<td colspan="2">
											<select class="form-control"  name="data[Channel]" required>
												<option value="">-Select-</option>
												<option value="Chat" selected>Chat</option>
												<option value="Email">Email</option>
												<option value="Phone">Phone</option>
											</select>
										</td> -->
										<td colspan="1">Case/Ticket #:</td>
										<td colspan="2"><input type="text" class="form-control" id="caseTicket" name="data[caseTicket]" value="<?php echo $awareness['caseTicket'] ?>" required></td>
									</tr>
									<tr>
										<td style="font-weight:bold" colspan="1">Product:</td>
										<td colspan="2">
											<select class="form-control"  name="data[product]" required>
												<option value="<?php echo $awareness['product'] ?>"><?php echo $awareness['product'] ?></option>
												<option value="">-Select-</option>
												<option value="WebWatcher">WebWatcher</option>
												<option value="InterGuard">InterGuard</option>
												<option value="ScreenTime Lab">ScreenTime Lab</option>
												<option value="Veriato">Veriato</option>
					
											</select>
										</td>
										<td style="font-weight:bold" colspan="1">Cust Rate:</td>
										<td colspan="2">
											<select class="form-control"  name="data[cust_rate]" required>
												<option value="<?php echo $awareness['cust_rate'] ?>"><?php echo $awareness['cust_rate'] ?></option>
												<option value="">-Select-</option>
												<option value="Excellent">Excellent</option>
												<option value="Good">Good</option>
												<option value="Fair">Fair</option>
												<option value="Poor">Poor</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="1">Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($awareness['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($awareness['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($awareness['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($awareness['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                     <option value="Certification Audit" <?= ($awareness['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                     <option value="WOW Call" <?= ($awareness['audit_type']=="WOW Call")?"selected":"" ?>>WOW Call</option>
											</select>
										</td>
										<td class="auType_epi" colspan="1">Auditor Type</td>
										<td class="auType_epi" colspan="2">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $awareness['auditor_type'] ?>"><?php echo $awareness['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td colspan="1">VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $awareness['voc'] ?>"><?php echo $awareness['voc'] ?></option>
											
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custlockScore" name="data[cust_score]" value="<?php echo $awareness['cust_score'] ?>"></td><td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busilockScore" name="data[busi_score]" value="<?php echo $awareness['busi_score'] ?>"></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compllockScore" name="data[comp_score]" value="<?php echo $awareness['comp_score'] ?>"></td>
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="pre_earnedScore" name="data[earned_score]" value="<?php echo $awareness['earned_score'] ?>"></td><td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="pre_possibleScore" name="data[possible_score]" value="<?php echo $awareness['possible_score'] ?>"></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="pre_overallScore" name="data[overall_score]" value="<?php echo $awareness['overall_score'] ?>"></td>
									</tr>									
									
									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=4>Sub Category</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=4>Remarks</td>
										</tr>
										
									<tr>
										<td rowspan=3 class="eml1">COMPLIANCE CRITICAL</td>
										<td class="" colspan=4>Agent verify Username / Email Address for correct account.</td>

										<td>											
											<select class="form-control affinity_point compliance" name="data[Category1]" required>
												<option affinity_val=3  <?php echo $awareness['Category1']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=3  <?php echo $awareness['Category1']=='No'?"selected":""; ?> value="No">No</option>
												
												<option affinity_val=0  <?php echo $awareness['Category1']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $awareness['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td class="" colspan=4>Setting proper expectation to the customer.</td>

										<td>											
											<select class="form-control affinity_point compliance" name="data[Category2]" required>
												<option affinity_val=5  <?php echo $awareness['Category2']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=5  <?php echo $awareness['Category2']=='No'?"selected":""; ?> value="No">No</option>
												
												<option affinity_val=0  <?php echo $awareness['Category2']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $awareness['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td class="" colspan=4>Did the agent ask if there is anything that they can do to enhance customer experience before interaction ends?</td>

										<td>											
											<select class="form-control affinity_point compliance" name="data[Category3]" required>
												<option affinity_val=3  <?php echo $awareness['Category3']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=3  <?php echo $awareness['Category3']=='No'?"selected":""; ?> value="No">No</option>
												
												<option affinity_val=0  <?php echo $awareness['Category3']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $awareness['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td rowspan=1 class="1">BUSINESS CRITICAL</td>

										<td class="" colspan=4>Did the agent follow correct / proper procedure based on company policy and/or mandated guidelines?</td>

										<td>											
											<select class="form-control affinity_point business" name="data[Category4]" required>
												<option affinity_val=5  <?php echo $awareness['Category4']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=5  <?php echo $awareness['Category4']=='No'?"selected":""; ?> value="No">No</option>
												
												<option affinity_val=0  <?php echo $awareness['Category4']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $awareness['cmt4'] ?>"></td>
									</tr>
									
									
									<tr>
										<td rowspan=7 class="1">CUSTOMER CRITICAL</td>

										<td class="" colspan=4>The agent greet and identified themselves to the customer. Warm and genuine tone of voice must be displayed to show willingness to assist.</td>

										<td>											
											<select class="form-control affinity_point customer" name="data[Category6]" required>
												<option affinity_val=3  <?php echo $awareness['Category6']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=3  <?php echo $awareness['Category6']=='No'?"selected":""; ?> value="No">No</option>
												
												<option affinity_val=0  <?php echo $awareness['Category6']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $awareness['cmt6'] ?>"></td>
								   </tr>
								   <tr>
										<td class="" colspan=4>Ask customer name and use it appropriately.</td>

										<td>											
											<select class="form-control affinity_point customer" name="data[Category7]" required>
												<option affinity_val=3  <?php echo $awareness['Category7']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=3  <?php echo $awareness['Category7']=='No'?"selected":""; ?> value="No">No</option>
												
												<option affinity_val=0  <?php echo $awareness['Category7']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $awareness['cmt7'] ?>"></td>
								 </tr>
									<tr>
										<td class="" colspan=4>Paraphrase, demonstrate active listening and acknowledge all statements / concerns.</td>

										<td>											
											<select class="form-control affinity_point customer" name="data[Category8]" required>
												<option affinity_val=3  <?php echo $awareness['Category8']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=3  <?php echo $awareness['Category8']=='No'?"selected":""; ?> value="No">No</option>
												
												<option affinity_val=0  <?php echo $awareness['Category8']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $awareness['cmt8'] ?>"></td>
								  </tr>
								   <tr>
										<td class="" colspan=4>Must display confidence and act professional throughout the call.</td>

										<td>											
											<select class="form-control affinity_point customer" name="data[Category9]" required>
												<option affinity_val=3  <?php echo $awareness['Category9']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=3  <?php echo $awareness['Category9']=='No'?"selected":""; ?> value="No">No</option>
												<option affinity_val=0  <?php echo $awareness['Category9']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $awareness['cmt9'] ?>"></td>
									</tr>
									 <tr>
										<td class="" colspan=4>Acknowledges and responds to the customer’s emotional statements. Expresses empathy appropriately.</td>

										<td>											
											<select class="form-control affinity_point customer" name="data[Category10]" required>
												<option affinity_val=5  <?php echo $awareness['Category10']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=5  <?php echo $awareness['Category10']=='No'?"selected":""; ?> value="No">No</option>
												<option affinity_val=0  <?php echo $awareness['Category10']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $awareness['cmt10'] ?>"></td>
									</tr>

									<tr>
										<td class="" colspan=4>Refrain from an excessive dead air or awkward silence.</td>

										<td>											
											<select class="form-control affinity_point customer" name="data[Category11]" required>
												<option affinity_val=3  <?php echo $awareness['Category11']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=3  <?php echo $awareness['Category11']=='No'?"selected":""; ?> value="No">No</option>
												<option affinity_val=0  <?php echo $awareness['Category11']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $awareness['cmt11'] ?>"></td>
									</tr>

									<tr>
										<td class="" colspan=4>The agent must thank the customer for contacting to properly end the call.</td>

										<td>											
											<select class="form-control affinity_point customer" name="data[Category12]" required>
												<option affinity_val=3  <?php echo $awareness['Category12']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option affinity_val=3  <?php echo $awareness['Category12']=='No'?"selected":""; ?> value="No">No</option>
												<option affinity_val=0  <?php echo $awareness['Category12']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $awareness['cmt12'] ?>"></td>
									</tr>
									


									<tr>
										<td>Call Summary:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[call_summary]"><?php echo $awareness['call_summary'] ?></textarea></td>
										<td colspan="2">Remark:</td>
										<td colspan=6><textarea class="form-control" id="" name="data[feedback]"><?php echo $awareness['feedback'] ?></textarea></td>
									</tr>
									
									

									<?php if($pre_booking_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files (wav,wmv,mp3,mp4)</td>
										<td colspan=4><input type="file" multiple class="form-control audioFile" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files(wav,wmv,mp3,mp4)</td>
										<?php if($awareness['attach_file']!=''){ ?>
											<td colspan=6>
												<?php $attach_file = explode(",",$awareness['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/awareness/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/awareness/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												//echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									
									<?php if($pre_booking_id!=0){ ?>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $awareness['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $awareness['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $awareness['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:12px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $awareness['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>
									
									
									<?php 
									if($pre_booking_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											 if($awareness['agent_rvw_note']=="") { ?>
												<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
									<?php 	
											}
										}
									} 
									?>
									
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
$(document).ready(function(){
    
    $('.audioFile').change(function () {
        var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
            case 'wav':
            case 'wmv':
            case 'mp3':
            case 'mp4':
                $('#uploadButton').attr('disabled', false);
                break;
            default:
                alert('This is not an allowed file type.');
                this.value = '';
        }
    });
    
});    
</script>