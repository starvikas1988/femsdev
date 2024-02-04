<style>
.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td{vertical-align:middle;padding:2px;font-size:11px;}.table > thead > tr > th,.table > tfoot > tr > th{text-align:center;}.panel .table td, .panel .table th{font-size:11px;padding:6px;}.hide{disply:none;}.modal-dialog{width: 800px;}.modal{overflow:auto;}/*---------- MY CUSTOM CSS -----------*/.rounded{-webkit-border-radius: 3px !important; -moz-border-radius: 3px !important; border-radius: 3px !important;}.mini-stat{padding: 5px; margin-bottom: 20px;}.mini-stat-icon{width: 30px; height: 30px; display: inline-block; line-height: 30px; text-align: center; font-size: 15px; background: none repeat scroll 0% 0% #EEE; border-radius: 100%; float: left; margin-right: 10px; color: #FFF;}.mini-stat-info{font-size: 12px; padding-top: 2px;}span, p{/*color: white;*/}.mini-stat-info span{display: block; font-size: 20px; font-weight: 600; margin-bottom: 5px; margin-top: 7px;}/*================colors=====================*/.bg-facebook{background-color: #3b5998 !important; border: 1px solid #3b5998; color: white;}.fg-facebook{color: #3b5998 !important;}.bg-twitter{background-color: #00a0d1 !important; border: 1px solid #00a0d1; color: white;}.fg-twitter{color: #00a0d1 !important;}.bg-googleplus{background-color: #db4a39 !important; border: 1px solid #db4a39; color: white;}.fg-googleplus{color: #db4a39 !important;}.bg-bitbucket{background-color: #205081 !important; border: 1px solid #205081; color: white;}.fg-bitbucket{color: #205081 !important;}.highcharts-credits{display: none !important;}.text-box{background-color: #fff;padding: 10px 10px;margin:5px 5px 25px 5px;border-radius: 4px;}.text-headbox{margin-top: 5px;text-align:center;}.bhead{padding: 5px 8px;color: #000;font-size: 20px;letter-spacing: 0.8px;font-weight: 600;text-align:center;}.bheadInfo{padding: 2px 8px;color: #000;font-size: 16px;letter-spacing: 1px;font-weight: 600;}.btext{background-color: #d4eff7;padding: 17px;border-radius: 20px 0px 0px 0px;font-size: 25px;}.boxShape{background-color: #fff797;padding: 10px 20px;width: 80%;border-radius: 10px;}.initialInfo{font-size: 45px;padding: 5px 10px;}.laterInfo{font-size: 19px; padding: 20px 5px 20px 5px;}.counterBox{background-color: #fff797;padding: 10px 20px;width: 100%;border-radius: 10px;}.counterIcon{font-size: 45px;padding: 5px 10px;}.counterInfo{font-size: 16px;}.prizeNumber{border: 2px solid #f4ff4d;border-radius: 50%;padding: 7px 12px;margin: 0px 10px 0px 0px;background-color: #000;font-size:16px;}.rankInfo{margin: 18px 10px;}/*28-07-22---table-header-fixed-css*/.tbl-container{max-width: fit-content;max-height: fit-content;}.tbl-fixed{overflow-x: scroll;overflow-y:scroll ;height: fit-content;max-height: 500px;}.tbl-container table{min-width: max-content;border-collapse: separate;}.tbl-container table th{position: sticky;top: 0px;background: #35b8e0;border: 1px solid #E2E2E2;padding: 2px; font-size: 11px;}.tbl-container table td{border: 1px solid #E2E2E2;padding: 2px;font-size: 11px;}
</style>


<div class="wrap">
	<nav aria-label="breadcrumb">
	    <ol class="breadcrumb" style="margin-bottom: 8px !important; background-color: #fff;">
	        <li class="breadcrumb-item">CQ Dashboard</li>
	        <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo base_url("qa_graph/acceptance_dashboard");?>">Acceptance Dashboard</a></li>
	    </ol>
	</nav>

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
								<div class="col-md-3">
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
								<?php $exist_process_lob_campaign = is_exist_process_lob_campaign_table();
                                if($exist_process_lob_campaign['process']==true){ ?>
								<div class="col-md-3">
									<div class="form-group" style="padding:2px 10px 2px 0px">
										<label for="ssdate">Select Process</label>
										<select class="form-control" name="process_id[]" id="process_id" required multiple>
										<?php if(in_array('ALL',$selected_process)){ $selectp = "selected"; } ?>
										<option value='ALL' <?php echo $selectp; ?>>All Process</option>
										<?php foreach($new_process_list as $process){
											$selectpr = "";
											if(in_array($process['id'],$selected_process)){ $selectpr = "selected"; } ?>
											<option value="<?php echo $process['id'] ?>" <?php echo $selectpr ?>><?php echo $process['process_name'] ?></option>
											<?php } ?>								
										</select>
									</div>
								</div>
								<?php }
                                if($exist_process_lob_campaign['lob']==true){ ?>
								<div class="col-md-3">
									<div class="form-group">
										<label>LOB</label>
										<select class="form-control" name="lob_id[]" id="lob_id" multiple>
										</select>
									</div>
								</div>
								<?php }
                                if($exist_process_lob_campaign['campaign']==true){ ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Campaign</label>
                                        <select class="form-control" name="campaign_id[]" id="campaign_id" required multiple>
                                            <option value=''>Select Campaign</option>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Audit Sheet</label>
                                        <select class="form-control" name="audit_sheet[]" id="audit_sheet" required multiple>
                                            <option value=''>Select Audit Sheet</option>
                                        </select>
                                    </div>
                                </div>
								<div class="col-md-3">
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
								<div class="col-md-3">
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

								<div class="col-md-3">
									<div class="form-group">
										<label>Start Date</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo $selected_from_date ?>" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>End Date</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo $selected_to_date ?>" class="form-control" readonly>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group" style="margin-top:20px">
										<input type="submit" class="btn btn-primary btn-md" name='submitgraph' value="Search">
										<?php if(!empty($_SERVER['QUERY_STRING'])):?>
					                       <a class="btn btn-warning" href="<?php echo base_url('Dyn_acceptance_dashboard?').$_SERVER['QUERY_STRING'].'&excel_report=true';?>">EXPORT REPORT</a>
					                    <?php endif;?>
									</div>
								</div>
							</div>
						</form>		
					</div>
				</div>
			</div>
		</div>
		<div class="widget">
			<hr class="widget-separator"/>
			<div class="widget-body clearfix">
				<div class="row">
				    <div class="col-md-12">
					  <h4 style="text-align: center;color: rgb(51, 51, 51);">Acceptance Analytics ( Total Feedback Raised: <?php echo $overall_data['total_feedback']; ?> )</h4>
					</div>
				</div>
				<div class="row" style="margin-top: 30px;">
					<div class="col-md-6"><div id="acceptance-analytics-chart-1"></div></div>
					<div class="col-md-6"><div id="acceptance-analytics-chart-2"></div></div>
				</div>
			    
				<?php $acceptance_analytics_graph_overall_value = array($overall_data['total_feedback'],$overall_data['tntfr_hr_acpt'],($overall_data['accept_count']-$overall_data['tntfr_hr_acpt']),$overall_data['not_accepted_count'],$overall_data['rebuttal_count']); ?>
			</div>
		</div>
		<br/>
		<?php if($exist_process_lob_campaign['process']==true){ ?>
		<div class="widget">	
			<div class="widget-body clearfix">
				<div class="row">
					<div class="col-md-12"><div id="process-wise-chart"></div></div>
				</div>
			    <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table style="margin-top: 10px;white-space: nowrap !important;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>#</th>
										<th>Process</th>
										<th>Feedback Raised</th>
										<th>Feedback Accepted within 24 hour</th>
										<th>Feedback Accepted within 24 hour %</th>
										<th>Feedback Accepted Post 24 hrs</th>
										<th>Feedback Accepted Post 24 hrs %</th>
										<!--<th>Feedback Accepted</th>
										<th>Overall Acceptance %</th>-->
										<th>Feedback Not Accepted</th>
										<th>Feedback Not Accepted %</th>
										<th>Rebuttal Raised</th>
										<th>Rebuttal Raised %</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 1;
								  /*For graph*/
	                              $process_wise_graph_xAxis = array();
	                              $process_wise_graph_feedback_raised = array();
	                              $process_wise_graph_feedback_accepted_less24hrs = array();
	                              $process_wise_graph_feedback_accepted_post24hrs = array();
	                              $process_wise_graph_feedback_not_accepted = array();
	                              $process_wise_graph_feedback_rebuttal = array();

								foreach($pro_wise_data as $pro_data){
									if($pro_data['total_feedback']!=0||$pro_data['tntfr_hr_acpt']!=0){
									$accept_per = number_format(($pro_data['tntfr_hr_acpt']/$pro_data['total_feedback'])*100,2);
									}else{
										$accept_per = 0;
									}
									$post_24_acpt = $pro_data['accept_count'] - $pro_data['tntfr_hr_acpt'];
									if($pro_data['total_feedback']!=0||$post_24_acpt!=0){
									$post_24_accept_per = number_format(($post_24_acpt/$pro_data['total_feedback'])*100,2);
									}else{
										$post_24_accept_per = 0;
									}
									if($pro_data['total_feedback']!=0||$pro_data['accept_count']!=0){
									$overall_accept_per = number_format(($pro_data['accept_count']/$pro_data['total_feedback'])*100,2);
									}else{
										$overall_accept_per = 0;
									}
									if($pro_data['total_feedback']!=0||$pro_data['not_accepted_count']!=0){
									$not_accept_per = number_format(($pro_data['not_accepted_count']/$pro_data['total_feedback'])*100,2);
									}else{
										$not_accept_per = 0;
									}
									if($pro_data['total_feedback']!=0||$pro_data['rebuttal_count']!=0){
									$rebuttal_per = number_format(($pro_data['rebuttal_count']/$pro_data['total_feedback'])*100,2);
									}else{
										$rebuttal_per = 0;
									}

									array_push($process_wise_graph_xAxis,$pro_data['process']);
                                 	array_push($process_wise_graph_feedback_raised,$pro_data['total_feedback']);
                                 	array_push($process_wise_graph_feedback_accepted_less24hrs,$pro_data['tntfr_hr_acpt']);
                                 	array_push($process_wise_graph_feedback_accepted_post24hrs,$post_24_acpt);
                                 	array_push($process_wise_graph_feedback_not_accepted,$pro_data['not_accepted_count']);
                                 	array_push($process_wise_graph_feedback_rebuttal,$pro_data['rebuttal_count']);
									?>
								<tr>
									<td class="text-center"><?php echo $cn++; ?></td>
									<td class="text-center"><b><?php echo $pro_data['process'] != ''? getProcessName($pro_data['process']):'' ?><b></td>
									<td class="text-center"><b><?php echo $pro_data['total_feedback'] ?></b></td>
									<td class="text-center"><?php echo $pro_data['tntfr_hr_acpt'] ?></td>
									<td class="text-center"><?php echo $accept_per.'%' ?></td>
									<td class="text-center"><?php echo $post_24_acpt ?></td>
									<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
									<!--<td class="text-center"><?php //echo $pro_data['accept_count'] ?></td>
									<td class="text-center"><?php //echo $overall_accept_per.'%' ?></td>-->
									<td class="text-center"><?php echo $pro_data['not_accepted_count'] ?></td>
									<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
									<td class="text-center"><?php echo $pro_data['rebuttal_count'] ?></td>
									<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
								</tr>
								<?php } ?>
								
								<?php 
									if(!empty($overall_data)){
									$od = $overall_data;
									if($od['tntfr_hr_acpt']!= 0 || $od['total_feedback']!=0){
									$accept_per = number_format(($od['tntfr_hr_acpt']/$od['total_feedback'])*100,2);
									}else{
										$accept_per = 0;
									}
									$post_24_acpt = $od['accept_count'] - $od['tntfr_hr_acpt'];
									if($post_24_accept_per!= 0 || $od['total_feedback']!=0){
									$post_24_accept_per = number_format(($post_24_acpt/$od['total_feedback'])*100,2);
									}else{
										$post_24_accept_per = 0;
									}
									if($od['accept_count']!= 0 || $od['total_feedback']!=0){
									$overall_accept_per = number_format(($od['accept_count']/$od['total_feedback'])*100,2);
									}else{
										$overall_accept_per = 0;
									}
									if($od['not_accepted_count']!= 0 || $od['total_feedback']!=0){
									$not_accept_per = number_format(($od['not_accepted_count']/$od['total_feedback'])*100,2);
									}else{
										$not_accept_per = 0;
									}
									if($od['rebuttal_count']!= 0 || $od['total_feedback']!=0){
									$rebuttal_per = number_format(($od['rebuttal_count']/$od['total_feedback'])*100,2);
									}else{
										$rebuttal_per = 0;
									}
								?>
								<tr>
									<td class="text-center"><?php echo "" ?></td>
									<td class="text-center"><b><?php echo $od['process'] ?><b></td>
									<td class="text-center"><b><?php echo $od['total_feedback'] ?></b></td>
									<td class="text-center"><?php echo $od['tntfr_hr_acpt'] ?></td>
									<td class="text-center"><?php echo $accept_per.'%' ?></td>
									<td class="text-center"><?php echo $post_24_acpt ?></td>
									<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
									<!--<td class="text-center"><?php //echo $od['accept_count'] ?></td>
									<td class="text-center"><?php //echo $overall_accept_per.'%' ?></td>-->
									<td class="text-center"><?php echo $od['not_accepted_count'] ?></td>
									<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
									<td class="text-center"><?php echo $od['rebuttal_count'] ?></td>
									<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
								</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php }
		if($exist_process_lob_campaign['lob']==true){ ?>
		<div class="widget">	
			<div class="widget-body clearfix">
				<!-- <div class="row">
				    <div class="col-md-4">
					  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> LOB Wise Acceptance Analytics</h4>
					</div>
				</div>
				<hr> -->
				<div class="row">
					<div class="col-md-12"><div id="lob-wise-chart"></div></div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table style="margin-top: 10px;white-space: nowrap !important;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>#</th>
										<th>LOB</th>
										<th>Feedback Raised</th>
										<th>Feedback Accepted within 24 hour hrs</th>
										<th>Feedback Accepted within 24 hour hrs %</th>
										<th>Feedback Accepted Post 24 hrs</th>
										<th>Feedback Accepted Post 24 hrs %</th>
										<!--<th>Feedback Accepted</th>
										<th>Overall Acceptance %</th>-->
										<th>Feedback Not Accepted</th>
										<th>Feedback Not Accepted %</th>
										<th>Rebuttal Raised</th>
										<th>Rebuttal Raised %</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 1;
								/*For graph*/
	                            $lob_wise_graph_xAxis = array();
	                            $lob_wise_graph_feedback_raised = array();
	                            $lob_wise_graph_feedback_accepted_less24hrs = array();
	                            $lob_wise_graph_feedback_accepted_post24hrs = array();
	                            $lob_wise_graph_feedback_not_accepted = array();
	                            $lob_wise_graph_feedback_rebuttal = array();

								foreach($lobwise_data as $lob_data){
									if($lob_data['total_feedback']!=0||$lob_data['tntfr_hr_acpt']!=0){
									$accept_per = number_format(($lob_data['tntfr_hr_acpt']/$lob_data['total_feedback'])*100,2);
									}else{
										$accept_per = 0;
									}
									$post_24_acpt = $lob_data['accept_count'] - $lob_data['tntfr_hr_acpt'];
									if($lob_data['total_feedback']!=0||$post_24_acpt!=0){
									$post_24_accept_per = number_format(($post_24_acpt/$lob_data['total_feedback'])*100,2);
									}else{
										$post_24_accept_per = 0;
									}
									if($lob_data['total_feedback']!=0||$lob_data['accept_count']!=0){
									$overall_accept_per = number_format(($lob_data['accept_count']/$lob_data['total_feedback'])*100,2);
									}else{
										$overall_accept_per = 0;
									}
									if($lob_data['total_feedback']!=0||$lob_data['not_accepted_count']!=0){
									$not_accept_per = number_format(($lob_data['not_accepted_count']/$lob_data['total_feedback'])*100,2);
									}else{
										$not_accept_per = 0;
									}
									if($lob_data['total_feedback']!=0||$lob_data['rebuttal_count']!=0){
									$rebuttal_per = number_format(($lob_data['rebuttal_count']/$lob_data['total_feedback'])*100,2);
									}else{
										$rebuttal_per = 0;
									}

									array_push($lob_wise_graph_xAxis,$lob_data['lob_name']);
                                 	array_push($lob_wise_graph_feedback_raised,$lob_data['total_feedback']);
                                 	array_push($lob_wise_graph_feedback_accepted_less24hrs,$lob_data['tntfr_hr_acpt']);
                                 	array_push($lob_wise_graph_feedback_accepted_post24hrs,$post_24_acpt);
                                 	array_push($lob_wise_graph_feedback_not_accepted,$lob_data['not_accepted_count']);
                                 	array_push($lob_wise_graph_feedback_rebuttal,$lob_data['rebuttal_count']);
								?>
								<tr>
									<td class="text-center"><?php echo $cn++; ?></td>
									<td class="text-center"><b><?php echo $lob_data['lob_name'] ?><b></td>
									<td class="text-center"><b><?php echo $lob_data['total_feedback'] ?></b></td>
									<td class="text-center"><?php echo $lob_data['tntfr_hr_acpt'] ?></td>
									<td class="text-center"><?php echo $accept_per.'%' ?></td>
									<td class="text-center"><?php echo $post_24_acpt ?></td>
									<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
									<!--<td class="text-center"><?php //echo $lob_data['accept_count'] ?></td>
									<td class="text-center"><?php //echo $overall_accept_per.'%' ?></td>-->
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
				</div>
			</div>
		</div>
		<?php }
		if($exist_process_lob_campaign['campaign']==true){  ?>
		<div class="widget">	
			<div class="widget-body clearfix">
				<!-- <div class="row">
				    <div class="col-md-4">
					  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> LOB Wise Acceptance Analytics</h4>
					</div>
				</div>
				<hr> -->
				<div class="row">
					<div class="col-md-12"><div id="campaign-wise-chart"></div></div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table style="margin-top: 10px;white-space: nowrap !important;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>#</th>
										<th>Campaign</th>
										<th>Feedback Raised</th>
										<th>Feedback Accepted within 24 hour hrs</th>
										<th>Feedback Accepted within 24 hour hrs %</th>
										<th>Feedback Accepted Post 24 hrs</th>
										<th>Feedback Accepted Post 24 hrs %</th>
										<!--<th>Feedback Accepted</th>
										<th>Overall Acceptance %</th>-->
										<th>Feedback Not Accepted</th>
										<th>Feedback Not Accepted %</th>
										<th>Rebuttal Raised</th>
										<th>Rebuttal Raised %</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 1;
								/*For graph*/
	                            $campaign_wise_graph_xAxis = array();
	                            $campaign_wise_graph_feedback_raised = array();
	                            $campaign_wise_graph_feedback_accepted_less24hrs = array();
	                            $campaign_wise_graph_feedback_accepted_post24hrs = array();
	                            $campaign_wise_graph_feedback_not_accepted = array();
	                            $campaign_wise_graph_feedback_rebuttal = array();

								foreach($campaignwise_data as $campaign_data){
									if($campaign_data['total_feedback']!=0||$campaign_data['tntfr_hr_acpt']!=0){
									$accept_per = number_format(($campaign_data['tntfr_hr_acpt']/$campaign_data['total_feedback'])*100,2);
									}else{
										$accept_per = 0;
									}
									$post_24_acpt = $campaign_data['accept_count'] - $campaign_data['tntfr_hr_acpt'];
									if($campaign_data['total_feedback']!=0||$post_24_acpt!=0){
									$post_24_accept_per = number_format(($post_24_acpt/$campaign_data['total_feedback'])*100,2);
									}else{
										$post_24_accept_per = 0;
									}
									if($campaign_data['total_feedback']!=0||$campaign_data['accept_count']!=0){
									$overall_accept_per = number_format(($campaign_data['accept_count']/$campaign_data['total_feedback'])*100,2);
									}else{
										$overall_accept_per = 0;
									}
									if($campaign_data['total_feedback']!=0||$campaign_data['not_accepted_count']!=0){
									$not_accept_per = number_format(($campaign_data['not_accepted_count']/$campaign_data['total_feedback'])*100,2);
									}else{
										$not_accept_per = 0;
									}
									if($campaign_data['total_feedback']!=0||$campaign_data['rebuttal_count']!=0){
									$rebuttal_per = number_format(($campaign_data['rebuttal_count']/$campaign_data['total_feedback'])*100,2);
									}else{
										$rebuttal_per = 0;
									}

									array_push($campaign_wise_graph_xAxis,$campaign_data['campaign_name']);
                                 	array_push($campaign_wise_graph_feedback_raised,$campaign_data['total_feedback']);
                                 	array_push($campaign_wise_graph_feedback_accepted_less24hrs,$campaign_data['tntfr_hr_acpt']);
                                 	array_push($campaign_wise_graph_feedback_accepted_post24hrs,$post_24_acpt);
                                 	array_push($campaign_wise_graph_feedback_not_accepted,$campaign_data['not_accepted_count']);
                                 	array_push($campaign_wise_graph_feedback_rebuttal,$campaign_data['rebuttal_count']);
								?>
								<tr>
									<td class="text-center"><?php echo $cn++; ?></td>
									<td class="text-center"><b><?php echo $campaign_data['campaign_name'] ?><b></td>
									<td class="text-center"><b><?php echo $campaign_data['total_feedback'] ?></b></td>
									<td class="text-center"><?php echo $campaign_data['tntfr_hr_acpt'] ?></td>
									<td class="text-center"><?php echo $accept_per.'%' ?></td>
									<td class="text-center"><?php echo $post_24_acpt ?></td>
									<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
									<!--<td class="text-center"><?php //echo $campaign_data['accept_count'] ?></td>
									<td class="text-center"><?php //echo $overall_accept_per.'%' ?></td>-->
									<td class="text-center"><?php echo $campaign_data['not_accepted_count'] ?></td>
									<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
									<td class="text-center"><?php echo $campaign_data['rebuttal_count'] ?></td>
									<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
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

		<div class="widget">	
			<div class="widget-body clearfix">
				<!-- <div class="row">
				    <div class="col-md-4">
					  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Audit Sheet Wise Acceptance Analytics</h4>
					</div>
				</div>
				<hr> -->
				<div class="row">
					<div class="col-md-12"><div id="asheet-wise-chart"></div></div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table style="margin-top: 10px;white-space: nowrap !important;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>#</th>
										<th>Audit Sheet Name</th>
										<th>Feedback Raised</th>
										<th>Feedback Accepted within 24 hour hrs</th>
										<th>Feedback Accepted within 24 hour hrs %</th>
										<th>Feedback Accepted Post 24 hrs</th>
										<th>Feedback Accepted Post 24 hrs %</th>
										<!--<th>Feedback Accepted</th>
										<th>Overall Acceptance %</th>-->
										<th>Feedback Not Accepted</th>
										<th>Feedback Not Accepted %</th>
										<th>Rebuttal Raised</th>
										<th>Rebuttal Raised %</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 1;
								/*For graph*/
	                            $a_sheet_wise_graph_xAxis = array();
	                            $a_sheet_wise_graph_feedback_raised = array();
	                            $a_sheet_wise_graph_feedback_accepted_less24hrs = array();
	                            $a_sheet_wise_graph_feedback_accepted_post24hrs = array();
	                            $a_sheet_wise_graph_feedback_not_accepted = array();
	                            $a_sheet_wise_graph_feedback_rebuttal = array();

								foreach($asheetwisedata as $a_sheet_data){
									if($a_sheet_data['total_feedback']!=0||$a_sheet_data['tntfr_hr_acpt']!=0){
									$accept_per = number_format(($a_sheet_data['tntfr_hr_acpt']/$a_sheet_data['total_feedback'])*100,2);
									}else{
										$accept_per = 0;
									}
									$post_24_acpt = $a_sheet_data['accept_count'] - $a_sheet_data['tntfr_hr_acpt'];
									if($a_sheet_data['total_feedback']!=0||$post_24_acpt!=0){
									$post_24_accept_per = number_format(($post_24_acpt/$a_sheet_data['total_feedback'])*100,2);
									}else{
										$post_24_accept_per = 0;
									}
									if($a_sheet_data['total_feedback']!=0||$a_sheet_data['accept_count']!=0){
									$overall_accept_per = number_format(($a_sheet_data['accept_count']/$a_sheet_data['total_feedback'])*100,2);
									}else{
										$overall_accept_per = 0;
									}
									if($a_sheet_data['total_feedback']!=0||$a_sheet_data['not_accepted_count']!=0){
									$not_accept_per = number_format(($a_sheet_data['not_accepted_count']/$a_sheet_data['total_feedback'])*100,2);
									}else{
										$not_accept_per = 0;
									}
									if($a_sheet_data['total_feedback']!=0||$a_sheet_data['rebuttal_count']!=0){
									$rebuttal_per = number_format(($a_sheet_data['rebuttal_count']/$a_sheet_data['total_feedback'])*100,2);
									}else{
										$rebuttal_per = 0;
									}

									array_push($a_sheet_wise_graph_xAxis,(float)$a_sheet_data['audit_sheet_name']);
                                 	array_push($a_sheet_wise_graph_feedback_raised,(float)$a_sheet_data['total_feedback']);
                                 	array_push($a_sheet_wise_graph_feedback_accepted_less24hrs,(float)$a_sheet_data['tntfr_hr_acpt']);
                                 	array_push($a_sheet_wise_graph_feedback_accepted_post24hrs,(float)$post_24_acpt);
                                 	array_push($a_sheet_wise_graph_feedback_not_accepted,(float)$a_sheet_data['not_accepted_count']);
                                 	array_push($a_sheet_wise_graph_feedback_rebuttal,(float)$a_sheet_data['rebuttal_count']);
								?>
								<tr>
									<td class="text-center"><?php echo $cn++; ?></td>
									<td class="text-center"><b><?php echo $a_sheet_data['audit_sheet_name'] ?><b></td>
									<td class="text-center"><b><?php echo $a_sheet_data['total_feedback'] ?></b></td>
									<td class="text-center"><?php echo $a_sheet_data['tntfr_hr_acpt'] ?></td>
									<td class="text-center"><?php echo $accept_per.'%' ?></td>
									<td class="text-center"><?php echo $post_24_acpt ?></td>
									<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
									<!--<td class="text-center"><?php //echo $a_sheet_data['accept_count'] ?></td>
									<td class="text-center"><?php //echo $overall_accept_per.'%' ?></td>-->
									<td class="text-center"><?php echo $a_sheet_data['not_accepted_count'] ?></td>
									<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
									<td class="text-center"><?php echo $a_sheet_data['rebuttal_count'] ?></td>
									<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
								</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="widget">	
			<div class="widget-body clearfix">
				<!-- <div class="row">
				    <div class="col-md-4">
					  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> TL Wise Acceptance Analytics</h4>
					</div>
				</div>
				<hr> -->
				<div class="row">
					<div class="col-md-12"><div id="tl-wise-chart"></div></div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table style="margin-top: 10px;white-space: nowrap !important;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									<th>#</th>
									<th>TL Name</th>
									<th>Feedback Raised</th>
									<th>Feedback Accepted within 24 hour hrs</th>
									<th>Feedback Accepted within 24 hour hrs %</th>
									<th>Feedback Accepted Post 24 hrs</th>
									<th>Feedback Accepted Post 24 hrs %</th>
									<!--<th>Feedback Accepted</th>
									<th>Overall Acceptance %</th>-->
									<th>Feedback Not Accepted</th>
									<th>Feedback Not Accepted %</th>
									<th>Rebuttal Raised</th>
									<th>Rebuttal Raised %</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$cn = 1;
									/*For graph*/
		                            $tl_wise_graph_xAxis = array();
		                            $tl_wise_graph_feedback_raised = array();
		                            $tl_wise_graph_feedback_accepted_less24hrs = array();
		                            $tl_wise_graph_feedback_accepted_post24hrs = array();
		                            $tl_wise_graph_feedback_not_accepted = array();
		                            $tl_wise_graph_feedback_rebuttal = array();

									foreach($tlwise_data as $tl_data){
										if($tl_data['total_feedback']!=0||$tl_data['tntfr_hr_acpt']!=0){
										$accept_per = number_format(($tl_data['tntfr_hr_acpt']/$tl_data['total_feedback'])*100,2);
										}else{
											$accept_per = 0;
										}
										$post_24_acpt = $tl_data['accept_count'] - $tl_data['tntfr_hr_acpt'];
										if($tl_data['total_feedback']!=0||$post_24_acpt!=0){
										$post_24_accept_per = number_format(($post_24_acpt/$tl_data['total_feedback'])*100,2);
										}else{
											$post_24_accept_per = 0;
										}
										if($tl_data['total_feedback']!=0||$tl_data['accept_count']!=0){
										$overall_accept_per = number_format(($tl_data['accept_count']/$tl_data['total_feedback'])*100,2);
										}else{
											$overall_accept_per = 0;
										}
										if($tl_data['total_feedback']!=0||$tl_data['not_accepted_count']!=0){
										$not_accept_per = number_format(($tl_data['not_accepted_count']/$tl_data['total_feedback'])*100,2);
										}else{
											$not_accept_per = 0;
										}
										if($tl_data['total_feedback']!=0||$tl_data['rebuttal_count']!=0){
										$rebuttal_per = number_format(($tl_data['rebuttal_count']/$tl_data['total_feedback'])*100,2);
										}else{
											$rebuttal_per = 0;
										}

										array_push($tl_wise_graph_xAxis,$tl_data['tl_name']);
	                                 	array_push($tl_wise_graph_feedback_raised,$tl_data['total_feedback']);
	                                 	array_push($tl_wise_graph_feedback_accepted_less24hrs,$tl_data['tntfr_hr_acpt']);
	                                 	array_push($tl_wise_graph_feedback_accepted_post24hrs,$post_24_acpt);
	                                 	array_push($tl_wise_graph_feedback_not_accepted,$tl_data['not_accepted_count']);
	                                 	array_push($tl_wise_graph_feedback_rebuttal,$tl_data['rebuttal_count']);
								?>
									<tr>
										<td class="text-center"><?php echo $cn++; ?></td>
										<td class="text-center"><b><?php echo $tl_data['tl_name'] ?><b></td>
										<td class="text-center"><b><?php echo $tl_data['total_feedback'] ?></b></td>
										<td class="text-center"><?php echo $tl_data['tntfr_hr_acpt'] ?></td>
										<td class="text-center"><?php echo $accept_per.'%' ?></td>
										<td class="text-center"><?php echo $post_24_acpt ?></td>
										<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
										<!--<td class="text-center"><?php //echo $tl_data['accept_count'] ?></td>
										<td class="text-center"><?php //echo $overall_accept_per.'%' ?></td>-->
										<td class="text-center"><?php echo $tl_data['not_accepted_count'] ?></td>
										<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
										<td class="text-center"><?php echo $tl_data['rebuttal_count'] ?></td>
										<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="widget">	
			<div class="widget-body clearfix">
				<!-- <div class="row">
				    <div class="col-md-4">
					  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> QA Wise Acceptance Analytics</h4>
					</div>
				</div>
				<hr> -->
				<div class="row">
					<div class="col-md-12"><div id="qa-wise-chart"></div></div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table style="margin-top: 10px;white-space: nowrap !important;" id="default-datatable-details" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									<th>#</th>
									<th>QA Name</th>
									<th>Department</th>
									<th>Feedback Raised</th>
									<th>Feedback Accepted within 24 hour hrs</th>
									<th>Feedback Accepted within 24 hour hrs %</th>
									<th>Feedback Accepted Post 24 hrs</th>
									<th>Feedback Accepted Post 24 hrs %</th>
									<!--<th>Feedback Accepted</th>
									<th>Overall Acceptance %</th>-->
									<th>Feedback Not Accepted</th>
									<th>Feedback Not Accepted %</th>
									<th>Rebuttal Raised</th>
									<th>Rebuttal Raised %</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$cn = 1;
									/*For graph*/
		                            $qa_wise_graph_xAxis = array();
		                            $qa_wise_graph_feedback_raised = array();
		                            $qa_wise_graph_feedback_accepted_less24hrs = array();
		                            $qa_wise_graph_feedback_accepted_post24hrs = array();
		                            $qa_wise_graph_feedback_not_accepted = array();
		                            $qa_wise_graph_feedback_rebuttal = array();

									foreach($qawise_data as $qa_data){
										if($qa_data['total_feedback']!=0||$qa_data['tntfr_hr_acpt']!=0){
										$accept_per = number_format(($qa_data['tntfr_hr_acpt']/$qa_data['total_feedback'])*100,2);
										}else{
											$accept_per = 0;
										}
										$post_24_acpt = $qa_data['accept_count'] - $qa_data['tntfr_hr_acpt'];
										if($qa_data['total_feedback']!=0||$post_24_acpt!=0){
										$post_24_accept_per = number_format(($post_24_acpt/$qa_data['total_feedback'])*100,2);
										}else{
											$post_24_accept_per = 0;
										}
										if($qa_data['total_feedback']!=0||$qa_data['accept_count']!=0){
										$overall_accept_per = number_format(($qa_data['accept_count']/$qa_data['total_feedback'])*100,2);
										}else{
											$overall_accept_per = 0;
										}
										if($qa_data['total_feedback']!=0||$qa_data['not_accepted_count']!=0){
										$not_accept_per = number_format(($qa_data['not_accepted_count']/$qa_data['total_feedback'])*100,2);
										}else{
											$not_accept_per = 0;
										}
										if($qa_data['total_feedback']!=0||$qa_data['rebuttal_count']!=0){
										$rebuttal_per = number_format(($qa_data['rebuttal_count']/$qa_data['total_feedback'])*100,2);
										}else{
											$rebuttal_per = 0;
										}

										array_push($qa_wise_graph_xAxis,$qa_data['qa_name']);
	                                 	array_push($qa_wise_graph_feedback_raised,$qa_data['total_feedback']);
	                                 	array_push($qa_wise_graph_feedback_accepted_less24hrs,$qa_data['tntfr_hr_acpt']);
	                                 	array_push($qa_wise_graph_feedback_accepted_post24hrs,$post_24_acpt);
	                                 	array_push($qa_wise_graph_feedback_not_accepted,$qa_data['not_accepted_count']);
	                                 	array_push($qa_wise_graph_feedback_rebuttal,$qa_data['rebuttal_count']);
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
										<!--<td class="text-center"><?php echo $qa_data['accept_count'] ?></td>
										<td class="text-center"><?php echo $overall_accept_per.'%' ?></td>-->
										<td class="text-center"><?php echo $qa_data['not_accepted_count'] ?></td>
										<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
										<td class="text-center"><?php echo $qa_data['rebuttal_count'] ?></td>
										<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="widget">	
			<div class="widget-body clearfix">
				<!-- <div class="row">
				    <div class="col-md-4">
					  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Agent Wise Acceptance Analytics</h4>
					</div>
				</div>
				<hr> -->
				<div class="row">
					<div class="col-md-12"><div id="agent-wise-chart"></div></div>
				</div>
				<div class="row">	
					<div class="col-md-12">
						<div class="tbl-container">
							<div class="table-responsive new-table tbl-fixed">
								<table style="margin-top: 10px;white-space: nowrap !important;" class="table-striped  table-condensed" cellspacing="0" width="100%">
									<thead>
										<tr class='bg-info'>
										<th>#</th>
										<th>Agent Name</th>
										<th>Feedback Raised</th>
										<th>Feedback Accepted within 24 hour hrs</th>
										<th>Feedback Accepted within 24 hour hrs %</th>
										<th>Feedback Accepted Post 24 hrs</th>
										<th>Feedback Accepted Post 24 hrs %</th>
										<!--<th>Feedback Accepted</th>
										<th>Overall Acceptance %</th>-->
										<th>Feedback Not Accepted</th>
										<th>Feedback Not Accepted %</th>
										<th>Rebuttal Raised</th>
										<th>Rebuttal Raised %</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										$cn = 1;
										/*For graph*/
			                            $agent_wise_graph_series_data = array();
			                            $agent_wise_graph_drilldown_series_data = array();

										foreach($agentwise_data as $agent_data){
											if($agent_data['total_feedback']!=0||$agent_data['tntfr_hr_acpt']!=0){
											$accept_per = number_format(($agent_data['tntfr_hr_acpt']/$agent_data['total_feedback'])*100,2);
											}else{
												$accept_per = 0;
											}
											$post_24_acpt = $agent_data['accept_count'] - $agent_data['tntfr_hr_acpt'];
											if($post_24_acpt!=0||$agent_data['total_feedback']!=0){
											$post_24_accept_per = number_format(($post_24_acpt/$agent_data['total_feedback'])*100,2);
											}else{
												$post_24_accept_per = 0;
											}
											if($agent_data['accept_count']!=0||$agent_data['total_feedback']!=0){
											$overall_accept_per = number_format(($agent_data['accept_count']/$agent_data['total_feedback'])*100,2);
											}else{
												$overall_accept_per = 0;
											}
											if($agent_data['not_accepted_count']!=0||$agent_data['total_feedback']!=0){
											$not_accept_per = number_format(($agent_data['not_accepted_count']/$agent_data['total_feedback'])*100,2);
											}else{
												$not_accept_per = 0;
											}
											if($agent_data['rebuttal_count']!=0||$agent_data['total_feedback']!=0){
											$rebuttal_per = number_format(($agent_data['rebuttal_count']/$agent_data['total_feedback'])*100,2);
											}else{
												$rebuttal_per = 0;
											}

											array_push($agent_wise_graph_series_data,array("name"=> $agent_data['agent_name'],"y"=>$agent_data['total_feedback'],"drilldown"=> $agent_data['agent_name']));

		                                 	array_push($agent_wise_graph_drilldown_series_data,array("name"=>$agent_data['agent_name'],"id"=>$agent_data['agent_name'],"data"=>array(
		                                 		array("Feedback Accepted within 24 hour hrs",$agent_data['tntfr_hr_acpt']),
		                                 		array("Feedback Accepted Post 24 hrs",$post_24_acpt),
		                                 		array("Feedback Not Accepted",$agent_data['not_accepted_count']),
		                                 		array("Rebuttal Raised",$agent_data['rebuttal_count'])
		                                 	)));
									?>
										<tr>
											<td class="text-center">
												<i style="cursor: pointer;" class="fa fa-eye audit-deatils" agent-id="<?php echo $agent_data['agent_id']?>" aria-hidden="true" data-toggle="modal" data-target="#auditDetailsModal"></i>
											</td>
											<td class="text-center"><b><?php echo ucwords(strtolower($agent_data['agent_name'])) ?><b></td>
											<td class="text-center"><b><?php echo $agent_data['total_feedback'] ?></b></td>
											<td class="text-center"><?php echo $agent_data['tntfr_hr_acpt'] ?></td>
											<td class="text-center"><?php echo $accept_per.'%' ?></td>
											<td class="text-center"><?php echo $post_24_acpt ?></td>
											<td class="text-center"><?php echo $post_24_accept_per.'%' ?></td>
											<!--<td class="text-center"><?php //echo $agent_data['accept_count'] ?></td>
											<td class="text-center"><?php //echo $overall_accept_per.'%' ?></td>-->
											<td class="text-center"><?php echo $agent_data['not_accepted_count'] ?></td>
											<td class="text-center"><?php echo $not_accept_per.'%' ?></td>
											<td class="text-center"><?php echo $agent_data['rebuttal_count'] ?></td>
											<td class="text-center"><?php echo $rebuttal_per.'%' ?></td>
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
	</section>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="auditDetailsModal" tabindex="-1" role="dialog" aria-labelledby="auditDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="auditDetailsModalLabel">Audit Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="widget-body table-responsive" style="height: 365px;overflow-y: auto;">
		    <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0" style="white-space: nowrap;">
		        <thead>
		            <tr class="bg-info">
		                <th class="text-center">SL. No.</th>
		                <th class="text-center">Auditor Name</th>
		                <th class="text-center">Audit Date</th>
		                <th class="text-center">Ticket Id.</th>
		                <th class="text-center">Process</th>
		                <th class="text-center">LOB</th>
		                <th class="text-center">L1 Supervisor</th>
		                <th class="text-center">Call Date Time</th>
		                <th class="text-center">Audit Type</th>
		                <th class="text-center">Total Score</th>
		                <!-- <th class="text-center">Call Duration</th> -->
		                <th class="text-center">Agent Review Date</th>
		                <th class="text-center">Mgnt Reviewed By</th>
		                <th class="text-center">Mgnt Review Date</th>
		            </tr>
		        </thead>
		        <tbody style="text-align: center;" id="audited-list">
		            
		        </tbody>
		    </table>
		</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>