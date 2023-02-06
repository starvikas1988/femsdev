
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
	background-color:#85C1E9;
}

</style>


<div class="wrap">
	<section class="app-content">


		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader" style="font-size:30px">Cholamandlam</td></tr>
									<?php
										if($cholamandlam_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($cholamandlam['entry_by']!=''){
												$auditorName = $cholamandlam['auditor_name'];
											}else{
												$auditorName = $cholamandlam['client_name'];
											}
											$auditDate = mysql2mmddyy($cholamandlam['audit_date']);
											$clDate_val = mysql2mmddyy($cholamandlam['call_date']);
										}
									?>
								
									<tr>
										<td>Auditor Name:</td>
										<?php if($cholamandlam['entry_by']!=''){
												$auditorName = $cholamandlam['auditor_name'];
											}else{
												$auditorName = $cholamandlam['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($cholamandlam['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($cholamandlam['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $cholamandlam['fname']." ".$cholamandlam['lname']." - [".$cholamandlam['fusion_id']."]" ?></option>
											</select>
										</td>
										<td>L1 Supervisor:</td>
										<td><select class="form-control" disabled><option><?php echo $cholamandlam['tl_name'] ?></option></select></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control"  value="<?php echo $cholamandlam['call_duration'] ?>" disabled></td>
									
									</tr>
									<tr>
									<td>Track ID:</td>
										<td><input type="text" class="form-control"  value="<?php echo $cholamandlam['track_id']	; ?>" disabled ></td>
									<td>Mobile No:</td>
										<td><input type="text" class="form-control" name=data[mobile_no] value="<?php echo $cholamandlam['mobile_no']; ?>" disabled></td>	
									<td>Language:</td>
										<td><input type="text" class="form-control" name=data[language] value="<?php echo $cholamandlam['language']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $cholamandlam['audit_type'] ?></option></select></td>
										<td>Week</td>
										<td>
										<select class="form-control"  name="data[week]" disabled>
											<option value="<?php echo $cholamandlam['week'] ?>"><?php echo $cholamandlam['week'] ?></option>
										</select>
									</td>	
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $cholamandlam['voc'] ?></option></select></td>
										
									</tr>
									<tr>
									<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" class="form-control" style="font-weight:bold" value="<?php echo $cholamandlam['overall_score'] ?>" disabled></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D2B4DE">
										<td>PARAMETER</td>
										<td colspan=2>SUB PARAMETER</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>
									<tr>
										<td class="eml" rowspan=5>Call Opening</td>
										<td colspan=2>Appropriate Greeting/Time taken to Greet</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[appropriate_greeting]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['appropriate_greeting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['appropriate_greeting'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['appropriate_greeting'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td rowspan=5 colspan=2><textarea name="data[call_opening_comment]" class="form-control" disabled><?php echo $cholamandlam['call_opening_comment'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Self & Company Intro</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF1" name="data[self_company]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['self_company'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['self_company'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['self_company'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">RPC - Right Party Contact</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF2" name="data[rpc]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['rpc'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['rpc'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['rpc'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
									<td colspan=2>Language Adherence</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[language_adherence]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['language_adherence'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['language_adherence'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['language_adherence'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									
									<tr>
									<td colspan=2 style="color:#FF0000">Purpose of call</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF3" name="data[purpose]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['purpose'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['purpose'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['purpose'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									
									<tr>
										<td class="eml" rowspan=13>Process Knowledge</td>
										<td colspan=2>Giving correct relevant information/ commitment</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF4" name="data[relevant_information]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['relevant_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['relevant_information'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['relevant_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td rowspan=13 colspan=2><textarea name="data[process_knowledge_comment]" class="form-control" disabled><?php echo $cholamandlam['process_knowledge_comment'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 style="color:#FF0000">Address & Landmark Confirmation</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF5" name="data[address_landmark]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['address_landmark'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['address_landmark'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['address_landmark'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Alternate Ph # & Cont person</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[alt_phone]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['alt_phone'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['alt_phone'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['alt_phone'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Date & Time </td>
										<td>
											<select class="form-control cholamandlam_points" name="data[dates_times]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['dates_times'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['dates_times'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['dates_times'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Amount confirmation + Overdue Charges amount(fatal)</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF6" name="data[overdue_charges]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam['overdue_charges'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam['overdue_charges'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['overdue_charges'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Mininum Charges amount 1500 Rs/- to be pitched on call </td>
										<td>
											<select class="form-control cholamandlam_points" name="data[minimum_charges]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['minimum_charges'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['minimum_charges'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['minimum_charges'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Chola App & Online payment Promotion</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF7" name="data[payment_promotion]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['payment_promotion'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['payment_promotion'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['payment_promotion'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Previous interaction to be pitched on follow up calls</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[follow_up_call]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=10 <?php echo $cholamandlam['follow_up_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=10 <?php echo $cholamandlam['follow_up_call'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['follow_up_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Proactive Information</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF8" name="data[proactive_information]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['proactive_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['proactive_information'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['proactive_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Mode of payment confirmation</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[payment_mode]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['payment_mode'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['payment_mode'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['payment_mode'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Payment details confirmation</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[payment_details]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['payment_details'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['payment_details'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['payment_details'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Effective Probing</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[effective_probing]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['effective_probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['effective_probing'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['effective_probing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Exhibits good knowledge on product and process</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[product_process]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['product_process'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['product_process'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['product_process'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>

									<tr>
										<td class="eml" rowspan=4>Negotiation Skill</td>
										<td colspan=2>Exhibits call control and ownership</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[control_ownership]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['control_ownership'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['control_ownership'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['control_ownership'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td rowspan=4 colspan=2><textarea name="data[negotiation_skill_comment]" class="form-control" disabled><?php echo $cholamandlam['negotiation_skill_comment'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Creates urgency & Educates customer on charges</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[educates_customer]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=10 <?php echo $cholamandlam['educates_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=10 <?php echo $cholamandlam['educates_customer'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['educates_customer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Pickup/Showroom confirmation</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF9" name="data[pickup_showroom]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['pickup_showroom'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['pickup_showroom'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['pickup_showroom'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Exhibits negotiation skills as per customer profiling</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[negotiation_skills]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['negotiation_skills'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['negotiation_skills'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['negotiation_skills'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
									<tr>
										<td class="eml" rowspan=7></td>
										<td colspan=2>Dead Air/Mute/Proper hold procedure</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[hold_procedure]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['hold_procedure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['hold_procedure'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['hold_procedure'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td rowspan=7 colspan=2><textarea name="data[forth_comment]" class="form-control"><?php echo $cholamandlam['forth_comment'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2>Thanking/Empathy/Apology</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[thanking]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['thanking'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['thanking'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['thanking'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Active Listening/Interruption</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[listening_interruption]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['listening_interruption'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['listening_interruption'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['listening_interruption'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Enthusiasm /Self confidence</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[enthusiasm]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['enthusiasm'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['enthusiasm'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['enthusiasm'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Maintains  Professionalism</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[professionalism]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['professionalism'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['professionalism'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['professionalism'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Phone Etiquettes</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[phone_etiquettes]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['phone_etiquettes'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['phone_etiquettes'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['phone_etiquettes'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Speech Clarity/Rate of Speech</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[speech_clarity]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['speech_clarity'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['speech_clarity'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['speech_clarity'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Call Closure</td>
										<td colspan=2>Summarization</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[summarization]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['summarization'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['summarization'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['summarization'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td rowspan=3 colspan=2><textarea name="data[call_closure_comment]" class="form-control" disabled><?php echo $cholamandlam['call_closure_comment'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Receipt Details & Not to share Bank details Awareness Script was informed during closing</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF10" name="data[receipt_details]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['receipt_details'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['receipt_details'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['receipt_details'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Proper Call closure</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[call_closure]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['call_closure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['call_closure'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['call_closure'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>System Knowledge</td>
										<td colspan=2 style="color:#FF0000">Documentation/Tagging</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF11" name="data[documentation]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['documentation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['documentation'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['documentation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td rowspan=2 colspan=2><textarea name="data[system_knowledge_comment]" class="form-control" disabled><?php echo $cholamandlam['system_knowledge_comment'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Disposition</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF12" name="data[disposition]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['disposition'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $cholamandlam['disposition'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['disposition'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td class="eml" rowspan=1>ZTP</td>
										<td colspan=2 style="color:#FF0000">Zero Tolerance Policy</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF13" name="data[tolerance_policy]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['tolerance_policy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=2 <?php echo $cholamandlam['tolerance_policy'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['tolerance_policy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td rowspan=1 colspan=2><textarea name="data[ztp_comment]" class="form-control" disabled><?php echo $cholamandlam['ztp_comment'] ?> </textarea></td>
									</tr>
									<tr>
										<td>Correct Disposition</td>
										<td><input type="text" class="form-control" name="data[correct_disposition]" value="<?php echo $cholamandlam['correct_disposition'] ?>" required></td>
										<td>Disposition selected by agent</td>
										<td><input type="text" class="form-control" name="data[disposition_agent]" value="<?php echo $cholamandlam['disposition_agent'] ?>" required></td>
										<td>Wrong Disposition -Failure Remarks</td>
										<td><input type="text" class="form-control" name="data[failure_remarks]" value="<?php echo $cholamandlam['failure_remarks'] ?>" required></td>
									</tr>
									<tr>
										<td>Maintain Professionalism - Failure Reason</td>
										<td><input type="text" class="form-control" name="data[failure_reason]" value="<?php echo $cholamandlam['failure_reason'] ?>" required></td>
										<td>Standard call opening Adherence</td>
										<td><input type="text" class="form-control" name="data[standard_call]" value="<?php echo $cholamandlam['standard_call'] ?>" required></td>
										<td>Pick up call validation</td>
										<td><input type="text" class="form-control" name="data[call_validation]" value="<?php echo $cholamandlam['call_validation'] ?>" required></td>
									<tr>
										<td>EMI Amount Confirmation</td>
										<td><input type="text" class="form-control" name="data[emi_amount]" value="<?php echo $cholamandlam['emi_amount'] ?>" required></td>
										<td>Address Confirmation</td>
										<td><input type="text" class="form-control" name="data[address]" value="<?php echo $cholamandlam['address'] ?>" required></td>
										<td>Invalid Pickup Remarks (If any)</td>
										<td><input type="text" class="form-control" name="data[pickup_remarks]" value="<?php echo $cholamandlam['pickup_remarks'] ?>" required></td>
									</tr>

								
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $cholamandlam['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $cholamandlam['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($cholamandlam['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$cholamandlam['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_cholamandlam/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_cholamandlam/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $cholamandlam['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $cholamandlam['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $cholamandlam['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $cholamandlam['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $cholamandlam['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($cholamandlam['entry_date'],72) == true){ ?>
											<tr>
												<?php if($cholamandlam['agent_rvw_note']==''){ ?>
													<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>
									
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
