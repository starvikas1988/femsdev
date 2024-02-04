<div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">

            <form class="frmaddCandidateInterview" action="<?php echo base_url(); ?>dfr/add_candidate_interview" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Candidate Interview</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="sch_id" name="sch_id" value="">
                    <input type="hidden" id="sh_status" name="sh_status" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Interviewer Name</label>
                                <select class="form-control" id="interviewer_id" name="interviewer_id" required>
                                    <option value="">--Select--</option>
                                    <?php
                                    $sCss = '';
                                    foreach ($user_tlmanager as $tm) {
                                        if ($tm['id'] == get_user_id()) {
                                            $sCss = 'selected'; ?>
                                            <option value="<?php echo $tm['id']; ?>" <?php echo $sCss; ?>><?php echo $tm['name']; ?></option>
                                        <?php
                                        } else { ?>
                                            <option value="<?php echo $tm['id']; ?>"><?php echo $tm['name']; ?></option>
                                        <?php } ?>
                                    <?php
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Interview Date</label>
                                <input type="text" id="scheduled_date" name="interview_date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    </br>

                    <div class="row">
                        <!-- -->
                        <div class="col-md-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Education/Training:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="educationtraining_param" name="educationtraining_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Job Knowledge:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="jobknowledge_param" name="jobknowledge_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Work Experience:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="workexperience_param" name="workexperience_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Analytical Skills:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="analyticalskills_param" name="analyticalskills_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Technical Skills:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="technicalskills_param" name="technicalskills_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">General Awareness:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="generalawareness_param" name="generalawareness_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Body Language:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="bodylanguage_param" name="bodylanguage_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">English Comfortable:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="englishcomfortable_param" name="englishcomfortable_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">MTI:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="mti_param" name="mti_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Enthusiasm:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="enthusiasm_param" name="enthusiasm_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Leadership Skills:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="leadershipskills_param" name="leadershipskills_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Customer Importance:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="customerimportance_param" name="customerimportance_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Job Motivation:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="jobmotivation_param" name="jobmotivation_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Target Oriented:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="resultoriented_param" name="resultoriented_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Convincing Power:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="logicpower_param" name="logicpower_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Initiative:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="initiative_param" name="initiative_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Assertiveness:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="assertiveness_param" name="assertiveness_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="float:right">Decision Making:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="decisionmaking_param" name="decisionmaking_param" required>
                                            <option value="">-Select-</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- -->
                    </div>

                    </br>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Listening Skill:</label>
                                <select class="form-control" id="listen_skill" name="listen_skill" required>
                                    <option value="">-Select-</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Overall Interview Result</label>
                                <select class="form-control" id="result" name="result" required>
                                    <option value="">-Select-</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Interview Status</label>
                                <select id="interview_status" name="interview_status" class="form-control" required>
                                    <option value="">--select--</option>
                                    <option value="C">Cleared Interview</option>
                                    <option value="N">Not Cleared Interview</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Overall Assessment (Minimum 20 characters)</label>
                                <textarea class="form-control" id="overall_assessment" name="overall_assessment" minlength="20" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Interview Remarks</label>
                                <textarea class="form-control" id="interview_remarks" name="interview_remarks"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='addCandidateInterview' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>