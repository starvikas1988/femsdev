<script src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<script src="<?php echo base_url() ?>assets/css/search-filter/js/chart.js"></script>
<script type="text/javascript">
	"use strict";
		$(function() {
		$( "#agent_id" ).on('change' , function() {
		var aids = this.value;
		//alert(aid);
		if(aids=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_ameridial/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aids,
			success: function(aLists){
				var json_objs = $.parseJSON(aLists);
			
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));
				
				for (var i in json_objs) $('#tl_id').append($('#tl_id').val(json_objs[i].assigned_to));
				
				for (var i in json_objs){
					if($('#tl_name').val(json_objs[i].tl_name)!=''){
						console.log(json_objs[0].tl_name);
						$('#tl_name').append($('#tl_name').val(json_objs[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				}  
				for (var i in json_objs) $('#fusion_id').append($('#fusion_id').val(json_objs[i].fusion_id));
				for (var i in json_objs) $('#campaign').append($('#campaign').val(json_objs[i].process_name));
				for (var i in json_objs) $('#office_id').append($('#office_id').val(json_objs[i].office_id));
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
	console.log("okk");
	$(document).ready(function(){
		//////////////////////////////////////////////
		/////////////////// VRS (Right party v2) ////////////////
		//////////////////////////////////////////////
		function vrs_right_party_copy_v2_calc(){
			var opening_score = 0;
			var effort_score = 0;
			var negotiation_score = 0;
			var compliance_score = 0;
			var pscript_score = 0;
			var callcontrol_score = 0;
			var softskill_score = 0;
			var closing_score = 0;
			var document_score = 0;
			var overallScr = 0;
			
			$('.opening_score').each(function(index,element){
				var score_type1 = $(element).val();
				if(score_type1 == 'Yes' || score_type1 == 'N/A'){
					var weightage1 = parseFloat($(element).children("option:selected").attr('o_val'));
					opening_score = opening_score + weightage1;
				}else if(score_type1 == 'No'){
					var weightage1 = parseFloat($(element).children("option:selected").attr('o_val'));
					opening_score = opening_score + weightage1;
				}
			});
			
			if($('#o_fatal1').val()=='No' || $('#o_fatal2').val()=='No' || $('#o_fatal3').val()=='No' || $('#o_fatal4').val()=='No' || $('#o_fatal5').val()=='No' || $('#o_fatal6').val()=='No' || $('#o_fatal7').val()=='No'){
				$('#totalOpening').val(0);
			}else{
				$('#totalOpening').val(opening_score.toFixed(2));
			}
		 ///////////
			$('.effort_score').each(function(index,element){
				var score_type2 = $(element).val();
				if(score_type2 == 'Yes' || score_type2 == 'N/A'){
					var weightage2 = parseFloat($(element).children("option:selected").attr('e_val'));
					effort_score = effort_score + weightage2;
				}else if(score_type2 == 'No'){
					var weightage2 = parseFloat($(element).children("option:selected").attr('e_val'));
					effort_score = effort_score + weightage2;
				}
			});
			$('#totalEffort').val(effort_score.toFixed(2));
		 ////////
			$('.negotiation_score').each(function(index,element){
				var score_type3 = $(element).val();
				if(score_type3 == 'Yes' || score_type3 == 'N/A'){
					var weightage3 = parseFloat($(element).children("option:selected").attr('n_val'));
					negotiation_score = negotiation_score + weightage3;
				}else if(score_type3 == 'No'){
					var weightage3 = parseFloat($(element).children("option:selected").attr('n_val'));
					negotiation_score = negotiation_score + weightage3;
				}
			});
			$('#totalNegotiation').val(negotiation_score.toFixed(2));
		 ////////
			$('.compliance_score').each(function(index,element){
				var score_type4 = $(element).val();
				if(score_type4 == 'Yes' || score_type4 == 'N/A'){
					var weightage4 = parseFloat($(element).children("option:selected").attr('c_val'));
					compliance_score = compliance_score + weightage4;
				}else if(score_type4 == 'No'){
					var weightage4 = parseFloat($(element).children("option:selected").attr('c_val'));
					compliance_score = compliance_score + weightage4;
				}
			});
			//total_compliance_score = parseInt(compliance_score);
			$('#totalCompliance').val(compliance_score.toFixed(2));
			//console.log(total_compliance_score);
			
			if($('#c_fatal1').val()=='No' || $('#c_fatal2').val()=='No' || $('#c_fatal3').val()=='No' || $('#c_fatal4').val()=='No' || $('#c_fatal5').val()=='No' || $('#c_fatal6').val()=='No' || $('#c_fatal7').val()=='No' || $('#c_fatal8').val()=='No' || $('#c_fatal9').val()=='No' || $('#c_fatal10').val()=='No' || $('#c_fatal11').val()=='No' || $('#c_fatal12').val()=='No' || $('#c_fatal13').val()=='No' || $('#c_fatal14').val()=='No' || $('#c_fatal15').val()=='No' || $('#c_fatal16').val()=='No'){
				$('#totalCompliance').val(0);	
			}else{
				$('#totalCompliance').val(total_compliance_score);
			}
		 ////////
			$('.pscript_score').each(function(index,element){
				var score_type5 = $(element).val();
				if(score_type5 == 'Yes' || score_type5 == 'N/A'){
					var weightage5 = parseFloat($(element).children("option:selected").attr('ps_val'));
					pscript_score = pscript_score + weightage5;
				}else if(score_type5 == 'No'){
					var weightage5 = parseFloat($(element).children("option:selected").attr('ps_val'));
					pscript_score = pscript_score + weightage5;
				}
			});
			
			if($('#ps_fatal1').val()=='No'){
				$('#totalPaymentScript').val(0);
			}else{
				$('#totalPaymentScript').val(pscript_score.toFixed(2));
			}
		 ////////
			$('.callcontrol_score').each(function(index,element){
				var score_type6 = $(element).val();
				if(score_type6 == 'Yes' || score_type6 == 'N/A'){
					var weightage6 = parseFloat($(element).children("option:selected").attr('cc_val'));
					callcontrol_score = callcontrol_score + weightage6;
				}else if(score_type6 == 'No'){
					var weightage6 = parseFloat($(element).children("option:selected").attr('cc_val'));
					callcontrol_score = callcontrol_score + weightage6;
				}
			});
			$('#totalCallControl').val(callcontrol_score.toFixed(2));
		 ////////
		 $('.softskill_score').each(function(index,element){
				var score_type9 = $(element).val();
				//console.log(score_type9);
				if(score_type9 == 'Yes' || score_type9 == 'N/A'){
					var weightage9 = parseFloat($(element).children("option:selected").attr('ss_val'));
					softskill_score = softskill_score + weightage9;
				}else if(score_type9 == 'No'){
					var weightage9 = parseFloat($(element).children("option:selected").attr('ss_val'));
					softskill_score = softskill_score + weightage9;
				}
			});
		 //console.log(softskill_score);
		 //total_softskill_score= parseInt(softskill_score);
			//$('#totalSoftskill').val(total_softskill_score);
			$('#totalSoftskill').val(softskill_score.toFixed(2));
			///////////////////////////
			$('.closing_score').each(function(index,element){
				var score_type7 = $(element).val();
				if(score_type7 == 'Yes' || score_type7 == 'N/A'){
					var weightage7 = parseFloat($(element).children("option:selected").attr('cl_val'));
					closing_score = closing_score + weightage7;
				}else if(score_type7 == 'No'){
					var weightage7 = parseFloat($(element).children("option:selected").attr('cl_val'));
					closing_score = closing_score + weightage7;
				}
			});
			$('#totalClosing').val(closing_score.toFixed(2));
		
			
		 ////////
			$('.document_score').each(function(index,element){
				var score_type8 = $(element).val();
				if(score_type8 == 'Yes' || score_type8 == 'N/A'){
					var weightage8 = parseFloat($(element).children("option:selected").attr('d_val'));
					document_score = document_score + weightage8;
				}else if(score_type8 == 'No'){
					var weightage8 = parseFloat($(element).children("option:selected").attr('d_val'));
					document_score = document_score + weightage8;
				}
			});
			
			if($('#d_fatal1').val()=='No' || $('#d_fatal2').val()=='No' || $('#d_fatal3').val()=='No' || $('#d_fatal4').val()=='No' || $('#d_fatal5').val()=='No'){
				$('#totalDocument').val(0);
			}else{
				$('#totalDocument').val(document_score.toFixed(2));
			}
		 /////////////////////
			overallScr = parseInt((opening_score+effort_score+negotiation_score+compliance_score+pscript_score+callcontrol_score+softskill_score+closing_score+document_score));
			if(!isNaN(overallScr)){
				$('#right_party_v2_overall_score').val(overallScr+'%');
			}
			
			if($('#o_fatal1').val()=='No' || $('#o_fatal2').val()=='No' || $('#o_fatal3').val()=='No' || $('#o_fatal4').val()=='No' || $('#o_fatal5').val()=='No' || $('#o_fatal6').val()=='No' || $('#o_fatal7').val()=='No' || $('#c_fatal1').val()=='No' || $('#c_fatal2').val()=='No' || $('#c_fatal3').val()=='No' || $('#c_fatal4').val()=='No' || $('#c_fatal5').val()=='No' || $('#c_fatal6').val()=='No' || $('#c_fatal7').val()=='No' || $('#c_fatal8').val()=='No' || $('#c_fatal9').val()=='No' || $('#c_fatal10').val()=='No' || $('#c_fatal11').val()=='No' || $('#c_fatal12').val()=='No' || $('#c_fatal13').val()=='No' || $('#c_fatal14').val()=='No' || $('#c_fatal15').val()=='No' || $('#c_fatal16').val()=='No' || $('#ps_fatal1').val()=='No' || $('#ps_fatal2').val()=='No' || $('#d_fatal1').val()=='No' || $('#d_fatal2').val()=='No' || $('#d_fatal3').val()=='No' || $('#d_fatal4').val()=='No' || $('#d_fatal5').val()=='No')
			{
				$('#right_party_v2_overall_score').val(0);
			}
			else
			{
				$('#right_party_v2_overall_score').val(overallScr+'%');
			}
			
		 /////////////////////	
		}

		function vrs_right_party_v2_calc(){
			var opening_score = 0;
			var effort_score = 0;
			var negotiation_score = 0;
			var compliance_score = 0;
			var pscript_score = 0;
			var callcontrol_score = 0;
			var softskill_score = 0;
			var closing_score = 0;
			var document_score = 0;
			var overallScr = 0;
			
			$('.opening_score').each(function(index,element){
				var score_type1 = $(element).val();
				if(score_type1 == 'Yes' || score_type1 == 'N/A'){
					var weightage1 = parseFloat($(element).children("option:selected").attr('o_val'));
					opening_score = opening_score + weightage1;
				}else if(score_type1 == 'No'){
					var weightage1 = parseFloat($(element).children("option:selected").attr('o_val'));
					opening_score = opening_score + weightage1;
				}
			});
			
			if($('#o_fatal1').val()=='No' || $('#o_fatal2').val()=='No' || $('#o_fatal3').val()=='No' || $('#o_fatal4').val()=='No' || $('#o_fatal5').val()=='No' || $('#o_fatal6').val()=='No' || $('#o_fatal7').val()=='No'){
				$('#totalOpening').val(0);
			}else{
				$('#totalOpening').val(opening_score.toFixed(2));
			}
		 ///////////
			$('.effort_score').each(function(index,element){
				var score_type2 = $(element).val();
				if(score_type2 == 'Yes' || score_type2 == 'N/A'){
					var weightage2 = parseFloat($(element).children("option:selected").attr('e_val'));
					effort_score = effort_score + weightage2;
				}else if(score_type2 == 'No'){
					var weightage2 = parseFloat($(element).children("option:selected").attr('e_val'));
					effort_score = effort_score + weightage2;
				}
			});
			$('#totalEffort').val(effort_score.toFixed(2));
		 ////////
			$('.negotiation_score').each(function(index,element){
				var score_type3 = $(element).val();
				if(score_type3 == 'Yes' || score_type3 == 'N/A'){
					var weightage3 = parseFloat($(element).children("option:selected").attr('n_val'));
					negotiation_score = negotiation_score + weightage3;
				}else if(score_type3 == 'No'){
					var weightage3 = parseFloat($(element).children("option:selected").attr('n_val'));
					negotiation_score = negotiation_score + weightage3;
				}
			});
			$('#totalNegotiation').val(negotiation_score.toFixed(2));
		 ////////
			$('.compliance_score').each(function(index,element){
				var score_type4 = $(element).val();
				if(score_type4 == 'Yes' || score_type4 == 'N/A'){
					var weightage4 = parseFloat($(element).children("option:selected").attr('c_val'));
					compliance_score = compliance_score + weightage4;
				}else if(score_type4 == 'No'){
					var weightage4 = parseFloat($(element).children("option:selected").attr('c_val'));
					compliance_score = compliance_score + weightage4;
				}
			});
			total_compliance_score = parseInt(compliance_score);
			//console.log(total_compliance_score);
			
			if($('#c_fatal1').val()=='No' || $('#c_fatal2').val()=='No' || $('#c_fatal3').val()=='No' || $('#c_fatal4').val()=='No' || $('#c_fatal5').val()=='No' || $('#c_fatal6').val()=='No' || $('#c_fatal7').val()=='No' || $('#c_fatal8').val()=='No' || $('#c_fatal9').val()=='No' || $('#c_fatal10').val()=='No' || $('#c_fatal11').val()=='No' || $('#c_fatal12').val()=='No' || $('#c_fatal13').val()=='No' || $('#c_fatal14').val()=='No' || $('#c_fatal15').val()=='No' || $('#c_fatal16').val()=='No'){
				$('#totalCompliance').val(0);	
			}else{
				$('#totalCompliance').val(total_compliance_score);
			}
		 ////////
			$('.pscript_score').each(function(index,element){
				var score_type5 = $(element).val();
				if(score_type5 == 'Yes' || score_type5 == 'N/A'){
					var weightage5 = parseFloat($(element).children("option:selected").attr('ps_val'));
					pscript_score = pscript_score + weightage5;
				}else if(score_type5 == 'No'){
					var weightage5 = parseFloat($(element).children("option:selected").attr('ps_val'));
					pscript_score = pscript_score + weightage5;
				}
			});
			
			if($('#ps_fatal1').val()=='No'){
				$('#totalPaymentScript').val(0);
			}else{
				$('#totalPaymentScript').val(pscript_score.toFixed(2));
			}
		 ////////
			$('.callcontrol_score').each(function(index,element){
				var score_type6 = $(element).val();
				if(score_type6 == 'Yes' || score_type6 == 'N/A'){
					var weightage6 = parseFloat($(element).children("option:selected").attr('cc_val'));
					callcontrol_score = callcontrol_score + weightage6;
				}else if(score_type6 == 'No'){
					var weightage6 = parseFloat($(element).children("option:selected").attr('cc_val'));
					callcontrol_score = callcontrol_score + weightage6;
				}
			});
			$('#totalCallControl').val(callcontrol_score.toFixed(2));
		 ////////
		 $('.softskill_score').each(function(index,element){
				var score_type9 = $(element).val();
				//console.log(score_type9);
				if(score_type9 == 'Yes' || score_type9 == 'N/A'){
					var weightage9 = parseFloat($(element).children("option:selected").attr('ss_val'));
					softskill_score = softskill_score + weightage9;
				}else if(score_type9 == 'No'){
					var weightage9 = parseFloat($(element).children("option:selected").attr('ss_val'));
					softskill_score = softskill_score + weightage9;
				}
			});
		 //console.log(softskill_score);
		 total_softskill_score= parseInt(softskill_score);
			$('#totalSoftskill').val(total_softskill_score);
			///////////////////////////
			$('.closing_score').each(function(index,element){
				var score_type7 = $(element).val();
				if(score_type7 == 'Yes' || score_type7 == 'N/A'){
					var weightage7 = parseFloat($(element).children("option:selected").attr('cl_val'));
					closing_score = closing_score + weightage7;
				}else if(score_type7 == 'No'){
					var weightage7 = parseFloat($(element).children("option:selected").attr('cl_val'));
					closing_score = closing_score + weightage7;
				}
			});
			$('#totalClosing').val(closing_score.toFixed(2));
		
			
		 ////////
			$('.document_score').each(function(index,element){
				var score_type8 = $(element).val();
				if(score_type8 == 'Yes' || score_type8 == 'N/A'){
					var weightage8 = parseFloat($(element).children("option:selected").attr('d_val'));
					document_score = document_score + weightage8;
				}else if(score_type8 == 'No'){
					var weightage8 = parseFloat($(element).children("option:selected").attr('d_val'));
					document_score = document_score + weightage8;
				}
			});
			
			if($('#d_fatal1').val()=='No' || $('#d_fatal2').val()=='No' || $('#d_fatal3').val()=='No' || $('#d_fatal4').val()=='No' || $('#d_fatal5').val()=='No'){
				$('#totalDocument').val(0);
			}else{
				$('#totalDocument').val(document_score.toFixed(2));
			}
		 /////////////////////
			overallScr = parseInt((opening_score+effort_score+negotiation_score+compliance_score+pscript_score+callcontrol_score+softskill_score+closing_score+document_score));
			if(!isNaN(overallScr)){
				$('#right_party_v2_overall_score').val(overallScr+'%');
			}
			
			if($('#o_fatal1').val()=='No' || $('#o_fatal2').val()=='No' || $('#o_fatal3').val()=='No' || $('#o_fatal4').val()=='No' || $('#o_fatal5').val()=='No' || $('#o_fatal6').val()=='No' || $('#o_fatal7').val()=='No' || $('#c_fatal1').val()=='No' || $('#c_fatal2').val()=='No' || $('#c_fatal3').val()=='No' || $('#c_fatal4').val()=='No' || $('#c_fatal5').val()=='No' || $('#c_fatal6').val()=='No' || $('#c_fatal7').val()=='No' || $('#c_fatal8').val()=='No' || $('#c_fatal9').val()=='No' || $('#c_fatal10').val()=='No' || $('#c_fatal11').val()=='No' || $('#c_fatal12').val()=='No' || $('#c_fatal13').val()=='No' || $('#c_fatal14').val()=='No' || $('#c_fatal15').val()=='No' || $('#c_fatal16').val()=='No' || $('#ps_fatal1').val()=='No' || $('#ps_fatal2').val()=='No' || $('#d_fatal1').val()=='No' || $('#d_fatal2').val()=='No' || $('#d_fatal3').val()=='No' || $('#d_fatal4').val()=='No' || $('#d_fatal5').val()=='No')
			{
				$('#right_party_v2_overall_score').val(0);
			}
			else
			{
				$('#right_party_v2_overall_score').val(overallScr+'%');
			}
			
		 /////////////////////	
		}
		
		
		
		$(document).on('change','.opening_score',function(){ vrs_right_party_copy_v2_calc(); });
		$(document).on('change','.effort_score',function(){ vrs_right_party_copy_v2_calc(); });
		$(document).on('change','.negotiation_score',function(){ vrs_right_party_copy_v2_calc(); });
		$(document).on('change','.compliance_score',function(){ vrs_right_party_copy_v2_calc(); });
		$(document).on('change','.pscript_score',function(){ vrs_right_party_copy_v2_calc(); });
		$(document).on('change','.callcontrol_score',function(){ vrs_right_party_copy_v2_calc(); });
		$(document).on('change','.softskill_score',function(){ vrs_right_party_copy_v2_calc(); });
		$(document).on('change','.closing_score',function(){ vrs_right_party_copy_v2_calc(); });
		$(document).on('change','.document_score',function(){ vrs_right_party_copy_v2_calc(); });
		vrs_right_party_v2_calc();	
		//vrs_right_party_copy_v2_calc();
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

		///////////////////////////////////////
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
	///////////////// ACPT ///////////////////////
	$('.acptoth').hide();
	
	$('#acpt').on('change', function(){
		if($(this).val()=='Agent'){
			var agentAcpt = '<option value="">Select</option>';
			agentAcpt += '<option value="No probing">No probing</option>';
			agentAcpt += '<option value="No Urgency">No Urgency</option>';
			agentAcpt += '<option value="No good faith payment">No good faith payment</option>';
			agentAcpt += '<option value="No Negotiation">No Negotiation</option>';
			agentAcpt += '<option value="No PDC">No PDC</option>';
			agentAcpt += '<option value="No follow up">No follow up</option>';
			agentAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(agentAcpt);
		}else if($(this).val()=='Customer'){
			var customerAcpt = '<option value="">Select</option>';
			customerAcpt += '<option value="Verbal Dispute">Verbal Dispute</option>';
			customerAcpt += '<option value="Refused to pay">Refused to pay</option>';
			customerAcpt += '<option value="Bankruptcy">Bankruptcy</option>';
			customerAcpt += '<option value="Attorney handling">Attorney handling</option>';
			customerAcpt += '<option value="CONSUMER CREDIT COUNSELING">CONSUMER CREDIT COUNSELING</option>';
			customerAcpt += '<option value="DOCUMENTS VALIDATE THE DEBT">DOCUMENTS VALIDATE THE DEBT</option>';
			customerAcpt += '<option value="Refused to pay  processing fees">Refused to pay  processing fees</option>';
			customerAcpt += '<option value="Refused to make the payment over the phone">Refused to make the payment over the phone</option>';
			customerAcpt += '<option value="RP driving">RP driving</option>';
			customerAcpt += '<option value="RP at POE">RP at POE</option>';
			customerAcpt += '<option value="CEASE ALL COMMUNICATION">CEASE ALL COMMUNICATION</option>';
			customerAcpt += '<option value="Does not speak english">Does not speak english</option>';
			customerAcpt += '<option value="DECEASED PENDING VERIFICATION">DECEASED PENDING VERIFICATION</option>';
			customerAcpt += '<option value="DO NOT CALL">DO NOT CALL</option>';
			customerAcpt += '<option value="FRAUD INVESTIGATION">FRAUD INVESTIGATION</option>';
			customerAcpt += '<option value="Identity theft">Identity theft</option>';
			customerAcpt += '<option value="ACTIVE ACCOUNT">ACTIVE ACCOUNT</option>';
			customerAcpt += '<option value="RETURNED CHECK">RETURNED CHECK</option>';
			customerAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(customerAcpt);
		}else if($(this).val()=='Process'){
			var processAcpt = '<option value="">Select</option>';
			processAcpt += '<option value="Dealership">Dealership</option>';
			processAcpt += '<option value="Letter sent to different address">Letter sent to different address</option>';
			processAcpt += '<option value="Waiver">Waiver</option>';
			processAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(processAcpt);
		}else if($(this).val()=='Technology'){
			var techAcpt = '<option value="">Select</option>';
			techAcpt += '<option value="call disconnected">call disconnected</option>';
			techAcpt += '<option value="connection barred">connection barred</option>';
			techAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(techAcpt);
		}else if($(this).val()==''){
			$("#acpt_option").html('<option value="">Select</option>');
		}
	});
	
	$('#acpt_option').on('change', function(){
		if($(this).val()=='Others'){
			$('.acptoth').show();
			$('#acpt_other').attr('required',true).attr("placeholder", "Type here");
		}else{
			$('.acptoth').hide();
			$('#acpt_other').attr('required',false);
			$('#acpt_other').val('');
		}
	});
</script>