<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$('#call_duration').timepicker({ timeFormat: 'HH:mm:ss' });
	$('#call_time').timepicker({ timeFormat: 'HH:mm:ss' });
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
///////////////// Calibration - Auditor Type ///////////////////////	
	$('.auType').hide();
	
	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});
	
	
var getTLname = function(aid){
		var URL='<?php echo base_url();?>Qa_craftjack/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	}
	$("#agent_id").on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		else{getTLname(aid);}
	});	
	if($("#agent_id").val()!="") getTLname($("#agent_id").val());
/////////////////Craftjack//////////////////
	$('#introduction').on('change', function(){
		overall_score();
	});
	$('#educate').on('change', function(){
		overall_score();
	});
	$('#solution').on('change', function(){
		overall_score();
	});
	$('#email_zip_code').on('change', function(){
		overall_score();
	});
	$('#xm_mmr_ib').on('change', function(){
		overall_score();
	});
	$('#expectation').on('change', function(){
		overall_score();
	});
	$('#professionalism').on('change', function(){
		overall_score();
	});
	$('#transfer').on('change', function(){
		overall_score();
	});
	$('#valid_ctt').on('change', function(){
		overall_score();
	});
	$('#correct_dispo').on('change', function(){
		overall_score();
	});
	$('#attitude').on('change', function(){
		overall_score();
	});
	$('#ownership').on('change', function(){
		overall_score();
	});
	$('#acknowledged').on('change', function(){
		overall_score();
	});
	$('#verbal_skill').on('change', function(){
		overall_score();
	});
	$('#card_detail').on('change', function(){
		overall_score();
	});
	$('#proper_closing').on('change', function(){
		overall_score();
	});

	$('#pass_fail_recorded_line').on('change', function(){
		overall_score();
	});
	$('#pass_fail_xm_mmr_ib').on('change', function(){
		overall_score();
	});
	$(".auto_pass_fail").on('change', function(){
		var apf = this.value;
		if(apf == "Pass"){
			$("#call_pass_fail").val('Pass');
			$("#call_pass_fail").css("color", "green");
		}else{
			$("#call_pass_fail").val('Fail');
			$("#call_pass_fail").css("color", "red");
		}
	});

////////////////////////	
	function overall_score(){
		var a1 = parseInt($("#introduction").val());
		var a2 = parseInt($("#educate").val());
		var a3 = parseInt($("#solution").val());
		var a4 = parseInt($("#email_zip_code").val());
		var a5 = parseInt($("#xm_mmr_ib").val());
		var a6 = parseInt($("#expectation").val());
		var a7 = parseInt($("#professionalism").val());
		var a8 = parseInt($("#transfer").val());
		var a9 = parseInt($("#valid_ctt").val());
		var a10 = parseInt($("#correct_dispo").val());
		var a11 = parseInt($("#attitude").val());
		var a12 = parseInt($("#ownership").val());
		var a13 = parseInt($("#acknowledged").val());
		var a14 = parseInt($("#verbal_skill").val());
		var a15 = parseInt($("#card_detail").val());
		var a16 = parseInt($("#proper_closing").val());
		
		var pass_fail1 = $("#pass_fail_recorded_line").val();
		var pass_fail2 = $("#pass_fail_xm_mmr_ib").val();
		
		if(isNaN(a1)){a1 = 0;}
		if(isNaN(a2)){a2 = 0;}
		if(isNaN(a3)){a3 = 0;}
		if(isNaN(a4)){a4 = 0;}
		if(isNaN(a5)){a5 = 0;}
		if(isNaN(a6)){a6 = 0;}
		if(isNaN(a7)){a7 = 0;}
		if(isNaN(a8)){a8 = 0;}
		if(isNaN(a9)){a9 = 0;}
		if(isNaN(a10)){a10 = 0;}
		if(isNaN(a11)){a11 = 0;}
		if(isNaN(a12)){a12 = 0;}
		if(isNaN(a13)){a13 = 0;}
		if(isNaN(a14)){a14 = 0;}
		if(isNaN(a15)){a15 = 0;}
		if(isNaN(a16)){a16 = 0;}
		
		if(pass_fail1=='Fail' || pass_fail2=='Fail'){
			var tot = 0;
		}else{
			
			var tot = a1+a2+a3+a4+a5+a6+a7+a8+a9+a10+a11+a12+a13+a14+a15+a16;
		}
		
		if(!isNaN(tot)){
			document.getElementById("overall_score").value= tot;
		}
		return tot; 
	}
});
 </script>