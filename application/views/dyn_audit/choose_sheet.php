<style>
    .table > tbody > tr > td {
        text-align: center;
        font-size: 13px;
    }

    #theader {
        font-size: 30px;
        font-weight: bold;
        background-color: #c0392b;
        color: white;
    }

    .eml {
        font-weight: bold;
        font-size: 18px;
        background-color: #85c1e9;
    }

    .ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
        float: left;
        background: #900;
        display: none;
    }
    /* .form-control {
			pointer-events: none;
			background-color: #D5DBDB;
		} */

    .imgContainer img {
        width: 9rem;
        height: 7rem;
        object-fit: cover;
        cursor: pointer;
        margin: 0.5rem;
    }
    .main_view {
        width: 100%;
        height: 100%;
    }
    .main_view img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .imgButton {
        text-align: center;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url('libs/bower/font-awesome/css/font-awesome-all.css')?>">
<link rel="stylesheet" href="<?php echo base_url('/libs/bower/jquery-toast-plugin/css/jquery.toast.css');?>">
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
			    <div class="widget">
			        <div class="widget-body">
			            <button class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#audit-sheet-list-modal" id="audit-sheet-list-show-btn">All Audit Sheets</button>
			            <table>
			                <tr>
			                    <td>
			                        <div class="imgContainer">
			                            <div class="imgbox">
			                                <img src="<?php echo base_url() ?>/qa_files/sample_dyn_sheet/template logo.png" onclick="change('demo_1')" />
			                            </div>
			                            <div class="imgButton">
			                                <a class="btn btn-info" title="Use This Template" href="<?php echo base_url('audit_sheet_dyn/create_sheet/?format_id=1')?>">Template 1</a>
			                            </div>
			                        </div>
			                    </td>
			                    <!-- <td>
			                        <div class="imgContainer">
			                            <div class="imgbox">
			                                <img src="https://www.omindtech.com/assets/front/images/logo.png" onclick="change('demo_2')" />
			                            </div>
			                            <div class="imgButton">
			                                <a class="btn btn-info" href="<?php echo base_url('audit_sheet_dyn/create_sheet/?format_id=2')?>">Use This</a>
			                            </div>
			                        </div>
			                    </td> -->
			                </tr>
			            </table>
			        </div>
			    </div>
			</div>
		</div>
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body">
						<div class="main_view">
							<div class="sheetdiv demo_1" style="display: none;">
							<div class="row">
								<div class="col-12">
									<div class="widget">
										<form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">

											<div class="widget-body">
												<div class="table-responsive">
													<table class="table table-striped skt-table" width="100%">
														<tbody>
															<tr style="background-color:#AEB6BF">
																<td colspan="6" id="theader">Demo Audit Sheet 1</td>
																<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
															</tr>
															<tr>
																<td>Name of Auditor:</td>
																<td style="width:230px"><input type="text" class="form-control" value="" disabled></td>
																<td style="width:200px">Date of Audit:</td>
																<td style="width:230px"><input type="text" class="form-control" value="" disabled></td>
																<td>Ticket ID<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>:</td>
																<td><input type="text" class="form-control" name="data[ticket_id]" value="" required></td>
															</tr>
															<tr>
																<td>Agent<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>:</td>
																<td>
																	<select class="form-control" id="" name="data[agent_id]" required>
																		<option value=""></option>
																	</select>
																</td>
																<td>EMP ID:</td>
																<td><input type="text" readonly class="form-control" id="xpoid" value=""></td>
																<td>L1 Supervisor:</td>
																<td>
																	<input type="text" readonly class="form-control" id="tl_name" value="">
																	<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="">
																</td>
															</tr>
															<tr>
																<td>Tenure (In Days):</td>
																<td><input type="text" readonly class="form-control" id="tenure" value=""></td>
																
																<td>Call Date/Time<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>:</td>
																<td><input type="text" class="form-control" id="call_date_time" name="call_date" value="" required></td>
																<td>Process:</td>
																<td>
																	<select class="form-control" id="procss" name="data[process]">
																		<option value="">-Select-</option>
																	</select>
																</td>
															</tr>
															<tr>
																<td>Call Duration<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>:</td>
																<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="" required></td>
																<td>Week:</td>
																<td>
																	<input type="text" class="form-control" name="data[week]" value="" readonly>
																</td>
																<td>LOB/Capmaign:</td>
																<td>
																	<select class="form-control" id="lob_campaign" name="data[lob_campaign]" required>
																		<option value="">-Select-</option>
																	</select>
																</td>
															</tr>
															
															<tr>
																<td>Audit Type<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>:</td>
																<td>
																	<select class="form-control" id="" name="data[audit_type]" required>
																		<option value="">-Select-</option>
																			<option value="Operation Audit">Operation Audit</option>
																			<option value="Certificate Audit">Certificate Audit</option>
																			<option value="CQ Audit">CQ Audit</option>
																			<option value="BQ Audit">BQ Audit</option>
																			<option value="Calibration">Calibration</option>
																			<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
																			<option value="Certificate Audit">Certificate Audit</option>
																			<option value="Operation Audit">Operation Audit</option>
																			<option value="Trainer Audit">Trainer Audit</option>
																			<option value="OJT">OJT</option>
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
																
															</tr>
															
															<tr style="font-weight:bold">
																<td style="font-size:18px; text-align:right">Earn Score:</td>
																<td><input type="text" class="form-control" id="earnScore" name="data[earn_score]" value="" readonly></td>
																<td style="font-size:18px; text-align:right">Possible Score:</td>
																<td><input type="text" class="form-control" id="possibleScore" name="data[possible_score]" value="" readonly></td>
																<td style="font-size:18px; text-align:right">Total Score:</td>
																<td><input type="text" class="form-control adtFatal" id="overallScore" name="overall_score" value="" readonly></td>
															</tr>
															<tr style="font-weight:bold">
																<td><input type="hidden" class="form-control" id="adt_prefatal" name="data[pre_fatal_score]" value=""></td>
																<td><input type="hidden" class="form-control" id="adt_fatalcount" name="data[fatal_count]" value=""></td>
															</tr>
															<tr style="height:25px; background-color:#114150; font-weight:bold">
																<td style="color:white">CALL AUDIT PARAMETERS</td>
																<td colspan=2 style="color:white">OBJECTIVES</td>
																<td style="color:white">STATUS</td>
																<td colspan=2 style="color:white">REMARKS</td>
															</tr>
															<tr>
																<td rowspan="3">Opening</td>
																<td colspan=2>Greeting / Call Brand / Caller identification</td>
																<td>
																	<select class="form-control audit_point" name="data[greeting]" required>
																		<option adt_val=4 value="Pass">Pass</option>
																		<option adt_val=4 value="Fail">Fail</option>
																		<option adt_val=4 value="N/A">N/A</option>
																	</select>
																</td>
																<td colspan=2><input type="text" class="form-control" name="data[comm1]" value=""></td>
															</tr>
															<tr>
																<!-- <td>Opening</td> -->
																<td colspan=2>Enthusiasm \ Energetic \ Energy Levels Maintaind throughout the call</td>
																<td>
																	<select class="form-control audit_point" name="data[enthusiasm]" required>
																		<option adt_val=5 value="Pass">Pass</option>
																		<option adt_val=5 value="Fail">Fail</option>
																		<option adt_val=5 value="N/A">N/A</option>
																	</select>
																</td>
																<td colspan=2><input type="text" class="form-control" name="data[comm2]" value=""></td>
															</tr>
															<tr>
																<!-- <td>Opening</td> -->
																<td colspan=2>Customer name and Preferred language confirmed</td>
																<td>
																	<select class="form-control audit_point" name="data[cus_name_lang]" required>
																		<option adt_val=4 value="Pass">Pass</option>
																		<option adt_val=4 value="Fail">Fail</option>
																		<option adt_val=4 value="N/A">N/A</option>
																	</select>
																</td>
																<td colspan=2><input type="text" class="form-control" name="data[comm3]" value=""></td>
															</tr>
															
															
															<tr>
																<td style="color:red">Tagging</td>
																<td colspan=2 style="color:red">
																Inaccurate Disposition /escalation / remarks</br>
																	1- Kapture disposition</br>
																	2- Panel Remarks / Esclation</br> 
																	3- DONE CORRECTLY</br>
																	4- Not required</br>
																	5- Other
																</td>
																<td>
																	<select class="form-control audit_point adt_fatal" id="auditAF3" name="data[accurate_disposition_escalation_remarks]" required>
																		<option adt_val=6 value="Pass">Pass</option>
																		<option adt_val=6 value="Fail">Fail</option>
																		<option adt_val=6 value="N/A">N/A</option>
																	</select>
																</td>
																<td colspan=2><input type="text" class="form-control" name="data[comm22]" value=""></td>
															</tr>
															
															<tr>
																<td>Call Summary<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>:</td>
																<td colspan=2><textarea class="form-control" name="data[call_summary]" required></textarea></td>
																<td>Feedback<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>:</td>
																<td colspan=2><textarea class="form-control" name="data[feedback]" required></textarea></td>
															</tr>

															<tr id="certificationAudit" style="background-color:#D4E6F1;display:none;">
																<td>Certification Attempt</td>
																<td>
																	<select class="form-control1" style="background-color:#D4E6F1; width:200px; height:40px" id="certification_attempt" name="data[certification_attempt]">
																		<option value="">-Select-</option>
																		<option value="1">First Attempt</option>
																		<option value="2">Second Attempt</option>
																		<option value="3">Third Attempt</option>
																	</select>
																</td>
																<td>Certification Status</td>
																<td colspan=3>
																	<select class="form-control1" style="background-color:#D4E6F1; width:200px; height:40px" id="certification_status" name="data[certification_status]">
																		<option value="">-Select-</option>
																		<option value="certified">Certified</option>
																		<option value="not_certified">Not Certified</option>
																	</select>
																</td>
															</tr>

															<tr style="background-color:#F5B7B1">
																<td colspan="2">Upload Audio Files</td>
																<td colspan=2><input type="file" accept="audio/*" multiple class="form-control dgt_sales_attachment" id="attach_file" name="attach_file[]"></td>
																<td colspan=2>
																	<a class="btn btn-warning" style="font-size:15px" href="#" target="a_blank" style="margin-left:5px; font-size:10px;">Record Audio Here</a>
																</td>
															</tr>

															<tr style="background-color:#F5B7B1">
																<td colspan="2"></td>

																
																	<td colspan="4">
																			<audio controls='' style="background-color:#607F93">
																				<source src="<?php echo base_url(); ?>qa_files/call" type="audio/ogg">
																				<source src="<?php echo base_url(); ?>qa_files/call" type="audio/mpeg">
																			</audio> </br>
																		
																	</td>
															</tr>

															
															<tr style="background-color:#F5B7B1">
																<td colspan="2">Upload Screenshot Files</td>
																
																	<td colspan=2><input type="file" accept="image/*" multiple class="form-control" name="attach_img_file[]"></td>
															</tr>

															<tr>
																<td colspan="6" style="background-color:#C5C8C8"></td>
															</tr>

															
																
																		<tr>
																			<td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px" disabled>SAVE</button></td>
																		</tr>
																		<tr>
																		<td colspan=6>
																			<button class="btn btn-primary waves-effect" onclick="location.href='<?php echo base_url() ?>/audit_sheet_dyn/create_sheet/?format_id=1'" type="button" id="" style="width:500px">Use This Template</button>
																			</td>
																		</tr>	
														</tbody>
													</table>
												</div>
											</div>

										</form>

									</div>
								</div>
							</div>
							</div>
							<div class="sheetdiv demo_2" style="display: none;">
							<div class="row">
								<div class="col-12">
									<div class="widget">

									</div>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</section>

	<!-- Audit sheet details modal -->

	<div class="modal fade" id="audit-sheet-list-modal" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-modal="true" role="dialog">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title h4" id="exampleModalXlLabel">All Audit Sheets</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">×</span>
	                </button>
	            </div>
	            <div class="modal-body">

	                <div class="widget-body table-responsive">
					    <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" style="white-space: nowrap;" width="100%" cellspacing="0">
					        <thead>
					            <tr class="bg-info">
					                <th class="text-center">SL. No.</th>
					                <th class="text-center">Audit Sheet Name</th>
					                <th class="text-center">Process</th>
					                <th class="text-center">LOB</th>
					                <th class="text-center">Campaign</th>
					                <th class="text-center">Created By</th>
					                <th class="text-center">Action</th>
					            </tr>
					        </thead>
					        <tbody style="text-align: center;" id="audit-sheet-list">
					            <tr>
					                <td>1</td>
					                <td>test</td>
					                <td>process</td>
					                <td>Lob</td>
					                <td>Campaign</td>
					                <td>Admin</td>
					                <td>
					                	<button class="btn btn-info btn-sm">Edit</button>
					                	<button class="btn btn-danger btn-sm">Inactive</button>
					                </td>
					            </tr>
					        </tbody>
					    </table>
					</div>

	            </div>
	            <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			    </div>
	        </div>
	    </div>
	</div>

</div>

