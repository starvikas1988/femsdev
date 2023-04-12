<style>
.table>thead>tr>th, .table>thead>tr>td, .table>tbody>tr>th, .table>tbody>tr>td, .table>tfoot>tr>th, .table>tfoot>tr>td {vertical-align: middle;padding: 2px;font-size: 11px;}.table>thead>tr>th, .table>tfoot>tr>th {text-align: center;}.panel .table td, .panel .table th {font-size: 11px;padding: 6px;}.hide {disply: none;}.modal-dialog {width: 800px;}.modal {overflow: auto;}.rounded {-webkit-border-radius: 3px !important;-moz-border-radius: 3px !important;border-radius: 3px !important;}.mini-stat {padding: 5px;margin-bottom: 20px;}.mini-stat-icon {width: 30px;height: 30px;display: inline-block;line-height: 30px;text-align: center;font-size: 15px;background: none repeat scroll 0% 0% #EEE;border-radius: 100%;float: left;margin-right: 10px;color: #FFF;}.mini-stat-info {font-size: 12px;padding-top: 2px;}span, p {}.mini-stat-info span {display: block;font-size: 20px;font-weight: 600;margin-bottom: 5px;margin-top: 7px;}.bg-facebook {background-color: #3b5998 !important;border: 1px solid #3b5998;color: white;}.fg-facebook {color: #3b5998 !important;}.bg-twitter {background-color: #00a0d1 !important;border: 1px solid #00a0d1;color: white;}.fg-twitter {color: #00a0d1 !important;}.bg-googleplus {background-color: #db4a39 !important;border: 1px solid #db4a39;color: white;}.fg-googleplus {color: #db4a39 !important;}.bg-bitbucket {background-color: #205081 !important;border: 1px solid #205081;color: white;}.fg-bitbucket {color: #205081 !important;}.highcharts-credits {display: none !important;}.text-box {background-color: #fff;padding: 10px 10px;margin: 5px 5px 25px 5px;border-radius: 4px;}.text-headbox {background-color: #1296c0;}.bhead {background-color: #1296c0;padding: 8px;color: #fff;font-size: 20px;letter-spacing: 1.8px;font-weight: 600;}.btext {background-color: #d4eff7;padding: 17px;border-radius: 20px 0px 0px 0px;font-size: 25px;}#pareto_test_composed .x.axis text {text-anchor: end !important;transform: rotate(-60deg);}li.oneItem {display: inline-block;background-color: #188ae2;padding: 10px;color: #fff;border-radius: 7px;cursor: pointer;}li.oneItem.active {background-color: #195bbb;}#dateWiseData td, #evaluator td, #tlWise td, #agentWise td {text-align: center;}#select_process option{text-transform:capitalize;}.monthlyData{font-weight: bold;}.weeklyTrend td{text-align: center;padding: 10px !important;font-size: small !important;}.bucket_0{background-color: #d74418 !important;color: #fff;}.bucket_1{background-color: #ff4700 !important;color: #fff;}.bucket_2{background-color: #ff6a00 !important;color: #fff;}.bucket_3{background-color: #ffb100 !important;color: #fff;}.bucket_4{background-color: #20cb3d !important;color: #fff;}#weekly_trendChart{height: 300px;}.top_ribbon{background-color: #337ab7;color: #fff;}.top_ribbon .widget-title{color: #fff !important;}.table-freeze-header thead th, .table-freeze-header tbody td {font-size: small !important;word-break: break-word !important;}.table-freeze-header tbody td{padding: 8px !important;}.table-freeze-header tbody{display:block;max-height:300px;overflow:hidden auto;}.table-freeze-header thead, .table-freeze-header tbody tr {display:table;width:100%;table-layout:fixed;}
	/*validation*/
	    .invalid-feedback {
	      display: none;
	      width: 100%;
	      margin-top: .25rem;
	      font-size: .875em;
	      color: #dc3545;
	    }
	    .form-control.is-invalid, .was-validated .form-control:invalid {
	      border-color: #dc3545;
	      padding-right: calc(1.5em + .75rem) !important;
	/*      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");*/
	      background-repeat: no-repeat;
	      background-position: right calc(.375em + .1875rem) center;
	      background-size: calc(.75em + .375rem) calc(.75em + .375rem);
	    }
	    .form-control.is-valid, .was-validated .form-control:valid {
	      border-color: #28a745;
	      padding-right: calc(1.5em + .75rem) !important;
	/*      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");*/
	      background-repeat: no-repeat;
	      background-position: right calc(.375em + .1875rem) center;
	      background-size: calc(.75em + .375rem) calc(.75em + .375rem);
	    }

</style>
<link rel="stylesheet" href="<?php echo base_url('/libs/bower/font-awesome/css/font-awesome-all.css');?>">
<link rel="stylesheet" href="<?php echo base_url('/libs/bower/jquery-toast-plugin/css/jquery.toast.css');?>">
<!-- Metrix -->
<div class="wrap">

   <nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="margin-bottom: 8px !important;background-color: #fff">
      <li class="breadcrumb-item">Manage Vertical & campaign</li>
    </ol>
  </nav>

   <section class="app-content">
	<div class="row">
		<div class="col-md-6">
			 <div class="widget" style="display: block;">
			    <hr class="widget-separator" />
			    <div class="widget-head clearfix" style="background-color: #f1f2f3; padding: 10px; color: #a70000;">
			        <div class="row">
			            <div class="col-md-4">
			                <h4 style="padding-left: 10px;"><i class="fa fa-bar-chart"></i> Vertical</h4>
			            </div>
			        </div>
			    </div>
			    <div class="widget-body">
			        <div class="row">
		                <div class="col-md-4" style="margin-bottom: 2px; float: right;">
		                    <button class="btn btn-success btn-sm add-vertical-btn" style="float: right;margin-bottom: 5px;" data-toggle="modal" data-target="#add-edit-vertical-modal"><i class="fas fa-plus-circle"></i>&nbsp;Add New</button>
		                </div>
		                <div class="col-md-12">
		                    <div class="table-responsive" style="overflow-y: auto; height: 100%; max-height: 500px;">
		                        <table data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%" style="white-space: nowrap;">
		                            <thead>
		                                <tr class="bg-info text-center">
		                                    <th>SL. No.</th>
		                                    <th>Vertical</th>
		                                    <th>Action</th>
		                                </tr>
		                            </thead>

		                            <tbody id="vertical-table-data">
		                                
		                            </tbody>
		                        </table>
		                    </div>
		                </div>
		            </div>
			    </div>
			</div>
		</div>
		<div class="col-md-6">
			 <div class="widget" style="display: block;">
			    <hr class="widget-separator" />
			    <div class="widget-head clearfix" style="background-color: #f1f2f3; padding: 10px; color: #a70000;">
			        <div class="row">
			            <div class="col-md-4">
			                <h4 style="padding-left: 10px;"><i class="fa fa-bar-chart"></i> Campaign</h4>
			            </div>
			        </div>
			    </div>
			    <div class="widget-body">
			        <div class="row">
		                <div class="col-md-4" style="margin-bottom: 2px; float: right;">
		                    <button class="btn btn-success btn-sm add-campaign-btn" style="float: right;margin-bottom: 5px;" data-toggle="modal" data-target="#add-edit-campaign-modal"><i class="fas fa-plus-circle"></i>&nbsp;Add New</button>
		                </div>
		                <div class="col-md-12">
		                    <div class="table-responsive" style="overflow-y: auto; height: 100%; max-height: 500px;">
		                        <table data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%" style="white-space: nowrap;">
		                            <thead>
		                                <tr class="bg-info text-center">
		                                    <th>SL. No.</th>
		                                    <th>Campaign</th>
		                                    <th>Action</th>
		                                </tr>
		                            </thead>

		                            <tbody id="campaign-table-data">
		                                
		                            </tbody>
		                        </table>
		                    </div>
		                </div>
		            </div>
			    </div>
			</div>
		</div>
	</div>

	<!-- Modal For vertical -->
	<div class="modal fade modal-design" id="add-edit-vertical-modal" tabindex="-1" role="dialog" aria-labelledby="add-edit-vertical-modal-label" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <form id="add-edit-vertical-modal-form" action="" method="POST">
	            	<input type="hidden" name="verticalSubmitType" id="verticalSubmitType" value="add">
	            	<input type="hidden" name="verticalEditId" value="" id="verticalEditId">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                    <h4 class="modal-title" id="add-edit-vertical-modal-label">Add Vertical</h4>
	                </div>
	                <div class="modal-body">
	                    <div class="row">
	                        <div class="col-md-12">
	                            <div class="form-group">
	                                <label>Vertical Name :</label>
	                                <input type="text" name="verticalName" id="verticalName" class="form-control" required />
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                    <button type="submit" id="add-edit-vertical-save-btn" class="btn btn-primary">Save</button>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>

	<!-- Modal For Campaign -->
	<div class="modal fade modal-design" id="add-edit-campaign-modal" tabindex="-1" role="dialog" aria-labelledby="add-edit-campaign-modal-label" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <form id="add-edit-campaign-modal-form" action="" method="POST">
	            	<input type="hidden" name="campaignSubmitType" id="campaignSubmitType" value="add">
	            	<input type="hidden" name="campaignEditId" value="" id="campaignEditId">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                    <h4 class="modal-title" id="add-edit-campaign-modal-label">Add Campaign</h4>
	                </div>
	                <div class="modal-body">
	                    <div class="row">
	                        <div class="col-md-12">
	                            <div class="form-group">
	                                <label>Campaign Name :</label>
	                                <input type="text" name="campaignName" id="campaignName" class="form-control" required />
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                    <button type="submit" id="add-edit-campaign-save-btn" class="btn btn-primary">Save</button>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>

   </section>
</div><!-- .wrap -->