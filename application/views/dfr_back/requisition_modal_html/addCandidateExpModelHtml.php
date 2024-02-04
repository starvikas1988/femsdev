<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmaddCandidateExp" action="<?php echo base_url(); ?>dfr/add_candidate_exp" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Experience</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" id="company_name" name="company_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Designation</label>
                                <input type="text" id="designation" name="designation" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="text" id="from_date" name="from_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="text" id="to_date" name="to_date" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact</label>
                                <input type="text" id="contact" name="contact" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Work Experience (In Year)</label>
                                <input type="text" id="work_exp" name="work_exp" class="form-control" onkeyup="checkDec(this);" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Job Description</label>
                                <textarea class="form-control" id="job_desc" name="job_desc" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company Address</label>
                                <textarea class="form-control" id="address" name="address" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='addCandidateExperience' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
    <script>
        $("#from_date").datepicker({
            maxDate: new Date()
        });
        $("#to_date").datepicker({
            maxDate: new Date()
        });
    </script>