<style>
.course:hover{
	-webkit-box-shadow: -1px 4px 20px 0px rgba(130,90,129,1);
	-moz-box-shadow: -1px 4px 20px 0px rgba(130,90,129,1);
	box-shadow: -1px 4px 20px 0px rgba(130,90,129,1);
	
	cursor:pointer;
}

.courses {
   /* background: #f8f8f8; */
    padding-top: 19px;
}


.center-position {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
	margin-top:10px;
}


p
{
	font-family: 'Poppins', sans-serif;
	font-size: 13px;
	line-height: 1.71;
	font-weight: 400;
	color: rgba(0,0,0,0.5);
	-webkit-font-smoothing: antialiased;
	-webkit-text-shadow: rgba(0,0,0,.01) 0 0 1px;
	text-shadow: rgba(0,0,0,.01) 0 0 1px;
}



a {

}
a:visited {

}
a.morelink {
	text-decoration:none;
	outline: none;
}
.morecontent span {
	display: none;
}
.comment {
	margin: 0px;
}


</style>

 <div class="courses"> 
	<div class="row courses_row">
			
				<!-- Course -->
		<?php if(!empty($course_details)){             ?>
			<?php foreach($course_details as $course) :?> 
				<div class="col-lg-3 course_col">
					<div class="course"> 
						<div class="course_image"><img src="<?php echo base_url();?>libs/course_asset_2/images/course_4.jpg" class="rounded mb-0" alt=""></div>
						 
							<a class="course_mark course_free trans_200" href="<?php echo base_url();?>course/view_courses/<?php echo $course['categories_id']; ?>/<?php echo $course['course_id']; ?>"  title="<?php echo  $gant_access == true ? "Click here to view Upload ".$course['course_name'] : "Click here to View ".$course['course_name']; ?>">
							<span class="fa fa-arrow-right"></span></a>
				 
						<div class="course_body">
							<div class="course_title"><a href="javascript:void(0);" title="<?php echo $course['course_name']; ?>"><?php echo substr($course['course_name'],0,13); ?></a>
													  &nbsp;&nbsp;<i style="color:red" class="fa fa-warning" title="This course is created only for training and development of Fusion employees. This course is not for distribution and sale of the material is prohibited."></i> 
							</div>
							<div class="course_info">
								<ul>
									<li><a href="javascript:void(0);"><?php echo $course['creator']; ?></a></li>
									<li><a href="#">English</a></li> 
								</ul>
							</div>
							<div class="course_text">
								
								<p  class="comment more"><?php echo $course['course_desc']; ?></p>
							</div>
						</div>
						<div class="course_footer d-flex flex-row align-items-center justify-content-start">
							<div class="course_students"><button type="button" id="view_<?php echo $course['course_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn  view_course"><span class="<?php echo $course['is_view'] == 0 ? 'fa fa-eye-slash' : 'fa fa-eye'?>" /></button></div>
							<?php if($course['is_view'] == 0){  ?>
								<div class="course_rating ml-auto"><button disabled type="submit" title="Pending Reading" id="" value="" class="btn  view_course"><span class="<?php echo $course['is_complete'] == 0 ? 'fa fa-clock-o' : 'fa fa-check'?>" /></button></div>
							<?php }else{  ?>
								<div class="course_rating ml-auto"><form method="post" action="<?php echo base_url();?>course/mark_complete/<?php echo $course['categories_id']; ?>/<?php echo $course['course_id']; ?>"><button <?php echo $course['is_complete'] == 0 ? '' : 'disabled'?>  type="submit" title="<?php echo $course['is_complete'] == 0 ? 'Mark Complete' : 'Completed'?>" id="view_<?php echo $course['id']; ?>" value="<?php echo $course['id']; ?>" class="btn view_course"><span class="<?php echo $course['is_complete'] == 0 ? 'fa fa-clock-o' : 'fa fa-check'?>" /></button></form></div>
								<?php if($course['is_complete'] == 1){?>
								<div class="course_rating ml-auto">
								
									<input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>" ><input type="hidden" name="categories_id" value="<?php echo $course['categories_id']; ?>"> <button type="submit" title="Proceed to Exam" id="view_<?php echo $course['id']; ?>" value="<?php echo $course['id']; ?>" class="btn view_course"><span class="fa fa-graduation-cap" /></button>
									
								</div>
								<?php }   ?>
							<?php }   ?>	
							  
						</div>
						
					</div>
				</div>
			<?php endforeach; ?>
		<?php }else{ ?>		
					
					<div class="col-lg-12">
						 <div class="center-position">
							<img src="<?php echo base_url();?>libs/course_asset_2/images/no_course.jpg" class="rounded mb-0" title="No Course Assigned." alt="No Course Assigned.">
						 </div>
					</div>
		<?php } ?>	
			</div>

		<!--<div class="row">
				<div class="col">
					<div class="load_more_button"><a href="#">load more</a></div>
				</div>
			</div>--> 
	</div>