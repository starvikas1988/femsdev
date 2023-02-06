<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<style>
	.table-small {
		height:auto!important;
		overflow:inherit!important;
	}
</style>

<script>
function selectExamList()
{
	var examArr="";
	var x=document.getElementById("examList");
      for (var i = 0; i < x.options.length; i++) {
         if(x.options[i].selected ==true){
             // alert(x.options[i].value);
			 examArr = examArr+','+x.options[i].value; 
          }
      }
	document.getElementById('examArr').value = examArr;
}
function selectUserList()
{
	var userArr="";
	var x=document.getElementById("userList");
      for (var i = 0; i < x.options.length; i++) {
         if(x.options[i].selected ==true){
             // alert(x.options[i].value);
			 userArr = userArr+','+x.options[i].value; 
          }
      }
	document.getElementById('userArr').value = userArr;
}
</script>
<script>
function valiadteFunc(){
	if(document.getElementById('examList').value==""){
		alert("Please select one exam.");
		return false;
	}
	else if(document.getElementById('userList').value==""){
		alert("Please select one user.");
		return false;
	}
}
</script>
<?php 
//echo "<pre>";
//print_r($user_lists);

//exit;?>

<div class="wrap">
	<section class="app-content">
	
		<div class="widget">
			<div class="widget-body compute-widget">
				<h4>Exam List</h4>
				<hr class="widget-separator">	
				<div class="common-top">
					<div class="filter-widget">
					<?php echo form_open('',array('id'=>'myform','enctype'=>"multipart/form-data")) ?>
						<input type="hidden" name="examArr" id="examArr" value="">
						<input type="hidden" name="userArr" id="userArr" value="">
						<div class="row">				
							<div class="col-sm-3">
								<div class="form-group">
									<label>Exam Name</label>
									<select id="examList" name="examList" class="form-control multiple-select" multiple="multiple" onchange="selectExamList();" required>
										<?php foreach($exam_lists as $token){	?>
										<option value="<?php echo $token['id'];?>" ><?php echo $token['exam_name'];?></option>
										<?php } ?>
										
									</select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>User List</label>
									<select id="userList" name="userList" class="form-control multiple-select" multiple="multiple" onchange="selectUserList();" required>
										<?php foreach($user_lists as $user){	?>
										<option value="<?php echo $user['id'];?>" ><?php echo $user['fname']." ".$user['lname'];?></option>
										<?php } ?>
										
									</select>
									
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Status</label>
									<select id="exam_status" name="exam_status" class="form-control">
										<option value="">Select Option</option>
										<option value="exam_given">Exam Given</option>
										<option value="exam_pending">Exam Pending</option>
										<option value="exam_expired">Exam Expired</option>
									</select>
									
								</div>
							</div>		
						
							<div class="col-sm-12">
								<div class="form-group">
									<button type="submit" name="submit" value="submit" class="submit-btn" onclick="return valiadteFunc();">							
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
		
		
		<?php //print_r($assigned_exams);?>
		<?php if(!empty($assigned_exams)){?>
		<div class="common-top">
			<div class="widget">
				<div class="widget-body no-padding">
					<div class="table-small data-widget table-bg">
						<table id="default-datatable" class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Exam Name</th>
									<th>Assigned User</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$i=0;
							foreach($assigned_exams as $list){?>
								<tr>
									<td><?php echo $list['exam_name'];?></td>
									<td> <?php echo $list['fname']. " ".$list['lname'];?></td>
									
									<td>
										
										<?php if($list['status']==1 && $list['exam_given']=='No'){?>
										<a href="" class="edit-btn-red" title="Pending Exam">
											<i class="fa fa-file-text" aria-hidden="true"></i>
										</a>
										<?php }else if($list['status']==0){
										?>
											<a href="" class="edit-btn-red" title="Re-assign Exam" onclick="reassignExam(<?php echo $list['exam_id'];?>,<?php echo $list['user_id'];?>);">
											<i class="fa fa-refresh" aria-hidden="true"></i>
										</a>
										<?php
										}else if($list['status']==1 && $list['exam_given']=='Yes'){?>
											<a href="" class="edit-btn-green" title="Exam Given">												
												<i class="fa fa-check" aria-hidden="true"></i>
											</a>
										<?php }?>
									</td>
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
									<th>Assigned User</th>
									<th>Status</th>
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

<script>
function reassignExam(exam_id,user_id){
	var root_path = "<?php echo base_url(); ?>";
	 var path = root_path+"process_knowledge_test/reassign_exam";
	 var exam_id = exam_id;
	 var assigned_user_id = user_id;
	 $.ajax({
			type: "POST",
			url: path,
			data:{exam_id:exam_id,assigned_user_id:assigned_user_id},
			
			success: function(data){
				//alert(data);
				window.location.href=root_path+"process_knowledge_test/manage_assigned_exams";
	
			}
		});
}
</script> 
