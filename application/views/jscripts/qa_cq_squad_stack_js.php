<script type="text/javascript">
$(document).ready(function(){
	
	
$(document).on('change','.stack',function(){ wireless_score(); });
$(document).on('change','.Connect',function(){ wireless_score(); });
$(document).on('change','.Close',function(){ wireless_score(); });
$(document).on('change','.compliance',function(){ wireless_score(); });
wireless_score();
///////////////// Date Time Picker ///////////////////////
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#call_date_time").datepicker();
	
	$("#call_duration").timepicker();
   $("#from_date").datepicker();
	$("#to_date").datepicker();
	
	
///////////////// Calibration - Auditor Type ///////////////////////	
	$('#audit_type').each(function(){
		$valdet=$(this).val();
		if($valdet=="Calibration"){
			$('.auType_epi').show();
		}else{
			$('.auType_epi').hide();
		}
	});

	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType_epi').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			//alert(222);
			$('.auType_epi').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});	

///////////////// Form Submit ///////////////////////
	$("#form_audit_user").submit(function (e) {
					
		$('#qaformsubmit').prop('disabled',true);
		
		//e.preventDefault();
		//$('.successMessage').show();
       // alert("Form submitted");
	});
	
	$("#form_agent_user").submit(function(e){
		//alert(12);
		$('.waves-effect').prop('disabled',true);
		//$('#agentstatusMessage').show();
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});
	
///////////////// Agent and TL names ///////////////////////
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		//alert(aid);
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_ameridial/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
	
});	
</script>
 
<script type="text/javascript">
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
</script>




<script>
	function date_validation(val,type){ 
	// alert(val);
		$(".end_date_error").html("");
		$(".start_date_error").html("");
		if(type=='E'){
		var start_date=$("#from_date").val();
		if(val<start_date){
			$(".end_date_error").html("To Date must be greater or equal to From Date");
			 $(".dna-effect").attr("disabled",true);
			 $(".dna-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".dna-effect").attr("disabled",false);
			 $(".dna-effect").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$("#to_date").val();
		if(val>end_date && end_date!=''){
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".dna-effect").attr("disabled",true);
			 $(".dna-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".dna-effect").attr("disabled",false);
			 $(".dna-effect").css('cursor', 'pointer');
			}

		}
		
		
	}
</script>


<script>
$('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'avi':
			case 'mp4':
				case '3gp':
					case 'mpeg':
						case 'mpg':
							case 'mov':
								case 'mp3':
        case 'flv':
        case 'wmv':
			case'mkv':
            $('#qaformsubmit').attr('disabled', false);
            break;
        default:
            alert('This is not an allowed file type.');
			//$('#qaformsubmit').attr('disabled', true);
            this.value = '';
    }
});
</script>

<script>
		function wireless_score(){
			
var score = 0;
var scoreable = 0;
var overall_score=0;
$('.stack').each(function(index,element){
	var score_type = $(element).val();
	if(score_type == 'Yes'){
		var w1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'No'){
		var w1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'N/A'){
		var w1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
});

totScore = ((score*100)/scoreable).toFixed(2);


	$('#earned_score').val(score);
		$('#possible_score').val(scoreable);

		//alert(totScore);

		if($('#mandatory_part').val()=='No' || $('#record_correct').val()=='No' || $('#abusive_words').val()=='No' || $('#pronounce_brand').val()=='No' || $('#price_product_scheme').val()=='No' || $('#correct_disposition').val()=='No' || $('#noise').val()=='No' || $('#jargons_slangs').val()=='No'){
	        $("#overall_score").val(0);
	 }else{
		if(!isNaN(totScore)){
		$('#overall_score').val(totScore);
	  }
	  }
	  

//////////////// Connect/Close/Compliance //////////////////
var ConnectScore = 0;
var ConnectScoreable = 0;
var ConnectPercentage = 0;
//alert(12345678);

$('.Connect').each(function(index,element){
	var sc1 = $(element).val();
	
	
	if(sc1 == 'Yes'){
		var cw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		ConnectScore = ConnectScore + cw1;
		ConnectScoreable = ConnectScoreable + cw2;
	}else if(sc1 == 'No'){
		var cw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		ConnectScore = ConnectScore + cw1;
		ConnectScoreable = ConnectScoreable + cw2;
	}else if(sc1 == 'N/A'){
		var cw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		ConnectScore = ConnectScore + cw1;
		ConnectScoreable = ConnectScoreable + cw2;
	}
});

$('#ConnectAcmEarned').val(ConnectScore);
$('#ConnectAcmPossible').val(ConnectScoreable);
ConnectPercentage = ((ConnectScore*100)/ConnectScoreable).toFixed(2);
if(!isNaN(ConnectPercentage)){
	$('#ConnectAcmScore').val(ConnectPercentage+'%');
}
////////////
var CloseScore = 0;
var CloseScoreable = 0;
var ClosePercentage = 0;
$('.Close').each(function(index,element){

	var sc2 = $(element).val();
	//alert(sc2);
	if(sc2 == 'Yes'){
		var bw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		CloseScore = CloseScore + bw1;
		CloseScoreable = CloseScoreable + bw2;
	}else if(sc2 == 'No'){
		var bw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		CloseScore = CloseScore + bw1;
		CloseScoreable = CloseScoreable + bw2;
	}else if(sc2 == 'N/A'){
		var bw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		CloseScore = CloseScore + bw1;
		CloseScoreable = CloseScoreable + bw2;
	}
});

$('#CloseAcmEarned').val(CloseScore);
$('#CloseAcmPossible').val(CloseScoreable);
ClosePercentage = ((CloseScore*100)/CloseScoreable).toFixed(2);
if(!isNaN(ClosePercentage)){
	$('#CloseAcmScore').val(ClosePercentage+'%');
}
////////////
var complianceScore = 0;
var complianceScoreable = 0;
var compliancePercentage = 0;
$('.Compliance').each(function(index,element){
	var sc3 = $(element).val();
	//alert(sc3);
	if(sc3 == 'Yes'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'No'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'N/A'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}
});

$('#complAcmEarned').val(complianceScore);
$('#complAcmPossible').val(complianceScoreable);
compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
if(!isNaN(compliancePercentage)){
	$('#complAcmScore').val(compliancePercentage+'%');
}

}
//////////////////////////////////
var ConvinceScore = 0;
var ConvinceScoreable = 0;
var ConvincePercentage = 0;
$('.Convince').each(function(index,element){

	var sc2 = $(element).val();
	//alert(sc2);
	if(sc2 == 'Yes'){
		var bw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		ConvinceScore = ConvinceScore + bw1;
		ConvinceScoreable = ConvinceScoreable + bw2;
	}else if(sc2 == 'No'){
		var bw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		ConvinceScore = ConvinceScore + bw1;
		ConvinceScoreable = ConvinceScoreable + bw2;
	}else if(sc2 == 'N/A'){
		var bw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		ConvinceScore = ConvinceScore + bw1;
		ConvinceScoreable = ConvinceScoreable + bw2;
	}
});

$('#ConvinceAcmEarned').val(ConvinceScore);
$('#ConvinceAcmPossible').val(ConvinceScoreable);
ConvincePercentage = ((ConvinceScore*100)/ConvinceScoreable).toFixed(2);
if(!isNaN(ConvincePercentage)){
	$('#ConvinceAcmScore').val(ConvincePercentage+'%');
}
////////////

var ConveyScore = 0;
var ConveyScoreable = 0;
var ConveyPercentage = 0;
$('.Convey').each(function(index,element){

	var sc2 = $(element).val();
	//alert(sc2);
	if(sc2 == 'Yes'){
		var bw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		ConveyScore = ConveyScore + bw1;
		ConveyScoreable = ConveyScoreable + bw2;
	}else if(sc2 == 'No'){
		var bw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		ConveyScore = ConveyScore + bw1;
		ConveyScoreable = ConveyScoreable + bw2;
	}else if(sc2 == 'N/A'){
		var bw1 = parseFloat($(element).children("option:selected").attr('stack_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('stack_max'));
		ConveyScore = ConveyScore + bw1;
		ConveyScoreable = ConveyScoreable + bw2;
	}
});

$('#ConveyAcmEarned').val(ConveyScore);
$('#ConveyAcmPossible').val(ConveyScoreable);
ConveyPercentage = ((ConveyScore*100)/ConveyScoreable).toFixed(2);
if(!isNaN(ConveyPercentage)){
	$('#ConveyAcmScore').val(ConveyPercentage+'%');
}
////////////
</script>



<script type="text/javascript">
		window.setTimeout("document.getElementById('successMessage').style.display='none';", 9000);
		window.setTimeout("document.getElementById('agentstatusMessage').style.display='none';", 9000);
		window.setTimeout("document.getElementById('successMessage').style.display='none';", 9000);
		//window.setTimeout("document.getElementById('errorMessage').style.display='none';", 9000);
		
		
		
		$('#mandatory_part').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.mandatory_part_observation').show();
		}else{
			$('.mandatory_part_observation').hide();
		}
	});

	$('#mandatory_part').on('change', function(){
		if($(this).val()=='No'){
			$('.mandatory_part_observation').show();
			$('#mandatory_part_observation').attr('required',true);
			$('#mandatory_part_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.mandatory_part_observation').hide();
			$('#mandatory_part_observation').attr('required',false);
			$('#mandatory_part_observation').prop('disabled',true);
		}
	});	
		
	
$('#record_correct').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.record_correct_observation').show();
		}else{
			$('.record_correct_observation').hide();
		}
	});

	$('#record_correct').on('change', function(){
		if($(this).val()=='No'){
			$('.record_correct_observation').show();
			$('#record_correct_observation').attr('required',true);
			$('#record_correct_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.record_correct_observation').hide();
			$('#record_correct_observation').attr('required',false);
			$('#record_correct_observation').prop('disabled',true);
		}
	});	
		
	
	$('#abusive_words').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.abusive_words_observation').show();
		}else{
			$('.abusive_words_observation').hide();
		}
	});

	$('#abusive_words').on('change', function(){
		if($(this).val()=='No'){
			$('.abusive_words_observation').show();
			$('#abusive_words_observation').attr('required',true);
			$('#abusive_words_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.abusive_words_observation').hide();
			$('#abusive_words_observation').attr('required',false);
			$('#abusive_words_observation').prop('disabled',true);
		}
	});
	
	
	
	$('#pronounce_brand').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.pronounce_brand_observation').show();
		}else{
			$('.pronounce_brand_observation').hide();
		}
	});

	$('#pronounce_brand').on('change', function(){
		if($(this).val()=='No'){
			$('.pronounce_brand_observation').show();
			$('#pronounce_brand_observation').attr('required',true);
			$('#pronounce_brand_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.pronounce_brand_observation').hide();
			$('#pronounce_brand_observation').attr('required',false);
			$('#pronounce_brand_observation').prop('disabled',true);
		}
	});
	$('#price_product_scheme').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.price_product_scheme_observation').show();
		}else{
			$('.price_product_scheme_observation').hide();
		}
	});

	$('#price_product_scheme').on('change', function(){
		if($(this).val()=='No'){
			$('.price_product_scheme_observation').show();
			$('#price_product_scheme_observation').attr('required',true);
			$('#price_product_scheme_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.price_product_scheme_observation').hide();
			$('#price_product_scheme_observation').attr('required',false);
			$('#price_product_scheme_observation').prop('disabled',true);
		}
	});
	$('#probe_guideline').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.probe_guideline_observation').show();
		}else{
			$('.probe_guideline_observation').hide();
		}
	});

	$('#probe_guideline').on('change', function(){
		if($(this).val()=='No'){
			$('.probe_guideline_observation').show();
			$('#probe_guideline_observation').attr('required',true);
			$('#probe_guideline_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.probe_guideline_observation').hide();
			$('#probe_guideline_observation').attr('required',false);
			$('#probe_guideline_observation').prop('disabled',true);
		}
	});
	$('#misselling_misleading').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.misselling_misleading_observation').show();
		}else{
			$('.misselling_misleading_observation').hide();
		}
	});

	$('#misselling_misleading').on('change', function(){
		if($(this).val()=='No'){
			$('.misselling_misleading_observation').show();
			$('#misselling_misleading_observation').attr('required',true);
			$('#misselling_misleading_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.misselling_misleading_observation').hide();
			$('#misselling_misleading_observation').attr('required',false);
			$('#misselling_misleading_observation').prop('disabled',true);
		}
	});
	$('#product_benefits_solution').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.product_benefits_solution_observation').show();
		}else{
			$('.product_benefits_solution_observation').hide();
		}
	});

	$('#product_benefits_solution').on('change', function(){
		if($(this).val()=='No'){
			$('.product_benefits_solution_observation').show();
			$('#product_benefits_solution_observation').attr('required',true);
			$('#product_benefits_solution_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.product_benefits_solution_observation').hide();
			$('#product_benefits_solution_observation').attr('required',false);
			$('#product_benefits_solution_observation').prop('disabled',true);
		}
	});
	$('#convince').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.convince_observation').show();
		}else{
			$('.convince_observation').hide();
		}
	});

	$('#convince').on('change', function(){
		if($(this).val()=='No'){
			$('.convince_observation').show();
			$('#convince_observation').attr('required',true);
			$('#convince_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.convince_observation').hide();
			$('#convince_observation').attr('required',false);
			$('#convince_observation').prop('disabled',true);
		}
	});
	
	
	$('#objections_rebuttal').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.objections_rebuttal_observation').show();
		}else{
			$('.objections_rebuttal_observation').hide();
		}
	});

	$('#objections_rebuttal').on('change', function(){
		if($(this).val()=='No'){
			$('.objections_rebuttal_observation').show();
			$('#objections_rebuttal_observation').attr('required',true);
			$('#objections_rebuttal_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.objections_rebuttal_observation').hide();
			$('#objections_rebuttal_observation').attr('required',false);
			$('#objections_rebuttal_observation').prop('disabled',true);
		}
	});
	
	
	$('#correct_disposition').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.correct_disposition_observation').show();
		}else{
			$('.correct_disposition_observation').hide();
		}
	});

	$('#correct_disposition').on('change', function(){
		if($(this).val()=='No'){
			$('.correct_disposition_observation').show();
			$('#correct_disposition_observation').attr('required',true);
			$('#correct_disposition_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.correct_disposition_observation').hide();
			$('#correct_disposition_observation').attr('required',false);
			$('#correct_disposition_observation').prop('disabled',true);
		}
	});
	
	
	$('#noise').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.noise_observation').show();
		}else{
			$('.noise_observation').hide();
		}
	});

	$('#noise').on('change', function(){
		if($(this).val()=='No'){
			$('.noise_observation').show();
			$('#noise_observation').attr('required',true);
			$('#noise_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.noise_observation').hide();
			$('#noise_observation').attr('required',false);
			$('#noise_observation').prop('disabled',true);
		}
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$('#rate_speech').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.rate_speech_observation').show();
		}else{
			$('.rate_speech_observation').hide();
		}
	});

	$('#rate_speech').on('change', function(){
		if($(this).val()=='No'){
			$('.rate_speech_observation').show();
			$('#rate_speech_observation').attr('required',true);
			$('#rate_speech_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.rate_speech_observation').hide();
			$('#rate_speech_observation').attr('required',false);
			$('#rate_speech_observation').prop('disabled',true);
		}
	});
	$('#build_rapport').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.build_rapport_observation').show();
		}else{
			$('.build_rapport_observation').hide();
		}
	});

	$('#build_rapport').on('change', function(){
		if($(this).val()=='No'){
			$('.build_rapport_observation').show();
			$('#build_rapport_observation').attr('required',true);
			$('#build_rapport_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.build_rapport_observation').hide();
			$('#build_rapport_observation').attr('required',false);
			$('#build_rapport_observation').prop('disabled',true);
		}
	});
	$('#additional_notes').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.additional_notes_observation').show();
		}else{
			$('.additional_notes_observation').hide();
		}
	});

	$('#additional_notes').on('change', function(){
		if($(this).val()=='No'){
			$('.additional_notes_observation').show();
			$('#additional_notes_observation').attr('required',true);
			$('#additional_notes_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.additional_notes_observation').hide();
			$('#additional_notes_observation').attr('required',false);
			$('#additional_notes_observation').prop('disabled',true);
		}
	});
	$('#jargons_slangs').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.jargons_slangs_observation').show();
		}else{
			$('.jargons_slangs_observation').hide();
		}
	});

	$('#jargons_slangs').on('change', function(){
		if($(this).val()=='No'){
			$('.jargons_slangs_observation').show();
			$('#jargons_slangs_observation').attr('required',true);
			$('#jargons_slangs_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.jargons_slangs_observation').hide();
			$('#jargons_slangs_observation').attr('required',false);
			$('#jargons_slangs_observation').prop('disabled',true);
		}
	});
	$('#interruption').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.interruption_observation').show();
		}else{
			$('.interruption_observation').hide();
		}
	});

	$('#interruption').on('change', function(){
		if($(this).val()=='No'){
			$('.interruption_observation').show();
			$('#interruption_observation').attr('required',true);
			$('#interruption_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.interruption_observation').hide();
			$('#interruption_observation').attr('required',false);
			$('#interruption_observation').prop('disabled',true);
		}
	});
	$('#purpose').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.purpose_observation').show();
		}else{
			$('.purpose_observation').hide();
		}
	});

	$('#purpose').on('change', function(){
		if($(this).val()=='No'){
			$('.purpose_observation').show();
			$('#purpose_observation').attr('required',true);
			$('#purpose_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.purpose_observation').hide();
			$('#purpose_observation').attr('required',false);
			$('#purpose_observation').prop('disabled',true);
		}
	});
	$('#Greet').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.Greet_observation').show();
		}else{
			$('.Greet_observation').hide();
		}
	});

	$('#Greet').on('change', function(){
		if($(this).val()=='No'){
			$('.Greet_observation').show();
			$('#Greet_observation').attr('required',true);
			$('#Greet_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.Greet_observation').hide();
			$('#Greet_observation').attr('required',false);
			$('#Greet_observation').prop('disabled',true);
		}
	});
	$('#correct_language').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.correct_language_observation').show();
		}else{
			$('.correct_language_observation').hide();
		}
	});

	$('#correct_language').on('change', function(){
		if($(this).val()=='No'){
			$('.correct_language_observation').show();
			$('#correct_language_observation').attr('required',true);
			$('#correct_language_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.correct_language_observation').hide();
			$('#correct_language_observation').attr('required',false);
			$('#correct_language_observation').prop('disabled',true);
		}
	});
	$('#dead_air').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.dead_air_observation').show();
		}else{
			$('.dead_air_observation').hide();
		}
	});

	$('#dead_air').on('change', function(){
		if($(this).val()=='No'){
			$('.dead_air_observation').show();
			$('#dead_air_observation').attr('required',true);
			$('#dead_air_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.dead_air_observation').hide();
			$('#dead_air_observation').attr('required',false);
			$('#dead_air_observation').prop('disabled',true);
		}
	});
	$('#empathetic').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.empathetic_observation').show();
		}else{
			$('.empathetic_observation').hide();
		}
	});

	$('#empathetic').on('change', function(){
		if($(this).val()=='No'){
			$('.empathetic_observation').show();
			$('#empathetic_observation').attr('required',true);
			$('#empathetic_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.empathetic_observation').hide();
			$('#empathetic_observation').attr('required',false);
			$('#empathetic_observation').prop('disabled',true);
		}
	});
	$('#verbiage').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.verbiage_observation').show();
		}else{
			$('.verbiage_observation').hide();
		}
	});

	$('#verbiage').on('change', function(){
		if($(this).val()=='No'){
			$('.verbiage_observation').show();
			$('#verbiage_observation').attr('required',true);
			$('#verbiage_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.verbiage_observation').hide();
			$('#verbiage_observation').attr('required',false);
			$('#verbiage_observation').prop('disabled',true);
		}
	});
	$('#summarization').each(function(){
		$values=$(this).val();
		if($values=="No"){
			$('.summarization_observation').show();
		}else{
			$('.summarization_observation').hide();
		}
	});

	$('#summarization').on('change', function(){
		if($(this).val()=='No'){
			$('.summarization_observation').show();
			$('#summarization_observation').attr('required',true);
			$('#summarization_observation').prop('disabled',false);
		}else{
			//alert(222);
			$('.summarization_observation').hide();
			$('#summarization_observation').attr('required',false);
			$('#summarization_observation').prop('disabled',true);
		}
	});
	
	
	
	
	
	
	
	</script>