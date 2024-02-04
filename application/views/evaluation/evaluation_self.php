<style>
#search_agent_rec tr:hover td {
	background: #EAEDCA;
	cursor:pointer;
}
</style>


<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Quarterly Job  Performance Evaluation Form</h4>
					</header>
					<hr class="widget-separator"/>
					<div class="widget-body clearfix">
														
							<div class="row">
							
								<div class="panel panel-info">
									  <div class="panel-heading">Please read carefully and fill self</div>
									  <div class="panel-body" style='font-size:12px;'>
										  1. Rate your performance, using the definitions below.<br>
										  2. Give an overall rating in the space provided, using the definitions below as a guide.
									</div>
								</div>
								<div class="panel panel-info">
									  <div class="panel-heading">
										Performance Rating Definitions:<br>
										<div style='font-size:12px;'><i>The following ratings must be used to ensure commonality of language and consistency on overall ratings:<br>
										(There should be supporting comments to justify ratings of “Outstanding”,“Below Expectations, and “Unsatisfactory”).</i>
										</div>
									  </div>
									  <div class="panel-body" style='font-size:12px;'>
										a) Outstanding Performance is consistently superior : <b>5 points </b> <br>
										b) Exceeds Expectations Performance is routinely above job requirements: <b>4 points </b>  <br>
										c) Meets Expectations Performance is regularly competent and dependable: <b>3 points </b> <br>
										d) Below Expectations Performance fails to meet job requirements on a frequent basis: <b>2 points </b> <br>
										e) Unsatisfactory Performance is consistently unacceptable: <b>1 point </b> <br>
									  </ul>
									</div>
								</div>
								
								<div class="alert alert-info">
								<b>Employee Name: <?php echo get_username(); ?></b>
								</div>
								
						</div>
						
						
						<?php 
							if($error!='') echo $error;
						?>
						
						<?php 
							echo form_open('',array('data-toggle'=>'validator'));
							
							$year = date("Y");
							$previousyear = $year -1;
							$cmonth=date('m');
						?>
						
						<div class="row">
							
								<div class="col-md-6">	
									
									<div class="input-group">
									
											<label for="evaluation_month">Select Evaluation Period:</label>
											<select style='width:150px' class="form-control selectpicker " name="evaluation_month" id="evaluation_month" required>
												<option value=''>- Period -</option>
												<option value='January-March'>January-March</option>
												<option value='April-June'>April-June</option>
												<option value='July-September'>July-September</option>
												<option value='October-December'>October-December</option>
											</select>
											

											<div class="input-group-btn" style='padding-top:25px;'>
													<select style='width:150px' class="form-control selectpicker" name="evaluation_year" id="evaluation_year" required>
														<option value=''>-Year-</option>
														<?php if($cmonth<='03') echo "<option value='$previousyear'>$previousyear</option>"; ?>
														<option value='<?php echo $year;?>'><?php echo $year;?></option>
													</select>
								
											</div>
																			
									</div>
									
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label for="evaluation_date">Evaluation Date:</label>
										<input type="text" class="form-control" id="evaluation_date" placeholder="Evaluation Date" name="evaluation_date" required >
									</div>
								</div>
						</div> 
						
						
						<div class="row">
							
							<div class="col-md-12">	
								<b>A) Performance Planning And Results/ Performance Review:</b>
							</div>
								
						</div> 
						
						<div class="row">
						
							<div class="table-responsive">
							
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>SL</th>
										<th>Evaluation Factors</th>
									    <th width='140px'>Score (Self)</th>
									</tr>
								</thead>
																
	
								<tbody>
									<tr>
										<td>1.</td>
										<td>
											Knowledge of Work - Consider employee's skill level, knowledge and understanding of all phases of the job and those requiring improved skills and/or experience.
										</td>
										<td>
										
											<div class="form-group">
												<input id="knowledge_work_self" name="knowledge_work_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
										
									</tr>
									<tr>
										<td>2.</td>
										<td>
											Planning and Organizing - Consider how well the employee defines goals for personal performance; how well work tasks are organized and priorities established; and the amount of supervision required to achieve it.
										</td>
										<td>
											
											<div class="form-group">
												<input id="planning_organizing_self" name="planning_organizing_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
																				
										</td>
									</tr>
									
									<tr>
										<td>3.</td>
										<td>
											Customer Relations - Consider how well the employee interacts in dealing with internal staff, external customers and vendors; employee projects a courteous manner.
										</td>
										<td>
											<div class="form-group">
												<input id="customer_relations_self" name="customer_relations_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
											
										</td>
									</tr>
									<tr>
										<td>4.</td>
										<td>
											Quality of Work - Consider the accuracy and thoroughness in completing work assignments. Consider the individual's ability to self-identify and correct errors. Take into consideration incomplete assignment.
										</td>
										<td>
											<div class="form-group">
												<input id="quality_work_self" name="quality_work_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
									<tr>
										<td>5.</td>
										<td>
											Quantity of Work - Consider the volume of work completed in relation to assigned responsibilities. Consider the ability to meet and stay on schedule and the proper use of work time.
										</td>
										<td>
											<div class="form-group">
												<input id="quantity_work_self" name="quantity_work_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
									<tr>
										<td>6.</td>
										<td>
											Dependability - Consider how well employee complies with instructions and performs under unusual circumstances; consider record of attendance and punctuality.
										</td>
										<td>
											<div class="form-group">
												<input id="dependability_self" name="dependability_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
									<tr>
										<td>7.</td>
										<td>
											Acceptance of Responsibility - Consider the manner in which the employee accepts new and varied work assignments, and assumes personal responsibility for completion.
										</td>
										<td>
											<div class="form-group">
												<input id="responsibility_self" name="responsibility_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
									<tr>
										<td>8.</td>
										<td>
											Self-Initiative - Consider how well employee demonstrates resourcefulness, independent thinking, and the extent to which employee seeks additional challenges and opportunities on their own.
										</td>
										<td>
											<div class="form-group">
												<input id="self_initiative_self" name="self_initiative_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
									<tr>
										<td>9.</td>
										<td>
											Teamwork - Consider how well this individual gets along with fellow employees, respects the rights of other employees and shows a cooperative spirit.
										</td>
										<td>
											<div class="form-group">
												<input id="teamwork_self" name="teamwork_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
									<tr>
										<td>10.</td>
										<td>
											Safety - Consider this individual's work habits and attitudes as they apply to working safely. Consider their contribution to accident prevention, safety awareness and ability to are for equipment and keep workspace safe and tidy.
										</td>
										<td>
											<div class="form-group">
												<input id="safety_self" name="safety_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
									<tr>
										<td>11.</td>
										<td>
											Personal Appearance - Consider the employee's neatness and personal hygiene appropriate to position.
										</td>
										<td>
											<div class="form-group">
												<input id="personal_appearance_self" name="personal_appearance_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
									<tr>
										<td>12.</td>
										<td>
											Leadership - Measures effectiveness in accomplishing work assignments through subordinates; establishing challenging goals; delegating and coordinating effectively; promoting innovation and team effort.
										</td>
										<td>
											<div class="form-group">
												<input id="leadership_self" name="leadership_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
									<tr>
										<td>13.</td>
										<td>
											Communication - Measures effectiveness in listening to others, expressing ideas, both orally and in writing, and providing relevant and timely information to management, co-workers, subordinates and customers.
										</td>
										<td>
											<div class="form-group">
												<input id="communication_self" name="communication_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
									<tr>
										<td>14.</td>
										<td>
											Decision Making/Problem Solving - Measures effectiveness in understanding problems and making timely, practical decisions.
										</td>
										<td>
											<div class="form-group">
												<input id="problem_solving_self" name="problem_solving_self" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											</div>
										</td>
									</tr>
																											
								</tbody>
							</table>
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
								<label for="comment">You Comments </label>
								<textarea class="form-control" rows="2" placeholder="Enter You Comments" id="comments_self" name='comments_self' required></textarea>
							</div>
						</div>
													
					</div>	
					<div class="row">							  	
							<div class="col-md-12 text-center">
								<input type="submit" name="submit" class="btn btn-primary btn-md" value="Save">
								<button type="reset" class="btn btn-danger btn-md" id="reset">Reset</button>	
							</div>
					</div>
						
					</form>
			   </div>
		</div><!-- .row -->
	</section>

</div><!-- .wrap -->
