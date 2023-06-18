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
//////////////////////POST DELIVERY JS///////////////////////////////
	 $("#disposition").on('change', function() {
        var isAll = '';
        var dispo = this.value;
		
        if (dispo == "") alert("Please Select Disposition")
        $('#sktPleaseWait').modal('show');

    	$('#sub_dispo').empty();
        $('#sub_dispo').append($('#sub_dispo').val(''));
        if (dispo == "") {
            if (isAll == 'Y') $('#sub_dispo').append($('<option></option>')
                .val('ALL').html('ALL'));
            else $('#sub_dispo').append($('<option></option>').val('NA')
                .html('NA'));
            $('#sktPleaseWait').modal('hide');
        } else {
            if (isAll == 'Y') $('#sub_dispo').append($('<option></option>')
                .val('ALL').html('ALL'));
            else $('#sub_dispo').append($('<option></option>').val('')
                .html('-- Select --'));

            if(dispo == 'Open') {
                $('#sub_dispo').append($('<option></option>').val('Call back').html('Call back'));
                $('#sub_dispo').append($('<option></option>').val('Short hung up').html('Short hung up'));
            }
            if(dispo == 'RC Transfer & Handover (Rename)') {
                $('#sub_dispo').append($('<option></option>').val('RC Transfer Status Update < 60 days').html('RC Transfer Status Update < 60 days'));
                $('#sub_dispo').append($('<option></option>').val('RC Transfer Status Update > 60 days').html('RC Transfer Status Update > 60 days'));
                $('#sub_dispo').append($('<option></option>').val('RC Transferred but Copy not received').html('RC Transferred but Copy not received'));
                $('#sub_dispo').append($('<option></option>').val('Buyer party peshi holdback').html('Buyer party peshi holdback'));
                $('#sub_dispo').append($('<option></option>').val('Buyer to collect RC from office').html('Buyer to collect RC from office'));
                $('#sub_dispo').append($('<option></option>').val('RC already received by the buyer').html('RC already received by the buyer'));
                $('#sub_dispo').append($('<option></option>').val('RC already received by the buyer').html('RC already received by the buyer'));
                $('#sub_dispo').append($('<option></option>').val('Change in RC details').html('Change in RC details'));
            }
             if(dispo == 'Return Related') {
                $('#sub_dispo').append($('<option></option>').val('New Return Request').html('New Return Request'));
                $('#sub_dispo').append($('<option></option>').val('Car Pick-up Pending').html('Car Pick-up Pending'));
                $('#sub_dispo').append($('<option></option>').val('Car Returned but Refund not Received').html('Car Returned but Refund not Received'));
                $('#sub_dispo').append($('<option></option>').val('Return Related Query').html('Return Related Query'));
            }
             if(dispo == 'Warranty/ Repair') {
                $('#sub_dispo').append($('<option></option>').val('Warranty Related Query').html('Warranty Related Query'));
                $('#sub_dispo').append($('<option></option>').val('New Repair Request').html('New Repair Request'));
                $('#sub_dispo').append($('<option></option>').val('Repair Reimbursement Not Received').html('Repair Reimbursement Not Received'));
                $('#sub_dispo').append($('<option></option>').val('Repair Status Update').html('Repair Status Update'));
                $('#sub_dispo').append($('<option></option>').val('Repair parts related query').html('Repair parts related query'));
                $('#sub_dispo').append($('<option></option>').val('Roadside Assistance Required').html('Roadside Assistance Required'));
            }
             if(dispo == 'Loan Related') {
                $('#sub_dispo').append($('<option></option>').val('Car Health Monitor concern').html('Car Health Monitor concern'));
                $('#sub_dispo').append($('<option></option>').val('EMI related').html('EMI related'));
                $('#sub_dispo').append($('<option></option>').val('Foreclosure related').html('Foreclosure related'));
                $('#sub_dispo').append($('<option></option>').val('Complaint related Car Loan').html('Complaint related Car Loan'));
            }
            if(dispo == 'Dropped') {
                $('#sub_dispo').append($('<option></option>').val('Language barrier').html('Language barrier'));
            }
            if(dispo == 'Other Post Sale Support') {
                $('#sub_dispo').append($('<option></option>').val('Invoice related concern').html('Invoice related concern'));
                $('#sub_dispo').append($('<option></option>').val('Insurance related concern').html('Insurance related concern'));
                $('#sub_dispo').append($('<option></option>').val('Second Car Key not received').html('Second Car Key not received'));
                $('#sub_dispo').append($('<option></option>').val('Interested in new booking').html('Interested in new booking'));
                $('#sub_dispo').append($('<option></option>').val('Pre existing challan').html('Pre existing challan'));
                $('#sub_dispo').append($('<option></option>').val('Car part missing issue').html('Car part missing issue'));
                $('#sub_dispo').append($('<option></option>').val('FasTag Related Concern').html('FasTag Related Concern'));
                $('#sub_dispo').append($('<option></option>').val('Legal related concern').html('Legal related concern'));
                $('#sub_dispo').append($('<option></option>').val('Post sale feedback').html('Post sale feedback'));
                $('#sub_dispo').append($('<option></option>').val('Do not Call').html('Do not Call'));
                $('#sub_dispo').append($('<option></option>').val('High Security number plate concern').html('High Security number plate concern'));
                $('#sub_dispo').append($('<option></option>').val('Wants to sell the car').html('Wants to sell the car'));

            }
            if(dispo == 'Ad Hoc Calling') {
                $('#sub_dispo').append($('<option></option>').val('NPS Calling D+30').html('NPS Calling D+30'));
                $('#sub_dispo').append($('<option></option>').val('NPS Calling D+60').html('NPS Calling D+60'));
                $('#sub_dispo').append($('<option></option>').val('Welcome Calling').html('Welcome Calling'));
                $('#sub_dispo').append($('<option></option>').val('Customer Not Interested in Feedback').html('Customer Not Interested in Feedback'));
            }
            
            $('#sktPleaseWait').modal('hide');
        }

        if (isAll == 'Y') $('#sub_dispo').val("ALL");
        else $('#sub_dispo').val('');
    });
</script>

<script type="text/javascript">
	 $("#sub_dispo").on('change', function() {
        var isAll = '';
        var subdispo = this.value;
        console.log(subdispo);
		
       // if (subdispo == "") alert("Please Select Disposition")
        $('#sktPleaseWait').modal('show');

    	$('#sub_subdispo').empty();
        //$('#sub_subdispo').append($('#sub_subdispo').val(''));

            if(subdispo == 'Call back') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has asked to callback on a specific time').html('Customer has asked to callback on a specific time'));
            }
            if(subdispo == 'Short hung up') {
                $('#sub_subdispo').append($('<option></option>').val('Customer disconnected the call or no response from customer within 30 sec.').html('Customer disconnected the call or no response from customer within 30 sec.'));
            }
             if(subdispo == 'RC Transfer Status Update < 60 days') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to status/update regarding RC transfer with in 60 days').html('Customer has query related to status/update regarding RC transfer with in 60 days'));
            }
             if(subdispo == 'RC Transfer Status Update > 60 days') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to update/RC transfer status after 60 days').html('Customer has query related to update/RC transfer status after 60 days.'));
            }
             if(subdispo == 'RC Transferred but Copy not received') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has not recieved the RC hard copy after Rc transfer completed').html('Customer has not recieved the RC hard copy after Rc transfer completed'));
            }
            if(subdispo == 'Buyer party peshi holdback') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has concern/query related to party peshi for RC transfer or  holdback refund pending related to RC').html('Customer has concern/query related to party peshi for RC transfer or  holdback refund pending related to RC'));
            }
            if(subdispo == 'Buyer to collect RC from office') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants to collect Rc from office by him/her self').html('Customer wants to collect Rc from office by him/her self'));
            }
            if(subdispo == 'RC already received by the buyer') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has already recieved the physical RC').html('Customer has already recieved the physical RC'));
            }
            if(subdispo == 'Courier address received') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has shared his address for the RC hard copy delivery').html('Customer has shared his address for the RC hard copy delivery'));
            }
            if(subdispo == 'Change in RC details') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants to change details in RC ( name, address etc)').html('Customer wants to change details in RC ( name, address etc)'));
            }
            if(subdispo == 'New Return Request') {
                $('#sub_subdispo').append($('<option></option>').val('First call for return - customer has raised the request first time to return the car').html('First call for return - customer has raised the request first time to return the car'));
            }
            if(subdispo == 'Car Pick-up Pending') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has raised the concern for return but car did not get picked up').html('Customer has raised the concern for return but car did not get picked up'));
            }
            if(subdispo == 'Car Returned but Refund not Received') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has not recieved his refund after returning the car').html('Customer has not recieved his refund after returning the car'));
            }
            if(subdispo == 'Return Related Query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to return/ wants to enquire about return process/ not eligible for returning the car post 7 days').html('Customer has query related to return/ wants to enquire about return process/ not eligible for returning the car post 7 days'));
            }
            if(subdispo == 'Warranty Related Query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to Warranty/repair/ wants to know how can we avail warranty').html('Customer has query related to Warranty/repair/ wants to know how can we avail warranty'));
            }
            if(subdispo == 'New Repair Request') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has raised the first time concern related to repair/warranty').html('Customer has raised the first time concern related to repair/warranty'));
            }
            if(subdispo == 'Repair Reimbursement Not Received') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has not recieved reimbursment').html('Customer has not recieved reimbursment'));
            }
            if(subdispo == 'Repair Status Update') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants to know update regarding raised concern/ticket related to warranty/repair').html('Customer wants to know update regarding raised concern/ticket related to warranty/repair'));
            }
            if(subdispo == 'Repair parts related query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to particular car part/ What all parts covered under warranty').html('Customer has query related to particular car part/ What all parts covered under warranty'));
            }
            if(subdispo == 'Roadside Assistance Required') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has concern/query related to RSA or want support from RSA').html('Customer has concern/query related to RSA or want support from RSA'));
            }
            if(subdispo == 'Car Health Monitor concern') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query/ concern related to Car health monitor/ GPS').html('Customer has query/ concern related to Car health monitor/ GPS'));
            }
            if(subdispo == 'EMI related') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has concern issue related to EMI / Not able to pay EMI/ EMI did not get deducted/ Got deducted twice').html('Customer has concern issue related to EMI / Not able to pay EMI/ EMI did not get deducted/ Got deducted twice'));
            }
            if(subdispo == 'Foreclosure related') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants to foreclose his loan/ has query related to foreclose/ forclosure charges/ status of forclosure request').html('Customer wants to foreclose his loan/ has query related to foreclose/ forclosure charges/ status of forclosure request'));
            }
            if(subdispo == 'Complaint related Car Loan') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has concern related to Loan terms/polocies/staff/ change in rate of interest').html('Customer has concern related to Loan terms/polocies/staff/ change in rate of interest'));
            }
            if(subdispo == 'Language barrier') {
                $('#sub_subdispo').append($('<option></option>').val('Wants call in different language').html('Wants call in different language'));
            }
            if(subdispo == 'Invoice related concern') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants changes in voice or has some query related to invoice/ mismatch in received invoice').html('Customer wants changes in voice or has some query related to invoice/ mismatch in received invoice'));
            }
            if(subdispo == 'Insurance related concern') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has concern related to insurance claim/transfer').html('Customer has concern related to insurance claim/transfer'));
            }
            if(subdispo == 'Second Car Key not received') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has not recieved duplicate key of the delivered car').html('Customer has not recieved duplicate key of the delivered car'));
            }
            if(subdispo == 'Interested in new booking') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants to book another car after delivery').html('Customer wants to book another car after delivery'));
            }
            if(subdispo == 'Pre existing challan') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has concern related to previous unpaid challans on the car').html('Customer has concern related to previous unpaid challans on the car'));
            }
            if(subdispo == 'Car part missing issue') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has concern related to car parts missing at the time of delivery or after repair work').html('Customer has concern related to car parts missing at the time of delivery or after repair work'));
            }
            if(subdispo == 'FasTag Related Concern') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has some Query/want to get fastag registered his name').html('Customer has some Query/want to get fastag registered his name'));
            }
            if(subdispo == 'Legal related concern') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has some legal issue on the car after delivery/ accidental case').html('Customer has some legal issue on the car after delivery/ accidental case'));
            }
            if(subdispo == 'Post sale feedback') {
                $('#sub_subdispo').append($('<option></option>').val('If any disposition not available for any particular concern, submit in this / Any feedback that customer wants to share').html('If any disposition not available for any particular concern, submit in this / Any feedback that customer wants to share'));
            }
            if(subdispo == 'Do not Call') {
                $('#sub_subdispo').append($('<option></option>').val('Customer does not want any call from cars24').html('Customer does not want any call from cars24'));
            }
            if(subdispo == 'High Security number plate concern') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has concern related to transfer of high security number plate').html('Customer has concern related to transfer of high security number plate'));
            }
            if(subdispo == 'Wants to sell the car') {
                $('#sub_subdispo').append($('<option></option>').val('customer wants to sell the car').html('customer wants to sell the car'));
            }
            if(subdispo == 'NPS Calling D+30') {
                $('#sub_subdispo').append($('<option></option>').val('NPS D+30').html('NPS D+30'));
            }
             if(subdispo == 'NPS Calling D+60') {
                $('#sub_subdispo').append($('<option></option>').val('NPS D+60').html('NPS D+60'));
            }
             if(subdispo == 'Welcome Calling') {
                $('#sub_subdispo').append($('<option></option>').val('Welcome call').html('Welcome call'));
            }
             if(subdispo == 'Customer Not Interested in Feedback') {
                $('#sub_subdispo').append($('<option></option>').val('NPS').html('NPS'));
            }

            $('#sktPleaseWait').modal('hide');
    });
</script>



<script type="text/javascript">
/////////////////////////////////////////////////////
$(document).ready(function(){

	
	$("#mail_action_date").datepicker();
	$("#tat_replied_date").datepicker();
	$("#cycle_date").datepicker();
	$("#week_end_date").datepicker();
	$("#call_date_time").datetimepicker();

	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date()}); //datetimepicker
	$("#call_date_time").datetimepicker({maxDate: new Date()});
	//$("#call_date").datepicker({ minDate: 0 });
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });

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

////////////////////////// ACM ///////////////////////////////
	$('#scripted_opening').on('change', function(){
		acm_score();
	});
	$('#call_flow').on('change', function(){
		acm_score();
	});
	$('#educate_customer').on('change', function(){
		acm_score();
	});
	$('#close_script').on('change', function(){
		acm_score();
	});
	$('#evident_smile').on('change', function(){
		acm_score();
	});
	$('#listening_acknow').on('change', function(){
		acm_score();
	});
	$('#grammer_pronoun').on('change', function(){
		acm_score();
	});
	$('#ownership_polite').on('change', function(){
		acm_score();
	});

////////////////////////// CLIO For Nilkanta///////////////////////////////
	$(document).on('change','.jurry_points',function(){
		do_calculation();
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

////////////////// SENSIO /////////////////////
	$(document).on('change','.sensioVal',function(){
		sensio_calc();
	});
	sensio_calc();

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
	$( "#agent_ids" ).on('change' , function(){
		let aidd = this.value;
		//alert(aid);
		if(aidd==""){
			alert("Please Select Agent");
			//return false;
		}
		var URL='<?php echo base_url();?>qa_vrs/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aidd,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_names').empty();
				$('#tl_names').append($('#tl_names').val(''));
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));
			    for (var i in json_obj){
					if($('#tl_names').val(json_obj[i].tl_name)!=''){
						console.log(json_obj[0].tl_name);
						$('#tl_names').append($('#tl_names').val(json_obj[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				}		

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

//////////////////////ACM///////////////////////////////
	function acm_score(){
		var a1 = parseInt($("#scripted_opening option:selected").attr("acm_val"));
		var a2 = parseInt($("#call_flow option:selected").attr("acm_val"));
		var a3 = parseInt($("#educate_customer option:selected").attr("acm_val"));
		var a4 = parseInt($("#close_script option:selected").attr("acm_val"));
		var a5 = parseInt($("#evident_smile option:selected").attr("acm_val"));
		var a6 = parseInt($("#listening_acknow option:selected").attr("acm_val"));
		var a7 = parseInt($("#grammer_pronoun option:selected").attr("acm_val"));
		var a8 = parseInt($("#ownership_polite option:selected").attr("acm_val"));

		var acm_tot = a1+a2+a3+a4+a5+a6+a7+a8;

		if(!isNaN(acm_tot)){
			document.getElementById("acm_overall_score").value= acm_tot+'%';
		}

		return acm_tot;
	}

///////////////////////////CLIO for Nilkanta//////////////////////////////
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
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#jurys_inn_earned_score').val(score);
		$('#jurys_inn_possible_score').val(scoreable);

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
				var w1 = parseInt($(element).children("option:selected").attr('ji_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('ji_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('ji_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custJiCisEarned').text(customerScore);
		$('#custJiCisPossible').text(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#custJiCisScore').val(customerPercentage+'%');
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('ji_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('ji_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('ji_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busiJiCisEarned').text(businessScore);
		$('#busiJiCisPossible').text(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busiJiCisScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('ji_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('ji_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('ji_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#complJiCisEarned').text(complianceScore);
		$('#complJiCisPossible').text(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complJiCisScore').val(compliancePercentage+'%');
		}


	///////////////CIS Autofail ///////////////
		if($('#clioAF1').val() == 'Yes' || $('#overcome_terms').val() == 'No' || $('#closure_booking').val() == 'No'){
			($('#jurys_inn_overall_score').val(0) && $('#clioAF1').val('Yes').css('color','Red'));


		}else{
			if(!isNaN(quality_score_percent)){
				($('#jurys_inn_overall_score').val(quality_score_percent+'%') && $('#clioAF1').val('No').css('color','Green'));
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



	////////////CLIO for Nilkanta (Not Use It)///////////////


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

////////////////// SENSIO ////////////////////////
	function sensio_calc(){
		var sensioScore=0;
		$('.sensioVal').each(function(index,element){
			var score_type = parseFloat($(element).children("option:selected").attr('sen_val'));
			sensioScore = score_type+sensioScore;
		});

		if(!isNaN(sensioScore)){
			$('#sensioOverallScore').val(sensioScore+'%');
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


<!-- <script>

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
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));
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

</script> -->

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

<script>
////////////////////// Kiwi ////////////////////
function do_kiwi(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;

		$('.kiwi').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('kiwi_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('kiwi_val'));
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#earnedScore_kiwi').val(score);
		$('#possibleScore_kiwi').val(scoreable);


         if(!isNaN(quality_score_percent)){
			$('#overallScore_kiwi').val(quality_score_percent+'%');
		}
 }

 $(document).on('change','.kiwi',function(){
		do_kiwi();
	});

</script>

<script>
////////////////////// Booking Validation Lost ////////////////////
function do_booking_validation_lost(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;

		$('.lost_validation').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('lost_validation_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('lost_validation_val'));
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#earnedScore_lost_validation').val(score);
		$('#possibleScore_lost_validation').val(scoreable);


         if(!isNaN(quality_score_percent)){
			$('#overallScore_lost_validation').val(quality_score_percent+'%');
		}
 }

 $(document).on('change','.lost_validation',function(){
		do_booking_validation_lost();
	});
do_booking_validation_lost();
</script>
<script>
////////////////////// Booking Status Check ////////////////////
function do_booking_status_check(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;

		$('.booking').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('booking_val'));
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#earnedScore_booking').val(score);
		$('#possibleScore_booking').val(scoreable);


         if(!isNaN(quality_score_percent)){
			$('#overallScore_booking').val(quality_score_percent+'%');
		}
 }

 $(document).on('change','.booking',function(){
		do_booking_status_check();
	});
do_booking_status_check();
</script>

<script>
////////////////////// Booking Lost Validation ////////////////////
function do_booking_lost_validation(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;

		$('.lost_validation').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('lost_validation_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('lost_validation_val'));
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#earnedScore_lost_validation').val(score);
		$('#possibleScore_lost_validation').val(scoreable);


         if(!isNaN(quality_score_percent)){
			$('#overallScore_lost_validation').val(quality_score_percent+'%');
		}
 }

 $(document).on('change','.lost_validation',function(){
		do_booking_lost_validation();
	});
do_booking_lost_validation();
</script>

<script>
////////////////////// PNB Email ////////////////////
function do_pnbemail(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;

		$('.pnb_email').each(function(index,element){
			var score_type = $(element).val();
            if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('pnb_email_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == '0'){
				parameter_count = parameter_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('pnb_email_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == '1' || score_type == '2' || score_type == '3' || score_type == '4'){
				var weightage = parseFloat($(element).children("option:selected").attr('pnb_email_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('pnb_email_val2'));
				parameter_count = parameter_count + 1;
				score = score + weightage;
				scoreable = scoreable + weightage2;
			}else if(score_type == '5'){
				parameter_count = parameter_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('pnb_email_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = (((score/parameter_count)/5)*100).toFixed(2);

		$('#earnedScore_pnb_email').val(score);
		$('#possibleScore_pnb_email').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#overallScore_pnb_email').val(quality_score_percent+'%');
		}

         if($('#fatal1').val()=='0' || $('#fatal2').val()=='0' || $('#emailScriptAF3').val()=='0' || $('#emailScriptAF4').val()=='0' || $('#emailScriptAF5').val()=='0' || $('#emailScriptAF6').val()=='0'){
		  $('.pnb_emailFatal').val(0+'%');
		  }else{
			$('.pnb_emailFatal').val(quality_score_percent+'%');
		  }
 }

 $(document).on('change','.pnb_email',function(){
		do_pnbemail();
	});

</script>

<script>
////////////////////// PuppySpot ////////////////////
function do_puppyspot(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;

		$('.puppyspot').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('puppyspot_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('puppyspot_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('puppyspot_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#earnedScore_puppyspot').val(score);
		$('#possibleScore_puppyspot').val(scoreable);


         if(!isNaN(quality_score_percent)){
			$('#overallScore_puppyspot').val(quality_score_percent+'%');
		}
          /*
         if(($('#fatal1').val()=='Yes') || ($('#fatal2').val()=='Yes')){
		  $('.offlineFatal').val(0);
		  }else{
			$('.offlineFatal').val(quality_score_percent+'%');
		  }
		  */
 }

 $(document).on('change','.puppyspot',function(){
		do_puppyspot();
	});

</script>

<script>
////////////////////// Offline ////////////////////
function do_offline(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;

		$('.offline').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('offline_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('offline_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('offline_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#earnedScore_offline').val(score);
		$('#possibleScore_offline').val(scoreable);


         if(!isNaN(quality_score_percent)){
			$('#overallScore_offline').val(quality_score_percent+'%');
		}

         if(($('#fatal1').val()=='Yes') || ($('#fatal2').val()=='Yes')){
		  $('.offlineFatal').val(0);
		  }else{
			$('.offlineFatal').val(quality_score_percent+'%');
		  }
 }

 $(document).on('change','.offline',function(){
		do_offline();
	});

</script>

<script>
////////////////////// Pre Booking ////////////////////
function do_pre_booking(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		var score2 = 0;
		var scoreable2 = 0;
		var quality_score_percent2 = 0;
		var score3 = 0;
		var scoreable3 = 0;
		var quality_score_percent3 = 0;
		var score4 = 0;
		var scoreable4 = 0;
		var quality_score_percent4 = 0;
		var score5 = 0;
		var scoreable5 = 0;
		var quality_score_percent5 = 0;

		$('.pre_booking_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#pre_earnedScore').val(score);
		$('#pre_possibleScore').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#pre_overallScore').val(quality_score_percent+'%');
		}

          // For Fatal
		if($('#fatal1').val()=='No' || $('#fatal2').val()=='No' || $('#fatal3').val()=='No' || $('#fatal4').val()=='No' || $('#fatal5').val()=='No' || $('#fatal6_com').val()=='No' || $('#fatal7_com').val()=='No' || $('#fatal8_com').val()=='No' || $('#fatal9_com').val()=='No'){
		  $('#pre_overallScore').val(0);
		  }else{
			$('#pre_overallScore').val(quality_score_percent+'%');
		  }

         // for standardization
		$('.standard').each(function(index,element){
			var score_type1 = $(element).val();

            if(score_type1 =='Yes'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score1 = score1 + weightage1;
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score1 = score1 + weightage1;
				scoreable1 = scoreable1 + weightage1;
			}
		});

		quality_score_percent1 = ((score1*100)/scoreable1).toFixed(2);

		$('#standardization_score').val(score1);
		$('#standardization_rating').val(scoreable1);

		if(!isNaN(quality_score_percent1)){
			$('#standardization_cqscore').val(quality_score_percent1+'%');
		}

		// for Product & Process
		$('.product_process').each(function(index,element){
			var score_type2 = $(element).val();

            if(score_type2 =='Yes'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score2 = score2 + weightage2;
				scoreable2 = scoreable2 + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable2 = scoreable2 + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score2 = score2 + weightage2;
				scoreable2 = scoreable2 + weightage2;
			}
		});

		quality_score_percent2 = ((score2*100)/scoreable2).toFixed(2);

		$('#product_earnedScore').val(score2);
		$('#product_possibleScore').val(scoreable2);

		if(!isNaN(quality_score_percent2)){
			$('#product_overallScore').val(quality_score_percent2+'%');
		}

		// for communication_soft_skills
		$('.communication_soft_skills').each(function(index,element){
			var score_type3 = $(element).val();

            if(score_type3 =='Yes'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score3 = score3 + weightage3;
				scoreable3 = scoreable3 + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable3 = scoreable3 + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score3 = score3 + weightage3;
				scoreable3 = scoreable3 + weightage3;
			}
		});

		quality_score_percent3 = ((score3*100)/scoreable3).toFixed(2);

		$('#communication_earnedScore').val(score3);
		$('#communication_possibleScore').val(scoreable3);

		if(!isNaN(quality_score_percent3)){
			$('#communication_overallScore').val(quality_score_percent3+'%');
		}
		// for Critical Error & ZTP
		$('.error_ztp').each(function(index,element){
			var score_type4 = $(element).val();

            if(score_type4 =='Yes'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type4 == 'No'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type4 == 'N/A'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}
		});

		quality_score_percent4 = ((score4*100)/scoreable4).toFixed(2);

		$('#critical_earnedScore').val(score4);
		$('#critical_possibleScore').val(scoreable4);

		if(!isNaN(quality_score_percent4)){
			$('#critical_overallScore').val(quality_score_percent4+'%');
		}

		// for Fatal Count
		$('.fat').each(function(index,element){
			var score_type5 = $(element).val();

            if(score_type5 =='Yes'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score5 = score5 + weightage5;
				scoreable5 = scoreable5 + weightage5;
			}else if(score_type5 == 'No'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable5 = scoreable5 + weightage5;
			}else if(score_type5 == 'N/A'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score5 = score5 + weightage5;
				scoreable5 = scoreable5 + weightage5;
			}
		});

		quality_score_percent5 = ((score5*100)/scoreable5).toFixed(2);

		$('#fatal_earnedScore').val(0);
		$('#fatal_overallScore').val(score5);
		$('#fatal_possibleScore').val(0);
		$('#without_fatal_possibleScore').val(100);
		$('#without_fatal_earnedScore').val(100);
		$('#without_fatal_overallScore').val(100);

		if(!isNaN(quality_score_percent5)){
			//$('#fatal_overallScore').val(quality_score_percent5+'%');
		}


 }

     $(document).on('change','.pre_booking_point',function(){
		do_pre_booking();
	});

</script>
<script>
////////////////////// post_delivery Booking ////////////////////
function do_post_delivery_booking(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		var score2 = 0;
		var scoreable2 = 0;
		var quality_score_percent2 = 0;
		var score3 = 0;
		var scoreable3 = 0;
		var quality_score_percent3 = 0;
		var score4 = 0;
		var scoreable4 = 0;
		var quality_score_percent4 = 0;
		var score5 = 0;
		var scoreable5 = 0;
		var quality_score_percent5 = 0;

		$('.post_delivery_booking_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#post_delivery_earnedScore').val(score);
		$('#post_delivery_possibleScore').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#post_delivery_overallScore').val(quality_score_percent+'%');
		}

          // For Fatal
		if($('#fatal1').val()=='No' || $('#fatal2').val()=='No' || $('#fatal3').val()=='No' || $('#fatal4').val()=='No' || $('#fatal5').val()=='No' || $('#fatal6_com').val()=='No' || $('#fatal7_com').val()=='No' || $('#fatal8_com').val()=='No' || $('#fatal9_com').val()=='No'){
		  $('#post_delivery_overallScore').val(0);
		  }else{
			$('#post_delivery_overallScore').val(quality_score_percent+'%');
		  }

         // for standardization
		$('.standard').each(function(index,element){
			var score_type1 = $(element).val();

            if(score_type1 =='Yes'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score1 = score1 + weightage1;
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score1 = score1 + weightage1;
				scoreable1 = scoreable1 + weightage1;
			}
		});

		quality_score_percent1 = ((score1*100)/scoreable1).toFixed(2);

		$('#standardization_score').val(score1);
		$('#standardization_rating').val(scoreable1);

		if(!isNaN(quality_score_percent1)){
			$('#standardization_cqscore').val(quality_score_percent1+'%');
		}

		// for Product & Process
		$('.product_process').each(function(index,element){
			var score_type2 = $(element).val();

            if(score_type2 =='Yes'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score2 = score2 + weightage2;
				scoreable2 = scoreable2 + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				scoreable2 = scoreable2 + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score2 = score2 + weightage2;
				scoreable2 = scoreable2 + weightage2;
			}
		});

		quality_score_percent2 = ((score2*100)/scoreable2).toFixed(2);

		$('#product_earnedScore').val(score2);
		$('#product_possibleScore').val(scoreable2);

		if(!isNaN(quality_score_percent2)){
			$('#product_overallScore').val(quality_score_percent2+'%');
		}

		// for communication_soft_skills
		$('.communication_soft_skills').each(function(index,element){
			var score_type3 = $(element).val();

            if(score_type3 =='Yes'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score3 = score3 + weightage3;
				scoreable3 = scoreable3 + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				scoreable3 = scoreable3 + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score3 = score3 + weightage3;
				scoreable3 = scoreable3 + weightage3;
			}
		});

		quality_score_percent3 = ((score3*100)/scoreable3).toFixed(2);

		$('#communication_earnedScore').val(score3);
		$('#communication_possibleScore').val(scoreable3);

		if(!isNaN(quality_score_percent3)){
			$('#communication_overallScore').val(quality_score_percent3+'%');
		}
		// for Critical Error & ZTP
		$('.error_ztp').each(function(index,element){
			var score_type4 = $(element).val();

            if(score_type4 =='Yes'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type4 == 'No'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type4 == 'N/A'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}
		});

		quality_score_percent4 = ((score4*100)/scoreable4).toFixed(2);

		$('#critical_earnedScore').val(score4);
		$('#critical_possibleScore').val(scoreable4);

		if(!isNaN(quality_score_percent4)){
			$('#critical_overallScore').val(quality_score_percent4+'%');
		}

		// for Fatal Count
		$('.fat').each(function(index,element){
			var score_type5 = $(element).val();

            if(score_type5 =='Yes'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score5 = score5 + weightage5;
				scoreable5 = scoreable5 + weightage5;
			}else if(score_type5 == 'No'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				scoreable5 = scoreable5 + weightage5;
			}else if(score_type5 == 'N/A'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('post_delivery_booking_val'));
				score5 = score5 + weightage5;
				scoreable5 = scoreable5 + weightage5;
			}
		});

		quality_score_percent5 = ((score5*100)/scoreable5).toFixed(2);

		$('#fatal_earnedScore').val(0);
		$('#fatal_overallScore').val(score5);
		$('#fatal_possibleScore').val(0);
		$('#without_fatal_possibleScore').val(100);
		$('#without_fatal_earnedScore').val(100);
		$('#without_fatal_overallScore').val(100);

		if(!isNaN(quality_score_percent5)){
			//$('#fatal_overallScore').val(quality_score_percent5+'%');
		}


 }

     $(document).on('change','.post_delivery_booking_point',function(){
		do_post_delivery_booking();
	});

</script>

<script>
////////////////////// post Booking ////////////////////
function do_post_booking(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		var score2 = 0;
		var scoreable2 = 0;
		var quality_score_percent2 = 0;
		var score3 = 0;
		var scoreable3 = 0;
		var quality_score_percent3 = 0;
		var score4 = 0;
		var scoreable4 = 0;
		var quality_score_percent4 = 0;
		var score5 = 0;
		var scoreable5 = 0;
		var quality_score_percent5 = 0;

		$('.post_booking_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#post_earnedScore').val(score);
		$('#post_possibleScore').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#post_overallScore').val(quality_score_percent+'%');
		}

          // For Fatal
		if($('#fatal1').val()=='Yes' || $('#fatal2').val()=='Yes' || $('#fatal3').val()=='Yes' || $('#fatal4').val()=='Yes' || $('#fatal5').val()=='Yes' || $('#fatal6_com').val()=='Yes' || $('#fatal7_com').val()=='Yes' || $('#fatal8_com').val()=='Yes' || $('#fatal9_com').val()=='Yes'){
		  $('#post_overallScore').val(0);
		  }else{
			$('#post_overallScore').val(quality_score_percent+'%');
		  }

         // for standardization
		$('.standard').each(function(index,element){
			var score_type1 = $(element).val();

            if(score_type1 =='Yes'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score1 = score1 + weightage1;
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score1 = score1 + weightage1;
				scoreable1 = scoreable1 + weightage1;
			}
		});

		quality_score_percent1 = ((score1*100)/scoreable1).toFixed(2);

		$('#standardization_score').val(score1);
		$('#standardization_rating').val(scoreable1);

		if(!isNaN(quality_score_percent1)){
			$('#standardization_cqscore').val(quality_score_percent1+'%');
		}

		// for Product & Process
		$('.product_process').each(function(index,element){
			var score_type2 = $(element).val();

            if(score_type2 =='Yes'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score2 = score2 + weightage2;
				scoreable2 = scoreable2 + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				scoreable2 = scoreable2 + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score2 = score2 + weightage2;
				scoreable2 = scoreable2 + weightage2;
			}
		});

		quality_score_percent2 = ((score2*100)/scoreable2).toFixed(2);

		$('#product_earnedScore').val(score2);
		$('#product_possibleScore').val(scoreable2);

		if(!isNaN(quality_score_percent2)){
			$('#product_overallScore').val(quality_score_percent2+'%');
		}

		// for communication_soft_skills
		$('.communication_soft_skills').each(function(index,element){
			var score_type3 = $(element).val();

            if(score_type3 =='Yes'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score3 = score3 + weightage3;
				scoreable3 = scoreable3 + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				scoreable3 = scoreable3 + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score3 = score3 + weightage3;
				scoreable3 = scoreable3 + weightage3;
			}
		});

		quality_score_percent3 = ((score3*100)/scoreable3).toFixed(2);

		$('#communication_earnedScore').val(score3);
		$('#communication_possibleScore').val(scoreable3);

		if(!isNaN(quality_score_percent3)){
			$('#communication_overallScore').val(quality_score_percent3+'%');
		}
		// for Critical Error & ZTP
		$('.error_ztp').each(function(index,element){
			var score_type4 = $(element).val();

            if(score_type4 =='Yes'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type4 == 'No'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type4 == 'N/A'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}
		});

		quality_score_percent4 = ((score4*100)/scoreable4).toFixed(2);

		$('#critical_earnedScore').val(score4);
		$('#critical_possibleScore').val(scoreable4);

		if(!isNaN(quality_score_percent4)){
			$('#critical_overallScore').val(quality_score_percent4+'%');
		}

		// for Fatal Count
		$('.fat').each(function(index,element){
			var score_type5 = $(element).val();

            if(score_type5 =='Yes'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score5 = score5 + weightage5;
				scoreable5 = scoreable5 + weightage5;
			}else if(score_type5 == 'No'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				scoreable5 = scoreable5 + weightage5;
			}else if(score_type5 == 'N/A'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('post_booking_val'));
				score5 = score5 + weightage5;
				scoreable5 = scoreable5 + weightage5;
			}
		});

		quality_score_percent5 = ((score5*100)/scoreable5).toFixed(2);

		$('#fatal_earnedScore').val(0);
		$('#fatal_overallScore').val(score5);
		$('#fatal_possibleScore').val(0);
		$('#without_fatal_possibleScore').val(100);
		$('#without_fatal_earnedScore').val(100);
		$('#without_fatal_overallScore').val(100);

		if(!isNaN(quality_score_percent5)){
			//$('#fatal_overallScore').val(quality_score_percent5+'%');
		}


 }

     $(document).on('change','.post_booking_point',function(){
		do_post_booking();
	});

</script>

<script>
////////////////////// IB Bank ////////////////////
function do_ibbank(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;

		$('.ib_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('ib_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ib_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('ib_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == '0'){
				var weightage = parseFloat($(element).children("option:selected").attr('ib_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == '1'){
				var weightage = parseFloat($(element).children("option:selected").attr('ib_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('ib_val2'));
				score = score + weightage;
				scoreable = scoreable + weightage2;
			}else if(score_type == '2'){
				var weightage = parseFloat($(element).children("option:selected").attr('ib_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('ib_val2'));
				score = score + weightage;
				scoreable = scoreable + weightage2;
			}else if(score_type == '3'){
				var weightage = parseFloat($(element).children("option:selected").attr('ib_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == '4'){
				var weightage = parseFloat($(element).children("option:selected").attr('ib_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('ib_val2'));
				score = score + weightage;
				scoreable = scoreable + weightage2;
			}else if(score_type == '6'){
				var weightage = parseFloat($(element).children("option:selected").attr('ib_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#earnedScore1').val(score);
		$('#possibleScore1').val(scoreable);


         if(!isNaN(quality_score_percent)){
			$('#overallScore1').val(quality_score_percent+'%');
		}

         if($('#brightwayIBAF1').val()=='Yes'){
		  $('.ibbankFatal').val(0);
		  }else{
			$('.ibbankFatal').val(quality_score_percent+'%');
		  }
 }

 $(document).on('change','.ib_point',function(){
		do_ibbank();
	});
// pick selected bonus point
 $(document).ready(function(){
    $("select#bonus_point").change(function(){
        var selectedCountry = $(this).children("option:selected").val();
        if((selectedCountry =='AB') || (selectedCountry =='AS')){
		  $('#ib_bomus').val(5);
		  }else {
		   $('#ib_bomus').val('0');
		  }
    });
});

</script>
<script>
////////////////////// PNB Inbound ////////////////////
function do_pnbinbound(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.pnb_point').each(function(index,element){
			var score_type = $(element).val();
			if((score_type =='0') || (score_type =='1') || (score_type =='2') || (score_type =='3') || (score_type =='4') || (score_type =='5')){
				parameter_count = parameter_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('pnb_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseInt($(element).children("option:selected").attr('pnb_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		//quality_score_percent = ((score*100)/scoreable).toFixed(2);
		quality_score_percent = (((score/parameter_count)/5)*100).toFixed(2);

		$('#earnedScore1').val(score);
		$('#possibleScore1').val(scoreable);


         if(!isNaN(quality_score_percent)){
				$('#overallScore1').val(quality_score_percent+'%');
			}
         if($('#pnbinboundF1').val()=='0' || $('#pnbinboundF2').val()=='0' || $('#pnbinboundF3').val()=='0' || $('#pnbinboundF4').val()=='0' || $('#pnbinboundF5').val()=='0' || $('#pnbinboundF6').val()=='0'){
		  $('.pnbinboundFatal').val(0+'%');
		  }else{
			$('.pnbinboundFatal').val(quality_score_percent+'%');
		  }
 }

	$(document).on('change','.pnb_point',function(){
		do_pnbinbound();
	});

</script>
	
<script>
////////////////////// pnbinbound new Nilkanta ////////////////////
function do_pnbinbound_new(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.pnb_point_new').each(function(index,element){
			var score_type = $(element).val();
            
			if((score_type =='Good') || (score_type =='Needs Improvement')){
				parameter_count = parameter_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('pnb_val'));
				score = score + weightage;
				//scoreable = scoreable + weightage;
				scoreable = scoreable + parseFloat($(element).children("option:selected").attr('pnb_max_val'));
			}else if(score_type == 'Poor'){
				var weightage = parseFloat($(element).children("option:selected").attr('pnb_val'));
				//scoreable = scoreable + weightage;
				scoreable = scoreable + parseFloat($(element).children("option:selected").attr('pnb_max_val'));
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}

			
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#earnedScorexx').val(score);
		$('#possibleScorexx').val(scoreable);


         if(!isNaN(quality_score_percent)){
				$('#overallScore').val(quality_score_percent+'%');
			}

		 if($('#pnb_fatal1').val()=='Fatal' || $('#pnb_fatal2').val()=='Fatal' || $('#pnb_fatal3').val()=='Fatal' || $('#pnb_fatal4').val()=='Fatal'){
		        $(".pnbinboundFatal").val(0);
		  }else{
			    $(".pnbinboundFatal").val(quality_score_percent+'%');
		  }

      }

     $(document).on('change','.pnb_point_new',function(){
		do_pnbinbound_new();
	});
     do_pnbinbound_new();
</script>
<script>
////////////////////// PNB Outbound New [Edited By Nilkanta] 30/12/2021 ///////////////////////////////
//$(document).on("change", ".pnb_ob_point", function(){
	function do_paynearoutbound(){
	var check_fatal=false;
	var earned_score=0, possible_score=0;
	$(".pnb_ob_point").each(function(){
		var score = $(this).children("option:selected").attr("pnb_ob_val");
		var scoreable = $(this).children("option:selected").attr("pnb_ob_max");
		if($(this).hasClass("pnb_ob_fatal")){
			if($(this).val()=="Fatal"){
				check_fatal=true;
			}else{
				earned_score += parseFloat(score);
				possible_score += parseFloat(scoreable);
			}
		}else{
			earned_score += parseFloat(score);
			possible_score += parseFloat(scoreable);
		}
	});
	    $('#paynear_earnedScore').val(earned_score);
		$('#paynear_possibleScore').val(possible_score);
	if(check_fatal){
		$("#pnb_ob_overallScore").val("0.00%");
	}else{
		$("#pnb_ob_overallScore").val(parseFloat((earned_score/possible_score)*100).toFixed(2)+"%");
	}

//});
}
    $(document).on('change','.pnb_ob_point',function(){
		do_paynearoutbound();
	});
    do_paynearoutbound();

////////////////////// PNB EMAIL NEW [Edited By Samrat 30/12/2021] ////////////////////////////////
$(document).on("change", ".pnb_email_point", function(){
	var earned_score=0, possible_score=0, check_fatal=false;
	$(".pnb_email_point").each(function(){
		var score = parseFloat($(this).children("option:selected").attr("pnb_email_val"));
		var scoreable = parseFloat($(this).children("option:selected").attr("pnb_email_max"));
		if($(this).hasClass("pnb_email_fatal")){
			if($(this).val()=="Fatal"){
				check_fatal=true;
			}else{
				earned_score += score;
				possible_score += scoreable;
			}
		}else{
			earned_score += score;
			possible_score += scoreable;
		}
	});
	$("#possibleScore_pnb_email").val(possible_score);
	$("#earnedScore_pnb_email").val(earned_score);
	if(check_fatal){
		$("#overallScore_pnb_email").val("0.00%");
	}else{
		$("#overallScore_pnb_email").val(parseFloat((earned_score/possible_score)*100).toFixed(2)+"%");
	}
});
////////////////////// presscreen Nilkanta ////////////////////
function do_presscreen(){
	    //alert("Nilkanta");
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.prescreen_point').each(function(index,element){
			var score_type = $(element).val();

			if(score_type == 'Effective' || score_type == 'Agent' || score_type == 'Agency' || score_type == 'Correct cold Transfer' || score_type == 'Incorrect cold Transfer'){
				parameter_count = parameter_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('prescreen_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Unacceptable'){
				var weightage = parseInt($(element).children("option:selected").attr('prescreen_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		//quality_score_percent = (((score/parameter_count)/5)*100).toFixed(2);

		$('#earnedScorepres').val(score);
		$('#possibleScorepres').val(scoreable);


         if(!isNaN(quality_score_percent)){
				$('#overallScorepres').val(quality_score_percent+'%');
			}
 }

   $(document).on('change','.prescreen_point',function(){
		do_presscreen();
   });

   ////////////////////// evaluation Nilkanta ////////////////////
function do_evaluation(){
	    //alert("Nilkanta");
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.evaluation_point').each(function(index,element){
			//alert("Nil");
			var score_type = $(element).val();

			if(score_type == 'Effective' || score_type == 'Agent' || score_type == 'Agency' || score_type == 'Correct cold Transfer' || score_type == 'Incorrect cold Transfer'){
				parameter_count = parameter_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('evaluation_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Unacceptable'){
				var weightage = parseInt($(element).children("option:selected").attr('evaluation_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		//quality_score_percent = (((score/parameter_count)/5)*100).toFixed(2);

		$('#earnedScorepres').val(score);
		$('#possibleScorepres').val(scoreable);


         if(!isNaN(quality_score_percent)){
				$('#overallScorepres').val(quality_score_percent+'%');
			}

		if($('#fatal1').val()=='Unacceptable' || $('#fatal2').val()=='Unacceptable'){
		  $('#overallScorepres').val(0+'%');
		  }else{
			$('#overallScorepres').val(quality_score_percent+'%');
		  }
 }

   $(document).on('change','.evaluation_point',function(){
		do_evaluation();
   });


////////////////////// varo rp Nilkanta ////////////////////
function do_varo_rp(){
	     //alert("Oooooo");
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;

		$('.varo_rp_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('varo_rp_val'));
				score = score + weightage;
		  });

		//totalscore = ((score*100)/scoreable).toFixed(2);
		//$('#varo_rp_overoll_score').val(score);
		$('#varo_rp_overoll_score').val(score.toFixed(2));
	}

    $(document).on('change','.varo_rp_point',function(){
		do_varo_rp();
    });
	do_varo_rp();

	//for opening
   function do_opening_point(){
		var score = 0;
		var scoreable = 0;
		var na_count=0;
          $('.opening_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('varo_rp_val'));
				score = score + weightage;
		  });

		$('#opening_score').val(score);

         if($('#o_fatal1').val()=='No' || $('#o_fatal2').val()=='No' || $('#o_fatal3').val()=='No' || $('#o_fatal4').val()=='No' || $('#o_fatal5').val()=='No' || $('#o_fatal6').val()=='No'|| $('#o_fatal7').val()=='No'){
		  $('#opening_score').val(0);
		  $('#varo_rp_overoll_score').val(0);
		  }else{
			//$('#opening_score').val(score);
			$('#opening_score').val(score.toFixed(2));
		  }
     }

     $(document).on('change','.opening_point',function(){
		do_opening_point();
	  });
     do_opening_point();

     //for effort
   function do_effort_point(){
		var score = 0;
		var scoreable = 0;
		$('.effort_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('varo_rp_val'));
				score = score + weightage;
		  });
		$('#effort_score').val(score);
     }
     $(document).on('change','.effort_point',function(){
		do_effort_point();
	  });
     do_effort_point();
     //for compliance
   function do_compliance_point(){
		var score = 0;
		$('.compliance_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('varo_rp_val'));
				score = score + weightage;
		});
		$('#compliance_score').val(score);

         if($('#complianceFatal1').val()=='No' || $('#complianceFatal2').val()=='No' || $('#complianceFatal3').val()=='No' || $('#complianceFatal4').val()=='No' || $('#complianceFatal5').val()=='No' || $('#complianceFatal6').val()=='No'|| $('#complianceFatal7').val()=='No'|| $('#complianceFatal8').val()=='No'|| $('#complianceFatal9').val()=='No'|| $('#complianceFatal10').val()=='No'|| $('#complianceFatal11').val()=='No'|| $('#complianceFatal12').val()=='No'|| $('#complianceFatal13').val()=='No'|| $('#complianceFatal14').val()=='No'|| $('#complianceFatal15').val()=='No'|| $('#complianceFatal16').val()=='No'){
		  $('#compliance_score').val(0);
		  $('#varo_rp_overoll_score').val(0);
		  }else{
			//$('#compliance_score').val(score);
			$('#compliance_score').val(score.toFixed(2));
		  }
     }
     $(document).on('change','.compliance_point',function(){
     	//alert("Oooooo");
		do_compliance_point();
	  });
      do_compliance_point();

     //for call_control
   function do_call_control_point(){
		var score = 0;
		var scoreable = 0;
		$('.call_control_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('varo_rp_val'));
				score = score + weightage;
		});
		$('#call_control_score').val(score);
     }
     $(document).on('change','.call_control_point',function(){
		do_call_control_point();
	  });
      do_call_control_point();


      //for closing_point
   function do_closing_point(){
		var score = 0;
		var scoreable = 0;
		$('.closing_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('varo_rp_val'));
				score = score + weightage;
		});
		$('#closing_score').val(score);
     }
     $(document).on('change','.closing_point',function(){
		do_closing_point();
	  });
      do_closing_point();

       //for negotiation_point
   function do_negotiation_point(){
		var score = 0;
		var scoreable = 0;
		$('.negotiation_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('varo_rp_val'));
				score = score + weightage;
		});
		$('#negotiation_score').val(score);
     }
     $(document).on('change','.negotiation_point',function(){
		do_negotiation_point();
	  });
      do_negotiation_point();



      //for documentation
   function do_documentation_point(){
		var score = 0;
		var scoreable = 0;
		var na_count=0;

		$('.documentation_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('varo_rp_val'));
				score = score + weightage;
		});

		$('#documentation_score').val(score);

         if($('#doc_fatal2').val()=='No' || $('#doc_fatal3').val()=='No' || $('#doc_fatal5').val()=='No' || $('#doc_fatal6').val()=='No' || $('#doc_fatal8').val()=='No'){
		  $('#documentation_score').val(0);
		  $('#varo_rp_overoll_score').val(0);
		  }else{
			//$('#documentation_score').val(score);
			$('#documentation_score').val(score.toFixed(2));
		  }

     }
     $(document).on('change','.documentation_point',function(){
		do_documentation_point();
	  });
     do_documentation_point();


    //for Varo LM
     function do_varo_lm_point(){
		var score9 = 0;
		var scoreable9 = 0;
		$('.varo_lm_point').each(function(index,element){
         if($('#lmfatal1').val()=='Fail' || $('#lmfatal2').val()=='Fail' || $('#lmfatal3').val()=='Fail' || $('#lmfatal4').val()=='Fail' || $('#lmfatal5').val()=='Fail' || $('#lmfatal6').val()=='Fail'|| $('#lmfatal7').val()=='Fail' || $('#lmfatal8').val()=='Fail' || $('#lmfatal9').val()=='Fail' || $('#lmfatal10').val()=='Fail' || $('#lmfatal11').val()=='Fail'){
		  $('#lm_overall_score').val(0+'%');
		  }else{
			$('#lm_overall_score').val(100+'%');
		  }
		});

     }

     $(document).on('change','.varo_lm_point',function(){

		do_varo_lm_point();
	  });

        do_varo_lm_point();




 ////////////////////// PNB Outbound ////////////////////
function do_pnboutbound(){
	    //alert("Nilkanta");
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.pnboutbound_point').each(function(index,element){
			var score_type = $(element).val();

			if((score_type =='0') || (score_type =='1') || (score_type =='2') || (score_type =='3') || (score_type =='4') || (score_type =='5')){
				parameter_count = parameter_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('pnboutbound_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseInt($(element).children("option:selected").attr('pnboutbound_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		//quality_score_percent = ((score*100)/scoreable).toFixed(2);
		quality_score_percent = (((score/parameter_count)/5)*100).toFixed(2);
		$('#earnedScore1').val(score);
		$('#possibleScore1').val(scoreable);


         if(!isNaN(quality_score_percent)){
				$('#overallScore1').val(quality_score_percent+'%');
			}
         if($('#pnboutboundF1').val()=='0' || $('#pnboutboundF2').val()=='0' || $('#pnboutboundF3').val()=='0' || $('#pnboutboundF4').val()=='0' || $('#pnboutboundF5').val()=='0' || $('#pnboutboundF6').val()=='0'){
		  $('.pnboutboundFatal').val(0+'%');
		  }else{
			$('.pnboutboundFatal').val(quality_score_percent+'%');
		  }
 }

 $(document).on('change','.pnboutbound_point',function(){
		do_pnboutbound();
	});

</script>


<script>
////////////////////// Craftjack New ////////////////////
function do_craftjack(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.craftjack_point').each(function(index,element){
			var score_type = $(element).val();

			if((score_type =='Yes') || (score_type =='Pass') || (score_type =='Mid Point')){
				parameter_count = parameter_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('craftjack_val'));
				score = score + weightage;
				scoreable = scoreable + parseInt($(element).children("option:selected").attr('craftjack_max'));
			}else if((score_type == 'No') || (score_type =='Fail')){
				var weightage = parseInt($(element).children("option:selected").attr('craftjack_val'));
				scoreable = scoreable + parseInt($(element).children("option:selected").attr('craftjack_max'));
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		//quality_score_percent = (((score/parameter_count)/5)*100).toFixed(2);
		$('#craft_earnedScore').val(score);
		$('#craft_possibleScore').val(scoreable);


         if(!isNaN(quality_score_percent)){
				$('#craft_overallScore').val(quality_score_percent+'%');
			}

		 if($('#pass_fail1').val()=='No' || $('#pass_fail2').val()=='No' || $('#pass_fail3').val()=='No' || $('#pass_fail4').val()=='No' || $('#pass_fail5').val()=='No' || $('#pass_fail6').val()=='No' || $('#pass_fail7').val()=='No' || $('#pass_fail8').val()=='No' || $('#pass_fail9').val()=='No' || $('#pass_fail10').val()=='No' || $('#pass_fail11').val()=='No' || $('#pass_fail12').val()=='No' || $('#pass_fail13').val()=='No' || $('#pass_fail14').val()=='No'){
		        $("#show_pass_fail").val('Fail');
			    $("#show_pass_fail").css("color", "red");
		  }else{
			    $("#show_pass_fail").val('Pass');
			    $("#show_pass_fail").css("color", "green");
		  }
		if($('#fatal_error1').val()=='Fail' || $('#fatal_error2').val()=='Fail' || $('#fatal_error3').val()=='Fail' || $('#fatal_error4').val()=='Fail' || $('#fatal_error5').val()=='Fail' || $('#fatal_error6').val()=='Fail'){
		        $("#fatal_error").val('Yes');
			    $("#fatal_error").css("color", "red");
				$("#craft_overallScore").val(0);
		  }else{
			    $("#fatal_error").val('No');
			    $("#fatal_error").css("color", "green");
				
		  }

 }

 $(document).on('change','.craftjack_point',function(){
		do_craftjack();
	});
 do_craftjack();

</script>
<script type="text/javascript">
	
function do_cebu(){
		var cebu_score = 0;
		var cebu_scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.cebu_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('cebu_val'));
				cebu_score = cebu_score + weightage;
				cebu_scoreable = cebu_scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('cebu_val'));
				cebu_scoreable = cebu_scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('cebu_val'));
				cebu_score = cebu_score + weightage;
				cebu_scoreable = cebu_scoreable + weightage;
			}
		});

		var quality_score_percent = ((cebu_score*100)/cebu_scoreable).toFixed(2);
		//quality_score_percent = (((cebu_score/parameter_count)/5)*100).toFixed(2);
		$('#cebu_earnedScore').val(cebu_score);
		$('#cebu_possibleScore').val(cebu_scoreable);


         if(!isNaN(quality_score_percent)){
				$('#cebu_overallScore').val(quality_score_percent+'%');
			}
   //       if($('#cebuF1').val()=='No' || $('#cebuF2').val()=='No' || $('#cebuF3').val()=='No' || $('#cebuF4').val()=='No' || $('#cebuF5').val()=='No' || $('#cebuF6').val()=='No'){
		 //  $('.cebuFatal').val(0+'%');
		 //  }else{
			// $('.cebuFatal').val(quality_score_percent+'%');
		 //  }
 }

 $(document).on('change','.cebu_point',function(){
		do_cebu();

	});
do_cebu();


</script>


<script>
////////////////////// HDFC(29-3-22) ////////////////////
function do_hdfc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.hdfc_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('hdfc_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('hdfc_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('hdfc_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}

		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		//alert(quality_score_percent);
		$('#hdfc_earnedScore').val(score);
		$('#hdfc_possibleScore').val(scoreable);


         if(!isNaN(quality_score_percent)){
				$('#hdfc_overallScore').val(quality_score_percent+'%');
			}

		 // if($('#auto_fail1').val()=='Yes' || $('#auto_fail2').val()=='Yes' || $('#auto_fail3').val()=='Yes' || $('#auto_fail4').val()=='Yes'){
		 //        $(".itfs_FA").val(0);
		 //  }else{
			//     $(".itfs_FA").val(quality_score_percent+'%');
		 //  }

 }

     $(document).on('change','.hdfc_point',function(){
		do_hdfc();
	});
     do_hdfc();
</script>