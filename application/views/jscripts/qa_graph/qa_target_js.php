<?php if($content_template == 'qa_graph/qa_monthly_target_list.php'){ ?>
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('#default-datatable').DataTable({
	"pageLength":50
});


$("#select_client").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'','select_process','N');
});

updateProcess();
function updateProcess()
{
	var client_id=$("#select_client").val();
	populate_process_combo(client_id,'','select_process','N');
}
</script>
<?php } ?>
<?php if($content_template == 'qa_graph/qa_monthly_target.php'){ ?>
<script>
$("#select_client").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'','select_process','Y');
});

updateProcess();
function updateProcess()
{
	var client_id=$("#select_client").val();
	populate_process_combo(client_id,'','select_process','Y');
}
</script>
<?php } ?>