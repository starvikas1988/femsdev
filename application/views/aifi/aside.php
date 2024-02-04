   
    <div class="sidebar_menu">
        <div class="menu-inner">
            <div id="sidebar-menu">               
                <ul class="metismenu" id="sidebar_menu"> 

                    <li>
                        <a href="<?php echo base_url('aifi')?>">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>                    
                    <li>
                        <a href="<?php echo base_url('aifi')?>/search_details">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <span>Search  Transaction (AIFI) </span>
                        </a>
                    </li>                    
                    <li>
                        <a href="<?php echo base_url('aifi')?>/new_transaction" aria-expanded="true">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Productivity Tracker </span>                  
                        </a>                        
                    </li>
                    <li>
                        <a href="<?php echo base_url('aifi')?>/new_transaction_for_plonogram" aria-expanded="true">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Planogram Mistake Tracker  </span>                  
                        </a>                        
                    </li>
                    <li>
                        <a href="<?php echo base_url('aifi')?>/new_transaction_for_tech_issue_tracker" aria-expanded="true">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Tech Issue Tracker</span>                  
                        </a>                        
                    </li>

                    <?php 
                    $admin_access_array = array('FCEB003880', 'FCEB000729', 'FCEB004062','FCEB003947','FCEB000580','FKOL006714','FKOL001710','FKOL008602');
                    $f_id = get_user_fusion_id();
                    // if (in_array($f_id, $admin_access_array)){
                 ?> 
                    <li>
                        <a href="<?php echo base_url('aifi')?>/report" aria-expanded="true">
                            <i class="fa fa-bug" aria-hidden="true"></i>
                            <span>Report of Productivity</span>                           
                        </a>                        
                    </li>
                    <li>
                        <a href="<?php echo base_url('aifi')?>/report_for_planogram" aria-expanded="true">
                            <i class="fa fa-bug" aria-hidden="true"></i>
                            <span>Reports For Planogram (AIFI)</span>                           
                        </a>                        
                    </li>
                    <li>
                        <a href="<?php echo base_url('aifi')?>/report_for_tech" aria-expanded="true">
                            <i class="fa fa-bug" aria-hidden="true"></i>
                            <span>Reports For Tech (AIFI)</span>                           
                        </a>                        
                    </li>
                    <?php  if(get_global_access()=='1'){  ?>
                    <li>
                        <a href="<?php echo base_url('aifi')?>/master_access" aria-expanded="true">
                            <i class="fa fa-bug" aria-hidden="true"></i>
                            <span>Master Access For AIFI</span>                           
                        </a>                        
                    </li>



                        <?php }  ?>
                <?php //}?>
                </ul>               
            </div>
            <div class="clearfix"></div>
        </div>
    </div>