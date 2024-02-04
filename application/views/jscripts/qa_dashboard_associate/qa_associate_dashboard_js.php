<script>
$(document).ready(function(){
	
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	
	$("#process_id").on('change',function(){
		var pid = this.value;
		//if(pid=="") alert("--Select Process--");
		var URL='<?php echo base_url();?>qa_associate_dashboard/getLocation';
		$('#sktPleaseWait').modal('show');
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'pid='+pid,
		   success: function(pList){
				var json_obj = $.parseJSON(pList);//parse JSON
				$('#office_id').empty();	
				$('#office_id').append($('<option></option>').val('').html('ALL'));
				
				for (var i in json_obj){
					$('#office_id').append($('<option></option>').val(json_obj[i].abbr).html(json_obj[i].office_name));
				}
				
				$('#sktPleaseWait').modal('hide');	
			},
			error: function(){	
				alert('Fail!');
			}
		}); 
	});
	
	
	$("#process_id").on('change',function(){
		var pid = this.value;
		//if(pid=="") alert("--Select Process--");
		var URL='<?php echo base_url();?>qa_associate_dashboard/getManager';
		$('#sktPleaseWait').modal('show');
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'pid='+pid,
		   success: function(pList){
				var json_obj = $.parseJSON(pList);//parse JSON
				$('#manager_id').empty();
				
				<?php if(get_role_dir()!='manager' || get_dept_folder()=="qa"){ ?>
				$('#manager_id').append($('<option></option>').val('').html('ALL'));
				<?php } ?>
				
				for (var i in json_obj){
					$('#manager_id').append($('<option></option>').val(json_obj[i].user_id).html(json_obj[i].m_name));
				}
				
				$('#sktPleaseWait').modal('hide');	
			},
			error: function(){	
				alert('Fail!');
			}
		}); 
	});
	
	
	$("#manager_id").on('change',function(){
		var mid = this.value;
		var pid = $('#process_id').val();
		
		//if(mid=="") alert("--Select Manager--");
		var URL='<?php echo base_url();?>qa_associate_dashboard/getTl';
		$('#sktPleaseWait').modal('show');
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'pid='+pid+'&mid='+mid,
		   success: function(pList){
				var json_obj = $.parseJSON(pList);//parse JSON
				$('#tl_id').empty();	
				$('#tl_id').append($('<option></option>').val('').html('ALL'));
				
				for (var i in json_obj){
					$('#tl_id').append($('<option></option>').val(json_obj[i].user_id).html(json_obj[i].tl_name));
				}
				$('#sktPleaseWait').modal('hide');	
			},
			error: function(){	
				alert('Fail!');
			}
		}); 
	});
	
	
	$("#tl_id").on('change',function(){
		var tlid = this.value;
		var pid = $('#process_id').val();
		var mid = $('#manager_id').val();
		
		//if(tlid=="") alert("--Select TL--");
		var URL='<?php echo base_url();?>qa_associate_dashboard/getAgentviaTL';
		$('#sktPleaseWait').modal('show');
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'pid='+pid+'&tlid='+tlid,
		   success: function(pList){
				var json_obj = $.parseJSON(pList);//parse JSON
				$('#agent_id').empty();	
				$('#agent_id').append($('<option></option>').val('').html('ALL'));
				
				for (var i in json_obj){
					$('#agent_id').append($('<option></option>').val(json_obj[i].user_id).html(json_obj[i].agent_name));
				}
				$('#sktPleaseWait').modal('hide');	
			},
			error: function(){	
				alert('Fail!');
			}
		}); 
	});
	
	$("#manager_id").on('change',function(){
		var mid = this.value;
		var pid = $('#process_id').val();
		
		//if(mid=="") alert("--Select Manager--");
		var URL='<?php echo base_url();?>qa_associate_dashboard/getAgentviaManager';
		$('#sktPleaseWait').modal('show');
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'pid='+pid+'&mid='+mid,
		   success: function(pList){
				var json_obj = $.parseJSON(pList);//parse JSON
				$('#agent_id').empty();	
				$('#agent_id').append($('<option></option>').val('').html('ALL'));
				
				for (var i in json_obj){
					$('#agent_id').append($('<option></option>').val(json_obj[i].user_id).html(json_obj[i].agent_name));
				}
				$('#sktPleaseWait').modal('hide');	
			},
			error: function(){	
				alert('Fail!');
			}
		}); 
	});
	  
	  
	
});
</script>