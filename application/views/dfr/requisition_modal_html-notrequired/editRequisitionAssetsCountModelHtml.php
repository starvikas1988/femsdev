<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="frmEditAssetsRequisition" action="<?php echo base_url(); ?>dfr/edit_assets_requisition" data-toggle="validator" method='POST'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Requisition Assets</h4>
                </div>
                <div class="modal-body filter-widget">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="requisition_id" name="requisition_id" value="">
                    <input type="hidden" id="assets" name="assets" value="">
                    <div class="row assets_count_dat" style="display:none;"></div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id='editRequisitionAssets' class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>