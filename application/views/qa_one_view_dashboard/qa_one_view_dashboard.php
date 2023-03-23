<style>
.table>thead>tr>th, .table>thead>tr>td, .table>tbody>tr>th, .table>tbody>tr>td, .table>tfoot>tr>th, .table>tfoot>tr>td {vertical-align: middle;padding: 2px;font-size: 11px;}.table>thead>tr>th, .table>tfoot>tr>th {text-align: center;}.panel .table td, .panel .table th {font-size: 11px;padding: 6px;}.hide {disply: none;}.modal-dialog {width: 800px;}.modal {overflow: auto;}.rounded {-webkit-border-radius: 3px !important;-moz-border-radius: 3px !important;border-radius: 3px !important;}.mini-stat {padding: 5px;margin-bottom: 20px;}.mini-stat-icon {width: 30px;height: 30px;display: inline-block;line-height: 30px;text-align: center;font-size: 15px;background: none repeat scroll 0% 0% #EEE;border-radius: 100%;float: left;margin-right: 10px;color: #FFF;}.mini-stat-info {font-size: 12px;padding-top: 2px;}span, p {}.mini-stat-info span {display: block;font-size: 20px;font-weight: 600;margin-bottom: 5px;margin-top: 7px;}.bg-facebook {background-color: #3b5998 !important;border: 1px solid #3b5998;color: white;}.fg-facebook {color: #3b5998 !important;}.bg-twitter {background-color: #00a0d1 !important;border: 1px solid #00a0d1;color: white;}.fg-twitter {color: #00a0d1 !important;}.bg-googleplus {background-color: #db4a39 !important;border: 1px solid #db4a39;color: white;}.fg-googleplus {color: #db4a39 !important;}.bg-bitbucket {background-color: #205081 !important;border: 1px solid #205081;color: white;}.fg-bitbucket {color: #205081 !important;}.highcharts-credits {display: none !important;}.text-box {background-color: #fff;padding: 10px 10px;margin: 5px 5px 25px 5px;border-radius: 4px;}.text-headbox {background-color: #1296c0;}.bhead {background-color: #1296c0;padding: 8px;color: #fff;font-size: 20px;letter-spacing: 1.8px;font-weight: 600;}.btext {background-color: #d4eff7;padding: 17px;border-radius: 20px 0px 0px 0px;font-size: 25px;}#pareto_test_composed .x.axis text {text-anchor: end !important;transform: rotate(-60deg);}li.oneItem {display: inline-block;background-color: #188ae2;padding: 10px;color: #fff;border-radius: 7px;cursor: pointer;}li.oneItem.active {background-color: #195bbb;}#dateWiseData td, #evaluator td, #tlWise td, #agentWise td {text-align: center;}#select_process option{text-transform:capitalize;}.monthlyData{font-weight: bold;}.weeklyTrend td{text-align: center;padding: 10px !important;font-size: small !important;}.bucket_0{background-color: #d74418 !important;color: #fff;}.bucket_1{background-color: #ff4700 !important;color: #fff;}.bucket_2{background-color: #ff6a00 !important;color: #fff;}.bucket_3{background-color: #ffb100 !important;color: #fff;}.bucket_4{background-color: #20cb3d !important;color: #fff;}#weekly_trendChart{height: 300px;}.top_ribbon{background-color: #337ab7;color: #fff;}.top_ribbon .widget-title{color: #fff !important;}.table-freeze-header thead th, .table-freeze-header tbody td {font-size: small !important;word-break: break-word !important;}.table-freeze-header tbody td{padding: 8px !important;}.table-freeze-header tbody{display:block;max-height:300px;overflow:hidden auto;}.table-freeze-header thead, .table-freeze-header tbody tr {display:table;width:100%;table-layout:fixed;}
</style>
<div class="wrap">

   <nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="margin-bottom: 8px !important;background-color: #fff">
      <li class="breadcrumb-item">CQ Dashboard</li>
      <li class="breadcrumb-item active" aria-current="page"><a href="<?php base_url('Qa_one_view_dashboard/one_view_dashboard');?>">One View Dashboard</a></li>
    </ol>
  </nav>

   <section class="app-content">
      
      
      <div class="row">
         <div class="col-md-12">
            <div class="widget">
               <hr class="widget-separator" />
               <div class="widget-body clearfix">
                  <div class="row">
                     <div class="col-md-4">
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i>One View Dashboard</h4>
                     </div>
                  </div>
                  <hr />
                  <div class="row">
                     <div class="col-md-12">
                        <form method="GET" id="summaryForm" enctype="multipart/form-data">
                           <div class="row">

                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="select_client">Select Client</label>
                                    <select class="form-control" name="select_client" id="select_client" required>
                                       <?php foreach($client_list as $item){?>
                                       <option value="<?php echo $item['client_id']; ?>" <?php echo $item['client_id'] == $selected_client_id ? 'selected' : ''; ?>>
                                          <?php echo ucwords($item['client_name']); ?>
                                       </option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>

                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="select_process">Select Process</label>
                                    <select class="form-control" name="select_process" id="select_process" required disabled>
                                       <option value="" selected disabled>Select Process</option>
                                    </select>
                                 </div>
                              </div>

                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="select_campaign">Select Campaign</label>
                                    <select class="form-control" name="select_campaign[]" id="select_campaign" required multiple disabled>
                                    </select>
                                 </div>
                              </div>

                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="select_office">Select Location</label>
                                    <select class="form-control" name="select_office[]" id="select_office" multiple required>
                                       <option value="ALL" <?php echo in_array('ALL',$selected_location) ? 'selected' : ''; ?> <?php echo empty($selected_location) ? 'selected' : ''?>>ALL</option>
                                       <?php foreach($location_list as $locationa){ ?>
                                       <option value="<?php echo $locationa['abbr']; ?>" <?php echo in_array($locationa['abbr'],$selected_location) ? 'selected' : ''; ?>>
                                          <?php echo ucwords($locationa['office_name']); ?>
                                       </option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                              
                           </div>
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                     <label for="rep_type">Representation Type</label>
                                     <select id="rep_type" class="form-control" name="rep_type">
                                         <option value="daily" <?php echo $data_show_type == 'daily' ? 'selected' : ''?>>Date Wise</option>
                                         <option value="monthly" <?php echo $data_show_type == 'monthly'|| $data_show_type == '' ? 'selected' : ''?>>Month Wise</option>
                                         <option value="weekly" <?php echo $data_show_type == 'weekly' ? 'selected' : ''?>>Weekly Wise</option>
                                     </select>
                                 </div>
                              </div>
                              <div class="col-md-3 monthly-section">
                                  <div class="form-group">
                                      <label for="ssdate">Search Month</label>
                                      <select class="form-control" name="select_month[]" id="select_month" multiple>
                                          <?php for ($i = 1; $i <= 12; $i++) { 
                                             $selectmn = "";
                                             if(in_array($i,$selected_month)){ $selectmn = "selected"; }
                                             ?>
                                          <option value="<?php echo sprintf('%02d', $i); ?>"
                                              <?php echo $selectmn ?>>
                                              <?php echo date('F', strtotime('2019-' . sprintf('%02d', $i) . '-01')); ?>
                                          </option>
                                          <?php } ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-3 monthly-section">
                                  <div class="form-group">
                                      <label for="ssdate">Search Year</label>
                                      <select class="form-control" name="select_year" id="select_year">
                                          <?php
                                          $current_y = date('Y');
                                          $last_y = $current_y - 5;
                                          for ($j = $current_y; $j >= $last_y; $j--) { ?>
                                          <option value="<?php echo $j; ?>" <?php echo $selected_year == $j ? 'selected' : ''; ?>>
                                              <?php echo $j; ?>
                                          </option>
                                          <?php } ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-3 daily-section">
                                  <div class="form-group">
                                      <label for="select_from_date">Search From Date</label>
                                      <input type="text" name="select_from_date" id="select_from_date"
                                          value="<?php echo $select_from_date ?>" class="form-control" />
                                  </div>
                              </div>
                              <div class="col-md-3 daily-section">
                                  <div class="form-group">
                                      <label for="select_to_date">Search To Date</label>
                                      <input type="text" name="select_to_date" id="select_to_date"
                                          value="<?php echo $select_to_date ?>" class="form-control" />
                                  </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group" style="margin-top: 22px;">
                                       <button type="submit" class="btn btn-primary btn-md" id="search-btn" disabled>Search</button>
                                       <?php if(!empty($_SERVER['QUERY_STRING']) && !empty($month_wise_data)):?>
                                          <a class="btn btn-warning" href="<?php echo base_url('Qa_one_view_dashboard/one_view_dashboard?').$_SERVER['QUERY_STRING'].'&excel_report=true';?>" onclick="return false" id="export-btn" disabled>EXPORT REPORT</a>
                                       <?php endif;?>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="widget">
         <div class="widget-body">
            <div class="col-md-12">
               <h4 style="text-align: center;color: rgb(51, 51, 51);">Weekly Trend</h4>
               <hr>
            </div>
            <div class="row" style="margin-top:55px;">
               <div class="col-sm-6">
                  <div style="width: 100%;height: 100%;overflow-y: auto;max-height: 375px;">
                     <table class="weeklyTrend table table-striped skt-table" style="width: 100%;">
                        <thead>
                           <tr class="bg-info">
                              <th>WEEK</th>
                              <th>NO OF AUDIT</th>
                              <th>NO OF FATAL</th>
                              <th>QUALITY SCORE</th>
                           </tr>
                        </thead>
                        <tbody>
                          
                              <?php 
                              /*For graph*/
                              $graph_weekly_audit_count = array();
                              $graph_weekly_quality_score = array();
                              $graph_weekly_fatal_count = array();
                              $graph_week_name = array();
                              foreach($weekly_data as $week):

                                $avg_cq = !empty($week['total_audit']) ? number_format((float)($week['cq_score'] / $week['total_audit']), 2) : 0;
                                 array_push($graph_week_name,'Week-'.$week['week_number']);
                                 array_push($graph_weekly_audit_count,(float)$week['total_audit']);
                                 array_push($graph_weekly_fatal_count,(float)$week['weekly_fatal_count']);
                                 array_push($graph_weekly_quality_score,(float)$avg_cq);
                                 ?>
                                 <tr>
                                    <td><?php echo 'Week-'.$week['week_number'];?></td>
                                    <td><?php echo $week['total_audit'];?></td>
                                    <td><?php echo $week['weekly_fatal_count'];?></td>
                                    <td><?php echo $avg_cq;?> %</td>
                                 </tr>
                              <?php endforeach; ?>

                        </tbody>
                     </table>
                  </div>
               </div>
               
               <div class="col-sm-6">
                  <div id="weekly-trend-graph"></div>
               </div>
            </div>
            <div class="col-md-12">
               <h4 style="text-align: center;color: rgb(51, 51, 51);">Monthly Trend</h4>
               <hr>
            </div>
            <div class="row" style="margin-top:55px;">
               
               <div class="col-sm-6">
                  <div style="width: 100%;height: 100%;overflow-y: auto;max-height: 375px;">
                     <table class="weeklyTrend table table-striped skt-table" style="width: 100%;">
                        <thead>
                           <tr class="bg-info">
                              <th>MONTH</th>
                              <th>NO OF AUDIT</th>
                              <th>NO OF FATAL</th>
                              <th>QUALITY SCORE</th>
                           </tr>
                        </thead>
                        <tbody>
                           
                              <?php 
                              /*For graph*/
                              $graph_mnthly_audit_count = array();
                              $graph_mnthly_quality_score = array();
                              $graph_mnthly_fatal_count = array();
                              $graph_mnth_name = array();
                              foreach($month_wise_data as $item):

                                 array_push($graph_mnth_name,$item['audit_month']);
                                 array_push($graph_mnthly_audit_count,(float)$item['total_audit']);
                                 array_push($graph_mnthly_fatal_count,(float)$item['audit_fatal']);
                                 array_push($graph_mnthly_quality_score,(float)$item['cq_score']);
                                 ?>
                                 <tr>
                                    <td><?php echo $item['audit_month'];?></td>
                                    <td><?php echo $item['total_audit'];?></td>
                                    <td><?php echo $item['audit_fatal'];?></td>
                                    <td><?php echo $item['cq_score'];?> %</td>
                                 </tr>

                              <?php endforeach; ?>

                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div id="monthly-trend-graph"></div>
               </div>
            </div>
            
         </div>
      </div>

      <div class="widget">
         <div class="widget-body">
            <ul class="oneTabs">
               <li class="oneItem active" data-open-tab="dataWise">DATE WISE</li>
               <li class="oneItem" data-open-tab="locationWise">LOCATION WISE</li>
               <li class="oneItem" data-open-tab="evaluatorWise">EVALUATOR WISE</li>
               <li class="oneItem" data-open-tab="tlWise">TL WISE</li>
               <li class="oneItem" data-open-tab="agentWise">AGENT WISE</li>
            </ul>
            <div class="tabs" data-tab-name="dataWise">
               
               <div class="row">
                  <div class="col-md-12">
                     <div style="width:100%;height:400px; padding:10px;">
                        <div id="date-wise-chart"></div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <table id="dateWiseData" class="table-freeze-header table table-striped skt-table">
                        <thead>
                           <tr class="bg-info">
                              <th>Date</th>
                              <th>Audit Count</th>
                              <th>Quality Score</th>
                              <th>Fatal Count</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                                 /*For graph*/
                                 $date_wise_graph_xAxis = array();
                                 $date_wise_graph_audit_count = array();
                                 $date_wise_graph_quality_score = array();

                                 if(count($date_wise_audit_data) > 0){
                                    
                                    foreach($date_wise_audit_data as $item){

                                       array_push($date_wise_graph_xAxis,$item['audit_date']);
                                       array_push($date_wise_graph_audit_count,(float)$item['audit_count']);
                                       array_push($date_wise_graph_quality_score,(float)$item['cq_score']);
                           ?>
                                       <tr>
                                          <td><?php echo $item['audit_date'];?></td>
                                          <td><?php echo $item['audit_count'];?></td>
                                          <td><?php echo $item['cq_score'];?> %</td>
                                          <td><?php echo $item['audit_fatal'];?></td>
                                       </tr>
                                 <?php }
                                 }else{?>
                                    <tr>
                                       <td colspan="3">No Data Available</td>
                                    </tr>
                                 <?php }?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="tabs" data-tab-name="locationWise" style="display:none;">
               <div class="widget-head clearfix" style="background-color: #f1f2f3;padding: 10px;color: #a70000;">
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="table-responsive">
                        <table style="margin-top: 10px;" id="default-datatable-details" data-plugin="DataTable"
                           class="table-freeze-header table table-striped skt-table" cellspacing="0" width="100%">
                           <thead>
                              <tr class='bg-info'>
                                 <th>#</th>
                                 <th>Location</th>
                                 <th>No of Audit</th>
                                 <th>Fatal Count</th>
                                 <th>Quality Score</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $location_Counter = 1;
                              /*For graph*/
                              $location_wise_graph_xAxis = array();
                              $location_wise_graph_audit_count = array();
                              $location_wise_graph_quality_score = array();
                              foreach($location_wise_audit_data as $location){

                                 array_push($location_wise_graph_xAxis,$location['office_name']);
                                 array_push($location_wise_graph_audit_count,(float)$location['audit_count']);
                                 array_push($location_wise_graph_quality_score,(float)$location['cq_score']);
                              ?>
                              <tr>
                                 <td><?php echo $location_Counter++;?></td>
                                 <td style="width: 70px !important;"><?php echo $location['office_name'];?></td>
                                 <td><?php echo $location['audit_count'];?></td>
                                 <td><?php echo $location['fatal_count']?></td>
                                 <td><?php echo $location['cq_score'];?>%</td>
                              </tr>
                              <?php }?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div style="width:100%;height:400px; padding:10px;">
                        <div id="location-wise-chart"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="tabs" data-tab-name="evaluatorWise" style="display:none;">
               <div class="row">
                  <div class="col-md-12">
                     <div style="width:100%;height:400px; padding:10px;">
                        <div id="evaluator-wise-chart"></div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <table id="evaluator" class="table-freeze-header table table-striped skt-table">
                        <thead>
                           <tr class='bg-info'>
                              <th>SL. No.</th>
                              <th>Evaluator Name</th>
                              <th>Audit Count</th>
                              <th>Quality Score</th>
                              <th>Fatal Count</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                           /*For graph*/
                           $evaluator_wise_graph_xAxis = array();
                           $evaluator_wise_graph_audit_count = array();
                           $evaluator_wise_graph_quality_score = array();

                           if(count($evaluator_wise_audit_data) > 0){
                              $i =1;
                              foreach($evaluator_wise_audit_data as $item){

                                 array_push($evaluator_wise_graph_xAxis,$item['auditor_name']);
                                 array_push($evaluator_wise_graph_audit_count,(float)$item['audit_count']);
                                 array_push($evaluator_wise_graph_quality_score,(float)$item['cq_score']);
                              ?>
                           <tr>
                              <td><?php echo $i++;?></td>
                              <td><?php echo $item['auditor_name'];?></td>
                              <td><?php echo $item['audit_count'];?></td>
                              <td><?php echo $item['cq_score'];?>%</td>
                              <td><?php echo $item['audit_fatal'];?></td>
                           </tr>
                           <?php }
                           }else{?>
                           <tr>
                              <td colspan="4">No Data Found</td>
                           </tr>
                           <?php }?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="tabs" data-tab-name="tlWise" style="display:none;">
               
               <div class="row">
                  <div class="col-md-12">
                     <div style="width:100%;height:400px; padding:10px;">
                        <div id="tl-wise-chart"></div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <table id="tlWise" class="table-freeze-header table table-striped skt-table">
                        <thead>
                           <tr class='bg-info'>
                              <th>SL. No.</th>
                              <th>Supervisor Name</th>
                              <th>Audit Count</th>
                              <th>Quality Score</th>
                              <th>Fatal Count</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                           /*For graph*/
                           $tl_wise_graph_xAxis = array();
                           $tl_wise_graph_audit_count = array();
                           $tl_wise_graph_quality_score = array();

                           if(count($tl_wise_audit_data) > 0){
                              $i = 1;
                              foreach($tl_wise_audit_data as $item){ 

                                 array_push($tl_wise_graph_xAxis,$item['tl_name']);
                                 array_push($tl_wise_graph_audit_count,(float)$item['audit_count']);
                                 array_push($tl_wise_graph_quality_score,(float)$item['cq_score']);

                           ?>
                                    <tr>
                                       <td><?php echo $i++;?></td>
                                       <td><?php echo $item['tl_name'];?></td>
                                       <td><?php echo $item['audit_count'];?></td>
                                       <td><?php echo $item['cq_score'];?>%</td>
                                       <td><?php echo $item['audit_fatal'];?></td>
                                    </tr>
                           <?php }
                           }else{?>

                              <tr>
                                 <td colspan="3">No Data Found</td>
                              </tr>

                           <?php }?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="tabs" data-tab-name="agentWise" style="display:none;">
               
               <div class="row">
                  <div class="col-md-12">
                     <div style="width:100%;height:400px; padding:10px;">
                        <div id="agent-wise-chart"></div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <table id="agentWise" data-plugin="DataTable"
                        class="table-freeze-header table table-striped skt-table">
                        <thead>
                           <tr class='bg-info'>
                              <th>SL. No.</th>
                              <th>Agent Name</th>
                              <th>Audit Count</th>
                              <th>Quality Score</th>
                              <th>Fatal Count</th>
                              <th>Accepted</th>
                              <th>Rejected</th>
                              <th>Pending</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                           /*For graph*/
                           $agent_wise_graph_xAxis = array();
                           $agent_wise_graph_audit_count = array();
                           $agent_wise_graph_quality_score = array();
                           $agent_wise_graph_accepted = array();

                           if(count($agent_wise_audit_data) > 0){
                              $i = 1;
                              foreach($agent_wise_audit_data as $item){

                                 array_push($agent_wise_graph_xAxis,$item['agent_name']);
                                 array_push($agent_wise_graph_audit_count,(float)$item['audit_count']);
                                 array_push($agent_wise_graph_quality_score,(float)$item['cq_score']);
                                 array_push($agent_wise_graph_accepted,(float)$item['accepted']);
                           ?>
                                 <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $item['agent_name'];?></td>
                                    <td><?php echo $item['audit_count'];?></td>
                                    <td><?php echo $item['cq_score'];?>%</td>
                                    <td><?php echo $item['audit_fatal'];?></td>
                                    <td><?php echo $item['accepted'];?></td>
                                    <td><?php echo $item['rejected'];?></td>
                                    <td><?php echo $item['pending'];?></td>
                                 </tr>
                           <?php }

                           }else{?>
                           <tr>
                              <td colspan="3">No Data Found</td>
                           </tr>
                           <?php }?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            
         </div>
      </div>
      
   </section>
</div><!-- .wrap -->