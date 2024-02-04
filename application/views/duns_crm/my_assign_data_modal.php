	

<div class="row text-right">

</div>
<div class="row">
    <?php foreach ($records_header as $token) {
        ?>
        <div class="col-sm-6">
            <div class="form-group">
                <label><?php echo $token['header_name']; ?></label>
                <textarea type="text" class="form-control" name="cl_<?php echo $token['column_name']; ?>" readonly><?php echo $data_info[$token['column_header']]; ?></textarea>
            </div>
        </div>
<?php } ?>
</div>



<hr/>
<div class="row">
    <div class="col-sm-6" style="font-size:16px">
        <i class="fa fa-user"></i> Agent Remarks
    </div>
<?php if ($view_type == "update") { ?>
        <div class="col-sm-6 text-right">
            <i class="fa fa-clock-o"></i> <span style="font-size:16px" id="timeWatch"></span>
        </div>
<?php } else { ?>
        <div class="col-sm-6 text-right">
            <b><i class="fa fa-clock-o"></i> <span style="font-size:16px;display:none" id="timeWatch"></span>
                <span style="font-size:16px;">AHT : <?php echo!empty($data_info['agent_aht']) ? $data_info['agent_aht'] : "00:00:00"; ?></span></b>
        </div>
<?php } ?>
</div>

<hr/>
<form method="POST" action="<?php echo duns_url('my_assign_data_agent_update'); ?>" enctype="multipart/form-data">

    <input type="hidden" class="form-control"  name="data_id" value="<?php echo!empty($data_info['id']) ? $data_info['id'] : ""; ?>" <?php echo $showType; ?> required>
    <input type="hidden" class="form-control"  name="record_id" value="<?php echo $record_id; ?>" <?php echo $showType; ?> required>
    <input type="hidden" name="time_interval" id="time_interval">

    <div class="row">
<?php
$showType = $view_type == "view" ? "readonly" : "";
foreach ($agents_input as $token) {
    $currentVal = !empty($data_info[$token['column_name']]) || $data_info[$token['column_name']] == "0" ? $data_info[$token['column_name']] : "";
    ?>
            <div class="col-sm-6">
                <div class="form-group">
                    <label><?php echo $token['reference_name']; ?></label>

    <?php if ($token['column_type'] == "text") { ?>
                        <input type="text" class="form-control"  name="<?php echo $token['column_name']; ?>" value="<?php echo $currentVal; ?>" <?php echo $showType; ?> required>
                    <?php } ?>

                    <?php if ($token['column_type'] == "textarea") { ?>
                        <textarea type="text" class="form-control"  name="<?php echo $token['column_name']; ?>" <?php echo $showType; ?> required><?php echo $currentVal; ?></textarea>
                    <?php } ?>

                    <?php
                    if ($token['column_type'] == "select") {
                        $colOptions = !empty($token['column_options']) ? explode(',', $token['column_options']) : array();
                        ?>
                        <select class="form-control"  name="<?php echo $token['column_name']; ?>" <?php echo $showType; ?> required>
                            <option value="">-- Select --</option>
                        <?php
                        if (!empty($colOptions)) {
                            foreach ($colOptions as $key => $val) {
                                $foundVal = "";
                                if ($currentVal == $val) {
                                    $foundVal = "selected";
                                }
                                ?>
                                    <option value="<?php echo $val; ?>" <?php echo $foundVal; ?> <?php echo $showType = $view_type == "view" ? "disabled" : "";?>><?php echo $val; ?></option>
                                <?php } ?>
                                <?php if (empty($foundVal) && !empty($currentVal)) { ?>
                                    <option value="<?php echo $currentVal; ?>" selected><?php echo $currentVal; ?></option>
                                <?php } ?>
                            </select>
                        <?php }
                    } ?>


                </div>
            </div>
        <?php } ?>	
    </div>


    <hr/>

    <?php if ($view_type == "update") { ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <button type="submit"  class="btn bg-success">Update</button>		 
                </div>
            </div>
        </div>
    <?php } ?>

</form>



<?php if (!duns_aht_exclusion()) { ?>
    <?php if ($view_type == "update") { ?>
        <hr/>
        <form method="POST" action="<?php echo duns_url('my_assign_data_agent_view_close'); ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                        <input type="hidden" class="form-control"  name="data_id" value="<?php echo!empty($data_info['id']) ? $data_info['id'] : ""; ?>" <?php echo $showType; ?> required>
                        <input type="hidden" class="form-control"  name="record_id" value="<?php echo $record_id; ?>" <?php echo $showType; ?> required>
                        <input type="hidden" name="time_interval" id="time_interval_close">
                        <button type="submit" onclick="return confirm('Are you sure you dont want to work on this now and close ?')" style="width:100px" class="btn bg-secondary">
                            <i class="fa fa-clock-o"></i> Close</button>		 
                    </div>
                </div>
            </div>
        </form>	
    <?php } else { ?>
        <hr/>
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="form-group">
                    <button type="button" style="width:100px" class="btn btn-secondary" data-dismiss="modal">Close</button>		 
                </div>
            </div>
        </div>

    <?php } ?>
<?php } ?>
	