<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('#search_from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });
$('#search_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });
$('#default-datatable').DataTable({
	"pageLength":50
});
</script>