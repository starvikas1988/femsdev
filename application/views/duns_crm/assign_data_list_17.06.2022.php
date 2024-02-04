<style>
.btn-sm{
	padding: 2px 5px;
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
.pd{
padding-left: 1px;
}
.form-control{
border-radius: 3px!important;
}
.fa{
padding-right: 2px;
}
.table .btn{
padding: 6px;
border-radius: 3px;
width: 120px;
}
.aWidth{
width: 520px;
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
<h4 class="widget-title"><i class="fa fa-calendar"></i> Assign Data</h4>
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
	<!--<hr/>	-->
	<div class="row">
	<div class="col-md-12">
	<div class="form-group pd">
		<button type="submit" class="btn btn-primary btn-new"><i class="fa fa-search"></i> Search</button>
	</div>
	</div>
	</div>
</form>
</div>
</div>
</div>


<?php if(!empty($client_id)){ ?>
<div class="common-top">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-database"></i> Data Assign List</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">					
<div class="table-responsive">
	
  <table id="default-datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col"  class="text-center ">#</th>
        <th scope="col" class="text-center ">Client Name</th>
        <th scope="col" class="text-center ">Upload Date</th>
        <th scope="col" class="text-center ">Total Data</th>
        <th scope="col" class="text-center ">Assigned</th>
        <th scope="col" class="text-center ">Unassigned</th>
		<th scope="col" class="text-center aWidth" >Action</th>
      </tr>
    </thead>
	
    <tbody>	
	<?php
	$countc = 0;
	foreach($data_client_list as $token){ 
		$countc++;
		
		$currentFile = base64_encode($token['upload_file']);
		$currentDirFile = base64_encode(duns_upload_dir(2) .$token['upload_file']);
		$downLoadURL = duns_url() ."attachment_view?file=".$currentFile."&filedir=".$currentDirFile;
		
		$record_id = $token['id'];
		$totalData = !empty($data_all_inedexed[$record_id]) ? $data_all_inedexed[$record_id]['data_count'] : 0;
		$assignData = !empty($data_assign_inedexed[$record_id]) ? $data_assign_inedexed[$record_id]['data_count'] : 0;
		$unassigned = $totalData - $assignData;
	?>	
      <tr>
        <td scope="row"class="text-center " ><?php echo $countc; ?></td>
        <td scope="row" class="text-center "><b><?php echo $token['client_name']; ?></b></td>
        <td scope="row" class="text-center "><b><?php echo $token['upload_date']; ?></b></td>
        <td scope="row" class="text-center "><b><?php echo $totalData; ?></b></td>
        <td scope="row" class="text-center "><b><?php echo $assignData; ?></b></td>
        <td scope="row" class="text-center "><b><?php echo $unassigned; ?></b></td>
		<td scope="row" class="text-center">
		<a class="btn btn-primary  btn-sm assignDataList" sid="<?php echo $token['id']; ?>"><i class="fa fa-users"></i> Assign Agent</a>
		<a href="<?php echo $downLoadURL; ?>" target="_blank" class="btn btn-warning  btn-sm viewExcelFile" sid="<?php echo $token['id']; ?>"><i class="fa fa-download"></i> Raw Data</a>
		<a href="<?php echo duns_url('download_file_data/'.$token['id']); ?>" class="btn btn-success  btn-sm viewExcelFileDownload" sid="<?php echo $token['id']; ?>"><i class="fa fa-download"></i> Download Data</a>
		<a class="btn btn-primary  btn-sm reassignDataList" sid="<?php echo $token['id']; ?>"><i class="fa fa-users"></i>Re-assign Agent</a>
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

<?php } ?>


</div>

<br/><br/>

</section>
</div>



<div class="modal fade" id="editModal_record" tabindex="-1" role="dialog" aria-labelledby="editModal_record" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Assign Data To Agents</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
	  <form method="POST" action="<?php echo duns_url('assign_data_agent_submission'); ?>" enctype="multipart/form-data">
	  	<div class="modal-scroll">
      <div class="modal-body">	
		
	  		
      </div>
    </div>
	  </form>	  
      <div class="modal-footer">	     
         <button type="button" style="width:100px" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-----------------------------------RE-ASSIGN AGENT-------------------------------->

<div class="modal fade" id="editModal_reassing_record" tabindex="-1" role="dialog" aria-labelledby="editModal_record" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Re-assign Data To Agents</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
	  <form method="POST" action="<?php echo duns_url('reassign_data_agent_submission'); ?>" enctype="multipart/form-data">
	  	<div class="modal-scroll">
      <div class="modal-body">	
		
	  		
      </div>
    </div>
	  </form>	  
      <div class="modal-footer">	     
         <button type="button" style="width:100px" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
		