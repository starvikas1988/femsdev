
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
<script>

	$('#summernote').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
			['table', ['table']],
  			['insert', ['link']],
        ],
        height: 200,
        placeholder: 'Details'
    });


	$('.edit_category').click(function()
	{
		$('#modal').modal('show');
		var id = $(this).attr('data-id');
		var category_id = $(this).parent().parent().children('td.category').attr('data-category_id');
		var department_id = $(this).parent().parent().children('td.department').attr('data-department');
		var title = $(this).parent().parent().children('td.title').text();
		var text = $(this).parent().parent().children('td.text').text();
		
		$('#myModalLabel').text('Edit FAQ Message');
		$('#faq_category').val(category_id);
		$('#department').val(department_id);
		$('#name').val(title);
		$('#text').val(text);
		$('[name="faq_id"]').val(id);
	});
	
	$('.create_category').click(function()
	{
		$('#modal').modal('show');
		$('#myModalLabel').text('Create FAQ Message');
		$('#create_category')[0].reset();
		$('[name="faq_id"]').val('');
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
			url: "<?php echo base_url('faq/process_message'); ?>",
			type: "POST",
			data: $(this).serializeArray(),
			success:function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					alert('FAQ Message Processed');
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