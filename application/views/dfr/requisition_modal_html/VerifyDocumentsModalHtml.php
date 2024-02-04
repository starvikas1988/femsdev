<div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form class="frmVerifyDocuments" action="<?php echo base_url(); ?>dfr/verifyDocuments" data-toggle="validator" method='POST'>
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">Verify Document</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div id='VerifyDocumentsContent' class="col-md-12">
                  </div>
               </div>
               <div id="certify_documents_div" class="row">
                  <div class="col-md-12" style="color:darkgreen;font-weight:bold;">
                     <input type="hidden" id="r_id" name="r_id" class="form-control" required>
                     <input type="hidden" id="c_id" name="c_id" class="form-control" required>
                     <input type="checkbox" id="is_verify_doc" name="is_verify_doc" value='1' required>
                     I certify that the documents uploaded by candidate are valid and verified by me. .
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <input id="verify_submit_btn" type="submit" name="submit" class="btn btn-primary" value="Save">
            </div>
         </form>
      </div>
   </div>