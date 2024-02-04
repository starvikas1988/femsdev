<div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <form class="frmfinalSelection" action="<?php echo base_url(); ?>dfr/candidate_select_employee" onsubmit="return finalselection()" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Candidate as Employee</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="r_id" name="r_id">
                    <input type="hidden" id="c_id" name="c_id">
                    <input type="hidden" id="hiring_source" name="hiring_source">
                    <input type="hidden" id="address" name="address">
                    <input type="hidden" id="country" name="country">
                    <input type="hidden" id="state" name="state">
                    <input type="hidden" id="city" name="city">
                    <input type="hidden" id="postcode" name="postcode">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Location</label>
                                <!--<select class="form-control" id="location" name="office_id">
                                        <option>--select--</option>
                                <?php //foreach($get_site_location as $sl):
                                ?>
                                                <option value="<?php //echo $sl['abbr'];
                                                                ?>"><?php //echo $sl['location'];
                                                                    ?></option>
                                <?php //endforeach;
                                ?>
                                </select>-->
                                <input type="text" readonly class="form-control" id="location" name="office_id">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control" id="department_id" name="dept_id" required>
                                    <option value="">--Select--</option>
                                    <?php foreach ($get_department_data as $dept) { ?>
                                        <option value="<?php echo $dept['id']; ?>"><?php echo $dept['shname']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sub Department</label>
                                <select class="form-control" id="sub_dept_id" name="sub_dept_id">
                                    <option value="">--Select--</option>
                                    <?php foreach ($sub_department_list as $sub_dept) { ?>
                                        <option value="<?php echo $sub_dept['id']; ?>"><?php echo $sub_dept['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--<div class="col-md-3">
                                <div class="form-group">
                                        <label>Password</label>
                                        <input type="text" readonly id="passwd" name="passwd" class="form-control" value='fusion@123'>
                                </div>	
                        </div>-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Emp ID/XPO ID</label>
                                <input type="text" id="xpoid" name="xpoid" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <?php
                                if (isIndiaLocation($dfr_location) == true) {
                                    echo '<label>Joining Date (dd/mm/yyyy)</label>';
                                } else {
                                    echo '<label>Joining Date (mm/dd/yyyy)</label>';
                                }
                                ?>

                                <input type="text" id="d_o_j" name="doj" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">


                            <div class="form-group">
                                <?php
                                if (isIndiaLocation($dfr_location) == true) {
                                    echo '<label>Date of Birth (dd/mm/yyyy)</label>';
                                } else {
                                    echo '<label>Date of Birth (mm/dd/yyyy)</label>';
                                }
                                ?>
                                <input type="text" id="d_o_b" name="dob" class="form-control" required>

                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" id="fname" name="fname" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" id="lname" name="lname" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Gender</label>
                                <select id="gender" name="sex" class="form-control" required>
                                    <option value="">--Select--</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">

                            <div class="form-group">
                                <label>Class/Batch Code</label>
                                <input type="text" id="batch_code" name="batch_code" class="form-control">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Father's/Husband's Name</label>
                                <?php
                                if (isIndiaLocation($dfr_location) == true) {
                                    echo "<input type='text' class='form-control' minlength='3' id='father_husband_name' name='father_husband_name' required>";
                                } elseif ($dfr_location == 'ELS') {
                                    echo "<input type='text' class='form-control' id='father_husband_name' name='father_husband_name'>";
                                } else {
                                    echo "<input type='text' class='form-control' id='father_husband_name' name='father_husband_name'>";
                                }
                                ?>
                            </div>
                        </div>
                        <!-- goutam added for new requirement by Sankha da on 06/07/2022 -->



                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Relation</label>

                                <?php
                                if (isIndiaLocation($dfr_location) == true) {
                                    echo "<select id='relation' name='relation' class='form-control' required>";
                                } elseif ($dfr_location == 'ELS') {
                                    echo "<select id='relation' name='relation' class='form-control'>";
                                } else {
                                    echo "<select id='relation' name='relation' class='form-control' >";
                                }
                                ?>
                                <option>--Select--</option>
                                <option value="Father">Father</option>
                                <option value="Husband">Husband</option>
                                <option value="Mother">Mother</option>
                                <option value="Wife">Wife</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2" id="mother_name_div" style="display:none;">
                            <div class="form-group">
                                <label>Mother name:</label>
                                <input type="text" id="mother_name" name="mother_name" class="form-control" value="" placeholder="Enter your mother name">
                                <span id="mother_name_status" style="color:red;font-size:10px;"></span>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Marital Status</label>

                                <?php
                                if ($dfr_location == 'ELS') {
                                    echo "<select id='marital_status' name='marital_status' class='form-control'>";
                                } else {
                                    echo "<select id='marital_status' name='marital_status' class='form-control' required>";
                                }
                                ?>
                                <option>--Select--</option>
                                <option value="Married">Married</option>
                                <option value="UnMarried">Un-Married</option>
                                <option value="Widow">Widow</option>
                                <option value="Widower">Widower</option>
                                <option value="Divorcee">Divorcee</option>

                                </select>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nationality</label>
                                <select id="nationality" name="nationality" class="form-control" required>
                                    <option value="">--Select--</option>
                                    <?php foreach ($get_countries as $country) { ?>
                                        <option value="<?php echo $country['name']; ?>"><?php echo $country['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2" id="caste_main">
                            <div class="form-group">
                                <label for="caste">Caste : </label>
                                <select class="form-control" id="caste" name="caste">
                                    <option value="">--select--</option>
                                    <option value="General">General</option>
                                    <option value="SC">SC</option>
                                    <option value="ST">ST</option>
                                    <option value="OBC">OBC</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Select a Designation</label>
                                <select id="role_id" name="role_id" class="form-control" required>
                                    <option>--Select--</option>
                                    <?php foreach ($role_list as $role) { ?>
                                        <option value="<?php echo $role->id; ?>" param="<?php echo $role->org_role; ?>"><?php echo $role->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Select Role Organization</label>
                                <select id="org_role_id" name="org_role_id" class="form-control">
                                    <option>--Select--</option>
                                    <?php foreach ($organization_role as $org_role) { ?>
                                        <option value="<?php echo $org_role->id; ?>"><?php echo $org_role->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Assign Level-1 Supervisor</label>
                                <select id="assigned_to" name="assigned_to" style="width:100%" class="form-control" required>
                                    <option value="">--Select--</option>
                                    <?php foreach ($tl_list as $tl) { ?>
                                        <option value="<?php echo $tl->id; ?>"><?php echo $tl->tl_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="check_payroll">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="client">Select Payroll Type</label>
                                <select class="form-control" name="payroll_type" id="payroll_type" required>
                                    <option value=''>-- Select Payroll Type --</option>
                                    <?php foreach ($payroll_type_list as $payroll_type) { ?>
                                        <option value="<?php echo $payroll_type['id']; ?>"><?php echo $payroll_type['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="client">Select Payroll Status</label>
                                <select class="form-control" name="payroll_status" id="payroll_status">
                                    <option value=''>-- Select Payroll Status --</option>
                                    <?php foreach ($payroll_status_list as $payroll_status) { ?>
                                        <option value="<?php echo $payroll_status['id']; ?>"><?php echo $payroll_status['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="grosspay">Gross Pay</label>
                                <input type="text" class="form-control" id="grosspay" placeholder="Gross Pay" name="grosspay" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <input type="text" class="form-control" id="currency" placeholder="Currency" name="currency" readonly>
                            </div>
                        </div>

                    </div>


                    <div class="row" id="stop_payroll" style="display:none;">
                        <input name="payroll_type" value="0" type="hidden">
                        <input name="payroll_status" value="0" type="hidden">
                        <input name="grosspay" value="0" type="hidden">
                        <input name="currency" value="" type="hidden">
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="client_div">
                                <label for="client_id">Select Client(s)</label>
                                <select class="form-control" style="width:100%; height:100px" name="client_id[]" id="client_id" multiple="multiple">
                                    <?php foreach ($client_list as $client) { ?>
                                        <option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="process_div">
                                <label for="process_id">Select Process(s)</label>
                                <select class="form-control" style="width:100%; height:100px" name="process_id[]" id="process_id" multiple="multiple">
                                    <?php foreach ($process_list as $process) { ?>
                                        <option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Email ID (Personal)</label>
                                <input type="email" pattern="[A-z0-9._%+-]+@[A-z0-9.-]+\.[A-z]{2,}$" data-error="Invalid email address" class="form-control email" id="email" placeholder="Email ID Personal" name="email_id_per" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Email ID (Office)</label>
                                <input type="email" data-error="Invalid email address" class="form-control" id="email_id_off" placeholder="Email ID Office" name="email_id_off" pattern="[A-z0-9._%+-]+@[A-z0-9.-]+\.[A-z]{2,}$">
                            </div>
                        </div>


                        <?php
                        // GET PHONE PATTERNS

                        $phone_patern = '9,10';

                        if (($dfr_location == 'CEB') && ($dfr_location == 'MAN')) {
                            $phone_patern = '9,10'; // for 10 11 digits
                        }
                        if ($dfr_location == 'ALB') {
                            $phone_patern = '8';  // for 8 digits
                        }
                        if ($dfr_location == 'UKL') {
                            $phone_patern = '9,10';  // for 10 11 digits
                        }
                        ?>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="phone">Phone No</label>
                                <input type="text" pattern="[0-9]{1}[0-9]{<?php echo $phone_patern; ?>}" class="form-control" id="phone" placeholder="Phone No" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="phone_emar">Phone No (Emergency)</label>
                                <input type="text" pattern="[0-9]{1}[0-9]{<?php echo $phone_patern; ?>}" class="form-control" id="phone_emar" placeholder="Phone No" name="phone_emar">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php if (($dfr_location != 'ALB') && ($dfr_location != 'UKL')) { ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <!--DUI -->
                                    <?php
                                    if (isIndiaLocation($dfr_location) == true) {
                                        $reqCss = 'required';
                                    } else {
                                        $reqCss = '';
                                    }

                                    if ($dfr_location == 'ELS') {
                                        echo "<label for='pan_no'>NIT</label>";
                                    } elseif ($dfr_location == 'JAM') {
                                        echo '<label >TRN No.</label>';
                                    } else {
                                        echo "<label for='pan_no'>TAX/PAN Number</label>";
                                    }
                                    ?>
                                    <input type="text" class="form-control" id="pan_no" name="pan_no" <?php echo $reqCss; ?> onfocusout="checkpan();">
                                    <span id="pan_status" style="color:red;font-size:10px;"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <?php
                                    if ($dfr_location == 'ELS') {
                                        echo "<label for='uan_no'>AFP</label>";
                                    } elseif ($dfr_location == 'JAM') {
                                        echo "<label for='uan_no'>NIT</label>";
                                    } else {
                                        echo "<label for='uan_no'>UAN(EPF) Number</label>";
                                    }
                                    ?>
                                    <input type="text" class="form-control" id="uan_no" name="uan_no" onfocusout="checkuan();">
                                    <span id="uan_status" style="color:red;font-size:10px;"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <?php
                                    if ($dfr_location == 'ELS') {
                                        echo '<label>ISSS</label>';
                                    } elseif ($dfr_location == 'JAM') {
                                        echo '<label>NIS</label>';
                                    } else {
                                        echo '<label>Existing ESI No</label>';
                                    }
                                    ?>

                                    <input type="text" class="form-control" id="esi_no" name="esi_no">
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-3">
                            <div class="form-group">
                                <?php
                                if ($dfr_location == 'ELS') {
                                    echo "<label  style='font-size:12px'>National ID</label>";
                                    $required = '';
                                    $length = '';
                                } elseif ($dfr_location == 'JAM') {
                                    echo "<label  style='font-size:12px'></label>";
                                    $required = '';
                                    $length = '';
                                } elseif (isIndiaLocation($dfr_location) == true) {
                                    echo "<label  style='font-size:12px'>Social Security No / Aadhaar No</label>";
                                    $required = 'required';
                                } elseif (get_user_office_id() == 'UKL') {
                                    echo "<label  style='font-size:12px'>National Insurance Number</label>";
                                    $required = 'required';
                                } else {
                                    echo "<label  style='font-size:12px'>Social Security No / Aadhaar No</label>";
                                    $required = 'required';
                                }
                                ?>
                                <input type="text" class="form-control" id="social_security_no" name="social_security_no" <?php echo $required; ?> onfocusout="checksecurity();">
                                <span id="social_security_no_status" style="color:red;font-size:10px;"></span>
                            </div>
                        </div>
                        <?php if (isIndiaLocation() == true) { ?>
                            <div class="body-widget">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bank_name">Bank Name</label>
                                            <input type="text" class="form-control email" id="bank_name" placeholder="Bank Name" name="bank_name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="branch_name">Branch</label>
                                            <input type="text" class="form-control" id="branch_name" placeholder="Branch Name" name="branch_name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="acc_type">Account Type</label>
                                            <!-- <input type="text" class="form-control" id="bank_ifsc" placeholder="IFSC CODE" name="bank_ifsc"> -->
                                            <select class="form-control" id="acc_type" name="acc_type">
                                                <option value="Savings">Savings</option>
                                                <option value="Checking">Checking</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bank_acc_no">Account Number</label>
                                            <input type="text" class="form-control" id="bank_acc_no" placeholder="Account No" name="bank_acc_no" onfocusout="checkaccount();">
                                            <span id="bank_acc_no_status" style="color:red;font-size:10px;"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ifsc_code">IFSC Code</label>
                                            <input type="text" class="form-control" id="ifsc_code" placeholder="IFSC CODE" name="ifsc_code">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" id='candidateFinalSelection' class="btn btn-primary" value="Save">
                </div>

            </form>

        </div>
    </div>
    <script>
        $("#client_id").select2();
        $("#process_id").select2();
       if (isIndiaLocation(location) == true) {
            $("#d_o_j").datepicker({
                dateFormat: 'dd/mm/yy',
                minDate: new Date(),
                beforeShow: function(el, dp) {
                    inputField = $(el);
                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();
                }
            });
        } else {
            $("#d_o_j").datepicker({
                dateFormat: 'mm/dd/yy',
                minDate: new Date(),
                beforeShow: function(el, dp) {
                    inputField = $(el);
                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();
                }
            });
        }

        if (isIndiaLocation(location) == true) {
            //$("#d_o_b").datepicker({dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});

            $("#d_o_b").datepicker({
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
            //$("#d_o_b").datepicker({dateFormat: 'mm/dd/yy',changeMonth: true,changeYear: true});

            $("#d_o_b").datepicker({
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



        $('.frmfinalSelection #department_id').change(function() {

            var dept_id = $('.frmfinalSelection #department_id').val();
            //alert(dept_id);

            populate_sub_dept_combo(dept_id);
        });
      
        $('#role_id').change(function() {
            var option = $('option:selected', this).attr('param');
            $('#org_role_id').val(option);
        });
        $("#client_id").change(function() {
            var client_id = $(this).val();
            var URL = '<?php echo base_url(); ?>dfr/select_process';
            $.ajax({
                type: 'GET',
                url: URL,
                data: 'client_id=' + client_id,
                success: function(data) {
                    var a = JSON.parse(data);
                    //var mySelect = $('#process_id');
                    $("#process_id").empty();
                    $.each(a, function(index, jsonObject) {
                        $("select#process_id").append('<option value="' + jsonObject.id + '">' + jsonObject.name + '</option>');
                    });
                },
                error: function() {
                    alert('error!');
                }
            });
        });
      
        $("#candidateFinalSelection").click(function() {
            var off_id = $('.frmfinalSelection #location').val();
            if (off_id == 'KOL') {
                //$('#xpoid').attr("required", "true");
                //alert('please fill the XPOID');
                $('#xpoid').removeAttr("required");
            } else {
                $('#xpoid').removeAttr("required");
            }
        });

    </script>