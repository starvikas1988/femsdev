<script type="text/javascript">

$(document).ready(function(){
    
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
	

	$("#exportSummReports").click(function(){
	
			//alert(baseURL+'attendance/createAttnSummary?'+$('#frmAttnSummary').serialize());
			
			//e.preventDefault();
			
			var start_date=$('#start_date').val();
			var end_date=$('#end_date').val();
			if(start_date!="" && end_date!=""){
				
				$("#exportSummReports").css("cursor", "not-allowed");
				$("#exportSummReports").prop('disabled', true);
				
				$("body").css("cursor", "progress");

				$("#ajax_msg_div").html("<b><i class='fa fa-spinner fa-pulse  fa-1x fa-fw'></i></b> Fetching Data from Database.");
				$("#ajax_msg_div").show();
						
				
				$("#progress_bar_div").show();
				$("#downloadSummReports").hide();
				
				var inv=(Math.random() * (35 - 25) + 25)*1000;
							
				$(".progress-bar").animate({
					width: "70%"
				}, inv).promise().done(function(){
					$("#ajax_msg_div").html("<b><i class='fa fa-refresh fa-spin fa-1x fa-fw'></i></b> Creating Excel File. It may take a few minutes.");
				});
			  
				$.ajax({
					url:baseURL+'attendance/createAttnSummary',
					type:'post',
					data:$('#frmAttnSummary').serialize(),
					success:function(ret){
						//whatever you wanna do after the form is successfully submitted
						ret=ret.trim();
						if(ret!="ERROR"){
								
							$("#ajax_msg_div").html("<b><i class='fa fa-refresh fa-spin fa-1x fa-fw'></i></b>Saving Excel File.");
								
							$(".progress-bar").animate({
									width: "100%"
							}, 5000).promise().done(function(){
								  
								$("#progress_bar_div").hide();
								$("#ajax_msg_div").hide();
								
								var dUrl=baseURL+'attendance/downloadFile?fn='+ret;	
								
								//var dUrl=baseURL+'temp_files/summary/'+encodeURI(ret);
								//alert(dUrl);					
								
								$("#downloadSummReports").attr("href", dUrl);
								$("#downloadSummReports").show();
								
								$("#exportSummReports").prop('disabled', false);
								$("#exportSummReports").css("cursor", "pointer");
						
								$(".progress-bar").animate({
									width: "0%"
								});
									
							});
														
						}else{
						
							$("#exportSummReports").prop('disabled', false);
							$("#exportSummReports").css("cursor", "pointer");
						
							$("#progress_bar_div").hide();
							$("#ajax_msg_div").hide();
							$("#ajax_msg_div").html("Error. Try Again.");
							$(".progress-bar").animate({
								width: "0%"
							});
						}
						
						$("body").css("cursor", "default");
												
					},
					error: function(){						
						alert('Fail!');
						$("body").css("cursor", "default");
						$(".progress-bar").animate({
							width: "0%"
						});
					}				
				});
			}
			
	});
	
	
	/*
	$("#downloadSummReports").click(function(){
		
		var fn=$(this).attr("fn");
		
		alert(fn);
		
	
	});
*/
		
});

  $( function() {
  
   // $( "#start_date" ).datepicker();
	$( "#start_date" ).datepicker({maxDate: new Date()});
	//$('#start_date').datepicker( "setDate", "-1d" );
	$( "#end_date" ).datepicker({ maxDate: new Date() });
	
	$( "#gstart_date" ).datepicker({maxDate: '-1d'});
	$( "#gend_date" ).datepicker({maxDate: '-1d'});
	 
	//$( "#end_date" ).datepicker();
	
  });
  
  function getSubSourceOptions(source_id){
	$('#sktPleaseWait').modal('show');
        $.ajax({
            url:"<?= base_url()."ar_data_impoter/get_sub_source_option/"?>",
            type:"POST",
            data:'source_id=' + source_id,
            success:function(result){
                console.log(result);                               
                $("#sub_source").html(result); 
				$('#sktPleaseWait').modal('hide');
            }
        });
    }

    setTimeout(() => {
            $('.alert').alert('close');
        }, 100000);

    function checkUploadedFile(elm)
    {
        var ext = elm.val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['xls','xlsx','csv']) == -1) {
            alert('This file format is not allowed , Please upload xls,xlsx,csv');
            elm.val('');
        }
    }  

    function checkUploadedFileFixed(elm)
    {
        var ext         = elm.val().split('.').pop().toLowerCase();
        var fileName    = elm.val().split('\\');;
        var clean       = fileName[fileName.length - 1]; // clean from C:\fakepath OR C:\fake_path 
        if($.inArray(ext, ['xlsx']) == -1) {
            alert('This file format is not allowed , Please upload xls,xlsx,csv');
            elm.val('');
        }
        /*if(clean != 'Dialer_data_sample_upload_format.xlsx'){
            alert('Downloaded file name and Uploaded file name are not matched.');
            elm.val('');
        }*/

    }  
    
</script>

