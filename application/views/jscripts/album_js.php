<!--allowedTypes:"doc,docx,xls,xlsx,ppt,pptx,pps,ppsx,jpg,jpeg,png,gif,pdf,wmv,avi,mp4,mp3",	 -->
<script>

$(document).ready(function() {
	
	var baseURL="<?php echo base_url();?>";
	 
	
	$("#attach_modal").on("shown.bs.modal", function () {
		
		var atpid=$('#atpid').val();
		 
		var uUrl=baseURL+'album/upload';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "attach",
			allowedTypes:"doc,docx,xls,xlsx,jpg,jpeg,png,gif,pdf,wmv,avi,mp4,mp3",	
			returnType:"json",
			maxFileSize: 1173741824,
			dynamicFormData:function()
			{
			   var atpid=$('#atpid').val();
			   return {
					'atpid' : atpid,
				}
			},
			onSelect:function(files)
			{
				
			},
			onSuccess:function(files,data,xhr)
			{
								//alert(data);
								
			//var iconUrl = getPolicyIconUrl(data[4]);
			var iconUrl = data[4]+''+ data[3];
					  //alert(iconUrl);
					  
			$("#currAttachDiv").show();
						
			if(data[0]=="done"){
				$("#currAttachDiv").append("<div class='attachDiv' title='"+data[2]+"' id='div" + data[1] + "'><img src='"+baseURL + iconUrl + "' id='" + data[3] + "'  width='20px' height='20px'/> <button title='Delete File' atid='" + data[4] + "' lid='" + data[3] + "' type='button' class='deleteAttach btn btn-danger btn-xs'><i class='fa fa-times-circle' aria-hidden='true'></i></button> </div>");
			}
			
			//alert("Successfully uploaded and import to database.");
						   
			},
			onError:function (files, status, message)
			{
			   
			   //$("#OutputDiv").html(message);
			   alert(message);
			   
			},
			showDelete:false
		}
				
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
	
	});
	
		////////////////////////////////////////
			
	$(".attachFile").click(function(){
		
		var atpid=$(this).val();
		$('#atpid').val(atpid);
		$('#attach_modal').modal('show');
		
	});
	
	
	$('#attach_modal').on('hidden.bs.modal', function () {
		location.reload();
	})

	$(document).on("click", "div.attachDiv>button", function(){
		var atid=$(this).attr("atid");
		var lid =$(this).attr("lid");

				
		var ans=confirm('Are you sure to delete attachment?');
		if(ans==true){
			$(this).parent().remove();
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'album/deleteAttachment',
			   data:'atid='+ atid + '&lid='+ lid,
			   success: function(msg){
					//alert(msg);
				},
				error: function(){
					alert('Fail!');
				}
			  });
		}
		
	});

	
	$(document).on('mouseover','div.attachDiv',function(){
		$(this).find(".deleteAttach").show();
	});

	$(document).on('mouseout','div.attachDiv',function(){
		$(this).find(".deleteAttach").hide();
	});
	
	$(document).on('mouseover','div.attachDiv',function(){
		$(this).find(".deleteAttach").show();
	});
	
	$(document).on('mouseout','div.attachDiv',function(){
		$(this).find(".deleteAttach").hide();
	});
	
	
	
$(document).on("click", "div .img-wrap .close", function(){ 
		var id = $(this).closest('.img-wrap').find('img').data('id'); 
		 
		var ans=confirm('Are you sure to delete attachment?');
		
		if(ans==true){
			$(this).parent().remove();
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'album/deleteuploads',
			   data:'atid='+ id,
			   success: function(msg){
					alert(msg);
					
				},
				error: function(){
					alert('Fail!');
				}
			  });
			  
			 
		}else{
					
		}
	
	});
	


	$(document).on("click", "button.default", function(){

		var link=$(this).attr("link");
	    
		 
		var ans=confirm('Are you sure to set this image as default ?');
		if(ans==true){
			
			  $.ajax({
			   type: 'POST',    
			   url: baseURL+'album/set_default',
			   data:'lid='+ link,
			   success: function(msg){
					 alert(msg);
				},
				error: function(){
					alert('Fail!');
				}
			  }); 
		}
		
	});	
	
	
	
	
});


</script>
