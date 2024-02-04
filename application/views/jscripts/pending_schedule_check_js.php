<script>
//======================================================================
// PENDING SCHEDULE CHECKBOX SELECTION JS
//======================================================================

$("#schedule_id_chekbox_all").click(function(){
	totalInput = $("input[name='schedule_id_chekbox[]']").length;
	totalChecked = $("input[name='schedule_id_chekbox[]']:checked").length;
	if(totalChecked < totalInput)
	{
		$("input[name='schedule_id_chekbox[]']").each(function(){
			$("input[name='schedule_id_chekbox[]']").prop('checked', true);
		});
		$('#checkSelection').show();
		$('.acceptEach, .reviewEach').hide();
	} else {
		$("input[name='schedule_id_chekbox[]']").each(function(){
			$("input[name='schedule_id_chekbox[]']").removeAttr("checked");
		});
		$('#checkSelection').hide();
		$('.acceptEach, .reviewEach').show();
	}
});

$("input[name='schedule_id_chekbox[]']").click(function(){
	totalInput = $("input[name='schedule_id_chekbox[]']").length;
	totalChecked = $("input[name='schedule_id_chekbox[]']:checked").length;
	if(totalChecked > 0){ $('#checkSelection').show(); $('.acceptEach, .reviewEach').hide(); } else { $('#checkSelection').hide(); $('.acceptEach, .reviewEach').show(); }
});

//======================================================================
// AGENT >> BUTTON APPROVE & REVIEW
//======================================================================

$("button[name='btnApprove[]']").click(function(){
	$("input[name='schedule_id_chekbox[]']").each(function(){
		$("input[name='schedule_id_chekbox[]']").removeAttr("checked");
	});
	$(this).closest('tr').find("input[name='schedule_id_chekbox[]']").prop('checked', true);
	$("input[name='schedule_submission_type']").val('1');
	$('#scheduleCheckSubmission').submit();
});
$("button[name='btnReview[]']").click(function(){
	
	dataParams = $(this).attr('params');
	dataArray = dataParams.split('{#}');
	scheduleDate = dataArray[0];
	scheduleIn = dataArray[1];
	scheduleOut = dataArray[2];
	scheduleDay = dataArray[3];
	
	$('#frmReviewShedule #schedule_day').val(scheduleDay);
	$('#frmReviewShedule #schedule_date').val(scheduleDate);
	$('#frmReviewShedule #schedule_in').val(scheduleIn);
	$('#frmReviewShedule #schedule_out').val(scheduleOut);
	$('#frmReviewShedule #request_schedule_in').val(scheduleIn);
	$('#frmReviewShedule #request_schedule_out').val(scheduleOut);
	
	$("input[name='schedule_id_chekbox[]']").each(function(){
		$("input[name='schedule_id_chekbox[]']").removeAttr("checked");
	});
	$(this).closest('tr').find("input[name='schedule_id_chekbox[]']").prop('checked', true);
	scheduleID = $(this).closest('tr').find("input[name='schedule_id_chekbox[]']").val();
	$('#frmReviewShedule #schedule_id').val(scheduleID);
	$('#modalReviewSchedule').modal('show');
	
	//$("input[name='schedule_submission_type']").val('2');
	//$('#scheduleCheckSubmission').submit();
});


$('#frmReviewShedule #request_type').change(function(){
	reqType = $(this).val();
	if(reqType == 'OFF')
	{
		$("#frmReviewShedule #request_schedule_in").prop("type", "text");
		$("#frmReviewShedule #request_schedule_out").prop("type", "text");
		$("#frmReviewShedule #request_schedule_in").val('OFF');
		$("#frmReviewShedule #request_schedule_out").val('OFF');
	}
	if(reqType == 'TIME')
	{
		$("#frmReviewShedule #request_schedule_in").prop("type", "time");
		$("#frmReviewShedule #request_schedule_out").prop("type", "time");
		scheduleIn = $("#frmReviewShedule #schedule_in").val();
		scheduleOut = $("#frmReviewShedule #schedule_out").val();
		$("#frmReviewShedule #request_schedule_in").val(scheduleIn);
		$("#frmReviewShedule #request_schedule_out").val(scheduleOut);
	}
});

$('.scheduleInTrigger').keyup(function(){
	userIn = $(this).val();
	scheduleDate = $("#frmReviewShedule #schedule_date").val();
	scheduleIn = $("#frmReviewShedule #schedule_in").val();
	scheduleOut = $("#frmReviewShedule #schedule_out").val();
	
	//var pattern = /(\d{4})\-(\d{2})\-(\d{2})/;
	//var dt = new Date(scheduleDate + ' ' + scheduleIn+':00');
	//var newEndTime = getNewEntry.substr(11, 5)+":00";
	
	var getNewStart = scheduleDate + ' ' + userIn+':00';
	var newStartTime = new Date(getNewStart);
	console.log(newStartTime);
	var newEndTime = newStartTime.addHours('9');
	var getNewEnd = newEndTime.toLocaleTimeString('it-IT');
	
	console.log(newEndTime);
	console.log(getNewEnd);
	$('#frmReviewShedule #request_schedule_out').val(getNewEnd);
});

Date.prototype.addHours = function(h) {
  this.setTime(this.getTime() + (h*60*60*1000));
  return this;
}

$("button[name='btnApproveSelection']").click(function(){
	$("input[name='schedule_submission_type']").val('1');
	$('#scheduleCheckSubmission').submit();
});
$("button[name='btnReviewSelection']").click(function(){
	
	getScheduleID = [];
	$("input[name='schedule_id_chekbox[]']:checked").each(function(){
		getScheduleID.push($(this).val());
	});
	scheduleIDs = getScheduleID.toString();
	$('#frmReviewShedule #schedule_id').val(scheduleIDs);
	$('#modalReviewSchedule').modal('show');
	
	//$("input[name='schedule_submission_type']").val('2');
	//$('#scheduleCheckSubmission').submit();
});


//======================================================================
// OPS >> REJECT & REVIEW
//======================================================================

$("button[name='btnOpsReject[]'], button[name='btnOpsReview[]']").click(function(){
	$("input[name='schedule_id_chekbox[]']").each(function(){
		$("input[name='schedule_id_chekbox[]']").removeAttr("checked");
	});
	$(this).closest('tr').find("input[name='schedule_id_chekbox[]']").prop('checked', true);
	scheduleID = $(this).closest('tr').find("input[name='schedule_id_chekbox[]']").val();
	scheduleStatus = $(this).attr('reviewtype');
	$('#frmReviewShedule #schedule_id').val(scheduleID);
	$('#frmReviewShedule #schedule_ops_status').val(scheduleStatus);
	if(scheduleStatus == 'R'){ $('#frmReviewShedule #schedule_submission_type').val('2'); $('#modalReviewSchedule .modal-title').text('Send to Review'); }
	if(scheduleStatus == 'C'){ $('#frmReviewShedule #schedule_submission_type').val('1'); $('#modalReviewSchedule .modal-title').text('Reject Review'); }
	$('#modalReviewSchedule').modal('show');
	
	//$("input[name='schedule_submission_type']").val('2');
	//$('#scheduleCheckSubmission').submit();
});

$("button[name='btnOpsRejectSelection'],button[name='btnOpsReviewSelection']").click(function(){
	
	getScheduleID = [];
	$("input[name='schedule_id_chekbox[]']:checked").each(function(){
		getScheduleID.push($(this).val());
	});
	scheduleIDs = getScheduleID.toString();
	$('#frmReviewShedule #schedule_id').val(scheduleIDs);
	scheduleStatus = $(this).attr('reviewtype');
	$('#frmReviewShedule #schedule_ops_status').val(scheduleStatus);
	if(scheduleStatus == 'R'){ $('#frmReviewShedule #schedule_submission_type').val('2'); $('#modalReviewSchedule .modal-title').text('Send to Review'); }
	if(scheduleStatus == 'C'){ $('#frmReviewShedule #schedule_submission_type').val('1'); $('#modalReviewSchedule .modal-title').text('Reject Review'); }
	$('#modalReviewSchedule').modal('show');
	
	//$("input[name='schedule_submission_type']").val('2');
	//$('#scheduleCheckSubmission').submit();
});


//======================================================================
// WFM >> REJECT BUTTON
//======================================================================

$("button[name='btnwfmRejected[]']").click(function(){
	$("input[name='schedule_id_chekbox[]']").each(function(){
		$("input[name='schedule_id_chekbox[]']").removeAttr("checked");
	});
	$(this).closest('tr').find("input[name='schedule_id_chekbox[]']").prop('checked', true);
	scheduleID = $(this).closest('tr').find("input[name='schedule_id_chekbox[]']").val();
	scheduleStatus = $(this).attr('reviewtype');
	$('#frmRejectSchedule #schedule_id').val(scheduleID);
	$('#frmRejectSchedule #schedule_wfm_status').val(scheduleStatus);
	if(scheduleStatus == 'X'){ $('#frmReviewShedule #schedule_submission_type').val('2'); $('#modalRejectSchedule .modal-title').text('Reject Request'); }
	$('#modalRejectSchedule').modal('show');
	
	//$("input[name='schedule_submission_type']").val('2');
	//$('#scheduleCheckSubmission').submit();
});

$("button[name='btnwfmRejectedSelection']").click(function(){
	getScheduleID = [];
	$("input[name='schedule_id_chekbox[]']:checked").each(function(){
		getScheduleID.push($(this).val());
	});
	scheduleIDs = getScheduleID.toString();
	$('#frmRejectSchedule #schedule_id').val(scheduleIDs);
	scheduleStatus = $(this).attr('reviewtype');
	$('#frmRejectSchedule #schedule_wfm_status').val(scheduleStatus);
	if(scheduleStatus == 'X'){ $('#frmRejectSchedule #schedule_submission_type').val('2'); $('#modalRejectSchedule .modal-title').text('Reject Request'); }
	$('#modalRejectSchedule').modal('show');
});




//======================================================================
// WFM >> ACCEPT & UPDATE BUTTON
//======================================================================

$("button[name='btnwfmReviewed[]']").click(function(){
	
	dataParams = $(this).attr('params');
	dataArray = dataParams.split('{#}');
	scheduleDate = dataArray[0];
	scheduleIn = dataArray[1];
	scheduleOut = dataArray[2];
	scheduleDay = dataArray[3];
	
	requestParams = $(this).attr('reqparams');
	reuqestArray = requestParams.split('{#}');
	reqscheduleIn = reuqestArray[0];
	reqscheduleOut = reuqestArray[1];
	
	$('#frmUpdateShedule #schedule_day').val(scheduleDay);
	$('#frmUpdateShedule #schedule_date').val(scheduleDate);
	$('#frmUpdateShedule #schedule_in').val(scheduleIn);
	$('#frmUpdateShedule #schedule_out').val(scheduleOut);
	$('#frmUpdateShedule #requested_schedule_in').val(reqscheduleIn);
	$('#frmUpdateShedule #requested_schedule_out').val(reqscheduleOut);
	if(reqscheduleIn == "OFF"){ $('#frmUpdateShedule #requested_type').val('OFF'); }
	$('#frmUpdateShedule #update_schedule_in').val(reqscheduleIn);
	$('#frmUpdateShedule #update_schedule_out').val(reqscheduleOut);
	if(reqscheduleIn == "OFF"){ $('#frmUpdateShedule #update_type').val('OFF'); }
	$("input[name='schedule_id_chekbox[]']").each(function(){
		$("input[name='schedule_id_chekbox[]']").removeAttr("checked");
	});
	$(this).closest('tr').find("input[name='schedule_id_chekbox[]']").prop('checked', true);
	scheduleID = $(this).closest('tr').find("input[name='schedule_id_chekbox[]']").val();
	scheduleStatus = $(this).attr('reviewtype');
	$('#frmUpdateShedule #schedule_id').val(scheduleID);
	$('#frmUpdateShedule #schedule_wfm_status').val(scheduleStatus);
	if(scheduleStatus == 'C'){ $('#frmUpdateShedule #schedule_submission_type').val('1'); $('#modalReviewSchedule .modal-title').text('Update Schedule'); }
	$('#modalReviewSchedule').modal('show');
	
	//$("input[name='schedule_submission_type']").val('2');
	//$('#scheduleCheckSubmission').submit();
});


$('#frmUpdateShedule #update_type').change(function(){
	reqType = $(this).val();
	if(reqType == 'OFF')
	{
		$("#frmUpdateShedule #update_schedule_in").val('OFF');
		$("#frmUpdateShedule #update_schedule_out").val('OFF');
	}
	if(reqType == 'TIME')
	{
		scheduleIn = $("#frmUpdateShedule #requested_schedule_in").val();
		scheduleOut = $("#frmUpdateShedule #requested_schedule_out").val();
		$("#frmUpdateShedule #update_schedule_in").val(scheduleIn);
		$("#frmUpdateShedule #update_schedule_out").val(scheduleOut);
	}
});


//======================================================================
// WFM >> ACCEPT & UPDATE ALL SELECTION
//======================================================================

$("button[name='btnwfmReviewedSelection']").click(function(){
	
	getScheduleID = [];
	$("input[name='schedule_id_chekbox[]']:checked").each(function(){
		getScheduleID.push($(this).val());
	});
	scheduleIDs = getScheduleID.toString();
	$('#frmReviewShedule #schedule_id').val(scheduleIDs);
	scheduleStatus = $(this).attr('reviewtype');
	$('#frmReviewShedule #schedule_wfm_status').val(scheduleStatus);
	if(scheduleStatus == 'C'){ $('#frmReviewShedule #schedule_submission_type').val('1'); $('#modalReviewSchedule .modal-title').text('Review Done'); }
	$('#modalReviewSchedule').modal('show');
	
	//$("input[name='schedule_submission_type']").val('2');
	//$('#scheduleCheckSubmission').submit();
});

</script>