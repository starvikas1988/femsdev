<script>
	$("#start_date").datepicker({ dateFormat: 'yy-mm-dd' });
	$("#end_date").datepicker({ dateFormat: 'yy-mm-dd' });
	$(".datePicker").datepicker({ dateFormat: 'yy-mm-dd' });

		// $(".complete_FNF").click(function(){
			
		// 	var fnfid=$(this).attr("fnfid");
		// 	//alert(fnfid);
		// 	$('.frmfnfFinalHR #fnfid').val(fnfid);
		// 	$("#fnfFinalHRModel").modal('show');
		// });
	
	    // ============= HR CHECKLIST PART ================================================
			// $("#fnfFinalHRSave").click(function(){
				
			// 	var postURL = "<?php echo base_url(); ?>fnf/hr_final_status";
				
			// 	var fnfid=$('.frmfnfFinalHR #fnfid').val();
			// 	var final_comments=$('.frmfnfFinalHR #final_comments').val().trim();
				
			// 	//alert(fnfid);
			// 	//alert(final_comments);
				
			// 	if(fnfid!="" && final_comments!=""){
			// 		$('#sktPleaseWait').modal('show');
			// 		$.ajax({
			// 			type	: 	'GET',    
			// 			url		:	postURL,
			// 			data	:	$('form.frmfnfFinalHR').serialize(),
			// 			success	:	function(msg){
			// 						$('#sktPleaseWait').modal('hide');
			// 						$('#fnfFinalHRModel').modal('hide');
			// 						location.reload();
			// 					}
			// 		});
			// 	}else{
			// 		alert("One or More field's are blank");
			// 	}	
			// });
			
			
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
					get_list('local_it');
					//location.reload();
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
		var pstatus = $(this).attr("pstatus");
		//alert(pstatus);

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


		// GET IT Assets DETAILS
		var datas = {'user_id': fnfd[0]};
		var request_url = "<?php echo base_url('fnf/get_assest_assignment_details'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if (res.stat == true) {
			if (res.active_ast==true) {
				var assets_details = "";
				var fnf_it_doc = "";

				$.each(res.datas_active,function(index,element)
				{
					if(element.fnf_it_local_status != '1'){
						assets_details += '<tr><td>'+element.user_name+'</td><td>'+element.assets_name+'</td><td>'+element.serial_number+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td><td><input class="form-control" type="date" name="it_local_release_date[]" value="<?=date("Y-m-d")?>" required></td><td><div class="file_upload_style"><input class="form-control file_validation" type="file" name="it_local_doc_file[]" required></div></td><td><input class="form-control" type="text" name="fnf_it_local_comment[]" required></td><td><input style="width: 18px;height: auto!important;min-width: 18px;margin-left: 13px;" class="form-control" type="checkbox" name="it_local_is_release[]" value="'+element.id+'" required></td></tr>';
					}else{

					if(element.fnf_it_doc!=null) fnf_it_doc = '<a href="<?=base_url()?>it_assets_import/fnf_doc/'+element.fnf_it_doc+'" target="_blank">View</a>';
					else fnf_it_doc = 'No Document Found';

						assets_details += '<tr><td>'+element.user_name+'</td><td>'+element.assets_name+'</td><td>'+element.serial_number+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td><td>'+element.fnf_it_local_return_date+'</td><td>'+fnf_it_doc+'</td><td>'+element.fnf_it_local_comment+'</td><td>Completed</td></tr>';

					}
					
				});

				$('#assets_maintanance_div #it_local_user_assets_details').html(assets_details);
				$('#assets_maintanance_div #it_local_com_fnf').val(fnfd[2]);

				if(pstatus == 'C'){
					$('#assets_maintanance_div #it_local_com_fnf').hide();
					//$('#assets_maintanance_div #assets_fnf_submit_btn').attr('disabled',false);
				}else{
					$('#assets_maintanance_div #it_local_com_fnf').show();
					$('#assets_maintanance_div #it_local_com_fnf').val(fnfd[2]);
					//$('#assets_maintanance_div #assets_fnf_submit_btn').removeAttr('disabled');		
				}	
				
			}
			else {
				$('#assets_maintanance_div #it_local_user_assets_details').html('');

				if(pstatus == 'C'){
					$('#assets_maintanance_div #it_local_com_fnf').hide();
					//$('#assets_maintanance_div #assets_fnf_submit_btn').attr('disabled',true);
				}else{
					$('#assets_maintanance_div #it_local_com_fnf').show();
					$('#assets_maintanance_div #it_local_com_fnf').val(fnfd[2]);
					//$('#assets_maintanance_div #assets_fnf_submit_btn').removeAttr('disabled');					
				}
			}
			if (res.release_ast==true) {
				var assets_details_release = "";
				var fnf_doc = "";
				$.each(res.datas_release,function(index,element)
				{
					if(element.fnf_doc!=null) fnf_doc = '<a href="<?=base_url()?>it_assets_import/fnf_doc/'+element.fnf_doc+'" target="_blank">View</a>';
					else fnf_doc = 'No Document Found';

					assets_details_release += '<tr><td>'+element.user_name+'</td><td>'+element.assets_name+'</td><td>'+element.serial_number+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td><td>'+element.return_date+'</td><td>'+fnf_doc+'</td><td>'+element.return_by_name+'</td></tr>';
				});
				$('#assets_maintanance_div #it_local_user_assets_details_returned').html(assets_details_release);
			}
			else {
				$('#assets_maintanance_div #it_local_user_assets_details_returned').html('');
			}
		}
		else {
			alert(res.errmsg);
		}
			
		},request_url, datas, 'text');


		if(pstatus=="C") { $('#fnfITLocalSave').attr("disabled", true); }
		else { $('#fnfITLocalSave').attr("disabled",false); }

		$('#fnfITLocalTeam').modal('show');
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
					get_list('local_it');
					//location.reload();
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
					get_list('it_network');
					//location.reload();
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
					get_list('it_global');
					//location.reload();
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

<script>

$(document).on('click','.procrument_fnf_save',function()
{
	var params=$(this).attr("extrapar");		
	var pstatus = $(this).attr("pstatus");
	
	var arrPrams = params.split("#");

	var datas = {'user_id': arrPrams[0]};
	var fnf_id = arrPrams[2];

	var hrcomment = $(this).attr("hrcomment");
	$('#procurement_fnf_model #hr_acc_comment').text(hrcomment);

	var request_url = "<?php echo base_url('fnf/get_assest_assignment_details'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) {
			if (res.active_ast==true) {
				var assets_details = "";
				var fnf_it_doc = "";
				var it_local_return_date = "";
				var fnf_it_local_comment = "";
				$.each(res.datas_active,function(index,element)
				{
					if(element.fnf_it_doc!=null) fnf_it_doc = '<a href="<?=base_url()?>it_assets_import/fnf_doc/'+element.fnf_it_doc+'" target="_blank">View</a>';
					else fnf_it_doc = 'No Document Found';

					if(element.fnf_it_local_return_date == null){
						it_local_return_date = '-';
					}else{
						it_local_return_date = element.fnf_it_local_return_date;
					}

					if(element.fnf_it_local_comment == null){
						fnf_it_local_comment = '-';
					}else{
						fnf_it_local_comment = element.fnf_it_local_comment;
					}

					assets_details += '<tr><td>'+element.user_name+'</td><td>'+element.assets_name+'</td><td>'+element.serial_number+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td><td>'+it_local_return_date+'</td><td>'+fnf_it_doc+'</td><td>'+fnf_it_local_comment+'</td><td><input class="form-control" type="date" name="release_date[]" value="<?=date("Y-m-d")?>" required></td><td><div class="file_upload_style"><input class="form-control file_validation" type="file" name="doc_file[]" required></div></td><td><input class="form-control" type="text" name="fnf_return_comment[]" required></td><td><input style="width: 18px;height: auto!important;min-width: 18px;margin-left: 13px;" class="form-control" type="checkbox" name="is_release[]" value="'+element.id+'" required></td></tr>';
				});

				$('#procurement_fnf_model #user_assets_details').html(assets_details);
				$('#procurement_fnf_model #com_fnf').val(fnf_id);

				if(pstatus == 1){
					$('#procurement_fnf_model #com_fnf').hide();
					$('#procurement_fnf_model #assets_fnf_submit_btn').attr('disabled',false);
				}else{
					$('#procurement_fnf_model #com_fnf').show();
					$('#procurement_fnf_model #com_fnf').val(fnf_id);
					$('#procurement_fnf_model #assets_fnf_submit_btn').removeAttr('disabled');		
				}	
				
			}
			else {
				$('#procurement_fnf_model #user_assets_details').html(' ');

				if(pstatus == 1){
					$('#procurement_fnf_model #com_fnf').hide();
					$('#procurement_fnf_model #assets_fnf_submit_btn').attr('disabled',true);
				}else{
					$('#procurement_fnf_model #com_fnf').show();
					$('#procurement_fnf_model #com_fnf').val(fnf_id);
					$('#procurement_fnf_model #assets_fnf_submit_btn').removeAttr('disabled');					
				}
			}
			if (res.release_ast==true) {
				var assets_details_release = "";
				var fnf_doc = "";
				var fnf_it_doc = "";
				var it_local_return_date = '';
				var fnf_it_local_comment = '';
				var fnf_return_comment = '';
				$.each(res.datas_release,function(index,element)
				{
					if(element.fnf_doc!=null) fnf_doc = '<a href="<?=base_url()?>it_assets_import/fnf_doc/'+element.fnf_doc+'" target="_blank">View</a>';
					else fnf_doc = 'No Document Found';

					if(element.fnf_it_doc!=null) fnf_it_doc = '<a href="<?=base_url()?>it_assets_import/fnf_doc/'+element.fnf_it_doc+'" target="_blank">View</a>';
					else fnf_it_doc = 'No Document Found';

					if(element.fnf_it_local_return_date == null){
						it_local_return_date = '-';
					}else{
						it_local_return_date = element.fnf_it_local_return_date;
					}

					if(element.fnf_it_local_comment == null){
						fnf_it_local_comment = '-';
					}else{
						fnf_it_local_comment = element.fnf_it_local_comment;
					}

					if(element.fnf_return_comment == null){
						fnf_return_comment = '-';
					}else{
						fnf_return_comment = element.fnf_return_comment;
					}

					assets_details_release += '<tr><td>'+element.user_name+'</td><td>'+element.assets_name+'</td><td>'+element.serial_number+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td><td>'+it_local_return_date+'</td><td>'+fnf_it_doc+'</td><td>'+fnf_it_local_comment+'</td><td>'+element.return_date+'</td><td>'+fnf_doc+'</td><td>'+fnf_return_comment+'</td><td>'+element.return_by_name+'</td></tr>';
				});
				$('#procurement_fnf_model #user_assets_details_returned').html(assets_details_release);
			}
			else {
				$('#procurement_fnf_model #user_assets_details_returned').html('');
			}
		}
		else {
			alert(res.errmsg);
		}
	},request_url, datas, 'text');


	$('#procurement_fnf_model').modal('show');

	// var req_id=$(this).attr("value");
	// var req_number=$(this).attr("r_id");
	// var req_assets=$(this).attr("assets_name");
	// var req_total=$(this).attr("request_total");
	// var assets_id=$(this).attr("assets_id");
	// var location_name=$(this).attr("location_name");
	// $('#myModal_assets_movement_history_details #req_location').text(location_name);
	// $('#myModal_assets_movement_history_details .assets_name_hod').text(req_assets);
	// $('#myModal_assets_movement_history_details #req_id_hod').text(req_number);
	// var datas = {'req_id': req_id};
	// var request_url = "<?php echo base_url('dfr_it_assets/get_assets_movement_history'); ?>";
	// process_ajax(function(response)
	// {
	// 	var res = JSON.parse(response);
	// 	if (res.stat == true) {
	// 		var tr_details = ''; var c=1;
	// 		$.each(res.datas,function(index,element)
	// 		{
	// 			tr_details += '<tr><td>'+c+'</td><td>'+element.serial_number+'</td><td>'+element.reference_id+'</td><td>'+element.brand_name+'</td><td>'+element.configuration+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td></tr>';
	// 			c++;
	// 		});
	// 		$('#myModal_assets_movement_history_details #move_assets_history_tr').html(tr_details);
	// 	}
	// 	else {
	// 		alert('Something is wrong');
	// 	}
	// },request_url, datas, 'text');
	
});


$(document).on('click','.acceptance_fnf_save',function()
{
	var params=$(this).attr("extrapar");		
	var pstatus = $(this).attr("pstatus");
	var hrcomment = $(this).attr("hrcomment");
	$('#acceptance_fnf_model #hr_acceptance_comment').text(hrcomment);
	
	var arrPrams = params.split("#");

	var datas = {'user_id': arrPrams[0]};
	var fnf_id = arrPrams[2];

	var request_url = "<?php echo base_url('fnf/get_assest_assignment_details'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) {
			if (res.active_ast==true) {
				var assets_details = "";
				var fnf_it_doc = "";
				var it_local_return_date = '';
				var fnf_return_comment  = '';
				var fnf_it_local_comment = '';

				$.each(res.datas_active,function(index,element)
				{

					if(element.fnf_it_doc!=null) fnf_it_doc = '<a href="<?=base_url()?>it_assets_import/fnf_doc/'+element.fnf_it_doc+'" target="_blank">View</a>';
					else fnf_it_doc = 'No Document Found';

					if(element.fnf_it_local_return_date == null){
						it_local_return_date = '-';
					}else{
						it_local_return_date = element.fnf_it_local_return_date;
					}

					if(element.fnf_return_comment == null){
						fnf_return_comment = '-';
					}else{
						fnf_return_comment = element.fnf_return_comment;
					}

					if(element.fnf_it_local_comment == null){
						fnf_it_local_comment = '-';
					}else{
						fnf_it_local_comment = element.fnf_it_local_comment;
					}
					//alert(element.fnf_hr_status);
					if(element.fnf_hr_status != '1'){
						assets_details += '<tr><td>'+element.user_name+'</td><td>'+element.assets_name+'</td><td>'+element.serial_number+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td><td>'+it_local_return_date+'</td><td>'+fnf_it_doc+'</td><td>'+fnf_it_local_comment+'</td><td>'+fnf_return_comment+'</td><td><input class="form-control" type="date" name="hr_acceptance_date[]" value="<?=date("Y-m-d")?>" required></td><td><input style="width: 18px;height: auto!important;min-width: 18px;margin-left: 13px;" class="form-control" type="checkbox" name="is_hr_acceptance[]" value="'+element.id+'" required></td></tr>';
					}else{
						assets_details += '<tr><td>'+element.user_name+'</td><td>'+element.assets_name+'</td><td>'+element.serial_number+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td><td>'+it_local_return_date+'</td><td>'+fnf_it_doc+'</td><td>'+fnf_it_local_comment+'</td><td>'+element.fnf_hr+'</td><td>'+fnf_return_comment+'</td><td>Completed</td></tr>';
					}
					
				});

				$('#acceptance_fnf_model #user_assets_details').html(assets_details);
				$('#acceptance_fnf_model #hr_acceptance_com_fnf').val(fnf_id);

				if(pstatus == 1){
					$('#acceptance_fnf_model #hr_acceptance_com_fnf').hide();
					$('#acceptance_fnf_model #acceptance_fnf_submit_btn').attr('disabled','disabled');
					$('#acceptance_fnf_model #hr_acceptance_comment').attr('disabled','disabled');
				}else{
					$('#acceptance_fnf_model #hr_acceptance_com_fnf').show();
					$('#acceptance_fnf_model #hr_acceptance_com_fnf').val(fnf_id);
					$('#acceptance_fnf_model #acceptance_fnf_submit_btn').removeAttr('disabled');	
					$('#acceptance_fnf_model #hr_acceptance_comment').removeAttr('disabled');	
				}	
				
			}
			else {
				$('#acceptance_fnf_model #user_assets_details').html('');

				if(pstatus == 1){
					$('#acceptance_fnf_model #hr_acceptance_com_fnf').hide();
					$('#acceptance_fnf_model #acceptance_fnf_submit_btn').attr('disabled','disabled');
					$('#acceptance_fnf_model #hr_acceptance_comment').attr('disabled','disabled');
				}else{
					$('#acceptance_fnf_model #hr_acceptance_com_fnf').show();
					$('#acceptance_fnf_model #hr_acceptance_com_fnf').val(fnf_id);
					$('#acceptance_fnf_model #acceptance_fnf_submit_btn').removeAttr('disabled');
					$('#acceptance_fnf_model #hr_acceptance_comment').removeAttr('disabled');					
				}
			}
			
			if (res.release_ast==true) {
				var assets_details_release = "";
				var fnf_doc = "";
				var fnf_it_doc = "";
				var it_local_return_date = '';
				var fnf_it_local_comment = '';
				var fnf_return_comment = '';

				$.each(res.datas_release,function(index,element)
				{
					if(element.fnf_doc!=null) fnf_doc = '<a href="<?=base_url()?>it_assets_import/fnf_doc/'+element.fnf_doc+'" target="_blank">View</a>';
					else fnf_doc = 'No Document Found';

					if(element.fnf_it_doc!=null) fnf_it_doc = '<a href="<?=base_url()?>it_assets_import/fnf_doc/'+element.fnf_it_doc+'" target="_blank">View</a>';
					else fnf_it_doc = 'No Document Found';

					if(element.fnf_it_local_return_date == null){
						it_local_return_date = '-';
					}else{
						it_local_return_date = element.fnf_it_local_return_date;
					}

					if(element.fnf_it_local_comment == null){
						fnf_it_local_comment = '-';
					}else{
						fnf_it_local_comment = element.fnf_it_local_comment;
					}

					if(element.fnf_return_comment == null){
						fnf_return_comment = '-';
					}else{
						fnf_return_comment = element.fnf_return_comment;
					}

					

					assets_details_release += '<tr><td>'+element.user_name+'</td><td>'+element.assets_name+'</td><td>'+element.serial_number+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td><td>'+it_local_return_date+'</td><td>'+fnf_it_doc+'</td><td>'+fnf_it_local_comment+'</td><td>'+element.return_date+'</td><td>'+fnf_doc+'</td><td>'+fnf_return_comment+'</td><td>'+element.return_by_name+'</td></tr>';
				});
				$('#acceptance_fnf_model #user_assets_details_returned').html(assets_details_release);
			}
			else {
				$('#acceptance_fnf_model #user_assets_details_returned').html('');
			}
		}
		else {
			alert(res.errmsg);
		}
	},request_url, datas, 'text');
	$('#acceptance_fnf_model').modal('show');	
	
});



	
function isAccessReleaseLetter(office_id = "", brand = "")
{
	var ret = false;
	var ses_fusion_id = '<?php echo get_user_fusion_id(); ?>';
	var isAdmin = '<?php echo get_site_admin(); ?>';

	
	if ((isIndiaLocation(office_id) == false) || ((isIndiaLocation(office_id) == true) && (brand == 3))) {		
		ret = true;
	} else {
		var access_ids = ['FKOL015832','FKOL000003','FKOL010158','FKOL016266'];
		if (access_ids.includes(ses_fusion_id)) {
			ret = true;			
		}else{		
			ret = false;
		}
	}	

	return ret;
}


</script>


<script>

//////// Philippines FNF start //////////////////////////

	$(document).on('click','.philippines_fnf_hold_unhold',function(){

		baseURL = "<?php echo base_url(); ?>";
		let hold_type=$(this).attr("type_access");
		let fnf_id=$(this).attr("fnfID");
		let tab_name=$(this).attr("tab_name");
		let user_id =$(this).attr("user_id");

		if(hold_type=="hold"){ var conf = "Do you want to hold?"; }
		else { var conf = "Do you want to Unhold?"; }

		if (confirm(conf)) {

			if(fnf_id!="" && user_id!="" && hold_type!="" && tab_name!=""){
				$('#sktPleaseWait').modal('show');			

				var formData = {"user_id": user_id, "fnf_id": fnf_id, "tab_name": tab_name, "hold_type": hold_type};
				$.ajax({
					type	: 	'POST',    
					url		:	baseURL+'fnf/fnf_ph_hold_unhold_update',
					data	:	formData,
					//dataType:   "json",
					success	:	function(msg){
						$('#sktPleaseWait').modal('hide');
						//console.log(msg);
						get_list(tab_name);
						//location.reload();
					}
				});
			}else{
				alert("Something is wrong!");
			}
		}

	});

	$(document).on('click','.philippines_fnf_submit_form',function(){

		baseURL = "<?php echo base_url(); ?>";
		let fnf_id=$(this).attr("fnfID");
		let tab_name=$(this).attr("tab_name");
		let user_id =$(this).attr("user_id");

		let model_content = "";

		if (tab_name=="account_access_philip") {

			model_content = `<form id="ph_form_submit_data" onsubmit="return false" method='POST' enctype="multipart/form-data">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"> Complete Accounting Checklist FNF</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" name="user_id" value="`+user_id+`">
          <input type="hidden" class="form-control" name="fnf_id" value="`+fnf_id+`">
          <input type="hidden" class="form-control" id="tab_name"  name="tab_name" value="`+tab_name+`">

          <div class="row">

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Complied exit clearance forms <span style="color:red">*</span></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control ph_status_check" pos="div1" name="ph_account_status" required>
                    <option value="">-- Select --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">Not Applicable</option>
                  </select>
                </div>
                <div class="div1">


	            </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Remaining pro rated leave credits <span style="color:red">*</span></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control ph_status_check" pos="div2" name="ph_account_leave" required>
                    <option value="">-- Select --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">Not Applicable</option>
                  </select>
                </div>
                <div class="div2">


	            </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Payable Loans (Gov't or Savii billing) <span style="color:red">*</span></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control ph_status_check" pos="div3" name="ph_account_loans" required>
                    <option value="">-- Select --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">Not Applicable</option>
                  </select>
                </div>
               <div class="div3">


	            </div>
              </div>
            </div>
          </div>

          <hr /><br />

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Comments</label>
                <textarea class="form-control" name="account_comments"></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='ph_account_submit' class="btn btn-primary">Save</button>
        </div>

      </form>`;
		}


		if (tab_name=="facilities_access_philip") {

			model_content = `<form id="ph_form_submit_data" onsubmit="return false" method='POST' enctype="multipart/form-data">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"> Complete Facilities Checklist FNF</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" name="user_id" value="`+user_id+`">
          <input type="hidden" class="form-control" name="fnf_id" value="`+fnf_id+`">
          <input type="hidden" class="form-control" id="tab_name"  name="tab_name" value="`+tab_name+`">

          <div class="row">

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Locker <span style="color:red">*</span></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control ph_status_check" pos="div1" name="ph_facilities_locker" required>
                    <option value="">-- Select --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">Not Applicable</option>
                  </select>
                </div>
                <div class="div1">


	            </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Access Card Disablement <span style="color:red">*</span></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control ph_status_check" pos="div2" name="ph_facilities_card" required>
                    <option value="">-- Select --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">Not Applicable</option>
                  </select>
                </div>
                <div class="div2">


	            </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Keys <span style="color:red">*</span></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control ph_status_check" pos="div3" name="ph_facilities_keys" required>
                    <option value="">-- Select --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">Not Applicable</option>
                  </select>
                </div>
               <div class="div3">


	            </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Others <span style="color:red">*</span></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control ph_status_check" pos="div4" name="ph_facilities_others" required>
                    <option value="">-- Select --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">Not Applicable</option>
                  </select>
                </div>
                <div class="div4">


	            </div>
              </div>
            </div>

          </div>

          <hr /><br />

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Comments</label>
                <textarea class="form-control" name="facilities_comments"></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='ph_account_submit' class="btn btn-primary">Save</button>
        </div>

      </form>`;
		}


		if (tab_name=="hr_fnf") {

			model_content = `<form id="ph_form_submit_data" onsubmit="return false" method='POST' enctype="multipart/form-data">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"> Complete HR Checklist FNF</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" name="user_id" value="`+user_id+`">
          <input type="hidden" class="form-control" name="fnf_id" value="`+fnf_id+`">
          <input type="hidden" class="form-control" id="tab_name"  name="tab_name" value="`+tab_name+`">

          <div class="row">

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Company ID <span style="color:red">*</span></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control ph_status_check" pos="div1" name="ph_hr_com" required>
                    <option value="">-- Select --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">Not Applicable</option>
                  </select>
                </div>
                <div class="div1">


	            </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Lanyard <span style="color:red">*</span></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control ph_status_check" pos="div2" name="ph_hr_lanyard" required>
                    <option value="">-- Select --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">Not Applicable</option>
                  </select>
                </div>
                <div class="div2">


	            </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>HMO Card (principal & dependent/s) <span style="color:red">*</span></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control ph_status_check" pos="div3" name="ph_hr_hmo" required>
                    <option value="">-- Select --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    <option value="2">Not Applicable</option>
                  </select>
                </div>
               <div class="div3">


	            </div>
              </div>
            </div>


          </div>

          <hr /><br />

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Comments</label>
                <textarea class="form-control" name="ph_hr_comments"></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='ph_account_submit' class="btn btn-primary">Save</button>
        </div>

      </form>`;
		}





		$("#philippines_fnf_model .modal-content").html(model_content);
		$('#philippines_fnf_model').modal('show');

	});

$(document).on('change','#philippines_fnf_model .ph_status_check',function(){
	let find_att = '.'+$(this).attr("pos");
	let find_att2 = $(this).attr("pos");
	if($(this).val()=='1') {
		$("#philippines_fnf_model "+find_att).html(`
	                <div class="col-md-4">
	                  <input type="date" class="form-control datePicker" name="ph_disablement_date_`+find_att2+`" placeholder="Enter Disbalement Date" required>
	                </div>
	                <div class="col-md-5">
	                  <input type="file" class="form-control" name="ph_disablement_file_`+find_att2+`">
	                </div>`);
	}
	else {
		$("#philippines_fnf_model "+find_att).html("");
	}
});

$(document).on('submit','#philippines_fnf_model #ph_form_submit_data',function(e){
		e.preventDefault();

		$('#sktPleaseWait').modal('show');

    	var formData = new FormData(this);
    	var tab_name = $("#philippines_fnf_model #ph_form_submit_data #tab_name").val();

			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'fnf/ph_fnf_submit',
				data	:	formData,
		        cache: false,
		        contentType: false,
		        processData: false,
				success	:	function(msg){
					$('#sktPleaseWait').modal('hide');
					$('#philippines_fnf_model').modal('hide');
					//console.log(formData);
					get_list(tab_name);
					//location.reload();
				}
			});

});

//////
$(document).on('click','.philippines_fnf_submit_details',function(){

	let fnf_id=$(this).attr("fnfID");
	let tab_name=$(this).attr("tab_name");
	let user_id =$(this).attr("user_id");
	var request_url = "<?=base_url()?>fnf/get_philippines_fnf_details";
	var datas ={"user_id": user_id, "fnf_id": fnf_id, "tab_name": tab_name};

	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		var modal_content = "";
		var fnf_details = "";
		if (res.stat == true) 
		{
			var baseURL = "<?=base_url()?>";

			let fnf_status_1 = fnf_status_2 = fnf_status_3 = fnf_status_4 = "";
			let fnf_date_1 = fnf_date_2 = fnf_date_3 = fnf_date_4 = "";
			let fnf_files_1 = fnf_files_2 = fnf_files_3 = fnf_files_4 = "";

			if (tab_name=="account_access_philip") {

				fnf_details = `
				<p>Name(MWP ID): ${res.datas[0].full_name+'('+res.datas[0].fusion_id+')'}</p>
				<p>FNF By: ${res.datas[0].account_fnf_by}</p>
				<p>FNF Date: ${res.datas[0].ph_account_date}</p>
				<p>Comments: ${res.datas[0].ph_account_commnets}</p><br>
				`;

				if(res.datas[0].ph_account_clearance_form_status=="1") {
				 	fnf_status_1 = "Yes";
				 	fnf_date_1 = res.datas[0].ph_account_clearance_form_date;
				 	if(res.datas[0].ph_account_clearance_form_doc!=null) { fnf_files_1 = "<a target='_blank' href='"+baseURL+"uploads/fnf_philippines/"+res.datas[0].ph_account_clearance_form_doc+"'>View</a>"; }
				}
				else if(res.datas[0].ph_account_clearance_form_status=="2") { fnf_status_1 = "Not Applicable"; }
				else { fnf_status_1 = "No"; }

				/////////////////////

				if(res.datas[0].ph_account_credits_status=="1") {
				 	fnf_status_2 = "Yes";
				 	fnf_date_2 = res.datas[0].ph_account_credits_date;
				 	if(res.datas[0].ph_account_credits_doc!=null) { fnf_files_2 = "<a target='_blank' href='"+baseURL+"uploads/fnf_philippines/"+res.datas[0].ph_account_credits_doc+"'>View</a>"; }
				}
				else if(res.datas[0].ph_account_credits_status=="2") { fnf_status_2 = "Not Applicable"; }
				else { fnf_status_2 = "No"; }

				////////////////////////

				if(res.datas[0].ph_account_loan_status=="1") {
				 	fnf_status_3 = "Yes";
				 	fnf_date_3 = res.datas[0].ph_account_loan_date;
				 	if(res.datas[0].ph_account_loan_doc!=null) { fnf_files_3 = "<a target='_blank' href='"+baseURL+"uploads/fnf_philippines/"+res.datas[0].ph_account_loan_doc+"'>View</a>"; }
				}
				else if(res.datas[0].ph_account_credits_status=="2") { fnf_status_3 = "Not Applicable"; }
				else { fnf_status_3 = "No"; }

				modal_content = `
					<thead>
	                  <tr class='bg-info'>
	                    <th>FNF Name</th>
	                    <th>Status</th>
	                    <th>Date of Submission</th>
	                    <th>View Document</th>
	                  </tr>
	                </thead>
	                <tbody>
	                	<tr>
	                		<td>Complied exit clearance forms</td>
	                		<td>${fnf_status_1}</td>
	                		<td>${fnf_date_1}</td>
	                		<td>${fnf_files_1}</td>
	                	</tr>
	                	<tr>
	                		<td>Remaining pro rated leave credits</td>
	                		<td>${fnf_status_2}</td>
	                		<td>${fnf_date_2}</td>
	                		<td>${fnf_files_2}</td>
	                	</tr>
	                	<tr>
	                		<td>Payable Loans (Gov't or Savii billing)</td>
	                		<td>${fnf_status_3}</td>
	                		<td>${fnf_date_3}</td>
	                		<td>${fnf_files_3}</td>
	                	</tr>
	                </tbody>
				`;

			}

			if (tab_name=="facilities_access_philip") {

				fnf_details = `
				<p>Name(MWP ID): ${res.datas[0].full_name+'('+res.datas[0].fusion_id+')'}</p>
				<p>FNF By: ${res.datas[0].facilities_fnf_by}</p>
				<p>FNF Date: ${res.datas[0].ph_facilities_date}</p>
				<p>Comments: ${res.datas[0].ph_facilities_comments}</p><br>
				`;

				if(res.datas[0].ph_facilities_locker_status=="1") {
				 	fnf_status_1 = "Yes";
				 	fnf_date_1 = res.datas[0].ph_facilities_locker_date;
				 	if(res.datas[0].ph_facilities_locker_doc!=null) { fnf_files_1 = "<a target='_blank' href='"+baseURL+"uploads/fnf_philippines/"+res.datas[0].ph_facilities_locker_doc+"'>View</a>"; }
				}
				else if(res.datas[0].ph_facilities_locker_status=="2") { fnf_status_1 = "Not Applicable"; }
				else { fnf_status_1 = "No"; }

				/////////////////////

				if(res.datas[0].ph_facilities_card_status=="1") {
				 	fnf_status_2 = "Yes";
				 	fnf_date_2 = res.datas[0].ph_facilities_card_date;
				 	if(res.datas[0].ph_facilities_card_doc!=null) { fnf_files_2 = "<a target='_blank' href='"+baseURL+"uploads/fnf_philippines/"+res.datas[0].ph_facilities_card_doc+"'>View</a>"; }
				}
				else if(res.datas[0].ph_facilities_card_status=="2") { fnf_status_2 = "Not Applicable"; }
				else { fnf_status_2 = "No"; }

				////////////////////////

				if(res.datas[0].ph_facilities_keys_status=="1") {
				 	fnf_status_3 = "Yes";
				 	fnf_date_3 = res.datas[0].ph_facilities_keys_date;
				 	if(res.datas[0].ph_facilities_keys_doc!=null) { fnf_files_3 = "<a target='_blank' href='"+baseURL+"uploads/fnf_philippines/"+res.datas[0].ph_facilities_keys_doc+"'>View</a>"; }
				}
				else if(res.datas[0].ph_facilities_keys_status=="2") { fnf_status_3 = "Not Applicable"; }
				else { fnf_status_3 = "No"; }

				////////////////////////

				if(res.datas[0].ph_facilities_others_status=="1") {
				 	fnf_status_4 = "Yes";
				 	fnf_date_4 = res.datas[0].ph_facilities_others_date;
				 	if(res.datas[0].ph_facilities_others_doc!=null) { fnf_files_4 = "<a target='_blank' href='"+baseURL+"uploads/fnf_philippines/"+res.datas[0].ph_facilities_others_doc+"'>View</a>"; }
				}
				else if(res.datas[0].ph_facilities_others_status=="2") { fnf_status_4 = "Not Applicable"; }
				else { fnf_status_3 = "No"; }

				modal_content = `
					<thead>
	                  <tr class='bg-info'>
	                    <th>FNF Name</th>
	                    <th>Status</th>
	                    <th>Date of Submission</th>
	                    <th>View Document</th>
	                  </tr>
	                </thead>
	                <tbody>
	                	<tr>
	                		<td>Locker</td>
	                		<td>${fnf_status_1}</td>
	                		<td>${fnf_date_1}</td>
	                		<td>${fnf_files_1}</td>
	                	</tr>
	                	<tr>
	                		<td>Access Card Disablement</td>
	                		<td>${fnf_status_2}</td>
	                		<td>${fnf_date_2}</td>
	                		<td>${fnf_files_2}</td>
	                	</tr>
	                	<tr>
	                		<td>Keys</td>
	                		<td>${fnf_status_3}</td>
	                		<td>${fnf_date_3}</td>
	                		<td>${fnf_files_3}</td>
	                	</tr>
	                	<tr>
	                		<td>Others</td>
	                		<td>${fnf_status_4}</td>
	                		<td>${fnf_date_4}</td>
	                		<td>${fnf_files_4}</td>
	                	</tr>
	                </tbody>
				`;

			}

			if (tab_name=="hr_fnf") {

				fnf_details = `
				<p>Name(MWP ID): ${res.datas[0].full_name+'('+res.datas[0].fusion_id+')'}</p>
				<p>FNF By: ${res.datas[0].hr_fnf_by}</p>
				<p>FNF Date: ${res.datas[0].ph_hr_date}</p>
				<p>Comments: ${res.datas[0].ph_hr_comments}</p><br>
				`;

				if(res.datas[0].ph_hr_com_status=="1") {
				 	fnf_status_1 = "Yes";
				 	fnf_date_1 = res.datas[0].ph_hr_com_date;
				 	if(res.datas[0].ph_hr_com_doc!=null) { fnf_files_1 = "<a target='_blank' href='"+baseURL+"uploads/fnf_philippines/"+res.datas[0].ph_hr_com_doc+"'>View</a>"; }
				}
				else if(res.datas[0].ph_hr_com_status=="2") { fnf_status_1 = "Not Applicable"; }
				else { fnf_status_1 = "No"; }

				/////////////////////

				if(res.datas[0].ph_hr_lanyard_status=="1") {
				 	fnf_status_2 = "Yes";
				 	fnf_date_2 = res.datas[0].ph_hr_lanyard_date;
				 	if(res.datas[0].ph_hr_lanyard_doc!=null) { fnf_files_2 = "<a target='_blank' href='"+baseURL+"uploads/fnf_philippines/"+res.datas[0].ph_hr_lanyard_doc+"'>View</a>"; }
				}
				else if(res.datas[0].ph_hr_lanyard_status=="2") { fnf_status_2 = "Not Applicable"; }
				else { fnf_status_2 = "No"; }

				////////////////////////

				if(res.datas[0].ph_hr_hmo_status=="1") {
				 	fnf_status_3 = "Yes";
				 	fnf_date_3 = res.datas[0].ph_hr_hmo_date;
				 	if(res.datas[0].ph_hr_hmo_doc!=null) { fnf_files_3 = "<a target='_blank' href='"+baseURL+"uploads/fnf_philippines/"+res.datas[0].ph_hr_hmo_doc+"'>View</a>"; }
				}
				else if(res.datas[0].ph_hr_hmo_status=="2") { fnf_status_3 = "Not Applicable"; }
				else { fnf_status_3 = "No"; }

				modal_content = `
					<thead>
	                  <tr class='bg-info'>
	                    <th>FNF Name</th>
	                    <th>Status</th>
	                    <th>Date of Submission</th>
	                    <th>View Document</th>
	                  </tr>
	                </thead>
	                <tbody>
	                	<tr>
	                		<td>Company ID</td>
	                		<td>${fnf_status_1}</td>
	                		<td>${fnf_date_1}</td>
	                		<td>${fnf_files_1}</td>
	                	</tr>
	                	<tr>
	                		<td>Lanyard</td>
	                		<td>${fnf_status_2}</td>
	                		<td>${fnf_date_2}</td>
	                		<td>${fnf_files_2}</td>
	                	</tr>
	                	<tr>
	                		<td>HMO Card (principal & dependent/s)</td>
	                		<td>${fnf_status_3}</td>
	                		<td>${fnf_date_3}</td>
	                		<td>${fnf_files_3}</td>
	                	</tr>
	                </tbody>
				`;

			}



			$('#philippines_fnf_model_view .fnf_complete_details').html(modal_content);
			$('#philippines_fnf_model_view #fnf_details_head').html(fnf_details);
		}
		else {
			alert('No data found!');
			$('#philippines_fnf_model_view .fnf_complete_details').html("");
		}
						
	},request_url, datas, 'text');

	$('#philippines_fnf_model_view').modal('show');



});


</script>