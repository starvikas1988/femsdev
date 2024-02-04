<script type="text/javascript">

$(document).ready(function(){

	$("#m_type").val('');
		



$("#client_id").change(function(){
	
	var client_id=$(this).val();
	
	populate_process_combo(client_id);

});
	
$("#m_type").change(function(){
		
		var m_type=$(this).val();

		
		if(m_type==1){
			
			$('#div_process').hide();
			$('#div_dept').hide();
			$('#div_role').show();
			$('#role_id').attr('required', 'required');
			$('#process_id').removeAttr('required');
		}else if(m_type==2 ){ 
			
			$('#div_role').hide();
			$('#div_dept').hide();
			$('#div_process').show();
			$('#process_id').attr('required', 'required');
			$('#role_id').removeAttr('required');
		}else if(m_type==3 ){ 
			$('#div_role').hide();
			$('#div_process').hide();
			$('#div_dept').show();
			$('#role_id').removeAttr('required');
			$('#process_id').removeAttr('required');
		}else{
		
			$('#div_role').hide();
			$('#div_process').hide();
			$('#div_dept').hide();
			
		}
	});
	
	var timeOffset="-300";
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
	
	
	var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        maxDate   : new Date()
    }
	
	$("#m_date").datepicker($.extend({},datepickersOpt));
	
	$( "#start_date" ).datepicker({maxDate: new Date()});
	$( "#end_date" ).datepicker({ maxDate: new Date() });
	
});

</script>