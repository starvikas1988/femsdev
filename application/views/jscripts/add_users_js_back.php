<script type="text/javascript">

$(document).ready(function(){
    
	
	$("#office_id").change(function(){
		
			
			$("#client_id").val('');
			$("#role_id").val('');
			$("#site_id").val('');
			
			$("#site_div").hide();
			$('#site_id').removeAttr('required');
			
			//$("#tr_nst_div").hide();
			
			$("#process_div").hide();		
			$('#process_id').removeAttr('required');
			
			$("#sub_process_div").hide();		
			$('#sub_process_id').removeAttr('required');
			
			$('#assigned_to').removeAttr('required');
			$("#assigned_to_div").hide();	
	
	});
	
	$("#client_id").change(function(){
		
		var client_id=$(this).val();
		
		$("#role_div").show();
		$("#role_id").val('');
		
		$("#site_id").val('');
		
		if(client_id=="1"){
		
			$("#site_div").show();
			$('#site_id').attr('required', 'required');
			
		}else{
					
			$("#site_div").hide();
			$('#site_id').removeAttr('required');
			
		}
		
			//$("#tr_nst_div").hide();
			
			$("#process_div").hide();		
			$('#process_id').removeAttr('required');
			
			$("#sub_process_div").hide();		
			$('#sub_process_id').removeAttr('required');
						
			$("#assigned_to_div").hide();
			$('#assigned_to').removeAttr('required');			
			
			populate_process_combo(client_id);
		
	});
	
	
	
	//////
	
	$("#process_id").change(function(){
	
		var process_id=$(this).val();
		$("#sub_process_div").show();
		
		populate_sub_process_combo(process_id);
			
	});
	
	
    $("#role_id").change(function(){
		
		var dept_id=$('#dept_id').val();
		var role_id=$(this).val();
		var office_id= $("#office_id").val();
		
		
		if(role_id>=1){
			
			if(dept_id==5 || dept_id==6 || dept_id==7 || dept_id==8){
				
				if(role_id == 2 || role_id == 3 || role_id == 5 || role_id == 7 || role_id == 8 || role_id == 9 ){
										
					$("#process_div").show();		
					$('#process_id').attr('required', 'required');
					
				}else{
				
					$("#process_div").hide();		
					$('#process_id').removeAttr('required');
					
					$("#sub_process_div").hide();		
					$('#sub_process_id').removeAttr('required');
				}
				
								
				if(role_id == 3 || role_id == 7 || role_id == 8 ){  //3->agent,7->Trainee ,8->nest
					
					populate_assign_combo(office_id);
					
					$("#assigned_to_div").show();		
					$('#assigned_to').attr('required', 'required');	
					
				}else {
					
					$('#assigned_to').removeAttr('required');
					$("#assigned_to_div").hide();
				}
		
			}else{
			
				//$("#tr_nst_div").hide();
				
				$("#process_div").hide();		
				$('#process_id').removeAttr('required');
				
				$("#sub_process_div").hide();		
				$('#sub_process_id').removeAttr('required');
					
				$('#assigned_to').removeAttr('required');
				$("#assigned_to_div").hide();					
			}
		
		}else{
			
			//$("#tr_nst_div").hide();
			
			$("#process_div").hide();		
			$('#process_id').removeAttr('required');
			
			$("#sub_process_div").hide();		
			$('#sub_process_id').removeAttr('required');
			
			$('#assigned_to').removeAttr('required');
			$("#assigned_to_div").hide();				
					
		}
		
    });
		
	
	$("#dept_id").change(function(){
		
		var dept_id=$('#dept_id').val();
		populate_sub_dept_combo(dept_id);
		$("#role_id").val('');
	});
	
	
    $("#reset").click(function(){
		$("#assigned_to_div").hide();
		$("#site_div").hide();
		$("#process_div").hide();
		$('#assigned_to').removeAttr('required');
		$('#process_id').removeAttr('required');
		$('#site_id').removeAttr('required');
		
		$("#sub_process_div").hide();		
		$('#sub_process_id').removeAttr('required');
					
	});
	
});


$(function(){
    
	var timeOffset="-300";
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
	
		
	/* global setting */
	/*
    var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        minDate   : "-2D"
    }
	*/
	 var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset
    }
	
	//$( "#doj" ).datepicker();
	$("#doj").datepicker($.extend({},datepickersOpt));
	
})

    
</script>

