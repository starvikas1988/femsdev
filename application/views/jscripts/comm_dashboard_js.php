<script type="text/javascript">

$(document).ready(function(){
    
	var baseURL="<?php echo base_url();?>";
	
	// $("#dept_id").change(function(){
	$(document).on('change','#dept_id',function()
	{
		var dept_id=$('#dept_id').val();
		populate_sub_dept_combo(dept_id,'','sub_dept_id','Y');
	});
	
	// $(".ncnsFinalTermsReq").click(function(){
	$(document).on('click','.ncnsFinalTermsReq',function()
	{
		//var today = new Date();
		//today.setHours(today.getHours()-9.5);
		//alert(today);
		
		var uid=$(this).attr("uid");
		$('#pTermUid').val(uid);
		
		var preRowId=$(this).attr("preRowId");
		$('#preRowId').val(preRowId);
		
		var URL=baseURL+'users/getLastDisposition';
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'uid='+uid,
		   success: function(ldDate){
				ldDate=ldDate.trim();
				$('#lastDispDt').val(ldDate);

				
				var URL=baseURL+'users/getPreTermUserInfo';
				//alert(URL);
				$('#sktPleaseWait').modal('show');
				
				$.ajax({
				   type: 'POST',    
				   url:URL,
				   data:'uid='+uid+'&preRowId='+preRowId,
				   success: function(msg){
							$('#sktPreTermModal').find('#div_pre_term_user_info').html(msg);		
							$('#sktPleaseWait').modal('hide');
							$('#sktPreTermModal').modal('show');
							
					},
					error: function(){
						alert('Fail!');
						$('#sktPleaseWait').modal('hide');
					}
					
				  });
				
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
		////
		
	});
	
	
	
	// $("#next_shift_time" ).change(function() {
	$(document).on('change','#next_shift_time',function()
	{
		var lastDispDt=$('#lastDispDt').val().trim();
		
		var next_shift_time=$('#next_shift_time').val().trim();
		
		var diffDays = getDateDiffDay(lastDispDt,next_shift_time);
		
		var nxtDate=new Date(next_shift_time);
		var term_dt= nxtDate.addHours(8);
		
		$('#terms_time').val(js_mm_dd_yyyy_hh_mm_ss(term_dt));
		
		//alert(diffDays);
		if(diffDays>1){
												
			$('#div_prevDispWithRO').show();
			var lbmsg="Agent Last Disposition is on "+lastDispDt;
			
			//alert(lastDispDt + ">"+next_shift_time);
			
			var dateStr = getDates(new Date(lastDispDt), new Date(next_shift_time));
			
			//alert(dateStr);
			$('#lb_PrevDispWithRO').text(lbmsg);
			
			var chkMsg="Status 'RO' for "+dateStr;
			$('#text_chk_prevDispWithRO').text(chkMsg);
			//$('#chk_prevDispWithRO').prop('checked', true);
			
			
						
		}else{
			
			//$('#chk_prevDispWithRO').prop('checked', false); 
			$('#div_prevDispWithRO').hide();
		}
	});
	
	
	
	
	// $("#updatePreTermReq").click(function(){
	$(document).on('click','#updatePreTermReq',function()
	{
	
		var uid=$('#pTermUid').val();
		var preRowId=$('#preRowId').val();
		
		var next_shift_time=$('#next_shift_time').val();
		var terms_time=$('#terms_time').val();
		
		if(next_shift_time!="" && terms_time!=""){
		
		var URL=baseURL+'users/updatePreTermUserInfo';
		
		//alert(URL);
		//alert(URL+"?"+$('form.frmPreTermReq').serialize());
		
		$('#sktPreTermModal').modal('hide');
		$('#sktPleaseWait').modal('show');
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:$('form.frmPreTermReq').serialize(),
		   success: function(msg){
					//alert(msg);
					$('#sktPleaseWait').modal('hide');
					location.reload();
			}
			,
			error: function(){
				//alert('Fail!');
			}
			
		  });
		  
		  }else{
			
			alert("One or more field(s) are blank. \r\nPlease fill the data");
			
		  }
		  
	});
	
	
	// $(".rejectPreTermsReq").click(function(){
	$(document).on('click','.rejectPreTermsReq',function()
	{
				
		var uid=$(this).attr("uid");	
		$('#rejPreTermUid').val(uid);
		
		var preRowId=$(this).attr("preRowId");
		
		$('#rejPreRowId').val(preRowId);
				
		$('#sktRejPreTermModal').modal('show');
		
	});
	
	
	// $("#updateRejPreTermReq").click(function(){
	$(document).on('click','#updateRejPreTermReq',function()
	{
		var uid=$('#rejPreTermUid').val();
		
		var action_desc=$('#action_desc').val();
				
		//alert(baseURL+'users/updateDisposition?'+$('form.editDisp').serialize());
		
		if(uid!=="" && action_desc!=""){
			
			$('#sktRejPreTermModal').modal('hide');
			$('#sktPleaseWait').modal('show');
			
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'users/rejectPreTermRequest',
			   data:$('form.frmRejPreTermReq').serialize(),
			   success: function(msg){
						//alert(msg);
						$('#sktPleaseWait').modal('hide');
						location.reload();
				}
				,
				error: function(){
					//alert('Fail!');
				}
				
			  });
			}else{
				alert("Please fill the remarks");
			}
	});
	
	
	
	
	// $(".editDisposition").click(function(){
	$(document).on('click','.editDisposition',function()
	{
		$('#div_schedule_data').hide();
		
		var uid=$(this).attr("uid");
		var disp_id=$(this).attr("disp_id");
		var cid = $(this).attr("cid");
		
		$('#uid').val(uid);
		$('#cid').val(cid);
		
		$('#event_master_id').val(disp_id);
		$('#div_end_date').hide();
		$('#div_request_type').hide();
		
		$( "#kterms_date" ).val("<?php echo CurrDateTimeMDY();?>");
		
		$('#sktModal').modal('show');
		
		//alert("UID="+uid + " atl:"+atl);
				
		var URL=baseURL+'users/get_last_lldate';
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'uid='+uid,
		   success: function(lldate){
				lldate=lldate.trim();
				var lldtArr = lldate.split("#") ;
				
				$( "#linDate" ).val(lldtArr[0]);
				$( "#loutDate" ).val(lldtArr[1]);
				
			},
			error: function(){	
			
			}
		  });
		  
	});
	
		
	
	// $("#event_master_id" ).change(function() {
	$(document).on('change','#event_master_id',function()
	{	
			var disp_id=$(this).val();
			//$('#start_date').attr('readonly', false);	
			$('#div_request_type').hide();
			
			var linDate = $('#linDate').val().trim();
			var loutDate = $('#loutDate').val().trim();
			
			
			
			if(disp_id=='4' || disp_id=='10' || disp_id=='11'){	
				$('#start_date').val(linDate);
				
			}else{
				$('#start_date').val("<?php echo CurrDateMDY();?>");
			}
			
			$('#updateDisp').removeAttr('disabled');
			
			if(disp_id=='19'){
				
				$('#div_schedule_data').show();
				
				var uid=$('#uid').val().trim();
				var start_date=$('#start_date').val().trim();
				
				//alert(uid + " >> "+ start_date);
				
				getUpdateScheduleInfo(uid,start_date);
				
			}else{
				$('#div_schedule_data').hide();
			}
			
			
			if(disp_id=='7'){
				
				$('#end_date').val("");
								
				$('#div_kterms_date').show();
				$('#div_term_type').show();
				$('#div_sub_term_type').show();
				
				$('#div_start_date').hide();
				$('#div_end_date').hide();
				$('#div_ticket_no').hide();
				$('#div_request_id').hide();
				
				$('#us_request_id').removeAttr('required');
				$('#us_ticket_no').removeAttr('required');
				$('#end_date').removeAttr('required');
				
			}else if(disp_id=='4'){
				
				//$('#start_date').attr('readonly', true);
				$('#end_date').val("");
				$('#div_request_type').show();

				$('#div_start_date').show();
				$('#div_end_date').show();
				
				$('#div_ticket_no').show();
				$('#div_request_id').show();
				
				$('#us_request_id').attr('required', 'required');		
				$('#us_ticket_no').attr('required', 'required');		
				$('#end_date').removeAttr('required');
				
				$('#div_kterms_date').hide();
				
				$('#lbl_start_date').text("Start Date (mm/dd/yyyy) i.e Last Login date of Agent");
				$('#lbl_end_date').text("Return Date (mm/dd/yyyy)");
				
				$('#div_term_type').hide();
				$('#div_sub_term_type').hide();
			
			}else if(disp_id=='10' || disp_id=='11'){
				
				
				$('#end_date').val("");
				$('#div_start_date').show();
				$('#div_end_date').show();
				
				$('#div_ticket_no').hide();
				$('#div_request_id').hide();
				$('#div_kterms_date').hide();
				
				$('#us_request_id').removeAttr('required');
				$('#us_ticket_no').removeAttr('required');
				
				$('#end_date').removeAttr('required');
				
				$('#lbl_start_date').text("Start Date (mm/dd/yyyy) i.e Last Login date of Agent");
				$('#lbl_end_date').text("Return Date (mm/dd/yyyy)");
				
				$('#div_term_type').hide();
				$('#div_sub_term_type').hide();
				
			}else if(disp_id=='12' || disp_id=='13'){
				
				
				$('#end_date').val("");
				$('#div_start_date').show();
				$('#div_end_date').show();
				
				$('#div_ticket_no').hide();
				$('#div_request_id').hide();
				$('#div_kterms_date').hide();
				
				$('#us_request_id').removeAttr('required');
				$('#us_ticket_no').removeAttr('required');
				
				$('#end_date').removeAttr('required');
				
				$('#lbl_start_date').text("Start Date (mm/dd/yyyy)");
				$('#lbl_end_date').text("Return Date (mm/dd/yyyy)");
				
				$('#div_term_type').hide();
				$('#div_sub_term_type').hide();
				
				
			}else if(disp_id=='9'){
				
				$('#end_date').val("");
								
				$('#div_start_date').show();
				$('#div_end_date').show();
				
				$('#div_ticket_no').show();
				$('#div_request_id').show();
				
				$('#us_request_id').attr('required', 'required');		
				$('#us_ticket_no').attr('required', 'required');		
				$('#end_date').attr('required', 'required');
				
				$('#div_kterms_date').hide();
				
				$('#lbl_start_date').text("Start Date (mm/dd/yyyy)");
				$('#lbl_end_date').text("Date of Return (mm/dd/yyyy)");
				
				$('#div_term_type').hide();
				$('#div_sub_term_type').hide();
				
			}else{
				$('#end_date').val("");
				
				$('#div_start_date').show();
				$('#div_ticket_no').show();
				
				$('#div_end_date').hide();
				$('#div_kterms_date').hide();
				
				$('#lbl_start_date').text("Date (mm/dd/yyyy)");
				$('#lbl_end_date').text("End Date (mm/dd/yyyy)");
				
				$('#div_term_type').hide();
				$('#div_sub_term_type').hide();
				$('#div_request_id').hide();
				
				$('#us_request_id').removeAttr('required');
				$('#us_ticket_no').removeAttr('required');
				$('#end_date').removeAttr('required');
				
			}	
			
		});
		
		
		
	
	// $("#updateDisp").click(function(){
	$(document).on('click','#updateDisp',function()
	{
		var totDays=0;
		
		
		var uid = $('#uid').val().trim();
		var cid = $('#cid').val().trim();
		
		var start_date=$('#start_date').val().trim();
		var end_date=$('#end_date').val().trim();
		
		var disp_id=$('#event_master_id').val().trim();
		var remarks=$('#remarks').val().trim();
		var t_type=$('#t_type').val().trim();
		var sub_t_type=$('#sub_t_type').val().trim();
		
		
		var request_id=$('#us_request_id').val().trim();
		var ticket_no=$('#us_ticket_no').val().trim();
		
		var request_type = $('#request_type').val().trim();
		
		var isRun = true;
		
		//alert(baseURL+'users/updateDisposition?'+$('form.editDisp').serialize());
							
		if(disp_id=='1'){
			
			isRun = false;
			alert("Please select proper disposition");	
			
		}else if(disp_id=='9' && end_date==""){
			isRun = false;
			alert("Fill Date of Return.");
		}else if(disp_id=='7' && t_type==""){
			
			isRun = false;
			alert("Fill the Term Type Options");
			
		}else if(disp_id=='7' && sub_t_type==""){
			isRun = false;
			alert("Fill Select Sub Termination Type.");
			
		}else if(disp_id=='7' && remarks==""){
			
			isRun = false;
			alert("Fill the comment fields");
								
		}else if(uid!="" && start_date!="" && disp_id!=""){
			
			if(disp_id=='4' || disp_id=='9' || disp_id=='10' || disp_id=='11'){
				totDays=getDateDiffDay(start_date,end_date);
			}
					
			
			if(cid == 1) {
			
				
				if((disp_id=='10' || disp_id=='11' || disp_id=='4') && totDays > 30){
					
					//$('#updateDisp').attr('disabled', 'disabled');
					
					isRun = false;
					alert("Agent Leave request is more than 30 days from the last login and its not possible to request for LOA/RTO. Kindly submit a deactivation/termination request in the portal");		
								
				}else if((disp_id=='10' || disp_id=='11') && totDays>15){
					isRun = false;
					alert("RTO not more than 15 days ");
				}else if(disp_id=='4' && request_type==""){
					isRun = false;
					alert("Please select LOA Request Type");
				}else if(disp_id=='4' && totDays<=15){
					isRun = false;
					alert("LOA should be more than 15 day."); 
				}else if(disp_id=='4' && totDays>=30){
					isRun = false;
					alert("LOA should be less than 30 day.");
				}else if( (disp_id=='4' || (disp_id=='9' && totDays>5)) && request_id==""){
					isRun = false;
					alert("Fill the Request ID.");
				}else if((disp_id=='4' || (disp_id=='9' && totDays>5)) && isValidRequestID(request_id)==false){
					isRun = false;
					alert("Enter valid Request ID.\r\nRequest ID should be start with REQ and followed by 7 digit");
				}else if((disp_id=='4' || (disp_id=='9' && totDays>5)) && ticket_no==""){
					isRun = false;
					alert("Fill the Ticket No.");
				}else if((disp_id=='4' || (disp_id=='9' && totDays>5)) && isValidTicketNo(ticket_no)==false){
					isRun = false;
					alert("Enter valid Ticket No. \r\n Ticket No. should be start with RITM  and followed by 7 digit");
				}
				
			}else if(cid == 6) {
				
				if(disp_id =='19' && ( remarks=="" || in_time=="" || out_time=="")  ){
					if (in_time=="") alert("Please fill the schedule in time");
					else if(out_time=="") alert("Please fill the schedule out time");
					else if(remarks=="") alert("Please fill the comment fields");
				}
			}
			
		}else{
			isRun = false;
			alert("One or more field(s) are blank. \r\nPlease fill the data");
		}
		
		
		if (isRun == true){
			
			var isCon=confirm('Are you sure to update the status?');
			if(isCon==true){
				
				$('#sktModal').modal('hide');
				$('#sktPleaseWait').modal('show');
				
								
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'users/updateDisposition',
				   data:$('form.editDisp').serialize(),
				   success: function(msg){
							
							//alert(msg);
							
							$('#sktPleaseWait').modal('hide');
							if(msg=="PRETREM") alert("User is in termination queue.");
							
							location.reload();
					}
					,
					error: function(){
						//alert('Fail!');
					}
					
				  });
	
			}
	  
		}
			
			
	});
	
	
	
	
	// $(".cancelTermination").click(function(){
	$(document).on('click','.cancelTermination',function()
	{
		var uid=$(this).attr("uid");	
		$('#ct_uid').val(uid);
		
		$('#cancelpopupModel').modal('show');
		 
	});
	
	// $("#btnCancelTermination").click(function(){
	$(document).on('click','#btnCancelTermination',function()
	{
		var uid = $('#ct_uid').val();
		var txtRem = $('#ct_update_remarks').val();	 
		//var ans=confirm('Are you sure to cancel the Termination?');
		
		//alert(baseURL+'users/cancelTermination?'+ $('form.frmCancelTermination').serialize())
		
		if(uid!="" && txtRem!=""){
			
			
			$('#cancelpopupModel').modal('hide');
			$('#sktPleaseWait').modal('show');
			
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'users/cancelTermination',
			   data:$('form.frmCancelTermination').serialize(),
			   success: function(msg){
				   $('#sktPleaseWait').modal('hide');
					//alert(msg);
					location.reload();
				},
				error: function(){
					alert('Fail!');
				}
			  });
		}
	});

	
	// $('.check_all').click(function () {
	$(document).on('click','.check_all',function()
	{
            if (this.checked) {

                $('.check_row').each(function () {
                    this.checked = true;
                });
            }

             else {
                $('.check_row').each(function () {
                    this.checked = false;
                }); 
             }  
        })
				
		// $("#combo_disposition" ).change(function() {
		$(document).on('change','#combo_disposition',function()
		{	
			var disp_id=$(this).val();
			var disp_txt=$(this).find("option:selected").text();
			
			var sel_uids=$('.check_row').serialize();
				sel_uids=sel_uids.replace(/sel_uids=/g, '');
				sel_uids=sel_uids.replace(/&/g, ',');
			
			var stdate='<?php echo CurrDate(); ?>';
			
			if(disp_id!="" && sel_uids!=""){
				
				var ans=confirm('Are you sure to change the disposition with '+ disp_txt+' on ' +stdate+'?');
				if(ans==true){
		
					$('#sktPleaseWait').modal('show');
					var params="uids="+sel_uids+"&disp_id="+disp_id;
					
					//alert(params);
					
					$.ajax({
						   type: 'POST',    
						   url:baseURL+'users/updateDispositionBulk',
						   data:params,
						   success: function(msg){
									//alert(msg);
									$('#sktPleaseWait').modal('hide');
									location.reload();
							},
							error: function(){
								//alert('Fail!');
							}
							
					});
				
			}
				
			}else{
				if(disp_id=="") alert("Select a Disposition");
				else if(sel_uids=="") alert("Please Select Agent(s)");
			}
			
			
			
		});
		
	//////
	
	// $(".termsUserOth").click(function(){
	$(document).on('click','.termsUserOth',function()
	{
		
		var uid=$(this).attr("uid");
		var doj=$(this).attr("doj");
		if(doj!=''){
			var tempDate = new Date(doj);
			doj = [tempDate.getMonth() + 1, tempDate.getDate(), tempDate.getFullYear()].join('/');
		}

		
		var URL=baseURL+'users/getLastLoginInfo';
		//alert(URL);	
		
		$('#sktPleaseWait').modal('show');
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'uid='+uid,
		   success: function(lwd){
			   
				lwd=lwd.trim();
				
				$('#lwd_oth').val(lwd);
				$('#tuid_oth').val(uid);
				
				$('#sktPleaseWait').modal('hide');
				$('#termsModalOth').modal('show');
				if( (new Date(lwd).getTime() < new Date(doj).getTime()))
				{
					$('.frmTermsUserOth #terminateUserOth').prop("disabled",true);
					setTimeout(function () {
						alert('Last working date can not be less than DOJ');
                 }, 1500);
				}
				
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  		
	});
	
	//=============== OLD TERMINATION WITHOUT CHECK BACKUP ========================================//
	/*	
	$("#terminateUserOth").click(function(){
		
		//alert(baseURL+'users/updateDisposition?'+$('form.frmTermsUserOth').serialize());
		
		var tuid=$('#tuid_oth').val();
		var terms_date=$('#terms_date_oth').val();
		var remarks=$('#remarks_oth').val();
		var t_type=$('#t_type_oth').val().trim();
		var sub_t_type=$('#sub_t_type_oth').val().trim();
		
		if(tuid!="" && terms_date!="" && t_type!="" && sub_t_type!="" && (remarks!="" || resign_remarks!="") ){
			
			var ans=confirm('Are you sure to terminate this user?');
			if(ans==true){
			
				$('#termsModalOth').modal('hide');
				$('#sktPleaseWait').modal('show');
				
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'users/updateDisposition',
				   data:$('form.frmTermsUserOth').serialize(),
				   success: function(msg){
							//alert(msg);
							$('#sktPleaseWait').modal('hide');
							
							if(msg=="PRETREM") alert("User is in termination queue.");
							
							location.reload();	
					}
				  });
			  }
			}else{
				alert("One or more field(s) are blank. \r\nPlease fill the data");
			}
	});
	
	*/
	
	
	// $("#terminateUserOth").click(function(){
	$(document).on('click','#terminateUserOth',function()
	{
		//alert(baseURL+'users/updateDisposition?'+$('form.frmTermsUserOth').serialize());
		
		var tuid=$('#tuid_oth').val();
		var terms_date=$('#terms_date_oth').val();
		var remarks=$('#remarks_oth').val();
		var t_type=$('#t_type_oth').val();
		var is_rehire=$('#is_rehire').val();
		var sub_t_type=$('#sub_t_type_oth').val();
		var lwd_oth=$('#lwd_oth').val();

		var term_type_new = $('#term_type_new').val();
		/*var t_type=$('#t_type_oth').val().trim();
		var is_rehire=$('#is_rehire').val().trim();
		var sub_t_type=$('#sub_t_type_oth').val().trim();*/
		
		var URL=baseURL+'users/checkDateOfJoining';
		postData = { uid : tuid, term_date : terms_date, lwd : lwd_oth }
		$.post(URL, postData, function(responseresult){
			console.log(responseresult);
			if(responseresult == "1" || responseresult == 1){
				if(tuid!="" && terms_date!="" && term_type_new!="" && t_type!="" && sub_t_type!="" && (remarks!="" || resign_remarks!="") && (is_rehire != "")){			
					var ans=confirm('Are you sure to terminate this user?');
					if(ans==true){
						console.log('Success');
						$('#termsModalOth').modal('hide');
						$('#sktPleaseWait').modal('show');
						
						$.ajax({
						   type: 'POST',    
						   url:baseURL+'users/updateDisposition',
						   data:$('form.frmTermsUserOth').serialize(),
						   success: function(msg){
								console.log(msg);
								$('#sktPleaseWait').modal('hide');									
								if(msg=="PRETREM") alert("User is in termination queue.");									
								location.reload();	
							}
						  });
						 
					  }
				}else{
					alert("One or more field(s) are blank. \r\nPlease fill the data");
				}
				
			} else {
				alert("LWD/Termination Date is Selected before the Joining Date or Date of Joining is Invalid!");
			}
		});
		
	});
	
	
	
	
	
	
///////////////////////////////

		$("#resign_comment").hide();
	
		// $("#t_type_oth").change(function(){
		$(document).on('change','#t_type_oth',function()
		{
			var t_type=$(this).val();
			if(t_type==9){
				$("#term_comment").hide();
				$("#resign_comment").show();
				$("#remarks_oth").prop("disabled", true);
				$("#resign_remarks").attr("required", true);
				$("#resign_remarks").prop("disabled", false);
			}else{
				$("#term_comment").show();
				$("#resign_comment").hide();
				$("#remarks_oth").prop("disabled", false);
				$("#resign_remarks").removeAttr("required", false);
				$("#resign_remarks").prop("disabled", true);
			}
		});
	
	
	//////////////////////////////
		
	// for Complete pre terminate users (NCNS)
	// $(".termsUser").click(function(){
	$(document).on('click','.termsUser',function()
	{	
		var uid=$(this).attr("uid");		
		$('#tuid').val(uid);
		var trm_tm=$(this).attr("trm_tm");		
		$('#terms_date').val(trm_tm);
		
		$('#termsModal').modal('show');
		
	});
	
	// for Complete pre terminate users (NCNS)	
	// $("#terminateUser").click(function(){
	$(document).on('click','#terminateUser',function()
	{
		//alert(baseURL+'admin/users/terminateUser?' + $('form.frmTermsUser').serialize());
		
		var tuid=$('#tuid').val();
		var terms_date=$('#terms_date').val();
		var ticket_no=$('#ticket_no').val();
		var ticket_date=$('#ticket_date').val();
		
		if(tuid!="" && terms_date!="" && ticket_no!="" && ticket_date!=""){
			
			var ans=confirm('Are you sure to terminate this user?');
			if(ans==true){
			
				$('#termsModal').modal('hide');
				$('#sktPleaseWait').modal('show');
				
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'users/terminateUser',
				   data:$('form.frmTermsUser').serialize(),
				   success: function(msg){
							//alert(msg);
							$('#sktPleaseWait').modal('hide');
							location.reload();
							
					}
				  });
			  }
			}else{
				alert("One or more field(s) are blank. \r\nPlease fill the data");
			}
	});
	
	
	// $(".completeKnownTerm").click(function(){
	$(document).on('click','.completeKnownTerm',function()
	{	
		var uid=$(this).attr("uid");
		var lwd=$(this).attr("lwd");
		var tremarks=$(this).attr("tremarks");
		
		$('#ut_uid').val(uid);
		$('#ut_lwd').val(lwd);
		
		$('#t_comments').val('');
		if(tremarks != "")
		{
			$('#t_comments').val(atob(tremarks));
		}
		
		$('#sktUdateTermModal').modal('show');
		
	});
	
	
	
	// $("#updateTerminateUser").click(function(){
	$(document).on('click','#updateTerminateUser',function()
	{
		//alert(baseURL+'admin/users/updateTerminateUser?'+$('form.frmUdateTerm').serialize());
		
		var tuid=$('#ut_uid').val();
		var ut_lwd=$('#ut_lwd').val();
		
		var ticket_no=$('#ut_ticket_no').val();
		var ticket_date=$('#ut_ticket_date').val();

		var pre_term_type_new = $('#pre_term_type_new').val();
		
		//if(tuid!="" && ticket_date!="" && ticket_no!=""){
			
		if(tuid!="" && ut_lwd!="" ){

			if(pre_term_type_new!="")
			{
			
				$('#sktUdateTermModal').modal('hide');
				$('#sktPleaseWait').modal('show');
				
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'users/updateTerminateUser',
				   data:$('form.frmUdateTerm').serialize(),
				   success: function(msg){
							//alert(msg);
							$('#sktPleaseWait').modal('hide');
							location.reload();
							
					}
				  });

			}
			else{
				alert('Please Select Termination Type');
			}
			  
			}else{
				alert("Last Working Date is blank. \r\nPlease fill the data");
			}
	});
	
	

	// $("#fclient_id").change(function(){
	$(document).on('change','#fclient_id',function()
	{
		var client_id=$(this).val();

		var rid=$.cookie('role_id'); 
		var dept_folder = $.cookie('dept_folder'); 
		
		if(rid<=1 || rid==6 || dept_folder=="hr"){
		
			if(client_id=="1"){
				$("#foffice_div").hide();
				$("#fsite_div").show();
				$("#foffice_id").val('ALL');
				
			}else{
				$("#fsite_div").hide();
				$("#foffice_div").show();
				$("#fsite_id").val('ALL');
			}
		}
		
		populate_process_combo(client_id,'','fprocess_id','Y');
		
	});
	
	// $("#fprocess_id").change(function(){
	$(document).on('change','#fprocess_id',function()
	{
				
		var pid=$(this).val();

		populate_sub_process_combo(pid,'','fsub_process_id','Y');
		
	});
	
	
	
	
	// $(".cancelSuspension").click(function(){
	$(document).on('click','.cancelSuspension',function()
	{
	
		var uid=$(this).attr("uid");		
		$('#csuid').val(uid);
		$('#sktSuspensionModal').modal('show');
		
		var fromdt=new Date($(this).attr("fromdt"));
		var todt=new Date($(this).attr("todt"));
		
		
		
		$('#final_return_date').datepicker('option', 'minDate', fromdt.toLocaleString());
		//$('#final_return_date').datepicker('option', 'maxDate', todt.toLocaleString());
		
		
	});
	
	
	// $("#btnCancelSuspension").click(function(){
	$(document).on('click','#btnCancelSuspension',function()
	{	
		//alert(baseURL+'user/cancelSuspension?'+$('form.frmSuspensionReq').serialize());
		
		var csuid=$('#csuid').val();
		var final_return_date=$('#final_return_date').val();
		var update_comments=$('#update_comments').val();
		
		
		if(csuid!="" && final_return_date!="" && update_comments!="" ){
			
				$('#sktSuspensionModal').modal('hide');
				$('#sktPleaseWait').modal('show');
				
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'users/cancelSuspension',
				   data:$('form.frmSuspensionReq').serialize(),
				   success: function(msg){
							//alert(msg);
							$('#sktPleaseWait').modal('hide');
							location.reload();
					}
				  });
			  
			}else{
				alert("One or more field(s) are blank. \r\nPlease fill the data");
			}
	});
	
	
	
	
});

  $(function() {
    
	
	var timeOffset="-300";
	
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
	
	
	var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        maxDate   : new Date()
    }
	
	$("#final_return_date").datepicker($.extend({},datepickersOpt));
	
	$("#lwd_oth").datepicker($.extend({},datepickersOpt));
	$("#ut_lwd").datepicker($.extend({},datepickersOpt));
	
	$( "#start_date" ).datepicker(
		{
			dateFormat: "mm/dd/yy",
			timezone: timeOffset,
			maxDate   : new Date(),
			onSelect: function(){
				$('#end_date').val('');
				$('#end_date').datepicker('option', 'minDate', $("#start_date").datepicker("getDate"));
				
				var uid=$('#uid').val().trim();
				var start_date=$('#start_date').val().trim();
				
				//alert(uid + " >> "+ start_date);
				
				getUpdateScheduleInfo(uid,start_date);
				
			}
		}
	).datepicker( "setDate", "<?php echo CurrDateMDY();?>" );
	
    	
	
	$( "#end_date" ).datepicker(
		{
			dateFormat: "mm/dd/yy",
			//timezone: timeOffset
		}
	);

	$("#next_shift_time").datetimepicker(
		{
			dateFormat: "mm/dd/yy",
			timeFormat: "HH:mm",
			//timezone: timeOffset
		}
	);
	
	//$( "#next_shift_time" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));
	
	$( "#terms_time" ).datetimepicker(
		{
			dateFormat: "mm/dd/yy",
			timeFormat: "HH:mm",
			//timezone: timeOffset
		}
	);
	
	//$( "#terms_time" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));
	$( "#terms_time" ).datetimepicker('setDate', (new Date()));
	
	//$( "#kterms_date" ).datetimepicker();
	//$( "#kterms_date" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));	
	//$( "#terms_date" ).datetimepicker();
	$( "#terms_date" ).datetimepicker('setDate', (new Date()));
	
	$( "#ticket_date" ).datetimepicker(
		{
			dateFormat: "mm/dd/yy",
			timeFormat: "HH:mm",
			//timezone: timeOffset
		}
	);
	//$( "#ticket_date" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));
	
	$( "#ut_ticket_date" ).datetimepicker(
		{
			dateFormat: "mm/dd/yy",
			timeFormat: "HH:mm",
			//timezone: timeOffset
		}
	);
	
	//$( "#ut_ticket_date" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));
			
	$( "#terms_date_oth" ).datetimepicker(
		{
			dateFormat: "mm/dd/yy",
			timeFormat: "HH:mm",
			maxDate   : new Date()
		}
	);
	
		
  });
  

  $.fn.dataTable.ext.errMode = 'none';


</script>

<script>
    $(function () {
        $('#multiselect').multiselect();
        $('#foffice_id').multiselect({
            includeSelectAllOption: false,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
			numberDisplayed: 1,
            filterPlaceholder: 'Search for something...',
            onChange: function() {
                var foffice_id=$('#foffice_id').val();

				if(jQuery.inArray("ALL", foffice_id) !== -1){
					$("#foffice_id").multiselect("clearSelection");
					$('#foffice_id').multiselect('select', ['ALL']);
					$('.open input[value!="ALL"]').attr("disabled", true);
				}else{
					$('.open input[value!="ALL"]').removeAttr("disabled");
				}
            }
        });
    });</script>



    <script>
    $(function () {
        $('#multiselect').multiselect();
        $('#dept_id').multiselect({
            includeSelectAllOption: false,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
			numberDisplayed: 1,
            filterPlaceholder: 'Search for something...',
            onChange: function() {
                var dept_id=$('#dept_id').val();

				if(jQuery.inArray("ALL", dept_id) !== -1){
					$("#dept_id").multiselect("clearSelection");
					$('#dept_id').multiselect('select', ['ALL']);
					$('.open input[value!="ALL"]').attr("disabled", true);
				}else{
					$('.open input[value!="ALL"]').removeAttr("disabled");
				}
            }


        });
    });</script>

    <script>
    $(function () {
        $('#multiselect').multiselect();
        $('#sub_dept_id').multiselect({
            includeSelectAllOption: false,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
			numberDisplayed: 1,
            filterPlaceholder: 'Search for something...',
            onChange: function() {
                var sub_dept_id=$('#sub_dept_id').val();

				if(jQuery.inArray("ALL", sub_dept_id) !== -1){
					$("#sub_dept_id").multiselect("clearSelection");
					$('#sub_dept_id').multiselect('select', ['ALL']);
					$('.open input[value!="ALL"]').attr("disabled", true);
				}else{
					$('.open input[value!="ALL"]').removeAttr("disabled");
				}
            }
        });
    });</script>

  <script>
    $(function () {
        $('#multiselect').multiselect();
        $('#fclient_id').multiselect({
            includeSelectAllOption: false,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
			numberDisplayed: 1,
            filterPlaceholder: 'Search for something...',
            onChange: function() {
                var fclient_id=$('#fclient_id').val();

				if(jQuery.inArray("ALL", fclient_id) !== -1){
					$("#fclient_id").multiselect("clearSelection");
					$('#fclient_id').multiselect('select', ['ALL']);
					$('.open input[value!="ALL"]').attr("disabled", true);
				}else{
					$('.open input[value!="ALL"]').removeAttr("disabled");
				}
            }
        });
    });</script>


    <script>
   		$(function () {
	        $('#multiselect').multiselect();
	        $('#fprocess_id').multiselect({
	            includeSelectAllOption: false,
	            enableFiltering: true,
	            enableCaseInsensitiveFiltering: true,
				numberDisplayed: 1,
	            filterPlaceholder: 'Search for something...',
	            onChange: function() {
	                var fprocess_id=$('#fprocess_id').val();

					if(jQuery.inArray("ALL", fprocess_id) !== -1){
						$("#fprocess_id").multiselect("clearSelection");
						$('#fprocess_id').multiselect('select', ['ALL']);
						$('.open input[value!="ALL"]').attr("disabled", true);
					}else{
						$('.open input[value!="ALL"]').removeAttr("disabled");
					}
	            }
	        });
	    });
	</script>


	<script>
   		$(function () {
	        $('#multiselect').multiselect();
	        $('#process_id').multiselect({
	            includeSelectAllOption: false,
	            enableFiltering: true,
	            enableCaseInsensitiveFiltering: true,
				numberDisplayed: 1,
	            filterPlaceholder: 'Search for something...',
				
	            onChange: function() {
	                var process_id=$('#process_id').val();

					if(jQuery.inArray("ALL", process_id) !== -1){
						$("#process_id").multiselect("clearSelection");
						$('#process_id').multiselect('select', ['ALL']);
						$('.open input[value!="ALL"]').attr("disabled", true);
					}else{
						$('.open input[value!="ALL"]').removeAttr("disabled");
					}
	            }
	        });
	    });
	</script>


	<script>
   		$(function () {
	        $('#multiselect').multiselect();
	        $('#fsub_process_id').multiselect({
	            includeSelectAllOption: false,
	            enableFiltering: true,
	            enableCaseInsensitiveFiltering: true,
				numberDisplayed: 1,
	            filterPlaceholder: 'Search for something...',
	            onChange: function() {
	                var fsub_process_id=$('#fsub_process_id').val();

					if(jQuery.inArray("ALL", fsub_process_id) !== -1){
						$("#fsub_process_id").multiselect("clearSelection");
						$('#fsub_process_id').multiselect('select', ['ALL']);
						$('.open input[value!="ALL"]').attr("disabled", true);
					}else{
						$('.open input[value!="ALL"]').removeAttr("disabled");
					}
	            }
	        });
	    });
	</script>

	<script>
   		$(function () {
	        $('#multiselect').multiselect();
	        $('#assigned_to').multiselect({
	            includeSelectAllOption: false,
	            enableFiltering: true,
	            enableCaseInsensitiveFiltering: true,
				numberDisplayed: 0,
	            filterPlaceholder: 'Search for something...',
	            onChange: function() {
	                var assigned_to=$('#assigned_to').val();

					if(jQuery.inArray("ALL", assigned_to) !== -1){
						$("#assigned_to").multiselect("clearSelection");
						$('#assigned_to').multiselect('select', ['ALL']);
						$('.open input[value!="ALL"]').attr("disabled", true);
					}else{
						$('.open input[value!="ALL"]').removeAttr("disabled");
					}
	            }
	        });
	    });
	</script>

