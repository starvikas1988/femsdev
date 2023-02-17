<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">-->

<style> 
input[type=submit]{
  background-color: #4c7aaf;
  border: none;
  color: white;
  padding: 10px 20px;
  text-decoration: none;
  margin: 4px 2px;
}
// for tabs
li.oneItem {
   display: inline-block;
   background-color: #188ae2;
   padding: 10px;
   color: #fff;
   border-radius: 7px;
   cursor: pointer;
}

li.oneItem.active {
   background-color: #195bbb;
}
.common_top {
	margin:10px 0 0 0;
}
.dataTables_filter input{
	outline: none;
	height: 30px!important;
	margin-bottom: 5px;
	 position: relative;
  z-index: 99;
}

.dataTables_length{
	display: none;
}
.dataTables_wrapper div.dataTables_length select {
  width: 50px!important;
  height: 40px!important;
  
  
}
.new-header{
	padding: 10px 10px 0px 10px!important;
}
.table_main{
	position: relative;
}
.new-row-na{
  position: absolute;
  width: 100%;
  bottom: -46px;
  z-index: 1;
  left:23px ;
}
/*.dataTables_paginate,.dataTables_info{
	display: none;
}*/
</style>

<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<header class="widget-header">
						<div class="row">
							<div class="col-md-12 text-right">
								<a href="javascript:void(0);" data-toggle="modal" data-target="#createBucketModal" class="" style="margin-top:15px; margin-left:15px;">
									<button class="btn btn-success waves-effect" type="submit" value="View">Create Bucket </button>
								</a>
							</div>
						</div>
					</header>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>Bucket Name</th>
										<th>Bucket Criteria Min</th>
										<th>Bucket Criteria Max</th>
										<th>Target Per Month</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($bucket_list as $row){ ?>
									<tr>
										<td><?php echo $row['bucket_name']; ?></td>
										<td><?php echo $row['bucket_criteria_min']; ?></td>
										<td><?php echo $row['bucket_criteria_max']; ?></td>
										<td><?php echo $row['bucket_target']; ?></td>
										<td>
											<a href="javascript:void(0);" bid="<?php echo $row['id']; ?>" cid="<?php echo $client_id;?>" pid="<?php echo $pro_id;?>" data-toggle="modal" data-target="#editBucketModal" class="bucketEdit">EDIT</a> &nbsp; &nbsp;
											<a class="target" href="#" onclick="deletefunc(<?php echo $row['id'];?>,<?php echo $client_id;?>,<?php echo $pro_id;?>)">DELETE</i></a>
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
		<!--
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="widget-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<?= $this->session->flashdata('Success');?>
									<?= form_open( base_url('qa_agent_categorisation/import_excel_agent_categorisation'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
										<input class="upload-path" disabled />
										  <label class="upload">
											<input type="file" id="upl_file" name="file" data-allowed_file_type="xlsx" data-max_size="1024" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
											<span>Upload Excel</span>
										  </label>
										  <input type="submit" id="uploadsubmitdata" name="submit"/>
									<?= form_close();?>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group" style="margin-top:10px">
									<a href="<?php //echo base_url();?>Qa_agent_categorisation/sample_agent_cat_download" class="btn btn-danger" title="Download Sample Examination Excel" download="Sample_Agent_Categorization.xlsx">Sample Excel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		-->
		
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<!--<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
							<a class="btn btn-success waves-effect" a href="<?php echo base_url()?>qa_agent_categorisation" type="submit" id='btnExisting' name='btnView' value="View">Existing Agent</a>
							<a class="btn btn-success waves-effect" a href="<?php //echo base_url()?>qa_agent_categorisation/new_agent" type="submit" id='btnExisting' name='btnView' value="View">New Agent</a>
							<a class="btn btn-success waves-effect" a href="<?php echo base_url()?>qa_agent_categorisation/view_agent_target" type="submit" id='btnExisting' name='btnView' value="View">Target Assigned Agent</a>
							</header>
						</div>
					</div>-->
					<div class="common_top">
						<div class="row">
							<div class="col-md-12">
								<header class="widget-header new-header">
										<div class="row new-row">
										
										<!------------------------>
											<?php if(!empty($agent_cat_list)){?>
												<div class="col-md-2">
													<a href="javascript:void(0);" class="" >
														<button class="btn btn-success waves-effect btnClickLoader" id="sx_update_score" type="submit" value="View">Set Target As Per Bucket</button>
													</a>
												</div>
												
												<div class="col-md-2">
												<select class="form-control" name="assign_qa" id="assign_qa">
												<option value="">Select QA to Assign</option>
													<?php foreach($qa_list as $list){ ?>
													<option value="<?php echo $list['id']; ?>"><?php echo $list['qa_name']; ?></option>
													<?php } ?>
												</select>
												</div>

												<div class="col-md-2">
													<a href="javascript:void(0);" class="" >
														<button class="btn btn-success waves-effect btnClickLoader" id="set_qa" name="set_qa" type="submit" value="View">Assign QA</button>
													</a>
												</div>
											<?php } ?>

										<!-- 	<div class="col-sm-3 col-md-3">

											</div>
											<div class="col-sm-3 col-md-3">
												<input id="myInput" type="text" class="form-control search" placeholder="Search..">
												
											</div> -->
											
										</div>
								</header>
							</div>
							<hr class="widget-separator">
						</div>
					</div>
					
					<div class="widget-body">
						<div class="table-responsive">
						 <div class="table_main">
						   <form id="form_sx_category_list" method="POST" action="<?php echo base_url('qa_agent_categorisation/set_agent_target');?>">
						   <input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id;?>">
						   <input type="hidden" name="process_id" id="process_id" value="<?php echo $pro_id;?>">
						   <input type="hidden" name="qa_id" id="qa_id" value="">
							<!--<table id="example" class="table table-striped skt-table results" cellspacing="0" width="100%">-->
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<?php if(!empty($agent_cat_list)){?>
											<th style="width:60px"><input id="agent_id" name="agent_id[]" type="checkbox" onchange="checkAll(this)" value="Select All"/> </th>
										<?php } ?>
										<th>Tool ID</th>
										<th>Agent Name</th>
										<th>Emp. ID</th>
										<th>Assigned Process</th>
										<th>Assigned QA</th>
										<th>Tenure</th>
										<th>CQ Score</th>
										<th>Bucket</th>
										<th>Target</th>
										<!--<th>Uploaded Date</th>-->
									</tr>
								</thead>
								<tbody >
								<?php //print_r($agent_cat_list);?>
									<?php 
									$i=1;
									foreach($agent_cat_list as $row){ 
									/* echo "<pre>";
									print_r($row);
									echo "</pre>"; */
										$bucket_name="";
										$bucket_target="";
										
										//if(!empty($row['a_target'])){is_null
										if(is_null($row['a_target']) == false){
											$bucket_target= $row['a_target'];
											$bucket_name= $row['a_bucket'];
										}
										else if(!empty($row['cq_score'])){
											$bucket_target= $row['target'];
											$bucket_name= $row['bucket_name'];
										//}else if(empty($row['a_target']) && $row['tenure']>30){
										}else if((is_null($row['a_target']) == true) && $row['tenure']>30){
											$bucket_name= $row['bucket_name'];
											$bucket_target= $row['target'];
										}else if($row['tenure']<=30){
											
											$bucket_target= 3;
										}
										
										//$agentTenure = $row['tenure'];
										//echo $days_left_for_the_month;
										/* if($agentTenure>=13 && $agentTenure<=30){
											$bucket_target=ROUND((10/30)*$days_left_for_the_month);
										} */
										//echo $bucket_target;
										//echo "<br>".$bucket_name."<br>";
									?>
									<tr>
										<td><?php echo $i; ?> <input type="checkbox" id="agent_id[]" name="data[<?php echo $i;?>][agentID]" value="<?php echo $row['id']; ?>">
									</td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['xpoid']; ?></td>
										<td><?php echo $row['process_name']; ?></td>
										<td><?php echo $row['qa_name']; ?></td>
										<td><?php echo $row['tenure'];?></td>
										<td><?php echo $row['cq_score'];?>
										<input type="hidden" name="data[<?php echo $i;?>][cq_score]" id="cq_score_<?php echo $i;?>" value="<?php echo $row['cq_score'];?>" class="form-control">
									</td>
										<td>
											<!--<select name="data[<?php //echo $i;?>][bucket_name_list]" id="bucket_name_list_<?php //echo $i;?>" class="form-control" <?php //if($row['tenure']>30){?> onchange="getTarget(this.value,<?php //echo $i;?>);"<?php //}else{ ?> onchange="getTargetOJT(this.value,<?php //echo $i;?>,<?php //echo $row['tenure'];?>);"<?php //} ?> required>
												<option value="">Select Bucket</option>
												<?php //foreach($bucket_list as $list){ ?>
												<?php 
												//$sel ="";
												//if($list['bucket_name'] == $row['a_bucket']) $sel = "selected";?>
													<option value="<?php //echo $list['id'];?>" <?php //echo $sel;?>><?php //echo $list['bucket_name'];?></option>
												<?php //}?>
											</select>-->
											<?php if($row['tenure']<=30){?>
											<input type="text" name="data[<?php echo $i;?>][bucket_name]" id="bucket_name_<?php echo $i;?>" value="" class="form-control">	
												
											<?php }else{?>
											<input type="text" name="data[<?php echo $i;?>][bucket_name]" id="bucket_name_<?php echo $i;?>" value="<?php echo $bucket_name;?>" class="form-control">
											<?php }?>
										</td>
										<td>
										<?php if($row['tenure']<=30){?>
											<input type="text" name="data[<?php echo $i;?>][bucket_target]" id="bucket_target_<?php echo $i;?>" value="<?php echo $bucket_target;?>" class="form-control" >
										<?php }else{?>
											<input type="text" name="data[<?php echo $i;?>][bucket_target]" id="bucket_target_<?php echo $i;?>" value="<?php echo $bucket_target;?>" class="form-control">
										<?php }?>
										</td>
									</tr>
									<?php $i++;
									} ?>									
								</tbody>
							</table>
						  </form>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</section>
</div>



<div class="modal fade" id="createBucketModal" tabindex="-1" role="dialog" aria-labelledby="createBucketModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="createBucketTitle">Create Bucket</h4>
      </div>
      <div class="modal-body">
	  
		<div class="">
			<form id="form_create_bucket" method="POST" action="<?php echo base_url('Qa_agent_categorisation/create_bucket'); ?>">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Bucket Name</label>
							<input type="text" id="bucket_name" name="bucket_name" value="" class="form-control" required>
							<input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id;?>" class="form-control">
							<input type="hidden" id="process_id" name="process_id" value="<?php echo $pro_id;?>" class="form-control">
						</div>
					</div> 
					<div class="col-md-3">
						<div class="form-group">
							<label>Bucket Criteria Min</label>
							<input type="text" id="bucket_criteria_min" name="bucket_criteria_min" value="" class="form-control" required>
						</div>
					</div> 
					<div class="col-md-3">
						<div class="form-group">
							<label>Bucket Criteria Max</label>
							<input type="text" id="bucket_criteria_max" name="bucket_criteria_max" value="" class="form-control" required>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="form-group">
							<label>Target Per Month</label>
							<input type="text" id="target_per_month" name="target_per_month" value="" class="form-control" required>
						</div>
					</div> 
					<div class="col-md-1" style="margin-top:20px">
						<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_agent_categorisation/create_bucket" type="submit" id='btnCreate' name='btnCreate' value="Create">Create</button>
					</div>
				</div>
			</form>
		</div>		
      </div>	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editBucketModal" tabindex="-1" role="dialog" aria-labelledby="editBucketModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="createBucketTitle">Edit Bucket</h4>
      </div>
      <div class="modal-body">
	  
		
      </div>	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
// $(document).ready(function(){
//   $("#myInput").on("keyup", function() {
//     var value = $(this).val().toLowerCase();
//     $("#example tr").filter(function() {
//       $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
//     });
//   });
// });
	</script>
<!-- 	<script>
  $(document).ready(function () {
    $('#example').DataTable({
    	"ordering":false,
    	
    });
});
</script> -->