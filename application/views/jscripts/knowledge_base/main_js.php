<script>
var baseURL="<?php echo base_url();?>";
	
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
		   url: baseURL+'knowledge/fileviewdata_log',
		   data:'kid='+ clickid,
		   success: function(data){
				$('#viewcountdata').html(data);
				$('#viewcountdata').attr("sourceid", clickid);
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
				$('#viewcountdataAll').html(data);
				$('#viewcountdataAll').attr("sourceid", clickid);
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
		   url: baseURL+'knowledge/filerecord_logs',
		   data:'kid='+ clickid,
		   success: function(data){
				$('.modaltable').html(data);
				$('#modaltableview .newDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, });
			},
			error: function(){
				alert('Fail!');
			}
		});
		
	});
	
	
	$("#viewcountdataAll").click(function(){
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
	
	
	$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, });
	
	$("#modaltableview").on('click', '.searchBtn', function(){
		var kid = $(this).closest("#modaltableview").find('input[name="search_kid"]').val();
		var startDate = $(this).closest("#modaltableview").find('input[name="search_start"]').val();
		var endDate = $(this).closest("#modaltableview").find('input[name="search_end"]').val();
		var fusion = $(this).closest("#modaltableview").find('input[name="search_fusion"]').val();
		$('#modaltableview').modal('show');
		$('.modaltable').html('');
		//alert(params);
		$.ajax({
		   type: 'GET',    
		   url: baseURL+'knowledge/filerecord_logs',
		   data: { 
			kid : kid,
			search_start : startDate,
			search_end : endDate,
			search_fusion : fusion,
		   },
		   success: function(data){
				$('.modaltable').html(data);
				$('#modaltableview .newDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, });
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