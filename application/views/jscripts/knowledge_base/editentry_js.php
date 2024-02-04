<script>
var baseURL="<?php echo base_url();?>";

$("#edit_assign_client").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'','edit_assign_process','N');
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
		$('#edit_assign_tags').val(arrPrams[4]);
		$('#file_downloadable').val(arrPrams[5]);
		$('#select_category').val(arrPrams[6]);
		$('#enter_category').val(arrPrams[6]);
		$('#edit_access_control').val(arrPrams[7]);
		
		//$('iframe').contents().find('.wysihtml5-editor').html(arrPrams[1]);
		
		//$('#edoffice_id').val(arrPrams[2]);
		//$('#edclient_id').val(arrPrams[3]);
		//$('#edprocess_id').val(arrPrams[4]);
		//$('#edis_active').val(arrPrams[5]);
		
		$('#editmodalknowledge').modal('show');
		
		//populate_process_combo(arrPrams[3],arrPrams[4],'edprocess_id','Y');
		
		
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