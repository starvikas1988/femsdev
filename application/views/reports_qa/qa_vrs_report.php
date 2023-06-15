<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom-femsdev.css"/>

<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								
								<?php
									$pval='';
									if($pValue=='Right Party') $pval='[Right Party]';
									else if($pValue=='Left Message') $pval='[Left Message]';
									else if($pValue=='Cavalry') $pval='[Cavalry]';
									else if($pValue=='CPTA') $pval='[CPTA]';
									else if($pValue=='VRS New') $pval='[VRS New]';
									else if($pValue=='VRS_Right_Party_V2') $pval='[VRS Right Party V2]';
									else if($pValue=='VRS Thirdparty') $pval='[VRS Thirdparty]';
									else $pval='';
									
								?>
							
								<h4 class="widget-title">QA Vital Recovery Services <?php echo $pval; ?> Report</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">					
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('reports_qa/qa_vrs_report'); ?>">	
						  <?php echo form_open('',array('method' => 'get')) ?>
						  
							<div class="col-md-3">
								<div class="form-group">
									<label>Search Date From - Audit Date (mm/dd/yyyy)</label>
									<!-- <input type="text" id="from_date" name="date_from" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control" required autocomplete="off"> -->

									<input type="text" id="from_date" name="date_from" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($date_from); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Search Date To - Audit Date (mm/dd/yyyy)</label>
									<!-- <input type="text" id="to_date" name="date_to" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control" required autocomplete="off"> -->
									<input type="text" id="to_date" name="date_to" onchange="date_validation(this.value,'E')"       value="<?php $date= mysql2mmddyy($date_to); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
								</div>
							</div>
							<!--<div class="col-md-3">
								<div class="form-group" id="foffice_div" <?php //echo $oHid;?>>
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<?php
											//if(get_global_access()==1) echo "<option value=''>ALL</option>";
										?>
										<?php //foreach($location_list as $loc): ?>
											<?php
											//$sCss="";
											//if($loc['abbr']==$office_id) $sCss="selected";
											?>
										<option value="<?php //echo $loc['abbr']; ?>" <?php //echo $sCss;?>><?php //echo $loc['office_name']; ?></option>
											
										<?php //endforeach; ?>
																				
									</select>
								</div>
							</div> -->
						
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Campaign</label>
									<select class="form-control" name="process_id" id="process_id" required>
										<option value=''>-Select Process-</option>
										<?php $cScc='';
										if($pValue=='Right Party') $cScc='Selected'; ?>
										<option value='Right Party' <?php echo $cScc; ?>>Right Party</option>
										<?php $cScc='';
										if($pValue=='Left Message') $cScc='Selected'; ?>										
										<option value='Left Message' <?php echo $cScc; ?>>Left Message</option>	
										<?php $cScc='';
										if($pValue=='Cavalry') $cScc='Selected'; ?>										
										<option value='Cavalry' <?php echo $cScc; ?>>Cavalry</option>
										<?php $cScc='';
										if($pValue=='CPTA') $cScc='Selected'; ?>										
										<option value='CPTA' <?php echo $cScc; ?>>CPTA</option>
										<?php $cScc='';
										if($pValue=='JRPA') $cScc='Selected'; ?>										
										<option value='JRPA' <?php echo $cScc; ?>>JRPA</option>
										<?php $cScc='';
										if($pValue=='Analysis') $cScc='Selected'; ?>										
										<option value='Analysis' <?php echo $cScc; ?>>Analysis [Right Party]</option>
										<?php $cScc='';
										if($pValue=='VRS New') $cScc='Selected'; ?>										
										<option value='VRS New' <?php echo $cScc; ?>>VRS New</option>
										<?php $cScc='';
										if($pValue=='VRS Thirdparty') $cScc='Selected'; ?>										
										<option value='VRS Thirdparty' <?php echo $cScc; ?>>VRS Thirdparty</option>	
										<?php $cScc='';
										if($pValue=='VRS_Right_Party_V2') $cScc='Selected'; ?>										
										<option value='VRS_Right_Party_V2' <?php echo $cScc; ?>>VRS Right Party V2</option>									
									</select>
								</div>
							</div>
							
							<div class="col-md-2" style='margin-top:2px;'>
								<div class="form-group">
									</br>
									<button class="btn btn-primary waves-effect blue-btn" a href="<?php echo base_url()?>reports_qa/qa_vrs_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
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
						<div class="row">
							<?php if($download_link!=""){ ?>
								<div style='float:right; margin-bottom:5px' class="col-md-1">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>	
									</div>
								</div>
							<?php } ?>
						</div>
					
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									<?php if($pValue=='CPTA'){ ?>
										<th>Audit Date</th>
										<th>Agent Audited</th>
										<th>Total Audit</th>
										<th>No of Connect</th>
										<th>No of Transfer</th>
										
									<?php }else if($pValue=='VRS New'){ ?>
									
										<th>SL</th>
										<th>Agent Name</th>
										<th>Fusion ID</th>
										<th>TL Name</th>
										<th>Audit Date</th>
										<th>Auditor</th>
										<th>Client Name</th>
										<th>QA Type</th>
										<th>Total Score</th>
										
									<?php }else if($pValue=='VRS_Right_Party_V2'){ ?>
									
										<th>SL</th>
										<th>Agent Name</th>
										<th>Fusion ID</th>
										<th>TL Name</th>
										<th>Audit Date</th>
										<th>Auditor</th>
										<th>Client Name</th>
										<th>QA Type</th>
										<th>Total Score</th>
										
									<?php }else{ ?>
									
										<th>SL</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>TL Name</th>
										<th>Audit Date</th>
										<th>Auditor</th>
										<?php if($pValue!="Cavalry") { ?>
											<th>Phone</th>
										<?php } ?>
										<th>Total Score</th>
									
									<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php  $i=1;
									foreach($qa_vrs_list as $row){ ?>
									<tr>
										<?php if($pValue=='CPTA'){ ?>
											<td><?php echo $row['audit_date']; ?></td>
											<td><?php echo $row['agent_audited']; ?></td>
											<td><?php echo $row['total_audit']; ?></td>
											<td><?php echo $row['no_connect']; ?></td>
											<td><?php echo $row['no_transfer']; ?></td>
										
										<?php }else if($pValue=='VRS New'){ ?>
											
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['fusion_id']; ?></td>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php echo $row['tl_name']; ?></td>
											<td><?php echo $row['audit_date']; ?></td>
											<td><?php echo $row['auditor_name']; ?></td>
											<td><?php echo $row['c_name']; ?></td>
											<td><?php echo $row['qa_type']; ?></td>
											<td><?php echo $row['overall_score']; ?></td>
											
										<?php }else if($pValue=='VRS_Right_Party_V2'){ ?>
											
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['fusion_id']; ?></td>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php echo $row['tl_name']; ?></td>
											<td><?php echo $row['audit_date']; ?></td>
											<td><?php echo $row['auditor_name']; ?></td>
											<td><?php echo $row['c_name']; ?></td>
											<td><?php echo $row['qa_type']; ?></td>
											<td><?php echo $row['overall_score']; ?></td>
											
										<?php }else{ ?>
									
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['fusion_id']; ?></td>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php echo $row['tl_name']; ?></td>
											<td><?php echo $row['audit_date']; ?></td>
											<td><?php echo $row['auditor_name']; ?></td>
											<?php if($pValue!="Cavalry"){ ?>
												<td><?php echo $row['phone']; ?></td>
											<?php } ?>
											<td><?php echo $row['overall_score']; ?></td>
										
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
		
		<?php if(!empty($qa_vrs_cpta_data)){ ?>
			<div class="row">
				<div class="col-md-12">
					<div class="widget">
							
						<div class="widget-body">	
							<div class="row">
								<?php if($download_link1!=""){ ?>
									<div style='float:right; margin-bottom:5px' class="col-md-1">
										<div class="form-group" style='float:right;'>
											<a href='<?php echo $download_link1; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>	
										</div>
									</div>
								<?php } ?>
							</div>
						
							<div class="table-responsive">
								<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
									<thead>
										<tr class='bg-info'>
											<th>SL</th>
											<th>Fusion ID</th>
											<th>Agent Name</th>
											<th>TL Name</th>
											<th>Audit Date</th>
											<th>Auditor</th>
											<th>Phone</th>
										</tr>
									</thead>
									<tbody>
										<?php  $i=1;
										foreach($qa_vrs_cpta_data as $row){ ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['fusion_id']; ?></td>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php echo $row['tl_name']; ?></td>
											<td><?php echo $row['audit_date']; ?></td>
											<td><?php echo $row['auditor_name']; ?></td>
											<td><?php echo $row['phone']; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	
	</section>
</div>	