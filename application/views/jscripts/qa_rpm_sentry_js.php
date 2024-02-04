<script>

///////////////// Calibration - Auditor Type ///////////////////////	
	$('.auType').hide();
	
	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});	

	var getTLname = function(aid){
		var URL='<?php echo base_url();?>Qa_RPM_Sentry/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	}	


	$("#from_date").datepicker({maxDate: new Date()});
	$("#to_date").datepicker({maxDate: new Date()});
	$("#audit_date").datepicker({maxDate: new Date()});
	$("#caller_date").datepicker({maxDate: new Date()});
	$("#audit_time").timepicker({timeFormat : 'HH:mm:ss' });

	if($("#agent_id").val()!="") getTLname($("#agent_id").val());

    ////////////////////////////////////////////////////////////////	
	$("#agent_id").on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		else{getTLname(aid);}
	});	

 
    var score_setter = function(selected_score, total_score){
        return (selected_score/(total_score))*100.00;
    }

    $(".score_setter").change(function(){
        main_score = 0;

        $(".score_setter").each(function(i,v){
            if($(this).val() != ''){
                main_score = main_score + parseFloat($(this).val()); 
            }
        });

        $("#total_score").val(score_setter(main_score, total_score).toFixed(2));
        $("#total_score_count").val(main_score.toFixed(2));


         if ($('#rpm1').val() == '0' || $('#rpm2').val() == '0' || $('#rpm3').val() == '0' || $('#rpm4').val() == '0') {
        $('#total_score_count').val(0);
    }else{
        $('#total_score_count').val(main_score + '%');
    }
    
    });

	//=================================================================
	// for sentry
	//=================================================================
	$(".audit_check").change(function(){
		
		audit_result = true;

		$(".audit_check").each(function(i, v){
			if($(this).val()== 0) audit_result = false;
		});

		if(!audit_result) $("#audit_result").val("FAIL");
		else $("#audit_result").val("YES");
	});
	//==================================================================
	$("#form_audit_user").submit(function(e){
		$('#save_button').attr('disabled',true);
	});
</script>

<script>
///////////////////////// RPM Calculation ////////////////////////////
	function rpm_calc(){
		var score = 0;
		var totscore = 0;
		
		$('.rpm_point').each(function(index,element){
			var weightage = parseFloat($(element).children("option:selected").attr('rpm_val'));
			score = score + weightage;
		});
		totscore = score;

        $('#total_score').val(totscore+'%');

    ///////////////
		if($('#rpmAF1').val()=='0' || $('#rpmAF2').val()=='0' || $('#rpmAF3').val()=='0' || $('#rpmAF4').val()=='0'){
		    $('.rpmFatal').val(0+'%');
		}else{
			$('.rpmFatal').val(totscore+'%');
		}
		
	}
	
	$(document).ready(function(){
		$(document).on('change','.rpm_point',function(){
			rpm_calc();
		});
		rpm_calc();
	});
</script>