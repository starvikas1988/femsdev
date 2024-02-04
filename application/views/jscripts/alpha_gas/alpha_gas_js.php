<script>
$('.number-only').keyup(function(e) {
	if(this.value!='-')
	  while(isNaN(this.value))
		this.value = this.value.split('').reverse().join('').replace(/[\D]/i,'')
							   .split('').reverse().join('');
})
.on("cut copy paste",function(e){
	e.preventDefault();
});

$('#c_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });


// STOPWATCH TIMER
startDateTimer = new Date();
startTimer();
function startTimer(){
	var total_seconds = (new Date() - startDateTimer) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timeWatch").html(result);
	$("#time_interval").val(result);
	setTimeout(function(){startTimer()}, 1000);
}


function callActionButton(current){
	callType = $(current).attr('btype');
	if(callType == 'start'){ 
		startTimerNew(new Date());
		$('#formInfoCrm').show();
		$('#startCallModalButton').hide();
		$('#holdCallModalButton').show();
		$('#unholdCallModalButton').hide();
		$('#endCallModalButton').show();
		$('#buttonCallBody').css('background-color', '#d9ffda');
		$(current).closest('.modal').modal('hide');
	}
	if(callType == 'hold'){
		reasonHold = $('#modal_hold_reason').val();
		if(reasonHold != ""){
			startHoldNew(new Date());
			$('#startCallModalButton').hide();
			$('#holdCallModalButton').hide();
			$('#unholdCallModalButton').show();
			$('#endCallModalButton').hide();
			extraAdd = "";
			reasonSet = $('#c_hold_reason').val();
			if(reasonSet != ""){ extraAdd = " || "; }
			$('#c_hold_reason').val(reasonSet + extraAdd + reasonHold);
			holdCount = $('#c_hold').val();
			$('#c_hold').val(Number(holdCount) + 1);
			$('#buttonCallBody').css('background-color', '#ffd9d9');
			$(current).closest('.modal').modal('hide');
		} else {
			alert('Please Enter the Reason!');
		}
	}
	if(callType == 'unhold'){ 
		startHoldEnd(); 
		$('#modal_hold_reason').val('');
		$('#startCallModalButton').hide();
		$('#holdCallModalButton').show();
		$('#unholdCallModalButton').hide();
		$('#endCallModalButton').show();		
		$('#buttonCallBody').css('background-color', '#d9ffda');
		$(current).closest('.modal').modal('hide');
	}	
	if(callType == 'end'){ 
		$('#endCallSubmit').click(); 
		$(current).closest('.modal').modal('hide');
	}	
}
function startTimerNew(startDate){
	var total_seconds = (new Date() - startDate) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timer_start").val(result);
	$('.inCall span').html(result);	
	timerStatus = $("#timer_start_status").val();
	if(timerStatus == 'S'){
		$('.inCall').show();
		$('.inHold, .inWait').hide();		
		setTimeout(function(){startTimerNew(startDate)}, 1000);
	} else {
		$('.inCall').hide();
		setTimeout(function(){startTimerNew(startDate)}, 1000);
	}
}

function startHoldNew(startDate){
	var total_seconds = (new Date() - startDate) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timer_hold").val(result);
	$('.inHold span').html(result);	
	timerHoldStatus = $("#timer_hold_status").val();
	if(timerHoldStatus == 'H'){
		$('.inHold').show();
		$('.inCall, .inWait').hide();
		$("#timer_start_status").val('H');
		timeOutVar = setTimeout(function(){startHoldNew(startDate)}, 1000);
		console.log('hi');
	} else {
		clearTimeout(timeOutVar);
		$("#timer_hold").val('');
		$("#timer_hold_status").val('H');	
		console.log('byee');
	}
}

function startHoldEnd(){
	holded = $("#timer_hold").val();
	holdedNo = $('#c_hold').val();
	$("#timeHolder").append('Hold ' + holdedNo + ' - ' + holded + '<br/>');
	pastHold = getSeconds($('#c_holdtime').val());
	currentHold = getSeconds(holded);
	var newTime = new Date(null);
	newTime.setSeconds(Number(pastHold) + Number(currentHold));
	var result = newTime.toISOString().substr(11, 8);
	$('#c_holdtime').val(result);	
	$("#timer_hold_status").val('U');
	$("#timer_start_status").val('S');
	$('.inCall').show();
	$('.inHold, .inWait').hide();
}

function getSeconds(time)
{
    var ts = time.split(':');
    return Date.UTC(1970, 0, 1, ts[0], ts[1], ts[2]) / 1000;
}

</script>