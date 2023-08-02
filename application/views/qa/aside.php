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

<?php if(get_login_type() == "client"){ ?>

	<aside id="app-aside" class="app-aside left light">
	<!--<header class="aside-header">
		<div class="animated">
			<a href="<?php //echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable"><?=get_logo()?></span>
			</a>
		</div>
	</header>--><!-- #sidebar-header -->
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Dip Check</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">

						<li>
							<a href="<?php echo base_url('client_qa_dipcheck')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Manage</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url('client_qa_dipcheck/dipcheck_report')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Reports</span>
							</a>
						</li>

					</ul>
				</li>

				<li class="menu-item">
					<a href="<?php echo base_url('client_qa_graph')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
						<span class=""> Dashboard</span>
					</a>
				</li>

				<!--
				<li class="menu-item">
					<a href="<?php //echo base_url('client_qa_dashboard')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
						<span class=""> Dashboard</span>
					</a>
				</li>
				-->

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="menu-text foldable">Calibration</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('client_qa_calibration')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Calibration</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url('client_qa_calibration/certificate_mockcall')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Certification Mockcall</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url('client_qa_calibration/certification_audit')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Certification Audit</span>
							</a>
						</li>
					</ul>
				</li>

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="menu-text foldable">Graphical Dashboard</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">

						<!--<li>
							<a href="<?php //echo base_url('client_qa_graph')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Summary Dashboard</span>
							</a>
						</li>-->

						<li>
							<a href="<?php echo base_url('client_qa_graph/program_level')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Program Level</span>
							</a>
						</li>

						<!--<li>
							<a href="<?php //echo base_url('client_qa_graph/agent_level')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Agent Dashboard</span>
							</a>
						</li>-->

						<li>
							<a href="<?php echo base_url('client_qa_graph/acceptance_dashboard')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Acceptance Dashboard</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('client_qa_graph/manager_level')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Manager Dashboard</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url('client_qa_graph/defect_level')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">Parameter Dashboard</span>
					        </a>
						</li>

						<li>
							<a href="<?php echo base_url('client_qa_graph/tender_level')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">AON Dashboard</span>
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


				<li class="menu-item">
					<a href="<?php echo base_url('Qa_agent_coaching')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
						<span class=""> Agent Coaching</span>
					</a>
				</li>


			</ul>

		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
	</aside>
	<!-- end client menu -->
<?php }else{ ?>

<aside id="app-aside" class="app-aside left light">
	<!--<header class="aside-header">
		<div class="animated">
			<a href="<?php //echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable"><img src="<?php //echo base_url() ?>assets/images/fusion-bpo.png" border="0" alt="Fusion BPO"></span>
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

				<?php if(is_access_qa_module()==true || get_user_fusion_id() == "FALB000144" ){ ?>

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
						<!--
						<li class="menu-item">
							<a href="<?php //echo base_url()?>qa_dipcheck/dipcheck_report" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Report</span>
						</a>
						</li>
						-->

					</ul>

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

					<?php if( is_access_qa_agent_module()==true){
						//$this->session->set_userdata('agentUrl',$agentUrl);
					?>

					<li class="menu-item">
						<a href="<?php echo base_url('Qa_dashboard')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">Dashboard</span>
						</a>
					</li>

					<!--<li class="menu-item">
					<a href="<?php //echo base_url('qa_graph/agent_level')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Agent Dashboard</span>
					</a>
				   </li>-->



					<li class="menu-item has-submenu">
						<a href="" class="menu-link submenu-toggle">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="menu-text foldable">Your Audit</span>
							<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
						</a>
						<ul class="submenu">


							<?php

								$qa_menu=get_fems_user_qa_menu();
								foreach( $qa_menu as $menu){
									echo '<li class="menu-item">';
									echo '<a href="'. base_url($menu['qa_agent_url']). '" class="menu-link">';
									echo '<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>';
									echo '<span class="">'.$menu['name'].'</span>';
									echo '</a>';
									echo '</li>';
								}
								?>

						</ul>

					</li>


					<!--
					<li class="menu-item">
						<a href="<?php //echo base_url().$this->session->userdata('agentUrl');?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">Your Audit</span>
						</a>
					</li>
					-->

					<li class="menu-item">
						<a href="<?php echo base_url('Qa_agent_coaching/agent_coaching_feedback'); ?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">Coaching</span>
						</a>
					</li>




					<?php if(isIndiaLocation(get_user_office_id())==true){ ?>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_hygiene/agent_hygiene_feedback'); ?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Hygiene</span>
							</a>
						</li>
					<?php } ?>



					</ul>
				</li>

				<?php } ?>


				<?php if((is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true || get_user_fusion_id() == "FALB000144") && is_access_qa_agent_module()==false){ ?>

				<!------- Kayum [25/03/2022] -------->

				<!--<li class="menu-item">
					<a href="<?php echo base_url('quality')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Dashboard</span>
					</a>
				</li>-->

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

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="menu-text foldable">QA Dashboard</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('Qa_calibration')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Calibration</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_calibration/certificate_mockcall')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Certification Mockcall</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_calibration/certification_audit')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Certification Audit</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_score_philipines')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Qa Score Dashboard (Philippines)</span>
							</a>
						</li>
					</ul>
				</li>

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="menu-text foldable">New Dashboard</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<!-- One View Dashboard -->
						<!-- Edited By Samrat 10-Aug-22 -->
						<li class="menu-item">
							<a href="<?php echo base_url('qa_one_view_dashboard/one_view_dashboard')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">One View Dashboard</span>
							</a>
						</li>
						<!-- Parameter Dashboard -->
						<!-- Edited By Samrat 21-Oct-22 -->
						<!-- <li class="menu-item">
							<a href="<?php echo base_url('Parameter_wise_dashboard')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Parameter Dashboard</span>
							</a>
						</li> -->
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_acceptance_new/acceptance_dashboard')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class="">Acceptance Dashboard</span>
							</a>
						</li>
					</ul>
				</li>

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class="menu-text foldable">Graphical Dashboard</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">

						<li>
							<a href="<?php echo base_url('qa_graph')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">Summary Dashboard</span>
					        </a>
						</li>

						<li>
							<a href="<?php echo base_url('qa_graph/program_level')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">Program Level</span>
					        </a>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('qa_graph/manager_level')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
								<span class=""> Manager Dashboard</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url('qa_graph/agent_level')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">Agent Dashboard</span>
					        </a>
						</li>

						<li>
							<a href="<?php echo base_url('qa_graph/acceptance_dashboard')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">Acceptance Dashboard</span>
					        </a>
						</li>
						<li>
							<a href="<?php echo base_url('Qa_acceptance_new/acceptance_dashboard')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">New Acceptance Dashboard</span>
					        </a>
						</li>

						<li>
							<a href="<?php echo base_url('qa_graph/defect_level')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">Parameter Dashboard</span>
					        </a>
						</li>

						<li>
							<a href="<?php echo base_url('qa_graph/tender_level')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">AON Dashboard</span>
					        </a>
						</li>

						<!--
						<li>
							<a href="<?php echo base_url('qa_graph/program_level')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">Program Level</span>
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
						-->
					</ul>
				</li>

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

				<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){ ?>
					<li class="menu-item">
						<a href="<?php echo base_url('Qa_sop_library')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">SOP Library</span>
						</a>
					</li>
				<?php } ?>


				<?php if(isADLocation()==false && get_user_office_id()!="CHA"){ ?>
				<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Office Depot</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_od/qaod_management_sorting_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Office Depot Audit</span>
									</a>
								</li>

								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_agent_coaching_upload/data_cdr_upload_freshdesk'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Office Depot Agent coaching Upload</span>
									</a>
								</li>

								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_agent_coaching_upload/agent_coaching_list_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Office Depot Agent coaching Feedback</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_od/qaod_nps_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Office Depot NPS ACPT Form</span>
									</a>
								</li>

							</ul>
						</li>	

				<li class="menu-item">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-dns zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Customer Services</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('Qa_od/qaod_management_sorting_feedback'); ?>">
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
									<a style="padding-left:50px" href="<?php echo base_url('Qa_meesho'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Email</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_meesho/meesho_inbound'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Inbound</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_meesho/supplier_support'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Supplier Support</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_meesho/pop_shop'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">POP SHOP</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Paynearby</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_paynearby'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">PNB Inbound</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_paynearby/paynearby_outbound'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">PNB Outbound</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_paynearby/paynearby_email'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">PNB Email</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_paynearby/closeloop'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">PNB Close Loop</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_acm')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">ACM</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_araca')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Araca Shop</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_superdaily')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Super Daily</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_chegg')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Chegg</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_k2_claims')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">K2 Claims</span>
							</a>
						</li>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Care.Com</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_care'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Email/Chat</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_care/billing'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Billing</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_care/buc'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">BUC</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_care/care_member'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Care Member</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_stifel')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Stifel</span>
							</a>
						</li>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">AJIO</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ajio'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Voice</span>
									</a>
								</li>
								<li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ajio/ajio_email'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Email</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ajio/ajio_chat'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Chat</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ajio/ajio_ccsr'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">AJIO CCSR</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_kiwi')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">KIWI</span>
							</a>
						</li>

					</ul>
				</li>

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-dns zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">ARM / Collections</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_vrs')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Vital Recovery Services</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_indiabulls')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">India Bulls</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_idfc')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">IDFC</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_msb')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">MSB Financial</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_freedom_financial')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">FREEDOM FINANCIAL</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_freedom_customer_service')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">FREEDOM CUSTOMER SERVICE</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_chariot')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">CHARIOT COLLECTIONS</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('Qa_chariot_energy')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">CHARIOT ENERGY</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('qa_varo')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Varo</span>
							</a>
						</li>
					</ul>
				</li>

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-dns zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Sales</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Home Advisor</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_homeadvisor'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Home Advisor</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_homeadvisor/qa_hcco_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">HCCO</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_homeadvisor/hcci'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">HCCI</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_homeadvisor/bcci'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">BCCI</span>
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
							<a href="<?php echo base_url('Qa_craftjack')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Craftjack</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_norther_tools_equipment')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Norther Tools & Equipment scorecard</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_park_west')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Park West</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_epgi')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">EPGI</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_ayming')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">AYMING</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_union_pacific')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Union Pacific</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_sea_world')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Sea World</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_kabbage')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Kabbage</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_doubtnut')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Doubtnut</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_hsdl')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">HSDL</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_fiberconnect')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Fiber Connect</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_magnilife'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">MAGNILIFE</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_srl')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">SRL Diagnostic</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_ltfs')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">LTFS</span>
							</a>
						</li>
					</ul>
				</li>

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-dns zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Lead Generation</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Verso</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_verso'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Customer Care Audit</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_verso/qa_verso_ob_fc_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Full Call Audit</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_verso/qa_verso_ob_sc_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Special Call Audit</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>

				<?php } ?>


				<?php if((isADLocation()==true || is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true) && get_user_office_id()!="CHA"){ ?>
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-dns zmdi-hc-lg"></i></span>
						<span class="menu-text foldable" style="font-size:12px">Sales & Customer Service</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<?php if(isADLocation()==false){ ?>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">OYO</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_oyo'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">International</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_oyo_rca/oyo_rca_feedback_review'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">RCA International</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_oyo_sig/qaoyo_management_sorting_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">SIG</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_oyosig_rca'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">DSAT RCA SIG</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_oyo_sig/oyo_sig_chat'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">SIG Chat</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_oyosig_rca/qa_sme_rca_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="" style="font-size:12px">Social Media RCA SIG</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_oyo_life'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">LIFE IB/OB</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_oyo_life/qa_oyolife_followup_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">LIFE FollowUp</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_oyo_life/qa_oyolife_booking_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">LIFE BOOKING</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_oyo/oyo_uk_us'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">UK / US</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_oyoinb'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">INBOUND</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_oyo/oyo_wallet_recharge'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">SECURE WALLET RECHARGE</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_oyo/oyo_esal'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">OYO ESAL</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_jurys_inn')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Leonardo Hotels</span>
							</a>
						</li>
						<!--<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Jurys Inn</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Reservations</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn/jurysinn_ME_cis'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Meets</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn/jurysinn_stag_hen'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Stag & Hen</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn/jurysinn_input_cis_gds'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">GDS</span>
									</a>
								</li>
								-->

								<!--<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Revised CIS</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn/jurysinn_email'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Res CIS Email</span>
									</a>
								</li>-->
								<!--<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn/jurysinn_ME_cis'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">M&E CIS Evaluation</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn/jurys_inn_meCis'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">M&E CIS Email & Voice Evaluation</span>
									</a>
								</li>-->
								<!--<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn/jurysinn_stag_hen'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Stag & Hen</span>
									</a>
								</li>-->
								<!--<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn/jurysinn_input_cis_gds'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CIS Inputting</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_jurys_inn/jurysinn_gds_prearrival'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">GDS & Pre Arrival</span>
									</a>
								</li>-->
							<!--</ul>
						</li>-->
						<li class="menu-item">
							<a href="<?php echo base_url('qa_docusign')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">DocuSign</span>
							</a>
						</li>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Ideal Living</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_ideal_living'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Sales</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_ideal_living/il_cs'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Customer Service</span>
									</a>
								</li>
							</ul>
						</li>

						<?php } ?>

						<?php if(isADLocation()==true || is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Ameridial Commercial</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Fortune Builder</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/purity_bottle/'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Purity Free Bottle</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/purity_catalog/'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Purity Catalog</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/purity_care/'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Purity Care</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/conduent'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Conduent</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/hoveround_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Hoveround</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/ncpssm_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">NCPSSM</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/stc_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">STC Scoresheet</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/touchfuse'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">TOUCHFUSE</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/tbn_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">TBN</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/jfmi_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">JFMI</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/tpm_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">TPM</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/aspca'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">ASPCA</span>
									</a>
								</li>
								<!-- <li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/ffai'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">FilterFast AIF</span>
									</a>
								</li> -->
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/patchology_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Patchology</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/lifi'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Life Quote(LIFI)</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/heatsurge_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Heat Surge</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/stauers_sales'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Stauers Sales</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/operation_smile'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Operation Smile</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/tactical_5_11'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">5-11 Tactical</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/jmmi'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">JMMI</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/icario'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Icario</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/qpc'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">QPC</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/ancient_nutrition'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Ancient Nutrition</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/power_fan'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Power Fan</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_ameridial/non_profit')?>" class="menu-link">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Ameridial Non-Profit</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/blains'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">BLAINS</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/pajamagram'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">PAJAMAGRAM</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/brightway'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Brightway</span>
									</a>
								</li>
								<!-- <li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_brightway_evaluation'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Brightway Evaluation</span>
									</a>
								</li> -->
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/foodsaver'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Food Saver</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/sas'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">SAS</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/gap'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">GAP</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/sfe'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">SFE</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/suarez'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Suarez</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/purity_conscious_selling'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Conscious Selling</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/mpc'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">MPC</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/empire'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Empire</span>
									</a>
								</li>
								<!-- <li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/cinemark'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Cinemark</span>
									</a>
								</li> -->
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/cmn'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CMN</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/pilgrim'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Pilgrim</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/compliance'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Compliance</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/ways2well'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Ways-2-Well</span>
									</a>
								</li>
									<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/qa_kenny_u_pull'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">American Iron Metal</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Ameridial Healthcare</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/sabal'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">SABAL</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/curative'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CURATIVE</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/episource'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">EPISOURCE</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/air_method'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Air Method</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/delta'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="" style="font-size:12px">DELTA DENTAL [Illinois]</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/delta_dental_iowa'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="" style="font-size:12px">DELTA DENTAL [IOWA]</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/trapollo'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">TRAPOLLO</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/sontiq'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Sontiq</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/hcpss'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">HCPSS </span>
									</a>
								</li>


								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/bluebenefits'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Blue Benefits </span>
									</a>
								</li>

								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/healthBridge'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Health Bridge </span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/mcKinsey'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">McKinsey</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_affinity'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Affinity</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/cci_medicare'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CCI Medicare</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/cci_commercial'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CCI Commercial</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_ameridial/lockheed'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Lockheed Martin</span>
									</a>
								</li>


							</ul>

						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_ameridial/follet')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">FOLLET</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_zovio_follet')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">ZOVIO</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_ameridial/nuwave'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">NuWave</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('Qa_ideal_living/mercy')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">MERCY SHIP</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('Qa_cars24')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Cars24</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('Qa_cinemark')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Cinemark</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('Qa_ffai')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">FilterFast AIF</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('Qa_att')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">AT&T</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_acc')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">ACC</span>
							</a>
						</li>
						
						<!--<li class="menu-item">
							<a href="<?php echo base_url('Qa_attverint')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">AT&T VERINT</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_attflorida')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">AT&T FLORIDA</span>
							</a>
						</li>-->
						<?php } ?>

					</ul>
				</li>
				<?php } ?>

				<?php if(isADLocation()==false && get_user_office_id()!="CHA"){ ?>
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-dns zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Others</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li class="menu-item">
							<a href="<?php echo base_url('qa_belmont/qa_feedback')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Belmont</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_argel/qa_feedback')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">ARGEL</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_ossur/qa_feedback')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Ossur</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_att/fiberconnect')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">ATT Fiberconnect</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?= base_url("qa_avon")?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Avon</span>
							</a>
						</li>

<!--- added for wireless--->

						<li class="menu-item">
							<a href="<?php echo base_url('qa_wireless_dna'); ?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Wiress DNA</span>
							</a>
						</li>


<!--- end for wireless--->

<!--- added for wireless--->

						<li class="menu-item">
							<a href="<?php echo base_url('qa_cesc'); ?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">CESC</span>
							</a>
						</li>


<!--- end for wireless--->






<!--- added for wireless--->

<li class="menu-item">
							<a href="<?php echo base_url('qa_intelycare'); ?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Intelycare</span>
							</a>
						</li>


<!--- end for wireless--->
<li class="menu-item">
							<a href="<?php echo base_url('qa_redeo'); ?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Redeo</span>
							</a>
						</li>
<!--- added for wireless--->

<li class="menu-item">
							<a href="<?php echo base_url('qa_epoch'); ?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Epoch</span>
							</a>
						</li>


						<li class="menu-item">
							<a href="<?php echo base_url('qa_arvind'); ?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Arvind</span>
							</a>
						</li>





						<li class="menu-item">
							<a href="<?php echo base_url('qa_ash_maples'); ?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Ash Maples</span>
							</a>
						</li>

<!--- end for wireless--->




<!--- added for Squad Stack--->

<li class="menu-item">
							<a href="<?php echo base_url('Qa_cq_squad_stack'); ?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class=""> Squad Stack</span>
							</a>
						</li>


<!--- end for Squad Stack--->

<!--- added for Romtech-->

<li class="menu-item">
							<a href="<?php echo base_url('qa_romtech'); ?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class=""> RomTech</span>
							</a>
						</li>


<!--- end for romtech-->



						<li class="menu-item">
							<a href="<?= base_url("qa_safe_eco")?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Safe Eco</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?= base_url("qa_tvs")?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">TVS</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?= base_url("Qa_credit_mantri")?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Credit Mantri</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?= base_url("qa_myglam")?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Sanghvi Beauty and Technologies</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?= base_url("qa_premium")?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Premium Choice Insurance Services</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?= base_url("qa_cloudflare")?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Cloudflare</span>
							</a>
						</li>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Welcome Pickup</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_welcomepickup/call_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Calls</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_welcomepickup/ticket_feedback'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Tickets</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_biomet')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Biomet</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_cholamandlam')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Cholamandlam</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_lcn')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">LCN Call</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_ameridial_recruitment')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Ameridial Recruitment</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_gtn')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">GTN Technical Staffing</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_vision_canada')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">World Vision Canada</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_comcast')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Comcast Sales</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_grid_aifi')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Grid AIFI</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_paytail')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Paytail</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_pinelabs')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Pine Labs</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_smileimpress')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Smile To Impress</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_mobikwik')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Mobikwik</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_maalomatia')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Maalomatia</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_heaps')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Heaps</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_coastline')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Coastline</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_actyvAI')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Actyv AI</span>
							</a>
						</li>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Checkpoint</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_checkpoint'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Chat</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_checkpoint_email'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Email</span>
									</a>
								</li>
							</ul>
						</li>
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
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_rugdoctor')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">RugDoctor</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_novasom')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Bioserenity</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_sxc')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">SXC</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_ibuumerang')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Ibuumerang</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_layway')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Layaway Depot</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_outsource_order')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Outsourced Order Capture Evaluation</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_viberides')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Viberides</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_sensio')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Sensio</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_vfs')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">VFS</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_us_da')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">US Directory Assistance</span>
							</a>
						</li>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">CarParts</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_service'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CarParts-Service</span>
									</a>
								</li>

								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_sales_carpart'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CarParts-SALES</span>
									</a>
								</li>

							</ul>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('qa_zoomcar')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Zoom Car</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_itel')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">ITEL</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_alpha')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">AGE</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_keeper')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">KEEPER</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_virtuox')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">VIRTUOX</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_phs')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Premier Health Solution</span>
							</a>
						</li>
						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Casablanca</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_alteras'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">Alteras</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_grille'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CHÂTEAU D'EAU</span>
									</a>
								</li>
								<!--<li>
									<a style="padding-left:50px" href="<?php //echo base_url('Qa_flv'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">FLV</span>
									</a>
								</li>-->
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_cati'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CATI</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_arabophone'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">ARABOPHONE</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_nordnet'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">NORDNET Customer Satisfaction Monitoring</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_schoolonline'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">SCHOOL ONLINE</span>
									</a>
								</li>
								<!--<li>
									<a style="padding-left:50px" href="<?php //echo base_url('Qa_collecte'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">COLLECTE DAYDREAMS SALES</span>
									</a>
								</li>-->
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_creditsafe'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CREDIT SAFE</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_carddata'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">CAR DATA</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('Qa_solucia'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">SOLUCIA</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_grille_evaluation'); ?>">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">TREVI POOLS</span>
									</a>
								</li>
								<li>
									<a style="padding-left:50px" href="<?php echo base_url('qa_daydreams')?>" class="menu-link">
										<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
										<span class="">DAY DREAMS</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_telaid')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">TELAID</span>
							</a>
						</li>
						<!-- <li class="menu-item">
							<a href="<?php echo base_url('Qa_awareness')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">AWARENESS TECHNOLOGY</span>
							</a>
						</li> -->

						<li class="menu-item has-submenu">
							<a href="" class="menu-link submenu-toggle">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">AWARENESS TECHNOLOGY</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url('Qa_awareness')?>">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">AWARENESS TECHNOLOGY OLD</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url('Qa_awareness_new')?>">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">AWARENESS TECHNOLOGY NEW</span>
							</a>
						</li>


					</ul>
				</li>



						<li class="menu-item">
							<a href="<?php echo base_url('Qa_edutech')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">CUEMATH</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_edutech/lido')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">LIDO</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_edutech/queens_english')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Queens English</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_edutech/beyondskool')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Beyondskool</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_sycn')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Ship Your Car Now</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_ameridial/qpc_esal')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">QPC ESAL</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_loanxm')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Debt Solution 123</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_clio')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">CLIO</span>
							</a>
						</li>

						<li class="menu-item">
							<a href="<?php echo base_url('qa_netmeds')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Netmeds</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_stratus')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Stratus</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('groupe_france_assur')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Groupe France Assur</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_associate_materials')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Associate Materials</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_sentient_jet')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Sentient Jet</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_one_assist')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">One Assist</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_bounce_infinity')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Bounce Infinity</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_bsnl')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">BSNL</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_lead')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Lead School</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_dunzo')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">DUNZO</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_nurture')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Nurture Farms</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_india_moe')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">India Moe</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_revive_rx')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Revive Rx</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_ameriflex')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Ameriflex</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_smartflats')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Smartflats</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_mba_voice')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Merchants Benefit Administration</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_avanse')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Avanse</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_acg')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Updater</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_credit_pro')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Credit Pro</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_octafx')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">OctaFX</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('qa_pinglend')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Pinglend</span>
							</a>
						</li>

					</ul>
				</li>


				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">QA as a Service</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('Qa_unacademy'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Unacademy</span>
							</a>
						</li>
					</ul>
				</li>

				<?php } ?>

				<li class="menu-item">
					<a href="<?php echo base_url('Qa_agent_coaching')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Agent Coaching</span>
					</a>
				</li>

				<?php if(isIndiaLocation(get_user_office_id())==true){ ?>
					<li class="menu-item">
						<a href="<?php echo base_url('Qa_hygiene')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-shield-check zmdi-hc-lg"></i></span>
							<span class="">Hygiene</span>
						</a>
					</li>
				<?php } ?>



			<?php } ?>

			<!-------------------------------->
			<?php if(((is_access_qa_module()==true || is_access_qa_operations_module()==true) && get_user_office_id()=="CHA") || get_global_access()=='1' || get_user_fusion_id()=='FKOL000023' || get_user_fusion_id()=='FBLR000155'){ ?>
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">CSPL</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('Qa_huda')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Huda</span>
							</a>
						</li>
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('Qa_ftpl'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">FTPL</span>
							</a>
						</li>
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('Qa_indiamart'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">INDIAMART</span>
							</a>
						</li>
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('Qa_indiabulls')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">India Bulls</span>
							</a>
						</li>
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('qa_ajio'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">AJIO Voice</span>
							</a>
						</li>
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('qa_ajio/ajio_email'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">AJIO Email</span>
							</a>
						</li>
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('qa_ajio/ajio_chat'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">AJIO Chat</span>
							</a>
						</li>
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('qa_ajio/ajio_ccsr'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">AJIO CCSR</span>
							</a>
						</li>
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('qa_arvind'); ?>" >
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Arvind</span>
							</a>
						</li>
						<li>
							<a style="padding-left:50px" href="<?php echo base_url('Qa_cars24')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Cars24</span>
							</a>
						</li>
						<li class="menu-item">
							<a style="padding-left:50px" href="<?php echo base_url('qa_dunzo')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">DUNZO</span>
							</a>
						</li>
						<li class="menu-item">
							<a style="padding-left:50px" href="<?php echo base_url('qa_nurture')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Nurture Farms</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?= base_url("Qa_credit_mantri")?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Credit Mantri</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_actyvAI')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Actyv AI</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_cholamandlam')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Cholamandlam</span>
							</a>
						</li>
						<li class="menu-item">
							<a style="padding-left:50px" href="<?php echo base_url('Qa_unacademy'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Unacademy</span>
							</a>
						</li>
						<li class="menu-item">
							<a style="padding-left:50px" href="<?php echo base_url('Qa_oyo_sig/qaoyo_management_sorting_feedback'); ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">SIG</span>
							</a>
						</li>
					</ul>
				</li>
			<?php } ?>
			<!-------------------------------->

			<!------------ IT Help Desk --------------->
				<?php if(is_access_qa_module()==true && is_access_qa_agent_module()==false){ ?>
					<li class="menu-item">
						<a href="<?php echo base_url('Qa_it_helpdesk_feedback')?>" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">IT Helpdesk</span>
						</a>
					</li>
				<?php }
					if(get_role_dir()=='agent' && get_dept_id()==2){ ?>
						<li class="menu-item">
							<a href="<?php echo base_url('Qa_it_helpdesk_feedback')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="">Your Audit</span>
							</a>
						</li>
				<?php } ?>
			<!----------------------------->


				<!--<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle  submenu-toggle1">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Test Main</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Menu 1</span>
							</a>
						</li>
						<li class="menu-item has-submenu1 parent open">
							<a href="" class="menu-link submenu1-toggle parent" >
								<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
								<span class="menu-text foldable">Sub Test Main</span>
								<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
							</a>
							<ul class="submenu1">
								<li>
									<a style="padding-left:50px" href="">
									<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
									<span class="">Hello</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li> -->

			</ul>

		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->

<?php } ?>


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
