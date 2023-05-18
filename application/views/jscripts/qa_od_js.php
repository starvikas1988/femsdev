
<script>
$(document).ready(function(){	

		$("#from_date").datepicker();
		$("#to_date").datepicker();
		$("#chat_date").datepicker();
		$("#call_date").datepicker({  maxDate: new Date() });
		$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
		$("#audit_date").datepicker();
		$("#mgnt_review_date").datepicker();
		$("#review_date").datepicker({  maxDate: new Date() });
		
		$("#coach_name").select2();
		$("#agent_id").select2();

		$("#disposition_area").select2();
		
/////////////// Agent Filteration ////////////////////
	/* $('#agent_id').on('change', function(){
		if($(this).val()!=''){
			$('#from_date, #to_date').prop('disabled',true).val('');
			$('#foffice_id').prop('disabled',true).val('');
		}else{
			$('#from_date, #to_date').prop('disabled',false);
			$('#foffice_id').prop('disabled',false);
		}
	}); */
	
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

////////CONNECT//////	
	$('#ack_chat_cust').on('change', function() {
		score_cal();
	});
	$('#made_cust_feel_imp').on('change', function() {
		score_cal();
	});
	$('#appro_sin_empathy').on('change', function() {
		score_cal();
	});
	$('#cust_clr_understood_crs').on('change', function() {
		score_cal();
	});
	
////////RESOLVE//////	
	$('#ccp_ask_sale').on('change', function() {
		score_cal();
	});
	$('#read_ack_understood_cust').on('change', function() {
		score_cal();
	});
	$('#used_proper_guidelines').on('change', function() {
		score_cal();
	});
	$('#noted_appropriately').on('change', function() {
		score_cal();
	});
	
////////MAKE IT EASY//////		
	$('#agent_maintained_control_chat').on('change', function() {		
		score_cal();		
	});
	$('#verified_info_appropriate_chat').on('change', function() {
		score_cal();
	});
	
	
	score_cal();
	
///////////////////////////////////////////////	
		$("#form_audit_user").submit(function (e) {
			$('#qaformsubmit').prop('disabled',true);
		});
		
		$("#form_agent_user").submit(function(e){
			$('#btnagentSave').prop('disabled',true);
		});
		
		$("#form_mgnt_user").submit(function(e){
			$('#btnmgntSave').prop('disabled',true);
		});
		
		
});
	////// Possible and EarnScore calculation return value------
	function score_res(v){
		var x = 0;
		var y = 0;
		if(v == 10){ // YES
			x = +10;
			y = +10;
			return [x, y];
		}
		else if(v == 0){ // NO
			x = +10;
			y = -0;
			return [x, y];
		}
		else if(v == -1){ // NA
			x = +10;
			y = +10;
			return [x, y];
		}		
		else{
			var x=0;
			var y=0;
			return [x, y];
		}
	}
	
	function score_cal(){		
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a = parseInt($("#ack_chat_cust option:selected").attr("od_val"));
		var b = parseInt($("#made_cust_feel_imp option:selected").attr("od_val"));
		var c = parseInt($("#appro_sin_empathy option:selected").attr("od_val"));
		var d = parseInt($("#cust_clr_understood_crs option:selected").attr("od_val"));
		
		var e = parseInt($("#ccp_ask_sale option:selected").attr("od_val"));
		var f = parseInt($("#read_ack_understood_cust option:selected").attr("od_val"));
		var g = parseInt($("#used_proper_guidelines option:selected").attr("od_val"));
		var h = parseInt($("#noted_appropriately option:selected").attr("od_val"));
		
		var i = parseInt($("#agent_maintained_control_chat option:selected").attr("od_val"));
		var j = parseInt($("#verified_info_appropriate_chat option:selected").attr("od_val"));
		
		if(!isNaN(a)) {
				var res = score_res(a);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(b)) {
				var res = score_res(b);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(c)) {
				var res = score_res(c);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(d)) {
				var res = score_res(d);
				ps = ps + res[0];
				es = es + res[1];
			}

		if(!isNaN(e)) {
				var res = score_res(e);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(f)) {
				var res = score_res(f);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(g)) {
				var res = score_res(g);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(h)) {
				var res = score_res(h);
				ps = ps + res[0];
				es = es + res[1];
			}
		
		if(!isNaN(i)) {
				var res = score_res(i);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(j)) {
				var res = score_res(j);
				ps = ps + res[0];
				es = es + res[1];
			}		
		
						
		if(!isNaN(ps) && !isNaN(es)){
		//alert(tot);
		document.getElementById("possible_score").value= ps;
		document.getElementById("overall_score").value= es;
		////// Pass or Fail calculation .........
		if(e==0){
			document.getElementById("call_pass_fail").value= "Auto Fail";
			$('#call_pass_fail').css('background-color', '#8B0000');
			$('#call_pass_fail').css('color', '#ffffff');
			document.getElementById("score").value="0%";
		}else{
			if(Math.round((es/ps)*100)>=90){
				document.getElementById("call_pass_fail").value= "Pass";
				$('#call_pass_fail').css('background-color', '#006400');
				$('#call_pass_fail').css('color', '#ffffff');
			  }
			  else{
				  document.getElementById("call_pass_fail").value= "Fail";
				  $('#call_pass_fail').css('background-color', '#8B0000');
				  $('#call_pass_fail').css('color', '#ffffff');
				  
			  }
		
			 ////////////Score % calculation...................
			 if(!isNaN(es/ps)){
				document.getElementById("score").value=Math.round((es/ps)*100)+"%";
			 }
			 else{
				 document.getElementById("score").value="0%";			 
			 }
			 
		} // e= NO calculation end........ 
		 
		}
	}
	
</script>	

<script>
function date_validation(val,type){ 
	// alert(val);
		$(".end_date_error").html("");
		$(".start_date_error").html("");
		if(type=='E'){
		var start_date=$("#from_date").val();
		//if(val<start_date)
		if(Date.parse(val) < Date.parse(start_date))
		{
			$(".end_date_error").html("To Date must be greater or equal to From Date");
			 $(".esal-effect").attr("disabled",true);
			 $(".esal-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".esal-effect").attr("disabled",false);
			 $(".esal-effect").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".esal-effect").attr("disabled",true);
			 $(".esal-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".esal-effect").attr("disabled",false);
			 $(".esal-effect").css('cursor', 'pointer');
			}

		}
	}
</script>

<script>

 $(document).ready(function(){
  
   $( "#reason_for_chat" ).on('change' , function() {
	  
	var pid = this.value;
	if(pid=="") alert("Please Select Primary Reason for chat")
	var URL='<?php echo base_url();?>qa_od/getSecondaryReasonList';
  
	//alert(URL+"?pid="+pid);
	
	$.ajax({
	   type: 'POST',    
	   url:URL,
	   data:'pid='+pid,
	   success: function(pList){
		   //alert(pList);
			var json_obj = $.parseJSON(pList);//parse JSON
			
			$('#reason_for_chat_s').empty();
			$('#reason_for_chat_s').append($('<option></option>').val('').html('-- Select --'));
					
			for (var i in json_obj) $('#reason_for_chat_s').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].description));
									
		},
		error: function(){	
			alert('Fail!');
		}
		
	  });
	  
  });
 
 });
 </script>
 
 <script>
	$(document).ready(function(){
		$( "#agent_id" ).on('change' , function() {	
			var aid = this.value;
			if(aid=="") alert("Please Select Agent")
			var URL='<?php echo base_url();?>qa_od/getTLname';
			$('#sktPleaseWait').modal('show');
			$.ajax({
				type: 'POST',    
				url:URL,
				data:'aid='+aid,
				success: function(aList){
					var json_obj = $.parseJSON(aList);
					$('#tl_name').empty();
					$('#tl_name').append($('#tl_name').val(''));
					for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
					for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
					for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
					for (var i in json_obj) $('#batch_code').append($('#batch_code').val(json_obj[i].batch_code));
					for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));
					$('#sktPleaseWait').modal('hide');
				},
				error: function(){	
					alert('Fail!');
				}
			});
		});
	});	
 </script>
 
 <script>
 /////////////// VFS ////////////////////////
 ///////
	function vfs_calc(){
		var score = 0;
		var sub_score=0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var nameVal="";
		var	store="";

		$('.vfsVal').each(function(index,element){
			var score_type = $(element).val();
					
			if(score_type == 'Yes'){
				var nameVal = $.trim($(element).attr('name'));			
				var weightage = parseFloat($(element).children("option:selected").attr('vfs_val'));
				var final_total=$.trim($(this).data('id'));
				score = score + weightage;
				sub_score=sub_score + weightage;
				scoreable = scoreable + weightage;
				$("#score_"+nameVal).html(weightage);
				$("#score_"+final_total).html(sub_score);
			}else if(score_type == 'No'){
				var nameVal = $.trim($(element).attr('name'));
				var weightage = parseFloat($(element).children("option:selected").attr('vfs_val'));
				var final_total=$.trim($(this).data('id'));
				scoreable = scoreable + weightage;
				$("#score_"+final_total).html(sub_score);
				$("#score_"+nameVal).html(0);
			}else if(score_type == 'N/A'){
				var nameVal = $.trim($(element).attr('name'));
				var weightage = parseFloat($(element).children("option:selected").attr('vfs_val'));
				var final_total=$.trim($(this).data('id'));	
				score = score + weightage;
				scoreable = scoreable + weightage;
				$("#score_"+nameVal).html(weightage);
				$("#score_"+final_total).html(sub_score);	
			}

			if(final_total != store){
				sub_score = weightage;
				$("#score_"+final_total).html(sub_score);
			}
			store = final_total;

		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#vfsEarned').val(score);
		$('#vfsPossible').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#vfsOverallScore').val(quality_score_percent+'%');
		}
		
	/*---- Chat ---*/
		if($('#chatAutof1').val()=='Yes' || $('#chatAutof2').val()=='Yes' || $('#chatAutof3').val()=='Yes' || $('#chatAutof4').val()=='Yes'){
			$('.vfsChatFatal').val(0);
			$('#fatalspan3').val("Fatal Error").css("color","red");
		}else{
			$('#fatalspan3').val("Non Fatal").css("color","blue");

			$('.vfsChatFatal').val(quality_score_percent+'%');
		}
	/*---- Call ---*/
		if($('#callAutof1').val()=='Yes' || $('#callAutof2').val()=='Yes' || $('#callAutof3').val()=='Yes' || $('#callAutof4').val()=='Yes' || $('#callAutof5').val()=='Yes'){
			$('.vfsCallFatal').val(0);
			$('#fatalspan1').val("Fatal Error").css("color","red");

		}else{
			$('#fatalspan1').val("Non Fatal").css("color","blue");
			$('.vfsCallFatal').val(quality_score_percent+'%');
		}
	/*---- Email ---*/
		if($('#emailAutof1').val()=='Yes' || $('#emailAutof2').val()=='Yes' || $('#emailAutof3').val()=='Yes' || $('#emailAutof4').val()=='Yes'){
			$('.vfsEmailFatal').val(0);
			$('#fatalspan2').val("Fatal Error").css("color","red");
		}else{
			$('#fatalspan2').val("Non Fatal").css("color","blue");
			$('.vfsEmailFatal').val(quality_score_percent+'%');
		}
		
	}
	
/////////////// US Directory Assistance ////////////////////////
///////
	function usda_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.usdaVal').each(function(index,element){
			var score_type = parseFloat($(element).val());
			score = score + score_type;
			scoreable = scoreable + 5;
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#usdaEarned').val(score);
		$('#usdaPossible').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#usdaOverallScore').val(quality_score_percent+'%');
		}
	////////
		if($('#usdaAutof1').val()=='0' || $('#usdaAutof2').val()=='0' || $('#usdaAutof3').val()=='0' || $('#usdaAutof4').val()=='0' || $('#usdaAutof5').val()=='0'){
			$('.usdaCallFatal').val(0);
			$('#usdaEarned').val(0);
		}else{
			$('.usdaCallFatal').val(quality_score_percent+'%');
			$('#usdaEarned').val(score);
		}
	}
	
	
$(document).ready(function(){
	
////////////////// VFS /////////////////////
	$(document).on('change','.vfsVal',function(){
		vfs_calc();
	});
	vfs_calc();
	
///////// US Directory Assistance /////////////	
	$(document).on('change','.usdaVal',function(){
		usda_calc();
	});
	usda_calc();
	
	
});
	
	

	
	
 
 </script>