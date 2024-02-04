<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>

<script>
$('#search_from_date, #search_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2016:' + new Date().getFullYear().toString() });
$('#client_filter').change(function(){
	cid = $(this).val();
	populate_process_combo(cid,def='',objid='process_filter',isAll='Y');
});
</script>

<script>
   $(function () {
	    $('#multiselect').multiselect();
	    $('#office_id').multiselect({
	        includeSelectAllOption: false,
	        enableFiltering: true,
	        enableCaseInsensitiveFiltering: true,
	        filterPlaceholder: 'Search for something...'
	    });
	});
</script>


<script>
   $(function () {
	    $('#multiselect').multiselect();
	    $('#dept_id').multiselect({
	        includeSelectAllOption: false,
	        enableFiltering: true,
	        enableCaseInsensitiveFiltering: true,
	        filterPlaceholder: 'Search for something...'
	    });
	});
</script>

<script>
   $(function () {
	    $('#multiselect').multiselect();
	    $('#client_filter').multiselect({
	        includeSelectAllOption: false,
	        enableFiltering: true,
	        enableCaseInsensitiveFiltering: true,
	        filterPlaceholder: 'Search for something...'
	    });
	});
</script>

<script>
   $(function () {
	    $('#multiselect').multiselect();
	    $('#process_filter').multiselect({
	        includeSelectAllOption: false,
	        enableFiltering: true,
	        enableCaseInsensitiveFiltering: true,
	        filterPlaceholder: 'Search for something...'
	    });
	});
</script>

<script>
   $(function () {
	    $('#multiselect').multiselect();
	    $('#shDay').multiselect({
	        includeSelectAllOption: false,
	        enableFiltering: true,
	        enableCaseInsensitiveFiltering: true,
	        filterPlaceholder: 'Search for something...'
	    });
	});
</script>