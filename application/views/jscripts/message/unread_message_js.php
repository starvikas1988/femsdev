<script>
	$('.card').click(function()
	{
		var msg_id = $(this).attr('data-message_id');
		var datas = {'msg_id':msg_id};
		$.ajax({
			url: "<?php echo base_url('faq/read_msg'); ?>",
			type: "POST",
			data: datas,
			success:function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					console.log('Message Read');
				}
				else
				{
					console.log('Some Error! Try After Sometime.');
				}
			}
		});
	});
</script>