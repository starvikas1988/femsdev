
<style>
 
 div.currAttachDiv {
	 float:left;
	 display: inline-flex;

	 }

 
 
#content { position: relative; }
#content .close { 
	color: black;
    display: block; 
    position: absolute;
    top: 10; 
    right: 0;
}
#content:hover .close { display: block; }


.img-wrap {
    position: relative;
    display: inline-block;
    #border: 1px red solid;
    font-size: 0;
}
.img-wrap .close {
    position: absolute;
	float-right:0px;
    top: 12px;
    z-index: 100;
    background-color: #FFF;
    padding: 2px 2px 2px;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    opacity: .2;
    text-align: center;
    font-size: 22px;
    line-height: 12px;
    border-radius: 50%;
}
.img-wrap:hover .close {
    opacity: 1;
}



/* for bootstrap grid images */
/* _________________________ */


.row {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
}

/* Create four equal columns that sits next to each other */
.column {
  flex: 25%;
  max-width: 25%;
  padding: 0 4px;
}

.column img {
  margin-top: 8px;
  vertical-align: middle;
}

/* Responsive layout - makes a two column-layout instead of four columns */
@media screen and (max-width: 800px) {
  .column {
    flex: 50%;
    max-width: 50%;
  }
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .column {
    flex: 100%;
    max-width: 100%;
  }
}


.img-wrap .default {
    position: absolute;
    top: 10px;
    left: 2px;
    z-index: 100;
    background-color: #FFF;
    padding: 2px 2px 2px;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    opacity: .2;
    text-align: center;
    font-size: 22px;
    line-height: 12px;
    border-radius: 50%;
}
.img-wrap:hover .default {
    opacity: 1;
}


</style>

<style text="text/css">
body {
  font-family: Verdana, sans-serif;
  margin: 0;
}

* {
  box-sizing: border-box;
}

.row > .column {
  padding: 0 8px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.column {
  float: left;
  width: 25%;
}

/* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 11em;
  padding-top: 10px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: black;
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 1200px;
}

/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

.mySlides {
  display: none;
  position: relative;
}

.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  position: absolute;
  font-weight: bold;
  cursor: pointer;
  top: 0;
  width: 50%;
  height:100%;
  color: white;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;  
}

.btnSlideLeft {
	font-size: 50px;
	position: absolute;
	margin-left:  10px;
	left: 0; 
	top:44%;
}

.btnSlideRight{
	font-size: 50px;
	position: absolute;
	margin-right: 10px;
	right: 0;
	top:44%;	
}


/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.1);
   color: white;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

img {
  margin-bottom: -4px;
}

.caption-container {
  text-align: center;
  background-color: black;
  padding: 2px 16px;
  color: white;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

img.hover-shadow {
  transition: 0.3s;
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}




</style>

 
 <!--<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">
							<div style="float:right; margin-top:20px; margin-right:10px;" class="col-md-4">
								<div class="form-group" style="float:right;">
									 
									<button  title="Attach Files" value="<?php  echo $uri;  ?>"   type="button" class="attachFile form-control btn btn-dark"  data-toggle="modal" data-target="#myModal"><i class='fa fa-upload' aria-hidden='true'></i></button>
								</div>
							</div>
						</h4>
					</header>
					<hr class="widget-separator"/>
				</div>
			</div>
		</div><!-- .row -->
		<!-- report -->
	<!--</section>

</div> .wrap -->

  

<div id="attach_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-themecolor" id="myLargeModalLabel">Add/Edit Attachment <span id="message_id1"></span></h4>
					<button type="button" class="close" style="color:black;" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
						<input type="hidden" value="" name="atpid" id='atpid'>
						<input type="hidden" value="" name="cid" id='cid'>
						
						<div class="form-group">
							<div id='currAttachDiv' class='currAttachDiv'>
							
							</div>
						</div>
				
						<div class="form-group">
								Upload attachment to message 
								<div style="z-index:10;" id="mulitplefileuploader">Upload</div>
						</div>
				</div>
			</div>
		</div>
</div>
  
  

</div><!-- .wrap -->

<div class="wrap">
	<section class="app-content">
	
		<div class="row">
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<div class="row">
							<div class="col-md-10 ">
								<h4 class="widget-title">Gallery</h4>
							</div>
							<div class="col-md-1  float-right">
								<h4 class="widget-title">
									<div style="display: inline-block; text-align: center;">
										<button  title="Back to Album" type="button" class="btn btn-dark" width="100px"><a href="<?php echo base_url();?>album"><i class='fa fa-mail-reply fa-lg' style="color:white"></i></a></button>
									</div>
								</h4>
							</div>
							<?php if (is_access_photo() == true ) { ?>
							<div class="col-md-1 float-right">
									
									<button  title="Attach Files" value="<?php  echo $uri;  ?>"   type="button" class="attachFile  btn btn-dark"  data-toggle="modal" data-target="#myModal" width="100px"><i class='fa fa-upload' aria-hidden='true'></i></button>
								
							</div>
							<?php } ?>
						</div>	
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					
						
							
					<div class="widget-body">
						<div class="parent">
							<?php $i=0; ?>
								 <div class="row">

									<?php foreach($imgfile as $file )  : ?>
										<div class="column">
											<!-- <img class="close" src="close.png" /> -->
												<?php 
												$extension = pathinfo(base_url().''.$file);
												$get_file_extension = $extension['extension'];
												//echo $get_file_extension;
												
												?>
    
											 <div class="img-wrap">
												
												<?php if (is_access_photo() == true ) { ?> 
												<button class="close" title="Delete File" type="button" class="deleteAttach btn btn-danger btn-xs" style="display: block;"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
												<?php }?>
												
							<?php if($get_file_extension == 'jpg' || $get_file_extension == 'jpeg' || $get_file_extension == 'png' || $get_file_extension == 'gif')   :?>
												<?php if (is_access_photo() == true ) { ?> 
												<!--Setting the default album pic -->
											
												<button class="default" title="Set default" type="button" link="<?php echo $file ?>" class="deleteAttach btn btn-danger btn-xs" style="display: block;"><i class="fa fa-check" aria-hidden="true"></i></button>
												
												<!--Setting the default album pic -->
												<?php }?>
												
												<img src="<?php  echo base_url(); ?><?php echo   $file ?>" data-id="<?php   echo $file ?>" class="img-thumbnail hover-shadow cursor" onclick="openModal();currentSlide(<?php echo $i; ?>)"  >
												
							<?php elseif($get_file_extension == 'docx' || $get_file_extension == 'doc') :?>
							
												<a href="<?php  echo base_url(); ?><?php echo $file ?>" target="_blank"><img src="<?php  echo base_url(); ?>main_img/word.png" alt="word" class="img-thumbnail hover-shadow cursor"></a>
												
							<?php elseif($get_file_extension == 'xlsx' || $get_file_extension == 'xls') :?>		
							
												<a href="<?php  echo base_url(); ?><?php echo $file ?>" target="_blank"><img src="<?php  echo base_url(); ?>main_img/excel.png" alt="excel" class="img-thumbnail hover-shadow cursor"></a>		
												
							<?php elseif($get_file_extension == 'pdf') :	?>	
							
												<a href="<?php  echo base_url(); ?><?php echo $file ?>" target="_blank"><img src="<?php  echo base_url(); ?>main_img/pdf.png" alt="pdf" class="img-thumbnail hover-shadow cursor"></a>	
												
							<?php endif;  ?>
													
											</div>	
										</div>	
										
									<?php $i++; ?>
									<?php  endforeach;  ?>	
								</div> 
								


			<div id="myModal_scroller" class="modal">
			  <span class="close cursor" onclick="closeModal()">&times;</span>
				<div class="modal-content">
				
					<?php $i=1; 
					 foreach($imgfile as $file )  :
							$extension_o = pathinfo(base_url().''.$file);
							$get_file_extension_o = $extension_o['extension'];
							
					?>
					<?php if($get_file_extension_o == 'jpg' || $get_file_extension_o == 'jpeg' || $get_file_extension_o == 'png' || $get_file_extension_o == 'gif')   :?>
							<div class="mySlides">
							  <div class="numbertext"><?php echo $i; ?> / <?php echo count($imgfile); ?></div>
							  <img src="<?php  echo base_url(); ?><?php echo   $file ?>" style="width:100%" class="img-thumbnail hover-shadow cursor">
							</div>
							
							
					<?php endif;  
					   $i++;
					   endforeach;  ?>	
					
						<a class="prev" onclick="plusSlides(-1)"><span class='btnSlideLeft'> &#10094; </span> </a>
						<a class="next" onclick="plusSlides(1)"><span class='btnSlideRight'> &#10095; </span> </a>

					<div class="caption-container">
					  <p id="caption"></p>
					</div>
				</div>
			</div>								
					

					
							
						</div>
					</div><!-- .widget-body -->
					
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
						
		</div><!-- .row -->
		
	</section>

</div>


<script>
// Open the Modal
function openModal() {
  document.getElementById("myModal_scroller").style.display = "block";
}

// Close the Modal
function closeModal() {
  document.getElementById("myModal_scroller").style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
  
}

// Thumbnail image controls
function currentSlide(n) { 
  showSlides(slideIndex = n);
}

function showSlides(n) {

  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
</script>
  