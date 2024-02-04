  
  
  
<!-- APP ASIDE ==========-->
<style>
.app-aside.light .aside-menu .active{
	color:#188ae2;
}

aside{
	scrollbar-width: thin;
	overflow: auto;
}

.modal-title {
    margin: 0;
    line-height: 1.428571429;
    position: absolute;
}
</style>

<aside id="app-aside" class="app-aside left light">
	<header class="aside-header">
		<div class="animated">
			<a href="<?php echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable"><?=get_logo()?></span>
			</a>
		</div>
	</header><!-- #sidebar-header -->
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
				
				<li class="menu-item">
					<a href="javascript:void(0)" class="menu-link activate">
						<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
						<span class="">Course Title</span>
					</a>
				</li>
				
				<?php $i=0; ?>
			<?php foreach($course_title as $title){ ?> 
			
			
				<li class="menu-item">
					<a href="javascript:void(0)" class="menu-link activate form-check-label"  data-label="<?php echo $title['title_id']; ?>">
						<div class="form-check"> 
						<?php   
							  if(!empty($check_progression)){	
								$found = array_search($title['title_id'],  array_column($check_progression, 'course_titleid')); 
								
								$is_checked = $check_progression[$found]['course_titleid'] == $title['title_id'] ? 'checked'  : '';
								
								
								
							  }else{
								  $is_checked='';
							  }
						?>
						
						<?php if($is_checked == ''){ ?>
							<input  type="checkbox"   <?php echo $i == 0 ?'':'disabled'; ?> data-checkboxid="<?php echo $i ;?>"  name="checksel" value="<?php echo $title['title_id']; ?>" class="form-check-input check"  id="material<?php echo $i; ?>" data-id="<?php echo $title['title_id']; ?>">
							<label class="form-check-label" data-label="<?php echo $title['title_id']; ?>" id="checklabel_<?php echo $title['title_id']; ?>" for="material_<?php echo $title['title_id']; ?>"><?php echo $title['title']; ?></label>
						<?php }else{ ?>	
							<input  type="checkbox"  <?php echo $is_checked; ?>  data-checkboxid="<?php echo $i ;?>"  name="checksel" value="<?php echo $title['title_id']; ?>" class="form-check-input check"  id="material<?php echo $i; ?>" data-id="<?php echo $title['title_id']; ?>">
							<label class="form-check-label" data-label="<?php echo $title['title_id']; ?>" id="checklabel_<?php echo $title['title_id']; ?>" for="material_<?php echo $title['title_id']; ?>"><?php echo $title['title']; ?></label>
						
						<?php } ?>
							<form method="post" action="<?php echo base_url();?>course/giveexam">
								<input type="hidden" name="course_id" value="<?php echo $course_id; ?>" >
								<input type="hidden" name="categories_id" value="<?php echo $category_id; ?>">
								<input type="hidden" name="title_id" value="<?php echo $title['title_id']; ?>">
								<button type="submit" title="Proceed to Exam" style="display:<?php echo $is_checked == 'checked'? 'block':'none'; ?>" id="view_<?php echo $title['title_id']; ?>" value="<?php echo $course_id; ?>" class="btn btn-success view_course">
									<span class="fa fa-graduation-cap" />
								</button>
							</form>
							
						</div>
					</a>
				</li>
			<?php  $i++; ?>
			<?php }  ?>	  
				
			</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside --> 