<script type="text/javascript">

function docusign_calc(){
		let score = 0;
		let scoreable = 0;
		let comp_score =0;
		let busi_score =0;
		let cust_score =0;
		
		$('.LOB').each(function(index,element){
			let score_type = $(element).val();
			if(score_type == "TPV"){
				$(".sr1").val("N/A");
				$(".s1").val("N/A");
				if($(".tpv").val()=="N/A" || $(".tpv1").val()=="N/A" || $(".tpv1").val()=="N/A"){
				   $(".tpv").val("YES");
				   $(".tpv1").val("YES");
				   $(".tpv2").val("YES");
				}
			}else if(score_type == "Sales"){
				$(".tpv").val("N/A");
				$(".tpv1").val("N/A");
				$(".tpv2").val("N/A");
				if($(".sr1").val()=="N/A" || $(".s1").val()=="N/A"){
					$(".sr1").val("YES");					
					$(".s1").val("YES");
				}
			}else if(score_type == "Retention / Customer Service"){
				$(".tpv").val("N/A");
				$(".tpv1").val("N/A");
				$(".tpv2").val("N/A");
				if($(".sr1").val()=="N/A"){
					$(".sr1").val("YES");					
				}
				$(".s1").val("N/A");
			}
		});


		$('.busi_score').each(function(index,element){
			let score_type = $(element).val();
			if(score_type == "YES"){
			    busi_score+=1;
			}
		});

		$('.cust_score').each(function(index,element){
			let score_type = $(element).val();
			if(score_type == "YES"){
			    cust_score+=1;
			}
		});

		$('.comp_score').each(function(index,element){
			let score_type = $(element).val();
			if(score_type == "YES"){
			    comp_score += 1;
			}
		});

		$('.common').each(function(index,element){
			let score_type = $(element).val();
			let weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
			if(score_type == "YES"){
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == "NO"){
				scoreable = scoreable + weightage;
			}
		});

		

		var arr=['g1','g2','g3','g4','tpv1','tpv2','fatal_epi'];

		arr.forEach(function(entry) {
		    $("."+entry).each(function(){
				let valNum=$(this).val();
				var ek = $("."+entry).map((_,el) => el.value).get();
				if(entry!='fatal_epi'){
					if(valNum != "NO" && $.inArray("NO", ek) === -1){
						$('#'+entry).val('YES');
						$('#hidden_'+entry).val('YES');
					}else{
						$('#'+entry).val('NO');
						$('#hidden_'+entry).val('NO');
					}
				}else{
					if(valNum == "NO"){
						score=0;
						return false;
					}
				}
			});
		});


		score = parseFloat(score);
		scoreable = parseFloat(scoreable);
		
		const quality_score_percent=((score*100)/scoreable).toFixed(2);

		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		$('#busiScore').val(busi_score);
		$('#custScore').val(cust_score);
		$('#compScore').val(comp_score);
		
		if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}			
	
	}
	
docusign_calc();
</script>
 
 <script>
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#call_duration").timepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	
///////////////// Calibration - Auditor Type ///////////////////////	
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
			$('.auType_epi').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});	

	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});
	
/////////////

	var arr=['g1','g2','g3','g4','sr1','s1','tpv','tpv1','tpv2','LOB','busi_score','cust_score','comp_score','fatal_epi'];

	arr.forEach(function(entry) {
		
		   $("."+entry).on("change",function(){
				docusign_calc();
			});
		
	});

	docusign_calc();

	/////////////////////ACPT///////////////////////////////////

	$('.acptoth').hide();
	
	$('#acpt').on('change', function(){
		if($(this).val()=='Agent'){
			let agentAcpt = `<option value="">Select</option>
<option value="No probing">No probing</option>
<option value="No Urgency">No Urgency</option>
<option value="No good faith payment">No good faith payment</option>
<option value="No Negotiation">No Negotiation</option>
<option value="No PDC">No PDC</option>
<option value="No follow up">No follow up</option>
<option value="Others">Others</option>`
			$("#acpt_option").html(agentAcpt);
		}else if($(this).val()=='Customer'){
			let customerAcpt = `<option value="">Select</option>
<option value="Verbal Dispute">Verbal Dispute</option>
<option value="Refused to pay">Refused to pay</option>
<option value="Bankruptcy">Bankruptcy</option>
<option value="Attorney handling">Attorney handling</option>
<option value="CONSUMER CREDIT COUNSELING">CONSUMER CREDIT COUNSELING</option>
<option value="DOCUMENTS VALIDATE THE DEBT">DOCUMENTS VALIDATE THE DEBT</option>
<option value="Refused to pay  processing fees">Refused to pay  processing fees</option>
<option value="Refused to make the payment over the phone">Refused to make the payment over the phone</option>
<option value="RP driving">RP driving</option>
<option value="RP at POE">RP at POE</option>
<option value="CEASE ALL COMMUNICATION">CEASE ALL COMMUNICATION</option>
<option value="Does not speak english">Does not speak english</option>
<option value="DECEASED PENDING VERIFICATION">DECEASED PENDING VERIFICATION</option>
<option value="DO NOT CALL">DO NOT CALL</option>
<option value="FRAUD INVESTIGATION">FRAUD INVESTIGATION</option>
<option value="Identity theft">Identity theft</option>
<option value="ACTIVE ACCOUNT">ACTIVE ACCOUNT</option>
<option value="RETURNED CHECK">RETURNED CHECK</option>
<option value="Others">Others</option>`
			$("#acpt_option").html(customerAcpt);
		}else if($(this).val()=='Process'){
			let processAcpt = `<option value="">Select</option>
<option value="Dealership">Dealership</option>
<option value="Letter sent to different address">Letter sent to different address</option>
<option value="Waiver">Waiver</option>
<option value="Others">Others</option>`
			$("#acpt_option").html(processAcpt);
		}else if($(this).val()=='Technology'){
			let techAcpt = `<option value="">Select</option>
<option value="call disconnected">call disconnected</option>
<option value="connection barred">connection barred</option>
<option value="Others">Others</option>`
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

	///////////////// Agent and TL names ///////////////////////
	$( "#agent_id" ).on('change' , function() {	
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
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
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
 
 <script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
 </script>
