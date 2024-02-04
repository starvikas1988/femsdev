<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmaddScheduleCandidate" action="<?php echo base_url(); ?>dfr/candidate_schedule" data-toggle="validator" method='POST'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Schedule Interview</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="dept_id" name="dept_id" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Schedule Date/Time</label>
                                <input type="text" id="scheduled_on" name="scheduled_on" class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Interview Site</label>
                                <input type="text" readonly class="form-control" id="interview_site" name="interview_site">                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Interview Type</label>
                                <select class="form-control" id="interview_type" name="interview_type" required onchange="assignInterviewer($(this));">
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
                                <select class="form-control" id="assign_interviewer" name="assign_interviewer" style="width:100%" required>
                                    <option>--Select--</option>                                    
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
                    <button type="submit" id='addCandidateSchedule' class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
<script>    
    $("#scheduled_on").datetimepicker({
        minDate: -7
    });
</script>