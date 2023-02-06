
 <style>

	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:2px;
		font-size:11px;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}

	.panel .table td, .panel .table th{
		font-size:11px;
		padding:6px;
	}
	
	.hide{
	  disply:none;	  
	}
	
	.modal-dialog {
		width: 800px;
	}
	.modal
	{
		overflow:auto;
	}
	
	/*---------- MY CUSTOM CSS -----------*/
	.rounded {
	  -webkit-border-radius: 3px !important;
	  -moz-border-radius: 3px !important;
	  border-radius: 3px !important;
	}

	.mini-stat {
	  padding: 5px;
	  margin-bottom: 20px;
	}

	.mini-stat-icon {
	  width: 30px;
	  height: 30px;
	  display: inline-block;
	  line-height: 30px;
	  text-align: center;
	  font-size: 15px;
	  background: none repeat scroll 0% 0% #EEE;
	  border-radius: 100%;
	  float: left;
	  margin-right: 10px;
	  color: #FFF;
	}

	.mini-stat-info {
	  font-size: 12px;
	  padding-top: 2px;
	}

	span, p {
	  /*color: white;*/
	}

	.mini-stat-info span {
	  display: block;
	  font-size: 20px;
	  font-weight: 600;
	  margin-bottom: 5px;
	  margin-top: 7px;
	}

	/* ================ colors =====================*/
	.bg-facebook {
	  background-color: #3b5998 !important;
	  border: 1px solid #3b5998;
	  color: white;
	}

	.fg-facebook {
	  color: #3b5998 !important;
	}

	.bg-twitter {
	  background-color: #00a0d1 !important;
	  border: 1px solid #00a0d1;
	  color: white;
	}

	.fg-twitter {
	  color: #00a0d1 !important;
	}

	.bg-googleplus {
	  background-color: #db4a39 !important;
	  border: 1px solid #db4a39;
	  color: white;
	}

	.fg-googleplus {
	  color: #db4a39 !important;
	}

	.bg-bitbucket {
	  background-color: #205081 !important;
	  border: 1px solid #205081;
	  color: white;
	}

	.fg-bitbucket {
	  color: #205081 !important;
	}
	
		
	.highcharts-credits {
		display: none !important;
	}
	
	
	.text-box{
		background-color: #fff;
		padding: 10px 10px;
		margin:5px 5px 25px 5px;
		border-radius: 4px;
	}
	
	.text-headbox{
		margin-top: 5px;
		text-align:center;
	}
	.bhead{
		padding: 5px 8px;
		color: #000;
		font-size: 20px;
		letter-spacing: 0.8px;
		font-weight: 600;
		text-align:center;
	}
	.bheadInfo{
		padding: 2px 8px;
		color: #000;
		font-size: 16px;
		letter-spacing: 1px;
		font-weight: 600;
	}
	.btext{
		background-color: #d4eff7;
		padding: 17px;
		border-radius: 20px 0px 0px 0px;
		font-size: 25px;
	}
	
	.boxShape{
		background-color: #fff797;
		padding: 10px 20px;
		width: 80%;
		border-radius: 10px;
	}
	.initialInfo{
		font-size: 45px;
		padding: 5px 10px;
	}
	.laterInfo{
		font-size: 19px;
        padding: 20px 5px 20px 5px;
	}
	
	.counterBox{
		background-color: #fff797;
		padding: 10px 20px;
		width: 100%;
		border-radius: 10px;
	}
	
	.counterIcon{
		font-size: 45px;
		padding: 5px 10px;
	}
	
	.counterInfo{
		font-size: 16px;
	}
	.prizeNumber{
		border: 2px solid #f4ff4d;
		border-radius: 50%;
		padding: 7px 12px;
		margin: 0px 10px 0px 0px;
		background-color: #000;
		font-size:16px;
	}
	.rankInfo{
		margin: 18px 10px;
	}
		
		/*28-07-22---table-header-fixed-css*/

		.tbl-container{
			max-width: fit-content;
			max-height: fit-content;
		}
		.tbl-fixed{
			overflow-x: scroll;
			overflow-y:scroll ;
			height: fit-content;
			max-height: 500px;
		}
		.tbl-container table{
			min-width: max-content;
			border-collapse: separate;
		}
		.tbl-container table th{
			position: sticky;
			top: 0px;
			background: #35b8e0;
			border: 1px solid #E2E2E2;
			padding: 2px;
           font-size: 11px;
		}
		.tbl-container table td {
			border: 1px solid #E2E2E2;
			padding: 2px;
			font-size: 11px;
		}
	
</style>


<!-- Metrix -->

<div class="wrap">
<section class="app-content">
	
<div class="widget">
<hr class="widget-separator"/>

	<div class="widget-body clearfix">
	
	<div class="row">
	  <div class="col-md-4">
	  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Acceptance Dashboard</h4>
	  </div>
	</div>
	 
	<hr/>
	
	<div class="row">		
	<div class="col-md-12">
	<form method="GET" id="summaryForm" enctype="multipart/form-data">
	
		<div class="row">
		<div class="col-md-2">
			<div class="form-group" style="padding:2px 10px 2px 0px">
				<label for="ssdate">Select Location</label>
				<select class="form-control" name="select_office[]" id="select_office" multiple>
				<?php
				 if(in_array('ALL',$selected_office)){ $selecto = "selected"; } ?>	
				<option value='ALL' <?php echo $selecto; ?>>ALL</option>
				<?php foreach($location_list as $office){
					 $selectoff = "";
					if(in_array($office['abbr'],$selected_office)){ $selectoff = "selected"; } ?>
					<option value="<?php echo $office['abbr'] ?>" <?php echo $selectoff; ?>><?php echo $office['location'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group" style="padding:2px 10px 2px 0px">
				<label for="ssdate">Select Process</label>
				<select class="form-control" name="select_process" id="select_process" required>
				<!-- <option value='a'>All Process</option> -->
				<?php foreach($process_list as $process){?>
					<option value="<?php echo $process['pro_id'] ?>" <?php echo ($selected_process == $process['pro_id']) ? 'selected' : '' ?>><?php echo $process['process_name'] ?></option>
					<?php } ?>								
				</select>
			</div>
		</div>

		<!-- <div class="col-md-2">
			<div class="form-group">
				<label>LOB</label>
				<select class="form-control" name="lob_id[]" id="lob_id" multiple>	
				<?php if(in_array('ALL',$selected_lob)){ $selectl = "selected"; } ?>	
				<option value='ALL' <?php echo $selectl; ?>>ALL</option>
					<?php foreach ($lob_campaign as $key => $lob) { 
						$selectlob = "";
						if(in_array($lob['id'],$selected_lob)){ $selectlob = "selected"; } ?>
						<option value="<?php echo $lob['id'] ?>" <?php echo $selectlob ?>><?php echo $lob['campaign'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div> -->
		
		<div class="col-md-2">
			<div class="form-group">
				<label>L1 Supervisor</label>
				<select class="form-control" name="l1_super[]" id="l1_super" multiple>	
				<?php if(in_array('ALL',$selected_tl)){ $selectl1 = "selected"; } ?>	
				<option value='ALL' <?php echo $selectl1; ?>>ALL</option>
					<?php foreach ($tl_details as $key => $tl) { 
						$selecttl = "";
						if(in_array($tl['id'],$selected_tl)){ $selecttl = "selected"; } ?>
						<option value="<?php echo $tl['id'] ?>" <?php echo $selecttl ?>><?php echo $tl['tl_name'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<label>Select QA</label>
				<select class="form-control" name="select_qa[]" id="select_qa" multiple>	
				<?php if(in_array('ALL',$selected_qa)){ $selectlq = "selected"; } ?>	
				<option value='ALL' <?php echo $selectlq; ?>>ALL</option>
					<?php foreach ($qa_list as $key => $qa) { 
						$selectqa = "";
						if(in_array($qa['id'],$selected_qa)){ $selectqa = "selected"; } ?>
						<option value="<?php echo $qa['id'] ?>" <?php echo $selectqa ?>><?php echo $qa['qa_name'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group">
				<label>Start Date</label>
				<input type="text" id="from_date" name="from_date" value="<?php echo $selected_from_date ?>" class="form-control">
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label>End Date</label>
				<input type="text" id="to_date" name="to_date" value="<?php echo $selected_to_date ?>" class="form-control">
			</div>
		</div>
		
		<div class="col-md-1">
			<div class="form-group" style="margin-top:20px">
				<input type="submit" class="btn btn-primary btn-md" name='submitgraph' value="Search">
			</div>
		</div>
		</div>
		
	</form>		
	</div>
	</div>
	
		
	</div>
</div>

<div class="widget">
    <hr class="widget-separator" />

    <div class="widget-body clearfix">
        <div class="row">
            <div class="col-md-4">
                <h4 style="padding-left: 10px;"><i class="fa fa-bar-chart"></i> Acceptance Analytics</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-1">
                        <div class="counterBox text-center row" style="background-color: #5f0000; background-image: linear-gradient(to right, #ed6ea0 0%, #ed7397 100%); margin: 0 auto; width: 100%; height: 170px;">
                            <div class="col-md-12 text-white counterIcon"><i class="fa fa-book"></i></div>
                            <div class="col-md-12 text-white text-center counterInfo">
                                <span style="font-size: 12px;">Audit Count</span> <br />
                                <b><?php echo $overall_data['total_feedback']; ?></b>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="counterBox text-center row" style="background-color: #31863f; background-image: linear-gradient(to top, #3cba92 0%, #0ba360 100%); margin: 0 auto; width: 100%; height: 170px;">
                            <div class="col-md-12 text-white counterIcon"><i class="fa fa-bullhorn"></i></div>
                            <div class="col-md-12 text-white text-center counterInfo">
                                <span style="font-size: 12px;">Accepted within 24 hour</span> <br />
                                <b><?php echo $overall_data['tntfr_hr_acpt']; ?></b>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="counterBox text-center row" style="background-color: #4d687c; background-image: linear-gradient(to top, #30cfd0 0%, #330867 100%); margin: 0 auto; width: 100%; height: 170px;">
                            <div class="col-md-12 text-white counterIcon"><i class="fa fa-thumbs-up"></i></div>
                            <div class="col-md-12 text-white text-center counterInfo">
                                <span style="font-size: 12px;">Accepted post 24 hour</span> <br />
                                <b><?php echo $overall_data['accept_count']-$overall_data['tntfr_hr_acpt']; ?></b>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="counterBox text-center row" style="background-color: #31863f; background-image: linear-gradient(to top, #ffbf00 0%, #ffbf00 100%); margin: 0 auto; width: 100%; height: 170px;">
                            <div class="col-md-12 text-white counterIcon"><i class="fa fa-hourglass"></i></div>
                            <div class="col-md-12 text-white text-center counterInfo">
                                <span style="font-size: 12px;">Feedback Not Accepted</span> <br />
                                <b><?php echo $overall_data['not_accepted_count']; ?></b>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="counterBox text-center row" style="background-color: #31863f; background-image: linear-gradient(to top, #f75257 0%, #eb343a 100%); margin: 0 auto; width: 100%; height: 170px;">
                            <div class="col-md-12 text-white counterIcon"><i class="fa fa-thumbs-down"></i></div>
                            <div class="col-md-12 text-white text-center counterInfo">
                                <span style="font-size: 12px;">Feedback Rebuttal Raised</span> <br />
                                <b><?php echo $overall_data['rebuttal_count']; ?></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br/>
	
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-body table-responsive">
					<table style="margin-top: 10px;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
						<thead>
							<tr class='bg-info'>
								<th>#</th>
								<th>Process</th>
								<th>Feedback Raised</th>
								<th>Feedback Accepted &lt;24 hrs</th>
								<th>Feedback Accepted &lt;24 hrs %</th>
								<th>Feedback Accepted Post 24 hrs</th>
								<th>Feedback Accepted Post 24 hrs %</th>
								<th>Feedback Accepted</th>
								<th>Overall Acceptance %</th>
								<th>Feedback Not Accepted</th>
								<th>Feedback Not Accepted %</th>
								<th>Rebuttal Raised</th>
								<th>Rebuttal Raised %</th>
							</tr>
						</thead>
						<tbody>
							<?php $cn = 1;
								if(!empty($overall_data)):
								$od = $overall_data;

								/*$accept_per = number_format(($od['tntfr_hr_acpt']/$od['approved_audit'])*100,2);
								$post_24_acpt = $od['accept_count'] - $od['tntfr_hr_acpt'];
								$post_24_accept_per = number_format(($post_24_acpt/$od['approved_audit'])*100,2);
								$overall_accept_per = number_format(($od['accept_count']/$od['approved_audit'])*100,2);
								$not_accept_per = number_format(($od['not_accepted_count']/$od['approved_audit'])*100,2);
								$rebuttal_per = number_format(($od['rebuttal_count']/$od['approved_audit'])*100,2);*/

								$accept_per = $od['tntfr_hr_acpt'];
								$post_24_acpt = $od['accept_count'] - $od['tntfr_hr_acpt'];
								$post_24_accept_per = $post_24_acpt;
								$overall_accept_per = $od['accept_count'];
								$not_accept_per = $od['not_accepted_count'];
								$rebuttal_per = $od['rebuttal_count'];
							?>
							<tr>
								<td class="text-center"><?php echo $cn++; ?></td>
								<td class="text-center"><b><?php echo $od['process'] ?><b></td>
								<td class="text-center"><b><?php echo $od['total_feedback'] ?></b></td>
								<td class="text-center"><?php echo $od['tntfr_hr_acpt'] ?></td>
								<td class="text-center"><?php echo $accept_per.'%' ?></td>
								<td class="text-center"><?php echo $post_24_acpt ?></td>
								<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
								<td class="text-center"><?php echo $od['accept_count'] ?></td>
								<td class="text-center"><?php echo $overall_accept_per.'%' ?></td>
								<td class="text-center"><?php echo $od['not_accepted_count'] ?></td>
								<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
								<td class="text-center"><?php echo $od['rebuttal_count'] ?></td>
								<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<!-- <div class="row">
	    <div class="col-md-4">
		  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> LOB Wise Acceptance Analytics</h4>
		</div>
	</div>
	<div class="row">
	<div class="col-md-12">
	<div class="table-responsive">
			<table style="margin-top: 10px;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
				<thead>
					<tr class='bg-info'>
						<th>#</th>
						<th>LOB</th>
						<th>Feedback Raised</th>
						<th>Feedback Accepted &lt;24 hrs</th>
						<th>Feedback Accepted &lt;24 hrs %</th>
						<th>Feedback Accepted Post 24 hrs</th>
						<th>Feedback Accepted Post 24 hrs %</th>
						<th>Feedback Accepted</th>
						<th>Overall Acceptance %</th>
						<th>Feedback Not Accepted</th>
						<th>Feedback Not Accepted %</th>
						<th>Rebuttal Raised</th>
						<th>Rebuttal Raised %</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$cn = 1;
				foreach($lobwise_data as $lob_data){
					if($lob_data['approved_audit']!=0||$lob_data['tntfr_hr_acpt']!=0){
					$accept_per = number_format(($lob_data['tntfr_hr_acpt']/$lob_data['approved_audit'])*100,2);
					}else{
						$accept_per = 0;
					}
					$post_24_acpt = $lob_data['accept_count'] - $lob_data['tntfr_hr_acpt'];
					if($lob_data['approved_audit']!=0||$post_24_acpt!=0){
					$post_24_accept_per = number_format(($post_24_acpt/$lob_data['approved_audit'])*100,2);
					}else{
						$post_24_accept_per = 0;
					}
					if($lob_data['approved_audit']!=0||$lob_data['accept_count']!=0){
					$overall_accept_per = number_format(($lob_data['accept_count']/$lob_data['approved_audit'])*100,2);
					}else{
						$overall_accept_per = 0;
					}
					if($lob_data['approved_audit']!=0||$lob_data['not_accepted_count']!=0){
					$not_accept_per = number_format(($lob_data['not_accepted_count']/$lob_data['approved_audit'])*100,2);
					}else{
						$not_accept_per = 0;
					}
					if($lob_data['approved_audit']!=0||$lob_data['rebuttal_count']!=0){
					$rebuttal_per = number_format(($lob_data['rebuttal_count']/$lob_data['approved_audit'])*100,2);
					}else{
						$rebuttal_per = 0;
					}
				?>
				<tr>
					<td class="text-center"><?php echo $cn++; ?></td>
					<td class="text-center"><b><?php echo $lob_data['lob_campaign'] ?><b></td>
					<td class="text-center"><b><?php echo $lob_data['total_feedback'] ?></b></td>
					<td class="text-center"><?php echo $lob_data['tntfr_hr_acpt'] ?></td>
					<td class="text-center"><?php echo $accept_per.'%' ?></td>
					<td class="text-center"><?php echo $post_24_acpt ?></td>
					<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
					<td class="text-center"><?php echo $lob_data['accept_count'] ?></td>
					<td class="text-center"><?php echo $overall_accept_per.'%' ?></td>
					<td class="text-center"><?php echo $lob_data['not_accepted_count'] ?></td>
					<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
					<td class="text-center"><?php echo $lob_data['rebuttal_count'] ?></td>
					<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	
	</div> -->

	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-body table-responsive">
					<span style="font-weight:bold; font-size:18px">TL Wise Acceptance Analytics:</span>
					<table id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
						<thead>
							<tr class='bg-info'>
							<th>#</th>
							<th>TL Name</th>
							<th>Feedback Raised</th>
							<th>Feedback Accepted &lt;24 hrs</th>
							<th>Feedback Accepted &lt;24 hrs %</th>
							<th>Feedback Accepted Post 24 hrs</th>
							<th>Feedback Accepted Post 24 hrs %</th>
							<th>Feedback Accepted</th>
							<th>Overall Acceptance %</th>
							<th>Feedback Not Accepted</th>
							<th>Feedback Not Accepted %</th>
							<th>Rebuttal Raised</th>
							<th>Rebuttal Raised %</th>
							</tr>
						</thead>
						<tbody>
						<?php $cn = 1;
						foreach($tlwise_data as $tl_data):

							/*$accept_per = number_format(($tl_data['tntfr_hr_acpt']/$tl_data['approved_audit'])*100,2);
							$post_24_acpt = $tl_data['accept_count'] - $tl_data['tntfr_hr_acpt'];
							$post_24_accept_per = number_format(($post_24_acpt/$tl_data['approved_audit'])*100,2);
							$overall_accept_per = number_format(($tl_data['accept_count']/$tl_data['approved_audit'])*100,2);
							$not_accept_per = number_format(($tl_data['not_accepted_count']/$tl_data['approved_audit'])*100,2);
							$rebuttal_per = number_format(($tl_data['rebuttal_count']/$tl_data['approved_audit'])*100,2);*/

							$accept_per = $tl_data['tntfr_hr_acpt'];
							$post_24_acpt = $tl_data['accept_count'] - $tl_data['tntfr_hr_acpt'];
							$post_24_accept_per = $post_24_acpt;
							$overall_accept_per = $tl_data['accept_count'];
							$not_accept_per = $tl_data['not_accepted_count'];
							$rebuttal_per = $tl_data['rebuttal_count'];
						?>
						<tr>
							<td class="text-center"><?php echo $cn++; ?></td>
							<td class="text-center"><b><?php echo $tl_data['tl_name'] ?><b></td>
							<td class="text-center"><b><?php echo $tl_data['total_feedback'] ?></b></td>
							<td class="text-center"><?php echo $tl_data['tntfr_hr_acpt'] ?></td>
							<td class="text-center"><?php echo $accept_per.'%' ?></td>
							<td class="text-center"><?php echo $post_24_acpt ?></td>
							<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
							<td class="text-center"><?php echo $tl_data['accept_count'] ?></td>
							<td class="text-center"><?php echo $overall_accept_per.'%' ?></td>
							<td class="text-center"><?php echo $tl_data['not_accepted_count'] ?></td>
							<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
							<td class="text-center"><?php echo $tl_data['rebuttal_count'] ?></td>
							<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-body table-responsive">
					<span style="font-weight:bold; font-size:18px">QA Wise Acceptance Analytics:</span>
						<table style="margin-top: 10px;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
						<thead>
							<tr class='bg-info'>
							<th>#</th>
							<th>QA Name</th>
							<th>Department</th>
							<th>Feedback Raised</th>
							<th>Feedback Accepted &lt;24 hrs</th>
							<th>Feedback Accepted &lt;24 hrs %</th>
							<th>Feedback Accepted Post 24 hrs</th>
							<th>Feedback Accepted Post 24 hrs %</th>
							<th>Feedback Accepted</th>
							<th>Overall Acceptance %</th>
							<th>Feedback Not Accepted</th>
							<th>Feedback Not Accepted %</th>
							<th>Rebuttal Raised</th>
							<th>Rebuttal Raised %</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$cn = 1;
							foreach($qawise_data as $qa_data):

								/*$accept_per = number_format(($qa_data['tntfr_hr_acpt']/$qa_data['approved_audit'])*100,2);
								$post_24_acpt = $qa_data['accept_count'] - $qa_data['tntfr_hr_acpt'];
								$post_24_accept_per = number_format(($post_24_acpt/$qa_data['approved_audit'])*100,2);
								$overall_accept_per = number_format(($qa_data['accept_count']/$qa_data['approved_audit'])*100,2);
								$not_accept_per = number_format(($qa_data['not_accepted_count']/$qa_data['approved_audit'])*100,2);
								$rebuttal_per = number_format(($qa_data['rebuttal_count']/$qa_data['approved_audit'])*100,2);*/

								$accept_per = $qa_data['tntfr_hr_acpt'];
								$post_24_acpt = $qa_data['accept_count'] - $qa_data['tntfr_hr_acpt'];
								$post_24_accept_per = $post_24_acpt;
								$overall_accept_per = $qa_data['accept_count'];
								$not_accept_per = $qa_data['not_accepted_count'];
								$rebuttal_per = $qa_data['rebuttal_count'];
						?>
							<tr>
								<td class="text-center"><?php echo $cn++; ?></td>
								<td class="text-center"><b><?php echo $qa_data['qa_name'] ?><b></td>
								<td class="text-center"><?php echo $qa_data['department'] ?></td>
								<td class="text-center"><b><?php echo $qa_data['total_feedback'] ?></b></td>
								<td class="text-center"><?php echo $qa_data['tntfr_hr_acpt'] ?></td>
								<td class="text-center"><?php echo $accept_per.'%' ?></td>
								<td class="text-center"><?php echo $post_24_acpt ?></td>
								<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
								<td class="text-center"><?php echo $qa_data['accept_count'] ?></td>
								<td class="text-center"><?php echo $overall_accept_per.'%' ?></td>
								<td class="text-center"><?php echo $qa_data['not_accepted_count'] ?></td>
								<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
								<td class="text-center"><?php echo $qa_data['rebuttal_count'] ?></td>
								<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-body table-responsive">
					<span style="font-weight:bold; font-size:18px">Agent Wise Acceptance Analytics:</span>
					<table style="margin-top: 10px;" class="table-striped  table-condensed" cellspacing="0" width="100%">
						<thead>
							<tr class='bg-info'>
							<th>#</th>
							<th>Employee ID</th>
							<th>Agent Name</th>
							<th>Supervisor Name</th>
							<th>Feedback Raised</th>
							<th>Feedback Accepted &lt;24 hrs</th>
							<th>Feedback Accepted &lt;24 hrs %</th>
							<th>Feedback Accepted Post 24 hrs</th>
							<th>Feedback Accepted Post 24 hrs %</th>
							<th>Feedback Accepted</th>
							<th>Overall Acceptance %</th>
							<th>Feedback Not Accepted</th>
							<th>Feedback Not Accepted %</th>
							<th>Rebuttal Raised</th>
							<th>Rebuttal Raised %</th>
							</tr>
						</thead>
						<tbody>
							<?php $cn = 1;
							foreach($agentwise_data as $agent_data):

							/*if($agent_data['approved_audit']!=0||$agent_data['tntfr_hr_acpt']!=0){
							$accept_per = number_format(($agent_data['tntfr_hr_acpt']/$agent_data['approved_audit'])*100,2);
							}else{
								$accept_per = 0;
							}
							$post_24_acpt = $agent_data['accept_count'] - $agent_data['tntfr_hr_acpt'];
							if($post_24_acpt!=0||$agent_data['approved_audit']!=0){
							$post_24_accept_per = number_format(($post_24_acpt/$agent_data['approved_audit'])*100,2);
							}else{
								$post_24_accept_per = 0;
							}
							if($agent_data['accept_count']!=0||$agent_data['approved_audit']!=0){
							$overall_accept_per = number_format(($agent_data['accept_count']/$agent_data['approved_audit'])*100,2);
							}else{
								$overall_accept_per = 0;
							}
							if($agent_data['not_accepted_count']!=0||$agent_data['approved_audit']!=0){
							$not_accept_per = number_format(($agent_data['not_accepted_count']/$agent_data['approved_audit'])*100,2);
							}else{
								$not_accept_per = 0;
							}
							if($agent_data['rebuttal_count']!=0||$agent_data['approved_audit']!=0){
							$rebuttal_per = number_format(($agent_data['rebuttal_count']/$agent_data['approved_audit'])*100,2);
							}else{
								$rebuttal_per = 0;
							}*/
							$accept_per = $agent_data['tntfr_hr_acpt'];
							$post_24_acpt = $agent_data['accept_count'] - $agent_data['tntfr_hr_acpt'];
							$post_24_accept_per = $post_24_acpt;
							$overall_accept_per = $agent_data['accept_count'];
							$not_accept_per = $agent_data['not_accepted_count'];
							$rebuttal_per = $agent_data['rebuttal_count'];
							?>
							<tr>
								<td class="text-center"><?php echo $cn++; ?></td>
								<td class="text-center"><b><?php echo $agent_data['xpoid'] ?><b></td>
								<td class="text-center"><b><?php echo ucwords(strtolower($agent_data['agent_name'])) ?><b></td>
								<td class="text-center"><b><?php echo $agent_data['tl_name'] ?><b></td>
								<td class="text-center"><b><?php echo $agent_data['total_feedback'] ?></b></td>
								<td class="text-center"><?php echo $agent_data['tntfr_hr_acpt'] ?></td>
								<td class="text-center"><?php echo $accept_per.'%' ?></td>
								<td class="text-center"><?php echo $post_24_acpt ?></td>
								<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
								<td class="text-center"><?php echo $agent_data['accept_count'] ?></td>
								<td class="text-center"><?php echo $overall_accept_per.'%' ?></td>
								<td class="text-center"><?php echo $agent_data['not_accepted_count'] ?></td>
								<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
								<td class="text-center"><?php echo $agent_data['rebuttal_count'] ?></td>
								<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
		
</section>
</div>