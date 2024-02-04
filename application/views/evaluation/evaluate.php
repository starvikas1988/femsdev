<style>
#search_agent_rec tr:hover td {
	background: #EAEDCA;
	cursor:pointer;
}

.center{
	text-align:center;
}
</style>


<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Evaluate Job  Performance Evaluation Form</h4>
					</header>
					<hr class="widget-separator"/>
					<div class="widget-body clearfix">
							
							<?php
							
							if(empty($row)){
							
									echo '<div class="row"><div class="alert alert-info"> <b>Record Not Found. Invalid Row ID</b></div></div>';	
									
							}else if($row['user_id']==get_user_id()){
								
									echo '<div class="row"><div class="alert alert-info"> <b>You cannot evaluate yourself.</b></div></div>';	
									
							}else{
								
							?>


							<div class="row">
							
								<div class="panel panel-info">
									  <div class="panel-heading">Performance Rating Definitions:</div>
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
								<b>Employee Name: <?php echo $row['fname'] . " ". $row['lname']; ?></b>
								</div>
						</div>
						
						
						<?php 
							if($error!='') echo $error;
							echo form_open('',array('data-toggle'=>'validator'));
						?>
						
						<input type="hidden" class="form-control" id="eid" name="eid" value="<?php echo $row['id'];?>"  required >
						
						<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $row['user_id'];?>"  required >
						
						<div class="row">
							
								<div class="col-md-10">	
									<div >
										<b>Evaluation Period: <?php echo $row['evaluation_period']; ?></b>
									</div>
								</div>
								<div class="col-md-2">
									<div style='float:right;'>
									<b>Date: <?php echo $row['evaluation_date'];?></b>
									</div>
								</div>
						</div> 
						<br>
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
										<th width='130px' class='center'>Score (Self)</th>
									    <th width='130px' class='center'>Evaluation Score</th>
									</tr>
								</thead>
																
	
								<tbody>
									<tr>
										<td>1.</td>
										<td>
											Knowledge of Work - Consider employee's skill level, knowledge and understanding of all phases of the job and those requiring improved skills and/or experience.
										</td>
										<td class='center'>										
											<?php echo $row['knowledge_work_self'];?>
										</td>
										<td class='center'>
										<input id="knowledge_work" name="knowledge_work" class="form-control number_spinner" type="number" value="1" min="1" max="5" />											
										</td>
										
									</tr>
									<tr>
										<td>2.</td>
										<td>
											Planning and Organizing - Consider how well the employee defines goals for personal performance; how well work tasks are organized and priorities established; and the amount of supervision required to achieve it.
										</td>
										
										<td class='center'>										
											<?php echo $row['planning_organizing_self'];?>
										</td>
										
										<td class='center'>
											
											<input id="planning_organizing" name="planning_organizing" class="form-control number_spinner" type="number" value="1" min="1" max="5" />											
										</td>
									</tr>
									
									<tr>
										<td>3.</td>
										<td>
											Customer Relations - Consider how well the employee interacts in dealing with internal staff, external customers and vendors; employee projects a courteous manner.
										</td>
										
										<td class='center'>										
											<?php echo $row['customer_relations_self'];?>
										</td>
										
										<td class='center'>
											<input id="customer_relations" name="customer_relations" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											
										</td>
										
									</tr>
									<tr>
										<td>4.</td>
										<td>
											Quality of Work - Consider the accuracy and thoroughness in completing work assignments. Consider the individual's ability to self-identify and correct errors. Take into consideration incomplete assignment.
										</td>
										<td class='center'>										
											<?php echo $row['quality_work_self'];?>
										</td>
										
										<td class='center'>
											
											<input id="quality_work" name="quality_work" class="form-control number_spinner" type="number" value="1" min="1" max="5" />											
										</td>
										
									</tr>
									<tr>
										<td>5.</td>
										<td>
											Quantity of Work - Consider the volume of work completed in relation to assigned responsibilities. Consider the ability to meet and stay on schedule and the proper use of work time.
										</td>
										
										<td class='center'>										
											<?php echo $row['quantity_work_self'];?>
										</td>
										
										<td class='center'>
											<input id="quantity_work" name="quantity_work" class="form-control number_spinner" type="number" value="1" min="1" max="5" />											
										</td>
										
									</tr>
									<tr>
										<td>6.</td>
										<td>
											Dependability - Consider how well employee complies with instructions and performs under unusual circumstances; consider record of attendance and punctuality.
										</td>
										
										<td class='center'>										
											<?php echo $row['dependability_self'];?>
										</td>
										
										<td class='center'>
											<input id="dependability" name="dependability" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											
										</td>
																				
									</tr>
									<tr>
										<td>7.</td>
										<td>
											Acceptance of Responsibility - Consider the manner in which the employee accepts new and varied work assignments, and assumes personal responsibility for completion.
										</td>
										
										<td class='center'>										
											<?php echo $row['responsibility_self'];?>
										</td>
										
										<td class='center'>
										<input id="responsibility" name="responsibility" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
										</td>
										
									</tr>
									<tr>
										<td>8.</td>
										<td>
											Self-Initiative - Consider how well employee demonstrates resourcefulness, independent thinking, and the extent to which employee seeks additional challenges and opportunities on their own.
										</td>
										
										<td class='center'>										
											<?php echo $row['self_initiative_self'];?>
										</td>
										
										<td class='center'>
											<input id="self_initiative" name="self_initiative" class="form-control number_spinner" type="number" value="1" min="1" max="5" />											
										</td>
										
									</tr>
									<tr>
										<td>9.</td>
										<td>
											Teamwork - Consider how well this individual gets along with fellow employees, respects the rights of other employees and shows a cooperative spirit.
										</td>
										
										<td class='center'>										
											<?php echo $row['teamwork_self'];?>
										</td>
										
										<td class='center'>
										<input id="teamwork" name="teamwork" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
										</td>
										
									</tr>
									<tr>
										<td>10.</td>
										<td>
											Safety - Consider this individual's work habits and attitudes as they apply to working safely. Consider their contribution to accident prevention, safety awareness and ability to are for equipment and keep workspace safe and tidy.
										</td>
																				
										<td class='center'>										
											<?php echo $row['safety_self'];?>
										</td>
										
										<td class='center'>
										<input id="safety" name="safety" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
																			
										</td>
										
									</tr>
									<tr>
										<td>11.</td>
										<td>
											Personal Appearance - Consider the employee's neatness and personal hygiene appropriate to position.
										</td>
										
										<td class='center'>										
											<?php echo $row['personal_appearance_self'];?>
										</td>
										
										<td class='center'>
										<input id="personal_appearance" name="personal_appearance" class="form-control number_spinner" type="number" value="1" min="1" max="5" /> 										
										</td>
									
									</tr>
									<tr>
										<td>12.</td>
										<td>
											Leadership - Measures effectiveness in accomplishing work assignments through subordinates; establishing challenging goals; delegating and coordinating effectively; promoting innovation and team effort.
										</td>
										
										<td class='center'>										
											<?php echo $row['leadership_self'];?>
										</td>
										
										<td class='center'>
											<input id="leadership" name="leadership" class="form-control number_spinner" type="number" value="1" min="1" max="5" /> 
											
										</td>
										
									</tr>
									<tr>
										<td>13.</td>
										<td>
											Communication - Measures effectiveness in listening to others, expressing ideas, both orally and in writing, and providing relevant and timely information to management, co-workers, subordinates and customers.
										</td>
										
										<td class='center'>										
											<?php echo $row['communication_self'];?>
										</td>
										
										<td class='center'>
											<input id="communication" name="communication" class="form-control number_spinner" type="number" value="1" min="1" max="5" />
											
										</td>
										
									</tr>
									<tr>
										<td>14.</td>
										<td>
											Decision Making/Problem Solving - Measures effectiveness in understanding problems and making timely, practical decisions.
										</td>
										
										<td class='center'>										
											<?php echo $row['problem_solving_self'];?>
										</td>
										
										<td class='center'>
											<input id="problem_solving" name="problem_solving" class="form-control number_spinner" type="number" value="1" min="1" max="5" />										
										</td>
										
									</tr>
																											
								</tbody>
							</table>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="comment">Employee Comments:</label>
								<br>
								<?php echo $row['comments_self'];?>
							</div>
						</div>
						
						<div class="col-md-12">	
							<div class="form-group">
							<b>B) Employee Strengths And Accomplishments:</b> <i>(Include those which are relevant during this evaluation period. This should be related to performance or behavioral aspects you appreciated in their performance.)</i>
							<br>
							<textarea class="form-control" rows="2" placeholder="Enter You Comments" id="employee_strengths" name='employee_strengths' required></textarea>
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
							<b>C) Performance Areas Which Need Improvement:</b>
							<br>
							<textarea class="form-control" rows="2" placeholder="Enter You Comments" id="improvement_areas" name='improvement_areas' required></textarea>
							</div>
						</div>
						
						<div class="col-md-12">	
							<div class="form-group">
							<b>D) Plan Of Action Towards Improvement:</b>
							<br>
							<textarea class="form-control" rows="2" placeholder="Enter You Comments" id="improvement_plan" name='improvement_plan' required></textarea>
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
							<b>E) Job Description Review</b> <i>(Please check the appropriate box)</i>
								<table>
									<tr>
										
										<td style="padding:3px 12px;">i) Employee job description has been reviewed during this evaluation and no changes have been made to the job description at this time.</td>
										<td width='150px' class='center'>
										<input type="radio" class='job_description_review' name='job_description_review' value="No" required>
										</td>
									</tr>
									<tr>
										
										<td style="padding:3px 12px;">ii) Employee job description has been reviewed during this evaluation and modifications have been proposed to the job description. The modified job description is attached to this evaluation.</td>
										<td width='150px' class='center'>
											<input type="radio" class='job_description_review' name='job_description_review' value="Yes" required>
										</td>
									</tr>
									<tr id='modified_job_div' style="display:none;">
										<td colspan=2 style="padding:3px 12px;">
											
												<b>iii) Modified job description:</b>
												<br>
												<textarea class="form-control" rows="2" placeholder="Enter Modified job description" id="modified_job_desc" name='modified_job_desc' ></textarea>
																				
										</td>
									</tr>
								</table>
							</div>
						</div>
						
						<div class="col-md-12">	
							<div class="form-group">
							<b>Evaluator Comments:</b>
							<br>
							<textarea class="form-control" rows="2" placeholder="Enter You Comments" id="evaluator_comments" name='evaluator_comments' required></textarea>
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
					
				<?php } ?>
					
			   </div>
		</div><!-- .row -->
	</section>

</div><!-- .wrap -->
