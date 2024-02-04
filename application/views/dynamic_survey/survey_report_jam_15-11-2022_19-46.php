<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/> 
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/> 
<script src="<?php echo base_url() ?>assets/css/search-filter/js/jquery.dataTables.min.js"></script>
<style>
	.filter-widget .select2-selection {
		overflow-y:scroll;
	}
	.dataTables_filter {
		position: absolute;
		right: 25px;
		margin: -50px 0 0 0;
	}
	.dataTables_length {
		margin:0 0 10px 0;
	}
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:2px;
		font-size:11px;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}

	.panel .table td, .panel .table th{
		font-size:11px;
		padding:6px;
	}
	
	.hide{
	  disply:none;	  
	}
	
	.modal-dialog {
		width: 800px;
	}
	.modal
	{
		overflow:auto;
	}
	
	/*---------- MY CUSTOM CSS -----------*/
	.rounded {
	  -webkit-border-radius: 3px !important;
	  -moz-border-radius: 3px !important;
	  border-radius: 3px !important;
	}

	.mini-stat {
	  padding: 5px;
	  margin-bottom: 20px;
	}

	.mini-stat-icon {
	  width: 30px;
	  height: 30px;
	  display: inline-block;
	  line-height: 30px;
	  text-align: center;
	  font-size: 15px;
	  background: none repeat scroll 0% 0% #EEE;
	  border-radius: 100%;
	  float: left;
	  margin-right: 10px;
	  color: #FFF;
	}

	.mini-stat-info {
	  font-size: 12px;
	  padding-top: 2px;
	}

	span, p {
	  /*color: white;*/
	}

	.mini-stat-info span {
	  display: block;
	  font-size: 20px;
	  font-weight: 600;
	  margin-bottom: 5px;
	  margin-top: 7px;
	}

	/* ================ colors =====================*/
	.bg-facebook {
	  background-color: #3b5998 !important;
	  border: 1px solid #3b5998;
	  color: white;
	}

	.fg-facebook {
	  color: #3b5998 !important;
	}

	.bg-twitter {
	  background-color: #00a0d1 !important;
	  border: 1px solid #00a0d1;
	  color: white;
	}

	.fg-twitter {
	  color: #00a0d1 !important;
	}

	.bg-googleplus {
	  background-color: #db4a39 !important;
	  border: 1px solid #db4a39;
	  color: white;
	}

	.fg-googleplus {
	  color: #db4a39 !important;
	}

	.bg-bitbucket {
	  background-color: #205081 !important;
	  border: 1px solid #205081;
	  color: white;
	}

	.fg-bitbucket {
	  color: #205081 !important;
	}
	
		
	.highcharts-credits {
		display: none !important;
	}
	
	.form-group {
		margin-bottom:8px;
	}

	.checklist input[type=checkbox]{
		margin-right:5px;
	}
	.phead{
		background-color: #f5f7f9;
		padding: 10px 15px;
	}
	.bRow{
		background-color: #f1f1f1;
		padding: 10px 0px;
		text-align: center;
		font-size: 16px;
		font-weight: 600;
	}
	.bCol{
		padding:10px 0px;
		text-align: center;
		font-size: 14px;
	}
	
</style>
<?php
$Client_content ='';
$Process_content ='';
$Department_content ='';
$Location_content ='';
?>
<div class="wrap">
<section class="app-content">
	<div class="widget">
		<div class="widget-body">
			<h4 class="widget-title">
				Survey Filters
			</h4>
		</div>
		<hr class="widget-separator">
		 <div class="widget-body">
			<div class="filter-widget"> 
			<form class="" method='POST' action="<?php echo base_url(); ?>dynamic_survey/survey_report_jam" style="margin:10px;">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="start_date">Start Date</label><sup style="color:red">*</sup><br>
							<input class="form-control" type="date" value="<?=$start_date?>" name="start_date" id="start_date" required="">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="start_date">End Date</label><sup style="color:red">*</sup><br>
							<input class="form-control" type="date" value="<?=$end_date?>" name="end_date" id="end_date" required="">
						</div>
					</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>Location</label>
									<select name="office_id" class="form-control" placeholder="Select Location">
										<?php
										if(get_role_dir()=="super" || $is_global_access==1) echo '<option value="All">ALL</option>';
										else echo '<option value="">All</option>';
										?>
										<?php foreach ($location_list as $key => $value) { 
											$sel = "";
											if ($value['abbr'] == $office_id) $sel = "selected";
											?>
												<option value="<?php echo $value['abbr']; ?>" <?php echo $sel; ?>><?php echo $value['office_name'] ?></option>
											<?php } ?>
									</select>
								</div>							
							</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<input type="checkbox" name="download_report" id="check_download"> Download Report
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<button type="submit" class="submit-btn" value="Download Report" id="download">Show</button>
						</div>
					</div>
				</div>
			</form>	
			</div>
		</div>
	</div>
	
	<div class="common-top">
		<div class="widget">
			<div class="widget-body">
				<h4 class="widget-title">
					Survey Reports
				</h4>
			</div>
			<hr class="widget-separator">
			<div class="widget-body">
					<div class="table-bg data-widget survey-table">
					  <table class="table common_data table-bordered table-striped">
						<thead>
						  <tr>
							<th>Sl</th>
							<th>Name of Survey</th>
							<th>Fusion Id</th>
							<th>User Name</th>
							<th>Department</th>
							<th>Client</th>
							<th>Process</th>
							<th>Questions</th>
							<th>Rating</th>
						  </tr>
						</thead>
						<tbody>
							<?php 
							if(!empty($survey_list)){
							$i = 1;
							foreach ($survey_list as $key => $value) { ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $value['name']; ?></td>
									<td> <?php echo "-";//$value['fusion_id']; ?> </td>
									<td> <?php echo "-";//$value['uname']; ?></td>
									<td> <?php echo $value['departments_user']; ?></td>
									<td> <?php echo $value['client_names']; ?></td>
									<td> <?php echo $value['process_names']; ?></td>
									<td><?php echo $value['questions']; ?></td>
									<td><?php
									if ($value['num_value'] != '') echo $value['num_value'];
									else echo $value['txt_value'];
									?></td>
								</tr>
							<?php
							$i++;
						 } }?>
						  
						</tbody>
					  </table>
					</div>
				</div>
		</div>
	</div>		
<section>
</div>



<script type="text/javascript">
	document.querySelector("#req_no_position").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
});
</script>
<script>
$(document).ready(function () { 
	var baseURL ="<?php echo base_url(); ?>";
		$("#check_download").click(function () {
			// console.log('lol');
			var checked = $('#check_download').is(':checked');
			// console.log(checked);
			$('#download').text(checked ? 'Download Report' : 'Show');
		});
	    $("#client").select2();
        $("#process").select2();
        $("#department").select2();
        $("#location").select2();
		$("#client").change(function(){
       		 var clients = $('#client').val(); 
			$.ajax({
				type: 'GET',    
				url:baseURL+'dynamic_survey/get_process_by_clients',
				data:'clients='+ clients,
				success: function(data){
					var res;
					var i=0;
					var a = JSON.parse(data); 
					
					var b = $("#process").val();
					$("#process option").remove();
				
					if(b != null){ 
						var res =  b.toString().split(',');
						var leng = res.length;
					}
					$.each(a, function(index,jsonObject){
						
						if( i < leng){
							if(jsonObject.id == res[i]){
									$("#process").append('<option value="'+jsonObject.id+'" selected="selected">' + jsonObject.name + '</option>');
									i++;
							}else{
								$("#process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
							}
						}else{
							$("#process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
						}
					});	
				}
			});
		});

      $('.select-box').selectize({
          sortField: 'text'
      });
  });
  
</script>


<script>
	$(document).ready(function() {
		$('.common_data').DataTable();
	} );
</script>