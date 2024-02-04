	
<script type="text/javascript">

var office_id = "<?php echo get_user_office_id(); ?>";

$(document).ready(function(){
	
	/*
	$(document).bind("contextmenu",function(e){
      return false;
   });
   
	*/

$(document).on('click', '.user_row', function(){
		
		var fid=$(this).attr("id");
		var aname=$(this).attr("aname");
		var map=$(this).attr("map");
		
		$("#"+map).val(fid);
		$("#"+map+"_name").val(aname);
		
		$('#userSearchModal').modal("hide");		
	});
	
	
	// Add event listener for opening and closing details
    $('#default-datatable tbody').on('click', 'td.details-control', function (){
		
		var p = $(this).closest('tr');
		var tr = $(this).closest('tr').next('tr')
		tr.toggle();
		p.toggleClass( "shown" );
		
    });
	
	
	var pht=$('#main_page_content').height();
	var wht=$( window ).height()-200;
	if(pht>wht){
		$('.app-footer').removeClass('fixed_bottom');
	}else{
		$('.app-footer').addClass("fixed_bottom");
	}
	
	
	/////////Change Password///////
		
		$(".changePsw").click(function(){
			$("#changePasswordModal").modal('show');
		});
		
		
		$("#btnLogoutModel").click(function(){

			//clearInterval (window.countdownTimer_onload);
			localStorage.clear();
			
			if(isADLocation(office_id)==true){
				$("#LogoutImgModelAd").modal('show');
			}else{
				$("#LogoutImgModel").modal('show');
			}
		});
		
		
		$("#LogoutImgModel").on("hide.bs.modal", function () {
			
			window.location = "<?php echo base_url();?>logout";
			
		});

	//////////////////	
	
});

/////////////////////////
	
function populate_secrch_user(aname,aomuid)
{
	
	var URL='<?php echo base_url();?>users/getUserList';
						
		//alert(URL+"?aname="+aname+"&aomuid="+aomuid);
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'aname='+aname+'&aomuid='+aomuid,
		   success: function(aList){
				
				
				var isfound=false;
				var json_obj = $.parseJSON(aList);//parse JSON
				
				var html = '<table id="tb_user_src" border="1" class="table table-striped" cellspacing="0" width="100%" >';
				
					html += '</head>';
					html += '<tr>';
					html += '<th>Fusion ID</th>';
					html += '<th>First Name</th>';
					html += '<th>Last Name</th>';
					html += '<th>Office</th>';
					html += '<th>Role</th>';
					html += '<th>Process</th>';
					html += '</tr>';
					html += '</head>';
					html += '<tbody>';
				
								
				for (var i in json_obj) 
				{
					isfound=true;
					html += '<tr class="user_row" map="'+map+'" id="'+json_obj[i].fusion_id+'" aname="'+json_obj[i].fname+" "+json_obj[i].lname+'" >';
					html += '<TD>'+json_obj[i].fusion_id+'</TD>';
					html += '<TD>'+json_obj[i].fname+'</TD>';
					html += '<TD>'+json_obj[i].lname+'</TD>';
					html += '<TD>'+json_obj[i].office_id+'</TD>';
					html += '<TD>'+json_obj[i].role_name+'</TD>';
					html += '<TD>'+json_obj[i].process_names+'</TD>';
					html += '</tr>';
				}
				if(isfound==false){
					html += '<tr>';
					html += '<TD colspan=5>Data Not Found</TD>';
					html += '</tr>';
					
				}
				
				html += '</tbody>';
				
				html += '</table>';
				
				
				
				$("#search_user_rec").html(html);
			
			},
			error: function(){	
				alert('Fail!');
			}
		  });
		  
}


function populate_sub_dept_combo(did,def='',objid='sub_dept_id',isAll='N')
{
	
	var URL='<?php echo base_url();?>users/getSubDepartmentList';
	
		//alert(URL+"?did="+did);
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'did='+did+'&isAll='+isAll,
		   success: function(sdList){
		   	
			// alert(sdList);
			
			var json_obj = $.parseJSON(sdList);//parse JSON
							
			// $('#'+objid).empty();
			
			// if(json_obj==''){
				
			// 	if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL'));
			// 	else $('#'+objid).append($('<option></option>').val('').html('NA'));
				
			// 	//$('#'+objid).removeAttr('required');
				
			// }else{
				
			// 	if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL'));
			// 	else $('#'+objid).append($('<option></option>').val('').html('-- Select a Sub Department --'));
				
			// 	for (var i in json_obj) 
			// 	{
			// 		$('#'+objid).append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name));					
			// 	}
				
			// 	//$('#'+objid).attr('required', 'required');	
				
			// }

			$('#'+objid).multiselect('clearSelection');
	        $('#'+objid).multiselect('refresh');
			
			var htm = ""

	        if (json_obj && json_obj.length > 0) {
	        	var htm = "<option value='ALL'>ALL</option>";
			    for (var i in json_obj) {
			        htm += "<option value=" + json_obj[i].id + ">" + json_obj[i].name + "</option>";
			    }
			}
	        
			$('#' + objid).html(htm);
			$('#' + objid).multiselect('rebuild');
			
			// if(isAll=='Y') $('#'+objid).val("ALL");
			// else{
			// 	$('#'+objid).val(def);
			// }
			
			
			},
			error: function(){	
				alert('Fail!');
			}
		  });
		  
}

/////
function populate_assign_combo(oid,def='',objid='assigned_to',isAll='N')
{

	//var oid= $("#office_id").val();
	//office_id
		
	var URL='<?php echo base_url();?>users/getAssignList';
	
	if(oid=="") alert("Please Select Employees' Office Location")
	//alert(URL+"?oid="+oid);
	
	$.ajax({
	   type: 'POST',    
	   url:URL,
	   data:'oid='+oid,
	   success: function(pList){
		
		//alert(pList);
		
		var json_obj = $.parseJSON(pList);//parse JSON
		
		// $('#'+objid).empty();
					
		// if(json_obj==""){
			
		// 	if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL'));
		// 	else $('#'+objid).append($('<option></option>').val('').html('NA'));
				
		// }else{
		
		// 	if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL'));
		// 	else $('#'+objid).append($('<option></option>').val('').html('-- Select a TL/Supervisor/Trainer --'));
				
		// 	for (var i in json_obj) 
		// 	{
		// 		$('#'+objid).append($('<option></option>').val(json_obj[i].id).html(json_obj[i].tl_name));
		// 	}
			
		// }


		$('#'+objid).multiselect('clearSelection');
        $('#'+objid).multiselect('refresh');
		
		var htm = '';

		for (var i in json_obj) {

            htm += "<option value="+json_obj[i].id+">"+json_obj[i].tl_name+"</option>";

        }

		$('#' + objid).html(htm);
		$('#' + objid).multiselect('rebuild');

		
		if(isAll=='Y') $('#'+objid).val("ALL");
		else $('#'+objid).val(def);
					
		},
		error: function(){	
			alert('Fail!');
		}
	  });
	  
}

function populate_process_combo(cid,def='',objid='process_id',isAll='N')
{
	
		var URL='<?php echo base_url();?>users/getProcessList';
		
		//alert(URL+"?cid="+cid);
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'cid='+cid+'&isAll='+isAll,
		   success: function(pList){
		   	
			// alert(pList);
			
			var json_obj = $.parseJSON(pList);//parse JSON
			
                //$('#'+objid)[0].selectize.clearOptions();
				
				$('#'+objid).multiselect('clearSelection');
                $('#'+objid).multiselect('refresh');
				
				var htm = "<option value='ALL'>All</option>";

				for (var i in json_obj) {
	                // $('#' + objid)[0].selectize.addOption({
	                //     value: json_obj[i].id,
	                //     text: json_obj[i].name
	                // });
	                // $('#' + objid)[0].selectize.addItem(i);

	                htm += "<option value="+json_obj[i].id+">"+json_obj[i].name+"</option>";

	            }
				// htm += '<option value="1"> aaaaaa</option>';
				// htm += '<option value="2"> bbbbb</option>';
				// htm += '<option value="3"> ccccccc</option>';
				$('#' + objid).html(htm);
				$('#' + objid).multiselect('rebuild');
		
				/*
                if (json_obj == "") {
                    if (isALL == 'Y') {
                        $('#' + objid)[0].selectize.addOption({
                            value: "",
                            text: "ALL"
                        });
                        $('#' + objid)[0].selectize.addItem(1);
                    } else {
                        $('#' + objid)[0].selectize.addOption({
                            value: "",
                            text: "NA"
                        });
                        $('#' + objid)[0].selectize.addItem(1);
                    }


                } else {
                    if (isAll == 'Y') {
                        $('#' + objid)[0].selectize.addOption({
                            value: "",
                            text: "ALL"
                        });
                        $('#' + objid)[0].selectize.addItem(1);
                    } else {
                        $('#' + objid)[0].selectize.addOption({
                            value: "",
                            text: "-- Select a Process --"
                        });
                        $('#' + objid)[0].selectize.addItem(1);
                    }


                    for (var i in json_obj) {
                        $('#' + objid)[0].selectize.addOption({
                            value: json_obj[i].id,
                            text: json_obj[i].name
                        });
                        $('#' + objid)[0].selectize.addItem(i);
                    }


                }
				
				*/
				
                // if (isAll == 'Y')
                //     $('#' + objid).val("0");
                // if (def != "")
                //     $('#' + objid).val(def);
			
			
				if(isAll=='Y') $('#'+objid).val("0");
				if(def!="") $('#'+objid).val(def);
				return true;
			},
			error: function(){	
				alert('Fail!');
			}
		  });	
			
}

function populate_sub_process_combo(pid,def='',objid='sub_process_id',isAll='N')
{
	
	var URL='<?php echo base_url();?>users/getSubProcessList';
	
		//alert(URL+"?pid="+pid);
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'pid='+pid,
		   success: function(pList){
		   	
			//alert(pList);
			
			var json_obj = $.parseJSON(pList);//parse JSON
							
			// $('#'+objid).empty();
			
			// if(json_obj==''){
				
			// 	if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL'));
			// 	else $('#'+objid).append($('<option></option>').val('').html('NA'));
				
			// 	$('#'+objid).removeAttr('required');
				
			// }else{
				
			// 	if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL'));
			// 	else $('#'+objid).append($('<option></option>').val('').html('-- Select a Sub Process --'));
				
			// 	for (var i in json_obj) 
			// 	{
			// 		$('#'+objid).append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name));					
			// 	}
				
			// 	$('#'+objid).attr('required', 'required');	
				
			// }


			$('#'+objid).multiselect('clearSelection');
            $('#'+objid).multiselect('refresh');
			
			var htm = '';

			for (var i in json_obj) {
                // $('#' + objid)[0].selectize.addOption({
                //     value: json_obj[i].id,
                //     text: json_obj[i].name
                // });
                // $('#' + objid)[0].selectize.addItem(i);

                htm += "<option value="+json_obj[i].id+">"+json_obj[i].name+"</option>";

            }
			// htm += '<option value="1"> aaaaaa</option>';
			// htm += '<option value="2"> bbbbb</option>';
			// htm += '<option value="3"> ccccccc</option>';
			$('#' + objid).html(htm);
			$('#' + objid).multiselect('rebuild');

			
			if(isAll=='Y') $('#'+objid).val("ALL");
			else $('#'+objid).val(def);
			
			
			},
			error: function(){	
				alert('Fail!');
			}
		  });
		  
}

///////////////////////////////// Access Control (22.05.2019) ///////////////////////////////
	
	function populate_access_control_combo(off_id,def='',objid='access_control',isAll='N')
	{
		
			var URL='<?php echo base_url();?>users/getAccessControl';
			
			//alert(URL+"?cid="+cid);
			
			$('#sktPleaseWait').modal('show');
			
			$.ajax({
			   type: 'POST',    
			   url:URL,
			   data:'off_id='+off_id,
			   success: function(oList){
				
				//alert(oList);
				
				var json_obj = $.parseJSON(oList);//parse JSON
				
				$('#'+objid).empty();
							
				if(json_obj==""){
					if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL')); 
					else $('#'+objid).append($('<option></option>').val('').html('NA'));
								
					
				}else{
				
					
					if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL'));
					else $('#'+objid).append($('<option></option>').val('').html('-- Select --'));
					
					
					for (var i in json_obj) 
					{
						$('#'+objid).append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name+' '+'('+json_obj[i].fusion_id+')'+' '+' -'+json_obj[i].dept_name));
					}
					
					
				}
				
					if(isAll=='Y') $('#'+objid).val("ALL");
					if(def!="") $('#'+objid).val(def);
					
					$('#sktPleaseWait').modal('hide');
					
				},
				error: function(){	
					alert('Fail!');
				}
			  });		  
	}


	function populate_access_control_combo_oth(off_id,def='',objid='access_control',isAll='N')
	{
		
			var URL='<?php echo base_url();?>users/getAccessControlServicerequest';
			
			//alert(URL+"?cid="+cid);
			
			$('#sktPleaseWait').modal('show');
			
			$.ajax({
			   type: 'POST',    
			   url:URL,
			   data:'off_id='+off_id,
			   success: function(oList){
				
				//alert(oList);
				
				var json_obj = $.parseJSON(oList);//parse JSON
				
				$('#'+objid).empty();
							
				if(json_obj==""){
					if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL')); 
					else $('#'+objid).append($('<option></option>').val('').html('NA'));
								
					
				}else{
				
					
					if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL'));
					else $('#'+objid).append($('<option></option>').val('').html('-- Select --'));
					
					
					for (var i in json_obj) 
					{
						$('#'+objid).append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name+' '+'('+json_obj[i].fusion_id+')'+' '+' -'+json_obj[i].dept_name));
					}
					
					
				}
				
					if(isAll=='Y') $('#'+objid).val("ALL");
					if(def!="") $('#'+objid).val(def);
					
					$('#sktPleaseWait').modal('hide');
					
				},
				error: function(){	
					alert('Fail!');
				}
			  });		  
	}


	
///////////////////////////////// Access User Control using Department (05.06.2019) ///////////////////////////////
	
	function populate_accesscontrol_dept_combo(cat_id,def='',objid='access_control',isAll='N')
	{
		
			var URL='<?php echo base_url();?>users/getAccessControlDept';
			
			//alert(URL+"?cid="+cid);
			
			$('#sktPleaseWait').modal('show');
			
			$.ajax({
			   type: 'POST',    
			   url:URL,
			   data:'cat_id='+cat_id,
			   success: function(oList){
				
				//alert(pList);
				
				var json_obj = $.parseJSON(oList);//parse JSON
				
				$('#'+objid).empty();
							
				if(json_obj==""){
					if(isAll=='Y') $('#'+objid).append($('<option></option>').val('-').html('')); 
					else $('#'+objid).append($('<option></option>').val('').html('NA'));
								
					
				}else{
				
					
					if(isAll=='Y') $('#'+objid).append($('<option></option>').val('-').html(''));
					else $('#'+objid).append($('<option></option>').val('').html('-- Select --'));
					
					
					for (var i in json_obj) 
					{
						$('#'+objid).append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name+' '+'('+json_obj[i].fusion_id+')'));
					}
					
					
				}
				
					if(isAll=='Y') $('#'+objid).val("");
					if(def!="") $('#'+objid).val(def);
					
					$('#sktPleaseWait').modal('hide');
					
				},
				error: function(){	
					alert('Fail!');
				}
			  });		  
	}	
	


///////////////////////////////////DFR Requisition part///////////////////////////////////////////////////

	function populate_requisition_lists(office_id,def='',objid='requisition_id',isAll='N')
	{
		
		var URL='<?php echo base_url();?>reports/getreqList';
			
			$.ajax({
			   type: 'GET',    
			   url:URL,
			   data:'office_id='+office_id,
			   success: function(sdList){
					var json_obj = $.parseJSON(sdList);//parse JSON
									
					$('#'+objid).empty();
					
					if(json_obj==''){
						
						if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL'));
						else $('#'+objid).append($('<option></option>').val('').html('NA'));
						
					}else{
						
						if(isAll=='Y') $('#'+objid).append($('<option></option>').val('ALL').html('ALL'));
						else $('#'+objid).append($('<option></option>').val('').html('--Select--'));
						
						for (var i in json_obj) 
						{
							$('#'+objid).append($('<option></option>').val(json_obj[i].requisition_id).html(json_obj[i].requisition_id));					
						}	
						
					}
					
					if(isAll=='Y') $('#'+objid).val("ALL");
					else{
						$('#'+objid).val(def);
					}
				
				},
				error: function(){	
					alert('Fail!');
				}
			  });
			  
	}
	
	function isIndiaLocation(office_id)
	{
		var locArray = ["KOL", "HWH", "BLR", "CHE", "NOI","MUM","CHA","KOC","DUR","JMP","KLY"];
		var pos = $.inArray( office_id, locArray );
		if(pos>=0) return true;
		else return false;
	}
	
	function isADLocation(office_id)
	{
		var locArray = ["FTK", "HIG", "MIN", "SPI", "TEX", "UTA", "CAM"];
		var pos = $.inArray( office_id, locArray );
		if(pos>=0) return true;
		else return false;
	}
	
	function isUSLocation(office_id)
	{
		var locArray = ["ALT","MON", "DRA", "FTK", "HIG", "MIN", "SPI", "TEX", "UTA", "CAM","FLO"];
		var pos = $.inArray( office_id, locArray );
		if(pos>=0) return true;
		else return false;
	}
	

  
</script>

