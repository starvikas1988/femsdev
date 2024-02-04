

<script type="text/javascript" src="<?php echo base_url(); ?>assets/daterangepicker/daterangepicker.js"></script>

<?php if(!empty($show_editor) && $show_editor == 1){ ?>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<?php } ?>

<?php if(!empty($show_table) && $show_table == 1){ ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
<?php } ?>
<!--start data table library here-->
<script src="<?php echo base_url()?>assets/legal/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/buttons.bootstrap5.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/jszip.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/vfs_fonts.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/buttons.colVis.min.js"></script>


<script>
	$(".filterType").change(function(){
	// alert(2);
	
	curVal = $(this).val();
	if(curVal == 'date'){
		$('.dateInfo').show();
		$('.monthInfo').hide();
	} else {
		$('.dateInfo').hide();
		$('.monthInfo').show();
	}
});
$(document).ready(function(){
	// alert(55);
	
	
	$('.activateEmailVerify').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		eidVal = $(this).attr('eid');
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('legal/verify_email_login'); ?>",
			type: "GET",
			data: { eid : eidVal },
			dataType: "text",
			success : function(token){
				$('#sktPleaseWait').modal('hide');		
				$('#modalVerifyEmail .modalBodyLEGALDesc').html(token);
				$('#modalVerifyEmail').modal('show');
			},
			error : function(token){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	});

	$('.updateEmailMessages').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		eidVal = $(this).attr('bURL');
		// alert(eidVal);
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: eidVal,
			type: "GET",
			// data: { eid : eidVal },
			dataType: "text",
			success : function(token){
				console.log(token);
				$('#sktPleaseWait').modal('hide');		
				$('#modalCronEmailMessage .modalBodyCronMessage').html(token);
				$('#modalCronEmailMessage').modal('show');
			},
			error : function(token){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	});

	$('.agentWidget').on('change', 'select[name="office_id"],select[name="client_id"],select[name="process_id"],select[name="role_type"]', function(){
		pid = $('.agentWidget select[name="process_id"]').val();
		cid = $('.agentWidget select[name="client_id"]').val();
		oid = $('.agentWidget select[name="office_id"]').val();
		tid = $('.agentWidget select[name="role_type"]').val();
		if(pid == "" || cid == "" || oid == "" || tid == ""){
			
		} else {
		
		$('#sktPleaseWait').modal('show');			
		$.ajax({
			url: "<?php echo base_url('legal/master_agent_ajax'); ?>",
			type: "GET",
			data: { cid : cid, pid : pid, oid : oid, tid: tid },
			dataType: "json",
			success : function(json_obj){
						
				var html = '';
				for (var i in json_obj){
					html += '<tr><td><input type="checkbox" name="userCheckBox[]" value="'+json_obj[i].id+'"></td><td>'+json_obj[i].full_name +'</td><td>'+json_obj[i].fusion_id+'</td><td>'+json_obj[i].department+'</td><td>'+json_obj[i].designation+'</td></tr>';
				}
				//datatable_refresh('.agentWidget #default-datatable', 1);
				$('.agentWidget #allUserCheckTableList').html(html);
				//datatable_refresh('.agentWidget #default-datatable');
				$('#sktPleaseWait').modal('hide');	
			},
			error : function(json_obj){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
		}
	});

	$('.agentWidget').on('change', 'select[name="client_id"]', function(){
		// alert('abcd');
		cid = $('.agentWidget select[name="client_id"]').val();			
		$.ajax({
			url: "<?php echo base_url('legal/master_process_ajax'); ?>",
			type: "GET",
			data: { cid : cid },
			dataType: "json",
			success : function(json_obj){	
				var html = '<option value="">-- Select Process --</option>';
				for (var i in json_obj){
					html += '<option value="'+json_obj[i].id+'">'+json_obj[i].name +'</option>';
				}
				$('.agentWidget select[name="process_id"]').html(html);
			},
			error : function(json_obj){
				alert('Something Went Wrong!');
			}
		});
	});

	$('.editMasterMailSettings').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		eidVal = $(this).attr('eid');
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('legal/master_email_ajax'); ?>",
			type: "GET",
			data: { eid : eidVal },
			dataType: "json",
			success : function(token){
				$('#sktPleaseWait').modal('hide');
				$('#frmUpdateEmailSettings input[name="edit_id"]').val(token.id);
				$('#frmUpdateEmailSettings input[name="email_name"]').val(token.email_name);
				$('#frmUpdateEmailSettings input[name="email_id"]').val(token.email_id);			
				$('#frmUpdateEmailSettings input[name="email_sla"]').val(token.ticket_sla);			
				$('#frmUpdateEmailSettings select[name="is_show_send"]').val(token.is_show_send);			
				$('#frmUpdateEmailSettings select[name="is_show_autocomplete"]').val(token.is_show_autocomplete);			
				$('#frmUpdateEmailSettings select[name="is_show_outlook"]').val(token.is_show_outlook);			
				$('#frmUpdateEmailSettings select[name="is_show_forward"]').val(token.is_show_forward);			
				$('#frmUpdateEmailSettings select[name="is_legal_active"]').val(token.is_active);			
				$('#modalUpdateEmailSettings').modal('show');
			},
			error : function(token){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	});

	$('.editMasterMail').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		eidVal = $(this).attr('eid');
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('legal/master_email_ajax'); ?>",
			type: "GET",
			data: { eid : eidVal },
			dataType: "json",
			success : function(token){
				$('#sktPleaseWait').modal('hide');
				$('#frmUpdateEmail input[name="edit_id"]').val(token.id);
				$('#frmUpdateEmail input[name="email_name"]').val(token.email_name);
				$('#frmUpdateEmail input[name="email_id"]').val(token.email_id);
				$('#frmUpdateEmail select[name="email_type"]').val(token.type);
				$('#frmUpdateEmail select[name="auth_type"]').val(token.auth_type);
				$('#frmUpdateEmail input[name="auth_email"]').val(token.auth_email);
				$('#frmUpdateEmail input[name="email_password"]').val(token.password);
				$('#frmUpdateEmail input[name="email_sla"]').val(token.ticket_sla);			
				$('#frmUpdateEmail input[name="email_prefix"]').val(token.ticket_prefix);			
				$('#frmUpdateEmail select[name="email_ticket"]').val(token.ticket_serial);			
				$('#modalUpdateEmail').modal('show');
			},
			error : function(token){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	});

	//==== TICKET INFO DIV ==========//	
	$(document).on('click', '.pop_new', function(){
		baseURL = "<?php echo base_url(); ?>";
		ticketNo = $(this).attr('ticket');
		// dticketNo = $(this).attr('dticket');
		// $('#sktPleaseWait').modal('show');
		$('#abcd').html('');
		$.ajax({
			url: "<?php echo base_url('legal/ticket_details_ajax'); ?>",
			type: "GET",
			data: "ticketNo="+ticketNo,
			success : function(result){
				$('#abcd').html(result);
				$('#ticketModal').modal('show');
				// $('#sktPleaseWait').modal('hide');			
				// $('.ticketListDiv #t'+ticketNo).html(result);
				// $('.ticketListDiv #arrival_date').datepicker({ dateFormat: 'mm/dd/yy' });
				// $('.box').overlayScrollbars({
				// 	className: "os-theme-round-dark",
				// 	resize: "both",
				// 	sizeAutoCapable : true,
				// 	paddingAbsolute : true
				// }); 
			},
			error : function(result){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	});

	$('.pin_ticket').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		ticketNo = $(this).attr('ticket');
		is_pinned = $(this).attr('pin');
		$.ajax({
			url: "<?php echo base_url('legal/ticket_pinned_ajax'); ?>",
			type: "GET",
			data: "ticketNo="+ticketNo+'&is_pinned='+is_pinned,
			success : function(token){
				// $('#sktPleaseWait').modal('hide');
				window.location.reload();
			},
			error : function(token){
				// $('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	});

	$('.flipswitch-inner').click(function(){
		myval = $(this).closest('.switch_widget').find('.inputBlock').val();
		if(myval == '1')
		{
			$(this).closest('.switch_widget').find('.flipswitch-cb').prop('checked', false);
			$(this).closest('.switch_widget').find('.inputBlock').val('0');
		} else {
			$(this).closest('.switch_widget').find('.flipswitch-cb').prop('checked', true);
			$(this).closest('.switch_widget').find('.inputBlock').val('1');
		}
	});

	//======= MASTER CATEGORY ==============//
	$('.courseCatEdit').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		eidVal = $(this).attr('eid');
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('legal/ticket_category_info_ajax'); ?>",
			type: "GET",
			data: { eid : eidVal },
			dataType: "json",
			success : function(token){
				$('#sktPleaseWait').modal('hide');
				$('#frmUpdateLegalCategory input[name="edit_id"]').val(token.id);
				$('#frmUpdateLegalCategory select[name="email_id"]').val(token.legal_id);
				$('#frmUpdateLegalCategory input[name="category_code"]').val(token.category_code);
				$('#frmUpdateLegalCategory input[name="category_name"]').val(token.category_name);
				$('#frmUpdateLegalCategory input[name="category_sla"]').val(token.category_sla);
				$('#modalUpdateLegalCategory').modal('show');
			},
			error : function(token){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	});

	$('.catInfoCheck').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		eidVal = $(this).attr('eid');
		$('#sktPleaseWait').modal('show');
		$('#modalEmailDetailsCat .modal-title').html('Categroy Info');
		$('#modalEmailDetailsCat .modal-body').html('');
		$.ajax({
			url: "<?php echo base_url('legal/ticket_category_info_details'); ?>",
			type: "GET",
			data: { eid : eidVal },
			dataType: "text",
			success : function(token){
				$('#sktPleaseWait').modal('hide');
				$('#modalEmailDetailsCat .modal-body').html(token);
				$('#modalEmailDetailsCat').modal('show');
			},
			error : function(token){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	});

	$('.courseCatEditInfo').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		eidVal = $(this).attr('eid');
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('legal/ticket_category_info_ajax'); ?>",
			type: "GET",
			data: { eid : eidVal },
			dataType: "json",
			success : function(token){
				$('#sktPleaseWait').modal('hide');
				$('#frmUpdateLegalCategoryInfo input[name="edit_id"]').val(token.id);
				$('#frmUpdateLegalCategoryInfo select[name="email_id"]').val(token.legal_id);
				CKEDITOR.instances['moreInfoEditor'].setData(token.category_info);
				$('#modalUpdateLegalCategoryInfo').modal('show');
			},
			error : function(token){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	});

	$('.check_all').click(function(){
		if($("#check_all").prop('checked') == true){
			$(".check_ticket").each(function() {
				$( this ).prop( "checked", true );
				$('.check_widget').css('display','block');
			});
		}else{
			$(".check_ticket").each(function() {
				$( this ).prop( "checked", false );
				$('.check_widget').css('display','none');
			});
		}
	});

	$('.check_ticket').click(function(){
		var chk=0;
		$(".check_ticket").each(function() {
			if($(this).prop('checked') == true){
				chk=1;
			}
		});
		if(chk==1){
			// $('.div_ticketAssignUpdate').css('display','block');
			$('.check_widget').css('display','block');
			$('#ticket_user').prop('required',true);
		}else{
			// $('.div_ticketAssignUpdate').css('display','none');
			$('.check_widget').css('display','none');
		}
	});
})	


	function btnPriority(ticketNo){
		baseURL = "<?php echo base_url(); ?>";
		setPriority = $('#setPriority_'+ticketNo).val();
		console.log(ticketNo);
		console.log(setPriority);
		$.ajax({
			url: "<?php echo base_url('legal/add_priority_ajax'); ?>",
			type: "POST",
			data: "ticketNo="+ticketNo+'&setPriority='+setPriority,
			success : function(token){
				// $('#sktPleaseWait').modal('hide');
				window.location.reload();
			},
			error : function(token){
				// $('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	}

	$('.submit_btn').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		 let ticket_id=$("#ticket_id").val();
		 let category=$("#category").val();
		 let start_date=$("#start_date").val();
		 let end_date=$("#end_date").val();
		$.ajax({
			url: "<?php echo base_url('legal_manual/ticket_unassigned_search'); ?>",
			type: "POST",
			data: { ticket_id : ticket_id, category:category,start_date:start_date,end_date:end_date},
			// data: { eid : eidVal },
			dataType: "text",
			success : function(json_obj){
				console.log(json_obj);
				var alrt = JSON.parse(json_obj);
                console.log(alrt.queryTicket);
                // console.log(alrt.date_res);
				$(".onload_tr_value").hide();
				$('#table_data').html("");
				var html ='';
				for(var i in alrt.queryTicket){
					html+=`<tr >
							<td>
								<div class="ticket_widget">
									<input type="checkbox" name="checkbox" onclick="boxchk();">
									<a href="#" class="link_icon" id="ticket_right">
										<i class="fa fa-star-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-thumb-tack" aria-hidden="true"></i>
									</a>
								</div>
							</td>
							<td><span class="pop_new" ticket="`+alrt.queryTicket[i].ticket_no+`" data-bs-toggle="modal" data-bs-target="#ticketModal`+alrt.queryTicket[i].ticket_no+`"><b>`+alrt.queryTicket[i].ticket_no+`</b></span> : `+alrt.queryTicket[i].ticket_subject+`</td>`;
							var date_val=alrt.queryTicket[i].date_added;
							// alert(date_val);
							if(alrt.queryTicket[i].ticket_arrival_date!=null){
								var arrival_date=alrt.queryTicket[i].ticket_arrival_date;
							}
							else{
								var arrival_date="-";
							}
							html+=`<td>`+arrival_date+`</td>
							<td>`+alrt.queryTicket[i].ticket_category+`</td>`;
							if(alrt.queryTicket[i].total_time!=null){
								var tot_time=alrt.queryTicket[i].total_time;
							}
							else{
								var tot_time="N/A";
								
							}
							html+=`<td>`+alrt.date_res[i]+`</td>
							<td><span class="red">`+alrt.date_res[i]+` 
							</span></td>
							</tr>`;
						}
							// //datatable_refresh('.agentWidget #default-datatable', 1);
							// alert(html);
							console.log(html);
				 			$('#table_data').html(html);
				 
				// //datatable_refresh('.agentWidget #default-datatable');
				// $('#sktPleaseWait').modal('hide');	
						},
				error : function(json_obj){
				// $('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}

		});
	});
	// for assigned list start here
	$('.submit_btn_for_assigned').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		 let ticket_id=$("#ticket_id").val();
		 let category=$("#category").val();
		 let start_date=$("#start_date").val();
		 let end_date=$("#end_date").val();
		 let side_bar_view='assigned';
		$.ajax({
			url: "<?php echo base_url('legal_manual/ticket_assigned_passed_search'); ?>",
			type: "POST",
			data: { ticket_id : ticket_id, category:category,start_date:start_date,end_date:end_date,side_bar_view:side_bar_view},
			// data: { eid : eidVal },
			dataType: "text",
			success : function(json_obj){
				console.log(json_obj);
				var alrt = JSON.parse(json_obj);
                console.log(alrt.queryTicket);
                // console.log(alrt.date_res);
				$(".onload_tr_value").hide();
				$('#table_data_val').html("");
				var html ='';
				for(var i in alrt.queryTicket){
					html+=`<tr >
							<td>
								<div class="ticket_widget">
									<input type="checkbox" name="checkbox">
									<a href="#" class="link_icon" id="ticket_right">
										<i class="fa fa-star-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-thumb-tack" aria-hidden="true"></i>
									</a>
								</div>
							</td>
							<td><b>`+alrt.queryTicket[i].ticket_no+`</b> : `+alrt.queryTicket[i].ticket_subject+`</td>`;
							var date_val=alrt.queryTicket[i].date_added;
							// alert(date_val);
							if(alrt.queryTicket[i].ticket_arrival_date!=null){
								var arrival_date=alrt.queryTicket[i].ticket_arrival_date;
							}
							else{
								var arrival_date="-";
							}
							html+=`<td>`+arrival_date+`</td>
							<td>`+alrt.queryTicket[i].ticket_category+`</td>`;
							if(alrt.queryTicket[i].total_time!=null){
								var tot_time=alrt.queryTicket[i].total_time;
							}
							else{
								var tot_time="N/A";
								
							}
							html+=`<td>`+alrt.date_res[i]+`</td>
							<td><span class="red">`+alrt.date_res[i]+` 
							</span></td>
							</tr>`;
						}
							// alert(html);
							console.log(html);
				 			$('#table_data_val').html(html);
						},
				error : function(json_obj){
				// $('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}

		});
	});

	$('.submit_btn_for_passed').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		 let ticket_id=$("#ticket_id").val();
		 let category=$("#category").val();
		 let start_date=$("#start_date").val();
		 let end_date=$("#end_date").val();
		 let side_bar_view='passed';
		$.ajax({
			url: "<?php echo base_url('legal_manual/ticket_assigned_passed_search'); ?>",
			type: "POST",
			data: { ticket_id : ticket_id, category:category,start_date:start_date,end_date:end_date,side_bar_view:side_bar_view},
			// data: { eid : eidVal },
			dataType: "text",
			success : function(json_obj){
				console.log(json_obj);
				var alrt = JSON.parse(json_obj);
                console.log(alrt.queryTicket);
                // console.log(alrt.date_res);
				$(".onload_tr_value").hide();
				$('#table_data_val').html("");
				var html ='';
				for(var i in alrt.queryTicket){
					html+=`<tr >
							<td>
								<div class="ticket_widget">
									<input type="checkbox" name="checkbox">
									<a href="#" class="link_icon" id="ticket_right">
										<i class="fa fa-star-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-thumb-tack" aria-hidden="true"></i>
									</a>
								</div>
							</td>
							<td><b>`+alrt.queryTicket[i].ticket_no+`</b> : `+alrt.queryTicket[i].ticket_subject+`</td>`;
							var date_val=alrt.queryTicket[i].date_added;
							// alert(date_val);
							if(alrt.queryTicket[i].ticket_arrival_date!=null){
								var arrival_date=alrt.queryTicket[i].ticket_arrival_date;
							}
							else{
								var arrival_date="-";
							}
							html+=`<td>`+arrival_date+`</td>
							<td>`+alrt.queryTicket[i].ticket_category+`</td>`;
							if(alrt.queryTicket[i].total_time!=null){
								var tot_time=alrt.queryTicket[i].total_time;
							}
							else{
								var tot_time="N/A";
								
							}
							html+=`<td>`+alrt.date_res[i]+`</td>
							<td><span class="red">`+alrt.date_res[i]+` 
							</span></td>
							</tr>`;
						}
							// alert(html);
							console.log(html);
				 			$('#table_data_val').html(html);
						},
				error : function(json_obj){
				// $('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}

		});
	});
	$('.submit_btn_for_completed').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		 let ticket_id=$("#ticket_id").val();
		 let category=$("#category").val();
		 let start_date=$("#start_date").val();
		 let end_date=$("#end_date").val();
		 let side_bar_view='completed';
		$.ajax({
			url: "<?php echo base_url('legal_manual/ticket_assigned_passed_search'); ?>",
			type: "POST",
			data: { ticket_id : ticket_id, category:category,start_date:start_date,end_date:end_date,side_bar_view:side_bar_view},
			// data: { eid : eidVal },
			dataType: "text",
			success : function(json_obj){
				console.log(json_obj);
				var alrt = JSON.parse(json_obj);
                console.log(alrt.queryTicket);
                // console.log(alrt.date_res);
				$(".onload_tr_value").hide();
				$('#table_data_val_for_complete_list').html("");
				var html ='';
				for(var i in alrt.queryTicket){
					html+=`<tr >
							<td>
								<div class="ticket_widget">
									<input type="checkbox" name="checkbox">
									<a href="#" class="link_icon" id="ticket_right">
										<i class="fa fa-star-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-thumb-tack" aria-hidden="true"></i>
									</a>
								</div>
							</td>
							<td><b>`+alrt.queryTicket[i].ticket_no+`</b> : `+alrt.queryTicket[i].ticket_subject+`</td>`;
							var date_val=alrt.queryTicket[i].date_added;
							// alert(date_val);
							if(alrt.queryTicket[i].ticket_arrival_date!=null){
								var arrival_date=alrt.queryTicket[i].ticket_arrival_date;
							}
							else{
								var arrival_date="-";
							}
							html+=`<td>`+arrival_date+`</td>
							<td>`+alrt.queryTicket[i].ticket_category+`</td>`;
							if(alrt.queryTicket[i].total_time!=null){
								var tot_time=alrt.queryTicket[i].total_time;
							}
							else{
								var tot_time="N/A";
								
							}
							html+=`<td>`+alrt.date_res[i]+`</td>
							<td><span class="red">`+alrt.date_res[i]+` 
							</span></td>
							</tr>`;
						}
							// alert(html);
							console.log(html);
				 			$('#table_data_val_for_complete_list').html(html);
						},
				error : function(json_obj){
				// $('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}

		});
	});





















	// for assigned list end here
	$('.filter_search').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		//  eidVal = 1;
		 let category_search=$("#category_search").val();
		 let ageing=$("#ageing").val();
		 let search_page='unassigned';
		$.ajax({
			url: "<?php echo base_url('legal_manual/ticket_top_bar_search'); ?>",
			type: "POST",
			data: { ageing :ageing,category_search:category_search},
			// data: { eid : eidVal },
			dataType: "text",
			success : function(json_obj){
				// console.log(json_obj);
				var alrt = JSON.parse(json_obj);
                console.log(alrt.queryTicket);
                console.log(alrt.date_res);

				$(".onload_tr_value").hide();
				$('#table_data').html("");
 
						
				// var html = '';
				// for (var i in json_obj){
				// 	html += '<tr><td><input type="checkbox" name="userCheckBox[]" value="'+json_obj[i].id+'"></td><td>'+json_obj[i].full_name +'</td><td>'+json_obj[i].fusion_id+'</td><td>'+json_obj[i].department+'</td><td>'+json_obj[i].designation+'</td></tr>';
				// }

				var html ='';
				for(var i in alrt.queryTicket){
					html+=`<tr >
							<td>
								<div class="ticket_widget">
									<input type="checkbox" name="checkbox">
									<a href="#" class="link_icon" id="ticket_right">
										<i class="fa fa-star-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-thumb-tack" aria-hidden="true"></i>
									</a>
								</div>
							</td>
							<td><b>`+alrt.queryTicket[i].ticket_no+`</b> : `+alrt.queryTicket[i].ticket_subject+`</td>`;
							var date_val=alrt.queryTicket[i].date_added;
							// alert(date_val);
							if(alrt.queryTicket[i].ticket_arrival_date!=null){
								var arrival_date=alrt.queryTicket[i].ticket_arrival_date;
							}
							else{
								var arrival_date="-";
							}
							html+=`<td>`+arrival_date+`</td>
							<td>`+alrt.queryTicket[i].ticket_category+`</td>`;
							if(alrt.queryTicket[i].total_time!=null){
								var tot_time=alrt.queryTicket[i].total_time;
							}
							else{
								var tot_time="N/A";
								
							}
							html+=`<td>`+alrt.date_res[i]+`</td>
							<td><span class="red">`+alrt.date_res[i]+` 
							</span></td>
							</tr>`;
						}
							// //datatable_refresh('.agentWidget #default-datatable', 1);
							// alert(html);
							console.log(html);
				 			$('#table_data').html(html);
				 
						},
			

		});
	});
	
	$('.filter_search_for_assigned').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		//  eidVal = 1;
		 let category_search=$("#category_search").val();
		 let ageing=$("#ageing").val();
		 let search_page='assigned';
		$.ajax({
			url: "<?php echo base_url('legal_manual/ticket_top_bar_search'); ?>",
			type: "POST",
			data: { ageing :ageing,category_search:category_search,search_page:search_page},
			// data: { eid : eidVal },
			dataType: "text",
			success : function(json_obj){
				// console.log(json_obj);
				var alrt = JSON.parse(json_obj);
                console.log(alrt.queryTicket);
                console.log(alrt.date_res);

				$(".onload_tr_value").hide();
				$('#table_data_val').html("");

						
				// var html = '';
				// for (var i in json_obj){
				// 	html += '<tr><td><input type="checkbox" name="userCheckBox[]" value="'+json_obj[i].id+'"></td><td>'+json_obj[i].full_name +'</td><td>'+json_obj[i].fusion_id+'</td><td>'+json_obj[i].department+'</td><td>'+json_obj[i].designation+'</td></tr>';
				// }

				var html ='';
				for(var i in alrt.queryTicket){
					html+=`<tr >
							<td>
								<div class="ticket_widget">
									<input type="checkbox" name="checkbox">
									<a href="#" class="link_icon" id="ticket_right">
										<i class="fa fa-star-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-thumb-tack" aria-hidden="true"></i>
									</a>
								</div>
							</td>
							<td><b>`+alrt.queryTicket[i].ticket_no+`</b> : `+alrt.queryTicket[i].ticket_subject+`</td>`;
							var date_val=alrt.queryTicket[i].date_added;
							// alert(date_val);
							if(alrt.queryTicket[i].ticket_arrival_date!=null){
								var arrival_date=alrt.queryTicket[i].ticket_arrival_date;
							}
							else{
								var arrival_date="-";
							}
							html+=`<td>`+arrival_date+`</td>
							<td>`+alrt.queryTicket[i].ticket_category+`</td>`;
							if(alrt.queryTicket[i].total_time!=null){
								var tot_time=alrt.queryTicket[i].total_time;
							}
							else{
								var tot_time="N/A";
								
							}
							html+=`<td>`+alrt.date_res[i]+`</td>
							<td><span class="red">`+alrt.date_res[i]+` 
							</span></td>
							</tr>`;
						}
							// //datatable_refresh('.agentWidget #default-datatable', 1);
							// alert(html);
							console.log(html);
				 			$('#table_data_val').html(html);
				 
						},
			

		});
	});
	$('.filter_search_for_passed').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		//  eidVal = 1;
		 let category_search=$("#category_search").val();
		 let ageing=$("#ageing").val();
		 let search_page='passed';
		$.ajax({
			url: "<?php echo base_url('legal_manual/ticket_top_bar_search'); ?>",
			type: "POST",
			data: { ageing :ageing,category_search:category_search,search_page:search_page},
			// data: { eid : eidVal },
			dataType: "text",
			success : function(json_obj){
				// console.log(json_obj);
				var alrt = JSON.parse(json_obj);
                console.log(alrt.queryTicket);
                console.log(alrt.date_res);

				$(".onload_tr_value").hide();
				$('#table_data_val').html("");

						
				// var html = '';
				// for (var i in json_obj){
				// 	html += '<tr><td><input type="checkbox" name="userCheckBox[]" value="'+json_obj[i].id+'"></td><td>'+json_obj[i].full_name +'</td><td>'+json_obj[i].fusion_id+'</td><td>'+json_obj[i].department+'</td><td>'+json_obj[i].designation+'</td></tr>';
				// }

				var html ='';
				for(var i in alrt.queryTicket){
					html+=`<tr >
							<td>
								<div class="ticket_widget">
									<input type="checkbox" name="checkbox">
									<a href="#" class="link_icon" id="ticket_right">
										<i class="fa fa-star-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-thumb-tack" aria-hidden="true"></i>
									</a>
								</div>
							</td>
							<td><b>`+alrt.queryTicket[i].ticket_no+`</b> : `+alrt.queryTicket[i].ticket_subject+`</td>`;
							var date_val=alrt.queryTicket[i].date_added;
							// alert(date_val);
							if(alrt.queryTicket[i].ticket_arrival_date!=null){
								var arrival_date=alrt.queryTicket[i].ticket_arrival_date;
							}
							else{
								var arrival_date="-";
							}
							html+=`<td>`+arrival_date+`</td>
							<td>`+alrt.queryTicket[i].ticket_category+`</td>`;
							if(alrt.queryTicket[i].total_time!=null){
								var tot_time=alrt.queryTicket[i].total_time;
							}
							else{
								var tot_time="N/A";
								
							}
							html+=`<td>`+alrt.date_res[i]+`</td>
							<td><span class="red">`+alrt.date_res[i]+` 
							</span></td>
							</tr>`;
						}
							// //datatable_refresh('.agentWidget #default-datatable', 1);
							// alert(html);
							console.log(html);
				 			$('#table_data_val').html(html);
				 
						},
			

		});
	});
	$('.filter_search_for_completed').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		//  eidVal = 1;
		 let category_search=$("#category_search").val();
		  let ageing=$("#ageing").val();
		 let search_page='completed';
		$.ajax({
			url: "<?php echo base_url('legal_manual/ticket_top_bar_search'); ?>",
			type: "POST",
			data: { ageing :ageing,category_search:category_search,search_page:search_page},
			// data: { eid : eidVal },
			dataType: "text",
			success : function(json_obj){
				// console.log(json_obj);
				var alrt = JSON.parse(json_obj);
                console.log(alrt.queryTicket);
                console.log(alrt.date_res);

				$(".onload_tr_value").hide();
				$('#table_data_val_for_complete_list').html("");

						
				// var html = '';
				// for (var i in json_obj){
				// 	html += '<tr><td><input type="checkbox" name="userCheckBox[]" value="'+json_obj[i].id+'"></td><td>'+json_obj[i].full_name +'</td><td>'+json_obj[i].fusion_id+'</td><td>'+json_obj[i].department+'</td><td>'+json_obj[i].designation+'</td></tr>';
				// }

				var html ='';
				for(var i in alrt.queryTicket){
					html+=`<tr >
							<td>
								<div class="ticket_widget">
									<input type="checkbox" name="checkbox">
									<a href="#" class="link_icon" id="ticket_right">
										<i class="fa fa-star-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
									</a>
									<a href="#" class="link_icon">
										<i class="fa fa-thumb-tack" aria-hidden="true"></i>
									</a>
								</div>
							</td>
							<td><b>`+alrt.queryTicket[i].ticket_no+`</b> : `+alrt.queryTicket[i].ticket_subject+`</td>`;
							var date_val=alrt.queryTicket[i].date_added;
							// alert(date_val);
							if(alrt.queryTicket[i].ticket_arrival_date!=null){
								var arrival_date=alrt.queryTicket[i].ticket_arrival_date;
							}
							else{
								var arrival_date="-";
							}
							html+=`<td>`+arrival_date+`</td>
							<td>`+alrt.queryTicket[i].ticket_category+`</td>`;
							if(alrt.queryTicket[i].total_time!=null){
								var tot_time=alrt.queryTicket[i].total_time;
							}
							else{
								var tot_time="N/A";
								
							}
							html+=`<td>`+alrt.date_res[i]+`</td>
							<td><span class="red">`+alrt.date_res[i]+` 
							</span></td>
							</tr>`;
						}
							// //datatable_refresh('.agentWidget #default-datatable', 1);
							// alert(html);
							console.log(html);
				 			$('#table_data_val_for_complete_list').html(html);
				 
						},
			

		});
	});




$('.oldDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy' });
$('.timeFormat').timepicker({ timeFormat: 'HH:mm:ss', });
$('.box').overlayScrollbars({
	className: "os-theme-round-dark",
	resize: "both",
	sizeAutoCapable : true,
	paddingAbsolute : true
}); 


<?php if(!empty($show_editor) && $show_editor == 1){ ?>

my_toolBar = [
	{
	  "name": "basicstyles",
	  "groups": ["basicstyles"]
	},
	{
	  "name": "links",
	  "groups": ["links"]
	},
	{
	  "name": "paragraph",
	  "groups": ["list", "blocks"]
	},
	/*{
	  "name": "document",
	  "groups": ["mode"]
	},*/
	{
	  "name": "insert",
	  "groups": ["insert"]
	},
	{
	  "name": "styles",
	  "groups": ["styles"]
	},
];
CKEDITOR.replace('moreInfoEditor2', {
		toolbarGroups: my_toolBar,
		removePlugins: 'about',
		removeButtons: 'Strike,Subscript,Superscript,Anchor,Specialchar',
		enterMode : CKEDITOR.ENTER_BR,
		disableNativeSpellChecker : false,
		height  : '300px',
		//customConfig: '<?php echo base_url(); ?>assets/ckeditor/configCustom.js',
		on: {
			instanceReady: function (evt) {
			evt.editor.document.getBody().setStyles({color: 'black', 'font-size': '11px', 'font-family': 'cambria'})
			}
		}
	});
CKEDITOR.replace('moreInfoEditor', {
	toolbarGroups: my_toolBar,
	removePlugins: 'about',
	removeButtons: 'Strike,Subscript,Superscript,Anchor,Specialchar',
	enterMode : CKEDITOR.ENTER_BR,
	height  : '300px',
	disableNativeSpellChecker : false,
	//customConfig: '<?php echo base_url(); ?>assets/ckeditor/configCustom.js',
	on: {
		instanceReady: function (evt) {
		evt.editor.document.getBody().setStyles({color: 'black', 'font-size': '11px', 'font-family': 'cambria'})
		}
	}
});
CKEDITOR.replace('moreInfoEditorEdit', {
	toolbarGroups: my_toolBar,
	removePlugins: 'about',
	removeButtons: 'Strike,Subscript,Superscript,Anchor,Specialchar',
	enterMode : CKEDITOR.ENTER_BR,
	disableNativeSpellChecker : false,
	height  : '300px',
	on: {
		instanceReady: function (evt) {
		evt.editor.document.getBody().setStyles({color: 'black', 'font-size': '11px', 'font-family': 'cambria'})
		}
	}
});
<?php } ?>

$('.masterEmailRow').on('keyup', 'input[name="email_id"]', function(){
	curVal = $(this).closest('.masterEmailRow').find('input[name="email_id"]').val();
	authType = $(this).closest('.masterEmailRow').find('select[name="auth_type"]').val();
	$(this).closest('.masterEmailRow').find('input[name="auth_email"]').val(curVal);
	$(this).closest('.masterEmailRow').find('input[name="auth_email"]').attr('readonly', 'readonly');
	if(authType == "shared"){
		$(this).closest('.masterEmailRow').find('input[name="auth_email"]').removeAttr('readonly', 'readonly');
	}
});

$('.masterEmailRow').on('change', 'select[name="auth_type"]', function(){
	curVal = $(this).closest('.masterEmailRow').find('input[name="email_id"]').val();
	authType = $(this).closest('.masterEmailRow').find('select[name="auth_type"]').val();
	$(this).closest('.masterEmailRow').find('input[name="auth_email"]').val(curVal);
	$(this).closest('.masterEmailRow').find('input[name="auth_email"]').attr('readonly', 'readonly');
	if(authType == "shared"){
		$(this).closest('.masterEmailRow').find('input[name="auth_email"]').val('');
		$(this).closest('.masterEmailRow').find('input[name="auth_email"]').removeAttr('readonly', 'readonly');
	}
});


$('#modalEmailDetails').on('click', '.editMasterMailFolder', function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	curVal = $(this).attr('folder');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('legal/move_master_email_folder'); ?>",
		type: "GET",
		data: { eid : eidVal, folder : curVal },
		dataType: "text",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Complete Folder Updated Successfully!');
			$('#modalEmailDetails').modal('hide');
			//window.location.reload();
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

notReply = 0;

//======= MASTER EMAIL ==============//
$('.editMasterMailFolder').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	$('#sktPleaseWait').modal('show');
	$('#modalEmailDetails .modal-title').html('Set Maibox Complete Folder');
	$('#modalEmailDetails .modal-body').html('');
	$.ajax({
		url: "<?php echo base_url('legal/master_email_folder_ajax'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "text",
		success : function(token){
			$('#sktPleaseWait').modal('hide');		
			$('#modalEmailDetails .modal-body').html(token);
			$('#modalEmailDetails').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

//======= CANNED MESSAGE ==============//
$('.cannedEdit').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('legal/master_canned_message_ajax'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "json",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			$('#frmUpdateEmailCanned input[name="edit_id"]').val(token.id);
			$('#frmUpdateEmailCanned input[name="message_name"]').val(token.canned_name);
			//$('#frmUpdateEmailCanned textarea[name="message_body"]').html(token.canned_message);
			$('#frmUpdateEmailCanned select[name="mail_box[]"]').val(token.mail_box.split(','));
			CKEDITOR.instances['moreInfoEditorEdit'].setData(token.canned_message);
			$('.agentWidget select[name="mail_box[]"]').select2();
			$('#modalUpdateEmailCanned').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

<?php if(!e_rta_access()){ ?>

//==== TICKET INFO DIV ==========//	
$('.ticketListDiv').on('click', '.arrivalDIVInfoTrigger', function(){
	$('.ticketListDiv .arrivalDIVInfo').show();
});

$('.ticketListDiv').on('click', '.arrivalDIVInfoUpdater', function(){
	arrival_ticket_no = $(this).closest('.arrivalDIVInfo').find('input[name="arrival_ticket_no"]').val();
	arrival_date = $(this).closest('.arrivalDIVInfo').find('input[name="arrival_date"]').val();
	if(arrival_date != "" && arrival_ticket_no != ""){
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('legal/ticket_arrival_date_update'); ?>",
			type: "GET",
			data: { arrival_date : arrival_date, ticket_no : arrival_ticket_no },
			dataType: "text",
			success : function(result){
				$('#sktPleaseWait').modal('hide');
				window.location.reload();
			},
			error : function(result){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	} else {
		alert('Please Select Appropriate Date!');
	}
});

$('.arrivalBlock').on('click', '.arrivalDIVInfoUpdater', function(){
	arrival_ticket_no = $(this).closest('.arrivalDIVInfo').find('input[name="arrival_ticket_no"]').val();
	arrival_date = $(this).closest('.arrivalDIVInfo').find('input[name="arrival_date"]').val();
	if(arrival_date != "" && arrival_ticket_no != ""){
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('legal/ticket_arrival_date_update'); ?>",
			type: "GET",
			data: { arrival_date : arrival_date, ticket_no : arrival_ticket_no },
			dataType: "text",
			success : function(result){
				$('#sktPleaseWait').modal('hide');
				alert('Arrival Date has been updated!');
			},
			error : function(result){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	} else {
		alert('Please Select Appropriate Date!');
	}
});


//==== TICKET DUPLICATE INFO DIV ==========//	
$('.ticketListDiv').on('click', '.ticketInfoDivDuplicate', function(){
	baseURL = "<?php echo base_url(); ?>";
	ticketNo = $(this).attr('ticket');
	dticketNo = $(this).attr('dticket');
	$('#sktPleaseWait').modal('show');
	$('.ticketListDiv .ticketInfoDetailsDuplicate').html('');
	$.ajax({
		url: "<?php echo base_url('legal/ticket_details_ajax'); ?>",
		type: "GET",
		data: { ticket_no : ticketNo, finder: 1 },
		dataType: "text",
		success : function(result){
			$('#sktPleaseWait').modal('hide');			
			$('.ticketListDiv #dt_'+dticketNo +'_'+ticketNo).html(result);
			$('.box').overlayScrollbars({
				className: "os-theme-round-dark",
				resize: "both",
				sizeAutoCapable : true,
				paddingAbsolute : true
			}); 
		},
		error : function(result){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

<?php } ?>

<?php if(!empty($showtimer)){ ?>
// STOPWATCH TIMER
startDateTimer = new Date();
startTimer();
function startTimer(){
	var total_seconds = (new Date() - startDateTimer) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timeWatch").html(result);
	$("#time_interval").val(result);
	$("#time_interval_notes").val(result);
	$("#time_interval_update").val(result);
	setTimeout(function(){startTimer()}, 1000);
}

startDateTimerNew = new Date();
startTimerNew();
function startTimerNew(){
	var total_seconds = (new Date() - startDateTimerNew) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timeWatchNew").html(result);
	setTimeout(function(){startTimerNew()}, 1000);
}

function startHoldNew(startDate){
	var total_seconds = (new Date() - startDate) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timer_hold").val(result);
	//$('.inHold span').html(result);	
	timerHoldStatus = $("#timer_hold_status").val();
	if(timerHoldStatus == 'H'){
		//$('.inHold').show();
		//$('.inCall, .inWait').hide();
		$("#timer_start_status").val('H');
		timeOutVar = setTimeout(function(){startHoldNew(startDate)}, 1000);
		console.log('hi');
	} else {
		clearTimeout(timeOutVar);
		$("#timer_hold").val('');
		$("#timer_hold_status").val('H');	
		console.log('byee');
	}
}

function startHoldEnd(){
	holded = $("#timer_hold").val();
	holdedNo = $('#hold_reason_count').val();
	//$("#timeHolder").append('Hold ' + holdedNo + ' - ' + holded + '<br/>');
	pastHold = getSeconds($('#hold_interval').val());
	currentHold = getSeconds(holded);
	var newTime = new Date(null);
	newTime.setSeconds(Number(pastHold) + Number(currentHold));
	var result = newTime.toISOString().substr(11, 8);
	$('#hold_interval').val(result);
	$('#hold_interval_notes').val(result);
	$('#hold_reason_count').val(Number(holdedNo) + 1);
	$('#hold_reason_count_notes').val(Number(holdedNo) + 1);
	$("#timer_hold_status").val('U');
	$('#modal_hold_reason').val('');
}

function getSeconds(time)
{
    var ts = time.split(':');
    return Date.UTC(1970, 0, 1, ts[0], ts[1], ts[2]) / 1000;
}


function callActionButton(current){
	callType = $(current).attr('btype');	
	if(callType == 'hold'){
		reasonHold = $('#modal_hold_reason').val();
		reasonOption = $('#modal_hold_option').val();
		if(reasonHold != ""){
			startHoldNew(new Date());
			$('#holdCallModal').modal('hide');
			$('#unholdCallModal').modal('show');
		} else {
			alert('Please Enter the Reason!');
		}
	}
	if(callType == 'unhold'){ 
		startHoldEnd(); 
		$('#unholdCallModal').modal('hide');
		$('#holdCallModal').modal('hide');
	}
}

<?php } ?>


$('.categoryFolderRow').on('change', 'select[name="email_id"]', function(){
	eid = $('.categoryFolderRow select[name="email_id"]').val();	
	$('#sktPleaseWait').modal('show');			
	$.ajax({
		url: "<?php echo base_url('legal/maste_legal_folder_ajax'); ?>",
		type: "GET",
		data: { eid : eid },
		dataType: "json",
		success : function(json_obj){
					
			var html = '';
			for (var i in json_obj){
				html += '<tr><td><input type="checkbox" name="folderCheckBox[]" value="'+json_obj[i].values+'"></td><td>'+json_obj[i].folder +'</td><td>'+json_obj[i].name+'</td><td>'+json_obj[i].code+'</td></tr>';
			}
			//datatable_refresh('.agentWidget #default-datatable', 1);
			$('.categoryFolderRow #allCategoryTableList').html(html);
			//datatable_refresh('.agentWidget #default-datatable');
			$('#sktPleaseWait').modal('hide');	
		},
		error : function(json_obj){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$(document).on('click','.selectAllUserCheckBox',function()
{
	if($(this).is(':checked'))
	{
		$('[name="userCheckBox[]"]').prop('checked',true);
	}
	else
	{
		$('[name="userCheckBox[]"]').prop('checked',false);
	}
});

<?php if(!empty($show_table) && $show_table == 1){ ?>
function datatable_refresh(id, type="")
{
	if(type!=''){
	$(id).dataTable().fnClearTable();
	$(id).dataTable().fnDestroy();
	}
	if(type==''){
	$(id).DataTable({
		paginate:false,
		bInfo:false
	});
	}
}

$('#default-datatable-list').DataTable({
	bInfo:false,
	pageLength:25
});
<?php } ?>

$('.agentWidget select[name="mail_box[]"]').select2();
$('.agentWidget select[name="category_id[]"]').select2();


//==== DROPDOWN TOGGLE LIST ==========//	
$('.dropdownCapture').on('change', 'select[name="ticket_list_dropdown"]', function(){
	pageType = $(this).val();
	emailID = "<?php echo !empty($email_id) ? bin2hex($email_id) : 'view'; ?>";
	finalPage = "ticket_list";	
	if(pageType == 'pending'){
		finalPage = "ticket_unassigned";
	} else if(pageType == 'assigned'){
		finalPage = "ticket_pending";
	} else if(pageType == 'passed'){
		finalPage = "ticket_passed";
	} else if(pageType == 'completed'){
		finalPage = "ticket_completed";
	} else if(pageType == 'all'){
		finalPage = "ticket_list";
	} else {
		finalPage = "ticket_list";
	}	
	url = "<?php echo base_url(); ?>legal/" + finalPage + "/" + emailID;
	window.location.href = url;
});

$('.dropdownCapture').on('change', 'select[name="sort_list_dropdown"]', function(){
	sortSelection = $(this).val();
	sortemailID = "<?php echo !empty($email_id) ? $email_id : ''; ?>";
	if(sortemailID != "" && sortSelection != "")
	{
		$.ajax({
			url: "<?php echo base_url('legal/ticket_sort_list_update_ajax'); ?>",
			type: "GET",
			data: { sort_type : sortSelection, email_id : sortemailID,  },
			dataType: "text",
			success : function(token){
				window.location.reload();
			},
			error : function(token){
				//alert('Something Went Wrong!');
			}
		});		
	}	
});

<?php if(!empty($show_editor) && $show_editor == 1){ ?>

//======= CANNED MESSAGE ==============//
$('.cannedMaster').change(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).val();
	if(eidVal != ""){
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('legal/master_canned_message_ajax'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "json",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			textData = CKEDITOR.instances['moreInfoEditor'].getData();
			finalData = textData + '<br/>' + token.canned_message;
			CKEDITOR.instances['moreInfoEditor'].setData(finalData);
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
	} else {
		
	}
});

<?php } ?>

//======= MASTER EMAIL ==============//
$('.notesSubmission').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.notesBlock input[name="ticket_no"]').val();
	time_interval_notes = $('.notesBlock input[name="time_interval_notes"]').val();
	ticket_notes = $('.notesBlock textarea[name="ticket_notes"]').val();
	hold_interval_notes = $('.notesBlock input[name="hold_interval_notes"]').val();
	hold_reason_count_notes = $('.notesBlock input[name="hold_reason_count_notes"]').val();
	hold_reason_notes = $('.notesBlock input[name="hold_reason_notes"]').val();
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('legal/ticket_add_notes'); ?>",
		type: "POST",
		data: { ticket_no : ticket_no, time_interval_notes : time_interval_notes, ticket_notes : ticket_notes, hold_interval_notes : hold_interval_notes, hold_reason_count_notes : hold_reason_count_notes, hold_reason_notes : hold_reason_notes  },
		dataType: "text",
		success : function(token){
			startDateTimer = new Date();
			startTimer();
			$('#sktPleaseWait').modal('hide');
			$('.notesBlock textarea[name="ticket_notes"]').val('');
			$("#hold_interval").val('00:00:00');
			$("#hold_reason_count").val('0');
			$("#hold_reason").val('');
			
			$("#hold_interval_notes").val('00:00:00');
			$("#hold_reason_count_notes").val('0');
			$("#hold_reason_notes").val('');
			$('.notesSectionShow').append(token);
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

<?php if(!empty($show_editor) && $show_editor == 1){ ?>

$('.replySubmission').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.ticketFormReply input[name="ticket_no"]').val();
	mailing_to = $('.ticketFormReply input[name="mailing_to"]').val();
	mailing_cc = $('.ticketFormReply input[name="mailing_cc"]').val();
	mailing_subject = $('.ticketFormReply input[name="mailing_subject"]').val();
	time_interval_notes = $('.ticketFormReply input[name="time_interval"]').val();
	ticket_notes = CKEDITOR.instances['moreInfoEditor'].getData();
	ticket_last = CKEDITOR.instances['moreInfoEditor2'].getData();
	hold_interval_notes = $('.ticketFormReply input[name="hold_interval"]').val();
	hold_reason_count_notes = $('.ticketFormReply input[name="hold_reason_count"]').val();
	hold_reason_notes = $('.ticketFormReply input[name="hold_reason"]').val();
	mailing_from = $('#mailing_from option:selected').val();
	
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('legal/ticket_close_reply'); ?>",
		type: "POST",
		data: { ticket_no : ticket_no, time_interval : time_interval_notes, message_body : ticket_notes, hold_interval : hold_interval_notes, hold_reason_count : hold_reason_count_notes, hold_reason : hold_reason_notes,message_body_trail :  ticket_last, mailing_to : mailing_to,mailing_from:mailing_from, mailing_cc : mailing_cc, mailing_subject : mailing_subject
		},
		dataType: "text",
		success : function(token){
			//console.log(token);
			/*startDateTimer = new Date();
			startTimer();
			$('#sktPleaseWait').modal('hide');
			$('.notesBlock textarea[name="ticket_notes"]').val('');
			$("#hold_interval").val('00:00:00');
			$("#hold_reason_count").val('0');
			$("#hold_reason").val('');
			
			$("#hold_interval_notes").val('00:00:00');
			$("#hold_reason_count_notes").val('0');
			$("#hold_reason_notes").val('');
			$('.notesSectionShow').append(token);*/
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
		},
		error : function(token){
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$('.replySubmissionOutlook').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.ticketFormReply input[name="ticket_no"]').val();
	time_interval_notes = $('.ticketFormReply input[name="time_interval"]').val();
	ticket_notes = "";
	hold_interval_notes = $('.ticketFormReply input[name="hold_interval"]').val();
	hold_reason_count_notes = $('.ticketFormReply input[name="hold_reason_count"]').val();
	hold_reason_notes = $('.ticketFormReply input[name="hold_reason"]').val();
	mailing_from = $('#mailing_from option:selected').val();
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('legal/ticket_auto_close_reply'); ?>",
		type: "POST",
		data: { ticket_no : ticket_no, time_interval : time_interval_notes, message_body : ticket_notes, hold_interval : hold_interval_notes, hold_reason_count : hold_reason_count_notes, hold_reason : hold_reason_notes,mailing_from:mailing_from  },
		dataType: "text",
		success : function(token){
			/*startDateTimer = new Date();
			startTimer();
			$('#sktPleaseWait').modal('hide');
			$('.notesBlock textarea[name="ticket_notes"]').val('');
			$("#hold_interval").val('00:00:00');
			$("#hold_reason_count").val('0');
			$("#hold_reason").val('');
			
			$("#hold_interval_notes").val('00:00:00');
			$("#hold_reason_count_notes").val('0');
			$("#hold_reason_notes").val('');
			$('.notesSectionShow').append(token);*/
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
		},
		error : function(token){
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
			//$('#sktPleaseWait').modal('hide');
			//alert('Something Went Wrong!');
		}
	});
});


$('.replySubmissionMove').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.ticketFormReply input[name="ticket_no"]').val();
	mailing_from = $('#mailing_from option:selected').val();
	time_interval_notes = $('.ticketFormReply input[name="time_interval"]').val();
	ticket_notes = "";
	hold_interval_notes = $('.ticketFormReply input[name="hold_interval"]').val();
	hold_reason_count_notes = $('.ticketFormReply input[name="hold_reason_count"]').val();
	hold_reason_notes = $('.ticketFormReply input[name="hold_reason"]').val();
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('legal/ticket_mark_close_reply'); ?>",
		type: "POST",
		data: { ticket_no : ticket_no, time_interval : time_interval_notes, message_body : ticket_notes, hold_interval : hold_interval_notes, hold_reason_count : hold_reason_count_notes, hold_reason : hold_reason_notes , mailing_from:mailing_from },
		dataType: "text",
		success : function(token){
			/*startDateTimer = new Date();
			startTimer();
			$('#sktPleaseWait').modal('hide');
			$('.notesBlock textarea[name="ticket_notes"]').val('');
			$("#hold_interval").val('00:00:00');
			$("#hold_reason_count").val('0');
			$("#hold_reason").val('');
			
			$("#hold_interval_notes").val('00:00:00');
			$("#hold_reason_count_notes").val('0');
			$("#hold_reason_notes").val('');
			$('.notesSectionShow').append(token);*/
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
		},
		error : function(token){
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
			//$('#sktPleaseWait').modal('hide');
			//alert('Something Went Wrong!');
		}
	});
});


// $('.forwardSubmission').click(function(){
// 	alert(11);
// 	$('#modalForwardEmail').modal('show');
// });
function forward_submission(){
		// alert('ggg');
		$('#modalForwardEmail').modal('show');
	}
function mailForwardSubmission(){
	// alert('button hit');
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.reply_form input[name="ticket_no"]').val();
	forward_to = $('#modalForwardEmail input[name="forward_email_id"]').val();
	mailing_cc = $('#modalForwardEmail input[name="mailing_cc"]').val();
    mailing_text = $('#modalForwardEmail #mytextarea_neww').val();
	mailing_to = $('.reply_form input[name="mailing_to"]').val();
	mailing_subject=  $('#mailing_subject').val();   
	mailing_body=  $('#moreInfoEditor2').val(); 
	// alert(mailing_subject);
	// alert(mailing_body);


	
	

	// mailing_cc = $('.ticketFormReply input[name="mailing_cc"]').val();
	// // mailing_subject = $('.ticketFormReply input[name="mailing_subject"]').val();
	// time_interval_notes = $('.ticketFormReply input[name="time_interval"]').val();
	// // ticket_notes = CKEDITOR.instances['moreInfoEditor'].getData();
	// // ticket_last = CKEDITOR.instances['moreInfoEditor2'].getData();
	// hold_interval_notes = $('.ticketFormReply input[name="hold_interval"]').val();
	// hold_reason_count_notes = $('.ticketFormReply input[name="hold_reason_count"]').val();
	// hold_reason_notes = $('.ticketFormReply input[name="hold_reason"]').val();
	// alert('base_url'+baseURL);
	// alert('ticket_no'+ticket_no);
	// alert('forward_to'+forward_to);
	// alert('mailing_to'+mailing_to);
	// // alert('mailing_cc'+mailing_cc);
	// alert('mailing_subject'+mailing_subject);
	// alert('time_interval_notes'+time_interval_notes);
	// alert('hold_interval_notes'+hold_interval_notes);
	// alert('hold_reason_count_notes'+hold_reason_count_notes);
	// alert('hold_reason_notes'+hold_reason_notes);
	
	if (typeof(forward_to) === "undefined") {
		forward_to=$('#forward_email_id option:selected').val();

	}
	
	if(forward_to != ""){
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('legal_manual/ticket_forward_reply'); ?>",
			type: "POST",
			data: { ticket_no : ticket_no, mailing_to : mailing_to, mailing_cc : mailing_cc, mailing_subject : mailing_subject, forward_to : forward_to,message_body_trail:mailing_body,mailing_text:mailing_text
			},
			dataType: "text",
			success : function(token){
				notReply = 1;
				$('#sktPleaseWait').modal('hide');
			},
			error : function(token){
				notReply = 1;
				$('#sktPleaseWait').modal('hide');
			}
		});
	} else {
		alert('Please Fill Up All Details!');
	}
}

$('.mailForwardSubmission').click(function(){
	// alert(22222222);
	// baseURL = "<?php echo base_url(); ?>";
	// alert(baseURL);
	// ticket_no = $('.ticketFormReply input[name="ticket_no"]').val();
	// forward_to = $('#modalForwardEmail input[name="forward_email_id"]').val();
	// mailing_to = $('.ticketFormReply input[name="mailing_to"]').val();
	// mailing_cc = $('.ticketFormReply input[name="mailing_cc"]').val();
	// mailing_subject = $('.ticketFormReply input[name="mailing_subject"]').val();
	// time_interval_notes = $('.ticketFormReply input[name="time_interval"]').val();
	// ticket_notes = CKEDITOR.instances['moreInfoEditor'].getData();
	// ticket_last = CKEDITOR.instances['moreInfoEditor2'].getData();
	// hold_interval_notes = $('.ticketFormReply input[name="hold_interval"]').val();
	// hold_reason_count_notes = $('.ticketFormReply input[name="hold_reason_count"]').val();
	// hold_reason_notes = $('.ticketFormReply input[name="hold_reason"]').val();
	
	// if (typeof(forward_to) === "undefined") {
	// 	forward_to=$('#forward_email_id option:selected').val();

	// }
	
	// if(forward_to != ""){
	// 	$('#sktPleaseWait').modal('show');
	// 	$.ajax({
	// 		url: "<?php echo base_url('legal/ticket_forward_reply'); ?>",
	// 		type: "POST",
	// 		data: { ticket_no : ticket_no, time_interval : time_interval_notes, message_body : ticket_notes, hold_interval : hold_interval_notes, hold_reason_count : hold_reason_count_notes, hold_reason : hold_reason_notes,
	// 			message_body_trail :  ticket_last, mailing_to : mailing_to, mailing_cc : mailing_cc, mailing_subject : mailing_subject, forward_to : forward_to
	// 		},
	// 		dataType: "text",
	// 		success : function(token){
	// 			/*startDateTimer = new Date();
	// 			startTimer();
	// 			$('#sktPleaseWait').modal('hide');
	// 			$('.notesBlock textarea[name="ticket_notes"]').val('');
	// 			$("#hold_interval").val('00:00:00');
	// 			$("#hold_reason_count").val('0');
	// 			$("#hold_reason").val('');
				
	// 			$("#hold_interval_notes").val('00:00:00');
	// 			$("#hold_reason_count_notes").val('0');
	// 			$("#hold_reason_notes").val('');
	// 			$('.notesSectionShow').append(token);*/
	// 			notReply = 1;
	// 			$('#sktPleaseWait').modal('hide');
	// 			//window.location.reload();
	// 		},
	// 		error : function(token){
	// 			notReply = 1;
	// 			$('#sktPleaseWait').modal('hide');
	// 			//window.location.reload();
	// 			//$('#sktPleaseWait').modal('hide');
	// 			//alert('Something Went Wrong!');
	// 		}
	// 	});
	// } else {
	// 	alert('Please Fill Up All Details!');
	// }
});

<?php } ?>

<?php if(!empty($show_close_confirm)){ ?>
<?php if(get_user_id() != 1 && get_user_id() != '8347'){ ?>
$(document).ready(function()
{
    $(window).bind("beforeunload", function() { 
        currentTicket = $('.ticketFormReply input[name="ticket_no"]').val();
        currentTime = $('.ticketFormReply #time_interval').val();
        currentHold = $('.ticketFormReply #hold_interval').val();
		if(notReply == 0){
		$.ajax({
			url: "<?php echo base_url('legal/ticket_add_auto_close_logs'); ?>",
			type: "POST",
			data: { ticket_no : currentTicket, time_interval : currentTime, ticket_hold : currentHold },
			dataType: "text",
			success : function(token){
				startDateTimer = new Date();
				startTimer();
			},
			error : function(token){
			}
		});
		return ('Are you sure you want to close ?');
		}
    });
});
<?php } ?>
<?php } ?>

$('#start_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2021:' + new Date().getFullYear().toString() });
$('#end_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2021:' + new Date().getFullYear().toString() });

$('.dropdownCapture').on('change', 'select[name="sort_list_category"]', function(){
	sortSelection = $(this).val();
	sortemailID = "<?php echo !empty($email_id) ? $email_id : ''; ?>";
	if(sortemailID != "" && sortSelection != "")
	{
		$.ajax({
			url: "<?php echo base_url('legal/ticket_sort_list_update_ajax_group'); ?>",
			type: "GET",
			data: { sort_type : sortSelection, email_id : sortemailID,  },
			dataType: "text",
			success : function(token){
				window.location.reload();
			},
			error : function(token){
				//alert('Something Went Wrong!');
			}
		});		
	}	
});
$('.moveEmail').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('bURL');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: eidVal,
		type: "GET",
		//data: { eid : eidVal },
		dataType: "text",
		success : function(token){
			$('#sktPleaseWait').modal('hide');		
			$('#modalCronEmailMessage .modalBodyCronMessage').html('Email Move Successfully');
			$('#modalCronEmailMessage').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});



</script>

<script>
	// $(document).ready(function() {
	// 	$("#first_ticket").click(function() {
	// 		// $(".check_widget").show();
	// 		$(".check_widget").toggle(this.checked);
	// 	});
	// });
</script>













<!--- legal analytical  related ---->



<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
//$("#select_start_date").datepicker({    changeMonth: true,    changeYear: true,    showButtonPanel: true,    dateFormat: "mm/dd/yyyy"});// addedby sougata
//$("#select_end_date").datepicker({    changeMonth: true,    changeYear: true,    showButtonPanel: true,    dateFormat: "mm/dd/yyyy"}); / addedby sougata

// $('#select_start_date').datepicker();
// $('#select_end_date').datepicker();

</script>






<?php if(!empty($graph_type) && $graph_type == "overview"){ ?>

<script type="text/javascript">

//=======================================================================================================//
//	 MAIL BOX OVERVIEW
//======================================================================================================//

//====== MAIL BOX CHART
  google.charts.load('current', {packages:["orgchart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
	var options = {
	  allowHtml: true,
	};
	
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Mail Box');
	data.addColumn('string', 'Info');
	data.addColumn('string', 'ToolTip');
	
	data.addRows([
	 [{'v':'Mail Box', 'f':'Mail Box<div style="color:#d3ffbc;">Legal  CRM</div>'},
	   '', 'Mail Box - EMAT CRM'],
	<?php foreach($category_list as $token){ ?>
	  [{'v':'<?php echo $token['email_id']; ?>', 'f':'<?php echo $token['email_name']; ?><div style="color:black; font-style:italic"><?php echo $token['email_id']; ?></div>'},
	   'Mail Box', '<?php echo $token['email_id']; ?>'],
	<?php } ?>
	]);
	
	data.setRowProperty(0, 'style', 'background-color: rgb(225 134 134);background-image:none;border: 0px solid #e3ca4b;color: #fff;');
	
	<?php $sl=0; foreach($category_list as $token){ ?>
	data.setRowProperty(<?php echo ++$sl; ?>, 'style', 'background-color: rgb(232 237 209);background-image:none;border: 0px solid rgb(227, 202, 75);color: rgb(32 102 70);font-weight: 600;padding: 6px 10px;');
	<?php } ?>
	
	var chart = new google.visualization.OrgChart(document.getElementById('g_email_box'));
	chart.draw(data, options);
  }
  
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(skillChart_all);
  function skillChart_all() {
	var data = google.visualization.arrayToDataTable([
	  ['Mail Box', 'Executives'],
	  <?php 
	  foreach($category_list as $elist){ 
		$counterSkill = !empty($skillsAllArray[$elist['id']]) ? $skillsAllArray[$elist['id']] : 0;
	  ?>
	  ['<?php echo $elist['email_name'] ." (" .$counterSkill .")"; ?>',  <?php echo $counterSkill; ?>],
	  <?php } ?>
	]);
	var options = {
	  title: 'Executives Skilled Overall',
	  is3D: true,
      pieSliceText:'label',
      sliceVisibilityThreshold :0
	};
	var chart = new google.visualization.PieChart(document.getElementById('g_skill_box_all'));
	chart.draw(data, options);
  }
  
  
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(tikcetChart_all);
	function tikcetChart_all() {
	  var data = google.visualization.arrayToDataTable([
		['Mail Box', 'Tickets'],
		<?php 
		foreach($category_list as $elist){ 
		$counterSkill = !empty($allTickets[$elist['email_id']]) ? $allTickets[$elist['email_id']]['counter'] : 0;
		?>
		['<?php echo $elist['email_name'] ." (" .$counterSkill .")"; ?>',  <?php echo $counterSkill; ?>],
		<?php } ?>
	  ]);

	  var options = {
		title: 'Tickets Overview',
		chartArea: {width: '100%'},
		hAxis: {
		  title: 'Total Tickets',
		  minValue: 0,
		},
	  };
	  var chart = new google.visualization.ColumnChart(document.getElementById('g_ticket_box_all'));
	  chart.draw(data, options);
	}


<?php foreach($category_list as $mailBOX){ ?>

//====== MAIL BOX CATEGORY
  google.charts.load('current', {packages:["orgchart"]});
  google.charts.setOnLoadCallback(drawChart_<?php echo $mailBOX['id']; ?>);
  function drawChart_<?php echo $mailBOX['id']; ?>() {
	var options = {
	  allowHtml: true,
	};
	
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Mail Box');
	data.addColumn('string', 'Info');
	data.addColumn('string', 'ToolTip');
	
	data.addRows([
	 [{'v':'<?php echo $mailBOX['email_id']; ?>', 'f':'<?php echo $mailBOX['email_name']; ?><div style="color:#357215;"><?php echo $mailBOX['email_id']; ?></div>'},
	   '', '<?php echo $mailBOX['email_id']; ?>'],
	<?php foreach($categroyArray[$mailBOX['id']] as $elist){ ?>
	  [{'v':'<?php echo $elist['category_name']; ?>', 'f':'<?php echo $elist['category_name']; ?><div style="color:black; font-style:italic"><?php echo $elist['category_code']; ?></div>'},
	   '<?php echo $elist['email_id']; ?>', '<?php echo $elist['category_code']; ?>'],
	<?php } ?>
	]);
	
	data.setRowProperty(0, 'style', 'background-color: rgb(132 218 219);background-image:none;border: 0px solid rgb(227, 202, 75);color: rgb(33 77 5);padding: 10px 20px;font-size: 12px;font-weight: 600;');
	
	
	var chart = new google.visualization.OrgChart(document.getElementById('g_email_box_<?php echo $mailBOX['id']; ?>'));
	chart.draw(data, options);
  }
  
   
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(skillChart_<?php echo $elist['id']; ?>);
  function skillChart_<?php echo $elist['id']; ?>() {
	var data = google.visualization.arrayToDataTable([
	  ['Category', 'Executives'],
	  <?php 
	  foreach($categroyArray[$mailBOX['id']] as $elist){ 
		$counterSkill = !empty($skillsArray[$elist['id']]) ? count($skillsArray[$elist['id']]) : 0;
	  ?>
	  ['<?php echo $elist['category_name'] ." (" .$counterSkill .")"; ?>',  <?php echo $counterSkill; ?>],
	  <?php } ?>
	]);
	var options = {
	  title: 'Executives Skilled On <?php echo $mailBOX['email_name']; ?>',
	  is3D: true,
      pieSliceText:'label',
      sliceVisibilityThreshold :0
	};
	var chart = new google.visualization.PieChart(document.getElementById('g_skill_box_<?php echo $mailBOX['id']; ?>'));
	chart.draw(data, options);
  }
  
  
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(tikcetChart_<?php echo $elist['id']; ?>);
	function tikcetChart_<?php echo $elist['id']; ?>() {
	  var data = google.visualization.arrayToDataTable([
		['Mail Box', 'Tickets'],
		<?php 
		foreach($categroyArray[$mailBOX['id']] as $elist){ 
		$counterSkill = !empty($allTicketsCat[$elist['category_code']]) ? $allTicketsCat[$elist['category_code']]['counter'] : 0;
		?>
		['<?php echo $elist['category_name'] ." (" .$counterSkill .")"; ?>',  <?php echo $counterSkill; ?>],
		<?php } ?>
	  ]);

	  var options = {
		title: 'Tickets Overview',
		chartArea: {width: '100%'},
		hAxis: {
		  title: 'Total Tickets',
		  minValue: 0,
		},
	  };
	  var chart = new google.visualization.ColumnChart(document.getElementById('g_ticket_box_<?php echo $mailBOX['id']; ?>'));
	  chart.draw(data, options);
	}
  
  
<?php } ?>  
  
  
</script>


<?php } ?>


<?php if(!empty($graph_type) && $graph_type == "overview_tickets"){ ?>

<script type="text/javascript">

//=======================================================================================================//
//	 OVERVIEW TICKETS
//======================================================================================================//

	<?php	
	$current_dataSet = $tickets_daily['start']['data'];
	$daysArrayNames = array_keys($current_dataSet);
	$daysArrayValues = array_values($current_dataSet);
	
	$current_dataSet = $assigned_daily['start']['data'];
	$daysArrayNames = array_keys($current_dataSet);
	$assignArrayValues = array_values($current_dataSet);
	
	$current_dataSet = $completed_daily['start']['data'];
	$daysArrayNames = array_keys($current_dataSet);
	$completedArrayValues = array_values($current_dataSet);
	
	?>
	var ctxBAR = document.getElementById("o_ticket_daily");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
		
		data: {
		  labels: ["<?php echo implode('","', $daysArrayNames); ?>"],
		  datasets: [
			{
			  type: 'bar',
			  label: "Tickets Added",
			  data: [
			  <?php echo implode(',', $daysArrayValues); ?>			
			  ],
			  backgroundColor: "#3b809b",
			  borderColor: '#152c9a',
			  borderWidth: 3
			},
			/*{
			  type: 'line',
			  label: "Tickets Assigned",
			  data: [
			  <?php echo implode(',', $assignArrayValues); ?>			
			  ],
			  //backgroundColor: "#b5ffb8",
			  borderColor: '#e60606',
			  borderWidth: 3,
			  datalabels : {
				  display: false
			  }
			},*/
			{
			  type: 'line',
			  label: "Tickets Closed",
			  data: [
			  <?php echo implode(',', $completedArrayValues); ?>			
			  ],
			  //backgroundColor: "#b5ffb8",
			  borderColor: '#239a15',
			  borderWidth: 3,
			  datalabels : {
				  display: false
			  }
			}
		  ]
		},	
		options: {
		  legend: { display: true, position: 'bottom',labels: { padding: 50 } },
		  title: {
			display: true,
			lineHeight: 4,
			text: "Ticket Overview - <?php echo date('d M, Y', strtotime($start_date_full)) ." - " . date('d M, Y', strtotime($end_date_full)); ?>"
		  },
		  tooltips: {
			callbacks: {
			   label: function(tooltipItem) {
					  return tooltipItem.yLabel + '';
			   }
			}
		  },
		  maintainAspectRatio: false,
		  responsive: true,
		  scales: {
			   xAxes: [{
				//gridLines: { color: "rgba(0, 0, 0, 0)", }			
			  }],
			  yAxes: [{
				display:true,
				//gridLines: { color: "rgba(0, 0, 0, 0)", },
				ticks: {
				  callback: function(value, index, values) {
						return value + '';
				  },
				  beginAtZero: false,
				}
			  }]
			},
		  plugins: {
		  datalabels: {
			anchor: 'end',
			align: 'top',
			formatter: (value, ctx) => {
				return value + '';
			},
			font: {
			  size:9,
			  weight: 'bold'
			}
		  }
		  }	
		},
		
	});
		
	google.charts.load("current", {packages:["corechart", "bar"]});
	google.charts.setOnLoadCallback(o_ticket_all);
	function o_ticket_all() {
		var data = google.visualization.arrayToDataTable([
			['Mail Box', 'Executives'],
			<?php 
			$counterEmails = array();
			$dataEmails = array();
			foreach($category_list as $elist){ 
				$counterSkill = !empty($ticketsEmails[$elist['email_id']]) ? count($ticketsEmails[$elist['email_id']]) : 0;
				$counterEmails[$elist['email_id']] = $counterSkill;
				$dataEmails[$elist['email_id']] = $elist;
			}
			arsort($counterEmails);
			foreach($counterEmails as $key=>$counterSkill){
				$elist = $dataEmails[$key];
			?>
			['<?php echo $elist['email_name'] ." (" .$counterSkill .")"; ?>',  <?php echo $counterSkill; ?>],
			<?php } ?>
		]);
		var options = {
			title: 'Mail Box Tickets',
			chartArea: {width: '50%'},
			hAxis: {
			  minValue: 0,
			},
			legend: {position: 'none'}
		};
		var chart = new google.visualization.BarChart(document.getElementById('o_ticket_all'));
		chart.draw(data, options);
	}
	
	
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(o_ticket_classified_all);
	function o_ticket_classified_all() {
		var data = google.visualization.arrayToDataTable([
			['Classification', 'Count'],
			['<?php echo "Tickets Open (" .count($ticketsOpen) .")"; ?>',  <?php echo count($ticketsOpen); ?>],
			//['<?php echo "Breached (" .count($ticketsBreached) .")"; ?>',  <?php echo count($ticketsBreached); ?>],
			['<?php echo "Tickets Closed (" .count($ticketsClosed) .")"; ?>',  <?php echo count($ticketsClosed); ?>],
		]);
		var options = {
			title: 'Mail Box Tickets',
			chartArea: {width: '100%', height:'100%'},
			is3D: true,
			pieSliceText:'value',
			sliceVisibilityThreshold :0,
			colors: ['#ff5252','#28eb86'],
			//slices: {  1: {offset: 0.2}, },
			//legend: { position: 'none' }
		};
		var chart = new google.visualization.PieChart(document.getElementById('o_ticket_classified_all'));
		chart.draw(data, options);
	}
	
	
	var ctxPIE  = document.getElementById("o_ticket_analytics_all_open");
	var o_ticket_analytics_all_open = new Chart(ctxPIE, {
	  type: 'pie',
	  data: {
		labels: [
		'<?php echo "Unassigned (" .count($ticketsPending) .")"; ?>', '<?php echo "Assigned (" .count($ticketsAssigned) .")"; ?>', '<?php echo "SLA Breached (" .count($ticketsBreached) .")"; ?>'
		],
		datasets: [
		 { 
			data: [
			<?php echo count($ticketsPending); ?>,<?php echo count($ticketsAssigned); ?>,<?php echo count($ticketsBreached); ?>
			],
			label: "Analytics",
			backgroundColor: ["#074676", "#f8919f", "#eb1212"],
		 }
		]
	  },
	  options: {
		legend: { display: true, position: 'right', },
		title: {
		  display: true,
		  text: "Open Tickets Overview"
		},
		tooltips: {
			callbacks: {
			label: function(tooltipItem, data) { 
				var indice = tooltipItem.index;                 
				return  data.labels[indice];
			}
			}
		 },
		  maintainAspectRatio: false,
		  responsive: true,
		  plugins: {
		  datalabels: {
			  color: '#ffffff',
			font: {
			  weight: 'bold'
			}
		  }
		  }	
	  }
	});
	
	
	var ctxPIE  = document.getElementById("o_ticket_analytics_all_closed");
	var o_ticket_analytics_all_closed = new Chart(ctxPIE, {
	  type: 'pie',
	  data: {
		labels: [
		'<?php echo "SLA Breached (" .count($ticketsBreachedClosed) .")"; ?>', '<?php echo "Within SLA (" .(count($ticketsClosed) - count($ticketsBreachedClosed)) .")"; ?>'
		],
		datasets: [
		 { 
			data: [
			<?php echo count($ticketsBreachedClosed); ?>,<?php echo count($ticketsClosed) - count($ticketsBreachedClosed); ?>
			],
			label: "Analytics",
			backgroundColor: ["#eb1212", "#3cc047", "#f5f0ca"],
		 }
		]
	  },
	  options: {
		legend: { display: true, position: 'right', },
		title: {
		  display: true,
		  text: "Closed Tickets Overview"
		},
		tooltips: {
			callbacks: {
			label: function(tooltipItem, data) { 
				var indice = tooltipItem.index;                 
				return  data.labels[indice];
			}
			}
		 },
		  maintainAspectRatio: false,
		  responsive: true,
		  plugins: {
		  datalabels: {
			  color: '#ffffff',
			font: {
			  weight: 'bold'
			}
		  }
		  }	
	  }
	});
	
	
</script>
 
<?php } ?>  
  
  
<?php if(!empty($graph_type) && $graph_type == "overview_agents"){ ?>

<script type="text/javascript">

//=======================================================================================================//
//	 OVERVIEW TICKETS
//======================================================================================================//

	<?php	
	arsort($all_agentsCount);
	$agentNames = array();
	$agentValues = array();
	$counter = 0;
	foreach($all_agentsCount as $key=>$val){
		$agentNames[] = $all_agentsList[$key]['agent_name'];
		$agentValues[] = $val;
		if($counter++ > 25){ continue; }
	}
	?>
	var ctxBAR = document.getElementById("o_ticket_daily");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
		type: 'bar',
		data: {
		  labels: ["<?php echo implode('","', $agentNames); ?>"],
		  datasets: [
			{			  
			  label: "Executives Assigned",
			  data: [
			  <?php echo implode(',', $agentValues); ?>			
			  ],
			  backgroundColor: "#3b809b",
			  borderColor: '#152c9a',
			  borderWidth: 3
			},
		  ]
		},	
		options: {
		  legend: { display: false, position: 'bottom',labels: { padding: 50 } },
		  title: {
			display: true,
			lineHeight: 4,
			text: "Executive Overview - <?php echo date('d M, Y', strtotime($start_date_full)) ." - " . date('d M, Y', strtotime($end_date_full)); ?>"
		  },
		  tooltips: {
			callbacks: {
			   label: function(tooltipItem) {
					  return tooltipItem.yLabel + '';
			   }
			}
		  },
		  maintainAspectRatio: false,
		  responsive: true,
		  scales: {
			   xAxes: [{
				//gridLines: { color: "rgba(0, 0, 0, 0)", }			
			  }],
			  yAxes: [{
				display:true,
				//gridLines: { color: "rgba(0, 0, 0, 0)", },
				ticks: {
				  callback: function(value, index, values) {
						return value + '';
				  },
				  beginAtZero: true,
				}
			  }]
			},
		  plugins: {
		  datalabels: {
			anchor: 'end',
			align: 'top',
			formatter: (value, ctx) => {
				return value + '';
			},
			font: {
			  size:9,
			  weight: 'bold'
			}
		  }
		  }	
		},
		
	});
	
	
	<?php	
	arsort($all_agentsCount);
	$agentNames = array();
	$agentValues = array();
	$counter = 0;
	foreach($ticketListAHT as $token){
		$agentNames[] = $token['agent_name'] ."(" .$token['total_seconds_aht'].")";
		$agentValues[] = $token['total_seconds'];
		if($counter++ > 25){ continue; }
	}
	?>
	var ctxPIE  = document.getElementById("o_ticket_daily_all");
	var o_ticket_analytics_all_open = new Chart(ctxPIE, {
	  type: 'pie',
	  data: {
		labels: [
		"<?php echo implode('","', $agentNames); ?>"
		],
		datasets: [
		 { 
			data: [
			<?php echo implode(',', $agentValues); ?>
			],
			label: "Analytics",
			backgroundColor: ["#074676", "#f8919f", "#eb1212"],
		 }
		]
	  },
	  options: {
		legend: { display: true, position: 'right', },
		title: {
		  display: true,
		  text: "Executive AHT Overview"
		},
		tooltips: {
			callbacks: {
			label: function(tooltipItem, data) { 
				var indice = tooltipItem.index;                 
				return  data.labels[indice];
			}
			}
		 },
		  maintainAspectRatio: false,
		  responsive: true,
		  plugins: {
		  datalabels: {
			  color: '#ffffff',
			font: {
			  weight: 'bold'
			}
		  }
		  }	
	  }
	});
	
</script>

<?php } ?>