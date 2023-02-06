<script type="text/javascript">
		function checkDec(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$('#phone').val("");
				return false;
			}
			// if(el.value.length >10){
   //     			alert("required 10 digits, match requested format!");
   //     			return false;
		 //    }
			//console.log(el.value);
		}
</script> 

<script>
 	$(function () {
    $('input[type=file]').change(function () {
        var val = $(this).val().toLowerCase(),
            regex = new RegExp("(.*?)\.(mp3|avi|mp4|wmv|wav)$");

        if (!(regex.test(val))) {
            $(this).val('');
            alert('Please select correct file format');
            return false;
        }
    });
});

   $('#btnViewAgent').click(function(){

    if($.trim($('#from_date').val()) == ''){
      alert('From Date can not be left blank');
      $('#tl_id').focus();
      return false;
   }
   	
   if($.trim($('#to_date').val()) == ''){
      alert('To Date can not be left blank');
      $('#tl_id').focus();
      return false;
   }

});

// $(document).ready(function(){
//     $("#qaformsubmit").on('submit',function(e){
//     	e.preventDefault();
//         if($.trim($('#tl_id').val()) == ''){
//       alert('L1 Supervisor can not be left blank');
//       $('#tl_id').focus();
//       return false;
//    }

//     });
// });     
</script>

<script type="text/javascript">
//////////purity extra function////////////////////
function totalcal(val=null){

	var sum = 0;
	var sum1 = 0;
	var sum2 = 0;
	var count=0;
	var earned_score=0;
	var scoreable=0;

	$('.call_one_comm').each(function(){
	    sum += parseFloat($(this).val());
	    count++;
	});

	$('.call_two_comm').each(function(){
	    sum1 += parseFloat($(this).val());
	    count++;
	});

	$('.call_three_comm').each(function(){
	    sum2 += parseFloat($(this).val());
	    count++;
	});

	if($("select[name='call_one_correct_use_of_action']").val()==0 || $("select[name='call_one_proper_confirmation']").val()==0 || $("select[name='call_one_badgering']").val()==0){
		sum=0;
	}

	if($("select[name='call_two_correct_use_of_action']").val()==0 || $("select[name='call_two_proper_confirmation']").val()==0 || $("select[name='call_two_badgering']").val()==0){
		sum1=0;
	}

	if($("select[name='call_three_correct_use_of_action']").val()==0 || $("select[name='call_three_proper_confirmation']").val()==0 || $("select[name='call_three_badgering']").val()==0){
		sum2=0;
	}

	earned_score=sum+sum1+sum2;
	scoreable=count;
	var quality_score_percent = ((earned_score*100)/scoreable).toFixed(2);

	$('#fb_earnedScorePurity').val(earned_score);
	$('#fb_possibleScorePurity').val(scoreable);

	if(!isNaN(quality_score_percent)){
		$('#fb_overallScorePurity').val(quality_score_percent+'%');
	}

	}

function docusign_calc(){

		var scoreable=0;
		var sec1score=0;
		var sec2score=0;
		var sec3score=0;
		var sec4score=0;
		var sec1scoreable=0;
		var sec2scoreable=0;
		var sec3scoreable=0;
		var sec4scoreable=0;

		$('.sec1').each(function(index,element){
			let score_type = $(element).val();
			let weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				if(score_type == 10){
				    sec1score=sec1score + weightage;
					sec1scoreable = sec1scoreable + weightage;
				}else if(score_type == 5){
				    sec1score=sec1score + (weightage/weightage);
					sec1scoreable = sec1scoreable + weightage;
				}else{
				    sec1score=0;
					sec1scoreable = sec1scoreable + weightage;
				}

		});

		$('.sec2').each(function(index,element){
			let score_type = $(element).val();
			let weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				if(score_type == 10){
				    sec2score=sec2score + weightage;
					sec2scoreable = sec2scoreable + weightage;
				}else if(score_type == 5){
				    sec2score=sec2score + (weightage/weightage);
					sec2scoreable = sec2scoreable + weightage;
				}else if(score_type == 1){
				    sec2score=0;
					sec2scoreable = sec2scoreable + weightage;
				}
		});

		$('.sec3').each(function(index,element){
			let score_type = $(element).val();
			let weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				if(score_type == 10){
				    sec3score=sec3score + weightage;
					sec3scoreable = sec3scoreable + weightage;
				}else if(score_type == 5){
				    sec3score=sec3score + (weightage/weightage);
					sec3scoreable = sec3scoreable + weightage;
				}else{
				    sec3score=0;
					sec3scoreable = sec3scoreable + weightage;
				}
		});

		$('.sec4').each(function(index,element){
			let score_type = $(element).val();
			let weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				if(score_type == "YES"){
			    	sec4score=sec4score + weightage;
					sec4scoreable = sec4scoreable + weightage;
				}else if(score_type == "NO"){
				    sec4score=0;
					sec4scoreable = sec4scoreable + weightage;
				}
		});

		$('.sec1').each(function(){
			let valNum=$(this).val();
			if(valNum == 1){
				sec1score=0;
				$('#sec1_Text').text("NO");
				$('#sec1_Total').text(0+"%");
			}else{
				if(sec1score!=0){
					$('#sec1_Text').text("YES");
					$('#sec1_Total').text(((sec1score*100)/sec1scoreable).toFixed(2)+"%");
				}
			}
		});

		$('.sec2').each(function(){
			let valNum=$(this).val();
			if(valNum == 1){
				sec2score=0;
				$('#sec2_Text').text("NO");
				$('#sec2_Total').text(0+"%");
			}else{
				if(sec2score!=0){
					$('#sec2_Text').text("YES");
					$('#sec2_Total').text(((sec2score*100)/sec2scoreable).toFixed(2)+"%");
				}
			}
		});

		$('.sec3').each(function(){
			let valNum=$(this).val();
			if(valNum == 1){
				sec3score=0;
				$('#sec3_Text').text("NO");
				$('#sec3_Total').text(0+"%");
			}else{
				if(sec3score!=0){
					$('#sec3_Text').text("YES");
					$('#sec3_Total').text(((sec3score*100)/sec3scoreable).toFixed(2)+"%");
				}
			}
		});

		$('.sec4').each(function(){
			let valNum=$(this).val();
			if(valNum == "NO"){
				sec4score=0;
				$('#sec4_Text').text("NO");
				$('#sec4_Total').text(0+"%");
			}else{
				if(sec4score!=0){
					$('#sec4_Text').text("YES");
					$('#sec4_Total').text(((sec4score*100)/sec4scoreable).toFixed(2)+"%");
				}
			}
		});

		score = parseInt(sec1score)+parseInt(sec2score)+parseInt(sec3score)+parseInt(sec4score);
		scoreable = parseInt(sec1scoreable)+parseInt(sec2scoreable)+parseInt(sec3scoreable)+parseInt(sec4scoreable);

		let quality_score_percent=((score*100)/scoreable).toFixed(2);

		$('#sontiq_earnedScore').val(score);
		$('#sontiq_possibleScore').val(scoreable);

		$('#sontiq_overallScore').val(quality_score_percent+'%').css( "background", "#eee" );


	}

docusign_calc();

function view(){
	var name=[];
	var i = 0;
	var dup=0;
	$('.points').each(function(){
		name[i++]=$(this).data('name');
	});

	for(var x=0;x<i;x++){
	if(name[x]!=""){
		if(name[x]==dup){
			continue;
		}else{
		var score=0;
		var	name1=name[x];
		$("."+name1).each(function(){
			if($(this).val() == 0)
			{
				score	+=	0;
			}
			else
			{
				score	+=	parseInt($(this).val());
			}
		});
			$("input[name='review_"+name1+"']").val(score);
			$("input[name='score_"+name1+"']").val(score);
			possible_val(name1);
		}
	}
	dup=name[x];
	}
}

function possible_val(name){
	var possible_score=0;
	possible_score_name		=	$("input[name='score_"+name+"']").attr("class").substr(13);
	$("."+possible_score_name).each(function(){
			if($(this).val() == 0)
			{
				possible_score	+=	0;
			}
			else
			{
				possible_score	+=	parseInt($(this).val());
			}
		});
	$("input[name='"+possible_score_name+"']").val(possible_score);
}

function total_view(){
	var sum = 0;
	var sum1 = 0;
	var sum2 = 0;

	$('.call_one_comm').each(function(){
	    sum += parseFloat($(this).val());

	});

	$('.call_two_comm').each(function(){
	    sum1 += parseFloat($(this).val());
	});

	$('.call_three_comm').each(function(){
	    sum2 += parseFloat($(this).val());
	});

	if($("select[name='call_one_correct_use_of_action']").val()==0 || $("select[name='call_one_proper_confirmation']").val()==0 || $("select[name='call_one_badgering']").val()==0){
		sum=0;
	}

	if($("select[name='call_two_correct_use_of_action']").val()==0 || $("select[name='call_two_proper_confirmation']").val()==0 || $("select[name='call_two_badgering']").val()==0){
		sum1=0;
	}

	if($("select[name='call_three_correct_use_of_action']").val()==0 || $("select[name='call_three_proper_confirmation']").val()==0 || $("select[name='call_three_badgering']").val()==0){
		sum2=0;
	}

	$('#fb_call_one_total').val(sum);
	$('#fb_call_two_total').val(sum1);
	$('#fb_call_three_total').val(sum2);
}

totalcal();
view();
total_view();

//////////purity extra function////////////////////



$(document).ready(function(){

	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	$("#agent_id").select2();


///////////////// Calibration - Auditor Type ///////////////////////
	// $('.auType').hide();

	// $('#audit_type').on('change', function(){
	// 	if($(this).val()=='Calibration'){
	// 		$('.auType').show();
	// 		$('#auditor_type').attr('required',true);
	// 		$('#auditor_type').prop('disabled',false);
	// 	}else{
	// 		$('.auType').hide();
	// 		$('#auditor_type').attr('required',false);
	// 		$('#auditor_type').prop('disabled',true);
	// 	}
	// });

///////////////// Calibration - Auditor Type ///////////////////////	
$('.auType').hide();
	if($("#audit_type").val() == "Calibration"){
		$('.auType').show();
		$('#auditor_type').attr('required',true);
		$('#auditor_type').prop('disabled',false);
	}
	//console.log(`OnLoad -> ${$("#auditor_type").val()}`)
	$('#audit_type').on('change', function(){
		
		if($(this).val()=='Calibration'){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);

		} else{
			$('.auType').hide();
			$('#auditor_type').val("")
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
			// $('#auditor_type').val('');
		}
	//	console.log(`OnChange -> ${$("#auditor_type").val()}`)
	});		

//////////////////////////complaince////////////////////////
	$('.compliance').hide();

	$('#compliance_type').on('change', function(){
		if($(this).val()=='Yes'){
			$('.auType').show();
			$('#issue_type').attr('required',true);
			$('#reason_type').attr('required',true);
			$('#issue_type').prop('disabled',false);
			$('#reason_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#issue_type').attr('required',false);
			$('#reason_type').attr('required',false);
			$('#issue_type').prop('disabled',true);
			$('#reason_type').prop('disabled',true);
		}
	});

	// $('.compliance_reason').hide();

	// $('#blank_compliance').on('change', function(){
	// 	if($(this).val()=='no_voice'){
	// 		$('.auType').show();
	// 		$('#no_voice').attr('required',true);
	// 		$('#no_voice').prop('disabled',false);
	// 	}else{
	// 		$('.auType').hide();
	// 		$('#no_voice').attr('required',false);
	// 		$('#no_voice').prop('disabled',true);
	// 	}
	// });

///////////////////////////////////////////////////////////////




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

//////////////// After Submit Form Disabled //////////////////////
	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});

	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});

	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});
//////////////////////////////////////////////////////////////////////////////////

////////////////////////// SONTIQ //////////////////////////////////

$(".sec1").on("change",function(){
		docusign_calc();
	});

	$(".sec2").on("change",function(){
		docusign_calc();
	});

	$(".sec3").on("change",function(){
		docusign_calc();
	});

	$(".sec4").on("change",function(){
		docusign_calc();
	});

	docusign_calc();

////////////////////////// ALL AD File///////////////////////////////
	$(document).on('change','.amd_point',function(){
		fb_calculation();
	});

	$(document).on('change','.points_epi',function(){
		fb_calculation();
	});

	$(document).on('change','.points_blains',function(){
		fb_calculation();
	});

	$(document).on('change','.points_delta',function(){
		fb_calculation();
	});

	$(document).on('change','.points_fatal',function(){
		fb_calculation();
	});

	$(document).on('change','.points_fatal_brightway',function(){
		fb_calculation();
	});

	fb_calculation();

///*************** NUWAVE ****************///
	$('#autofNW_infractions').on('change', function(){
		if($(this).val()=='Yes'){
			var sub_infractions = '<option value="Unprofessional Behaviour on call">Unprofessional Behaviour on call</option>';
			sub_infractions += '<option value="Guidelines/Procedure/Policy not adhered">Guidelines/Procedure/Policy not adhered</option>';
			sub_infractions += '<option value="Lack of process knowledge">Lack of process knowledge</option>';
			sub_infractions += '<option value="Lack of Customer retention effort">Lack of Customer retention effort</option>';
			sub_infractions += '<option value="Improper Documentation/Customer profiling/Notes">Improper Documentation/Customer profiling/Notes</option>';
			sub_infractions += '<option value="Misguiding customer">Misguiding customer</option>';
			sub_infractions += '<option value="Improper Information conveyed">Improper Information conveyed</option>';
			sub_infractions += '<option value="Mandatory Information">Mandatory Information</option>';
			sub_infractions += '<option value="Incorrect Commitment">Incorrect Commitment</option>';
			$("#sub_infractions").html(sub_infractions);
		}else{
			$("#sub_infractions").html('');
		}
	});

/*****************************************************/
/*********************** Purity Care *****************/
/*****************************************************/
$("#call_one_call_duration").timepicker({timeFormat : 'HH:mm:ss' });
$("#call_two_call_duration").timepicker({timeFormat : 'HH:mm:ss' });
$("#call_three_call_duration").timepicker({timeFormat : 'HH:mm:ss' });
$(".points").on("change",function(){
		var score 					=	0;
		var possible_score			=	0;
		var earned_score 			=	0;
		var scoreable 				= 	0;
		var quality_score_percent 	= 	0;
		var name			=	$(this).data("name");

		$("."+name).each(function(){
			if($(this).val() == 0)
			{
				score	+=	0;
			}
			else
			{
				score	+=	parseInt($(this).val());
			}
		});
		$("input[name='review_"+name+"']").val(score);
		$("input[name='score_"+name+"']").val(score);
		possible_score_name		=	$("input[name='score_"+name+"']").attr("class").substr(13);
		$("."+possible_score_name).each(function(){
			if($(this).val() == 0)
			{
				possible_score	+=	0;
			}
			else
			{
				possible_score	+=	parseInt($(this).val());
			}
		});
		$("input[name='"+possible_score_name+"']").val(possible_score);
		$('.points').each(function(index,element){

			if($(this).val() == 0)
			{
				var weightage	=	0;
			}
			else
			{
				var weightage	=	1;
				scoreable = scoreable + weightage;
				earned_score = earned_score + parseInt($(this).val());
			}
		});

		quality_score_percent = ((earned_score*100)/scoreable).toFixed(2);
		  if($("#call_one_call_duration").val() != "" && $("#call_two_call_duration").val() != "" && $("#call_three_call_duration").val() != "" && $("#call_one_file_no").val() != "" && $("#call_two_file_no").val() != "" && $("#call_three_file_no").val() != "")
		  {
			totalcal();

		 }
		 total_view();
	});
});
</script>
<?php
if(isset($call_data['agent_id']) && $call_data['agent_id'] != '')
{?>
	<script>
	$(document).ready(function(){
		var aid = "<?php echo isset($call_data['agent_id'])?$call_data['agent_id']:'';?>";
		if(aid!="")
		{
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
		}
	});
	</script>
<?php
}
?>

<script>

function acm_score(){

var score = 0;
var scoreable = 0;
var quality_score_percent = 0;
$('.acm_points').each(function(index,element){
	var score_type = $(element).val();
	if(score_type == 'Yes'){
		var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var w2 = parseInt($(element).children("option:selected").attr('acm_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'No'){
		var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var w2 = parseInt($(element).children("option:selected").attr('acm_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'N/A'){
		var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var w2 = parseInt($(element).children("option:selected").attr('acm_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
});
quality_score_percent = ((score*100)/scoreable).toFixed(2);

$('#acm_earn_score').val(score);
$('#acm_possible_score').val(scoreable);

if(!isNaN(quality_score_percent)){
	$('#acm_overall_score').val(quality_score_percent+'%');
}

if($('#acmAF1').val()=='No' || $('#acmAF2').val()=='No' || $('#acmAF3').val()=='Yes' || $('#acmAF4').val()=='Yes' ){
	$('.acmFatal').val(0);
}else{
	$('.acmFatal').val(quality_score_percent+'%');
}

//////////////// Customer/Business/Compliance //////////////////
var customerScore = 0;
var customerScoreable = 0;
var customerPercentage = 0;
$('.customer').each(function(index,element){
	var sc1 = $(element).val();
	if(sc1 == 'Yes'){
		var cw1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var cw2 = parseInt($(element).children("option:selected").attr('acm_max'));
		customerScore = customerScore + cw1;
		customerScoreable = customerScoreable + cw2;
	}else if(sc1 == 'No'){
		var cw1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var cw2 = parseInt($(element).children("option:selected").attr('acm_max'));
		customerScore = customerScore + cw1;
		customerScoreable = customerScoreable + cw2;
	}else if(sc1 == 'N/A'){
		var cw1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var cw2 = parseInt($(element).children("option:selected").attr('acm_max'));
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
	if(sc2 == 'Yes'){
		var bw1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var bw2 = parseInt($(element).children("option:selected").attr('acm_max'));
		businessScore = businessScore + bw1;
		businessScoreable = businessScoreable + bw2;
	}else if(sc2 == 'No'){
		var bw1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var bw2 = parseInt($(element).children("option:selected").attr('acm_max'));
		businessScore = businessScore + bw1;
		businessScoreable = businessScoreable + bw2;
	}else if(sc2 == 'N/A'){
		var bw1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var bw2 = parseInt($(element).children("option:selected").attr('acm_max'));
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
$('.compliance01').each(function(index,element){
	var sc3 = $(element).val();
	if(sc3 == 'Yes'){
		var cpw1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var cpw2 = parseInt($(element).children("option:selected").attr('acm_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'No'){
		var cpw1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var cpw2 = parseInt($(element).children("option:selected").attr('acm_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'N/A'){
		var cpw1 = parseInt($(element).children("option:selected").attr('acm_val'));
		var cpw2 = parseInt($(element).children("option:selected").attr('acm_max'));
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


$(document).ready(function(){
$(document).on('change','.acm_points',function(){ acm_score(); });
$(document).on('change','.customer',function(){ acm_score(); });
$(document).on('change','.business',function(){ acm_score(); });
$(document).on('change','.compliance',function(){ acm_score(); });
acm_score();
});




	////////////////Empire score///////////////////

// function empire_score(){

// var score = 0;
// var scoreable = 0;
// var quality_score_percent = 0;
// $('.empire_points').each(function(index,element){

// 	var score_type = $(element).val();
//         if (score_type == 'Yes') {
//             var weightage = parseInt($(element).children("option:selected").attr('amd_val'));
//             score = score + weightage;
//             scoreable = scoreable + weightage;
//         } else if (score_type == 'No') {
//             var weightage = parseInt($(element).children("option:selected").attr('amd_val'));
//             scoreable = scoreable + weightage;
//         } else if (score_type == 'N/A') {
//             var weightage = parseInt($(element).children("option:selected").attr('amd_val'));
//             score = score + weightage;
//             scoreable = scoreable + weightage;
//         }
// });

// 		quality_score_percent = ((score*100)/scoreable).toFixed(2);

// 		$('#empire_earn_score').val(score);
// 		$('#empire_possible_score').val(scoreable);

// 		if(!isNaN(quality_score_percent)){
// 			$('#empire_overall_score').val(quality_score_percent+'%');
// 		}

// 		if($('#condtAF1').val()=='No' || $('#condtAF2').val()=='Yes' || $('#condtAF3').val()=='No' || $('#condtAF4').val()=='No' || $('#condtAF5').val()=='NO' || $('#condtAF6').val()=='No' || $('#condtAF7').val()=='No' || $('#condtAF8').val()=='No'){
// 			$('.conduentFatal').val(0);
// 		}else{
// 			$('.conduentFatal').val(quality_score_percent+'%');
// 		}



// 	}


// 		$(document).ready(function(){
// 		$(document).on('change','.empire_points',function(){ empire_score(); });
// 		empire_score();
// });

////////////////Conduent score brains///////////////////

function conduent_score(){

var score = 0;
var scoreable = 0;
var quality_score_percent = 0;
$('.conduent_points').each(function(index,element){

	var score_type = $(element).val();
        if (score_type == 'Yes' || score_type == 'Effective' || score_type == 'Pass') {
            var weightage = parseFloat($(element).children("option:selected").attr('acm_val'));
            score = score + weightage;
            scoreable = scoreable + weightage;
        } else if (score_type == 'No' || score_type == 'Unacceptable' || score_type == 'Fail') {
            var weightage = parseFloat($(element).children("option:selected").attr('acm_val'));
            scoreable = scoreable + weightage;
        } else if (score_type == 'N/A') {
            var weightage = parseFloat($(element).children("option:selected").attr('acm_val'));
            score = score + weightage;
            scoreable = scoreable + weightage;
        }
	});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#conduent_earn_score').val(score);
		$('#conduent_possible_score').val(scoreable);

		if(!isNaN(quality_score_percent)){
			$('#conduent_overall_score').val(quality_score_percent+'%');
		}

		if($('#condtAF1').val()=='No' || $('#condtAF2').val()=='No' || $('#condtAF3').val()=='No' || $('#condtAF4').val()=='No' || $('#condtAF5').val()=='NO' || $('#condtAF6').val()=='No' || $('#condtAF7').val()=='No' || $('#condtAF8').val()=='No' || $('#condtAFbtl2').val()=='Yes' || $('#condtAFbtl3').val()=='Yes' || $('#hovBR1').val()=='Fail' || $('#hovBR2').val()=='Fail'){
			$('.conduentFatal').val(0);
		}else{
			$('.conduentFatal').val(quality_score_percent+'%');
		}
	/////////////
		if($('#hovAF1').val()=='Fail' || $('#hovAF2').val()=='Fail' || $('#hovAF3').val()=='Fail' || $('#hovAF4').val()=='Fail'){
			$('.hoveroundFatal').val(0);
		}else{
			$('.hoveroundFatal').val(quality_score_percent+'%');
		}

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		var sc1 = '';
		var sc2 = '';
		var sc3 = '';
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				
				var w1 = parseFloat($(element).children("option:selected").attr('acm_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseFloat($(element).children("option:selected").attr('acm_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('acm_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custlockEarned').val(customerScore);
		$('#custlockPossible').val(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#custlockScore').val(customerPercentage+'%');
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseFloat($(element).children("option:selected").attr('acm_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseFloat($(element).children("option:selected").attr('acm_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('acm_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busilockEarned').val(businessScore);
		$('#busilockPossible').val(businessScoreable);
		// console.log(businessScore);
		// console.log(businessScoreable);
		// console.log(sc2);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busilockScore').val(businessPercentage+'%');
		}

		
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance_round').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseFloat($(element).children("option:selected").attr('acm_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'Pass'){
				var w3 = parseFloat($(element).children("option:selected").attr('acm_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
			else if(sc3 == 'No'){
				var w3 = parseFloat($(element).children("option:selected").attr('acm_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'Fail'){
				var w1 = parseFloat($(element).children("option:selected").attr('acm_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc3 == 'N/A'){
				var w3 = parseFloat($(element).children("option:selected").attr('acm_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#compllockEarned').val(complianceScore);
		$('#compllockPossible').val(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#compllockScore').val(compliancePercentage+'%');
		}

	}

	



	$(document).ready(function(){
		
		$(document).on('change','.conduent_points',function(){ 
			conduent_score(); 
		});
		$(document).on('change','.customer',function(){
			conduent_score();
		});
		$(document).on('change','.business',function(){
			conduent_score();
		});
		$(document).on('change','.compliance_round',function(){
			conduent_score();
		});
		conduent_score();
		
	});

/////////////////////////Blains Score////////////////////////////////


// function aspca_calc() {

// var score = 0;
// var scoreable = 0;
// var quality_score_percent = 0;

// $('.aspca_point').each(function(index, element) {
// 	var score_type = $(element).val();
// 	if (score_type == 'Yes') {
	
// 		var weightage = parseFloat($(element).children("option:selected").attr('aspca_val'));
// 		score = score + weightage;
// 		scoreable = scoreable + weightage;
		
// 	} else if (score_type == 'No' ) {
// 		if( $('#aspcaAF3').val() == 'No' || $('#aspcaAF4').val() == 'No'){
// 			var weightage = parseFloat($(element).children("option:selected").attr('aspca_val'));
// 			score = score + weightage;
// 		}
// 		var weightage = parseFloat($(element).children("option:selected").attr('aspca_val'));
// 		//score = score + weightage;
// 		scoreable = scoreable + weightage;
// 	} else if (score_type == 'N/A') {
// 		var weightage = parseFloat($(element).children("option:selected").attr('aspca_val'));
// 		score = score + weightage;
// 		scoreable = scoreable + weightage;
// 	}
// });
// if( $('#aspcaAF3').val() == 'Yes' ){
// 			var weightage = parseFloat($('#aspcaAF3 option[value="Yes"]').attr('aspca_val'));
// 			score = score - weightage;
// 		}
// if( $('#aspcaAF4').val() == 'Yes'){
// 			var weightage = parseFloat($('#aspcaAF4 option[value="Yes"]').attr('aspca_val'));
// 			score = score - weightage;
// }		
// quality_score_percent = ((score * 100) / scoreable).toFixed(2);

// $('#aspca_earned').val(score);
// $('#aspca_possible').val(scoreable);

// if (!isNaN(quality_score_percent)) {
// 	$('#aspca_overall_score').val(quality_score_percent + '%');
// }
// // if($('#stratuscsr1').val() == 'No'){
// // 	$('#stratus_overall_score').val(0);
// // 	}else{
// // 		if(!isNaN(quality_score_percent)){
// // 			$('#stratus_overall_score').val(quality_score_percent + '%');
// // 		}	
// // 	}
// ////////////////Fatal  Score ///////////////////
// if ($('#aspcaAF1').val() == 'No' || $('#aspcaAF2').val() == 'No' || $('#aspcaAF3').val() == 'Yes' || $('#aspcaAF4').val() == 'Yes') {
// 	$('.aspca_overall_fatalscore').val(0);
// } else {
// 	$('.aspca_overall_fatalscore').val(quality_score_percent+'%');
   
// }

// //////////////////////////////
// 	var compliancescore = 0;
// 	var compliancescoreable = 0;
// 	var compliance_score_percent = 0;
// 	var customerscore = 0;
// 	var customerscoreable = 0;
// 	var customer_score_percent = 0;
// 	var businessscore = 0;
// 	var businessscoreable = 0;
// 	var business_score_percent = 0;
	
// 	$('.compliance01').each(function(index,element){
// 		var score_type1 = $(element).val();
		
// 		if(score_type1 == 'Yes'){
// 			var weightage1 = parseInt($(element).children("option:selected").attr('aspca_val'));
// 			compliancescore = compliancescore + weightage1;
// 			compliancescoreable = compliancescoreable + weightage1;
// 		}else if(score_type1 == 'No'){
// 			var weightage1 = parseInt($(element).children("option:selected").attr('aspca_val'));
// 			compliancescoreable = compliancescoreable + weightage1;
// 		}else if(score_type1 == 'N/A'){
// 			var weightage1 = parseInt($(element).children("option:selected").attr('aspca_val'));
// 			compliancescore = compliancescore + weightage1;
// 			compliancescoreable = compliancescoreable + weightage1;
// 		}
// 	});
// 	if( $('#aspcaAF3').val() == 'Yes' ){
// 			var weightage1 = parseFloat($('#aspcaAF3 option[value="Yes"]').attr('aspca_val'));
// 			compliancescore = compliancescore - weightage1;
// 		}
// 	if( $('#aspcaAF3').val() == 'Yes' ){
// 			var weightage1 = parseFloat($('#aspcaAF3 option[value="Yes"]').attr('aspca_val'));
// 			compliancescore = compliancescore - weightage1;
// 		}
// 	compliance_score_percent = ((compliancescore*100)/compliancescoreable).toFixed(2);
// 	$('#compliancescore').val(compliancescore);
// 	$('#compliancescoreable').val(compliancescoreable);
// 	$('#compliance_score_percent').val(compliance_score_percent+'%');
// //////////////
// 	$('.customer').each(function(index,element){
// 		var score_type2 = $(element).val();
		
// 		if(score_type2 == 'Yes'){
// 			var weightage2 = parseInt($(element).children("option:selected").attr('aspca_val'));
// 			customerscore = customerscore + weightage2;
// 			customerscoreable = customerscoreable + weightage2;
// 		}else if(score_type2 == 'No'){
// 			var weightage2 = parseInt($(element).children("option:selected").attr('aspca_val'));
// 			customerscoreable = customerscoreable + weightage2;
// 		}else if(score_type2 == 'N/A'){
// 			var weightage2 = parseInt($(element).children("option:selected").attr('aspca_val'));
// 			customerscore = customerscore + weightage2;
// 			customerscoreable = customerscoreable + weightage2;
// 		}
// 	});
// 	customer_score_percent = ((customerscore*100)/customerscoreable).toFixed(2);
// 	$('#customerscore').val(customerscore);
// 	$('#customerscoreable').val(customerscoreable);
// 	$('#customer_score_percent').val(customer_score_percent+'%');
// //////////////
// 	$('.business').each(function(index,element){
// 		var score_type3 = $(element).val();
		
// 		if(score_type3 == 'Yes'){
// 			var weightage3 = parseInt($(element).children("option:selected").attr('aspca_val'));
// 			businessscore = businessscore + weightage3;
// 			businessscoreable = businessscoreable + weightage3;
// 		}else if(score_type3 == 'No'){
// 			var weightage3 = parseInt($(element).children("option:selected").attr('aspca_val'));
// 			businessscoreable = businessscoreable + weightage3;
// 		}else if(score_type3 == 'N/A'){
// 			var weightage3 = parseInt($(element).children("option:selected").attr('aspca_val'));
// 			businessscore = businessscore + weightage3;
// 			businessscoreable = businessscoreable + weightage3;
// 		}
// 	});
// 	business_score_percent = ((businessscore*100)/businessscoreable).toFixed(2);
// 	$('#businessscore').val(businessscore);
// 	$('#businessscoreable').val(businessscoreable);
// 	$('#business_score_percent').val(business_score_percent+'%');

// }
// $(document).on('change', '.aspca_point', function() {
// aspca_calc();
// });
// aspca_calc();
</script>
<script type="text/javascript">

////////////////////// ALL AD Calculation (Start) ///////////////////////////////////
	function fb_calculation(){
		var score = 0;
		var scoreable = 0;
		let comp_score =0;
		let busi_score =0;
		let cust_score =0;
		var fail="";
		var quality_score_percent = 0;

		var amd_fatal=false;

		$('.amd_point').each(function(index,element){
			var score_type = $(element).val();

			if($(element).hasClass("amd_fatal")){
				if($(element).val()=="Yes"){
					amd_fatal=true;
				}
			}else{
				if($(element).hasClass("soft_skills")){
					if(score_type == 'Effective with errors' || score_type == 'Effective'){
						var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
						score = score + weightage;
						scoreable = scoreable + parseFloat($(element).children("option:selected").attr('amd_max'));
					}else if(score_type == 'No' || score_type == 'Unacceptable'){
						var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
						scoreable = scoreable + parseFloat($(element).children("option:selected").attr('amd_max'));
					}else if(score_type == 'N/A'){
						var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
						score = score + weightage;
						scoreable = scoreable + weightage;
					}
				}else{
					if(score_type == 'Yes' || score_type == 'Effective'){
						var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
						score = score + weightage;
						scoreable = scoreable + weightage;
					}else if(score_type == 'No' || score_type == 'Unacceptable'){
						var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
						scoreable = scoreable + weightage;
					}else if(score_type == 'N/A'){
						var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
						score = score + weightage;
						scoreable = scoreable + weightage;
					}
				}

				

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Effective' || sc1 == 'Yes'){
				var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
				
			}else if(sc1 == 'Unacceptable' || sc1 == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
				customerScoreable = customerScoreable + w1;
				
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
				
			}
		});
		$('#custJiCisEarned').val(customerScore);
		$('#custJiCisPossible').val(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#custJiCisScore').val(customerPercentage+'%');
		}

		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Effective' || sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('amd_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
				
			}else if(sc2 == 'Unacceptable' || sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('amd_val'));
				businessScoreable = businessScoreable + w2;
				
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('amd_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
				
			}
		});
		$('#busiJiCisEarned').val(businessScore);
		$('#busiJiCisPossible').val(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busiJiCisScore').val(businessPercentage+'%');
		}

		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance1').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Effective' || sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('amd_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
				
			}else if(sc3 == 'Unacceptable' || sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('amd_val'));
				complianceScoreable = complianceScoreable + w3;
				
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('amd_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
				
			}
		});
		$('#complJiCisEarned').val(complianceScore);
		$('#complJiCisPossible').val(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complJiCisScore').val(compliancePercentage+'%');
		}

		}

		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#fb_earnedScore').val(score);
		$('#fb_possibleScore').val(scoreable);

		if(($('#hovBR1').val()=='Fail') || $('#hovBR2').val()=='Fail'){
		$('#fb_overallScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#fb_overallScore').val(quality_score_percent+'%');
			}	
		}

		if(!isNaN(quality_score_percent)){
			$('#fb_overallScore').val(quality_score_percent+'%');
		}





/////////////////////////////Riya (Health Bridge)/////////////////////////////////////

		$('.healthbridge_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Exceeds'){
			    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val'));
			    var max_wght = parseFloat($(element).children("option:selected").attr('healthbridge_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'Meets'){
			    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('healthbridge_max_val'));
				score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'Needs'){
			    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('healthbridge_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'Yes'){max_wght
			    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('healthbridge_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('healthbridge_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'Good'){
			    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('healthbridge_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'Bad'){
			    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('healthbridge_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'Average'){
			    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('healthbridge_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'NA'){
			    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('healthbridge_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}
		});


		$('.compliance_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('compliance_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('compliance_val'));
			    scoreable = scoreable + weightage;
			}
		});

		// $('.healthbridge_point1').each(function(index,element){
		// 	var score_type = $(element).val();
		// 	if(score_type == 'Yes'){
		// 	    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val1'));
		// 	    score = score + weightage;
		// 	    scoreable = scoreable + weightage;
		// 	}else if(score_type == 'No'){
		// 	    var weightage = parseFloat($(element).children("option:selected").attr('healthbridge_val1'));
		// 	    scoreable = scoreable + weightage;
		// 	}
		// });


//////////////////////////////////////////////////////////////////////////////////////

		$('.points_epi').each(function(index,element){
			var score_type = $(element).val();

			if(score_type == 'Awesome'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Average'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				score = score + (weightage-1);
				scoreable = scoreable + weightage;
			}else if(score_type == 'Action Needed'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				score = score + (weightage-2);
				scoreable = scoreable + weightage;
			}else if(score_type == 'Absent'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});

		// $('.points_blains').each(function(index,element){
		// 	var score_type = $(element).val();

		// 	if(score_type == 'Yes'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
		// 		score = score + weightage;
		// 		scoreable = scoreable + weightage;
		// 	}else if(score_type == 'No'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
		// 		scoreable = scoreable + weightage;
		// 	}else if(score_type == 'N/A'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
		// 		score = score + weightage;
		// 		scoreable = scoreable + weightage;
		// 	}
		// });

		

		$('.busi_score').each(function(index,element){
			let score_type = $(element).val();
			let weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
			if(score_type == "YES"){
				score = score + weightage;
				scoreable = scoreable + weightage;
			    busi_score=busi_score + weightage;
			}else if(score_type == "NO"){
				scoreable = scoreable + weightage;
			}
		});

		$('.cust_score').each(function(index,element){
			let score_type = $(element).val();
			let weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
			if(score_type == "YES"){
				score = score + weightage;
				scoreable = scoreable + weightage;
			    cust_score=cust_score + weightage;
			}else if(score_type == "NO"){
				scoreable = scoreable + weightage;
			}
		});

		$('.comp_score').each(function(index,element){
			let score_type = $(element).val();
			let weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
			if(score_type == "YES"){
				score = score + weightage;
				scoreable = scoreable + weightage;
			    comp_score=comp_score + weightage;
			}else if(score_type == "NO"){
				scoreable = scoreable + weightage;
			}
		});

		// $('.points_delta').each(function(index,element){
		// 	var score_type = $(element).val();

		// 	if(score_type == 'Effective'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
		// 		score = score + weightage;
		// 		scoreable = scoreable + weightage;
		// 	}else if(score_type == 'Unacceptable'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
		// 		scoreable = scoreable + weightage;
		// 	}
		// });

		$(".points_fatal").each(function(){
		valNum=$(this).val();
		if(valNum == "Yes" || valNum == "Unacceptable" || valNum == "Fail"){
		score=0;
		return false;
		}
		});

		$(".points_fatal_brightway").each(function(){
		valNum=$(this).val();
		if(valNum == "No"){
		score=0;
		}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#fb_earnedScore').val(score);
		$('#fb_possibleScore').val(scoreable);

		if(!isNaN(quality_score_percent)){
			$('#fb_overallScore').val(quality_score_percent+'%');
			if(fail){
				$('#overallScore').val(quality_score_percent+'%').css( "background", "red" );;
			}else{
				$('#overallScore').val(quality_score_percent+'%').css( "background", "#eee" );
			}
		}

		if(!amd_fatal){
			$("#fb_overallScore_amd").val(quality_score_percent+"%");
		}else{
			$("#fb_overallScore_amd").val("0%");
		}

		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		$('#busiScore').val(busi_score);
		$('#custScore').val(cust_score);
		$('#compScore').val(comp_score);

///////////////////////Riya (Health Bridge)////////////////////////////////

		$('#healthbridge_earned').val(score);
		$('#healthbridge_possible').val(scoreable);


		if($('#fatal1').val()=='No' || $('#fatal2').val()=='No' || $('#fatal3').val()=='No' || $('#fatal4').val()=='Yes' || $('#fatal5').val()=='Yes' ){
			$('#healthbridge_overall_score').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#healthbridge_overall_score').val(quality_score_percent+'%');
			}
		}
/////////////////////Compliance/////////////////////////////////////////

		$('#compliance_earned').val(score);
		$('#compliance_possible').val(scoreable);


		if($('#compliance_type').val()=='No' ){
			$('#compliance_overall_score').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#compliance_overall_score').val(quality_score_percent+'%');
			}
		}


///////////////////////////Riya End///////////////////////////////////////////////

		if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}

	/*----- purity free bottle -----*/
		if($('#pfb_autof1').val()=='No' || $('#pfb_autof2').val()=='Yes' || $('#pfb_autof3').val()=='No'){
			$('.pfbscore').val(0);
		}else{
			$('.pfbscore').val(quality_score_percent+'%');
		}

	/*----- ncpssm -----*/
		if($('#ncp1').val()=='Yes' || $('#ncp2').val()=='Yes' || $('#ncp3').val()=='Yes' || $('#ncp4').val()=='Yes'){
			$('.ncpAutof').val(0);
		}else{
			$('.ncpAutof').val(quality_score_percent+'%');
		}

	/*----- TBN/TPM -----*/
		if($('#autof1').val()=='Yes' || $('#autof2').val()=='Yes' || $('#autof3').val()=='Yes' || $('#autof4').val()=='Yes'){
			$('.tbnAutofail').val(0);
			$('.tpmAutofail').val(0);
		}else{
			$('.tbnAutofail').val(quality_score_percent+'%');
			$('.tpmAutofail').val(quality_score_percent+'%');
		}

	/*----- Non-Profit -----*/
		if($('#npaf1').val()=='Yes' || $('#npaf2').val()=='Yes' || $('#npaf3').val()=='Yes' || $('#npaf4').val()=='Yes' || $('#npaf5').val()=='Yes' || $('#npaf6').val()=='Yes' || $('#npaf7').val()=='Yes' || $('#npaf8').val()=='Yes' || $('#npaf9').val()=='Yes' || $('#npaf10').val()=='Yes' || $('#npaf11').val()=='Yes'){
			$('.autofNP').val(0);
		}else{
			$('.autofNP').val(quality_score_percent+'%');
		}

	/*----- ASPCA -----*/
		if($('#text_fatal1').val()=='No' || $('#text_fatal2').val()=='No' || $('#text_fatal3').val()=='Yes' || $('#text_fatal4').val()=='Yes' || $('#tf1').val()=='No' || $('#tf2').val()=='No' || $('#tf3').val()=='No' || $('#tf4').val()=='No'){
			$('.aspcaAutof').val(0);
		}else{
			$('.aspcaAutof').val(quality_score_percent+'%');
		}

	/*----- JMMI -----*/
		if($('#jmmi_text23').val()=='No' || $('#jmmi_text24').val()=='No'){
			$('.jmmi_autof').val(0);
		}else{
			$('.jmmi_autof').val(quality_score_percent+'%');
		}

	/*----- REVEL -----*/
		if($('#autofRVL1').val()=='Yes' || $('#autofRVL2').val()=='Yes'){
			$('.revelAutofail').val(0);
		}else{
			$('.revelAutofail').val(quality_score_percent+'%');
		}

	/*----- QPC -----*/
		if($('#qpcAF1').val()=='Yes' || $('#qpcAF2').val()=='Yes' || $('#qpcAF3').val()=='Yes' || $('#qpcAF4').val()=='Yes'){
			$('.qpcAutofail').val(0);
		}else{
			$('.qpcAutofail').val(quality_score_percent+'%');
		}

	/*----- Ancient Nutrition -----*/
		if($('#autofAN1').val()=='Unacceptable' || $('#autofAN2').val()=='Unacceptable' || $('#autofAN3').val()=='Unacceptable'){
			$('.ancient_nutritionAutofail').val(0);
		}else{
			$('.ancient_nutritionAutofail').val(quality_score_percent+'%');
		}

	/*----- SABAL -----*/
		if($('#autofSBL1').val()=='Yes' || $('#autofSBL2').val()=='Yes' || $('#autofSBL3').val()=='Yes' || $('#autofSBL4').val()=='Yes'){
			$('.sabalAutofail').val(0);
		}else{
			$('.sabalAutofail').val(quality_score_percent+'%');
		}

	/*----- CURATIVE -----*/
		if($('#curativeAF1').val()=='Unacceptable' || $('#curativeAF2').val()=='Unacceptable' || $('#curativeAF4').val()=='Unacceptable' || $('#curativeAF5').val()=='Unacceptable' || $('#curativeAF6').val()=='Unacceptable' || $('#curativeAF7').val()=='Unacceptable' || $('#curativeAF8').val()=='Unacceptable' || $('#curativeAF9').val()=='Unacceptable'){
			$('.curativeAutof').val(0);
		}else{
			$('.curativeAutof').val(quality_score_percent+'%');
		}
		/*--$('#curativeAF3').val()=='Unacceptable'--*/


	/*----- Power Fan -----*/
		if($('#powerfanAF1').val()=='Yes'){
			$('.powerFanAutof').val(0);
		}else{
			$('.powerFanAutof').val(quality_score_percent+'%');
		}

	/*----- NuWave -----*/
		if($('#autofNW_infractions').val()=='Yes'){
			$('.nwAutoFail').val(0);
		}else{
			$('.nwAutoFail').val(quality_score_percent+'%');
		}

	/*----- JFMI -----*/
		if($('#jfmi_af1').val()=='No' || $('#jfmi_af2').val()=='No'){
			$('.jfmiAutoFail').val(0);
		}else{
			$('.jfmiAutoFail').val(quality_score_percent+'%');
		}

	/*----- DD-IOWA -----*/
		if($('#iowaAF1').val()=='Yes' || $('#iowaAF2').val()=='Yes' || $('#iowaAF3').val()=='Yes' || $('#iowaAF4').val()=='Yes' || $('#iowaAF5').val()=='Yes'){
			$('.iowaFatal').val(0);
		}else{
			$('.iowaFatal').val(quality_score_percent+'%');
		}

	/*----- Food Saver -----*/
		if($('#foodsaverAF1').val()=='Unacceptable' || $('#foodsaverAF2').val()=='Unacceptable' || $('#foodsaverAF3').val()=='Unacceptable' || $('#foodsaverAF4').val()=='Unacceptable' || $('#foodsaverAF5').val()=='Unacceptable' || $('#foodsaverAF6').val()=='Unacceptable'){
			$('.foodsaverFatal').val(0);
		}else{
			$('.foodsaverFatal').val(quality_score_percent+'%');
		}

	/*----- SAS -----*/
		if($('#sasAF1').val()=='Unacceptable' || $('#sasAF2').val()=='Unacceptable' || $('#sasAF3').val()=='Unacceptable' || $('#sasAF4').val()=='Unacceptable' || $('#sasAF01').val()=='Yes' || $('#sasAF02').val()=='Yes' || $('#sasAF03').val()=='Yes' || $('#sasAF04').val()=='Yes' || $('#tactical1').val()=='Yes' || $('#tactical2').val()=='Yes' || $('#tactical3').val()=='Yes'){
			$('.sasFatal').val(0);
		}else{
			$('.sasFatal').val(quality_score_percent+'%');
		}

	/*----- GAP -----*/
		if($('#gapAF1').val()=='Unacceptable' || $('#gapAF2').val()=='Unacceptable' || $('#gapAF3').val()=='Unacceptable' || $('#gapAF4').val()=='Unacceptable' || $('#gapAF5').val()=='Unacceptable' || $('#gapAF6').val()=='Unacceptable' || $('#gapAF7').val()=='Unacceptable' || $('#gapAF8').val()=='Unacceptable' || $('#gapAF9').val()=='Unacceptable' || $('#gapAF10').val()=='Unacceptable' || $('#gapAF11').val()=='Unacceptable' || $('#gapAF12').val()=='Unacceptable'){
			$('.gapFatal').val(0);
		}else{
			$('.gapFatal').val(quality_score_percent+'%');
		}

	/*----- MPC -----*/
		if($('#mpcAF1').val()=='Unacceptable'){
			$('.mpcFatal').val(0);
		}else{
			$('.mpcFatal').val(quality_score_percent+'%');
		}

	/*------Blains------------*/
		// if($('#fatal1').val()=='No'){
		// 	$('.blains_fatal').val(0);
		// }else{
		// 	$('.blains_fatal').val(quality_score_percent+'%');
		// }

		// if($('#hovBR1').val()=='Fail' || $('#hovBR2').val()=='Fail'){
		// 	quality_score_percent = 0;
		// 	$('.blains_fatal').val(quality_score_percent+'%');
		// 	//$('.blains_fatal').val(0);
		// 	alert($('#hovBR1').val());
		// 	alert(quality_score_percent);
		// }
		// else{
		// 	$('.blains_fatal').val(quality_score_percent+'%');
		// }
		
	/*------AIR METHOD [Email]------------*/
		if($('#air_email_af1').val()=='Unacceptable' || $('#air_email_af2').val()=='Unacceptable' || $('#air_email_af3').val()=='Unacceptable' || $('#air_email_af4').val()=='Unacceptable' || $('#air_email_af5').val()=='Unacceptable' || $('#air_email_af6').val()=='Unacceptable'){
			$('.airmethod_email_fatal').val(0);
		}else{
			$('.airmethod_email_fatal').val(quality_score_percent+'%');
		}
		
	/*------Lockheed Martin------------*/
		if($('#lockheedAF1').val()=='No' || $('#lockheedAF2').val()=='No' || $('#lockheedAF3').val()=='No' || $('#lockheedAF4').val()=='No'){
			$('.lockheedAutofail').val(0);
		}else{
			$('.lockheedAutofail').val(quality_score_percent+'%');
		}

	/*------Conduent------------*/
			if($('#conduent1').val()=='No' || $('#conduent2').val()=='No' || $('#conduent3').val()=='No' || $('#conduent4').val()=='No' || $('#conduent5').val()=='No' || $('#conduent6').val()=='No' || $('#conduent7').val()=='No' || $('#conduent8').val()=='No'){
			$('.conduentAutofail').val(0);
		}else{
			$('.conduentAutofail').val(quality_score_percent+'%');
		}
	}

/////////////////////////////////////////////////////////
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}

////////////////////////////Riya (Health Bridge)////////////////////////
	$(document).on('change','.healthbridge_point',function(){ 
		fb_calculation();

    });
	fb_calculation();
////////////////////////////Compliance/////////////////////////////////
	$(document).on('change','.compliance_point',function(){ 
		fb_calculation();

    });
	fb_calculation();
///////////////////////////////Riya End//////////////////////////////////////////


</script>

<script>
////////////////// Purity Care New ///////////////////////

	function pcare_new_calc(){
		var greetScore = 0;
		var greetScoreable = 0;
		var discoveryScore = 0;
		var discoveryScoreable = 0;
		var valueScore = 0;
		var valueScoreable = 0;
		var retentionScore = 0;
		var retentionScoreable = 0;
		var conclusionScore = 0;
		var conclusionScoreable = 0;
		var confScore = 0;
		var confScoreable = 0;
		var packageScore = 0;
		var packageScoreable = 0;
		var optinsScore = 0;
		var optinsScoreable = 0;
		var databaseScore = 0;
		var databaseScoreable = 0;
		var infoScore = 0;
		var infoScoreable = 0;
		var callScore = 0;
		var callScoreable = 0;

		var pcare_new_earned = 0;
		var pcare_new_possible = 0;
		var pcare_new_OvlScore = 0;

		var call1Score = 0;
		var call2Score = 0;
		var call3Score = 0;
		var call4Score = 0;
		var call5Score = 0;

	/////////////////////////////////////////
	//// individuals score ////
		$('.greet_point').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1=='Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('greet_val'));
				greetScore = greetScore + w1;
				greetScoreable = greetScoreable + w1;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc1=='No'){
				var w1 = parseFloat($(element).children("option:selected").attr('greet_val'));
				greetScoreable = greetScoreable + w1;
				$(this).css('background-color', '#CD6155');
			}
		});
		$('#greetScore').val(greetScore);
		$('#greetScoreable').val(greetScoreable);
	///////////
		$('.discovery_point').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2=='Yes'){
				var w2 = parseFloat($(element).children("option:selected").attr('discovery_val'));
				discoveryScore = discoveryScore + w2;
				discoveryScoreable = discoveryScoreable + w2;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc2=='No'){
				var w2 = parseFloat($(element).children("option:selected").attr('discovery_val'));
				discoveryScoreable = discoveryScoreable + w2;
				$(this).css('background-color', '#CD6155');
			}else if(sc2=='N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('discovery_val'));
				discoveryScore = discoveryScore + w2;
				discoveryScoreable = discoveryScoreable + w2;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#discoveryScore').val(discoveryScore);
		$('#discoveryScoreable').val(discoveryScoreable);
	///////////
		$('.value_point').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3=='Yes'){
				var w3 = parseFloat($(element).children("option:selected").attr('value_val'));
				valueScore = valueScore + w3;
				valueScoreable = valueScoreable + w3;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc3=='No'){
				var w3 = parseFloat($(element).children("option:selected").attr('value_val'));
				valueScoreable = valueScoreable + w3;
				$(this).css('background-color', '#CD6155');
			}
		});
		$('#valueScore').val(valueScore);
		$('#valueScoreable').val(valueScoreable);
	///////////
		$('.retention_point').each(function(index,element){
			var sc4 = $(element).val();
			if(sc4=='Yes'){
				var w4 = parseFloat($(element).children("option:selected").attr('retention_val'));
				retentionScore = retentionScore + w4;
				retentionScoreable = retentionScoreable + w4;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc4=='No'){
				var w4 = parseFloat($(element).children("option:selected").attr('retention_val'));
				retentionScoreable = retentionScoreable + w4;
				$(this).css('background-color', '#CD6155');
			}else if(sc4=='N/A'){
				var w4 = parseFloat($(element).children("option:selected").attr('retention_val'));
				retentionScore = retentionScore + w4;
				retentionScoreable = retentionScoreable + w4;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#retentionScore').val(retentionScore);
		$('#retentionScoreable').val(retentionScoreable);
	///////////
		$('.conclusion_point').each(function(index,element){
			var sc5 = $(element).val();
			if(sc5=='Yes'){
				var w5 = parseFloat($(element).children("option:selected").attr('conclusion_val'));
				conclusionScore = conclusionScore + w5;
				conclusionScoreable = conclusionScoreable + w5;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc5=='No'){
				var w5 = parseFloat($(element).children("option:selected").attr('conclusion_val'));
				conclusionScoreable = conclusionScoreable + w5;
				$(this).css('background-color', '#CD6155');
			}
		});
		$('#conclusionScore').val(conclusionScore);
		$('#conclusionScoreable').val(conclusionScoreable);
	///////////
		$('.conf_point').each(function(index,element){
			var sc6 = $(element).val();
			if(sc6=='Yes'){
				var w6 = parseFloat($(element).children("option:selected").attr('conf_val'));
				confScore = confScore + w6;
				confScoreable = confScoreable + w6;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc6=='No'){
				var w6 = parseFloat($(element).children("option:selected").attr('conf_val'));
				confScoreable = confScoreable + w6;
				$(this).css('background-color', '#CD6155');
			}else if(sc6=='N/A'){
				var w6 = parseFloat($(element).children("option:selected").attr('conf_val'));
				confScore = confScore + w6;
				confScoreable = confScoreable + w6;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#confScore').val(confScore);
		$('#confScoreable').val(confScoreable);
	///////////
		$('.package_point').each(function(index,element){
			var sc7 = $(element).val();
			if(sc7=='Yes'){
				var w7 = parseFloat($(element).children("option:selected").attr('package_val'));
				packageScore = packageScore + w7;
				packageScoreable = packageScoreable + w7;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc7=='No'){
				var w7 = parseFloat($(element).children("option:selected").attr('package_val'));
				packageScoreable = packageScoreable + w7;
				$(this).css('background-color', '#CD6155');
			}else if(sc7=='N/A'){
				var w7 = parseFloat($(element).children("option:selected").attr('package_val'));
				packageScore = packageScore + w7;
				packageScoreable = packageScoreable + w7;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#packageScore').val(packageScore);
		$('#packageScoreable').val(packageScoreable);
	///////////
		$('.optins_point').each(function(index,element){
			var sc8 = $(element).val();
			if(sc8=='Yes'){
				var w8 = parseFloat($(element).children("option:selected").attr('optins_val'));
				optinsScore = optinsScore + w8;
				optinsScoreable = optinsScoreable + w8;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc8=='No'){
				var w8 = parseFloat($(element).children("option:selected").attr('optins_val'));
				optinsScoreable = optinsScoreable + w8;
				$(this).css('background-color', '#CD6155');
			}else if(sc8=='N/A'){
				var w8 = parseFloat($(element).children("option:selected").attr('optins_val'));
				optinsScore = optinsScore + w8;
				optinsScoreable = optinsScoreable + w8;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#optinsScore').val(optinsScore);
		$('#optinsScoreable').val(optinsScoreable);
	///////////
		$('.database_point').each(function(index,element){
			var sc9 = $(element).val();
			if(sc9=='Yes'){
				var w9 = parseFloat($(element).children("option:selected").attr('database_val'));
				databaseScore = databaseScore + w9;
				databaseScoreable = databaseScoreable + w9;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc9=='No'){
				var w9 = parseFloat($(element).children("option:selected").attr('database_val'));
				databaseScoreable = databaseScoreable + w9;
				$(this).css('background-color', '#CD6155');
			}else if(sc9=='N/A'){
				var w9 = parseFloat($(element).children("option:selected").attr('database_val'));
				databaseScore = databaseScore + w9;
				databaseScoreable = databaseScoreable + w9;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#databaseScore').val(databaseScore);
		$('#databaseScoreable').val(databaseScoreable);
	///////////
		$('.info_point').each(function(index,element){
			var sc10 = $(element).val();
			if(sc10=='Yes'){
				var w10 = parseFloat($(element).children("option:selected").attr('info_val'));
				infoScore = infoScore + w10;
				infoScoreable = infoScoreable + w10;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc10=='No'){
				var w10 = parseFloat($(element).children("option:selected").attr('info_val'));
				infoScoreable = infoScoreable + w10;
				$(this).css('background-color', '#CD6155');
			}
		});
		$('#infoScore').val(infoScore);
		$('#infoScoreable').val(infoScoreable);
	///////////
		$('.call_point').each(function(index,element){
			var sc11 = $(element).val();
			if(sc11=='Yes'){
				var w11 = parseFloat($(element).children("option:selected").attr('call_val'));
				callScore = callScore + w11;
				callScoreable = callScoreable + w11;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc11=='No'){
				var w11 = parseFloat($(element).children("option:selected").attr('call_val'));
				callScoreable = callScoreable + w11;
				$(this).css('background-color', '#CD6155');
			}
		});
		$('#callScore').val(callScore);
		$('#callScoreable').val(callScoreable);

	///////////////////////////////////
	//// calls score ////
		$('.call1').each(function(index,element){
			var c1 = parseFloat($(element).children("option:selected").attr('cl1'));
			call1Score = call1Score + c1;
		});
	//////////
		$('.call2').each(function(index,element){
			var c2 = parseFloat($(element).children("option:selected").attr('cl2'));
			call2Score = call2Score + c2;
		});
	/////////
		$('.call3').each(function(index,element){
			var c3 = parseFloat($(element).children("option:selected").attr('cl3'));
			call3Score = call3Score + c3;
		});
	/////////
		$('.call4').each(function(index,element){
			var c4 = parseFloat($(element).children("option:selected").attr('cl4'));
			call4Score = call4Score + c4;
		});
	////////
		$('.call5').each(function(index,element){
			var c5 = parseFloat($(element).children("option:selected").attr('cl5'));
			call5Score = call5Score + c5;
		});

	/////////////////////////////////////
		$('.autofCall1').each(function(index,element){
			var AF_C1 = $(element).val();
			if(AF_C1=='Yes'){
				$(this).css('background-color', '#CD6155');
			}
		});
		$('.autofCall2').each(function(index,element){
			var AF_C2 = $(element).val();
			if(AF_C2=='Yes'){
				$(this).css('background-color', '#CD6155');
			}
		});
		$('.autofCall3').each(function(index,element){
			var AF_C3 = $(element).val();
			if(AF_C3=='Yes'){
				$(this).css('background-color', '#CD6155');
			}
		});
		$('.autofCall4').each(function(index,element){
			var AF_C4 = $(element).val();
			if(AF_C4=='Yes'){
				$(this).css('background-color', '#CD6155');
			}
		});
		$('.autofCall5').each(function(index,element){
			var AF_C5 = $(element).val();
			if(AF_C5=='Yes'){
				$(this).css('background-color', '#CD6155');
			}
		});
	//// autofail section ////
		if($('#cl1af1').val()=='Yes' || $('#cl1af2').val()=='Yes' || $('#cl1af3').val()=='Yes' || $('#cl1af4').val()=='Yes' || $('#cl1af5').val()=='Yes' || $('#cl1af6').val()=='Yes'|| $('#cl1af7').val()=='Yes' || $('#cl1af8').val()=='Yes'){
			var cl1Scr = 0;
			$('#call1').val(0);
		}else{
			var cl1Scr = call1Score;
			$('#call1').val(call1Score);
		}

		if($('#cl2af1').val()=='Yes' || $('#cl2af2').val()=='Yes' || $('#cl2af3').val()=='Yes' || $('#cl2af4').val()=='Yes' || $('#cl2af5').val()=='Yes' || $('#cl2af6').val()=='Yes'|| $('#cl2af7').val()=='Yes' || $('#cl2af8').val()=='Yes'){
			var cl2Scr = 0;
			$('#call2').val(0);
		}else{
			var cl2Scr = call2Score;
			$('#call2').val(call2Score);
		}

		if($('#cl3af1').val()=='Yes' || $('#cl3af2').val()=='Yes' || $('#cl3af3').val()=='Yes' || $('#cl3af4').val()=='Yes' || $('#cl3af5').val()=='Yes' || $('#cl3af6').val()=='Yes'|| $('#cl3af7').val()=='Yes' || $('#cl3af8').val()=='Yes'){
			var cl3Scr = 0;
			$('#call3').val(0);
		}else{
			var cl3Scr = call3Score;
			$('#call3').val(call3Score);
		}

		if($('#cl4af1').val()=='Yes' || $('#cl4af2').val()=='Yes' || $('#cl4af3').val()=='Yes' || $('#cl4af4').val()=='Yes' || $('#cl4af5').val()=='Yes' || $('#cl4af6').val()=='Yes'|| $('#cl4af7').val()=='Yes' || $('#cl4af8').val()=='Yes'){
			var cl4Scr = 0;
			$('#call4').val(0);
		}else{
			var cl4Scr = call4Score;
			$('#call4').val(call4Score);
		}

		if($('#cl5af1').val()=='Yes' || $('#cl5af2').val()=='Yes' || $('#cl5af3').val()=='Yes' || $('#cl5af4').val()=='Yes' || $('#cl5af5').val()=='Yes' || $('#cl5af6').val()=='Yes'|| $('#cl5af7').val()=='Yes' || $('#cl5af8').val()=='Yes'){
			var cl5Scr = 0;
			$('#call5').val(0);
		}else{
			var cl5Scr = call5Score;
			$('#call5').val(call5Score);
		}
	/////////////////////////////////////////
	//// overall score ////
		pcare_new_earned = (cl1Scr+cl2Scr+cl3Scr+cl4Scr+cl5Scr);
		pcare_new_possible = (greetScoreable+discoveryScoreable+valueScoreable+retentionScoreable+conclusionScoreable+confScoreable+packageScoreable+optinsScoreable+databaseScoreable+infoScoreable+callScoreable);
		pcare_new_OvlScore = ((pcare_new_earned * 100) / pcare_new_possible).toFixed(2);

		if(!isNaN(pcare_new_OvlScore)){
			$('#pcare_new_earned').val(pcare_new_earned);
			$('#pcare_new_possible').val(pcare_new_possible);
			$('#pcare_new_OvlScore').val(pcare_new_OvlScore+'%');
		}

		if(pcare_new_OvlScore < 75){
			$('#pcare_new_OvlScore').css('background-color', '#CB4335');
		}else if(pcare_new_OvlScore >= 75 && pcare_new_OvlScore < 85){
			$('#pcare_new_OvlScore').css('background-color', '#F7DC6F');
		}else if(pcare_new_OvlScore > 85){
			$('#pcare_new_OvlScore').css('background-color', '');
		}

	}


	$(document).ready(function(){

		$(document).on('change','.greet_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$(document).on('change','.discovery_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$(document).on('change','.value_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$(document).on('change','.retention_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$(document).on('change','.conclusion_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$(document).on('change','.conf_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$(document).on('change','.package_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$(document).on('change','.optins_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$(document).on('change','.database_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$(document).on('change','.info_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$(document).on('change','.call_point',function(){
			pcare_new_calc();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});

		$(document).on('change','.call1',function(){ pcare_new_calc(); });
		$(document).on('change','.call2',function(){ pcare_new_calc(); });
		$(document).on('change','.call3',function(){ pcare_new_calc(); });
		$(document).on('change','.call4',function(){ pcare_new_calc(); });
		$(document).on('change','.call5',function(){ pcare_new_calc(); });

		$(document).on('change','.autofCall1',function(){
			pcare_new_calc();
			if($(this).val()=="Yes"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="No"){
				$(this).css('background-color', '');
			}
		});
		$(document).on('change','.autofCall2',function(){
			pcare_new_calc();
			if($(this).val()=="Yes"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="No"){
				$(this).css('background-color', '');
			}
		});
		$(document).on('change','.autofCall3',function(){
			pcare_new_calc();
			if($(this).val()=="Yes"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="No"){
				$(this).css('background-color', '');
			}
		});
		$(document).on('change','.autofCall4',function(){
			pcare_new_calc();
			if($(this).val()=="Yes"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="No"){
				$(this).css('background-color', '');
			}
		});
		$(document).on('change','.autofCall5',function(){
			pcare_new_calc();
			if($(this).val()=="Yes"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="No"){
				$(this).css('background-color', '');
			}
		});

		pcare_new_calc();

		/* $(document).on('change','.form-control',function(){
			if($(this).val()=="No"){
				$(this).css({color: "red"});
			}else{
				$(this).css({color: "black"});
			}
		}); */

	});
</script>

//////vikas////////
<script type="text/javascript">
	//////////////////////Kenny-U-Pull////////////////////////////
	
	function kenny_u_pull_calc(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.kennyVal').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('kenny_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('kenny_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('kenny_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#kennyEarnedScore').val(score);   
		$('#kennyPossibleScore').val(scoreable);

		// if(!isNaN(quality_score_percent)){
		// 	$('#sensioOverallScore').val(quality_score_percent+'%');
		// }

		if(($('#kenny_AF1').val()=='Yes') || $('#kenny_AF2').val()=='Yes' || $('#file_opening').val()=='No'){
		$('#kennyOverallScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#kennyOverallScore').val(quality_score_percent+'%');
			}	
		}

		
		$('#pass_count').val(pass_count);
		$('#fail_count').val(fail_count);
		$('#na_count').val(na_count);
		

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custSenEarned').text(customerScore);
		$('#custSenPossible').text(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		// if(!isNaN(customerPercentage)){
		// 	$('#custSenScore').val(customerPercentage+'%');
		// }
		if(($('#kenny_AF1').val()=='Yes') || $('#kenny_AF2').val()=='Yes' || $('#file_opening').val()=='No'){
		$('#custSenScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#custSenScore').val(quality_score_percent+'%');
			}	
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busiSenEarned').text(businessScore);
		$('#busiSenPossible').text(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busiSenScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliancee').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#complSenEarned').text(complianceScore);
		$('#complSenPossible').text(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complSenScore').val(compliancePercentage+'%');
		}
	}


	/////////////////////////////////////////////////
</script>

<script type="text/javascript">
		//////////////////////Homeward Health////////////////////////////
	
	function homeward_health_calc(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;


		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('homeward_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseFloat($(element).children("option:selected").attr('homeward_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('homeward_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			} 
			if(sc1 == '4'){
				var w1 = parseFloat($(element).children("option:selected").attr('homeward_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == '3'){
				var w1 = parseFloat($(element).children("option:selected").attr('homeward_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == '2'){
				var w1 = parseFloat($(element).children("option:selected").attr('homeward_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == '1'){
				var w1 = parseFloat($(element).children("option:selected").attr('homeward_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custSenEarned').val(customerScore);
		$('#custSenPossible').val(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		// if(!isNaN(customerPercentage)){
		// 	$('#custSenScore').val(customerPercentage+'%');
		// }
		if(($('#homeward_AF1').val()=='No') || $('#homeward_AF2').val()=='Yes' || $('#homeward_AF3').val()=='Yes'){
		$('#custSenScore').val(0);
		}else{
			if(!isNaN(customerPercentage)){
				$('#custSenScore').val(customerPercentage+'%');
			}	
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('homeward_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('homeward_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('homeward_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busiSenEarned').val(businessScore);
		$('#busiSenPossible').val(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busiSenScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliancee').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('homeward_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('homeward_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('homeward_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#complSenEarned').val(complianceScore);
		$('#complSenPossible').val(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complSenScore').val(compliancePercentage+'%');
		}

		//////////////////////////////////////
    $('.homewardVal').each(function(index,element){
		var score_type = $(element).val();
		if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('homeward_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('homeward_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('homeward_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 4){
				//alert(score_type);
				pass_count = pass_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('homeward_val'));
				//console.log(weightage);
				score = score + weightage;
				scoreable = scoreable + 4;
			}
			else if(score_type == 3){
				//alert(score_type);
				pass_count = pass_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('homeward_val'));
				//console.log(weightage);
				score = score + weightage;
				scoreable = scoreable + 4;
			}
			else if(score_type == 2){
				//alert(score_type);
				pass_count = pass_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('homeward_val'));
				score = score + weightage;
				scoreable = scoreable + 4;
			}
			else if(score_type == 1){
				//alert(score_type);
				pass_count = pass_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('homeward_val'));
				score = score + weightage;
				scoreable = scoreable + 4;
			}
			else if(score_type == 0){
				//alert(score_type);
				pass_count = pass_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('homeward_val'));
				score = score + weightage;
				scoreable = scoreable + 4;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		//console.log(quality_score_percent);
		//console.log(isNaN(0.00))
		$('#homewardEarnedScore').val(score);   
		$('#homewardPossibleScore').val(scoreable);

		// if(!isNaN(quality_score_percent)){
		// 	$('#homewardOverallScore').val(quality_score_percent+'%');
		// }

		if(($('#homeward_AF1').val()=='No') || $('#homeward_AF2').val()=='Yes' || $('#homeward_AF3').val()=='Yes'){
		$('#homewardOverallScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#homewardOverallScore').val(quality_score_percent+'%');
			}	
		}

		
		$('#pass_count').val(pass_count);
		$('#fail_count').val(fail_count);
		$('#na_count').val(na_count);
		/////////////////////////////////////
	}
	////////////////// Homeward Health /////////////////////
	$(document).on('change','.homewardVal',function(){ 
		homeward_health_calc(); 
	});
	homeward_health_calc();	

	////////////////// Kenny-U-Pull /////////////////////
	$(document).on('change','.kennyVal',function(){ 
		kenny_u_pull_calc(); 
	});
	kenny_u_pull_calc();
</script>
<script>
////////////// Conscious Selling (23-07-2021) /////////////////
	function pcare_conscious_selling(){

		var greeting_score=0;
		var greeting_scoreable=0;
		$('.greeting').each(function(index,element){
			var sc1 = $(element).val();
			var clr1 = $(element).val();
			if(sc1=='No'){
				greeting_score = 0;
				greeting_scoreable = 10;
				$(this).css('background-color', '#CD6155');
				return false;
			}else if(sc1=='Yes'){
				greeting_score = 10;
				greeting_scoreable = 10;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc1=='N/A'){
				greeting_score = 10;
				greeting_scoreable = 10;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#greeting_introduction_score').val(greeting_score);
	/////////
		var upfront_score=0;
		var upfront_scoreable=0;
		$('.upfront').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2=='No'){
				upfront_score = 0;
				upfront_scoreable = 15;
				return false;
				$(this).css('background-color', '#CD6155');
			}else if(sc2=='Yes'){
				upfront_score = 15;
				upfront_scoreable = 15;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc2=='N/A'){
				upfront_score = 15;
				upfront_scoreable = 15;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#up_front_agreement_score').val(upfront_score);
	/////////
		var examine_score=0;
		var examine_scoreable=0;
		$('.examine').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3=='No'){
				examine_score = 0;
				examine_scoreable = 15;
				return false;
				$(this).css('background-color', '#CD6155');
			}else if(sc3=='Yes'){
				examine_score = 15;
				examine_scoreable = 15;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc3=='N/A'){
				examine_score = 15;
				examine_scoreable = 15;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#examine_diagnose_score').val(examine_score);
	/////////
		var solution_score=0;
		var solution_scoreable=0;
		$('.solution').each(function(index,element){
			var sc4 = $(element).val();
			if(sc4=='No'){
				solution_score = 0;
				solution_scoreable = 15;
				return false;
				$(this).css('background-color', '#CD6155');
			}else if(sc4=='Yes'){
				solution_score = 15;
				solution_scoreable = 15;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc4=='N/A'){
				solution_score = 15;
				solution_scoreable = 15;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#solution_overview_score').val(solution_score);
	/////////
		var conclusion_score=0;
		var conclusion_scoreable=0;
		$('.conclusion').each(function(index,element){
			var sc5 = $(element).val();
			if(sc5=='No'){
				conclusion_score = 0;
				conclusion_scoreable = 10;
				return false;
				$(this).css('background-color', '#CD6155');
			}else if(sc5=='Yes'){
				conclusion_score = 10;
				conclusion_scoreable = 10;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc5=='N/A'){
				conclusion_score = 10;
				conclusion_scoreable = 10;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#conclusion_score').val(conclusion_score);
	/////////
		var package_score=0;
		var package_scoreable=0;
		$('.package').each(function(index,element){
			var sc6 = $(element).val();
			if(sc6=='No'){
				package_score = 0;
				package_scoreable = 10;
				return false;
				$(this).css('background-color', '#CD6155');
			}else if(sc6=='Yes'){
				package_score = 10;
				package_scoreable = 10;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc6=='N/A'){
				package_score = 0;
				package_scoreable = 0;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#package_return_score').val(package_score);
	/////////
		var procedure_score=0;
		var procedure_scoreable=0;
		$('.procedure').each(function(index,element){
			var sc7 = $(element).val();
			if(sc7=='No'){
				procedure_score = 0;
				procedure_scoreable = 10;
				return false;
				$(this).css('background-color', '#CD6155');
			}else if(sc7=='Yes'){
				procedure_score = 10;
				procedure_scoreable = 10;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc7=='N/A'){
				procedure_score = 10;
				procedure_scoreable = 10;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#procedure_score').val(procedure_score);
	/////////
		var accuracy_score=0;
		var accuracy_scoreable=0;
		$('.accuracy').each(function(index,element){
			var sc8 = $(element).val();
			if(sc8=='No'){
				accuracy_score = 0;
				accuracy_scoreable = 10;
				return false;
				$(this).css('background-color', '#CD6155');
			}else if(sc8=='Yes'){
				accuracy_score = 10;
				accuracy_scoreable = 10;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc8=='N/A'){
				accuracy_score = 10;
				accuracy_scoreable = 10;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#accuracy_score').val(accuracy_score);
	/////////
		var call_score=0;
		var call_scoreable=0;
		$('.call').each(function(index,element){
			var sc9 = $(element).val();
			if(sc9=='No'){
				call_score = 0;
				call_scoreable = 10;
				return false;
				$(this).css('background-color', '#CD6155');
			}else if(sc9=='Yes'){
				call_score = 10;
				call_scoreable = 10;
				$(this).css('background-color', '#7DCEA0');
			}else if(sc9=='N/A'){
				call_score = 10;
				call_scoreable = 10;
				$(this).css('background-color', '#F7DC6F');
			}
		});
		$('#call_management_score').val(call_score);

	///////////////////////////
		var pcsEarn = (greeting_score+upfront_score+examine_score+solution_score+conclusion_score+package_score+procedure_score+accuracy_score+call_score);
		var pcsPossible = (greeting_scoreable+upfront_scoreable+examine_scoreable+solution_scoreable+conclusion_scoreable+package_scoreable+procedure_scoreable+accuracy_scoreable+call_scoreable);
		var pcsOverallScore = ((pcsEarn*100)/pcsPossible).toFixed(2);

		$('#pcs_earnedScore').val(pcsEarn);
		$('#pcs_possibleScore').val(pcsPossible);
		$('#pcs_overallScore').val(pcsOverallScore+'%');

		if($('#pcsAF1').val()=='Yes' || $('#pcsAF2').val()=='Yes' || $('#pcsAF3').val()=='Yes' || $('#pcsAF4').val()=='Yes' || $('#pcsAF5').val()=='Yes' || $('#pcsAF6').val()=='Yes'|| $('#pcsAF7').val()=='Yes'){
			$('.pcsFatal').val(0);
		}else{
			$('.pcsFatal').val(pcsOverallScore+'%');
		}

	////////////////////////////////////////////////////
		$('.autocolor').each(function(index,element){
			var ac1 = $(element).val();
			if(ac1=='No'){
				$(this).css('background-color', '#CD6155');
			}else if(ac1=='Yes'){
				$(this).css('background-color', '#7DCEA0');
			}else if(ac1=='N/A'){
				$(this).css('background-color', '#F7DC6F');
			}
		});

		$('.autocolorfatal').each(function(index,element){
			var ac2 = $(element).val();
			if(ac2=='No'){
				$(this).css('background-color', '#7DCEA0');
			}else if(ac2=='Yes'){
				$(this).css('background-color', '#CD6155');
			}else if(ac2=='N/A'){
				$(this).css('background-color', '#F7DC6F');
			}
		});

	}

	$(document).ready(function(){

		$(document).on('change','.greeting',function(){
			pcare_conscious_selling();
			/* if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			} */
		});

		$(document).on('change','.upfront',function(){
			pcare_conscious_selling();
			/* if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			} */
		});

		$(document).on('change','.examine',function(){
			pcare_conscious_selling();
			/* if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			} */
		});

		$(document).on('change','.solution',function(){
			pcare_conscious_selling();
			/* if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			} */
		});

		$(document).on('change','.conclusion',function(){
			pcare_conscious_selling();
			/* if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}	 */
		});

		$(document).on('change','.package',function(){
			pcare_conscious_selling();
			/* if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}	 */
		});

		$(document).on('change','.procedure',function(){
			pcare_conscious_selling();
			/* if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}	 */
		});

		$(document).on('change','.accuracy',function(){
			pcare_conscious_selling();
			/* if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			} */
		});

		$(document).on('change','.call',function(){
			pcare_conscious_selling();
			/* if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			} */
		});

		$(document).on('change','.pcs_fatal',function(){
			pcare_conscious_selling();
			/* if($(this).val()=="Yes"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="No"){
				$(this).css('background-color', '');
			} */
		});

		$(document).on('change','.autocolor',function(){
			pcare_conscious_selling();
			if($(this).val()=="No"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});

		$(document).on('change','.autocolorfatal',function(){
			pcare_conscious_selling();
			if($(this).val()=="No"){
				$(this).css('background-color', '#7DCEA0');
			}else if($(this).val()=="Yes"){
				$(this).css('background-color', '#CD6155');
			}else if($(this).val()=="N/A"){
				$(this).css('background-color', '#F7DC6F');
			}
		});

		pcare_conscious_selling();
	});
</script>

<!-- Ameridial Commercial CMN Script -->
<script>
	$(document).ready(function(){
		$("#hold_duration").timepicker({timeFormat : 'HH:mm:ss' });
		$("#verif_duration").timepicker({timeFormat : 'HH:mm:ss' });
		$(document).on("change", ".amd_cmn_point", function(){
			var total_earned_score=0,total_possible_score=0;
			$(".amd_cmn_point").each(function(){
				var earned_score=parseInt($(this).children("option:selected").attr("amd_val"));
				var possible_score=parseInt($(this).children("option:selected").attr("amd_max"));
				if($(this).val()=="Y"){
					total_earned_score += earned_score;
					total_possible_score += possible_score;
				}else if($(this).val()=="N"){
					total_earned_score += 0;
					total_possible_score += possible_score;
				}
			});
			$("#cmn_earnedScore").val(total_earned_score);
			$("#cmn_possibleScore").val(total_possible_score);
			$("#cmn_overallScore").val(parseFloat((total_earned_score/total_possible_score)*100).toFixed(2)+"%");
		});
	});
</script>

<!-- Ameridial Commercial Pilgrim Script -->
<script>
	$(document).ready(function(){
		$(document).on("change", ".amd_pilgrim_point", function(){
			var total_earned_score=0,total_possible_score=0;
			$(".amd_pilgrim_point").each(function(){
				var earned_score=parseInt($(this).children("option:selected").attr("amd_val"));
				var possible_score=parseInt($(this).children("option:selected").attr("amd_max"));
				if($(this).val()=="Yes"){
					total_earned_score += earned_score;
					total_possible_score += possible_score;
				}else if($(this).val()=="No"){
					total_earned_score += 0;
					total_possible_score += possible_score;
				}else if($(this).val()=="NA"){
					total_earned_score += 0;
					total_possible_score += possible_score;
				}
			});
			$("#pilgrim_earnedScore").val(total_earned_score);
			$("#pilgrim_possibleScore").val(total_possible_score);
			$("#pilgrim_overallScore").val(parseFloat((total_earned_score/total_possible_score)*100).toFixed(2)+"%");
		});
	});
</script>

<script>
$(document).ready(function(){
	
	$('.audioFile').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'wav':
			case 'wmv':
			case 'mp3':
			case 'mp4':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
	
});	
</script>

<!-- <script type="text/javascript">
		function pilgrim_calc(){
		var pilgrim_score = 0;
		var pilgrim_scoreable = 0;
		var pilgrim_score_percent = 0;
		
		$('.amd_pilgrim_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
				pilgrim_score = pilgrim_score + weightage;
				pilgrim_scoreable = pilgrim_scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
				pilgrim_scoreable = pilgrim_scoreable + weightage;
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
				pilgrim_score = pilgrim_score + weightage;
				pilgrim_scoreable = pilgrim_scoreable + weightage;
			}
		});
		pilgrim_score_percent = ((pilgrim_score*100)/pilgrim_scoreable).toFixed(2);
		var ern_score =pilgrim_score.toFixed(0);
		var posible_score =pilgrim_scoreable.toFixed(0);
		$('#pilgrim_earnedScore').val(ern_score);
		$('#pilgrim_possibleScore').val(posible_score);
		
		if(!isNaN(pilgrim_score_percent)){
			$('#pilgrim_overallScore').val(pilgrim_score_percent+'%');
		}
		
	}
	 $(document).on('change','.amd_pilgrim_point',function(){
		pilgrim_calc();
    });
	pilgrim_calc();
	
</script> -->


