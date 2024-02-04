
<script type="text/javascript">

$(document).on("keyup", '.monthly_rent', function() {
    var total=0;
    $(".monthly_rent").each(function(){
        quantity = parseInt($(this).val());
        if (!isNaN(quantity)){
            total += quantity;
        }
    });
    $('#total_rent_paid').val(total);
});


$(document).on("keyup", '.paid_80c', function() {
    var total=0;
    $(".paid_80c").each(function(){
        quantity = parseInt($(this).val());
        if (!isNaN(quantity)) {
            total += quantity;
        }
    });
    $('#total_80c_paid').val(total);
});


$(document).on("keyup", '.req_upl', function(){
	
		reqUpl = parseInt($(this).val());
		var rel= $(this).attr("rel");
		
		if(reqUpl > 0){
			$('.uploadReq'+rel).prop('required', true);
		}else{
			$('.uploadReq'+rel).prop('required', false);
		}
	
});

	
$(document).ready(function(){
   
////////////////////////////////
	$("#rent_paid_chkb").on('click', function(){
		var total=0;
		
		if($(this).is(":checked")){
			var apr = $("#apr").val();
			$(".monthly_rent").val(apr);
			
			$(".monthly_rent").each(function(){
				quantity = parseInt($(this).val());
				if (!isNaN(quantity)){
					total += quantity;
				}
			});
			$('#total_rent_paid').val(total);
		}
	});
///////////////////////	
	
	
	$('.frmAddITDeclaration').submit(function(e){
	
		e.preventDefault();
		
		var isCon=confirm('Are you sure you want to submit the form, once submitted, you cannot change it.');
		if(isCon==true){
		
			var pan_no=$('#pan_no').val();
					
			if(pan_no!=''){
				
				//alert(" <?php echo base_url();?>itdeclaration/add?" + $('form.frmAddITDeclaration').serialize());
				
				var data_dev = new FormData(this);
				console.log(data_dev);
				
				$('#sktPleaseWait').modal('show');
				
				$.ajax({
					type	:	'POST',
					url		:	'<?php echo base_url();?>itdeclaration/add',
					data	:	data_dev,
					processData: false,
					contentType: false,
					success	:	function(msg){
								$('#sktPleaseWait').modal('hide');
								
								//alert('<?php echo base_url();?>itdeclaration');
								window.location.href = '<?php echo base_url();?>itdeclaration';
								
							}
				});
			}else{
				alert('Fill the form correctly...');
			}
			
		}
		
	});
	
	
	$(".delITdcl").on('click', function(){
		var r_p = $(this).attr("r_p");
		var itdcl_id = $(this).attr("itdcl_id");
		//alert(r_p);
		var answer = confirm ("Are you sure you want to delete from this post?");
		if(answer==true){
			$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>itdeclaration/deleteimage',
				data: 'r_p='+r_p+'&itdcl_id='+ itdcl_id,
				success: function (response) {
				  if (response == 1) {
					$(".imagelocation"+r_p).remove(".imagelocation"+r_p);
				  };
				  
				}
			});
		  }
	});
	
	$(".frmEditITDeclaration").submit(function (e) {
		$('#editITDCL').prop('disabled',true);
	});


//////////////// Report & Download (ZIP & Raw data) ////////////////////////	
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	

////////// Lock/Unlock ///////////	
	$(".editItdcl").on('click', function(){
		var itd_id=$(this).attr("itd_id");
		var sid=$(this).attr("sid");
		var title=$(this).attr("title");
		var ans=confirm('Are you sure to '+title+"?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: '<?php echo base_url(); ?>itdeclaration/islockEdit',
			   data:'itd_id='+ itd_id+'&sid='+ sid,
			   success: function(msg){
					location.reload();
				}
			});
		}
	});
	
	$('.check_all').click(function(){
		if (this.checked){
			$('.check_row').each(function () {
				$('.ziptot').show();
				this.checked = true;
			});
			
		}else{
			$('.check_row').each(function () {
				$('.ziptot').hide();
				this.checked = false;
			});
			
		}  
	});
	
	$('.check_row').click(function(){
		if (this.checked){
			$('.ziptot').show();
		}
	});
	
	
	$(document).on("keyup", '.fusionid', function(){
		var fusionId = $(this).val();
		if(fusionId!=''){
			$('.filtDisab').prop('disabled', true);
		}else{
			$('.filtDisab').prop('disabled', false);
		}
	});
	
	
///////////////////////////////////////////////////////////////////////////////// 
 });

</script>

