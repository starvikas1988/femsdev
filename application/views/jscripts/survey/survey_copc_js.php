<script>
// SURVEY 1 CHECK
$("input[name='survey_1[]'][value='others']").click(function(){
	if ($(this).is(':checked')){ 
		$('#survey_1_others').prop('required',true);
		$('#survey_1_others').show();
	
	} else {
		$('#survey_1_others').prop('required',false);
		$('#survey_1_others').hide();
	}
});

// SURVEY 2 CHECK
$("input[name='survey_2[]'][value='others']").click(function(){
	if ($(this).is(':checked')){ 
		$('#survey_2_others').prop('required',true);
		$('#survey_2_others').show();
	
	} else {
		$('#survey_2_others').prop('required',false);
		$('#survey_2_others').hide();
	}
});

// SURVEY 3 CHECK
$("input[name='survey_3[]'][value='others']").click(function(){
	if ($(this).is(':checked')){ 
		$('#survey_3_others').prop('required',true);
		$('#survey_3_others').show();
	
	} else {
		$('#survey_3_others').prop('required',false);
		$('#survey_3_others').hide();
	}
});


// SURVEY 5 CHECK
function calculateSurveyCheck(){
	totalWeight = 0;
	$(".survey_5_check").each(function(){
		val = 0; 
		if($(this).val() != ''){ val = $(this).val(); }
		totalWeight = totalWeight + Number(val);
	});
	$("#survey_5_weightage").val(totalWeight);
	$("#survey_5_pass").val('1');
	$("#survey_5_weightage_entered").html('<span style="color:green;font-size:15px"><i class="fa fa-check"><i/> ' + totalWeight + '</span>');	
	if(totalWeight != 100){
		$("#survey_5_pass").val('0');
		$("#survey_5_weightage_entered").html('<span style="color:red;font-size:16px"><i class="fa fa-warning"><i/> ' + totalWeight + '</span>');		 
	}		
}


// SURVEY 6 SLIDER
var survey_6_range = document.getElementById("survey_6_range");
var surve_6_output = document.getElementById("survey_6_output");
var surve_6_val = document.getElementById("survey_6");
surve_6_output.innerHTML = survey_6_range.value;
surve_6_val.val = survey_6_range.value;
survey_6_range.oninput = function() {
  surve_6_output.innerHTML = this.value;
  surve_6_val.value = this.value;
}

// SURVEY 7 SLIDER
var survey_7_range = document.getElementById("survey_7_range");
var surve_7_output = document.getElementById("survey_7_output");
var surve_7_val = document.getElementById("survey_7");
surve_7_output.innerHTML = survey_7_range.value;
surve_7_val.val = survey_7_range.value;
survey_7_range.oninput = function() {
  surve_7_output.innerHTML = this.value;
  surve_7_val.value = this.value;
}

// SURVEY 8 CHECK
$("input[name='survey_8[]'][value='others']").click(function(){
	if ($(this).is(':checked')){ 
		$('#survey_8_others').prop('required',true);
		$('#survey_8_others').show();
	
	} else {
		$('#survey_8_others').prop('required',false);
		$('#survey_8_others').hide();
	}
});


// SURVEY VERIFY
$('.verifySurveyForm').click(function()
{
	survey_1 = $("input[name='survey_1[]']:checked").length;
	survey_2 = $("input[name='survey_1[]']:checked").length;
	survey_3 = $("input[name='survey_1[]']:checked").length;
	survey_8 = $("input[name='survey_1[]']:checked").length;
	survey_5 = $("#survey_5_pass").val();
	if((survey_1 > 0 && survey_2 > 0 && survey_3 > 0 && survey_8 > 0) && (survey_5 == 1))
	{
		$('.submitSurveyForm').click();
	} else {
		alert('Please fill up the all details carefully!');
	}

});


</script>