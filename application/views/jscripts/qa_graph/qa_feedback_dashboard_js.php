<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
// DATEPICKER
$('.oldDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy' });

// CLIENT CAMPAIGN SELECTION
$("#select_client").change(function(){
	var process_id=$('#select_process').val();
	var client_id=$('#select_client').val();
	var office_id=$('#select_office').val();
	var tl_id=$('#select_tl').val();
	var agent_id=$('#select_agent').val();
	updateProcessSelection(client_id);
	updateCampaignSelection(client_id);
	updateTlSelection(client_id, process_id, office_id);
});

$("#select_office").change(function(){
	var process_id=$('#select_process').val();
	var client_id=$('#select_client').val();
	var office_id=$('#select_office').val();
	var tl_id=$('#select_tl').val();
	var agent_id=$('#select_agent').val();
	updateTlSelection(client_id, process_id, office_id);
});

$("#select_process").change(function(){
	var process_id=$('#select_process').val();
	var client_id=$('#select_client').val();
	var office_id=$('#select_office').val();
	var tl_id=$('#select_tl').val();
	var agent_id=$('#select_agent').val();
	updateCampaignSelection(client_id, process_id, office_id);
	updateTlSelection(client_id, process_id, office_id);
});

$("#select_tl").change(function(){
	var process_id=$('#select_process').val();
	var client_id=$('#select_client').val();
	var office_id=$('#select_office').val();
	var tl_id=$('#select_tl').val();
	var agent_id=$('#select_agent').val();
	updateAgentSelection(client_id, process_id, tl_id, office_id);
});


$(".feedbackSubmit").click(function(){
	var process_id=$('#select_process').val();
	var client_id=$('#select_client').val();
	var office_id=$('#select_office').val();
	var tl_id=$('#select_tl').val();
	var agent_id=$('#select_agent').val();
	var campaing_id=$('#select_campaign').val();
	var select_end_date=$('#select_end_date').val();
	var select_start_date=$('#select_start_date').val();
	
	var form = $('#summaryForm');

	// Trigger HTML5 validity.
	var reportValidity = form[0].reportValidity();

	// Then submit if form is OK.
	if(reportValidity){
	
	
	var URL='<?php echo base_url() ."qa_graph/feedback_dashboard_view"; ?>';
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data: {
		   'client_id' : client_id,
		   'process_id' : process_id,
		   'office_id' : office_id,
		   'tl_id' : tl_id,		   
		   'agent_id' : agent_id,
		   'campaign_id' : campaing_id,
		   'start_date' : select_start_date,
		   'end_date' : select_end_date,
	   },
		success: function(data){
		  $('.feedbackRow').html(data);
		},
		error: function(){	
			//alert('error!');
		}
	  });
	  
	}
});

function updateCampaignSelection(client_id, process_id = ''){
	var URL='<?php echo base_url() ."qa_graph/select_campaign"; ?>';
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data: {
		   'client_id' : client_id,
		   'process_id' : process_id,
	   },
		success: function(data){
		  var a = JSON.parse(data);
			$("#select_campaign").empty();
			$("#select_campaign").html('<option value="">-- Select Campaign --</option>');		
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("select#select_campaign").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
			});
		},
		error: function(){	
			//alert('error!');
		}
	  });
	  
}


function updateProcessSelection(client_id){
	var URL='<?php echo base_url() ."qa_graph/select_process"; ?>';
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data: {
		   'client_id' : client_id,
	   },
		success: function(data){
		  var a = JSON.parse(data);
			$("#select_process").empty();
			$("#select_process").html('<option value="">-- Select Process --</option>');		
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("select#select_process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
			});
		},
		error: function(){	
			//alert('error!');
		}
	  });	  
}

function updateTlSelection(client_id, process_id = '', office_id = ''){
	var URL='<?php echo base_url() ."qa_graph/select_tl"; ?>';
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data: {
		   'office_id' : office_id,
		   'client_id' : client_id,
		   'process_id' : process_id,
	   },
		success: function(data){			
		  console.log(data);
		  var a = JSON.parse(data);
			$("#select_tl").empty();
			$("#select_tl").html('<option value="">-- Select TL --</option>');		
			$("#select_agent").html('<option value="">-- Select Agent --</option>');		
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("select#select_tl").append('<option value="'+jsonObject.user_id+'">' + jsonObject.fullname + '</option>');
			});
		},
		error: function(){	
			//alert('error!');
		}
	  });	  
}

function updateAgentSelection(client_id, process_id = '', tl_id = '', office_id = ''){
	var URL='<?php echo base_url() ."qa_graph/select_agent"; ?>';
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data: {
		   'office_id' : office_id,
		   'client_id' : client_id,
		   'process_id' : process_id,
		   'tl_id' : tl_id,
	   },
		success: function(data){
		  var a = JSON.parse(data);
			$("#select_agent").empty();
			$("#select_agent").html('<option value="">-- Select Agent --</option>');	
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("select#select_agent").append('<option value="'+jsonObject.user_id+'">' + jsonObject.fullname + '</option>');
			});
		},
		error: function(){	
			//alert('error!');
		}
	  });	  
}
</script>