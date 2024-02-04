<script>

$("#start_date").datepicker({ dateFormat: 'yy-mm-dd' });
$("#end_date").datepicker({ dateFormat: 'yy-mm-dd' });

// PROCESS --> CLIENT FILTER
$("#client_id").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'0','process_id','Y');
});

</script>