 <link rel="stylesheet" href="<?php echo base_url(); ?>course_uploads/loader/percircle.css">
 
    <!--<link href="<?php echo base_url(); ?>libs/bower/course_slider/app_critical7069.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>libs/bower/course_slider/combined_presentation89a2.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>libs/bower/course_slider/slideviewc0c4.css media="screen" rel="stylesheet" type="text/css" />-->
	
	<link href="<?php // echo base_url(); ?>libs/bower/course_slider/fancybox-style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>libs/bower/course_slider/custom-style.css" rel="stylesheet" type="text/css" />
	
	
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

.image-gallary-grid li img {
    width: 100%;
    height: 508px;
    padding-bottom: 10px;
}

.percircle.small {
    font-size: 45px;
    margin-top: 7px;
}

.carousel .nav a small {
    display:block;
}
.carousel .nav {
	background:#eee;
}
.carousel .nav a {
    border-radius:0px;
}

.carousel .active  {
    background:green;
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
								<div class="col-sm-1 col-1 pull-right">
									<a href="<?php echo base_url();?>course" class="btn  btn-success"><i class="glyphicon glyphicon-arrow-left"></i> Back </a>
								</div>
							</div>
						</header><!-- .widget-header -->
						<!--<hr class="widget-separator"> 
						<div class="widget-body">
							<!--<div class="clearfix" style="padding-left:20px">
									<div id="redBecomesBlue" class="red small" title="Your Progress"></div> 
							</div>
						</div>-->
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</section>
	</div><!-- .wrap -->	
<?php $k=0; ?>
<?php $j=1; ?>
<?php foreach($course_title as $title) :?> 

<?php  $file_name = explode(",",$title['title_image']);
	  $file_extension='';
?> 
 	  	
	<div class="wrap course_section" id="partition_<?php echo $title['title_id']; ?>" style="display:<?php echo $k == 0 ? 'block':'none'; ?>">
		<section class="app-content">
			<div class="row">
			<!-- DataTable -->
				<div class="col-md-12">
					<div class="widget">
						<div class="widget-body list-inline">
							
								
								</br>
								<!--- DIV SLIDER -->
									
										<!--<div id="myCarousel_<?php echo $j;?>" class="carousel slide" data-ride="carousel">-->
										<div id="myCarousel_<?php echo $j;?>" class="carousel slide" data-ride="">
										
										  <!-- Wrapper for slides -->
										   <div class="carousel-inner">
										    
												<?php for($i=1;$i<count($file_name);$i++){ ?>	 
											   
													<div class="item <?php echo $i==1?'active':''; ?>">
													
													<?php $file_extension = pathinfo(strtolower($file_name[$i]), PATHINFO_EXTENSION) ; 
												
													 if($file_extension == 'mp4'){ ?>
														  <video id='homevideo'  controls webkit-playsinline='' width='100%' height='100%' >
																<source src="<?php echo base_url()."course_uploads/".$file_name[$i]; ?>" type='video/mp4'>
														  </video>
														  
													<?php }elseif($file_extension == 'jpeg' || $file_extension == 'jpg'){ ?> 
															
															<img src='<?php echo base_url();?>course_uploads/<?php echo $file_name[$i]; ?>' id='<?php echo $j.'_'.$i;?>'/>


												   
												   <?php }elseif($file_extension == 'pdf' ){ ?> 
														<button onclick="openFullscreen();">Open Pdf in Fullscreen Mode & Press ESC to exit</button>
														<div id="pdf">
															<object data="<?php echo base_url();?>course_uploads/<?php echo $file_name[$i]; ?>" type="application/pdf" width="100%" height="100%">
														</div>
													<?php } ?> 
													   
													</div><!-- End Item -->
														
												<?php } ?>	
													
										   </div><!-- End Carousel Inner -->	 
										   <?php if($title['is_text'] == 0){ ?>
										  
												<ul class="nav nav-pills nav-justified">
													 <!--<li><button id="button_next_<?php echo $j;?>" class="btn_next btn btn-danger"><span class="fa fa-arrow-left"></span></button></li>--> 
													<?php for($i=1;$i<count($file_name);$i++){ ?>	 
													  <li data-target="#myCarousel_<?php echo $j; ?>" data-slide-to="<?php echo $i; ?>" class="<?php echo $i==1?'active':''; ?>"><a href="#"><?php echo  $i; ?></small></a></li>
													
													<?php } ?>
													
													 <!--<li><button id="button_previous_<?php echo $j;?>" class="btn btn-danger"><span class="fa fa-arrow-right"></span></button></li>-->
												</ul>
										   <?php }?>
										  
										</div><!-- End Carousel -->
										
										<blockquote>
											<p>
											<?php if($title['is_text'] == 1){ ?>
												
												<?php echo $title['text_field']; ?>
												
											<?php }?>
											</p>
										</blockquote>
										
								</form>
						</div>
						
								
								
								   
					</div>	
				</div><!-- .widget-body -->
			</div><!-- .widget -->
		</section>
	</div><!-- .wrap -->
	<?php $k = $k + 1; ?>
	<?php $j = $j + 1; ?>
<?php endforeach ?>		
