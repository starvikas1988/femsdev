<script>
<?php if(!empty($ab_leaveData)){ ?>
//========================================================================================//
// LEAVE APPLY JS   
//========================================================================================//
var ab_user_office_id = '<?php echo $ab_leaveData['user_office_id']; ?>';
ab_var_js = $.parseJSON('<?php echo $ab_leaveData['var_js'] ?>');
//console.log(ab_var_js);
var baseURL = "<?php echo base_url();?>";
var processAttendanc="N";
$(document).ready(function(){
	
	/*
    $("#myLeaveModal #from_date").datepicker({
        onSelect: function(selected){
            $("#myLeaveModal #to_date").datepicker("option", selected);
            $('#sktPleaseWait').modal('show');
            date_change_checks();
            if($("#myLeaveModal #form-leave_type").val()!=""){
                if(ab_var_js[$("#myLeaveModal #form-leave_type").val()][2] =="a"){
                    $.post("<?php echo base_url();?>leave/check_probabtion_leave_date/",{'lc_id':$("#myLeaveModal #form-leave_type").val(), 'from_dt':$(this).val()}, function(data){
                        if(parseInt(data) > 0){
                            $("#myLeaveModal #from_date, #myLeaveModal #to_date").val("");
                            $("#myLeaveModal #sub_but").attr('disabled',true); 
                            $('#sktPleaseWait').modal('hide');
                            alert("Cannot apply anymore leaves since you have applied one in the same month as per the company policy");
                        }else{                            
                            $('#sktPleaseWait').modal('hide');                        
                        }
                    });                    
                }else $('#sktPleaseWait').modal('hide');
            }
			
        }
    });
    
    $("#myLeaveModal #to_date").datepicker({
        onSelect: function(selected){            
            $("#myLeaveModal #from_date").datepicker("option", selected);
            date_change_checks();
        }
    });
    */
	
    $("#apply_from_vl").click(function(){
        if($(this).prop("checked") == true){
            if(ab_var_js[ab_var_js[$("#myLeaveModal #form-leave_type").val()][4]][1] > 0){                
                $("div.additional_section_JAM").show();
            }else{
                $(this).prop("checked", false);
                alert("You cannot avail the addon facility, since there is no leave balance left");
            }            
        }else{
            $("div.additional_section_JAM").hide();
        }
    });

});

function date_change_checks(){
    if($("#myLeaveModal #from_date").val()!="" && $("#myLeaveModal #to_date").val()!=""){  

        var leave_type_id = $("#myLeaveModal #form-leave_type").val();

        if((leave_type_id !='' && ab_var_js[leave_type_id][3] != 0) || leave_type_id == 40){
            from_date = new Date($("#myLeaveModal #from_date").val());
            to_date = new Date($("#myLeaveModal #to_date").val());
            
            Difference_In_Time = to_date - from_date;
            Difference_In_Days = parseFloat(1 + Difference_In_Time / (1000 * 3600 * 24)); 
            
            if(!check_date_range()){
                $("#myLeaveModal #sub_but").prop("disabled",true);                     
            }else{
                $("#no_of_days").text(Difference_In_Days);
                $("#myLeaveModal #sub_but").prop("disabled",false);                     
            }
        }    
    }
    else if($("#myLeaveModal #from_date").val()=="" && $("#myLeaveModal #to_date").val()!=""){
        $("#no_of_days").empty().text('');
        $("#myLeaveModal #from_date, #myLeaveModal #to_date").val("");
        $("#myLeaveModal #sub_but").prop("disabled",true);
        alert("Please select from date");                
    }else if($("#myLeaveModal #from_date").val()=="" && $("#myLeaveModal #to_date").val()==""){
        $("#no_of_days").empty().text('');
        $("#myLeaveModal #sub_but").prop("disabled",true);
    } 
}

$('#myLeaveModal').on('hidden.bs.modal', function (e) {
    document.getElementById("leave_form").reset();
    $("#myLeaveModal #leave-balance").text('');
    clear_fields();
   //// $("#myLeaveModal #from_date").attr('disabled',true);
   /// $("#myLeaveModal #to_date").attr('disabled',true);
})

$("#myLeaveModal #form-leave_type").change(function(){
    
	//alert('ok');
    //$("#myLeaveModal #from_date").val('');
   // $("#myLeaveModal #to_date").val('');
   // $("#myLeaveModal #leave-balance").text('');
   // $("#no_of_days").text('');

   // $("#myLeaveModal #from_date").attr('disabled',true);
   // $("#myLeaveModal #to_date").attr('disabled',true);
   // $("#myLeaveModal #sub_but").attr('disabled',true);
    
    if($("#myLeaveModal #form-leave_type").val()!=""){
        //$('#sktPleaseWait').modal('show');

        if(ab_var_js[$(this).val()][5] == 1){

            sub_html = '<option></option>';
            $.each(ab_var_js[$(this).val()][6], function(i,v){
                sub_html += "<option value='"+i+"'>"+v.sub_leave_description+"</option>";
            });
            
            $("#myLeaveModal #sub_select_select").empty().append(sub_html);
            $("#myLeaveModal .sub_select_select").show();
        }else{
            $("#myLeaveModal .sub_select_select").hide();
        }

        if(ab_var_js[$(this).val()][1] == 0 && ab_var_js[$(this).val()][3] != 0){
            $("#myLeaveModal #sub_but").attr('disabled',true);
            //$("#myLeaveModal #from_date,#myLeaveModal #to_date").val("");
            //$('#sktPleaseWait').modal('hide');
            $('#leave-balance').text(0);
            alert('Leave Balance for the particular leave type selected is nill. Select anyother leave type to proceed');
            return false;
        }

        if(ab_var_js[$(this).val()][4]!= '0'){           
            
            html = '';
            for(i = 1; i <= ab_var_js[ab_var_js[$(this).val()][4]][1]; i++){
                html += '<option>'+i+'</option>';
            }

            $('div#additional_section_JAM').show();
            $("#additional_leaves_select").empty().append(html);
            
        }else{
            $('div#additional_section_JAM').hide();
            $('div.additional_section_JAM').hide();
        }

        if(ab_var_js[$(this).val()][3] != 0){        
            $("#myLeaveModal #leave-balance").text(ab_var_js[$(this).val()][1]);
        } else{
            if($(this).val()==40){
                alert("You can select maximum 14 days of leave");
            }
        }       
        $("#leave_type_id").val(ab_var_js[$(this).val()][0]);



        if(ab_var_js[$(this).val()][2] =="a"){

            $.post("<?php echo base_url();?>leave/check_probabtion_leave/",{'lc_id':$(this).val()}, function(data){
                if(parseInt(data) > 0){
                    $("#myLeaveModal #sub_but").attr('disabled',true);
                    $("#myLeaveModal #from_date,#myLeaveModal #to_date").val("");
                   // $('#sktPleaseWait').modal('hide');
                    alert("Cannot apply anymore leaves since you have applied one in the same month as per the company policy");
                }else{
                    $("#myLeaveModal #sub_but").attr('disabled',false);
                   // $("#myLeaveModal #from_date").attr('disabled',false);
                   // $("#myLeaveModal #to_date").attr('disabled',false);
                    //$('#sktPleaseWait').modal('hide');
                    alert("You are in probation period then you can avail only 1 SL and CL per month");
                }
            });
        }else{
            $('#sktPleaseWait').modal('hide');
           // $("#myLeaveModal #from_date").attr('disabled',false);
           // $("#myLeaveModal #to_date").attr('disabled',false);
            $("#myLeaveModal #sub_but").attr('disabled',false);
        }

    }else{
        $("#myLeaveModal #leave-balance").text('');
        $("#myLeaveModal #sub_select_select").empty();
        $("#myLeaveModal .sub_select_select").hide();
    }
});

////////////////////////////////////////////////////////////////////
// $('.frmAddReferrals').submit(function(e) {
		
// 		alert('OK1');
		
// 		var refName=$('.frmAddReferrals #name').val();
// 		var refPhone=$('.frmAddReferrals #phone').val();
// 		var refEmail=$('.frmAddReferrals #email').val();
// 		var refPosition=$('.frmAddReferrals #position').val();
		
// 		var form = $('#frmAddReferrals');
// 		var formData = new FormData(form[0]);
		
// 		var fileName = $('.frmAddReferrals #r_cv_attach').val();
// 		/*if(fileName == ""){
// 			alert('CV Not Selected');
// 			return false;
// 		}*/
// 		if(fileName != ""){
// 		var extension = $('.frmAddReferrals #r_cv_attach').val().split('.').pop().toLowerCase();
// 		if($.inArray(extension, ['pdf']) == -1){
// 			alert('Sorry, Only PDF File Allowed');
// 			return false;
// 		   }
// 	    }
// 		 //&& fileName!='' && extension == 'pdf'
// 		if(refName!='' && refPhone!='' && refEmail!='' && refPosition!=''){
			
// 			///alert("<?php echo base_url();?>home/addreferral?"+$('form.frmAddReferrals').serialize());
// 		//if ($(form).valid()) {
			
// 			$('#sktPleaseWait').modal('show');
			
// 			$.ajax({
// 				type	:	'POST',
// 				url		:	'<?php echo base_url();?>homecha/addreferral',
// 				//data	:	$('form.frmAddReferrals').serialize(),
// 				data	:	formData,
// 				contentType: false, //this is requireded
// 				processData: false, //this is requireded
// 				success	:	function(msg){
// 					//console.log(msg);
					
// 					$('#sktPleaseWait').modal('hide');
// 					$("#addReferrals").modal('hide');
					
// 					//window.location.reload();
// 					$(".frmAddReferrals #name").val('');
// 					$(".frmAddReferrals #phone").val('');
// 					$(".frmAddReferrals #email").val('');
// 					$(".frmAddReferrals #position").val('');
// 					$(".frmAddReferrals #comment").val('');
// 					$('.frmAddReferrals #r_cv_attach').val('');
					
// 					alert('Successfully Submit Your Referrals');
// 				},
// 				error : function(msg){
// 					$('#sktPleaseWait').modal('hide');
// 					alert('Something Went Wrong!');
// 				}
// 			});
// 		}else{
// 			alert('Fill the form correctly...');
// 		}
// 	});
	
////////////////////////////////

// Extra code conflict with Hone.js same event. commented by saikat 
/*	
$("#viewModalAttendance").click(function(){
		console.log('ok');
		if(processAttendanc=="Y"){
			
			$('#attendance_model').modal('show');
			
		}else{
			
			$('#sktPleaseWait').modal('show');
			
			var rURL=baseURL+'homecha/getCurrentAttendance';
			
			$.ajax({
			   type: 'POST',    
			   url:rURL,
			   success: function(tbDtata){
				   
				   $('#sktPleaseWait').modal('hide');
				   $('#attendance_model').modal('show');	
				   $('#currAttendanceTable').html(tbDtata);
				   processAttendanc = "Y";
				   
				},
				error: function(){	
					alert('Fail!');
					$('#sktPleaseWait').modal('hide');
				}
			  });
		
		}
		////
	});
*/

$("#myLeaveModal #sub_select_select").on("change", function(){
    if($(this))clear_fields();
});

$("#myLeaveModal #sub_select_select").on("change", function(){
    if($(this))clear_fields();
});


function clear_fields(){
    $("#no_of_days").text('');
    $('div#additional_section_JAM').hide();
    $('div.additional_section_JAM').hide();
    $("#myLeaveModal #sub_but").attr('disabled',true);
    $("#myLeaveModal #from_date").val('');
    $("#myLeaveModal #to_date").val('');
}


function check_date_range(){

    from_date = new Date($("#myLeaveModal #from_date").val());
    to_date = new Date($("#myLeaveModal #to_date").val());
    
    Difference_In_Time = to_date - from_date;
    Difference_In_Days = parseFloat(1 + (Difference_In_Time / (1000 * 3600 * 24))); 

    if(Difference_In_Days<=0){
        alert('In-Valid Date Range selected');
        $("#myLeaveModal #leave-balance").text('');
        $("#no_of_days").empty().html("<span style='color:#FF0000'>(In-Valid To Date selected. Please change it.)</span>"); 
        return false;
    } 

    access = ab_var_js[$("#myLeaveModal #form-leave_type").val()][1];

    if(ab_var_js[$("#myLeaveModal #form-leave_type").val()][2] == "a") {
        if(ab_var_js[$("#myLeaveModal #form-leave_type").val()][1] >0) access = 1;
        else access = 0;
    }        
    
    if(ab_var_js[$("#myLeaveModal #form-leave_type").val()][5] == 1) {
        if($("#myLeaveModal #sub_select_select").val()!=""){
            access = ab_var_js[$("#myLeaveModal #form-leave_type").val()][6][$("#myLeaveModal #sub_select_select").val()]["sub_deduction"];   
        }
    }else{
        $("#myLeaveModal .sub_select_select").hide();
    }

    if(access < 1) access = 1;

    if(parseFloat(access) >= Difference_In_Days){
        return true;
    }else{
        alert('In-Valid Number of days selected');
        $("#no_of_days").empty().html(Difference_In_Days + " <span style='color:#FF0000'>(In-Valid Number of days selected. Please change it.)</span>"); 
        return false;
    }
} 
<?php } ?>
</script>