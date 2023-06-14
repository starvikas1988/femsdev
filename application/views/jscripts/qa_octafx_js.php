<script type="text/javascript">
	$(document).ready(function(){
			$('#call_date').on('change', function(){
			var call_date = Date.parse($("#call_date").val());
			var d = new Date(call_date);
			var date = d.getDate();
			var day = d.getDay();

			//var weekOfMonth = Math.ceil((date - 1 - day) / 7);
			var weekOfMonth = (0 | d.getDate() / 7)+1;
			console.log(weekOfMonth);
			$('#call_week').val(weekOfMonth);
			
		});

		var currentDate = new Date();
		var dateAudit = currentDate.getDate();
		var dayAudit = currentDate.getDay();

		//var weekOfMonthAudit = Math.ceil((dateAudit - 1 - dayAudit) / 7);
		var weekOfMonthAudit = (0 | currentDate.getDate() / 7)+1;
		console.log(weekOfMonthAudit);
		$('#audit_week').val(weekOfMonthAudit);	
	});
	

</script>

<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date()});
	$("#chat_date").datepicker();
	$("#mail_action_date").datepicker();
	$("#tat_replied_date").datepicker();
	$("#cycle_date").datepicker();
	$("#week_end_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#call_date_time").datetimepicker();
	// $("#from_date").datepicker();
	// $("#to_date").datepicker();
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });
	
	$(".agentName").select2();
	
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
	
/////////////////////////////////////////////////////////////////////
	



	$('#preparation').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent prepared adequately">Agent prepared adequately</option>';
			$("#preparation_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Agent did not prepare adequately">Agent did not prepare adequately</option>';
			$("#preparation_reason").html(opt2);
		}
	});
	$('#introduction').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent introduced OctaFX and themselves correctly">Agent introduced OctaFX and themselves correctly</option>';
			$("#introduction_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Agent did not introduce OctaFX and themselves correctly">Agent did not introduce OctaFX and themselves correctly</option>';
			$("#introduction_reason").html(opt2);
		}
	});
	$('#profiling').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent profiled the customer">Agent profiled the customer</option>';
			$("#profiling_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Agent did not profile the customer">Agent did not profile the customer</option>';
			$("#profiling_reason").html(opt2);
		}else if($(this).val()=='N/A'){
			var opt3 = '<option value="">Select</option>';
			opt3 += '<option ofx_val=5 ofx_max=5 value="Agent had no need to profile the customer">Agent had no need to profile the customer</option>';
			$("#profiling_reason").html(opt3);
		}
	});
	$('#delivary').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent delivered a sales pitch">Agent delivered a sales pitch</option>';
			$("#delivary_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Agent did not deliver a sales pitch">Agent did not deliver a sales pitch</option>';
			$("#delivary_reason").html(opt2);
		}else if($(this).val()=='N/A'){
			var opt3 = '<option value="">Select</option>';
			opt3 += '<option ofx_val=5 ofx_max=5 value="Agent did not have a chance to deliver sales pitch due to customer being ready to deposit">Agent did not have a chance to deliver sales pitch due to customer being ready to deposit</option>';
			$("#delivary_reason").html(opt3);
		}
	});
	$('#objection').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent successfully handled all objections">Agent successfully handled all objections</option>';
			opt1 += '<option ofx_val=3 ofx_max=5 value="Agent did not handle 1 or 2 objections well">Agent did not handle 1 or 2 objections well</option>';
			$("#objection_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Agent did not successfully handle any objections">Agent did not successfully handle any objections</option>';
			$("#objection_reason").html(opt2);
		}else if($(this).val()=='N/A'){
			var opt3 = '<option value="">Select</option>';
			opt3 += '<option ofx_val=5 ofx_max=5 value="No objection handling needed as customer was ready to deposit immediately">No objection handling needed as customer was ready to deposit immediately</option>';
			$("#objection_reason").html(opt3);
		}
	});
	$('#closing').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent assisted client to deposit successfully">Agent assisted client to deposit successfully</option>';
			opt1 += '<option ofx_val=3 ofx_max=5 value="Agent was not able to assist client to deposit successfully due to technical issues">Agent was not able to assist client to deposit successfully due to technical issues</option>';
			$("#closing_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Customer declining to deposit">Customer declining to deposit</option>';
			$("#closing_reason").html(opt2);
		}else if($(this).val()=='N/A'){
			var opt3 = '<option value="">Select</option>';
			opt3 += '<option ofx_val=5 ofx_max=5 value="Agent did not get the opportunity to assist the client to deposit">Agent did not get the opportunity to assist the client to deposit</option>';
			$("#closing_reason").html(opt3);
		}
	});
	$('#conclusion').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent concluded the call correctly">Agent concluded the call correctly</option>';
			$("#conclusion_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Agent did not conclude the call correctly">Agent did not conclude the call correctly</option>';
			$("#conclusion_reason").html(opt2);
		}
	});
	$('#follow_up').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="If email sent AND reminder made (as per requirement)">If email sent AND reminder made (as per requirement)</option>';
			$("#follow_up_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="If email not sent AND/OR call reminder in calendar not created (as per requirement)">If email not sent AND/OR call reminder in calendar not created (as per requirement)</option>';
			$("#follow_up_reason").html(opt2);
		}
	});
	$('#product_explanation').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=20 ofx_max=20 value="No mistakes">No mistakes</option>';
			opt1 += '<option ofx_val=15 ofx_max=20 value="One mistake">One mistake</option>';
			opt1 += '<option ofx_val=10 ofx_max=20 value="Two mistakes">Two mistakes</option>';
			opt1 += '<option ofx_val=5 ofx_max=20 value="Three mistakes">Three mistakes</option>';
			$("#product_explanation_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=20 value="Four or more mistakes">Four or more mistakes</option>';
			$("#product_explanation_reason").html(opt2);
		}
	});
	$('#rapport').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent built a friendly relationship with the customer">Agent built a friendly relationship with the customer</option>';
			$("#rapport_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Agent didnot build a friendly relationship with the customer">Agent didnot build a friendly relationship with the customer</option>';
			$("#rapport_reason").html(opt2);
		}
	});
	$('#clarity').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent spoke clearly for the duration of the call">Agent spoke clearly for the duration of the call</option>';
			$("#clarity_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Agent didnot speak clearly for the duration of the call">Agent didnot speak clearly for the duration of the call</option>';
			$("#clarity_reason").html(opt2);
		}
	});
	$('#enthusiasm').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent was enthusiastic for the duration of the call">Agent was enthusiastic for the duration of the call</option>';
			$("#enthusiasm_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Agent wasnot enthusiastic for the duration of the call">Agent wasnot enthusiastic for the duration of the call</option>';
			$("#enthusiasm_reason").html(opt2);
		}
	});
	$('#goal_driven').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=5 ofx_max=5 value="Agent was channeling the call to assist client to deposit">Agent was channeling the call to assist client to deposit</option>';
			$("#goal_driven_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=5 value="Agent was not focused on assisting the customer to deposit">Agent was not focused on assisting the customer to deposit</option>';
			$("#goal_driven_reason").html(opt2);
		}
	});
	$('#do_dont_call_ethicate').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=20 ofx_max=20 value="No mistakes">No mistakes</option>';
			opt1 += '<option ofx_val=15 ofx_max=20 value="One mistake">One mistake</option>';
			opt1 += '<option ofx_val=10 ofx_max=20 value="Two mistakes">Two mistakes</option>';
			opt1 += '<option ofx_val=5 ofx_max=20 value="Three mistakes">Three mistakes</option>';
			$("#do_dont_call_ethicate_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=20 value="Four or more mistakes">Four or more mistakes</option>';
			$("#do_dont_call_ethicate_reason").html(opt2);
		}
	});
	$('#trading_advice').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=0 ofx_max=0 value="NA">NA</option>';
			$("#trading_advice_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=0 value="Gave trading advice on call">Gave trading advice on call</option>';
			$("#trading_advice_reason").html(opt2);
		}
	});
	$('#profanity_rudeness').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=0 ofx_max=0 value="NA">NA</option>';
			$("#profanity_rudeness_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=0 value="Uesd profanity rudeness or sarcasm">Uesd profanity rudeness or sarcasm</option>';
			$("#profanity_rudeness_reason").html(opt2);
		}
	});
	$('#asking_details_payment_details').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=0 ofx_max=0 value="NA">NA</option>';
			$("#asking_details_payment_details_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=0 value="Asked details of payment option for example card details">Asked details of payment option for example card details</option>';
			$("#asking_details_payment_details_reason").html(opt2);
		}
	});
	$('#use_customer_info').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=0 ofx_max=0 value="NA">NA</option>';
			$("#use_customer_info_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=0 value="Using customers personal info for non official purpose">Using customers personal info for non official purpose</option>';
			$("#use_customer_info_reason").html(opt2);
		}
	});
	$('#false_commitment').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=0 ofx_max=0 value="NA">NA</option>';
			$("#false_commitment_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=0 value="False commitment/Mislead the client for deposit">False commitment/Mislead the client for deposit</option>';
			$("#false_commitment_reason").html(opt2);
		}
	});
	$('#login_client_trading').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=0 ofx_max=0 value="NA">NA</option>';
			$("#login_client_trading_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=0 value="Login to clients trading platform/personal area on behalf of the client">Login to clients trading platform/personal area on behalf of the client</option>';
			$("#login_client_trading_reason").html(opt2);
		}
	});
	$('#client_disposit_during_call').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=10 ofx_max=10 value="Client deposited during call">Client deposited during call</option>';
			$("#client_disposit_during_call_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=0 value="Client not deposited during call">Client not deposited during call</option>';
			$("#client_disposit_during_call_reason").html(opt2);
		}
	});
	$('#client_disposit_during_call_kpi').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=10 ofx_max=10 value="Client deposited during call above KPI">Client deposited during call above KPI</option>';
			$("#client_disposit_during_call_kpi_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=0 value="Client not deposited during call above KPI">Client not deposited during call above KPI</option>';
			$("#client_disposit_during_call_kpi_reason").html(opt2);
		}
	});
	$('#client_upload_document').on('change', function(){
		if($(this).val()=='Yes'){
			var opt1 = '<option value="">Select</option>';
			opt1 += '<option ofx_val=10 ofx_max=10 value="Client uploaded documents during call">Client uploaded documents during call</option>';
			$("#client_upload_document_reason").html(opt1);
		}else if($(this).val()=='No'){
			var opt2 = '<option value="">Select</option>';
			opt2 += '<option ofx_val=0 ofx_max=0 value="Client not uploaded documents during call">Client not uploaded documents during call</option>';
			$("#client_upload_document_reason").html(opt2);
		}
	});
	
});
</script>

<script type="text/javascript">
	$( "#agent_id" ).on('change' , function(){
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_octafx/getTenuarity';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				console.log(json_obj[0]);
				for (var i in json_obj){
					console.log(json_obj[i].tenure);
					$('#tenuarity').append($('#tenuarity').val(json_obj[i].tenure+' Days')); 
				} 
				//$('#tenure').append($('#tenure').val(json_obj[0].tenure+' Days')); 
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
</script>
<script type="text/javascript">
	
	function date_validation(val,type){
	// alert(val);
		$(".end_date_error").html("");
		$(".start_date_error").html("");
		if(type=='E'){
		var start_date=$("#from_date").val();
		//if(val<start_date)
		if(Date.parse(val) < Date.parse(start_date))
		{
			$(".end_date_error").html("To Date must be greater or equal to From Date");
			 $(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".blains-effect").attr("disabled",false);
			 $(".blains-effect").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
			
		}
		else{
			 $(".blains-effect").attr("disabled",false);
			 $(".blains-effect").css('cursor', 'pointer');
			}

		}
	}
</script>


<script>
$('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'mp4':
        case 'mp3':
		case 'wav':
		case 'm4a':
			$('#qaformsubmit').attr('disabled', false);
        break;
        default:
            alert('This is not an allowed file type. Please upload allowed file type like [m4a,mp4,mp3,wav]');
            this.value = '';
    }
});
</script>

<script type="text/javascript">
////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function(){
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_ameridial/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				//console.log(json_obj);
				$('#tl_names').empty().append($('#tl_names').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj){
					if($('#tl_names').val(json_obj[i].tl_name)!=''){
						//console.log(json_obj[0].tl_name);
						$('#tl_names').append($('#tl_names').val(json_obj[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
				} 	
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days')); 
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
</script>

<script type="text/javascript">
		function checkDec(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$("#qaformsubmit").attr("disabled", "disabled");
				$('#phone').val("");
				return false;
			}
			if(el.value.length >10){
       			//alert("required 10 digits, match requested format!");
       			$("#start_phone").html("Required 10 digits, match requested format!");
       			$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }else if(el.value.length <10){
		    	$("#start_phone").html("Phone number can not be less than 10 digits!");
		    	$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }
		    else if(el.value.length == 10){
		    	$("#start_phone").html("");
		    	 $("#qaformsubmit").removeAttr("disabled");
       			return false;
		    }
		    // else{
		    // 	$("#start_phone").html("");
		    // 	 $("#qaformsubmit").removeAttr("disabled");
		    // }
			console.log(el.value);
		}
</script> 
<script type="text/javascript">
	function checkDecConsumer(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$("#qaformsubmit").attr("disabled", "disabled");
				$('#consumer_no').val("");
				return false;
			}
			// if(el.value.length >25){
   //     			//alert("required 10 digits, match requested format!");
   //     			$("#start_phone").html("Consumer number can not be more than 25 digits!");
   //     			$("#qaformsubmit").attr("disabled", "disabled");
   //     			return false;
		 //    }
		    if(el.value.length < 1){
		    	$("#start_phone").html("Consumer number can not be a negative digits!");
		    	$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }
		    else{
		    	$("#start_phone").html("");
		    	 $("#qaformsubmit").removeAttr("disabled");
       			return false;
		    }
		    // else{
		    // 	$("#start_phone").html("");
		    // 	 $("#qaformsubmit").removeAttr("disabled");
		    // }
			console.log(el.value);
		}
</script>

<script type="text/javascript">
	function checkDecCallNo(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$("#qaformsubmit").attr("disabled", "disabled");
				$('#call_number').val("");
				return false;
			}
			
		    if(el.value.length < 1){
		    	$("#start_phone").html("Call number can not be a negative digits!");
		    	$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }
		    else{
		    	$("#start_phone").html("");
		    	 $("#qaformsubmit").removeAttr("disabled");
       			return false;
		    }
		   
			console.log(el.value);
		}
</script>

<script>
////////////////////// OCTA FX ////////////////////
	function octafx_calc(){
		//var overallScore = 0;
		
		var tot_score = 0;
		var earn = 0;
		var possible = 0;
		$('.octafx_point').each(function(index,element){
			var w1 = parseFloat($(element).children("option:selected").attr('ofx_val'));
			var w2 = parseFloat($(element).children("option:selected").attr('ofx_max'));
			earn = earn + w1;
			possible = possible + w2;
		});
		tot_score = ((earn*100)/possible).toFixed(2);
	///////////////
		/* var tot_score1 = 0;
		var earn1 = 0;
		var possible1 = 0;
		var call_earn = 0;
		var call_possible = 0;
		$('.octafx_point1').each(function(index,element){
			var w3 = parseFloat($(element).children("option:selected").attr('ofx_val'));
			var w4 = parseFloat($(element).children("option:selected").attr('ofx_max'));
			earn1 = earn1 + w3;
			possible1 = possible1 + w4;
		});
		tot_score1 = ((earn1*100)/possible1).toFixed(2);
		
		if($('.call_type1').val()=='Successful Deposit Call'){
			call_earn = earn1;
			call_possible = possible1;
		}else{
			call_earn = 0;
			call_possible = 0;
		}
		overallScore = (((earn+call_earn)*100)/(possible+call_possible)).toFixed(2);*/
		
		if(!isNaN(tot_score)){
			$('#octa_earned').val(earn);
			$('#octa_possible').val(possible);
			$('#octa_overall').val(tot_score+'%');
		}
		
		/* if(!isNaN(overallScore)){
			$('#octa_earned').val(earn+call_earn);
			$('#octa_possible').val(possible+call_possible);
			$('#octa_overall').val(overallScore+'%');
		} */

		if($('.octafxAF1').val()=='No' || $('.octafxAF2').val()=='No' || $('.octafxAF3').val()=='No' || $('.octafxAF4').val()=='No' || $('.octafxAF5').val()=='No' || $('.octafxAF6').val()=='No'){
		    $('.octafxFatal').val(0+'%');
		}else{
			$('.octafxFatal').val(tot_score+'%');
		}
	}
	
	$(document).ready(function(){
		$(document).on('change','.octafx_point',function(){
			octafx_calc();
		});
		$(document).on('change','.octafx_point1',function(){
			octafx_calc();
		});
		$(document).on('change','.octafxFatal',function(){
			octafx_calc();
		});
		octafx_calc();
	});

</script>

<script type="text/javascript">
		function octafx_outbound_calc(){
		//var overallScore = 0;

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0.00;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;

		
		// var tot_score = 0;
		// var earn = 0;
		// var possible = 0;
		// $('.octafx_outbound_point').each(function(index,element){
		// 	var w1 = parseFloat($(element).children("option:selected").attr('octafx_val'));
		// 	var w2 = parseFloat($(element).children("option:selected").attr('octafx_max'));
		// 	earn = earn + w1;
		// 	possible = possible + w2;
		// });

		$('.octafx_outbound_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('octafx_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('octafx_max'));
				score = score + w1;
				scoreable = scoreable + w2;

			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('octafx_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('octafx_max'));
				//score = score + w1;
				scoreable = scoreable + w2;
				//scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('octafx_val'));
				var w2 = parseInt($(element).children("option:selected").attr('octafx_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}
		});
		//tot_score = ((earn*100)/possible).toFixed(2);

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
	
		
		// if(!isNaN(tot_score)){
		// 	$('#octa_earned').val(earn);
		// 	$('#octa_possible').val(possible);
		// 	$('#octa_overall').val(tot_score+'%');
		// }

		if(quality_score_percent == "NaN"){
			quality_score_percent = (0.00).toFixed(2);
		}else{
			quality_score_percent = quality_score_percent;
		}

		$('#octa_earned').val(score);
		$('#octa_possible').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#octa_overall').val(quality_score_percent+'%');
		}

		if($('.octafxAF1').val()=='Fatal' || $('.octafxAF2').val()=='Fatal' || $('.octafxAF3').val()=='Fatal' || $('.octafxAF4').val()=='Fatal' || $('.octafxAF5').val()=='Fatal' || $('.octafxAF6').val()=='Fatal'){
		    $('.octafx_outbound_Fatal').val(0+'%');
		}else{
			$('.octafx_outbound_Fatal').val(quality_score_percent+'%');
			//$('.octafx_outbound_Fatal').val(tot_score+'%');
		}
	}

	$(document).ready(function(){
		$(document).on('change','.octafx_outbound_point',function(){
			octafx_outbound_calc();
		});
		
		octafx_outbound_calc();
	});
</script>

<script>
///////////////////////// Pinglend ////////////////////////////
	function pinglend_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.pnld_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('pl_id'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('pl_id'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('pl_id'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}

    ///////////////
		if($('#pnlAF1').val()=='No'){
		    $('.pinglendFatal').val(0.00+'%');
		}else{
			$('.pinglendFatal').val(quality_score_percent+'%');
		}
		
	}
	
	
	$(document).ready(function(){
		$(document).on('change','.pnld_point',function(){
			pinglend_calc();
		});
		pinglend_calc();
	});
</script>