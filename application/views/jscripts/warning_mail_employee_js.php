<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script type="text/javascript">
	var baseURL ="<?php echo base_url(); ?>";
	$('#default-datatable').DataTable({
		"pageLength":50
	});

	$('#issu_date, #review_date').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'dd-mm-yy'
	});


	function viewdocsedu(key){
		$("#viewdocsmodal").modal('show');
		var edu = $('#edudoc'+key).val();
		$("#show_docs").html('<iframe style="width: 100%; height: 600px;" src="'+baseURL+'/temp_files/hr_letters/'+edu+'"/>');
	}

	
$(document).ready(function(){
	var baseURL ="<?php echo base_url(); ?>";

	if($("#reasChck").prop('checked') == true){
		$('#chcklbl').html('Uncheck this to select Reason from dropdown');
	    $('#reason').val('').trigger('change');
	    $('#details').attr('required','required');
	    $('#reason').removeAttr('required');
		$('#det_div').removeAttr('style');
		$('#res_div').hide();
	}else{
		$('#chcklbl').html('Check this box to customize Reason');
		$('#details').val('');
		$('#reason').attr('required','required');
		$('#details').removeAttr('required');
		$('#det_div').hide();
		$('#res_div').show();
	}

	$('#requester').select2();
	// $('#reason').select2();

	$("#add_contst").click(function(){
		$('#modalAddcontst').modal('show');
	});


	var loc=$('#location').val();
	if(loc == "all"){
		$('#warn_lvl_serch').attr('required','required');
	}else{
		$('#warn_lvl_serch').removeAttr('required');
	}


	$("#location").change(function(){
		var loc=$(this).val();
		if(loc == "all"){
			$('#warn_lvl_serch').attr('required','required');
		}else{
			$('#warn_lvl_serch').removeAttr('required');
		}
	});

	$("#reasChck").change(function(){
		if($("#reasChck").prop('checked') == true){
			$('#chcklbl').html('Uncheck this to select Reason from dropdown');
		    $('#reason').val('').trigger('change');
		    $('#details').attr('required','required');
		    $('#reason').removeAttr('required');
			$('#det_div').removeAttr('style');
			$('#res_div').hide();
		}else{
			$('#chcklbl').html('Check this box to customize Reason');
			$('#details').val('');
			$('#reason').attr('required','required');
			$('#details').removeAttr('required');
			$('#det_div').hide();
			$('#res_div').show();
		}
	});


	// $("#reason").change(function(){
	// 	var reason=$(this).val();
	// 	if(reason == "Customize"){
	// 		$(this).val('').trigger('change');
	// 		$('#det_div').removeAttr('style');
	// 		$('#res_div').hide();
	// 	}else{
	// 		$('#det_div').hide();
	// 	}
	// });


	$("#issu_date , #warn_lvl").change(function(){
		var warn_lvl=$('#warn_lvl').val();
		var issu_date=$('#issu_date').val();
		//console.log(issu_date);
		
		issu_date = issu_date.split('-');
		issu_date = issu_date[2]+'-'+issu_date[1]+'-'+issu_date[0];
		
		var isu = new Date(issu_date);
		//console.log(isu);
		if(warn_lvl == "First level") isu.setDate(isu.getDate() + 30);
		else if(warn_lvl == "Second level") isu.setDate(isu.getDate() + 21);
		else if(warn_lvl == "Final level") isu.setDate(isu.getDate() + 15);
		
		var month = "0"+(isu.getMonth()+1);
    	var date = "0"+isu.getDate();
	    month = month.slice(-2);
	    date = date.slice(-2);
	    var date =  date+"-"+month+"-"+isu.getFullYear();
		$("#review_date").val(date);
	});

	$(document).on('submit','.form_warn',function(e){
		e.preventDefault();
		let valid = true;
		$('.form_warn [required]').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
		if(!valid) alert("please fill all fields!");
		else{
			$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'warning_mail_employee/send_mail',
				   data: new FormData(this),
				    contentType: false,
					cache: false,
					processData:false,
				   // data:$('form.form_warn').serialize(),
				   success: function(msg){
						var msg = JSON.parse(msg);
						if(msg.error == 'false')
						{	
							location.reload();	
						}
						else if(msg.error == 'true')
						{
							$('#sktPleaseWait').modal('hide');
							alert('Unable to Process, Please Try After A While');
						}
							
					}	
				});
		}

	});


});
</script>


