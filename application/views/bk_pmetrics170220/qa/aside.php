<!-- APP ASIDE ==========-->

<?php if(get_login_type() == "client"){ ?>

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
					<a href="<?php echo base_url('client_qa_dashboard')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
						<span class=""> Dashboard</span>
					</a>
				</li>
				
				
				
				<li class="menu-item">
					<a href="<?php echo base_url('client_qa_calibration')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
						<span class="">Calibration</span>
					</a>
				</li>
				
				
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="menu-text foldable">Graphical Dashboard</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">

						<li>
							<a href="<?php echo base_url('client_qa_graph')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Summary OPS View</span>
							</a>
						</li>
						<!--
						<li>
							<a href="<?php //echo base_url('client_qa_graph/globalview')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Process Wise Global View</span>
							</a>
						</li>
						-->
					</ul>
				</li>
				
				<?php  

					$qa_menu=get_client_qa_menu();
					foreach( $qa_menu as $menu){
						echo '<li class="menu-item">';
						echo '<a href="'. base_url($menu['qa_url']). '" class="menu-link">';
						echo '<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>';
						echo '<span class="">'.$menu['name'].'</span>';
						echo '</a>';
						echo '</li>';
					}
				?>

			</ul>
			
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
	</aside>
	<!-- end client menu -->
<?php }else{ ?>

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
			
				
				<?php if( is_access_qa_module()==true){ ?>
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Dip Check</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li class="menu-item">
							<a href="<?php echo base_url('qa_dipcheck')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Create/Manage</span>
						</a>
						</li>
						
						<li class="menu-item">
							<a href="<?php echo base_url()?>reports/dipcheck" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Report</span>
						</a>
						</li>
						</ul>
					</li>
					
				<?php } ?>
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_dashboard')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Dashboard</span>
					</a>
				</li>
				
				<?php if( is_access_qa_agent_module()==true ){ ?>
					
					<li class="menu-item">
						<a href="<?php echo base_url().$agentUrl;?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">Your Audit</span>
						</a>
					</li>
				
				<?php } ?>
					<!--<li class="menu-item">
						<a href="<?php //echo base_url();?>home" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">Your Audit</span>
						</a>
					</li> -->
				<?php //} ?>
				
				<?php if( is_access_qa_module()==true || is_access_qa_operations_module()==true){?>
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_associate_dashboard')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
						<span class="">Associate Dashboard</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_productivity_dashboard')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
						<span class="">Productivity Dashboard</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_calibration')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
						<span class="">QA Calibration</span>
					</a>
				</li>
				
				
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="menu-text foldable">Graphical Dashboard</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('Qa_graph')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">Summary</span>
					</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_graph/opsview')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Summary OPS View</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_graph/globalview')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Global View</span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url('Qa_graph/leadview')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">QA Lead View</span>
							</a>
						</li>
						
					</ul>
				</li>
				
				<?php if(isADLocation()==false || is_access_qa_module()==true ){ ?>
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">OYO</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
					
						<li>
							<a href="<?php echo base_url('Qa_oyo'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">International</span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url('Qa_oyo_rca/oyo_rca_feedback_review'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">RCA International</span>
							</a>
						</li>
						
						<?php
							$link_URL="Qa_oyo_sig/qaoyo_management_sorting_feedback";
						?>
						
						<li>
							<a href="<?php echo base_url().$link_URL; ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">SIG</span>
							</a>
						</li>
												
						<li>
							<a href="<?php echo base_url('Qa_oyosig_rca'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">DSAT RCA SIG</span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url('Qa_oyosig_rca/qa_sme_rca_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Social Media RCA SIG</span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url('Qa_oyo_life'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-return"></i></span>
								<span class="">LIFE IB/OB</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_oyo_life/qa_oyolife_followup_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-return"></i></span>
								<span class="">LIFE FollowUp</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_oyo_life/qa_oyolife_booking_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-return"></i></span>
								<span class="">LIFE BOOKING</span>
							</a>
						</li>
																		
					</ul>
				</li>	
			
			
			
				<!-- <li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Grubhub</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
					
						<?php 
							//$linkURL="Qa_grubhub/management_sorting_feedback";
						?>
					
						<li>
							<a href="<?php //echo base_url().$linkURL; ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">QA Feedback</span>
							</a>
						</li>
						
						<li>
							<a href="<?php //echo base_url('Qa_grubhub/kpi_feedback_entry'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">KPI Feedback</span>
							</a>
						</li>
						
						<li>
							<a href="<?php //echo base_url('Qa_grubhub/management_realtime_csat'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Real Time CSAT</span>
							</a>
						</li>
					</ul>
				</li> -->
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_od/qaod_management_sorting_feedback')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Office Depot</span>
					</a>
				</li>
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Meesho</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('Qa_meesho'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Email</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_meesho/meesho_inbound'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Inbound</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_meesho/supplier_support'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Supplier Support</span>
							</a>
						</li>
						
					</ul>
				</li>
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Verso</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('Qa_verso'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Customer Care Audit</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_verso/qa_verso_ob_fc_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Full Call Audit</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_verso/qa_verso_ob_sc_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Special Call Audit</span>
							</a>
						</li>
						
					</ul>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_puppyspot')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">PuppySpot</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_vrs')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Vital Recovery Services</span>
					</a>
				</li>
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Welcome Pickups</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('Qa_welcomepickup/call_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Calls</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_welcomepickup/ticket_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Tickets</span>
							</a>
						</li>
					</ul>
				</li>
								
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_rugdoctor')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">RugDoctor</span>
					</a>
				</li> 

							
				
				<!--Checkpoint SUB-MENU START-->
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Checkpoint</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('qa_checkpoint'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Checkpoint Chat</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_checkpoint_email'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Checkpoint Email</span>
							</a>
						</li>
						<!-- <li>
							<a href="<?php echo base_url('qa_checkpoint_chat'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Checkpoint Chat</span>
							</a>
						</li> -->
						
					</ul>
				</li>
				<!--Checkpoint SUB-MENU END-->
				
				

				<li class="menu-item">
					<a href="<?php echo base_url('Qa_RPM_Sentry/rpm')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">RPM</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_RPM_Sentry/sentry')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Sentry</span>
					</a>
				</li>
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Home Advisor</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('Qa_homeadvisor'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Home Advisor</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_homeadvisor/qa_hcco_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">HCCO</span>
							</a>
						</li>
					</ul>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_craftjack')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Craftjack</span>
					</a>
				</li>
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Amazon</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('Qa_amazon_intake'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Intake</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_amazon_intake/qa_amazon_question'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Question</span>
							</a>
						</li>
						
					</ul>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_novasom')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Novasom</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_metropolis')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Metropolis</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_swiggy')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Swiggy</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_paynearby')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Paynearby</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_acm')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">ACM</span>
					</a>
				</li>
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Jury's Inn</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('Qa_jurys_inn'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Revised CIS</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_jurys_inn/jurysinn_email'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Res CIS Email</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_indiabulls')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">India Bulls</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_araca')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Araca Shop</span>
					</a>
				</li>
				
				<?php } ?>
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Ameridial Commercial</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('qa_ameridial'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Fortune Builder</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/purity_bottle/'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Purity Free Bottle</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/purity_catalog/'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Purity Catalog</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/purity_care/'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Purity Care</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/hoveround_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Hoveround</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/ncpssm_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">NCPSSM</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/stc_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">STC Scoresheet</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/touchfuse'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">TOUCHFUSE</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/tbn_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">TBN</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/jfmi_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">JFMI</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/tpm_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">TPM</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/aspca'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">ASPCA</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/ffai'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">FilterFast AIF</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/patchology_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Patchology Improvement</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/lifi'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Life Quote(LIFI)</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/heatsurge_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Heat Surge</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/stauers_sales'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Stauers Sales</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/operation_smile'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Operation Smile</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/tactical_5_11'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">5-11 Tactical</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_ameridial/jmmi'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">JMMI</span>
							</a>
						</li>
					</ul>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_ameridial/non_profit')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Ameridial Non-Profit</span>
					</a>
				</li>

				<li class="menu-item">
					<a href="<?php echo base_url('Qa_agent_coaching')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Agent Coaching</span>
					</a>
				</li>
				
				<?php if(isADLocation()==false || is_access_qa_module()==true ){ ?>
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_kiwi')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">KIWI</span>
					</a>
				</li> 
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_superdaily')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Super Daily</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_entice_energy')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Entice Energy</span> 
					</a>
				</li>
				
				<?php } ?>
				
			<?php } ?>
				
			</ul>
			
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->

<?php } ?>