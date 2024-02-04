<script>
	$(document).ready(function(){
		$("#maintype").change(function(){
			$(this).find("option:selected").each(function(){
				var optionValue = $(this).attr("value");
				if(optionValue){
					$(".mainbox").not("." + optionValue).hide();
	                 // console.log(optionValue);
	                 $("." + optionValue).show();
	                // $("div").find("." + optionValue).css("display","block");
	            } else{
	            	$(".mainbox").hide();
	            }
	        });
		}).change();
	});
	
	// CATASTROPHE YES/NO
	$('.catastropheRadio').on('click', function(){
		curVal = $(this).val();
		if(curVal == 'yes'){
			$(this).closest('div .row').find('.catastropheOption').show();
		} else {
			$(this).closest('div .row').find('.catastropheOption').hide();
            $('#which_catastrophe').val('') ;
		}
	});
	
	$(document).ready(function(){
		$('.relationshipSelectOP').change(function(){
			curSelect = $(this).val();			
			$(this).closest('div.mainbox').find('.relationshipDIVOp').show();
			$(this).closest('div.mainbox').find('.relationshipDIVOp .policyOP').hide();
			$(this).closest('div.mainbox').find('.relationshipDIVOp .policyOP input[name="r_policy_holder"]').removeAttr('required', 'required');			
			$(this).closest('div.mainbox').find('.relationshipDIVOp .phoneOP').hide();
			$(this).closest('div.mainbox').find('.relationshipDIVOp .phoneOP input[name="r_policy_phone"]').removeAttr('required', 'required');			
			$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP').hide();
			$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP input[name="r_policy_firm"]').removeAttr('required', 'required');
			$(this).closest('div.mainbox').find('.relationshipDIVOp .policyOP .numberSL').html('5.b.');	
			$(this).closest('div.mainbox').find('.relationshipDIVOp .phoneOP .numberSL').html('5.c.');
			
			if(curSelect == 'Public Adjuster/Attorney' || curSelect == 'Agent/Broker'){
				$(this).closest('div.mainbox').find('.relationshipDIVOp').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .policyOP').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .policyOP input[name="r_policy_holder"]').prop('required', true);
				
				$(this).closest('div.mainbox').find('.relationshipDIVOp .phoneOP').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .phoneOP input[name="r_policy_phone"]').prop('required', true);
				
				$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP .nameChanger').html('Firm Name');
				$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP input[name="r_policy_firm"]').attr('placeholder', 'Firm Name');
				$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP input[name="r_policy_firm"]').prop('required', true);
			}
			if(curSelect == 'Relative' || curSelect == 'Claimant'){
				$(this).closest('div.mainbox').find('.relationshipDIVOp').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .policyOP').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .policyOP input[name="r_policy_holder"]').prop('required', true);
				$(this).closest('div.mainbox').find('.relationshipDIVOp .policyOP .numberSL').html('5.a.');
				
				$(this).closest('div.mainbox').find('.relationshipDIVOp .phoneOP').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .phoneOP input[name="r_policy_phone"]').prop('required', true);
				$(this).closest('div.mainbox').find('.relationshipDIVOp .phoneOP .numberSL').html('5.b.');
				
				$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP').hide();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP input[name="r_policy_firm"]').removeAttr('required', 'required');
			}
			if(curSelect == 'Contractor'){
				$(this).closest('div.mainbox').find('.relationshipDIVOp').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .policyOP').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .policyOP input[name="r_policy_holder"]').prop('required', true);
				
				$(this).closest('div.mainbox').find('.relationshipDIVOp .phoneOP').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .phoneOP input[name="r_policy_phone"]').prop('required', true);
				
				$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP').show();
				$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP .nameChanger').html('Contractor Name');
				$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP input[name="r_policy_firm"]').attr('placeholder', 'Contractor Name');
				$(this).closest('div.mainbox').find('.relationshipDIVOp .firmOP input[name="r_policy_firm"]').prop('required', true);
			}
		});
	});
</script>
<!-- <script>
	$(document).ready(function(){
		$("#cps").change(function(){
			$(this).find("option:selected").each(function(){
				var optionValue = $(this).attr("value");
				if(optionValue){
					$(".box").not("." + optionValue).hide();
					$("." + optionValue).show();
				} else{
					$(".box").hide();
				}
			});
		}).change();
	});
</script> -->
<script>
    $(document).ready(function(){
		$("#cps").change(function(){
			$(this).find("option:selected").each(function(){
				var optionValue = $(this).attr("value");
				if(optionValue){
					$(".box").not("." + optionValue).hide();
					$("." + optionValue).show();
					if (optionValue == 'cpswater') {
						$(".cpswaterf").attr("required", true);
					}else{
						$(".cpswaterf").removeAttr("required");
					}
					if (optionValue == 'cpsfire') {
						$(".cpsfiref").attr("required", true);
					}else{
						$(".cpsfiref").removeAttr("required");
					}
					if (optionValue == 'cpsother') {
						$(".cpsotherf").attr("required", true);
					}else{
						$(".cpsotherf").removeAttr("required");
					}
					
				} else{
					$(".box").hide();
				}
			});			
		}).change();
	});
</script>
<script>
	
	$(document).ready(function(){
		
		$('#cps_date_of_loss').change(function(){
			var DateOfLoss = $('#cps_date_of_loss').val() ;
			Datel =DateOfLoss.split('-');
			DateOfLoss= new Date(Datel[1]+'/'+Datel[2]+'/'+Datel[0]);
			
			var tod = new Date() ;
			
			var day = tod.getDate() ;
			
			var month = tod.getMonth() + 1 ;

			if(month<9){
				month='0'+month;

			}
			
			var year = tod.getFullYear() ;
			
			tod = new Date(month+'/'+day+'/'+year);//year+'-'+month+'-'+day ;
			
			if(tod > DateOfLoss){
				
				var diffTime = Math.abs(DateOfLoss - tod);
			
				var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));


				if(diffDays > 3){

					$("input[name=cps_file_claim_reason]").removeAttr('disabled');
					
					$("input[name=cps_file_claim_reason]").attr('required','true');

				}

				else{

					$("input[name=cps_file_claim_reason]").attr('disabled','true');

					$("input[name=cps_file_claim_reason]").removeAttr('required');

				}
				
			}
			
			else{
				
				$("input[name=cps_file_claim_reason]").attr('disabled','true');

				$("input[name=cps_file_claim_reason]").removeAttr('required');
				
			}
			
		});
		
	});
	
</script>

<script>

	$(document).ready(function(){
		
		
		$('#cpsliability_select_for_injuries').change(function(){
			
			var value = $('#cpsliability_select_for_injuries').val() ;
			
			if(value == '1'){
				
				$('#cpsliability_type_of_injuries').removeAttr('disabled') ;
				
			}
			
			else{
				
				$('#cpsliability_type_of_injuries').attr('disabled', true) ;
				
			}
			
		});
		
		$('#cpsliability_parties_at_attorney').change(function(){
			
			var value = $('#cpsliability_parties_at_attorney').val() ;
			
			if(value == '1'){
				
				$('#cpsliability_attorney_info').removeAttr('disabled') ;
				
			}
			
			else{
				
				$('#cpsliability_attorney_info').attr('disabled', true) ;
				
			}
			
		});
		
		$('#ncpsliability_select_for_injuries').change(function(){
			
			var value = $('#ncpsliability_select_for_injuries').val() ;
			
			if(value == '1'){
				
				$('#ncpsliability_type_of_injuries').removeAttr('disabled') ;
				
			}
			
			else{
				
				$('#ncpsliability_type_of_injuries').attr('disabled', true) ;
				
			}
			
		});
		
		$('#ncpsliability_parties_at_attorney').change(function(){
			
			var value = $('#ncpsliability_parties_at_attorney').val() ;
			
			if(value == '1'){
				
				$('#ncpsliability_attorney_info').removeAttr('disabled') ;
				
			}
			
			else{
				
				$('#ncpsliability_attorney_info').attr('disabled', true) ;
				
			}
			
		});
		
	});


</script>


<script>
	$(document).ready(function(){
		$("#ncps").change(function(){
			$(this).find("option:selected").each(function(){
				var optionValue = $(this).attr("value");
				if(optionValue){
					$(".box").not("." + optionValue).hide();
					$("." + optionValue).show();
					if (optionValue == 'ncpswater') {
						$(".ncpswaterf").attr("required", true);
					}else{
						$(".ncpswaterf").removeAttr("required");
					}
					if (optionValue == 'ncpsfire') {
						$(".ncpsfiref").attr("required", true);
					}else{
						$(".ncpsfiref").removeAttr("required");
					}
					if (optionValue == 'ncpsother') {
						$(".ncpsotherf").attr("required", true);
					}else{
						$(".ncpsotherf").removeAttr("required");
					}
				} else{
					$(".box").hide();
				}
			});
		}).change();
	});
</script>

<script>
	
	$(document).ready(function(){
		
		$('#ncps_date_of_loss').change(function(){
			
			var DateOfLoss = $('#ncps_date_of_loss').val() ;
			Datel =DateOfLoss.split('-');
			DateOfLoss= new Date(Datel[1]+'/'+Datel[2]+'/'+Datel[0]);
			
			var tod = new Date() ;
			
			var day = tod.getDate() ;
			
			var month = tod.getMonth() + 1 ;

			if(month<9){
				month='0'+month;

			}
			
			var year = tod.getFullYear() ;
			
			tod = new Date(month+'/'+day+'/'+year);//year+'-'+month+'-'+day ;
			
			if(tod > DateOfLoss){
				
				var diffTime = Math.abs(DateOfLoss - tod);
			
				var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));


				if(diffDays > 3){

					$("input[name=ncps_file_claim_reason]").removeAttr('disabled');
					
					$("input[name=ncps_file_claim_reason]").attr('required','true');

				}

				else{

					$("input[name=ncps_file_claim_reason]").attr('disabled','true');

					$("input[name=ncps_file_claim_reason]").removeAttr('required');

				}
				
			}
			
			else{
				
				$("input[name=ncps_file_claim_reason]").attr('disabled','true');

				$("input[name=ncps_file_claim_reason]").removeAttr('required');
				
			}
			
		});
		
	});
	
</script>


<script>
	$(document).ready(function(){

		$('#amrliability_select_for_injuries').change(function(){
			
			var value = $('#amrliability_select_for_injuries').val() ;
			
			if(value == '1'){
				
				$('#amrliability_type_of_injuries').removeAttr('disabled') ;
				
			}
			
			else{
				
				$('#amrliability_type_of_injuries').attr('disabled', true) ;
				
			}
			
		});
		
		$('#amrliability_parties_at_attorney').change(function(){
			
			var value = $('#amrliability_parties_at_attorney').val() ;
			
			if(value == '1'){
				
				$('#amrliability_attorney_info').removeAttr('disabled') ;
				
			}
			
			else{
				
				$('#amrliability_attorney_info').attr('disabled', true) ;
				
			}
			
		});
		
		
	});

	$(document).ready(function(){

		$('#cmrliability_select_for_injuries').change(function(){
			var value = $('#cmrliability_select_for_injuries').val() ;
			if(value == '1'){
				$('#cmrliability_type_of_injuries').removeAttr('disabled') ;
			}
			else{
				$('#cmrliability_type_of_injuries').attr('disabled', true) ;
			}
		});
		
		$('#cmrliability_parties_at_attorney').change(function(){
			var value = $('#cmrliability_parties_at_attorney').val() ;
			if(value == '1'){
				$('#cmrsliability_attorney_info').removeAttr('disabled') ;
			}
			else{
				$('#cmrsliability_attorney_info').attr('disabled', true) ;
			}
		});
		
	});


</script>


<script>
	$(document).ready(function(){
		$("#amr").change(function(){
			$(this).find("option:selected").each(function(){
				var optionValue = $(this).attr("value");
				if(optionValue){
					$(".box").not("." + optionValue).hide();
					$("." + optionValue).show();
					if (optionValue == 'ncpswater') {
						$(".ncpswaterf").attr("required", true);
					}else{
						$(".ncpswaterf").removeAttr("required");
					}
					if (optionValue == 'ncpsfire') {
						$(".ncpsfiref").attr("required", true);
					}else{
						$(".ncpsfiref").removeAttr("required");
					}
					if (optionValue == 'ncpsother') {
						$(".ncpsotherf").attr("required", true);
					}else{
						$(".ncpsotherf").removeAttr("required");
					}
				} else{
					$(".box").hide();
				}
			});
		}).change();
	});

	$(document).ready(function(){
		$("#cmr").change(function(){
			$(this).find("option:selected").each(function(){
				var optionValue = $(this).attr("value");
				if(optionValue){
					$(".box").not("." + optionValue).hide();
					$("." + optionValue).show();
					if (optionValue == 'ncpswater') {
						$(".ncpswaterf").attr("required", true);
					}else{
						$(".ncpswaterf").removeAttr("required");
					}
					if (optionValue == 'ncpsfire') {
						$(".ncpsfiref").attr("required", true);
					}else{
						$(".ncpsfiref").removeAttr("required");
					}
					if (optionValue == 'ncpsother') {
						$(".ncpsotherf").attr("required", true);
					}else{
						$(".ncpsotherf").removeAttr("required");
					}
				} else{
					$(".box").hide();
				}
			});
		}).change();
	});
</script>

<script>
	$(document).ready(function(){
		
		$('#amr_date_of_loss').change(function(){
			
			var DateOfLoss = $('#amr_date_of_loss').val() ;
			Datel =DateOfLoss.split('-');
			DateOfLoss= new Date(Datel[1]+'/'+Datel[2]+'/'+Datel[0]);
			
			var tod = new Date() ;
			
			var day = tod.getDate() ;
			
			var month = tod.getMonth() + 1 ;

			if(month<9){
				month='0'+month;

			}
			
			var year = tod.getFullYear() ;
			
			tod = new Date(month+'/'+day+'/'+year);//year+'-'+month+'-'+day ;
			
			if(tod > DateOfLoss){
				
				var diffTime = Math.abs(DateOfLoss - tod);
			
				var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));


				if(diffDays > 3){

					$("input[name=ncps_file_claim_reason]").removeAttr('disabled');
					
					$("input[name=ncps_file_claim_reason]").attr('required','true');

				}

				else{

					$("input[name=ncps_file_claim_reason]").attr('disabled','true');

					$("input[name=ncps_file_claim_reason]").removeAttr('required');

				}
				
			}
			
			else{
				
				$("input[name=ncps_file_claim_reason]").attr('disabled','true');

				$("input[name=ncps_file_claim_reason]").removeAttr('required');
				
			}
			
		});
		
	});

	$(document).ready(function(){
		$('#cmr_date_of_loss').change(function(){
			var DateOfLoss = $('#cmr_date_of_loss').val() ;
			Datel =DateOfLoss.split('-');
			DateOfLoss= new Date(Datel[1]+'/'+Datel[2]+'/'+Datel[0]);
			var tod = new Date() ;
			var day = tod.getDate() ;
			var month = tod.getMonth() + 1 ;
			if(month<9){
				month='0'+month;
			}
			var year = tod.getFullYear() ;
			tod = new Date(month+'/'+day+'/'+year);//year+'-'+month+'-'+day ;
			if(tod > DateOfLoss){
				var diffTime = Math.abs(DateOfLoss - tod);
				var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
				if(diffDays > 3){
					$("input[name=cmr_file_claim_reason]").removeAttr('disabled');
					
					$("input[name=cmr_file_claim_reason]").attr('required','true');
				}
				else{
					$("input[name=cmr_file_claim_reason]").attr('disabled','true');

					$("input[name=cmr_file_claim_reason]").removeAttr('required');
				}
			}
			else{
				$("input[name=cmr_file_claim_reason]").attr('disabled','true');

				$("input[name=cmr_file_claim_reason]").removeAttr('required');
			}
		});
	});

</script>



<script>
	
	$(document).ready(function(){
		
		$('#nlt_date_of_loss').change(function(){
			
			var DateOfLoss = $('#nlt_date_of_loss').val() ;
			Datel =DateOfLoss.split('-');
			DateOfLoss= new Date(Datel[1]+'/'+Datel[2]+'/'+Datel[0]);
			
			var tod = new Date() ;
			
			var day = tod.getDate() ;
			
			var month = tod.getMonth() + 1 ;

			if(month<9){
				month='0'+month;

			}
			
			var year = tod.getFullYear() ;
			
			tod = new Date(month+'/'+day+'/'+year);//year+'-'+month+'-'+day ;
			
			if(tod > DateOfLoss){
				
				var diffTime = Math.abs(DateOfLoss - tod);
			
				var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));


				if(diffDays > 3){

					$("input[name=nlt_file_claim_reason]").removeAttr('disabled');
					
					$("input[name=nlt_file_claim_reason]").attr('required','true');

				}

				else{

					$("input[name=nlt_file_claim_reason]").attr('disabled','true');

					$("input[name=nlt_file_claim_reason]").removeAttr('required');

				}
				
			}
			
			else{
				
				$("input[name=nlt_file_claim_reason]").attr('disabled','true');

				$("input[name=nlt_file_claim_reason]").removeAttr('required');
				
			}
			
		});
		
	});
	
</script>

<script>
	
	$(document).ready(function(){
		
		$('#aas_date_of_loss').change(function(){
			
			var DateOfLoss = $('#aas_date_of_loss').val() ;
			Datel =DateOfLoss.split('-');
			DateOfLoss= new Date(Datel[1]+'/'+Datel[2]+'/'+Datel[0]);
			
			var tod = new Date() ;
			
			var day = tod.getDate() ;
			
			var month = tod.getMonth() + 1 ;

			if(month<9){
				month='0'+month;

			}
			
			var year = tod.getFullYear() ;
			
			tod = new Date(month+'/'+day+'/'+year);//year+'-'+month+'-'+day ;
			
			if(tod > DateOfLoss){
				
				var diffTime = Math.abs(DateOfLoss - tod);
			
				var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));


				if(diffDays > 3){

					$("input[name=aas_file_claim_reason]").removeAttr('disabled');
					
					$("input[name=aas_file_claim_reason]").attr('required','true');

				}

				else{

					$("input[name=aas_file_claim_reason]").attr('disabled','true');

					$("input[name=aas_file_claim_reason]").removeAttr('required');

				}
				
			}
			
			else{
				
				$("input[name=aas_file_claim_reason]").attr('disabled','true');

				$("input[name=aas_file_claim_reason]").removeAttr('required');
				
			}
			
		});
		
	});
	
</script>


<script>
	$(document).ready(function() {
		$("#yesreport").click(function() {
			$("#detailsreport").show();
			$("#emptyreport").focus();
		});
	});
</script>
<script>
	$(document).ready(function() {
		$("#noreport").click(function() {
			$("#emptyreport").val('');
			$("#detailsreport").hide();
		});
	});
</script>
<script>
	$(document).ready(function() {
		$("#yesreport2").click(function() {
			$("#detailsreport2").show();
			$("#emptyreport2").focus();
		});
	});
</script>
<script>
	$(document).ready(function() {
		$("#noreport2").click(function() {
			$("#emptyreport2").val('');
			$("#detailsreport2").hide();
		});
	});
</script>
<script>
	$(document).ready(function() {
		$("#yesinjuries").click(function() {
			$("#detailsinjuries").show();
			$("#emptyinjuries").focus();
		});
	});
</script>
<script>
	$(document).ready(function() {
		$("#noinjuries").click(function() {
			$("#emptyinjuries").val('');
			$("#detailsinjuries").hide();
		});
	});
</script>
<script>
	$(document).ready(function() {
		$("#yesattorny").click(function() {
			$("#detailsattorny").show();
			$("#emptyattorny").focus();
		});
	});
</script>
<script>
	$(document).ready(function() {
		$("#noattorny").click(function() {
			$("#emptyattorny").val('');
			$("#detailsattorny").hide();
		});
	});
</script>
<script>
	$(document).ready(function() {
		$("#yesinjuries2").click(function() {
			$("#detailsinjuries2").show();
			$("#emptyinjuries2").focus();
		});
	});
</script>
<script>
	$(document).ready(function() {
		$("#noinjuries2").click(function() {
			$("#emptyinjuries2").val('');
			$("#detailsinjuries2").hide();
		});
	});
</script>
<script>
$('form').on('change paste', 'input, select, textarea', function(){
	formID = $(this).closest('form').attr('id');
	draftID = $('#'+formID+' input[name="draftid"]').val();
	mainType = $('#maintype').val();
	var myForm = $('#'+formID);
	var formData = false;
	formData = new FormData(myForm[0]);
	
	formURL = "";
    if(formID == 'cpsForm'){		
		formURL = "<?php echo base_url('k2_claims_crm/process_cpsform_draft'); ?>";
	}
	if(formID == 'ncpsForm'){		
		formURL = "<?php echo base_url('k2_claims_crm/process_ncpsform_draft'); ?>";
	}
	if(formID == 'alsForm'){		
		formURL = "<?php echo base_url('k2_claims_crm/process_alsform_draft'); ?>";
	}
	if(formID == 'aasForm'){		
		formURL = "<?php echo base_url('k2_claims_crm/process_aasform_draft'); ?>";
	}
	if(formID == 'caefForm'){		
		formURL = "<?php echo base_url('k2_claims_crm/process_caefform_draft'); ?>";
	}
	if(formID == 'oiForm'){		
		formURL = "<?php echo base_url('k2_claims_crm/process_oiform_draft'); ?>";
	}
	if(formID == 'nltForm'){		
		formURL = "<?php echo base_url('k2_claims_crm/process_nltform_draft'); ?>";
	}
	if(formID == 'amrForm'){
		formURL = "<?php echo base_url('k2_claims_crm/process_amrform_draft'); ?>";
	}
	if(formID == 'cmrForm'){
		formURL = "<?php echo base_url('k2_claims_crm/process_cmrform_draft'); ?>";
	}
	
	if(formID != "" && mainType != "")
	{
		$('.autosaveLoad').show();
		$.ajax({
			type: 'POST',
			url: formURL,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				console.log("success");
				console.log(data);
				$('.autosaveLoad').hide();
				//$('#uploadResult').text(data);
			},
			error: function (data) {
				console.log("error");
				console.log(data);
				$('.autosaveLoadWarning').fadeIn().delay(5000).fadeOut();
				//$('#uploadResult').text(data);
			}
		});
	}
	
});
//injuries
$("#injuries").change(function(){
	val=$(this).val();
	if(val==1){
		$('#no_of_injuries').removeAttr('disabled');
	}else{
		$('#no_of_injuries').attr('disabled','disabled');
		$('#no_of_injuries').val('');
	}
});
//police contact
$("#police_contact").change(function(){
	val=$(this).val();
	if(val==1){
		$('#department_report_number').removeAttr('disabled');
	}else{
		$('#department_report_number').attr('disabled','disabled');
		$('#department_report_number').val('');
	}
});

$("form").submit(function () {
    // prevent duplicate form submissions
    $(this).find(":submit").attr('disabled', 'disabled');
});



$("#damage_semi_tractor").change(function(){
	val=$(this).val();
	if(val=='Yes'){
		$('#damage_semi_tractor_what_area_div').show();
		$('#damage_semi_tractor_what_area').prop('required',true);
	}else{
		$('#damage_semi_tractor_what_area_div').hide();
		$('#damage_semi_tractor_what_area').removeAttr('required');
	}
});

$("#insured_pulling_asemi_trailer").change(function(){
	val=$(this).val();
	if(val=='Yes'){
		$('#insured_pulling_asemi_trailer_div').show();
		$('#insured_semi_trailer').prop('required',true);
		$('#vin_insured_semi_trailer').prop('required',true);
		$('#damage_semi_trailor').prop('required',true);
	}else{
		$('#insured_pulling_asemi_trailer_div').hide();
		$('#insured_semi_trailer').removeAttr('required');
		$('#vin_insured_semi_trailer').removeAttr('required');
		$('#damage_semi_trailor').removeAttr('required');
	}
});

$("#damage_semi_trailor").change(function(){
	val=$(this).val();
	if(val=='Yes'){
		$('#damage_semi_trailor_what_area_div').show();
		$('#damage_semi_trailor_what_area').prop('required',true);
	}else{
		$('#damage_semi_trailor_what_area_div').hide();
		$('#damage_semi_trailor_what_area').removeAttr('required');
	}
});

//other_damage
$("#other_damage").change(function(){
	val=$(this).val();
	if(val==1){
		$('#what_was_damaged_div').show();
		$('#what_was_damaged').prop('required',true);
	}else{
		$('#what_was_damaged_div').hide();
		$('#what_was_damaged').removeAttr('required');
	}
});


$("#vehicle_involved").change(function(){
	val=$(this).val();
	if(val==1 || val==""){
		$('#contact_info_other').attr('disabled','disabled');
		$('#contact_info_other').val('');		
	}else{
		$('#contact_info_other').removeAttr('disabled');
	}
});

//witness
$("#witness").change(function(){
	val=$(this).val();
	if(val=='1'){
		$('#witness_passenger_details_div').show();
		$('#witness_passenger_details').prop('required',true);
	}else{
		$('#witness_passenger_details_div').hide();
		$('#witness_passenger_details').removeAttr('required');
	}
});

$('input[name="claimantdriver_name_phone"]').bind('keypress', function(e)
{
    if ((e.which < 64 || e.which > 122) && (e.which < 44 || e.which > 46) && (e.which < 48 || e.which > 57) && (e.which <= 31 || e.which >= 33))
    {
        e.preventDefault();
    }
});


$('input[name="year_make_model"]').bind('keypress', function(e)
{
    if ((e.which < 65 || e.which > 122) && (e.which < 48 || e.which > 57) && (e.which <= 31 || e.which >= 33))
    {
        e.preventDefault();
    }
});

//were_there_any_injuries
$("#were_there_any_injuries").change(function(){
	val=$(this).val();
	if(val=='Yes'){
		//$('#injuries_description_div').show();
		$('#injuries_description').prop('required',true);
	}else{
		//$('#injuries_description_div').hide();
		$('#injuries_description').removeAttr('required');
	}
});






</script>


<?php /* 
<script>
	$(document).on('submit','#cpsForm',function(e)
	{    
	    // event.preventDefault()
		//$('button[type="submit"]').attr('disabled','disabled');
		var datas = $(this).serializeArray();
		$.ajax({
			type	:	'POST',
			url		:	'<?php echo base_url('k2_claims_crm/process_cpsform'); ?>',
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success	:	function(result){
				if(result == 'true')
				{
					alert('You Have Successfully Applied For This Job');
				}
			}
		});
	});
</script>
<script>
	$(document).on('submit','#ncpsForm',function(e)
	{    
	    // event.preventDefault()
		//$('button[type="submit"]').attr('disabled','disabled');
		var datas = $(this).serializeArray();
		$.ajax({
			type	:	'POST',
			url		:	'<?php echo base_url('k2_claims_crm/process_ncpsform'); ?>',
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success	:	function(result){
				if(result == 'true')
				{
					alert('You Have Successfully Applied For This Job');
				}
			}
		});
	});
</script>
<script>
	$(document).on('submit','#alsForm',function(e)
	{    
	    // event.preventDefault()
		//$('button[type="submit"]').attr('disabled','disabled');
		var datas = $(this).serializeArray();
		$.ajax({
			type	:	'POST',
			url		:	'<?php echo base_url('k2_claims_crm/process_alsform'); ?>',
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success	:	function(result){
				if(result == 'true')
				{
					alert('You Have Successfully Applied For This Job');
				}
			}
		});
	});
</script>
<script>
	$(document).on('submit','#aasForm',function(e)
	{    
	    // event.preventDefault()
		//$('button[type="submit"]').attr('disabled','disabled');
		var datas = $(this).serializeArray();
		$.ajax({
			type	:	'POST',
			url		:	'<?php echo base_url('k2_claims_crm/process_aasform'); ?>',
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success	:	function(result){
				if(result == 'true')
				{
					alert('You Have Successfully Applied For This Job');
				}
			}
		});
	});
</script>
<script>
	$(document).on('submit','#caefForm',function(e)
	{    
	    // event.preventDefault()
		//$('button[type="submit"]').attr('disabled','disabled');
		var datas = $(this).serializeArray();
		$.ajax({
			type	:	'POST',
			url		:	'<?php echo base_url('k2_claims_crm/process_caefform'); ?>',
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success	:	function(result){
				if(result == 'true')
				{
					alert('You Have Successfully Applied For This Job');
				}
			}
		});
	});
</script>
<script>
	$(document).on('submit','#oiForm',function(e)
	{    
	    // event.preventDefault()
		//$('button[type="submit"]').attr('disabled','disabled');
		var datas = $(this).serializeArray();
		$.ajax({
			type	:	'POST',
			url		:	'<?php echo base_url('k2_claims_crm/process_oiform'); ?>',
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success	:	function(result){
				if(result == 'true')
				{
					alert('You Have Successfully Applied For This Job');
				}
			}
		});
	});
</script>

*/ ?>


<!-- for test report solve 25-11-2022 -->
<script>
	function alpha(e) {
		var k;
		document.all ? k = e.keyCode : k = e.which;
		return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
	}

	function validateEmail(email){
		var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		if(reg.test(email)){
			return true;
			//$('.new_loss_tst_submit_btn').prop('disabled',false);
		}
		
		//alert('Please enter valid email.');
		//$('.new_loss_tst_submit_btn').prop('disabled',true);
		
		return false;
	}

	$('.new_loss_tst_submit_btn').click(function(){
		
		let primary_email = document.forms["nltForm"]["email1"].value;
		
		if (primary_email != "") {
			if(validateEmail(primary_email)==false)
			{
				alert('Please Enter Valid Email Address');
				document.forms["nltForm"]["email1"].focus();
				return false;
			}
						
		}

		let second_email = document.forms["nltForm"]["email2"].value;
		
		if (second_email != "") {
			if(validateEmail(second_email)==false)
			{
				alert('Please Enter Valid Email Address');
				document.forms["nltForm"]["email2"].focus();
				return false;
			}
			
		}
	
	});

</script>

<script>
	$(document).ready(function(){ 
		$("#txtNoSpaces").keydown(function(event) {
			if (event.keyCode == 32) {
				event.preventDefault();
			}
		});
	});

	function keyDown(e) { 
		var e = window.event || e;
		var key = e.keyCode;
		//space pressed
		if (key == 32) { //space
			e.preventDefault();
		}				
	}
</script>