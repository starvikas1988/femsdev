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
		var datas = {'design_id':design_id};
		$('#add_target_form #did').val(design_id);
		var request_url = "<?php echo base_url('Pmetrix_v2/get_metrix_col'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#target_table').html(res.table);
			}
			
		},request_url, datas, 'text');
	});
</script>
<script>
	$(document).on('submit','#add_target_form',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('Pmetrix_v2/add_target'); ?>";
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
		var tenure_bucket = $('#tenure_bucket').val();
		var did = $('#did').val();
		
		if(trg_month != '' && target_year != '' && tenure_bucket != '')
		{
			var datas = {'did':did,'tenure_bucket':tenure_bucket,'target_year':target_year,'trg_month':trg_month};
			var request_url = "<?php echo base_url('Pmetrix_v2/get_target'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					if(res.datas == '')
					{
						$('[name="col_ids[]"]').prev().val('');
					}
					else
					{
						$.each(res.datas,function(index,element)
						{
							$('[name="col_ids[]"][value="'+element.pm_design_kpi_id+'"]').prev().val(element.target	);
						});
					}
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