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
<?php
$pmenu="";
$act1="";
$act2="";
$act3="";
$act4="";
$act5="";
$act6="";
if(!isset($_SESSION['pmenu'])){
   $pmenu="1";
} else {
    $pmenu=$_SESSION['pmenu'];
}
if ($pmenu=='1') $act1="active";
else if ($pmenu=='2') $act2="active";
else if ($pmenu=='3') $act3="active";
else if ($pmenu=='4') $act4="active";
else if ($pmenu=='5') $act5="active";
else if ($pmenu=='6') $act6="active";
else if ($pmenu=='8') $act8="active";

?>
<aside id="app-aside" class="app-aside left light">	
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
				
				<li class="menu-item">
					<a href="<?php echo base_url('egaze/individual') ?>" class="menu-link <?php echo $act1;?>">
						<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
						<span class="">My Activities</span>
					</a>
				</li>
				
				<?php if( get_role_dir()!="agent" ||  isAccessEGazeReport()==true || isAccessGlobalEGaze()==true ) { ?>
					
				<li class="menu-item">
					<a href="<?php echo base_url('egaze/dashboard') ?>" class="menu-link <?php echo $act2;?>">
						<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
						<span class="">Dashboard</span>
					</a>
				</li>
				
				
				
				<li class="menu-item">
					<a href="<?php echo base_url('egaze/realtime')?>" class="menu-link <?php echo $act3;?>">
						<span class="menu-icon"><i class="fa fa-bar-chart"></i></span>
						<span class=""> Your Team (Realtime)</span>
					</a>
				</li>
												
				<li class="menu-item">
					<a href="<?php echo base_url('egaze/reports') ?>" class="menu-link <?php echo $act4;?>">
						<span class="menu-icon"><i class="fa fa-dashboard"></i></span>
						<span class="">Report</span>
					</a>
				</li>
				
				<?php if(get_global_access() == 1 || get_role_dir()=="admin" || isAccessGlobalEGaze()==true || isAccessEGazeReport()==true ){ ?>
				<li class="menu-item">
					<a href="<?php echo base_url('egaze/download_reports') ?>" class="menu-link <?php echo $act5;?>">
						<span class="menu-icon"><i class="fa fa-calendar"></i></span>
						<span class="">Download Raw Data</span>
					</a>
				</li>
				
				<!--<li class="menu-item">
					<a href="<?php echo base_url('egaze/config')?>" class="menu-link <?php echo $act6;?>">
						<span class="menu-icon"><i class="fa fa-cog"></i></span>
						<span class="">Config</span>
					</a>
				</li>-->
				
				<li class="menu-item open">
					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-cog"></i></span>
						<span class="menu-text foldable">Config</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					
					<ul class="submenu" style="display:block">
						
						<li>
							<a  href="<?php echo base_url()?>egaze/config/productive">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Productive Apps</span>
							</a>
						</li>
						
						<li>
							<a  href="<?php echo base_url()?>egaze/config/noncompliance">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Non Compliance Apps</span>
							</a>
						</li>
						
					</ul>
						
				</li>
				
				<?php } ?>
				
				<?php } ?>
				
			</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->