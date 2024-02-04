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
					<a href="<?php echo base_url()?>leave" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Leave Dashboard</span>
					</a>
				</li>
				<? 
				
				///echo "get_role_dir :: ". get_role_dir();
				
				if (get_role_dir()!="agent" || is_access_all_leave_approve() || specific_location_leave_approve()){ ?>
				
				<?php if(get_user_office_id() == 'JAM'){?>
				
						<?php if(leave_approvers_location_specify("JAM", FALSE, ['FJAM004129','FCEB000001','FJAM004503'])){ ?>
							<li class="menu-item">
								<a href="<?php echo base_url()?>leave/leave_approval" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
									<span class="">My Team Leaves</span>
								</a>
							</li>
							<li class="menu-item">
								<?php  ?>
								<a  href="<?php echo base_url(); ?>leave/team_leave_balance" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Team Leave Balance</span>
								</a>
							</li>
							<li class="menu-item">
								<a  href="<?php echo base_url(); ?>leave/leave_balance" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">All Leave Balance</span>
								</a>
							</li>

						<?php } ?>	
					
				<?php }else{ ?>

					<li class="menu-item">
						<a href="<?php echo base_url()?>leave/leave_approval" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">My Team Leaves</span>
						</a>
					</li>
					<li class="menu-item">
						<?php  ?>
						<a  href="<?php echo base_url(); ?>leave/team_leave_balance" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Team Leave Balance</span>
						</a>
					</li>
				<? }
				
				} ?>
				
				<? if (is_access_leave_manage()==true){ ?>
					<li class="menu-item">
						<a  href="<?php echo base_url(); ?>leave/leave_balance" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">All Leave Balance</span>
						</a>
					</li>					
				
					<li class="menu-item">
						<a  href="<?php echo base_url(); ?>leave/leave_access_location" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Location Access</span>
						</a>
					</li>	
					<? } ?>
					
					<? if (is_access_leave_report()==true){ ?>
					<li class="menu-item">
						<a  href="<?php echo base_url(); ?>leave/reports" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Reports</span>
						</a>
					</li>		
					<? } ?>
				
				
			</ul>
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->