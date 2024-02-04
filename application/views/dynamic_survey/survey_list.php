<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/> 
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<style>

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
					Survey List
				</h4>
			</div>
			<hr class="widget-separator">
			<div class="widget-body no-padding">
					<div class="table-bg table-small survey-table">
					  <table class="table table-bordered table-striped">
						<thead>
						  <tr>
							<th>Sl</th>
							<th>Date</th>
							<th>Survey Name</th>
							<th>Created by</th>
							<th>Category</th>
							<th>Actions</th>
						  </tr>
						</thead>
						<tbody>
						 
							<?php
							$i=1;
							foreach ($survey_list as $key => $value) {?>
				 			<tr><td><?php echo $i; ?></td>
								<td><?php echo $value['created_date']; ?></td>
								<td><?php echo $value['survey_name']; ?></td>
								<td><?php echo $value['uname']; ?></td>
								<td><?php echo $value['category_name']; ?></td>
								<td><?php if($value['launched'] == 1){
									echo "Launched";
								}else{ ?>
									<a href="javascript:void(0);" 
										data-toggle="modal" 
										data-target="#myModal" 
										data-title="<?php echo $value['survey_name']; ?>" 
										data-sid="<?php echo $value['sid']; ?>" 
										class="edit-btn">
										<i class="fa fa-sticky-note-o" aria-hidden="true"></i>
									</a>
									<?php } ?>
								</td>
							</tr>
							<?php $i++; } ?>
						  
						</tbody>
					  </table>
					</div>
				</div>
		</div>
				
	</section>
</div>

<!--start pop up here-->
<div class="modal fade modal-design" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal_title"></h4>
        </div>
        <div class="modal-body">
			<div class="filter-widget">
				<span style="font-size:11px;"><strong><i class="fas fa-clock"></i> TIMEZONE -</strong> EST</span>
				<form class="" method='POST' action="<?php echo base_url(); ?>dynamic_survey/launch_survey">
					<input type="hidden" id="sid" value="" name="sid">
					<div class="row">
						<div class="form-group col-md-6">
							<label for="start_date">Start Date</label><br>
							<input class="form-control" type="date" name="start_date" id="start_date" required="">
						</div>
						<div class="form-group col-md-6">
							<label for="start_date">End Date</label><br>
							<input class="form-control" type="date" name="end_date" id="end_date" required="">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6" id="client_div">
							<label for="Client">Client</label><br/>
								<select class="form-control" style="width:100%; height:100px" id="client" name="client[]" multiple required="">
									<option value="">Select</option>
									<option value="0">All</option>
									<?php 
									$Client_data = explode(",",$Client_content);
									foreach($client_list as $client): 
										$cScc='';
										if(in_array($client->id,$Client_data)){$cScc='Selected';};
									?>
								<option value="<?php echo $client->id; ?>" <?php echo $cScc; ?> ><?php echo $client->shname; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label for="Process">Process</label><br/>
							<div id="change-process">
							<select class="form-control" style="width:100%; height:100px" multiple id="process" name="process[]" required="">
								<option value="">Select</option>
								<option value="0">All</option>
								<?php 
								$Process_data = explode(",",$Process_content);
								foreach($process_list as $process): 
									$cScc='';
									if(in_array($process->id,$Process_data)){$cScc='Selected';};
								?>
								<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?> ><?php echo $process->name; ?></option>
							<?php endforeach; ?>
							</select>
							</div>
						</div>
						</div>
						<div class="row">
						<div class="form-group col-md-6">
							<label for="Location">Department</label><br>
							<select class="form-control" style="width:100%; height:100px" multiple id="department" name="department[]" required="">
								<option value="">Select</option>
								<?php 
								$Department_data = explode(",",$Department_content);
								foreach($department_list as $lc): 
									$cScc='';
									if(in_array($lc['shname'],$Department_data)){$cScc='Selected';};
								?>
									<option value="<?php echo $lc['id']; ?>" <?php echo $cScc; ?> ><?php echo $lc['shname']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					
					
						<div class="form-group col-md-6">
							<label for="Location">Location</label><br>
							<select class="form-control" style="width:100%; height:100px" id="location" multiple name="location[]" required="">
								<option value="">Select</option>
								<?php 
								$Location_data = explode(",",$Location_content);
								foreach($location_list as $lc): 
									$cScc='';
									if(in_array($lc['abbr'],$Location_data)){$cScc='Selected';};
								?>
								<option value="<?php echo $lc['abbr']; ?>" <?php echo $cScc; ?> ><?php echo $lc['location']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="red-btn1" data-dismiss="modal">Cancel</button>
					<button type="submit" class="submit-btn">Save</button>
				</div>
				</form>
			</div>
		</div>
      </div>
      
    </div>
  </div>
<!--end pop up here-->  


