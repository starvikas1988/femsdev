<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('#search_check').click(function(){
	subOrder = $('#s_sub_order').val();
	subUser = $('#s_user_id').val();
	if(subOrder != "")
	{
		$('#serach_submit').click();
	} else {
		if(subUser == "")
		{
			alert('Please Enter user ID');
		} else {
			$('#serach_submit').click();			
		}
	}
});


$('.newDatePickFormat').datepicker({ dateFormat: 'yy-mm-dd' });
$('#default-datatable').DataTable({
	"pageLength":50
});
</script>