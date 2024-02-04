
<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#feedback_date").datepicker();
	$("#feedback_shared_date").datepicker();
	$("#audit_date_time").datetimepicker();
	$("#call_date_time").datetimepicker();
	$("#call_date").datetimepicker();
	$("#email_date_time").datetimepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	
	$("#agent_disposition").select2();
	$("#correct_disposition").select2();
	$("#qa_id").select2();
	$("#agent_id").select2(); 
	$("#officeLocation").select2(); 
	
	$('#vertical').select2();
	$('#campaign_process').select2();
	
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
	
////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_boomsourcing/getTLname';
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
				for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#xpoid').append($('#xpoid').val(json_obj[i].xpoid));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure));
				for (var i in json_obj) $('#office_name').append($('#office_name').val(json_obj[i].office_name));
				for (var i in json_obj) $('#vertical_name').append($('#vertical_name').val(json_obj[i].vertical_name));
				for (var i in json_obj) $('#channel_name').append($('#channel_name').val(json_obj[i].channel_name));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	  
//////////////////// Delete Audit ////////////////////////////
	$(".auditDelete").click(function(){
		var pid=$(this).attr("pid");
		var table=$(this).attr("table");
		var title=$(this).attr("title");
		var URL='<?php echo base_url();?>qa_snapdeal/audit_delete/'+table;
		var ans=confirm('Are you sure to '+title+" ?");
		if(ans==true){
			$.ajax({
			   type: 'POST',    
			   url: URL,
			   data:'pid='+ pid,
			   success: function(msg){
					location.reload();
				}
			});
		}
	});
	
	
});
</script>

<script>
//////////////////////////Phone Number validation///////////////////////////////////	
function checkDec(el)
{
    var ex = /^[0-9]+\.?[0-9]*$/;
    if(ex.test(el.value)==false){
        el.value = el.value.substring(0,el.value.length - 1);
    }
}	
///////////////////////////////
	function boomsourcing_calc(){
		
		var score=0;
		var scoreable=0;
		var totScore=0;
		$('.boomsourcing_point').each(function(index,element){
			var s1 = $(element).val();
			var w1=parseFloat($(this).children("option:selected").attr("boomsourcing_val"));
			if(s1=='Yes'){
				score = score + w1;
				scoreable = scoreable + w1;
			}else if(s1=='No' || s1=='Fatal'){
				scoreable = scoreable + w1;
			}else if(s1=='N/A'){
				score = score + w1;
				scoreable = scoreable + w1;
			}
		});
		totScore=((score/scoreable)*100).toFixed(2);
		
		$('#earnScore').val(score);
		$('#possibleScore').val(scoreable);
		if(!isNaN(totScore)){
			$('#overallScore').val(totScore);
		}
		//console.log(totScore)
		
	///////////////////////////
		var fatal_count=0;
		$('.boomsourcing_fatal').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='Fatal'){
				fatal_count=fatal_count+1;
			}
		});
		$('#boomsourcing_fatalcount').val(fatal_count);
		
		if(!isNaN(totScore)){
			$('#boomsourcing_prefatal').val(totScore);
		}
	
	//////Voice///////
		if($('#boomsourcingAF1').val()=='Fatal' || $('#boomsourcingAF2').val()=='Fatal' || $('#boomsourcingAF3').val()=='Fatal' || $('#boomsourcingAF4').val()=='Fatal' || $('#boomsourcingAF5').val()=='Fatal' || $('#boomsourcingAF6').val()=='Fatal' || $('#boomsourcingAF7').val()=='Fatal' || $('#boomsourcingAF8').val()=='Fatal' || $('#boomsourcingAF9').val()=='Fatal'){
			$('.boomsourcingFatal').val(0);
			totScore = 0;
		}else{
			$('.boomsourcingFatal').val(totScore+'%');
		}

		if(totScore == 0){
			$('#ncs').val('NCS0');
		}else if(totScore <75 && totScore>0){
			$('#ncs').val('NCS1');
		}else if(totScore <=90 && totScore>=76){
			$('#ncs').val('NCS2');
		}else if(totScore <=100 && totScore>=95)
		{
			$('#ncs').val('NCS3');
		}
	}

	
	$(document).ready(function(){
		
		$(document).on("change", ".boomsourcing_point", function(){
			boomsourcing_calc();
		});
		$(document).on("change", ".boomsourcing_point", function(){
			boomsourcing_calc();
		});
		boomsourcing_calc();	
	
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
	
	
	$('.imageFile').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'jpg':
			case 'jpeg':
			case 'png':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
	
});	
</script>