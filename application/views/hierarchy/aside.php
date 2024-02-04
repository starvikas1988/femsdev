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
if(!isset($_SESSION['pmenu'])){
   $pmenu="1";
} else {
    $pmenu=$_SESSION['pmenu'];
}
if ($pmenu=='1') $act1="active";
else if ($pmenu=='2') $act2="active";
else if ($pmenu=='3') $act3="active";

?>
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
					<a href="<?php echo base_url('hierarchy')?>/myupteam" class="menu-link <?php echo $act3;?>">
						<span class="menu-icon"><i class="zmdi zmdi-accounts-outline zmdi-hc-lg"></i></span>
						<span class="">My Hierarchy</span>
					</a>
				</li>
				
			</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->