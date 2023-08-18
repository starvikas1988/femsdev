<script>
	$(document).ready(function(){
	
	//////////////////// Date Time Picker ////////////////////////
		$("#agent_id").select2();
		$("#from_date").datepicker({maxDate: new Date() });
	    $("#to_date").datepicker({maxDate: new Date() });
	    $("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
		$("#audit_date").datepicker({
			dateFormat: 'mm-dd-yy'
		});
		$("#call_date").datepicker({maxDate: new Date()}); //datetimepicker
		$("#call_date_time").datetimepicker({ timeFormat:'HH:mm:ss',maxDate: new Date()});
		// $('#call_date_time').datetimepicker({
		//     dateFormat: "yy-mm-dd",
		//     timeFormat:  "hh:mm:ss"
		// });
		// $("#call_date").datepicker({
		// 	maxDate: new Date(),
		// 	dateFormat: 'mm-dd-yy'
		// });
		// $("#call_date_time").datetimepicker({
		// 	maxDate: new Date(),
		// 	dateFormat: 'mm-dd-yy'
		// });

		//$("#call_duration").timepicker({ timeFormat:'HH:mm:ss', showButtonPanel:false });
		$("#call_duration1").timepicker({ timeFormat:'HH:mm:ss', showButtonPanel:false });
		// $("#from_date").datepicker({
		// 	onSelect: function(selected) {
		// 	  $("#to_date").datepicker("option","minDate", selected);
		// 	},
		// 	dateFormat: 'mm-dd-yy'
		// });
		// $("#to_date").datepicker({
		// 	onSelect: function(selected) {
		// 	   $("#from_date").datepicker("option","maxDate", selected);
		// 	},
		// 	dateFormat: 'mm-dd-yy'
		// });
		$("#call_start_date").datepicker({
			onSelect: function(selected) {
			  $("#call_end_date").datepicker("option","minDate", selected);
			},
			maxDate: new Date(),
			dateFormat: 'mm-dd-yy'
		});
		$("#call_end_date").datepicker({
			onSelect: function(selected) {
			   $("#call_start_date").datepicker("option","maxDate", selected);
			},
			maxDate: new Date(),
			dateFormat: 'mm-dd-yy'
		});
		
		
	///////////////// Auditor Type - Calibration ///////////////////////	
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
	
	///////////////// Agent and TL names ///////////////////////
		$( "#agent_id" ).on('change' , function() {	
			var aid = this.value;
			if(aid=="") alert("Please Select Agent")
			var URL='<?php echo base_url();?>qa_belmont/getTLname';
			$('#sktPleaseWait').modal('show');
			$.ajax({
				type: 'POST',    
				url:URL,
				data:'aid='+aid,
				success: function(aList){
					var json_obj = $.parseJSON(aList);
					$('#tl_name').empty();
					$('#tl_name').append($('#tl_name').val(''));	
					for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
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
		
	///////////////////// Upload File Condition ///////////////////////
		$('INPUT[type="file"]').change(function (){
			var ext = this.value.match(/\.(.+)$/)[1];
			switch (ext){
				case 'mp3':
				case 'mp4':
				case 'wav':
				case 'm4a':
				$('#qaformsubmit').attr('disabled', false);
					break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
		});
		
		$("#email").change(function () {    
			var inputvalues = $(this).val();    
			var regex = /^([a-z0-9_.+-])+\@(([a-z0-9-])+\.)+([a-z0-9]{2,4})+$/;    
			if(!regex.test(inputvalues)){    
				alert("invalid Email ID");
				$('#email').val('');
				return regex.test(inputvalues);    
			}    
		});
		
		$("#email1").change(function () {    
			var inputvalues = $(this).val();    
			var regex = /^([a-z0-9_.+-])+\@(([a-z0-9-])+\.)+([a-z0-9]{2,4})+$/;     
			if(!regex.test(inputvalues)){    
				alert("Invalid Email ID");
				$('#email1').val('');				
				return regex.test(inputvalues);    
			}    
		});
	
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
<script>
//////////////////// Phone Number Validation ///////////////////
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
	
	function phone_noFunction(phone_no){
		var phone_no=$("#phone_no").val();
		var pattern =/^[0-9]+\.?[0-9]*$/;    
		if(!pattern.test(phone_no)){
			$("#msg-phone_no").html("<font color=red style='font-size:14px;'>This Phone No  is not valid </font>");
			$(".waves-effect").attr("disabled",true);
			$(".waves-effect").css('cursor', 'no-drop');
		}else if((phone_no.length <10) || (phone_no.length >12)){
			$("#msg-phone_no").html("<font color=red style='font-size:14px;'>Please enter at least 10-12 characters inside the Text Box</font>");
			$(".waves-effect").attr("disabled",true);
			$(".waves-effect").css('cursor', 'no-drop');
		}else{
			$("#msg-phone_no").html("");
			$(".waves-effect").attr("disabled",false);
			$(".waves-effect").css('cursor', 'pointer');
		}
	}
</script>


<script>
	function score_calculation(){
	
	/*---- Main score calculation ----*/
		var score = 0;
		var scoreable = 0;
		var overall_score=0;
		$('.scorecalc').each(function(index,element){
			var w1 = parseFloat($(element).children("option:selected").attr('scr_val'));
			var w2 = parseFloat($(element).children("option:selected").attr('scr_max'));
			score = score + w1;
			scoreable = scoreable + w2;
		});
		overall_score = ((score*100)/scoreable).toFixed(2);
		$('#earned_score').val(score.toFixed(2));
		$('#possible_score').val(scoreable.toFixed(2));
		if(!isNaN(overall_score)){
			$('#overall_score').val(overall_score+'%');
		}
		
	/*---- Customer score calculation ----*/
		var cust_score = 0;
		var cust_scoreable = 0;
		var cust_overall_score=0;
		$('.customer').each(function(index,element){
			var cw1 = parseFloat($(element).children("option:selected").attr('scr_val'));
			var cw2 = parseFloat($(element).children("option:selected").attr('scr_max'));
			cust_score = cust_score + cw1;
			cust_scoreable = cust_scoreable + cw2;
		});
		cust_overall_score = ((cust_score*100)/cust_scoreable).toFixed(2);
		$('#customer_score').val(cust_score);
		$('#customer_scoreable').val(cust_scoreable);
		if(!isNaN(cust_overall_score)){
			$('#customer_total').val(cust_overall_score+'%');
		}
	/*---- Business score calculation ----*/
		var busi_score = 0;
		var busi_scoreable = 0;
		var busi_overall_score=0;
		$('.business').each(function(index,element){
			var bw1 = parseFloat($(element).children("option:selected").attr('scr_val'));
			var bw2 = parseFloat($(element).children("option:selected").attr('scr_max'));
			busi_score = busi_score + bw1;
			busi_scoreable = busi_scoreable + bw2;
		});
		busi_overall_score = ((busi_score*100)/busi_scoreable).toFixed(2);
		$('#business_score').val(busi_score);
		$('#business_scoreable').val(busi_scoreable);
		if(!isNaN(busi_overall_score)){
			$('#business_total').val(busi_overall_score+'%');
		}
	/*---- Business score calculation ----*/
		var comp_score = 0;
		var comp_scoreable = 0;
		var comp_overall_score=0;
		$('.compliance').each(function(index,element){
			var cmw1 = parseFloat($(element).children("option:selected").attr('scr_val'));
			var cmw2 = parseFloat($(element).children("option:selected").attr('scr_max'));
			comp_score = comp_score + cmw1;
			comp_scoreable = comp_scoreable + cmw2;
		});
		comp_overall_score = ((comp_score*100)/comp_scoreable).toFixed(2);
		$('#compliance_score').val(comp_score);
		$('#compliance_scoreable').val(comp_scoreable);
		if(!isNaN(comp_overall_score)){
			$('#compliance_total').val(comp_overall_score+'%');
		}
		
	//////// Belmont //////////
		if(score>=64 && score<=100){
			$('#performance_rating').val('Excellent').css('color','green');
		}else if(score>=51 && score<64){
			$('#performance_rating').val('Good').css('color','green');
		}else if(score>=42 && score<51){
			$('#performance_rating').val('Meets Expectation').css('color','blue');
		}else if(score>=35 && score<42){
			$('#performance_rating').val('Opportunity').css('color','orange');
		}else if(score<35){
			$('#performance_rating').val('Dissatisfaction').css('color','red');
		}
		
	//////// Unacademy V2 //////////
		if(($("#unacv2AF1").val()=='RE' || $("#unacv2AF1").val()=='ZT') || ($("#unacv2AF2").val()=='RE' || $("#unacv2AF2").val()=='ZT') || ($("#unacv2AF3").val()=='RE' || $("#unacv2AF3").val()=='ZT') || ($("#unacv2AF4").val()=='RE' || $("#unacv2AF4").val()=='ZT') || ($("#unacv2AF5").val()=='RE' || $("#unacv2AF5").val()=='ZT') || ($("#unacv2AF6").val()=='RE' || $("#unacv2AF6").val()=='ZT') || ($("#unacv2AF7").val()=='RE' || $("#unacv2AF7").val()=='ZT') || ($("#unacv2AF8").val()=='RE' || $("#unacv2AF8").val()=='ZT') || ($("#unacv2AF9").val()=='RE' || $("#unacv2AF9").val()=='ZT')){
			$(".unacademyv2Fatal").val(0);
		}else{
			$(".unacademyv2Fatal").val(overall_score+'%');
		}
		
	//////// Intelycare //////////
		if($("#intelycareOBAF1").val()=='No'){
			$(".intelycareOBFatal").val(0);
		}else{
			$(".intelycareOBFatal").val(overall_score+'%');
		}
		
	//////// Ossur [Voice & Email] //////////
		if($("#ossurVoiceAF1").val()=='Missed' || $("#ossurVoiceAF2").val()=='Missed' || $("#ossurVoiceAF3").val()=='Missed' || $("#ossurVoiceAF4").val()=='Missed' || $("#ossurVoiceAF5").val()=='Missed'|| $("#ossurVoiceAF6").val()=='Missed'){
			$(".ossurVoiceFatal").val(0);
		}else{
			$(".ossurVoiceFatal").val(overall_score+'%');
		}
		if($("#ossurEmailAF1").val()=='No' || $("#ossurEmailAF2").val()=='No' || $("#ossurEmailAF3").val()=='No' || $("#ossurEmailAF4").val()=='No' || $("#ossurEmailAF5").val()=='No'|| $("#ossurEmailAF6").val()=='No'){
			$(".ossurEmailFatal").val(0);
		}else{
			$(".ossurEmailFatal").val(overall_score+'%');
		}
		
	///////////// ATT Compliance GBRM //////////////////
		if($("#compAF1").val()=='Yes' || $("#compAF2").val()=='Yes' || $("#compAF3").val()=='Yes' || $("#compAF4").val()=='Yes' || $("#compAF5").val()=='Yes' || $("#compAF6").val()=='Yes' || $("#compAF7").val()=='Yes' || $("#compAF8").val()=='Yes' || $("#compAF9").val()=='Yes' || $("#compAF10").val()=='Yes' || $("#compAF11").val()=='Yes' || $("#compAF12").val()=='Yes' || $("#compAF13").val()=='Yes' || $("#compAF14").val()=='Yes' || $("#compAF15").val()=='Yes' || $("#compAF16").val()=='Yes' || $("#compAF17").val()=='Yes' || $("#compAF18").val()=='Yes' || $("#compAF19").val()=='Yes' || $("#compAF20").val()=='Yes' || $("#compAF21").val()=='Yes'){
			$("#att_compliance_score").val(0+'%');
		}else{
			$("#att_compliance_score").val(100+'%');
		}
	
	///////////// ATT Whitespace //////////////////
		if($("#attWhitespaceAF1").val()=='No' || $("#attWhitespaceAF2").val()=='No' || $("#attWhitespaceAF3").val()=='No'){
			$(".whitespaceFatal").val(0);
		}else{
			$(".whitespaceFatal").val(overall_score+'%');
		}
	
	///////////// HCCI Core V2 Converted & Unconverted //////////////////
		if($("#coreConverted_AF1").val()=='Yes'){
			$(".coreConvertedFatal").val(0);
		}else{
			$(".coreConvertedFatal").val(overall_score+'%');
		}
		
		if($("#coreUnconverted_AF1").val()=='Yes'){
			$(".coreUnconvertedFatal").val(0);
		}else{
			$(".coreUnconvertedFatal").val(overall_score+'%');
		}
		
	
	}
	
	$(document).ready(function(){
		$(document).on('change','.scorecalc',function(){ score_calculation(); });
		$(document).on('change','.customer',function(){ score_calculation(); });
		$(document).on('change','.business',function(){ score_calculation(); });
		$(document).on('change','.compliance',function(){ score_calculation(); });
	/////// ATT Compliance ///////
		$(document).on('change','.comp_scorecalc',function(){ score_calculation(); });
		
		score_calculation();
	});
</script>

<script>
	$(document).ready(function(){
		
		$(".dataAnalytics").click(function(){
			$('#modalDataAnalytics').modal('show');
		});
		
	});
</script>