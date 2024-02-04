<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmBGVCandidate" action="<?php echo base_url(); ?>dfr/updateBGV" data-toggle="validator" method='POST' enctype="mulipart/form-data">

                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Candidate BGV</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" class="form-control" required>
                    <input type="hidden" id="c_id" name="c_id" class="form-control" required>

                    <div class="row" id="bgvdat">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Is BGV?</label>
                                <select class="form-control" id="is_bgv_verify" name="is_bgv_verify">
                                    <option value="">-Select-</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                        <!--				<div class="col-md-6">
					<div class="form-group">
						<label>Upload Document</label>
                                                <input type="file" class="form-control" id="bgv_document" name="bgv_document" >
					</div>
				</div>-->
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" class="btn btn-primary frmSaveButton" value="Save">
                </div>

            </form>

        </div>
    </div>