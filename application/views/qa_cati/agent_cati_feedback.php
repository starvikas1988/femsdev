
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Search Your Feedback</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_'.$page.'/process/agent'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control" autocomplete="off">
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control" autocomplete="off">
									</div> 
								</div>

								<div class="col-md-3"> 
									<div class="form-group">
										<label>Select Campaign</label>
										<select class="form-control" id="campaign" name="campaign" required>
											<option value="">--Select--</option>
											<option <?php echo $campaign=='cati'?"selected":""; ?> value="cati">Cati</option>
											<option <?php echo $campaign=='cati_sopriam_APV'?"selected":""; ?> value="cati_sopriam_APV">Sopriam APV</option>
											<option <?php echo $campaign=='cati_sopriam_VN'?"selected":""; ?> value="cati_sopriam_VN">Sopriam VN</option>
											<option <?php echo $campaign=='cati_toyota_sondage_sav'?"selected":""; ?> value="cati_toyota_sondage_sav">Toyota Sondage Sav</option>
											<option <?php echo $campaign=='cati_toyota_sondage_sale'?"selected":""; ?> value="cati_toyota_sondage_sale">Toyota sondage sale</option>
											<option <?php echo $campaign=='cati_toyota_sondage_VO'?"selected":""; ?> value="cati_toyota_sondage_VO">Toyota sondage VO</option>
											<option <?php echo $campaign=='cati_IPSOS'?"selected":""; ?> value="cati_IPSOS">IPSOS</option>
											<option <?php echo $campaign=='cati_Toyota_RC'?"selected":""; ?> value="cati_Toyota_RC">Toyota RC</option>
										</select>
									</div> 
								</div>
								
								<div class="col-md-1" style="margin-top:20px">
								    <button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_<?php echo $page; ?>/agent_<?php echo $page; ?>_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
	
		<?php 
		$processnmCnt=count($processName);
		foreach ($processName as $key => $value) { 
			$total_feedback="tot_feedback_".$value;
			$yet_rvw="yet_rvw_".$value;
			?>
		<div class="row">
			<div class="col-12">
				<div class="widget">
				
				
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<div class="col-md-6">
									<h4 class="widget-title"></h4>
								</div>
								<div class="col-md-6" style="float:right">
									<span style="font-weight:bold; color:red">Total Feedback <?php echo ucwords($campaign) ?></span> <span class="badge" style="font-size:12px"><?php echo ($$total_feedback)?$$total_feedback:"0"; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?php echo ($$yet_rvw)?$$yet_rvw:"0"; ?></span>
								</div>
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
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Total Score</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									if($processnmCnt<=1){
										$loop=$page."_agent_list";
									}else{
										$loop=$page."_".$value."_agent_list";

									} 
									if(!empty($$loop)){
										foreach($$loop as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $adid=$row['id']; ?>
											<!-- <?php  
											//if($campaign == 'cati_Toyota_RC'){
												?>
												<a class="btn btn-success agentFeedback" href="<?php //echo base_url(); ?>qa_<?php //echo $page; ?>/process/agnt_feedback/<?php //echo $adid ?>/<?=$campaign?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View/Review</a>
												<?php

											//}else{
												?>
												<a class="btn btn-success agentFeedback" href="<?php //echo base_url(); ?>qa_<?php //echo $page; ?>/process/agnt_feedback/<?php //echo $adid ?>/<?=$campaign?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View/Review</a>
												<?php
											//}
											?> -->

											<a class="btn btn-success agentFeedback" href="<?php echo base_url(); ?>qa_<?php echo $page; ?>/process/agnt_feedback/<?php echo $adid ?>/<?=$campaign?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View/Review</a>
												
										</td>
									</tr>
									<?php endforeach; } ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Total Score</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
						
					</div>
					
					
				
				</div>
			</div>
		</div>
	<?php } ?>

	</section>
</div>