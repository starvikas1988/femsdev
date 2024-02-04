<script type="text/javascript">
$(document).ready(function(){
	
	
$(document).on('change','.wireless',function(){ wireless_score(); });
$(document).on('change','.customer',function(){ wireless_score(); });
$(document).on('change','.business',function(){ wireless_score(); });
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
		
		
	});
	
	$("#form_agent_user").submit(function(e){
		//alert(12);
		$('.waves-effect').prop('disabled',true);
		
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});
	
///////////////// Agent and TL names ///////////////////////
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
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
$('.wireless').each(function(index,element){
	var score_type = $(element).val();
	if(score_type == 'Yes'){
		var w1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'No'){
		var w1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	
	else if(score_type == 'Excellent'){
		var w1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	
	else if(score_type == 'Good'){
		var w1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	else if(score_type == 'Poor'){
		var w1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	
	
	
	else if(score_type == 'N/A'){
		var w1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
});

totScore = ((score*100)/scoreable).toFixed(2);


	$('#earned_score').val(score);
		$('#possible_score').val(scoreable);

		//alert(totScore);

		if($('#rudeness').val()=='Fail' || $('#call_aviodance').val()=='Fail' || $('#improper_won_tagging').val()=='Fail' || $('#infosec_violation').val()=='Fail'){
	        $("#overall_score").val(0);
	  }else{
		if(!isNaN(totScore)){
		$('#overall_score').val(totScore);
	}	
	  }

//////////////// Customer/Business/Compliance //////////////////
var customerScore = 0;
var customerScoreable = 0;
var customerPercentage = 0;
//alert(12345678);

$('.customer').each(function(index,element){
	var sc1 = $(element).val();
	
	
	if(sc1 == 'Yes'){
		var cw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		customerScore = customerScore + cw1;
		customerScoreable = customerScoreable + cw2;
	}else if(sc1 == 'No'){
		var cw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		customerScore = customerScore + cw1;
		customerScoreable = customerScoreable + cw2;
	}else if(sc1 == 'N/A'){
		var cw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		customerScore = customerScore + cw1;
		customerScoreable = customerScoreable + cw2;
	}
});

$('#custAcmEarned').val(customerScore);
$('#custAcmPossible').val(customerScoreable);
customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
if(!isNaN(customerPercentage)){
	$('#custAcmScore').val(customerPercentage+'%');
}
////////////
var businessScore = 0;
var businessScoreable = 0;
var businessPercentage = 0;
$('.business').each(function(index,element){

	var sc2 = $(element).val();
	//alert(sc2);
	if(sc2 == 'Yes'){
		var bw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		businessScore = businessScore + bw1;
		businessScoreable = businessScoreable + bw2;
	}else if(sc2 == 'No'){
		var bw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		businessScore = businessScore + bw1;
		businessScoreable = businessScoreable + bw2;
	}else if(sc2 == 'N/A'){
		var bw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		businessScore = businessScore + bw1;
		businessScoreable = businessScoreable + bw2;
	}
});

$('#busiAcmEarned').val(businessScore);
$('#busiAcmPossible').val(businessScoreable);
businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
if(!isNaN(businessPercentage)){
	$('#busiAcmScore').val(businessPercentage+'%');
}
////////////
var complianceScore = 0;
var complianceScoreable = 0;
var compliancePercentage = 0;
$('.compliance').each(function(index,element){
	var sc3 = $(element).val();
	//alert(sc3);
	if(sc3 == 'Yes'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'No'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'Fail'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'Pass'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'Excellent'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'Good'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'Poor'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'N/A'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('dna_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('dna_max'));
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



</script>



