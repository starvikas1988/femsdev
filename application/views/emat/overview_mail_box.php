					<div class="col-sm-6">
						<div class="job-detail">
							<div class="body-widget">
								<h2 class="small-title">Overall <?php echo empty($date_filter) ? "Today" : ""; ?></h2>
							</div>
							<div class="table-widget">
								<table class="table table-bordered table-striped">
								<?php
								//$resultFoundData = $ematCounters;
								$resultFoundData = $dashboardCounters;
								?>
									<tbody>
									  <tr>
										<td>Recieved</td>
										<td><?php echo $resultFoundData['total']; ?></td>
										<td>Complete</td>
										<td><?php echo $resultFoundData['completed']; ?></td>
									  </tr>
									  <tr>
										<td>Backlog</td>
										<td><?php echo $resultFoundData['pending']; ?></td>
										<td>Passed</td>
										<td><?php echo $resultFoundData['passed']; ?></td>
									  </tr>
									  <tr>
										<td>Duplicate</td>
										<td><?php echo $resultFoundData['duplicate']; ?></td>
										<td>Unassigned</td>
										<td><?php echo $resultFoundData['unassigned']; ?></td>
									  </tr>
									  <tr>
										<td>Within SLA</td>
										<td><?php echo $resultFoundData['pending']; ?></td>
										<td>SLA Breached</td>
										<td>0</td>
									  </tr>
									  <tr>
										<td>AHT</td>
										<td><?php echo $resultFoundData['aht']; ?></td>
									  </tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>