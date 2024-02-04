<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('#file_category').select2();
$('.newDatePickFormat').datepicker({ dateFormat: 'yy-mm-dd' });
$('#schedule_start_time').datetimepicker({ showSecond: false, dateFormat: 'yy-mm-dd', timeFormat: 'HH:mm:ss', });
$('#schedule_end_time').datetimepicker({ showSecond: false, dateFormat: 'yy-mm-dd', timeFormat: 'HH:mm:ss', });
$('#e_schedule_start_time').datetimepicker({ showSecond: false, dateFormat: 'yy-mm-dd', timeFormat: 'HH:mm:ss', });
$('#e_schedule_end_time').datetimepicker({ showSecond: false, dateFormat: 'yy-mm-dd', timeFormat: 'HH:mm:ss', });

$("#exam_start_time").datetimepicker({
		dateFormat: "mm/dd/yy",
		timeFormat: "HH:mm",
		minDate   : '-1D'
}).datetimepicker( "setDate", "<?php echo CurrDateTimeMDY();?>" );

$('input[name="date_range"]').daterangepicker({
opens: 'left',
 locale: {
	"format": "DD/MM/YYYY",
	"separator": " - "
  }
}, function(start, end, label) {
  //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
});

// DATEPICKER
$('.oldDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy' });
$('.timeFormat').timepicker({ timeFormat: 'HH:mm:ss', });

function categorycheck()
{
	var scat = $('#modalKnowledgeAttachment #file_category').val();
	if(scat == 0)
	{ 
		$('#modalKnowledgeAttachment #enter_category').val('');
		$('#modalKnowledgeAttachment #categoryname').show();
	} else {
		if((scat != "") && (scat != 0))
		{
			$('#modalKnowledgeAttachment #enter_category').val(scat);
			$('#modalKnowledgeAttachment #categoryname').hide();
		} else {
			$('#modalKnowledgeAttachment #enter_category').val('');
			$('#modalKnowledgeAttachment #categoryname').hide();
		}
	}
}


$('.ld-file-entry ').click(function()
{
	$('#modalKnowledgeAttachment').modal('show');
});




	// OPEN VIEW MODAL
	$(".viewmodalclick").click(function(){	
		var clickid =$(this).attr("sourceid");
		$('#modaldocview').modal('show');
		$('.docbodymodal').html('');
		$.ajax({
		   type: 'POST',    
		   url: '<?php echo base_url(); ?>ld_programs/ld_viewdata',
		   data:'kid='+ clickid,
		   success: function(data){
				$('.docbodymodal').html(data);
			},
			error: function(){
				alert('Fail!');
			}
		});
	});
	
	
</script>
<script>
    $(".dataTables_empty").html("No record found");
	$(".dataTables_empty").addClass("empty_ld");
    </script>