<!-- APP ASIDE ==========-->
<style>
.app-aside.light .aside-menu .active{
	color:#188ae2;
}

aside{
	scrollbar-width: thin;
	overflow: auto;
}
.rounded-pill{
	border-radius:10px;
	float:right;
}
</style>
<aside id="app-aside" class="app-aside left light">
	<header class="aside-header">
		<div class="animated">
			<a href="<?php echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable">
				<?=get_logo()?>		
				</span>
			</a>
		</div>
	</header><!-- #sidebar-header -->
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
				
		        <li class="menu-item">
				    <a class="menu-link">
						<span class="widget-title">Dynamic Pop-up System</span>
					</a>
					<a href="<?php echo base_url('dynamic_pop_up')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-plus-circle" style="font-size:18px;"></i></span>
						<span class="">Create Pop-up</span>
					</a>
					<a href="<?php echo base_url('dynamic_pop_up/active_list')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-check-circle" style="font-size:18px;"></i></span>
						<span class="">Active Pop-up List <span class="badge rounded-pill bg-primary"><?php echo isset($active_survey_number) ?  $active_survey_number : '' ?></span></span>
					</a>
					<a href="<?php echo base_url('dynamic_pop_up/upcoming_list')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-tint " style="font-size:18px;"></i></span>
						<span class="">Upcoming Pop-up List <span class="badge rounded-pill bg-success"><?php echo isset($upcoming_survey_number) ? $upcoming_survey_number : '' ?></span></span>
					</a>
					<a href="<?php echo base_url('dynamic_pop_up/pending_list')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-hourglass"></i></span>
						<span class="">Pending Pop-up List <span class="badge rounded-pill bg-danger"><?php echo isset($pending_survey_number) ? $pending_survey_number : '' ?></span></span>
					</a>
					<a href="<?php echo base_url('dynamic_pop_up/rejected_list')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-times-circle" style="font-size:18px;"></i></span>
						<span class="">Rejected Pop-up List <span class="badge rounded-pill bg-secondary"><?php echo isset($rejected_survey_number) ? $rejected_survey_number : '' ?></span></span>
					</a>
					<a href="<?php echo base_url('dynamic_pop_up/expired_list')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-hourglass-end" ></i></span>
						<span class="">Expired Pop-up List <span class="badge rounded-pill bg-warning text-dark"><?php echo isset($expired_survey_number) ? $expired_survey_number : '' ?></span></span>
					</a>
					<a href="<?php echo base_url('dynamic_pop_up/deleted_list')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-trash" style="font-size:18px;"></i></span>
						<span class="">Deleted Pop-up List <span class="badge rounded-pill bg-warning text-dark"><?php echo isset($deleted_survey_number) ? $deleted_survey_number : '' ?></span></span>
					</a>
				</li>

			</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->