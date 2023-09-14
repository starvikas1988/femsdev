<style>
	@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
	.container {
		margin-top: 20px;
		font-family: 'Roboto', sans-serif;
		width: 100%;
	}

	.card {
		position: relative;
		display: flex;
		flex-direction: column;
		min-width: 0;
		word-wrap: break-word;
		background-color: #fff;
		background-clip: border-box;
		border: 1px solid rgba(0, 0, 0, 0.125);
		border-radius: 1px;
		box-shadow: 0 2px 6px 0 rgba(32, 33, 37, .1);
	}

	.card-header {
		padding: 0.5rem 1rem;
		margin-bottom: 0;
		background-color: rgba(0, 0, 0, 0.03);
		border-bottom: 1px solid rgba(0, 0, 0, 0.125);
		padding: 15px;
		background-color: #3b5998;
		color: #fff;
	}

	.header {
		font-family: 'Roboto', sans-serif;
		font-weight: 900;
		font-size: 12px;
		text-transform: capitalize;
		letter-spacing: 1px;
	}

	.card-body {
		flex: 1 1 auto;
		padding: 1rem 1rem;
	}

	.form-control {
		height: 40px!important;
		border-radius: 0px!important;
		transition: all 0.3s ease;
	}

	.form-control:focus {
		border-color: #3b5998;
		box-shadow: none!important;
	}

	.common-space {
		margin-bottom: 10px;
	}

	textarea {
		width: 100%;
		max-width: 100%;
	}

	.table tbody th.scope {
		background: #e8ebf8;
		border-bottom: 1px solid #e0e5f6;
	}



	.btn-save {
		width: 150px;
		border-radius: 1px;
		background: #3b5998;
		color: #fff;
		transition: all 0.3s ease;
		padding: 8px;
	}


	.btn-save:focus,
	.btn-save:hover {
		color: #fff;
		text-decoration: none;
		background: #335192;
		box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .25), 0 3px 10px 5px rgba(0, 0, 0, 0.05) !important;
	}

	.table > thead > tr > th {
		vertical-align: bottom;
		border-bottom: 1px solid #ddd;
		background: #3b5998;
		color: #fff;
		padding: 15px;
	}

	.table tbody th.scope {
		background: #3b5998;
		border-bottom: 1px solid #e0e5f6;
		color: #fff;
		text-align: center;
		padding: 12px;
	}

	.table th,
	td {
		text-align: center;
		padding-top: 15px;
	}

	.margin-Right {
		margin-right: -20px;
	}

	.paddingTop {
		padding-top: 15px!important;
	}

	.fa-shield {
		margin-right: 5px;
		font-size: 18px;
	}


	.search-select label {
		display: block;
	}

	.search-select .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
		width: 100%;
	}

	.bootstrap-select > .dropdown-toggle {
		height: 40px;
		border-radius: 0px!important;
	}

	.search-select ul {
		max-height: 200px!important;
	}

	.search-select .bs-placeholder:hover {
		background: #fff!important;
		box-shadow: none!important;
	}

	.search-select .dropdown-menu > .active > a,
	.search-select .dropdown-menu > .active > a:focus,
	.search-select .dropdown-menu > .active > a:hover {
		color: #fff;
		text-decoration: none;
		background-color: #3b5998!important;
		outline: 0;
	}

	.search-select .dropdown-menu {
		border-radius: 1px!important;
	}

	.btn-place {
		float: right;
	}

	.btn-place .btn {
		border-radius: 1px!important;
		color: #3b5998!important;
		font-weight: bold;
	}


	.btn-place .btn:focus,
	.btn-place .btn:hover {
		text-decoration: none;
		background: #fdfafa!important;
		color: #3b5998!important;
		font-weight: bold;
		box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .25), 0 3px 10px 5px rgba(0, 0, 0, 0.05) !important;
	}

	.new-table .buttons-excel {
		border-radius: 1px!important;
		padding: 10px 15px;
		color: #fff;
		background: #3b5998!important;
	}

	.new-table td {
		padding: 15px!important;
	}
	.new-table .dt-buttons{
		margin: 0!important;
	}
	.canvas-chart {
		width: 100%;
		display: block;
		box-sizing: border-box;
		height: 499px!important;
	}
	.new-modal .modal-content
	{
		border-radius: 1px!important;
	}
	.new-modal .modal-title{
		color: #fff!important;
	}
	.new-modal .modal-header{
		background: #3b5998!important;
	}
	.new-modal .modal-header .close{
	background-color: #e3e4e7 !important;
	color: #3b5998!important;
	opacity: 1;
	padding: 5px 10px;
	border-radius: 50%;
	}
	.new-modal .modal-save{
		background: #3b5998;
	color: #fff;
	padding: 8px;
	width: 100px;
	border-radius: 1px;
	}
	.new-modal .modal-save:focus,
	.new-modal .modal-save:hover {
		color: #fff;
		text-decoration: none;
		background: #335192;
		box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .25), 0 3px 10px 5px rgba(0, 0, 0, 0.05) !important;
	}
	.new-modal .modal-footer .btn-default{
		padding: 8px;
	width: 100px;
	border-radius: 1px;
	}
	.fa-btn{
	  color: #3b5998;
	  font-size: 15px;
	  border: 1px solid #3b5998;
	  border-radius: 1px;
	}
	.new .btn-sm{
		color: #3b5998!important;
		border-radius: 1px!important;
	}
	.new-datatable div.dt-btn-split-wrapper button.dt-btn-split-drop{
		display: none!important;
	}
	.new-datatable .table td{
		text-align: left!important;
	}
</style>

<div class="wrap">
	<section class="app-content">
		
		<div class="common-space">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-12"> <span class="header" style="font-size:20px">apphelp</span> </div>
							</div>
						</div>
						<div class="card-body">
							<form id="form_new_user" method="GET" action="<?php echo base_url('qa_apphelp/agent_apphelp_feedback'); ?>">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Audit Date From(mm-dd-yyyy):<span style="font-size:15px;color:red">*</span></label>
										<input type="text" id="from_date"  name="from_date" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Audit Date To(mm-dd-yyyy):<span style="font-size:15px;color:red">*</span></label>
										<input type="text" id="to_date" name="to_date" onchange="date_validation(this.value,'E')"       value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
									</div>
								</div>
								<div class="col-sm-3">
									<button style="margin-top:22px" class="btn btn-save blains-effect" name="btnView" value="Show"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Show</button>
								</div>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<div class="common-space new-datatable">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-body new-table">
							<div class="row col-sm-6">
								<button class="btn btn-success"><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;Total Audits: <b><?php echo $tot_feedback ?></b></button>
								<button class="btn btn-warning"><i class="fa fa-comments" aria-hidden="true"></i>&nbsp;Review Pending: <b><?php echo $yet_rvw ?></b></button>
							</div>
							<table class="table table-striped " id="datatablesSimple">
								<thead>
									<th>SL No</th>
									<th>Auditor</th>
									<th>Audit Date</th>
									<th>Agent</th>
									<th>MWP ID</th>
									<th>L1 Supervisor</th>
									<th>Audit Type</th>
									<th>Overall Score</th>
									<th>Agent Review Status</th>
									<th>Agent Review Date & Time</th>
									<th>Mgnt Review By</th>
									<th>Mgnt Review Date & Time</th>
									<th>Action</th>
								</thead>
								<tbody>
									<?php $i=1;
										foreach($auditData as $row){
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php
											if($row['entry_by']!=''){
												echo $row['auditor_name'];
											}else{
												echo $row['client_name'].' [Client]';
											}
										?></td>
										<td><?php echo mysql2mmddyy($row['audit_date']); ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['audit_type']; ?></td>
										<td><?php echo $row['overall_score'].'%'; ?></td>
										<td><?php echo $row['agnt_fd_acpt']; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>

										<td>
											<?php $adt_id=$row['id']; ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_apphelp/agent_apphelp_rvw/<?php echo $adt_id ?>"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Review</a>
										</td>
									</tr>
									<?php } ?>
								</tbody>
								<tfoot></tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>