
<script>	
$(document).ready(function(e){
	
	$('#from_date').datepicker();
	$('#to_date').datepicker();
	$('#office_id').select2();
	$('#lob_campaign').select2();
	
	
	/*$("#process_id").on('change',function(){
		var pid = this.value;
		alert(pid);
		//if(pid=="") alert("--Select Process--");
		var URL='<?php echo base_url();?>Qa_productivity_dashboard/getLocation';
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
	});*/
	
/////////////////////////////////////////////////

	
	
	
/////////////////////////////////////////	
});
</script>

<script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
 </script>
 
 
 
<!------------------------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------- Use for Graph--------------------------------------------------------------------------->



 <script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


