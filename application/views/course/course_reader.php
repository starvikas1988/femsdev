	<link rel="stylesheet" href="<?php echo base_url(); ?>course_uploads/loader/percircle.css">

<style>

.tag {
       float: left;
       position: absolute;
       left: 0px;
       top: 0px;
	   width:98%;
	   height:100%;
       z-index: 1000;
	   text-indent: 100vw;
    }
	.item {		
		margin:0 0 15px 0;
		border:2px solid #bdbdbd;
		border-radius:5px;
		padding:5px;
	}
	.course-content-heading  {		
		display:block;
		background:#188ae2;
		color:#fff;
	}
	.blockquote-footer {
		color:#fff!important;
	}

</style>

	  <input type="hidden" name="categoryid" id="categoryid" value="<?php echo $category_id; ?>">
	  <input type="hidden" name="courseid" id="courseid" value="<?php echo $course_id; ?>">
				
				<div class="home">
							<div class="row">
								<div class="col">
									<a  href="<?php echo base_url(); ?>course/view_subject_list/<?php echo $this->uri->segment(3);?>" type="button" class="btn  btn-success"  width="100px"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
								</div>
							</div>
				</div>
				
				<div class="row">
                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                        <div class="row course-content">
                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                                <div class="card card-shadow mb-4">
                                    <div class="card-body">
                                        <div class="course-content-heading mb-3 pl-3 pr-2 pb-2">
                                            <blockquote class="blockquote m-0 blockquote-reverse text-uppercase">
                                                <small class="mb-0"><?php echo $course['course_name']; ?></small>
                                                <span class="blockquote-footer"><?php echo $course['course_desc']; ?></span>
                                            </blockquote>
                                        </div>
                                        <div class="course-video mb-4">
										
										<?php $k=0; ?>
										<?php $j=1; ?>
										<?php foreach($course_title as $title) :?> 

										<?php  $file_name = explode(",",$title['title_image']);
											  $file_extension='';
										?> 
												
											<div class="wrap course_section" id="partition_<?php echo $title['title_id']; ?>" style="display:<?php echo $k == 0 ? 'block':'none'; ?>">
												<!--embed-responsive-16by9-->
												
												<div class="embed-responsive-16by9">
													<?php for($i=0;$i<count($file_name);$i++){ ?>	 
											   
														<div class="item <?php echo $i==0?'active':''; ?>">
														
														<?php $file_extension = pathinfo(strtolower($file_name[$i]), PATHINFO_EXTENSION) ; 
													 
														 if($file_extension == 'mp4'){ ?>
															  <video id='homevideo'  controls webkit-playsinline='' width='100%' height='100%' >
																	<source src="<?php echo base_url()."course_uploads/".$file_name[$i]; ?>" type='video/mp4'>
															  </video>
															 
															  
														<?php }elseif($file_extension == 'jpeg' || $file_extension == 'jpg'){ ?> 
																
																<div class="col-lg-12">	
																	<img  style="height: auto;  width: 100%; display:<?php echo $k == 0 ? 'block':'none'; ?> class="img-responsive" src='<?php echo base_url();?>course_uploads/<?php echo $file_name[$i]; ?>' id='<?php echo $j.'_'.$i;?>'>
																</div>

													   
													   <?php }elseif($file_extension == 'pdf' ){ ?> 
															<div id="pdf" style="height:500px">
																<img id="img_file_<?php echo $title['title_id']; ?>" class="tag" src="" style="border:none">
																<object id="pdf_file_<?php echo $title['title_id']; ?>"  data="<?php echo base_url();?>course_uploads/<?php echo $file_name[$i]; ?>#toolbar=0;" type="application/pdf" width="100%" height="100%"></object>
																
															</div>
															&nbsp;
															<button  class="btn btn-secondary pdf_file" value="<?php echo $title['title_id']; ?>">Open Pdf in Fullscreen Mode & Press ESC to exit</button>
														<?php } ?> 
														   
														</div><!-- End Item -->
														
													<?php } ?>	
													
													
														<blockquote>
															<p>
															<?php if($title['is_text'] == 1){ ?>
																
																<?php echo $title['text_field']; ?>
																
															<?php }?>
															</p>
														</blockquote>
													
												</div>
											
											</div><!-- .wrap -->
											
											<?php $k = $k + 1; ?>
											<?php $j = $j + 1; ?>
										<?php endforeach ?>		

                                        </div>
                                        <!--<div class="course-details-content">
                                            <ul class="nav nav-pills mb-4" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#tab-1">Overview</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tab-2">Q&A</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#tab-3">Announcements</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab-1" role="tabpanel">
                                                    Build responsive, mobile-first projects on the web with the world's most popular front-end component library.
                                                    Bootstrap is an open source toolkit for developing with HTML, CSS, and JS. Quickly prototype your ideas or build your entire app with our Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful plugins built on jQuery.
                                                </div>
                                                <div class="tab-pane" id="tab-2" role="tabpanel">
                                                    <form>
                                                        <div class="input-group question-search-filter mb-4">
                                                            <input type="text" class="form-control" placeholder="Search all course questions">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-secondary" type="button">
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row question-filter mb-4">
                                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                                
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                               
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                                <div class="form-group m-0">
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row question-filter-massaging">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="card card-shadow mb-4">
                                                                    <div class="card-header pl-0 pr-0">
                                                                        <div class="card-title">
                                                                            4 question in this course
                                                                            <div class="float-right text-capitalize">
                                                                                ask a new question
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body p-0">
                                                                        <div class="media mb-2 border-bottom">
                                                                            <div class="profile-short align-self-center mr-3 rounded-circle">
                                                                                <span>rb</span>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <p class="mb-0 text-capitalize"><strong>build 11 E-learning scenarios</strong></p>
                                                                                <span class="text-capitalize">where do i find the discount code the "build 11 E-learning scenarios"</span>
                                                                            </div>
                                                                            <div class="author">
                                                                                <small class="text-capitalize text-info">robin <span class="seperator text-dark">||</span><span class="text-dark"> 4 months ago</span></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="media mb-2 border-bottom">
                                                                            <div class="profile-short align-self-center mr-3 rounded-circle">
                                                                                <span>vg</span>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <p class="mb-0 text-capitalize"><strong>build 11 E-learning scenarios</strong></p>
                                                                                <span class="text-capitalize">where do i find the discount code the "build 11 E-learning scenarios"</span>
                                                                            </div>
                                                                            <div class="author">
                                                                                <small class="text-capitalize text-info">virginia <span class="seperator text-dark">||</span><span class="text-dark"> 4 months ago</span></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                                <div class="tab-pane" id="tab-3" role="tabpanel">
                                                    Take Bootstrap 4 to the next level with official premium themes—toolkits built on Bootstrap with new components and plugins, docs, and build tools.
                                                </div>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 row">
								<div class="card card-shadow mb-4 w-100">
									<div class="card-header p-0">
										<div class="card-title">
											<div class="course-content-heading ">
												<blockquote class="blockquote m-0 blockquote-reverse text-uppercase p-2 pl-3 pr-3">
													<small class="mb-0">learning path</small>
												</blockquote>
											</div>
										</div>
									</div>
									<div class="card-body p-0">
										<div id="accordion" class="accordion">
											<div class="card mb-0">
										 
												<div class="card-body ">
												   
													<?php $i=1; ?>
													<?php $j=0; ?>
													<?php foreach($course_title as $title){ ?> 
													
														<div class="form-group border-bottom">
															<?php   
																if(!empty($check_progression)){	
																	$found = array_search($title['title_id'],  array_column($check_progression, 'course_titleid')); 
																	
																	$is_checked = $check_progression[$found]['course_titleid'] == $title['title_id'] ? 'checked'  : '';
																	
																  }else{
																	  $is_checked='';
																  }
															?>
															
															<?php if($is_checked == ''){ ?>
														
															<label class="control control-solid control-solid-primary control--checkbox " id="materiallabel_<?php echo $i; ?>"><?php echo $i;?>. <?php echo $title['title']; ?>
																<input type="checkbox" <?php echo $i == 1 ?'':''; ?> <?php echo $is_checked == '' ? 'disabled': ''; ?> data-checkboxid="<?php echo $i ;?>"  name="checksel" value="<?php echo $title['title_id']; ?>" class="form-check-input check"  id="material<?php echo $i; ?>" data-id="<?php echo $title['title_id']; ?>" data-label="<?php echo $title['title_id']; ?>">
																<span class="control__indicator "></span>
															</label>
															
															
															<?php }else{ ?>	
															 <label class="control control-solid control-solid-primary control--checkbox" id="materiallabel_<?php echo $i; ?>"><?php echo $i;?>. <?php echo $title['title']; ?>
																<input type="checkbox" <?php echo $is_checked; ?> <?php echo $is_checked == '' ? 'disabled': ''; ?> data-checkboxid="<?php echo $i ;?>"  name="checksel" value="<?php echo $title['title_id']; ?>" class="form-check-input check"  id="material<?php echo $i; ?>" data-id="<?php echo $title['title_id']; ?>" data-label="<?php echo $title['title_id']; ?>">
																<span class="control__indicator "></span>
															</label>
															<?php } ?>
															
															
															<?php 
																				
																 $key1 = array_search($title['title_id'], array_column($title_exam, 'title_id'));
															
															?>
															
															<?php if(!empty($title_exam)){ ?>
																<?php if($title_exam[$key1]['title_id'] == $title['title_id']){ ?>
															
																	<form method="post" action="<?php echo base_url();?>course/giveexam">
																		<input type="hidden" name="course_id" value="<?php echo $course_id; ?>" >
																		<input type="hidden" name="categories_id" value="<?php echo $category_id; ?>">
																		<input type="hidden" name="title_id" value="<?php echo $title['title_id']; ?>">
																		
																<?php if(!empty($exam_complete)){ ?>
																	<?php //if(isset($exam_complete[$j])){ ?>
																		<!--<button type="submit" data-exam="<?php // echo $exam_complete[$j]['exam_status']; ?>" title="<?php // echo $exam_complete[$j]['exam_status'] == 0 ? 'Proceed to Exam':'Examination Completed' ?>" style="display:<?php // echo $is_checked == 'checked'? 'block':'none'; ?>" id="view_<?php // echo $title['title_id']; ?>" value="<?php // echo $course_id; ?>" class="btn btn-success view_course">
																			<span class="<?php // echo $exam_complete[$j]['exam_status'] == 0 ? 'fa fa-graduation-cap':'fa fa-certificate' ?>" />
																		</button>-->
																		<?php //echo $j;?>
																	<?php // }else{  ?>
																		<!--<button type="submit" title="Proceed to Exam'" style="display:<?php //echo $is_checked == 'checked'? 'block':'none'; ?>" id="view_<?php //echo $title['title_id']; ?>" value="<?php //echo $course_id; ?>" class="btn btn-success view_course">
																			<span class="fa fa-graduation-cap" />
																		</button>-->
																		<?php //echo $j;?>
																	<?php //}       ?>
																		
																	<?php  $key2 = array_search($title['title_id'], array_column($exam_complete, 'title_id')); ?>	
																	
																	<?php if($title['title_id'] ==  $exam_complete[$key2]['title_id']){ ?>
																		<button type="submit" data-exam="<?php echo $exam_complete[$key2]['exam_status']; ?>" title="<?php echo $exam_complete[$key2]['exam_status'] == 0 ? 'Proceed to Exam':'Examination Completed' ?>" style="display:<?php echo $is_checked == 'checked'? 'block':'none'; ?>" id="view_<?php echo $title['title_id']; ?>" value="<?php echo $course_id; ?>" class="btn btn-success view_course">
																			<span class="<?php echo $exam_complete[$key2]['exam_status'] == 0 ? 'fa fa-graduation-cap':'fa fa-certificate' ?>" />
																		</button>
																	<?php } ?>
																	
																	
																<?php }else{ ?>
																		<button type="submit" title="Proceed to Exam" style="display:<?php echo $is_checked == 'checked'? 'block':'none'; ?>" id="view_<?php echo $title['title_id']; ?>" value="<?php echo $course_id; ?>" class="btn btn-success view_course">
																			<span class="fa fa-graduation-cap" />
																		</button>	
																<?php } ?>
																
																
																	</form>
																	 
																<?php } ?>
																
															<?php } ?>
															
															
															
														</div>
														
														
														
														
														
													<?php  $i++; ?>
													<?php  $j++; ?>
													
													<?php }  ?>	     
												</div>
												
											</div>
										</div>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>