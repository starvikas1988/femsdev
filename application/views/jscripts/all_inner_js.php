<script src="<?php echo base_url(); ?>assets/clipboardjs-master/dist/clipboard.min.js"></script>
<script type="text/javascript">
var baseURL = "<?php echo base_url();?>";
var processAttendanc="N";

$(document).ready(function(){	

	
	var clipboard = new ClipboardJS('.support_img');

	clipboard.on('success', function(e) {
		console.info('Action:', e.action);
		console.info('Text:', e.text);
		console.info('Trigger:', e.trigger);
		var cp_elm_id = e.trigger.dataset.clipboardTarget;
		$(`${cp_elm_id}_copied`).show();
		setTimeout( function(){ $(`${cp_elm_id}_copied`).hide();} , 2000);    
		console.log(e.trigger.dataset.clipboardTarget);
		e.clearSelection();
	});

	clipboard.on('error', function(e) {
		console.error('Action:', e.action);
		console.error('Trigger:', e.trigger);
	});

	$("#viewModalAttendance").click(function(){	

		if(processAttendanc=="Y"){			
			$('#attendance_model').modal('show');			
		}else{			
			$('#sktPleaseWait').modal('show');			
			var rURL=baseURL+'mytimepopup/getCurrentAttendanceforinnerpages';			
			$.ajax({
			   type: 'POST',    
			   url:rURL,
			   success: function(tbDtata){
				   
				   $('#sktPleaseWait').modal('hide');
				   $('#attendance_model').modal('show');	
				   $('#currAttendanceTable').html(tbDtata);
				   processAttendanc = "Y";
				   
				},
				error: function(){	
					alert('Fail!');
					$('#sktPleaseWait').modal('hide');
				}
			  });		
		}
	});
});
































</script>






