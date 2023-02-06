
<script>
	$(document).ready(function(){	//ready function start
		
	/*--------- Bootstrap Date Pickers -----------*/
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
		
	/*--------- Azax call to bring Fusion ID & L1 Super on Agent ID change -----------*/
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
					// for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
					// for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
					// for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));
					$('#sktPleaseWait').modal('hide');
				},
				error: function(){	
					alert('Fail!');
				}
			});
		});

		$( "#agent_id" ).on('change' , function(){
			var aid = this.value;
			var desig = '';
			if(aid=="") alert("Please Select Agent")
			var URL='<?php echo base_url();?>Qa_mobikwik/getDesignation';
			$('#sktPleaseWait').modal('show');
			$.ajax({
				type: 'POST',    
				url:URL,
				data:'aid='+aid,
				success: function(aList){
					var json_obj = $.parseJSON(aList);
					console.log(json_obj);
					//$('#designation').empty().append($('#designation').val(''));	
					//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
					
					for (var i in json_obj){
						if(json_obj[i].roleName =='QA Auditor' || json_obj[i].roleName =='QA Specialist' || json_obj[i].roleName =='Quality Analyst'){
							desig = 'QA';

						}else{
							desig = json_obj[i].designation.toUpperCase();
						}
					$('#designation').append($('#designation').val(desig));
					}
					
					$('#sktPleaseWait').modal('hide');
				},
				error: function(){	
					alert('Fail!');
				}
			});
		});
		
	/*--------- Calibration - Auditor Type -----------*/
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
		
	
	/*----------------- Customer VOC & Sub VOC ------------------*/
		$('#cust_voc').on('change', function()
		{
			if($(this).val()=='Financial issue'){
				var custVoc1 = '<option value="">Select</option>';
				custVoc1 += '<option value="Salary not received">Salary not received</option>';
				custVoc1 += '<option value="Payment not received">Payment not received</option>';
				custVoc1 += '<option value="Asked for Waiver">Asked for Waiver</option>';
				custVoc1 += '<option value="Shops closed">Shops closed</option>';
				custVoc1 += '<option value="Do not have business">Do not have business</option>';
				custVoc1 += '<option value="Payment not arranged">Payment not arranged</option>';
				custVoc1 += '<option value="Jobless">Jobless</option>';
				custVoc1 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc1);
			}else if($(this).val()=='Health issue'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Own health issue">Own health issue</option>';
				custVoc2 += '<option value="Family members Health Issue">Family members Health Issue</option>';
				custVoc2 += '<option value="Family member Expired">Family member Expired</option>';
				custVoc2 += '<option value="Customer Hospitalized">Customer Hospitalized</option>';
				custVoc2 += '<option value="Family member Hospitalized">Family member Hospitalized</option>';
				custVoc2 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc2);
			}else if($(this).val()=='Dispute on EMI/Charges'){
				var custVoc3 = '<option value="">Select</option>';
				custVoc3 += '<option value="Already Paid through Online or E-Mitr">Already Paid through Online or E-Mitr</option>';
				custVoc3 += '<option value="ECS not deducted (Account maintained)">ECS not deducted (Account maintained)</option>';
				custVoc3 += '<option value="BCC Amount Mismatch">BCC Amount Mismatch</option>';
				custVoc3 += '<option value="Discuss with Bank Regarding Charges">Discuss with Bank Regarding Charges</option>';
				custVoc3 += '<option value="EMI Amount Mismatch">EMI Amount Mismatch</option>';
				custVoc3 += '<option value="Tenure mismatch">Tenure mismatch</option>';
				custVoc3 += '<option value="Incorrect Charges Amount">Incorrect Charges Amount</option>';
				custVoc3 += '<option value="Incorrect Due date informed By IDFC">Incorrect Due date informed By IDFC</option>';
				custVoc3 += '<option value="EMI Amount Adjusted in Charges">EMI Amount Adjusted in Charges</option>';
				custVoc3 += '<option value="Extra Amount debited">Extra Amount debited</option>';
				custVoc3 += '<option value="Do not want to pay extra charges">Do not want to pay extra charges</option>';
				custVoc3 += '<option value="Incorrect EMI inform by IDFC">Incorrect EMI inform by IDFC</option>';
				custVoc3 += '<option value="Multiple ECS hit">Multiple ECS hit</option>';
				custVoc3 += '<option value="Waiver Commited">Waiver Commited</option>';
				custVoc3 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc3);
			}else if($(this).val()=='Loan cancel/Not Received/Settle'){
				var custVoc4 = '<option value="">Select</option>';
				custVoc4 += '<option value="Product returned">Product returned</option>';
				custVoc4 += '<option value="Fraud loan activated">Fraud loan activated</option>';
				custVoc4 += '<option value="Loan Settled">Loan Settled</option>';
				custVoc4 += '<option value="NOC received">NOC received</option>';
				custVoc4 += '<option value="Already foreclosed">Already foreclosed</option>';
				custVoc4 += '<option value="Product Stolen">Product Stolen</option>';
				custVoc4 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc4);
			}else if($(this).val()=='No Information about charges'){
				var custVoc5 = '<option value="">Select</option>';
				custVoc5 += '<option value="Information not received">Information not received</option>';
				custVoc5 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc5);
			}else if($(this).val()=='Want FOS/ECS'){
				var custVoc6 = '<option value="">Select</option>';
				custVoc6 += '<option value="Want cash pickup">Want cash pickup</option>';
				custVoc6 += '<option value="Want ECS Deduction">Want ECS Deduction</option>';
				custVoc6 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc6);
			}else if($(this).val()=='Wrong number/Loan'){
				var custVoc7 = '<option value="">Select</option>';
				custVoc7 += '<option value="Wrong Person on Call">Wrong Person on Call</option>';
				custVoc7 += '<option value="Loan details mismatch">Loan details mismatch</option>';
				custVoc7 += '<option value="Product mismatch">Product mismatch</option>';
				custVoc7 += '<option value="Product not taken">Product not taken</option>';
				custVoc7 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc7);
			}else if($(this).val()=='Third Party on Call'){
				var custVoc8 = '<option value="">Select</option>';
				custVoc8 += '<option value="Right party not payer">Right party not payer</option>';
				custVoc8 += '<option value="Customer Death">Customer Death</option>';
				custVoc8 += '<option value="Right party not available">Right party not available</option>';
				custVoc8 += '<option value="Loan taken for other">Loan taken for other</option>';
				custVoc8 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc8);
			}else if($(this).val()=='Frustated regarding continous call'){
				var custVoc9 = '<option value="">Select</option>';
				custVoc9 += '<option value="Continues calls for EMI Collection">Continues calls for EMI Collection</option>';
				custVoc9 += '<option value="Refuse to pay">Refuse to pay</option>';
				custVoc9 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc9);
			}else if($(this).val()=='Refuse to pay Charges/EMI'){
				var custVoc10 = '<option value="">Select</option>';
				custVoc10 += '<option value="No reason shared">No reason shared</option>';
				custVoc10 += '<option value="Details already shared with previous agent">Details already shared with previous agent</option>';
				custVoc10 += '<option value="Dispute in Charge/EMI">Dispute in Charge/EMI</option>';
				custVoc10 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc10);
			}else if($(this).val()=='Loan not Taken'){
				var custVoc11 = '<option value="">Select</option>';
				custVoc11 += '<option value="Applied but not taken">Applied but not taken</option>';
				custVoc11 += '<option value="Documentation not Submitted/Done">Documentation not Submitted/Done</option>';
				custVoc11 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc11);
			}else if($(this).val()=='Cannot Pay Online'){
				var custVoc12 = '<option value="">Select</option>';
				custVoc12 += '<option value="In a Meeting">In a Meeting</option>';
				custVoc12 += '<option value="Busy">Busy</option>';
				custVoc12 += '<option value="Did not Trust Online mode">Did not Trust Online mode</option>';
				custVoc12 += '<option value="Driving">Driving</option>';
				custVoc12 += '<option value="In office">In office</option>';
				custVoc12 += '<option value="Internet/Network Issue">Internet/Network Issue</option>';
				custVoc12 += '<option value="In family Function">In family Function</option>';
				custVoc12 += '<option value="In Death Assembly">In Death Assembly</option>';
				custVoc12 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc12);
			}else if($(this).val()=='Not Applicable'){
				var custVoc13 = '<option value="">Select</option>';
				custVoc13 += '<option value="Call disconnected in mid">Call disconnected in mid</option>';
				custVoc13 += '<option value="Other Reasons">Other Reasons</option>';
				custVoc13 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc13);
			}else if($(this).val()=='Out of station'){
				var custVoc14 = '<option value="">Select</option>';
				custVoc14 += '<option value="Fund not available">Fund not available</option>';
				custVoc14 += '<option value="Did not aware about payment modes">Did not aware about payment modes</option>';
				custVoc14 += '<option value="Stuck in Hometown">Stuck in Hometown</option>';
				custVoc14 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc14);
			}else if($(this).val()=='Pay at the time of Loan closure'){
				var custVoc15 = '<option value="">Select</option>';
				custVoc15 += '<option value="Suggested by Branch/FOS/Dealer/Agent">Suggested by Branch/FOS/Dealer/Agent</option>';
				custVoc15 += '<option value="Cutomers Choice">Cutomers Choice</option>';
				custVoc15 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc15);
			}else if($(this).val()=='Promise to pay'){
				var custVoc16 = '<option value="">Select</option>';
				custVoc16 += '<option value="Will pay Today">Will pay Today</option>';
				custVoc16 += '<option value="Will pay Tomorrow">Will pay Tomorrow</option>';
				custVoc16 += '<option value="Will pay Day after Tomorrow">Will pay Day after Tomorrow</option>';
				custVoc16 += '<option value="Customer will pay but time and date not confirmed">Customer will pay but time and date not confirmed</option>';
				custVoc16 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc16);
			}else if($(this).val()=='Behaviour Issue'){
				var custVoc17 = '<option value="">Select</option>';
				custVoc17 += '<option value="Misbehave by Telecaller">Misbehave by Telecaller</option>';
				custVoc17 += '<option value="Misbehave by Shopkeeper">Misbehave by Shopkeeper</option>';
				custVoc17 += '<option value="Misbehave by Branch executive">Misbehave by Branch executive</option>';
				custVoc17 += '<option value="Misbehave by Field Executive">Misbehave by Field Executive</option>';
				custVoc17 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc17);
			}else if($(this).val()=='Bank realted issue'){
				var custVoc18 = '<option value="">Select</option>';
				custVoc18 += '<option value="Account freezed">Account freezed</option>';
				custVoc18 += '<option value="Wants to Update Bank account">Wants to Update Bank account</option>';
				custVoc18 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc18);
			}else if($(this).val()=='Other'){
				var custVoc19 = '<option value="">Select</option>';
				custVoc19 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc19);
			}
		});

		////////////////////////////////////////////

		/*----------------- Status and Reason ------------------*/
		$('#cust_voc').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Not following standard opening script of the project">Not following standard opening script of the project</option>';
				custVoc2 += '<option value="Late opening (after 3 seconds)">Late opening (after 3 seconds)</option>';
				custVoc2 += '<option value="Wrong/No greeting">Wrong/No greeting</option>';
				custVoc2 += '<option value="No self-introduction">No self-introductions</option>';
				$("#reason").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason").html(custVoc3);
			}
		});
		$('#cust_voc1').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason1").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Slang words">Slang words</option>';
				custVoc2 += '<option value="Technical Terms/Jargon">Technical Terms/Jargon</option>';
				custVoc2 += '<option value="Different Languages during the call">Different Languages during the call</option>';
				custVoc2 += '<option value="Negative Language">Negative Language</option>';
				custVoc2 += '<option value="Negative comment affecting organisation image">Negative comment affecting organisation image</option>';
				custVoc2 += '<option value="Not met-Not using positive, welcoming statements/word">Not met-Not using positive, welcoming statements/word</option>';
				$("#reason1").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason1").html(custVoc3);
			}
		});
		$('#cust_voc2').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason2").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Not following standard script where applicable">Not following standard script where applicable</option>';
				custVoc2 += '<option value="Sounding hesitant/non-confedint">Sounding hesitant/non-confedint</option>';
				custVoc2 += '<option value="Speaking too fast/ rushed the conversation">Speaking too fast/ rushed the conversation</option>';
				$("#reason2").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason2").html(custVoc3);
			}
		});
		$('#cust_voc3').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason3").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Sleepy/cheerless/Inactive tone of voice">Sleepy/cheerless/Inactive tone of voice</option>';
				custVoc2 += '<option value="Imperative tone of voice">Imperative tone of voice</option>';
				custVoc2 += '<option value="Aggressive/irritated/argumentative tone of voice">Aggressive/irritated/argumentative tone of voice</option>';
				custVoc2 += '<option value="Ironic/sarcastic tone of voice">Ironic/sarcastic tone of voice</option>';
				custVoc2 += '<option value="Chewing/Eating sounds">Chewing/Eating sounds</option>';
				$("#reason3").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason3").html(custVoc3);
			}
		});
		$('#cust_voc4').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason4").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Not using de-escalating techniques">Not using de-escalating techniques</option>';
				custVoc2 += '<option value="Not Empathizing with the customer">Not Empathizing with the customer</option>';
				$("#reason4").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason4").html(custVoc3);
			}
		});
		$('#cust_voc5').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason5").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Using irrelevant questions/ Not staying on topic">Using irrelevant questions/ Not staying on topic</option>';
				custVoc2 += '<option value="Not using effective questions techniques ">Not using effective questions techniques </option>';
				$("#reason5").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason5").html(custVoc3);
			}
		});
		$('#cust_voc6').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason6").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Not using verbal nods such as yes, uh huh">Not using verbal nods such as yes, uh huh</option>';
				custVoc2 += '<option value="Distracted/ not concentrating during the call">Distracted/ not concentrating during the call</option>';
				custVoc2 += '<option value="Repeating questions already answered by the customer">Repeating questions already answered by the customer</option>';
				custVoc2 += '<option value="Deadair- Silent/mute for more than (10 sec)">Deadair- Silent/mute for more than (10 sec)</option>';
				custVoc2 += '<option value="Interuppting the customer">Interuppting the customer</option>';
				custVoc2 += '<option value="Talking to others/laughing">Talking to others/laughing</option>';
				$("#reason6").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason6").html(custVoc3);
			}
		});
		$('#cust_voc7').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason7").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Not asking customer permission to be on hold/transfer">Not asking customer permission to be on hold/transfer</option>';
				custVoc2 += '<option value="Not waiting for customer approval for hold/transfer">Not waiting for customer approval for hold/transfer</option>';
				custVoc2 += '<option value="Reason for hold/transfer was not mentioned">Reason for hold/transfer was not mentioned</option>';
				custVoc2 += '<option value="Not thanking customer for hold">Not thanking customer for hold</option>';
				custVoc2 += '<option value="Exceededing hold duration">Exceededing hold duration</option>';
				$("#reason7").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason7").html(custVoc3);
			}
		});
		$('#cust_voc8').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason8").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Not using customer name 2 times minimum">Not using customer name 2 times minimum</option>';
				custVoc2 += '<option value="Not using appropriate prefix ">Not using appropriate prefix </option>';
				$("#reason8").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason8").html(custVoc3);
			}
		});
		$('#cust_voc9').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason9").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Not following standard closing script of the project">Not following standard closing script of the project</option>';
				custVoc2 += '<option value="Not asking customer if any further help is needed">Not asking customer if any further help is needed</option>';
				custVoc2 += '<option value="Not waiting for customer answer if any further help is needed">Not waiting for customer answer if any further help is needed</option>';
				$("#reason9").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason9").html(custVoc3);
			}
		});
		$('.cust_voc10').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason10").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Wrong/Incomplete information from the systems ">Wrong/Incomplete information from the systems</option>';
				custVoc2 += '<option value="Wrong/Incomplete information from knowledgebase/Process">Wrong/Incomplete information from knowledgebase/Process</option>';
				$("#reason10").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason10").html(custVoc3);
			}
		});
		$('.cust_voc11').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason11").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Disconnecting/releasing the call ">Disconnecting/releasing the call </option>';
				custVoc2 += '<option value="Denying/refusing the customer request">Denying/refusing the customer request</option>';
				$("#reason11").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason11").html(custVoc3);
			}
		});
		$('.cust_voc12').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason12").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Talking to the customer in a rude, non-professional manner">Talking to the customer in a rude, non-professional manner</option>';
				$("#reason12").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason12").html(custVoc3);
			}
		});
		$('.cust_voc13').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason13").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Wrong/Incomplete/No customer profile added">Wrong/Incomplete/No customer profile added</option>';
				custVoc2 += '<option value="Wrong/Incomplete/No customer profile update">Wrong/Incomplete/No customer profile update</option>';
				custVoc2 += '<option value="Wrong/Incomplete/No customer profile verification">Wrong/Incomplete/No customer profile verification</option>';
				$("#reason13").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason13").html(custVoc3);
			}
		});
		$('.cust_voc14').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason14").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Not creating ticket">Not creating ticket</option>';
				custVoc2 += '<option value="Wrong ticket status">Wrong ticket status</option>';
				custVoc2 += '<option value="Wrong/No update on existing ticket status">Wrong/No update on existing ticket status</option>';
				custVoc2 += '<option value="Adding ticket on a wrong customer profile">Adding ticket on a wrong customer profile</option>';
				$("#reason14").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason14").html(custVoc3);
			}
		});
		$('.cust_voc15').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason15").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Wrong service drivers on HPSM/CRM">Wrong service drivers on HPSM/CRM </option>';
				custVoc2 += '<option value="Wrong Call Type">Wrong Call Type</option>';
				custVoc2 += '<option value="Wrong ticket priority on HPSM/CRM">Wrong ticket priority on HPSM/CRM</option>';
				$("#reason15").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason15").html(custVoc3);
			}
		});
		$('.cust_voc16').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason16").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Wrong/Incomplete ticket description">Wrong/Incomplete ticket description</option>';
				custVoc2 += '<option value="Ticket description is not in the agreed language">Ticket description is not in the agreed language</option>';
				custVoc2 += '<option value="Wrong/No attachment in the ticket">Wrong/No attachment in the ticket</option>';
				custVoc2 += '<option value="Wrong/No update on existing ticket">Wrong/No update on existing ticket</option>';
				$("#reason16").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason16").html(custVoc3);
			}
		});
		$('.cust_voc17').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason17").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Opening duplicate ticket">Opening duplicate ticket</option>';
				$("#reason17").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason17").html(custVoc3);
			}
		});
		$('.cust_voc18').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason18").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Assignment to wrong backend">Assignment to wrong backend</option>';
				$("#reason18").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason18").html(custVoc3);
			}
		});
		$('.cust_voc19').on('change', function()
		{
			if($(this).val()=='Met'){
				var custVoc1 = '<option value="---">---</option>';
				$("#reason19").html(custVoc1);
			}else if($(this).val()=='Not Met'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Opening unnecessary ticket to backened">Opening unnecessary ticket to backened</option>';
				$("#reason19").html(custVoc2);
			}else if($(this).val()=='N/A'){
				var custVoc3 = '<option value="---">---</option>';
				$("#reason19").html(custVoc3);
			}
		});

	});	//ready function end
</script>

<script>
/*--------- check Number field -----------*/
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
</script>


<script>
/*--------- Audit Sheet Calculation [IDFC] -----------*/
	function idfc_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.idfc').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('idfc_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('idfc_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'Fatal'){
			    var weightage = parseFloat($(element).children("option:selected").attr('idfc_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('idfc_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		//$('#idfcEarnedScore').val(score);
		$('#idfcPossibleScore').val(scoreable);
		
		// if(!isNaN(quality_score_percent)){
		// 	$('#idfcOverallScore').val(quality_score_percent+'%');
		// }
		
	//////////
		if($('#idfcAF1').val()=='Fatal' || $('#idfcAF2').val()=='Fatal' || $('#idfcAF3').val()=='Fatal' || $('#idfcAF4').val()=='Fatal' || $('#idfcAF5').val()=='Fatal' || $('#idfcAF6').val()=='Fatal' || $('#idfcAF7').val()=='Fatal' || $('#idfcAF8').val()=='Fatal'){
			$('#idfcOverallScore').val(0);
			$('#idfcEarnedScore').val(0);
		}else{
			//$('.idfcOverallScore').val(quality_score_percent+'%');
			if(!isNaN(quality_score_percent)){
				$('#idfcEarnedScore').val(score);
				$('#idfcOverallScore').val(quality_score_percent+'%');
			}	
		}

	}

	$(document).on('change','.idfc',function(){
		idfc_calc();
	});
	idfc_calc();


	/*--------- Audit Sheet Calculation [PAYTAIL] -----------*/
function paytail_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.paytail_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Followed'){
				var weightage = parseFloat($(element).children("option:selected").attr('paytail_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}if(score_type == 'Partially Followed'){
				var weightage = parseFloat($(element).children("option:selected").attr('paytail_val'));
				var weightage1 = parseFloat($(element).children("option:selected").attr('paytail_max_val'));
				score = score + weightage;
				scoreable = scoreable + weightage1;
			}else if(score_type == 'Not Followed'){
				var weightage = parseFloat($(element).children("option:selected").attr('paytail_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('paytail_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
				
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		//$('#paytailearnedScore').val(score);
		$('#paytailpossibleScore').val(scoreable);

		if($('#paytail1').val()=='Not Followed' || $('#paytail2').val()=='Not Followed' || $('#paytail3').val()=='Not Followed' || $('#paytail4').val()=='Not Followed' || $('#paytail5').val()=='Not Followed'){
		$('#paytailoverallScore').val(0);
		$('#paytailearnedScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#paytailearnedScore').val(score);
				$('#paytailoverallScore').val(quality_score_percent+'%');
			}	
		}
	
	}
	
	$(document).on('change','.paytail_point',function(){
		paytail_calc();
	});
	paytail_calc();

	/*--------- Audit Sheet Calculation [MAALOMATIA] -----------*/
	function maalomatia_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.maalomatia').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Met'){
			    var weightage = parseFloat($(element).children("option:selected").attr('maalomatia_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'Not Met'){
			    var weightage = parseFloat($(element).children("option:selected").attr('maalomatia_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'Fatal'){
			    var weightage = parseFloat($(element).children("option:selected").attr('maalomatia_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('maalomatia_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#EarnedScore').val(score);
		$('#PossibleScore').val(scoreable);
		
		
	//////////
		if($('#maa1').val()=='Not Met' || $('#maa2').val()=='Not Met' || $('#maa3').val()=='Not Met' || $('#maa4').val()=='Not Met' || $('#maa5').val()=='Not Met' || $('#maa6').val()=='Not Met' || $('#maa7').val()=='Not Met' || $('#maa8').val()=='Not Met' || $('#maa9').val()=='Not Met' || $('#maa10').val()=='Not Met'){
			$('#OverallScore').val(0);
			
		}else{
			
			if(!isNaN(quality_score_percent)){
			
				$('#OverallScore').val(quality_score_percent+'%');
			}	
		}

	}

	$(document).on('change','.maalomatia',function(){
		maalomatia_calc();
	});
	maalomatia_calc();

/*--------- Audit Sheet Calculation [actyvAI Audit] -----------*/
function actyvAI_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.actyvAI').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Good'){
			    var weightage1 = parseFloat($(element).children("option:selected").attr('maalomatia_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('maalomatia_max'));
			    score = score + weightage1;
			    scoreable = scoreable + weightage2;
			}else if(score_type == 'Needs Improvement'){
			    var weightage1 = parseFloat($(element).children("option:selected").attr('maalomatia_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('maalomatia_max'));
			    score = score + weightage1;
				scoreable = scoreable + weightage2;
			}else if(score_type == 'Poor'){
			    var weightage1 = parseFloat($(element).children("option:selected").attr('maalomatia_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('maalomatia_max'));
			    scoreable = scoreable + weightage2;
			}else if(score_type == 'N/A'){
			    var weightage1 = parseFloat($(element).children("option:selected").attr('maalomatia_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('maalomatia_max'));
			    score = score + weightage1;
			    scoreable = scoreable + weightage2;
			
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#EarnedScore').val(score);
		$('#PossibleScore').val(scoreable);
		
		
	//////////
		if($('#actyvAI1').val()=='Fatal' || $('#actyvAI2').val()=='Fatal' || $('#actyvAI3').val()=='Fatal'){
			$('#OverallScore').val(0);
			
		}else{
			
			if(!isNaN(quality_score_percent)){
			
				$('#OverallScore').val(quality_score_percent+'%');
			}	
		}

	}

	$(document).on('change','.actyvAI',function(){
		actyvAI_calc();
	});
	actyvAI_calc(); 

</script>