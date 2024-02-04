<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<style>
	td{
		font-size:10px;
	}
	
	#default-datatable th{
		font-size:11px;
	}
	#default-datatable th{
		font-size:11px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
	}
	
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">All Candidate List</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
							
					<div class="widget-body">
					
						<?php echo form_open('',array('method' => 'get','id' => 'dynamic_search_form')) ?>
						
							<input type="hidden" id="req_status" name="req_status" value='' >
							
							<div class="filter-widget">								
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Start Date</label>
											<input type="text" class="form-control" id="from_date" name="from_date" value="<?=date('Y-m-01')?>" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>End Date</label>
											<input type="text" class="form-control" id="to_date" name="to_date" value="<?=date('Y-m-d', strtotime('last day of this month'))?>" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Brand</label>
											<select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>
												<?php foreach ($company_list as $key => $value) {
												?>	
														<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
												<?php  }?> 
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Location</label>
											<select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>
											<?php foreach($location_list as $loc){ ?>
												<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>												
											<?php } ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Department</label>
											<select id="select-department" class="form-control" name="department_id[]" autocomplete="off" placeholder="Select Department" multiple>
											<?php
												foreach($department_list as $k=>$dep){	
											?>
											<option value="<?php echo $dep['id']; ?>"><?php echo $dep['shname']; ?></option>
											<?php		
												}
											?>	
											</select>
										</div>
									</div>									
									
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Client</label>
											<select id="fclient_id" name="client_id[]" autocomplete="off" placeholder="Select Client" multiple>	
											<?php foreach($client_list as $client){
											?>
											<option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
											<?php } ?>	
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Process</label>
											<select id="fprocess_id"  name="process_id" autocomplete="off" placeholder="Select Process" class="select-box" >
											<option value="">-- Select Process--</option>	
											<?php foreach($process_list as $process){
											?>
											<option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
											<?php } ?>	
											</select>
										</div>
									</div>
									<div class="col-sm-3" id="requisation_div" style="display:none;">
										<div class="form-group">
											<label>Requisition</label>
											<select  autocomplete="off" name="requisition_id[]" id="edurequisition_id" placeholder="Select Requisition" class="select-box">
											<option="">ALL</option>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" name="search" id="search" value="Search" class="submit-btn">
												<i class="fa fa-search" aria-hidden="true"></i>
												Search
											</button>
										</div>
									</div>
								</div>
								
							</div>
							
						</form>							
					</div>			
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
		
		<div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="widget">
						<input type="hidden" name="search_click" id="search_click" value="0">
                            <input type="hidden" name="button_search_value" id="button_search_value" value="0">
                            <input type="hidden" name="data_url" id="data_url" value="<?php echo base_url('dfr_new/getCandidateListAjaxResponse'); ?>">
						<div class="tbl-container1">
                            <div id="bg_table" class="table-responsive1 new-table tbl-fixed1">							
								<table id="dynamic-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Requision Code</th>
										<th><b>Candidate Name</b></th>
										<th>Hiring Source</th>
										<th>Onboarding Type</th>
										<th>Gender</th>
										<th>Mobile</th>
										<th>DOB</th>
										<th>State</th>
										<th>City</th>
										<th>Postcode</th>
										<th>Country</th>
										<th><b>Status</b></th>
										<th>Added Date/Time</th>
									</tr>
								</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</section>
	
</div><!-- .wrap -->

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>

<script type="text/javascript">
	/*var dataTable = $('#default-datatable').DataTable({
            "pageLength": '20',
            "lengthMenu": [
                [20, 50, 100, 150, 200, -1],
                [20, 50, 100, 150, 200, 'All'],
            ],
			"columnDefs": [
            { "searchable": false, "targets": [0] },  // Disable search on first 
            { "orderable": false, "targets": [0] }    // Disable orderby on first
            ],
            // 'scrollY': '60vh',
            'scrollCollapse': false,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'searching': false, // Remove default Search Control
            'ajax': {
                complete: function (data) {                  
                },
                
                'url': '<?php echo base_url('dfr_new_21/getCandidateListAjaxResponse'); ?>',
                'data': function (data) {
                    // Read values
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var select_brand = $('#select-brand').val();
                    var office_id = $('#fdoffice_ids').val();
                    var select_department = $('#select-department').val();
                    var fclient_id = $('#fclient_id').val();
                    var fprocess_id = $('#fprocess_id').val();
                    var requisation_div = $('#requisation_div').val();
                    var search_click = $('#search_click').val();
                    var req_status = $('#button_search_value').val();
                    // Append to data
                    data.from_date = from_date;
                    data.to_date = to_date;
                    data.brand = select_brand;
                    data.office_id = office_id;
                    data.department_id = select_department;
                    data.client_id = fclient_id;
                    data.process_id = fprocess_id;
                    data.requisation_div = requisation_div;
                    data.searchClick = search_click;
                    data.req_status = req_status;
                }
            },
            'columns': [
                {data: 'sl'},
                {data: 'requisition_id'},
                {data: 'fname'},
                {data: 'hiring_source'},
                {data: 'onboarding_type'},
                {data: 'gender'},
                {data: 'phone'},
                {data: 'd_o_b'},
                {data: 'state'},
                {data: 'city'},
                {data: 'postcode'},
                {data: 'country'},
                {data: 'status'},
                {data: 'added_date'}
            ]

        });

        $('#search').click(function (e) {
            e.preventDefault();
            $('#search_click').val(1);
            dataTable.draw();
        });*/
</script>

<script type="text/javascript">
	document.querySelector("#req_no_position").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
});
</script>
<script>
/*$(function() {  
 $('#multiselect').multiselect();

 $('#edurequisition_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); */
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#fdoffice_ids').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); 
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#select-brand').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); 
</script>

<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#fclient_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); 
</script>
<script>
/*$(function() {  
 $('#multiselect').multiselect();

 $('#fprocess_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); */
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#select-department').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});

</script>
<script>
	 $(document).ready(function () {
      $('.select-box').selectize({
          sortField: 'text'
      });
  });
  
</script>
