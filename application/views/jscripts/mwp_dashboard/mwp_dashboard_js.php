
<script>

$(document).on('change','#filter_regions',function(){
	var datas = {"regions_name": $(this).val()};
	var request_url = "<?php echo base_url('mwp_qa_dashboard/get_regions_location_list'); ?>";

	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat==true) {
			//let options_html = "<option value=''>All</option>";
			let options_html = "";

			$('#office_location_filter').multiselect('clearSelection');
	    	$('#office_location_filter').multiselect('refresh');

            $.each(res.datas,function(index,element) {
                options_html += '<option value="'+element.abbr+'">'+element.office_name+'</option>';
            });

            $('#office_location_filter').html(options_html);
		}
		else {
			if (res.nothing_selected) { alert(res.errmsg); }
			$('#office_location_filter').html(''); 
		}

		$('#office_location_filter').multiselect('rebuild');

	},request_url, datas, 'text');
});

// $(document).on('change','#clients',function(){
// 	var datas = {"client_name": $(this).val()};
// 	var request_url = "<?php echo base_url('mwp_qa_dashboard/get_client_process_list'); ?>";

// 	process_ajax(function(response)
// 	{
// 		var res = JSON.parse(response);
// 		if (res.stat==true) {

// 			$('#process').multiselect('clearSelection');
// 	    	$('#process').multiselect('refresh');

// 			let options_html = "";

//             $.each(res.datas,function(index,element) {
//                 options_html += '<option value="'+element.id+'">'+element.name+'</option>';
//             });

//             $('#process').html(options_html);
// 		}
// 		else {
// 			//if (res.nothing_selected) { alert(res.errmsg); }
// 			$('#process').html(''); 
// 		}

// 		$('#process').multiselect('rebuild');

// 	},request_url, datas, 'text');
// });


$(document).on('click','.get_reports',function(){

	let report_type = $(this).attr("type");
	$('.save_common_btn').attr('type',report_type);

	let regions = $("#filter_regions").val();
	let locations = $("#office_location_filter").val();
	let clients = $("#clients").val();
	let processes = $("#process").val();
	let designation = $("#designation").val();
	let report_head = $("#report_head").val();

	let datas = {
		"report_type": report_type, 
		"regions": regions, 
		"locations": locations, 
		"clients": clients, 
		"processes": processes,
		"designation": designation,
		"report_head": report_head
	};

	var request_url = "<?php echo base_url('mwp_qa_dashboard/get_report'); ?>";
	process_ajax(function(response)
	{
		$("#"+report_type).html(response);
	},request_url, datas, 'text');


});
</script>