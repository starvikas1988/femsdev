<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmeditScheduleCandidate" action="<?php echo base_url(); ?>dfr/edit_candidate_schedule" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Schedule</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="sch_id" name="sch_id" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Schedule Date/Time</label>
                                <input type="text" id="scheduled_on1" name="scheduled_on" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Interview Site</label>
                                <input type="text" readonly class="form-control" id="edinterview_site" name="interview_site">
                                <!--<select class="form-control" readonly id="interview_site" name="interview_site">
                                        <option>--Select--</option>
                                <?php //foreach($get_site_location as $sl):
                                ?>
                                                <option value="<?php //echo $sl['abbr'];
                                                                ?>"><?php //echo $sl['location'];
                                                                    ?></option>
                                <?php //endforeach;
                                ?>	
                                </select>-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Interview Type</label>
                                <select class="form-control" id="edinterview_type" name="interview_type" required>
                                    <option>--Select--</option>
                                    <?php foreach ($dfr_interview_type_mas as $invType) { ?>
                                        <option value="<?php echo $invType['id']; ?>"><?php echo $invType['name']; ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Interviewer</label>
                                <select class="form-control" id="edassign_interviewer" name="assign_interviewer" style="width:100%" required>
                                    <option>--Select--</option>
                                    <?php //foreach($user_tlmanager as $row){
                                    ?>
                                    <!--<option value="<?php //echo $row['id'];
                                                        ?>"><?php //echo $row['name'];
                                                            ?></option>-->
                                    <?php //}
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Remarks</label>
                                <input type="text" id="remarks" name="remarks" class="form-control">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='edCandidateSchedule' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>