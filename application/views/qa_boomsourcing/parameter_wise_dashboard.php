<style>
.table>thead>tr>th, .table>thead>tr>td, .table>tbody>tr>th, .table>tbody>tr>td, .table>tfoot>tr>th, .table>tfoot>tr>td {padding: 2px;text-align: center;font-size: 12px;}li.oneItem_ {display: inline-block;background-color: #188ae2;padding: 10px;color: #fff;border-radius: 7px;cursor: pointer;}li.oneItem_.active {background-color: #195bbb;}.fitwidth {width: 1px;white-space: nowrap;}
</style>
<div class="wrap">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb" style="margin-bottom: 8px !important;background-color: #fff">
        <li class="breadcrumb-item">CQ Dashboard</li>
        <li class="breadcrumb-item active" aria-current="page"><a href="<?php base_url('Qa_boomsourcing_data_analytics/parameter_wise_dashboard');?>">Parameter Dashboard</a></li>
      </ol>
    </nav>
    <section class="app-content">
        <div class="row">
            <div class="col-12">
                <div class="widget">
                    <div class="widget-body">
                        <form method="GET" action="<?php echo base_url("Qa_boomsourcing_data_analytics/parameter_wise_dashboard");?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="select_process">Process</label>
                                        <select id="select_process" class="form-control" name="select_process" required>

                                            <?php foreach($process_list as $process):?>
                                            <option value="<?php echo $process['process_id']?>" <?php echo in_array( $process['process_id'], $selected_process) ? 'selected' : ''; ?>><?php echo $process['process_name']?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
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

                                <div class="col-md-2">
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

                                <div class="col-md-2">
                                    <div class="form-group">
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
                                    <div class="form-group">
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
                                    <div class="form-group">
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
                                    <div class="form-group">
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
                                    <div class="form-group">
                                        <label for="parameter_type">Parameter Type</label>
                                        <select id="parameter_type" class="form-control" name="parameter_type" required>
                                            <option value="normal" <?php echo $selected_parameter_type == 'normal' ? 'selected' : ''?>>Normal Parameter</option>
                                            <option value="fatal" <?php echo $selected_parameter_type == 'fatal' ? 'selected' : ''?>>Fatal Parameter</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rep_type">Representation Type</label>
                                        <select id="rep_type" class="form-control" name="rep_type">
                                            <option value="daily" <?php echo $data_show_type == 'daily' ? 'selected' : ''?>>Date Wise</option>
                                            <option value="monthly" <?php echo $data_show_type == 'monthly' ? 'selected' : ''?>>Month Wise</option>
                                            <option value="weekly" <?php echo $data_show_type == 'weekly' ? 'selected' : ''?>>Weekly Wise</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="monthly" style="display:none;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ssdate">Search Month</label>
                                            <select class="form-control" name="select_month" id="select_month">
                                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                <option value="<?php echo sprintf('%02d', $i); ?>"
                                                    <?php echo $selected_month == $i ? 'selected' : ''; ?>>
                                                    <?php echo date('F', strtotime('2019-' . sprintf('%02d', $i) . '-01')); ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                                </div>
                                <div id="daily" style="display:none;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="select_from_date">Search From Date</label>
                                            <input type="text" name="select_from_date" id="select_from_date"class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="select_to_date">Search To Date</label>
                                            <input type="text" name="select_to_date" id="select_to_date" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-top: 22px;">
                                        <input type="submit" class="btn btn-primary btn-md" name="submitForm" value="Search"/>
                                        <?php if(!empty($_SERVER['QUERY_STRING'])):?>
                                        <a class="btn btn-warning" href="<?php echo base_url('Qa_boomsourcing_data_analytics/parameter_wise_dashboard/?').$_SERVER['QUERY_STRING'].'&excel_report=true';?>">EXPORT REPORT</a>
                                        <?php endif;?>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                    
        <?php 
            $i = 1;
            $graph_data = array();
            foreach($parameter_details as $lob_key => $data):?>
            <div class="widget">
                <div class="widget-body"> 
                    <div class="row">
                        <div class="col-md-12" style="padding-left: 13px !important;">
                            <div id="chart-<?php echo $i;?>"></div>
                        </div>
                        <div class="col-md-12" style="padding-left: 13px !important;">
                            <div class="widget">
                                <div class="widget-body">
                                    <div class="widget-body table-responsive">
                                        <div style="overflow-y: auto;">
                                            <div class="col-md-4" style="margin-bottom:2px;float: right;">
                                                <input type="text" id="table-search-input-<?php echo $i;?>" placeholder="Type to search" class="form-control">
                                            </div>
                                            
                                            <table id="table-data-<?php echo $i;?>" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr class="bg-info">
                                                        <th class="text-center fitwidth ">Parameters</th>
                                                        <th class="text-center fitwidth ">Audit Count</th>
                                                        <th class="text-center fitwidth ">Yes</th>
                                                        <th class="text-center fitwidth ">No</th>
                                                        <th class="text-center fitwidth ">NA</th>
                                                        <th class="text-center fitwidth ">Score (%)</th>
                                                        <th class="text-center fitwidth ">Defect (%)</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    <?php 
                                                        /*For graph*/
                                                        $xAxis = array();
                                                        $yes_count = array();
                                                        $no_count = array();
                                                        $na_count = array();
                                                        $graphScore = array();
                                                        $defectScore = array();
                                                        foreach($lob_wise_parameters[$lob_key] as $parameter):
                                                            $total_audit = ($data[$parameter."_yes"] + $data[$parameter."_no"] + $data[$parameter."_na"]);

                                                            if($selected_parameter_type == 'normal'){
                                                                $score = number_format((float)(($data[$parameter."_yes"] / $total_audit) * 100),2);
                                                            }
                                                            else
                                                            {
                                                                $score = number_format((float)(($data[$parameter."_no"] / $total_audit) * 100),2);
                                                            }
                                                            $defect = number_format((float)(100 - $score),2);

                                                            array_push($xAxis,ucwords(str_replace('_', ' ', $parameter)));
                                                            array_push($yes_count,(float)$data[$parameter."_yes"]);
                                                            array_push($no_count,(float)$data[$parameter."_no"]);
                                                            array_push($na_count,(float)$data[$parameter."_na"]);
                                                            array_push($graphScore,(float)number_format((float)$score, 2));
                                                            array_push($defectScore,(float)number_format((float)$defect, 2));
                                                        ?>
                                                       
                                                       <tr>
                                                            <td><?php echo ucwords(str_replace('_', ' ', $parameter));?></td>
                                                            <td><?php echo $total_audit;?></td>
                                                            <td><?php echo $data[$parameter."_yes"];?></td>
                                                            <td><?php echo $data[$parameter."_no"];?></td>
                                                            <td><?php echo $data[$parameter."_na"];?></td>
                                                            <td><?php echo $score;?> %</td>
                                                            <td><?php echo $defect;?> %</td>
                                                       </tr>

                                                   <?php endforeach;

                                                            $graph_data[$lob_key] = array(
                                                                                            "xAxis" => $xAxis,
                                                                                            "yes_count" => $yes_count,
                                                                                            "no_count" => $no_count,
                                                                                            "na_count" => $na_count,
                                                                                            "score" => $graphScore,
                                                                                            "defect" => $defectScore
                                                                                         );
                                                   ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        <?php $i++; endforeach;?>
    
    </section>
</div>
