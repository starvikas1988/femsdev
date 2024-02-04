<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmeditCandidateQual" action="<?php echo base_url(); ?>dfr/edit_candidate_qual" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Qualification</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="c_qual_id" name="c_qual_id" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Exam</label>
                                <input type="text" id="exam" name="exam" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Passing Year</label>
                                <input type="number" id="passing_year" name="passing_year" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Board/UV</label>
                                <input type="text" id="board_uv" name="board_uv" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Grade/CGPA</label>
                                <input type="text" id="grade_cgpa" name="grade_cgpa" class="form-control" onkeyup="checkDec(this);" required>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="div_parcent_edit" style="display:none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>10th Eng%</label>
                                <input type="number" id="10eng_edit" name="10eng" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>10th Math%</label>
                                <input type="number" id="10math_edit" name="10math" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="div_parcent1_edit" style="display:none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>12th Eng%</label>
                                <input type="number" id="12eng_edit" name="12eng" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>12th Math%</label>
                                <input type="number" id="12math_edit" name="12math" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Specialization</label>
                                <textarea class="form-control" id="specialization" name="specialization" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='editCandidateQualification' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>