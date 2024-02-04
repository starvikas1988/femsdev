<div style='color:black;'>

	<div class='apps_grid'>
			<?php
				
				if(get_role_dir()!="agent" || get_global_access()=='1' ){

				if(get_global_access()=='1') $team_url = base_url()."super/dashboard/1";
				else if(get_dept_folder()=="hr") $team_url=base_url().'hr/dashboard/1';
				else $team_url = base_url().get_role_dir()."/dashboard";
					
			?>
			
			
			
			
			<div class="case-wrapper" title="Manage Your Team">
				<a  href="<?php echo $team_url;?>" >
				<div class="app-icon" style="background-color: #3498db" title="Manage Your Team">
				<i class="fa fa-users" title="Manage Your Team" aria-hidden="true" style=""></i>
				
				</div> 
				<div class="case-label ellipsis"> 
					<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
					<span class="case-label-text">
					<?php 
						if(get_role_dir()=="agent" && get_global_access()!='1' && get_dept_folder()!="hr") echo "Your Dashboard";
						else echo "Your Team";
					?>
					</span>
				</div>
				</a>
			</div>
			
			<?php
				}
			?>
			
			<div class="case-wrapper"  title="Profile">
				<a href="<?php echo base_url()?>profile" >
				<div class="app-icon" style="background-color: #1abc9c" title="Profile">
					<i class="fa fa-user" title="Profile" aria-hidden="true" style=""></i>
					</div> 
				<div class="case-label ellipsis"> 
					<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
					<span class="case-label-text">Your Profile</span>
				</div>
				</a>
			</div>
			
			<?php
				if(get_global_access()=='1' || get_dept_folder()=="hr" || get_role_dir()=="super" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_dept_folder()=="rta"){
					
					$ac_class="";
					$linkurl=base_url()."dfr";
			?>
			
								
			<div class="case-wrapper <?php echo $ac_class; ?>" title="Delivary Fullfilment Ratio">
				<a  href="<?php echo $linkurl;?>" >
				<div class="app-icon" style="background-color: #FF8C00" title="Delivary Fullfilment Ratio">
				<i class="fa fa-user-plus" title="Delivary Fullfilment Ratio" aria-hidden="true" style=""></i>
				
				</div> 
				<div class="case-label ellipsis"> 
					<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
					<span class="case-label-text">
						DFR
					</span>
				</div>
				</a>
			</div>
			
			<?php
				}
			?>
											
			<div class="case-wrapper" title="QA feedback">
				<a  href="<?php echo base_url()."uc";?>" >
				<div class="app-icon" style="background-color: #669999" title="QA feedback">
				<i class="fa fa-file-sound-o" title="QA feedback" aria-hidden="true" style=""></i>
				
				</div> 
				<div class="case-label ellipsis"> 
					<span class="case-label-text">
						QA Feedback
					</span>
				</div>
				</a>
			</div>
			
			
			<?php
			if(get_role_dir()!="agent" || get_global_access()=='1' ){
				$ac_class="";
				$linkurl=base_url()."reports";
			
			?>
								
			<div class="case-wrapper <?php echo $ac_class; ?>" title="Reports">
				<a  href="<?php echo $linkurl; ?>" >
					<div class="app-icon" style="background-color: #7578f6" title="Reports">
					<i class="fa fa-wpforms" title="Reports" style=""></i>
					
					</div> 
					<div class="case-label ellipsis"> 
						<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
						<span class="case-label-text">Reports</span>
					</div>
				</a>
			</div>
			
			<?php
				}
			?>
			
			<?php
			$ac_class = "";
							
			if(get_user_office_id()=="KOL" || get_user_office_id()=="BLR" || get_user_office_id()=="HWH" ) $linkurl=base_url()."leave/";
			else if(get_user_office_id()=="JAM") $linkurl="/jlp/";

			// Only for Neha Kallani - ALT/KOL
			
			else if(get_user_fusion_id() == 'FALT002231') $linkurl=base_url()."leave/leave_approval";
			else if(get_user_fusion_id() == 'FMON003955' || get_user_fusion_id() == 'FHIG000301') $linkurl=base_url()."leave/";
			else $linkurl=base_url()."uc";
						
			//echo get_user_fusion_id();
								
			?>
							
			<div class="case-wrapper <?php echo $ac_class; ?>" title="Leave">
				<a href="<?php echo $linkurl; ?>" >
				<div class="app-icon" style="background-color: #EF4DB6" title="Leave">
				<i class="fa fa-glass" title="Leave" style=""></i>
				</div> 
				<div class="case-label ellipsis"> 
					<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
					<span class="case-label-text">Leave</span>
				</div>
				</a>
			</div>
			
			
			<div class="case-wrapper" title="Salary Slip">
				<a  href="<?php echo base_url()."payslip";?>" >
					<div class="app-icon" style="background-color: #E898E9" title="Salary Slip">
					<i class="fa fa-calendar-o" title="Salary Slip" style=""></i>
					</div> 
					<div class="case-label ellipsis"> 
						<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
						<span class="case-label-text">Salary Slip</span>
					</div>
				</a>
			</div>
			
			
			<div class="case-wrapper" title="Performance Improvement Plan">
				<a  href="<?php echo base_url()."uc";?>" >
				<div class="app-icon" style="background-color: #b3b300" title="Performance Improvement Plan">
				<i class="fa fa-line-chart custom" title="Performance Improvement Plan" aria-hidden="true" style=""></i>
				
				</div> 
				<div class="case-label ellipsis"> 
					<span class="case-label-text">
						PIP
					</span>
				</div>
				</a>
			</div>
			
			
			<?php
				$linkurl=base_url()."policy";
			?>
			
			
			<div class="case-wrapper" title="Fusion Policy">
				<a  href="<?php echo $linkurl; ?>" >
					<div class="app-icon" style="background-color: #669999" title="Fusion Policy">
					<i class="fa fa-files-o" title="Fusion Policy" style=""></i>
					</div> 
					<div class="case-label ellipsis"> 
						<span class="case-label-text">Fusion Policy</span>
					</div>
				</a>
			</div>
			
			<?php
				$linkurl1=base_url()."process_update";
			?>
			<div class="case-wrapper" title="Process Update">
				<a  href="<?php echo $linkurl1; ?>" >
					<div class="app-icon" style="background-color: #7FA6F9" title="Process Update">
					<i class="fa fa-newspaper-o" title="Process Update" style=""></i>
					</div> 
					<div class="case-label ellipsis"> 
						<span class="case-label-text">Process Updates</span>
					</div>
				</a>
			</div>
			
			<?php
				
				$linkurl=base_url()."pmetrix";
				 
			?>
			
			<div class="case-wrapper" title="Performance Matrix">
				<a  href="<?php echo $linkurl; ?>" >
					<div class="app-icon" style="background-color: #285C53" title="Performance Matrix">
					<i class="fa fa-hourglass-start" title="Performance Matrix" style=""></i>
					</div> 
					<div class="case-label ellipsis"> 
						<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
						<span class="case-label-text">Performance Metrix</span>
					</div>
				</a>
			</div>
			
			<div class="case-wrapper" title="Resignation">
				<a  href="<?php echo base_url()."user_resign";?>" >
				<div class="app-icon" style="background-color: #DF7401" title="Resignation">
				<i class="fa fa-user-times" title="Resignation" aria-hidden="true" style=""></i>
				
				</div> 
				<div class="case-label ellipsis"> 
					<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
					<span class="case-label-text">
						Resignation
					</span>
				</div>
				</a>
			</div>
			
			
			<?php
				if(get_global_access()=='1' || get_dept_folder()=="hr" || get_role_dir()=="super"){
					$ac_class="";
					$linkurl=base_url()."master/role";
				
			?>
			<div class="case-wrapper <?php echo $ac_class; ?>" title="Master Entry">
				<a  href="<?php echo $linkurl; ?>" >
					<div class="app-icon" style="background-color: #4aa3df" title="Master Entry">
					<i class="fa fa-sun-o" title="Master Entry" style=""></i>
					</div> 
					<div class="case-label ellipsis"> 
						<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
						<span class="case-label-text">Master Entry</span>
					</div>
				</a>
			</div>
			<?php
				}
			?>
			
			<?php if(get_global_access()=='1'  || get_role_dir()=="super" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_role_dir()=="tl"){ ?>
				<div class="case-wrapper" title="Break Monitoring">
					<a  href="<?php echo base_url()."Break_monitor";?>" >
						<div class="app-icon" style="background-color: #FF616A" title="Break Monitoring">
						<i class="fa fa-desktop" title="Break Monitoring" style=""></i>
						</div> 
						<div class="case-label ellipsis"> 
							<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
							<span class="case-label-text">Break Monitoring </span>
						</div>
					</a>
				</div>
			<?php } ?>
			
			
			<div class="case-wrapper" title="Service Request">
				<a  href="<?php echo base_url()."Servicerequest";?>" >
					<div class="app-icon" style="background-color: #4AEBE9" title="Service Request">
						<i class="fa fa-upload" title="Service Request" aria-hidden="true" style=""></i>
					</div> 
					<div class="case-label ellipsis"> 
						<span class="case-label-text">
							Service Request
						</span>
					</div>
				</a>
			</div>
			
	</div>
	
</div>
					
					