<div class="wrap">
    <section class="app-content">
        <div class="row">
            <div class="col-12">
                <div class="widget">
                    <div class="row">
                        <div class="col-md-10">
                            <header class="widget-header">
                                <h4 class="widget-title">Search Your Feedback</h4>
                            </header>
                        </div>
                        <hr class="widget-separator">
                    </div>
                    <div class="widget-body">
                        <form id="form_new_user" name="form_new_user" method="GET" action="<?= base_url('qa_avon/agent_avon_feedback'); ?>" onsubmit="return validate()">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From Date (mm/dd/yyyy)</label>
                                        <input type="text" id="from_date" onchange="date_validation(this.value,'S')" name="from_date" onkeydown="return false;" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control"  required><span class="start_date_error" style="color:red"></span>
                                    </div>
                                </div>  
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                        <label>To Date (mm/dd/yyyy)</label>
                                        <input type="text" id="to_date" name="to_date" onkeydown="return false;" onchange="date_validation(this.value,'E')" value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control"  required><span class="end_date_error" style="color:red"></span>
                                    </div> 
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>LOB/Channel</label>
                                        <select class="form-control" id ="campaign" name="campaign" required>
                                            <option value="">Select</option>
                                            <option value="Inbound" <?= (isset($_GET['campaign']) && $_GET['campaign']=="Inbound")?"selected":""?>>Inbound</option>
                                            <option value="Outbound" <?= (isset($_GET['campaign']) && $_GET['campaign']=="Outbound")?"selected":""?>>Outbound</option>
                                            <option value="Email" <?= (isset($_GET['campaign']) && $_GET['campaign']=="Email")?"selected":""?>>Email</option>
                                            <option value="Chat" <?= (isset($_GET['campaign']) && $_GET['campaign']=="Chat")?"selected":""?>>Chat</option>
                                            <option value="CRM" <?= (isset($_GET['campaign']) && $_GET['campaign']=="CRM")?"selected":""?>>CRM</option>
                                            <option value="SMS" <?= (isset($_GET['campaign']) && $_GET['campaign']=="SMS")?"selected":""?>>SMS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1" style="margin-top:20px">
                                    <button class="btn btn-success waves-effect" a href="<?= base_url() ?>qa_avon/agent_avon_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="widget">
                    <div class="row">
                        <div class="col-md-12">
                            <header class="widget-header">
                                <div class="col-md-6">
                                    <h4 class="widget-title">Avon</h4>
                                </div>
                                <div class="col-md-6" style="float:right">
                                    <span style="font-weight:bold; color:red">Total Feedback</span> <span class="badge" style="font-size:12px"><?= $tot_feedback; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?= $yet_rvw; ?></span>
                                </div>
                            </header>
                        </div>
                        <hr class="widget-separator">
                    </div>
                    <div class="widget-body">
                        <div class="table-responsive">
                            <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="bg-info">
                                        <th>SL</th>
                                        <th>Auditor</th>
                                        <th>Audit Date</th>
                                        <th>Agent Name</th>
                                        <th>L1 Supervisor</th>
                                        <th>LOB</th>
                                        <th><?= (isset($_GET['campaign']) && ($_GET['campaign']=="email" || $_GET['campaign']=="ticket"))?"SLA":"Call Duration"?></th>
                                        <th>Total Score</th>
                                        <th>Audio</th>
                                        <th>Agent Review Date</th>
                                        <th>Mgnt Review By</th>
                                        <th>Mgnt Review Date</th>
                                        <th>Client Review Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($agent_rvw_list as $row) :

                                        $new = explode("-", $row['entry_date']);
                                        $new1 = explode(" ", $new[2]);
                                        //print_r($new);
                                        $a = array($new[1], $new1[0], $new[0]);
                                        $n_date = implode("/", $a);
                                        $auditDate = ($n_date)." ".$new1[1];
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $row['auditor_name']; ?></td>
                                            <td><?= $auditDate; ?></td>
                                            <td><?= $row['fname'] . " " . $row['lname']; ?></td>
                                            <td><?= $row['tl_name']; ?></td>
                                            <td><?= $row['lob']; ?></td>
                                            <td><?= (isset($_GET['campaign']) && ($_GET['campaign']=="email" || $_GET['campaign']=="ticket"))?$row['sla']:$row['call_duration']; ?></td>
                                            <td><?= $row['overall_score'] . "%"; ?></td>
                                            <td oncontextmenu="return false;">
                                                <?php
                                                if ($row['attach_file'] != '') {
                                                    $attach_file = explode(",", $row['attach_file']);
                                                    foreach ($attach_file as $mp) {
                                                ?>
                                                        <audio controls='' style="width:120px; height:25px; background-color:#607F93">
                                                            <source src="<?= base_url(); ?>qa_files/qa_avon/<?= $mp; ?>" type="audio/ogg">
                                                            <source src="<?= base_url(); ?>qa_files/qa_avon/<?= $mp; ?>" type="audio/mpeg">
                                                        </audio>
                                                <?php }
                                                }    ?>
                                            </td>
                                            <td><?= $row['agent_rvw_date']; ?></td>
                                            <td><?= $row['mgnt_rvw_name']; ?></td>
                                            <td><?= $row['mgnt_rvw_date']; ?></td>
                                            <td><?= $row['client_rvw_date']; ?></td>
                                            <td>
                                                <?php $mpid = $row['id']; ?>

                                                <a class="btn btn-success" href="<?= base_url(); ?>qa_avon/agent_avon_rvw<?= (isset($_GET['campaign']))?"/".$_GET['campaign']:"" ?>/<?= $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-info">
                                        <th>SL</th>
                                        <th>Auditor</th>
                                        <th>Audit Date</th>
                                        <th>Agent Name</th>
                                        <th>L1 Supervisor</th>
                                        <th>LOB</th>
                                        <th><?= (isset($_GET['campaign']) && ($_GET['campaign']=="email" || $_GET['campaign']=="ticket"))?"SLA":"Call Duration"?></th>
                                        <th>Total Score</th>
                                        <th>Audio</th>
                                        <th>Agent Review Date</th>
                                        <th>Mgnt Review By</th>
                                        <th>Mgnt Review Date</th>
                                        <th>Client Review Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
</div>