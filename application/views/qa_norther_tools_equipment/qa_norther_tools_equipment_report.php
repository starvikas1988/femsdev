<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">Norther Tools & Equipment Report</h4></header>
						</div>
						<hr class="widget-separator">
					</div>

					<div class="widget-body">
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('Qa_norther_tools_equipment/qa_norther_tools_equipment_report'); ?>">
						  <?php echo form_open('',array('method' => 'get')) ?>

							<div class="col-md-3">
								<div class="form-group">
									<label>Search Date From -(mm/dd/yyyy)</label>
									
									<input type="text" id="from_date" name="from_date" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Search Date To -(mm/dd/yyyy)</label>

									<input type="text" id="to_date" name="to_date" onchange="date_validation(this.value,'E')"       value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
								</div>
							</div>

							<!-------------added-------------->

							<!-- <div class="col-md-4">
								<div class="form-group">
									<label> Select Campaign</label>
									<select class="form-control" id="campaign" name="campaign" required>
										<option value=''>Select</option>
										<option <?php echo $campaign=='1'?"selected":""; ?> value="1">ACC [Old] </option>
										<option <?php echo $campaign=='2'?"selected":""; ?> value="2">ACC [New] </option>
										<option <?php echo $campaign=='3'?"selected":""; ?> value="3">ACG </option>
									</select>
								</div>
							</div> -->

						</div>	
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<option value='All'>ALL</option>
										<?php foreach($location_list as $loc):
											$sCss="";
											if($loc['abbr']==$office_id) $sCss="selected";
											?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Select Audit Type</label>
									<select class="form-control" id="" name="audit_type">
										<option value='All'>ALL</option>
										<option <?php echo $audit_type=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
										<option <?php echo $audit_type=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
										<option <?php echo $audit_type=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
										<option <?php echo $audit_type=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
										<option <?php echo $audit_type=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
										<?php if(get_login_type()!="client"){ ?>
											<option <?php echo $audit_type=='Operation Audit'?"selected":""; ?> value="Operation Audit">Operation Audit</option>
											<option <?php echo $audit_type=='Trainer Audit'?"selected":""; ?> value="Trainer Audit">Trainer Audit</option>
										<?php } ?>
									</select>
								</div>
							</div>


							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									<button class="btn btn-primary blains-effect" a href="<?php echo base_url()?>Qa_norther_tools_equipment/qa_norther_tools_equipment_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>

							<?php //if($download_link!="" && ($this->input->get('show')=='Show')){ ?>
								<div style='float:right; margin-top:22px;' class="col-md-1">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>
									</div>
								</div>
							<?php //} ?>

						  </form>
						</div>


						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Date</th>
										<th>Total Score</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;

									foreach($qa_norther_tools_equipment_list as $row){ ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php
											if($row['entry_by']!=''){
												echo $row['auditor_name'];
											}else{
												echo $row['client_name'];
											}
										?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<?php //if($campaign=='idfc_new'){ ?>
											<td><?php echo $row['call_date']; ?></td>
										<?php //}else{  ?>

										<?php //} ?>
										<td><?php echo $row['overall_score']."%"; ?></td>
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

