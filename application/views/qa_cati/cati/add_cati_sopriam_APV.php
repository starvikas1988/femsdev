
<style>

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
	background-color:#CCD1D1;
}

.eml2{
	font-size:24px;
	font-weight:bold;
	background-color:#008B8B;
	color:white;
}

.eml1{
	font-size:20px;
	font-weight:bold;
	background-color:#AED6F1;
}

.emp2{
	font-size:16px; 
	font-weight:bold;
}

.seml{
	font-size:15px;
	font-weight:bold;
	background-color:#CCD1D1;
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
									<tr style="background-color:#AEB6BF"><td colspan="9" id="theader" style="font-size:30px">Sopriam APV QA Form</td></tr>
									<input type="hidden" name="data[audit_start_time]" value="<?php echo $stratAuditTime; ?>">
									<tr>
										<td colspan="1">QA Name:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td colspan="1">Audit Date:</td>
										<td colspan="2"><input type="text" name="data[audit_date]" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled>
										</td>
									</tr>
									<tr>
										<td colspan="1">Agent:</td>
										<td  colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="1">Fusion ID:</td>
										<td colspan="2"><input type="text" class="form-control" id="fusion_id" disabled></td> 
										<td colspan="1">L1 Supervisor:</td>
										<td  colspan="2">
											<select class="form-control" readonly id="tl_id" name="data[tl_id]" required>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>										
										<!-- <td style="font-weight:bold" colspan="1">UCID:</td>
										<td colspan="2"><input type="text" class="form-control"  name="data[UCID]" required></td> -->
										<td colspan="1">Contact Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" required></td>
										<td colspan="1">Contact Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" required></td>
									</tr>

									<tr>
										<td colspan="1">Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td class="auType_epi" colspan="1">Auditor Type</td>
										<td class="auType_epi" colspan="2">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td colspan="1">VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<!-- <tr>
										<td colspan="1">Auto Fail:</td>
										<td colspan="2">
											<select class="form-control" id="autofail" name="data[autofail]" required>
												<?php												
												 foreach ($scoreCard as $key => $value) {
												 	if($value=="N/A")
												 		continue;
												 	
													 ?>
												 	
												<option <?=($value=="NO")?'selected':'';?> value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
									</tr> -->
									<!-- <tr>
										<td colspan="1">ACPT:</td>
										<td colspan="2">
											<select class="form-control" id="acpt" name="data[acpt]" required>
												<option value="">-Select-</option>
												<option value="Agent">Agent</option>
												<option value="Customer">Customer</option>
												<option value="Process">Process</option>
												<option value="Technology">Technology</option>
											</select>
										</td>
										<td class="acpt_option" colspan="1">ACPT Options</td>
										<td class="acpt_option" colspan="2">
											<select class="form-control" id="acpt_option" name="data[acpt_option]">
											</select>
										</td>
										<td class="acptoth" colspan="1">ACPT Others</td>
										<td class="acptoth" colspan="2">
											<input type="text" class="form-control" id="acpt_other" name="data[acpt_other]">
										</td>
									</tr> -->

									<!-- <tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busiScore" name="data[busi_score]"></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custScore" name="data[cust_score]"></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compScore" name="data[comp_score]"></td>
									</tr> -->
									
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="earnedScore" name="data[earned_score]" value=""></td><td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="possibleScore" name="data[possible_score]" value=""></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="overallScore" name="data[overall_score]" value=""></td>
									</tr>
									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=4>Sub Category</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=2>Remarks</td>
										
										</tr>
										<?php
											$parameter_column_name=0; 
											$score_column_name=0; 
											$i=1; 
											$val=0;
										?>
									<tr>
										<td rowspan=4 class="eml1">ACCUEIL</td>
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>											
											<select class="form-control points_epi" name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
										
									</tr>
									<tr>
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi" name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
										
									</tr>
									<tr>
										
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
									</tr>
									<tr>
										
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
									</tr>
									<tr>
										<td rowspan=8 class="eml1">ENVIRONNEMENT DE L'APPEL</td>
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
									</tr>
									<tr>

										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
									</tr>
									<tr>
										
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
									</tr>
									<tr>
										
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
									</tr>
									<tr>
										
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
									
								    </tr>
									<tr>
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
									
								   </tr>
								   <tr>
								   		
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
									
								 </tr>
									<tr>
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
									
								  </tr>
								   <tr>
								   	<td rowspan=1 class="eml1">QUALIFICATION</td>
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi" name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
										
									</tr>
									<tr>
								   		<td rowspan=1 class="eml1">PRISE DE CONGE</td>
										
										<td class="eml" colspan=4><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi" name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]"></td>
										
									</tr>
								    								    
									<tr>
										<td colspan=3>Call Summary:</td>
										<td colspan=6><textarea class="form-control" name="data[call_summary]"></textarea></td>
									</tr>
									<tr>
										<td colspan=3>Feedback:</td>
										<td colspan=6><textarea class="form-control" name="data[feedback]"></textarea></td>
									</tr>
									<tr>
										<td colspan=3>Upload Files</td>
										<td colspan=6><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php if(is_access_qa_module()==true){ ?>
									<tr>
										<td colspan=9><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
									</tr>
									<?php } ?>
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