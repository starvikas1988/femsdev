 <div class="modal-dialog" style="width:90%;position: absolute;left:90px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ta_CertificateUpdateLabel">Edit Certificate Details</h4>
            </div>		
            <form id="frm_CertificateUpdate" autocomplete="off" method='POST' action="<?php echo base_url(); ?>Course_modal_con/certificate_update_info" enctype="multipart/form-data">		
                <div class="modal-body">
                    <input type="hidden" id="course_id" name="course_id" value="<?=$course_id?>" >					
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="office_id">Certificate Name <span class="red_bg">*</span></label>
                                <input class="form-control" name="certification_name" id="c_certification_name" type="text" required>
                            </div>
                        </div>							
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="process_id">CC Mails (Comma Separated)</label>
                                <input class="form-control" name="certification_cc" id="certification_cc" type="text" value=""  placeholder="example@fusionbposervices.com" >
                            </div>
                        </div>
                    </div>

                    <div class="signature-widget">
                        <p>
                            <strong>Signature 1</strong>
                        </p>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Search Id <span class="red_bg">*</span></label>
                                    <input  type="text" class="form-control" name="position_first_id" placeholder="Example. FKOL019028" id="edit_position_first_id" class="position_first_id" required onfocusout ="checkIDd('position_first_id')">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Details</label>
                                    <input type="text" class="form-control" readonly id="view_position_first_id">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Signature Upload <span class="red_bg">*</span></label>
                                    <input  type="file" class="form-control" id="position_first_file" name="position_first_file" required accept="image/*">
                                </div>
                            </div> 
                            <div class="col-sm-2">
                                <img width="100%">
                            </div> 
                        </div>
                       
                        <hr>
                    </div>

                    <div class="signature-widget">
                        <p>
                            <strong>Signature 2</strong>
                        </p>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Search Id <span class="red_bg signature_2_disabled" style="display:none;">*</span></label>
                                    <input  type="text" class="form-control" name="position_snd_id" placeholder="Example. FKOL019028" id="edit_position_snd_id" class="position_snd_id"  onfocusout ="checkIDd('position_snd_id')">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Details</label>
                                    <input type="text" class="form-control" readonly id="view_position_snd_id">
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Signature Upload <span class="red_bg signature_2_disabled" style="display:none;">*</span></label>
                                    <input  type="file" id="position_snd_file" class="form-control" name="position_snd_file" accept="image/*">
                                </div>
                            </div> 
                            <div class="col-sm-2">
                                <img width="100%">
                            </div>
                        </div>
                        <hr>                        
                    </div>

                    <!--<div class="signature-widget">
                        <p>
                            <strong>Signature 3</strong>
                        </p>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Search Id</label>
                                    <input  type="text" class="form-control" name="position_thrd_id" id="edit_position_thrd_id" class="position_thrd_id" onfocusout ="checkIDd('position_thrd_id')">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Details</label>
                                    <input type="text" class="form-control" readonly id="view_position_thrd_id">
                                </div>
                            </div> 
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Third Position Signature Upload*</label>
                                    <input  type="file" id="position_thrd_file" class="form-control" name="position_thrd_file" accept="image/*">
                                </div>
                            </div> 
                             <div class="col-sm-2">
                                <img width="100%">
                            </div>
                        </div>                       
                        <hr>
                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="updateCertificate" disabled class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>