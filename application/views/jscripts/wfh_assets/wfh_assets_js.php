<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
	
	$(".editwfhReturn").click(function(){
		var params=$(this).attr("params");
		wfh = params.split('##');
		$('.frmwfhAssets #alloc_id').val(wfh[0]);
		$('.frmwfhAssets #office_asset_info').val(wfh[1]);
		$('.frmwfhAssets #office_asset_sepecifications').val(wfh[2]);
		$('.frmwfhAssets #office_asset_headshet').val(wfh[3]);
		$('.frmwfhAssets #office_asset_dongle').val(wfh[4]);
		$('.frmwfhAssets #office_asset_sim').val(wfh[5]);
		$("#wfhAssetsModal").modal('show');
	
	});
	
	
	$('#default-datatable').DataTable({
		"pageLength":50
	});
	
	$("#wfhAssetsSubmit").click(function(){
		
		baseURL = "<?php echo base_url(); ?>";
		var uid=$('.frmwfhAssets #alloc_id').val().trim();
		
		if(uid!=""){
			$('#sktPleaseWait').modal('show');
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'wfh_assets/wfh_return_submit',
				data	:	$('form.frmwfhAssets').serialize(),
				success	:	function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#wfhAssetsModal').modal('hide');
							location.reload();
						}
			});
		}else{
			alert("One or More field's are blank");
		}	
	});
	
	$(".excelAsset").click(function(){
		office = $('#excel_office_id').val();
		sendUrl = "<?php echo base_url(); ?>wfh_assets/generate_wfh_assets_xls/" + office;
		window.location.href = sendUrl;
		//window.open( sendUrl );
		
	});
	
	
</script>