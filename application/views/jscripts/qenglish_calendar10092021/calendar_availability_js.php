<script>

	$('.checkAll').click(function(){   
      var numberOfCheckboxes = $(".checkboxes").length;
      var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
	  $("#selectslbutton").hide();
      if(numberOfCheckboxesChecked < 1){
         $(".checkAll").prop("checked", true);
         $(".checkboxes").prop("checked", true); 
		 buttonShowChecker();
      } else {		  
         $(".checkAll").prop("checked", false);
         $(".checkboxes").prop("checked", false);
		 buttonShowChecker();
      }
   });
   
   $('.checkboxes').click(function(){   
     buttonShowChecker();
   });
   
function buttonShowChecker(){
	 var numberOfCheckboxes = $(".checkboxes").length;
     var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
	 if(numberOfCheckboxesChecked > 0){
		  $("#selectslbutton").show();
     } else {
		  $("#selectslbutton").hide();
	 }
}
   
</script>