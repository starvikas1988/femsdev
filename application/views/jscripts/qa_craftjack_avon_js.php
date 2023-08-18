<!-- AVON SCRIPT -->
<!-- Score Counter Script-->
<script src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<script src="<?php echo base_url() ?>assets/css/search-filter/js/chart.js"></script>

<script>
//     $(document).ready(function(e){
//     $('#batch_code').select2(); 
    
// });
$(function() {
    $('#multiselect').multiselect();
    $('.multiple-select').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
		numberDisplayed: 0,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Search for something...'
    });
});

</script>
<script type="text/javascript">
		$(function() {
		$( "#agent_id" ).on('change' , function() {
		var aid = this.value;
		//alert(aid);
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_ameridial/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
			
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));
				
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj){
					if($('#tl_name').val(json_obj[i].tl_name)!=''){
						console.log(json_obj[0].tl_name);
						$('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				}
				for (var i in json_obj){
					if($('#tl_names').val(json_obj[i].tl_name)!=''){
						console.log(json_obj[0].tl_name);
						$('#tl_names').append($('#tl_names').val(json_obj[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				}  
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){
				alert('Fail!');
			}
		});
	});
});
</script>

<script type="text/javascript">
	$( "#location" ).on('change' , function() {

		var aid = this.value;
		//console.log(aid);
		if(aid==""){
			alert("Please Select Location");
			$('#agent_ids').empty();
			$('#agent_ids').append($('#agent_ids').val());
			$('#fusion_id').empty();
			$('#fusion_id').append($('#fusion_id').val(''));
		}else{
			var URL='<?php echo base_url();?>Qa_craftjack/getAgentName';
			$('#sktPleaseWait').modal('show');
			$.ajax({
				type: 'POST',
				url:URL,
				data:'aid='+aid,
				success: function(aList){
					var json_obj = $.parseJSON(aList);
					$('#agent_ids').empty();
					$('#agent_ids').append($('#agent_ids').val());
					$('#agent_ids').append('<option value="">-Select-</option>');
					for (var i in json_obj) $('#agent_ids').append('<option value="'+json_obj[i].id+'">'+json_obj[i].name+"-("+json_obj[i].fusion_id+")"+'</option>');

					$('#sktPleaseWait').modal('hide');
				},
				error: function(){
					alert('Fail!');
				}
			});
		} 
		
	});
</script>

<script type="text/javascript">
	
		$(function() {
		$( "#agent_ids" ).on('change' , function() {
		var aid = this.value;
		//alert(aid);
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_ameridial/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
			
				$('#tl_names').empty();
				$('#tl_names').append($('#tl_names').val(''));
				
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj){
					if($('#tl_names').val(json_obj[i].tl_name)!=''){
						console.log(json_obj[0].tl_name);
						$('#tl_names').append($('#tl_names').val(json_obj[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				} 
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){
				alert('Fail!');
			}
		});
	});
});
</script>
<script type = "text/javascript">
   <!--
      // Form validation code will come here.
      function validate() {
      
         if( document.form_new_user.from_date.value == "" ) {
            alert( "Please provide From Date!" );
            document.form_new_user.from_date.focus() ;
            return false;
         }
         if( document.form_new_user.to_date.value == "" ) {
            alert( "Please provide To Date!" );
            document.form_new_user.to_date.focus() ;
            return false;
         }
         if( document.form_new_user.campaign.value == "" ) {
            alert( "Please provide LOB!" );
            document.form_new_user.campaign.focus() ;
            return false;
         }

         return( true );
      }
   //-->
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

<script>
	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date()}); //datetimepicker
	$("#call_date_time").datetimepicker({maxDate: new Date()});
	//$("#call_date").datepicker({ minDate: 0 });
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });


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


<script type="text/javascript">
	///////////////// Calibration - Auditor Type ///////////////////////	
	//$('.auType').hide();
	
	if($("#audit_type").val() == "Calibration"){
		$('.auType').show();
		$('#auditor_type').attr('required',true);
		$('#auditor_type').prop('disabled',false);
	}
	
	$('#audit_type').each(function(){
		$valdet=$(this).val();
		console.log($valdet);
		if($valdet=="Calibration"){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});

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

	///////////////////hcci core/////////////////

	$('#audit_type').each(function(){
		$valdet=$(this).val();
		if($valdet=="Calibration"){
			$('.auType_epi').show();
		}else{
			$('.auType_epi').hide();
		}
	});

	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType_epi').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			//alert(222);
			$('.auType_epi').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});
</script>
<script type="text/javascript">
	////////////inbound/outbound//////////////
	$('#type_of_call').each(function(){
		$valdet=$(this).val();
		if($valdet == ''){
			$('.ib_show').show();
			$('.ob_show').show();
		}
		if($valdet=="IB"){
			$('.ib_show').show();
			$('.ob_show').hide();
		}else if($valdet=="OB"){
			$('.ib_show').hide();
			$('.ob_show').show();
		 }
		 //else{
		// 	$('.ib_show').show();
		// 	$('.ob_show').show();
		// }
		
	});

	$('#type_of_call').on('change', function(){
		if($(this).val()=='IB'){
			$('.ib_show').show();
			$('#ib_show1').attr('required',true);
			$('#ib_show1').prop('disabled',false);

			$('#ib_show2').attr('required',true);
			$('#ib_show2').prop('disabled',false);

			$('.ob_show').hide();
			$('#ob_show1').attr('required',false);
			$('#ob_show1').prop('disabled',true);

			$('#ob_show2').attr('required',false);
			$('#ob_show2').prop('disabled',true);

			$('#ob_show3').attr('required',false);
			$('#ob_show3').prop('disabled',true);

			$('#ob_show4').attr('required',false);
			$('#ob_show4').prop('disabled',true);

		}else if($(this).val()=='OB'){
			//alert(222);
			$('.ib_show').hide();
			$('#ib_show1').attr('required',false);
			$('#ib_show1').prop('disabled',true);

			$('#ib_show2').attr('required',false);
			$('#ib_show2').prop('disabled',true);

			$('.ob_show').show();
			$('#ob_show1').attr('required',true);
			$('#ob_show1').prop('disabled',false);

			$('#ob_show2').attr('required',true);
			$('#ob_show2').prop('disabled',false);

			$('#ob_show3').attr('required',true);
			$('#ob_show3').prop('disabled',false);

			$('#ob_show4').attr('required',true);
			$('#ob_show4').prop('disabled',false);
		}else{
			$('.ib_show').show();
			$('.ob_show').show();

			$('#ib_show1').attr('required',false);
			$('#ib_show1').prop('disabled',true);

			$('#ob_show1').attr('required',false);
			$('#ob_show1').prop('disabled',true);

			$('#ob_show2').attr('required',false);
			$('#ob_show2').prop('disabled',true);

			$('#ob_show3').attr('required',false);
			$('#ob_show3').prop('disabled',true);

			$('#ob_show4').attr('required',false);
			$('#ob_show4').prop('disabled',true);
			craftjack_inbound_outbound_calcs();
		}
	});

</script>
<script type="text/javascript">
	
	$('#tl_id').on('click', function(){
		alert("Can not Change TL");
		$("#tl_id").attr('disabled','disabled');
		return false;
	});
</script>
<script type="text/javascript">
	function avon_calc(){
		var check_fatal=false;
			$(".avon_point").each(function(){
				if($(this).hasClass("avon_fatal") && ($(this).val()=="Fail") ){
					check_fatal=true;
					$("#avon_overall_score").val("0.00%");
				}
			});
			if(!check_fatal){
				//var earned_score = 0, possible_score=0, overall_score="";
				var earned_score = 0, possible_score=0, overall_score="", cust_earned=0, cust_possible=0, cust_overall=0;
			    var comp_earned=0, comp_possible=0, comp_overall=0, business_earned=0, business_possible=0, business_overall=0;
				$(".avon_point").each(function(index, element){
					if($(element).val()!="N/A" && $(element).val()!=""){
						var earned_weightage = parseFloat($(element).children("option:selected").attr('avon_val'));
						earned_score += earned_weightage;
						var weightage = parseFloat($(element).children("[value='Pass']").attr('avon_val'));
						possible_score += weightage;
						overall_score=parseFloat((earned_score/possible_score)*100);
						
						if($(this).hasClass("customer")){
							cust_earned+=earned_weightage;
							cust_possible+=weightage;
							//console.log(cust_earned);
							$("#customer_earned_score").val(cust_earned);
							$("#customer_possible_score").val(cust_possible);
							$("#customer_overall_score").val(parseFloat((cust_earned/cust_possible)*100).toFixed(2)+"%");
						}
						if($(this).hasClass("compliance")){
							comp_earned+=earned_weightage;
							comp_possible+=weightage;
							//console.log(comp_earned);
							$("#compliance_earned_score").val(comp_earned);
							$("#compliance_possible_score").val(comp_possible);
							$("#compliance_overall_score").val(parseFloat((comp_earned/comp_possible)*100).toFixed(2)+"%");
						}
						if($(this).hasClass("business")){
							business_earned+=earned_weightage;
							business_possible+=weightage;
							//console.log(business_earned);
							$("#business_earned_score").val(business_earned);
							$("#business_possible_score").val(business_possible);
							$("#business_overall_score").val(parseFloat((business_earned/business_possible)*100).toFixed(2)+"%");
						}

						$("#avon_overall_score").val(parseFloat((earned_score/possible_score)*100).toFixed(2)+"%");
						
					}
				});
			}
			if(!isNaN(earned_score)){
				$("#avon_earned_score").val(earned_score);
			}
			if(!isNaN(possible_score)){
				$("#avon_possible_score").val(possible_score);
			}
	}
</script>



////////////////vikas//////////////////////////////
 <script type="text/javascript">
 		function craftjack_inbound_outbound_calcs(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0.00;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.craftjack_inbound_outbound_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Pass'){
				pass_count = pass_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				score = score + w1;
				scoreable = scoreable + w2;

			}else if(score_type == 'Fail'){
				fail_count = fail_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				//score = score + w1;
				scoreable = scoreable + w2;
				//scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		if(quality_score_percent == "NaN"){
			quality_score_percent = (0.00).toFixed(2);
		}else{
			quality_score_percent = quality_score_percent;
		}
		
		$('#mtl_earned_score').val(score);
		$('#mtl_possible_score').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#mtl_overall_score').val(quality_score_percent+'%');
		}

		if($('#ib_ob_Fail1').val()=='Fail' || $('#ib_ob_Fail2').val()=='Fail' || $('#ib_ob_Fail3').val()=='Fail' || $('#ib_ob_Fail4').val()=='Fail'){
			quality_score_percent = (0.00).toFixed(2);
			$('.acgFatal').val(quality_score_percent+'%');
			//$('.phs_chatemail_v2Fatal').val(0.00).toFixed(2);
		}else{
			$('.mtl_overall_score').val(quality_score_percent+'%');
		}
	
		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Pass'){
				var w1 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'Fail'){
				var w1 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#customer_earned_score').val(customerScore);
		$('#customer_possible_score').val(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#customer_overall_score').val(customerPercentage+'%');
		}
	
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Pass'){
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'Fail'){
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#business_earned_score').val(businessScore);
		$('#business_possible_score').val(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#business_overall_score').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Pass'){
				var w3 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'Fail'){
				var w3 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#compliance_earned_score').val(complianceScore);
		$('#compliance_possible_score').val(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#compliance_overall_score').val(compliancePercentage+'%');
		}
		
		///////////////////////////////////////////////////////////////////////
	}

	///////////////////////////////////////////////////////////////////////
	function craftjack_inbound_outbound_ib_calcs(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0.00;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.craftjack_IB_OB_point_ib').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Pass'){
				pass_count = pass_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				score = score + w1;
				scoreable = scoreable + w2;

			}else if(score_type == 'Fail'){
				fail_count = fail_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				//score = score + w1;
				scoreable = scoreable + w2;
				//scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		if(quality_score_percent == "NaN"){
			quality_score_percent = (0.00).toFixed(2);
		}else{
			quality_score_percent = quality_score_percent;
		}
		
		$('#mtl_earned_score').val(score);
		$('#mtl_possible_score').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#mtl_overall_score').val(quality_score_percent+'%');
		}

		if($('#ib_ob_Fail1').val()=='Fail' || $('#ib_ob_Fail2').val()=='Fail' || $('#ib_ob_Fail3').val()=='Fail'){
			quality_score_percent = (0.00).toFixed(2);
			$('.acgFatal').val(quality_score_percent+'%');
			$('#autofail_status').val('Fail');
			//$('.phs_chatemail_v2Fatal').val(0.00).toFixed(2);
		}else{
			$('#autofail_status').val('Pass');
			$('.mtl_overall_score').val(quality_score_percent+'%');
		}
		$('#follow_up').val('20');
		$('#sr').val('40');
		$('#critical_error').val('30');
	
		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer_ib').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Pass'){
				var w1 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'Fail'){
				var w1 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#customer_earned_score').val(customerScore);
		$('#customer_possible_score').val(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#customer_overall_score').val(customerPercentage+'%');
		}
	
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business_ib').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Pass'){
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'Fail'){
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#business_earned_score').val(businessScore);
		$('#business_possible_score').val(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#business_overall_score').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance_ib').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Pass'){
				var w3 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'Fail'){
				var w3 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#compliance_earned_score').val(complianceScore);
		$('#compliance_possible_score').val(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#compliance_overall_score').val(compliancePercentage+'%');
		}
		
	}
	///////////////////////////////////////////////////////////////////////
	function craftjack_inbound_outbound_ob_calcs(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0.00;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.craftjack_IB_OB_point_ob').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Pass'){
				pass_count = pass_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				score = score + w1;
				scoreable = scoreable + w2;

			}else if(score_type == 'Fail'){
				fail_count = fail_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				//score = score + w1;
				scoreable = scoreable + w2;
				//scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		if(quality_score_percent == "NaN"){
			quality_score_percent = (0.00).toFixed(2);
		}else{
			quality_score_percent = quality_score_percent;
		}
		
		$('#mtl_earned_score').val(score);
		$('#mtl_possible_score').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#mtl_overall_score').val(quality_score_percent+'%');
		}

		if($('#ib_ob_Fail1').val()=='Fail' || $('#ib_ob_Fail2').val()=='Fail' || $('#ib_ob_Fail3').val()=='Fail' || $('#ib_ob_Fail4').val()=='Fail'){
			quality_score_percent = (0.00).toFixed(2);
			$('.acgFatal').val(quality_score_percent+'%');
			$('#autofail_status').val('Fail');
			//$('.phs_chatemail_v2Fatal').val(0.00).toFixed(2);
		}else{
			$('#autofail_status').val('Pass');
			$('.mtl_overall_score').val(quality_score_percent+'%');
		}

		$('#follow_up').val('25');
		$('#sr').val('45');
		$('#critical_error').val('40');
	
		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer_ob').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Pass'){
				var w1 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'Fail'){
				var w1 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#customer_earned_score').val(customerScore);
		$('#customer_possible_score').val(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#customer_overall_score').val(customerPercentage+'%');
		}
	
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business_ob').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Pass'){
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'Fail'){
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#business_earned_score').val(businessScore);
		$('#business_possible_score').val(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#business_overall_score').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance_ob').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Pass'){
				var w3 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'Fail'){
				var w3 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_max'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseFloat($(element).children("option:selected").attr('craftjack_inbound_outbound_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#compliance_earned_score').val(complianceScore);
		$('#compliance_possible_score').val(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#compliance_overall_score').val(compliancePercentage+'%');
		}
		
	}
	///////////////////////////////////////////////////////////////////////



	$('#type_of_call').on('change', function(){
		if($(this).val()=='IB'){
			$(document).on('change','.craftjack_IB_OB_point_ib',function(){
				craftjack_inbound_outbound_ib_calcs();
			});
			craftjack_inbound_outbound_ib_calcs();

		}else if($(this).val()=='OB'){
			$(document).on('change','.craftjack_IB_OB_point_ob',function(){
				craftjack_inbound_outbound_ob_calcs();
			});
			craftjack_inbound_outbound_ob_calcs();
			
		}else{
			//craftjack_inbound_outbound_calcs();
		}
	});

	if($("#type_of_call").val() == "IB"){
		$(document).on('change','.craftjack_IB_OB_point_ib',function(){
				craftjack_inbound_outbound_ib_calcs();
			});
		craftjack_inbound_outbound_ib_calcs();
	}else if($("#type_of_call").val() == "OB"){
		$(document).on('change','.craftjack_IB_OB_point_ob',function(){
				craftjack_inbound_outbound_ob_calcs();
			});
		craftjack_inbound_outbound_ob_calcs();
	}else{
		craftjack_inbound_outbound_calcs();
	}
	
	
 </script>


<script>
	//$( "#datepicker" ).datepicker({ minDate: 0});
//Edited By Samrat 30/9/21
	$(document).ready(function(){
		$("#from_date, #to_date, #call_date").datepicker();
		$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
		<?php if($this->uri->segment(2)=="qa_avon" && $this->uri->segment(4)=="0"){?>
			$("#avon_earned_score, #avon_possible_score").val("0");
		<?php }?>
	});
</script>
