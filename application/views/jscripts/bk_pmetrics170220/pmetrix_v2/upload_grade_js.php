<script>
	$(document).on('submit','#metrix_target_form',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('Pmetrix_v2/get_metrix_design'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#available_metrix_design').html(res.table);
			}
			else
			{
				$('#available_metrix_design').html('');
			}
			
		},request_url, datas, 'text');
	});
</script>
<script>
	$(document).on('click','.upload_target',function(e)
	{
		$('#add_target_modal').modal('show');
		var design_id = $(this).attr('data-design_id');
		var process_id = $(this).attr('data-process_id');
		var datas = {'design_id':design_id};
		$('#add_target_form #did').val(design_id);
		$('#add_target_form #process_id').val(process_id);
		
	});
</script>
<script>
	$(document).on('submit','#add_target_form',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('Pmetrix_v2/add_grade'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				alert('Information Added');
				$('#add_target_form')[0].reset();
				$('#add_target_modal').modal('hide');
			}
			
		},request_url, datas, 'text');
	});
</script>
<script>
	$(document).on('change','#target_month,#target_year,#tenure_bucket',function(e)
	{
		var trg_month = $('#target_month').val();
		var target_year = $('#target_year').val();
		var did = $('#did').val();
		
		if(trg_month != '' && target_year != '')
		{
			var datas = $('#add_target_form').serializeArray();
			var request_url = "<?php echo base_url('Pmetrix_v2/get_exisiting_grade'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					$.each(res.data,function(index,element)
					{
						//console.log(element.grade);
						//$('[name="grade[]"][value="'+element.grade+'"]').parent().parent().find('[name="grade_start[]"]').val(element.grade_start);
						$('#target_month').val(element.month);
						$('#target_year').val(element.year);
						if(element.grade == 'A')
						{
							$('[name="grade[]"][value="'+element.grade+'"]').parent().parent().find('[name="grade_end[]"]').val( Math.round(element.grade_start));
						}
						else if(element.grade == 'B')
						{
							$('[name="grade[]"][value="'+element.grade+'"]').parent().parent().find('[name="grade_end[]"]').val( Math.round(element.grade_start));
						}
						else
						{
							$('[name="grade[]"][value="'+element.grade+'"]').parent().parent().find('[name="grade_end[]"]').val( Math.round(element.grade_end));
						}
					})
					
				}
				else
				{
					$('[name="grade[]"]').parent().parent().find('[name="grade_end[]"]').val('');
				}
				
			},request_url, datas, 'text');
		}
	});
</script>
<script>
	$(document).ready(function()
	{
		$('#foffice_id').val('<?php echo $oValue; ?>').trigger("change");
		
	});
	
</script>
<script>
	$(document).on('change','#foffice_id',function()
	{
		var office_id = $(this).val();
		$.ajax({
		   type: 'POST',    
		   url:"<?php echo base_url('pmetrix_v2/get_clients');?>",
		   data:'office_id='+office_id,
		   success: function(response){
				var res = JSON.parse(response);
				console.log(res);
				var option = '<option value="">--Select--</option>';
				$.each(res, function(key,value)
				{
					option += '<option value="'+value.client_id+'" selected>'+value.shname+'</option>';
					
					/* $('#fclient_id option:not([value="'+value.client_id+'"])').attr('disabled','disabled');
					$('#fclient_id option[value="'+value.client_id+'"]').removeAttr('disabled'); */
				});
				$.when($('#fclient_id').html(option)).done(function()
				{
					$('#fclient_id').val('<?php echo $cValue; ?>').trigger("change");
				});
				
			}
			
		  });
	});
</script>
<script>
	$("#fclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'<?php echo $pValue; ?>','fprocess_id','Y');
		
	});
	
</script>