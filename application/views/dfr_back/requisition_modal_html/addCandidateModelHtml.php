<div class="modal-dialog modal-lg">
   <div class="modal-content">
      <form class="frmAddCandidate" action="<?php echo base_url(); ?>dfr/add_candidate" data-toggle="validator" method='POST' enctype="multipart/form-data">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add Candidate Details</h4>
         </div>
         <div class="modal-body">
            <input type="hidden" id="r_id" name="r_id" value="">
            <input type="hidden" id="office_loc" name="office_loc" value="<?php echo $dfr_location; ?>">
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Requisition Code</label>
                     <input type="text" readonly id="requisition_id" name="requisition_id" class="form-control" value="">
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>First Name <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="text" id="fname" name="fname" class="form-control" value="" placeholder="Enter First name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" required>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Last Name</label>
                     <input type="text" id="lname" name="lname" class="form-control" value="" placeholder="Enter Last name" onkeypress="return /[a-z]/i.test(event.key)">
                  </div>
               </div>
            </div>
            <?php if ($dfr_location == 'CHA') { ?>
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>
                     <strong>Guardian's Name(Father/Mother/Husband) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></strong>
                     </label>
                     <input type="text" name="guardian_name" class="form-control" required placeholder="Guardian's Name">
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>
                     <strong>Relation With Guardian</strong> <i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
                     </label>
                     <select name="relation_guardian" class="form-control" required>
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
            <div class="row">
               <div class="col-md-9">
                  <div class="form-group">
                     <label for="exampleInputEmail1">
                     <span id="dis_cont_other">
                     Do you know anyone in Fusion / Are you applying through any Fusion / Xplore-Tech Employee?
                     </span>
                     <span id="dis_cont_cha" style="display: none;">
                     Do you know anyone in CSPL / Are you applying through any CSPL Employee?
                     </span>
                     </label>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-check form-check-inline">
                     <input type="checkbox" class="form-check-input" id="referal" name="hiring_source" value="Existing Employee" required>
                     <label class="form-check-label" for="referal">Check Me If Yes</label>
                  </div>
               </div>
            </div>
            <div class="row" id="non_existing_employee">
               <div class="col-md-12">
                  <div class="form-group">
                     <label for="exampleInputEmail1">How you come to know about the vacancy: </label>
                     <div style="display:inline-block">
                        <input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_portal" value="Job Portal">
                        <label class="form-check-label" for="job_source_portal">Job Portal</label>
                     </div>
                     <div style="display:inline-block">
                        <input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_consult" value="Consultancy">
                        <label class="form-check-label" for="job_source_consult">Consultancy</label>
                     </div>
                     <div style="display:inline-block">
                        <input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_callHR" value="Call From HR">
                        <label class="form-check-label" for="job_source_callHR">Call From HR</label>
                     </div>
                     <div style="display:inline-block">
                        <input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_newspaper" value="Newspaper">
                        <label class="form-check-label" for="job_source_newspaper">Newspaper</label>
                     </div>
                     <div style="display:inline-block">
                        <input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_walkin" value="Walkin">
                        <label class="form-check-label" for="job_source_walkin">Walk In</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row" id="not_friend_referal">
               <div class="col-md-12">
                  <div class="form-group">
                     <label id="lebel_ref"></label>                     
                     <select class="form-control" name="ref_name" id="ref_name" style="width:100%">
                        <option></option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="row" id="existing_employee">
               <div class="col-md-4">
                  <div class="form-group">
                     <select class="form-control select-box existing_employee" id="ref_name1" name="ref_name">
                        <option value="">--Select--</option>
                        <?php foreach ($user_list_ref as $ur) { ?>
                        <option value="<?php echo $ur['fusion_id']; ?>"><?php echo $ur['fname'] . ' ' . $ur['lname'] . ' (' . $ur['fusion_id'] . ', ' . $ur['xpoid'] . ')'; ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <input type="text" readonly class="form-control existing_employee" id="refferer" name="ref_id" placeholder="Employee Name" value="">
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <input type="text" readonly class="form-control existing_employee" id="refferer_dept" name="ref_dept" placeholder="Employee Department" value="">
                  </div>
               </div>
            </div>
            <span id="hiring_source_status" style="color:red;padding-bottom:10px;display:inline-block"></span>
            <div class="row">
               <?php if (isUSLocation($dfr_location) != true) { ?>
               <div class="col-md-3">
                  <div class="form-group">
                     <?php
                        if (isIndiaLocation($dfr_location) == true) {
                            echo '<label>Date of Birth (dd/mm/yyyy) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
                        } else {
                            echo '<label>Date of Birth (mm/dd/yyyy) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
                        }
                        ?>
                     <!-- <input type="text" id="dob" name="dob" class="form-control dobdatepicker" value="" placeholder="Enter DOB" autocomplete="off" readonly required> -->
                     <input type="text" id="dob" name="dob" class="form-control dobdatepicker" value="" placeholder="Enter DOB" autocomplete="off" required>
                  </div>
               </div>
               <?php } ?>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Email ID <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="email" id="add_email" name="email" class="form-control" value="" placeholder="Enter Email" onfocusout="checkemail('add');" required>
                     <span id="add_email_status" style="color:red;font-size:10px;"></span>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Gender <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <select class="form-control" id="gender" name="gender" required>
                        <option value="">--Select--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Transgender">Transgender</option>
                        <option value="Other">Other</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-3">
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
            </div>
            <div class="row">
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Phone <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <?php
                        if ($dfr_location == 'ALB') {
                            $phone_length = '8';
                        } else {
                            $phone_length = '10';
                        }
                        ?>
                     <input type="text" id="add_phone" name="phone" class="form-control checkNumber" value="" placeholder="Enter Phone no" onfocusout="checkphone(<?php echo $phone_length; ?>,'add')" required>
                     <span id="add_phone_status" style="color:red;font-size:10px;"></span>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Alternate Phone</label>
                     <?php
                        if ($dfr_location == 'ALB') {
                            $phone_length = '8';
                        } else {
                            $phone_length = '10';
                        }
                        ?>
                     <input type="text" id="alter_phone" name="alter_phone" class="form-control checkNumber" value="" placeholder="Enter Alternate Phone no" onfocusout="checkphone(<?php echo $phone_length; ?>,'alter')">
                     <span id="alter_phone_status" style="color:red;font-size:10px;"></span>
                  </div>
               </div>
               <?php
                  if ($dfr_location == 'KOL') {
                  ?>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>SSN/Aadhaar No</label>
                     <input type="text" class="form-control number-only-no-minus-also" minlength="12" maxlength="12" id="social_security_no_for_candidate" name="social_security_no" onfocusout="checksecurity_for_candidate();">
                     <span id="social_security_no_status_for_candidate" style="color:red;font-size:10px;"></span>
                  </div>
               </div>
               <?php  }  ?>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Skill Set</label>
                     <input type="text" id="skill_set" name="skill_set" class="form-control" value="" placeholder="Enter Skill Set">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6" style="margin-bottom:4px;">
                  <div class="form-group">
                     <label>Experience Level: <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label><br />
                     <div style="display:inline-block">
                        <input class="form-check-input_r" type="radio" name="experience" id="experience_fresh" value="Fresher" checked="checked">
                        <label class="form-check-label" for="experience_fresh">Fresher</label>
                     </div>
                     <div style="display:inline-block">
                        <input class="form-check-input_r" type="radio" name="experience" id="experience_exp" value="Experienced">
                        <label class="form-check-label" for="experience_exp">Experienced</label>
                     </div>
                  </div>
               </div>
               <div class="col-md-6" id="total_experience" style="display:none">
                  <div class="form-group">
                     <label>Total Work Exp.(In Year) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <input type="text" id="total_work_exp" name="total_work_exp" class="form-control" value="0" placeholder="Enter Total Work Exp." onkeyup="checkDec(this);">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label>
                     Field of Interest:
                     <?php if ($dfr_location != 'CHA') { ?>
                     <i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
                     <?php } ?>
                     </label><br />
                     <div style="display:inline-block">
                        <input class="form-check-input_r" type="radio" name="interest" id="interest_voice" value="Voice" checked="checked">
                        <label class="form-check-label" for="interest_voice">Voice</label>
                     </div>
                     <div style="display:inline-block">
                        <input class="form-check-input_r" type="radio" name="interest" id="interest_back" value="Back Office">
                        <label class="form-check-label" for="interest_back">Back Office</label>
                     </div>
                     <div style="display:inline-block">
                        <input class="form-check-input_r" type="radio" name="interest" id="interest_other" value="Other">
                        <label class="form-check-label" for="interest_other">Other</label>
                     </div>
                  </div>
               </div>
               <div class="col-md-6" id="interest_type" style="display:none">
                  <div class="form-group">
                     <input type="text" class="form-control" id="interest_desc" name="interest_desc" placeholder="Describe">
                  </div>
               </div>
            </div>
            <span id="experience_field_of_interest" style="color:red;margin-bottom:4px;display:inline-block"></span>
            <div class="row">
               <div class="col-md-3">
                  <div class="form-group">
                     <label>
                     Country <?php if ($dfr_location != 'CHA') { ?>
                     <i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
                     <?php } ?> </label>
                     <select name="country" id="country" class="form-control" <?php echo ($dfr_location != 'CHA') ? 'required' : ''; ?>>
                        <option value="">--select--</option>
                        <?php
                           foreach ($get_countries as $country) {
                           ?>
                        <option cid="<?php echo $country['id']; ?>" value="<?php echo $country['name']; ?>"> <?php echo $country['name']; ?> </option>
                        <?php
                           }
                           ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>State <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <select class="form-control" id="state" name="state" required></select>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>City <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                     <select class="form-control" id="city" name="city" required></select>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label for="city_other">City other:</label>
                     <input type="text" class="form-control" id="city_other" name="city_other" value="" disabled>
                  </div>
               </div>
            </div>
            <div class="row">
               <?php
                  if ($dfr_location == 'ELS' || $dfr_location == 'JAM') {
                  } else {
                  ?>
               <div class="col-md-2">
                  <div class="form-group">
                     <label>
                     Post Code <?php if ($dfr_location != 'CHA') { ?>
                     <i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
                     <?php } ?></label>
                     <?php
                        // echo $dfr_location;
                        if ($dfr_location == 'MAN' || $dfr_location == 'CEB') {
                            $post_code_length = '4';
                        } else {
                            $post_code_length = '6';
                        } ?>
                     <input type="text" id="postcode" name="postcode" class="form-control checkNumber" value="" placeholder="Enter Postcode" <?php echo ($dfr_location != 'CHA') ? 'required' : ''; ?> onblur="checkPostCode(<?php echo $post_code_length; ?>)">
                     <span id="post_status" style="color:red;font-size:10px;"></span>
                  </div>
               </div>
               <?php
                  } ?>
               <div class="col-md-5">
                  <div class="form-group">
                     <label>
                     Address <?php if ($dfr_location != 'CHA') { ?>
                     <i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
                     <?php } ?></label>
                     <textarea class="form-control" id="address" name="address" placeholder="Enter Address details" <?php echo ($dfr_location != 'CHA') ? 'required' : ''; ?>></textarea>
                  </div>
               </div>
               <div class="col-md-5">
                  <div class="form-group">
                     <label>Summary</label>
                     <textarea class="form-control" id="summary" name="summary" placeholder="Enter Summary details"></textarea>
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
            <div class="row">
               <div class="col-md-6">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text">Upload Resume</span>
                     </div>
                     <div class="custom-file">
                        <input type="file" name="attachment" class="custom-file-input" id="inputGroupFile01" onchange="Filevalidation()" aria-describedby="inputGroupFileAddon01">
                        <label><i class="fa fa-asterisk" style="font-size:10px; color:red"> File should be in .PDF format</i></label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" id='addCandidateDetails' class="btn btn-primary">Save</button>
         </div>
      </form>
   </div>
</div>

<script>
    if (isIndiaLocation(location) == true) {
            //$(".frmAddCandidate #dob").datepicker({dateFormat: 'dd/mm/yy',maxDate: new Date()});
            //$("#dob1").datepicker({dateFormat: 'dd/mm/yy',maxDate: new Date()});


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
            //$(".frmAddCandidate #dob").datepicker({dateFormat: 'mm/dd/yy',maxDate: new Date()});
            //$("#dob1").datepicker({dateFormat: 'mm/dd/yy',maxDate: new Date()});

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