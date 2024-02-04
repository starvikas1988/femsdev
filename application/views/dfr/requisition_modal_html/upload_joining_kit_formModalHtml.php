<div class="modal-dialog">
      <div class="modal-content">
         <form class="frmjoiningkit" id="frmjoiningkit" action="<?php echo base_url(); ?>base_url().'dfr/upload_joining_kit?" data-toggle="validator" method='POST'>
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">Joining Kit Upload</h4>
            </div>
            <div class="modal-body">
               <input type="hidden" id="r_id" name="r_id" class="form-control">
               <input type="hidden" id="c_id" name="c_id" class="form-control">
               <input type="hidden" id="c_status" name="c_status" class="form-control">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Upload Joining Kit</label>
                        <input type="file" name="joining_kit_pdf" id="joining_kit_pdf" class="form-control" accept=".pdf" required="required">
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