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
				
				<!--
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-envelope"></i></span>
						<span class="menu-text foldable">Email IDS</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
					<?php 
					foreach($asideEmails as $token){
					?>
						<li>
							<a href="<?php echo base_url()?>emat/view_mails/<?php echo bin2hex($token['email_id']); ?>">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="" style="font-size:10px"><?php echo $token['email_name']; ?></span>
							</a>
						</li>
					<?php } ?>
					</ul>						
				</li>
				-->
				
				<?php if(get_role_dir() != "agent" || get_global_access() || e_tl_access() || e_manager_access()){ ?>
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-gear"></i></span>
						<span class="menu-text foldable">Master</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url()?>emat/master_email">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Master Mail Box</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/ticket_category">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Ticket Category</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/master_agents">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Master Agent</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url()?>emat/master_agents_assign">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Agent Skillset</span>
							</a>
						</li>
						<!--
						<li>
							<a href="<?php echo base_url()?>emat/master_agents_secondary">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Secondary Skillset</span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url()?>emat/master_canned_message">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Canned Message</span>
							</a>
						</li>
						-->
						<!--<li>
							<a target="_blank" href="<?php echo base_url()?>emat/cron_update_tickets/656d6174406f6d696e64746563682e636f6d/">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Update Tickets</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/view_tickets">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Tickets List</span>
							</a>
						</li>-->
					</ul>						
				</li>
				
				<?php if(empty($show_mail_menu)){ ?>
				<li class="menu-item open">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-envelope"></i></span>
						<span class="menu-text foldable">Mail Box</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu"  <?php if(!empty($show_mail_menu)){ echo "style='display:block'"; } ?>>
					<?php 
					foreach($asideEmails as $token){
						$page_type = !empty($page_type) ? $page_type : "ticket_list";
					?>
						<li class="category_menu">
							<a href="<?php echo base_url()?>emat/<?php echo $page_type; ?>/<?php echo bin2hex($token['email_id']); ?>">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="" style="font-size:10px"><?php echo $token['email_name']; ?></span>
							</a>
						</li>
					<?php } ?>
					</ul>						
				</li>
				<?php } ?>
				
				<?php  } ?>
				
				<?php 
				if(!empty($show_cateory_menu) && !empty($email_id)){ 
					$page_type = !empty($page_type) ? $page_type : "ticket_list";
				?>
				<li class="menu-item <?php if(!empty($show_cateory_menu)){ echo "open"; } ?>">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-envelope"></i></span>
						<span class="menu-text foldable">Category</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu"  <?php if(!empty($email_id)){ echo "style='display:block'"; } ?>>
						<li>
							<a href="<?php echo base_url()?>emat/<?php echo $page_type; ?>/<?php echo bin2hex($email_id); ?>/all">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="" style="font-size:10px">All</span>
							</a>
						</li>
					<?php 
					foreach($ticketCategory as $token){
						$page_type = !empty($page_type) ? $page_type : "ticket_list";
					?>
						<li>
							<a href="<?php echo base_url()?>emat/<?php echo $page_type; ?>/<?php echo bin2hex($email_id); ?>/<?php echo $token['category_code']; ?>">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="" style="font-size:10px"><?php echo $token['category_name']; ?></span>
							</a>
						</li>
					<?php } ?>
					</ul>						
				</li>
				<?php } ?>
				
				
				<?php if(get_role_dir() != "agent" || get_global_access() || e_tl_access() || e_manager_access() || e_rta_access()){ ?>
			
				
				<li class="menu-item">					
					<a href="<?php echo base_url('emat/ticket_pending/view'); ?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-pie-chart"></i></span>
						<span class="menu-text foldable">Ticket Portal</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm"></i></span>
					</a>						
				</li>
				
				
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-ticket"></i></span>
						<span class="menu-text foldable">Manage Ticket</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url()?>emat/ticket_unassigned/view">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Unassigned <label class="badge badge-danger"><?php echo $ematCounters['unassigned']; ?></label></span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/ticket_pending/view">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Assigned <label class="badge badge-light"><?php echo $ematCounters['pending']; ?></label></span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/ticket_passed/view">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Passed <label class="badge badge-warning"><?php echo $ematCounters['passed']; ?></label></span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/ticket_completed/view">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Completed</span>
							</a>
						</li>
						<!--<li>
							<a target="_blank" href="<?php echo base_url()?>emat/cron_update_tickets/656d6174406f6d696e64746563682e636f6d/">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Update Tickets</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/view_tickets">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Tickets List</span>
							</a>
						</li>-->
					</ul>						
				</li>
				
				<?php } ?>
				
				<!--<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-user"></i></span>
						<span class="menu-text foldable">Manage Ticket</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url()?>emat/ticket_assigned/view">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">My Tickets</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/ticket_assigned_completed/view">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Completed</span>
							</a>
						</li>
					</ul>						
				</li>-->
				
				<?php //if(get_role_dir() == 'agent'){ ?>
				<?php if(!e_rta_access()){ ?>
				<li class="menu-item">					
					<a href="<?php echo base_url('emat/ticket_assigned/view'); ?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-pie-chart"></i></span>
						<span class="menu-text foldable">My Tickets <label class="badge badge-danger"><?php echo $ematCounters['myassigned']; ?></label></span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm"></i></span>
					</a>						
				</li>
				
				<li class="menu-item">					
					<a href="<?php echo base_url('emat/ticket_assigned_completed/view'); ?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-users"></i></span>
						<span class="menu-text foldable">Completed</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm"></i></span>
					</a>						
				</li>
				
				<?php } ?>
				<?php //} ?>
				
				
				<?php if(get_role_dir() != "agent" || get_global_access() || e_tl_access() || e_manager_access() || e_rta_access()){ ?>
				<li class="menu-item">					
					<a href="<?php echo base_url('emat/ticket_finder'); ?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-search"></i></span>
						<span class="menu-text foldable">Search</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm"></i></span>
					</a>						
				</li>		
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-ticket"></i></span>
						<span class="menu-text foldable">Manage Report</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url()?>emat/report_agent">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Agent Overview</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/report_agent_hourly">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Hourly Report</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/report_ticket">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Ticket Report</span>
							</a>
						</li>
					</ul>						
				</li>
				
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="menu-text foldable">Analytics</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url()?>emat/graphical_overview">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">MailBox Overview</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/graphical_overview_tickets">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Ticket Overview</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>emat/graphical_overview_agents">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Agents Overview</span>
							</a>
						</li>
					</ul>						
				</li>
				<?php } ?>						
				
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>