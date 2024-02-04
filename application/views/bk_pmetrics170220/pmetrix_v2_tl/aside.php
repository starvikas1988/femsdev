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
				<?php
				if( get_role_dir() == "super" || get_global_access()=='1' || is_access_ba_design() == true ) {
				?>
				
				<li class="menu-item">
					<a href="<?php echo base_url()?>Pmetrix_v2_management" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="">Management View</span>
					</a>
				</li>
				
				<?php
				}
				?>
				<li class="menu-item">
					<a href="<?php echo base_url('Pmetrix_v2_tl')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="">Agent View</span>
					</a>
				</li>
				<li class="menu-item">
					<a href="<?php echo base_url('Pmetrix_v2_tl/tl')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="">TL View</span>
					</a>
				</li>
			  </ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->