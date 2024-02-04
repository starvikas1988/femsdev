div class="modal-dialog">
        <div class="modal-content">

            <form class="frmApprovalFinalSelectPhp" id="candidateSelectionFormPhp" action="<?php echo base_url(); ?>dfr/candidate_final_approval_php" data-toggle="validator" method='POST'>

                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Final Candidate Approval</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="requisition_id" name="requisition_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="location_id" name="location_id" value="">
                    <input type="hidden" id="c_status" name="c_status" value="">
                    <input type="hidden" id="org_role" name="org_role" value="">
                    <input type="hidden" id="gender" name="gender" value="">
                    <input type="hidden" id="brand_id" name="brand_id" value="">

                    <div class="row" id="prevUserInfoRow" style="display:none; margin-bottom:10px">
                        <div class="col-md-12" style="border:1px solid; border-color:#a94442;" id="prevUserInfoContent">

                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                if (isIndiaLocation(get_user_office_id()) == true) {
                                    echo '<label>Date of Joining (dd/mm/yyyy) &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
                                } else {
                                    echo '<label>Date of Joining (mm/dd/yyyy) &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
                                }
                                ?>
                                <input type="date" id="doj" name="doj" class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Job Level &nbsp; <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="job_level" name="job_level" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Division &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="division" name="division" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Immediate Supervisor &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="immediate_supervisor" name="immediate_supervisor" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coordinate with &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="coordinate_with" name="coordinate_with" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Overseas &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="overseas" name="overseas" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Currency &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <select class="form-control" id="pay_currency" name="pay_currency" disabled>
                                    <option value="SL">Philippine Peso (PHP)</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Deminimis &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="deminimis" name="deminimis" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Standard Incentive &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="standard_incentive" name="standard_incentive" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Account Premium &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="account_premium" name="account_premium" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Night Differential &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="night_differential" name="night_differential" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group" id="">
                                <label>Monthly Basic Salary &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="basic_salary" name="basic_salary" class="form-control" onblur="calculate_total();" onkeyup="checkDec(this);" autocomplete="off" value='0' required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group" id="">
                                <label>Total &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="total_amount" name="total_amount" class="form-control" autocomplete="off" value='0' readonly>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Qualification &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <textarea class="form-control" id="qualification" name="qualification" class="form-control" autocomplete="off" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Job Summary &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <textarea class="form-control" id="job_summary" name="job_summary" class="form-control" autocomplete="off" required></textarea>
                            </div>
                        </div>

                        <div class="row" id="" style="display:none;">
                            <input name="pay_type" value="0" type="hidden">
                            <input name="pay_currency" value="" type="hidden">
                            <input name="gross_amount" value="0" type="hidden">
                        </div>


                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <input type="button" name="finalcheckphp" id='finalcheckphp' class="btn btn-primary" value="Save">
                    </div>
                </div>
            </form>

        </div>
    </div>