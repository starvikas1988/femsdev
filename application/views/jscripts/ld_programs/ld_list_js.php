<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('#default-datatable').DataTable({
	"pageLength":50
});

// DATEPICKER
$('.oldDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy' });



$('.ldOPCourse').change(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).val();
	$('#sktPleaseWait').modal('show');
	$('.ldOPBatch').empty();
	$('.ldOPBatch').html('<option value="ALL">-- ALL --</option>');
	if(eidVal != "ALL"){
	$.ajax({
		url: "<?php echo base_url('ld_programs/course_batch_list_ajax'); ?>",
		type: "GET",
		data: { cid : eidVal },
		dataType: "json",
		success : function(result){
			counter=0;
			$.each(result, function(i,token){
				 counter++;
				 $(".ldOPBatch").append('<option value="'+token.id+'">' + token.batch_name + ' (' + token.trainer_name + ')</option>');
			});
			if(counter < 1){
				$('.ldOPBatch').html('<option value="">-- No Batch Found --</option>');
			}
			$('#sktPleaseWait').modal('hide');
		},
		error : function(result){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
	} else {
		$('#sktPleaseWait').modal('hide');
	}
});

</script>

<script>
    $(".dataTables_empty").html("No record found");
	$(".dataTables_empty").addClass("empty_ld");
    </script>