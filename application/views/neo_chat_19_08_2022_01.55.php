<!--start custom chat design elements here 27.01.2022-->
<div class="omind-tech">
  <div class="omind-chat">
    <div class="omind-chat-header">
      <div class="omind-chat-option">
		<!--start custom changes-->
		<div class="profile-widget">
			<div class="row">
				<div class="col-sm-8">
					<img src="<?php echo base_url() ?>assets/mwp-chatbot/images/small-logo.png" class="small-chat-logo" id=""> Neo
				</div>			
			</div>
			<div class="profile-chat">
				<div class="omind-agent">
					<img src="<?php echo base_url() ?>assets/mwp-chatbot/images/agent.jpg" class="profile-img" alt=""/>
				</div>
			</div>
		</div>		
		<button type="button" class="refresh-btn" id="test" onclick="refresh_chat();">
			<i class="fa fa-refresh" aria-hidden="true"></i>
		</button>

		<button onclick="postFeedback()" class="video-btn1">
			Feedback Neo
		</button>
		
		
		<a href="javascript:void(0);" class="video-btn" data-bs-toggle="modal" data-bs-target="#myModal-iframe">
			<i class="fa fa-play-circle" aria-hidden="true"></i>
		</a>
		
		
      </div>
    </div>	
    <div class="omind-body-chat omind-chat-login">
		<div class="vital-widget">
		<div class="row align-items-center">			
			<div class="col-sm-12">
				<div class="right-chat">
					<div class="body-widget">
						<div id="bot"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
    </div>
      
    <div class="omind-submit-widget" style="display:none;">      
      <a id="omind-send" class="send-widget">
		<i class="fa fa-paper-plane icons"></i>
	  </a>
      <textarea id="chatSend" name="chat_message" placeholder="Send a message" class="omind-chat-box chat-message"></textarea>
    </div>
  </div>
	
  <a id="message-box">
		<div class="omind-widget1">			
			<img src="<?php echo base_url() ?>assets/mwp-chatbot/images/main-icon.png" class="icon-small-new" alt="">
		</div>
		<div class="close-area">
			<i class="omind icons message-outline"></i>
		</div>
	</a>
	
</div>
<!--end custom chat design elements here 27.01.2022-->




<!--start video popup iframe element here 22.03.2022-->
<div class="modal fade video-popup" id="myModal-iframe">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title">
			<img src="<?php echo base_url() ?>assets/mwp-chatbot/images/small-logo.png" class="small-chat-logo" id="">
			Ask Neo
		  </h5>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">		
		   <div class="video-widget">
				<video id="videoPlayerTag" controls loop poster="<?php echo base_url() ?>assets/mwp-chatbot/images/poster.png">
				<source src="<?php echo base_url() ?>assets/mwp-chatbot/images/mind-neo-chatbot.mp4" type="video/mp4">
				</video>
			</div>
        </div>		
      </div>
    </div>
  </div>
<!--end video popup iframe element here 22.03.2022-->