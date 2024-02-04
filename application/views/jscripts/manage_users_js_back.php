<script type="text/javascript">

$(document).ready(function(){
    
	var baseURL="<?php echo base_url();?>";
	var fusion_id_db="";
	
	$("#dept_id").change(function(){
		var dept_id=$('#dept_id').val();
		populate_sub_dept_combo(dept_id);
	});
	
	$("#fdept_id").change(function(){
		var dept_id=$('#fdept_id').val();
		populate_sub_dept_combo(dept_id,'','fsub_dept_id','Y');
	});
	
	
	$(".editUser").click(function(){
		
		var uid=$(this).attr("uid");
		
		var vParams=$(this).attr("params");
		
		var arrPrams = vParams.split("#"); 
		$('#uid').val(uid);
		
		$('#fusion_id').val(arrPrams[0]);
		fusion_id_db=arrPrams[0];
		
		$('#office_id').val(arrPrams[1]);
		$('#dept_id').val(arrPrams[2]);
		
		$('#omuid').val(arrPrams[3]);
		$('#fname').val(arrPrams[4]);
		$('#lname').val(arrPrams[5]);
		$('#role_id').val(arrPrams[6]);
		$('#old_role_id').val(arrPrams[6]);
		
		$('#site_id').val(arrPrams[7]);
		$('#process_id').val(arrPrams[8]);
		$('#assigned_to').val(arrPrams[9]);
		
		$('#email_id').val(arrPrams[10]);
		$('#doj').val(arrPrams[11]);
		$('#phno').val(arrPrams[12]);
		
		var client_id=arrPrams[13];
		$('#client_id').val(client_id);
		
		var sub_process_id=arrPrams[14];
		$('#sub_process_id').val(sub_process_id);
		
		var red_login_id=arrPrams[15];
		$('#red_login_id').val(red_login_id);
		
		var sub_dept_id=arrPrams[16];
		$('#sub_dept_id').val(sub_dept_id);
		
		var xpoid=arrPrams[17];
		$('#xpoid').val(xpoid);
		
		var dept_id=arrPrams[2];
		var role_id=arrPrams[6];
		var office_id= arrPrams[1];
		var process_id=arrPrams[8];
		var assigned_to=arrPrams[9];
		
		populate_sub_dept_combo(dept_id,sub_dept_id);
				
		if(role_id>=1){
			
			if(dept_id==4 || dept_id==5 || dept_id==6 || dept_id==8){
				
				if(role_id == 2 || role_id == 3 || role_id == 5 || role_id == 7 || role_id == 8 || role_id == 9 ){
					
					populate_process_combo(client_id,process_id);
					
					$("#process_div").show();		
					$('#process_id').attr('required', 'required');
					
					$("#sub_process_div").show();
					populate_sub_process_combo(process_id,sub_process_id);
					
				}else{
				
					$("#process_div").hide();		
					$('#process_id').removeAttr('required');
					
					$("#sub_process_div").hide();		
					$('#sub_process_id').removeAttr('required');
				}
								
					
				if(role_id == 3 || role_id == 7 || role_id == 8 ){  //3->agent,7->Trainee ,8->nest
					
					populate_assign_combo(office_id,assigned_to);
					
					$("#assigned_to_div").show();		
					$('#assigned_to').attr('required', 'required');	
					
				}else {
					
					$('#assigned_to').removeAttr('required');
					$("#assigned_to_div").hide();
					
				}
		
			}else{
				
				$("#process_div").hide();		
				$('#process_id').removeAttr('required');
				
				$("#sub_process_div").hide();		
				$('#sub_process_id').removeAttr('required');
					
				$('#assigned_to').removeAttr('required');
				$("#assigned_to_div").hide();					
			}
		
		}else{
			
			$("#process_div").hide();		
			$('#process_id').removeAttr('required');
			
			$("#sub_process_div").hide();		
			$('#sub_process_id').removeAttr('required');
			
			$('#assigned_to').removeAttr('required');
			$("#assigned_to_div").hide();				
					
		}
		
		$('#sktModal').modal('show');
		
		//alert("UID="+uid + " atl:"+atl);
		
	});
	
	
	 $("#role_id").change(function(){
		
		var dept_id=$('#dept_id').val();
		var role_id=$(this).val();
		var office_id= $("#office_id").val();
		
		
		if(role_id>=1){
			
			if(dept_id==4 || dept_id==5 || dept_id==6 || dept_id==8){
				
				if(role_id == 2 || role_id == 3 || role_id == 5 || role_id == 7 || role_id == 8 || role_id == 9 ){
										
					$("#process_div").show();		
					$('#process_id').attr('required', 'required');
					
				}else{
				
					$("#process_div").hide();		
					$('#process_id').removeAttr('required');
					
					$("#sub_process_div").hide();		
					$('#sub_process_id').removeAttr('required');
				}
				
				if(role_id == 3 || role_id == 7 || role_id == 8 ){  //3->agent,7->Trainee ,8->nest
					
					populate_assign_combo(office_id);
					
					$("#assigned_to_div").show();		
					$('#assigned_to').attr('required', 'required');	
					
				}else {
					
					$('#assigned_to').removeAttr('required');
					$("#assigned_to_div").hide();
				}
		
			}else{
			
				
				
				$("#process_div").hide();		
				$('#process_id').removeAttr('required');
				
				$("#sub_process_div").hide();		
				$('#sub_process_id').removeAttr('required');
					
				$('#assigned_to').removeAttr('required');
				$("#assigned_to_div").hide();					
			}
		
		}else{
					
			$("#process_div").hide();		
			$('#process_id').removeAttr('required');
			
			$("#sub_process_div").hide();		
			$('#sub_process_id').removeAttr('required');
			
			$('#assigned_to').removeAttr('required');
			$("#assigned_to_div").hide();				
					
		}
		
    });
	
	
	$("#office_id").change(function(){
		
		var abbr=$(this).val();
		var uid=$('#uid').val();
		
		if(fusion_id_db==""){
		
			var fusion_id="F"+abbr +""+pad(uid,6);
			//alert(fusion_id);
			$('#fusion_id').val(fusion_id);
			
		}
					
	});
	
	$("#client_id").change(function(){
		
		var client_id=$(this).val();
		
		$("#role_div").show();
		//$("#role_id").val('');
		
		//$("#site_id").val('');
		
		if(client_id=="1"){
		
			$("#site_div").show();
			$('#site_id').attr('required', 'required');
			
		}else{
					
			$("#site_div").hide();
			$('#site_id').removeAttr('required');
		}
		
		populate_process_combo(client_id);
		
	});
	
	$("#fclient_id").change(function(){
		
		var client_id=$(this).val();
		
		if(client_id=="1"){
			$("#foffice_div").hide();
			$("#foffice_id").val('ALL');
			$("#fsite_div").show();
			
		}else{
			$("#fsite_div").hide();
			$("#fsite_id").val('ALL');
			$("#foffice_div").show();
		}
		
		populate_process_combo(client_id,'','fprocess_id','Y');
		
	});
	
	$("#fprocess_id").change(function(){
		
		var pid=$(this).val();
		populate_sub_process_combo(pid,'','fsub_process_id','Y');
		
	});
	
	
	$("#process_id").change(function(){
		var process_id=$(this).val();
		$("#sub_process_div").show();
		populate_sub_process_combo(process_id);
			
	});
	
		
	$("#updateUser").click(function(){
	
		var uid=$('#uid').val().trim();
		var office_id=$('#office_id').val().trim();
		var fusion_id=$('#fusion_id').val().trim();
		var dept_id=$('#dept_id').val().trim();
		var role_id=$('#role_id').val().trim();
						
		//alert("users/updateUser?"+$('form.editUser').serialize());
		
		if(uid!="" && office_id!="" && fusion_id!="" && dept_id!="" && role_id!=""){
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'users/updateUser',
			   data:$('form.editUser').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#sktModal').modal('hide');
						location.reload();
				}
				/*,
				error: function(){
					alert('Fail!');
				}
				*/
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});
	
	
	$(".resetPasswd").click(function(){
	
		var uid=$(this).attr("uid").trim();
				
		var ans=confirm("Are you sure to reset the password?\r\n New password will be 'Fusion ID'");
		if(ans==true){
		
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'users/resetPasswd',
			   data:'uid='+ uid,
			   success: function(msg){
					//alert(msg);
					location.reload();
				},
				error: function(){
					alert('Fail!');
				}
			  });
		}
	});
	
	
	$(".setGlobalAccess").click(function(){
	
		var uid=$(this).attr("uid").trim();
		var cgval=$(this).attr("cgval").trim();
				
		//var ans=confirm('Are you sure to set global access');
		//if(ans==true){
		
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'user/setGlobalAccess',
			   data:'uid='+ uid+"&cgval="+cgval,
			   success: function(msg){
					//alert(msg);
					location.reload();
				},
				error: function(){
					alert('Fail!');
				}
			  });
		//}
	});
		
	$(".rejoinTermUser").click(function(){
	
		var uid=$(this).attr("uid");
		
		$('#rejoin_date').val('<?php echo CurrDateMDY();?>');
		
		$('#rjuid').val(uid);
		$('#reJoinModal').modal('show');
		
	});
	
	
	$("#btnReJoinTermUser").click(function(){
	
		var rjuid=$('#rjuid').val().trim();
		var rejoin_date=$('#rejoin_date').val().trim();
		
		//alert("user/rejoin_term_user?"+$('form.frmReJoinUser').serialize());
		
		if(rjuid!="" && rejoin_date!=""){
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'user/rejoin_term_user',
			   data:$('form.frmReJoinUser').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#reJoinModal').modal('hide');
						location.reload();
				}
				/*,
				error: function(){
					alert('Fail!');
				}
				*/
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});
	
	
	
	$( "#doj" ).datepicker();
	$( "#rejoin_date" ).datepicker({maxDate: new Date()});
	$( "#rejoin_date" ).datepicker();
		
});

function pad(num, size) {
    var s = "0000000000" + num;
    return s.substr(s.length-size);
}

    
</script>

