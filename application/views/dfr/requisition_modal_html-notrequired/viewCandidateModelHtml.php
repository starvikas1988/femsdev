<div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form class="frmViewCandidate" onsubmit="return false" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">View Candidate Details</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="r_id" name="r_id" value="">

                    <?php //foreach($get_candidate_details as $row):
                    ?>

                    <div class="table-responive">
                        <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                            <tr>
                                <td class='bg-info'>Requision Code</td>
                                <td id="c_d_requisition_id"></td>
                                <td class='bg-info'>Candidate Name</td>
                                <td id="c_d_fullname"></td>
                                <td class='bg-info'>Hiring Source</td>
                                <td id="c_d_hiring_source"></td>
                                <td class='bg-info'>Date of Birth</td>
                                <td id="c_d_dob"></td>
                            </tr>
                            <tr>
                                <td class='bg-info'>Email ID</td>
                                <td id="c_d_email"></td>
                                <td class='bg-info'>Mobile</td>
                                <td id="c_d_phone"></td>
                                <td class='bg-info'>Last Qualification</td>
                                <td id="c_d_last_qualification"></td>
                                <td class='bg-info'>Skill Set</td>
                                <td id="c_d_skill_set"></td>
                            </tr>
                            <tr>
                                <td class='bg-info'>Total Work Exp.</td>
                                <td id="c_d_total_work_exp"></td>
                                <td class='bg-info'>Country</td>
                                <td id="c_d_country"></td>
                                <td class='bg-info'>State</td>
                                <td id="c_d_state"></td>
                                <td class='bg-info'>City</td>
                                <td id="c_d_city"></td>
                            </tr>
                            <tr>
                                <td class='bg-info'>Post Code</td>
                                <td id="c_d_postcode"></td>
                                <td class='bg-info'>Gender</td>
                                <td id="c_d_gender"></td>
                                <td class='bg-info'>Address</td>
                                <td colspan='4' id="c_d_address"></td>
                            </tr>
                            <tr>
                                <td class='bg-info'>Attachment</td>
                                <td colspan='2' id="c_d_attachment"></td>
                                <td class='bg-info'>Summary</td>
                                <td colspan='4' id="c_d_summary"></td>
                            </tr>
                        </table>
                    </div>

                    <?php //endforeach;
                    ?>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </form>

        </div>
    </div>