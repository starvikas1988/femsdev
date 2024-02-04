<script>
$('#select_from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });

$('#select_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });

	$('.fromdateCheck').on('change',function(){
			//alert('hello World');
			teacherId = $('#teacher_id').val();
			select_from_date = $('#select_from_date').val();
			to_date = $('#select_to_date').val();
			URL = "<?php echo base_url('diy/get_modify_availability_data'); ?>";
			if(select_from_date!=""&&to_date!=""){
				$.ajax({
				   type: 'GET',    
				   url:URL,
				   data:'start='+select_from_date+'&teacher=' + teacherId+'&end='+to_date,
					success: function(data){
						
					  $('.allData').html(data);
					  console.log(data);
					},
					error: function(){	
						//alert('error!');
					}
				});
			}	
});

	function checkuncheck(id){
		if($('#checkall'+id).is(':checked')){
			$('.unchecked'+id).prop('checked',true);
		}else{
			$('.unchecked'+id).prop('checked',false);
		}
	}	

</script>