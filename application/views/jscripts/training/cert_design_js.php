<script type="text/javascript">

$(document).ready(function()
{
		//var last_clone = $('#last_row').clone();
		//console.log(last_clone);
		//$('#last_row').remove();
		//$('#value_start').before('<tr>'+last_clone[0].innerHTML+'</tr>');
		
		var baseURL="<?php echo base_url();?>";
		
		var uUrl=baseURL+'training/upload';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "myfile",
			allowedTypes:"xls,xlsx",	
			//returnType:"json",	
			dynamicFormData:function()
			{
			   var sdate = $('#ssdate').val();
			   var edate = $('#sedate').val();
			   var mptype = $('#mptype').val();
			   var mpid =  $('#mpid').val();
			   			  			   
			   return {
					'sdate' : sdate,
					'edate' : edate,
					'mpid' : mpid,
					'mptype' : mptype
				}
			},
			onSelect:function(files)
			{
				
				var sdate=$('#ssdate').val();
				if(sdate==""){
					alert("Enter the Start Date");
					return false;
				}else{
					if(isValidDate(sdate)==false){
						alert("Invalid Start Date");
						return false;
					}
					
				}
				
				var edate=$('#sedate').val();
				if(edate==""){
					alert("Enter the End Date");
					return false;
				}else{
					if(isValidDate(edate)==false){
						alert("Invalid End Date");
						return false;
					}	
				}
				
			},
			onSuccess:function(files,data,xhr)
			{
				//alert(data);
			   //$("#OutputDiv").html(data[0]);	   
			   //alert("Successfully uploaded and import to database.");
			   
			   var rUrl=baseURL+'pmetrix';
			   window.location.href=rUrl;	
			   
			},
			onError:function (files, status, message)
			{
			   $("#OutputDiv").html(message);
			   
			   alert(message);
			   
			  // var rUrl=baseURL+'metrix';
			   //window.location.href=rUrl;	
			   
			},
			showDelete:false
		}
		
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);

		////////////////////////////////////////
	
			
	$(document).on("click", ".btnMore", function(){
		
		var text=$(this).parent().parent().html();
		
		$("#kpi_divs").append("<div class='col-md-12 kpi_input_row'>" + text + "</div>");
		$(this).siblings('.hide').removeClass("hide");
		$(this).hide();
	});
	
	$(document).on("click", ".btnRemove", function(){
		
		$(this).parent().parent().remove();
		
	});
	
	$("#btn_add_design").click(function(){	
		$('#modalAddCertDesign').modal('show');
	});
	
	
	
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
	
	
	// PASSING MARKS UPDATE
	$('.editPassingMarks').click(function(){
		var params=$(this).attr("params");
		var arrPrams = params.split("#"); 
		var mdid = arrPrams[0];
		var pmarks = arrPrams[5];
		$('#marks_mdid').val(arrPrams[0]);
		$('#passing_marks').val(pmarks);
		$('#modalUpdatePassingMarks').modal('show');
		
	});
	
	$(".editCertDesignButton").click(function(){
	
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
				
		var URL=baseURL+'training/getDesignForm?mdid='+mdid;
		//alert(URL);
		
		$('#sktPleaseWait').modal('show');
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'mdid='+mdid,
		   success: function(msg){
			   
					$('#modalUpdateCertDesign').find('#kpi_divs_ed').html(msg);		
					$('#sktPleaseWait').modal('hide');
					$('#modalUpdateCertDesign').modal('show');
					
			},
			error: function(){
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
			
		  });
			
			
	});
	
	$("#fclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'0','fprocess_id','Y');
		
	});
	
	$("#uclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'0','uprocess_id','Y');
		
	});
	
	/////////////////
	$("#foffice_id, #fclient_id, #fprocess_id").change(function(){
		
		$("#updiv_details").hide();
		
	});
	
	////////////////////////	
	
	
	$("#aclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'0','aprocess_id','Y');
		
	});
	
	$("#aoffice_id, #aclient_id , #aprocess_id, #amp_type").change(function(){
		var office_name =  $('#aoffice_id option:selected').text();
		var client_name =  $('#aclient_id option:selected').text();
		var process_name =  $('#aprocess_id option:selected').text();
				
		var title = office_name + "-" + client_name+ "-"+process_name;
		
		$('#adescription').val(title);
		
	});
	
	
	$("#uoffice_id, #uclient_id , #uprocess_id, #ump_type").change(function(){
		var office_name =  $('#uoffice_id option:selected').text();
		var client_name =  $('#uclient_id option:selected').text();
		var process_name =  $('#uprocess_id option:selected').text();
				
		var title = office_name + "-" + client_name+ "-"+process_name;
		
		$('#udescription').val(title);
		
	});
	
	
	
}); 



  $(function(){
    
	var timeOffset="-300";
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
	
	
	/* global setting */
    var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        minDate   : "-90D"
    }

    $("#ssdate").datepicker($.extend({
        onSelect: function() {
			var typ = $(this).attr("typ");
			
			//alert(typ);
			
			$("#sedate").attr("readonly", "readonly");
			
            var minDate = $(this).datepicker('getDate');
			if(typ==1) minDate.setDate(minDate.getDate()+0); //add 0 days
			else if(typ==2) minDate.setDate(minDate.getDate()+6); //add 6 days
			else if(typ==3){
				minDate.setDate(minDate.getDate()+29); //add 30 days
				$("#sedate").removeAttr("readonly");
			}
			
            $("#sedate").datepicker( "option", "minDate", minDate);
			
			$('#sedate').val(js_mm_dd_yyyy(minDate));
        }
    },datepickersOpt));
	
	
});
 
</script>

<script>
	$(document).on('change','#sch_range',function()
	{
		var mdid = $(this).children('option[value="'+$(this).val()+'"]').attr('data-mdid');
		if(parseInt(mdid) > 1)
		{
			$('#showsummary').hide();
			$('#sch_range').after('<input type="hidden" name="mdid" value="'+mdid+'">');
		}
	});
</script>

<script>
	$(document).on('change','#foffice_id',function()
	{
		var office_id = $(this).val();
		$.ajax({
		   type: 'POST',    
		   url:"<?php echo base_url('training/get_clients');?>",
		   data:'office_id='+office_id,
		   success: function(response){
				var res = JSON.parse(response);
				console.log(res);
				var option = '<option value="">--Select--</option>';
				$.each(res, function(key,value)
				{
					option += '<option value="'+value.client_id+'">'+value.shname+'</option>';
					
					/* $('#fclient_id option:not([value="'+value.client_id+'"])').attr('disabled','disabled');
					$('#fclient_id option[value="'+value.client_id+'"]').removeAttr('disabled'); */
				});
				$('#fclient_id').html(option);
			}
			
		  });
	});
</script>

