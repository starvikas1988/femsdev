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

.aside-left-menu .menu-link.active  {
  background: #10c469 !important;
  color: #fff !important;
}

.logo-fusion img{
  height: 60px!important;
  margin: 5px;
}
</style>

<aside id="app-aside" class="app-aside left light">
	<header class="aside-header">
		<div class="animated">
			<a href="<?php echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable logo-fusion"><img src="<?php echo base_url() ?>assets/images/fusion-bpo.png" border="0" alt="Fusion BPO"></span>
			</a>
		</div>
	</header><!-- #sidebar-header -->
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
				 
				<li class="menu-item">
					<a href="<?php echo base_url('course') ?>" class="menu-link <?php if(($this->uri->segment(1) == 'course' && $this->uri->segment(2) == '' && $this->uri->segment(3) == '' && $this->uri->segment(4) == '') || ($this->uri->segment(2) == "reporting" && $this->uri->segment(1) == 'course' && $this->uri->segment(3) != '' &&  $this->uri->segment(4) == '') || ($this->uri->segment(2) == "view_subject_list" && $this->uri->segment(1) == 'course' && $this->uri->segment(3) != '' &&  $this->uri->segment(4) == '') || ($this->uri->segment(2) == "assign_users" && $this->uri->segment(1) == 'course' && $this->uri->segment(3) != '' &&  $this->uri->segment(4) == '') ){ echo 'active'; }?>">
						<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
						<span class="">Dashboard</span>
					</a>
				</li>
				
				<?php if($this->uri->segment(2) == 'view_courses' && is_access_level_up() == "true" && $gant_access == true) { //?>
				<li class="menu-item">
					<a href="<?php echo base_url('examination?ctid='. $this->uri->segment(3) .'&cid='. $this->uri->segment(4)) ?>" class="menu-link active">
						<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
						<span class="">Create Examination</span>
					</a>
				</li>
				<?php } ?>
				
				
				<?php if(($this->uri->segment(2) == '')  && (get_role_dir()=="super" || is_access_level_up() == "true" || get_role_dir()=="admin"  || get_role_dir()=="manager" ||  get_user_id() == '6462' || get_user_fusion_id() == 'FKOL002536' ) ) { ?>
				
					
					<!--<li class="menu-item">
						<a href="javascript:void(0);" class="menu-link " data-toggle="modal" data-target="#exampleModal">
							<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
							<span class="">Add Course</span>
						</a>
					</li>-->
				 
					<li class="menu-item">
						<a href="javascript:void(0);" class="menu-link "  data-toggle="modal" data-target="#AssignCordinatorModal">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">Assign Cordinators</span>
						</a>
					</li> 
					
					<li class="menu-item">
						<a href="javascript:void(0);"  width="100px"  class="menu-link " data-toggle="modal" data-target="#uploadCordinatorModal">
							<span class="menu-icon"><i class="fa fa-upload"></i></span>
							<span class="">Upload Cordinator</span>
						</a>
					</li>
							
							
				
				<?php }elseif($this->uri->segment(2) == "view_subject_list" && is_access_level_up() == "true"  && $gant_access == true){ ?>
							<!--<li class="menu-item">
								<a href="javascript:void(0);" class="menu-link " data-toggle="modal" data-target="#exampleModal">
									<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
									<span class="">Add Course</span>
								</a>
							</li>-->
						
							<li class="menu-item">
								<a href="<?php echo base_url();?>course/assign_users/<?php echo $this->uri->segment(3); ?>" class="menu-link " >
									<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
									<span class="">Assign Users</span>
								</a>
							</li>
						
							<li class="menu-item">
								<a href="<?php echo base_url();?>course/direct_access_course" class="menu-link ">
									<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
									<span class="">Assigned Course</span>
								</a>
							</li>
							
							<li class="menu-item">
								<a href="<?php echo base_url();?>course/reporting/<?php echo $this->uri->segment(3); ?>" class="menu-link ">
									<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
									<span class="">Reporting </span>
								</a>
							</li>
				<?php }elseif($this->uri->segment(2) == "assign_users" && is_access_level_up() == "true" && $gant_access == true ){ ?>

							<li class="menu-item">
								<a href="javascript:void(0)" class="menu-link"  data-toggle="modal" data-target="#uploaduserModal">
									<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
									<span class="">Assign Upload Excel </span>
								</a>
							</li>
				
				<?php }elseif($this->uri->segment(2) == "reporting" && is_access_level_up() == "true" && $gant_access == true ){ ?>
							
							<?php foreach($course_list as $course) { $course_id = $course['course_id']; ?>
							<li class="menu-item">
								<a href="<?php echo base_url() . 'course/reporting/' . $categ_id . '/' . $course['course_id']; ?>" class="menu-link <?php if($this->uri->segment(2) == "reporting" && $this->uri->segment(1) == 'course' && $this->uri->segment(3) == $categ_id &&  $this->uri->segment(4) == $course_id ){ echo 'active'; }?>">
									<span class="menu-icon"><i class="fa fa-book"></i></span>
									<span class=""><?php echo $course['course_name']; ?></span>
								</a>
							</li>
							
							
							<?php }  ?>
							
				<?php }elseif(is_access_level_up() == "false" && $gant_access == false){ ?>
						
				
				<?php } ?>
				
			</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->