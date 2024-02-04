<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('#default-datatable').DataTable({
	"pageLength":50
});

// DATEPICKER
$('.oldDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy' });

$("select[name='course_id']").change(function(){
	cid = $(this).val();
	$("input[name='course_start_date']").val('');
	$("input[name='course_schedule_time']").val('');
	get_course_batch_list(cid);
});

$("select[name='search_course_type']").change(function(){
	cid = $(this).val();
	if(cid == 'ALL'){
		$("select[name='search_course_batch']").empty();
		$("select[name='search_course_batch']").append('<option value="ALL">-- All Batch --</option>');
	} else {
		get_course_batch_list_all(cid);
	}
});

$("select[name='batch_id']").change(function(){
	bid = $(this).val();
	get_course_batch_details(bid);
});

function get_course_batch_list(cid){
	URL = "<?php echo base_url('ld_courses/info_courses_batch_list'); ?>";
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data:'cid='+cid,
		success: function(data){
		  var a = JSON.parse(data);
			$("select[name='batch_id']").empty();
			$("select[name='batch_id']").append('<option value="">-- Select Batch --</option>');
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("select[name='batch_id']").append('<option value="'+jsonObject.id+'">' + jsonObject.batch_name + ' (' + jsonObject.batch_trainer + ')</option>');
			});
			if(countercheck == 0){
				$("select[name='batch_id']").empty();
				$("select[name='batch_id']").append('<option value="">-- No Batch Found --</option>');			
			}
		},
		error: function(){	
			//alert('error!');
		}
	  });
}

function get_course_batch_list_all(cid){
	URL = "<?php echo base_url('ld_courses/info_courses_batch_list'); ?>";
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data:'cid='+cid,
		success: function(data){
		  var a = JSON.parse(data);
			$("select[name='search_course_batch']").empty();
			$("select[name='search_course_batch']").append('<option value="ALL">-- All Batch --</option>');
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("select[name='search_course_batch']").append('<option value="'+jsonObject.id+'">' + jsonObject.batch_name + ' (' + jsonObject.batch_trainer + ')</option>');
			});
			if(countercheck == 0){
				$("select[name='search_course_batch']").empty();
				$("select[name='search_course_batch']").append('<option value="">-- No Batch Found --</option>');			
			}
		},
		error: function(){	
			//alert('error!');
		}
	  });
}

function get_course_batch_details(bid){
	URL = "<?php echo base_url('ld_courses/info_courses_batch_details'); ?>";
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data:'bid='+bid,
		success: function(data){
		  var a = JSON.parse(data);
			$("input[name='course_start_date']").val('');
			$("input[name='course_schedule_time']").val('');
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("input[name='course_start_date']").val(jsonObject.batch_start_date);
				 $("input[name='course_schedule_time']").val(jsonObject.schedule_info);
			});
		},
		error: function(){	
			//alert('error!');
		}
	  });
}
</script>