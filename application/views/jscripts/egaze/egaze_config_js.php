<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
// PROCESS --> CLIENT FILTER
$("#addConfigEgaze #client_id").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'0','process_id','Y');
});


$('#addConfigEgaze #is_global').change(function(){
	setConfig = $(this).val();
	if(setConfig == '1')
	{
		$('#addConfigEgaze #department_id').val(0);
		$('#addConfigEgaze #client_id').val(0);
		$('#addConfigEgaze #process_id').val(0);
		$('#addConfigEgaze .clientProcessForm').hide();
		$('#addConfigEgaze .departmentForm').hide();
	}
	if(setConfig == '0')
	{
		$('#addConfigEgaze #department_id').val(0);
		$('#addConfigEgaze #client_id').val(0);
		$('#addConfigEgaze #process_id').val(0);
		$('#addConfigEgaze .clientProcessForm').show();
		$('#addConfigEgaze .departmentForm').show();
	}
});

$('#default-datatable').DataTable({
	"pageLength":50
});




</script>