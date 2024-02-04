<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmDeclineWfm" action="<?php echo base_url(); ?>dfr/decline_requisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Decline Requisition</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Decline Remarks</label>
                                <textarea class="form-control" id="approved_comment" name="approved_comment" placeholder="Remarks Here...." required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='wfmDecline' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>