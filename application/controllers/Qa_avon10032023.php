<?php
class Qa_avon extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model( 'user_model' );
        $this->load->model( 'Common_model' );
    }

    public function index() {
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $data['aside_template'] = 'qa/aside.php';
            $data['content_template'] = 'qa_avon/qa_avon_feedback.php';
            $data['content_js'] = 'qa_avon_js.php';
            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,162) and is_assign_process(id,348) and status=1 order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $from_date = $this->input->get( 'from_date' );
            $to_date = $this->input->get( 'to_date' );
            $agent_id = $this->input->get( 'agent_id' );
            $lob = $this->input->get( 'lob' );
            $cond = '';
            $ops_cond = '';

            if ( $from_date == '' ) {
                $from_date = CurrDate();
            } else {
                $from_date = mmddyy2mysql( $from_date );
            }

            if ( $to_date == '' ) {
                $to_date = CurrDate();
            } else {
                $to_date = mmddyy2mysql( $to_date );
            }

            if ( $from_date != '' && $to_date !== '' )  $cond = " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
            if ( $agent_id != '' )	$cond .= " and agent_id='$agent_id'";
            if ( $lob != '' )       $cond .= " and lob='$lob'";

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $ops_cond = " Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $ops_cond = " Where assigned_to='$current_user'";
            } else if ( get_login_type() == 'client' ) {
                $ops_cond = " Where audit_type not in ('Operation Audit','Trainer Audit')";
            } else {
                $ops_cond = '';
            }

            //Avon Data
           // if($lob != ''){
                $qSql = "SELECT * from
                (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
                (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
                (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
                (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avon_feedback $cond) xx Left Join
                (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
            $data['avon_details'] = $this->Common_model->get_query_result_array( $qSql );

            //}
            

            //Avon Inbound Data
    //         $qSql = "SELECT * from
				// (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				// (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				// (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				// (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avon_inbound_feedback $cond) xx Left Join
				// (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
    //         $data['avon_inbound'] = $this->Common_model->get_query_result_array( $qSql );

            //Avon Outbound Data
    //         $qSql_outbound = "SELECT * from
				// (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				// (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				// (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				// (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avon_outbound_feedback $cond) xx Left Join
				// (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
    //         $data['avon_outbound'] = $this->Common_model->get_query_result_array( $qSql_outbound );

            //Avon SMS Data
    //         $qSql_outbound = "SELECT * from
				// (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				// (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				// (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				// (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avon_sms_feedback $cond) xx Left Join
				// (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
    //         $data['avon_sms'] = $this->Common_model->get_query_result_array( $qSql_outbound );

            //Avon Ticket Data
    //         $qSql_outbound = "SELECT * from
				// (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				// (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				// (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				// (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avon_ticket_feedback $cond) xx Left Join
				// (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
    //         $data['avon_ticket'] = $this->Common_model->get_query_result_array( $qSql_outbound );

            //Avon Email Data
    //         $qSql_outbound = "SELECT * from
				// (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				// (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				// (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				// (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avon_email_feedback $cond) xx Left Join
				// (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
    //         $data['avon_email'] = $this->Common_model->get_query_result_array( $qSql_outbound );

    //         $qSql_outbound = "SELECT * from
				// (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				// (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				// (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				// (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avon_scorecard_feedback $cond) xx Left Join
				// (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
    //         $data['avon_scorecard'] = $this->Common_model->get_query_result_array( $qSql_outbound );

            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['agent_id'] = $agent_id;
            $data['lob'] = $lob;

            $this->load->view( 'dashboard', $data );
        }
    }

    //add_edit_avon Function
    public function add_edit_avon( $avon_id ) {
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data['content_template'] = 'qa_avon/add_edit_avon.php';
            $data['content_js'] = 'qa_avon_js.php';
            $data['avon_id'] = $avon_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,162) and is_assign_process(id,348) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            $data['tlname'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * from
                (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
                (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
                (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
                (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
                from qa_avon_feedback where id='$avon_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['avon_data'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $avon_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_avon")){
                        mkdir("./qa_files/qa_avon");
                    }
                    $a = $this->avon_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_avon/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_avon_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_avon_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_feedback', $edit_array );

                }
                redirect( 'qa_avon' );
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }

    //add_edit_avon_inbound Function
    public function add_edit_avon_inbound( $avon_id ) {
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data['content_template'] = 'qa_avon/add_edit_avon_inbound.php';
            $data['content_js'] = 'qa_avon_js.php';
            $data['avon_id'] = $avon_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,162) and is_assign_process(id,348) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            $data['tlname'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_avon_inbound_feedback where id='$avon_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['avon_inbound'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $avon_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_avon_inbound")){
                        mkdir("./qa_files/qa_avon_inbound");
                    }
                    $a = $this->avon_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_avon/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_avon_inbound_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_avon_inbound_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_inbound_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_inbound_feedback', $edit_array );

                }
                redirect( 'qa_avon' );
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }

    //add_edit_avon_outbound Function
    public function add_edit_avon_outbound( $avon_id ) {
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data['content_template'] = 'qa_avon/add_edit_avon_outbound.php';
            $data['content_js'] = 'qa_avon_js.php';
            $data['avon_id'] = $avon_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,162) and is_assign_process(id,348) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            $data['tlname'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_avon_outbound_feedback where id='$avon_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['avon_outbound'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $avon_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_avon_outbound")){
                        mkdir("./qa_files/qa_avon_outbound");
                    }
                    $a = $this->avon_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_avon/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_avon_outbound_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_avon_outbound_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_outbound_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_outbound_feedback', $edit_array );

                }
                redirect( 'qa_avon' );
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }

    //add_edit_avon_sms Function
    public function add_edit_avon_sms( $avon_id ){
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data['content_template'] = 'qa_avon/add_edit_avon_sms.php';
            $data['content_js'] = 'qa_avon_js.php';
            $data['avon_id'] = $avon_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,162) and is_assign_process(id,348) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            $data['tlname'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_avon_sms_feedback where id='$avon_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['avon_sms'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $avon_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_avon_sms")){
                        mkdir("./qa_files/qa_avon_sms");
                    }
                    $a = $this->avon_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_avon/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_avon_sms_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_avon_sms_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_sms_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_sms_feedback', $edit_array );

                }
                redirect( 'qa_avon' );
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }

    //add_edit_avon_ticket Function
    public function add_edit_avon_ticket($avon_id){
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data['content_template'] = 'qa_avon/add_edit_avon_ticket.php';
            $data['content_js'] = 'qa_avon_js.php';
            $data['avon_id'] = $avon_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,162) and is_assign_process(id,348) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            $data['tlname'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_avon_ticket_feedback where id='$avon_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['avon_ticket'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $avon_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_avon_ticket")){
                        mkdir("./qa_files/qa_avon_ticket");
                    }
                    $a = $this->avon_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_avon/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_avon_ticket_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_avon_ticket_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_ticket_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_ticket_feedback', $edit_array );

                }
                redirect( 'qa_avon' );
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }

    //add_edit_avon_email Function
    public function add_edit_avon_email($avon_id){
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data['content_template'] = 'qa_avon/add_edit_avon_email.php';
            $data['content_js'] = 'qa_avon_js.php';
            $data['avon_id'] = $avon_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,162) and is_assign_process(id,348) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            $data['tlname'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_avon_email_feedback where id='$avon_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['avon_email'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $avon_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_avon_email")){
                        mkdir("./qa_files/qa_avon_email");
                    }
                    $a = $this->avon_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_avon/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_avon_email_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_avon_email_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_email_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_email_feedback', $edit_array );

                }
                redirect( 'qa_avon' );
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }


    public function add_edit_avon_scorecard( $avon_id ) {
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data['content_template'] = 'qa_avon/add_edit_avon_scorecard.php';
            $data['content_js'] = 'qa_avon_js.php';
            $data['avon_id'] = $avon_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,162) and is_assign_process(id,348) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            $data['tlname'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_avon_scorecard_feedback where id='$avon_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['avon_scorecard'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $avon_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_avon_screcard")){
                        mkdir("./qa_files/qa_avon_screcard");
                    }
                    $a = $this->avon_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_avon/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_avon_scorecard_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_avon_scorecard_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_scorecard_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_scorecard_feedback', $edit_array );

                }
                redirect( 'qa_avon' );
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }


 	public function add_edit_avon_scorecard_new($avon_id){
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data['content_template'] = 'qa_avon/add_edit_avon_scorecard_new.php';
            $data['content_js'] = 'qa_avon_js.php';
            $data['avon_id'] = $avon_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,162) and is_assign_process(id,348) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            $data['tlname'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_avon_scorecard_feedback where id='$avon_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['avon_scorecard'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $avon_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_avon_email")){
                        mkdir("./qa_files/qa_avon_email");
                    }
                    $a = $this->avon_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_avon/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_avon_scorecard_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_avon_scorecard_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_scorecard_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $avon_id );
                    $this->db->update( 'qa_avon_scorecard_feedback', $edit_array );

                }
                redirect( 'qa_avon' );
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }


    private function avon_upload_files( $files, $path ) {
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
        $config['max_size'] = '2024000';
        $this->load->library( 'upload', $config );
        $this->upload->initialize( $config );
        $images = array();
        foreach ( $files['name'] as $key => $image ) {
            $_FILES['uFiles']['name'] = $files['name'][$key];
            $_FILES['uFiles']['type'] = $files['type'][$key];
            $_FILES['uFiles']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['uFiles']['error'] = $files['error'][$key];
            $_FILES['uFiles']['size'] = $files['size'][$key];

            if ( $this->upload->do_upload( 'uFiles' ) ) {
                $info = $this->upload->data();
                $ext = $info['file_ext'];
                $file_path = $info['file_path'];
                $full_path = $info['full_path'];
                $file_name = $info['file_name'];
                if ( strtolower( $ext ) == '.wav' ) {

                    $file_name = str_replace( '.', '_', $file_name ).'.mp3';
                    $new_path = $file_path.$file_name;
                    $comdFile = FCPATH."assets/script/wavtomp3.sh '$full_path' '$new_path'";
                    $output = shell_exec( $comdFile );
                    sleep( 2 );
                }

                $images[] = $file_name;

            } else {
                return false;
            }
        }
        return $images;
    }

	public function qa_avon_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_avon/qa_avon_report.php";
			$data["content_js"] = "qa_avon_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
            $qSql="";
			
			$data["qa_avon_list"] = array();
			
			if($this->input->get('show')=='Show'){
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');
				$campaign = $this->input->get("campaign");

				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' )";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				if($audit_type=="All"){ 
					if(get_login_type()=="client"){
						$cond .= "audit_type not in ('Operation Audit','Trainer Audit')";
					}else{
						$cond .= "";
					}
				}else{ 
					$cond .=" and audit_type='$audit_type'";
				}

                if($campaign!=''){
                    $cond .=" and lob='$campaign'";
                }
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if((get_role_dir()=='tl' && get_user_fusion_id()!='FMAN000616') && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}
				

                $qSql="SELECT * from
                (Select *, get_user_name(entry_by) as auditor_name, get_user_name(client_entryby) as client_name, get_user_name(tl_id) as tl_name, get_user_name(mgnt_rvw_by) as mgnt_rvw_name,
                (select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_avon_feedback) xx Left Join
                (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on
                (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
                $fullAray = $this->Common_model->get_query_result_array($qSql);
                $data["qa_avon_list"] = $fullAray;
				
                $this->create_qa_avon_CSV($fullAray); 

                // if($campaign=="inbound"){
                //     $this->create_qa_avon_inbound_CSV($fullAray);	
                // }elseif($campaign=="outbound"){
                //     $this->create_qa_avon_outbound_CSV($fullAray);
                // }elseif($campaign=="sms"){
                //     $this->create_qa_avon_sms_CSV($fullAray);
                // }elseif($campaign=="ticket"){
                //     $this->create_qa_avon_ticket_CSV($fullAray);
                // }elseif($campaign=="email"){
                //     $this->create_qa_avon_email_CSV($fullAray);
                // }elseif($campaign=="scorecard"){
                //     $this->create_qa_avon_scorecard_CSV($fullAray);
                // }
                $dn_link = base_url()."qa_avon/download_qa_avon_CSV/$campaign";
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			$this->load->view('dashboard',$data);
		}
	}

    public function create_qa_avon_CSV($rr){
        $currDate=date("Y-m-d");
        $filename = "./assets/reports/Report".get_user_id().".csv";
        $currentURL = base_url();
        $controller = "qa_avon";
        $edit_url = "add_edit_avon";
        $main_url =  $currentURL.''.$controller.'/'.$edit_url;
        $fopen = fopen($filename,"w+");

        $header=array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Supervisor", "Call Date", "Digital/Non Digital", "Week", "Audit Type", "Auditor Type", "VOC","Audit Link",
        "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score","Lob",
        "Used Suggested Opening Spiel", "SLA", "Used Suggested Closing Spiel", "Additional Assistance", "Spiel Adherance", "Did the agent use proper script", "Did the agent acknowledge the issue of the customer?",
        "Did the agent provide empathy statement?(when necessary)",
        "Did the agent provide assurance to help the customer?",
        "Information Shared",
        "Probing question",
        "Failed to Escalate/Call back",
        "Active Listening/Reading",
        "Interruption",
        "Dead Air and Proper Hold Technique",
        "Grammar usage/Technical Writing and Pronunciation/branding",
        "Professionalism (ZTP)",
        "Interact with intention",
        "Strong Ownership",
        "Enthusiasm",
        "Tailored Contact",
        "Avon Security ",
        "Send to the right approver",
        "Efficiency of Action",
        "Documentation",
        "Use proper disposition and tagging",
        "Did the agent resolved the concerns within the interactions?",
        "Did the agent used first response?",
        "Remarks1","Remarks2", "Remarks3", "Remarks4", "Remarks5", "Remarks6", "Remarks7", "Remarks8", "Remarks9", "Remarks10", "Remarks11","Remarks12","Remarks13","Remarks14","Remarks15","Remarks16","Remarks17","Remarks18","Remarks19","Remarks20","Remarks21","Remarks22","Remarks23","Remarks24","Remarks25","Remarks26","Remarks27","Remarks28", "Call Summary", "Feedback", "Agent Feedback Acceptance",
        "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

        $row = "";
        foreach($header as $data) $row .= ''.$data.',';
        fwrite($fopen,rtrim($row,",")."\r\n");
        $searches = array("\r", "\n", "\r\n");

        foreach($rr as $user){
            $auditorName=($user['entry_by']!="")?$user['auditor_name']:$user['client_name'];
            if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
                $interval1 = '---';
            }else{
                $interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
            }
            $main_urls = $main_url.'/'.$user['id'];
            $row = '"'.$auditorName.'",'; 
            $row .= '"'.$user['audit_date'].'",'; 
            $row .= '"'.$user['fname']." ".$user['lname'].'",';
            $row .= '"'.$user['fusion_id'].'",';
            $row .= '"'.$user['tl_name'].'",';
            $row .= '"'.$user['call_date'].'",';
            $row .= '"'.$user['digital_non_digital'].'",';
            $row .= '"'.$user['week'].'",';
            $row .= '"'.$user['audit_type'].'",';
            $row .= '"'.$user['auditor_type'].'",';
            $row .= '"'.$user['voc'].'",';
            $row .= '"'.$main_urls.'",';
            $row .= '"'.$user['audit_start_time'].'",';
            $row .= '"'.$user['entry_date'].'",';
            $row .= '"'.$interval1.'",';
            $row .= '"'.$user['earned_score'].'",';
            $row .= '"'.$user['possible_score'].'",';
            $row .= '"'.$user['overall_score'].'%'.'",';
            $row .= '"'.$user['lob'].'",';
            $row .= '"'.$user['suggested_opening_spiel'].'",';
            $row .= '"'.$user['sla'].'",';
            $row .= '"'.$user['suggested_closing_spiel'].'",';
            $row .= '"'.$user['additional_assistance'].'",';
            $row .= '"'.$user['spiel_adherance'].'",';
            $row .= '"'.$user['use_proper_script'].'",';
            $row .= '"'.$user['acknowledge_issue'].'",';
            $row .= '"'.$user['empathy_statement'].'",';
            $row .= '"'.$user['provide_assurance'].'",';
            $row .= '"'.$user['information_shared'].'",';
            $row .= '"'.$user['probing_question'].'",';
            $row .= '"'.$user['call_back'].'",';
            $row .= '"'.$user['active_listening'].'",';
            $row .= '"'.$user['interruption'].'",';
            $row .= '"'.$user['dead_air'].'",';
            $row .= '"'.$user['grammar_usage'].'",';
            $row .= '"'.$user['professionalism'].'",';
            $row .= '"'.$user['interact_with_intention'].'",';
            $row .= '"'.$user['strong_ownership'].'",';
            $row .= '"'.$user['enthusiasm'].'",';
            $row .= '"'.$user['tailored_contact'].'",';
            $row .= '"'.$user['avon_security'].'",';
            $row .= '"'.$user['send_right_approver'].'",';
            $row .= '"'.$user['efficiency_of_action'].'",';
            $row .= '"'.$user['documentation'].'",';
            $row .= '"'.$user['proper_disposition_tagging'].'",';
            $row .= '"'.$user['resolved_the_concerns'].'",';
            $row .= '"'.$user['first_response'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
            $row .= '"'.$user['agnt_fd_acpt'].'",';
            $row .= '"'.$user['agent_rvw_date'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
            $row .= '"'.$user['mgnt_rvw_date'].'",';
            $row .= '"'.$user['mgnt_rvw_name'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
            $row .= '"'.$user['client_rvw_date'].'",';
            $row .= '"'.$user['client_rvw_name'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';

            fwrite($fopen,$row."\r\n");
        }
        fclose($fopen);
    }

    public function create_qa_avon_ticket_CSV($rr){
        $currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
        $currentURL = base_url();
        $controller = "qa_avon";
        $edit_url = "add_edit_avon_ticket";
        $main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$fopen = fopen($filename,"w+");

        $header=array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Supervisor", "Call Date", "SLA Achieved", "Ticket Type", "Digital/Non Digital", "Week", "Audit Type", "Auditor Type", "VOC","Audit Link",
        "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score", "Identifying Ticket", "SLA Achieved", "Sent to Right Approver", "Followed Request",
        "Efficiency of Action", "Correct Information Shared", "Documentation", "Incomplete Information Shared", "Inaccurate Information Shared", "Correct Tagging", "Avon Security", "Remarks1",
        "Remarks2", "Remarks3", "Remarks4", "Remarks5", "Remarks6", "Remarks7", "Remarks8", "Remarks9", "Remarks10", "Remarks11", "Call Summary", "Feedback", "Agent Feedback Acceptance",
        "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

        $row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

        foreach($rr as $user){
            $auditorName=($user['entry_by']!="")?$user['auditor_name']:$user['client_name'];
            if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
            $main_urls = $main_url.'/'.$user['id'];
            $row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['sla'].'",';
			$row .= '"'.$user['ticket_type'].'",';
            $row .= '"'.$user['digital_non_digital'].'",';
			$row .= '"'.$user['week'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
            $row .= '"'.$main_urls.'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
            $row .= '"'.$user['earned_score'].'",';
            $row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
            $row .= '"'.$user['identifying_ticket'].'",';
            $row .= '"'.$user['sla_achieved'].'",';
            $row .= '"'.$user['sent_right_approver'].'",';
            $row .= '"'.$user['followed_request'].'",';
            $row .= '"'.$user['efficiency_of_action'].'",';
            $row .= '"'.$user['correct_info_shared'].'",';
            $row .= '"'.$user['documentation'].'",';
            $row .= '"'.$user['information_shared_incomplete'].'",';
            $row .= '"'.$user['information_shared_inaccurate'].'",';
            $row .= '"'.$user['correct_tagging'].'",';
            $row .= '"'.$user['avon_security'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';

            fwrite($fopen,$row."\r\n");
        }
        fclose($fopen);
    }

    public function create_qa_avon_email_CSV($rr){
        $currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
        $currentURL = base_url();
        $controller = "qa_avon";
        $edit_url = "add_edit_avon_email";
        $main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$fopen = fopen($filename,"w+");

        $header=array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Supervisor", "Call Date", "SLA Achieved", "Email Type", "Digital/Non Digital", "Week", "Audit Type", "Auditor Type", "VOC","Audit Link",
        "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score", "Standard Greeting", "Composition of Email","Probing Question (If Applicable)",
        "Escalated the Issue (If Applicable)", "Ticket Handling (If Applicable)", "SLA Achieved", "Standard Closing", "Correct Template used (If Applicable)", "Correct Disposition", "Request Documents (If Applicable)",
        "Comprehension", "Avon Security (If Applicable)", "Standard Email Subject Line", "Tagging of Status", "FTR", "Incomplete Information Shared", "Inaccurate Information Shared", "Used Acknowledgement Template",
        "Can the agent easily reply to the sender without using the Acknowledgment Template?",
        "Remarks1", "Remarks2", "Remarks3", "Remarks4", "Remarks5", "Remarks6", "Remarks7", "Remarks8", "Remarks9", "Remarks10", "Remarks11", "Remarks12", "Remarks13", "Remarks14", "Remarks15", "Remarks16", "Remarks17",
        "Remarks18", "Remarks19", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date",
        "Client Review Name", "Client Review Note");

        $row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

        foreach($rr as $user){
            $auditorName=($user['entry_by']!="")?$user['auditor_name']:$user['client_name'];
            if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
            $main_urls = $main_url.'/'.$user['id'];
            $row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['sla'].'",';
			$row .= '"'.$user['email_type'].'",';
            $row .= '"'.$user['digital_non_digital'].'",';
			$row .= '"'.$user['week'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
            $row .= '"'.$main_urls.'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
            $row .= '"'.$user['earned_score'].'",';
            $row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
            $row .= '"'.$user['standard_greeting'].'",';
            $row .= '"'.$user['composition_email'].'",';
            $row .= '"'.$user['probing_question_if_applicable'].'",';
            $row .= '"'.$user['escalated_issue_if_applicable'].'",';
            $row .= '"'.$user['ticket_handling_if_applicable'].'",';
            $row .= '"'.$user['sla_achieved'].'",';
            $row .= '"'.$user['standard_closing'].'",';
            $row .= '"'.$user['correct_template_if_applicable'].'",';
            $row .= '"'.$user['correct_disposition'].'",';
            $row .= '"'.$user['request_documents_if_applicable'].'",';
            $row .= '"'.$user['comprehension'].'",';
            $row .= '"'.$user['avon_security_if_applicable'].'",';
            $row .= '"'.$user['standard_email_sub_line'].'",';
            $row .= '"'.$user['tagging_of_status'].'",';
            $row .= '"'.$user['ftr'].'",';
            $row .= '"'.$user['incomplete_info_shared'].'",';
            $row .= '"'.$user['inaccurate_info_shared'].'",';
            $row .= '"'.$user['use_acknowledge_temp'].'",';
            $row .= '"'.$user['agent_easy_reply_sender'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';

            fwrite($fopen,$row."\r\n");
        }
        fclose($fopen);
    }


    public function create_qa_avon_scorecard_CSV($rr){
        $currDate=date("Y-m-d");
        $filename = "./assets/reports/Report".get_user_id().".csv";
        $currentURL = base_url();
        $controller = "qa_avon";
        $edit_url = "add_edit_avon_scorecard";
        $main_url =  $currentURL.''.$controller.'/'.$edit_url;
        $fopen = fopen($filename,"w+");

        $header=array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Supervisor", "Call Date","AHT", "Digital/Non Digital", "Week", "Audit Type", "Auditor Type", "VOC","Audit Link",
        "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score", "SLA", "Used Suggested Closing Spiel","Additional Assistance",
        "Spiel Adherance", "Did the agent use proper script", "Did the agent acknowledge the issue of the customer?", "Did the agent provide empathy statement?(when necessary)", "Did the agent provide assurance to help the customer?", "Information Shared", "Failed to Escalate/Call back",
        "Active Listening/Reading", "Interruption", "Dead Air and Proper Hold Technique", "Grammar usage and Technical Writing", "Professionalism (ZTP)", "Interact with intention", "Strong Ownership", "Tailored Contact",
        "Tailored Contact2","Enthusiasm","Avon Security","Send to the right approver","Efficiency of Action","Documentation","Use proper disposition and tagging",
        "Remarks1", "Remarks2", "Remarks3", "Remarks4", "Remarks5", "Remarks6", "Remarks7", "Remarks8", "Remarks9", "Remarks10", "Remarks11", "Remarks12", "Remarks13", "Remarks14", "Remarks15", "Remarks16", "Remarks17",
        "Remarks18", "Remarks19","Remarks20","Remarks21","Remarks22","Remarks23","Remarks24","Remarks25", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date",
        "Client Review Name", "Client Review Note");

        $row = "";
        foreach($header as $data) $row .= ''.$data.',';
        fwrite($fopen,rtrim($row,",")."\r\n");
        $searches = array("\r", "\n", "\r\n");

        foreach($rr as $user){
            $auditorName=($user['entry_by']!="")?$user['auditor_name']:$user['client_name'];
            if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
                $interval1 = '---';
            }else{
                $interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
            }
            $main_urls = $main_url.'/'.$user['id'];
            $row = '"'.$auditorName.'",'; 
            $row .= '"'.$user['audit_date'].'",'; 
            $row .= '"'.$user['fname']." ".$user['lname'].'",';
            $row .= '"'.$user['fusion_id'].'",';
            $row .= '"'.$user['tl_name'].'",';
            $row .= '"'.$user['call_date'].'",';
            $row .= '"'.$user['aht'].'",';
            $row .= '"'.$user['digital_non_digital'].'",';
            $row .= '"'.$user['week'].'",';
            $row .= '"'.$user['audit_type'].'",';
            $row .= '"'.$user['auditor_type'].'",';
            $row .= '"'.$user['voc'].'",';
            $row .= '"'.$main_urls.'",';
            $row .= '"'.$user['audit_start_time'].'",';
            $row .= '"'.$user['entry_date'].'",';
            $row .= '"'.$interval1.'",';
            $row .= '"'.$user['earned_score'].'",';
            $row .= '"'.$user['possible_score'].'",';
            $row .= '"'.$user['overall_score'].'%'.'",';
            $row .= '"'.$user['SLA'].'",';
            $row .= '"'.$user['Spiel'].'",';
            $row .= '"'.$user['Assistance'].'",';
            $row .= '"'.$user['Adherance'].'",';
            $row .= '"'.$user['proper_script'].'",';
            $row .= '"'.$user['customer'].'",';
            $row .= '"'.$user['when_necessary'].'",';
            $row .= '"'.$user['provide_assurance'].'",';
            $row .= '"'.$user['Shared'].'",';
            $row .= '"'.$user['Call_back'].'",';
            $row .= '"'.$user['Reading'].'",';
            $row .= '"'.$user['Interruption'].'",';
            $row .= '"'.$user['Technique'].'",';
            $row .= '"'.$user['Writing'].'",';
            $row .= '"'.$user['professionalism'].'",';
            $row .= '"'.$user['intention'].'",';
            $row .= '"'.$user['Ownership'].'",';
            $row .= '"'.$user['Contact'].'",';
            $row .= '"'.$user['Contact2'].'",';
            $row .= '"'.$user['Enthusiasm'].'",';
            $row .= '"'.$user['Security'].'",';
            $row .= '"'.$user['approver'].'",';
            $row .= '"'.$user['Action'].'",';
            $row .= '"'.$user['Documentation'].'",';
            $row .= '"'.$user['tagging'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
            $row .= '"'.$user['agnt_fd_acpt'].'",';
            $row .= '"'.$user['agent_rvw_date'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
            $row .= '"'.$user['mgnt_rvw_date'].'",';
            $row .= '"'.$user['mgnt_rvw_name'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
            $row .= '"'.$user['client_rvw_date'].'",';
            $row .= '"'.$user['client_rvw_name'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';

            fwrite($fopen,$row."\r\n");
        }
        fclose($fopen);
    }

    public function create_qa_avon_sms_CSV($rr){
        $currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
        $currentURL = base_url();
        $controller = "qa_avon";
        $edit_url = "add_edit_avon_sms";
        $main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$fopen = fopen($filename,"w+");

        $header=array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Supervisor", "Call Date", "Call Duration", "SMS Type", "Digital/Non Digital", "Week", "Audit Type", "Auditor Type", "VOC","Audit Link",
        "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score", "Standard Greeting", "Sentence Construction", "Professionalism", "Empathy",
        "Probing Questions (If Applicable)", "Comprehension", "Correct Disposition", "Avon Security", "FTR", "Incomplete Information Shared", "Inaccurate Information Shared", "Rudeness", "Remarks1",
        "Remarks2", "Remarks3", "Remarks4", "Remarks5", "Remarks6", "Remarks7", "Remarks8", "Remarks9", "Remarks10", "Remarks11", "Remarks12", "Call Summary", "Feedback", "Agent Feedback Acceptance",
        "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

        $row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

        foreach($rr as $user){
            $auditorName=($user['entry_by']!="")?$user['auditor_name']:$user['client_name'];
            if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
            $main_urls = $main_url.'/'.$user['id'];
            $row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['sms_type'].'",';
            $row .= '"'.$user['digital_non_digital'].'",';
			$row .= '"'.$user['week'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
            $row .= '"'.$main_urls.'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
            $row .= '"'.$user['earned_score'].'",';
            $row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
            $row .= '"'.$user['standard_greeting'].'",';
            $row .= '"'.$user['sentence_construction'].'",';
            $row .= '"'.$user['professionalism'].'",';
            $row .= '"'.$user['empathy'].'",';
            $row .= '"'.$user['probing_question_if_applicable'].'",';
            $row .= '"'.$user['comprehension'].'",';
            $row .= '"'.$user['correct_disposition'].'",';
            $row .= '"'.$user['avon_security'].'",';
            $row .= '"'.$user['first_call_resolution'].'",';
            $row .= '"'.$user['information_shared_incomplete'].'",';
            $row .= '"'.$user['information_shared_inaccurate'].'",';
            $row .= '"'.$user['rudeness'].'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';

            fwrite($fopen,$row."\r\n");
        }
        fclose($fopen);
    }

    public function create_qa_avon_outbound_CSV($rr){
        $currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
        $currentURL = base_url();
        $controller = "qa_avon";
        $edit_url = "add_edit_avon_outbound";
        $main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$fopen = fopen($filename,"w+");

        $header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Supervisor", "Call Date", "Call Duration", "Type of Call", "Digital/Non Digital", "Week", "Audit Type", "Auditor Type", "VOC", "Audit Link","Audit Start Date Time",
        "Audit End Date Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score", "Opening Spiel", "Disclaimer Spiel", "Avon Security", "Consent (If Applicable)", "Enthusiasm", "Hold Procedure", "Dead Air",
        "Listening Skills", "(Customer Service) Interruption", "(Customer Service) Polite Words/Professionalism", "(Customer Service) Empathy", "(Customer Service) Assurance", "(Customer Service) Personalization", "Ticket/Email Handling",
        "Incomplete Information Shared", "Inaccurate Information Shared", "Fisrt Call Resolution", "Disposition", "Closing Spiel", "Rudeness", "(Adherance to Recommended Spiels) Ghost Spiel",
        "(Adherance to Recommended Spiels) Bad Line Spiel", "(Adherance to Recommended Spiels) Profanity Spiel", "(Adherance to Recommended Spiels) Others", "Remarks1", "Remarks2", "Remarks3", "Remarks4", "Remarks5", "Remarks6", "Remarks7", "Remarks8",
        "Remarks9", "Remarks10", "Remarks11", "Remarks12", "Remarks13", "Remarks14", "Remarks15", "Remarks16", "Remarks17", "Remarks18", "Remarks19", "Remarks20", "Remarks21", "Remarks22", "Remarks23",
        "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name",
        "Client Review Note");

        $row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

        foreach($rr as $user){
            $auditorName=($user['entry_by']!="")?$user['auditor_name']:$user['client_name'];
            if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
            $main_urls = $main_url.'/'.$user['id'];
            $row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['call_type'].'",';
            $row .= '"'.$user['digital_non_digital'].'",';
			$row .= '"'.$user['week'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
            $row .= '"'.$main_urls.'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
            $row .= '"'.$user['earned_score'].'",';
            $row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['opening_spiel'].'",';
			$row .= '"'.$user['disclaimer_spiel'].'",';
			$row .= '"'.$user['avon_security'].'",';
			$row .= '"'.$user['consent_if_applicable'].'",';
			$row .= '"'.$user['enthusiasm'].'",';
			$row .= '"'.$user['hold_procedure'].'",';
			$row .= '"'.$user['dead_air'].'",';
			$row .= '"'.$user['listening_skills'].'",';
			$row .= '"'.$user['customer_service_interruption'].'",';
			$row .= '"'.$user['customer_service_polite_words'].'",';
			$row .= '"'.$user['customer_service_empathy'].'",';
            $row .= '"'.$user['customer_service_assurance'].'",';
            $row .= '"'.$user['customer_service_personalization'].'",';
            $row .= '"'.$user['ticket_email_handling_if_applicable'].'",';
            $row .= '"'.$user['information_shared_incomplete'].'",';
            $row .= '"'.$user['information_shared_inaccurate'].'",';
            $row .= '"'.$user['first_call_resolution'].'",';
            $row .= '"'.$user['disposition'].'",';
            $row .= '"'.$user['closing_spiel'].'",';
            $row .= '"'.$user['rudeness'].'",';
            $row .= '"'.$user['ghost_spiel'].'",';
            $row .= '"'.$user['bad_line_spiel'].'",';
            $row .= '"'.$user['profanity_spiel'].'",';
            $row .= '"'.$user['others'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
        }
        fclose($fopen);
    }

    public function create_qa_avon_inbound_CSV($rr){
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
        $currentURL = base_url();
        $controller = "qa_avon";
        $edit_url = "add_edit_avon_inbound";
        $main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Supervisor", "Call Date", "Call Duration", "Type of Call", "Digital/Non Digital", "Week", "Audit Type", "Auditor Type", "VOC","Audit Link", "Audit Start Date Time",
        "Audit End Date Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score", "Verbatim Opening", "Rate of speech", "Clarity and tone", "Assurance Statement","Appropriate Acknowledgement",
        "(Customer Service) Interruption", "(Customer Service) Polite Words/Professionalism", "(Customer Service) Personalization", "(Customer Service) Enthusiasm", "Hold Procedure", "Dead Air", "Probing Questions (If Applicable)",
        "Listening Skills", "Request Documents (If Applicable)", "Ticket/Email Handling (If Applicable)", "Incomplete Information Shared", "Inaccurate Information Shared", "First Call Resolution", "Disposition",
        "Additional Assistance", "Closing Spiel", "Avon Security (If Applicable)", "Late Opening", "Rudeness", "Ghost Spiel",
        "Bad Line Spiel", "Profanity Spiel", "Others", "Remarks1", "Remarks2", "Remarks3", "Remarks4", "Remarks5", "Remarks6", "Remarks7", "Remarks8", "Remarks9", "Remarks10", "Remarks11", "Remarks12", "Remarks13",
        "Remarks14", "Remarks15", "Remarks16", "Remarks17", "Remarks18", "Remarks19", "Remarks20", "Remarks21", "Remarks22", "Remarks23", "Remarks24", "Remarks25", "Remarks26", "Remarks27", "Remarks28", "Call Summary",
        "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user){
			if($user['entry_by']!=''){
				$auditorName = $user['auditor_name'];
			}else{
				$auditorName = $user['client_name'];
			}
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
            $main_urls = $main_url.'/'.$user['id'];
			
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['call_type'].'",';
            $row .= '"'.$user['digital_non_digital'].'",';
			$row .= '"'.$user['week'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
            $row .= '"'.$main_urls.'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
            $row .= '"'.$user['earned_score'].'",';
            $row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['opening_spiel_verbatim_opening'].'",';
            $row .= '"'.$user['opening_spiel_rate_of_speech'].'",';
            $row .= '"'.$user['opening_spiel_clarity_and_tone'].'",';
			$row .= '"'.$user['assurance_statement'].'",';
			$row .= '"'.$user['appropriate_acknowledgement'].'",';
			$row .= '"'.$user['customer_service_interruption'].'",';
			$row .= '"'.$user['customer_service_polite_words_professionalism'].'",';
			$row .= '"'.$user['customer_service_personalization'].'",';
			$row .= '"'.$user['customer_service_enthusiasm'].'",';
			$row .= '"'.$user['hold_procedure'].'",';
			$row .= '"'.$user['dead_air'].'",';
			$row .= '"'.$user['probing_question_if_applicable'].'",';
			$row .= '"'.$user['listening_skills'].'",';
            $row .= '"'.$user['request_documents_if_applicable'].'",';
            $row .= '"'.$user['ticket_email_handling_if_applicable'].'",';
            $row .= '"'.$user['information_shared_incomplete'].'",';
            $row .= '"'.$user['information_shared_inaccurate'].'",';
            $row .= '"'.$user['first_call_resolution'].'",';
            $row .= '"'.$user['disposition'].'",';
            $row .= '"'.$user['additional_assistance'].'",';
            $row .= '"'.$user['closing_spiel'].'",';
            $row .= '"'.$user['avon_security_if_applicable'].'",';
            $row .= '"'.$user['late_opening'].'",';
            $row .= '"'.$user['rudeness'].'",';
            $row .= '"'.$user['ghost_spiel'].'",';
            $row .= '"'.$user['bad_line_spiel'].'",';
            $row .= '"'.$user['profanity_spiel'].'",';
            $row .= '"'.$user['others'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
            $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);
		
	}

    public function download_qa_avon_CSV($campaign){
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Avon ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

    //Get Agent Details
    public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

    //Agent Function
    public function agent_avon_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_avon/agent_avon_feedback.php";
			$data["content_js"] = "qa_avon_js.php";
			$data["agentUrl"] = "qa_avon/agent_avon_feedback";
            $lob = $this->input->get( 'campaign' );
            
			if ( $lob != '' )       $cond_lob = " and lob='$lob'";
			//Fetch Total Feedback
            $total_feedback=0;
            
            if($lob!=''){
                $qSql_avon="Select count(id) as value from qa_avon_feedback where agent_id='$current_user' $cond_lob And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
             $total_feedback =$this->Common_model->get_single_value($qSql_avon);
            }
            

			// $qSql_inbound="Select count(id) as value from qa_avon_inbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
   //          $qSql_outbound="Select count(id) as value from qa_avon_outbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
   //          $qSql_email="Select count(id) as value from qa_avon_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
   //          $qSql_sms="Select count(id) as value from qa_avon_sms_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
   //          $qSql_ticket="Select count(id) as value from qa_avon_ticket_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";

            // $total_feedback+=$this->Common_model->get_single_value($qSql_inbound)+
            // $this->Common_model->get_single_value($qSql_outbound)+
            // $this->Common_model->get_single_value($qSql_email)+
            // $this->Common_model->get_single_value($qSql_sms)+
            // $this->Common_model->get_single_value($qSql_ticket);
			$data["tot_feedback"] =  $total_feedback;
			
			//Fetch Pending Review Count
            $total_yet_rvw=0;
            if($lob!=''){
                $qSql_avon_lobwise ="Select count(id) as value from qa_avon_feedback where agent_id='$current_user' $cond_lob And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
             $total_yet_rvw =$this->Common_model->get_single_value($qSql_avon_lobwise);
            }
            

            // $qSql_inbound="Select count(id) as value from qa_avon_inbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
            // $qSql_outbound="Select count(id) as value from qa_avon_outbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
            // $qSql_email="Select count(id) as value from qa_avon_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
            // $qSql_sms="Select count(id) as value from qa_avon_sms_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
            // $qSql_ticket="Select count(id) as value from qa_avon_ticket_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
            // $total_yet_rvw+=$this->Common_model->get_single_value($qSql_inbound)+
            // $this->Common_model->get_single_value($qSql_outbound)+
            // $this->Common_model->get_single_value($qSql_email)+
            // $this->Common_model->get_single_value($qSql_sms)+
            // $this->Common_model->get_single_value($qSql_ticket);            
			$data["yet_rvw"] =  $total_yet_rvw;
			
			$from_date = '';
			$to_date = '';
			$cond="";
			$campaign="";
			
			if($this->input->get('btnView')=='View'){
                $campaign=$this->input->get("campaign");
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";
                if ($campaign != '') $cond .= " and lob='$campaign'";

				$qSql = "SELECT * from
				(Select *, get_user_name(entry_by) as auditor_name, get_user_name(client_entryby) as client_name, get_user_name(tl_id) as tl_name, get_user_name(mgnt_rvw_by) as mgnt_rvw_name
                from qa_avon_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
			}else{
    //             if ( $lob != '' )       $cond = " and lob='$lob'";

				// $qSql="SELECT * from
				// (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			 // 	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			 // 	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			 // 	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_avon_feedback where agent_id='$current_user'  $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
			 // 	(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
			 // 	$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
                $data["agent_rvw_list"] = array();
			}
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}

    //Agent Review Page
    public function agent_avon_rvw($campaign, $id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			//$data["content_template"] = "qa_avon/agent_avon_".$campaign."_rvw.php";
            $data["content_template"] = "qa_avon/agent_avon_rvw.php";
			$data["content_js"] = "qa_avon_js.php";
			$data["agentUrl"] = "qa_avon/agent_avon_feedback";
			
            $table="qa_avon_feedback";

			$qSql="SELECT * from
				(Select *, get_user_name(entry_by) as auditor_name, get_user_name(client_entryby) as client_name, get_user_name(tl_id) as tl_name, get_user_name(mgnt_rvw_by) as mgnt_rvw_name
                from ".$table." where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["avon"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			if($this->input->post('pnid')){
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update($table,$field_array1);
					
				redirect('qa_avon/agent_avon_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
}
?>