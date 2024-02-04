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
						<a href="<?php echo base_url()?>bcp_survey" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
							<span class="">BCP Survey</span>
						</a>
					</li>

					<?php if(get_user_fusion_id()=='FKOL000001' || get_user_fusion_id()=='FKOL000004'){ ?>
						<li class="menu-item">
							<a href="<?php echo base_url()?>bcp_survey/bcp_list" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
								<span class="">BCP Survey List</span>
							</a>
						</li>
					<?php } ?>
				
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->