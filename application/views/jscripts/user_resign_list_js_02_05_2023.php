<script>
	
	var resign_period_day=<?php echo $resign_period_day; ?>
	
	var timeOffset="-300";
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
	
	
	/* global setting */
    var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        minDate   : "D",
		maxDate   : "5D",
    }
	
	var datepickersOpt1 = {
		dateFormat: 'mm/dd/yy',
		//minDate   : "D",
	}

	var datepickersOpt2 = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        minDate   : "-15D",
		maxDate   : "5D",
    }
	
	$(document).ready(function(){
		
		var baseURL = "<?php echo base_url(); ?>";
		var location = "<?php echo get_user_office_id(); ?>";
	
		/* $("#resigndate").datepicker($.extend({
			onSelect: function() {
				var selDate = $(this).datepicker('getDate');
				selDate.setDate(selDate.getDate()+10); //add 10 days
				//alert(selDate);
				$('#releaseddate').val(js_mm_dd_yyyy(selDate));
				alert($("#user_id").val());
				
				   $.ajax({
					type	: 	'POST',    
					url		:	baseURL+'user/accepted_resign_user',
					data	:	$('form.frmUserAcceptedResign').serialize(),
					success	:	function(msg){
								console.log(msg);
								var test = jQuery.parseJSON(msg);
								alert(test.id);
							}
					});	
				   
				alert('resign_period_day');
			}
		},datepickersOpt)); */


	//Auto calculate release date on current date===============================

	var myDate_release = new Date(new Date().getTime()+(resign_period_day*24*60*60*1000));
	final_release = myDate_release.toISOString().slice(0, 10);
	$('#released_date').val(final_release);
		
		
	////////////////////////Approved Section//////////////////////////	
		
		//$("#releaseddate").datepicker(datepickersOpt1);
		//if(location == 'KOL' || location == 'HWH' || location == 'BLR'){
		// if(isIndiaLocation(location)==true){
		// 	//$("#releaseddate").datepicker({dateFormat: 'dd/mm/yy',minDate: new Date()});
		// 	$("#accepted_released_date").datepicker({dateFormat: 'dd/mm/yy'});
		// }else{
		// 	//$("#releaseddate").datepicker({dateFormat: 'mm/dd/yy',minDate: new Date()});
		// 	$("#accepted_released_date").datepicker({dateFormat: 'mm/dd/yy'});
		// }

		$(document).on('click','.userApprovedResign',function(){
			var user_id=$(this).attr("user_id");
			var rdate=$(this).attr("rdate");
			var noticeday=$(this).attr("noticeday");
			var resdate=$(this).attr("resdate");
			var reason=$(this).attr("r_reason");
			var remarks=$(this).attr("r_remarks");
			
			$('#user_id').val(user_id);
			
			var officeid=$(this).attr("oid");
			allOffice = '<option value="">-Select-</option><option value="0">0 Days</option><option value="15">15 Days</option><option value="30">30 Days</option><option value="90">90 Days</option>';
			casOffice = '<option value="">-Select-</option><option value="8">8 Days</option><option value="30">30 Days</option><option value="60">60 Days</option><option value="90">90 Days</option>';
			currentNotice = allOffice;
			if(officeid == 'CAS'){ currentNotice = casOffice; }
			$('.frmUserApprovedResign #is_notice').html(currentNotice);
			
			$('.frmUserApprovedResign #user_id').val(user_id);
			$('.frmUserApprovedResign #releaseddate').val(rdate);
			$('.frmUserApprovedResign #resigndate').val(resdate);
			$('.frmUserApprovedResign #sub_reason').val(reason);
			$('.frmUserApprovedResign #reason').val(remarks);
			$('.frmUserApprovedResign #is_notice').val(noticeday);

			$("#releaseddate").datepicker("destroy");
			if(isIndiaLocation(location)==true){
				$("#releaseddate").datepicker({dateFormat: 'dd/mm/yy',minDate: new Date(resdate)});
			}else{
				$("#releaseddate").datepicker({dateFormat: 'mm/dd/yy',minDate: new Date(resdate)});
			}			
			//$("#releaseddate").datepicker({dateFormat: 'mm/dd/yy',minDate: new Date(resdate)});

			$("#userApprovedResignModal").modal('show');
		});
		
		
		
		 $("#acceptedResignModal").click(function(){
			var user_id=$('.frmUserApprovedResign #user_id').val().trim();
			var releaseDate=$('.frmUserApprovedResign #releaseddate').val().trim();
			var approved_remarks=$('.frmUserApprovedResign #approved_remarks').val().trim();
			
			if(user_id!="" && approved_remarks!="" && releaseDate!="" && releaseDate!="00-00-0000"){
				$('#sktPleaseWait').modal('show');
				$.ajax({
					type	: 	'POST',    
					url		:	baseURL+'user_resign/approved_resign_user',
					data	:	$('form.frmUserApprovedResign').serialize(),
					success	:	function(msg){
								$('#sktPleaseWait').modal('hide');
								$('#userApprovedResignModal').modal('hide');
								location.reload();
							}
				});
			}else{
				alert("One or More field's are blank");
			}	
		});	
		
		$(".frmUserApprovedResign #is_notice").change(function(){
			initialdate = $('.frmUserApprovedResign #resigndate').val();
			totaldays = $(this).val();
			mydate = new Date(initialdate);
			newdate = mydate.addDays(Number(totaldays));
			  year = "" + newdate.getFullYear();
			  month = "" + (newdate.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
			  day = "" + newdate.getDate(); if (day.length == 1) { day = "0" + day; }
			  finaldate = day + "-" + month + "-"+ year; 
			$('.frmUserApprovedResign #releaseddate').val(finaldate);
		});
		
		
		
		$(".userDeclinedResign").click(function(){
			
			var user_id=$(this).attr("user_id");
			$('#user_id').val(user_id);
			$('.frmUserDeclineResign #user_id').val(user_id);
			$("#userDeclineResignModal").modal('show');
			
		});
		
		
		$("#declineResignModal").click(function(){
			var user_id=$('.frmUserDeclineResign #user_id').val().trim();
			var approved_remarks=$('.frmUserDeclineResign #approved_remarks').val().trim();
			
			if(user_id!="" && approved_remarks!=""){
				$('#sktPleaseWait').modal('show');
				$.ajax({
					type	: 	'POST',    
					url		:	baseURL+'user_resign/decline_resign_user',
					data	:	$('form.frmUserDeclineResign').serialize(),
					success	:	function(msg){
								$('#sktPleaseWait').modal('hide');
								$('#userDeclineResignModal').modal('hide');
								location.reload();
							}
				});
			}else{
				alert("One or More field's are blank");
			}	
		});
		
//////////////////Accept & Retain Resign (HR section)-16/08/2019//////////////////////	
		
			
		
			$(".termHRAccept").click(function(){
				var uid=$(this).attr("uid");
				var rdate=$(this).attr("rdate");
				var noticeday=$(this).attr("noticeday");
				var resdate=$(this).attr("resdate");
				var reason=$(this).attr("r_reason");
				var remarks=$(this).attr("r_remarks");
				var aremarks=$(this).attr("aremarks");
				var rehire=$(this).attr("rehire");
				var resign_id=$(this).attr("resid");
				
				var officeid=$(this).attr("oid");
				allOffice = '<option value="">-Select-</option><option value="0">0 Days</option><option value="15">15 Days</option><option value="30">30 Days</option><option value="90">90 Days</option>';
				casOffice = '<option value="">-Select-</option><option value="8">8 Days</option><option value="30">30 Days</option><option value="60">60 Days</option><option value="90">90 Days</option>';
				currentNotice = allOffice;
				if(officeid == 'CAS'){ currentNotice = casOffice; }
				$('.frmUserTermHRAccept #is_notice').html(currentNotice);
			
				$('.frmUserTermHRAccept #uid').val(uid);
				$('.frmUserTermHRAccept #resigndate').val(resdate);
				$('.frmUserTermHRAccept #sub_reason').val(reason);
				$('.frmUserTermHRAccept #reason').val(remarks);
				$('.frmUserTermHRAccept #is_notice').val(noticeday);
				$('.frmUserTermHRAccept #approved_remarks').val(aremarks);
				$('.frmUserTermHRAccept #is_rehire').val(rehire);
				$('.frmUserTermHRAccept #accepted_released_date').val(rdate);
				$('.frmUserTermHRAccept #resign_id').val(resign_id);

				$("#accepted_released_date").datepicker("destroy");
				if(isIndiaLocation(location)==true){
					$("#accepted_released_date").datepicker({
						dateFormat: 'dd/mm/yy', minDate: new Date(resdate),
						beforeShow: function (input, inst) {
				            var rect = input.getBoundingClientRect();
				            setTimeout(function () {
				            //Set your datepicker possition
				    	        inst.dpDiv.css({ top: rect.top - 200, left: rect.left + 0 });
				            }, 0);
				        }
					});
				}else{
					$("#accepted_released_date").datepicker({
						dateFormat: 'mm/dd/yy',
						 minDate: new Date(resdate),
						 beforeShow: function (input, inst) {
				            var rect = input.getBoundingClientRect();
				            setTimeout(function () {
				            //Set your datepicker possition
				    	        inst.dpDiv.css({ top: rect.top - 200, left: rect.left + 0 });
				            }, 0);
				        }
					});
				}

				$("#userTermHRAcceptModal").modal('show');
			});
			
			$("#userTermHRAccept").click(function(){
				var uid=$('.frmUserTermHRAccept #uid').val().trim();
				var apprvReleseDt=$('.frmUserTermHRAccept #accepted_released_date').val();
				var accepted_remarks=$('.frmUserTermHRAccept #accepted_remarks').val().trim();
				
				if(uid!="" && accepted_remarks!="" && apprvReleseDt!="" && apprvReleseDt!="00-00-0000"){
					$('#sktPleaseWait').modal('show');
					$.ajax({
						type	: 	'POST',    
						url		:	baseURL+'user_resign/accepted_resign_user',
						data	:	$('form.frmUserTermHRAccept').serialize(),
						success	:	function(msg){
									$('#sktPleaseWait').modal('hide');
									$('#userTermHRAcceptModal').modal('hide');
									location.reload();
								}
					});
				}else{
					alert("One or More field's are blank");
				}	
			});
			
			$(".frmUserTermHRAccept #is_notice").change(function(){
				initialdate = $('.frmUserTermHRAccept #resigndate').val();
				totaldays = $(this).val();
				mydate = new Date(initialdate);
				newdate = mydate.addDays(Number(totaldays));
				  year = "" + newdate.getFullYear();
				  month = "" + (newdate.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
				  day = "" + newdate.getDate(); if (day.length == 1) { day = "0" + day; }
				  finaldate = day + "-" + month + "-"+ year; 
				$('.frmUserTermHRAccept #accepted_released_date').val(finaldate);
			});
			
			
			$(".termHRRetain").click(function(){
				var uid=$(this).attr("uid");
				$('.frmUserTermHRretain #uid').val(uid);
				$("#userTermHRretainModal").modal('show');
			});
			
			$("#userTermHRretain").click(function(){
				var uid=$('.frmUserTermHRretain #uid').val().trim();
				var accepted_remarks=$('.frmUserTermHRretain #accepted_remarks').val().trim();
				
				if(uid!="" && accepted_remarks!=""){
					$('#sktPleaseWait').modal('show');
					$.ajax({
						type	: 	'POST',    
						url		:	baseURL+'user_resign/reject_resign_user',
						data	:	$('form.frmUserTermHRretain').serialize(),
						success	:	function(msg){
									$('#sktPleaseWait').modal('hide');
									$('#userTermHRretainModal').modal('hide');
									location.reload();
								}
					});
				}else{
					alert("One or More field's are blank");
				}	
			});

	////////////////////////////////////////////
		
/////////////Released Document /////////////
		$(".termReleased").click(function(){
			var uid=$(this).attr("uid");
			var acptdate=$(this).attr("acptdate");
			
			$('.frmUserTermReleaseDocu #uid').val(uid);
			$('.frmUserTermReleaseDocu #term_date').val(acptdate);
			
			$("#userTermReleaseModal").modal('show');
		});	
		
		
		$("#userTermandRelease").click(function(){
			var uid=$('.frmUserTermReleaseDocu #uid').val().trim();
			var term_date=$('.frmUserTermReleaseDocu #term_date').val().trim();
			var term_remarks=$('.frmUserTermReleaseDocu #term_remarks').val().trim();
			
			if(uid!="" && term_date!="" && term_remarks!=""){
				$('#sktPleaseWait').modal('show');
				$.ajax({
					type	: 	'POST',    
					url		:	baseURL+'user_resign/release_term',
					data	:	$('form.frmUserTermReleaseDocu').serialize(),
					success	:	function(msg){
							alert(msg);
								$('#sktPleaseWait').modal('hide');
								$('#userTermReleaseModal').modal('hide');
								location.reload();
							}
				});
			}
		});
		
	///////////////////////////////////////////////////////////////////
		
///////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////Resignation Part//////////////////////////////////////
///////////////////////////////////////////////////////////////////////////

		$("#resign_date").datepicker($.extend({
			onSelect: function() {
				var selDate = $(this).datepicker('getDate');
				selDate.setDate(selDate.getDate()+resign_period_day); //add period of days
				//alert(selDate);
				$('#released_date').val(js_mm_dd_yyyy(selDate));
			}
		},datepickersOpt2));
		
		
		
		
		$("#form_resign_user").submit(function (e) {
			$('#sktPleaseWait').modal('show');
			//$('#btn_save_row').hide();
		});
		
		
		$('.withdrawResign').click(function(){
			$('#userWithdrawResignModal input[name="resign_id"]').val('');
			$('#userWithdrawResignModal input[name="user_id"]').val('');			
			rid = $(this).attr('rid');
			uid = $(this).attr('uid');
			$('#userWithdrawResignModal input[name="resign_id"]').val(rid);
			$('#userWithdrawResignModal input[name="user_id"]').val(uid);
			$('#userWithdrawResignModal').modal('show');
		});
		
	});	
</script>
