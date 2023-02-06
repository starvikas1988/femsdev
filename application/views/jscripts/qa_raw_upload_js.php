<script type="text/javascript">
$(document).ready(function() {
    //console.log("okk");
    $("#audit_date").datepicker();
    $("#feedback_date").datepicker();
    $("#survey_date").datetimepicker();
    $("#callout_date").datepicker();
    $("#email_date_time").datetimepicker();
    $("#from_date").datepicker();
    $("#to_date").datepicker();
    $("#call_duration").timepicker({
        timeFormat: 'HH:mm:ss'
    });
    $("#survey_date").timepicker({
        timeFormat: 'HH:mm:ss'
    });

    $("#qa_id").select2();
    $("#agent_id").select2();
    $("#audit_type").select2();
    //$("#process_id").select2();
	


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

    //////////////////// coachng age calculation ////////////////////////////
 
    $("#callout_date").on('change', function() {
        var callout_date = this.value;
        var audit_date = $('#audit_date').val();
       // var callout_datess  new Date(callout_date).toISOString();
        //console.log(callout_date);
        //console.log(audit_date);
        
        if (callout_date == "") alert("Please Select callout date")
        var URL = '<?php echo base_url();?>Qa_agent_coaching_upload/getCoachingAge';
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url: URL,
            data: {
                callout_date: callout_date,
                audit_date: audit_date
            },
            success: function(pList) {
                var json_obj = $.parseJSON(pList);
               // console.log(json_obj);
                $('#coaching_age').empty();
                $('#lob_camp_sub_dispo').append($('#coaching_age').val(''));
                if (json_obj == "") {
                    
                    $('#coaching_age').append($('#coaching_age').val('0'));
                    $('#sktPleaseWait').modal('hide');
                } else {
                    $('#coaching_age').append($('#coaching_age').val(json_obj));
                    $('#sktPleaseWait').modal('hide');
                }
            },
            error: function() {
                alert('Fail!');
            }
        });
    });

    ///////////////// Agent and TL names ///////////////////////
    $( "#agent_id" ).on('change' , function() {
        var aid = this.value;
        if(aid=="") alert("Please Select Agent")
        var URL='<?php echo base_url();?>qa_agent_coaching/getTlname';
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url:URL,
            data:'aid='+aid,
            success: function(aList){
                var json_obj = $.parseJSON(aList);
                $('#tl_name').empty();
                $('#tl_name').append($('#tl_name').val(''));
                //for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
                for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
                for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
                for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
                for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
                for (var i in json_obj) $('#dept_id').append($('#dept_id').val(json_obj[i].department_name));
                $('#sktPleaseWait').modal('hide');
            },
            error: function(){
                alert('Fail!');
            }
        });
    });

    $('#rcal1').on('change', function(){
        if($(this).val()=='Agent'){
            var agentAcpt = '<option value="">Select</option>';
            agentAcpt += '<option value="Skill Issue">Skill Issue</option>';
            agentAcpt += '<option value="Behavioral">Behavioral</option>';
            agentAcpt += '<option value="Knowledge Gap">Knowledge Gap</option>';
            agentAcpt += '<option value="Ineffective Training">Ineffective Training</option>';
            $("#rcal2").html(agentAcpt);
        }else if($(this).val()=='Customer'){
            var customerAcpt = '<option value="">Select</option>';
            customerAcpt += '<option value="Customer Rudeness Onset of Call">Customer Rudeness Onset of Call</option>';
            $("#rcal2").html(customerAcpt);
        }else if($(this).val()=='Process'){
            var processAcpt = '<option value="">Select</option>';
            processAcpt += '<option value="Capacity Issue">Capacity Issue</option>';
            processAcpt += '<option value="Courier Delay">Courier Delay</option>';
            processAcpt += '<option value="Shipment Cancelled">Shipment Cancelled</option>';
            $("#rcal2").html(processAcpt);
        }else if($(this).val()=='Technology'){
            var techAcpt = '<option value="">Select</option>';
            techAcpt += '<option value="System Downtime">System Downtime</option>';
            techAcpt += '<option value="System Limitation">System Limitation</option>';
            $("#rcal2").html(techAcpt);
        }else if($(this).val()==''){
            $("#rcal2").html('<option value="">Select</option>');
        }
    });

    

    //////////////////////// Number Checking //////////////////////
    function checkDec(el) {
        var ex = /^[0-9]+\.?[0-9]*$/;
        if (ex.test(el.value) == false) {
            el.value = el.value.substring(0, el.value.length - 1);
        }
    }
});
</script>