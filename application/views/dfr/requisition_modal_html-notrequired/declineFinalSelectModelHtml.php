<div class="modal-dialog">
      <div class="modal-content">
         <form class="frmDeclineFinalSelect" action="<?php echo base_url(); ?>dfr/candidate_final_decline" data-toggle="validator" method='POST'>
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">Decline Final Selection</h4>
            </div>
            <div class="modal-body">
               <input type="hidden" id="r_id" name="r_id" value="">
               <input type="hidden" id="c_id" name="c_id" value="">
               <input type="hidden" id="c_status" name="c_status" value="">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Decline Comment</label>
                        <textarea class="form-control" id="approved_comment" name="approved_comment" required></textarea>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <input type="submit" name="submit" id='declineApproval' class="btn btn-primary" value="Save">
            </div>
         </form>
      </div>
   </div>


   