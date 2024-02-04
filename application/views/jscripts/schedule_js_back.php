<script type="text/javascript">

$(document).ready(function()
{
		var baseURL="<?php echo base_url();?>";

		var uUrl=baseURL+'schedule/upload';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "myfile",
			allowedTypes:"xls,xlsx",	
			returnType:"json",	
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
			},
			onSuccess:function(files,data,xhr)
			{
			   //$("#OutputDiv").html(data[0]);
			   
			   var rUrl=baseURL+'schedule';
			   window.location.href=rUrl;	
			   
			},
			showDelete:false,
			deleteCallback: function(data,pd)
			{
			for(var i=0;i<data.length;i++)
			{
				$.post("delete.php",{op:"delete",name:data[i]},
				function(resp, textStatus, jqXHR)
				{
					//Show Message  
					$("#status").append("<div>File Deleted</div>");      
				});
			 }
			 
			pd.statusbar.hide(); //You choice to hide/not.

			}
		}
		
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);

		////////////////////////////////////////
		
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
        minDate   : "-1D"
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

