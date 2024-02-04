<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('.myDatePicker').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });

$(document).ready(function() {
    $('#dataExportTable').DataTable({
		pageLength:'50'
	});
});

$('#client_id').select2();
$('#process_id').select2();
$('#office_id').select2();

</script>