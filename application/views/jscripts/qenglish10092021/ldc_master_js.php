<script>
$('#search_from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });
$('#search_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });



$(function(){
   var today = new Date();
  var datesss =  $(".date_pic").datepicker({
	  minDate: today,
    // dateFormat: 'dd/mm/yy',
    
   }).val();
   $('.time_pic').timepicker({
	  showSecond: true,
	  timeFormat: 'HH:mm:ss'
   });

  
 });
 function myFunction(elem) {
  

  var d = new Date($(elem).val());
  var weekday = new Array(7);
  weekday[0] = "SUN";
  weekday[1] = "MON";
  weekday[2] = "TUE";
  weekday[3] = "WED";
  weekday[4] = "THU";
  weekday[5] = "FRI";
  weekday[6] = "SAT";

  var n = weekday[d.getDay()];
  //document.getElementById("demo").innerHTML = ny;
  $("#schedule_days").val(n);
  $("#schedule_days_new").val(n);
}



 

//  button 
$(function(){
  $("#selectslbutton").each(function(){
          $(this).hide();
        });

   $("#selectslbutton_cancel").each(function(){
          $(this).hide();
        });
    
  //  $('.checkAll').click(function(){
  //     if (this.checked) {
  //       $("#selectslbutton").show();
  //        $(".checkboxes").prop("checked", true);

  //     } else {
  //       $("#selectslbutton").hide();
  //        $(".checkboxes").prop("checked", false);
  //     }	
  //  });
 
  //  $(".checkboxes").click(function(){
  //   if(this.checked){
  //     $("#selectslbutton").show();
  //   }
  //   // else{
  //   //   $("#selectslbutton").hide();
  //   // }
  //  });


   $(".checkboxessss").click(function(){
      var numberOfCheckboxes = $(".checkboxes").length;
      var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
      if(numberOfCheckboxes == numberOfCheckboxesChecked) {
         $(".checkAll").prop("checked", true);

      } else {
         $(".checkAll").prop("checked", false);
        //  $("#selectslbutton").hide();
      }
   });



   $('.checkAll').click(function(){
    
    var numberOfCheckboxes = $(".checkboxes").length;
      var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
      if(numberOfCheckboxesChecked < 1){
         $(".checkAll").prop("checked", true);
         $(".checkboxes").prop("checked", true);
         $("#selectslbutton").show();
         $("#selectslbutton_cancel").show();
      // $('#myModal').modal();

      } else {
        $(".checkAll").prop("checked", false);
         $(".checkboxes").prop("checked", false);
         $("#selectslbutton").hide();
         $("#selectslbutton_cancel").hide();
      }
   });

   
  
 
});

$(".checkboxes").click(function(){
    getSelectCheckbox();
  });

function getSelectCheckbox(){
    var classCheck = "checkboxes";
    var buttonCheck = "selectslbutton";
    var numberOfCheckboxes = $("."+classCheck).length;
     var numberOfCheckboxesChecked = $('.'+classCheck+':checked').length;
    if(numberOfCheckboxesChecked < 1){
      //alert('hi');
        $("#"+buttonCheck).hide();
        $("#selectslbutton_cancel").hide();
    } else {
      //alert('hisss');
      // $('#myModal').modal();
      $("#"+buttonCheck).show();
      $("#selectslbutton_cancel").show();
    }
}

//   $('input[type="checkbox"]').on('change', function(e){
//    if(e.target.checked){
//      $('#myModal').modal();
//    }
// });


   $(document).ready(function() {
  $('#checkedli1').click(function(event) {
    if (this.checked) {
      $('.uncheckedli1').each(function() { //loop through each checkbox
        $(this).prop('disabled', true); //check 
        $(this).prop('checked',false);
      });
    } else {
      $('.uncheckedli1').each(function() { //loop through each checkbox
        $(this).prop('disabled', false); //uncheck              
      });
    }
  });
  $('#checkedli2').click(function(event) {
    if (this.checked) {
      $('.uncheckedli2').each(function() { //loop through each checkbox
        $(this).prop('disabled', true);
        $(this).prop('checked',false); //check 
      });
    } else {
      $('.uncheckedli2').each(function() { //loop through each checkbox
        $(this).prop('disabled', false); //uncheck              
      });
    }
  });
  $('#checkedli3').click(function(event) {
    if (this.checked) {
      $('.uncheckedli3').each(function() { //loop through each checkbox
        $(this).prop('disabled', true);
        $(this).prop('checked',false); //check 
      });
    } else {
      $('.uncheckedli3').each(function() { //loop through each checkbox
        $(this).prop('disabled', false); //uncheck              
      });
    }
  });
  $('#checkedli4').click(function(event) {
    if (this.checked) {
      $('.uncheckedli4').each(function() { //loop through each checkbox
        $(this).prop('disabled', true);
        $(this).prop('checked',false); //check 
      });
    } else {
      $('.uncheckedli4').each(function() { //loop through each checkbox
        $(this).prop('disabled', false); //uncheck              
      });
    }
  });
  $('#checkedli5').click(function(event) {
    if (this.checked) {
      $('.uncheckedli5').each(function() { //loop through each checkbox
        $(this).prop('disabled', true);
        $(this).prop('checked',false); //check 
      });
    } else {
      $('.uncheckedli5').each(function() { //loop through each checkbox
        $(this).prop('disabled', false); //uncheck              
      });
    }
  });
  $('#checkedli6').click(function(event) {
    if (this.checked) {
      $('.uncheckedli6').each(function() { //loop through each checkbox
        $(this).prop('disabled', true);
        $(this).prop('checked',false); //check 
      });
    } else {
      $('.uncheckedli6').each(function() { //loop through each checkbox
        $(this).prop('disabled', false); //uncheck              
      });
    }
  });
  $('#checkedli7').click(function(event) {
    if (this.checked) {
      $('.uncheckedli7').each(function() { //loop through each checkbox
        $(this).prop('disabled', true);
        $(this).prop('checked',false); //check 
      });
    } else {
      $('.uncheckedli7').each(function() { //loop through each checkbox
        $(this).prop('disabled', false); //uncheck              
      });
    }
  });
  
  
  $('.fromdateCheck').on('change keyup', function(){
	 lastDate =  "<?php echo $lastDate; ?>";
	 lastDateName =  "<?php echo date('d M, Y', strtotime($lastDate)); ?>";
	 currData = $(this).val();
	 if(lastDate != ""){
		var startDate = new Date($(this).val());
		var endDate = new Date(lastDate);
		if(Date.parse(currData) <= Date.parse(endDate)){
			$(this).val('');
			alert('You have already added availability till ' + lastDateName +', Please Select date carefully!');
		}
	 }
  });
  
});


</script>