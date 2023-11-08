<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">AJIO</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">					
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('qa_ajio/qa_ajio_report'); ?>">	
						  <?php echo form_open('',array('method' => 'get')) ?>
						  
							<div class="col-md-4">
								<div class="form-group">
									<label>From Date (MM/DD/YYYY)<span style="font-size:24px;color:red"></span></label>
										<input type="text" id="from_date" name="date_from" onchange="date_validation(this.value,'S')" onkeydown="return false;" value="<?php $date= mysql2mmddyy($date_from); echo str_replace('-', '/', $date); ?>" class="form-control">
										<span class="start_date_error" style="color:red"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>To Date (MM/DD/YYYY)<span style="font-size:24px;color:red"></span></label>
										<input type="text" id="to_date" name="date_to" onchange="date_validation(this.value,'E')" onkeydown="return false;" value="<?php $date= mysql2mmddyy($date_to); echo str_replace('-', '/', $date); ?>" class="form-control">
									<span class="end_date_error" style="color:red"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="office_id">Select a Location<span style="font-size:24px;color:red"></span></label>
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
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Select Campaign<span style="font-size:24px;color:red">*</span></label>
									<select class="form-control" name="campaign" required>
										<option value="">--Select--</option>
										<option <?php echo $campaign=='inbound'?"selected":""; ?> value="inbound">Voice</option>
										<option <?php echo $campaign=='inb_hygiene'?"selected":""; ?> value="inb_hygiene">Voice [Hygiene]</option>
										<option <?php echo $campaign=='email'?"selected":""; ?> value="email">Email</option>
										<option <?php echo $campaign=='email_v2'?"selected":""; ?> value="email_v2">Email [Version 2]</option>
										<option <?php echo $campaign=='chat'?"selected":""; ?> value="chat">Chat</option>
										<option <?php echo $campaign=='chat_v2'?"selected":""; ?> value="chat_v2">Chat [Version 2]</option>
										<option <?php echo $campaign=='ccsr_voice'?"selected":""; ?> value="ccsr_voice">CCSR Voice</option>
										<option <?php echo $campaign=='ccsr_nonvoice'?"selected":""; ?> value="ccsr_nonvoice">CCSR [Non-Voice]</option>
										<option <?php echo $campaign=='inbound_v2'?"selected":""; ?> value="inbound_v2">VOICE [Version 2]</option>
										<option <?php echo $campaign=='social_media'?"selected":""; ?> value="social_media">Social Media</option>
										<option <?php echo $campaign=='ccsr_voice_email'?"selected":""; ?> value="ccsr_voice_email">CCSR Voice Email</option>
									</select>
								</div>
							</div>
							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									<br>
									<button class="btn btn-primary blains-effect" a href="<?php echo base_url()?>qa_ajio/qa_ajio_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
							<?php if($download_link!=""){ ?>
								<div style='float:right; margin-top:25px;' class="col-md-2">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>	
									</div>
								</div>
							<?php } ?>
							
						  </form>
						</div>
						
						<?php if($campaign!=""){ ?>
							<div class="table-responsive">
								<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
									<thead>
										<tr class='bg-info'>
											<th>SL</th>
											<th>Auditor</th>
											<th>Audit Date</th>
											<th>Agent Name</th>
											<th>L1 Supervisor</th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1;
										foreach($qa_ajio_list as $row){ ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['auditor_name']; ?></td>
											<td><?php echo $row['audit_date']; ?></td>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php echo $row['tl_name']; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						<?php } ?>
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	