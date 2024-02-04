<script type="text/javascript">

$(document).ready(function(){
	
	$("#fdept_id").change(function(){
		var dept_id=$('#fdept_id').val();
		populate_sub_dept_combo(dept_id,'','fsub_dept_id','Y');
	});
	
	$(".viewEvaluation").click(function(){
		
		var eid=$(this).attr("eid");
		var herf="<?php echo base_url()?>evaluation/view_job_performance?eid="+eid;
		window.location.href = herf;
		
	});
	
	$(".evaluateEvaluation").click(function(){
		
		var eid=$(this).attr("eid");
		var herf="<?php echo base_url()?>evaluation/evaluate?eid="+eid;
		window.location.href = herf;
		
	});
	
	
	$(".reviewEvaluation").click(function(){
		
		var eid=$(this).attr("eid");
		var herf="<?php echo base_url()?>evaluation/review?eid="+eid;
		window.location.href = herf;
		
	});
	
	$(".job_description_review").click(function(){
		
		var rval=$(this).val();
		
		if(rval=="Yes"){
			$("#modified_job_div").show();
			$('#modified_job_desc').attr('required', 'required');
		}else{
			$("#modified_job_div").hide();
			$('#modified_job_desc').removeAttr('required');
		}
		
	});
	
	
})


$(function(){
    
	
	var timeOffset="-300";
	<?php if(date('T')=="EDT"):?>
		timeOffset="-240";
	<?php elseif(date('T')=="EST"): ?>
		timeOffset="-300";
	<?php endif;?>
		
	/* global setting */
    var datepickersOpt = {
        dateFormat: 'mm/dd/yy',
		timezone: timeOffset,
        maxDate   : "today"
    }
	
	$("#evaluation_date").datepicker($.extend({},datepickersOpt));
	//$( "#end_date" ).datepicker({ maxDate: new Date() });
	
	
	$('.number_spinner').bootstrapNumber({
		upClass: 'success',
		downClass: 'danger'
	});

	$(".selectpicker").selectpicker();

	
	
})

    
</script>

