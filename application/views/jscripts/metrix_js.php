<script type="text/javascript">

$(document).ready(function()
{
		var baseURL="<?php echo base_url();?>";
		
		var uUrl=baseURL+'metrix/upload';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "myfile",
			allowedTypes:"xls,xlsx",	
			//returnType:"json",	
			dynamicFormData:function()
			{
			   var sdate=$('#ssdate').val();
			   var edate=$('#sedate').val();
			   return {
					'sdate' : sdate,
					'edate' : edate
				}
			},
			onSelect:function(files)
			{
				/*
				var sdate=$('#ssdate').val();
				if(sdate==""){
					alert("Enter the Start Date");
					return false;
				}else{
					if(isValidDate(sdate)==false){
						alert("Invalid Start Date");
						return false;
					}
					
				}
				
				var edate=$('#sedate').val();
				if(edate==""){
					alert("Enter the End Date");
					return false;
				}else{
					if(isValidDate(edate)==false){
						alert("Invalid End Date");
						return false;
					}	
				}
				*/
			},
			onSuccess:function(files,data,xhr)
			{
				alert(data);
				
			   //$("#OutputDiv").html(data[0]);
			   
			   //alert("Successfully uploaded and import to database.");
			   
			   var rUrl=baseURL+'metrix';
			   window.location.href=rUrl;	
			   
			},
			onError:function (files, status, message)
			{
			   $("#OutputDiv").html(message);
			   
			   alert(message);
			   
			  // var rUrl=baseURL+'metrix';
			   //window.location.href=rUrl;	
			   
			},
			showDelete:false
		}
		
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);

		////////////////////////////////////////
		
			
		
	$(".editSchedule").click(function(){
		
		//var today = new Date();
		//today.setHours(today.getHours()-9.5);
		//alert(today);
		
		var shid=$(this).attr("shid");
		$('#shid').val(shid);
		
		var URL=baseURL+'schedule/get_data';

		//$('#sktPleaseWait').modal('show');
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'shid='+shid,
		   success: function(data){
		   
								
				var rsp = jQuery.parseJSON(data);
				
				
				$('#user_id').val(rsp[0].user_id);
				
				$('#agent_name').val(rsp[0].agent_name);
				$('#omuid').val(rsp[0].omuid);
				$('#start_date').val(rsp[0].start_date);
				$('#end_date').val(rsp[0].end_date);
				
				$('#mon_in').val(rsp[0].mon_in);
				$('#mon_out').val(rsp[0].mon_out);
				$('#tue_in').val(rsp[0].tue_in);
				$('#tue_out').val(rsp[0].tue_out);
				$('#wed_in').val(rsp[0].wed_in);
				$('#wed_out').val(rsp[0].wed_out);
				$('#thu_in').val(rsp[0].thu_in);
				$('#thu_out').val(rsp[0].thu_out);
				$('#fri_in').val(rsp[0].fri_in);
				$('#fri_out').val(rsp[0].fri_out);
				$('#sat_in').val(rsp[0].sat_in);
				$('#sat_out').val(rsp[0].sat_out);
				$('#sun_in').val(rsp[0].sun_in);
				$('#sun_out').val(rsp[0].sun_out);
							
				//$('#sktPleaseWait').modal('hide');
				
				$('#sktShModal').modal('show');
				
			},
			error: function(){
			
				alert('Fail!');
				
				$('#sktPleaseWait').modal('hide');
			}
			
		  });
		 
		  
		////
		
	});
	
	
	
	$("#updateSchedule").click(function(){
	
		var shid=$('#shid').val();
		var user_id=$('#user_id').val();
		
		//var mon_in=$('#mon_in').val();
		//var mon_out=$('#mon_out').val();
		
		//var tue_in=$('#tue_in').val();
		//var tue_out=$('#tue_out').val();		
		//alert($('form.frmEditSchedule').serialize());
		
		if(user_id!="" && shid!=""){
		
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'metrix/update_data',
			   data:$('form.frmEditSchedule').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#sktShModal').modal('hide');
						location.reload();
				}
				/*,
				error: function(){
					alert('Fail!');
				}
				*/
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
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
    var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        minDate   : "-5D"
    }

    $("#ssdate").datepicker($.extend({
        onSelect: function() {
            var minDate = $(this).datepicker('getDate');
            minDate.setDate(minDate.getDate()+6); //add 6 days
            $("#sedate").datepicker( "option", "minDate", minDate);
			
			$('#sedate').val(js_mm_dd_yyyy(minDate));
        }
    },datepickersOpt));

    $("#sedate").datepicker($.extend({
        onSelect: function() {
            var maxDate = $(this).datepicker('getDate');
            maxDate.setDate(maxDate.getDate()-6);
            $("#ssdate").datepicker( "option", "maxDate", maxDate);
        }
    },datepickersOpt));
	

});
 
</script>

