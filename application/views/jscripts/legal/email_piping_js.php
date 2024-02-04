<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
// MAIL VIEW INFO
$('.mailInfoDetails').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	eidEmail = $(this).attr('email');
	eidFolder = $(this).attr('efolder');
	$('#modalInfoDetails .modal-body').html('<span class="text-danger">-- No Info Found --</span>');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('legal/view_mails_message_details'); ?>",
		type: "GET",
		data: { eid : eidVal, email : eidEmail, efolder : eidFolder },
		dataType: "text",
		success : function(result){
			$('#sktPleaseWait').modal('hide');
			$('#modalInfoDetails .modal-body').html(result);
			$('#modalInfoDetails').modal('show');
		},
		error : function(result){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

$('.ticketMailInfoDetails').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticketNo = $(this).attr('ticket_no');
	$('#modalInfoDetails .modal-body').html('<span class="text-danger">-- No Info Found --</span>');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('legal/view_ticket_details'); ?>",
		type: "GET",
		data: { ticket_no : ticketNo },
		dataType: "text",
		success : function(result){
			$('#sktPleaseWait').modal('hide');
			$('#modalInfoDetails .modal-body').html(result);
			$('#modalInfoDetails').modal('show');
		},
		error : function(result){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$('.ticketMailReply').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticketNo = $(this).attr('ticket_no');
	$('#modalInfoReplyTicket .modal-body').html('<span class="text-danger">-- No Info Found --</span>');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('legal/view_ticket_reply'); ?>",
		type: "GET",
		data: { ticket_no : ticketNo },
		dataType: "text",
		success : function(result){
			$('#sktPleaseWait').modal('hide');
			$('#modalInfoReplyTicket .modal-body').html(result);
			CKEDITOR.replace('moreInfoEditor', {
				removePlugins: 'about',
			});
			$('#modalInfoReplyTicket').modal('show');
		},
		error : function(result){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


</script>