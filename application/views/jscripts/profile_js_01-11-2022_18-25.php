<style>
    .datepicker-modal {
        position: absolute !important;
        top: auto !important;
        left: auto !important;
    }
</style>

<script type="text/javascript">


    var is_done_vac = $('#is_done_vac_edit').val();
    if (is_done_vac == "Yes") {
        $('.vac_yes_edit').show();
        $('#vac_name_edit ,#vac_date_edit ,#vac_dose_edit').attr('required', 'required');
    } else {
        $('.vac_yes_edit').hide();
        $('#vac_name_edit ,#vac_date_edit ,#vac_dose_edit ,#vac_file_edit_new').removeAttr('required');
    }


    $(document).ready(function () {

        var location = "";
<?php if (isset($main_info['office_id'])) { ?>
            location = "<?php echo $main_info['office_id']; ?>";
<?php } else { ?>
            location = "<?php echo get_user_office_id(); ?>";
<?php } ?>

        $('#vac_file,#vac_file_edit_new').change(function () {
            var uploadpath = $(this).val();
            var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
            fileExtension = fileExtension.toLowerCase();
            var size = this.files[0].size;//1000000
            if (size > 1000000) {
                alert('maximum file size exceeded' + size);
                $(this).val('');
            }
            if (fileExtension == "pdf") {

            } else if ((location == 'CEB') && (fileExtension == "jpeg" || fileExtension == "jpg")) {

            } else {
                alert("File type not supported please upload pdf files");
                $(this).val('');
                return false;
            }
        });

        // var is_done_vac=$('#is_done_vac_edit').val();
        // if(is_done_vac == "Yes"){
        // 	$('.vac_yes_edit').show();
        // 	$('#vac_name_edit ,#vac_date_edit ,#vac_dose_edit ,#vac_file_edit_new').attr('required','required');
        // }else{
        // 	$('.vac_yes_edit').hide();
        // 	$('#vac_name_edit ,#vac_date_edit ,#vac_dose_edit ,#vac_file_edit_new').removeAttr('required');
        // }



        var baseURL = "<?php echo base_url(); ?>";
        var fusion_id_db = "";


        if (location == 'CEB') {
            marital_status = $('#marital_status').val();
            if (marital_status === "Unmarried") {
                $('#no_of_children').removeAttr('disabled');
            }
        }


        $("#fdept_id").change(function () {
            var dept_id = $('#fdept_id').val();
            populate_sub_dept_combo(dept_id, '', 'fsub_dept_id', 'Y');
        });

        $("#is_done_vac").change(function () {
            var is_done_vac = $('#is_done_vac').val();
            if (is_done_vac == "Yes") {
                $('.vac_yes').show();
                $('#vac_reason').removeAttr('required');
                $('.vac_no').hide();
                if (location != 'JAM' && location != 'CAS') {
                    $('#vac_file').attr('required', 'required');
                }
                $('#vac_name ,#vac_date ,#vac_dose').attr('required', 'required');
            } else {
                $('.vac_yes').hide();
                $('#vac_name ,#vac_date ,#vac_dose ,#vac_file').val('');
                $('#vac_name ,#vac_date ,#vac_dose ,#vac_file').removeAttr('required');
                if (location == 'CAS') {
                    $('.vac_no').show();
                    $('#vac_reason').attr('required', 'required');
                } else {
                    $('#vac_reason').removeAttr('required');
                    $('.vac_no').hide();
                }
            }
        });


        $("#is_done_vac_edit").change(function () {
            var is_done_vac = $('#is_done_vac_edit').val();
            if (is_done_vac == "Yes") {
                $('.vac_yes_edit').show();
                $('#vac_reason_edit').removeAttr('required');
                $('.vac_no_edit').hide();
                $('#vac_name_edit ,#vac_date_edit ,#vac_dose_edit').attr('required', 'required');
            } else {
                $('.vac_yes_edit').hide();
                $('#vac_name_edit ,#vac_date_edit ,#vac_dose_edit ,#vac_file_edit_new').val('');
                $('#vac_name_edit ,#vac_date_edit ,#vac_dose_edit').removeAttr('required');
                if (location == 'CAS') {
                    $('.vac_no_edit').show();
                    $('#vac_reason_edit').attr('required', 'required');
                } else {
                    $('#vac_reason_edit').removeAttr('required');
                    $('.vac_no_edit').hide();
                }
            }
        });



        $(".editNewVacButton").click(function () {
            var params = $(this).attr("params");
            var did = $(this).attr("did");
            var uid = $(this).attr("uid");
            var arrPrams = params.split("#");
            $('#vac_name_edit').val(arrPrams[1]);
            $('#vac_date_edit').val(arrPrams[0]);
            $('#vac_dose_edit').val(arrPrams[2]);
            $('#vac_file_edit').val(arrPrams[3]);
            $('#is_done_vac_edit').val(arrPrams[4]).trigger('change');
            $('#did').val(did);
            $('#prof_uid_edit').val(uid);
            $('#vac_reason_edit').val(arrPrams[5]);
            $('#editVaccineInfoModal').modal('show');
        });



        $("#fclient_id").change(function () {
            var client_id = $(this).val();
            populate_process_combo(client_id, '', 'fprocess_id', 'Y');
        });
        ////////////////////////////////////	

/////////////////// System Information ///////////////////////////////////
//////

        if (isIndiaLocation(location) == true)
        {
            //$("#doj").datepicker({dateFormat: 'dd/mm/yy',maxDate: new Date()});

            $("#doj").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "c-20:c+0",
                beforeShow: function (el, dp) {
                    inputField = $(el);

                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();

                }

            });

        } else
        {
            //$("#doj").datepicker({dateFormat: 'mm/dd/yy',maxDate: new Date()});

            $("#doj").datepicker({
                dateFormat: 'mm/dd/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "c-20:c+0",
                beforeShow: function (el, dp) {
                    inputField = $(el);

                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();

                }

            });


            $("#dstart").datepicker({
                dateFormat: 'mm/dd/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "c-20:c+20",
                beforeShow: function (el, dp) {
                    inputField = $(el);

                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();

                }

            });

            $("#dend").datepicker({
                dateFormat: 'mm/dd/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "c-20:c+0",
                beforeShow: function (el, dp) {
                    inputField = $(el);

                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();

                }

            });



        }



        //$("#doj").datepicker({maxDate: new Date()});

        if (isIndiaLocation(location) == true)
        {
            $("#dob").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "c-70:c+0",
                beforeShow: function (el, dp) {
                    inputField = $(el);

                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();

                }

            });
        } else
        {
            $("#dob").datepicker({
                dateFormat: 'mm/dd/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "c-70:c+0",
                beforeShow: function (el, dp) {
                    inputField = $(el);

                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();

                }

            });

        }


        if (isIndiaLocation(location) == true)
        {


            $("#dom").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "c-70:c+0",
                beforeShow: function (el, dp) {
                    inputField = $(el);
                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();

                }

            });

        } else
        {
            $("#dom").datepicker({
                dateFormat: 'mm/dd/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "c-50:c+0",
                beforeShow: function (el, dp) {
                    inputField = $(el);

                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();

                }

            });

        }

        $("#client_id").select2();
        $("#exam").select2();
        $("#type_of_lan_known").select2({multiple: true, placeholder: 'Select value...'});
        $("#type_of_lan_known2").select2({multiple: true, placeholder: 'Select value...'});
        $("#process_id").select2();


        $("#dept_id").change(function () {
            var dept_id = $('#dept_id').val();
            populate_sub_dept_combo(dept_id);
            //$("#role_id").val('');
        });



        $(".editHRButton").click(function () {
            $('#editHRInfoModal').modal('show');
        });

        $(".editOfficeButton").click(function () {
            $('#editOfficeInfoModal').modal('show');
        });

        /* $("#btnUpdateHRInfo").click(function(){
         var dept_id=$('#dept_id').val().trim();
         var doj=$('#doj').val().trim();
         var role_id=$('#role_id').val().trim();
         var org_role_id=$('#org_role_id').val().trim(); 
         
         if(dept_id!="" && doj!="" && role_id!="" && org_role_id!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/editHRInfo',
         data	:	$('form.frmEditHRInfo').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#editHRInfoModal').modal('hide');
         location.reload();
         }
         });	
         }else{
         alert("One or More Field(s) are Blank.");
         }	
         }); */

//////////	
        $('#role_id').change(function () {
            var option = $('option:selected', this).attr('param');
            $('#org_role_id').val(option);

        });


        /*------------------- Reporting Head Info Part ------------------------------*/

        $("#is_bod").click(function () {
            if ($('#is_bod').is(':checked')) {
                $('.reporting_head').attr('disabled', 'true');
                $('.btn_search_user').attr('disabled', 'true');
            } else {
                $('.reporting_head').removeAttr('disabled');
                $('.btn_search_user').removeAttr('disabled');
            }
        });

        $(".btn_search_user").click(function () {
            var map = $(this).attr("map");
            $('#userSearchModal').modal('show');
            $('#fetch_user').attr('map', map);
            $("#search_user_rec").html('');
        });

        $(".reporting_head").keydown(function (event) {
            if (event.which == 112) {
                var map = $(this).attr("id");
                $('#userSearchModal').modal('show');
                $('#fetch_user').attr('map', map);
                $("#search_user_rec").html('');
            }
        });

        $(".reporting_head").focusout(function () {
            var URL = '<?php echo base_url(); ?>Profile/getUserName';
            var fid = $(this).val();
            var op_id = $(this).attr("id") + "_name";
            $.ajax({
                type: 'POST',
                url: URL,
                data: 'fid=' + fid,
                success: function (aname) {
                    $("#" + op_id).val(aname);
                },
                error: function () {
                    alert('Fail!');
                }
            });
        });

        $("#fetch_user").click(function () {
            var map = $(this).attr("map");
            var sfname = $('#sfname').val()
            var slname = $('#slname').val()
            var srole = $('#srole').val()
            populate_secrch_user(sfname, slname, srole, map);
        });


        /////////////
        var contrct = $('#emp_status').val();
        if (contrct == 6) {
            $(".startd").prop('required', true);
            $(".endd").prop('required', true);

            $('.startd').show();
            $('.endd').show();
        } else {

            $(".startd").prop('required', false);
            $(".endd").prop('required', false);
            $('.startd').hide();
            $('.endd').hide();
        }


        $('#emp_status').on('change', function () {
            var contrct = $(this).val();

            if (contrct == 6) {
                $(".startd").prop('required', true);
                $(".endd").prop('required', true);

                $('.startd').show();
                $('.endd').show();
            } else {

                $(".startd").prop('required', false);
                $(".endd").prop('required', false);
                $('.startd').hide();
                $('.endd').hide();
            }
        });



        /////////////////////////////////////////////////////////////

/////////////////// Personal Information ///////////////////////////////////
//////

        $("#ph_type").select2();


        $(".editPersonalButton").click(function () {
            $('#editPerInfoModal').modal('show');
        });

        $('#marital_status').on('change', function () {

            if (location == 'CHA' || location == 'CAS') {

                $('#dom').attr('disabled', 'true').removeAttr('required').val("");
                $('#spouse_name').attr('disabled', 'true').removeAttr('required').val("");
                $('#no_of_children').attr('disabled', 'true').removeAttr('required').val("");

            } else if (location == 'CEB') {
                if (this.value === "Unmarried") {
                    $('#no_of_children').removeAttr('disabled');
                }
            } else {

                if (this.value === "Unmarried") {
                    $('#dom').attr('disabled', 'true').removeAttr('required').val("");
                    $('#spouse_name').attr('disabled', 'true').removeAttr('required').val("");
                    $('#no_of_children').attr('disabled', 'true').removeAttr('required').val("");
                } else {
                    $('#dom').removeAttr('disabled').attr('required', 'true');
                    $('#spouse_name').removeAttr('disabled').attr('required', 'true');
                    $('#no_of_children').removeAttr('disabled').attr('required', 'true');
                }
            }
        });

        $('#is_ph').on('change', function () {
            if (this.value === "No") {
                $('#ph_type').attr('disabled', 'true');
                $('#ph_per').attr('disabled', 'true');
            } else {
                $('#ph_type').removeAttr('disabled');
                $('#ph_per').removeAttr('disabled');
            }
        });


        $(document).on('click', '#email_id_off', function () {
            $(document).on('focusout', '#email_id_off', function ()
            {
                var email = $(this).val();
                if (email.length > 0)
                {
                    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@(fusionbposervices.com|vitalsolutions.net|xplore-tech.com|omindtech.com|travelomind.com)$/;
                    if (!(email.toLowerCase().match(validRegex))) {
                        alert("Invalid email address");
                        $('#email_id_off').val('');
                        return false;
                    } else {


                        var datas = {'email': email};
                        // console.log(datas);
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url('email_cleanup/check_email_exist_user'); ?>',
                            data: datas,
                            success: function (msg) {
                                var msg = JSON.parse(msg);
                                // console.log(msg);
                                if (msg.error == 'yes')
                                {
                                    alert("This email id is already registered with MWP");
                                    $('#email_id_off').val('');

                                }
                            }
                        });
                    }
                }

                //alert(email.length);

            });
        });


        $(document).on('click', '#email_id_off_2', function () {
            $(document).on('focusout', '#email_id_off_2', function ()
            {
                var email = $(this).val();
                if (email.length > 0)
                {

                    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@(fusionbposervices.com|vitalsolutions.net|xplore-tech.com|omindtech.com|travelomind.com)$/;
                    if (!(email.toLowerCase().match(validRegex))) {
                        alert("Invalid email address");
                        $('#email_id_off_2').val('');
                        return false;
                    } else {
                        var email_id_off = $('#email_id_off').val();
                        if (email == email_id_off) {
                            alert("Secondary email address can't match Primary email address");
                            $('#email_id_off_2').val('');
                        } else {
                            var datas = {'email': email};
                            // console.log(datas);
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url('email_cleanup/check_email_exist_user'); ?>',
                                data: datas,
                                success: function (msg) {
                                    var msg = JSON.parse(msg);
                                    // console.log(msg);
                                    if (msg.error == 'yes')
                                    {
                                        alert("This email id is already registered with MWP");
                                        $('#email_id_off_2').val('');
                                    }
                                }
                            });
                        }
                    }
                }

                //alert(email.length);

            });
        });

        /* $("#btnEditPersonal").click(function(){
         var dob=$('#dob').val().trim();
         var email_id_off=$('#email_id_off').val().trim();
         
         
         if(dob!="" && email_id_off!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/editPersonal',
         data	:	$('form.frmEditPersonal').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#editPerInfoModal').modal('hide');
         location.reload();
         }
         });	
         }else{
         alert("Date of Birth & Email ID Field(s) are Blank.");
         }	
         }); */
        /////////////////////////////////////////////////////////	

/////////////////// Education Information /////////////////////////////////////
//////
        $(".addNewButton").click(function () {
            $('#addEduInfoModal').modal('show');
        });


        $(".editNewButton").click(function () {
            var params = $(this).attr("params");
            var did = $(this).attr("did");
            var arrPrams = params.split("#");
            $('#did').val(did);

            var selectedValues = arrPrams[6].split(',');
            $('.frmEditEducation #did').val(did);
            $('.frmEditEducation #exam').val(arrPrams[0]).trigger("change");
            $('.frmEditEducation #passing_year').val(arrPrams[1]);
            $('.frmEditEducation #board_uv').val(arrPrams[2]);
            $('.frmEditEducation #specialization').val(arrPrams[3]);
            $('.frmEditEducation #grade_cgpa').val(arrPrams[4]);
            $('.frmEditEducation #training_in_progress').val(arrPrams[5]);
            $('.frmEditEducation #type_of_lan_known2').val(selectedValues).trigger("change");

            $('#editEduInfoModal').modal('show');
        });
        ///////////////////////////////////////////////////





/////////////////// Experience Information /////////////////////////////////////
//////	

        $(function () {
            //$("#from_date").datepicker();
            //$("#to_date").datepicker();
            $("#from_date").datepicker({
                maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-20:c+0",
                beforeShow: function (el, dp) {
                    inputField = $(el);

                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();

                }

            });

            $("#to_date").datepicker({
                maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-20:c+0",
                beforeShow: function (el, dp) {
                    inputField = $(el);

                    inputField.parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();

                }

            });

            //$("#fromdate").datepicker();
            // $("#todate").datepicker();

            $("#fromdate").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-20:c+0"});
            $("#todate").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-20:c+0"});

        });

        $(".addNewExpButton").click(function () {
            $('#addExpInfoModal').modal('show');
        });


        $(".editNewExpButton").click(function () {
            var params = $(this).attr("params");
            var did = $(this).attr("did");
            var arrPrams = params.split("#");
            $('#did').val(did);

            $('.frmEditExpInfo #did').val(did);
            $('.frmEditExpInfo #org_name').val(arrPrams[0]);
            $('.frmEditExpInfo #desig').val(arrPrams[1]);
            $('.frmEditExpInfo #fromdate').val(arrPrams[2]);
            $('.frmEditExpInfo #todate').val(arrPrams[3]);
            $('.frmEditExpInfo #work_exp_year').val(arrPrams[4]);
            $('.frmEditExpInfo #contact').val(arrPrams[5]);
            $('.frmEditExpInfo #job_desc').val(arrPrams[6]);
            $('.frmEditExpInfo #address').val(arrPrams[7]);
            $('.frmEditExpInfo #work_exp_months').val(arrPrams[8]);

            $('#editExpInfoModal').modal('show');
        });


        /* $("#btnEditExpPerInfo").click(function(){
         var did=$('.frmEditExpInfo #did').val().trim();
         var org_name=$('.frmEditExpInfo #org_name').val().trim();
         var desig=$('.frmEditExpInfo #desig').val().trim();
         var period=$('.frmEditExpInfo #period').val().trim();
         var job_desc=$('.frmEditExpInfo #job_desc').val().trim();
         
         if(did!="" && org_name!="" && desig!="" && period!="" && job_desc!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/edit_experience',
         data	:	$('form.frmEditExpInfo').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#editExpInfoModal').modal('hide');
         location.reload();
         }
         });	
         }else{
         alert("One or More Field(s) are Blank.");
         }	
         });	 */
        ////////////////////////////////////////////////////

/////////////////// Skill Information /////////////////////////////////////
//////
        $(".addNewSkillButton").click(function () {
            $('#addSkillsInfoModal').modal('show');
        });

        /* $("#btnAddSkillPerInfo").click(function(){
         var skills=$('#skills').val().trim();
         if(skills!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/add_skills',
         data	:	$('form.frmAddSkillsInfo').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#addSkillsInfoModal').modal('hide');
         location.reload();
         }
         });	
         }else{
         alert("One or More Field(s) are Blank.");
         }	
         }); */


        $(".editSkillButton").click(function () {
            var params = $(this).attr("params");
            var did = $(this).attr("did");
            var arrPrams = params.split("#");
            $('#did').val(did);

            $('.frmEditSkillsInfo #did').val(did);
            $('.frmEditSkillsInfo #skills').val(arrPrams[0]);

            $('#editSkillsInfoModal').modal('show');
        });

        /* $("#btnEditSkillPerInfo").click(function(){
         var did=$('.frmEditSkillsInfo #did').val().trim();
         var skills=$('.frmEditSkillsInfo #skills').val().trim();
         
         if(did!="" && skills!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/edit_skills',
         data	:	$('form.frmEditSkillsInfo').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#editSkillsInfoModal').modal('hide');
         location.reload();
         }
         });	
         }else{
         alert("One or More Field(s) are Blank.");
         }	
         });	 */

        /////////////////////////////////////////////////////

/////////////////// Passport Information /////////////////////////////////////
//////
        $(function () {
            //$("#issue_date").datepicker({maxDate: new Date()});
            $("#issue_date").datepicker();
            //$("#expiry_date").datepicker({minDate: new Date()});
            $("#expiry_date").datepicker();
            $("#vac_date").datepicker();
            $("#vac_date_edit").datepicker();
        });

        $(".addNewPassportButton").click(function () {
            $('#addPassportInfoModal').modal('show');
        });

        $(".addNewVaccineButton").click(function () {
            $('#addVaccineInfoModal').modal('show');
        });

        /* $("#btnAddPassportPerInfo").click(function(){
         var pno=$('.frmAddPassportInfo #pno').val().trim();
         var issue_date=$('.frmAddPassportInfo #issue_date').val().trim();
         var expiry_date=$('.frmAddPassportInfo #expiry_date').val().trim();
         
         if(pno!="" && issue_date!="" && expiry_date!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/add_passportprofile/add_passport',
         data	:	$('form.frmAddPassportInfo').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#addPassportInfoModal').modal('hide');
         location.reload();
         }
         });	
         }else{
         alert("One or More Field(s) are Blank.");
         }	
         }); */

        $(function () {
            //$("#issue_date1").datepicker({maxDate: new Date()});
            $("#issue_date1").datepicker();
            //$("#expiry_date1").datepicker({maxDate: new Date()});
            $("#expiry_date1").datepicker();
        });

        $(".editNewPassButton").click(function () {
            var params = $(this).attr("params");
            var did = $(this).attr("did");
            var arrPrams = params.split("#");
            $('#did').val(did);

            $('.frmEditPassportInfo #did').val(did);
            $('.frmEditPassportInfo #pno').val(arrPrams[0]);
            $('.frmEditPassportInfo #issue_date1').val(arrPrams[1]);
            $('.frmEditPassportInfo #expiry_date1').val(arrPrams[2]);
            $('.frmEditPassportInfo #note').val(arrPrams[3]);

            $('#editPassportInfoModal').modal('show');
        });

        /* $("#btnEditPassportPerInfo").click(function(){
         var did=$('.frmEditPassportInfo #did').val().trim();
         var pno=$('.frmEditPassportInfo #pno').val().trim();
         var issue_date1=$('.frmEditPassportInfo #issue_date1').val().trim();
         var expiry_date1=$('.frmEditPassportInfo #expiry_date1').val().trim();
         
         if(did!="" && pno!="" && issue_date1!="" && expiry_date1!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/edit_passport',
         data	:	$('form.frmEditPassportInfo').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#editPassportInfoModal').modal('hide');
         location.reload();
         }
         });	
         }else{
         alert("One or More Field(s) are Blank.");
         }	
         }); */
        //////////////////////////////////////////////////////

/////////////////// Visa Information /////////////////////////////////////
//////
        $(function () {
            $("#issue_date").datepicker({maxDate: new Date()});
            $("#expiry_date").datepicker({maxDate: new Date()});
        });

        $(".addNewVisaButton").click(function () {
            $('#addVisaInfoModal').modal('show');
        });

        /* $("#btnAddVisaPerInfo").click(function(){
         var vno=$('.frmAddVisaInfo #vno').val().trim();
         var location=$('.frmAddVisaInfo #location').val().trim();
         var issue_date=$('.frmAddVisaInfo #issue_date').val().trim();
         var expiry_date=$('.frmAddVisaInfo #expiry_date').val().trim();
         
         if(vno!="" && location!="" && issue_date!="" && expiry_date!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/add_visa',
         data	:	$('form.frmAddVisaInfo').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#addVisaInfoModal').modal('hide');
         window.location.reload();
         }
         });	
         }else{
         alert("One or More Field(s) are Blank.");
         }	
         }); */



        $(function () {
            $("#issue_date1").datepicker({maxDate: new Date()});
            $("#expiry_date1").datepicker({maxDate: new Date()});
        });

        $(".editNewVisaButton").click(function () {
            var params = $(this).attr("params");
            var did = $(this).attr("did");
            var arrPrams = params.split("#");
            $('#did').val(did);

            $('.frmEditVisaInfo #did').val(did);
            $('.frmEditVisaInfo #vno').val(arrPrams[0]);
            $('.frmEditVisaInfo #location1').val(arrPrams[1]);
            $('.frmEditVisaInfo #issue_date1').val(arrPrams[2]);
            $('.frmEditVisaInfo #expiry_date1').val(arrPrams[3]);
            $('.frmEditVisaInfo #note').val(arrPrams[4]);

            $('#editVisaInfoModal').modal('show');
        });


        /* $("#btnEditVisaPerInfo").click(function(){
         var did=$('.frmEditVisaInfo #did').val().trim();
         var vno=$('.frmEditVisaInfo #vno').val().trim();
         var location1=$('.frmEditVisaInfo #location1').val().trim();
         var issue_date1=$('.frmEditVisaInfo #issue_date1').val().trim();
         var expiry_date1=$('.frmEditVisaInfo #expiry_date1').val().trim();
         
         if(did!="" && vno!="" && location1!="" && issue_date1!="" && expiry_date1!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/edit_visa',
         data	:	$('form.frmEditVisaInfo').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#editVisaInfoModal').modal('hide');
         location.reload();
         }
         });	
         }else{
         alert("One or More Field(s) are Blank.");
         }	
         }); */
        ///////////////////////////////////////////////////////

/////////////////// Bank Information /////////////////////////////////////
//////	
        $(".addNewBankButton").click(function () {
            $('#addBankInfoModal').modal('show');
        });

        /* $("#btnAddBankPerInfo").click(function(){
         var bank_name=$('#bank_name').val().trim();
         var branch=$('#branch').val().trim();
         var acc_no=$('#acc_no').val().trim();
         var ifsc_code=$('#ifsc_code').val().trim();
         
         if(bank_name!="" && branch!="" && acc_no!="" && ifsc_code!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/add_bank',
         data	:	$('form.frmAddBankInfo').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#addBankInfoModal').modal('hide');
         location.reload();
         }
         });	
         }else{
         alert("One or More Field(s) are Blank.");
         }	
         }); */


        $(".editNewBankButton").click(function () {
            var params = $(this).attr("params");
            var did = $(this).attr("did");
            var arrPrams = params.split("#");
            $('#did').val(did);

            $('.frmEditBankInfo #did').val(did);
            $('.frmEditBankInfo #bank_name').val(arrPrams[0]);
            $('.frmEditBankInfo #branch').val(arrPrams[1]);
            $('.frmEditBankInfo #acc_no').val(arrPrams[2]);
            $('.frmEditBankInfo #acc_type').val(arrPrams[3]);
            $('.frmEditBankInfo #ifsc_code').val(arrPrams[4]);

            $('#editBankInfoModal').modal('show');
        });

        /* $("#btnEditBankPerInfo").click(function(){
         var did=$('.frmEditBankInfo #did').val().trim();
         var bank_name=$('.frmEditBankInfo #bank_name').val().trim();
         var branch=$('.frmEditBankInfo #branch').val().trim();
         var acc_no=$('.frmEditBankInfo #acc_no').val().trim();
         var ifsc_code=$('.frmEditBankInfo #ifsc_code').val().trim();
         
         if(did!="" && bank_name!="" && branch!="" && acc_no!="" && ifsc_code!=""){
         $('#sktPleaseWait').modal('show');
         $.ajax({
         type	: 	'POST',    
         url		:	baseURL+'profile/edit_bank',
         data	:	$('form.frmEditBankInfo').serialize(),
         success	:	function(msg){
         $('#sktPleaseWait').modal('hide');
         $('#editBankInfoModal').modal('hide');
         location.reload();
         }
         });	
         }else{
         alert("One or More Field(s) are Blank.");
         }	
         }); */
        ///////////////////////////////////////////////////////






/////////////////// Family Information /////////////////////////////////////
//////
        $("#family_dob").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "-90:+00"});
        $("#e_family_dob").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "-90:+00"});

        $(".addNewFamilyButton").click(function () {
            $('#addFamilyInfoModal').modal('show');
        });
        $("#family_relation").click(function () {
            var selected_frelation = $('#family_relation').val();
            if (selected_frelation == "Others")
            {
                $('#otherRelationDiv').show();
                $("#other_relation").prop('required', true);
            } else {
                $('#otherRelationDiv').hide();
                $("#other_relation").prop('required', false);
            }
        });


        $(".editNewFamilyButton").click(function () {
            var params = $(this).attr("params");
            var did = $(this).attr("did");
            var arrPrams = params.split("#");
            $('#did').val(did);

            $('.frmEditFamily #did').val(did);
            $('.frmEditFamily #e_family_name').val(arrPrams[0]);
            $('.frmEditFamily #e_family_relation').val(arrPrams[1]);
            $('.frmEditFamily #e_family_dob').val(arrPrams[2]);
            $('.frmEditFamily #e_family_phone').val(arrPrams[4]);
            $('.frmEditFamily #e_userid').val(arrPrams[3]);

            // CHECK SELECTION
            var selected_frelation = $('#e_family_relation').val();
            if (selected_frelation == null)
            {
                $('#e_otherRelationDiv').show();
                $("#e_other_relation").val(arrPrams[1]);
                $("#e_other_relation").prop('required', true);
                $('#e_family_relation').val("Others");
            } else {
                $('#e_otherRelationDiv').hide();
                $("#e_other_relation").prop('required', false);
            }

            $('#editFamilyModal').modal('show');
        });

        $("#e_family_relation").click(function () {
            var selected_frelation = $('#e_family_relation').val();
            if (selected_frelation == "Others")
            {
                $('#e_otherRelationDiv').show();
                $("#e_other_relation").prop('required', true);
            } else {
                $('#e_otherRelationDiv').hide();
                $("#e_other_relation").prop('required', false);
            }
        });

///////////////////////////////////////////////////






/////////////////// NOMINEE Information /////////////////////////////////////
//////

        $(".addNewNomineeButton").click(function () {
            $('#addNomineeInfoModal').modal('show');
        });

        $(".frmAddNominee #nominee_relation").click(function () {
            var selected_frelation = $('#nominee_relation').val();
            if (selected_frelation == "Others")
            {
                $('#otherRelationDiv').show();
                $("#other_relation").prop('required', true);
            } else {
                $('#otherRelationDiv').hide();
                $("#other_relation").prop('required', false);
            }
        });

        $(".editNewNomineeButton").click(function () {
            var params = $(this).attr("params");
            var did = $(this).attr("did");
            var arrPrams = params.split("#");
            $('#did').val(did);

            $('.frmEditNominee #did').val(did);
            $('.frmEditNominee #nominee_name').val(arrPrams[0]);
            $('.frmEditNominee #nominee_relation').val(arrPrams[1]);
            $('.frmEditNominee #nominee_state').val(arrPrams[2]);
            $('.frmEditNominee #nominee_district').val(arrPrams[3]);
            $('.frmEditNominee #nominee_address').val(arrPrams[5]);
            $('.frmEditNominee #nominee_pincode').val(arrPrams[4]);
            $('.frmEditNominee #e_userid').val(arrPrams[6]);
            $('.frmEditNominee #nominee_country').val(arrPrams[7]);

            // CHECK SELECTION
            var selected_frelation = $('.frmEditNominee #nominee_relation').val();
            if (selected_frelation == null)
            {
                $('#e_otherRelationDiv').show();
                $("#e_nother_relation").val(arrPrams[1]);
                $("#e_nother_relation").prop('required', true);
                $('.frmEditNominee #nominee_relation').val("Others");
            } else {
                $('#e_otherRelationDiv').hide();
                $("#e_nother_relation").prop('required', false);
            }

            $('#editNomineeModal').modal('show');
        });


        $(".frmEditNominee #nominee_relation").click(function () {
            var selected_frelation = $('.frmEditNominee #nominee_relation').val();
            if (selected_frelation == "Others")
            {
                $('#e_otherRelationDiv').show();
                $("#e_nother_relation").prop('required', true);
            } else {
                $('#e_otherRelationDiv').hide();
                $("#e_nother_relation").prop('required', false);
            }
        });

        $(".frmAddNominee #nominee_state").change(function () {

            var stateid = $('.frmAddNominee #nominee_state').val();
            var baseURL = "<?php echo base_url(); ?>";
            var uUrl = baseURL + 'profile/get_ncity';

            $.ajax({
                url: uUrl,
                cache: false,
                data: {
                    stateid: stateid
                },
                type: 'POST',
                // async:false,
                success: function (response) {
                    //alert(response);	
                    $('.frmAddNominee #nominee_district').html(response);
                }
            });

            //alert(stateid);
        });

        $(".frmEditNominee #nominee_state").change(function () {

            var stateid = $('.frmEditNominee #nominee_state').val();
            var baseURL = "<?php echo base_url(); ?>";
            var uUrl = baseURL + 'profile/get_ncity';

            $.ajax({
                url: uUrl,
                cache: false,
                data: {
                    stateid: stateid
                },
                type: 'POST',
                // async:false,
                success: function (response) {
                    //alert(response);	
                    $('.frmEditNominee #nominee_district').html(response);
                }
            });

            //alert(stateid);
        });



        $(".frmAddNominee #nominee_country").change(function () {

            var stateid = $('.frmAddNominee #nominee_country').val();
            var baseURL = "<?php echo base_url(); ?>";
            var uUrl = baseURL + 'profile/get_nstate';

            $.ajax({
                url: uUrl,
                cache: false,
                data: {
                    countryid: stateid
                },
                type: 'POST',
                // async:false,
                success: function (response) {
                    //alert(response);	
                    $('.frmAddNominee #nominee_state').html(response);
                }
            });

            //alert(stateid);
        });

        $(".frmEditNominee #nominee_country").change(function () {

            var stateid = $('.frmEditNominee #nominee_country').val();
            var baseURL = "<?php echo base_url(); ?>";
            var uUrl = baseURL + 'profile/get_nstate';

            $.ajax({
                url: uUrl,
                cache: false,
                data: {
                    countryid: stateid
                },
                type: 'POST',
                // async:false,
                success: function (response) {
                    //alert(response);	
                    $('.frmEditNominee #nominee_state').html(response);
                }
            });

            //alert(stateid);
        });


///////////////////////////////////////////////////////////////////////////////////




        $('.image-box').hover(
                function () {
                    $('#change-pic').show();
                },
                function () {
                    $('#change-pic').hide();
                }
        );


        $('#change-pic').on('click', function (e) {

            $('#btn-crop').hide();

            $('#changePic').modal(
                    {show: true}
            );

        });

        $('#photoimg').on('change', function ()
        {
            $("#preview-avatar-profile").html('');
            $("#preview-avatar-profile").html('Uploading....');
            $("#cropimage").ajaxForm(
                    {
                        target: '#preview-avatar-profile',
                        success: function (data) {

                            if (data.indexOf("Fail") == -1) {
                                $('#btn-crop').show();

                                $('img#photo').imgAreaSelect({
                                    aspectRatio: '1:1',
                                    onSelectEnd: getSizes,
                                });

                                $('#image_name').val($('#photo').attr('file-name'));

                            }
                        }
                    }).submit();

        });

        $('#btn-crop').on('click', function (e) {
            e.preventDefault();
            params = {
                targetUrl: baseURL + '/Profilepic?action=save',
                action: 'save',
                x_axis: $('#hdn-x1-axis').val(),
                y_axis: $('#hdn-y1-axis').val(),
                x2_axis: $('#hdn-x2-axis').val(),
                y2_axis: $('#hdn-y2-axis').val(),
                thumb_width: $('#hdn-thumb-width').val(),
                thumb_height: $('#hdn-thumb-height').val()
            };

            saveCropImage(params);
        });



        function getSizes(img, obj)
        {
            var x_axis = obj.x1;
            var x2_axis = obj.x2;
            var y_axis = obj.y1;
            var y2_axis = obj.y2;
            var thumb_width = obj.width;
            var thumb_height = obj.height;
            if (thumb_width > 0)
            {

                $('#hdn-x1-axis').val(x_axis);
                $('#hdn-y1-axis').val(y_axis);
                $('#hdn-x2-axis').val(x2_axis);
                $('#hdn-y2-axis').val(y2_axis);
                $('#hdn-thumb-width').val(thumb_width);
                $('#hdn-thumb-height').val(thumb_height);

            } else
                alert("Please select portion..!");
        }

        function saveCropImage(params) {


            jQuery.ajax({
                url: params['targetUrl'],
                cache: false,
                dataType: "html",
                data: {
                    action: params['action'],
                    pid: $('#profile-id').val(),
                    t: 'ajax',
                    w1: params['thumb_width'],
                    x1: params['x_axis'],
                    h1: params['thumb_height'],
                    y1: params['y_axis'],
                    x2: params['x2_axis'],
                    y2: params['y2_axis'],
                    image_name: $('#image_name').val()
                },
                type: 'Post',
                // async:false,
                success: function (response) {


                    $('#changePic').modal('hide');
                    $(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');

                    $("#avatar-edit-img").attr('src', response);
                    $("#preview-avatar-profile").html('');
                    $("#photoimg").val();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
                }
            });
        }
        $(document).on("change", "#pre_country,#per_country", function () {

            //var country		=	$(this).val();
            var country = $("option:selected", this).attr("cid");
            //alert(country);
            var adrs = $(this).data("adrs");

            jQuery.ajax({
                url: baseURL + "profile/stateList",
                type: 'POST',
                data: {country: country},
                dataType: "json",
                success: function (response) {
                    if (response.error == false)
                    {
                        if (response.state_list == "")
                        {
                            if (adrs == "pre")
                            {
                                $("#pre_state").empty();
                                $("#pre_city").empty();
                                $("#pre_state").append($('<option></option>').val('').html('--select--'));
                                $("#pre_city").append($('<option></option>').val('').html('--select--'));
                            } else
                            {
                                $("#per_state").empty();
                                $("#per_city").empty();
                                $("#per_state").append($('<option></option>').val('').html('--select--'));
                                $("#per_city").append($('<option></option>').val('').html('--select--'));
                            }
                        } else
                        {
                            if (adrs == "pre")
                            {
                                $("#pre_state").empty();
                                $("#pre_city").empty();
                                $("#pre_state").append($('<option></option>').val('').html('--select--'));
                                for (var i in response.state_list)
                                {
                                    $('#pre_state').append($('<option sid="' + response.state_list[i].id + '"></option>').val(response.state_list[i].name).html(response.state_list[i].name));
                                }
                                $("#pre_city").append($('<option></option>').val('').html('--select--'));
                            } else
                            {
                                $("#per_state").empty();
                                $("#per_city").empty();
                                $("#per_state").append($('<option></option>').val('').html('--select--'));
                                for (var i in response.state_list)
                                {
                                    $('#per_state').append($('<option sid="' + response.state_list[i].id + '" ></option>').val(response.state_list[i].name).html(response.state_list[i].name));
                                }
                                $("#per_city").append($('<option></option>').val('').html('--select--'));

                                if ($("#same_addr").is(':checked') == true)
                                {
                                    $("#per_state").val($("option:selected", $("#pre_state")).val()).change();
                                }
                            }
                        }
                    }
                }
            });


        });
        $(document).on("change", "#pre_state,#per_state", function () {
            //var state		=	$(this).val();

            var state = $("option:selected", this).attr("sid");
            //alert(state);

            var adrs = $(this).data("adrs");
            jQuery.ajax({
                url: baseURL + "profile/cityList",
                type: 'POST',
                data: {state: state},
                dataType: "json",
                success: function (response) {
                    if (response.error == false)
                    {
                        $("#pre_city").attr("disabled", false);
                        $("#per_city").attr("disabled", false);
                        $("#pre_city_other").attr("disabled", true);
                        $("#per_city_other").attr("disabled", true);
                        if (response.city_list == "")
                        {
                            if (adrs == "pre")
                            {
                                $("#pre_city").empty();
                                $("#pre_city").append($('<option></option>').val('').html('--select--'));
                                $("#pre_city").append($('<option></option>').val('other').html('Other'));
                            } else
                            {
                                $("#per_city").empty();
                                $("#per_city").append($('<option></option>').val('').html('--select--'));
                                $("#per_city").append($('<option></option>').val('other').html('Other'));
                            }
                        } else
                        {
                            if (adrs == "pre")
                            {
                                $("#pre_city").empty();
                                $("#pre_city").append($('<option></option>').val('').html('--select--'));
                                for (var i in response.city_list)
                                {
                                    $('#pre_city').append($('<option></option>').val(response.city_list[i].name).html(response.city_list[i].name));
                                }
                                $("#pre_city").append($('<option></option>').val('other').html('Other'));
                            } else
                            {
                                $("#per_city").empty();
                                $("#per_city").append($('<option></option>').val('').html('--select--'));
                                for (var i in response.city_list)
                                {
                                    $('#per_city').append($('<option></option>').val(response.city_list[i].name).html(response.city_list[i].name));
                                }
                                $("#per_city").append($('<option></option>').val('other').html('Other'));
                                if ($("#same_addr").is(':checked') == true)
                                {
                                    $("#per_city").val($("#pre_city").val()).change();
                                }
                            }
                        }
                    }
                }
            });
        });
        $(document).on("change", "#pre_city,#per_city", function () {
            var adrs = $(this).data("adrs");
            if (adrs == "pre")
            {
                if ($(this).val() == "other")
                {
                    $(this).attr("disabled", true);
                    $("#pre_city_other").attr("disabled", false).attr("required", true);
                } else
                {
                    $("#pre_city_other").attr("disabled", true).removeAttr("required");
                }
            } else
            {
                if ($(this).val() == "other")
                {
                    $(this).attr("disabled", true);
                    $("#per_city_other").attr("disabled", false).attr("required", true);
                } else
                {
                    $("#per_city_other").attr("disabled", true).removeAttr("required");
                }
            }
            if ($('#same_addr').is(':checked') == true && $('#pre_city').val() == "other")
            {
                $('#pre_city').attr("disabled", true);
                $("#pre_city_other").attr("disabled", false);
            }
        });
        $('#same_addr').on("click", function () {
            if ($(this).is(':checked') == true)
            {
                var pre_country = $("#pre_country").val();
                var pre_state = $("#pre_state").val();
                $("#per_country").val(pre_country).change();
                $("#address_permanent").val($("#address_present").val()).val();
                $("#per_state").val($("#pre_state").val()).val();
                $("#per_pin").val($("#pre_pin").val()).val();
                $("#per_city_other").val($("#pre_city_other").val());
            }
        });


//////////////////////////


/////////////

    });
    $(".profUpload").click(function () {
        $("#profileUploadDocu").modal('show');
    });
/////////////////////////////////////////////////////////////////////////////////////

    function checkDec(el) {
        var ex = /^[0-9]+\.?[0-9]*$/;
        if (ex.test(el.value) == false) {
            el.value = el.value.substring(0, el.value.length - 1);
        }
    }

/////////////////////////////////////

    function pad(num, size) {
        var s = "0000000000" + num;
        return s.substr(s.length - size);
    }



    $("#client_id").change(function () {
        var client_id = $(this).val();

        var URL = '<?php echo base_url(); ?>/user/select_process';

        $.ajax({
            type: 'GET',
            url: URL,
            data: 'client_id=' + client_id,
            success: function (data) {
                var res;
                var i = 0;
                var a = JSON.parse(data);

                //$('#process_id option').each(function() {
                //if (this.selected){
                //	$("#process_id option[value='"+ $(this).val() +"']").remove();
                //	alert($(this).text());
                ///	
                //}else{
                //$("#process_id option[value='"+ $(this).val() +"']").remove();
                //}
                //});

                var b = $("#process_id").val();
                $("#process_id option").remove();

                if (b != null) {
                    var res = b.toString().split(',');
                    var leng = res.length;
                }


                $.each(a, function (index, jsonObject) {

                    if (i < leng) {
                        if (jsonObject.id == res[i]) {
                            $("#process_id").append('<option value="' + jsonObject.id + '" selected="selected">' + jsonObject.name + '</option>');
                            i++;
                        } else {
                            $("#process_id").append('<option value="' + jsonObject.id + '">' + jsonObject.name + '</option>');
                        }
                    } else {
                        $("#process_id").append('<option value="' + jsonObject.id + '">' + jsonObject.name + '</option>');
                    }


                });





            },
            error: function () {
                alert('error!');
            }
        });

    });


</script>



<script type="text/javascript">

    $(document).ready(function ()
    {
        var baseURL = "<?php echo base_url(); ?>";

        var uUrl = baseURL + 'profile/upload';

        var settings = {
            url: uUrl,
            dragDrop: true,
            fileName: "myfile",
            allowedTypes: "png,jpeg,jpg,pdf",
            onSuccess: function (files, data, xhr)
            {
                console.log(data);
                var res = JSON.parse(data);
                //console.log(res);
                //console.log('fdfd fdf asdfs');
                if (res.success == 'true')
                {

                    $('[name="exp_id"][value="' + res.exp_id + '"]').parent().parent().prev().html('<a href="<?php echo base_url('../femsdev/pimgs/' . $prof_fid . '/'); ?>/' + res.file_name + '" target="_blank">' + res.file_name + '</a>');
                    location.reload();
                }
                /* if(res.error == false)
                 {
                 location.reload();
                 } */
            },
            onSelect: function (files)
            {
                console.log(files);
                console.log($(this).attr('data-id'));
            },
            onError: function (files, status, message)
            {
                $("#OutputDiv").html(message);

                alert(message);

                //var rUrl=baseURL+'schedule';
                //window.location.href=rUrl;	

            },
            showDelete: false
        }

        $(".file_uploader").each(function (index, element) {
            //var exp_id_value = $(element).find('name="exp_id"').val();
            var ind = $(element).attr('data-id');
            var exp_id_val = $(element).find('[name="exp_id"]').val();
            settings.formData = {exp_id: exp_id_val, prof_fid: '<?php echo $prof_fid; ?>'};
            var uploadObj = $("#mulitplefileuploader" + ind).uploadFile(settings);
        });

    });

</script>

<script type="text/javascript">

    $(document).ready(function ()
    {
        var baseURL = "<?php echo base_url(); ?>";

        var uUrl = baseURL + 'profile/upload';

        var settings = {
            url: uUrl,
            dragDrop: true,
            fileName: "myfile",
            allowedTypes: "png,jpeg,jpg,pdf",
            onSuccess: function (files, data, xhr)
            {
                console.log(data);
                var res = JSON.parse(data);
                //console.log(res);
                //console.log('fdfd fdf asdfs');
                if (res.success == 'true')
                {

                    $('[name="bank_id"][value="' + res.bank_id + '"]').parent().parent().prev().html('<a href="<?php echo base_url('../femsdev/pimgs/' . $prof_fid . '/'); ?>/' + res.file_name + '" target="_blank">' + res.file_name + '</a>');
                    location.reload();
                }
                /* if(res.error == false)
                 {
                 window.location.reload();
                 } */
            },
            onSelect: function (files)
            {
                console.log(files);
                console.log($(this).attr('data-id'));
            },
            onError: function (files, status, message)
            {
                $("#OutputDiv").html(message);

                alert(message);

                //var rUrl=baseURL+'schedule';
                //window.location.href=rUrl;	

            },
            showDelete: false
        }


        $(".file_uploader_bank").each(function (index, element) {
            //var exp_id_value = $(element).find('name="bank_id"').val();
            var ind = $(element).attr('data-id');
            var bank_id_val = $(element).find('[name="bank_id"]').val();
            settings.formData = {bank_id: bank_id_val, prof_fid: '<?php echo $prof_fid; ?>'};
            var uploadObj = $("#mulitplefileuploaderbank" + ind).uploadFile(settings);
        });

    });

</script>

<script type="text/javascript">

    $(document).ready(function ()
    {
        var baseURL = "<?php echo base_url(); ?>";

        var uUrl = baseURL + 'profile/upload';

        var settings = {
            url: uUrl,
            dragDrop: true,
            fileName: "myfile",
            allowedTypes: "png,jpeg,jpg,pdf",
            onSuccess: function (files, data, xhr)
            {
                console.log(data);
                var res = JSON.parse(data);
                //console.log(res);
                //console.log('fdfd fdf asdfs');
                if (res.success == 'true')
                {

                    $('[name="passport_id"][value="' + res.passport_id + '"]').parent().parent().prev().html('<a href="<?php echo base_url('../femsdev/pimgs/' . $prof_fid . '/'); ?>/' + res.file_name + '" target="_blank">' + res.file_name + '</a>');
                    location.reload();
                }
                /* if(res.error == false)
                 {
                 location.reload();
                 } */
            },
            onSelect: function (files)
            {
                console.log(files);
                console.log($(this).attr('data-id'));
            },
            onError: function (files, status, message)
            {
                $("#OutputDiv").html(message);

                alert(message);

                //var rUrl=baseURL+'schedule';
                //window.location.href=rUrl;	

            },
            showDelete: false
        }


        $(".file_uploader_passport").each(function (index, element) {
            //var exp_id_value = $(element).find('name="passport_id"').val();
            var ind = $(element).attr('data-id');
            var passport_id_val = $(element).find('[name="passport_id"]').val();
            settings.formData = {passport_id: passport_id_val, prof_fid: '<?php echo $prof_fid; ?>'};
            var uploadObj = $("#mulitplefileuploaderpassport" + ind).uploadFile(settings);
        });

    });

</script>

<script type="text/javascript">

    $(document).ready(function ()
    {
        var baseURL = "<?php echo base_url(); ?>";

        var uUrl = baseURL + 'profile/upload';

        var settings = {
            url: uUrl,
            dragDrop: true,
            fileName: "myfile",
            allowedTypes: "png,jpeg,jpg,pdf",
            onSuccess: function (files, data, xhr)
            {
                console.log(data);
                var res = JSON.parse(data);
                //console.log(res);
                //console.log('fdfd fdf asdfs');
                if (res.success == 'true')
                {

                    $('[name="education_id"][value="' + res.education_id + '"]').parent().parent().prev().html('<a href="<?php echo base_url('../femsdev/pimgs/' . $prof_fid . '/'); ?>/' + res.file_name + '" target="_blank">' + res.file_name + '</a>');
                    location.reload();
                }
                /* if(res.error == false)
                 {
                 location.reload();
                 } */
            },
            onSelect: function (files)
            {
                console.log(files);
                console.log($(this).attr('data-id'));
            },
            onError: function (files, status, message)
            {
                $("#OutputDiv").html(message);

                alert(message);

                // var rUrl=baseURL+'schedule';
                //window.location.href=rUrl;	

            },
            showDelete: false
        }


        $(".file_uploader_education").each(function (index, element) {
            //var exp_id_value = $(element).find('name="education_id"').val();
            var ind = $(element).attr('data-id');
            var education_id_val = $(element).find('[name="education_id"]').val();
            settings.formData = {education_id: education_id_val, prof_fid: '<?php echo $prof_fid; ?>'};
            var uploadObj = $("#mulitplefileuploadereducation" + ind).uploadFile(settings);
        });

    });

</script>



<script type="text/javascript">

    $(document).ready(function ()
    {
        var baseURL = "<?php echo base_url(); ?>";

        var uUrl = baseURL + 'profile/upload';

        var settings = {
            url: uUrl,
            dragDrop: true,
            fileName: "myfile",
            allowedTypes: "png,jpeg,jpg,pdf",
            onSuccess: function (files, data, xhr)
            {
                console.log(data);
                var res = JSON.parse(data);
                //console.log(res);
                //console.log('fdfd fdf asdfs');
                if (res.success == 'true')
                {

                    $('[name="other_id"][value="' + res.other_id + '"]').parent().parent().prev().html('<a href="<?php echo base_url('../pimgs/' . $prof_fid . '/'); ?>/' + res.file_name + '" target="_blank">' + res.file_name + '</a>');
                    location.reload();
                }
                /* if(res.error == false)
                 {
                 location.reload();
                 } */
            },
            onSelect: function (files)
            {
                console.log(files);
                console.log($(this).attr('data-id'));
            },
            onError: function (files, status, message)
            {
                $("#OutputDiv").html(message);

                alert(message);

                // var rUrl=baseURL+'schedule';
                //window.location.href=rUrl;	

            },
            showDelete: false
        }


        $(".file_uploader_other").each(function (index, element) {
            //var exp_id_value = $(element).find('name="other_id"').val();
            var ind = $(element).attr('data-id');
            var other_id_val = $(element).find('[name="other_id"]').val();
            settings.formData = {other_id: other_id_val, prof_fid: '<?php echo $prof_fid; ?>'};
            var uploadObj = $("#mulitplefileuploaderother" + ind).uploadFile(settings);
        });

    });

</script>

<script>
    $(document).on('submit', '#upload_others', function (e)
    {
        e.preventDefault();


        var form_data = new FormData(this);
        form_data.append('file', '');
        $.ajax({
            url: '<?php echo base_url('profile/upload'); ?>', // point to server-side PHP script 
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            dynamicFormData: function ()
            {
                var prof_fid = $('#prof_fid').val();
                return {
                    'prof_fid': prof_fid
                }
            },
            success: function (response) {
                var res = JSON.parse(response);
                if (res.success == 'true')
                {
                    alert('Thank You For Uploading ' + res.file_name);
                    location.reload();
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('input#bank_name').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z \s]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            } else
            {
                e.preventDefault();
                //alert('This Fields accepts only alphabet');
                return false;
            }
        });
        $('.locked').on("click", function () {
            alert("Please contact with HRD with the hard copy of Cheque / Passbook");
        });
        $("#is_diff_abled").on("change", function () {
            var is_diff_abled = $(this).val();
            if (is_diff_abled == "Yes")
            {
                $("#diff_type").attr("required", true);
                $("#ph_per").attr("required", true);
            } else
            {
                $("#diff_type").attr("required", false);
                $("#ph_per").attr("required", false);
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#agreeTermsModal').on("click", function () {
            $('#personalConsentModal').modal();
        });
    });


    $('.editFileNameButton').click(function () {
        fileName = $(this).attr('ename');
        fileID = $(this).attr('eid');
        $('#fileNameUpdateDocModal input[name="file_id"]').val(fileID);
        $('#fileNameUpdateDocModal input[name="file_type"]').val(fileName);
        $('#fileNameUpdateDocModal').modal('show');
    });
    function check_size(id) {
        dt = $(id).val();
        var size = id.files[0].size;
        if (size > 1000000) {
            alert('File should not be greater than 1 MB ');
            $(id).val('');
        }
    }
</script>

