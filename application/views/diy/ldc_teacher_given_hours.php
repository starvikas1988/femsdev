<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">Hours Given By Teacher Day and Time List</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">
					
						<div class="row">
						  <form id="form_new_user" method="GET">
						  
							<div class="col-md-2">
								<div class="form-group">
									<label>Teacher List</label>
									<!-- <input type="text" id="search_from_date" name="date_from" value="<?php echo !empty($search_from) ? $search_from : ""; ?>" class="form-control" required autocomplete="off"> -->
									<select name="teacher_id" id="teacher_id">
										<?php foreach($teachersData as $key=>$val){?>
										<option value="<?php echo $val['id'];?>"><?php echo $val['fname'].' '. $val['lname'];?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<!-- <label>To Date</label>
									<input type="text" id="search_to_date" name="date_to" value="<?php echo !empty($search_to) ? $search_to : ""; ?>" class="form-control" required autocomplete="off"> -->
								</div>
							</div>
													
							<div class="col-md-4">
								
							</div>
							
							
							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									<button class="btn btn-primary waves-effect" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
						  </form>
						</div>
						
						<form name="frm" id="frm" method="post" action="<?php echo base_url();?>/diy/multi_avail_update_status">
						<div class="table-responsive">
							<table class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th><input type="checkbox" class="checkAll"> SL</th>
										<th>Teachers Name</th>
										<th>Date</th>
										<th>Day</th>
										<th>Hours</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$counter=0;
									
									foreach($tech as $key=>$row){ 
										$counter++;
									?>
									<tr>
										<td><?php echo $counter; ?> </td>
										<td><?php echo $row['teacher_id']; ?></td>
										<td><?php echo $row['avail_date']; ?></td>
										<td><?php echo $row['avail_day']; ?></td>
										<td><?php echo $row['cont']; ?></td>
										
									</tr>
									<?php } ?>
								</tbody>

							</table>
										<div style="width:100%;display:flex;justify-content:center;align-items:center;">
										<!-- <a class="btn btn-danger" id="selectslbutton" style="width:50%;" target="_blank" href="<?php echo base_url()?>diy/function name/<?php echo $row['teacher_id'];?>">
										<i class="fa fa-trash-o"></i> Delete Selected Items</a> -->
										<button type="submit" class="btn btn btn-success btn-xs" id="selectslbutton" style="width:50%;"><i class="fa fa-file"></i>Approved Selected Items</button>
										</div>
						</div>
						</form>
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	