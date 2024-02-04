<div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">

            <form class="frmLetterOfIntent" action="<?php echo base_url(); ?>dfr/loi_send" onsubmit="return finalselection()" method='POST'>

                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Letter of Intent</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id">
                    <input type="hidden" id="c_id" name="c_id">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Onboarding Type <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <select id="onboarding_typ" name="onboarding_typ" class="form-control">
                                    <option value="">-- Select type --</option>
                                    <option value="Regular">Regular</option>
                                    <option value="NAPS">NAPS</option>
                                    <option value="Stipend">Stipend</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="fname" id="fname" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="lname" id="lname" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" id="email" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Training Start Date</label>
                                <input type="text" name="training_start_date" id="training_start_date" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Stipend Amount</label>
                                <input type="text" name="stipend_amount" id="stipend_amount" class="form-control number-only-no-minus-also">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>CTC Amount</label>
                                <input type="text" name="ctc_amount" id="ctc_amount" class="form-control number-only-no-minus-also">
                            </div>
                        </div>
                    </div>

                </div>


                <div class="modal-footer">

                    <span style="float: left;">
                        <label>Candidate History: </label>
                        <span id="user_history">

                        </span>
                    </span>

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" id='send_loi_button' class="btn btn-primary" value="Save & Send">
                </div>

            </form>

        </div>
    </div>