<script>
	$('#create_ijp_btn').on('click',function()
	{
		$('#create_ijp_modal').modal('show');
	});
	$("#client_id").change(function(){
		var client_id=$(this).val();
		
		populate_process_combo(client_id,'','process_id','N');
	});
	$("#dept_id").change(function(){
		var dept=$(this).val();
		populate_sub_dept_combo(dept,'','sub_debt_id','N')
	});
	$('#function').on('change',function()
	{
		var val = $(this).val();
		$('#client_container,#dept_container').hide();
		$('#client_container select,#dept_container select').removeAttr('disabled');
		if(val=='Support')
		{
			$('#dept_container').show();
			$('#client_container select').attr('disabled','disabled');
		}
		else if(val=='Operation')
		{
			$('#client_container').show();
			$('#dept_container select').attr('disabled','disabled');
		}
	});
</script>

<script>
	$('#create_ijp_form').on('submit',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('ijp/process_ijp_requisition'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#client_container,#dept_container').hide();
				$('#create_ijp_form')[0].reset();
				alert('Information Saved.');
				$('#search_ijp_requisition').submit();
				$('#create_ijp_modal').modal('hide');
				location.reload();
			}
			else
			{
				alert('Try After Some Time.');
			}
		},request_url, datas, 'text');
	});
	
</script>
<script>
	$('#search_ijp_requisition').on('submit',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		console.log(datas);
		var request_url = "<?php echo base_url('ijp/get_requisition_result/true'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#ijp_search_container').html(res.datas);
			}
			
		},request_url, datas, 'text');
	});
	
</script>

<script>
	$("#location_id,#requisition_id,#posting_type,#movement_type").change(function(){
		$('#search_ijp_requisition').submit();
	});
</script>

<script>
	$(document).ready(function() {
		$('#hiring_manager_id').select2({
			placeholder: "Type Hiring Manager",
			allowClear: true,
			dropdownParent: $("#create_ijp_modal")
		});
	});
</script>

<script>
	$(document).on('click',".approve_requisition",function(e){
		e.preventDefault();
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/approve_requisition'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#search_ijp_requisition').submit();
			}
			
		},request_url, datas, 'text');
	});
</script>
<script>
	$(document).on('click',".appliy_requisition",function(e){
		e.preventDefault();
		$('.question_container').hide();
		$(this).parent().parent().next('.question_container').find('form')[0].reset();
		$(this).parent().parent().next('.question_container').toggle();
	});
</script>
<script>
	$('.process_user_credential').on('submit',function(e)
	{
		e.preventDefault();
		var datas = new FormData(this);
		console.log(datas);
		var request_url = "<?php echo base_url('ijp/submit_user_application'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				location.reload();
			}
			
		},request_url, datas, 'text','POST','file');
	});
	
</script>
<script>
	$(document).on('click',".view_life_cycle",function(e){
		e.preventDefault();
		$('#ijp_life_cycle_modal').modal('show');
		var requisition_id = $(this).text();
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/get_life_cycle'); ?>";
		process_ajax(function(response)
		{
			$('#life_cycle_msg').text(response);
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',".view_applications",function(e){
		e.preventDefault();
		var a = $(this);
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/get_application'); ?>";
		process_ajax(function(response)
		{
			if(response != '')
			{
				a.parent().parent().next().show();
				a.parent().parent().next().find('.applicants').html(response);
			}
		},request_url, datas, 'text');
	});
</script>
<script>
	$(document).on('click',".approve_application",function(e){
		e.preventDefault();
		var a = $(this);
		var user_id = $(this).attr('data-user_id');
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'user_id':user_id,'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/approve_application'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				a.parent().html('Approved');
			}
			
		},request_url, datas, 'text');
	});
</script>