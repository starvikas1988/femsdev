
<div class="tabs-widget1">
		<div class="tabs-widget">
			<div class="body-widget">
				<ul class="nav nav-pills">
									
				<?php 
				$sl=0;
				foreach($asideEmails as $token){ 
					$sl++;
					$page_type = !empty($page_type) ? $page_type : "ticket_list";
					$myMailBox = explode(',', $ematCounters['myMailBox']);
					
					$showMailBox = false;
					if(in_array($token['email_id'], $myMailBox)){ $showMailBox = true; }
					if($email_id == $token['email_id']){ $showMailBox = true; }
					if(get_global_access() || e_manager_access() || e_rta_access()){ $showMailBox = true; }
						
					if($showMailBox == true){
						$unassignedCount = 0; $emat_badgeClass = "success";
						if(!empty($ematCounters['mailBoxCounters'][$token['email_id']])){ 
							$unassignedCount = $ematCounters['mailBoxCounters'][$token['email_id']]['total']; 
							$emat_badgeClass = "danger";  
						}
						if(!empty($my_page_type) && $my_page_type == "individual"){ 
						    $unassignedCount = 0; 
							if(!empty($my_emat_counters[$token['email_id']])){ 
								$unassignedCount = $my_emat_counters[$token['email_id']]['total']; 
								$emat_badgeClass = "danger";  
							}
						}
				?>
					<li class="nav-item">
					  <a class="nav-link <?php echo $email_id == $token['email_id'] ? "active" : ""; ?>" href="<?php echo base_url('emat/'.$page_type.'/'.bin2hex($token['email_id'])); ?>">
						<?php echo $token['email_name']; ?> <?php if($unassignedCount > 0){ ?><label class="badge badge-<?php echo $emat_badgeClass; ?>"><?php echo $unassignedCount; ?></label><?php } ?>
					  </a>
					</li>
					
				<?php } } ?>
				</ul>
			</div>
		</div>
	</div>
	
	
	<!--
	<div class="tabs-widget1">
		<div class="tabs-widget">
			<div class="body-widget">
				<ul class="nav nav-pills">
				
					<li class="nav-item">
					  <a class="nav-link <?php echo empty($currentCat) ? "active" : ""; ?>" href="<?php echo base_url('emat/ticket_list/all'); ?>">
						All
					  </a>
					</li>
					
				<?php 
				/*$sl=0;
				foreach($ticketCategory as $token){ 
					$sl++;
				?>
					<li class="nav-item">
					  <a class="nav-link <?php echo $currentCat == $token['category_code'] ? "active" : ""; ?>" href="<?php echo base_url('emat/ticket_list/'.$token['category_code']); ?>">
						<?php echo $token['category_name']; ?>
					  </a>
					</li>
					
				<?php } */ ?>
				</ul>
			</div>
		</div>
	</div>
	-->