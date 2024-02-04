<script type="text/javascript">	

var startDt = new Date;
var tm_tm_total_seconds=0;
var tmInv=null;
var isUserNewHomePageModel = "<?php echo !empty($isUserNewHomePageModel) ? $isUserNewHomePageModel : 0; ?>";

$(document).ready(function () {
			
	if(isUserNewHomePageModel=="0") $("#homeUserNewHomePageModel").modal('show');
	
	$(".btnNewHomePage").click(function(){
		
		var ans =$(this).attr('value');
		
		$('#sktPleaseWait').modal('show');
		$('#homeUserNewHomePageModel').modal('hide');
		
		var rURL=baseURL+'home/saveUserNewhome';
		
		$.ajax({
		   type: 'POST',
		   data: { ans: ans} ,
		   url:rURL,
		   success: function(tbDtata){
			   
			   $('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		});
			  
			  
	});
	
///////////////////////////////////////////////////////
	
	$("input.break_onoff").click(function(e){
		
		var typ =$(this).attr('typ');
						
		var onUrl="<?php echo base_url();?>users/break_on_ld";
		var offUrl="<?php echo base_url();?>users/break_off_ld";
			
		if(typ=="coaching"){
			var onUrl="<?php echo base_url();?>users/break_on_coaching";
			var offUrl="<?php echo base_url();?>users/break_off_coaching";
		}else if(typ=="others"){
			var onUrl="<?php echo base_url();?>users/break_on";
			var offUrl="<?php echo base_url();?>users/break_off";
		}else if(typ=="downtime"){
			var onUrl="<?php echo base_url();?>users/break_on_system_downtime";
			var offUrl="<?php echo base_url();?>users/break_off_system_downtime";
		}
		
		if($(this).prop("checked")==true){
			
			swal({
			  title: "Are You Sure to Turn "+ typ +" Break Timer On?",
			  text: "",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
				if(willDelete){
					
					$('#sktPleaseWait').modal('show');
					
					$.post( onUrl ,function(data){
						//window.location.href = "<?php echo base_url();?>home";
							
							$('#sktPleaseWait').modal('hide');
							
							startDt = new Date;
							tm_total_seconds=0;
							
							$("#lunch_timer").html("00:00");
							$("#coaching_timer").html("00:00");
							$("#others_timer").html("00:00")
							
							tmInv = setInterval(start_break_timer, 1000,typ);
							 
							$("input.break_onoff").prop('disabled', true);
							$("[typ="+typ+"]").prop('disabled', false);
							
					});
					

				}else{
					
					$(this).prop("checked",false);
					$("input.break_onoff").prop("checked",false);
					$("input.break_onoff").prop('disabled', false);
							
					
				}
			
			});
			
			
		}else{
			
				//alert("Off");
				
				$('#sktPleaseWait').modal('show');
				$.post(offUrl,function(data){
					if(data==1){
						//window.location.href = "<?php echo base_url();?>home";
						$('#sktPleaseWait').modal('hide');
						
						clearInterval(tmInv);
						clearInterval (countdownTimer_onload);
						
						$(this).prop("checked",false);
						$("input.break_onoff").prop("checked",false);
						$("input.break_onoff").prop('disabled', false);
					
					}else{
						$(this).prop("checked",true);
						alert(data); 
						$('#sktPleaseWait').modal('hide');
						//("Error Occurred. Contact TL/Supervisor/Administrator");
					}
				});
		}
		
				
	});
	
	
	
	$(".viewModalAttendance").click(function(){
		
		if(processAttendanc=="Y"){
			
			$('#attendance_model').modal('show');
			
		}else{
			
			$('#sktPleaseWait').modal('show');
			
			var rURL=baseURL+'home/getCurrentAttendance';
			
			$.ajax({
			   type: 'POST',    
			   url:rURL,
			   success: function(tbDtata){
				   
				   $('#sktPleaseWait').modal('hide');
				   $('#attendance_model').modal('show');	
				   $('#currAttendanceTable').html(tbDtata);
				   processAttendanc = "Y";
				   
				},
				error: function(){	
					alert('Fail!');
					$('#sktPleaseWait').modal('hide');
				}
			  });
		
		}
		////
		
	});



	
  $("#appSearchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".mega-widget li a").filter(function() {
      $(this).closest("li").toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
  



	
	
});


function start_break_timer(typ){
	
	tm_total_seconds++;
	
	var hours = Math.floor(tm_total_seconds / 3600);
	var seconds_left = tm_total_seconds % 3600;
	var minutes = Math.floor(seconds_left / 60);
	seconds_left = seconds_left % 60;
	var seconds = Math.floor(seconds_left);
  
	$("#"+typ+"_timer").html(hours +":"+ pad2d(minutes)+":"+pad2d(seconds));
		
	//alert(typ);
  
}

  function pad2d(num) {
    return ( num < 10 ? "0" : "" ) + num;
  }
  
  
  
</script>
  

