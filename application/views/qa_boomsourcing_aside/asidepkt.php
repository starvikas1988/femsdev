<!-- APP ASIDE ==========-->

<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){ 
	$(function () {
		$(".submenu1").hide();
		$(".parent").click(function (e) {
			e.preventDefault();
			if (!$(e.target).closest("ul").is(".submenu1")) {
				 $(".submenu1", this).toggle();
				 $(this).siblings(".parent").find(".submenu1").hide();
			}
		});
	});
});  
</script> -->

<!--
<style>
.submenu1{
    display: block;
    font-size: .875rem;
    font-weight: 500;
    text-transform: capitalize;
}

.aside-left-menu .submenu1 .li {
  display: none;
  box-shadow: none; }
  .aside-left-menu .submenu1 > li > a {
    display: block;
    padding: 10px 5px 10px 30px;
    font-size: .875rem;
    font-weight: 500;
    text-transform: capitalize; }
  .aside-left-menu .submenu1 .menu-label {
    float: right; }

@media (min-width: 1200px) {
  .app-aside.left.folded {
    width: 5rem; }
    .app-aside.left.folded .foldable {
      visibility: hidden;
      display: none; }
    .app-aside.left.folded .brand-icon {
      width: 100%;
      margin-right: 0; }
    .app-aside.left.folded .menu-icon {
      display: inline-block;
      text-align: center;
      width: 100%;
      margin: 0; }
    .app-aside.left.folded .menu-link .md-icon {
      font-size: 20px; }
    .app-aside.left.folded .submenu1 {
      position: absolute;
      left: 100%;
      right: auto;
      top: 0;
      max-height: auto;
      display: none;
      min-width: 220px;
      -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175); }
      .app-aside.left.folded .submenu1 > li > a {
        padding-left: 500px; }
    .app-aside.left.folded .open > .submenu1 {
      display: block; } }

</style>  -->


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
				<span id="brand-name" class="brand-icon foldable"><img src="<?php echo base_url() ?>/assets/images/fusion-bpo.png" border="0" alt="Fusion BPO"></span>
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
						<span class="menu-text foldable">PKT Exam</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
						<?php if(get_global_access()==1){?>
					<?php 
					$arr = explode("/", $_SERVER['PHP_SELF']);
					$sub_menu = end($arr);
					//$_SERVER['PHP_SELF'];
					?>
					<ul class="submenu" <?php if($sub_menu=="create_exam" || $sub_menu =="exam_list" || $sub_menu=="assign_exam_to_user"){?> style="display:block;"<?php }?>>
						<li>
							<a href="<?php echo base_url()?>process_knowledge_test/create_exam">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Create Exam</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>process_knowledge_test/exam_list">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Exam List</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>process_knowledge_test/assign_exam_to_user">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Assign Exam</span>
							</a>
						</li>
				
				<?php }?>
					<li class="menu-item">
					<a href="<?php echo base_url();?>process_knowledge_test/my_exam" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">My Exam</span>
					</a>
				</li>
				<?php if(get_global_access()==1){?>
				<li class="menu-item">
					<a href="<?php echo base_url()?>process_knowledge_test/manage_assigned_exams" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Manage Assigned Exams</span>
					</a>
				</li>
				<?php }?>

				<li class="menu-item">
					<a href="<?php echo base_url()?>process_knowledge_test/pkt_report" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Report</span>
					</a>
				</li>
				<?php } ?>
				
				<!--
				<li class="menu-item">
					<a href="<?php //echo base_url('Qa_dashboard')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Dashboard</span>
					</a>
				</li>
				-->
				
				<?php if( is_access_qa_agent_module()==true ){ 
					$this->session->set_userdata('agentUrl',$agentUrl);
					?>
					
					<li class="menu-item">
						<a href="<?php echo base_url('Qa_dashboard')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">Dip Check</span>
						</a>
					</li>
					
					<li class="menu-item">
						<a href="<?php echo base_url('Qa_agent_dashboard')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">Dashboard</span>
						</a>
					</li>
				
					<li class="menu-item has-submenu">
						<a href="" class="menu-link submenu-toggle">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="menu-text foldable">Your Audit</span>
							<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
						</a>
						<ul class="submenu">
							<?php  
								$qa_menu=get_fems_user_qa_menu(); 
								//foreach( $qa_menu as $menu){
									echo '<li class="menu-item">';
									echo '<a href="'. base_url('qa_boomsourcing/agent_boomsourcing_feedback'). '" class="menu-link">';
									echo '<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>';
									echo '<span class="">Boomsourcing</span>';
									echo '</a>';
									echo '</li>';
							//	}
							?>
						</ul>
					</li>
					
				<!-- 	<li class="menu-item">
						<a href="<?php echo base_url('Qa_agent_coaching/agent_coaching_feedback'); ?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">Coaching</span>
						</a>
					</li> -->
					
				<?php } ?>
				
				
				<?php if( is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){ ?>
				
				<!--<li class="menu-item">
					<a href="<?php //echo base_url('Qa_cq_dashboard/cq_overall')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="">Summary Dashboard</span>
					</a>
				</li>-->
				
			<!-- 	<li class="menu-item">
					<a href="<?php //echo base_url('Qa_calibration')?>" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="">QA Calibration</span>
					</a>
				</li> -->
				
		<!--		<li class="menu-item has-submenu">
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
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-collection-folder-image"></i></span>
						<span class="menu-text foldable">CQ Dashboard</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
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
						<li>
							<a href="<?php echo base_url('Qa_graph_boomsourcing/acceptance_dashboard')?>" class="menu-link">
							<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
							<span class="">Acceptance Dashboard</span>
					        </a>
						</li>
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
						<li class="menu-item">
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
						</li>
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
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_agent_score_comparison_boomsourcing')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Agent Score Comparison</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_repeat_dashboard_boomsourcing')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">Repeat Error Dashboard</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_boomsourcing_one_view_dashboard/one_view_dashboard')?>" class="menu-link">
								<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
								<span class="">One View Dashboard</span>
							</a>
						</li>
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
						<?php
						if(get_role_dir() == "agent"){
							?>
							<li class="menu-item">
							<a href="<?php echo base_url('Qa_boomsourcing/agent_boomsourcing_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-account"></i></span>
								<span class="">Bommsourcing</span>
							</a>
						</li>
							<?php

						}else{
							?>
							<li class="menu-item">
							<a href="<?php echo base_url('Qa_boomsourcing/boomsourcing'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-account"></i></span>
								<span class="">Bommsourcing</span>
							</a>
						</li>
							<?php
						}
						 ?>
						
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
				
				<?php } ?>
				
			</ul> 
			
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->

<?php } ?>