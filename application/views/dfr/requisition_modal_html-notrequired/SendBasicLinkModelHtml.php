<div class="modal-dialog">
    <div class="modal-content">
        <form class="frmSendBasicLink" action="<?php echo base_url(); ?>dfr/send_basic_link" data-toggle="validator" method='POST' enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                <h4 class="modal-title" id="myModalLabel">Add Candidate to Send Link</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="link_rid" name="rid" value="" required>
                <input type="hidden" id="link_role_id" name="role_id" value="">
                <input type="hidden" id="pool_location" name="pool_location" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Requisition Code</label>
                            <input type="text" readonly id="link_requisition_id" name="requisition_id" class="form-control" value="" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name <span class="red_bg">*</span></label>
                            <input type="text" id="link_fname" name="fname" class="form-control" value="" placeholder="Enter First name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Last Name</label>
                            <input type="text" id="link_lname" name="lname" class="form-control" value="" placeholder="Enter Last name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email <span class="red_bg">*</span></label>
                            <!-- <input type="text" id="link_email" name="email" class="form-control" value="" placeholder="Enter Email" required > -->
                            <input type="email" id="first_email" name="email" class="form-control" value="" placeholder="Enter Email" onfocusout="checkemail('first');" required>
                            <span id="first_email_status" style="color:red;font-size:10px;"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone <span class="red_bg">*</span></label>
                            <?php
                            if ($dfr_location == 'ALB') {
                                $phone_length = '10';
                            } else {
                                $phone_length = '10';
                            }
                            // echo $dfr_location;
                            ?>
                            <input type="text" id="first_phone" name="phone" class="form-control checkNumber" value="" placeholder="Enter phone" onfocusout="checkphone(<?php echo $phone_length; ?>,'first')">
                            <span id="first_phone_status" style="color:red;font-size:10px;"></span>
                        </div>
                    </div>
                </div>


                <?php
                if (isIndiaLocation($dfr_location) == true) {
                    $disCss = '';
                    //$reqCss="";
                    $reqCss = 'required';
                } else {
                    $disCss = 'display:none;';
                }
                ?>
                <div class="row" style="<?php echo $disCss; ?>">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Onboarding Type <span class="red_bg">*</span></i></label>
                            <select id="onboarding_typ" name="onboarding_typ" class="form-control" "<?php echo $reqCss; ?>">
                                <option value="">-- Select type --</option>
                                <option value="Regular">Regular</option>
                                <option value="NAPS">NAPS</option>
                                <option value="Stipend">Stipend</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company <span class="red_bg">*</span></label>
                            <select id="company" name="company" class="form-control" "<?php echo $reqCss; ?>">
                                <option value="">-- Select company --</option>
                                <?php foreach ($company_list as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>
                <?php if ($offc_location == 'Chandigarh') { ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Site</label>
                                <select name="site" class="form-control site">
                                    <?php foreach ($site_list as $site) { ?>
                                        <option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                <?php } ?>



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                <button type="submit" id='btnSendBasicLink' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
            </div>

        </form>

    </div>
</div>