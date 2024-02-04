
    <link href="<?php echo base_url(); ?>libs/bower/course_slider/app_critical7069.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>libs/bower/course_slider/combined_presentation89a2.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>libs/bower/course_slider/slideviewc0c4.css media="screen" rel="stylesheet" type="text/css" />


  <body id="pagekey-slideshare_desktop_slideview_loggedout" class="   locale-en">

	<div class="wrapper">
		<div class="col-md-12" style="padding-bottom:20px;">
			<div class="widget">
				<header class="widget-header">
					<div class="row">
						<div class="col-sm-2 col-2 pull-right">
								<button type="button" class="btn  btn-success" onclick="window.open('<?php echo base_url();?>course/view_courses/<?php echo $category_id;?>/<?php echo $course_id;?>/full_page','popUpWindow','height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no, status=yes');"><i class="glyphicon glyphicon-mobile"></i> Open In Seperate Window </button>			
						</div 
						<div class="col-sm-1 col-1 pull-right">
								<a  href="<?php echo base_url(); ?>/course/view_subject_list/<?php echo $this->uri->segment(3);?>" type="button" class="btn  btn-success"  width="100px"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
						</div>
					</div>
				</header>
			</div>
		</div>
	
	<?php if(!empty($files_contents)){?>
	
		<?php 
			$fileError_count = 0;
			$file_extension ='';
			
			
			foreach($files_contents as $files){
				$file_extension = pathinfo(strtolower($files['file_name']), PATHINFO_EXTENSION);
				if($file_extension == 'jpg' || 'jpeg' || 'png' || 'gif'){
					$fileError_count = $fileError_count + 1;
				} 
			}
			

			
		?> 
	
		<?php if((count($files_contents) > 1)  && ($fileError_count  === count($files_contents)) &&  ($file_extension === 'jpeg' || $file_extension === 'jpg' || $file_extension === 'png' || $file_extension === 'gif')){ ?>
		 <div id="slideview-container" class="">
		  <div class="row">
			<div id="main-panel" class="small-12 large-8 columns" style="margin-top:30px;">
			  <div class="sectionElements">
					<div class="j-clips-toolbar clips-toolbar ">
					</div>

					<div class="playerWrapper">
						<div>
							<!-- For slideview page , combined js for player is now combined with slideview javascripts for logged out users-->
							<div class="player lightPlayer fluidImage presentation_player " id="svPlayerId">
							  <div class="stage valign-first-slide">
									<div class="player-cta-container">
										<div class="clip-button-top">
											<a id="clips-button-top" class="j-clips-button clip-button player-cta visible " href="" rel="nofollow" data-reveal-id=login_modal style="display:none">
												<div class="container clearfix">
												  <div class="svg-icon" aria-hidden="true">
													<svg><use data-size="small" xlink:href="#clipboard-add-icon"></use></svg>
												  </div>
												  <span class="clip-button-text-clip notranslate copy-in-aria-label" aria-label="Clip slide" title="Clip to save this slide for later"></span>
												</div>
											</a>
										</div>
									</div>
									<a class="exit-fullscreen j-exit-fullscreen" style="display: none;">
									  <i class="fa fa-compress fa-2x"></i>
									</a>
									
									<?php $i=0; ?>
									<div class="slide_container">
									<?php foreach($files_contents as $files){  ?>
									<?php  $i = $i+1; ?>
										<section id="slide_<?php echo $i; ?>" data-index="<?php echo $i; ?>"  class="slide <?php echo $i == 1 ? 'show':'' ?>" >
											<i class="fa fa-spinner fa-spin"></i>
											<img class="slide_image" src="<?php echo base_url();?>course_uploads/<?php echo $files['file_name']; ?>" data-small="<?php echo base_url();?>course_uploads/<?php echo $files['file_name']; ?>" data-normal="<?php echo base_url();?>course_uploads/<?php echo $files['file_name']; ?>" data-full="<?php echo base_url();?>course_uploads/<?php echo $files['file_name']; ?>" title="" alt=""/>
										</section>
									<?php } ?>	
										
										<div class="j-next-container next-container">
										  <div class="content-container">
											<div class="next-slideshow-wrapper">
											  <div class="j-next-slideshow next-slideshow">
												<div class="title-container">
												  <span class="title-text">Upcoming SlideShare</span>
												</div>
												<div class="j-next-url info">
												  <div class="thumb-container">
													<img class="j-next-thumb thumb" />
												  </div>
												  <div class="text-container">
													<span class="j-next-title next-title"></span>
												  </div>
												</div>
											  </div>
											  <div class="next-timer">Loading in …<span class="j-timer-count timer-count">5</span></div>
											  <div class="j-next-cancel next-cancel">&#215;</div>
											</div>
										  </div>
										</div>
									</div>
								
									<div class="rightpoint pointly"><img id="point" src=""></div>
									<div class="leftpoint pointly"></div>
								<div class="filmstrip-container" style="opacity: 1; display: none;"><div class="filmstrip-lens top-clip" style="width: 216px; height: 157.875px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-6-320.jpg?cb=1580413780" class="filmstrip-lens-image"><span class="top-clip-label">Top clipped slide</span></div><ul class="filmstrip" style="width: 3780px; margin-left: -268.589px;"><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-1-320.jpg?cb=1580413780" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-2-320.jpg?cb=1580413780" class="filmstrip-thumb top-clip" style="width: 100px; height: 70.9375px;"><span class="top-clip-label">Top clipped slide</span></li><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-3-320.jpg?cb=1580413780" class="filmstrip-thumb top-clip" style="width: 100px; height: 70.9375px;"><span class="top-clip-label">Top clipped slide</span></li><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-4-320.jpg?cb=1580413780" class="filmstrip-thumb top-clip" style="width: 100px; height: 70.9375px;"><span class="top-clip-label">Top clipped slide</span></li><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-5-320.jpg?cb=1580413780" class="filmstrip-thumb top-clip" style="width: 100px; height: 70.9375px;"><span class="top-clip-label">Top clipped slide</span></li><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-6-320.jpg?cb=1580413780" class="filmstrip-thumb top-clip" style="width: 100px; height: 70.9375px;"><span class="top-clip-label">Top clipped slide</span></li><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-7-320.jpg?cb=1580413780" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-8-320.jpg?cb=1580413780" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-9-320.jpg?cb=1580413780" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-10-320.jpg?cb=1580413780" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="https://image.slidesharecdn.com/winkelmannickpbcoachinglanguageslideshare-190630151552/85/the-language-of-coaching-a-story-about-learning-11-320.jpg?cb=1580413780" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li><li style="margin: 4px;"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="filmstrip-thumb" style="width: 100px; height: 70.9375px;"></li></ul></div>
							</div>
						</div> <!-- end stage -->

						  <div class="toolbar_wrapper j-player-toolbar">
							<div class="toolbar normal">
							  
								<!-- using div.bar-[top, bottom]-margin to fix toolbar spacing with a taller progressbar (improve slide scrubbing UX) -->
								<div class="j-progress-bar progress-bar-wrapper">
								  <div class="progress-bar-spacing"></div>
								  <div class="buffered-bar" tabindex="0"></div>
								  <div id="g" class="j-slides-loaded-bar progress-bar"></div>
								  <div class="j-progress-tooltip progress-tooltip" style="display: none;">
										<div class="j-tooltip-content progress-tooltip-wrapper">
											<span class="j-slidecount-label slidecount-label">1</span>
										</div>
									<div class="progress-tooltip-caret"></div>
								  </div>
								</div>
								<div class="progress-bar-spacing"></div>

								<div class="j-tools bot-actions">
								</div><!-- .bot-actions -->

								  <div class="nav">
									  <button id="btnPrevious"  aria-label="Previous Slide">
										<a class="arrow-left"title="" tabindex="-1"></a>
									  </button>
									<label class="goToSlideLabel">
									  <span id="current-slide" class="j-current-slide">1</span> of <span id="total-slides" class="j-total-slides">5</span>
									</label>
									  <button id="btnNext"   aria-label="Next Slide">
										<a  class=" arrow-right"></a>
									  </button>
								  </div>
								  
								  <div class="navActions">
									 <button id="btnFullScreen" class="j-tooltip btnFullScreen" title="View Fullscreen" aria-label="View Fullscreen">
										<span class="fa fa-stack">
										   <i class="fa fa-expand fa-stack-1x" aria-hidden="true"></i>
										 </span>
									</button>
									<button id="btnLeaveFullScreen" class="j-tooltip btnLeaveFullScreen" title="Exit Fullscreen" aria-label="Exit Fullscreen">
									  <span class="fa-stack">
										<i class="fa fa-compress fa-stack-1x" aria-hidden="true"></i>
									  </span>
									</button>
								  </div>


							</div>
						</div>

							<div class="success-toast-wrapper hide" tabindex="-1"></div>
							<div class="image_maps"></div>
						</div>

					<div id="j-lead-form-placeholder" style="display:none">
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	  
	  
			<?php }elseif($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png' || $file_extension == 'gif'){   ?>
				<div class="widget">
					<header class="widget-header">
						<img class=" float-right" src="<?php echo base_url()."course_uploads/". $files_contents[0]['file_name'];  ?>">
					</header>
				</div>
			<?php }elseif($file_extension == 'pdf'){ ?>
						
					<iframe src="<?php echo base_url()."course_uploads/".  $files_contents[0]['file_name'];  ?>" style="width: 100%;height: 100%;border: none;"></iframe>	
			<?php }  ?>
			
			<!--<iframe src='https://docs.google.com/viewer?url=ENTER URL OF YOUR DOCUMENT HERE&embedded=true' frameborder='0'></iframe>
			<iframe src='//docs.google.com/gview?url=URLOFDOC.docx&embedded=true' frameborder='0'></iframe>
			https://docs.google.com/gview?url=http://-->

	<?php }  ?>
	</div>  
  </body> 
</html>
