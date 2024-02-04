
<script>
	$(function () {
		$('#review_date').datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});
</script>

<script>
	$('#manager_review,#agent_review_submit').on('submit',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray()
		var url = "<?php echo base_url('qa_oyo/process_review'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				window.location.href = "<?php echo base_url('qa_oyo'); ?>";
			}
			else
			{
				alert('Try Afer Some Time');
			}
		},url,datas, 'text');
	});
</script>

<script>
	$(document).ready(function(){
		$("#agent_review_submit").submit(function (e){
			$('#btnAgentSave').prop('disabled',true);
		});
		
		$("#manager_review").submit(function (e){
			$('#btnMgntSave').prop('disabled',true);
		});
	});
</script>