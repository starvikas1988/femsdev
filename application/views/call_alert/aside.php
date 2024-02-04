<style>
a {
    text-decoration: none!important;
}
.aside-left-menu .submenu > li.category_menu > a{
	padding: 5px 5px 10px 30px!important;
}
.tabs-widget .nav-link {
	padding:10px 5px!important;
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
				<?php if(get_role_dir() != "agent" || get_global_access() || admin_access() || call_l2_access()){ ?>
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">Master</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url()?>call_alert/master_type">
								<span class="menu-icon"><i class="fa fa-linode"></i></span>
								<span class="">Type</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>call_alert/master_location">
								<span class="menu-icon"><i class="fa fa-podcast"></i></span>
								<span class="">Location</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>call_alert/location_access">
								<span class="menu-icon"><i class="fa fa-key"></i></span>
								<span class="">Location Access</span>
							</a>
						</li>
					</ul>
				</li>
				<?php } ?>				
				<li>					
					<a href="<?php echo base_url();?>call_alert/" class="menu-link">
						<span class="menu-icon"><i class="fa fa-calendar"></i></span>
						<span class="menu-text foldable">Set Date</span>
					</a>										
				</li>
				<!--<li>					
					<a href="<?php echo base_url();?>Call_alert/set_notification" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">Set Notification</span>
					</a>										
				</li>
				<li>					
					<a href="<?php echo base_url();?>Call_alert/send_notification" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">Send Notification</span>
					</a>										
				</li>-->
				<li>					
					<a href="<?php echo base_url();?>call_alert/call_alert_list" class="menu-link">
						<span class="menu-icon"><i class="fa fa-navicon"></i></span>
						<span class="menu-text foldable">List</span>
					</a>										
				</li>
				<?php if(get_role_dir() != "agent" || get_global_access() || admin_access() || call_l2_access()){ ?>	
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-envelope"></i></span>
						<span class="menu-text foldable">Report</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url()?>call_alert/call_alert_report">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Call Alert Report</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>call_alert/report_breach">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Breach</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>call_alert/report_total">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Overall Report</span>
							</a>
						</li>
					</ul>
				</li>
				<li>					
					<a href="<?php echo base_url();?>call_alert/log_list" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">Log</span>
					</a>										
				</li>
				<li>					
					<a href="<?php echo base_url();?>call_alert/call_alert_bulk_upload" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">Bulk Upload</span>
					</a>										
				</li>
				<?php } ?>							
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>