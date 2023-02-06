<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
							
								<h4 class="widget-title">Qa <?php echo "NORDNET" ?> Report</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">					
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('reports_qa/qa_process_report/'.$returnProcess); ?>">	
						  <?php echo form_open('',array('method' => 'get')) ?>
						  
							<div class="col-md-4">
								<div class="form-group">
									<label>Search Date From (mm/dd/yyyy)</label>
									<input type="text" id="from_date" name="date_from" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Search Date To (mm/dd/yyyy)</label>
									<input type="text" id="to_date" name="date_to" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group" id="foffice_div" <?php //echo $oHid;?>>
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<?php
											if(get_global_access()==1) echo "<option value=''>ALL</option>";
										?>
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
						
							<div class="col-md-1" style='margin-top:2px;'>
								<div class="form-group">
									</br>
									<button class="btn btn-primary waves-effect" a href="<?php echo base_url()?>qa_<?php echo $page; ?>/process/reports" type="submit" id='show' name='show' value="Show">SHOW</button>
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
						
					<div class="widget-body">	
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
										<th>SL</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>TL Name</th>
										<th>Audit Date</th>
										<th>Auditor</th>
										<th>Total Score</th>
									</tr>
								</thead>
								<tbody>
									<?php  $i=1;
									$loop="qa_".$page."_list";
									foreach($$loop as $row){ ?>
									<tr>
											
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['fusion_id']; ?></td>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php echo $row['tl_name']; ?></td>
											<td><?php echo $row['audit_date']; ?></td>
											<td><?php echo $row['auditor_name']; ?></td>
											<td><?php echo $row['overall_score']; ?></td>
											
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