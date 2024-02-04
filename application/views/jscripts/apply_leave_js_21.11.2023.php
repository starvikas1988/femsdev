<script>

var user_office_id = '<?php echo $user_office_id ?>';

var is_ind_loc = '<?php echo isIndiaLocation($user_office_id); ?>';

var var_js = $.parseJSON('<?php echo $var_js ?>');

console.log(var_js);

$(document).ready(function(){
    
    
    //
    // DELIVERY DATE CHECK
    //
    
    var prev_date = false;
    var max_end_date = false;

    $("#delivery_date").on("change", function(){
        frm_start_date  = new Date($(this).val());
        end_start_date  = new Date($(this).val());
        
        prev_date = frm_start_date.setDate(frm_start_date.getDate() - 6);
        prev_date_chk = new Date(prev_date);
        
        if(prev_date > new Date()){
            alert("You cannot apply for PTL now. You can apply after "+prev_date_chk+". Again select the delivery date and try again, if you want to apply for Paternity Leave.");
            $(this).val("").focus();
            $("#sub_but").prop("disabled",true);
        }
        
        max_end_date = end_start_date.setDate(end_start_date.getDate() + 30);
    });

    //
    //

    $("#from_date").datepicker({
        onSelect: function(selected){
            //$("#to_date").datepicker("option", selected);
            $("#to_date").datepicker( "option", "defaultDate", selected );

            $('#sktPleaseWait').modal('show');

            //Leave applied type for CL=2 SL=3 PL=2 CO=12 IND Location - Half Day/Full Day
            let leave_applied_type = $('#leave_form input[type=radio][name=leave_full_half_type]:checked').val();
            if (leave_applied_type==2) { 
                $("#to_date").prop("disabled",true);
                $("#to_date").val($(this).val()); 
            }
            else { 
                $("#to_date").prop("disabled",false);
                $("#to_date").val('');
            }

            // Applicable for PTL Leave
            if (var_js[$("#form-leave_type").val()][0] == 13 && is_ind_loc == 1) {
                var to_date_ptl = var_js[$("#form-leave_type").val()][1];
                to_date_ptl = Math.round(to_date_ptl);
                ptl_leave_date_range_check(to_date_ptl);
            }

            // Applicable for ML Leave
            if (var_js[$("#form-leave_type").val()][0] == 11 && (is_ind_loc == 1 || user_office_id=='JAM')) {

                const from_date_ml = $("#from_date").val();
                const user_doj = '<?php echo $date_of_joining ?>';

                var arrPrams_ml = from_date_ml.split("/");
                var actual_date_ml = arrPrams_ml[2]+'/'+arrPrams_ml[0]+'/'+arrPrams_ml[1];

                var ml_from_date = new Date(user_doj);
                var ml_to_date = new Date(from_date_ml);
               
                var ml_difference_In_Time = ml_to_date - ml_from_date;
                var ml_difference_In_Days = parseFloat(1 + ml_difference_In_Time / (1000 * 3600 * 24));

                //WP-1580
                $.post("<?php echo base_url()?>/leave/check_maternity_paternity_leave",{"leave_type_id":'11'}, function(ml_ptl_data){                
                    if (ml_ptl_data > 0) {
                    $("#sub_but").attr({style: "display: inline",});
                    var to_date_ml = var_js[$("#form-leave_type").val()][1];
                    to_date_ml = Math.round(to_date_ml);
                    ptl_leave_date_range_check(to_date_ml);
                    }
                    // }else{
                    // $("#sub_but").attr({style: "display: none",});
                    // alert('In-Valid date range selected');
                    // }
                }); 

                

            }
            
            if (user_office_id!='CAS') { date_change_checks(); }
            

            if($("#form-leave_type").val()!=""){
                if(var_js[$("#form-leave_type").val()][2] =="a"){
                    $.post("<?php echo base_url();?>leave/check_probabtion_leave_date/",{'lc_id':$("#form-leave_type").val(), 'from_dt':$(this).val()}, function(data){
                        if(parseInt(data) > 0){
                            $("#from_date, #to_date").val("");
                            $("#sub_but").attr('disabled',true); 
                            $('#sktPleaseWait').modal('hide');
                            alert("Cannot apply anymore leaves since you have applied one in the same month as per the company policy");
                        }else{                            
                            $('#sktPleaseWait').modal('hide');                        
                        }
                    });                    
                }
                else if(var_js[$("#form-leave_type").val()][0] == 13 && $("#delivery_date").val() !="" && prev_date !==false && max_end_date!==false){
                                        
                    from_date = new Date($(this).val());
                    prev_date_chk = new Date(prev_date);
                    max_end_date_chk = new Date(max_end_date);
                    
                    //console.log(from_date, prev_date_chk);
                    
                    if(from_date < prev_date_chk || from_date > max_end_date_chk){
                        alert("Invalid Date Range : Can only apply on the dates between "+prev_date_chk+" to "+max_end_date_chk);
                        $(this).val("").focus();
                    }
                    
                    $('#sktPleaseWait').modal('hide');
                }
                else $('#sktPleaseWait').modal('hide');
            }
        }
    });


    $("#to_date").datepicker({
        onSelect: function(selected){  
            $("#from_date").datepicker("option", selected);

                //JAM location & not applicable for ML Leave Type
                if(user_office_id == 'JAM' && var_js[$("#form-leave_type").val()][0] != 11) {
                    $("div.additional_section_JAM").hide();
                    $("#apply_from_vl").prop("checked", false);
                }

            ///For CAS Location (Morocco) Date range not check
            if (user_office_id=='CAS') { 
                if ($("#from_date").val()!='' && $("#to_date").val()!='') {
                    from_date = new Date($("#from_date").val());
                    to_date = new Date($("#to_date").val());
                    Difference_In_Time = to_date - from_date;
                    Difference_In_Days = parseFloat(1 + (Difference_In_Time / (1000 * 3600 * 24))); 
                    Difference_In_Days = Math.round(Difference_In_Days);

                    if(Difference_In_Days<=0){
                        $("#sub_but").attr('disabled',true);
                        alert('In-Valid Date Range selected');
                        $("#no_of_days").empty().html("<span style='color:#FF0000'>(In-Valid To Date selected. Please change it.)</span>");
                    }
                    else {
                        // $("#no_of_days").empty().html('<div class="col-md-3"><input min="1" max="365" step="any" autocomplete="off" type="number" name="no_of_days_apply_cas" value="${Difference_In_Days}" class="form-control" required></div>');
                        $("#no_of_days").empty().html('<div class="col-md-3"><input min="0.5" max="365" step="0.5" autocomplete="off" type="number" name="no_of_days_apply_cas" id="no_of_days_apply_cas" value="${Difference_In_Days}" class="form-control" onchange="noofDays();"; required></div>');
                        $("#sub_but").attr('disabled',false);
                    }
                }
                else {
                    alert("Select From Date & To Date!");
                    $("#sub_but").attr('disabled',true); 
                }
            }
            else {
                date_change_checks();
            }
        }
    });
    
    $("#apply_from_vl").click(function(){
        if($(this).prop("checked") == true){
            if(var_js[var_js[$("#form-leave_type").val()][4]][1] > 0){                
                
                //JAM location & not applicable for ML Leave Type
                if(user_office_id == 'JAM' && var_js[$("#form-leave_type").val()][0] != 11) {
                    var additional_date = new Date($("#to_date").val());
                    additional_date.setDate(additional_date.getDate() + 1);
                    additional_date.toISOString().slice(0, 10);

                    if(new Date(additional_date).getFullYear()==new Date().getFullYear()) {
                        $("div.additional_section_JAM").show();
                    }
                    else {
                        $("div.additional_section_JAM").hide();
                        $(this).prop("checked", false);
                        alert('You will not be able to take leave on next calendar year.');
                    }
                }
                else {
                    $("div.additional_section_JAM").show();
                }

            }else{
                $(this).prop("checked", false);
                alert("You cannot avail the addon facility, since there is no leave balance left");
            }            
        }else{
            $("div.additional_section_JAM").hide();
        }
    });

});

function noofDays() {
    no_of_days_apply = $("#no_of_days_apply_cas").val();
    if ($("#from_date").val()!='' && $("#to_date").val()!='') {
        from_date = new Date($("#from_date").val());
        to_date = new Date($("#to_date").val());
        Difference_In_Time = to_date - from_date;
        Difference_In_Days = parseFloat(1 + (Difference_In_Time / (1000 * 3600 * 24))); 
        Difference_In_Days = Math.round(Difference_In_Days);
        if(Difference_In_Days<=0){
            $("#sub_but").attr('disabled',true);
            alert('In-Valid Date Range selected');
            $("#no_of_days").empty().html("<span style='color:#FF0000'>(In-Valid To Date selected. Please change it.)</span>");
        }
        else {
            if(Difference_In_Days<no_of_days_apply){
                alert('In-Valid No. of Day(s) given');
                $("#sub_but").attr('disabled',true);
            }else{
                $("#sub_but").attr('disabled',false);
            }
        }
    }
    else {
        alert("Select From Date & To Date!");
        $("#sub_but").attr('disabled',true); 
    }
}

// function noofDays() {
//     no_of_days_apply = $("#no_of_days_apply_cas").val();
//     if ($("#from_date").val()!='' && $("#to_date").val()!='') {
//         from_date = new Date($("#from_date").val());
//         to_date = new Date($("#to_date").val());
//         const date = new Date();
//         Difference_In_Days = Math.round(no_of_days_apply);
//         to_date = date.setDate(from_date.getDate() + (Difference_In_Days -1));
//         $("#to_date").val(new Date(to_date).toLocaleDateString("en-US", {
//             year: "numeric",
//             month: "2-digit",
//             day: "2-digit"
//         }));
//     }
//     else {
//         alert("Select From Date & To Date!");
//         $("#sub_but").attr('disabled',true); 
//     }
// }


function date_change_checks(){
    if($("#from_date").val()!="" && $("#to_date").val()!=""){ 


           

        var leave_type_id = $("#form-leave_type").val(); 
        var leave_typeid = $("#leave_type_id").val();        
        //alert(leave_type_ids);
        if((leave_type_id !='') || leave_type_id == 40){
            from_date = new Date($("#from_date").val());
            to_date = new Date($("#to_date").val());
            
            Difference_In_Time = to_date - from_date;
            Difference_In_Days = parseFloat(1 + Difference_In_Time / (1000 * 3600 * 24)); 
           
            if(!check_date_range()){
                $("#sub_but").prop("disabled",true);                    
            }else{
                //Leave applied type for CL=2 SL=3 PL=2 CO=12 IND Location - Half Day/Full Day
                let leave_applied_type = $('#leave_form input[type=radio][name=leave_full_half_type]:checked').val();
                if(leave_applied_type==2) { $("#no_of_days").text("0.5"); }
                else { $("#no_of_days").text(Difference_In_Days); }



               if(leave_typeid ==3)
                {
                   var from_date = $("#from_date").val();
                    var to_date = $("#to_date").val();

                    if(Difference_In_Days > 3)
                    {
                         $("#sl_file_upload").show();           
                         $("#file_upload_sl").attr('required',true);
                    }else
                    {
                       var request_url = "<?=base_url()?>leave/check_date_for_sl_leave_apply?from_date="+from_date;
                    extera_day = 0;
                    $.ajax({
                        url: request_url,
                        method: 'GET', // You can use 'GET' or 'POST'
                             success: function(res) {
                                extera_day = parseInt(res) + parseInt(Difference_In_Days);
                                 if(extera_day > 3){
                                    $("#sl_file_upload").show();           
                                    $("#file_upload_sl").attr('required',true);
                                 }else{
                                     $("#sl_file_upload").hide();
                                    $("#file_upload_sl").attr('required',false);
                                 }
                                 
                             }
                  });
                   
                }
            }
               
                $("#sub_but").prop("disabled",false);  
                
                //add 11-05-2022 21:06 for applied date ready applied or not
                check_apply_date_range();

            }
        }
        
    }
    else if($("#from_date").val()=="" && $("#to_date").val()!=""){
        $("#no_of_days").empty().text('');
        $("#from_date, #to_date").val("");
        $("#sub_but").prop("disabled",true);
        alert("Please select from date");                
    }else if($("#from_date").val()=="" && $("#to_date").val()==""){
        $("#no_of_days").empty().text('');
        $("#sub_but").prop("disabled",true);
    } 
}

//
//

$('#myModal').on('hidden.bs.modal', function (e) {
    document.getElementById("leave_form").reset();
    $("#leave-balance").text('');
    clear_fields();
    $("#from_date").attr('disabled',true);
    $("#to_date").attr('disabled',true);
})

$("#form-leave_type").change(function(){

    $("#sub_but").attr({style: "display: inline",});
    $("#duplicate_to_date_ptl").remove();
    
    $("#from_date").val('');
    $("#to_date").val('');
    $("#leave-balance").text('');
    $("#no_of_days").text('');

    $("#from_date").attr('disabled',true);
    $("#to_date").attr('disabled',true);
    $("#sub_but").attr('disabled',true);
    
    if($("#form-leave_type").val()!=""){
        $('#sktPleaseWait').modal('show');
        
        if(var_js[$(this).val()][5] == 1){

            sub_html = '<option></option>';
            $.each(var_js[$(this).val()][6], function(i,v){
                sub_html += "<option value='"+i+"'>"+v.sub_leave_description+"</option>";
            });
            
            $("#sub_select_select").empty().append(sub_html);
            $(".sub_sections").show();
        }else{
            $(".sub_sections").hide();
        }


        //File upload for ML Leave option All locations
        if(var_js[$(this).val()][0] == 11){
            $("#ml_file_upload").show();           
            $("#file_upload_ml").attr('required',true);
        }else{
            $("#ml_file_upload").hide();
            $("#file_upload_ml").attr('required',false);
        }

        
    
        if(var_js[$(this).val()][1] == 0 && var_js[$(this).val()][3] != 0){
            $("#sub_but").attr('disabled',true);
            $("#from_date,#to_date").val("");
            $('#sktPleaseWait').modal('hide');
            alert('Leave Balance for the particular leave type selected is nill. Select anyother leave type to proceed');
            return false;
        }

        if(var_js[$(this).val()][4]!= '0'){           
            
            html = '';
            for(i = 1; i <= var_js[var_js[$(this).val()][4]][1]; i++){
                html += '<option>'+i+'</option>';
            }

            $('div#additional_section_JAM').show();
            $("#additional_leaves_select").empty().append(html);
            
        }else{
            $('div#additional_section_JAM').hide();
            $('div.additional_section_JAM').hide();
        }

        if(var_js[$(this).val()][3] != 0){        
            $("#leave-balance").text(var_js[$(this).val()][1]);
        } else{
            if($(this).val()==40){
                alert("You can select maximum 14 days of leave");
            }
        }       
        $("#leave_type_id").val(var_js[$(this).val()][0]);


        if(var_js[$(this).val()][0] == 13){
            alert("Applied for PTL");
            $("#ptl_div_india").show();
            $("#ptl_div_india #discharge_report").attr('required',true);
        }else{
            $("#ptl_div_india #discharge_report").removeAttr('required');
            $("#ptl_div_india").hide();
        }

        //Leave applied type for CL=2 SL=3 PL=2 CO=12 IND Location - Half Day/Full Day
        if((var_js[$(this).val()][0] == 1 || var_js[$(this).val()][0] == 2 || var_js[$(this).val()][0] == 3 || var_js[$(this).val()][0] == 12) && is_ind_loc == '1'){
            
            // $('#leave_applied_type_full_half').html('<div class="form-group"> <label class="col-md-4" style="line-height:37px;padding: 0;">Leave Apply For: </label> <div class="col-md-8"> <input ld="full" type="radio" name="leave_full_half_type" value="1" checked required> <label for="full" style="margin-right: 10px;">Full Day</label> <input type="radio" id="half" name="leave_full_half_type" value="2" required><label for="half">Half Day</label><br> </div></div>');

            $('#leave_applied_type_full_half').html('<div class="form-group"> <label class="col-md-4" style="line-height:37px;padding: 0;">Leave Apply For: </label> <div class="col-md-8"> <input ld="full" type="radio" name="leave_full_half_type" value="1" checked required> <label for="full" style="margin-right: 10px;">Full Day</label><br> </div></div>');
            
        }
        else {
            $('#leave_applied_type_full_half').html("");
        }        

        if(var_js[$(this).val()][0]>= 26 &&var_js[$(this).val()][0]<=27){
            alert("Applied for Weding");
            $("#wedding_div_moroco").show();
        }else{
            $("#wedding_div_moroco").hide();
        }

        if(var_js[$(this).val()][0]>= 28 &&var_js[$(this).val()][0]<=35){
            alert("Applied for Death");
            $("#death_div_moroco").show();
        }else{
            $("#death_div_moroco").hide();
        }

        if(var_js[$(this).val()][0]==36){
            alert("Applied for surgery");
            $("#surgery_div_moroco").show();
        }else{
            $("#surgery_div_moroco").hide();
        }
        
        if(var_js[$(this).val()][0]==39){
            $("#leave-balance").text('');
        }
        
        
    

        if(var_js[$(this).val()][2] =="a"){
            
            
            
            $.post("<?php echo base_url();?>leave/check_probabtion_leave/",{'lc_id':$(this).val()}, function(data){
                if(parseInt(data) > 0){
                    $("#sub_but").attr('disabled',true);
                    $("#from_date,#to_date").val("");
                    $('#sktPleaseWait').modal('hide');
                    alert("Cannot apply anymore leaves since you have applied one in the same month as per the company policy");
                }else{
                    $("#sub_but").attr('disabled',false);
                    $("#from_date").attr('disabled',false);
                    $("#to_date").attr('disabled',false);
                    $('#sktPleaseWait').modal('hide');
                    alert("You are in probation period then you can avail only 1 SL and CL per month");
                }
            });
        }else{
            $('#sktPleaseWait').modal('hide');
            $("#from_date").attr('disabled',false);
            $("#to_date").attr('disabled',false);
            $("#sub_but").attr('disabled',false);
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


    }else{
        $("#leave-balance").text('');
        $("#sub_select_select").empty();
        $(".sub_sections").hide();
    }
});

$(document).on('change','#apply_holiday_date',function(){

    var h_date = $("#apply_holiday_date").val();
    var leave_balance = var_js[$('#form-leave_type').val()][1];
    var h_date_count = h_date.length;

    if (h_date_count >  leave_balance) {
        alert("Available leave balance is less then selected date");
        $("#sub_but").attr('disabled',true);
    }
    else {
        $("#sub_but").attr('disabled',false);
    }
    $("#no_of_days").text(h_date_count);

})

//
///
//
$("#sub_select_select").on("change", function(){
    if($(this))clear_fields();
});


function clear_fields(){
    $("#no_of_days").text('');
    $('div#additional_section_JAM').hide();
    $('div.additional_section_JAM').hide();
    $("#sub_but").attr('disabled',true);
    $("#from_date").val('');
    $("#to_date").val('');
}


function check_date_range(){

    from_date = new Date($("#from_date").val());
    to_date = new Date($("#to_date").val());
    
    Difference_In_Time = to_date - from_date;
    Difference_In_Days = parseFloat(1 + (Difference_In_Time / (1000 * 3600 * 24))); 
    Difference_In_Days = Math.round(Difference_In_Days);

    if(Difference_In_Days<=0){
        alert('In-Valid Date Range selected');
        $("#leave-balance").text('');
        $("#no_of_days").empty().html("<span style='color:#FF0000'>(In-Valid To Date selected. Please change it.)</span>"); 
        return false;
    } 

    access = var_js[$("#form-leave_type").val()][1];

    if(var_js[$("#form-leave_type").val()][2] == "a") {
        if(var_js[$("#form-leave_type").val()][1] >0) access = 1;
        else access = 0;
    }        
    
    if(var_js[$("#form-leave_type").val()][5] == 1) {
        if($("#sub_select_select").val()!=""){
            access = var_js[$("#form-leave_type").val()][6][$("#sub_select_select").val()]["sub_deduction"];   
        }
    }else{
        $(".sub_sections").hide();
    }

    if(access < 1) access = 1;

    if(parseFloat(access) >= Difference_In_Days || Math.round(var_js[$("#form-leave_type").val()][3]) == 0){

        return true;

    }else{
        alert('In-Valid Number of days selected');
        $("#no_of_days").empty().html(Difference_In_Days + " <span style='color:#FF0000'>(In-Valid Number of days selected. Please change it.)</span>");
        return false;
    }
} 


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

<script>
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
           //add 30-05-2022 19:00 applicable for Comp Off Leave (set limit 3 leave in a month)
            if (var_js[$("#form-leave_type").val()][0] == 12 && is_ind_loc == 1) {
                check_com_off_date();
            }
            //JAM location & not applicable for ML Leave Type
            else if(user_office_id == 'JAM' && var_js[$("#form-leave_type").val()][0] != 11) {

                if(new Date(check_to_date).getFullYear()==new Date().getFullYear()) {
                    $("#sub_but").attr({style: "display: inline",});
                }
                else {
                    $("#sub_but").attr({style: "display: none",});
                    alert('You will not be able to take leave on next calendar year.');
                }
            }
            else {
                //$("#sub_but").prop("disabled",false);
                $("#sub_but").attr({style: "display: inline",});
            }
        }
        else {
            //$("#sub_but").prop("disabled",true); 
            $("#sub_but").attr({style: "display: none",});
            alert('Multiple leaves on same date not allowed, please check leave applied history');
        }                 
    },request_url, datas, 'text');  
}

///JAM Additional Leave check for next year leave apply date
$(document).on('change','#additional_leaves_select',function(){
    var additional_leave = $(this).val();
    if(user_office_id == 'JAM' && var_js[$("#form-leave_type").val()][0] != 11) {
        if(additional_leave!=""){
            var ch_to_date = $("#to_date").val();
            var additional_date = new Date(ch_to_date);
            additional_date.setDate(additional_date.getDate() + parseInt(additional_leave));
            additional_date.toISOString().slice(0, 10);

            if(new Date(additional_date).getFullYear()==new Date().getFullYear()) {
                $("#sub_but").attr({style: "display: inline",});
            }
            else {
                $("#sub_but").attr({style: "display: none",});
                alert('You will not be able to take leave on next calendar year.');
            }
        }
    }
});


</script>

<script>
    function check_com_off_date()
    {

        var check_from_date = $("#from_date").val();
        var check_to_date = $("#to_date").val();

        from_date = new Date(check_from_date);
        to_date = new Date(check_to_date);
            
        Difference_In_Time = to_date - from_date;
        Difference_In_Days = parseFloat(1 + Difference_In_Time / (1000 * 3600 * 24)); 

        var datas = { 'from_date': check_from_date, 'to_date': check_to_date, 'deff_days': Difference_In_Days};
        var request_url = "<?=base_url()?>leave/check_com_off_date_apply";

        process_ajax(function(response)
        {
            var res = JSON.parse(response);
            
            if (res.stat == true) 
            {
                //$("#sub_but").prop("disabled",false); 
                $("#sub_but").attr({style: "display: inline",});
            }
            else {
                //$("#sub_but").prop("disabled",true);
                $("#sub_but").attr({style: "display: none",});
                alert('More than 3 Comp Off can not be applied in a month');
            }                 
        },request_url, datas, 'text'); 

        //Leave applied type for CL=2 SL=3 PL=2 CO=12 IND Location - Half Day/Full Day
        let leave_applied_type = $('#leave_form input[type=radio][name=leave_full_half_type]:checked').val();
        if(leave_applied_type==2) { $("#no_of_days").text("0.5"); }
        else { $("#no_of_days").text(Difference_In_Days); }
    }    
</script>

<script>
    function ptl_leave_date_range_check(to_date)
    {
        var date_from_ptl = $("#from_date").val();
        var arrPrams = date_from_ptl.split("/");

        var actual_date = arrPrams[2]+'/'+arrPrams[0]+'/'+arrPrams[1];
        var d = new Date(actual_date);

        var split_zone = d.toString().split(" ");
        if(split_zone[5].substr(3,1)=="-") { to_date -= 1; }

        d.setDate(d.getDate() + to_date);

        var final_to_date = d.toISOString().slice(0, 10);

        var arrPrams2 = final_to_date.split("-");
        var acrtual_final_to_date = arrPrams2[1]+'/'+arrPrams2[2]+'/'+arrPrams2[0];

        $("#duplicate_to_date_ptl").remove();
        $("#to_date").val(acrtual_final_to_date);
        $("#to_date").prop("disabled", true);
        $("#leave_form").append('<input id="duplicate_to_date_ptl" type="hidden" value="'+acrtual_final_to_date+'" name="to_date">');

    }
</script>

<script>
    if(is_ind_loc==1)
    {
        var date_diff_ml = '<?php echo $ml_date_check ?>';
        //alert(date_diff_ml);
        if (date_diff_ml >= 80) {
            $("#form-leave_type option:contains('Maternity Leave ')").show();
        }
        else {
            $("#form-leave_type option:contains('Maternity Leave ')").hide();
        }
    }    
</script>

<script>
//Leave applied type for CL=2 SL=3 PL=2 CO=12 IND Location - Half Day/Full Day
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

</script>
