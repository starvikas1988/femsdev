<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(e){
	$('#select_office').select2();
	$('#lob_id').select2();
	$('#l1_super').select2();
	$('#select_qa').select2();
	$('#from_date').datepicker({
      dateFormat: 'yy-mm-dd'
	});
	$('#to_date').datepicker({
      dateFormat: 'yy-mm-dd'
	});
		
});
</script>