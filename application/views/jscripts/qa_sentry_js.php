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
});	
	
/////////////////////////////////////////////////////////////////////
	
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
	$(document).ready(function () {
	  var start_date	=	$("#from_date").val();
	  var end_date		=	$("#to_date").val();
	  if(start_date == '' && end_date == ''){
		  	$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	  if(end_date == ''){
	  		$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	  if(start_date == ''){
	  		$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
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
		if(start_date!=''){
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

		}else{
				 $(".blains-effect").attr("disabled",true);
				 $(".blains-effect").css('cursor', 'no-drop');
		}
		
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(end_date!=''){
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
		}else{
			$(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
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

 <script type="text/javascript">
 		function sentry_credit_calcs(){
		let score_park = 0;
		let scoreable_park = 0;
		let quality_score_percent_park = 0.00;
		let pass_count_park = 0;
		let fail_count_park = 0;
		let na_count_park = 0;
		let score_park_final = 0;
		let scoreable_park_final = 0;

		$('.sentry_credit_point').each(function(index,element){
			let score_type_park = $(element).val();
			
			if(score_type_park == 'Yes'){
				pass_count_park = pass_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('sentry_credit_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('sentry_credit_max'));
				
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;

			}else if(score_type_park == 'No'){
				fail_count_park = fail_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('sentry_credit_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('sentry_credit_max'));

				//score = score + w1;
				scoreable_park = scoreable_park + w2_park;
				//scoreable = scoreable + weightage;
			}else if(score_type_park == 'NA'){
				na_count_park = na_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('sentry_credit_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('sentry_credit_max'));
				
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;
			}
		});
		score_park = Math.round(score_park);
		scoreable_park = Math.round(scoreable_park);
		quality_score_percent_park = ((score_park*100)/scoreable_park).toFixed(2);

		if(quality_score_percent_park == "NaN"){
			quality_score_percent_park = (0.00).toFixed(2);
		}else{
			quality_score_percent_park = quality_score_percent_park;
		}
		
      score_park_final     = (score_park).toFixed(2);
      scoreable_park_final = (scoreable_park).toFixed(2);
      //console.log(score_park_final);
      //console.log(scoreable_park_final);

		
		//console.log(quality_score_percent_park);

		$('#sentry_credit_earned').val(score_park_final);
		$('#sentry_credit_possible').val(scoreable_park_final);

		// if(quality_score_percent_park == '100.00'){
		// 	//console.log("okk");
		// 	score_park_final = Math.round(score_park_final);
		// 	scoreable_park_final = Math.round(scoreable_park_final);
		// 	$('#sentry_credit_earned').val(score_park_final);
		//     $('#sentry_credit_possible').val(scoreable_park_final);
		// }else{
		// 	$('#sentry_credit_earned').val(score_park_final);
		// 	scoreable_park_final = Math.round(scoreable_park_final);
		//     $('#sentry_credit_possible').val(scoreable_park_final);
		// }
		
		if(!isNaN(quality_score_percent_park)){
			$('#sentry_credit_overall').val(quality_score_percent_park+'%');
		}

		if($('#sentry_Fatal1').val()=='No' || $('#sentry_Fatal2').val()=='No' || $('#sentry_Fatal3').val()=='No' || $('#sentry_Fatal4').val()=='No' || $('#sentry_Fatal5').val()=='No' || $('#sentry_Fatal6').val()=='No' || $('#sentry_Fatal7').val()=='No' || $('#sentry_Fatal8').val()=='No'){
			//console.log($('#sentry_FatalF1').val());

			quality_score_percent_park = (0.00).toFixed(2);
			$('.sentry_creditFatal').val(quality_score_percent_park+'%');
		}else{
			$('#sentry_credit_overall').val(quality_score_percent_park+'%');
		}
	}
	
	$(document).on('change','.sentry_credit_point',function(){
		sentry_credit_calcs();
	});
	sentry_credit_calcs();
</script>
