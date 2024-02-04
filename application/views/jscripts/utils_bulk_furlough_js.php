<script type="text/javascript">

$(document).ready(function()
{
		var baseURL="<?php echo base_url();?>";
		
		
		
		var uUrl=baseURL+'bulk_furlough_users/upload';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "myfile",
			allowedTypes:"xls,xlsx",	
			//returnType:"json",
			dynamicFormData:function()
			{
			   var remarks=$('#remarks').val();
			   return {
					'remarks' : remarks
				}
			},
			onSelect:function(files)
			{								
				var remarks=$('#remarks').val();
				if(remarks==null){
					alert("Please Enter Remarks");
					return false;
				}
				
			},
			onSuccess:function(files,data,xhr)
			{
			  
				alert(data);
				//$("#OutputDiv").html(data[0]);
			   //alert("Successfully uploaded and import to database.");
			   
			   var rUrl=baseURL+'bulk_furlough_users';
			   window.location.href=rUrl;	
			   
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

 
</script>

