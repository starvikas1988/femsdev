<script type="text/javascript" src="<?php echo base_url(); ?>assets/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
 function toggleIcon(e) {
	$(e.target) 
	
		.prev('.panel-heading')
		.find(".more-less")
		.toggleClass('glyphicon-plus glyphicon-minus'); 
	}
	

	function btnAssmntResultUpload_ajax(a){
		
		var batch_id=$(a).attr("batch_id");
		var asmnt_id = $(a).attr("asmnt_id");
		$('#arubatch_id').val(batch_id);
		$('#aruassmnt_id').val(asmnt_id);
		var uUrl=baseURL+'training/downloadOfflineResultHeader' + '?bid=' + batch_id + '&aid=' + asmnt_id;
		$("#downloadheaderOffline").attr("href", uUrl);		
		$('#modelAssmntResultUpload').modal('show');
		
	}
	
	
	function btnScheduleAssmnt_ajax(a)
	{
		var loc_id=$(a).attr("loc_id");
		var batch_id=$(a).attr("batch_id");
		var asmnt_id = $(a).attr("asmnt_id");
		$('#sabatch_id').val(batch_id);
		$('#saassmnt_id').val(asmnt_id);
		
		$('#modalScheduleAssmnt').modal('show');
		$('#scheduleAssmntListContainer').html("");
		
		var rURL=baseURL+'training/fetchActiveAgent';
		
		$('#sktPleaseWait').modal('show');
		//alert(rURL + "?batch_id="+batch_id);
		
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   data:'batch_id='+batch_id+"&asmnt_id="+asmnt_id+"&loc_id="+loc_id,
		   success: function(response){
				
				//alert(response);
				var json_obj = JSON.parse(response);
				
				var html = '';
				
				for (var i in json_obj){
					
					html += '<tr><td><input type="checkbox" name="agentCheckBox[]" value="'+json_obj[i].user_id+'"></td><td>'+json_obj[i].fname + " " + json_obj[i].lname +'</td> <td>'+json_obj[i].fusion_id+'</td> <td>'+json_obj[i].role_name + " ("+ json_obj[i].dept_name + ")"+'</td> </tr>';
					
				}
				$('#scheduleAssmntListContainer').html(html);
							
				$('#sktPleaseWait').modal('hide');
								
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
	}
	
	
	
$(document).ready(function(){
		var process_id=$("#b_process_id").val();
		var office_id=$("#b_office_id").val();
		// alert(process_id);
		var training_type=$("#training_type").val();
		// alert(training_type);
		// baseURL = "<?php echo base_url(); ?>";
		// request_url = baseURL + "/training/auto_batch_name/" + process_id;
		// datas = { 'process_id' : process_id,'office_id' : office_id };
		// process_ajax(function(response)
		// {
		// 	// alert(response);
		// 	$("#batch_name").val(response);
		//    $("#batch_name").prop('readOnly', true);

		// 	//console.log(response);
		// },request_url, datas, 'text');
		$("#batch_name").prop('readOnly', true);
		
	
	$('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);	
	
	var baseURL="<?php echo base_url();?>";
	
		
	$(".btnCertficationDesign").click(function(){
		var batch_id=$(this).attr("batch_id");
		$('#trn_batch_id').val(batch_id);
		var rURL=baseURL+'training/cert_design/'+batch_id;
		
		window.location = rURL;
	});
	
	$("#search_assmnt_summ #office_id").change(function(){
		var office_id=$(this).val();
		var batch_type = $('#as_batch_type').val();
		var rURL=baseURL+'training/assmnt_summary?office_id='+office_id;
		if(batch_type == 3){ rURL=baseURL+'training/assmnt_summary/nesting?office_id='+office_id; }
		if(batch_type == 4){ rURL=baseURL+'training/assmnt_summary/recursive?office_id='+office_id; }
		if(batch_type == 5){ rURL=baseURL+'training/assmnt_summary/upskill?office_id='+office_id; }
		if(batch_type == 1){ rURL=baseURL+'training/assmnt_summary/production?office_id='+office_id; }
		window.location = rURL;
		
	});
	
	
	$("#search_ert_summ #office_id").change(function(){
		var office_id = $(this).val();
		var rURL = baseURL + 'training?office_id=' + office_id;
		window.location = rURL;
		//var rs_picker = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
		//var re_picker = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
	});

	$("#training_type").change(function(){
		var training_type=$(this).val();
		if(training_type!='2'){
			$("#batch_name").val("");
			$("#b_office_id").val("");
			$("#b_process_id").val("");
			$("#b_client_id").val("");
		$("#batch_name").prop('readOnly', false);

		}
		else{
			$("#batch_name").val("");
			$("#b_office_id").val("");
			$("#b_process_id").val("");
			$("#b_client_id").val("");
		$("#batch_name").prop('readOnly', true);

		}



	});

	$("#b_process_id").change(function(){
		var process_id=$(this).val();
		var office_id=$("#b_office_id").val();
		// alert(process_id);
		var training_type=$("#training_type").val();
		// alert(training_type);
		if(training_type=='2') {
		baseURL = "<?php echo base_url(); ?>";
		request_url = baseURL + "/training/auto_batch_name/" + process_id; 
		datas = { 'process_id' : process_id,'office_id' :office_id };
		process_ajax(function(response)
		{
			// alert(response);
			$("#batch_name").val(response);
			$("#batch_name").prop('readOnly', true);
			//console.log(response);
		},request_url, datas, 'text');

	}
	else{
		$("#batch_name").val("");
		$("#batch_name").prop('readOnly', false);
		

	}



	});

	// $("#b_office_id").change(function(){
	// 	var office_id=$(this).val();
	// 	var process_id=$("#b_process_id").val();
	// 	var training_type=$("#training_type").val();
	// 	// alert(training_type);
	// 	if(training_type=='2') {
	// 	baseURL = "<?php echo base_url(); ?>";
	// 	request_url = baseURL + "/training/auto_batch_name/" + process_id; 
	// 	datas = { 'process_id' : process_id,'office_id' :office_id };
	// 	process_ajax(function(response)
	// 	{
	// 		// alert(response);
	// 		$("#batch_name").val(response);
	// 		$("#batch_name").prop('readOnly', true);

	// 		//console.log(response);
	// 	},request_url, datas, 'text');

	// }
	// else{
	// 	$("#batch_name").val("");
	// 	$("#batch_name").prop('readOnly', false);
	// }

	// });
	
	
	$("#search_training_batch #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/crt_batch?office_id='+office_id;
		window.location = rURL;
		
	});
	
	$("#search_training_rag #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/rag?office_id='+office_id;
		window.location = rURL;
		
	});
	
	
	$("#search_training_cert #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/certificate?office_id='+office_id;
		window.location = rURL;
		
	});
	
	$("#search_assmnt_batch #office_id").change(function(){
		var office_id=$(this).val();
		var batch_type = $('#as_batch_type').val();
		var rURL=baseURL+'training/assmnt_batch?office_id='+office_id;
		if(batch_type == 3){ rURL=baseURL+'training/assmnt_batch/nesting?office_id='+office_id; }
		if(batch_type == 4){ rURL=baseURL+'training/assmnt_batch/recursive?office_id='+office_id; }
		if(batch_type == 5){ rURL=baseURL+'training/assmnt_batch/upskill?office_id='+office_id; }
		window.location = rURL;
		
	});
	
	
	$("#search_prod_assmnt #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/production?office_id='+office_id;
		window.location = rURL;
		
	});
	
	
	$("#search_nesting_office #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/nesting?office_id='+office_id;
		window.location = rURL;
		
	});
	
	$("#search_nesting_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/nesting_performance?office_id='+office_id;
		window.location = rURL;
		
	});
	
	$("#search_nesting_summary #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/nesting_summary?office_id='+office_id;
		window.location = rURL;
		
	});
	
	$("#search_audit_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/audit_performance?office_id='+office_id;
		window.location = rURL;
		
	});
	
	$("#search_audit_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/audit_performance?office_id='+office_id;
		window.location = rURL;
		
	});
	
	$("#search_tni_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/refresher_tni_summary?office_id='+office_id;
		window.location = rURL;
		
	});
	
	$("#search_bqm_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/refresher_bqm_summary?office_id='+office_id;
		window.location = rURL;
		
	});
	
	$("#search_soft_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/refresher_soft_summary?office_id='+office_id;
		window.location = rURL;
	});
	
	$("#search_recursive_summary #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/recursive_summary?office_id='+office_id;
		window.location = rURL;
	});
	
	$("#search_recursive_batch #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/recursive_batch?office_id='+office_id;
		window.location = rURL;
	});
	
	$("#search_recursive_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/recursive_performance?office_id='+office_id;
		window.location = rURL;
	});
	
	$("#search_upskill_batch #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/upskill_batch?office_id='+office_id;
		window.location = rURL;
	});
	
	$("#search_upskill_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/upskill_performance?office_id='+office_id;
		window.location = rURL;
	});
	
	$("#search_nesting_rag_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/nesting_rag?office_id='+office_id;
		window.location = rURL;
	});

	$("#search_recursive_rag_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/recursive_rag?office_id='+office_id;
		window.location = rURL;
	});
	
	$("#search_upskill_rag_upload #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/upskill_rag?office_id='+office_id;
		window.location = rURL;
	});
	
	
	$("#search_recursive_incub #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/recursive_incubation?office_id='+office_id;
		window.location = rURL;
	});
	
	$("#search_upskill_incub #office_id").change(function(){
		var office_id=$(this).val();
		var rURL=baseURL+'training/upskill_incubation?office_id='+office_id;
		window.location = rURL;
	});
	
	
	$("#client_id").change(function(){
			var client_id=$(this).val();
			populate_process_combo(client_id,'','process_id','N');
		});
		
		
	$("#location_id, #client_id , #process_id").change(function(){
		
		var location_id =  $('#location_id option:selected').text();
		var client_name =  $('#client_id option:selected').text();
		var process_name =  $('#process_id option:selected').text();			
		var title = location_id + "-" + client_name+ "-"+process_name;
		$('#asmnt_name').val(title);
		
	});
	
	
	
	$(".showAllCandidate").click(function(){
		
		var batch_id=$(this).attr("batch_id");
		var asmnt_id = $(this).attr("asmnt_id");
		
		$('#modelShowAllCandidate').modal('show');
		$('#showAllCandidateList').html("");
		
		var rURL=baseURL+'training/showAssmntCandList';
		
		$('#sktPleaseWait').modal('show');
		//alert(rURL + "?batch_id="+batch_id);
		
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   data:'batch_id='+batch_id+"&asmnt_id="+asmnt_id,
		   success: function(response){
								
				//alert(response);
				var json_obj = JSON.parse(response);
				
				var html = '';
				
				for (var i in json_obj){
					
					html += '<tr> <td>'+json_obj[i].fusion_id+'</td> <td>'+json_obj[i].fname + " " + json_obj[i].lname +'</td> <td>'+json_obj[i].role_name+'</td> <td>'+ ((json_obj[i].score==null) ? "Pending" : json_obj[i].score) +'&nbsp;</td>  </tr>';
					
					
					
				}
				$('#showAllCandidateList').html(html);
							
				$('#sktPleaseWait').modal('hide');
				
								
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
		
		
		
	});
	
	
	
	
	$(".btnCreateAssmnt").click(function(){
		var batch_id=$(this).attr("batch_id");
		$('#trn_batch_id').val(batch_id);
		$('#modelCreateAssmnt').modal('show');
	});
	
	
	$("#btnSaveCreateAssmnt").click(function(){
		
		var trn_batch_id = $('#trn_batch_id').val().trim();
		var asmnt_name=$('#asmnt_name').val().trim();
		var asmnt_date=$('#asmnt_date').val().trim();
		var assmnt_type=$('#assmnt_type').val().trim();
		var isRun = true;		
		
		//alert(baseURL+'training/createAssmnt?'+$('form.frmCreateAssmnt').serialize());
		
		if(trn_batch_id=="" || asmnt_name == "" || asmnt_date =="" || assmnt_type ==""){
			isRun = false;
			alert("One or more field(s) are blank. \r\nPlease fill the data");
		}
				
		if (isRun == true){
			
			var isCon=confirm('Are you sure to add the Assessment?');
			if(isCon==true){
				
				
				$('#modelCreateAssmnt').modal('hide');
				$('#sktPleaseWait').modal('show');
								
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'training/createAssmnt',
				   data:$('form.frmCreateAssmnt').serialize(),
				   success: function(msg){
							//alert(msg);
							$('#sktPleaseWait').modal('hide');
							location.reload();
					}
					,
					error: function(){
						//alert('Fail!');
					}
					
				  });
			}	  
		}
		
	});
	
	
	
	
	 $(document).on('click','.editDisposition',function(){
		var uid=$(this).attr("uid");
		$('#uid').val(uid);
		$('#sktModalDisp').modal('show');
		  
	});
	
	$("#updateDisp").click(function(){
		
		var uid = $('#uid').val().trim();
		var disp_id=$('#event_master_id').val().trim();
		var start_date=$('#start_date').val().trim();
		var remarks=$('#remarks').val().trim();
		
		var isRun = true;
		
		//alert(baseURL+'users/updateDisposition?'+$('form.editDisp').serialize());
							
		if(disp_id=='1'){
			isRun = false;
			alert("Please select proper disposition");		
		}
			
		if(uid=="" || start_date == "" || remarks ==""){
			isRun = false;
			alert("One or more field(s) are blank. \r\nPlease fill the data");
		}
		
		
		if (isRun == true){
			
			var isCon=confirm('Are you sure to update the status?');
			if(isCon==true){
				
				
				$('#sktModalDisp').modal('hide');
				$('#sktPleaseWait').modal('show');
				
				
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'users/updateDisposition',
				   data:$('form.editDisp').serialize(),
				   success: function(msg){
							
							//alert(msg);
							
							$('#sktPleaseWait').modal('hide');
							if(msg=="PRETREM") alert("User is in termination queue.");
							
							location.reload();
					}
					,
					error: function(){
						//alert('Fail!');
					}
					
				  });
	
			}
	  
		}
			
			
	});
	
	function date_diff_termination(lwd,st_date)
	{
		const date_lwd = $.datepicker.formatDate( "m/d/yy",new Date(lwd));
		const date_st = $.datepicker.formatDate( "m/d/yy",new Date(st_date));
		const present_date = $.datepicker.formatDate( "m/d/yy",new Date());

		// const date1 = new Date(date_lwd);
		// const date2 = new Date(date_st);
		// const present = new Date(present_date);

		// const diffTime_date1 = Math.abs(present - date1);
		// const diffTime_date2 = Math.abs(present - date2);

		// const diffDays_date1 = Math.ceil(diffTime_date1 / (1000 * 60 * 60 * 24)); 
		// const diffDays_date2 = Math.ceil(diffTime_date2 / (1000 * 60 * 60 * 24)); 

		const date1 = new Date(date_lwd);
		const date2 = new Date(date_st);

		const diffTime_date = date1 - date2;

		const diffDays_date = Math.ceil(diffTime_date / (1000 * 60 * 60 * 24)); 		
		
		const termination_deff = diffDays_date+1;

		//alert(date2);
		return termination_deff;
	}

	$(document).on('change','#lwd_oth',function(){

		var st_date=$('#batch_start_date_term').val();
		var lwd=$('#lwd_oth').val();

		var result = date_diff_termination(lwd,st_date);

		// var _date_1 = new Date(lwd);
		// var _date_2 = new Date(st_date);

		// var _diffTime_date = _date_1 - _date_2;
		// var _diffTime_date = Math.ceil(_diffTime_date / (1000 * 60 * 60 * 24));

		if(result < 0){
			// alert('Last working date can not be less than Training Start Date');
			result = 0;
			// $('#lwd_oth').val('');
		}
		$('#trn_day_term_oth').val(result);

    	var uid = $('.frmTermsUserOth #tuid_oth').val();
    	var datas = {'ldate': lwd, 'uid': uid};
    	var request_url = "<?=base_url()?>users/last_working_date_check";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if (res.stat == true) {
				$('.frmTermsUserOth #terminateUserOth').prop("disabled",false);
			}
			else {
				$('.frmTermsUserOth #terminateUserOth').prop("disabled",true);
				alert('Last working date can not be less than DOJ');
				$('#lwd_oth').val('');
			}
		},request_url, datas, 'text');

	})	
	
	$(document).on('click','.termsUserOth',function(){		
			
		var uid=$(this).attr("uid");
		var bid=$(this).attr("bid");
		var st_date=$(this).attr("start_date");
		var doj =$(this).attr('doj');
		//alert(st_date+'*****'+doj);
		
				
		var rURL=baseURL+'users/getLastLoginInfo';
		
		$('#sktPleaseWait').modal('show');
		
		//alert(rURL + "?"+uid);
				
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   data:'uid='+uid,
		   success: function(lwd){
			   
				//alert(lwd);
			   
				lwd=lwd.trim();
				//alert(lwd);
				if( (new Date(lwd).getTime() < new Date(doj).getTime()))
				{
					$('.frmTermsUserOth #terminateUserOth').prop("disabled",true);
					setTimeout(function () {
						alert('Last working date can not be less than DOJ');
                 }, 1500);
					
				}

				var trn_day_term = date_diff_termination(lwd,st_date);

				if(trn_day_term < 0){
					trn_day_term = 0;
				}
				
				$('#trn_day_term_oth').val(trn_day_term);
				$('#lwd_oth').val(lwd);
				$('#tuid_oth').val(uid);
				$('#tbid').val(bid);
				$('#batch_start_date_term').val(st_date);
				
				$('#sktPleaseWait').modal('hide');
				$('#termsModalOth').modal('show');
				
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  		
	});

	$("#terminateUserOth").click(function(){
		
		//alert(baseURL+'users/updateDisposition?'+$('form.frmTermsUserOth').serialize());
		
		var tuid=$('#tuid_oth').val();
		var lwd_oth=$('#lwd_oth').val();
		var tbid=$('#tbid').val();
		var tattrition=$('#term_trn_attrition').val();
		var terms_date=$('#terms_date_oth').val();
		var remarks=$('#remarks_oth').val();
		var t_type=$('#t_type_oth').val().trim();
		var sub_t_type=$('#sub_t_type_oth').val().trim();

		var trn_day_term_oth=$('#trn_day_term_oth').val();
		var term_type_new=$('#term_type_new').val();
		
		if(lwd_oth!="" && tuid!="" && terms_date!="" && t_type!="" && sub_t_type!="" && tattrition != "" &&(remarks!="" || resign_remarks!="")){
			
			var ans=confirm('Are you sure to terminate this user?');
			if(ans==true){
			
				$('#termsModalOth').modal('hide');
				//$('#sktPleaseWait').modal('show');
				
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'users/updateDisposition',
				   data:$('form.frmTermsUserOth').serialize(),
				   success: function(msg){
						//alert(msg);							
						if(msg=="PRETREM") alert("User is in termination queue.");	
						if(tbid != "" && tattrition != ""){
							$.ajax({
							type: 'POST',    
							url:baseURL+'training/updateAttritionTerm',
							data: { bid : tbid, uid : tuid, trnattrition : tattrition, t_type : t_type, trn_term_day : trn_day_term_oth, term_type_new : term_type_new, terms_date : terms_date, lwd_oth : lwd_oth },
							success: function(msg){
								$('#sktPleaseWait').modal('hide');
									console.log(tbid + ' - User ' + tuid +' Moved to Attrition : ' + tattrition);
									location.reload();
								}
							});
						}						
									
					}
				  });
				
			  }
			}else{
				alert("One or more field(s) are blank. \r\nPlease fill the data");
			}
	});
	
	
		$("#resign_comment").hide();
	
		$("#t_type_oth").change(function(){
			var t_type=$(this).val();
			if(t_type==9){
				$("#term_comment").hide();
				$("#resign_comment").show();
				
				
				$("#remarks_oth").prop("disabled", true);
				$("#resign_remarks").attr("required", true);
				$("#resign_remarks").prop("disabled", false);
			}else{
				$("#term_comment").show();
				$("#resign_comment").hide();
				
				$("#remarks_oth").prop("disabled", false);
				$("#resign_remarks").removeAttr("required", false);
				$("#resign_remarks").prop("disabled", true);
			}
		});
		
	///////////////////////////////
	
	
	
	///////////////////////////////
	
	$('#modelRAGResultUpload').on('hidden.bs.modal', function () {
		location.reload();
	})
		
	$("#modelRAGResultUpload").on("shown.bs.modal", function () {
	
		var uUrl=baseURL+'training/uploadRagResult';
				
		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "sktfile",
			allowedTypes:"xls,xlsx",	
			returnType:"json",
			maxFileSize: 7397376,
			dynamicFormData:function()
			{
			   var batch_id=$('#ragbatch_id').val();
			   return {
					'batch_id' : batch_id,
				}
			},
			onSelect:function(files)
			{
				
			},
			onSuccess:function(files,data,xhr)
			{
			
		     //alert(data);
								
			$("#currAttachDiv").show();
						
			if(data[0]=="done"){
				location.reload();
			}
			
			//alert("Successfully uploaded and import to database.");
						   
			},
			onError:function (files, status, message)
			{
			   
			   //$("#OutputDiv").html(message);
			   alert(message);
			   
			},
			showDelete:false
		}
				
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
	
	});
				
	$(".btnRagUpload").click(function(){
		
		var batch_id=$(this).attr("batch_id");
		$('#ragbatch_id').val(batch_id);
		$("#downloadheader1").hide();
		var ragurl = baseURL+'training/batch_rag_design?batchid=' +batch_id;
		$.ajax({
		   type: 'GET',    
		   url:baseURL+'training/getFormatDesignIDRag',
		   data:'batchid=' + batch_id,
		   success: function(msg){
			 if(msg != 0)
			 {
				var uUrl=baseURL+'training/downloadTrainingRAGHeader' + '?pmdid=' + msg;
				$("#downloadheader1").attr("href", uUrl);
				$("#downloadheader1").show();
			 } else {
				$("#downloadheader1").hide();
				$('#uploadingdivattach').html("<b>No Format Found - </b> <a href='"+ragurl+"' class='btn btn-primary btn-sm' style='padding:2px 5px'>Create Rag Design</a>");
			 }
			}
		  });
				  
		
		$('#modelRAGResultUpload').modal('show');
		
	});
	
	
	
	
	
	
	
	////////////////////////////////////////////////////
	/// Certificate Result Add
	
	$('#modelCertificateResultUpload').on('hidden.bs.modal', function () {
		location.reload();
	});
		
	$("#modelCertificateResultUpload").on("shown.bs.modal", function () {
	
		var uUrl = baseURL+'training/uploadCertificateResult';
		
		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "sktfile",
			allowedTypes:"xls,xlsx",	
			returnType:"json",
			maxFileSize: 7397376,
			dynamicFormData:function()
			{
			   var batch_id=$('#certificatebatch_id').val();
			   recertify = '0';
			   var recertification = $('#recertification').is(':checked');
			   if(recertification == true){ recertify = '1'; }
			   return {
					'batch_id' : batch_id,
					'recertification' : recertify
				}
			},
			onSelect:function(files)
			{
				
			},
			onSuccess:function(files,data,xhr)
			{
			console.log(data[0]);
		    //alert(data);
							
			$("#currAttachDiv").show();
						
			if(data[0]=="done"){
				location.reload();
			}
			
			//alert("Successfully uploaded and import to database.");
						   
			},
			onError:function (files, status, message)
			{
			   //$("#OutputDiv").html(message);
			   alert(message);
			   
			},
			showDelete:false
		}
				
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
	
	});
				
	$(".btnCertificateUpload").click(function(){
		
		var batch_id=$(this).attr("batch_id");
		$('#certificatebatch_id').val(batch_id);
		$("#downloadheader1").hide();
		var certificateurl = baseURL+'training/cert_design?batchid=' + batch_id;
		$.ajax({
		   type: 'GET',    
		   url:baseURL+'training/getFormatDesignCertificateRag',
		   data:'batchid=' + batch_id,
		   success: function(msg){
			 if(msg != 0)
			 {
				var uUrl=baseURL+'training/downloadTrainingCertificateHeader' + '?pmdid=' + msg;
				$("#downloadheader1").attr("href", uUrl);
				$("#downloadheader1").show();
			 } else {
				$("#downloadheader1").hide();
				$('#uploadingdivattach').html("<b>No Format Found - </b> <a href='"+certificateurl+"' class='btn btn-primary btn-sm' style='padding:2px 5px'>Create Certificate Design</a>");
			 }
			}
		  });
				  
		
		$('#modelCertificateResultUpload').modal('show');
		
	});
	
	
	
	///////////////////////////////
	
	$('#modelAssmntResultUpload').on('hidden.bs.modal', function () {
		location.reload();
	})
		
	$("#modelAssmntResultUpload").on("shown.bs.modal", function () {
	
		var uUrl=baseURL+'training/uploadAssmntResult';

		var settings = {
			url: uUrl,
			dragDrop:true,
			fileName: "asktfile",
			allowedTypes:"xls,xlsx",	
			returnType:"json",
			maxFileSize: 7397376,
			dynamicFormData:function()
			{
			   var batch_id=$('#arubatch_id').val();
			   var asmnt_id=$('#aruassmnt_id').val();
			   
			   return {
					'batch_id' : batch_id,
					'asmnt_id' : asmnt_id,
				}
			},
			onSelect:function(files)
			{
				
			},
			onSuccess:function(files,data,xhr)
			{
	        
			//alert("check it");
			//alert(data);
			
			$("#currAttachDiv").show();
			if(data[0]=="done"){
				location.reload();
			}
			if(data[0]=="error"){
				alert("Something went wrong! Please check your file!");
			}
			   
			},
			onError:function (files, status, message)
			{
			   
			   //$("#OutputDiv").html(message);
			   alert(message);
			   
			},
			showDelete:false
		}
				
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
	
	});
		
			
	$(".btnAssmntResultUpload").click(function(){
		
		var batch_id=$(this).attr("batch_id");
		var asmnt_id = $(this).attr("asmnt_id");
		$('#arubatch_id').val(batch_id);
		$('#aruassmnt_id').val(asmnt_id);
		var uUrl=baseURL+'training/downloadOfflineResultHeader' + '?bid=' + batch_id + '&aid=' + asmnt_id;
		$("#downloadheaderOffline").attr("href", uUrl);		
		$('#modelAssmntResultUpload').modal('show');
		
	});
	
	
	
	/*---------------------------*/
	
	
	$(".btnScheduleAssmnt").click(function(){
		var loc_id=$(this).attr("loc_id");
		var batch_id=$(this).attr("batch_id");
		var asmnt_id = $(this).attr("asmnt_id");
		$('#sabatch_id').val(batch_id);
		$('#saassmnt_id').val(asmnt_id);
		
		$('#modalScheduleAssmnt').modal('show');
		$('#scheduleAssmntListContainer').html("");
		
		var rURL=baseURL+'training/fetchActiveAgent';
		
		$('#sktPleaseWait').modal('show');
		//alert(rURL + "?batch_id="+batch_id);
		
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   data:'batch_id='+batch_id+"&asmnt_id="+asmnt_id+"&loc_id="+loc_id,
		   success: function(response){
				
				//alert(response);
				var json_obj = JSON.parse(response);
				
				var html = '';
				
				for (var i in json_obj){
					
					html += '<tr><td><input type="checkbox" name="agentCheckBox[]" value="'+json_obj[i].user_id+'"></td><td>'+json_obj[i].fname + " " + json_obj[i].lname +'</td> <td>'+json_obj[i].fusion_id+'</td> <td>'+json_obj[i].role_name + " ("+ json_obj[i].dept_name + ")"+'</td> </tr>';
					
				}
				$('#scheduleAssmntListContainer').html(html);
							
				$('#sktPleaseWait').modal('hide');
								
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
	});
	
	
	$('#exam_id').change(function(){
		var totSet = $('option:selected', this).attr('totSet');
		var totQues = $('option:selected', this).attr('totQues');
		
		if(totSet==0 || totQues==0 ){
				alert("Please upload the questions in Exam ");
				$('#exam_id').val("");
		}else{
			$('#no_of_question').val(totQues);
			$('#no_of_question').prop('max',totQues);
		}			
	});
		
	
	
	$(document).on('click',".btnStartExam",function(e){
		
		var batch_id=$(this).attr("batch_id");
		var asmnt_id = $(this).attr("asmnt_id");
		
		$('#frmStartExam #batch_id').val(batch_id);
		$('#frmStartExam #assmnt_id').val(asmnt_id);
		
		$('#modelStartExam').modal('show');

		var rURL = "<?php echo base_url('training/fetchScheduleTimes'); ?>";
		//alert(rURL);
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   data:'batch_id='+batch_id+"&asmnt_id="+asmnt_id,
		   success: function(response){
				
				//alert(response);
				var json_obj = JSON.parse(response);
				
				var options = '<option value="">--Select a Start Time--</option>';
				
				for (var i in json_obj){		
					options += '<option value="'+json_obj[i].exam_start_time+'">'+json_obj[i].exam_start_time+'</option>';	
				}
				
				$('#scheduledExamTime').html(options);
				
				$('#sktPleaseWait').modal('hide');
								
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
	});
	
	$(document).on('change',"#scheduledExamTime",function(e){
		
		var scheduled_exam_time = $(this).val();
		var batch_id =  $('#frmStartExam #batch_id').val();
		var assmnt_id =  $('#frmStartExam #assmnt_id').val();
		var datas = {'scheduled_exam_time':scheduled_exam_time,'batch_id':batch_id,'assmnt_id':assmnt_id};
		var request_url = "<?php echo base_url('training/getScheduledCandidates'); ?>";
		
		$('#startExamAgentListContainer').html("");
		
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var tr = '';
				$.each(res.datas,function(index,element)
				{
					tr += '<tr><td><input type="checkbox" name="agentCheckBox[]" value="'+element.user_id+'"></td><td>'+element.candidate_name+'</td><td>'+element.fusion_id+'</td><td>'+element.role_name+'</td></tr>';
				});
				$('#startExamAgentListContainer').html(tr);
			}
			else
			{
				tr = '<tr><td colspan="3" class="text-center">No Candidate Found</td></tr>';
				$('#startExamAgentListContainer').html(tr);
			}
		},request_url, datas, 'text');
	});
			
	$(document).on('click','.selectAllCheckBox',function()
		{
		if($(this).is(':checked'))
		{
			$('[name="agentCheckBox[]"]').prop('checked',true);
		}
		else
		{
			$('[name="agentCheckBox[]"]').prop('checked',false);
		}
	});
	
/////////////////////////////Training Handover///////////////////////////
	$("#trn_handover_l1super").select2();
	$("#trn_handover_l1super_tr").select2();

	$(".btnHandOver").click(function(){
		var batch_id=$(this).attr("batch_id");
		$('#frmTrainingHandover #batch_id_trn').val(batch_id);
		$('#modelTrainingHandover').modal('show');
	});
	
	$(".btnHandOverTraining").click(function(){
		var batch_id=$(this).attr("batch_id");
		$('#frmTrainingHandoverTr #batch_id_trn_tr').val(batch_id);
		$('#modelTrainingHandoverTr').modal('show');
	});
	
	$(".btnNotHandOver").click(function(){
		$('#modelTrainingNotHandover').modal('show');
	});

	// $(".btnHandOver").click(function(){
	// 	var batch_id=$(this).attr("batch_id");
	// 	$('#frmTrainingHandover #batch_id_trn').val(batch_id);
	// 	$('#modelTrainingHandover').modal('show');
	// });
	

	// TRAINING USERS CERTIFY
	$(".FullbtnHandOver").click(function(){
		
		baseURL = "<?php echo base_url(); ?>";
		var clientid  = $(this).attr("clientid");
		var processid = $(this).attr("processid");
		var batch_id  = $(this).attr("batch_id");
		var batchname  = $(this).attr("bname");
		//alert(batch_id);die;
		$('#modalFullbtnHandOver #batch_id').val(batch_id);
		$('#modalFullbtnHandOver #certify_batch_id').val(batch_id);
		
		$('#certify_batch_name').val(batchname);
		$('#frmTrainingHandover #batch_id_trn').val(batch_id);
		$('#modalFullbtnHandOver').modal('show');
		
		var rURL=baseURL+'training/fetchBatchUsers_handover';
		var bURL=baseURL+'training/fetchBatchlist';
		var batchidURL=baseURL+'training/batchl1supervisor'; 
	
		$('#sktPleaseWait').modal('show');
		$('#movehandoverListContainer').html('');

		// $.ajax({
		//    type: 'POST',    
		//    url:batchidURL,

		//    data:'batchid_trainner='+batch_id,
		//    success: function(response){
		// 	var json_obj = JSON.parse(response);

		// 	console.log(response);
		// 	if(json_obj!='0')
		// 	{
		// 		$('#modalFullbtnHandOver #trn_handover_l1super_tr').val(json_obj.id);
		// 		$('#modalFullbtnHandOver #trn_handover_l1super_tr option').each(function() {
		// 				!this.selected ? $(this).attr('disabled', true) : "";
		// 				});
		// 	}
		// 	else
		// 	{
		// 		$('#modalFullbtnHandOver #trn_handover_l1super_tr').val('');
		// 		$('#modalFullbtnHandOver #trn_handover_l1super_tr option').each(function() {
		// 				 $(this).attr('disabled', false) ;
		// 				});
						
		// 	}
				
			
			
		//    }
		// });
		
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   data:'batchid='+batch_id,
		   success: function(response){

			
				var json_obj = JSON.parse(response);
				
				var html = '';  
				for (var i in json_obj){
					var term_st = json_obj[i].status=='0'?'Term':(json_obj[i].status=='2'?'Pre-Term':'MIA');
					var term_disabe = json_obj[i].status=='0'?'disabled':(json_obj[i].status=='2'?'':'MIA');
					html += '<tr><td><input type="checkbox" name="userCertifyCheckBox[]" value="'+json_obj[i].user_id+'" '+term_disabe+'></td><td>'+json_obj[i].fname + " " + json_obj[i].lname +'</td> <td>'+json_obj[i].fusion_id+'</td> <td>'+term_st+'</td></tr>';
				}
				
				$('#movehandoverListContainer').html(html);
				$('#sktPleaseWait').modal('hide');
				if(json_obj=='')
				{
					$("#batch_value").css("display", "none");
				}
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
		  
	});







/////////////////////////////////
});
///////////////////////////////


$(function() {

	var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
        maxDate   : new Date()
    }
	
	$("#lwd_oth").datepicker($.extend({},datepickersOpt));
	
	$("#start_date").datepicker({
			dateFormat: "mm/dd/yy",
			maxDate   : new Date()
	}).datepicker( "setDate", "<?php echo CurrDateMDY();?>" );
		
	$("#exam_start_time").datetimepicker({
			dateFormat: "mm/dd/yy",
			timeFormat: "HH:mm",
			minDate   : '-1D'
	}).datetimepicker( "setDate", "<?php echo CurrDateTimeMDY();?>" );
		
});


///////////////////////////////////////////////////
  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
	 locale: {
        "format": "DD/MM/YYYY",
        "separator": " - "
      }
  }, function(start, end, label) {
      //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });




	// OPEN VIEW MODAL
	$(".viewmodalclick").click(function(){
	
		var clickid = $(this).attr("sourceid");
		var myarr = clickid.split("#");
		var baseURL="<?php echo base_url();?>";
		var urlformed = baseURL + 'training/view_result_modal/' + myarr[0] + '/' + myarr[1] + '/' + myarr[2];
		$('#modaldocview').modal('show');
		$('.docbodymodal').html('');
		//alert(params);
		$.ajax({
		   type: 'GET',    
		   url: urlformed,
		   data:'kid=1',
		   success: function(data){
				$('.docbodymodal').html(data);
			},
			error: function(){
				alert('Fail!');
			}
		});
		
	});
	
	
 
	
	// DISPLAY TABLE USER
	function displaytableuser(a,fid)
	{
		$(a).parent().parent().parent().find('[id="'+fid+'"]').show();
		$(a).parent().parent().find('#nominus').show();
		$(a).parent().parent().find('#noplus').hide();
		$(a).parent().parent().css("background-color", "#D4E1F7");
	}
	function hidetableuser(a,fid)
	{
		$(a).parent().parent().parent().find('[id="'+fid+'"]').hide();
		$(a).parent().parent().find('#nominus').hide();
		$(a).parent().parent().find('#noplus').show();
		$(a).parent().parent().css("background-color", "#EDF0F5");
	}
	
	// RAG BATCH DETAILS
	function getassigned_batch_details(bid)
	{
		baseURL = "<?php echo base_url(); ?>";
		request_url = baseURL + "/training/crt_batch_details/" + bid;
		datas = { 'batchid' : bid };
		process_ajax(function(response)
		{
			$('#'+bid).html(response);
			//console.log(response);
		},request_url, datas, 'text');
	}
	
	function batchdetailsclick(a)
	{
	  var batchid = $(a).attr('batchid');
	  $('#'+batchid).toggleClass('in');
	  if($('#'+batchid).hasClass('in'))
	  {
		getassigned_batch_details(batchid);
	  }
	}
	// goutam added here
	function userdetailsclick(a)
	{
	
	  var userid = $(a).attr('userid');
	  var training_start_date=$(a).attr('training_start_date');
	  var handover_date=$(a).attr('handover_date');	  
	//   alert(userid);
	  $('#'+userid).toggleClass('in');
	  if($('#'+userid).hasClass('in'))
	  {
		// alert(2);
		getattendance_details(userid,training_start_date,handover_date);
	  }
	}
	function usercandidatesclick(a)
	{
	
	  var batch_id = $(a).attr('batch_id');
	//   var training_start_date=$(a).attr('training_start_date');
	//   var handover_date=$(a).attr('handover_date');
	  
	  $('#'+batch_id).toggleClass('in');
	  if($('#'+batch_id).hasClass('in'))
	  {
		getcandidate_details(batch_id);
	  }
	}
	function usercandidatesclickrta(a)
	{
	
	  var batch_id = $(a).attr('batch_id');
	//   var training_start_date=$(a).attr('training_start_date');
	//   var handover_date=$(a).attr('handover_date');
	  
	  $('#'+batch_id).toggleClass('in');
	  if($('#'+batch_id).hasClass('in'))
	  {
		getcandidate_details_by_rta(batch_id);
	  }
	}
	function getattendance_details(uid,training_start_date,handover_date)
	{
		//  alert(uid);
		//  alert(training_start_date);
		//  alert(handover_date);
		baseURL = "<?php echo base_url(); ?>";
		request_url = baseURL + "/training/attendance_details/" + uid;
		datas = { 'userid' : uid,'training_start_date' :training_start_date,handover_date:handover_date };
		process_ajax(function(response)
		{
			 $('#'+uid).html(response);
			console.log(response);
		},request_url, datas, 'text');
	}
	function getcandidate_details(batch_id)
	{
		var url = $(location).attr('href').split("/").splice(5, 5).join("/");
		baseURL = "<?php echo base_url(); ?>";
		request_url = baseURL + "/training/candidate_details_for_batch_wise/" + batch_id;
		datas = { 'batch_id' : batch_id,'url' :url };
		process_ajax(function(response) 
		{
			$('#'+batch_id).html(response);
			//console.log(response);
		},request_url, datas, 'text');
	}
	
	function getcandidate_details_by_rta(batch_id)
	{
		
		var url = $(location).attr('href').split("/").splice(5, 5).join("/");
		// alert(url);	
		baseURL = "<?php echo base_url(); ?>";
		request_url = baseURL + "/training/candidate_details_for_batch_wise_by_rta/" + batch_id;
		datas = { 'batch_id' : batch_id,'url' :url };
		process_ajax(function(response) 
		{
			$('#'+batch_id).html(response);
			//console.log(response);
		},request_url, datas, 'text');
	}
	

	// goutam end here
	
	// ASSESSMENT BATCH DETAILS
	function getassigned_assmnt_batch_details(bid)
	{
		baseURL = "<?php echo base_url(); ?>";
		request_url = baseURL + "/training/assmnt_batch_details/" + bid;
		datas = { 'batchid' : bid };
		process_ajax(function(response)
		{
			$('#'+bid).html(response);
			//console.log(response);
		},request_url, datas, 'text');
	}
	
	function assmnt_batchdetailsclick(a)
	{
	  var batchid = $(a).attr('batchid');
	  $('#'+batchid).toggleClass('in');
	  if($('#'+batchid).hasClass('in'))
	  {
		getassigned_assmnt_batch_details(batchid);
	  }
	}
	
	
	
	
	
	// TRAINING USERS MOVE
	$(".moveclasstrainee").click(function(){
		
		baseURL = "<?php echo base_url(); ?>";
		var clientid  = $(this).attr("clientid");
		var processid = $(this).attr("processid");
		var batch_id  = $(this).attr("batch_id");
		
		$('#initial_batch_id').val(batch_id);
		$('#modalMoveUserBatch').modal('show');
		
		var rURL=baseURL+'training/fetchBatchUsers';
		var bURL=baseURL+'training/fetchBatchlist';
	
		$('#sktPleaseWait').modal('show');
		$('#moveListContainer').html('');
		$.ajax({
		   type: 'POST',    
		   url: bURL,
		   data:'batchid='+batch_id,
		   success: function(response){
				var json_obj1 = JSON.parse(response);
				var html1 = '';
				for (var i in json_obj1){
					batch_get_name = json_obj1[i].batch_name;
					if(!json_obj1[i].batch_name){ batch_get_name = json_obj1[i].job_title+'-'+json_obj1[i].requisition_id; }
					html1 += '<option value="'+json_obj1[i].id+'">'+batch_get_name +' ('+json_obj1[i].shname+' - '+json_obj1[i].name+')'+'</option>';
				}
				$('#move_to_batch_id').html(html1);
				$('#move_to_batch_id').val(batch_id);
			},
			error: function(){	
				alert('Fail!');
			}
		  });
		
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   data:'batchid='+batch_id,
		   success: function(response){
				var json_obj = JSON.parse(response);
				var html = '';
				for (var i in json_obj){
					html += '<tr><td><input type="checkbox" name="userCheckBox[]" value="'+json_obj[i].user_id+'"></td><td>'+json_obj[i].fname + " " + json_obj[i].lname +'</td> <td>'+json_obj[i].fusion_id+'</td> </tr>';
				}
				$('#moveListContainer').html(html);
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
		  
	});
	
	$(document).on('click','.selectAllUserCheckBox',function()
		{
		if($(this).is(':checked'))
		{
			$('[name="userCheckBox[]"]').prop('checked',true);
		}
		else
		{
			$('[name="userCheckBox[]"]').prop('checked',false);
		}
	});
	
	
	$(document).on('click','.selectAllSplitUserCheckBox',function()
		{
		if($(this).is(':checked'))
		{
			$('[name="userSplitCheckBox[]"]').prop('checked',true);
		}
		else
		{
			$('[name="userSplitCheckBox[]"]').prop('checked',false);
		}
	});
	
	
	// TRAINING USERS SPLIT
	$(".splitclassbatch").click(function(){
		
		baseURL = "<?php echo base_url(); ?>";
		var clientid  = $(this).attr("clientid");
		var processid = $(this).attr("processid");
		var batch_id  = $(this).attr("batch_id");
		var batchname  = $(this).attr("bname");
		
		$('#split_initial_batch_id').val(batch_id);
		$('#split_initial_batch_name').val(batchname + '_2');
		$('#modalSplitUserBatch').modal('show');
		
		var rURL=baseURL+'training/fetchBatchUsers';
		var bURL=baseURL+'training/fetchBatchlist';
	
		$('#sktPleaseWait').modal('show');
		$('#moveSplitListContainer').html('');
		
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   data:'batchid='+batch_id,
		   success: function(response){
				var json_obj = JSON.parse(response);
				var html = '';
				for (var i in json_obj){
					html += '<tr><td><input type="checkbox" name="userSplitCheckBox[]" value="'+json_obj[i].user_id+'"></td><td>'+json_obj[i].fname + " " + json_obj[i].lname +'</td> <td>'+json_obj[i].fusion_id+'</td> </tr>';
				}
				$('#moveSplitListContainer').html(html);
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
		  
	});
	
	
	
	// TRAINING USERS CERTIFY
	$(".certifyclassbatch").click(function(){
		
		baseURL = "<?php echo base_url(); ?>";
		var clientid  = $(this).attr("clientid");
		var processid = $(this).attr("processid");
		var batch_id  = $(this).attr("batch_id");
		var batchname  = $(this).attr("bname");
		
		$('#certify_batch_id').val(batch_id);
		$('#certify_batch_name').val(batchname);
		$('#modalCertifyUserBatch').modal('show');
		
		var rURL=baseURL+'training/fetchBatchUsers';
		var bURL=baseURL+'training/fetchBatchlist';
	
		$('#sktPleaseWait').modal('show');
		$('#moveCertifyListContainer').html('');
		
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   data:'batchid='+batch_id+'&status=certify',
		   success: function(response){
				var json_obj = JSON.parse(response);
				var html = '';
				for (var i in json_obj){
					html += '<tr><td><input type="checkbox" name="userCertifyCheckBox[]" value="'+json_obj[i].user_id+'"></td><td>'+json_obj[i].fname + " " + json_obj[i].lname +'</td> <td>'+json_obj[i].fusion_id+'</td> </tr>';
				}
				$('#moveCertifyListContainer').html(html);
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
		  
	});
	
	
	
	// TRAINING USERS SURVEY
	$(".takeSurveyTrigger").click(function(){
		
		baseURL = "<?php echo base_url(); ?>";
		var clientid  = $(this).attr("clientid");
		var processid = $(this).attr("processid");
		var batch_id  = $(this).attr("batch_id");
		var batchname  = $(this).attr("bname");
		var survey_status  = $(this).attr("survey_status");
		
		$('.survey_not,.survey_progress,.survey_complete').addClass('hide'); 
		$('#survey_status').val('1');
		
		if(survey_status == 0){ $('.survey_not').removeClass('hide'); $('#survey_status').val('1'); }
		if(survey_status == 1){ $('.survey_progress').removeClass('hide'); $('#survey_status').val('2'); }
		if(survey_status == 2){ $('.survey_complete').removeClass('hide'); $('#survey_status').val('1'); }
		$('#survey_batch_id').val(batch_id);
		$('#modalTakeSurvey').modal('show');
					  
	});
	
	
	// TRAINING REMOVE BATCH USER
	$(".btnRemoveUserTraining").click(function()
	{		
		baseURL = "<?php echo base_url(); ?>";
		var params  = $(this).attr("r_params");
		var allParams = params.split('{#}');
		var bid  = allParams[0];
		var uid  = allParams[1];
		var trn  = allParams[2];
		$('#frmRemoveBatchUser #rm_batch_id').val(bid);
		$('#frmRemoveBatchUser #rm_user_id').val(uid);
		$('#frmRemoveBatchUser #rm_trn_type').val(trn);
		$('#frmRemoveBatchUser .rm_batch_user_name').html($(this).closest('tr').find('td:eq(2)').html());
		$('#btnRemoveUserTrainingModal').modal('show');
					  
	});
	
	// TRAINING UPSKILL BATCH
	$(".incubBatchTrigger").click(function(){
		
		baseURL = "<?php echo base_url(); ?>";
		var batch_id  = $(this).attr("batch_id");
		var batchname  = $(this).attr("bname");
		$('#frmIncubBatch #incub_batch_id').val(batch_id);
		$('#frmIncubBatch .incubBatchName').html(batchname);
		$('#modalIncubBatch').modal('show');
					  
	});
	
	// TRAINING CLOSE BATCH
	$(".closeBatchTrigger").click(function(){
		
		baseURL = "<?php echo base_url(); ?>";
		var batch_id  = $(this).attr("batch_id");
		var batchname  = $(this).attr("bname");
		$('#frmCloseBatch #close_batch_id').val(batch_id);
		$('#frmCloseBatch .closeBatchName').html(batchname);
		$('#modalCloseBatch').modal('show');
					  
	});
	
	
	// TRAINING INCUBATION BATCH
	$(".moveToIncubationTrigger").click(function(){
		
		baseURL = "<?php echo base_url(); ?>";
		var batch_id  = $(this).attr("batch_id");
		var batchname  = $(this).attr("bname");
		$('#frmIncubBatch #incub_batch_id').val(batch_id);
		$('#frmIncubBatch .incubBatchName').html(batchname);
		$('#modalIncubationTrigger').modal('show');
					  
	});
	
	// TRAINING USERS SPLIT
	$(".newuserbatch").click(function(){
		
		baseURL = "<?php echo base_url(); ?>";
		var clientid  = $(this).attr("clientid");
		var processid = $(this).attr("processid");
		var batch_id  = $(this).attr("batch_id");
		var batchname  = $(this).attr("bname");
		
		$('#add_trainee_batch_id').val(batch_id);
		$('#add_trainee_batch_name').val(batchname);
		$('#modalNewUserBatch').modal('show');
		
		
		var rURL=baseURL+'training/fetchBatchTraineeList';
		//var bURL=baseURL+'training/fetchBatchlist';
	
		$('#sktPleaseWait').modal('show');
		$('#AddNewUserContainer').html('');
		
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   data:'batchid='+batch_id,
		   success: function(response){
				var json_obj = JSON.parse(response);
				var html = '';
				for (var i in json_obj){
					html += '<tr><td><input type="checkbox" name="traineeNewCheckBox[]" value="'+json_obj[i].user_id+'"></td><td>'+json_obj[i].trainee_name +'</td><td>'+json_obj[i].fusion_id+'</td></tr>';
				}
				datatable_refresh('#modalNewUserBatch #default-datatable', 1);
				$('#AddNewUserContainer').html(html);
				datatable_refresh('#modalNewUserBatch #default-datatable');
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
		  
	});
	
	
	function datatable_refresh(id, type="")
	{
		if(type!=''){
		$(id).dataTable().fnClearTable();
		$(id).dataTable().fnDestroy();
		}
		if(type==''){
		$(id).DataTable({
			paginate:false,
			bInfo:false
		});
		}
	}
	// goutam added on 30/08/2022
	$(document).on('click','.check_ticket_approval',function()
	{
		// alert(1111);
	// $('.check_ticket').click(function(){
		var chk=0;
		$(".check_ticket_approval").each(function() {
			if($(this).prop('checked') == true){
				chk=1;
			}
		});
		// alert(chk);
		if(chk==1){
			// $('.div_ticketAssignUpdate').css('display','block');
			$('.check_widget').css('display','block');
			// $('#ticket_user').prop('required',true);
		}else{
			// $('.div_ticketAssignUpdate').css('display','none');
			$('.check_widget').css('display','none');
		}
	});
	$('#approval_work_section').click(function(){
	
	$("#modalapproveworkapproval_by_admin").modal('show'); 

	});
	$('#reject_work_section').click(function(){

	$("#modalrejectworkapproval_by_admin").modal('show'); 

	});

	handover_reject=(val)=>{
		if(val=='accept'){
			type=val;
			remarks = $('#modalworkapproval_by_admin #remarks').val();
		}
		else{
			type=val;
			remarks = $('#modalrejectworkapproval_by_admin #remarks').val();
			

		}
		
		var selected=$("input[name='check_ticket_val[]']:checked").map(function() {
                return this.value;
            }).get().join(',');
			// alert(get_data);
		if (remarks != "") {
			// $('#sktPleaseWait').modal('show');
			$.ajax({
				url: "<?php echo base_url('training/handover_reject_submit_by_operation'); ?>",
				type: "POST",
				data: {
					remarks:remarks,
					reject_id:selected,
					type:type

				},
				dataType: "text",
				success: function(token) {
					if(token==1){
						alert('The data will move to Rta panel for verification');
						location.href = "<?php echo base_url()?>training/selected_candidate";
					}
					else{
						alert('Something went wrong');
					}

				},
				error: function(token) {
					notReply = 1;
					$('#sktPleaseWait').modal('hide');
				}
			});
		} else {
			alert('Please Fill Up reject remarks field!');
		}
	}

	// goutam end here on 30/08/2022


	
	$(".collapse").on('click', ".btnInterviewRemarks", function()
	{
		//alert('hi');
		baseURL = "<?php echo base_url(); ?>";
		var userID  = $(this).attr("uid");
		var batchID = $(this).attr("batch_id");

		var rURL=baseURL+'training_analytics/get_interview_details';

		$('#sktPleaseWait').modal('show');
		$('#modalInterviewRemarks .modal-body').html('');
		
		$.ajax({
		   type: 'GET',    
		   url:rURL,
		   data:'uid='+userID + '&batch=' +batchID,
		   success: function(response){
				$('#modalInterviewRemarks .modal-body').html(response);
				$('#modalInterviewRemarks').modal('show');
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		  });
		  
		  
	});

	$("#training_start").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
	//$("#trainer_id").select2();

	function edit_train_plus_one(a)
	{
		var batchid = $(a).attr('eid');
		var date_ = $(a).attr('date_');
		$('#btch_id_').val(batchid);
		$('#date__').val(date_);
	 	$('#modal_edit_train_plus_one').modal('show');
	}
	
</script>

<script>


handover_reject_rta=(val)=>{
		if(val=='accept'){
			type=val;
			remarks = $('#modalworkapproval_by_admin #remarks').val();
		}
		else{
			type=val;
			remarks = $('#modalrejectworkapproval_by_admin #remarks').val();
			

		}
		
		var selected=$("input[name='check_ticket_val[]']:checked").map(function() {
                return this.value;
            }).get().join(',');
			// alert(get_data);
		if (remarks != "") {
			// $('#sktPleaseWait').modal('show');
			$.ajax({
				url: "<?php echo base_url('training/handover_reject_submit_by_rta'); ?>",
				type: "POST",
				data: {
					remarks:remarks,
					reject_id:selected,
					type:type

				},
				dataType: "text",
				success: function(token) {
					if(token==1){
						alert('The user Rejection declined by RTA team ');
						location.href = "<?php echo base_url()?>training/rejected_candidate_list_for_rta";
					}
					else{
						alert('Something went wrong');
					}

				},
				error: function(token) {
					notReply = 1;
					$('#sktPleaseWait').modal('hide');
				}
			});
		} else {
			alert('Please Fill Up reject remarks field!');
		}
	}

	handover_approve_rta=(val)=>{
		if(val=='approve'){
			type=val;
			remarks = $('#modalapproveworkapproval_by_admin #remarks').val();
		}
		
		var selected=$("input[name='check_ticket_val[]']:checked").map(function() {
                return this.value;
            }).get().join(',');
			// alert(get_data);
		if (remarks != "") {
			// $('#sktPleaseWait').modal('show');
			$.ajax({
				url: "<?php echo base_url('training/handover_approve_submit_by_rta'); ?>",
				type: "POST",
				data: {
					remarks:remarks,
					reject_id:selected,
					type:type

				},
				dataType: "text",
				success: function(token) {
					if(token==1){
						alert('The user Rejection approved by RTA team');
						location.href = "<?php echo base_url()?>training/rejected_candidate_list_for_rta";
					}
					else{
						alert('Something went wrong');
					}

				},
				error: function(token) {
					notReply = 1;
					$('#sktPleaseWait').modal('hide');
				}
			});
		} else {
			alert('Please Fill Up reject remarks field!');
		}
	}
























	$(".selectAllCertifyUserCheckBox").click(function(){
	    $('input:checkbox').not(this).prop('checked', this.checked);
	});

	$(document).on('click','.resetPasswd',function(){
		var uid=$(this).attr("uid").trim();
		var ans=confirm("Are you sure to reset the password?\r\n New password will be 'Fusion ID'");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'users/resetPasswd',
			   data:'uid='+ uid,
			   success: function(msg){
					alert("Password Reset Success");
					//location.reload();
				},
				error: function(){
					alert('Fail!');
				}
			  });
		}
	});
	
	$('#from_date').datepicker({ 
       minDate: "-7d",
       maxDate: "7d",
       dateFormat: "dd-mm-yy"
});


</script>