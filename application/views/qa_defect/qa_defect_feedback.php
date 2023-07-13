<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css" />
<style>
input[type=submit] {
	background-color: #4c7aaf;
	border: none;
	color: white;
	padding: 10px 20px!important;
	width: 120px;
	text-decoration: none;
	margin: 4px 2px;
}

.upload-path {
	display: inline-block!important;
	padding: 8px;
	min-width: 250px;
	max-width: 100%;
	font-style: italic;
	border: 1px solid #ccc!important;
	border-radius: 5px!important;
	transition: all 0.5s ease-in-out 0s;
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
}

.new-audit .pull-left {
	margin-bottom: 15px;
}

.new-audit .btn {
	width: 120px;
	padding: 10px;
	border-radius: 4px;
	margin-top: 6px;
}
.new-row{
    padding: 0px 10px 10px 10px;
	 margin-top: -10px;
}
.btn-submit{
    width: 100px;
    padding: 12px!important;
    font-size: 12px;
    border-radius: 4px;
}
.view-btn-new {
    width: 100px;
    padding: 10px;
}

</style>

<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa Defect Table Entries</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_sea_world/add_edit_sea_world/0">Add Feedback</a> -->
									</div>	
									<?php } ?>
								</h4>
							</header>
						</div>
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>Client</th>
										<th>Last Audit Date</th>
										<th>Process</th>
										<th>Table Name/Campaign</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($qa_defect_data as $key=>$row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['clientName']; ?></td>
										<td><?php echo $qa_last_audit_date[$key]['entry_date']; ?></td>
										<td><?php echo $row['processName']; ?></td>
										<td><?php echo $row['table_name']; ?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Client</th>
										<th>Last Audit Date</th>
										<th>Process</th>
										<th>Table Name/Campaign</th>
									</tr>
								</tfoot>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
