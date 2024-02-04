<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script type="text/javascript">
	$('#default-datatable').DataTable({
		"pageLength":50
	});

	var baseURL="<?php echo base_url();?>";

    

	function desc(count){
		var idp = count.id;
    	var counter = idp.match(/\d+/);
    	var ram= $('#ram_id'+counter).find(":selected").text();
    	var processor= $('#processor_id'+counter).find(":selected").text();
    	var display= $('#display_id'+counter).find(":selected").text();
    	var hdd= $('#hdd_id'+counter).find(":selected").text();
    	$("#desc"+counter).val('ram='+ram+',processor='+processor+",display="+display+",hard disk="+hdd);
    };



    function myFunction(count){
    	var idp = count.id;
    	var counter = idp.match(/\d+/);
    	var stockName = $("#pro_id"+counter).val();
    	// alert(counter);

    		$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/get_cat_id',
				   data:'pro_id='+stockName,
				   success: function(msg){
				   	var alrt = JSON.parse(msg);
					   $("#cat_id"+counter).val(alrt.status);
					}
				  });

		if(stockName != 1 && stockName != 3){
			$("#ram_id"+counter+"_div").hide();
			$("#ram_id"+counter).removeAttr("required");
			$("#processor_id"+counter+"_div").hide();
			$("#processor_id"+counter).removeAttr("required");
			$("#display_id"+counter+"_div").hide();
			$("#display_id"+counter).removeAttr("required");
			$("#hdd_id"+counter+"_div").hide();
			$("#hdd_id"+counter).removeAttr("required");
			$("#desc"+counter+"_div").hide();
			$("#desc"+counter).removeAttr("required");
			$("#type_div"+counter).show();
			$("#type"+counter).removeAttr("required");
			$("#mouse_div"+counter).hide();
			$("#mouse"+counter).removeAttr("required");
			$("#keybrd_div"+counter).hide();
			$("#keybrd"+counter).removeAttr("required");
			$("#headset_div"+counter).hide();
			$("#headset"+counter).removeAttr("required");
		}
		else{
			$("#type_div"+counter).hide();
			$("#ram_id"+counter+"_div").show();
			$("#ram_id"+counter).attr("required",true);
			$("#mouse_div"+counter).show();
			$("#mouse"+counter).attr("required",true);
			$("#keybrd_div"+counter).show();
			$("#keybrd"+counter).attr("required",true);
			$("#headset_div"+counter).show();
			$("#headset"+counter).attr("required",true);
			$("#processor_id"+counter+"_div").show();
			$("#processor_id"+counter).attr("required",true);
			$("#display_id"+counter+"_div").show();
			$("#display_id"+counter).attr("required",true);
			$("#hdd_id"+counter+"_div").show();
			$("#hdd_id"+counter).attr("required",true);
			$("#desc"+counter+"_div").show();
			$("#desc"+counter).attr("required",true);
		}
		// $("#togl_shw").show();


    }; 
$(document).ready(function(){


	$("#conf_stat").change(function(){
    	var conf_stat = $("#conf_stat").val();
		if(conf_stat == 0){
			$('#asset_sl_no').removeAttr("required");
		}
    });
	
	
	$('#employee_id').select2({
		placeholder: "Fusion ID For Other",
		allowClear: true,
		createTag: function (tag) {

			// Check if the option is already there
			var found = false;
			$("#timezones option").each(function() {
				if ($.trim(tag.term).toUpperCase() === $.trim($(this).text()).toUpperCase()) {
					found = true;
				}
			});

			// Show the suggestion only if a match was not found
			if (!found) {
				return {
					id: tag.term,
					text: tag.term + " (new)",
					isNew: true
				};
			}
		}
	});



    var baseURL="<?php echo base_url();?>";

    $("#pro_id").change(function(){
    	var stockName = $("#pro_id").val();
    	$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/get_cat_id',
				   data:'pro_id='+stockName,
				   success: function(msg){
				   	var alrt = JSON.parse(msg);
					   $("#cat_id").val(alrt.status); 
					}
				  });
		if(stockName != 1 && stockName != 3){
			$("#ram_id_div").hide();
			$("#processor_id_div").hide();
			$("#display_id_div").hide();
			$("#hdd_id_div").hide();
			$("#desc_div").hide();
			$("#type_div").show();
		}
		else{
			$("#type_div").hide();
			$("#ram_id_div").show();
			$("#processor_id_div").show();
			$("#display_id_div").show();
			$("#hdd_id_div").show();
			$("#desc_div").show();
		}	
    });


    $("#dlvr_stat").change(function(){
    	var stockName = $(this).val();
    	
		if(stockName == 8 || stockName == 9){
			$("#asset_div").show();
			$("#address_div").show();
		}
		else{
			$("#type_div").hide();
			$("#ram_id_div").show();
			$("#processor_id_div").show();
			$("#display_id_div").show();
			$("#hdd_id_div").show();
			$("#desc_div").show();
		}	
    });


    $("#pro_id2").change(function(){
    	var stockName = $("#pro_id2").val();
    	
    		$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/get_cat_id',
				   data:'pro_id='+stockName,
				   success: function(msg){
				   	var alrt = JSON.parse(msg);
					   $("#cat_id2").val(alrt.status);
					   $("#cat_id1").val(alrt.status);
					}
				  });

		if(stockName != 1 && stockName != 3){
			$("#ram_id2_div").hide();
			$("#ram_id2").removeAttr("required");
			$("#processor_id2_div").hide();
			$("#processor_id2").removeAttr("required");
			$("#display_id2_div").hide();
			$("#display_id2").removeAttr("required");
			$("#hdd_id2_div").hide();
			$("#hdd_id2").removeAttr("required");
			$("#desc2_div").hide();
			$("#desc2").removeAttr("required");
			$("#type_div2").show();
			$("#mouse_div2").hide();
			$("#mouse").removeAttr("required");
			$("#keybrd_div2").hide();
			$("#keybrd").removeAttr("required");
			$("#headset_div2").hide();
			$("#headset").removeAttr("required");
		}
		else{
			$("#type_div1").hide();
			$("#ram_id2_div").show();
			$("#ram_id2").attr("required",true);
			$("#mouse_div2").show();
			$("#mouse").attr("required",true);
			$("#keybrd_div2").show();
			$("#keybrd").attr("required",true);
			$("#headset_div2").show();
			$("#headset").attr("required",true);
			$("#processor_id2_div").show();
			$("#processor_id2").attr("required",true);
			$("#display_id2_div").show();
			$("#display_id2").attr("required",true);
			$("#hdd_id2_div").show();
			$("#hdd_id2").attr("required",true);
			$("#desc2_div").show();
			$("#desc2").attr("required",true);
		}
		// $("#togl_shw").show();


    });


    $("#ram_id,#processor_id,#display_id,#hdd_id").change(function(){
    	var ram= $('#ram_id').find(":selected").text();
    	var processor= $('#processor_id').find(":selected").text();
    	var display= $('#display_id').find(":selected").text();
    	var hdd= $('#hdd_id').find(":selected").text();
    	$("#desc").val('ram='+ram+',processor='+processor+",display="+display+",hard disk="+hdd);
    });

    $("#ram_id1,#processor_id1,#display_id1,#hdd_id1").change(function(){
    	var ram= $('#ram_id1').find(":selected").text();
    	var processor= $('#processor_id1').find(":selected").text();
    	var display= $('#display_id1').find(":selected").text();
    	var hdd= $('#hdd_id1').find(":selected").text();
    	$("#desc1").val('ram='+ram+',processor='+processor+",display="+display+",hard disk="+hdd);
    });
    $("#ram_id2,#processor_id2,#display_id2,#hdd_id2").change(function(){
    	var ram= $('#ram_id2').find(":selected").text();
    	var processor= $('#processor_id2').find(":selected").text();
    	var display= $('#display_id2').find(":selected").text();
    	var hdd= $('#hdd_id2').find(":selected").text();
    	$("#desc2").val('ram='+ram+',processor='+processor+",display="+display+",hard disk="+hdd);
    });

	
	

    $("#whom").change(function(){
    	var whom = $(this).val();
		if(whom == 2){
			$("#employee_id").attr("required",true);
			$("#ref_by_comp_emplo").show();
		}
		else{
			$("#ref_by_comp_emplo").hide();
			$('#ref_employee_name_container select').removeAttr('required');
		}	
    });


	///////////////stock///////////////////
	
	$(".editStock").click(function(){
		

		var params=$(this).attr("params");
		var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
		
		$('#rid').val(rid);
		
		$('#pro_id2').val(arrPrams[0]);
		$('#cat_id1').val(arrPrams[1]);
		$('#brand_id1').val(arrPrams[2]);
		$('#ram_id1').val(arrPrams[3]);
		$('#processor_id1').val(arrPrams[6]);
		$('#display_id1').val(arrPrams[4]);
		$('#hdd_id1').val(arrPrams[5]);
		$('#desc1').val(arrPrams[7]);
		$('#quant1').val(arrPrams[8]);
		$('#model_no1').val(arrPrams[9]);
		$('#gst_no1').val(arrPrams[10]);
		$('#receipt_no1').val(arrPrams[11]);
		$('#serial_no1').val(arrPrams[12]);
		$('#hdph_type1').val(arrPrams[13]);


		var stockName = $("#pro_id2").val();

	    if(stockName != 1 && stockName != 3){
			$("#ram_id2_div").hide();
			$("#processor_id2_div").hide();
			$("#display_id2_div").hide();
			$("#hdd_id2_div").hide();
			$("#desc2_div").hide();
			$("#type_div1").show();
		}
		else{
			$("#type_div1").hide();
			$("#ram_id2_div").show();
			$("#processor_id2_div").show();
			$("#display_id2_div").show();
			$("#hdd_id2_div").show();
			$("#desc2_div").show();
		}


		$('#modalEditStock').modal('show');
		
		
	});
	
	$("#btnEditStock").click(function(){
	
		var rid=$('#rid').val().trim();
		var name=$('#pro_id2').val().trim();
		var cat_id=$('#cat_id1').val().trim();
		var brand_id=$('#brand_id1').val().trim();
		var quant=$('#quant1').val().trim();

		var ram_id=$('#ram_id1').val().trim();
		var processor_id=$('#processor_id1').val().trim();
		var display_id=$('#display_id1').val().trim();
		var hdd_id=$('#hdd_id1').val().trim();
		var desc=$('#desc1').val().trim();
		
		if(name != 1 && name != 3){
			if(rid!="" && name!="" && cat_id!="" && brand_id!="" && quant!=""){
				
				$('#sktPleaseWait').modal('show');
					
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/update_stock',
				   data:$('form.frmEditStock').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditStock').modal('hide');
						location.reload();
				}
			  });
			}else{
				alert("One or More Field(s) are Blank.");
			}
		}else{
			if(rid!="" && name!="" && cat_id!="" && brand_id!="" && quant!="" && ram_id!="" && processor_id!="" && display_id!="" && hdd_id!="" && desc!=""){
				
				$('#sktPleaseWait').modal('show');
					
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/update_stock',
				   data:$('form.frmEditStock').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditStock').modal('hide');
						location.reload();
				}
			  });
			}else{
				alert("One or More Field(s) are Blank.");
			}
		}
	});

		
	$("#add_Stock").click(function(){
		$('#modalAddStock').modal('show');
	});
		
	$("#btnAddStock").click(function(){

		// $(".frmAddProd").valid();
	
		var name=$('#pro_id').val().trim();
		var cat_id=$('#cat_id').val().trim();
		var brand_id=$('#brand_id').val().trim();
		var quant=$('#quant').val().trim();

		var ram_id=$('#ram_id').val().trim();
		var processor_id=$('#processor_id').val().trim();
		var display_id=$('#display_id').val().trim();
		var hdd_id=$('#hdd_id').val().trim();
		var desc=$('#desc').val().trim();
		if(name != 1 && name != 3){
			if(name!="" && cat_id!="" && brand_id!="" && quant!=""){
				$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/add_stock',
				   data:$('form.frmAddStock').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalAddStock').modal('hide');
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
		}
		else{
			if(name!="" && cat_id!="" && brand_id!="" && quant!="" && ram_id!="" && processor_id!="" && display_id!="" && hdd_id!="" && desc!=""){
				$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/add_stock',
				   data:$('form.frmAddStock').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalAddStock').modal('hide');
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
		}
		
		
	});


	$(".chckSim").click(function(){ 
		var pid=$(this).attr("pid");
					$.ajax({
						   type: 'POST',    
						   url: baseURL+'asset/checkSimilarProducts',
						   data:'pro_id='+pid,
						   success: function(msg){
						   	$("#modalAprv").modal('hide');
								var alrt = JSON.parse(msg);
								    console.log(alrt);
								    var j = 1;
								    $('#content').empty();
								    for (var i in alrt){
										$('#content').append('<tr><td>'+j+'</td><td>'+alrt[i].name+'</td><td>'+alrt[i].category+'</td><td>'+alrt[i].brand_name+'</td><td>'+alrt[i].description+'</td><td>'+alrt[i].quantity+'</td></tr>');	
									j=j+1;
									}

						}
					});

		$('#modalSim').modal('show');
	});


	$(".aprvReq").click(function(){
		var pid=$(this).attr("rid");
		var rqid=$(this).attr("rqid");
		$("#ridAprv").val(pid);
		$("#rqidAprv").val(rqid);
		$("#modalAprv").modal('show');
		
	});
	$("#btnAprv").click(function(){
		var pid=$("#ridAprv").val();
		var ans=confirm('Are you sure to approve the request?');
		if(ans==true){
			$.ajax({
				   type: 'POST',    
				   url: baseURL+'asset/approve',
				   data:$('form.frmAprv').serialize(),
				   success: function(msg){
				   	$("#modalAprv").modal('hide');
						var alrt = JSON.parse(msg);
						   if(alrt.status == 'approved'){
						   	location.reload();	
						   }

					}
			});
		}


	});


	$(".rjctReq").click(function(){
		var pid=$(this).attr("rid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the request?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/reject',
			   data:'pid='+ pid+'&sid='+sid,
			   success: function(msg){
					var alrt = JSON.parse(msg);
				   if(alrt.status == 'rejected'){
				   	alert("Request Rejected");
				   	location.reload();
				   	// $("#status"+pid).html("<label class='label label-danger'>Cancelled</label>");
				   	// $("#default"+pid).hide();
				   	// $("#disapprove"+pid).hide();
				   	// $("#approve"+pid).show();
				   }
				}
			  });
		  }
	});

	$(".rjctReq1").click(function(){
		var pid=$(this).attr("rid");
		var pqid=$(this).attr("rqid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the request?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/reject1',
			   data:'pid='+ pid+'&pqid='+ pqid+'&sid='+sid,
			   success: function(msg){
					var alrt = JSON.parse(msg);
				   if(alrt.status == 'rejected'){
				   	alert("Request Rejected");
				   	location.reload();
				   	// $("#status"+pid).html("<label class='label label-danger'>Cancelled</label>");
				   	// $("#default"+pid).hide();
				   	// $("#disapprove"+pid).hide();
				   	// $("#approve"+pid).show();
				   }
				}
			  });
		  }
	});


	$(".asignIt").click(function(){
		var pid=$(this).attr("rid");
		$("#ridIt").val(pid);
		var pqid=$(this).attr("rqid");
		$("#rqidIt").val(pqid);
		$("#modalIt").modal('show');
		
	});

	$("#btnIt").click(function(){
		var pid=$("#ridIt").val();
		var name=$("#it_engnr").val();
		if(name!=""){
			var ans=confirm('Are you sure to proceed?');
			if(ans==true){
				$.ajax({
					   type: 'POST',    
					   url: baseURL+'asset/assign_it',
					   data:$('form.frmIt').serialize(),
					   success: function(msg){
					   	$("#modalAprv").modal('hide');
							var alrt = JSON.parse(msg);
							   if(alrt.status == 'approved'){
							   	location.reload(); 	
							   }

						}
				});
			}
		}else{
			alert("One or More Field(s) are Blank.");
		}


	});



	$(".dlvrIt").click(function(){
		var params=$(this).attr("params");	
		var arrPrams = params.split("#");


		$("#dlvr_stat").change(function(){
    	var stockName = $(this).val();
    	
			if(stockName == 8 || stockName == 9){
				$("#asset_div").show();
				$("#asset_sl_no").attr("required",true);
				$("#address_div").show();
				$("#destination").attr("required",true);
				if(arrPrams[9] == "Yes"){
					$('#mouse_div').show();
					$("#mouse_sl_no").attr("required",true);
				}
				if(arrPrams[10] == "Yes"){
					$('#keyboard_div').show();
					$("#keyboard_sl_no").attr("required",true);
				}
				if(arrPrams[11] == "USB" || arrPrams[11] == "Analog"){
					$('#headset_div').show();
					$("#headset_sl_no").attr("required",true);
				}
			}
			else{
				$("#mouse_div").hide();
				$("#mouse_sl_no").removeAttr("required");
				$("#asset_div").hide();
				$("#asset_sl_no").removeAttr("required");
				$("#address_div").hide();
				$("#destination").removeAttr("required");
				$("#keyboard_div").hide();
				$("#keyboard_sl_no").removeAttr("required");
				$("#headset_div").hide();
				$("#headset_sl_no").removeAttr("required");
			}	
	    });

		$("#qty").val(arrPrams[6]);
		$("#mouse_id").val(arrPrams[9]);
		$("#keybrd_id").val(arrPrams[10]);
		$("#hdset_id").val(arrPrams[11]);

		var pid=$(this).attr("rid");
		$("#riddlvr").val(pid);
		var pqid=$(this).attr("rqid");
		$("#rqiddlvr").val(pqid);
		$("#modaldlvrIt").modal('show');
		
	});

	$("#btndlvrIt").click(function(){
		var dlvr_stat = $("#dlvr_stat").val();

	    let valid = true;
	    $('.frmdlvrIt input:required').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
	    if (!valid || dlvr_stat =="") alert("please fill all fields!");
  		else{
  			var ans=confirm('Are you sure to proceed?');
			if(ans==true){
				$.ajax({
					   type: 'POST',    
					   url: baseURL+'asset/delivered_to_agent',
					   data:$('form.frmdlvrIt').serialize(),
					   success: function(msg){
					   	$("#modaldlvrIt").modal('hide');
							var alrt = JSON.parse(msg);
							   if(alrt.status == 'done'){
							   	location.reload(); 	
							   }
						}
				});
			}
  		}

	});



	$(".aprvPrchseReq").click(function(){
		var pid=$(this).attr("rid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+" the request?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/approve_purcashe',
			   data:'pid='+ pid+'&sid='+sid,
			   success: function(msg){
					var alrt = JSON.parse(msg);
				   if(alrt.status == 'approved'){
				   	location.reload();
				   	// $("#status"+pid).html("<label class='label label-success'>Approved</label>");
				   	// $("#default"+pid).hide();
				   	// $("#disapprove"+pid).hide();
				   	// $("#approve"+pid).show();
				   }
				}
			  });
		  }
	});


	$(".reqPurchse").click(function(){


		var params=$(this).attr("params");
		// var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
		
		$('#ridp').val(arrPrams[7]);
		$('#rqidp').val(arrPrams[12]);
		$('#pro_id').val(arrPrams[0]);
		$('#cat_id').val(arrPrams[1]);
		$('#ram_id').val(arrPrams[2]);
		$('#processor_id').val(arrPrams[5]);
		$('#display_id').val(arrPrams[3]);
		$('#hdd_id').val(arrPrams[4]);
		$('#desc').val(arrPrams[8]);
		$('#quant').val(arrPrams[6]);


    	var stockName = $("#pro_id").val();
  		
  		$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/get_cat_id',
				   data:'pro_id='+stockName,
				   success: function(msg){
				   	var alrt = JSON.parse(msg);
					   $("#cat_id").val(alrt.status); 
					}
		});

		if(stockName != 1 && stockName != 3){

			$("#ram_id_div").hide();
			$("#processor_id_div").hide();
			$("#display_id_div").hide();
			$("#hdd_id_div").hide();
			$("#desc_div").hide();
		}
		else{
			$("#ram_id_div").show();
			$("#processor_id_div").show();
			$("#display_id_div").show();
			$("#hdd_id_div").show();
			$("#desc_div").show();
		}	


		$('#modalReqPurchse').modal('show');
	});


	$("#btnAddPurchse").click(function(){

		// $(".frmAddProd").valid();
	
		var name=$('#pro_id').val().trim();
		var cat_id=$('#cat_id').val().trim();
		var quant=$('#quant').val().trim();

		var ram_id=$('#ram_id').val().trim();
		var processor_id=$('#processor_id').val().trim();
		var display_id=$('#display_id').val().trim();
		var hdd_id=$('#hdd_id').val().trim();
		var desc=$('#desc').val().trim();
		if(name != 1 && name != 3){
			if(name!="" && cat_id!="" && quant!=""){
				$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/add_reqPurchase',
				   data:$('form.frmAddProd1').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalAddProd').modal('hide');
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
		}
		else{
			if(name!="" && cat_id!="" && quant!="" && ram_id!="" && processor_id!="" && display_id!="" && hdd_id!="" && desc!=""){
				$('#sktPleaseWait').modal('show');	
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/add_reqPurchase',
				   data:$('form.frmAddProd1').serialize(),
				   success: function(msg){
							$('#sktPleaseWait').modal('hide');
							$('#modalAddProd').modal('hide');
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
		}
		
		
	});


	///////////////Ram///////////////////
	
	$(".editRam").click(function(){
	
		var params=$(this).attr("params");
		var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
		
		$('#rid').val(rid);
		
		$('#name').val(arrPrams[0]);
		
		
		
		$('#modalEditRam').modal('show');
		
		
	});
	
	$("#btnEditRam").click(function(){
	
		var rid=$('#rid').val().trim();
		var name=$('#name').val().trim();
		
		//alert(baseURL+"asset/updateRole?"+$('form.frmEditRole').serialize());
		
		if(rid!="" && name!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/updateRam',
			   data:$('form.frmEditRam').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditRam').modal('hide');
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
		
	$(".ramActDeact").click(function(){
		var rid=$(this).attr("rid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		//alert(baseURL+"asset/roleActDeact?did="+did + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the ram?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/ramActDeact',
			   data:'rid='+ rid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#add_ram").click(function(){
		$('#modalAddRam').modal('show');
	});
		
	$("#btnAddRam").click(function(){
	
		var name=$('#aname').val().trim();
		
		//alert(baseURL+"asset/addRole?"+$('form.frmAddRole').serialize());	
		
		if(name!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/addRam',
			   data:$('form.frmAddRam').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddRam').modal('hide');
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



///////////////Category///////////////////
	
	$(".editCat").click(function(){
	
		var params=$(this).attr("params");
		var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
		
		$('#rid').val(rid);
		
		$('#name').val(arrPrams[0]);
		
		
		
		$('#modalEditCat').modal('show');
		
		
	});
	
	$("#btnEditCat").click(function(){
	
		var rid=$('#rid').val().trim();
		var name=$('#name').val().trim();
		
		//alert(baseURL+"asset/updateRole?"+$('form.frmEditRole').serialize());
		
		if(rid!="" && name!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/update_category',
			   data:$('form.frmEditCat').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditCat').modal('hide');
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
		
	$(".CatActDeact").click(function(){
		var rid=$(this).attr("rid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		//alert(baseURL+"asset/roleActDeact?did="+did + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the category?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/categoryActDeact',
			   data:'rid='+ rid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#add_cat").click(function(){
		$('#modalAddCat').modal('show');
	});
		
	$("#btnAddCat").click(function(){
	
		var name=$('#aname').val().trim();
		
		//alert(baseURL+"asset/addRole?"+$('form.frmAddRole').serialize());	
		
		if(name!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/add_category',
			   data:$('form.frmAddCat').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddCat').modal('hide');
						location.reload();
				}
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});



///////////////Brand///////////////////
	
	$(".editBrand").click(function(){
	
		var params=$(this).attr("params");
		var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
		
		$('#rid').val(rid);
		
		$('#name').val(arrPrams[0]);
		
		
		
		$('#modalEditBrand').modal('show');
		
		
	});
	
	$("#btnEditBrand").click(function(){
	
		var rid=$('#rid').val().trim();
		var name=$('#name').val().trim();
		
		if(rid!="" && name!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/update_brand',
			   data:$('form.frmEditBrand').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditBrand').modal('hide');
						location.reload();
				}
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});
		
	$(".BrandActDeact").click(function(){
		var rid=$(this).attr("rid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		//alert(baseURL+"asset/roleActDeact?did="+did + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the brand?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/brandActDeact',
			   data:'rid='+ rid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#add_Brand").click(function(){
		$('#modalAddBrand').modal('show');
	});
		
	$("#btnAddBrand").click(function(){
	
		var name=$('#aname').val().trim();
		
		if(name!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/add_brand',
			   data:$('form.frmAddBrand').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddBrand').modal('hide');
						location.reload();
				}
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});



	///////////////Product///////////////////
	
	$(".editProd").click(function(){
	
		var params=$(this).attr("params");
		var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
		
		$('#rid').val(rid);
		
		$('#name').val(arrPrams[0]);
		$('#cat_id1').val(arrPrams[1]);
		$('#brand_id1').val(arrPrams[2]);
		
		$('#modalEditProd').modal('show');
		
		
	});
	
	$("#btnEditProd").click(function(){
	
		var rid=$('#rid').val().trim();
		var name=$('#name').val().trim();
		
		
		if(rid!="" && name!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/update_product',
			   data:$('form.frmEditProd').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditProd').modal('hide');
						location.reload();
				}
			  });
		}else{
			alert("One or More Field(s) are Blank.");
		}
	});
		
	$(".ProdActDeact").click(function(){
		var rid=$(this).attr("rid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		//alert(baseURL+"asset/roleActDeact?did="+did + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the product?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/productActDeact',
			   data:'rid='+ rid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#add_prod").click(function(){
		$('#modalAddProd').modal('show');
	});
		
	$("#btnAddProd").click(function(){
	
		var name=$('#aname').val().trim();
		
		//alert(baseURL+"asset/addRole?"+$('form.frmAddRole').serialize());	
		
		if(name!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/add_product',
			   data:$('form.frmAddProd').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddProd').modal('hide');
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






///////////////Processor///////////////////
	
	$(".editProcessor").click(function(){
	
		var params=$(this).attr("params");
		var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
		
		$('#rid').val(rid);
		
		$('#name').val(arrPrams[0]);
		
		
		
		$('#modalEditProcessor').modal('show');
		
		
	});
	
	$("#btnEditProcessor").click(function(){
	
		var rid=$('#rid').val().trim();
		var name=$('#name').val().trim();
		
		//alert(baseURL+"asset/updateRole?"+$('form.frmEditRole').serialize());
		
		if(rid!="" && name!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/updateProcessor',
			   data:$('form.frmEditProcessor').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditProcessor').modal('hide');
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
		
	$(".processorActDeact").click(function(){
		var rid=$(this).attr("rid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		//alert(baseURL+"asset/roleActDeact?did="+did + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the processor?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/processorActDeact',
			   data:'rid='+ rid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#add_processor").click(function(){
		$('#modalAddProcessor').modal('show');
	});
		
	$("#btnAddProcessor").click(function(){
	
		var name=$('#aname').val().trim();
		
		//alert(baseURL+"asset/addRole?"+$('form.frmAddRole').serialize());	
		
		if(name!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/addProcessor',
			   data:$('form.frmAddProcessor').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddProcessor').modal('hide');
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




///////////////Hdd///////////////////
	
	$(".editHdd").click(function(){
	
		var params=$(this).attr("params");
		var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
		
		$('#rid').val(rid);
		
		$('#name').val(arrPrams[0]);
		
		
		
		$('#modalEditHdd').modal('show');
		
		
	});
	
	$("#btnEditHdd").click(function(){
	
		var rid=$('#rid').val().trim();
		var name=$('#name').val().trim();
		
		//alert(baseURL+"asset/updateRole?"+$('form.frmEditRole').serialize());
		
		if(rid!="" && name!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/updateHardDisk',
			   data:$('form.frmEditHdd').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditHdd').modal('hide');
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
		
	$(".hddActDeact").click(function(){
		var rid=$(this).attr("rid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		//alert(baseURL+"asset/roleActDeact?did="+did + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the drive?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/hardDiskActDeact',
			   data:'rid='+ rid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#add_hdd").click(function(){
		$('#modalAddHdd').modal('show');
	});
		
	$("#btnAddHdd").click(function(){
	
		var name=$('#aname').val().trim();
		
		//alert(baseURL+"asset/addRole?"+$('form.frmAddRole').serialize());	
		
		if(name!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/addHardDisk',
			   data:$('form.frmAddHdd').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddHdd').modal('hide');
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



///////////////Screen size///////////////////
	
	$(".editScrn").click(function(){
	
		var params=$(this).attr("params");
		var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
		
		$('#rid').val(rid);
		
		$('#name').val(arrPrams[0]);
		
		
		
		$('#modalEditScrn').modal('show');
		
		
	});
	
	$("#btnEditScrn").click(function(){
	
		var rid=$('#rid').val().trim();
		var name=$('#name').val().trim();
		
		//alert(baseURL+"asset/updateRole?"+$('form.frmEditRole').serialize());
		
		if(rid!="" && name!=""){
			
			$('#sktPleaseWait').modal('show');
				
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/update_screen_size',
			   data:$('form.frmEditScrn').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditScrn').modal('hide');
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
		
	$(".scrnActDeact").click(function(){
		var rid=$(this).attr("rid");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		//alert(baseURL+"asset/roleActDeact?did="+did + "&sid="+sid);
		var ans=confirm('Are you sure to '+title+" the Screen size?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/screen_sizeActDeact',
			   data:'rid='+ rid+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			  });
		  }
	});
		
	$("#add_scrn").click(function(){
		$('#modalAddScrn').modal('show');
	});
		
	$("#btnAddScrn").click(function(){
	
		var name=$('#aname').val().trim();
		
		//alert(baseURL+"asset/addRole?"+$('form.frmAddRole').serialize());	
		
		if(name!=""){
			$('#sktPleaseWait').modal('show');	
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'asset/add_screen_size',
			   data:$('form.frmAddScrn').serialize(),
			   success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalAddScrn').modal('hide');
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


	$("#reqGdgt").click(function(){
		$('#modalReqGdgt').modal('show');
	});


	 $(document).on('submit','.frmAddProd',function(e){
	 	e.preventDefault();
		// $(".frmAddProd").valid();

		let valid = true;
	    $('.frmAddProd input:required').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
	    if (!valid) alert("please fill all fields!");
  		else{
					$('#sktPleaseWait').modal('show');	
					$.ajax({
					   type: 'POST',    
					   url:baseURL+'asset/add_reqGdgt',
					   data:$('form.frmAddProd').serialize(),
					   success: function(msg){
								$('#sktPleaseWait').modal('hide');
								$('#modalAddProd').modal('hide');
								location.reload();
						}
					  });
		}
		
		
		
	});



	$(".adjstRqst").click(function(){
		
		
		var params=$(this).attr("params");
		var rid=$(this).attr("rid");
		//alert("rid="+rid + " params:"+params);	
		var arrPrams = params.split("#"); 
		
		$('#rid').val(rid);
		$('#rqid').val(arrPrams[12]);
		
		$('#pro_id2').val(arrPrams[0]);
		$('#cat_id1').val(arrPrams[1]);
		$('#ram_id1').val(arrPrams[2]);
		$('#processor_id1').val(arrPrams[5]);
		$('#display_id1').val(arrPrams[3]);
		$('#hdd_id1').val(arrPrams[4]);
		$('#desc1').val(arrPrams[8]);
		$('#quant1').val(arrPrams[6]);
		$('#mouse').val(arrPrams[9]);
		$('#keybrd').val(arrPrams[10]);
		$('#headset').val(arrPrams[11]);

	    if(arrPrams[0] != 1 && arrPrams[0] != 3){
			$("#ram_id2_div").hide();
			$("#ram_id1").removeAttr("required");
			$("#processor_id2_div").hide();
			$("#processor_id1").removeAttr("required");
			$("#display_id2_div").hide();
			$("#display_id1").removeAttr("required");
			$("#hdd_id2_div").hide();
			$("#hdd_id1").removeAttr("required");
			$("#desc2_div").hide();
			$("#desc1").removeAttr("required");
			$("#type_div2").show();
			$("#mouse_div2").hide();
			$("#mouse").removeAttr("required");
			$("#keybrd_div2").hide();
			$("#keybrd").removeAttr("required");
			$("#headset_div2").hide();
			$("#headset").removeAttr("required");


		}
		else{
			$("#type_div1").hide();
			$("#ram_id2_div").show();
			$("#ram_id1").attr("required",true);
			$("#mouse_div2").show();
			$("#mouse").attr("required",true);
			$("#keybrd_div2").show();
			$("#keybrd").attr("required",true);
			$("#headset_div2").show();
			$("#headset").attr("required",true);
			$("#processor_id2_div").show();
			$("#processor_id1").attr("required",true);
			$("#display_id2_div").show();
			$("#display_id1").attr("required",true);
			$("#hdd_id2_div").show();
			$("#hdd_id1").attr("required",true);
			$("#desc2_div").show();
			$("#desc1").attr("required",true);
		}

		$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/checkSimilarProducts',
			   data:'pro_id='+arrPrams[0],
				   success: function(msg){
						var alrt = JSON.parse(msg);

					    var j = 1;
					    $('#content1').empty();
					    for (var i in alrt){
							$('#content1').append('<tr><td>'+j+'</td><td>'+alrt[i].name+'</td><td>'+alrt[i].category+'</td><td>'+alrt[i].brand_name+'</td><td>'+alrt[i].description+'</td><td>'+alrt[i].quantity+'</td></tr>');
							j=j+1;
						}

					}
				});





		$('#modalEditRqst').modal('show');
		
	});

	$(document).on('submit','.frmEditRqst',function(e){
		e.preventDefault();
		// $(".frmAddProd").valid();

		let valid = true;
	    $('.frmEditRqst input:required').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
	    if (!valid) alert("please fill all fields!");
  		else{
				
				$('#sktPleaseWait').modal('show');
					
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'asset/adjust_rqst',
				   data:$('form.frmEditRqst').serialize(),
			  		success: function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#modalEditRqst').modal('hide');
						location.reload();
					}
				});
			}
		
	});


	$(".shwVndr").click(function(){
		var rid=$(this).attr("rid");
		
		$('#ridq2').val(rid);
		$.ajax({
			   type: 'POST',    
			   url: baseURL+'asset/get_vendors',
			   data:'rqst_id='+rid,
			   success: function(msg){
					var alrt = JSON.parse(msg);
					    
					    var j = 1;
					    $("#content").empty();
					    $("#vndr").empty();
					    for (var i in alrt){
					    	// console.log(alrt[i].vendor_name);
							$("#content").append('<tr><td>'+j+'</td><td>'+alrt[i].vendor_name+'</td><td>'+alrt[i].vendor_price+'</td><td><a target="_blank" href="'+baseURL+'uploads/quotation/'+alrt[i].file_name+'">'+alrt[i].file_name+'</a></td><td>'+alrt[i].comment+'</td></tr>');	

							$("#vndr").append('<option value="'+alrt[i].id+'">'+alrt[i].vendor_name+'</option>');

						j=j+1;
						}

			}
		});

	$('#modalshwVndr').modal('show');

	});


	$(".upldqt").click(function(){
		var rid=$(this).attr("rid");
		
		$('#ridq').val(rid);
		$('#modalUpldQote').modal('show');
	});

	$(document).on('submit','.frmUpldQote',function(e){
		e.preventDefault();
		// $(".frmAddProd").valid();

		let valid = true;
	    $('.frmUpldQote input:required').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
	    if (!valid) alert("please fill all fields!");
  		else{
				
				$('#sktPleaseWait').modal('show');
					
				$.ajax({
				    type: 'POST',    
				    url:baseURL+'asset/upld_qote',
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
							$('#modalEditRqst').modal('hide');
							location.reload();
			  			}
						
					}
				});
			}
		
	});


	$(document).on('submit','.frmAprvQote',function(e){
		e.preventDefault();
		// $(".frmAddProd").valid();

		let valid = true;
	    $('.frmAprvQote input:required').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
	    if (!valid) alert("please fill all fields!");
  		else{
				
				$('#sktPleaseWait').modal('show');
					
				$.ajax({
				    type: 'POST',    
				    url:baseURL+'asset/aprv_qote',
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
							$('#modalEditRqst').modal('hide');
							location.reload();
			  			}
						
					}
				});
			}
		
	});



	$(document).on('click','.add',function()
	{
		var container = $('#togl_hid').clone();
		var counter = $('#count').val();
		counter = parseInt(counter)+1;
		$('#count').val(counter);
		$('#pro_id_x').attr("p_idd",counter);

		var filter = container[0].innerHTML.replaceAll(/\_x/g,counter);
		$('.togl_shw').after('<div>'+filter+'</div>');
		
	});

	$(document).on('click','.addVndr',function()
	{
		var container = $('.vendorhid').clone();
		$('.vendor').after('<div>'+container[0].innerHTML+'</div>');
		
	});

	$(document).on('click','.remove',function()
	{
		$(this).parent().parent().remove();
	});


	$(".cnfrmDlvry").click(function(){
		var params=$(this).attr("params");	
		var arrPrams = params.split("#"); 
		

		if(arrPrams[9] == "Yes"){
			$('#mouse_div').show();
			$("#mouse_sl_no").attr("required",true);
		}
		if(arrPrams[10] == "Yes"){
			$('#keyboard_div').show();
			$("#keyboard_sl_no").attr("required",true);
		}
		if(arrPrams[11] == "USB" || arrPrams[11] == "Analog"){
			$('#headset_div').show();
			$("#headset_sl_no").attr("required",true);
		}
		$("#qty").val(arrPrams[6]);
		$('#ridcnf').val(arrPrams[7]);
		$('#rqidcnf').val(arrPrams[12]);
		$('#modalCnfrm').modal('show');
	});

	$(document).on('submit','.frmCnfrm',function(e){
		e.preventDefault();
		let valid = true;
	    $('.frmCnfrm input:required').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
	    if (!valid) alert("please fill all fields!");
  		else{
				
				// $('#sktPleaseWait').modal('show');
					
				$.ajax({
				    type: 'POST',    
				    url:baseURL+'asset/conf_dlvry_stat',
				    data: new FormData(this),
				    contentType: false,
					cache: false,
					processData:false,
			  		success: function(msg){
			  			var alrt = JSON.parse(msg);
			  			if(alrt.status == "done"){
							location.reload();
			  			}
						
					}
				});
			}
		
	});


	$(".invcVndr").click(function(){
		var rid=$(this).attr("rid");
		
		$('#ridInv').val(rid);
		$('#modalInv').modal('show');
	});


	$(document).on('submit','.frmAprvInv',function(e){
		e.preventDefault();
		// $(".frmAddProd").valid();

		let valid = true;
	    $('.frmAprvInv input:required').each(function() {
	      if ($(this).is(':invalid') || !$(this).val()) valid = false;
	    })
	    if (!valid) alert("please fill all fields!");
  		else{
				
				$('#sktPleaseWait').modal('show');
					
				$.ajax({
				    type: 'POST',    
				    url:baseURL+'asset/upld_invoice',
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
							$('#modalEditRqst').modal('hide');
							location.reload();
			  			}
						
					}
				});
			}
		
	});

	$(".view_invc").click(function(){
		var rid=$(this).attr("rid");
		

		$.ajax({
		    type: 'POST',    
		    url:baseURL+'asset/get_invoice',
		    data: "rid="+rid,
	  		success: function(msg){
	  			var alrt = JSON.parse(msg);
			    $("#contentinvc").empty();
			    // for (var i in alrt){
			    	// console.log(alrt[i].invoice);
					$("#contentinvc").append('<iframe style="width:100%; height:auto;" src="'+baseURL+'uploads/approved_invoice/'+alrt[0].invoice+'"</iframe>');
				// }
			}
		});

		$('#modal_shw_inv').modal('show');
	});

});
</script>


