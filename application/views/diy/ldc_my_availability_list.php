<style>
.form-control{
background-color: #fff !important;
}
</style>
<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">Availability List</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">
					
						<div class="row">
						  <form id="form_new_user" method="GET">
						  
							<div class="col-md-2">
								<div class="form-group">
									<label>From Date</label>
									<input type="text" id="search_from_date" name="date_from" value="<?php echo !empty($search_from) ? $search_from : ""; ?>" class="form-control" required autocomplete="off" readonly>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>To Date</label>
									<input type="text" id="search_to_date" name="date_to" value="<?php echo !empty($search_to) ? $search_to : ""; ?>" class="form-control" required autocomplete="off" readonly>
								</div>
							</div>
							<?php if(get_role() != 'teacher' && get_role() != 'Teacher'){ ?>
							<div class="col-md-2">
								<div class="form-group">
									<label>Select Teachers</label>
									<select class="form-control" id="teacher_id" name="teacher_id" >
										<option value="">
										All Teachers
										</option>
									<?php foreach($teachersList as $k=>$tch){?>
										<option value="<?=$tch['id'];?>" 
											<?php if ($teacher_id==$tch['id']) { echo "selected";} ?>>
										<?=$tch['fname'].' '.$tch['lname'];?>
										</option>
									<?php }?>	
									</select>
								</div>
							</div>
							<?php } ?>
							<div class="col-md-2" style="<?php echo $display;?>">	
								<div class="form-group">
									<label>Select Time Zone</label>

								<?php $my_gmt_timezoneval=($my_gmt_timezone=='+5:30')?'GMT+05:30':$my_gmt_timezone; 
										//echo "<br>gggg".$gmt_time_id;
								?>
								<select name="gmt_time_id" id="gmt_time_id" class="form-control" onchange="set_gmt_val();">
								<?php 
								foreach($gmtlist as $token){			
								$selection = "";
								$gmt_time_id=$gmt_time_id?$gmt_time_id:17;
								if($gmt_time_id == $token['id']){ $selection = "selected"; }
								if($token['GMT_offset'] == $my_gmt_timezoneval){$selection = "selected";}
								?>
								<option value="<?php echo $token['GMT_offset'].'#'.$token['id']; ?>" sltid="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['gmtCountryName']; ?></option>
								<?php } ?>
								</select>
							</div>
							</div>
							<div class="col-md-2">
                                <div class="form-group">
                                    <label>Select Status</label>
                                    <select class="form-control" id="status" name="status" >
                                        <option value="All" <?php echo ($status=="All")?"selected":"" ?>>All</option>
                                        <option value="1" <?php echo ($status=="1")?"selected":"" ?>>Approved</option>    
                                        <option value="0" <?php echo ($status=="")?"selected":"" ?>>Pending</option>    
                                    </select>
                                </div>
                            </div>
                            <?php $multi_approve = $status; ?>

							<?php if(get_role() != 'teacher' || get_role() != 'Teacher'){ ?>
							<!--<div class="col-md-2">
								<div class="form-group">
									<label>Select Course</label>
									<select class="form-control" id="course_id" name="course_id">
										<option value="">
										All Course
										</option>
										<?php foreach($courseList as $k=>$cl){?>
										<option value="<?= $cl['id'];?>" <?php echo($course_id==$cl['id'])?"selected='selected'":"";?>>
										 <?= $cl['name'];?>
										</option>
									<?php }?>	
									</select>
								</div>
							</div>-->
							<?php } ?> 
							
							
							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									<button class="btn btn-primary waves-effect" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
							<?php 
							$econ="";
							if($_GET['teacher_id']!=""){ $econ = "&teacher_id=".$_GET['teacher_id']; }
							if($my_gmt_timezoneval!=""){ $econ.="&timezone=".$my_gmt_timezoneval;}else{ $econ.="&timezone=+5:30";}
							if($gmt_time_id!=''){ $econ.="&timezone_id=".$gmt_time_id;}
							$download_link = base_url().'diy/generate_available_reports?date_from='.$_GET['date_from'].'&date_to='.$_GET['date_to'].$econ;
							if($download_link!="" && $status != ''){ ?>
								<div style='float:right; margin-top:22px;' class="col-md-1">
									<div class="form-group" style='float:right; margin-top: 41px; margin-bottom: 13px;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Teacher Availability</span></a>	
									</div>
								</div>
							<?php } ?>
							
						  </form>
						</div>
						
						<form name="frm" id="frm" method="post" action="<?php echo base_url();?>/diy/multi_avail_update_status_new">
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
										<!--<th>Course</th>
										   <th>Added On</th>
										-->
										<th>Date</th>
										<th>Day</th>
										<th>Slot Start Time</th>
										<th>Slot End Time</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$counter=0;
									if($status){
										$status=($status!='All')?array($status):array('0','1');
									}else{
										$status=array(0);
									}

									foreach($availabilityList as $row){ 
										$counter++;
										if(in_array($row['is_approved'],$status)){
										$checkup = "Pending"; $checkupClass = "danger";
										if($row['is_approved'] == '0'){ $checkup = "Pending"; $checkupClass = "danger"; }
										if($row['is_approved'] == '1'){ $checkup = "Approved"; $checkupClass = "success"; }
									?>
									<tr>
										<?php if(get_role() != 'teacher'){ ?>
										<td><input type="checkbox" class="checkboxes" name="selectsllist[]" value="<?php echo $row['id'];?>" /> <?php echo $counter; ?> </td>
										<?php }else { ?>
											<td> <?php echo $counter; ?> </td>
											<?php } ?>
										<td><?php echo $row['teacher_name']; ?></td>

										<!--<td><?php echo $row['course_name']; ?></td>-->
										<td><?php echo date('d M, Y', strtotime($row['found_gmt_date'])); ?></td>
										<td><?php echo date('D',strtotime($row['found_gmt_date'])); ?></td>
										<td><?php echo date(' h:i A', strtotime($row['found_gmt_start']));; ?></td>
										<td>
										<?php echo date(' h:i A', strtotime($row['found_gmt_end']));; ?></td>
										<td>	
										<span class="text-<?php echo $checkupClass; ?>"><b><?php echo $checkup; ?></b></span>
										</td>
										<td>
										
										<?php if($row['is_approved'] == '0' || get_role() == 'client'){ ?>
										<!--<a class="btn btn-primary btn-xs" target="blank" href="<?php echo base_url()?>diy/update_availability/<?php echo $row['teacher_id'];?>/<?php echo $row['batch_code'];?>">
										<i class="fa fa-edit"></i> Edit</a>-->
										<?php } ?>
										
										&nbsp; 
										<a class="btn btn-success btn-xs" target="_blank" href="<?php echo base_url()?>diy_calendar/calendar_teacher_availability/<?php echo $row['teacher_id'];?>/<?php echo date('Y-m-d',strtotime($row['found_gmt_date']));?>">
										<i class="fa fa-eye"></i> Calendar</a>
										&nbsp; 
										
										<!--<a class="btn btn-danger btn-xs" onclick='return confirm("Are you sure you want to delete ?")' target="_blank" href="<?php echo base_url()?>diy/availability_delete/<?php echo $row['teacher_id'];?>">
										<i class="fa fa-trash-o"></i> Delete</a>-->
										
										<?php if(get_role() != 'teacher' && get_role() != 'Teacher'){ 
											 if($row['is_approved'] == '0'){
										?>
										<a class="btn btn-success btn-xs" onclick='return confirm("Are you sure you want to approve ?")' href="<?php echo base_url()?>diy/availability_update_status_new/<?php echo $row['id'];?>">
										<i class="fa fa-sign-in"></i> Approve</a>
										<?php } } ?>

									<?php
										if ($row['schedule_id'] == "") {
										?>
										<a class="btn btn-danger btn-xs" onclick='return confirm("Are you sure you want to Cancel ?")' href="<?php echo base_url()?>diy/availability_update_status_delete/<?php echo $row['id'];?>">
										<i class="fa fa-sign-in"></i> Cancel</a>
									<?php 
										}
										else 
										{
											echo "<span style='#0084E7: green'>Already Scheduled</span>";
										} 

									?>


										
										
										</td>
										
									</tr>
									<?php } } ?>
								</tbody>

							</table>

								<?php  
								if ($multi_approve == "" && get_role() != "teacher" && get_role() != "Teacher") {
								?>
										<div style="width:100%;display:flex;justify-content:center;align-items:center;">
										<!-- <a class="btn btn-danger" id="selectslbutton" style="width:50%;" target="_blank" href="<?php echo base_url()?>diy/function name/<?php echo $row['teacher_id'];?>">
										<i class="fa fa-trash-o"></i> Delete Selected Items</a> -->
										<button type="submit" class="btn btn btn-success btn-xs" id="selectslbutton" style="width:50%;"><i class="fa fa-file"></i>Approved Selected Items</button>
										</div>
									<?php
										}
										else {
											if (get_role() != "teacher" && get_role() != "Teacher") {
									?>
										<div style="width:100%;display:flex;justify-content:center;align-items:center;">
										<h5 style="color: red;">
											Please set status in pending for Multiple Approve
										</h5>
										</div>

									<?php 
									}
								} 
								?>
						</div>
						</form>
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	