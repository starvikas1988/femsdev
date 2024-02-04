<script type="text/javascript">

var baseURL="<?php echo base_url();?>";



////////////////////////////////////////////////
// NESTING SUMMARY INFORMATION
$('.openmodalkpi').click(function(){
	var paramskpi = $(this).attr("kpiid");
	$.ajax({
	   type: 'GET',    
	   url: baseURL+'training/nesting_kpi_details',
	   data:'kid=' + paramskpi,
	   success: function(data){
			$('#kpibody').html(data);
			$('#modalkpidetails').modal('show');	
		},
		error: function(){
			alert('Fail!');
		}
	});
});





////////////////////////////////////////////////////
	/// Nesting Result Add
	
	$('#modelNestingResultUpload').on('hidden.bs.modal', function () {
		location.reload();
	});
		
	$("#modelNestingResultUpload").on("shown.bs.modal", function () {
	
		var uUrl=baseURL+'training/upload_refresher_bqm_Result';
				
		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "sktfile",
			allowedTypes:"xls,xlsx",	
			returnType:"json",
			maxFileSize: 7397376,
			dynamicFormData:function()
			{
			   var batch_id=$('#nestingbatch_id').val();
			   return {
					'batch_id' : batch_id,
				}
			},
			onSelect:function(files)
			{
				
			},
			onSuccess:function(files,data,xhr)
			{
			
		    //alert(data);
							
			$("#currAttachDiv").show();
						
			if(data[0]=="done"){
				location.reload();
			}
			
			//alert("Successfully uploaded and import to database.");
						   
			},
			onError:function (files, status, message)
			{
			   //$("#OutputDiv").html(message);
			   alert(message);
			   
			},
			showDelete:false
		}
				
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
	
	});
				
	$(".btnNestingUpload").click(function(){
		
		var batch_id=$(this).attr("batch_id");
		$('#nestingbatch_id').val(batch_id);
		$("#downloadheader1").hide();
		var certificateurl = baseURL+'training/refresher_bqm_design/' +batch_id;
		$.ajax({
		   type: 'GET',    
		   url:baseURL+'training/getFormatDesign_refresher_bqm',
		   data:'batchid=' + batch_id,
		   success: function(msg){
			 if(msg != 0)
			 {
				var uUrl=baseURL+'training/download_refresher_bqm_Header' + '?pmdid=' + msg;
				$("#downloadheader1").attr("href", uUrl);
				$("#downloadheader1").show();
			 } else {
				$("#downloadheader1").hide();
				$('#uploadingdivattach').html("<b>No Format Found - </b> <a href='"+certificateurl+"' class='btn btn-primary btn-sm' style='padding:2px 5px'>Create Upskill  Design</a>");
			 }
			}
		  });
				  
		
		$('#modelNestingResultUpload').modal('show');
		
	});
	
//================================== DESIGN JS ===================================================================//	
	
	
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


	//------ NEW DESIGN KPI APPEND
	$(document).on("click", ".btnMore", function(){
		var text=$(this).parent().parent().html();
		$("#kpi_divs").append("<div class='col-md-12 kpi_input_row'>" + text + "</div>");
		$(this).siblings('.hide').removeClass("hide");
		$(this).hide();
	});
	$(document).on("click", ".btnRemove", function(){
		$(this).parent().parent().remove();
	});
	
	
	//---------- EDIT DESIGN KPI APPEND
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
	
	//----------- EDIT DESIGN
	$(".editDesignButton").click(function(){
	
		var params=$(this).attr("params");
		//alert(params);
		
		var arrPrams = params.split("#"); 
		var mdid = arrPrams[0];
		
		//console.log(arrPrams);
		$('#mdid').val(arrPrams[0]);
		$('#uoffice_id').val(arrPrams[1]);
		$('#uclient_id').val(arrPrams[2]);
		//populate_process_combo(arrPrams[2],arrPrams[3],'uprocess_id','Y');
		
		$('#udescription').val(arrPrams[4]);
		$('#batchid').val(arrPrams[5]);
		//$('#modalUpdateTrainingRagDesign').modal('show');
		$('#sktPleaseWait').modal('show');
		var URL=baseURL+'training/get_refresher_bqm_DesignForm?mdid='+mdid;
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'mdid='+mdid,
		   success: function(msg){			   
					$('#modalUpdateDesign').find('#kpi_divs_ed').html(msg);		
					$('#sktPleaseWait').modal('hide');
					$('#modalUpdateDesign').modal('show');					
			},
			error: function(){
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
			
		  });
			
		
	});
	
	
//================================== CLIENT PROCESS FILTE ===================================================================//		
	
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
	
	$("#foffice_id, #fclient_id, #fprocess_id").change(function(){
		$("#updiv_details").hide();		
	});	
	

 
</script>
<script>
	$(document).on('change','#foffice_id',function()
	{
		var office_id = $(this).val();
		$.ajax({
		   type: 'POST',    
		   url:"<?php echo base_url('training/get_clients_refresher_bqm');?>",
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