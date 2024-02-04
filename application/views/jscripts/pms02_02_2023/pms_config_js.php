<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<script>
    $(function () {
        $(".date-picker").datepicker({dateFormat: "dd-mm-yy"});
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    $('.aside-menu .menu-item').click(function (e) {
        $('.aside-menu .menu-item').removeClass("active");
    });
    function setDefaultActive() {
        let URL = window.location.href;
        $("a[href='" + URL + "'").addClass("active");
        $("a[href='" + URL + "'").closest("li").addClass("active");
        $("a[href='" + URL + "'").closest("ul").css("display", "block");
    }

    $(document).ready(function () {
        setDefaultActive();
        let pageName = "<?= $this->uri->segment(2) ?>";
        let appr_id = "<?= $this->uri->segment(3) ?>";
        let fussion_id = "<?= $this->uri->segment(4) ?>";
        switch (pageName) {
//            case("view_pms"):
//                getPmsFormViewPage();
//                break;
            case("teams_performance_sheet"):
                showTeamPerformanceModal();
                break;
            case("performance_sheet"):
                getPmsFormViewPage(appr_id);
                break;
            case("performance_sheet_review"):
                getPmsFormViewPageReview(appr_id, fussion_id);
                break;
            case("pms_qs_set_by_hr"):
                showPerformanceModal();
                break;
            default:
//                getPmsFormViewPage();
                break;
        }
    });
</script>
<script>
//CREATE PROCESS DROPDOWN
    $("#client_id").change(function () {
        $('#sktPleaseWait').modal('show');
        let client_id = $(this).val();
        $.post("<?= base_url() ?>pms_assignment/getProcessDropdown", {client_id: client_id}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data != '') {
                $("#process").html(data);
                $("#process").selectpicker('refresh');
            }

        });
    });
</script>
<script>
    function showPerformanceModal(group_id = '1', sub_group_id = '', appr_id = '', details = 'Y') {
        $('#sktPleaseWait').modal('show');
        if (sub_group_id == '' && group_id != '2') {
            sub_group_id = $("#description_drop").val();
        }
        if (appr_id == '') {
            appr_id = $("#pms_id").val();
        }
        $.post("<?= base_url() ?>pms_assignment/get_performance_question", {sub_group_id: sub_group_id, appr_id: appr_id, details: details, group_id: group_id}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data != '') {
                if (group_id == '1') {
                    $("#mng_performance_competency").text('');
                    $("#mng_performance_competency").html(data);
                    $("#mng_performance_kra").html('');
                } else {
                    $("#mng_performance_kra").html('');
                    $("#mng_performance_kra").html(data);
                    $("#mng_performance_competency").html('');
                }
                $(`.selectpicker`).selectpicker("refresh");
                checkFieldStatusAll();
            }
        });
    }
    $("#designation").change(function () {
//        swalAlert();
        $('#sktPleaseWait').modal('show');
        let designation = $(this).val();
        let brand = $("#brand").val();
        let location = $("#location").val();
        let department = $("#department").val();
        let client = $("#client_id").val();
        let process = $("#process").val();
        if (brand != '' && location != '' && department != '') {
            $.post("<?= base_url() ?>pms_assignment/get_employee_drop", {designation: designation, brand: brand, location: location, department: department, client: client, process: process}).done(function (data) {
                $('#sktPleaseWait').modal('hide');
                if (data != '') {
                    $("#fusion_id").html(data);
                    $("#fusion_id").selectpicker('refresh');
                }
            });
        } else {
            $('#sktPleaseWait').modal('hide');
            swal("Please select", "Brand, Location, Department", "info");
            $("#designation").val('');
            $("#designation").selectpicker('refresh');
        }
    });
    function showTeamPerformanceModal(group_id = '1', sub_group_id = '', appr_id = '', details = 'Y') {
        $('#sktPleaseWait').modal('show');
        if (sub_group_id == '' && group_id != '2') {
            sub_group_id = $("#description_drop").val();
        }
        if (appr_id == '') {
            appr_id = $("#pms_id").val();
        }

        $.post("<?= base_url() ?>pms_assignment/modifyPmsPageViewpages", {sub_group_id: sub_group_id, appr_id: appr_id, details: details, group_id: group_id}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data != '') {
                if (group_id == '1') {
                    $("#mng_performance_competency").html(data);
                    $("#mng_performance_kra").html('');
                } else {
                    $("#mng_performance_kra").html(data);
                    $("#mng_performance_competency").html('');
                }
                $(`.selectpicker`).selectpicker("refresh");
                checkFieldStatusAll();
            }
        });
    }
    function getquestionForPms(group_id, sub_group_id = '', ) {//get question by subgroup
        $('#sktPleaseWait').modal('show');
        let appr_id = $("#pms_id").val();
        $.post("<?= base_url() ?>pms_assignment/get_question_set", {group_id: group_id, sub_group_id: sub_group_id, appr_id: appr_id}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data != '') {
                $("#mng_performance_competency").html(data);
                checkFieldStatusAll();
            }

        });
    }
    $("#btn_pms_form").click(function () {//create new pms
        if (!requiredValidation($("#frm_submit_pms"))) {
            $('#sktPleaseWait').modal('show');
            $.post("<?= base_url() ?>pms_assignment/save_pms_hr", $("#frm_submit_pms").serialize()).done(function (data) {
                let dat = JSON.parse(data);
                if (dat.mesg == 'success') {
                    $('#sktPleaseWait').modal('hide');
                    $("#pms_id").val(dat.id);
                    $(".parameter-container").css("display", "block");
                    swal("Created PMS Successfully.", "", "success");
                } else if (dat.mesg == 'error mwp') {
                    $('#sktPleaseWait').modal('hide');
                    swal("Error ! MWP id Not match.", dat.mwp_id, "error");
                } else {
                    $('#sktPleaseWait').modal('hide');
                    swal("Error ! Please Try Again Later.", "", "error");
                }

            });

        }
    });

    function btn_submit_question() {//insert question set from hr       
        if (!requiredValidation($("#frm_submit_ques"))) {
            $('#sktPleaseWait').modal('show');
            let pms_id = $("#pms_id").val();
            let group_id = $("#group_id").val();

            $.post("<?= base_url() ?>pms_assignment/save_pms_hr_question", $("#frm_submit_ques").serialize() + "&pms_id=" + pms_id).done(function (data) {

                if (data == 1) {
                    $('#sktPleaseWait').modal('hide');
                    if (group_id == '1') {
                        swal("PMS Competency Parameter Saved Successfully.", "", "success");
                    } else {
                        swal("PMS KRA Parameter Saved Successfully.", "", "success");
                    }
                } else if (data == 2) {
                    $('#sktPleaseWait').modal('hide');
                    swal("Error ! limit count exceeded.", "", "error");
                } else {
                    $('#sktPleaseWait').modal('hide');
                    swal("Error ! Please Try Again Later.", "", "error");
                }

            });

        }
    }
    function edtParameterQes(ques_id) {
        let param = $(`#ques_def_${ques_id}`).text();
        let pms_id = $(`#pms_id`).val();
        $('#sktPleaseWait').modal('show');
        $.post("<?= base_url() ?>Pms_assignment/edit_parameter", {pms_id: pms_id, ques_id: ques_id, param: param}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data) {
                $("#edit_param_modal").html(data);
                $("#edit_param_modal").modal('show');
                $(".selectpicker").selectpicker('refresh');
            }
        });
    }
    function saveEditeParam(dataFor) {
        let param_id = $("#param_id").val();
        let param = $("#edt_param").val();
        $('#sktPleaseWait').modal('show');
        $.post("<?= base_url() ?>Pms_assignment/save_new_param", $("#frm_edt_param").serialize() + '&dataFor=' + dataFor).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data) {
                $("#edit_param_modal").modal('hide');
                $(`#ques_def_${param_id}`).text(param);
                swal("Saved successfully", "", "success");


            } else {

                $("#edit_param_modal").modal('hide');
                swal("Error ! Please Try Again Later", "", "error");
            }
        });
    }
    function btn_submit_question_team(nos) {
        if (nos == '2') {
            $("#team_member").prop('required', false);
        } else {
            $("#team_member").prop('required', true);
        }
        if (!requiredValidation($("#frm_submit_ques_team"))) {
            $('#sktPleaseWait').modal('show');
            let pms_id = $("#pms_id").val();
            $.post("<?= base_url() ?>Pms_assignment/save_pms_for_team", $("#frm_submit_ques_team").serialize() + '&question_for=' + nos + '&pms_id=' + pms_id).done(function (data) {
                $('#sktPleaseWait').modal('hide');
                console.log(data);
                if (data != '') {
                    if (data.trim() == 'exceeded') {
                        swal("Description/Parameter count exceeded", "", "error");
                    } else {
//                $("#edit_param_modal").modal('hide');
//                $(`#ques_def_${param_id}`).text(param);
                        swal("Saved successfully", "", "success");
                    }

                } else {
//                $("#edit_param_modal").modal('hide');
                    swal("Error ! Please Try Again Later", "", "error");
                }
            });
        }
    }

</script>
<script>
    function requiredValidation(e) {
        var error = false;
        $(e).find('input[required]').each(function (event) {
            var val = $(this).val();
            if (val.trim() == "") {
                $(this).css({
                    "border": "1px solid red"
                });
                $(this).focus();
                popupErrorMsg($(this), "Fill the field to proceed", 3);
                error = true;

            } else {
                $(this).css({
                    "border": "1px solid #ddd"
                });

            }
        });
        $(e).find('input[number]').each(function (event) {
            var val = $(this).val();
            if (checkNonDec(val.trim()) == false) {
                $(this).css({
                    "border": "1px solid red"
                });
                $(this).focus();
                popupErrorMsg($(this), "Decimal value Not allowed", 3);
                error = true;

            } else {
                $(this).css({
                    "border": "1px solid #ddd"
                });

            }
        });
        $(e).find('textarea').each(function (event) {
            var val = $(this).val();
            if (checkNonDec(val.trim()) == false) {
                $(this).css({
                    "border": "1px solid red"
                });
                $(this).focus();
                popupErrorMsg($(this), "Fill the field to proceed", 3);
                error = true;

            } else {
                $(this).css({
                    "border": "1px solid #ddd"
                });

            }
        });
        $(e).find('select[required]').each(function (event) {
            var val = $(this).val();
            if (typeof (val) != 'object') {
                if (val.trim() == "") {
                    $(this).focus().css({
                        "border": "1px solid red"
                    });
                    popupErrorMsg($(this), "Select a option to proceed", 3);
                    error = true;
                } else {
                    $(this).css({
                        "border": "1px solid #ddd"
                    });
                }
            } else {
                if (val.length == "0") {
                    $(this).focus().css({
                        "border": "1px solid red"
                    });
                    popupErrorMsg($(this), "Select a option to proceed", 3);
                    error = true;
                } else {
                    $(this).css({
                        "border": "1px solid #ddd"
                    });
                }
            }
        });
        $(e).find('input[min]').each(function (event) {
            var val = $(this).val();
            var min = $(this).attr("min");
            if (val.trim() < Number(min)) {
                $(this).css({
                    "border": "1px solid red"
                });
                $(this).focus();
                popupErrorMsg($(this), `Value must be grater than or equal to ${min}`, 3);
                error = true;
            } else {
                $(this).css({
                    "border": "1px solid #ddd"
                });

            }
        });
        $(e).find('input[max]').each(function (event) {
            var val = $(this).val();
            var max = $(this).attr("max");
            if (val.trim() > Number(max)) {
                $(this).css({
                    "border": "1px solid red"
                });
                $(this).focus();
                popupErrorMsg($(this), `Value must be less than or equal to ${max}`, 3);
                error = true;
            } else {
                $(this).css({
                    "border": "1px solid #ddd"
                });

            }
        });

        return error;
    }
    function popupErrorMsg(e, msg, interval) {
        //$(".kmi-popup_error").remove();
        var div = $(e).closest("div");
        var offset = $(e).position();
        var close = document.createElement('div');
        $(close).addClass("kmi-popup_error")
                .html(msg)
                .css({
                    "position": "absolute",
                    "left": (offset.left),
                    "top": (offset.top - 30),
                    "z-index": "10999",
                    "color": "white",
                    "font-size": "14px",
                    "cursor": "pointer",
                    "background-color": "#dd4b39",
                    "border-radius": "3px",
                    "padding": "5px",
                    "width": "150px;",
                    "text-align": "center",
                    "display": "none"
                })
                .attr("id", "kmi-popup_error")
                .appendTo(div)
                .on("click", function () {
                    $(close).remove();
                });
        $(close).slideDown("slow");
        $(close).fadeOut(interval * 1000);
        setTimeout(function () {
            $(close).remove();
        }, interval * 1000);
    }
    function checkNonDec(val) {
        var ex = /^[0-9]*$/;
        if (val.match(ex) == false) {
            return false;
        } else {
            return true;
        }
    }
</script><!-- Validation code End Here -->
<script>
    function getPmsFormViewPage(appr_id = '') {
        $('#sktPleaseWait').modal('show');
        $.post("<?= base_url() ?>pms_assignment/getPmsPageView", {appr_id: appr_id}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data) {
                $("#page_view").html(data);
            } else {
                location.load("<?= base_url() ?>pms/pms_own_performance_list");
            }
        });
    }
    function getPmsFormViewPageReview(appr_id, fusion_id) {
        $('#sktPleaseWait').modal('show');

        $.post("<?= base_url() ?>pms_assignment/getPmsPageViewReview", {appr_id: appr_id, fusion_id: fusion_id}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data) {
                $("#page_view").html(data);
            } else {
                location.load("<?= base_url() ?>home");
            }
        });
    }

    function getModifyPms() {
        $('#sktPleaseWait').modal('show');
        $.post("<?= base_url() ?>pms_assignment/modifyPmsPageViewpages").done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data) {
                $("#page_view").html(data);
            } else {
                location.load("<?= base_url() ?>home");
            }
        });
    }
    function submitView() {
        if (!requiredValidation($("#frm_submit"))) {
            let conf = confirm("Do You realy want to submit?");
            if (conf === true) {
                $('#sktPleaseWait').modal('show');
                $.post("<?= base_url() ?>pms_assignment/save_pms", $("#frm_submit").serialize()).done(function (data) {
                    if (data) {
                        $('#sktPleaseWait').modal('hide');
                        swal("Form Submitted Successfully.", "", "success");
                        location.reload();
                    } else {
                        $('#sktPleaseWait').modal('hide');
                        swal("Error ! Please Try Again Later.", "", "error");
                    }

                });
            }
        }
    }

    function clickAcknowledge() {
        if ($("#acknowledge").is(":checked")) {
            $("#btn_submit").css("display", "block");
        } else {
            $("#btn_submit").css("display", "none");
        }
    }

    function addDefination(appr_id = '') {
        let subgroup_id = '';
        showTeamPerformanceModal(subgroup_id, appr_id, 'Y');
    }
    function editDefinationDescription(appr_id, subgroup_id) {
        showTeamPerformanceModal(subgroup_id, appr_id, 'N');
    }
    function addDescriptionModals(group_id = '', sub_group_id = '', appr_id = '', details = 'Y') {
        $('#sktPleaseWait').modal('show');
        if (appr_id == '') {
            appr_id = $("#pms_id").val();
        }
        $.post("<?= base_url() ?>pms_assignment/get_description_modals", {group_id: group_id, sub_group_id: sub_group_id, appr_id: appr_id, details: details}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            $("#description_modal").html(data);
            $("#description_modal").modal("show");
            $(".selectpicker").selectpicker('refresh');

        });
    }
    function addDescriptionModalsMaster(group_id = '', sub_group_id = '', appr_id = '', details = 'Y') {
        $('#sktPleaseWait').modal('show');
        if (appr_id == '') {
            appr_id = $("#pms_id").val();
        }
        $.post("<?= base_url() ?>pms_assignment/get_description_modals_master", {group_id: group_id, sub_group_id: sub_group_id, appr_id: appr_id, details: details}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            $("#description_modal").html(data);
            $("#description_modal").modal("show");
            $(".selectpicker").selectpicker('refresh');

        });
    }
    function addDefinationModals(group_id = '', sub_group_id = '', details = '') {
        $('#sktPleaseWait').modal('show');
        $.post("<?= base_url() ?>pms_assignment/get_defination_modals", {group_id: group_id, sub_group_id: sub_group_id, details: details}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            $("#defination_modal").html(data);
            $("#description_modal").modal("hide");
            $("#defination_modal").modal("show");
            $(".selectpicker").selectpicker('refresh');

        });
    }
    function addDefinationModalsMaster(group_id = '', sub_group_id = '', details = '') {
        $('#sktPleaseWait').modal('show');
        $.post("<?= base_url() ?>pms_assignment/get_defination_modals_master", {group_id: group_id, sub_group_id: sub_group_id, details: details}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            $("#defination_modal").html(data);
            $("#description_modal").modal("hide");
            $("#defination_modal").modal("show");
            $(".selectpicker").selectpicker('refresh');

        });
    }

//    ==================================================================================//

//    function showTeamPerformanceModal(sub_group_id = '', appr_id = '', details = 'Y') {
//        $('#sktPleaseWait').modal('show');
//        $.post("<?= base_url() ?>pms_assignment/get_team_performance_question", {sub_group_id: sub_group_id, appr_id: appr_id, details: details}).done(function (data) {
//            $('#sktPleaseWait').modal('hide');
//            if (data != '') {
//                $("#mng_performance").html(data);
//                $("#mng_performance").modal('show');
//                $(".date-picker").datepicker({dateFormat: "dd-mm-yy"});
//                $(`.selectpicker`).selectpicker("refresh");
//                checkFieldStatusAll();
//            }
//        });
//    }
//    function showPerformanceModal() {
//        $('#sktPleaseWait').modal('show');
//        $("#mng_performance").modal('show');
//        $(".date-picker").datepicker({dateFormat: "dd-mm-yy"});
//        $('#sktPleaseWait').modal('hide');
//    }
    function getQuestionset() {
        $('#sktPleaseWait').modal('show');
        let selectpicker = "selectpicker";
        $.post("<?= base_url() ?>pms_assignment/get_performance_question").done(function (data) {
            $('#sktPleaseWait').modal('hide');
            $("#description_qes_set").html(data);
            $(`.${selectpicker}`).selectpicker('refresh');
        });
    }
    function getDescriptionDrop(group_id) {
        $('#sktPleaseWait').modal('show');
        let pms_id = $("#pms_id").val();
        $.post("<?= base_url() ?>pms_assignment/get_description_drop", {group_id: group_id, pms_id: pms_id}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data != '') {
                $("#description_drop").html(data);
                $("#sub_group_list").html(data);
                $(".selectpicker").selectpicker('refresh');
            }

        });
    }

//    $("#btn_add_pms").click(function () {
//        $(".block-hide").css("display", "block");
//    });

    $("#btn_add_pms").click(function () {
        if (!requiredValidation($("#frm_submit_pms"))) {
            $('#sktPleaseWait').modal('show');
            let sub_group_id = $("#definition_drop").val();
            $.post("<?= base_url() ?>pms_assignment/save_pms_hr", $("#frm_submit_pms").serialize()).done(function (data) {
                if (data > 0) {
                    $('#sktPleaseWait').modal('hide');
                    $("#pms_id").val(data.trim());
                    $(".block-hide").css("display", "block");
                    swal("PMS Saved Successfully.", "", "success");
                } else {
                    $('#sktPleaseWait').modal('hide');
                    swal("Error ! Please Try Again Later.", "", "error");
                }

            });
            getquestionForPms(sub_group_id);
        }

    });
    $(document).bind("change", ".description_qes_set_row .active_ques_data input:checkbox", function (e) {
        let id = $(`#${e.target.id}`).attr('for');
        checkFieldStatus(id);
    });

    function checkFieldStatus(id = '') {
//        $('#sktPleaseWait').modal('show');

        if ($(`#check_${id}`).is(":checked")) {
            $(`#weightage_${id}`).prop("required", true);
            $(`#weightage_${id}`).prop("disabled", false);
            $(`#is_editable_${id}`).prop("required", true);
            $(`#is_editable_${id}`).prop("disabled", false);
            $(`#brand_${id}`).prop("required", true);
            $(`#brand_${id}`).prop("disabled", false);
            $(`#location_${id}`).prop("required", true);
            $(`#location_${id}`).prop("disabled", false);
            $(`#department_${id}`).prop("required", true);
            $(`#department_${id}`).prop("disabled", false);
            $(`.selectpicker`).selectpicker("refresh");
        } else {
            $(`#weightage_${id}`).prop("required", false);
            $(`#weightage_${id}`).prop("disabled", true);
            $(`#is_editable_${id}`).prop("required", false);
            $(`#is_editable_${id}`).prop("disabled", true);
            $(`#brand_${id}`).prop("required", false);
            $(`#brand_${id}`).prop("disabled", true);
            $(`#location_${id}`).prop("required", false);
            $(`#location_${id}`).prop("disabled", true);
            $(`#department_${id}`).prop("required", false);
            $(`#department_${id}`).prop("disabled", true);
            $(`.selectpicker`).selectpicker("refresh");
        }

//        $('#sktPleaseWait').modal('hide');
        return true;
    }
    function checkFieldStatusAll() {
        $('[class^="active_ques_data"]').each(function () {
            let id = $(this).attr("for");
            if ($(this).is(":checked")) {
                $(`#weightage_${id}`).prop("required", true);
                $(`#weightage_${id}`).prop("type", "number");
                $(`#weightage_${id}`).prop("min", '0');
                $(`#weightage_${id}`).prop("max", '100');
                $(`#weightage_${id}`).prop("disabled", false);
                $(`#is_editable_${id}`).prop("required", true);
                $(`#is_editable_${id}`).prop("disabled", false);
                $(`#brand_${id}`).prop("required", true);
                $(`#brand_${id}`).prop("disabled", false);
                $(`#location_${id}`).prop("required", true);
                $(`#location_${id}`).prop("disabled", false);
                $(`#department_${id}`).prop("required", true);
                $(`#department_${id}`).prop("disabled", false);
                $(`.selectpicker`).selectpicker("refresh");
            } else {
                $(`#weightage_${id}`).prop("required", false);
                $(`#weightage_${id}`).prop("type", "text");
                $(`#weightage_${id}`).removeAttr("min");
                $(`#weightage_${id}`).removeAttr("max");
                $(`#weightage_${id}`).prop("disabled", true);
                $(`#is_editable_${id}`).prop("required", false);
                $(`#is_editable_${id}`).prop("disabled", true);
                $(`#brand_${id}`).prop("required", false);
                $(`#brand_${id}`).prop("disabled", true);
                $(`#location_${id}`).prop("required", false);
                $(`#location_${id}`).prop("disabled", true);
                $(`#department_${id}`).prop("required", false);
                $(`#department_${id}`).prop("disabled", true);
                $(`.selectpicker`).selectpicker("refresh");
            }
        });

        return true;
    }
//    function disabledSubgroupSectionDrop() {
//        $(`.back-drop`).prop("disabled", true);
//        $(`.back-drop`).selectpicker("refresh");
//    }
//    function chekAllCheckBox(subgroup_id) {
//        let selector = `check_all_${subgroup_id}`;
//        //let active_ques_data="[class^='active_ques_data']";
//        if ($(`#${selector}`).is(":checked")) {
//            $(`[class^="active_ques_data"] .check_${subgroup_id} input:checkbox`).prop("checked", true);
//            $(`.brand_${subgroup_id}`).prop("disabled", false);
//            $(`.brand_${subgroup_id}`).prop("required", true);
//            $(`.location_${subgroup_id}`).prop("disabled", false);
//            $(`.location_${subgroup_id}`).prop("required", true);
//            $(`.department_${subgroup_id}`).prop("disabled", false);
//            $(`.department_${subgroup_id}`).prop("required", true);
//            $(`.selectpicker`).selectpicker("refresh");
//        } else {
//            $(`.check_${subgroup_id} .active_ques_data input:checkbox`).prop("checked", false);
//            $(`.brand_${subgroup_id}`).prop("disabled", true);
//            $(`.brand_${subgroup_id}`).prop("required", false);
//            $(`.location_${subgroup_id}`).prop("disabled", true);
//            $(`.location_${subgroup_id}`).prop("required", false);
//            $(`.department_${subgroup_id}`).prop("disabled", true);
//            $(`.department_${subgroup_id}`).prop("required", false);
//            $(`.selectpicker`).selectpicker("refresh");
//        }
//
//        checkFieldStatusAll();
//        return false;
//    }

    if ($("#pms_qs_list").length) {
        var dataTable = $('#pms_qs_list').DataTable({
            "pageLength": '10',
            "lengthMenu": [
                [10, 20, 50, 100, 150, 200, -1],
                [10, 20, 50, 100, 150, 200, 'All'],
            ],
            "columnDefs": [{
                    "targets": [0, -1],
                    "searchable": false

                }, // Disable search on first 
                {
                    "targets": [0, -1],
                    "orderable": false

                } // Disable orderby on first            
            ],
            'scrollCollapse': false,
            'processing': true,
            'serverSide': true,
            'responsive': true,
            'serverMethod': 'post',
            'searching': true, // Remove default Search Control
            'ajax': {
                complete: function (data) {
                    // var office_id = $('#fdoffice_ids').val();
                    // if (jQuery.inArray("CHA", office_id) !== -1) {
                    //     $('th:nth-child(7)').show();
                    //     $('td:nth-child(7)').show();
                    // } else {
                    //     $('th:nth-child(7)').hide();
                    //     $('td:nth-child(7)').hide();
                    // }
                },
                'url': $('#data_url').val(),
                'data': function (data) {
                    // var $form = $("#dynamic_search_form");
                    // var fdata = $($form).serializeAssoc();
                    // data.form_data = fdata;
                    // var search_click = $('#search_click').val();
                    // var req_status = $('#button_search_value').val();
                    // // Append to data
                    // data.searchClick = search_click;
                    //  data.req_status = req_status;
                }
            }
        });
    }
//    function editpmsForm(dat, group_id) {
//        // alert(group_id);
//        $.post("<?= base_url() ?>Pms_assignment/getSingalePms", {id: dat}).done(function (data) {
//            if (data != '') {
//                let dat = JSON.parse(data);
//                $("#pms_id").val(dat.id);
////                $("#pms_title").val(dat.pms_title);
////                $("#pms_type").val(dat.pms_type);
////                $("#pms_rating").val(dat.pms_rating);
////                $("#start_date").val(dateconvert(dat.start_date));
////                $("#closing_date").val(dateconvert(dat.closing_date));
//                showPerformanceModal('', dat.id, '', group_id);
//                //getquestionForPms();
//            }
//        });
//
//    }
    function insertDefination() {
        if (!requiredValidation($("#frm_submit_defination"))) {
            let appr_id = $("#pms_id").val();
            let group_id = $("#select_group").val();
            $('#sktPleaseWait').modal('show');
            $.post("<?= base_url() ?>Pms_assignment/insert_defination", $("#frm_submit_defination").serialize() + '&pms_id=' + appr_id).done(function (data) {
                $('#sktPleaseWait').modal('hide');
//                alert(data);
                if (data) {
                    swal("Paramater Saved Successfully.", "", "success");
                    $("#description_modal").modal("hide");
                    $("#mng_performance").modal("hide");
                    showTeamPerformanceModal(group_id);
                    $('.modal-backdrop').remove().remove();

                } else {
                    swal("Error ! Please Try Again Later.", "", "error");
                }
            });
        }
    }
    function insertDefinationMaster() {
        if (!requiredValidation($("#frm_submit_defination"))) {
            let group_id = $("#group_id").val();
            $('#sktPleaseWait').modal('show');
            $.post("<?= base_url() ?>Pms_assignment/insert_defination_master", $("#frm_submit_defination").serialize()).done(function (data) {
                $('#sktPleaseWait').modal('hide');
                if (data) {
                    swal("Paramater Saved Successfully.", "", "success");
                    $("#description_modal").modal("hide");
                    showPerformanceModal(group_id);
                    $('.modal-backdrop').remove().remove();

                } else {
                    swal("Error ! Please Try Again Later.", "", "error");
                }
            });
        }
    }
    function addDescription() {
        if (!requiredValidation($("#frm_sub_grp"))) {
            let appr_id = $("#pms_id").val();
            let subgroup_id = '';
            $('#sktPleaseWait').modal('show');
            $.post("<?= base_url() ?>Pms_assignment/add_description", $("#frm_sub_grp").serialize() + '&pms_id=' + appr_id).done(function (data) {
                $('#sktPleaseWait').modal('hide');
                if (data) {
                    swal("Description Saved Successfully.", "", "success");
                    $("#description_modal").modal("hide");
                    $("#defination_modal").modal("show");
                    //$('.modal-backdrop').remove().remove();
//                    showPerformanceModal(subgroup_id, appr_id, 'Y');
                } else {
                    swal("Error ! Please Try Again Later.", "", "error");
                }
            });
        }
    }
    function addDescriptionMaster() {
        if (!requiredValidation($("#frm_sub_grp"))) {
            $('#sktPleaseWait').modal('show');
            $.post("<?= base_url() ?>Pms_assignment/add_description_master", $("#frm_sub_grp").serialize()).done(function (data) {
                $('#sktPleaseWait').modal('hide');
                if (data) {
                    swal("Description Saved Successfully.", "", "success");
                    $("#description_modal").modal("hide");
                    $("#defination_modal").modal("show");
                    //$('.modal-backdrop').remove().remove();
                } else {
                    swal("Error ! Please Try Again Later.", "", "error");
                }
            });
        }
    }

    function btn_reviewer_insert(save_type) {

        if (save_type == '1') {
            $('#sktPleaseWait').modal('show');
            $.post("<?= base_url() ?>pms_assignment/save_pms_review", $("#frm_reviewer").serialize() + '&save_type=' + save_type).done(function (data) {
                let dat = JSON.parse(data);
                if (dat.status != '') {
                    $('#sktPleaseWait').modal('hide');
                    swal(dat.msg, "", dat.status);
                    location.reload();
                }

            });
        } else {
            if (!requiredValidation($("#frm_reviewer"))) {
                $('#sktPleaseWait').modal('show');
                $.post("<?= base_url() ?>pms_assignment/save_pms_review", $("#frm_reviewer").serialize() + '&save_type=' + save_type).done(function (data) {
                    let dat = JSON.parse(data);
                    if (dat.status != '') {
                        $('#sktPleaseWait').modal('hide');
                        swal(dat.msg, "", dat.status);
                        location.reload();
                    }

                });
            }
        }
    }
    function btn_hr_reviewer_insert(save_type) {
        if (!requiredValidation($("#frm_hr_reviewer"))) {
            $('#sktPleaseWait').modal('show');
            $.post("<?= base_url() ?>pms_assignment/save_pms_hr_review", $("#frm_hr_reviewer").serialize() + '&save_type=' + save_type).done(function (data) {
                let dat = JSON.parse(data);
                if (dat.status != '') {
                    if (dat.status == 'success') {
                        location.reload();
                    }
                    $('#sktPleaseWait').modal('hide');
                    swal(dat.msg, "", dat.status);
                }

            });
        }
    }

</script>
<script>
    function check_switch(data) {
        if (data.value == '1') {
            $(`#${data.id}`).val('0');
        } else {
            $(`#${data.id}`).val('1');
        }
        return false;
    }
</script>
<script>
    function dateconvert(dat) {
        var todaydate = new Date(dat);  //pass val varible in Date(val)
        var dd = todaydate.getDate();
        var mm = todaydate.getMonth() + 1; //January is 0!
        var yyyy = todaydate.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var date = dd + '-' + mm + '-' + yyyy;
        return date;
    }



    $(document).on('click', '.check_pms_active', function ()
    {
        // $('.check_ticket').click(function(){
        var chk = 0;
        $(".check_pms_active").each(function () {
            if ($(this).prop('checked') == true) {
                chk = 1;
            }
        });
        // alert(chk);
        if (chk == 1) {
            // $('.div_ticketAssignUpdate').css('display','block');
            $('.check_widget_pms').css('display', 'block');
            // $('#ticket_user').prop('required',true);
        } else {
            // $('.div_ticketAssignUpdate').css('display','none');
            $('.check_widget_pms').css('display', 'none');
        }
    });

    get_pms_start_date = (val) => {
        // alert(val);
        $('#sktPleaseWait').modal('show');
        $("#start_date").val("");
        $.ajax({
            url: "<?php echo base_url('pms/fetch_pms_location_wise_start_date'); ?>",
            type: "POST",
            data: {
                val: val
            },

            success: function (data) {
                $('#sktPleaseWait').modal('hide');
                var a = JSON.parse(data);
                $(".populate_rating").empty();
                $.each(a, function (index, jsonObject) {
                    var checked = '';
                    var d = new Date(),
                            n = d.getMonth(),
                            y = d.getFullYear();
                    // alert(y);
                    var date_val = jsonObject.start_duration + '-' + y;
                    var total_date = '01-' + date_val;
                    $("#start_date").val(total_date);
                });
            },
            error: function (token) {
                notReply = 1;
                $('#sktPleaseWait').modal('hide');
            }
        });




    }





    pms_active = () => {
        var type = 'A';
        $('#sktPleaseWait').modal('show');
        var selected = $("input[name='check_ticket_val[]']:checked").map(function () {
            return this.value;
        }).get().join(',');
        // alert(get_data);
//        console.log(selected);
        // $('#sktPleaseWait').modal('show');
        $.ajax({
            url: "<?php echo base_url('pms/change_status_for_pms'); ?>",
            type: "POST",
            data: {
                selected: selected,
                type: type
            },
            dataType: "text",
            success: function (token) {
                $('#sktPleaseWait').modal('hide');
                notReply = 1;
                if (token == 1) {
                    swal('PMS status successfully updated', "", "success");
                    location.reload();
//                    get_config_set_list();

                } else {
                    swal('Error ! Something Went Wrong', "", "error");
                }
            },
            error: function (token) {
                notReply = 1;
                $('#sktPleaseWait').modal('hide');
                swal('Error ! Something Went Wrong', "", "error");
            }
        });

    }

    $(".selectAllCertifyUserCheckBox").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
        $('.check_widget_pms').css('display', 'block');
    });


</script>

<script>
    function swalAlert() {
//        swal({
//            toast: true,
//            icon: 'success',
//            title: 'General Title',
//            animation: false,
//            position: 'top-right',
//            showConfirmButton: false,
//            timer: 3000,
//            timerProgressBar: true,
//            button:false,
//            didOpen: (toast) => {
//                toast.addEventListener('mouseenter', Swal.stopTimer)
//                toast.addEventListener('mouseleave', Swal.resumeTimer)
//            }
//        });

//        alert();
//        swal({
//            position: 'top-right',
////            icon: 'success',
//            title: 'Your work has been saved',
//            buttons: false,
////            timer: 1500
//        });
//        swal({
//            title: "Are you sure?",
//            text: "Once deleted, you will not be able to recover this imaginary file!",
//            icon: "warning",
//            buttons: true,
//            dangerMode: true,
//        })
//                .then((willDelete) => {
//                    if (willDelete) {
//                        swal("Poof! Your imaginary file has been deleted!", {
//                            icon: "success",
//                        });
//                    } else {
//                        swal("Your imaginary file is safe!");
//                    }
//                });
    }

</script>


