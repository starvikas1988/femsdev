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
							<header class="widget-header"><h4 class="widget-title">Schedule List</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">
					
						<div class="row">
						  <form id="form_new_user" method="GET">
						  <input type="hidden" id="gm_time_slots" name="gm_time_slots" value="<?php echo $gmt_time_id;?>">
							<div class="col-md-4">
								<div class="form-group">
									<label>From Date</label>
									<input type="text" id="search_from_date" name="date_from" value="<?php echo !empty($search_from) ? $search_from : ""; ?>" class="form-control" required readonly autocomplete="off">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>To Date</label>
									<input type="text" id="search_to_date" name="date_to" value="<?php echo !empty($search_to) ? $search_to : ""; ?>" class="form-control" required readonly autocomplete="off">
								</div>
							</div>
							<!-- <div class="col-md-4">
								<div class="form-group">
									<label>Session Type</label>
									<Select class="form-control">
										<option value="">--Select--</option> 
										<option value="">Session Type</option> 
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Age Group</label>
									<Select class="form-control">
										<option value="">--Select--</option> 
										<option value="">Age Group</option> 
									</select>
								</div>
							</div> -->
							<?php if(get_login_type() == "client"){ ?>
							<!--<div class="col-md-4">
								<div class="form-group">
									<label>Courses</label>
									<Select class="form-control" name="course_id" id="course_id">
										<option value="">--All--</option> 
										<?php foreach($courselist as $ke=>$rows){  ?> 
										<option value="<?php echo $rows['id']?>" <?php echo ($rows['id']==$course_id)?'selected="selected"':'';?>><?php echo $rows['name']?></option> 
										<?php } ?>
									</select>
								</div>
							</div>-->
							<div class="col-md-4">
								<div class="form-group">
									<label>Teachers</label>
									<Select class="form-control" name="teacher_id" id="teacher_id">
										<option value="">--All--</option>
										<?php foreach($teachersList as $k=>$row){  ?> 
										<option value="<?php echo $row['id']?>" <?php echo ($row['id']==$teacher_id)?"selected='selected'":'';?>><?php echo $row['fname'].' '.$row['lname'];?></option> 
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
							<div class="form-group">
									<label>GM Time Slots</label>	
								<select name="gmt_time_id" id="gmt_time_id" class="form-control" onchange="set_gmt_val();">
								<?php foreach($gmtList as $token){			
								$selection = "";
								if($gmt_time_id == $token['id']){ $selection = "selected"; }
								?>
								<option value="<?php echo $token['GMT_offset']; ?>" sltid="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['gmtCountryName']; ?></option>
								<?php } ?>
								</select>
							</div>	
							</div>
							<div class="col-md-4">
							<div class="form-group">
									<label>Status</label>	
								<select name="status_id" id="status_id" class="form-control">
									<?php $selection=($iscomp)?'selected':'' ?>
									<option value="" <?= $selection=($iscomp=='')?'selected':'' ?>>Pending</option>
								<option value="1" <?= $selection=($iscomp==1)?'selected':'' ?>>Completed</option>
								<option value="2" <?= $selection=($iscomp==2)?'selected':'' ?>>Canceled</option>
								</select>
							</div>	
							</div>
							<?php }?>
							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group" style="display:flex;">
									<button class="btn btn-primary waves-effect" type="submit" id='show' name='show' value="Show">SHOW</button>
									<!--<button style="margin-left: 8px;" class="btn btn-success waves-effect" type="submit" id='download' name='download' value="Download">Download</button>-->
								</div>
							</div>
							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									
								</div>
							</div>
							
							<?php 
							/*$download_link = base_url().'diy/generate_available_reports?date_from='.$_GET['date_from'].'&date_to='.$_GET['date_to'];
							if($download_link!=""){ ?>
								<div style='float:right; margin-top:22px;' class="col-md-1">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>	
									</div>
								</div>
							<?php }*/ ?>
							
						  </form>
						</div>
						
						<form name="frm" id="frm" method="post" action="<?php echo base_url();?>/diy/completed_schedule_multi_upload">
							<div class="table-responsive">
								<table class="table table-striped skt-table" cellspacing="0" width="100%">
									<thead>
										<tr class='bg-info'>
										<?php if(get_role() != 'teacher' && get_role() != 'Teacher'){ ?>
											<th><input type="checkbox" class="checkAll">SL</th>
											<?php } else{?>
											<th>SL</th>
											<?php } ?>
											<th>Teachers Name</th>
											<!--<th>Course</th>-->
											<th>Date</th>
											<th>Day</th>
											<th>Start Time</th>
											<th>End Time</th>
											<th>Session Name</th>
											<!--<th>Age Group</th>-->
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$counter=0;
										foreach($scheduleList as $row){ 
											$counter++;
											$checkup = "Pending"; $checkupClass = "danger";
											if($row['status'] == 'P'){ $checkup = "Pending"; $checkupClass = "danger"; }
											if($row['status'] == 'C'){ $checkup = "Approved"; $checkupClass = "success"; }
										?>
										<tr>
										<?php if(get_role() != 'teacher' && get_role()!= 'Teacher'){ ?>
    												<?php
    													$comp_id = $row['is_comp'];

    													if($row['is_comp']==0 && $row['active'] == 1){
    												 ?>
											<td><input type="checkbox" class="checkboxes" name="selectsllist[]" value="<?php echo $row['schedule_id'];?>" /><?php echo "&nbsp;&nbsp;".$counter; ?></td>
											<?php }else{?>
												<td><?php echo "&nbsp;&nbsp;".$counter; ?></td>
											<?php }} else{ ?>
												<td><?php echo "&nbsp;&nbsp;".$counter; ?></td>
											<?php } ?>

											<td><?php echo $row['teacher_name']; ?></td>
											<!--<td><?php echo $row['course_name']; ?></td>-->
											<td><?php echo date('d M, Y', strtotime($row['condate'])); ?></td>
											<td><?php echo $row['condays']; ?></td>
											<td><?php echo $row['constart_time']; ?></td>
											<td><?php echo $row['conend_time']; ?></td>
											<td><?php echo $row['session_type']; ?></td>
											<!--<td><?php echo $row['age_group']; ?></td>-->
											<td> 
											<?php if(get_role() != 'teacher' && get_role()!= 'Teacher'){ ?>
											<!--<a class="btn btn-primary btn-xs" target="blank" href="<?php echo base_url()?>diy/availability_update_data/<?php echo $row['schedule_id'];?>"><i class="fa fa-edit"></i> Edit</a> -->
											
											<?php } ?>
											<?php 
    											$endDate=date('Y-m-d', strtotime($row['condate']))." ".$row['conend_time'];
    												?>
    												<?php if($row['is_comp']==0 && $row['active'] == 1){ ?>
													<a class="btn btn-success btn-xs" target="_blank" href="<?php echo base_url()?>diy/availability_calendar/<?php echo $row['teacher_id'];?>/<?php echo date('Y-m-d', strtotime($row['condate'])); ?>">
													<i class="fa fa-eye"></i> Calendar</a>    													
    												<a class="btn btn-success btn-xs" onclick="return confirm('Do you want mark the selected schedules as completed?')" href="<?php echo base_url()?>diy/completed_schedule/<?php echo $row['schedule_id'];?>">
    													<i class="fa fa-edit"></i> Complete</a>
    												<a class="btn btn-danger btn-xs" onclick="return confirm('Do you want mark the selected schedule as cancelled, please provide reason to proceed?')" href="<?php echo base_url()?>diy/cancel_schedule/<?php echo $row['schedule_id'];?>">
    													<i class="fa fa-edit"></i> Cancel</a>
    												<?php }
    												if($row['is_comp']==1 && $row['active'] == 1){ 
    													
    													?>
    													<p class="btn btn-xs" style="background-color: transparent;color:green">Completed</p>


    											<?php } 
    											if($row['is_comp']==0 && $row['active'] == 0){
    												?>
    													<p class="btn btn-xs" style="background-color: transparent;color:red">Canceled</p>
													<?php } ?>
												<!-- <a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete?')" href="<?php echo base_url()?>diy/delete_schedule/<?php echo $row['schedule_id'];?>">
												<i class="fa fa-trash-o"></i> Delete</a> -->
												<!-- <?php
												
                                            $id=$row['id'];
                                             $params= $row['name'];     
											// echo "<button title='Edit' rid='$id' params='$params' type='button' class='editCourseBtn btn btn-info btn-xs'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>&nbsp;";
											//echo '<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal222"><i class="fa fa-pencil-square-o"></i> Edit</button>';
                                        ?>  
											<button type="button"  class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o"></i> Edit</button>-->
											
											
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<div style="width:100%;display:flex;justify-content:center;align-items:center;">
										<!-- <a class="btn btn-danger" id="selectslbutton" style="width:50%;" target="_blank" href="<?php echo base_url()?>diy/function name/<?php echo $row['teacher_id'];?>">
										<i class="fa fa-trash-o"></i> Delete Selected Items</a> -->
								<input type="submit" class="btn btn-success" id="selectslbutton" onclick="return confirm('Do you want mark the selected schedules as completed?')" name="complete_multi" value="Complete Selected Items" style="width:50%;">
								<!--<input type="submit" class="btn btn-danger" id="selectslbutton_cancel" onclick="return confirm('Are you sure you want to cancel selected Items?')" name="cancel_multi" value="Cancel Selected Items" style="width:50%;">--> 
							</div>
					</form>	
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	

<!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirm</h4>
      </div>
      <div class="modal-body">
        Few schedules are not completed, do you want to proceed with auto complete them and invoiced?
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default">Auto complete and invoice</button>
        <button type="submit" class="btn btn-primary">Invoice completed only</button>
      </div>
      </form>	
    </div>
  </div>
</div>
 -->
<?php /*
<div id="myModal" class="modal fade" role="dialog" style="font-size:90%; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="add_level" id="leave_form" onsubmit="submit_data();">
                <div class="modal-header" style="padding:8px 15px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Schedule</h4>
                </div>
                <div class="modal-body">

                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Date :</label>
                            <div class="col-md-6">
                                <input type="text" name="date" class="form-control date_pic" required>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding:3px 0px;">
						<div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Day :</label>
                            <div class="col-md-6">
                                <select class="form-control">
									<option value="">Select Days</option>
									<option value="1">Mon</option>
									<option value="2">Tue</option>
									<option value="3">Wed</option>
									<option value="4">Thu</option>
									<option value="5">Fri</option>
									<option value="6">Sat</option>
									<option value="7">Sun</option>
								</select>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding:3px 0px;">
						<div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Teachers Name :</label>
                            <div class="col-md-6">
                                <select class="form-control">
									<option value="">Select Teachers Name</option>
									<option value="1">Teacher 1</option>
									<option value="1">Teacher 2</option>
									<option value="1">Teacher 3</option>
									<option value="1">Teacher 4</option>
									<option value="1">Teacher 5</option>
								</select>
                            </div>
                        </div>
                    </div>
					<div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Email :</label>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                    </div>
                
				<div class="row" style="padding:3px 0px;">
						<div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Slots Time :</label>
                            <div class="col-md-6">
                                <select class="form-control">
									<option value="">Select Slots Time</option>
									<option value="1">11 AM</option>
									<option value="1">12 PM</option>
									<option value="1">1 PM</option>
									<option value="1">2 PM</option>
									<option value="1">3 PM</option>
								</select>
                            </div>
                        </div>
                </div>
				<div class="row" style="padding:3px 0px;">
						<div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Session Type :</label>
                            <div class="col-md-6">
                                <select class="form-control">
									<option value="">Select Session Type</option>
									<option value="1">11</option>
									<option value="1">12</option>
									<option value="1">1</option>
									<option value="1">2</option>
									<option value="1">3</option>
								</select>
                            </div>
                        </div>
                </div>
				<div class="row" style="padding:3px 0px;">
						<div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Course :</label>
                            <div class="col-md-6">
                                <select class="form-control">
									<option value="">Select Course</option>
									<option value="1">11</option>
									<option value="1">12</option>
									<option value="1">1</option>
									<option value="1">2</option>
									<option value="1">3</option>
								</select>
                            </div>
                        </div>
                </div>
					<div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Age Group :</label>
                            <div class="col-md-6">
                                <input type="name" name="email" class="form-control" required>
                            </div>
                        </div>
                    </div>
					<div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Child Name :</label>
                            <div class="col-md-6">
                                <input type="name" name="child_name" class="form-control" required>
                            </div>
                        </div>
                    </div>
					<div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Notes :</label>
                            <div class="col-md-6">
								<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="modal-footer" style="padding:8px 15px;">
                    <button id="sub_but" type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
*/ ?>
<script type="text/javascript">
	function set_gmt_val(id){

		 var element = $('#gmt_time_id').find('option:selected'); 
        var slot_id = element.attr("sltid");
		$('#gm_time_slots').val(slot_id);
	}
</script>