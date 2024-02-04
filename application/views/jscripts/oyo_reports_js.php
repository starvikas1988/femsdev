<script type="text/javascript">

$(document).ready(function(){
    
	var baseURL="<?php echo base_url();?>";
		
	
	$("#filter_key").change(function(){
		
		var key=$(this).val();
		//alert(key);
		
			$("#site_div").hide();
			$('#site_id').removeAttr('required');
			
			$("#agent_div").hide();
			$('#agent_id').removeAttr('required');
			
			$("#process_div").hide();
			$('#process_id').removeAttr('required');
			
			$("#disp_div").hide();
			$('#disp_id').removeAttr('required');
			
			$("#role_div").hide();
			$('#role_div').removeAttr('required');
			
			$("#aof_div").hide();
			$('#aof_div').removeAttr('required');
		
		if(key == "Site" ){ 
			$("#site_div").show();
			$('#site_id').attr('required', 'required');
						
		}else if($(this).val() == "Process" ){ 
			
			$("#process_div").show();
			$('#process_id').attr('required', 'required');
		
		}else if($(this).val() == "Disposition" ){ 
			
			$("#disp_div").show();
			$('#disp_id').attr('required', 'required');
		
		}else if($(this).val() == "Agent" ){ 
			
			$("#agent_div").show();
			$('#agent_id').attr('required', 'required');
			
		}else if($(this).val() == "Role" ){ 
			
			$("#role_div").show();
			$('#role_div').attr('required', 'required');
		
		}else if($(this).val() == "AOF" ){ 
			
			$("#aof_div").show();
			$('#aof_div').attr('required', 'required');
			
		}else{
		
			
		}
		
        
    });
		
});

  $( function() {
  
   // $( "#start_date" ).datepicker();
	$( "#start_date" ).datepicker({maxDate: new Date()});
	//$('#start_date').datepicker( "setDate", "-1d" );
	
	
	$( "#end_date" ).datepicker({ maxDate: new Date() });
	 
	//$( "#end_date" ).datepicker();
	
  });
</script>

<script type="text/javascript">
$(document).ready(function(){
	var maxLength = 20;
	$(".chat_transcript").each(function(){
		var myStr = $(this).text();
		if($.trim(myStr).length > maxLength){
			var newStr = myStr.substring(0, maxLength);
			var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
			$(this).empty().html(newStr);
			$(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
			$(this).append('<span class="more-text">' + removedStr + '</span>');
		}
	});
	$(".read-more").click(function(){
		$(this).siblings(".more-text").contents().unwrap();
		$(this).remove();
	});
});
</script>

