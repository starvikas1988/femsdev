<script>
$(document).ready(function() {
	var datas = $('#search_progression_requisition').serializeArray();
	get_requisition_result(datas);
});

function get_requisition_result(datas)
{
	var requisition_id = $('#search_progression_requisition #requisition_id').val();
	var request_url = "<?php echo base_url('progression/get_requisition_result'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if(res.stat == true)
		{
			$('#progression_search_container').html(res.datas);
			var list = '<option value="">ALL</option>';
			$.each(res.get_requisition_ids,function(index,element)
			{
				if(requisition_id == element.requisition_id)
				{
					list += '<option value="'+element.requisition_id+'" selected>'+element.requisition_id+'</option>';
				}
				else
				{
					list += '<option value="'+element.requisition_id+'">'+element.requisition_id+'</option>';
				}
			});
			$('#search_progression_requisition #requisition_id').html(list);
		}
		else
		{
			alert('Try After Some Time.');
		}
	},request_url, datas, 'text');
}

$('#create_progression_btn').on('click',function()
{
	$('#create_progression_modal').modal('show');
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
	$(document).ready(function() {
		$('#hiring_manager_id').select2({
			placeholder: "Type Hiring Manager",
			dropdownParent: $("#create_progression_modal"),
			multiple: true
		});
	});
</script>

<script>
	$('#create_progression_form [name="location_id"]').on('change',function()
	{
		var datas = {'office_id':$(this).val()};
		var request_url = "<?php echo base_url('progression/get_hiring_manager'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var list = '<option></option>';
				if(res.stat == true)
				{
					//console.log(res.datas);
					$.each(res.datas,function(index,element)
					{
						//console.log(element);
						
						list += '<option value="'+element.id+'">'+element.name+'</option>';
					});
				}
				list += '';
				$('#create_progression_form #hiring_manager_id').html(list);
			}
			else
			{
				alert('Try After Some Time.');
			}
		},request_url, datas, 'text');
	});
</script>

<script>
	$('#create_progression_form').on('submit',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('progression/process_progression_requisition'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#create_progression_form #client_container,#create_progression_form #dept_container').hide();
				$('#create_progression_form')[0].reset();
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
				$('#create_ijp_modal').modal('hide');
				
			}
			else
			{
				alert('Try After Some Time.');
			}
		},request_url, datas, 'text');
	});
	
</script>

<script>
	$('#search_progression_requisition').on('change',function(e)
	{
		var datas = $('#search_progression_requisition').serializeArray();
		get_requisition_result(datas);
	});
	
</script>

<script>
	$(document).on('click',".approve_progression",function(e){
		e.preventDefault();
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('progression/approve_progression'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
			}
			
		},request_url, datas, 'text');
	});
</script>


<script>
	$(document).on('click','.close_progression_btn',function()
	{
		
		$('#close_progression_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		$('#close_progression_form #requisition_id').val(requisition_id);
	});
	$(document).on('submit',"#close_progression_form",function(e){
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('progression/close_progression'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
				$('#close_progression_modal').modal('hide');
				$('#close_progression_form')[0].reset();
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click',".view_applications",function(e){
		
		e.preventDefault();
		var a = $(this);
		$(this).parent().parent().next('.application_container').toggle();
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('progression/get_application'); ?>";
		if($(this).parent().parent().next('.application_container').is(":visible"))
		{
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res != '')
				{
					a.parent().parent().next('.application_container').find('.applications').html(res);
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
		var request_url = "<?php echo base_url('progression/approve_application'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click','.reject_application_btn',function()
	{
		
		$('#rejet_application_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		var user_id = $(this).attr('data-user_id');
		$('#rejet_application_form #requisition_id').val(requisition_id);
		$('#rejet_application_form #user_id').val(user_id);
	});
	$(document).on('submit',"#rejet_application_form",function(e){
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('progression/reject_application'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
				$('#rejet_application_modal').modal('hide');
				$('#rejet_application_form')[0].reset();
			}
			
		},request_url, datas, 'text');
	});
</script>


<script>
	$(document).on('click','.schedule_interview',function()
	{
		$('#schedule_interview_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		var location = $(this).attr('data-location');
		$('#schedule_interview_form #requisition_id').val(requisition_id);
		$('#schedule_interview_form #location_id').val(location);
		
		var datas = {'requisition_id':requisition_id,'office_id':location};
		var request_url = "<?php echo base_url('progression/get_approved_applications'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			
			if(res.stat == true)
			{
				var tr = '';
				$.each(res.datas,function(index,element)
				{
					tr += '<tr><td><input type="checkbox" name="select_for_interview[]" value="'+element.id+'"></td><td>'+element.name+'</td><td>'+element.fusion_id+'</td></tr>';
				});
				$('#schedule_interview_container').html(tr);
				if(res.datas.length == 0)
				{
					$('#schedule_interview_modal').modal('hide');
					$('#schedule_interview_form #interview_schedulue_time,#schedule_interview_form #interview_schedulue_end_time').val('');
					$('#schedule_interview_form #requisition_id').val('');
				}
			}
			
		},request_url, datas, 'text');
		
		var request_url = "<?php echo base_url('progression/get_requisition_hiring_manager'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			
			//var list = '<option></option>';
			var list = [];
			var list1 = '';
			var list_hr = '<option></option>';
			var list_np = '<option></option>';
			if(res.stat == true)
			{
				$.each(res.datas_hrigin_manager,function(index,element)
				{
					list[index] = element.name;
					list1 += '<input type="hidden" name="interviewers[]" class="hiring_managers" value="'+element.id+'">';
				});
				
				$.each(res.datas_hr_manager,function(index,element)
				{
					list_hr += '<option value="'+element.id+'">'+element.name+'</option>';
				});
				
				$.each(res.datas_np_manager,function(index,element)
				{
					list_np += '<option value="'+element.id+'">'+element.name+'</option>';
				});
			}
			//list += '';
			list_hr += '';
			list_np += '';
			$('#schedule_interview_form #h_managers').html(list.join(' , '));
			//$('#schedule_interview_form #hiring_managers').html(list);
			$('#schedule_interview_form #hr_panel').html(list_hr);
			$('#schedule_interview_form #neutral_panel').html(list_np);
			$('#ipd').html(list1);
			
		},request_url, datas, 'text');
	});
	
	
	$(document).on('click','#select_all_for_interview',function()
	{
		if($(this).is(':checked'))
		{
			$('#schedule_interview_form [name="select_for_interview[]"]').prop('checked',true);
		}
		else
		{
			$('#schedule_interview_form [name="select_for_interview[]"]').prop('checked',false);
		}
	});
	$(document).on('click','#schedule_interview_form [name="select_for_interview[]"]',function()
	{
		var no_of_approved_application = $('#schedule_interview_form [name="select_for_interview[]"]').length;
		var no_scheduled_application = $('#schedule_interview_form [name="select_for_interview[]"]:checked').length;
		
		if(no_of_approved_application == no_scheduled_application)
		{
			$('#select_all_for_interview').prop('checked',true);
		}
		else
		{
			$('#select_all_for_interview').prop('checked',false);
		}
	});
	$(function () {
		var currentDate = new Date();
		var new_date = currentDate.addDays(2);
		var month = new_date.getMonth()+1;
		var day = new_date.getDate();
		mindate =  new_date.getFullYear() + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;
		$('#interview_schedulue_time,#interview_schedulue_end_time,#exam_start_time').datetimepicker({
			dateFormat: 'yy-mm-dd', 
			timeFormat: 'HH:mm',
			minDate: mindate
		})
	});
	$(document).on('submit',"#schedule_interview_form",function(e){
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('progression/process_schedule_interview'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#schedule_interview_modal').modal('hide');
				$('#schedule_interview_form #interview_schedulue_time,#schedule_interview_form #interview_schedulue_end_time').val('');
				$('#schedule_interview_form #requisition_id').val('');
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click','.give_interview_marks',function()
	{
		$('#give_interview_marks_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		$('#give_interview_marks_form #requisition_id').val(requisition_id);
		
		var user_id = $(this).attr('data-user_id');
		$('#give_interview_marks_form #user_id').val(user_id);
	});
	$(document).on('submit',"#give_interview_marks_form",function(e){
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('progression/give_interview_marks'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#give_interview_marks_modal').modal('hide');
				$('#give_interview_marks_form #overall_interview_score').val('');
				$('#give_interview_marks_form #requisition_id').val('');
				$('#give_interview_marks_form #user_id').val('');
				$('#give_interview_marks_form #remarks').val('');
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click','.re_schedule_interview',function()
	{
		var requisition_id = $(this).attr('data-requisition_id');
		var user_id = $(this).attr('data-user_id');
		var datas = {'requisition_id':requisition_id,'user_id':user_id};
		var request_url = "<?php echo base_url('progression/re_schedule_interview'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click','.final_selection',function()
	{
		$('#final_selection_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		var no_of_position = $(this).attr('data-no_of_position');
		$('#final_selection_form #requisition_id').val(requisition_id);
		$('#final_selection_form #no_of_position').val(no_of_position);
		
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('progression/get_final_selection'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			
			if(res.stat == true)
			{
				var tr = '';
				$.each(res.datas,function(index,element)
				{
					tr += '<tr><td rowspan="'+element.scores.length+'"><input type="checkbox" name="select_candidate[]" id="select_candidate" value="'+element.id+'"></td><td rowspan="'+element.scores.length+'">'+element.name+'</td><td rowspan="'+element.scores.length+'">'+element.fusion_id+'</td><td>'+element.scores[0]+'</td><td width="50%">'+element.remarks[0]+'</td></tr>';
					
					$.each(element.scores,function(ind,ele)
					{
						if(ind > 0)
						{
							tr += '<tr><td>'+element.scores[ind]+'</td><td>'+element.remarks[ind]+'</td></tr>';
						}
					});
				
					
				});
				$('#final_selection_container').html(tr);
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).ready(function() {
		$('#hiring_managers').select2({
			placeholder: "Select Interviewer",
			dropdownParent: $("#schedule_interview_modal"),
			multiple: true
		});
		$('#hr_panel').select2({
			placeholder: "Select HR Panel",
			dropdownParent: $("#schedule_interview_modal")
		});
		$('#neutral_panel').select2({
			placeholder: "Select Neutral Panel",
			dropdownParent: $("#schedule_interview_modal")
		});
		
	});
</script>

<script>
	$(document).on('submit',"#final_selection_form",function(e){
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('progression/process_final_selection'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
				$('#final_selection_modal').modal('hide');
			}
			
		},request_url, datas, 'text');
	});
	$(document).on('click',"#scrap",function(e){
		e.preventDefault();
		var datas = $('#final_selection_form').serializeArray();
		var request_url = "<?php echo base_url('progression/process_final_selection/true'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
				$('#final_selection_modal').modal('hide');
			}
			
		},request_url, datas, 'text');
	});
	$(document).on('click','[name="select_candidate[]"]',function()
	{
		var no_of_position = $('#no_of_position').val();
		if($('[name="select_candidate[]"]:checked').length > no_of_position)
		{
			$(this).prop('checked',false);
			alert('Maximum Selected Candidate Limit Reached');
		}
	});
</script>

<script>
	$(document).on('click','.schedule_filter_test',function()
	{
		$('#schedule_filter_test_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		var location = $(this).attr('data-location');
		
		var datas = {'requisition_id':requisition_id,'location':location};
		
		$('#schedule_filter_test_form #requisition_id').val(requisition_id);
		$('#schedule_filter_test_form #location_id').val(location);
		
		var request_url = "<?php echo base_url('progression/get_un_assig_filter_test_users'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var tr = '';
				$.each(res.datas.users,function(index,element)
				{
					tr += '<tr><td><input type="checkbox" name="select_for_filter_test[]" value="'+element.user_id+'"></td><td>'+element.applicant_name+'</td><td>'+element.fusion_id+'</td></tr>';
				});
				$('#schedule_filter_test_container').html(tr);
				
				var option = '<option value="">--Select a Examination--</option>';
				$.each(res.datas.avail_exam,function(index,element)
				{
					option += '<option value="'+element.id+'">'+element.title+'</option>';
				});
				
				$('#schedule_filter_test_form #exam').html(option);
			}
			
		},request_url, datas, 'text');
	});
	$(document).on('click','#select_all_for_filter_test',function()
	{
		if($(this).is(':checked'))
		{
			$('[name="select_for_filter_test[]"]').prop('checked',true);
		}
		else
		{
			$('[name="select_for_filter_test[]"]').prop('checked',false);
		}
	});
	$(document).on('click','[name="select_for_filter_test[]"]',function()
	{
		var no_of_position = $('#no_of_position').val();
		if($('[name="select_for_filter_test[]"]').length == $('[name="select_for_filter_test[]"]:checked').length)
		{
			$('#select_all_for_filter_test').prop('checked',true);
		}
		else
		{
			$('#select_all_for_filter_test').prop('checked',false);
		}
	});
	$(document).on('submit',"#schedule_filter_test_form",function(e){
		e.preventDefault();
		if($('[name="select_for_filter_test[]"]:checked').length == 0)
		{
			alert('Please Select a Candidate');
		}
		else
		{
			var datas = $(this).serializeArray();
			var request_url = "<?php echo base_url('progression/schedule_filter_test'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					var datas = $('#search_progression_requisition').serializeArray();
					get_requisition_result(datas);
					$('#schedule_filter_test_modal').modal('hide');
				}
				
			},request_url, datas, 'text');
		}
	});
</script>

<script>
	$(document).on('click','.re_schedule_filter_test',function()
	{
		var requisition_id = $(this).attr('data-requisition_id');
		var user_id = $(this).attr('data-user_id');
		var datas = {'requisition_id':requisition_id,'user_id':user_id};
		var request_url = "<?php echo base_url('progression/re_schedule_filter_test'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click','.select_threshold',function()
	{
		$('#threshold_modal').modal('show');
		
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('progression/get_threshold'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var percentage_array = [];
				
				var i;
				for (i = 0; i < 10; i++)
				{
					if(!percentage_array[i])
					{
						percentage_array[i] = 0;
					}
				}
				
				$.each(res.datas,function(index,element)
				{
					var percentage = ((element.total_correct * 100)/element.no_of_question).toFixed(1);
					
					if(percentage >= 0 && percentage <= 9.9)
					{
						percentage_array[0] = percentage_array[0] + 1;
					}
					else if(percentage >= 10 && percentage <= 19.9)
					{
						percentage_array[1] = percentage_array[1] + 1;
					}
					else if(percentage >= 20 && percentage <= 29.9)
					{
						percentage_array[2] = percentage_array[2] + 1;
					}
					else if(percentage >= 30 && percentage <= 39.9)
					{
						percentage_array[3] = percentage_array[3] + 1;
					}
					else if(percentage >= 40 && percentage <= 49.9)
					{
						percentage_array[4] = percentage_array[4] + 1;
					}
					else if(percentage >= 50 && percentage <= 59.9)
					{
						percentage_array[5] = percentage_array[5] + 1;
					}
					else if(percentage >= 60 && percentage <= 69.9)
					{
						percentage_array[6] = percentage_array[6] + 1;
					}
					else if(percentage >= 70 && percentage <= 79.9)
					{
						percentage_array[7] = percentage_array[7] + 1;
					}
					else if(percentage >= 80 && percentage <= 89.9)
					{
						percentage_array[8] = percentage_array[8] + 1;
					}
					else if(percentage >= 90 && percentage <= 100)
					{
						percentage_array[9] = percentage_array[9] + 1;
					}
					
					
				});
				console.log(percentage_array);
				percentage_array.reverse();
				$('#threshold_container tr').each(function(index,element)
				{
					$(element).children('td:nth-of-type(2)').html(percentage_array[index]);
					$(element).children('td:nth-of-type(3)').children('button').attr('data-requisition_id',requisition_id);
				});
				/* var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas); */
			}
			
		},request_url, datas, 'text');
	});
</script>
<script>
	$(document).on('click','.selected_threshold',function()
	{
		var limit = $(this).attr('data-available');
		var requisition_id = $(this).attr('data-requisition_id');
		var datas = {'limit':limit,'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('progression/select_threshold_candidate'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#threshold_modal').modal('hide');
			}
		},request_url, datas, 'text');
	});
</script>
<script>
	$(document).on('change','#schedule_interview_form #hr_panel',function()
	{
		var hr_value = $(this).val();
		$('.hiring_managers').each(function(index,element)
		{
			if($(element).val() == hr_value)
			{
				$('#schedule_interview_form #neutral_panel').val('').trigger('change');
				return false;
			}
		});
	});
</script>

<script>
	$(document).on('change','#schedule_interview_form #neutral_panel',function()
	{
		var hr_value = $(this).val();
		$('.hiring_managers').each(function(index,element)
		{
			if($(element).val() == hr_value)
			{
				$('#schedule_interview_form #neutral_panel').val('').trigger('change');
				return false;
			}
			
		});
	});
</script>