<script>

var resign_period_day=<?php echo $resign_period_day; ?>

$(document).ready(function(){
	/*
	<?php if(date('T')=="EDT"):?>
		//EDT();
	<?php elseif(date('T')=="EST"): ?>
		//EST();
	<?php endif;?>
	*/
	
	ServerTime();
	
	$('#break_check_button_ld').change(function(){
	
		if($(this).prop("checked")==true){
						
			r = confirm("Are You Sure to Lunch/Dinner Break Timer On?");
			
			if(r===true){
				
				//alert("<?php echo base_url();?>users/break_on_ld");
				
				$.post("<?php echo base_url();?>user/break_on_ld",function(data){
					window.location.href = "<?php echo base_url().get_role_dir();?>/dashboard";
				});
				

			}else $(this).prop("checked",false);
			
		}else{
				
				$('#countdown_ld').hide();
						
				$.post("<?php echo base_url();?>user/break_off_ld",function(data){
					if(data==1){
						$(this).prop("checked",false);
						window.location.href = "<?php echo base_url().get_role_dir();?>/dashboard";
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
				
				$.post("<?php echo base_url();?>users/break_on",function(data){
					window.location.href = "<?php echo base_url().get_role_dir();?>/dashboard";
				});

			}else $(this).prop("checked",false);
			
		}else{
			
				$('#countdown').hide();		
				$.post("<?php echo base_url();?>users/break_off",function(data){
					if(data==1){
						$(this).prop("checked",false);
						window.location.href = "<?php echo base_url().get_role_dir();?>/dashboard";
					}else{
						$(this).prop("checked",true);
						alert(data);//("Error Occurred. Contact TL/Supervisor/Administrator");
					}
				});
		} 
	});
//////////////////	
	
	$('#resign_date').change(function(){
		alert(resign_period_day);
	});	

/////////////	
});

var srvTimeStr="<?php echo CurrTime();?>";
var ss = srvTimeStr.split(":");
var srvDt = new Date();
    srvDt.setHours(ss[0]);
    srvDt.setMinutes(ss[1]);
    srvDt.setSeconds(ss[2]);

function ServerTime(){
    //EST
    srvDt = new Date(srvDt.valueOf() + 1000);
	var ts = srvDt.toTimeString().split(" ")[0];
	document.getElementById('txt').innerHTML = ts +" EST";
	var t = setTimeout(ServerTime, 1000);
}


function startTime() {
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();
	m = checkTime(m);
	s = checkTime(s);
	document.getElementById('txt2').innerHTML =	"Local Time - "+ h + ":" + m + ":" + s;
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
	t = setTimeout(EST, 1000);
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
	
	t = setTimeout(EDT, 1000);
}

var seconds_ld = <?php echo $break_countdown_ld; ?>

var seconds = <?php echo $break_countdown; ?>

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
	document.getElementById('countdown_ld').innerHTML =  hours + ":" + minutes + ":" + remainingSeconds + " Hours";
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
	
    document.getElementById('countdown').innerHTML =  hours + ":" + minutes + ":" + remainingSeconds + " Hours";
	
    /*if (seconds == 0) {
        clearInterval(countdownTimer);
        document.getElementById('countdown').innerHTML = "Completed";
    } else {
        seconds++;
    }*/
	seconds++;
}

var countdownTimer_ld = setInterval('timer_ld()', 1000);
var countdownTimer = setInterval('timer()', 1000);
</script>
