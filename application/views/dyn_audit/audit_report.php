<div class="wrap">
    <section class="app-content">

        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <div class="row">
                        <div class="col-md-10">
                            <header class="widget-header">
                                <h4 class="widget-title">Audit Report</h4>
                            </header>
                        </div>
                        <hr class="widget-separator">
                    </div>

                    <div class="widget-body">
                        <div class="row">
                            <form id="form_new_user" method="GET"
                                action="<?php echo base_url('dyn_audit_report/dyn_audit_report'); ?>">
                                <?php echo form_open('',array('method' => 'get')) ?>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Search Date From - Audit Date (mm/dd/yyyy)</label>
                                        <input type="text" id="from_date" name="date_from"
                                            value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control"
                                            required autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Search Date To - Audit Date (mm/dd/yyyy)</label>
                                        <input type="text" id="to_date" name="date_to"
                                            value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control" required
                                            autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" id="foffice_div">
                                        <label for="office_id">Select Location</label>
                                        <select class="form-control" name="office_id" id="foffice_id">
                                            <option value='All'>All</option>
                                            <?php foreach($location_list as $loc): ?>
                                            <?php
											$sCss="";
											if($loc['abbr']==$office_id) $sCss="selected";
											?>
                                            <option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>>
                                                <?php echo $loc['office_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $exist_process_lob_campaign = is_exist_process_lob_campaign_table();
                                if($exist_process_lob_campaign['process']==true){ ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Process</label>
                                        <select class="form-control" name="process_id[]" id="process_id" required multiple>
                                        <?php if(in_array('ALL',(array)$pValue)) $cSpr='Selected'; ?>
                                            <option value='ALL' <?php echo $cSpr; ?>>ALL</option>
                                            <?php foreach($all_process as $process):?>
                                            <?php $cScc='';
										if(in_array($process['pro_id'],(array)$pValue)) $cScc='Selected'; ?>
                                            <option value="<?php echo $process['pro_id']?>" <?php echo $cScc; ?>>
                                                <?php echo $process['process_name']?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <?php }
                                if($exist_process_lob_campaign['lob']==true){ ?>
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Lob</label>
                                        <select class="form-control" name="lob_id[]" id="lob_id" required multiple>
                                        <?php if(in_array('ALL',$selected_lob)){ $select2 = "selected"; } ?>
                                        <option value='ALL' <?php echo $select2; ?>>ALL</option>
                                            <option value=''>Select LOB</option>
                                        </select>
                                    </div>
                                </div>
                                <?php }
                                if($exist_process_lob_campaign['campaign']==true){ ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Campaign</label>
                                        <select class="form-control" name="campaign_id[]" id="campaign_id" required multiple>
                                            <option value=''>Select Campaign</option>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Audit Sheet</label>
                                        <select class="form-control" name="audit_sheet[]" id="audit_sheet" required multiple>
                                            <option value=''>Select Audit Sheet</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select Audit Type</label>
                                    <select class="form-control" name="a_type">
                                        <option value='All'>All</option>
                                        <option <?php echo $a_type=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ
                                            Audit</option>
                                        <option <?php echo $a_type=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ
                                            Audit</option>
                                        <option <?php echo $a_type=='Calibration'?"selected":""; ?> value="Calibration">
                                            Calibration</option>
                                        <option <?php echo $a_type=='Pre-Certificate Mock Call'?"selected":""; ?>
                                            value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
                                        <option <?php echo $a_type=='Certificate Audit'?"selected":""; ?>
                                            value="Certificate Audit">Certificate Audit</option>
                                        <option <?php echo $a_type=='Operation Audit'?"selected":""; ?>
                                            value="Operation Audit">Operation Audit</option>
                                        <option <?php echo $a_type=='Trainer Audit'?"selected":""; ?>
                                            value="Trainer Audit">Trainer Audit</option>
                                        <option <?php echo $a_type=='OJT'?"selected":""; ?> value="OJT">OJT</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-1 text-center" style='margin-top:22px;'>
                                <div class="form-group">
                                    <button class="btn btn-primary waves-effect" a
                                        href="<?php echo base_url()?>qa_otipy/qa_otipy_report" type="submit" id='show'
                                        name='show' value="Show">SHOW</button>
                                </div>
                            </div>
                            <div class="col-md-2" style='margin-top:22px;'>
                                <div class="form-group">
                                    <button class="btn btn-primary waves-effect" a
                                        href="<?php echo base_url()?>qa_otipy/qa_otipy_report" type="submit" id='show'
                                        name='show' value="export">EXPORT</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php if($download_link!=""){ ?>
                            <div style='float:right; margin-top:25px;' class="col-md-4">
                                <div class="form-group" style='float:right;'>
                                    <a href='<?php echo $download_second_link; ?>' title="Export This Report"><span
                                            style="padding:12px;" class="label label-success">Export This
                                            Report</span></a>
                                    <a href='<?php echo $download_link; ?>' title="Export Detailed Report"><span
                                            style="padding:12px;" class="label label-success">Export Report</span></a>
                                </div>
                            </div>
                            <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
                <hr class="widget-separator" />
                    <div class="widget">
                        <div class="widget-header">
                            <h4 class="widget-title"><?php echo $$referrer['lob_name'];?></h4>
                        </div>
                        <div class="widget-body">
                            <div class="table-responsive">
                                <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr class='bg-info'>
                                            <th>SL</th>
                                            <th>Ticket ID</th>
                                            <th>Agent Name</th>
                                            <th>Process Name</th>
                                            <th>TL Name</th>
                                            <th>Audit Date</th>
                                            <th>Auditor</th>
                                            <th>Total Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                            $i=1;
                                            foreach($qa_otipy_list as $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['ticket_id']; ?></td>
                                            <td><?php echo $row['agent_name']; ?></td>
                                            <td><?php $p_name = $row['process']!=0? getProcessName($row['process']):'NA';
                                            echo $p_name ?></td>
                                            <td><?php echo $row['tl_name']; ?></td>
                                            <td><?php echo ConvServerToLocal($row['entry_date']); ?></td>
                                            <td><?php 
                                                if($row['entry_by']!=''){
                                                    echo $row['auditor_name'];
                                                }else{
                                                    echo $row['client_name'].' [Client]';
                                                }
                                            ?></td>
                                            <td><?php echo $row['overall_score'].'%'; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
</div>