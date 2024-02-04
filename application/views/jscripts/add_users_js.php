<script type="text/javascript">
$(document).ready(function(){
	$("#dept_id").on('change', function() {
		var x = $(this).val();
		if(x==7 || x==9){
			$("#client_id").val(0).trigger('change');
		}	
	});	
	
	
	$('#uan_no,#existing_uan').hide();
	$('#esi_no,#existing_esi').hide();
	$('#role').on('change', function(){
		var selectValue = $(this).val();
		if(selectValue=='consultant'){
			$('#client_id, #process_id').prop('disabled', true);
			$("#client_div, #process_div").hide('slow');
		}else{
			$('#client_id, #process_id').prop('disabled', false);
			$("#client_div, #process_div").show('slow');
		}
	});
	$('#edrole').on('change', function(){
		var selectValue = $(this).val();
		if(selectValue=='consultant'){
			$('#edclient_id, #edprocess_id').prop('disabled', true);
			$("#client_div, #process_div").hide('slow');
		}else{
			if(selectValue=="Caller"){
				$("#caller").hide();
			}else{
				$("#caller").show();
			}
			$('#edclient_id, #edprocess_id').prop('disabled', false);
			$("#client_div, #process_div").show('slow');
		}
	});
	
	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	
	$("#office_id").change(function(){
					
		$("#client_id").val('');
		$("#role_id").val('');
		$("#site_id").val('');
		
		$("#site_div").hide();
		$('#site_id').removeAttr('required');
			
		var off_id=$(this).val();
		if(off_id=='KOL' || off_id=='MON' || off_id=='FTK' || off_id=='CAM'|| off_id=='UTA'|| off_id=='TEX'|| off_id=='SPI'|| off_id=='MIN'|| off_id=='HIG'){
			$('#xpoid').attr("required", "true");
		}else{
			$('#xpoid').removeAttr("required");
		}
		
		if(off_id=='BLR' || off_id=='HWH' || off_id=='KOL'){
			$('#uan_no,#existing_uan').show();
			$('#esi_no,#existing_esi').show();
			$('#uan_no').prop('disabled', false);
			$('#esi_no').prop('disabled', false);
		}else{
			$('#uan_no,#existing_uan').hide();
			$('#esi_no,#existing_esi').hide();
			$('#uan_no').prop('disabled', true);
			$('#esi_no').prop('disabled', true);
		}
		
	});
	
	
	function check_required_feilds_validation()
	{
		clientIDs = $('#client_id').val();
		processIDs = $('#process_id').val();
		officeID = $('#office_id').val();
		xpoRequired = 0;
		$.each(clientIDs, function(key,val){
			if(val == "133"){ xpoRequired = 1; }
			if(val == "134"){ xpoRequired = 1; }
			if(val == "93"){ xpoRequired = 1; }
		});
		
		if(officeID == "FTK"){ xpoRequired = 1; }
		if(officeID == "HIG"){ xpoRequired = 1; }
		if(officeID == "MIN"){ xpoRequired = 1; }
		if(officeID == "SPI"){ xpoRequired = 1; }
		if(officeID == "TEX"){ xpoRequired = 1; }
		if(officeID == "UTA"){ xpoRequired = 1; }
		if(officeID == "CAM"){ xpoRequired = 1; }
		if(officeID == "MON"){ xpoRequired = 1; }
		
		if(xpoRequired == 1){
			$('#xpoid').attr('required', 'required');
		} else {
			$('#xpoid').removeAttr('required', 'required');
		}			
	}
	
	$('.addUserClass').on('change', '#client_id', function(){
		check_required_feilds_validation();
	});
	
	$("#client_id").change(function(){
		var client_id=$(this).val();
		
		var URL='<?php echo base_url();?>/users/select_process';
		
		$.ajax({
		   type: 'GET',    
		   url:URL,
		   data:'client_id='+client_id,
		    success: function(data){
			  
			  
			  var a = JSON.parse(data);
			  //var mySelect = $('#process_id');
			  $("#process_id").empty();
			  
				$.each(a, function(index,jsonObject){
					 $("select#process_id").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
				});	
			}
		  });
		  
		
	});
	
	$("#edclient_id").change(function(){
		var client_id=$(this).val();
		
		var URL='<?php echo base_url();?>/users/select_process';
		
		$.ajax({
		   type: 'GET',    
		   url:URL,
		   data:'client_id='+client_id,
		    success: function(data){
			  
			  
			  var a = JSON.parse(data);
			  //var mySelect = $('#process_id');
			  $("#edprocess_id").empty();
			  
				$.each(a, function(index,jsonObject){
					 $("select#edprocess_id").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
				});	
			},
			error: function(){	
				alert('error!');
			}
		  });
		
	});
	$("#country_id").change(function(){
		var client_id=$(this).val();
		if(client_id==101){
		    $(".NonIndian_details").css("display", "none");
		    $(".Indian_details").css("display", "block");
		   }else{
		    $(".NonIndian_details").css("display", "block");
		    $(".Indian_details").css("display", "none");
		   }
		var URL='<?php echo base_url();?>/users/select_phoneCode';
		$.ajax({
		   type: 'GET',    
		   url:URL,
		   data:'phoneCode_id='+client_id,
		    success: function(data){
			  var a = JSON.parse(data);
  			  $("#countryCode").val(a.phonecode);
			},
			error: function(){	
				alert('error!');
			}
		  });
		
	});
	
	
	$("#dept_id").change(function(){
		
		var dept_id=$('#dept_id').val();
		populate_sub_dept_combo(dept_id);
		//$("#role_id").val('');
	});
	
	$("#is_bod").click(function(){
		
		if($('#is_bod').is(':checked')){
			$('.reporting_head').attr('disabled','true');
			$('.btn_search_user').attr('disabled','true');
				
		}else{
			$('.reporting_head').removeAttr('disabled');
			$('.btn_search_user').removeAttr('disabled');
		}
	});
	
	
	$(".btn_search_user").click(function(){
						
		 var map=$(this).attr("map");
		$('#userSearchModal').modal('show');
		$('#fetch_user').attr('map', map);	
		$("#search_user_rec").html('');
	});
	
	$(".reporting_head").keydown(function (event) {
		if (event.which ==112) {
			var map=$(this).attr("id");
			$('#userSearchModal').modal('show');
			$('#fetch_user').attr('map', map);
			$("#search_user_rec").html('');
		}
	});
	
	$(".reporting_head").focusout(function(){
  
		var URL='<?php echo base_url();?>users/getUserName';
		var fid=$(this).val();
		var op_id=$(this).attr("id")+"_name";
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'fid='+fid,
		   success: function(aname){
				$("#"+op_id).val(aname);
			},
			error: function(){	
				alert('Fail!');
			}
		  });	
	});
		
	
	$("#fetch_user").click(function(){
		 
		 var map=$(this).attr("map");
		 var aname=$('#aname').val()
		 var aomuid=$('#aomuid').val()
		
		 populate_secrch_user(aname,aomuid);
		 
	}); 
  
	
    $("#reset").click(function(){
		//$("#assigned_to_div").hide();
		//$("#site_div").hide();
		//$("#process_div").hide();
		//$('#assigned_to').removeAttr('required');
		//$('#process_id').removeAttr('required');
		//$('#site_id').removeAttr('required');
		//$("#sub_process_div").hide();		
		//$('#sub_process_id').removeAttr('required');
					
	});
	
///////////////////////////////////////////////
//////////////USER CLIENT SECTION//////////////////
	

		$("body").on("click", ".userClientActDeact", function(event){ 
		var URL='<?php echo base_url();?>users/userClientActDeact';
		var c_id=$(this).attr("c_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Client?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: URL,
			   data:'c_id='+ c_id+'&sid='+ sid,
			   success: function(msg){
				//alert(msg);
				window.location.reload();
				},
				error: function (msg, errorThrown) {
					window.location.reload();
        }
			  });
		  }
	});
	
	
		$("body").on("click", ".resetPasswordClient", function(event){ 
		var cid = $(this).attr("c_id");
		var pwd = $(this).attr("pwd");	
		
		$('#resetPassowrdClientModal input[name="r_cid"]').val('');
		$('#resetPassowrdClientModal input[name="r_cid"]').val(cid);
		$('#resetPassowrdClientModal input[name="r_new_passwd"]').val(pwd);
		$('#resetPassowrdClientModal input[name="r_confirm_passwd"]').val(pwd);
		$('#resetPassowrdClientModal').modal('show');
	});
	$(".viewDoc").click(function(){
		$('#viewDocModal').modal('show');
	});
	
	
	$(".resetPasswordClientSubmit").click(function(){
		cid = $('#resetPassowrdClientModal input[name="r_cid"]').val();
		newp = $('#resetPassowrdClientModal input[name="r_new_passwd"]').val();
		oldp = $('#resetPassowrdClientModal input[name="r_confirm_passwd"]').val();
		
		if(newp != "" && oldp != "" && cid != ""){
			if(newp == oldp){
				var URL='<?php echo base_url();?>users/resetClientPassword';
				$.ajax({
				   type: 'POST',    
				   url: URL,
				   data:'r_cid='+ cid+'&r_new_passwd='+ newp+'&r_confirm_passwd='+ oldp,
				   success: function(msg){
						window.location.reload();
					}
				 });
			} else {
				alert('Entered Password Does Not Match!');
			}
		} else {
			alert("Please Enter All Details!");
		}
	});
	$('#diy_tid,#personal_doc').change(function () {
    	var uploadpath = $(this).val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg or png files");
	        $(this).val('');
	        return false;
	    }
});
	$('#security_doc').change(function () {
    	var uploadpath = $(this).val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $(this).val('');
	        return false;
	    }
});
	
		$("body").on("click", ".editUserClient", function(event){ 
		var params=$(this).attr("params");
		var assign=$(this).attr("assign");
		var c_id=$(this).attr("c_id");	
		var arrPrams = params.split("#"); 
		var assignPrams = assign.split("#"); console.log(assignPrams);
		
		$( ".frmeditUserClient #allow_process_update" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_module" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_ba_module" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_knowledge" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_dfr_interview" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_audit" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_review" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_mind_faq" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_dfr_report" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qenglish" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_dashboard" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_dipcheck" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_report" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_calibration" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_follett" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_zovio" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_mpower_voc" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_kyt" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_diy" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_naps" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_consultant_report" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_emat" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_k2claims" ).prop( 'checked', false );
		
		$('.frmeditUserClient #c_id').val(c_id);
		$('.frmeditUserClient #edemail_id_per').val(arrPrams[0]);
		$('.frmeditUserClient #edfname').val(arrPrams[1]);
		$('.frmeditUserClient #edlname').val(arrPrams[2]);
		$('.frmeditUserClient #edsex').val(arrPrams[3]);
		$('.frmeditUserClient #edoffice_id').val(arrPrams[4]);
		$('.frmeditUserClient #edclient_id').val(arrPrams[5]);
		$('.frmeditUserClient #edprocess_id').val(arrPrams[6]);
		$('.frmeditUserClient #eddob').val(arrPrams[7]);
		$('.frmeditUserClient #edphone').val(arrPrams[8]);
		$('.frmeditUserClient #edrole').val(arrPrams[9]);
		$('.frmeditUserClient #edcountry_id').val(arrPrams[10]);
		$('.frmeditUserClient #edcountryCode').val(arrPrams[11]);
		$('.frmeditUserClient #edmobile').val(arrPrams[12]);
		$('.frmeditUserClient #eddiy_payout_currency').val(arrPrams[13]);
		$('.frmeditUserClient #edPHR').val(arrPrams[14]);
		$('.frmeditUserClient #edaccount_num').val(arrPrams[15]);
		$('.frmeditUserClient #edaccount_name').val(arrPrams[16]);
		$('.frmeditUserClient #edbank_name').val(arrPrams[17]);
		$('.frmeditUserClient #edbank_add').val(arrPrams[18]);
		$('.frmeditUserClient #eddiy_IBAN').val(arrPrams[19]);
		$('.frmeditUserClient #eddiy_TIN').val(arrPrams[20]);
		$('.frmeditUserClient #edpan').val(arrPrams[21]);
		$('.frmeditUserClient #eddiy_IFSC').val(arrPrams[22]);
		$('.frmeditUserClient #edTimeZone').val(arrPrams[23]);
		var countryCode=arrPrams[11];
		if(countryCode==91){
			$(".Indian_details").css("display", "block");
			$(".NonIndian_details").css("display", "none");
		}else{
			$(".NonIndian_details").css("display", "block");
			$(".Indian_details").css("display", "none");
		}
		var consult = arrPrams[9];
		if(consult=='consultant'){
			$('#edclient_id, #edprocess_id').prop('disabled', true);
			$("#client_div, #process_div").hide('slow');
		}else{
			if(consult=="Caller"){
				$("#caller").hide();
			
			}else{
				$("#caller").show();
				
			}
			$('#edclient_id, #edprocess_id').prop('disabled', false);
			$("#client_div, #process_div").show('slow');
		}
		
		$.each(arrPrams[4].split(","), function(i,e){
			$(".frmeditUserClient #edoffice_id option[value='" + e + "']").prop("selected", true);
		});
		
		$.each(arrPrams[6].split(","), function(i,e){
			$(".frmeditUserClient #edprocess_id option[value='" + e + "']").prop("selected", true);
		});
		
		
		$("#edclient_id").select2();
		$("#edprocess_id").select2();
		$("#edoffice_id").select2();
		
		
		if(assignPrams[0] > 0){ $( ".frmeditUserClient #allow_process_update" ).prop( 'checked', true ); }
		if(assignPrams[1] > 0){ $( ".frmeditUserClient #allow_qa_module" ).prop( 'checked', true ); }
		if(assignPrams[2] > 0){ $( ".frmeditUserClient #allow_ba_module" ).prop( 'checked', true ); }
		if(assignPrams[3] > 0){ $( ".frmeditUserClient #allow_knowledge" ).prop( 'checked', true ); }
		if(assignPrams[4] > 0){ $( ".frmeditUserClient #allow_dfr_interview" ).prop( 'checked', true ); }
		if(assignPrams[5] > 0){ $( ".frmeditUserClient #allow_qa_audit" ).prop( 'checked', true ); }
		if(assignPrams[6] > 0){ $( ".frmeditUserClient #allow_qa_review" ).prop( 'checked', true ); }
		if(assignPrams[7] > 0){ $( ".frmeditUserClient #allow_mind_faq" ).prop( 'checked', true ); }
		if(assignPrams[8] > 0){ $( ".frmeditUserClient #allow_dfr_report" ).prop( 'checked', true ); }
		if(assignPrams[9] > 0){ $( ".frmeditUserClient #allow_qenglish" ).prop( 'checked', true ); }
		if(assignPrams[10] > 0){ $( ".frmeditUserClient #allow_qa_dashboard" ).prop( 'checked', true ); }
		if(assignPrams[11] > 0){ $( ".frmeditUserClient #allow_qa_dipcheck" ).prop( 'checked', true ); }
		if(assignPrams[12] > 0){ $( ".frmeditUserClient #allow_qa_report" ).prop( 'checked', true ); }
		if(assignPrams[13] > 0){ $( ".frmeditUserClient #allow_calibration" ).prop( 'checked', true ); }
		if(assignPrams[14] > 0){ $( ".frmeditUserClient #allow_follett" ).prop( 'checked', true ); }
		if(assignPrams[15] > 0){ $( ".frmeditUserClient #allow_zovio" ).prop( 'checked', true ); }
		if(assignPrams[16] > 0){ $( ".frmeditUserClient #allow_mpower_voc" ).prop( 'checked', true ); }
		if(assignPrams[17] > 0){ $( ".frmeditUserClient #allow_kyt" ).prop( 'checked', true ); }
		if(assignPrams[18] > 0){ $( ".frmeditUserClient #allow_naps" ).prop( 'checked', true ); }
		if(assignPrams[19] > 0){ $( ".frmeditUserClient #allow_consultant_report" ).prop( 'checked', true ); }
		if(assignPrams[20] > 0){ $( ".frmeditUserClient #allow_emat" ).prop( 'checked', true ); }
		if(assignPrams[21] > 0){ $( ".frmeditUserClient #allow_k2claims" ).prop( 'checked', true ); }
		if(assignPrams[22] > 0){ $( ".frmeditUserClient #allow_diy" ).prop( 'checked', true ); }
		
		
		// --- ALLOW PARAM-B 
		var assignb = $(this).attr("paramb");
		$( ".frmeditUserClient #allow_downtime" ).prop( 'checked', false );		
		if(assignb != ""){
			var assigBparams = assignb.split("#");
			if(assigBparams[0] > 0){ $( ".frmeditUserClient #allow_downtime" ).prop( 'checked', true ); }
		}
		var timezone_det=arrPrams[23];
		if(timezone_det){
			var timezone_split=timezone_det.split('_');
			console.log(timezone_split);
			$(".frmeditUserClient #edTimeZone option[value='" + timezone_split[0]+'#'+timezone_split[1] + "']").prop("selected", true);
		}
		
		var extrainfo=$(this).attr("extrainfo");
		if(extrainfo!=""){
			var infoPrams = extrainfo.split("#");
			$('.frmeditUserClient #eclient_course').val(infoPrams[0]);
			$.each(infoPrams[0].split(","), function(i,e){
				$(".frmeditUserClient #eclient_course option[value='" + e + "']").prop("selected", true);
			});			
		}
		$("#eclient_course").select2();
		$('#editUserClientModel').modal('show');
	});
	
///////////////////////
});
$(function(){
    
	var timeOffset="-300";
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
	
	
	 var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset
    }
	
	//$( "#doj" ).datepicker();
	$("#doj").datepicker($.extend({},datepickersOpt));
	$("#dob").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-70:c+0"});
	$("#eddob").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-70:c+0"});
	$("#time_details").datepicker().timepicker();
	$("#client_id").select2();
	$("#process_id").select2();
	$("#office_id").select2();
	$("#client_course").select2();
	
	
	
}); 
            
// dropdown selection of role and setting org_role  
$('#role_id').change(function(){
	var option = $('option:selected', this).attr('param');
	$('#org_role').val(option);
	
});
   
</script>
