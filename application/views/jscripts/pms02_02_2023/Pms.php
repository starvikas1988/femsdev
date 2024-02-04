<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pms
        extends CI_Controller {

    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    private $aside = "pms/aside.php";

    function __construct() {
        parent::__construct();    

        $this->load->model('Profile_model');    
        $this->load->model('auth_model');  
        $this->load->model('Email_model');
        $this->load->model('Common_model');
        $this->load->model('pms_model');
        $this->load->model('pms_assigment_model');
    }

    private function check_access() {
        if (get_global_access() != '1' && get_dept_folder() != "hr" && get_role_dir() != "super")
            redirect(base_url() . "home", "refresh");
    }

    public function index() {
        if (check_logged_in()) {
            $user_site_id = get_user_site_id();
            $srole_id = get_role_id();
            $current_user = get_user_id();
            $location = get_user_office_id();
            $currLocalDate = GetLocalDate();
            $curLocalTime = GetLocalTime();
            $CurrMySqlDate = CurrMySqlDate();

            if (is_access_appraisal_module() == false)
                redirect(base_url() . "appraisal_employee/your_appraisal_letter", "refresh");

            $data["aside_template"] = $this->aside;
            $data["content_template"] = "appraisal_employee/index.php";
            $search = $this->input->get('search');
            $fusion_id = $this->input->get('fusion_id');
            if ($search == "Search") {
                $qSql = "SELECT CONCAT (s.fname,' ',s.lname) as fullname,o.office_name,wl.*,s.fusion_id,s.id,s.assigned_to,s.role_id,s.dept_id,CONCAT (l.fname,' ',l.lname) as l1_super,ro.name as role,get_process_names(s.id) as process_name,d.shname as department
					FROM signin as s
					left join info_payroll as wl on wl.user_id = s.id
					join office_location as o on s.office_id = o.abbr
					left join department as d on d.id = s.dept_id
					left join role as ro on ro.id = s.role_id
					left join signin as l on l.id = s.assigned_to
					WHERE s.fusion_id = '$fusion_id'";

                // exit;
                $data["details"]['present'] = $this->Common_model->get_query_result_array($qSql);

                $qSql = "SELECT CONCAT (s.fname,' ',s.lname) as fullname,o.office_name,wl.*,s.fusion_id,CONCAT (l.fname,' ',l.lname) as l1_super,ro.name as role,get_process_names(s.id) as process_name,d.shname as department
					FROM signin as s
					left join info_appraisal_letter as wl on wl.user_id = s.id
					join office_location as o on s.office_id = o.abbr
					left join department as d on d.id = wl.dept_id
					left join role as ro on ro.id = wl.role_id
					left join signin as l on l.id = wl.assigned_to
					WHERE s.fusion_id = '$fusion_id' and wl.type = 2";

                // exit;
                $data["details"]['history'] = $this->Common_model->get_query_result_array($qSql);

                $qSql = "SELECT CONCAT (s.fname,' ',s.lname) as fullname,s.id,fusion_id,office_id,(select shname from department d where d.id=s.dept_id) as dept_name
					FROM signin as s
					left join role as r on r.id = s.role_id where r.folder != 'agent' and s.status = 1";
                $data["tl_list"] = $this->Common_model->get_query_result_array($qSql);

                $qSql = "SELECT id,name, org_role FROM role where is_active=1 and id>0 ORDER BY name";
                $data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
                $data['role_organization'] = $this->Common_model->role_organization();

                $data['department_list'] = $this->Common_model->get_department_list();

                $sql_paytype = "SELECT * from master_payroll_type WHERE is_active = '1'";
                $data['paytype'] = $this->Common_model->get_query_result_array($sql_paytype);

                $sql_selected = "SELECT * from master_currency WHERE is_active = '1'";
                $data['mastercurrency'] = $this->Common_model->get_query_result_array($sql_selected);

                $data['fusion_id'] = $fusion_id;
                $data['searched'] = 'searched';
            }

            $data["content_js"] = "appraisal_js.php";
            $data["error"] = '';

            $this->load->view('dashboard', $data);
        }
    }

    public function add_group() {

        if (check_logged_in()) {
            $user_site_id = get_user_site_id();
            $srole_id = get_role_id();
            $current_user = get_user_id();
            $location = get_user_office_id();
            $currLocalDate = GetLocalDate();
            $curLocalTime = GetLocalTime();
            $CurrMySqlDate = CurrMySqlDate();

            if (is_access_appraisal_module() == false)
                redirect(base_url() . "appraisal_employee/your_appraisal_letter", "refresh");

            $data["aside_template"] = $this->aside;
            $data["content_template"] = "pms/index.php";
            $search = $this->input->get('search');
            $fusion_id = $this->input->get('fusion_id');

            $data["pms_group"] = $this->pms_model->pms_group_details();

            $data["content_js"] = "pms/pms_js.php";
            $data["error"] = '';
            $data["content_template"] = "pms/add_group.php";

            $this->load->view('dashboard', $data);
        }
    }

    public function pms_qs_set_by_hr() {
        // $this->load->model('Pms_assigment_model');
        $data["aside_template"] = $this->aside;
        $data["content_template"] = "pms/index.php";
        $data["content_js"] = "pms/pms_js.php";
        $data["error"] = '';
        // $data['company'] = $this->Pms_assigment_model->getAllDataWithWhere(MASTER_COMPANY);
        // $data['location'] = $this->Pms_assigment_model->getAllDataWithWhere(OFFICE_LOCATION, array("is_active" => '1'));
        // $data['department'] = $this->Pms_assigment_model->getAllDataWithWhere(DEPARTMENT, array("is_active" => '1'));	
        // echo "<pre>";
        // print_r($data['company']);die; 
        $data["content_template"] = "pms/pms_qs_set_list.php";

        $this->load->view('dashboard', $data);
    }

    public function fetch_pms_qs_set_list() {
        $start_index = $row = $this->input->post('start');
        $rowperpage = $this->input->post('length'); // Rows display per page
        $columnIndex = $this->input->post('order')[0]['column']; // Column index
        $columnName = $this->input->post('columns')[$columnIndex]['data']; // Column name
        $columnOrderable = $this->input->post('columns')[$columnIndex]['orderable']; // Column orderable or not
        $columnSortOrder = $this->input->post('order')[0]['dir']; // asc or desc
        $draw = $this->input->post('draw');

        $data = $this->pms_model->fetch_pms_qs_set_list($columnName, $columnSortOrder, $row, $rowperpage, $columnOrderable);
        $sql_record_count = $this->pms_model->fetch_pms_qs_set_list_count();

        $totalRecords = $sql_record_count[0]['allcount'];
        $sql_fildered_record_count = $this->pms_model->fetch_pms_qs_set_list_display_count();
        // $fildered_record_count = $this->Common_model->get_query_result_array($sql_fildered_record_count);
        $totalRecordwithFilter = $sql_fildered_record_count[0]['filter_allcount'];
        // echo $totalRecordwithFilter;die;


        $sl_no = $start_index;
        foreach ($data as $key => $row) {
            $sl_no++;
            $str_action1 = '';
            $str_action2 = '';
            $pid = $row['id'];
            $compatiency_group_id='1';
            $kra_group_id='2';

            $str_action1 = '<button title="Edit PMS" type="button" class="btn btn-success small-icon btn-xs" style="font-size:12px" onClick="editpmsForm('."'".$row['id']."'".');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
//            $str_action2 = '<button title="Edit PMS" type="button" class="btn btn-warning small-icon btn-xs" style="font-size:12px" onClick="editpmsForm('."'".$row['id']."'".','.$kra_group_id.');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
            $dataRow = array();
            $dataRow[] = ($sl_no);
            $dataRow[] = $row['pms_title'];
            $dataRow[] = $row['pms_rating'];
            $dataRow[] = date_format(date_create($row['start_date']),'d-m-Y');
            $dataRow[] = date_format(date_create($row['closing_date']),'d-m-Y');
            

            $dataRow[] = $str_action1;
//            $dataRow[] = $str_action2;
            $respArr[] = $dataRow;
        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $respArr
        );
        echo json_encode($response);
        exit;
    }
//fetch pms flow list code start here
public function fetch_pms_flow_list() {
    // echo "gfdgfdgfdg";die;
    $start_index = $row = $this->input->post('start');
    $rowperpage = $this->input->post('length'); // Rows display per page
    $columnIndex = $this->input->post('order')[0]['column']; // Column index
    $columnName = $this->input->post('columns')[$columnIndex]['data']; // Column name
    $columnOrderable = $this->input->post('columns')[$columnIndex]['orderable']; // Column orderable or not
    $columnSortOrder = $this->input->post('order')[0]['dir']; // asc or desc
    $draw = $this->input->post('draw');

    $data = $this->pms_model->fetch_pms_flow_list($columnName, $columnSortOrder, $row, $rowperpage, $columnOrderable);
    // print_r($data);die;
    $sql_record_count = $this->pms_model->fetch_pms_flow_count();

    $totalRecords = $sql_record_count[0]['allcount'];
    $sql_fildered_record_count = $this->pms_model->fetch_pms_flow_list_display_count();
    // $fildered_record_count = $this->Common_model->get_query_result_array($sql_fildered_record_count);
    $totalRecordwithFilter = $sql_fildered_record_count[0]['filter_allcount'];
    // echo $totalRecordwithFilter;die;


    $sl_no = $start_index;
    foreach ($data as $key => $row) {
        $sl_no++;
        $str_action1 = '';
        $str_action2 = '';
        $pid = $row['id'];

         $str_action1 = '<button title="Edit PMS" type="button" class="btn btn-warning small-icon btn-xs" style="font-size:12px" onClick="editpmsForm('."'".$row['id']."'".');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
        $dataRow = array();
        $dataRow[] = ($sl_no);
        $dataRow[] = $row['org_role'];
        $dataRow[] = $row['flow_order'];    

        // $dataRow[] = $str_action1;  
        $respArr[] = $dataRow;
    }
    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $respArr
    );
    echo json_encode($response);
}





//fetch pms flow list code end here









    public function config_set() {
        if (check_logged_in()) {
            $user_site_id = get_user_site_id();
            $srole_id = get_role_id();
            $current_user = get_user_id();
            $location = get_user_office_id();
            $currLocalDate = GetLocalDate();
            $curLocalTime = GetLocalTime();
            $CurrMySqlDate = CurrMySqlDate();
            $data["aside_template"] = $this->aside;
            $data["content_template"] = "pms/index.php";
            $data["pms_role_details"] = $this->pms_model->pms_role_details();
            // $data["location_details"] = $this->pms_model->pms_location_details();
            // print_r($data["pms_role_details"]);die;
            // FILTER EXTRA CHECK
            $locations = $this->input->post('location');
            $rating = $this->input->post('rating');

            $current_user = get_user_id();
            $data["current_user"] = $current_user;
            $btn = $this->input->POST('view_report');

            $data["content_js"] = "pms/pms_js.php";
            $data["error"] = '';
            // $data["content_template"] = "pms/add_edit_config.php";
            $data["content_template"] = "pms/config.php";

            $this->load->view('dashboard', $data);
        }
    }

    public function config_set1() {
        if (check_logged_in()) {
            $user_site_id = get_user_site_id();
            $srole_id = get_role_id();
            $current_user = get_user_id();
            $location = get_user_office_id();
            $currLocalDate = GetLocalDate();
            $curLocalTime = GetLocalTime();
            $CurrMySqlDate = CurrMySqlDate();
            $data["aside_template"] = $this->aside;
            $data["content_template"] = "pms/index.php";
          
            $locations = $this->input->post('location');
            $rating = $this->input->post('rating');

            $current_user = get_user_id();
            $data["current_user"] = $current_user;
            $btn = $this->input->POST('view_report');

            $data["content_js"] = "pms/pms_js.php";
            $data["error"] = '';
            // $data["content_template"] = "pms/add_edit_config.php";
            $data["content_template"] = "pms/config1.php";

            $this->load->view('dashboard', $data);
        }
    }


    public function add_config_set() {

        $location = $this->input->post('location');
        $rating = $this->input->post('rating');
        $pms_type = $this->input->post('pms_type');
        $pms_status = $this->input->post('pms_status');

        $data["current_user"] = $current_user;
        $btn = $this->input->POST('view_report');
        if ($btn != '') {
            foreach ($location as $value) {
                $date = date('Y-m-d H:i:s');
                $current_user = get_user_id();
                $logs = get_logs();

                $dataLogs = array(
                    "rating_status" => $rating,
                    "pms_type" => $pms_type,
                    "pms_enable_status" => $pms_status,
                    "office_id" => $value,
                    "created_by" => $current_user,
                    "created_date" => $date,
                    "log" => $logs
                );
                $data['config_list'] = $this->pms_model->pms_config_add($dataLogs);
            }
        }
        redirect(base_url() . "pms/config_set");
    }

    public function edit_config_set() {

        $edit_id = $this->input->post('edit_id');
        $location = $this->input->post('edit_location');

        $rating = $this->input->post('rating');
        $pms_type = $this->input->post('pms_type');
        $pms_status = $this->input->post('pms_status');

        // $data["current_user"] = $current_user;


        $date = date('Y-m-d H:i:s');
        $current_user = get_user_id();
        $logs = get_logs();

        $dataLogs = array(
            "rating_status" => $rating,
            "pms_type" => $pms_type,
            "pms_enable_status" => $pms_status,
            "office_id" => $location,
            "created_by" => $current_user,
            "created_date" => $date,
            "log" => $logs,
            "id" => $edit_id,
            "table_name" => 'pms_config'
        );
        $data['config_list'] = $this->pms_model->pms_config_update($dataLogs);

        redirect(base_url() . "pms/config_set");
    }

    public function config_setting_details() {

        if (check_logged_in()) {
            $config_id = trim($this->input->post('cid'));
            $resultDetails = array();
            if (!empty($config_id)) {
                $queryDetails = $this->pms_model->get_configs_ids($config_id);
                if (!empty($queryDetails)) {
                    $resultDetails = $queryDetails[0];
                    // $resultDetails['password'] = base64_decode($queryDetails[0]['password']);
                }
            }
            echo json_encode($resultDetails);
        }
    }

    public function fetch_pms_qs_get_config(){
        if (check_logged_in()) {
            $data = $this->pms_model->config_setting_list();
            //   print_r($data); die;
            // echo json_encode($data["subgroup_list"], JSON_UNESCAPED_SLASHES);
            echo json_encode($data);
        }
    }

    public function add_sub_group() {

        if (check_logged_in()) {
            $user_site_id = get_user_site_id();
            $srole_id = get_role_id();
            $current_user = get_user_id();
            $location = get_user_office_id();
            $currLocalDate = GetLocalDate();
            $curLocalTime = GetLocalTime();
            $CurrMySqlDate = CurrMySqlDate();

            if (is_access_appraisal_module() == false)
                redirect(base_url() . "appraisal_employee/your_appraisal_letter", "refresh");

            $data["aside_template"] = $this->aside;
            $data["content_template"] = "pms/index.php";
            $search = $this->input->get('search');
            $fusion_id = $this->input->get('fusion_id');
            $group_id='1';

            $data["pms_group"] = $this->pms_model->pms_group_details($group_id);
            $data["pms_sub_group"] = $this->pms_model->pms_sub_group_details();
            //  print_r($data['appraisal_sub_group']);die;



            $data["content_js"] = "pms/pms_js.php";
            $data["error"] = '';
            $data["content_template"] = "pms/add_sub_group.php";

            $this->load->view('dashboard', $data);
        }
    }

    public function add_group_name() {
        $current_user = get_user_id();
        $group_name = trim($this->input->post('group_name'));
        $date = date('Y-m-d H:i:s');
        $fetch_array = array(
            "group_name" => $group_name,
            "date" => $date,
            "current_user" => $current_user
        );
        $data['group_name'] = $this->pms_model->add_pms_group($fetch_array);
        echo $data['group_name'][0]['v_status'];
    }

    public function add_sub_group_name() {
        $current_user = get_user_id();
        $group_name = $this->input->post('group_name');
        $sub_group_name = trim($this->input->post('sub_group_name'));
        $date = date('Y-m-d H:i:s');
        $fetch_array = array(
            "group_name" => $group_name,
            "sub_group_name" => $sub_group_name,
            "date" => $date,
            "current_user" => $current_user
        );
        $data['group_name'] = $this->pms_model->add_pms_sub_group($fetch_array);
        echo $data['group_name'][0]['v_status'];
    }

    public function add_edit_config_setting_details(){
        $current_user = get_user_id();
        $post_status = trim($this->input->post('status'));
        $on_off = trim($this->input->post('on_off'));
        
        $id = trim($this->input->post('id'));
        $date = date('Y-m-d H:i:s');
        $logs = get_logs();

        // echo $post_status."---".$id;die;
        if($post_status=='pms_enable_status'){
            if($on_off=='OFF'){
                $status_val='1';
                $rating=$this->pms_assigment_model->getConfigRatingValus();
                 $data['pms_details_check'] = $this->pms_model->get_pms_details_check($rating->rating);
            }
            else{
                $status_val='2';
                $data['pms_details_edit'] = $this->pms_model->update_pms_edit_date();

            }
            $fetch_array = array(
                "pms_enable_status" =>$status_val,
                "date" => $date,
                "id"    =>$id,
                "current_user" => $current_user,
                "type"=>"pms_enable_status",
                "log"=>$logs,
                "table_name"=>PMS_CONFIG
            );
             $data['pms_status'] = $this->pms_model->add_edit_pms_config_details($fetch_array);
        }
        else if($post_status=='pms_appraisal_status'){
            if($on_off=='OFF'){
                $status_val='1';
            }
            else{
                $status_val='0';
            }
            $fetch_array = array(
                "pms_appraisal_status" =>$status_val,
                "date" => $date,
                "id"    =>$id,
                "current_user" => $current_user,
                "type"=>"pms_appraisal_status",
                "log"=>$logs,
                "table_name"=>PMS_CONFIG
            );
            $data['pms_status'] = $this->pms_model->add_edit_pms_config_details($fetch_array);

        }
       
        else if($post_status=='pms_reverse_appraisal_status'){
            if($on_off=='OFF'){
                $status_val='1';
            }
            else{
                $status_val='0';
            }
            $fetch_array = array(
                "pms_reverse_appraisal_status" =>$status_val,
                "date" => $date,
                "id"    =>$id,
                "current_user" => $current_user,
                "type"=>"pms_reverse_appraisal_status",
                "log"=>$logs,
                "table_name"=>PMS_CONFIG
            );
            $data['pms_status'] = $this->pms_model->add_edit_pms_config_details($fetch_array);

        }
        else if($post_status=='pms_edit_status'){
            if($on_off=='OFF'){
                $status_val='1';
            }
            else{
                $status_val='0';
            }
            $fetch_array = array(
                "pms_edit_status" =>$status_val,
                "date" => $date,
                "id"    =>$id,
                "current_user" => $current_user,
                "type"=>"pms_edit_status",
                "log"=>$logs,
                "table_name"=>PMS_CONFIG
            );
            $data['pms_status'] = $this->pms_model->add_edit_pms_config_details($fetch_array);

        }
        // echo "<pre>";
        // print_r($fetch_array); die;
       
        // $fetch_array = array(
            
        //     "date" => $date,
        //     "id"    =>$id,
        //     "current_user" => $current_user
        // );
       
        echo $data['pms_status'];
    }


    public function change_rating_value(){
        $current_user = get_user_id();
        $rating_value = trim($this->input->post('rating_val'));
        $rating_id = trim($this->input->post('change_rating_id'));
        $date = date('Y-m-d H:i:s');
        $logs = get_logs();

        // echo $post_status."---".$id;die;
       
            $fetch_array = array(
                "rating_id" =>$rating_value,
                "id"    =>$rating_id,
                "log"=>$logs,
                "table_name"=>PMS_CONFIG
            );
             $data['pms_rating_status'] = $this->pms_model->change_rating_status($fetch_array);
            echo $data['pms_rating_status'];
    }


    public function add_qs_set() {

        if (check_logged_in()) {
            $user_site_id = get_user_site_id();
            $srole_id = get_role_id();
            $current_user = get_user_id();
            $location = get_user_office_id();
            $currLocalDate = GetLocalDate();
            $curLocalTime = GetLocalTime();
            $CurrMySqlDate = CurrMySqlDate();

            if (is_access_appraisal_module() == false)
                redirect(base_url() . "appraisal_employee/your_appraisal_letter", "refresh");

            $data["aside_template"] = $this->aside;
            $data["content_template"] = "pms/index.php";
            $search = $this->input->get('search');
            $fusion_id = $this->input->get('fusion_id');
            $group_id='1';
            $data["pms_group"] = $this->pms_model->pms_group_details($group_id);
            $data["pms_sub_group"] = $this->pms_model->pms_sub_group_details();
            $data["pms_question_master"] = $this->pms_model->pms_question_details();

            // print_r($data["appraisal_question_master"]);die;


            $data["content_js"] = "pms/pms_js.php";
            $data["error"] = '';
            $data["content_template"] = "pms/add_qs_set.php";

            $this->load->view('dashboard', $data);
        }
    }

    public function add_qs_set_kra() {

        if (check_logged_in()) {
            $user_site_id = get_user_site_id();
            $srole_id = get_role_id();
            $current_user = get_user_id();
            $location = get_user_office_id();
            $currLocalDate = GetLocalDate();
            $curLocalTime = GetLocalTime();
            $CurrMySqlDate = CurrMySqlDate();

            if (is_access_appraisal_module() == false)
                redirect(base_url() . "appraisal_employee/your_appraisal_letter", "refresh");

            $data["aside_template"] = $this->aside;
            $data["content_template"] = "pms/index.php";
            $search = $this->input->get('search');
            $fusion_id = $this->input->get('fusion_id');
            $group_id='2';
            $data["pms_group"] = $this->pms_model->pms_group_details($group_id);
            $data["pms_sub_group"] = $this->pms_model->pms_sub_group_details();
            $data["pms_question_master"] = $this->pms_model->pms_kra_question_details();

            // print_r($data["appraisal_question_master"]);die;


            $data["content_js"] = "pms/pms_js.php";
            $data["error"] = '';
            $data["content_template"] = "pms/add_qs_set_for_kra.php";

            $this->load->view('dashboard', $data);
        }
    }

    public function fetch_subgroup_according_group() {

        $group_id = $this->input->post('group_id');
        // echo $group_id;die;
        $data = $this->pms_model->appraisal_subgroup_list($group_id);
        //  print_r($data); die;
        // echo json_encode($data["subgroup_list"], JSON_UNESCAPED_SLASHES);
        echo json_encode($data);
    }

    public function fetch_rating_details() {

        $data = $this->pms_model->pms_rating_list();
        //   print_r($data); die;
        // echo json_encode($data["subgroup_list"], JSON_UNESCAPED_SLASHES);
        echo json_encode($data);
    }





    public function add_qs_submit() {

        $qs_name = array_unique($this->input->post('qs_name'));
        $select_group = $this->input->post('select_group');
        $select_sub_group = $this->input->post('select_sub_group');
        //  print_r($qs_name);die;
        foreach ($qs_name as $value) {
            $date = date('Y-m-d H:i:s');
            $current_user = get_user_id();
            $logs = get_logs();

            $dataLogs = array(
                "group_id" => $select_group,
                "sub_group_id" => $select_sub_group,
                "question" => $value,
                "current_user" => $current_user,
                "created_date" => $date,
                "logs" => $logs
            );
            $data['question_add'] = $this->pms_model->add_question_submit($dataLogs);
        }
        // print_r($data['question_add']);die;

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function add_pms_flow_role_wise() {

        $select_role = array_unique($this->input->post('select_role'));
        $priority = $this->input->post('priority');
        foreach ($select_role as $key=>$value) {
       

            $date = date('Y-m-d H:i:s');
            $current_user = get_user_id();
            $logs = get_logs();

            $dataLogs = array(
                "org_role" => $value,
                "flow_order" => $priority[$key],
                "created_by" => $current_user,
                "created_date" => $date,
                "log" => $logs
            );
            $data['question_add'] = $this->pms_model->add_pms_flow($dataLogs);
        }
        // print_r($data['question_add']);die;

        redirect($_SERVER['HTTP_REFERER']);
    }





    public function pms_qs_set() {

        $qs_name = array_unique($this->input->post('qs_name'));
        $select_group = $this->input->post('select_group');
        $select_sub_group = $this->input->post('select_sub_group');
        //  print_r($qs_name);die;
        foreach ($qs_name as $value) {
            $date = date('Y-m-d H:i:s');
            $current_user = get_user_id();
            $logs = get_logs();

            $dataLogs = array(
                "group_id" => $select_group,
                "sub_group_id" => $select_sub_group,
                "question" => $value,
                "current_user" => $current_user,
                "created_date" => $date,
                "logs" => $logs
            );
            $data['question_add'] = $this->pms_model->pms_qs_set($dataLogs);
        }
        // print_r($data['question_add']);die;

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function your_appraisal_letter() {
        if (check_logged_in()) {
            $user_site_id = get_user_site_id();
            $srole_id = get_role_id();
            $current_user = get_user_id();
            $location = get_user_office_id();
            $currLocalDate = GetLocalDate();
            $curLocalTime = GetLocalTime();
            $CurrMySqlDate = CurrMySqlDate();

            $data["aside_template"] = $this->aside;
            $data["content_template"] = "appraisal_employee/your_appraisal_letter.php";
            $qSql = "SELECT CONCAT (s.fname,' ',s.lname) as fullname,CONCAT (a.fname,' ',a.lname) as added_by_name,o.office_name,wl.*,s.fusion_id,get_client_names(s.id) as client_name,CONCAT (l.fname,' ',l.lname) as l1_super,ro.name as role,get_process_names(s.id) as process_name,d.shname as department
				FROM info_payroll as wl
				left join info_appraisal_letter as iph on wl.user_id = iph.user_id
				left join signin as s on wl.user_id = s.id
				left join signin as a on a.id = wl.event_by
				join office_location as o on s.office_id = o.abbr
				left join department as d on d.id = s.dept_id
				left join role as ro on ro.id = s.role_id
				left join signin as l on l.id = s.assigned_to
				WHERE iph.user_id = '$current_user' group by affected_from order by id desc";

            // exit;
            $data["details"] = $this->Common_model->get_query_result_array($qSql);

            $data["content_js"] = "appraisal_js.php";
            $data["error"] = '';

            $this->load->view('dashboard', $data);
        }
    }

    public function save() {
        if (check_logged_in()) {
            // print_r($_POST); exit;
            $current_user = get_user_id();
            $added_date = CurrMySqlDate();
            $log = get_logs();

            $CurrMySqlDate = CurrMySqlDate();

            $u_id = $this->input->post('user_id');
            $aprsl_type = $this->input->post('aprsl_type');
            $issu_date = ddmmyy2mysql(trim($this->input->post('issu_date')));
            $role_id = $this->input->post('role_id');
            $dept_id = $this->input->post('dept_id');
            $gross_amount = $this->input->post('gross_amount');
            $pay_currency = $this->input->post('pay_currency');
            $pay_type = $this->input->post('pay_type');
            $assigned_to = $this->input->post('assigned_to');

            if ($u_id != "") {

                $field_array = array(
                    "user_id" => $u_id,
                    "affected_type" => $aprsl_type,
                    "affected_from" => $issu_date,
                    "payroll_type" => $this->input->post('pay_type'),
                    "payroll_status" => 1,
                    "gross_pay" => $this->input->post('gross_amount'),
                    "currency" => $this->input->post('pay_currency'),
                    "incentive_period" => $this->input->post('incentive_period'),
                    "incentive_amt" => $this->input->post('incentive_amt'),
                    "event_by" => $current_user,
                    "role_id" => $role_id,
                    "assigned_to" => $assigned_to,
                    "dept_id" => $dept_id,
                    "event_date" => $CurrMySqlDate,
                    "type" => 1,
                    "log" => $log
                );
                $this->db->insert('info_appraisal_letter', $field_array);

                if ($aprsl_type == 1 || $aprsl_type == 3) {

                    $qSql = "Select * from signin where id = '$u_id'";
                    $UserRow = $this->Common_model->get_query_row_array($qSql);
                    $old_role_id = $UserRow['role_id'];

                    if ($old_role_id != $role_id) {
                        $history_array = array(
                            "user_id" => $u_id,
                            "h_type" => 1,
                            "from_id" => $old_role_id,
                            "to_id" => $role_id,
                            "affected_date" => $issu_date,
                            "comments" => 'Promotion',
                            "event_date" => date('Y-m-d'),
                            "event_by" => $current_user,
                            "log" => $log,
                        );
                        $rowid = data_inserter('history_emp_all', $history_array);

                        $field_array = array(
                            "role_id" => $role_id
                        );
                        $this->db->where('id', $u_id);
                        $this->db->update('signin', $field_array);
                    }

                    $old_dept_id = $UserRow['dept_id'];

                    if ($old_dept_id != $dept_id) {

                        $history_array = array(
                            "user_id" => $u_id,
                            "h_type" => 3,
                            "from_id" => $old_dept_id,
                            "to_id" => $dept_id,
                            "affected_date" => $issu_date,
                            "comments" => 'Promotion',
                            "event_date" => date('Y-m-d'),
                            "event_by" => $current_user,
                            "log" => $log,
                        );
                        $rowid = data_inserter('history_emp_all', $history_array);

                        $field_array = array(
                            "dept_id" => $dept_id
                        );
                        $this->db->where('id', $u_id);
                        $this->db->update('signin', $field_array);
                    }

                    $old_assigned_to = $UserRow['assigned_to'];

                    if ($old_assigned_to != $assigned_to) {


                        $history_array = array(
                            "user_id" => $value->user_id,
                            "h_type" => 5,
                            "from_id" => $old_assigned_to,
                            "to_id" => $assigned_to,
                            "affected_date" => $issu_date,
                            "comments" => 'Promotion',
                            "event_date" => date('Y-m-d'),
                            "event_by" => $current_user,
                            "log" => $log,
                        );
                        $rowid = data_inserter('history_emp_all', $history_array);

                        $field_array = array(
                            "assigned_to" => $assigned_to
                        );
                        $this->db->where('id', $u_id);
                        $this->db->update('signin', $field_array);
                    }
                }

                $iSql = "Insert into info_payroll_history (user_id,affected_from,affected_to,affected_type,payroll_type,payroll_status,gross_pay,currency,incentive_period,incentive_amt,event_by,event_date,log) select '$u_id' as user_id, affected_from,'$issu_date' as affected_to,affected_type,payroll_type,payroll_status,gross_pay,currency,incentive_period,incentive_amt,event_by,'$CurrMySqlDate' as event_date,log from info_payroll where user_id = '$u_id'";
                $this->db->query($iSql);

                $field_array = array(
                    "user_id" => $u_id,
                    "affected_type" => $aprsl_type,
                    "affected_from" => $issu_date,
                    "payroll_type" => $this->input->post('pay_type'),
                    "payroll_status" => 1,
                    "gross_pay" => $this->input->post('gross_amount'),
                    "currency" => $this->input->post('pay_currency'),
                    "incentive_period" => $this->input->post('incentive_period'),
                    "incentive_amt" => $this->input->post('incentive_amt'),
                    "event_by" => $current_user,
                    "log" => $log
                );

                $this->db->where('user_id', $u_id);
                $this->db->update('info_payroll', $field_array);

                if ($this->db->affected_rows() > 0) {
                    // echo "string1";
                    $this->send_mail('', $u_id);
                } else {
                    // echo $u_id;
                    $response = array('error' => 'true');
                    echo json_encode($response);
                }
            } else {
                $response = array('error' => 'true');
                echo json_encode($response);
            }
        }
    }

    public function send_mail($view = "", $u_id = "", $appraised = "") {
        // print_r($_POST); exit;
        $CurrMySqlDate = CurrMySqlDate();
        $filename = '';
        $extraFilter = "";

        $SQLtxt = "select *,i.email_id_off as office_email,i.email_id_per as personal_email,d.shname as department_name, (select rank from role_organization ror where ror.id=signin.org_role_id)  as rank  from signin 
		left join info_personal as i on i.user_id = signin.id
		left join department as d on d.id = signin.dept_id
		left join info_payroll as pr on pr.user_id = signin.id
		left join info_appraisal_letter as ial on ial.user_id = signin.id
		where signin.id = '$u_id'  $extraFilter ORDER BY ial.id DESC";

        // exit;
        //echo $SQLtxt."<br/>";

        $data['individual_user'] = $crow = $this->Common_model->get_query_row_array($SQLtxt);

        if ($appraised == "Y") {
            $SQLtxt = "select *,ia.role_id,ia.dept_id,s.assigned_to,i.email_id_off as office_email,i.email_id_per as personal_email,d.shname as department_name, (select rank from role_organization ror where ror.id=s.org_role_id)  as rank from info_appraisal_letter as ia 
				left join info_personal as i on i.user_id = ia.user_id
				left join department as d on d.id = ia.dept_id
				left join signin as s on ia.user_id = s.id
				where ia.id = '$u_id'  $extraFilter  ORDER BY ia.id DESC ";
            // exit;
            //echo $SQLtxt."<br/>";

            $data['individual_user'] = $crow = $this->Common_model->get_query_row_array($SQLtxt);
        }

        $aprsl_type = $crow['affected_type'];
        // print_r($data['individual_user']);exit;

        if ($aprsl_type == 0)
            $aprsl_type = 2;

        $role_id = $data['individual_user']['role_id'];
        $brand = $data['individual_user']['brand'];

        $SQLtxt = "SELECT name FROM role WHERE id = '$role_id'";

        //echo $SQLtxt."<br/>"; 

        $data['role'] = $this->Common_model->get_query_row_array($SQLtxt);
        // print_r($data['role']);
        // exit;

        $fname = $crow['fname'];
        $lname = $crow['lname'];

        $event = 'appraisalEmployee';
        $office_id = $crow['office_id'];
        $site_id = $crow['site_id'];
        $brand = $crow['brand'];

        $res = get_notification_info($event, $brand, $site_id, $office_id);

        if (count($res) > 0) {
            $esubj = $res["email_subject"] . $fname . ' ' . $lname . ' ' . $crow['fusion_id'];
            $e_body = $res["email_body"];
            $from_email = $res["from_email"];
            $from_name = $res["from_name"];
            // $company_hr = $res['signature_text'];
            // $ecc = $res['cc_email_id'];
        }
        //$total_score = $crow['total_score'];
        if ($aprsl_type == 1) {
            $html = $this->load->view('appraisal_employee/promotion-letter', $data, true);
            $filename = 'Appraisal_letter_' . $fname . '_' . $lname . '_' . $crow['fusion_id'];
            // $ebody='Please find your attached Appraisal Letter';
            $esubj = 'Appraisal ' . $esubj;
        }
        if ($aprsl_type == 2) {
            $html = $this->load->view('appraisal_employee/revision-letter', $data, true);
            $filename = 'Revision_letter_' . $fname . '_' . $lname . '_' . $crow['fusion_id'];
            $esubj = 'Salary Revision ' . $esubj;
            $e_body = str_replace('Appraisal', 'Salary Revision', $e_body);
        }
        if ($aprsl_type == 3) {
            $html = $this->load->view('appraisal_employee/promotion-letter-no-ctc', $data, true);
            $filename = 'Promotion_letter_' . $fname . '_' . $lname . '_' . $crow['fusion_id'];
            // $ebody='Please find your attached Promotion Letter';
            $e_body = str_replace('Appraisal', 'Promotion', $e_body);
            $esubj = 'Promotion ' . $esubj;
        }



        if ($view != "Y") {
            $save = "Y";
            $l1_id = $crow['assigned_to'];

            $qSql = "SELECT email_id_off as value FROM `info_personal` WHERE user_id = '$l1_id';";
            $l1_email_off = $this->Common_model->get_single_value($qSql);

            $qSql = "SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='" . $l1_id . "');";
            $l2_email_off = $this->Common_model->get_single_value($qSql);

            $eto = array();
            $eto[] = $crow['personal_email'];
            $eto[] = $crow['office_email'];
            $ecc = array();
            $ecc[] = "employee.connect@fusionbposervices.com";
            $ecc[] = $l1_email_off;
            $ecc[] = $l2_email_off;
            if ($crow['brand'] == 3) {
                $ecc[] = "omindhr@omindtech.com";
            }
        }

        $attachment_path = $this->generate_pdf_files($html, $filename, $crow, 1, $save);

        // echo $attachment_path;
        // echo 'hello';
        // exit;
        if ($view != "Y") {
            sleep(1);
            if (file_exists($attachment_path)) {
                // echo "j"; exit;												
                $is_send = $this->Email_model->send_email_sox($u_id, implode(',', $eto), implode(',', $ecc), $e_body, $esubj, $attachment_path, $from_email, $from_name, '', $brand);

                // echo $is_send;
            }
            if ($is_send) {
                $response = array('error' => 'false');
                echo json_encode($response);
            } else {
                $response = array('error' => 'true');
                echo json_encode($response);
            }
        }
    }

    public function generate_pdf_files($html, $filename, $individual_user, $flags, $isSave) {

        //ob_start();  // start output buffering
        $this->load->library('m_pdf');
        $this->m_pdf->pdf = new mPDF('c');

        $hfArray = get_letter_header_footer($individual_user['office_id'], $individual_user['brand'], $individual_user['doj']);

        $header_html = $hfArray['header'];
        $header_footer = $hfArray['footer'];

        if ($flags == 1) {

            $this->m_pdf->pdf->SetHTMLHeader($header_html);
            $this->m_pdf->pdf->SetHTMLFooter($header_footer);
        }

        $filename = str_replace(' ', '_', $filename);

        $this->m_pdf->shrink_tables_to_fit;
        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
        $attachment_path = FCPATH . "temp_files/hr_letters/" . $filename . ".pdf";

        if ($isSave == "Y") {

            $this->m_pdf->pdf->Output($attachment_path, "F");

            //ob_clean();
            return $attachment_path;
        } else {
            //ob_clean();
            $this->m_pdf->pdf->Output($filename . ".pdf", "D");
        }
    }

    public function downloadCsv() {
        $filename = "./assets/reports/Report_appraisal_letter_" . get_user_id() . ".csv";
        $newfile = "report-appraisal-letter_" . get_user_id() . ".csv";
        header('Content-Disposition: attachment;  filename="' . $newfile . '"');
        readfile($filename);
    }

    public function create_raw_CSV($rr, $isDownload = false) {
        $filename = "./assets/reports/Report_appraisal_letter_" . get_user_id() . ".csv";

        $fopen = fopen($filename, "w+");

        $header = array("Fusion ID", "Name", "Dept", "Process", "Designation", "Location", "L1 Supervisor", "Affected From", "Gross Pay", "Appraisal Type", "Added By");

        $row = "";

        foreach ($header as $data)
            $row .= '' . $data . ',';

        fwrite($fopen, rtrim($row, ",") . "\r\n");

        //echo "<pre>";
        //print_r($rr);
        //echo "</pre>";

        foreach ($rr as $user) {
            if ($user['affected_type'] == "1") {
                $type = "Promotion";
            } elseif ($user['affected_type'] == "3") {
                $type = "Promotion With Same CTC";
            } else
                $type = "Revision";
            $row = "";
            $row .= '"' . $user['fusion_id'] . '",';
            $row .= '"' . $user['fullname'] . '",';
            $row .= '"' . $user['department'] . '",';
            $row .= '"' . $user['process_name'] . '",';
            $row .= '"' . $user['role'] . '",';
            $row .= '"' . $user['office_name'] . '",';
            $row .= '"' . $user['l1_super'] . '",';
            $row .= '"' . date('d-m-Y', strtotime($user['affected_from'])) . '",';
            $row .= '"' . $user['gross_pay'] . '",';
            $row .= '"' . $type . '",';
            $row .= '"' . $user['added_by_name'] . '",';

            fwrite($fopen, $row . "\r\n");
        }

        fclose($fopen);

        // if($isDownload==true){
        // 	ob_end_clean();
        // 	$newfile="report-warning-letter_".get_user_id().".csv";
        // 	header('Content-Disposition: attachment;  filename="'.$newfile.'"');
        // 	readfile($filename);
        // 	exit();
        // }
    }

}

?>