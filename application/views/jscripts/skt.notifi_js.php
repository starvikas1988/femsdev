<script>
////////////////
var baseURL="<?php echo base_url();?>";
var is_loggedIn = <?php echo $is_loggedIn; ?>;
//alert(is_loggedIn);
if(is_loggedIn == 0){
	var URL=baseURL+'logout';
	window.location = URL;
}

setInterval(function(){
	window.location.reload();
}, (61*60*1000)); 

var loggedin_countdown = <?php echo $loggedin_countdown; ?>;
//alert(loggedin_countdown);
var notifyTimer = setInterval('sktNotifyMe()', (20*60*1000)); //milisecond

////////////////

Notification.requestPermission(function (permission) {
      if (!('permission' in Notification)) {
        Notification.permission = permission;
      }
      if (permission === "granted"){
		
		var iSOpenNotifi = $.cookie('iSOpenNotifi');
		if(iSOpenNotifi != "Y"){
			CreateNotification();
			$.cookie('iSOpenNotifi', 'Y');
		}
      }
 });
 
function sktNotifyMe() {
  	
	loggedin_countdown=loggedin_countdown+(20*60); // added 10 min 10*60
	
	if(loggedin_countdown >= 43200){ //12hrs
		var URL=baseURL+'logout';
		window.location = URL;
	}
		
	if(loggedin_countdown>=(8*60*60)){ // then check for 8 hours (8*60*60)
 
	  if (!("Notification" in window)) {
	   
	   //alert("This browser does not support desktop notification");
	   
	  } else if (Notification.permission === "granted") {
	  
		  CreateNotification();
		  
	  }else if (Notification.permission !== 'denied') {
	  
		Notification.requestPermission(function (permission) {
		  if (!('permission' in Notification)) {
			Notification.permission = permission;
		  }
		  if (permission === "granted") {
			CreateNotification();
		  }
		});
	  }
	}
}

function CreateNotification() {

        var options = {
              //body: "You must log out from FEMS system, when you leave your desk.",
			  body: "You must log out from FEMS system, when your shift ends.",
              icon: "<?php echo base_url(); ?>assets/images/notify.png",
              dir : "ltr"
          };
        var notification = new Notification("Hi <?php echo get_username(); ?>",options);
		
}

</script>