<style>
.btn-sm{
	padding: 7px;
width: 120px;
border-radius: 3px;
}
.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
}
/*start new custom 25.05.2022*/
.common-top {
	width: 100%;
	margin-top: 10px;
	float: left;
}
.file-upload {
	width: 100%;
	margin: 10px 0 0 0;
}
.file-upload .form-control:focus {
	outline: none;
	box-shadow: none;
}
.modal-scroll {
	width: 100%;
	height: 400px;
	overflow-y: scroll;
}
.modal .modal-header {
	background: #188ae2;
	color: #fff;
}
.modal .close {
	width: 35px;
    height: 35px;
    background: #72b8ed;
    line-height: 35px;
    border-radius: 50%;
    position: absolute;
    right: -9px;
    top: -16px;
    opacity: 1;
    color: #fff;
    transition: all 0.5s ease-in-out 0s;
}
.modal .close:hover {
	background: #5ea5db;
}
.modal .table-responsive {
	padding-right: 10px;
	overflow: inherit;
}
.modal .form-inline .form-control {
	min-width: 100%;
}
.bg-success {
	transition: all 0.5s ease-in-out 0s;
}
.bg-success:hover {
	background: #0eb15e;
}
/*end new custom 25.05.2022*/
.btn-new{
width: 150px;
padding: 10px;
border-radius: 3px;
}
.form-control{
border-radius: 3px;
}
.table-bordered > thead > tr > th {
 padding: 12px;
}
</style>

<div class="wrap">
<section class="app-content">

<div class="row">
<div class="col-md-12">
<?php if(!empty($this->input->get('elog')) && $this->input->get('elog') == "error"){ ?>
<div class="alert alert-danger" role="alert">
  <i class="fa fa-warning"></i> Record Already Exist!
</div>
<?php } ?>
</div>
</div>

<div class="row">

<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-calendar"></i> All Record Data</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="GET" >				
	<div class="row">	
	<div class="col-md-4">
	<div class="form-group">
		<label>Client</label>
		 <select class="form-control" name="client_id">
			<?php echo duns_dropdown_3d_options($duns_clients_list, 'id', 'name', $client_id, ''); ?>
		 </select>
	</div>
	</div>
	<div class="col-md-4">
	<div class="form-group">
		<label>From Date</label>
		<input type="text" class="form-control oldDatePick" name="search_from" value="<?php echo date('m/d/Y', strtotime($search_from)); ?>" required>
	</div>
	</div>

	<div class="col-md-4">
	<div class="form-group">
		<label>To Date</label>
		<input type="text" class="form-control oldDatePick" name="search_to" value="<?php echo date('m/d/Y', strtotime($search_to)); ?>" required>
	</div>
	</div>		
</div>
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-new"><i class="fa fa-search"></i> Search</button>
	</div>
	</div>
	</div>
</form>
</div>
</div>
</div>

<div class="common-top">
<?php if(!empty($client_id)){ ?>
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-database"></i> All Data List</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">					
<div class="table-responsive">
	
  <table id="default-datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col" class="text-center">#</th>
        <th scope="col" class="text-center">Client Name</th>
        <th scope="col" class="text-center">Upload Date</th>
        <th scope="col" class="text-center">Assigned To</th>
        <th scope="col" class="text-center">Assigned Date</th>
        <th scope="col" class="text-center">AHT</th>
        <th scope="col" class="text-center">Status</th>
		<th scope="col" class="text-center" style="width:300px;">Action</th>
      </tr>
    </thead>
	
    <tbody>	
	<?php
	$countc = 0;
	foreach($duns_data_list as $token){ 
		$countc++;
	?>	
      <tr>
        <td scope="row" class="text-center"><?php echo $countc; ?></td>
        <td scope="row"  class="text-center"><b><?php echo $token['client_name']; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo $token['upload_date']; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo $token['assigned_to_name']; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo $token['assigned_date']; ?></b></td>
        <td scope="row" class="text-center" <?php if($token['agent_aht'] != "00:00:00"){ ?>style="font-size:13px"<?php } ?>><b><?php echo $token['agent_aht']; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo duns_data_status($token['record_status'], 2); ?></b></td>
		<td scope="row" class="text-center">
		<a class="btn btn-primary  btn-sm dataRemarksUpdate" sid="<?php echo $token['record_format']; ?>" did="<?php echo $token['id']; ?>"><i class="fa fa-users"></i> Add Remarks</a>
		<a class="btn btn-success  btn-sm viewRemarksUpdate" sid="<?php echo $token['record_format']; ?>" did="<?php echo $token['id']; ?>"><i class="fa fa-eye"></i> View Remarks</a>
		</td>
      </tr>
	<?php } ?>	
    </tbody>
  </table>
		
		
</div>
</div>
</div>
</div>
</div>
</div>

<?php } ?>


</div>

<br/><br/><br/><br/><br/><br/><br/>

</section>
</div>



<div class="modal fade" id="editModal_record" data-backdrop="static" data-keyboard="false"  tabindex="-1" role="dialog" aria-labelledby="editModal_record" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title"></h4>
		<?php if(duns_aht_exclusion()){ ?>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php } ?>
      </div>
      <div class="modal-scroll">
      <div class="modal-body">	
		
	  		
      </div>
      </div>	  
	  <?php if(duns_aht_exclusion()){ ?>	  
      <div class="modal-footer">	     
         <button type="button" style="width:100px" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
	  <?php } ?>	  
    </div>
  </div>
</div>
		