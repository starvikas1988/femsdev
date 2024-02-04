	<div class="header-area">
        <div class="header-area-left">
            <a href="#" class="logo">
                <!--<img src="<?php echo base_url() ?>assets/harhith/images/logo.svg" class="logo" alt="">-->
                <img src="<?php echo base_url() ?>assets/harhith/images/harhith_logo.png" style="height: 70px;width:100%" class="logo" alt="">
            </a>
        </div>
		<!--start mobile logo -->
		<div class="mobile-logo-new" style="padding: 8px;background:none;border:0px">
			<a href="#" class="logo">
               <!-- <img src="<?php echo base_url() ?>assets/harhith/images/logo.svg" class="logo" alt="">-->
                <img src="<?php echo base_url() ?>assets/harhith/images/harhith_logo.png"  style="height: 40px;width:100%" class="logo" alt="">
            </a>
		</div>
		<!--end mobile logo -->
		
        <div class="row align-items-center header_right">           
            <div class="col-md-7 d_none_sm d-flex align-items-center">
                <div class="nav-btn button-menu-mobile pull-left">
                    <button class="open-left waves-effect">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>
                </div>
				<span style="margin--top:10px">
				<?php
				echo get_username();
				if(get_login_type() == "client"){
					echo " (".ucwords(get_role()) .")";
				} else {
				if(get_deptname() != ""){ 
					echo " (". get_role().", ".get_deptshname().")"; 
				}
				}				
				?>
			    </span>
			
                <div class="search-box pull-left">					
                    <!--<form action="#">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input type="text" name="search" placeholder="Search..." required="">
                    </form>-->
                </div>
            </div>            
            <div class="col-md-5 col-sm-12">
                <ul class="notification-area pull-right">
                    <li class="mobile_menu_btn">
                        <span class="nav-btn pull-left d_none_lg">
                            <button class="open-left waves-effect">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </button>
                        </span>
                    </li>
                    <li id="full-view" class="d_none_sm">
						<i class="fa fa-arrows-alt" aria-hidden="true"></i>
					</li>
                    <li id="full-view-exit" class="d_none_sm">
						<i class="fa fa-window-minimize" aria-hidden="true"></i>
					</li>
					<?php if(get_role() != "moderator" && get_role() != "stakeholder" && get_role() != "md"){ ?>
					<li class="d_none_sm">
						<a style="text-decoration:none;" href="<?php echo hth_url('add_ticket'); ?>"><i class="fa fa-user-plus"></i> Raise</a>
					</li>
					<?php } ?>
					<li class="d_none_sm">
						<a style="text-decoration:none;" href="<?php echo hth_url('search_ticket'); ?>"><i class="fa fa-search"></i> Track</a>
					</li>
					<li class="d_none_sm" style="font-size:30px">
						<a style="text-decoration:none;margin-top:10px" href="<?php echo base_url('home'); ?>"><i class="fa fa-home" aria-hidden="true"></i></a>
					</li>                    
                    <li class="user-dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo base_url() ?>assets/harhith/images/user.jpg" alt="" class="img-fluid">
                            </button>
                            <div class="dropdown-menu dropdown_user" aria-labelledby="dropdownMenuButton" >
                                <div class="dropdown-header d-flex flex-column align-items-center">
                                    <div class="user_img mb-3">
                                        <img src="<?php echo base_url() ?>assets/harhith/images/user.jpg" alt="User Image">
                                    </div>
                                    <div class="user_bio text-center">
                                        <p class="name font-weight-bold mb-0">
											<?php echo get_username(); ?>
										</p>
                                        <!--<p class="email text-muted mb-3">
											<a href="#" class="pl-3 pr-3">example@gmail.com</a>
										</p>-->
                                    </div>
                                </div>
                                <span role="separator" class="divider"></span>
								<?php
								$logoutURL = base_url('logout');
								if(get_login_type() == "client"){
									$logoutURL = base_url('clientlogin/client_logout');
								}
								?>
                                <a class="dropdown-item" href="<?php echo $logoutURL; ?>">
									<i class="fa fa-sign-out" aria-hidden="true"></i> Logout
								</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>            
        </div>
   </div>
   
   
	