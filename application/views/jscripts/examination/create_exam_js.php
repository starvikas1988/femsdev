<script>
	$('#create_examination_btn').click(function()
	{
		$('#create_examination_modal').modal('show');
	});
	$(document).on('click','.upload_exam_btn',function()
	{
		var set_id = $(this).attr('data-set_id');
		$('#exam_set_modal #set_id').val(set_id);
		$('#exam_set_modal').modal('show');
	});
	$(document).on('click','.create_sets',function()
	{
		$('#create_set_modal').modal('show');
		var exam_id = $(this).attr('data-exam_id');
		$('#create_set_modal #exam_id').val(exam_id);
	});
	
	$(document).on('click','.view_sets',function()
	{
		var exam_id = $(this).attr('data-exam_id');
		get_sets(exam_id)
	});
</script>
<script>
	$(document).ready(function()
	{
		get_examinations();
	});
	
	$('#lt_type').change(function(){
		get_examinations();
	});
	
	
	
	function get_examinations()
	{
		var ltype = $("#lt_type").val();
		var datas = { 'office_id':"<?php echo get_user_office_id(); ?>", 'lttype': ltype };
		var request_url = "<?php echo base_url('examination/get_exam_list'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var tr = '';
				$.each(res.datas,function(index,element)
				{
					tr += '<tr data-exam_id="'+element.id+'"><td>'+(index+1)+'</td><td>'+element.title+'</td><td>'+element.location+'</td><td>'+element.type+'</td><td><button class="btn btn-xs  view_sets no_padding" title="View Sets" data-exam_id="'+element.id+'"><img src="<?php echo base_url();?>assets_home_v3/images/view.svg" alt=""></button><button class="btn btn-xs create_sets no_padding btn_left" title="Create Sets" data-exam_id="'+element.id+'"><img src="<?php echo base_url();?>assets_home_v3/images/add.svg" alt=""></button></td></tr><tr class="exam_set_container"><td colspan="5"><table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0"><thead><tr class="bg-warning"><th>SL</th><th>Title</th><th>No. of Question</th><th>Action</th></tr></thead><tbody data-exam_set_container="'+element.id+'"></tbody></table></td></tr>';
					//
				});
				$('#examination_container').html(tr);
			}
			else
			{
				alert('Try After Some Time.');
			}
		},request_url, datas, 'text');
	}
	function get_sets(exam_id)
	{
		var datas = {'exam_id':exam_id};
		var request_url = "<?php echo base_url('examination/get_set_list'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var tr = '';
				$.each(res.datas,function(index,element)
				{
					tr += '<tr><td>'+(index+1)+'</td><td>'+element.title+'</td><td>'+element.no_of_question+'</td><td style="width:20%"><button class="btn btn-xs upload_exam_btn no_padding" data-set_id="'+element.id+'" title="Upload Set"><img src="<?php echo base_url();?>assets_home_v3/images/upload_icon.svg" alt=""></button><button class="btn btn-xs view_question no_pdding btn_left" data-set_id="'+element.id+'" title="View Question"><img src="<?php echo base_url();?>assets_home_v3/images/view.svg" alt=""></button></td></tr>';
				});
				$('[data-exam_set_container="'+exam_id+'"]').html(tr);
				$('tr[data-exam_id="'+exam_id+'"]').next().show();
			}
			else
			{
				alert('Try After Some Time.');
			}
		},request_url, datas, 'text');
	}
</script>

<script>
	$(document).on('submit','#create_examination_form',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('examination/create_exam'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				//alert('New Exam Created');
				$('#create_examination_modal').modal('hide');
				$("#create_examination_form").trigger("reset");
				get_examinations()
			}
			else
			{
				alert('Try After Some Time.');
			}
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('submit','#exam_set_form',function(e)
	{
		e.preventDefault();
		var datas = new FormData($(this)[0]);
		var request_url = "<?php echo base_url('examination/upload_exam_set'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				
				$('#exam_set_modal').modal('hide');
				$('#sktPleaseWait').modal('hide');
				
				get_examinations();
				$('.upload_label').removeAttr('style');
				$('.upload_label').text('Select File');
				get_sets(res.datas.exam_id);
				
			}
			else
			{
				$('#sktPleaseWait').modal('hide');
				alert('File format doesn\'t match. Please try back after some time.');
			}
		},request_url, datas, 'text','POST','file');
	});
	$(document).on('change','#s_check',function(){
		if(this.checked) {
			$("#s_box").show();
		}else{
			$("#s_box").hide();
		}
	});
</script>

<script>
	$(document).on('change','#upload_file',function()
	{
		var file = $(this).val();
		var ext = file.split('.').pop();
		var allowed_file_type_array = $(this).attr('data-allowed_file_type').split(',');
		var actual_file_size = ($(this).context.files[0].size/1000);
		var allowed_file_size = $(this).attr('data-max_size');
		
		if($.inArray(ext,allowed_file_type_array) == -1)
		{
			$('.upload_label').text('Only Allowed File Type: '+allowed_file_type_array.join(','));
			$('.upload_label').css({'border':'1px dashed red'});
			$(this).val('');
		}
		else
		{
			$('.upload_label').removeAttr('style');
			if(actual_file_size > allowed_file_size)
			{
				$('.upload_label').text('Max Allowed File Size: '+allowed_file_size);
				$('.upload_label').css({'border':'1px dashed red'});
				$(this).val('');
			}
			else
			{
				$('.upload_label').text($(this).context.files[0].name+' File Selected');
				$('.upload_label').css({'border':'1px dashed green'});
			}
		}
	});
	function bytesToSize(bytes) {
	   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	   if (bytes == 0) return '0 Byte';
	   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
	   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
	}
</script>

<script>
	$(document).on('submit','#create_set_form',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('examination/create_set'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				//alert('New Set Created');
				$('#create_set_modal').modal('hide');
				$("#create_set_form").trigger("reset");
				get_examinations();
				get_sets(datas[0].value);
				
			}
			else
			{
				alert('Try After Some Time.');
			}
		},request_url, datas, 'text');
	});
</script>
<script>
	$(document).on('click','.view_question',function(e)
	{
		$('#view_question_modal').modal('show');
		var datas = {'set_id':$(this).attr('data-set_id')};
		var request_url = "<?php echo base_url('examination/get_question_to_view'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var tr = '';
				var i = 1;
				if(res.datas)
				{
					$.each(res.datas,function(index,element)
					{
						tr += '<tr><td>'+(i)+'</td><td>'+element.question+'</td>';
						$.each(element.option,function(ine,ele)
						{
							if(element.option_correct[ine] == 0)
							{
								tr += '<td>'+ele+'</td>';
							}
							else
							{
								tr += '<td style="color:green;font-weight:bold;">'+ele+'</td>';
							}
						});
						tr += '</tr>';
						i++;
					});
					$('#view_question_modal #question_container').html(tr);
				}
				else
				{
					var tr = '<tr><td colspan="6">No Question Available</td></tr>';
					$('#view_question_modal #question_container').html(tr);
				}
			}
			else
			{
				alert('Try After Some Time.');
			}
		},request_url, datas, 'text');
	});
</script>