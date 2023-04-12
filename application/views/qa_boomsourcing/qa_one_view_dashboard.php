<style>
.table>thead>tr>th, .table>thead>tr>td, .table>tbody>tr>th, .table>tbody>tr>td, .table>tfoot>tr>th, .table>tfoot>tr>td {vertical-align: middle;padding: 2px;font-size: 11px;}.table>thead>tr>th, .table>tfoot>tr>th {text-align: center;}.panel .table td, .panel .table th {font-size: 11px;padding: 6px;}.hide {disply: none;}.modal-dialog {width: 800px;}.modal {overflow: auto;}.rounded {-webkit-border-radius: 3px !important;-moz-border-radius: 3px !important;border-radius: 3px !important;}.mini-stat {padding: 5px;margin-bottom: 20px;}.mini-stat-icon {width: 30px;height: 30px;display: inline-block;line-height: 30px;text-align: center;font-size: 15px;background: none repeat scroll 0% 0% #EEE;border-radius: 100%;float: left;margin-right: 10px;color: #FFF;}.mini-stat-info {font-size: 12px;padding-top: 2px;}span, p {}.mini-stat-info span {display: block;font-size: 20px;font-weight: 600;margin-bottom: 5px;margin-top: 7px;}.bg-facebook {background-color: #3b5998 !important;border: 1px solid #3b5998;color: white;}.fg-facebook {color: #3b5998 !important;}.bg-twitter {background-color: #00a0d1 !important;border: 1px solid #00a0d1;color: white;}.fg-twitter {color: #00a0d1 !important;}.bg-googleplus {background-color: #db4a39 !important;border: 1px solid #db4a39;color: white;}.fg-googleplus {color: #db4a39 !important;}.bg-bitbucket {background-color: #205081 !important;border: 1px solid #205081;color: white;}.fg-bitbucket {color: #205081 !important;}.highcharts-credits {display: none !important;}.text-box {background-color: #fff;padding: 10px 10px;margin: 5px 5px 25px 5px;border-radius: 4px;}.text-headbox {background-color: #1296c0;}.bhead {background-color: #1296c0;padding: 8px;color: #fff;font-size: 20px;letter-spacing: 1.8px;font-weight: 600;}.btext {background-color: #d4eff7;padding: 17px;border-radius: 20px 0px 0px 0px;font-size: 25px;}#pareto_test_composed .x.axis text {text-anchor: end !important;transform: rotate(-60deg);}li.oneItem {display: inline-block;background-color: #188ae2;padding: 10px;color: #fff;border-radius: 7px;cursor: pointer;}li.oneItem.active {background-color: #195bbb;}#dateWiseData td, #evaluator td, #tlWise td, #agentWise td {text-align: center;}#select_process option{text-transform:capitalize;}.monthlyData{font-weight: bold;}.weeklyTrend td{text-align: center;padding: 10px !important;font-size: small !important;}.bucket_0{background-color: #d74418 !important;color: #fff;}.bucket_1{background-color: #ff4700 !important;color: #fff;}.bucket_2{background-color: #ff6a00 !important;color: #fff;}.bucket_3{background-color: #ffb100 !important;color: #fff;}.bucket_4{background-color: #20cb3d !important;color: #fff;}#weekly_trendChart{height: 300px;}.top_ribbon{background-color: #337ab7;color: #fff;}.top_ribbon .widget-title{color: #fff !important;}.table-freeze-header thead th, .table-freeze-header tbody td {font-size: small !important;word-break: break-word !important;}.table-freeze-header tbody td{padding: 8px !important;}.table-freeze-header tbody{display:block;max-height:300px;overflow:hidden auto;}.table-freeze-header thead, .table-freeze-header tbody tr {display:table;width:100%;table-layout:fixed;}
</style>

<div class="wrap">

   <nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="margin-bottom: 8px !important;background-color: #fff">
      <li class="breadcrumb-item">CQ Dashboard</li>
      <li class="breadcrumb-item active" aria-current="page"><a href="<?php base_url('Qa_boomsourcing_data_analytics/one_view_dashboard');?>">One View Dashboard</a></li>
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
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> All In One Dashboard</h4>
                     </div>
                  </div>
                  <hr />
                  <div class="row">
                     <div class="col-md-12">
                        <form method="GET" id="summaryForm" enctype="multipart/form-data">
                           <div class="row">

                              <div class="col-md-4">
                                    <div class="form-group" style="padding:2px 10px 2px 0px">
                                        <label for="select_process">Select Process</label>
                                        <select class="form-control" name="select_process" id="select_process" required>

                                        <?php foreach($process_list as $process): ?>

                                            <option value="<?php echo $process['process_id'] ?>" <?php echo $selected_process_id == $process['process_id'] ? 'selected' : '' ?>><?php echo $process['process_name'] ?></option>

                                            <?php endforeach; ?>                                
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vertical">Vertical</label>
                                        <select id="vertical" class="form-control" name="vertical">
                                            <option value="" selected disabled>Select Vertical</option>
                                            <?php foreach($vertical_list as $vertical):?>
                                                <option value="<?php echo $vertical['id'];?>" <?php echo $selected_vertical == $vertical['id'] ? 'selected' : '';?>><?php echo $vertical['vertical'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="campaign_process">Campaign/Process</label>
                                        <select id="campaign_process" class="form-control" name="campaign_process">
                                            <option value="" selected disabled>Select Campaign Process</option>
                                            <?php foreach($campaign_process_list as $campaign):?>
                                                <option value="<?php echo $campaign['id'];?>" <?php echo $selected_campaign_process == $campaign['id'] ? 'selected' : '';?>><?php echo $campaign['campaign'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                           </div>
                           <div class="row">
                               <div class="col-md-4">
                                 <div class="form-group" style="padding:2px 10px 2px 0px">
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
                              <div class="col-md-4">
                                    <div class="form-group" style="padding:2px 10px 2px 0px">
                                        <label for="find_by">Find By</label>
                                        <select id="find_by" class="form-control" name="find_by">
                                            <option value="" selected disabled>Select</option>
                                            <option value="QA" <?php echo $selected_find_by == 'QA' ? 'selected' : '';?>>QA</option>
                                            <option value="L1" <?php echo $selected_find_by == 'L1' ? 'selected' : '';?>>L1 Super</option>
                                            <option value="Agent" <?php echo $selected_find_by == 'Agent' ? 'selected' : '';?>>Agent</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3"  style="display:<?php echo $selected_find_by == 'QA' ? 'block;' : 'none';?>;" id="find-by-qa">
                                    <div class="form-group" style="padding:2px 10px 2px 0px">
                                        <label for="select_qa">QA Name</label>
                                        <select id="select_qa" class="form-control" name="select_qa">
                                            <option value="" selected disabled>Select QA</option>
                                            <?php foreach($qa_list as $qa):?>
                                            <option value="<?php echo $qa['qa_id']?>" <?php echo $qa['qa_id'] == $selected_qa ? 'selected' : ''; ?>><?php echo $qa['qa_name']?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3"  style="display:<?php echo $selected_find_by == 'L1' ? 'block;' : 'none';?>;" id="find-by-l1">
                                    <div class="form-group" style="padding:2px 10px 2px 0px">
                                        <label for="select_l1">L1 Name</label>
                                        <select id="select_l1" class="form-control" name="select_l1">
                                            <option value="" selected disabled>Select L1</option>
                                            <?php foreach($l1_list as $l1):?>
                                            <option value="<?php echo $l1['l1_id']?>" <?php echo $l1['l1_id'] == $selected_l1 ? 'selected' : ''; ?>><?php echo $l1['l1_name']?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3"  style="display:<?php echo $selected_find_by == 'Agent' ? 'block;' : 'none';?>;" id="find-by-agent">
                                    <div class="form-group" style="padding:2px 10px 2px 0px">
                                        <label for="select_agent">Agent Name</label>
                                        <select id="select_agent" class="form-control" name="select_agent">
                                            <option value="" selected disabled>Select Agent</option>
                                            <?php foreach($agent_list as $agent):?>
                                            <option value="<?php echo $agent['agent_id']?>" <?php echo $agent['agent_id'] == $selected_agent ? 'selected' : ''; ?>><?php echo $agent['agent_name']?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                           </div>
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group" style="padding:2px 10px 2px 0px">
                                     <label for="rep_type">Representation Type</label>
                                     <select id="rep_type" class="form-control" name="rep_type">
                                         <option value="daily" <?php echo $data_show_type == 'daily' ? 'selected' : ''?>>Date Wise</option>
                                         <option value="monthly" <?php echo $data_show_type == 'monthly'|| $data_show_type == '' ? 'selected' : ''?>>Month Wise</option>
                                         <option value="weekly" <?php echo $data_show_type == 'weekly' ? 'selected' : ''?>>Weekly Wise</option>
                                     </select>
                                 </div>
                              </div>
                              <div class="col-md-3 monthly-section">
                                  <div class="form-group" style="padding:2px 10px 2px 0px">
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
                                  <div class="form-group" style="padding:2px 10px 2px 0px">
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
                                  <div class="form-group" style="padding:2px 10px 2px 0px">
                                      <label for="select_from_date">Search From Date</label>
                                      <input type="text" name="select_from_date" id="select_from_date"
                                          value="<?php echo $select_from_date ?>" class="form-control" />
                                  </div>
                              </div>
                              <div class="col-md-3 daily-section">
                                  <div class="form-group" style="padding:2px 10px 2px 0px">
                                      <label for="select_to_date">Search To Date</label>
                                      <input type="text" name="select_to_date" id="select_to_date"
                                          value="<?php echo $select_to_date ?>" class="form-control" />
                                  </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group" style="margin-top: 22px;">
                                    <input type="submit" class="btn btn-primary btn-md" name='submitgraph'
                                       value="Search" />
                                       <?php if(!empty($_SERVER['QUERY_STRING'])):?>
                                          <a class="btn btn-warning" href="<?php echo base_url('Qa_boomsourcing_data_analytics/one_view_dashboard?').$_SERVER['QUERY_STRING'].'&excel_report=true';?>">EXPORT REPORT</a>
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
                                 array_push($graph_week_name,$week['week_name']);
                                 array_push($graph_weekly_audit_count,(float)$week['total_audit']);
                                 array_push($graph_weekly_fatal_count,(float)$week['weekly_fatal_count']);
                                 array_push($graph_weekly_quality_score,(float)$avg_cq);
                                 ?>
                                 <tr>
                                    <td><?php echo $week['week_name'];?></td>
                                    <td><?php echo $week['total_audit'];?></td>
                                    <td><?php echo !empty($week['weekly_fatal_count']) ? $week['weekly_fatal_count'] : 0;?></td>
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
                              foreach($total_month_wise_data as $mnth):

                                $avg_cq_m = !empty($mnth['total_audit']) ? number_format((float)($mnth['total_cq_score'] / $mnth['total_audit']), 2) : 0;
                                $dateObj   = DateTime::createFromFormat('!m', $mnth['audit_month']);
                                $mnth_name = $dateObj->format('F');
                                 array_push($graph_mnth_name,$mnth_name);
                                 array_push($graph_mnthly_audit_count,(float)$mnth['total_audit']);
                                 array_push($graph_mnthly_fatal_count,(float)$mnth['audit_fatal']);
                                 array_push($graph_mnthly_quality_score,(float)$avg_cq_m);
                                 ?>
                                 <tr>
                                    <td><?php echo $mnth_name;?></td>
                                    <td><?php echo $mnth['total_audit'];?></td>
                                    <td><?php echo $mnth['audit_fatal'];?></td>
                                    <td><?php echo $avg_cq_m;?> %</td>
                                 </tr>

                              <?php endforeach; ?>

                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div id="mnthly-trend-graph"></div>
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
                                       array_push($date_wise_graph_quality_score,(float)number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2));
                           ?>
                                       <tr>
                                          <td><?php echo $item['audit_date'];?></td>
                                          <td><?php echo $item['audit_count'];?></td>
                                          <td><?php echo number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2)?> %</td>
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
                                 array_push($location_wise_graph_quality_score,(float)number_format((float)($location['cq_score_sum'] / $location['audit_count']), 2));
                              ?>
                              <tr>
                                 <td><?php echo $location_Counter++;?></td>
                                 <td style="width: 70px !important;"><?php echo $location['office_name'];?></td>
                                 <td><?php echo $location['audit_count'];?></td>
                                 <td><?php echo $location['fatal_count']?></td>
                                 <td><?php echo number_format((float)($location['cq_score_sum'] / $location['audit_count']) , 2);?>%</td>
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
                                 array_push($evaluator_wise_graph_quality_score,(float)number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2));
                              ?>
                           <tr>
                              <td><?php echo $i++;?></td>
                              <td><?php echo $item['auditor_name']?></td>
                              <td><?php echo $item['audit_count']?></td>
                              <td><?php echo number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2)?>%</td>
                              <td><?php echo $item['audit_fatal']?></td>
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
                                 array_push($tl_wise_graph_quality_score,(float)number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2));

                           ?>
                                    <tr>
                                       <td><?php echo $i++;?></td>
                                       <td><?php echo $item['tl_name']?></td>
                                       <td><?php echo $item['audit_count']?></td>
                                       <td><?php echo number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2)?>%</td>
                                       <td><?php echo $item['audit_fatal']?></td>
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
                                 array_push($agent_wise_graph_quality_score,(float)number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2));
                                 array_push($agent_wise_graph_accepted,(float)$item['accepted']);
                           ?>
                                 <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $item['agent_name']?></td>
                                    <td><?php echo $item['audit_count']?></td>
                                    <td><?php echo number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2)?>%</td>
                                    <td><?php echo $item['audit_fatal'];?></td>
                                    <td><?php echo $item['accepted'];?></td>
                                    <td><?php echo $reject_count =  $item['rejected'];?></td>
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

      <div class="widget">
         <hr class="widget-separator" />
         <div class="widget-head clearfix" style="background-color: #f1f2f3;padding: 10px;color: #a70000;">
            <div class="row">
               <div class="col-md-4">
                  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Parameter Wise Score</h4>
               </div>
            </div>
         </div>
         <div class="widget-body clearfix">
            <?php 

            $parameter_wise_graph = array();
            $pcount = 1;
            foreach($all_defect_table_overall_params as $defect_table_key => $defect_table):?>
               <h4><?php echo strtoupper(str_replace('qa_', '', str_replace('_feedback', '', $defect_table_key)));?></h4>
            <div class="row">
               <div class="col-md-6">
                  <div class="table-responsive">
                     <table style="margin-top: 10px;" id="default-datatable-details" data-plugin="DataTable"
                        class="table table-striped skt-table" cellspacing="0" width="100%">
                        <thead>
                           <tr class='bg-info'>
                              <th>#</th>
                              <th>Overall Parameters</th>
                              <th>Yes</th>
                              <th>No</th>
                              <th>NA</th>
                              <th>Grand Total</th>
                              <th>Score%</th>
                              <th>Error Count%</th>
                           </tr>
                        </thead>
                        <tbody><?php
                           $cn = 1;
                           $params = array_keys($all_defect_table_overall_params[$defect_table_key]);

                           $total_no_count = 0;
                           foreach($params as $key => $param){

                              $grand_total = $defect_table[$param]['Yes'] + $defect_table[$param]['No'] + $defect_table[$param]['NA'];

                              if($grand_total!=0 || $defect_table[$param]['Yes']!=0){
                              $score = ($defect_table[$param]['Yes'] / $grand_total) * 100;
                              }else{
                                 $score = 0;
                              }
                              if($grand_total!=0 || $defect_table[$param]['No']!=0){
                              $error_count = ($defect_table[$param]['No'] / $grand_total) * 100;
                              }else{
                                 $error_count = 0;
                              }
                           ?>
                           <tr>
                              <td class="text-center"><?php echo $key + 1; ?></td>
                              <td class="" style="padding-left:5px"><b><?php echo ucwords(str_replace('_',' ',$param)); ?><b></td>
                              <td class="text-center"><?php echo $defect_table[$param]['Yes']; ?></td>
                              <td class="text-center"><?php echo $defect_table[$param]['No']; ?></td>
                              <td class="text-center"><?php echo $defect_table[$param]['NA']; ?></td>
                              <td class="text-center">
                                 <?php echo $grand_total; ?>
                              </td>
                              <td class="text-center"><b><?php echo is_nan($score) ? 0 : sprintf('%.2f',$score); ?>%<b>
                              </td>
                              <td class="text-center"><b><?php echo is_nan($error_count) ? 0 : sprintf('%.2f',$error_count); ?>%<b></td>
                           </tr>
                           <?php 
                              $total_no_count += $defect_table[$param]['No'];
                           } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="table-responsive">
                     <table style="margin-top: 10px;" id="default-datatable-details" data-plugin="DataTable"
                        class="table table-striped skt-table" cellspacing="0" width="100%">
                        <thead>
                           <tr class='bg-info'>
                              <th>#</th>
                              <th>Overall Parameters</th>
                              <th>No</th>
                              <th>Error Count%</th>
                              <th>CF%</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                              $cn = 1; 
                              $totalpercent = 0;
                              /*For graph*/
                              $parameter_wise_graph_xAxis = array();
                              $parameter_wise_graph_audit_count = array();
                              $parameter_wise_graph_quality_score = array();
                              
                              foreach($params as $key => $param){

                                 $errorpercent = 0;
                                 if($total_no_count!=0 || $defect_table[$param]['No']!=0){
                                 $errorpercent = ( $defect_table[$param]['No'] / $total_no_count) * 100;
                                 }else{
                                    $errorpercent = 0;
                                 }
                                 $totalpercent = $totalpercent + $errorpercent;

                                 array_push($parameter_wise_graph_xAxis,$param);
                                 array_push($parameter_wise_graph_audit_count,(float) !is_nan($errorpercent) ? $errorpercent : 0);
                                 array_push($parameter_wise_graph_quality_score,(float)number_format((float)!is_nan($totalpercent) ? $totalpercent : 0, 2));
                           ?>
                           <tr>
                              <td class="text-center"><?php echo $cn++; ?></td>
                              <td class="" style="padding-left:5px"><b><?php echo ucwords(str_replace('_',' ',$param)); ?><b></td>
                              <td class="text-center"><?php echo $defect_table[$param]['No']; ?></td>
                              <td class="text-center"><?php echo !is_nan($errorpercent) ? sprintf('%.2f', $errorpercent) : 0; ?>%</td>
                              <td class="text-center"><b><?php echo !is_nan($totalpercent) ? sprintf('%.2f', $totalpercent) : 0; ?>%<b></td>
                           </tr>
                           <?php }

                              $parameter_wise_graph = array_merge($parameter_wise_graph,array($defect_table_key => array("parameter_wise_graph_xAxis" => $parameter_wise_graph_xAxis,"parameter_wise_graph_audit_count" => $parameter_wise_graph_audit_count,"parameter_wise_graph_quality_score" => $parameter_wise_graph_quality_score)));
                              
                           ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="col-md-12">
                  <div style="width:100%;height:400px; padding:10px;">
                     <div id="parameter-wise-chart-<?php echo $pcount++; ?>"></div>
                  </div>
               </div>
            </div>
            <?php endforeach;?>
         </div>
      </div>
   </section>
</div><!-- .wrap -->