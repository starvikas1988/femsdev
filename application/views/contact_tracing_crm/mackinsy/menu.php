<div class="col-md-10">
<div class="nav-new" id="desktop-menu">
					<div class="menu-right">
						<ul class="menu-new">
							<!--<li class="active-top"><a href="<?php echo base_url() ?>mck/">Listing</a>
							</li>-->
							<li><a href="#">Confirmed <i class="fa fa-angle-down" aria-hidden="true"></i></a>
								<ul class="sub-menu">
									<li><a href="<?php echo base_url() ?>mck/myconfirmed">My Cases</a></li>
									
									<li>
										<a href="<?php echo base_url() ?>mck/confirmed">All Cases </a>
									</li>
									
								</ul>
							</li>
							<li><a href="#"> Suspect Cases <i class="fa fa-angle-down" aria-hidden="true"></i></a>
								<ul class="sub-menu">
									<li><a href="<?php echo base_url() ?>mck/my_suspect_cases"> My Cases </a>
									</li>
									<li><a href="<?php echo base_url() ?>mck/suspect_cases">  All Cases</a>
									</li>
									
								</ul>
							</li>
							<li><a href="#"> Other Cases <i class="fa fa-angle-down" aria-hidden="true"></i></a>
								<ul class="sub-menu">
									<li><a href="<?php echo base_url() ?>mck/my_other_cases">My Cases</a>
									</li>
									<li><a href="<?php echo base_url() ?>mck/other_cases">All Cases</a>
									</li>
									
								</ul>
							</li>		
							<li><a href="#"> Close Contact Cases <i class="fa fa-angle-down" aria-hidden="true"></i></a>
								<ul class="sub-menu">
									<li><a href="<?php echo base_url() ?>mck/my_close_contact">My  Cases</a>
									</li>
									<li><a href="<?php echo base_url() ?>mck/close_contact"> Cases All</a>
									</li>
									
								</ul>
							</li>
					<!--<li><a href="#">Task</a></li>
					<li><a href="#">Report <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="sub-menu">
							<li><a href="#">Health Status</a></li>
							<li><a href="#">Fully Vaccinated</a></li>
							<li><a href="#">Positive Test date</a></li>
							<li><a href="#">Self-Isolate Start Date</a></li>
							<li><a href="#">Contact Status</a></li>
							<li><a href="#">Date Symptoms</a></li>
						</ul>
					</li>-->
					<?php  if(is_access_mckinsey_email()==1){?>
					<li><a href="#">Config<i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="sub-menu">
						<li><a href="<?php echo base_url() ?>mck/email_config_list">Email</a>
						</li>
					</ul>	
					</li>
					<?php } ?>
					<?php if(is_access_mckinsey_report() || get_login_type()== "client"){ ?>
					<li><a href="#">Report <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="sub-menu">
									<li><a href="<?php echo base_url() ?>mck/report/close_contacts">Close contacts</a>
									</li>
									<li><a href="<?php echo base_url() ?>mck/report/all_cases">All Cases</a>
									</li>
									<li><a href="<?php echo base_url() ?>mck/report/compersion_report">Compersion report</a></li>
								</ul>
					</li>
					<?php } if(is_access_mckinsey_add() || get_login_type()== "client"){?>
				
					<li><a href="<?php echo base_url() ?>mck/case/new">New</a></li>
					<?php } ?>
					<?php  ?>
				</ul>
					</div>
				</div>
				</div> 
				<div class="col-md-2">
                  <div class="dropdown log-out pull-right">
						<button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
						  <img src="<?php echo base_url() ?>assets/mckinsey/images/user.jpg" alt="" class="img-fluid">
						</button>
						<ul class="dropdown-menu profile-widget">
							<!--<li class="text-center">
								<img src="<?php echo base_url() ?>assets/mckinsey/images/user.jpg" alt="" class="img-fluid">
							</li>-->
							<!--<li class="text-center"><strong>Profile Name</strong></li>
						  <li><a class="dropdown-item" href="#">example@gmail.com</a></li>
						  ;-->
						  <li><a class="dropdown-item home_btn" href= "<?php echo base_url();?>home"?> Home</a>
						  <li><a class="dropdown-item" href= "<?php echo base_url();?>logout"?> Logout</a>
						</ul>
					</div>
				</div>