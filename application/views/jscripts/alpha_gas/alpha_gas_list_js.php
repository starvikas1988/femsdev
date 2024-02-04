<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('#search_from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });
$('#search_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });

<?php if(!empty($call_type)) { ?>$('#search_call_type').val('<?php echo $call_type; ?>');<?php } ?>

$('#default-datatable').DataTable({
	"pageLength":50
});

$(document).on('click', '#viewCrmLogs', function(){
    cname = $(this).attr('cname');
    cid = $(this).attr('cid');
	$('#crmLogsModal .modal-title').html('Disposition Logs : ' + cid + ' (' + cname + ')');
	$('#crmLogsModal .modal-body').html('No Records Found');
	$('#sktPleaseWait').modal('show');
	bUrl = '<?php echo base_url(); ?>alphagas/crm_logs_list/'+cid;
	$.ajax({
		type: 'POST',
		url: bUrl,
		data: 'cid=' + cid,
		success: function(response) {
			$('#sktPleaseWait').modal('hide');
			$('#crmLogsModal .modal-body').html(response);
			$('#crmLogsModal').modal('show');
			/*$('#default-datatable-logs').DataTable({
				searching: false,
				info:false,
				pageLength:50
			});*/
		}
	});
});
</script>