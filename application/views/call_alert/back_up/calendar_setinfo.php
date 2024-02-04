<style>
.slotDIV .slotButton {
    margin: 1px 0px!important;
}

#slots_selected .slotShowButton {
    margin: 2px 1px!important;
}

.slotDIV button.in {
    background-color: #196f24!important;
    border-color: #196f24!important;
}

.header_slot {
    font-size: 16px!important;
}

.header_slot_section {
    background-color: #eee;
    padding: 10px 0px 10px 10px;
    font-size: 14px;
    font-weight: 600;
}

.slotDIV::-webkit-scrollbar {
    width: 4px;
}


/* Track */

.slotDIV::-webkit-scrollbar-track {
    /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.8);*/
    -webkit-border-radius: 10px;
    background-color: #fff;
    border-radius: 10px;
}


/* Handle */

.slotDIV::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: #c5bebe;
    /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);*/
}
.txt textarea {
  width: 100% !important;
  max-width: 580px;
  max-height: 40px;
  border-radius: 5px;
}
.submit-btn{
width: 150px;
max-width: 100%;
padding: 9px;
border-radius: 5px;
border: none;
font-size: 15px;
transition: all 0.5s ease-in-out 0s;
display: block;
}
.modal-footer {
display: none;
}
.modal-content{
width: 60%;
position: relative;
right: -270px;
}
</style>
<?php  $currTime =date('H:i',strtotime(GetLocalTime()));?>
<div class="row">
    <div class="col-md-12">
        <div class="slotFormGroup" >
            <div class="row">
            <hr style="margin-top: 10px;margin-bottom: 10px;" />
            
            <form method="POST" action="<?php echo base_url('Call_alert/calendar_availability_data_'.$cl_type); ?>">
                <input type="hidden" name="entry_type" id="entry_type" value="<?php echo $cl_type;?>">
                <input type="hidden" name="Call_alert_id" id="Call_alert_id" value="<?php echo $call_alert_id;?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="case"> Date </label>
                            <input type="date" class="form-control date_pic" autocomplete="off" value="<?php echo $Call_alert_date; ?>" min="<?php echo $cl_type=="edit" ?$Call_alert_date:date("Y-m-d"); ?>" name="s_from_date" required <?php echo $cl_type=="edit" ? "" : ""; ?>> </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="case">Type</label>
                            <select name="type" id="type" class="form-control" onchange="active_btn();" ; required>
                                <option value="">--select--</option>
                                <?php foreach($type_list as $key=>$rows){ ?>
                                    <option value="<?php echo $rows['name'];?>" <?php echo (trim($cattype)==trim($rows[ 'name']))? 'selected="selected"': '';?>>
                                        <?php echo $rows['name'];?>
                                    </option>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="case"> Email IDs</label>
                            <input type="text" class="form-control " autocomplete="off" value="<?php echo $emails; ?>" name="emails" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="case">Notification Days </label>
                            <input type="Date" class="form-control " autocomplete="off" value="<?php echo $cl_type=="edit" ?$notification_days:''; ?>" min="<?php echo $cl_type=="edit" ?$notification_days:date("Y-m-d"); ?>" name="notification_days" required> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="case">Notification Time </label>
                            <input type="time" class="form-control " autocomplete="off" value="<?php echo $cl_type=="edit" ?$notification_time:$currTime; ?>" name="notification_time" required>
                        </div>
                    </div>
                </div>        
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="case"> Supervisor's Email IDs</label>
                            <input type="text" class="form-control " autocomplete="off" value="<?php echo $emails1; ?>" name="emails1" required> 
                        </div>
                    </div>
                </div>
                        <div class="row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="case">Supervisor's Notification Days </label>
                                    <input type="date" class="form-control " autocomplete="off" min="<?php echo $cl_type=="edit" ?$notification_days1:date("Y-m-d"); ?>"  value="<?php echo $cl_type=="edit" ?$notification_days1:''; ?>" name="notification_days1" required> 
                                </div>
                            </div>    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="case">Supervisor's Notification Time </label>
                                    <input type="time" class="form-control " autocomplete="off" value="<?php echo $cl_type=="edit" ?$supervisor_notification_time:$currTime; ?>" name="supervisor_notification_time" required> 
                                </div>
                            </div>        
                        </div>
                        <div class="row">    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="case">Duration</label>
                                    <input type="number" class="form-control " autocomplete="off" value="<?php echo $duration; ?>" min="1" name="duration" required> 
                                </div>
                            </div>        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="case">Duration Type</label>
                                    <select name="duration_type" id="duration_type" class="form-control" required>
                                        <option value="1"  <?php echo ($duration_type==1)? 'selected="selected"': '';?>>Days</option>
                                        <option value="2" <?php echo ($duration_type==2)? 'selected="selected"': '';?>>Hours</option>
                                    </select>
                                </div>
                            </div>
                        </div>   
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="case">Location </label>
                                        <select name="location" id="location" class="form-control" required>
                                            <option value="">--select--</option>
                                            <?php foreach($location_list as $key=>$rows){ ?>
                                                <option value="<?php echo $rows['name'];?>" <?php echo (trim($location_name)==trim($rows[ 'name']))? 'selected="selected"': '';?>>
                                                    <?php echo $rows['name'];?>
                                                </option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group txt">
                                        <label for="case">Comments</label><br>
                                        <textarea name="comment" id="comments" placeholder="comments" required><?php echo $Comment;?></textarea>
                                    </div>
                                </div>
                                <?php/* if($cl_type!='edit'){ ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="checkbox" name="repeat" id="repeat" value="yes" onClick="open_repeat()"> Repeat </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select id="repeat_mode" name="repeat_mode" class="form-control" style="display:none;">
                                                <option value="12">monthly</option>
                                                <option value="4">quarterly</option>
                                                <option value="2">half-yearly</option>
                                                <option value="1">Yearly</option>
                                            </select>
                                        </div>
                                    </div>    
                                    <hr/>
                                    <?php }*/ ?>
                                </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" name="submission"  class="btn btn-primary submit-btn"><i class="fa fa-paper-plane"></i> Submit</button>
                                                </div>
                                            </div>
                                        </div>
            </form>
            </div>
            </div>
            </div>
                <script>
                function active_btn() {
                    dt = $('#type').val();
                    if(dt == '') {
                        $('#type').removeAttr('disabled');
                        $('#type').css('disabled', 'none');
                    } else {
                        $('#type').Attr('disabled');
                        $('#type').css('disabled', 'disabled');
                    }
                }
                function open_repeat(){
                    let isChecked = $('#repeat').is(':checked');
                    if(isChecked){
                        $('#repeat_mode').css('display','block');
                    }else{
                        $('#repeat_mode').css('display','none');
                    }
                }
                </script>