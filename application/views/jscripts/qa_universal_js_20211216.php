<script type="text/javascript">	
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#mail_action_date").datepicker();
	$("#tat_replied_date").datepicker();
	$("#cycle_date").datepicker();
	$("#week_end_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#call_date_time").datetimepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	$(".agentName").select2();
	
///////////////////// SOP Library ////////////////////////////
	$(".addSOPLibrary").click(function(){
		$("#addSOPLibraryModel").modal('show');
	});
	
	$('#docu_upl').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'doc':
			case 'docx':
			case 'xls':
			case 'xlsx':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
/////////////////////////////////////////////////////////////	
	
	
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
});
</script>

<script type="text/javascript">
////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function(){
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_metropolis/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
</script>

<script>

$( "#client_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Client ID")
		var URL='<?php echo base_url();?>Qa_agent_coaching/get_client';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aid,
			success: function(aList){ 
				var json_obj = $.parseJSON(aList); 
				
					 $('#agent_id_process').empty();
				     $('#agent_id_process').append("<option value=''>--Select--</option>"); 
				for(i=0; i < json_obj.length;i++){
					 var newoption = '<option value='+ json_obj[i].id +'>'+ json_obj[i].name+' - '+json_obj[i].office_id +'</option>';
					 $('#agent_id_process').append(newoption);
				}
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		});
	});

	
	$( "#agent_id_process" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_metropolis/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#process_id').append($('#process_id').val(json_obj[i].process_id));
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
</script>

<!--Use For Programing-->
<script>
//////////////// queens and english ///////////////////////
	function do_queens_english(){
		var score=0;

		var score = 0;
		var scoreable = 0;
		var na_count = 0;
		var quality_score_percent = 0;
		$('.queens').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('queens_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('queens_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
         
        $('#ernscoo').val(score);
        $('#posiooo').val(scoreable);

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		if(!isNaN(quality_score_percent)){
			$('#queensScore').val(quality_score_percent+'%');
		}

	   /*---------------*/
		if($('#queensAF1').val()=='No' || $('#queensAF2').val()=='No' || $('#queensAF3').val()=='No' || $('#queensAF4').val()=='No' || $('#queensAF5').val()=='No' || $('#queensAF6').val()=='No' || $('#queensAF7').val()=='No'){
			$('.queensFatal').val(0.00+'%');
		}else{
			$('.queensFatal').val(score+'%');
		}
	}

	$(document).on('change','.queens',function(){
		do_queens_english();
	});
	do_queens_english();

	</script>

	<script>
//////////////// groupe and france ///////////////////////
	function do_group_france(){
		var score=0;
		$('.group_france_point').each(function(index,element){
			var group_france = parseFloat($(element).children("option:selected").attr('group_france_val'));
			score = score + group_france;
		});
		if(!isNaN(score)){
			$('#group_overallScore').val(score+'%');
		}

	}

	$(document).on('change','.group_france_point',function(){
		do_group_france();
	});
	do_group_france();

	</script>

	<script>
	////////////////////// AB Commercial ////////////////////
function do_ab_commercial_rp(){
	     //alert("Oooooo");
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;

		$('.commercial_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('commercial_val'));
				score = score + weightage;
		  });

		$('#commercial_overoll_score').val(score);  
	}

    $(document).on('change','.commercial_point',function(){
		do_ab_commercial_rp();
    });
	do_ab_commercial_rp();	
	</script>

<script>
////////////////////// indiabulls ////////////////////
function do_indiabulls(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.indiabulls_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('bull_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('bull_val'));
				scoreable = scoreable + weightage;
			}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);

         if(!isNaN(score)){
         	if(score==800){
			$('#indiabullScore').val(quality_score_percent+'%');
		    }else{
		    $('#indiabullScore').val('');	
		    }
		}

       //Fatal
       /*---------------*/
		if($('#indiabullFAt').val()=='No'){
			$('#indiabullScore').val(0);
		}else{
			if(score==800){
			$('#indiabullScore').val(quality_score_percent+'%');
		    }
		}

 }

 $(document).on('change','.indiabulls_point',function(){
		do_indiabulls();
	});
   do_indiabulls();
</script>

<script>
////////////////////// indiabulls ////////////////////
function do_final_pmo(){
		var score = 0;
		var scoreable = 0;
		var na_count = 0;
		var quality_score_percent = 0;
		$('.final_pmo_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('final_pmo_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('final_pmo_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);

         $('#final_pmo_earned_score').val(score);
		 $('#final_pmo_possible_score').val(scoreable);
         if(!isNaN(quality_score_percent)){
			$('#final_pmo_overall_score').val(quality_score_percent+'%'); 
		}	

 }

 $(document).on('change','.final_pmo_point',function(){
		do_final_pmo();
	});
   do_final_pmo();
</script>

<script>
	////////////////////// Sentient Jet/ ////////////////////
function do_sentient_jet(){
	     //alert("Oooooo");
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;
		var na_count = 0;
		$('.sentient_point').each(function(index,element){
			
				var weightage = parseFloat($(element).children("option:selected").attr('sentient_val'));
				score = score + weightage;
			
		  });
        totalscore = ((score*100)/129).toFixed(2);
		$('#sentient_jet_overall_score').val(totalscore); 
		if(totalscore>=85){
		$('#final_result').val('Pass').css("color", "green");
		} else {
		$('#final_result').val('Fail').css("color", "red");
		}
	}

    $(document).on('change','.sentient_point',function(){
		do_sentient_jet();
    });
	do_sentient_jet();



	$(document).on('change','#evaluated',function(){
		do_evaluated();
		function do_evaluated(){
        var number=document.getElementById("evaluated").value; 
        const dateObj = new Date(number);
		const monthNameLong = dateObj.toLocaleString("en-US", { month: "long" });
		$('#evaluated_date').val(monthNameLong); 
		//Use For Week
		const currentdate = new Date(number);
        const oneJan = new Date(currentdate.getFullYear(),0,1);
        const numberOfDays = Math.floor((currentdate - oneJan) / (24 * 60 * 60 * 1000));
        const result = Math.ceil(( currentdate.getDay() + 1 + numberOfDays) / 7);
       $('#week').val(result);

		}
    });	
	</script>

<script>
function grille_moreco(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		
		$('.grille_moreco_point').each(function(index,element){
			//alert("Ooooo");
			var score_type = $(element).val();
			if(score_type != "N/A"){
				var weightage = parseFloat($(element).children("option:selected").attr('grille_moreco_val'));
				score = score + parseFloat(weightage*(score_type/100));
				scoreable = scoreable + weightage;
			}
		});
        
		score = parseFloat(score);
		quality_score_percent = parseFloat(scoreable);
		
		var quality_score_percent=((score*100)/quality_score_percent).toFixed(2);
        
		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}			
	
	}
	

$(document).on('change','.grille_moreco_point',function(){
	grille_moreco();
    });
	grille_moreco();
</script>

<script type="text/javascript">
////////////////////// Icario ///////////////////////////////////	
	function icario_calculation(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.icario_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('icario_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('icario_val'));
				scoreable = scoreable + weightage;
			}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#fb_earnedScore1').val(score);
		$('#fb_possibleScore1').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#icario_overallScore').val(quality_score_percent+'%');
			if($('#autoF6').val()=='Yes'){
		     var ppp = parseFloat(quality_score_percent)+parseFloat(5);
             $('.bonusAutofail').val(ppp+'%');
		     }
		}
	
	    if($('#autoF1').val()=='No' || $('#autoF2').val()=='Yes' || $('#autoF3').val()=='Yes' || $('#autoF4').val()=='Yes' || $('#autoF5').val()=='Yes'){
			$('.icarioAutofail').val(0);
			$('.bonusAutofail').val(0);
		}else{
			$('.icarioAutofail').val(quality_score_percent+'%');
		}

        
        //Mechanics
        var score22 = 0;
		var scoreable22 = 0;
		var quality_score_percent22 = 0;
		var weightage22=0;
		
		$('.mechanic').each(function(index,element){
			var score_type22 = $(element).val();
			
			if(score_type22 == 'Yes'){
				weightage22 = parseFloat($(element).children("option:selected").attr('icario_val'));
				score22 = score22 + weightage22;
				scoreable22 = scoreable22 + weightage22;
			}else if(score_type22 == 'No'){
			    weightage22 = parseFloat($(element).children("option:selected").attr('icario_val'));
				scoreable22 = scoreable22 + weightage22;
			}
		});

		quality_score_percent22 = ((score22*100)/scoreable22).toFixed(2);
		$('#fb_earnedScore2').val(score22);
		$('#fb_possibleScore2').val(scoreable22);
		
		if(!isNaN(quality_score_percent22)){
			$('#icario_overallScore2').val(quality_score_percent22+'%');
		}
              
         // Soft Skills
         var score33 = 0;
		 var scoreable33 = 0;
		 var quality_score_percent33 = 0;
         $('.soft_skill').each(function(index,element){
			var score_type33 = $(element).val();
			
			if(score_type33 == 'Yes'){
				var weightage33 = parseFloat($(element).children("option:selected").attr('icario_val'));
				score33 = score33 + weightage33;
				scoreable33 = scoreable33 + weightage33;
			}else if(score_type33 == 'No'){
				var weightage33 = parseFloat($(element).children("option:selected").attr('icario_val'));
				scoreable33 = scoreable33 + weightage33;
			}
		});

		quality_score_percent33 = ((score33*100)/scoreable33).toFixed(2);
		$('#fb_earnedScore3').val(score33);
		$('#fb_possibleScore3').val(scoreable33);
		
		if(!isNaN(quality_score_percent33)){
			$('#icario_overallScore3').val(quality_score_percent33+'%');
		}

	}

	$(document).on('change','.icario_point',function(){
		icario_calculation();
	});
	icario_calculation();

</script>

<script>
	////////////////////// LM New ////////////////////
function do_lm_new_vrs(){
	     //alert("Oooooo");
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;

		$('.lm_new_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('lm_val'));
				score = score + weightage;
		  });

		$('#lm_overoll_score').val(score);

        if($('#lm_FAT1').val()=='No' || $('#lm_FAT2').val()=='No' || $('#lm_FAT3').val()=='No' || $('#lm_FAT4').val()=='No' || $('#lm_FAT5').val()=='No' || $('#lm_FAT6').val()=='No' || $('#lm_FAT7').val()=='No' || $('#lm_FAT8').val()=='Yes' || $('#lm_FAT9').val()=='Yes' || $('#lm_FAT10').val()=='Yes' || $('#lm_FAT11').val()=='No' || $('#lm_FAT12').val()=='No'){
			$('.lm_fatal').val(0);
		}else{
			$('.lm_fatal').val(score+'%');
		}

	}

    $(document).on('change','.lm_new_point',function(){
		do_lm_new_vrs();
    });
	do_lm_new_vrs();	
	</script>