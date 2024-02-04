<script type="text/javascript">

$(document).ready(function()
{
		var baseURL="<?php echo base_url();?>";
		
		
		
		var uUrl=baseURL+'bulk_term_users/upload';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "myfile",
			allowedTypes:"xls,xlsx",	
			//returnType:"json",
			dynamicFormData:function()
			{
			   var term_type = $("input[name='term_type']:checked").val();
			   var remarks=$('#remarks').val();
			   return {
					'term_type' : term_type,
					'remarks' : remarks
				}
			},
			onSelect:function(files)
			{
				var term_type = $("input[name='term_type']:checked").val();
				if(term_type==null){
					alert("Please Select The Term Type");
					return false;
				}
				
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
			   
			   var rUrl=baseURL+'bulk_term_users';
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

