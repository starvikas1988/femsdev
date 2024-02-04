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
				<span id="brand-name" class="brand-icon foldable"><img src="<?php echo base_url() ?>assets/images/fusion-bpo.png" border="0" alt="Fusion BPO"></span>
			</a>
		</div>
	</header><!-- #sidebar-header -->
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
				
				<li class="menu-item">
					<a href="<?php echo base_url('') ?>" class="menu-link activate">
						<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
						<span class="">Dashboard</span>
					</a>
				</li>
				
				<?php if( get_role_dir()=="super") { ?>
					<?php if($this->uri->segment(2) == ''){?>
					<li class="menu-item">
						<a href="javascript:void(0);" class="menu-link " data-toggle="modal" data-target="#exampleModal">
							<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
							<span class="">Add Course</span>
						</a>
					</li>
				 
					<li class="menu-item">
						<a href="javascript:void(0);" class="menu-link "  data-toggle="modal" data-target="#AssignCordinatorModal">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">Assign Cordinators</span>
						</a>
					</li> 
				
					<?php }elseif($this->uri->segment(2) == "view_subject_list"){ ?>
					 
							<li class="menu-item">
								<a href="javascript:void(0);" class="menu-link " data-toggle="modal" data-target="#exampleModal">
									<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
									<span class="">Add Course</span>
								</a>
							</li>
						
							
							<li class="menu-item">
								<a href="<?php echo base_url();?>course/assign_users/<?php echo $this->uri->segment(3); ?>" class="menu-link " >
									<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
									<span class="">Assign Users</span>
								</a>
							</li>
							
							<li class="menu-item">
								<a href="javascript:void(0);" class="menu-link "  data-toggle="modal" data-target="#set_rule">
									<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
									<span class="">Set Rules</span>
								</a>
							</li>
					 
					 <?php } ?>
				<?php }elseif(get_role_dir() == 'manager' || get_role_dir() == 'tl' || get_role_dir() == 'trainer'){ ?>
				
				     <?php if($this->uri->segment(2) == "view_subject_list"){ ?>
					 
							<li class="menu-item">
								<a href="javascript:void(0);" class="menu-link " data-toggle="modal" data-target="#exampleModal">
									<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
									<span class="">Add Course</span>
								</a>
							</li>
						
							
							<li class="menu-item">
								<a href="javascript:void(0);" class="menu-link "  data-toggle="modal" data-target="#AssignCordinatorModal">
									<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
									<span class="">Assign Users</span>
								</a>
							</li> 
					 
					 <?php } ?>
				
				<?php } ?>
				
			</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->