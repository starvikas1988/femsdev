
<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">QA Boomsourcing <?php  echo ucfirst(str_replace("_"," ",str_replace(array("qa_","_feedback"),"",$pValue))); ?> Report</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">					
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('Qa_boomsourcing/qa_boomsourcing_report'); ?>">	
						  <?php echo form_open('',array('method' => 'get')) ?>
						  
							<div class="col-md-3">
								<div class="form-group">
									<label>Search Date From - Audit Date (mm/dd/yyyy)</label>
									<input type="text" id="from_date" name="date_from" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Search Date To - Audit Date (mm/dd/yyyy)</label>
									<input type="text" id="to_date" name="date_to" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group" id="foffice_div" <?php //echo $oHid;?>>
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<option value='All'>All</option>
										<?php foreach($location_list as $loc): ?>
											<?php
											$sCss="";
											if($loc['abbr']==$office_id) $sCss="selected";
											?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
										<?php endforeach; ?>							
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Process</label>
									<select class="form-control" name="process_id" id="process_id" required>
										<option value=''>-Select Process-</option>
										<?php foreach($all_process as $process):?> 
											<?php $cScc='';
										if($pValue == $process['table_name']) $cScc='Selected'; ?>
															<option value="<?php echo $process['table_name']?>" <?php echo $cScc; ?>><?php echo ucfirst(str_replace("_"," ",str_replace(array("qa_","_feedback"),"",$process['process_name'])));?></option>
														<?php endforeach;?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Audit Type</label>
									<select class="form-control" name="a_type">
										<option value='All'>All</option>
										<option <?php echo $a_type=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
										<option <?php echo $a_type=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
										<option <?php echo $a_type=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
										<option <?php echo $a_type=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
										<option <?php echo $a_type=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
										<option <?php echo $a_type=='Operation Audit'?"selected":""; ?> value="Operation Audit">Operation Audit</option>
										<option <?php echo $a_type=='Trainer Audit'?"selected":""; ?> value="Trainer Audit">Trainer Audit</option>
										<option <?php echo $a_type=='OJT'?"selected":""; ?> value="OJT">OJT</option>
									</select>
								</div>
							</div>
							<div class="col-md-2" style='margin-top:22px;'>
								<div class="form-group">
									<button class="btn btn-primary waves-effect" a href="<?php echo base_url()?>qa_otipy/qa_otipy_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
							<?php if($download_link!=""){ ?>
								<div style='float:right; margin-top:25px;' class="col-md-2">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>	
									</div>
								</div>
							<?php } ?>
							
						  </form>
						</div>
						
						
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Employee ID of Agent</th>
										<th>Agent Name</th>
										<th>TL Name</th>
										<th>Audit Date</th>
										<th>Auditor</th>
										<th>Total Score</th>
									</tr>
								</thead>
								<tbody>
									<?php  
										$i=1;
										foreach($qa_boomsourcing_list as $row){
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['agent_name']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['entry_date']; ?></td>
										<td><?php 
											if($row['entry_by']!=''){
												echo $row['auditor_name'];
											}else{
												echo $row['client_name'].' [Client]';
											}
										?></td>
										<td><?php echo $row['overall_score'].'%'; ?></td>
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