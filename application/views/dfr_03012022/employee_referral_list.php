<style>
	.table-height{
		width:100%;
		height:450px;
		overflow:scroll;
	}
	</style>
<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								
								<div class="row">
									<div class="col-md-6">
										<h4 class="widget-title">Employee Referral List </h4>
									</div>
									
								 </div>
							</header>
						</div>	
					</div>
					<hr class="widget-separator">
					
					<div class="widget-body">	
	
						<form method="GET" action="">
						
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Date From</label>
									<input type="text" id="date_from" name="date_from" value="<?php echo date('m/d/Y', strtotime(($date_from))); ?>" class="form-control" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Date To</label>
									<input type="text" id="date_to" name="date_to" value="<?php echo date('m/d/Y', strtotime(($date_to))); ?>" class="form-control" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-2" >
								<div class="form-group" id="foffice_div" <?php //echo $oHid;?>>
									<label>Location</label>
									<select class="form-control" name="office_id" id="office_id" >
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
							
							<div class="col-md-2" >
								<div class="form-group" id="foffice_div" <?php //echo $oHid;?>>
									<label>Status</label>
									<select class="form-control" name="ref_status">
										<option value=''>ALL</option>
                                        <?php foreach(_ref_show_status_name() as $key=>$tokenop){ ?>	
											<?php
											$sCss="";
											if($key==$s_ref_status) $sCss="selected";
											?>
											<option value='<?php echo $key; ?>'><?php echo $tokenop; ?></option>
										<?php } ?>																			
									</select>
								</div>
							</div>
							<div class="col-md-2" >
								<div class="form-group" id="download" <?php //echo $oHid;?>>
								    <label>Download</label><br/>
									<input type="checkbox" id="download" name="download" value="download"> Download Excel
								</div>
							</div>
							
							<div class="col-md-2" style='margin-top:20px;'>
								<div class="form-group">
								    <button class="btn btn-primary waves-effect" a href="<?php echo base_url()?>reports_hr/add_referrals_lists" type="submit" id='show' name='show' value="Show">SHOW</button>
									<!-- <button class="btn btn-info waves-effect" a href="<?php echo base_url()?>dfr/getExcel" type="submit" name="download" value="download">Download</button> -->
								</div>
							</div>
							
						</div>
					
					</form>	
	
						<div class="table-responsive table-height">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Name</th>
										<th>Location</th>
										<th>Phone</th>
										<th>Email</th>
										<th>CV</th>
										<th>Added By</th>
										<th>Fusion ID</th>
										<th>Department</th>
										<th>Client</th>
										<th>Process</th>										
										<th>Added Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php  $i=1;
									
									// FOR STATUS
								    function _ref_show_status_name($check=""){
										$resultArray = array(
											"P" => "Pending",
											"A" => "Shortlisted",
											"R" => "Rejected",
											"C" => "Moved to Requisiton",
											"X" => "Call Back",
										);
										$finalResult = $resultArray;
										if(!empty($check)){ $finalResult = $resultArray[$check]; }
										return $finalResult;
									}
									function _ref_show_status_color($check="")
									{
										$resultArray = array(
											"P" => "danger",
											"A" => "primary",
											"R" => "secondary",
											"C" => "success",
											"X" => "warning",
										);
										$finalResult = $resultArray;
										if(!empty($check)){ $finalResult = $resultArray[$check]; }
										return $finalResult;
									}
								
								
									foreach($add_referrals_list as $row):
								?>	
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['off_loc']; ?></td>
										<td><?php echo $row['phone']; ?></td>
										<td><?php echo $row['email']; ?></td>
										<td>
										<?php if(!empty($row['attachment_cv'])){ ?>
										<a title="<?php echo $row['attachment_cv']; ?>" style="cursor:pointer" onclick="window.open('<?php echo base_url()."dfr/employee_referral_attachment_view?filedir=".base64_encode($row['attachment_cv']); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no, status=yes');"><b><i class="fa fa-download"></i> <?php echo substr($row['attachment_cv'], 0, 15); if(strlen($row['attachment_cv']) > 15){ echo ".."; } ?></b></a>
										<?php } ?>
										</td>
										<td><?php echo $row['added_name']; ?></td>
										<td><?php echo $row['referral_fusionid']; ?></td>
										<td><?php echo $row['department']; ?></td>
										<td><?php echo $row['client_name']; ?></td>
										<td><?php echo $row['process_name']; ?></td>
										<td><?php echo $row['added_date']; ?></td>
										<td><span class="text text-<?php echo _ref_show_status_color($row['ref_status']); ?>"><b><?php echo _ref_show_status_name($row['ref_status']); ?></b></span></td>
										<td>
										<a  eid="<?php echo $row['id']; ?>" class="btn btn-danger btn-xs btnInfoReferral"><i class="fa fa-eye"></i> View</a>
										<?php if(!empty($row['ref_requisition_id'])){ ?>
										 <a target="_blank" href="<?php echo base_url('dfr/view_requisition/'.$row['ref_requisition_id']); ?>" class="btn btn-success btn-xs"><i class="fa fa-external-link"></i> View Requisition</a>
										<?php } ?>
										</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Name</th>
										<th>Location</th>
										<th>Phone</th>
										<th>Email</th>
										<th>CV</th>
										<th>Added By</th>
										<th>Fusion ID</th>
										<th>Department</th>
										<th>Client</th>
										<th>Process</th>
										<th>Added Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
						
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	



<div class="modal fade" id="modalInfoReferral" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalInfoReferral" aria-hidden="true">
  <div class="modal-dialog" style="width:60%">  
    <div class="modal-content">				
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Referral Info</h4>
		</div>		
		<div class="modal-body">
			<span class="text-danger">-- No Info Found --</span>
		</div>
	  <div class="modal-footer">			
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>			
	  </div>		
	</div>
</div>
</div>