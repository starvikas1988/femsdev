<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script> -->

<script>

$(document).ready(function() {
	
	var baseURL="<?php echo base_url();?>";
	
	$("#aoffice_id").select2();
	$("#edoffice_id").select2();
	
	$("#btn_add_policy").click(function(){
		$('#modalAddPolicy').modal('show');
	});
	
	
	$("#btnAddPolicy").click(function(){
		
				
		var aoffice_id=$('#aoffice_id').val();
		var afunction_id=$('#afunction_id').val().trim();
		
		var atitle=$('#atitle').val().trim();
		//var adescription=$('#adescription').val().trim();
		
		///alert(baseURL+"policy/addPolicy?"+$('form.frmAddPolicy').serialize());	
		
		if(aoffice_id!="" && afunction_id!="" && atitle!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'policy/addPolicy',
			   data:$('form.frmAddPolicy').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddPolicy').modal('hide');
						location.reload();
				}
				,
				error: function(){
					alert('Fail!');
				}
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});
	
	
	
	
	$("#attach_modal").on("shown.bs.modal", function () {
	
		var uUrl=baseURL+'policy/upload';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "attach",
			allowedTypes:"doc,docx,xls,xlsx,ppt,pptx,pps,ppsx,jpg,jpeg,png,gif,pdf",	
			returnType:"json",
			maxFileSize: 7397376,
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
									
			var iconUrl = getPolicyIconUrl(data[3]);
						
			$("#currAttachDiv").show();
						
			if(data[0]=="done"){
				$("#currAttachDiv").append("<div class='attachDiv' title='"+data[2]+"' id='div" + data[1] + "'><img src='"+baseURL + iconUrl + "' id='" + data[1] + "'/> <button title='Delete File' atid='" + data[1] + "' type='button' class='deleteAttach btn btn-danger btn-xs'><i class='fa fa-times-circle' aria-hidden='true'></i></button> </div>");
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
		
		var atpid=$(this).attr("pid");
		$('#atpid').val(atpid);
		$('#attach_modal').modal('show');
		
	});
	
	
	$('#attach_modal').on('hidden.bs.modal', function () {
		location.reload();
	})

	$(document).on("click", "div.attachDiv>button", function(){
		var atid=$(this).attr("atid");
				
		var ans=confirm('Are you sure to delete attachment?');
		if(ans==true){
			$(this).parent().remove();
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'policy/deleteAttachment',
			   data:'atid='+ atid,
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
	
	
	
	
	$(".editPolicy").click(function(){
	
		var params=$(this).attr("params");
		var epid=$(this).attr("epid");
		
		//alert("pid="+pid + " params:"+params);	
		var arrPrams = params.split("$#"); 
		$('#edpid').val(epid);
		
		$('#edtitle').val(arrPrams[0]);
		//$('#eddescription').val(arrPrams[1]);
		$('#edoffice_id').val(arrPrams[2]);
		$('#edfunction_id').val(arrPrams[3]);
		//$('#edis_active').val(arrPrams[4]);
		
		$('#modalEditPolicy').modal('show');
		
		
	});
	
	$("#btnEditPolicy").click(function(){
	
		var pid=$('#edpid').val().trim();
		var title=$('#edtitle').val().trim();
		var office_id=$('#edoffice_id').val();
		var function_id=$('#edfunction_id').val().trim();
		
		//alert(baseURL+"policy/updatePolicy?"+$('form.frmEditPolicy').serialize());
		
		if(pid!="" && title!="" && office_id!="" && function_id!="" ){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'policy/updatePolicy',
			   data:$('form.frmEditPolicy').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditPolicy').modal('hide');
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
		
		
	$(".pActDeact").click(function(){
		var pid=$(this).attr("adpid");
		var sid=$(this).attr("pstat");
		var title=$(this).attr("titleJS");
		
		//alert(baseURL+"policy/pActDeact?pid="+pid + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the Policy?");
		
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'policy/pActDeact',
			   data:'pid='+ pid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
	
////////////////////////////////////////////////////////////////////////////////////////

//////////////////////Accept Policy////////////////////

		$(".acceptedPolicy").click(function(){
			var adpid=$(this).attr("adpid");
			$('#adpid').val(adpid);
			$('#modalPolicyAccept').modal('show');
		});
	
});

</script>
