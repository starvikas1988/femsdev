<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">Availability Approval List</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">
					
						<div class="row">
						  <form id="form_new_user" method="GET">
							<div class="col-md-2">
								<div class="form-group">
									<label>Select Teachers</label>
									<select class="form-control" id="teacher_id" name="teacher_id" >
									<?php if(get_role() != 'teacher'){ ?>
										<option value="">
										All Teachers
										</option>
										<?php } ?>
									<?php foreach($teachersList as $k=>$tch){?>
										<option value="<?= $tch['id'];?>" <?php echo($teacher_id==$tch['id'])?"selected='selected'":"";?>>
										<?= $tch['fname'].' '.$tch['lname'];?>
										</option>
									<?php }?>	
									</select>
								</div>
							</div>						
							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									<button class="btn btn-primary waves-effect" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
							<?php 
							$econ="";
							if($_GET['teacher_id']!=""){ $econ = "&teacher_id=".$_GET['teacher_id']; }
							$download_link = base_url().'diy/generate_available_reports?date_from='.$_GET['date_from'].'&date_to='.$_GET['date_to'].$econ;
							if($download_link!=""){ ?>
								<div style='float:right; margin-top:22px;' class="col-md-1">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>	
									</div>
								</div>
							<?php } ?>
							
						  </form>
						</div>
						
						<form name="frm" id="frm" method="post" action="<?php echo base_url();?>/diy_calendar/calendar_approval_update_status_multi">
						<div class="table-responsive">
							<table class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									<?php if(get_role() != 'teacher'){ ?>
										<th><input type="checkbox" class="checkAll"> SL</th>
										<?php } else { ?>
											<th> SL</th>
										<?php } ?>
										<th>Teachers Name</th>
										<!--<th>Course</th>-->
										<th>From Date</th>
										<th>To Date</th>
										<th>Added On</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$counter=0;
									foreach($availabilityList as $row){ 
										$counter++;
										$checkup = "Pending"; $checkupClass = "danger";
										if($row['status'] == 'P'){ $checkup = "Pending"; $checkupClass = "danger"; }
										if($row['status'] == 'C'){ $checkup = "Approved"; $checkupClass = "success"; }
									?>
									<tr>
										<?php if(get_role() != 'teacher'){ ?>
										<td><input type="checkbox" class="checkboxes" name="selectsllist[]" value="<?php echo $row['batch_code'];?>" /> <?php echo $counter; ?> </td>
										<?php }else { ?>
											<td> <?php echo $counter; ?> </td>
											<?php } ?>
										<td><?php echo $row['teacher_name']; ?></td>

										<!--<td><?php echo $row['course_name']; ?></td>-->
										<td><?php echo date('d M, Y', strtotime($row['from_date'])); ?></td>
										<td><?php echo date('d M, Y', strtotime($row['to_date'])); ?></td>
										<td><?php echo date('Y-m-d h:i A', strtotime($row['created_on']));; ?></td>
										<td>
										<span class="text-<?php echo $checkupClass; ?>"><b><?php echo $checkup; ?></b></span>
										</td>
										<td>
										
										&nbsp; 
										<a class="btn btn-primary btn-xs" target="_blank" href="<?php echo base_url()?>diy_calendar/calendar_availability/<?php echo $row['teacher_id'];?>">
										<i class="fa fa-eye"></i> Calendar</a>
										&nbsp; 
										
										<?php if(get_role() != 'teacher'){ ?>
										<a class="btn btn-success btn-xs" onclick='return confirm("Are you sure you want to approve ?")' href="<?php echo base_url()?>diy_calendar/calendar_approval_availability_update_status/<?php echo $row['batch_code'];?>">
										<i class="fa fa-sign-in"></i> Approve</a>
										<?php } ?>
										
										</td>
										
									</tr>
									<?php } ?>
								</tbody>

							</table>
							
							<div style="width:100%;display:flex;justify-content:center;align-items:center;">
							<button type="submit" class="btn btn btn-success btn-xs" id="selectslbutton" style="width:50%;display:none">
							<i class="fa fa-file"></i>Approved Selected Items
							</button>
							</div>
						</div>
						</form>
						</form>
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	