
<div class="wrap">
<section class="app-content">
	

  <h4>Search Case for Contact Tracing</h4>
  <hr/>
  
<div class="panel panel-default">
  <div class="panel-heading">Case Information</div>
  <div class="panel-body">
  
    <form action="" method="POST">
	
	<div class="row">
	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">CRM ID</label>
		  <input type="text" class="form-control" id="crm_id" placeholder="Enter CRM ID" value="<?php echo (!empty($casecrmid)) ? $casecrmid : ''; ?>" name="crm_id">
		  <input type="hidden" class="form-control" id="case_search" placeholder="Enter CRM ID" value="1" name="case_search">
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Case Name</label>
		  <input type="text" class="form-control" id="case_name" placeholder="Enter Case Name" value="<?php echo (!empty($casename)) ? $casename : ''; ?>" name="case_name">
		</div>
	</div>
	
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Phone :</label>
		  <input type="text" class="form-control number-only" id="case_phone" placeholder="Enter Phone No" name="case_phone" value="<?php echo (!empty($casephone)) ? $casephone : ''; ?>">
		</div>
	</div>
	
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Email :</label>
		  <input type="email" class="form-control" id="case_email" placeholder="Enter Email ID" name="case_email" value="<?php echo (!empty($caseemail)) ? $caseemail : ''; ?>">
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
		<button type="submit" name="save" class="btn btn-success" style="margin-top:20px"><i class="fa fa-search"></i> Search</button>
		</div>
	</div>
	</div>
	
	</form>
	
</div>
</div>





<?php if((!empty($totaldata)) && ($totaldata > 0)){ ?>
  
<div class="panel panel-default">
  <div class="panel-heading">Cases Found</div>
  <div class="panel-body">


	<div class="table-responsive">
		<table style="margin-top: 10px;" id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
		
			<thead>
				<tr class='bg-info'>
					<th>SL</th>
					<th>CRM ID</th>
					<th>Case Name</th>
					<th>Case Phone</th>
					<th>Case Email</th>
					<th>Case Status</th>
					<th>Opened By</th>
					<th>Date Added</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$cn = 1;
			foreach($case_list as $token){ 								
			?>
			<tr>
				<td><?php echo $cn++; ?></td>
				<td><?php echo $token['crm_id']; ?></td>
				<td><?php echo $token['case_fname'] ." " .$token['case_lname']; ?></td>
				<td><?php echo $token['p_phone']; ?></td>
				<td><?php echo $token['p_email']; ?></td>
				<td><?php 
				if(!empty($token['case_status']))
				{
					if($token['case_status'] == 'POSITIVE')
					{
						echo "<span class='text-danger'><b>POSITIVE</b></span>";
					}
					if($token['case_status'] == 'NEGATIVE')
					{
						echo "<span class='text-success'><b>NEGATIVE</b></span>";
					}
					if($token['case_status'] == 'RECOVERED')
					{
						echo "<span class='text-primary'><b>RECOVERED</b></span>";
					}
				} else {
					echo "<span class='text-warning'><b>PENDING</b></span>";
				}
				?></td>				
				<td><?php echo $token['fname'] ." " .$token['lname']; ?></td>
				<td><?php echo date('d M, Y', strtotime($token['case_added'])); ?></td>
				<td>
				<a title='View Case' href="<?php echo base_url()."covid_case/form/" .$token['crm_id']."/personal/"; ?>" class='btn btn-success btn-xs' style='font-size:12px'>
				<i class='fa fa-eye'></i> Open Case</a>	
				
				<a title='View Logs' target="_blank" href="<?php echo base_url()."covid_case/check_logs/" .$token['crm_id']."/"; ?>" class='btn btn-danger btn-xs' style='font-size:12px'>
				<i class='fa fa-calendar'></i> View Logs</a>
				</td>
			</tr>
			<?php } ?>
			</tbody>
			
		</table>
	</div>
		

   </div>
</div>

<?php } ?>










	

<section>
</div>