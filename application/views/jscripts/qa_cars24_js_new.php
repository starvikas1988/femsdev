<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datetimepicker();
	$("#mail_action_date").datepicker();
	$("#tat_replied_date").datepicker();
	$("#cycle_date").datepicker();
	$("#week_end_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	// $("#call_date_time").datetimepicker();
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
});
</script>

<script type="text/javascript">
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
            if(dispo == 'Dead Lead') {
                $('#sub_dispo').append($('<option></option>').val('Test Lead').html('Test Lead'));
                $('#sub_dispo').append($('<option></option>').val('Do not call').html('Do not call'));
                $('#sub_dispo').append($('<option></option>').val('Non-Buyer query').html('Non-Buyer query'));
				$('#sub_dispo').append($('<option></option>').val('Seller Query').html('Seller Query'));
				$('#sub_dispo').append($('<option></option>').val('Wrong number').html('Wrong number'));
				
            }
			if(dispo == 'Hub Related Query') {
                $('#sub_dispo').append($('<option></option>').val('Directions Location').html('Directions Location'));
                $('#sub_dispo').append($('<option></option>').val('Hub Timings').html('Hub Timings'));
                $('#sub_dispo').append($('<option></option>').val('Need Hub Contact').html('Need Hub Contact'));
				$('#sub_dispo').append($('<option></option>').val('No Reason given').html('No Reason given'));
                $('#sub_dispo').append($('<option></option>').val('Not Looking for a car').html('Not Looking for a car'));
                $('#sub_dispo').append($('<option></option>').val('Not shown any interest').html('Not shown any interest'));
				
            }
             if(dispo == 'Dropped') {
                $('#sub_dispo').append($('<option></option>').val('Language Barrier').html('Language Barrier'));
            }
             if(dispo == 'Interested In Booking') {
                $('#sub_dispo').append($('<option></option>').val('Bank Statement & Order Link Shared').html('Bank Statement & Order Link Shared'));
                $('#sub_dispo').append($('<option></option>').val('Loan Offer and Banking statement Link shared').html('Loan Offer and Banking statement Link shared'));
                $('#sub_dispo').append($('<option></option>').val('Car link shared').html('Car link shared'));
                $('#sub_dispo').append($('<option></option>').val('Order Link Shared').html('Order Link Shared'));
                $('#sub_dispo').append($('<option></option>').val('Booking done on call').html('Booking done on call'));
            }
             if(dispo == 'Not Interested in Booking') {
                $('#sub_dispo').append($('<option></option>').val('Already booked/bought from CARS24').html('Already booked/bought from CARS24'));
                $('#sub_dispo').append($('<option></option>').val('Already booked/bought from outside - Used Car').html('Already booked/bought from outside - Used Car'));
                $('#sub_dispo').append($('<option></option>').val('Already booked/bought from outside - New Car').html('Already booked/bought from outside - New Car'));
                $('#sub_dispo').append($('<option></option>').val('Postponed plan to purchase the car').html('Postponed plan to purchase the car'));
                $('#sub_dispo').append($('<option></option>').val('Reason not Specified/General Query').html('Reason not Specified/General Query'));
                $('#sub_dispo').append($('<option></option>').val('Want to buy new car only').html('Want to buy new car only'));
                $('#sub_dispo').append($('<option></option>').val('Booking amount relate issue').html('Booking amount relate issue'));
                $('#sub_dispo').append($('<option></option>').val('Do not want to pay for test drive').html('Do not want to pay for test drive'));
            }
            if(dispo == 'Pre-Booking Query') {
                $('#sub_dispo').append($('<option></option>').val('Payment/Charges/ Refund related Query').html('Payment/Charges/ Refund related Query'));
                $('#sub_dispo').append($('<option></option>').val('Consumer Financing Related Query').html('Consumer Financing Related Query'));
                $('#sub_dispo').append($('<option></option>').val('Visit/Delivery Process Related Query').html('Visit/Delivery Process Related Query'));
                $('#sub_dispo').append($('<option></option>').val('Car Specific Query').html('Car Specific Query'));
                $('#sub_dispo').append($('<option></option>').val('Price Related Query').html('Price Related Query'));
                $('#sub_dispo').append($('<option></option>').val('Documents Related Query').html('Documents Related Query'));
                $('#sub_dispo').append($('<option></option>').val('RC Transfer Process Related Query').html('RC Transfer Process Related Query'));
                $('#sub_dispo').append($('<option></option>').val('Insurance/ Warranty Related Query').html('Insurance/ Warranty Related Query'));
                $('#sub_dispo').append($('<option></option>').val('7 Day Return/ Money Back Related Query').html('7 Day Return/ Money Back Related Query'));
            }
            if(dispo == 'Interested_others') {
                $('#sub_dispo').append($('<option></option>').val('Could not find preferred make/ model').html('Could not find preferred make/ model'));
                $('#sub_dispo').append($('<option></option>').val('Selected car not available').html('Selected car not available'));
                $('#sub_dispo').append($('<option></option>').val('Want Loan- from CARS24 but not available').html('Want Loan- from CARS24 but not available'));
                $('#sub_dispo').append($('<option></option>').val('Non operational city').html('Non operational city'));
                $('#sub_dispo').append($('<option></option>').val('Will browse and book later').html('Will browse and book later'));
                $('#sub_dispo').append($('<option></option>').val('Postponed plan to purchase the car < 1 month').html('Postponed plan to purchase the car < 1 month'));
                $('#sub_dispo').append($('<option></option>').val('Postponed plan to purchase the car > 1 month').html('Postponed plan to purchase the car > 1 month'));
                $('#sub_dispo').append($('<option></option>').val('Want Loan- Offer Terms Not Acceptable').html('Want Loan- Offer Terms Not Acceptable'));
                $('#sub_dispo').append($('<option></option>').val('Expected Negotiation on listed price').html('Expected Negotiation on listed price'));
                $('#sub_dispo').append($('<option></option>').val('Wants to reserve the car').html('Wants to reserve the car'));
				$('#sub_dispo').append($('<option></option>').val('Comparison with competition').html('Comparison with competition'));
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
                $('#sub_subdispo').append($('<option></option>').val('Customer hung up the call or call got hung up due to other reasons ( less than 1 minute)').html('Customer hung up the call or call got hung up due to other reasons ( less than 1 minute)'));
            }
             if(subdispo == 'Test Lead') {
                $('#sub_subdispo').append($('<option></option>').val('Wrong Number/Test Lead').html('Wrong Number/Test Lead'));
            }
             if(subdispo == 'Do not call') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants DND to be activated or he does not want any call from our end.').html('Customer wants DND to be activated or he does not want any call from our end.'));
            }
             if(subdispo == 'Non-Buyer query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants to sell car/ wants to sell or buy bike / Wants to get dealership').html('Customer wants to sell car/ wants to sell or buy bike / Wants to get dealership'));
            }
			if(subdispo == 'Seller Query') {
				$('#sub_subdispo').append($('<option></option>').val('N/A').html('N/A'));
            }
			if(subdispo == 'Wrong number') {
                $('#sub_subdispo').append($('<option></option>').val('N/A').html('N/A'));
            }
			if(subdispo == 'Directions Location') {
                $('#sub_subdispo').append($('<option></option>').val('N/A').html('N/A'));
            }
			if(subdispo == 'Hub Timings') {
                $('#sub_subdispo').append($('<option></option>').val('N/A').html('N/A'));
            }
			if(subdispo == 'Need Hub Contact') {
                $('#sub_subdispo').append($('<option></option>').val('N/A').html('N/A'));
            }
			if(subdispo == 'No Reason given') {
                $('#sub_subdispo').append($('<option></option>').val('N/A').html('N/A'));
            }
			if(subdispo == 'Not Looking for a car') {
                $('#sub_subdispo').append($('<option></option>').val('N/A').html('N/A'));
            }
			if(subdispo == 'Not shown any interest') {
                $('#sub_subdispo').append($('<option></option>').val('N/A').html('N/A'));
            }
            if(subdispo == 'Language Barrier') {
                $('#sub_subdispo').append($('<option></option>').val('Lingual customer not comfortable in Hindi & english/ lingual advisor not comfortable in hindi or english').html('Lingual customer not comfortable in Hindi & english/ lingual advisor not comfortable in hindi or english'));
            }
            if(subdispo == 'Bank Statement & Order Link Shared') {
                $('#sub_subdispo').append($('<option></option>').val('Customer agreed for booking & Financing- Booking & Bank Statement Upload link shared').html('Customer agreed for booking & Financing- Booking & Bank Statement Upload link shared'));
            }
            if(subdispo == 'Loan Offer and Banking statement Link shared') {
                $('#sub_subdispo').append($('<option></option>').val('Pre-approved loan offer & Bank statement upload link shared').html('Pre-approved loan offer & Bank statement upload link shared'));
            }
            if(subdispo == 'Car link shared') {
                $('#sub_subdispo').append($('<option></option>').val('Car details link shared with the customer').html('Car details link shared with the customer'));
            }
            if(subdispo == 'Order Link Shared') {
                $('#sub_subdispo').append($('<option></option>').val('Customer agreed for booking- Test drive cnonfirmation Link Shared( Pay On Delivery/Loan)').html('Customer agreed for booking- Test drive cnonfirmation Link Shared( Pay On Delivery/Loan)'));
            }
            if(subdispo == 'Booking done on call') {
                $('#sub_subdispo').append($('<option></option>').val('Customer made the test drive booking while being on call)').html('Customer made the test drive booking while being on call)'));
            }
            if(subdispo == 'Already booked/bought from CARS24') {
                $('#sub_subdispo').append($('<option></option>').val('Customer already booked/bought another car from CARS24 or has any concern post booking or delivery of the car)').html('Customer already booked/bought another car from CARS24 or has any concern post booking or delivery of the car)'));
            }
            if(subdispo == 'Already booked/bought from outside - Used Car') {
                $('#sub_subdispo').append($('<option></option>').val('Customer already booked/bought another car from outside)').html('Customer already booked/bought another car from outside)'));
            }
            if(subdispo == 'Already booked/bought from outside - New Car') {
                $('#sub_subdispo').append($('<option></option>').val('Customer already booked/bought a New car)').html('Customer already booked/bought a New car)'));
            }
            if(subdispo == 'Postponed plan to purchase the car') {
                $('#sub_subdispo').append($('<option></option>').val('Customer dropped his plan to buy a car)').html('Customer dropped his plan to buy a car)'));
            }
            if(subdispo == 'Reason not Specified/General Query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer did not specify the reason for not booking the car)').html('Customer did not specify the reason for not booking the car)'));
            }
            if(subdispo == 'Want to buy new car only') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has planned to buy a new car only)').html('Customer has planned to buy a new car only)'));
            }
            if(subdispo == 'Booking amount relate issue') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has some issue related to booking amount)').html('Customer has some issue related to booking amount)'));
            }
            if(subdispo == 'Do not want to pay for test drive') {
                $('#sub_subdispo').append($('<option></option>').val('Customer is not willing to pay any amount for test drive & want the car at his/her at doorstep or nearest store)').html('Customer is not willing to pay any amount for test drive & want the car at his/her at doorstep or nearest store)'));
            }
            if(subdispo == 'Payment/Charges/ Refund related Query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to Payment/Charges/Refund)').html('Customer has query related to Payment/Charges/Refund)'));
            }
            if(subdispo == 'Consumer Financing Related Query') {
                $('#sub_subdispo').append($('<option></option>').val('Query Related to loan (Documents/Process/ROI/ Zero Down Payment etc))').html('Query Related to loan (Documents/Process/ROI/ Zero Down Payment etc))'));
            }
            if(subdispo == 'Visit/Delivery Process Related Query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query/concern related to Visit/Delivery/Hub Details))').html('Customer has query/concern related to Visit/Delivery/Hub Details))'));
            }
            if(subdispo == 'Car Specific Query') {
                $('#sub_subdispo').append($('<option></option>').val('Car Related query (Exterior/Interior/Specification/ features /Inspection Report)))').html('Car Related query (Exterior/Interior/Specification/ features /Inspection Report)))'));
            }
            if(subdispo == 'Price Related Query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to listing price/Additional Charges (RC transfer etc))))').html('Customer has query related to listing price/Additional Charges (RC transfer etc))))'));
            }
            if(subdispo == 'Documents Related Query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to purchase/financing documents').html('Customer has query related to purchase/financing documents'));
            }
            if(subdispo == 'RC Transfer Process Related Query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to RC transfer').html('Customer has query related to RC transfer'));
            }
            if(subdispo == 'Insurance/ Warranty Related Query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to car insurance/ 12 months warranty').html('Customer has query related to car insurance/ 12 months warranty'));
            }
            if(subdispo == '7 Day Return/ Money Back Related Query') {
                $('#sub_subdispo').append($('<option></option>').val('Customer has query related to 7 day return policy').html('Customer has query related to 7 day return policy'));
            }
            if(subdispo == 'Could not find preferred make/ model') {
                $('#sub_subdispo').append($('<option></option>').val('Preferred make & Model not available on website( Car makes & model not available on the website)').html('Preferred make & Model not available on website( Car makes & model not available on the website)'));
            }
            if(subdispo == 'Selected car not available') {
                $('#sub_subdispo').append($('<option></option>').val('Shorted listed car not available/sold or reserved( As per the budget/ Variant/Model year)').html('Shorted listed car not available/sold or reserved( As per the budget/ Variant/Model year)'));
            }
            if(subdispo == 'Want Loan- from CARS24 but not available') {
                $('#sub_subdispo').append($('<option></option>').val('Customer location is not serviceable/ Customer not eligible for loan').html('Customer location is not serviceable/ Customer not eligible for loan'));
            }
            if(subdispo == 'Non operational city') {
                $('#sub_subdispo').append($('<option></option>').val('CARS24 services not available at customers location').html('CARS24 services not available at customers location'));
            }
            if(subdispo == 'Will browse and book later') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants to explore car by his/her own').html('Customer wants to explore car by his/her own'));
            }
            if(subdispo == 'Postponed plan to purchase the car < 1 month') {
                $('#sub_subdispo').append($('<option></option>').val('Postponed the plan to buy a  car within 30 days from the date of call').html('Postponed the plan to buy a  car within 30 days from the date of call'));
            }
            if(subdispo == 'Postponed plan to purchase the car > 1 month') {
                $('#sub_subdispo').append($('<option></option>').val('Postponed the plan to buy a  car after 30 days from the date of call').html('Postponed the plan to buy a  car after 30 days from the date of call'));
            }
            if(subdispo == 'Want Loan- Offer Terms Not Acceptable') {
                $('#sub_subdispo').append($('<option></option>').val('Customer not aligned with loan T&C / wants negotiation on ROI / Wants zerodownpayment only').html('Customer not aligned with loan T&C / wants negotiation on ROI / Wants zerodownpayment only'));
            }
            if(subdispo == 'Expected Negotiation on listed price') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants negotiation on listing price / looking for discount').html('Customer wants negotiation on listing price / looking for discount'));
            }
            if(subdispo == 'Wants to reserve the car') {
                $('#sub_subdispo').append($('<option></option>').val('Customer wants to reserve the car for himself').html('Customer wants to reserve the car for himself'));
            }
			if(subdispo == 'Comparison with competition') {
                $('#sub_subdispo').append($('<option></option>').val('N/A').html('N/A'));
            }

            $('#sktPleaseWait').modal('hide');
    });
</script>

<script type="text/javascript">
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
				console.log(json_obj);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				let tenure = json_obj[i].tenure
				let today = new Date()
				let live_date = new Date()
				live_date.setDate(today.getDate() - tenure)
				for (var i in json_obj) $('#live_date').append($('#live_date').val(`${("0"+live_date.getMonth()).slice(-2)}-${live_date.getDate()}-${live_date.getFullYear()}`));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));

					if (tenure>=0 && tenure<=30) {
						var tenure_bucket = "0-30";
					}else if(tenure>30 && tenure<=60){
						var tenure_bucket = "31-60";
					}else if(tenure>60 && tenure<=90){
						var tenure_bucket = "61-90";
					}else if(tenure>90){
						var tenure_bucket = "91 and Above";
					}
					$('#tenure_bucket').empty().append($('#tenure_bucket').val(tenure_bucket));

				// if($user['tenure']>='0' && $user['tenure']<='30'){
				// $tenure_bucket = "0-30";
				// }else if($user['tenure']>'30' && $user['tenure']<='60'){
				// 	$tenure_bucket = "31-60";
				// }else if($user['tenure']>'60' && $user['tenure']<='90'){
				// 	$tenure_bucket = "61-90";
				// }else if($user['tenure']>'90'){
				// 	$tenure_bucket = "91 and Above";
				// }




				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
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
////////////////////// Pre Booking ////////////////////
function do_pre_booking(){
	
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		var pro = 0;
		var cust = 0;
		var cru = 0;
		var defects = 0;
		var good = 0;
		var average = 0;
		var bad = 0;
		$('.pre_booking_point').each(function(index,element){
			var score_type = $(element).val();
			//alert(score_type);
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
				if ($(element).attr('identifier')=="process") {
					pro+=1;
				}else if ($(element).attr('identifier')=="customer"){
					cust+=1;
				}

				// if ($(element).attr('identifier1')=="Crucial") {
				// 	cru +=1;
				// }

				
				// console.log(pro+' '+ cust)
				//alert(weightage);
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable = scoreable + weightage;

				if ($(element).attr('identifier1')=="Crucial") {
					cru +=1;
				}


				if ($(element).attr('identifier2')=="defects") {
					defects +=1;
				}
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = Math.round(((score*100)/scoreable));
		
		$('#crucial_score').val(parseInt(cru)>0 ? 'Yes' : 'No');

		$('#defects_score').val(defects);

		$('#cru_score').val(cru);

		$('#pre_earnedScore').val(score);
		$('#pre_possibleScore').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#pre_overallScore').val(quality_score_percent+'%');

		if (quality_score_percent >= 81) {
			$('#overall_result').val('Good');
		}else if (quality_score_percent >= 60.99 && quality_score_percent < 81) {
			$('#overall_result').val('Average');
		}else if(quality_score_percent <= 60){
			$('#overall_result').val('Bad');
		}



		}

// Manipulating Reason field's [required] property on Grade change
		$(document).on("change", ".pre_booking_point", function(){
			if($(this).val() == "Yes" || $(this).val() == "NA"){
				$(this).closest("td").siblings("td").find(".aoi").attr("required", false)
			}else{
				$(this).closest("td").siblings("td").find(".aoi").attr("required", true)
			}
		})
////////Analysis part change/////////////////////
		$(document).on("change", ".pre_booking_point", function(){
			if($(this).val() == "Yes"){
				$(this).closest("td").siblings("td").find(".11-1").val("Wow Call")
			}else if($(this).val() == "No"){
				$(this).closest("td").siblings("td").find(".11-1").val("Average Call")
			}else if($(this).val() == "NA") {
				$(this).closest("td").siblings("td").find(".11-1").val("Poor Call")
			}
		})

		$(document).on("change", ".tenure", function(){
			if($(this).val() == "0-30"){
				$(this).closest("td").find(".tenure_bucket").val("0-30")
			}else if($(this).val() == "31-60"){
				$(this).closest("td").find(".tenure_bucket").val("31-60")
			}else if($(this).val() == "61-90"){
				$(this).closest("td").find(".tenure_bucket").val("91 and Above")
			}
		})

////////////////////////////////////////////////////////////////////////
		$(document).on('change','.aoi',function(){
			let aoi_val='';
			let concat = '';
			$('.aoi').each(function(index,element){
				// var score_type = $(element).val();
				if ($(element).val()!=null) {
					aoi_val = aoi_val+concat+$(element).val();
				concat =',';
				// console.log(aoi_val);
				}
				$('#aoi_val').val(aoi_val);
			});

		});
		
		$(document).on('change','.remarks',function(){
			let remarks_val='';
			let concat = '';
			$('.remarks').each(function(index,element){
				// var score_type = $(element).val();
				if ($(element).val()!=null) {
					remarks_val = remarks_val+concat+$(element).val();
				concat =',';
				// console.log(remarks_val);
				}
				$('#remarks_val').val(remarks_val);
			});
			
		});
		



		// $('.pre_booking_point1').each(function(index,element){
		// 	var score_type = $(element).val();
		// 	//alert(score_type);
		// 	console.log(score_type);
  //           if(score_type == 'Good'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
		// 		var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
		// 		score1 = score1 + weightage;
		// 		scoreable1 = scoreable1 + max_wght;
		// 	}else if(score_type == 'Bad'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
		// 		var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
		// 		score1 = score1 + weightage;
		// 		scoreable1 = scoreable1 + max_wght;
		// 	}else if(score_type == 'Average'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
		// 		var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
		// 		score1 = score1 + weightage;
		// 		scoreable1 = scoreable1 + max_wght;
		// 	}else if(score_type == 'NA'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
		// 		var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
		// 		score1 = score1 + weightage;
		// 		scoreable1 = scoreable1 + weightage;
		// 	}
		// });
		// quality_score_percent1 = Math.round(((score*100)/scoreable1));
		
		

		$('#parameter_earnedScore').val(score1);
		$('#parameter_possibleScore').val(scoreable1);

         if(!isNaN(quality_score_percent1)){
			$('#parameter_overallScore').val(quality_score_percent1+'%');
		}




          // For Fatal
		if($('.all_fatal1').val()=='No' || $('.all_fatal2').val()=='No' || $('.all_fatal3').val()=='No' || $('.all_fatal4').val()=='No' || $('.all_fatal5').val()=='No' || $('.all_fatal6').val()=='No' || $('.all_fatal7').val()=='No' || $('.all_fatal8').val()=='No'){
		    $('#pre_overallScore').val(0+'%');
		  }else{
			$('#pre_overallScore').val(quality_score_percent+'%');
		  }


		  						//////////////// Customer/Process/Compliance(Riya) //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		var pro = 0;
		var cust = 0;
		var no_count = 0;
		var pro_count = 0;
		var propossible = 0;
		var custpossible = 0;
		var postpossible = 0;


		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
				if ($(element).attr('identifier')=="process") {
					pro+=1;
				}else if ($(element).attr('identifier')=="customer"){
					cust+=1;
				}

				// custpossible = 3 - cust;
				
			}else if(sc1 == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				customerScoreable = customerScoreable + w1;
				if ($(element).attr('identifier')=="process") {
					pro+=1;
				}else if ($(element).attr('identifier')=="customer"){
					cust+=1;
				}

				if ($(element).attr('identifier_no')=="no_count") {
					no_count+=1;
				}else {
					0;
				}
				

				
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
				
			}
		});
		$('#customerEarned').val(cust);		
		$('#customerPossible').val(custpossible);
		$('#customerno_count').val(no_count);

		$('#custJiCisEarned').text(customerScore);		
		$('#custJiCisPossible').text(customerScoreable);

		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#custJiCisScore').val(customerPercentage+'%');
		}

		var processScore = 0;
		var processScoreable = 0;
		var processPercentage = 0;

		$('.process').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				processScore = processScore + w2;
				processScoreable = processScoreable + w2;
				if ($(element).attr('identifier')=="process") {
					pro+=1;
				}else if ($(element).attr('identifier')=="customer"){
					cust+=1;
				}

				

				propossible = 17 - pro;
				postpossible = 20 - pro;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				processScoreable = processScoreable + w2;
				if ($(element).attr('identifier')=="process") {
					pro+=1;
				}else if ($(element).attr('identifier')=="customer"){
					cust+=1;
				}


				if ($(element).attr('identifier_pro')=="pro_count") {
					pro_count+=1;
				}else {
					0;
				}
				
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				processScore = processScore + w2;
				processScoreable = processScoreable + w2;
				
			}
		});
		$('#processJiCisEarned').text(processScore);
		$('#processJiCisPossible').text(processScoreable);
		

		$('#processEarned').val(pro);
		$('#processPossible').val(propossible);
		$('#postnewPossible').val(postpossible);
		$('#process_count').val(pro_count);
		// console.log('pro')

		processPercentage = ((processScore*100)/processScoreable).toFixed(2);
		if(!isNaN(processPercentage)){
			$('#processJiCisScore').val(processPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
				
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				complianceScoreable = complianceScoreable + w3;
				
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
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

		///////////////////////////////////////////////////////////////////////////////////////////////////
 }

 $(document).on('change','.pre_booking_point',function(){
	do_pre_booking();
});
 do_pre_booking();

	$('#standardization_ex').on('change', function(){
	if($(this).val()=='Yes'){
		$('#standardization_exsub').attr('required',true);
		$('#standardization_exsub').val('Star Call');
	
	}else{
	
		$('#standardization_exsub').attr('required',true);
		$('#standardization_exsub').val('Normal Call');
	
	}
});	

</script>


<script type="text/javascript">
	
// 	function calculation(){
		
// 		var score1 = 0;
// 		var scoreable1 = 0;
// 		var quality_score_percent1 = 0;
// 		var pass_count = 0;
// 		var fail_count = 0;
// 		var na_count = 0;
		
// 		$('.pre_booking_point1').each(function(index,element){
// 			var score_type = $(element).val();
// 			//alert(score_type);
			
//             if(score_type == 'Good'){
// 				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
// 				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
// 				score1 = score1 + weightage;
// 				scoreable1 = scoreable1 + max_wght;

// 			}else if(score_type == 'Bad'){
// 				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
// 				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
// 				score1 = score1 + weightage;
// 				scoreable1 = scoreable1 + max_wght;
				
// 			}else if(score_type == 'Average'){
// 				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
// 				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
// 				score1 = score1 + weightage;
// 				scoreable1 = scoreable1 + max_wght;
// 			}else if(score_type == 'NA'){
// 				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
// 				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
// 				score1 = score1 + weightage;
// 				scoreable1 = scoreable1 + weightage;

// 			}
// 		});
// 		quality_score_percent1 = Math.round(((score1*100)/scoreable1));



// 		$('#cars_earnedScore').val(score1);
// 		$('#cars_possibleScore').val(scoreable1);

//          if(!isNaN(quality_score_percent1)){
// 			$('#cars_overallScore').val(quality_score_percent1+'%');
// }
 //     $(document).on('change','.pre_booking_point1',function(){
	// 	calculation();
	// });

     // calculation()

   $(document).on('change','.pre_booking_point1',function(){

   		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		
		$('.pre_booking_point1').each(function(index,element){
			var score_type = $(element).val();
			//alert(score_type);
			
            if(score_type == 'Good'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
				score1 = score1 + weightage;
				scoreable1 = scoreable1 + max_wght;

			}else if(score_type == 'Bad'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
				score1 = score1 + weightage;
				scoreable1 = scoreable1 + max_wght;
				
			}else if(score_type == 'Average'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
				score1 = score1 + weightage;
				scoreable1 = scoreable1 + max_wght;
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
				score1 = score1 + weightage;
				scoreable1 = scoreable1 + weightage;

			}
		});
		quality_score_percent1 = Math.round(((score1*100)/scoreable1));



		$('#cars_earnedScore').val(score1);
		$('#cars_possibleScore').val(scoreable1);

         if(!isNaN(quality_score_percent1)){
			$('#cars_overallScore').val(quality_score_percent1+'%');
		}

		if (quality_score_percent1 >= 81) {
			$('#overall_result1').val('Good');
		}else if (quality_score_percent1 >= 60.99 && quality_score_percent1 < 81) {
			$('#overall_result1').val('Average');
		}else if(quality_score_percent1 <= 60){
			$('#overall_result1').val('Bad');
		}
   });	

</script>

<script>
$(document).ready(function(){
	
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
	
});	
</script>