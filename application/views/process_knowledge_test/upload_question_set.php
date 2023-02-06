<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<script>
 function fileValidation() {
            var fileInput = 
                document.getElementById('set_file_name');
              
            var filePath = fileInput.value;
          
            // Allowing file type
            var allowedExtensions = 
                    /(\.csv)$/i;
              
            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type');
                fileInput.value = '';
                return false;
            } 
 }

function valiadteFunc(){
	if(document.getElementById('set_name').value==""){
		alert("Please enter set name.");
		document.getElementById('set_name').focus();
		return false;
	}
	
	if(document.getElementById('set_file_name').value==""){
		alert("Please select one csv file to upload.");
		return false;
	}
}

</script>
<?php 
//print_r($exam_info);
?>
	<div class="wrap">
		<div class="repeatable">					
		   <div id="main-form">
			   <div class="child-group">
				<div class="widget">
					<div class="widget-body compute-widget">
						<div class="row">
							<div class="col-sm-6">
								<h4>Upload Question Set</h4>
								<?php if(!empty($message)){?>
								<h6><font color="#FF0000"><?php echo $message;?></font></h6>
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
													Upload Set
												</button>
											</div>
											<div class="col-sm-2">
												<a href="<?php echo base_url();?>process_knowledge_test/sample_download" class="submit-btn"> Download Sample</a>
											</div>
										</div>
									</div>
									<!--<button type="button" id="exam-click" class="submit-btn">
										Upload Set
									</button>-->
									<!--<button type="button" class="blue-btn1">
										Upload Questions
									</button>-->
									<!--<button type="button" class="blue-btn2">
										Download Sample
									</button>-->
									<?php echo form_open('',array('data-toggle'=>'validator', 'id'=>'myform','enctype'=>"multipart/form-data")) ?>
									<!--start exam-->
									<input type="hidden" class="form-control" id="exam_id" name="exam_id" value="<?php echo $exam_id;?>">
									<input type="hidden" class="form-control" id="action" name="action" value="<?php echo $action;?>">
									<div class="exam-widget">
										<div class="form-group">
											<label>Set Name</label><span style="color:#FF0000">*</span>
											<input type="text" class="form-control" id="set_name" name="set_name" onfocusout="checkSetName(<?php echo $exam_id;?>);" required>
										</div>
										<div class="form-group">
											<label>Question Type</label>
											<input type="hidden" id="question_type_id" name="question_type_id" value="<?php echo $exam_info[0]['question_type_id'];?>">
											<select id="question_type" name="question_type" class="form-control" required disabled>
											<option value="">Select Question Type</option>
											<?php 
											foreach($question_type_list as $token){
												if($token['id'] ==  $exam_info[0]['question_type_id']){
												    $selected = $question_type_id;
												}else{
													$selected ="";
												}
											?>
											<option value="<?php echo $token['id']; ?>" selected=<?php echo $selected;?> readonly><?php echo $token['question_type_name']; ?></option>
											<?php } ?>
											
											
											</select>
										</div>
										<div class="form-group">
											<label>Upload Set File<span style="color:#FF0000">*</span> (Upload only.csv file)</label>
											<input type="file" class="form-control" id="set_file_name" name="set_file_name" onchange="return fileValidation()">
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
	function checkSetName(examId){
		var set_name = document.getElementById('set_name').value;
		//alert("set Name : "+set_name);
		//alert("exam id: "+examId);
		 var root_path = "<?php echo base_url(); ?>";
	     var path = root_path+"process_knowledge_test/duplicate_setname/";
	      //alert(path);
	      var jquery = jQuery.noConflict();
		  jquery.ajax({
			type: "POST",
			url: path,
			data:{exam_id:examId,set_name:set_name},
		
			success: function(data){
				//alert(data);
				//console.log(data);
				var data = JSON.parse(data);
				if(data.error == 'true')
				{
					alert('Set name already exists. Please use different name');
					document.getElementById('set_name').value ="";
				}
				
			}
			
		  });
	}
		
	
</script>