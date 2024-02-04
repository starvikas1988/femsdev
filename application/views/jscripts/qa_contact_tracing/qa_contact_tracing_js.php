<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('#call_score_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() })
$('#from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() })
$('#to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() })

$('.number-only').keyup(function(e){
	if(this.value!='-')
	  while(isNaN(this.value))
		this.value = this.value.split('').reverse().join('').replace(/[\D]/i,'')
							   .split('').reverse().join('');
})
.on("cut copy paste",function(e){
	e.preventDefault();
});

$('#default-datatable').DataTable({
		"pageLength":50
});

<?php if(($content_template == "qa_contact_tracing/add_feedback.php") || (($content_template == "qa_contact_tracing/view_feedback.php"))){ ?>
	
// AGENT DROPDOWN FILTER
$('.form_contact_audit').on('change', '#agent_id', function(){
	fusion_id = $(this).find('option:selected').attr("fid");
	$('#fusion_id').val(fusion_id);
	$.ajax({
		url: "<?php echo base_url('qa_contact_tracing/qa_get_tl_filter'); ?>/" +  $(this).val(),
		cache: false,
		success: function(data){
			$("#tl_id").html(data);
		}
	});
});


updateScore();
function updateScore(){
$('.reviewTable table tr').each(function(){
	reviewEachScore = $(this).find('td').eq(1).find('option:selected').attr('score');
	$(this).find('td').eq(2).find('input').val(reviewEachScore);
});

greetingsScore = 0;
authenticationScore = 0;
clinincalScore = 0;
contactsScore = 0;
dataScore = 0;
closingScore = 0;
i = 1;
$('.greetingsTable tr').each(function(){
	i++; if(i>2){
	greetingsScore = Number(greetingsScore) + Number($(this).find('td').eq(1).find('option:selected').attr('score'));
	}
});
i = 1;
$('.authenticationTable tr').each(function(){
	i++; if(i>2){
	authenticationScore = Number(authenticationScore) + Number($(this).find('td').eq(1).find('option:selected').attr('score'));
	}
});
i = 1;
$('.clinicalTable tr').each(function(){
	i++; if(i>2){
	clinincalScore = Number(clinincalScore) + Number($(this).find('td').eq(1).find('option:selected').attr('score'));
	}
});
i = 1;
$('.contactsTable tr').each(function(){
	i++; if(i>2){
	contactsScore = Number(contactsScore) + Number($(this).find('td').eq(1).find('option:selected').attr('score'));
	}
});
i = 1;
$('.dataTable tr').each(function(){
	i++; if(i>2){
	dataScore = Number(dataScore) + Number($(this).find('td').eq(1).find('option:selected').attr('score'));
	}
});
i = 1;
$('.closingTable tr').each(function(){
	i++; if(i>2){
	closingScore = Number(closingScore) + Number($(this).find('td').eq(1).find('option:selected').attr('score'));
	}
});

greetingsPercent = (Number(greetingsScore)/Number($('.scoreTable tr').eq(1).find('td').eq(2).text())) * 100;
authenticationPercent = (Number(authenticationScore)/Number($('.scoreTable tr').eq(2).find('td').eq(2).text())) * 100;
clinicalPercent = (Number(clinincalScore)/Number($('.scoreTable tr').eq(3).find('td').eq(2).text())) * 100;
contactsPercent = (Number(contactsScore)/Number($('.scoreTable tr').eq(4).find('td').eq(2).text())) * 100;
dataPercent = (Number(dataScore)/Number($('.scoreTable tr').eq(5).find('td').eq(2).text())) * 100;
closingPercent = (Number(closingScore)/Number($('.scoreTable tr').eq(6).find('td').eq(2).text())) * 100;
totalScore = Number(greetingsScore) + Number(authenticationScore) + Number(clinincalScore) + Number(contactsScore) + Number(dataScore) + Number(closingScore);
totalPercent = Number(greetingsPercent) + Number(authenticationPercent) + Number(clinicalPercent) + Number(contactsPercent) + Number(dataPercent) + Number(closingPercent);
overallScore = (Number(totalPercent)/600) * 100;

$('.scoreTable tr').eq(1).find('td').eq(1).text(greetingsScore);
$('.scoreTable tr').eq(2).find('td').eq(1).text(authenticationScore);
$('.scoreTable tr').eq(3).find('td').eq(1).text(clinincalScore);
$('.scoreTable tr').eq(4).find('td').eq(1).text(contactsScore);
$('.scoreTable tr').eq(5).find('td').eq(1).text(dataScore);
$('.scoreTable tr').eq(6).find('td').eq(1).text(closingScore);

$('.scoreTable tr').eq(1).find('td').eq(3).text(greetingsPercent.toFixed(2));
$('.scoreTable tr').eq(2).find('td').eq(3).text(authenticationPercent.toFixed(2));
$('.scoreTable tr').eq(3).find('td').eq(3).text(clinicalPercent.toFixed(2));
$('.scoreTable tr').eq(4).find('td').eq(3).text(contactsPercent.toFixed(2));
$('.scoreTable tr').eq(5).find('td').eq(3).text(dataPercent.toFixed(2));
$('.scoreTable tr').eq(6).find('td').eq(3).text(closingPercent.toFixed(2));

$('#t_greeting_score').val(greetingsScore);
$('#t_authentication_score').val(authenticationScore);
$('#t_clinical_score').val(clinincalScore);
$('#t_contacts_score').val(contactsScore);
$('#t_data_score').val(dataScore);
$('#t_closing_score').val(closingScore);
$('#t_total_score').val(totalScore);
$('#t_overall_score').val(overallScore);


$('.scoreTable tr').eq(7).find('td').eq(1).text(totalScore);
$('.scoreTable tr').eq(7).find('td').eq(3).text(overallScore.toFixed(2));
$('.scoreTable tr').eq(9).find('td').eq(1).text(overallScore.toFixed(2));

overallRating(overallScore.toFixed(2));

}

function overallRating(score)
{
	resultRate = 'Critical List';
	if(Number(score) < 97){ resultRate = 'Critical List'; resultColor = '#ff4444'; }
	if((Number(score) >= 97) && (Number(score) < 99)){ resultRate = 'Good'; resultColor = '#37a3ff'; }
	if(Number(score) >= 99){ resultRate = 'Excellent'; resultColor = '#5ce218';  }
	$('.scoreTable tr').eq(9).find('td').eq(2).text(resultRate);
	$('.scoreTable tr').eq(9).find('td').eq(2).css('background-color', resultColor);
	$('.scoreTable tr').eq(9).find('td').eq(2).css('color', '#fff');
	$('.scoreTable tr').eq(9).find('td').eq(1).css('background-color', resultColor);
	$('.scoreTable tr').eq(9).find('td').eq(1).css('color', '#fff');
	return resultRate;
}

<?php } ?>






</script>