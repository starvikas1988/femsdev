<div class="modal-dialog">
      <div class="modal-content">
         <form class="frminterviewformupload" id="frminterviewformupload" action="<?php echo base_url(); ?>dfr/uploadInterviewFrom" data-toggle="validator" method='POST' enctype="multipart/form-data">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel" Upload Form</h4>
            </div>
            <div class="modal-body">
               <input type="hidden" id="r_id" name="r_id" class="form-control" required>
               <input type="hidden" id="c_id" name="c_id" class="form-control" required>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <input type="file" name="interview_form" id="interview_form" class="form-control" required accept=".pdf">
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