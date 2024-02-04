<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>

$('.oldDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy' });

$('.editMasterClient').click(function(){	
	sid = $(this).attr('sid');
	$('#editModal_record input[name="edit_id"]').val(sid);
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo duns_url('master_client_ajax'); ?>",
		type: "GET",
		data: { eid : sid },
		dataType: "json",
		success : function(jsonData){			
			if(jsonData.response == "success"){
				$('#editModal_record input[name="edit_id"]').val(jsonData.id);
				$('#editModal_record input[name="client_name"]').val(jsonData.name);
				$('#editModal_record textarea[name="client_description"]').val(jsonData.description);
				$('#editModal_record select[name="client_status"]').val(jsonData.is_active);
				$('#editModal_record').modal('show');
			} else {
				alert("Somethign Went Wrong!");
			}
			$('#sktPleaseWait').modal('hide');
		},
		error : function(jsonData){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$('.div_agentInputAddition').on('change', 'select[name="field_type"]', function(){
	curVal = $(this).val();
	if(curVal == "select"){
		$(this).closest('.div_agentInputAddition').find('.div_drodpdownOption').show();
		$(this).closest('.div_agentInputAddition').find('textarea[name="field_options"]').attr('required', 'required');		
		$(this).closest('.div_agentInputAddition').find('textarea[name="field_options"]').val('');		
	} else {
		$(this).closest('.div_agentInputAddition').find('.div_drodpdownOption').hide();
		$(this).closest('.div_agentInputAddition').find('textarea[name="field_options"]').removeAttr('required', 'required');
		$(this).closest('.div_agentInputAddition').find('textarea[name="field_options"]').val('');
	}
});

$('.div_agentColumnAddition').on('change', 'select[name="header_map[]"]', function(){
	curVal = $(this).val();
	if(curVal == "_add_column"){
		$(this).closest('.div_agentColumnAddition').find('.div_newColumnEntry').show();
		$(this).closest('.div_agentColumnAddition').find('input[name="header_new[]"]').attr('required', 'required');
	} else {
		$(this).closest('.div_agentColumnAddition').find('.div_newColumnEntry').hide();
		$(this).closest('.div_agentColumnAddition').find('input[name="header_new[]"]').removeAttr('required', 'required');
	}
});

$('.viewMasterDatList').click(function(){	
	sid = $(this).attr('sid');
	$('#editModal_record input[name="edit_id"]').val(sid);
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo duns_url('master_client_ajax'); ?>",
		type: "GET",
		data: { eid : sid },
		dataType: "json",
		success : function(jsonData){			
			if(jsonData.response == "success"){
				$('#editModal_record input[name="edit_id"]').val(jsonData.id);
				$('#editModal_record input[name="client_name"]').val(jsonData.name);
				$('#editModal_record textarea[name="client_description"]').val(jsonData.description);
				$('#editModal_record select[name="client_status"]').val(jsonData.is_active);
				$('#editModal_record').modal('show');
			} else {
				alert("Somethign Went Wrong!");
			}
			$('#sktPleaseWait').modal('hide');
		},
		error : function(jsonData){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$('.assignDataList').click(function(){	
	sid = $(this).attr('sid');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo duns_url('assign_data_agent_modal'); ?>",
		type: "GET",
		data: { record_id : sid },
		dataType: "text",
		success : function(jsonData){			
			$('#editModal_record .modal-body').html(jsonData);
			datatable_refresh('#editModal_record #default-datatable');
			$('#editModal_record').modal('show');
			$('#sktPleaseWait').modal('hide');
		},
		error : function(jsonData){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$('.dataRemarksUpdate').click(function(){	
	sid = $(this).attr('sid');
	did = $(this).attr('did');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo duns_url('my_assign_list_data_modal'); ?>",
		type: "GET",
		data: { record_id : sid, data_id : did, view_type : 'update' },
		dataType: "text",
		success : function(jsonData){
			startDateTimer = new Date();
			startTimer();
			$('#editModal_record .modal-body').html(jsonData);
			datatable_refresh('#editModal_record #default-datatable');
			$('#editModal_record').modal('show');
			$('#sktPleaseWait').modal('hide');
		},
		error : function(jsonData){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

$('.viewRemarksUpdate').click(function(){	
	sid = $(this).attr('sid');
	did = $(this).attr('did');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo duns_url('my_assign_list_data_modal'); ?>",
		type: "GET",
		data: { record_id : sid, data_id : did, view_type : 'view' },
		dataType: "text",
		success : function(jsonData){
			startDateTimer = new Date();
			startTimer();
			$('#editModal_record .modal-body').html(jsonData);
			datatable_refresh('#editModal_record #default-datatable');
			$('#editModal_record').modal('show');
			$('#sktPleaseWait').modal('hide');
		},
		error : function(jsonData){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

function datatable_refresh(id, type="")
{
	if(type!=''){
	$(id).dataTable().fnClearTable();
	$(id).dataTable().fnDestroy();
	}
	if(type==''){
	$(id).DataTable({
		paginate:false,
		bInfo:false
	});
	}
}


//=============== STOP WATCH TIMER START =================================================//

function startTimer(){
	var total_seconds = (new Date() - startDateTimer) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#editModal_record #timeWatch").html(result);
	$("#editModal_record #time_interval").val(result);
	$("#editModal_record #time_interval_close").val(result);
	setTimeout(function(){startTimer()}, 1000);
}
</script>