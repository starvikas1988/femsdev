<?php //echo get_role();
//exit;
?>

<aside id="app-aside" class="app-aside left light">
	<header class="aside-header">
		<div class="animated">
			<a href="<?php echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable"><img style="width:150px;margin: -10px 0 0 0;object-fit: contain;" src="<?php echo base_url() ?>assets/images/diy_logo.jpg" class="diy-logo" border="0" alt="DIY LOGO"></span>
			</a>
		</div>
	</header><!-- #sidebar-header -->
	
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
						
				<li class="menu-item">
					<a href="<?php echo base_url('diy')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Dashboard</span>
					</a>
				</li>
				
				<?php if(get_role() != 'teacher' && get_role() != 'Teacher'){ ?>
				
				<li class="menu-item">
					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Admin</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					
					<ul class="submenu">
						
						<?php if(get_login_type() != "client" ){ ?>
						<li>
							<a  href="<?php echo base_url()?>diy/form">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Demo Class</span>
							</a>
						</li>
						
						<?php } ?>
						
						<?php if(get_login_type() == "client" && (get_role() != 'teacher' && get_role() != 'Teacher')){ ?>						
						<li>
							<a  href="<?php echo base_url()?>diy/course_master">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Categories</span>
							</a>
						</li>	
						<li>
							<a  href="<?php echo base_url()?>diy/role_master">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Role</span>
							</a>
						</li>
						<li>
							<a  href="<?php echo base_url()?>diy/currency_master">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Payout Currencies</span>
							</a>
						</li>					
						<!-- <li>
							<a  href="<?php echo base_url()?>diy/level_master">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Levels</span>
							</a>
						</li> -->						
						<?php } ?>
						
					</ul>	
				</li>
				
				<?php } ?>
						
				<?php if(get_login_type() == "client"){ ?>
				<li class="menu-item">
					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Availability</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					
					<ul class="submenu">
					
					<?php if(get_login_type() == "client" && (get_role() == 'teacher' && get_role() != 'Teacher')){ ?>
						<!--<li>
							<a href="<?php echo base_url()?>diy/set_availability">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Set Availability</span>
							</a>
						</li>-->
					<?php } ?>
					<?php if(get_login_type() == "client" && (get_role() != 'teacher' && get_role() != 'Teacher')){ ?>
						<!--<li>
							<a  href="<?php echo base_url()?>diy/add_availability_admin">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Add Availability</span>
							</a>
						</li>-->
						<li>
							<a  href="<?php echo base_url()?>diy/upload_availability">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Upload  </span>
							</a>
						</li>
					<?php } ?>
					
						<li>
							<a  href="<?php echo base_url()?>diy_calendar/calendar_availability">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Edit</span>
							</a>
						</li>
						<!--<li>
							<a  href="<?php echo base_url()?>diy_calendar/calendar_availability_approval">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Availability Approval List</span>
							</a>
						</li>-->
						<?php if(get_login_type() == "client" && (get_role() != 'teacher' && get_role() != 'Teacher')){ ?>
						<li>
							<!--diy/availability_calendar-->
							<a  href="<?php echo base_url()?>diy_calendar/calendar_teacher_availability">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">View</span>
							</a>
						</li>
						<?php } ?>
						<li>
							<a href="<?php echo base_url()?>diy/my_availability">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">List</span>
							</a>
						</li>						
						<?php if((get_login_type() == "client" && (get_role() != 'teacher' && get_role() != 'Teacher')) || get_global_access()){ ?>
						<!--<li>
							<a  href="<?php echo base_url()?>diy_calendar/calendar_view_course">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Categories</span>
							</a>
						</li>-->
						
						<?php } ?>
						<!-- <li>
							<a  href="<?php echo base_url()?>diy/leave">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Leave</span>
							</a>
						</li>
						<li>
							<a  href="<?php echo base_url()?>diy/partical_leave_form">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Partial Leave</span>
							</a>
						</li>
						<li>
							<a  href="<?php echo base_url()?>diy/partial_leave_apply_list">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Partial Leave</span>
							</a>
						</li> -->
						<?php if(get_login_type() == "client" && get_role() != 'teacher'){ ?>
						<!--<li>
							<a  href="<?php echo base_url()?>diy/modify_availability_set">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Update Availability</span>
							</a>
						</li>-->
						<?php } ?>
					</ul>
					
				</li>
				<?php } ?>
				
				
				<li class="menu-item">
					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Schedule</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					
					<ul class="submenu">
						
						<?php if((get_login_type() == "client" &&( get_role() != 'teacher' && get_role() != 'Teacher')) || get_global_access()){ ?>
							<li>
								<a href="<?php echo base_url()?>diy/upload_schedule">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Upload</span>
								</a>
							</li>
						<?php } ?>
						<li>
							<a href="<?php echo base_url()?>diy/schedule_list">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">List</span>
							</a>
						</li>
						<li>
							<!--<a href="<?php echo base_url()?>diy/delete_list">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Delete</span>
							</a>-->
						</li>
						
					</ul>
					
				</li>
				
				<!--<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Schedule</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					
					<ul class="submenu">
					
					
					</ul>
				</li>-->
				
					
					
					
				
				<?php if((get_login_type() == "client" && (get_role() != 'teacher' && get_role() != 'Teacher')) || get_global_access()){ ?>

				<li class="menu-item">
					
					<!--<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-download"></i></span>
						<span class="menu-text foldable">Reports</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>-->
					
					<ul class="submenu">
						
						<!--<li>
							<a  href="<?php echo base_url()?>diy/teacher_hourly_report">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Daywise Availability </span>
							</a>
						</li>-->
						
						<!--<li>
							<a  href="<?php echo base_url()?>diy/teacher_overview_report">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Teachers Utilisation</span>
							</a>
						</li>
						
						<li>
							<a  href="<?php echo base_url()?>diy/teacher_leave_report">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Leave Report</span>
							</a>
						</li>
						
						<li>
							<a  href="<?php echo base_url()?>diy/demo_class_report">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Demo Class Report</span>
							</a>
						</li>-->
						
					</ul>
						
				</li>

				<?php } ?>
										
				
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>