
<style>
	aside{
		scrollbar-width: thin;
		overflow: auto;
	}
</style>

<!-- APP ASIDE ==========-->
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

				<?php if (is_access_announcment() == 1) { ?>

					<li class="menu-item">
						<a href="<?php echo base_url()?>master/fems_announcement" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-cast-connected zmdi-hc-lg"></i></span>
							<span class="">Announcement</span>
						</a>
					</li>

				<?php }
					if(is_access_master_entry() == true){ 
				?>
								
					<li class="menu-item has-submenu">
						<a href="" class="menu-link submenu-toggle">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="menu-text foldable">Master Entry</span>
							<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
						</a>
						<ul class="submenu">
							
							<li>
								<a href="<?php echo base_url()?>master/role">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Designation</span>
								</a>
							</li>
							
							
							<li>
								<a  href="<?php echo base_url()?>master/client">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Client</span>
								</a>
							</li>
							
							
							<li>
								<a href="<?php echo base_url()?>master/process">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Process</span>
								</a>
							</li>
							
							
							<!--<li>
								<a href="<?php //echo base_url()?>master/disposition">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Disposition</span>
								</a>
							</li>-->
							
							
							
							<li>
								<a href="<?php echo base_url()?>master/office">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Office Location</span>
								</a>
							</li>
							
							
							<li>
								<a href="<?php echo base_url()?>master/department">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Department</span>
								</a>
							</li>
						
							
							<li>
								<a href="<?php echo base_url()?>master/sub_department">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sub Department</span>
								</a>
							</li>
							
							<li>
								<a href="<?php echo base_url()?>master/site">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Site</span>
								</a>
							</li>

							<li>
								<a href="<?php echo base_url()?>master/clientInfo">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Client Info</span>
								</a>
							</li>
							
							<!--<li>
								<a href="<?php //echo base_url()?>master/subprocess">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sub Process</span>
								</a>
							</li>-->
						</ul>
					</li>

					
					<li class="menu-item">
						<a href="<?php echo base_url()?>dynamic_pop_up" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-cast-connected zmdi-hc-lg"></i></span>
							<span class="">Dynamic Popup</span>
						</a>
					</li>
					
					<li class="menu-item has-submenu">
						<a href="" class="menu-link submenu-toggle">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="menu-text foldable">Dynamic Survey</span>
							<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
						</a>
						<ul class="submenu">
							
							<li>
								<a href="<?php echo base_url()?>dynamic_survey/create_survey">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Create Survey</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url()?>dynamic_survey/survey_category">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Add Category</span>
								</a>
							</li>						
							<li>
								<a  href="<?php echo base_url()?>dynamic_survey/survey_list">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Survey List</span>
								</a>
							</li>						
							<li>
								<a href="<?php echo base_url()?>dynamic_survey/survey_report">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Reports</span>
								</a>
							</li>
							
												
						</ul>
					</li>
					
					<li class="menu-item">
						<a href="<?php echo base_url()?>ipl_admin" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-cast-connected zmdi-hc-lg"></i></span>
							<span class="">IPL Admin </span>
						</a>
					</li>
					
					<li class="menu-item">
						<a href="<?php echo base_url()?>weekly_activities/contest" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-cast-connected zmdi-hc-lg"></i></span>
							<span class="">Activities Admin </span>
						</a>
					</li>
					
					
					
					
					<li class="menu-item">
						<a href="<?php echo base_url()?>master/fems_announcement" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-cast-connected zmdi-hc-lg"></i></span>
							<span class="">Announcement</span>
						</a>
					</li>
					
					<li class="menu-item">
						<a href="<?php echo base_url()?>master/organization_news" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment zmdi-hc-lg"></i></span>
							<span class="">Organisation News</span>
						</a>
					</li>
					
					
					
					<li class="menu-item has-submenu">
						<a href="" class="menu-link submenu-toggle">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="menu-text foldable">Email Notification</span>
							<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
						</a>
						<ul class="submenu">
						<!--
							<li>
								
								<a  href="<?php echo base_url()?>emailinfo/add">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Add</span>
								</a>
							
							</li>
							-->
							<li>
								<a href="<?php echo base_url()?>emailinfo">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Manage</span>
								</a>
								
							</li>
						</ul>
					</li>
					
					
					<li class="menu-item has-submenu">
						<a href="" class="menu-link submenu-toggle">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="menu-text foldable">Service Request</span>
							<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
						</a>
						<ul class="submenu">
							
							<li>
								<a href="<?php echo base_url()?>master/sr_category">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Category</span>
								</a>
							</li>
							
							<li>
								<a href="<?php echo base_url()?>master/sr_subcategory">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sub-Category</span>
								</a>
							</li>
							
							<!--<li>
								<a href="<?php //echo base_url()?>master/sr_categoryPreAssign">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Category Pre-Assign</span>
								</a>
							</li>-->
							
							<!--<li>
								<a href="<?php //echo base_url()?>master/sr_subCategoryPreAssign">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sub-Category Pre-Assign</span>
								</a>
							</li>-->
							
							<li>
								<a href="<?php echo base_url()?>master/sr_Priority">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Priority</span>
								</a>
							</li>
							
							<li>
								<a href="<?php echo base_url()?>master/sr_Status">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Status</span>
								</a>
							</li>
							
						</ul>
					</li>
					
					
					<li class="menu-item">
						<a href="<?php echo base_url();?>master/assign_performance_matrics" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-cast-connected zmdi-hc-lg"></i></span>
							<span class="">Performance Metric User Assign</span>
						</a>
					</li>
					
					
					<li class="menu-item has-submenu">
						<a href="" class="menu-link submenu-toggle">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="menu-text foldable">Fems Certification</span>
							<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
						</a>
						<ul class="submenu">
						
							<li>
								<a  href="<?php echo base_url(); ?>master/certification_questions_answers">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Certification Questions & Answers</span>
								</a>
							</li>
							
							<li>
								<a  href="<?php echo base_url(); ?>master/open_fusion_certification">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Open Fusion Certification</span>
								</a>
							</li>
							
						</ul>
					</li>
					
					<li class="menu-item">
						<a href="<?php echo base_url();?>master/manage_policy_access" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-cast-connected zmdi-hc-lg"></i></span>
							<span class="">Policy Manage Access</span>
						</a>
					</li>
					
					<li class="menu-item">
						<a href="<?php echo base_url();?>master/manage_processupdate_access" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-cast-connected zmdi-hc-lg"></i></span>
							<span class="">Process Update Manage Access</span>
						</a>
					</li>
					
					<li class="menu-item has-submenu">
						<a href="" class="menu-link submenu-toggle">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="menu-text foldable">Leave Management</span>
							<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
						</a>
						<ul class="submenu">
							<li>
								<a  href="<?php echo base_url(); ?>master/view_leave_types">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Leave Types</span>
								</a>
							</li>					
							<li>
								<a  href="<?php echo base_url(); ?>master/leave_index">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Leave Criterias</span>
								</a>
							</li>
							<li>
								<a  href="<?php echo base_url(); ?>master/leave_user_management">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">User Assignment</span>
								</a>
							</li>
							<!--
							<li>
								<a  href="<?php //echo base_url(); ?>master/leave_access_location">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Location Access</span>
								</a>
							</li>
							-->
						</ul>
					</li>	

				<?php } ?>	
				
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->
