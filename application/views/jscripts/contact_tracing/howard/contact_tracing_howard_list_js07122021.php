<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('#default-datatable').DataTable({
	"pageLength":50
});

// DATEPICKER
$('.oldDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy' });

// SEND MAIL
//$('.sendMailCase').on('click', function(){
$('#default-datatable').on('click', '.sendMailCase', function(){	
	email = $(this).attr('c_mail');
	name = $(this).attr('c_name');
	crmid = $(this).attr('c_crmid');	
	$('#myEmailSendModal #form_crm_id').val('');
	$('#myEmailSendModal #form_case_name').val('');
	$('#myEmailSendModal #form_email_id').val('');	
	$('#myEmailSendModal #form_crm_id').val(crmid);
	$('#myEmailSendModal #form_case_name').val(name);
	$('#myEmailSendModal #form_email_id').val(email);
	$('#myEmailSendModal').modal('show');
});
$("#download_report").click(function() {
	console.log('ok');
    if($(this).is(':checked')) {
        $("#dw_text").text("Download Report");
    } else {
        $("#dw_text").text("Filter");
    }
});

$('#myEmailSendModal .sendMailSubmission').on('click', function(){
	crmid = $('#myEmailSendModal #form_crm_id').val();
	name = $('#myEmailSendModal #form_case_name').val();
	email = $('#myEmailSendModal #form_email_id').val();
	sendtype = $('#myEmailSendModal #form_send_type').val();
	if(email != ""  && crmid != "")
	{
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('contact_tracing_crm/send_email'); ?>",
			data:{
				'form_email_id' : email,
				'form_case_name' : name,
				'form_crm_id' : crmid,
				'form_send_type' : 2,
			},
		    cache: false,
		    success: function(data){
				$('#sktPleaseWait').modal('hide');
				$('#myEmailSendModal').modal('hide');
				alert('Mail hase been sent successfully!');
			}
		});
	} else {
		alert('Please enter the Email ID!');
	}
	$('#myEmailSendModal').modal('show');
});

</script>