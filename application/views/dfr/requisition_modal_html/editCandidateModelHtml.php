<div class="modal-dialog modal-lg">
   <div class="modal-content">
      <form class="frmEditCandidate" action="<?php echo base_url(); ?>dfr/edit_candidate" data-toggle="validator" method='POST' enctype="multipart/form-data">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit Candidate</h4>
         </div>
         <div class="modal-body">
            <input type="hidden" id="c_id" name="c_id" value="">
            <input type="hidden" id="r_id" name="r_id" value="">
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Requisition Code</label>
                     <input type="text" readonly id="requisition_id" name="requisition_id" class="form-control" value="">
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Location</label>
                     <input type="text" id="office_location_edit" name="location" class="form-control" value="" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <?php
                        if (isIndiaLocation($dfr_location) == true) {
                            echo '<label>Date of Birth (dd/mm/yyyy) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
                        } else {
                            echo '<label>Date of Birth (mm/dd/yyyy) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
                        }
                        ?>
                     <input type="text" id="dob1" name="dob" class="form-control dobdatepicker" value="" required>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label>First Name <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="text" id="fname" name="fname" class="form-control" value="" required>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Last Name</label>
                     <input type="text" id="lname" name="lname" class="form-control" value="">
                  </div>
               </div>
            </div>
            <?php if ($dfr_location == 'CHA') { ?>
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>
                     <strong>Guardian's Name(Father/Mother/Husband)</strong>
                     </label>
                     <input type="text" name="guardian_name" id="guardian_name" class="form-control" placeholder="Guardian's Name">
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>
                     <strong>Relation With Guardian</strong>
                     </label>
                     <select name="relation_guardian" id="relation_guardian" class="form-control">
                        <option value="">--Select--</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Husband">Husband</option>
                        <option value="Wife">Wife</option>
                     </select>
                  </div>
               </div>
            </div>
            <?php } ?>
            <?php if ($dfr_location == 'KOL') { ?>
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>
                     <strong>Mother Name</strong>
                     </label>
                     <input type="text" name="mother_name" id="edit_mother_name" class="form-control" placeholder="Mother Name">
                     <span id="edit_mother_name_status" style="color:red;font-size:10px;"></span>
                  </div>
               </div>
            </div>
            <?php  } ?>
            <?php if (get_user_fusion_id() == 'FKOL000003') { ?>
            <div class="row">
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Hiring Source <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <select id="hiring_source" name="hiring_source" class="form-control" required>
                        <option value="Existing Emplyee">Existing Emplyee</option>
                        <option value="Job Portal">Job Portal</option>
                        <option value="Consultancy">Consultancy</option>
                        <option value="Call From HR">Call From HR</option>
                        <option value="Newspaper">Newspaper</option>
                        <option value="Walkin">Walkin</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Source Details <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="text" id="ref_name" name="ref_name" class="form-control" required>
                  </div>
               </div>
            </div>
            <?php } else { ?>
            <div class="row">
               <div class="col-md-3" id="hir">
                  <div class="form-group">
                     <label>Hiring Source</label>
                     <input readonly type="text" id="hiring_source" name="hiring_source" class="form-control">
                     <!-- <select id="hiring_source" name="hiring_source" class="form-control">
                        <option value="Existing Emplyee">Existing Emplyee</option>
                        <option value="Job Portal">Job Portal</option>
                        <option value="Consultancy">Consultancy</option>
                        <option value="Call From HR">Call From HR</option>
                        <option value="Newspaper">Newspaper</option>
                        <option value="Walkin">Walkin</option>
                        </select> -->
                  </div>
               </div>
               <div class="col-md-3" id="sorce">
                  <div class="form-group">
                     <label>Source Details</label>
                     <input readonly type="text" id="ref_name" name="ref_name" class="form-control">
                  </div>
               </div>
               <div class="col-md-3 existing" id="existing_employee" style="display: none;">
                  <div class="form-group">
                     <label>Employee Name</label>
                     <select class="existing_employee form-control" id="ref_name1" name="ref_name">
                        <option value="">--Select--</option>
                        <?php foreach ($user_list_ref as $ur) { ?>
                        <option value="<?php echo $ur['fusion_id']; ?>"><?php echo $ur['fname'] . ' ' . $ur['lname'] . ' (' . $ur['fusion_id'] . ', ' . $ur['xpoid'] . ')'; ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-3 not_friend_referal" id="not_friend_referal" style="display: none;">
                  <div class="form-group">
                     <label id="lebel_reff"></label>
                     <!--<input type="text" class="form-control" name="ref_name" id="ref_name" style="width:100%" value="" >-->
                     <select class="form-control" name="ref_name" id="reff_name" style="width:100%">
                        <option></option>
                     </select>
                  </div>
               </div>
            </div>
            <?php } ?>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Email ID <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <!-- <input type="email" id="email" name="email" class="form-control" value="" required> -->
                     <input type="email" id="edit_email" name="email" class="form-control" value="" placeholder="Enter Email" onfocusout="checkemail('edit');" required>
                     <span id="edit_email_status" style="color:red;font-size:10px;"></span>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Gender <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <select class="form-control" id="gender" name="gender" required>
                        <option value="">--Select--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Phone <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <?php
                        if ($dfr_location == 'ALB') {
                            $phone_length = '8';
                        } else {
                            $phone_length = '10';
                        }
                        // echo $dfr_location;
                        ?>
                     <input type="text" id="edit_phone" name="phone" class="form-control checkNumber" placeholder="Enter Phone" value="" onfocusout="checkphone(<?php echo $phone_length; ?>,'edit')" required>
                     <span id="edit_phone_status" style="color:red;font-size:10px;"></span>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Last Qualification <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <select class="form-control" id="last_qualification" name="last_qualification" required>
                        <option value="">--Select Last Qualification--</option>
                        <?php
                           foreach ($qualification_list as $key => $value) {
                               echo '<option value="' . $value->qualification . '">' . $value->qualification . '</option>';
                           }
                           ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Skill Set <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="text" id="skill_set" name="skill_set" class="form-control" value="" required>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Total Work Exp. (In Year) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="text" id="total_work_exp" name="total_work_exp" class="form-control" value="" onkeyup="checkDec(this);" required>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Country <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="text" id="country" name="country" class="form-control" value="" required>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>State <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="text" id="state" name="state" class="form-control" value="" required>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>City <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="text" id="city" name="city" class="form-control" value="" required>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Post Code <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="text" id="postcode" name="postcode" class="form-control" value="" required>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Address <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <textarea class="form-control" id="address" name="address" required></textarea>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Summary</label>
                     <textarea class="form-control" id="summary" name="summary"></textarea>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Onboarding Type <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <select id="onboarding_type" name="onboarding_type" class="form-control" required="required">
                        <option value="">-- Select type --</option>
                        <option value="Regular">Regular</option>
                        <option value="NAPS">NAPS</option>
                        <option value="Stipend">Stipend</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Company <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <select id="company" name="company" class="form-control" required="required">
                        <option value="">-- Select company --</option>
                        <?php foreach ($company_list as $key => $value) { ?>
                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
            </div>
            <div class="site_cspl" style="display: none">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Site</label>
                        <select name="site" class="form-control site">
                           <option>--Select Site--</option>
                           <?php foreach ($site_list as $site) { ?>
                           <option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Edit Upload Resume</label>
                     <input type="file" id="uploadFile" name="attachment" class="form-control" value="" onchange="Filevalidation()">
                     <input type="text" id="attachment" readonly class="form-control" value="">
                     <label><i class="fa fa-asterisk" style="font-size:10px; color:red"> File should be in .PDF format</i></label>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" id='edit_candidate' class="btn btn-primary">Save</button>
         </div>
      </form>
   </div>
</div>
<script>
    if (isIndiaLocation(location) == true) {
            $(".dobdatepicker").datepicker({
                dateFormat: 'dd/mm/yy',
                maxDate: new Date(),
                changeMonth: true,
                changeYear: true,
                yearRange: "c-70:c+0",
                beforeShow: function(el, dp) {
                    inputField = $(el);
                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();
                }

            });
        } else {
            $(".dobdatepicker").datepicker({
                dateFormat: 'mm/dd/yy',
                maxDate: new Date(),
                changeMonth: true,
                changeYear: true,
                yearRange: "c-70:c+0",
                beforeShow: function(el, dp) {
                    inputField = $(el);
                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();
                }
            });
        }
</script>