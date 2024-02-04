

<aside id="app-aside" class="app-aside left light">
	<header class="aside-header">
		<div class="animated">
			<a href="<?php echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable"><img style="width:100px;height:70px" src="<?php echo base_url() ?>assets/images/Howard_logo.png" border="0" alt="Fusion BPO"></span>
			</a>
		</div>
	</header><!-- #sidebar-header -->
	
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
						
				<li class="menu-item">
					<a href="<?php echo base_url()?>howard_training/overview" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Dashboard</span>
					</a>
				</li>
				
				<li class="menu-item open">
					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Howard</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					
					<ul class="submenu" style="display:block">
						
						<?php if(get_login_type() != "client" && !is_crm_readonly_access_mindfaq()){ ?>
						<li>
							<a  href="<?php echo base_url()?>howard_training/form">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">New Case</span>
							</a>
						</li>
						<?php } ?>
						
						<li>
							<a  href="<?php echo base_url()?>howard_training/case_search">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Search Case</span>
							</a>
						</li>
						
						<li>
							<a  href="<?php echo base_url()?>howard_training/case_list">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Case List</span>
							</a>
						</li>
						<li>
							<a  href="<?php echo base_url()?>howard_training/manage_school">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Manage School</span>
							</a>
						</li>
						
					</ul>
						
				</li>
				
				
				<?php if(is_access_zovio_report() || get_login_type() == "client"){ ?>
				<li class="menu-item">
					<a href="<?php echo base_url()?>howard_training/case_report" class="menu-link">
						<span class="menu-icon"><i class="fa fa-download"></i></span>
						<span class="">Generate Report</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url()?>howard_training/report" class="menu-link">
						<span class="menu-icon"><i class="fa fa-download"></i></span>
						<span class="">Health Dept Report</span>
					</a>
				</li>
				<?php } ?>
										
				
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>