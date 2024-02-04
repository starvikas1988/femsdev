<script>

$(document).ready(function() {
	
	var baseURL="<?php echo base_url();?>";
	
	
/////////////////////

		/* $("#client_id").change(function(){
			var client_id=$(this).val();
			
			var URL='<?php echo base_url();?>/user/select_process';
			
			$.ajax({
			   type: 'GET',    
			   url:URL,
			   data:'client_id='+client_id,
				success: function(data){
				  
				  
				  var a = JSON.parse(data);
				  //var mySelect = $('#process_id');
				  $("#process_id").empty();
				  
					$.each(a, function(index,jsonObject){
						 $("select#process_id").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
					});	
				},
				error: function(){	
					alert('error!');
				}
			  });
			
		}); */
		
		
		/* $("#edclient_id").change(function(){
			var client_id=$(this).val();
			
			var URL='<?php echo base_url();?>/user/select_process';
			
			$.ajax({
			   type: 'GET',    
			   url:URL,
			   data:'client_id='+client_id,
				success: function(data){
				  
				  
				  var a = JSON.parse(data);
				  //var mySelect = $('#process_id');
				  $("#edprocess_id").empty();
				  
					$.each(a, function(index,jsonObject){
						 $("select#edprocess_id").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
					});	
				},
				error: function(){	
					alert('error!');
				}
			  });
			
		}); */
		
///////////////////////
		$('#specific_user'). click(function(){
			if($(this). prop("checked") == true){
				$('#accessControl').show();
			}else{
				$('#accessControl').hide();
			}
		});	
		
		
		$('#edspecific_user'). click(function(){
			if($(this). prop("checked") == true){
				$('#edaccessControl').show();
			}else{
				$('#edaccessControl').hide();
			}
		});
		
		
		
		$(function(){
			$("#access_control").select2();
			$("#edaccess_control").select2();
		});
		
		
		
		$("#aoffice_id").change(function(){
			var aoffice_id=$(this).val();
			
			populate_access_control_combo(aoffice_id,'','access_control','Y');
		});
		
		
		
		$("#edoffice_id").change(function(){
			var edoffice_id=$(this).val();
			
			populate_access_control_combo(edoffice_id,'','edaccess_control','Y');
		});
		
		
	////////////////////	
		
		$("#client_id").change(function(){
			var client_id=$(this).val();
			
			populate_process_combo(client_id,'','process_id','Y');
		});
		
		
		$("#edclient_id").change(function(){
			var client_id=$(this).val();
			
			populate_process_combo(client_id,'','edprocess_id','Y');
		});
		
		
		
		$("#fclient_id").change(function(){
			var client_id=$(this).val();
			
			populate_process_combo(client_id,'','fprocess_id','Y');
		});
		
		
		
		$("#aoffice_id").change(function(){
			var aoffice_id=$(this).val();
			
			populate_users_combo(aoffice_id,'','access_control','Y');
		});

////////////	
	
	
	$("#btn_add_processUpdates").click(function(){
		$('#modalAddProcessUpdates').modal('show');
	});
	
	
	$("#attach_modal").on("shown.bs.modal", function () {
	
		var uUrl=baseURL+'process_update/upload';

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
			   url: baseURL+'process_update/deleteAttachment',
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
	
	
	
	
	$(".editProcessUpdates").click(function(){
		$('#sktPleaseWait').modal('show');
		var uUrl=baseURL+'process_update/ajax_EditProcessUpdates';
		var params=$(this).attr("params");
		var epid=$(this).attr("epid");
		
		//console.log(params);
			
		var arrPrams = params.split("#"); 

		$.ajax({
			   type: 'POST',    
			   url: uUrl,
			   data:'office_id='+ arrPrams[2],
			   success: function(msg){
				$('#edaccess_control').html(msg);
				//console.log(arrPrams);
				$('#edpid').val(epid);
				
				$('#edtitle').val(arrPrams[0]);
				$('iframe').contents().find('.wysihtml5-editor').html(arrPrams[1]);
				
				$('#edoffice_id').val(arrPrams[2]);
				$('#edclient_id').val(arrPrams[3]);
				//$('#edprocess_id').val(arrPrams[4]);
				//$('#edis_active').val(arrPrams[5]);
				$('#sktPleaseWait').modal('hide');
				$('#modalEditProcessUpdates').modal('show');
						//$('#edprocess_id').val(arrPrams[4]);
				//$('#edis_active').val(arrPrams[5]);
				populate_process_combo(arrPrams[3],arrPrams[4],'edprocess_id','Y');
				
				},
				error: function(){
					alert('Fail!');
					$('#sktPleaseWait').modal('hide');
				}
			  });
		
		
		
	});
	
	
		
		
	$(".pActDeact").click(function(){
		var pid=$(this).attr("adpid");
		var sid=$(this).attr("pstat");
		var title=$(this).attr("titleJS");
		
		//alert(baseURL+"policy/pActDeact?pid="+pid + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the Process Updates?");
		
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'process_update/pActDeact',
			   data:'pid='+ pid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
	
////////////////////////////////////////////////////////////////////////////////////////

//////////////////////Accept Policy////////////////////

		$(".acceptedProcessUpdates").click(function(){
			var adpid=$(this).attr("adpid");
			$('#adpid').val(adpid);
			$('#modalProcessUpdatesAccept').modal('show');
		});
		
///////////////////////////////		
	
	/* $('.note-editable').on("keyup", function(){
		alert($('#adescription').code());
       $('textarea[name="description1"]').html($('#adescription').code());
	});

	$('#adescription1').on("focus", function(){
		alert($('#adescription').code());
       $('textarea[name="description1"]').html($('#adescription').code());
	});
	
	
	$('#adescription').summernote({
		height: 200,                 
		minHeight: null,             
		maxHeight: 200,             
		focus: true,                 
		dialogsInBody: true,
		tableClassName: 'table table-bordered table-responsive',
		toolbar: [
			['style', ['bold', 'italic', 'underline', 'clear']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['insert', ['link','video','picture','table','hr']]
		],
	}); */
	
});


$(function () {
	$('#adescription1').wysihtml5();
	
	$('#eddescription').wysihtml5()
})

/* $(function(){
	$("#client_id").select2();
	$("#process_id").select2();
}); */

</script>
