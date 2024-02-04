<script type="text/javascript">

$(document).ready(function(){
	
	$(".editDisposition").click(function(){
		var uid=$(this).attr("uid");
		$('#uid').val(uid);
		$( "#start_date" ).val("<?php echo CurrDateMDY();?>");
		
	});
	
$("#updateDisp").click(function(){
		
		var totDays=0;
		
		
		var uid = $('#uid').val().trim();
		var remarks=$('#remarks').val().trim();
		var start_date=$('#start_date').val().trim();
		
		if(uid !="" && start_date!=""){
			
		var isCon=confirm('Are you sure to update the status?');
		if(isCon==true){
			
			$('#sktModal').modal('hide');
			$('#sktPleaseWait').modal('show');
										
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'user/updateDailyStatus',
			   data:$('form.editDisp').serialize(),
			   success: function(msg){
						//alert(msg);
						$('#sktPleaseWait').modal('hide');
						location.reload();
				},
				error: function(){
					//alert('Fail!');
				}
				
			  });

			}
		
		}else{
			
			alert("Please Fill the fields");
			
		}
			
	});
	
//////////////////////////////////////

	var baseURL="<?php echo base_url();?>";
	
	$("#assessment_date").datepicker();
	$("#l1_supervisor").select2();
	
	
		$(".assmntScore").click(function(){
			var assmntUid=$(this).attr("assmntUid");
			//alert(assmntUid);
			$('.frmAssmntScore #assmntUid').val(assmntUid);
			
			var assmntUid=$('#assmntUid').val().trim();
			
			if(assmntUid!=""){
				$.ajax({
				   type: 'POST',    
				   url:baseURL+'training/assmnt_score',
				   data:$('form.frmAssmntScore').serialize(),
				   success: function(data){
					   $('.modal-body #assmnt_score').html(data);
					}
				});
			}
			
			$('#modalAssmntScore').modal('show');
		});

		
		
		$('#move_to').click(function(){
			var move_to = $(this).val();
			if(move_to==6){
				$('#l1_supervisor').prop('disabled',true);
			}else{
				$('#l1_supervisor').prop('disabled',false);
			}
			
		});
	
////////////////////////////////////////////

/*-----------Manager Dashboard----------*/
		$('.check_all').click(function () {
            if (this.checked){
                $('.check_row').each(function () {
                    this.checked = true;
                });
            }else{
                $('.check_row').each(function () {
                    this.checked = false;
                }); 
             }  
        });

/////////////////////	
	
});	

 
</script>


