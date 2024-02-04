<script>
$(document).ready(function(){
	$("#from_date").datepicker({
		dateFormat: "mm/dd/yy",
		onClose: function(selectedDate) {
			$("#to_date").datepicker("option", "minDate", new Date (selectedDate));
		}
	});
	$("#to_date").datepicker({
		dateFormat: "mm/dd/yy",
		minDate : new Date($("#from_date").val())
	});
	
	$("#office_id,#process_id").on("change",function(){
		var office_id		=	$("#office_id").val();
		var process_id		=	Math.floor($("#process_id").val());
		if(office_id != "" && process_id != "")
		{
			$("#sktPleaseWait").modal("show");
			$.ajax({
				"type" : "post",
				"dataType" : "json",
				url:"<?php echo base_url().'Qa_associate_dashboard/ajax_get_managers/';?>",
				data:{"office_id":office_id,"process_id":process_id},
				success:function(data) {
					$("#sktPleaseWait").modal("hide");
					
					$("#manager_id").empty("show");
					var manager_list	=	'<option value="">-Select-</option>';
					var counter			=	0;
					for(manager in data.managers){
						manager_list += "<option value="+data.managers[manager].id+">"+data.managers[manager].fname+" "+data.managers[manager].lname+" - "+data.managers[manager].dept_name+"</option>";
						counter++;
					}
					$("#manager_id").append(manager_list);
					$("#tl_id").empty();
					$("#agent_id").empty();
					$("#tl_id").append('<option value="">-Select-</option>');
					$("#agent_id").append('<option value="">-Select-</option>');
					
					if(counter == 0)
					{
						if(confirm("No manager found. Proceed with TL/L1 Supervisor?"))
						{
							$("#manager_id").change();
						}
					}
				}
			});
		}
	});
	$("#manager_id").on("change",function(){
		var manager_id	=	$(this).val();
		var office_id	=	$("#office_id").val();
		var process_id	=	$("#process_id").val();
		//$("#sktPleaseWait").modal("show");
		$.ajax({
			"type" : "post",
			"dataType" : "json",
			url:"<?php echo base_url().'Qa_associate_dashboard/ajax_get_tl_supervisor/';?>",
			data:{"office_id":office_id,"process_id":process_id,"manager_id":manager_id},
			success:function(data) {
				//$("#sktPleaseWait").modal("hide");
				
				$("#tl_id").empty();
				var tl_list	=	'<option value="">-Select-</option>';
				for(tl_super in data.tl_supers){
					
					
					tl_list += "<option value="+data.tl_supers[tl_super].id+">"+data.tl_supers[tl_super].fname+" "+data.tl_supers[tl_super].lname+"-"+data.tl_supers[tl_super].roleName+"-"+data.tl_supers[tl_super].office_id+"</option>";
				}
				$("#tl_id").append(tl_list);
				$("#agent_id").empty();
				$("#agent_id").append('<option value="">-Select-</option>');
				
			}
		});
	});
	$("#tl_id").on("change",function(){
		var tl_id	=	$(this).val();
		$("#sktPleaseWait").modal("show");
		$.ajax({
			"type" : "post",
			"dataType" : "json",
			url:"<?php echo base_url().'Qa_associate_dashboard/ajax_get_agents/';?>",
			data:{"tl_id":tl_id},
			success:function(data) {
				$("#agent_id").empty();
				var agent_list	=	'<option value="">-Select-</option>';
				for(agent in data.agents){
					agent_list += "<option value="+data.agents[agent].id+">"+data.agents[agent].fname+" "+data.agents[agent].lname+"</option>";
				}
				$("#agent_id").append(agent_list);
				$("#sktPleaseWait").modal("hide");
			}
		});
	});
	$("#btnView").on("click",function(){
		var office_id	=	$("#office_id").val();
		var process_id	=	$("#process_id").val();
		var manager_id	=	"";
		var tl_id		=	"";
		var agent_id	=	"";
		var role		=	"<?php echo $role;?>";
		if(typeof($("#manager_id").val()) !="undefined") 	manager_id	=	$("#manager_id").val();	else manager_id	=	0;
		if(typeof($("#tl_id").val()) !="undefined") 		tl_id		=	$("#tl_id").val();		else tl_id		=	0;
		if(typeof($("#agent_id").val()) !="undefined") 		agent_id	=	$("#agent_id").val();	else agent_id	=	0;
		var from_date	=	$("#from_date").val();
		var to_date		=	$("#to_date").val();
		if(agent_id == "" || agent_id == "0")
		{
			$("#full-score").css("display","block");
			$("#only-agent-score").css("display","none");
		}
		else
		{
			$("#full-score").css("display","none");
			$("#only-agent-score").css("display","block");
		}
		if(process_id !="" && office_id !="")
		{
			/*if((role == "manager" || role == "tl" || role == "agent") && manager_id == "")
			{
				alert("Please select Manager.");
				$("#manager_id").focus();
				return false;
			}
			else if((role == "tl" || role == "agent") && tl_id == "")
			{
				alert("Please select TL/L1 Supervisor.");
				$("#tl_id").focus();
				return false;
			}
			else if(role == "agent" && agent_id == "")
			{
				alert("Please select agent.");
				$("#tl_id").focus();
				return false;
			}*/
			$("#sktPleaseWait").modal("show");
			$.ajax({
				"type" : "post",
				"dataType" : "json",
				url:"<?php echo base_url().'Qa_associate_dashboard/ajax_qa_score/';?>",
				data:{"office_id":office_id,"manager_id":manager_id,"tl_id":tl_id,"process_id":process_id,"agent_id":agent_id,"from_date":from_date,"to_date":to_date},
				success:function(data) {
					$(".csat_process_score").text(data.datas.csat_process_score);
					$(".nps_process_score").text(data.datas.nps_process_score);
					$(".mtd_process_score").text(data.datas.mtd_process_score);
					$(".process_mtd_no_of_audit").text(data.datas.process_mtd_no_of_audit);
					
					$(".wtd_score_30").text(data.datas.wtd_score_30);
					$(".mtd_score_30").text(data.datas.mtd_score_30);
					
					$(".wtd_score_60").text(data.datas.wtd_score_60);
					$(".mtd_score_60").text(data.datas.mtd_score_60);
					
					$(".wtd_score_90").text(data.datas.wtd_score_60);
					$(".mtd_score_90").text(data.datas.mtd_score_60);
					
					$(".wtd_score_above").text(data.datas.wtd_score_above);
					$(".mtd_score_above").text(data.datas.mtd_score_above);
					
					//$(".mtd_no_of_audit").text(data.datas.mtd_no_of_audit);
					//$(".mtd_score").text(data.datas.mtd_score);
					
					//$(".wtd_no_of_audit").text(data.datas.wtd_no_of_audit);
					//$(".wtd_score").text(data.datas.wtd_score);
					var defects_all_accuracy = '';
					$('.defects_all_accuracy').html(defects_all_accuracy);
					$.each(data.datas.defects.defect_column_names,function(index,value)
					{
						var defect_accuracy_score	=	typeof(data.datas.defects.defects_all_accuracy[index])!="undefined"?data.datas.defects.defects_all_accuracy[index]:0;
						var defect_accuracy_score_percent	=	((parseInt(defect_accuracy_score)/parseInt(data.datas.defects.defects_all_count))*100).toFixed(2);
						if(isNaN(defect_accuracy_score_percent))
						{
							defects_all_accuracy += '<tr><td>'+data.datas.defects.defect_column_names[index]+'</td><td>0.00%</td></tr>';
						}
						else
						{
							defects_all_accuracy += '<tr><td>'+data.datas.defects.defect_column_names[index]+'</td><td>'+defect_accuracy_score_percent+'%</td></tr>';
						}
					});
					
					$('.defects_all_accuracy').html(defects_all_accuracy);
					var defects_all = '';
					$('.defects_all').html(defects_all);
					$.each(data.datas.defects.defect_column_names,function(index,value)
					{
						var defect_score	=	typeof(data.datas.defects.defects_all[index])!="undefined"?data.datas.defects.defects_all[index]:0;
						var defect_score_percent	=	((parseInt(defect_score)/parseInt(data.datas.defects.defects_all_count_accuracy))*100).toFixed(2);
						if(isNaN(defect_score_percent))
						{
							defects_all += '<tr><td>'+data.datas.defects.defect_column_names[index]+'</td><td>0.00%</td></tr>';
						}
						else
						{
							defects_all += '<tr><td>'+data.datas.defects.defect_column_names[index]+'</td><td>'+defect_score_percent+'%</td></tr>';
						}
					});
					$('.defects_all').html(defects_all);
				}
			});
			$("#sktPleaseWait").modal("hide");
		}
		else if(office_id == "")
		{
			alert("Please select a location");
			$("#office_id").focus();
		}
		else if(process_id == "")
		{
			alert("Please select a process");
			$("#process_id").focus();
		}
	});
});
</script>