<div class="dropdown-menu mega-menu">
    <div class="search">
        <i class="fa fa-search"></i>
        <input type="text" class="form-control" id="autosuggest_input" placeholder="Search App...">
    </div>
    <?php
    if (is_access_qa_boomsourcing() == False) {
        if (is_ppbl_check() != '1') {
    ?>

            <ul>
                <li><a href="<?php echo base_url() ?>profile"><img src="<?php echo base_url() ?>assets_home_v3/images/my_profile.svg" class="menu_icon" alt="">My Profile</a></li>

                <?php
                if (get_role_dir() != "agent" || get_site_admin() == '1' || get_global_access() == '1' || get_dept_folder() == "hr" || get_dept_folder() == "wfm" || get_dept_folder() == "rta") {
                    if (get_global_access() == '1')
                        $team_url = base_url() . "super/dashboard";
                    else if (get_dept_folder() == "hr")
                        $team_url = base_url() . 'hr/dashboard';
                    else if (get_dept_folder() == "wfm" || get_dept_folder() == "rta")
                        $team_url = base_url() . 'wfm/dashboard';
                    else if (get_site_admin() == "1")
                        $team_url = base_url() . 'admin/dashboard';
                    else
                        $team_url = base_url() . get_role_dir() . "/dashboard";
                ?>

                    <li><a href="<?php echo $team_url ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/my_team.svg" class="menu_icon" alt="">My Team </a></li>

                <?php } ?>




                <?php $dashboard_url=base_url()."mwp_qa_dashboard?report_head=quality"; ?>

                <li><a href="<?php echo $dashboard_url ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/my_team.svg" class="menu_icon" alt="">MWP Dashboard</a></li>





                <?php
                if (is_access_search_employee() == true) {
                    $linkurl = base_url() . "search_candidate";
                ?>

                    <li><a href="<?php echo $linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/search_employee.svg" class="menu_icon" alt="">Search Employee</a></li>

                <?php } ?>

                <li><a href="<?php echo base_url() ?>policy"><img src="<?php echo base_url() ?>assets_home_v3/images/policies.svg" class="menu_icon" alt="">Policies</a></li>


                <?php
                if ((isAssignInterview() > 0 || is_access_dfr_module() == true) && is_disable_module() == false) {

                    $ac_class = "";
                    $linkurl = base_url() . "dfr";
                ?>
                    <li><a href="<?php echo $linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/recruitment.svg" class="menu_icon" alt="">Recruitment</a></li>
                <?php } ?>


                <?php
                if (get_global_access() == '1' || get_dept_folder() == "hr" || it_assets_access() == true) {

                    $ac_class = "";
                    $linkurl = base_url() . "Bgv";
                ?>
                    <li><a href="<?php echo $linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/background_verification.svg" class="menu_icon" alt="">Background Verification</a></li>
                <?php } ?>


                <?php
                if (get_dept_folder() == "it" && it_assets_access() == false)
                $linkurl = base_url() . "dfr_it_assets/assets_stock_entry";
                elseif (it_assets_access() == true)
                $linkurl = base_url() . "dfr_it_assets";
                if (it_assets_access() == true || get_dept_folder() == "it") {
                ?>
                    <li><a href="<?php echo $linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/it_assets.svg" class="menu_icon" alt="">IT Assets v1</a></li>
                <?php } ?>


                <?php
                if (isIndiaLocation(get_user_office_id()) == true && isAccessNaps() == true) {
                ?>
                    <li><a href="<?php echo base_url() . "naps"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/naps.svg" class="menu_icon" alt="">NAPS</a></li>
                <?php } ?>

                <?php
                if (is_disable_module() == false) {
                ?>
                    <li><a href="<?php echo base_url(); ?>progression"><img src="<?php echo base_url() ?>assets_home_v3/images/progression.svg" class="menu_icon" alt="">Progression</a></li>
                <?php } ?>

                <!--                                                    <li ><a href="<?php echo base_url(); ?>uc">Movement</a></li> -->

                <li><a href="<?php echo base_url() . "user_resign"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/sepration.svg" class="menu_icon" alt="">Separation</a></li>

                <?php
                if (isAccessFNF() == true || isAccessFNFHr() == true || isAccessFNFITSecurity() == true || isAccessFNFITHelpdesk() == true || isAccessFNFPayroll() == true || isAccessFNFAccounts() == true || isAccessFNFIT_Morocco() == true || isAccessFNFHR_Morocco() == true || isAccessFNFprocurement() == true) {
                ?>
                    <li><a href="<?php echo base_url() . "fnf"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/fnf.svg" class="menu_icon" alt="">F&F </a></li>

                <?php } ?>

                <?php
                if (isIndiaLocation(get_user_office_id()) == true) {
                ?>
                    <li><a href="<?php echo base_url() . "employee_id_card/card"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/id_card.svg" class="menu_icon" alt="">ID-Card </a></li>
                <?php } ?>

                <?php
                if (is_access_confirmation() == true) {
                    if (get_role_dir() != "agent") {
						
                 ?>
                            <li><a href="<?php echo base_url() . "letter/confirmation_list"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/confirmation.svg" class="menu_icon" alt="">Confirmation</a></li>
               <?php 
                    }
                }
				
                if (isIndiaLocation(get_user_office_id()) == true) {

                ?>

                    <li><a href="<?php echo base_url() . "Warning_mail_employee/your_warning_letter"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/warning.svg" class="menu_icon" alt="">Warning </a></li>

                    <li><a href="<?php echo base_url() . "appraisal_employee/your_appraisal_letter"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/appraisal_revision.svg" class="menu_icon" alt="">Appraisal / Revision </a></li>
                <?php } ?>

                <?php
                if (is_access_resend_payslip() == true) {
                ?>
                    <li><a href="<?php echo base_url() . "resend_payslip"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/salary_slip.svg" class="menu_icon" alt="">Resend payslip </a></li>

                <?php } ?>

                <?php if (isAccessAssetManagement() == true) { ?>

                    <li><a href="<?php echo base_url() . "asset"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/manage_assets.svg" class="menu_icon" alt="">Manage Assets </a></li>

                <?php } ?>

                <li><a href="<?php echo base_url() . "egaze"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/efficencyx.svg" class="menu_icon" alt="">EfficiencyX </a></li>

                <?php
                if (get_role_dir() != "agent" || is_access_schedule_update() == true || is_access_schedule_upload() == true || get_dept_folder() == "wfm" || get_dept_folder() == "rta") {
                ?>
                    <li><a href="<?php echo base_url() . "schedule"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/shedule.svg" class="menu_icon" alt="">Schedule </a></li>

                <?php } ?>

                <?php if (get_user_office_id() != "ALT" && get_user_office_id() != "DRA") { ?>
                    <li><a id='viewModalAttendance'><img src="<?php echo base_url() ?>assets_home_v3/images/my_time.svg" class="menu_icon" alt="">My Time </a></li>
                <?php } ?>

                <?php
                $ac_class = "";
                if (in_array(get_user_office_id(), ["ALT", "JAM", "CEB", "MAN", "CAS", "ALB", "KOS"]) || isIndiaLocation(get_user_office_id()) == true || get_global_access() == '1' || specific_location_leave_approve() == true)
                    $linkurl = base_url() . "leave/";
                else if (team_leave_approve() == true)
                    $linkurl = base_url() . "leave/leave_approval";
                else
                    $linkurl = base_url() . "uc/";
                ?>

                <li><a href="<?php echo $linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/leave.svg" class="menu_icon" alt="">Leave </a></li>



                <?php if (get_global_access() == '1' || get_site_admin() == '1' || get_dept_folder() == "hr" || get_role_dir() == "super" || get_role_dir() == "admin" || get_role_dir() == "manager" || get_role_dir() == "tl" || get_dept_folder() == "wfm" || get_dept_folder() == "rta" || get_user_fusion_id() == "FALB000079") { ?>

                    <li><a href="<?php echo base_url() . "break_monitor"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/break_monitor.svg" class="menu_icon" alt="">Break Monitor </a></li>

                <?php } ?>



                <?php
                if (is_access_ar_module() == true) {
                ?>

                    <li><a href="<?php echo base_url() . "attendance_reversal"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/attendance_reversal.svg" class="menu_icon" alt="">Attendance Reversal </a></li>

                <?php } ?>


                <?php
                if (is_access_qa_agent_module() == true || is_access_qa_module() == true || is_access_qa_operations_module() == true || is_quality_access_trainer() == true) {
                    $linkurl = base_url() . "quality";
                    $sr_linkurl = base_url() . "qa_servicerequest";
                ?>

                    <li><a href="<?php echo $linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/audit.svg" class="menu_icon" alt="">Audit </a></li>

                    <li><a href="<?php echo $sr_linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/qa_service_request.svg" class="menu_icon" alt="">QA Service Request </a></li>

                <?php } ?>

                <?php
                if (get_user_office_id() == "CEB" || get_user_office_id() == "MAN") {
                    $ac_class = "";
                    $linkurl = base_url() . "qa_coaching";
                ?>
                    <li><a href="<?php echo $linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/quality_coaching.svg" class="menu_icon" alt="">Quality Coaching </a></li>

                <?php } ?>

                <?php
                if (get_role_dir() != "agent" || isAccessReports() == true) {
                    $ac_class = "";
                    $linkurl = base_url() . "reports_qa/dipcheck";
                ?>
                    <li><a href="<?php echo $linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/quality_report.svg" class="menu_icon" alt="">Quality Report </a></li>

                <?php } ?>

                <?php if (power_bi_access() == true || power_bi_create_access() == true) { ?>
                    <li><a href="<?php echo base_url() . "power_bi"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/power_bi.svg" class="menu_icon" alt="">Global ER</a></li>
                <?php } ?>

                <?php if (isAccessAssetWFH() == true) { ?>
                    <li><a href="<?php echo base_url() . "wfh_assets"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/it_assets.svg" class="menu_icon" alt="">Assets</a></li>
                <?php } ?>

                <?php if (get_user_office_id() == "CEB" || get_user_office_id() == "MAN" || get_global_access() == '1') { ?>
                    <li><a href="<?php echo base_url(); ?>covid19_pre_check"><img src="<?php echo base_url() ?>assets_home_v3/images/covid_pre_check.svg" class="menu_icon" alt="">Covid Pre Check</a></li>
                <?php } ?>

                <?php if (get_user_office_id() == "CEB" || get_user_office_id() == "MAN" || get_global_access() == '1') { ?>
                    <li><a href="<?php echo base_url() . "mental_health"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/cognitive_check.svg" class="menu_icon" alt="">Cognitive Check</a></li>
                <?php } ?>

                <li><a href="<?php echo base_url(); ?>employee_feedback" title="Employee Perception Survey"><img src="<?php echo base_url() ?>assets_home_v3/images/survey.svg" class="menu_icon" alt="">Survey</a></li>

                <?php if (get_user_office_id() == "KOL" || get_global_access() == '1') { ?>
                    <li><a href="<?php echo base_url(); ?>survey/cafeteria"><img src="<?php echo base_url() ?>assets_home_v3/images/cafeteria_card.svg" class="menu_icon" alt="">Cafeteria Survey</a></li>
                <?php } ?>

                <?php if ((get_role_dir() != 'agent' && get_dept_id() != '6') || get_global_access() == '1') { ?>
                    <li><a href="<?php echo base_url(); ?>survey/copc"><img src="<?php echo base_url() ?>assets_home_v3/images/copc_survey.svg" class="menu_icon" alt="">COPC Survey</a></li>
                <?php } ?>

                <?php if (get_user_office_id() == "CEB" || get_user_office_id() == "MAN") { ?>
                    <li><a href="<?php echo base_url() . "survey/employee_pulse"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/pulse_survey.svg" class="menu_icon" alt="">Pulse Survey</a></li>
                <?php } ?>

                <?php if (get_user_office_id() == "CEB" || get_user_office_id() == "MAN") { ?>

                    <li><a href="<?php echo base_url() . "survey/townhall"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/townhall_survey.svg" class="menu_icon" alt="">Townhall Survey</a></li>
                <?php } ?>

                <?php if (is_access_clinic_portal()) { ?>

                    <li><a href="<?php echo base_url() . "clinic_portal"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/total_reward.svg" class="menu_icon" alt="">Total Rewards</a></li>
                <?php } ?>

                <?php if (get_global_access() == 1 || isADLocation() || is_access_downtime_tracker()) { ?>

                    <li><a href="<?php echo base_url() . "downtime/ameridial"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/downtime_tracker.svg" class="menu_icon" alt="">Downtime Tracker</a></li>

                <?php } ?>

                <?php /* ?><?php if(get_global_access() == 1 || isIndiaLocation() || get_user_office_id()=="CEB" || get_user_office_id()=="MAN"){ ?><?php */ ?>
                <li><a href="<?php echo base_url() . "survey/tna"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/tna.svg" class="menu_icon" alt="">TNA</a></li>
                <?php /* ?><?php } ?><?php */ ?>

                <?php if (get_user_office_id() == "CEB" || get_global_access()) { ?>
                    <li><a href="<?php echo base_url() . "survey/hr_audit"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/hr_audit_survey.svg" class="menu_icon" alt="">HR Audit Survey</a></li>
                <?php } ?>

                <?php if (news_access_permission() == 1) { ?>

                    <li><a href="<?php echo base_url() . "news/news_list"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/news.svg" class="menu_icon" alt="">News</a></li>
                <?php } ?>

                <?php
                if (isDisablePersonalInfo() == false) {
                ?>
                    <li><a href="<?php echo base_url() . "payslip"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/salary_slip.svg" class="menu_icon" alt="">Salary Slip</a></li>

                    <li><a href="<?php echo base_url() . "itdeclaration_new"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/it_decalaration.svg" class="menu_icon" alt="">IT Declaration</a></li>
                    <li><a href="<?php echo base_url() . "mediclaim"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/mediclaim_card.svg" class="menu_icon" alt="">Mediclaim Card</a></li>

                <?php } ?>

                <?php
                if (get_dept_folder() == "training" || is_access_trainer_module() == true || isAgentInTraining() || isAvilTrainingExam() > 0 || is_access_training_analytics()) {

                    if (is_access_training_analytics() > 0)  $linkurl = base_url() . "training_analytics/training";
                    else if (isAssignAsTrainer() > 0)
                        $linkurl = base_url() . "training/crt_batch";
                    else if ((isAgentInTraining() && get_dept_folder() != "training") || isAvilTrainingExam() > 0)
                        $linkurl = base_url() . "training/agent";
                    else
                        $linkurl = base_url() . "training/crt_batch";

                    //$linkurl=base_url()."uc";
                ?>
                    <li><a href="<?php echo $linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/training.svg" class="menu_icon" alt="">Training</a></li>
                <?php } ?>

                <li><a href="<?php echo base_url() . "knowledge"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/knowledge_base.svg" class="menu_icon" alt="">Knowledge Base</a></li>

                <li><a href="<?php echo base_url(); ?>faq"><img src="<?php echo base_url() ?>assets_home_v3/images/faq.svg" class="menu_icon" alt="">FAQ</a></li>

                <li><a href="<?php echo base_url(); ?>message"><img src="<?php echo base_url() ?>assets_home_v3/images/shoutbox.svg" class="menu_icon" alt="">Shoutbox</a></li>

                <li><a href="<?php echo base_url(); ?>course"><img src="<?php echo base_url() ?>assets_home_v3/images/level_up.svg" class="menu_icon" alt="">Level Up</a></li>

                <li><a href="<?php echo base_url(); ?>kat"><img src="<?php echo base_url() ?>assets_home_v3/images/kat.svg" class="menu_icon" alt="">Kat</a></li>
                <li><a href="<?php echo base_url(); ?>kat_admin"><img src="<?php echo base_url() ?>assets_home_v3/images/kat.svg" class="menu_icon" alt="">KAT 2.0</a></li>

                <?php if (is_access_ld_registration()) { ?>
                    <li><a href="<?php echo base_url(); ?>ld_courses"><img src="<?php echo base_url() ?>assets_home_v3/images/l_d_registration.svg" class="menu_icon" alt="">L&D Registration</a></li>
                <?php } ?>

                <li><a href="<?php echo base_url(); ?>ld_programs"><img src="<?php echo base_url() ?>assets_home_v3/images/l_d_progress.svg" class="menu_icon" alt="">L&D Progress</a></li>

                <li><a href="<?php echo base_url(); ?>process_update"><img src="<?php echo base_url() ?>assets_home_v3/images/process_update.svg" class="menu_icon" alt="">Process Updates</a></li>
                <li><a href="<?php echo base_url(); ?>pmetrix_v2"><img src="<?php echo base_url() ?>assets_home_v3/images/perfomance_matrix.svg" class="menu_icon" alt="">Performance Metrics</a></li>

                <li><a href="<?php echo base_url(); ?>pip"><img src="<?php echo base_url() ?>assets_home_v3/images/pip.svg" class="menu_icon" alt="">PIP</a></li>
                <?php if (is_access_Cns_modules()) { ?>
                <li><a href="<?php echo base_url() . "cns"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/cns.svg" class="menu_icon" alt="">CNS</a></li>
                <?php } ?>
                <?php if (is_access_Call_modules()) { ?>
                <li><a href="<?php echo base_url() . "call_alert"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/call_alert.svg" class="menu_icon" alt="">Call Alert</a></li>
                <?php } ?>
                <?php if (isAccessMindfaqApps() == true) { ?>

                    <?php if (is_access_jurys_inn_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "Mindfaq_leonardohotels"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/leonardo_hotels.svg" class="menu_icon" alt="">Leonardo_Hotels MindFAQ</a></li>
                    <?php } ?>

                    <?php if (is_access_mpower_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "mindfaq_mpower"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/mpower_mind_faq.svg" class="menu_icon" alt="">Mpower MindFAQ</a></li>
                    <?php } ?>
                    <?php if (is_access_apphelp_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "mindfaq_apphelp"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/app_help_mind_faq.svg" class="menu_icon" alt="">AppHelp MindFAQ</a></li>
                    <?php } ?>
                    <?php if (is_access_affinity_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "mindfaq_affinity"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_mind_faq.svg" class="menu_icon" alt="">Affinity MindFAQ</a></li>
                    <?php } ?>
                    <?php if (is_access_meesho_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "mindfaq_meesho"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/messho_mind_faq.svg" class="menu_icon" alt="">Meesho MindFAQ</a></li>
                    <?php } ?>

                    <?php if (is_access_kabbage_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "mindfaq_kabbage"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_mind_faq.svg" class="menu_icon" alt="">Kabbage MindFAQ</a></li>
                    <?php } ?>

                    <?php /* ?><?php if(is_access_brightway_modules()==true){ ?><?php */ ?>
                    <!--<li ><a href="<?php /* ?><?php echo base_url() ."mindfaq_brightway"; ?><?php */ ?>">Brightway MindFAQ</a></li>-->
                    <?php /* ?><?php } ?><?php */ ?>

                    <?php if (is_access_snapdeal_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "mindfaq_snapdeal"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/snapdeal_mind_faq.svg" class="menu_icon" alt="">Snapdeal MindFAQ</a></li>
                    <?php } ?>

                    <?php if (is_access_cars24_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "mindfaq_cars24"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/cars24_mind_faq.svg" class="menu_icon" alt="">Cars24 MindFAQ</a></li>
                    <?php } ?>

                    <?php /* ?><?php if(is_access_awareness_modules()==true){ ?><?php */ ?>
                    <!--<li ><a href="<?php /* ?><?php echo base_url() ."mindfaq_awareness"; ?><?php */ ?>">Awareness MindFAQ</a></li>-->
                    <?php /* ?><?php } ?><?php */ ?>

                    <?php /* ?><?php if(is_access_paynearby_modules()==true){ ?><?php */ ?>
                    <!--<li ><a href="<?php /* ?><?php echo base_url() ."mindfaq_paynearby"; ?><?php */ ?>">Pay Nearby MindFAQ</a></li>-->
                    <?php /* ?><?php } ?><?php */ ?>

                    <?php /* ?><?php if(is_access_cci_modules()==true){ ?><?php */ ?>
                    <!--<li ><a href="<?php /* ?><?php echo base_url() ."mindfaq_cci"; ?><?php */ ?>">CCI MindFAQ</a></li>-->
                    <?php /* ?><?php } ?><?php */ ?>

                    <?php if (is_access_phs_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "mindfaq_phs"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_mind_faq.svg" class="menu_icon" alt="">PHS MindFAQ </a></li>
                    <?php } ?>

                    <?php /* ?><?php if(is_access_att_modules()==true){ ?><?php */ ?>
                    <!--<li ><a href="<?php /* ?><?php echo base_url() ."mindfaq_att"; ?><?php */ ?>"> AT&T MindFAQ </a></li>-->
                    <?php /* ?><?php } ?><?php */ ?>


                    <?php if (is_access_clio_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "mindfaq_clio"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_mind_faq.svg" class="menu_icon" alt="">CLIO MindFAQ </a></li>
                    <?php } ?>

                    <?php if (is_access_achieve_modules() == true) { ?>
                        <li><a href="<?php echo base_url() . "mindfaq_achieve"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_mind_faq.svg" class="menu_icon" alt="">Achieve MindFAQ </a></li>
                    <?php } ?>

                <?php } ?>

                <?php if (is_access_zendesk_crm() == true) { ?>

                    <li><a href="<?php echo base_url() . "zendesk_report/tickets_report_export"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/zendesk_crm.svg" class="menu_icon" alt="">Zendesk CRM</a></li>
                <?php } ?>

                <?php if (is_access_jurys_inn_crm_report() == true || is_crm_readonly_access_mindfaq() || get_user_fusion_id() == "FALB000144") { ?>

                    <li><a href="<?php echo base_url() . "jurys_inn/"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/jurysinn_crm.svg" class="menu_icon" alt="">JurysInn CRM</a></li>
                <?php } ?>

                <?php if (is_access_alpha_gas_modules()) { ?>
                    <li><a href="<?php echo base_url() . "alphagas"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/alpha_gas_crm.svg" class="menu_icon" alt="">Alpha Gas CRM</a></li>
                <?php } ?>
                <?php
                if (is_access_k2crm_modules() == true || is_crm_readonly_access_mindfaq()) {
                ?>
                    <li><a href="<?php echo base_url(); ?>k2_claims_crm"><img src="<?php echo base_url() ?>assets_home_v3/images/common_crm.svg" class="menu_icon" alt="">K2 Claims CRM</a></li>
                <?php } ?>
                <?php
                if (is_access_mpower_voc_report() == true || is_crm_readonly_access_mindfaq()) {
                ?>
                    <li><a href="<?php echo base_url() . "mpower"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/mpower_mind_faq.svg" class="menu_icon" alt="">Mpower VOC</a></li>
                <?php } ?>
                <?php if (is_access_meesho_modules() || is_access_meesho_search_modules()) { ?>

                    <li><a href="<?php echo base_url() . "meesho_bulk"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/messho_search.svg" class="menu_icon" alt="">Meesho Search</a></li>
                <?php } ?>
                <?php if (is_access_t2_capabilities() == true) { ?>
                    <li><a href="<?php echo base_url() . "t2_capabilities"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/docusing_skill.svg" class="menu_icon" alt="">Docusign Skills</a></li>
                <?php } ?>
                <?php if (get_user_fusion_id() != "FALB000144") { ?>
                    <li><a href="<?php echo base_url() . "covid_case/form/"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/contact_tracing.svg" class="menu_icon" alt="">Contact Tracing</a></li>
                <?php } ?>
                <?php if (is_access_zovio_modules()) { ?>
                    <li><a href="<?php echo base_url() . "contact_tracing_crm"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_crm.svg" class="menu_icon" alt="">Zovio CRM</a></li>
                <?php } ?>


                <?php if (is_access_follett_modules()) { ?>
                    <li><a href="<?php echo base_url() . "contact_tracing_follett"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_crm.svg" class="menu_icon" alt="">Follett CRM</a></li>
                <?php } ?>

                <?php if (is_access_howard_modules()) { ?>
                    <li><a href="<?php echo base_url() . "howard_training"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/howard_system.svg" class="menu_icon" alt="">Howard System</a></li>
                <?php } ?>
                <?php if (is_access_mckinsey_modules()) { ?>
                    <li><a href="<?php echo base_url() . "mck"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/mckinsey.svg" class="menu_icon" alt="">Mckinsey</a></li>
                <?php } ?>

                <?php if (is_access_kyt_modules()) { ?>
                    <li><a href="<?php echo base_url() . "kyt"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/kyt_crm.svg" class="menu_icon" alt="">KYT CRM</a></li>
                <?php } ?>
                <?php if (is_access_cj_crm_modules()) { ?>
                    <li><a href="<?php echo base_url() . "emat_new/dashboard"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_crm.svg" class="menu_icon" alt="">CJ CRM</a></li>
                <?php } ?>

                <?php
                $url = "home";
                $admin_access_array = array('FKOL006288', 'FKOL005998', 'FKOL001961');
                $f_id = get_user_fusion_id();
                if (get_process_ids() == '536' || get_process_ids() == '537') {
                    $url = "qenglish/newCustomer";
                }

                if (in_array($f_id, $admin_access_array)) {
                    $this->session->set_userdata('qenglish_client', 'yes');
                    $url = "qenglish";
                }

                if (get_client_ids() == '250' || in_array($f_id, $admin_access_array)) {
                ?>
                    <li><a href="<?php echo base_url() . $url; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_crm.svg" class="menu_icon" alt="">Queen's English CRM</a></li>

                <?php } ?>

                <?php if (is_access_emat_crm()) { ?>
                    <li><a href="<?php echo base_url() . "emat"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_crm.svg" class="menu_icon" alt="">EMAT CRM</a></li>
                <?php } ?>

                <?php if (is_access_oyo_disposition() == true) { ?>
                    <li><a href="<?php echo base_url() . "oyo_disposition"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/oyo.svg" class="menu_icon" alt="">OYO Disposition</a></li>
                <?php } ?>
                <?php if (is_access_ma_platform() == true) { ?>
                    <li><a href="<?php echo base_url() . "ma_platform"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/m_a_plateform.svg" class="menu_icon" alt="">M&A Platform</a></li>
                <?php } ?>
                <?php if (is_access_harhith() || get_user_fusion_id() == "FCHA001874") { ?>
                    <li><a href="<?php echo base_url() . "harhith"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/common_crm.svg" class="menu_icon" alt="">Harhith CRM</a></li>
                <?php } ?>
                <?php if (is_access_client_voc()) { ?>
                    <li><a href="<?php echo base_url() . "harhith"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/client_voc.svg" class="menu_icon" alt="">Client VOC</a></li>
                <?php } ?>

                <li><a href="<?php echo base_url() . "webpages/cci/index.html"; ?>" target="_blank"><img src="<?php echo base_url() ?>assets_home_v3/images/cci_health.svg" class="menu_icon" alt="">CCI Health</a></li>

                <?php if (get_role_dir() != "agent" || isAccessReports() == true) { ?>

                    <li><a href="<?php echo base_url() . "reports_hr"; ?>" target="_blank"><img src="<?php echo base_url() ?>assets_home_v3/images/hr_attendance.svg" class="menu_icon" alt="">HR & Attendance</a></li>

                    <li><a href="<?php echo base_url() . "reports_pm"; ?>" target="_blank"><img src="<?php echo base_url() ?>assets_home_v3/images/perfomance_report.svg" class="menu_icon" alt="">Performance Report</a></li>

                    <li><a href="<?php echo base_url() . "reports_misc/itAssessment"; ?>" target="_blank"><img src="<?php echo base_url() ?>assets_home_v3/images/miscellaneous.svg" class="menu_icon" alt="">Miscellaneous</a></li>

                <?php } ?>

                <?php if (isAccessMindfaqReports()) { ?>
                    <li><a href="<?php echo base_url() . "mindfaq_analytics_skt"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/mind_faq.svg" class="menu_icon" alt="">Mindfaq</a></li>
                <?php } ?>

                <?php if (isAccessAvonReports()) { ?>
                    <li><a href="<?php echo base_url() . "avon_chat_report/export"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/avon_chat_data.svg" class="menu_icon" alt="">AVON CHAT DATA</a></li>
                <?php } ?>


                <li><a href="<?php echo base_url() . "report_center"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/report_hub.svg" class="menu_icon" alt="">Report Hub</a></li>

                <?php if (is_access_reset_password()) { ?>
                    <li><a href="<?php echo base_url() . "user_password_reset"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/reset_password.svg" class="menu_icon" alt="">Reset Password</a></li>
                <?php } ?>

                <li><a href="<?php echo base_url() . "servicerequest"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/service_request.svg" class="menu_icon" alt="">Service Request</a></li>

                <li><a href="<?php echo base_url() . "album"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/photo_gallery.svg" class="menu_icon" alt="">Photo Gallery</a></li>

                <?php if (is_access_master_entry() == 1) { ?>
                    <li><a href="<?php echo base_url() . "master/role"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/master_entry.svg" class="menu_icon" alt="">Master Entry</a></li>
                <?php } else if (is_access_announcment() == 1) { ?>

                    <li><a href="<?php echo base_url() . "master/fems_announcement"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/annoucement.svg" class="menu_icon" alt="">Announcement</a></li>

                <?php } ?>

                <?php if (isAccessQuestionBank()) { ?>
                    <li><a href="<?php echo base_url() . "examination"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/question_bank.svg" class="menu_icon" alt="">Question Bank</a></li>
                <?php } ?>

                <?php if (get_user_fusion_id() == "FKOL000001" || get_user_fusion_id() == "FKOL001800" || get_user_fusion_id() == "FKOL012753") { ?>
                    <li><a href="<?php echo base_url() . "Qa_boomsourcing/boomsourcing"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/boomsourcing.svg" class="menu_icon" alt="">Boomsourcing </a></li>
                <?php }
               // if (is_department_restriction() == true || is_pms_permssion() == true) {  
                if (is_department_restriction() == true) { ?>

                    <li><a href="<?= base_url() ?>pms_assignment"><img src="<?php echo base_url() ?>assets_home_v3/images/pms.svg" class="menu_icon" alt="">PMS</a></li>
                <?php } ?>
                <li><a href="#"></a></li>
            </ul>

        <?php }
        if (is_ppbl_check() == '1') { ?>
            <ul>
                <li><a href="<?php echo base_url() ?>profile"><img src="<?php echo base_url() ?>assets_home_v3/images/my_profile.svg" class="menu_icon" alt="">My Profile</a></li>
                <?php
                if (get_role_dir() != "agent" || get_site_admin() == '1' || get_global_access() == '1' || get_dept_folder() == "hr" || get_dept_folder() == "wfm" || get_dept_folder() == "rta") {
                    if (get_global_access() == '1')
                        $team_url = base_url() . "super/dashboard";
                    else if (get_dept_folder() == "hr")
                        $team_url = base_url() . 'hr/dashboard';
                    else if (get_dept_folder() == "wfm" || get_dept_folder() == "rta")
                        $team_url = base_url() . 'wfm/dashboard';
                    else if (get_site_admin() == "1")
                        $team_url = base_url() . 'admin/dashboard';
                    else
                        $team_url = base_url() . get_role_dir() . "/dashboard";
                ?>
                <?php } ?>

                <?php if (get_user_office_id() != "ALT" && get_user_office_id() != "DRA") { ?>
                    <li><a id='viewModalAttendance'><img src="<?php echo base_url() ?>assets_home_v3/images/my_time.svg" class="menu_icon" alt="">My Time </a></li>
                <?php } ?>
                <?php
                $ac_class = "";
                if (in_array(get_user_office_id(), ["ALT", "JAM", "CEB", "MAN", "CAS", "ALB", "KOS"]) || isIndiaLocation(get_user_office_id()) == true || get_global_access() == '1')
                    $linkurl = base_url() . "leave_ppbl/";
                else if (get_user_fusion_id() == 'FALT002231')
                    $linkurl = base_url() . "leave_ppbl/leave_approval";
                else
                    $linkurl = base_url() . "uc/";
                ?>
                <li><a href="<?php echo $linkurl; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/leave.svg" class="menu_icon" alt="">Leave </a></li>
                <li><a href="#"></a></li>
            </ul>
        <?php
        }
    } else if (is_access_qa_boomsourcing() == True) {
        ?>
        <ul>
            <li><a href="<?php echo base_url() . "Qa_boomsourcing/boomsourcing"; ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/boomsourcing.svg" class="menu_icon" alt="">Boomsourcing </a></li>
        </ul>
    <?php } ?>
</div>