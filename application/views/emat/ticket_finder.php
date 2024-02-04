<style>
	.filter-widget .form-control {
		width:100%;
		height:auto;
		padding:10px;
		height:40px;
		transition:all 0.5s ease-in-out 0s;
	}
	.filter-widget .form-control:hover {
		border:1px solid #188ae2;
	}
	.filter-widget .form-control:focus {
		border:1px solid #188ae2;
		outline:none;
		box-shadow:none;
	}
	.submit-btn {
		width:200px;
		padding:10px;
		background:#10c469;
		color:#fff;
		font-size:13px;
		letter-spacing:0.5px;
		transition:all 0.5s ease-in-out 0s;
		border:none;
		border-radius:5px;
	}
	.submit-btn:hover {
		background:#0b8145;
	}
	.submit-btn:focus {
		background:#0b8145;
		outline:none;
		box-shadow:none;
	}
	.common-top {
		width:100%;
		margin:15px 0 0 0;
	}
	.table-widget th {
		background:#188ae2;
		color:#fff;
		text-align:left;
	}
	.table-widget td {		
		text-align:left;		
	}
	.view-right {
		width:100%;
		text-align:right;
	}
	.view-btn {
		width: auto;
		padding:5px 10px;
		background: #10c469;
		color: #fff!important;
		font-size: 12px;
		letter-spacing: 0.5px;
		transition: all 0.5s ease-in-out 0s;
		border: none;
		border-radius: 5px;
		display:inline-block;		
	}
	.view-btn:hover {
		background:#0b914d;
	}
	.view-btn:focus {
		background: #0b8145;
		outline: none;
		box-shadow: none;
	}
	.marginT{
		margin-top: 20px;
	}
</style>
<div class="wrap">
	<div class="widget">
		<div class="widget-header">
			<h4 class="widget-title">
				Search 
			</h4>
					
		</div>
		<hr class="widget-separator">
		<div class="widget-body">
		<form name="frm" id="frm" method="POST" action="<?php echo base_url();?>/emat/ticket_finder"> 
			<div class="filter-widget">
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<label>Search Reference No/Ticket ID</label>
							<input type="text" class="form-control" placeholder="Ticket ID" id="references_no" name="references_no" value="<?php echo $references_no;?>">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>Search Email From</label>
							<input type="text" class="form-control" placeholder="Search Email From" id="email_from" name="email_from" value="<?php echo $email_form;?>">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>Search Subject</label>
							<input type="text" class="form-control" placeholder="Search Subject" id="search_subject" name="search_subject" value="<?php echo $search_keyword;?>">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>Search From Date</label>
							<input type="text" class="form-control oldDatePick" placeholder="Search From Date" id="search_from_date" name="search_from_date" value="<?php  echo !empty($search_start) ? date('m/d/Y', strtotime($search_start)) : date('m/d/Y', CurrMySqlDate()); ?>" >
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>Search To Date</label>
							<input type="text" class="form-control oldDatePick" placeholder="Search To Date" id="search_to_date" name="search_to_date" value="<?php  echo !empty($search_end) ? date('m/d/Y', strtotime($search_end)) : date('m/d/Y', CurrMySqlDate()); ?>">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>Assigned by</label>
							<select class="form-control" placeholder="Assigned by" id="assigned_by" name="assigned_by">
								<option value=""> -- select--</option>	
								<?php foreach($agentList as $key=>$rws){ 
									if(e_tl_access($rws['fusion_id'])){
								?>
									<option value="<?php echo $rws['id'];?>" <?php echo($rws['id']==$assigned_to)?'selected="selected"':'';?>><?php echo $rws['fname'].' '.$rws['lname'] ;?></option>
								<?php }} ?>
							</select>	
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>Assigned To</label>
							<select class="form-control" placeholder="Assigned To" id="assigned_to" name="assigned_to">
							<option value=""> -- select--</option>	
							<?php foreach($agentList as $key=>$rws){ 
								if(e_agent_access($rws['fusion_id'])){
							?>
								<option value="<?php echo $rws['id'];?>" <?php echo($rws['id']==$assigned_to)?'selected="selected"':'';?>><?php echo $rws['fname'].' '.$rws['lname'] ;?></option>
							<?php }} ?>	
							</select>
						</div>
					</div>
					<!--<div class="col-sm-3">
						<div class="form-group">
							<label>Worked by</label>
							<input type="text" class="form-control" placeholder="Worked by" id="worked_by" name="worked_by">
						</div>
					</div>-->
					<div class="col-sm-3">
						<div class="form-group">
							<label>Mailbox/All Mailbox</label>
							<select name="mailbox" id="mailbox" class="form-control" placeholder="Mailbox/All Mailbox" onchange="setcategory();">
							     <option value="">All</option>
								<?php foreach($email_list as $key=>$rows){ ?>
									<option value="<?php echo $rows['email_id'];?>" <?php echo($rows['email_id']==$email_id)?'selected="selected"':'';?>><?php echo $rows['email_name'];?></option>
								<?php } ?>	
							</select>	
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>Mailbox Category</label>
							<select name="categorys" id="categorys" class="form-control" placeholder="Mailbox Category">
								<option value=""> -- Select -- </option>
								<?php foreach($category_list as $key=>$rws){ ?>	
									<option value="<?php echo $rws['category_code'];?>" <?php echo($rws['category_code']==$categorys)?'selected="selected"':'';?>><?php echo $rws['category_name'];?></option>
								<?php } ?>	
							</select>	
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>Handled By</label>
							<select class="form-control" placeholder="Handled By" id="handled_by" name="handled_by">
							<option value=""> -- select--</option>	
							<?php foreach($agentList as $key=>$rws){ 
								if(e_agent_access($rws['fusion_id'])){
							?>
								<option value="<?php echo $rws['id'];?>" <?php echo($rws['id']==$handled_by)?'selected="selected"':'';?>><?php echo $rws['fname'].' '.$rws['lname'] ;?></option>
							<?php }} ?>	
							</select>
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group marginT">
							<button type="submit" class="submit-btn ">
								<i class="fa fa-search" aria-hidden="true"></i>
								Search
							</button>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group marginT">
							<button type="button" class="submit-btn " name="Download" onclick="download_list();">
								<i class="fa fa-download" aria-hidden="true"></i>
								Download
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>	
		</div>
	</div>
	<div class="common-top">		
		<div class="widget">			
			<div class="widget-body">				
				<div class="table-widget">
					<table class="table table-responsive table-striped">
						<thead>
							<tr>
								<th>Ticket ID</th>
								<?php if(!empty($email_id) && e_show_arrival($email_id)){ ?>
									<th>Arrival Dt</th>	
								<?php } ?>
								<th>Mailbox Name</th>	
								<th>Category</th>
								<th>AHT</th>
								<th>Aging</th>
								<th>Assigned</th>
								<th>Handled By</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							foreach($messageList as $token){ 
								
								$agingTime = e_display_aging_time(e_aging_ticket($token['date_added']));
								if(e_aging_ticket($token['date_added'])>'86400'){
									$agingTime = $token['date_added'];
								}
								if($token['is_open'] == 0){ 
									$agingTime = e_display_aging_time(e_aging_ticket_closure($token['date_added'], 12, $token['closed_date'])); 
									
									if(e_aging_ticket_closure($token['date_added'], 12, $token['closed_date'])>'86400'){
										$agingTime = $token['date_added'];
									}
								}
								$ticketCategory = $token['ticket_category'];
								$slaTime = $ticketCategoryIndexed[$ticketCategory]['category_sla'];
								$ticketCategoryName = $ticketCategoryIndexed[$ticketCategory]['category_name'];
								$ticket_no=$token['ticket_no'];
								$status=($token['closed_date']=='')?'Open':'Close';
								//echo $token['primary_email'];
								$email_name=get_emat_email_name($token['primary_email']);
								//echo'<pre>';print_r($email_name);die();
								$closed_by=$token['closed_by_name'];
								
							?>
							<tr>
								<td>
								<b><?php echo $token['ticket_no']; ?></b> : 
								<?php echo e_short_text($token['ticket_subject'], 30); ?>
								</td>
								<?php if(e_show_arrival($email_id)){ ?>
								<td><?php echo !empty($token['ticket_arrival_date']) ? $token['ticket_arrival_date'] : "-"; ?></td>
								<?php } ?>
								<td><?php echo $email_name; ?></td>
								<td><?php echo $ticketCategory; ?></td>
								<td><?php if(!empty($token['total_time'])){ ?><span class="green"><?php echo $token['total_time']; ?></span><?php } else { ?><b>n/a</b><?php } ?></td>
								<td><span class="green"><?php echo $agingTime; ?></span></td>
								<td>
								<?php if(!empty($ticketAssigned[$token['ticket_no']])){ ?>
									<?php echo e_short_text($ticketAssigned[$token['ticket_no']]['fullname'], 15); ?>
								<?php } else { ?>
									<span style="color: #ab0c13;">Unassigned</span>
								<?php } ?>
								</td>
								<td>
									<?php echo $closed_by;?>
								</td>
								<td>
									<?php echo $status;?>

								</td>
								<td>
									<a href="<?php echo base_url();?>emat/ticket_view/<?php echo $ticket_no;?>"  class="view-btn" target="_blank"><?php echo ($token['closed_date']=='')?'Work':'View';?></a>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function setcategory(){
		var cat = $('#mailbox').val();
		$.ajax({
			type:'GET',
			url:'<?php echo base_url();?>/emat/get_category',
			data:'email_id='+cat,
			success:function(res){
				$('#categorys').html(res);
			}
		});
		//alert(cat);
	}
	function download_list(){
		url='<?php echo base_url();?>/emat/search_list_excel'
		$('#frm').attr('action', url).submit();
	}
</script>