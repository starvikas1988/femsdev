<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script type="text/javascript">
	$('#default-datatable').DataTable({
		"pageLength":50
	});

$(document).ready(function(){
	var baseURL ="<?php echo base_url(); ?>";

	$("#add_qstn").click(function(){
		$('#modalAddQstn').modal('show');
	});
	$("#add_qstn_new").click(function(){
		$('#modalAddQstn_new').modal('show');
	});
	$('#q_type').on('change', function() {
		$('#radio').hide();
		$('#text').hide();
		$('#dropdown').hide();
		var a=this.value;
		if(a=='radio'){
			$('#radio').show();
			$("#opt1,#opt2,#opt3,#opt4").attr('required',true);
			$("#dropdown_answer,#correct_option_drop").removeAttr("required");
			$("#text_answer").removeAttr("required");
		}else if(a=='text'){
			$('#text').show();
			// $("#text_answer").attr('required',true);
			$("#dropdown_answer,#correct_option_drop").removeAttr("required");
			$("#opt1,#opt2,#opt3,#opt4,#correct_option").removeAttr("required");
		}else if(a=='dropdown'){
			$('#dropdown').show();
			$("#dropdown_answer").attr('required',true);
			$("#text_answer").removeAttr("required");
			$("#opt1,#opt2,#opt3,#opt4,#correct_option").removeAttr("required");
		}
});

	$('#edit_q_type').on('change', function() {
		$('#edit_radio').hide();
		$('#edit_text').hide();
		$('#edit_dropdown').hide();
		var a=this.value;
		if(a=='radio'){
			$('#edit_radio').show();
			$("#edit_opt1,#edit_opt2,#edit_opt3,#edit_opt4,#edit_correct_option").attr('required',true);
			$("#edit_dropdown_answer,#edit_correct_option_drop").removeAttr("required");
			$("#edit_text_answer").removeAttr("required");
		}else if(a=='text'){
			$('#edit_text').show();
			$("#edit_text_answer").attr('required',true);
			$("#edit_dropdown_answer,#edit_correct_option_drop").removeAttr("required");
			$("#edit_opt1,#edit_opt2,#edit_opt3,#edit_opt4,#edit_correct_option").removeAttr("required");
		}else if(a=='dropdown'){
			$('#edit_dropdown').show();
			$("#edit_dropdown_answer,#edit_correct_option_drop").attr('required',true);
			$("#edit_text_answer").removeAttr("required");
			$("#edit_opt1,#edit_opt2,#edit_opt3,#edit_opt4,#edit_correct_option").removeAttr("required");
		}
});

	$("#btnAddQstn").click(function(){
		let valid = true;
		$('.frmAddQstn [required]').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
		if(!valid) alert("please fill all fields!");
		else{
			$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'ipl_admin/add_question',
				   data:$('form.frmAddQstn').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalAddQstn').modal('hide');
							location.reload();
					}	
				});
		}

	});
	$("#btnAddQstn_new").click(function(){
		let valid = true;
		$('.frmAddQstn_new [required]').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
		if(!valid) alert("please fill all fields!");
		else{
			$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'ipl_admin/add_question_new',
				   data:$('#frmAddQstn_new').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalAddQstn_new').modal('hide');
							// location.reload();
					}	
				});
		}

	});

	$("#contst").change(function(){
    	var cntst = $(this).val();
		
		$.ajax({
			   type: 'POST',    
			   url:baseURL+'ipl_admin/get_contest',
			   data:'con_id='+cntst,
			   success: function(msg){
			   	var alrt = JSON.parse(msg);
				   $("#scheduled_on").val(alrt.status);
				   // $("#cat_id1").val(alrt.status);
				}
			  });
	});
	$("#contst_new").change(function(){
    	var cntst = $(this).val();
		
		$.ajax({
			   type: 'POST',    
			   url:baseURL+'ipl_admin/get_contest',
			   data:'con_id='+cntst,
			   success: function(msg){
			   	var alrt = JSON.parse(msg);
				   $("#scheduled_on_new").val(alrt.status);
				   // $("#cat_id1").val(alrt.status);
				}
			  });
	});


	$("#edit_contst_new").change(function(){
    	var cntst = $(this).val();
		$.ajax({
			   type: 'POST',    
			   url:baseURL+'ipl_admin/get_contest',
			   data:'con_id='+cntst,
			   success: function(msg){
			   	var alrt = JSON.parse(msg);
				   $("#edit_scheduled_on_new").val(alrt.status);
				}
			  });
	});

	
	$(".editqstn").click(function(){
		

		var params=$(this).attr("params");
		var rid=$(this).attr("rid");	
		var arrPrams = params.split("#");
		
		$('#q_id').val(rid);
		// alert(arrPrams[1]);
		$('#edit_qstn').val(arrPrams[2]);
		$('#edit_contst_new').val(arrPrams[8]);
		$('#edit_scheduled_on_new').val(arrPrams[9]);
		$('#edit_q_type').val(arrPrams[10]);
		if(arrPrams[10] == 'radio'){
			$('#edit_text').hide();
			$('#edit_dropdown').hide();
			$('#edit_radio').show();
			$("#edit_opt1,#edit_opt2,#edit_opt3,#edit_opt4,#edit_correct_option").attr('required',true);
			$("#edit_dropdown_answer,#edit_correct_option_drop").removeAttr("required");
			$("#edit_text_answer").removeAttr("required");
			$('#edit_opt1').val(arrPrams[3]);
			$('#edit_opt2').val(arrPrams[4]);
			$('#edit_opt3').val(arrPrams[5]);
			$('#edit_opt4').val(arrPrams[6]);
			$('#edit_correct_option').val(arrPrams[7]);
		}else if(arrPrams[10] == 'text'){
			$('#edit_radio').hide();
			$('#edit_dropdown').hide();
			$('#edit_text').show();
			$("#edit_text_answer").attr('required',true);
			$("#edit_dropdown_answer,#edit_correct_option_drop").removeAttr("required");
			$("#edit_opt1,#edit_opt2,#edit_opt3,#edit_opt4,#edit_correct_option").removeAttr("required");
			$("#edit_opt1,#edit_opt2,#edit_opt3,#edit_opt4,#edit_correct_option").val("");
			$('#edit_text_answer').val(arrPrams[11]);
		}else if(arrPrams[10] == 'dropdown'){
			$('#edit_radio').hide();
			$('#edit_text').hide();
			$('#edit_dropdown').show();
			$("#edit_dropdown_answer,#edit_correct_option_drop").attr('required',true);
			$("#edit_text_answer").removeAttr("required");
			$("#edit_opt1,#edit_opt2,#edit_opt3,#edit_opt4,#edit_correct_option").removeAttr("required");
			$("#edit_opt1,#edit_opt2,#edit_opt3,#edit_opt4,#edit_correct_option").val("");
			$('#edit_dropdown_answer').val(arrPrams[12]);
			$('#edit_correct_option_drop').val(arrPrams[7]);
		}

		$('#modalEditqstn').modal('show');
	});


	$("#btnEditqstn").click(function(){
		let valid = true;
		$('.frmEditQstn [required]').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
		if(!valid) alert("please fill all fields!");
		else{
			$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'ipl_admin/update_question',
				   data:$('form.frmEditQstn').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalEditqstn').modal('hide');
							location.reload();
					}	
				});
		}

	});
	
	
	
	
	
	$(".addAnswer").click(function(){
		

		var params=$(this).attr("params");
		var rid=$(this).attr("rid");	
		var arrPrams = params.split("#");
		
		$('#ans_qid').val(rid);
		// alert(arrPrams[1]);
		$('#ans_qstn').val(arrPrams[2]);
		$('#ans_contst_id').val(arrPrams[8]);
		$('#ans_contst_dropdown').val(arrPrams[8]);
		
		$('#ans_scheduled_on').val(arrPrams[9]);
		$('#ans_q_type').val(arrPrams[10]);
		$('#correct_answer').val(arrPrams[7]);
		
		if(arrPrams[10] == 'radio'){
			
			$('#ans_dropdown').hide();
			$('#ans_radio').show();
			
			$('#ans_opt1').val(arrPrams[3]);
			$('#ans_opt2').val(arrPrams[4]);
			$('#ans_opt3').val(arrPrams[5]);
			$('#ans_opt4').val(arrPrams[6]);
			
		}else if(arrPrams[10] == 'text'){
			$('#ans_radio').hide();
			$('#ans_dropdown').hide();
		}else if(arrPrams[10] == 'dropdown'){
			$('#ans_radio').hide();
			$('#ans_dropdown').show();
			$('#ans_dropdown_answer').val(arrPrams[12]);
		}

		$('#modalAddAnswer').modal('show');
	});
	
	
	
	$("#btnAddAnswer").click(function(){
		
		$('#sktPleaseWait').modal('show');	
		$.ajax({
		   type: 'POST',    
		   url:baseURL+'ipl_admin/add_answers_new',
		   data:$('form.frmAddAnswer').serialize(),
		   success: function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#modalAddAnswer').modal('hide');
					location.reload();
			}	
		});
		

	});
	





$("#add_contst").click(function(){
		$('#modalAddcontst').modal('show');
	});

	$("#btnAddcontst").click(function(){
		let valid = true;
		$('.frmAddcontst [required]').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
		if(!valid) alert("please fill all fields!");
		else{
			$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'ipl_admin/add_contest',
				   data:$('form.frmAddcontst').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalAddcontst').modal('hide');
							location.reload();
					}	
				});
		}

	});


	$(".editcontst").click(function(){
		

		var params=$(this).attr("params");
		var rid=$(this).attr("rid");	
		var arrPrams = params.split("#"); 
		// alert(arrPrams);
		$('#c_id').val(rid);

		// alert(arrPrams[1]);
		$('#edit_team1').val(arrPrams[0]);
		$('#edit_team2').val(arrPrams[1]);
		$('#edit_scheduled_on').val(arrPrams[2]);
		$('#edit_closed_on').val(arrPrams[3]);
		$('#edit_max_time').val(arrPrams[4]);

		$('#modalEditcontst').modal('show');
	});


	$("#btnEditcontst").click(function(){
		let valid = true;
		$('.frmEditcontst [required]').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
		if(!valid) alert("please fill all fields!");
		else{
			$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'ipl_admin/update_contest',
				   data:$('form.frmEditcontst').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalEditcontst').modal('hide');
							location.reload();
					}	
				});
		}

	});


	$(".editcontststat").click(function(){
		var params=$(this).attr("params");
		var rid=$(this).attr("rid");	
		var arrPrams = params.split("#"); 
		$('#c_id_stat').val(rid);
		$('#edit_status').val(arrPrams[3]);
		$('#modalEditcontststat').modal('show');
	});


	$("#btnEditcontststat").click(function(){
		let valid = true;
		$('.frmEditcontststat [required]').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
		if(!valid) alert("please fill all fields!");
		else{
			$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'ipl_admin/update_contest_stat',
				   data:$('form.frmEditcontststat').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalEditcontst').modal('hide');
							location.reload();
					}	
				});
		}

	});


	$("#contst_id").change(function(){
    	var cntst = $(this).val();
		$.ajax({
			   type: 'POST',    
			   url:baseURL+'ipl_admin/get_questions',
			   data:'c_id='+cntst,
			   success: function(msg){
			   	var alrt = JSON.parse(msg);
			   	console.log(alrt);
			   	$('#content').empty();
			   	$('#total_q').val(alrt.length);
			   	var j = 1;
			   	for (var i in alrt){
			   		// alert(alrt.length);
					$('#content').append('<input type="hidden" name="q_id'+j+'" value="'+alrt[i].id+'"><input type="hidden" name="c_id'+j+'" value="'+alrt[i].contest_id+'"><div class="form-group col-md-6"><label>'+alrt[i].question+'</label><input class="form-control" placeholder="Type the answer" type="text" name="ans'+j+'" id="ans'+j+'"></div>');	
				j=j+1;
				}
				   // $("#edit_scheduled_on_new").val(alrt.status);
				}
			  });
	});
	
	$("#btnAddans").click(function(){
		let valid = true;
		$('.frmAddans [required]').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
		if(!valid) alert("please fill all fields!");
		else{
			$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'ipl_admin/add_answers',
				   data:$('form.frmAddans').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							// $('#modalAddQstn').modal('hide');
							location.reload();
					}	
				});
		}

	});



});
</script>


