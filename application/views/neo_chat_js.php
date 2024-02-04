
<style>

#cboxmain{
	   left:0;
	}
	
	
	.chat-initiation_left {
		min-width: 180px;
		height: 38px;
		background: #40a4dc;
		color: #fff;
		border-radius: 3px 0 0 0;
		cursor: pointer;
		float: left;
	}
	
	.chat-initiation--offline_left {
		min-width: 180px;
		background: #ccc;
		color: #fff;
		border-radius: 3px 0 0 0;
		cursor: pointer;
		min-height: 39px;
		float: left;
	}


</style>


<script src="<?php echo base_url(); ?>assets_home_v3/mwp-chatbot/js/botchat.js"></script>

<script type="text/javascript">	

//$.getScript("<?php echo base_url(); ?>assets/mwp-chatbot/js/botchat.js");

<?php 
	
 $usrNm=get_username();
 $uName=explode(" ",$usrNm);
 $userName=$uName['0'];
?>

//commented by skt
//refresh_chat();

var user = {
		id: '<?php echo get_user_fusion_id();?>',
		name :'<?php echo $userName;?>',
		userparam:{
			FullName :'<?php echo get_username();?>', 
			Dept :'<?php echo get_dept_folder();?>', 
			LocationCode: '<?php echo get_user_office_id();?>',
			LocationName: '<?php echo get_user_location_name();?>',
			LocationCountry: '<?php echo get_location_country();?>',
			Country: '<?php echo get_country();?>',
			DeptShName: '<?php echo get_deptshname();?>',
			Designation: '<?php echo get_role();?>',
			Role: '<?php echo get_role_dir();?>',
			Phone: '<?php echo get_phone();?>',
			Client: '<?php echo get_client_names();?>',
			Process: '<?php echo get_process_names();?>',
			L1Supervisor: '<?php echo get_assigned_to_name();?>',
			langCd: 'en'}				
	};

function refresh_chat(){

		$.getScript("<?php echo base_url(); ?>assets_home_v3/mwp-chatbot/js/botchat.js");
			
		
        var botConnection = new BotChat.DirectLine({
           token: 'wn4w0_UIDGQ.tX7llXYa6BkWnoYOPb4wzGIFMTIZcX8ngw1hAtXB2sQ',
            user: user
        });
        BotChat.App({
            user: user,
            botConnection: botConnection,
            bot: { id: '<?php echo get_user_fusion_id();?>', name: 'MWP Neo Bot' },
            resize: 'detect'
        }, document.getElementById("bot"));
        botConnection
            .postActivity({
                from: user,
                name: 'requestWelcomeDialog',
                type: 'event',
                value: ''
            })
            .subscribe(function (id) {
                console.log('"trigger requestWelcomeDialog" sent');
            });

}
	/*
	
       var user = {
		id: '<?php echo get_user_fusion_id();?>',
		name :'<?php echo $userName;?>',
        userparam:{Dept :'<?php echo get_dept_folder();?>', Office: '<?php echo get_user_office_id();?>',  Region: '<?php echo get_user_location_name();?>', langCd: 'en'}
			
        };
        var botConnection = new BotChat.DirectLine({
           token: 'wn4w0_UIDGQ.tX7llXYa6BkWnoYOPb4wzGIFMTIZcX8ngw1hAtXB2sQ',
            user: user
        });
        BotChat.App({
            user: user,
            botConnection: botConnection,
            bot: { id: '<?php echo get_user_fusion_id();?>', name: 'MWP Neo Bot' },
            resize: 'detect'
        }, document.getElementById("bot"));
        botConnection
            .postActivity({
                from: user,
                name: 'requestWelcomeDialog',
                type: 'event',
                value: ''
            })
            .subscribe(function (id) {
                console.log('"trigger requestWelcomeDialog" sent');
            });
			
		*/
			
			
		
	  <!--start start new js code for the chatbot 07.04.2022-->
	  $(document).ready(function(){
		  
		var counter=0;
		$(".omind-widget1").click(function(){
			$(".close-area").show("");		
			$(".icon-small").hide("");
			if(counter==0){
				
				var botConnection = new BotChat.DirectLine({
				   token: 'wn4w0_UIDGQ.tX7llXYa6BkWnoYOPb4wzGIFMTIZcX8ngw1hAtXB2sQ',
					user: user
				});
			
				BotChat.App({
					user: user,
					botConnection: botConnection,
					 bot: { id: '<?php echo get_user_fusion_id();?>', name: 'MWP Neo Bot' },
					resize: 'detect'
				}, document.getElementById("bot"));
			
				botConnection
					.postActivity({
						from: user,
						name: 'requestWelcomeDialog',
						type: 'event',
						value: ''
					})
					.subscribe(function (id) {
						console.log('"trigger requestWelcomeDialog" sent');
					});
					counter++;
			}
			
			
		});
		$(".close-area").click(function(){
			$(".close-area").hide("");		
			$(".icon-small").show("");
		});
	});
	  <!--end start new js code for the chatbot 07.04.2022-->
	  
		
    </script>
	
 <script type="text/javascript">	
 
	hideChat(0);
	
	$('#message-box').click(function() {

	  toggleFab();
	});
function toggleFab() {
  $('.omind').toggleClass('message-outline');
  $('.omind').toggleClass('message-close');
  $('.omind').toggleClass('is-active');
  $('.omind').toggleClass('is-visible');  
  $('.omind-chat').toggleClass('is-visible');
  $('.omind-widget').toggleClass('is-visible'); 
  $('.omind-tech').toggleClass('isvisible');
}  
function hideChat(hide) {
	// $('.omind-tech').css( "zIndex", "90" );
}

	</script>
	<script>
		$('#message-box').click(function() {
			$('.omind-body-chat').addClass('large');

		});
	</script>
	<script>
		$('.wc-message-groups').click(function() {
		$(".wc-message-groups").stop().animate({ scrollTop: $(".wc-message-groups")[0].scrollHeight}, 1000);
		});
</script>

<!--start custom chat design library here 10.03.2022-->
<script type="text/javascript">	

	$(document).ready(function(){
		$(".omind-widget1").click(function(){
			$(".close-area").show("");		
			$(".icon-small").hide("");
		});
		$(".close-area").click(function(){
			$(".close-area").hide("");		
			$(".icon-small").show("");
		});
	});
</script>
<!--end custom chat design library here 10.03.2022-->


<script type="text/javascript">

$(window).on('load', function() {
	
	//console.log('Hi i am here');
	//console.log($('#cboxmain').contents().html());
	
	console.log($('#cboxmain').contents().find('body').find(".chat-initiation").html());
	
});

/*
setTimeout(function () {
  
  $('#cboxmain').contents().find('body').html('Hey, i`ve changed content of <body>! Yay!!!');
  console.log('hi i am here');
  console.log($('#cboxmain').contents().find('body').find(".chat-initiation").html());
  
  $('#cboxmain').contents().find('body').find(".chat-initiation").css('float', 'left');
  $('#cboxmain').contents().find('body').find(".chat-initiation").css('float', 'left');
	
}, 1000);
*/


</script>



<!--start custom chat design video here 22.03.2022-->
<script type="text/javascript">	

	$("#myModal-iframe").on('hidden.bs.modal', function (e) {
			$("#myModal-iframe iframe").attr("src", $("#myModal-iframe iframe").attr("src"));
	});
	
	$('#myModal-iframe').on('hide.bs.modal', function(e) {
		this.querySelector('video').pause();
	})


    function postFeedback() {
        var input = document.getElementsByClassName("wc-shellinput")[0];
        var lastValue = input.value;
        input.value = 'Feedback for Mind Neo';
        var event = new CustomEvent('input', { bubbles: true });
        // hack React15
        event.simulated = true;
        // hack React16
        var tracker = input._valueTracker;
        if (tracker) {
            tracker.setValue(lastValue);
        }
        input.dispatchEvent(event);

        //send the message
        $(".wc-send:first").click();
    }
</script>
<!--end custom chat design video here 22.03.2022-->

