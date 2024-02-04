<script type="text/javascript">

$(document).ready(function()
{
		//var last_clone = $('#last_row').clone();
		//console.log(last_clone);
		//$('#last_row').remove();
		//$('#value_start').before('<tr>'+last_clone[0].innerHTML+'</tr>');
		
		var baseURL="<?php echo base_url();?>";
		
		var uUrl=baseURL+'pmetrix_v2/upload';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "myfile",
			allowedTypes:"xls,xlsx",	
			//returnType:"json",	
			dynamicFormData:function()
			{
			   var sdate = $('#ssdate').val();
			   var edate = $('#sesdate').val();
			   var mptype = $('#mptype').val();
			   var mpid =  $('#mpid').val();
			   var override =  $('[name="override"]').val();
			   			  			   
			   return {
					'sdate' : sdate,
					'edate' : edate,
					'mpid' : mpid,
					'mptype' : mptype,
					'override':override
				}
			},
			onSelect:function(files)
			{
				var mptype = $('#mptype').val();
				if(mptype == 1)
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
					
					var edate=$('#sesdate').val();
					if(edate==""){
						alert("Enter the End Date");
						return false;
					}else{
						if(isValidDate(edate)==false){
							alert("Invalid End Date");
							return false;
						}	
					}
				}
				
			},
			onSuccess:function(files,data,xhr)
			{
				//alert(data);
			   //$("#OutputDiv").html(data[0]);	   
			   //alert("Successfully uploaded and import to database.");
			   
			  // var rUrl=baseURL+'pmetrix_v2';
			   //window.location.href=rUrl;	
			   
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
		
		
		var baseURL="<?php echo base_url();?>";
		
		var uUrl=baseURL+'pmetrix_v2/uploadBonus';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "myfile",
			allowedTypes:"xls,xlsx",	
			//returnType:"json",,
			onSuccess:function(files,data,xhr)
			{
				$("#OutputDiv1").html(data);
				//alert(data);
			   //$("#OutputDiv").html(data[0]);	   
			   //alert("Successfully uploaded and import to database.");
			   
			  // var rUrl=baseURL+'pmetrix_v2';
			   //window.location.href=rUrl;	
			   
			},
			onError:function (files, status, message)
			{
			   $("#OutputDiv1").html(message);
			   
			   alert(message);
			   
			  // var rUrl=baseURL+'metrix';
			   //window.location.href=rUrl;	
			   
			},
			showDelete:false
		}
		
		var uploadObj = $("#mulitplefileuploader1").uploadFile(settings);
		
		
		///////////////////////////////////////////////
		
		
		var baseURL="<?php echo base_url();?>";
		
		var uUrl=baseURL+'pmetrix_v2/uploadBonusSupervisor';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "myfile",
			allowedTypes:"xls,xlsx",	
			//returnType:"json",,
			onSuccess:function(files,data,xhr)
			{
				$("#OutputDiv2").html(data);
				//alert(data);
			   //$("#OutputDiv").html(data[0]);	   
			   //alert("Successfully uploaded and import to database.");
			   
			  // var rUrl=baseURL+'pmetrix_v2';
			   //window.location.href=rUrl;	
			   
			},
			onError:function (files, status, message)
			{
			   $("#OutputDiv2").html(message);
			   
			   alert(message);
			   
			  // var rUrl=baseURL+'metrix';
			   //window.location.href=rUrl;	
			   
			},
			showDelete:false
		}
		
		var uploadObj = $("#mulitplefileuploader2").uploadFile(settings);
		
		
		///////////////////////////////////////////////
	
			
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
		$('#modalAddDesign').modal('show');
	});
	
	
	
	$(document).on("click", ".btnEdMore", function(){
		
		var text=$(this).parent().parent().html();
		
		text=text.replace("value=", "valuex="); 
		
		$("#kpi_divs_ed").append("<div class='col-md-12 kpi_input_row'>" + text + "</div>");
		$('.kpi_input_row:nth-last-child(1) > div:last-child > .btnEdMore').addClass('new');
		//$(this).siblings('.hide').removeClass("hide");
		$(this).hide();
		$('.kpi_input_row:nth-last-child(1) > div:last-child > .btnEdRemove').addClass('new');
	});
	
	$(document).on("click", ".btnEdRemove", function(){
		var th = $(this);
		if(th.hasClass("new"))
		{
			th.parent().parent().remove();
			$('.kpi_input_row:nth-last-child(1) > div:last-child > .btnEdMore').removeClass('hide').css({'display':'block'});
		}
		else
		{
			var mdid = $('#modalUpdateDesign .frmUpdateDesign #mdid').val();
			var kpi_id = $(this).parent().parent().find('[name="kpi_id[]"]').val();
			var datas = {'mdid':mdid,'kpi_id':kpi_id};
			var request_url = "<?php echo base_url('Pmetrix_v2/check_existing_data'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					var r = confirm("If You Delete It, All KPI Data Will Be Deleted");
					if (r == true) {
						
						var request_url1 = "<?php echo base_url('Pmetrix_v2/delete_metrix'); ?>";
						process_ajax(function(response)
						{
							var res = JSON.parse(response);
							if(res.stat == true)
							{
								window.location.href = "<?php echo base_url('Pmetrix_v2/design'); ?>";
							}
						},request_url1, datas, 'text');
					}
				}
				else if(res.stat == null)
				{
					th.parent().parent().remove();
					$('.kpi_input_row:nth-last-child(1) > div:last-child > .btnEdMore').removeClass('hide').css({'display':'block'});
					var request_url1 = "<?php echo base_url('Pmetrix_v2/delete_metrix'); ?>";
					process_ajax(function(response)
					{
						var res = JSON.parse(response);
						if(res.stat == true)
						{
							window.location.href = "<?php echo base_url('Pmetrix_v2/design'); ?>";
						}
					},request_url1, datas, 'text');
					
				}
			},request_url, datas, 'text');
			
		}
	});
	
	////////////////////////////////////////////////
	//////////////Get Matrix Week List//////////////
	///////////////////////////////////////////////
	$(".onProcessAction").change(function(){
		var process_id = $(this).val();
		var office_id = $('#foffice_id').val();
		var client_id = $('#fclient_id').val();
		
		
		var URL=baseURL+'pmetrix_v2/get_matrix_week';
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:{'process_id':process_id,'office_id':office_id,'client_id':client_id},
		   success: function(msg){
				//console.log(JSON.parse(msg));
				var data = JSON.parse(msg);
				//console.log(data.length);
					if(data.length > 0)
					{
						var option = '<label for="sch_range">Select a Metrix Week</label><select class="form-control" name="sch_range" id="sch_range"  required><option value="">--Select--</option>';
						$.each(data,function(index,element)
						{
							//console.log(element);
							option += '<option value="'+element.start_date+'#'+element.end_date+'" data-mdid="'+element.mp_type+'">'+element.shrange+'</option>';
						});
						option += "</select>";
						//console.log(option);
						//$('#week_range_container').html(option);
						//$('#showReports').show();
					}
					else
					{
						//$('#week_range_container').html('');
						//$('#showReports').hide();
					}
			},
			error: function(){
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
			
		  });
	});
	
	$(".editPMButton").click(function(){
	
		var params=$(this).attr("params");
		//alert(params);
		
		var arrPrams = params.split("#"); 
		var mdid = arrPrams[0];
		
		//console.log(arrPrams);
		$('#mdid').val(arrPrams[0]);
		$('#uoffice_id').val(arrPrams[1]);
		$('#uclient_id').val(arrPrams[2]);
		populate_process_combo(arrPrams[2],arrPrams[3],'uprocess_id','Y');
		
		$('#ump_type').val(arrPrams[4]);
		$('#udescription').val(arrPrams[5]);
		$('#uincentive').val(arrPrams[6]);
				
		var URL=baseURL+'pmetrix_v2/getDesignForm?mdid='+mdid;
		//alert(URL);
		
		$('#sktPleaseWait').modal('show');
		
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
	
	$(".copy_design").click(function(){
	
		var params=$(this).attr("params");
		//alert(params);
		
		var arrPrams = params.split("#"); 
		var mdid = arrPrams[0];
		
		//console.log(arrPrams);
		$('#copy_design_modal #mdid').val(arrPrams[0]);
		$('#copy_design_modal #cuoffice_id').val(arrPrams[1]);
		$('#copy_design_modal #cuclient_id').val(arrPrams[2]);
		populate_process_combo(arrPrams[2],arrPrams[3],'cuprocess_id','Y');
		
		$('#copy_design_modal #ump_type').val(arrPrams[4]);
		$('#copy_design_modal #udescription').val('');
				
		var URL=baseURL+'pmetrix_v2/getDesignForm?mdid='+mdid;
		//alert(URL);
		$('#copy_design_modal').modal('show');
		
			
	});
	
	
	$("#uclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'0','uprocess_id','N');
		
	});
	$("#cuclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'0','cuprocess_id','N');
		
	});
	
	/////////////////
	$("#foffice_id, #fclient_id, #fprocess_id").change(function(){
		
		$("#updiv_details").hide();
		
	});
	
	////////////////////////	
	
	
	$("#aclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'0','aprocess_id','N');
		
	});
	
	$("#aoffice_id, #aclient_id , #aprocess_id, #amp_type").change(function(){
		
				
		var office_name =  $('#aoffice_id option:selected').text();
		var client_name =  $('#aclient_id option:selected').text();
		var process_name =  $('#aprocess_id option:selected').text();
		var mp_name =  $('#amp_type option:selected').text();
		
		var title = office_name + "-" + client_name+ "-"+process_name+ "-"+mp_name;
		
		$('#adescription').val(title);
		
	});
	
	
	$("#cuoffice_id, #cuclient_id , #cuprocess_id, #cump_type").change(function(){
		
				
		var office_name =  $('#cuoffice_id option:selected').text();
		var client_name =  $('#cuclient_id option:selected').text();
		var process_name =  $('#cuprocess_id option:selected').text();
		var mp_name =  $('#cump_type option:selected').text();
		
		var title = office_name + "-" + client_name+ "-"+process_name+ "-"+mp_name;
		
		$('#cudescription').val(title);
		
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
	
	$("#sesdate").datepicker($.extend({
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
	
	/*
    $("#sedate").datepicker($.extend({
        onSelect: function() {
            var maxDate = $(this).datepicker('getDate');
            maxDate.setDate(maxDate.getDate()-6);
            $("#ssdate").datepicker( "option", "maxDate", maxDate);
        }
    },datepickersOpt));
	*/

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
  $( function() {
    var dateFormat = "yy-mm-dd",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 2,
		  dateFormat: 'yy-mm-dd'
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
		dateFormat: 'yy-mm-dd'
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
</script>

<script>
	$('#search_type').on('change',function()
	{
		$('#agent_container,#tl_container').hide();
		$('#agent_fusion_id,#tl_fusion_id').attr('disabled','disabled');
		var type_value = $(this).val();
		if(type_value == 1)
		{
			$('#agent_container').show();
			$('#agent_fusion_id').removeAttr('disabled');
		}
		else if(type_value == 2)
		{
			$('#tl_container').show();
			$('#tl_fusion_id').removeAttr('disabled');
		}
	});
</script>

<script>
	$(document).on('change','#fprocess_id',function()
	{
		var process_id = $(this).val();
		$.ajax({
		   type: 'POST',    
		   url:"<?php echo base_url('pmetrix_v2/get_tl_list');?>",
		   data:'process_id='+process_id,
		   success: function(response){
				var res = JSON.parse(response);
				console.log(res);
				var option = '<option value="">--Select--</option>';
				$.each(res, function(key,value)
				{
					option += '<option value="'+value.id+'">'+value.tl_name+'</option>';
				});
				$('#tl_fusion_id').html(option);
			}
			
		  });
	});
</script>

<script>
	$(document).on('submit','.frmUpdateDesign',function(e)
	{
		
		var total_wait = 0;
		$(this).find('[name="weightage[]"]').each(function(index,element)
		{
			console.log($(element).val());
			total_wait = total_wait + parseInt(Math.abs($(element).val()));
		});
		if(total_wait != 0)
		{
			if(total_wait != 100)
			{
				e.preventDefault();
				alert('Total Waitage must be equal to 100. Current Total Waitage is: '+total_wait);
			}
		}
	});
</script>
<script>
	$("#fclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'0','fprocess_id','Y');
	});
</script>
<script>
	$(document).on('change','#foffice_id',function()
	{
		var office_id = $(this).val();
		$.ajax({
		   type: 'POST',    
		   url:"<?php echo base_url('pmetrix_v2/get_clients');?>",
		   data:'office_id='+office_id,
		   success: function(response){
				var res = JSON.parse(response);
				console.log(res);
				var option = '<option value="">--Select--</option>';
				$.each(res, function(key,value)
				{
					option += '<option value="'+value.client_id+'" selected>'+value.shname+'</option>';
					
					/* $('#fclient_id option:not([value="'+value.client_id+'"])').attr('disabled','disabled');
					$('#fclient_id option[value="'+value.client_id+'"]').removeAttr('disabled'); */
				});
				$.when($('#fclient_id').html(option)).done(function()
				{
					$('#fclient_id').val('<?php echo $cValue; ?>').trigger("change");
				});
				
			}
			
		  });
	});
</script>


<script>
	$(document).on('change','#uoffice_id,#cuoffice_id',function()
	{
		var office_id = $(this).val();
		$.ajax({
		   type: 'POST',    
		   url:"<?php echo base_url('pmetrix_v2/get_clients');?>",
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
				$('#uclient_id').html(option);
			}
			
		  });
	});
</script>

<script>
$(document).on('submit','#copy_metrix',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('pmetrix_v2/copy_metrix'); ?>";
		
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				alert('Copy Successfully');
				window.location.reload();
			}
			else
			{
				alert(res.message);
			}
		},request_url, datas, 'text');
		
		
		/* var datas = $(this).serializeArray();
		$.ajax({
		   type: 'POST',    
		   url:"<?php echo base_url('pmetrix_v2/copy_metrix');?>",
		   data:datas,
		   success: function(response){
				var res = JSON.parse(response);
				console.log(res);
				if(res.stat == true)
				{
					alert('Copy Successfully');
					window.location.reload();
				}
				else
				{
					alert(res.message);
				}
			}
			
		  }); */
	});
	
	
	
</script>