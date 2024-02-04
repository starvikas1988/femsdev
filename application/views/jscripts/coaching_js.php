<script type="text/javascript">

$(document).ready(function(){
    
	
	// Add event listener for opening and closing details
    $('#default-datatable tbody').on('click', 'td.details-control', function (){
		
        var p = $(this).closest('tr');
		var tr = $(this).closest('tr').next('tr')
		tr.toggle();
		p.toggleClass( "shown" );
		
    });
		
	$("#client_id").change(function(){
		var client_id=$(this).val();
		populate_process_combo(client_id);
		
	});
	
	
	$("#fclient_id").change(function(){
		
		var client_id=$(this).val();
		
		var rid=$.cookie('role_id'); 
		
		//if(rid<=1 || rid==6){
		
			if(client_id=="1"){
				$("#foffice_div").hide();
				$("#fsite_div").show();
				$("#foffice_id").val('ALL');
				
			}else{
				$("#fsite_div").hide();
				$("#foffice_div").show();
				$("#fsite_id").val('ALL');
			}
			
		//}
		
		populate_process_combo(client_id,'','fprocess_id','Y');
		
	});
	
	
	
    $("#reset").click(function(){
		$("#assigned_to_div").hide();
		$("#site_div").hide();
		$("#process_div").hide();
		$('#assigned_to').removeAttr('required');
		$('#process_id').removeAttr('required');
		$('#site_id').removeAttr('required');
				
					
	});
	
	 

});


$(function(){
    
	$("#focus_area").select2();
	
	var timeOffset="-300";
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
	
		
	/* global setting */
    var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timeFormat: "HH:mm",
		timezone: timeOffset,
        minDate   : "-7D"
    }
	
	$("#coaching_date").datetimepicker($.extend({},datepickersOpt));
	
	$("#next_coaching_date").datetimepicker($.extend({},datepickersOpt));
	
	$( "#start_date" ).datepicker({maxDate: new Date()});
	
	$( "#end_date" ).datepicker({ maxDate: new Date() });
	
})

    
</script>

