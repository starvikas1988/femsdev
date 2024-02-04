<!-- APP ASIDE ==========-->
<aside id="app-aside" class="app-aside left light">
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			
				<ul class="aside-menu aside-left-menu">                      
				 <?php if(get_global_access()=='1' || get_dept_folder()=="hr" || it_assets_access() == true){ ?>                                   
					<li class="menu-item">
						<a href="<?php echo base_url() ?>bgv" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">View BGV</span>
						</a>
					</li>
				<?php } if(get_global_access()=='1' || get_dept_folder()=="hr"){ ?>
					
					<li class="menu-item">
						<a href="<?php echo base_url() ?>bgv/update" class="menu-link">
							<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
							<span class="">Update BGV</span>
						</a>
					</li>
					<?php } ?>  
					
				</ul>
				
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->