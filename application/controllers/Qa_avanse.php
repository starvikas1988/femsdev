<?php

class Qa_avanse extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Common_model');
    }

    public function createPath($path){
        if (!empty($path)) {
            if(!file_exists($path)){
                $mainPath="./";
                $checkPath=str_replace($mainPath,'', $path);
                $checkPath=explode("/",$checkPath);
                $cnt=count($checkPath);
                for($i=0;$i<$cnt;$i++){

                    $mainPath.=$checkPath[$i].'/';
                    if (!file_exists($mainPath)) {
                        $oldmask = umask(0);
                        $mkdir=mkdir($mainPath, 0777);
                        umask($oldmask);

                        if ($mkdir) {
                            return true;
                        }else{
                            return false;
                        }
                    }
                }
            }else{
                return true;
            }
        }
    }
    
    
    private function audio_upload_files($files,$path)
    {
        $result=$this->createPath($path);
        if($result){
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
            $config['max_size'] = '2024000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $images = array();
            foreach ($files['name'] as $key => $image) {           
                $_FILES['uFiles']['name']= $files['name'][$key];
                $_FILES['uFiles']['type']= $files['type'][$key];
                $_FILES['uFiles']['tmp_name']= $files['tmp_name'][$key];
                $_FILES['uFiles']['error']= $files['error'][$key];
                $_FILES['uFiles']['size']= $files['size'][$key];

                if ($this->upload->do_upload('uFiles')) {
                    $info = $this->upload->data();
                    $ext = $info['file_ext'];
                    $file_path = $info['file_path'];
                    $full_path = $info['full_path'];
                    $file_name = $info['file_name'];
                    if(strtolower($ext)== '.wav'){
                        
                        $file_name = str_replace(".","_",$file_name).".mp3";
                        $new_path = $file_path.$file_name;
                        $comdFile=FCPATH."assets/script/wavtomp3.sh '$full_path' '$new_path'";
                        $output = shell_exec( $comdFile);
                        sleep(2);
                    }
                    
                    $images[] = $file_name;
                    
                    
                } else {
                    return false;
                }
            }
            return $images;
        }
    }

    public function index()
    {
        if (check_logged_in())
        {
            $current_user = get_user_id();
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_avanse/qa_avanse.php";
            $data["content_js"] = "qa_mba_voice_js.php";

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,695) and status=1  order by name";
            $data["agentName"] = $this->Common_model->get_query_result_array($qSql);

            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');
            $agent_id = $this->input->get('agent_id');
            $cond = "";

            if ($from_date == "")
            {
                $from_date = CurrDate();
            }
            else
            {
                $from_date = mmddyy2mysql($from_date);
            }

            if ($to_date == "")
            {
                $to_date = CurrDate();
            }
            else
            {
                $to_date = mmddyy2mysql($to_date);
            }

            if ($from_date != "" && $to_date !== "") $cond = " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
            if ($agent_id != "") $cond .= " and agent_id='$agent_id'";

            if (get_role_dir() == 'manager' && get_dept_folder() == 'operations')
            {
                $ops_cond = " Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            }
            else if (get_role_dir() == 'tl' && get_dept_folder() == 'operations')
            {
                $ops_cond = " Where assigned_to='$current_user'";
            }
            else
            {
                $ops_cond = "";
            }

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avanse_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
            $data["auditData"] = $this->Common_model->get_query_result_array($qSql);

            $data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
            $data["agent_id"] = $agent_id;

            $this->load->view("dashboard", $data);
        }
    }

    public function add_edit_avanse($avanse_id)
    {
        if (check_logged_in())
        {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_avanse/add_edit_avanse.php";
            $data["content_js"] = "qa_mba_voice_js.php";
            $data['avanse_id'] = $avanse_id;

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,695) and status=1  order by name";
            $data["agentName"] = $this->Common_model->get_query_result_array($qSql);

            $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
            $data['tlname'] = $this->Common_model->get_query_result_array($qSql);

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_avanse_feedback where id='$avanse_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data["auditData"] = $this->Common_model->get_query_row_array($qSql);

            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty($_POST['data']['agent_id']) ? $_POST['data']['agent_id'] : "";

            if ($field_array['agent_id'])
            {

                if ($avanse_id == 0)
                {

                    $field_array = $this->input->post('data');
                    $field_array['audit_date'] = CurrDate();
                   // $field_array['entry_date'] = $curDateTime;
                    $field_array['call_date'] = mmddyy2mysql($this->input->post('call_date'));
                   // $field_array['audit_start_time'] = $this->input->post('audit_start_time');
                    $field_array['entry_date'] = getEstToLocalCurrUser($curDateTime);
                    $field_array['audit_start_time'] = getEstToLocalCurrUser($this->input->post( 'audit_start_time' ));

                    if (get_login_type() == "client")
                    {
                        $field_array['client_entryby'] = $current_user;
                    }
                    else
                    {
                        $field_array['entry_by'] = $current_user;
                    }

                    $a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_avanse/');
                    $field_array["attach_file"] = implode(',',$a);

                    $rowid = data_inserter('qa_avanse_feedback', $field_array);

                    /**Client & Process Table Update */

                    $clientSql = "Select * from client where id=324";
                    $clientData = $this->Common_model->get_query_row_array($clientSql);
                    if ($clientData['qa_report_url'] == "")
                    {
                        $this->db->query("UPDATE client SET qa_report_url='qa_avanse_report' WHERE id=324");
                    }

                    $processSql = "Select * from process where id=695";
                    $processData = $this->Common_model->get_query_row_array($processSql);
                    if ($processData['qa_agent_url'] == "")
                    {
                        $this->db->query("UPDATE process SET qa_url='qa_avanse', qa_agent_url='qa_avanse/agent_avanse_feedback' WHERE id=695");
                    }

                }
                else
                {

                    $edit_array = $this->input->post('data');

                    if (get_login_type() == "client")
                    {

                        $edit_array["client_rvw_by"] = $current_user;
                        $edit_array["client_rvw_note"] = $this->input->post('note');
                        $edit_array["client_rvw_date"] = $curDateTime;
                    }
                    else
                    {

                        $edit_array["mgnt_rvw_by"] = $current_user;
                        $edit_array["mgnt_rvw_note"] = $this->input->post('note');
                        $edit_array["mgnt_rvw_date"] = $curDateTime;
                    }
                    $this->db->where('id', $avanse_id);
                    $this->db->update('qa_avanse_feedback', $edit_array);

                }
                redirect('qa_avanse');
            }
            $data["array"] = $a;
            $this->load->view("dashboard", $data);
        }
    }

    /**Agent part */
    public function agent_avanse_feedback()
    {
        if (check_logged_in())
        {
            $role_id = get_role_id();
            $current_user = get_user_id();
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_avanse/agent_avanse_feedback.php";
            $data["content_js"] = "qa_mba_voice_js.php";
            $data["agentUrl"] = "Qa_avanse/agent_avanse_feedback";

            $qSql = "Select count(id) as value from qa_avanse_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
            $data["tot_feedback"] = $this->Common_model->get_single_value($qSql);

            $qSql = "Select count(id) as value from qa_avanse_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
            $data["yet_rvw"] = $this->Common_model->get_single_value($qSql);

            $from_date = '';
            $to_date = '';
            $cond = "";

            if ($this->input->get('btnView') == 'View')
            {

                $from_date = mmddyy2mysql($this->input->get('from_date'));
                $to_date = mmddyy2mysql($this->input->get('to_date'));

                if ($from_date != "" && $to_date !== "") $cond = " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' ";

                $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avanse_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
                $data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

            }
            else
            {

                $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avanse_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
                $data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

            }

            $data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
            $this->load->view('dashboard', $data);
        }
    }

    public function agent_avanse_rvw($id)
    {
        if (check_logged_in())
        {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_avanse/agent_avanse_rvw.php";
            $data["content_js"] = "qa_mba_voice_js.php";
            $data["agentUrl"] = "qa_avanse/agent_avanse_feedback";

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avanse_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data["auditData"] = $this->Common_model->get_query_row_array($qSql);

            $data["avanse_id"] = $id;

            if ($this->input->post('avanse_id'))
            {
                $pnid = $this->input->post('avanse_id');
                $curDateTime = CurrMySqlDate();
                $log = get_logs();

                $field_array1 = array(
                    "agnt_fd_acpt" => $this->input->post('agnt_fd_acpt') ,
                    "agent_rvw_note" => $this->input->post('note') ,
                    "agent_rvw_date" => $curDateTime
                );
                $this->db->where('id', $pnid);
                $this->db->update('qa_avanse_feedback', $field_array1);

                redirect('qa_avanse/agent_avanse_feedback');

            }
            else
            {
                $this->load->view('dashboard', $data);
            }
        }
    }

    /**Report Part */
    public function qa_avanse_report()
    {
        if (check_logged_in())
        {
            $user_office_id = get_user_office_id();
            $current_user = get_user_id();
            $is_global_access = get_global_access();
            $role_dir = get_role_dir();
            $data["show_download"] = false;
            $data["download_link"] = "";
            $data["show_table"] = false;
            $data["show_table"] = false;
            $data["aside_template"] = "reports_qa/aside.php";
            $data["content_template"] = "qa_avanse/qa_avanse_report.php";
            $data["content_js"] = "qa_mba_voice_js.php";

            $data['location_list'] = $this->Common_model->get_office_location_list();

            $office_id = "";
            $date_from = "";
            $date_to = "";
            $audit_type = "";
            $action = "";
            $dn_link = "";
            $cond = "";
            $cond1 = "";
            $user = "";

            $data["avanse_audit_list"] = array();

            if ($this->input->get('show') == 'Show')
            {
                $date_from = mmddyy2mysql($this->input->get('date_from'));
                $date_to = mmddyy2mysql($this->input->get('date_to'));
                $office_id = $this->input->get('office_id');
                $audit_type = $this->input->get('audit_type');

                if ($date_from != "" && $date_to !== "") $cond = " Where (audit_date >= '$date_from' and audit_date <= '$date_to' )";

                if ($office_id == "All") $cond .= "";
                else $cond .= " and office_id='$office_id'";

                if ($audit_type == "All")
                {
                    if (get_login_type() == "client")
                    {
                        $cond .= "audit_type not in ('Operation Audit','Trainer Audit')";
                        
                    }
                    else
                    {
                        $cond .= "";
                    }
                }
                else
                {
                    $cond .=" and audit_type='$audit_type'";
                    
                }

                if (get_role_dir() == 'manager' && get_dept_folder() == 'operations')
                {
                    $cond1 .= " And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
                }
                else if ((get_role_dir() == 'tl' && get_user_fusion_id() != 'FMAN000616') && get_dept_folder() == 'operations')
                {
                    $cond1 .= " And assigned_to='$current_user'";
                }
                else
                {
                    $cond1 .= "";
                }

                if (get_role_dir() == 'agent')
                {
                    $user .= "where id ='$current_user'";
                }

                $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_avanse_feedback) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

                $fullAray = $this->Common_model->get_query_result_array($qSql);
                $data["avanse_audit_list"] = $fullAray;
                $this->create_qa_avanse_CSV($fullAray);
                $dn_link = base_url() . "qa_avanse/download_qa_avanse_CSV/";
            }

            $data['download_link'] = $dn_link;
            $data["action"] = $action;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['office_id'] = $office_id;
            $data['audit_type'] = $audit_type;
            $this->load->view('dashboard', $data);
        }
    }

    public function download_qa_avanse_CSV()
    {
        $currDate = date("Y-m-d");
        $filename = "./assets/reports/Report" . get_user_id() . ".csv";
        $newfile = "QA Avanse Audit List-'" . $currDate . "'.csv";
        header('Content-Disposition: attachment;  filename="' . $newfile . '"');
        readfile($filename);
    }

    public function create_qa_avanse_CSV($rr)
    {
        $currDate = date("Y-m-d");
        $filename = "./assets/reports/Report" . get_user_id() . ".csv";
        $fopen = fopen($filename, "w+");

        $header = array(
            "Auditor Name",
            "Audit Date",
            "Agent",
            "Fusion ID",
            "L1 Super",
			"Campaign","Product Name","Customer VOC","Phone Number","Agent Disposition","QA Disposition",
            "Audit Type",
            "VOC","Audit Start Date Time", "Audit End Date Time",
            "Call Date",
            "Earned Score",
            "Possible Score",
            "Overall Score",
            "Call Opening",
            "Call Closing",
            "Purpose of the call",
            "Did agent use the FAB approach to sell product ?",
            "Did agent covince the customer appropriately ?",
            "Did agent able to handle customer objection efficiently",
            "Tone & Pace",
            "Dead air & Hold",
            "Complete & Correct Information",
            "Mandatory Information",
            "Tagging & Remarks",
            "Call Disconnection",
            "Call/Query Avoidance",
            "Personal & Confedential Details not to be shared",
            "Remarks 1",
            "Remarks 2",
            "Remarks 3",
            "Remarks 4",
            "Remarks 5",
            "Remarks 6",
            "Remarks 7",
            "Remarks 8",
            "Remarks 9",
            "Remarks 10",
            "Remarks 11",
            "Remarks 12",
            "Remarks 13",
            "Remarks 14",
            "Call Summary",
            "Feedback",
            "Agent Feedback Acceptance",
            "Agent Review Date",
            "Agent Comment",
            "Mgnt Review Date",
            "Mgnt Review By",
            "Mgnt Comment"
        );

        $row = "";
        foreach ($header as $data) $row .= '' . $data . ',';
        fwrite($fopen, rtrim($row, ",") . "\r\n");
        $searches = array(
            "\r",
            "\n",
            "\r\n"
        );

        foreach ($rr as $user)
        {
            if ($user['entry_by'] != '')
            {
                $auditorName = $user['auditor_name'];
            }
            else
            {
                $auditorName = $user['client_name'];
            }

            if ($user['audit_start_time'] == "" || $user['audit_start_time'] == '0000-00-00 00:00:00')
            {
                $interval1 = '---';
            }
            else
            {
                $interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
            }

            $row = '"' . $auditorName . '",';
            $row .= '"' . ConvServerToLocal($user['audit_date']) . '",';
            $row .= '"' . $user['fname'] . " " . $user['lname'] . '",';
            $row .= '"' . $user['fusion_id'] . '",';
            $row .= '"' . $user['tl_name'] . '",';
            $row .= '"' . $user['campaign'] . '",';
            $row .= '"' . $user['product'] . '",';
            $row .= '"' . $user['customer_voc'] . '",';
            $row .= '"' . $user['phone'] . '",';
            $row .= '"' . $user['agent_disposition'] . '",';
            $row .= '"' . $user['qa_disposition'] . '",';
            $row .= '"'.$user['audit_type'].'",';
            $row .= '"'.$user['voc'].'",';
            $row .= '"'.ConvServerToLocal($user['audit_start_time']).'",';
            $row .= '"'.ConvServerToLocal($user['entry_date']).'",';
            $row .= '"' .ConvServerToLocal($user['call_date']) . '",';
            $row .= '"' . $user['earned_score'] . '",';
            $row .= '"' . $user['possible_score'] . '",';
            $row .= '"' . $user['overall_score'] . '",';
            $row .= '"' . $user['call_opening'] . '",';
            $row .= '"' . $user['call_closing'] . '",';
            $row .= '"' . $user['call_purpose'] . '",';
            $row .= '"' . $user['did_agent_use_fab'] . '",';
            $row .= '"' . $user['did_agent_covince'] . '",';
            $row .= '"' . $user['customer_objection_handle'] . '",';
            $row .= '"' . $user['tone_pace'] . '",';
            $row .= '"' . $user['dead_air_hold'] . '",';
            $row .= '"' . $user['complete_correct_information'] . '",';
            $row .= '"' . $user['mandatory_information'] . '",';
            $row .= '"' . $user['tagging_remarks'] . '",';
            $row .= '"' . $user['call_disconnection'] . '",';
            $row .= '"' . $user['call_avoidance'] . '",';
            $row .= '"' . $user['details_shared'] . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt1'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt2'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt3'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt4'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt5'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt6'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt7'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt8'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt9'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt10'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt11'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt12'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt13'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['cmt14'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['call_summary'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['feedback'])) . '",';
            $row .= '"' . $user['agnt_fd_acpt'] . '",';
            $row .= '"' . $user['agent_rvw_date'] . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['agent_rvw_note'])) . '",';
            $row .= '"' . $user['mgnt_rvw_date'] . '",';
            $row .= '"' . $user['mgnt_rvw_name'] . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['mgnt_rvw_note'])) . '"';

            fwrite($fopen, $row . "\r\n");
        }
        fclose($fopen);

    }

}

