<style>
.datepicker-modal {
  position: absolute !important;
  top: auto !important;
  left: auto !important;
}
</style>

<script type="text/javascript">
	$(document).ready(function(){

		var baseURL="<?php echo base_url();?>";


		$("#rjct_reason").change(function(){
	    	var rjct_reason = $(this).val();

	    	// alert(rjct_reason);
			if(rjct_reason == 'Incomplete Documentation' || rjct_reason == 'Other'){
				$("#rjct_cmnt").attr("required",true);
				$("#comnt_div").show();
			}
			else{
				$("#comnt_div").hide();
				$('#rjct_cmnt').removeAttr('required');
			}	
	    });


		$(".aprvNaps").click(function(){
			var cid=$(this).attr("c_id");
			$.ajax({
				   type: 'POST',    
				   url:baseURL+'naps/get_dfr_details',
				   data:'c_id='+cid,
				   success: function(msg){
				   	var alrt = JSON.parse(msg);
				   	// console.log(alrt[0].id);
					   	if(alrt[0].last_qualification =="Graduation" || alrt[0].last_qualification =="Masters"){
					   		$("#contrct_period").val('360/365 Days'); 
						   	$("#enroll_state").val('NAPS');
					   	}else{
					   		$("#contrct_period").val("180 Days"); 
						   	$("#enroll_state").val('BTP (10+2)');
					   	}
					   
					}
			  	});
			$("#c_id").val(cid);
			$("#modalAprv").modal('show');
			
		});


		$(document).on('submit','.frmAprv',function(e){
			e.preventDefault();

			let valid = true;
		    $('.frmAprv input:required').each(function() {
		      if ($(this).is(':invalid') || !$(this).val()) valid = false;
		    })
		    if (!valid) alert("please fill all fields!");
	  		else{
					
					$('#sktPleaseWait').modal('show');
						
					$.ajax({
					    type: 'POST',    
					    url:baseURL+'naps/process_aprv',
					    data: new FormData(this),
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
				  			var alrt = JSON.parse(msg);
				  			if(alrt.error == "file_error"){
				  				$('#sktPleaseWait').modal('hide');
				  				alert('Unable to upload file..please reupload');
				  			}else if(alrt.error == "no_error"){
				  				$('#sktPleaseWait').modal('hide');
								$('#modalAprv').modal('hide');
								location.reload();
				  			}
							
						}
					});
				}
			
		});

		$(".rjctNaps").click(function(){
			var c_id=$(this).attr("c_id");
			$("#rjct_c_id").val(c_id);

			$.ajax({
				   type: 'POST',    
				   url:baseURL+'naps/get_dfr_cause_list',
				   data:"",
				   success: function(msg){
						$("#rjct_reason").html(msg);
					}
			  	});

			//$("#rjct_reason").html();
			$("#modalrjct").modal('show');

		});

		$(document).on('submit','.frmrjct',function(e){
			e.preventDefault();

			let valid = true;
		    $('.frmrjct input:required').each(function() {
		      if ($(this).is(':invalid') || !$(this).val()) valid = false;
		    })
		    if (!valid) alert("please fill all fields!");
	  		else{
					
					$('#sktPleaseWait').modal('show');
						
					$.ajax({
					    type: 'POST',    
					    url:baseURL+'naps/process_rjct',
					    data:$('form.frmrjct').serialize(),
				  		success: function(msg){
				  				$('#sktPleaseWait').modal('hide');
								$('#modalrjct').modal('hide');
								location.reload();	
						}
					});
				}
			
		});


		$(".updteNaps").click(function(){
			var cid=$(this).attr("c_id");
			$.ajax({
				   type: 'POST',    
				   url:baseURL+'naps/get_dfr_naps_details',
				   data:'c_id='+cid,
				   success: function(msg){
				   	var alrt = JSON.parse(msg);
				   	 //console.log(alrt[0].id);
						   	$("#enroll_state").val(alrt[0].enroll_state);
					   		$("#contrct_date").val(alrt[0].contract_date);
					   		$("#apprentice_no").val(alrt[0].apprentice_registration_no);
					   		$("#contract_no").val(alrt[0].contract_registration_no);
					   
					}
			  	});
			$("#c_id").val(cid);
			$("#modalAprv").modal('show');
			
		});

		$(document).on('submit','.frmAprvUpdte',function(e){
			e.preventDefault();
			let valid = true;
		    $('.frmAprvUpdte input:required').each(function() {
		      if ($(this).is(':invalid') || !$(this).val()) valid = false;
		    })
		    if (!valid) alert("please fill all fields!");
	  		else{
				
					
					$('#sktPleaseWait').modal('show');
						
					$.ajax({
					    type: 'POST',    
					    url:baseURL+'naps/process_aprvUpdate',
					    data: new FormData(this),
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
				  			var alrt = JSON.parse(msg);
				  			if(alrt.error == "file_error"){
				  				$('#sktPleaseWait').modal('hide');
				  				alert('Unable to upload file..please reupload');
				  			}else if(alrt.error == "no_error"){
				  				$('#sktPleaseWait').modal('hide');
								$('#modalAprv').modal('hide');
								location.reload();
				  			}
							
						}
					});
				}
			
		});

		$(".moveNaps").click(function(){
			var cid=$(this).attr("c_id");
			$("#c_id").val(cid);
			$("#modalmove").modal('show');
			
		});
		$(document).on('submit','.frmmove',function(e){
			e.preventDefault();

			let valid = true;
		    $('.frmmove input:required').each(function() {
		      if ($(this).is(':invalid') || !$(this).val()) valid = false;
		    })
		    if (!valid) alert("please fill comment fields!");
	  		else{
					
					$('#sktPleaseWait').modal('show');
						
					$.ajax({
					    type: 'POST',    
					    url:baseURL+'naps/process_move',
					    data: new FormData(this),
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
				  			var alrt = JSON.parse(msg);
				  			if(alrt.error == "file_error"){
				  				$('#sktPleaseWait').modal('hide');
				  				alert('Unable to upload file..please reupload');
				  			}else if(alrt.error == "no_error"){
				  				$('#sktPleaseWait').modal('hide');
								$('#modalmove').modal('hide');
								location.reload();
				  			}
							
						}
					});
				}
			
		});

		$("#status_chk").change(function(){
			var dt = $(this).val();
			if(dt==2){
				$('#reason_list').css('display','');
			}else{
				$('#reason_list').css('display','none');
			}
		});

		$(".EditNaps").click(function(){
			var cid=$(this).attr("c_id");
			$("#can_id").val(cid);
			$.get(baseURL+'naps/candidate_edit_details',{'id':cid},function(data, status){
				obj = JSON.parse(data);
				$('#phone_no').val(obj.phone_no);
				$('#alter_phone').val(obj.alt_phone);
				$('#aadhar_no').val(obj.aadhar);
				$('#pan').val(obj.pan);
				
			});
			$("#modalEdit").modal('show');
			
		});
		$(document).on('submit','.frmEdit',function(e){
			e.preventDefault();
			let valid = true;
		    $('.frmEdit input:required').each(function() {
		      if ($(this).is(':invalid') || !$(this).val()) valid = false;
		    })
		    if (!valid) alert("please fill all fields!");
	  		else{
				
					
					$('#sktPleaseWait').modal('show');
						
					$.ajax({
					    type: 'POST',    
					    url:baseURL+'naps/process_candidateUpdate',
					    data: new FormData(this),
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
							  //alert(msg);
				  			
				  				$('#sktPleaseWait').modal('hide');
								$('#modalEdit').modal('hide');
								location.reload();
				  			
							
						}
					});
				}
			
		});

		$(document).on('submit','.frmBgUpdte',function(e){
			e.preventDefault();
			let valid = true;
		    $('.frmBgUpdte input:required').each(function() {
		      if ($(this).is(':invalid') || !$(this).val()) valid = false;
		    })
		    if (!valid) alert("please fill all fields!");
	  		else{
				
					
					$('#sktPleaseWait').modal('show');
						
					$.ajax({
					    type: 'POST',    
					    url:baseURL+'naps/upload_Bg_file',
					    data: new FormData(this),
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
							  alert(msg);
				  			
				  				$('#sktPleaseWait').modal('hide');
								$('#modalBg').modal('hide');
								location.reload();
						}
					});
				}
			
		});

		$(".addsetNaps").click(function(){
			//alert("enter");
			$('#c_id').val(0);
			$('#modalsetting').modal('show');
		});

		$(".updtesetNaps").click(function(){
			var cid=$(this).attr("c_id");
			$("#can_id").val(cid);
			$.get(baseURL+'naps/setting_edit_details',{'id':cid},function(data, status){
				obj = JSON.parse(data);
				$('#percentage_edit').val(obj.percentage);
				$('#max_amount_edit').val(obj.max_amount);
				$('#from_date_edit').val(obj.from_date);
				$('#to_date_edit').val(obj.to_date);
				
			});
			$('#editmodalsetting').modal('show');
		});

		$(document).on('submit','.frmsett',function(e){
			e.preventDefault();
			let valid = true;
		    $('.frmsett input:required').each(function() {
				//alert($(this).val());
		      if ($(this).is(':invalid') || !$(this).val()) valid = false;
		    })
		    if (!valid) alert("please fill all fields!");
	  		else{
				
					
					$('#sktPleaseWait').modal('show');
						
					$.ajax({
					    type: 'POST',    
					    url:baseURL+'naps/add_setting_claim_amount',
					    data: new FormData(this),
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
							  alert(msg);
				  			
				  				$('#sktPleaseWait').modal('hide');
								$('#modalBg').modal('hide');
								location.reload();
						}
					});
				}
			
		});
		$(document).on('submit','.frmsettedit',function(e){
			e.preventDefault();
			let valid = true;
		    $('.frmsettedit input:required').each(function() {
				//alert($(this).val());
		      if ($(this).is(':invalid') || !$(this).val()) valid = false;
		    })
		    if (!valid) alert("please fill all fields!");
	  		else{
				
					
					$('#sktPleaseWait').modal('show');
						
					$.ajax({
					    type: 'POST',    
					    url:baseURL+'naps/edit_setting_claim_amount',
					    data: new FormData(this),
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
							  alert(msg);
				  			
				  				$('#sktPleaseWait').modal('hide');
								$('#modalBg').modal('hide');
								location.reload();
						}
					});
				}
			
		});
		$(".delsetNaps").click(function(){
			var cid=$(this).attr("c_id");
			$('#sktPleaseWait').modal('show');
			$.ajax({
					    type: 'GET',    
					    url:baseURL+'naps/Delete_setting_claim_amount',
					    data: 'id='+cid,
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
							  alert(msg);
				  			
				  				$('#sktPleaseWait').modal('hide');
								$('#modalBg').modal('hide');
								location.reload();
						}
					});

		});
		$(".addprogNaps").click(function(){
			//alert("enter");
			$('#c_id').val(0);
			$('#modalprogram').modal('show');
		});
		$(".updteprogNaps").click(function(){
			var cid=$(this).attr("c_id");
			$("#can_id").val(cid);
			$.get(baseURL+'naps/program_edit_details',{'id':cid},function(data, status){
				obj = JSON.parse(data);
				$('#name_edit').val(obj.name);
				$('#duration_edit').val(obj.duration);
				$('#from_date_edit').val(obj.from_date);
				$('#to_date_edit').val(obj.to_date);
				
			});
			$('#editmodalprogram').modal('show');
		});
		$(document).on('submit','.frmprog',function(e){
			e.preventDefault();
			let valid = true;
		    $('.frmprog input:required').each(function() {
				//alert($(this).val());
		      if ($(this).is(':invalid') || !$(this).val()) valid = false;
		    })
		    if (!valid) alert("please fill all fields!");
	  		else{
				
					
					$('#sktPleaseWait').modal('show');
						
					$.ajax({
					    type: 'POST',    
					    url:baseURL+'naps/add_program_master',
					    data: new FormData(this),
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
							  alert(msg);
				  			
				  				$('#sktPleaseWait').modal('hide');
								$('#modalBg').modal('hide');
								location.reload();
						}
					});
				}
			
		});
		$(document).on('submit','.frmprogedit',function(e){
			e.preventDefault();
			let valid = true;
		    $('.frmprogedit input:required').each(function() {
				//alert($(this).val());
		      if ($(this).is(':invalid') || !$(this).val()) valid = false;
		    })
		    if (!valid) alert("please fill all fields!");
	  		else{
				
					
					$('#sktPleaseWait').modal('show');
						
					$.ajax({
					    type: 'POST',    
					    url:baseURL+'naps/edit_program_master',
					    data: new FormData(this),
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
							  alert(msg);
				  			
				  				$('#sktPleaseWait').modal('hide');
								$('#modalBg').modal('hide');
								location.reload();
						}
					});
				}
			
		});
		$(".delprogNaps").click(function(){
			var cid=$(this).attr("c_id");
			$('#sktPleaseWait').modal('show');
			$.ajax({
					    type: 'GET',    
					    url:baseURL+'naps/Delete_program_master',
					    data: 'id='+cid,
					    contentType: false,
						cache: false,
						processData:false,
				  		success: function(msg){
							  alert(msg);
				  			
				  				$('#sktPleaseWait').modal('hide');
								$('#modalBg').modal('hide');
								location.reload();
						}
					});

		});
		
		
	});
	function uploadbg_file(obj){
		$('#dfr_id').val(obj);
		$('#modalBg').modal('show');
			
	}
</script>


