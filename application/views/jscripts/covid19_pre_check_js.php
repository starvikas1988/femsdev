<script>
	
	$(document).ready(function(){
		
		var baseURL = "<?php echo base_url(); ?>";
		var location = "<?php echo get_user_office_id(); ?>";
		
		
		$("#date_from").datepicker();
		$("#date_to").datepicker();
		
		
		$('.checkPreCovid19').submit(function() {
			
			var medical = $(this).find('input[class="medical"]:checked');
			var symptom = $(this).find('input[class="symptom"]:checked');
			
			if (!medical.length) {
				alert('You must check at least one box of PRE-EXISTING MEDICAL CONDITIONS AND PREDISPOSITIONS!');
				return false; // The form will *not* submit
			}
			
			if (!symptom.length) {
				alert('You must check at least one box of SYMPTOMS CHECK!');
				return false; // The form will *not* submit
			}
			
		});
		
		
		
		$("#pre_exist_pregnant").on("click", function(){
			if($(this).val()!=""){
				$("#pre_exist_pregnant_text").prop('required', true);
			}else{
				$("#pre_exist_pregnant_text").prop('required', false);
			}
		});
		
		$("#pre_exist_disease").on("click", function(){
			if($(this).val()!=""){
				$("#pre_exist_disease_text").prop('required', true);
			}else{
				$("#pre_exist_disease_text").prop('required', false);
			}
		});
		
		
		$("#symptoms_fever").on("click", function(){
			if($(this).val()!=""){
				$("#fever_how_long").prop('required', true);
			}else{
				$("#fever_how_long").prop('required', false);
			}
		});
		
		$("#symptoms_cough").on("click", function(){
			if($(this).val()!=""){
				$("#cough_how_long").prop('required', true);
			}else{
				$("#cough_how_long").prop('required', false);
			}
		});
		
		
	});	
</script>
