
<script>
$(document).on('change','.frmTermsUserOth #t_type_oth,.frmTerminateUser #t_type',function()
    {
		id = $('.frmTermsUserOth #t_type_oth,.frmTerminateUser #t_type').val();
		if(id=='11'){
			is_active='2';
		}else{
			is_active='1';
		}
		request_url="<?php echo base_url('super/sub_term'); ?>";
		var datas = {'is_active':  is_active};
		dts="";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			for(let i=0;i<res.length;i++){
				dts+='<option value="'+res[i]['id']+'">'+res[i]['name']+'</option>';
			}
			console.log(dts);
			$('.frmTermsUserOth #sub_t_type_oth,.frmTerminateUser #sub_t_type').html(dts);
		},request_url, datas, 'text');
		
		
	});
 </script>