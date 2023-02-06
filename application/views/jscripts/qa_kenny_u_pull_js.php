<script>
////////////// Doubtnut (call audit)///////////////////
	function dn_calculation(){
		var quality_score_percent = 0;
		var dnIntroVal = 0;
		var dnStdQlVal = 0;
		var dnNeedAlVal = 0;
		var dnProductVal = 0;
		var dnObjectVal = 0;
		var dnPriceVal = 0;
		var dnClosingVal = 0;
		var dnUrjencyVal = 0;
		var dnPrdVal = 0;
		var dnPaymentVal = 0;
		var dnHandleVal = 0;
		var dnCloseVal = 0;
		
	///////Introduction///////
		var fail_count1 = 0;
		$('.dnt_intro').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='No'){
				fail_count1 = fail_count1 + 1;
			}
		});
		if(fail_count1>=1){
			dnIntroVal=0;
		}else{
			dnIntroVal=5;
		}
		$('#dnIntroVal').text(dnIntroVal);
	///////Student Qualification///////
		var fatal_count1 = 0;
		$('.dnt_student').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='Fatal'){
				fatal_count1 = fatal_count1 + 1;
			}
		});
		if(fatal_count1>=3){
			dnStdQlVal=0;
		}else{
			dnStdQlVal=15;
		}
		$('#dnStdQlVal').text(dnStdQlVal);
	////////Need Analysis/////////
		if($('.dnt_need').val()=='Fatal'){
			dnNeedAlVal = 0;
		}else{
			dnNeedAlVal = 15;
		}
		$('#dnNeedAlVal').text(dnNeedAlVal);
	/////////Product//////////
		var fatal_count2 = 0
		$('.dnt_product').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='Fatal'){
				fatal_count2 = fatal_count2 + 1;
			}
		});
		if(fatal_count2>=1){
			dnProductVal=0;
		}else{
			dnProductVal=15;
		}
		$('#dnProductVal').text(dnProductVal);
	///////Pricing & Payment//////
		var fatal_count3 = 0;
		$('.dnt_price').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='Fatal'){
				fatal_count3 = fatal_count3 + 1;
			}
		});
		if(fatal_count3>=1){
			dnPriceVal=0;
		}else{
			dnPriceVal=5;
		}
		$('#dnPriceVal').text(dnPriceVal);
	///////Objection Handling//////
		var fail_count2 = 0;
		$('.dnt_object').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='No'){
				fail_count2 = fail_count2 + 1;
			}
		});
		if(fail_count2>=1){
			dnObjectVal=0;
		}else{
			dnObjectVal=10;
		}
		$('#dnObjectVal').text(dnObjectVal);
	///////Closing/ Urgency//////
		var fail_count3 = 0;
		$('.dnt_closing').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='No'){
				fail_count3 = fail_count3 + 1;
			}
		});
		if(fail_count3>=1){
			dnClosingVal=0;
		}else{
			dnClosingVal=5;
		}
		$('#dnClosingVal').text(dnClosingVal);
	////////Introduction - Segment2/////////
		if($('.dnt_urjency').val()=='No'){
			dnUrjencyVal = 0;
		}else{
			dnUrjencyVal = 5;
		}
		$('#dnUrjencyVal').text(dnUrjencyVal);
	///////Product - Segment2//////
		var fail_count4 = 0;
		$('.dnt_prd').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='No'){
				fail_count4 = fail_count4 + 1;
			}
		});
		if(fail_count4>=1){
			dnPrdVal=0;
		}else{
			dnPrdVal=10;
		}
		$('#dnPrdVal').text(dnPrdVal);
	///////Pricing & Payment//////
		fail_count5 = 0;
		$('.dnt_payment').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='No'){
				fail_count5 = fail_count5 + 1;
			}
		});
		if(fail_count5>=1){
			dnPaymentVal=0;
		}else{
			dnPaymentVal=5;
		}
		$('#dnPaymentVal').text(dnPaymentVal);
	///////Objection Handling//////
		var fail_count6 = 0;
		$('.dnt_handle').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='No'){
				fail_count6 = fail_count6 + 1;
			}
		});
		if(fail_count6>=1){
			dnHandleVal=0;
		}else{
			dnHandleVal=5;
		}
		$('#dnHandleVal').text(dnHandleVal);
	///////Summary//////
		var fail_count7 = 0;
		$('.dnt_close').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='No'){
				fail_count7 = fail_count7 + 1;
			}
		});
		if(fail_count7>=1){
			dnCloseVal=0;
		}else{
			dnCloseVal=5;
		}
		$('#dnCloseVal').text(dnCloseVal);
		
		
		
		quality_score_percent = (dnIntroVal+dnStdQlVal+dnNeedAlVal+dnProductVal+dnPriceVal+dnObjectVal+dnClosingVal+dnUrjencyVal+dnPrdVal+dnPaymentVal+dnHandleVal+dnCloseVal);
		if(!isNaN(quality_score_percent)){
			if(dnStdQlVal==0 || dnNeedAlVal==0 || dnProductVal==0 || dnPrdVal==0 || dnPaymentVal==0 || dnHandleVal==0){
				$('#doubtnutScore').val(0);
			}else{
				$('#doubtnutScore').val(quality_score_percent+'%');
			}
		}
		
	}
	
///////////////// Superdaily New Call Audit ////////////////////////
	function superdaily_new_call(){
		var new_call_audit_score = 0;
		var ucp_score = 0;
		var tna_score = 0;
		var cu_score = 0;
		var hc_score = 0;
		
		$('.ucp_point').each(function(index,element){
			var weightage1 = parseFloat($(element).children("option:selected").attr('ucp_val'));
			ucp_score = ucp_score + weightage1;
		});
		$('#ucp_score').val(ucp_score+'%');
		///////
		$('.tna_point').each(function(index,element){
			var weightage2 = parseFloat($(element).children("option:selected").attr('tna_val'));
			tna_score = tna_score + weightage2;
		});
		$('#tna_score').val(tna_score+'%');
		///////
		$('.cu_point').each(function(index,element){
			var weightage3 = parseFloat($(element).children("option:selected").attr('cu_val'));
			cu_score = cu_score + weightage3;
		});
		$('#cu_score').val(cu_score+'%');
		///////
		$('.hc_point').each(function(index,element){
			var weightage4 = parseFloat($(element).children("option:selected").attr('hc_val'));
			hc_score = hc_score + weightage4;
		});
		$('#hc_score').val(hc_score+'%');
		
		new_call_audit_score = (ucp_score+tna_score+cu_score+hc_score);
		if(!isNaN(new_call_audit_score)){
			$('#newCallAuditScr').val(new_call_audit_score+'%');
		}
		
	/////////////
		if($('#af_para1').val()=='Yes' || $('#af_para2').val()=='Yes' || $('#af_para3').val()=='Yes' || $('#af_para4').val()=='Yes' || $('#af_para5').val()=='Yes'){
			$('.new_call_audit_AF').val(0+'%');
		}else{
			$('.new_call_audit_AF').val(new_call_audit_score+'%');
		}
		
	}
	
	/*------------ Superdaily Image Validate ------------*/
	function superdaily_img_validate(){
		var ucp_score = 0;
		var tna_score = 0;
		var uwbd_score = 0;
		
		$('.ucp').each(function(index,element){
			var w1 = parseFloat($(element).children("option:selected").attr('imgval'));
			ucp_score = ucp_score + w1;
		});
		$('#ucp_score').val(ucp_score+'%');
	/////////
		$('.tna').each(function(index,element){
			var w2 = parseFloat($(element).children("option:selected").attr('imgval'));
			tna_score = tna_score + w2;
		});
		$('#tna_score').val(tna_score+'%');
	//////////
		$('.uwbd').each(function(index,element){
			var w3 = parseFloat($(element).children("option:selected").attr('imgval'));
			uwbd_score = uwbd_score + w3;
		});
		$('#uwbd_score').val(uwbd_score+'%');
	/////////////////////
		var overallScorePercent = (ucp_score + tna_score + uwbd_score);
		if(!isNaN(overallScorePercent)){
			$('#imgValSPDL').val(overallScorePercent+'%');
		}
		
		if($('#imgvalAF1').val()=='No' || $('#imgvalAF2').val()=='Yes' || $('#imgvalAF3').val()=='Yes'){
			$('.imgValFatal').val(0);
			$('.imgValFatal').css('color','red');
		}else{
			$('.imgValFatal').val(overallScorePercent+'%');
			$('.imgValFatal').css('color','black');
		}
	}
	
/////////// IDFC (NEW) ///////////////
	function idfc_new_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.idfc_new').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('idfcnew_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('idfcnew_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('idfcnew_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#idfcEarnedScore').val(score);
		$('#idfcPossibleScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#idfcNewScore').val(quality_score_percent+'%');
		}
		
	//////////
		if($('#idfc_new_AF1').val()=='No' || $('#idfc_new_AF2').val()=='No' || $('#idfc_new_AF3').val()=='No' || $('#idfc_new_AF4').val()=='No' || $('#idfc_new_AF5').val()=='No' || $('#idfc_new_AF6').val()=='No' || $('#idfc_new_AF7').val()=='No'){
			$('.idfcNewFatal').val(0);
		}else{
			$('.idfcNewFatal').val(quality_score_percent+'%');
		}
		
	}

/////////////////////// MERCY SHIP START ////////////////////////////

	function docusign_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		
		$('.points_epi').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				// var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				// score = score + weightage;
				// scoreable = scoreable + weightage;
			}
		});

		$(".fatal_epi").each(function(){
			valNum=$(this).val();
			if(valNum == "Yes"){
				score=0;
			}	
		});

		score = parseFloat(score);
		quality_score_percent = parseFloat(scoreable);
		
		var quality_score_percent=((score*100)/quality_score_percent).toFixed(2);

		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}			
	
	}
	
docusign_calc();

////////////////////// NERCY SHIP END ///////////////////////////////
	
///////////////////////////// CHEGG /////////////////////////////////
	function chegg_calculation(){
		var score = 0;
		$('.chegg').each(function(index,element){
			var weightage = parseFloat($(element).children("option:selected").attr('chegg_val'));
			score = score + weightage;
		});
		
		if(!isNaN(score)){
			$('#cheggScore').val(score+'%');
		}
		
		//////////
		if($('#cheggAF1').val()=='No' || $('#cheggAF2').val()=='Yes'){
			$('.cheggFatal').val(0);
		}else{
			$('.cheggFatal').val(score+'%');
		}
		
	}

</script>


<script type="text/javascript">
$(document).ready(function(){
	
	$("#follow_up_date").datetimepicker();
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#mail_action_date").datepicker();
	$("#tat_replied_date").datepicker();
	$("#cycle_date").datepicker();
	$("#week_end_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#call_date_time").datetimepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	$(".agentName").select2();
	
///////////////////// SOP Library ////////////////////////////
	$(".addSOPLibrary").click(function(){
		$("#addSOPLibraryModel").modal('show');
	});
	
	$('#docu_upl').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'doc':
			case 'docx':
			case 'xls':
			case 'xlsx':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
/////////////////////////////////////////////////////////////	
	
	
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
	
////////////////////METROPOLIS///////////////////////////////
	$('#welcome_customer').on('change', function(){
		if($(this).val()=='5'){
			$('#wc_reason').val('N/A');
		}else{
			$('#wc_reason').val('');
		}
		overall_score();
	});
	$('#know_customer').on('change', function(){
		if($(this).val()=='5'){
			$('#kyc_reason').val('N/A');
		}else{
			$('#kyc_reason').val('');
		}
		overall_score();
	});
	$('#effective_communication').on('change', function(){
		if($(this).val()=='10'){
			$('#ec_reason').val('N/A');
		}else{
			$('#ec_reason').val('');
		}
		overall_score();
	});
	$('#building_rapport').on('change', function(){
		if($(this).val()=='15'){
			$('#br_reason').val('N/A');
		}else{
			$('#br_reason').val('');
		}
		overall_score();
	});
	$('#maintain_courtesy').on('change', function(){
		if($(this).val()=='10'){
			$('#mc_reason').val('N/A');
		}else{
			$('#mc_reason').val('');
		}
		overall_score();
	});
	$('#probing_assistance').on('change', function(){
		if($(this).val()=='10'){
			$('#pa_reason').val('N/A');
		}else{
			$('#pa_reason').val('');
		}
		overall_score();
	});
	$('#significance_info').on('change', function(){
		if($(this).val()=='20'){
			$('#si_reason').val('N/A');
		}else{
			$('#si_reason').val('');
		}
		overall_score();
	});
	$('#action_solution').on('change', function(){
		if($(this).val()=='15'){
			$('#as_reason').val('N/A');
		}else{
			$('#as_reason').val('');
		}
		overall_score();
	});
	$('#proper_docu').on('change', function(){
		if($(this).val()=='10'){
			$('#pd_reason').val('N/A');
		}else{
			$('#pd_reason').val('');
		}
		overall_score();
	});
	$('#zero_tolerance,#fu_zero_tolerance').on('change', function(){
		if($(this).val()=='N/A'){
			$('#ztp_reason').val('N/A');
		}else{
			$('#ztp_reason').val('');
		}
		overall_score();
	});
	
////////////////////SWIGGY///////////////////////////////		
	$('#greeting').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#greeting_reason").prop('disabled',false);
			$("#greeting_reason").attr('required',true);
			$("#greeting_reason2").prop('disabled',false);
		}else{
			$("#greeting_reason").prop('disabled',true);
			$("#greeting_reason").attr('required',false);
			$("#greeting_reason").val('');
			$("#greeting_reason2").prop('disabled',true);
			$("#greeting_reason2").val('');
		}
	});
	$('#identification').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#identification_reason").prop('disabled',false);
			$("#identification_reason").attr('required',true);
			$("#identification_reason2").prop('disabled',false);
		}else{
			$("#identification_reason").prop('disabled',true);
			$("#identification_reason").attr('required',false);
			$("#identification_reason").val('');
			$("#identification_reason2").prop('disabled',true);
			$("#identification_reason2").val('');
		}
	});
	$('#callintro').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#callintro_reason").prop('disabled',false);
			$("#callintro_reason").attr('required',true);
			$("#callintro_reason2").prop('disabled',false);
		}else{
			$("#callintro_reason").prop('disabled',true);
			$("#callintro_reason").attr('required',false);
			$("#callintro_reason").val('');
			$("#callintro_reason2").prop('disabled',true);
			$("#callintro_reason2").val('');
		}
	});
	$('#languageadher').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#languageadher_reason").prop('disabled',false);
			$("#languageadher_reason").attr('required',true);
			$("#languageadher_reason2").prop('disabled',false);
		}else{
			$("#languageadher_reason").prop('disabled',true);
			$("#languageadher_reason").attr('required',false);
			$("#languageadher_reason").val('');
			$("#languageadher_reason2").prop('disabled',true);
			$("#languageadher_reason2").val('');
		}
	});
	$('#confirm').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#confirm_reason").prop('disabled',false);
			$("#confirm_reason").attr('required',true);
			$("#confirm_reason2").prop('disabled',false);
		}else{
			$("#confirm_reason").prop('disabled',true);
			$("#confirm_reason").attr('required',false);
			$("#confirm_reason").val('');
			$("#confirm_reason2").prop('disabled',true);
			$("#confirm_reason2").val('');
		}
	});
	$('#systemvalid').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#systemvalid_reason").prop('disabled',false);
			$("#systemvalid_reason").attr('required',true);
			$("#systemvalid_reason2").prop('disabled',false);
		}else{
			$("#systemvalid_reason").prop('disabled',true);
			$("#systemvalid_reason").attr('required',false);
			$("#systemvalid_reason").val('');
			$("#systemvalid_reason2").prop('disabled',true);
			$("#systemvalid_reason2").val('');
		}
	});
	$('#probing').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#probing_reason").prop('disabled',false);
			$("#probing_reason").attr('required',true);
			$("#probing_reason2").prop('disabled',false);
		}else{
			$("#probing_reason").prop('disabled',true);
			$("#probing_reason").attr('required',false);
			$("#probing_reason").val('');
			$("#probing_reason2").prop('disabled',true);
			$("#probing_reason2").val('');
		}
	});
	$('#takingowner').on('change', function(){
		swiggy_score();
		if($(this).val()=='0' || $(this).val()=='-1'){
			$("#takingowner_reason").prop('disabled',false);
			$("#takingowner_reason").attr('required',true);
			$("#takingowner_reason2").prop('disabled',false);
		}else{
			$("#takingowner_reason").prop('disabled',true);
			$("#takingowner_reason").attr('required',false);
			$("#takingowner_reason").val('');
			$("#takingowner_reason2").prop('disabled',true);
			$("#takingowner_reason2").val('');
		}
	});
	$('#infosharing').on('change', function(){
		swiggy_score();
		if($(this).val()=='-1'){
			$("#infosharing_reason").prop('disabled',false);
			$("#infosharing_reason").attr('required',true);
			$("#infosharing_reason2").prop('disabled',false);
		}else{
			$("#infosharing_reason").prop('disabled',true);
			$("#infosharing_reason").attr('required',false);
			$("#infosharing_reason").val('');
			$("#infosharing_reason2").prop('disabled',true);
			$("#infosharing_reason2").val('');
		}
	});
	$('#rightaction').on('change', function(){
		swiggy_score();
		if($(this).val()=='0' || $(this).val()=='-1'){
			$("#rightaction_reason").prop('disabled',false);
			$("#rightaction_reason").attr('required',true);
			$("#rightaction_reason2").prop('disabled',false);
		}else{
			$("#rightaction_reason").prop('disabled',true);
			$("#rightaction_reason").attr('required',false);
			$("#rightaction_reason").val('');
			$("#rightaction_reason2").prop('disabled',true);
			$("#rightaction_reason2").val('');
		}
	});
	$('#callcontrol').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#callcontrol_reason").prop('disabled',false);
			$("#callcontrol_reason").attr('required',true);
			$("#callcontrol_reason2").prop('disabled',false);
		}else{
			$("#callcontrol_reason").prop('disabled',true);
			$("#callcontrol_reason").attr('required',false);
			$("#callcontrol_reason").val('');
			$("#callcontrol_reason2").prop('disabled',true);
			$("#callcontrol_reason2").val('');
		}
	});
	$('#softskill').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#softskill_reason").prop('disabled',false);
			$("#softskill_reason").attr('required',true);
			$("#softskill_reason2").prop('disabled',false);
		}else{
			$("#softskill_reason").prop('disabled',true);
			$("#softskill_reason").attr('required',false);
			$("#softskill_reason").val('');
			$("#softskill_reason2").prop('disabled',true);
			$("#softskill_reason2").val('');
		}
	});
	$('#holdprocedure').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#holdprocedure_reason").prop('disabled',false);
			$("#holdprocedure_reason").attr('required',true);
			$("#holdprocedure_reason2").prop('disabled',false);
		}else{
			$("#holdprocedure_reason").prop('disabled',true);
			$("#holdprocedure_reason").attr('required',false);
			$("#holdprocedure_reason").val('');
			$("#holdprocedure_reason2").prop('disabled',true);
			$("#holdprocedure_reason2").val('');
		}
	});
	$('#languageswitch').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#languageswitch_reason").prop('disabled',false);
			$("#languageswitch_reason").attr('required',true);
			$("#languageswitch_reason2").prop('disabled',false);
		}else{
			$("#languageswitch_reason").prop('disabled',true);
			$("#languageswitch_reason").attr('required',false);
			$("#languageswitch_reason").val('');
			$("#languageswitch_reason2").prop('disabled',true);
			$("#languageswitch_reason2").val('');
		}
	});
	$('#activelisten').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#activelisten_reason").prop('disabled',false);
			$("#activelisten_reason").attr('required',true);
			$("#activelisten_reason2").prop('disabled',false);
		}else{
			$("#activelisten_reason").prop('disabled',true);
			$("#activelisten_reason").attr('required',false);
			$("#activelisten_reason").val('');
			$("#activelisten_reason2").prop('disabled',true);
			$("#activelisten_reason2").val('');
		}
	});
	$('#rightfit').on('change', function(){
		swiggy_score();
		if($(this).val()=='0' || $(this).val()=='-1'){
			$("#rightfit_reason").prop('disabled',false);
			$("#rightfit_reason").attr('required',true);
			$("#rightfit_reason2").prop('disabled',false);
		}else{
			$("#rightfit_reason").prop('disabled',true);
			$("#rightfit_reason").attr('required',false);
			$("#rightfit_reason").val('');
			$("#rightfit_reason2").prop('disabled',true);
			$("#rightfit_reason2").val('');
		}
	});
	$('#furtherassist').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#furtherassist_reason").prop('disabled',false);
			$("#furtherassist_reason").attr('required',true);
			$("#furtherassist_reason2").prop('disabled',false);
		}else{
			$("#furtherassist_reason").prop('disabled',true);
			$("#furtherassist_reason").attr('required',false);
			$("#furtherassist_reason").val('');
			$("#furtherassist_reason2").prop('disabled',true);
			$("#furtherassist_reason2").val('');
		}
	});
	$('#callclose').on('change', function(){
		swiggy_score();
		if($(this).val()=='0'){
			$("#callclose_reason").prop('disabled',false);
			$("#callclose_reason").attr('required',true);
			$("#callclose_reason2").prop('disabled',false);
		}else{
			$("#callclose_reason").prop('disabled',true);
			$("#callclose_reason").attr('required',false);
			$("#callclose_reason").val('');
			$("#callclose_reason2").prop('disabled',true);
			$("#callclose_reason2").val('');
		}
	});
	$('#omt_ztp').on('change', function(){
		swiggy_score();
		if($(this).val()=='Yes'){
			$("#otmztp_reason").prop('disabled',false);
			$("#otmztp_reason").attr('required',true);
		}else{
			$("#otmztp_reason").prop('disabled',true);
			$("#otmztp_reason").attr('required',false);
			$("#otmztp_reason").val('');
		}
	});
	
////////////////////////	
	$('#greeting_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			$("#greeting_reason2").html('<option value="Call Opening not done">Call Opening not done</option>');
		}else if($(this).val()=='Behaviour'){
			var gr_option = '<option value="Call opening was not done as per the time of the day">Call opening was not done as per the time of the day</option>';
			gr_option += '<option value="Delay in Call Opening">Delay in Call Opening</option>';
			$("#greeting_reason2").html(gr_option);
		}else if($(this).val()=='Attitude'){
			$("#greeting_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#greeting_reason2").html('');
		}	
	});
	
	$('#identification_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			var ir_option = '<option value="Did not introduce Self">Did not introduce Self</option>';
			ir_option += '<option value="Did not identify the Called party">Did not identify the Called party</option>';
			ir_option += '<option value="Branding not done">Branding not done</option>';
			$("#identification_reason2").html(ir_option);
		}else if($(this).val()=='Behaviour' || $(this).val()=='Attitude'){
			$("#identification_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#identification_reason2").html('');
		}
	});
	
	$('#callintro_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			var cr_option = '<option value="Did not inform the reason for calling">Did not inform the reason for calling</option>';
			cr_option += '<option value="Incorrect reason for calling was informed">Incorrect reason for calling was informed</option>';
			cr_option += '<option value="Incomplete reason for calling was informed">Incomplete reason for calling was informed</option>';
			$("#callintro_reason2").html(cr_option);
		}else if($(this).val()=='Behaviour' || $(this).val()=='Attitude'){
			$("#callintro_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#callintro_reason2").html('');
		}
	});
	
	$('#languageadher_reason').on('change', function(){
		if($(this).val()=='Non_Adherence' || $(this).val()=='Attitude'){
			$("#languageadher_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else if($(this).val()=='Behaviour'){
			$("#languageadher_reason2").html('<option value="Call not opened in prefered language">Call not opened in prefered language</option>');
		}else{
			$("#languageadher_reason").html('');
		}
	});
	
	$('#confirm_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			$("#confirm_reason2").html('<option value="Resto Name, Order ID number & Item name not confirmed">Resto Name, Order ID number & Item name not confirmed</option>');
		}else if($(this).val()=='Behaviour' || $(this).val()=='Attitude'){
			$("#confirm_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#confirm_reason2").html('');
		}
	});
	
	$('#systemvalid_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			$("#systemvalid_reason2").html('<option value="Failed to check  the Call logs or the requests raised related to order">Failed to check  the Call logs or the requests raised related to order</option>');
		}else if($(this).val()=='Behaviour' || $(this).val()=='Attitude'){
			$("#systemvalid_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#systemvalid_reason2").html('');
		}
	});
	
	$('#probing_reason').on('change', function(){
		if($(this).val()=='Non_Adherence' || $(this).val()=='Attitude'){
			$("#probing_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else if($(this).val()=='Behaviour'){
			var pr_option = '<option value="Failed to do the probing">Failed to do the probing</option>';
			pr_option += '<option value="Failed to do relevant probing">Failed to do relevant probing</option>';
			pr_option += '<option value="Unnecessary probing was done">Unnecessary probing was done</option>';
			$("#probing_reason2").html(pr_option);
		}else{
			$("#probing_reason2").html('');
		}
	});
	
	$('#takingowner_reason').on('change', function(){
		if($(this).val()=='Non_Adherence' || $(this).val()=='Attitude'){
			$("#takingowner_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else if($(this).val()=='Behaviour'){
			var tr_option = '<option value="Failed to identify the options for order Fulfillment">Failed to identify the options for order Fulfillment</option>';
			tr_option += '<option value="Failed to take necessary ownership">Failed to take necessary ownership</option>';
			tr_option += '<option value="Took Ownership but gave incomplete/Incorrect Information">Took Ownership but gave incomplete/Incorrect Information</option>';
			$("#takingowner_reason2").html(tr_option);
		}else{
			$("#takingowner_reason2").html('');
		}
	});
	
	$('#infosharing_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			var ir_option = '<option value="FRT not met as per the definition">FRT not met as per the definition</option>';
			ir_option += '<option value="Call flow was not followed as per the request">Call flow was not followed as per the request</option>';
			ir_option += '<option value="failed to transfer to the IVR as per the process">failed to transfer to the IVR as per the process</option>';
			ir_option += '<option value="Conference was not made as per the SOP">Conference was not made as per the SOP</option>';
			ir_option += '<option value="Delay information was not given">Delay information was not given</option>';
			ir_option += '<option value="Order Id was not informed to the DE/Restro">Order Id was not informed to the DE/Restro</option>';
			ir_option += '<option value="Provided Incomplete Information">Provided Incomplete Information</option>';
			ir_option += '<option value="Provided Inaccurate Information">Provided Inaccurate Information</option>';
			ir_option += '<option value="Any Other Deviations">Any Other Deviations</option>';
			$("#infosharing_reason2").html(ir_option);
		}else if($(this).val()=='Behaviour'){
			$("#infosharing_reason2").html('<option value="False commitment was given">False commitment was given</option>');
		}else if($(this).val()=='Attitude'){
			$("#infosharing_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#infosharing_reason2").html('');
		}
	});
	
	$('#rightaction_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			var rr_option = '<option value="Incorrect System action was done">Incorrect System action was done</option>';
			rr_option += '<option value="Comments not updated as per the Conversation">Comments not updated as per the Conversation</option>';
			rr_option += '<option value="Incomplete Comments updated">Incomplete Comments updated</option>';
			rr_option += '<option value="Incorrect Comments updated">Incorrect Comments updated</option>';
			rr_option += '<option value="Spelling & Gramatical Errors">Spelling & Gramatical Errors</option>';
			$("#rightaction_reason2").html(rr_option);
		}else if($(this).val()=='Behaviour' || $(this).val()=='Attitude'){
			$("#rightaction_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#rightaction_reason2").html('');
		}
	});
	
	$('#callcontrol_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			var cr_option = '<option value="Not Energetic throughout the call">Not Energetic throughout the call</option>';
			cr_option += '<option value="High Rate of speech was Observed">High Rate of speech was Observed</option>';
			$("#callcontrol_reason2").html(cr_option);
		}else if($(this).val()=='Behaviour'){
			var cr_option1 = '<option value="Impolite Tone was Observed">Impolite Tone was Observed</option>';
			cr_option1 += '<option value="Rude Tone was Observed">Rude Tone was Observed</option>';
			cr_option1 += '<option value="Interruptions was Observed">Interruptions was Observed</option>';
			cr_option1 += '<option value="Switch the Language without permission">Switch the Language without permission</option>';
			cr_option1 += '<option value="Casual behaviour Observed">Casual behaviour Observed</option>';
			$("#callcontrol_reason2").html(cr_option1);
		}else if($(this).val()=='Attitude'){
			$("#callcontrol_reason2").html('<option value="was not Enthusiastic on the call">was not Enthusiastic on the call</option>');
		}else{
			$("#callcontrol_reason2").html('');
		}
	});
	
	$('#softskill_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			$("#softskill_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else if($(this).val()=='Behaviour'){
			var sr_option = '<option value="Failed to Empathize whereever required">Failed to Empathize whereever required</option>';
			sr_option += '<option value="Over Empathetic Behaviour observed">Over Empathetic Behaviour observed</option>';
			sr_option += '<option value="Failed to Apologize wherever required">Failed to Apologize wherever required</option>';
			sr_option += '<option value="Unnecessary & repeat Apology was Observed">Unnecessary & repeat Apology was Observed</option>';
			$("#softskill_reason2").html(sr_option);
		}else if($(this).val()=='Attitude'){
			var sr_option1 = '<option value="Failed to use Pleasantries on Call like Please Thanks">Failed to use Pleasantries on Call like Please Thanks</option>'
			sr_option1 = '<option value="Failed to avoid  direct statements">Failed to avoid  direct statements</option>'
			$("#softskill_reason2").html(sr_option1);
		}else{
			$("#softskill_reason2").html('');
		}
	});
	
	$('#holdprocedure_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			var hr_option = '<option value="Placed call on hold without Permission">Placed call on hold without Permission</option>';
			hr_option += '<option value="Hold Timelines not specified">Hold Timelines not specified</option>';
			hr_option += '<option value="Failed to appreciate customer for being on hold">Failed to appreciate customer for being on hold</option>';
			hr_option += '<option value="Unnecessary Hold was used">Unnecessary Hold was used</option>';
			hr_option += '<option value="Dead air was found for more than 10 seconds">Dead air was found for more than 10 seconds</option>';
			hr_option += '<option value="Conference not done when required">Conference not done when required</option>';
			hr_option += '<option value="Failed to follow the Conference Procedure">Failed to follow the Conference Procedure</option>';
			$("#holdprocedure_reason2").html(hr_option);
		}else if($(this).val()=='Behaviour' || $(this).val()=='Attitude'){
			$("#holdprocedure_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#holdprocedure_reason2").html('');
		}
	});
	
	$('#languageswitch_reason').on('change', function(){
		if($(this).val()=='Behaviour'){
			$("#languageswitch_reason2").html('<option value="Switch the Language without permission">Switch the Language without permission</option>');
		}else if($(this).val()=='Non_Adherence' || $(this).val()=='Attitude'){
			$("#languageswitch_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#languageswitch_reason2").html('');
		}
	});
	
	$('#activelisten_reason').on('change', function(){
		if($(this).val()=='Behaviour'){
			var ar_option = '<option value="Active listening  was not found which made customer/DE/Resto to repeat the information">Active listening  was not found which made customer/DE/Resto to repeat the information</option>';
			ar_option += '<option value="Failed to comprehend to the customer/DE/Resto thoughts(Irrelevant response)">Failed to comprehend to the customer/DE/Resto thoughts(Irrelevant response)</option>';
			ar_option += '<option value="Failed to Acknowledge the information given by the customer">Failed to Acknowledge the information given by the customer</option>';
			ar_option += '<option value="Attentive listening not found">Attentive listening not found</option>';
			$("#activelisten_reason2").html(ar_option);
		}else if($(this).val()=='Non_Adherence' || $(this).val()=='Attitude'){
			$("#activelisten_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#activelisten_reason2").html('');
		}
	});
	
	$('#rightfit_reason').on('change', function(){
		if($(this).val()=='Behaviour'){
			var rf_option = '<option value="Incorrect Sentence formation was observed">Incorrect Sentence formation was observed</option>';
			rf_option += '<option value="Incorrect pronunciation of words was Observed">Incorrect pronunciation of words was Observed</option>';
			rf_option += '<option value="Choice  of words was not appropriate">Choice  of words was not appropriate</option>';
			rf_option += '<option value="MTI influence was Observed">MTI influence was Observed</option>';
			rf_option += '<option value="Fumbling & fillers were Observed on multiple instances">Fumbling & fillers were Observed on multiple instances</option>';
			rf_option += '<option value="Speech Defect like(Lisp, Stammering, eating up words etc)">Speech Defect like(Lisp, Stammering, eating up words etc)</option>';
			$("#rightfit_reason2").html(rf_option);
		}else if($(this).val()=='Non_Adherence' || $(this).val()=='Attitude'){
			$("#rightfit_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#rightfit_reason2").html('');
		}
	});
	
	$('#furtherassist_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			$("#furtherassist_reason2").html('<option value="Failed to ask for further assistance">Failed to ask for further assistance</option>');
		}else if($(this).val()=='Behaviour' || $(this).val()=='Attitude'){
			$("#furtherassist_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#furtherassist_reason2").html('');
		}
	});
	
	$('#callclose_reason').on('change', function(){
		if($(this).val()=='Non_Adherence'){
			$("#callclose_reason2").html('<option value="Failed to follow the Call Closing Protocol">Failed to follow the Call Closing Protocol</option>');
		}else if($(this).val()=='Behaviour' || $(this).val()=='Attitude'){
			$("#callclose_reason2").html('<option value="Not Applicable">Not Applicable</option>');
		}else{
			$("#callclose_reason2").html('');
		}
	});	

////////////////////PAYNEARBY///////////////////////////////		
	$('#opening_greeting').on('change', function(){
		paynearby_score();
	});	
	$('#initial_empathy').on('change', function(){
		paynearby_score();
	});
	$('#agent_query').on('change', function(){
		paynearby_score();
	});
	$('#proper_telephone').on('change', function(){
		paynearby_score();
	});
	$('#ivr_promotion').on('change', function(){
		paynearby_score();
	});
	$('#efective_rebuttal').on('change', function(){
		paynearby_score();
	});
	$('#fraud_alert').on('change', function(){
		paynearby_score();
	});
	$('#sentence_acknowledge').on('change', function(){
		paynearby_score();
	});
	$('#polite_call').on('change', function(){
		paynearby_score();
	});
	$('#good_behaviour').on('change', function(){
		paynearby_score();
	});
	$('#good_listening').on('change', function(){
		paynearby_score();
	});
	$('#not_interrupt').on('change', function(){
		paynearby_score();
	});
	$('#proper_empathy').on('change', function(){
		paynearby_score();
	});
	$('#proper_pace').on('change', function(){
		paynearby_score();
	});
	$('#agent_patience').on('change', function(){
		paynearby_score();
	});
	$('#energy_enthusias').on('change', function(){
		paynearby_score();
	});
	$('#confident_level').on('change', function(){
		paynearby_score();
	});
	$('#error_fumbling').on('change', function(){
		paynearby_score();
	});
	$('#dead_air').on('change', function(){
		paynearby_score();
	});
	$('#dragged_call').on('change', function(){
		paynearby_score();
	});
	$('#rude_language').on('change', function(){
		paynearby_score();
	});
	$('#exact_tat').on('change', function(){
		paynearby_score();
	});
	$('#wrong_provide').on('change', function(){
		paynearby_score();
	});
	$('#correct_tagging').on('change', function(){
		paynearby_score();
	});
	$('#minor_error').on('change', function(){
		paynearby_score();
	});
	$('#satisfy_rapport').on('change', function(){
		paynearby_score();
	});
	$('#closing_script').on('change', function(){
		paynearby_score();
	});
	
	/*------------- OOUTBOUND ---------------*/
	$(document).on('change','.obSalesVal',function(){
		paynearby_ob();
	});
	
	/*--------------- EMAIL -------------------*/
	$(document).on('change','.pnbEmail',function(){
		paynearby_email();
	});
	
////////////////////////// Jurys Inn ///////////////////////////////
	$(document).on('change','.jurry_points',function(){
		do_calculation();
	});
	$(document).on('change','.jurry_points2',function(){
		do_calculation();
	});
	$(document).on('change','.amd_point',function(){
		calculation();
	});
	$(document).on('change','.customer',function(){
		do_calculation();
	});
	$(document).on('change','.business',function(){
		do_calculation();
	});
	$(document).on('change','.compliance',function(){
		do_calculation();
	});
	do_calculation();
	
///////////////////// India Bulls ////////////////////////	
	$('#bullgreeting').on('change', function(){
		bull_score();
	});
	$('#bullclosing').on('change', function(){
		bull_score();
	});
	$('#bullcoprehending').on('change', function(){
		bull_score();
	});
	$('#bullownership').on('change', function(){
		bull_score();
	});
	$('#bullhold').on('change', function(){
		bull_score();
	});
	$('#bullbehavior').on('change', function(){
		bull_score();
	});
	$('#bulllanguage').on('change', function(){
		bull_score();
	});
	$('#bullproactive').on('change', function(){
		bull_score();
	});
	$('#bulldisposition').on('change', function(){
		bull_score();
	});
	
	$('#ibDispo').on('change', function(){
		var ib_dispo = $(this).val();
		
		if(ib_dispo=='Declined/No requirement' || ib_dispo=='FCR - Collection' || ib_dispo=='FCR - Dhani Care' || ib_dispo=='Loan amount less' || ib_dispo=='No android phone' || ib_dispo=='Wrong Number' || ib_dispo=='Partial_Payment')
		{
			$("#ibSubDispo").html('<option value="--">--</option>');
		}else if(ib_dispo=='Technical error'){
			var ib_option = '<option value="OTP not received">OTP not received</option>';
			ib_option += '<option value="No Offers">No Offers</option>';
			ib_option += '<option value="Error in Final Stage">Error in Final Stage</option>';
			$("#ibSubDispo").html(ib_option);
		}else if(ib_dispo=='POP'){
			var ib_option1 = '<option value="Razor Pay LINK / Pay Nemo">Razor Pay LINK / Pay Nemo</option>';
			ib_option1 += '<option value="Dhani App">Dhani App</option>';
			ib_option1 += '<option value="UPI">UPI</option>';
			ib_option1 += '<option value="IMPS/NEFT">IMPS/NEFT</option>';
			ib_option1 += '<option value="Paid in Branch">Paid in Branch</option>';
			ib_option1 += '<option value="Pay Nemo">Pay Nemo</option>';
			ib_option1 += '<option value="PAYTM">PAYTM</option>';
			$("#ibSubDispo").html(ib_option1);
		}else if(ib_dispo=='DRR' || ib_dispo=='DRP'){
			var ib_option2 = '<option value="Already Requested">Already Requested</option>';
			ib_option2 += '<option value="Requested Now">Requested Now</option>';
			$("#ibSubDispo").html(ib_option2);
		}else if(ib_dispo=='FPTP'){
			$("#ibSubDispo").html('<option value="3 - 5 Days">3 - 5 Days</option>');
		}else{
			$("#ibSubDispo").html('');
		}
	});
	
////////////////////// Araca ////////////////////////
	$(document).on('change','.aracaVal',function(){
		araca_score();
	});
	
//////////////////////////////////// Super Daily ///////////////////////////////////////////
	$(document).on('change','.comm_point',function(){
		superdaily_calculation();
	});
	
	$(document).on('change','.reso_point',function(){
		superdaily_calculation();
	});
	
	$(document).on('change','.autof',function(){
		superdaily_calculation();
	});

////////////////////////// Super Daily call Audit ///////////////////////////////
	$(document).on('change','.call_hand_skill',function(){
		superdaily_call_calculation();
	});

	$(document).on('change','.comm_point1',function(){
		superdaily_call_calculation();
	});
	
	$(document).on('change','.reso_point1',function(){
		superdaily_call_calculation();
	});
	
	$(document).on('change','.autof1',function(){
		superdaily_call_calculation();
	});
	
////////////// Superdaily New Call Audit ////////////////
	$(document).on('change','.ucp_point',function(){ superdaily_new_call(); });
	$(document).on('change','.tna_point',function(){ superdaily_new_call(); });
	$(document).on('change','.cu_point',function(){ superdaily_new_call(); });
	$(document).on('change','.hc_point',function(){ superdaily_new_call(); });
	$(document).on('change','.af_point',function(){ superdaily_new_call(); });	
	superdaily_new_call()
	
////////////// Superdaily (Image Validation) ////////////////
	$(document).on('change','.ucp',function(){ superdaily_img_validate(); });
	$(document).on('change','.tna',function(){ superdaily_img_validate(); });
	$(document).on('change','.uwbd',function(){ superdaily_img_validate(); });
	$(document).on('change','.imgval',function(){ superdaily_img_validate(); });
	superdaily_img_validate();
	
	
///////////////// Entice Energy /////////////////////////////
	$(document).on('change','.ee_points',function(){
		entice_energy_calc();
	});
	
///////////////// DoubtNut /////////////////////////////
	$("#level1generationdate").datepicker();
	$("#level1promisedate").datepicker();
	$("#level2lastconnectdate").datepicker();
	$("#level2lastpromisedate").datepicker();
	
	$('#level1cause').on('change', function(){
		if($(this).val()=='Incorrect_P2P'){
			var lv_p2p1 = '<option value="Incorrect P2P tagged">Incorrect P2P tagged</option>';
			lv_p2p1 += '<option value="Need identification not done (BANT)">Need identification not done (BANT)</option>';
			lv_p2p1 += '<option value="Improper pitch">Improper pitch</option>';
			lv_p2p1 += '<option value="Mis Selling">Mis Selling</option>';
			$("#level1subcause").html(lv_p2p1);
			
			$("#level1subcause1").css('display','none').attr('required',false);
			$("#level1subcause1").val('');
			$("#level1subcause").css('display','block').attr('required',true);
		}else if($(this).val()=='Correct_P2P'){
			$('#level1subcause').css('display','none').attr('required',false);
			$("#level1subcause").val('');
			$('#level1subcause1').css('display','block').attr('required',true);
		}
	});
	
	$('#level2cause').on('change', function(){
		if($(this).val()=='L2_TM'){
			var lv2_p2p1 = '<option value="Delay In Follow-up">Delay In Follow-up</option>';
			lv2_p2p1 += '<option value="Lack of conviction">Lack of conviction</option>';
			$("#level2subcause").html(lv2_p2p1);
			
			$("#level2subcause1").css('display','none').attr('required',false);
			$("#level2subcause1").val('');
			$("#level2subcause").css('display','block').attr('required',true);
		}else if($(this).val()=='Customer'){
			var lv2_p2p2 = '<option value="Cx Mind Changed">Cx Mind Changed</option>';
			lv2_p2p2 += '<option value="Financial Constraints">Financial Constraints</option>';
			lv2_p2p2 += '<option value="Cx Not Reachable">Cx Not Reachable</option>';
			$("#level2subcause").html(lv2_p2p2);
			
			$("#level2subcause1").css('display','none').attr('required',false);
			$("#level2subcause1").val('');
			$("#level2subcause").css('display','block').attr('required',true);
		}else if($(this).val()=='Technology'){
			var lv2_p2p3 = '<option value="Data consumption">Data consumption</option>';
			lv2_p2p3 += '<option value="Different payment mode">Different payment mode</option>';
			$("#level2subcause").html(lv2_p2p3);
			
			$("#level2subcause1").css('display','none').attr('required',false);
			$("#level2subcause1").val('');
			$("#level2subcause").css('display','block').attr('required',true);
		}else if($(this).val()=='Sale_Done'){
			var lv2_p2p4 = '<option value="Monthly">Monthly</option>';
			lv2_p2p4 += '<option value="Quarterly">Quarterly</option>';
			lv2_p2p4 += '<option value="Yearly">Yearly</option>';
			$("#level2subcause").html(lv2_p2p4);
			
			$("#level2subcause1").css('display','none').attr('required',false);
			$("#level2subcause1").val('');
			$("#level2subcause").css('display','block').attr('required',true);
		}else if($(this).val()=='Due_For_Follow_up'){
			$('#level2subcause').css('display','none').attr('required',false);
			$("#level2subcause").val('');
			$('#level2subcause1').css('display','block').attr('required',true);
		}
	});


	$(document).on('change','.dnt_intro',function(){ dn_calculation(); });
	$(document).on('change','.dnt_student',function(){ dn_calculation(); });
	$(document).on('change','.dnt_need',function(){ dn_calculation(); });
	$(document).on('change','.dnt_product',function(){ dn_calculation(); });
	$(document).on('change','.dnt_price',function(){ dn_calculation(); });
	$(document).on('change','.dnt_object',function(){ dn_calculation(); });
	$(document).on('change','.dnt_closing',function(){ dn_calculation(); });
	$(document).on('change','.dnt_urjency',function(){ dn_calculation(); });
	$(document).on('change','.dnt_prd',function(){ dn_calculation(); });
	$(document).on('change','.dnt_payment',function(){ dn_calculation(); });
	$(document).on('change','.dnt_handle',function(){ dn_calculation(); });
	$(document).on('change','.dnt_close',function(){ dn_calculation(); });
	dn_calculation();

//////////////////////// IDFC ////////////////////////////
	$(document).on('change','.greeting',function(){ idfc_calc(); });
	$(document).on('change','.purposecall',function(){ idfc_calc(); });
	$(document).on('change','.collectionstechnique',function(){ idfc_calc(); });
	$(document).on('change','.communicationskill',function(){ idfc_calc(); });
	$(document).on('change','.telephoneetiquette',function(){ idfc_calc(); });
	$(document).on('change','.callclosing',function(){ idfc_calc(); });
	idfc_calc();
	
//////// IDFC (NEW) /////////////
	$(document).on('change','.idfc_new',function(){ 
		idfc_new_calc(); 
	});
	idfc_new_calc();
	
//////////////// SXC ////////////////////	
	$(document).on('change','.sxc_point',function(){
		sxc_calculation();
	});
	sxc_calculation();
	
//////////////// Ideal Living  ////////////////////	
	$(document).on('change','.il_point',function(){ 
		il_calculation(); 
	});
	il_calculation();
	
//////////////// Ideal Living Feedback ////////////////////	
	$(document).on('change','#il_point_feedback',function(){ 
		il_calculation_feedback(); 
	});

	$(".points_epi").on("change",function(){
		docusign_calc();
	});

	docusign_calc();

	il_calculation_feedback();

	///////////////// wrong disposition feedback ///////////////////////	
	$('#correct_disposition').attr("disabled", true);
	
	$('#wrong_disposition').on('change', function(){
		if($(this).val()=='1'){
			$('#correct_disposition').show();
			$('#correct_disposition').attr('required',true);
			$('#correct_disposition').prop('disabled',false);
			$("#ilSalesScore").val('0%');
			$('#il_point_feedback').attr('disabled', true);
			// $('#il_point_feedback').find(":selected").text('');
			$('#il_point_feedback').val('0');
		}else{
			// $('#correct_disposition').hide();
			$('#correct_disposition').attr('required',false);
			$('#correct_disposition').prop('disabled',true);
			$('#il_point_feedback').attr('disabled', false);
			
			
		}
	});

////////////////// Kenny-U-Pull /////////////////////
	$(document).on('change','.kennyVal',function(){ 
		kenny_u_pull_calc(); 
	});
	kenny_u_pull_calc();	
	
////////////////// SENSIO /////////////////////
	$(document).on('change','.sensioVal',function(){ 
		sensio_calc(); 
	});
	sensio_calc();
	
////////////////// CINEMARK /////////////////////
	$(document).on('change','.amd_point',function(){ 
		cinemark_calc(); 
	});
	cinemark_calc();
	
///////////////// Chegg /////////////////////////////
	$(document).on('change','.chegg',function(){
		chegg_calculation();
	});
	chegg_calculation();
	
	/* $(document).on('change','.chegg_rubric',function(){
		chegg_rubric_calc();
	});
	chegg_rubric_calc(); */
	
////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function(){
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_metropolis/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
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
	
/////////// Hygiene /////////////
	/*$("#process_id").on('change',function(){
		var pid = this.value;
		//if(pid=="") alert("--Select Process--");
		var URL='<?php echo base_url();?>qa_hygiene/getAgent';
		$('#sktPleaseWait').modal('show');
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'pid='+pid,
		   success: function(pList){
				var json_obj = $.parseJSON(pList);//parse JSON
				$('#agent_id').empty();	
				$('#agent_id').append($('<option></option>').val('').html('--Select--'));
				
				for (var i in json_obj){
					$('#agent_id').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name));
				}
				
				$('#sktPleaseWait').modal('hide');	
			},
			error: function(){	
				alert('Fail!');
			}
		}); 
	});*/
	
//////////////////////////////////////

		$("#form_audit_user").submit(function (e) {
			$('#qaformsubmit').prop('disabled',true);
		});
		
		$("#form_agent_user").submit(function(e){
			$('#btnagentSave').prop('disabled',true);
		});
		$("#form_agent_user_verification").submit(function(e){
			$('#btnagentSave').prop('disabled',true);
		});


		$("#form_agent_user_mercy").submit(function(e){
			$('#btnagentSavemercy').prop('disabled',true);
		});

		$("#form_agent_call_user").submit(function(e){
			$('#btnagentSave').prop('disabled',true);
		});
		
		$("#form_mgnt_user").submit(function(e){
			$('#btnmgntSave').prop('disabled',true);
		});

		$("#form_mgnt_call_user").submit(function(e){
			$('#btnmgntSave').prop('disabled',true);
		});
	
/////////////////////////////////

});
</script>


<script type="text/javascript">
	
////////////////////METROPOLIS////////////////////////////
	function overall_score(){
		var a = parseInt($("#welcome_customer").val());
		var b = parseInt($("#know_customer").val());
		var c = parseInt($("#effective_communication").val());
		var d = parseInt($("#building_rapport").val());
		var e = parseInt($("#maintain_courtesy").val());
		var f = parseInt($("#probing_assistance").val());
		var g = parseInt($("#significance_info").val());
		var h = parseInt($("#action_solution").val());
		var i = parseInt($("#proper_docu").val());
		var j = $("#zero_tolerance").val();
		
		if(f==-1 || g==-1 || h==-1 || j=='ZTP'){
			var tot = 0;
		}else{
			var tot = a+b+c+d+e+f+g+h+i;
		}
		if(!isNaN(tot)){
			document.getElementById("total_score").value= tot+'%';
		}
		return tot;
	}

//////////////////////SWIGGY///////////////////////////////		
	function swiggy_score(){
		var a1 = parseInt($("#greeting").val());
		var a2 = parseInt($("#identification").val());
		var a3 = parseInt($("#callintro").val());
		var a4 = parseInt($("#languageadher").val());
		var a5 = parseInt($("#confirm").val());
		var a6 = parseInt($("#systemvalid").val());
		var a7 = parseInt($("#probing").val());
		var a8 = parseInt($("#takingowner").val());
		var a9 = parseInt($("#infosharing").val());
		var a10 = parseInt($("#rightaction").val());
		var a11 = parseInt($("#callcontrol").val());
		var a12 = parseInt($("#softskill").val());
		var a13 = parseInt($("#holdprocedure").val());
		var a14 = parseInt($("#languageswitch").val());
		var a15 = parseInt($("#activelisten").val());
		var a16 = parseInt($("#rightfit").val());
		var a17 = parseInt($("#furtherassist").val());
		var a18 = parseInt($("#callclose").val());
		var a19 = $("#omt_ztp").val();
		
		if(a8==-1 || a9==-1 || a10==-1 || a16==-1 || a19=='Yes'){
			var swiggytot = 0;
		}else{
			var swiggytot = a1+a2+a3+a4+a5+a6+a7+a8+a9+a10+a11+a12+a13+a14+a15+a16+a17+a18;
		}
		
		if(!isNaN(swiggytot)){
			document.getElementById("swiggy_score").value= swiggytot+'%';
		}
		return swiggytot;
	}
	
//////////////////////PAYNEARBY///////////////////////////////	
	function paynearby_score(){
		var a1 = parseInt($("#opening_greeting option:selected").attr("data_val"));
		var a2 = parseInt($("#initial_empathy option:selected").attr("data_val"));
		var a3 = parseInt($("#agent_query option:selected").attr("data_val"));
		var a4 = parseInt($("#proper_telephone option:selected").attr("data_val"));
		var a5 = parseInt($("#ivr_promotion option:selected").attr("data_val"));
		var a6 = parseInt($("#efective_rebuttal option:selected").attr("data_val"));
		var a7 = parseInt($("#fraud_alert option:selected").attr("data_val"));
		var a8 = parseInt($("#sentence_acknowledge option:selected").attr("data_val"));
		var a9 = parseInt($("#polite_call option:selected").attr("data_val"));
		var a10 = parseInt($("#good_behaviour option:selected").attr("data_val"));
		var a11 = parseInt($("#good_listening option:selected").attr("data_val"));
		var a12 = parseInt($("#not_interrupt option:selected").attr("data_val"));
		var a13 = parseInt($("#proper_empathy option:selected").attr("data_val"));
		var a14 = parseInt($("#proper_pace option:selected").attr("data_val"));
		var a15 = parseInt($("#agent_patience option:selected").attr("data_val"));
		var a16 = parseInt($("#energy_enthusias option:selected").attr("data_val"));
		var a17 = parseInt($("#confident_level option:selected").attr("data_val"));
		var a18 = parseInt($("#error_fumbling option:selected").attr("data_val"));
		var a19 = parseInt($("#dead_air option:selected").attr("data_val"));
		var a20 = parseInt($("#dragged_call option:selected").attr("data_val"));
		var a21 = parseInt($("#rude_language option:selected").attr("data_val"));
		var a22 = parseInt($("#exact_tat option:selected").attr("data_val"));
		var a23 = parseInt($("#wrong_provide option:selected").attr("data_val"));
		var a24 = parseInt($("#correct_tagging option:selected").attr("data_val"));
		var a25 = parseInt($("#minor_error option:selected").attr("data_val"));
		var a26 = parseInt($("#satisfy_rapport option:selected").attr("data_val"));
		var a27 = parseInt($("#closing_script option:selected").attr("data_val"));
		
		if(a21==-1 || a22==-1 || a23==-1 || a24==-1){
			var paynearby_tot = 0;
		}else{
			var paynearby_tot = a1+a2+a3+a4+a5+a6+a7+a8+a9+a10+a11+a12+a13+a14+a15+a16+a17+a18+a19+a20+a21+a22+a23+a24+a25+a26+a27;
		}
		
		if(!isNaN(paynearby_tot)){
			document.getElementById("paynearby_score").value= paynearby_tot+'%';
		}
		
		if(parseInt(paynearby_tot) <= 50){
			document.getElementById("paynearby_grade").value= 'D';
		}else if(parseInt(paynearby_tot) > 50 && parseInt(paynearby_tot) <= 70){
			document.getElementById("paynearby_grade").value= 'C';
		}else if(parseInt(paynearby_tot) > 70 && parseInt(paynearby_tot) <= 90){
			document.getElementById("paynearby_grade").value= 'B';
		}else if(parseInt(paynearby_tot) > 90){
			document.getElementById("paynearby_grade").value= 'A';
		}else{
			document.getElementById("paynearby_grade").value= '';
		}
		
		return paynearby_tot;
	}
	
	/*------------ Outbound ------------*/
	function paynearby_ob(){
		var pnbScore=0;
		$('.obSalesVal').each(function(index,element){
			var score_type = parseInt($(element).children("option:selected").attr('obSales'));
			pnbScore = pnbScore+score_type;
		});
		
		if(!isNaN(pnbScore)){
			$('#pnb_ob_score').val(pnbScore+'%');
		}
		
	///// Sales //////
		if($("#ob_sales_AF1").val()=='Fatal' || $("#ob_sales_AF2").val()=='Fatal'){
			$('.ob_sales_AF').val(0);
		}else{
			$('.ob_sales_AF').val(pnbScore+'%');
		}
	///// Service //////
		if($("#ob_service_AF1").val()=='Fatal' || $("#ob_service_AF2").val()=='Fatal'){
			$('.ob_service_AF').val(0);
		}else{
			$('.ob_service_AF').val(pnbScore+'%');
		}
	
	}
	
	/*------------ Email ------------*/
	function paynearby_email(){
		var pnbEmailScore=0;
		$('.pnbEmail').each(function(index,element){
			var score_type = parseInt($(element).children("option:selected").attr('email_val'));
			pnbEmailScore = pnbEmailScore + score_type;
		});
		
		if(!isNaN(pnbEmailScore)){
			$('#pnbEmailScore').val(pnbEmailScore+'%');
		}
		
		if($("#pnbEmailFatal1").val()=='Fatal'){
			$('.pnbRmailAF').val(0);
		}else{
			$('.pnbRmailAF').val(pnbEmailScore+'%');
		}
	
	}
	
///////////////////////////Jury's Inn//////////////////////////////	
	function do_calculation(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;

		
		$('.jurry_points').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('ji_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('ji_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('ji_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}

		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		
		
		$('#jurys_inn_earned_score').val(score);
		$('#jurys_inn_possible_score').val(scoreable);
		
		$('#pass_count').val(pass_count);
		$('#fail_count').val(fail_count);
		$('#na_count').val(na_count);
		
	//////////////// Customer/Business/Compliance //////////////////
		var customerScore1 = 0;
		var customerScoreable1 = 0;
		var customerPercentage1 = 0;
		$('.customer').each(function(index,element){
			var sc = $(element).val();
			if(sc == 'Yes'){
				var w = parseInt($(element).children("option:selected").attr('ji_val'));
				customerScore1 = customerScore1 + w;
				customerScoreable1 = customerScoreable1 + w;
			}else if(sc == 'No'){
				var w = parseInt($(element).children("option:selected").attr('ji_val'));
				customerScoreable1 = customerScoreable1 + w;
			}else if(sc == 'N/A'){
				var w = parseInt($(element).children("option:selected").attr('ji_val'));
				customerScore1 = customerScore1 + w;
				customerScoreable1 = customerScoreable1 + w;
			}
		});
		$('#custJiCisEarned').text(customerScore1);
		$('#custJiCisPossible').text(customerScoreable1);
		customerPercentage1 = ((customerScore1*100)/customerScoreable1).toFixed(2);
		if(!isNaN(customerPercentage1)){
			$('#custJiCisScore').val(customerPercentage1+'%');
		}
	////////////
		var businessScore1 = 0;
		var businessScoreable1 = 0;
		var businessPercentage1 = 0;
		$('.business').each(function(index,element){
			var scb = $(element).val();
			if(scb == 'Yes'){
				var wb = parseInt($(element).children("option:selected").attr('ji_val'));
				businessScore1 = businessScore1 + wb;
				businessScoreable1 = businessScoreable1 + wb;
			}else if(scb == 'No'){
				var wb = parseInt($(element).children("option:selected").attr('ji_val'));
				businessScoreable1 = businessScoreable1 + wb;
			}else if(scb == 'N/A'){
				var wb = parseInt($(element).children("option:selected").attr('ji_val'));
				businessScore1 = businessScore1 + wb;
				businessScoreable1 = businessScoreable1 + wb;
			}
		});
		$('#busiJiCisEarned').text(businessScore1);
		$('#busiJiCisPossible').text(businessScoreable1);
		businessPercentage1 = ((businessScore1*100)/businessScoreable1).toFixed(2);
		if(!isNaN(businessPercentage1)){
			$('#busiJiCisScore').val(businessPercentage1+'%');
		}
	////////////
		var complianceScore1 = 0;
		var complianceScoreable1 = 0;
		var compliancePercentage1 = 0;
		$('.compliance').each(function(index,element){
			var scc = $(element).val();
			if(scc == 'Yes'){
				var wc = parseInt($(element).children("option:selected").attr('ji_val'));
				complianceScore1 = complianceScore1 + wc;
				complianceScoreable1 = complianceScoreable1 + wc;
			}else if(scc == 'No'){
				var wc = parseInt($(element).children("option:selected").attr('ji_val'));
				complianceScoreable1 = complianceScoreable1 + wc;
			}else if(scc == 'N/A'){
				var wc = parseInt($(element).children("option:selected").attr('ji_val'));
				complianceScore1 = complianceScore1 + wc;
				complianceScoreable1 = complianceScoreable1 + wc;
			}
		});
		$('#complJiCisEarned').text(complianceScore1);
		$('#complJiCisPossible').text(complianceScoreable1);
		compliancePercentage1 = ((complianceScore1*100)/complianceScoreable1).toFixed(2);
		if(!isNaN(compliancePercentage1)){
			$('#complJiCisScore').val(compliancePercentage1+'%');
		}
	
	///////////////CIS///////////////
		if($('#recognise_gdpr').val() == 'No' || $('#overcome_terms').val() == 'No' || $('#closure_booking').val() == 'No'){
			$('#jurysinn_PF').css("color", "red").val('Fail');
			$('#jurys_inn_overall_score').val(0);
		}else{
			if(quality_score_percent <= 90){
				$('#jurysinn_PF').css("color", "red").val('Fail');
			}else{
				$('#jurysinn_PF').css("color", "green").val('Pass');
			}
			
			if(!isNaN(quality_score_percent)){
				$('#jurys_inn_overall_score').val(quality_score_percent+'%');
			}
		}
		
	/////////////CIS Email///////////////	
		if($('#agentusetemplate').val() == 'No' || $('#agentusesignature').val() == 'No' || $('#agentuseinformation').val() == 'No' || $('#duplicatereservation').val()=='No' || $('#bookingmade').val()=='No' || $('#incorrectbookingchange').val()=='No' || $('#escalationagainstemail').val()=='No'){
			$('#ji_email_PF').css("color", "red").val('Fail');
			$('.jiEmail').val(0);
		}else{
			if(quality_score_percent <= 90){
				$('#ji_email_PF').css("color", "red").val('Fail');
			}else{
				$('#ji_email_PF').css("color", "green").val('Pass');
			}
			
			if(!isNaN(quality_score_percent)){
				$('.jiEmail').val(quality_score_percent+'%');
			}
		}
		
	////////////Stag and Hen///////////////	
		if($('#stag_hen_AF1').val() == 'No' || $('#stag_hen_AF2').val() == 'No'){
			$('.stag_hen_fatal').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('.stag_hen_fatal').val(quality_score_percent+'%');
			}
		}
		
	////////////CIS GDS///////////////	
		if($('#cis_gds_AF1').val() == 'No' || $('#cis_gds_AF2').val() == 'No' || $('#cis_gds_AF3').val() == 'No' || $('#cis_gds_AF4').val() == 'No' || $('#cis_gds_AF5').val() == 'No'){
			$('.cis_gds_fatal').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('.cis_gds_fatal').val(quality_score_percent+'%');
			}
		}
		
	////////////GDS & Pre Arrival///////////////	
		if($('#gds_prearrival_AF1').val() == 'No' || $('#gds_prearrival_AF2').val() == 'No' || $('#gds_prearrival_AF3').val() == 'No' || $('#gds_prearrival_AF4').val() == 'No' || $('#gds_prearrival_AF5').val() == 'No' || $('#gds_prearrival_AF6').val() == 'No' || $('#gds_prearrival_AF7').val() == 'No' || $('#gds_prearrival_AF8').val() == 'No' || $('#gds_prearrival_AF9').val() == 'No' || $('#gds_prearrival_AF10').val() == 'No' || $('#gds_prearrival_AF11').val() == 'No' || $('#gds_prearrival_AF12').val() == 'No' || $('#gds_prearrival_AF13').val() == 'No' || $('#gds_prearrival_AF14').val() == 'No' || $('#gds_prearrival_AF15').val() == 'No'){
			$('.gds_prearrival_fatal').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('.gds_prearrival_fatal').val(quality_score_percent+'%');
			}
		}
		
	////////////Stifel///////////////	
		if($('#stifel_AF1').val()=='No' || $('#stifel_AF2').val()=='No' || $('#stifel_AF3').val()=='No' || $('#stifel_AF4').val()=='No' || $('#stifel_AF5').val()=='No' || $('#stifel_AF6').val()=='No'){
			$('.stifel_fatal').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('.stifel_fatal').val(quality_score_percent+'%');
			}
		}
	
	////////////////
	}
	
////////////////////// India Bulls ////////////////////
	function bull_score(){
		var a1 = parseInt($("#bullgreeting option:selected").attr("bull_val"));
		var a2 = parseInt($("#bullclosing option:selected").attr("bull_val"));
		var a3 = parseInt($("#bullcoprehending option:selected").attr("bull_val"));
		var a4 = parseInt($("#bullownership option:selected").attr("bull_val"));
		var a5 = parseInt($("#bullhold option:selected").attr("bull_val"));
		var a6 = parseInt($("#bullbehavior option:selected").attr("bull_val"));
		var a7 = parseInt($("#bulllanguage option:selected").attr("bull_val"));
		var a8 = parseInt($("#bullproactive option:selected").attr("bull_val"));
		var a9 = parseInt($("#bulldisposition option:selected").attr("bull_val"));
		
		if(a3==-1 || a5==-1 || a6==-1 || a9==-1){
			var bull_tot = 0;
		}else{
			var bull_tot = a1+a2+a3+a4+a5+a6+a7+a8+a9;
		}
		
		if(!isNaN(bull_tot)){
			document.getElementById("bullScore").value= bull_tot+'%';
		}
	}
	
////////////////// Araca Shop ////////////////////////	
	function araca_score(){
		var arcScore=0;
		$('.aracaVal').each(function(index,element){
			score_type = parseInt($(element).children("option:selected").attr('arc_val'));
			arcScore = score_type+arcScore;
		});
		
		if(!isNaN(arcScore)){
			$('#aracaScore').val(arcScore+'%');
		}
	}
	
/////////////////////// Super Daily //////////////////////////
	function superdaily_calculation(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.comm_point').each(function(index,element){
			var score_type1 = $(element).val();
			if(score_type1 == 'Pass' || score_type1 == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('sd_value'));
				score = score + weightage;
			}else if(score_type1 == 'Fail'){
				var weightage = parseInt($(element).children("option:selected").attr('sd_value'));
				score = score + weightage;
			}
		});
		$('#sd_communication_score').val(score+'%');
		
		$('.reso_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Pass' || score_type == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('sd_value'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'Fail'){
				var weightage = parseInt($(element).children("option:selected").attr('sd_value'));
				scoreable = scoreable + weightage;
			}
		});
		$('#sd_resolution_score').val(scoreable+'%');
		
		quality_score_percent = (score+scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#superdaily_overall_score').val(quality_score_percent+'%');
		}
		
		if($('#af1').val()=='Fatal' || $('#af2').val()=='Fatal' || $('#af4').val()=='Fatal' || $('#af5').val()=='Yes' || $('#af6').val()=='Fail' || $('#af7').val()=='Fail'){
			$('.autoFail').val(0+'%');
		}else{
			$('.autoFail').val(quality_score_percent+'%');
		}
		
	}

//////////////////// Super Daily Call Audit Calculation  //////////////////////////
	
	function superdaily_call_calculation(){
		
		//alert("hi");

		var callHandScore = 0;
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.call_hand_skill').each(function(index,element){
			var score_type1 = $(element).val();
			if(score_type1 == 'Pass' || score_type1 == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('sd_value'));
				callHandScore = callHandScore + weightage;
			}else if(score_type1 == 'Fail'){
				var weightage = parseInt($(element).children("option:selected").attr('sd_value'));
				callHandScore = callHandScore + weightage;
			}
		});

		$('.comm_point1').each(function(index,element){
			var score_type1 = $(element).val();
			if(score_type1 == 'Pass' || score_type1 == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('sd_value'));
				score = score + weightage;
			}else if(score_type1 == 'Fail'){
				var weightage = parseInt($(element).children("option:selected").attr('sd_value'));
				score = score + weightage;
			}
		});
		callHandScore=(callHandScore+score);
		$('#sd_communication_score1').val(callHandScore+'%');
		
		$('.reso_point1').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Pass' || score_type == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('sd_value'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'Fail'){
				var weightage = parseInt($(element).children("option:selected").attr('sd_value'));
				scoreable = scoreable + weightage;
			}
		});

		$('#sd_resolution_score1').val(scoreable+'%');
		
		quality_score_percent = (callHandScore+scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#superdaily_overall_score1').val(quality_score_percent+'%');
		}
		
		//$(document).on('change','.autof1',function(){
			// console.log($('#acf1').val());
			if($('#acf1').val()=='Fail' || $('#acf2').val()=='Fail' || $('#acf3').val()=='Fail' || $('#acf4').val()=='Fail' || $('#acf5').val()=='Fail' || $('#acf6').val()=='Fail' || $('#acf7').val()=='Fail'){
				$('.autoFail1').val(0+'%');
			}else{
				$('.autoFail1').val(quality_score_percent+'%');
			}
		//});
		
	}

/////////////////// Entice Energy ///////////////////////
	function entice_energy_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.ee_points').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('ee_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ee_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('ee_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#ee_earned_score').val(score);
		$('#ee_possible_score').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#ee_overall_score').val(quality_score_percent+'%');
		}
		
	}
	
/////////////////// DoubtNut ///////////////////////
	function doubtnut_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.doubtnut_points').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('doubtnut_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('doubtnut_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('doubtnut_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#dnt_earned_score').val(score);
		$('#dnt_possible_score').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#doubtnut_score').val(quality_score_percent+'%');
		}
		
	/////////////////
		$(document).on('change','.dntfatal',function(){
			if($('#dnt_fatal1').val()=='Fatal' || $('#dnt_fatal2').val()=='Fatal' || $('#dnt_fatal3').val()=='Fatal'){
				$('.doubtnutscore').val(0+'%');
			}else{
				$('.doubtnutscore').val(quality_score_percent+'%');
			}
		});
		
	}	
	
//////////////////////////// IDFC //////////////////////////////////	
	function idfc_calc(){
		var greeting = 0;
		var purposecall = 0;
		var collectionstechnique = 0;
		var communicationskill = 0;
		var telephoneetiquette = 0;
		var callclosing = 0;
		
		var overallScr = 0;
		
		$('.greeting').each(function(index,element){
			var score_type1 = $(element).val();
			if(score_type1 == 'Yes' || score_type1 == 'N/A'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('g_val'));
				greeting = greeting + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('g_val'));
				greeting = greeting + weightage1;
			}
		});
		
		if($('#gfatal1').val()=='No'){
			$('#greetingScore').val(0);
		}else{
			$('#greetingScore').val(greeting.toFixed(2));
		}
	///////////
		$('.purposecall').each(function(index,element){
			var score_type2 = $(element).val();
			if(score_type2 == 'Yes' || score_type2 == 'N/A'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('pc_val'));
				purposecall = purposecall + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('pc_val'));
				purposecall = purposecall + weightage2;
			}
		});
		if($('#pcfatal1').val()=='No'){
			$('#purposecallScore').val(0);
		}else{
			$('#purposecallScore').val(purposecall.toFixed(2));
		}
	////////
		$('.collectionstechnique').each(function(index,element){
			var score_type3 = $(element).val();
			if(score_type3 == 'Yes' || score_type3 == 'N/A'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('ct_val'));
				collectionstechnique = collectionstechnique + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('ct_val'));
				collectionstechnique = collectionstechnique + weightage3;
			}
		});
		if($('#ctfatal1').val()=='No' || $('#ctfatal2').val()=='No' || $('#ctfatal3').val()=='No'){
			$('#collectiontechniqueScore').val(0);
		}else{
			$('#collectiontechniqueScore').val(collectionstechnique.toFixed(2));
		}
	////////
		$('.communicationskill').each(function(index,element){
			var score_type4 = $(element).val();
			if(score_type4 == 'Yes' || score_type4 == 'N/A'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('cs_val'));
				communicationskill = communicationskill + weightage4;
			}else if(score_type4 == 'No'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('cs_val'));
				communicationskill = communicationskill + weightage4;
			}
		});
		
		if($('#csfatal1').val()=='No' || $('#csfatal2').val()=='No' || $('#csfatal3').val()=='No'){
			$('#communicatioskillScore').val(0);	
		}else{
			$('#communicatioskillScore').val(communicationskill.toFixed(2));
		}
	////////
		$('.telephoneetiquette').each(function(index,element){
			var score_type5 = $(element).val();
			if(score_type5 == 'Yes' || score_type5 == 'N/A'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('te_val'));
				telephoneetiquette = telephoneetiquette + weightage5;
			}else if(score_type5 == 'No'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('te_val'));
				telephoneetiquette = telephoneetiquette + weightage5;
			}
		});
		
		if($('#tefatal1').val()=='No' || $('#tefatal2').val()=='No' || $('#tefatal3').val()=='No'){
			$('#telephoneetiquetteScore').val(0);
		}else{
			$('#telephoneetiquetteScore').val(telephoneetiquette.toFixed(2));
		}
	////////
		$('.callclosing').each(function(index,element){
			var score_type6 = $(element).val();
			if(score_type6 == 'Yes' || score_type6 == 'N/A'){
				var weightage6 = parseFloat($(element).children("option:selected").attr('cc_val'));
				callclosing = callclosing + weightage6;
			}else if(score_type6 == 'No'){
				var weightage6 = parseFloat($(element).children("option:selected").attr('cc_val'));
				callclosing = callclosing + weightage6;
			}
		});
		$('#callclosingScore').val(callclosing.toFixed(2));
	/////////////////////
		overallScr = parseInt((greeting+purposecall+collectionstechnique+communicationskill+telephoneetiquette+callclosing));
		
		if($('#gfatal1').val()=='No' || $('#pcfatal1').val()=='No' || $('#ctfatal1').val()=='No' || $('#ctfatal2').val()=='No' || $('#ctfatal3').val()=='No' || $('#ctfatal4').val()=='No' || $('#csfatal1').val()=='No' || $('#csfatal2').val()=='No' || $('#csfatal3').val()=='No' || $('#tefatal1').val()=='No' || $('#tefatal2').val()=='No' || $('#tefatal3').val()=='No')
		{
			$('#idfcScore').val(0);
		}
		else
		{
			$('#idfcScore').val(overallScr+'%');
		}
		
	/////////////////////	
	}
	
	
//////////////////////// SXC //////////////////////////////	
	function sxc_calculation(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.sxc_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('sxc_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('sxc_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('sxc_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#sxc_earnedScore').val(score);
		$('#sxc_possibleScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#sxc_overallScore').val(quality_score_percent+'%');
		}
	}
	
//////////////////////// Ideal Living //////////////////////////////	
	function il_calculation(){
		var ilscore = 0;
		var ilscoreable = 0;
		var il_score_percent = 0;
		
		$('.il_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Absent'){
				var weightage = parseFloat($(element).children("option:selected").attr('il_val'));
				ilscore = ilscore + weightage;
				ilscoreable = ilscoreable+3;
			}else if(score_type == 'Action needed'){
				var weightage = parseFloat($(element).children("option:selected").attr('il_val'));
				ilscore = ilscore + weightage;
				ilscoreable = ilscoreable+3;
			}else if(score_type == 'Average'){
				var weightage = parseFloat($(element).children("option:selected").attr('il_val'));
				ilscore = ilscore + weightage;
				ilscoreable = ilscoreable+3;
			}else if(score_type == 'Awesome'){
				var weightage = parseFloat($(element).children("option:selected").attr('il_val'));
				ilscore = ilscore + weightage;
				ilscoreable = ilscoreable+3;
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('il_val'));
				ilscore = ilscore + weightage;
				ilscoreable = ilscoreable + weightage;
			}
		});
		$('#ilSalesActual').val(ilscore);
		$('#ilSalesPossible').val(ilscoreable);
		
		il_score_percent = ((ilscore*100)/ilscoreable).toFixed(2);
		
		if(!isNaN(il_score_percent)){
			$('#ilSalesScore').val(il_score_percent+'%');
		}
		
	////////////////
		if($("#ilsales_AF").val()=='Yes'){
			$('.ilsales_fatal').val(0);
		}else{
			$('.ilsales_fatal').val(il_score_percent+'%');
		}
		
		if($("#ilcs_AF").val()=='Fail'){
			$('.autofail').val(0);
		}else{
			$('.autofail').val(il_score_percent+'%');
		}
	
	
	}

	/////////saqlain ideal living feedback verification//////////

	function il_calculation_feedback(){

		var ilscore = 0;
		var ilscoreable = 0;
		var il_score_percent = 0;
		
		$('.il_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == '0'){
				var weightage = parseFloat($(element).children("option:selected").attr('il_val'));
				ilscore = ilscore + weightage;
				ilscoreable = ilscoreable+3;
			}else if(score_type == '1'){
				var weightage = parseFloat($(element).children("option:selected").attr('il_val'));
				ilscore = ilscore + weightage;
				ilscoreable = ilscoreable+2;
			}else if(score_type == '2'){
				var weightage = parseFloat($(element).children("option:selected").attr('il_val'));
				ilscore = ilscore + weightage + 1;
				ilscoreable = ilscoreable+4;
			}else if(score_type == '3'){
				var weightage = parseFloat($(element).children("option:selected").attr('il_val'));
				ilscore = ilscore + weightage;
				ilscoreable = ilscoreable+3;
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('il_val'));
				ilscore = ilscore + weightage;
				ilscoreable = ilscoreable + weightage;
			}
		});
		$('#ilSalesActual').val(ilscore);
		$('#ilSalesPossible').val(ilscoreable);
		
		il_score_percent = ((ilscore*100)/ilscoreable).toFixed(2);
		
		if(!isNaN(il_score_percent)){
			$('#ilSalesScore').val(il_score_percent+'%');
		}

	}

	//////////////////////Kenny-U-Pull////////////////////////////
	
	function kenny_u_pull_calc(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.kennyVal').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('kenny_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('kenny_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('kenny_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#kennyEarnedScore').val(score);   
		$('#kennyPossibleScore').val(scoreable);

		// if(!isNaN(quality_score_percent)){
		// 	$('#sensioOverallScore').val(quality_score_percent+'%');
		// }

		if(($('#kenny_AF1').val()=='Yes') || $('#kenny_AF2').val()=='Yes' || $('#file_opening').val()=='No'){
		$('#kennyOverallScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#kennyOverallScore').val(quality_score_percent+'%');
			}	
		}

		
		$('#pass_count').val(pass_count);
		$('#fail_count').val(fail_count);
		$('#na_count').val(na_count);
		

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custSenEarned').text(customerScore);
		$('#custSenPossible').text(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		// if(!isNaN(customerPercentage)){
		// 	$('#custSenScore').val(customerPercentage+'%');
		// }
		if(($('#kenny_AF1').val()=='Yes') || $('#kenny_AF2').val()=='Yes' || $('#file_opening').val()=='No'){
		$('#custSenScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#custSenScore').val(quality_score_percent+'%');
			}	
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('kenny_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('kenny_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('kenny_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busiSenEarned').text(businessScore);
		$('#busiSenPossible').text(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busiSenScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('kenny_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('kenny_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('kenny_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#complSenEarned').text(complianceScore);
		$('#complSenPossible').text(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complSenScore').val(compliancePercentage+'%');
		}
	}


	/////////////////////////////////////////////////
	
////////////////// SENSIO ////////////////////////	
	function sensio_calc(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.sensioVal').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('sen_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('sen_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('sen_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#sensioEarnedScore').val(score);
		$('#sensioPossibleScore').val(scoreable);

		// if(!isNaN(quality_score_percent)){
		// 	$('#sensioOverallScore').val(quality_score_percent+'%');
		// }

		if(($('#sensio_AF1').val()=='No') || $('#sensio_AF2').val()=='No'){
		$('#sensioOverallScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#sensioOverallScore').val(quality_score_percent+'%');
			}	
		}

		
		$('#pass_count').val(pass_count);
		$('#fail_count').val(fail_count);
		$('#na_count').val(na_count);
		

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('sen_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseFloat($(element).children("option:selected").attr('sen_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('sen_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custSenEarned').text(customerScore);
		$('#custSenPossible').text(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		// if(!isNaN(customerPercentage)){
		// 	$('#custSenScore').val(customerPercentage+'%');
		// }
		if(($('#sensio_AF1').val()=='No') || $('#sensio_AF2').val()=='No'){
		$('#custSenScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#custSenScore').val(quality_score_percent+'%');
			}	
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('sen_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('sen_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('sen_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busiSenEarned').text(businessScore);
		$('#busiSenPossible').text(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busiSenScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('sen_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('sen_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('sen_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#complSenEarned').text(complianceScore);
		$('#complSenPossible').text(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complSenScore').val(compliancePercentage+'%');
		}
	}

/////////////////////////////////////////// Cinemark ///////////////////////////////////////
	function cinemark_calc(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.amd_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Effective'){
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('amd_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Unacceptable'){
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('amd_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}else if(score_type == 'Effective with errors'){
				var weightage = parseInt($(element).children("option:selected").attr('amd_val'));
				var weightage1 = parseInt($(element).children("option:selected").attr('amd_max'));
				score = score + weightage;
				scoreable = scoreable + weightage1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#cin_earned_score').val(score);
		$('#cin_possible_score').val(scoreable);

		if(!isNaN(quality_score_percent)){
			$('#cin_overall_score').val(quality_score_percent+'%');
		}
		
		$('#pass_count').val(pass_count);
		$('#fail_count').val(fail_count);
		$('#na_count').val(na_count);
		
	//////////
		if($("#cinemarkAF1").val()=='Yes' || $("#cinemarkAF2").val()=='Yes' || $("#cinemarkAF3").val()=='Yes'){
			$(".cinemarkFatal").val(0);
		}else{
			$(".cinemarkFatal").val(quality_score_percent+'%');
		}

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Effective'){
				var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'Unacceptable'){
				var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custCinEarned').text(customerScore);
		$('#custCinPossible').text(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#custCinScore').val(customerPercentage+'%');
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Effective'){
				var w2 = parseInt($(element).children("option:selected").attr('amd_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'Unacceptable'){
				var w2 = parseInt($(element).children("option:selected").attr('amd_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('amd_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busiCinEarned').text(businessScore);
		$('#busiCinPossible').text(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busiCinScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Effective'){
				var w3 = parseInt($(element).children("option:selected").attr('amd_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'Unacceptable'){
				var w3 = parseInt($(element).children("option:selected").attr('amd_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('amd_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#complCinEarned').text(complianceScore);
		$('#complCinPossible').text(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complCinScore').val(compliancePercentage+'%');
		}
	}


	
</script>

 
 <script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
 </script>
 
 
 <script>
 //// KIWI ///
  var a,b,c;
  
   	$('.common').on('change', function(){ 
		a = $('#text1').val();
		b = $('#text2').val();
		c = $('#text3').val();

		check_pass_fail(a,b,c);
		
	});
	
	function check_pass_fail(a,b,c){

			if(a==''){
				calculation();
			}else if(b == ''){
				calculation();
			}else if(c== ''){
				calculation();
			}
			
			if(a=='Pass' && b=='Pass' && c=='Pass'){
				//alert("success");
				calculation();
			}else{
				//alert("falilure");
				calculation();
				$('#quality_score').val(0);
			} 
			
			
			
			
	}
	
	var i=0;
	
	$('.common_calulation').on('change', function(){  
		t1 = $('#text1').val();
		t2 = $('#text2').val();
		t3 = $('#text3').val();
		
		a = $('#text4').val();
		b = $('#text5').val();
		c = $('#text6').val();
		  
		calculation();
		check_pass_fail(t1,t2,t3);
	 
	});
	
	function calculation(){
		a = $('#text4').val() != '' ? parseInt($('#text4').val()) : 0;
		b = $('#text5').val() != '' ? parseInt($('#text5').val()) : 0;
		c = $('#text6').val() != '' ? parseInt($('#text6').val()) : 0;
		
        var total = (a+b+c);
		
			$('#achieved_score').val(parseInt(total));
			var percentage = (total/100)*100;
			$('#quality_score').val(parseInt(percentage));
		
			  $('#comment2').empty();
			 
				    $('#text4').val() != '0'? $('#comment2').append(''): $('#comment2').append('2.1 is Fail &');
					$('#text5').val() != '0'? $('#comment2').append(''): $('#comment2').append(' 2.2 is Fail &');
					$('#text6').val() != '0'? $('#comment2').append(''): $('#comment2').append(' 2.3 is Fail &');
				
				var h = $('#comment2').val();
				var k = $.trim(h);
				var j = k.split('&')
			
	}
 
 </script>
 
 <script>
   $('document').ready(function(){
	   $('#accept_reject').on('change',function(){
       
        var optionText = $("#accept_reject option:selected").text();
		if(optionText === ''){
			alert("Please select the Accept reject option");
			$('#accept_reject').focus();
		}
        
    });
	   
   });
</script>


<script>

$( "#client_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Client ID")
		var URL='<?php echo base_url();?>Qa_agent_coaching/get_client';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aid,
			success: function(aList){ 
				var json_obj = $.parseJSON(aList); 
				
					 $('#agent_id_process').empty();
				     $('#agent_id_process').append("<option value=''>--Select--</option>"); 
				for(i=0; i < json_obj.length;i++){
					 var newoption = '<option value='+ json_obj[i].id +'>'+ json_obj[i].name+' - '+json_obj[i].office_id +'</option>';
					 $('#agent_id_process').append(newoption);
				}
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		});
	});

	
	$( "#agent_id_process" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_metropolis/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#process_id').append($('#process_id').val(json_obj[i].process_id));
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

<script>
///////////////// ACM ///////////////////
	function acm_score(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.acm_points').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var w2 = parseInt($(element).children("option:selected").attr('acm_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}else if(score_type == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var w2 = parseInt($(element).children("option:selected").attr('acm_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}else if(score_type == 'Meets'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var w2 = parseInt($(element).children("option:selected").attr('acm_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}else if(score_type == 'Coaching'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var w2 = parseInt($(element).children("option:selected").attr('acm_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}else if(score_type == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var w2 = parseInt($(element).children("option:selected").attr('acm_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			} 
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#acm_earn_score').val(score);
		$('#acm_possible_score').val(scoreable);

		if(!isNaN(quality_score_percent)){
			$('#acm_overall_score').val(quality_score_percent+'%');
		}
		
		if($('#acmAF1').val()=='Yes' || $('#acmAF2').val()=='Yes' ){
			$('.acmFatal').val(0);
		}else{
			$('.acmFatal').val(quality_score_percent+'%');
		}

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var cw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var cw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				customerScore = customerScore + cw1;
				customerScoreable = customerScoreable + cw2;
			}else if(sc1 == 'No'){
				var cw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var cw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				customerScore = customerScore + cw1;
				customerScoreable = customerScoreable + cw2;
			}else if(sc1 == 'Meets'){
				var cw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var cw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				customerScore = customerScore + cw1;
				customerScoreable = customerScoreable + cw2;
			}else if(sc1 == 'Coaching'){
				var cw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var cw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				customerScore = customerScore + cw1;
				customerScoreable = customerScoreable + cw2;
			}else if(sc1 == 'N/A'){
				var cw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var cw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				customerScore = customerScore + cw1;
				customerScoreable = customerScoreable + cw2;
			}
		});
		$('#custAcmEarned').text(customerScore);
		$('#custAcmPossible').text(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#custAcmScore').val(customerPercentage+'%');
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var bw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var bw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				businessScore = businessScore + bw1;
				businessScoreable = businessScoreable + bw2;
			}else if(sc2 == 'No'){
				var bw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var bw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				businessScore = businessScore + bw1;
				businessScoreable = businessScoreable + bw2;
			}else if(sc2 == 'Meets'){
				var bw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var bw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				businessScore = businessScore + bw1;
				businessScoreable = businessScoreable + bw2;
			}else if(sc2 == 'Coaching'){
				var bw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var bw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				businessScore = businessScore + bw1;
				businessScoreable = businessScoreable + bw2;
			}else if(sc2 == 'N/A'){
				var bw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var bw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				businessScore = businessScore + bw1;
				businessScoreable = businessScoreable + bw2;
			}
		});
		$('#busiAcmEarned').text(businessScore);
		$('#busiAcmPossible').text(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busiAcmScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var cpw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var cpw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				complianceScore = complianceScore + cpw1;
				complianceScoreable = complianceScoreable + cpw2;
			}else if(sc3 == 'No'){
				var cpw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var cpw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				complianceScore = complianceScore + cpw1;
				complianceScoreable = complianceScoreable + cpw2;
			}else if(sc3 == 'Meets'){
				var cpw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var cpw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				complianceScore = complianceScore + cpw1;
				complianceScoreable = complianceScoreable + cpw2;
			}else if(sc3 == 'Coaching'){
				var cpw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var cpw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				complianceScore = complianceScore + cpw1;
				complianceScoreable = complianceScoreable + cpw2;
			}else if(sc3 == 'N/A'){
				var cpw1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var cpw2 = parseInt($(element).children("option:selected").attr('acm_max'));
				complianceScore = complianceScore + cpw1;
				complianceScoreable = complianceScoreable + cpw2;
			}
		});
		$('#complAcmEarned').text(complianceScore);
		$('#complAcmPossible').text(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complAcmScore').val(compliancePercentage+'%');
		}
	
	}
	
	
	$(document).ready(function(){
		$(document).on('change','.acm_points',function(){ acm_score(); });
		$(document).on('change','.customer',function(){ acm_score(); });
		$(document).on('change','.business',function(){ acm_score(); });
		$(document).on('change','.compliance',function(){ acm_score(); });
		acm_score();
	});
		
</script>

<script>
///////////// Superdaily New ////////////////
	$(document).ready(function(){
		
		$('#spdl_acpt').on('change', function(){
			if($(this).val()=='Agent'){
				var spdl_agent = '<option value="">Select</option>';
				spdl_agent += '<option value="Incomplete Information shared">Incomplete Information shared</option>';
				spdl_agent += '<option value="Incorrect Information shared">Incorrect Information shared</option>';
				spdl_agent += '<option value="Resolution not provided">Resolution not provided</option>';
				spdl_agent += '<option value="Lack of Ownership">Lack of Ownership</option>';
				spdl_agent += '<option value="Knowledge Gap">Knowledge Gap</option>';
				spdl_agent += '<option value="Soft skill issue">Soft skill issue</option>';
				$("#spdl_why1").html(spdl_agent);
			}else if($(this).val()=='Process'){
				var spdl_process = '<option value="">Select</option>';
				spdl_process += '<option value="Consumption issues">Consumption issues</option>';
				spdl_process += '<option value="Delivery timing">Delivery timing</option>';
				spdl_process += '<option value="Item not available">Item not available</option>';
				spdl_process += '<option value="MRP issue">MRP issue</option>';
				spdl_process += '<option value="Non-serviceable area">Non-serviceable area</option>';
				spdl_process += '<option value="Offer related issue">Offer related issue</option>';
				spdl_process += '<option value="Order not delivered">Order not delivered</option>';
				spdl_process += '<option value="Payment related issue">Payment related issue</option>';
				spdl_process += '<option value="Quality issue">Quality issue</option>';
				spdl_process += '<option value="Quantity issue">Quantity issue</option>';
				spdl_process += '<option value="Supr credits expiry">Supr credits expiry</option>';
				spdl_process += '<option value="Supr access related">Supr access related</option>';
				spdl_process += '<option value="Refund related">Refund related</option>';
				spdl_process += '<option value="Call back not done">Call back not done</option>';
				spdl_process += '<option value="Order related">Order related</option>';
				spdl_process += '<option value="Invoice issue">Invoice issue</option>';
				spdl_process += '<option value="Partial order delivered">Partial order delivered</option>';
				spdl_process += '<option value="Delivery fee related">Delivery fee related</option>';
				spdl_process += '<option value="Bag not received">Bag not received</option>';
				spdl_process += '<option value="Stock Issue">Stock Issue</option>';
				$("#spdl_why1").html(spdl_process);
			}else if($(this).val()=='Customer'){
				var spdl_customer = '<option value="">Select</option>';
				spdl_customer += '<option value="Consumption issues">Consumption issues</option>';
				spdl_customer += '<option value="Order not delivered">Order not delivered</option>';
				spdl_customer += '<option value="Payment related issue">Payment related issue</option>';
				spdl_customer += '<option value="Quality issue">Quality issue</option>';
				spdl_customer += '<option value="Refund issue">Refund issue</option>';
				spdl_customer += '<option value="Free item not added in the cart">Free item not added in the cart</option>';
				spdl_customer += '<option value="Called For Reconfirmation">Called For Reconfirmation</option>';
				$("#spdl_why1").html(spdl_customer);
			}else if($(this).val()=='Tech Issue'){
				var spdl_tech = '<option value="">Select</option>';
				spdl_tech += '<option value="App issue">App issue</option>';
				spdl_tech += '<option value="Payment related issue">Payment related issue</option>';
				spdl_tech += '<option value="Subscription issue">Subscription issue</option>';
				spdl_tech += '<option value="Charged More than MRP">Charged More than MRP</option>';
				$("#spdl_why1").html(spdl_tech);
			}
		});
		
		
		$(document).on('keyup','#ucp',function(){
			superdaily_new();
		});
		$(document).on('keyup','#tnasp',function(){
			superdaily_new();
		});
		$(document).on('keyup','#cuwbd',function(){
			superdaily_new();
		});
		$(document).on('keyup','#whc',function(){
			superdaily_new();
		});
		$(document).on('keyup','.spdl',function(){
			superdaily_new();
		});
		$(document).on('change','.spdl_fatal',function(){
			superdaily_new();
		});
		superdaily_new();
		
	});
	
	function superdaily_new(){
		var ucpScore = 0;
		var tnaScore = 0;
		var cuScore = 0;
		var hcScore = 0;
		
		$('.spdl').each(function(index,element){
			
			var ucp_score = $("#ucp").val();
			$('#ucp_earned').val(ucp_score);
			$('#ucp_possible').val(20);
			ucpScore = ((ucp_score*100)/20).toFixed(2);
			if(!isNaN(ucpScore)){
				$('#ucp_percentage').val(ucpScore+'%');
			}
		////////
			var tna_score = $("#tnasp").val();
			$('#tna_earned').val(tna_score);
			$('#tna_possible').val(40);
			tnaScore = ((tna_score*100)/40).toFixed(2);
			if(!isNaN(tnaScore)){
				$('#tna_percentage').val(tnaScore+'%');
			}
		/////////
			var cu_score = $("#cuwbd").val();
			$('#cu_earned').val(cu_score);
			$('#cu_possible').val(20);
			cuScore = ((cu_score*100)/20).toFixed(2);
			if(!isNaN(cuScore)){
				$('#cu_percentage').val(cuScore+'%');
			}
		//////////
			var hc_score = $("#whc").val();
			$('#hc_earned').val(hc_score);
			$('#hc_possible').val(20);
			hcScore = ((hc_score*100)/20).toFixed(2);
			if(!isNaN(hcScore)){
				$('#hc_percentage').val(hcScore+'%');
			}
		//////////
			
			var min_overall_score = Math.min(ucpScore, tnaScore, cuScore, hcScore);
			
		////////Superdaily//////////
			if($('#spdlAF1').val()=='Yes' || $('#spdlAF2').val()=='Yes'){
				$('#newSPDL').val(0);
			}else{
				$('#newSPDL').val(min_overall_score+'%');
			}
		
		////////Superdaily (Complaint Resolution)//////////
			if($('#spdlResoAF1').val()=='No' || $('#spdlResoAF2').val()=='No' || $('#spdlResoAF3').val()=='Yes' || $('#spdlResoAF4').val()=='Yes'){
				$('#newSPDLReso').val(0);
			}else{
				$('#newSPDLReso').val(min_overall_score+'%');
			}
			
		
		});
		
	}
</script>



<script type="text/javascript">
/////////////////// Payneraby [QA Feedback] /////////////////////
	$(document).ready(function(){
		
		$(".addQaFeedback").click(function(){
			var mpid=$(this).attr("mpid");
			var pnb_tbl=$(this).attr("pnb_tbl");
			$('.frmAddQaFeedbackModel #mpid').val(mpid);
			$('.frmAddQaFeedbackModel #pnb_tbl').val(pnb_tbl);
			$("#addQaFeedbackModel").modal('show');

		});
		
	});
</script>