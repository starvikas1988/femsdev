<script>
var baseURL="<?php echo base_url();?>";


$('#select_category').select2();

$('.knowledge-entry').click(function()
{
	$('#modalknowledge').modal('show');
});

$('#kclosebutton').click(function()
{
	$('#modalknowledge').modal('hide');
	window.location.reload();
});

$('#ksubmitbutton').click(function()
{
	var assignstate = $('#assign_site').val();
	var assignclient = $('#assign_client').val();
	var assignprocess = $('#assign_process').val();
	if((assignstate != "") && (assignclient != "") && (assignprocess != ""))
	{
		$('#knowledge-entry').submit();
	} else {
		alert('Please fill up all details carefully!');
	}
});


function categorycheck()
{
	var scat = $('#select_category').val();
	if(scat == 0)
	{ 
		$('#enter_category').val('');
		$('#categoryname').show();
	} else {
		if((scat != "") && (scat != 0))
		{
			$('#enter_category').val(scat);
			$('#categoryname').hide();
		} else {
			$('#enter_category').val('');
			$('#categoryname').hide();
		}
	}
}


$("#assign_client").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'','assign_process','N');
	$(".ajax-upload-dragdrop").remove();
	canuploadcheck();
});

$("#s_assign_client").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'','s_assign_process','N');
	canuploadcheck();
});

$("#assign_site").change(function(){
	$(".ajax-upload-dragdrop").remove();
	canuploadcheck();
});

$("#assign_process").change(function(){
	$(".ajax-upload-dragdrop").remove();
	canuploadcheck();
});

$("#upload_type").change(function(){
	$(".ajax-upload-dragdrop").remove();
	canuploadcheck();
});

function canuploadcheck()
{
	var assignstate = $('#assign_site').val();
	var assignclient = $('#assign_client').val();
	var assignprocess = $('#assign_process').val();
	var uploadtype = $('#upload_type').val();
	if((assignstate != "") && (assignclient != "") && (assignprocess != "") && (uploadtype == "documentfile"))
	{
		$("#uploadingjfile").show();
		
		var uUrl=baseURL+'knowledge/upload';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "attach",
			allowedTypes:"doc,docx,xls,xlsx,ppt,pptx,pps,ppsx,jpg,jpeg,png,gif,pdf,mp4,avi",	
			returnType:"json",
			maxFileSize: 1173741824, //7397376,
			dynamicFormData:function()
			{
				
			   var assignstate = $('#assign_site').val();
			   var assignclient = $('#assign_client').val();
			   var assignprocess = $('#assign_process').val();
			   var filedownloadable = $('#file_downloadable').val();
			   var enter_category = $('#enter_category').val();
			   var access_control = $('#access_control').val();
			   var assigntags = $('#assign_tags').val();
			   var atpid=$('#atpid').val();
			   return {
					'atpid' : atpid,
					'assign_site' : assignstate,
					'assign_client' : assignclient,
					'assign_process' : assignprocess,
					'assign_tags' : assigntags,
					'is_download' : filedownloadable,
					'access_control' : access_control,
					'enter_category' : enter_category
				}
			},
			onSelect:function(files)
			{
				
			},
			onSuccess:function(files,data,xhr)
			{
									
			//var iconUrl = getPolicyIconUrl(data[3]);
			//canuploadcheck();
			//$("#currAttachDiv").show();
			var init_directory = "knowledge_base/" + data[4] + "/" + data[5] + "/" + data[6];	
			var myiconurl = filtypeurl_icon(data[3],init_directory);
			
			if(data[0]=="done"){
				
				//$("#currAttachDiv").append("<div class='attachDiv' title='"+data[2]+"' id='div" + data[1] + "'><img src='"+baseURL + "uploads/knowledge_base/" + data[4] + "/" + data[5] + "/" + data[6] + "/" + data[3] + "' id='" + data[1] + "'/> <button title='Delete File' atid='" + data[1] + "' type='button' class='deleteAttach btn btn-danger btn-xs'><i class='fa fa-times-circle' aria-hidden='true'></i></button> </div>");
				
				$("#currAttachDiv").append("<div class='attachDiv' title='"+data[2]+"' id='div" + data[1] + "'><img src='"+baseURL + myiconurl + "' id='" + data[1] + "'/> <button title='Delete File' atid='" + data[1] + "' type='button' class='deleteAttach btn btn-danger btn-xs'><i class='fa fa-times-circle' aria-hidden='true'></i></button> </div>");
				
			}
			
			//alert("Successfully uploaded and import to database.");
						   
			},
			onError:function (files, status, message)
			{
			  
			   //$("#OutputDiv").html(message);
			   //alert(message);
			   
			},
			showDelete:false
		}
		
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
		$('#uploadinghtmlzip').hide();
		$('#ksubmitbutton').hide();
		$('#kclosebutton').show();
	} else {
		
		$("#uploadingjfile").hide();
		$('#uploadinghtmlzip').hide();
		$('#ksubmitbutton').hide();
		$('#kclosebutton').hide();
		if((assignstate != "") && (assignclient != "") && (assignprocess != "") && (uploadtype == "zipfile"))
		{
			$('#uploadinghtmlzip').show();
			$('#ksubmitbutton').show();
		}
		
	}
}


$("#modalknowledge").on("shown.bs.modal", function () {
	canuploadcheck();
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
	
	
	$(document).on("click", "div.attachDiv>button", function(){
		var atid=$(this).attr("atid");
				
		var ans=confirm('Are you sure to delete attachment?');
		if(ans==true){
			$(this).parent().remove();
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'knowledge/deleteAttachment',
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
	
	
	
	
	$(".editfileUpdates").click(function(){
	
		var params=$(this).attr("params");
		var epid=$(this).attr("epid");
		
		//console.log(params);
			
		var arrPrams = params.split("#"); 
		//console.log(arrPrams);
		$('#editid').val(epid);
		
		$('#edit_assign_site').val(arrPrams[0]);
		$('#edit_assign_client').val(arrPrams[1]);
		
		$('#edit_assign_process').append($('<option>').val(arrPrams[2]).text(arrPrams[3]));
		$('#edit_assign_process').val(arrPrams[2]);
		
		//$('iframe').contents().find('.wysihtml5-editor').html(arrPrams[1]);
		
		//$('#edoffice_id').val(arrPrams[2]);
		//$('#edclient_id').val(arrPrams[3]);
		//$('#edprocess_id').val(arrPrams[4]);
		//$('#edis_active').val(arrPrams[5]);
		
		$('#editmodalknowledge').modal('show');
		
		//populate_process_combo(arrPrams[3],arrPrams[4],'edprocess_id','Y');
		
		
	});
	
	
	
	// OPEN VIEW MODAL
	$(".viewmodalclick").click(function(){
	
		var clickid =$(this).attr("sourceid");
		$('#modaldocview').modal('show');
		$('.docbodymodal').html('');
		//alert(params);
		$.ajax({
		   type: 'POST',    
		   url: baseURL+'knowledge/viewdata',
		   data:'kid='+ clickid,
		   success: function(data){
				$('.docbodymodal').html(data);
			},
			error: function(){
				alert('Fail!');
			}
		});
		
		// GET VIEW DATA
		$.ajax({
		   type: 'GET',    
		   url: baseURL+'knowledge/fileviewdata',
		   data:'kid='+ clickid,
		   success: function(data){
				$('#viewcountdata').html(data);
				$('#viewcountdata').attr("sourceid", clickid);
			},
			error: function(){
				alert('Fail!');
			}
		});
		
	});
	
	$("#viewcountdata").click(function(){
		var clickid =$(this).attr("sourceid");
		$('#modaltableview').modal('show');
		$('.modaltable').html('');
		//alert(params);
		$.ajax({
		   type: 'GET',    
		   url: baseURL+'knowledge/filerecord',
		   data:'kid='+ clickid,
		   success: function(data){
				$('.modaltable').html(data);
			},
			error: function(){
				alert('Fail!');
			}
		});
		
	});
	
	
	// FILE TYPE ICON
	function inArray(needle, haystack) {
		var length = haystack.length;
		for(var i = 0; i < length; i++) {
			if(haystack[i] == needle) return true;
		}
		return false;
	}


	function filtypeurl_icon(fileName, folder)
	{
		var ext = fileName.split('.').pop();
		imgArray = ["jpg", "jpeg", "png", "gif"];
		docArray = ["doc", "docx"];
		excelArray = ["xls", "xlsx"];
		pptArray = ["ppt", "pptx", "pps", "ppsx"];
		pdfArray = ["pdf"];
		txtArray = ["txt"];
		csvArray = ["csv"];
		videoArray = ["mp4","avi","mkv","mpeg","mpeg4","mov","wmv"];
		
		imgUrl="/assets/images/un.png";
		if(inArray(ext, imgArray)) { imgUrl="/uploads/" + folder + "/" + fileName;	}	
		else if( inArray(ext, docArray)) { imgUrl="/assets/images/doc.png"; }
		else if(inArray(ext, excelArray)) { imgUrl="/assets/images/excel.png"; }
		else if( inArray(ext, pptArray)) { imgUrl="/assets/images/ppt.png"; }
		else if( inArray(ext, pdfArray)) { imgUrl="/assets/images/pdf.png"; }
		else if( inArray(ext, txtArray)) { imgUrl="/assets/images/txt.png"; }	
		else if( inArray(ext, csvArray)) { imgUrl="/assets/images/csv.png"; }
		else if( inArray(ext, videoArray)) { imgUrl="/assets/images/video.png"; }
		return imgUrl;
	}
</script>