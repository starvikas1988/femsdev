<script>
$('.optionCircle').click(function(){
  vals = $(this).attr('val');
  updater = $(this).attr('update');
  $(this).closest('div.row').find('.optionCircle').removeClass('optionCircleActive');
  $('#'+updater).val(vals);
  $(this).addClass('optionCircleActive');
});


$('.surveySubmission').click(function(){
	s1 = $('#survey_1').val();
	s2 = $('#survey_2').val();
	s3 = $('#survey_3').val();
	s4 = $('#survey_4').val();
	s5 = $('#survey_5').val();
	s6 = $('#survey_6').val();
	s7a = $('#survey_7a').val();
	s7b = $('#survey_7b').val();
	s7c = $('#survey_7c').val();
	s8a = $('#survey_8a').val();
	s8b = $('#survey_8b').val();
	s8c = $('#survey_8c').val();
	if(s1!="" && s2!="" && s3!="" && s4!="" && s5!="" && s6!="" && s7a!="" && s7b!="" && s7c!="" && s8a!="" && s8b!="" && s8c!="")
	{
		$('#surveyFormTna').submit();
	} else {
		alert('Please full up the all details carefully!');
	}
});

$('#answer').keyup(function () {
           var maxLength = 100;
           var text = $(this).val();
           var textLength = text.length;
           if (textLength > maxLength) {
               $(this).val(text.substring(0, (maxLength)));
               alert("Sorry, only " + maxLength + " characters are allowed");
           }
           else {
               //alert("Required Min. 500 characters");
           }
       });

	   
$('#answer1').keyup(function () {
           var maxLength = 100;
           var text = $(this).val();
           var textLength = text.length;
           if (textLength > maxLength) {
               $(this).val(text.substring(0, (maxLength)));
               alert("Sorry, only " + maxLength + " characters are allowed");
           }
           else {
               //alert("Required Min. 500 characters");
           }
       });
</script>