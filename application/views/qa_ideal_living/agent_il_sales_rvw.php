<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
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
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader">Ideal Living [SALES]</td></tr>
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $sales_data['auditor_name']; ?>" disabled></td>
										<td>Evaluation Date:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo mysql2mmddyy($sales_data['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td style="width:250px"><input type="text" class="form-control" id="" name="" value="<?php echo mysql2mmddyy($sales_data['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td style="width:250px">
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['fname']." ".$sales_data['lname'] ?></option>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $sales_data['fusion_id']; ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['tl_name'] ?></option>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Product:</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['product'] ?></option>
											</select>
										</td>
										<td>Call Type:</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['call_type'] ?></option>
											</select>
										</td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $sales_data['call_duration']; ?>" disabled></td>
									</tr>
									<tr>
										<td>QA Type:</td>
										<td>
											<select class="form-control" id="" name="qa_type" disabled>
												<option><?php echo $sales_data['qa_type'] ?></option>
											</select>
										</td>
										<td>Audit Type:</td>
										<td>
											<select class="form-control eml" id="" name="" disabled>
												<option><?php echo $sales_data['audit_type'] ?></option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control eml" id="" name="" disabled>
												<option><?php echo $sales_data['voc'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Recording ID:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $sales_data['recording_id']; ?>" disabled></td>
										<td>Disposition:</td>
										<td>
											<select class="form-control eml" id="" name="" disabled>
												<option><?php echo $sales_data['disposition'] ?></option>
											</select>
										</td>
										<td>Correct Disposition:</td>
										<td>
											<select class="form-control eml" id="" name="" disabled>
												<option><?php echo $sales_data['correct_disposition'] ?></option>
											</select>
										</td>
										
									</tr>
									<tr>
									<td>Can be Automated:</td>
										<td>
											<select class="form-control" disabled>
												<option value="">-Select-</option>
												<option <?php echo $sales_data['can_automated']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $sales_data['can_automated']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td style="font-weight:bold">Auto Fail:</td>
										<td>
											<select class="form-control il_point" id="ilsales_AF" name="auto_fail" disabled>
												<option value="">-Select-</option>
												<option il_val=0 <?php echo $sales_data['auto_fail']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option il_val=0 <?php echo $sales_data['auto_fail']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan= style="text-align:right">Overall Score</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $sales_data['overall_score']; ?>" disabled></td>
									</tr>
									<tr style="background-color:#AED6F1; font-size:15px; font-weight:bold">
										<td colspan=2>Parameters</td>
										<td colspan=3>Description</td>
										<td>Score</td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#F6DDCC">Sales Skills</td>
										<td>Greeting</td>
										<td colspan=3>Agent greets caller with a happy and friendly voice and tone. Mentions caller's name, the campaign name and lets caller know the call will be recorded</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['greeting'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Probing Question</td>
										<td colspan=3>Agent must ask the required probing questions to know the needs and reasons why the caller called to us, we have to let the caller express their needs, so we can  present  the offer and highlight the benefits of the product the offer and highlight the benefits of the product  in a presonalized way in order to adapt the product to customer needs and concerns.</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['probing_question'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Product Benefit</td>
										<td colspan=3>The agent connects the product benefits to the solutions for the caller based on their needs. Builds the product value beyond price</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['product_benefit'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Closing the Sales</td>
										<td colspan=3>Agent recognizes the signals of purchase and makes closings, these must be with confidence and after mentioning main offer, rebuttals and answer questions</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['close_the_sale'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Rebuttals</td>
										<td colspan=3>Agent handles and reads ALL rebuttals and provides a solution, removes obstacles in the way to guide a purchase decision at that time. rebuttals should be based on the needs of the caller</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['rebuttals'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#BFC9CA">Soft Skills</td>
										<td>Rapport / Empathy</td>
										<td colspan=3>Agent builds a personal relationship with the caller like talking to a friend, creates interest and trust. And provides and emotional connection by letting the caller know they understand the caller's feelings</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['rapport'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Product Knowledge</td>
										<td colspan=3>The agent is an expert with the product knowledge and FAQ. Answers all questions accurately and educates the caller on the product benefits</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['product_knowledge'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Speed / Clarity</td>
										<td colspan=3>The agent speaks with a strong steady speed or pace. Not to Fast and Not to Slow, The agent voice is clear and can be understood throughout the call</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['speed_clarity'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Professional ethics / Emotional Intelligence</td>
										<td colspan=3>The agent always respects and listens to the caller, does not interrupt the caller. The agent is honest and ethical. Controls their emotions and is not rude to the caller</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['professional_ethics'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Enthusiasm / Passion About Selling</td>
										<td colspan=3>The agent sounds happy, excited and has energy when speaking to the caller. It is easy to see they love their job and selling the product</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['passion_selling'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#A9DFBF">Script Adherence</td>
										<td>Main Offers Compliance</td>
										<td colspan=3>Agent sticks to the script, mentions main offer details and prices and continuities correctly</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['main_offers'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Upsells Compliance</td>
										<td colspan=3>Agent sticks to the script, mentions upsell details and prices and continuities correctly</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['upsell_compliance'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Prepays Compliance</td>
										<td colspan=3>Agent reads prepay as scripted, speaks clearly with good pace-not too fast, and gets valid confirmation (Yes, Agree, Ok, etc…)</td>
										<td>
										<!-- <td>Prepays / Platinum</td>
										<td colspan=3>Agent reads Main D  offer  or prepay option as scripted, speaks clearly with good pace-not too fast, and gets valid confirmation</td>
										<td> -->
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['prepays_compliance'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Legal Terms / Confirmation Compliance</td>
										<td colspan=3>Agent confirms with  the caller what  they ordered, future charges, legal terms and took data correctly (this must be clear and with good pace)</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['legal_terms'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Third party separation Compliance</td>
										<td colspan=3>Agent correctly separates the sale of the clubs "now completely/totally apart from your order ....follows the script</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['third_party_separation'] ?></option>
											</select>
										</td>
									</tr>

									<!-- <tr>
										<td rowspan=3 style="background-color:#F9E79F">ABC Process</td>
										<td>Acknowledge</td>
										<td colspan=3>Show the customer that they’re being listened to and that you want to keep talking to them</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['acknowledge'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Build Value</td>
										<td colspan=3>Explain the customer how the product will fulfill their needs and give them a real value of the product</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['build_value'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Close the Sale</td>
										<td colspan=3>Always close try to close the sales after answer a customer questions</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $sales_data['sale_close'] ?></option>
											</select>
										</td>
									</tr> -->

									<tr>
										<td colspan=2>Call Summary:</td>
										<td colspan=4><textarea class="form-control" disabled><?php echo $sales_data['call_summary'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Feedback:</td>
										<td colspan=4><textarea class="form-control" disabled><?php echo $sales_data['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($sales_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan=2>Audio Files</td>
										<td colspan=4>
											<?php $attach_file = explode(",",$sales_data['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_ideal_living/sales/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_ideal_living/sales/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td colspan=2 style="font-size:16px">Manager Review:</td> <td colspan=4 style="text-align:left"><?php echo $sales_data['mgnt_rvw_note'] ?></td></tr>
									<tr><td colspan=2 style="font-size:16px">Client Review:</td> <td colspan=4 style="text-align:left"><?php echo $sales_data['client_rvw_note'] ?></td></tr>	
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
									   <input type="hidden" name="salesid" class="form-control" value="<?php echo $salesid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $sales_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $sales_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2  style="font-size:16px">Your Review</td>
											<td colspan=4>
												<textarea class="form-control" <?php //echo $disable; ?> name="note" required><?php echo $sales_data['agent_rvw_note'] ?></textarea>
											</td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($sales_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($sales_data['agent_rvw_date']==''){ ?>
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
