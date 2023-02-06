
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

<?php if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form-control{
			pointer-events:none;
			background-color:#D5DBDB;
		}
	</style>
<?php } ?>

<div class="wrap">
	<section class="app-content">


		<div class="row">
		<form id="form_mgnt_user" method="POST" action="">

			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="9" id="theader" style="font-size:30px">Mgnt Sopriam APV Rvw<!-- <img src="<?php echo base_url(); ?>main_img/hra.png"> --></td>
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									</tr>
										
									<tr>
										<td colspan="1">QA Name:</td>
										<?php 
										// $page="flv";
										$page_name_val=explode('_', $page);
										$pageCnt=count($page_name_val);
										if($pageCnt>1){
											$page_name=implode("/",$page_name_val);
										}else{
											$page_name=$page."/".$page;
										}
										// die;
										$dataDetails=$page."_new";
										if($$dataDetails['entry_by']!=''){
												$auditorName = $$dataDetails['auditor_name'];
											}else{
												$auditorName = $$dataDetails['client_name'];
										} ?>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td colspan="1">Audit Date:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($$dataDetails['audit_date']); ?>" disabled></td>
										<!-- <td colspan="1">Phone Number:</td>
										<td colspan="2"><input type="text" class="form-control" id="phone" name="data[phone]" value="<?php echo $$dataDetails['phone'] ?>" disabled></td> -->
										
									</tr>
									<tr>
										<td colspan="1">Agent:</td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $$dataDetails['agent_id'] ?>"><?php echo $$dataDetails['fname']." ".$$dataDetails['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="1">Fusion ID:</td>
										<td colspan="2"><input type="text" disabled class="form-control" id="fusion_id" value="<?php echo $$dataDetails['fusion_id'] ?>"></td>
										<td colspan="1">L1 Supervisor:</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]"  disabled>
												<option value="<?php echo $$dataDetails['tl_id'] ?>"><?php echo $$dataDetails['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<!-- <td style="font-weight:bold" colspan="1">UCID:</td>
										<td colspan="2"><input type="text" class="form-control"  name="data[UCID]" value="<?php echo $$dataDetails['UCID'] ?>" required></td> -->
										<td colspan="1">Contact Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $$dataDetails['call_date'] ?>" disabled></td>
										<td colspan="1">Contact Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $$dataDetails['call_duration'] ?>" disabled></td>
									</tr>
									<!-- <tr>
										<td colspan="1">Wrong Disposition:</td>
										<td colspan="2"><input type="text" class="form-control" id="wrong_disposition" name="data[wrong_disposition]" value="<?php echo $$dataDetails['wrong_disposition'] ?>" required></td>										
									</tr> -->
									<tr>
										<td colspan="1">Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]">
												<option value="<?php echo $$dataDetails['audit_type'] ?>"><?php echo $$dataDetails['audit_type'] ?></option>
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
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $$dataDetails['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $$dataDetails['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td colspan="1">VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]"  disabled>
												<option value="<?php echo $$dataDetails['voc'] ?>"><?php echo $$dataDetails['voc'] ?></option>
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
												 	
												<option <?=($$dataDetails['autofail']==$value)?'selected':'';?> value="<?=$value?>"><?=$value?></option>
												<?php } ?>
											</select>
										</td>
									</tr> -->
									<!-- <tr>
										<td colspan="1">ACPT:</td>
										<td colspan="2">
											<select class="form-control" id="acpt" name="data[acpt]" required>
												<option value="<?php echo $$dataDetails['acpt'] ?>"><?php echo $$dataDetails['acpt'] ?></option>
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
												<option value="<?php echo $$dataDetails['acpt_option'] ?>"><?php echo $$dataDetails['acpt_option'] ?></option>
											</select>
										</td>
										<td class="acptoth" colspan="1">ACPT Others</td>
										<td class="acptoth" colspan="2">
											<input type="text" class="form-control" id="acpt_other" name="data[acpt_other]" value="<?php echo $$dataDetails['acpt_other'] ?>">
										</td>
									</tr> -->
									<!-- <tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busiScore" name="data[busi_score]" value="<?php echo $$dataDetails['busi_score'] ?>"></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custScore" name="data[cust_score]" value="<?php echo $$dataDetails['cust_score'] ?>"></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compScore" name="data[comp_score]" value="N/A"></td>
									</tr> -->
									<tr>										
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="earnedScore" name="data[earned_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="possibleScore" name="data[possible_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="overallScore" name="data[overall_score]" value="<?php echo $$dataDetails['overall_score'] ?>" readonly></td>
									</tr>
									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=6>Sub Category</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=2>Remarks</td>
										

										
										</tr>
										<?php
												$i=1;
												$j=1;
												$parameter_column_name=0;
												$score_column_name=0;
												$score_column_name_db_tbl=0; 
												$val=0;
										?>
									<tr>
										<td rowspan=4 class="eml1">ACCUEIL</td>
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>											
											<select class="form-control points_epi" name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
										
									</tr>
									<tr>
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi" name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
										
									</tr>
									<tr>
										
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
									</tr>
									<tr>
										
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
									</tr>
									<tr>
										<td rowspan=8 class="eml1">ENVIRONNEMENT DE L'APPEL</td>
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
									</tr>
									<tr>

										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
									</tr>
									<tr>
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
									</tr>
									<tr>
										
										
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
									</tr>
									<tr>
										
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
									
								    </tr>
									<tr>
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
									
								   </tr>
								   <tr>
								   	
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
									
								 </tr>
									<tr>
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi"  name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
									
								  </tr>
								   <tr>
								   		<td rowspan=1 class="eml1">QUALIFICATION</td>
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi" name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
										
									</tr>
									<tr>
								   		<td rowspan=1 class="eml1">PRISE DE CONGE</td>
								   		
										<td class="eml" colspan=6><?php echo $scoreParametername[$parameter_column_name++] ?></td>
										<td>
											<select class="form-control points_epi" name="data[<?=$columname[$score_column_name++]?>]" required>
												<?php
												$x=$score_column_name_db_tbl++;
												$score=$val++;
												 foreach ($scoreCard as $key => $value) {
													 ?>
												<option ds_val="<?php echo $scoreVal[$score]; ?>" value="<?=$value?>"   <?=($$dataDetails[$columname[$x]]==$value)?'selected':'';?>><?=$value?></option>
												<?php } ?>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>" disabled></td>
										
									</tr>
																		
									<tr>
										<td colspan="3">Call Summary:</td>
										<td colspan="6"><textarea class="form-control" id="call_summary" name="data[call_summary]"><?php echo $$dataDetails['call_summary'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="3">Feedback:</td>
										<td colspan="6"><textarea class="form-control" id="feedback" name="data[feedback]"><?php echo $$dataDetails['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($$dataDetails['attach_file']!=''){ ?>
									<tr>
										<td colspan="3">Audio Files</td>
										<td colspan="6">
											<?php $attach_file = explode(",",$$dataDetails['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio controls='' style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_cati/cati/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_cati/cati/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Agent Review:</td> <td colspan="8" style="text-align:left"><?php echo $$dataDetails['agent_rvw_note']; ?></td></tr>
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="8" style="text-align:left"><?php echo $$dataDetails['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="8" style="text-align:left"><?php echo $$dataDetails['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr>
										<td colspan="3"  style="font-size:16px">Client/Manager Reviews</td>
										<td colspan="6"><textarea class="form-control1" style="width:100%" name="note" placeholder="Please Write Reviews Here..." required></textarea></td>
									</tr>
									
									<?php if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ 
									if(is_available_qa_feedback($$dataDetails['entry_date'],72) == true){ ?>
										<tr>
											<td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='btnmgntSave' name='btnSave' value="SAVE" style="width:300px">SAVE</button> &nbsp; <a class="btn btn-warning" href="<?php echo base_url(); ?>Qa_<?=$page_name_val[0] ?>">Back</a></td>
										</tr>
									<?php } 
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>	
			</div>

		</form>	
		</div>

	</section>
</div>