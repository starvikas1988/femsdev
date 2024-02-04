<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
<script>
	$('#text').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ],
        height: 200,
        placeholder: 'Give Message'
    });
</script>
<script>
	$('.edit_category').click(function()
	{
		$('#modal').modal('show');
		var id = $(this).attr('data-id');
		var location = $(this).parent().parent().children('td.location').attr('data-location');
		var department = $(this).parent().parent().children('td.department').attr('data-department');
		var client = $(this).parent().parent().children('td.client').attr('data-client');
		var process = $(this).parent().parent().children('td.process').attr('data-process');
		
		
		var subject = $(this).parent().parent().children('td.subject').text();
		var message = $(this).parent().parent().children('td.message').attr('data-message');
		$('#myModalLabel').text('Edit Message');
		$('#name').val(subject);
		$('#text').val(message);
		$('#location').val(location);
		$('#department').val(department);
		$('#client').val(client);
		populate_process_combo(client,process,'process','N');
		$('#text').summernote('code', message);
		
		$('[name="faq_messageboard_id"]').val(id);
	});
	
	$('.upload').click(function()
	{
		$('#modal_upload').modal('show');
		$('[name="exp_id"]').val($(this).attr('data-id'));
	});
	
	$('.create_category').click(function()
	{
		$('#text').summernote('code', '');
		$('#modal').modal('show');
		$('#myModalLabel').text('Create FAQ Message');
		$('#create_category')[0].reset();
		$('[name="faq_messageboard_id"]').val('');
	});
	
	$("#client").change(function(){
		var client_id=$(this).val();
		
		populate_process_combo(client_id,'','process','N');
	});
</script>
<script>
	$('#create_category').submit(function(e)
	{
		e.preventDefault();
		$.ajax({
			url: "<?php echo base_url('faq/proces_create_message'); ?>",
			type: "POST",
			data: $(this).serializeArray(),
			success:function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					alert('Message Processed');
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

<script>
$(document).ready(function()
{
	var baseURL="<?php echo base_url();?>";
		
	var uUrl=baseURL+'faq/upload';
	var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "myfile",
			allowedTypes:"png,jpeg,jpg,pdf,doc,docx,xlx,xlsx",	
			onSuccess:function(files,data,xhr)
			{
			   console.log(data);
			   var res = JSON.parse(data);
			   if(res.success=='true')
			   {
					location.reload();
			   }
			},
			onSelect:function(files)
			{
				/* console.log(files);
				console.log($(this).attr('data-id')); */
			},
			onError:function (files, status, message)
			{
			   $("#OutputDiv").html(message);
			   
			   alert(message);
			   
			  // var rUrl=baseURL+'schedule';
			   //window.location.href=rUrl;	
			   
			},
			showDelete:false
		}
		
		$( ".upload_image" ).each(function(index,element) {
			//var exp_id_value = $(element).find('name="exp_id"').val();
			var ind = $(element).attr('data-id');
			var exp_id_val = $(element).find('[name="exp_id"]').val();
			settings.formData = {exp_id:exp_id_val};
			var uploadObj = $("#mulitplefileuploader"+ind).uploadFile(settings);
		});
			/* var exp_id_val = $('[name="exp_id"]').val();
			settings.formData = {exp_id:exp_id_val};
			var uploadObj = $("#mulitplefileuploader").uploadFile(settings); */
		
});
</script>
<script>
	$('.delte_attach').click(function(e)
	{
		e.preventDefault();
		var attachemtn_id = $(this).attr('data-id');
		var datas = {'attachemtn_id':attachemtn_id};
		$.ajax({
			url: "<?php echo base_url('faq/delete_attach'); ?>",
			type: "POST",
			data: datas,
			success:function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					alert('Information Deleted');
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