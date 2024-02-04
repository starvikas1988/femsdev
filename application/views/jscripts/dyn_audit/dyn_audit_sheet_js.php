<script type="text/javascript">

$("#audit_date").datepicker();
$("#feedback_date").datepicker();
$("#audit_date_time").datetimepicker();
$("#call_date_time").datetimepicker({  maxDate: 0 });
$("#email_date_time").datetimepicker({  maxDate: 0 });
$("#from_date").datepicker({  maxDate: 0 });
$("#to_date").datepicker({  maxDate: 0 });
$("#call_duration").timepicker({
    timeFormat: 'HH:mm:ss'
});

$("#agent_disposition").select2();
$("#correct_disposition").select2();
$("#qa_id").select2();
$("#agent_id").select2();
$('.audit-search-agent-id').select2();
$("#process").select2();
$("#campaign").select2();
$("#lob_camp_dispo").select2();
$("#lob_camp_sub_dispo").select2();
$("#audit_type").select2();
$("#process_id").select2();

    
  
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

    ///////// for cerification audit /////////
		if ($(this).val() == 'Certificate Audit'){
			$('#certificationAudit').show();
            $('#certification_attempt').attr('required', true);
            $('#certification_status').attr('required', true);
			$('#certification_attempt').prop('disabled', false);
			$('#certification_status').prop('disabled', false);
		}else{
			$('#certificationAudit').hide();
            $('#certification_attempt').attr('required', false);
            $('#certification_status').attr('required', false);
			$('#certification_attempt').prop('disabled', true);
			$('#certification_status').prop('disabled', true);
		}
});

///////////////////////////////
function audit_calc() {

var score = 0;
var scoreable = 0;
var totScore = 0;
$('.audit_point').each(function(index, element) {
    var s1 = $(element).val();
    var w1 = parseInt($(this).children("option:selected").attr("adt_val"));
    if (s1 == 'Pass') {
        score = score + w1;
        scoreable = scoreable + w1;
    } else if (s1 == 'Fail') {
        scoreable = scoreable + w1;
    } else if (s1 == 'N/A') {
        score = score + w1;
        scoreable = scoreable + w1;
    }
});
totScore = ((score / scoreable) * 100).toFixed(2);
$('#earnScore').val(score);
$('#possibleScore').val(scoreable);
if (!isNaN(totScore)) {
    $('#overallScore').val(totScore);
}
////////////////////////////////////////

////////////////////////////////
var fatal_count = 0;
$('.adt_fatal').each(function(index, element) {
    var score_type = $(element).val();
    if (score_type == 'Fail') {
        fatal_count = fatal_count + 1;
    }
});
$('#adt_fatalcount').val(fatal_count);

if (!isNaN(totScore)) {
    $('#adt_prefatal').val(totScore);
}
<?php if($fatal_string!=''){ ?>
var fatal_string = <?php echo $fatal_string ?>;
<?php }else{ ?>
    var fatal_string = ''
    <?php } ?>
if (fatal_string) {
    $('.adtFatal').val(0);
} else {
    $('.adtFatal').val(totScore + '%');
}

}


$(document).ready(function() {

$(document).on("change", ".audit_point", function() {
    audit_calc();
});
$(document).on("change", ".adt_fatal", function() {
    audit_calc();
});

audit_calc();


});

$("#agent_id").on('change', function() {
        var aid = this.value;
        var qd_id = '<?php echo $qa_defect_id; ?>';
        if (aid == "") alert("Please Select Agent")
        var URL = '<?php echo base_url();?>qa_audit_dyn/getTLname';
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
                for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i]
                    .assigned_to));
                for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i]
                    .tl_name));
                for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[
                    i].fusion_id));
                for (var i in json_obj) $('#xpoid').append($('#xpoid').val(json_obj[i]
                    .xpoid));
                for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i]
                    .tenure));
                for (var i in json_obj) $('#office_name').append($('#office_name').val(
                    json_obj[i].office_name));
				// for (var i in json_obj) $('#campaign1').append($('#campaign1').val(
                //     json_obj[i].campaign_name));
				// for (var i in json_obj){ $('#campaign').append($('#campaign').val(
                //     json_obj[i].campaign_name));
					
					/////////////////////
                    //get process
                var URL = '<?php echo base_url();?>qa_audit_dyn/getProcess';
                $.ajax({
                    type: 'POST',
                    url: URL,
                    data: 'aid=' + aid,
                    success: function(prList) {
                        var j_obj = $.parseJSON(prList);
                        $('#process').empty();
                        $("#process").append($('<option></option>').val('').html('Select Process'));
                        for (var i in j_obj) {
                                $("#process").append($('<option></option>').val(j_obj[i].id).html(j_obj[i].name));
                            }
                    },
                    error: function() {
                    alert('Fail!');
                }
                });
                    //  //get campaign
                    //  var URL = '<?php echo base_url();?>qa_audit_dyn/getCampaign';
                    // $.ajax({
					// 	type: 'POST',
					// 	url: URL,
					// 	data: 'qd_id=' + qd_id,
					// 	success: function(p_List) {
                    //         var js_obj = $.parseJSON(p_List);
                    //         $('#campaign').empty();
                    //         $("#campaign").append($('<option></option>').val('').html('Select Campaign'));
                    //         for (var i in js_obj) {
					// 				$("#campaign").append($('<option></option>').val(js_obj[i].id).html(js_obj[i].campaign));
					// 			}
                    //     },
                    //     error: function() {
                    //     alert('Fail!');
                    // }
                    // });
                    
                $('#sktPleaseWait').modal('hide');
            },
            error: function() {
                alert('Fail!');
            }
        });

    });

    $('.audioFile').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'wav':
			case 'wmv':
			case 'mp3':
			case 'mp4':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
	
	
	$('.imageFile').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'jpg':
			case 'jpeg':
			case 'png':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
</script>