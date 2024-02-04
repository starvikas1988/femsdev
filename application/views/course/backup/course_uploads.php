<style>
	td{
		font-size:11px;
	}
	
	#default-datatable th{
		font-size:12px;
	}
	#default-datatable th{
		font-size:12px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:5px;
	}
	
	.modal-dialog{
		width:750px;
	}
	
	td.details-control {
	background: url('<?php echo base_url()?>assets/images/details_open.png') no-repeat center center;
	cursor: pointer;
}
	
tr.shown td.details-control {
	background: url('<?php echo base_url()?>assets/images/details_close.png') no-repeat center center;
	cursor: pointer;
}
		
 
 

.faicon{
	color:red;
	cursor:pointer;
}

.list-group-item{
    position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;
    background-color: #fff;
	border: 0px;
}

.list-inline > li {
    display: inline-block;
    padding-left: 5px;
    padding-right: 50px;
}

.course_title{
	font-family:"Roboto";
	font-size:19px;
	font-weight:bold;
	color:black;
	
}


h1, h2 { font-family: Arial, sans-serif; font-size: 25px; }
h2 { font-size: 20px; }
 
label { font-family: Verdana, sans-serif; font-size: 12px; display: block; }
input { padding: 3px 5px; width: 250px; margin: 0 0 10px; }
input[type="file"] { padding-left: 0; }
input[type="submit"] { width: auto; }
 
#files { font-family: Verdana, sans-serif; font-size: 11px; }
#files strong { font-size: 13px; }
#files a { float: right; margin: 0 0 5px 10px; }
#files ul { list-style: none; padding-left: 0; }
#files li { width: 280px; font-size: 12px; padding: 5px 0; border-bottom: 1px solid #CCC; }

</style>


<div class="wrap"> 
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<div class="row">
							<div class="col-sm-2 col-12 ">
								<h4 class="widget-title btn label labeled">Subject List for course (course 1)</h4>
							</div>
							<div class="col-sm-1 col-1 pull-right">
											<button type="button" class="btn  btn-success"><i class="glyphicon glyphicon-arrow-left"></i> Back </button>
							</div>
						<?php if(check_file_count($this->uri->segment('3'), $this->uri->segment('4')) ==0){ ?>	
							<div class="col-sm-1 col-1 pull-right">
									<button  type="button" class="btn  btn-success"  data-toggle="modal" data-target="#attach_modal" width="100px"><i class="glyphicon glyphicon-plus"></i> Create </button>
							</div>
					    <?php }  ?>
							
						</div>
					</header><!-- .widget-header -->
					<hr class="widget-separator"> 
					<div class="widget-body">
						<ul class="list-inline">
						<?php 
						if(($get_files != null)){ 
							if((count($get_files) > 1)){ 
						
								foreach($get_files as $files){ ?>
								
									<li class="list-group-item"><img id="img" src="<?php echo base_url();?>course_uploads/<?php echo $files['file_name']; ?>" onContextMenu="return false;" width="50px" height="50px" >&nbsp;<button type="button" class="btn btn-success"><span class="fa fa-trash" /></li> 
									
								<?php } ?>
							
							<?php }else{ ?>
								 
								 <?php echo $extension = pathinfo($get_files[0]['file_name'], PATHINFO_EXTENSION);
								 
								 if($extension == 'jpg' || $extension == 'jpeg'){ ?>
								 
									  <li class="list-group-item"><img id="img" src="<?php echo base_url();?>course_uploads/<?php echo $get_files[0]['file_name']; ?>" onContextMenu="return false;" width="50px" height="50px" >&nbsp;<button type="button" class="btn btn-success"><span class="fa fa-trash" /></li> 
								 <?php }elseif($extension == 'pdf'){  ?>	  
									  <div class="PDF">
										   <object data="<?php echo base_url();?>course_uploads/<?php echo $get_files[0]['file_name']; ?>" type="application/pdf" width="50" height="50">
											   alt : <a href="<?php echo $get_files[0]['file_name']; ?>"><?php echo $get_files[0]['file_name']; ?></a>
										   </object>
									 </div>
								 <?php }       ?>
								  
						<?php 
							
							}   
						} 
						?>
						</ul>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>


</div><!-- .wrap -->



<div id="attach_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-themecolor" id="myLargeModalLabel">Add/Edit Attachment <span id="message_id1"></span></h4>
					<button type="button" class="close" style="color:black;" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					 <!-- Bootstrap -->
						  
					  </head>
					  <body>  	
						<section id="form-container">
						  <div class="container">    
							<div class="row">
							  <div class="col-md-6">
							  
								<form action="<?php echo site_url("course/upload") ?>" id="form-upload">         
								  <input type="hidden" id="id_categ" name="course_id" value="<?php echo $this->uri->segment('3');?>" >
								  <input type="hidden" id="idcourse" name="course_id" value="<?php echo $this->uri->segment('4');?>" >
								  <div class="fileinput fileinput-new " data-provides="fileinput" style="padding-bottom:40px">
									<div class="form-control" data-trigger="fileinput">
										<i class="glyphicon glyphicon-file fileinput-exists"></i> 
										<span class="fileinput-filename"></span>
										</div>
										<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new"></span>
											<span class="fileinput-exists"></span>
											<input type="file" name="file[]" multiple id="file">
										</span>
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-remove"></i> Remove</a>
										<a href="#" id="upload-btn" class="input-group-addon btn btn-success fileinput-exists"><i class="glyphicon glyphicon-open"></i> Upload</a>
								  </div>
								</form>

								<!-- <progress id="progress-bar" max="100" value="0"></progress> -->
								<div class="progress" style="display:none;">
								  <div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped " role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
									20%
								  </div>
								</div>

								<ul class="list-group"><ul>
							  </div>
							</div>
						  </div><!-- /.container -->
						</section>
				</div>
			</div>
		</div>
</div>
  
  
 