<script type="text/javascript">


var timeOffset="-300";
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
	
	
	/* global setting */
    var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        //minDate   : "D",
		//maxDate   : "5D",
    }
	
	
	var datepickersOpt1 = {
		dateFormat: 'mm/dd/yy',
	}


$(document).ready(function(){
	
////////////////////////
	$("#date_from").datepicker(datepickersOpt);
	$("#date_to").datepicker(datepickersOpt);
/////////////////////////	
    
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
	
	var baseURL="<?php echo base_url();?>";
			
	$("#filter_key").change(function(){
		
		var key=$(this).val();
		//alert(key);
		
			$("#site_div").hide();
			$('#site_id').removeAttr('required');
			
			$("#agent_div").hide();
			$('#agent_id').removeAttr('required');
			
			$("#process_div").hide();
			$('#process_id').removeAttr('required');
			
			$("#disp_div").hide();
			$('#disp_id').removeAttr('required');
			
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
		
		}else if($(this).val() == "Disposition" ){ 
			
			$("#disp_div").show();
			$('#disp_id').attr('required', 'required');
		
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
	
/////////////////////DFR Requisition part////////////////////////
		$("#requisitionID").change(function(){
			var req_fil = $(this).val();
			if(req_fil!=''){
				$('.reqFilter').prop('disabled', true);
			}else{
				$('.reqFilter').prop('disabled', false);
			}
		});
		
		
		$("#fdoffice_id").on('change',function(){
			var offid = this.value;
			
			
			if(offid=="") alert("--Select--");
			var URL='<?php echo base_url();?>dfr/getRequisitionid';
			$('#sktPleaseWait').modal('show');
			$.ajax({
			   type: 'POST',    
			   url:URL,
			   data:'offid='+offid,
			   success: function(offList){
					var json_obj = $.parseJSON(offList);//parse JSON
					
					$('#requisitionID').empty();	
					
					$('#requisitionID').append($('<option></option>').val('').html('ALL'));
					for (var i in json_obj){
						$('#requisitionID').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].requisition_id));
					}
					
					$('#sktPleaseWait').modal('hide');	

				},
				error: function(){	
					alert('Fail!');
				}
				
			});
			  
		});

///////////////
});


	

  $( function() {
  
   // $( "#start_date" ).datepicker();
	$( "#start_date" ).datepicker({maxDate: new Date()});
	//$('#start_date').datepicker( "setDate", "-1d" );
	
	
	$( "#end_date" ).datepicker({ maxDate: new Date() });
	 
	//$( "#end_date" ).datepicker();
	
  });
    
</script>

<script>
	$(document).ready(function(){
		
		$("#fclient_id").on('change',function() {
			var cid = this.value;
			var office_id = $('#foffice_id').val();
			//alert(office_id);
			
			if(cid=="") alert("Please Select Client")
			var URL='<?php echo base_url();?>reports/getProcessTitle';
			$('#sktPleaseWait').modal('show');
			$.ajax({
			   type: 'POST',    
			   url:URL,
			   data:'cid='+cid+'&office_id='+office_id,
			   success: function(cList){
				   //alert(pList);
					var json_obj = $.parseJSON(cList);//parse JSON
					
					$('#process_update_id').empty();
					$('#process_update_id').append($('<option></option>').val('').html('-- Select --'));
							
					for (var i in json_obj) $('#process_update_id').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].title+' -'+json_obj[i].off_loc+' '+json_obj[i].client));
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
	$(document).ready(function(){
		//$("#life_lob").hide();
		$('#lob').removeAttr('required');
		
		$("#process_id").on('change',function(){
			var prsid=$(this).val();
			
			if(prsid=='OYO LIFE'){
				$("#life_lob").show();
				$("#lob").attr('required', 'required');
			}else{
				$("#life_lob").hide();
				$('#lob').removeAttr('required');
			}
			
		});
	});
</script>



<script>
	$(document).ready(function(){
		 $('input#xpoid').keypress(function (e) {
			var a=   $('input#xpoid').val();
			 if(a != ''){
				$('input#start_date').removeAttr('required');
				$('input#end_date').removeAttr('required');
			 }
		});
	});
</script>