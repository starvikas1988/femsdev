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
                        var initial_case_type = $('#initial_case_type').val();
                        
                        var name = fname+" "+lname;
                        // alert(name);
                        $("#effect_name").val(name);
                        $("#r_initial_case_type").val(initial_case_type);
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
    $("#formtwo #diagnosed_yes").change(function(){
		var yes = $(this).val();
        if(yes == 1){
            $('#formtwo #diagnosed_date').css('display','block');
			$('#formtwo #diagnosed_date').prop('required',true); 
        }else{
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
        if(ot == 3){
            $('#formtwo #others_connect').css('display','block');
        }else{
            $('#formtwo #others_connect').css('display','none');
            $('#formtwo #connect_others').val('');
        }
    });
    $("#formtwo #fully_vaccinated").change(function(){
		var ot = $(this).val();
        if(ot == 1){
            $('#formtwo #fully_vaccinated_date').css('display','block');
        }else{
            $('#formtwo #fully_vaccinated_date').css('display','none');
            $('#formtwo #fully_vaccinated_date_val').val('');
        }
    });
    $("#formtwo #type_of_case").change(function(){
		var type = $(this).val();
        $('#formfour #r_type_of_case').val(type);
    });
    $("#formthree #disposition").change(function(){
		var type = $(this).val();
        $('#formfour #r_disposition').val(type);
    });
    $("#formone .location_attended").change(function(){
		var location_id = $(this).val();
        // $( "#formone .location_attended").children().val(location_id).prop('disabled',true);
        if(location_id == 19){
            $('#formone #others_expose').css('display','block');
            $('#formone #others_val').prop('required',true); 
        }else{
            $('#formone #others_expose').css('display','none');
            $('#formone #others_val').removeAttr('required'); 
        }
    });
    $("#add_school").click(function(){
            $('#modalAddMsn').modal('show');
			$('#sid').val();
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