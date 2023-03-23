<?php
class Qa_arvind  extends CI_Controller
{
   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Common_model');
        $this->load->model('Legal_executive_model');
      


    }

    public function createPath($path)
    {

        if (!empty($path)) {

            if (!file_exists($path)) {

                $mainPath = "./";
                $checkPath = str_replace($mainPath, '', $path);
                $checkPath = explode("/", $checkPath);
                $cnt = count($checkPath);
                for ($i = 0; $i < $cnt; $i++) {

                    $mainPath .= $checkPath[$i] . '/';
                    if (!file_exists($mainPath)) {
                        $oldmask = umask(0);
                        $mkdir = mkdir($mainPath, 0777);
                        umask($oldmask);

                        if ($mkdir) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            } else {
                return true;
            }
        }
    }


    private function arvind_upload_files($files, $path)   // this is for file uploaging purpose
    {
        $result = $this->createPath($path);
        if ($result) {
            $config['upload_path'] = $path;
            $config['allowed_types'] = '*';

            //  $config['allowed_types'] = 'avi|mp4|3gp|mpeg|mpg|mov|mp3|flv|wmv|mkv';
            $config['max_size'] = '2024000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $images = array();
            foreach ($files['name'] as $key => $image) {
                $_FILES['uFiles']['name'] = $files['name'][$key];
                $_FILES['uFiles']['type'] = $files['type'][$key];
                $_FILES['uFiles']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES['uFiles']['error'] = $files['error'][$key];
                $_FILES['uFiles']['size'] = $files['size'][$key];

                if ($this->upload->do_upload('uFiles')) {
                    $info = $this->upload->data();
                    $ext = $info['file_ext'];
                    $file_path = $info['file_path'];
                    $full_path = $info['full_path'];
                    $file_name = $info['file_name'];
                    if (strtolower($ext) == '.wav') {

                        $file_name = str_replace(".", "_", $file_name) . ".mp3";
                        $new_path = $file_path . $file_name;
                        $comdFile = FCPATH . "assets/script/wavtomp3.sh '$full_path' '$new_path'";
                        $output = shell_exec($comdFile);
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

    

        if (check_logged_in()) {
            $current_user = get_user_id();
            $data["aside_template"] = "qa/aside.php"; // no change on this sie bar
            $data["content_template"] = "qa_arvind/qa_arvind_feedback.php";
            $data["content_js"] = "qa_arvind_js.php";
          
            
			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,371) and status=1  order by name";
            $data["agentName"] = $this->Common_model->get_query_result_array($qSql); // this will display id, name,assigned_to,fusion_id
            
			$from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			
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
            
            if ($agent_id == '') // if no option is choosen
            {
                $cond = " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
            } elseif ($agent_id == 'All') {
                $cond = " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
            } else {
                $cond = " Where (audit_date >= '$from_date' and audit_date <= '$to_date' and agent_id='$agent_id')";
            }
            $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_arvind_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond  order by audit_date";
            $data["qa_arvind_admin"] = $this->Common_model->get_query_result_array($qSql);
            /////////////////////////////
            $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_arvind_email_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond  order by audit_date";
            $data["qa_arvind_email_admin"] = $this->Common_model->get_query_result_array($qSql);

            $data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
            $data["agent_id"] = $agent_id;

            $this->load->view("dashboard", $data);
        }
    }


    function agent_tenure()  // this will give name for giving id

    {
        
      $this->db->select("doj");
  
      $this->db->where("id", $agent_id);
  
      $result = $this->db->get("signin")->row_array();
  
      return $result;
  
    }







    public function edit_qa_arvind($ajio_id)  // working file sougata

    {
        if (check_logged_in()) {
            $_SESSION['id'] = $ajio_id;
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();
            $curDateTime = date('Y-m-d H:i');
         

            if (isset($_POST['mgnt_rvw_by']) && $_POST['note']) {
                $edit_array = $this->input->post('data');

              
  
                if ($_FILES['attach_file']['name'][0] != '') {
                    $a = $this->arvind_upload_files($_FILES['attach_file'], $path = './qa_files/qa_arvind/inbound/');
                    $edit_array["attach_file"] = implode(',', $a);
                } else if ($_FILES['attach_file']['name'][0] == "") {
                    $qSql = "SELECT attach_file from qa_arvind_feedback where id=$ajio_id";
                    $old_data = $this->Common_model->get_query_result_array($qSql);   
                }
                $edit_array["mgnt_rvw_by"] = $this->input->post('mgnt_rvw_by');
                $mgnt_rvw_note = $this->input->post('note');
                $mgnt_rvw_note = ucwords($mgnt_rvw_note);

                $edit_array["mgnt_rvw_note"] = $mgnt_rvw_note;

                $edit_array["mgnt_rvw_date"] = $curDateTime;
                $this->db->where('id', $ajio_id);
                $this->db->update('qa_arvind_feedback', $edit_array);
                redirect(base_url('qa_arvind'));
            } else {

                $current_user = get_user_id();

              

                $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,371) and status=1  order by name";
                $data["agentName"] = $this->Common_model->get_query_result_array($qSql); // this will display id, name,assigned_to,fusion_id
              
              
              
              
                $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1 ORDER BY fname";
              
              
              
              //  $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1 ORDER BY fname";
                
                
                
                
                
                $data['tlname'] = $this->Common_model->get_query_result_array($qSql);
                $qSql = " SELECT * from  (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
   (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
   (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
   (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_arvind_feedback where id='$ajio_id') xx Left Join
   (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
                $data["edit_arvind"] = $this->Common_model->get_query_result_array($qSql);
                $data["aside_template"] = "qa/aside.php";
                $data["content_template"] = "qa_arvind/edit_arvind.php"; 
                $data["content_js"] = "qa_arvind_js.php"; // js file for this page

                $this->load->view('dashboard', $data);
            }
        }
    }
    public function add_qa_arvind()  

    {
        if (check_logged_in()) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();
           
            $data["aside_template"] = "qa/aside.php"; 
            $data["content_template"] = "qa_arvind/curd_arvind.php"; 
            $data["content_js"] = "qa_arvind_js.php"; // js file for this page
            $tl_mgnt_cond = '';

            if (get_role_dir() == 'manager' && get_dept_folder() == 'operations') {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if (get_role_dir() == 'tl' && get_dept_folder() == 'operations') {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = "";
            }
            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,371) and status=1  order by name";
            $data["agentName"] = $this->Common_model->get_query_result_array($qSql);

            $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1 ORDER BY fname";
           
           
           
           // $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1 ORDER BY fname";
            $data['tlname'] = $this->Common_model->get_query_result_array($qSql);
            $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_arvind_feedback where id='1') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data["arvind_curd"] = $this->Common_model->get_query_row_array($qSql);

            $curDateTime = date('Y-m-d H:i');

          
            $a = array();
            $field_array['agent_id'] = !empty($_POST['data']['agent_id']) ? $_POST['data']['agent_id'] : "";
            if ($field_array['agent_id']) {
                    $field_array = $this->input->post('data');
                   
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mdydt2mysql($this->input->post('call_date'));
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post('audit_start_time');



                    $a = $this->arvind_upload_files($_FILES['attach_file'], $path = './qa_files/qa_arvind/inbound/');
                    $field_array["attach_file"] = implode(',', $a);

                  
                 

                    $rowid = data_inserter('qa_arvind_feedback', $field_array);
                    ///////////
                    if (get_login_type() == "client") {
                        $add_array = array("client_entryby" => $current_user);
                    } else {
                        $add_array = array("entry_by" => $current_user);
                    }
                    $this->db->where('id', $rowid);

                    $this->db->update('qa_arvind_feedback', $add_array);
                

                redirect('qa_arvind');
            }
            $data["array"] = $a;
            $this->load->view("dashboard", $data);
        }
    }

    public function add_edit_arvind_email($arvind_email_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_arvind/add_edit_arvind_email.php";
			$data['arvind_email_id']=$arvind_email_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,17) and is_assign_process(id,213)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, concat(fname, ' ', lname) as name, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1 order by name ASC";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_arvind_email_feedback where id='$arvind_email_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["arvind_email"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($arvind_email_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->arvind_upload_files($_FILES['attach_file'], $path='./qa_files/qa_arvind/arvind/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_arvind_email_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_arvind_email_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $arvind_email_id);
					$this->db->update('qa_arvind_email_feedback',$field_array1);
				/////////////
					if(get_login_type()=="client"){
						$edit_array = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $arvind_email_id);
					$this->db->update('qa_arvind_email_feedback',$edit_array);
					
				}
				redirect('qa_arvind/qa_arvind_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	} 


    /*------------------- Agent Part ---------------------*/

    public function agent_arvind_feedback()
    {
        if (check_logged_in()) {
            $user_site_id = get_user_site_id();
            $role_id = get_role_id();
            $current_user = get_user_id();
          
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_arvind/agent_arvind_feedback.php";
            $data["agentUrl"] = "qa_arvind/agent_arvind_feedback";

            $data["content_js"] = "qa_arvind_js.php"; // js file for this page



            $qSql = "Select count(id) as value from qa_arvind_feedback where agent_id='$current_user'  And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')   ";
            $data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);



            $qSql = "Select count(id) as value from qa_arvind_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') AND agent_rvw_date is Null";
            $data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

            $from_date = '';
            $to_date = '';
            $cond = "";
            $user = "";

            if ($this->input->get('btnView') == 'View') {
                $from_date = mmddyy2mysql($this->input->get('from_date'));
                $to_date = mmddyy2mysql($this->input->get('to_date'));

                if ($from_date != "" && $to_date !== "")  $cond = " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";

                if (get_role_dir() == 'agent') {
                    $user .= "where id ='$current_user'";
                }


                $qSql = "SELECT * from
(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_arvind_feedback  $cond And agent_id='$current_user'  And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
                $data["qa_arvind_agent"] = $this->Common_model->get_query_result_array($qSql);
            } else {

                $qSql = "SELECT * from
     (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
     (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
     (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
     (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_arvind_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
     (Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
                $data["qa_arvind_agent"] = $this->Common_model->get_query_result_array($qSql);
            }

            $data["from_date"] = $from_date;
            $data["to_date"] = $to_date;

            $this->load->view('dashboard', $data);
        }
    }

    public function agent_arvind_feedback_rvw($id)

    {
        if (check_logged_in()) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_arvind/agent_arvind_rvw.php";
            $data["agentUrl"] = "qa_arvind/agent_arvind_feedback";
            $data["content_js"] = "qa_arvind_js.php";
           
            //$data["campaign"] = $campaign;
            $data["pnid"] = $id;

            $qSql = "SELECT * from
           (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
           (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
           (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
           (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_arvind_feedback where id='$id') xx Left Join
           (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data["agent_arvind_rvw"] = $this->Common_model->get_query_row_array($qSql);

            if ($this->input->post('pnid')) {
                $pnid = $this->input->post('pnid');


                $curDateTime = date('Y-m-d H:i');
                $log = get_logs();

                $field_agent = array(
                    "agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
                    "agent_rvw_note" => ucwords($this->input->post('note')),
                    "agent_rvw_date" => $curDateTime
                );

            
                $this->db->where('id', $pnid);
                $this->db->update("qa_arvind_feedback", $field_agent);

                redirect('qa_arvind/agent_arvind_feedback');
            } else {
                $this->load->view('dashboard', $data);
            }
        }
    }




    public function getTLname(){
        if(check_logged_in()){
            $aid=$this->input->post('aid');
         
          $qSql = "Select id, assigned_to,doj, fusion_id, get_process_names(id) as process_name,  TIMESTAMPDIFF(DAY, doj, CURDATE()) AS agent_tenure,  office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where id ='$aid'    order by tl_name";
          
            echo json_encode($this->Common_model->get_query_result_array($qSql));
        }
    }







    /*------------------------------ Report Part ---------------------------*/


    public function qa_arvind_report() // working


    {
        if (check_logged_in()) {
            $user_office_id = get_user_office_id();
            $current_user = get_user_id();
            $is_global_access = get_global_access();
            $role_dir = get_role_dir();
            
            $data["show_download"] = false;
            $data["download_link"] = "";
            $data["show_table"] = false;
            $data["show_table"] = false;
            $data["aside_template"] = "reports_qa/aside.php";
            $data["content_template"] = "qa_arvind/qa_arvind_report.php";

            $data["content_js"] = "qa_arvind_js.php"; // js file for this page


            $data['location_list'] = $this->Common_model->get_office_location_list();

            $office_id = "";
            $date_from = "";
            $date_to = "";
            $action = "";
            $dn_link = "";
            $cond = "";
            $cond1 = "";
            if ($this->input->get('show') == 'Show') {
                $date_from = mmddyy2mysql($this->input->get('date_from'));
                $date_to = mmddyy2mysql($this->input->get('date_to'));
                $office_id = $this->input->get('office_id');

                if ($date_from != "" && $date_to !== "")  $cond = " Where (audit_date >= '$date_from' and audit_date <= '$date_to' )";

                if ($office_id == "All") $cond .= "";
                else $cond .= " and office_id='$office_id'";

                if (get_role_dir() == 'manager' && get_dept_folder() == 'operations') {
                    $cond1 .= " And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
                } else if ((get_role_dir() == 'tl' && get_user_fusion_id() != 'FMAN000616') && get_dept_folder() == 'operations') {
                    $cond1 .= " And assigned_to='$current_user'";
                } else {
                    $cond1 .= "";
                }
                $qSql = "SELECT * from
                   (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
                   (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
                   (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
                   (select d.description from department d left join signin sd on d.id=sd.dept_id where sd.id=entry_by) as auditor_dept,
                   (select r.name from role r left join signin sr on r.id=sr.role_id where sr.id=entry_by) as auditor_role,
                   (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
                   (select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_arvind_feedback) xx
                   Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
                $fullAray = $this->Common_model->get_query_result_array($qSql);

                $data["qa_arvind_list"] = $fullAray;
                $this->create_qa_arvind_CSV($fullAray);
                $dn_link = base_url() . "qa_arvind/download_qa_arvind_CSV";
            }
            $data['download_link'] = $dn_link;
            $data["action"] = $action;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;

            $this->load->view('dashboard', $data);
        }
    }



    public  function download_qa_arvind_CSV() // testing sougata
    {
        $currDate = date("Y-m-d");
        $filename = "./qa_files/qa_arvind/Report" . get_user_id() . ".csv";
        $newfile = "QA arvind  List-'" . $currDate . "'.csv";
        header('Content-Disposition: attachment;  filename="' . $newfile . '"');
        readfile($filename);
    }


    public function create_qa_arvind_CSV($rr)
    {
        $currDate = date("Y-m-d");
        $filename = FCPATH . "qa_files/qa_arvind/Report" . get_user_id() . ".csv";
        $fopen = fopen($filename, "w+");
        $header = array("Evaluator Name ", "Campaign  ", "Agent Disposition ","Actual Disposition", "Agent Tenure",    "Type of Audit", "Auditor Type", "VOC",  "Team Leader ",  "Earned Score", "Possible Score", "Overall Score", "Agent ID ", "Associate Name ", "Call date ",  "Customer Contact Number ", "Audit date "," Did the advisor Adherence to Opening Procedure","Reason of Did the advisor Adherence to Opening Procedure ","Did the advisor do the authentication before sharing any information ","Reason of Did the advisor do the authentication before sharing any information ","Did Advisor acknowledged the customer","Reason of Did Advisor acknowledged the customer ","Did the associate personalize on the call. ","Reason of Did the associate personalize on the call.","Active listening/Probing done on  the call to understand the concern of the customer/Alternative solution or information if required."," Reason of Active listening/Probing done on  the call to understand the concern of the customer/Alternative solution or information if required","Did the Advisor apology/empathy on the call ","Reason of Did the Advisor apology/empathy on the call","Did the Advisor sound Confident and enthusiastic","Reason of Did the Advisor sound Confident and enthusiastic ","Was the Advisor polite and professional.","Reason of Was the Advisor polite and professional.","Was the Rate of speech / Voice modulation accurate","Reason of Was the Rate of speech / Voice modulation accurate","Nofillers/Jargons/Interruption on call"," Reason of Nofillers/Jargons/Interruption on call","Did the advisor do any Grammatical & Sentence Construction mistake","Reason of Did the advisor do any Grammatical & Sentence Construction mistake","Was the advisor leading the call? (Based on opportunity)"," Reason of Was the advisor leading the call? (Based on opportunity)","Did the advisor take ownership on the call"," Reason of Did the advisor take ownership on the call","Did the agent adhere to dead air Protocol (more then 20 second)","Reason of Did the agent adhere to dead air Protocol (more then 20 second)","Did agent follow the Hold protocol","Reason of Did agent follow the Hold protocol","Did the advisor provide correct and complete information to the customer (including TAT)","Reason of Did the advisor provide correct and complete information to the customer (including TAT).","Did the agent handel the customers disagreement giving correct information","Reason of Did the agent handel the customers disagreement giving correct information","Did the advisor do correct tagging. ","Reason of Did the advisor do correct tagging","Did the agent mention complete correct notes and used the required trackers","Reason of Did the agent mention complete correct notes and used the required trackers.","Did the advisor guide the customer for self serve","Reason of Did the advisor guide the customer for self serve","Did the Advisor ask for further assistance","Reason of Did the Advisor ask for further assistance","Did the advisor follow the closing script.","Reason of Did the advisor follow the closing script.", "Audit Start date and  time EST","Audit end date and  time EST ", "  Interval in sec ",  "Call Observation ", "Feedback ", "Agent feedback status ", "Agent Review", "Agent review date Time EST ", "Management review date Time EST  ", "Management reviewer name ", "Management review note", "Client review name", "Client review note", "Client review date ");
        $row = "";
        foreach ($header as $data) $row .= '' . $data . ',';
        fwrite($fopen, rtrim($row, ",") . "\r\n");
        $searches = array("\r", "\n", "\r\n");
        foreach ($rr as $user) {
            if ($user['entry_by'] != '') {
                $auditorName = $user['auditor_name'];
            } else {
                $auditorName = $user['client_name'];
            }

            if ($user['audit_start_time'] == "" || $user['audit_start_time'] == '0000-00-00 00:00:00') {
                $interval1 = '---';
            } else {
                $interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
            }
            $row = '"' . $auditorName . '",';
            $row .= '"' . $user['campaign'] . '",';
            $row .= '"' . $user['agent_disposition'] . '",';
            $row .= '"' . $user['actual_disposition'] . '",';
            $row .= '"' . $user['agent_tenure'] . '",';
            $row .= '"' . $user['audit_type'] . '",';
            $row .= '"' . $user['auditor_type'] . '",';
            $row .= '"' . $user['voc'] . '",';
            $row .= '"' . $user['tl_name'] . '",';
           
            $row .= '"' . $user['earned_score'] . '",';
            $row .= '"' . $user['possible_score'] . '",';
            $row .= '"' . $user['overall_score'] . '",';
            $row .= '"' . $user['fusion_id'] . '",';
            $row .= '"' . $user['fname'] . " " . $user['lname'] . '",';
            $row .= '"' . $user['call_date'] . '",';
           
            $row .= '"' . $user['phone_no'] . '",';
            $row .= '"' . $user['audit_date'] . '",';
            $row .= '"' . $user['opening'] . '",';
            $row .= '"' . $user['opening_reason'] . '",';
            $row .= '"' . $user['authentication'] . '",';
            $row .= '"' . $user['authentication_reason'] . '",';
            $row .= '"' . $user['acknowledgement'] . '",';
            $row .= '"' . $user['acknowledgement_reason'] . '",';
            $row .= '"' . $user['associate'] . '",';
            $row .= '"' . $user['associate_reason'] . '",';
            $row .= '"' . $user['probing'] . '",';
            $row .= '"' . $user['probing_reason'] . '",';
            $row .= '"' . $user['apology'] . '",';
            $row .= '"' . $user['apology_reason'] . '",';
            $row .= '"' . $user['sound'] . '",';
            $row .= '"' . $user['sound_reason'] . '",';
            $row .= '"' . $user['polite'] . '",';
            $row .= '"' . $user['polite_reason'] . '",';
            $row .= '"' . $user['speech'] . '",';
            $row .= '"' . $user['speech_reason'] . '",';
            $row .= '"' . $user['notification'] . '",';
            $row .= '"' . $user['notification_reason'] . '",';
            $row .= '"' . $user['grammar'] . '",';
            $row .= '"' . $user['grammar_reason'] . '",';
            $row .= '"' . $user['advisor'] . '",';
            $row .= '"' . $user['advisor_reason'] . '",';
            $row .= '"' . $user['ownership'] . '",';
            $row .= '"' . $user['ownership_reason'] . '",';
            $row .= '"' . $user['deadair'] . '",';
            $row .= '"' . $user['deadair_reason'] . '",';
            $row .= '"' . $user['hold'] . '",';
            $row .= '"' . $user['hold_reason'] . '",';
            $row .= '"' . $user['information'] . '",';
            $row .= '"' . $user['information_reason'] . '",';
            $row .= '"' . $user['disagreement'] . '",';
            $row .= '"' . $user['disagreement_reason'] . '",';
            $row .= '"' . $user['tagging'] . '",';
            $row .= '"' . $user['tagging_reason'] . '",';
            $row .= '"' . $user['mention'] . '",';
            $row .= '"' . $user['mention_reason'] . '",';
            $row .= '"' . $user['guide'] . '",';
            $row .= '"' . $user['guide_reason'] . '",';
            $row .= '"' . $user['assistance'] . '",';
            $row .= '"' . $user['assistance_reason'] . '",';
            $row .= '"' . $user['close'] . '",';
            $row .= '"' . $user['close_reason'] . '",';
           

            $row .= '"' . $user['audit_start_time'] . '",';
            $row .= '"' . $user['entry_date'] . '",';
            $row .= '"' . $interval1 . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['call_summary'])) . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['feedback'])) . '",';
            $row .= '"' . $user['agnt_fd_acpt'] . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['agent_rvw_note'])) . '",';
            $row .= '"' . $user['agent_rvw_date'] . '",';
            $row .= '"' . $user['mgnt_rvw_date'] . '",';
            $row .= '"' . $user['mgnt_rvw_name'] . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['mgnt_rvw_note'])) . '",';
            $row .= '"' . $user['client_rvw_name'] . '",';
            $row .= '"' . str_replace('"', "'", str_replace($searches, "", $user['client_rvw_note'])) . '",';
            
            fwrite($fopen, $row . "\r\n");
        }
        fclose($fopen);
    }
}
