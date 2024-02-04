<script>

$(document).ready(function() {
	
	var baseURL="<?php echo base_url();?>";
	
		/*
		$('#specific_user'). click(function(){
			if($(this). prop("checked") == true){
				$('#accessControl').show();
			}else{
				$('#accessControl').hide();
			}
		});	
		
		
		$('#edspecific_user'). click(function(){
			if($(this). prop("checked") == true){
				$('#edaccessControl').show();
			}else{
				$('#edaccessControl').hide();
			}
		});
		
		$(function(){
			$("#access_control").select2();
			$("#edaccess_control").select2();
		});
		
		
		
		$("#aoffice_id").change(function(){
			var aoffice_id=$(this).val();
			populate_access_control_combo(aoffice_id,'','access_control','Y');
		});
		
		
		
		$("#edoffice_id").change(function(){
			var edoffice_id=$(this).val();
			populate_access_control_combo(edoffice_id,'','edaccess_control','Y');
		});
		
		
		$("#aoffice_id").change(function(){
			var aoffice_id=$(this).val();
			populate_users_combo(aoffice_id,'','access_control','Y');
		});
		
		$("#btn_add_processUpdates").click(function(){
			$('#modalAddProcessUpdates').modal('show');
		});
	
		*/
		
	////////////////////	
		
		$("#client_id").change(function(){
			var client_id=$(this).val();
			populate_process_combo(client_id,'','process_id','N');
		});
		
		
		$("#edclient_id").change(function(){
			var client_id=$(this).val();
			populate_process_combo(client_id,'','edprocess_id','N');
		});
		
		
		
		$("#fclient_id").change(function(){
			var client_id=$(this).val();
			populate_process_combo(client_id,'','fprocess_id','N');
		});
		
		
	////////////	

	
	$(".pActDeact").click(function(){
		var pid=$(this).attr("adpid");
		var sid=$(this).attr("pstat");
		var title=$(this).attr("titleJS");
		
		//alert(baseURL+"policy/pActDeact?pid="+pid + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the Process Updates?");
		
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'process_update/pActDeact',
			   data:'pid='+ pid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
	
	
	$("#location_id, #client_id , #process_id").change(function(){
		
		
		
		var location_id =  $('#location_id option:selected').text();
		
		var client_name =  $('#client_id option:selected').text();
		var process_name =  $('#process_id option:selected').text();			
		var title = location_id + "-" + client_name+ "-"+process_name;
		$('#description').val(title);
		
	});
	
////////////////////////////////////////////////////////////////////////////////////////
	
	$("#create_dipcheck_form").submit(function (e) {
		$('#btnSubmit').prop('disabled',true);
	});
		
		
	/*
	$(document).on('submit','#qaformsubmit',function(){
		$('#qaformsubmit').prop('disabled',true);
			
	});
	});	 */
	
});

</script>
