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

if (user_office_id == "ALB" || user_office_id == "KOS") {

    $("#form-leave_type").change(function(){
        $('#sktPleaseWait').modal('show');

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

            if(var_js[$(this).val()][1] <= 0 && var_js[$(this).val()][3] != 0){
                alert('Leave Balance for the particular leave type selected is nill. Select anyother leave type to proceed');
            }
            else{
                ///////////
                if (var_js[$(this).val()][3]==0) { $("#leave-balance").text(''); }
                else { $("#leave-balance").text(var_js[$(this).val()][1]); }
                $("#from_date").attr('disabled',false);
            }
        }
        $('#sktPleaseWait').modal('hide');
    });

    //Date Range Check------------------
    $("#from_date").datepicker({
        onSelect: function(selected){

            //For Annual vacations Leave in ALB and KOS Location
            //Leave type ID: 46
            var leave_criteria_id = $("#form-leave_type").val();
            if((var_js[leave_criteria_id][0]==46) && (user_office_id=='ALB' || user_office_id=='KOS')) {

                from_date = new Date($("#from_date").val());
                to_date = new Date();
                Difference_In_Days = check_deference_in_days_leave(to_date,from_date);
                //Annual vacations > 30 days from current date for ALB
                //Annual vacations > 15 days from current date for KOS
                if (Difference_In_Days >= 30 && user_office_id=='ALB') {
                    $("#to_date").val('');
                    $("#to_date").attr('disabled',false);
                }
                else if(Difference_In_Days >= 15 && user_office_id=='KOS'){
                    $("#to_date").val('');
                    $("#to_date").attr('disabled',false);
                }
                else {
                    $("#to_date").val(''); $("#to_date").attr('disabled',true);
                    if(user_office_id=='ALB') { alert("Leave should be apply before 30 days"); }
                    if(user_office_id=='KOS') { alert("Leave should be apply before 15 days"); }
                    
                }

            }
            else {
                $("#to_date").val('');
                $("#to_date").attr('disabled',false);
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
                    alert('Available Leave Balance is: '+var_js[$("#form-leave_type").val()][1]);
                    $("#no_of_days").empty().html(Difference_In_Days);
                    sub_button_disabled(); 
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
        $('#leave_form .modal-footer').html('<input id="sub_but" type="submit" class="btn btn-primary btn-sm" value="Save"><button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>');
    }
    else{
        $('#leave_form #sub_but').remove();
        $('#leave_form .modal-footer').html('<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>');
    }
}
function check_deference_in_days_leave(from_date,to_date)
{
    Difference_In_Time = to_date - from_date;
    Difference_In_Days = parseFloat(1 + (Difference_In_Time / (1000 * 3600 * 24))); 
    Difference_In_Days = Math.round(Difference_In_Days);
    return Difference_In_Days;
}

});

</script>



