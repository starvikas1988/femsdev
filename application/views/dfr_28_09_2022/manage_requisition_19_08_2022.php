<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	.btn{
		/*min-width:105px;*/
	}
	.label {
		/*padding: .7em .6em;*/
	}
	#req_qualification_container
	{
		display:none;
	}
	/*start custom design css here*/
	.small-icon {
		width: 20px;
		height: 20px;
		border-radius: 50%;
		padding: 0;
		margin:0 0 0 2px;
		line-height: 19px;
	}	
	.red-btn {
		width: 100px;
		padding: 10px;
		background: #f00;
		color: #fff;
		font-size: 13px;
		letter-spacing: 0.5px;
		transition: all 0.5s ease-in-out 0s;
		border: none;
		border-radius: 5px;
	}
	.red-btn:hover {
		background: #af0606;
		color: #fff;
	}
	.candidate-area {
		width:100%;
	}
	.candidate-area label {
		margin:10px 0 0 0;
	}
	.cloumns-bg {
		background: #eee;
		padding: 10px;
	}
	.cloumns-bg1 {
		background:#f5f5f5;
		padding: 10px;
	}
	.no-padding {
		padding:0;
		margin:0;
	}
	.table-small {
		height:400px;
		overflow:scroll;
	}
	/*end custom design css here*/

</style>

<div class="wrap">

	
	
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">					
					<div class="row">
						<div class="col-md-4">
							<header class="widget-header">
								<?php
									if($req_status==0){
										$req_Status='Open';
									}else if($req_status==1){
										$req_Status='Closed';
									}else if($req_status==3){
										$req_Status='Pending';
									}else{
										$req_Status='Cancel';
									}
								?>
								<h4 class="widget-title">Manage <span style="font-weight:bold; font-size:18px"><?php echo $req_Status; ?></span> Requisition</h4>
							</header>
						</div>
						<div class="col-md-8" style='float:right; padding-right:10px; margin-top:14px'>
							<div class="form-group" style='padding-right:10px; float:right'>
								<a href='?req_status=2' <span style="padding:8px 12px;border-radius:5px;font-size:13px;" class="label label-warning">Cancel/Decline</span></a>	
							</div>
							<div class="form-group" style='padding-right:10px; float:right'>
								<a href='?req_status=1' <span style="padding:8px 12px;border-radius:5px;font-size:13px;" class="label label-danger">Closed</span></a>	
							</div>
							<div class="form-group" style='padding-right:10px; float:right'>
								<a href='?req_status=3' <span style="padding:8px 12px;border-radius:5px;font-size:13px;" class="label label-info">Pending</span></a>	
							</div>
							<div class="form-group" style='padding-right:10px; float:right'>
								<a href='?req_status=0' <span style="padding:8px 12px;border-radius:5px;font-size:13px;" class="label label-success">Open</span></a>	
							</div>
						</div>
					</div>
					<hr class="widget-separator">
					
					<div class="widget-body">
					
						<!--<form id="form_new_user" method="GET" action="<?php //echo base_url('dfr'); ?>">-->
						<?php echo form_open('',array('method' => 'get')) ?>
						
							<input type="hidden" id="req_status" name="req_status" value='<?php echo $req_status; ?>' >
							
							<div class="filter-widget">								
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Start Date</label>
											<input type="text" class="form-control" id="from_date" name="from_date" value="<?php echo $from_date;?>" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>End Date</label>
											<input type="text" class="form-control" id="to_date" name="to_date" value="<?php echo $to_date;?>" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Brand</label>
											<select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>
												
												<?php foreach ($company_list as $key => $value) { 
												$bss="";
												if(in_array($value['id'],$brand))$bss="selected";	
												?>	
														<option value="<?php echo $value['id']; ?>"<?php echo $bss;?>><?php echo $value['name']; ?></option>
												<?php  }?> 
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Location</label>
											<select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>
												
												<?php
												//if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
											?>
											<?php foreach($location_list as $loc): ?>
												<?php
												$sCss="";
												if(in_array($loc['abbr'],$oValue)) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												
											<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Department</label>
											<select id="select-department" class="form-control" name="department_id[]" autocomplete="off" placeholder="Select Department" multiple>
											<?php
												foreach($department_list as $k=>$dep){
												$sCss="";
												if(in_array($dep['id'],$o_department_id))$sCss="selected";	
											?>
											<option value="<?php echo $dep['id']; ?>"<?php echo $sCss;?>><?php echo $dep['shname']; ?></option>
											<?php		
												}
											?>	
											</select>
										</div>
									</div>									
									
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Client</label>
											<select id="fclient_id" name="client_id[]" autocomplete="off" placeholder="Select Client" multiple>	
											<?php foreach($client_list as $client): 
												$cScc='';
												if(in_array($client->id,$client_id)) $cScc='Selected';
											?>
											<option value="<?php echo $client->id; ?>" <?php echo $cScc; ?> ><?php echo $client->shname; ?></option>
											<?php endforeach; ?>	
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Process</label>
											<select id="fprocess_id"  name="process_id" autocomplete="off" placeholder="Select Process" class="select-box" >
											<option value="">-- Select Process--</option>	
											<?php foreach($process_list as $process): 
												$cScc='';
												if($process->id==$process_id) $cScc='Selected';
											?>
											<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?> ><?php echo $process->name; ?></option>
											<?php endforeach; ?>	
											</select>
										</div>
									</div>
									<div class="col-sm-3" id="requisation_div" style="display:none;">
										<div class="form-group">
											<label>Requisition</label>
											<select  autocomplete="off" name="requisition_id[]" id="edurequisition_id" placeholder="Select Requisition" class="select-box">
											<option="">ALL</option>	
											<?php /*foreach($get_requisition as $gr): ?>
											<?php
												$sRss="";
												if($gr['requisition_id']==$requisition_id) $sRss="selected";
											?>
												<option value="<?php echo $gr['requisition_id']; ?>" <?php echo $sRss; ?>><?php echo $gr['requisition_id']; ?></option>
											<?php endforeach;*/ ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" name="search" id="search" value="Search" class="submit-btn">
												<i class="fa fa-search" aria-hidden="true"></i>
												Search
											</button>
										</div>
									</div>
								</div>
								
							</div>
							
						</form>
						
					</div>
				</div>
			</div>
		</div>
		
		<div class="common-top">	
			<div class="row">
				<div class="col-md-12">
					<div class="widget">						
						<div class="widget-body no-padding">								
							<div class="row">
								<?php 									
									if((get_dept_folder()=="wfm" || get_global_access()== 1 || $is_role_dir=="admin" || $is_role_dir=="manager" || is_access_dfr_module()==true || is_approve_requisition()==true) && is_disable_add_requisition()==false){ 
								?>								
									<div class="col-md-12" style="float:right">
										<div class="form-group" style='float:right; display: inline-block;padding: 15px 15px 5px 0;border-radius:5px;cursor:pointer;font-size:16px;'>
											<a><span style="padding:8px 14px;" class="label label-primary addRequisition">Add Requisition</span></a>
										</div>
									</div>
									
								<?php	
									} 
								?>	
											
							</div>
							<?php
							//  print_r($get_requisition_list);die;
							 ?>
							<div id="bg_table" class="table-responsive ">
								<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
									<thead>
										<tr class='bg-info'>
											<th>SL</th>
											<th>Requisition Code</th>
											<th>Type</th>
											<th>Company Brand</th>
											<th>Department</th>
											<th>Due Date</th>
											<?php if($oValue=='CHA'){?>
												<th>Proposed Date</th>
											<?php } ?>	
											<th>Position</th>
											<th>Client</th>
											<th>Process</th>
											<th>Required Position</th>
											<th>Filled Position</th>
											<th>Batch No</th>
											<th>Raised By</th>
											<th>Raised Date</th>
											<th>Approved By</th>
											<th>Trainer/L1 Supervisor</th>
											<th>Closed Date</th>
											<?php if($req_status==1) { ?>
											<th>Closed Comment</th>
											<?php } ?>
											<?php if($req_status!=2){ ?>
											<th>Action</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php 
											$i=1;
											foreach($get_requisition_list as $row):
											
											$r_status=$row['requisition_status'];
											$id=$row['id'];
											
											$DueDate=$row['dueDate'];
											
											if($req_status==3){
												$approved_name="---";
											}else{
												$approved_name=$row['approved_name'];
											}
											
											$raised_by=$row['raised_by'];
											
										?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['requisition_id']; ?></td>
											<td><?php echo $row['req_type']; ?></td>
											<td><?php echo $row['company_brand_name']; ?></td>
											<td><?php echo $row['department_name']; ?></td>
											<td><?php echo $row['dueDate']; ?></td>
											<?php if($oValue=='CHA'){?>
											<td><?php echo $row['proposed_date']; ?></td>
											<?php } ?>
											<td><?php echo $row['role_name']; ?></td>
											<td><?php echo $row['client_name']; ?></td>
											<td><?php echo $row['process_name']; ?></td>
											<td><?php echo $row['req_no_position']; ?></td>
											<td><?php echo $row['count_canasempl']; ?></td>  <!-- dynamic filled position count -->
											<td><?php echo $row['job_title']; ?></td>
											<td><?php echo $row['raised_name']; ?></td>
											<td><?php echo mysqlDt2mmddyyDate($row['raised_date']); ?></td>
											<td><?php echo $approved_name; ?></td>
											<td><?php echo $row['l1_supervisor']; ?></td>
											<td><?php echo $row['closed_date']; ?></td>
											<?php if($req_status==1) { ?>
											<td><?php echo $row['closed_comment']; ?></td>
											<?php } ?>
											
											<?php if($req_status!=2){ ?>
											<td width="145px" style="text-align:left">
												<?php 											
													$r_id=$row['id'];
													$requisition_id=$row['requisition_id'];
													$requisition_status=$row['requisition_status'];
													$due_date=$row['due_date'];
													$currDate=date('Y-m-d');
													
													$dept_id=$row['department_id'];
													$role_folder=$row['role_folder'];
													 
													//echo $row['count_canasempl'];
													//$params=$row['location']."#".$row['dueDate']."#".$row['department_id']."#".$row['role_id']."#".$row['client_id']."#".$row['process_id']."#".$row['employee_status']."#".$row['req_qualification']."#".$row['req_exp_range']."#".$row['req_no_position']."#".$row['job_title']."#".$row['job_desc']."#".$row['req_skill']."#".$row['additional_info']."#".$row['raised_name']."#".$row['raised_date']."#".$row['requisition_status']."#".$row['req_type'];
													//."#".$row['filled_no_position']
													
													$params=$row['location']."#".$row['dueDate']."#".$row['department_id']."#".$row['role_id']."#".$row['client_id']."#".$row['process_id']."#".$row['employee_status']."#".$row['req_qualification']."#".$row['req_exp_range']."#".$row['req_no_position']."#".$row['job_title']."#".$row['job_desc']."#".$row['req_skill']."#".$row['additional_info']."#".$row['req_type']."#".$row['proposed_date']."#".$row['company_brand']."#".$row['raised_name']."#".$row['raised_date']."#".$row['requisition_status']."#".$row['site_id']."#"."editme";
													
												if($r_status=='P'){
													$title="Click to View requisition";
													$class="btn btn-primary btn-xs";
													$design="fa fa-eye";
												}else if($r_status=='A' || $r_status=='CL'){
													$title="Click to View & Manage Approved Requisition";
													$class="btn btn-success btn-xs small-icon";
													$design="fa fa-check-square";
												}else if($r_status=='R'){
													$title="Click to View Decline requisition";
													$class="btn btn-danger btn-xs small-icon";
													$design="fa fa-eye";
												}else{
													echo "";
												}
												
												
												
													//if($is_role_dir=="manager" || $is_role_dir=="admin" || get_dept_folder()=="wfm" || $is_role_dir=="super" || $is_global_access==1 || get_dept_folder()=="hr"){
														
												if(is_access_dfr_module()==1 || is_approve_requisition()==true){
													
													if($r_status!='C'){
													
													echo '<a class="'.$class.'" href="'.base_url().'dfr/view_requisition/'.$id.'" title="'.$title.'" style="font-size:12px"><i class="'.$design.'"></i></a>'; 
													echo "";
													
													}
													
												}
													
												//if( get_dept_folder()=="wfm" || $is_role_dir=="super" || is_approve_requisition()==true ){
													
														if($row['can_count']==0){
															
															if($r_status=='A'){
																echo "<button title='Decline Requisition' type='button' r_id='$r_id' requisition_id='$requisition_id' requisition_status='$requisition_status' class='btn btn-danger small-icon btn-xs cancelRequisition' style='font-size:12px'><i class='fa fa-times-circle' aria-hidden='true'></i></button>";
															}else if($r_status=='C'){
																echo "<span class='label label-danger' style='font-size:10px; min-width:80px; display:inline-block;'>Cancel </span>";
															}else{
																echo '';
															}
															
															
															if($r_status!='C' && $r_status!='CL'){
															
															echo "<button title='Edit Requisition' type='button' r_id='$r_id' requisition_id='$requisition_id' params='$params' class='btn btn-warning small-icon btn-xs editRequisition' style='font-size:12px'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>";
															echo "";
															
															}
															
														}
														
													//}
													
													
												//if( get_dept_folder()=="wfm" || $is_role_dir=="super"  || $is_role_dir=="manager"|| is_approve_requisition()==true ){	
												//if(get_dept_folder()=="hr" || get_role_dir()=="super"){
													
												if($current_user==$raised_by || is_assign_trainer_dfr()==true ){
													
													if($r_status=='A'){		/* $row['count_canasempl'] > 0 &&  */
														
														if($row['department_id']==6 && $row['role_folder']=='agent'){
															echo "<button title='Assign Trainer' type='button' r_id='$r_id' dept_id='$dept_id' role_folder='$role_folder' class='btn btn-xs small-icon  handoverRequisition' style='font-size:12px;  color:white; background-color:#1B6CC2'><i class='fa fa-male' aria-hidden='true'></i></button>";
														}else{
															echo "<button title='Assign L1 Supervisor' type='button' r_id='$r_id' dept_id='$dept_id' role_folder='$role_folder' class='btn btn-xs small-icon assignTlRequisition' style='font-size:12px;  color:white; background-color:#5A25AB'><i class='fa fa-male' aria-hidden='true'></i></button>";
														}
													}
												}
												
												
												if(is_force_close_dfr_requisition()==true){
												
													if($r_status!='C' && $r_status!='CL' && $r_status!='P'){ 
													echo "; <button title='Force Close Requisition' type='button' rid='$r_id' raised_by='$raised_by' dept_id='$dept_id' role_folder='$role_folder' class='btn btn-danger btn-xs small-icon forceclosedRequisitionModel' style='font-size:12px'><i class='fa fa-times' aria-hidden='true'></i></button>";
													}
												
												}
												
												if( get_global_access()==true || is_approve_requisition()==true ){
													
													if($r_status=='CL' ){ 
														
														echo "; <button title='Reopen Requisition' type='button' r_id='$r_id' class='btn btn-danger btn-xs reopenRequisition' style='font-size:12px'><i class='fa fa-check-square' aria-hidden='true'></i></button>";
														
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
						
					</div>
				</div>	
			</div>
		</div>
		
		
	</section>
</div>


<!---------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------->

<!----------- Add Requisition model ------------>
<div class="modal fade modal-design" id="addRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	  
	<form class="frmAddRequisition" action="<?php echo base_url(); ?>dfr/add_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Requisition</h4>
      </div>
      <div class="modal-body">
		<div class="filter-widget">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Location</label>
						<select class="select-box" name="location" id="location" required>
							<option value="">--Select--</option>
							<?php foreach($location_list as $ld): $abb = $ld['abbr']; if(get_user_fusion_id() == "FCHA000263") { if($abb == "CHA") { ?>
								<option value="<?php echo $ld['abbr']; ?>"><?php echo $ld['office_name']; ?></option>
							<?php }else{ echo "";} }else{ ?><option value="<?php echo $ld['abbr']; ?>"><?php echo $ld['office_name']; ?></option><?php } endforeach; ?>									
						</select>						
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
						<label>Department</label>
						<select class="select-box" id="department_id" name="department_id" required>
							<option value="">--Select--</option>
							<?php foreach($department_data as $row): ?>
							<option value="<?php echo $row['id']; ?>"><?php echo $row['shname']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
						<label>Requisition Type</label>
						<select class="select-box" id="req_type" name="req_type" required>
							<option value="">--Select--</option>
							<option value="Growth">Growth</option>
							<option value="Attrition">Attrition</option>
						</select>
					</div>	
				</div>
				
			</div>
			
			<div class="row">
			
				<div class="col-md-4">
					<div class="form-group">
						<label>Due Date</label>
						<input type="text" id="due_date" name="due_date" class="form-control" disabled>
					</div>	
				</div>
				
				<div class="col-md-4" id='proposed_date_add_col' style='display:none;'>
					<div class="form-group">
						<label>Proposed New Date</label>
						<input type="text" id="proposed_date_add" name="proposed_date" class="form-control" readonly="readonly">
					</div>	
				</div>
				
					<div class="col-md-4">
						<div class="form-group">
							<label>Company Brand</label>
							<select id="company_brand" name="company_brand" class="select-box brand" required>
								<option value="">-- Select Brand --</option>
								<?php foreach ($company_list as $key => $value) { if(get_user_fusion_id() == "FCHA000263") { if($value['name'] == "CSPL") { ?>
									<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
									<?php }else{ echo "";} }else{ ?>
										<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
								<?php } }?>
							</select>
						</div>
					</div>
					
			</div>
			
			<div class="row">
			
				<div class="col-md-4">
					<div class="form-group">
						<label>Position</label>
						<select class="select-box" id="role_id" name="role_id" required>
							<option value="">--Select--</option>
							<?php foreach($role_data as $row1): ?>
							<option value="<?php echo $row1->id; ?>"><?php echo $row1->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Client</label>
						<select class="select-box" id="fdclient_id" name="client_id" required>
							<option value="">--Select--</option>
							<?php foreach($client_list as $client): ?>
							<option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
						<label>Process</label>
						<select class="select-box" id="fdprocess_id" name="process_id" required>
							<option value="">--Select--</option>
							<?php foreach($process_list as $process): ?>
							<option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Employee Status</label>
						<select class="select-box" id="employee_status" name="employee_status" >
							<option value="">--Select--</option>
							<option value="1">Part Time</option>
							<option value="2">Full Time</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Qualification</label>
						<select class="select-box" id="qualification_type" name="a" required>
							<option value="">--Select--</option>
							<option value="Xth">Xth</option>
							<option value="XII">XII</option>
							<option value="Graduation">Graduation</option>
							<option value="Masters">Masters</option>
							<option value="Others">Others</option>
						</select>
					</div>	
				</div>
				<div class="col-md-2" id="req_qualification_container">
					<div class="form-group">
						<label>;</label>
						<input type="text" id="req_qualification" name="req_qualification" class="form-control" value="" placeholder="Req. Qualification..." required>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Required Experience Range (In Year)</label>
						<input type="number" maxlength="4" id="req_exp_range" name="req_exp_range" class="form-control" value=""  placeholder="Enter Req. Exp. Range..." required >
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Required no of Position</label>
						<input type="number" id="req_no_position" name="req_no_position" class="form-control" value="" placeholder="Enter Req. no of Position..." required>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Batch No</label>
						<input type="text" id="job_title" name="job_title" class="form-control" value="" placeholder="Enter Batch No..." >
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Required Skill</label>
						<input type="text" id="req_skill" name="req_skill" class="form-control" value="" placeholder="Enter Required Skill..." >
					</div>	
				</div>
			</div>	
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Job Desciption</label>
						<textarea class="form-control" id="job_desc" name="job_desc"></textarea>
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Additional Information</label>
						<textarea class="form-control" id="additional_info" name="additional_info"></textarea>
					</div>	
				</div>
			</div>
			<div class="site_cspl" style="display: none">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Site</label>
							<select name="site" class="form-control site">
								<?php foreach($site_list as $site): ?>
								<option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>					
				</div>
			</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="submit-btn" data-dismiss="modal">Close</button>
		<button type="submit" id='addRequisition' class="submit-btn1">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!-------------------- Edit Requisition model ----------------------------->
<div class="modal fade" id="editRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	  
	<form class="frmEditRequisition" action="<?php echo base_url(); ?>dfr/edit_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Requisition</h4>
      </div>
      <div class="modal-body">
	  
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="requisition_id" name="requisition_id" value="">
			
			<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Location</label>
							<select class="form-control" id="location" name="location" required>
								<option value="">--Select--</option>
								<?php foreach($location_data as $row): ?>
								<option value="<?php echo $row['abbr']; ?>"><?php echo $row['location']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label>Department</label>
							<select class="form-control" id="department_id" name="department_id" required>
								<option value="">--Select--</option>
								<?php foreach($department_data as $department): ?>
								<option value="<?php echo $department['id']; ?>"><?php echo $department['shname']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>	
					</div>
										
					
					<div class="col-md-4">
						<div class="form-group">
							<label>Requisition Type</label>
							<select class="form-control" id="req_type" name="req_type" required>
								<option value="">--Select--</option>
								<option value="Growth">Growth</option>
								<option value="Attrition">Attrition</option>
							</select>
						</div>	
					</div>
					
				</div>
				
								
				<div class="row">
															
					<?php if(get_dept_folder()=="wfm"){ ?>
						<div class="col-md-4">
							<div class="form-group">
								<label>Due Date</label>
								<input type="text" class="form-control" id="due_date1" name="due_date" required autocomplete="off">
							</div>	
						</div>
					<?php }else{ ?>
						<div class="col-md-4">
							<div class="form-group">
								<label>Due Date</label>
								<input type="text" class="form-control" name="due_date" value="<?php echo $DueDate; ?>" readonly>
							</div>	
						</div>
					<?php } ?>
					
						<div class="col-md-4" id='proposed_date_edit_col'>
						<div class="form-group">
							<label>Proposed New Date</label>
							<input type="date"  id="proposed_date_edit" name="proposed_date_edit" class="form-control" readonly >
						</div>	
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label>Company Brand</label>
								<select id="company_brand" name="company_brand" class="brand form-control" required>
									<option value="">-- Select Brand --</option>
									<?php foreach ($company_list as $key => $value) { ?>
										<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					
					</div>
				
					<div class="row">
									
					<div class="col-md-4">
						<div class="form-group">
							<label>Position</label>
							<select class="form-control" id="role_id" name="role_id" required>
								<option value="">--Select--</option>
								<?php foreach($role_data as $role): ?>
								<option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>	
					</div>
					<div class="col-md-4">
					<div class="form-group">
						<label>Client</label>
						<select class="form-control" id="fedclient_id" name="client_id" required>
							<option value="">--Select--</option>
							<?php foreach($client_list as $client): ?>
							<option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Process</label>
							<select class="form-control" id="fedprocess_id" name="process_id" required>
								<option value="">--Select--</option>
								<?php foreach($process_list as $process): ?>
								<option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>	
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Employee Status</label>
							<select class="form-control" id="employee_status" name="employee_status" >
								<option value="">--Select--</option>
								<option value="1">Part Time</option>
								<option value="2">Full Time</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Required Qualification</label>
							<input type="text" class="form-control" id="req_qualification" name="req_qualification" value="" required>
						</div>	
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Required Experience Range</label>
							<input type="text" class="form-control" id="req_exp_range" name="req_exp_range" value="" required>
						</div>	
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Required no of Position</label>
							<input type="number" class="form-control" id="req_no_position" name="req_no_position" value="" required>
						</div>	
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Required Skill</label>
							<input type="text" class="form-control" id="req_skill" name="req_skill" value="" >
						</div>	
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Batch No</label>
							<input type="text" class="form-control" id="job_title" name="job_title" value="" required>
						</div>	
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Job Desciption</label>
							<textarea class="form-control" id="job_desc" name="job_desc"></textarea>
						</div>	
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Additional Information</label>
							<textarea class="form-control" id="additional_info" name="additional_info"></textarea>
						</div>	
					</div>
				</div>
				<div class="site_cspl" style="display: none">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Site</label>
							<select name="site" class="form-control site">
								<?php foreach($site_list as $site): ?>
								<option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>					
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='editRequisition' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!-------------------- Cancel Requisition model ----------------------------->
<div class="modal fade modal-design" id="cancelRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmCancelRequisition" action="<?php echo base_url(); ?>dfr/cancelRequisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cancel Requisition</h4>
      </div>
      <div class="modal-body">
	  
			<input type="hidden" id="r_id" name="r_id" >
			<input type="hidden" id="requisition_id" name="requisition_id" value="">
			<input type="hidden" id="requisition_status" name="requisition_status" value="">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Cancel Reason</label>
						<textarea class="form-control" id="cancel_comment" name="cancel_comment" required></textarea>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='cancelRequisition' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!-------------------- Assign TL Requisition model ----------------------------->
<div class="modal fade modal-design" id="handoverRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmhandoverRequisition" action="<?php echo base_url(); ?>dfr/assignTLRequisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Assign Trainer</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" >
			<input type="hidden" id="dept_id" name="dept_id" >
			<input type="hidden" id="role_folder" name="role_folder" >
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Assign Trainer</label>
						<select class="form-control" id="assign_trainer" name="assign_trainer" required>
							<option>Select</option>
							<?php foreach($trainer_details as $row): ?>
								<option value="<?php echo $row['id']; ?>"><?php echo $row['name']." - ".$row['fusion_id']." - ".$row['dept_name']." - ".$row['role_name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='closedRequisition' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<div class="modal fade modal-design" id="assignTlRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmAssignTlRequisition" action="<?php echo base_url(); ?>dfr/assignTLRequisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Assign L1-Supervisor</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" >
			<input type="hidden" id="dept_id" name="dept_id" >
			<input type="hidden" id="role_folder" name="role_folder" >
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>L1 Supervisor</label>
						<select class="form-control" id="l1_supervisor" name="l1_supervisor" required>
							<option></option>
							
						</select>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='assignTlRequisition' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!-------------------- Re-Open Requisition model ----------------------------->
<div class="modal fade modal-design" id="reopenRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmReopenRequisition" action="<?php echo base_url(); ?>dfr/reopenRequisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reopen Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" >
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Reopen Reason</label>
						<textarea class="form-control" id="reopen_comment" name="reopen_comment" required></textarea>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='reopenRequisition' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!-------------------- force closed Requisition Model ----------------------------->
<div class="modal fade modal-design" id="forceclosedRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmforceclosedRequisition" action="<?php echo base_url(); ?>dfr/handover_forced_closed_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Force Close Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="rid" name="rid" >
			<input type="hidden" id="dept_id" name="dept_id" >
			<input type="hidden" id="role_folder" name="role_folder" >
			<input type="hidden" id="raised_by" name="raised_by" >
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Phase Type</label>
						<select id="" name="phase_type" class="form-control">
							<option value="0">NA</option>
							<option value="2">Training</option>
							<option value="4">Production</option>
						</select>
					</div>	
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment</label>
						<textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='closedRequisition' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
	document.querySelector("#req_no_position").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
});
</script>
<script>
/*$(function() {  
 $('#multiselect').multiselect();

 $('#edurequisition_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); */
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#fdoffice_ids').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); 
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#select-brand').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); 
</script>

<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#fclient_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); 
</script>
<script>
/*$(function() {  
 $('#multiselect').multiselect();

 $('#fprocess_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); */
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#select-department').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});

</script>
<script>
	 $(document).ready(function () {
      $('.select-box').selectize({
          sortField: 'text'
      });
  });
  
</script>
