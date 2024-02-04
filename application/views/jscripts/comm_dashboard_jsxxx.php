<script type="text/javascript">

$(document).ready(function(){
    
	var baseURL="<?php echo base_url();?>";
	
	$(".ncnsFinalTermsReq").click(function(){
		
		//var today = new Date();
		//today.setHours(today.getHours()-9.5);
		//alert(today);
		
		var uid=$(this).attr("uid");
		$('#pTermUid').val(uid);
		
		var preRowId=$(this).attr("preRowId");
		$('#preRowId').val(preRowId);
		
		
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
		  
		
	});
	
	
	$("#updatePreTermReq").click(function(){
	
		var uid=$('#pTermUid').val();
		var preRowId=$('#preRowId').val();
		
		var next_shift_time=$('#next_shift_time').val();
		var terms_time=$('#terms_time').val();
		
		if(next_shift_time!="" && terms_time!=""){
		
		var URL=baseURL+'users/updatePreTermUserInfo';
		//alert(URL);
		//alert($('form.frmPreTermReq').serialize());
		
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
	
	
	$(".rejectPreTermsReq").click(function(){
		
				
		var uid=$(this).attr("uid");	
		$('#rejPreTermUid').val(uid);
		
		var preRowId=$(this).attr("preRowId");
		
		$('#rejPreRowId').val(preRowId);
				
		$('#sktRejPreTermModal').modal('show');
		
	});
	
	
	$("#updateRejPreTermReq").click(function(){
	
		var uid=$('#rejPreTermUid').val();
		
		var action_desc=$('#action_desc').val();
				
		//alert(baseURL+'tl/users/updateDisposition?'+$('form.editDisp').serialize());
		
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
	
	
	
	
	$(".editDisposition").click(function(){
		
		var today = new Date();
		today.setHours(today.getHours()-9.5);
		
		//alert(today);
		
		var uid=$(this).attr("uid");
		var disp_id=$(this).attr("disp_id");
		
		$('#uid').val(uid);
		$('#event_master_id').val(disp_id);
		
		$( "#kterms_date" ).val("<?php echo CurrDateTimeMDY();?>");
		
		$('#sktModal').modal('show');
		
		//alert("UID="+uid + " atl:"+atl);
		
	});
	
	
	
	
	
	$("#event_master_id" ).change(function() {
			
			
			
			var disp_id=$(this).val();
			
			if(disp_id=='7'){
			
				$('#div_kterms_date').show();
				$('#div_start_date').hide();
				$('#div_end_date').hide();
				$('#div_ticket_no').hide();
				
			}else{
				$('#div_start_date').show();
				$('#div_end_date').show();
				$('#div_ticket_no').show();
				$('#div_kterms_date').hide();
			}	
			
		});
		
	
	$("#updateDisp").click(function(){
	
		var uid=$('#suid').val();
		var start_date=$('#start_date').val();
		var disp_id=$('#event_master_id').val();
		
		//alert(baseURL+'tl/users/updateDisposition?'+$('form.editDisp').serialize());
		
		if(start_date!=="" && disp_id!=""){
			
			$('#sktModal').modal('hide');
			$('#sktPleaseWait').modal('show');
			
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'tl/users/updateDisposition',
			   data:$('form.editDisp').serialize(),
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
			
	
	$('.check_all').click(function () {
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
				
		$("#combo_disposition" ).change(function() {
			
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
						   url:baseURL+'tl/users/updateDispositionBulk',
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
		
		
		
	
	$(".termsUser").click(function(){
	
		var uid=$(this).attr("uid");		
		$('#tuid').val(uid);
		
		$('#termsModal').modal('show');
		
	});
		
	
	$("#terminateUser").click(function(){
		
		//alert($('form.frmTermsUser').serialize());
		
		var tuid=$('#tuid').val();
		var terms_date=$('#terms_date').val();
		var ticket_no=$('#ticket_no').val();
		
		if(tuid!="" && terms_date!="" && ticket_no!=""){
			
			var ans=confirm('Are you sure to terminate this user?');
			if(ans==true){
			
				$('#termsModal').modal('hide');
				$('#sktPleaseWait').modal('show');
				
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'admin/users/terminateUser',
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
	
	
	$(".completeKnownTerm").click(function(){
	
		var uid=$(this).attr("uid");		
		$('#ut_uid').val(uid);
		
		$('#sktUdateTermModal').modal('show');
		
	});
	
	
	
	$("#updateTerminateUser").click(function(){
		
		//alert(baseURL+'admin/users/updateTerminateUser?'+$('form.frmUdateTerm').serialize());
		
		var tuid=$('#ut_uid').val();
		var ticket_no=$('#ut_ticket_no').val();
		var ticket_date=$('#ut_ticket_date').val();
		
		if(tuid!="" && ticket_date!="" && ticket_no!=""){
			
				$('#sktUdateTermModal').modal('hide');
				
				$('#sktPleaseWait').modal('show');
				
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'admin/users/updateTerminateUser',
				   data:$('form.frmUdateTerm').serialize(),
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

  $( function() {
    
    $( "#start_date" ).datepicker();
	$('#start_date').datepicker( "setDate", "<?php echo CurrDateMDY();?>" );
	
	$( "#end_date" ).datepicker();
	
	$( "#next_shift_time" ).datetimepicker(
		{
		timeFormat: 'HH:mm z',
		timezoneList: [ 
				{ value: -240, label: 'EDT'}, 
				{ value: -300, label: 'EST' }
			]
		}
	);
	$( "#next_shift_time" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));
	
	$( "#terms_time" ).datetimepicker(
		{
		timeFormat: 'HH:mm z',
		timezoneList: [ 
				{ value: -240, label: 'EDT'}, 
				{ value: -300, label: 'EST' }
			]
		}
	);
	$( "#terms_time" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));
	
	/*	
	$( "#kterms_date" ).datetimepicker(
		{
		timeFormat: 'HH:mm z',
		timezoneList: [ 
				{ value: -240, label: 'EDT'}, 
				{ value: -300, label: 'EST' }
			]
		}
	);
	*/
	//$( "#kterms_date" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));
	
	$( "#terms_date" ).datetimepicker(
		{
		timeFormat: 'HH:mm z',
		timezoneList: [ 
				{ value: -240, label: 'EDT'}, 
				{ value: -300, label: 'EST' }
			]
		}
	);
	$( "#terms_date" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));
		
	$( "#ticket_date" ).datetimepicker(
		{
		timeFormat: 'HH:mm z',
		timezoneList: [ 
				{ value: -240, label: 'EDT'}, 
				{ value: -300, label: 'EST' }
			]
		}
	);
	$( "#ticket_date" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));
	
	$( "#ut_ticket_date" ).datetimepicker(
		{
		timeFormat: 'HH:mm z',
		timezoneList: [ 
				{ value: -240, label: 'EDT'}, 
				{ value: -300, label: 'EST' }
			]
		}
	);
	$( "#ut_ticket_date" ).datetimepicker('setDate', (new Date("<?php echo CurrDateTimeMDY();?>")));
	
  });
 
 
</script>

