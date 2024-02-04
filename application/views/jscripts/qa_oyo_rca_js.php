
<script>
	$(document).on('blur','#fusion_id',function()
	{
		var request_url = "<?php echo base_url('qa_oyo_rca/get_agent_information'); ?>";
		var fusion_id = $(this).val();
		if(fusion_id.length > 9)
		{
			var datas = {'fusion_id':fusion_id};
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				$.each(res.datas,function(index,element)
				{
					if($('#'+index).prev().is("input"))
					{
						$('#'+index).val(element);
					}
					else
					{
						$('#'+index).text(element);
					}
					console.log(index+' - '+element);
				});
			},request_url, datas, return_type = 'text');
		}
	});
</script>

<script>
	$('#activate_get_fusion_id').click(function()
	{
		$('#get_fusion_id').modal('show');
	});
</script>

<script>
	$("#fetch_agents").click(function(){
  
		var URL='<?php echo base_url();?>user/getAgentList';
		
		var aname=$('#aname').val();
		
		var aomuid=$('#aomuid').val();
		
		//alert(URL+"?pid="+pid);
		
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'aname='+aname+'&aomuid='+aomuid,
		   success: function(aList){
					
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
		//$("#agent_name").val(aname);
		$("#fusion_id").val(fid);
		$("#fusion_id").focus();
		
		$('#get_fusion_id').modal("hide");		
	});
</script>


<script>
	$(document).ready(function(){
		
		$('#salesoppr').hide();
		$('#reason_nonconv').hide();
		
		$('#sales_oppr').change(function(){
			var s_o=$(this).val();
			if(s_o=='Yes'){
				$('#salesoppr').show();
				$('#sales_done').prop('disabled', false);
			}else{
				$('#salesoppr').hide();
				$('#sales_done').prop('disabled', true);
				
				$('#reason_nonconv').hide();
			}
		});
		
		$('#sales_done').change(function(){
			var s_d=$(this).val();
			if(s_d=='No'){
				$('#reason_nonconv').show();
				$('#reason_nonconv').prop('disabled', false);
			}else{
				$('#reason_nonconv').hide();
				$('#reason_nonconv').prop('disabled', true);
			}
		});
		
	});
</script>

<script>
	$(function(){
		$('#audit_date').datepicker({
			dateFormat: 'yy-mm-dd'
		});
		
		$('#call_duration').timepicker({
			timeFormat: 'HH:mm:ss',
		});
		
		$('#record_date_time').datetimepicker({
			dateFormat: 'yy-mm-dd', 
			timeFormat: 'HH:mm:ss'
		});
		
		$('#from_date').datepicker({
			//dateFormat: 'yy-mm-dd'
		});
		
		$('#to_date').datepicker({
			//dateFormat: 'yy-mm-dd'
		});
		
		$('#audit_date_time').datetimepicker();
		
		$('#audit_date').datepicker();
		$('#escalated_date').datepicker();
		$('#call_date').datepicker();
		
	});
</script>

<script>
	$(document).on('click','#submit',function(e){
		
		e.preventDefault();
		var datas = {};
		$('.database_value').each(function(index,element)
		{
			var id = $(element).attr('id');
			console.log(element);
			console.log(id);
			if($(element).is("input"))
			{
				//console.log(id+' - '+$('#'+id).val());
				datas[id] = $('#'+id).val();
			}
			else if($(element).is("select"))
			{
				//console.log(id+' - '+$('#'+id).val());
				datas[id] = $('#'+id).val();
			}
			else if($(element).is("textarea"))
			{
				//console.log(id+' - '+$('#'+id).val());
				datas[id] = $('#'+id).val();
			}
			else
			{
				//console.log(id+' - '+$('#'+id).text());
				datas[id] = $('#'+id).text();
			}
		});
		//console.log(datas);
		var url = "<?php echo base_url('qa_oyo_rca/process_oyo_rca'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				alert('Information Saved');
				$('.database_value,.databaseValue').each(function(index,element)
				{
					if($(element).is("input"))
					{
						$(element).val('');
					}
					else if($(element).is("select"))
					{
						$(element).val('');
					}
					else if($(element).is("textarea"))
					{
						$(element).val('');
					}
					else
					{
						$(element).text('');
					}
				});
				$('#team_leader_name').text('');
			}
			else
			{
				alert('Try Afer Some Time');
			}
		},url,datas, 'text');
	});
</script>


<!-------------------SIG RCA Issue Category/Subcategory-------------------------->
<script>
 $(document).ready(function(){
	 
	 $("#monetory_loss").on('change',function(){
		if($(this).val()=='Yes'){
			$("#amount").prop('disabled',false);
			$("#amount").attr('required',true);
		}else{
			$("#amount").prop('disabled',true);
			$("#amount").attr('required',false);
			$("#amount").val('');
		}
		
	 });
	 
///////////////////////////
	 
   $("#issue_category").on('change' , function(){ 
	var cid = this.value;
	if(cid=="") alert("Please Select Category");
	var URL='<?php echo base_url();?>qa_oyosig_rca/issueSubcategory';
	$('#sktPleaseWait').modal('show');
	$.ajax({
	   type: 'POST',    
	   url:URL,
	   data:'cid='+cid,
	   success: function(cList){
			var json_obj = $.parseJSON(cList);//parse JSON
			$('#issue_subcategory').empty();
			$('#issue_subcategory').append($('<option></option>').val('').html('-- Select --'));
					
			for (var i in json_obj) $('#issue_subcategory').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].description));
			$('#sktPleaseWait').modal('hide');
		},
		error: function(){	
			alert('Fail!');
		}
	  }); 
   });
   
   $("#acpt").on('change' , function(){ 
	var acptid = this.value;
	if(acptid=="") alert("Please Select ACPT");
	var URL='<?php echo base_url();?>qa_oyosig_rca/acptwhy1';
	$('#sktPleaseWait').modal('show');
	$.ajax({
	   type: 'POST',    
	   url:URL,
	   data:'acptid='+acptid,
	   success: function(acptList){
			var json_obj = $.parseJSON(acptList);//parse JSON
			$('#why1').empty();
			$('#why1').append($('<option></option>').val('').html('-- Select --'));
					
			for (var i in json_obj) $('#why1').append($('<option></option>').val(json_obj[i].description).html(json_obj[i].description));
			$('#sktPleaseWait').modal('hide');
		},
		error: function(){	
			alert('Fail!');
		}
	  }); 
   });
   
//////////////////////////////////////
	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});
///////////////////////////////
 
 $( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_oyosig_rca/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
 
 });
 </script>