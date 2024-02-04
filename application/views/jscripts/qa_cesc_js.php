<script type="text/javascript">
$(document).ready(function(){


$(document).on('change','.cesc',function(){ cesc_score(); });
$(document).on('change','.communication',function(){ cesc_score(); });
$(document).on('change','.resolution',function(){ cesc_score(); });
$(document).on('change','.zero',function(){ cesc_score(); });


cesc_score();
///////////////// Date Time Picker ///////////////////////
	$("#audit_date").datepicker();
	





$("#call_duration").timepicker({timeFormat:'HH:mm:ss' });

	
   $("#from_date").datepicker({  maxDate: new Date() });
	$("#to_date").datepicker({  maxDate: new Date() });
	

	$("#call_date").datetimepicker({  maxDate: new Date() });

	

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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////















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
	











jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
          
            return ((key == 8) || (key == 46) ||    (key == 189) || (key >= 48 && key <= 57)|| (key >= 96 && key <= 105)|| (key >= 65 && key <= 90));
        });
    });
};





$("#registration_no").ForceNumericOnly();
















$(function () {
   $('#phone_no').keydown(function (e) {
        if (e.shiftKey || e.ctrlKey || e.altKey) {
           e.preventDefault();
        } 
        else {
            var key = e.keyCode;
            if (!((key == 8) || (key == 46) || (key ==16) ||  (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
               e.preventDefault();
            }
        }
    });
});



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
								case 'wav':
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
		function cesc_score(){

var score = 0;
var scoreable = 0;
var overall_score=0;
$('.cesc').each(function(index,element){
	var score_type = $(element).val();
	if(score_type == 'Yes'){
		var w1 = parseFloat($(element).children("option:selected").attr('cesc_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('cesc_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'No'){
		var w1 = parseFloat($(element).children("option:selected").attr('cesc_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('cesc_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'N/A'){
		var w1 = parseFloat($(element).children("option:selected").attr('cesc_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('cesc_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	else if(score_type == 'Pass'){
		var w1 = parseFloat($(element).children("option:selected").attr('cesc_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('cesc_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	else if(score_type == 'Fail'){
		var w1 = parseFloat($(element).children("option:selected").attr('cesc_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('cesc_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
});

totScore = ((score*100)/scoreable).toFixed(2);

score=score.toFixed(2);
scoreable=scoreable.toFixed(2);

	$('#earned_score').val(score);
		$('#possible_score').val(scoreable);

		//alert(totScore);

		if($('#procedure').val()=='Fail' || $('#tagging').val()=='Fail' || $('#information').val()=='Fail' || $('#security').val()=='Fail'){
			totScore=0;
	        $("#overall_score").val(totScore+'%');
	 }else{
		if(!isNaN(totScore)){
		$('#overall_score').val(totScore+'%');
	  }
	  }


}
//////////

</script>







<script>
	function date_validation(val,type){ 
	// alert(val);
		$(".end_date_error").html("");
		$(".start_date_error").html("");
		if(type=='E'){
		var start_date=$("#from_date").val();
		//if(val<start_date)
		if(Date.parse(val) < Date.parse(start_date))
		{
			$(".end_date_error").html("To Date must be greater or equal to From Date");
			 $(".cesc-effect").attr("disabled",true);
			 $(".cesc-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".cesc-effect").attr("disabled",false);
			 $(".cesc-effect").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".cesc-effect").attr("disabled",true);
			 $(".cesc-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".cesc-effect").attr("disabled",false);
			 $(".cesc-effect").css('cursor', 'pointer');
			}

		}
		
		
	}






























</script>