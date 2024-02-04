<style>
a {
    text-decoration: none!important;
}
.aside-left-menu .submenu > li.category_menu > a{
	padding: 5px 5px 10px 30px!important;
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
	<br/>
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
				
				<?php if(get_role_dir() != "agent"){ ?>
				
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-gear"></i></span>
						<span class="menu-text foldable">Master</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo duns_url('master_client'); ?>">
								<span class="menu-icon"><i class="fa fa-users"></i></span>
								<span class="" style="font-size:12px">Client</span>
							</a>
						</li>
						<li>
							<a href="<?php echo duns_url('master_agent_columns'); ?>">
								<span class="menu-icon"><i class="fa fa-wrench"></i></span>
								<span class="" style="font-size:12px">Agent Inputs</span>
							</a>
						</li>
					</ul>						
				</li>
				
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-database"></i></span>
						<span class="menu-text foldable">Data</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo duns_url('new_data'); ?>">
								<span class="menu-icon"><i class="fa fa-folder"></i></span>
								<span class="" style="font-size:10px">New Data</span>
							</a>
						</li>
						<li>
							<a href="<?php echo duns_url('new_data_list'); ?>">
								<span class="menu-icon"><i class="fa fa-download"></i></span>
								<span class="" style="font-size:10px">Upload List</span>
							</a>
						</li>
					</ul>						
				</li>
				
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-suitcase"></i></span>
						<span class="menu-text foldable">Agents</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo duns_url('assign_data_list'); ?>">
								<span class="menu-icon"><i class="fa fa-slideshare"></i></span>
								<span class="" style="font-size:10px">Assign Data</span>
							</a>
						</li>
						<li>
							<a href="<?php echo duns_url('data_list'); ?>">
								<span class="menu-icon"><i class="fa fa-fax"></i></span>
								<span class="" style="font-size:10px">Data List</span>
							</a>
						</li>
					</ul>						
				</li>
				
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="menu-text foldable">Reports</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo duns_url('report_upload'); ?>">
								<span class="menu-icon"><i class="fa fa-file-excel-o"></i></span>
								<span class="" style="font-size:10px">Data Report</span>
							</a>
						</li>
					</ul>						
				</li>
				
				<?php } ?>
				
				<li class="menu-item">
					<a href="<?php echo duns_url('my_assign_list'); ?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-clock-o"></i></span>
						<span class="">My Assigned List</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo duns_url('my_completed_list'); ?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-check-square-o"></i></span>
						<span class="">My Completed List</span>
					</a>
				</li>

				<li class="menu-item">
					<a href="<?php echo duns_url('quality_console'); ?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-check-square-o"></i></span>
						<span class="">Quality Control</span>
					</a>
				</li>
								
				
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>