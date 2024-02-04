<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script>
	$(document).ready(function(){
        var baseURL="<?php echo base_url(); ?>";
            $("#correct_letter").select2();
			$("#contact-trace").click(function(e){
                // $("#contact-tracing").hide();
				// $("#case-detail").show();
                    // alert('ok');
                    let valid = true;
                    $('#formone [required]').each(function() {
                    if ($(this).is(':invalid') || !$(this).val()) valid = false;
                    })
                    if(!valid) alert("please fill all required fields!");
                    else{
                        e.preventDefault();
                        $('#sktPleaseWait').modal('show');	
                        // var frm = $('#formone');    
                        // var formData = new FormData(frm);
                        var fname = $('#c_fname').val();
                        var lname = $('#c_lname').val();
                        var initial_case_type = $('#initial_case_type  option:selected').text();
                        // $("#yourdropdownid option:selected").text();
                        
                        var name = fname+" "+lname;
                        // alert(name);
                        $("#effect_name").val(name);
                        $("#r_initial_case_type").val(initial_case_type);
                        $("#r2_initial_case_type").val(initial_case_type);
                        $("#r3_initial_case_type").val(initial_case_type);
                        var formData = new FormData(document.getElementById("formone"));
                        $.ajax({
                        	url: baseURL+'howard_training/saveFormOne',
                        	type: 'POST',
                        	data: formData,
                        	cache: false,
                        	contentType: false,
                        	processData: false,
                        	success: function (data) {
                                $('#sktPleaseWait').modal('hide');
                        		$("#contact-tracing").hide();
                        		$("#case-detail").show();
                        	},
                        });
                        return false;
                    }
		    });
            $("#back_one").click(function(){
                $('#sktPleaseWait').modal('show');	
                $("#contact-tracing").show();
                $("#case-detail").hide();
                $('#sktPleaseWait').modal('hide');
            });
            
		$("#case-inner").click(function(e){
		
            let valid = true;
            $('#formtwo [required]').each(function() {
            if ($(this).is(':invalid') || !$(this).val()) valid = false;
            })
            if(!valid) alert("please fill all required fields!");
            else{
                e.preventDefault();
                $('#sktPleaseWait').modal('show');	
                var formData = new FormData(document.getElementById("formtwo"));
                $.ajax({
                    url: baseURL+'howard_training/saveFormTwo',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $("#case-detail").hide();
                        $("#contact-tracing-new").show();
                        $('#sktPleaseWait').modal('hide');
                    },
                    
                });
                return false;
            }
		});
            $("#back_two").click(function(){
                $('#sktPleaseWait').modal('show');	
                $("#case-detail").show();
                $("#contact-tracing-new").hide();
                $('#sktPleaseWait').modal('hide');
                
            });
		
		$("#tracing-save").click(function(e){
                let valid = true;
                $('#formthree [required]').each(function() {
                if ($(this).is(':invalid') || !$(this).val()) valid = false;
                })
                if(!valid) alert("please fill all required fields!");
                else{
                    e.preventDefault();
                    $('#sktPleaseWait').modal('show');	
                    var formData = new FormData(document.getElementById("formthree"));
                    $.ajax({
                        url: baseURL+'howard_training/saveFormThree',
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $("#contact-tracing-new").hide();
                            $("#final-call").show();
                            $('#sktPleaseWait').modal('hide');
                        },
                    });
                    return false;
                }
		});
            $("#back_three").click(function(){
                $('#sktPleaseWait').modal('show');
                $("#contact-tracing-new").show();
                $("#final-call").hide();
                $('#sktPleaseWait').modal('hide');
               
            });
        $("#map-next").click(function(e){
            let valid = true;
            $('#formfour [required]').each(function() {
            if ($(this).is(':invalid') || !$(this).val()) valid = false;
            })
            if(!valid) alert("please fill all required fields!");
            else{
                e.preventDefault();
                $('#sktPleaseWait').modal('show');	
                var formData = new FormData(document.getElementById("formfour"));
                $.ajax({
                    url: baseURL+'howard_training/saveFormFour',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $("#final-call").hide();
                        $("#map-area").show();
                        $('#sktPleaseWait').modal('hide');
                        window.location.href = (baseURL+'howard_training/case_list');
                    }
                });
                return false;
            }
		});
		
        $(".editschool").click(function(){
            var params=$(this).attr("params");
			
			var id=$(this).attr("id");
			var arrPrams = params.split("#");
			$('#sid').val(id);
			$('#name').val(arrPrams[0]);
			$('#grades').val(arrPrams[1]);
			$('#address').val(arrPrams[2]);
			$('#county').val(arrPrams[3]);
			$('#city').val(arrPrams[4]);
            $('#modalAddMsn').modal('show');
    });

    $("#formone #school").change(function(){
		var school = $(this).val();
        $.ajax({
            url: baseURL+'howard_training/on_school',
            type: 'GET',
            data: 'school='+ school,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                var a = JSON.parse(data);
                // console.log(a[0].grades);
                $('#formone #grades').val(a[0].grades);
                $('#formone #address').val(a[0].address);
                $('#formtwo #childs_school').val(a[0].name);
                $('#formtwo #school_location').val(a[0].address);
        
            }
        });
    });
    $("#formone #school2").change(function(){
		var school = $(this).val();
        $.ajax({
            url: baseURL+'howard_training/on_school',
            type: 'GET',
            data: 'school='+ school,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                var a = JSON.parse(data);
                // console.log(a[0].grades);
                $('#formone #grades2').val(a[0].grades);
                $('#formone #address2').val(a[0].address);
                $('#formtwo #childs_school2').val(a[0].name);
                $('#formtwo #school_location2').val(a[0].address);
            }
        });
    });
    $("#name_of_facility").change(function(){
        var school = $(this).val();
        $.ajax({
            url: baseURL+'howard_training/on_school',
            type: 'GET',
            data: 'school='+ school,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                var a = JSON.parse(data);
               
                $('#facility_address').val(a[0].address);
                
        
            }
        });
    });
    
    $("#formtwo #diagnosed_yes").change(function(){
		var yes = $(this).val();
        if((yes == 1)||(yes==3)){
            $('#formtwo #diagnosed_date').css('display','block');
			$('#formtwo #diagnosed_date').prop('required',true); 
        }
        else{
            $('#formtwo #diagnosed_date').removeAttr("required");
            $('#formtwo #diagnosed_date').css('display','none');
            $('#formtwo #diagnosed_date').val('');
        }
    });
    $("#formtwo #front_door").change(function(){
		var ot = $(this).val();
        if(ot == 4){
            $('#formtwo #others_door').css('display','block');
        }else{
            $('#formtwo #others_door').css('display','none');
            $('#formtwo #doors_other').val('');
        }
    });
    $("#formtwo #close_connect").change(function(){
		var ot = $(this).val();
        search_ex();
        if(ot == 3){
            $('#formtwo #others_connect').css('display','block');
             $('#close_connect_ref').css('display','none');
             $('#contact_close_ref').val('');
        }
        else if(ot==1){
            $('#formtwo #others_connect').css('display','none');
            $('#formtwo #connect_others').val('');
            $('#close_connect_ref').css('display','block');
        }
        else{
            $('#formtwo #others_connect').css('display','none');
            $('#formtwo #connect_others').val('');
            $('#close_connect_ref').css('display','none');
            $('#contact_close_ref').val('');
            
        }
    });
    $("#formtwo #fully_vaccinated").change(function(){
		var ot = $(this).val();
        if(ot == 1){
            $('#formtwo #fully_vaccinated_date').css('display','block');
            $('#formtwo .fdose').css('display','none');
            $('#formtwo #first_vaccinated_date').css('display','none');
            $('#formtwo #first_vaccinated_date_val').val('');
            $('#formtwo .final_shot').css('display','block');
        }else{
            $('#formtwo #fully_vaccinated_date').css('display','none');
            $('#formtwo #fully_vaccinated_date_val').val('');
            $('#formtwo .fdose').css('display','block');
            $('#formtwo .final_shot').css('display','none');
        }
    });
    $("#formtwo #first_dose").change(function(){
        var ot = $(this).val();
        if(ot == 1){
            $('#formtwo #first_vaccinated_date').css('display','block');
        }else{
             $('#formtwo #first_vaccinated_date').css('display','none');
            $('#formtwo #first_vaccinated_date_val').val('');
           
        }
    });

    // $("#formtwo #type_of_case").change(function(){
	// 	var type = $(this).val();
    //     $('#formfour #r_type_of_case').val(type);
    // });
    $("#formfour #disposition").change(function(){
		var disposition = $(this).val();
        if(disposition == 5){
            $('#formfour #disposition_expose').css('display','block');
            // $('#formfour #others_disposition').prop('required',true); 
            $('#extra_data_field').css('display','none');
        }else{
            $('#formfour #others_expose').css('display','none');
            $('#extra_data_field').css('display','none');
            // $('#formfour #others_disposition').removeAttr('required'); 
            if(disposition == 1||disposition ==2||disposition == 3){
                $('#extra_data_field').css('display','block');
            }
        }
    });
    $("#formfour #final_case_type").change(function(){
		var final_case_type = $(this).val();
        if(final_case_type == 6){
            $('#formfour #final_case_type_expose').css('display','block');
            // $('#formfour #others_disposition').prop('required',true); 
        }else{
            $('#formfour #final_case_type_expose').css('display','none');
            // $('#formfour #others_disposition').removeAttr('required'); 
        }
    });
    $("#formone .location_attended").change(function(){
		var location_id = $(this).val();
        chk=0; 
        // $( "#formone .location_attended").children().val(location_id).prop('disabled',true);
        if(location_id == 19){
            $('#formone #others_expose').css('display','block');
            $('#formone #others_val').prop('required',true); 
        }else{
               
            $('.location_attended').each(function() {
                var loc = $(this).val();
                if(loc==19){
                    chk=1;
                }
            });
            
            if(chk==0){
                $('#formone #others_expose').css('display','none');
                $('#formone #others_val').removeAttr('required');
            } 
        }
    });
    $("#add_school").click(function(){
            $('#modalAddMsn').modal('show');
			$('#sid').val();
        }); 
    $('#test_type').change(function(){
        type=$(this).val();
        if(type!=''){
            if(type==1){
                $('#display_test_type').css('display','block');
                $('#display_rapid_test').css('display','block');
                $('#display_other_type').css('display','none');
                $('#other_type').html('');
            }else if(type==2){
                $('#display_test_type').css('display','block');
                $('#display_rapid_test').css('display','none');
                $('#display_other_type').css('display','block');
                $('#other_type').html('');
            }
        }else{
            $('#display_test_type').css('display','none');
            $('#other_type').html('');
        }
    });
    $("#btnAddSchool").click(function(e){
            let valid = true;
            $('#frmAddSchool [required]').each(function() {
            if ($(this).is(':invalid') || !$(this).val()) valid = false;
            })
            if(!valid) alert("please fill all required fields!");
            else{
                e.preventDefault();
                $('#sktPleaseWait').modal('show');	
                var formData = new FormData(document.getElementById("frmAddSchool"));
                $.ajax({
                    url: baseURL+'howard_training/saveSchool',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('#sktPleaseWait').modal('hide');
                        location.reload();
                    }
                });
                return false;
            }
		});
		$("#contact-trace").click(function(){
			 $('html, body').animate({scrollTop:0}, 'slow');
        return false;
		});
		$("#case-inner").click(function(){
			 $('html, body').animate({scrollTop:0}, 'slow');
        return false;
		});
		$("#tracing-save").click(function(){
			 $('html, body').animate({scrollTop:0}, 'slow');
        return false;
		});
        $('#date_first_sym').datepicker({ 
            dateFormat: 'yy-mm-dd',
            changeMonth: true, 
            changeYear: true, 
            yearRange: '1940:' + new Date().getFullYear().toString(),
            onSelect: function() {
                dateChanger();
            }
            });
            dateChanger();
            function dateChanger(){
                var e_date = $('#date_first_sym').val() + ' 00:00:00';

                e_currDate = new Date(e_date);
                e_currDate.setDate(e_currDate.getDate() - 3);
                n = 1;
                console.log(e_currDate);
                console.log(('0' + (e_currDate.getMonth()+1)).slice(-2));
                for(i=0;i<7;i++)
                {
                    //e_addDate = e_currDate.getTime() +  (1 * 24 * 60 * 60 * 1000);
                    //e_currDate = new Date(e_addDate);
                    e_currDate.setDate(e_currDate.getDate() + n);
                    $('#e_date_'+i).val(e_currDate.getFullYear()+'-'+('0' + (e_currDate.getMonth()+1)).slice(-2)+'-'+('0' + e_currDate.getDate()).slice(-2));
                }
            }
	});
    

</script>