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


<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">New Productive App</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form id="addConfigEgaze" method="POST" action="<?php echo base_url('egaze/submitConfig'); ?>">
					<div class="row">
					<div class="col-md-8">
					<div class="form-group">
						<label> App Name </label>
						<input class="form-control" name="app_name" id="app_name">
						<input type="hidden" class="form-control" name="app_type" id="app_type" value="productive">
					</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-4">
					<div class="form-group">
						<label> Is Global ? </label>
						<select class="form-control" name="is_global" id="is_global" required>
							<option value="">-- Select Option ----</option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-4">
					<div class="form-group">
						<label> Select Office </label>
						<select class="form-control" name="office_id" id="office_id">
							
							<?php
								if(get_user_office_id()!=="SKC" ) echo "<option value='0'>ALL</option>";
								foreach($location_list as $token)
								{
									if($token['is_active'] == 1)
									{
										$varso = "";
										if($token['abbr'] == $office_now) { $varso = "selected"; } 
										echo '<option value="'.$token['abbr'].'" ' .$varso .'>'.$token['location'].'</option>';
									}
								}
							?>
						</select>
					</div>
					</div>
					
					<div class="col-md-4">
					<div class="form-group departmentForm" style="display:none">
						<label> Select Department </label>
						<select class="form-control" name="department_id" id="department_id">
							<option value="0">ALL</option>
							<?php
								foreach($department_list as $token)
								{
									if($token['is_active'] == 1)
									{
										$varso = "";
										if($token['id'] == $department_now) { $varso = "selected"; } 
										echo '<option value="'.$token['id'].'" ' .$varso .'>'.$token['description'].'</option>';
									}
								}
							?>
						</select>
					</div>
					</div>
					</div>
					
					<div class="row clientProcessForm" style="display:none">
					<div class="col-md-4">
					<div class="form-group">
						<label> Select Client </label>
						<select class="form-control" name="client_id" id="client_id" required >
						    <option value="0">ALL</option>
							<?php foreach($client_list as $client): ?>
								<?php
								$sCss="";
								if($client['client_id']==$client_now) $sCss="selected";
								?>
								<option value="<?php echo $client['client_id']; ?>" <?php echo $sCss;?>><?php echo $client['shname']; ?></option>
								
							<?php endforeach; ?>
																	
						</select>
					</div>
					</div>
					
					<div class="col-md-4">
					<div class="form-group">
						<label> Select Process </label>
						<select class="form-control" name="process_id" id="process_id">
						    <option value="0">ALL</option>
							<?php foreach($process_list as $process): ?>
								<?php
									if($process->id ==0 ) continue;
									$sCss="";
									if($process->id==$process_now) $sCss="selected";
								?>
								<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
								
							<?php endforeach; ?>
							
						</select>
					</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-8">
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
<h4 class="widget-title">Productive Apps</h4>
</header>
<hr class="widget-separator"/>

	<div class="widget-body clearfix">
					
	<div class="table-responsive">
	
	<table id="default-datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">
  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
        <th scope="col">App</th>
        <th scope="col">Office</th>
        <th scope="col">Is Global</th>
        <th scope="col">Department</th>
        <th scope="col">Client</th>
        <th scope="col">Process</th>
        <th scope="col">Added By</th>
		<th scope="col">Action</th>
      </tr>
    </thead>
	
    <tbody>
	
	<?php
	$countc = 0;
	foreach($myapp as $token){ 
		$countc++;
	?>
	
      <tr>
        <td scope="row" class="text-center"><?php echo $countc; ?></td>
        <td scope="row"><b><?php echo $token['app_name']; ?></b></td>
        <td scope="row" class="text-center"><?php echo !empty($token['office_id']) ? $token['office_id'] : "All Office"; ?></td>
        <td scope="row" class="text-center"><?php echo !empty($token['is_global']) ? "<i class='fa fa-check text-success'></i>" : "<i class='fa fa-times text-danger'></i>"; ?></td>
        <td scope="row" class="text-center"><?php echo !empty($token['dept_id']) ? $token['department_name'] : 'All'; ?></td>
        <td scope="row" class="text-center"><?php echo !empty($token['client_id']) ? $token['client_name'] : 'All';  ?></td>
        <td scope="row" class="text-center"><?php echo !empty($token['process_id']) ? $token['process_name'] : 'All'; ?></td>
        <td scope="row" class="text-center"><?php echo !empty($token['fullname']) ? $token['fullname'] : '-'; ?></td>
		<td scope="row" class="text-center"><a onclick="return confirm('Do you really want to delete?')" href="<?php echo base_url() ."egaze/deleteConfig?type=papp&did=" .$token['id'] ."&del=1"; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a></td>
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
