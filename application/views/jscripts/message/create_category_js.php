<script>
	$('.edit_category').click(function()
	{
		$('#modal').modal('show');
		var category_id = $(this).attr('data-category_id');
		var category = $(this).parent().parent().children('td.category').text();
		var client = $(this).parent().parent().children('td.client').attr('data-client_id');
		var process = $(this).parent().parent().children('td.process').attr('data-process_id');
		var location = $(this).parent().parent().children('td.location').text();
		
		$('#myModalLabel').text('Edit Category');
		$('#name').val(category);
		$('[name="faq_types_id"]').val(category_id);
		$('#assign_site').val(location);
		$('#assign_client').val(client);
		populate_process_combo(client,process,'assign_process','N');
	});
	
	$('.create_category').click(function()
	{
		$('#modal').modal('show');
		$('#myModalLabel').text('Create Category');
		$('#create_category')[0].reset();
		$('[name="faq_types_id"]').val('');
	});
	
	$("#assign_client").change(function(){
		var client_id=$(this).val();
		
		populate_process_combo(client_id,'','assign_process','N');
	});
</script>
<script>
	$('#create_category').submit(function(e)
	{
		e.preventDefault();
		$.ajax({
			url: "<?php echo base_url('faq/process_category'); ?>",
			type: "POST",
			data: $(this).serializeArray(),
			success:function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					alert('Category Processed');
					location.reload();
				}
				else
				{
					alert('Some Error! Try After Sometime.');
				}
			}
		});
	});
</script>