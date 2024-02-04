<script>
	$(document).on('click','.appliy_requisition',function(e)
	{
		e.preventDefault()
		$('.process_user_credential_form').trigger("reset");
		$(this).parent().parent().next().find('div').slideToggle(100);
	});
	
	//=== Consent ============//
	/*$(document).on('click','.appliy_consent_requisition',function(e)
	{
		rid = $(this).attr('rid');
		e.preventDefault();
		if(confirm("Are you sure you want to relocate to another location?")){
			var request_url = "<?php echo base_url('progression/ijp_consent_application'); ?>";
			datas = { "rid" : rid };
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				console.log(res.id);
				if(res.stat == true)
				{				
					$('.apply_req_'+rid).find('.appliy_requisition').show();
					$('.apply_req_'+rid).find('.appliy_consent_requisition').hide();
				}
				
			},request_url, datas, 'text','POST');
		}
		else{
			return false;
		}
	});*/	
	
	$(document).on('click','.requisitionConsentAccept',function(e)
	{
		rid = $(this).attr('rid');
		consentComments = $(this).closest('tbody').find('textarea[name="consent_comments"]').val();
		if(consentComments == ""){
			alert('Please Enter Comments!');
			$(this).closest('tbody').find('textarea[name="consent_comments"]').focus();
		} else {
			$(this).closest('tbody').find('input[name="consent_accept"]').val('1');
			$(this).closest('tbody').find('.requisitionConsentCheckAccept').hide();
			$(this).closest('tbody').find('.requisitionuploadResume').show();
		}
	});
	
	$(document).on('click','.requisitionConsentNo',function(e)
	{
		rid = $(this).attr('rid');
		$(this).closest('tbody').find('textarea[name="consent_comments"]').val('');
		$(this).closest('div').slideToggle(100);
	});
	
</script>

<script>
	$(document).on('submit','.process_user_credential_form',function(e)
	{
		e.preventDefault();
		var datas = new FormData(this);
		var request_url = "<?php echo base_url('progression/submit_user_application'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				get_requisition_result();
			}else{
				alert(res.stat);
			}
			
		},request_url, datas, 'text','POST','file');
	});
	
</script>

<script>
$(document).ready(function() {
	get_requisition_result();
});

function get_requisition_result()
{
	var datas = {};
	var request_url = "<?php echo base_url('progression/get_apply_ijp'); ?>";
	process_ajax(function(response)
	{
		// alert('');
		var res = JSON.parse(response);

		console.log(res);
		if(res.stat == true)
		{
			$('#progression_search_container').html(res.datas);
					
		}
		else
		{
			$('#progression_search_container').html(res.datas);

		}
		// var table = $('#progression_apply').DataTable({
		// 			lengthChange: false,		
		// 		});
		// 		new $.fn.dataTable.Buttons(table, {
		// 			buttons: [{
		// 				extend: 'excelHtml5',
		// 				text: 'Export to Excel',
		// 				exportOptions: {
		// 					columns: ':not(:last-child)',
		// 				}
		// 			}, ]
		// 		});
		// 		table.buttons().container()
		// 			.appendTo($('.col-sm-6:eq(0)', table.table().container()))
	},request_url, datas, 'text');
	
	var request_url = "<?php echo base_url('progression/applied_progression'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if(res.stat == true)
		{
			$('#progression_applied').html(res.datas);

			var table = $('#applied_prog').DataTable({
		
		lengthChange: false,		
	});
	new $.fn.dataTable.Buttons(table, {
		buttons: [{
			extend: 'excelHtml5',
			text: 'Export to Excel',
			exportOptions: {
				columns: ':not(:last-child)',
			}
		}, ]
	});
	table.buttons().container()
		.appendTo($('.col-sm-6:eq(0)', table.table().container()))


		}
	},request_url, datas, 'text');
}
</script>

<script>
	/* setTimeout(function(){
		$('td[data-filter_test_time]').each(function(index,element)
		{
			var start = new Date('<?php echo ConvServerToLocalAny(date('Y-m-d H:i:s'),get_user_office_id()); ?>');
			var end = new Date(''+$(element).attr('data-filter_test_time')+'');
			var exam_end = new Date(''+$(element).attr('data-filter_test_end_time')+'');
			
			
			
			var exam_schedule_id = new Date(''+$(element).attr('data-exam_schedule_id')+''); */
			//console.log(start);
			//console.log($(element).attr('data-exam_schedule_id'));
			/* index = setInterval(function() {
				if((exam_end.getTime()-start.getTime()) <= 0)
				{
					$(element).next().html('Exam End')
				} */
				/* else if(start.getTime() > end.getTime())
				{
					$(element).next().html('Exam Inprogress');
				} */
				//else
				//{
					/* console.log(exam_end.getTime());
					console.log(end.getTime());
					console.log(start.getTime()); */
					/* start.setSeconds(start.getSeconds() + 1);
					timeBetweenDates(start,end,element,index);
				}
			}, 1000);
		});
	}, 3000); */
	/* var start = new Date('<?php echo $current_server_time; ?>');
	var end   = new Date('<?php echo $exam_info->exam_end_time; ?>');
	var timer;

	var compareDate = new Date();
	compareDate.setDate(compareDate.getDate() + 7); //just for this demo today + 7 days
*/
	/* timer = setInterval(function() {
	start.setSeconds(start.getSeconds() + 1);
	  timeBetweenDates(start,end);
	}, 1000); */

	function timeBetweenDates(start,end,element,index) {
	  var dateEntered = end;
	  var now = new Date(start);
	  var difference = dateEntered.getTime() - start.getTime();
		//console.log(difference);
	  if (difference <= 0) {
//alert();
		// Timer done
		clearInterval(index);
		$(element).next().html('<form method="POST" action="<?php echo base_url('examination/exam_panel'); ?>"><input type="hidden" name="lt_exam_schedule_id" value="'+$(element).attr('data-exam_schedule_id')+'"><button type="submit" class="btn btn-success btn-sm">Give Exam</button></form>');
		
		//if time over 
		//loop thorough all question ans marks as skip
		/* var datas = {'exam_schedule_id':<?php echo $exam_schedule_id; ?>};
		var request_url = "<?php echo base_url('examination/submit_examination'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				window.location.href = "<?php echo base_url('examination/examination_done_page'); ?>";
			}
			else
			{
				alert('Unable to Submit Examination. Server Error!');
			}
		},request_url, datas, 'text'); */
	  
	  } else {
		
		var seconds = Math.floor(difference / 1000);
		var minutes = Math.floor(seconds / 60);
		var hours = Math.floor(minutes / 60);
		var days = Math.floor(hours / 24);

		hours %= 24;
		minutes %= 60;
		seconds %= 60;
		//alert();
		$(element).next().text(days+' Days '+hours+'hr '+minutes+'min '+seconds+'sec');
	  }
	}
</script>

<script>
	$(document).on('click','.agent_final_selection_basic',function()
	{
		var click_type2 = $(this).hasClass('agent_final_selection_basic');
		
		if(click_type2)
		{
			$('#agent_final_selection_basic_modal').modal('show');
		}
		var requisition_id = $(this).attr('data-requisition_id');
		
		var datas = {'requisition_id':requisition_id};
		var request_url = "<?php echo base_url('progression/get_final_selection_agent'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			
			if(res.stat == true)
			{
				if(click_type2)
				{
					var tr = '';
					$.each(res.datas,function(index,element)
					{
						//tr += '<tr><td rowspan="'+element.scores.length+'">'+element.name+'</td><td rowspan="'+element.scores.length+'">'+element.fusion_id+'</td><td>'+element.interviewer_name[0]+'</td><td width="50%">'+element.remarks[0]+'</td></tr>';
						tr += '<tr><td rowspan="'+element.scores.length+'">'+element.name+'</td><td rowspan="'+element.scores.length+'">'+element.fusion_id+'</td><td width="50%">'+element.remarks[0]+'</td></tr>';
						
						$.each(element.scores,function(ind,ele)
						{
							if(ind > 0)
							{
								//tr += '<tr><td>'+element.interviewer_name[ind]+'</td><td>'+element.remarks[ind]+'</td></tr>';
								tr += '<tr><td>'+element.remarks[ind]+'</td></tr>';
							}
						});
					
						
					});
					$('#agent_final_selection_basic_container').html(tr);
				}
				else
				{
					alert('Nothing Found');
				}
			}
			
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click','a.job_desc',function(e)
	{
		e.preventDefault();
		
		var job_desc = $(this).parent().attr('data-job_desc');
		$('#job_desc_modal').modal('show');
		$('#job_desc_modal_body').html(job_desc+'<br><br> <b>Please apply only if you have understood and agreed to the above terms.</b>');
	});
</script>