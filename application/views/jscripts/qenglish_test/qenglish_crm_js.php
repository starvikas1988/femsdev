<script>
$(".kyt_datePicker").datepicker();
 $(function() {
	var today = new Date();
	$( "#date_pic" ).datepicker({
	   minDate: today,
	   dateFormat: 'dd/mm/yy'
	});
	$( "#date_pic2" ).datepicker({
	   minDate: today,
	   dateFormat: 'dd/mm/yy'
	});
	$('#time_pic').timepicker({
	   showSecond: true,
	   timeFormat: 'HH:mm:ss'
	});
	// calculation of day of leave
	$("#firstDate").datepicker({
	}); 
	$("#secondDate").datepicker({
	   onSelect: function () {
		  myfunc();
	   }
	}); 

	function myfunc(){
	   var start= $("#firstDate").datepicker("getDate");
	   var end= $("#secondDate").datepicker("getDate");
	   if(start<=end){
		  days = (end- start) / (1000 * 60 * 60 * 24);
		  no_of_day = (Math.round(days));
		  //$('#no_of_days').text(no_of_day+1);
		  $('#no_of_days').val(no_of_day+1);
	   }else{
		  $('#no_of_days').text('You have selected wrong day').css("color", "red");
		  $('#sub_but').prop('disabled', true);

	   }
	  
	   // alert(Math.round(days));
	}
	
 });
 function change_leavestatus(id,obj){
	sts = $(obj).val();
	$.post("<?php echo base_url();?>/kyt/change_leave_status",{id: id,status: sts},
	   function(data,status){
		  alert("Status Updated Successfully");
	   });
 }
 
 function change_Partical_leavestatus(id,obj){
	sts = $(obj).val();
	//alert(id+sts);
	$.post("<?php echo base_url();?>/kyt/change_partical_leave_status",{id: id,status: sts},
	   function(data,status){
		  alert("Status Updated Successfully");
	   });
 }

 $('.editCourseBtn').on('click', function(){
	 cid = $(this).attr('rid');
	 cParams = $(this).attr('params');
	 $('#myCourseModal input[name="edit_id"]').val('');
	 $('#myCourseModal input[name="name"]').val('');
	 $('#myCourseModal textarea[name="description"]').val('');	 
	 if(cParams != ""){
		 dataFound = cParams.split('#');
		 $('#myCourseModal input[name="edit_id"]').val(cid);
		 $('#myCourseModal input[name="name"]').val(dataFound[0]);
		 $('#myCourseModal textarea[name="description"]').val(dataFound[1]);
		 $('#myCourseModal').modal();
	 }
 });

</script>