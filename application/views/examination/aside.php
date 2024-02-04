<!-- APP ASIDE ==========-->

<aside id="app-aside" class="app-aside left light">
	<div class="sidebar_box">
		<div id="sidebar-menu">
			<ul class="metismenu" id="sidebar_menu">
				<?php
				if (get_dept_folder() == "wfm" || get_dept_folder() == "hr" || $is_role_dir == "super"  || $is_role_dir == "manager" || is_approve_requisition() == true) {
				?>
					<li>
						<a href="<?php echo base_url('examination'); ?>">
							<img src="<?php echo base_url();?>assets_home_v3/images/question_left_menu.svg" class="sidebar_icon" alt="">
							<span>Question paper</span>
						</a>
					</li>
				<?php
				}
				?>
				<!-- <li>
					<a href="<?php //echo base_url('examination/giveexam'); ?>">
						<img src="images/dashboard.svg" class="sidebar_icon" alt="">
						<span>Give Exam</span>
					</a>
				</li> -->
			</ul>
		</div>
	</div>
</aside>
<!--========== END app aside -->