<script>
$('#userSelection').select2();
$('#area_kpi').select2();
$('#pip_date').datepicker({ dateFormat: 'yy-mm-dd' });

$('.pipReportForm #pip_client_id').change(function(){
	cid = $(this).val();	
	populate_process_combo(cid, '', 'pip_process_id', 'Y');
});

$('input[name="area_others_selection"]').click(function(){
	otherSelection = $('input[name="area_others_selection"]').val();
	$('input[name="area_others"]').val('');
	$('input[name="area_others"]').hide();
	if($('input[name="area_others_selection"]').is(":checked"))
	{
		$('input[name="area_others"]').show();
	}
});

$('#area_kpi').change(function(){
	otherSelection = $('#area_kpi').val();
	$('input[name="area_kpi_others"]').val('');
	$('input[name="area_kpi_others"]').hide();
	found = false;
	if(otherSelection.length > 0){
	$.each(otherSelection, function(i, val){
		if(val == found){ 
			$('input[name="area_kpi_others"]').show();
		} else {
			$('input[name="area_kpi_others"]').hide();
		}
	});
	} else {
		$('input[name="area_kpi_others"]').hide();
	}
});

$('#w_selection').change(function(){
	mySelection = $('#w_selection').val();
	var URL='<?php echo base_url() ."pip/ajax_week_dropdown"; ?>';
	$.ajax({
	   type: 'GET',    
	   url: URL,
	   data:'ops='+mySelection,
		success: function(data){
			$('.weekDIV').html(data);
		},
		error: function(){	
			//alert('error!');
		}
	});
});

$('#w_extend_selection').change(function(){
	mySelection = $('#w_extend_selection').val();
	myPIP = $('#w_extend_pip').val();
	var URL='<?php echo base_url() ."pip/ajax_week_extend_dropdown"; ?>';
	$.ajax({
	   type: 'GET',    
	   url: URL,
	   data:'ops='+mySelection+'&pipid='+myPIP,
		success: function(data){
			$('.weekDIV').html(data);
		},
		error: function(){	
			//alert('error!');
		}
	});
});

// OFFICE FILTER
$('#officeSelection').change(function(){
	officeID = $('#officeSelection').val();
	$("#userSelection").empty();
	if(officeID != "")
	{
		var URL='<?php echo base_url() ."pip/filter_office_user"; ?>';
		$.ajax({
		   type: 'GET',    
		   url: URL,
		   data:'oid='+officeID,
			success: function(data){

				
			  var a = JSON.parse(data);
						  
				$("#userSelection").append('<option value="">-- Select Employee --</option>');	  
				$.each(a, function(index,jsonObject){
					 $("#userSelection").append('<option value="'+jsonObject.fusion_id+'">' + jsonObject.full_name + ' (' + jsonObject.fusion_id + ", " + jsonObject.process_names + ')' + '</option>');
				});	
				$('#userSelection').html();
				$('#userSelection').prop("disabled", false);
			},
			error: function(){	
				//alert('error!');
			}
		});
	}
});



$('.viewPIPDetailsInfo').click(function(){
    pipid = $(this).attr('pid');
	$('#pipDetailsModal .modal-title').html('PIP ID : ' + pipid);
	$('#pipDetailsModal .modal-body').html('No Records Found');
	$('#sktPleaseWait').modal('show');
	bUrl = '<?php echo base_url(); ?>pip/pipDetailsView/'+pipid;
	$.ajax({
		type: 'POST',
		url: bUrl,
		data: 'pid=' + pipid,
		success: function(response) {
			$('#sktPleaseWait').modal('hide');
			$('#pipDetailsModal .modal-body').html(response);
			$('#pipDetailsModal').modal('show');
			$('#pipDetailsModal #area_kpi').select2();
		}
	});
});

$('.hrAcceptPIPDetailsInfo').click(function(){
    pipid = $(this).attr('pid');
	$('#pipDetailsModal .modal-title').html('PIP ID : ' + pipid);
	$('#pipDetailsModal .modal-body').html('No Records Found');
	$('#sktPleaseWait').modal('show');
	bUrl = '<?php echo base_url(); ?>pip/pipDetailsView/'+pipid;
	$.ajax({
		type: 'POST',
		url: bUrl,
		data: 'pid=' + pipid + '&hr=1',
		success: function(response) {
			$('#sktPleaseWait').modal('hide');
			$('#pipDetailsModal .modal-body').html(response);
			$('#pipDetailsModal').modal('show');
			$('#pipDetailsModal #area_kpi').select2();
		}
	});
});

$('.employeeAcceptPIPDetailsInfo').click(function(){
    pipid = $(this).attr('pid');
	$('#pipDetailsModal .modal-title').html('PIP ID : ' + pipid);
	$('#pipDetailsModal .modal-body').html('No Records Found');
	$('#sktPleaseWait').modal('show');
	bUrl = '<?php echo base_url(); ?>pip/pipDetailsView/'+pipid;
	$.ajax({
		type: 'POST',
		url: bUrl,
		data: 'pid=' + pipid + '&employee=1',
		success: function(response) {
			$('#sktPleaseWait').modal('hide');
			$('#pipDetailsModal .modal-body').html(response);
			$('#pipDetailsModal').modal('show');
			$('#pipDetailsModal #area_kpi').select2();
		}
	});
});

$('.extensionHR .weekExtendSelect').change(function(){
   week_extend = $(this).val();
   $('.weekSelectionDIV').hide();
   $('.weekClosureDIV').hide();
   $('.weekTerminationDIV').hide();
   if(week_extend == 'extend')
   {
	   $('.weekSelectionDIV').show();
   }
   if(week_extend == 'close')
   {
	   $('.weekClosureDIV').show();
   }
   if(week_extend == 'terminate')
   {
	   $('.weekTerminationDIV').show();
   }
});
</script>