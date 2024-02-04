<script type="text/javascript">

	$(document).ready(function(){
		
		var baseURL="<?php echo base_url();?>";
		
		var uUrl=baseURL+'Pmetrix_Blended/upload';

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
					}
					
					var edate=$('#sesdate').val();
					if(edate==""){
						alert("Enter the End Date");
						return false;
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
	});
	
	//
	//
	//

	$(document).on("click", "#btnMore", function(){
		
		htm = '<div class="col-md-12 kpi_input_row" style="padding-top:10px">';					
		htm += '<div class="col-md-2">';
		htm += '<select class="form-control" name="kpi_name[]">';
		htm += '<option value=""></option>';
		htm += "<?php echo $master_kpis_dropdown; ?>";		
		htm += '</select>';
		htm += '</div>';
		htm += '<div class="col-md-1">';
		htm += '<select class="form-control" name="kpi_target[]" >';	
		htm += '<option value="">None</option>';
		htm += "<?php echo $master_kpis_dropdown; ?>";
		htm += '</select>';
		htm += '</div>';
		htm += '<div class="col-md-1">';
		htm += '<select class="form-control" name="summ_type[]" >';
		htm += '<?php foreach($kpi_summtype_list as $kpimas): ?>';
		htm += '<option value="'+<?php echo $kpimas['id']; ?>+'"><?php echo $kpimas['name']; ?></option>';
		htm += '<?php endforeach; ?>';
		htm += '</select>';
		htm += '</div>';
		htm += '<div class="col-md-1">';
		htm += '<input type="text" class="form-control" placeholder="Formula" name="summ_formula[]">';
		htm += '</div>';
		htm += '<div class="col-md-1">';
		htm += '<select class="form-control" name="currency[]" >';
		htm += '<option value="" >No</option>';
		htm += '<option value="$">$</option>';
		htm += '<option value="R">₹</option>'; 
		htm += '<option value="P">£</option>'; 
		htm += '</select>';								
		htm += '</div>';
		htm += '<div class="col-md-1">';
		htm += '<input type="number" min="0" step="1" pattern="\d+" value="20" class="form-control" placeholder="Integer" name="weightage[]">';
		htm += '</div>';						
		htm += '<div class="col-md-1">';
		htm += '<select class="form-control" name="weightage_comp[]"><option value="1" selected="">MAX</option><option value="0">MIN</option></select>';
		htm += '</div>';
		htm += '<div class="col-md-1">';
		htm += '<select class="form-control" name="agent_view[]"><option value="1">Yes</option><option value="0" selected>No</option></select>';
		htm += '</div>';
		htm += '<div class="col-md-1">';
		htm += '<select class="form-control" name="tl_view[]"><option value="1">Yes</option><option value="0" selected>No</option></select>';
		htm += '</div>';
		htm += '<div class="col-md-1">';
		htm += '<select class="form-control" name="management_view[]"><option value="1">Yes</option><option value="0" selected>No</option></select>';
		htm += '</div>';						
		htm += '<div class="col-md-1">';
		htm += '<button type="button" style="margin-top:1px;" class="btn btn-danger btnRemove">Remove</button>';							
		htm += '</div>';						
		htm += '</div>';
		
		$("#kpi_divs").append(htm);
	});

	//
	//
	//
	$(document).on("click", ".btnRemove", function(){
		$(this).closest(".kpi_input_row").remove();
	});
	
	//
	//
	//
	function get_kpi_blended_office_list(elem){
		if($(elem).val()!=""){
			$.post("<?php echo base_url()?>Pmetrix_Blended/get_blended_kpi_list/", {"office_id":$(elem).val()}, function(data){
				$("#design_title_description").empty().append(data);
			});
		}
	}
	
	//
	//
	//
	function design_client_process(elem){
		$('#sktPleaseWait').modal('show');
		var process_id = $(elem).val();
		if(process_id !=""){
		
			$.post("<?php echo base_url()?>Pmetrix_Blended/get_periods_dropdown", {"start_date":$("#start_date").val(), "end_date": $("#end_date").val(), 
						"client_id":$("#client_id").val(), "process_id":$("#client_process").val()},
				function(data){
					$("#period_id").empty().append(data);
			});
		}
		
		$.post("<?php echo base_url()?>Pmetrix_Blended/design_client_process", {"client_id":$("#client_id").val(), 
				"process_id":$("#client_process").val()}, function(data){
					
			if(data == "") alert("No designs associated with the selected client and process");		
			else $("#design_id").val(data);
			$('#sktPleaseWait').modal('hide');
		});
		
		
		//$("#design_id").html('');
	}
	
	function get_client_process_dropdown(elem){
		$('#sktPleaseWait').modal('show');
		var client_id = $(elem).val();
		if(client_id !=""){
			$.post("<?php echo base_url()?>Pmetrix_Blended/get_client_process_dropdown", {"client_id":client_id}, function(data){
				$("#client_process").empty().html(data);
			});
		
			$.post("<?php echo base_url()?>Pmetrix_Blended/get_periods_dropdown", {"start_date":$("#start_date").val(), "end_date": $("#end_date").val(), 
					"client_id":$("#client_id").val(), "process_id":$("#client_process").val()},
				function(data){
					$("#period_id").empty().append(data);
					$('#sktPleaseWait').modal('hide');
			});
			
		}else{
			$("#client_process").empty();
		}
		
	}
	
	//
	//
	//
	
	function get_client_process_dropdown(elem){
		$('#sktPleaseWait').modal('show');
		var client_id = $(elem).val();
		if(client_id !=""){
			$.post("<?php echo base_url()?>Pmetrix_Blended/get_client_process_dropdown", {"client_id":client_id}, function(data){
				$("#client_process").empty().html(data);
			});
		
			$.post("<?php echo base_url()?>Pmetrix_Blended/get_periods_dropdown", {"start_date":$("#start_date").val(), "end_date": $("#end_date").val(), 
					"client_id":$("#client_id").val(), "process_id":$("#client_process").val()},
				function(data){
					$("#period_id").empty().append(data);
					$('#sktPleaseWait').modal('hide');
			});
			
		}else{
			$("#client_process").empty();
		}
	}
	
	
	//
	//
	//
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
	
	});
	
	
	/*
	*
	*/
	
	function blended_accept(row_id){
		$.post("<?php echo base_url()?>Pmetrix_Blended/blended_accepted",{"row_num":row_id}, function(data){
			if(data == '1'){
				$("#accept_"+row_id).prop("disabled", true).css("display", "none");
				$("#label_accepted_"+row_id).show();
				$("#label_accepted_"+row_id).css("display", "block");
				$("#reject_"+row_id).hide();
			}
		});
	}
	
	
	/*
	*
	*/
	
	function blended_reject(row_id){
		$("#rejectModal").modal('show');
		$("#rejected_row_num").val(row_id);
	}
	
	function reject_form_blended(){
		formd = $("form#reject_form_blended").serialize();
		$.post("<?php echo base_url()?>Pmetrix_Blended/blended_rejected", formd, function(data){
			if(data == '1'){
				location.reload()
			}
		});
	}
	
	
	
	
	$("#end_date").on("blur", function(){
		$("#client_id").val("");
		$("#period_id").empty();
		$("#client_process").empty();
	});
	
	
	function get_agent_blended_data(tl_id){
		$('#sktPleaseWait').modal('show');
		data = {
			"design_id" : $("#design_id").val(),
			"start_date" : $("#start_date").val(),
			"end_date" : $("#end_date").val(),
			"tl_id" : tl_id,
			"process_ids" : $("#client_process").val(),
			"period_ids" : $("#period_id").val()
		}
		
		$.post("<?php echo base_url()?>Pmetrix_Blended/get_agent_blended_data", data, function(result){
			$('#sktPleaseWait').modal('hide');
			$("tr.hidden-trs").hide();
			$("tr#tr-"+tl_id).show();
			$("tr#tr-"+tl_id).find('td').empty().html(result);
		});
	}

	function get_agent_blended_maindata(agent_id){
		$('#sktPleaseWait').modal('show');
		data = {
			"design_id" : $("#design_id").val(),
			"start_date" : $("#start_date").val(),
			"end_date" : $("#end_date").val(),
			"agent_id" : agent_id,
			"client_id": $("#client_id").val(),
			"process_ids" : $("#client_process").val(),
			"period_ids" : $("#period_id").val()
		}
		
		$.post("<?php echo base_url()?>Pmetrix_Blended/get_agent_blended_maindata", data, function(result){
			$('#sktPleaseWait').modal('hide');
			$("tr.hidden-inner-trs").hide();
			//alert();
			$("tr#tr-"+agent_id).show();
			$("tr#tr-"+agent_id).find('td').empty().html(result);
		});
	}


	function get_manager_tl_list(manager_id){
		$('#sktPleaseWait').modal('show');
		
		data = {
			"design_id" : $("#design_id").val(),
			"start_date" : $("#start_date").val(),
			"end_date" : $("#end_date").val(),
			"manager_id" : manager_id,
			"client_id": $("#client_id").val(),
			"process_ids" : $("#client_process").val(),
			"period_ids" : $("#period_id").val()
		}
		
		$.post("<?php echo base_url()?>Pmetrix_Blended/get_manager_tl_list", data, function(result){
			$('#sktPleaseWait').modal('hide');
			$("tr.hidden-ml-trs").hide();
			//alert();
			$("tr#tr-ml-"+manager_id).show();
			$("tr#tr-ml-"+manager_id).find('td').empty().html(result);
			
			console.log(result);
		});
	}	

	
	
	
	
	
	
</script>