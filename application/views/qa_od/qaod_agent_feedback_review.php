<style>
.form-control1{
	margin-right:0px;
    box-shadow: none;
    border-color: #d2d6de;
	display: inline-block;
    width: 65px;
    height: 28px;
    padding: 4px 8px;
    font-size: 10px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
	border: 1px solid rgba(0,0,0,.15);
	border-radius: .25rem;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;	
}

</style>


<div class="wrap">
<section class="app-content">

<div class="row">
	<div class="col-12">

		<div class="widget">
		
			
		
			<div class="widget-body">
				
				<form id="form_new_user" method="GET" action="<?php echo base_url('qa_od/qaod_agent_sorting_feedback'); ?>">
					
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>From Date (mm-dd-yyyy)</label>
								<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control">
							</div>
						</div> 
						<div class="col-md-3"> 
							<div class="form-group">
								<label>To Date (mm-dd-yyyy)</label>
								<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control">
							</div> 
						</div>
						<div class="col-md-3"> 
							<div class="form-group">
								<label>Select Campaign</label>
								<select class="form-control" name="process" required>
									<!-- <option value="">Select</option> -->
									<option <?php echo $lob == "old_chat"?"selected":"";?> value="old_chat">Old Chat</option>
									<option <?php echo $lob == "chat"?"selected":"";?> value="chat">Chat</option>
									<option <?php echo $lob == "od_voice"?"selected":"";?> value="od_voice">Voice</option>
									<option <?php echo $lob == "od_ecommerce"?"selected":"";?> value="od_ecommerce">Ecommerce</option>
									<option <?php echo $lob == "od_npsACPT"?"selected":"";?> value="od_nps">NPS ACPT</option>
									<option <?php echo $lob == "od_nps_coaching"?"selected":"";?> value="od_nps_coaching">NPS Coaching</option>		
								</select>
							</div> 
						</div>
						<div class="col-md-2" style="margin-top:24px">
							<input type="submit" class="btn btn-info btn-rounded" id='btnView' name='btnView' value="View">
						</div>
					</div>
					
				</form>
			</div>
		</div>

	</div>		
</div>

<div class="row">
	<header class="widget-header">
		<div class="col-md-6">
			<h4 class="widget-title"><?php if($lob=='old_chat') echo "Old Chat"; if($lob=='chat') echo "Chat"; if($lob=='od_voice') echo "Voice"; if($lob=='od_nps') echo "nps ACPT"; if($lob=='od_ecommerce') echo "Ecommerce"; ?></h4>
		</div>
		<div class="col-md-6" style="float:right">
			<span style="font-weight:bold; color:red">Total Feedback</span> <span class="badge" style="font-size:12px"><?php echo $total_feedback; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?php echo $total_review_needed; ?></span>
		</div>
	</header>
	<hr class="widget-separator">
</div>
<?php if($lob=='od_voice' || $lob=='od_ecommerce' || $lob=='chat' || $lob=='od_nps'){ ?>
<div class="row">
	<div class="col-12">
		<div class="widget">
			<div class="widget-body">
			
				<div class="table-responsive">
					<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
						<thead>
							<tr class="bg-info">	
								<th>SL</th>
								<th>QA</th> 
								<th>Chat Date</th> 
								<th>Chat Audit Date</th> 
								<th>Agent Name</th>
								<?php if(($lob=='old_chat') || ($lob=='od_voice') || ($lob=='od_ecommerce') || ($lob=='chat')){ ?><th> Customer ID </th><?php } ?>
								<th>Session ID/ANI</th>
								<?php if(($lob=='old_chat') || ($lob=='od_voice') || ($lob=='od_ecommerce') || ($lob=='chat')){ ?><th>Score %</th>
								<th>Possible Score</th>
								<th>Overall Score</th><?php } ?>
								<th>Agent Review Status</th>
								<th>Agent Review Date</th>
								<th>Mgnt Review Date</th>
								<th>Audio</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$i=1;
								foreach($get_agent_review_list as $row): 
							?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php 
											if($row['entry_by']!=''){
												echo $row['auditor_name'];
											}else{
												echo $row['client_name'];
											}
										?></td>
								<td><?php echo $row['call_date']; ?></td>
								<td><?php echo $row['audit_date']; ?></td>
								<td><?php echo $row['fname']." ".$row['lname']; ?></td>
								<?php if(($lob=='old_chat') || ($lob=='od_voice') || ($lob=='od_ecommerce') || ($lob=='chat')){ ?>
									<td><?php echo $row['customer_id']; ?></td>
								<?php }?>
								<td><?php echo $row['session_id']; ?></td>
								<?php if(($lob=='old_chat') || ($lob=='od_voice') || ($lob=='od_ecommerce') || ($lob=='chat')){ ?>
									<td> <?php echo $row['earned_score']; ?></td>
									<td><?php echo $row['possible_score']; ?></td>
									<td><?php echo $row['overall_score']; ?></td>
								<?php } ?>
								<td><?php echo $row['agnt_fd_acpt']; ?></td>
								<td><?php echo $row['agent_rvw_date']; ?></td>
                                <td><?php echo $row['mgnt_rvw_date']; ?></td>
								<td oncontextmenu="return false;">
								<?php if($row['attach_file']!=''){ ?>
									<audio controls='' style="width:120px;"> 
									  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $row['attach_file']; ?>" type="audio/ogg">
									  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $row['attach_file']; ?>" type="audio/mpeg">
									</audio>
								<?php } ?>
								</td>
								<td>
									<?php if($lob=='old_chat'){ ?>
									<a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/qaod_agent_status_form/<?php echo $row['id']; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
									<?php } else if($lob=='od_voice'){ ?>
                                     <a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/qaod_agent_voice_rvw/<?php echo $row['id']; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
									 <?php } else if($lob=='od_ecommerce'){ ?>
                                     <a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/qaod_agent_ecommerce_rvw/<?php echo $row['id']; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
									<?php } else if($lob=='chat'){ ?>
									<a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/qaod_agent_chat_rvw/<?php echo $row['id']; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
									<!-- <?php //} ?> -->
									<?php } else if($lob=='od_nps'){?>
									<a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/qaod_agent_nps_rvw/<?php echo $row['id']; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
									<?php } ?>		
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>
<?php } else if($lob=='od_npsACPT') {  ?>

<div class="row">
	<div class="col-12">
		<div class="widget">
			<div class="widget-body">
			
				<div class="table-responsive">
					<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
						<thead>
							<tr class="bg-info">	
								<th>SL</th>
								<th>QA</th> 
								<th>Chat Date</th> 
								<th>Chat Audit Date</th> 
								<th>Agent Name</th>
								<th>Customer ID</th>
								<th>Session ID/ANI</th>
								<th>Call Pass / Fail</th>
								<th>Score %</th>
								<th>Possible Score</th>
								<th>Overall Score</th>
								<th>Agent Review Date</th>
								<th>Mgnt Review Date</th>
								<th>Audio</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$i=1;
								foreach($get_agent_review_list as $mgrl): 
							?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $mgrl->qa_name; ?></td>
								<td><?php echo $mgrl->chat_date; ?></td>
								<td><?php echo $mgrl->audit_date; ?></td>
								<td><?php echo $mgrl->agent_name; ?></td>
								<td><?php echo $mgrl->customer_id; ?></td>
								<td><?php echo $mgrl->ani; ?></td>
								<td><?php echo $mgrl->call_pass_fail; ?></td>
								<td><?php echo $mgrl->score; ?></td>
								<td><?php echo $mgrl->possible_score; ?></td>
								<td><?php echo $mgrl->overall_score; ?></td>
								<td><?php echo $mgrl->agent_review_date; ?></td>
								<td><?php echo $mgrl->mgnt_review_date; ?></td>
								<td oncontextmenu="return false;">
								<?php if($mgrl->attach_file!=''){ ?>
									<audio controls='' style="width:120px;"> 
									  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $mgrl->attach_file; ?>" type="audio/ogg">
									  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $mgrl->attach_file; ?>" type="audio/mpeg">
									</audio>
								<?php } ?>
								</td>
								<td>
									<a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/qaod_agent_status_form/<?php echo $mgrl->id; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>

<?php } else if($lob=='od_nps_coaching') {  ?>

<div class="row">
	<div class="col-12">
		<div class="widget">
			<div class="widget-body">
			
				<div class="table-responsive">
					<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
						<thead>
							<tr class="bg-info">	
								<th>SL</th>
								<th>QA</th> 
								<th>Date of Coaching</th> 
								<th>Survey Date</th> 
								<th>Agent Name</th>
								<th>Session ID</th>
								<th>NPS SCORE</th>
								<th>Agent Review Date</th>
								<th>Mgnt Review Date</th>
								<th>Audio</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$i=1;
								// echo"<pre>";
								// print_r($get_agent_review_list);
								// echo"</pre>";

								foreach($get_agent_review_list as $mgrl): 
							?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $mgrl['auditor_name']; ?></td>
								<td><?php echo $mgrl['audit_date']; ?></td>
								<td><?php echo $mgrl['call_date']; ?></td>
								<td><?php echo $mgrl['agent_name']; ?></td>
								<td><?php echo $mgrl['session_id']; ?></td>
								<td><?php echo $mgrl['nps_score']; ?></td>
								<td><?php echo $mgrl['agent_rvw_date']; ?></td>
								<td><?php echo $mgrl['mgnt_rvw_date']; ?></td>
								<td oncontextmenu="return false;">
								<?php if($mgrl['attach_file']!=''){ ?>
									<audio controls='' style="width:120px;"> 
									  <source src="<?php echo base_url(); ?>qa_files/qa_agent_coaching/<?php echo $mgrl['attach_file']; ?>" type="audio/ogg">
									  <source src="<?php echo base_url(); ?>qa_files/qa_agent_coaching/<?php echo $mgrl['attach_file']; ?>" type="audio/mpeg">
									</audio>
								<?php } ?>
								</td>
								<td>
									<a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/qaod_agent_nps_coaching_rvw/<?php echo $mgrl['id']; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
									<!-- qaod_agent_status_form -->
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>

<?php } ?>


