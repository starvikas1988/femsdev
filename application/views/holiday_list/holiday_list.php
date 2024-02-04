
				
			<?php if(isIndiaLocation(get_user_office_id())==true) { ?>
			
			
					<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
						<thead>
							<tr><th colspan=6 style="text-align:left; font-size:12px">**Employees are eligible to avail any 10 holidays (including Statutory Holiday) in the Calendar Year </br>(We are operating in 24x7 environment. So please inform in advance when planning to avail the holiday)</th></tr>
							<tr class='bg-info'>
								<th>SL No</th>
								<th>Holiday For</th>
								<th>Holiday Date</th>
								<th>Day</th>
								<th>No of Holiday</th>
								<th>Nature of Holiday</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1;
								foreach($holidaylist as $row){ 
							
								if($row['holiday_status']!='Festive'){
									$hlStatus='**';
								}else{
									$hlStatus='';
								}
							?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $row['description']." ".$hlStatus; ?></td>
								<td><?php echo $row['holiday_date']; ?></td>
								<td><?php echo $row['day_name']; ?></td>
								<td><?php echo '1'; ?></td>
								<td><?php echo $row['holiday_status']; ?></td>
							</tr>	
							<?php } ?>
						</tbody>
					</table>
				
			
			<?php }else{ ?>
			
			<div class="widget-body">
				<div class="row">
					<div class="col-md-12">
						<img src="<?php echo base_url(); ?>main_img/coming soon.jpg" class="center" style="width:70%; height:40%" />
					</div>
				</div>
			</div>
			
			<?php } ?>
				
