<!-- AVON SCRIPT -->
<!-- Score Counter Script-->
<script src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<script src="<?php echo base_url() ?>assets/css/search-filter/js/chart.js"></script>

<script>
//     $(document).ready(function(e){
//     $('#batch_code').select2(); 
    
// });
$(function() {
    $('#multiselect').multiselect();
    $('.multiple-select').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
		numberDisplayed: 0,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Search for something...'
    });
});

</script>
<script type="text/javascript">

	    $(function() {
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
				
					$('#tl_name_s').empty();
					$('#tl_name_s').append($('#tl_name_s').val(''));
					$('#fusion_id').empty();
					$('#fusion_id').append($('#fusion_id').val(''));
					
					for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
					for (var i in json_obj){
						if($('#tl_name_s').val(json_obj[i].tl_name)!=''){
							console.log(json_obj[0].tl_name);
							$('#tl_name_s').append($('#tl_name_s').val(json_obj[i].tl_name));

						}else{
							alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
						}
						
					}
					 
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
	
		$(function() {
		$( "#agent_id" ).on('change' , function() {
		var aid = this.value;
		//alert(aid);
		//if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_epgi/getSiteLocation';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'agent_id='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
			
				$('#site').empty();
				$('#site').append($('#site').val(''));
				//console.log(json_obj);
				for (var i in json_obj){
					if($('#site').val(json_obj[i].office_id)!=''){
						//console.log(json_obj[0].office_id);
						$('#site').append($('#site').val(json_obj[i].office_id));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				} 
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){
				alert('Fail!');
			}
		});
	});
});
</script>

<script type = "text/javascript">
   <!--
      // Form validation code will come here.
      function validate() {
      
         if( document.form_new_user.from_date.value == "" ) {
            alert( "Please provide From Date!" );
            document.form_new_user.from_date.focus() ;
            return false;
         }
         if( document.form_new_user.to_date.value == "" ) {
            alert( "Please provide To Date!" );
            document.form_new_user.to_date.focus() ;
            return false;
         }
         if( document.form_new_user.campaign.value == "" ) {
            alert( "Please provide LOB!" );
            document.form_new_user.campaign.focus() ;
            return false;
         }

         return( true );
      }
   //-->
</script>

<script type="text/javascript">
		function checkDec(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$("#qaformsubmit").attr("disabled", "disabled");
				$('#phone').val("");
				return false;
			}
			if(el.value.length >10){
       			//alert("required 10 digits, match requested format!");
       			$("#start_phone").html("Required 10 digits, match requested format!");
       			$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }else if(el.value.length <10){
		    	$("#start_phone").html("Phone number can not be less than 10 digits!");
		    	$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }
		    else if(el.value.length == 10){
		    	$("#start_phone").html("");
		    	 $("#qaformsubmit").removeAttr("disabled");
       			return false;
		    }
		    // else{
		    // 	$("#start_phone").html("");
		    // 	 $("#qaformsubmit").removeAttr("disabled");
		    // }
			console.log(el.value);
		}
</script> 
<script type="text/javascript">
	function checkDecConsumer(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$("#qaformsubmit").attr("disabled", "disabled");
				$('#consumer_no').val("");
				return false;
			}
			// if(el.value.length >25){
   //     			//alert("required 10 digits, match requested format!");
   //     			$("#start_phone").html("Consumer number can not be more than 25 digits!");
   //     			$("#qaformsubmit").attr("disabled", "disabled");
   //     			return false;
		 //    }
		    if(el.value.length < 1){
		    	$("#start_phone").html("Consumer number can not be a negative digits!");
		    	$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }
		    else{
		    	$("#start_phone").html("");
		    	 $("#qaformsubmit").removeAttr("disabled");
       			return false;
		    }
		    // else{
		    // 	$("#start_phone").html("");
		    // 	 $("#qaformsubmit").removeAttr("disabled");
		    // }
			console.log(el.value);
		}
</script>

<script type="text/javascript">
	function checkDecCallNo(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$("#qaformsubmit").attr("disabled", "disabled");
				$('#call_number').val("");
				return false;
			}
			
		    if(el.value.length < 1){
		    	$("#start_phone").html("Call number can not be a negative digits!");
		    	$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }
		    else{
		    	$("#start_phone").html("");
		    	 $("#qaformsubmit").removeAttr("disabled");
       			return false;
		    }
		   
			console.log(el.value);
		}
</script>

<script type="text/javascript">
	// $(function () {
	// 	$( "#audit_type" ).on('change' , function() {
	// 		let val = $(this).val();
	// 		if(val == 'Calibration'){
	// 			$('#auditor_type').attr('required','required');
	// 		}else{
	// 			$('#auditor_type').attr('required', false);
	// 		}
	// 	});
	// });
</script>



<script>
$('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'mp4':
        case 'mp3':
		case 'wav':
		case 'm4a':
			$('#qaformsubmit').attr('disabled', false);
        break;
        default:
            alert('This is not an allowed file type. Please upload allowed file type like [m4a,mp4,mp3,wav]');
            this.value = '';
    }
});
</script>

<script>
	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date()}); //datetimepicker
	$("#call_date_time").datetimepicker({maxDate: new Date()});
	//$("#call_date").datepicker({ minDate: 0 });
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });

</script>

<script type="text/javascript">
	$(document).ready(function () {
	 // console.log("Hello World!");
	  var start_date	=	$("#from_date").val();
	  var end_date		=	$("#to_date").val();
	  if(start_date == '' && end_date == ''){
		  	$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	  if(end_date == ''){
	  		$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	  if(start_date == ''){
	  		$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	});
</script>

<script type="text/javascript">
	
	function date_validation(val,type){
	// alert(val);
		$(".end_date_error").html("");
		$(".start_date_error").html("");
		
		if(type=='E'){
		var start_date=$("#from_date").val();
		//if(val<start_date)
		if(start_date!=''){
			if(Date.parse(val) < Date.parse(start_date))
			{
				$(".end_date_error").html("To Date must be greater or equal to From Date");
				 $(".blains-effect").attr("disabled",true);
				 $(".blains-effect").css('cursor', 'no-drop');
			}
			else{
				 $(".blains-effect").attr("disabled",false);
				 $(".blains-effect").css('cursor', 'pointer');
				}

		}else{
				 $(".blains-effect").attr("disabled",true);
				 $(".blains-effect").css('cursor', 'no-drop');
		}
		
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(end_date!=''){
			if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
			
		}
		else{
			 $(".blains-effect").attr("disabled",false);
			 $(".blains-effect").css('cursor', 'pointer');
			}
		}else{
			$(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
		}
		

		}
	}
</script>

<script type="text/javascript">
	///////////////// Calibration - Auditor Type ///////////////////////	
	//$('.auType').hide();
	
	if($("#audit_type").val() == "Calibration"){
		$('.auType').show();
		$('#auditor_type').attr('required',true);
		$('#auditor_type').prop('disabled',false);
	}
	
	$('#audit_type').each(function(){
		$valdet=$(this).val();
		console.log($valdet);
		if($valdet=="Calibration"){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});

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

	///////////////////hcci core/////////////////

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
</script>
<script type="text/javascript">
	
	$('#tl_id').on('click', function(){
		alert("Can not Change TL");
		$("#tl_id").attr('disabled','disabled');
		return false;
	});
</script>


////////////////vikas//////////////////////////////


 <script type="text/javascript">
 	
 		function conduent_direct_express_calc(){
		let score_conduent = 0;
		let scoreable_conduent = 0;
		let quality_score_percent_conduent = 0.00;
		let pass_count_conduent = 0;
		let fail_count_conduent = 0;
		let na_count_conduent = 0;
		let score_conduent_direct_express_final = 0;
		let scoreable_conduent_direct_express_final = 0;

		$('.conduent_direct_express_point').each(function(index,element){
			let score_type_conduent = $(element).val();
			
			if(score_type_conduent == 'Pass'){
				pass_count_conduent = pass_count_conduent + 1;
				let w1_conduent = parseFloat($(element).children("option:selected").attr('conduent_direct_express_val'));
				let w2_conduent = parseFloat($(element).children("option:selected").attr('conduent_direct_express_max'));
				
				score_conduent = score_conduent + w1_conduent;
				scoreable_conduent = scoreable_conduent + w2_conduent;

			}else if(score_type_conduent == 'Fail'){
				fail_count_conduent = fail_count_conduent + 1;
				let w1_conduent = parseFloat($(element).children("option:selected").attr('conduent_direct_express_val'));
				let w2_conduent = parseFloat($(element).children("option:selected").attr('conduent_direct_express_max'));

				//score = score + w1;
				scoreable_conduent = scoreable_conduent + w2_conduent;
				//scoreable = scoreable + weightage;
			}else if(score_type_conduent == 'Opportunity'){
				na_count_conduent = na_count_conduent + 1;
				let w1_conduent = parseFloat($(element).children("option:selected").attr('conduent_direct_express_val'));
				let w2_conduent = parseFloat($(element).children("option:selected").attr('conduent_direct_express_max'));
				score_conduent = score_conduent + w1_conduent;
				scoreable_conduent = scoreable_conduent + w2_conduent;
			}
		});
		quality_score_percent_conduent = ((score_conduent*100)/scoreable_conduent).toFixed(2);

		if(quality_score_percent_conduent == "NaN"){
			quality_score_percent_conduent = (0.00).toFixed(2);
		}else{
			quality_score_percent_conduent = quality_score_percent_conduent;
		}
		
      score_conduent_direct_express_final     = (score_conduent).toFixed(2);
      scoreable_conduent_direct_express_final = (scoreable_conduent).toFixed(2);

		$('#conduent_direct_express_earned_score').val(score_conduent_direct_express_final);
		$('#conduent_direct_express_possible_score').val(scoreable_conduent_direct_express_final);
		
		if(!isNaN(quality_score_percent_conduent)){
			$('#conduent_direct_express_overall_score').val(quality_score_percent_conduent+'%');
		}

		if($('#conduentAF1').val()=='Fail' || $('#conduentAF2').val()=='Fail' || $('#conduentAF3').val()=='Fail' || $('#conduentAF4').val()=='Fail' || $('#conduentAF5').val()=='Fail' || $('#conduentAF6').val()=='Fail' || $('#conduentAF7').val()=='Fail' || $('#conduentAF8').val()=='Fail' || $('#conduentAF9').val()=='Fail'  || $('#conduentAF10').val()=='Fail' || $('#conduentAF11').val()=='Fail' || $('#conduentAF12').val()=='Fail' || $('#conduentAF13').val()=='Fail' || $('#conduentAF14').val()=='Fail' || $('#conduentAF15').val()=='Fail' || $('#conduentAF16').val()=='Fail' || $('#conduentAF17').val()=='Fail' || $('#conduentAF18').val()=='Fail' || $('#conduentAF19').val()=='Fail' || $('#conduentAF20').val()=='Fail' || $('#conduentAF21').val()=='Fail' || $('#conduentAF22').val()=='Fail' || $('#conduentAF23').val()=='Fail' || $('#conduentAF24').val()=='Fail' || $('#conduentAF25').val()=='Fail' || $('#conduentAF26').val()=='Fail' || $('#conduentAF27').val()=='Fail' || $('#conduentAF28').val()=='Fail' || $('#conduentAF29').val()=='Fail'){
			console.log($('#conduentAF1').val());

			quality_score_percent_conduent = (0.00).toFixed(2);
			$('.conduentFatal').val(quality_score_percent_conduent+'%');
		}else{
			$('#conduent_direct_express_overall_score').val(quality_score_percent_conduent+'%');
		}
	}
	
	$(document).on('change','.conduent_direct_express_point',function(){
		conduent_direct_express_calc();
	});
	$( document ).ready(function() {
    conduent_direct_express_calc();
	});
	
</script>


<script>
	//$( "#datepicker" ).datepicker({ minDate: 0});
//Edited By Samrat 30/9/21
	$(document).ready(function(){
		$("#from_date, #to_date, #call_date").datepicker();
		$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
		<?php if($this->uri->segment(2)=="Qa_sea_world" && $this->uri->segment(4)=="0"){?>
			//console.log("okk");
			//$("#epgi_earned_score, #epgi_possible_score").val("0");
		<?php }?>
	});
</script>

