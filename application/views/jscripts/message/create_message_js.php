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
        height: 100,
        placeholder: 'Give Message'
    });
</script>
<script>
	$(document).on('click','.edit_category',function()
	{
		$('#modal').modal('show');
		var id = $(this).attr('data-id');
		var location = $(this).parent().parent().children('td.location').attr('data-location');
		var individual = $(this).parent().parent().children('td.location').attr('data-individual');
		var individual_ids = $(this).parent().parent().children('td.location').attr('data-individual_ids');
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
		
		if(individual == 1)
		{
			$('#specific_users').parent().show();
			$('#specific_users').removeAttr('disabled');
			
			$('#department,#client,#process').parent().hide();
			$('#department,#client,#process').attr('disabled','disabled');
			
			$('#specific_user').prop('checked', true);
			var request_url = "<?php echo base_url('message/get_users'); ?>";
			var datas = {'location':location};
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				var option = '';
				if(res.stat == true)
				{
					$.each(res.datas,function(index,element)
					{
						var str = individual_ids;
						var split_str = str.split(",");
						if (split_str.indexOf(element.id) !== -1) {
							option += '<option value="'+element.id+'" selected="selected">'+element.name+' ('+element.fusion_id+') ('+element.shname+')</option>';
						}
						else
						{
							option += '<option value="'+element.id+'">'+element.name+' ('+element.fusion_id+') ('+element.shname+')</option>';
						}
					});
					$('#specific_users').html(option);
					/* console.log(option);
					$.when($('#specific_users').html(option)).done(function()
					{
						 var array = individual_ids.split(",");
						 el = [];
						$.each(array,function(index,element)
						{
							el[index] = element;
							
							//alert(element);
						 });
						 $('#specific_users').val([el.join(',')]).trigger('change');
						/*setTimeout(function(){ $('#specific_users').val([individual_ids]).trigger('change'); alert(individual_ids);}, 3000); */
				}	
						
			},request_url, datas, 'text');
		}
		else
		{
			$('#specific_users').parent().hide();
			$('#specific_user').prop('checked', false);
			$('#specific_users').attr('disabled','disabled');
			
			$('#department,#client,#process').parent().show();
			$('#department,#client,#process').removeAttr('disabled');
		}
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
		$('#myModalLabel').text('Create Message');
		$('#create_category')[0].reset();
		$('[name="faq_messageboard_id"]').val('');
		$('#specific_users').html('');
		$('#specific_users').parent().hide();
		$('#specific_users').attr('disabled','disabled');
		$('#department,#client,#process').parent().show();
		$('#department,#client,#process').removeAttr('disabled');
	});
	
	$("#client").change(function(){
		var client_id=$(this).val();
		
		populate_process_combo(client_id,'','process','Y');
	});
</script>
<script>
	$('#create_category').submit(function(e)
	{
		e.preventDefault();
		$.ajax({
			url: "<?php echo base_url('message/proces_create_message'); ?>",
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
		
			var ind = $('#upload_image_form').attr('data-id');
			settings.formData = {exp_id:ind};
			var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
		
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

<script>
	$(document).on('click','#specific_user',function()
	{
		if($(this).is(":checked"))
		{
			$('#specific_users').parent().show();
			$('#specific_users').removeAttr('disabled');
			
			if($('#faq_messageboard_id').val() != '')
			{
				var location = $('#location').val();
				var request_url = "<?php echo base_url('message/get_users'); ?>";
				var datas = {'location':location};
				process_ajax(function(response)
				{
					var res = JSON.parse(response);
					var option = '';
					if(res.stat == true)
					{
						$.each(res.datas,function(index,element)
						{
							option += '<option value="'+element.id+'">'+element.name+' ('+element.fusion_id+') ('+element.shname+')</option>';
						});
						console.log(option);
						$('#specific_users').html(option);
					}
				},request_url, datas, 'text');
			}
			
			$('#department,#client,#process').parent().hide();
			$('#department,#client,#process').attr('disabled','disabled');
		}
		else
		{
			$('#specific_users').parent().hide();
			$('#specific_users').attr('disabled','disabled');
			
			$('#department,#client,#process').parent().show();
			$('#department,#client,#process').removeAttr('disabled');
		}
	});
	$(document).ready(function() {
		$('#specific_users').select2({
			placeholder: "Select Users",
			allowClear: true
		});
	});
	$('#location').change(function()
	{
		var location = $(this).val();
		var request_url = "<?php echo base_url('message/get_users'); ?>";
		var datas = {'location':location};
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			var option = '';
			if(res.stat == true)
			{
				$.each(res.datas,function(index,element)
				{
					option += '<option value="'+element.id+'">'+element.name+' ('+element.fusion_id+') ('+element.shname+')</option>';
				});
				console.log(option);
				$('#specific_users').html(option);
			}
		},request_url, datas, 'text');
	});
</script>