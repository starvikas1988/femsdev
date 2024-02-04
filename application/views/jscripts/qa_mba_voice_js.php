<script type="text/javascript">
function mba_point_calculation() {
	var score = 0;
	var quality_score_percent = 0;
	var scoreable = 0;

	$('.mba_val').each(function(index, element) {
		let score_type = $(element).val();
		if (score_type == 'Completely'){
			var w1 = parseFloat($(element).children("option:selected").attr('mba_val'));
			var w2 = parseFloat($(element).children("option:selected").attr('mba_max'));
			score = score + w1;
			scoreable = scoreable + w2;
		}else if (score_type == 'Partially'){
			var w1 = parseFloat($(element).children("option:selected").attr('mba_val'));
			var w2 = parseFloat($(element).children("option:selected").attr('mba_max'));
			score = score + w1;
			scoreable = scoreable + w2;
		}else if (score_type == 'Not at all'){
			var w1 = parseFloat($(element).children("option:selected").attr('mba_val'));
			var w2 = parseFloat($(element).children("option:selected").attr('mba_max'));
			score = score + w1;
			scoreable = scoreable + w2;
		}else if (score_type == 'N/A'){
			var w1 = parseFloat($(element).children("option:selected").attr('mba_val'));
			var w2 = parseFloat($(element).children("option:selected").attr('mba_max'));
			score = score + w1;
			scoreable = scoreable + w2;
		}
	});

	/* $('.mba_val').each(function(index, element) {
		let score_type = $(element).val();

		if (score_type != 'N/A') {
			possibleScore += parseInt($(element).attr('max-possible'));
		}
	}); */

	quality_score_percent = ((score * 100)/scoreable).toFixed(2);

	$('#mba_earned_score').val(score);
	$('#mba_possible_score').val(scoreable);


	if (!isNaN(quality_score_percent)) {
		$('#mba_overall_score').val(quality_score_percent + '%');
	}

	//////MBA///////
    if ($('#mbaAF1').val() == 'Not at all' || $('#mbaAF2').val() == 'Not at all' || $('#mbaAF3').val() == 'Not at all' || $('#mbaAF4').val() == 'Not at all' || $('#mbaAF5').val() == 'Not at all' || $('#mbaAF6').val() == 'Not at all') {
        $('.mbaFatal').val(0 + '%');
    } else {
        $('.mbaFatal').val(quality_score_percent + '%');
    }
}

$(document).on('change', '.mba_val', function() {
	mba_point_calculation();
});
mba_point_calculation();

/**Avanse Audit*/
function avanse_point_calculation() {
	var score = 0;
	var quality_score_percent = 0;
	var possibleScore = 0;

	$('.avanse_val').each(function(index, element) {
		let score_type = $(element).val();
		if (score_type == 'Yes') {
			var weightage = parseFloat($(element).children("option:selected").attr('avanse_val'));
			score = score + weightage;
		} else if (score_type == 'No') {
			var weightage = parseFloat($(element).children("option:selected").attr('avanse_val'));
		} else if (score_type == 'N/A') {
			var weightage = parseFloat($(element).children("option:selected").attr('avanse_val'));
			score = score + weightage;
		}
	});

	$('.avanse_val').each(function(index, element) {
		let score_type = $(element).val();

		if (score_type != 'N/A') {
			possibleScore += parseInt($(element).attr('max-possible'));
		}
	});

	quality_score_percent = ((score * 100) / possibleScore).toFixed(2);

	//$('#avanse_earned_score').val(score);
	$('#avanse_possible_score').val(possibleScore);


	if($('#complete_correct_information').val()=='Fatal' || $('#mandatory_information').val()=='Fatal' || $('#tagging_remarks').val()=='Fatal' || $('#call_disconnection').val()=='Fatal' || $('#call_avoidance').val()=='Fatal' || $('#details_shared').val()=='Fatal' ){
		$('#avanse_overall_score').val(0);
		$('#avanse_earned_score').val(0);
	}else{
		if (!isNaN(quality_score_percent)) {
			$('#avanse_earned_score').val(score);
			$('#avanse_overall_score').val(quality_score_percent + '%');
		}
	}
	
}

$(document).on('change', '.avanse_val', function() {
	avanse_point_calculation();
});

avanse_point_calculation();

/**Avanse Audit */
$(document).ready(function() {

	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#booking_date").datepicker();
	$("#video_duration").timepicker({
		timeFormat: 'HH:mm:ss'
	});
	$("#call_duration").timepicker({
		timeFormat: 'HH:mm:ss'
	});
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	$("#go_live_date").datepicker();
	
	
	///////////////// Calibration - Auditor Type ///////////////////////
    $('.auType').hide();

    $('#audit_type').on('change', function() {
        if ($(this).val() == 'Calibration') {
            $('.auType').show();
            $('#auditor_type').attr('required', true);
            $('#auditor_type').prop('disabled', false);
        } else {
            $('.auType').hide();
            $('#auditor_type').attr('required', false);
            $('#auditor_type').prop('disabled', true);
        }
    });
	

	/*Agent and TL names*/
	$("#agent_id").on('change', function() {
		var aid = this.value;
		if (aid == "") alert("Please Select Agent")
		var URL = '<?php echo base_url();?>qa_ameridial/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url: URL,
			data: 'aid=' + aid,
			success: function(aList) {
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
				$('#sktPleaseWait').modal('hide');
			},
			error: function() {
				alert('Fail!');
			}
		});
	});

	$("#form_audit_user").submit(function(e) {
		$('#qaformsubmit').prop('disabled', true);
	});

	$("#form_agent_user").submit(function(e) {
		$('#btnagentSave').prop('disabled', true);
	});

	$("#form_mgnt_user").submit(function(e) {
		$('#btnmgntSave').prop('disabled', true);
	});

});
</script>


