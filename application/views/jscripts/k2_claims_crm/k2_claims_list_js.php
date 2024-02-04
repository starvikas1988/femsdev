<script>
$('.catastropheDIV').on('click', '.editCrmBtn', function(){
	cid = $(this).attr('cid');
	code = $(this).attr('ccode');
	$('#modalCRMEdit input[name="catastrophe_id"]').val(cid);
	$('#modalCRMEdit input[name="catastrophe_code"]').val(code);
	$('#modalCRMEdit').modal();
});
</script>