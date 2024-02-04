<style>
	.header_style_failed{
			border-radius: 10px 10px 0px 0px;"
			border: solid 1px black; background-color: red;font-family: tahoma;
	}
	
	.header_style_start{
			border-radius: 10px 10px 0px 0px;"
			border: solid 1px black; background-color: green;font-family: tahoma;
	}
	
	.pending_style{
		
		border-radius: 10px 10px 0px 0px;"
			border: solid 1px black; background-color: #cbcf0e;font-family: tahoma;
	}
	
	.bg-info{
			background-color: #0ecfc1;
	}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive" style="margin-top:20px; border-radius: 10px 10px 10px 10px;">
				<?php
					if(isset($failed_exam_infos))
					{
						foreach($failed_exam_infos as $key=>$value)
						{
							echo '<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">';
				?>
							<thead>
								<tr class="bg-info">
									<th colspan="3" class="text-center header_style_failed" ><h4 style="font-weight: bold;">Failed Exam Info</h4></th>
								</tr>
								<tr class="bg-info">
								
									<th style="font-weight: bold;">Total Question</th>
									<th style="font-weight: bold;">Exam Date</th>
									<th style="font-weight: bold;">Result</th>
								</tr>
							</thead>
							<tbody>
								<?php
									echo '<tr>';
									echo '<td style="font-weight: bold;"> Total Question : '. $this->config->item('fems_certificate_total_question') .', Attempted '. $value->total_question_attempted .'</td>';
										//echo '<td style="font-weight: bold;">'.$value->total_question.'</td>';
										echo '<td style="font-weight: bold;">'.$value->exam_datetime.'</td>';
										echo '<td style="font-weight: bold;">'.$value->result.' (Marks)</td>';
									echo '</tr>';
								?>
							</tbody>
				<?php
							echo '</table>';
						}
					}
				?>
				<?php
					if(count($pending_exam)==0)
					{
				?>
				<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0" >
					<thead>
						<tr class="bg-info"  style="border-radius: 10px 10px 10px 10px;">
							<th colspan="3" class="text-center header_style_start"><h4 style="font-weight: bold;">Fusion Certification Exam</h4></th>
						</tr>
						<tr class="bg-info ">
						
							<th style="font-weight: bold;">Total Question</th>
							<th style="font-weight: bold;">Pass Marks</th>
							<th style="font-weight: bold;">Total Time</th>
					
						</tr>
					</thead>
						
					<tbody>
						<tr>
							<td style="font-weight: bold;"><?php echo $total_question_no; ?></td>
							<td style="font-weight: bold;"><?php echo $pass_mark.'%'; ?> (Marks)</td>
							<td style="font-weight: bold;"><?php echo $per_question_time * $total_question_no; ?></td>
						</tr>
						<tr>
							<td colspan="3" class="text-center"><a href="<?php echo base_url('fems_certification/startexam'); ?>"><button class="btn btn-success btn-sm">Start Exam</button></a></td>
						</tr>
					</tbody>
				</table>
				<?php
					}
				?>
				<?php
					if(count($pending_exam) >0)
					{
						foreach($pending_exam as $key=>$value)
						{
							echo '<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0"  style="margin-top:20px; border-radius: 10px 10px 10px 10px;">';
				?>
							<thead>
								<tr class="bg-info"   style="border-radius: 10px 10px 10px 10px;">
									<th colspan="3" class="text-center pending_style"><h4  style="font-weight: bold;">Pending Exam Info</h4></th>
								</tr>
								<tr class="bg-info pending_style">
								
									<th style="font-weight: bold;">Total Question</th>
									<th style="font-weight: bold;">Exam Date</th>
									<th style="font-weight: bold;">Result</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$pending = (int)$this->config->item('fems_certificate_total_question') - (int)$this->session->userdata('ques_counter');
									echo '<tr>';
										//echo '<td style="font-weight: bold;">'.$value->total_question.'</td>';
										echo '<td style="font-weight: bold;"> Total Question : '. $this->config->item('fems_certificate_total_question') .', Attempted '. $this->session->userdata('ques_counter') .' & Pending :'. $pending .'</td>';
										
										echo '<td style="font-weight: bold;">'.$value->exam_datetime.'</td>';
										echo '<td style="font-weight: bold;">'.$value->result.' (Marks)</td>';
									echo '</tr>';
								?>
									<tr>
							<td colspan="3" class="text-center"><a href="<?php echo base_url('fems_certification/pendingexam/'.$value->attempt_id); ?>"><button class="btn btn-success btn-sm">Start Exam</button></a></td>
									</tr>
							</tbody>
				<?php
							echo '</table>';
						}
					}
				?>
			</div>
		</div>
	</div>
</div>