<script type="text/javascript">
$(document).ready(function() {

    $("#audit_date").datepicker();
    $("#feedback_date").datepicker();
    $("#audit_date_time").datetimepicker();
    $("#call_date_time").datetimepicker();
    $("#email_date_time").datetimepicker();
    $("#from_date").datepicker();
    $("#to_date").datepicker();
    $("#call_duration").timepicker({
        timeFormat: 'HH:mm:ss'
    });

    $("#agent_disposition").select2();
    $("#correct_disposition").select2();
    $("#qa_id").select2();
    $("#agent_id").select2();
    $("#procss").select2();
    $("#lob_campaign").select2();
    $("#lob_camp_dispo").select2();
    $("#lob_camp_sub_dispo").select2();
    $("#audit_type").select2();
    $("#process_id").select2();
	
	$("#sales_opportunity_reason").select2();
	$("#sales_opportunity_company").select2();


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

    ////////////////////////////////////////////////////////////////	

    const getProcess = async(params) =>{

const {aid} = params;

<?php if($ss_id!=0){ ?>
var selProcessId = <?php echo $audit_data['process'] ?>;
var selProcessName = '<?php echo getProcessName($audit_data['process']) ?>';
<?php }else{ ?>
 var selProcessId = '';
 var selProcessName = 'Select Process';
    <?php } ?>

try{
    await $.ajax({
        url:"<?php echo base_url("qa_cashify/getProcess")?>",
        type:"POST",
        data:{ aid },
        success: function(prList) {
            var j_obj = $.parseJSON(prList);
            $('#procss').empty();
            
                $("#procss").append($('<option></option>').val(selProcessId).html(selProcessName));
                
            //$("#procss").append($('<option></option>').val('').html('Select Process'));
            
            for (var i in j_obj) {
                    $("#procss").append($('<option></option>').val(j_obj[i].id).html(j_obj[i].name));
                }
        },
        error: function() {
        alert('Fail!');
        }
    })
}catch(e){
    // console.log(e)
}
}

const getCampaign = async() =>{

    var qd_id = '<?php echo $qa_defect_id; ?>';
    <?php if($ss_id!=0 && $campaign != ''){ ?>
    var selLobId = <?php echo $campaign ?>;
    var selLobName = '<?php echo getLobName($campaign) ?>';
    <?php }else{ ?>
    var selLobId = '';
    var selLobName = 'Select LOB';
        <?php } ?>

try{
    await $.ajax({
        url:"<?php echo base_url("qa_cashify/getCampaign")?>",
        type:"POST",
        data:{ qd_id },
        success: function(p_List) {
                var js_obj = $.parseJSON(p_List);
                $('#lob_campaign').empty();
                //$("#lob_campaign").append($('<option></option>').val('').html('Select LOB'));
                $("#lob_campaign").append($('<option></option>').val(selLobId).html(selLobName));
                for (var i in js_obj) {
                        $("#lob_campaign").append($('<option></option>').val(js_obj[i].id).html(js_obj[i].campaign));
                    }
            },
            error: function() {
            alert('Fail!');
        }
    })
}catch(e){
    // console.log(e)
}
}
var aid = $("#agent_id").val();
if(aid!=''){
    //get process
    getProcess({aid});
    //get lob
    getCampaign();
}

    $("#agent_id").on('change', function() {
	  
        var aid = this.value;
        var qd_id = '<?php echo $qa_defect_id; ?>';
        if (aid == "") alert("Please Select Agent")
        var URL = '<?php echo base_url();?>qa_cashify/getTLname';
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
				// for (var i in json_obj) $('#lob_campaign1').append($('#lob_campaign1').val(
                //     json_obj[i].campaign_name));
				// for (var i in json_obj){ $('#lob_campaign').append($('#lob_campaign').val(
                //     json_obj[i].campaign_name));
					
					/////////////////////
                    //get process
                    getProcess({aid});
                     //get lob
                     getCampaign();
                    /////////////////////
					// var isAll = '';
					// var lobid = json_obj[i].campaign_name;
					// if (lobid == "") alert("Please Select Campaign")
					// var URL = '<?php echo base_url();?>qa_cashify/getDisposition';
					// //$('#sktPleaseWait').modal('show');
					// $.ajax({
					// 	type: 'POST',
					// 	url: URL,
					// 	data: 'lobid=' + lobid,
					// 	success: function(pList) {
					// 		var json_obj = $.parseJSON(pList);
					// 		$('#lob_camp_dispo').empty();
					// 		$('#lob_camp_dispo').append($('#lob_camp_dispo').val(''));
					// 		if (json_obj == "") {
					// 			if (isAll == 'Y') $('#lob_camp_dispo').append($('<option></option>')
					// 				.val('ALL').html('ALL'));
					// 			else $('#lob_camp_dispo').append($('<option></option>').val('').html(
					// 				'NA'));
					// 			//$('#sktPleaseWait').modal('hide');
					// 		} else {
					// 			if (isAll == 'Y') $('#lob_camp_dispo').append($('<option></option>')
					// 				.val('ALL').html('ALL'));
					// 			else $('#lob_camp_dispo').append($('<option></option>').val('').html(
					// 				'-- Select --'));

					// 			for (var i in json_obj) {
					// 				$('#lob_camp_dispo').append($('<option></option>').val(json_obj[i]
					// 					.description).html(json_obj[i].description));
					// 			}
					// 			//$('#sktPleaseWait').modal('hide');
					// 		}

					// 		if (isAll == 'Y') $('#lob_camp_dispo').val("ALL");
					// 		else $('#lob_camp_dispo').val('');
					// 	},
					// 	error: function() {
					// 		alert('Fail!');
					// 	}
					// });
				//}
					/////////////////////
                $('#sktPleaseWait').modal('hide');
            },
            error: function() {
                alert('Fail!');
            }
        });
    });


    
    $("#lob_campaign").on('change', function() {
        var isAll = '';
        var lobid = this.value;
        if (lobid == "") alert("Please Select Campaign")
        var URL = '<?php echo base_url();?>qa_cashify/getDisposition';
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url: URL,
            data: 'lobid=' + lobid,
            success: function(pList) {
                var json_obj = $.parseJSON(pList);
                $('#lob_camp_dispo').empty();
                $('#lob_camp_dispo').append($('#lob_camp_dispo').val(''));
                if (json_obj == "") {
                    if (isAll == 'Y') $('#lob_camp_dispo').append($('<option></option>')
                        .val('ALL').html('ALL'));
                    else $('#lob_camp_dispo').append($('<option></option>').val('').html(
                        '-- Select --'));
                    $('#lob_camp_dispo').append($('<option></option>').val('').html(
                        'NA'));
                    $('#sktPleaseWait').modal('hide');
                } else {
                    if (isAll == 'Y') $('#lob_camp_dispo').append($('<option></option>')
                        .val('ALL').html('ALL'));
                    else $('#lob_camp_dispo').append($('<option></option>').val('').html(
                        '-- Select --'));

                    for (var i in json_obj) {
                        $('#lob_camp_dispo').append($('<option></option>').val(json_obj[i]
                            .description).html(json_obj[i].description));
                    }
                    $('#sktPleaseWait').modal('hide');
                }

                if (isAll == 'Y') $('#lob_camp_dispo').val("ALL");
                else $('#lob_camp_dispo').val('');
            },
            error: function() {
                alert('Fail!');
            }
        });
    });


    $("#lob_camp_dispo").on('change', function() {
        var isAll = '';
        var dispo = this.value;
		//var lobid = $('#lob_campaign').val();
		
        if (dispo == "") alert("Please Select Disposition")
        var URL = '<?php echo base_url();?>qa_cashify/getSubDisposition';
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url: URL,
            //data: 'dispo=' + dispo,
			data: {
				dispo: dispo
				//lobid: lobid
			},
            success: function(pList) {
                var json_obj = $.parseJSON(pList);
                $('#lob_camp_sub_dispo').empty();
                $('#lob_camp_sub_dispo').append($('#lob_camp_sub_dispo').val(''));
                if (json_obj == "") {
                    if (isAll == 'Y') $('#lob_camp_sub_dispo').append($('<option></option>')
                        .val('ALL').html('ALL'));
                    else $('#lob_camp_sub_dispo').append($('<option></option>').val('NA')
                        .html('NA'));
                    $('#sktPleaseWait').modal('hide');
                } else {
                    if (isAll == 'Y') $('#lob_camp_sub_dispo').append($('<option></option>')
                        .val('ALL').html('ALL'));
                    else $('#lob_camp_sub_dispo').append($('<option></option>').val('')
                        .html('-- Select --'));

                    for (var i in json_obj) {
                        $('#lob_camp_sub_dispo').append($('<option></option>').val(json_obj[
                            i].description).html(json_obj[i].description));
                    }
                    $('#sktPleaseWait').modal('hide');
                }

                if (isAll == 'Y') $('#lob_camp_sub_dispo').val("ALL");
                else $('#lob_camp_sub_dispo').val('');
            },
            error: function() {
                alert('Fail!');
            }
        });
    });


    // $("#lob_camp_sub_dispo").on('change', function() {
    //     var isAll = 'N';
    //     var sub_dispo = this.value;
	// 	var lobid = $('#lob_campaign').val();
    //     if (sub_dispo == "") alert("Please Select Sub Disposition")
    //     var URL = '<?php echo base_url();?>qa_cashify/getSubSubDisposition';
    //     $('#sktPleaseWait').modal('show');
    //     $.ajax({
    //         type: 'POST',
    //         url: URL,
    //        // data: 'sub_dispo=' + sub_dispo,
	// 	    data: {
	// 			sub_dispo: sub_dispo,
	// 			lobid: lobid
	// 		},
    //         success: function(pList) {
    //             var json_obj = $.parseJSON(pList);
    //             $('#lob_camp_sub_sub_dispo').empty();
    //             $('#lob_camp_sub_sub_dispo').append($('#lob_camp_sub_sub_dispo').val(''));
    //             if (json_obj == "") {
    //                 if (isAll == 'Y') $('#lob_camp_sub_sub_dispo').append($(
    //                     '<option></option>').val('ALL').html('ALL'));
    //                 else $('#lob_camp_sub_sub_dispo').append($('<option></option>').val('NA')
    //                     .html('NA'));
    //                 $('#sktPleaseWait').modal('hide');
    //             } else {
    //                 if (isAll == 'Y') $('#lob_camp_sub_sub_dispo').append($(
    //                     '<option></option>').val('ALL').html('ALL'));
    //                 else $('#lob_camp_sub_sub_dispo').append($('<option></option>').val('')
    //                     .html('-- Select --'));

    //                 for (var i in json_obj) {
    //                     $('#lob_camp_sub_sub_dispo').append($('<option></option>').val(
    //                         json_obj[i].description).html(json_obj[i].description));
    //                 }
    //                 $('#sktPleaseWait').modal('hide');
    //             }

    //             if (isAll == 'Y') $('#lob_camp_sub_sub_dispo').val("ALL");
    //             else $('#lob_camp_sub_sub_dispo').val('');
    //         },
    //         error: function() {
    //             alert('Fail!');
    //         }
    //     });
    // });

    //////////////////// Delete Audit ////////////////////////////
    $(".auditDelete").click(function() {
        var pid = $(this).attr("pid");
        var table = $(this).attr("table");
        var title = $(this).attr("title");
        var URL = '<?php echo base_url();?>qa_snapdeal/audit_delete/' + table;
        var ans = confirm('Are you sure to ' + title + " ?");
        if (ans == true) {
            $.ajax({
                type: 'POST',
                url: URL,
                data: 'pid=' + pid,
                success: function(msg) {
                    location.reload();
                }
            });
        }
    });


    /////////////////////// Agent Fatal Accept BY TL //////////////////////
    $(".addQaFeedback").click(function() {
        var ss_id = $(this).attr("ss_id");
        var cashify_tbl = $(this).attr("cashify_tbl");
        $('.frmAddQaFeedbackModel #ss_id').val(ss_id);
        $('.frmAddQaFeedbackModel #cashify_tbl').val(cashify_tbl);
        $("#addQaFeedbackModel").modal('show');
    });

    //////////////////////// Number Checking //////////////////////
    function checkDec(el) {
        var ex = /^[0-9]+\.?[0-9]*$/;
        if (ex.test(el.value) == false) {
            el.value = el.value.substring(0, el.value.length - 1);
        }
    }

    
//////////////////////// ACPT & L2 ////////////////////////
	$('#acpt_l1').on('change', function(){
		if($(this).val()=='Agent'){
			var acpt1 = '<option value="">Select</option>';
			acpt1 += '<option value="Knowledge">Knowledge</option>';
			acpt1 += '<option value="Skill">Skill</option>';
			acpt1 += '<option value="Compliance">Compliance</option>';
			acpt1 += '<option value="Language">Language</option>';
			acpt1 += '<option value="Others">Others</option>';
			$("#acpt_l2").html(acpt1);
		}else if($(this).val()=='Process'){
			var acpt2 = '<option value="">Select</option>';
			acpt2 += '<option value="Data">Data</option>';
			acpt2 += '<option value="Underwriter">Underwriter</option>';
			acpt2 += '<option value="Test">Test</option>';
			acpt2 += '<option value="DNC">DNC</option>';
			acpt2 += '<option value="Not Eligible">Not Eligible</option>';
			acpt2 += '<option value="Company Reject">Company Reject</option>';
			acpt2 += '<option value="Wrong No">Wrong No</option>';
			acpt2 += '<option value="Others">Others</option>';
			$("#acpt_l2").html(acpt2); 
		}else if($(this).val()=='Technology'){
			var acpt3 = '<option value="">Select</option>';
			acpt3 += '<option value="Disconnection">Disconnection</option>';
			acpt3 += '<option value="Unable to Connect">Unable to Connect</option>';
			acpt3 += '<option value="Website Down">Website Down</option>';
			acpt3 += '<option value="Unable to Pay">Unable to Pay</option>';
			acpt3 += '<option value="Service Issue">Service Issue</option>';
			acpt3 += '<option value="Others">Others</option>';
			$("#acpt_l2").html(acpt3); 
		}else if($(this).val()=='Customer'){
			var acpt4 = '<option value="">Select</option>';
			acpt4 += '<option value="Competition">Competition</option>';
			acpt4 += '<option value="Cost">Cost</option>';
			acpt4 += '<option value="Benefits">Benefits</option>';
			acpt4 += '<option value="No Need">No Need</option>';
			acpt4 += '<option value="BPTP">BPTP</option>';
			acpt4 += '<option value="RNR">RNR</option>';
			acpt4 += '<option value="NR">NR</option>';
			acpt4 += '<option value="Switched Off">Switched Off</option>';
			acpt4 += '<option value="Busy">Busy</option>';
			acpt4 += '<option value="Bad Experience">Bad Experience</option>';
			acpt4 += '<option value="Others">Others</option>';
			$("#acpt_l2").html(acpt4); 
		}
	}); 


});
</script>

<script>

function cashify_calc() {

    var score = 0;
    var scoreable = 0;
    var totScore = 0;
    $('.cashify_point').each(function(index, element) {
        var s1 = $(element).val();
        var w1 = parseInt($(this).children("option:selected").attr("dgt_val"));
        if (s1 == 'Yes') {
            score = score + w1;
            scoreable = scoreable + w1;
        } else if (s1 == 'No') {
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
    $('.cashify_fatal').each(function(index, element) {
        var score_type = $(element).val();
        if (score_type == 'No') {
            fatal_count = fatal_count + 1;
        }
    });

     $('.cas_fatal').each(function(index, element) {
        var score_type = $(element).val();
        if (score_type == 'No') {
            fatal_count = fatal_count + 1;
        }
    });
    $('#cas_fatalcount').val(fatal_count);

    if (!isNaN(totScore)) {
        $('#cas_prefatal').val(totScore);
    }


    ////////////Call///////////////
    if ($('#callAF1').val() == 'No' || $('#callAF2').val() == 'No' || $('#callAF3').val() == 'No' || $('#callAF4')
    .val() == 'No' || $('#callAF5').val() == 'No' || $('#callAF6').val() == 'No') {
        $('.casCallFatal').val(0)
    } else {
        $('.casCallFatal').val(totScore + '%');
    }

    // if ($('#callAF1').val() == 'No') {
    //     $("#fatal_call1").prop('required',true);
    // }
    // if ($('#callAF2').val() == 'No') {
    //     $("#fatal_call2").prop('required',true);
    // }
    // if ($('#callAF3').val() == 'No') {
    //     $("#fatal_call3").prop('required',true);
    // }

    // if (totScore <= 84) {
    //     $('.dgt_call_attachment').attr('required', true);
    // } else {
    //     $('.dgt_call_attachment').removeAttr('required');
    // }

    ////////////Sales///////////////
    // if ($('#salesAF1').val() == 'No' || $('#salesAF2').val() == 'No' || $('#salesAF3').val() == 'No' || $('#salesAF4')
    //     .val() == 'No') {
    //     $('.dgtSalesFatal').val(0)
    // } else {
    //     $('.dgtSalesFatal').val(totScore + '%');
    // }

    // if (totScore <= 84) {
    //     $('.dgt_sales_attachment').attr('required', true);
    // } else {
    //     $('.dgt_sales_attachment').removeAttr('required');
    // }
}


$(document).ready(function() {

    $(document).on("change", ".cashify_point", function() {
        cashify_calc();
    });
    $(document).on("change", ".cas_fatal", function() {
        cashify_calc();
    });
    // $(document).on("change", ".soft_skill", function() {
    //     cashify_calc();
    // });
    // $(document).on("change", ".sale_skill", function() {
    //     cashify_calc();
    // });

    cashify_calc();


});

/* Check/Uncheck All*/
function checkAll(ele) {

    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
            console.log(checkboxes[i])
            if (checkboxes[i].type == 'checkbox' && !checkboxes[i].disabled) {
                checkboxes[i].checked = true;
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            //console.log(i)
            if (checkboxes[i].type == 'checkbox' && !checkboxes[i].disabled) {
                checkboxes[i].checked = false;
            }
        }
    }
}
/* Bulk approve JS */
$('#bulk_approve').click(function() {
    $("#edit").prop("disabled", true);
    var checkboxes = document.getElementsByTagName('input');
    var checkboxCount = 0;
    for (var i = 0; i < checkboxes.length; i++) {

        if (checkboxes[i].type == 'checkbox') {
            if (checkboxes[i].checked == true) {
                checkboxCount++;
            }
        }
    }
    checkboxCount = checkboxCount - 1;
    if (checkboxCount > 0) {
        $('#form_audit_list').submit();
    } else {
        alert("Please select at least two from the list.");
    }

});
/* Bulk edit JS */
$('#bulk_edit').click(function() {
    //alert("edit");
    $("#approve").prop("disabled", true);

    var checkboxes = document.getElementsByTagName('input');
    var checkboxCount = 0;
    for (var i = 0; i < checkboxes.length; i++) {

        if (checkboxes[i].type == 'checkbox') {
            if (checkboxes[i].checked == true) {
                checkboxCount++;
            }
        }
    }
    checkboxCount = checkboxCount - 1;
    if (checkboxCount > 0) {
        $('#form_audit_list').submit();
    } else {
        alert("Please select at least two from the list.");
    }

});
$("#form_audit_user").on("submit", function(){

    $("#qaformsubmit").attr("disabled", true);

 });
 /* Sales opportunity JS added on 30-08-22 */
 $("#sales_oppotunity").on('change', function() {
        var isAll = '';
        var selectVal = this.value;
		//alert(selectVal);
		if(selectVal =='Yes'){
			$('#sales_opportunity_reason').attr('required', true);
            $('#sales_opportunity_reason').prop('disabled', false);
			$('#sales_opportunity_company').attr('required', true);
            $('#sales_opportunity_company').prop('disabled', false);
			$('#sales_opportunity_comment').attr('required', true);
            $('#sales_opportunity_comment').prop('disabled', false);
			/*select reason */
			
        var URL = '<?php echo base_url();?>qa_cashify/getReason';
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url: URL,
            success: function(pList) {
                var json_obj = $.parseJSON(pList);
                $('#sales_opportunity_reason').empty();
                $('#sales_opportunity_reason').append($('#sales_opportunity_reason').val(''));
                if (json_obj == "") {
                    if (isAll == 'Y') $('#sales_opportunity_reason').append($('<option></option>')
                        .val('ALL').html('ALL'));
                    else $('#sales_opportunity_reason').append($('<option></option>').val('').html(
                        'NA'));
                    $('#sktPleaseWait').modal('hide');
                } else {
                    if (isAll == 'Y') $('#sales_opportunity_reason').append($('<option></option>')
                        .val('ALL').html('ALL'));
                    else $('#sales_opportunity_reason').append($('<option></option>').val('').html(
                        '-- Select --'));

                    for (var i in json_obj) {
                        $('#sales_opportunity_reason').append($('<option></option>').val(json_obj[i]
                            .id).html(json_obj[i].reason));
                    }
                    $('#sktPleaseWait').modal('hide');
                }

                if (isAll == 'Y') $('#sales_opportunity_reason').val("ALL");
                else $('#sales_opportunity_reason').val('');
            },
            error: function() {
                alert('Fail!');
            }
			});
			
		}else if(selectVal =='No'){
			$('#sales_opportunity_reason').attr('required', false);
            $('#sales_opportunity_reason').prop('disabled', true);
			$('#sales_opportunity_company').attr('required', false);
            $('#sales_opportunity_company').prop('disabled', true);
			$('#sales_opportunity_comment').attr('required', false);
            $('#sales_opportunity_comment').prop('disabled', true);
		}
    });
	
	$("#sales_opportunity_reason").on('change', function() {
		 var isAll = '';
		 var rID = this.value;
		 var URL = '<?php echo base_url();?>qa_cashify/getCompany';
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url: URL,
			data : {rID:rID},
            success: function(pList) {
                var json_obj = $.parseJSON(pList);
                $('#sales_opportunity_company').empty();
                $('#sales_opportunity_company').append($('#sales_opportunity_company').val(''));
                if (json_obj == "") {
                    if (isAll == 'Y') $('#sales_opportunity_company').append($('<option></option>')
                        .val('ALL').html('ALL'));
                    else $('#sales_opportunity_company').append($('<option></option>').val('').html(
                        'NA'));
                    $('#sktPleaseWait').modal('hide');
                } else {
                    if (isAll == 'Y') $('#sales_opportunity_company').append($('<option></option>')
                        .val('ALL').html('ALL'));
                    else $('#sales_opportunity_company').append($('<option></option>').val('').html(
                        '-- Select --'));

                    for (var i in json_obj) {
                        $('#sales_opportunity_company').append($('<option></option>').val(json_obj[i]
                            .id).html(json_obj[i].company));
                    }
                    $('#sktPleaseWait').modal('hide');
                }

                if (isAll == 'Y') $('#sales_opportunity_company').val("ALL");
                else $('#sales_opportunity_company').val('');
            },
            error: function() {
                alert('Fail!');
            }
			});
	});
 / * End */
</script>