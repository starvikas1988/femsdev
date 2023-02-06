
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
/* new view Rajay */
.new-qa .form-control{
border-radius:1px!important;
}
.new-qa .form-control:focus,.new-qa  .form-control:active {
    border-color: #5b73f5!important;
  
}

.new-qa .btn-new{
	width: 150px;
    padding: 12px;
    border-radius: 0px;
}
/* end */
</style>


<div class="wrap">
	<section class="app-content new-qa">


		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table  skt-table" width="100%">
								<tbody>
									<tr><td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #3f5691 ; color:#fff;">Myglamm CQ sheet</td></tr>
									
									<tr>
										<td style="width:16%;">Auditor Name:</td>
										<?php if($myglam['entry_by']!=''){
												$auditorName = $myglam['auditor_name'];
											}else{
												$auditorName = $myglam['client_name'];
										} ?>
										<td style="width:20%;"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($myglam['audit_date']); ?>" disabled></td>
										<td>Chat Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($myglam['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td><select class="form-control" disabled><option><?php echo $myglam['fname']." ".$myglam['lname'] ?></option></select></td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $myglam['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td><select class="form-control" disabled><option><?php echo $myglam['tl_name'] ?></option></select></td>
									</tr>
									<tr>
										<td>Chat Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $myglam['call_duration'] ?>" disabled ></td>
										<td>Objection:</td>
										<td>
											<input type="text" class="form-control" name="data[objection]" value="<?php echo $myglam['objection'] ?>" disabled>
										</td>
										<td>Campaign:</td>
										<td>
											<select class="form-control" name="data[campaign]" disabled>
												<option value="<?php echo $myglam['campaign'] ?>"><?php echo $myglam['campaign'] ?></option>
												<option value="">-Select-</option>
												<option value="BA">BA</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td>Chat ID:</td>
										<td>
											<input type="text" class="form-control" name="data[chat_id]" value="<?php echo $myglam['chat_id'] ?>" disabled>
										</td>
										<td>Product:</td>
										<td>
											<select class="form-control" name="data[Product]" disabled>
												<option value="<?php echo $myglam['Product'] ?>"><?php echo $myglam['Product'] ?></option>
												<option value="">-Select-</option>								<option value="Skin">Skin</option>
												<option value="Hair">Hair</option>
												<option value="Makeup">Makeup</option>
												<option value="Personal Care">Personal Care</option>
												<option value="Others">Others</option>
											</select>
										</td>
										<td>Customer VOC:</td>
										<td><input type="text" class="form-control" name="data[customer_voc]" value="<?php echo $myglam['customer_voc'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Disposition:</td>
										<td><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $myglam['agent_disposition'] ?>" disabled></td>
										<td>QA Disposition:</td>
										<td><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $myglam['qa_disposition'] ?>" disabled></td>
									</tr>
									
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $myglam['audit_type'] ?></option></select></td>
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $myglam['voc'] ?></option></select></td>
										<td style="font-weight:bold; font-size:16px">Overall Score:</td>
										<td ><input type="text" disabled class="form-control" style="font-weight:bold" value="<?php echo $myglam['overall_score'] ?>"></td>
									</tr>
									<tr style=" font-weight:bold;background-color: #dce3eb;">
										<td>Sub-Parameter</td>
										<td>Points</td>
										<td>Score</td>
										<td>Legend</td>
										<td colspan=2>Remarks</td>
									</tr>

									<tr>
										<td class="eml1" colspan=8 style="background-color:#3f5691; color: white;">Opening & Identification</td>
									</tr>
									</tr>
									<tr>
										<td colspan=2>Did the Advisor open the chat correctly?</td>
										<td>3</td>
										<td>
											<select class="form-control safe_point" name="data[chat_correctly]" disabled>
												
												<option safe_val=3 <?php echo $myglam['chat_correctly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['chat_correctly'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $myglam['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor greet the client in a timely manner? (Under 30 secs)</td>
										<td>3</td>
										
										<td>
											<select class="form-control safe_point" name="data[timely_manner]" disabled>
												
												<option safe_val=3 <?php echo $myglam['timely_manner'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['timely_manner'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $myglam['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 >Did the Advisor seek permission from customer to keep the chat on hold and showed presence to keep conversation active?</td>
										<td >3</td>
										
										<td>
											<select class="form-control safe_point" name="data[conversation_active]" disabled>
												
												<option safe_val=3 <?php echo $myglam['conversation_active'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['conversation_active'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['conversation_active'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>  
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $myglam['cmt3'] ?>"></td>
									</tr>

									<tr>
										<td class="eml1" colspan=8 style="background-color:#3f5691; color: white;">Chat - Query/Objection/Concern - Handling</td>
									</tr>
									<tr>
										<td colspan=2>Did the Advisor understand the customer query/concern/used relevant probing / fact finding questions to understand customer</td>
										<td>5</td>
										
										<td>
											<select class="form-control safe_point" name="data[understand_customer]" disabled>
												
												<option safe_val=5 <?php echo $myglam['understand_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=5 <?php echo $myglam['understand_customer'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['understand_customer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $myglam['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor ask for a budget preferance before recommending?</td>
										<td>3</td>
										
										<td>
											<select class="form-control safe_point " name="data[budget_preferance]" disabled>
												
												<option safe_val=3 <?php echo $myglam['budget_preferance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['budget_preferance'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $myglam['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did Advisor edit /use relevant canned responses?</td>
										<td>2</td>
										
										<td>
											<select class="form-control safe_point " name="data[canned_responses]" disabled>
												
												<option safe_val=2 <?php echo $myglam['canned_responses'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=2 <?php echo $myglam['canned_responses'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $myglam['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the Advisor provide correct/complete information to resolve customers' query/concern?</td>
										<td>5</td>
										
										<td>
											<select class="form-control safe_point " name="data[query_concern]" disabled>
												
												<option safe_val=5 <?php echo $myglam['query_concern'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=5 <?php echo $myglam['query_concern'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['query_concern'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $myglam['cmt7'] ?>"></td>
									</tr>

									<tr>
										<td class="eml1" colspan=8 style="background-color:#3f5691; color: white;">Communication & Soft Skills</td>
									</tr>

								    <tr>
										<td colspan=2>Did the Advisor use upfront Empathy/Apology and acknowledgement of query or complaint</td>
										<td>4</td>
										
										<td>
											<select class="form-control safe_point " name="data[Communication1]" disabled>
												
												<option safe_val=4 <?php echo $myglam['Communication1'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=4 <?php echo $myglam['Communication1'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['Communication1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $myglam['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the Advisor make personalize chat & Personalization wherever required?</td>
										<td>3</td>
										
										<td>
											<select class="form-control safe_point" name="data[Communication2]" disabled>
												
												<option safe_val=3 <?php echo $myglam['Communication2'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['Communication2'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $myglam['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the Advisor use accurate Sentence formation, Grammar, Punctuation, Tenses, Spellings, avoid usage of jargons & correct choice of words during chat?</td>
										<td>5</td>
										
										<td>
											<select class="form-control safe_point" name="data[Communication3]" disabled>
												
												<option safe_val=5 <?php echo $myglam['Communication3'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=5 <?php echo $myglam['Communication3'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $myglam['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the Advisor switch the language as per the requirement?</td>
										<td>3</td>
										
										<td>
											<select class="form-control safe_point" name="data[Communication4]" disabled>
												
												<option safe_val=3 <?php echo $myglam['Communication4'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['Communication4'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['Communication4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $myglam['cmt11'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor recommend the correct product as per the concern?</td>
										<td>7</td>
										
										<td>
											<select class="form-control safe_point" name="data[Communication5]" disabled>
												
												<option safe_val=7 <?php echo $myglam['Communication5'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=7 <?php echo $myglam['Communication5'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['Communication5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $myglam['cmt12'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor attempt for upselling?</td>
										<td>6</td>
										
										<td>
											<select class="form-control safe_point" name="data[Communication6]" disabled>
												
												<option safe_val=6 <?php echo $myglam['Communication6'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=6 <?php echo $myglam['Communication6'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['Communication6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $myglam['cmt13'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor share UTM link/correct UTM link?</td>
										<td>3</td>
										
										<td>
											<select class="form-control safe_point" id="tvsAF1" name="data[Communication7]" disabled>
												
												<option safe_val=3 <?php echo $myglam['Communication7'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['Communication7'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $myglam['cmt14'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor help the customer with the product coupon code after product recommendation?</td>
										<td>5</td>
										
										<td>
											<select class="form-control safe_point" id="tvsAF1" name="data[Communication8]" disabled>
												
												<option safe_val=5 <?php echo $myglam['Communication8'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=5 <?php echo $myglam['Communication8'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['Communication8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $myglam['cmt15'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor share relevant benefits of product?</td>
										<td>3</td>
										
										<td>
											<select class="form-control safe_point" id="tvsAF1" name="data[Communication9]" disabled>
												
												<option safe_val=3 <?php echo $myglam['Communication9'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['Communication9'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['Communication9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $myglam['cmt16'] ?>"></td>
									</tr>

									<tr>
										<td class="eml1" colspan=8 style="background-color:#3f5691; color: white;">Documentation</td>
									</tr>

									<tr>
										<td colspan=2>Did the Advisor use the correct disposition/Tagging as per the conversation along with remarks?</td>
										<td>5</td>
										
										<td>
											<select class="form-control safe_point" id="tvsAF1" name="data[Documentation1]" disabled>
												
												<option safe_val=5 <?php echo $myglam['Documentation1'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=5 <?php echo $myglam['Documentation1'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $myglam['cmt17'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the Advisor inform the correct TAT?</td>
										<td>3</td>
										
										<td>
											<select class="form-control safe_point" id="tvsAF1" name="data[Documentation2]" disabled>
												
												<option safe_val=3 <?php echo $myglam['Documentation2'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['Documentation2'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['Documentation2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $myglam['cmt18'] ?>"></td>
									</tr>

									<tr>
										<td class="eml1" colspan=8 style="background-color:#3f5691; color: white;">Closing</td>
									</tr>

									<tr>
										<td colspan=2>Did the Advisor ask for Further assistance</td>
										<td>3</td>
										
										<td>
											<select class="form-control safe_point" id="tvsAF1" name="data[Closing1]" disabled>
												
												<option safe_val=3 <?php echo $myglam['Closing1'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['Closing1'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['Closing1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $myglam['cmt19'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 style="color: red;">Did the adviser keep the chat open for more than five minutes?</td>
										<td>5</td>
										
										<td>
											<select class="form-control safe_point" id="netmedsAF5" name="data[Closing2]" disabled>
												
												<option safe_val=5 <?php echo $myglam['Closing2'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=5 <?php echo $myglam['Closing2'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $myglam['cmt20'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the Advisor close the chat properly/ followed the closing procedure</td>
										<td>5</td>
										
										<td>
											<select class="form-control safe_point" id="tvsAF1" name="data[Closing3]" disabled>
												
												<option safe_val=5 <?php echo $myglam['Closing3'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=5 <?php echo $myglam['Closing3'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $myglam['cmt21'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor share the reference link macro with the links?</td>
										<td>3</td>
										
										<td>
											<select class="form-control safe_point"  name="data[Closing4]" disabled>
												
												<option safe_val=3 <?php echo $myglam['Closing4'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['Closing4'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['Closing4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $myglam['cmt22'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor assist the client with the current event as per the calendar sheet shared?</td>
										<td>3</td>
										
										<td>
											<select class="form-control safe_point"  name="data[Closing5]" disabled>
												
												<option safe_val=3 <?php echo $myglam['Closing5'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=3 <?php echo $myglam['Closing5'] == "No"?"selected":"";?> value="No">No</option>
												<option safe_val=0 <?php echo $myglam['Closing5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $myglam['cmt23'] ?>"></td>
									</tr>
									
									<tr>
										<td class="eml1" colspan=8 style="background-color:#3f5691; color: white;">Wrong Practices</td>
									</tr>

									<tr>
										<td colspan=2 style="color: red;">No instance of chat avoidance or wrong practice followed?</td>
										<td>5</td>
										
										<td>
											<select class="form-control safe_point" id="netmedsAF6" name="data[Practices1]" disabled>
												
												<option safe_val=5 <?php echo $myglam['Practices1'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=5 <?php echo $myglam['Practices1'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $myglam['cmt24'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 style="color: red;">The Advisor was unprofessional during chat? ( rude /offensive /sarcastic / unethical words not used</td>
										<td>5</td>
										
										<td>
											<select class="form-control safe_point" id="netmedsAF7" name="data[Practices2]" disabled>
												
												<option safe_val=5 <?php echo $myglam['Practices2'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option safe_val=5 <?php echo $myglam['Practices2'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt25]" class="form-control" value="<?php echo $myglam['cmt25'] ?>"></td>
									</tr>


									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $myglam['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $myglam['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($myglam['attach_file']!=''){ ?>
										<tr oncontextmenu="return false;">
											<td colspan="2">Audio Files</td>
											<td colspan="4">
												<?php $attach_file = explode(",",$myglam['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_myglam/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_myglam/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $myglam['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $myglam['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $myglam['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $myglam['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required=""><?php echo $myglam['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($myglam['entry_date'],72) == true){ ?>
											<tr>
												<?php if($myglam['agent_rvw_note']==''){ ?>
													<td colspan="6"><button class="btn btn-success waves-effect btn-new" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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
