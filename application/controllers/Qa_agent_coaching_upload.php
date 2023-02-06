<?php

class Qa_agent_coaching_upload extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
       // $this->load->library('excel');
        $this->load->model('user_model');
        $this->load->model('Common_model');
        $this->load->model('Qa_agent_coaching_model');
        
       // $this->objPHPExcel = new PHPExcel();
    }

    public function getTLname(){
        if(check_logged_in()){
            $aid=$this->input->post('aid');
            $qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id, dept_id, (SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=signin.id)) as department_name FROM signin where id = '$aid'";
            echo json_encode($this->Common_model->get_query_result_array($qSql));
        }
    }

    private function mt_upload_files($files){
        $config['upload_path'] = './qa_files/qa_agent_coaching/';
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
            }else{
                return false;
            }
        }
        return $images;
    }

    function import_cdr_excel_data(){
        
        $this->load->library('excel');
        $current_user = '';
        $audit_time = time();
        $audit_time_each = date("Y-m-d", $audit_time);
        if(check_logged_in())
        {
            $current_user = get_user_id(); 
        }
        $value_client = 42;
        if(isset($_FILES["file"]["name"])){
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            // $clmarr = array("call_date_time","agent_id","call_date","process","fusion_id","nps_score","nps_comment","coaching_reason","session_id","category1","sub_Category","rca_level1","rca_level2","rca_level3","queue_name","tenurity","controllable_uncontrollable","rca_details","recommendation","entry_by","survey_date");

            $clmarr = array("Survey Date","Session ID","Category","Sub Category","Tenure Desc","Contact Center LTR","LTR Comments","MWP","Queue Name","Employee_Name");

            // $clmarr = array("Survey_ID","Responsedate","Survey_Program","Unique_Identifier","S_Date","Survey Date","Source_Survey","Incident_Id","Reference_Number","Contact_Id","Assigned_Id","Queue_Id","Queue_Name","Chat_Topic","Category","Sub Category","Session ID","Site_ID","Site_Name","Employee_ID","Employee_Name","Tenure Desc","Tenure_Days","Customer_ID","Phone","Email","Customer_Type","Order_Date","Order_Number","Carrier","Location","Distribution_Center","VWVendor_ID","VWVendor_Name","Ship_Date","Route_ID","Contact Center LTR","LTR Comments","Satisfaction_with_Agent","Resolve","Make_Easy","Number_of_contacts","Satisfaction_with_Order_Status","Satisfaction_with_Product_Availability","Satisfaction_with_Return_Process","Connect","Connect_Comments","Resolve_Comments","Make_Easy_Comments","Ship_By_Name","MWP");
            
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                
                $columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                $adjustedColumnIndex = $columnIndex + $adjustment;
                $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
            
                $dd = array();
                $user_list = array();
                
                for($col=0; $col<$adjustedColumnIndex; $col++){
                    $colindex = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
                    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($col);
                
                    foreach($clmarr as $name){
                        if($name == $colindex){
                             $dd[$colindex]  = $adjustedColumn;
                        }
                    }
                }
                
                //$random_row = round(($highestRow * (20/100)));                
                for($row=2; $row<=$highestRow; $row++){
                    foreach($dd as $key=>$d){
                        
                        if($key=="Survey Date"){
                            $user_list[$row]['call_date'] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
                        }
                        else if($key=="Session ID"){
                             
                            $user_list[$row]['call_id'] = $worksheet->getCell($d.$row )->getValue();
                        }
                        else if($key=="MWP"){
                            $fusion_id = $worksheet->getCell($d.$row )->getValue();
                             $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
                            
                            $tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

                            $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
                            $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

                            $user_list[$row]['agent_id']            =  $tl_agent_ids['agent_id'];
                            $user_list[$row]['tl_id']               =  $tl_agent_ids['tl_id'];
                            $user_list[$row]['entry_by']            =  $current_user;
                            $user_list[$row]['fusion_id']           = $worksheet->getCell($d.$row )->getValue();
                            $user_list[$row]['entry_date']          =  $audit_time_each;
                            $user_list[$row]['audit_date']          =  $audit_time_each;
                            //$user_list[$row]['audit_start_time']    =  $audit_start_time;
                            

                        }
                        else if($key=='Contact Center LTR'){
                            $user_list[$row]['nps_score']           = $worksheet->getCell($d.$row )->getValue();
                        }
                        else if($key=='LTR Comments'){
                            $user_list[$row]['nps_comment']           = $worksheet->getCell($d.$row )->getValue();
                        }
                        else if($key=='Category'){
                            $user_list[$row]['category1']           = $worksheet->getCell($d.$row )->getValue();
                        }
                        else if($key=='Sub Category'){
                            $user_list[$row]['sub_Category']           = $worksheet->getCell($d.$row )->getValue();
                        }
                        else if($key=='Queue Name'){
                            $user_list[$row]['queue_name']           = $worksheet->getCell($d.$row )->getValue();
                        }
                        else if($key=='Tenure Desc'){
                            $user_list[$row]['tenurity']           = $worksheet->getCell($d.$row )->getValue();
                        }
                        else{
                            $user_list[$row][$key] = $worksheet->getCell($d.$row )->getValue();
                        }
                    }   
                }
                
                $data_inserted_id =  $this->Qa_agent_coaching_model->agent_coaching_insert_excel($user_list);
                redirect('Qa_agent_coaching_upload/data_cdr_upload_freshdesk');
            }
        }
    }

    public function data_cdr_upload_freshdesk(){
        if(check_logged_in()){
            $current_user = get_user_id(); 
            $user_office = get_user_office_id(); 
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_agent_coaching/data_cdr_upload_freshdesk.php";
            $data["content_js"] = "qa_raw_upload_js.php";
            
            $qSql = "Select count(*) as count, date(audit_date) as uplDate from qa_coaching_raw_feedback WHERE audit_status= 0 group by date(audit_date)";
            $data["sampling"] = $this->Common_model->get_query_result_array($qSql);
            
            $this->load->view("dashboard",$data);
        }
    }

    public function qa_agent_upload_feedback(){
        if(check_logged_in()){
            $up_date = $this->input->get('up_date');

            $current_user = get_user_id(); 
            $user_office = get_user_office_id(); 
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_agent_coaching/qa_agent_upload_feedback.php";
            $data["content_js"] = "qa_raw_upload_js.php";

            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');

            // if($from_date==""){
            //     $from_date=CurrDate();
            // }else{
            //     $from_date = mmddyy2mysql($from_date);
            // }

            // if($to_date==""){
            //     $to_date=CurrDate();
            // }else{
            //     $to_date = mmddyy2mysql($to_date);
            // }

            if($from_date!='' && $to_date!=''){
                $from_date = mmddyy2mysql($from_date);
                $to_date = mmddyy2mysql($to_date);
            }

            $cond = '';
            $cond1 = '';
            if($from_date!="" && $to_date!==""){
                $cond1 .= "  and (audit_date >= '$from_date' and audit_date <= '$to_date')";
            }else{
                $cond1 .="";
            }

            
            if($up_date !=""){
               $cond= " and  (audit_date = '$up_date')";
            }  

            $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select fullname as name from client sc where sc.id=42) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_coaching_raw_feedback WHERE audit_status = 0 $cond $cond1) xx Left Join (Select id as sid,concat(fname, ' ', lname) as agent_name, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
            $data["agent_upload"] = $this->Common_model->get_query_result_array($qSql);
            //die();
            $data['from_date'] = $from_date;
            $data['to_date'] =  $to_date;
            $this->load->view("dashboard",$data);
        }
    }

    public function add_edit_agent_raw_upload($upload_agent_coaching_id=''){
        if(check_logged_in()){

            $current_user = get_user_id(); 
            $user_office = get_user_office_id(); 
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_agent_coaching/add_agent_raw_feedback.php";
            $data["content_js"] = "qa_raw_upload_js.php";
            $data['upload_agent_coaching_id']=$upload_agent_coaching_id;

            if($upload_agent_coaching_id !=""){
                $cond= " Where (id = '$upload_agent_coaching_id') ";
                $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select fullname as name from client sc where sc.id=42) as client_name,(select name as name from process ps where ps.id=process) as process_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_coaching_raw_feedback $cond) xx Left Join (Select id as sid,concat(fname, ' ', lname) as agent_name, fusion_id as emp_id, get_process_names(id) as campaign,DATEDIFF(CURDATE(), doj) as tenure,  assigned_to from signin) yy on (xx.agent_id=yy.sid)";
                $data["agent_upload_each"] = $this->Common_model->get_query_row_array($qSql);
            }else{
                $data["agent_upload_each"] = array();
            }  
            //(select s.id as tl_idd from signin s where s.id=tl_id) as tl_id
            

            $sql_process = "Select id,name from process where client_id =42 and is_active=1";
            $data["process_details"] = $this->Common_model->get_query_result_array($sql_process);
            
            $this->load->view("dashboard",$data);
        }
    }

    public function agent_coaching_list_feedback(){

        if(check_logged_in()){

            $current_user = get_user_id(); 
            $user_office = get_user_office_id(); 
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_agent_coaching/agent_coaching_list_feedback.php";
            $data["content_js"] = "qa_raw_upload_js.php";

            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');

            if($from_date==""){
                $from_date=CurrDate();
            }else{
                $from_date = mmddyy2mysql($from_date);
            }

            if($to_date==""){
                $to_date=CurrDate();
            }else{
                $to_date = mmddyy2mysql($to_date);
            }

            // if($from_date!='' && $to_date!=''){
            //     $from_date = mmddyy2mysql($from_date);
            //     $to_date = mmddyy2mysql($to_date);
            // }

            $cid = 42;
            // $qSqlAgent = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id,(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=signin.id)) as department_name FROM `signin` where role_id in (select id from role where folder ='agent') and is_assign_client (id,$cid)  and status=1  order by name";

            // $data['agent_name'] = $this->Common_model->get_query_result_array($qSqlAgent);

            // $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            // $data['tlname'] = $this->Common_model->get_query_result_array($qSql);

            $sql_process = "Select id,name from process where client_id =42 and is_active=1";
            $data["process_details"] = $this->Common_model->get_query_result_array($sql_process);
            $curDateTime=CurrMySqlDate();

            // if(get_global_access()=='1' || is_access_coach_module()==true){
            //     $cond .= '';
            // }else{
            //     $cond .= " where id in ($client_id)";
            // }

            $cond = '';
            if($from_date!="" && $to_date!==""){
                $cond .= "  WHERE (audit_date >= '$from_date' and audit_date <= '$to_date')";
            }else{
                $cond .="";
            }
 

            $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select fullname as name from client sc where sc.id=42) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name  from qa_agent_coaching_office_depot_feedback $cond ) xx Left Join (Select id as sid,concat(fname, ' ', lname) as agent_name, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
            $data["qa_coaching_data"] = $this->Common_model->get_query_result_array($qSql);
            //die();
            $data['from_date'] = $from_date;
            $data['to_date'] =  $to_date;
            $this->load->view("dashboard",$data);
        }
    }

    public function add_agent_coaching_feedback()
    {
        if(check_logged_in()){
            $client_id = get_client_ids();
            $current_user=get_user_id();
            $user_office_id=get_user_office_id();
           //$data["aside_template"] = "qa/aside.php";
           //$data["content_template"] = "qa_agent_coaching/qa_agent_upload_feedback.php";

            // $cond='';
            // if(get_global_access()=='1' || is_access_coach_module()==true){
            //    // $cond .= '';
            // }else{
            //    // $cond .= " where id in ($client_id)";
            // }
            // $qSql="SELECT * FROM client $cond";
            // $data['client']= $this->Common_model->get_query_result_array($qSql);

            // $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            // $data['tlname'] = $this->Common_model->get_query_result_array($qSql);

            $curDateTime=CurrMySqlDate();
            $a = array();
            // echo"<pre>";
            // print_r($_REQUEST);
            // echo"</pre>";
            // die();
            if($this->input->post('agent_id')){

                //$nps_comment= $this->input->post('nps_comment');
                // if(!empty($coaching_reason)){
                //     $coaching_reason=implode(",", $coaching_reason);
                // } mdydt2mysql($this->input->post('survey_date'))
                $survey_date = date('Y-m-d h:i:s',strtotime($this->input->post('survey_date')));
                $up_date = ($this->input->post('date_coaching'));
                $upload_raw_id = $this->input->post('upload_raw_id');
                $field_array=array(
                   // "audit_date" => CurrDate(),
                    "client_id" => $this->input->post('client_id'),
                    "process_id" => $this->input->post('process_id'),
                    "audit_type" => $this->input->post('audit_type'),
                    "auditor_type" => $this->input->post('auditor_type'),
                    "voc" => $this->input->post('voc'),
                    "audit_date" => mdydt2mysql($this->input->post('date_coaching')),
                    "callout_date" => mdydt2mysql($this->input->post('callout_date')),
                    "coaching_age" => $this->input->post('coaching_age'),
                    "tl_id" => $this->input->post('tl_id'),
                    "call_date" => $survey_date,
                    "category1" => $this->input->post('category1'),
                    "queue_name" => $this->input->post('queue_name'),
                    "sub_Category" => $this->input->post('sub_category'),
                    "session_id" => $this->input->post('session_id'),
                    "nps_comment" => $this->input->post('nps_comment'),
                    "agent_id" => $this->input->post('agent_id'),
                    "rca_level1" => $this->input->post('rcal1'),
                    "tenuarity" => $this->input->post('tenuarity'),
                    "rca_level2" => $this->input->post('rcal2'),
                    "nps_score" => $this->input->post('nps_score'),
                    "upload_raw_id" => $this->input->post('upload_raw_id'),
                    "fusion_id" => $this->input->post('fusion_id'),
                    "controllable_uncontrollable" => $this->input->post('controllable_uncontrollable'),
                    "month" => $this->input->post('month'),
                    "rca_details" => $this->input->post('rca_details'),
                    "recommendation" => $this->input->post('recommendation'),
                    "entry_by" => $current_user,
                    "entry_date" => $curDateTime,
                    "log"=> get_logs()
                );
                $a = $this->mt_upload_files($_FILES['attach_file']);
                if($a==""){
                    $field_array["attach_file"]="";
                }else{
                    $field_array["attach_file"] = implode(',',$a);
                }

                $field_array1 = array("audit_status"=>"1");
                if($upload_raw_id!=''){
                    $rowid= data_inserter('qa_agent_coaching_office_depot_feedback',$field_array);
                    $this->db->where('id', $upload_raw_id);
                    $this->db->update(' qa_coaching_raw_feedback',$field_array1);

                }
                // else{
                //     $rowid= data_inserter('qa_coaching_raw_feedback',$field_array);
                // }
                

               
               //redirect('Qa_agent_coaching_upload/qa_agent_upload_feedback?up_date='.$up_date);
               redirect('Qa_agent_coaching_upload/qa_agent_upload_feedback');
            /////////
                // $field_array1=array(
                //     "cf_id" => $rowid,
                //     "comment" => $this->input->post('coaching_comment'),
                //     "entry_by" => $current_user,
                //     "entry_date" => $curDateTime,
                //     'log'=> get_logs()
                // );
                // data_inserter('qa_coaching_mgnt_rvw',$field_array1);
                // redirect('Qa_agent_coaching');
            }
            // $data["array"] = $a;
            // $this->load->view("dashboard",$data);
        }
    }

    public function add_edit_mgnt_coaching()
    {
        if(check_logged_in()){
            $client_id = get_client_ids();
            $current_user=get_user_id();
            $user_office_id=get_user_office_id();
           //$data["aside_template"] = "qa/aside.php";
           //$data["content_template"] = "qa_agent_coaching/qa_agent_upload_feedback.php";

            // $cond='';
            // if(get_global_access()=='1' || is_access_coach_module()==true){
            //    // $cond .= '';
            // }else{
            //    // $cond .= " where id in ($client_id)";
            // }
            // $qSql="SELECT * FROM client $cond";
            // $data['client']= $this->Common_model->get_query_result_array($qSql);

            // $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            // $data['tlname'] = $this->Common_model->get_query_result_array($qSql);

            $curDateTime=CurrMySqlDate();
            $a = array();
            // echo"<pre>";
            // print_r($_REQUEST);
            // echo"</pre>";
            // die();
            if($this->input->post('agent_id')){

                //$nps_comment= $this->input->post('nps_comment');
                // if(!empty($coaching_reason)){
                //     $coaching_reason=implode(",", $coaching_reason);
                // } mdydt2mysql($this->input->post('survey_date')); mdydt2mysql($this->input->post('date_coaching'));

                $survey_date = date('Y-m-d h:i:s',strtotime($this->input->post('survey_date')));
                $callout_date = date('Y-m-d',strtotime($this->input->post('callout_date')));
                $audit_date = date('Y-m-d',strtotime($this->input->post('date_coaching')));
                $up_date = ($this->input->post('date_coaching'));
                $upload_raw_id = $this->input->post('upload_raw_id');
                $field_array=array(
                   // "audit_date" => CurrDate(),
                    "client_id" => $this->input->post('client_id'),
                    "process_id" => $this->input->post('process_id'),
                    "audit_type" => $this->input->post('audit_type'),
                    "auditor_type" => $this->input->post('auditor_type'),
                    "voc" => $this->input->post('voc'),
                    "audit_date" =>  $audit_date,
                    "callout_date" => $callout_date,
                    "coaching_age" => $this->input->post('coaching_age'),
                    "tl_id" => $this->input->post('tl_id'),
                    "call_date" => $survey_date,
                    "category1" => $this->input->post('category1'),
                    "queue_name" => $this->input->post('queue_name'),
                    "sub_Category" => $this->input->post('sub_category'),
                    "session_id" => $this->input->post('session_id'),
                    "nps_comment" => $this->input->post('nps_comment'),
                    "agent_id" => $this->input->post('agent_id'),
                    "rca_level1" => $this->input->post('rcal1'),
                    "tenuarity" => $this->input->post('tenuarity'),
                    "rca_level2" => $this->input->post('rcal2'),
                    "nps_score" => $this->input->post('nps_score'),
                    "fusion_id" => $this->input->post('fusion_id'),
                    "controllable_uncontrollable" => $this->input->post('controllable_uncontrollable'),
                    "month" => $this->input->post('month'),
                    "rca_details" => $this->input->post('rca_details'),
                    "recommendation" => $this->input->post('recommendation'),
                    "entry_by" => $current_user,
                    "entry_date" => $curDateTime,
                    "log"=> get_logs()
                );
                $a = $this->mt_upload_files($_FILES['attach_file']);
                if($a==""){
                    $field_array["attach_file"]="";
                }else{
                    $field_array["attach_file"] = implode(',',$a);
                }

                if($upload_raw_id!=''){
                    //$rowid= data_inserter('qa_agent_coaching_office_depot_feedback',$field_array);
                    $this->db->where('id', $upload_raw_id);
                    $this->db->update(' qa_agent_coaching_office_depot_feedback',$field_array);
                //////////
                    if(get_login_type()=="client"){
                        $field_array1 = array(
                            "client_rvw_by" => $current_user,
                            "client_rvw_note" => $this->input->post('note'),
                            "client_rvw_date" => $curDateTime
                        );
                    }else{
                        $field_array1 = array(
                            "mgnt_rvw_by" => $current_user,
                            "mgnt_rvw_note" => $this->input->post('note'),
                            "mgnt_rvw_date" => $curDateTime
                        );
                    }
                    $this->db->where('id', $upload_raw_id);
                    $this->db->update('qa_agent_coaching_office_depot_feedback',$field_array1);

                }
                // else{
                //     $rowid= data_inserter('qa_coaching_raw_feedback',$field_array);
                // }
                

               
               //redirect('Qa_agent_coaching_upload/qa_agent_upload_feedback?up_date='.$up_date);
               redirect('Qa_agent_coaching_upload/agent_coaching_list_feedback');
            /////////
                // $field_array1=array(
                //     "cf_id" => $rowid,
                //     "comment" => $this->input->post('coaching_comment'),
                //     "entry_by" => $current_user,
                //     "entry_date" => $curDateTime,
                //     'log'=> get_logs()
                // );
                // data_inserter('qa_coaching_mgnt_rvw',$field_array1);
                // redirect('Qa_agent_coaching');
            }
            // $data["array"] = $a;
            // $this->load->view("dashboard",$data);
        }
    }

    public function add_agent_coaching(){
        if(check_logged_in()){

            $current_user = get_user_id(); 
            $user_office = get_user_office_id(); 
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_agent_coaching/add_agent_coaching.php";
            $data["content_js"] = "qa_raw_upload_js.php";
           // $data['upload_agent_coaching_id']=$upload_agent_coaching_id;

          
            $cond='';
            if(get_global_access()=='1' || is_access_coach_module()==true){
                $cond .= '';
            }else{
                $cond .= " where id in ($client_id)";
            }
            $qSql="SELECT * FROM client $cond";
            $data['client']= $this->Common_model->get_query_result_array($qSql);

            $cid = 42;
            $qSqlAgent = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id,(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=signin.id)) as department_name FROM `signin` where role_id in (select id from role where folder ='agent') and is_assign_client (id,$cid)  and status=1  order by name";

            $data['agent_name'] = $this->Common_model->get_query_result_array($qSqlAgent);

            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
            $data['tlname'] = $this->Common_model->get_query_result_array($qSql);

            $curDateTime=CurrMySqlDate();
            $a = array();
            $agent_id = $this->input->post('agent_id');
            if($this->input->post('agent_id')){

                $up_date = $curDateTime;
                $qSql_agent = "Select fusion_id  FROM signin where id = '$agent_id'";
                $fusion_id_data = $this->Common_model->get_query_row_array($qSql_agent);
               // print_r($fusion_id_data);
                //$upload_raw_id = $this->input->post('upload_raw_id');
                $field_array=array(
                    //"audit_date" => CurrDate(),
                    "client_id" => $this->input->post('client_id'),
                    "process_id" => $this->input->post('process_id'),
                    "fusion_id" => $this->input->post('fusion_id'),
                    "audit_type" => $this->input->post('audit_type'),
                    "voc" => $this->input->post('voc'),
                    "fusion_id" => $this->input->post('fusion_id'),
                    "audit_date" => mdydt2mysql($this->input->post('date_coaching')),
                    "callout_date" => mdydt2mysql($this->input->post('callout_date')),
                    "coaching_age" => $this->input->post('coaching_age'),
                    "tl_id" => $this->input->post('tl_id'),
                    "call_date" => mdydt2mysql($this->input->post('survey_date')),
                    "audit_start_time" => $this->input->post('audit_start_time'),
                    "category1" => $this->input->post('category1'),
                    "queue_name" => $this->input->post('queue_name'),
                    "sub_Category" => $this->input->post('sub_category'),
                    "session_id" => $this->input->post('session_id'),
                    "nps_comment" => $this->input->post('nps_comment'),
                    "agent_id" => $this->input->post('agent_id'),
                    "rca_level1" => $this->input->post('rcal1'),
                    "tenuarity" => $this->input->post('tenuarity'),
                    "rca_level2" => $this->input->post('rcal2'),
                    "nps_score" => $this->input->post('nps_score'),
                    "controllable_uncontrollable" => $this->input->post('controllable_uncontrollable'),
                    "month" => $this->input->post('month'),
                    "rca_details" => $this->input->post('rca_details'),
                    "recommendation" => $this->input->post('recommendation'),
                    "entry_by" => $current_user,
                    "entry_date" => $curDateTime,
                    "log"=> get_logs()
                );
                $a = $this->mt_upload_files($_FILES['attach_file']);
                if($a==""){
                    $field_array["attach_file"]="";
                }else{
                    $field_array["attach_file"] = implode(',',$a);
                }

                 $rowid= data_inserter('qa_agent_coaching_office_depot_feedback',$field_array);
                 redirect('Qa_agent_coaching_upload/agent_coaching_list_feedback');
            }
            

            $sql_process = "Select id,name from process where client_id =42 and is_active=1";
            $data["process_details"] = $this->Common_model->get_query_result_array($sql_process);
            
            $this->load->view("dashboard",$data);


        }
    }

    public function mgnt_coaching_feedback_rvw($coaching_id=''){
        if(check_logged_in()){

            $current_user = get_user_id(); 
            $user_office = get_user_office_id(); 
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_agent_coaching/mgnt_coaching_feedback_rvw.php";
            $data["content_js"] = "qa_raw_upload_js.php";
            $data['coaching_id']=$coaching_id;

            if($coaching_id !=""){
                $cond= " Where (id = '$coaching_id') ";
                $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select fullname as name from client sc where sc.id=42) as client_name,(select name as name from process ps where ps.id=process_id) as process_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_agent_coaching_office_depot_feedback $cond) xx Left Join (Select id as sid,concat(fname, ' ', lname) as agent_name, fusion_id as emp_id, get_process_names(id) as campaign,DATEDIFF(CURDATE(), doj) as tenure,  assigned_to from signin) yy on (xx.agent_id=yy.sid)";
                $data["agent_data_each"] = $this->Common_model->get_query_row_array($qSql);
            }else{
                $data["agent_data_each"] = array();
            }  
            //(select s.id as tl_idd from signin s where s.id=tl_id) as tl_id
            

            $sql_process = "Select id,name from process where client_id =42 and is_active=1";
            $data["process_details"] = $this->Common_model->get_query_result_array($sql_process);
            
            $this->load->view("dashboard",$data);
        }
    }

    public function sample_cdr_download(){
        if(check_logged_in()){ 
             $file_name = base_url()."application/views/qa_agent_coaching/agent_coaching_upload.xlsx";
            header("location:".$file_name); 
            exit();
        }
    }

    public function getCoachingAge(){
        if(check_logged_in()){
             $callout_date = $this->input->post('callout_date');
             $callout_date = mmddyy2mysql($callout_date);
             $audit_date   = $this->input->post('audit_date');
            
            $endDate = strtotime($callout_date);
            $startDate = strtotime($audit_date);


        //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
        //We add one to inlude both dates in the interval.
        $days = ($endDate - $startDate) / 86400 + 1;

        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);

        //It will return 1 if it's Monday,.. ,7 for Sunday
        $the_first_day_of_week = date("N", $startDate);
        $the_last_day_of_week = date("N", $endDate);

        //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
        //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
        if ($the_first_day_of_week <= $the_last_day_of_week) {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
        }
        else {
            // (edit by Tokes to fix an edge case where the start day was a Sunday
            // and the end day was NOT a Saturday)

            // the day of the week for start is later than the day of the week for end
            if ($the_first_day_of_week == 7) {
                // if the start date is a Sunday, then we definitely subtract 1 day
                $no_remaining_days--;

                if ($the_last_day_of_week == 6) {
                    // if the end date is a Saturday, then we subtract another day
                    $no_remaining_days--;
                }
            }
            else {
                // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
                // so we skip an entire weekend and subtract 2 days
                $no_remaining_days -= 2;
            }
        }

        //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
        //---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
       $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0 )
        {
          $workingDays += $no_remaining_days;
        }

        //We subtract the holidays
        // foreach($holidays as $holiday){
        //     $time_stamp=strtotime($holiday);
        //     //If the holiday doesn't fall in weekend
        //     if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
        //         $workingDays--;
        // }
            echo json_encode($workingDays);
        }
    }

}
?>