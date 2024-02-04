   <div class="sidebar_menu">
        <div class="menu-inner">
            <div id="sidebar-menu">               
                <ul class="metismenu" id="sidebar_menu">
                
                    <li>
                        <a href="<?php echo base_url() ?>harhith" class="<?php echo !empty($h_page) && $h_page == "1" ? "active" : ""; ?>">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

					
                   
				   <?php 
				   //=============================================================================//
				   //     SECTION TICKET LIST
				   //=============================================================================//
				   ?>			   
				   <?php if(get_login_type() != "client"){ ?>
				   
					<li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-venus" aria-hidden="true"></i>
                            <span>Enquiry</span>
                            <span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url() ?>harhith/add_ticket"><span>New</span></a></li>
                            <li><a href="<?php echo base_url() ?>harhith/existing_ticket"><span>Existing</span></a></li>
                            <li><a href="<?php echo base_url() ?>harhith/search_ticket"><span>Search Ticket</span></a></li>
                            <li><a href="<?php echo base_url() ?>harhith/my_ticket"><span>My Enquiries</span></a></li>
                        </ul>
                    </li>
					
					
					<li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            <span>Overall</span>
                            <span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url() ?>harhith/view_ticket/today"><span>Today Tickets</span></a></li>
                            <li><a href="<?php echo base_url() ?>harhith/view_ticket/open"><span>New Tickets</span></a></li>
                            <li><a href="<?php echo base_url() ?>harhith/view_ticket/assigned"><span>Open Tickets</span></a></li>
                            <li><a href="<?php echo base_url() ?>harhith/view_ticket/followup"><span>In Progress</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/view_ticket/closed"><span>Closed Tickets</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/view_ticket/all"><span>Overall Tickets</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/view_ticket/aged"><span>Aged Tickets</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/view_ticket/repeat"><span>Repeat Tickets</span></a></li>
                        </ul>
                    </li>					
					
				   <?php } ?>
				   
				   
				   <?php 
				   //=============================================================================//
				   //     SECTION CLIENT TICKET
				   //=============================================================================//
				   ?>	
				   <?php if(get_login_type() == "client"){ ?>
				   
				   
					<?php if(get_role() == "moderator" || get_role() == "md"){ ?>
					<li>
                        <a href="<?php echo base_url(); ?>harhith/view_ticket/open" class="">
                            <i class="fa fa-pie-chart" aria-hidden="true"></i>
                            <span>New Tickets</span>
                        </a>
                    </li>
					<li>
                        <a href="<?php echo base_url(); ?>harhith/view_ticket/assigned" class="">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <span>Open Tickets</span>
                        </a>
                    </li>
					
					<li>
                        <a href="<?php echo base_url(); ?>harhith/search_ticket" class="">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <span>Search Ticket</span>
                        </a>
                    </li>
					<li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            <span>Overall</span>
                            <span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url() ?>harhith/view_ticket/today"><span>Today Tickets</span></a></li>
                            <li><a href="<?php echo base_url() ?>harhith/view_ticket/followup"><span>In Progress</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/view_ticket/closed"><span>Closed Tickets</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/view_ticket/all"><span>Overall Tickets</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/view_ticket/aged"><span>Aged Tickets</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/view_ticket/repeat"><span>Repeat Tickets</span></a></li>
                        </ul>
                    </li>
					<?php } ?>
					
					
					<?php if(get_role() == "stakeholder"){ ?>
					<li>
                        <a href="<?php echo base_url(); ?>harhith/view_ticket/assigned" class="">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>My Open Tickets</span>
                        </a>
                    </li>
					<li>
                        <a href="<?php echo base_url(); ?>harhith/view_ticket/followup" class="">
                            <i class="fa fa-pie-chart" aria-hidden="true"></i>
                            <span>In Progress Tickets</span>
                        </a>
                    </li>					
					<li>
                        <a href="<?php echo base_url(); ?>harhith/view_ticket/closed" class="">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            <span>Closed Tickets</span>
                        </a>
                    </li> 
					<?php } ?>
					
					
					<?php } ?>
                    
					
					
					<?php if(get_global_access() || hth_admin_access()){ ?>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                            <span>Master</span>
                            <span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url() ?>harhith/department"><span>Department</span></a></li>
                            <li><a href="<?php echo base_url() ?>harhith/users"><span>Users</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/master_calltype"><span>Call Type</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/master_disposition"><span>Disposition Type</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/master_callreason"><span>Contact Reason Type</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/master_callsubreason"><span>Sub Reason Type</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/master_assign_ticket"><span>Auto Assign Master</span></a></li>
							<li><a href="<?php echo base_url() ?>harhith/roles"><span>Roles</span></a></li>
                        </ul>
                    </li>
					<?php } ?>
					
					
					<?php if(get_role() != "stakeholder"){ ?>
					<li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-pie-chart" aria-hidden="true"></i>
                            <span>Reports</span>
                            <span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url() ?>harhith/view_unassigned_report"><span>Unassigned Tickets</span></a></li>
                            <li><a href="<?php echo base_url() ?>harhith/view_ticket_report"><span>Ticket Report</span></a></li>
                            <li><a href="<?php echo base_url() ?>harhith/view_district_report"><span>District Report</span></a></li>
                        </ul>
                    </li>
					<?php } ?>
					
                </ul>               
            </div>
            <div class="clearfix"></div>
        </div>
    </div>