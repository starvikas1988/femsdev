<script>
$('.actionStatusButton').click(function(){
	$('#changeStatus').modal('show');
	btype = $(this).attr('btype');
	sdata = $(this).attr('sdata');
	allData = sdata.split('#');
	$('#changeStatus #user_id').val(allData[1]);
	$('#changeStatus #application_id').val(allData[0]);	
	if(btype == 1){
		wrapUnwrapOptions('P');		
	}
	if(btype == 2){
		wrapUnwrapOptions('A');		
	}
	if(btype == 3){
		wrapUnwrapOptions('T,R');		
	}
	if(btype == 4){
		wrapUnwrapOptions('C,T');		
	}
	if(btype == 5){
		wrapUnwrapOptions('D');		
	}
	if(btype == 6){
		wrapUnwrapOptions('H');		
	}
	if(btype == 7){
		wrapUnwrapOptions('R');		
	}
	if(btype == 8){
		wrapUnwrapOptions('A,T,C,D,H,R');		
	}
});

function wrapUnwrapOptions(optionCheck){
	unwrapper = [];
	unwrapper['P'] = "Pending";
	unwrapper['R'] = "Reject";
	unwrapper['A'] = "Approve";
	unwrapper['T'] = "Send ID for Printing";
	unwrapper['C'] = "Printed Copy Received";
	unwrapper['D'] = "Handover to HR";
	unwrapper['H'] = "Collected by Employee";
	
	$("#changeStatus #status").html("");
	optionsData = optionCheck.split(',');
	getOptions = "";
	$.each(optionsData, function(i, token){
		getOptions += "<option value='" + token + "'>" + unwrapper[token] + "</option>";
	});
	$("#changeStatus #status").html(getOptions);
}


$('#changeStatus #updateIDStatus').click(function(){	
    var application_id = $('#changeStatus #application_id').val();
    var user_id = $('#changeStatus #user_id').val();
    var remarks = $('#changeStatus  #remarks').val();
    var status = $('#changeStatus #status').val();
    var status_text = $('#changeStatus #status').find(":selected").text();
	
	if(application_id != "" && user_id != "" && status != ""){
	$('#sktPleaseWait').modal('show');		
    var url = "<?php echo base_url('employee_id_card/change_status')?>";
    $.ajax({
        url: url,
        type: 'POST',
        data: { 
			"application_id": application_id, 
			"remarks":remarks, 
			"status":status, 
			"status_text":status_text, 
			"user_id":user_id 
		},
        dataType: 'text',
        success: function(data) {
		     $('#sktPleaseWait').modal('hide');	
             $('#changeStatus').modal('hide');
             location.reload();
        }
    });	
	} else {
		alert('Please fillup all details!');
	}
});



//====================== BULK ================================================//

$('.actionStatusButtonBulk').click(function(){
	$('#changeStatusBulk').modal('show');
	btype = $(this).attr('btype');
	
	selectedIDS = "0"; couter = 0;
	$("input[name='employee_id_checkbox[]']:checked").each(function(){
		selectedIDS += "," + $(this).val();
		couter++;
	});
	
	$('#changeStatusBulk #bulkCounters').html(couter + ' ID Card Selected');
	
	$('#changeStatusBulk #application_id').val(selectedIDS);	
	if(btype == 1){
		wrapUnwrapOptionsBulk('P');		
	}
	if(btype == 2){
		wrapUnwrapOptionsBulk('A');		
	}
	if(btype == 3){
		wrapUnwrapOptionsBulk('T,R');		
	}
	if(btype == 4){
		wrapUnwrapOptionsBulk('C,R');		
	}
	if(btype == 5){
		wrapUnwrapOptionsBulk('D');		
	}
	if(btype == 6){
		wrapUnwrapOptionsBulk('H');		
	}
	if(btype == 7){
		wrapUnwrapOptionsBulk('R');		
	}
	if(btype == 8){
		wrapUnwrapOptionsBulk('A,T,C,D,H,R');		
	}
});


function wrapUnwrapOptionsBulk(optionCheck){
	unwrapper = [];
	unwrapper['P'] = "Pending";
	unwrapper['R'] = "Reject";
	unwrapper['A'] = "Approve";
	unwrapper['T'] = "Send ID for Printing";
	unwrapper['C'] = "Printed Copy Received";
	unwrapper['D'] = "Handover to HR";
	unwrapper['H'] = "Collected by Employee";
	
	$("#changeStatusBulk #status").html("");
	optionsData = optionCheck.split(',');
	getOptions = "";
	$.each(optionsData, function(i, token){
		getOptions += "<option value='" + token + "'>" + unwrapper[token] + "</option>";
	});
	$("#changeStatusBulk #status").html(getOptions);
}

$('#changeStatusBulk #updateIDStatusBulk').click(function(){	
    var application_id = $('#changeStatusBulk #application_id').val();
    var remarks = $('#changeStatusBulk  #remarks').val();
    var status = $('#changeStatusBulk #status').val();
    var status_text = $('#changeStatusBulk #status').find(":selected").text();
	
	if(application_id != "" && user_id != "" && status != ""){
	$('#sktPleaseWait').modal('show');		
    var url = "<?php echo base_url('employee_id_card/change_status_bulk')?>";
    $.ajax({
        url: url,
        type: 'POST',
        data: { 
			"application_ids": application_id, 
			"remarks":remarks, 
			"status":status, 
			"status_text":status_text,
		},
        dataType: 'text',
        success: function(data) {
		     $('#sktPleaseWait').modal('hide');	
             $('#changeStatusBulk').modal('hide');
             location.reload();
        }
    });	
	} else {
		alert('Please fillup all details!');
	}
});


$("#employee_id_checkbox_all").click(function(){
	if($(this).is(':checked')){
		$("input[name='employee_id_checkbox[]']").each(function(){
			$("input[name='employee_id_checkbox[]']").prop('checked', true);
		});
		$('#checkSelection').show();
	} else {
		$("input[name='employee_id_checkbox[]']").each(function(){
			$("input[name='employee_id_checkbox[]']").prop("checked", false);
		});
		$('#checkSelection').hide();
	}
});

$("input[name='employee_id_checkbox[]']").click(function(){
	totalInput = $("input[name='employee_id_checkbox[]']").length;
	totalChecked = $("input[name='employee_id_checkbox[]']:checked").length;
	if(totalChecked > 0){ $('#checkSelection').show(); } else { $('#checkSelection').hide(); }
});

</script>