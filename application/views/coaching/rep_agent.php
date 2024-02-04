<style>
	td{
		font-size:12px;
	}
	
	#default-datatable th{
		font-size:12px;
	}
	#default-datatable th{
		font-size:12px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
	}
	.lbl_chk_all{
		padding:0px 5px;
		background-color:#ddd;
	}
	
	.lbl_chk{
		padding:0px 5px;
	}
	
	.updateRows{
		background-color:#ADEBAD;
	}
	
</style>

	<div class="wrap">
	
	<section class="app-content">
	
	<div class="row">
		<div class="col-md-12">
		<div class="widget">

		<header class="widget-header">
			<h4 class="widget-title">Coaching Report Agents Wise</h4>
		</header>
		
		<hr class="widget-separator"/>
		<div class="widget-body clearfix">
		
		<?php echo form_open('',array('method' => 'get')) ?>
		
		<div class="row">

			<div class="col-md-2">
				<div class="form-group">
				<label for="start_date">Start Date</label>
				<input type="text" class="form-control" id="start_date" value='<?php echo $start_date; ?>' name="start_date" >
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
				<label for="end_date">End Date</label>
				<input type="text" class="form-control" id="end_date" value='<?php echo $end_date; ?>' name="end_date" >
				</div>
			</div>
			
			<div class="col-md-3" id="agent_div">
				<div class="form-group">
				<label for="filter_key">Enter Agent Fusion-ID</label>
					<input type='text' id='fagent_id' name='fagent_id'  value='<?php echo $fagent_id;?>' class="form-control" placeholder="Agent Fusion-ID" />
				</div> 
			</div>

		</div>
		
		<div class="row">
	
		<div class="col-md-2">
			<div class="form-group">
				<label for="client_id">Client</label>
				<select class="form-control" name="client_id" id="fclient_id" >
					<option value='ALL'>ALL</option>
					<?php foreach($client_list as $client): ?>
						<?php
						$sCss="";
						if($client->id==$cValue) $sCss="selected";
						?>
						<option value="<?php echo $client->id; ?>" <?php echo $sCss;?>><?php echo $client->shname; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
		<!-- .form-group -->
		</div>
		
	<?php
	if($cValue==1){
		$sHid="";
		$oHid='style="display:none;"';
	}else{
		$oHid="";
		$sHid='style="display:none;"';
	}
	?>
	
		<div class="col-md-2">
			<div class="form-group" id="fsite_div" <?php echo $sHid;?> >
				<label for="site_id">Site</label>
				<select class="form-control" name="site_id" id="fsite_id" >
					<option value='ALL'>ALL</option>
					<?php foreach($site_list as $site): ?>
						<?php
						$sCss="";
						if($site->id==$sValue) $sCss="selected";
						?>
						<option value="<?php echo $site->id; ?>" <?php echo $sCss;?>><?php echo $site->name; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
				
			<div class="form-group" id="foffice_div" <?php echo $oHid;?>>
				<label for="office_id">Location</label>
				<select class="form-control" name="office_id" id="foffice_id" >
					<option value='ALL'>ALL</option>
					<?php foreach($location_list as $loc): ?>
						<?php
						$sCss="";
						if($loc['abbr']==$oValue) $sCss="selected";
						?>
					<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
			
		<!-- .form-group -->
		</div>
		
		<div class="col-md-2">
			<div class="form-group">
			<label for="process_id">Process</label>
			<select class="form-control" name="process_id" id="fprocess_id" >
				<option value='ALL'>ALL</option>
				<?php foreach($process_list as $process): ?>
					<?php
						$sCss="";
						if($process->id==$pValue) $sCss="selected";
					?>
					<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
					
				<?php endforeach; ?>
														
			</select>
			</div>
		<!-- .form-group -->
		</div>
		
		
		<div class="col-md-2" id="" >
			<div class="form-group">
				<label for="role">Agent of (TL/Trainer)</label>
				<select class="form-control" name="assigned_to" id="assigned_to">
					<option value='ALL'>ALL</option>
					<?php foreach($tl_list as $tl): 
						$sCss="";
						if($tl->id==$aValue) $sCss="selected";
						
					?>
					<option value="<?php echo $tl->id ?>" <?php echo $sCss;?> ><?php echo $tl->tl_name ?></option>
					<?php endforeach; ?>
															
				</select>
			</div>
		<!-- .form-group -->
		</div>
		
			<div class="col-md-2">
			<div class="form-group">
			<br>
			<input type="submit" class="btn btn-primary btn-md" style='margin-top:4px;' id='showReports' name='showReports' value="Show">
			</div>
		</div>
		
		
		</div><!-- .row -->
		</form>
		
		</div>
		</div>
		</div>
	</div><!-- .row -->
			
	
		
	<div class="row">
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<div class="row" style="padding-top:10px;">
					
					<header class="widget-header">
						<h4 class="widget-title"> Agent Wisw Coaching Report </h4>
					</header><!-- .widget-header -->
					
					<?php if($download_link!=""){ ?>
						<div style='float:right; margin-top:-35px; margin-right:10px;' class="col-md-4">
						
							<div class="form-group" style='float:right;'>
							<a href='<?php echo $download_link.'?'.$dn_param; ?>' <span style="padding:12px;" class="label label-danger">Export As Excel</span> </a>		
							</div>
							
						</div>
						
					<?php } ?>
					
					<hr class="widget-separator">
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										
										<th>SL</th>
										<th>Agent</th>
										<th>Fusion ID</th>
										<th>TL/Trainer</th>
										<th>Client</th>
										<th>Site</th>
										<th>Process</th>
										<th>Coach Name</th>	
										<th>Coaching Date</th>		
										<th>Time Spent</th>
										<th>Review Type</th>
										<th>Best Part</th>
										<th>Focus Area</th>
										<th>Next Coaching Date</th>
										<th>Next Coaching POA</th>
										<th>Comments</th>
										
									</tr>
								</thead>
								
								<tfoot>
									<tr>
										
										<th>SL</th>
										<th>Agent</th>
										<th>Fusion ID</th>
										<th>TL/Trainer</th>
										<th>Client</th>
										<th>Site</th>
										<th>Process</th>
										<th>Coach Name</th>	
										<th>Coaching Date</th>		
										<th>Time Spent</th>
										<th>Review Type</th>
										<th>Best Part</th>
										<th>Focus Area</th>
										<th>Next Coaching Date</th>
										<th>Next Coaching POA</th>
										<th>Comments</th>
									</tr>
								</tfoot>
	
								<tbody>
								
								<?php 
								
									$cnt=1;
									$pagent_id="";
									
									foreach($user_list as $user): 
									
									$coach_id=$user['coach_id'];
									$coach_name=$user['coach_name'];
									$coaching_date=$user['coaching_date'];
									$agent_id=$user['agent_id'];
									$agent_fusion_id=$user['fusion_id'];
									
									if($pagent_id!=$agent_id){
										
										if($pagent_id!="") echo "<tr class=''><td colspan='14' class='bg-sep'></td></tr>";
										$pagent_id=$agent_id;
										$cnt=1;
									}
									
								?>
									<tr>
										
										<td><?php echo $cnt++; ?></td>
										
										
										<td><?php echo $user['fname'] . " ". $user['lname']; ?></td>
										<td><?php echo $user['fusion_id']; ?></td>
										<td><?php echo $user['asign_tl']; ?></td>
										<td><?php echo $user['client_name']; ?></td>
										<td><?php echo $user['site_name']; ?></td>
										<td><?php echo $user['process_name']; ?></td>
										<td><?php echo $coach_name; ?></td>
										<td><?php echo $coaching_date; ?></td>
										<td><?php echo $user['time_spent']; ?></td>
										<td><?php echo $user['review_type']; ?></td>
										<td><?php echo $user['best_part']; ?></td>
										<td><?php echo $user['focus_area']; ?></td>
										<td><?php echo $user['next_coaching_date']; ?></td>
										<td><?php echo $user['next_coaching_poa']; ?></td>
										<td><?php echo $user['comment']; ?></td>
																				
									</tr>
									
								<?php endforeach; ?>
										
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
			
			</div> <!-- .row -->
			
			<!-- END DataTable -->	
			
			</div>
		</div>
			
	</div><!-- .row -->
				
		
</section> <!-- #dash-content -->	
	
</div><!-- .wrap -->