<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
				
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">Leave Report</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">
					
						<div class="row">
						  <form id="form_new_user" autocomplete="off" method="GET">
						  
							
							<div class="col-md-3">								
								<label>From Date</label>
								<input type="text" id="start_date" name="start_date" value="<?php if(!empty($gotStart)){ echo date('m/d/Y', strtotime($gotStart)); } ?>" class="form-control diy_datePicker" required>
							</div>
							
							<div class="col-md-3">
								<label>To Date</label>
								<input type="text" id="end_date" name="end_date" value="<?php if(!empty($gotEnd)){ echo date('m/d/Y', strtotime($gotEnd)); } ?>" class="form-control diy_datePicker" required>
							</div>
																
							
							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									<button class="btn btn-primary waves-effect" type="submit" id='show' name='show' value="Show">Search</button>
								</div>
							</div>
							
						  </form>
						</div>
						
						<br/><br/>
						
						<div class="panel panel-default">
						  <div class="panel-heading"><b>Teacher Leave</b></div>
						  <div class="panel-body">	  
							<div style="width:100%;height:400px; padding:10px 10px">
								<canvas id="qa_2dpie_graph_container"></canvas>
							</div>  
						  </div>
						</div>
						
						
						
						<div class="row">
						<div class="table-responsive">
							<table class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th class="text-center">SL</th>
										<th class="text-center">Teachers Name</th>
										<th class="text-center">No of Leave</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									//echo "<pre>" .print_r($teacherArray, 1) ."</pre>";
									$counter=0;	 							
									foreach($teacherArray as $key=>$token){ 
										$counter++;		
										$tid = $token['employee_id'];										
									?>
									<tr>
										<td class="text-center"><?php echo $counter; ?> </td>
										<td class="text-center"><?php echo $token['teacher_name']; ?></td>
										<td class="text-center"><?php echo !empty($overallDates[$tid]) ? count($overallDates[$tid]) : "0"; ?></td>									
									</tr>
									<?php } ?>
								</tbody>

							</table>
						</div>
						
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	