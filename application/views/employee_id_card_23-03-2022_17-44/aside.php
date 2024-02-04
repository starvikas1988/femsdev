<!-- APP ASIDE ==========-->
<style>
.app-aside.light .aside-menu .active{
	color:#188ae2;
}

aside{
	scrollbar-width: thin;
	overflow: auto;
}
</style>
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
					<a href="<?php echo base_url('employee_id_card/card')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
						<span class="">New ID Card</span>
					</a>
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url('employee_id_card/id_card_request/all')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
						<span class="">My Request List</span>
					</a>
				</li>
				
				<?php if(get_role_dir() !='agent'){?>
				
				<li class="menu-item">
					<a href="<?php echo base_url('employee_id_card/id_card_request/pending')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
						<span class="">Team Pending Approvals</span>
					</a>
				</li>
				
				<?php 
				}
				if(is_access_id_card_module()==true){
				?>
				
				<li class="menu-item open">
					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">ID Card List</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
				
				<ul class="submenu" style="display:block">
						
					<li>
						<a  href="<?php echo base_url('employee_id_card/id_card_list/approved')?>">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Approved List</span>
						</a>
					</li>
					
					<li>
						<a  href="<?php echo base_url('employee_id_card/id_card_list/printing')?>">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Printing Queue</span>
						</a>
					</li>
					
					<li>
						<a  href="<?php echo base_url('employee_id_card/id_card_list/distribute')?>">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Printed List</span>
						</a>
					</li>
					
					<li>
						<a  href="<?php echo base_url('employee_id_card/id_card_list/handover')?>">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">HR List</span>
						</a>
					</li>
					
					<li>
						<a  href="<?php echo base_url('employee_id_card/id_card_list/complete')?>">
							<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
							<span class="">Handover List</span>
						</a>
					</li>
					
				</ul>
				
				</li>
				
				<li class="menu-item">
					<a href="<?php echo base_url('employee_id_card/id_card_request/all')?>" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
						<span class="">All ID Card List</span>
					</a>
				</li>
				
				<?php } ?>
				
			</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->