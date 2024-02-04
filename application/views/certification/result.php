


<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Your Certification Result</h4>
								
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
										<th>Name</th>
										<th>Total Questions</th>
										<th>Total Answers</th>
										<th>Correct Answers</th>
										<th>Marks(%)</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i=1;
										foreach($get_user_result as $row){
											
										$tot_corr_ans=$row['tot_corr_ans'];
										$tot_answer=$row['tot_answer'];
										
										$percentage=round((($tot_corr_ans/$TotQuesDisplay)*100), 2);
										?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['user_name']; ?></td>
										<td><?php echo $TotQuesDisplay; ?></td>
										<td><?php echo $row['tot_answer']; ?></td>
										<td><?php echo $row['tot_corr_ans']; ?></td>
										<td><?php echo $percentage; ?></td>
									</tr>
									<?php 
										}
									?>
								</tbody>
							</table>
						</div>
						
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	