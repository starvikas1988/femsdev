
<style>
	
		
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:5px;
	}
	
.widget-header, .widget{
			
			background-color:orange;
			border:sold 1px black;
			border-radius: 17px 17px 0px 0px;
}


.widget-body,.widget-separator{
			background-color:white;
			border:sold 1px black;
			box-shadow:1px 1px 1px;
			border-radius: 0px 0px 0px 0px;
			-moz-border-radius: 0px 0px 0px 0px;
			-webkit-border-radius: 0px 0px 0px 0px;
			border: 0px solid #000000;
			-webkit-box-shadow: 11px 14px 23px -6px rgba(0,0,0,0.75);
			-moz-box-shadow: 11px 14px 23px -6px rgba(0,0,0,0.75);
			box-shadow: 11px 14px 23px -6px rgba(0,0,0,0.75);
}



.prevAttachDiv{
	background-color:#f5f5f5;
	float:left;
	position:relative;
	height:auto; min-height:70px;
	width:100%;
	border:1px solid #ccc; 
	padding:3px;
	z-index:1;
}

.currAttachDiv{
	background-color:#f5f5f5;
	float:left;
	position:relative;
	height:auto; min-height:70px;
	width:100%;
	border:1px solid #ccc; 
	padding:3px;
	z-index:1;
	display:none;
}

.attachDiv{
	width: 50px;
	height: 50px;
	float:left;
	padding:1px;
	border:2px solid #ccc; 
	margin:5px;
	position:relative;
	cursor:pointer;
}

.attachDiv img{
	width: 100%;
	height: 100%;
	position:relative;
}

.deleteAttach{
	display:none;
	cursor:pointer;
	top:0;
	right:0;
	position:absolute;
	z-index:99;
}

input[type="checkbox"]{
  width: 20px;
  height: 20px;
}


</style>

<style> .frame{ 
           
			position: relative; top: 0; left: 0; 
			box-shadow:1px 1px 1px;
			border-radius: 17px 17px 17px 17px;
			-moz-border-radius: 17px 17px 17px 17px;
			-webkit-border-radius: 17px 17px 17px 17px;
			border: 0px solid #000000;
			-webkit-box-shadow: 11px 14px 23px -6px rgba(0,0,0,0.75);
			-moz-box-shadow: 11px 14px 23px -6px rgba(0,0,0,0.75);
			box-shadow: 11px 14px 23px -6px rgba(0,0,0,0.75);
			cursor: pointer;

} 
	.picture{
		
			position: absolute;	
			box-shadow:1px 1px 1px;
			border-radius: 11px 11px 11px 11px;
			-moz-border-radius: 11px 11px 11px 11px;
			-webkit-border-radius: 11px 11px 11px 11px;
			border: 0px solid #000000;
			-webkit-box-shadow: 11px 14px 23px -6px rgba(0,0,0,0.75);
			-moz-box-shadow: 11px 14px 23px -6px rgba(0,0,0,0.75);
			box-shadow: 11px 14px 23px -6px rgba(0,0,0,0.75);
			cursor: pointer;
	} 
	
.alertol  {
			padding: 10px;
			margin-top: -43px;
			position: absolute;	
			opacity: 0.6;
			border-radius: 12px 12px 12px 12px;
			
	} 	
	
.col-md-3 {
    width: 25%;
    height: 20%;
}
	
	
	
	
	
	
	</style>

<!-- report -->


<!-- <div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">
							<div style="float:right; margin-top:20px; margin-right:10px;" class="col-md-4">
								<div class="form-group" style="float:right;">
									<button type="button" class="form-control btn btn-dark"  data-toggle="modal" data-target="#myModal">Create Album</button>
								</div>
							</div>
						</h4>
					</header>
					<hr class="widget-separator"/>
				</div>
			</div>
		</div><!-- .row -->
		<!-- report -->
	<!-- </section>

<!-- </div><!-- .wrap -->


<div class="wrap">
	<section class="app-content">
	
		<div class="row">
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<!--<h4 class="widget-title">Current Albums</h4>
					<!-- .widget-header -->
					
					<div class="row">
							<div class="col-md-10 ">
								<h4 class="widget-title">User Gallery</h4>
							</div>
							
						<?php if (is_access_photo() == true ) { ?>
							<div class="col-md-2 float-right">
									<button type="button" class="form-control btn btn-dark"  data-toggle="modal" data-target="#myModal">Create Album</button>
							</div>
						<?php } ?>
						</div>	
					
					</header>
					<hr class="widget-separator"> 
					<div class="widget-body">
						<div class="parent">
							
							<div class="row">
								<?php foreach($albums as $display) :?>
										<?php   
										
										$file_name = array();
										
										/* $extract_uri = explode("&",$display);
										$extract_name = explode("/",$extract_uri[0]); */
								 
								
								 
										// $dir = $this->config->item('image_gallery').'/'.$extract_uri[0].'/';
										 
											/* if (is_dir($dir)){
											  if ($dh = opendir($dir)){
													
													while (($file = readdir($dh)) !== false){
														if ($file!='.' && $file!='..'){
															$file_name[] = $file;
														}
													}
													
													closedir($dh);
											  }
											}
										 
													
												$filtered_array = array_filter($file_name); 
												  
											
												if (!empty($filtered_array)){
													$extension = pathinfo(base_url().''.$filtered_array[0]);
													$get_file_extension = $extension['extension'];
												} */
												
										?>
										
										<div class="col-md-3" style="padding-top:10px" title="<?php echo $display['album_name'] ?>"> 
										<?php if($display['album_cover']!="") {  ?>
											<img alt="" src="<?php echo base_url().''.$display['album_cover'];?>" width="200px" height="200px"  class="picture">
										<?php }else{ ?>				 
													
											<img alt="" src="<?php echo base_url();?>main_img/Untitled.png" width="180px"
													height="180px"  class="picture">
										
										<?php }     ?>
											<a href="<?php echo base_url();?>gallery/album?s=<?php echo urlencode($display['album_userid']."/".$display['album_name']."&". $display['id']);  ?>">
											<img alt="" src="<?php echo base_url();?>main_img/f1.png" width="200px" height="200px"  class="frame"></a>
											<div class="alertol alert-success">
											  <strong><?php echo $display['album_name']; ?></strong> 
											</div>
										</div>
										
										
										
										<?php endforeach; ?>
										</div>
								
							</div>
						</div><!-- .widget-body -->
					
					</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
						
		</div><!-- .row -->
		
	</section>

	
	
</div>
	

	<?php 
	if($this->session->flashdata('message') != '') {?>
		<div class="alert alert-danger alert-dismissible" align="center">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <strong><?php echo $this->session->flashdata('message'); ?></strong>	
		</div>
	<?php 
	}
	?>
	
  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
		<form id="f1" method="post" action="<?php echo base_url(); ?>album/create_album">
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title">Create Album</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<label for="album_name">Album Name : </label>
							<input type="text" name="album_name" class="form-control" required >	
						</div>
					</div>
					<div class="modal-footer">
					  <button type="submit" class="btn btn-success">Save</button>
					</div> 
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
			  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
        </form>
      </div>
    </div>
  </div>
  
  
  
 