<div class="wrap">
	<?php
		
			echo '<section class="app-content">';
				echo '<div class="row">';
					echo '<div class="col-md-12">';
						echo '<div class="widget">';
							echo '<header class="widget-header">';
								echo '<h4 class="widget-title">Available Examination</h4>';
							echo '</header>';
							echo '<hr class="widget-separator">';
							
							echo '<div class="widget-body clearfix">';
								echo '<div class="table-responsive">';
									echo '<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">';
										echo '<thead>';
											echo '<tr class="bg-info">';
												echo '<th>SL</th>';
												echo '<th>Examination</th>';
												echo '<th>Total Question</th>';
												echo '<th>Allotted Time</th>';
												echo '<th>Action</th>';
											echo '</tr>';
										echo '</thead>';
										
										echo '<tbody>';
										//echo '<pre>';
										//print_r($available_exam);
										if($available_exam_count > 0)
										{
											$i=1;
											foreach($available_exam as $key=>$value)
											{
												echo '<tr>';
													echo '<td>'.$i.'</td>';
													echo '<td>'.$value->module_id.'</td>';
													echo '<td>'.$value->no_of_question.'</td>';
													echo '<td>'.$value->allotted_time.'</td>';
													
													if(strtotime($value->exam_start_time_est) <= strtotime($value->current_server_time) && strtotime($value->current_server_time) <= strtotime($value->exam_end_time))
													{
														if($value->exam_status == 1)
														{
															echo '<td><button class="btn btn-success btn-sm disabled">Give Exam</button></td>';
														}
														else
														{
															echo '<td><form method="POST" action="'.base_url('examination/exam_panel').'"><input type="hidden" name="lt_exam_schedule_id" value="'.$value->id.'"><button type="submit" class="btn btn-success btn-sm">Give Exam</button></form></td>';
														}
													}
													else
													{
														echo '<td><button class="btn btn-success btn-sm disabled">Give Exam</button></td>';
													}
												echo '</tr>';
												$i++;
											}
										}
										else
										{
											echo '<tr>';
												echo '<td colspan="5" class="text-center">No Examination Available</td>';
											echo '</tr>';
										}
										echo '</tbody>';
										
									echo '</table>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</section>';
		
		
	?>
</div>