<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10"><header class="widget-header"><h4 class="widget-title">Unacademy Report</h4></header></div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">					
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('qa_unacademy/qa_unacademy_report'); ?>">	
						  <?php echo form_open('',array('method' => 'get')) ?>
						  
							<div class="col-md-3">
								<div class="form-group">
									<label>Search Date From -(mm/dd/yyyy)</label>
									<br/><br/>
									<input type="text" id="from_date" name="date_from" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($date_from); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Search Date To -(mm/dd/yyyy)</label>
									<br/><br/>
									<input type="text" id="to_date" name="date_to" onchange="date_validation(this.value,'E')"       value="<?php $date= mysql2mmddyy($date_to); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Select LOB/Campaign:<span style="font-size:24px;color:red">*</span></label>
									<select class="form-control" name="campaign" required>
										<option value=''>Select</option>
										<option <?php echo $campaign=="unacademy"?"selected":""; ?> value="unacademy">Unacademy [Version-I]</option>
										<option <?php echo $campaign=="unacademy_v2"?"selected":""; ?> value="unacademy_v2">Unacademy [Version-II]</option>
										<option <?php echo $campaign=="unacademy_activation"?"selected":""; ?> value="unacademy_activation">Unacademy Activation</option>
									</select>
								</div>
							</div>
							<div class="col-md-1" style='margin-top:40px;'>
								<div class="form-group">
									<button class="btn btn-primary blains-effect" a href="<?php echo base_url()?>qa_unacademy/qa_unacademy_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
							<?php if($download_link!=""){ ?>
								<div class="col-md-2" style='float:right; margin-top:40px'>
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
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Date of Upload</th>
										<th>Category</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($qa_unacademy_list as $row){ ?>
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
										<td><?php echo $row['call_date']; ?></td>
										<td><?php echo $row['category']; ?></td>
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