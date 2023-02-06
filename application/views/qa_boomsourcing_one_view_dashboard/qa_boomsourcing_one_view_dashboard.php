<style>
.table>thead>tr>th,
.table>thead>tr>td,
.table>tbody>tr>th,
.table>tbody>tr>td,
.table>tfoot>tr>th,
.table>tfoot>tr>td {
   vertical-align: middle;
   padding: 2px;
   font-size: 11px;
}

.table>thead>tr>th,
.table>tfoot>tr>th {
   text-align: center;
}

.panel .table td,
.panel .table th {
   font-size: 11px;
   padding: 6px;
}

.hide {
   disply: none;
}

.modal-dialog {
   width: 800px;
}

.modal {
   overflow: auto;
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

span,
p {
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

.text-box {
   background-color: #fff;
   padding: 10px 10px;
   margin: 5px 5px 25px 5px;
   border-radius: 4px;
}

.text-headbox {
   background-color: #1296c0;
}

.bhead {
   background-color: #1296c0;
   padding: 8px;
   color: #fff;
   font-size: 20px;
   letter-spacing: 1.8px;
   font-weight: 600;
}

.btext {
   background-color: #d4eff7;
   padding: 17px;
   border-radius: 20px 0px 0px 0px;
   font-size: 25px;
}

#pareto_test_composed .x.axis text {
   text-anchor: end !important;
   transform: rotate(-60deg);
}

/* Edited By Samrat 27-May-22 */
li.oneItem {
   display: inline-block;
   background-color: #188ae2;
   padding: 10px;
   color: #fff;
   border-radius: 7px;
   cursor: pointer;
}

li.oneItem.active {
   background-color: #195bbb;
}

#dateWiseData td,
#evaluator td,
#tlWise td,
#agentWise td {
   text-align: center;
}

#select_process option{
	text-transform:capitalize;
}

/* Edited By Samrat 13-Jun-22 */
.monthlyData{
   font-weight: bold;
}
.weeklyTrend td{
   text-align: center;
   padding: 10px !important;
   font-size: small !important;
}
.bucket_0{
   background-color: #d74418 !important;
   color: #fff;
}
.bucket_1{
   background-color: #ff4700 !important;
   color: #fff;
}
.bucket_2{
   background-color: #ff6a00 !important;
   color: #fff;
}
.bucket_3{
   background-color: #ffb100 !important;
   color: #fff;
}
.bucket_4{
   background-color: #20cb3d !important;
   color: #fff;
}
#weekly_trendChart{
   height: 300px;
}
.top_ribbon{
   background-color: #337ab7;
   color: #fff;
}
.top_ribbon .widget-title{
   color: #fff !important;
}
/* Edited By Samrat 16-Jun-22 */
/* Freeze Table Header */
.table-freeze-header thead th,
.table-freeze-header tbody td {
    font-size: small !important;
	word-break: break-word !important;
}
.table-freeze-header tbody td{
	padding: 8px !important;
}
.table-freeze-header tbody{
	display:block;
    max-height:300px;
    overflow:hidden auto;
}
.table-freeze-header thead, .table-freeze-header tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;
}
</style>
<!-- Metrix -->
<div class="wrap">
   <section class="app-content">
      <div class="row">
         <div class="col-md-12">
            <div class="widget">
               <hr class="widget-separator" />
               <div class="widget-body clearfix">
                  <div class="row">
                     <div class="col-md-4">
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> One View Dashboard</h4>
                     </div>
                  </div>
                  <hr />
                  <div class="row">
                     <div class="col-md-12">
                        <form method="GET" id="summaryForm" enctype="multipart/form-data">
                           <div class="row">
                              <div class="col-md-2">
                                 <div class="form-group" style="padding:2px 10px 2px 0px">
                                    <label for="ssdate">Select Office</label>
                                    <select class="form-control" name="select_office[]" id="select_office" multiple>
                                       <?php
													$selectin = "";
													if(in_array('ALL', $selected_office)){ $selectin = "selected"; }?>
                                        <option value="ALL" <?php echo $selectin; ?>>ALL</option> 
                                       <?php foreach($location_list as $token){
														$selectin = "";
														if(in_array($token['abbr'],$selected_office)){ $selectin = "selected"; }?>
                                       <option value="<?php echo $token['abbr']; ?>" <?php echo $selectin; ?>>
                                          <?php echo $token['office_name']; ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                             <!--  <div class="col-md-2">
                                 <div class="form-group" style="padding:2px 10px 2px 0px">
                                    <label for="ssdate">Search Client</label>
                                    <select class="form-control" name="select_client" id="select_client" required>
                                       <option value="">-- Select Client --</option>
                                       <?php foreach($client_list as $token){
														$selectin = "";
														if($selected_client == $token['id']){ $selectin = "selected"; } ?>
                                       <option value="<?php echo $token['id']; ?>" <?php echo $selectin; ?>>
                                          <?php echo $token['shname']; ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div> -->
                              <div class="col-md-2">
                                 <div class="form-group" style="padding:2px 10px 2px 0px">
                                    <label for="ssdate">Select Process</label>
                                    <select class="form-control" name="select_process" id="select_process" required>
                                       <option value="">-- Select Process --</option>
                                       <?php $sn=0; foreach($process_list as $token){ $sn++;
													$selectiny = "";
													if($selected_process == $token['process_id']){ $selectiny = "selected"; }?>
                                       <option value="<?php echo $token['process_id']; ?>" <?php echo $selectiny; ?>>
                                          <?php echo ucwords(str_replace('_', ' ', str_replace('_feedback', '', str_replace('qa_', '', $token['table_name'])))); ?>
                                       </option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                              <!-- <div class="col-md-2">
                                 <div class="form-group" style="padding:2px 10px 2px 0px">
                                    <label for="ssdate">Select LOB</label>
                                    <select class="form-control" name="select_lob" id="select_lob" required>
                                       <option value="">-- Select LOB --</option>
                                       <option value="">ALL</option>
                                       <?php $sn=0; foreach($campaign_list as $token){ $sn++;
													$selectiny = "";
													if($selected_campaign == $token['id']){ $selectiny = "selected"; }?>
                                       <option value="<?php echo $token['id']; ?>" <?php echo $selectiny; ?>>
                                          <?php echo $token['campaign']; ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div> -->
                              <div class="col-md-2">
                                 <div class="form-group" style="padding:2px 10px 2px 0px">
                                    <label for="ssdate">Search Month</label>
                                    <select class="form-control" name="select_month" id="select_month">
                                       <?php for($i=1;$i<=12;$i++){$selectin = "";
													if($selected_month == $i){ $selectin = "selected"; }?>
                                       <option value="<?php echo sprintf('%02d', $i); ?>" <?php echo $selectin; ?>>
                                          <?php echo date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01')); ?>
                                       </option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group" style="padding:2px 10px 2px 0px">
                                    <label for="ssdate">Search Year</label>
                                    <select class="form-control" name="select_year" id="select_year">
                                       <?php
													$current_y = date('Y');
													$last_y = $current_y - 5;
													for($j=$current_y;$j>=$last_y;$j--){
														$selectiny = "";
														if($selected_year == $j){ $selectiny = "selected"; }?>
                                       <option value="<?php echo $j; ?>" <?php echo $selectiny; ?>><?php echo $j; ?>
                                       </option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-md" name='submitgraph'
                                       value="Search" />
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
      <!-- <div class="widget">
         <div class="widget-body top_ribbon">
            <div class="row">
               
               <?php
               $soft_skill_score = $sale_skill_score = $compliance_score = $cq_score = 0.00;
               if(!empty($skill_score)){
                  $soft_skill_score = number_format((float)($skill_score['total_soft_skill_score']/($skill_score['total_audit_ex']*25))*100, 2);
                  $sale_skill_score = number_format((float)($skill_score['total_sales_skill_score']/($skill_score['total_audit_ex']*75))*100, 2);
                  $compliance_score = number_format((float)(($skill_score['total_audit_ex']-$skill_score['fatal_audit'])/$skill_score['total_audit_ex'])*100, 2);
                  $cq_score = number_format((float)($skill_score['cq_score']/($skill_score['total_audit_ex']*100))*100, 2);
               }
               ?>
               <div class="col-xs-6 col-sm-6 col-md-3">
                  <div class="row">
                     <div class="col-xs-6 col-sm-6 text-center">
                        <i class="fa fa-bar-chart fa-4x"></i>
                     </div>
                     <div class="col-xs-6 col-sm-6">
                        <h4 class="widget-title">CQ SCORE</h4>
                        <div class="widget-title">
                           <span class="skill_score" data-score="<?php echo (!is_numeric($cq_score))?"0.00":$cq_score?>">0.00%</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xs-6 col-sm-6 col-md-3">
                  <div class="row">
                     <div class="col-xs-6 col-sm-6 text-center">
                        <i class="fa fa-bar-chart fa-4x"></i>
                     </div>
                     <div class="col-xs-6 col-sm-6">
                        <h4 class="widget-title">SOFT SKILL SCORE</h4>
                        <div class="widget-title">
                           <span class="skill_score" data-score="<?php echo (!is_numeric($soft_skill_score))?"0.00":$soft_skill_score?>">0.00%</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xs-6 col-sm-6 col-md-3">
                  <div class="row">
                     <div class="col-xs-6 col-sm-6 text-center">
                        <i class="fa fa-bar-chart fa-4x"></i>
                     </div>
                     <div class="col-xs-6 col-sm-6">
                        <h4 class="widget-title">SALES SKILL SCORE</h4>
                        <div class="widget-title">
                           <span class="skill_score" data-score="<?php echo (!is_numeric($sale_skill_score))?"0.00":$sale_skill_score?>">0.00%</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xs-6 col-sm-6 col-md-3">
                  <div class="row">
                     <div class="col-xs-6 col-sm-6 text-center">
                        <i class="fa fa-bar-chart fa-4x"></i>
                     </div>
                     <div class="col-xs-6 col-sm-6">
                        <h4 class="widget-title">COMPLIANCE SCORE</h4>
                        <div class="widget-title">
                           <span class="skill_score" data-score="<?php echo (!is_numeric($compliance_score))?"0.00":$compliance_score?>">0.00%</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div> -->
      <div class="widget">
         <div class="widget-body">
            <div class="row">
               <div class="col-sm-3">
                  <table class="weeklyTrend table table-striped skt-table" style="width: 100%;">
                     <thead>
                        <tr>
                           <th></th>
                           <th>NO OF AUDIT</th>
                           <th>TOTAL DEFECTS</th>
                           <th>FATAL DEFECTS</th>
                           <th>Quality SCORE</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        if(isset($weekly) && $weekly['total_defect']['no_of_weeks'] > 0){
                           $monthlyData = $weekly['total_defect']['monthlyData'];
                           foreach($monthlyData as $monthly){?>
                           <tr>
                              <td class="monthlyData"><?php echo $weekly['month_name']?></td>
                              <td class="monthlyData"><?php echo $monthly['totalAudit']?></td>
                              <td class="monthlyData"><?php echo $monthly['total_defect']?></td>
                              <td class="monthlyData">
                                 <?php if($monthly['total_fatal'] != 0){?>
                                    <?php echo $monthly['total_fatal']." - ".(number_format((float)($monthly['total_fatal']/$monthly['total_defect'])*100, 2))."%"?>
                                 <?php }else{
                                    echo "-";
                                 }?>
                              </td>
                              <td class="monthlyData"><?php echo number_format((float)($monthly['cq_score']/$monthly['monthlyData']['total_audit_ex']), 2)?>%</td>
                           </tr>
                           <?php }
                           $weeklyData = $weekly['total_defect']['weeklyData'];
                           $weekCounter = 1;
                           foreach($weeklyData as $week){?>
                           <tr>
                              <td><?php echo ("wk-".$week['week']."-".date("y"))?></td>
                              <td><?php echo $week['weeklyAuditCount']['weeklyCount']?></td>
                              <td><?php echo $week["week_$weekCounter"]?></td>
                              <td><?php if($week["fatalCount_$weekCounter"] != 0){
                                 echo $week["fatalCount_$weekCounter"]." - ".(number_format((float)($week["fatalCount_$weekCounter"]/$week["week_$weekCounter"])*100, 2))."%";
                              }else{
                                 echo "-";
                              }?></td>
                              <td><?php echo number_format((float)$week['cq_score'], 2)?>%</td>
                           </tr>
                           <?php ++$weekCounter;}
                        }
                        ?>
                     </tbody>
                  </table>
               </div>
               <div class="col-sm-6">
                  <canvas id="weekly_trendChart"></canvas>
               </div>
               <div class="col-sm-3">
                  <table class="weeklyTrend table table-striped skt-table" style="width: 100%;">
                     <thead>
                        <tr>
                           <th>QUALITY BUCKET</th>
                           <th>AGENT COUNT</th>
                           <th>CONTRIBUTION</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $bucketType = array("<30%", "30% to 60%", "60% to 80%", "80% to 90%", ">90%");
                        $bucketCounter = 0;
                        if(isset($weekly)){
                           $qualityData = $weekly['quality'];
                           $totalAgents = $qualityData[0]['monthlyAgentData']['total_agents'];
                           foreach($qualityData['bucketCount'] as $bucket){?>
                           <tr class="bucket_<?php echo $bucketCounter?>">
                              <td><?php echo $bucketType[$bucketCounter]?></td>
                              <td><?php echo $bucket?></td>
                              <td>
                                 <?php if($totalAgents != 0){
                                    echo (is_numeric(($bucket/$totalAgents)*100))?(number_format((float)(($bucket/$totalAgents)*100), 2))."%":"-";
                                 }else{
                                    echo "-";
                                 }?>
                              </td>
                           </tr>
                           <?php ++$bucketCounter;}
                        }else{
                           foreach($bucketType as $bucket){?>
                           <tr class="bucket_<?php echo $bucketCounter?>">
                              <td><?php echo $bucketType[$bucketCounter]?></td>
                              <td>-</td>
                              <td>-</td>
                           </tr>
                           <?php ++$bucketCounter;}
                        }?>
                     </tbody>
                  </table>
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
               <li class="oneItem" data-open-tab="verticalWise">VERTICAL WISE</li>
               <li class="oneItem" data-open-tab="channelWise">CHANNEL WISE</li>
               <li class="oneItem" data-open-tab="tenurityWise">Tenurity WISE</li>
            </ul>
            <div class="tabs" data-tab-name="dataWise">
					<div class="widget-head clearfix" style="background-color: #f1f2f3;padding: 10px;color: #a70000;">
                  <div class="row">
                     <div class="col-md-4">
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i>Date Wise Audit</h4>
                     </div>
                     <div class="col-md-8 text-right">
                        <button class="btn btn-primary" onclick="window.open('<?php echo base_url('qa_one_view_dashboard/download_dateWiseReport')?>')">
                           <i class="fa fa-download"></i>&nbsp;Download Report
                        </button>
                     </div>
                  </div>
               </div>
               <div class="row">
						<div class="col-md-6">
							<table id="dateWiseData" class="table-freeze-header table table-striped skt-table">
								<thead>
									<tr>
										<th>Date</th>
										<th>Audit Count</th>
										<th>Quality Score</th>
									</tr>
								</thead>
								<tbody>
									<?php if(isset($date_wise) && count($date_wise) > 0){
										foreach($date_wise as $item){?>
									<tr>
										<td><?php echo $item['audit_date']?></td>
										<td><?php echo $item['audit_count']?></td>
										<td><?php echo number_format((float)$item['average_score'], 2)?>%</td>
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
						<div class="col-md-6">
							<div style="width:100%;height:400px; padding:10px;">
                        <canvas id="dateWiseScoreChart"></canvas>
                     </div>
						</div>
					</div>
            </div>
            <div class="tabs" data-tab-name="locationWise" style="display:none;">
               <div class="widget-head clearfix" style="background-color: #f1f2f3;padding: 10px;color: #a70000;">
                  <div class="row">
                     <div class="col-md-4">
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Location Wise Audit</h4>
                     </div>
                     <div class="col-md-8 text-right">
                        <button class="btn btn-primary" onclick="window.open('<?php echo base_url('qa_one_view_dashboard/download_locationWiseReport')?>')">
                           <i class="fa fa-download"></i>&nbsp;Download Report
                        </button>
                     </div>
                  </div>
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
                                 <th>Total Parameters</th>
                                 <th>Total Defects</th>
                                 <th>Total Defects %</th>
                                 <th>Fatal Count</th>
                                 <th>Quality Score</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php //echo "<pre>";print_r($location_Data['defect_count']);echo "</pre>";
                              $location_Counter = 1;
                              $total_defect_counts = array();
                              $total_fatal_counts = array();
                              foreach($location_Data['generic'] as $location){
                                 $total_defect_counts[$location['office_name']] = 0;
                                 $total_fatal_counts[$location['office_name']] = 0;
                              }
                              foreach($location_Data['defect_count'] as $defect){
                                 for($i = 0; $i < count($defect); $i++){
                                    $total_defect_counts[$defect[$i]['office_name']] += $defect[$i]['defect_count'];
                                 }
                              }
                              foreach($location_Data['fatal_count'] as $fatal)
                                 $total_fatal_counts[$fatal['office_name']] += $fatal['fatal_count'];
                              foreach($location_Data['generic'] as $location){?>
                              <tr>
                                 <td><?php echo $location_Counter;?></td>
                                 <td><?php echo $location['office_name']?></td>
                                 <td><?php echo $location['total_audit_count']?></td>
                                 <td><?php echo count($cq['parameterArray'])*$location['total_audit_count']?></td>
                                 <td><?php echo $total_defect_counts[$location['office_name']]?></td>
                                 <td>
                                    <?php echo number_format((float)($total_defect_counts[$location['office_name']]/($location['total_audit_count']*$location_Data['total_parameters']))*100, 2);?>
                                 </td>
                                 <td><?php echo $total_fatal_counts[$location['office_name']]?></td>
                                 <td><?php echo $location['cq_score']?>%</td>
                              </tr>
                              <?php ++$location_Counter;}?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div style="width:100%;height:400px; padding:10px;">
                        <canvas id="scorechart"></canvas>
                     </div>
                  </div>
               </div>
            </div>
            <div class="tabs" data-tab-name="evaluatorWise" style="display:none;">
					<div class="widget-head clearfix" style="background-color: #f1f2f3;padding: 10px;color: #a70000;">
                  <div class="row">
                     <div class="col-md-4">
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i>Evaluator Wise Audit</h4>
                     </div>
                     <div class="col-md-8 text-right">
                        <button class="btn btn-primary" onclick="window.open('<?php echo base_url('qa_one_view_dashboard/download_EvalWiseReport')?>')">
                           <i class="fa fa-download"></i>&nbsp;Download Report
                        </button>
                     </div>
                  </div>
               </div>
					<div class="row">
						<div class="col-md-6">
							<table id="evaluator" class="table-freeze-header table table-striped skt-table">
								<thead>
									<tr>
										<th>Evaluator Name</th>
										<th>MTD Audit Count</th>
                              <th>FTD Audit Count</th>
										<th>Quality Score</th>
									</tr>
								</thead>
								<tbody>
									<?php if(count($evaluator_wise) > 0){
										foreach($evaluator_wise as $item){?>
									<tr>
										<td><?php echo $item['auditor_name']?></td>
										<td><?php echo $item['audit_count']?></td>
                              <td><?php echo $item['ftd_count']?></td>
										<td><?php echo number_format((float)$item['average_score'], 2)?>%</td>
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
						<div class="col-md-6">
							<div style="width:100%;height:400px; padding:10px;">
                        <canvas id="auditorWiseScoreChart"></canvas>
                     </div>
						</div>
					</div>
            </div>
            <div class="tabs" data-tab-name="tlWise" style="display:none;">
					<div class="widget-head clearfix" style="background-color: #f1f2f3;padding: 10px;color: #a70000;">
                  <div class="row">
                     <div class="col-md-4">
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i>TL Wise Audit</h4>
                     </div>
                     <div class="col-md-8 text-right">
                        <button class="btn btn-primary" onclick="window.open('<?php echo base_url('qa_one_view_dashboard/download_TLWiseReport')?>')">
                           <i class="fa fa-download"></i>&nbsp;Download Report
                        </button>
                     </div>
                  </div>
               </div>
					<div class="row">
						<div class="col-md-6">
							<table id="tlWise" class="table-freeze-header table table-striped skt-table">
								<thead>
									<tr>
										<th>TL Name</th>
										<th>MTD Audit Count</th>
										<th>Quality Score</th>
									</tr>
								</thead>
								<tbody>
									<?php if(count($tl_wise) > 0){
										foreach($tl_wise as $item){?>
									<tr>
										<td><?php echo $item['tl_name']?></td>
										<td><?php echo $item['audit_count']?></td>
										<td><?php echo number_format((float)$item['average_score'], 2)?>%</td>
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
						<div class="col-md-6">
							<div style="width:100%;height:400px; padding:10px;">
                        <canvas id="tlWiseScoreChart"></canvas>
                     </div>
						</div>
					</div>
            </div>
            <div class="tabs" data-tab-name="agentWise" style="display:none;">
					<div class="widget-head clearfix" style="background-color: #f1f2f3;padding: 10px;color: #a70000;">
                  <div class="row">
                     <div class="col-md-4">
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i>Agent Wise Audit</h4>
                     </div>
                     <div class="col-md-8 text-right">
                        <button class="btn btn-primary" onclick="window.open('<?php echo base_url('qa_one_view_dashboard/download_AgentWiseReport')?>')">
                           <i class="fa fa-download"></i>&nbsp;Download Report
                        </button>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <table id="agentWise" data-plugin="DataTable"
                        class="table-freeze-header table table-striped skt-table">
                        <thead>
                           <tr>
                              <th>Agent Name</th>
                              <th>MTD Audit Count</th>
                              <th>Quality Score</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if(count($agentWise) > 0){
										foreach($agentWise as $item){?>
                           <tr>
                              <td><?php echo $item['agent_name']?></td>
                              <td><?php echo $item['audit_count']?></td>
                              <td><?php echo number_format((float)$item['average_score'], 2)?>%</td>
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
						<!-- <div class="col-md-6">
							<div style="width:100%;height:400px; padding:10px;">
                        <canvas id="agentWiseScoreChart"></canvas>
                     </div>
						</div> -->
               </div>
            </div>
            <div class="tabs" data-tab-name="verticalWise" style="display:none;">
               <div class="widget-head clearfix" style="background-color: #f1f2f3;padding: 10px;color: #a70000;">
                  <div class="row">
                     <div class="col-md-4">
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i>Vertical Wise Audit</h4>
                     </div>
                     <div class="col-md-8 text-right">
                        <button class="btn btn-primary" onclick="window.open('<?php echo base_url('qa_one_view_dashboard/download_VerticalWiseReport')?>')">
                           <i class="fa fa-download"></i>&nbsp;Download Report
                        </button>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                  <table id="verticalWise" data-plugin="DataTable"
                        class="table-freeze-header table table-striped skt-table">
                        <thead>
                           <tr>
                              <th>Vertical Name</th>
                              <th>MTD Audit Count</th>
                              <th>Quality Score</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if(count($verticalWise) > 0){
										foreach($verticalWise as $item){?>
                           <tr>
                              <td><?php echo $item['vertical_name']?></td>
                              <td><?php echo $item['audit_count']?></td>
                              <td><?php echo number_format((float)$item['average_score'], 2)?>%</td>
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
            <div class="tabs" data-tab-name="channelWise" style="display:none;">
               <div class="widget-head clearfix" style="background-color: #f1f2f3;padding: 10px;color: #a70000;">
                  <div class="row">
                     <div class="col-md-4">
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i>Channel Wise Audit</h4>
                     </div>
                     <div class="col-md-8 text-right">
                        <button class="btn btn-primary" onclick="window.open('<?php echo base_url('qa_one_view_dashboard/download_ChannelWiseReport')?>')">
                           <i class="fa fa-download"></i>&nbsp;Download Report
                        </button>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <table id="channelWise" data-plugin="DataTable"
                        class="table-freeze-header table table-striped skt-table">
                        <thead>
                           <tr>
                              <th>Channel Name</th>
                              <th>MTD Audit Count</th>
                              <th>Quality Score</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if(count($channelWise) > 0){
										foreach($channelWise as $item){?>
                           <tr>
                              <td><?php echo $item['channel_name']?></td>
                              <td><?php echo $item['audit_count']?></td>
                              <td><?php echo number_format((float)$item['average_score'], 2)?>%</td>
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
            <div class="tabs" data-tab-name="tenurityWise" style="display:none;">
               <div class="widget-head clearfix" style="background-color: #f1f2f3;padding: 10px;color: #a70000;">
                  <div class="row">
                     <div class="col-md-4">
                        <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i>Tenure Wise Audit</h4>
                     </div>
                     <div class="col-md-8 text-right">
                        <button class="btn btn-primary" onclick="window.open('<?php echo base_url('qa_one_view_dashboard/download_TenurityWiseReport')?>')">
                           <i class="fa fa-download"></i>&nbsp;Download Report
                        </button>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                  <table id="verticalWise" data-plugin="DataTable"
                        class="table-freeze-header table table-striped skt-table">
                        <thead>
                           <tr>
                              <th>Tenure</th>
                              <th>MTD Audit Count</th>
                              <th>Quality Score</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if(count($tenurityWise) > 0){
										foreach($tenurityWise as $item){?>
                           <tr>
                              <td><?php echo $item['tenurity']?> days</td>
                              <td><?php echo $item['audit_count']?></td>
                              <td><?php echo number_format((float)$item['average_score'], 2)?>%</td>
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
               <div class="col-md-8 text-right">
                  <button class="btn btn-primary" onclick="window.open('<?php echo base_url('qa_one_view_dashboard/download_ParameterWiseReport')?>')">
                     <i class="fa fa-download"></i>&nbsp;Download Report
                  </button>
               </div>
            </div>
         </div>
         <div class="widget-body clearfix">
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
                        <tbody><?php if(!empty($cq)){
									$cn = 1;
									foreach($cq['parameterArray'] as $token){?>
                           <tr>
                              <td class="text-center"><?php echo $cn++; ?></td>
                              <td class="" style="padding-left:5px"><b><?php echo $token; ?><b></td>
                              <td class="text-center"><?php echo $cq['params2']['count'][$token]['yes']; ?></td>
                              <td class="text-center"><?php echo $cq['params2']['count'][$token]['no']; ?></td>
                              <td class="text-center"><?php echo $cq['params2']['count'][$token]['na']; ?></td>
                              <td class="text-center">
                                 <?php echo $cq['params2']['count'][$token]['yes'] + $cq['params2']['count'][$token]['no'] + $cq['params2']['count'][$token]['na']; ?>
                              </td>
                              <td class="text-center"><b><?php echo $cq['params2']['percent'][$token]['yes']; ?>%<b>
                              </td>
                              <td class="text-center"><b><?php echo $cq['params2']['percent'][$token]['no']; ?>%<b></td>
                           </tr>
                           <?php }
								}?>
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
                           <?php $cn = 1; $totalpercent = 0;
									$defectValues = array();
									$defectCUM = array();
									$defectKey = array();
									if(!empty($cq)){
										foreach($cq['params']['count'] as $key=>$value){
											$errorpercent = 0;
											if(!empty($cq['audit']['error'])){
												$errorpercent = ($value / $cq['audit']['error']) * 100;
											} 
											$totalpercent = $totalpercent + $errorpercent;
											$defectValues[] = sprintf('%.2f', $errorpercent);
											$defectCUM[] = sprintf('%.2f', $totalpercent);
											$defectKey[] = $key ." (".$value.")";?>
                           <tr>
                              <td class="text-center"><?php echo $cn++; ?></td>
                              <td class="" style="padding-left:5px"><b><?php echo $key; ?><b></td>
                              <td class="text-center"><?php echo $value; ?></td>
                              <td class="text-center"><?php echo sprintf('%.2f', $errorpercent); ?>%</td>
                              <td class="text-center"><b><?php echo sprintf('%.2f', $totalpercent); ?>%<b></td>
                           </tr>
                           <?php }
										}?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="col-md-12">
                  <div style="width:100%;height:400px; padding:10px;display:none">
                     <canvas id="mylinebarchart"></canvas>
                  </div>
                  <div style="width:100%;">
                     <div id="pareto_test_composed" style="width:100%;height:600px;"></div>
                  </div>
                  <div id="pareto_pie-chart" style="display:none"></div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div><!-- .wrap -->