<!-- APP ASIDE ==========-->

<aside id="app-aside" class="app-aside left light">
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
				<?php
					if(get_global_access() == 1)
					{
				?>
						<li class="menu-item">
							<a href="<?php echo base_url('faq/category')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
								<span class="">FAQ Category</span>
							</a>
						</li>
				<?php
					}
				?>
				<?php
					if(get_global_access() == 1)
					{
				?>
						<li class="menu-item">
							<a href="<?php echo base_url('faq/faq_message')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
								<span class="">FAQ Message</span>
							</a>
						</li>
				<?php
					}
				?>
				<?php
					/* if(get_global_access() == 1)
					{ */
				?>
						<li class="menu-item">
							<a href="<?php echo base_url('faq/faqs')?>" class="menu-link">
								<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
								<span class="">FAQ's</span>
							</a>
						</li>
				<?php
					/* } */
				?>
				
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->