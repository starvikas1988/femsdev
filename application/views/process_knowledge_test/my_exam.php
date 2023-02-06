<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>

<style>	
	.edit-btn-green {
		width:30px;
		height:30px;
		line-height:30px;
		border-radius:50%;
		background:#10c469;
		color:#fff;
		text-align:center;
		display:inline-block;
		cursor:pointer;
		transition:all 0.5s ease-in-out 0s;
}
	.edit-btn-green:hover {
		background:#0b8145;
		color:#fff;
	}
	.edit-btn-green:focus {
		background:#0b8145;
		color:#fff;
		outline:none;
		box-shadow:none;
	}
	.edit-btn-red {
		width:30px;
		height:30px;
		line-height:30px;
		border-radius:50%;
		background:#f00;
		color:#fff;
		text-align:center;
		display:inline-block;
		cursor:pointer;
		transition:all 0.5s ease-in-out 0s;
}
	.edit-btn-red:hover {
		background:#b50c0c;
		color:#fff;
	}
	.edit-btn-red:focus {
		background:#b50c0c;
		color:#fff;
		outline:none;
		box-shadow:none;
	}
</style>

<div class="wrap">
	<section class="app-content">
		<div class="widget">
			<div class="widget-body compute-widget">
				<h4>Assigned Exams</h4>
				<hr class="widget-separator">
				
			</div>			
		</div>
		<?php //print_r($assigned_exams);?>
		<div class="common-top">
			<div class="widget">
				<div class="widget-body no-padding">
					<div class="table-small table-bg">
						<table class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Exam Name</th>
									<th>Assigned Question Type</th>
									<th>Assigned On</th>
									<th>Total Marks</th>
									<th>Exam Status</th>
									
								</tr>
							</thead>
							<tbody>
								<?php 
								$count = 0;
								foreach($assigned_exams as $assigned_exam){?>
								<tr>
									<td><?php echo $assigned_exam['exam_name'];?></td>
									<td><?php echo $assigned_exam['question_assigned_type'];?></td>
									<td><?php echo $assigned_exam['created_on'];?></td>
									<td><?php if($assigned_exam['score'] != ""){ echo $assigned_exam['score'].'/';}?><?php echo $assigned_exam['total_score'];?></td>
									<td>
										<?php //if($exam_given[$i]['tot_exam'] == 0 && $exam_given[$i]['tot_user'] == 0 && $assigned_exam['status']==1){?>
										<?php if($assigned_exam['status']==1 && $assigned_exam['exam_given']=="No"){?>
										<a href="<?php echo base_url();?>process_knowledge_test/give_exam/<?php echo $assigned_exam['id'];?>" class="edit-btn-red" title="Take Exam">
											<i class="fa fa-file-text" aria-hidden="true"></i>
										</a>
										<?php }else if($assigned_exam['status']==0){
										?>
											<a href="#" class="edit-btn-red" title="Exam Expired">
											<i class="fa fa-refresh" aria-hidden="true"></i>
										</a>
										<?php
										}else if($assigned_exam['status']==1 && $assigned_exam['exam_given']=="Yes"){?>
											<a href="#" class="edit-btn-green" title="Exam Given">												
												<i class="fa fa-check" aria-hidden="true"></i>
											</a>
										<?php }?>
									</td>
								</tr>
								<?php 
								//$i++;
								}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		
	</section>
</div>

