<link href="<?php echo base_url(); ?>assets/css/chosen.min.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>assets/js/chosen.jquery.min.js"></script>


<script>
	$("#feedback_reason").chosen();
	$("#agent_id").select2();
	
	$("#agent_name").chosen();
</script>


<script>
$(document).ready(function(){
	
	
		$(function(){
			$("#chat_date").datepicker();
			$("#from_date").datepicker();
			$("#to_date").datepicker();
			$("#review_date").datepicker();
			$("#mgnt_review_date").datepicker();
			$("#feedback_date").datepicker();
			$("#coach_date").datepicker();
		 });
	
	
	var a=0, b=0, c=0, d=0, total;
	
	function get_total()
	{
		return a+b+c+d;
	}
	
	$('#critical_error').on('change', function() {
		if(this.value === "yes"){
			a=0;
			
			$("#rel_critical_error").show();
 
				$('#rel_critical_error').on('change', function() {
					if(this.value === "agent_related"){
						a=0;
						////$("#pqr1").show();
						//$("#agent_critical").show();
						$("#demo").show();
						$("#demo1").hide();
						$("#demo1").prop( "disabled", true );
						$("#demo").prop( "disabled", false );
						//$("#nonagent_critical").css({"display":"none"});
						//$("#agent_critical").removeAttr('style');						
						//$("#pqr2").hide();
						//$("#nonagent_critical").hide();
						$("#agent_critical").chosen();
						//console.log(a);
						total=get_total();
					document.getElementById("overall_score").value= total;
					}else{
						a=50;
						//$("#agent_critical").css({"display":"none"});	
						//$("#nonagent_critical").removeAttr('style');
						//$("#pqr2").show();
						//$("#nonagent_critical").show();
					/*  $("#agent_critical").removeAttr("multiple"); */		
						$("#demo1").show();
						$("#demo").hide();
						$("#demo").prop( "disabled", true );
						$("#demo1").prop( "disabled", false );						
						///$("#pqr1").hide();
						//$("#agent_critical").hide();
						$("#nonagent_critical").chosen();
						//console.log(a);
						total=get_total();
						document.getElementById("overall_score").value= total;
					}
					
				});
			$("#rel_critical_error,#demo,#demo1").prop( "disabled", false );	
			//console.log("a:", a);
		} else {
			a=50;
			$("#rel_critical_error,#demo,#demo1").hide();	
			$("#rel_critical_error,#demo,#demo1").prop( "disabled", true );	
			total=get_total();
			/* console.log("a:", a);
			document.getElementById("overall_score").value= total; */
		}
		total=get_total();
		document.getElementById("overall_score").value= total;
	});
	$('#critical_error').on('change', function(){
		if(this.value === "yes"){
			$("#abc1").show();
		}else{
			$("#abc1").hide();
		}
	});
	
	$('#non_critical_error').on('change', function() {
		if(this.value === "no"){
			b=20;
			$("#non_critical_reason").remove();
			$("#non_critical_reason").removeAttr("required");
			$("#non_critical_reason").removeAttr("multiple");
			$("#demo3").hide();
		} else {
			b=0;
			$("#non_critical_reason").removeAttr("style", "display:none")
			$("#non_critical_reason").attr("required", "true");
			$("#demo3").show();
			$("#non_critical_reason").chosen();
		}
		total=get_total();
		document.getElementById("overall_score").value= total;
	});
	$('#non_critical_error').on('change', function(){
		if(this.value === "yes"){
			$("#abc2").show();
		}else{
			$("#abc2").hide();
		}
	});
	
	$('#busi_critical').on('change', function() {
		if(this.value === "yes"){
			c=0;
			$("#busi_critical_reason").show();
			$("#busi_critical_reason").attr("required", "true");
			$("#demo4").show();
			$("#busi_critical_reason").chosen();
			
		} else {
			c=30;
			$("#busi_critical_reason").hide();
			$("#busi_critical_reason").remove();
			$("#busi_critical_reason").removeAttr("required");
			$("#busi_critical_reason").removeAttr("multiple");
			$("#demo4").hide();
		}
		total=get_total();
		document.getElementById("overall_score").value= total;
	});
	
	$('#busi_critical').on('change', function(){
		if(this.value === "yes"){
			$("#abc3").show();
		}else{
			$("#abc3").hide();
		}
	});
	
	/*$('#critical_accuracy').on('change', function() {
		if(this.value === "yes"){
			d=0;
			$("#critical_accuracy_reason").show();
			$("#critical_accuracy_reason").ttr("required", "true");
		} else {
			d=10;
			$("#critical_accuracy_reason").hide();
			$("#critical_accuracy_reason").removeAttr("required");
		}
		total=get_total();
		document.getElementById("overall_score").value= total;
	});
	$('#critical_accuracy').on('change', function(){
		if(this.value === "yes"){
			$("#abc5").show();
		}else{
			$("#abc5").hide();
		}
	}); */
	
	$('#follow_wiki').on('change', function(){
		if(this.value === "no"){
			$("#wiki_link").show();
			$("#wiki_link_text").hide();
			$("#wiki_link_text").prop( "disabled", true );	
			$("#wiki_link").attr("required", "true");
			$("#abc4").show();
			$("#abc5").hide();
		} else {
			$('#wiki_link').hide();
			$('#wiki_link').prop( "disabled", true );	
			$("#wiki_link_text").show();
			$("#wiki_link").removeAttr("required");
			$("#abc4").hide();
			$("#abc5").show();
		}
	});
	/* $('#follow_wiki').on('change', function(){
		if(this.value === "yes"){
			$("#abc4").hide();
			$("#abc5").show();
		}else{
			$("#abc4").show();
			$("#abc5").hide();
		}
	}); */
	
	$('#was_critical_fail').on('change' , function(){
		if(this.value === "yes"){
			//$("$overall_score").show();
			document.getElementById("overall_score").value= 0;
		}else{
			//$("$overall_score").show();
			document.getElementById("overall_score").value=total;
		}	
	});
	
	$('#mishandled').on('change', function(){
		if(this.value === "no"){
			$("#category").hide();
			$("#sub_category").hide();
			$("#category").removeAttr("required");
			$("#sub_category").removeAttr("required");
		}else{
			$("#category").show();
			$("#sub_category").show();
			$("#category").attr("required", "true");
			$("#sub_category").attr("required", "true");
		}	
	})
	$('#mishandled').on('change', function(){
		if(this.value === "no"){
			$("#xyz1").hide();
			$("#xyz2").hide();
		}else{
			$("#xyz1").show();
			$("#xyz2").show();
		}	
	})
	
	$('#correct_concession').on('change', function(){
		if(this.value === "too high" || this.value === "too low"){
			$("#concession_amount").show();
			$("#correct_concession_amount").show()
			$("#concession_amount").attr("required", "true");
			$("#correct_concession_amount").attr("required", "true");
		}else{
			$("#concession_amount").hide();
			$("#correct_concession_amount").hide()
			$("#concession_amount").removeAttr("required");
			$("#correct_concession_amount").removeAttr("required");
		}
	})
	$('#correct_concession').on('change', function(){
		if(this.value === "too high" || this.value === "too low"){
			$("#xyz3").show();
			$("#xyz4").show()
		}else{
			$("#xyz3").hide();
			$("#xyz4").hide()
		}
	})
});

</script> 

<script>
$(document).ready(function(){
	var a=0,b=0,c=0,d=0,e=0,f=0,n=0;
	
		$('#preparation').on("change",function(){
			 a =parseInt($('#preparation option:selected').text());
			 n = ((a+b+c+d+e+f)/30)*100;			
			 $('#step_score').val(n.toFixed(2));
			 
		});
			
		$('#greeting').on("change",function(){
			 b = parseInt($('#greeting option:selected').text());
			 n = ((a+b+c+d+e+f) / 30)*100;			
			 $('#step_score').val(n.toFixed(2));
		});
			
		$('#owndership').on("change",function(){
			 c = parseInt($('#owndership option:selected').text());
			 n = ((a+b+c+d+e+f) / 30)*100;			
			 $('#step_score').val(n.toFixed(2));
		});
			
		$('#solving_problem').on("change",function(){
			 d = parseInt($('#solving_problem option:selected').text());
			 n = ((a+b+c+d+e+f) / 30)*100;			
			 $('#step_score').val(n.toFixed(2));
		});
			
		$('#start_wrapping').on("change",function(){
			 e = parseInt($('#start_wrapping option:selected').text());
			 n = ((a+b+c+d+e+f) / 30)*100;			
			 $('#step_score').val(n.toFixed(2));
		});
			
		$('#end_possitive_note').on("change",function(){
			  f = parseInt($('#end_possitive_note option:selected').text());
			 n = ((a+b+c+d+e+f) / 30)*100;			
			 $('#step_score').val(n.toFixed(2));
		});
		
		 
});	
</script>	

<script>

 $(document).ready(function(){
  
   $( "#reason_for_chat" ).on('change' , function() {
	  
	var pid = this.value;
	if(pid=="") alert("Please Select Primary Reason for chat")
	var URL='<?php echo base_url();?>qa_grubhub/getSecondaryReasonList';
  
	//alert(URL+"?pid="+pid);
	
	$.ajax({
	   type: 'POST',    
	   url:URL,
	   data:'pid='+pid,
	   success: function(pList){
		   //alert(pList);
			var json_obj = $.parseJSON(pList);//parse JSON
			
			$('#reason_for_chat_s').empty();
			$('#reason_for_chat_s').append($('<option></option>').val('').html('-- Select --'));
					
			for (var i in json_obj) $('#reason_for_chat_s').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].description));
									
		},
		error: function(){	
			alert('Fail!');
		}
		
	  });
	  
  });
 
 });
 </script>
 
 <script>
 $(document).ready(function(){
  
   $( "#category" ).on('change' , function() {
	  
	var cid = this.value;
	if(cid=="") alert("Please Select Category")
	var URL='<?php echo base_url();?>qa_grubhub/getSubcategory';
  
	
	$.ajax({
	   type: 'POST',    
	   url:URL,
	   data:'cid='+cid,
	   success: function(cList){
			
			var json_obj = $.parseJSON(cList);//parse JSON
			
			$('#sub_category').empty();
			$('#sub_category').append($('<option></option>').val('').html('-- Select --'));
					
			for (var i in json_obj) $('#sub_category').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].description));
									
		},
		error: function(){	
			alert('Fail!');
		}
		
	  });
	  
  });
 
 });
 </script>
 
 <script>
	$(document).ready(function(){
		$( "#agent_id" ).on('change' , function() {
			
			var aid = this.value;
			if(aid=="") alert("Please Select Agent")
			var URL='<?php echo base_url();?>qa_grubhub/getTLname';
			
			//alert(URL+"?aid="+aid);
		
			$.ajax({
				type: 'POST',    
				url:URL,
				data:'aid='+aid,
				success: function(aList){
					
				//alert(aList);
				
				var json_obj = $.parseJSON(aList);//parse JSON
			
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));
					
				for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				
				},
				error: function(){	
					alert('Fail!');
				}
			});
			
		});
	});	
 </script>
 
 
 <script>
	$(document).ready(function(){
		$( "#agent_id" ).on('change' , function() {
			
			var aid = this.value;
			if(aid=="") alert("Please Select Agent")
			var URL='<?php echo base_url();?>qa_grubhub/getOfficeName';
			
			//alert(URL+"?aid="+aid);
		
			$.ajax({
				type: 'POST',    
				url:URL,
				data:'aid='+aid,
				success: function(aList){
					
				//alert(aList);
				
				var json_obj = $.parseJSON(aList);//parse JSON
			
				$('#office_name').empty();
				$('#office_name').append($('#office_name').val(''));
					
				for (var i in json_obj) $('#office_name').append($('#office_name').val(json_obj[i].office_name));
				
				for (var i in json_obj) $('#off_id').append($('#off_id').val(json_obj[i].office_id));
				
				},
				error: function(){	
					alert('Fail!');
				}
			});
			
		});
	});	
 </script>
 
 
 
 <!------------------------------------------------------------------------------------------------------------>
 <!------------------------- KPI Feedback JS Part ------------------------------------------------------------->
 <!------------------------------------------------------------------------------------------------------------>
 
<script>
	$(document).ready(function(){
		$( "#agent_name" ).on('change' , function() {
			
			var str='';
			var aid;
			var result=[];
			aid = $("#form_new_user").serialize();
			//alert(aid);
			$('#tl_name1').empty();
			
			if(aid=="") alert("Please Select Agent")
			var URL='<?php echo base_url();?>qa_grubhub/get_TL_name';
			
			
			
			//alert(URL+"?aid="+aid);
		
			$.ajax({
				type: 'POST',    
				url:URL,
				data:aid,
				success: function(aList){
					
				//alert(aList);
				
					var json_obj = $.parseJSON(aList);//parse JSON
					
					for (var i in json_obj){ 
						
						$('#tl_name1').append((json_obj[i].tl_name) +"</br>");
							
							if(str!= ''){
							   str = str +","+ json_obj[i].assigned_to ; 
						    }else{
								str = str + json_obj[i].assigned_to ; 
						    } 
							
					} 
					
					$('#tl_name6').val(str); 
				
				},
				error: function(){	
					alert('Fail!');
				}
			});
			
		
			
		});
	});	
</script>

<!-- file upload validation start -->
	<script>
		$(document).ready(function(){
			$('INPUT[type="file"]').change(function () {
				var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
					case 'doc':
					case 'docx':
					case 'pdf':
						$('#uploadButton').attr('disabled', false);
						break;
					default:
						alert('This is not an allowed file type.');
						this.value = '';
				}
			});
		});	
	</script>
	
	<script>
		function validate() {
			$("#file_error").html("");
			$(".demoInputBox").css("border-color","#F0F0F0");
			var file_size = $('#kpi_attached_file')[0].files[0].size;
			if(file_size>1048576) {
				$("#file_error").html("File size is greater than 1MB");
				$(".demoInputBox").css("border-color","#FF0000");
				return false;
			} 
			return true;
		}
	</script>
<!-- file upload validation end --> 
 
 <script>
	$(document).ready(function(){
		$("#button1").click(function(){
			alert('Are you sure to submit form');
		});
	});	
 </script>
 
 
 
 
 <!------------------------------------------------------------------------------------------------------------>
 <!------------------------- Real-Time CSAT JS Part ----------------------------------------------------------->
 <!------------------------------------------------------------------------------------------------------------>
 

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/date-time-picker.min.js"></script>
 
 <script>
	$('#coach_date').dateTimePicker();
	$('#chat_date').dateTimePicker();
 </script>
 
 
 <script>
	$(document).ready(function(){
	   $( "#real_time_category" ).on('change' , function() {
		var catid = this.value;
		if(catid=="") alert("Please Select Category")
		var URL='<?php echo base_url();?>qa_grubhub/get_sub_category';
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'catid='+catid,
		   success: function(catList){
				
				var json_obj = $.parseJSON(catList);//parse JSON
				
				$('#real_time_sub_category').empty();
				$('#real_time_sub_category').append($('<option></option>').val('').html('-- Select --'));
						
				for (var i in json_obj) $('#real_time_sub_category').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].description));
										
			},
			error: function(){	
				alert('Fail!');
			}
			
		  });
		  
	  });
 
 });
 </script>
 
 
 <script>
	$(document).ready(function(){
	   $( "#real_time_sub_category" ).on('change' , function() {
		var sub_catid = this.value;
		if(sub_catid=="") alert("Please Select Sub-Category")
		var URL='<?php echo base_url();?>qa_grubhub/get_real_time_true_reason';
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'sub_catid='+sub_catid,
		   success: function(sub_catList){
				
				var json_obj = $.parseJSON(sub_catList);//parse JSON
				
				$('#true_reason').empty();
				$('#true_reason').append($('<option></option>').val('').html('-- Select --'));
						
				for (var i in json_obj) $('#true_reason').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].description));
										
			},
			error: function(){	
				alert('Fail!');
			}
			
		  });
		  
	  });
 
 });
 </script>
 
 <script>
	$(document).ready(function(){
		
		$( "#real_time_category" ).on('change' , function() {
			var x = this.value;
			if(x != 1){
				//$("#demo").attr('selected','selected');
				//$("#demo").val('1');
				//$("#demo").text('ok');
				$("#is_coach1").attr('type','text');
				$("#is_coached").hide();
				$("#is_coached").attr('disabled', true);
				$("#coach_name").attr('disabled', true);
				$("#coach_date").attr('disabled', true);
				$("#coach_comment").attr('disabled', true);
			}else{
				$("#is_coach1").attr('type','hidden');
				$("#is_coached").show();
				$("#is_coached").attr('disabled', false);
				$("#coach_name").attr('disabled', false);
				$("#coach_date").attr('disabled', false);
				$("#coach_comment").attr('disabled', false);
			}
		});	
	});
 </script>
 