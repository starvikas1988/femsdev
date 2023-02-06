<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<script>
function valiadteFunc(){
	if(document.getElementById('exam_name').value==""){
		alert("Please enter exam name.");
		document.getElementById('exam_name').focus();
		return false;
	}
	if(document.getElementById('examination_type_id').value==""){
		alert("Please select examination type.");
		return false;
	}
	if(document.getElementById('examination_duration').value==""){
		alert("Please select duration.");
		return false;
	}
	if(document.getElementById('question_type_id').value==""){
		alert("Please select question type.");
		return false;
	}
	if(document.getElementById('total_score').value==""){
		alert("Please enter total score.");
		document.getElementById('total_score').focus();
		return false;
	}
	
}
</script>

<?php 
//print_r($question_type_list);
?>
	<div class="wrap">
		<div class="repeatable">					
		   <div id="main-form">
			   <div class="child-group">
				<div class="widget">
					<div class="widget-body compute-widget">
						<div class="row">
							<div class="col-sm-6">
								<h4>Create Exam</h4>
								<?php if(!empty($message)){?>
								<h4><?php echo $message;?></h4>
								<?php } ?>
							</div>
							<div class="col-sm-6">
							</div>
						</div>
						<hr class="widget-separator">
					</div>
				<div class="widget-body">
					<div class="filter-widget">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<div class="exam-btn-widget">
										<div class="row">
											<div class="col-sm-2">
												<button type="button" id="exam-click" class="blue-btn1">
													Create Exam
												</button>
											</div>
											<div class="col-sm-2">
												<a href="<?php echo base_url();?>process_knowledge_test/sample_download" class="submit-btn"> Download Sample</a>
											</div>
										</div>
									</div>
									
																	
									<?php echo form_open('',array('data-toggle'=>'validator', 'id'=>'myform','enctype'=>"multipart/form-data")) ?>
									<!--start exam-->
									<div class="exam-widget">
										<div class="form-group">
											<label>Name of Exam</label><span style="color:#FF0000">*</span>
											<input type="text" class="form-control" id="exam_name" name="exam_name" onfocusout="checkExamName();" required>
										</div>
										<!--<div class="form-group">
											<label>Exam Type</label><span style="color:#FF0000">*</span>
											<select id="examination_type_id" name="examination_type_id" class="form-control" required>
											<option value="">Select Exam Type</option>
											<?php 
											foreach($examination_type_list as $token){
											?>
											<option value="<?php echo $token['id']; ?>"><?php echo $token['examination_type_name']; ?></option>
											<?php } ?>
										</select>
										</div>-->
										<div class="form-group">
											<label>Exam Duration<span style="color:#FF0000">*</span> (min)</label>
											<!--<select id="examination_duration" name="examination_duration" class="form-control" required>
											<option value="">Select Exam Duration</option>
											<option value="45">45</option>
											<option value="60">60</option>
											<option value="90">90</option>
											</select>-->
										<input type="number" class="form-control" id="examination_duration" name="examination_duration" min="0" data-maxlength="3" data-bind="value:replyNumber" required>
										</div>
										<div class="form-group" id="monthly_start_date_div">
											<label>Exam Start Date<span style="color:#FF0000">*</span></label>
											<input type='date' id="monthly_start_date" name="monthly_start_date" class="form-control" >
											
										</div>
										<div class="form-group" id="monthly_end_date_div">
											<label>Exam End Date<span style="color:#FF0000">*</span></label>
											<input type='date' id="monthly_end_date" name="monthly_end_date" class="form-control">
											
										</div>
										<div class="form-group">
											<label>Question Type</label><span style="color:#FF0000">*</span>
											<select id="question_type_id" name="question_type_id" class="form-control" required>
											<option value="">Select Question Type</option>
											<?php 
											foreach($question_type_list as $token){
											?>
											<option value="<?php echo $token['id']; ?>"><?php echo $token['question_type_name']; ?></option>
											<?php } ?>
											
											
											</select>
										</div>
										<div class="form-group">
											<label>Total Score</label><span style="color:#FF0000">*</span>
											<input type="number" class="form-control" id="total_score" name="total_score" min="0" data-maxlength="3" data-bind="value:replyNumber" required>
										</div>
										<div class="form-group">
											<button type="submit" name="submit" value="submit" class="blue-btn1" onclick='return valiadteFunc();'>
												Submit
											</button>
										</div>
									</div>
									</form>
									<!--end exam-->
									
								</div>
								
							</div>							
						</div>						
					  </div>
				  </div>
				  </div>
				  
				  <div class="base-group" style="display:none;">
					<div class="common-top">
						<div class="widget">
							<div class="widget-body">
								dssfdf
							</div>
						</div>
						</div>
					</div>
					
					
					
			   </div>
		   </div>
	</div>
	
	



<script>
	$(function() {
  $(".repeat").on('click', function(e) {
		var c = $('.base-group').clone();
    c.removeClass('base-group').css('display','block').addClass("child-group");
    $("#main-form").append(c);
  });
});

</script>
<script type="text/javascript">
	function checkExamName(){
		var exam_name = document.getElementById('exam_name').value;
		//alert(exam_name);
		 var root_path = "<?php echo base_url(); ?>";
		  var path = root_path+"process_knowledge_test/duplicate_examname/";
	      //alert(path);
	      var jquery = jQuery.noConflict();
		  jquery.ajax({
			type: "POST",
			url: path,
			data:{exam_name:exam_name},
		
			success: function(data){
				//alert(data);
				//console.log(data);
				var data = JSON.parse(data);
				if(data.error == 'true')
				{
					alert('Exam name already exists. Please use different name');
					document.getElementById('exam_name').value ="";
				}
				
			}
			
		  });
	}
		
	
</script>