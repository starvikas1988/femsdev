<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmApprovalWfm" action="<?php echo base_url(); ?>dfr/approved_requisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Approved Requisition</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="deptid" name="deptid" value="">
                    <input type="hidden" id="raisedby" name="raisedby" value="">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Assigned Assets</label>
                            </div>
                        </div>
                        <?php
                        if (count($asset_approved->result()) > 0) {
                            foreach ($asset_approved->result() as $approved) {
                        ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm success assets"><?php echo $approved->name; ?>
                                            <span style="background: #fd8000;color: white;width: 40px;display: inline-block;height: 18px;border-radius: 50%;text-align: center;position: absolute;top: 7px;right: 0px;"><?php echo $approved->assets_required; ?></span>
                                        </button>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <button type="button" class="btn btn-sm default no_assets">No Assets Assigned</button>
                        <?php
                        }
                        ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Approval Remarks</label>
                                <textarea class="form-control" id="approved_comment" name="approved_comment" placeholder="Remarks Here...." required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" id='wfmApproval' class="btn btn-primary" value="Save">
                </div>

            </form>

        </div>
    </div>