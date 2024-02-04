<script>
$('#multi_fusion_id').select2();
$('#l_dept, #l_office_abbr').change(function(){
	
	var dept_id = $('#l_dept').val();
	var offc_id = $('#l_office_abbr').val();
	
	// alert('hello' + dept_id);
	// alert('hello' + offc_id);
	//if(dept_id != '' && dept_id!= 'ALL'){
		
	var URL='<?php echo base_url() ."leave_reports/dropdown_users"; ?>';
	$.ajax({
	   type: 'GET',    
	   url: URL,
	   data:'offc_id='+offc_id +'&dept_id='+dept_id,
		success: function(data){
		  var a = JSON.parse(data);
			$("#multi_fusion_id").empty();		  
			$.each(a, function(index,jsonObject){
				 $("select#multi_fusion_id").append('<option value="'+jsonObject.id+'">' + jsonObject.name + ' (' + jsonObject.id + ')' + '</option>');
			});	
			$('#multi_fusion_id').select2();
		},
		error: function(){	
			//alert('error!');
		}
	  });
		  
	//}else{
		/*$('#fusion_id').html('<option value="">Select Id</option>');*/
	//}
});
</script>