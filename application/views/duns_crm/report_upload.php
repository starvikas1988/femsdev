<style>
.btn-sm{
padding: 5px;
border-radius: 3px;
width: 120px;
}
.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
}
.largerFont{
	font-size:15px!important;
	padding: 9px 4px;
}
.btn-new{
width: 150px;
padding: 10px;
border-radius: 3px;
}
.header .btn{
width: 150px;
padding: 7px;
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
<h4 class="widget-title"><i class="fa fa-calendar"></i> Report Data</h4>
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
	<div class="form-group" style="padding-left: 1px;">
		<button type="submit" class="btn btn-primary btn-new"><i class="fa fa-search"></i> Search</button>
	</div>
	</div>
	</div>
</form>
</div>
</div>
</div>


<?php if(!empty($client_id)){ ?>

<div class="col-md-12">
<div class="widget">
<header class="widget-header header">
<h4 class="widget-title"><i class="fa fa-database"></i> Report Analytics
<?php
$downLoadURL = duns_url('report_upload') ."?client_id=" .$client_id."&search_from=".$search_from."&search_to=".$search_to."&report_type=excel";
?>
<a href="<?php echo $downLoadURL; ?>" class="btn btn-primary btn-sm pull-right "><i class="fa fa-file-excel-o"></i> Download Report</a>
</h4>
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
        <th scope="col" class="text-center">Total</th>
        <th scope="col" class="text-center">Unassigned</th>
        <th scope="col" class="text-center">Assigned</th>
        <th scope="col" class="text-center">Completed</th>
        <th scope="col" class="text-center">Overall Time</th>
        <th scope="col" class="text-center">Overall AHT</th>
		<th scope="col" class="text-center " style="width:300px;">Action</th>
      </tr>
    </thead>
	
    <tbody>	
	<?php
	$countc = 0;
	foreach($data_client_list as $token){ 
		$countc++;
		$record_id = $token['id'];
		
		$currentFile = base64_encode($token['upload_file']);
		$currentDirFile = base64_encode(duns_upload_dir(2) .$token['upload_file']);
		$downLoadURL = duns_url() ."attachment_view?file=".$currentFile."&filedir=".$currentDirFile;
	?>	
      <tr>
        <td scope="row" class="text-center"><?php echo $countc; ?></td>
        <td scope="row"  class="text-center"><b><?php echo $token['client_name']; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo $token['upload_date']; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo !empty($duns_result_ar['total'][$record_id]) ? count($duns_result_ar['total'][$record_id]) : 0; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo !empty($duns_result_ar['unassigned'][$record_id]) ? count($duns_result_ar['unassigned'][$record_id]) : 0; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo !empty($duns_result_ar['assigned'][$record_id]) ? count($duns_result_ar['assigned'][$record_id]) : 0; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo !empty($duns_result_ar['completed'][$record_id]) ? count($duns_result_ar['completed'][$record_id]) : 0; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo !empty($duns_result_ar['seconds_total'][$record_id]) ? duns_seconds_to_time($duns_result_ar['seconds_total'][$record_id]) : "00:00:00"; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo !empty($duns_result_ar['time_aht'][$record_id]) ? $duns_result_ar['time_aht'][$record_id] : "00:00:00"; ?></b></td>
		<td scope="row" class="text-center">
		
		<a href="<?php echo $downLoadURL; ?>" target="_blank" class="btn btn-warning  btn-sm viewExcelFile" sid="<?php echo $token['id']; ?>"><i class="fa fa-download"></i> Raw Data</a>
		<a href="<?php echo duns_url('download_file_data/'.$token['id']); ?>" class="btn btn-success  btn-sm viewExcelFileDownload" sid="<?php echo $token['id']; ?>"><i class="fa fa-download"></i> Download Data</a>
		
		</td>
      </tr>
	<?php } ?>	
	  <tr style="background-color:#ddd">
        <td scope="row" colspan="3" class="text-center largerFont">Total Overall</td>
        <td scope="row" class="text-center largerFont"><b><?php echo !empty($duns_result['total']) ? $duns_result['total'] : 0; ?></b></td>
        <td scope="row" class="text-center text-danger largerFont"><b><?php echo !empty($duns_result['unassigned']) ? $duns_result['unassigned'] : 0; ?></b></td>
        <td scope="row" class="text-center text-primary largerFont"><b><?php echo !empty($duns_result['assigned']) ? $duns_result['assigned'] : 0; ?></b></td>
        <td scope="row" class="text-center text-success largerFont"><b><?php echo !empty($duns_result['completed']) ? $duns_result['completed'] : 0; ?></b></td>
        <td scope="row" class="text-center largerFont"><b><?php echo !empty($duns_result['seconds_total']) ? duns_seconds_to_time($duns_result['seconds_total']) : "00:00:00"; ?></b></td>
        <td scope="row" class="text-center largerFont"><b><?php echo !empty($duns_result['time_aht']) ? $duns_result['time_aht'] : "00:00:00"; ?></b></td>
        <td scope="row" class="text-center largerFont"></td>
       </tr>
    </tbody>
  </table>
		
		
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
        <h4 class="modal-title">Update Data</h4>
		<?php if(duns_aht_exclusion()){ ?>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php } ?>
      </div>	  
      <div class="modal-body">	
		
	  		
      </div>	  
	  <?php if(duns_aht_exclusion()){ ?>	  
      <div class="modal-footer">	     
         <button type="button" style="width:100px" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
	  <?php } ?>	  
    </div>
  </div>
</div>
		