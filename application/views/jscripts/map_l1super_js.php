<script type="text/javascript">

	$(document).ready(function(){
		
		var baseURL="<?php echo base_url(); ?>";
		
	////////////////
		$("#l1_supervisor").select2();
		$("#l1Super").select2();
		
		
		$("#fclient_id").change(function(){
			var client_id=$(this).val();
			
			populate_process_combo(client_id,'','fprocess_id','Y');
		});
		
		$("#mclient_id").change(function(){
			var client_id=$(this).val();
			
			populate_process_combo(client_id,'','mprocess_id','Y');
		});
		
		
		$("#location").on('change' , function() {
			var location = $("#location").val();

			// console.log(location);

			// if(location=="") alert("--Select--");
			var URL='<?php echo base_url();?>Map_l1super/getUserDetails';
			
			$.ajax({
				type: 'POST',    
				url:URL,
				data:'location='+location,
				success: function(aList){
				var json_obj = $.parseJSON(aList);//parse JSON
			
				$('#l1Super').empty();
				$('#l1Super').append($('<option></option>').val('').html('-- Select --'));


	        	var htm = "";
					
				for (var i in json_obj){ 
					$('#l1Super').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name +'-'+ json_obj[i].office_id));
					htm += "<option value="+json_obj[i].id+">"+json_obj[i].name+'-'+ json_obj[i].office_id+"</option>";
				}

				
				},
				error: function(){	
					alert('Fail!');
				}
			});
			
		});
		
	////////////////
		
	});

</script>	