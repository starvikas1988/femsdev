<?php if(!empty($_show_table)){ ?>
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('#default-datatable').DataTable({
	"pageLength":50
});
</script>
<?php } ?>
<script>
$('.oldDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, });
$('.timeFormat').timepicker({ timeFormat: 'HH:mm:ss', });
$('.dataTable').timepicker({ timeFormat: 'HH:mm:ss', });
$('.singelSelect').select2();

$('.date-picker-year').datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years"
});
			
$('.addMoreData_Body').on('click', '.addMoreData_Button', function(){
	$(this).closest('.addMoreData_Body').children('.addMoreData_Row').find('.singelSelect').select2('destroy');
	rowCopy = $(this).closest('.addMoreData_Body').children('.addMoreData_Row').first().clone();
	$(this).closest('.addMoreData_Body').children('.addMoreData_Row').find('.singelSelect').select2('');
	$(this).addClass('hide');
	$(this).closest('.addMoreData_Body').append(rowCopy);
	$(this).closest('.addMoreData_Body').children('.addMoreData_Row').last().find('textarea,input,select').val('');
	$(this).closest('.addMoreData_Body').children('.addMoreData_Row').last().find('.removeMoreData_Button').removeClass('hide');
	$(this).closest('.addMoreData_Body').children('.addMoreData_Row').last().find('.addMoreData_Button').removeClass('hide');
	$(this).closest('.addMoreData_Body').children('.addMoreData_Row').last().find('.singelSelect').select2('');
	$(this).closest('.addMoreData_Body').children('.addMoreData_Row').last().find('.removeMoreDataFull_Button').addClass('hide');
});

$('.addMoreData_Body').on('click', '.removeMoreData_Button', function(){
	curElementBody = $(this).closest('.addMoreData_Body');
	$(this).closest('.addMoreData_Row').remove();
	curElementBody.children('.addMoreData_Row').last().find('.addMoreData_Button').removeClass('hide');
});


$('.addMoreData_Body').on('change', '.locationRow .d_country', function(){
	country = $(this).val();
	closestRow = $(this).closest('.addMoreData_Row');
	$('#sktPleaseWait').modal('show');	
	/*
	$.ajax({
		url: "<?php echo ma_url('master_states_ajax'); ?>",
		type: "GET",
		data: { cn : country },
		dataType: "json",
		success : function(jsonData){		
			var html = '<option value="">-- Select State --</option>';
			$(jsonData).each(function(key, token){
				html += '<option value="'+token.id+'">'+token.name +'</option>';
			});
			closestRow.find('.d_state').html(html);
			
			var html = '<option value="">-- Select City --</option>';
			closestRow.find('.d_city').html(html);
			$('#sktPleaseWait').modal('hide');
		},
		error : function(jsonData){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
	*/
	$.ajax({
		url: "<?php echo ma_url('master_country_cities_ajax'); ?>",
		type: "GET",
		data: { cn : country },
		dataType: "json",
		success : function(jsonData){		
			var html = '<option value="">-- Select City --</option>';
			$(jsonData).each(function(key, token){
				html += '<option value="'+token.id+'">'+token.name +'</option>';
			});
			closestRow.find('.d_city').html(html);
			$('#sktPleaseWait').modal('hide');
		},
		error : function(jsonData){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$('.addMoreData_Body').on('change', '.locationRow .d_state', function(){
	state = $(this).val();
	closestRow = $(this).closest('.addMoreData_Row');
	$('#sktPleaseWait').modal('show');	
	$.ajax({
		url: "<?php echo ma_url('master_cities_ajax'); ?>",
		type: "GET",
		data: { sn : state },
		dataType: "json",
		success : function(jsonData){		
			var html = '<option value="">-- Select City --</option>';
			$(jsonData).each(function(key, token){
				html += '<option value="'+token.id+'">'+token.name +'</option>';
			});
			closestRow.find('.d_city').html(html);
			$('#sktPleaseWait').modal('hide');
		},
		error : function(jsonData){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$('.recordListRow').on('click', '.recordView', function(){
	maID = $(this).attr('mid');
	$.ajax({
		url: "<?php echo ma_url('view_record_details'); ?>",
		type: "GET",
		data: { mid : maID },
		dataType: "text",
		success : function(htmlData){
			$('#recordDetailsModal .modal-body').html(htmlData);
			$('#sktPleaseWait').modal('hide');
			$('#recordDetailsModal').modal('show');
		},
		error : function(jsonData){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$('.recordLogRow').on('click', function(){
	maID = $(this).attr('mid');
	maTYPE = $(this).attr('mtype');
	$.ajax({
		url: "<?php echo ma_url('view_record_log'); ?>",
		type: "GET",
		data: { mid : maID, mtype : maTYPE },
		dataType: "text",
		success : function(htmlData){
			$('#recordLogsModal .modal-body').html(htmlData);
			$('#sktPleaseWait').modal('hide');
			$('#recordLogsModal').modal('show');
		},
		error : function(jsonData){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});



$('.addMoreData_Body').on('keypress','.is_numeric', function (event) {
    var keycode = event.which;
    if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
    }
});


$('.addMoreData_Body').on('keyup','input[name="ma_revenue_year[]"],input[name="ma_revenue_amount[]"]', function(){
	previousYearVal = "";
	$(this).closest('.addMoreData_Body').find('input[name="ma_revenue_amount[]"]').each(function(){		
		currentYearVal = $(this).val();
		if(previousYearVal != ""){
			resultPercent = ((Number(currentYearVal) - Number(previousYearVal)) / Number(previousYearVal) * 100);
			$(this).closest('.addMoreData_Row').find('input[name="ma_revenue_growth[]"]').val(resultPercent.toFixed(2));		
		}
		previousYearVal = currentYearVal;
	});
	
});

$('.addMoreData_Body').on('keyup','input[name="ma_ebitda_year[]"],input[name="ma_ebitda_amount[]"]', function(){
	$(this).closest('.addMoreData_Body').find('input[name="ma_ebitda_amount[]"]').each(function(){		
		currentEBYearVal = $(this).val();		
		currentEBYear = $(this).closest('.addMoreData_Row').find('input[name="ma_ebitda_year[]"]').val();
		currentRevenueVal = "";
		$('.addMoreData_Body').find('input[name="ma_revenue_amount[]"]').each(function(){
			currentRVYear =  $(this).closest('.addMoreData_Row').find('input[name="ma_revenue_year[]"]').val();
			console.log(currentRVYear);
			if(currentRVYear == currentEBYear){ currentRevenueVal = $(this).val(); }
		});
		console.log(currentEBYearVal);
		console.log(currentRevenueVal);
		if(currentRevenueVal != "" && currentEBYearVal != ""){
			resultPercent = ((Number(currentEBYearVal) / Number(currentRevenueVal)) * 100);
			$(this).closest('.addMoreData_Row').find('input[name="ma_ebitda_margin[]"]').val(resultPercent.toFixed(2));		
		}
	});
});


$('.accessGrantRow').on('click', 'input[name="is_super_checker[]"]', function(){
	currentStatus = $(this).is(':checked');
	if(currentStatus){
		$(this).closest('tr').find('select').val(3);
		$(this).closest('tr').find('input[name="is_super[]"]').val(1);
		$(this).closest('tr').find('select').attr('readonly', 'readonly');
	} else {
		$(this).closest('tr').find('select').val(0);
		$(this).closest('tr').find('input[name="is_super[]"]').val(0);
		$(this).closest('tr').find('select').removeAttr('readonly', 'readonly');
	}
});



//=================== MULTIPLE FILE UPLOADER ===========================//

var baseURL = "<?php echo base_url(); ?>";
var uploadURL = "<?php echo ma_url('upload_record_preview'); ?>";
var settings = {
	url: uploadURL,
	dragDrop:true,
	fileName: "ma_attach",
	allowedTypes:"doc,docx,xls,xlsx,ppt,pptx,pps,ppsx,jpg,jpeg,png,gif,pdf,zip,txt",
	returnType:"json",
	maxFileSize: 10485760, //7397376,
	dynamicFormData:function()
	{		
	   var ma_id = $('input[name="ma_id"]').val();
	   var ma_draft_id = $('input[name="ma_draft_id"]').val();
	   var ma_type = "ma_upload_preview";
	   return {
			'ma_id' : ma_id,
			'ma_draft_id' : ma_draft_id,
			'ma_type' : ma_type,
	   }
	},
	onSelect:function(files)
	{		
	},
	onSuccess:function(files,data,xhr)
	{
		if(data.status == "success")
		{
			$("#currAttachDiv").append("<div class='upl_attachDiv' title='"+ data.upload_type +"' id='upl_" + data.id + "'><img src='"+ baseURL + data.icon_url + "' id='" + data.id + "'/> <button title='Delete File' fileID='" + data.id + "' type='button' class='deleteAttach btn btn-danger btn-xs'><i class='fa fa-times-circle' aria-hidden='true'></i></button></div>");		
		}	
		$("#currAttachDiv").show();		   
	},
	onError:function (files, status, message)
	{	  
	   $("#OutputDiv").html(message);
	   alert(message);  
	},
	showDelete:false
}
var uploadObj = $("#multiple_fileUploader").uploadFile(settings);


$(document).on("click", "div.upl_attachDiv>button", function(){
	var fileID = $(this).attr("fileID");			
	var ans= confirm('Are you sure to delete this attachment ?');
	if(ans == true){
		$(this).parent().remove();
		$.ajax({
		   type: "POST",    
		   url: "<?php echo ma_url('delete_record_file'); ?>",
		   data: "fileID="+ fileID,
		   success: function(msg){
		   },
		   error: function(){
			 alert('Fail!');
		   }
		});
	}	
});


</script>