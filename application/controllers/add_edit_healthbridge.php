<style>
   .table > tbody > tr > td{
   text-align: center;
   font-size:13px;
   }
   #theader{
   font-size:20px;
   font-weight:bold;
   background-color:#95A5A6;
   }
   .eml{
   font-weight:bold;
   background-color:#AED6F1;
   }
</style>
<?php if($hcpss_id!=0){
   if(is_access_qa_edit_feedback()==false){ ?>
<style>
   .form-control{
   pointer-events:none;
   background-color:#D5DBDB;
   }
</style>
<?php }
   } ?>
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
                              <tr>
                                 <td colspan="6" id="theader" style="font-size:40px">Health Bridge - Healthcare Quality Guidelines</td>
                                 <input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
                              </tr>
                              <?php
                                 if($hcpss_id==0){
                                 	$auditorName = get_username();
                                 	$auditDate = CurrDateMDY();
                                 	$clDate_val='';
                                 }else{
                                 	if($healthbridge['entry_by']!=''){
                                 		$auditorName = $healthbridge['auditor_name'];
                                 	}else{
                                 		$auditorName = $healthbridge['client_name'];
                                 	}
                                 	$auditDate = mysql2mmddyy($healthbridge['audit_date']);
                                 	$clDate_val = mysql2mmddyy($healthbridge['call_date']);
                                 }
                                 ?>
                              <tr>
                                 <td style="width:150px">Auditor Name:</td>
                                 <td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
                                 <td>Audit Date:</td>
                                 <td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
                                 <td>Call Date:</td>
                                 <td style="width:150px"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required ></td>
                              </tr>
                              <tr>
                                 <td>Agent:</td>
                                 <td>
                                    <select class="form-control" id="agent_id" name="data[agent_id]" required >
                                       <option value="<?php echo $healthbridge['agent_id'] ?>"><?php echo $healthbridge['fname']." ".$healthbridge['lname']." - ".$healthbridge['fusion_id'] ?></option>
                                       <option value="">-Select-</option>
                                       <?php foreach($agentName as $row):  ?>
                                       <option value="<?php echo $row['id']; ?>"><?php echo $row['name']." - ".$row['fusion_id']; ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </td>
                                 <td>Process:</td>
                                 <td><input type="text" class="form-control" id="campaign" value="<?php echo $healthbridge['process'] ?>" readonly ></td>
                                 <td>L1 Supervisor:</td>
                                 <td>
                                    <select class="form-control" id="tl_id" name="data[tl_id]" readonly>
                                       <option value="<?php echo $healthbridge['tl_id'] ?>"><?php echo $healthbridge['tl_name'] ?></option>
                                       <option value="">--Select--</option>
                                       <?php foreach($tlname as $tl): ?>
                                       <option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Site/Location:</td>
                                 <td><input type="text" readonly class="form-control" id="office_id" value="<?php echo $healthbridge['office_id'] ?>"></td>
                                 <td>Call Duration:</td>
                                 <td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $healthbridge['call_duration']; ?>" required ></td>
                                 <td>File No:</td>
                                 <td><input type="text" class="form-control" id="" name="data[file_no]" value="<?php echo $healthbridge['file_no']; ?>" required ></td>
                              </tr>
                              <tr>
                                 <td>Audit Type:</td>
                                 <td>
                                    <select class="form-control" id="audit_type" name="data[audit_type]" required >
                                       <option value="">-Select-</option>
                                       <option <?php echo $healthbridge['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
                                       <option <?php echo $healthbridge['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
                                       <option <?php echo $healthbridge['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
                                       <option <?php echo $healthbridge['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
                                       <option <?php echo $healthbridge['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
									   <option <?php echo $healthbridge['audit_type']=='WOW Call'?"selected":""; ?> value="WOW Call">WOW Call</option>
                                       <?php if(get_login_type()!="client"){ ?>
                                       <option <?php echo $healthbridge['audit_type']=='Operation Audit'?"selected":""; ?> value="Operation Audit">Operation Audit</option>
                                       <option <?php echo $healthbridge['audit_type']=='Trainer Audit'?"selected":""; ?> value="Trainer Audit">Trainer Audit</option>
                                       <?php } ?>
                                    </select>
                                 </td>
                                 <td class="auType">Auditor Type</td>
                                 <td class="auType">
                                    <select class="form-control" id="auditor_type" name="data[auditor_type]">
                                       <option value="">-Select-</option>
                                       <option value="Master">Master</option>
                                       <option value="Regular">Regular</option>
                                    </select>
                                 </td>
                                 <td>VOC:</td>
                                 <td>
                                    <select class="form-control" id="voc" name="data[voc]" required >
                                       <option value="">-Select-</option>
                                       <option <?php echo $healthbridge['voc']=='1'?"selected":""; ?> value="1">1</option>
                                       <option <?php echo $healthbridge['voc']=='2'?"selected":""; ?> value="2">2</option>
                                       <option <?php echo $healthbridge['voc']=='3'?"selected":""; ?> value="3">3</option>
                                       <option <?php echo $healthbridge['voc']=='4'?"selected":""; ?> value="4">4</option>
                                       <option <?php echo $healthbridge['voc']=='5'?"selected":""; ?> value="5">5</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                              	<td style="font-weight:bold; font-size:16px">Possible Score</td>
                                 <td><input type="text" readonly id="healthbridge_possible" name="data[possible_score]" class="form-control" value="<?= $healthbridge['possible_score']?>" style="font-weight:bold"></td>

                                 <td style="font-weight:bold; font-size:16px">Earned Score</td>
                                 <td><input type="text" readonly id="healthbridge_earned" name="data[earned_score]" class="form-control" value="<?= $healthbridge['earned_score']?>" style="font-weight:bold"></td>                               
 	                             <td style="font-weight:bold; font-size:16px">Overall Score:</td>
                                 <td><input type="text" readonly id="healthbridge_overall_score" name="data[overall_score]" class="form-control" value="<?= $healthbridge['overall_score']?>%" style="font-weight:bold"></td>
                              </tr>
                              <tr style="height:25px; font-weight:bold">
                                 <td colspan=3></td>
                                 <td>RATING</td>
                                 <td colspan=2>COMMENTS/NOTES</td>
                              </tr>
                              <tr>
                                 <td class="eml" colspan=6>Accuracy</td>
                              </tr>
                              <tr>
                                 <td style="text-align:left;" colspan=3>1.1 Correct Information provided regarding account details, benefit, information, plan, etc</td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[correct_information]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['correct_information']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['correct_information']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['correct_information']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $healthbridge['cmt1']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left;" colspan=3>1.2 Resolved all member concerns or questions. </td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[resolved_all]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['resolved_all']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['resolved_all']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['resolved_all']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $healthbridge['cmt2']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left;" colspan=3>1.3 Added detailed notes to the member account. </td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[added_detailed]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['added_detailed']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['added_detailed']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['added_detailed']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $healthbridge['cmt3']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left" colspan=3>1.4 Disposition the call appropriately.</td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[disposition_the]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['disposition_the']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['disposition_the']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['disposition_the']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $healthbridge['cmt4']; ?>"></td>
                              </tr>
                              <tr>
                                 <td class="eml" colspan="6">Adherence to Company Policies</td>
                              </tr>
                              <tr>
                                 <td style="text-align:left" colspan=3>2.1 Verified the member's name, last 4 SS#, DOB, and zipcode. </td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[verified_the]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['verified_the']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['verified_the']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['verified_the']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $healthbridge['cmt5']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left" colspan=3>2.2 Used the verification button. </td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[used_the_verification]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['used_the_verification']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['used_the_verification']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['used_the_verification']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $healthbridge['cmt6']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left;" colspan=3>2.3 Followed all company procedures, guidelines, and policies.</td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[followed_all_company]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['followed_all_company']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['followed_all_company']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['followed_all_company']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $healthbridge['cmt7']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left;" colspan=3>2.4 Informed the member of call recording (OUTBOUND ONLY)</td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[informed_the_member]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['informed_the_member']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['informed_the_member']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['informed_the_member']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $healthbridge['cmt8']; ?>"></td>
                              </tr>
                              <tr>
                                 <td class="eml" colspan=6>Soft Skills</td>
                              </tr>
                              <tr>
                                 <td style="text-align:left" colspan=3>3.1 Proper Greeting and Closing was used including name, company, and name. </td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[proper_greeting]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=5 healthbridge_max_val=5 <?php echo $healthbridge['proper_greeting']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=3 healthbridge_max_val=5 <?php echo $healthbridge['proper_greeting']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=2.5 healthbridge_max_val=5 <?php echo $healthbridge['proper_greeting']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $healthbridge['cmt9']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left" colspan=3>3.2 Clear communication, active listening, call control, and efficiency was demonstrated throughout the call. </td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[clear_communication]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=5 healthbridge_max_val=5 <?php echo $healthbridge['clear_communication']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=3 healthbridge_max_val=5 <?php echo $healthbridge['clear_communication']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=2.5 healthbridge_max_val=5 <?php echo $healthbridge['clear_communication']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $healthbridge['cmt10']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left" colspan=3>3.3 Proper expectations were set, empathetic, pleasant voice tone, and positive attitude during the call. </td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[proper_expectations]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=5 healthbridge_max_val=5 <?php echo $healthbridge['proper_expectations']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=3 healthbridge_max_val=5 <?php echo $healthbridge['proper_expectations']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=2.5 healthbridge_max_val=5 <?php echo $healthbridge['proper_expectations']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $healthbridge['cmt11']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left" colspan=3>3.4 Avoided industry jargon, excessive hold time, dead air, slang, interruptions, or self talk.</td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[avoided_industry]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=5 healthbridge_max_val=5 <?php echo $healthbridge['avoided_industry']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=3 healthbridge_max_val=5 <?php echo $healthbridge['avoided_industry']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=2.5 healthbridge_max_val=5 <?php echo $healthbridge['avoided_industry']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $healthbridge['cmt12']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left" colspan=3>3.5 Verified current address, preffered phone number and email address. </td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[verified_current_address]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=5 healthbridge_max_val=5 <?php echo $healthbridge['verified_current_address']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=3 healthbridge_max_val=5 <?php echo $healthbridge['verified_current_address']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=2.5 healthbridge_max_val=5 <?php echo $healthbridge['verified_current_address']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $healthbridge['cmt13']; ?>"></td>
                              </tr>
                              <tr>
                                 <td class="eml" colspan=6>Payment Communication</td>
                              </tr>
                              <tr>
                                 <td style="text-align:left;" colspan=3>4.1 If applicable, requested payment from member and other family members.  </td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[if_applicable_requested]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['if_applicable_requested']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['if_applicable_requested']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['if_applicable_requested']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $healthbridge['cmt14']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left;" colspan=3>4.2 If applicable, the member has outstanding balance after payment, ask if they would like us to set up a recurring payment. </td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[if_applicable_the_member]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['if_applicable_the_member']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['if_applicable_the_member']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['if_applicable_the_member']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $healthbridge['cmt15']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left;" colspan=3>4.3 Did agent present the authorize payment ask before processing</td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[did_agent_present]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['did_agent_present']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['did_agent_present']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['did_agent_present']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $healthbridge['cmt16']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left;" colspan=3>4.4 Did agent offer confirmation number</td>
                                 <td>
                                    <select class="form-control healthbridge_point" name="data[did_agent_offer]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=6.25 healthbridge_max_val=6.25 <?php echo $healthbridge['did_agent_offer']=='Exceeds'?"selected":""; ?> value="Exceeds">Exceeds Expectations</option>
                                       <option healthbridge_val=5.75 healthbridge_max_val=6.25 <?php echo $healthbridge['did_agent_offer']=='Meets'?"selected":""; ?> value="Meets">Meets Expectations</option>
                                       <option healthbridge_val=3.125 healthbridge_max_val=6.25 <?php echo $healthbridge['did_agent_offer']=='Needs'?"selected":""; ?> value="Needs">Needs Improvement</option>
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $healthbridge['cmt17']; ?>"></td>
                              </tr>
                               <tr>
                                 <td class="eml" colspan=6>Auto Fails</td>
                              </tr>
                             
                              <tr>
                                 <td style="text-align:left; color: red;" colspan=3>4.5 Adhered to HIPAA regulations throughout the entire call.</td>
                                 <td>
                                    <select class="form-control healthbridge_point" id="fatal1" name="data[adhered_to_HIPAA]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=0 healthbridge_max_val=0 <?php echo $healthbridge['adhered_to_HIPAA']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
                                       <option healthbridge_val=0 healthbridge_max_val=0 <?php echo $healthbridge['adhered_to_HIPAA']=='No'?"selected":""; ?> value="No">No</option>
                                       
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $healthbridge['cmt19']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left; color: red;" colspan=3>4.6 Used inappropriate tone and language with the member</td>
                                 <td>
                                   <select class="form-control healthbridge_point" id="fatal2" name="data[used_inappropriate]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=0 healthbridge_max_val=0 <?php echo $healthbridge['used_inappropriate']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
                                       <option healthbridge_val=0 healthbridge_max_val=0 <?php echo $healthbridge['used_inappropriate']=='No'?"selected":""; ?> value="No">No</option>
                                       
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt20]" value="<?php echo $healthbridge['cmt20']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left; color: red;" colspan=3>4.7 Did agent repeat card numbers back. </td>
                                 <td>
                                    <select class="form-control healthbridge_point" id="fatal3" name="data[did_agent_repeat]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=0 healthbridge_max_val=0 <?php echo $healthbridge['did_agent_repeat']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
                                       <option healthbridge_val=0 healthbridge_max_val=0 <?php echo $healthbridge['did_agent_repeat']=='No'?"selected":""; ?> value="No">No</option>
                                       
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt21]" value="<?php echo $healthbridge['cmt21']; ?>"></td>
                              </tr>
                              <tr>
                                 <td style="text-align:left; color: red;" colspan=3>4.8 Call Avoidance </td>
                                 <td>
                                    <select class="form-control healthbridge_point" id="fatal4" name="data[call_avoidance]" required>
                                       <option value="">-Select-</option>
                                       <option healthbridge_val=0 healthbridge_max_val=0 <?php echo $healthbridge['call_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
                                       <option healthbridge_val=0 healthbridge_max_val=0 <?php echo $healthbridge['call_avoidance']=='No'?"selected":""; ?> value="No">No</option>
                                       
                                    </select>
                                 </td>
                                 <td colspan=2><input type="text" class="form-control" name="data[cmt22]" value="<?php echo $healthbridge['cmt22']; ?>"></td>
                              </tr>
                              <tr>
                                 <td>Call Summary:</td>
                                 <td colspan="2"><textarea class="form-control" id="" name="data[call_summary]"><?php echo $healthbridge['call_summary'] ?></textarea></td>
                                 <td>Feedback:</td>
                                 <td colspan="2"><textarea class="form-control" id="" name="data[feedback]"><?php echo $healthbridge['feedback'] ?></textarea></td>
                              </tr>
                              <?php if($hcpss_id==0){ ?>
                              <tr>
                                 <td colspan=2>Upload Files</td>
                                 <td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
                              </tr>
                              <?php }else{ ?>
                              <tr>
                                 <td colspan=2>Upload Files</td>
                                 <?php if($healthbridge['attach_file']!=''){ ?>
                                 <td colspan=4>
                                    <?php $attach_file = explode(",",$healthbridge['attach_file']);
                                       foreach($attach_file as $mp){ ?>
                                    <audio controls='' style="background-color:#607F93">
                                       <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/healthBridge/<?php echo $mp; ?>" type="audio/ogg">
                                       <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/healthBridge/<?php echo $mp; ?>" type="audio/mpeg">
                                    </audio>
                                    </br>
                                    <?php } ?>
                                 </td>
                                 <?php }else{
                                    echo '<td colspan=6><b>No Files</b></td>';
                                     }
                                    } ?>
                              </tr>
                              <?php if($hcpss_id!=0){ ?>
                              <tr>
                                 <td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
                                 <td colspan=4><?php echo $healthbridge['agnt_fd_acpt'] ?></td>
                              </tr>
                              <tr>
                                 <td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
                                 <td colspan=4><?php echo $healthbridge['agent_rvw_note'] ?></td>
                              </tr>
                              <tr>
                                 <td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
                                 <td colspan=4><?php echo $healthbridge['mgnt_rvw_note'] ?></td>
                              </tr>
                              <tr>
                                 <td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
                                 <td colspan=4><?php echo $healthbridge['client_rvw_note'] ?></td>
                              </tr>
                              <tr>
                                 <td colspan=2  style="font-size:16px">Your Review</td>
                                 <td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td>
                              </tr>
                              <?php } ?>
                              <?php
                                 if($hcpss_id==0){
                                 	if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
                              <tr>
                                 <td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
                              </tr>
                              <?php
                                 }
                                 }else{
                                 if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
                                 	if(is_available_qa_feedback($healthbridge['entry_date'],72) == true){ ?>
                              <tr>
                                 <td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
                              </tr>
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