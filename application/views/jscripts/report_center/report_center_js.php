<script>
	$('#upload_report_btn').click(function(e)
	{
		e.preventDefault();
		$('#upload_report').modal('show');
	});
	
	$("#fedclient_id").change(function(){
		var client_id=$(this).val();
		
		populate_process_combo(client_id,'','fedprocess_id','N');
	});
	
	$("#sclient_id").change(function(){
		var client_id=$(this).val();
		
		populate_process_combo(client_id,'','sprocess_id','N');
	});
</script>

<script>
	$(document).ready(function(){

	$('input[type="file"]').change(function(e){
		$('#file_uploader').removeAttr('class');
		var fileName = e.target.files[0].name;
		var ext = fileName.split('.').pop();
		console.log(e.target.files);
		console.log(ext);
		var ext_array = ['xlsx', 'xls', 'csv', 'pdf','docx'];
		if($.inArray( ext, ext_array ) < 0)
		{
			var file = document.getElementById("upload");
			file.value = file.defaultValue;
			$('#file_uploader').addClass('wrong_file');
			$('#file_uploader').html('Only PDF, Docx, Excel & CSV File Allowed');
		}
		else if(((e.target.files[0].size/ 1024 / 1024) < 10))
		{
			if(e.target.files[0].type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
			{
				$('#file_uploader').html('<i class="far fa-file-word"></i> '+fileName);
			}
			else
			{
				$('#file_uploader').html('<i class="fas fa-file-pdf"></i> '+fileName);
			}
			
			$('#file_uploader').addClass('correct_file');
		}
		else if(((e.target.files[0].size/ 1024 / 1024) > 10))
		{
			var file = document.getElementById("upload");
			file.value = file.defaultValue;
			$('#file_uploader').addClass('wrong_file');
			$('#file_uploader').html('Max File Size 10MB');
		}

		

	});

});
</script>
<script>
	$(document).on('submit','#upload_report_form',function(e)
	{
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url('Report_center/process_upload_report_form'); ?>', 
			type: 'POST',
			data: new FormData($('#upload_report_form')[0]), // The form with the file inputs.
			processData: false,
			contentType: false                    // Using FormData, no need to process data.
		}).done(function(response){
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				alert('Information Saved Successfully!');
				$('#upload_report_form')[0].reset();
				var file = document.getElementById("upload");
				file.value = file.defaultValue;
				$('#file_uploader').removeAttr('class');
				$('#file_uploader').html('Select File');
				$('#upload_report').modal('hide');
			}
			else
			{
				alert('Unable to save info. Try again.');
			}
		}).fail(function(){
			console.log("An error occurred, the files couldn't be sent!");
		});
	});
</script>

<script>
	$(document).on('submit','#search_report',function(e)
	{//
	//
		e.preventDefault();
		$.ajax({
			url: "<?php echo base_url('Report_center/get_results'); ?>",
			type: "POST",
			data: $(this).serializeArray(),
			success:function(response)
			{
				var res = jQuery.parseJSON(response);
				console.log(res);
				if(res.stat == true)
				{
					
					var table = '';
					$.each(res.data, function(key,value) {
						var url = '<?php echo base_url('/uploads/report_center/'); ?>';
						url += '/'+encodeURIComponent(value.file_name);
						
						if(value.department_name == null)
						{	
							value.department_name = 'All';
						}
						table += '<tr><td>'+(key+1)+'</td><td>'+value.location_id+'</td><td>'+value.department_name+'</td><td>'+value.client_name+'</td><td>'+value.process_name+'</td><td><a href="<?php echo base_url('Report_center/download'); ?>/'+value.i+'" class="download">Download</a></td></tr>';
						//table += '<tr><td>'+(key+1)+'</td><td>'+value.location_id+'</td><td>'+value.department_name+'</td><td>'+value.client_name+'</td><td>'+value.process_name+'</td><td><a href="" id="'+value.id+'" class="download">Download</a></td></tr>';
						//table += '<tr><td>'+(key+1)+'</td><td>'+value.location_id+'</td><td>'+value.department_name+'</td><td>'+value.client_name+'</td><td>'+value.process_name+'</td><td><a href="'+url+'" class="download">Download</a></td></tr>';
					});
					$('#result_container').html(table);
				}
				else
				{
					alert('No Information Found');
				}
			}
		});
	});
</script>

<script>
	$(document).on('click','.download',function(e)
	{
		/* e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url: "<?php echo base_url('Report_center/download'); ?>/"+id+"",
			type: "POST",
			success:function(response)
			{
				var res = jQuery.parseJSON(response);
				if(res.stat == true)
				{
					//window.location.href="<?php echo base_url('uploads/'); ?>/"+res.location+"/"+res.file_name+"";
					//window.open("<?php echo base_url('uploads/'); ?>/"+res.location+"/"+res.file_name+"", '_blank');
					window.location.assign("<?php echo base_url('uploads/'); ?>/"+res.location+"/"+res.file_name+"");
				}
			}
		}); */
	});
</script>
