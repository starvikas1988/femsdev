<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Generate Raw Report</h4>
					</header>
					
					<hr class="widget-separator">
					<div class="widget-body clearfix">
						<form action="<?php echo base_url('employee_feedback/gen_rawreport') ?>" method="POST" id="search_report">
						
						<div class="row">
						<div class="col-md-4">
						<select class="form-control" name="office_id" id="office_id">
							<?php foreach($location_list as $loc):
								$sel = "";
								if($useroffice == $loc['abbr'] ) $sel="selected";
							?>
							<option value="<?php echo $loc['abbr']; ?>" <?php echo $sel;?> ><?php echo $loc['office_name']; ?></option>
							<?php endforeach; ?>			
						</select>
						</div>
						
						<div class="col-md-4">
						<select class="form-control" name="quartertime" id="quartertime" required>
							<?php foreach($quarter_list as $tokenq):
								$sel="";
								if($cquarter == $tokenq['yearlist']) $sel="selected";
							?>
							<option value="<?php echo $tokenq['yearlist']; ?>" <?php echo $sel;?> ><?php echo $tokenq['yearlist']; ?></option>
							<?php endforeach; ?>			
						</select>
						</div>
						
						<!--<div class="col-md-4">
						<select class="form-control" name="reportype" id="reportype" required>
							<option value="all">All Feedback</option>			
							<option value="pending">Pending Feedback</option>			
						</select>
						</div>-->
						
						</div>
						<br/><br/>
							<div class="row no-margin">
								<div class="col-md-12">
									<button type="submit" class="btn btn-success btn-sm btn-block">Get Report</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>