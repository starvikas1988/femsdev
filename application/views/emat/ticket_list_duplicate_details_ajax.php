		<div class="card-body">
		  <div class="email-new2 box">		  
		    <?php 
			if(!empty($messageList)){
			$sl=0;
			foreach($messageList as $token){
				$sl++;
				if($sl > 1){ continue; }
			?>
			  <div class="email-repeat">
				  <div class="email-widget">
					<div class="row">
						<div class="col-sm-8">
							<div class="email-main">
								<h2 class="email-title">
									From : <?php echo $token['email_from']; ?>
								</h2><br>
								<h3 class="email-sub-title">
									Subject : <?php echo $token['email_subject']; ?>
								</h3>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="body-widget">
								<div class="attachment-left">
									<p><strong>Attachment</strong></p>
								</div>
								<div class="attachment-right">
									<div class="attachment-widget">
									<?php if(!empty($messageListAttachment[$token['email_piping_id']])){ ?>
										<div class="attachment-link">
											<?php 
											$sn=0;	
											foreach($messageListAttachment[$token['email_piping_id']] as $atoken){ 
											?>
											<a title="<?php echo $atoken['at_name']; ?>" style="cursor:pointer" onclick="window.open('<?php echo base_url()."emat/attachment_view?filedir=".base64_encode($atoken['at_content_dir']); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no, status=yes');"><b><i class="fa fa-download"></i> <?php echo e_short_text($atoken['at_name'], 25); ?></b></a><br/>
											<?php } ?>
										</div>
									<?php } else { ?>
										<div class="attachment-link">
											<a href="#">N/A</a>
										</div>
									<?php } ?>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-sm-12">
							<div class="email-content">
								<p>
									<?php 
									
									$body_html = $token['e_body_html'];
									$body_plain = $token['e_body_plain'];
									echo str_replace('<p></p>', '', e_show_mail_body($body_html, $body_plain));
									
									?>
									<br/><br/><br/>
								</p>
							</div>
						</div>
					</div>
				  </div>
			  </div>
			  <?php } ?>
			  <?php } ?>
			  
			</div>
			
			
			
			<div class="common-top">
				<div class="select-main">
					<div class="row">
						<div class="col-sm-3">
							<div class="select-widget">
								<div class="body-widget">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
									 