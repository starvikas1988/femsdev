 <link rel="stylesheet" href="<?php echo base_url(); ?>course_uploads/loader/percircle.css">
 
    <link href="<?php echo base_url(); ?>libs/bower/course_slider/app_critical7069.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>libs/bower/course_slider/combined_presentation89a2.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>libs/bower/course_slider/slideviewc0c4.css media="screen" rel="stylesheet" type="text/css" />

	
	<style>
	a[data-tool-tip]{
    position: relative;
    text-decoration: none;
    color: rgba(255,255,255,0.75);
}

a[data-tool-tip]::after{
    content: attr(data-tool-tip);
    display: block;
    position: absolute;
    background-color: dimgrey;
    padding: 1em 3em;
    color: white;
    border-radius: 5px;
    font-size: .5em;
    bottom: 0;
    left: -180%;
    white-space: nowrap;
    transform: scale(0);
    transition: 
    transform ease-out 150ms,
    bottom ease-out 150ms;
}

a[data-tool-tip]:hover::after{
    transform: scale(1);
    bottom: 200%;
}
	</style> 
	
    <input type="hidden" name="categoryid" id="categoryid" value="<?php echo $category_id; ?>">
	<input type="hidden" name="courseid" id="courseid" value="<?php echo $course_id; ?>">
	 
	<div class="wrap">
		<section class="app-content">
			<div class="row">
			<!-- DataTable -->
				<div class="col-md-12">
					<div class="widget">
						<header class="widget-header">
							<div class="row">
								<div class="col-sm-2 col-12 ">
									<h4 class="widget-title btn label labeled">Your Progress</h4>
								</div>
								<div class="col-sm-1 col-1 pull-right">
									<a href="<?php echo base_url();?>home" class="btn  btn-success"><i class="glyphicon glyphicon-arrow-left"></i> Back </a>
								</div>
								<div class="col-sm-1 col-1 pull-right">
									
								</div> 
								
							</div>
						</header><!-- .widget-header -->
						<hr class="widget-separator"> 
						<div class="widget-body">
							<div class="clearfix" style="padding-left:20px">
									<div id="redBecomesBlue" class="red small"></div> 
							</div>
						</div>	
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</section>
	</div><!-- .wrap -->	
	
<?php foreach($course_title as $title) :?>
<?php $file_name = explode(",",$title['title_image']);
	  $file_extension=''; ?>
 	  	
	<div class="wrap course_section" id="partition_<?php echo $title['title_id']; ?>" style="display:none">
		<section class="app-content">
			<div class="row">
			<!-- DataTable -->
				<div class="col-md-12">
					<div class="widget">
						<div class="widget-body list-inline">
							
								
								<!--- DIV SLIDER -->
								
								
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
																		<a class="exit-fullscreen j-exit-fullscreen" style="display: block;">
																		  <i class="fa fa-compress fa-2x"></i>
																		</a>
																		<?php $j=0; ?>
																		<div class="slide_container">
																		<?php for($i=0;$i<count($file_name);$i++){ ?>	
																			<?php $j=$j+1; ?>
																			<?php $file_extension = pathinfo(strtolower($file_name[$i]), PATHINFO_EXTENSION) ; 
																			
																				if($file_extension == 'mp4'){ ?>
																					  <video id='homevideo' autoplay='' controls webkit-playsinline='' width='100%' height='100%' >
																							<source src="<?php echo base_url()."course_uploads/".$file_name[$i]; ?>" type='video/mp4'>
																					  </video>
																			<?php }
																			
																			?>
																			<section id="slide_<?php echo $title['title_id']; ?>_<?php echo $j; ?>" data-index="<?php echo $j; ?>"  class="slide <?php echo $j == 1 ? 'show':'' ?>" >
																			
																				<i class="fa fa-spinner fa-spin"></i>
																				
																				<img class="slide_image_<?php echo $title['title_id']; ?>" src="<?php echo base_url();?>course_uploads/<?php echo $file_name[$i]; ?>" data-small="<?php echo base_url();?>course_uploads/<?php echo $file_name[$i]; ?>" data-normal="<?php echo base_url();?>course_uploads/<?php echo $file_name[$i]; ?>" data-full="<?php echo base_url();?>course_uploads/<?php echo $file_name[$i]; ?>" title="" alt=""/>
																				
																			</section>
																		<?php } ?>	
																		
																			
																		</div>
																	
																		<div class="rightpoint pointly"><img id="point" src=""></div>
																		<div class="leftpoint pointly"></div>
																	
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
																		  <button id="btnPrevious_<?php echo $title['title_id']; ?>"  class="btnPrevious" aria-label="Previous Slide">
																			<a class="arrow-left" title="" tabindex="-1"></a>
																		  </button>
																		<label class="goToSlideLabel">
																		  <span id="current-slide" class="j-current-slide">1</span> of <span id="total-slides" class="j-total-slides"><?php echo $i; ?></span>
																		</label>
																		  <button id="btnNext_<?php echo $title['title_id']; ?>" class="btnNext"  aria-label="Next Slide">
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
													
					
								
								
							 
									
									
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								

									
						</div>	
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div><!-- END DataTable -->	
		</section>
	</div><!-- .wrap -->
	
<?php endforeach ?>		