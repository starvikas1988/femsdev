<style>
	.widget
	{
		text-align:center !important;
	}
	.widget > div > div
	{
		font-size:34px !important;
	}
	.widget > div > div > h3
	{
		margin:0px !important;
	}
	.widget > div > div > h3 > span
	{
		font-size: 40px;
	}
</style>
<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<?php echo form_open('',array('method' => 'get')) ?>
							<div class="col-md-3">
								<header class="widget-header">
									<h4 class="widget-title text-left">DFR Dashboard (EST)</h4>
								</header>
							</div>
						
							<div class="col-md-2">
								<div class="widget-header text-left">
								<?php
									echo '<select name="location" class="form-control">';
									
									foreach($location_list as $key=>$value)
									{
										$sCss="";
										if($value['abbr']==$location) $sCss="selected";
									
										echo '<option value="'.$value['abbr'].'" '.$sCss.'>'.$value['office_name'].'</option>';
									}
									echo '</select>';
								?>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="widget-header text-left">
								<?php
									echo '<select name="process" class="form-control">';
									
									foreach($process_list as $key=>$value)
									{
										$sCss="";
										if($value['id']==$process) $sCss="selected";
									
										echo '<option value="'.$value['id'].'" '.$sCss.'>'.$value['name'].'</option>';
									}
									echo '</select>';
								?>
								</div>
							</div>
							
							
							
							
							<div class="col-md-3">
								<div class="widget-header text-left">
								<input type="text" class="form-control" id="start_date" value='<?php echo $start_date; ?>' name="start_date" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-2">
								<div class="widget-header">
									<input type="submit" name="showReports" value="Show" class="btn btn-block btn-success">
								</div>
							</div>
						</form>
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">
						
							<div class="row">
								
								
							</div>
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>

<div class="wrap">
	<section class="app-content">
		<div class="row">	
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $opened_requisation; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Requisition Open</small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>

			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="">
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $candidate_registered; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Candidate Registered</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			

			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $total_candidate_scheduled; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Total Candidate Scheduled</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $total_candidate_pending; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Total Candidate Pending</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
		</div>

	</section>
</div>


<div class="wrap">
	<section class="app-content">
		<div class="row">	
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $candidate_inprogress; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Candidate In-Progress</small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>

			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $candidate_shortlisted; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Candidate Shortlisted</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			

			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $total_candidate_selected; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Candidate Selected</small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>
			
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $candidate_rejected; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer  bg-primary">
						<small>Candidate Rejected</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			
						
		</div>

	</section>
</div>


<div class="wrap">
	<section class="app-content">
		<div class="row">	
						
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $total_candidate_selected_employee; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Candidate Selected as Employee</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $candidate_undefind_status; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Candidate Undefined Status</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			
		</div>

	</section>
</div>


<div class="wrap">
	<section class="app-content">
		<div class="row">	
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $total_interview_scheduled; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Total Interview Scheduled</small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>

			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $interview_completed; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Interview Completed</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			

			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $interview_pending; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Interview Pending</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $interview_cancel; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Interview canceled</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			
		</div>

	</section>
</div>


<div class="wrap">
	<section class="app-content">
		<div class="row">	
		
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $hr_interview_completed; ?>/<?php echo $hr_interview_cancel; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>HR Interview Completed / Canceled</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $hr_interview_pending; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>HR Interview Pending</small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>

			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $ops_interview_completed; ?> / <?php echo $ops_interview_cancel; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>OPs Interview Completed / Canceled </small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			

			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $ops_interview_pending; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>OPs Interview Pending</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			
		</div>

	</section>
</div>


<div class="wrap">
	<section class="app-content">
		<div class="row">
			
			
			<!--
			<div class="col-sm-3">
				<a href="">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div>
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php //echo $pending_cand_final_stat; ?></span></h3>
						</div>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Pending Candidate Final Status</small>
					</footer>
				</div>
				</a>
			</div>
			-->
			
		</div>

	</section>
</div>




<!--<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title"></h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">	
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Information Type</th>
										<th>Value</th>
									</tr>
								</thead>
								<tbody>
									<!--<tr>
										<td>1</td>
										<td>Requisition Open</td>
										<td><?php echo $opened_requisation; ?></td>
									</tr>
									<tr>
										<td>2</td>
										<td>Candidate Registered</td>
										<td><?php echo $candidate_registered; ?></td>
									</tr>
									<tr>
										<td>3</td>
										<td>Total Candidate Scheduled</td>
										<td><?php echo $total_candidate_scheduled; ?></td>
									</tr>
									<tr>
										<td>4</td>
										<td>Total Candidate Pending</td>
										<td><?php echo $total_candidate_pending; ?></td>
									</tr>-->
									<!--<tr>
										<td>5</td>
										<td>Candidate In-Progress</td>
										<td><?php echo $candidate_inprogress; ?></td>
									</tr>
									<tr>
										<td>6</td>
										<td>Candidate Shortlisted</td>
										<td><?php echo $candidate_shortlisted; ?></td>
									</tr>
									<tr>
										<td>7</td>
										<td>Total Candidate Selected</td>
										<td><?php echo $total_candidate_selected; ?></td>
									</tr>
									<tr>
										<td>8</td>
										<td>Total Candidate Selected as Employee</td>
										<td><?php echo $total_candidate_selected_employee; ?></td>
									</tr>-->
									<!--<tr>
										<td>9</td>
										<td>Total Interview Scheduled</td>
										<td><?php echo $total_interview_scheduled; ?></td>
									</tr>
									<tr>
										<td>10</td>
										<td>Interview Completed</td>
										<td><?php echo $interview_completed; ?></td>
									</tr>
									<tr>
										<td>11</td>
										<td>Interview Pending</td>
										<td><?php echo $interview_pending; ?></td>
									</tr>
									<tr>
										<td>12</td>
										<td>HR Interview Completed</td>
										<td><?php echo $hr_interview_completed; ?></td>
									</tr>-->
									<!--<tr>
										<td>13</td>
										<td>HR Interview Pending</td>
										<td><?php echo $hr_interview_pending; ?></td>
									</tr>
									<tr>
										<td>14</td>
										<td>OPs Interview Completed</td>
										<td><?php echo $ops_interview_completed; ?></td>
									</tr>
									<tr>
										<td>15</td>
										<td>OPs Interview Pending</td>
										<td><?php echo $ops_interview_pending; ?></td>
									</tr>
									<tr>
										<td>16</td>
										<td>Candidate Undefined Status</td>
										<td><?php echo $candidate_undefind_status; ?></td>
									</tr>-->
									<!--<tr>
										<td>17</td>
										<td>Pending Candidate Final Status</td>
										<td><?php echo $pending_cand_final_stat; ?></td>
									</tr>
									<tr>
										<td>18</td>
										<td>Candidate Rejected</td>
										<td><?php echo $candidate_rejected; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>-->
