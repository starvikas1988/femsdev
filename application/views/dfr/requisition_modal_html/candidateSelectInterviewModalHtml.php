<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmCandidateSelectInterview" action="<?php echo base_url(); ?>dfr/candidate_final_interviewStatus" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Candidate Final Status</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select id="candidate_status" name="candidate_status" class="form-control" required>
                                    <option value="">--select--</option>

                                    <option value="SL">Shortlisted</option>
                                    <option value="R">Reject</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Reason/Remarks</label>
                                <textarea class="form-control" id="final_status_remarks" name="final_status_remarks"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='selectInterviewCandidate' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>