<script type="text/javascript" language="javascript" src="https://wfh.ameyoengage.com:8443/ameyochatjs/ameyo-emerge-chat.js" async defer></script>   
<script type="text/javascript"> 
var campaignId = '11';
var nodeflowId = '5';
var ameyoUrl = 'https://wfh.ameyoengage.com:8443'
var phoneNoRegex = "^[+]{0,1}[0-9]{9,16}$";

var ameyo_script = document.createElement('script');
ameyo_script.onload = function() {
        try {
            initializeChat(campaignId, nodeflowId,ameyoUrl,null,null,null,null,null, phoneNoRegex);
        } catch (err) {
            console.error( err);
        }
    };
ameyo_script.src = ameyoUrl+"/ameyochatjs/ameyo-emerge-chat.js";
document.getElementsByTagName('head')[0].appendChild(ameyo_script);
</script>

<script type="text/javascript">

function getRndInteger(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}


$(document).ready(function(){
	
	$("#dob").datepicker({maxDate: new Date(), changeMonth: true, changeYear: true, yearRange: "c-70:c+0"});
	
	var processAttendanc="N";
	var isPayrollPopup = "<?php echo $isPayrollPopup; ?>";
	var isMoodModel = "<?php echo $isMoodModel; ?>";
	//alert(isPayrollPopup);
	
	if(isPayrollPopup == "1") $("#infoPayrollFrmModel").modal('show');
		
	var is_OpenPayPopup = "<?php echo $is_OpenPayPopup; ?>";
	if(is_OpenPayPopup == "Y") $("#acceptPayInfoModal").modal('show');
	
	var is_global_access = "<?php echo get_global_access(); ?>";
	var office_id = "<?php echo get_user_office_id(); ?>";
	var dept_folder = "<?php echo get_dept_folder(); ?>";
	var role_folder = "<?php echo get_role_dir(); ?>";
	
	$("#homeImgModelAllLocation").modal('show');
	//$("#homeImgModelAllLocation2").modal('show');
	
	<?php if(get_role_dir() != 'agent'){ ?>
		//$("#homeImgModelAllLocationLink").modal('show');
	<?php } ?>
	
	if(isMoodModel==0) $("#homeYourMoodAllLoc").modal('show');
	
	$(".YourMood").click(function(){
		
		var txt=$(this).attr("txt");
		//var r = confirm("Your Mood on Today is "+txt+"\r\nAre You Sure About Your Mood?");
		var r =true;	
		if(r===true){
			var dUrl="<?php echo base_url();?>home/saveYourMood?txt="+txt;
			$('#sktPleaseWait').modal('show');
			$.ajax({
				type	:	'GET',
				url		:	dUrl,
				success	:	function(msg){
							$('#sktPleaseWait').modal('hide');
							$("#homeYourMoodAllLoc").modal('hide');						
						}
			});
		}
	});
	
	$('#myModal').on('shown.bs.modal', function() {
  $('#myInput').focus()
})
	
	$("#audioOn").click(function(){
		var vid = document.getElementById("femsHomeVideo");
		vid.muted = false;
		$(this).hide();
	});
	
	//on close remove
    $('#homeVideoNewBrandAllLoc').on('hidden.bs.modal', function () {
		$('#homeVideoNewBrandAllLoc .modal-body').empty();
    });
	
	if( isADLocation(office_id)==false && office_id !="ALT" && office_id !="DRA"){
		//$("#homeVideoNewBrandAllLoc").modal('show');
		//$("#homeImageNewBrandAllLoc").modal('show');
		
	}
	
	
	//$("#homeImgModelItAssessment").modal('show');
	/* $("#homeImgModelItAssessment").on('click', function(){
		$('#homeImgModelItAssessment').modal('hide');
	}); */
	
	//$("#itAssessment").modal('show');
	
	//if(office_id=="KOL" || office_id=="BLR" || office_id=="HWH" || office_id=="NOI"){
		
	if( isIndiaLocation(office_id)==true){
		//$("#IndCarousel").carousel(0);
		//$("#homeImgModelInd").modal('show');
	}
	
	if(office_id=="ALT" || is_global_access=='1'){
		//$("#homeImgModelALT").modal('show');
	}
	
	if(office_id=="ELS" || is_global_access=='1'){
		//$("#ElsCarousel").carousel(getRndInteger(0,5));
		//$("#ElsCarousel").carousel(0);
		//$("#homeImgModelEsl").modal('show');
	}
		
	if(office_id=="KOL" && (dept_folder !="operations" || role_folder !="agent")){
		//$("#applnIjpImgModel").modal('show');
		//$("#homeImgModelKol").modal('show');	
	}
		
	if(office_id=="CEB" || is_global_access=='1'){
		//$("#CebCarousel").carousel(0);
		//$("#refCebuImgModel").modal('show');
	}
	
	if(office_id=="MAN" || is_global_access=='1'){
		//$("#ManCarousel").carousel(0);
		//$("#refManImgModel").modal('show');
	}
	
	if(office_id=="CEB" || office_id=="MAN" || is_global_access=='1'){
		//$("#philCarousel").carousel(0);
		//$("#PhilImgModel").modal('show');
	}
		
	/*
	$("#applnIjpModelBtn").click(function(){
		$("#applnIjpFrmModel").modal('show');
		$("#applnIjpImgModel").modal('hide');		
	});
	*/
	
	$("#homeImgModelKolBtn").click(function(){
		
		var isApply=$(this).attr("isApply");
				
		if(isApply>0){
			alert('You Already Applied.');
			
		}else{
			$("#frmHomeImgModelKol").modal('show');
			$("#homeImgModelKol").modal('hide');
		}
		
	});
	
	$("#refCebuAddRefModelBtn").click(function(){
		$("#addReferrals").modal('show');
		$("#refCebuImgModel").modal('hide');
	});
	
	$("#refManAddRefModelBtn").click(function(){
		$("#addReferrals").modal('show');
		$("#refManImgModel").modal('hide');
	});
	
	
	$("#refCebuModelBtn").click(function(){
		$("#refCebuFrmModel").modal('show');
		$("#refCebuImgModel").modal('hide');
	});
	
	
	$("#accepteGaze").click(function(){
		
		var dUrl="<?php echo base_url();?>home/accepteGaze?var=1.0.1.2";
		
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type	:	'POST',
			url		:	dUrl,
			success	:	function(msg){
						$('#sktPleaseWait').modal('hide');
						$('#EGazeDownModel').modal('hide');
						window.location = '<?php echo base_url();?>assets/egaze/EfficiencyX_Fems_V1.0.1.2.msi';
						//window.open('<?php echo base_url();?>assets/egaze/EGaze_Setup.msi', "_blank")
						
					}
		});
			
			
	});
	
	$('.frmHomeKolSeed').submit(function(e) {
		
				
		var location_id=$('.frmHomeKolSeed #location_id').val();
		var fusion_id=$('.frmHomeKolSeed #fusion_id').val();
		var appln_name=$('.frmHomeKolSeed #appln_name').val();
		
		var phone=$('.frmHomeKolSeed #phone').val();
		var email_id=$('.frmHomeKolSeed #email_id').val();
		
		if(fusion_id!='' && phone!='' && email_id!='' && location_id!=''){
			
			//alert("<?php echo base_url();?>home/seedApplnSave?"+$('form.frmHomeKolSeed').serialize());
			
			$('#sktPleaseWait').modal('show');
			
			$.ajax({
				type	:	'POST',
				url		:	'<?php echo base_url();?>home/seedApplnSave',
				data	:	$('form.frmHomeKolSeed').serialize(),
				success	:	function(msg){
							$('#sktPleaseWait').modal('hide');
							$("#frmHomeImgModelKol").modal('hide');
							
							alert('You Have Successfully Applied.');
							
						}
			});
		}else{
			alert('Fill the form correctly...');
		}
	});
	
	
	
	$('.frmApplnIJP #ijp_location').change(function(){
		
		var location=$(this).val();
		
		$('.frmApplnIJP #app_post').empty();
		$('.frmApplnIJP #app_post').append($('<option></option>').val('').html('-Select-'));
		
		$('.frmApplnIJP #app_post').append($('<option></option>').val('SME').html('SME'));
		$('.frmApplnIJP #app_post').append($('<option></option>').val('Quality').html('Quality'));
		$('.frmApplnIJP #app_post').append($('<option></option>').val('Team Leader').html('Team Leader'));
		$('.frmApplnIJP #app_post').append($('<option></option>').val('Trainer').html('Trainer'));
			
		if(location=="KOL"){
			$('.frmApplnIJP #app_post').append($('<option></option>').val('MIS').html('MIS'));
			$('.frmApplnIJP #app_post').append($('<option></option>').val('HR').html('HR'));				
		}
	});
		
	$('.frmApplnIJP').submit(function(e) {
		
		//alert('OK');
		
		var location=$('.frmApplnIJP #location').val();
		var app_post=$('.frmApplnIJP #app_post').val();
		var phone=$('.frmApplnIJP #phone').val();
		var email_id=$('.frmApplnIJP #email_id').val();
		
		if(app_post!='' && phone!='' && email_id!='' && location!=''){
			
			//alert("<?php echo base_url();?>Ijpapplnsave?"+$('form.frmApplnIJP').serialize());
			
			$('#sktPleaseWait').modal('show');
			
			$.ajax({
				type	:	'POST',
				url		:	'<?php echo base_url();?>Ijpapplnsave',
				data	:	$('form.frmApplnIJP').serialize(),
				success	:	function(msg){
							$('#sktPleaseWait').modal('hide');
							$("#applnIjpFrmModel").modal('hide');
							
							alert('You Have Successfully Applied For This Job');
							
							$(".frmApplnIJP #name").val('');
							$(".frmApplnIJP #phone").val('');
							$(".frmApplnIJP #email").val('');
							$(".frmApplnIJP #comment").val('');
						}
			});
		}else{
			alert('Fill the form correctly...');
		}
	});
	
	
	/*
	<?php if(date('T')=="EDT"):?>
		//EDT();
	<?php elseif(date('T')=="EST"): ?>
		//EST();
	<?php endif;?>
	*/
	
<?php if ( get_role_dir()=="agent" || get_role_dir()=="tl" ) {
	
	echo " CurrServerTime(); ";
	echo " CurrLocalTime(); ";
	
 } ?>

	$('#break_check_button_ld').change(function(){
	
		if($(this).prop("checked")==true){
						
			r = confirm("Are You Sure to Lunch/Dinner Break Timer On?");
			
			if(r===true){
				
				$('#sktPleaseWait').modal('show');
				
				//alert("<?php echo base_url();?>users/break_on_ld");
				
				$.post("<?php echo base_url();?>user/break_on_ld",function(data){
					//window.location.href = "<?php echo base_url().get_role_dir();?>/dashboard";
					window.location.href = "<?php echo base_url();?>home";
				});
				

			}else $(this).prop("checked",false);
			
		}else{
				
				$('#countdown_ld').hide();
				
				$('#sktPleaseWait').modal('show');
				
				$.post("<?php echo base_url();?>user/break_off_ld",function(data){
					if(data==1){
						$(this).prop("checked",false);
						//window.location.href = "<?php echo base_url().get_role_dir();?>/dashboard";
						window.location.href = "<?php echo base_url();?>home";
					}else{
						$(this).prop("checked",true);
						alert(data);//("Error Occurred. Contact TL/Supervisor/Administrator");
					}
				});
				
			} 
	});
	
	
	$('#break_check_button').change(function(){
		if($(this).prop("checked")==true){
						
			r = confirm("Are You Sure to Others Break Timer On?");
			
			if(r===true){
				
				//alert("<?php echo base_url();?>users/break_on");
				
				$('#sktPleaseWait').modal('show');
				
				$.post("<?php echo base_url();?>users/break_on",function(data){
					//window.location.href = "<?php echo base_url().get_role_dir();?>/dashboard";
					window.location.href = "<?php echo base_url();?>home";
				});

			}else $(this).prop("checked",false);
			
		}else{
			
				$('#countdown').hide();	
				$('#sktPleaseWait').modal('show');
				
				$.post("<?php echo base_url();?>users/break_off",function(data){
					if(data==1){
						$(this).prop("checked",false);
						//window.location.href = "<?php echo base_url().get_role_dir();?>/dashboard";
						window.location.href = "<?php echo base_url();?>home";
					}else{
						$(this).prop("checked",true);
						alert(data);//("Error Occurred. Contact TL/Supervisor/Administrator");
					}
				});
		} 
	});
	
	
/////////////////-------- IT Assessment (09/03/2020) --------//////////////////
	$("#dekstop_laptop").on('change', function(){
		if($(this).val()=='No'){
			$('.itast').prop('disabled', true).val('');
		}else{
			$('.itast').prop('disabled', false);	
		}
	});

	$('.frmItAssessment').submit(function(e) {
		var refdl=$('.frmItAssessment #dekstop_laptop').val();
		
		if(refdl!=''){
			$('#sktPleaseWait').modal('show');
			$.ajax({
				type	:	'POST',
				url		:	'<?php echo base_url();?>home/itAssessment',
				data	:	$('form.frmItAssessment').serialize(),
				success	:	function(msg){
					
							$('#sktPleaseWait').modal('hide');
							$("#itAssessment").modal('hide');
							
							alert('Successfully Submited');
						}
			});
		}else{
			alert('Fill the form correctly...');
		}
	});
	
	
/////////////////-------- WORK From Home Survey (27/03/2020) --------//////////////////
	<?php if($survey_workhome['isdonesurvey'] <= 0){  ?>
	$('#SurveyWorkHome').modal();
	display_wfh_status();
	<?php } ?>
	
	function display_wfh_status(){
		wfh_status = $("#is_work_home").val();
		if(wfh_status == "Yes"){ 		
			$('#to_show_wah').show(); 
			$("#is_shifted_happy").prop('required',true);
			$("#how_shifted_happy").prop('required',true);
			$("#wfh_hashtag").prop('required',true);
			$("#wfh_comments").prop('required',true);
		} else { 
			$('#to_show_wah').hide(); 
			$('.frmSurveyWorkHome #is_shifted_happy').val('');
			$('.frmSurveyWorkHome #how_shifted_happy').val('');
			$('.frmSurveyWorkHome #wfh_hashtag').val('');
			$('.frmSurveyWorkHome #wfh_comments').val('');
			$("#is_shifted_happy").removeAttr('required');
			$("#how_shifted_happy").removeAttr('required');
			$("#wfh_hashtag").removeAttr('required');
			$("#wfh_comments").removeAttr('required');
		}
	}
	$("#is_work_home").on('change', function(){
       display_wfh_status();
	});

	$('.frmSurveyWorkHome').submit(function(e) {
		var survWFH=$('.frmSurveyWorkHome #is_work_home').val();
		var ishappyf = $('.frmSurveyWorkHome #is_shifted_happy').val();
		var howhappyf = $('.frmSurveyWorkHome #how_shifted_happy').val();
		var wfhhastagf = $('.frmSurveyWorkHome #wfh_hashtag').val();
		var wfhcommentsf = $('.frmSurveyWorkHome #wfh_comments').val();
		
		if(survWFH!=''){
		if(((survWFH == 'Yes') && (ishappyf != "") && (howhappyf != "") && (wfhhastagf != "") && (wfhcommentsf != "")) || (survWFH == 'No'))
		{
				$('#sktPleaseWait').modal('show');
				$.ajax({
					type	:	'POST',
					url		:	'<?php echo base_url();?>home/survey_workfromhome',
					data	:	$('form.frmSurveyWorkHome').serialize(),
					success	:	function(msg){
						
								$('#sktPleaseWait').modal('hide');
								$("#SurveyWorkHome").modal('hide');
								
								alert('Survey Submited Successfully!');
							}
				});
		} else {			
			alert('Fill the form correctly...');
		}
		} else {
			alert('Fill the form correctly...');
		}
	});
	
	
	
////////////////////////////////////////////////////////////////////
	$('.frmAddReferrals').submit(function(e) {
		
		//alert('OK');
		
		var refName=$('.frmAddReferrals #name').val();
		var refPhone=$('.frmAddReferrals #phone').val();
		var refEmail=$('.frmAddReferrals #email').val();
		
		if(refName!='' && refPhone!='' && refEmail!=''){
			
			///alert("<?php echo base_url();?>home/addreferral?"+$('form.frmAddReferrals').serialize());
			
			$('#sktPleaseWait').modal('show');
			$.ajax({
				type	:	'POST',
				url		:	'<?php echo base_url();?>home/addreferral',
				data	:	$('form.frmAddReferrals').serialize(),
				success	:	function(msg){
					
							$('#sktPleaseWait').modal('hide');
							$("#addReferrals").modal('hide');
							
							//window.location.reload();
							$(".frmAddReferrals #name").val('');
							$(".frmAddReferrals #phone").val('');
							$(".frmAddReferrals #email").val('');
							$(".frmAddReferrals #comment").val('');
							
							alert('Successfully Submit Your Referrals');
						}
			});
		}else{
			alert('Fill the form correctly...');
		}
	});
	
		
////////////////////////////////
	
	$("#viewModalAttendance").click(function(){
		
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
	
/////////////Holiday List//////////////////
	$("#appHolidayList").click(function(){
		$('#sktPleaseWait').modal('show');
		var rURL=baseURL+'holiday_list';
		
		$.ajax({
		   type: 'POST',    
		   url:rURL,
		   success: function(tbDtata){
			   $('#sktPleaseWait').modal('hide');
			   $('#holidayListModel').modal('show');	
			   $('#holidayList').html(tbDtata);
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		});
	});
////////////////////	


});


/////////////////////////////////////////


var srvTimeStr="<?php echo CurrTime();?>";
var localtime="<?php echo GetLocalTime();?>";

var localDateTimeArray = localtime.split(' ');

localDate = localDateTimeArray[0];
localTime = localDateTimeArray[1];

var ll = localTime.split(":");

var locDt = new Date();
    locDt.setHours(ll[0]);
    locDt.setMinutes(ll[1]);
    locDt.setSeconds(ll[2]);
	
function CurrLocalTime(){
    //EST
    locDt = new Date(locDt.valueOf() + 1000);
	var ts = locDt.toTimeString().split(" ")[0];
	//document.getElementById('txt1').innerHTML = ts;
	$("#txt1").html(ts);
	
	var Linv = setTimeout(CurrLocalTime, 1000);
}

var ss = srvTimeStr.split(":");
var srvDt = new Date();
    srvDt.setHours(ss[0]);
    srvDt.setMinutes(ss[1]);
    srvDt.setSeconds(ss[2]);

function CurrServerTime(){
    //EST
    srvDt = new Date(srvDt.valueOf() + 1000);
	var ts = srvDt.toTimeString().split(" ")[0];
	//document.getElementById('txt').innerHTML = ts +" EST";
	$("#txt").html(ts +" EST");
	
	var Sinv = setTimeout(CurrServerTime, 1000);
}


function startTime() {
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();
	m = checkTime(m);
	s = checkTime(s);
	//document.getElementById('txt2').innerHTML =	"Local Time - "+ h + ":" + m + ":" + s;
	$("#txt2").html("Local Time - "+ h + ":" + m + ":" + s);
	
	t = setTimeout(startTime, 1000);
}
function checkTime(i) {
	if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	return i;
}


function EST(){
    //EST
    offset = -5.0;
    clientDate = new Date();
    utc = clientDate.getTime() + (clientDate.getTimezoneOffset() * 60000);
    serverDate = new Date(utc + (3600000*offset));
	h = serverDate.getHours();
	m = checkTime(serverDate.getMinutes());
	s = checkTime(serverDate.getSeconds());
    //return h+" "+m+" "+s;
	document.getElementById('txt').innerHTML = h + ":" + m + ":" + s + " EST";
	var t = setTimeout(EST, 1000);
}

function EDT(){
	//EDT
    offset = -4.0;
    clientDate = new Date();
    utc = clientDate.getTime() + (clientDate.getTimezoneOffset() * 60000);
    serverDate = new Date(utc + (3600000*offset));
	h = serverDate.getHours();
	m = checkTime(serverDate.getMinutes());
	s = checkTime(serverDate.getSeconds());
    //return h+" "+m+" "+s;
	
	document.getElementById('txt').innerHTML = h + ":" + m + ":" + s + " EST";
	
	var t = setTimeout(EDT, 1000);
}

var seconds_ld = <?php echo $break_countdown_ld; ?>;

//alert(seconds_ld);

var seconds = <?php echo $break_countdown; ?>;

//alert(seconds);

function timer_ld() {
    var days        = Math.floor(seconds_ld/24/60/60);
    var hoursLeft   = Math.floor((seconds_ld) - (days*86400));
    var hours       = Math.floor(hoursLeft/3600);
    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
    var minutes     = Math.floor(minutesLeft/60);
	
    var remainingSeconds = seconds_ld % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds; 
    }
	
	//document.getElementById('countdown_ld').innerHTML =  hours + ":" + minutes + ":" + remainingSeconds + " Hours";
	
	$("#countdown_ld").html(hours + ":" + minutes + ":" + remainingSeconds + " Hours");
	
	seconds_ld++;
}

function timer() {
    var days        = Math.floor(seconds/24/60/60);
    var hoursLeft   = Math.floor((seconds) - (days*86400));
    var hours       = Math.floor(hoursLeft/3600);
    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
    var minutes     = Math.floor(minutesLeft/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds; 
    }
	
    //document.getElementById('countdown').innerHTML =  hours + ":" + minutes + ":" + remainingSeconds + " Hours";
	
	$("#countdown").html(hours + ":" + minutes + ":" + remainingSeconds + " Hours");
	
    /*if (seconds == 0) {
        clearInterval(countdownTimer);
        document.getElementById('countdown').innerHTML = "Completed";
    } else {
        seconds++;
    }*/
	seconds++;
}

if(seconds_ld > 0){
	var countdownTimer_ld = setInterval('timer_ld()', 1000);
}

if(seconds > 0){
	var countdownTimer = setInterval('timer()', 1000);
}
////////////////////////////


/////////vertical news board/////////////

	var total_facebook_review_count = $('#facebook_reviews .row .facebook_review').length;
	var i = 0;
	var height = 0;
	setInterval(function(){
		//alert();
			if(i < total_facebook_review_count)
				{
					//alert(height);
					console.log(height);
					console.log(i);
					height = height + $('#facebook_reviews .row .facebook_review').get(i).offsetHeight;
					$('#facebook_reviews .row').animate({
						scrollTop: height
					}, 1500);
					i++;
				}
				else
				{
					i = 0;
					height = 0;
					$('#facebook_reviews .row').animate({
						scrollTop: 0
					}, 1500);
				}
		}, 5000);
	
	
////////////////////////

</script>

<script>

	function checkemail(){
		var email=$("#email").val();
			
		if(email){
			$.ajax({
			  type: 'POST',
			  url: '<?php echo base_url(); ?>home/validate_referral_email',
			  data: 'email='+email,
			  success: function (response){
				   //$('#email_status').html(response);
				   if(response=="OK"){
						//return true;	
				   }else{
					   $("#email").val('');
						//return false;
				   }
			  }
			  });
		 }else{
		  $( '#email_status' ).html("");
		  return false;
		 }
	}
	
	
	function checkphone(){
		var phone=$("#phone").val();
			
		if(phone){
			$.ajax({
			  type: 'POST',
			  url: '<?php echo base_url(); ?>home/validate_referral_phone',
			  data: 'phone='+phone,
			  success: function (response){
				  // $('#phone_status').html(response);
				   if(response=="OK"){
					   //return true;	
				   }else{
					   $("#phone").val('');
						//return false;
				   }
			  }
			  });
		 }else{
		  $( '#phone_status' ).html("");
		  return false;
		 }
	}
	
	
	/* function checkall(){
		var emailhtml=document.getElementById("email_status").innerHTML;
		 if((emailhtml)=="OK"){
		  return true;
		 }else{
		  return false;
		 }
	}
 */
 
</script>



<script>

 $('#bank_name').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z \s]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else
        {
        e.preventDefault();
        //alert('This Fields accepts only alphabet');
        return false;
        }
    });
	
</script>

<script>
	$(document).ready(function(){
		$('#upl_bank_info').change(function () {
			var ext = this.value.match(/\.(.+)$/)[1];
			ext=ext.toLowerCase();
			
			switch (ext) {
				case 'jpg':
				case 'jpeg':
				case 'png':
				case 'pdf':
					$('#uploadButton').attr('disabled', false);
					break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
		});
	});	
</script>