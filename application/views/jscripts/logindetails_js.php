<script type="text/javascript">

$(document).ready(function(){
    	
	var baseURL="<?php echo base_url();?>";
	/////////////////////////////////////////////
	
	$("#fdept_id").change(function(){
		var dept_id=$('#fdept_id').val();
		populate_sub_dept_combo(dept_id,'','fsub_dept_id','Y');
	});
	
	$("#fclient_id").change(function(){
		
		var client_id=$(this).val();
		
		var rid=$.cookie('role_id'); 
		if(rid<=1 || rid==6){
		
			if(client_id=="1"){
				$("#foffice_div").hide();
				$("#fsite_div").show();
				$("#foffice_id").val('ALL');
				
			}else{
				$("#fsite_div").hide();
				$("#foffice_div").show();
				$("#fsite_id").val('ALL');
			}
		}
		populate_process_combo(client_id,'','fprocess_id','Y');
		
	});
	
	
	
	$("#filter_key").change(function(){
		
		var key=$(this).val();
		//alert(key);
		
			$("#site_div").hide();
			$('#site_id').removeAttr('required');
			
			$("#agent_div").hide();
			$('#agent_id').removeAttr('required');
			
			$("#process_div").hide();
			$('#process_id').removeAttr('required');
			
			$("#role_div").hide();
			$('#role_div').removeAttr('required');
			
			$("#aof_div").hide();
			$('#aof_div').removeAttr('required');
		
		if(key == "Site" ){ 
			$("#site_div").show();
			$('#site_id').attr('required', 'required');
						
		}else if($(this).val() == "Process" ){ 
			
			$("#process_div").show();
			$('#process_id').attr('required', 'required');
		
		}else if($(this).val() == "Agent" ){ 
			
			$("#agent_div").show();
			$('#agent_id').attr('required', 'required');
		
		}else if($(this).val() == "Role" ){ 
			
			$("#role_div").show();
			$('#role_div').attr('required', 'required');
			
		}else if($(this).val() == "AOF" ){ 
			
			$("#aof_div").show();
			$('#aof_div').attr('required', 'required');
			
		}else{
			
		}
		        
    });
	
	
	////////////////
	
	$(".manualLoginEntry").click(function(){
		$('#manualLoginUserModal').modal('show');
	});
	
	$(".manualUserLoginEntry").click(function(){
			var uid=$(this).attr("uid");
			var ldate=$(this).attr("ldate");
			
			//alert(uid);
			$('#uid').val(uid);
			$('#login_date').val(ldate);
			$('#logout_date').val(ldate);
			
			$('#sktLoginUserModal').modal('show');
	});
	
	
	$("#btn_search_agent").click(function(){
		$('#agentSearchModal').modal('show');	 
	 });
	
	$("#agent_fusion_id").keydown(function (event) {
		if (event.which ==112) {
			$('#agentSearchModal').modal('show');
		}
  });
	
	
	$("#logout_time").focusout(function(){
	
		var login_date=$('#login_date').val();
		var login_time=$('#login_time').val();
		
		var logout_date=$('#logout_date').val();
		var logout_time=$('#logout_time').val();
		
		if(login_time!="" && logout_date!="" && logout_time!="" ){
		
			login_time=login_date+' ' +login_time;
			logout_time=logout_date+' ' +logout_time;
				
			var totHrs=getDateDiffHours(login_time,logout_time);
			
			$("#total_hours_div").show();
			$("#total_hours").html('<b>'+totHrs+'</b>');
		}else{
			
			$("#total_hours_div").hide();
			$("#total_hours").html("");
		}
		
		
  });
  
  $("#mlogout_time").focusout(function(){
	
		var login_date=$('#mlogin_date').val();
		var login_time=$('#mlogin_time').val();
		
		var logout_date=$('#mlogout_date').val();
		var logout_time=$('#mlogout_time').val();
		
		if(login_time!="" && logout_date!="" && logout_time!="" ){
		
			login_time=login_date+' ' +login_time;
			logout_time=logout_date+' ' +logout_time;
				
			var totHrs=getDateDiffHours(login_time,logout_time);
			
			$("#mtotal_hours_div").show();
			$("#mtotal_hours").html('<b>'+totHrs+'</b>');
		}else{
			
			$("#mtotal_hours_div").hide();
			$("#mtotal_hours").html("");
		}
		
		
  });
	
	
	
	
  $("#fetch_agents").click(function(){
  
		var URL='<?php echo base_url();?>user/getUserList';
		
		var aname=$('#aname').val();
		
		var aomuid=$('#aomuid').val();
				
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'aname='+aname+'&aomuid='+aomuid,
		   success: function(aList){
				
				//alert(aList);
				
				var json_obj = $.parseJSON(aList);//parse JSON
				
				var html = '<table id="tbXXX" border="1" class="table table-striped" cellspacing="0" width="100%" >';
				
					html += '</head>';
					html += '<tr>';
					html += '<th>Fusion ID</th>';
					html += '<th>First Name</th>';
					html += '<th>Last Name</th>';
					html += '<th>OM-ID</th>';
					html += '</tr>';
					html += '</head>';
					html += '<tbody>';
				
				
				for (var i in json_obj) 
				{
					html += '<tr class="agent_row" id="'+json_obj[i].fusion_id+'" aname="'+json_obj[i].fname+" "+json_obj[i].lname+'" >';
					html += '<TD>'+json_obj[i].fusion_id+'</TD>';
					html += '<TD>'+json_obj[i].fname+'</TD>';
					html += '<TD>'+json_obj[i].lname+'</TD>';
					html += '<TD>'+json_obj[i].omuid+'</TD>';
					html += '</tr>';
				}
				html += '</tbody>';
				
				html += '</table>';
				$("#search_agent_rec").html(html);
			
			},
			error: function(){	
				alert('Fail!');
			}
		  });
		  
	});
	
	$(document).on('click', '.agent_row', function(){
		var fid=$(this).attr("id");
		var aname=$(this).attr("aname");
		$("#agent_name").val(aname);
		$("#agent_fusion_id").val(fid);
		
		$('#agentSearchModal').modal("hide");		
	});
	
		
	$("#agent_fusion_id").focusout(function(){
  
		var URL='<?php echo base_url();?>user/getUserName';
		var fid=$(this).val();
			$.ajax({
			   type: 'POST',    
			   url:URL,
			   data:'fid='+fid,
			   success: function(aname){
					$("#agent_name").val(aname);
				},
				error: function(){	
					alert('Fail!');
				}
			  });  
  });
	
	
	
	$("#saveManualLoginDetails").click(function(){
		
		//alert(baseURL+'admin/users/save_manual_login_details?'+$('form.frmLoginUser').serialize());
		
		var uid=$('#uid').val().trim();
		var login_time=$('#login_time').val().trim();
		var logout_date=$('#logout_date').val().trim();
		var logout_time=$('#logout_time').val().trim();
		var disp_id=$('#disp_id').val().trim();
		var comments=$('#comments').val().trim();
		
		//alert(uid + " > " + login_time +  " > " + logout_date + " > " + logout_time + " > " + disp_id + " > " + comments );
		if(uid!="" && login_time!="" && logout_date!="" && logout_time!="" && disp_id!="" && comments!=""){
			
				$('#sktLoginUserModal').modal('hide');
				$('#sktPleaseWait').modal('show');
				
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'user/save_manual_login_details',
				   data:$('form.frmLoginUser').serialize(),
				   success: function(msg){
							//alert(msg);
							$('#sktPleaseWait').modal('hide');
							location.reload();
							
					}
				  });
			  
			}else{
				alert("One or more field(s) are blank. \r\nPlease fill the data xxx");
			}
	});
	
	
	
	$("#saveManualLoginDetailsAny").click(function(){
		
		//alert(baseURL+'admin/users/save_manual_login_details_any?'+$('form.frmLoginUserAny').serialize());
		
		var agent_fusion_id=$('#agent_fusion_id').val().trim();
		var login_date=$('#mlogin_date').val().trim();
		var login_time=$('#mlogin_time').val().trim();
		var logout_date=$('#mlogout_date').val().trim();
		var logout_time=$('#mlogout_time').val().trim();
		var disp_id=$('#mdisp_id').val().trim();
		var comments=$('#mcomments').val().trim();
		
		if(agent_fusion_id!="" && login_date!="" && login_time!="" && logout_date!="" && logout_time!="" && disp_id!="" && comments!=""){
			
				$('#manualLoginUserModal').modal('hide');
				$('#sktPleaseWait').modal('show');
				
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'user/save_manual_login_details_any',
				   data:$('form.frmLoginUserAny').serialize(),
				   success: function(msg){
							//alert(msg);
							$('#sktPleaseWait').modal('hide');
							location.reload();
					}
				  });
			  
			}else{
				alert("One or more field(s) are blank. \r\nPlease fill the data");
			}
	});
	
	
	
});

  $( function() {
	
	var timeOffset="-300";
	
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
	
  
	$( "#start_date" ).datepicker({maxDate: new Date()});
	$( "#end_date" ).datepicker({ maxDate: new Date() });
	
	/*
	$("#login_date").datepicker(
		{
			dateFormat: "mm/dd/yy",
			timezone: timeOffset
		}
	);
	
	$("#mlogin_time").datetimepicker(
		{
			dateFormat: "mm/dd/yy",
			timeFormat: "HH:mm",
			timezone: timeOffset
		}
	);
	
	*/
	
	/*
	$('#login_time').timepicker();
	$('#logout_time').timepicker();
	*/
	
	$("#login_time").mask("99:99");
	$("#logout_time").mask("99:99");
	
	$("#mlogin_time").mask("99:99");
	$("#mlogout_time").mask("99:99");
	
	$("#logout_date").datepicker(
		{
			dateFormat: "mm/dd/yy",
			timezone: timeOffset
		}
	);
	
	$("#mlogin_date").datepicker(
		{
			dateFormat: "mm/dd/yy",
			timezone: timeOffset
		}
	);
	
	$("#mlogout_date").datepicker(
		{
			dateFormat: "mm/dd/yy",
			timezone: timeOffset
		}
	);
	
	
	
  });

    
</script>

