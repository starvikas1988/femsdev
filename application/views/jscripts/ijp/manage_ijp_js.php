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
				location.reload();
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
	$(document).on('click',".view_application",function(e){
		e.preventDefault();
		//$('#view_application_modal').modal('show');
		var a = $(this);
		$(this).parent().parent().next('.application_container').toggle();
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/get_application'); ?>";
		if($(this).parent().parent().next('.application_container').is(":visible"))
		{
			process_ajax(function(response)
			{
				if(response != '')
				{
					a.parent().parent().next('.application_container').find('.applications').html(response);
				}
			},request_url, datas, 'text');
		}
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

<script>
	$(document).on('click',".reject_application",function(e){
		e.preventDefault();
		var a = $(this);
		var user_id = $(this).attr('data-user_id');
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'user_id':user_id,'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/reject_application'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				a.parent().parent().remove();
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',".schedule_interview",function(e){
		e.preventDefault();
		var a = $(this);
		$('#schedule_interview_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/schedule_interview'); ?>";
		$('.remove').remove();
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#schedule_interview_modal').find('tbody').append(res.datas);
			}
			else
			{
				$('#schedule_interview_modal').modal('hide');
				alert('No Candidate to Schedule Interview');
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',"#all_select",function(e){
	
		if($(this).is(':checked'))
		{
			$('[name="select[]"]').prop('checked', true);
		}
		else
		{
			$('[name="select[]"]').prop('checked', false);
		}
	});
	$(function () {
		$('#schedule_datetime').datetimepicker({
			dateFormat: 'yy-mm-dd', 
			timeFormat: 'HH:mm:ss'
		});
	});
</script>


<script>
	
	$(document).on('submit',"#schedule_interview_form",function(e){
		e.preventDefault();
		var a = $(this);
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('ijp/schedule_interview_process'); ?>";
		
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				location.reload();
				$('.remove').remove();
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',".interview_qualified",function(e){
		$('#interview_qualifeid_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		var user_id = $(this).attr('data-user_id');
		var filter_type = $(this).attr('data-filter_type');
		$('#interview_qualifeid_form [name="requisition_id"],#interview_qualifeid_form [name="user_id"],#interview_qualifeid_form [name="filter_type"]').remove();
		$('#interview_qualifeid_form').append('<input type="hidden" name="requisition_id" value="'+requisition_id+'">');
		$('#interview_qualifeid_form').append('<input type="hidden" name="user_id" value="'+user_id+'">');
		$('#interview_qualifeid_form').append('<input type="hidden" name="filter_type" value="'+filter_type+'">');
	});
</script>

<script>
	
	$(document).on('submit',"#interview_qualifeid_form",function(e){
		e.preventDefault();
		var a = $(this);
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('ijp/process_interview'); ?>";
		
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				location.reload();
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',".close_application",function(e){
		e.preventDefault();
		var a = $(this);
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/close_application'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				location.reload();
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',".close_interview",function(e){
		e.preventDefault();
		var a = $(this);
		var filter_type = $(this).attr('data-filter_type');
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id,'filter_type':filter_type};
		var request_url = "<?php echo base_url('ijp/close_interview'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				location.reload();
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',".filter_test_result",function(e){
		$('#filter_test_result_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		var user_id = $(this).attr('data-user_id');
		var filter_type = $(this).attr('data-filter_type');
		$('#filter_test_result_form [name="requisition_id"],#filter_test_result_form [name="user_id"],#filter_test_result_form [name="filter_type"]').remove();
		$('#filter_test_result_form').append('<input type="hidden" name="requisition_id" value="'+requisition_id+'">');
		$('#filter_test_result_form').append('<input type="hidden" name="user_id" value="'+user_id+'">');
		$('#filter_test_result_form').append('<input type="hidden" name="filter_type" value="'+filter_type+'">');
	});
</script>

<script>
	
	$(document).on('submit',"#filter_test_result_form",function(e){
		e.preventDefault();
		var a = $(this);
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('ijp/filter_test_result_process'); ?>";
		
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				location.reload();
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',".close_filter_type",function(e){
		e.preventDefault();
		var a = $(this);
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/close_filter_type'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				location.reload();
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',".final_selection",function(e){
		e.preventDefault();
		var a = $(this);
		$('#final_selection_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/final_application'); ?>";
		$('.remove').remove();
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#final_selection_modal').find('tbody').html(res.datas);
			}
			else
			{
				$('#final_selection_modal').modal('hide');
				alert('No Candidate to Schedule Interview');
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',"#final_selection_form [name='select[]']",function(e){
		var i = 0;
		$('#final_selection_form [name="select[]"]').each(function(index,element)
		{
			if($(element).is(':checked'))
			{
				i++;
			}
		});
		//alert(i);
		var no_of_position = parseInt($('#final_selection_form #no_of_position').val());
		//alert(no_of_position);
		if(no_of_position == i)
		{
			$('#final_selection_form [name="select[]"]:not(:checked)').each(function(index,element)
			{
				$(element).attr("disabled", true);
			});
		}
		else if(no_of_position > i)
		{
			$('#final_selection_form [name="select[]"]').each(function(index,element)
			{
				$(element).removeAttr("disabled");
			});
		}
	});
</script>

<script>
	
	$(document).on('submit',"#final_selection_form",function(e){
		e.preventDefault();
		var a = $(this);
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('ijp/final_selection'); ?>";
		
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				location.reload();
			}
			
		},request_url, datas, 'text');
	});
</script>

<!--Filter Test-->
<script>
	$(document).on('click',".schedule_filter_test",function(e){
		e.preventDefault();
		var a = $(this);
		$('#schedule_filter_test_modal').modal('show');
		/* $('#final_selection_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('ijp/final_application'); ?>";
		$('.remove').remove();
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#final_selection_modal').find('tbody').html(res.datas);
			}
			else
			{
				$('#final_selection_modal').modal('hide');
				alert('No Candidate to Schedule Interview');
			}
			
		},request_url, datas, 'text'); */
	});
</script>