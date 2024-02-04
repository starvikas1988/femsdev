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
				<?php 
				$brand = get_brand();
				$logo =show_brand_logo($brand);
				?>
				<span id="brand-name" class="brand-icon foldable"><img src="<?php echo base_url() ?><?php echo $logo ?>" border="0" alt="Fusion BPO"></span>
			</a>
		</div>
	</header><!-- #sidebar-header -->
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
				
		        <li class="menu-item">
				    <a class="menu-link">
						<span class="widget-title">Dynamic Survey</span>
					</a>
					<a href="<?php echo base_url('dynamic_survey/create_survey')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-plus-circle" style="font-size:18px;"></i></span>
						<span class="">Create Survey</span>
					</a>
					<a href="<?php echo base_url('dynamic_survey/survey_category')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-plus" style="font-size:18px;"></i></span>
						<span class="">Add Category <span class="badge rounded-pill bg-primary"><?php echo isset($active_survey_number) ?  $active_survey_number : '' ?></span></span>
					</a>
					<a href="<?php echo base_url('dynamic_survey/survey_list')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-list-alt" style="font-size:18px;"></i></span>
						<span class="">Survey List <span class="badge rounded-pill bg-success"><?php echo isset($upcoming_survey_number) ? $upcoming_survey_number : '' ?></span></span>
					</a>
					<a href="<?php echo base_url('dynamic_survey/survey_report')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-download"></i></span>
						<span class="">Survey Reports <span class="badge rounded-pill bg-danger"><?php echo isset($pending_survey_number) ? $pending_survey_number : '' ?></span></span>
					</a>
					<?php  if(get_user_office_id() == "JAM" || get_global_access() == '1') { ?>
					<a href="<?php echo base_url('dynamic_survey/survey_report_jam')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-download"></i></span>
						<span class="">Custom Survey Report<span class="badge rounded-pill bg-danger"><?php echo isset($pending_survey_number) ? $pending_survey_number : '' ?></span></span>
					</a>
					<?php } ?>					
					<!-- <a href="<?php echo base_url('dynamic_survey/my_survey')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-download"></i></span>
						<span class="">Take Survey <span class="badge rounded-pill bg-danger"><?php echo isset($pending_survey_number) ? $pending_survey_number : '' ?></span></span>
					</a> -->
				</li>

			</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->