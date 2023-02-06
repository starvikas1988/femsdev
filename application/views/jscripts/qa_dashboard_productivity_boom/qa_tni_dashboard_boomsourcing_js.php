<script>	
$(document).ready(function(e){
	
	$('#from_date').datepicker();
	$('#to_date').datepicker();
	
	$('#office_id').select2();
	
	
	$("#process_id").on('change',function(){
		var pid = this.value;
		//if(pid=="") alert("--Select Process--");
		var URL='<?php echo base_url();?>Qa_tni_dashboard_boomsourcing/getLocation';
		$('#sktPleaseWait').modal('show');
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'pid='+pid,
		   success: function(pList){
				var json_obj = $.parseJSON(pList);//parse JSON
				$('#office_id').empty();	
				$('#office_id').append($('<option></option>').val('ALL').html('ALL'));
				
				for (var i in json_obj){
					$('#office_id').append($('<option></option>').val(json_obj[i].abbr).html(json_obj[i].office_name));
				}
				
				$('#sktPleaseWait').modal('hide');	
			},
			error: function(){	
				alert('Fail!');
			}
		}); 
	});
	
		
});
</script>