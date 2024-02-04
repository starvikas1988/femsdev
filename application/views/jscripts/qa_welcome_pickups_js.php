<script>

$(document).ready(function(){

///////////////// Calibration - Auditor Type ///////////////////////	
	$('.auType').hide();
	
	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});	

/////////////////////

    var score_setter = function(selected_score, total_score){
        return (selected_score/(total_score))*100.00;
    }

    $(".score_setter").change(function(){
        main_score = 0;
    
        $(".score_setter").each(function(i,v){
            if($(this).val() != ''){
                //main_score = main_score + parseInt(Math.floor($(this).val())); 
				main_score = main_score + parseInt(Math.floor( $("option:selected", this).attr("score") )); 				
            }
        });
		
        $("#total_score").val(score_setter(main_score, total_score).toFixed(1));
       
    });

})

</script>