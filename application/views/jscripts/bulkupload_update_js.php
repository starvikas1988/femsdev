<script type="text/javascript">

$(document).ready(function()
{
		var baseURL="<?php echo base_url();?>";
		
		var uUrl=baseURL+'bulk_user_update/upload';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "myfile",
			allowedTypes:"xls,xlsx",	
			returnType:"json",
			onSuccess:function(files,data,xhr)
			{
				alert(data);
				
			   $("#OutputDiv").html(data[0]);
			   
			   //alert("Successfully uploaded and import to database.");
			   
			   var rUrl=baseURL+'bulk_user_update';
			   //window.location.href=rUrl;	
			   
			},
			onError:function (files, status, message)
			{
			   $("#OutputDiv").html(message);
			   
			   alert(message);
			   
			  // var rUrl=baseURL+'schedule';
			   //window.location.href=rUrl;	
			   
			},
			showDelete:false
		}
		
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);

	
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

