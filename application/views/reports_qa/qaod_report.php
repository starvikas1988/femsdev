<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom-femsdev.css"/>

<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">QA Office Depot Report</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">					
						<form id="form_new_user" method="GET" action="<?php echo base_url('reports_qa/qaod_report'); ?>">	
						  
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Search Date From - Audit Date (mm/dd/yyyy)</label>
									<input type="text" id="from_date" name="date_from" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control" autocomplete="off">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Search Date To - Audit Date (mm/dd/yyyy)</label>
									<input type="text" id="to_date" name="date_to" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control" autocomplete="off">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Audit Type</label>
									<select class="form-control" name="audit_type">
										<option value="">ALL</option>
										<option <?php echo $audit_type=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
										<option <?php echo $audit_type=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
										<option <?php echo $audit_type=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
										<option <?php echo $audit_type=='Pre-Certification Mock Call'?"selected":""; ?> value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
										<option <?php echo $audit_type=='Certification Audit'?"selected":""; ?> value="Certification Audit">Certification Audit</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<option value='All'>ALL</option>
										<?php foreach($location_list as $loc): 
											$sCss="";
											if($loc['abbr']==$office_id) $sCss="selected";
											?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Agent</label>
									<select class="form-control" id="agent_id" name="agent_id">
										<option value="">Select</option>
										<?php foreach($get_agent_id_list as $agent){ 
											$sCss='';
											if($agent->id==$agent_id) $sCss='Selected';
										?>
											<option value="<?php echo $agent->id ?>" <?php echo $sCss; ?>><?php echo $agent->name ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Select Campaign</label>
									<select class="form-control" name="process" required>
										<option value="">Select</option>
										<option <?php echo $lob == "od_chat"?"selected":"";?> value="od_chat">Old Chat</option>
										<option <?php echo $lob == "od_voice"?"selected":"";?> value="od_voice">Voice</option>
										<option <?php echo $lob == "od_ecommerce"?"selected":"";?> value="od_ecommerce">Ecommerce</option>
										<option <?php echo $lob == "chat"?"selected":"";?> value="chat">Chat</option>
										<option <?php echo $lob == "od_nps"?"selected":"";?> value="od_nps">NPS ACPT</option>
										<option <?php echo $lob == "od_nps_coaching"?"selected":"";?> value="od_nps_coaching">NPS Coaching</option>
										
									</select>
								</div>
							</div>
							<div class="col-md-2" style='margin-top:2px;'>
								<div class="form-group">
									
									<button class="btn btn-primary waves-effect blue-btn" a href="<?php echo base_url()?>reports_qa/qaod_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
							<?php if($download_link!=""){ ?>
								<div style='float:right; margin-top:25px;' class="col-md-2">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>	
									</div>
								</div>
							<?php } ?>
						</div>
					</form>
					</div>
						</div>
				</div>
			</div>
	
			<!-- <?php //if($lob=='od_voice' || $lob=='od_ecommerce' || $lob=='chat' || $lob=='od_nps'){ ?> -->
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
						
					<div class="widget-body table-parent">
						
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>TL Name</th>
										<?php if(($lob=='old_chat') || ($lob=='od_voice') || ($lob=='od_ecommerce') || ($lob=='chat')){ ?><th>Customer ID</th><?php }?>
										<th>Audit Type</th>
										<?php if(($lob=='old_chat') || ($lob=='od_voice') || ($lob=='od_ecommerce') || ($lob=='chat')){ ?><th>Total Score</th><?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									// echo"<pre>";
									// print_r($qa_od_list);
									// echo"</pre>";
									foreach($qa_od_list as $row){ ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<?php if(($lob=='old_chat') || ($lob=='od_voice') || ($lob=='od_ecommerce') || ($lob=='chat')){ ?>
											<td><?php echo $row['customer_id']; ?></td>
										<?php } ?>
										<td><?php echo $row['audit_type']; ?></td>
										<?php if(($lob=='old_chat') || ($lob=='od_voice') || ($lob=='od_ecommerce') || ($lob=='chat')){ ?>
											<td><?php echo $row['overall_score']; ?></td>
										<?php } ?>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<?php //}  ?>
	</section>
</div>	