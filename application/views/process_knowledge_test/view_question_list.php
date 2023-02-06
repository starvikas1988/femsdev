<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<style>
	.table-small {
		height:auto!important;
		overflow:inherit!important;
	}
</style>
<script>
function valiadteFunc(){
	if(document.getElementById('examination_type').value==""){
		alert("Please select one exam type.");
	}
	if(document.getElementById('question_type').value==""){
		alert("Please select one question type.");
	}
}
</script>
<div class="wrap">
	<section class="app-content">
		<div class="widget">
			<div class="widget-body compute-widget">
				<h4>Question List</h4>
				
				<div class="common-top">
					<div class="filter-widget">
					
						<div class="row">
							
									
						    <div class="widget-body compute-widget">
								
								<hr class="widget-separator">
								<div class="pull-right">
									<h6><a href="<?php echo base_url();?>process_knowledge_test/exam_list">Go Back</a></h6>
								</div>	
							</div>	
						
						</div>
					
					</div>
				</div>
			</div>			
		</div>
		
		<?php if(!empty($question_list)){?>
		<div class="common-top">
			<div class="widget">
				<div class="widget-body no-padding">
					<div class="table-small data-widget table-bg">
						<table id="default-datatable" class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>SL</th>
									<th>Question </th>
									<th>Set Name</th>
									<th>Exam Name</th>
									
									<th>Date Added</th>								
								</tr>
							</thead>
							<tbody>
							<?php 
							$i=1;
							foreach($question_list as $list){?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $list['question'];?></td>
									<td><?php echo $list['set_name'];?></td>
									<td><?php echo $list['exam_name'];?></td>
									
									<td><?php echo date('Y-m-d', strtotime($list['created_on']));?></td>
								</tr>
							<?php 
							$i++;
							}?>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<?php }else{?>
		<div class="common-top">
			<div class="widget">
				<div class="widget-body no-padding">
					<div class="table-small table-bg">
						<table class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Exam Name</th>
									<th>Exam Type</th>
									<th>Question Type</th>
									<th>Duration</th>
									<th>Date of Creation</th>
									<th>Action</th>
									
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan=6 align="centre">No result found.</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php }?>
	</section>
</div>

