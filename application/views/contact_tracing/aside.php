<!-- APP ASIDE ==========-->

<aside id="app-aside" class="app-aside left light">
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<!--<ul class="aside-menu aside-left-menu">
			
			<?php 
			$sectionCheck = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 
		                           'exposure', 'transmission', 'risk', 'aftercase', 'investigation', 'contacts');
								   
			if(!empty($crm_treatment)){ 
				if($crm_treatment != 'Y'){
					$sectionCheck = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes');
					$mysections = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes');
					if(!empty($crmdetails['a_is_outbreak_related'])){ 
					if($crmdetails['a_is_outbreak_related'] == 'N'){
						$sectionCheck = array('personal', 'administrative', 'notes');
						$mysections = array('personal', 'administrative', 'notes');
					}}
				}				
			}
			
			if((!empty($crmdetails['ongoing_status']) && $crmdetails['ongoing_status'] == 'P') || (!empty($crmrow) && $crmrow['ongoing_status'] == 'P'))
			{
				$sectionCheck = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 
		                           'exposure', 'transmission', 'risk', 'aftercase', 'investigation', 'contacts');
				$mysections = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 'exposure', 'risk', 'aftercase');
				if(!empty($crmdetails['a_is_outbreak_related'])){ 
				if($crmdetails['a_is_outbreak_related'] == 'N'){
					$sectionCheck = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 'exposure', 'risk', 'aftercase');
					$mysections = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 'exposure', 'risk', 'aftercase');
				}}
			}
			
					
			
			$extraFormCheck = "";
			if(($this->uri->segment(2) == 'form') && (!empty($this->uri->segment(3))) && (in_array($this->uri->segment(4), $sectionCheck))){
				$extraFormCheck = "return confirm('Are you sure you want to exit the form? All unsaved form changes will be lost? Click ok to exit or click cancel to continue with form?')";
			}
			?>
				
				<?php if(in_array($uri, $mysections)){ ?>
				<li class="menu-item open">
					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Contact Tracing</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					
					<ul class="submenu" style="display:block">
					
						
                        <?php foreach($mysections as $eachsection){ ?>  						
						<li>
							<a class="menu-link active" href="<?php echo base_url('covid_case/form/'.$crmid.'/'.$eachsection); ?>" onclick="<?php echo $extraFormCheck; ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class=""><?php echo ucwords($eachsection); ?></span>
							</a>
						</li>
						<?php } ?>
						
					</ul>
						
				</li>
				<?php } ?>
				
							
				</ul>-->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->