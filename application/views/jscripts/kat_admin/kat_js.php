<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script> -->
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script type="text/javascript">
	$('#default-datatable').DataTable({
		"pageLength":50
	});

    $(document).ready(function(){
        var baseURL ="<?php echo base_url(); ?>";
        $("#add_msn").click(function(){
            $('#modalAddMsn').modal('show');
        }); 
        $("#add_nggt").click(function(){
            // $('#mission option:selected').removeAttr('selected');
            $("#mission").val('');

            $('#append').empty();
            $('#dpdf').empty();
            $(".form-control").val('');
            $('#description').summernote('code', '');

            $('#modalAddNggt').modal('show');
        });
        $("#add_qstn").click(function(){
            $('#modalAddQstn').modal('show');
        });
        $("#new_access").click(function(){
            $('#modalAccess').modal('show');
        });
        $("#client").select2();
        $("#e_client").select2();
        $("#process").select2();
        $("#e_process").select2();
        $("#department").select2();
        $("#location").select2();
        $("#organization_role").select2();
        $("#mission").select2();
        $("#users").select2();
        $("#agents").select2();
        $("#questions").select2();
        $("#nuid").select2();
        $('#description').summernote({
                toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                ], // optional, if you want to show specific tools declare toolbar accordingly
                height: 100, // set height
        });

        

        // $("#btnAddMsn").click(function(e){
       $(document).on('submit','.frmAddMsn',function(e){
            let valid = true;
            $('.frmAddMsn [required]').each(function() {
            if ($(this).is(':invalid') || !$(this).val()) valid = false;
            })
            if(!valid) alert("please fill all fields!");
            else{
                e.preventDefault();
                $('#sktPleaseWait').modal('show');	
                // var a = $('#msnForm').serialize();
                var formData = new FormData(this);
                // console.log(formData);
                    $.ajax({
                    type: 'POST',    
                    url:baseURL+'kat_admin/add_mission',
                    // data:$('form.frmAddMsn').serialize(),
                    // data:$('#msnForm').serialize(),
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(msg){
                        $('#sktPleaseWait').modal('hide');
                        $('#modalAddQstn').modal('hide');
                        location.reload();
                        }	
                    });
            }

        });
       $(document).on('submit','.frmAddNggt',function(e){
            let valid = true;
            $('.frmAddNggt [required]').each(function() {
            if ($(this).is(':invalid') || !$(this).val()) valid = false;
            })
            if(!valid) alert("please fill all fields!");
            else{
                e.preventDefault();
                $('#sktPleaseWait').modal('show');	
                // var frm = $('form.frmAddNggt');    
                var formData = new FormData(this);
                // console.log(formData);
                $.ajax({
                    url: baseURL+'kat_admin/add_nugget',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        // alert("Data Uploaded: "+data);
                        $('#sktPleaseWait').modal('hide');
                        $('#modalAddQstn').modal('hide');
                        location.reload();
                    },
                    
                });
                return false;
            }
        });
        $(document).on('change','#pdf',function(){
		        var file = $('#pdf').val();
                var ext = file.slice((file.lastIndexOf(".") - 1 >>> 0) + 2);
                // const accpt_types = ["txt","doc","docx","ppt","pdf","mp4","wmv","mpeg-4","mpeg","flv","webm","mkv","3gp","pptx"];
                const accpt_types = ["txt","doc","docx","ppt","pdf","mp4","webm","pptx"];
                if(!accpt_types.includes(ext)){
                    document.getElementById("filerror").innerHTML = "File type is not correct!";
                    $("#pdf").val('');
                }else{
                    $('#filerror').empty();
                }
                if(this.files[0].size > 52428800){
                    document.getElementById("filesizerror").innerHTML = "File size can not be greater than 50 MB!";
                    $("#pdf").val('');
                }else{
                    $('#filesizerror').empty();
                }
        });
       

        $("#btnEditQstn").click(function(){
            let valid = true;
            $('.btnEditQstn [required]').each(function() {
            if ($(this).is(':invalid') || !$(this).val()) valid = false;
            })
            if(!valid) alert("please fill all fields!");
            else{
                $('#sktPleaseWait').modal('show');	
                    $.ajax({
                    type: 'POST',    
                    url:baseURL+'kat_admin/add_question',
                    // data:$('form.frmAddMsn').serialize(),
                    data:$('#qstnForm').serialize(),
                    success: function(msg){
                                $('#sktPleaseWait').modal('hide');
                                $('#modalAddQstn').modal('hide');
                                location.reload();
                        }	
                    });
            }

        });
        $(document).on('submit','.frmAccess',function(e){
            let valid = true;
            $('.frmAccess [required]').each(function() {
            if ($(this).is(':invalid') || !$(this).val()) valid = false;
            })
            if(!valid) alert("please fill all fields!");
            else{
                e.preventDefault();
                $('#sktPleaseWait').modal('show');	
                // var frm = $('form.frmAddNggt');    
                var formData = new FormData(this);
                // console.log(formData);
                $.ajax({
                    url: baseURL+'kat_admin/add_access',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('#sktPleaseWait').modal('hide');
                        $('#modalAccess').modal('hide');
                        location.reload();
                    },
                    
                });
                return false;
            }
        });

        
	$(".editqstn").click(function(){
		var params = $(this).attr("params");
		var id = $(this).attr("id");	
		var arrPrams = params.split("#"); 
		// alert(arrPrams);
		$('#qid').val(id);

		// alert(arrPrams[1]);
		$('#question').val(arrPrams[1]);
		$('#option1').val(arrPrams[2]);
		$('#option2').val(arrPrams[3]);
		$('#option3').val(arrPrams[4]);
		$('#option4').val(arrPrams[5]);
        $('#coption').val(arrPrams[6]);
        $('#nugget_id').val(arrPrams[7]);
        $('#organization_role').val(arrPrams[8]);

		$('#modalAddQstn').modal('show');
	});
    $("#edit_status").change(function(){
        // alert('hi');
        var edit_status = $('#edit_status').val(); 
        if(edit_status == 2){
           $("#comm").css({ display: "block" });
           $("#comments").prop('required',true);
        }else{
            $("#comm").css({ display: "none" });
            $("#comments").removeAttr("required");

        }
    });
    $(".editstat").click(function(){
		var params=$(this).attr("params");
		var id = $(this).attr("id");	
		var arrPrams = params.split("#"); 
		$('#id_stat').val(id);
		$('#edit_status').val(arrPrams[0]);
		$('#modalEditstat').modal('show');
	});

    $("#btnEditstat").click(function(){
		let valid = true;
		$('.frmEditstat [required]').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
		if(!valid) alert("please fill all fields!");
		else{
			$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'kat_admin/update_stat',
				   data:$('form.frmEditstat').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalEditstat').modal('hide');
							location.reload();
					}	
				});
		}

	});
    // $(".editmission").click(function(){
	// 	var params = $(this).attr("params");
	// 	var id = $(this).attr("id");	
	// 	var arrPrams = params.split("#"); 
	// 	// alert(arrPrams);
	// 	$('#mid').val(id);

	// 	// alert(arrPrams[1]);
	// 	$('#title').val(arrPrams[1]);
	// 	// $('#location').val(arrPrams[2]);
    //     var option_value_location = arrPrams[2];
    //     var substr_location = option_value_location.split(',');
    //     var i_location;
    //     for (i_location = 0; i_location < substr_location.length; ++i_location) {
    //         var a_location = substr_location[i_location];
    //         // alert(a);
    //         $("#location option[value='" + a_location + "']").attr("selected","selected");
    //     }
	// 	// $('#client').val(arrPrams[3]);
       
    //     var option_value_client = arrPrams[3];
    //     var substr_client = option_value_client.split(',');
    //     var i_client;
    //     for (i_client = 0; i_client < substr_client.length; ++i_client) {
    //         var a_client = substr_client[i_client];
    //         // alert(a);
    //         $("#client option[value='" + a_client + "']").attr("selected","selected");
    //     }
        
	// 	// $('#process').val(arrPrams[4]);
    //     var option_value_process = arrPrams[4];
    //     var substr_process = option_value_process.split(',');
    //     var i_process;
    //     for (i_process = 0; i_process < substr_process.length; ++i_process) {
    //         var a_process = substr_process[i_process];
    //         // alert(a);
    //         $("#process option[value='" + a_process + "']").attr("selected","selected");
    //     }
	// 	// $('#department').val(arrPrams[5]);
    //     var option_value = arrPrams[5];
    //     var substr_department = option_value.split(',');
    //     var i_department;
    //     for (i_department = 0; i_department < substr_department.length; ++i_department) {
    //         var a_department = substr_department[i_department];
    //         // alert(a);
    //         $("#department option[value='" + a_department+ "']").attr("selected","selected");
    //     }
	// 	$('#start_date').val(arrPrams[6]);
	// 	$('#end_date').val(arrPrams[7]);
	// 	$('#organization_role').val(arrPrams[8]);

	// 	$('#modalAddMsn').modal('show');
	// });
    $(".editmission").click(function(){
		var id = $(this).attr("id"); 
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_admin/edit_mission',
            data:'id='+ id,
            success: function(code){
                $('#modalAddMsn').modal('show');
                $('#msnForm').empty();
                $('#msnForm').html(code);
                $("#client").select2();
                $("#process").select2();
                $("#department").select2();
                $("#location").select2();
                $("#organization_role").select2();
                $("#modalAddMsn #e_client").select2();
                $("#modalAddMsn #e_process").select2();
                $("#append").css({ display: "block" });
            }
        });
    });
    $(".editnugget").click(function(){
		var params = $(this).attr("params");
		var id = $(this).attr("id");	
		var arrPrams = params.split("#"); 
		// alert(arrPrams);
		$('#nid').val(id);

		// alert(arrPrams[1]);
		$('#title').val(arrPrams[1]);
		$('#mission').val(arrPrams[2]).trigger('change');
		$('#start_date').val(arrPrams[3]);
		$('#end_date').val(arrPrams[4]);
		$('#points').val(arrPrams[5]);
		// $('#description').val(arrPrams[6]);
		$('#passmarks').val(arrPrams[7]);
        $("#pdf").removeAttr("required");
        $("#csv").removeAttr("required");
        $('#description').summernote('code', arrPrams[6]);
        $('#qcount').text(arrPrams[10]+' questions');
        $('#dpdf').text(arrPrams[11]);
		$('#max_time').val(arrPrams[12]);

        $("#append").css({ display: "block" });
        // $("#append :input").prop('required',true);
		$('#modalAddNggt').modal('show');
	});
    $(".mission-repeat").click(function(){
        var title = $(this).data('title');
        $('#modal_title').text(title);
        var nid = $(this).data('id');
        // var points = $(this).data('points');
        // $('#points-dump').text(points+" points");
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_agent/get_question',
            data:'nid='+ nid,
            success: function(code){
                $('#my-mission').empty();
                $('#my-mission').html(code);
            }
        });
       
		$('#exam_panel').modal('show');
	});
    $(".editaccess").click(function(){
		var id = $(this).attr("id"); 
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_admin/edit_access',
            data:'id='+ id,
            success: function(code){
                $('#modalAccess').modal('show');
                $('#accessForm').empty();
                $('#accessForm').html(code);
                $("#mission").select2();
                $("#users").select2();
            }
        });
    });
    $(".deleteaccess").click(function(){
		var id = $(this).attr("id"); 
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_admin/delete_access',
            data:'id='+ id,
            success: function(msg){
                if(msg == '{"status":"done"}'){
                    location.reload();
                }
            }
        });
    });
    $("#client").change(function(){
        // alert('hi');
        var clients = $('#client').val(); 
        // console.log(clients);
        $.ajax({
            type: 'GET',    
            url:baseURL+'kat_admin/get_process_by_clients',
            data:'clients='+ clients,
            success: function(data){
                // $('#change-process').empty();
                // $('#change-process').html(code);
                var res;
				var i=0;
				var a = JSON.parse(data); 
				
				var b = $("#process").val();
				$("#process option").remove();
			
				if(b != null){ 
					var res =  b.toString().split(',');
					var leng = res.length;
				}
				
				
				$.each(a, function(index,jsonObject){
					
					if( i < leng){
						if(jsonObject.id == res[i]){
								$("#process").append('<option value="'+jsonObject.id+'" selected="selected">' + jsonObject.name + '</option>');
								i++;
						}else{
							   $("#process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
						}
					}else{
						$("#process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
					}
					
					
				});	
            }
        });
    });
    $('#mid').on('change', function() {
        var mid = this.value;
        $.ajax({
            type: 'GET',    
            url:baseURL+'kat_agent/getNuggetsByMission',
            data:'mid='+ mid,
            success: function(code){
                 $('#nuggets_list').empty();
                $('#nuggets_list').html(code);
            }
        })
    });
    $('#missionid').on('change', function() {
        var mid = this.value;
        $.ajax({
            type: 'GET',    
            url:baseURL+'kat_agent/getNuggetsByMissionForScore',
            data:'mid='+ mid,
            success: function(code){
                 $('#nuggets_list').empty();
                 $('#nuggets_list').html(code);
                 $("#nuid").select2();

            }
        })
    });
    $(document).on('change','#nuid',function(){
    // $('#nuid').on('change', function() {
        var nid = this.value;
        // alert(nid);
        $.ajax({
            type: 'GET',    
            url:baseURL+'kat_agent/getQuestionsByNuggets',
            data:'nid='+ nid,
            success: function(code){
                 $('#questions_list').empty();
                 $('#questions_list').html(code);
                 $("#qid").select2();

            }
        })
    });
    $("#modalAddMsn").on('change','#e_client',function(){
        // alert('hi');
        var clients = $(this).val(); 
        // console.log(clients);
        $.ajax({
            type: 'GET',    
            url:baseURL+'kat_admin/get_process_by_clients',
            data:'clients='+ clients,
            success: function(data){
                // $('#change-process').empty();
                // $('#change-process').html(code);
                var res;
				var i=0;
				var a = JSON.parse(data); 
				
				var b = $("#modalAddMsn #e_process").val();
				$("#modalAddMsn #e_process option").remove();
			
				if(b != null){ 
					var res =  b.toString().split(',');
					var leng = res.length;
				}
				
				
				$.each(a, function(index,jsonObject){
					
					if( i < leng){
						if(jsonObject.id == res[i]){
								$("#modalAddMsn #e_process").append('<option value="'+jsonObject.id+'" selected="selected">' + jsonObject.name + '</option>');
								i++;
						}else{
							   $("#modalAddMsn #e_process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
						}
					}else{
						$("#modalAddMsn #e_process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
					}
					
					
				});	
                $("#modalAddMsn #e_client").select2();
                $("#modalAddMsn #e_process").select2();
            }
        });
    });
   
});
function close_modal(){
   var id = $("#nugget_id").val();
    if (confirm('Are you sure to close?')) {
        var baseURL ="<?php echo base_url(); ?>";
        clearInterval(window.runTimer);
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_agent/on_close',
            data:'nid='+ id,
            success: function(ans){
                if(ans == '{"status":"done"}'){
                  $("#exam_panel").fadeOut();
                }
            }
        });
        $('#doc_video')[0].pause();
    }

}
function start(id){
    var title = $('#'+id).data('title');
    var points = $('#'+id).data('points');
    $('#modal_title').text(title);
    $('#modal_points').text(points+' - Points');
    $("#nugget_id").val(id);
    var baseURL ="<?php echo base_url(); ?>";
    $.ajax({
        type: 'POST',    
        url:baseURL+'kat_agent/get_doc',
        data:'nid='+ id,
        success: function(code){
            $('#my-nugget-test').empty();
			$("#exam_panel").fadeIn();
            $('#my-nugget-test').html(code);

        }
    });
}

function mylink(id){
        var baseURL ="<?php echo base_url(); ?>";
        p = id-1;
        //check prev submit or not
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_agent/check_submit',
            data:'qid='+ p,
            success: function(msg){
                // alert(msg);
                if(msg == '{"status":"submitted"}'){
                    // alert('ok');
                    // $("li#1").css("background-color", "red");
                }
            }
        });
        //fetch ew question
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_agent/get_single_question',
            data:'qid='+ id,
            success: function(code){
                $('#change_q_panel').empty();
                $('#change_q_panel').html(code);
            }
        });
}
function start_test(id){
        var baseURL ="<?php echo base_url(); ?>";
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_agent/get_question',
            data:'nid='+ id,
            success: function(code){
                $('#my-nugget-test').empty();
                $('#my-nugget-test').html(code);
                
                if(code.length<115){
                    setTimeout( function(){ 
                    $("#exam_panel").fadeOut(); 
                }  , 4000 );
                }else{
                    Timeron();
                }
            }
        });
}
function review(id){
        var baseURL ="<?php echo base_url(); ?>";
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_agent/review_answers',
            data:'nid='+ id,
            success: function(code){
                $('#change_q_panel').empty();
                $('#change_q_panel').html(code);
            }
        });
}
function load_mission_user(id){
        var baseURL ="<?php echo base_url(); ?>";
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_agent/user_list_for_mission',
            data:'nid='+ id,
            success: function(code){
                $('#user_list').empty();
                $('#user_list').html(code);
                $('#default-datatable').DataTable({
                        "pageLength":50
                    });
            }
        });
}
function load_mission(id){
        var id = id;
        var baseURL ="<?php echo base_url(); ?>";
        window.location = baseURL+'kat_agent/team_mission_statistics/'+id;
}
function open_question(id){
        var id = id;
        var baseURL ="<?php echo base_url(); ?>";
        window.location = baseURL+'kat_admin/question/'+id;
}
function clicked_me(elem){
    // console.log($(elem).html());
    var selected_option = $(elem).children().text();
    var id = $(elem).attr('id');
    // console.log(id);
    $(".question-bg").removeAttr("style");
    $(elem).css({'background-color': '#35b8e0',
        'color': '#ffffff'
    });
    $("ul li").filter("#"+id).has( "a" ).css({'background-color': '#188ae2',
        'color': '#ffffff',
        'border-radius':'5px'
    });

    // var next =Number(id)+1;
    // console.log(next);
    var baseURL ="<?php echo base_url(); ?>";
    $.ajax({
        type: 'POST',    
        url:baseURL+'kat_agent/save_question',
        // data:'qid='+ id,
        data: {qid: id, selected_option: selected_option},
        success: function(){
            // mylink(next);
        }
    });
}
function submit(id){
        var baseURL ="<?php echo base_url(); ?>";
        clearInterval(window.runTimer);
        $.ajax({
            type: 'POST',    
            url:baseURL+'kat_agent/submit_final_answers',
            data:'nid='+ id,
            success: function(code){
                $('#my-nugget-test').empty();
                $('#my-nugget-test').html(code);
                setTimeout( function(){ 
                    $("#exam_panel").fadeOut(); 
                    location.reload();
                }  , 4500 );
            }
        });
}
function Timeron() {

var timeleft = '';
var rem_time = $('#countdown').text();
var baseURL = '<?php echo base_url(); ?>';

// timeleft = parseInt(rem_time.substring(0, 2));
timeleft = parseInt(rem_time);
// timeleft = timeleft - 1;

window.runTimer = setInterval(function() {
    document.getElementById("countdown").innerHTML = timeleft + " seconds remaining";
    if (timeleft <= 0) {
        clearInterval(window.runTimer);
        // $("#timeleft").val(timeleft);
        //submit form
        // $('#sktPleaseWait').modal('show');
        var nid = $('#nugget_id').val();
        // $('#sktPleaseWait').modal('hide');

        submit(nid);
        // $.ajax({
        //     type: 'POST',
        //     url: baseURL + 'kat_agent/submit_form',
        //     data: $('#submit_form').serialize(),
        //     success: function(msg) {
        //         $('#sktPleaseWait').modal('hide');
        //         $("#open-question").hide();
        //         $("#countdown").hide();
        //         $("#progressBar").hide();
        //         $("#submit-btn").hide();
        //         location.reload();
        //     }
        // });
    }
    // $("#countdown").val(timeleft);
    document.getElementById("progressBar").value = rem_time - timeleft;
    timeleft -= 1;
 }, 1000);

}
function get_filtered_mission(){
    var start_date = $("#mstart_date").val();
    var end_date = $("#mend_date").val();
    // alert(start_date);
    var baseURL ="<?php echo base_url(); ?>";
    $.ajax({
        type: 'POST',    
        url:baseURL+'kat_agent/filtered_mission',
        // data:'start_date='+ id,
        data: {start_date: start_date, end_date: end_date},
        success: function(code){
            $('#mission_list').empty();
			// $("#exam_panel").fadeIn();
            $('#mission_list').html(code);

        }
    });
}
function get_filtered_chart(){
    var start_date = $("#cstart_date").val();
    var end_date = $("#cend_date").val();
    // alert(start_date);
    var baseURL ="<?php echo base_url(); ?>";
    $.ajax({
        type: 'POST',    
        url:baseURL+'kat_agent/filtered_chart',
        // data:'start_date='+ id,
        data: {start_date: start_date, end_date: end_date},
        success: function(data){
            if(data){
                chart_data = $.parseJSON(data);

                // console.log(chart_data);
                // console.log(chart_data.completed);
                // console.log(chart_data.incompleted);
                // console.log(chart_data.expired);
                $('#piechart_3d').empty();
                $('#piechart2_3d').empty();
                // google.charts.load("current", {packages:["corechart"]});
	            // google.setOnLoadCallback(drawVisualization);
	            // drawVisualization(chart_data.completed,chart_data.incompleted,chart_data.expired,chart_data.t_completed,chart_data.t_incompleted,chart_data.t_expired);
                var completed = Number(chart_data.completed);
                var incompleted = Number(chart_data.incompleted);
                var expired = Number(chart_data.expired);
                var t_completed = Number(chart_data.t_completed);
                var t_incompleted = Number(chart_data.t_incompleted);
                var t_expired = Number(chart_data.t_expired);
                // drawA(completed,incompleted,chart_data.expired);
                drawA(completed,incompleted,expired);
                drawB(t_completed,t_incompleted,t_expired);
            }
        }
    });
}
function view_score(){
    var mid = $("#missionid").val();
    var nid = $("#nuid").val();
    var aid = $("#agents").val();
    // alert(mid+nid+aid);
    if(mid){
    var baseURL ="<?php echo base_url(); ?>";
    $.ajax({
        type: 'POST',    
        url:baseURL+'kat_agent/get_scores',
        // data:'start_date='+ id,
        data: {mid: mid, nid: nid, aid:aid},
        success: function(code){
            $('#view_score').empty();
			// $("#exam_panel").fadeIn();
            $('#view_score').html(code);
            $('#default-datatable').DataTable({
                        "pageLength":50
                    });
        }
    });
    }else{
        alert('Please Select Mission');
    }
}
function view_answers(){
    var mid = $("#mid").val();
    var nid = $("#nuid").val();
    var aid = $("#agents").val();

    if(mid && nid){
    var baseURL ="<?php echo base_url(); ?>";
    $.ajax({
        type: 'POST',    
        url:baseURL+'kat_agent/get_answers',
        data: {mid: mid, nid: nid, aid:aid},
        success: function(code){
            $('#view_answers').empty();
            $('#view_answers').html(code);
            $('#default-datatable').DataTable({
                "pageLength":50
            });
        }
    });
    }else{
        alert('Please Select Mission ansd Nugget');
    }
    
}
function view_performance(){
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var aid = $("#agents").val();

    if(start_date && end_date){
    var baseURL ="<?php echo base_url(); ?>";
    $.ajax({
        type: 'POST',    
        url:baseURL+'kat_agent/get_performance',
        data: {start_date: start_date, end_date: end_date, aid:aid},
        success: function(code){
            $('#view_performance').empty();
            $('#view_performance').html(code);
            $('#default-datatable').DataTable({
                "pageLength":50
            });
        }
    });
    }else{
        alert('Please Select Mission ansd Nugget');
    }
    
}
</script>