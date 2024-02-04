<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/> 
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/> 
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
	.disabled {
		cursor:not-allowed;
	}
	.disabled:hover {
		background-color: gray;
		cursor:not-allowed;
	}
</style>
<div class="wrap">
    <section class="app-content">
		<div class="widget">
			<div class="widget-body">
				<form method='POST' action="<?php echo base_url(); ?>dynamic_survey/create_survey">
					<div class="row">
						<div class="col-md-12" class="repeatable">
							
						   <div id="main-form">
							   <div class="filter-widget">
									<!--start top-->
									<div class="row">
										<div class="col-sm-6">
											<h4 class="widget-title">
												Create Survey
											</h4>
										</div>
										<div class="col-sm-6">
											<div class="btn-right">
												<button type="button" class="repeat submit-btn">Add Questions</button>
											</div>
										</div>
									</div>
									<!--end top-->
									<div class="common-top">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<input type="text" name="survey_name" class="form-control" placeholder="Survey name" id="" required>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<select name='category_id' required>
														<option id="" value="">Select Category</option>
														<?php 
															foreach($master_survey_category as $key=>$val){
																echo "<option value='".$val['id']."'>".$val['name']."</option>";
															}
														?>
													</select>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group">
													<select name='type_id' required>
														<option value="">Select Type</option>
														<option value="1">Star</option>
														<option value="2">Button</option>
													    
													</select>
												</div>
											</div>
										</div>
										<div class="base-group" style="display:none">
											<div class="filter-widget">								
												<div class="create-form">
													<div class="row">
														<div class="col-sm-12">
															<div class="form-group">
																<input type="text" class="form-control" value="" placeholder="Survey questions">
																<input type="checkbox">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- <div class="create-form">
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<input type="text" name="question[]" class="form-control" placeholder="Survey Questions" id="">
														<input type="checkbox" name="checkbox[]">
													</div>
												</div>
											</div>
										</div> -->
									</div>								
								</div>
						  </div> 
					</div> 
				</div>
				<div class="body-widget">
					<button type="submit" id="submit_survey" class="submit-btn1 disabled" disabled>Submit</button>
				</div>
			</form>
		</div>
	</div>
