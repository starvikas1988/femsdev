<script type="text/javascript">

$(document).ready(function(){
    
	
	// Add event listener for opening and closing details
    $('#default-datatable tbody').on('click', 'td.details-control', function (){
						
		//var p = $(this).closest('tr');
		//var tr = $(this).closest('tr').next('tr')
		//tr.toggle();
		//alert('OK');
		//p.toggleClass("shown");
		
    });
	
	
	$("#client_id").change(function(){
		var client_id=$(this).val();
		populate_process_combo(client_id);
		
	});
	
	$("#process_id").change(function(){
		var process_id=$(this).val();
		populate_sub_process_combo(process_id);
		
	});
	
	
		
		
	$("#fclient_id").change(function(){
		
		var client_id=$(this).val();
		
		var rid=$.cookie('role_id'); 
		if(rid<=1 || rid==6){
		
			if(client_id=="1"){
				$("#foffice_div").hide();
				$("#fsite_div").show();
				$("#foffice_id").val('ALL');
				
			}else{
				$("#fsite_div").hide();
				$("#foffice_div").show();
				$("#fsite_id").val('ALL');
			}
		}
		
		populate_process_combo(client_id,'','fprocess_id','Y');
		
	});
	
		
	
	
	
	
	
    $("#reset").click(function(){
		$("#assigned_to_div").hide();
		$("#site_div").hide();
		$("#process_div").hide();
		$('#assigned_to').removeAttr('required');
		$('#process_id').removeAttr('required');
		$('#site_id').removeAttr('required');
		
		$("#sub_process_div").hide();		
		$('#sub_process_id').removeAttr('required');
					
	});
	
	$("#btn_search_agent").click(function(){
		$('#agentSearchModal').modal('show');	 
	});
	
	$("#agent_fusion_id").keydown(function (event) {
		if (event.which ==112) {
			$('#agentSearchModal').modal('show');
		}
	});
  
  
  $("#fetch_agents").click(function(){
  
		var URL='<?php echo base_url();?>user/getAgentList';
		
		var aname=$('#aname').val();
		
		var aomuid=$('#aomuid').val();
		
		//alert(URL+"?pid="+pid);
		
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'aname='+aname+'&aomuid='+aomuid,
		   success: function(aList){
					
				var json_obj = $.parseJSON(aList);//parse JSON
				
				var html = '<table id="tbXXX" border="1" class="table table-striped" cellspacing="0" width="100%" >';
				
					html += '</head>';
					html += '<tr>';
					html += '<th>Fusion ID</th>';
					html += '<th>First Name</th>';
					html += '<th>Last Name</th>';
					html += '<th>OM-ID</th>';
					html += '</tr>';
					html += '</head>';
					html += '<tbody>';
				
				
				for (var i in json_obj) 
				{
					html += '<tr class="agent_row" id="'+json_obj[i].fusion_id+'" aname="'+json_obj[i].fname+" "+json_obj[i].lname+'" >';
					html += '<TD>'+json_obj[i].fusion_id+'</TD>';
					html += '<TD>'+json_obj[i].fname+'</TD>';
					html += '<TD>'+json_obj[i].lname+'</TD>';
					html += '<TD>'+json_obj[i].omuid+'</TD>';
					html += '</tr>';
				}
				html += '</tbody>';
				
				html += '</table>';
				$("#search_agent_rec").html(html);
			
			},
			error: function(){	
				alert('Fail!');
			}
		  });
		  
	});
		
	$("#audit_by").change(function(){
		
		var aname=$.cookie('aname');
				
		if($(this).val()=="Self"){ 
			$("#auditor_name").val(aname);
			$("#auditor_name").attr('readonly', 'readonly');
		}else{
			$("#auditor_name").val("");
			$("#auditor_name").removeAttr('readonly');
		}
			
			
    });
	
	
  $("#agent_fusion_id").focusout(function(){
  
	var URL='<?php echo base_url();?>user/getUserName';
	var fid=$(this).val();
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'fid='+fid,
		   success: function(aname){
				$("#agent_name").val(aname);
			},
			error: function(){	
				alert('Fail!');
			}
		  });
		  
		
  });
	  
	
	$(document).on('click', '.agent_row', function(){
		var fid=$(this).attr("id");
		var aname=$(this).attr("aname");
		$("#agent_name").val(aname);
		$("#agent_fusion_id").val(fid);
		
		$('#agentSearchModal').modal("hide");		
	});
	

});


$(function(){
    
	$("#overall_score").mask("99.9%");
	
	
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
        minDate   : "-15D"
    }
	
	$("#call_date").datepicker($.extend({},datepickersOpt));
	
	$("#audit_date").datepicker($.extend({},datepickersOpt));
	
	$( "#start_date" ).datepicker({maxDate: new Date()});
	
	$( "#end_date" ).datepicker({ maxDate: new Date() });
	
})

    
</script>

