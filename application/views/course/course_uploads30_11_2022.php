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



#accordion .panel-heading { padding: 0;}
#accordion .panel-title > a {
	display: block;
	padding: 0.4em 0.6em;
    outline: none;
    font-weight:bold;
    text-decoration: none;
}

#accordion .panel-title > a.accordion-toggle::before, #accordion a[data-toggle="collapse"]::before  {
    content:"\e113";
    float: left;
    font-family: 'Glyphicons Halflings';
	margin-right :1em;
}
#accordion .panel-title > a.accordion-toggle.collapsed::before, #accordion a.collapsed[data-toggle="collapse"]::before  {
    content:"\e114";
}


.btn-icon{
	color: red;
	background-color: #f5f7f9;
	border-color: #f5f7f9;
}

.item {
	border:1px solid red;
}

</style>


 

<div class="wrap"> 
	<form id="f1">
		<input type="hidden" name="category_id" value="<?php echo $categories_id ;?>"?>
		<input type="hidden" name="course_id" value="<?php echo $course_id ;?>"?>
	</form>
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<div class="row">
							<div class="col-sm-2 col-4 ">
								<h4 class="widget-title btn label labeled">Subject List for course</h4>
							</div>
							<div class="col-sm-1 col-1 pull-right">
								<?php if($gant_access == true){  ?>
									<a href="<?php echo base_url();?>course/view_subject_list/<?php echo $this->uri->segment('3');?>" type="button" class="btn  btn-success"><i class="glyphicon glyphicon-arrow-left"></i> Back </a>
								<?php }else{  ?>
									<a href="<?php echo base_url();?>course" type="button" class="btn  btn-success"><i class="glyphicon glyphicon-arrow-left"></i> Back </a>
								<?php } ?>
							</div>
						<?php if(check_file_count($this->uri->segment('3'), $this->uri->segment('4')) ==0){ ?>	
							<div class="col-sm-0 col-1 pull-right">
									<button  type="button" class="btn  btn-success"  data-toggle="modal" data-target="#set_category" width="100px" title="Create course description "><i class="glyphicon glyphicon-plus"></i></button>
							</div>
					    <?php }  ?>
							
						</div>
					</header><!-- .widget-header -->
					<hr class="widget-separator"> 
					<div class="widget-body">
							<?php foreach($course as $title){ ?>
									<h4><span class="badge badge-secondary">Course Title</span> :<?php echo $title['course_name']; ?></h4>
									<h4><span class="badge badge-secondary">Course Description</span> :<?php echo $title['course_desc']; ?></h4>
									<h4><span class="badge badge-secondary">Course Requirement</span> :<?php echo $title['requirement']; ?></h4>
									<h4><span class="badge badge-secondary">Course Prerequisites</span> :<?php echo $title['prerequisites']; ?></h4>
									<h4><?php echo $title['whoshould']; ?></h4>
									<h4><?php echo $title['whosfor']; ?></h4>
									
							<?php }          ?>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>

	
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<div class="row">
							<div class="col-sm-2 col-12 ">
								<h4 class="widget-title btn label labeled">Course content</h4>
							</div>
						<?php if(check_file_count($this->uri->segment('3'), $this->uri->segment('4')) ==0){ ?>	
							<div class="col-sm-1 col-1 pull-right">
									<button  type="button" class="btn  btn-success course_content"  data-toggle="modal" data-target="#attach_modal" width="100px" title="Create Course Content"><i class="glyphicon glyphicon-plus"></i></button>
							</div>
					    <?php }  ?>
							
						</div>
					</header><!-- .widget-header -->
					<hr class="widget-separator"> 
						
							<div class="container">
								<div class="row">
									<div class="col-md-11" id="main">
										<h3></h3>
										<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
										
										<?php foreach($course_title as $title){ ?>
										
											  <div class="panel panel-default">
												<div class="panel-heading" role="tab" id="headingOne">
													<div class="row">
														<div class="col-12">
														  <h4 class="panel-title">
																<div class="col-sm-8 col-8 panel-title">
																	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $title['title_id'];?>" aria-expanded="true" aria-controls="collapse<?php echo $title['title_id'];?>">
																	<?php echo $title['title']; ?> 
																	</a>
																</div>
																<div class="col-sm-0 col-0 pull-right">
																<?php 
																	
																	 $key = array_search($title['title_id'], array_column($is_exam_assigned, 'title_id'));
																
																?>
																		<?php if(!empty($is_exam_assigned)){ ?>
																			<button class="btn btn-icon pull-right assign_exam" data-titleid="<?php echo $title['title_id']; ?>" id="titleid_<?php echo $title['title_id']; ?>"  title="<?php echo  $is_exam_assigned[$key]['title_id'] == $title['title_id']?'Assesment is Assigned to '.$is_exam_assigned[$key]['set_title'] :'Assesment is not Assigned'; ?>" data-toggle="modal" data-target="#create_dipcheck_modal"><span class="fa fa-graduation-cap"></span></button>
																		<?php }else{  ?>
																			<button class="btn btn-icon pull-right assign_exam" data-titleid="<?php echo $title['title_id']; ?>" id="titleid_<?php echo $title['title_id']; ?>"  title="Assesment is not Assigned" data-toggle="modal" data-target="#create_dipcheck_modal"><span class="fa fa-graduation-cap"></span></button>
																		<?php } ?> 
																</div>
																<div class="col-sm-0 col-0 pull-right">
																		<button class="btn btn-icon pull-right title_edit" data-titleid="<?php echo $title['title_id']; ?>" id="titleid_<?php echo $title['title_id']; ?>"  title="Edit course title" data-toggle="modal" data-target="#attach_modal"><span class="fa fa-edit"></span></button>
																</div>
																<div class="col-sm-0 col-0 pull-right">
																		<button class="btn btn-icon pull-right course_upload" data-uploadid="<?php echo $title['title_id']; ?>" id="uploadid_<?php echo $title['title_id']; ?>" data-toggle="modal" data-target="#upload_file" width="100px"><span class="fa fa-upload"></span></button>
																</div>
																
																<div class="col-sm-0 col-0 pull-right">
																		<button class="btn btn-icon pull-right course_txt" data-uploadid="<?php echo $title['title_id']; ?>" id="txtid_<?php echo $title['title_id']; ?>" data-toggle="modal" data-target="#inputtext" width="100px" title="Add Textlines "><span class="fa fa-pencil"></span></button>
																</div> 
																
																<div class="col-sm-0 col-0 pull-right">
																		<button class="btn btn-icon pull-right title_delete" data-titleid="<?php echo $title['title_id']; ?>" id="txtid_<?php echo $title['title_id']; ?>" width="100px" title="Delete Title's"><span class="fa fa-trash"></span></button>
																</div> 
														  </h4>
														</div>
														  
													</div>
												  
												</div>
												<div id="collapse<?php echo $title['title_id'];?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $title['title_id'];?>">
												  <div class="panel-body">
													<section class="app-content">
														<div class="row">
														<!-- DataTable -->
														<div class="col-md-12">
																<div class="widget">
																	<!--<header class="widget-header">
																		<div class="row">
																			<div class="col-sm-2 col-4 ">
																				<h4 class="widget-title btn label labeled"></h4>
																			</div>
																			<div class="col-sm-1 col-1 pull-right">
																			<?php 
																				
																				 //$key = array_search($title['title_id'], array_column($is_exam_assigned, 'title_id'));
																			
																			?>
																					<?php //if(!empty($is_exam_assigned)){ ?>
																						<button class="btn btn-primary pull-right assign_exam" data-titleid="<?php echo $title['title_id']; ?>" id="titleid_<?php echo $title['title_id']; ?>"  title="<?php echo  $is_exam_assigned[$key]['title_id'] == $title['title_id']?'Assesment is Assigned to '.$is_exam_assigned[$key]['set_title'] :'Assesment is not Assigned'; ?>" data-toggle="modal" data-target="#create_dipcheck_modal"><span class="fa fa-graduation-cap"></span></button>
																					<?php //}else{  ?>
																						<button class="btn btn-primary pull-right assign_exam" data-titleid="<?php echo $title['title_id']; ?>" id="titleid_<?php echo $title['title_id']; ?>"  title="Assesment is not Assigned" data-toggle="modal" data-target="#create_dipcheck_modal"><span class="fa fa-graduation-cap"></span></button>
																					<?php //} ?>
																					
																			</div>
																			<div class="col-sm-1 col-1 pull-right">
																					<button class="btn btn-primary pull-right title_edit" data-titleid="<?php echo $title['title_id']; ?>" id="titleid_<?php echo $title['title_id']; ?>"  title="Edit course title" data-toggle="modal" data-target="#attach_modal"><span class="fa fa-edit"></span></button>
																			</div>
																			<div class="col-sm-1 col-1 pull-right">
																					<button class="btn btn-primary pull-right course_upload" data-uploadid="<?php echo $title['title_id']; ?>" id="uploadid_<?php echo $title['title_id']; ?>" data-toggle="modal" data-target="#upload_file" width="100px"><span class="fa fa-upload"></span></button>
																			</div>
																			
																			<div class="col-sm-1 col-1 pull-right">
																					<button class="btn btn-primary pull-right course_txt" data-uploadid="<?php echo $title['title_id']; ?>" id="txtid_<?php echo $title['title_id']; ?>" data-toggle="modal" data-target="#inputtext" width="100px" title="Add Textlines "><span class="fa fa-pencil"></span></button>
																			</div>
																		</div>
																	</header> --><!-- .widget-header -->
																	<hr class="widget-separator"> 
																	<div class="widget-body">
																	
																		<ul class="list-inline" >
																			<?php $split_files  = explode(',',$title['title_image']);
																					
																					for($i=0;$i<count($split_files);$i++){ ?>
																							
																							<?php  $extension = pathinfo($split_files[$i], PATHINFO_EXTENSION);
								 
																									if(strtolower($extension) == 'jpg' || strtolower($extension) == 'jpeg' || strtolower($extension) == 'gif' || strtolower($extension) == 'png'){ ?>
																									 <li class="list-inline-item" style="margin-top:20px"><img class="img-fluid  img-thumbnail" width="100px" height="100px" src="<?php echo base_url();?>/course_uploads/<?php echo $split_files[$i]; ?>" alt="<?php echo $split_files[$i]; ?>"></li>
																									 
																							<?php	}elseif(strtolower($extension) == 'mp4'){  ?>
																							
																									<li class="list-inline-item"><video width="320" height="240" controls><source src="<?php echo base_url();?>/course_uploads/<?php echo $split_files[$i]; ?>" type="video/mp4"></li>
																									
																							<?php	}elseif(strtolower($extension) == 'pdf'){  ?>
																										<object data="<?php echo base_url();?>course_uploads/<?php echo $split_files[$i]; ?>" type="application/pdf" width="100%"></object>

																							<?php	}  ?>
																					<?php }  ?>
																					
																				<li class="list-inline-item"><?php 
																				
																					if($title['is_text'] == 1){
																						echo $title['text_field'];
																					}
																				
																				?></li>
																			
																		</ul>
																	</div><!-- .widget-body -->
																</div><!-- .widget -->
															</div>
															<!-- END DataTable -->	
														</div><!-- .row -->
													</section>
												  
												  
												</div>
												</div>
											  </div>
										<?php }  ?>
										  
										  <!--<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingTwo">
											  <h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
												  Collapsible Group Item #2
												</a>
											  </h4>
											</div>
											<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
											  <div class="panel-body">
												Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
											  </div>
											</div>
										  </div>
										  <div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingThree">
											  <h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
												  Collapsible Group Item #3
												</a>
											  </h4>
											</div>
											<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
											  <div class="panel-body">
												Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
											  </div>
											</div>
										  </div>
										  -->
										</div>
										
									</div>
									
								</div>
							<div>
						
					<!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>

</div><!-- .wrap -->





<div class="modal fade" id="set_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form method="post" action ="<?php echo base_url();?>course/create_description">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Course More Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		  <div class="modal-body">
				<section id="form-container">
				  <div class="container">    
				  <input type="hidden" name="category_id" value="<?php echo $this->uri->segment(3);?>" class="form-control" placeholder="course title">
				  <input type="hidden" name="course_id"  value="<?php echo $this->uri->segment(4);?>" class="form-control" placeholder="course title">
				  
						<div class="col-md-7">
							<label for="requirementFormControlInput1">Requirements</label>
							<textarea class="form-control" id="requirementFormControlInput1" name="requirementFormControlInput1" rows="3" required></textarea>
					    </div>
					    <div class="col-md-7">
							<label for="descriptioneFormControlSelect1">Description</label>
							<textarea class="form-control" id="descriptioneFormControlInpu2" name="descriptionFormControlInput2" rows="3" required></textarea>
						</div>
						<div class="col-md-7">
							<label for="prerequisitesFormControlSelect2">Prerequisites</label>
							<textarea class="form-control" id="prerequisitesFormControlInput3" name="prerequisitesFormControlInput3" rows="3" required></textarea>
						</div>
						<div class="col-md-7">
							<label for="whoshouldFormControlTextarea1">Who should take this course:</label>
							<textarea class="form-control" id="whoshouldFormControlInput4" name="whoshouldFormControlInput4" rows="3" required></textarea>
						</div>
						<div class="col-md-7">
							<label for="whosforFormControlTextarea1">Course Certification and Assessment:</label>
							<textarea class="form-control" id="whosforFormControlInput5" name="whosforFormControlInput5" rows="3" required></textarea>
						</div>
						 
				  </div><!-- /.container -->
				</section>
		  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
	</form>
  </div>
</div>




<div class="modal fade" id="inputtext" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form method="post" action ="<?php echo base_url();?>course/create_textinsteadofimage">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Course More Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		  <div class="modal-body">
				<section id="form-container">
				  <div class="container">     
						<div class="col-md-7">
						  <input type="hidden" name="category_id" value="<?php echo $this->uri->segment(3);?>" class="form-control" placeholder="course title">
						  <input type="hidden" name="course_id"  value="<?php echo $this->uri->segment(4);?>" class="form-control" placeholder="course title">
						  <input type="hidden" id="txttitle_id" name="title_id"  value="" class="form-control">
				  
				  
							<label for="inputtext1">Input Text</label>
							<textarea class="form-control" id="inputtext1" name="inputtext" rows="8" required></textarea>
					    </div>
				  </div><!-- /.container -->
				</section>
		  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
	</form>
  </div>
</div>


<div id="attach_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
		 <form method="post" action="<?php echo base_url();?>course/create_title">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-themecolor" id="myLargeModalLabel">Create Contents <span id="message_id1"></span></h4>
					<button type="button" class="close" style="color:black;" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					 <!-- Bootstrap --> 	
					<section id="form-container">
						<input type="hidden" id='categid' name="category_id" value="<?php echo $this->uri->segment(3);?>" class="form-control">
						<input type="hidden" id='coursegid' name="course_id"   value="<?php echo $this->uri->segment(4);?>" class="form-control">
						<input type="hidden" id="title_id" name="title_id"  value="" class="form-control">
						<input type="text" id='content' name="content" class="form-control" placeholder="Course content title">
					  
					</section>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</form>	
	 </div>
</div>
  
  
<div class="modal fade" id="upload_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document"> 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Documents</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		  <div class="modal-body">
			  <div class="container"> 
				  <div class="row">
					<div class="col-md-6">
					<form action="<?php echo site_url("course/upload") ?>" id="form-upload">         
					  <input type="hidden" id="idcourse" name="id_categ" value="<?php echo $course_id; ?>" >
					  <input type="hidden" id="id_categ" name="idcourse" value="<?php echo $categories_id; ?>" >
					  <input type="hidden" id="course_title" name="course_title" value="" >
					  
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
				</div><!-- /.container -->
		  </div>
    </div> 
  </div>
</div>
</div>

	<!----  CREATE EXAM -->

<div class="modal fade" id="create_dipcheck_modal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Create Course Exam</h4>
			</div>
			<form id="create_dipcheck_form"  action="<?php echo base_url(); ?>course/savedipcheck" method='POST'>
				<div class="modal-body">
					  <input type="hidden" id="idcourse" name="course_id" value="<?php echo $course_id; ?>" >
					  <input type="hidden" id="id_categ" name="categories_id" value="<?php echo $categories_id; ?>" >
					  <input type="hidden" id="titleid" name="title_id" value="" >

					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Exam Question Paper</label>
								<select name="exam_id" id="exam_id" class="form-control examid" required>
									<option value="">--Select Exam Question Paper--</option>
								<?php  foreach($examination_list as $exam): ?>
									<option data-exam_id="<?php echo $exam['id']; ?>" value="<?php echo $exam['id']; ?>"><?php echo $exam['title']; ?></option>
								<?php  endforeach; ?>
								</select>
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Exam Question Set</label>
								<select name="set_id" id="set_id" class="form-control" required>
									<!--<option value="">--Select Exam Question Set--</option>-->
								</select>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Total Questions</label>
								<input type="text" name="no_question" id="no_question" class="form-control" disabled>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Set No. of Questions</label>
								<input type="text" name="set_no_question" id="set_no_question" class="form-control" required>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
									<label>Description:</label>
									<input type="text" class="form-control" id="course_description" name="description" required>
							</div>
						</div>	
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
									<label>Input Pass Marks:</label>
									<input type="text" class="form-control" id="passmarks" name="passmarks" required>
							</div>
						</div>	
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id='btnSubmit' class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>  