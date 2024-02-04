<div class="modal-dialog">
      <div class="modal-content">
         <form class="frmdropCandidate" action="<?php echo base_url(); ?>dfr/CandidateDrop" data-toggle="validator" method='POST'>
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">Drop Candidate</h4>
            </div>
            <div class="modal-body">
               <input type="hidden" id="r_id" name="r_id" class="form-control" required>
               <input type="hidden" id="c_id" name="c_id" class="form-control" required>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Are you sure you want to drop this candidate ?</label>
                        <select class="form-control" id="is_drop" name="is_drop" required>
                           <option value="">-Select-</option>
                           <option value="Y">Yes</option>
                        </select>
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