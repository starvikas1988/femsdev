<?php if(empty($personal_row) || $personal_row['is_update_family_info']==0){ ?>

<style>
.customRibbonCount {
  position: absolute;
  line-height: 1.5;
  padding: 5px 10px;
  width: 30px;
  top: -3px;
  left: 2px;
  text-align: center;
  transform-origin: 50% 50%;
  box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.3);
  border-radius: 40px;
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

<div class="row" style="margin-bottom:2px;">
<div class="col-md-12">
<a href="<?php echo base_url('profile/family/'.$prof_fid); ?>">
<div class="widget widgetRibbonLD" style="border-radius: 3px; cursor:pointer;">
	<header class="widget-header">
		<div class="widget-title" style="color:darkblue; font-size:16px; text-align:center;">
		  Update Your Family Info
		</div>
	</header>
</div>
</a>
</div>
</div>
<?php } ?>