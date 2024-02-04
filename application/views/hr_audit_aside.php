<!-- APP ASIDE ==========-->

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
				<a href="<?php echo base_url()?>survey/hr_audit" class="menu-link">
					<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
					<span class="">HR Audit</span>
				</a>
			</li>
			
			<?php if(((get_dept_folder() == 'hr' || get_role_id() == '116') && get_user_office_id()=="CEB") || get_global_access()){ ?> 
			
			<!--<li class="menu-item">
				<a href="<?php echo base_url()?>survey/hr_audit_reports" class="menu-link">
					<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
					<span class="">Survey Report</span>
				</a>
			</li> -->
			
			<!-- <li class="menu-item">
				<a href="<?php echo base_url()?>survey/facilities_department_analytics" class="menu-link">
					<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
					<span class="">Survey Analytics</span>
				</a>
			</li> -->
			
			<?php } ?>
			
			</ul>
		</div>
	</div>
</aside>