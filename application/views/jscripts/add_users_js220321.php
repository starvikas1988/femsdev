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
	
	$("#office_id").change(function(){
					
		$("#client_id").val('');
		$("#role_id").val('');
		$("#site_id").val('');
		
		$("#site_div").hide();
		$('#site_id').removeAttr('required');
			
		var off_id=$(this).val();
		if(off_id=='KOL'){
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
	
	$("#client_id").change(function(){
		var client_id=$(this).val();
		
		var URL='<?php echo base_url();?>/user/select_process';
		
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
			},
			error: function(){	
				alert('error!');
			}
		  });
		
	});
	
	$("#edclient_id").change(function(){
		var client_id=$(this).val();
		
		var URL='<?php echo base_url();?>/user/select_process';
		
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
	
	
	$("#dept_id").change(function(){
		
		var dept_id=$('#dept_id').val();
		populate_sub_dept_combo(dept_id);
		//$("#role_id").val('');
	});
	
	/*
	 $("#role_id").change(function(){
		
		var dept_id=$('#dept_id').val().trim();
		var role_id=$(this).val().trim();
		var office_id= $("#office_id").val().trim();
		
		var roleArray=['3','7','8','12','13','18','23'];
		if($.inArray(role_id,roleArray)>=0){
			populate_assign_combo(office_id);
			$("#assigned_to_div").show();		
			//$('#assigned_to').attr('required', 'required');	
		}else {
			$("#assigned_to").empty();
			$('#assigned_to').removeAttr('required');
			//$("#assigned_to_div").hide();
		}
				
    });
	
	*/
	
	
	
	
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
  
		var URL='<?php echo base_url();?>user/getUserName';
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
	$(".userClientActDeact").click(function(){
		var URL='<?php echo base_url();?>user/userClientActDeact';
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
					window.location.reload();
				}
			  });
		  }
	});
	
	
	$(".editUserClient").click(function(){
		var params=$(this).attr("params");
		var assign=$(this).attr("assign");
		var c_id=$(this).attr("c_id");	
		var arrPrams = params.split("#"); 
		var assignPrams = assign.split("#"); 
		
		$( ".frmeditUserClient #allow_process_update" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_module" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_ba_module" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_knowledge" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_dfr_interview" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_audit" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_review" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_mind_faq" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_dfr_report" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_dashboard" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_dipcheck" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_qa_report" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_calibration" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_follett" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_zovio" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_mpower_voc" ).prop( 'checked', false );
		$( ".frmeditUserClient #allow_kyt" ).prop( 'checked', false );
		
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
		if(assignPrams[9] > 0){ $( ".frmeditUserClient #allow_qa_dashboard" ).prop( 'checked', true ); }
		if(assignPrams[10] > 0){ $( ".frmeditUserClient #allow_qa_dipcheck" ).prop( 'checked', true ); }
		if(assignPrams[11] > 0){ $( ".frmeditUserClient #allow_qa_report" ).prop( 'checked', true ); }
		if(assignPrams[12] > 0){ $( ".frmeditUserClient #allow_calibration" ).prop( 'checked', true ); }
		if(assignPrams[13] > 0){ $( ".frmeditUserClient #allow_follett" ).prop( 'checked', true ); }
		if(assignPrams[14] > 0){ $( ".frmeditUserClient #allow_zovio" ).prop( 'checked', true ); }
		if(assignPrams[15] > 0){ $( ".frmeditUserClient #allow_mpower_voc" ).prop( 'checked', true ); }
		if(assignPrams[16] > 0){ $( ".frmeditUserClient #allow_kyt" ).prop( 'checked', true ); }
		
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
	
		
	/* global setting */
	/*
    var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        minDate   : "-2D"
    }
	*/
	 var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset
    }
	
	//$( "#doj" ).datepicker();
	$("#doj").datepicker($.extend({},datepickersOpt));
	$("#dob").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-70:c+0"});
	$("#eddob").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-70:c+0"});
	
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

