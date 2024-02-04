<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmTransferShortlistedCandidate" action="<?php echo base_url(); ?>dfr/CandidateTransfer" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Candidate Transfer</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" class="form-control">
                    <input type="hidden" id="c_id" name="c_id" class="form-control">
                    <input type="hidden" id="c_status" name="c_status" class="form-control">
                    <input type="hidden" name="req_id" id="req_id" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>List of Requisition</label>
                                <!--<select class="form-control" id="req_id" name="req_id">
                                        <option value="">-Select-</option>
                                        <option value="0">Pool</option>
                                            <?php foreach ($getrequisition as $row) { ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['req_desc']; ?></option>
                                            <?php } ?>
                                </select>-->
                                <input type="text" name="search_req" id="search_req" class="form-control" placeholder="Type Requisition Number">
                                <div id="searchList"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left:8px" id="req_details">

                    </div>

                    </br></br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Transfer Comment</label>
                                <textarea class="form-control" id="transfer_comment" name="transfer_comment"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" class="btn btn-primary" value="Save">
                </div>

            </form>

        </div>
    </div>