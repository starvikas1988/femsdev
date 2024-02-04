<link rel="stylesheet" href="<?php echo base_url() ?>assets/aifi/css/bootstrap-multiselect.css">
<script src="<?php echo base_url() ?>assets/aifi/js/bootstrap-multiselect.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/jquery.dataTables.min.js"></script>



<?php  $date=date('Y-m-d');
//echo $date;die; ?>

<style type="text/css">
	div.dataTables_wrapper div.dataTables_paginate {
	    display: none!important;
	}
	div.dataTables_wrapper div.dataTables_info {
		display: none!important;
	}
</style>



<div class="main-content page-content">
	<div class="main-content-inner">

		<div class="common-top">
			<div class="middle-content">
				<div class="white-dash">
					<div class="filter-widget">
					<button type="button" class="btn btn-success" onclick="master_access_add_section();">Add Master Access</button>
						<?php //if($search_time !=''){   ?>
						<!-- <center><span style="color:green;" class="search_value" > Search Date Time: <?php  //echo $search_time;   ?> </span></center> -->
						<?php  //} ?>
					</div>
				</div>
			</div>
		</div>

		<div class="common-top">
			<div class="middle-content">
				<?php if(!empty($crm_list)){ ?>
					<a class="btn btn-success" href="<?php echo str_replace('report_for_tech?', 'download_report_for_tech?', $_SERVER['REQUEST_URI']); ?>">Download Report</a>
				<?php } ?>
				<div class="white-dash" style="height:600px;overflow:scroll;">
					<div class="table-widget">
						<div class="table-white">
						<table id="example" class="table table-striped">
					<thead>
						<tr>
							<th>Sl No.</th>
							<th>Fusion Id</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="table_data_val_for_complete_list">
						<?php
						// print_r($messageList);die;  
						$i=0;
						foreach ($access_details_show as $token) {$i++;
							if($token['status']==1){
								$status='Already given.';
							}
							else{
								$status='Already given.';
							}
						?>

							<tr class="onload_tr_value">

								<td><?= $i;?></td>
								<td><?= $token['fusion_id']; ?></td>
								<td><button class="btn btn-warning" onclick="access_remove('<?= $token['fusion_id']; ?>');">Remove Access </button></td>
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

<div class="modal fade" id="access_add_section" tabindex="-1" role="dialog" aria-labelledby="access_add_section" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Access</h4>
				<button type="button" class="btn-close" onclick="modal_note_button_close('access_add');" data-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			<!-- <div class="field_wrapper">
			<div>
				<input type="text" name="field_name[]" value=""/>
				<a href="javascript:void(0);" class="add_button" title="Add field">+</a>
			</div>
		</div> -->
		<div class ="row">
			<span style="color:red;" class="fusion_id_exist"></span>
		</div>
				<form method="POST" action="<?php echo base_url('aifi/access_submit'); ?>">
				<div class="field_wrapper">
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Fusion Id</label>
						<input type="text" name="field_name[]" class="form-control fusion_id_exists" id="exampleInputEmail1" aria-describedby="emailHelp">
						<a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus" aria-hidden="true"></i></a>
						
					</div>
				</div>
					<button type="submit" class="btn btn-primary disable_btn"  >Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>


<script>
$(document).ready(function() {
        $('.multi_select').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: true
        });
    }); 
</script>

<script>
	// $(document).ready(function() {
	// 	$('#default-datatable').DataTable();
	// } );
</script>
