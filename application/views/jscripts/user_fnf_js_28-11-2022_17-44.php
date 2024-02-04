<script>
	$("#start_date").datepicker({ dateFormat: 'yy-mm-dd' });
	$("#end_date").datepicker({ dateFormat: 'yy-mm-dd' });
	$(".datePicker").datepicker({ dateFormat: 'yy-mm-dd' });

		$(".complete_FNF").click(function(){
			
			var fnfid=$(this).attr("fnfid");
			//alert(fnfid);
			$('.frmfnfFinalHR #fnfid').val(fnfid);
			$("#fnfFinalHRModel").modal('show');
		});
	
	    // ============= HR CHECKLIST PART ================================================
			$("#fnfFinalHRSave").click(function(){
				
				var postURL = "<?php echo base_url(); ?>fnf/hr_final_status";
				
				var fnfid=$('.frmfnfFinalHR #fnfid').val();
				var final_comments=$('.frmfnfFinalHR #final_comments').val().trim();
				
				//alert(fnfid);
				//alert(final_comments);
				
				if(fnfid!="" && final_comments!=""){
					$('#sktPleaseWait').modal('show');
					$.ajax({
						type	: 	'GET',    
						url		:	postURL,
						data	:	$('form.frmfnfFinalHR').serialize(),
						success	:	function(msg){
									$('#sktPleaseWait').modal('hide');
									$('#fnfFinalHRModel').modal('hide');
									location.reload();
								}
					});
				}else{
					alert("One or More field's are blank");
				}	
			});
			
			
			$(".viewDetailsFNF").click(function(){
							
				var fnfid=$(this).attr('fnfid');				
				var postURL = "<?php echo base_url(); ?>fnf/fnf_details_view/"+fnfid;	
				if(fnfid!=""){
					$('#sktPleaseWait').modal('show');
					$.ajax({
						type	: 	'GET',    
						url		:	postURL,
						data	:	'fid='+fnfid,
						success	:	function(msg){
							console.log(msg);
									$('#sktPleaseWait').modal('hide');
									$('#fnfDetailsModal .modal-body').html(msg);
									$('#fnfDetailsModal').modal('show');
								}
					});
				} else {
					alert("Something Went Wrong!");
				}	
			});
			
//==========================================================================================================	
//  6. IT SECURITY TEAM 
//==========================================================================================================
		  
	$(".editfnfSecurityTeam").click(function(){
		var extrapar=$(this).attr("extrapar");		
		fnfd = extrapar.split('#');
		$('.frmITSecurityTeam #user_id').val(fnfd[0]);
		$('.frmITSecurityTeam #fnf_id').val(fnfd[2]);
		$('.frmITSecurityTeam #resign_id').val(fnfd[1]);
		
		// GET FNF DETAILS
		baseURL = "<?php echo base_url(); ?>";
		$.ajax({
			type	: 	'POST',    
			url		:	baseURL+'fnf/fnf_details_ajax',
			data	:	"fnf_id=" + fnfd[2],
			dataType:   "json",
			success	:	function(result){				
				$('.frmITSecurityTeam input[name="it_security_remarks"]').val(result.it_security_remarks);
				$("#fnfITSecurityTeam").modal('show');
			}
		});	
	});	
	
	$("#fnfITSecurityTeamSave").click(function(){			
		baseURL = "<?php echo base_url(); ?>";
		var uid=$('.frmITSecurityTeam #user_id').val().trim();
		var fid=$('.frmITSecurityTeam #fnf_id').val();
		var rid=$('.frmITSecurityTeam #resign_id').val().trim();
		
		returnDate1 = $('.frmITSecurityTeam input[name="it_security_remarks"]').val();
							
		if((uid!="" && fid!="")){
			$('#sktPleaseWait').modal('show');			
			var form = $('#frmITSecurityTeam')[0];
			var formData = new FormData(form);		
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'fnf/fnf_it_security_team_checkpoint',
				data	:	formData,
				contentType: false, 
				processData: false,
				success	:	function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#fnfITSecurityTeam').modal('hide');
					//console.log(msg);
					location.reload();
				}
			});
		}else{
			alert("One or More field is blank!");
		}
	});
	
	
//==========================================================================================================	
//  7. HOLD TEAM 
//==========================================================================================================
		  
	$(".editfnfHoldTeam").click(function(){
		var extrapar=$(this).attr("extrapar");		
		fnfd = extrapar.split('#');
		$('.frmITHoldTeam #user_id').val(fnfd[0]);
		$('.frmITHoldTeam #fnf_id').val(fnfd[2]);
		$('.frmITHoldTeam #resign_id').val(fnfd[1]);
		
		// GET FNF DETAILS
		baseURL = "<?php echo base_url(); ?>";
		$.ajax({
			type	: 	'POST',    
			url		:	baseURL+'fnf/fnf_details_ajax',
			data	:	"fnf_id=" + fnfd[2],
			dataType:   "json",
			success	:	function(result){
				holdVal = result.is_hold;
				showVal = 0;
				if(holdVal == 0){
					showVal = 1;
				}
				$('.frmITHoldTeam select[name="it_hold_status"]').val(showVal);
				$('.frmITHoldTeam select[name="it_hold_status"]').attr("style", "pointer-events: none;");
				$("#fnfITHoldModalTeam").modal('show');
			}
		});	
	});	
	
	$("#fnfITHoldTeamSave").click(function(){			
		baseURL = "<?php echo base_url(); ?>";
		var uid=$('.frmITHoldTeam #user_id').val().trim();
		var fid=$('.frmITHoldTeam #fnf_id').val();
		var rid=$('.frmITHoldTeam #resign_id').val().trim();
		
		returnDate1 = $('.frmITHoldTeam input[name="it_hold_status"]').val();
							
		if((uid!="" && fid!="")){
			$('#sktPleaseWait').modal('show');			
			var form = $('#frmITHoldTeam')[0];
			var formData = new FormData(form);		
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'fnf/fnf_it_hold_team_checkpoint',
				data	:	formData,
				contentType: false, 
				processData: false,
				success	:	function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#fnfITHoldModalTeam').modal('hide');
					//console.log(msg);
					location.reload();
				}
			});
		}else{
			alert("One or More field is blank!");
		}
	});
	
//=========================================================================================================
//  YES | No | N/A Selection
//=========================================================================================================

 $('.yesNoSelection').change(function(){
	currVal = $(this).val();
	$(this).closest('div.row').find('div.col-md-4').hide(); 
	$(this).closest('div.row').find('div.col-md-5').hide();
	$(this).closest('div.row').find('div.col-md-4').removeClass('required');
	$(this).closest('div.row').find('div.col-md-4').children(':input').val(''); 
	//$(this).closest('div.row').find('div.col-md-5').removeClass('required');
	if(currVal == 'Yes')
	{
		$(this).closest('div.row').find('div.col-md-4').show();		
		$(this).closest('div.row').find('div.col-md-5').show();
		$(this).closest('div.row').find('div.col-md-4').addClass('required');	
		//$(this).closest('div.row').find('div.col-md-5').addClass('required'); 
	}
 });
 
 function requiredUpdationYesNo(div = '')
 {
	$(div + ' .yesNoSelection').each(function(){
		currVal = $(this).val();
		$(this).closest('div.row').find('div.col-md-4').hide(); 
		$(this).closest('div.row').find('div.col-md-5').hide();
		$(this).closest('div.row').find('div.col-md-4').removeClass('required'); 
		//$(this).closest('div.row').find('div.col-md-5').removeClass('required');
		if(currVal == 'Yes')
		{
			$(this).closest('div.row').find('div.col-md-4').show();		
			$(this).closest('div.row').find('div.col-md-5').show();
			$(this).closest('div.row').find('div.col-md-4').addClass('required'); 
			//$(this).closest('div.row').find('div.col-md-5').addClass('required'); 
		}
	});	
 }
 
 	
//==========================================================================================================	
//  MOROCCO ==============> IT LOCAL TEAM CHECKPOINT
//==========================================================================================================
		  
	$(".editfnfITLocalTeamMorocco").click(function(){
		var extrapar=$(this).attr("extrapar");		
		fnfd = extrapar.split('#');
		$('.frmITLocalTeamMorocco #user_id').val(fnfd[0]);
		$('.frmITLocalTeamMorocco #fnf_id').val(fnfd[2]);
		$('.frmITLocalTeamMorocco #resign_id').val(fnfd[1]);
		
		// SECURITY REMARKS					
		var ftype=$(this).attr("ftype");
		$('.frmITLocalTeamMorocco #f_type').val(ftype);
		$(".frmITLocalTeamMorocco :input").removeAttr("disabled", "disabled");
		
		// GET FNF DETAILS
		baseURL = "<?php echo base_url(); ?>";
		$.ajax({
			type	: 	'POST',    
			url		:	baseURL+'fnf/fnf_details_ajax',
			data	:	"fnf_id=" + fnfd[2],
			dataType:   "json",
			success	:	function(result){
				$('.frmITLocalTeamMorocco input[name="return_computer_date"]').val(result.return_date_computer);
				$('.frmITLocalTeamMorocco input[name="return_computer_headset"]').val(result.return_date_headset);
				$('.frmITLocalTeamMorocco input[name="return_computer_tools"]').val(result.return_date_accessories);
				$('.frmITLocalTeamMorocco input[name="disable_dialer_id"]').val(result.disablement_date_dialer);
				$('.frmITLocalTeamMorocco input[name="disable_crm_id"]').val(result.disablement_date_crm);
				$('.frmITLocalTeamMorocco textarea[name="security_remarks"]').val(result.it_local_remarks);
				
				$('.frmITLocalTeamMorocco select[name="is_return_computer_date"]').val(result.is_return_date_computer);
				$('.frmITLocalTeamMorocco select[name="is_return_computer_headset"]').val(result.is_return_date_headset);
				$('.frmITLocalTeamMorocco select[name="is_return_computer_tools"]').val(result.is_return_date_accessories);
				$('.frmITLocalTeamMorocco select[name="is_disable_dialer_id"]').val(result.is_disablement_date_dialer);
				$('.frmITLocalTeamMorocco select[name="is_disable_crm_id"]').val(result.is_disablement_date_crm);
				
				requiredUpdationYesNo('.frmITLocalTeamMorocco');
				
				$('.imgView').hide();
				imgVal = result.return_date_computer_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('input[name="return_computer_date_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('input[name="return_computer_date_file"]').closest('div').children('span.imgView').show();
				}
				imgVal = result.disablement_date_crm_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('input[name="disable_crm_id_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('input[name="disable_crm_id_file"]').closest('div').children('span.imgView').show();
				}				
				imgVal = result.disablement_date_dialer_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('input[name="disable_dialer_id_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('input[name="disable_dialer_id_file"]').closest('div').children('span.imgView').show();
				}
				
				$("#fnfITLocalTeamMorocco").modal('show');
			}
		});	
	});	
	
	$("#fnfITLocalSaveMorocco").click(function(){			
		baseURL = "<?php echo base_url(); ?>";
		var uid=$('.frmITLocalTeamMorocco #user_id').val().trim();
		var fid=$('.frmITLocalTeamMorocco #fnf_id').val();
		var rid=$('.frmITLocalTeamMorocco #resign_id').val().trim();
		
		returnDate1 = $('.frmITLocalTeamMorocco input[name="return_computer_date"]').val();
		returnDate2 = $('.frmITLocalTeamMorocco input[name="return_computer_headset"]').val();
		returnDate3 = $('.frmITLocalTeamMorocco input[name="return_computer_tools"]').val();
		returnDate4 = $('.frmITLocalTeamMorocco input[name="disable_dialer_id"]').val();
		returnDate5 = $('.frmITLocalTeamMorocco input[name="disable_crm_id"]').val();
		
		checkup = true;
		$('.frmITLocalTeamMorocco .required').each(function(){
			dataCheck = $(this).find(':input').val();
			if(dataCheck == ""){ checkup = false; }
		});
		$('.frmITLocalTeamMorocco .yesNoSelection').each(function(){
			dataCheck = $(this).val();
			if(dataCheck == ""){ checkup = false; }
		});
		
		//if((returnDate1 == "") || (returnDate2 == "") || (returnDate3 == "") || (returnDate4 == "") || (returnDate5 == "")){
		if(checkup == false){
			alert("Please Enter All Details!");
		} else {					
		if((uid!="" && fid!="")){
			$('#sktPleaseWait').modal('show');			
			var form = $('#frmITLocalTeamMorocco')[0];
			var formData = new FormData(form);		
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'fnf/fnf_it_local_checkpoint',
				data	:	formData,
				contentType: false, 
				processData: false,
				success	:	function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#frmITLocalTeamMorocco').modal('hide');
					//console.log(msg);
					location.reload();
				}
			});
		}else{
			alert("One or More field is blank!");
		}
		}
	});
	
	

//==========================================================================================================	
//  MOROCCO ==============> HR & PAYROLL CHECKPOINT
//==========================================================================================================
		  
	$(".complete_FNF_Morocco").click(function(){
		var extrapar=$(this).attr("extrapar");		
		fnfd = extrapar.split('#');
		$('.frmPayrollTeamMorocco #user_id').val(fnfd[0]);
		$('.frmPayrollTeamMorocco #fnf_id').val(fnfd[2]);
		$('.frmPayrollTeamMorocco #resign_id').val(fnfd[1]);
						
		// GET FNF DETAILS
		baseURL = "<?php echo base_url(); ?>";
		$.ajax({
			type	: 	'POST',    
			url		:	baseURL+'fnf/fnf_details_ajax',
			data	:	"fnf_id=" + fnfd[2],
			dataType:   "json",
			success	:	function(result){
				$('.frmPayrollTeamMorocco input[name="cas_reason_of_leaving"]').val(result.last_month_unpaid);
				$('.frmPayrollTeamMorocco input[name="cas_resignation_notice"]').val(result.leave_encashment);				
				$('.frmPayrollTeamMorocco input[name="cas_mutual_insurance"]').val(result.notice_pay);				
				$('.frmPayrollTeamMorocco input[name="cas_salary_debit"]').val(result.pf_deduction);				
				$('.frmPayrollTeamMorocco input[name="cas_balance"]').val(result.esic_deduction);				
				$('.frmPayrollTeamMorocco input[name="cas_final_comments"]').val(result.ptax_deduction);			
				$('.imgView').hide();
				imgVal = result.biometric_access_revocation_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('.frmPayrollTeam input[name="cas_hr_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('.frmPayrollTeam input[name="cas_hr_file"]').closest('div').children('span.imgView').show();
				}
				if(result.payroll_status == 'C'){
					if(result.payroll_remarks)
					{
						$(".frmPayrollTeamMorocco :input").prop("disabled", true);
						$('.frmPayrollTeamMorocco #fnfPayrollTeamSaveMorocco').hide(); 
					} else {
						if(ftype == 1)
						{
							$(".frmPayrollTeamMorocco :input").prop("disabled", true);
							$('.frmPayrollTeamMorocco #fnfPayrollTeamSaveMorocco').hide();
						}
					}
				} 
				else { 
					$('.frmPayrollTeam #fnfPayrollTeamSaveMorocco').show(); 
				}				
				$("#fnfPayrollTeamMorocco").modal('show');
			}
		});	
	});	
	
	$("#fnfPayrollTeamSaveMorocco").click(function(){			
		baseURL = "<?php echo base_url(); ?>";
		var uid=$('.frmPayrollTeamMorocco #user_id').val().trim();
		var fid=$('.frmPayrollTeamMorocco #fnf_id').val();
		var rid=$('.frmPayrollTeamMorocco #resign_id').val().trim();
		
		$('#frmPayrollTeamMorocco')[0].checkValidity();
		
		returnDate1 = $('.frmPayrollTeamMorocco input[name="cas_reason_of_leaving"]').val();
		returnDate2 = $('.frmPayrollTeamMorocco input[name="cas_resignation_notice"]').val();
		returnDate3 = $('.frmPayrollTeamMorocco input[name="cas_mutual_insurance"]').val();
		returnDate4 = $('.frmPayrollTeamMorocco input[name="cas_salary_debit"]').val();
		returnDate5 = $('.frmPayrollTeamMorocco input[name="cas_balance"]').val();
		returnDate6 = $('.frmPayrollTeamMorocco input[name="cas_final_comments"]').val();
		
		if((returnDate1 == "") || (returnDate2 == "") || (returnDate3 == "") || (returnDate4 == "") || (returnDate5 == "") || (returnDate6 == "")){
			alert("Please Enter All Details!");
		} else {					
		if((uid!="" && fid!="")){
			$('#sktPleaseWait').modal('show');			
			var form = $('#frmPayrollTeamMorocco')[0];
			var formData = new FormData(form);		
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'fnf/fnf_hr_payroll_morocco',
				data	:	formData,
				contentType: false, 
				processData: false,
				success	:	function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#fnfPayrollTeamMorocco').modal('hide');
					//console.log(msg);
					location.reload();
				}
			});
		}else{
			alert("One or More field is blank!");
		}
		}
	});
		
	
	
//==========================================================================================================	
//  1. IT LOCAL TEAM 
//==========================================================================================================
		  
	$(".editfnfITLocalTeam").click(function(){
		var extrapar=$(this).attr("extrapar");		
		fnfd = extrapar.split('#');
		$('.frmITLocalTeam #user_id').val(fnfd[0]);
		$('.frmITLocalTeam #fnf_id').val(fnfd[2]);
		$('.frmITLocalTeam #resign_id').val(fnfd[1]);
		
		// SECURITY REMARKS					
		var ftype=$(this).attr("ftype");
		$('.frmITLocalTeam #f_type').val(ftype);
		$('.securityRemarks').hide();
		$('.frmITLocalTeam textarea[name="security_remarks"]').removeAttr('required');
		$(".frmITLocalTeam :input").removeAttr("disabled", "disabled");
		$('.frmITLocalTeam textarea[name="security_remarks"]').removeAttr("disabled", "disabled");
		if(ftype == 2){
			$(".frmITLocalTeam :input").prop("disabled", true);
			$('.frmITLocalTeam textarea[name="security_remarks"]').attr('required', 'required'); 
			$('.frmITLocalTeam textarea[name="security_remarks"]').removeAttr('disabled', 'disabled'); 
			$('.frmITLocalTeam input[name="user_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmITLocalTeam input[name="fnf_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmITLocalTeam input[name="resign_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmITLocalTeam input[name="f_type"]').removeAttr('disabled', 'disabled'); 
			$('.frmITLocalTeam button[type="submit"]').removeAttr('disabled', 'disabled'); 
			$('.frmITLocalTeam button[type="button"]').removeAttr('disabled', 'disabled'); 
			$('.securityRemarks').show(); 
		}
		
		// GET FNF DETAILS
		baseURL = "<?php echo base_url(); ?>";
		$.ajax({
			type	: 	'POST',    
			url		:	baseURL+'fnf/fnf_details_ajax',
			data	:	"fnf_id=" + fnfd[2],
			dataType:   "json",
			success	:	function(result){
				$('.frmITLocalTeam input[name="return_computer_date"]').val(result.return_date_computer);
				$('.frmITLocalTeam input[name="return_computer_headset"]').val(result.return_date_headset);
				$('.frmITLocalTeam input[name="return_computer_tools"]').val(result.return_date_accessories);
				$('.frmITLocalTeam input[name="disable_dialer_id"]').val(result.disablement_date_dialer);
				$('.frmITLocalTeam input[name="disable_crm_id"]').val(result.disablement_date_crm);
				$('.frmITLocalTeam textarea[name="security_remarks"]').val(result.it_local_remarks);
				$('.frmITLocalTeam textarea[name="it_local_comments"]').val(result.it_local_comments);
				
				$('.frmITLocalTeam select[name="is_return_computer_date"]').val(result.is_return_date_computer);
				$('.frmITLocalTeam select[name="is_return_computer_headset"]').val(result.is_return_date_headset);
				$('.frmITLocalTeam select[name="is_return_computer_tools"]').val(result.is_return_date_accessories);
				$('.frmITLocalTeam select[name="is_disable_dialer_id"]').val(result.is_disablement_date_dialer);
				$('.frmITLocalTeam select[name="is_disable_crm_id"]').val(result.is_disablement_date_crm);
				
				requiredUpdationYesNo('.frmITLocalTeam');
				
				$('.imgView').hide();
				imgVal = result.return_date_computer_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('input[name="return_computer_date_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('input[name="return_computer_date_file"]').closest('div').children('span.imgView').show();
				}
				imgVal = result.disablement_date_crm_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('input[name="disable_crm_id_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('input[name="disable_crm_id_file"]').closest('div').children('span.imgView').show();
				}				
				imgVal = result.disablement_date_dialer_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('input[name="disable_dialer_id_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('input[name="disable_dialer_id_file"]').closest('div').children('span.imgView').show();
				}
				
				$("#fnfITLocalTeam").modal('show');
			}
		});	
	});	
	
	$("#fnfITLocalSave").click(function(){			
		baseURL = "<?php echo base_url(); ?>";
		var uid=$('.frmITLocalTeam #user_id').val().trim();
		var fid=$('.frmITLocalTeam #fnf_id').val();
		var rid=$('.frmITLocalTeam #resign_id').val().trim();
		
		returnDate1 = $('.frmITLocalTeam input[name="return_computer_date"]').val();
		returnDate2 = $('.frmITLocalTeam input[name="return_computer_headset"]').val();
		returnDate3 = $('.frmITLocalTeam input[name="return_computer_tools"]').val();
		returnDate4 = $('.frmITLocalTeam input[name="disable_dialer_id"]').val();
		returnDate5 = $('.frmITLocalTeam input[name="disable_crm_id"]').val();
		returnDate6 = $('.frmITLocalTeam textarea[name="it_local_comments"]').val();
		
		checkup = true;
		$('.frmITLocalTeam .required').each(function(){
			dataCheck = $(this).find(':input').val();
			if(dataCheck == ""){ checkup = false; }
		});
		$('.frmITLocalTeam .yesNoSelection').each(function(){
			dataCheck = $(this).val();
			if(dataCheck == ""){ checkup = false; }
		});
		
		//if((returnDate1 == "") || (returnDate2 == "") || (returnDate3 == "") || (returnDate4 == "") || (returnDate5 == "")){
		if(checkup == false){
			alert("Please Enter All Details!");
		} else {					
		if((uid!="" && fid!="")){
			$('#sktPleaseWait').modal('show');			
			var form = $('#frmITLocalTeam')[0];
			var formData = new FormData(form);		
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'fnf/fnf_it_local_checkpoint',
				data	:	formData,
				contentType: false, 
				processData: false,
				success	:	function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#fnfITLocalTeam').modal('hide');
					//console.log(msg);
					location.reload();
				}
			});
		}else{
			alert("One or More field is blank!");
		}
		}
	});
	
	
//==========================================================================================================	
//  2. IT NETWORK TEAM 
//==========================================================================================================
		  
	$(".editfnfITNetworkTeam").click(function(){
		var extrapar=$(this).attr("extrapar");		
		fnfd = extrapar.split('#');
		$('.frmITNetworkTeam #user_id').val(fnfd[0]);
		$('.frmITNetworkTeam #fnf_id').val(fnfd[2]);
		$('.frmITNetworkTeam #resign_id').val(fnfd[1]);
				
		// SECURITY REMARKS					
		var ftype=$(this).attr("ftype");
		$('.frmITNetworkTeam #f_type').val(ftype);
		$('.securityRemarks').hide();
		$('.frmITNetworkTeam textarea[name="security_remarks"]').removeAttr('required');
		$(".frmITNetworkTeam :input").removeAttr("disabled", "disabled");
		if(ftype == 2){
			$(".frmITNetworkTeam :input").prop("disabled", true);
			$('.frmITNetworkTeam textarea[name="security_remarks"]').attr('required', 'required'); 
			$('.frmITNetworkTeam textarea[name="security_remarks"]').removeAttr('disabled', 'disabled'); 
			$('.frmITNetworkTeam input[name="user_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmITNetworkTeam input[name="fnf_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmITNetworkTeam input[name="f_type"]').removeAttr('disabled', 'disabled'); 
			$('.frmITNetworkTeam input[name="resign_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmITNetworkTeam button[type="submit"]').removeAttr('disabled', 'disabled'); 
			$('.frmITNetworkTeam button[type="button"]').removeAttr('disabled', 'disabled'); 
			$('.securityRemarks').show(); 
		}
		
		// GET FNF DETAILS
		baseURL = "<?php echo base_url(); ?>";
		$.ajax({
			type	: 	'POST',    
			url		:	baseURL+'fnf/fnf_details_ajax',
			data	:	"fnf_id=" + fnfd[2],
			dataType:   "json",
			success	:	function(result){
				$('.frmITNetworkTeam input[name="disablement_date_vpn"]').val(result.disablement_date_vpn);
				$('.frmITNetworkTeam input[name="disablement_date_firewall"]').val(result.disablement_date_firewall);				
				$('.frmITNetworkTeam textarea[name="security_remarks"]').val(result.it_network_remarks);
				
				$('.frmITNetworkTeam select[name="is_disablement_date_vpn"]').val(result.is_disablement_date_vpn);
				$('.frmITNetworkTeam select[name="is_disablement_date_firewall"]').val(result.is_disablement_date_firewall);				
				
				requiredUpdationYesNo('.frmITNetworkTeam');
				
				$('.imgView').hide();
				imgVal = result.disablement_date_firewall_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('input[name="disablement_date_firewall_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('input[name="disablement_date_firewall_file"]').closest('div').children('span.imgView').show();
				}
				
				$("#fnfITNetworkTeam").modal('show');
			}
		});	
	});	
	
	$("#fnfITNetworkSave").click(function(){			
		baseURL = "<?php echo base_url(); ?>";
		var uid=$('.frmITNetworkTeam #user_id').val().trim();
		var fid=$('.frmITNetworkTeam #fnf_id').val();
		var rid=$('.frmITNetworkTeam #resign_id').val().trim();
		
		returnDate1 = $('.frmITNetworkTeam input[name="disablement_date_vpn"]').val();
		returnDate2 = $('.frmITNetworkTeam input[name="disablement_date_firewall"]').val();
		
		checkup = true;
		$('.frmITNetworkTeam .required').each(function(){
			dataCheck = $(this).find(':input').val();
			if(dataCheck == ""){ checkup = false; }
		});
		$('.frmITNetworkTeam .yesNoSelection').each(function(){
			dataCheck = $(this).val();
			if(dataCheck == ""){ checkup = false; }
		});
		
		//if((returnDate1 == "") || (returnDate2 == "")){
		if(checkup == false){
			alert("Please Enter All Details!");
		} else {					
		if((uid!="" && fid!="")){
			$('#sktPleaseWait').modal('show');			
			var form = $('#frmITNetworkTeam')[0];
			var formData = new FormData(form);		
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'fnf/fnf_it_network_checkpoint',
				data	:	formData,
				contentType: false, 
				processData: false,
				success	:	function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#fnfITNetworkTeam').modal('hide');
					//console.log(msg);
					location.reload();
				}
			});
		}else{
			alert("One or More field is blank!");
		}
		}
	});
	
	
	
//==========================================================================================================	
//  3. IT GLOBAL HELPDESK
//==========================================================================================================
		  
	$(".editfnfITGlobalHelpdeskTeam").click(function(){
		var extrapar=$(this).attr("extrapar");		
		fnfd = extrapar.split('#');
		$('.frmITGlobalHelpdeskTeam #user_id').val(fnfd[0]);
		$('.frmITGlobalHelpdeskTeam #fnf_id').val(fnfd[2]);
		$('.frmITGlobalHelpdeskTeam #resign_id').val(fnfd[1]);
		
		
		// SECURITY REMARKS					
		var ftype=$(this).attr("ftype");
		$('.frmITGlobalHelpdeskTeam #f_type').val(ftype);
		$('.securityRemarks').hide();
		$('.frmITGlobalHelpdeskTeam textarea[name="security_remarks"]').removeAttr('required');
		$(".frmITGlobalHelpdeskTeam :input").removeAttr("disabled", "disabled");
		if(ftype == 2){
			$(".frmITGlobalHelpdeskTeam :input").prop("disabled", true);
			$('.frmITGlobalHelpdeskTeam textarea[name="security_remarks"]').attr('required', 'required'); 
			$('.frmITGlobalHelpdeskTeam textarea[name="security_remarks"]').removeAttr('disabled', 'disabled'); 
			$('.frmITGlobalHelpdeskTeam input[name="user_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmITGlobalHelpdeskTeam input[name="fnf_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmITGlobalHelpdeskTeam input[name="f_type"]').removeAttr('disabled', 'disabled'); 
			$('.frmITGlobalHelpdeskTeam input[name="resign_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmITGlobalHelpdeskTeam button[type="submit"]').removeAttr('disabled', 'disabled'); 
			$('.frmITGlobalHelpdeskTeam button[type="button"]').removeAttr('disabled', 'disabled'); 
			$('.securityRemarks').show(); 
		}
		
		// GET FNF DETAILS
		baseURL = "<?php echo base_url(); ?>";
		$.ajax({
			type	: 	'POST',    
			url		:	baseURL+'fnf/fnf_details_ajax',
			data	:	"fnf_id=" + fnfd[2],
			dataType:   "json",
			success	:	function(result){
				
				$('.frmITGlobalHelpdeskTeam input[name="disablement_date_domain"]').val(result.disablement_date_domain);							
				$('.frmITGlobalHelpdeskTeam input[name="disablement_date_email"]').val(result.disablement_date_email);				
				$('.frmITGlobalHelpdeskTeam input[name="disablement_date_ticket"]').val(result.disablement_date_ticket);					
				$('.frmITGlobalHelpdeskTeam textarea[name="security_remarks"]').val(result.it_global_helpdesk_remarks);
				
				$('.frmITGlobalHelpdeskTeam select[name="is_disablement_date_domain"]').val(result.is_disablement_date_domain);
				$('.frmITGlobalHelpdeskTeam select[name="is_disablement_date_email"]').val(result.is_disablement_date_email);	
				$('.frmITGlobalHelpdeskTeam select[name="is_disablement_date_ticket"]').val(result.is_disablement_date_ticket);		
				
				requiredUpdationYesNo('.frmITGlobalHelpdeskTeam');
				
				$('.imgView').hide();
				imgVal = result.disablement_date_domain_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('input[name="disablement_date_domain_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('input[name="disablement_date_domain_file"]').closest('div').children('span.imgView').show();
				}
				imgVal = result.disablement_date_email_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('input[name="disablement_date_email_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('input[name="disablement_date_email_file"]').closest('div').children('span.imgView').show();
				}
				imgVal = result.disablement_date_ticket_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('input[name="disablement_date_ticket_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('input[name="disablement_date_ticket_file"]').closest('div').children('span.imgView').show();
				}				
				$("#fnfITGlobalHelpdeskTeam").modal('show');
			}
		});	
	});	
	
	$("#fnfITGlobalHelpdeskSave").click(function(){			
		baseURL = "<?php echo base_url(); ?>";
		var uid=$('.frmITGlobalHelpdeskTeam #user_id').val().trim();
		var fid=$('.frmITGlobalHelpdeskTeam #fnf_id').val();
		var rid=$('.frmITGlobalHelpdeskTeam #resign_id').val().trim();
		
		returnDate1 = $('.frmITGlobalHelpdeskTeam input[name="disablement_date_domain"]').val();
		returnDate2 = $('.frmITGlobalHelpdeskTeam input[name="disablement_date_email"]').val();
		returnDate3 = $('.frmITGlobalHelpdeskTeam input[name="disablement_date_ticket"]').val();
		
		checkup = true;
		$('.frmITGlobalHelpdeskTeam .required').each(function(){
			dataCheck = $(this).find(':input').val();
			if(dataCheck == ""){ checkup = false; }
		});
		$('.frmITGlobalHelpdeskTeam .yesNoSelection').each(function(){
			dataCheck = $(this).val();
			if(dataCheck == ""){ checkup = false; }
		});
		
		//if((returnDate1 == "") || (returnDate2 == "") || (returnDate3 == "")){
		if(checkup == false){
			alert("Please Enter All Details!");
		} else {					
		if((uid!="" && fid!="")){
			$('#sktPleaseWait').modal('show');			
			var form = $('#frmITGlobalHelpdeskTeam')[0];
			var formData = new FormData(form);		
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'fnf/fnf_it_globalhelpdesk_checkpoint',
				data	:	formData,
				contentType: false, 
				processData: false,
				success	:	function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#fnfITGlobalHelpdeskTeam').modal('hide');
					//console.log(msg);
					location.reload();
				}
			});
		}else{
			alert("One or More field is blank!");
		}
		}
	});

//==========================================================================================================	
//  4. FNF Payroll TEAM
//==========================================================================================================
		  
	$(".editfnfPayrollTeam").click(function(){
		var extrapar=$(this).attr("extrapar");		
		fnfd = extrapar.split('#');
		$('.frmPayrollTeam #user_id').val(fnfd[0]);
		$('.frmPayrollTeam #fnf_id').val(fnfd[2]);
		$('.frmPayrollTeam #resign_id').val(fnfd[1]);
		
		// SECURITY REMARKS
		$('.payrollTeamGross').show();		
		var ftype=$(this).attr("ftype");
		$('.frmPayrollTeam #f_type').val(ftype);
		$('.securityRemarks').hide();
		$('.frmPayrollTeam textarea[name="security_remarks"]').removeAttr('required');
		$(".frmPayrollTeam :input").removeAttr("disabled", "disabled");
		if(ftype == 2){
			$(".frmPayrollTeam :input").prop("disabled", true);
			$('.frmPayrollTeam textarea[name="security_remarks"]').attr('required', 'required'); 
			$('.frmPayrollTeam textarea[name="security_remarks"]').removeAttr('disabled', 'disabled'); 
			$('.frmPayrollTeam input[name="user_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmPayrollTeam input[name="fnf_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmPayrollTeam input[name="f_type"]').removeAttr('disabled', 'disabled'); 
			$('.frmPayrollTeam input[name="resign_id"]').removeAttr('disabled', 'disabled'); 
			$('.frmPayrollTeam button[type="submit"]').removeAttr('disabled', 'disabled'); 
			$('.frmPayrollTeam button[type="button"]').removeAttr('disabled', 'disabled'); 
			$('.securityRemarks').show();
			$('.payrollTeamGross').hide();			
		}
				
		// GET FNF DETAILS
		baseURL = "<?php echo base_url(); ?>";
		$.ajax({
			type	: 	'POST',    
			url		:	baseURL+'fnf/fnf_details_ajax',
			data	:	"fnf_id=" + fnfd[2],
			dataType:   "json",
			success	:	function(result){
				$('.frmPayrollTeam input[name="last_month_unpaid"]').val(result.last_month_unpaid);
				$('.frmPayrollTeam input[name="leave_encashment"]').val(result.leave_encashment);				
				$('.frmPayrollTeam input[name="notice_pay"]').val(result.notice_pay);				
				$('.frmPayrollTeam input[name="pf_deduction"]').val(result.pf_deduction);				
				$('.frmPayrollTeam input[name="esic_deduction"]').val(result.esic_deduction);				
				$('.frmPayrollTeam input[name="ptax_deduction"]').val(result.ptax_deduction);				
				$('.frmPayrollTeam input[name="tds_deductions"]').val(result.tds_deductions);				
				$('.frmPayrollTeam input[name="loan_recovery"]').val(result.loan_recovery);				
				$('.frmPayrollTeam input[name="total_deduction"]').val(result.total_deduction);				
				$('.frmPayrollTeam input[name="net_payment"]').val(result.net_payment);				
				$('.frmPayrollTeam select[name="biometric_access_revocation"]').val(result.biometric_access_revocation);				
				$('.frmPayrollTeam textarea[name="security_remarks"]').val(result.payroll_remarks);				
				$('.imgView').hide();
				imgVal = result.biometric_access_revocation_file;
				if(imgVal !== "" && imgVal !== null && imgVal !== undefined)
				{
					imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
					imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='"+ imgURL +"'><i class='fa fa-download'></i> " + imgVal + "</a>";
					$('.frmPayrollTeam input[name="biometric_access_revocation_file"]').closest('div').children('span.imgView').html(imgViewSpan);
					$('.frmPayrollTeam input[name="biometric_access_revocation_file"]').closest('div').children('span.imgView').show();
				}
				if(result.payroll_status == 'C'){
					if(result.payroll_remarks)
					{
						$(".frmPayrollTeam :input").prop("disabled", true);
						$('.frmPayrollTeam #fnfPayrollTeamSave').hide(); 
					} else {
						if(ftype == 1)
						{
							$(".frmPayrollTeam :input").prop("disabled", true);
							$('.frmPayrollTeam #fnfPayrollTeamSave').hide();
						} else {
							$('.frmPayrollTeam #fnfPayrollTeamSave').show();
						}
					}
				} 
				else { 
					$('.frmPayrollTeam #fnfPayrollTeamSave').show(); 
				}				
				$("#fnfPayrollTeam").modal('show');
			}
		});	
	});	
	
	$("#fnfPayrollTeamSave").click(function(){			
		baseURL = "<?php echo base_url(); ?>";
		var uid=$('.frmPayrollTeam #user_id').val().trim();
		var fid=$('.frmPayrollTeam #fnf_id').val();
		var rid=$('.frmPayrollTeam #resign_id').val().trim();
		
		returnDate1 = $('.frmPayrollTeam input[name="last_month_unpaid"]').val();
		returnDate2 = $('.frmPayrollTeam input[name="leave_encashment"]').val();
		returnDate3 = $('.frmPayrollTeam input[name="notice_pay"]').val();
		returnDate4 = $('.frmPayrollTeam input[name="pf_deduction"]').val();
		returnDate5 = $('.frmPayrollTeam input[name="esic_deduction"]').val();
		returnDate6 = $('.frmPayrollTeam input[name="ptax_deduction"]').val();
		returnDate7 = $('.frmPayrollTeam input[name="tds_deductions"]').val();
		returnDate8 = $('.frmPayrollTeam input[name="loan_recovery"]').val();
		returnDate9 = $('.frmPayrollTeam input[name="total_deduction"]').val();
		returnDate10 = $('.frmPayrollTeam input[name="net_payment"]').val();
		returnDate11 = $('.frmPayrollTeam select[name="biometric_access_revocation"]').val();
		
		if((returnDate1 == "") || (returnDate2 == "") || (returnDate3 == "") || (returnDate4 == "") || (returnDate5 == "") || (returnDate6 == "") || (returnDate7 == "") || (returnDate8 == "") || (returnDate9 == "") || (returnDate10 == "") || (returnDate11 == "")){
			alert("Please Enter All Details!");
		} else {					
		if((uid!="" && fid!="")){
			$('#sktPleaseWait').modal('show');			
			var form = $('#frmPayrollTeam')[0];
			var formData = new FormData(form);		
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'fnf/fnf_it_payrollteam_checkpoint',
				data	:	formData,
				contentType: false, 
				processData: false,
				success	:	function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#fnfPayrollTeam').modal('hide');
					//console.log(msg);
					location.reload();
				}
			});
		}else{
			alert("One or More field is blank!");
		}
		}
	});
			

//==========================================================================================================	
//  5. FNF Accounts TEAM
//==========================================================================================================
		  
	$(".editfnfAccountsTeam").click(function(){
		var extrapar=$(this).attr("extrapar");		
		fnfd = extrapar.split('#');
		$('.frmAccountsTeam #user_id').val(fnfd[0]);
		$('.frmAccountsTeam #fnf_id').val(fnfd[2]);
		$('.frmAccountsTeam #resign_id').val(fnfd[1]);
		$('.frmAccountsTeam #payment_id').val(fnfd[3]);

		// GET FNF DETAILS
		baseURL = "<?php echo base_url(); ?>";
		$.ajax({
			type	: 	'POST',    
			url		:	baseURL+'fnf/fnf_details_ajax',
			data	:	"fnf_id=" + fnfd[2],
			dataType:   "json",
			success	:	function(result){
				$('.frmAccountsTeam input[name="last_month_unpaid"]').val(result.last_month_unpaid);
				$('.frmAccountsTeam input[name="leave_encashment"]').val(result.leave_encashment);				
				$('.frmAccountsTeam input[name="notice_pay"]').val(result.notice_pay);				
				$('.frmAccountsTeam input[name="pf_deduction"]').val(result.pf_deduction);				
				$('.frmAccountsTeam input[name="esic_deduction"]').val(result.esic_deduction);				
				$('.frmAccountsTeam input[name="ptax_deduction"]').val(result.ptax_deduction);				
				$('.frmAccountsTeam input[name="tds_deductions"]').val(result.tds_deductions);				
				$('.frmAccountsTeam input[name="loan_recovery"]').val(result.loan_recovery);				
				$('.frmAccountsTeam input[name="total_deduction"]').val(result.total_deduction);				
				$('.frmAccountsTeam input[name="net_payment"]').val(result.net_payment);				
				$('.frmAccountsTeam textarea[name="status_salary_loan"]').val(result.status_salary_loan);				
				$('.frmAccountsTeam textarea[name="status_credit_card"]').val(result.status_credit_card);				
				$('.frmAccountsTeam textarea[name="status_gift_card"]').val(result.status_gift_card);				
				$('.frmAccountsTeam textarea[name="status_reimbursement"]').val(result.status_reimbursement);				
				$('.frmAccountsTeam textarea[name="status_incentive"]').val(result.status_incentive);				
				$('.frmAccountsTeam textarea[name="payment_id"]').val(result.payment_id);			
				
				if(result.p_accounts_status == 'C'){ 
					$('.frmAccountsTeam #fnfAccountsTeamSave').hide(); 
					$('.frmAccountsTeam #accountSubmission').hide(); 
					//$('.frmAccountsTeam #accountSubmissionStatus').hide(); 
				} 
				else { 
					$('.frmAccountsTeam #fnfAccountsTeamSave').show(); 
					$('.frmAccountsTeam #accountSubmission').show(); 
					//$('.frmAccountsTeam #accountSubmissionStatus').show(); 
				}
				
				$("#fnfAccountsTeam").modal('show');
			}
		});	
	});	
	
	$("#fnfAccountsTeamSave").click(function(){			
		baseURL = "<?php echo base_url(); ?>";
		var uid=$('.frmAccountsTeam #user_id').val().trim();
		var fid=$('.frmAccountsTeam #fnf_id').val();
		var rid=$('.frmAccountsTeam #resign_id').val().trim();
		var pid=$('.frmAccountsTeam #payment_id').val().trim();
		
		returnDate1 = $('.frmAccountsTeam input[name="last_month_unpaid"]').val();
		returnDate2 = $('.frmAccountsTeam input[name="leave_encashment"]').val();
		returnDate3 = $('.frmAccountsTeam input[name="notice_pay"]').val();
		returnDate4 = $('.frmAccountsTeam input[name="pf_deduction"]').val();
		returnDate5 = $('.frmAccountsTeam input[name="esic_deduction"]').val();
		returnDate6 = $('.frmAccountsTeam input[name="ptax_deduction"]').val();
		returnDate7 = $('.frmAccountsTeam input[name="tds_deductions"]').val();
		returnDate8 = $('.frmAccountsTeam input[name="loan_recovery"]').val();
		returnDate9 = $('.frmAccountsTeam input[name="total_deduction"]').val();
		returnDate10 = $('.frmAccountsTeam input[name="net_payment"]').val();
		returnDate11 = $('.frmAccountsTeam select[name="biometric_access_revocation"]').val();
		returnDate12 = $('.frmAccountsTeam select[name="payment_id"]').val();
		
		if((returnDate1 == "") && (returnDate2 == "") && (returnDate3 == "") && (returnDate4 == "") && (returnDate5 == "") && (returnDate6 == "") && (returnDate7 == "") && (returnDate8 == "") && (returnDate9 == "") && (returnDate10 == "") && (returnDate11 == "") && (returnDate12 == "")){
			alert("Please Enter All Details!");
		} else {					
		if((uid!="" && fid!="" && pid!= "")){
			$('#sktPleaseWait').modal('show');			
			var form = $('#frmAccountsTeam')[0];
			var formData = new FormData(form);		
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'fnf/fnf_accountsteam_checkpoint',
				data	:	formData,
				contentType: false, 
				processData: false,
				success	:	function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#fnfAccountsTeam').modal('hide');
					//console.log(msg);
					location.reload();
				}
			});
		}else{
			alert("One or More field is blank!");
		}
		}
	});
			

/*	
        // ============= HELPDESK PART ================================================
		  
			$(".editfnfHelpdesk").click(function(){
				var params=$(this).attr("params");
				var checked=$(this).attr("checks");
				var extrapar=$(this).attr("extrapar");
				
				fnfd = extrapar.split('#');
				$('.frmITHelpdesk #user_id').val(fnfd[0]);
				$('.frmITHelpdesk #fnf_id').val(fnfd[2]);
				$('.frmITHelpdesk #resign_id').val(fnfd[1]);
				
				check = params.split('#');
				checkpoint = checked.split('#');
				helpcheck = 0;
				if(fnfd[1]!=""){
					if(check[0] == 1){ $('#domainid_f').show(); helpcheck++;
					if(checkpoint[0] == 1){ $('#domain_id_deletion').prop('checked', true); } else { $('#domain_id_deletion').prop('checked', false); } }
					if(check[1] == 1){ $('#emailid_f').show(); helpcheck++;
					if(checkpoint[1] == 1){ $('#email_id_deletion').prop('checked', true); } else { $('#email_id_deletion').prop('checked', false); } }
					if(check[2] == 1){ $('#loginid_f').show(); helpcheck++;
					if(checkpoint[2] == 1){ $('#login_credential_deletion').prop('checked', true); } else { $('#login_credential_deletion').prop('checked', false); } }
					if(check[3] == 1){ $('#phoneid_f').show(); helpcheck++;
					if(checkpoint[3] == 1){ $('#phone_login_deletion').prop('checked', true); } else { $('#phone_login_deletion').prop('checked', false); } }
					if(helpcheck > 0){ $('#noneDeletion').hide(); } else { $('#noneDeletion').show(); }
				} else {
					$('#domainid_f').show(); 
					if(checkpoint[0] == 1){ $('#domain_id_deletion').prop('checked', true); } else { $('#domain_id_deletion').prop('checked', false); }
					$('#emailid_f').show(); 
					if(checkpoint[1] == 1){ $('#email_id_deletion').prop('checked', true); } else { $('#email_id_deletion').prop('checked', false); }
					$('#loginid_f').show(); 
					if(checkpoint[2] == 1){ $('#login_credential_deletion').prop('checked', true); } else { $('#login_credential_deletion').prop('checked', false); }
					$('#phoneid_f').show(); 
					if(checkpoint[3] == 1){ $('#phone_login_deletion').prop('checked', true); } else { $('#phone_login_deletion').prop('checked', false); }					
				}
				
				if(checkpoint[4] != ''){ $('#computer_items').val(checkpoint[4]); } else { $('#computer_items').val('');  }
				if(checkpoint[5] != ''){ $('#all_check').val(checkpoint[5]); } else { $('#all_check').val('');   }
				if(checkpoint[6] != ''){ $('#ecomment_f').show(); $('#security_comments').val(checkpoint[6]); } else { $('#ecomment_f').val(''); }
				
				$("#fnfHelpdesk").modal('show');
			
			});
			
			
			$("#fnfHelpdeskSave").click(function(){
				
				baseURL = "<?php echo base_url(); ?>";
				var uid=$('.frmITHelpdesk #user_id').val().trim();
				var fid=$('.frmITHelpdesk #fnf_id').val();
				var rid=$('.frmITHelpdesk #resign_id').val().trim();
				
				cval = $('#computer_items').val();
				callcheck = $('#all_check').val();
				comments = $('#security_comments').val();
				
				if((cval == "NA") && (comments == "")){
					alert("One or More field's are blank");
				} else {					
				if((uid!="" && fid!="") && (cval!="" && callcheck!="")){
					$('#sktPleaseWait').modal('show');
					$.ajax({
						type	: 	'POST',    
						url		:	baseURL+'fnf/fnf_helpdesk_checkpoint',
						data	:	$('form.frmITHelpdesk').serialize(),
						success	:	function(msg){
									$('#sktPleaseWait').modal('hide');
									$('#fnfHelpdesk').modal('hide');
									location.reload();
								}
					});
				}else{
					alert("One or More field's are blank");
				}
				}
			});
			
			
		// ============= SECURITY PART ================================================
		  
			$(".editfnfSecurity").click(function(){
				
				var checked=$(this).attr("checks");
				var extrapar=$(this).attr("extrapar");
				
				fnfd = extrapar.split('#');
				$('.frmITSecurity #user_id').val(fnfd[0]);
				$('.frmITSecurity #fnf_id').val(fnfd[2]);
				$('.frmITSecurity #resign_id').val(fnfd[1]);
				
				checkpoint = checked.split('#');
				
				$('.frmITSecurity #user_id').val(fnfd[0]);
				
				if(checkpoint[0] != ''){ $('#laptop_returned').val(checkpoint[0]); } else { $('#laptop_returned').val(''); } 
				//if(checkpoint[1] != ''){ $('#computer_items').val(checkpoint[1]); } else { $('#computer_items').val('');  }
				//if(checkpoint[2] != ''){ $('#all_check').val(checkpoint[2]); } else { $('#all_check').val('');   }
				//if(checkpoint[3] != ''){ $('#ecomment_f').show(); $('#security_comments').val(checkpoint[3]); } else { $('#ecomment_f').val(''); }
				
				var params=$(this).attr("params");
				check = params.split('#');
				helpcheck = 0;
				if(fnfd[1]!=""){
					if(check[0] == 1){ $('#sec_domainid_f').show(); helpcheck++;
					if(checkpoint[1] == 1){ $('#sec_domain_id_deletion').prop('checked', true); } else { $('#sec_domain_id_deletion').prop('checked', false); } }
					if(check[1] == 1){ $('#sec_emailid_f').show(); helpcheck++;
					if(checkpoint[2] == 1){ $('#sec_email_id_deletion').prop('checked', true); } else { $('#sec_email_id_deletion').prop('checked', false); } }
					if(check[2] == 1){ $('#sec_loginid_f').show(); helpcheck++;
					if(checkpoint[3] == 1){ $('#sec_login_credential_deletion').prop('checked', true); } else { $('#sec_login_credential_deletion').prop('checked', false); } }
					if(check[3] == 1){ $('#sec_phoneid_f').show(); helpcheck++;
					if(checkpoint[4] == 1){ $('#sec_phone_login_deletion').prop('checked', true); } else { $('#sec_phone_login_deletion').prop('checked', false); } }
					if(helpcheck > 0){ $('#sec_noneDeletion').hide(); } else { $('#sec_noneDeletion').show(); }
				} else {
					$('#sec_domainid_f').show(); 
					if(checkpoint[1] == 1){ $('#sec_domain_id_deletion').prop('checked', true); } else { $('#sec_domain_id_deletion').prop('checked', false); }
					$('#sec_emailid_f').show(); 
					if(checkpoint[2] == 1){ $('#sec_email_id_deletion').prop('checked', true); } else { $('#sec_email_id_deletion').prop('checked', false); }
					$('#sec_loginid_f').show(); 
					if(checkpoint[3] == 1){ $('#sec_login_credential_deletion').prop('checked', true); } else { $('#sec_login_credential_deletion').prop('checked', false); }
					$('#sec_phoneid_f').show(); 
					if(checkpoint[4] == 1){ $('#sec_phone_login_deletion').prop('checked', true); } else { $('#sec_phone_login_deletion').prop('checked', false); }					
				}
				
				var helpdesk = $(this).attr("helpd");
				helpStatus = helpdesk.split('#');
				$('#sec_l1_confirm').hide();
				$('#sec_l1_notconfirm').show();
				$('#sec_asset_confirm').hide();
				$('#sec_asset_preconfirm').hide();
				$('#sec_asset_notconfirm').show();
				if(helpStatus[0] == 'C'){ $('#sec_l1_confirm').show(); $('#sec_l1_notconfirm').hide(); }
				if(helpStatus[1] == 'Yes'){ $('#sec_asset_confirm').show(); $('#sec_asset_preconfirm').hide(); $('#sec_asset_notconfirm').hide(); }
				if(helpStatus[1] == 'NA'){ $('#sec_asset_preconfirm').show(); $('#sec_asset_confirm').hide(); $('#sec_asset_notconfirm').hide(); }

				
				$("#fnfSecurity").modal('show');
			
			});
			
			$("#computer_items").change(function(){
				cval = $('#computer_items').val();
				if(cval == "NA"){ $('#ecomment_f').show(); } 
				else { $('#ecomment_f').hide();  $('#security_comments').val(''); }
			});
			
			
			$("#fnfSecuritySave").click(function(){
				
				baseURL = "<?php echo base_url(); ?>";
				var uid=$('.frmITSecurity #user_id').val().trim();
				var fid=$('.frmITSecurity #fnf_id').val();
				var rid=$('.frmITSecurity #resign_id').val().trim();
				
				//cval = $('#computer_items').val();
				claptop = $('#laptop_returned').val();
				//callcheck = $('#all_check').val();
				//comments = $('#security_comments').val();
				
				//if((cval == "NA") && (comments == "")){
					//alert("One or More field's are blank");
				//} else {
				//&& callcheck!="" && cval!=""
				if((uid!="" && fid!="") && (claptop!="")){
					$('#sktPleaseWait').modal('show');
					$.ajax({
						type	: 	'POST',    
						url		:	baseURL+'fnf/fnf_security_checkpoint',
						data	:	$('form.frmITSecurity').serialize(),
						success	:	function(msg){
									$('#sktPleaseWait').modal('hide');
									$('#fnfSecurity').modal('hide');
									location.reload();
								}
					});
				}else{
					alert("One or More field's are blank");
				}
				//}
			});
		
		
		
		
		
		
		// ============= PAYROLL PART ================================================
		  
			$(".editfnfPayroll").click(function(){
				
				var checked=$(this).attr("checks");
				var extrapar=$(this).attr("extrapar");
				
				fnfd = extrapar.split('#');
				$('.frmPayroll #user_id').val(fnfd[0]);
				$('.frmPayroll #fnf_id').val(fnfd[2]);
				$('.frmPayroll #resign_id').val(fnfd[1]);
				
				checkpoint = checked.split('#');
				
				$('.frmPayroll #user_id').val(fnfd[0]);
				
				if(checkpoint[0] != ''){ $('.frmPayroll #last_month_unpaid').val(checkpoint[0]); } else { $('.frmPayroll #last_month_unpaid').val('');  }				 
				//if(checkpoint[1] != ''){ $('.frmPayroll #loss_of_pay').val(checkpoint[1]); } else { $('.frmPayroll #loss_of_pay').val(''); }				
				if(checkpoint[2] != ''){ $('.frmPayroll #notice_pay').val(checkpoint[2]); } else { $('.frmPayroll #notice_pay').val(''); }
				if(checkpoint[3] != ''){ $('.frmPayroll #pf_deduction').val(checkpoint[3]); } else { $('.frmPayroll #pf_deduction').val(''); }
				if(checkpoint[4] != ''){ $('.frmPayroll #esic_deduction').val(checkpoint[4]); } else { $('.frmPayroll #esic_deduction').val(''); }
				if(checkpoint[5] != ''){ $('.frmPayroll #ptax_deduction').val(checkpoint[5]); } else { $('.frmPayroll #ptax_deduction').val(''); }
				//if(checkpoint[3] != ''){ $('.frmPayroll #misc_deductions').val(checkpoint[3]); } else { $('.frmPayroll #misc_deductions').val(''); }
				if(checkpoint[6] != ''){ $('.frmPayroll #tds_deductions').val(checkpoint[6]); } else { $('.frmPayroll #tds_deductions').val(''); }
				//if(checkpoint[5] != ''){ $('.frmPayroll #others_pay').val(checkpoint[5]); } else { $('.frmPayroll #others_pay').val(''); }
				if(checkpoint[7] != ''){ $('.frmPayroll #loan_recovery').val(checkpoint[7]); } else { $('.frmPayroll #loan_recovery').val(''); }
				if(checkpoint[8] != ''){ $('.frmPayroll #total_deduction').val(checkpoint[8]); } else { $('.frmPayroll #total_deduction').val(''); }
				if(checkpoint[9] != ''){ $('.frmPayroll #net_payment').val(checkpoint[9]); } else { $('.frmPayroll #net_payment').val(''); }
				if(checkpoint[10] == 'C'){ $('#fnfPayrollSave').hide(); } else { $('#fnfPayrollSave').show(); }				
				if(checkpoint[1] != ''){ $('.frmPayroll #leave_encashment').val(checkpoint[1]); } else {
						if(checkpoint[11] != ''){ $('.frmPayroll #leave_encashment').val(checkpoint[11]); } else { $('.frmPayroll #leave_encashment').val(''); }  
				}
								
				$("#fnfPayroll").modal('show');
			
			});
			
	
			$("#fnfPayrollSave").click(function(){
				
				baseURL = "<?php echo base_url(); ?>";
				var uid=$('.frmPayroll #user_id').val().trim();
				var fid=$('.frmPayroll #fnf_id').val();
				var rid=$('.frmPayroll #resign_id').val().trim();
				
				// REQUIRED FIELDS
				var lastmonth = $('.frmPayroll #last_month_unpaid').val();
				var leave = $('.frmPayroll #leave_encashment').val();
				//var lossofpay = $('.frmPayroll #loss_of_pay').val();
				var noticepay = $('.frmPayroll #notice_pay').val();
				var pf = $('.frmPayroll #pf_deduction').val();
				var esic = $('.frmPayroll #esic_deduction').val();
				var ptax = $('.frmPayroll #ptax_deduction').val();
				//var misc_deductions = $('.frmPayroll #misc_deductions').val();
				var tds_deductions = $('.frmPayroll #tds_deductions').val();
				//var others_pay = $('.frmPayroll #others_pay').val();
				var loan_recovery = $('.frmPayroll #loan_recovery').val();
				var total_deduction = $('.frmPayroll #total_deduction').val();
				var net_payment = $('.frmPayroll #net_payment').val();
				
				if((uid!="" && fid!="") && (lastmonth != "" && leave != "" && noticepay!="" && pf!=""  && esic!=""  && ptax!=""  && tds_deductions!="" && loan_recovery!="" && total_deduction!="" && net_payment!="")){
					$('#sktPleaseWait').modal('show');
					$.ajax({
						type	: 	'POST',    
						url		:	baseURL+'fnf/fnf_payroll_checkpoint',
						data	:	$('form.frmPayroll').serialize(),
						success	:	function(msg){
									$('#sktPleaseWait').modal('hide');
									$('#fnfPayroll').modal('hide');
									location.reload();
								}
					});
				}else{
					alert("One or More field's are blank, Please enter 0 if not applicable!");
				}
			});

		
		
		
		
		// ============= ACCOUNTS PART ================================================
		  
			$(".editfnfAccounts").click(function(){
				
				var checked=$(this).attr("checks");
				var extrapar=$(this).attr("extrapar");
				
				fnfd = extrapar.split('#');
				$('.frmAccounts #user_id').val(fnfd[0]);
				$('.frmAccounts #fnf_id').val(fnfd[2]);
				$('.frmAccounts #payment_id').val(fnfd[1]);
				
				checkpoint = checked.split('#');
				
				$('.frmAccounts #user_id').val(fnfd[0]);
				
				if(checkpoint[0] != ''){ $('.frmAccounts #last_month_unpaid').val(checkpoint[0]); } else { $('.frmAccounts #last_month_unpaid').val('');  } 
				if(checkpoint[1] != ''){ $('.frmAccounts #leave_encashment').val(checkpoint[1]); } else { $('.frmAccounts #leave_encashment').val('');  }			
				if(checkpoint[2] != ''){ $('.frmAccounts #notice_pay').val(checkpoint[2]); } else { $('.frmAccounts #notice_pay').val(''); }
				if(checkpoint[3] != ''){ $('.frmAccounts #pf_deduction').val(checkpoint[3]); } else { $('.frmAccounts #pf_deduction').val(''); }
				if(checkpoint[4] != ''){ $('.frmAccounts #esic_deduction').val(checkpoint[4]); } else { $('.frmAccounts #esic_deduction').val(''); }
				if(checkpoint[5] != ''){ $('.frmAccounts #ptax_deduction').val(checkpoint[5]); } else { $('.frmAccounts #ptax_deduction').val(''); }
				if(checkpoint[6] != ''){ $('.frmAccounts #tds_deductions').val(checkpoint[6]); } else { $('.frmAccounts #tds_deductions').val(''); }
				if(checkpoint[7] != ''){ $('.frmAccounts #loan_recovery').val(checkpoint[7]); } else { $('.frmAccounts #loan_recovery').val(''); }
				if(checkpoint[8] != ''){ $('.frmAccounts #total_deduction').val(checkpoint[8]); } else { $('.frmAccounts #total_deduction').val(''); }
				if(checkpoint[9] != ''){ $('.frmAccounts #net_payment').val(checkpoint[9]); } else { $('.frmAccounts #net_payment').val(''); }
				
				//if(checkpoint[7] != ''){ $('.frmAccounts #previous_remarks').val(checkpoint[7]); } else { }
				if(checkpoint[11] == 'C'){ $('.frmAccounts #fnfAccountsSave').hide(); $('.frmAccounts #accountSubmission').hide(); } 
				else { $('.frmAccounts #fnfAccountsSave').show(); $('.frmAccounts #accountSubmission').show(); }
				
				$("#fnfAccounts").modal('show');
			
			});
			
	
			$("#fnfAccountsSave").click(function(){
				
				baseURL = "<?php echo base_url(); ?>";
				var uid=$('.frmAccounts #user_id').val().trim();
				var fid=$('.frmAccounts #fnf_id').val();
				var rid=$('.frmAccounts #payment_id').val().trim();
				
				// REQUIRED FIELDS
				var leave = $('.frmAccounts #leave_encashment').val();
				var total_deduction = $('.frmAccounts #total_deduction').val();
				var net_payment = $('.frmAccounts #net_payment').val();
				var noticepay = $('.frmAccounts #notice_pay').val();
				var accountstatus = $('.frmAccounts #account_status').val();
				var accountremarks = $('.frmAccounts #account_remarks').val();
				
				if((uid!="" && fid!="" &&rid!="") && ((leave != "" && net_payment!="" && total_deduction!="" && noticepay!="" && accountstatus!="" && accountremarks.trim()!="" && accountstatus == 'C') || (accountstatus == 'R'))){
					$('#sktPleaseWait').modal('show');
					$.ajax({
						type	: 	'POST',    
						url		:	baseURL+'fnf/fnf_accounts_checkpoint',
						data	:	$('form.frmAccounts').serialize(),
						success	:	function(msg){
									$('#sktPleaseWait').modal('hide');
									$('#fnfAccounts').modal('hide');
									location.reload();
								}
					});
				}else{
					alert("One or More field's are blank");
				}
			});
*/		
		
		///// SELECT ALL TO SEND MAIL IN FNF 
		
		$(document).ready(function(){
			
			 $(".check_all").on("click", function() {
				 $('input:checkbox').not(this).prop('checked', this.checked);
			 }); 
			 
			 
			 
			 $('.send_mails').on("click",function(){
				 
				 var baseURL = "<?php echo base_url(); ?>";
				 var cnt=0;
				 
				$(':checkbox:checked').each(function(i,e){
					  					  
					  var fnfid = $(e).attr('value');			  
					 $.get(baseURL+"fnf/send_release_letter/"+ fnfid +"/Y");
					 cnt++;
					  
				});
				
				if(cnt>0) alert('Send');
				else alert('Select checkbox');
				 
			 });

		});
		
		
		
		// CHECK ALL FNF COMPLETION
		$('.check_complete_fnf').on('click',function(){
			baseURL = "<?php echo base_url(); ?>";
			$('#sktPleaseWait').modal('show');
			fnfCompleteIDs = $("input[name='fnfAllHRCheck']").val();
			fnfOfficeID = $("select[name='office_id']").val();
			$.ajax({
				type	: 	'GET',    
				url		:	baseURL+'fnf/bulk_fnf_hr',
				data	:	{
					"fnfID" : fnfCompleteIDs,
					"office_id" : fnfOfficeID
				},
				success	: function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#fnfFinalHRModelBulk .modal-body').html(msg);
					$('#fnfFinalHRModelBulk').modal('show');
				},
				error: function(msg){
					$('#sktPleaseWait').modal('hide');
				}
			});
				
		});
		
		 $("#fnfFinalHRModelBulk .modal-body").on("click", ".check_bulk_all", function() {
			 $('input[name="check_bulk_box[]"]:checkbox').not(this).prop('checked', this.checked);
		 });

</script>