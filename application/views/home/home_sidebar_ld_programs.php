<style>
.customRibbon {
  position: absolute;
  line-height: 1.5;
  padding: 0 1rem;
  width: 160px;
  top: 10px;
  left: -50px;
  text-align: center;
  transform-origin: 50% 50%;
  transform:rotateZ(-39deg);
  box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.3);
}
.widgetRibbonLD{
	background: rgb(238,174,202);
	background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);
}
.widgetRibbonLD:hover{
	background: rgb(238,174,202);
	background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgb(174 60 60) 100%)!important;
}
</style>

<?php if(!empty($ld_assigned_courses)){ ?>
<div class="row" style="margin-bottom:2px;overflow:hidden">
<div class="col-md-12">
<?php //foreach($ld_assigned_courses as $ld_token){ ?>
<a href="<?php echo base_url('ld_programs/new_registration'); ?>">
<div class="widget widgetRibbonLD" style="border-radius: 3px; cursor:pointer;">
	<div class="customRibbon bg-danger">Register</div>
	<header class="widget-header">
		<div class="widget-title" style="color:darkblue; font-size:16px; text-align:center;">
		<?php echo count($ld_assigned_courses); ?> L&D Course Available <i class="fa fa-graduation-cap"></i>
		</div>
	</header>
</div>
</a>
<?php //} ?>
</div>
</div>
<?php } ?>