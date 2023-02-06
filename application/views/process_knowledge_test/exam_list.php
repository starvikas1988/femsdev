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
				<h4>Exam List</h4>
				<hr class="widget-separator">	
				<div class="common-top">
					<div class="filter-widget">
					<?php echo form_open('',array('data-toggle'=>'validator', 'id'=>'myform','enctype'=>"multipart/form-data",'onsubmit'=>'valiadteFunc();','method'=>'get')) ?>
						<div class="row">				
							<!--<div class="col-sm-3">
								<div class="form-group">
									<label>Exam Type</label><span style="color:#FF0000">*</span>
									<select id="examination_type" name="examination_type" class="form-control" required>
									    <option value="">Select Exam Type</option>
										<?php //foreach($examination_type_list as $token){	
										//if($token['id'] == $type_id){
										//	$selected="selected";
										//}else{
										//	$selected="";
										//}
										?>
										<option value="<?php //echo $token['id'];?>" <?php //echo $selected;?>><?php //echo $token['examination_type_name'];?></option>
										<?php //} ?>
										
									</select>
									
								</div>
							</div>-->
							<div class="col-sm-3">
								<div class="form-group">
									<label>Question Type</label><span style="color:#FF0000">*</span>
									<select id="question_type" name="question_type" class="form-control" required>
										<option value="">Select Question Type</option>
										<?php foreach($question_type_list as $token){ 
										if($token['id'] == $question_type_id){
											$selected="selected";
										}else{
											$selected="";
										}
										?>
										<option value="<?php echo $token['id']; ?>" <?php echo $selected;?>><?php echo $token['question_type_name']; ?></option>
										<?php }?>
										
									</select>
									
								</div>
							</div>				
						
							<div class="col-sm-12">
								<div class="form-group">
									<button type="submit" name="submit" value="submit" class="submit-btn">							
										Search
									</button>
								</div>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>			
		</div>
		
		<?php if(!empty($examination_list)){?>
		<div class="common-top">
			<div class="widget">
				<div class="widget-body no-padding">
					<div class="table-small data-widget table-bg">
						<table id="default-datatable" class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Exam Name</th>
									<th>Question Type</th>
									<th>Duration (min)</th>
									<th>Date of Creation</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($examination_list as $list){?>
								<tr>
									<td><?php echo $list['exam_name'];?></td>
									<td><?php echo $list['question_type_name'];?></td>
									<td><?php echo $list['examination_duration'];?></td>
									<td><?php echo $list['created_on'];?></td>
									<td>
										
										<a href="<?php echo base_url();?>process_knowledge_test/upload_question_set/<?php echo $list['id'];?>/add" data-toggle="modal" class="edit-btn">
											<i class="fa fa-hand-pointer-o" aria-hidden="true" title="Upload Set"></i>
										</a>
										<a href="<?php echo base_url();?>process_knowledge_test/view_exams/<?php echo $list['id'];?>/view" data-toggle="modal" class="edit-btn">
											<i class="fa fa-eye" aria-hidden="true" title="View Details"></i>
										</a>
									</td>
								</tr>
							<?php }?>
								
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

