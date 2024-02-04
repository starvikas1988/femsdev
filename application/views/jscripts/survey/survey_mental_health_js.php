<script>
$('.viewMentalHealthDetails').click(function(){
	params = $(this).attr('dParam');
	clearRadioSelection();	
	setValuesSelection(params);
	$('#mentalDetailsModal').modal();
});

function clearRadioSelection(){
	<?php for($ik=1; $ik<= 10; $ik++){ ?>
	$("input[name='survey_<?php echo $ik; ?>']:checked").removeAttr('checked');
	<?php } ?>
}

function setValuesSelection(params){
	allParams = params.split('#');
	<?php for($ik=1; $ik<= 10; $ik++){ ?>
	$("input[name='survey_<?php echo $ik; ?>'][value='" +allParams[<?php echo $ik - 1; ?>]+"']").prop('checked', 'checked');
	<?php } ?>
}
</script>