
<?php if(get_login_type() == "client"){ ?>

	<aside id="app-aside" class="app-aside left light">
	<header class="aside-header">
		<div class="animated">
			<a href="<?php echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable"><img src="<?php echo base_url() ?>/assets/images/fusion-bpo.png" border="0" alt="Fusion BPO"></span>
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
			
		</div>
	</div>
</aside>
<!-- end client menu -->

<?php }else{ ?>

<aside id="app-aside" class="app-aside left light">
	<header class="aside-header">
		<div class="animated">
			<a href="<?php echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable"><img src="<?php echo base_url() ?>/assets/images/fusion-bpo.png" border="0" alt="Fusion BPO"></span>
			</a>
		</div>
	</header>
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
			
				<?php if(get_role_dir()=="agent" && (get_dept_folder()=="operations" || get_dept_folder()=="sales")){ ?>
				
					<li class="menu-item has-submenu">
						<a href="" class="menu-link submenu-toggle">
							<span class="menu-icon"><i class="zmdi zmdi-collection-folder-image"></i></span>
							<span class="menu-text foldable">Audit Sheet</span>
							<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
						</a>
						<ul class="submenu">
							<li class="menu-item">
								<a href="<?php echo base_url('Qa_boomsourcing/agent_boomsourcing_feedback'); ?>">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-account"></i></span>
									<span class="">Bommsourcing</span>
								</a>
							</li>
						</ul>
					</li>
				
				<?php }else{ ?>
				
				<!--<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">PKT</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li class="menu-item">
							<a href="<?php echo base_url()?>process_knowledge_test/create_exam" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Create Exam</span>
							</a>
						</li>
						<li class="menu-item">
						<a href="<?php echo base_url()?>process_knowledge_test/exam_list" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Exam List</span>
						</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url()?>process_knowledge_test/assign_exam_to_user" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Assign Exam</span>
						</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url();?>process_knowledge_test/my_exam" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">My Exam</span>
						</a>
						</li>
						<?php if(get_global_access()==1){?>
						<li class="menu-item">
							<a href="<?php echo base_url()?>process_knowledge_test/manage_assigned_exams"  class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Manage Assigned Exams</span>
						</a>
						</li>
						<?php }?>
						<li class="menu-item">
							<a href="<?php echo base_url()?>process_knowledge_test/pkt_report"  class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Pkt Report</span>
						</a>
						</li>
					</ul>
				</li>-->
					
				
				<?php if( is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){ ?>
				
				<!--<li class="menu-item">
					<a href="<?php //echo base_url('Qa_cq_dashboard/cq_overall')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="">Summary Dashboard</span>
					</a>
				</li>-->
				
				<!--<li class="menu-item">
					<a href="<?php //echo base_url('Qa_calibration')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="">QA Calibration</span>
					</a>
				</li> -->
				
				<!--<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-collection-folder-image"></i></span>
						<span class="menu-text foldable">Certification Dashboard</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php //echo base_url('Qa_calibration/certificate_mockcall')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Certification Mockcall</span>
							</a>
						</li>
						<li>
							<a href="<?php //echo base_url('Qa_calibration/certification_audit')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Certification Audit</span>
							</a>
						</li> 
						<li>
							<a href="<?php //echo base_url('Qa_calibration/recertification_audit')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Recertification Audit</span>
							</a>
						</li> 
					</ul>
				</li> -->
				<li class="menu-item">
					<a href="<?php echo base_url('Qa_boomsourcing_data_analytics/qa_calibration')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="">Calibration Dashboard</span>
					</a>
				</li>

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-collection-folder-image"></i></span>
						<span class="menu-text foldable">CQ Dashboard</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">

						<li class="menu-item">
							<a href="<?php echo base_url('Qa_boomsourcing_data_analytics/one_view_dashboard')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">One View Dashboard</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_boomsourcing_data_analytics/acceptance_dashboard')?>" class="menu-link">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">Acceptance Dashboard</span>
					        </a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_boomsourcing_data_analytics/Parameter_wise_dashboard')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Parameter Dashboard</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_repeat_dashboard_boomsourcing')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Repeat Error Dashboard</span>
							</a>
						</li>
					<!-- 	<li>
							<a href="<?php echo base_url('qa_graph/program_level')?>" class="menu-link">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">Program Level</span>
					        </a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_graph/manager_level')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class=""> Manager Dashboard</span>
							</a>
						</li>	 -->					
						<!--<li>
							<a href="<?php echo base_url('qa_graph/agent_level')?>" class="menu-link">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">Agent Dashboard</span>
					        </a>
						</li>-->
						
			<!-- 			<li>
							<a href="<?php echo base_url('qa_graph/defect_level')?>" class="menu-link">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">Parameter Dashboard</span>
					        </a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_graph/tender_level')?>" class="menu-link">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">AON Dashboard</span>
					        </a>
						</li> -->
						<!-- <li class="menu-item">
							<a href="<?php echo base_url('Qa_tni_dashboard_boomsourcing')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">TNI Dashboard</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_tni_dashboard_boomsourcing')?>/tni_fatal_dashboard" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">TNI Fatal Dashboard</span>
							</a>
						</li> -->
						<!--<li class="menu-item">
							<a href="<?php echo base_url('Qa_productivity_dashboard/disposition_dashboard')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Disposition Dashboard</span>
							</a>
						</li>-->
					<!-- 	<li class="menu-item">
							<a href="<?php echo base_url('qa_cq_dashboard/all_in_one_dashboard')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">All-In-One Dashboard</span>
							</a>
						</li> -->
				<!-- 		<li class="menu-item">
							<a href="<?php echo base_url('qa_cq_dashboard/correlation_matrix')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Correlation Matrix</span>
							</a>
						</li> -->
				<!-- 		<li class="menu-item">
							<a href="<?php echo base_url('Qa_productivity_dashboard/qa_productivity_dashboard_new')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Productivity Dashboard</span>
							</a>
						</li> -->
						<!-- <li class="menu-item">
							<a href="<?php echo base_url('Qa_agent_score_comparison_boomsourcing')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Agent Score Comparison</span>
							</a>
						</li> -->
						<!--<li class="menu-item">
							<a href="<?php echo base_url('Qa_acpt_dashboard/acpt')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">ACPT Dashboard</span>
							</a>
						</li>-->
						<!--
						<li>
							<a href="<?php echo base_url('Qa_graph/opsview')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Summary OPS View</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_graph/globalview')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Global View</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_graph/leadview')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">QA Lead View</span>
							</a>
						</li>
						-->
						
					</ul>
				</li>
				
				<li class="menu-item">
				    <a href="<?php echo base_url('Qa_boomsourcing_vertical_campaign'); ?>" class="menu-link">
				        <span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
				        <span class="">Manage Vertical & Campaign</span>
				    </a>
				</li>
				
				<!-- <li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-collection-folder-image"></i></span>
						<span class="menu-text foldable">QA ATA</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li class="menu-item">
							<a href="<?php echo base_url('qa_dunzo_ata'); ?>">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">QA Wise ATA</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_dunzo_ata/qa_wise_ata'); ?>">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">ATA Dashboard</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_dunzo/qa_ata_audit'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-account"></i></span>
								<span class="">QA ATA Acceptance</span>
							</a>
						</li>
					</ul>
				</li> -->
				
				<!--<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="menu-text foldable">QA Target</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('qa_graph/set_target')?>" class="menu-link">
							<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
							<span class="">Set Target</span>
					</a>
						</li>
						<li>
							<a href="<?php echo base_url('qa_graph/view_target')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">View Target</span>
							</a>
						</li>						
					</ul>
				</li>-->
				
			<!-- 	<li class="menu-item">
					<a href="<?php echo base_url('Qa_agent_categorisation')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Agent Categorisation</span>
					</a>
				</li> -->
				<!--
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-collection-folder-image"></i></span>
						<span class="menu-text foldable">Sampling/Randamiser</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Voice</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_sop_library/data_cdr_upload_freshdesk'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CDR Upload</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_sop_library/data_nps_upload_freshdesk'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">NPS Upload</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_sop_library/data_randamise_compute_freshdesk'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Compute</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_sop_library/data_randamise_logiclist_freshdesk'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Logic History</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_sop_library/data_distribute_freshdesk'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">My Audit</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>-->
				
				
							
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-collection-folder-image"></i></span>
						<span class="menu-text foldable">QA/ATA Audit Sheet</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_boomsourcing/boomsourcing'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-account"></i></span>
								<span class="">Bommsourcing</span>
							</a>
						</li>
					</ul>
				</li>

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-collection-folder-image"></i></span>
						<span class="menu-text foldable">Reports</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
							<li class="menu-item">
							<a href="<?php echo base_url('Qa_boomsourcing/qa_boomsourcing_report'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-account"></i></span>
								<span class="">Bommsourcing</span>
							</a>
						</li>
					</ul>
				</li>
				
				<?php } 
				} ?>
				
			</ul> 
			
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->

<?php } ?>