<style>
	td{
		font-size:10px;
	}
	
	#default-datatable th{
		font-size:11px;
	}
	#default-datatable th{
		font-size:11px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
	}
	
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Rejected Candidate List</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
							
					<div class="widget-body">
					
						<!--<form id="form_new_user" method="GET" action="<?php //echo base_url('dfr'); ?>">-->
						<?php echo form_open('',array('method' => 'get')) ?>
						
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Location</label>
										<select class="form-control" name="office_id" id="foffice_id" >
											<?php
												if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
											?>
											<?php foreach($location_list as $loc): ?>
												<?php
												$sCss="";
												if($loc['abbr']==$oValue) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												
											<?php endforeach; ?>
																					
										</select>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Requisition</label>
										<select class="form-control" name="requisition_id" id="requisition_id">
											<option value="">ALL</option>
											<?php foreach($get_requisition as $gr): ?>
											<?php
												$sRss="";
												if($gr['requisition_id']==$requisition_id) $sRss="selected";
											?>
												<option value="<?php echo $gr['requisition_id']; ?>" <?php echo $sRss; ?>><?php echo $gr['requisition_id']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
									
								<div class="col-md-1" style="margin-top:25px">
									<div class="form-group">
										<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>dfr/rejected_candidate" type="submit" id='btnView' name='btnView' value="View">View</button>
									</div>
								</div>
							</div>
							
						</form>	
					
					
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Requision Code</th>
										<th>Last Qualification</th>
										<th>Candidate Name</th>
										<th>Gender</th>
										<th>Mobile</th>
										<th>Skill Set</th>
										<th>Total Exp.</th>
										<th>Attachment</th>
										<th>Status</th>
										<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
											<th>Action</th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php
								$k=1;
								$m=1;
								foreach($candidate_rejected as $cd): 
								
								$r_id=$cd['r_id'];
								$c_id=$cd['can_id'];
								$c_status = $cd['candidate_status'];
								
								if($c_status=='P')	$cstatus="Pending";
								else if($c_status=='IP')	$cstatus="In Progress";
								else if($c_status=='SL')	$cstatus="Shortlisted";
								else if($c_status=='CS')	$cstatus="Selected";
								else if( $c_status=='E') $cstatus="Selected as Employee";
								else if($c_status=='R') $cstatus="Rejected";
								
								if($cd['requisition_status']=='CL'){
									$bold="style='font-weight:bold; color:red'";
								}else{
									$bold="";
								}
								
								if($cd['attachment']!='') $viewResume='View Resume';
								else $viewResume='';
							?>
							<tr>
								
								<td><?php echo $k++; ?></td>
								
								<td <?=$bold?>><?php echo $cd['requisition_id']; ?></td>
								<td><?php echo $cd['last_qualification']; ?></td>
								<td><?php echo $cd['fname']." ".$cd['lname']; ?></td>
								<td><?php echo $cd['gender']; ?></td>
								<td><?php echo $cd['phone']; ?></td>
								<td><?php echo $cd['skill_set']; ?></td>
								<td><?php echo $cd['total_work_exp']; ?></td>
								<td><a href="<?php echo base_url(); ?>uploads/candidate_resume/<?php echo $cd['attachment']; ?>"><?php echo $viewResume; ?></a></td>
								<td width="70px"><?php echo $cstatus; ?></td>
								
								<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
								<td width="150px">
									<?php	
										$sch_id=$cd['sch_id'];
										$interview_type=$cd['interview_type'];	
										$interview_site=$cd['location'];	//echo $interview_site;
										$requisition_id=$cd['requisition_id'];
										$filled_no_position=$cd['filled_no_position'];
										$req_no_position=$cd['req_no_position'];
										$department_id=$cd['department_id'];
										$role_id=$cd['role_id'];
										$sh_status=$cd['sh_status'];
										
										
									if($c_id!=""){
										
										echo '<a class="btn btn-success btn-xs viewCandidate" href="'.base_url().'dfr/view_candidate_details/'.$c_id.'" target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Candidate Details" style="font-size:12px"><i class="fa fa-eye"></i></a>';
										
											echo '&nbsp &nbsp';
										
										echo '<a class="btn btn-danger btn-xs rejectCandidateTransfer" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'" title="Transfer Candidate" style="font-size:12px" ><i class="fa fa-exchange"></i></a>';
										
										
										
										echo "&nbsp &nbsp";
										
										if($c_status!='P'){
										
											echo '<a class="btn btn-xs candidateInterviewReport" href="'.base_url().'dfr/view_candidate_interview/'.$c_id.'"  target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Candidate Interview Report" style="font-size:12px; background-color:#EE8CE4;"><i class="fa fa-desktop"></i></a>';
										
										}
										
									}
									?>
								</td>
								<?php } ?>
							</tr>
							
							<?php endforeach; ?>
								</tbody>
								
							</table>
							
						</div>
					</div>
			
			
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>
	
</div><!-- .wrap -->


<!---------------Candidate Transfer-------------------->
<div class="modal fade" id="transferRejectCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmTransferCandidate" action="<?php echo base_url(); ?>dfr/CandidateTransfer" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Candidate Transfer</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" class="form-control">
			<input type="hidden" id="c_id" name="c_id" class="form-control">
			<input type="hidden" id="c_status" name="c_status" class="form-control">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>List of Requisition</label>
						<select class="form-control" id="req_id" name="req_id">
							<option value="">-Select-</option>
							<option value="0">Pool</option>
							<?php foreach($getrequisition as $row){ ?>
								<option value="<?php echo $row['id']; ?>"><?php echo $row['req_desc']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row" style="margin-left:8px" id="req_details">
				
			</div>
			
			</br></br>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Transfer Comment</label>
						<textarea class="form-control" id="transfer_comment" name="transfer_comment"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="submit" name="submit" class="btn btn-primary" value="Save">
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>
