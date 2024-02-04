<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>



<script type="text/javascript">

$(document).ready(function(){
    
	var baseURL="<?php echo base_url();?>";
		
	$(".editProcess").click(function(){
	
		var params=$(this).attr("params");
		var pid=$(this).attr("pid");
		//alert("pid="+pid + " params:"+params);	
		var arrPrams = params.split("#"); 
		console.log(arrPrams);
		$('#pid').val(pid);
		
		$('#client_id').val(arrPrams[0]);
		$('#name').val(arrPrams[1]);
		$('#duration_training').val(arrPrams[2]);
		$('#duration_nest').val(arrPrams[3]);
		$('#modalEditProcess').modal('show');
		
		
	});
	
	$("#btnEditProcess").click(function(){
	
		var pid=$('#pid').val().trim();
		var client_id=$('#client_id').val().trim();
		var name=$('#name').val().trim();
		var duration_training=$('#duration_training').val().trim();
		var duration_nest=$('#duration_nest').val().trim();
		//alert(baseURL+"master/updateProcess?"+$('form.frmEditProcess').serialize());
		if(pid!="" && client_id!="" && name!="" && duration_training!="" && duration_nest!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   	type: 'POST',    
			   	url:baseURL+'master/updateProcess',
			   	data:$('form.frmEditProcess').serialize(),
			   	success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditProcess').modal('hide');
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
		
	$(".pActDeact").click(function(){
		var pid=$(this).attr("pid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		//alert(baseURL+"master/processActDeact?pid="+pid + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the process?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/processActDeact',
			   data:'pid='+ pid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#btn_add_process").click(function(){
		$('#modalAddProcess').modal('show');
	});
	
	
	$("#btnAddProcess").click(function(){
	
		var client_id=$('#aclient_id').val().trim();
		var name=$('#aname').val().trim();
		var duration_training=$('#aduration_training').val().trim();
		var duration_nest=$('#aduration_nest').val().trim();
		//alert(baseURL+"master/addProcess?"+$('form.frmAddProcess').serialize());		
		if(client_id!="" && name!="" && duration_training!="" && duration_nest!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/addProcess',
			   data:$('form.frmAddProcess').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddProcess').modal('hide');
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
	
	
	////////////////// Sub Process ////////////////////
	
	$(".editSubProcess").click(function(){
	
		
		var spid=$(this).attr("spid");
		var spname=$(this).attr("spname");
		
		$('#spid').val(spid);
		$('#spname').val(spname);
		
		$('#modalEditSubProcess').modal('show');
		
		
	});
	
	$("#btnEditSubProcess").click(function(){
	
		var pid=$('#pid').val().trim();
		var spid=$('#spid').val().trim();
		
		var name=$('#spname').val().trim();
		
		//alert(baseURL+"master/updateSubProcess?"+$('form.frmEditSubProcess').serialize());
		if(pid!="" && spid!="" && name!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/updateSubProcess',
			   data:$('form.frmEditSubProcess').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditSubProcess').modal('hide');
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
		
	$(".spActDeact").click(function(){
		var spid=$(this).attr("spid");
		var sid=$(this).attr("sid");

		var title=$(this).attr("title");
		
		//alert(baseURL+"master/processSubActDeact?spid="+spid + "&sid="+sid);
		
		var ans=confirm('Are you sure to '+title+" the Sub process?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/processSubActDeact',
			   data:'spid='+ spid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#btn_add_sub_process").click(function(){
		$('#modalAddSubProcess').modal('show');
	});
	
	
	$("#btnAddSubProcess").click(function(){
	
		var pid=$('#pid').val().trim();
		
		var name=$('#aspname').val().trim();
		
		//alert(baseURL+"master/addSubProcess?"+$('form.frmAddSubProcess').serialize());
		
		if(pid!="" && name!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/addSubProcess',
			   data:$('form.frmAddSubProcess').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddSubProcess').modal('hide');
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
	
	
	////////////////// disposition ////////////////////
	
	
	$(".editDisposition").click(function(){
	
		var params=$(this).attr("params");
		var did=$(this).attr("did");
		//alert("pid="+pid + " params:"+params);	
		var arrPrams = params.split("#"); 
		$('#did').val(did);
		
		$('#description').val(arrPrams[0]);
		$('#name').val(arrPrams[1]);
		
		$('#modalEditDisposition').modal('show');
		
		
	});
	
	$("#btnEditDisposition").click(function(){
	
		var did=$('#did').val().trim();
		var description=$('#description').val().trim();
		var name=$('#name').val().trim();
		
		
		if(did!="" && description!="" && name!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/updateDisposition',
			   data:$('form.frmEditDisposition').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditDisposition').modal('hide');
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
		
	$(".dActDeact").click(function(){
		var did=$(this).attr("did");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		//alert(baseURL+"master/dispositionActDeact?did="+did + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the disposition?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/dispositionActDeact',
			   data:'did='+ did+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#add_disposition").click(function(){
		$('#modalAddDisposition').modal('show');
	});
		
	$("#btnAddDisposition").click(function(){
	
		var description=$('#adescription').val().trim();
		var name=$('#aname').val().trim();
	

		//alert(baseURL+"master/addDisposition?"+$('form.frmAddDisposition').serialize());	
		
		if(description!="" && name!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/addDisposition',
			   data:$('form.frmAddDisposition').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddDisposition').modal('hide');
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
	



	
	
//////////////////////// Role Master //////////////////////////
	
	
	$(".editRole").click(function(){
	
		var params=$(this).attr("params");
		var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
	
		$('#rid').val(rid);
		
		$('#name').val(arrPrams[0]);
		$('#folder').val(arrPrams[1]);
		$('#role_org_1').val(arrPrams[2]);
		$('#grade_org_1').val(arrPrams[3]);
		
		
		$('#modalEditRole').modal('show');
		
		
	});
	
	$("#btnEditRole").click(function(){
	
		var rid=$('#rid').val().trim();
		var name=$('#name').val().trim();
		var folder=$('#folder').val().trim();
		
		//alert(baseURL+"master/updateRole?"+$('form.frmEditRole').serialize());
		
		if(rid!="" && folder!="" && name!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/updateRole',
			   data:$('form.frmEditRole').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditRole').modal('hide');
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
		
	$(".rActDeact").click(function(){
		var rid=$(this).attr("rid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		//alert(baseURL+"master/roleActDeact?did="+did + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the role?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/roleActDeact',
			   data:'rid='+ rid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#add_role").click(function(){
		$('#modalAddRole').modal('show');
	});
		
	$("#btnAddRole").click(function(){
	
		var name=$('#aname').val().trim();
		var folder=$('#afolder').val().trim();
		
		//alert(baseURL+"master/addRole?"+$('form.frmAddRole').serialize());	
		
		if(folder!="" && name!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/addRole',
			   data:$('form.frmAddRole').serialize(),
			   success: function(msg){

				//console.log(msg);die;
						$('#sktPleaseWait').modal('hide');
						$('#modalAddRole').modal('hide');
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
	
/////////////////////Client//////////////////////
	
	$("#btn_add_process").click(function(){
		$('#modalAddClient').modal('show');
	});
	
	
	$("#btnAddClient").click(function(){
		var shname=$('.frmAddClient #shname').val().trim();
		var fullname=$('.frmAddClient #fullname').val().trim();
		
		if(shname!="" && fullname!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/addClient',
			   data:$('form.frmAddClient').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddClient').modal('hide');
						location.reload();
					}
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});
	
	
	
	$(".editClient").click(function(){
		var params=$(this).attr("params");
		var cid=$(this).attr("cid");	
		var arrPrams = params.split("#"); 
		$('.frmEditClient #cid').val(cid);
		$('.frmEditClient #shname').val(arrPrams[0]);
		$('.frmEditClient #fullname').val(arrPrams[1]);
		$('#modalEditClient').modal('show');
	});
	
	
	$("#btnEditClient").click(function(){
		var cid=$('.frmEditClient #cid').val().trim();
		var shname=$('.frmEditClient #shname').val().trim();
		var fullname=$('.frmEditClient #fullname').val().trim();
		
		if(cid!="" && shname!="" && fullname!=""){
			$('#sktPleaseWait').modal('show');
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/editClient',
			   data:$('form.frmEditClient').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditClient').modal('hide');
						location.reload();
					}
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});
	
	
	$(".clientActDeact").click(function(){
		var cid=$(this).attr("cid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" this client?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/clientActDeact',
			   data:'cid='+ cid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
	

//////////////////////Department//////////////////////////	

	$("#btn_add_department").click(function(){
		$('#modalAddDeparttment').modal('show');
	});
	
	$(".departmentActDeact").click(function(){
		var dept_id=$(this).attr("dept_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Department?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/DepartmentActDeact',
			   data:'dept_id='+ dept_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});
	
	$(".editDepartment").click(function(){
		var params=$(this).attr("params");
		var dept_id=$(this).attr("dept_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditDepartment #dept_id').val(dept_id);
		$('.frmEditDepartment #edshname').val(arrPrams[0]);
		$('.frmEditDepartment #eddescription').val(arrPrams[1]);
		$('.frmEditDepartment #edfolder').val(arrPrams[2]);
		$('#modalEditDepartment').modal('show');
	});
	
//////////////////////Sub Department//////////////////////////	
	$("#btn_add_sub_department").click(function(){
		$('#modalAddSubDeparttment').modal('show');
	});
	
	$(".subDepartmentActDeact").click(function(){
		var sd_id=$(this).attr("sd_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Sub-Department?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/subDepartmentActDeact',
			   data:'sd_id='+ sd_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});
	
	$(".editSubdepartment").click(function(){
		var params=$(this).attr("params");
		var sd_id=$(this).attr("sd_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditSubdepartment #sd_id').val(sd_id);
		$('.frmEditSubdepartment #eddept_id').val(arrPrams[0]);
		$('.frmEditSubdepartment #edname').val(arrPrams[1]);
		$('#modalEditSubdepartment').modal('show');
	});
	
	
/////////////////////////////Site///////////////////////////////

	$("#btn_add_site").click(function(){
		$('#modalAddSite').modal('show');
	});
	
	$(".siteActDeact").click(function(){
		var site_id=$(this).attr("site_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Site?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/siteActDeact',
			   data:'site_id='+ site_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});
	
	$(".editSite").click(function(){
		var params=$(this).attr("params");
		var site_id=$(this).attr("site_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditSite #site_id').val(site_id);
		$('.frmEditSite #edname').val(arrPrams[0]);
		$('.frmEditSite #eddescription').val(arrPrams[1]);
		$('.frmEditSite #edtimezone').val(arrPrams[2]);
		$('#modalEditSite').modal('show');
	});
	
/////////////////
	
//////////////////////Announcement//////////////////////////	
	
	$('#anoffice_id').select2();
	$("#btn_add_announcement").click(function(){
		$('#modalAddAnnouncement').modal('show');
	});
	
	
	$('#description').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link']]
        ],
        height: 200,
        placeholder: 'Details'
    });
	
	$('#eddescription').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link']],
            ['misc', ['codeview']]
        ],
        height: 200
    });
	
	/*
	$(".editAnnouncement").click(function(){
		var params=$(this).attr("params");
		var al_id=$(this).attr("al_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditAnnouncement #al_id').val(al_id);
		//$('.frmEditAnnouncement #eddescription').val(arrPrams[0]);
		//console.log(arrPrams[0].replace(/\\/g, ''));
		$('div').contents().find('.note-editable').html(arrPrams[0].replace(/\\/g, ''));		
		$.each(arrPrams[1].split(","), function(i,e){
			$(".frmEditAnnouncement #aedoffice_id option[value='" + e + "']").prop("selected", true);
		});		
		$('#aedoffice_id').select2();
		$('#modalEditAnnouncement').modal('show');
	});
	*/
	
	$(".editAnnouncement").click(function(){
		var params=$(this).attr("params");
		var al_id=$(this).attr("al_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditAnnouncement #al_id').val(al_id);
		if(al_id!=""){
			$('#eddescription').summernote('code','');
			$.ajax({
			   type: 'GET',    
			   url: baseURL+'master/ajaxAnnouncement',
			   data:'aid='+ al_id,
			   dataType : 'json',
			   success: function(msgData){
				   $('#eddescription').summernote('code',msgData.description);
				}
			});
			
			$.each(arrPrams[0].split(","), function(i,e){
				$(".frmEditAnnouncement #aedoffice_id option[value='" + e + "']").prop("selected", true);
			});
			$('#aedoffice_id').select2();
			$('#modalEditAnnouncement').modal('show');
		}
	});
	
	
	$(".announcementActDeact").click(function(){
		var al_id=$(this).attr("al_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Announcement?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/AnnouncementActDeact',
			   data:'al_id='+ al_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});

///////////////////

//////////////////////Organizational News//////////////////////////	

	$(function(){
	   $("#publish_date").datepicker();
	   $("#closed_date").datepicker();
	   
	   $("#edpublish_date").datepicker();
	   $("#edclosed_date").datepicker();
	});
	

	$("#btn_add_orgNews").click(function(){
		$('#modalAddOrg_news').modal('show');
	});
	
	
	$(".editOrg_news").click(function(){
		var params=$(this).attr("params");
		var on_id=$(this).attr("on_id");	
		var arrPrams = params.split("$#"); 
		console.log(arrPrams);
		$('.frmEditOrg_news #on_id').val(on_id);
		$('.frmEditOrg_news #eddescription').summernote("code", arrPrams[0]);
		$('.frmEditOrg_news #edoffice_id').val(arrPrams[1]);
		$('.frmEditOrg_news #edtitle').val(arrPrams[2]);
		$('.frmEditOrg_news #edpublish_date').val(arrPrams[3]);
		$('.frmEditOrg_news #edclosed_date').val(arrPrams[4]);
		$('#modalEditOrg_news').modal('show');
	});
	
	
	$(".org_newsActDeact").click(function(){
		var on_id=$(this).attr("on_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Organizational News?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/orgNewsActDeact',
			   data:'on_id='+ on_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});

///////////////////
	
/////// OFFICE LOCATION ///////////////////////////////////////////////////////////////////////////////////

	
	$("#btn_add_office").click(function(){
		$('#modalAddOffice').modal('show');
	});
	
	
	$("#btnAddoffice").click(function(){
		
		var abbr_name=$('.frmAddOffice #abbr_name').val().trim();
		var office_name=$('.frmAddOffice #office_name').val().trim();
		var location=$('.frmAddOffice #location').val().trim();
		var prov_period_day=$('.frmAddOffice #prov_period_day').val().trim();		
		var resign_period_day=$('.frmAddOffice #resign_period_day').val().trim();
		
		if(abbr_name!="" && office_name!="" && location!="" && prov_period_day!="" && resign_period_day!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/AddOffice',
			   data:$('form.frmAddOffice').serialize(),
			   success: function(msg){
						if(msg== "Already Exists"){
								alert(msg);
								window.location.reload();
						}else{
								$('#sktPleaseWait').modal('hide');
								$('#modalAddClient').modal('hide');
								window.location.reload();
						}
					}
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});
	
	
	
	$(".editoffice").click(function(){
		var params=$(this).attr("params");
		 
		var arrPrams = params.split("#"); 
		
		$('.frmEditOffice #abbr_name').val(arrPrams[0]);
		$('.frmEditOffice #office_name').val(arrPrams[1]);
		$('.frmEditOffice #location').val(arrPrams[2]);
		$('.frmEditOffice #prov_period_day').val(arrPrams[3]);
		$('.frmEditOffice #resign_period_day').val(arrPrams[4]);
		
		$('#modalEditOffice').modal('show');
	});
	
 
	
	
	
	$("#btnEditOffice").click(function(){
	
		var abbr_name=$('.frmEditOffice #abbr_name').val().trim();
		var office_name=$('.frmEditOffice #office_name').val().trim();
		var location=$('.frmEditOffice #location').val().trim();
		var prov_period_day=$('.frmEditOffice #prov_period_day').val().trim();		
		var resign_period_day=$('.frmEditOffice #resign_period_day').val().trim();
		
		if(abbr_name!="" && office_name!="" && location!="" && prov_period_day!="" && resign_period_day!=""){
			$('#sktPleaseWait').modal('show');
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'master/editOffice',
			   data:$('form.frmEditOffice').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditOffice').modal('hide');
						window.location.reload();
					}
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});
	
	
	$(".oActDeact").click(function(){
		
		
		var pid=$(this).attr("pid");
		var sid=$(this).attr("sid");
	 
		
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" this Office?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/OfficeActDeact',
			   data:'pid='+ pid+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});

//////////////////	

/////////////////////////////////////////////////////////////
////////////// SERVICE REQUEST(24.05.2019) //////////////////
/////////////////////////////////////////////////////////////

/*----------- SR_Category -------------*/
	$("#btn_add_category").click(function(){
		$('#modalAddCategory').modal('show');
	});
		
	function getSelectedOptions(sel) {
			  var opts = [],
			    opt;
			  var len = sel.options.length;
			  for (var i = 0; i < len; i++) {
			    opt = sel.options[i];

			    if (opt.selected) {
			      opts.push(opt);
			    }
			  }

			  return opts;
	}

	$("#location_sr").select2();
	$("#location_sr1").select2();
	
	$(".editCategory").click(function(){
		var params=$(this).attr("params");
		var location=$(this).attr("location");
		console.log(location);
		var c_id=$(this).attr("c_id");	
		var arrPrams = params.split("#"); 
		var arrlocation = location.split(","); 
		$('.frmEditCategory #c_id').val(c_id);
		$('.frmEditCategory #edname').val(arrPrams[0]);
		$('.frmEditCategory #location_sr1').val(arrlocation).select2();
		$('#modalEditCategory').modal('show');
	});
	
	
	$(".categoryActDeact").click(function(){
		var c_id=$(this).attr("c_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Category?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/srCategoryActDeact',
			   data:'c_id='+ c_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});
	
	
	$("#office_id").change(function(){
		var aoffice_id=$(this).val();
		populate_access_control_combo(aoffice_id,'','cat_user_id','N');
	});

	$("#office_id_oth").change(function(){
		var aoffice_id=$(this).val();
		populate_access_control_combo_oth(aoffice_id,'','cat_user_id','N');
	});
	
	$(".addCatPreassign").click(function(){
		var params=$(this).attr("params");
		var c_id=$(this).attr("c_id");	
		var arrPrams = params.split("#"); 
		$('.frmAddCategoryPreAssign #c_id').val(c_id);
		$('.frmAddCategoryPreAssign #name').val(arrPrams[0]);
		$('#modalAddCategoryPreAssign').modal('show');
	});
	
/////////////////	
	
	$(function(){
		$("#cat_user_id").select2();
	});
	
	
	
	$(".editCategoryPreAssign").click(function(){
		var params=$(this).attr("params");
		var cp_id=$(this).attr("cp_id");	
		var edcat_user_id=$(this).attr("edcat_user_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditCategoryPreAssign #cp_id').val(cp_id);
		$('.frmEditCategoryPreAssign #edcat_user_id').val(edcat_user_id);
		$('.frmEditCategoryPreAssign #edcat_id').val(arrPrams[0]);
		$('.frmEditCategoryPreAssign #edcategory_name').val(arrPrams[1]);
		$('.frmEditCategoryPreAssign #edoffice_id').val(arrPrams[2]);
		$('#modalEditCategoryPreAssign').modal('show');
	});
		
	$("#edoffice_id").change(function(){
		var aoffice_id=$(this).val();
		populate_access_control_combo(aoffice_id,'','edcat_user_id','N');
	});	
	
	
	$(".categoryPreAssignActDeact").click(function(){
		var cp_id=$(this).attr("cp_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Category Pre-Assign?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/srCategoryPreAssign',
			   data:'cp_id='+ cp_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});
	
	
	
/*----------- SR_Sub-Category -------------*/
	$("#btn_add_subcategory").click(function(){
		$('#modalAddSubCategory').modal('show');
	});
	
	
	$(".editSubCategory").click(function(){
		var params=$(this).attr("params");
		var sc_id=$(this).attr("sc_id");	
		var location=$(this).attr("location");
		var arrPrams = params.split("#");
		var arrlocation = location.split(","); 
		 
		$('.frmEditSubCategory #sc_id').val(sc_id);
		$('.frmEditSubCategory #edcat_id').val(arrPrams[0]);
		$('.frmEditSubCategory #edname').val(arrPrams[1]);
		$('.frmEditSubCategory #location_sr1').val(arrlocation).select2();
		$('#modalEditSubCategory').modal('show');
	});
	
	
	$(".subCategoryActDeact").click(function(){
		var sc_id=$(this).attr("sc_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Sub-Category?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/srSubCategoryActDeact',
			   data:'sc_id='+ sc_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});	

///////////////////////	
	$(".addSubcatPreassign").click(function(){
		var params=$(this).attr("params");
		var c_id=$(this).attr("c_id");	
		var arrPrams = params.split("#"); 
		$('.frmAddsubCategoryPreAssign #c_id').val(c_id);
		//$('.frmAddsubCategoryPreAssign #scat_id').val(arrPrams[0]);
		//$('.frmAddsubCategoryPreAssign #edname').val(arrPrams[1]);
		$('#modalAddsubCategoryPreAssign').modal('show');
	});
	
	$("#edoffice_id").change(function(){
		var aoffice_id=$(this).val();
		populate_access_control_combo(aoffice_id,'','eduser_id','N');
	});
	
	
	$("#scat_id").change(function(){
		var cid = this.value;
		if(cid=="") alert("Please Select Category");
		var URL=baseURL+'master/getsubcategory';
		//alert(URL+"?cid="+cid);
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'cid='+cid,
		   success: function(cList){
			   //alert(cList);
				var json_obj = $.parseJSON(cList);//parse JSON
				
				$('#cat_sub_id').empty();
				$('#cat_sub_id').append($('<option></option>').val('').html('-- Select --'));
						
				for (var i in json_obj) $('#cat_sub_id').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name));								
			},
			error: function(){	
				alert('Fail!');
			}
		  });
	  });

	  
	  $(".editsubCategoryPreAssign").click(function(){
		var params=$(this).attr("params");
		var scp_id=$(this).attr("scp_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditsubCategoryPreAssign #scp_id').val(scp_id);
		$('.frmEditsubCategoryPreAssign #edcat_id').val(arrPrams[0]);
		$('.frmEditsubCategoryPreAssign #category_name').val(arrPrams[1]);
		$('.frmEditsubCategoryPreAssign #edcat_sub_id').val(arrPrams[2]);
		$('.frmEditsubCategoryPreAssign #subcat_name').val(arrPrams[3]);
		$('.frmEditsubCategoryPreAssign #edoffice_id').val(arrPrams[4]);
		$('.frmEditsubCategoryPreAssign #eduser_id').val(arrPrams[5]);
		$('#modalEditsubCategoryPreAssign').modal('show');
	});
	
	
	$(".subcategoryPreAssignActDeact").click(function(){
		var scp_id=$(this).attr("scp_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Sub-Category Pre-Assign?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/srsubCategoryPreAssign',
			   data:'scp_id='+ scp_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});	
	

	
/*----------- SR_Priority -------------*/
	$("#btn_add_priority").click(function(){
		$('#modalAddPriority').modal('show');
	});
	
		
	$(".editPriority").click(function(){
		var params=$(this).attr("params");
		var pr_id=$(this).attr("pr_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditPriority #pr_id').val(pr_id);
		$('.frmEditPriority #edpriority_name').val(arrPrams[0]);
		$('#modalEditPriority').modal('show');
	});
	
	
	$(".priorityActDeact").click(function(){
		var pr_id=$(this).attr("pr_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Priority?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/srPriority',
			   data:'pr_id='+ pr_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});	


/*----------- SR_Status -------------*/
	$("#btn_add_status").click(function(){
		$('#modalAddStatus').modal('show');
	});
	
		
	$(".editStatus").click(function(){
		var params=$(this).attr("params");
		var st_id=$(this).attr("st_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditStatus #st_id').val(st_id);
		$('.frmEditStatus #edname').val(arrPrams[0]);
		$('#modalEditStatus').modal('show');
	});
	
	
	$(".statusActDeact").click(function(){
		var st_id=$(this).attr("st_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Status?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/srStatus',
			   data:'st_id='+ st_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});		
		
//////////////////////////////////////////////////////////////////////////////////////	

/*----------- Assign Performance Metrics (30.05.2019) -------------*/
	$("#btn_add_pmassign").click(function(){
		$('#modalAddPmAssign').modal('show');
	});
	
	
		$(function(){
			$("#user_id").select2();
			//$("#eduser_id").select2();
		});
		
		
		$("#did").change(function(){
			var aoffice_id = $('option:selected', this).attr('office_id');
			
			$("#user_id").empty();
			populate_access_control_combo(aoffice_id,'','user_id','N');
		});
		
		
		
		/* $("#eddid").change(function(){
			var boffice_id = $('option:selected', this).attr('edoffice_id');
			
			$("#eduser_id").empty();
			populate_access_control_combo(boffice_id,'','eduser_id','N');
		}); */
		
		
		
	$(".editPmAssign").click(function(){
		var params=$(this).attr("params");
		var pm_id=$(this).attr("pm_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditPmAssign #pm_id').val(pm_id);
		$('.frmEditPmAssign #eddid').val(arrPrams[0]);
		$('.frmEditPmAssign #eduser_id').val(arrPrams[1]);
		
		$('#modalEditPmAssign').modal('show');
	});
	
	
	$(".editPmAssign").click(function(){
		var office=$(this).attr("office");
		//alert(office);
		populate_access_control_combo(office,'','eduser_id','N');
	});	
	
	
	$(".pmAssignActDeact").click(function(){
		var pm_id=$(this).attr("pm_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Performance Metrics User Assign?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/pmAssign',
			   data:'pm_id='+ pm_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});	
	
	
/////////////////////////////////////////////////////////////
////////////// Fems Certification(13.06.2019) ///////////////
/////////////////////////////////////////////////////////////

/*-----------  -------------*/
	$("#btnAddQuestions").click(function(){
		$('#modalAddQuestions').modal('show');
	});
		
	
	$(".editQuestion").click(function(){
		var params=$(this).attr("params");
		var q_id=$(this).attr("q_id");	
		var arrPrams = params.split("#"); 
		$('.frmEditQuestions #q_id').val(q_id);
		$('.frmEditQuestions #ed_question_name').val(arrPrams[0]);
		$('#modalEditQuestions').modal('show');
	});
	
	
	$(".questionActDeact").click(function(){
		var q_id=$(this).attr("q_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Category?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/questionsActDeact',
			   data:'q_id='+ q_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});
	
	
	$(".addAnswers").click(function(){
		var params=$(this).attr("params");
		var q_id=$(this).attr("q_id");	
		var arrPrams = params.split("#"); 
		$('.frmAddAnswers #q_id').val(q_id);
		//$('.frmAddAnswers #name').val(arrPrams[0]);
		$('#modalAddAnswers').modal('show');
	});
	
/////////////////	
	
	$(".editAnswer").click(function(){
		var params=$(this).attr("params");
		var a_id=$(this).attr("a_id");
		var arrPrams = params.split("#"); 
		$('.frmEditAnswers #a_id').val(a_id);
		$('.frmEditAnswers #edquestion_id').val(arrPrams[0]);
		$('.frmEditAnswers #edanswer').val(arrPrams[1]);
		$('.frmEditAnswers #edis_correct').val(arrPrams[2]);
		$('#modalEditAnswers').modal('show');
	});
	
	
	$(".answerActDeact").click(function(){
		var a_id=$(this).attr("a_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the Answer?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'master/answerActDeact',
			   data:'a_id='+ a_id+'&sid='+ sid,
			   success: function(msg){
					window.location.reload();
				}
			  });
		  }
	});
	
/*---------------------Open FEMS Certification---------------------*/

	$("#btnAddingUsers").click(function(){
		$("#modalOpenCertification").modal('show');
	});
	
	
	$("#office_id").change(function(){
		var aoffice_id=$(this).val();
		$("#open_user_id").empty();
		populate_access_control_combo(aoffice_id,'','open_user_id','N');
	});
	
	
	$(function(){
		//$("#open_user_id").select2();
	});
	
	
	$(".editOpenFusionCerti").click(function(){
		var a_id=$(this).attr("id"); 
		var edopen_user_id=$(this).attr("user_id"); 
		$('.frmEditOpenCertification #open_id').val(a_id);
		$('.frmEditOpenCertification #edopen_user_id').val(edopen_user_id);
		$('#modalEditOpenCertification').modal('show');
	});
	
	
//////////////////////////////////////////////////////////////////////////////
////////////// Manage Policy & Process Update Access(28.06.2019) /////////////
//////////////////////////////////////////////////////////////////////////////
	
	$("#btnPolicyAccessUsers").click(function(){
		$("#modalPolicyAccess").modal('show');
	});
	
	
	$("#office_id").change(function(){
		var aoffice_id=$(this).val();
		$("#user_id").empty();
		populate_access_control_combo(aoffice_id,'','user_id','N');
	});
	
	
	$(".editPolicyAccess").click(function(){
		var access_id=$(this).attr("id"); 
		var edo_user_id=$(this).attr("user_id"); 
		$('.frmEditPolicyAccess #access_id').val(access_id);
		$('.frmEditPolicyAccess #edo_user_id').val(edo_user_id);
		$('#modalEditPolicyAccess').modal('show');
	});
	
/////////////////////////
	$("#btnProcessupdateAccessUsers").click(function(){
		$("#modalProcessupdateAccess").modal('show');
	});
	
	
	$(".editProcessupdateAccess").click(function(){
		var pu_accessid=$(this).attr("puid"); 
		var edpu_user_id=$(this).attr("pu_userid"); 
		$('.frmEditProcessupdateAccess #pu_accessid').val(pu_accessid);
		$('.frmEditProcessupdateAccess #edpu_user_id').val(edpu_user_id);
		$('#modalEditProcessupdateAccess').modal('show');
	});
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	

});

////////////////////////////

function pad(num, size) {
    var s = "0000000000" + num;
    return s.substr(s.length-size);
}


// 
//	Added by Lawrence for leave portal
// Section Start
//

function get_leave_criteria_data(id){
	$.post("<?php echo base_url()?>master/get_leave_criteria_data", { id:id },function(data){
		if(data != 0){
			data = $.parseJSON(data);
			$("#modalEditLeaveCriteria").find("#edit_id").val(data.id);
			$("#modalEditLeaveCriteria").find("#edit_office_location").val(data.office_abbr);
			$("#modalEditLeaveCriteria").find("#edit_leave_type").val(data.leave_type_id);
			$("#modalEditLeaveCriteria").find("#edit_criteria").val(data.criteria);
			$("#modalEditLeaveCriteria").find("#edit_limit_per_month").val(data.limit_per_month);
			$("#modalEditLeaveCriteria").find("#edit_has_sub_category").val(data.has_sub_category);
			$("#modalEditLeaveCriteria").find("#edit_period_start").val(data.period_start);
			$("#modalEditLeaveCriteria").find("#edit_period_end").val(data.period_end);
			$("#modalEditLeaveCriteria").find("#edit_max_limit").val(data.max_limit);
			$("#modalEditLeaveCriteria").find("#edit_carry_forward").val(data.carry_forward);
			$("#modalEditLeaveCriteria").find("#edit_carry_forward_limit").val(data.carry_forward_limit);
			$("#modalEditLeaveCriteria").find("#edit_for_gender").val(data.for_gender);
			$("#modalEditLeaveCriteria").find("#edit_for_dept").val(data.for_dept);
			$("#modalEditLeaveCriteria").find("#edit_activate_after_days").val(data.activate_after_days);
			$("#modalEditLeaveCriteria").find("#edit_show_after_days").val(data.show_after_days);
			$("#modalEditLeaveCriteria").find("#edit_show_in_dashboard").val(data.show_in_dashboard);
			$("#modalEditLeaveCriteria").find("#edit_show_in_dropdown").val(data.show_in_dropdown);
			$("#modalEditLeaveCriteria").find("#edit_spl_leave").val(data.spl_leave);

			$("#modalEditLeaveCriteria").modal('show');

		}else{ alert("Operation Failed");}
	});
}

function get_leave_type_data(id){
	$.post("<?php echo base_url()?>master/get_leave_type_data", { id:id },function(data){
		if(data != 0){
			data = $.parseJSON(data);
			$("#modalEditLeaveType").find("#edit_id").val(data.id);
			$("#modalEditLeaveType").find("#edit_abbr").val(data.abbr);
			$("#modalEditLeaveType").find("#edit_full_form").val(data.description);

			$("#modalEditLeaveType").modal('show');

		}else{ alert("Operation Failed");}
	});
}

function delete_leave_type(id){
	/*
	$.post("<?php echo base_url()?>master/delete_leave_type", { id:id },function(data){
		location.reload();
	});
	*/
}

function delete_leave_criteria(id){
	$.post("<?php echo base_url()?>master/delete_leave_criteria", { id:id },function(data){
		location.reload();
	});
}

function activate_leave_criteria(id){
	$.post("<?php echo base_url()?>master/activate_leave_criteria", { id:id },function(data){
		location.reload();
	});
}

function extra_leave_criteria(id){
	$("#modalAddLeaveCriteriaConfig").find("#criteria_id").val(id);

	$.post("<?php echo base_url()?>master/get_leave_criteria_extra_config_data", {id:id}, function(data){
		$("#previous_leave_criteria_configs").html(data);
		$("#modalAddLeaveCriteriaConfig").modal('show');
	});
}

function add_more_leave_criteria_subs(){

	html_a = '<div class="row">';
	html_a += '<div class="form-group col-md-6" style="margin-bottom:5px;">';
	html_a += '<input type="text" name="description[]" class="form-control" required>';
	html_a += '</div>';
	html_a += '<div class="form-group col-md-5" style="margin-bottom:5px;">';
	html_a += '<input type="text" name="deduction[]" class="form-control" placeholder="1.00" required>';
	html_a += '</div>';
	html_a += '<div class="form-group col-md-1" style="margin-bottom:5px;margin-top: -4px; margin-left: -6px">';
	html_a += '<button onclick="remove_me_input($(this))" type="button" class="btn btn-sm btn-danger" style="margin-top: 3px;">';
	html_a += '<i class="fa fa-times"></i>';
	html_a += '</button>';
	html_a += '</div>';
	html_a += '</div>';

	$("#modalAddLeaveCriteriaConfig").find('div#criteria_config_id').after(html_a);
}

function remove_me_input(elem){
	$(elem).closest('div.row').remove();
}

function edit_leave_criteria_config(elem){
	$(elem).closest("tr").find('span').hide();
	$(elem).closest("tr").find("input").show();
	$("button.button-save").prop("disabled",false);
}

function deactivate_leave_criteria_config(elem,id){
	$.post("<?php echo base_url()?>master/deactivate_leave_criteria_config",{id:id}, function(data){
		$(elem).closest('td').find('button.button-deactive').hide();		
		$(elem).closest("tr").find("td.active-in-td").empty().html('<span style="padding:2px 3px" class="bg-danger">In-Active</span>');		
		$(elem).closest('td').find('button.button-active').show();

	});
	
}

function activate_leave_criteria_config(elem,id){
	$.post("<?php echo base_url()?>master/activate_leave_criteria_config",{id:id}, function(data){
		$(elem).closest('td').find('button.button-active').hide();
		$(elem).closest("tr").find("td.active-in-td").empty().html('<span style="padding:2px 3px" class="bg-primary">Active</span>');	
		$(elem).closest('td').find('button.button-deactive').show();
	});
	
}


// 
//	Added by Lawrence for leave portal
// 	Section End
//



</script>


<script type="text/javascript">
	
</script>

