<style>
.makebold{
	font-weight:600;
	color:#000;
}
</style>
<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Feedback Details by <?php echo $assigned_by_name; ?> - (<?php echo $performancedata['year_quarter']; ?>)</h4>
					</header>
					
					<hr class="widget-separator">
					<div class="widget-body clearfix">
						<div class="row">
							<div class="col-md-6">
								<p>Who do you directly report to? Choose your STL's/TL's/SME's name.</p>
								<h1><?php echo $assigned_to_name; ?></h1>
								<hr class="widget-separator">
								<p>Account/Department</p>
								<h1><?php echo $department_name; ?></h1>
							</div>
							<div class="col-md-6">
								<div class="widget">
									<header class="widget-header">
										<h4 class="widget-title"> Performance Review Summary </h4>
									</header>
									<hr class="widget-separator">
									<div class="widget-body clearfix">
										<table class="table table-condensed">
											<tbody>
												<tr>
													<th>Performance Area</th>
													<th style="text-align: right;">%</th>
												</tr>
												<tr>
													<td>Leadership (20%)</td>
													<td align="right"><span class="badge bg-danger" id="leadership_performance"><?php echo $performancedata['leadership_performance']; ?>%</span></td>
												</tr>
												<tr>
													<td>Performance Management &amp; Knowledge of Work (20%)</td>
													<td align="right"><span class="badge bg-danger" id="work_knowledge_performance"><?php echo $performancedata['work_knowledge_performance']; ?>%</span></td>
												</tr>
												<tr>
													<td>Decision Making &amp; Problem Solving (20%)</td>
													<td align="right"><span class="badge bg-danger" id="decision_making_performance"><?php echo $performancedata['decision_making_performance']; ?>%</span></td>
												</tr>
												<tr>
													<td>Communication (20%)</td>
													<td align="right"><span class="badge bg-danger" id="communication_performance"><?php echo $performancedata['communication_performance']; ?>%</span></td>
												</tr>
												<tr>
													<td>Change, Crisis &amp; Improvement Management (20%)</td>
													<td align="right"><span class="badge bg-danger" id="crisis_performance"><?php echo $performancedata['crisis_performance']; ?>%</span></td>
												</tr>
												<tr>
													<td>Overall Grade</td>
													<td align="right"><span class="badge bg-success" id="overall_performance"><?php echo $performancedata['overall_performance']; ?>%</span></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title text-center"> Please rate your STL's/TL's/SME's performance based on the point scale below. </h4>
					</header>
					<hr class="widget-separator">
					<div class="widget-body clearfix">
						<table class="table table-condensed" style="margin:10px 0px;">
							<tbody>
								<tr>
									<td>Outstanding (performance&nbsp;is consistently superior)</td>
									<td align="right">5</td>
								</tr>
								<tr>
									<td>Exceeds Expectations (performance&nbsp;is routinely above job requirements)</td>
									<td align="right">4</td>
								</tr>
								<tr>
									<td>Meets Expectations (performance&nbsp;is regularly competent and dependable)</td>
									<td align="right">3</td>
								</tr>
								<tr>
									<td>Below Expectations (performance&nbsp;failed to meet job requirements on frequent basis)</td>
									<td align="right">2</td>
								</tr>
								<tr>
									<td>Unsatisfactory (performance&nbsp;is consistently unacceptable)</td>
<!--                                                    <td>
										<div class="progress progress-xs">
											<div class="progress-bar progress-bar-danger" style="width: 55%"></div>
										</div>
									</td>-->
									<td align="right">1</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
			<input type='hidden' name='location_id' id='location_id' value='<?php echo get_user_office_id();?>' />
			<div class="row">
				<div class="col-md-6">
					<div class="widget">
						<header class="widget-header">
							<h4 class="widget-title text-center">Leadership (20%)</h4>
						</header>
						<hr class="widget-separator">
						<div class="widget-body clearfix">
							<table class="table table-condensed">
								<tbody>
									<tr>
										<td>1. Does your Direct Head bring out the best in you?</td>
										<td align="right" class="makebold">
											<?php echo $leadership[0]; ?>
										</td>
									</tr>
									<tr>
										<td>2.  Does your Direct Head take accountability of his/her actions?</td>
										<td align="right" class="makebold">
											<?php echo $leadership[1]; ?>
										</td>
									</tr>
									<tr>
										<td>3.  Is your Direct Head open to feedback and constructive criticism?</td>
										<td align="right" class="makebold">
											<?php echo $leadership[2]; ?>
										</td>
									</tr>
									<tr>
										<td>4.  Do you trust your Direct Head?</td>
										<td align="right" class="makebold">
											<?php echo $leadership[3]; ?>
										</td>
									</tr>
									<tr>
										<td>5.  Do you feel comfortable working with your Direct Head?</td>
										<td align="right" class="makebold">
											<?php echo $leadership[4]; ?>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="text-center">
								<b>Cite Incidents/Specific scenarios to elaborate feedback:</b>
							</div>
							<textarea class="form-control" style="margin: 20px 0px;" name="leadership_comment" readonly><?php echo $performancedata['leadership_comment']; ?></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="widget">
						<header class="widget-header">
							<h4 class="widget-title text-center">Performance Management & Knowledge of Work (20%)</h4>
						</header>
						<hr class="widget-separator">
						<div class="widget-body clearfix">
							<table class="table table-condensed">
								<tbody>
									<tr>
										<td>1. Does your Direct Head define clear performance objectives/goals, KPIs, and standards in the Program/Department?</td>
										<td align="right" class="makebold">
											<?php echo $work_knowledge[0]; ?>
										</td>
									</tr>
									<tr>
										<td>2. Does your Direct Head  provide relevant and fair learning and development opportunities through coaching, one-on-one feedback and/or team huddles?</td>
										<td align="right" class="makebold">
											<?php echo $work_knowledge[1]; ?>
										</td>
									</tr>
									<tr>
										<td>3. Does your Direct Head recognize and reward strong individual and team performance?</td>
										<td align="right" class="makebold">
											<?php echo $work_knowledge[2]; ?>
										</td>
									</tr>
									<tr>
										<td>4. Is your Direct Head knowledgeable of internal Fusion BPO Services Standard Operating procedures,  processes, and guidelines, Code of Conduct, & organizational structure?</td>
										<td align="right" class="makebold">
											<?php echo $work_knowledge[3]; ?>
										</td>
									</tr>
									<tr>
										<td>5. Is your Direct Head knowledgeable of Account-related and/or Departmental-specific Standard Operating Processes, procedures and guidelines, Code of Conduct, & organizational structure?</td>
										<td align="right" class="makebold">
											<?php echo $work_knowledge[4]; ?>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="text-center">
								<b>Cite Incidents/Specific scenarios to elaborate feedback:</b>
							</div>
							<textarea class="form-control" style="margin: 20px 0px;" name="work_knowledge_comment" readonly><?php echo $performancedata['work_knowledge_comment']; ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="widget">
						<header class="widget-header">
							<h4 class="widget-title text-center">Decision Making & Problem Solving (20%)</h4>
						</header>
						<hr class="widget-separator">
						<div class="widget-body clearfix">
							<table class="table table-condensed">
								<tbody>
									<tr>
										<td>1. Does your Direct Head effectively identify root causes and rule out solutions to defects, problems, issues, and concerns, in order to ensure non-recurrence?</td>
										<td align="right" class="makebold">
											<?php echo $decision_making[0]; ?>
										</td>
									</tr>
									<tr>
										<td>2.  Does your Direct Head make sound, fair, timely, and rational decisions/judgment based on data, facts, and objectives?</td>
										<td align="right" class="makebold">
											<?php echo $decision_making[1]; ?>
										</td>
									</tr>
									<tr>
										<td>3.  Does your Direct Head impose urgency/deadlines based on realistic goals?</td>
										<td align="right" class="makebold">
											<?php echo $decision_making[2]; ?>
										</td>
									</tr>
									<tr>
										<td>4.  Does your Direct Head properly guide/walk you through the process of basic troubleshooting?</td>
										<td align="right" class="makebold">
											<?php echo $decision_making[3]; ?>
										</td>
									</tr>
									<tr>
										<td>5.  Does your Direct Head share the accountability with you on strategic planning, process developments, and agent statuses?</td>
										<td align="right" class="makebold">
											<?php echo $decision_making[4]; ?>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="text-center">
								<b>Cite Incidents/Specific scenarios to elaborate feedback:</b>
							</div>
							<textarea class="form-control" style="margin: 20px 0px;" name="decision_making_comment" readonly><?php echo $performancedata['decision_making_comment']; ?></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="widget">
						<header class="widget-header">
							<h4 class="widget-title text-center">Communication (20%)</h4>
						</header>
						<hr class="widget-separator">
						<div class="widget-body clearfix">
							 <table class="table table-condensed">
								<tbody>
									<tr>
										<td>1. If you need help on a concern, would you feel most comfortable asking help from your Direct Head?</td>
										<td align="right" class="makebold">
											<?php echo $communication[0]; ?>
										</td>
									</tr>
									<tr>
										<td>2. Does your Direct Head express ideas, both orally and in writing, effectively and clearly?</td>
										<td align="right" class="makebold">
											<?php echo $communication[1]; ?>
										</td>
									</tr>
									<tr>
										<td>3.  Does your Direct Head properly and effectively manage expectations prior to taking actions?</td>
										<td align="right" class="makebold">
											<?php echo $communication[2]; ?>
										</td>
									</tr>
									<tr>
										<td>4. Is your Direct Head transparent in providing feedback?</td>
										<td align="right" class="makebold">
											<?php echo $communication[3]; ?>
										</td>
									</tr>
									<tr>
										<td>5. Does your Direct Head regularly conduct weekly team meetings, huddles, and one-on-one sessions with you?</td>
										<td align="right" class="makebold">
											<?php echo $communication[4]; ?>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="text-center">
								<b>Cite Incidents/Specific scenarios to elaborate feedback:</b>
							</div>
							<textarea class="form-control" style="margin: 20px 0px;" name="communication_comment" readonly><?php echo $performancedata['communication_comment']; ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="widget">
						<header class="widget-header">
							<h4 class="widget-title text-center">Change, Crisis & Improvement Management (20%)</h4>
						</header>
						<hr class="widget-separator">
						<div class="widget-body clearfix">
							<table class="table table-condensed">
								<tbody>
									<tr>
										<td>1.  Does your Direct Head initiate change in an effective and positive manner?</td>
										<td align="right" class="makebold">
											<?php echo $crisis[0]; ?>
										</td>
									</tr>
									<tr>
										<td>2. Are changes/improvements in your Account/Department properly documented and executed with minimal negative impact?</td>
										<td align="right" class="makebold">
											<?php echo $crisis[1]; ?>
										</td>
									</tr>
									<tr>
										<td>3.  Does your Direct Head define and implement change/improvements based on facts, reasonable goals, team feedback, and data?</td>
										<td align="right" class="makebold">
											<?php echo $crisis[2]; ?>
										</td>
									</tr>
									<tr>
										<td>4.  Does your Direct Head sustain the change through follow-through by studying the actual results and comparing them against expected results?</td>
										<td align="right" class="makebold">
											<?php echo $crisis[3]; ?>
										</td>
									</tr>
									<tr>
										<td>5.  Does your Direct Head display a professional and composed demeanor in times of crisis?</td>
										<td align="right" class="makebold">
											<?php echo $crisis[4]; ?>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="text-center">
								<b>Cite Incidents/Specific scenarios to elaborate feedback:</b>
							</div>
							<textarea class="form-control" style="margin: 20px 0px;" name="crisis_comment" readonly><?php echo $performancedata['crisis_comment']; ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="widget">
						<hr class="widget-separator">
						<div class="widget-body clearfix">
							<div class="row">
								<div class="col-md-6">
									<b>Overall, are you a happy and satisfied Fusion BPO Services employee?</b>
									<br/><span class="makebold"><?php echo $performancedata['overall']; ?></span>
								</div>
								<div class="col-md-6">
									<b>COMMENTS</b>
									<textarea class="form-control" style="margin: 20px 0px;" name="other_comments" readonly><?php echo $performancedata['other_comments']; ?></textarea>
								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	