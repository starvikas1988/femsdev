<script>
$('#create_progression_form [name="applicable_location[]"]').select2();
function load_popup_data(r_id)
{
	var datas = {'requisition_id':r_id};
	var request_url = "<?php echo base_url('progression/get_application'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if(res != '')
		{
			$('#view_applications_modal #applications_container').html(res);
		}
	},request_url, datas, 'text');
}
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
	$('#create_progression_form').trigger("reset");
	$('#create_progression_form #process_id').html('');
	$('#create_progression_form #hiring_manager_id').html('');
	$('#create_progression_form #requisition_id').removeAttr('value');
	$('#create_progression_form [name="applicable_location[]"]').select2();
});

$("#client_id").change(function(){
	var client_id=$(this).val();
	
	populate_process_combo(client_id,'','process_id','N');
});
$("#dept_id").change(function(){
	var dept=$(this).val();
	populate_sub_dept_combo(dept,'','sub_debt_id','N')
});
$('#ffunction').on('change',function()
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
		$('#process_id').select2({
			placeholder: "Select Process",
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
						
						list += '<option value="'+element.id+'">'+element.name+" ("+element.office_id+"-"+element.dept_name+")" + '</option>';
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
				$('#create_progression_modal').modal('hide');
				
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
		$('#view_applications_modal').modal('show');
		$('#applications_container_reject').hide();
		e.preventDefault();
		var a = $(this);
		//$(this).parent().parent().next('.application_container').toggle();
		var requisition_id = $(this).attr('data-requisition_id');
		var life_cycle = $(this).attr('data-life_cycle');
		if(life_cycle=="FTSC"){ 
			$('#btn_bulk_reject_filtertest').show(); 
			$('#btn_bulk_reject_filtertest').attr("data-requisition_id",requisition_id);
		}else $('#btn_bulk_reject_filtertest').hide();
		
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('progression/get_application'); ?>";
		/* if($(this).parent().parent().next('.application_container').is(":visible"))
		{
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res != '')
				{
					a.parent().parent().next('.application_container').find('.applications').html(res);
					$('#view_applications_modal #applications_container').html(res);
				}
			},request_url, datas, 'text');
		} */
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res != '')
			{
				$('#view_applications_modal #applications_container').html(res);
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
		if(confirm("Are You Sure?"))
		{
			var request_url = "<?php echo base_url('progression/approve_application'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					var datas = $('#search_progression_requisition').serializeArray();
					get_requisition_result(datas);
					load_popup_data(requisition_id);
				}
				
			},request_url, datas, 'text');
		}
	});
</script>

<script>
	$(document).on('click','.reject_application_btn',function()
	{
		
		$('#rejet_application_modal').modal('show');
		$('#view_applications_modal').modal('hide');
		var requisition_id = $(this).attr('data-requisition_id');
		var user_id = $(this).attr('data-user_id');
		$('#rejet_application_form #requisition_id').val(requisition_id);
		$('#rejet_application_form #user_id').val(user_id);
	});
	
	$(document).on('submit',"#rejet_application_form",function(e){
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('progression/reject_application'); ?>";
		if(confirm("Are You Sure?"))
		{
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
		}
	});
</script>
<script>
	$(document).on('click','.reject_filtertest_btn',function()
	{
		var exam_schedule_id = $(this).attr('data-exam_schedule_id');
		var datas = {'exam_schedule_id':exam_schedule_id};
		var request_url = "<?php echo base_url('examination/reject_exam'); ?>";
		if(confirm("Are You Sure?"))
		{
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					var datas = $('#search_progression_requisition').serializeArray();
					get_requisition_result(datas);
					$('#view_applications_modal').modal('hide');
				}
				
			},request_url, datas, 'text');
		}
	});
	
	$(document).on('click','#btn_bulk_reject_filtertest',function()
	{
		var requisition_id = $(this).attr('data-requisition_id');
		
		//alert(requisition_id);
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('examination/reject_exam_all'); ?>";
		if(confirm("Are You Sure?"))
		{
			$('#view_applications_modal').modal('hide');
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				
				if(res.stat == true)
				{
					var datas = $('#search_progression_requisition').serializeArray();
					//get_requisition_result(datas);
					//$('#view_applications_modal').modal('hide');
					window.location.reload();
				}
				
			},request_url, datas, 'text');
		}
	});
	
	
</script>


<script>
	$(document).on('click','.schedule_interview',function()
	{
		$('#schedule_interview_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		var location = $(this).attr('data-location');
		var hiring_manager_id = $(this).attr('data-hiring_manager_id');
		$('#schedule_interview_form #requisition_id').val(requisition_id);
		$('#schedule_interview_form #location_id').val(location);
		$('#schedule_interview_form #hiring_manager_id').val(hiring_manager_id);
		
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
					list_hr += '<option value="'+element.id+'">'+element.name+" ("+ element.office_id +")</option>";
				});
				
				$.each(res.datas_np_manager,function(index,element)
				{
					list_np += '<option value="'+element.id+'">'+element.name +" ("+ element.office_id +")</option>";
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
		var new_date = currentDate; //.addDays(2);
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
		if($('[name="select_for_interview[]"]').is(':checked'))
		{
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
		}
		else
		{
			alert('Please Select a Candidate');
		}
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
		var filter_test = $(this).attr('data-filter_test');
		var datas = {'requisition_id':requisition_id,'user_id':user_id,'filter_test':filter_test};
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
	$(document).on('click','.final_selection,.final_selection_basic,.agent_final_selection_basic',function()
	{
		var click_type1 = $(this).hasClass('final_selection_basic');
		var click_type = $(this).hasClass('final_selection');
		var click_type2 = $(this).hasClass('agent_final_selection_basic');
		if(click_type1)
		{
			$('#final_selection_basic_modal').modal('show');
		}
		if(click_type)
		{
			$('#final_selection_modal').modal('show');
		}
		if(click_type2)
		{
			$('#agent_final_selection_basic_modal').modal('show');
		}
		var requisition_id = $(this).attr('data-requisition_id');
		var no_of_position = $(this).attr('data-no_of_position');
		var location = $(this).attr('data-location');
		var hiring_manager_id = $(this).attr('data-hiring_manager_id');
		$('#final_selection_form #requisition_id').val(requisition_id);
		$('#final_selection_form #no_of_position').val(no_of_position);
		$('#final_selection_form #location').val(location);
		$('#final_selection_form #hiring_manager_id').val(hiring_manager_id);
		
		var datas = {'requisition_id':requisition_id,'location':location,'no_of_position':no_of_position,'hiring_manager_id':hiring_manager_id};
		var request_url = "<?php echo base_url('progression/get_final_selection'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			
			if(res.stat == true)
			{
				if(click_type1)
				{
					var tr = '';
					$.each(res.datas,function(index,element)
					{
						
						var trCss=((element.status=="JoinDateDone") ? "trJDD" : "");
						
						tr += '<tr ><td rowspan="'+element.scores.length+'"> </td><td class="'+trCss+'" rowspan="'+element.scores.length+'">'+element.name+'</td><td rowspan="'+element.scores.length+'">'+element.fusion_id+'</td><td>'+element.interviewer_name[0]+'</td><td>'+element.scores[0]+'</td><td width="50%">'+element.remarks[0]+'</td></tr>';
						
						$.each(element.scores,function(ind,ele)
						{
							if(ind > 0)
							{
								
								var trSCss=((element.scores[ind]==null) ? "trPending" : "");
								
								tr += '<tr class="'+trSCss+'"><td>'+element.interviewer_name[ind]+'</td><td>'+((element.scores[ind]==null) ? "Pending" : element.scores[ind]) +'</td><td>'+((element.remarks[ind]==null) ? "Pending" : element.remarks[ind])+'</td></tr>';
							}
						});
					
						
					});
					$('#final_selection_basic_container').html(tr);
				}
				if(click_type)
				{
					var tr = '';
					$.each(res.datas,function(index,element)
					{
						tr += '<tr><td rowspan="'+element.scores.length+'"><input type="checkbox" name="select_candidate[]" id="select_candidate" value="'+element.id+'"></td><td rowspan="'+element.scores.length+'">'+element.name+'</td><td rowspan="'+element.scores.length+'">'+element.fusion_id+'</td><td>'+element.interviewer_name[0]+'</td><td>'+element.scores[0]+'</td><td width="50%">'+element.remarks[0]+'</td></tr>';
						
						$.each(element.scores,function(ind,ele)
						{
							if(ind > 0)
							{
								tr += '<tr><td>'+element.interviewer_name[ind]+'</td><td>'+element.scores[ind]+'</td><td>'+element.remarks[ind]+'</td></tr>';
							}
						});
					
						
					});
					$('#final_selection_container').html(tr);
				}
				if(click_type2)
				{
					var tr = '';
					$.each(res.datas,function(index,element)
					{
						tr += '<tr><td rowspan="'+element.scores.length+'">'+element.name+'</td><td rowspan="'+element.scores.length+'">'+element.fusion_id+'</td><td>'+element.interviewer_name[0]+'</td><td width="50%">'+element.remarks[0]+'</td></tr>';
						
						$.each(element.scores,function(ind,ele)
						{
							if(ind > 0)
							{
								tr += '<tr><td>'+element.interviewer_name[ind]+'</td><td>'+((element.remarks[ind]==null) ? "Pending" : element.remarks[ind])+'</td></tr>';
							}
						});
					
						
					});
					$('#agent_final_selection_basic_modal').html(tr);
				}
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
		if($('[name="select_candidate[]"]').is(":checked"))
		{
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
		}
		else
		{
			alert('Please Select a Candidate');
		}
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
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
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
<script>
	var today = new Date();
	today.setDate(today.getDate() + 1);
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	$('#update_due_date_form [name="due_date"]').attr('min',yyyy+'-'+mm+'-'+dd);
	$('#create_progression_form [name="due_date"]').attr('min',yyyy+'-'+mm+'-'+dd);
	$('#set_role_selection_form [name="new_joining_date[]"]').attr('min',yyyy+'-'+mm+'-'+dd);
</script>

<script>
	$(document).on('click',".start_filter_test",function(e){
		$('#start_filter_test_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		$('#start_filter_test_form #requisition_id').val(requisition_id);
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('progression/get_scheduled_time'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var options = '<option value="">--Select a Start Time--</option>';
				$.each(res.datas,function(index,element)
				{
					options += '<option value="'+element.exam_start_time+'">'+element.exam_start_time+'</option>';
				});
				$('#scheduled_exam_time').html(options);
			}
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('change',"#scheduled_exam_time",function(e){
		
		var scheduled_exam_time = $(this).val();
		var requisition_id = $('#start_filter_test_form #requisition_id').val();
		var datas = {'scheduled_exam_time':scheduled_exam_time,'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('progression/get_scheduled_candidates'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var tr = '';
				$.each(res.datas,function(index,element)
				{
					tr += '<tr><td><input type="checkbox" name="candiates[]" value="'+element.user_id+'"></td><td>'+element.candidate_name+'</td><td>'+element.fusion_id+'</td></tr>';
				});
				$('#start_filter_test_container').html(tr);
			}
			else
			{
				tr = '<tr><td colspan="3" class="text-center">No Candidate Found</td></tr>';
				$('#start_filter_test_container').html(tr);
			}
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('submit',"#start_filter_test_form",function(e){
		e.preventDefault();
		var datas = $(this).serializeArray();
		if(typeof $('#start_filter_test_form [name="candiates[]"]:checked').val() === "undefined")
		{
			alert('Please Select a Candidate');
			
		}
		else
		{
			var request_url = "<?php echo base_url('progression/start_exam'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					$('#start_filter_test_modal').modal('hide');
					var datas = $('#search_progression_requisition').serializeArray();
					get_requisition_result(datas);
				}
			},request_url, datas, 'text');
		}
	});
</script>
<script>
	$(document).on('click',"#start_all_filter_test",function(e){
		if($(this).is(':checked'))
		{
			$('#start_filter_test_form [name="candiates[]"]').prop('checked',true);
		}
		else
		{
			$('#start_filter_test_form [name="candiates[]"]').prop('checked',false);
		}
		
	});
</script>
<script>
	$(document).on('click',".set_role_selection",function(e){
		$('#set_role_selection_modal').modal('show');
		var requisition_id = $(this).attr('data-requisition_id');
		var ffunction = $(this).attr('data-function');
		$('#set_role_selection_form #requisition_id').val(requisition_id);
		$('#set_role_selection_form #ffunction').val(ffunction);
		var datas = {'requisition_id':requisition_id,'ffunction':ffunction};
		var request_url = "<?php echo base_url('progression/get_selected_candidate'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var tr = '';
				$.each(res.datas.user_list,function(index,element)
				{
					tr += '<tr><td>'+element.candidate_name+'</td><td>'+element.fusion_id+'</td><td><input type="hidden" name="candiate_id[]" value="'+element.id+'"><input type="date" name="new_joining_date[]" class="form-control" required></td><td><select name="new_l1[]" class="form-control" required>';
					tr += '<option value="">--Select New L1--</option>';
					$.each(res.datas.tl,function(ind,ele)
					{
						tr += '<option value="'+ele.id+'">'+ele.fname+' '+ele.lname+' ('+ele.fusion_id+') ('+ele.shname+')</option>';
					});
					tr += '</select></td></tr>';
					$('#selected_user_container').html(tr);
				});
			}
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('submit',"#set_role_selection_form",function(e){
		e.preventDefault();
		var datas = $(this).serializeArray();
		if($('[name="new_joining_date[]"]').val() != '' && $('[name="new_l1[]"]').val() != '')
		{
			var request_url = "<?php echo base_url('progression/set_joing_date'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					$('#set_role_selection_modal').modal('hide');
					var datas = $('#search_progression_requisition').serializeArray();
					get_requisition_result(datas);
				}
			},request_url, datas, 'text');
		}
		else
		{
			alert('Please Select Joining Date and New L1');
		}
	});
</script>
<script>
	$(document).on('click',".update_due_date",function(e){
		$('#update_due_date_modal').modal('show');
		
		var requisition_id = $(this).attr('data-requisition_id');
		var due_date = $(this).attr('data-due_date');
		var job_desc = $(this).attr('data-job_desc');
				
		$('#update_due_date_form #requisition_id').val(requisition_id);
		$('#update_due_date_form #due_date').val(due_date);
		$('#update_due_date_form #job_desc').val(job_desc);
		
	});
</script>

<script>
	$(document).on('submit',"#update_due_date_form",function(e){
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('progression/update_due_date'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#update_due_date_modal').modal('hide');
				var datas = $('#search_progression_requisition').serializeArray();
				get_requisition_result(datas);
			}
		},request_url, datas, 'text');
		
	});
</script>
<script>
	$(document).on('click',".edit_progression",function(e){
		$('#create_progression_modal').modal('show');
		var datas = {'requisition_id':$(this).attr('data-requisition_id')};
		var request_url = "<?php echo base_url('progression/get_edit_requisition_data'); ?>";
		$('#create_progression_form #requisition_id').val($(this).attr('data-requisition_id'));
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#create_progression_modal #ffunction').val(res.datas['requistion_data'].ffunction).change();
				
				if(res.datas['requistion_data'].client_id != null)
				{
					$('#create_progression_modal #client_id').val(res.datas['requistion_data'].client_id);
					var process_array = res.datas['requistion_data'].process_id.split(',');
					var option = '<option></option>';
					$.each(res.datas['process_data'],function(index,element)
					{
						option += '<option value="'+element.id+'">'+element.name+'</option>';
					});
					$('#create_progression_modal #process_id').html(option);
					$('#create_progression_modal #process_id').val(process_array);
				}
				else
				{
					$('#create_progression_modal #dept_id').val(res.datas['requistion_data'].dept_id);
					var sub_debt_array = res.datas['requistion_data'].sub_debt_id.split(',');
					var option = '<option value="">--Select Sub Dept--</option>';
					$.each(res.datas['process_data'],function(index,element)
					{
						option += '<option value="'+element.id+'">'+element.name+'</option>';
					});
					$('#create_progression_modal #sub_debt_id').html(option);
					$('#create_progression_modal #sub_debt_id').val(sub_debt_array);
				}
				
				$('#create_progression_modal [name="applicable_location[]"]').select2();
				if(res.datas['requistion_data'].applicable_location != "" || res.datas['requistion_data'].applicable_location != null || res.datas['requistion_data'].applicable_location != "undefined"){
					$('#create_progression_modal [name="applicable_location[]"]').val(res.datas['requistion_data'].applicable_location.split(','));
					$('#create_progression_modal [name="applicable_location[]"]').select2();
				}
				
				$('#create_progression_modal [name="location_id"]').val(res.datas['requistion_data'].location_id);
				$('#create_progression_modal [name="new_designation_id"]').val(res.datas['requistion_data'].new_designation_id).change();
				$('#create_progression_modal [name="posting_type"]').val(res.datas['requistion_data'].posting_type).change();
				$('#create_progression_modal [name="movement_type"]').val(res.datas['requistion_data'].movement_type).change();
				$('#create_progression_modal [name="request_reason_id"]').val(res.datas['requistion_data'].request_reason_id).change();
				$('#create_progression_modal [name="filter_type"]').val(res.datas['requistion_data'].filter_type).change();
				$('#create_progression_modal [name="no_of_position"]').val(res.datas['requistion_data'].no_of_position).change();
				$('#create_progression_modal [name="due_date"]').val(res.datas['requistion_data'].due_date).change();
				$('#create_progression_modal [name="role_id"]').val(res.datas['requistion_data'].role_id).change();
				
				var hiring_manager_array = res.datas['requistion_data'].hiring_manager_id.split(',');
				
				var option = '<option></option>';
				$.each(res.datas['hiring_manage_data'],function(index,element)
				{
					option += '<option value="'+element.id+'" >'+element.name+'('+element.office_id+'-'+element.dept_name+')</option>';
				});
				$('#create_progression_modal #hiring_manager_id').html(option);
				$('#create_progression_modal #hiring_manager_id').val(hiring_manager_array);
				$('#create_progression_modal #job_desc').val(res.datas['requistion_data'].job_desc);
			}
		},request_url, datas, 'text');
		
	});
	
	
	$(document).on('click','a.job_desc',function(e)
	{
		e.preventDefault();
		
		var job_desc = $(this).parent().attr('data-job_desc');
		$('#job_desc_modal').modal('show');
		$('#job_desc_modal_body').html(job_desc+'<br><br> <b>Please apply only if you have understood and agreed to the above terms.</b>');
	});

</script>

<script>
	$(document).on('change','[name="role_id"]',function(e){
		var role_id = $('[name="role_id"] option:selected').attr('data-role_org_id');
		$('[name="new_designation_id"]').val(role_id);
	});
</script>
<script>
	$(document).on('click','[class="bulck_reject"]',function(e){
		if($('[class="bulck_reject"]').is(":checked"))
		{
			$('#applications_container_reject').show();
		}
		else
		{
			$('#applications_container_reject').hide();
		}
	});
</script>
<script>
	$(document).on('submit','#applications_container_reject_form',function(e){
		var datas = $(this).serializeArray();
		e.preventDefault();
		var request_url = "<?php echo base_url('progression/bulck_reject'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#view_applications_modal').modal('hide');
			}
			else
			{
				alert('Unable to Process Data.');
			}
		},request_url, datas, 'text');
	});
</script>