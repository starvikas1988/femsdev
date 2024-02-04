<script>
/*
|NOTES:
|1. Check Leave Type ID: 46 For Annual vacations(AV) in Live (From Date & To Date DatePicker) FOR ALB & KOS
|2. Check Leave Type ID: 48 For Voluntary Blood Donation(VBD) Leave in KOS Location in Live (date_change_checks function)
|
*/


var user_office_id = '<?php echo $user_office_id ?>';

var var_js = $.parseJSON('<?php echo $var_js ?>');
console.log(var_js);

$(document).ready(function(){
clear_fields();
$('button[data-target="#myModal"]').on('click', function (e) { clear_fields(); });

let location_access = ["ALB","KOS","COL","ELS","MAN","CEB"];

if (location_access.includes(user_office_id)) {

    $("#form-leave_type").change(function(){
        $('#sktPleaseWait').modal('show');

        $('#leave_full_half_type').remove();
        
        $("#file_upload_ml").attr('required',false);
        $("#ptl_div_india #discharge_report").removeAttr('required');
        $('#apply_holiday_date').attr('required',false);

        $("#leave-balance").text('');
        $("#no_of_days").text('');
        $("#from_date").val('');
        $("#to_date").val('');
        $("#from_date").attr('disabled',true);
        $("#to_date").attr('disabled',true);
        sub_button_disabled();

        if($("#form-leave_type").val()!=""){
            $("#leave_type_id").val(var_js[$(this).val()][0]);

            if(var_js[$(this).val()][5] == 1){

                sub_html = '<option value="" selected>--Select--</option>';
                $.each(var_js[$(this).val()][6], function(i,v){
                    sub_html += "<option value='"+i+"'>"+v.sub_leave_description+"</option>";
                });
                
                $("#sub_select_select").empty().append(sub_html);
                $("#sub_select_select").attr('required',true);
                $(".sub_sections label span").empty();
                $(".sub_sections label").append("<span style='color:red'> *</span>");
                $(".sub_sections").show();
            }else{
                $(".sub_sections").hide();
                $("#sub_select_select").empty();
                $("#sub_select_select").attr('required',false);
            }

            //Leave applied type for SIL=54 CEB & MAN Location - Half Day/Full Day
            if((var_js[$(this).val()][0] == 54) && (user_office_id=="CEB" || user_office_id=="MAN") ){
                
                if (var_js[$(this).val()][1] >= 1) {
                    $('#leave_applied_type_full_half').html('<div class="form-group"> <label class="col-md-4" style="line-height:37px;padding: 0;">Leave Apply For: </label> <div class="col-md-8"> <input ld="full" type="radio" name="leave_full_half_type" value="1" checked required> <label for="full" style="margin-right: 10px;">Full Day</label> <input type="radio" id="half" name="leave_full_half_type" value="2" required> <label for="half">Half Day</label><br> </div></div>');                
                }
                else {
                    $('#leave_applied_type_full_half').html('<div class="form-group"> <label class="col-md-4" style="line-height:37px;padding: 0;">Leave Apply For: </label> <div class="col-md-8"> <input type="radio" id="half" name="leave_full_half_type" value="2" checked required> <label for="half">Half Day</label><br> </div></div>'); 
                }
                
            }
            else {
                $('#leave_applied_type_full_half').html("");
            }  

            //applicable for Holiday Leave
            if (var_js[$(this).val()][0] == 42) {

                $(".to_date_h").hide();
                $(".from_date_h").hide();
                //$('.holiday_dates_div').attr({style: "display: block"});
                $('.holiday_dates_div').show();
                $("#to_date").attr('required',false);
                $("#from_date").attr('required',false);

                $("#no_of_days").text('0');
            }
            else {
                $(".to_date_h").show();
                $(".from_date_h").show();
                $("#to_date").attr('required',true);
                $("#from_date").attr('required',true);
                //$('.holiday_dates_div').attr({style: "display: none"});
                $('#apply_holiday_date').attr('required',false);
                $("#apply_holiday_date option:selected").prop("selected", false);
                $('#apply_holiday_date').multiselect('rebuild');

                $('.holiday_dates_div').hide();
            }

            if(var_js[$(this).val()][1] <= 0 && var_js[$(this).val()][3] != 0){
                alert('Leave Balance for the particular leave type selected is nill. Select anyother leave type to proceed');
            }
            else{
                ///////////
                //alert(var_js[$(this).val()][3]);
                if (var_js[$(this).val()][3]==0) { $("#leave-balance").text(''); }
                else { $("#leave-balance").text(var_js[$(this).val()][1]); }

                if(var_js[$(this).val()][0]==54 && (user_office_id=="MAN" || user_office_id=="CEB") ) {
                    $("#from_date").attr('disabled',true);
                }
                else { $("#from_date").attr('disabled',false); }
                
            }
        }
        $('#sktPleaseWait').modal('hide');
    });

    $(document).on('change','#apply_holiday_date',function(){

        var h_date = $("#apply_holiday_date").val();
        var leave_balance = var_js[$('#form-leave_type').val()][1];
        var h_date_count = h_date.length;

        if (h_date_count > leave_balance && location_access.indexOf(user_office_id) != 1) {
            alert("Available leave balance is less then selected date");
            sub_button_disabled();
        }
        else {
            sub_button_disabled(1);
        }
        $("#no_of_days").text(h_date_count);

    });

    $(document).on('change','#sub_select_select',function(){
        if ($(this).val()!="") {
            $("#from_date").attr('disabled',false);
            $("#from_date").val('');
        } 
        else {
            $("#from_date").attr('disabled',true);
        } 
    });

    //Date Range Check------------------
    $("#from_date").datepicker({
        onSelect: function(selected){
            $("#to_date").datepicker( "option", "defaultDate", selected );

            //For Annual vacations Leave in ALB and KOS Location
            //Leave type ID: 46
            var leave_criteria_id = $("#form-leave_type").val();
            if((var_js[leave_criteria_id][0]==46) && (user_office_id=="KOS" || user_office_id=="ALB")) {

                from_date = new Date($("#from_date").val());
                to_date = new Date();
                Difference_In_Days = check_deference_in_days_leave(to_date,from_date);
                //Annual vacations > 30 days from current date for ALB
                //Annual vacations > 15 days from current date for KOS
                if (Difference_In_Days >= 15 && user_office_id=='ALB') {
                    $("#to_date").val('');
                    $("#to_date").attr('disabled',false);
                }
                else if(Difference_In_Days >= 15 && user_office_id=='KOS'){
                    $("#to_date").val('');
                    $("#to_date").attr('disabled',false);
                }
                else {
                    $("#to_date").val(''); $("#to_date").attr('disabled',true);
                    if(user_office_id=='ALB') { alert("Leave should be apply before 15 days"); }
                    if(user_office_id=='KOS') { alert("Leave should be apply before 15 days"); }
                    
                }

            }
            else {

                let leave_applied_type = $('#leave_form input[type=radio][name=leave_full_half_type]:checked').val();
                if (leave_applied_type==2 && (user_office_id!='CEB' && user_office_id!='MAN')) { 
                    $("#to_date").prop("disabled",true);
                    $("#to_date").val($(this).val());
                    date_change_checks();
                }
                else {

                    if (user_office_id=='CEB' || user_office_id=='MAN') {
                        let retrun_check =  check_user_leave_apply_prior();
                        if(retrun_check) {
                            if (leave_applied_type==2) {

                                $("#to_date").prop("disabled",true);
                                $("#to_date").val($(this).val());
                                date_change_checks();
                            }
                            else {
                                $("#to_date").prop("disabled",false);
                                $("#to_date").val('');
                            }
                        }
                        else {
                            $("#to_date").prop("disabled",true);
                            $("#to_date").val('');
                            sub_button_disabled();
                        }
                    }
                    else {
                        $("#to_date").prop("disabled",false);
                        $("#to_date").val('');
                    }


                }

            }
        }
    });

    $("#to_date").datepicker({
        onSelect: function(selected){
            if ($("#from_date").val()!="" && $(this).val()!="") {
                date_change_checks();
            }
            else {
                $("#to_date").val('');
                $("#to_date").attr('disabled',false);
                alert("Please Select From Date");
            }
        }
    });

}

function date_change_checks(){
    if($("#from_date").val()!="" && $("#to_date").val()!=""){

        var leave_type_id = $("#form-leave_type").val();       

        if(leave_type_id !=''){

            from_date = new Date($("#from_date").val());
            to_date = new Date($("#to_date").val());

            Difference_In_Days = check_deference_in_days_leave(from_date,to_date);
            if(Difference_In_Days<=0){
                alert('In-Valid Date Range selected');
                $("#no_of_days").empty().html("<span style='color:#FF0000'>(In-Valid To Date selected. Please change it.)</span>");
                sub_button_disabled();
            }
            else{
                if (Difference_In_Days <= var_js[$("#form-leave_type").val()][1] || var_js[leave_type_id][3]==0) {
                    $("#no_of_days").empty().html(Difference_In_Days);

                    //For Voluntary Blood Donation Leave in KOS Location
                    //Leave type ID: 48
                    if (var_js[leave_type_id][0]==48 && user_office_id=='KOS' && Difference_In_Days > 1) {
                        alert("You can take only one leave at a time.");
                        sub_button_disabled();
                    }
                    else {
                        check_apply_date_range();
                    }

                }
                else{
                    ///For 0.5 Day Leave Balance
                    if ( Difference_In_Days == 1 && Math.round(var_js[$("#form-leave_type").val()][1]) !=0 ) {
                        if (var_js[$("#form-leave_type").val()][1] == "0.50" && user_office_id!='MAN' && user_office_id!='CEB') {
                            $('#leave_form').append("<input id='leave_full_half_type' name='leave_full_half_type' type='hidden' value='2' />");
                            
                            check_apply_date_range();
                        }
                        else {
                            alert('Available Leave Balance is: '+var_js[$("#form-leave_type").val()][1]);
                            $("#no_of_days").empty().html(Difference_In_Days);
                            sub_button_disabled(); 
                        }
                    }
                    else {
                        alert('Available Leave Balance is: '+var_js[$("#form-leave_type").val()][1]);
                        $("#no_of_days").empty().html(Difference_In_Days);
                        sub_button_disabled(); 
                    }
                }
            }
        }
        else{
            sub_button_disabled();
        }
    }
    else{
        sub_button_disabled();
    }
}
function check_apply_date_range()
{
    var check_from_date = $("#from_date").val();
    var check_to_date = $("#to_date").val();
    var datas = { 'from_date': check_from_date, 'to_date': check_to_date };
    var request_url = "<?=base_url()?>leave/check_date_for_leave_apply";

    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat == true) 
        {
            $("#leave_type_id").val(var_js[$("#form-leave_type").val()][0]);
            sub_button_disabled(1);
        }
        else {
            sub_button_disabled();
            alert('Multiple leaves on same date not allowed, please check leave applied history');
        }                 
    },request_url, datas, 'text');  
}
function clear_fields(){
    document.getElementById("leave_form").reset();
    $("#leave-balance").text('');
    $("#no_of_days").text('');
    sub_button_disabled();
    $("#from_date").val('');
    $("#to_date").val('');
    $("#from_date").attr('disabled',true);
    $("#to_date").attr('disabled',true);
}
function sub_button_disabled(req=2)
{
    if (req==1) {
        $('#leave_form .modal-footer').html('<button type="button" class="btn btn_padding filter_btn btn-sm save_common_btn" data-dismiss="modal">Cancel</button> <input id="sub_but" type="submit" class="btn btn_padding filter_btn_blue btn-sm save_common_btn" value="Save">');
    }
    else{
        $('#leave_form #sub_but').remove();
        $('#leave_form .modal-footer').html('<button type="button" class="btn btn_padding filter_btn save_common_btn btn-sm" data-dismiss="modal">Cancel</button>');
    }
}
function check_deference_in_days_leave(from_date,to_date)
{ 
    let leave_applied_type = $('#leave_form input[type=radio][name=leave_full_half_type]:checked').val();
    if(leave_applied_type==2) {
        return 0.5;
    }
    else {
        Difference_In_Time = to_date - from_date;
        Difference_In_Days = parseFloat(1 + (Difference_In_Time / (1000 * 3600 * 24))); 
        Difference_In_Days = Math.round(Difference_In_Days);
        return Difference_In_Days;
    }

}
function check_deference_in_days_philippines(from_date,to_date)
{ 

    Difference_In_Time = to_date - from_date;
    Difference_In_Days = parseFloat(1 + (Difference_In_Time / (1000 * 3600 * 24))); 
    Difference_In_Days = Math.round(Difference_In_Days);
    return Difference_In_Days;

}


function check_user_leave_apply_prior() 
{
    let leave_applied_type = $('#leave_form input[type=radio][name=leave_full_half_type]:checked').val();

    let location_access = ["MAN","CEB"];
    let leave_type = [14,54,16];
    let leave_type_id = parseInt($("#leave_type_id").val());

    let from_date = new Date($("#from_date").val());
    let to_date = new Date();
    let Difference_In_Days = check_deference_in_days_philippines(to_date,from_date);

    if (location_access.includes(user_office_id) && leave_type.includes(leave_type_id)) {

        if(Difference_In_Days >= 7 || ( $('#sub_select_select :selected').text()=="Sick leave (SL)" && leave_type_id==54) ) {

            if(leave_type_id==14) {
                let from_date_new = new Date(from_date);
                let current_date = new Date('<?=$user_dob?>');

                if(from_date_new.getFullYear()!=new Date().getFullYear() || from_date_new.getMonth()!=current_date.getMonth()) {
                    $("#to_date").val(''); $("#to_date").attr('disabled',true);
                    alert("Leave should be applied within birthday month");

                    return false;
                }
                else {
                    $("#to_date").val('');
                    $("#to_date").attr('disabled',false);
                    return true;
                }
            }
            else {
                $("#to_date").val('');
                $("#to_date").attr('disabled',false);
                return true;
            }
        }
        else {
            $("#to_date").val(''); $("#to_date").attr('disabled',true);
            alert("Leave should be applied before 7 days");

            return false;

        }
    }
    else {
        return true;
    }

}

$(document).on('change','#leave_form input[type=radio][name=leave_full_half_type]',function(){
    let leave_applied_type = $(this).val();
    if (leave_applied_type==2) { 
        $("#to_date").prop("disabled",true); 
        $("#to_date,#from_date").val('');
    }
    else { 
        $("#to_date").prop("disabled",false);
        $("#to_date,#from_date").val('');
    }
    $("#no_of_days").text("");
});


});


function approve_leave(id){
    //alert('');
    $.post("<?php echo base_url()?>/leave/set_leave_status",{"id":id, "status_id": 1}, function(){
        location.reload();
        
    });
}

function cancel_leave(id){
    //alert('rej');
    $.post("<?php echo base_url()?>/leave/cancel_leave",{"id":id, "status_id": 3}, function(){
        location.reload();
    });
}

</script>



