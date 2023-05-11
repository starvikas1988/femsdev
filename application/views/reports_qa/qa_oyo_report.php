<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom-femsdev.css"/>

<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">QA OYO Report</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">					
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('reports_qa/qa_oyo_report'); ?>">	
						  <?php echo form_open('',array('method' => 'get')) ?>
						  
						  <div class="col-md-3">
							<div class="form-group">
								<label>Search From Date (mm/dd/yyyy)</label>
								<input type="text" id="from_date" name="date_from" onchange="date_validation(this.value,'S')" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control" onkeydown="return false;" required autocomplete="off"> <span class="start_date_error" style="color:red"></span> </div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Search To Date (mm/dd/yyyy)</label>
									<input type="text" id="to_date" name="date_to" onchange="date_validation(this.value,'E')" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control" onkeydown="return false;" required autocomplete="off"> <span class="end_date_error" style="color:red"></span> </div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<option value='All'>ALL</option>
										<?php foreach($location_list as $loc): ?>
											<?php $sCss="";
											if($loc['abbr']==$office_id) $sCss="selected"; ?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
										<?php endforeach; ?>									
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Process</label>
									<select class="form-control" name="process_id" id="process_id" required>
										<option value=''>-Select Process-</option>
										<?php
											$cScc='';
											if($pValue=='OYO IBD'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>
										<option value='OYO IBD' <?php echo $cScc; ?>>OYO International</option>
										
										<?php
											$cScc='';
											if($pValue=='OYO SIG'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>										
										<!-- <option value='OYO SIG' <?php echo $cScc; ?>>OYO SIG</option> -->
										
										<?php
											$cScc='';
											if($pValue=='OYO SIG New'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>										
										<option value='OYO SIG New' <?php echo $cScc; ?>>OYO SIG</option>
										<?php
											$cScc='';
											if($pValue=='OYO ITC'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>										
										<option value='OYO ITC' <?php echo $cScc; ?>>OYO ITC</option>
										
										<?php
											$cScc='';
											if($pValue=='oyo_sigchat_service'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>										
										<option value='oyo_sigchat_service' <?php echo $cScc; ?>>OYO SIG Chat (Service)</option>
										
										<?php
											$cScc='';
											if($pValue=='oyo_sigchat_escalation'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>										
										<option value='oyo_sigchat_escalation' <?php echo $cScc; ?>>OYO SIG Chat (Escalation)</option>
										
										<?php
											$pHide = "style='display:none'";
											$cScc='';
											if($pValue=='OYO LIFE'){ 
												$cScc='Selected';
												$pHide = "";
											}
										?>	
										<option value='OYO LIFE' <?php echo $cScc; ?>>OYO LIFE</option>
										
										<?php
											$cScc='';
											if($pValue=='Social Media RCA'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>
										<option value='Social Media RCA' <?php echo $cScc; ?>>Social Media RCA</option>
										
										<?php
											$cScc='';
											if($pValue=='DSAT RCA SIG'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>
										<option value='DSAT RCA SIG' <?php echo $cScc; ?>>DSAT RCA SIG</option>
										
										<?php
											$cScc='';
											if($pValue=='UK/US'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>
										<option value='UK/US' <?php echo $cScc; ?>>UK/US</option>

											<?php
												$cScc='';
												if($pValue=='OYO/WALLET/RECHARGE'){ 
													$cScc='Selected';
													$pHide = "style='display:none'";
												}
											?>
										<option value='OYO/WALLET/RECHARGE' <?php echo $cScc; ?>>OYO/WALLET/RECHARGE</option>

										<?php
												$cScc='';
												if($pValue=='OYO/ESAL'){ 
													$cScc='Selected';
													$pHide = "style='display:none'";
												}
											?>
										<option value='OYO/ESAL' <?php echo $cScc; ?>>OYO/ESAL</option>

										<?php
											$cScc='';
											if($pValue=='UK/US/NEW'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>
										<option value='UK/US/NEW' <?php echo $cScc; ?>>UK/US/NEW</option>

										<?php
											$cScc='';
											if($pValue=='OYOINB'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>
										<option value='OYOINB' <?php echo $cScc; ?>>OYOINB</option>
										
										<?php
											$cScc='';
											if($pValue=='OYOINB Hygiene'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>
										<option value='OYOINB Hygiene' <?php echo $cScc; ?>>OYOINB Hygiene</option>
										<?php
											$cScc='';
											if($pValue=='Booking_status_check'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>
										<option value='Booking_status_check' <?php echo $cScc; ?>>Booking Status Check</option>
										<?php
											$cScc='';
											if($pValue=='booking_lost_validation'){ 
												$cScc='Selected';
												$pHide = "style='display:none'";
											}
										?>
										<option value='booking_lost_validation' <?php echo $cScc; ?>>Booking Lost Validation</option>
									</select>
								</div>
							</div>
							
							<div class="col-md-2" id="life_lob" <?php echo $pHide;?>>
								<div class="form-group">
									<select class="form-control" name="lob" id="lob" style="margin-top:20px" >
										<option value="">-- Select LOB --</option>
										<?php
											$cScc='';
											if($lob=='IB/OB') $cScc='Selected';
										?>
										<option value="IB/OB" <?php echo $cScc; ?>>IB/OB</option>
										<?php
											$cScc='';
											if($lob=='Follow Up') $cScc='Selected';
										?>
										<option value="Follow Up" <?php echo $cScc; ?>>Follow Up</option>
										<?php
											$cScc='';
											if($lob=='Booking') $cScc='Selected';
										?>
										<option value="Booking" <?php echo $cScc; ?>>Booking</option>
										<?php
											$cScc='';
											if($lob=='Booking_status_check') $cScc='Selected';
										?>
										<option value="Booking_status_check" <?php echo $cScc; ?>>Booking Status Check</option>
										<?php
											$cScc='';
											if($lob=='booking_lost_validation') $cScc='Selected';
										?>
										<option value="booking_lost_validation" <?php echo $cScc; ?>>Booking Lost Validation</option>
									</select>
								</div>
							</div>
							
							<div class="col-md-2" style='margin-top:2px;'>
								<div class="form-group">
									</br>
									<button class="btn btn-primary waves-effect blue-btn" a href="<?php echo base_url()?>reports_qa/qa_oyo_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
							<?php if(!empty($qa_oyo_list)){ ?>
							
								<?php if($download_link!=""){ ?>
									<div style='float:right; margin-top:25px;' class="col-md-2">
										<div class="form-group" style='float:right;'>
											<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>	
										</div>
									</div>
								<?php } ?>
								
							<?php } ?>	
							
						  </form>
						</div>
						</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
						
					<div class="widget-body table-parent">
						
						
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>TL Name</th>
										<th>Audit Date</th>
										<th>Auditor Name</th>
										
										<?php if($pValue!='DSAT RCA SIG' && $pValue!='Social Media RCA' && $pValue!='UK/US' && $pValue=='OYO SIG New'){ ?>
										
											<th>Call Duration</th>
											<th>Recorded Date/Time</th>
										
										<?php if($pValue=='OYO LIFE' || $pValue=='OYOINB'){ ?>
											<th>Score</th>
										<?php }else{ ?>	
											<th>Call Type</th>
										<?php } ?>
										
										<?php }?>
										
											
									</tr>
								</thead>
								<tbody>
									<?php  
										$i=1;
										foreach($qa_oyo_list as $row){
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										
										<?php if($pValue=='OYO LIFE' || $pValue=='OYO/WALLET/RECHARGE' || $pValue=='OYO/ESAL' || $pValue=='UK/US' || $pValue=='UK/US/NEW' || $pValue=='OYOINB' || $pValue=='OYOINB Hygiene' || $pValue=='OYO SIG New' || $pValue=='oyo_sigchat_service' || $pValue=='oyo_sigchat_escalation' || $pValue=='Booking_status_check'|| $pValue=='booking_lost_validation'|| $pValue=='OYO ITC'){ ?>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<?php }else{ ?>
											<td><?php echo $row['agent_name']; ?></td>
										<?php } ?>
										
										<td><?php echo $row['tl_name']; ?></td>
										
										<?php if($pValue=='OYO LIFE'){ ?>
											<td><?php echo $row['auditDate']; ?></td>
										<?php }else{ ?>
											<td><?php echo $row['audit_date']; ?></td>
										<?php } ?>
										
										<td><?php echo $row['auditor_name']; ?></td>
										
										<?php if($pValue!='DSAT RCA SIG' && $pValue!='Social Media RCA' && $pValue!='UK/US' && $pValue!='UK/US/NEW' && $pValue=='OYO SIG New'){ ?>
										
											<td><?php echo $row['call_duration']; ?></td>
											
											<?php if($pValue=='OYO LIFE'){ ?>
												<td><?php echo $row['call_date_time']; ?></td>
											<?php }elseif(($pValue=='OYOINB' || $pValue=='OYO SIG New')){ ?>
												<td><?php echo $row['call_date']; ?></td>
											<?php }else{ ?>
												<td><?php echo $row['record_date_time']; ?></td>
											<?php } ?>
											
											<?php if($pValue=='OYO LIFE' || $pValue=='OYOINB'){ ?>
												<td><?php echo $row['overall_score']; ?></td>
											<?php }else{ ?>	
												<td><?php echo $row['call_type']; ?></td>
											<?php } ?>
										
										<?php } ?>
											
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	