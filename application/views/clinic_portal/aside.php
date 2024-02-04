<!-- APP ASIDE ==========-->
<style>
.app-aside.light .aside-menu .active{
	color:#188ae2;
}

aside{
	scrollbar-width: thin;
	overflow: auto;
}
</style>
<aside id="app-aside" class="app-aside left light">
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">


				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="">Government Benefits</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">

						<li class="menu-item">
							<a href="<?php echo base_url('clinic_portal/govt_benefits') ?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">SSS/PAG-IBIG/PHILHEALTH</span>
							</a>
						</li>

						<li class="menu-item">
							<a target="_blank" href="<?php echo base_url('clinic_portal/push_file/COVID19_Benefit_application.png') ?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">COVID19 Benefit application</span>
							</a>
						</li>
					</ul>
				</li>


				<?php 
					//if(get_user_fusion_id() != "FMAN000456") {
					 if(get_role_dir() == 'agent' || get_role_dir() == 'tl' || is_access_clinic_portal_distro()){ ?>
					
					<li class="menu-item">
						<a href="<?php echo base_url('clinic_portal/push_file/CORPORATE_HEALTH_AND_LIFE_INSURANCE_FILE.rar') ?>" class="menu-link">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">Corporate Health & Life Insurance</span>
						</a>
					</li>
				<?php } //} ?>

				<?php if(get_user_fusion_id() == "FMAN000456" || is_access_clinic_portal_distro() || get_role_dir() == 'admin' || get_global_access() == 1){ ?>
					<li class="menu-item has-submenu">
						<a href="" class="menu-link submenu-toggle">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">Corporate Health & Life Insurance</span>
							<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
						</a>
						<ul class="submenu">
							
							<?php if(get_user_fusion_id() == "FMAN000456" || is_access_clinic_portal_distro() || get_global_access() == 1){ ?>
				
								<li class="menu-item">
									<a href="<?php echo base_url('clinic_portal/dashboard') ?>" class="menu-link">
										<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
										<span class="">Dashboard</span>
									</a>
								</li>
							<?php } ?>
							
							
							<?php if(get_role_id() == '276'  || get_global_access() == 1 || is_access_clinic_portal()){ ?>
							
								<li class="menu-item">
									<a href="<?php echo base_url('clinic_portal/patient/add') ?>" class="menu-link">
										<span class="menu-icon"><i class="fa fa-stethoscope"></i></span>
										<span class="">New Patient</span>
									</a>
								</li>
							
							<?php } ?>
							
							<?php if(get_user_fusion_id() == "FMAN000456" || get_user_fusion_id() == "FCEB005426" || is_access_clinic_portal_distro() || get_global_access() == 1){ ?>
							
							<?php //if(get_role_id() == '276'  || get_global_access() == 1 || (get_user_office_id()=="CEB" && get_dept_folder()=="hr") || is_access_clinic_portal()){ ?>
								<li class="menu-item">
									<a href="<?php echo base_url('clinic_portal/patient_search') ?>" class="menu-link">
										<span class="menu-icon"><i class="fa fa-search"></i></span>
										<span class="">Patient Search</span>
									</a>
								</li>
							
								<li class="menu-item">
									<a href="<?php echo base_url('clinic_portal/patient_list') ?>" class="menu-link">
										<span class="menu-icon"><i class="fa fa-user-md"></i></span>
										<span class="">Patient List</span>
									</a>
								</li>
							<?php //} ?>
							
							
							<?php //if((get_user_office_id()=="CEB" && get_dept_folder()=="hr") || get_global_access() == 1 || is_access_clinic_portal()){ ?>
								<li class="menu-item">
									<a href="<?php echo base_url('clinic_portal/patient_report') ?>" class="menu-link">
										<span class="menu-icon"><i class="fa fa-heartbeat"></i></span>
										<span class="">Generate Report</span>
									</a>
								</li>
							<?php //} ?>
							
							<?php } ?>
							
							<?php
								//if(get_user_fusion_id() != "FMAN000456") {
								 if(get_role_dir() == 'agent' || get_global_access() || get_user_fusion_id() == 'FCEB000093' || get_user_fusion_id() == 'FMAN000456' || get_user_fusion_id() == 'FCEB006276' || get_user_fusion_id() == 'FCEB005799'){ ?>
								<li class="menu-item">
									<a href="<?php echo base_url('clinic_portal/documents') ?>" class="menu-link">
										<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
										<span class="">Info Documents</span>
									</a>
								</li>
							<?php } //} ?>
							
						</ul>
					</li>
				<?php } ?>


				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="">Downloadable Forms</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>

					<ul class="submenu">

						<li class="menu-item">
							<a href="<?php echo base_url('clinic_portal/push_file/COMPBEN_DOWNLOADABLE_FORMS.rar') ?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">COMPBEN DOWNLOADABLE FORM</span>
							</a>
						</li>

						<li class="menu-item">
							<a target="_blank" href="<?php echo base_url('clinic_portal/push_file/FUSION_CEBU_ACKNOWLEDGEMENT_RECEIPT.pdf') ?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">ACKNOWLEDGEMENT RECEIPT</span>
							</a>
						</li>
					</ul>
				</li>


				<li class="menu-item">
					<a target="_blank" href="<?php echo base_url('clinic_portal/push_file/Other_Employees_Perk.png') ?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="">Other Employee Perks</span>
					</a>
				</li>


				<li class="menu-item">
					<a target="_blank" href="<?php echo base_url('clinic_portal/faq') ?>" class="menu-link download_faq">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="">Frequently Asked Questions</span>
					</a>
				</li>


				<?php if(get_user_fusion_id() == "FMAN000456" || get_user_fusion_id() == "FCEB005426" || is_access_clinic_portal_distro() || get_role_dir() == 'admin' || get_global_access() == 1){ ?>
					<li class="menu-item">
						<a href="<?php echo base_url('clinic_portal/download_report') ?>" class="menu-link">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">File Download Report</span>
						</a>
					</li>
				<?php } ?>
				
				
			</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->