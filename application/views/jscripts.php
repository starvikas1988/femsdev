<script>

function isValidDate(date) {  
   return moment(date, "MM/DD/YYYY").isValid(); 
}

//////////////////////

	var process_ajax = function (call_back_func = null,request_url, sent_data = "", return_type = 'json', request_type = "POST",contains="")
    {
        if(contains === 'file')
        {
            var processdata = false;
            var contenttype = false;
        }
        else
        {
            var processdata = true;
            var contenttype = 'application/x-www-form-urlencoded; charset=UTF-8';
        }
        $.ajax
                ({
                    type: request_type,
                    url: request_url,
                    data: sent_data,
                    dataType: return_type,
                    processData: processdata,
                    contentType: contenttype,
                    beforeSend: function ()
                    {
						
                        $("#snackbar").remove();
						$("body").append('<div id="snackbar" style="display:none;min-width: 250px;margin-left: -125px;background-color: #333;color: #fff;text-align: center;border-radius: 2px;padding: 16px;position: fixed;z-index: 99999999;left: 50%;bottom: 30px;font-size: 17px;">Loading Start.</div>');
						$('#snackbar').text('Loading Please Wait');
						$('#snackbar').show('1000');
						
						$('#sktPleaseWait').modal('show');
                    },
                    success: function (response_text)
                    {
						$('#sktPleaseWait').modal('hide');
						$('.modal-backdrop').remove();
                        $('#snackbar').text('All Process Completed.');
                        if (call_back_func !== null)
                        {
                            call_back_func(response_text);
                        }
                    },
                    error: function (xhr)
                    {
						$('#sktPleaseWait').modal('hide');
						 $('.modal-backdrop').remove();
						
                        $('#snackbar').text('Please Try After Some Time.');
                        $('#snackbar').hide('5000');
						
                    },
                    complete: function ()
                    {
                        $('#snackbar').hide('1000');
						$('#sktPleaseWait').modal('hide');
						$('.modal-backdrop').remove();
						
                    }
                });
    };
	
</script>


<?php 
include_once 'jscripts/skt.common_js.php';
include_once 'jscripts/skt.salary_js.php';

if($content_template=="home/home.php" || $content_template=="home/homecha.php" || $content_template=="home/homealm.php" || $content_template=="homev2.php" || $content_template=="homev3.php" ){
	include_once 'jscripts/skt.notifi_js.php';
}

if(strpos($content_template, 'home') !== false){
	include_once 'jscripts/home_js.php';
}
if($content_template=="home/pending_process_policy.php"){
	include_once 'jscripts/profile_js.php';
}

if($content_template=="home/home.php"){
	include_once 'jscripts/schedule_adherence/agent_dashboard_check_js.php';
}

if($content_template=="home/covid_checkup.php"){ include_once 'jscripts/covid_checkup_js.php'; }
if($content_template=="reports/covid_self_declaration_report.php"){ include_once 'jscripts/covid_checkup_js.php'; }
if($content_template=="home/pending_schedule_check.php"){ include_once 'jscripts/pending_schedule_check_js.php'; }
if($content_template=="schedule/ops_review.php"){ include_once 'jscripts/pending_schedule_check_js.php'; }
if($content_template=="schedule/wfm_review.php"){ include_once 'jscripts/pending_schedule_check_js.php'; }

if($content_template=="user/add_users.php" ) include_once 'jscripts/add_users_js.php';
if($content_template=="user/manage_users.php" || $content_template=="user/add.php") include_once 'jscripts/manage_users_js.php';
if($content_template=="emailinfo/manage.php") include_once 'jscripts/manage_emailinfo_js.php';
if($content_template=="user/manage_client.php" || $content_template=="user/add_client.php") include_once 'jscripts/add_users_js.php';
if($content_template=="user/add_client_from_myteam.php")  include_once 'jscripts/add_users_js.php';

if(strpos($content_template, 'profile') !== false){
	include_once 'jscripts/profile_js.php';
}

if(strpos($content_template, 'dashboard.php') !== false){
		include_once 'jscripts/comm_dashboard_js.php';
}

if(strpos($content_template, 'agent_resignation.php') !== false){
	include_once 'jscripts/agent_dashboard_js.php';
}


if(strpos($content_template, 'reports_hr') !== false){
	include_once 'jscripts/reports_hr_js.php';
}

if(strpos($content_template, 'reports_qa') !== false){
	include_once 'jscripts/reports_js.php';
}

if(strpos($content_template, 'reports_pm') !== false){
	include_once 'jscripts/reports_js.php';
}

if(strpos($content_template, 'reports_misc') !== false){
	include_once 'jscripts/reports_js.php';
}

if(strpos($content_template, 'reports/') !== false){
	include_once 'jscripts/reports_js.php';
}



/////==================== ATTENDANCE STARTS  ================================/////////////////////
if($content_template=="attendance/att_main.php" || $content_template=="attendance/att_summary.php" || $content_template=="attendance/att_logintime.php" || $content_template=="attendance/att_adherence.php") include_once 'jscripts/attendance_js.php';

/////==================== ATTENDANCE ENDS  ================================/////////////////////


if($content_template=="schedule/upload.php") include_once 'jscripts/schedule_js.php';
if($content_template=="schedule/actual_screen.php") include_once 'jscripts/schedule_js.php';

if($content_template=="audit/add.php" || $content_template=="audit/manage.php" || $content_template=="audit/rawdata.php" ) include_once 'jscripts/audit_js.php';

if($content_template=="coaching/add.php" || $content_template=="coaching/manage.php" || $content_template=="coaching/rep_tl.php" || $content_template=="coaching/rep_agent.php" || $content_template=="coaching/rawdata.php" ) include_once 'jscripts/coaching_js.php';

if($content_template=="logindetails/main.php") include_once 'jscripts/logindetails_js.php';

if(strpos($content_template, 'master') !== false) include_once 'jscripts/master_js.php';
//if($content_template=="master/manage_category_pre_assign.php") include_once 'jscripts/master_js.php';

if(strpos($content_template, 'evaluation') !== false) include_once 'jscripts/evaluation_js.php';

if($content_template=="user/upload.php") include_once 'jscripts/bulkupload_js.php';
if($content_template=="user/upload_update.php") include_once 'jscripts/bulkupload_update_js.php';

if($content_template=="dfr/upload.php") include_once 'jscripts/bulkupload_dfr_js.php';
if($content_template=="utils/bulk_term.php") include_once 'jscripts/utils_bulk_term_js.php';
if($content_template=="utils/bulk_fnf.php") include_once 'jscripts/utils_bulk_fnf_js.php';
if($content_template=="utils/update_gross.php") include_once 'jscripts/bulk_update_gross_js.php';
if($content_template=="utils/bulk_furlough.php") include_once 'jscripts/utils_bulk_furlough_js.php';

/////User Resignation//////
if($content_template=="user_resign/user_resign_list.php" || $content_template=="user_resign/resignation.php")  
include_once 'jscripts/user_resign_list_js.php';

if($content_template=="fnf/user_fnf.php") include_once 'jscripts/user_fnf_js.php';
if($content_template=="fnf/reports_archieve.php") include_once 'jscripts/user_fnf_js.php';
if($content_template=="wfh_assets/wfh_assets.php") include_once 'jscripts/wfh_assets/wfh_assets_js.php';
if($content_template=="wfh_assets/wfh_return.php") include_once 'jscripts/wfh_assets/wfh_assets_js.php';
if($content_template=="wfh_assets/wfh_reports.php") include_once 'jscripts/wfh_assets/wfh_assets_js.php';


/////User History//////
if($content_template=="user_history/add.php") include_once 'jscripts/user_history_js.php';


/////User Policy//////
if(strpos($content_template, 'policy') !== false){
	include_once 'jscripts/policy_js.php';
}


/////User Process Update//////
if(strpos($content_template, 'process_update') !== false){
	include_once 'jscripts/process_update_js.php';
}


//////DFR/////////
// if(strpos($content_template, 'dfr') !== false){
// 	include_once 'jscripts/dfr_js.php';
// 	include_once 'jscripts/dfr_can_assets_js.php';
// }

$dfr_check = substr($content_template, 0, 4);
if ($dfr_check != "dfr_") {
	if(strpos($content_template, 'dfr') !== false){		
		include_once 'jscripts/dfr_js.php';
		include_once 'jscripts/dfr_can_assets_js.php';
	}
}


if($content_template=="clientlogin/client_dfr.php") include_once 'jscripts/dfr_dashboard/client_dfr_dashboard_js.php';


///////Employee Movement///////
if(strpos($content_template, 'map_l1super') !== false){
	include_once 'jscripts/map_l1super_js.php';
}


if($content_template=="metrix/upload.php") include_once 'jscripts/metrix_js.php';
if($content_template=="metrix/metrix_screen.php") include_once 'jscripts/metrix_js.php';


if($content_template=="pmetrix/kpi_design.php") include_once 'jscripts/pmetrix_js.php';
if($content_template=="pmetrix/metrix_screen.php") include_once 'jscripts/pmetrix_js.php';
if($content_template=="pmetrix/metrix_screen_agent.php") include_once 'jscripts/pmetrix_js.php';
if($content_template=="pmetrix/metrix_screen_summary.php") include_once 'jscripts/pmetrix_js.php';
if($content_template=="pmetrix/upload.php") include_once 'jscripts/pmetrix_js.php';


if($content_template=="pmetrix_v2/upload.php") include_once 'jscripts/pmetrix_js_v2.php';
if($content_template=="pmetrix_v2/kpi_design.php" || 
	$content_template=="pmetrix_blended/blended_kpi_design.php" || 
	$content_template=="pmetrix_blended/blended_metrix_show.php"
	) include_once 'jscripts/pmetrix_js_v2.php';
	
if($content_template=="pmetrix_blended/blended_edit_kpi_design.php" 
	|| $content_template=="pmetrix_blended/upload.php"
	|| $content_template=="pmetrix_blended/blended_kpi_design.php"
	|| $content_template=="pmetrix_blended/blended_metrix_show.php" 
	|| $content_template=="pmetrix_blended/pm_blended_agent_view.php" 
	|| $content_template=="pmetrix_blended/pm_blended_tl_view.php" 
	|| $content_template=="pmetrix_blended/pm_blended_management_view.php" 
	|| $content_template=="pmetrix_blended/pm_blended_reports_view.php" 
	) include_once 'jscripts/pm_blended_js.php';

	
/* if(strpos($content_template, 'pmetrix_v2') !== false){
	include_once 'jscripts/pmetrix_js_v2.php';
} */



/////==================== DFR DASHBOARD STARTS  ================================/////////////////////

if($content_template=="dfr/dfr_dashboard_view.php") include_once 'jscripts/dfr_dashboard/dfr_dashboard_js.php';

////==================== DFR DASHBOARD ENDS ===========================//////////////////////


if($content_template=="break_monitor/break_monitor.php") include_once 'jscripts/break_monitor_js.php';

if($content_template=="servicerequest/index.php" || 
	$content_template=="servicerequest/ticket.php" || 
	$content_template=="servicerequest/dashboard.php" || 
	$content_template=="servicerequest/add_category.php" || 
	$content_template=="servicerequest/add_sub_category.php" || 
	$content_template=="servicerequest/add_sub_category_pre_assign.php" || 
	$content_template=="servicerequest/add_category_pre_assign.php" || 
	$content_template=="servicerequest/edit_ticket.php" || 
	$content_template=="servicerequest/reports.php" 
) include_once 'jscripts/servicerequest_js.php';


if(strpos($content_template, 'qa_servicerequest') !== false) include_once 'jscripts/qa_servicerequest_js.php';



/////==================== HIERARCHY STARTS  ================================/////////////////////

if($content_template=="hierarchy/organisation.php") include_once 'jscripts/hierarchy/organisation_js.php';
if($content_template=="hierarchy/myteam.php") include_once 'jscripts/hierarchy/myteam_js.php';
if($content_template=="hierarchy/myallteam.php") include_once 'jscripts/hierarchy/myallteam_js.php';
if($content_template=="hierarchy/myupteam.php") include_once 'jscripts/hierarchy/myallteam_js.php';

////==================== HIERARCHY ENDS ===========================//////////////////////



/////

if(strpos($content_template, 'payslip') !== false){
	include_once 'jscripts/payslip_js.php';
}


/////User Album//////
if(strpos($content_template, 'album') !== false){
	include_once 'jscripts/album_js.php';
}



/////==================== KNOWLEDGE BASE STARTS ================================/////////////////////

if($content_template=="knowledge_base/entry.php") include_once 'jscripts/knowledge_base/entry_js.php';
if($content_template=="knowledge_base/main.php") include_once 'jscripts/knowledge_base/main_js.php';
if($content_template=="knowledge_base/video.php") include_once 'jscripts/knowledge_base/main_js.php';
if($content_template=="knowledge_base/editentry.php") include_once 'jscripts/knowledge_base/editentry_js.php';

/////==================== KNOWLEDGE BASE ENDS ================================/////////////////////



if($content_template=="album/album_dashboard.php") include_once 'jscripts/album_js.php';

if($content_template=="employee_feedback/index.php") include_once 'jscripts/employee_feedback_js.php';
if($content_template=="employee_feedback/done_employee_feedback.php") include_once 'jscripts/employee_feedback_js.php';
if($content_template=="employee_feedback/feedbackdetails.php") include_once 'jscripts/employee_feedback_js.php';
if($content_template=="employee_feedback/raw_report.php") include_once 'jscripts/employee_feedback_js.php';

if($content_template=="faq/create_category.php") include_once 'jscripts/faq/create_category_js.php';
if($content_template=="faq/create_faq_message.php") include_once 'jscripts/faq/create_faq_message_js.php';
if($content_template=="faq/faqs.php") include_once 'jscripts/faq/faq_js.php';
if($content_template=="faq/create_message.php") include_once 'jscripts/faq/create_message_js.php';
if($content_template=="faq/unread_message.php") include_once 'jscripts/faq/unread_message_js.php';

if($content_template=="message/create_message.php") include_once 'jscripts/message/create_message_js.php';
if($content_template=="message/unread_message.php") include_once 'jscripts/message/unread_message_js.php';

if($content_template=="master/leave_user_assignment.php") include_once 'jscripts/leave_js.php';


if($content_template=="report_center/report_center.php") include_once 'jscripts/report_center/report_center_js.php';

//////////BCP Survey/////////////
//if(strpos($content_template, 'bcp_survey') !== false) include_once 'jscripts/bcp_survey_js.php';


/////////QA Grubhub////////////
if(strpos($content_template, 'qa_grubhub') !== false){
	include_once 'jscripts/qagrubhub_js.php';
}

/////////QA OYO////////////
if($content_template=="qa_oyo/inbound_sales.php" || $content_template=="qa_oyo/inbound_sales_edit.php") include_once 'jscripts/qa_oyo/inbound_sale_js.php';
if($content_template=="qa_oyo/search_inbound_sales.php") include_once 'jscripts/qa_oyo/inbound_sale_js.php';
if($content_template=="qa_oyo/show_inbound_sales.php") include_once 'jscripts/qa_oyo/process_review_js.php';

/////////QA Office Depot////////////
if(strpos($content_template, 'qa_od') !== false){
	include_once 'jscripts/qa_od_js.php';
}

/////////QA OYO Feedback////////////
if(strpos($content_template, 'qa_oyo_sig') !== false){
	include_once 'jscripts/qa_oyo_sig_js.php';
}

if(strpos($content_template, 'qa_oyo_rca') !== false) include_once 'jscripts/qa_oyo_rca_js.php';
if(strpos($content_template, 'qa_oyosig_rca') !== false) include_once 'jscripts/qa_oyo_rca_js.php';

if(strpos($content_template, 'qa_dashboard') !== false){
	include_once 'jscripts/qa_dashboard_js.php';
}

//////QA Meesho Feedback/////////
if(strpos($content_template, 'qa_meesho') !== false) include_once 'jscripts/qa_meesho_js.php';

//////QA OYO LIFE Feedback/////////
if(strpos($content_template, 'qa_oyolife') !== false) include_once 'jscripts/qa_oyolife_js.php';

//////QA VERSO Feedback/////////
if(strpos($content_template, 'qa_verso') !== false) include_once 'jscripts/qa_verso_js.php';

//////////QA PuppySpot / Welcomepickup/////////////
if(strpos($content_template, 'qa_puppyspot') !== false) include_once 'jscripts/qa_puppyspot_js.php';
if(strpos($content_template, 'qa_welcome_pickups') !== false) include_once 'jscripts/qa_puppyspot_js.php';

//////////QA VRS/////////////
if($content_template=="qa_vrs/add_jrpa_feedback.php" || $content_template=="qa_vrs/agent_vrs_jrpa_feedback_rvw.php" || $content_template=="qa_vrs/mgnt_vrs_jrpa_feedback_rvw.php" || $content_template=="qa_vrs/add_rpaudit_feedback_analysis.php"|| $content_template=="qa_vrs/mgnt_vrs_rp_analysis_feedback_rvw.php" || $content_template=="qa_vrs/add_rp_new.php" || $content_template=="qa_vrs/mgnt_vrs_rp_new.php" || $content_template=="qa_vrs/vrs_thirdparty/add_edit_vrs_thirdparty.php"){
	include_once 'jscripts/qa_vrs_2_js.php';
}else{
	if(strpos($content_template, 'qa_vrs') !== false) include_once 'jscripts/qa_vrs_js.php';
}

//////////QA MSB/////////////
	if(strpos($content_template, 'qa_msb') !== false) include_once 'jscripts/qa_msb_js.php';

//////////QA OYOINB/////////////
	if(strpos($content_template, 'qa_oyoinb') !== false) include_once 'jscripts/qa_oyo_inb_js.php';

//////////QA RugDoctor/////////////
if(strpos($content_template, 'qa_rugdoctor') !== false) include_once 'jscripts/qa_rugdoctor_js.php';

//////////QA Homeadvisor/////////////
if(strpos($content_template, 'qa_homeadvisor') !== false) include_once 'jscripts/qa_homeadvisor_js.php';
//////////QA Craftjack/////////////
if(strpos($content_template, 'qa_craftjack') !== false) include_once 'jscripts/qa_craftjack_js.php';

///-------- LEAVE ------------------////
if((in_array(get_user_office_id(), array("ALB","KOS","COL","ELS")) || isPhilLocation()) && $content_template=="leave/index.php") include_once 'jscripts/apply_leave_alb_kos_js.php';
elseif($content_template=="leave/index.php") include_once 'jscripts/apply_leave_js.php';

if($content_template=="leave/leave_approval.php") include_once 'jscripts/leave_approval_js.php';
if($content_template=="leave/leave_access_location.php") include_once 'jscripts/leave_access_location_js.php';
if($content_template=="leave/reports.php") include_once 'jscripts/leave_reports_js.php';
if($content_template=="leave/cebu_extra_leaves.php") include_once 'jscripts/cebu_extra_leaves_js.php';


/////==================== TRAINING ASSESSMENT STARTS ================================/////////////////////

if(strpos($content_template, 'training') !== false) include_once 'jscripts/training/training_js.php';
if($content_template=="training/nesting_summary.php") include_once 'jscripts/training/nesting_js.php';
if($content_template=="training/nesting_alignment.php") include_once 'jscripts/training/nesting_js.php';
if($content_template=="training/nesting_details.php") include_once 'jscripts/training/nesting_js.php';
if($content_template=="training/nesting_rag_details.php") include_once 'jscripts/training/nesting_rag_js.php';
if($content_template=="training/training_nesting_rag_design.php") include_once 'jscripts/training/nesting_rag_js.php';

if($content_template=="training/audit_details.php") include_once 'jscripts/training/training_audit_js.php';
if($content_template=="training/training_audit_design.php") include_once 'jscripts/training/training_audit_js.php';

if($content_template=="training/refresher_tni_design.php") include_once 'jscripts/training/refresher_tni_design_js.php';
if($content_template=="training/refresher_tni_details.php") include_once 'jscripts/training/refresher_tni_design_js.php';

if($content_template=="training/refresher_bqm_design.php") include_once 'jscripts/training/refresher_bqm_design_js.php';
if($content_template=="training/refresher_bqm_details.php") include_once 'jscripts/training/refresher_bqm_design_js.php';

if($content_template=="training/refresher_soft_design.php") include_once 'jscripts/training/refresher_soft_design_js.php';
if($content_template=="training/refresher_soft_details.php") include_once 'jscripts/training/refresher_soft_design_js.php';

if($content_template=="training/training_nesting_design.php") include_once 'jscripts/training/nesting_js.php';
if($content_template=="training/training_batch_rag_design.php") include_once 'jscripts/training/training_batch_design_js.php';
if($content_template=="training/testingqa.php") include_once 'jscripts/training/training_test_qa_js.php';
if($content_template=="training/create_batch.php") include_once 'jscripts/training/training_batch_modify_js.php';
if($content_template=="training/training_agent_survey_reports.php") include_once 'jscripts/training/training_batch_modify_js.php';

if($content_template=="training/recursive_batch.php") include_once 'jscripts/training/recursive_js.php';
if($content_template=="training/recursive_details.php") include_once 'jscripts/training/recursive_js.php';
if($content_template=="training/recursive_design.php") include_once 'jscripts/training/recursive_js.php';
if($content_template=="training/recursive_rag_details.php") include_once 'jscripts/training/recursive_rag_js.php';
if($content_template=="training/recursive_rag_design.php") include_once 'jscripts/training/recursive_rag_js.php';
if($content_template=="training/recursive_incub_design.php") include_once 'jscripts/training/recursive_incub_js.php';
if($content_template=="training/recursive_incub_details.php") include_once 'jscripts/training/recursive_incub_js.php';

if($content_template=="training/upskill_batch.php") include_once 'jscripts/training/upskill_js.php';
if($content_template=="training/upskill_details.php") include_once 'jscripts/training/upskill_js.php';
if($content_template=="training/upskill_design.php") include_once 'jscripts/training/upskill_js.php';
if($content_template=="training/upskill_rag_details.php") include_once 'jscripts/training/upskill_rag_js.php';
if($content_template=="training/upskill_rag_design.php") include_once 'jscripts/training/upskill_rag_js.php';
if($content_template=="training/upskill_incub_design.php") include_once 'jscripts/training/upskill_incub_js.php';
if($content_template=="training/upskill_incub_details.php") include_once 'jscripts/training/upskill_incub_js.php';

/////==================== TRAINING ASSESSMENT ENDS ================================/////////////////////


//////KAT Check/////////
if($content_template=="kat/kat.php") include_once 'jscripts/kat/kat_js.php';

//////QA DIP Check/////////
if(strpos($content_template, 'qa_dipcheck') !== false) include_once 'jscripts/qa_dipcheck/qa_dipcheck_js.php';

//////////QA Checkpoint/////////////
if(strpos($content_template, 'qa_checkpoint') !== false) include_once 'jscripts/qa_checkpoint_js.php';

//////////QA Checkpoint email/////////////
if(strpos($content_template, 'qa_checkpoint_email') !== false) include_once 'jscripts/qa_checkpoint_email_js.php';

//////////QA Checkpoint chat/////////////
if(strpos($content_template, 'qa_checkpoint_chat') !== false) include_once 'jscripts/qa_checkpoint_chat_js.php';

/////////////////RPM & SENTRY/////////////////////
if(strpos($content_template, 'qa_welcome_pickups') !== false) include_once 'jscripts/qa_welcome_pickups_js.php';
if(strpos($content_template, 'qa_rpm_sentry') !== false) include_once 'jscripts/qa_rpm_sentry_js.php';

//////////QA Amazon Intake/////////////
if(strpos($content_template, 'qa_amazon_intake') !== false) include_once 'jscripts/qa_amazon_intake_js.php';
//////////QA Novasom/////////////
if(strpos($content_template, 'qa_novasom') !== false) include_once 'jscripts/qa_novasom_js.php';

////////// QA:- Metropolis/Swiggy/Paynearby/ACM/Jury's Inn/IndiaBulls/Araca/Kiwi/Entice Energy/DoubtNut /////////////
if(strpos($content_template, 'qa_metropolis') !== false || strpos($content_template, 'qa_swiggy') !== false || strpos($content_template, 'qa_paynearby') !== false || strpos($content_template, 'qa_acm') !== false || strpos($content_template, 'qa_jurys_inn') !== false || strpos($content_template, 'qa_indiabulls') !== false || strpos($content_template, 'qa_araca') !== false || strpos($content_template, 'qa_kiwi') !== false || strpos($content_template, 'qa_superdaily') !== false || strpos($content_template, 'qa_agent_coaching') !== false || strpos($content_template, 'qa_entice_energy') !== false || strpos($content_template, 'qa_doubtnut') !== false)
	
include_once 'jscripts/qa_metropolis_js.php';


//////////QA AMERIDIAL/////////////
if(strpos($content_template, 'qa_ameridial') !== false) include_once 'jscripts/qa_ameridial_js.php';

///  course section
if(strpos($content_template, 'course') !== false){ 
	include_once 'jscripts/course/course_js.php'; 
	include_once 'jscripts/course/course_slideshow_js.php' ; 
	include_once 'jscripts/course/search_js.php';
}


/////==================== COVID CASE STARTS ================================/////////////////////
if(strpos($content_template, 'covid19_case') !== false) include_once 'jscripts/covid19_case/covid_form_js.php';
if($content_template=="covid19_case/covid_case_calendar.php") include_once 'jscripts/covid19_case/covid_calendar_js.php';
if($content_template=="covid19_case/covid_case_form_transmission.php") include_once 'jscripts/covid19_case/covid_calendar_js.php';
if($content_template=="covid19_case/covid_case_form_list.php") include_once 'jscripts/covid19_case/covid_case_list_js.php';
if($content_template=="covid19_case/covid_case_form_individual_list.php") include_once 'jscripts/covid19_case/covid_case_list_js.php';

/////==================== CONTACT TRACING ================================/////////////////////
//if(strpos($content_template, 'contact_tracing') !== false) include_once 'jscripts/contact_tracing/contact_tracing_form_js.php';

/////==================== QA CONTACT TRACING ================================/////////////////////
if(strpos($content_template, 'qa_contact_tracing') !== false) include_once 'jscripts/qa_contact_tracing/qa_contact_tracing_js.php';

/////==================== JURRYS INN CRM ================================/////////////////////
if(strpos($content_template, 'jurys_inn') !== false) include_once 'jscripts/jurys_inn/jurys_inn_form_js.php';

/////==================== DOCUSIGN T2 CAPABILITIES ================================/////////////////////
if(strpos($content_template, 't2_capabilities') !== false) include_once 'jscripts/t2_capabilities/docusign_form_js.php';

/////==================== QA GRAPH STARTS ================================/////////////////////

if($content_template=="qa_graph/qa_graph_score_test.php") include_once 'jscripts/qa_graph/qa_graph_score_test_js.php';
if($content_template=="qa_graph/qa_ops_view.php") include_once 'jscripts/qa_graph/qa_ops_view_js.php';
if($content_template=="qa_graph/qa_global_view.php") include_once 'jscripts/qa_graph/qa_global_view_js.php';
if($content_template=="qa_graph/qa_lead_view.php") include_once 'jscripts/qa_graph/qa_lead_view_js.php';

////==================== QA GRAPH ENDS ===========================//////////////////////




/////==================== ACTIVITIES LOGGER STARTS ================================/////////////////////

if($content_template=="activities/monitoring.php") include_once 'jscripts/activities/monitoring_js.php';
if($content_template=="activities/monitoring2.php") include_once 'jscripts/activities/monitoring_js.php';
if($content_template=="activities/monitoring3.php") include_once 'jscripts/activities/monitoring_js.php';
if($content_template=="activities/teammonitoring.php") include_once 'jscripts/activities/monitoring_js.php';
if($content_template=="activities/teammonitoring2.php") include_once 'jscripts/activities/monitoring_js.php';
if($content_template=="activities/teammonitoring3.php") include_once 'jscripts/activities/monitoring_js.php';

if($content_template=="egaze/dashboard.php") include_once 'jscripts/egaze/egaze_js.php';
if($content_template=="egaze/teammonitoring.php") include_once 'jscripts/egaze/egaze_js.php';
if($content_template=="egaze/individual.php") include_once 'jscripts/egaze/egaze_js.php';
if($content_template=="egaze/mydashboard.php") include_once 'jscripts/egaze/egaze_js.php';
if($content_template=="egaze/download_report.php") include_once 'jscripts/egaze/egaze_reports_js.php';

////==================== ACTIVITIES LOGGER  ENDS ===========================//////////////////////

////////// Covid-19 /////////////
if(strpos($content_template, 'covid19_pre_check') !== false) include_once 'jscripts/covid19_pre_check_js.php';


/////==================== SURVEY STARTS  ================================/////////////////////
if($content_template=="survey/copc_form.php") include_once 'jscripts/survey/survey_copc_js.php';
if($content_template=="survey/copc_reports_graphical.php") include_once 'jscripts/survey/survey_copc_graphical_js.php';
/////==================== SURVEY ENDS  ================================/////////////////////

/////==================== SCHEDULE ADHERENCE STARTS  ================================/////////////////////
if(strpos($content_template, 'schedule_adherence') !== false) include_once 'jscripts/schedule_adherence/adherence_js.php';
if($content_template=="schedule_adherence/agent_level.php") include_once 'jscripts/schedule_adherence/agent_adherence_js.php';
if($content_template=="schedule_adherence/team_level.php") include_once 'jscripts/schedule_adherence/team_adherence_js.php';
if($content_template=="schedule_adherence/manager_level.php") include_once 'jscripts/schedule_adherence/manager_adherence_js.php';
/////==================== SCHEDULE ADHERENCE  ENDS  ================================/////////////////////


/////==================== LETTER JS STARTS  ================================/////////////////////
if(strpos($content_template, 'letter') !== false) include_once 'jscripts/letter/letter_home_js.php';

/////==================== LETTER JS ENDS  ================================/////////////////////


if($content_template=="leave/cebu_regularization.php") include_once 'jscripts/cebu_regularization.php';


/////======================= Emat New SENTIENT JET CRM -08-02-2022===========================/////////////

if(strpos($content_template, 'emat_new') !== false) include_once 'jscripts/emat_new/emat_new_form_js.php';

////==================== Emat New SENTIENT JET CRM END================================/////////////////////
///===================== Terminate User===============================================////////////////////
if($content_template=="super/dashboard.php" || 
	$content_template=="training/training.php" || $content_template=="hr/dashboard.php" ||
	$content_template=="user/manage_users.php" ){
		include_once 'jscripts/term_user_js.php';
	}
?>