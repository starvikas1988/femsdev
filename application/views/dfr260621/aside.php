<!-- APP ASIDE ==========-->

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
					<a href="<?php echo base_url()?>dfr" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">Requisition</span>
					</a>
				</li>
				
				
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/assigned_interviewer" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">Interviewer</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/pending_candidate" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">Pending Candidates</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/inprogress_candidate" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">In progress Candidates</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/shortlisted_candidate" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">Shortlisted Candidates</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/selected_candidate" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">Selected Candidates</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/rejected_candidate" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">Rejected Candidates</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/dropped_candidate" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">Dropped Candidates</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/all_candidate_lists" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">All Candidates List</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/pool_requisition" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">Fusion Pool</span>
					</a>
				</li>
				
				
				<?php if(get_dept_folder()=="hr" || get_global_access()=="1"){ ?>
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/handover_dfr_requisition" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">Handover & Closed</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url()?>dfr/bench_user_list" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">Bench User</span>
					</a>
				</li>
				<?php } ?>
				
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->