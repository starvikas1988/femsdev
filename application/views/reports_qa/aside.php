<!--start css for the search filter-->
<style>
	.brand-icon img {
		margin:-25px 0 0 0;
	}
	.search-widget {
		padding:0 10px;
	}
	.form-control-feedback {
		top: 3px;
		right: 5px;
	}
	/*start left side menu css here*/
	.aside-left-menu .menu-link {
		border-bottom: 1px solid #eee;
		transition:all 0.5s ease-in-out 0s;
	}
	.aside-left-menu .menu-link:hover {
		background:#10c469!important;
		color:#fff!important;
	}
	.aside-left-menu .menu-link:focus {
		background:#10c469!important;
		color:#fff!important;
		outline:none;
		box-shadow:none;
	}
	.aside-left-menu .menu-icon {
		margin:0 5px 0 0;
	}
	.left-active a {
		background:#10c469;
		color:#fff!important;
		font-weight:bold!important;
	}
/*end left side menu css here*/
</style>
<!--end css for the search filter-->

<!-- APP ASIDE ==========-->
<aside id="app-aside" class="app-aside left light">
	<!--<header class="aside-header">
		<div class="animated">
			<a href="<?php echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable"><?=get_logo()?></span>
			</a>
		</div>
	</header>--><!-- #sidebar-header -->
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">

			<ul class="aside-menu aside-left-menu">
				<div class="search-widget">
					<div class="form-group has-feedback has-search">
						<i class="fa fa-search form-control-feedback" aria-hidden="true"></i>
						<input type="text" id="myInput" class="form-control" autocomplete="off" placeholder="Search..">
					</div>
				</div>
				<?php
					if(get_login_type() == "client"){

						$qa_report_menu=get_client_qa_report_menu();
						foreach( $qa_report_menu as $menu){
							echo '<li class="menu-item">';
							echo '<a href="'. base_url($menu['qa_report_url']). '" class="menu-link">';
							echo '<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>';
							echo '<span class="">'.$menu['shname'].'</span>';
							echo '</a>';
							echo '</li>';
						}
				?>

				<!-- <li class="menu-item">
					<a href="<?php echo base_url('reports_qa/qa_agent_coaching_report')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
						<span class=""> Agent Coaching</span>
					</a>
				</li> -->
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_agent_coaching_new/qa_agent_coaching_report')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
						<span class=""> GRBM Agent Coaching</span>
					</a>
				</li>

				<?php
					}else{
				?>


					<?php if(get_dept_folder()=="qa" || get_global_access()==1 || get_dept_folder()=="mis" || get_dept_folder()== "operations" || get_dept_folder()== "training" || get_dept_folder()=="cs" || is_access_qa_module()==true){ ?>


							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/dipcheck" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Dip Check Report</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_belmont/qa_belmont_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Belmont</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_healthmitra/qa_healthmitra_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Healthmitra</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_apphelp/qa_apphelp_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AppHelp</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_argel/qa_argel_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">ARGEL</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_ossur/qa_ossur_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Ossur</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_appdirect/qa_appdirect_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AppDirect</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_oyo_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">OYO</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qaod_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Office Depot</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_meesho_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">MEESHO</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_verso_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">VERSO</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_puppyspot_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">PuppySpot</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_vrs_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">VRS</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_rugdoctor_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">RugDoctor</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_checkpoint_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">QA Checkpoint</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_welcome_pickup_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Welcome Pickups</span>
								</a>
							</li>
							<li class="menu-item has-submenu">
								<a href="" class="menu-link submenu-toggle">
									<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
									<span class="menu-text foldable">CarParts</span>
									<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
								</a>
								<ul class="submenu">

									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_process_report/service" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Service</span>
										</a>
									</li>

									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_process_report/sales_carpart" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Sales</span>
										</a>
									</li>

									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_sales_carpart_inbound_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">inbound</span>
										</a>
									</li>
									<!-- <li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_sales_carpart_inbound2_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">inbound Version 2</span>
										</a>
									</li> -->
								</ul>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_rpm_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">RPM</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/itel" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">ITEL</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_alpha/qa_alpha_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AGE</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/keeper" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">KEEPER</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_virtuox/qa_virtuox_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">VIRTUOX</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_phs_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Premier Health Solution</span>
								</a>
							</li>

							<!-- <li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/telaid" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">TELAID</span>
								</a>
							</li> -->
							<li class="menu-item has-submenu">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/telaid" class="menu-link submenu-toggle">
									<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
									<span class="menu-text foldable">TELAID</span>
									<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
								</a>
								<ul class="submenu">

								<li class="menu-item">
									<a href="<?php echo base_url()?>reports_qa/qa_process_report/telaid" class="menu-link">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">TELAID</span>
									</a>
								</li>
									<li class="menu-item">
										<a href="<?php echo base_url()?>qa_telaid/qa_starbucks_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Telaid Starbucks</span>
										</a>
									</li>
									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_telaidqa_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Telaid QA-IB</span>
										</a>
									</li>

									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_telaidobqa_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Telaid QA-OB</span>
										</a>
									</li>


								</ul>
							</li>
							<!-- <li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/awareness" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Awareness TECH</span>
								</a>
							</li> -->


							<li class="menu-item has-submenu">
								<a href="" class="menu-link submenu-toggle">
									<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
									<span class="menu-text foldable">Awareness TECH</span>
									<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
								</a>
								<ul class="submenu">

									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_process_report/awareness" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Awareness TECH OLD</span>
										</a>
									</li>

									<li class="menu-item">
										<a href="<?php echo base_url()?>Qa_awareness_new/qa_awareness_new_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Awareness TECH New</span>
										</a>
									</li>


								</ul>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_sentry_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sentry</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_pajamagram/qa_pajamagram_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Vermont Teddy Bear [Coaching]</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_RPM_Sentry/qa_sentry_credit_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sentry Credit Observation</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_homeadvisor_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Home Advisor</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_craftjack_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Craftjack</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_amazon_intake_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Amazon</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_novasom_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Bioserenity</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_metropolis_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Metropolis</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_swiggy_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Swiggy</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_paynearby_report" class="menu-link"> 
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Paynearby</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_avon/qa_avon_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AVON</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_acm_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">ACM</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_jurys_inn_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Jury's Inn</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_indiabulls_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">India Bulls</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/chariot" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">CHARIOT COLLECTION</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_araca_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Araca Shop</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_ameridial_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AMERIDIAL</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_kiwi_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">KIWI</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_superdaily_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Super Daily</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_agent_coaching_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Agent Coaching</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_agent_coaching_new/qa_agent_coaching_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">GRBM Agent Coaching</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_kabbage_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Kabbage</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_idfc_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">IDFC</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_sxc_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">SXC</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_docusign_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Docusign</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_msb_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">MSB Financial</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_freedom_financial_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Achieve Collection</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_freedom_customer_service_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Achieve Cs</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_doubtnut_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Doubtnut</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_il_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Ideal Living</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_ibuumerang_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Ibuumerang</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_att_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AT&T </span>
								</a>
							</li>
							<!--<li class="menu-item">
								<a href="<?php //echo base_url()?>reports_qa/qa_att_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AT&T VERINT</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php //echo base_url()?>reports_qa/qa_att_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AT&T FLORIDA</span>
								</a>
							</li>-->
							<!--<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/brightway_evaluation" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Brightway Evaluation</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/brightway_prescreen" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Brightway Prescreen</span>
								</a>
							</li>-->
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_acc_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">ACC </span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_acg/qa_acg_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Updater </span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_norther_tools_equipment/qa_norther_tools_equipment_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Norther Tools & Equipment </span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_park_west/qa_park_west_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Park West</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_epgi/qa_epgi_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">EPGI</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_ayming/qa_ayming_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AYMING</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_sea_world/qa_sea_world_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sea World</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_scan/qa_scan_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Scan</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_urban_piper/qa_urban_piper_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Urban Piper</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_lunajoy/qa_lunajoy_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Lunajoy</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_superbill_outbound/qa_superbill_outbound_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Superbill-Outbound</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_travel_pro/qa_travel_pro_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Travel Pro Scorecard</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_clever_care/qa_clever_care_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Clever Care</span>
								</a>
							</li>
							<!--<li class="menu-item">
								<a href="<?php //echo base_url()?>Qa_conduent_direct_express/qa_conduent_direct_express_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Conduent- Direct Express</span>
								</a>
							</li>-->
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_assured_imaging/qa_assured_imaging_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Assured Imaging</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_union_pacific/qa_union_pacific_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Union Pacific</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_cesc/qa_cesc_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">CESC </span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_intelycare/qa_intelycare_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Intelycare </span>
								</a>
							</li>


							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_ash_maples/qa_ash_maples_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class=""> ASH & MAPLE </span>
								</a>
							</li>






							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_redeo/qa_redeo_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Redeo </span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_epoch/qa_epoch_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Epoch </span>
								</a>
							</li>


							
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_arvind/qa_arvind_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Arvind </span>
								</a>
							</li>



							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_ash_maples/qa_ash_maples_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Ash Maples </span>
								</a>
							</li>


							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_romtech_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">RomTech </span>
								</a>
							</li>


						
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/service" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Service</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/sales_carpart" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sales</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_layway_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Laya Way Depot</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_outsource_order_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Outsource Order Capture Evaluation</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_viberides_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Viberides</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_sensio_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sensio</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_vfs/qa_vfs_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">VFS</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_tvs_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">TVS</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_myglam/qa_myglam_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sanghvi Beauty and Technologies</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_premium/qa_premium_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Premium Choice Insurance Services</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_us_da_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">US Directory Assistance</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/alteras" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Alteras</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/grille" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">CHÂTEAU D'EAU</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/flv" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">FLV</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/cati" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">CATI</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/arabophone" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">ARABOPHONE</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/nordnet" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">NORDNET</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/schoolonline" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">SCHOOL ONLINE</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/collecte" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">COLLECTE DAYDREAMS SALES</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/creditsafe" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">CREDIT SAFE</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/carddata" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">CAR DATA</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/solucia" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">SOLUCIA</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/mercy" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">MERCY SHIP</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_chegg/qa_chegg_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Chegg</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_zovio_follet_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Zovio/Follet</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_nuwave_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Nuwave</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_magnilife_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Magnilife</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_hsdl_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">HSDL</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_process_report/fiberconnect" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Fiber Connect</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_k2_claims_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">K2 Claims</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_biomet_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Biomet</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_edtech_cuemath_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">CUEMATH</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_edtech_beyondskool_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Beyondskool</span>
								</a>
							</li>
							<!-- <li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_sycn_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Ship Your Car Now</span>
								</a>
							</li> -->

							<li class="menu-item has-submenu">
								<a href="" class="menu-link submenu-toggle">
									<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
									<span class="menu-text foldable">Ship Your Car Now</span>
									<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
								</a>
								<ul class="submenu">

									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_sycn_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Ship Your Car Now (Inbound)</span>
										</a>
									</li>

									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_sycn_outbound_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Ship Your Car Now (Outbound)</span>
										</a>
									</li>
								</ul>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_care_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Care.Com</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_huda_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Huda</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_cloudflare_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Cloudflare</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_srl_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">SRL Diagnostic</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_loanxm_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Debt Solution 123</span>
								</a>
							</li>
							<!-- <li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_clio_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">CLIO</span>
								</a>
							</li> -->

							<li class="menu-item has-submenu">
								<a href="" class="menu-link submenu-toggle">
									<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
									<span class="menu-text foldable">CLIO</span>
									<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
								</a>
								<ul class="submenu">

									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_clio_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Clio</span>
										</a>
									</li>

									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_clio_spot_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">Clio Spot Check</span>
										</a>
									</li>
								</ul>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_credit_pro_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Credit Pro</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_stifel_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Stifel</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_credit_mantri/qa_credit_mantri_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Credit Mantri</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_netmeds_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Netmeds</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_dunzo_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Dunzo</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_nurture_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Nurture Farms</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_india_moe_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">India Moe</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_revive_rx/qa_revive_rx_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Revive Rx</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_ajio/qa_ajio_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AJIO</span>
								</a>
							</li>
<!--- added for wireless--->
							<li class="menu-item">
								<a href="<?php echo base_url('qa_wireless_dna/qa_wireless_dna_report'); ?>" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Wireless DNA</span>
								</a>
							</li>


<!--- end for wireless--->


<!--- added for Squad Stack--->
<li class="menu-item">
								<a href="<?php echo base_url('qa_cq_squad_stack/qa_stack_report'); ?>" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class=""> Squad Stack</span>
								</a>
							</li>


<!--- end for Squad Stack--->

							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_safe_eco_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Safe Eco</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_stratus/qa_stratus_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Stratus</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_varo_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Varo</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_cars24_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Cars24</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_cinemark_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Cinemark</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_ffai_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Filter Fast Agent Improvement</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_ameridial_recruitment/qa_ameridial_recruitment_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Ameridial Recruitment</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_one_assist_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">One Assist</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_groupe_france_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Groupe France Assue</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_ab_commercial/qa_ab_commercial_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">AB Commercial Offline</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_sentient_jet/qa_sentient_jet_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Sentient Jet</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_edtech_lido_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">LIDO</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_queens_english_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Queens English</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_bounce_infinity_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Bounce Infinity</span>
								</a>
							</li>
							<!-- <li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_bsnl_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">BSNL</span>
								</a>
							</li> -->

							<li class="menu-item has-submenu">
								<a href="" class="menu-link submenu-toggle">
									<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
									<span class="menu-text foldable">BSNL</span>
									<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
								</a>
								<ul class="submenu">

									<li class="menu-item">
										<a href="<?php echo base_url()?>reports_qa/qa_bsnl_report" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">BSNL</span>
										</a>
									</li>

									<li class="menu-item">
										<a href="<?php echo base_url()?>qa_bsnl/qa_bsnl_report_new" class="menu-link">
											<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
											<span class="">BSNL Outbound</span>
										</a>
									</li>
								</ul>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_grille_evaluation_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Grille Evaluation</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_daydreams_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Day Dreams</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_cholamandlam_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Cholamandlam</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_lcn/qa_lcn_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">LCN Call</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/gtn_technical_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">GTN Technical Staffing</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_comcast_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Comcast Sales</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_gridaifi_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Grid AIFI</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_paytail_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Paytail</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_pinelabs_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Pine Labs</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_smileimpress/qa_smileimpress_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Smile To Impress</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_mobikwik_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Mobikwik</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_maalomatia_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Maalomatia</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_heaps_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Heaps </span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_coastline/qa_coastline_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Coastline </span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_actyvAI_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Actyv AI</span>
								</a>
							</li>
								<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_vision_canada_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">World Vision Canada</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_chariot_energy_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">CHARIOT ENERGY</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_lead_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Lead School</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_associate_mats_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Associate Materials</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_ameriflex_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Ameriflex</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_smartflats/qa_smartflats_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Smartflats</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_mba_voice/qa_mba_voice_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Merchants Benefit Administration</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_avanse/qa_avanse_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Avanse</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_octafx/qa_octafx_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">OctaFX</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_pinglend/qa_pinglend_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">PingLend</span>
								</a>
							</li>
							<li class="menu-item has-submenu">
								<a href="" class="menu-link submenu-toggle">
									<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
									<span class="menu-text foldable">CSPL</span>
									<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
								</a>
								<ul class="submenu">
									<li>
										<a style="padding-left:50px" href="<?php echo base_url('reports_qa/qa_ftpl_report'); ?>">
											<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
											<span class="">FTPL</span>
										</a>
									</li>

									<li>
										<a style="padding-left:50px" href="<?php echo base_url('reports_qa/qa_process_report/indiamart'); ?>">
											<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
											<span class="">INDIAMART</span>
										</a>
									</li>

									<li>
										<a style="padding-left:50px" href="<?php echo base_url('qa_wireless_dna/qa_wireless_dna_report'); ?>">
											<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
											<span class="">Wireless DNA</span>
										</a>
									</li>

								</ul>
							</li>


							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_agent_coaching_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Agent Coaching</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>Qa_agent_coaching_new/qa_agent_coaching_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">GRBM Agent Coaching</span>
								</a>
							</li>
							<li class="menu-item">
								<a href="<?php echo base_url()?>reports_qa/qa_hygiene_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Hygiene</span>
								</a>
							</li>

							<li class="menu-item">
								<a href="<?php echo base_url()?>qa_unacademy/qa_unacademy_report" class="menu-link">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Unacademy</span>
								</a>
							</li>



					<?php } ?>

				<?php } ?>

				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->

<!--start js code for the search filter-->
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".aside-left-menu li a").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
$(document).ready(function(){
	$("#myInput").click(function(){
		$(".submenu").show();
    });
	$(".app-main").click(function(){
		$(".submenu").hide();
    });
});
</script>
<!--end js code for the search filter-->
