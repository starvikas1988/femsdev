<style>
.btn-sm{
	padding: 2px 5px;
}

.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
}
</style>




<div class="wrap">
<section class="app-content">

<div class="row">

<div class="col-md-12 agentWidget">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-users"></i> Master Agent</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="POST" action="<?php echo base_url('emat/add_master_agent'); ?>" enctype="multipart/form-data">
			
	<div class="row">
		
	<div class="col-md-3">
	<div class="form-group">
		<label>Office</label>
		<select class="form-control" name="office_id" required>
			<option value="">-- Select Office --</option>
			<?php foreach($office_list as $token){ ?>
				<option value="<?php echo $token['abbr']; ?>"><?php echo $token['location']; ?></option>
			<?php } ?>
		</select>
	</div>
	</div>
	
	
	<div class="col-md-3">
	<div class="form-group">
		<label for="process_id">Client</label>
		<select class="form-control" name="client_id" required>
			<option value="">-- Select Client --</option>
			<?php foreach($client_list as $token){ ?>
				<option value="<?php echo $token['id']; ?>"><?php echo $token['shname']; ?></option>
			<?php } ?>
		</select>
	</div>
	</div>
	
	<div class="col-md-3">
	<div class="form-group">
		<label for="process_id">Process</label>
		<select class="form-control" name="process_id" required>
			<option value="">-- Select Process --</option>
			<?php foreach($process_list as $token){ ?>
				<option value="<?php echo $token['id']; ?>"><?php echo $token['name']; ?></option>
			<?php } ?>
		</select>
	</div>
	</div>
	
	
	<div class="col-md-3">
	<div class="form-group">
		<label for="process_id">Role</label>
		<select class="form-control" name="role_type" required>
			<option value="">-- Select Role --</option>
			<option value="agent">Agent</option>
			<option value="tl">TL</option>
		</select>
	</div>
	</div>
	

	</div>
	
	<hr/>
	
	<div class="row">	
	<div class="col-md-12 table-responsive" style="max-height:300px;">
			
		  <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
			<thead>
				<tr class='bg-primary'>
					<th><input type="checkbox" name="selectAllUserCheckBox" class="selectAllUserCheckBox" value="1"></th>
					<th>Name</th>
					<th>Fusion ID</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody id="allUserCheckTableList">								
			</tbody>
		</table>
				
			
	</div>
	</div>
	
	<hr/>
	
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
	</div>
	</div>
	
</form>
</div>
</div>
</div>


<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-users"></i> T1 Agent</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">					
<div class="table-responsive">
	
  <table id="default-datatable-list" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
		<th scope="col">Fusion ID</th>
        <th scope="col">Name</th>        
        <th scope="col">Proccess</th>
        <th scope="col">Designation</th>
		<th scope="col">L1 Supervisor</th>
		<th scope="col">Role</th>
		<th scope="col">Status</th>
		<th scope="col">Skillset</th>
		<th scope="col">Is Pick</th>
		<th scope="col">Is Pass</th>
		<!--<th scope="col">Action</th>-->
      </tr>
    </thead>
	
    <tbody>	
	<?php
	$countc = 0;
	foreach($agent_list as $token){ 
		$countc++;
		//if($token['role_type'] == 'agent'){
		if(e_agent_access($token['fusion_id'])){
	?>	
      <tr>
        <td scope="row" class="text-center"><?php echo $countc; ?></td>
		<td scope="row"><b><?php echo $token['fusion_id']; ?></b></td>
        <td scope="row"><b><?php echo $token['full_name']; ?></b></td>        
        <td scope="row" title="<?php echo $token['process_names']; ?>"><b><?php echo e_short_text($token['process_names'], 30); ?></b></td>        
        <td scope="row"><b><?php echo $token['designation']; ?></b></td>
		<td scope="row"><b><?php echo $token['l1_supervisor']; ?></b></td>
		<td scope="row"><b><?php echo $token['role_type']; ?></b></td>
		<td scope="row"><b><?php echo $token['is_logged_in'] == 1 ? "<span class='text-success'><i class='fa fa-circle'></i> Online</span>" : "<span class='text-secondary'><i class='fa fa-circle'></i> Offline</span>"; ?></b></td>
		<td scope="row"><b><?php echo !empty($token['is_assigned']) ? "<span class='text-success'><i class='fa fa-check'></i></span>" : "<span class='text-danger'>N/A</span>"; ?></b></td>
		<td scope="row"><b><?php echo !empty($token['is_pick']) ? "<span class='text-success'><i class='fa fa-check'></i></span>" : "<span class='text-danger'><i class='fa fa-times'></i></span>"; ?></b></td>
		<td scope="row"><b><?php echo !empty($token['is_pass']) ? "<span class='text-success'><i class='fa fa-check'></i></span>" : "<span class='text-danger'><i class='fa fa-times'></i></span>"; ?></b></td>
		<!--<td scope="row" class="text-center"></td>-->
      </tr>
	<?php } } ?>	
    </tbody>
  </table>
		
		
</div>
</div>
</div>
</div>



<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-users"></i> T2 Agent</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">					
<div class="table-responsive">
	
  <table id="default-datatable-list" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
		<th scope="col">Fusion ID</th>
        <th scope="col">Name</th>        
        <th scope="col">Proccess</th>
        <th scope="col">Designation</th>
		<th scope="col">L1 Supervisor</th>
		<th scope="col">Role</th>
		<th scope="col">Status</th>
		<th scope="col">Skillset</th>
		<th scope="col">Is Pick</th>
		<th scope="col">Is Pass</th>
		<!--<th scope="col">Action</th>-->
      </tr>
    </thead>
	
    <tbody>	
	<?php
	$countc = 0;
	foreach($agent_list as $token){ 
		$countc++;
		//if($token['role_type'] != 'agent'){
		if(e_tl_access($token['fusion_id'])){
	?>	
      <tr>
        <td scope="row" class="text-center"><?php echo $countc; ?></td>
		<td scope="row"><b><?php echo $token['fusion_id']; ?></b></td>
        <td scope="row"><b><?php echo $token['full_name']; ?></b></td>        
        <td scope="row" title="<?php echo $token['process_names']; ?>"><b><?php echo e_short_text($token['process_names'], 30); ?></b></td>        
        <td scope="row"><b><?php echo $token['designation']; ?></b></td>
		<td scope="row"><b><?php echo $token['l1_supervisor']; ?></b></td>
		<td scope="row"><b><?php echo $token['role_type']; ?></b></td>
		<td scope="row"><b><?php echo $token['is_logged_in'] == 1 ? "<span class='text-success'><i class='fa fa-circle'></i> Online</span>" : "<span class='text-secondary'><i class='fa fa-circle'></i> Offline</span>"; ?></b></td>
		<td scope="row"><b><?php echo !empty($token['is_assigned']) ? "<span class='text-success'><i class='fa fa-check'></i></span>" : "<span class='text-danger'>N/A</span>"; ?></b></td>
		<td scope="row"><b><?php echo !empty($token['is_pick']) ? "<span class='text-success'><i class='fa fa-check'></i></span>" : "<span class='text-danger'><i class='fa fa-times'></i></span>"; ?></b></td>
		<td scope="row"><b><?php echo !empty($token['is_pass']) ? "<span class='text-success'><i class='fa fa-check'></i></span>" : "<span class='text-danger'><i class='fa fa-times'></i></span>"; ?></b></td>
		<!--<td scope="row" class="text-center"></td>-->
      </tr>
	<?php  } } ?>	
    </tbody>
  </table>
		
		
</div>
</div>
</div>
</div>

</div>

<br/><br/><br/><br/><br/><br/><br/>

</section>
</div>





<div class="modal fade" id="modalUpdateEmail" tabindex="-1" role="dialog" aria-labelledby="modalUpdateEmail" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">
		
	<form class="frmUpdateEmail" id="frmUpdateEmail" action="<?php echo base_url(); ?>emat/add_master_email" method='POST' enctype="multipart/form-data">			
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="updateEmail">Mail Box Config Update</h4>
		</div>
		
		<div class="modal-body">				
			<input type="hidden" id='edit_id' name='edit_id' required>		
			<div class="row">
				
				<div class="col-md-6">
				<div class="form-group">
					<label>Name</label>
					<input class="form-control" name="email_name" required>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">Email Type</label>
					<select class="form-control" name="email_type" required>
						<option value="outlook">Outlook</option>
					</select>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">Email ID</label>
					<input type="email" class="form-control" name="email_id" required>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">Password</label>
					<input type="text" class="form-control" name="email_password" required>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">SLA (in Hours)</label>
					<input type="text" class="form-control" name="email_sla" required>
				</div>
				</div>
				
				<div class="col-md-3">
				<div class="form-group">
					<label for="process_id">Ticket Prefix</label>
					<input type="text" class="form-control" name="email_prefix" required>
				</div>
				</div>
				
				<div class="col-md-3">
				<div class="form-group">
					<label for="process_id">Ticket Serial</label>
					<select class="form-control" name="email_ticket" required>
						<option value="individual">Individual</option>
						<option value="continuous">Continuous</option>
					</select>
				</div>
				</div>
					
						
			</div>														
		</div>
			
	
	  <div class="modal-footer">			
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='btnUpdateEmail' class="btn btn-primary">Update</button>			
	  </div>		  
	</form>
		
	</div>
</div>
</div>
