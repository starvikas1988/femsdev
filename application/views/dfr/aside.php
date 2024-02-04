<!-- APP ASIDE ==========-->
<aside id="app-aside" class="app-aside left light sidebar_main">
	<!--start new sidebar implementation-->
	<div class="sidebar_box">
		<div id="sidebar-menu">
			<ul class="metismenu" id="sidebar_menu">
				<li>
					<a href="#">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/interview_process.svg" class="sidebar_icon" alt="">
						<span>Interview Process</span>
						<span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url() ?>dfr" aria-expanded="true">
								<span>Requisition</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url() ?>dfr/assigned_interviewer" aria-expanded="true">
								<span>Interviewer</span>
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/interview_status.svg" class="sidebar_icon" alt="">
						<span>Candidates</span>
						<span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url() ?>dfr/all_candidate_lists" aria-expanded="true">
								<span>View All</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url() ?>dfr/pending_candidate" aria-expanded="true">
								<span>Pending</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url() ?>dfr/inprogress_candidate" aria-expanded="true">
								<span>In Progress</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url() ?>dfr/shortlisted_candidate" aria-expanded="true">
								<span>Shortlisted</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url() ?>dfr/selected_candidate" aria-expanded="true">
								<span>Selected</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url() ?>dfr/rejected_candidate" aria-expanded="true">
								<span>Rejected</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url() ?>dfr/dropped_candidate" aria-expanded="true">
								<span>Dropped</span>
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/support_pool.svg" class="sidebar_icon" alt="">
						<span>Support Pool</span>
						<span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url() ?>dfr/pool_requisition" aria-expanded="true">
								<span>Fusion Pool</span>
							</a>
						</li>
						<?php if (get_dept_folder() == "hr" || get_global_access() == "1") { ?>
						<li>
							<a href="<?php echo base_url() ?>dfr/bench_user_list" aria-expanded="true">
								<span>Bench User</span>
							</a>
						</li>
						<?php } ?>
					</ul>
				</li>
				<li>
					<a href="<?php echo base_url() ?>dfr/employee_referral_list">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/employee_refferral.svg" class="sidebar_icon" alt="">
						<span>Employee Referrals</span>
					</a>
				</li>
				<?php if (get_dept_folder() == "hr" || get_global_access() == "1") { ?>
				<li>
					<a href="<?php echo base_url() ?>dfr/handover_dfr_requisition">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/handover_closed.svg" class="sidebar_icon" alt="">
						<span>Handover & Closed</span>
					</a>
				</li>
				<?php } ?>
				<li>
					<a href="#">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/other.svg" class="sidebar_icon" alt="">
						<span>Others</span>
						<span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
					</a>
					<ul class="submenu">
						<?php if (get_dept_folder() == "hr" || get_global_access() == "1") { ?>
							<li>
								<a href="<?php echo base_url() ?>dfr/master_mis" aria-expanded="true">
									<span>Master Mis Report</span>
								</a>
							</li>
						<?php } ?>
						<?php if(get_user_fusion_id() == 'FKOL015609' || get_user_fusion_id() == 'FKOL000007' || get_user_fusion_id() == 'FKOL007187'){ ?>
						<li>
							<a href="<?php echo base_url() ?>Dfr_move_doc/move_doc" aria-expanded="true">
								<span>Move Doc</span>
							</a>
						</li>
						<?php } ?>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!--end new sidebar implementation-->

</aside>
<!--========== END app aside -->