<?php
$classnow = "style='background-color:#3cc3b5;color:#fff;font-weight:600;font-size:11px'";
$classactive = "style='color:#888181;font-weight:600;border-right:1px solid #eee;font-size:11px'";
if($urlSection == 'form' && !empty($crmid)){ $urlSection = "personal"; }
if(in_array($urlSection, $mysections)){
?>
<div class="wrap">
<ul class="nav nav-tabs" style="background:#fff">
<?php foreach($mysections as $eachsection){ 

//$linkURL = "#";
$linkURL = base_url('contact_tracing_crm/form/'.$crmid.'/'.$eachsection);
if($urlSection == $eachsection){ $linkURL = base_url('contact_tracing_crm/form/'.$crmid.'/'.$eachsection); }
?>  
  <li class="nav-item" <?php echo (($urlSection == $eachsection))? $classnow : $classactive; ?>>
  <a class="nav-link"  onclick="<?php echo $extraFormCheck; ?>" href="<?php echo $linkURL; ?>" <?php echo (($urlSection == $eachsection))? $classnow : $classactive; ?>><?php echo ucwords($eachsection); ?></a></li>
<?php } ?>  
 </ul>
</div>
<?php } ?>