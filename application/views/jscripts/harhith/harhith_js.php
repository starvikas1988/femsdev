<?php if(!empty($is_show_table) && $is_show_table == 1){ ?>
<!--<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>-->
<script src="<?php echo base_url() ?>assets/harhith/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/datatable/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/datatable/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/datatable/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/datatable/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/datatable/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/harhith/datatable/buttons.print.min.js"></script>

<script>
$('#datatable-check').DataTable({
	"pageLength":50,
	dom: 'Bfrtip',
	buttons: [
	  'excel',
	   {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'TABLOID',
            footer: true,
        }
	  
	],
	"ordering": false,
});
</script>
<?php } ?>


<script>
$('.singleSelect').select2();


$('.captcha-refresh').on('click', function(){
   $.get('<?php echo hth_url('CaptchaRefresh'); ?>', function(data){
	   $('#image_captcha').html(data);
   });
});

$('.verify_captcha').on('click', function(){
   if($('#complaintEnquiryFrm')[0].checkValidity()){
	   
	   // CAPTCHA VALIDATION
	   captchaValidation = 0;
	   userCaptcha = $('.captchaDIV input[name="captcha"]').val();
	   if(userCaptcha != ""){
		   $.ajax({
				url: "<?php echo hth_url('captcha_verify'); ?>",
				type: "POST",
				data: { captcha : userCaptcha },
				dataType: "text",
				success : function(jsonData){		
					if(jsonData == "success"){
						captchaValidation = 1;
						$('#complaintEnquiryFrm').submit();
					} else {
						$.get('<?php echo hth_url('CaptchaRefresh'); ?>', function(dataCap){
						   $('#image_captcha').html(dataCap);
					    });
						alert("Captcha Mismatch! Please Try Again!");						
					}
				},
				error : function(jsonData){
					alert('Something Went Wrong!');
				}
			});		   
	   } else {
			alert("Please Enter Captcha!");
	   }
	   
   } else {
	   $("#complaintEnquiryFrm")[0].reportValidity();
   }
});


$('.verify_captcha_search').on('click', function(){
   if($('#searchTicketForm')[0].checkValidity()){
	   
	   // CAPTCHA VALIDATION
	   captchaValidation = 0;
	   userCaptcha = $('.captchaDIV input[name="captcha"]').val();
	   if(userCaptcha != ""){
		   $.ajax({
				url: "<?php echo hth_url('captcha_verify'); ?>",
				type: "POST",
				data: { captcha : userCaptcha },
				dataType: "text",
				success : function(jsonData){		
					if(jsonData == "success"){
						captchaValidation = 1;
						$('#searchTicketForm').submit();
					} else {
						$.get('<?php echo hth_url('CaptchaRefresh'); ?>', function(dataCap){
						   $('#image_captcha').html(dataCap);
					    });
						alert("Captcha Mismatch! Please Try Again!");						
					}
				},
				error : function(jsonData){
					alert('Something Went Wrong!');
				}
			});		   
	   } else {
			alert("Please Enter Captcha!");
	   }
	   
   } else {
	   $("#searchTicketForm")[0].reportValidity();
   }
});


$('.formRow').on('change', 'select[name="d_role_id"]', function(){
	curVal = $(this).val();
	if(curVal == "stakeholder"){
		$(this).closest('.formRow').find('select[name="d_department_id"]').val('');
		$(this).closest('.formRow').find('select[name="d_department_id"]').attr('required', 'required');
		$(this).closest('.formRow').find('.departmentSelect').show();
	} else {
		$(this).closest('.formRow').find('select[name="d_department_id"]').val('');
		$(this).closest('.formRow').find('select[name="d_department_id"]').removeAttr('required');
		$(this).closest('.formRow').find('.departmentSelect').hide();
	}	
});


$('.assignTicket').click(function(){
	tid = $(this).attr('tid');
	$('#assignTicketsModal input[name="ticket_no"]').val(tid);	
	$('#assignTicketsModal').modal('show');
});

$('.numberCheckPhone').keyup(function(){
	curVal = $(this).val();
	if(curVal != "" && (curVal.charAt(0)=='6' || curVal.charAt(0)=='7' || curVal.charAt(0)=='8' || curVal.charAt(0)=='9')){		
	} else {
		$(this).val('');
	}
});

$('.nameCheckPhone').keyup(function(){
	curVal = $(this).val();
	if(curVal != "" && (curVal.charAt(0)==' ')){
			$(this).val('');
	}
});

$('.capitalCheckText').keyup(function(){
	curVal = $(this).val();
	if(curVal != "" && (curVal.charAt(0)==' ')){
			$(this).val('');
	} else {
	if(curVal != ""){
		val = curVal.substr(0, 1).toUpperCase() + curVal.substr(1);
		$(this).val(val);
	}
	}
});
		
$('[data-mask]').inputmask();


$('.searchTicketButton').click(function(){
	ticketNo = $(this).closest('.searchBodyDiv').find('input[name="search_ticket"]').val();
	phonetNo = $(this).closest('.searchBodyDiv').find('input[name="search_phone"]').val();
	error = 0;
	if(ticketNo != "" &&  ticketNo.length < 5){
		error = 1;
	}
	if(phonetNo != "" &&  phonetNo.length < 5){
		error = 2;
	}
	if(error > 0){
		alert("Please Enter Atleast 5 Characters");
	} else {
		 $('#searchTicketForm').submit();
	}
});

<?php if(!empty($page_type) && $page_type == "ticket_entry" && !empty($ticket_success_no)){ ?>
$('#finalTicketNo').html('<?php echo $ticket_success_no; ?>');
$('#finalTicketCall').html('<?php echo !empty($ticket_details) ? $ticket_details[0]['call_type_name'] : ""; ?>');
$('#successTicketsModal').modal('show');
<?php } ?>

<?php if(!empty($this->uri->segment(3)) && $this->uri->segment(3) == "error"){ ?>
$('#errorTicketsModal').modal('show');
<?php } ?>

$('#assignTicketsModal').on('change','select[name="select_department"]', function(){
	did = $(this).val();
	var html = '<option value="">-- Select User --</option>';
	$('#assignTicketsModal select[name="select_user"]').html(html);
	$.ajax({
		url: "<?php echo hth_url('department_user_ajax'); ?>",
		type: "GET",
		data: { did : did },
		dataType: "json",
		success : function(jsonData){		
			var html = '<option value="">-- Select User --</option>';
			cn = 0;
			$(jsonData).each(function(key, token){
				cn = cn + 1;
				html += '<option value="'+token.id+'">'+token.fname + ' ' + token.lname +'</option>';
			});
			if(cn == 0){
				var html = '<option value="">-- No Users Found --</option>';
			}
			$('#assignTicketsModal select[name="select_user"]').html(html);
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});

$('#assignTicketsModal').on('change','select[name="select_department_sub"]', function(){
	did = $(this).val();
	var html = '<option value="">-- Select Department --</option>';
	var html2 = '<option value="">-- No Users --</option>';
	$('#assignTicketsModal select[name="select_department"]').html(html);
	$('#assignTicketsModal select[name="select_user"]').html(html2);
	$.ajax({
		url: "<?php echo hth_url('department_sub_ajax'); ?>",
		type: "GET",
		data: { did : did },
		dataType: "json",
		success : function(jsonData){		
			var html = '<option value="">-- Select Department --</option>';
			cn = 0;
			$(jsonData).each(function(key, token){
				cn = cn + 1;
				html += '<option value="'+token.id+'">'+token.name +'</option>';
			});
			if(cn == 0){
				var html = '<option value="">-- No Department Found --</option>';
			}
			$('#assignTicketsModal select[name="select_department"]').html(html);
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});

$('.replyTicket').click(function(){
	tid = $(this).attr('tid');
	$('#replyTicketsModal input[name="ticket_no"]').val(tid);	
	$('#replyTicketsModal').modal('show');
});

$('.commentTicket').click(function(){
	tid = $(this).attr('tid');
	$('#commentTicketModal input[name="ticket_no"]').val(tid);	
	$('#commentTicketModal textarea[name="select_remarks"]').val('');	
	$('#commentTicketModal').modal('show');
});

$('#commentTicketModal .commentTicketModalSubmit').click(function(){
	ticketNo = $('#commentTicketModal input[name="ticket_no"]').val();
	ticketRemarks = $('#commentTicketModal textarea[name="select_remarks"]').val();	
	$.ajax({
		url: "<?php echo hth_url('add_ticket_comments'); ?>",
		type: "POST",
		data: { 
			ticket_no : ticketNo, 
			log_type : 'comments', 
			log_status : '', 
			log_comments : ticketRemarks, 
			log_remarks : 'Comment', 
			log_reference : '', 
		},
		dataType: "json",
		success : function(jsonData){
			if(jsonData.response == "success"){
				alert('Comments added Successfully!');
				$('#commentTicketModal').modal('hide');
				$('#commentTicketModal textarea[name="select_remarks"]').val('');
			} else {
				$('#commentTicketModal textarea[name="select_remarks"]').val(ticketRemarks);
				alert('Something Went Wrong!');
			}
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});


$('.newTicketEnquiry').on('change','select[name="c_district"]', function(){
	
	did = $('.newTicketEnquiry select[name="c_district"]').val();
	cid = $('.newTicketEnquiry select[name="c_city"]').val();
	pid = $('.newTicketEnquiry select[name="c_postoffice"]').val();
	$('.newTicketEnquiry input[name="c_pincode"]').val('');
	
	// FOR POST OFFICE
	$('.newTicketEnquiry select[name="c_postoffice"]').select2('destroy');
	var html = '<option value="">-- Select --</option>';
	$('.newTicketEnquiry select[name="c_postoffice"]').html(html);
	$.ajax({
		url: "<?php echo hth_url('ajax_location_search'); ?>",
		type: "GET",
		data: { did : did, type : 'postoffice' },
		dataType: "json",
		success : function(jsonData){	
			var html = '<option value="">-- Select PostOffice --</option>';
			cn = 0;
			$.each(jsonData, function(index, value){
				cn = cn + 1;
				html += '<option value="'+value+'">'+value+'</option>';
			});
			if(cn == 0){
				var html = '<option value="">-- No PostOffice Found --</option>';
			}
			$('.newTicketEnquiry select[name="c_postoffice"]').html(html);
			$('.newTicketEnquiry select[name="c_postoffice"]').select2();
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
	
	// FOR CITY
	$('.newTicketEnquiry select[name="c_city"]').select2('destroy');
	var html = '<option value="">-- Select --</option>';
	$('.newTicketEnquiry select[name="c_city"]').html(html);
	$.ajax({
		url: "<?php echo hth_url('ajax_location_search'); ?>",
		type: "GET",
		data: { did : did, type : 'taluk' },
		dataType: "json",
		success : function(jsonData){		
			var html = '<option value="">-- Select City/Taluk --</option>';
			cn = 0;
			$.each(jsonData, function(key, token){
				cn = cn + 1;
				html += '<option value="'+token+'">'+token +'</option>';
			});
			if(cn == 0){
				var html = '<option value="">-- No City/Taluk Found --</option>';
			}
			$('.newTicketEnquiry select[name="c_city"]').html(html);
			$('.newTicketEnquiry select[name="c_city"]').select2();
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});


$('.newTicketEnquiry').on('change','select[name="c_city"]', function(){
	
	did = $('.newTicketEnquiry select[name="c_district"]').val();
	cid = $('.newTicketEnquiry select[name="c_city"]').val();
	pid = $('.newTicketEnquiry select[name="c_postoffice"]').val();
	
	// FOR POST OFFICE
	$('.newTicketEnquiry select[name="c_postoffice"]').select2('destroy');
	var html = '<option value="">-- Select --</option>';
	$('.newTicketEnquiry select[name="c_postoffice"]').html(html);
	$('.newTicketEnquiry input[name="c_pincode"]').val('');
	$.ajax({
		url: "<?php echo hth_url('ajax_location_search'); ?>",
		type: "GET",
		data: { did : did, cid : cid, type : 'postoffice' },
		dataType: "json",
		success : function(jsonData){		
			var html = '<option value="">-- Select PostOffice --</option>';
			cn = 0;
			$.each(jsonData, function(key, token){
				cn = cn + 1;
				html += '<option value="'+token+'">'+token +'</option>';
			});
			if(cn == 0){
				var html = '<option value="">-- No PostOffice Found --</option>';
			}
			$('.newTicketEnquiry select[name="c_postoffice"]').html(html);
			$('.newTicketEnquiry select[name="c_postoffice"]').select2();			
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});


$('.newTicketEnquiry').on('change','select[name="c_postoffice"]', function(){
	
	did = $('.newTicketEnquiry select[name="c_district"]').val();
	cid = $('.newTicketEnquiry select[name="c_city"]').val();
	pid = $('.newTicketEnquiry select[name="c_postoffice"]').val();
	
	// FOR PINCODE
	$.ajax({
		url: "<?php echo hth_url('ajax_location_search'); ?>",
		type: "GET",
		data: { did : did, cid : cid, pid : pid, type : 'pincode' },
		dataType: "json",
		success : function(jsonData){
			$('.newTicketEnquiry input[name="c_pincode"]').val(jsonData.pincode);		
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});

$('.newTicketEnquiry').on('change','select[name="c_reason"]', function(){
	
	crid = $('.newTicketEnquiry select[name="c_reason"]').val();
	$('.newTicketEnquiry select[name="c_sub_reason"]').select2('destroy');
	var html = '<option value="">-- Select Sub Reason --</option>';
	$('.newTicketEnquiry select[name="c_sub_reason"]').html(html);
	$.ajax({
		url: "<?php echo hth_url('master_callsubreason_all_ajax'); ?>",
		type: "GET",
		data: { eid : crid },
		dataType: "json",
		success : function(jsonData){
			var html = '<option value="">-- Select Sub Reason --</option>';
			cn = 0;
			$(jsonData).each(function(key, token){
				cn = cn + 1;
				html += '<option value="'+token.id+'">'+token.name +'</option>';
			});
			if(cn == 0){
				var html = '<option value="">-- No Sub Reason Found --</option>';
			}
			$('.newTicketEnquiry select[name="c_sub_reason"]').html(html);
			$('.newTicketEnquiry select[name="c_sub_reason"]').select2();	
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});


$('.viewTicketInfo').click(function(){	
	tid = $(this).attr('tid');
	$.ajax({
		url: "<?php echo hth_url('view_ticket_info_ajax'); ?>",
		type: "GET",
		data: { ticket_no : tid },
		dataType: "text",
		success : function(jsonData){			
			$('#viewTicketsModal .modal-body').html(jsonData);
			$('#viewTicketsModal').modal('show');
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});


$('.viewTicketLogs').click(function(){	
	tid = $(this).attr('tid');
	$.ajax({
		url: "<?php echo hth_url('view_ticket_log_info_ajax'); ?>",
		type: "GET",
		data: { ticket_no : tid },
		dataType: "text",
		success : function(jsonData){			
			$('#viewTicketsModal .modal-body').html(jsonData);
			$('#viewTicketsModal').modal('show');
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});


$('.editDepartment').click(function(){	
	sid = $(this).attr('sid');
	$('#editModal_department input[name="edit_id"]').val(sid);
	$.ajax({
		url: "<?php echo hth_url('department_ajax'); ?>",
		type: "GET",
		data: { eid : sid },
		dataType: "json",
		success : function(jsonData){
			if(jsonData.response == "success"){
				$('#editModal_department input[name="edit_id"]').val(jsonData.id);
				$('#editModal_department input[name="d_short_name"]').val(jsonData.shname);
				$('#editModal_department input[name="d_full_name"]').val(jsonData.name);
				$('#editModal_department select[name="d_internal_external"]').val(jsonData.sub_info);
				$('#editModal_department select[name="d_status"]').val(jsonData.is_active);
				$('#editModal_department').modal('show');
			} else {
				alert("Somethign Went Wrong!");
			}
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});



$('.editMasterCallType').click(function(){	
	sid = $(this).attr('sid');
	$('#editModal_record input[name="edit_id"]').val(sid);
	$.ajax({
		url: "<?php echo hth_url('master_calltype_ajax'); ?>",
		type: "GET",
		data: { eid : sid },
		dataType: "json",
		success : function(jsonData){
			if(jsonData.response == "success"){
				$('#editModal_record input[name="edit_id"]').val(jsonData.id);
				$('#editModal_record input[name="d_name"]').val(jsonData.name);
				$('#editModal_record select[name="d_status"]').val(jsonData.is_active);
				$('#editModal_record').modal('show');
			} else {
				alert("Somethign Went Wrong!");
			}
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});


$('.editMasterCallAssign').click(function(){	
	sid = $(this).attr('sid');
	$('#editModal_record input[name="edit_id"]').val(sid);
	$.ajax({
		url: "<?php echo hth_url('master_assign_ticket_ajax'); ?>",
		type: "GET",
		data: { eid : sid },
		dataType: "json",
		success : function(jsonData){
			if(jsonData.response == "success"){
				$('#editModal_record input[name="edit_id"]').val(jsonData.id);
				$('#editModal_record select[name="d_calltype"]').val(jsonData.call_type);
				$('#editModal_record select[name="d_reason"]').val(jsonData.contact_reason);
				$('#editModal_record select[name="d_department"]').val(jsonData.department_id);
				$('#editModal_record select[name="d_status"]').val(jsonData.is_active);
				$('#editModal_record').modal('show');
			} else {
				alert("Somethign Went Wrong!");
			}
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});


$('.editMasterDisposition').click(function(){	
	sid = $(this).attr('sid');
	$('#editModal_record input[name="edit_id"]').val(sid);
	$.ajax({
		url: "<?php echo hth_url('master_disposition_ajax'); ?>",
		type: "GET",
		data: { eid : sid },
		dataType: "json",
		success : function(jsonData){
			if(jsonData.response == "success"){
				$('#editModal_record input[name="edit_id"]').val(jsonData.id);
				$('#editModal_record input[name="d_name"]').val(jsonData.name);
				$('#editModal_record select[name="d_status"]').val(jsonData.is_active);
				$('#editModal_record').modal('show');
			} else {
				alert("Somethign Went Wrong!");
			}
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});

$('.editMasterReason').click(function(){	
	sid = $(this).attr('sid');
	$('#editModal_record input[name="edit_id"]').val(sid);
	$.ajax({
		url: "<?php echo hth_url('master_callreason_ajax'); ?>",
		type: "GET",
		data: { eid : sid },
		dataType: "json",
		success : function(jsonData){
			if(jsonData.response == "success"){
				$('#editModal_record input[name="edit_id"]').val(jsonData.id);
				$('#editModal_record input[name="d_name"]').val(jsonData.name);
				$('#editModal_record select[name="d_status"]').val(jsonData.is_active);
				$('#editModal_record').modal('show');
			} else {
				alert("Somethign Went Wrong!");
			}
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});



$('.editMasterSubReason').click(function(){	
	sid = $(this).attr('sid');
	$('#editModal_record input[name="edit_id"]').val(sid);
	$.ajax({
		url: "<?php echo hth_url('master_callsubreason_ajax'); ?>",
		type: "GET",
		data: { eid : sid },
		dataType: "json",
		success : function(jsonData){
			if(jsonData.response == "success"){
				$('#editModal_record input[name="edit_id"]').val(jsonData.id);
				$('#editModal_record input[name="d_name"]').val(jsonData.name);
				$('#editModal_record select[name="c_reason"]').val(jsonData.parent_id);
				$('#editModal_record select[name="d_status"]').val(jsonData.is_active);
				$('#editModal_record').modal('show');
			} else {
				alert("Somethign Went Wrong!");
			}
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});


$('.editMasterClientUser').click(function(){	
	sid = $(this).attr('sid');
	$('#editModal_user input[name="edit_id"]').val(sid);
	$('#editModal_user .departmentSelect').hide();
	$.ajax({
		url: "<?php echo hth_url('master_client_user_ajax'); ?>",
		type: "GET",
		data: { eid : sid },
		dataType: "json",
		success : function(jsonData){
			if(jsonData.response == "success"){
				$('#editModal_user input[name="edit_id"]').val(jsonData.id);
				$('#editModal_user input[name="d_first_name"]').val(jsonData.fname);
				$('#editModal_user input[name="d_last_name"]').val(jsonData.lname);
				$('#editModal_user select[name="d_sex"]').val(jsonData.sex);
				$('#editModal_user input[name="d_phone_no"]').val(jsonData.phno);
				$('#editModal_user select[name="d_role_id"]').val(jsonData.role);
				$('#editModal_user select[name="d_department_id"]').val(jsonData.department_id);
				$('#editModal_user input[name="d_email_id"]').val(jsonData.email_id);
				$('#editModal_user select[name="d_department_id"]').select2();
				$('#editModal_user select[name="d_role_id"]').select2();
				
				if(jsonData.role == "stakeholder"){
					$('#editModal_user .departmentSelect').show();
					$('#editModal_user select[name="d_department_id"]').attr('required', 'required');
				} else {
					$('#editModal_user .departmentSelect').hide();
					$('#editModal_user select[name="d_department_id"]').removeAttr('required', 'required');					
				}				
	
				$('#editModal_user').modal('show');
			} else {
				alert("Somethign Went Wrong!");
			}
		},
		error : function(jsonData){
			alert('Something Went Wrong!');
		}
	});
});



$(".resetPasswordClient").click(function(){
	var cid = $(this).attr("c_id");
	$('#resetPassowrdClientModal input[name="r_cid"]').val('');
	$('#resetPassowrdClientModal input[name="r_cid"]').val(cid);
	$('#resetPassowrdClientModal').modal('show');
});


$(".resetPasswordClientSubmit").click(function(){
	cid = $('#resetPassowrdClientModal input[name="r_cid"]').val();
	newp = $('#resetPassowrdClientModal input[name="r_new_passwd"]').val();
	oldp = $('#resetPassowrdClientModal input[name="r_confirm_passwd"]').val();
	if(newp != "" && oldp != "" && cid != ""){
		if(newp == oldp){
			var URL='<?php echo hth_url('users_client_reset_password'); ?>';
			$.ajax({
			   type: 'POST',    
			   url: URL,
			   data:'r_cid='+ cid+'&r_new_passwd='+ newp+'&r_confirm_passwd='+ oldp,
			   success: function(msg){
					window.location.reload();
				}
			 });
		} else {
			alert('Entered Password Does Not Match!');
		}
	} else {
		alert("Please Enter All Details!");
	}
});
	
	
</script>



<?php if(!empty($is_show_graph) && $is_show_graph == 1){ ?>
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>

//========================================================================
// DEAPRTMENTAL RECORDS
//========================================================================

google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(o_ticket_classified_all);
function o_ticket_classified_all() {
	var data = google.visualization.arrayToDataTable([
		['Classification', 'Count'],
		<?php foreach($department_list as $tokenD){ $_did = $tokenD['id']; ?>
		<?php //foreach($department_counters_pie as $tokenD) { ?>
		['<?php echo $tokenD['name']; ?>',  <?php echo !empty($department_counters_pie_f[$_did]['count']) ? $department_counters_pie_f[$_did]['count'] : "0"; ?>],
		<?php } ?>
	]);
	var options = {
		//title: 'Department Wise Call Volume',
		chartArea: {width: '100%'},
		is3D: true,
		pieSliceText:'value',
		sliceVisibilityThreshold :0,
		//colors: ['#ff5252','#28eb86'],
		//slices: {  1: {offset: 0.2}, },
		legend: { position: 'right' }
	};
	var chart = new google.visualization.PieChart(document.getElementById('o_ticket_deapartment_pie'));
	chart.draw(data, options);
}


//========================================================================
// DAYWISE RECORDS
//========================================================================
<?php 
$currentDate = $to_date;
$resultSet = array(); $departmentArray = array(); $datesGetArray = array(); $valuesArray = array();
for($i=0;$i<=$totalDays;$i++){ 
	$currentDate = date('Y-m-d', strtotime('-'.$i.' day', strtotime($to_date)));
	$departmentArray = array(); $datesArray = array();	
	foreach($department_list as $dlist)
	{
		$deptID = $dlist['id'];
		$departmentArray[] = $dlist['name'];		
		$resultSet[$deptID][$currentDate] = !empty($departmental[$deptID]['date'][$currentDate]) ? count($departmental[$deptID]['date'][$currentDate]) : "0";
		$valuesArray[$deptID][] = $resultSet[$deptID][$currentDate];
	}
	$datesGetArray[] = $currentDate;	
}
//hth_print($datesArray);

$colorsTrek = array("#AF3319","#2319AF","#0D7B18");
$colorsTrek = array("#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff", "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F');

?>
var ctxBAR = document.getElementById("o_ticket_deapartment_fullget");
var myBarChart = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php echo implode($datesGetArray, '","'); ?>"],
	  datasets: [
	  <?php $cn=0; foreach($department_list as $dlist){ $deptID = $dlist['id']; ?>
		{
		  //type: 'line',
		  label: "<?php echo $dlist['name']; ?>",
		  data: [<?php echo implode($valuesArray[$deptID], ','); ?>],
		  //backgroundColor: "#FFA500",
		  borderColor: "<?php echo $colorsTrek[$cn] ; ?>",
		  borderWidth: 3
		},
	  <?php $cn++; } ?>
	  ]
	},
	
	options: {
	  legend: { display: true, position: 'right' },
	  title: {
		display: true,
		lineHeight: 3,
		text: "Last 30 Days Call Volume - Department Wise"
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel;
		   }
		}
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  scales: {
		   xAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value;
			  },
			  beginAtZero: true,
			  //steps: 5,
			  //max: <?php echo !empty($allTotal) ? $allTotal : "0"; ?>,
			  //min:0
			}
		  }]
		},
	  plugins: {
	  datalabels: {
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value;
		},
		font: {
		  weight: 'bold',
		  size:9,
		}
	  }
	  },
	},	
});



//========================================================================
// DAYWISE DEPARTMENT RECORDS
//========================================================================
<?php 
$openArray = array();
$allArray = array();
$repeatArray = array();
foreach($department_list as $dlist)
{
	$deptID = $dlist['id'];
	$openArray[] = !empty($dept_analytics[$deptID]['open']) ? count($dept_analytics[$deptID]['open']) : "0";
	$allArray[] = !empty($dept_analytics[$deptID]['all']) ? count($dept_analytics[$deptID]['all']) : "0";
	$repeatArray[] = !empty($dept_analytics[$deptID]['repeat']) ? count($dept_analytics[$deptID]['repeat']) : "0";
}
$colorsTrek = array("#AF3319","#2319AF","#0D7B18","#AF3319","#2319AF","#0D7B18");
?>
var ctxBAR2 = document.getElementById("o_ticket_deapartment_barget");
var myBarChart2 = new Chart(ctxBAR2, {
	type: 'bar',
	data: {	  
	  labels: ["<?php echo implode($departmentArray, '","'); ?>"],
	  datasets: [
		{
		  //type: 'bar',
		  label: "Total Calls",
		  data: [<?php echo implode($allArray, ','); ?>],
		  backgroundColor: "<?php echo $colorsTrek[0] ; ?>",
		  borderColor: "<?php echo $colorsTrek[0] ; ?>",
		  borderWidth: 1
		},
		{
		  //type: 'bar',
		  label: "Total Open",
		  data: [<?php echo implode($openArray, ','); ?>],
		  backgroundColor: "<?php echo $colorsTrek[1] ; ?>",
		  borderColor: "<?php echo $colorsTrek[1] ; ?>",
		  borderWidth: 1
		},
		{
		  //type: 'bar',
		  label: "Repeat Calls",
		  data: [<?php echo implode($repeatArray, ','); ?>],
		  backgroundColor: "<?php echo $colorsTrek[2] ; ?>",
		  borderColor: "<?php echo $colorsTrek[2] ; ?>",
		  borderWidth: 1
		},
	]
	},
	options: {
	  legend: { display: true, position: 'bottom' },
	  title: {
		display: true,
		lineHeight: 3,
		text: "Department Wise Bar Chart"
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel;
		   }
		}
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  scales: {
		   xAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value;
			  },
			  beginAtZero: true,
			  //steps: 5,
			  //max: <?php echo !empty($allTotal) ? $allTotal : "0"; ?>,
			  //min:0
			}
		  }]
		},
	  plugins: {
	  datalabels: {
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value;
		},
		font: {
		  weight: 'bold',
		  size: 9,
		}
	  }
	  },
	},	
});



//========================================================================
// DISTRICT WISE RECORDS
//========================================================================
<?php 
$currentDate = $to_date;
$resultSet = array(); $districtArray = array(); $datesGetArray = array(); $valuesArray = array();
for($i=0;$i<=$totalDays;$i++){ 
	$currentDate = date('Y-m-d', strtotime('-'.$i.' day', strtotime($to_date)));
	$districtArray = array(); $datesArray = array();	
	foreach($district_list as $dlist)
	{
		$districtArray[] = $dlist;		
		$resultSet[$dlist][$currentDate] = !empty($district[$dlist]['date'][$currentDate]) ? count($district[$dlist]['date'][$currentDate]) : "0";
		$valuesArray[$dlist][] = $resultSet[$dlist][$currentDate];
	}
	$datesGetArray[] = $currentDate;	
}
//hth_print($datesArray);

$colorsTrek = array("#8a3194","#1961c9","#0d9339","#fe586a","#30b49e","#a4b626","#b983a2","#a4b626","#f14e10","#dc46b7","#c6b3a9","#0D7B18","#588667",
                    "#8a3194","#1961c9","#0d9339","#fe586a","#30b49e","#a4b626","#b983a2","#a4b626","#f14e10","#dc46b7","#c6b3a9","#0D7B18","#588667");

?>
var ctxBAR3 = document.getElementById("o_ticket_deapartment_districtget");
var myBarChart3 = new Chart(ctxBAR3, {
	type: 'line',
	data: {
	  labels: ["<?php echo implode($datesGetArray, '","'); ?>"],
	  datasets: [
	  <?php $cn=0; foreach($district_list as $dlist){ ?>
		{
		  //type: 'line',
		  label: "<?php echo $dlist; ?>",
		  data: [<?php echo implode($valuesArray[$dlist], ','); ?>],
		  //backgroundColor: "#FFA500",
		  borderColor: "<?php echo $colorsTrek[$cn] ; ?>",
		  borderWidth: 3
		},
	  <?php $cn++; } ?>
	  ]
	},
	
	options: {
	  legend: { display: true, position: 'right' },
	  title: {
		display: true,
		lineHeight: 3,
		text: "Last 30 Days Call Volume - District Wise"
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel;
		   }
		}
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  scales: {
		   xAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value;
			  },
			  beginAtZero: true,
			  //steps: 5,
			  //max: <?php echo !empty($allTotal) ? $allTotal : "0"; ?>,
			  //min:0
			}
		  }]
		},
	  plugins: {
	  datalabels: {
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value;
		},
		font: {
		  weight: 'bold',
		  size:9,
		}
	  }
	  },
	},	
});

<?php //*/ ?>
</script>
<?php } ?>