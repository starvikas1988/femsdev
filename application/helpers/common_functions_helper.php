<?php

$CI = & get_instance();

function gen_csrf_token() {
    global $CI;
    $csrf_token = bin2hex(openssl_random_pseudo_bytes(12));
    $CI->session->set_userdata('FEMSCSRFTOKEN', $csrf_token);
    return $csrf_token;
}

////////////////////////////////////////////////////////////////////////////////////
//  Check PRE Logged In
////////////////////////////////////////////////////////////////////////////////////

function check_pre_logged_in() {
    global $CI;
    if ($CI->session->userdata('pre_logged_in'))
        return True;
    else {
        if (!$CI->input->is_cli_request())
            redirect(base_url(), "refresh");
    }
}

function get_pre_user_id() {
    global $CI;
    $rr = $CI->session->userdata('pre_logged_in');
    if (check_pre_logged_in())
        return $rr["id"];
}

function get_pre_user_fusion_id() {
    global $CI;
    $rr = $CI->session->userdata('pre_logged_in');
    if (check_pre_logged_in())
        return $rr["fusion_id"];
}

function get_pre_username() {
    global $CI;
    $rr = $CI->session->userdata('pre_logged_in');
    if (check_pre_logged_in())
        return ucwords($rr["name"]);
}

function get_pre_status() {
    global $CI;
    $rr = $CI->session->userdata('pre_logged_in');
    if (check_pre_logged_in())
        return $rr["status"];
}

function get_pre_login_type() {
    global $CI;
    $rr = $CI->session->userdata('pre_logged_in');
    if (check_pre_logged_in())
        return $rr["login_type"];
}

function get_pre_enable_2fa() {
    global $CI;
    $rr = $CI->session->userdata('pre_logged_in');
    if (check_pre_logged_in())
        return $rr["is_enable_2fa"];
}

function get_pre_email_id_off() {
    global $CI;
    $rr = $CI->session->userdata('pre_logged_in');
    if (check_pre_logged_in())
        return $rr["email_id_off"];
}

function get_pre_email_id_per() {
    global $CI;
    $rr = $CI->session->userdata('pre_logged_in');
    if (check_pre_logged_in())
        return $rr["email_id_per"];
}

function get_pre_phone() {
    global $CI;
    $rr = $CI->session->userdata('pre_logged_in');
    if (check_pre_logged_in())
        return $rr["phone"];
}

function get_pre_varify_email() {
    global $CI;
    $rr = $CI->session->userdata('pre_logged_in');
    if (check_pre_logged_in())
        return $rr["is_varify_email"];
}

////////////////////////////////////////////////////////////////////////////////////
//  Check Logged In
////////////////////////////////////////////////////////////////////////////////////

function check_logged_in() {
    global $CI;
    if ($CI->session->userdata('logged_in'))
        return True;
    else {
        if (!$CI->input->is_cli_request())
            redirect(base_url(), "refresh");
    }
}

////////////////////////////////////////////////////////////////////////////////////
// Header Refresher
////////////////////////////////////////////////////////////////////////////////////

function header_refresher() {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");
}

function get_login_type() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["login_type"];
}

/////////////////// Client



function get_clients_client_name() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["client_name"];
}

function get_clients_client_id() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["client_id"];
}

function get_clients_process_id() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["process_id"];
}

function get_clients_allow_qa_module() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_qa_module"];
}

function get_clients_allow_qa_audit() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_qa_audit"];
}

function get_clients_allow_qa_review() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_qa_review"];
}

function get_clients_allow_mind_faq() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_mind_faq"];
}

function get_clients_allow_qa_dashboard() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_qa_dashboard"];
}

function get_clients_allow_qa_dipcheck() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_qa_dipcheck"];
}

function get_clients_allow_qa_report() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_qa_report"];
}

function get_clients_allow_calibration() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_calibration"];
}

function is_access_client_qa_feedback() {

    if (get_login_type() == "client") {
        if (get_clients_allow_qa_audit() == '1')
            return true;
        else
            return false;
    } else {
        return false;
    }
}

function is_access_client_qa_review() {

    if (get_login_type() == "client") {
        if (get_clients_allow_qa_review() == '1')
            return true;
        else
            return false;
    } else {
        return false;
    }
}

function get_clients_allow_dfr_interview() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_dfr_interview"];
}

function get_clients_allow_dfr_report() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_dfr_report"];
}

function get_clients_allow_kyt_crm() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_kyt"];
}

function get_clients_allow_diy_crm() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_diy"];
}

function get_clients_allow_naps() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["allow_naps"];
}

#***********************************************************************************
#  Client Menu 
#***********************************************************************************

function get_client_qa_menu() {
    global $CI;
    $client_id = get_clients_client_id();
    $process_id = get_clients_process_id();

    $qSQL = "SELECT id,name,qa_url FROM process where client_id in ($client_id) and id in ($process_id) and qa_url!='' and is_active=1";
    //echo $qSQL;
    $query = $CI->db->query($qSQL);
    return $query->result_array();
}

function get_rta_rejection_count(){
    global $CI;
    

    $qSQL = "SELECT count(id) as cnt  FROM `training_details` WHERE `send_rta` = 1 and rta_status='0'";
    //echo $qSQL;
    $query = $CI->db->query($qSQL);
    if($query->num_rows()>0){
        $row= $query->result_array();
        return $row[0]['cnt'];    
    }
    else{
        return 0;
    }

    
}

function get_operation_rejection_count(){
    global $CI;
    $qSQL = "SELECT count(td.id) as cnt,GROUP_CONCAT(td.id),GROUP_CONCAT(td.trn_batch_id),count(td.trn_batch_id) FROM `signin` s INNER JOIN training_details td ON td.user_id=s.id INNER JOIN training_batch tb ON tb.id=td.trn_batch_id WHERE td.handover_date>= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d'),INTERVAL 3 DAY) and td.handover_date is not null and td.is_handover='1' and td.send_rta='0' ";
    // echo $qSQL;die;
    $query = $CI->db->query($qSQL);
    if ($query->num_rows() > 0) {
        $row= $query->result_array();
        return $row[0]['cnt'];
    } else {
        return 0;
    }


}

function get_client_qa_report_menu() {
    global $CI;
    $client_id = get_clients_client_id();
    $process_id = get_clients_process_id();

    $qSQL = "SELECT id,shname,qa_report_url FROM client where id in ('$client_id') and qa_report_url!='' and is_active=1";
    //echo $qSQL;
    $query = $CI->db->query($qSQL);
    return $query->result_array();
}

function get_client_qa_report_link() {
    global $CI;
    $client_id = get_clients_client_id();
    $process_id = get_clients_process_id();

    $qSql = "SELECT qa_report_url as value FROM client where id in ('$client_id') and qa_report_url!='' and is_active=1 limit 1";

    $query = $CI->db->query($qSql);
    if ($query->num_rows() > 0) {
        $res = $query->row_array();
        return $res["value"];
    } else {
        return "";
    }
}

////////////////////
////////////////////////////////////////////////////////////////////////////////////
//  News Access
////////////////////////////////////////////////////////////////////////////////////

function news_access_permission() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCAS000078#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function news_read_permission() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCAS000078#FCAS000004#FCAS000004#FCAS000006#FCAS000597#FCAS000009#FCAS000012#FCAS000030#FCAS000015"
            . "#FCAS000058#FCAS000016#FCAS000018#FCAS000019#FCAS000020#FCAS000022#FCAS000023#FCAS000025#FCAS000026"
            . "#FCAS000161#FCAS000028#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

////////////////////////////////////////////////////////////////////////////////////
//  Get Username
////////////////////////////////////////////////////////////////////////////////////

function get_username() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return ucwords($rr["name"]);
}

////////////////////////////////////////////////////////////////////////////////////
//  Get Dept Name
////////////////////////////////////////////////////////////////////////////////////

function get_deptname() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return ucwords($rr["dept_name"]);
}

function get_deptshname() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return ucwords($rr["dept_shname"]);
}

////////////////////////////////////////////////////////////////////////////////////
//  Get Dept Name
////////////////////////////////////////////////////////////////////////////////////

function get_dept_id() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["dept_id"];
}

////////////////////////////////////////////////////////////////////////////////////
//  Get Dept Folder
////////////////////////////////////////////////////////////////////////////////////

function get_dept_folder() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["dept_folder"];

    /* global $CI;
      $fusion_id = get_user_fusion_id() ;
      $qSQL= "SELECT d.folder AS 'department'
      FROM department d
      LEFT JOIN signin s
      ON s.dept_id = d.id
      WHERE s.fusion_id = '".$fusion_id."'";

      $query = $CI->db->query($qSQL);
      $row = $query->result_array();
      return $row[0]['department'] ; */
}

function get_dept_folder_original() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["dept_folder_original"];
}

////////////////////////////////////////////////////////////////////////////////////
//  Get Role
////////////////////////////////////////////////////////////////////////////////////

function get_role() {
    // return "ghfghf";
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["role"];
}

////////////////////////////////////////////////////////////////////////////////////
//  Get Role DIR
////////////////////////////////////////////////////////////////////////////////////

function get_role_dir() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["role_dir"];
}

function get_role_dir_original() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["role_dir_original"];
}

////////////////////////////////////////////////////////////////////////////////////
//  Get Role ID
////////////////////////////////////////////////////////////////////////////////////

function get_role_id() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["role_id"];
}

function get_global_access() {
    global $CI;
    $ret = "0";
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in()) {

        if ($rr["is_global_access"] == "1")
            $ret = "1";
        else {
            if (get_role_dir() == "super")
                $ret = "1";
        }

        return $ret;
    }
}

function get_site_admin() {
    global $CI;
    $ret = "0";
    $rr = $CI->session->userdata('logged_in');

    if (check_logged_in()) {

        if ($rr["is_site_admin"] == "1")
            $ret = "1";
        else {
            if (get_role_dir() == "admin")
                $ret = "1";
        }
        return $ret;
    }
}

function get_aside_template() {
    if (get_global_access() == '1')
        return "super/aside.php";
    else if (get_dept_folder() == "hr")
        return "hr/aside.php";
    else if (get_dept_folder() == "wfm")
        return "wfm/aside.php";
    else if (get_dept_folder() == "rta")
        return "wfm/aside.php";
    else if (get_site_admin() == "1")
        return "admin/aside.php";
    else if (get_login_type() == "client")
        return "user/client_aside.php";
    else if (is_access_cspl_my_team())
        return "wfm/aside.php";
    else
        return get_role_dir() . "/aside.php";
}

////////////////////////////////////////////////////////////////////////////////////
//  Get User` ID
////////////////////////////////////////////////////////////////////////////////////

function get_user_id() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["id"];
}

function get_user_omuid() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["omuid"];
}

function get_user_fusion_id() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["fusion_id"];
}

function get_additional_id() {
    $access_ids = "'FHWH002648','FKOL005826','FKOL012611','FKOL002157','FKOL008317','FKOL009964','FHWH008072','FMUM005769','FNOI000656','FKOL010682'";
    return $access_ids;
}

function get_user_site_id() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["site_id"];
}

function get_user_office_id() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["office_id"];
}

function get_office_id($fusion_id) {

    global $CI;

    $qSQL = "SELECT office_id FROM signin WHERE fusion_id = '" . $fusion_id . "'";

    $query = $CI->db->query($qSQL);
    $row = $query->result_array();
    return $row[0]['office_id'];
}

function get_user_company_id() {
    global $CI;
    $fusion_id = get_user_fusion_id();
    $qSQL = "SELECT brand FROM signin WHERE fusion_id = '" . $fusion_id . "'";

    $query = $CI->db->query($qSQL);
    $row = $query->result_array();
    return $row[0]['brand'];
}

function get_user_location_name() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["location_name"];
}

function get_location_country() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["location_country"];
}

function get_user_oth_office() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["oth_office"];
}

function get_update_pswd() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["is_update_pswd"];
}

function get_accept_consent() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["is_accept_consent"];
}

/* -new------------------------------- */

function get_status() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["status"];
}

function get_enable_2fa() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["is_enable_2fa"];
}

function get_email_id_off() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["email_id_off"];
}

function get_email_id_per() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["email_id_per"];
}

function get_phone() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["phone"];
}

function get_country() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["country"];
}

function get_varify_email() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["is_varify_email"];
}

/* ------------------------------------- */

/////////////////////////////////////////////////////////
//will be remove
/*
  function get_client_id()
  {
  global $CI;
  $rr = $CI->session->userdata('logged_in');
  if(check_logged_in()) return $rr["client_id"];
  }
 */
//will be remove
/*
  function get_process_id()
  {
  global $CI;
  $rr = $CI->session->userdata('logged_in');
  if(check_logged_in()) return $rr["process_id"];
  }
 */
////////////////////////////////////////////////////////

function get_client_ids() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["client_ids"];
}

function get_client_names() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["client_names"];
}

function get_process_ids() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["process_ids"];
}

function get_process_names() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["process_names"];
}

function get_assigned_to() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["assigned_to"];
}

function get_assigned_to_name() {
    global $CI;

    $rr = $CI->session->userdata('logged_in');
    if ($rr["assigned_to"] == "") {
        return "";
    } else {
        $query = $CI->db->query("select fname, lname from signin where id = '" . $rr["assigned_to"] . "'");
        $res = $query->row_array();

        if (check_logged_in())
            return ucwords($res["fname"] . " " . $res["lname"]);
    }
}

function getLoginIP() {
    global $CI;
    $UserLocalIP = $CI->session->userdata('UserLocalIP');
    $ip = getClientIP(); // $_SERVER['REMOTE_ADDR'];
    $browser = $_SERVER['HTTP_USER_AGENT'];

    //$user_name=get_username();
    //$user_fid=get_user_fusion_id();
    //$cuur_date_fid=CurrMySqlDate();

    $log = " RemoteIP: " . $ip . ", LocalIP:" . $UserLocalIP;
    // . " Browser:".$browser;

    return $log;
}

function get_logs($prev = "") {
    global $CI;
    $UserLocalIP = $CI->session->userdata('UserLocalIP');
    $ip = getClientIP(); // $_SERVER['REMOTE_ADDR'];
    $browser = $_SERVER['HTTP_USER_AGENT'];

    $user_name = get_username();
    $user_fid = get_user_fusion_id();
    $cuur_date_fid = CurrMySqlDate();

    $log = "User: " . $user_name . " FID: " . $user_fid . " Date: " . $cuur_date_fid . " RemoteIP: " . $ip . ", LocalIP:" . $UserLocalIP . " Browser:" . $browser;

    if ($prev != "")
        $log .= " ## " . $prev;

    return $log;
}

//////////////////////////////////////////////////////////
//////////////// Survey Helper //////////////////////////
/////////////////////////////////////////////////////////

function participation_survey_users_permission() {

    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $user_office = get_user_office_id();

    $access_ids = array("FKOL008610");

    $access_locations = array("CAS");

    if (in_array($ses_fusion_id, $access_ids)) {
        $ret = true;
    } else if (in_array($user_office, $access_locations)) {
        $ret = true;
    } else
        $ret = false;

    return $ret;
}

function important_survey_users_permission() {

    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $user_office = get_user_office_id();

    $access_ids = array("FKOL012410");

    $access_locations = array("CAS");

    if (in_array($ses_fusion_id, $access_ids)) {
        $ret = true;
    } else if (in_array($user_office, $access_locations)) {
        $ret = true;
    } else
        $ret = false;

    return $ret;
}

#*******************************************************
# Imp Notice PNB Inbound User Acknowledgement
#*******************************************************

function imp_notice_PNB_ibound_user() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = array("FHWH009167", "FHWH009168", "FHWH009169", "FHWH009171", "FHWH009172", "FHWH008729",
        "FHWH005673", "FHWH008651", "FHWH007679", "FHWH008914", "FHWH007919", "FHWH008913", "FHWH008911",
        "FHWH008915", "FHWH002550", "FHWH006209", "FHWH008392", "FHWH008405", "FHWH007928", "FHWH007692",
        "FHWH008910", "FHWH007930", "FHWH007695", "FHWH009168", "FHWH009169", "FHWH009172", "FHWH009167",
        "FHWH008729", "FHWH007679", "FHWH008651", "FHWH007924", "FHWH007101", "FHWH007096", "FHWH005947",
        "FHWH005804", "FHWH007704", "FHWH005805", "FHWH007927", "FHWH007935", "FHWH006211", "FHWH002507",
        "FHWH007100", "FHWH007099", "FHWH007923", "FHWH007713", "FHWH007702", "FHWH005803", "FHWH007184",
        "FHWH005274", "FHWH007708", "FHWH007934", "FKOL002948", "FHWH005026", "FHWH007705", "FHWH007921",
        "FHWH000039", "FHWH005933", "FHWH008983", "FHWH007715", "FHWH007714", "FHWH008821", "FHWH005724",
        "FCHE001920", "FCHE001921", "FCHE001938", "FCHE001923", "FCHE001924", "FHWH008594", "FKOL010196",
        "FHWH005197", "FHWH009222", "FKOL008610");

    if (in_array($ses_fusion_id, $access_ids)) {
        $ret = true;
    } else {
        $ret = false;
    }

    return $ret;
}

function getDBPrevLogs($qSql = "") {
    global $CI;
    $log = "";
    if ($qSql != "") {
        $query = $CI->db->query($qSql);
        $res = $query->row_array();
        $log = $res["log"];
    }

    return $log;
}

function get_fems_user_qa_menu() {
    global $CI;
    $client_id = get_client_ids();
    $process_id = get_process_ids();
    if ($client_id == "")
        $client_id = 99999;
    if ($process_id == "")
        $process_id = 99999;

    $qSQL = "SELECT * FROM process where client_id in ($client_id) and id in ($process_id) and qa_agent_url!='' and is_active=1";

    //echo $qSQL;
    $query = $CI->db->query($qSQL);
    return $query->result_array();
}

////////////////////////////////////////////////////////////////////////////////////
//  Module Access
////////////////////////////////////////////////////////////////////////////////////


function isDisableFemsLogin($user_login_id) {

    //remove FHWH005113 & FHWH005211 for hr request
    //FKOL005012 XPO10963 FKOL003489, FKOL005735 XPO12070, FKOL003662	XPO8701
    // FKOL003498 XPO9060
    // Sheema Khatoon	FKOL004717 XPO10650	OYOLIFE
    // Supriya Roy	FKOL004395 XPO10306	OYOLIFE
    // FKOL002404 XPO8236 - Ankita
    //FKOL006212 FKOL004688

    $ret = false;
    //$disable_fems_ids="-##FKOL002847#FKOL004624#FKOL004795#FBLR000463#FBLR000506#FBLR000549#";		
    //$disable_omuid_ids="-##XPO8615#XPO10549#XPO10715#FBLR000463#FBLR000506#FBLR000549#";
    $disable_fems_ids = "-##";
    $disable_omuid_ids = "-##";

    if (strpos($disable_fems_ids, "#" . $user_login_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if ($ret == false) {
        if (strpos($disable_omuid_ids, "#" . $user_login_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function isDisableModule() {


    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();
    $ret = false;

    $disable_ids = "--#FKOL001747#";
    if (strpos($disable_ids, "#" . $ses_fusion_id . "#") > 0)
        $ret = true;

    return $ret;
}

function is_enable_coaching_break() {

    /*
      Ethel Jane Emos CEBU FCEB005954
      Shirame Alvarez CEBU FCEB005955
      Alvaro Efigenio ESAL FELS005633
      Jorge Barahona ESAL FELS005632
      FCEB004073 , FCEB003975
     */

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB005954#FCEB005955#FELS005633#FELS005632#FCEB004073#FCEB003975#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_user_office_id() == "CEB" || get_user_office_id() == "ELS" || get_user_office_id() == "MAN" || get_dept_folder() == "transformation" || get_dept_folder() == "wfm")
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            //CentreLake Imaging
            if (in_array('221', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_enable_my_team() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "##FKOL011173#FKOL005386#FKOL007211#FKOL011173#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_enable_search() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL011173#FKOL005386#FKOL007211#FBLR000155#FKOL011554#FKOL003040#FKOL012336#FKOL008636#FKOL012753#FCAS000176#FCEB004450#FKOL002240#FKOL004856#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (get_site_admin() == '1')
        $ret = true;

    if (get_dept_folder() == "hr" || get_dept_folder() == "Recruitment" || get_dept_folder() == "wfm" || get_dept_folder() == "rta")
        $ret = true;

    return $ret;
}

function is_access_cj_crm_modules() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB005643#FCEB005640#FCEB005637#FCEB005638#FCEB005639#FCEB005636#FCEB005635#FCEB005645#FCEB004150#FCEB005633#FCEB003880#FCEB000729#FCEB004062#FCEB003947#FCEB000580#FKOL006714#FKOL001710#FKOL008602#FKOL007078#FCEB004062#FKOL007196#FCEB006165#FCEB006166#FCEB006167#FCEB003975#";

    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;



    return $ret;
}

function is_cj_crm_admin() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "##FCEB003880#FCEB000729#FCEB004062#FCEB003947#FCEB000580#FKOL006714#FKOL001710#FKOL008602#FKOL007078#FKOL007196#FCEB003975#";

    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;



    return $ret;
}

function isDisableFemsChat() {

    // 157 -  ATT Fiber Connect
    // 1 - STI
    // 17 - Home Advisor
    // 19 Craft Jack
    // 69  HCCO - PROJECT ADVISOR

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "-#-#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('1', explode(',', $client_ids)) == true)
                $ret = true;
            else if (in_array('157', explode(',', $client_ids)) == true)
                $ret = true;
            //else if (in_array('17', explode(',',$client_ids)) == true) $ret=true;
            else if (in_array('19', explode(',', $client_ids)) == true)
                $ret = true;
            //else if (in_array('69', explode(',',$client_ids)) == true) $ret=true;
        }
    }

    return $ret;
}

function isKatAvailable() {

    /*

      FCEB000791	Lozada, Fely Rose
      Leann Lesserreh Maluay : FCEB000386
      Arlene Salahuddin FCEB005369

      FCEB003423	Basubas, Syra Jane
      FCEB004238 	Ramirez, Ester Mae
      FCEB004355	Rex Nacua
      FCEB004009	Louishena Hermida
      FCEB004889	Jaypee Sayson
      FCEB000340 Rey Mart Fajardo
      FCEB000722 Remie Jonathan Biñan
      FCEB004264	Gagote, Ivan

      Betinol, Melvin - FCEB003441
      Lapidez, Regine - FCEB000142
      Salazar, Winna Mae - FCEB000457
      Fernando Emmanuel V Moises III - FCEB004335
      Jeneva Mateo - FCEB004126
      Rey Kevin Villar - FCEB004173
      Alvin Ybañez - FCEB003947
      Judy Ann Loise Ortega - FCEB004217
      Ivan Gagote - FCEB004264
      Cromwel Maestrado - FCEB005192
      Jamaica Colina - FCEB005193
      Dave Bacus - FCEB005430
      Richard Aragon - FCEB000553
      Alfie Romina - FCEB004921
      Ivan Gagote - FCEB004264
      Dave Dominic Bacus - FCEB005430
      Richard Rae Aragon - FCEB000553

      FCEB000757 - Satiembre, Zephaniah
      FCEB005921 - Yap, Rodney Ray
      FCEB005297 - Garcia, Vivien
      FCEB004672 - Darlyn Keth Dacay
      FCEB000114 - Silverio, Wilfredo

     */

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $access_ids = " #FCEB000029#FCEB000791#FCEB003423#FCEB004238#FCEB004355#FCEB004009#FCEB004889#FCEB003880#FCEB004073#FCEB004064#FMAN000131#FMAN001057#FMAN000762#FMAN001151#FCEB003365#FCEB000078#FCEB000078#FCEB000029#FCEB004335#FCEB000457#FMAN000410#FCEB000386#FCEB005369#FCEB000340#FCEB000722#FCEB000722#FCEB000340#FCEB003423#FCEB000383#FCEB004264#FCEB003441#FCEB000142#FCEB004126#FCEB004173#FCEB003947#FCEB004217#FCEB005192#FCEB005193#FCEB005430#FCEB000553#FCEB004921#FCEB005356#FCEB005078#FCEB000757#FCEB005921#FCEB005297#FCEB004672#FCEB000114#";

    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (get_site_admin() == '1')
        $ret = true;

    return $ret;
}

function isAccessKatExam() {

    /*

      FCEB000791	Lozada, Fely Rose

      Leann Lesserreh Maluay : FCEB000386
      Arlene Salahuddin FCEB005369

      FCEB003423	Basubas, Syra Jane
      FCEB004238 	Ramirez, Ester Mae
      FCEB004355	Rex Nacua
      FCEB004009	Louishena Hermida
      FCEB004889	Jaypee Sayson
      FCEB000340 Rey Mart Fajardo
      FCEB000722 Remie Jonathan Biñan

      Betinol, Melvin - FCEB003441
      Lapidez, Regine - FCEB000142
      Salazar, Winna Mae - FCEB000457
      Fernando Emmanuel V Moises III - FCEB004335
      Jeneva Mateo - FCEB004126
      Rey Kevin Villar - FCEB004173
      Alvin Ybañez - FCEB003947
      Judy Ann Loise Ortega - FCEB004217
      Ivan Gagote - FCEB004264
      Cromwel Maestrado - FCEB005192
      Jamaica Colina - FCEB005193
      Dave Bacus - FCEB005430
      Richard Aragon - FCEB000553
      Alfie Romina - FCEB004921
      Ivan Gagote - FCEB004264
      Dave Dominic Bacus - FCEB005430
      Richard Rae Aragon - FCEB000553

      FCEB000757 - Satiembre, Zephaniah
      FCEB005921 - Yap, Rodney Ray
      FCEB005297 - Garcia, Vivien
      FCEB004672 - Darlyn Keth Dacay
      FCEB000114 - Silverio, Wilfredo

     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL000001#FKOL000007#FCEB000004#FCEB000029#FCEB000791#FCEB003423#FCEB004238#FCEB004355#FCEB004009#FCEB004889#FCEB003880#FCEB004073#FCEB004064#FMAN000131#FMAN001057#FMAN000762#FMAN001151#FMAN001074#FCEB003365#FCEB000078#FCEB000078#FCEB000029#FCEB004335#FCEB000457#FMAN000410#FCEB000386#FCEB005369#FCEB000340#FCEB000722#FCEB000722#FCEB000340#FCEB003423#FCEB000383#FCEB004264#FCEB003441#FCEB000142#FCEB004126#FCEB004173#FCEB003947#FCEB004217#FCEB005192#FCEB005193#FCEB005430#FCEB000553#FCEB004921#FCEB005356#FCEB005078#FCEB000757#FCEB005921#FCEB005297#FCEB004672#FCEB000114#FCEB005433#FCEB000155#FCEB005424#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "wfm")
        $ret = true;

    return $ret;
}

function isAvilKatExam() {
    global $CI;
    $current_user = get_user_id();

    //$qSql= "SELECT count(id) as value  FROM lt_exam_schedule WHERE user_id = '$current_user' and module_type='KAT' and exam_status in (0,2,3)";

    $qSql = "SELECT count(lt.id) as value  FROM lt_exam_schedule lt  LEFT JOIN kat on kat.id=lt.module_id WHERE user_id = '$current_user' and module_type='KAT' and exam_status in (0,2,3) and kat.is_active=1";

    //echo $qSql;

    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

function is_access_global_mindfaq() {

    /*
      //subhajit, Rahul and Hitesh FKOL001985,FKOL005388,FKOL005828
      Amit - FKOL006573
      Manas - FKOL006998
      FKOL006390 - laltu
      FKOL008587 -  Arghya
      FKOL008598 - Debanjan
      FKOL005767 - Saswata
      //FKOL007078 - Daljeet

      Purba Hazra (FKOL002245)
      Dipan Sarkar (FKOL001854)
      Susweta Das (FKOL004812)

      Subhadip Saha (FKOL006795)
      Nilotpal Bhandary (FKOL008559)
      Srijan Biswas (FKOL006065)
      FKOL001900 - Prasanta
      FKOL001929 Prasun Das
      FKOL001961 Manash Kundu

     */

    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $access_ids = "##FKOL000001#FKOL000007#FKOL001985#FKOL005388#FKOL005828#FKOL006573#FKOL006998#FCEB004639#FKOL006390#FKOL008587#FKOL008598#FKOL005767#FKOL002702#FKOL007078#FKOL002245#FKOL001854#FKOL004812#FKOL006795#FKOL008559#FKOL006065#FKOL001900#FKOL011685#FKOL001929#FKOL001961#FKOL012753#FKOL011554#FKOL013064#FHIG000013#FKOL012858#FKOL013936#";

    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_k2crm_modules() {

    // k2 crm		
    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " ##";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('142', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_k2crm_catastrophe() {

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FMAN000375#";
    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    if (get_global_access() == '1')
        $ret = true;
    return $ret;
}

function is_access_zovio_modules() {

    // ZOVIO		
    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL002200#FKOL007078#FKOL005611#FCEB004639#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('185', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_howard_modules() {

    // howard		
    //$client_ids=get_client_ids();
    $ses_fusion_id = get_user_fusion_id();
    $process_ids = get_process_ids();

    $access_ids = " #FKOL007078#FKOL008610#FKOL007187#FKOL001929#FKOL001961#FHIG000301#FHIG000211#FKOL002200#FKOL005611#FSPI000105#FHIG000211#FHIG000302#FSPI000752#FHIG000301#FHIG000007#FHIG000210#FSPI000005#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if ($ret == false) {
        if ($process_ids == "")
            $ret = false;
        else {
            if (in_array('581', explode(',', $process_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_kyt_modules() {

    // KYT		
    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " ##";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_login_type() == 'client')
        $ret = true;
    if (get_global_access() == '1')
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            //if (in_array('201', explode(',',$client_ids)) == true) $ret=true;
        }
    }

    return $ret;
}

function is_access_qenglish_modules() {

    // queen english		
    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " ##";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_login_type() == 'client')
        $ret = true;
    if (get_global_access() == '1')
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('250', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }
}

function is_access_follett_modules() {

    // FOLLETT		
    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL002200#FKOL007078#FKOL005611#FCEB004639#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('184', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_alpha_gas_modules() {

    // FOLLETT		
    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " ##";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('104', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_crm_readonly_access_mindfaq() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB004639#FCEB004889#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_zovio_report() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL002200#FKOL007078#FKOL005611#FCEB004639#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_follett_report() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL002200#FKOL007078#FKOL005611#FCEB004639#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_covid_crm_readonly() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL002200#FKOL007078#FKOL005611#FCEB004639#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_jurys_inn_crm_report() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL001893#FCEB004639#FCEB004889#FALB000001#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('124', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_mpower_voc_report() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB000418#FCEB003939#FCEB000413#FCEB000018#FCEB004639#FCEB000005#FCEB004358#FKOL003087#FCEB000409#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_meesho_search_modules() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL007362#";

    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_client_voc() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB000005#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_duns_crm() {

    // FKOL001961 Manash	Kundu
    // FKOL007078 - daljeet

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL001961#FKOL007078#FKOL011922#";
    $ret = true;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    return $ret;
}

function is_access_apphelp_modules() {

    /*
      // Vishesh Jog - FMON004163

      FKOL003616 - Swagata
      Adrian Camp: FSPI000170
      Pradipta Some: FKOL007149

     */

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB004639#FMON004163#FKOL003616#FSPI000170#FKOL007149#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('7', explode(',', $client_ids)) == true)
                $ret = true;
            else if (in_array('12', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_affinity_modules() {

    /*
      FHIG000302

      FKOL003616 - Swagata
      Adrian Camp: FSPI000170
      Pradipta Some: FKOL007149

      •	FSPI000001 Darnetta Burton
      •	FSPI000086 ALYSSA MACOPSON
      •	FSPI000127 MIAYAH MACOPSON
      •	FSPI000105 SARAH WOLF
      •	FHIG000302 TERRI PETERMAN
      •	FKOL008598 Debanjan Guha

     */

    //$client_ids=get_client_ids();
    $process_ids = get_process_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB004639#FKOL003616#FSPI000170#FKOL007149#FSPI000001#FSPI000086#FSPI000127#FSPI000105#FHIG000302#FKOL008598#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($process_ids == "")
            $ret = false;
        else {
            if (in_array('266', explode(',', $process_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_mpower_modules() {

    /*
      #FCEB000005- Barbara.Alovera
     */

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();
    ###FCEB004639#FCEB004358#
    $access_ids = " #FCEB000005#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('39', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_jurys_inn_modules() {

    /*
      FALB000001-Klejda Hoxha
      FCEB000791 Fely Rose Lozada - STL
      FCEB003423 Syra Jane Basubas - TL Res
      FCEB000965 Satomi Dejanio - TL LAP - Res / S&H
      FCEB004238 Ester Ramirez - TL M&E
      FCEB004354 Raffy Tan - TL Res
      FCEB004355 Rexielito Nacua - TL Res

     */

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FALB000001#FCEB000791#FCEB000965#FCEB004238#FCEB004354#FCEB004355#FCEB003423#FCEB004639#FCEB004889#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('124', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_meesho_modules() {


    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FHWH005204#FHWH005243#FHWH002540#FHWH005281#FHWH005188#FHWH005187#FHWH005220#FHWH005215#FHWH005189#FKOL001985#FKOL006573#FKOL005828#FKOL005388#FKOL006426#FCHE000739#FKOL002880#FKOL008612#FKOL002519#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('105', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_kabbage_modules() {


    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB003365#FMAN000131#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('140', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_brightway_modules() {

    //FKOL003616 - Swagata
    // Summer Littlejohn	FSPI000020
    // FMAN001145

    $client_ids = get_client_ids();
    $process_ids = get_process_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FMON004078#FSPI000019#FSPI000004#FKOL003616#FSPI000020#FSPI000474#FCEB003880#FCEB004073#FCEB004072#FCEB000687#FCEB003967#FCEB003975#FCEB004064#FCEB004059#FCEB003999#FCEB004085#FCEB004081#FCEB003983#FMAN001145#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($process_ids == "")
            $ret = false;
        else {
            if (in_array('377', explode(',', $process_ids)) == true)
                $ret = true;
        }
    }


    return $ret;
}

function is_access_snapdeal_modules() {

    //FKOL003616 - Swagata

    $client_ids = get_client_ids();
    $process_ids = get_process_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL003616#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('223', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_cars24_modules() {


    $client_ids = get_client_ids();
    $process_ids = get_process_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "-#FCHA005320#FCHA005325#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('246', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_awareness_modules() {


    $client_ids = get_client_ids();
    $process_ids = get_process_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #xx#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('22', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_paynearby_modules() {


    $client_ids = get_client_ids();
    $process_ids = get_process_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #xx#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('115', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_cci_modules() {


    $client_ids = get_client_ids();
    $process_ids = get_process_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "*#FKOL011817#FHIG000302#FHIG000301#FHIG000103#FHIG000005#FHIG000047#FHIG000186#FHIG000013#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (is_access_global_mindfaq() == true)
        $ret = true;


    if ($ret == false) {
        if ($process_ids == "")
            $ret = false;
        else {
            if (in_array('264', explode(',', $process_ids)) == true)
                $ret = true;
            else if (in_array('263', explode(',', $process_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_phs_modules() {

    $client_ids = get_client_ids();
    $process_ids = get_process_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "##FCEB005078#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('196', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_clio_modules() {


    $client_ids = get_client_ids();
    $process_ids = get_process_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "#xx#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('221', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_att_modules() {


    $client_ids = get_client_ids();
    $process_ids = get_process_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "#xx#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (is_access_global_mindfaq() == true)
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('157', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function isAccessMindfaqApps() {

    $ret = false;

    if (is_access_global_mindfaq() == true)
        $ret = true;
    else if (get_global_access() == '1')
        $ret = true;
    else if (get_site_admin() == '1')
        $ret = true;
    else if (is_access_mpower_modules() == true)
        $ret = true;
    else if (is_access_jurys_inn_modules() == true)
        $ret = true;
    else if (is_access_affinity_modules() == true)
        $ret = true;
    else if (is_access_apphelp_modules() == true)
        $ret = true;
    else if (is_access_meesho_modules() == true)
        $ret = true;
    else if (is_access_kabbage_modules() == true)
        $ret = true;
    else if (is_access_brightway_modules() == true)
        $ret = true;
    else if (is_access_snapdeal_modules() == true)
        $ret = true;
    else if (is_access_cars24_modules() == true)
        $ret = true;
    else if (is_access_awareness_modules() == true)
        $ret = true;
    else if (is_access_paynearby_modules() == true)
        $ret = true;
    else if (is_access_cci_modules() == true)
        $ret = true;
    else if (is_access_phs_modules() == true)
        $ret = true;
    else if (is_access_clio_modules() == true)
        $ret = true;
    else if (is_access_att_modules() == true)
        $ret = true;

    return $ret;
}

function isAccessMindfaqReports() {

    $ret = false;

    if (is_access_global_mindfaq() == true)
        $ret = true;
    else if (get_global_access() == '1')
        $ret = true;
    else if (get_site_admin() == '1')
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_mpower_modules() == true) || (get_dept_folder() != "operations" && is_access_mpower_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_jurys_inn_modules() == true) || (get_dept_folder() != "operations" && is_access_jurys_inn_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_affinity_modules() == true) || (get_dept_folder() != "operations" && is_access_affinity_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_apphelp_modules() == true) || (get_dept_folder() != "operations" && is_access_apphelp_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_meesho_modules() == true) || (get_dept_folder() != "operations" && is_access_meesho_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_kabbage_modules() == true) || (get_dept_folder() != "operations" && is_access_kabbage_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_brightway_modules() == true) || (get_dept_folder() != "operations" && is_access_brightway_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_snapdeal_modules() == true) || (get_dept_folder() != "operations" && is_access_snapdeal_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_cars24_modules() == true) || (get_dept_folder() != "operations" && is_access_cars24_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_awareness_modules() == true) || (get_dept_folder() != "operations" && is_access_awareness_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_paynearby_modules() == true) || (get_dept_folder() != "operations" && is_access_paynearby_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_cci_modules() == true) || (get_dept_folder() != "operations" && is_access_cci_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_phs_modules() == true) || (get_dept_folder() != "operations" && is_access_phs_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_clio_modules() == true) || (get_dept_folder() != "operations" && is_access_clio_modules() == true))
        $ret = true;
    else if ((get_role_dir() != "agent" && is_access_att_modules() == true) || (get_dept_folder() != "operations" && is_access_att_modules() == true))
        $ret = true;


    return $ret;
}

function isAccessAvonReports() {

    // FKOL001961 Manash	Kundu
    // FKOL007078 - daljeet
    // FKOL002542
    // FKOL007301

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL001961#FKOL007078#FKOL002542#FKOL007301#FKOL007614#FKOL007196#FKOL003098#";
    $ret = true;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    return $ret;
}

function isAccessReports() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $access_ids = " #FKOL000007#FELS003427#FHIG000239#FMON004090#FMON004089#FCEB003423#FSPI000109#FSPI000110#FKOL001738#FCEB000791#FMAN001140#FCEB000011#FCEB004485#FCEB004009#FCEB000965#FCEB004354#FALB000026#FCEB004355#FCEB000791#FCEB003423#FCEB004238#FELS003419#FHWH002648#FHWH002648#FALB000001#FCEB004450#FKOL002619#FKOL006885#FKOL001804#FKOL002896#FKOL007975#FCAS000007#FKOL000006#FKOL005386#FSPI000004#FKOL007906#FKOL001854#FKOL002245#FKOL004812#FSPI000108#FHIG000301#FCHA000264#FCHA000262#FKOL008613#FKOL008629#FKOL009915#FCEB000482#FCEB000526#FCEB000502#FCEB005433#FELS004207#FKOL001900#FKOL011815#FKOL005826#FKOL006742#FCEB004073#FCEB003975#FKOL007860#FALB000079#FALB000085#FALB000167#FALB000188#FALB000189#FALB000101#FKOL003779#FKOL007158#FKOL001899#FCHA005112#FCAS000484#FKOL000162#FKOL007512#FKOL008409#FJAM005481#FJAM005224#FKOL008441#FJAM004099#FJAM004208#FKOL001934#FELS003773#FKOL007304#FJAM004092#FELS003595#FELS003034#FELS003295#FELS005281#FKOL007211#FALB000240#FALB000153#FALB000256#FKOL001269#FALB000082#FALB000111#FKOL003040#FCHE000633#FCAS000434#FCAS000458#FCAS000154#FHIG000005#FCAS000078#FCAS000076#FCAS000075#FCAS000158#FCAS000198#FCAS000157#FCAS000156#FCAS000196#FCAS000200#FCAS000027#FCAS000143#FCAS000152#FCAS000123#FCAS000077#FCAS000203#FELS001565#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (get_site_admin() == '1')
        $ret = true;

    if (get_dept_folder() == "hr" || get_dept_folder() == "mis" || get_dept_folder() == "wfm" || get_dept_folder() == "rta" || get_dept_folder() == "accounts" || get_dept_folder() == "qa" || get_dept_folder() == "Recruitment" || (get_dept_folder() == "operations" && get_role_dir() == "manager"))
        $ret = true;


    return $ret;
}

function is_access_downtime_tracker() {

    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $access_ids = " #FKOL001754#FKOL004711#FKOL000077#FKOL006793#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    return $ret;
}

function is_access_downtime_tracker_reports() {

    /*
      Terri Peterman - FHIG000302
      Tina Church - FHIG000013
      Brittany Ryder - FHIG000314
      Stephanie Rohr - FHIG000170
      Sarah Wolf - FSPI000105
      Lisa Snell - FHIG000142
      Bill Price - FSPI000022
      Jennifer Karas - FHIG000309
      Melissa Monsoon - FUTA000001
     */

    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $access_ids = " #FHIG000314#FHIG000170#FSPI000022#FHIG000309#FUTA000001#FELS004872#FELS004873#FELS004874#FELS004875#FELS004876#FHIG000001#FHIG000013#FHIG000006#FSPI000001#FSPI000003#FSPI000002#FSPI000105#FHIG000142#FHIG000303#FHIG000302#FHIG000160#FELS003398#FELS004299#FELS003519#FKOL001754#FKOL004711#FKOL000077#FHIG000295#FHIG000210#FMIN000049#FSPI000005#FSPI000006#FSPI000004#FHIG000189#FKOL006793#FSPI000019#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_tna_reports() {

    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $access_ids = " #FKOL006655#FCEB000013#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_t2_capabilities_reports() {

    /*
      FCEB000005 FMAN000594 FCEB000004
     */

    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $access_ids = " #FCEB000005#FMAN000594#FCEB000004#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_t2_capabilities() {

    /*

     */

    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $access_ids = " ";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1' || ( get_user_office_id() == "CEB" && $client_id == '30'))
        $ret = true;

    return $ret;
}

function is_access_oyo_disposition() {

    /*
      FKOL001961 Manash
     */


    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $process_id = get_process_ids();
    $access_ids = " #FKOL001961#FKOL000004#FKOL000001#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (($process_id == '171' || $process_id == '181') && $client_id == '90')
        $ret = true;

    return $ret;
}

function is_access_clinic_portal() {

    /*
      MANASH KUNDU- FKOL001961,
      HENRY PRESTO- FCEB003836,
      JOEMAR DELA PENA- FCEB000089
      //FMAN000456 - Anna Marie
     */
    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $access_ids = " #FKOL001961#FCEB003836#FCEB000089#FCEB004453#FMAN000456#";
    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else if (get_user_office_id() == "CEB")
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_clinic_portal_distro() {

    $ses_fusion_id = get_user_fusion_id();
    $client_id = get_client_ids();
    $access_ids = " #FCEB000093#FCEB003836#FCEB004994#FCEB004993#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    //if(get_global_access()=='1') $ret=true;

    return $ret;
}

function is_bypass_hr_aduit_sruvey() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FCEB000005#";
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    return $ret;
}

function is_access_facilities_survey_report() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    //FCEB000755 - Hector V Tan Jr
    $access_ids = " #FCEB000755#";
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    return $ret;
}

function is_access_ameridial_participant_survey_report() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    //FHIG000141 - Yvonne Hutchins
    $access_ids = " #FHIG000141#";
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    return $ret;
}

function is_access_survey_team_report() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " ##";
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    return $ret;
}

function isAccessAssetWFH() {

    //vivek - FKOL002504
    // prasenjit - FKOL001786
    /*
      FMAN000378	Charlie Barinque
      FMAN000367	Mishelle Ann Gevero

      FCEB000011	Jan Cyrell Puntual
      FCEB000299	Rodegelio Velayo
      FCEB000302	Jose Paulo Comendado

      Stephanie Rohr FHIG000170
      Sarah Wolf FSPI000105
      Bill Price FSPI000022
      Danielle Shepherd FMIN000029
      Tina Church FHIG000013
      Siddhartha	Jana FKOL001794
      // FKOL011477 - Farhaan Fatma John
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL002504#FKOL001786#FMAN000378#FMAN000367#FCEB000011#FCEB000299#FCEB000302#FHIG000170#FSPI000105#FSPI000022#FMIN000029#FHIG000013#FKOL001794#FSPI000019#FKOL005575#FKOL008262#FKOL008451#FKOL010158#FKOL011477#FHIG000314#FKOL008598#FHIG000302#FHIG000142#FFLO000002#FHIG000309#FALT002327#FHIG000142#FUTA000001#FSPI000105#FHIG000170#FHIG000013#FSPI000019#FKOL012213#FJAM004503#FKOL012897#FNOI000565#FDUR000125#FCHE000367#FKOL006366#FKOC000138#FMUM000048#FNOI000140#";
    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

//////////FNF /

function isAccessFNF() {
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL001771#FKOL012213#FMUM000051#FKOL005575#FJAM004503#FKOL012897#FDUR000125#FCHE000367#FKOL006366#FKOC000138#FMUM000048#FNOI000140#FJMP000071#";
    $ret = false;
    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function isAccessFNFHr() {
    /*
      FKOL000003 - Oindrila Banerjee
      FKOL003187 - Sudeepta	Moitra
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL000003#FKOL003187#FKOL010158#FKOL012897#FNOI000565#";

    $ret = false;

    if (get_global_access() == '1' || get_dept_folder() == "hr")
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function isAccessFNFITSecurity() {

    //FKOL001786 IT Security
    //FKOL004016 sagar

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL001786#FKOL004016#FNOI000140#FJMP000071#";

    $ret = false;

    if (get_global_access() == '1') $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
	
    return $ret;
}

function isAccessFNFITHelpdesk() {


    //FKOL002504 vivek
    //FKOL001803 debjeet
    //FKOL001780 Arindam
    //FKOL001782 Satyajit
    //FKOL002196 Debjyoti
    //FKOL005575 - ashfaque.iqbal
    //FKOL001774 - Santosh.singh
    // FKOL001790 - Kanchan
    // FKOL005557 Mrinal
    //FKOL002505 Sourav
    //FKOL001777 Ronik
    //FKOL002501 Mehraj
    //FKOL001779 Subhankar
    //FKOL007297 Abhishek Das
    //FKOL007405 Sanjay
    //FKOL007232 Biswarup Roy
    //FKOL007508 Pradeep Dammu
    //FKOL008233- Saikat Biswas

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL002504#FKOL001803#FKOL001780#FKOL001782#FKOL005575#FKOL001774#FKOL001790#FKOL005557#FKOL002505#FKOL001777#FKOL002501#FKOL001779#FKOL007297#FKOL007405#FKOL007232#FKOL007508#FKOL008233#FKOL006963#FCHE000112#FKOL001788#FKOL008638#FKOL008600#FKOL009320#FKOL008262#FKOL008451#FKOL008627#FKOL012213#FJAM004503#FDUR000125#FCHE000367#FKOL006366#FKOC000138#FMUM000048#FNOI000140#FJMP000071#FKOL011103#";

    $ret = false;

   if (get_global_access() == '1') $ret = true;
   else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
   
    return $ret;
}



	function isAccessFNFITNetwork(){
		

		//FKOL002504 vivek
		//FKOL001803 debjeet
		//FKOL001780 Arindam
		//FKOL001782 Satyajit
		//FKOL002196 Debjyoti
		//FKOL005575 - ashfaque.iqbal
		//FKOL001774 - Santosh.singh
		// FKOL001790 - Kanchan
		// FKOL005557 Mrinal
		//FKOL002505 Sourav
		//FKOL002501 Mehraj
		//FKOL001779 Subhankar
		//FKOL007297 Abhishek Das
		//FKOL007405 Sanjay
		//FKOL007232 Biswarup Roy
		//FKOL007508 Pradeep Dammu
		//FKOL008233- Saikat Biswas

		$ses_fusion_id=get_user_fusion_id();
		$access_ids=" #FKLY000097#FKOL008451#FKOL008451#FCHE010691#FMUM007504#FNOI000140#FKOL015908#FKOL013653#FKOL015402#FKOL015980#FKOL015908#FKOL002504#FKOL001803#FKOL001780#FKOL001782#FKOL005575#FKOL001774#FKOL001790#FKOL005557#FKOL002505#FKOL002501#FKOL001779#FKOL007297#FKOL007405#FKOL007232#FKOL007508#FKOL008233#FKOL006963#FCHE000112#FKOL001788#FKOL008638#FKOL008600#FKOL009320#FKOL008262#FKOL008451#FKOL008627#FKOL012213#FJAM004503#FDUR000125#FCHE000367#FKOL006366#FKOC000138#FMUM000048#FNOI000140#FJMP000071#FKOL010888#FKOL008638#FCHA003550#FCHA003562#FCHA002016#FKOL014024#FKOL014734#FKOL014689#FKOL015102#FKOL015113#FKOL015404#FHWH009981#FKOL008638#FKOL010888#FCHA003550#FCHA002016#FKOL008233#FKOL015716#FCHA002102#FKOL013738#FKOL015865#FKOL015979#FKOL017980#FKOL015178#FKOL015739#FKOL001919#FKOL001917#";
		
		$ret=false;
				
		//if(get_global_access()=='1') $ret=true;
		//else{
			if(strpos($access_ids,"#".$ses_fusion_id."#")== false) $ret=false;
			else $ret=true;
		//}
		return $ret;	
	}
	
	function isAccessFNFITGlobalHelpdesk(){
		

		//FKOL002504 vivek
		//FKOL001803 debjeet
		//FKOL001780 Arindam
		//FKOL001782 Satyajit
		//FKOL002196 Debjyoti
		//FKOL005575 - ashfaque.iqbal
		//FKOL001774 - Santosh.singh
		// FKOL001790 - Kanchan
		// FKOL005557 Mrinal
		//FKOL002505 Sourav
		//FKOL001777 Ronik
		//FKOL002501 Mehraj
		//FKOL001779 Subhankar
		//FKOL007297 Abhishek Das
		//FKOL007405 Sanjay
		//FKOL007232 Biswarup Roy
		//FKOL007508 Pradeep Dammu
		//FKOL008233- Saikat Biswas

		$ses_fusion_id=get_user_fusion_id();
		$access_ids=" #FKLY000097#FKOL008451#FKOL008451#FCHE010691#FMUM007504#FNOI000140#FKOL015908#FKOL013653#FKOL015402#FKOL015980#FKOL015908#FKOL002504#FKOL001803#FKOL001780#FKOL001782#FKOL005575#FKOL001774#FKOL001790#FKOL005557#FKOL002505#FKOL001777#FKOL002501#FKOL001779#FKOL007297#FKOL007405#FKOL007232#FKOL007508#FKOL008233#FKOL006963#FCHE000112#FKOL001788#FKOL008638#FKOL008600#FKOL009320#FKOL008262#FKOL008451#FKOL008627#FKOL012213#FJAM004503#FDUR000125#FCHE000367#FKOL006366#FKOC000138#FMUM000048#FNOI000140#FJMP000071#FKOL010888#FKOL008638#FCHA003550#FCHA003562#FCHA002016#FKOL014024#FKOL014734#FKOL014689#FKOL015102#FKOL015113#FKOL015404#FHWH009981#FKOL008638#FKOL010888#FCHA003550#FCHA002016#FKOL008233#FKOL015716#FCHA002102#FKOL013738#FKOL015865#FKOL015979#FKOL017980#FKOL015178#FKOL015739#FKOL001919#FKOL001917#";
		
		$ret=false;
				
		//if(get_global_access()=='1') $ret=true;
		//else{
			if(strpos($access_ids,"#".$ses_fusion_id."#")== false) $ret=false;
			else $ret=true;
		//}
		return $ret;
		
	}
	

function isAccessFNFprocurement() {


    //FKOL002504 vivek
    //FKOL001803 debjeet
    //FKOL001780 Arindam
    //FKOL001782 Satyajit
    //FKOL002196 Debjyoti
    //FKOL005575 - ashfaque.iqbal
    //FKOL001774 - Santosh.singh
    // FKOL001790 - Kanchan
    // FKOL005557 Mrinal
    //FKOL002505 Sourav
    //FKOL001777 Ronik
    //FKOL002501 Mehraj
    //FKOL001779 Subhankar
    //FKOL007297 Abhishek Das
    //FKOL007405 Sanjay
    //FKOL007232 Biswarup Roy
    //FKOL007508 Pradeep Dammu
    //FKOL008233- Saikat Biswas

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL002504#FKOL001803#FKOL001780#FKOL001782#FKOL005575#FKOL001774#FKOL001790#FKOL005557#FKOL002505#FKOL001777#FKOL002501#FKOL001779#FKOL007297#FKOL007405#FKOL007232#FKOL007508#FKOL008233#FKOL006963#FCHE000112#FKOL001788#FKOL008638#FKOL008600#FKOL009320#FKOL008262#FKOL008451#FKOL008627#FKOL012213#FJAM004503#FDUR000125#FCHE000367#FKOL006366#FKOC000138#FMUM000048#FNOI000140#FJMP000071#FKOL011103#FKOL001919#";

    $ret = false;

   if (get_global_access() == '1') $ret = true;
   else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
   
    return $ret;
}

function isAccessFNFPayroll() {

    /*
      FKOL001766 Payroll Rohit
      FKOL001709 Payroll manik
      FKOL004086 - Mangaldeep
      //FKOL006124 - (Debraj Banerjee
      // FCHA000264 – Parkash Joshi
      // FCHA000262 – Mangal Singh
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL001766#FKOL001709#FKOL004086#FKOL006124#FKOL007911#FKOL008639#FKOL008807#FCHA000264#FCHA000262#FKOL011173#FKOL007860#FKOL005386#FKOL007211#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#";

    $ret = false;

    //if (get_global_access() == '1') $ret = true;
   // else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
   // }
    return $ret;
}

function isAccessFNFAccounts() {

    /*
      FKOL001725 Asamanja
      FKOL005795 Prashant	Khandelwal
      FKOL001730 Niraj
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL001725#FKOL005795#FKOL001730#FKOL012213#FJAM004503#FNOI000140#";

    $ret = false;

    //if (get_global_access() == '1') $ret = true;
   // else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
   // }
    return $ret;
}

function isAccessFNFIT_Morocco() {
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FCAS000001#FCAS000175#FCAS000002#FCAS000003#FCAS000181#FCAS000180#FCAS000172#";
    $ret = false;
   
   //if (get_global_access() == '1') $ret = true;
   // else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
   // }
   
    return $ret;
}

function isAccessFNFHR_Morocco() {
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FCAS000171#FCAS000044#FCAS000174#";
    $ret = false;
    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

///////////////	
function isAccessGlobalEGaze() {

    //FKOL001786 IT Security
    // FKOL004016 sagar
    // FMON003209 Darwin
    //FKOL006066 - VS
    //subhajit, Rahul and Hitesh FKOL001985,FKOL005388,FKOL005828
    //Amit - FKOL006573

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL001786#FKOL004016#FMON003209#FKOL003779#FKOL006066#FKOL005388#FKOL005828#FKOL006573#FKOL001985#FKOL010536#FCEB000746#FCEB000308#FCEB000337#FCEB005123#FCEB004160#FCEB000269#FCEB005666#FCEB000751#FCEB000236#FCEB000582#FKOL013064#FKOL009043#FKOL007507#FKOL008653#FBLR000604#FKOL003644#FKOL002879#FMUM005792#FCHE001275#FNOI000476#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function isAccessEGazeReport() {

    //FCEB000748 

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "-#FCEB000748#FKOL006573#FKOL005828#FKOL013064#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function is_access_master_entry() {

    //FCEB000582 

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "-#FCEB000582#FKOL001916#FKOL001899#FMON002590#";

    $ret = false;

    if (get_global_access() == '1' || get_dept_folder() == 'transition')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function isDisablePayrollInfo($user_office_id = "") {

    $skipArray = array("ALT", "MON", "DRA", "FTK", "HIG", "MIN", "SPI", "TEX", "UTA", "CAM");
    if ($user_office_id == "")
        $user_office_id = get_user_office_id();

    return in_array($user_office_id, $skipArray);
}

function isDisableBankInfo($user_office_id = "") {

    $skipBankArray = array("ALT", "FTK", "HIG", "MIN", "SPI", "TEX", "UTA", "CAM");
    if ($user_office_id == "")
        $user_office_id = get_user_office_id();

    return in_array($user_office_id, $skipBankArray);
}

function isDisableFusionPolicy($user_office_id = "") {

    $skipArray = array("FTK", "HIG", "MIN", "SPI", "TEX", "UTA", "CAM", "SKC");
    if ($user_office_id == "")
        $user_office_id = get_user_office_id();
    return in_array($user_office_id, $skipArray);
}

function isDisablePersonalInfo($user_office_id = "") {

    $skipArray = array("FTK", "HIG", "MIN", "SPI", "TEX", "UTA", "CAM");
    if ($user_office_id == "")
        $user_office_id = get_user_office_id();
    return in_array($user_office_id, $skipArray);
}

function isIndiaLocation($user_office_id = "") {

    $skipArray = array("KOL", "HWH", "BLR", "CHE", "NOI", "MUM", "CHA", "KOC", "DUR", "JMP", "KLY");
    if ($user_office_id == "")
        $user_office_id = get_user_office_id();
    return in_array($user_office_id, $skipArray);
}

function isADLocation($user_office_id = "") {

    $skipArray = array("FTK", "HIG", "MIN", "SPI", "TEX", "UTA", "CAM");
    if ($user_office_id == "")
        $user_office_id = get_user_office_id();
    return in_array($user_office_id, $skipArray);
}

function isUSLocation($user_office_id = "") {

    $skipArray = array("ALT", "MON", "DRA", "FTK", "HIG", "MIN", "SPI", "TEX", "UTA", "CAM");
    if ($user_office_id == "")
        $user_office_id = get_user_office_id();
    return in_array($user_office_id, $skipArray);
}

function isPhilLocation($user_office_id = "") {

    $skipArray = array("CEB", "MAN");
    if ($user_office_id == "")
        $user_office_id = get_user_office_id();
    return in_array($user_office_id, $skipArray);
}

function is_access_neo_chatbot() {

    // Hitesh FKOL005828
    // Amit - FKOL006573
    ///Saikat - FKOL000007
    // subhadip
    //FKOL002245 - Purba
    //FKOL006795 - Subhadip

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL005828#FKOL006573#FKOL000007#FKOL002245#FKOL006795#FKOL011554#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (isIndiaLocation(get_user_office_id()) == true)
        $ret = true;

    return $ret;
}

function isUploadKnowledgeBase() {

    // Linda -FALT002335;
    // Shelita Kithcart -FALT002330; 
    // Mary Hare-FALT002329
    // FHIG000032 --
    // Glasspole Brown - FJAM004099
    // FELS001494 - Jonathan Rivas
    /*
      FKOL001763 - Neeraj Kumar
      FKOL004242 - Shuva Paul
      FKOL006266 - ASHOK  KU PATNAIK
      FKOL006539 - Jyoti Prakash Madhual
      FKOL002966 - Krishanu Roy Choudhury
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FALT002335#FALT002330#FALT002329#FHIG000032#FHIG000301#FJAM004099#FELS001494#FKOL001763#FKOL004242#FKOL006266#FKOL006539#FKOL002966#FELS003424#FELS003830#FCHA000004#FCHA000285#FFLO000053#FELS003561#FJAM005382#FJAM004103#FJAM005224#FKOL013736#";

    $ret = false;

    if (get_dept_folder() == "training" || get_global_access() == '1' || get_site_admin() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function is_access_ld_registration() {
    /*
      FKOL000001 - System Administrator
      FKOL004242 - Gargi Chattakhandi
      FCEB000013 - Ana Candelaria	Aviso
      FCEB004159 - Earl Marzon
      FKOL008502 - Srinjita Dey
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL000001#FKOL006655#FCEB000013#FCEB004159#FKOL008502#FELS001494#FCEB005596#";

    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    return $ret;
}

function isUpdatePolicy() {

    $ses_omuid_id = get_user_omuid();
    $ses_fusion_id = get_user_fusion_id();

    //FCEB000092	Mary Grace Muralla Amores
    //FALT002330 Shelita Kithcart, HR for atlanta
    // FHIG000185 - Margaret Schory
    //FCEB004452 - Tristan 

    $access_ids = " #FKOL000001#FKOL001929#FKOL001961#FCEB000017#FCEB000014#FCEB000748#FKOL001766#FMAN000456#FCEB000582#FCEB000337#FCEB000750#FCEB000308#FCEB000751#FJAM004503#FCEB000092#FALT002330#FHIG000185#FSPI000110#FCEB004452#";

    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;


    if ($ret == false) {
        if (get_global_access() == '1' || get_site_admin() == 1)
            $ret = true;
        else
            $ret = false;
    }

    return $ret;
}

function isProcessUpdates() {

    $ses_omuid_id = get_user_omuid();
    $ses_fusion_id = get_user_fusion_id();

    //Miss Shie Guevarra -> FMAN000343
    /*
      BRANDI CUNNINGHAM	FHIG000169
      JODI KELLISH	FHIG000301
      TERRI PETERMAN	FHIG000302
      ROBERT NEARY	FHIG000298
      LINDA MORGAN	FHIG000032
      MICHELL YOUNG	FHIG000015
      SCOTT BATTERSHELL	FHIG000038
      RICHARD LONGNECKER	FHIG000080
      JAMI PATRICK	FHIG000300
      CHRISTIAN YOUNG	FHIG000299
      KELLY LLOYD	FSPI000004
      TOPAZ ROBERTS-TOLLOTI	FHIG000303
      NANCY WARREN	FHIG000138
      Jason FCEB000764
      FKOL001763 - Neeraj Kumar
      FKOL004242 - Shuva Paul
      FKOL006266 - ASHOK  KU PATNAIK
      FKOL006539 - Jyoti Prakash Madhual
      FKOL002966 - Krishanu Roy Choudhury

      FCEB000730 - Jube Aries
      FCEB000383 - Jennifer
      FMON004086

      Leann Lesserreh Maluay : FCEB000386
      Arlene Salahuddin FCEB005369

      Akeiba Chambers	FJAM005382
      Christopher Ellis	FJAM005374

      FCEB005357	Mary Rose Sarino
      FCEB005130 	Durango. Ma Cristina
      FELS005241 	Palacios, Francisco Daniel Portillo
      FCEB004264	Gagote, Ivan
      Noela Saraña    FCEB000525
      Carl Biol       FCEB004485
      Meal Amboy      FCEB000701

     */

    $access_ids = " #FKOL000001#FKOL001929#FKOL001961#FCEB000016#FCEB000013#FCEB000014#FCEB000748#FKOL001984# FCEB000016#FMAN000343#FMAN000242#FMAN000410#FMAN000230#FMAN000769#FMAN000352#FMAN000334#FMAN000351#FMAN000382#FMAN000120#FMAN000342#FCEB000016#FKOL000023#FCEB000582#FCEB000337#FCEB000750#FCEB000308#FCEB000751#FKOL001751#FKOL000162#FKOL001930#FKOL002517#FKOL001716#FKOL002893#FELS003654#FCEB000009#FHIG000169#FHIG000301#FHIG000302#FHIG000298#FHIG000032#FHIG000015#FHIG000038#FHIG000080#FHIG000300#FHIG000299#FSPI000004#FHIG000303#FHIG000138#FCEB000764#FKOL001763#FKOL004242#FKOL006266#FKOL006539#FKOL002966#FSPI000109#FSPI000001#FSPI000110#FCEB003423#FCEB004238#FCEB000791#FCEB004173#FCEB004354#FCEB004355#FCEB000965#FCEB004009#FCEB000730#FCEB000383#FJAM004129#FJAM004099#FJAM002790#FJAM004092#FJAM005113#FJAM005044#FJAM004241#FMON004086#FBLR000155#FJAM005212#FJAM004099#FCEB004452#FJAM005160#FJAM005191#FCEB000386#FCEB005369#FCEB000525#FJAM005382#FJAM005374#FSPI000108#FKOL006184#FCEB005357#FCEB005130#FELS005241#FCEB004264#FCEB004485#FCEB000701#FKOL006359#FCEB005297#FCEB004672#FCEB000114#FCEB000579#FCEB000339#FCEB004296#FCEB000763#FCEB000334#FCEB000503#FCEB005172#FCEB005372#FCEB005251#FCEB004658#FCEB003698#FCEB000766#FCEB000584#FCEB003302#FCEB005191#FCEB000938#FCEB004128#FCEB004265#FCEB000760#FCEB000338#FCEB000355#FCEB000580#FCEB000197#";

    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;


    if ($ret == false) {

        if (get_global_access() == '1' || get_site_admin() == 1 || get_role_dir() == "manager" || get_role_dir() == "tl")
            $ret = true;
        else
            $ret = false;
    }
    return $ret;
}

/*
  // may be Not required
  function isAccessEditProfile(){

  //FBLR000327 - Mukesh (HR BLR)
  ////FMAN000342 Miss Jo

  $ses_omuid_id=get_user_omuid();
  $ses_fusion_id=get_user_fusion_id();

  $access_ids=" #FKOL000001#FJAM004241#FCEB000748#FJAM004503#FBLR000327#FMAN000342#";

  $ret=false;


  if(strpos($access_ids,"#".$ses_fusion_id."#")== false) $ret=false;
  else $ret=true;


  if($ret==false){

  if(get_global_access()=='1') $ret=true;
  else $ret=false;

  }
  return $ret;

  }
 */

function is_access_Personal_Info($pfid = "") {

    /*
      FKOL003187	Sudeepta Moitra
      FKOL000003	Oindrila Banerjee Das
      FKOL005837	Shivika
      FHWH002596	Sweta Dalui
      FCHE000227	Sharmila S
      FNOI000141	Anika Mahar
      FKOL007562	POOJA SHARMA
      FKOL007099 Somyodip

      // FKOL001854 - Dipan	Sarkar
      // FKOL002245 - Purba	Hazra
      // FKOL004812 - SUSWETA DAS
      // FKOL001900 - Prasanta
     */

    $ses_omuid_id = get_user_omuid();
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " ##FKOL003187#FKOL000003#FKOL005837#FHWH002596#FCHE000227#FNOI000141#FKOL007562#FKOL007099#FKOL003663#FKOL001854#FKOL002245#FKOL004812#FKOL010158#FKOL001900#";

    $ret = false;

    if (get_dept_folder() == "hr" || get_global_access() == '1' || get_site_admin() == '1')
        $ret = true;
    if (isIndiaLocation(get_user_office_id()) == true)
        $ret = false;

    if ($ret == false) {

        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_user_office_id() == "CHA" && get_dept_folder() == "hr")
        $ret = true;
    if (get_user_office_id() == "CAS" && get_dept_folder() == "hr")
        $ret = true;
    if ($ses_fusion_id == $pfid)
        $ret = true;

    return $ret;
}

function is_update_system_data() {

    //FMAN000230 	Reyes Josephine
    //FBLR000327 - Mukesh (HR BLR) 
    //FMAN000342 Miss Jo
    //Miss Shie Guevarra -> FMAN000343
    //FCEB000236 Ronald
    //
    //Sounak Bhattacharyya :  FKOL002702
    //Adrian Camp          :  FSPI000170
    // // FKOL005767 Saswata 
    //FHIG000301
    //FKOL002877 Tirthankar
    //FALB000001 - Klejda Hoxha
    //FCEB004160 - Madel 
    //FKOL007078 - Daljeet
    //FCEB004300 - WF Almira
    //FKOL001900 - Prasanta 
    //Brittany Bridges	FSPI000107
    // FKOL011172 - Niladri 
    //FKOL001929 Prasun
    //FCEB000582	Sheila Ann 
    // FCEB000337 - WFM Jason

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " ##FJAM002325#FCEB000748#FJAM004503#FMAN000230#FBLR000327#FMAN000342#FMAN000343#FCEB000236#FKOL002702#FSPI000170#FKOL005767#FHIG000301#FKOL002877#FALB000001#FCEB004160#FKOL007078#FCEB000492#FKOL007643#FCEB000268#FCEB004300#FHIG000170#FHIG000142#FHIG000013#FHIG000309#FSPI000019#FSPI000105#FUTA000001#FHIG000314#FHIG000302#FCEB000746#FCEB000308#FCHA000571#FCHA003182#FCHA002098#FKOL001900#FSPI000107#FKOL001901#FKOL011172#FKOL001929#FCEB000582#FCEB000337#";

    $ret = false;

    if (get_global_access() == '1' || get_site_admin() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    //if(get_user_office_id()=="CHA" && get_dept_folder()=="hr") $ret=true;
    //if(get_user_office_id()=="CAS" && get_dept_folder()=="hr") $ret=true;
    if (get_dept_folder() == "hr")
        $ret = true;

    return $ret;
}

function is_update_ad_office_location($user = "") {
    /*
      FHIG000142    LISA SNELL
      FHIG000302    Terri Peterman
      FKOL008598    Debanjan Guha
     */

    $ses_omuid_id = get_user_omuid();
    $ses_fusion_id = get_user_fusion_id();
    if (!empty($user)) {
        $ses_fusion_id = $user;
    }
    $access_ids = " ##FHIG000142#FHIG000302#FKOL008598#";
    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_update_office_location_limit($user = "") {
    /* 		
      FHIG000170    STEPHANIE ROHR
      FHIG000013    TINA CHURCH
      FHIG000309    JENNIFER JACKSON
      FSPI000019    NA TINA Dailey
      FSPI000105    SARAH WOLF
      FUTA000001    MELISSA MONSON
      FHIG000314    BRITTANY RYDER
      FKOL002702    Sounak **
      Access : Can Update office location for users of their office location only
      FKOL000003 - Oindrila Banerjee
      FKOL010158 - swapan kundu

     */

    $ses_omuid_id = get_user_omuid();
    $ses_fusion_id = get_user_fusion_id();
    if (!empty($user)) {
        $ses_fusion_id = $user;
    }
    $access_ids = " ##FHIG000170#FHIG000013#FHIG000309#FSPI000019#FSPI000105#FUTA000001#FHIG000314#FKOL002702#FKOL000003#FKOL010158#";
    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_update_profile($pfid) {

    //FMAN000342 Miss Jo
    //FBLR000327 - Mukesh (HR BLR) 
    //Miss Shie Guevarra -> FMAN000343
    //FCEB000236 Ronald
    // FKOL001854 - Dipan	Sarkar
    // FKOL002245 - Purba	Hazra
    // FKOL004812 - SUSWETA DAS
    // FKOL001900 - Prasanta 

    $ses_omuid_id = get_user_omuid();
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " ##FJAM002325#FCEB000748#FJAM004503#FMAN000342#FBLR000327#FMAN000343#FCEB000236#FCEB000492#FKOL001854#FKOL002245#FKOL004812#FKOL007562#FCEB000746#FKOL001901#FCHA000571#FCHA003182#FCHA002098#FKOL001900#";

    $ret = false;

    if (get_dept_folder() == "hr" || get_user_fusion_id() == $pfid || get_global_access() == '1' || get_site_admin() == '1')
        $ret = true;
    else {


        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (is_update_system_data() == true)
        $ret = true;


    return $ret;
}

function is_view_profile($pfid) {

    $ret = false;
    $ret = is_update_profile($pfid);

    //FCEB004160 - Madel 
    //FKOL001900 - Prasanta 

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " ##FCEB004160#FCEB000492#FCEB000268#FCEB000746#FCHA000571#FCHA003182#FCHA002098#FKOL001900#FKOL011173#";

    if ($ret == false) {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }


    if (get_role_dir() != "agent")
        $ret = true;
    if (get_dept_folder() == "training")
        $ret = true;

    if ($pfid == "")
        $ret = false;

    return $ret;
}

function is_access_cspl_my_team() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FCHA000571#FCHA003182#FCHA002098#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_view_social_security_info($pfid) {


    /*
      FKOL000003 - Oindrila Banerjee
      FKOL002960 - Dipti
      FKOL005837 shivika
      FKOL003187 - Sudeepta	Moitra
      //FKOL006124 - (Debraj Banerjee
      //Arpita Chakraborty (FKOL002206) & Somyodip Basak (FKOL007099).

      // FCHA000264 – Parkash Joshi
      // FCHA000262 – Mangal Singh

     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " ##FKOL000003#FKOL002960#FKOL005837#FKOL003187#FKOL006124#FKOL002206#FKOL007099#FKOL008639#FCHA000264#FCHA000262#FKOL010158#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    //if(get_user_office_id()=="CHA" && get_dept_folder()=="hr") $ret=true;
    //if($ses_fusion_id==$pfid ) $ret=true;

    return $ret;
}

function is_view_payroll_info($pfid) {

    /*
      FKOL001766 - Rohit	Sen
      FKOL004086 - Mangaldeep
      //FBLR000327 - Mukesh (HR BLR)
     */

    /*
      FKOL000003 - Oindrila Banerjee
      FKOL010158 - swapan kundu
      FKOL002960 - Dipti
      FKOL005837 shivika
      FKOL003187 - Sudeepta	Moitra
      //FKOL006124 - (Debraj Banerjee
      //Arpita Chakraborty (FKOL002206) & Somyodip Basak (FKOL007099).

      // FCHA000264 – Parkash Joshi
      // FCHA000262 – Mangal Singh
      // FKOL011172 - Niladri
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FKOL001766#FKOL004086#FBLR000327#FKOL000003#FKOL002960#FKOL005837#FKOL003187#FKOL006124#FKOL008639#FKOL002206#FKOL007099#FKOL007911#FKOL008643#FKOL008803#FKOL008803#FKOL008807#FKOL007562#FCHA000264#FCHA000262#FKOL010158#FKOL011173#FKOL011172#FKOL007860#FKOL005386#FKOL007211#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#FKOL012897#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (is_update_payroll_info() == true)
        $ret = true;

    //if($ses_fusion_id==$pfid ) $ret=true;
    return $ret;
}

function is_update_payroll_info() {


    /*
      FKOL000003 - Oindrila Banerjee
      FKOL002960 - Dipti
      FKOL005837 - shivika
      FKOL003187 - Sudeepta	Moitra
      // FKOL011172 - Niladri
      //FKOL001929 Prasun
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FKOL000003#FKOL002960#FKOL005837#FKOL003187#FKOL008643#FKOL008803#FKOL007562#FKOL010158#FKOL002328#FKOL010419#FKOL011477#FKOL011172#FKOL001929#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_download_payroll_report() {

    /*
      FKOL001766 - Rohit	Sen
      FKOL004086 - Mangaldeep
      //FBLR000327 - Mukesh (HR BLR)
      //FKOL006124 - (Debraj Banerjee
     */

    /*
      FKOL000003 - Oindrila Banerjee
      FKOL002960 - Dipti
      # FKOL005837 - shivika
      FKOL003187 - Sudeepta	Moitra
      //Arpita Chakraborty (FKOL002206) & Somyodip Basak (FKOL007099).

      // FCHA000264 – Parkash Joshi
      // FCHA000262 – Mangal Singh
      // FKOL011172 - Niladri
      //FKOL001929 Prasun
     */


    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FKOL000001#FKOL001766#FKOL004086#FBLR000327#FKOL000003#FKOL002960#FKOL005837#FKOL003187#FKOL006124#FKOL002206#FKOL007099#FKOL007911#FKOL008639#FKOL008643#FKOL008803#FKOL008803#FKOL008807#FCHA000264#FCHA000262#FKOL010158#FKOL011173#FKOL011172#FKOL001929#FKOL007860#FKOL006484#FKOL005386#FKOL007211#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    return $ret;
}

function is_access_operations_module() {

    if (get_dept_folder() == "operations" || get_global_access() == '1' || get_dept_folder() == "hr")
        return true;
    else
        return false;
    //return true;
}

function is_available_qa_feedback($entry_date, $hrs = 72) {
    return true;

    /* $diffmins=getCurrTimeDiffInMinute($entry_date);
      if($diffmins>=($hrs*60)) return false;
      else return true; */
}

function is_access_qa_agent_module() {
    if (get_dept_folder() == "operations" && get_role_dir() == 'agent')
        return true;
    else if (get_user_fusion_id() == 'FMON004368' || get_user_fusion_id() == 'FSPI000816') {
        return true;
    } else
        return false;
}

function is_access_qa_module() {

    if (get_login_type() == "client") {
        return is_access_client_qa_feedback();
    } else {

        $ses_fusion_id = get_user_fusion_id();
        $access_ids = "##FKOL004397#FKOL002533#FKOL005113#FBLR000269#FELS003053#FELS004299#FHIG000298#FUTA000007#FUTA000012#FMIN000011#FKOL002240#FKOL000158#FKOL003095#FKOL004642#FHIG000038#FALB000001#FSPI000038#FSPI000009#FSPI000005#FALT002329#FMON004090#FMON004089#FKOL002880#FALB000026#FKOL003814#FKOL002610#FKOL002155#FKOL004172#FCEB004009#FCEB000965#FCEB004354#FALB000026#FCEB004355#FCEB000791#FCEB003423#FCEB004238#FHWH000019#FHWH005103#FHWH005343#FKOL004826#FHWH002495#FHWH002573#FKOL004560#FKOL003923#FKOL005893#FKOL002530#FKOL006310#FKOL006349#FKOL006568#FKOL006028#FKOL005008#FKOL006427#FHWH005176#FBLR000006#FBLR000007#FBLR000008#FBLR000014#FCHE000074#FCHE000234#FCHE000228#FCHE000368#FBLR000213#FCHE000263#FKOL003384#FKOL005540#FHWH002603#FNOI000147#FNOI000274#FNOI000315#FNOI000313#FNOI000380#FNOI000381#FBLR000017#FCEB004394#FCEB003779#FHWH000010#FKOL004241#FKOL002528#FKOL002258#FKOL006660#FKOL002536#FKOL004106#FKOL004810#FKOL003939#FKOL003793#FKOL005027#FKOL004569#FKOL005934#FKOL006363#FKOL006211#FKOL002637#FKOl006513#FKOL002779#FKOL006658#FKOL004863#FKOL003665#FKOL003924#FNOI000021#FELS003419#FKOL006441#FKOL002060#FKOL004757#FHWH002605#FHWH005662#FHWH002561#FHWH002535#FHWH002527#FHWH002651#FKOL002745#FHIG000170#FHWH002524#FHWH002524#FKOL005356#FKOL003689#FKOL007148#FCEB000191#FCEB000203#FCAS000007#FCAS000074#FCEB000029#FKOL001862#FKOL002928#FKOL004262#FKOL002833#FJAM005160#FKOL006568#FKOL007264#FCAS000140#FCEB004173#FCHE000795#FELS003363#FELS002553#FCHE000798#FKOL007975#FKOL002635#FKOL006597#FKOL007365#FKOL007782#FNOI000320#FNOI000562#FELS005047#FHWH002590#FKOL007646#FCHE000810#FNOI000572#FCAS000027#FCAS000077#FHWH002648#FHWH005194#FKOL008237#FKOL007081#FHWH002549#FCHE000029#FCHE000851#FCEB004317#FNOI000447#FMIN000029#FKOL003098#FKOL007265#FKOL007112#FKOL001808#FCAS000190#FCAS000155#FCAS000156#FKOL004345#FKOL008503#FKOL006359#FCAS000158#FCAS000157#FCEB000730#FCEB000383#FCEB000388#FCEB000729#FCEB000386#FCEB000387#FCEB000311#FCEB000731#FCEB000742#FCEB000693#FCEB000727#FCEB000570#FCEB000739#FCEB000385#FCEB000707#FCEB000155#FCEB000081#FCEB000734#FCEB004404#FCEB000380#FCEB000068#FCEB000065#FKOL001271#FKOL005643#FKOL002328#FKOL008317#FHWH002521#FCEB004639#FSPI000001#FCAS000076#FCAS000075#FCAS000059#FKOL005386#FCEB000584#FCEB000701#FCEB000339#FKOL007907#FKOL008238#FHWH005979#FKOL003191#FKOL005957#FKOL007516#FKOL003572#FCEB000078#FCEB000029#FCEB004126#FCEB000142#FNOI000709#FCEB005044#FCEB005123#FCEB000739#FHWH002629#FHWH005066#FHWH005102#FCEB004454#FCHE000920#FCHE000923#FKOL008247#FHWH005197#FCEB003665#FCEB004118#FCEB000371#FCEB000289#FCEB000156#FCAS000078#FHWH005139#FKOL007906#FHWH002532#FHWH005256#FHWH006068#FHWH005513#FHWH005168#FHWH006067#FHWH005985#FCAS000154#FCHE000997#FMUM000049#FHWH002582#FCHE001034#FMAN000138#FMAN000405#FMAN000374#FSPI000020#FMON004096#FMAN000375#FMON004078#FCAS000158#FKOL005576#FSPI000108#FKOL001821#FKOL008646#FSPI000117#FHWH002610#FMON004037#FCHE001181#FCHE001068#FHWH002610#FCHE001321#FCHE001322#FKOL008983#FNOI000009#FNOI000833#FNOI000204#FKOL006054#FCHA000595#FCHA002242#FCHA002241#FCHA002264#FCHA002288#FCHA002644#FCHA002642#FCHA002643#FCHA002798#FCHA002799#FCHA002801#FCHA002800#FCHA002795#FCHA002794#FCHA00212FCAS0001230#FCHA002862#FCHE000701#FKOL008882#FCHE001438#FMUM005769#FMUM005741#FNOI000640#FKOL003123#FKOL005198#FHWH007026#FALB000079#FCHE001488#FKOL010080#FCEB003672#FKOL003802#FKOL003619#FKOL003416#FCHE001536#FKOL002605#FMUM005921#FCHE000293#FCHE000646#FCEB004073#FMUM005768#FMUM005776#FMUM005800#FMUM005815#FMUM005883#FMUM005920#FKOL010704#FCEB004420#FCEB005193#FCEB000192#FCEB005521#FHWH007850#FCEB005474#FCEB004922#FCEB004189#FKOL010745#FCHE001501#FCHE001594#FCHE000889#FHIG000211#FALB000144#FCEB005105#FCEB000484#FCEB003441#FALB000132#FMUM005963#FMUM005980#FCHA000721#FKOL010705#FKOC000058#FKOC000025#FKOC000023#FKOC000050#FHWH006485#FKOL009964#FKOL011047#FKOL010759#FKOL011680#FKOL009357#FHIG000183#FKOL010681#FKOL010760#FKOL011815#FKOL005826#FKOL011184#FKOL002619#FKOL006742#FHIG000189#FKOL007860#FALB000085#FKOL008880#FCEB004974#FCEB003947#FMAN000131#FMAN001069#FMON004394#FALB000144#FHIG000210#FMON004385#FCHA001660#FCHA001661#FCHA001390#FCHA005930#FCHA005929#FCHA001440#FCHA004790#FCHA001662#FCHA005401#FCHA005580#FCHA005208#FHIG000295#FMAN00336#FMAN001152#FMAN000386#FCAS000079#FCAS000123#FKOL000162#FKOL007512#FKOL008409#FJAM005481#FJAM005224#FJAM004099#FJAM004208#FKOL001934#FELS003773#FKOL007304#FJAM004092#FELS003595#FELS003295#FHWH002562#FHWH002521#FHWH007937#FHWH002506#FHWH002638#FSPI000097#FHWH002549#FKOL007211#FCHA002295#FCHA000721#FMUM005744#FCHA013424#FCHA004075#FCHA004078#FJAM004241#FKOL009043#FKOL007507#FKOL008653#FBLR000604#FKOL003644#FKOL002879#FMUM005792#FCHE001275#FNOI000476#FHWH002518#FALB000082#FALB000111#FHIG000155#FHIG000195#FKOL003040#FMUM006146#FBLR000155#FKOL011554#FKOL003040#FKOL012336#FKOL008636#FKOL012753#FCAS000176#FCEB004450#FKOL002240#FKOL004856#FMUM006197#FMUM006174#FKOL010739#FMUM000060#FKOL014088#FKOL014386#";

        $ret = false;
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;

        if (get_dept_folder() == "qa" || get_global_access() == '1')
            $ret = true;

        return $ret;
    }
}

///////////////// DebD (11/02/2021) //////////////////////
function is_access_qa_edit_feedback() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FKOL000023#FKOL005863#FELS003424#FHIG000301#FKOL003087#FCEB004358#FCEB000757#FCEB000764#FMAN000616#FCEB000525#FMAN000360#FCEB004836#FJAM004102#FJAM004208#FJAM004104#FJAM004103#FJAM003056#FKOL000162#FKOL001932#FKOL002896#FCAS000140#FCHE000795#FELS003363#FKOL006539#FCHE000798#FKOL007975#FKOL007975#FKOL007057#FKOL004242#FKOL008253#FCAS000007#FMAN001310#FCEB004402#FNOI000139#FNOI000412#FCEB003805#FKOL008612#FCEB005630#FCEB005767#FCEB005921#FCHA001660#FCHA001661#FCHA001390#FCHA005930#FCHA005929#FCHA001440#FCHA004790#FCHA001662#FCHA005401#FCHA005580#FCHA005208#FELS003561#FELS004874#FMAN000612#FKOL011817#FKOL010073#FMUM006114#FCEB006380#";
    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    return $ret;
}

////////////////////////////////////////////////////////

function is_access_qa_oyo_fd_entry() {

    /*
      Debasish Nag (FKOL002883)
      Biswajit Sen (FKOL003427)
      Jason D’Rozario (FKOL005347)
      Mushtaque Ahmed (FKOL005009)
      Vikash Kumar Gupta (FKOL004856)
      Abhishek Bhaumick (FKOL005614)
      Layaquat Ali (FKOL002879)
      Akash Kr. Shaw (FKOL002635)
      FKOL002777 - Mousumi
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FKOL002883#FKOL003427#FKOL005347#FKOL005009#FKOL004856#FKOL005614#FKOL002879#FKOL002635#FKOL002777#";
    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_qa_operations_module() {

    if (get_login_type() == "client") {
        return is_access_client_qa_review();
    } else {
        if (get_dept_folder() == "cs" || (get_dept_folder() == "operations" && get_role_dir() != 'agent'))
            return true;
        else
            return false;
    }
}

function is_access_coach_module() {

    /* if((get_dept_folder()== "operations" && get_role_dir() !='agent') || get_dept_folder()=="training"  || get_dept_folder()=="qa" || get_global_access()=='1' ) return true;
      else return false; */

    $ses_fusion_id = get_user_fusion_id();
    $access_coach_ids = "##FSPI000108#";
    $coach_ret = false;
    if (strpos($access_coach_ids, "#" . $ses_fusion_id . "#") == false)
        $coach_ret = false;
    else
        $coach_ret = true;

    if ((get_dept_folder() == "operations" && get_role_dir() != 'agent') || get_dept_folder() == "training" || get_dept_folder() == "qa" || get_global_access() == '1')
        $coach_ret = true;

    return $coach_ret;
}

//////////// Traner QUALITY Access (10/11/2020 - Deb) //////////////	
function is_quality_access_trainer() {
    /*
      Akash Shaw (FKOL002635)
      Rizwan Shams (FKOL003729)
      Sanjeev Kumar Singh (FKOL002157)
      Debayan Chakraborty (FKOL002536)
      Jacob John James (FKOL001271)
      Supriyo Dalapati (FHWH002527)
      Tanmoy Panigrahi (FHWH002648)
      Anupam Maity (FHWH002651)
      Vicky Raj (FKOL005826)
      Kunal Adhikary (FKOL003050)
      Sukanya Bhattacharya (FHWH000010)
      Sushma Sharma (FHWH002502)
      Surya k Nair (FCHE000368)
      Rahul Gupta (FKOL002619)
      Dibyalochan Pradhan (FKOL006742)
      Urbita Das Adhikary (FKOL006660)
      Shimul Das (FKOL005356)
      Minati Nag (FNOI000320)
      Ramesh Sharma (FKOL006785)
      Gurpreet Singh Malhotra (FKOL006426)
      Nirajita Dey(FKOL003689)
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FKOL002635#FKOL003729#FKOL002157#FKOL002536#FKOL001271#FHWH002527#FHWH002648#FHWH002651#FKOL005826#FKOL003050#FHWH000010#FHWH002502#FCHE000368#FKOL002619#FKOL006742#FKOL006660#FKOL005356#FNOI000320#FKOL006785#FKOL006426#FKOL002536#FKOL003689#FKOL002619#FCHE000798#FNOI000572#";
    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

//////////////////////////////

function is_access_login_dtl_entry() {

    /*
      Akeiba Chambers	FJAM005382
      Christopher Ellis	FJAM005374


     */

    $ses_omuid_id = get_user_omuid();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "##FJAM004241#FELS001178#FKOL001709#FELS000328#FELS000025#FELS000939#FELS000445#FALT001942#FJAM002219#FCEB000748#FCEB000582#FCEB000337#FCEB000750#FCEB000308#FCEB000751#FJAM005382#FJAM005374#FHIG000189#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_photo() {


    $ses_omuid_id = get_user_omuid();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "##FKOL001795#FKOL001735#FKOL002246#FELS003450#FELS003492#FELS003452#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "hr" || get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_bank_report() {


    $ses_fusion_id = get_user_fusion_id();
    //FKOL003187 - Sudeepta	Moitra
    //FKOL006124 - (Debraj Banerjee
    //Arpita Chakraborty (FKOL002206) & Somyodip Basak (FKOL007099).
    // FCHA000264 – Parkash Joshi
    // FCHA000262 – Mangal Singh
    /*
      FKOL006708	Shakil Ahmed
      FKOL007055	Shilpi Chowdhury
      FKOL006412	Siddhartha Pramanick
      FHWH006461	Neha Kumari
      FMUM005964	Reshma Bhandarkar
      FMUM005999	Laxmi Sagai
      FKOL011477	Farhaan Fatma John
      FHWH008383	Debojyoti Dutta
      // FKOL011172 - Niladri
      //FKOL001929 Prasun
     */

    $access_ids = "##FKOL000003#FKOL001766#FCEB000748#FKOL001732#FJAM004503#FKOL004086#FBLR000003#FKOL006124#FKOL003187#FKOL002206#FKOL007099#FKOL007911#FKOL005837#FKOL008639#FKOL008643#FKOL008803#FKOL008807#FCHA000264#FCHA000262#FKOL010158#FKOL011173#FKOL003663#FHWH002596#FCHE000227#FKOL006412#FKOL006700#FKOL006708#FKOL007055#FHWH006461#FMUM005964#FMUM005999#FKOL010535#FKOL010868#FKOL011477#FKOC000001#FHWH008383#FKOL011172#FKOL001929#FKOL007860#FKOL005386#FKOL007211#FKOL012897#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_mandatory_report() {


    $ses_fusion_id = get_user_fusion_id();
    //FKOL003187 - Sudeepta	Moitra
    //FKOL006124 - (Debraj Banerjee
    //Arpita Chakraborty (FKOL002206) & Somyodip Basak (FKOL007099).
    // FKOL006885 - deasish
    // FCHA000264 – Parkash Joshi
    // FCHA000262 – Mangal Singh
    // FKOL011172 - Niladri 


    $access_ids = "##FKOL000003#FKOL001766#FCEB000748#FKOL001732#FJAM004503#FKOL004086#FBLR000003#FKOL006124#FKOL003187#FKOL002206#FKOL007099#FKOL006885#FKOL007911#FKOL008639#FKOL008807#FCHA000264#FCHA000262#FKOL010158#FKOL011173#FKOL011172#FKOL007860#FKOL005386#FKOL007211#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_bank_edit() {
    /*
      FKOL001766 - Rohit	Sen
      FKOL004086 - Mangaldeep
      FBLR000003 - atifa	soudagar
      //FKOL003187 - Sudeepta	Moitra
      FKOL006124 - (Debraj Banerjee

      // FCHA000264 – Parkash Joshi
      // FCHA000262 – Mangal Singh

      FKOC000001	Jerin C Mathew
      FNOI000141	Anika Mahar

      FKOL006708	Shakil Ahmed
      FKOL007055	Shilpi Chowdhury
      FKOL006412	Siddhartha Pramanick
      FHWH006461	Neha Kumari
      FMUM005964	Reshma Bhandarkar
      FMUM005999	Laxmi Sagai
      FKOL011477	Farhaan Fatma John
      FHWH008383	Debojyoti Dutta
      // FKOL011172 - Niladri

     */

    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "##FKOL001766#FBLR000003#FKOL004086#FKOL003187#FKOL006124#FKOL007911#FCAS000044#FCAS000174#FCAS000171#FKOL008639#FKOL008803#FKOL008807#FCHA000264#FCHA000262#FKOL010158#FKOL010868#FCHE000227#FHWH002596#FMUM000779#FKOL011173#FNOI000141#FKOC000001#FKOL006708#FKOL007055#FKOL006412#FHWH006461#FMUM005964#FMUM005999#FKOL011477#FHWH008383#FKOL011172#FKOL001929#FKOL007860#FKOL005386#FKOL007211#FKOL012897#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#FKOC001630#FKOL011290#FKOL007805#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_master_database_report() {

    //FKOL002198 - Atanu	Das
    //FBLR000327 - Mukesh (HR BLR) 
    //FKOL002503 - Sanjukta Basu-HR.
    //FCEB000748 - Reina
    //FKOL003187 - Sudeepta	Moitra
    // FKOL005837 - shivika
    //FKOL002960 Dipti Singh	XPO8797
    //FHIG000302	TERRI PETERMAN
    //FHIG000160	MATTHEW MCGEORGE
    //FMAN000342 Miss Jo 
    //FCEB000085, FCEB000092
    // FALT002329
    // FKOL005767 saswata
    //FKOL006124 - (Debraj Banerjee
    //FKOL005386
    //FCEB000009
    // FCHA000264 – Parkash Joshi
    // FCHA000262 – Mangal Singh
    // FCHA002098 – Gautam Rana
    // FHIG000014 - JESSICA.MITCHELL
    // FKOL011172 - Niladri 

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "##FKOL002960#FKOL000003#FKOL001766#FJAM004503#FKOL004086#FKOL004370#FKOL001747#FKOL001709#FKOL002198#FKOL002499#FBLR000003#FBLR000327#FKOL002503#FKOL003187#FKOL005837#FHIG000302#FHIG000160#FMAN000342#FCEB000085#FCEB000092#FALT002329#FKOL005767#FKOL006124#FKOL008639#FKOL0005386#FCEB000009#FKOL001804#FKOL008142#FKOL007911#FKOL008807#FCHA000264#FCHA000262#FCHA002098#FKOL010158#FKOL011173#FHIG000014#FKOL011172#FKOL001899#FKOL007860#FKOL005386#FKOL007211#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "hr")
        $ret = true;

    return $ret;
}

//////////////////////////////////
/////// business analytics

function is_access_ba_design() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FCHA002317#FKOL011979#FKOL006223#FCHA001659#FCHA003515#FCHA003516#FCHA003505#FCHA000001#FCHA002098#FCHA000406#FKOL000003#FKOL001709#FKOL001716#FKOL002203#FKOL002878#FKOL007975#FCHA000001#FCHA000017#FKOL005386#FKOL007906#FKOL005227#FKOL004013#FKOL005037#FKOL008142#FKOL008609#FKOL007247#FKOL004013#FCHA001659#FKOL007211#";
    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function is_access_ba_mgntview() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FCAS000657#FCHA002317#FKOL011979#FKOL006223#FCHA001659#FCHA003515#FCHA003516#FCHA003505#FCHA002098#FCHA000406#FKOL007975#FCHA000001#FCHA000017#FKOL005386#FMAN000230#FKOL002702#FKOL005227#FKOL004013#FKOL005037#FKOL008142#FKOL008609#FKOL007247#FKOL004013#FCHA001659#FKOL007860#FKOL007211#";
    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "mis" || get_dept_folder() == "cs" || get_dept_folder() == "qa")
        $ret = true;

    return $ret;
}

function is_access_ba_upload() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FCHA003518#FCHA002317#FKOL011979#FKOL006223#FCHA001659#FCHA003515#FCHA003516#FCHA003505#FCHA002098#FCHA000406#FCHA000001#FCHA000017#FKOL005386#FKOL007906#FKOL005227#FKOL004013#FKOL005037#FKOL008142#FKOL008609#FKOL007247#FKOL004013#FCHA001659#FCHA001659#FCHA001657#FCHA003516#FCHA000017#FCHA000001#FCHA000864#FCHA001932#FCHA003515#FCHA000406#FCHA002671#FCHA002924#FCHA003517#FCHA005438#FCHA003505#FKOL007860#FCHA003498#FCHA003498#FCHA003515#FCHA003516#FCHA001932#FCHA000017#FCHA001657#FCHA000864#FCHA003499#FKOL007211#";
    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "mis")
        $ret = true;

    return $ret;
}

//////////////////////////////////////	

function is_access_pm_design() {

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "##FCHA003518#FCHA002317#FKOL011979#FKOL006223#FCHA001659#FCHA003515#FCHA003516#FCHA003505#FCHA000001#FCHA002098#FCHA000406#FKOL000003#FCEB000748#FKOL002203#FKOL002878#FKOL007975#FCHA000001#FCHA000017#FKOL005386#FKOL007906#FKOL005227#FKOL004013#FKOL005037#FKOL008142#FKOL008609#FCHA001659#FKOL007860#FKOL007211#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_vrs_bonus() {

    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " ##";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    if (get_dept_folder() == "mis")
        $ret = true;

    if (get_user_office_id() == "ALT" && (get_role_dir() == "admin" || get_role_dir() == "manager" || get_role_dir() == "trainer" || get_role_dir() == "tl"))
        $ret = true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('18', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }

    return $ret;
}

function is_access_pm() {

    $ses_fusion_id = get_user_fusion_id();
    ////Miss Shie Guevarra -> FMAN000343
    //Gloria Salazar		FCEB000288
    //FCEB004161 Albert Joseph

    $access_ids = "##FCHA002317#FKOL011979#FKOL006223#FCHA001659#FCHA003515#FCHA003516#FCHA003505#FCHA002098#FCHA000406#FKOL005386#FKOL000003#FKOL001766#FCEB000517#FCEB000068#FCEB000069#FCEB000375#FCEB000288#FCEB000286#FCEB000523#FCEB000016#FCEB000004#FCEB000499#FCEB000524#FCEB000487#FCEB000520#FCEB000650#FCEB000153#FCEB000015#FCEB000070#FCEB000192#FCEB000290#FCEB000018#FCEB000409#FCEB000007#FCEB000432#FCEB000291#FCEB000730#FCEB000729#FCEB000386#FCEB000383#FCEB000388#FCEB000008#FCEB000191#FCEB000193#FCEB000010#FCEB000289#FCEB000154#FCEB000155#FCEB000159#FCEB000113#FCEB000156#FCEB000791#FMAN000342#FMAN000769#FMAN000336#FMAN000343#FMAN000352#FMAN000334#FMAN000351#FMAN000353#FMAN000366#FMAN000120#FMAN000230#FMAN000036#FMAN000382#FCEB000748#FCEB000582#FCEB000337#FCEB000750#FCEB000308#FCEB000751#FMAN000341#FMAN000337#FCEB000203#FMAN000405#FMAN000373#FMAN000512#FKOL002878#FKOL002203#FKOL001761#FKOL001759#FKOL001973#FKOL005930#FKOL005931#FCEB004161#FKOL007975#FCHA000001#FCHA000017#FKOL007906#FMAN000230#FKOL002702#FKOL005227#FKOL004013#FKOL005037#FKOL008142#FKOL008609#FKOL007247#FKOL004013#FCHA001659#FKOL007860#FKOL007211#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function isAccessEmployeeFeedback() {

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "##FKOL000003#FKOL000004#FCEB000289#FKOL001801#FCEB000748#CEB000582#FCEB000337#FCEB000750#FCEB000308#FCEB000751#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function global_access_training_module() {
    ////FKOL007078 - Daljeet
    //FKOL004711 Dilip
    //FJAM005341 Everard Barnett
    //FJAM005342 Shemar Brooks

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FKOL000023#FKOL003087#FKOL007078#FKOL004711#FJAM005341#FJAM005342#FKOL004790#FKOL002877#FHIG000301#FJAM005224#FCAS000484#FCAS000445#FCEB000068#FCEB000069#FCEB000375#FCEB000061#FCEB000031#FCEB000524#FCEB000526#FCEB000018#FCEB000383#FCEB005424#FCEB004073#FCEB003975#FCEB000730#FCEB003516#FCEB000729#FCEB005521#FCEB000288#FCEB000289#FCEB005101#FMAN000762#FMAN000351#FMAN000375#FMAN000749#FMAN000366#FMAN000337#FMAN000355#FCHA005379#FCHA005426#FCHA005013#FCHA004306#FCHA004089#FCHA005208#FCHA005425#FCHA000410#FCHA005424#FCHA001646#FCHA005894#FCHA001642#FCHA005432#FCHA005429#FCHA012069#FCHA005431#FCHA005944#FCHA000590#FCHA000724#FCHA007167#FCHA005931#FCAS000152#FCEB000203#FCEB000734#FCEB000008#FCEB000191#FCEB000149#FCEB000193#FMAN001618#FMAN000386#FMAN000336#FMAN000345#FMAN000405#FCAS000079#FCHA003747#FCHA005720#FHIG000314#FKOL008598#FHIG000302#FJAM005382#FJAM004103#FHWH006275#FHIG000189#FCHA002295#FCHA000721#FCEB005336#FMAN000410#FCEB000078#FCEB003441#FCEB003947#FCEB000457#FCEB000029#FCEB000142#FMAN000138#FELS000025#FELS005471#FELS003514#FCEB000405#FKOL005826#FKOL009043#FKOL007507#FKOL008653#FBLR000604#FKOL003644#FKOL002879#FMUM005792#FCHE001275#FNOI000476#FCAS000187#FCAS000076#FCAS000075#FCAS000078#FCAS000077#FCAS000027#FCAS000198#FCAS000434#FCAS000196#FCAS000143#FCAS000200#FAC0000458#FCAS000154#FCAS000158#FKOL003040#FKOL004856#FBLR000155#FKOL012336#FKOL008636#FKOL012753#FCAS000176#FCEB004450#FKOL002240#FELS004882#FKOL013736#";
    $ret = false;
    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function global_super_access_training_module() {
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FCEB000013#FCEB000029#FHIG000301#";
    $ret = false;
    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function is_access_create_exam() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FCAS000484#FCAS000152#FCAS000445#FCAS000152#FCAS000079#FCAS000484#FCAS000445#";
    $ret = false;
    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function is_access_assessment_result_blocked() {
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FHWH005107#FHWH005290#FHWH005299#FHWH005500#FHWH005502#FHWH005503#FHWH005269#FHWH005265#FHWH005507#FHWH005670#FHWH005667#FHWH005666#FHWH005664#FHWH002574#FHWH002578#FHWH002576#FHWH002601#FHWH002595#FHWH002613#FHWH002632#FHWH002655#FHWH005048#FHWH005072#FHWH005069#FHWH002579#FHWH002653#FHWH002591#FHWH005674#FHWH005675#FHWH005676#FHWH005672#FHWH005673#FHWH005728#FHWH005729#FHWH005864#FHWH005862#FHWH005868#FHWH005913#FHWH005914#FHWH005940#FHWH005961#FHWH005960#FHWH005980#FHWH006141#FHWH005866#";
    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    return $ret;
}

//
////////////////////// updated on 28/08/2019 //////////////////////////////	
function is_access_trainer_module() {

    /*

      Rhea Lijarso		FCEB000061
      Jaden Berdos		FCEB000068
      Mary Gen Albarico	FCEB000065
      Noriel Britanico	FCEB000153
      Jonah Marie Rondina	FCEB000109
      Je Grace Bael		FCEB003235
      Jonathan Torreon	FCEB000094
      Jane Minoza			FCEB000270
      Janilee Dela Rama	FCEB000290
      Gloria Salazar		FCEB000288
      FCEB004161 Albert Joseph
      Marjorie Tecson		FCEB000777
      Jasen Tabarno		FCEB000375
      Maluay, Leann Lessereh	FCEB000386

      Senni Nolasco	   FELS004207
      Glasspole Brown	   FJAM004099
      Karene Hutchinson  FJAM004102
      Talia Shaw	       FJAM004208
      Molesha Virgo	   FJAM004103
      Susan Hastings	   FJAM004134
      Andrew 	           FJAM002790
      //  FCEB000079, FCEB000076, FCEB000078, FMAN000410, FJAM004945
      FELS000380 - Beatriz Cardova
      FELS001494 - Jonathan Rivas
      FELS000328 - Franklin Alvarez
      FELS000376 - Rolando Ortiz

      FJAM004203 - Jadusingh Diandra
      FJAM004132 - Obrain Wray
      FJAM004241 - Abbegale Valentine
      Roxana-FELS003424
      //FBLR000017 Arockia Samy
      //FCHA000590

      Akeiba Chambers	FJAM005382
      Christopher Ellis	FJAM005374

      FCEB005110 Ronlee Suquib

     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FCEB000061#FCEB000068#FCEB000065#FCEB000153#FCEB000109#FCEB003235#FCEB000094#FCEB000270#FCEB000290#FCEB000288#FCEB000777#FCEB000375#FCEB000386#FELS004207#FJAM004099#FJAM004102#FJAM004208#FJAM004103#FJAM004134#FJAM002790#FCEB004161#FCEB000079#FCEB000076#FCEB000078#FMAN000410#FJAM004945#FELS000380#FELS001494#FELS000328#FELS000376#FJAM004203#FJAM004132#FJAM004241#FELS003424#FBLR000017#FKOL007078#FKOL002328#FELS003830#FCHA000004#FCHA000018#FCHA000005#FJAM005044#FJAM005191#FJAM005098#FJAM004092#FCHA000590#FJAM005113#FJAM005224#FJAM005382#FJAM005374#FCEB005110#FCHA005755#FMON004089#FCHA000721#FMON004394#FCHA001643#FCHA001644#FCEB000751#FCEB000337#FCEB000308#FCEB000582#FCEB000746#FCEB000236#FCEB004160#FCEB000269#FCEB005666#FMAN000230#FCEB005123#FKOL004790#FKOL002877#FKOL004553#FHIG000301#FHIG000211#FHIG000299#FHIG000065#FHIG000733#FSPI000005#FSPI000006#FSPI000097#FCAS000484#FCAS000445#FCEB000069#FCEB000375#FCEB000031#FCEB000524#FCEB000526#FCEB000018#FCEB000383#FCEB005424#FCEB004073#FCEB003975#FCEB000730#FCEB003516#FCEB000729#FCEB005521#FCEB000288#FCEB000289#FCEB005101#FMAN000762#FMAN000351#FMAN000375#FMAN000749#FMAN000366#FMAN000337#FMAN000355#FCHA005379#FCHA005426#FCHA005013#FCHA004306#FCHA004089#FCHA005208#FCHA005425#FCHA000410#FCHA005424#FCHA001646#FCHA005894#FCHA001642#FCHA005432#FCHA005429#FCHA012069#FCHA005431#FCHA005944#FCHA000590#FCHA000724#FCHA007167#FCHA005931#FCAS000152#FCAS000079#FCHA003747#FCHA005720#FHIG000314#FKOL008598#FHIG000302#FJAM005382#FJAM004103#FHWH006275#FJAM005713#FJAM005715#FJAM005716#FJAM005720#FCHA002295#FCHA000721#FCHA005916#FCHA000902#FCEB000432#FCEB000405#FCEB000430#FCEB000106#FCEB005078#FCEB004126#FCEB000333#FCEB005430#FCEB004921#FCEB004173#FCEB005325#FMAN001360#FCEB005193#FCEB004217#FCEB000553#FMAN001145#FELS003514#FELS003053#FJAM005385#FJAM002219#FKOL003040#FKOL011817#";

    if (get_global_access() == '1' || get_site_admin() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "training")
        $ret = true;
    if (global_access_training_module() == true)
        $ret = true;

    return $ret;
}

function is_access_break_identifier() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FKOL008610#FKOL008587#FKOL011810#FKOL006214#FKOL008604#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_dept_folder() == "wfm" || get_dept_folder() == "transformation")
        $ret = true;

    return $ret;
}

function is_access_all_asset_location() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FKOL008598#FKOL012897#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function isAssignAsTrainer() {
    global $CI;
    $current_user = get_user_id();

    $qSql = "SELECT count(id) as value  FROM training_batch WHERE trainer_id = '$current_user' ";

    //echo $qSql;

    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

function check_consent($fusion_id, $warning_id) {

    global $CI;

    $qSql = "SELECT acceptance
				 FROM warning_letter_acceptance wla
				 WHERE wla.user_id = (SELECT s.id
									  FROM signin s
									  WHERE s.fusion_id = '$fusion_id')
				 AND wla.warning_id = '$warning_id'";

    $query = $CI->db->query($qSql);

    $res = $query->row_array();

    return $res["acceptance"];
}

function isAgentInTraining() {
    global $CI;
    $current_user = get_user_id();

    $qSql = "SELECT count(id) as value  FROM training_details WHERE user_id = '$current_user' ";

    //echo $qSql;

    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

function isAvilTrainingExam() {
    global $CI;
    $current_user = get_user_id();

    $qSql = "SELECT count(id) as value  FROM lt_exam_schedule WHERE user_id = '$current_user' and module_type='TR' and exam_status in (0,2,3)";

    //echo $qSql;

    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

//////
//IJP

function is_Spl_Access_IJP_Interview() {
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL004517#FCEB003573#FMAN000382#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_create_progression() {

    /*
      following are approved by prasun
      FCEB000018 Michelle Sausa
      FCEB000015 Rondec Adarlo
      FCEB000008 Sherryl Gay Demape
      FCEB000033 Ruth Jayme
      FCEB000004 Shahmin Christine Sencio
      FCEB000730 Jube Aries Luar
      FCEB000383 Jennifer Abellar
      FCEB000288 Gloria Salazar
      FCEB004161 Albert Joseph
      FCEB000005 Barbara
      FCEB004358 Maria
      // FKOL011172 - Niladri
     */

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB000018#FCEB000015#FCEB000008#FCEB000033#FCEB000004#FCEB000730#FCEB000383#FCEB000288#FCEB004161#FCEB000005#FCEB004358#FKOL003187#FKOL010158#FKOL011172#FKOL008881#FKOL006355#FKOL011103#FMAN000382#FJAM004503#FKOL001919#FCHA005231#";

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_progression_ijp_all_action() {
    /*
      FKOL003187 Sudeepta	Moitra
     */
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL003187#FKOL010158#FMAN000342#FMAN000382#FJAM004503#FKOL001919#FCHA005231#";
    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

/////////////	

function is_force_close_dfr_requisition() {
    /*
      FKOL001929 Prasun
      FKOL001961 Manash
      FKOL000005  RABI
      // FKOL011172 - Niladri
     */
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL001929#FKOL001961#FKOL000005#FKOL011172#";
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_dept_folder() == "wfm")
        $ret = true;

    return $ret;
}

function is_access_dfr_module() {
    // FKOL002246 - Reesav	Saha
    /*
      following are approved by prasun

      FCEB000018 Michelle Sausa
      FCEB000015 Rondec Adarlo
      FCEB000008 Sherryl Gay Demape
      FCEB000033 Ruth Jayme
      FCEB000004 Shahmin Christine Sencio
      FCEB000730 Jube Aries Luar
      FCEB000383 Jennifer Abellar
      FCEB000288 Gloria Salazar
      FCEB004161 Albert Joseph

      Faye Davis		FMIN000011
      Danielle Shepherd	FMIN000029
      Tina Dailey		FSPI000348
      Summer Littlejohn	FSPI000020
      William Price		FSPI000022
      Jessica As-Samad	FHIG000294
      Brittany Bridges	FSPI000107
      Jessica Mitchell	FHIG000014
      Lisa Snell		FHIG000142
      Stephanie Rohr		FHIG000170
      Melissa Monson		FUTA000001
      Jennifer Jackson	FHIG000309
      FCEB004477

      Shruti Kedia	FKOL002328
      Sanjeev Kumar Singh	FKOL002157
      Shimul Das	FKOL005356
      Kunal Adhikary	FKOL003050
      FCEB004450 - Jason  Kerr
      FCEB004639 - Eva Joy

      FELS003424
      FJAM004945
      FELS000376
      FELS005047
      FELS003830

      FELS003414 - Cecilia Carolina Vasquez Posada

     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL002246#FCEB000018#FCEB000015#FCEB000008#FCEB000033#FCEB000004#FCEB000730#FCEB000383#FCEB000288#FHIG000302#FMIN000011#FMIN000029#FSPI000348#FSPI000020#FSPI000022#FHIG000294#FSPI000107#FHIG000014#FHIG000142#FHIG000170#FUTA000001#FHIG000309#FCEB004477#FKOL002328#FKOL002157#FKOL005356#FKOL003050#FCEB004450#FCEB004639#FELS003424#FJAM004945#FELS000376#FELS005047#FELS003830#FCEB000011#FELS004299#FCHA000277#FCHA000265#FCHA000264#FCHA000262#FCHA000263#FCHA000281#FCHA000273#FCHA000280#FCHA000272#FCHA000271#FCHA000269#FCHA000267#FCHA000276#FCHA000275#FCHA000270#FCHA000278#FCHA000266#FCHA000268#FCHA000269#FMAN000338#FSPI000019#FELS003414#FKOL007158#FCAS000484#FKOL008602#FKOL008881#FKOL011103#FCAS000122#FCAS000193#FCAS000174#FCEB000090#FALB000144#FKOL004856#FKOL009043#FKOL007507#FKOL008653#FBLR000604#FKOL003644#FKOL002879#FMUM005792#FCHE001275#FNOI000476#FKOL008636#FKOL001919#FCEB003423#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "hr" || get_dept_folder() == "wfm" || get_site_admin() == '1' || get_role_dir() == "manager" || get_role_dir_original() == 'am' || isAssignInterview() > 0)
        $ret = true;

    return $ret;
}

function is_approve_requisition() {

    $ses_fusion_id = get_user_fusion_id();

    //Miss Shie Guevarra -> FMAN000343
    //FCEB000748 -Reina 
    // miss jo FMAN000342
    // FHIG000014 - JESSICA.MITCHELL
    // FKOL001961 Manash Kundu
    //$access_ids=" #FKOL000001#FKOL000005#FMAN000594#";
    //$access_ids=" #FKOL000005#FMAN000594#FCEB000748#FCEB000005#FMAN000342#FMAN000594#";

    $access_ids = "##FKOL000005#FMAN000342#FCHA002093#FCHA003450#FCEB000748#FHIG000014#FKOL001929#FKOL007158#FCAS000174#FKOL010321#FKOL001919#FKOL001961#";

    /*
      if( get_global_access()=='1' ) $ret=true;
      else{
      if(strpos($access_ids,"#".$ses_fusion_id."#") == false) $ret=false;
      else $ret=true;
      }
     */

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_dept_folder() == "wfm")
        $ret = true;

    return $ret;
}

function is_assign_trainer_dfr() {

    $ses_fusion_id = get_user_fusion_id();

    // FKOL004410 :: ISHANI
    // FKOL002880 :: Sandip
    //FELS003492 MARCELA ABIGAIL SURIO
    //FCEB000013 Ana Candelaria.Aviso
    //FCEB000748 Reina Margaret 
    // FKOL003644 PEYALEE bose
    // FKOL005837 - Shivika Dhanuka
    //	// FKOL003187 Sudeepta
    //FKOL006426
    /*
      Faye Davis		FMIN000011
      Danielle Shepherd	FMIN000029
      Tina Dailey		FSPI000348
      Summer Littlejohn	FSPI000020
      William Price		FSPI000022
      Jessica As-Samad	FHIG000294
      Brittany Bridges	FSPI000107
      Jessica Mitchell	FHIG000014
      Lisa Snell		FHIG000142
      Stephanie Rohr		FHIG000170
      Melissa Monson		FUTA000001
      Jennifer Jackson	FHIG000309

      Shruti Kedia	FKOL002328
      Sanjeev Kumar Singh	FKOL002157
      Shimul Das	FKOL005356
      Kunal Adhikary	FKOL003050


     */

    $access_ids = " #FKOL004410#FKOL002880#FKOL001961#FCEB000013#FCEB000748#FELS003492#FKOL003644#FKOL005837#FKOL003187#FKOL006426#FMIN000011#FMIN000029#FSPI000348#FSPI000020#FSPI000022#FHIG000294#FSPI000107#FHIG000014#FHIG000142#FHIG000170#FUTA000001#FHIG000309#FKOL002328#FKOL002157#FKOL005356#FKOL003050#FMAN000338#FSPI000019#FKOL010158#FKOL002536#FCEB000078#FKOL010419#FMAN000410#";

    /*
      if( get_global_access()=='1' ) $ret=true;
      else{
      if(strpos($access_ids,"#".$ses_fusion_id."#") == false) $ret=false;
      else $ret=true;
      }
     */

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_hr_permission_id_card() {

    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL005837#FKOL010158#FKOL012897#FKOL006412#FKOL007055#FKOL003663#FNOI000565#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_edit_sig_audit() {

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL000162#FKOL002517#FKOL002966#FKOL000023#FKOL001716#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_edit_oyoint_audit() {
    //FKOL002896 : Amit Kr Sarkar	
    //FKOL000023 Anshuman

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL002896#FKOL000023#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function isAssignInterview() {
    global $CI;
    $current_user = get_user_id();

    $qSql = "SELECT count(id) as value  FROM dfr_interview_schedules WHERE  assign_interviewer = '$current_user' and interview_type!=5";
    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

function isOpenFemsCertification() {
    global $CI;
    $current_user = get_user_id();

    $qSql = "SELECT count(id) as value  FROM train_open_fems_certification WHERE  user_id = '$current_user' ";
    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

function is_access_manage_client() {
    // FHIG000301 jodi
    // FCHA002018  - GAURAV SOOD
    // FCHA002017  - SHASHI PAL
    // FCHA001874  - AMAN KAKKAR 
    // FCHA002019  - AJAY KUMAR 
    // FCHA002016  - GIAN CHAND

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FHIG000301#FCHA002018#FCHA002017#FCHA001874#FCHA002019#FCHA002016#FKOL008266#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_add_user() {
    // FKOL001961 Manash	Kundu
    // FKOL003186 Debabrata	Mukherjee
    // FKOL001916 Rasmiranjan	Pattnaik
    // FALB000001 Klejda Hoxha
    // FKOL005767 Saswata 
    // Sounak Bhattacharyya :  FKOL002702
    // Adrian Camp          :  FSPI000170
    //JODI KELLISH	FHIG000301
    //Danielle Shepherd FMIN000029
    //Lisa Snell  FHIG000142
    //Stephanie Rohr  FHIG000170
    //Melissa Monson  FUTA000001
    //Jennifer Jackson  FHIG000309
    //Bill Price  FSPI000022
    //Tina Church  FHIG000013
    //Sarah Wolf  FSPI000105
    //FKOL007078 - Daljeet
    //FMON004019 - Santhiya Gnanamehan
    // FKOL005837 shivika
    // FKOL003187 - Sudeepta	Moitra
    // FKOL001854 - Dipan	Sarkar
    // FKOL002245 - Purba	Hazra
    // FKOL004812 - SUSWETA DAS
    //  FCHA000777 - Location Tester
    //  FALB000144  - Alvear
    // FCHA000278 - PRABHDEEP KAUR
    // FCHA000264 – Parkash Joshi
    // FKOL001900 - Prasanta
    // FCHA000327 - BALAM SINGH
    // FCHA000268 - SATISH KUMAR
    // FCHA000328 - AMIT KUMAR CHAUBEY
    // FCHA000272 - JASMEEN KAUR
    // FCHA003529 - HARPREET KAUR
    //FCHA000326 - LOKENDER KUMAR

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL000001#FKOL001961#FKOL003186#FKOL001916#FALB000001#FKOL005767#FKOL002702#FSPI000170#FHIG000301#FMIN000029#FHIG000142#FHIG000142#FHIG000170#FUTA000001#FHIG000309#FSPI000022#FHIG000013#FSPI000105#FKOL007078#FMON004019#FKOL005837#FKOL003187#FHIG000302#FKOL007643#FKOL002877#FSPI000019#FKOL001854#FKOL002245#FKOL004812#FCHA000777#FCHA000267#FKOL007158#FCHA000267#FKOL003616#FCHA002300#FCHA000262#FCHA000280#FKOL001901#FCHA000571#FCHA003182#FCHA002098#FKOL010158#FALB000144#FCHA000278#FCHA000264#FKOL001900#FCHA000327#FCHA000268#FCHA000328#FCHA000272#FCHA003529#FCHA000326#FKOL008610#FALB000189#";

    /*
      if( get_global_access()=='1' ) $ret=true;
      else{
      if(strpos($access_ids,"#".$ses_fusion_id."#") == false) $ret=false;
      else $ret=true;
      }
      if(get_dept_folder()=="hr" || get_global_access()=='1' ) $ret=true;
     */

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_term_module() {

    if (get_global_access() == '1' || get_role_dir() == "super" || get_dept_folder() == "hr" || get_dept_folder() == "wfm" || get_role_dir() == "admin" || get_role_dir() == "manager" || get_role_dir() == "tl" || get_role_dir() == "trainer" || is_access_cspl_my_team())
        return true;
    else
        return false;
    //return true;
}

function is_access_complete_kterm() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "#FHIG000013#FHIG000014#FHIG000302#FHIG000141#FHIG000142#FHIG000160#FHIG000170#FHIG000303#FHIG0002123#FHIG000309#FMIN000029#FSPI000022#FSPI000019#FSPI000105#FUTA000001#FSPI000019#FKOL002702#FKOL009357#FKOL001725#FNOI000386#";

    if (get_global_access() == '1')
        $ret = true;
    elseif (get_site_admin() == '1')
        $ret = true;
    elseif (get_role_dir() == "admin")
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "hr")
        $ret = true;

    return $ret;
}

function is_utils_access() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "-##FKOL000007#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_create_shout_box_msg() {
    $ret = false;

    //FCEB000748 Reina Margaret 

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL003186#FCEB000748#FJAM004144#FJAM004148#FJAM004503#FJAM004635#FJAM004203#FJAM004129#FJAM004134#FJAM004099#FJAM002222#FJAM002227#FJAM002219#FJAM004577#FJAM002214#FJAM004132#FJAM002790#FJAM002325#FJAM004139#FCEB000791#FJAM005160#";

    if (get_global_access() == '1' || get_dept_folder() == "hr")
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_l1_map() {
    /*

      Poulami Mondal FKOL002156
      Sanjeev Singh FKOL002157
      Vikas Shinde : FKOL002494
      Anand Dinesh (FKOL002523)
      Dennis Kumar (FBLR000005)
      Imran Ali FKOL005348
      sudeepta FKOL003187
      Miss Jo FMAN000342
      FBLR000213 Bala subramani.C
      FHWH002650	Soumitra.Chakraborty
      FHWH002649 , Bhanu Prakash
      FCEB000582	Sheila
      FCEB000748 Reina Margaret
      //FMAN000230 	Reyes Josephine
      //FJAM004503
      //FKOL002497 - omar
      //FBLR000017 Arockia Samy
      //FKOL005837 - shivika
      //Miss Shie Guevarra -> FMAN000343
      //FCEB000236
      //FKOL003616
      // FKOL005767 Saswata
      //Sounak Bhattacharyya :  FKOL002702
      // FMAN000131 Marenne Bamba
      // FCEBB003880 Desiree Arnado
      //FALB000001 - Klejda Hoxha
      // FCHE000227
      //FKOL006426
      FCHE000263 - Harish K S

      // FKOL001854 - Dipan	Sarkar
      // FKOL002245 - Purba	Hazra
      // FKOL004812 - SUSWETA DAS
      //FCHA000777 - Location Tester
      FKOL001900  Prasanta
      Romaine Green - FJAM005224
      Shaniel Johnson - FJAM005191
      Everard Barnett - FJAM005341

      ||  get_role_dir()=="manager"
     */

    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "-##FKOL000007#FKOL001961#FKOL002880#FKOL004517#FKOL004553#FKOL003012#FKOL004368#FKOL001269#FKOL003644#FKOL004480#FKOL003087#FKOL004410#FKOL002156#FKOL002157#FKOL001916#FKOL002879#FKOL002494#FKOL002523#FBLR000005#FKOL001365#FKOL002494#FKOL005348#FKOL005015#FKOL003187#FMAN000342#FBLR000213#FHWH002650#FHWH002649#FCEB000582#FCEB000748#FMAN000230#FJAM004129#FJAM004503#FKOL002497#FBLR000017#FMAN000343#FCEB000236#FKOL003616#FKOL005767#FKOL002702#FMAN000131#FCEBB003880#FALB000001#FCHE000227#FKOL006426#FCHE000263#FMON004086#FCHE000739#FKOL002877#FKOL000023#FCHA000005#FCHA000018#FHWH002605#FHWH002561#FJAM004099#FMAN000131#FCEB003880#FKOL008803#FKOL001854#FKOL002245#FKOL004812#FCHA000777#FKOL004828#FCHA000571#FCHA003182#FCHA002098#FKOL010158#FKOL001900#FJAM005224#FJAM005191#FJAM005341#FCEB000078#";

    if (get_global_access() == '1' || get_dept_folder() == "hr" || get_role_dir() == "manager" || get_role_dir() == "am")
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_itdeclaration_dump() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "-##FKOL000007#FKOL001730#";

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    return $ret;
}

function is_block_add_candidate_requisition($req_id) {
    $ret = false;
    $block_ids = "-##KOL2019130#KOL2019131#KOL2019143#KOL2019147#";
    if (strpos($block_ids, "#" . $req_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_leave_manage() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    //FKOL004086 - Mangaldeep
    //FKOL006124 - (Debraj Banerjee
    // FCHA000264 – Parkash Joshi
    // FCHA000262 – Mangal Singh
    // FKOL011172 - Niladri 
    $access_ids = "-##FKOL000003#FKOL000004#FKOL001709#FKOL001766#FKOL004086#FKOL006124#FKOL008639#FKOL007911#FKOL008807#FCHA000264#FCHA000262#FKOL010158#FKOL011173#FKOL011172#FKOL001929#FJAM005341#FJAM005224#FJAM005191#FJAM004099#FJAM004503#FKOL007860#FKOL008610#FKOL005386#FKOL007211#FKOL012897#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_leave_report() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    ////FKOL002198 -atanu
    // FKOL001961 - manash
    //FKOL002523 ansnd Dinesh 
    //FKOL004086 mangal
    //FKOL006124 - (Debraj Banerjee 
    //FKOL005386
    // FCHA000264 – Parkash Joshi
    // FCHA000262 – Mangal Singh
    // FKOL011477 - Farhaan Fatma John

    $access_ids = "-##FCEB000093#FCEB005436#FCEB005426#FKOL001738#FKOL001804#FKOL000001#FKOL000003#FKOL000004#FKOL002198#FKOL004086#FKOL001709#FKOL001766#FJAM004129#FCEB000001#FJAM004503#FKOL001732#FKOL001724#FKOL001747#FBLR000327#FKOL001961#FKOL002523#FKOL006124#FKOL005386#FKOL008142#FCEB004452#FCEB003574#FCEB003628#FCEB000085#FCEB003587#FCEB000744#FCEB000086#FCEB005126#FKOL008639#FKOL007906#FKOL007911#FKOL008807#FCHA000264#FCHA000262#FKOL010158#FKOL011173#FKOL007860#FKOL011477#FJAM005341#FJAM005224#FJAM005191#FJAM004099#FJAM004503#FKOL007211#FKOL012897#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_all_leave_approve() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    // FKOL004086 -mangal
    //FKOL005386
    //FKOL006124 - (Debraj Banerjee 
    // FCHA000264 – Parkash Joshi
    // FCHA000262 – Mangal Singh
    // FKOL011477 - Farhaan Fatma John

    $access_ids = "-##FKOL000003#FKOL000004#FKOL001766#FKOL001709#FKOL002198#FKOL004086#FKOL005386#FKOL006124#FKOL008639#FKOL007906#FKOL007911#FKOL008807#FCHA000264#FCHA000262#FKOL010158#FKOL011173#FKOL011477#FKOL002504#FKOL007860#FJAM005341#FJAM005224#FJAM005191#FJAM004099#FJAM004503#FKOL007211#FKOL008610#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function specific_location_leave_approve() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    //FKOL004086 - mangal
    //FKOL006124 - (Debraj Banerjee 
    $access_ids = "-##FKOL004086#FKOL006124#FKOL008639#FKOL007911#FKOL008807#FKOL011173#FKOL007860#FKOL005386#FKOL007211#FCHA000264#FCHA000326#FCHA000279#FCHA000280#FCHA000262#FCHA000327#FCHA003519#FCHA000278#FCHA000283#FJAM005935#FJAM006076#FJAM005877#";
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_all_dept_access() {
    //FMAN000342 - Miss Jo 
    //Miss Shie Guevarra -> FMAN000343
    //FCEB000236 Ronald 
    // FBLR000017 S Arockia
    // FKOL001766 - rohit
    // FCEB004450 - Jason  Kerr
    // as per kunal request we remove following user from list.
    // FKOL001919 - Bablu
    //FKOL001746- RUPAM
    //FKOL002203 subham
    //FKOL004016 Sagar Chandra
    //FKOL001742 Arunaditya
    //FKOL001738 Sk Rajul
    //FKOL001739 Suvankar 
    // FKOL001747 Subrata
    // FKOL002878 - santu
    // FKOL004835 - BODHISATTWA
    // KELLY LLOYD	FSPI000004 
    // FCEB000482 Anselmo Baron 
    // FCEB000526 - Rex Zamora
    // FCEB000502 - Jeremy Mah
    // FCEB005433 - Kwinnie Dawn Caballero

    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "-##FMAN000343#FCEB000852#FKOL000007#FMAN000342#FKOL001766#FCEB000236#FBLR000017#FCEB000009#FCEB004450#FCAS000204#FKOL005767#FKOL005767#FSPI000004#FCEB000482#FCEB000526#FCEB000502#FCEB005433#FKOL003779#FCHA005112#FHIG000301#FHIG000014#FCHE000633#";
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    if (get_dept_folder() == "rta")
        $ret = true;

    return $ret;
}

function is_access_emat_crm() {

    /*
      FCEB004300	Almira C. Ceniza	Allow
      FALB000026	Aleksa Bardhi	Allow
      FCEB003423	Syra Jane Basubas	Allow

      FKOL005767	Saswata Chakraborty
      FKOL001961	Manash Kundu
      FKOL001929	Prasun Das
      FKOL000005	Rabi Dhar
     */

    /*
      RTA
      Ronald Agustino – FCEB000236
      Jason Deguinon – FECB000337
      Reina Margaret Borces – FCEB000748
      Sharon Lal - FKOL002851
      Nandita Chakraborty - FKOL006255
      Amarjit SIngh - FKOL001893
      Rupam Mondol - FKOL006136
      Almira C.	Ceniza - FCEB004300
     */

    // AGENTS
    $onlyAgentAccess = " AND s.fusion_id IN ('FCEB000219','FALB000059','FALB000085','FALB000092','FALB000060','FCEB004128','FCEB004189','FCEB004207','FCEB003806','FCEB003781','FCEB004277','FCEB003706','FALB000079','FCEB000386','FCEB000731','FCEB004029','FALB000064','FALB000097','FALB000091','FALB000095','FCEB004265','FCEB004280','FCEB000486','FCEB004746','FCEB000549','FCEB004747','FCEB004739','FCEB000980','FCEB000722','FCEB000340','FALB000103','FALB000104','FALB000110','FALB000111','FALB000112','FCEB004281','FCEB004267','FCEB005474','FCEB003444','FCEB000560','FCEB003488','FCEB005369','FCEB000949','FKOL005150','FCEB004263','FCEB000486','FCEB004263','FKOL004855','FALB000064','FALB000128','FCEB000549','FCEB005059','FCEB000556','FCEB000639','FCEB005417','FCEB005802','FCEB000129','FCEB004263','FCEB004295','FCEB000555','FALB000117','FALB000127','FALB000081','FALB000163','FALB000147','FALB000162','FALB000125','FALB000164','FALB000118','FALB000129','FALB000067','FALB000145','FALB000146','FCEB005998','FCEB005999','FCEB006001','FCEB006046','FCEB006002','FCEB005805','FCEB005995','FCEB006006','FCEB000636','FCEB005809','FCEB000713','FCEB006004','FCEB006003','FCEB005803','FCEB005421','FCEB005412','FCEB005808','FCEB005952','FCEB000634','FCEB003392','FCEB005950','FCEB003307','FCEB005800','FCEB005951','FCEB005801','FKOL012753','FCEB000385','FCEB004922','FCEB000593','FKOL003773','FKOL007187','FCEB005191','FCEB004128','FCEB000766','FCEB000584','FCEB004265','FCEB003302')";

    global $CI;
    $user_id = get_user_id();
    $ses_fusion_id = get_user_fusion_id();
    $acccess = false;
    $qSQL = "SELECT count(e.id) as value FROM emat_agents as e LEFT JOIN signin as s ON s.id = e.agent_id where e.agent_id = '$user_id' AND e.is_active = '1' $onlyAgentAccess";
    $query = $CI->db->query($qSQL);
    $res = $query->row_array();

    $access_ids = "-##FKOL005767#FKOL001961#FKOL001929#FKOL000005#FCEB004300#FALB000026#FCEB003423#FCEB000386#FCEB000236#FCEB000337#FCEB000748#FKOL002851#FKOL006255#FKOL001893#FKOL006136#FCEB004300#FKOL001898#FCEB000949#FKOL005150#FCEB004263#FCEB000486#FCEB004263#FKOL004855#FALB000085#FALB000064#FKOL011775#FALB000128#FCEB000549#FCEB000129#FCEB000555#FALB000117#FALB000127#FALB000081#FALB000163#FALB000147#FALB000162#FALB000125#FALB000164#FALB000118#FALB000129#FALB000067#FALB000145#FALB000146#FCEB005998#FCEB005999#FCEB006001#FCEB006046#FCEB006002#FCEB005805#FCEB005995#FCEB006006#FCEB000636#FCEB005809#FCEB000713#FCEB006004#FCEB006003#FCEB005803#FCEB005421#FCEB005412#FCEB005808#FCEB005952#FCEB000634#FCEB003392#FCEB005950#FCEB003307#FCEB005800#FCEB005951#FCEB005801#FKOL012753#FCEB000385#FCEB004922#FCEB000593#FKOL003773#FKOL007187#FCEB005191#FCEB004128#FCEB000766#FCEB000584#FCEB004265#FCEB003302#";
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $acccess = false;
    else
        $acccess = true;
    if ($res["value"] > 0) {
        $acccess = true;
    }
    return $acccess;
}

// goutam added on 27/07/2022 for legal access
function is_access_legal_crm() {
    global $CI;
    $user_id = get_user_id();
    $ses_fusion_id = get_user_fusion_id();
    $sql = "CALL fusion_id_exist_for_legal_crm_access_proc('$ses_fusion_id')";
    $query = $CI->db->query($sql);
    $query->next_result();
    $res = $query->row_array();
    $data = $res['status'];
    return $data;
}

// goutam end here the code for legal crm access
// goutam added on 02/08/2022 for AIFI access
function is_access_aifi_crm() {
    global $CI;
    $user_id = get_user_id();
    $ses_fusion_id = get_user_fusion_id();
    $qsql = "CALL fusion_id_exist_for_aifi_crm_access_proc('$ses_fusion_id')";
    $query = $CI->db->query($qsql);
    //$res = $query->result();
    //echo'<pre>=====>';print_r($query);
    $query->next_result();
    $res = $query->row_array();
    //echo'<pre>=====>';print_r($res);
    $data = $res['status'];
    return $data;
}

// goutam end here the code for AIFI crm access

function is_access_ma_platform() {
    /*
      FALT000001 Kishore Saraogi
      FDRA000001 Pankaj Dhanuka
      FKOL005795 Prashant Khandelwal
      FALT002231 Neha Kallani
      FKOL007059 Suman Samanta
      FKOL008614 Amarnath Agarwal
      FKOL001929 Prasun Das

      FKOL001961 Manash Kundu
      FKOL005767 Saswata Chakraborty
      FKOL003186 Debabrata Mukherjee
     */
    $user_id = get_user_id();
    $ses_fusion_id = get_user_fusion_id();
    $acccess = false;
    $access_ids = " #FKOL001929#FKOL005767#FKOL001961#FKOL003186#FALT000001#FDRA000001#FKOL005795#FALT002231#FKOL007059#FKOL008614#FKOL005854#";
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $acccess = false;
    else
        $acccess = true;
    return $acccess;
}

function isAvilDipCheck() {
    global $CI;
    $current_user = get_user_id();

    $qSql = "SELECT count(id) as value  FROM lt_exam_schedule WHERE user_id = '$current_user' and module_type='QA' and exam_status in (0,2,3)";

    //echo $qSql;

    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

//////////////////

function is_access_schedule_update() {
    /*
      FCEB000159	Eileen.Martin-additional
      FCEB000018 	Michelle Sausa
      FCEB000015 	Rondec Adarlo
      FCEB000010 	Edlyn Dandoy
      FCEB000008	Sherryl Gay Demape
      FCEB000033	Ruth Jayme
      FCEB000004	Shahmin Christine Sencio
      FCEB000730	Jube Aries Luar
      FCEB000383	Jennifer Abellar
      FCEB000288 	Gloria Salazar
      FCEB000437->Frederick Dave Caparida
      FCEB004161 Albert Joseph
      FKOL002533
      FCEB000764

      // FKOL001854 - Dipan	Sarkar
      // FKOL002245 - Purba	Hazra
      // FKOL004812 - SUSWETA DAS
      //FCHA000777 - Location Tester
      FKOL001900  Prasanta

     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL000001#FKOL000005#FKOL000007#FCEB000748#FCEB000582#FCEB000337#FCEB000750#FCEB000308#FCEB000751#FKOL001751#FCEB000016#FKOL001916#FMAN000230#FMAN000343#FKOL002569#FKOL002216#FCEB000746#FMAN000392#FCEB000159#FCEB000018#FCEB000015#FCEB000010#FCEB000008#FCEB000033#FCEB000004#FCEB000730#FCEB000383#FCEB000288#FCEB000437#FCEB004161#FKOL002533#FCEB000764#FCEB005015#FCEB000734#FKOL001854#FKOL002245#FKOL004812#FCHA000777#FCEB000722#FCEB000340#FKOL001900#FCEB005711#FKOL009043#FKOL007507#FKOL008653#FBLR000604#FKOL003644#FKOL002879#FMUM005792#FCHE001275#FNOI000476#";

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_schedule_upload() {
    /*
      FCEB000018 	Michelle Sausa
      FCEB000015 	Rondec Adarlo
      FCEB000010 	Edlyn Dandoy
      FCEB000008	Sherryl Gay Demape
      FCEB000033	Ruth Jayme
      FCEB000004	Shahmin Christine Sencio
      FCEB000730	Jube Aries Luar
      FCEB000383	Jennifer Abellar
      FCEB000288 	Gloria Salazar
      Approve by prasun on 10/01/2020
      FCEB000437->Frederick Dave Caparida
      FKOL002635-Akash Shaw
      FCEB004161 Albert Joseph
      FCEB000764

      // FKOL001854 - Dipan	Sarkar
      // FKOL002245 - Purba	Hazra
      // FKOL004812 - SUSWETA DAS
      //FCHA000777 - Location Tester
      FKOL001900  Prasanta
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL000001#FKOL000005#FCEB000254#FCEB000650#FCEB000375#FKOL001751#FCEB000016#FKOL001916#FKOL002707#FKOL002569#FKOL002216#FCEB000746#FMAN000392#FCEB000018#FCEB000015#FCEB000010#FCEB000008#FCEB000033#FCEB000004#FCEB000730#FCEB000383#FCEB000288#FCEB000437#FKOL002635#FCEB004161#FCEB000764#FKOL001854#FKOL002245#FKOL004812#FCHA000777#FKOL001900#FKOL008451#FKOL008629#";

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_schedule_report() {
    /*
      FKOL001766
     */

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL001766#FKOL006426#FKOL009043#FKOL007507#FKOL008653#FBLR000604#FKOL003644#FKOL002879#FMUM005792#FCHE001275#FNOI000476#";

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_breakmon() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL009043#FKOL007507#FKOL008653#FBLR000604#FKOL003644#FKOL002879#FMUM005792#FCHE001275#FNOI000476#";

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function is_access_reset_password() {
    //FMAN000392 Rolando	Castardo
    // FKOL005767 Saswata 
    /*

      FCEB000159 Eileen.Martin-additional
      FCEB000018 Michelle Sausa
      FCEB000015 Rondec Adarlo
      FCEB000008 Sherryl Gay Demape
      FCEB000033 Ruth Jayme
      FCEB000004 Shahmin Christine Sencio
      FCEB000730 Jube Aries Luar
      FCEB000383 Jennifer Abellar
      FCEB000288 Gloria Salazar
      FCEB004161 Albert Joseph
      FCEB003791 Billy James De Vera

      FKOL001780 Arindam Dey
      FKOL002501 MD Mehraj
      FKOL001777 Ronik Chakraborty
      FKOL001782 Satyajit Jana
      FKOL002505 Sourav Gupta
      FKOL001779 Subhankar Bose
      FKOL002152 Aaqir Aslam
      FKOL003040 - Kingshuk Dey
      FKOL004569 - Faiyaz Azgar
      FKOL002196 - Debjyoti
      FBLR000213 Bala subramani.C
      FBLR000008	Ramachandran M
      FELS003406 - Julio Mendoza
      //FCHE000227
      FELS003419 -Jackie

      // FKOL001854 - Dipan	Sarkar
      // FKOL002245 - Purba	Hazra
      // FKOL004812 - SUSWETA DAS
      // FCHA000777

      •	FCHA002102
      •	FCHA002100
      •	FCHA002101
      •	FCHA002018
      •	FCHA002017
      •	FCHA002019
      •	FCHA002016
      •	FCHA001874
      •	FCHA002103
      •	FCHA002095
      //  FCHA003134 - Jaspal
      FKOL001900 - Prasanta
      FCHA002098
      FCHA000001
      FCAS000657 - Narimane

      Brittany Bridges	FSPI000107

     */

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = "##FKOL000001#FMAN000392#FKOL005767#FCEB000159#FCEB000018#FCEB000015#FCEB000008#FCEB000033#FCEB000004#FCEB000730#FCEB000383#FCEB000288#FCEB003791#FKOL001780#FKOL002501#FKOL001777#FKOL001782#FKOL002505#FKOL001779#FKOL002152#FKOL003040#FKOL004569#FKOL002196#FBLR000213#FBLR000008#FCEB004161#FELS003406#FCHE000227#FELS003419#FCEB000748#FSPI000110#FSPI000266#FSPI000258#FSPI000273#FSPI000117#FSPI000086#FSPI000087#FSPI000127#FSPI000348#FSPI000026#FSPI000020#FSPI000038#FHIG000319#FHIG000323#FHIG000195#FHIG000155#FHIG000239#FHIG000165#FHIG000202#FHIG000211#FHIG000173#FUTA000007#FMIN000011#FMIN000008#FALT002375#FALT002364#FKOL007297#FKOL007405#FKOL007508#FKOL008433#FKOL008627#FCHE000797#FKOL001854#FKOL002245#FKOL004812#FCHA000777#FCHA002102#FCHA002100#FCHA002101#FCHA002018#FCHA002017#FCHA002019#FCHA002016#FCHA001874#FCHA002103#FCHA002095#FELS003414#FELS004207#FKOL009320#FCHA003134#FKOL001900#FCHA002098#FCHA000001#FCAS000657#FSPI000107#FKOL001899#FKOL007158#";

    if (get_global_access() == '1')
        $ret = true;

    
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    if(get_dept_id()==35)
    {
        $ret = false;
    }
    return $ret;
}

function is_access_as_hr($ses_fusion_id) {
    $ret = false;

    // FKOL004086 MANGALDEEP
    // FKOL002198 Atanu
    // FKOL001766 Rohit	Sen
    // FKOL005386 Manoj Kumar Moharana
    //FKOL006124 - (Debraj Banerjee
    // FKOL008142 - SAHANAWAZ
    // FKOL007911 - Rohit Shaw
    // FMON004089 
    // FCHA000264 – Parkash Joshi
    // FCHA000262 – Mangal Singh
    // FCHA002098 – Gautam Rana
    //FELS003414 - Cecilia Carolina Vasquez Posada

    $access_ids = " #FKOL004086#FKOL002198#FKOL001766#FKOL005386#FKOL006124#FKOL008142#FKOL007911#FMON004089#FKOL008639#FKOL007906#FKOL008807#FCHA000264#FCHA000262#FCHA002098#FELS003414#FKOL007860#FKOL007211#FCHA000326#FCHA000279#FCHA000280#FCHA000327#FCHA003519#FCHA000278#FCHA000283#FKOL011173#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_as_wfm($ses_fusion_id) {
    $ret = false;

    // FKOL001854 - Dipan	Sarkar
    // FKOL002245 - Purba	Hazra
    // FKOL004812 - SUSWETA DAS
    //FCHA000777 -  Location Tester
    //FKOL001900 - Prasanta 

    $access_ids = " #FKOL001854#FKOL002245#FKOL004812#FCHA000777#FKOL001900#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_as_manager($ses_fusion_id) {
    $ret = false;

    /*
      FUTA000007
      FSPI000009
      FHIG000323
      FMIN000008
     */

    $access_ids = " #FUTA000007#FSPI000009#FHIG000323#FMIN000008#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_executive_access_as_supervisor($user_id, $role, $dept) {
    global $CI;
    $ret = false;

    if ($role == "agent" && $dept != "operations") {
        $qSql = "SELECT count(id) as value  FROM signin WHERE assigned_to = '$user_id' ";
        $query = $CI->db->query($qSql);
        $res = $query->row_array();
        if ($res["value"] > 0)
            $ret = true;
    }
    return $ret;
}

function is_access_id_card_module() {

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL006885#FKOL012897#FKOL006412#FKOL007055#FKOL003663#FNOI000565#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "hr")
        $ret = true;

    return $ret;
}

function isAccessNaps() {

    // FKOL001854 - Dipan	Sarkar
    // FKOL002245 - Purba	Hazra
    // FKOL004812 - SUSWETA DAS
    // FKOL001900 - Prasanta
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL008643#FKOL008803#FKOL001854#FKOL002245#FKOL004812#FCHA000327#FCHA000283#FCHA000268#FCHA000328#FCHA000272#FCHA003529#FCHA000326#FKOL001900#FKOL007078#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "hr")
        $ret = true;

    return $ret;
}

function isAccessAssetManagement() {

    /*
      FKOL008262 -Arup
      FKOL008451 - DEBOJIT
      // FKOL011477 - Farhaan Fatma John
     */

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL002504#FKOL005575#FKOL008262#FKOL008451#FKOL010158#FKOL005837#FKOL011477#FKOL012213#FJAM004503#FKOL012897#FNOI000565#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    elseif (get_site_admin() == '1')
        $ret = true;
    elseif (get_role_dir() == "admin")
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    return $ret;
}

function isAccessQuestionBank() {

    /*
      Leann Lesserreh Maluay : FCEB000386
      Arlene Salahuddin FCEB005369
     */

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB000791#FCEB000386#FCEB005369#FKOL008502#FCAS000484#FCEB005596#FCAS000152#FCAS000079#FCAS000484#FCAS000445#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    elseif (get_site_admin() == '1')
        $ret = true;
    elseif (get_role_dir() == "admin")
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "wfm" || get_dept_folder() == "qa" || get_dept_folder() == "training" || get_dept_folder() == "L&D" || get_dept_folder() == "hr" || get_role_dir() == "manager" || get_role_dir() == "admin" || is_approve_requisition() == true)
        $ret = true;

    return $ret;
}

function isAccessAdherenceManagementView() {

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FJAM004129#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    elseif (get_site_admin() == '1')
        $ret = true;
    elseif (get_role_dir() == "admin")
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "wfm" || get_dept_folder() == "hr")
        $ret = true;
    //get_role_dir()=="manager"

    return $ret;
}

function isAccessAdherenceManagementReport() {

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FJAM004129#FKOL006426#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    elseif (get_site_admin() == '1')
        $ret = true;
    elseif (get_role_dir() == "admin")
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_dept_folder() == "wfm" || get_dept_folder() == "hr")
        $ret = true;
    //get_role_dir()=="manager"

    return $ret;
}

function isAccessAddPip() {

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL001766#";

    $ret = false;

    if (get_global_access() == '1')
        $ret = true;
    elseif (get_site_admin() == '1')
        $ret = true;
    elseif (get_role_dir() == "admin")
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }

    if (get_role_dir() == 'tl' || get_role_dir() == 'manager')
        $ret = true;

    return $ret;
}

function is_disable_module() {

    $ret = false;
    if (get_user_office_id() == "xxxx")
        $ret = true;

    return $ret;
}

function is_access_appraisal_module() {

    /*
      FKOL003187	Sudeepta Moitra
      FKOL000003	Oindrila Banerjee Das
      FKOL005837	Shivika
      // FKOL011172 - Niladri
     */

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL000003#FKOL003187#FKOL005837#FKOL007562#FKOL010158#FKOL011172#FKOL001929#FKOL012410#";

    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    //if(get_dept_folder()=="hr" ) $ret=true;
    return $ret;
}
    function is_pms_permssion() {
       $ses_fusion_id = get_user_fusion_id();
        $access_ids = array("FKOL012410");
        $ret = false;
        if (in_array($ses_fusion_id,$access_ids) == false){
            $ret = false;
        }else{            
            $ret = true;
        }
        if(get_dept_folder()=="hr" ){ $ret=true;}
        return $ret;
    }
    function is_user_assignd_employee_count($user_id, $role, $dept) {
    global $CI;
    $ret = false;

    if ($role!= "agent" && $dept != "operations") {
        $qSql = "SELECT count(id) as value  FROM signin WHERE assigned_to = '$user_id' ";
        $query = $CI->db->query($qSql);
        $res = $query->row_array();
        if ($res["value"] > 0)
            $ret = true;
    }
    return $ret;
}
function is_access_resend_payslip() {

    /*
      FKOL003187	Sudeepta Moitra
      FKOL000003	Oindrila Banerjee Das
      FKOL005837	Shivika
      // FKOL011477 - Farhaan Fatma John
      // FKOL011172 - Niladri
     */

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL000003#FKOL003187#FKOL005837#FKOL007562#FKOL010158#FKOL011477#FKOL011172#FKOL001929#FKOL012897#";

    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    //if(get_dept_folder()=="hr" ) $ret=true;
    return $ret;
}

function is_access_gamification() {


    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL001953#FKOL004277#FKOL006364#FKOL006981#FKOL004688#FKOL006262#FKOL007967#FKOL004265#FKOL004674#";
    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    return $ret;
}

function is_access_harhith() {

    //FKOL007078 - daljeet
    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL007078#";
    $ret = false;

    if (get_user_office_id() == "CHA")
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;
    else {
        if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
            $ret = false;
        else
            $ret = true;
    }
    // elseif(get_site_admin()=='1' ) $ret=true;
    // elseif(get_role_dir()=="admin" ) $ret=true;

    if ($ret == false) {
        if ($client_ids == "")
            $ret = false;
        else {
            if (in_array('239', explode(',', $client_ids)) == true)
                $ret = true;
        }
    }


    return $ret;
}

///////////Quality Report Access (03/01/2020)////////////
/* function is_access_quality_report(){

  $ses_fusion_id=get_user_fusion_id();

  $access_ids=" #FELS003445#FKOL005348#";

  $ret=false;

  if( get_global_access()=='1' ) $ret=true;
  else{
  if(strpos($access_ids,"#".$ses_fusion_id."#")== false) $ret=false;
  else $ret=true;
  }

  if(get_dept_folder()=="qa" || get_dept_folder()=="mis") $ret=true;

  return $ret;

  } */

////////////////////////////////////////////////////////////////////////////////////
//  CHECK SESSION ANFD URL AUTHENTICATION
////////////////////////////////////////////////////////////////////////////////////

function check_session_url_authentication() {
    global $CI;

    $rr = $CI->session->userdata('logged_in');

    $_array = array("home", "super", "hr", "qa", "admin", "tl", "supervisor", "manager", "trainer", "support", "agent", "nesting", "trainee", "user", "users", "reports", "attendance", "emailinfo", "schedule", "logindetails", "audit", "coaching", "mis", "querybrowser", "master", "evaluation", "bulk_user", "profile", "leave", "apicanceltermination", "user_resign", "dfr", "bulk_user_update", "servicerequest");

    $exp = explode("/", current_url());

    $_role = '';

    foreach ($_array as $value) {
        if (in_array($value, $exp)) {
            $_role = $value;
            break;
        }
    }

    if ($_role == "") {
        show_404();
    }
}

function is_valid_session_url() {
    global $CI;

    $rr = $CI->session->userdata('logged_in');

    $_array = array("home", "super", "hr", "qa", "admin", "tl", "supervisor", "manager", "trainer", "support", "agent", "nesting", "trainee", "user", "users", "reports", "attendance", "emailinfo", "schedule", "logindetails", "audit", "coaching", "mis", "querybrowser", "master", "evaluation", "bulk_user", "profile", "leave", "apicanceltermination", "user_resign", "dfr", "bulk_user_update", "servicerequest");

    $exp = explode("/", current_url());
    //print_r($exp);

    $ans = true;

    foreach ($_array as $value) {
        if (in_array($value, $exp)) {
            $_role = $value;
            $ans = true;
            break;
        }
    }

    if ($ans == false) {

        show_404();
    }
}

////////////////////////////////////////////////////////////////////////////////////
//  MESSGAE BOXES
////////////////////////////////////////////////////////////////////////////////////

function show_msgbox($data, $error = true) {
    if ($error === true) {
        $html = '<div class="alert alert-danger">
					  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  ' . $data . '</div>';

        return $html;
    } else {
        $html = '<div class="alert alert-success">
					  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  ' . $data . '</div>';

        return $html;
    }
}

////////////////////////////////////////////////////////////////////////////////////
//  DATA INSERTER
////////////////////////////////////////////////////////////////////////////////////


function data_inserter($_tablename, $_field_array) {
    global $CI;
    try {
        if ($CI->db->insert($_tablename, $_field_array))
            return $CI->db->insert_id();
        else
            return false;
    } catch (Exception $e) {

        $lastError = error_get_last();
        $msg = $lastError ? "Error: " . $lastError["message"] . " on line " . $lastError["line"] : "";
        log_message('FEMS', 'data_inserter:: Caught exception: ', $msg);

        return false;
    }
}

function data_replace_into($_tablename, $_field_array) {
    global $CI;
    try {
        if ($CI->db->replace($_tablename, $_field_array))
            return $CI->db->insert_id();
        else
            return false;
    } catch (Exception $e) {

        $lastError = error_get_last();
        $msg = $lastError ? "Error: " . $lastError["message"] . " on line " . $lastError["line"] : "";
        log_message('FEMS', 'data_replace_into:: Caught exception: ', $msg);

        return false;
    }
}

function data_batch_inserter($_tablename, $_field_array) {
    global $CI;

    if ($CI->db->insert_batch($_tablename, $_field_array))
        return true;
    else
        return false;
}

function get_single_value($qSql) {
    global $CI;
    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

function getEstToLocalCurrUser($dttime) {
    global $CI;
    $current_user = get_user_id();
    $qSql = "Select getEstToLocal('$dttime',$current_user) as value";
    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

function getEstToLocal($dttime, $user_id) {
    global $CI;
    $qSql = "Select getEstToLocal('$dttime',$user_id) as value";
    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

function getEstToLocalByMwpId($dttime, $mwpid) {
    global $CI;
    $qSql = "Select getEstToLocal('$dttime',(select id from signin where fusion_id='$mwpid')) as value";
    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

function getLocalToEstByMwpId($dttime, $mwpid) {
    global $CI;
    $qSql = "Select getLocalToEst('$dttime',(select id from signin where fusion_id='$mwpid')) as value";
    $query = $CI->db->query($qSql);
    $res = $query->row_array();
    return $res["value"];
}

function get_notify_count() {

    return "0";
}

function get_notify_html() {

    $html = "";

    $html = '<div class="alert-info">';
    $html .= 'Indicates a neutral informative change or action.';
    $html .= '</div>';

    return $html;
}

////////////////////////////////////////////////////////////////////////////////////
//  Date Functions
////////////////////////////////////////////////////////////////////////////////////

function mmddyy2mysql($date) {

    $date = str_replace("/", "-", $date);
    $new = explode("-", $date);
    $a = array($new[2], $new[0], $new[1]);
    return $n_date = implode("-", $a);
}

function ddmmyy2mysql($date) {

    $date = str_replace("/", "-", $date);
    $new = explode("-", $date);
    $a = array($new[2], $new[1], $new[0]);
    return $n_date = implode("-", $a);
}

function mdydt2mysql($datetm) {

    $newdt = explode(" ", $datetm);

    $date = $newdt[0];
    $tm = $newdt[1];

    $date = str_replace("/", "-", $date);
    $new = explode("-", $date);
    $a = array($new[2], $new[0], $new[1]);
    $n_date = implode("-", $a) . " " . $tm;
    return $n_date;
}

function mdyDateTime2MysqlDate($datetm) {

    $newdt = explode(" ", $datetm);
    $date = $newdt[0];
    $tm = $newdt[1];

    $date = str_replace("/", "-", $date);
    $new = explode("-", $date);
    $a = array($new[2], $new[0], $new[1]);
    $n_date = implode("-", $a);
    return $n_date;
}

function mysqlDt2mmddyy($datetm) {

    $newdt = explode(" ", $datetm);
    $date = $newdt[0];
    $tm = $newdt[1];

    $date = str_replace("/", "-", $date);
    $new = explode("-", $date);
    $a = array($new[1], $new[2], $new[0]);
    $n_date = implode("-", $a) . " " . $tm;
    return $n_date;
}

function mysqlDt2mmddyyDate($datetm) {

    $newdt = explode(" ", $datetm);
    $date = $newdt[0];
    //$tm=$newdt[1];

    $date = str_replace("/", "-", $date);
    $new = explode("-", $date);
    $a = array($new[1], $new[2], $new[0]);
    $n_date = implode("/", $a);
    return $n_date;
}

function mysqlDt2yymmddDate($datetm) {

    $newdt = explode(" ", $datetm);
    $date = $newdt[0];

    return $date;
}

function mysql2mmddyy($date) {
    if ($date == "") {
        return $date;
    }

    $date = str_replace("/", "-", $date);
    $new = explode("-", $date);
    $a = array($new[1], $new[2], $new[0]);
    return $n_date = implode("-", $a);
}

function mysql2mmddyySls($date) {

    $date = str_replace("/", "-", $date);
    $new = explode("-", $date);
    $a = array($new[1], $new[2], $new[0]);
    return $n_date = implode("/", $a);
}

function mysqlToddmmyy($date) {
    if ($date == "") {
        return $date;
    }

    $newdt = explode(" ", $date);
    $date = $newdt[0];

    $date = str_replace("/", "-", $date);
    $new = explode("-", $date);
    $a = array($new[2], $new[1], $new[0]);
    $n_date = implode("-", $a);
    return $n_date;
}

function CurrMySqlDate() {

    $dt = date("Y-m-d", time());
    $tm = date("H:i:s", time());
    $mydt = $dt . " " . $tm;
    return $mydt;
}

function CurrDate() {
    $dt = date("Y-m-d", time());
    return $dt;
}

function CurrDateTimeMDY() {

    $dt = date("m/d/Y", time());
    $tm = date("H:i:s", time());
    $mydt = $dt . " " . $tm;
    return $mydt;
}

function CurrDateTimeMDYnew() {

    $dt = date("m/d/Y", "00:00:00");
    $tm = date("H:i:s", "00:00:00");
    $mydt = $dt . " " . $tm;
    return $mydt;
}

function CurrDateMDY() {
    $dt = date("m/d/Y", time());
    return $dt;
}

function CurrTime() {
    $tm = date("H:i:s", time());
    return $tm;
}

function isValidMysqlDate($date, $format = '') {
    //echo $format;// die;
    $format = (($format == '') ? 'Y-m-d' : $format);
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

//////////////////////////////////////////

function GetLocalTimeByOffice($loc) {
    global $CI;
    $query = $CI->db->query("SELECT time_zone_str, time_zone_str_ds FROM `office_location` where abbr='" . $loc . "'");

    $row = $query->row();

    $dtTime = date('Y-m-d H:i:s');
    if (isDayLightSaving($dtTime, $loc) == 0)
        $serverTime = $row->time_zone_str;
    else
        $serverTime = $row->time_zone_str_ds;

    $xmasDay = new DateTime(date('Y-m-d H:i:s') . ' ' . $serverTime . '');
    return $xmasDay->format('Y-m-d H:i:s');
}

function GetLocalDateByOffice($loc) {
    global $CI;
    $query = $CI->db->query("SELECT time_zone_str, time_zone_str_ds FROM `office_location` where abbr='" . $loc . "'");

    $row = $query->row();

    $dtTime = date('Y-m-d H:i:s');
    if (isDayLightSaving($dtTime, $loc) == 0)
        $serverTime = $row->time_zone_str;
    else
        $serverTime = $row->time_zone_str_ds;

    $xmasDay = new DateTime(date('Y-m-d H:i:s') . ' ' . $serverTime . '');
    return $xmasDay->format('Y-m-d');
}

function GetLocalDate() {
    global $CI;
    $query = $CI->db->query("SELECT time_zone_str, time_zone_str_ds FROM `office_location` where abbr='" . get_user_office_id() . "'");

    $row = $query->row();
    $dtTime = date('Y-m-d H:i:s');

    if (isDayLightSaving($dtTime) == 0)
        $serverTime = $row->time_zone_str;
    else
        $serverTime = $row->time_zone_str_ds;

    $xmasDay = new DateTime(date('Y-m-d H:i:s') . ' ' . $serverTime . '');
    return $xmasDay->format('Y-m-d');
}

function GetLocalMDYDate() {
    global $CI;
    $query = $CI->db->query("SELECT time_zone_str, time_zone_str_ds FROM `office_location` where abbr='" . get_user_office_id() . "'");

    $row = $query->row();
    $dtTime = date('Y-m-d H:i:s');

    if (isDayLightSaving($dtTime) == 0)
        $serverTime = $row->time_zone_str;
    else
        $serverTime = $row->time_zone_str_ds;

    $xmasDay = new DateTime(date('Y-m-d H:i:s') . ' ' . $serverTime . '');
    return $xmasDay->format('m-d-Y');
}

function GetLocalTime() {
    global $CI;
    $query = $CI->db->query("SELECT time_zone_str, time_zone_str_ds FROM `office_location` where abbr='" . get_user_office_id() . "'");

    $row = $query->row();
    $dtTime = date('Y-m-d H:i:s');

    if (isDayLightSaving($dtTime) == 0)
        $serverTime = $row->time_zone_str;
    else
        $serverTime = $row->time_zone_str_ds;

    $xmasDay = new DateTime(date('Y-m-d H:i:s') . ' ' . $serverTime . '');
    return $xmasDay->format('Y-m-d H:i:s');
}

function ConvServerToLocal($dtTime) {
    global $CI;
    $query = $CI->db->query("SELECT time_zone_str, time_zone_str_ds FROM `office_location` where abbr='" . get_user_office_id() . "'");

    $row = $query->row();

    if (isDayLightSaving($dtTime) == 0)
        $serverTime = $row->time_zone_str;
    else
        $serverTime = $row->time_zone_str_ds;

    $xmasDay = new DateTime($dtTime . " " . $serverTime . "");

    return $xmasDay->format('Y-m-d H:i:s');
}

function ConvLocalToServer($dtTime) {
    global $CI;

    $loc = get_user_office_id();

    $query = $CI->db->query("SELECT time_zone_str, time_zone_str_ds FROM `office_location` where abbr='" . get_user_office_id() . "'");
    $row = $query->row();

    if (isDayLightSaving($dtTime) == 0)
        $serverTime = $row->time_zone_str;
    else
        $serverTime = $row->time_zone_str_ds;

    $StartWith = substr($serverTime, 0, 1);
    if ($StartWith == "-" || $StartWith == "+")
        $serverTime = substr($serverTime, 1);
    if ($StartWith == "-")
        $serverTime = "+ " . $serverTime;
    else
        $serverTime = "- " . $serverTime;

    $xmasDay = new DateTime($dtTime . ' ' . $serverTime . "");
    return $xmasDay->format('Y-m-d H:i:s');
}

function ConvServerToLocalAny($dtTime, $loc) {
    if ($dtTime == "")
        return "";
    if ($loc == "")
        return "";

    global $CI;
    $query = $CI->db->query("SELECT time_zone_str, time_zone_str_ds FROM `office_location` where abbr='" . $loc . "'");
    $row = $query->row();

    if (isDayLightSaving($dtTime, $loc) == 0)
        $serverTime = $row->time_zone_str;
    else
        $serverTime = $row->time_zone_str_ds;

    $xmasDay = new DateTime($dtTime . " " . $serverTime . "");

    return $xmasDay->format('Y-m-d H:i:s');
}

function ConvLocalToServerAny($dtTime, $loc) {
    if ($dtTime == "")
        return "";
    if ($loc == "")
        return "";

    global $CI;

    $query = $CI->db->query("SELECT time_zone_str, time_zone_str_ds FROM `office_location` where abbr='" . $loc . "'");
    $row = $query->row();

    if (isDayLightSaving($dtTime, $loc) == 0)
        $serverTime = $row->time_zone_str;
    else
        $serverTime = $row->time_zone_str_ds;

    $StartWith = substr($serverTime, 0, 1);
    if ($StartWith == "-" || $StartWith == "+")
        $serverTime = substr($serverTime, 1);

    if ($StartWith == "-")
        $serverTime = "+ " . $serverTime;
    else
        $serverTime = "- " . $serverTime;

    $xmasDay = new DateTime($dtTime . ' ' . $serverTime . "");
    return $xmasDay->format('Y-m-d H:i:s');
}

function isDayLightSaving($anydt, $loc = "") {
    if ($loc == "")
        $loc = get_user_office_id();
    $dat = date('Y-m-d', strtotime($anydt));
    $year = date('Y', strtotime($anydt));

    $count = 0;

    if (isValidMysqlDate($dat) == true) {

        global $CI;

        $qSql = "Select isDayLightSaving('$dat','$loc') as value";
        $query = $CI->db->query($qSql);
        $res = $query->row_array();
        $count = $res["value"];
    }
    return $count;
}

function addLeadingZero($vStr, $t) {
    $pdStr = substr('000000000000000' . $vStr, -$t);
    return $pdStr;
}

function dateDiffCount($start, $end) {
    $date1 = date_create($start);
    $date2 = date_create($end);
    $diff = date_diff($date1, $date2);
    return $diff->format("%a") + 1;
}

function getCurrTimeDiffInMinute($dt1) {
    $date1 = strtotime($dt1);
    $currdt = strtotime(CurrMySqlDate());
    return round(($currdt - $date1) / 60, 2);
}

function getDayPart($cdate) {
    return date("d", strtotime($cdate));
}

function getMonthNumber($cdate) {
    return date("n", strtotime($cdate));
}

function getYear($cdate) {
    return date("Y", strtotime($cdate));
}

function daysInMonth($cdate) {
    return date("t", strtotime($cdate));
}

function daysInYear($year) {
    $yeardays = 0;
    for ($i = 1; $i <= 12; $i++) {
        $yeardays += cal_days_in_month(CAL_GREGORIAN, $i, $year);
    }
    return $yeardays;
}

function countWeekendDays($start, $end) {
    $iter = 24 * 60 * 60; // whole day in seconds
    $count = 0; // keep a count of Sats & Suns

    for ($i = $start; $i <= $end; $i = $i + $iter) {
        if (Date('D', $i) == 'Sat' || Date('D', $i) == 'Sun') {
            $count++;
        }
    }
    return $count;
}

/*
  function getReportingHead($cdate)
  {
  return date("t", strtotime($cdate));
  }
 */

function lz($num) {
    return (strlen($num) < 2) ? "0{$num}" : $num;
}

function convertToTimeHHMM($h) {
    //return floor($h).":".(floor($h * 60) % 60).":". (floor($h * 3600) % 60);
    return lz(floor($h)) . ":" . lz(floor($h * 60) % 60); //
}

function convertSecToTime($sec) {
    return lz(floor($sec / (60 * 60))) . ":" . lz(floor(($sec % (60 * 60)) / 60)) . ":" . lz(floor(($sec % (60 * 60)) % 60));
}

function get_night_login($login = '', $logout = '', $office_id = '') {

    $NCalLoginDate = "";
    $NCalLogoutDate = "";

    $loginSet = "22:00:00";
    $logoutSet = "06:00:00";

    if ($office_id == "CEB" || $office_id == "MAN") {

        $loginSet = "22:00:00";
        $logoutSet = "06:00:00";
    } else {
        return "0";
    }

    $NightLoginDate = date('Y-m-d', strtotime($login)) . " " . $loginSet;
    $PrevNightLoginDate = date('Y-m-d', strtotime("-1 day", strtotime($login))) . " " . $loginSet;

    $NightLogoutDate = date('Y-m-d', strtotime("+1 day", strtotime($login))) . " " . $logoutSet;
    $PrevNightLogoutDate = date('Y-m-d', strtotime($login)) . " " . $logoutSet;

    if (strtotime($login) >= strtotime($PrevNightLoginDate) && strtotime($login) <= strtotime($PrevNightLogoutDate)) {
        $NCalLoginDate = $login;
    } else if (strtotime($login) <= strtotime($NightLoginDate))
        $NCalLoginDate = $NightLoginDate;
    else
        $NCalLoginDate = $login;

    if (strtotime($logout) >= strtotime($PrevNightLogoutDate) && strtotime($logout) <= strtotime($NightLoginDate)) {
        $NCalLogoutDate = $PrevNightLogoutDate;
    } else if (strtotime($logout) <= strtotime($NightLogoutDate)) {
        $NCalLogoutDate = $logout;
    } else
        $NCalLogoutDate = $NightLogoutDate;

    // ACTUAL Light Login SECONDS
    $nightLoginSeconds = 0;
    if (strtotime($NCalLogoutDate) > strtotime($NCalLoginDate)) {
        $nightLoginSeconds = strtotime($NCalLogoutDate) - strtotime($NCalLoginDate);
    }

    return $nightLoginSeconds;
}

function getDayDateArray($st, $ed) {
    $start = strtotime($st);
    $end = strtotime($ed);
    $dtArray = array();
    // start and end are seconds, so I convert it to days 

    $diff = ($end - $start) / 86400;
    for ($i = 0; $i <= $diff; $i++) {
        $cDate = date('Y-m-d', $start);
        $cday = strtoupper(date("D", $start));
        // echo $cDate  ." = " . $cday . "<br>";
        $dtArray[$cday] = $cDate;
        $start = strtotime($cDate . ' +1 day');
    }

    return $dtArray;
}

function callHarhithSMSAPI($tktNo) {

    global $CI;
    $qSql = "SELECT mc.name as prompt, c.customer_phone as cPhone  FROM harhith_crm c LEFT JOIN harhith_master_calltype as mc ON mc.id = c.call_type where ticket_no='$tktNo';";

    $query = $CI->db->query($qSql);
    $row = $query->row();
    $prompt = $row->prompt;
    $cPhone = $row->cPhone;
    $cPhone = str_replace("-", "", $cPhone);

    $msg = urlencode("Welcome to Harhith Retail Expansion Project of HAICL. Your Ticket No for " . $prompt . " is " . $tktNo . ".For Any query you can reach us @9517951711");

    $cUrl = "http://125.16.147.178/VoicenSMS/webresources/CreateSMSCampaignGet?ukey=SCzi7Mo0oZVQP6yZCNEq3WeUR&msisdn=" . $cPhone . "&language=0&credittype=7&senderid=CSPCMP&templateid=0&message=" . $msg . "&filetype=2";

    //echo $cUrl;
    //echo '<br/><br/>';
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_HEADER,FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.001 (windows; U; NT4.0; en-US; rv:1.0) Gecko/25250101');
    curl_setopt($ch, CURLOPT_URL, $cUrl);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
    //curl_setopt($ch, CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_array);
    curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = trim(curl_exec($ch));

    $info = curl_getinfo($ch);
    //print_r($info);
    //echo curl_errno($ch) . '<br/>';
    //echo curl_error($ch) . '<br/>';
    //print_r($response);

    $reqLog = "cPhone: " . $cPhone . " prompt:" . $prompt . " Ticket No:" . $tktNo;
    log_api_record('0', 'callHarhithSMSAPI', 'Harhith SMS API', $response, $reqLog);

    curl_close($ch);
    return $response;
}

function getCurlRequest($cUrl, $curl_array) {

    $cUrl = $cUrl . "?" . http_build_query($curl_array);
    //echo $cUrl;
    //echo '<br/><br/>';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.001 (windows; U; NT4.0; en-US; rv:1.0) Gecko/25250101');
    curl_setopt($ch, CURLOPT_URL, $cUrl);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_array);
    curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = trim(curl_exec($ch));

    $info = curl_getinfo($ch);
    //print_r($info);
    //echo curl_errno($ch) . '<br/>';
    //echo curl_error($ch) . '<br/>';

    curl_close($ch);
    return $response;
}

function getExt($filename) {
    return $ext = pathinfo($filename)['extension'];
}

function getIconUrl($filename, $folder = "policy") {

    global $CI;
    $ext = getExt($filename);
    $ext = strtolower($ext);

    $imgArray = array("jpg", "jpeg", "png", "gif");
    $docArray = array("doc", "docx");
    $excelArray = array("xls", "xlsx");
    $pptArray = array("ppt", "pptx", "pps", "ppsx");
    $pdfArray = array("pdf");
    $txtArray = array("txt");
    $csvArray = array("csv");
    $videoArray = array("mp4", "avi", "mkv", "mpeg", "mpeg4", "mov", "wmv");
    $htmlArray = array("html", "htm");
    $imgUrl = "/assets/images/un.png";

    $BaseRealPath = $CI->config->item('BaseRealPath');

    if (in_array($ext, $imgArray)) {

        $imgPath = $BaseRealPath . "/$folder/" . $filename;
        if (file_exists($imgPath))
            $imgUrl = "/$folder/" . $filename;
        else
            $imgUrl = "/uploads/$folder/" . $filename;
    } else if (in_array($ext, $docArray))
        $imgUrl = "/assets/images/doc.png";
    else if (in_array($ext, $excelArray))
        $imgUrl = "/assets/images/excel.png";
    else if (in_array($ext, $pptArray))
        $imgUrl = "/assets/images/ppt.png";
    else if (in_array($ext, $pdfArray))
        $imgUrl = "/assets/images/pdf.png";
    else if (in_array($ext, $txtArray))
        $imgUrl = "/assets/images/txt.png";
    else if (in_array($ext, $csvArray))
        $imgUrl = "/assets/images/csv.png";
    else if (in_array($ext, $videoArray))
        $imgUrl = "/assets/images/video.png";
    else if (in_array($ext, $htmlArray))
        $imgUrl = "/assets/images/html.png";
    return $imgUrl;
}

function create_birthday_card($bname) {

    $imgPath = APPPATH . '../assets/images/birthday_card1.jpg';
    $jpg_image = imagecreatefromjpeg($imgPath);
    $image_width = imagesx($jpg_image);
    $color = imagecolorallocate($jpg_image, 255, 255, 255);

    $text = strtolower($bname);
    $text = ucwords($text);

    $font_size = 20;
    if (strlen($text) > 30) {
        $font_size = 6;
        $font_path = APPPATH . '../assets/font/Sketchalot.ttf';
    } else if (strlen($text) > 20) {
        $font_size = 22;
        $font_path = APPPATH . '../assets/font/RiseofKingdom.ttf';
    } else {
        $font_size = 35;
        $font_path = APPPATH . '../assets/font/AlexBrush-Regular.ttf';
    }

    $font_angle = 0;
    list($left,, $right) = imageftbbox($font_size, $font_angle, $font_path, $text);
    $dwidth = $right - $left;
    $x = (($image_width / 2) - $dwidth / 2);
    $y = 475;
    imagettftext($jpg_image, $font_size, $font_angle, $x, $y, $color, $font_path, $text);

    ob_start();
    imagejpeg($jpg_image);
    $contents = ob_get_contents();
    ob_end_clean();
    imagedestroy($jpg_image);
    return base64_encode($contents);
}

function create_birthday_card_url($bname, $fusion_id) {

    global $CI;
    $BaseRealPath = $CI->config->item('BaseRealPath');

    //$imgPath = APPPATH.'../assets/images/birthday_card2.jpg';
    $imgPath = $BaseRealPath . '/assets/images/birthday_card2.jpg';
    $jpg_image = imagecreatefromjpeg($imgPath);
    $image_width = imagesx($jpg_image);
    $color = imagecolorallocate($jpg_image, 255, 255, 255);
    $text = strtolower($bname);
    $text = ucwords($text);

    $font_size = 20;
    if (strlen($text) > 35) {
        $font_size = 8;
        //$font_path = APPPATH.'../assets/font/Sketchalot.ttf';
        $font_path = $BaseRealPath . '/assets/font/Sketchalot.ttf';
    } else if (strlen($text) > 25) {
        $font_size = 26;
        //$font_path = APPPATH.'../assets/font/RiseofKingdom.ttf';
        //$font_path = APPPATH.'../assets/font/AlexBrush-Regular.ttf';
        $font_path = $BaseRealPath . '/assets/font/AlexBrush-Regular.ttf';
    } else {
        $font_size = 35;
        //$font_path = APPPATH.'../assets/font/AlexBrush-Regular.ttf';
        $font_path = $BaseRealPath . '/assets/font/AlexBrush-Regular.ttf';
    }

    $font_angle = 0;
    list($left,, $right) = imageftbbox($font_size, $font_angle, $font_path, $text);
    $dwidth = $right - $left;
    $x = (($image_width / 2) - $dwidth / 2);
    $y = 600;
    imagettftext($jpg_image, $font_size, $font_angle, $x, $y, $color, $font_path, $text);

    //$BimagPath=APPPATH.'../../birthday/'.$fusion_id;
    $BimagPath = '/opt/lampp/htdocs/birthday/' . $fusion_id;

    if (!file_exists($BimagPath))
        mkdir($BimagPath, 0777, true);

    $BimagName = '/birthday_' . $fusion_id . '.jpg';

    //$IuRL= 'https://fems.fusionbposervices.com/birthday/'.$fusion_id.$BimagName;

    $IuRL = 'https://mindwork.place/fusion/' . $fusion_id . $BimagName;

    imagejpeg($jpg_image, $BimagPath . $BimagName);
    // Free up memory

    return $IuRL;
}

function get_month($month) {
    $month = (int) $month;
    if ($month == 0 || $month === false)
        return '';
    $dateObj = DateTime::createFromFormat('!m', $month);
    $monthName = $dateObj->format('F');
    return $monthName;
}

function htmlToPlainText($str) {
    $str = str_replace('&nbsp;', ' ', $str);
    $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT, 'UTF-8');
    $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
    $str = html_entity_decode($str);
    $str = htmlspecialchars_decode($str);
    $str = strip_tags($str);
    $str = stripslashes($str);
    $str = str_replace('\r\n', ' ', $str);
    $str = preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', $str);

    return $str;
}

function get_payslip_desc($office_id) {

    $paydesc = "";
    $cDate = CurrDate();
    $currYear = getYear($cDate);
    $currMonth = getMonthNumber($cDate);
    $currMonthName = substr(get_month($currMonth), 0, 3);
    $currDay = getDayPart($cDate);

    //Payslips - they will upload within 1st to 14th of the month will be the Payslips for Second Cycle of Last Month. Similarly, the Payslips they will upload within 15th to 30th of the month will be the Payslips for First Cycle of Current Month

    if ($office_id == "JAM" || $office_id == "ELS") {

        if ($currDay >= 15 and $currDay <= 30) {
            $paydesc = $currMonthName . "-" . $currYear . "-1st";
        } else {
            if ($currDay >= 1 and $currDay <= 14) {
                $currMonth = $currMonth - 1;
                $currMonthName = substr(get_month($currMonth), 0, 3);
            }

            $paydesc = $currMonthName . "-" . $currYear . "-2nd";
        }
    } else if ($office_id == "CEB" || $office_id == "MAN") {
        if ($currDay >= 12 and $currDay <= 20) {
            $paydesc = $currMonthName . "-" . $currYear . "-1st";
        } else {
            if ($currDay >= 1 and $currDay <= 11) {
                $currMonth = $currMonth - 1;
                $currMonthName = substr(get_month($currMonth), 0, 3);
            }
            $paydesc = $currMonthName . "-" . $currYear . "-2nd";
        }
    } else {

        if ($currDay >= 1 and $currDay <= 28) {
            $currMonth = $currMonth - 1;
            $currMonthName = substr(get_month($currMonth), 0, 3);
        }

        $paydesc = $currMonthName . "-" . $currYear;
    }

    return $paydesc;
}

function log_record($user_id, $description, $module, $form_data, $logs = "", $download = '0') {

    global $CI;
    $query = $CI->db->query("INSERT INTO `log`(module, `description`, `user_id`, `added_time`,search_query,dtls,download) VALUES ('" . $module . "','" . $description . "','" . $user_id . "',now()," . $CI->db->escape(json_encode($form_data)) . ",'" . $logs . "', '" . $download . "' )");
    if ($query) {
        return true;
    } else {
        return false;
    }
}

function log_api_record($user_id, $description, $module, $form_data, $logs = "", $download = '0') {

    global $CI;
    $query = $CI->db->query("INSERT INTO `log_api`(module, `description`, `user_id`, `added_time`,search_query,dtls,download) VALUES ('" . $module . "','" . $description . "','" . $user_id . "',now()," . $CI->db->escape(json_encode($form_data)) . ",'" . $logs . "', '" . $download . "' )");
    if ($query) {
        return true;
    } else {
        return false;
    }
}

function getClientIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

/* * ***************************************************************** */

// PMETRIX LOG
/* * ***************************************************************** */

function pm_log_record($user_id, $description, $module, $form_data, $logs = "", $download = '0') {

    global $CI;

    $sql = "INSERT INTO `log_pm`(module, `description`, `user_id`, `time`,search_query,dtls,download, client_id, process_id, office_id,usertype) 
			VALUES ('" . $module . "','" . $description . "','" . $user_id . "',now()," . $CI->db->escape(json_encode($form_data)) . ",'" . $logs . "', '" . $download . "'";

    //print $sql."<br>";

    if (array_key_exists("client_id", $form_data))
        $sql .= ",'" . $form_data["client_id"] . "'";
    else
        $sql .= ",''";


    if (array_key_exists("process_id", $form_data))
        $sql .= ",'" . $form_data["process_id"] . "'";
    else
        $sql .= ",''";

    if (array_key_exists("office_id", $form_data))
        $sql .= ",'" . $form_data["office_id"] . "'";
    else
        $sql .= ",''";

    $sql .= ",'" . get_login_type() . "')";

    $query = $CI->db->query($sql);
    if ($query) {
        return true;
    } else {
        return false;
    }
}

function check_file_count($category_id, $course_id) {
    global $CI;

    $query = $CI->db->query("select count(file_id) as no from course_filedetails where categories_id=$category_id AND course_id= $course_id");
    $res = $query->row_array();
    /* 		
      echo "<pre>";
      print_r($res['no']);
     */
    if (check_logged_in()) {
        if ($res['no'] > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}

function mask_email($str, $amount = 2, $char = '*') {
    list($local, $domain) = explode("@", $str);
    return substr($local, 0, $amount) . str_repeat($char, strlen($local) - $amount) . "@" . $domain;
}

function get_profile_pic($fid) {
    global $CI;
    $qSql = "Select pic_ext from signin where fusion_id='$fid'";
    $query = $CI->db->query($qSql);
    $row = $query->row_array();
    $url = "";
    if ($row["pic_ext"] == "")
        $url = base_url() . "pimgs/blank.png";
    else
        $url = base_url() . "pimgs/$fid/$fid." . $row["pic_ext"];
    return $url;
}

/* * ***************************************************************** */

// BLENDED PMETRIX LOG
/* * ***************************************************************** */

function pm_blended_log($user_id, $description, $module, $form_data, $logs = "", $download = '0') {

    global $CI;

    $sql = "INSERT INTO `pm_blended_log`(module, `description`, `user_id`, `time`,search_query, dtls, download, user_type) 
				VALUES ('" . $module . "','" . $description . "','" . get_current_user() . "',now()," . $CI->db->escape(json_encode($form_data)) . ",'" . $logs . "', '" . $download . "'";

    $sql .= ",'" . get_login_type() . "')";

    $query = $CI->db->query($sql);
    if ($query)
        return true;
    else
        return false;
}

function get_client_name_by_id($client_id) {
    global $CI;
    if ($client_id == "ALL")
        return $client_id;
    else {
        $query = $CI->db->query("SELECT shname from client where id='$client_id'");
        $res = $query->row_array();
        return $res['shname'];
    }
}

function get_process_name_by_id($process_id) {
    global $CI;

    if ($process_id == "ALL")
        return $process_id;
    else {
        $query = $CI->db->query("SELECT name from process where id='$process_id'");
        $res = $query->row_array();
    }
    return $res['name'];
}

function get_name_by_fems_id($fems_id) {
    global $CI;

    $query = $CI->db->query("SELECT fname,lname from signin where fusion_id='$fems_id'");
    $res = $query->row_array();
    $name = $res['fname'] . ' ' . $res['lname'];
    return $name;
}

function get_name_by_user_id($id) {
    global $CI;

    $query = $CI->db->query("SELECT fname,lname from signin where id='$id'");
    $res = $query->row_array();
    $name = $res['fname'] . ' ' . $res['lname'];
    return $name;
}

function get_location_by_abbr($abbr) {
    global $CI;

    if ($abbr == "ALL")
        return $abbr;
    else {
        $query = $CI->db->query("SELECT office_name from office_location where abbr='$abbr'");
        $res = $query->row_array();
        $name = $res['office_name'];
        return $name;
    }
}

function get_timezone_name($GMT) {

    $timezones = array(
        '-12:00' => 'Pacific/Kwajalein',
        '-11:00' => 'Pacific/Samoa',
        '-10:00' => 'Pacific/Honolulu',
        '-09:00' => 'America/Juneau',
        '-08:00' => 'America/Los_Angeles',
        '-07:00' => 'America/Denver',
        '-06:00' => 'America/Mexico_City',
        '-05:00' => 'America/New_York',
        '-04:00' => 'America/Caracas',
        '-03:30' => 'America/St_Johns',
        '-03:00' => 'America/Argentina/Buenos_Aires',
        '-02:00' => 'Atlantic/Azores',
        '-01:00' => 'Atlantic/Azores',
        '+00:00' => 'Europe/London',
        '+01:00' => 'Europe/Paris',
        '+02:00' => 'Europe/Helsinki',
        '+03:00' => 'Europe/Moscow',
        '+03:30' => 'Asia/Tehran',
        '+04:00' => 'Asia/Baku',
        '+04:30' => 'Asia/Kabul',
        '+05:00' => 'Asia/Karachi',
        '+05:30' => 'Asia/Calcutta',
        '+06:00' => 'Asia/Colombo',
        '+07:00' => 'Asia/Bangkok',
        '+08:00' => 'Asia/Singapore',
        '+09:00' => 'Asia/Tokyo',
        '+09:00' => 'Australia/Darwin',
        '+10:00' => 'Pacific/Guam',
        '+11:00' => 'Asia/Magadan',
        '+12:00' => 'Asia/Kamchatka'
    );
    if (in_array($GMT, $timezones))
        $zonename = $timezones[$GMT];
    else
        $zonename = "Asia/Kolkata";
    return $zonename;
}

function is_access_mckinsey_modules() {

    // Mckinsey		
    $client_ids = get_client_ids();
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = $access_ids = " #FKOL007187#FHIG000065#FHIG000238#FHIG000301#FKOL001934#FKOL005611#FSPI000099#FSPI000907#FSPI000928#FSPI000931#FSPI000932#FSPI000938#FSPI000958#FSPI000959#FSPI000960#FSPI000924#FSPI000961#FSPI000963#";
    $ret = false;

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    /* if($ret==false){
      if($client_ids=="") $ret=false;
      else {
      if (in_array('184', explode(',',$client_ids)) == true) $ret=true;
      }
      } */

    return $ret;
}

function is_access_mckinsey_report() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = " #FKOL007187#FSPI000099#FHIG000065#FHIG000301#FHIG000238#FKOL001934#FKOL005611#FCEB004639#FSPI000105#FSPI000099#FSPI000961#FSPI000932#FHIG000302#FMON004394#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_mckinsey_add() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL007187#FSPI000928#FSPI000938#FSPI000932#FSPI000907#FSPI000931#FSPI000958#FSPI000099#FHIG000065#FHIG000301#FHIG000238#FSPI000959#FSPI000960#FSPI000924#FSPI000961#FSPI000963#FCEB004639#FSPI000105#FSPI000099#FSPI000961#FSPI000932#FHIG000302#FMON004394#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_mckinsey_edit() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL007187#FSPI000928#FSPI000938#FSPI000932#FSPI000907#FSPI000931#FSPI000958#FSPI000099#FHIG000065#FHIG000301#FHIG000238#FKOL001934#FSPI000959#FSPI000960#FSPI000924#FSPI000961#FSPI000963#FCEB004639#FSPI000105#FSPI000099#FSPI000961#FSPI000932#FHIG000302#FMON004394#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_mckinsey_delete() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL007187#FSPI000928#FSPI000938#FSPI000932#FSPI000907#FSPI000931#FSPI000958#FSPI000099#FHIG000065#FHIG000301#FHIG000238#FCEB004639#FSPI000105#FSPI000099#FSPI000961#FSPI000932#FHIG000302#FMON004394#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function is_access_mckinsey_email() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FKOL007187#FKOL001961#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_global_access() == '1')
        $ret = true;

    return $ret;
}

function review_omind_user_phili() {
    $ret = false;
    $user_office = get_user_office_id();
    $access_locations = array("CEB", "MAN");
    if (in_array($user_office, $access_locations)) {
        $ret = true;
    } else
        $ret = false;

    return $ret;
}

function review_omind_user_cas() {
    $ret = false;
    $user_office = get_user_office_id();
    $access_locations = array("CAS");
    if (in_array($user_office, $access_locations)) {
        $ret = true;
    } else
        $ret = false;

    return $ret;
}

function review_omind_user() {
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = array("FKOL012410");
    if (in_array($ses_fusion_id, $access_ids)) {
        $ret = true;
    } else
        $ret = false;

    return $ret;
}

function get_brand() {
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    if (check_logged_in())
        return $rr["brand"];
}

function get1Darr($arr) {
    $ret = array();
    foreach ($arr as $val) {
        if (is_array($val)) {
            foreach ($val as $val1) {
                $ret[] = $val1;
            }
        } else {
            $ret[] = $val;
        }
    }
    return $ret;
}

function getBrandNameById($id) {
    global $CI;
    $query = $CI->db->query("SELECT name from master_company where id='$id'");
    $res = $query->row_array();
    $name = $res['name'];
    return $name;
}

function is_access_progression_report() {

    $ses_fusion_id = get_user_fusion_id();
    $access_ids = "##FKOL005837#FKOL010158#FKOL006175#FKOL011477#FKOL000003#";

    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;

    if (get_dept_folder() == "wfm" || get_global_access() == '1')
        $ret = true;

    return $ret;
}

function convertNumberToWord(float $number) {
    $no = floor($number);
    $decimal = round($number - $no, 2) * 100;
    $decimal_part = $decimal;
    $hundred = null;
    $hundreds = null;
    $digits_length = strlen($no);
    $decimal_length = strlen($decimal);
    $i = 0;
    $str = array();
    $str2 = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');

    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            //$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else
            $str[] = null;
    }

    $d = 0;
    while ($d < $decimal_length) {
        $divider = ($d == 2) ? 10 : 100;
        $decimal_number = floor($decimal % $divider);
        $decimal = floor($decimal / $divider);
        $d += $divider == 10 ? 1 : 2;
        if ($decimal_number) {
            //$plurals = (($counter = count($str2)) && $decimal_number > 9) ? 's' : null;
            $plurals = (($counter = count($str2)) && $decimal_number > 9) ? '' : null;
            $hundreds = ($counter == 1 && $str2[0]) ? ' and ' : null;
            @$str2 [] = ($decimal_number < 21) ? $words[$decimal_number] . ' ' . $digits[$decimal_number] . $plural . ' ' . $hundred : $words[floor($decimal_number / 10) * 10] . ' ' . $words[$decimal_number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else
            $str2[] = null;
    }

    $Rupees = implode('', array_reverse($str));
    $paise = implode('', array_reverse($str2));
    $paise = ($decimal_part > 0) ? ' and ' . $paise . ' Paise' : '';
    return ($Rupees ? $Rupees . ' ' : '') . $paise;
}

function check_user_is_hod() {
    global $CI;
    $current_user = get_user_id();
    //Role folder = admin, super AND department = IT
    $query = $CI->db->query("SELECT s.id FROM signin s INNER JOIN role r ON r.id=s.role_id WHERE r.folder in('admin', 'super') AND s.dept_id='2' AND s.id='" . $current_user . "'");
    if ($query->num_rows() > 0)
        $check_hod = true;
    else
        $check_hod = false;


    return $check_hod;
}

function show_brand_logo($brand) {
    //global $CI;

    if ($brand != '3') {

        $path = 'assets/images/fusion-bpo.png';
    } else {
        $path = 'assets/images/omind_logo.jpg';
    }


    return $path;
}

function is_ppbl_check() {

    //print_r('test');
    //die;
    global $CI;
    $rr = $CI->session->userdata('logged_in');
    $user_id = $rr["id"];

    $url = current_url();

    $parts = $CI->uri->segment(1);

    // echo $url;
    // echo $parts;
    // echo 'abc';
    // die;
    $client_id_static = '222';
    $process_id_static = '445';
    //$ipaddress = $this->get_client_ip();  
    //$ipaddress ='182.71.32.138';
    $ppbl_details_check = $CI->db->query("SELECT * FROM `info_assign_process` WHERE `user_id` = '$user_id' and process_id='$process_id_static' and user_id in (select user_id from info_assign_client where client_id ='$client_id_static')")->num_rows();

    if ($ppbl_details_check > 0) {
        return true;
    } else
        return false;
}

function get_client_name_by_user_id($user_id) {
    global $CI;
    $client = "";
    $sql1 = "SELECT shname from client where id in(select client_id from info_assign_client where user_id='$user_id')";
    $query = $CI->db->query($sql1);
    $row1 = $query->result_array();
    foreach ($row1 as $key => $rw) {
        if ($client == '')
            $client = $rw['shname'];
        else
            $client = $client . ',' . $rw['shname'];
    }
    return $client;
}

function get_process_name_by_user_id($user_id) {
    global $CI;
    $process = "";
    $sql1 = "SELECT name from process where id in(select process_id from info_assign_process where user_id='$user_id')";
    $query = $CI->db->query($sql1);
    $row1 = $query->result_array();
    foreach ($row1 as $key => $rw) {
        if ($process == '')
            $process = $rw['name'];
        else
            $process = $process . ',' . $rw['name'];
    }
    return $process;
}

function payslip_upload_permission() { 
    $ret = false;
    $ses_fusion_id = get_user_fusion_id();
    $access_ids = array("FKOL012410", "FHWH009168"); 

    if (in_array($ses_fusion_id, $access_ids)) {
        $ret = true;
    } else {
        $ret = false;
    }

    return $ret;

}

function it_assets_access()
{
    /*Read Only Access
    ------------
    Darwin Aloot - FMON003209
    Sukhdeep Mangat - FCHA002096
    Endrit Golemi - FALB000003
    Joel Jacobs - FUTA890003
    ARO - FBLR000017
    Rajesh Grover - FCHA013994
    Rahul Saran - FKOL008224
    Full Access
    ------------
    Vinod Pol - FKOL011751
    Harsh Kedia - FKOL001917
    Bablu Biswas - FKOL001919
    Hriday Debnath(DEV) - FKOL011103
    Sankha Chowdhury(DEV) - FKOL008610 */

    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    if (get_global_access()==1) $ret = true;

    $access_ids = array("FMON003209", "FCHA002096", "FALB000003", "FUTA890003", "FBLR000017", "FCHA013994", "FKOL008224", "FKOL011751", "FKOL001917", "FKOL001919", "FKOL011103", "FKOL008610", "FCHA005904", "FCEB000294");

    if(in_array($ses_fusion_id, $access_ids)) $ret = true;

    return $ret;
}
function it_assets_full_access()
{
    /*Full Access
    ------------
    Vinod Pol - FKOL011751
    Harsh Kedia - FKOL001917
    Bablu Biswas - FKOL001919
    Hriday Debnath(DEV) - FKOL011103
    Sankha Chowdhury(DEV) - FKOL008610 */

    $ret = false;
    $ses_fusion_id = get_user_fusion_id();

    if (get_global_access()==1) $ret = true;

    $access_ids = array("FKOL011751", "FKOL001917", "FKOL001919", "FKOL011103", "FKOL008610", "FCHA005904", "FCEB000294");
    if(in_array($ses_fusion_id, $access_ids)) $ret = true;

    return $ret;
}
function it_assets_office_email_ids($user_id=null)
{
    global $CI;

    $data_arr = array();

    if($user_id!=null){
        $sql1 = "SELECT office_id, brand from signin where id='$user_id'";
        $query = $CI->db->query($sql1);
        if ($query->num_rows() > 0) {
            $row1 = $query->result_array();
            $location = $row1[0]['office_id'];

            if ($row1[0]['brand']==3) $location = 'omind_brand';
        }
    }
    else {
        $location = get_user_office_id();
    }

        switch($location)
        {
            case "MAN":
                $data_arr["to"] = "it.manila@fusionbposervices.com,hr.manila@fusionbposervices.com,PhilsEmployee.Connect@fusionbposervices.com";
                $data_arr["cc"] = "rocurement@fusionbposervices.com,darwin.aloot@fusionbposervices.com";
                break;

            case "LEZ":
                $data_arr["to"] = "aaroncboomsourcing@gmail.com,justineboomsourcing@gmail.com,jeboomsourcing@gmail.com,jonasboomsourcing@gmail.com";
                $data_arr["cc"] = "rocurement@fusionbposervices.com,darwin.aloot@fusionbposervices.com";
                break;

            case "SLG":
                $data_arr["to"] = "jraquid@teleservasia.com,shlegaspi@teleservasia.com";
                $data_arr["cc"] = "rocurement@fusionbposervices.com,darwin.aloot@fusionbposervices.com";
                break;

            case 'CEB':
                $data_arr["to"] = "it.cebu@fusionbposervices.com,hr.cebu@fusionbposervices.com,PhilsEmployee.Connect@fusionbposervices.com";
                $data_arr["cc"] = "rocurement@fusionbposervices.com,darwin.aloot@fusionbposervices.com";
                break;

            case 'KOL':
                $data_arr["to"] = "it.kolkata@fusionbposervices.com,subhangi.ghosh@fusionbposervices.com,Farhaan.John@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;

            case 'HWH':
                $data_arr["to"] = "it.howrah@fusionbposervices.com,debojyoti.dutta@fusionbposervices.com,sweta.dalui@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;

            case 'MUM':
                $data_arr["to"] = "it.mumbai@fusionbposervices.com,Farhaan.John@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;

            case 'KOC':
                $data_arr["to"] = "it.kochi@fusionbposervices.com,y.vivekananda@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;

            case 'CHE':
                $data_arr["to"] = "it.chennai@fusionbposervices.com,y.vivekananda@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;

            case 'CHA':
                $data_arr["to"] = "it.itc1mohali@fusionbposervices.com,it.c157mohali@fusionbposervices.com,samardeep.kaur@fusionbposervices.com,kamaldeep.singh@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;

            case 'NOI':
                $data_arr["to"] = "it.noida@fusionbposervices.com,radhika.sharma@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;

            case 'KLY':
                $data_arr["to"] = "it.kalyani@fusionbposervices.com,Kalyani.HRsupport@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;

            case 'DUR':
                $data_arr["to"] = "it.durgapur@fusionbposervices.com,mrinal.kantighosh@fusionbposervices.com,Phul.Das@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;

            case 'JMP':
                $data_arr["to"] = "it.jamshedpur@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;

            case 'ALB':
                $data_arr["to"] = "it.albania@fusionbposervices.com,Albania.hiring@fusionbposervices.com,assia.idrissi@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,endrit.golemi@fusionbposervices.com";
                break;

            case 'KOS':
                $data_arr["to"] = "it.albania@fusionbposervices.com,Kosovo.hiring@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,endrit.golemi@fusionbposervices.com";
                break;

            case 'CAS':
                $data_arr["to"] = "it.morocco@fusionbposervices.com,lamia.chentih@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,ezzirani.abdeltif@fusionbposervices.com";
                break;

            case 'JAM':
                $data_arr["to"] = "it.jamaica@fusionbposervices.com,jamhr@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,joel.jacobs@fusionbposervices.com";
                break;

            case 'ELS':
                $data_arr["to"] = "it.elsalvador@fusionbposervices.com,hr.esal@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,joel.jacobs@fusionbposervices.com";
                break;

            case 'HIG':
                $data_arr["to"] = "it.higbee@fusionbposervices.com,jeanie.vazquez@fusionbposervices.com,raymond.moreno@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,joel.jacobs@fusionbposervices.com";
                break;

            case 'SPI':
                $data_arr["to"] = "it.spindale@fusionbposervices.com,jeanie.vazquez@fusionbposervices.com,raymond.moreno@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,joel.jacobs@fusionbposervices.com";
                break;

            case 'ALT':
                $data_arr["to"] = "it.atlanta@fusionbposervices.com,jeanie.vazquez@fusionbposervices.com,raymond.moreno@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,joel.jacobs@fusionbposervices.com";
                break;

            case 'COL':
                $data_arr["to"] = "it.colombia@fusionbposervices.com,hr.col@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,joel.jacobs@fusionbposervices.com";
                break;

            case 'MON':
                $data_arr["to"] = "it.montreal@fusionbposervices.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,joel.jacobs@fusionbposervices.com";
                break;

            case 'CAM':
                $data_arr["to"] = "jeanie.vazquez@fusionbposervices.com,raymond.moreno@fusionbposervices.com";
                $data_arr["cc"] = "";
                break;

            case 'FLO':
                $data_arr["to"] = "jeanie.vazquez@fusionbposervices.com,raymond.moreno@fusionbposervices.com";
                $data_arr["cc"] = "";
                break;

            case 'UTA':
                $data_arr["to"] = "jeanie.vazquez@fusionbposervices.com,raymond.moreno@fusionbposervices.com";
                $data_arr["cc"] = "";
                break;

            case 'omind_brand':
                $data_arr["to"] = "it.kolkata@fusionbposervices.com,OmindHR@omindtech.com";
                $data_arr["cc"] = "Procurement@fusionbposervices.com,sukhdeep.mangat@fusionbposervices.com";
                break;
            
            default:
                $data_arr["to"] = "Procurement@fusionbposervices.com";
                $data_arr["cc"] = "";
        }
    return $data_arr;
}

function id_restrict() {
	$ret = false;
	$ses_fusion_id = get_user_fusion_id();   
	$access_ids = array("FKOL015294");


	if (in_array($ses_fusion_id, $access_ids)) {
		$ret = true;
	}
	else{
		$ret = false;
	}

	return $ret;
}

function create_phase_history($user_id,$oldPhase,$newPhase,$changeDate,$remarks){
	
    global $CI;
    $current_user = get_user_id();
	$log = get_logs();
	
	$CI->db->query("Update phase_history set end_date='$changeDate' where user_id='$user_id' and phase_type='$oldPhase'");
	
	$phaseArr = array(
		"user_id" => $user_id,
		"phase_type" => $newPhase,
		"start_date" => $changeDate,
		"remarks" => $remarks,
		"event_by" => $current_user,
		"log" => $log
	);

	$rowid = data_inserter('phase_history', $phaseArr);
	
	return $rowid;
						
}

function is_access_ld_program() {

    $ses_fusion_id = get_user_fusion_id();

    $access_ids = " #FCEB004126#";
    $ret = false;
    if (strpos($access_ids, "#" . $ses_fusion_id . "#") == false)
        $ret = false;
    else
        $ret = true;
    if (get_global_access() == '1')
        $ret = true;
    return $ret;
}

function get_wfo_wfh($office_id,$log_ip,$flogin_time,$flogin_time_local) {
    global $CI;
    $user_ip = "";
    $wfo_wfh = '';

    $logInTime = '';
    if($flogin_time != ''){
        $logInTime = $flogin_time;
    }else{
        $logInTime = $flogin_time_local;
    }


    if(!empty($log_ip)){                
        preg_match('~RemoteIP:(.*?),~', $log_ip, $output);        

        $sql1 = "SELECT abbr, office_ip, vpn_ip from office_location where abbr='$office_id'";        
        $query = $CI->db->query($sql1);
        
        if ($query->num_rows() > 0) {
            $row1 = $query->row_array();
            $office_ip = $row1['office_ip'];  

            if($office_ip != ''){
                $office_ip_arr = explode(',', $office_ip);

                if(in_array(trim($output[1]),$office_ip_arr)){
                    $wfo_wfh = 'WFO';
                }else{
                    $wfo_wfh = 'WFH';
                }

            }elseif($vpn_ip != ''){
                $vpn_ip_arr = explode(',', $office_ip);

                if(in_array(trim($output[1]),$vpn_ip_arr)){
                    $wfo_wfh = 'WFH';
                }  

            }else{

                if($logInTime != ''){
                   $wfo_wfh = "N/A"; 
                }else{
                   $wfo_wfh = "-"; 
                }
            } 
        }

    }else{

        if($logInTime != ''){
           $wfo_wfh = "N/A"; 
        }else{
           $wfo_wfh = "-"; 
        }
        
    }
    return $wfo_wfh;    
}



?>
