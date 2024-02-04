<script type="text/javascript">
$(document).ready(function()
{
	
	baseURL = "<?php echo base_url(); ?>";
	
	
	// NEW DESIGN MODAL
	$("#btn_add_design").click(function(){	
		$('#modalAddTrainingRagDesign').modal('show');
	});
	
	
	
	// NEW DESIGN KPI APPEND
	$(document).on("click", ".btnMore", function(){
		var text=$(this).parent().parent().html();
		$("#kpi_divs").append("<div class='col-md-12 kpi_input_row'>" + text + "</div>");
		$(this).siblings('.hide').removeClass("hide");
		$(this).hide();
	});
	$(document).on("click", ".btnRemove", function(){
		$(this).parent().parent().remove();
	});
	
	
	
	// EDIT DESIGN KPI APPEND
	$(document).on("click", ".btnEdMore", function(){
		
		var text=$(this).parent().parent().html();		
		//text=text.replace("value=", "valuex="); 
		$("#kpi_divs_ed").append("<div class='col-md-12 kpi_input_row'>" + text + "</div>");
		$(this).siblings('.hide').removeClass("hide");
		$(this).hide();
	});
	$(document).on("click", ".btnEdRemove", function(){
		
		$(this).parent().parent().remove();
		
	});
	
	////////////////////////////////////////////////
	
	
	// EDIT DESIGN
	$(".editTrainingRagDesignButton").click(function(){
	
		var params=$(this).attr("params");
		//alert(params);
		
		var arrPrams = params.split("#"); 
		var mdid = arrPrams[0];
		
		//console.log(arrPrams);
		$('#mdid').val(arrPrams[0]);
		$('#uoffice_id').val(arrPrams[1]);
		$('#uclient_id').val(arrPrams[2]);
		populate_process_combo(arrPrams[2],arrPrams[3],'uprocess_id','Y');
		
		$('#udescription').val(arrPrams[4]);
		$('#batchid').val(arrPrams[5]);
		//$('#modalUpdateTrainingRagDesign').modal('show');
		
		$('#sktPleaseWait').modal('show');
		var URL=baseURL+'training/getTrainingRagDesignForm?mdid='+mdid;
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'mdid='+mdid,
		   success: function(msg){
			   
					$('#modalUpdateTrainingRagDesign').find('#kpi_divs_ed').html(msg);		
					$('#sktPleaseWait').modal('hide');
					$('#modalUpdateTrainingRagDesign').modal('show');
					
			},
			error: function(){
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
			
		  });
			
		
	});
	
	
	
	
	// CLIENT FILTER
	$("#fclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'0','fprocess_id','Y');
		
	});
	$("#uclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'0','uprocess_id','Y');
		
	});
	$("#aclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'0','aprocess_id','Y');
		
	});
	
	
	
	/////////////////
	$("#foffice_id, #fclient_id, #fprocess_id").change(function(){
		
		$("#updiv_details").hide();
		
	});
	////////////////////////	
	

	// NEW DESIGN TITLE
	$("#aoffice_id, #aclient_id , #aprocess_id, #amp_type").change(function(){
		
				
		var office_name =  $('#aoffice_id option:selected').text();
		var client_name =  $('#aclient_id option:selected').text();
		var process_name =  $('#aprocess_id option:selected').text();
				
		var title = office_name + "-" + client_name+ "-"+process_name;
		
		$('#adescription').val(title);
		
	});
	
	
	// EDIT DESIGN TITLE
	$("#uoffice_id, #uclient_id , #uprocess_id, #ump_type").change(function(){
		
				
		var office_name =  $('#uoffice_id option:selected').text();
		var client_name =  $('#uclient_id option:selected').text();
		var process_name =  $('#uprocess_id option:selected').text();
				
		var title = office_name + "-" + client_name+ "-"+process_name;
		
		$('#udescription').val(title);
		
	});
	
	
	
}); 
 
</script>
<script>
	$(document).on('change','#foffice_id',function()
	{
		var office_id = $(this).val();
		$.ajax({
		   type: 'POST',    
		   url:"<?php echo base_url('training/get_clients_training');?>",
		   data:'office_id='+office_id,
		   success: function(response){
				var res = JSON.parse(response);
				console.log(res);
				var option = '<option value="">--Select--</option>';
				$.each(res, function(key,value)
				{
					option += '<option value="'+value.id+'">'+value.shname+'</option>';
					
					//$('#fclient_id option:not([value="'+value.client_id+'"])').attr('disabled','disabled');
					//$('#fclient_id option[value="'+value.client_id+'"]').removeAttr('disabled');
				});
				$('#fclient_id').html(option);
			}
			
		  });
	});
</script>

